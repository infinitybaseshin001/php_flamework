<?php
/****************************************************/
/*ファイル名 : sqlQueryForm.php
/*概要   : SQLデバッグページ
/*引数   : なし
/*返却値 : なし
/*作成者 : 村上　慎一郎
/*作成日 : 2011/05/19
/*更新日、更新者、更新内容:
/****************************************************/
?>
<? require_once('../../CONF/ini.inc.php');?>
<? require_once(MODEL_COMMON."\mdb2PEAR.class.php");?>
<? mysql_connect('localhost', 'root', '');?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>
<?
if($_REQUEST[SQL] != ""){
    print $_REQUEST[SQL];
    
} else {
    print "DB=".$_REQUEST[DB];
    
    if($_REQUEST[TB] != ""){
        print "&TB=".$_REQUEST[TB];
        
    }
}
?>
</title>
</head>
<body bgcolor = "#FFFFFF" text = "#000000" link = "#9933FF" vlink = "#9933FF" alink = "#FFCCFF">
<style type = "text/css">
<!--
a:link,a:visited,a:active,a:hover {
    FONT-family: "ＭＳ Ｐゴシック";
    text-decoration: none;
    color: #000000;/**/
}
/*input,textarea,select {
	background-color: #000000;
	border-top: medium groove #666666;
	border-right: thin groove #CCCCCC;
	border-bottom: thin ridge #CCCCCC;
	border-left: medium groove #666666;
	font-size: 12px;
	color: #c0c0c0;
	font-family: "MS ゴシック";
}*/
tr {
    background-color: #FFFFFF;
}
-->
</style>
<?
function getmicrotime(){
    list($msec, $sec) = explode(" ", microtime());
    return ((float)$sec + (float)$msec);
    
}
?>
<form method = "REQUEST" action = "<?=$_SERVER["PHP_SELF"]?>" name = "ff" onSubmit = "return sss();">
    <input type = "text" name = "DB" size = "15" value = "<?=$_REQUEST["DB"]?>">
    <input type = "text" name = "TB" size = "15" value = "<?=$_REQUEST["TB"]?>">
    <input type = "text" name = "FD" size = "8" id = "FD" onkeypress='setTimeout("aiueo()",100)' style="display:none" value="NO">
    <input type = "text" name = "TB2" size = "8" id = "TB2" onkeypress='setTimeout("aiueo()",100)' style="display:none" value="NO">
    <input type = "submit" value = "送信" name = "submit">
    <select name = "select" onChange="aiueo();">
        <option>　</option>
	<option value = "kensaku">検索</option>
	<option value = "kensaku2">検索like</option>
	<option value = "kensaku3">検索FIND_IN_SET</option>
	<option value = "kensaku4">検索CASE~WHEN THEN~END</option>
	<option value = "zokusei">フィールドの属性表示</option>
	<option value = "count">フィールドの項目数表示</option>
	<option value = "datalist">フィールドの種類表示</option>
	<option value = "timelist">フィールドの種類表示(時間別)</option>
	<option value = "index">フィールドのインデックス表示</option>
	<option value = "showCreate">テーブルのCREATE文表示</option>
	<option value = "showDatabase">データベース情報表示</option>
	<option value = "process">プロセスリスト表示</option>
	<option value = "gousei">テーブルの合成元</option>
	<option value = "gousei2">テーブルの付加表示</option>
	<option value = "gousei3">新規ウィンドウ</option>
	<option value = "jyun">数の小さい順,大きい順(最後にdesc)</option>
	<option value = "Yupdate" class="bbb">update テーブル set 式 where 条件</option>
	<option value = "Ydrop">delete from テーブル where 条件</option>
	<option value = "Yadd">insert into テーブル(フィールド) values (値)</option>
	<option value = "Tadd">alter table テーブル add 新規フィールド after フィールド</option>
	<option value = "Tdrop" class="momo">alter table テーブル drop column フィールド</option>
	<option value = "Tchange">alter table テーブル change フィールド 新規フィールド定義</option>
	<option value = "TBadd">create table 新規テーブル()</option>
	<option value = "TBcopy">create table 新規テーブル as select * from テーブル</option>
	<option value = "TBdrop" class="momo">drop table テーブル</option>
	<option value = "TBrename" class="momo">alter table テーブル rename 変更名</option>
	<option value = "DBadd">create database 新規データベース</option>
	<option value = "DBdrop" class="momo">drop database データベース</option>
	<option value = "keisan">合計,平均,標準偏差(それぞれはgroup by</option>
	<option value = "unique">ユニークインデックスを追加(uniqueでない場合はindex</option><? /*条件unique値はadd インデックス名(NO,tokuten)*/?>
	<option value = "PRIdrop">主キーの削除</option>
	<option value = "INDEXdrop">インデックスの削除</option>
	<option value = "hensati">偏差値</option>
    </select>
    <span id = "oo""></span>
    <input type = "radio" id = "single" name = "radiobutton" value = "single" onClick="ttt()" checked>
    <label for = "single">s</label>
    <input type = "radio" id = "multi" name = "radiobutton" value = "multi" onClick="ttt()">
    <label for = "multi">m</label><BR>

<span id = "ttt"><input type = "text" name = "SQL" size = "150"></span>
</form>
<?
//バグ修正のため$_REQUESTで取得、また"'が\"\'になってしまうため取り除く,負荷かけないようにlimitつける
$sql = $_REQUEST["SQL"];
$insert = 0;
if(($_REQUEST["DB"] == "") && ($_REQUEST["TB"] == "") && ($_REQUEST["SQL"] == "")){
    $sql = "show databases";//自動
    
} elseif(($_REQUEST["TB"] == "") && ($_REQUEST["SQL"] == "")){
    $sql = "show tables";//自動
    
} elseif($_REQUEST["SQL"] == ""){
    $sql = "select * from ".$_REQUEST["TB"]." limit 0,10";
    $insert = 1;//自動
    
}

mysql_select_db('mvc_framework');
$sql = str_replace("\\", "", $sql);//\"\'になってしまうため取り除く

$startTime = getmicrotime();
mysql_query("SET @aiueo:=0");
mysql_query("SET @kaki:=0");
mysql_query("SET @sasi:=0");
$arrayRtn = mysql_query($sql);//"select * from ecproducts;"
$endTime = getmicrotime();
print(round($endTime - $startTime, 5)."sec<BR>");
$mdb2 = new mdb2ex();
print($mdb2->sqlColor($sql));

if( $arrayRtn == FALSE ){
    print("<BR>\n".mysql_error());
    die("<script>function sss(){}</script>");
    
} else;

$body .= "<table border = 0 cellspacing = 1 bgcolor = #9cb8f8>";
$body .= "<TR class=ao>\n";

$arrayField = mysql_num_fields($arrayRtn);

for($i = 0; $i < $arrayField; $i += 1){
    $body .= "<TD align=left valign=top>" ."<a href=\"\" onclick='document.ff.FD.value=\"".mysql_field_name($arrayRtn,$i)."\";setTimeout(\"aiueo()\",100);return false;'>".mysql_field_name($arrayRtn,$i)."</a>"."</TD>\n";
    
}

$body .= "</TR>\n";

$iii = 0;

while($array = mysql_fetch_assoc($arrayRtn)){
    $iii+=1;

    if($iii > 100){
        break;
    
    }

    $body .= "<TR>\n";

    foreach($array as $key => $val){//$array[$key]=$val
        if($key=="NO"){
            $body .= "<TD align=left valign=top class=ao>";
		
        } else {
            $body .= "<TD align=left valign=top>";
            
        }
	
        if((($_REQUEST["DB"] == "") || ($_REQUEST["TB"] == "")) && ($_GET["SQL"] == "")){
            $body .="<a href=" .$_SERVER["PHP_SELF"]."?DB=".($_REQUEST["DB"]==""||!isset($_REQUEST["DB"])?$val:$_REQUEST["DB"])."&TB=".($_REQUEST["DB"]!=""&&isset($_REQUEST["DB"])&&$_REQUEST["TB"]==""?$val:$_REQUEST["TB"])."&SQL=".">";
            $body .= htmlspecialchars($val);//$body .= htmlentities($val, 3, 'SJIS');
            $body .="</a>";
		
        } else {
            $body .= htmlspecialchars($val);
	
        }

        $body.="</TD>\n";
    }
    $body .= "</TR>\n";
}
$body.="</table>";
//mysql_free_result($arrayRtn);
//mysql_close($mysql);

?>
<?=$body?>
<script language=javascript><!--
function aiueo(){
	document.ff.radiobutton[0].click();
	vvv=document.ff.select.options[document.ff.select.selectedIndex].value;
	
	if(vvv=="kensaku"){
	   document.ff.SQL.value="select * from "+document.ff.TB.value+' where '+document.ff.FD.value+'="" limit 0,100'}
	if(vvv=="kensaku2"){
	   document.ff.SQL.value="select * from "+document.ff.TB.value+' where '+document.ff.FD.value+' like "%%" limit 0,100'}
	if(vvv=="kensaku3"){
	   document.ff.SQL.value="select * from "+document.ff.TB.value+' where FIND_IN_SET("",'+document.ff.FD.value+')=0 limit 0,100';}
	if(vvv=="kensaku4"){
	   document.ff.radiobutton[1].click()
	   document.ff.SQL.value="select\n"
	   +"CASE"
	   +" WHEN mail_address like '%yahoo.co.jp' THEN 'yahoo'\n"
	   +" WHEN mail_address like '%hotmail.co.jp' THEN 'msn'\n"
	   +" WHEN mail_address like '%hotmail.com' THEN 'msn'\n"
	   +" WHEN mail_address like '%docomo.ne.jp' THEN 'docomo.ne.jp'\n"
	   +" WHEN mail_address like '%ezweb.ne.jp' THEN 'ezweb.ne.jp'\n"
	   +" WHEN mail_address like '%vodafone.ne.jp' THEN 'vodafone.ne.jp'\n"
	   +" ELSE mail_address\n"
	   +"END\n"
	   +"as Domain\n"
	   +"from "+document.ff.TB.value+' limit 0,100';}
	if(vvv=="zokusei"){
	   document.ff.SQL.value="desc "+document.ff.TB.value
	   document.ff.submit.click();}
	if(vvv=="count"){
	   document.ff.SQL.value="select count(*) from "+document.ff.TB.value
	   document.ff.submit.click();}
	if(vvv=="datalist"){
	   document.ff.SQL.value="select "+document.ff.FD.value+",count(*) from "+document.ff.TB.value+' group by '+document.ff.FD.value}
	if(vvv=="timelist"){
	   document.ff.SQL.value='select date_format('+document.ff.FD.value+',"%Y-%m-%d %H: %i")  as regMinute,count(*) from '+document.ff.TB.value+' group by regMinute order by regMinute desc'}
	if(vvv=="index"){
	   document.ff.SQL.value="show index from "+document.ff.TB.value
	   document.ff.submit.click();}
	if(vvv=="showCreate"){
	   document.ff.SQL.value="show create table "+document.ff.TB.value
	   document.ff.submit.click();}
	if(vvv=="showDatabase"){
	   document.ff.SQL.value="show table status "
	   document.ff.submit.click();}
	if(vvv=="process"){
	   document.ff.SQL.value="show processlist";
	   document.ff.submit.click();}
	if(vvv=="gousei"){
	   document.ff.SQL.value=<?if ($insert==1&&$arrayRtn==true){for((mysql_field_name($arrayRtn,0)=="NO"?$i=1:$i=0);$i<$arrayField;$i+=1){print("document.ff.TB.value+\"." . mysql_field_name($arrayRtn,$i). ($i<$arrayField-1?",":"")."\"+");}}?>""}
	if(vvv=="gousei2"){
	   document.all.TB2.style.display="inline";
	   document.ff.SQL.value="select "+document.ff.TB2.value+".* from "+document.ff.TB.value+","+document.ff.TB2.value+" where "+document.ff.TB.value+"."+document.ff.FD.value+"="+document.ff.TB2.value+"."+document.ff.FD.value;}
	if(vvv=="gousei3"){
	   www=window.open(location.href,"aiueo","width=600,height=400,resizable=1,scrollbars=1");}
	if(vvv=="jyun"){
	   document.ff.SQL.value="select * from "+document.ff.TB.value+" order by "+document.ff.FD.value}
	if(vvv=="Yupdate"){
	   document.ff.SQL.value="update "+document.ff.TB.value+" set "+'<?if ($insert==1&&$arrayRtn==true){for((mysql_field_name($arrayRtn,0)=="NO"?$i=1:$i=0);$i<$MNF;$i+=1){print("" . mysql_field_name($arrayRtn,$i)."=\"\"". ($i<$MNF-1?",":""));}}?>'+" where "+document.ff.FD.value+"=\"\" limit 1";}
	if(vvv=="Ydrop"){
	   document.ff.SQL.value="delete from "+document.ff.TB.value+" where "+document.ff.FD.value+'="" limit 1';}
	if(vvv=="Yadd"){
	   document.ff.SQL.value="insert "+document.ff.TB.value+" set "+'<?if ($insert==1&&$arrayRtn==true){for((mysql_field_name($arrayRtn,0)=="NO"?$i=1:$i=0);$i<$MNF;$i+=1){print("" . mysql_field_name($arrayRtn,$i)."=\"\"". ($i<$MNF-1?",":""));}}?>';}
	   //document.ff.SQL.value="insert into "+document.ff.TB.value+"("+'<?if ($insert==1&&$arrayRtn==true){for((mysql_field_name($arrayRtn,0)=="NO"?$i=1:$i=0);$i<$MNF;$i+=1){print("" . mysql_field_name($arrayRtn,$i). ($i<$MNF-1?",":""));}}?>'+") values ("+'<?if ($insert==1&&$arrayRtn==true){for($i=1;$i<$MNF;$i+=1){print("\"\"".($i<$MNF-1?",":""));}}?>'+")"}
	if(vvv=="Tadd"){
	   document.ff.SQL.value="alter table "+document.ff.TB.value+" add  after "+document.ff.FD.value}
	if(vvv=="Tdrop"){
	   document.ff.SQL.value="alter table "+document.ff.TB.value+" drop "+document.ff.FD.value}
	if(vvv=="Tchange"){
	   document.ff.SQL.value="alter table "+document.ff.TB.value+" change "+document.ff.FD.value}
	if(vvv=="TBadd"){
	   document.ff.radiobutton[1].click()
	   document.ff.SQL.value="create table (\nNO int unsigned primary key auto_increment,\nname text,\n\n)"}
	if(vvv=="TBcopy"){
	   document.ff.SQL.value="create table  as select * from "+document.ff.TB.value}
	if(vvv=="TBdrop"){
	   document.ff.SQL.value="drop table "+document.ff.TB.value;
	   document.ff.TB.value="";}
	if(vvv=="DBadd"){
	   document.ff.SQL.value="create database"}
	if(vvv=="DBdrop"){
	   document.ff.SQL.value="drop database "+document.ff.DB.value
	   document.ff.DB.value=""}
	if(vvv=="TBrename"){
	   document.ff.SQL.value="alter table "+document.ff.TB.value+" rename "
	   document.ff.TB.value=""}
	if(vvv=="keisan"){
	   document.ff.SQL.value="select sum("+document.ff.FD.value+"),avg("+document.ff.FD.value+"),stddev("+document.ff.FD.value+") from "+document.ff.TB.value}
	if(vvv=="unique"){
	   document.ff.SQL.value="alter table "+document.ff.TB.value+" add unique ("+document.ff.FD.value+")";}
	if(vvv=="PRIdrop"){
	   document.ff.SQL.value="alter table "+document.ff.TB.value+" drop primary key";}
	if(vvv=="INDEXdrop"){
	   document.ff.SQL.value="alter table "+document.ff.TB.value+" drop index "+document.ff.FD.value;}
	if(vvv=="hensati"){
	   document.ff.SQL.value="select 50+("+document.ff.FD.value+"-)/ from "+document.ff.TB.value}
	
	document.all.oo.innerHTML=document.ff.select.selectedIndex;      
}


function ttt(){
    tt=document.all.ff.SQL.value;
    if(document.ff.radiobutton[0].checked == 1){
        document.all.ttt.innerHTML="<input type=text name=SQL size=150>";
	
    }

    if(document.ff.radiobutton[1].checked==1){
        document.all.ttt.innerHTML="<textarea name=SQL cols=105 rows=4></textarea>";
	
    }
    document.all.ff.SQL.value=tt;
    
}


function sss(){
    vvv = document.ff.select.options[document.ff.select.selectedIndex].value;
    if((document.ff.SQL.value != "") && (vvv=="Tdrop"||vvv=="TBdrop"||vvv=="DBdrop"||vvv=="TBrename")){
        alert("削除系SQL文は危険なので送信できません");
        return false;
    
    }
}
--></script>
</html>