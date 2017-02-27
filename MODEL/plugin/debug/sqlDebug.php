<?php
/****************************************************/
/*ファイル名 : sqlDebug.php
/*概要   : SQLデバッグプリントクラス
/*引数   : なし
/*返却値 : なし
/*作成者 : 村上　慎一郎
/*作成日 : 2011/06/08
/*更新日、更新者、更新内容:
/****************************************************/
?>
<? require_once("dBug.php"); //無料デバッグツール　?>
<?php
class sqlDebug extends dBug {
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    public function __construct(){
        //parent::__construct();
        
    }
    
    
    function asSplit($string){
	if(preg_match('/(.+)\s+as\s+(.+)/i', $string, $assplitArray)){
            
	}else if(preg_match('/(.+)\s+(.+)/i',$string,$assplitArray)){
            
	}else if(preg_match('/(.+)/i',$string,$assplitArray)){
            
	}
        
	$assplitArray[1] = trim($assplitArray[1]);
	$assplitArray[2] = trim($assplitArray[2]);
	
        return $assplitArray;
        
    }
   
    
    function regexEscape($string){
	$string = str_replace("(","\(",$string);
	$string = str_replace(")","\)",$string);
        
	return $string;
        
    }

    
    function sqlColor($sql){
	if(preg_match('/select\s+([\s\S]+)\s+from\s+([\s\S]+)where([\s\S]+)?/i', $sql, $regexArray)) {//WHEREだったら
            $sql = '<SPAN class = koubun><B>select</B></SPAN> '.$regexArray[1].' <SPAN class = koubun><B>from</B></SPAN> ';
            
            if(preg_match('/([\s\S]+)(INNER|LEFT|RIGHT)[\s\S]+JOIN([\s\S]+)ON([\s\S]+)=([\s\S]+)/i', $regexArray[2], $innerjoinArray)){//INNERJOINだったら
		$db1Array = $this->asSplit($innerjoinArray[1]); 
		$db2Array = $this->asSplit($innerjoinArray[3]);
		
                $sql .= '<B>'.$innerjoinArray[1].'</B><SPAN class = koubun>'.$innerjoinArray[2].' JOIN</SPAN><B>'.$innerjoinArray[3].'</B>
                        <SPAN class = koubun>ON</SPAN>'.$innerjoinArray[4].'='.$innerjoinArray[5];
		$sql .= " where ".$regexArray[3];
		
                if($db1Array[1] != ""){
                    $db1Array[1] = $this->regexEscape($db1Array[1]);
                    $sql = preg_replace('/('.$db1Array[1].'\.)/', '<strong>\1</strong>', $sql);
			
                }
		
                if($db1Array[2] != ""){
                    $db1Array[2] = $this->regexEscape($db1Array[2]);
                    $sql = preg_replace('/('.$db1Array[2].'\.)/', '<strong>\1</strong>', $sql);
			
                }
		
                if($db2Array[1] != ""){
                    $db2Array[1] = $this->regexEscape($db2Array[1]);
                    $sql = preg_replace('/('.$db2Array[1].'\.)/', '<strong>\1</strong>', $sql);
			
                }
			
                if($db2Array[2] != ""){
                    $db2Array[2] = $this->regexEscape($db2Array[2]);
                    $sql = preg_replace('/('.$db2Array[2].'\.)/', '<strong>\1</strong>', $sql);
			
                }
                    
            } else {
		$sql = '<SPAN class = koubun><B>select</B></SPAN> '.$regexArray[1].' <SPAN class = koubun><B>from</B></SPAN> '.$regexArray[2]." where ".$regexArray[3];
		$dbasArray = $this->assplit(",",$regexArray[2]);
		$db1Array = $this->asSplit($dbasArray[0]);
		$db2Array = $this->asSplit($dbasArray[1]);
                
		foreach($dbasArray as $key => $val){
                    $sql = str_replace($val,"<B>".$val."</B>",$sql);
			
                }
		
                $sql = preg_replace('/('.$db1Array[1].'\.)/', '<strong>\1</strong>', $sql);
		$sql = preg_replace('/('.$db1Array[2].'\.)/', '<strong>\1</strong>', $sql);
		$sql = preg_replace('/('.$db2Array[1].'\.)/', '<strong>\1</strong>', $sql);
		$sql = preg_replace('/('.$db2Array[2].'\.)/', '<strong>\1</strong>', $sql);
            
            }
            
        } elseif(preg_match('/select\s+([\s\S]+)\s+from\s+([^ ]+)(.+)?/i', $sql, $regexArray)){
            $sql = '<SPAN class=koubun><B>select</B></SPAN> '.$regexArray[1].' <SPAN class=koubun><B>from</B></SPAN> '.$regexArray[2].$regexArray[3];
            $dbsArray = split(",", $regexArray[2]);
		
            foreach($dbsArray as $key => $val){
		$sql = str_replace($val, "<B>".$val."</B>", $sql);
		
            }
        }

	$sql = preg_replace('/delete\s+from\s+([^ ]+)(.+)/i','<SPAN class=koubun><B>delete from</B></SPAN> <B>\\1</B>\2',$sql);
	$sql = preg_replace('/update\s+([\s\S]+)\s+set\s+([^ ]+)/i','<SPAN class=koubun><B>update</B></SPAN> <B>\1</B> <SPAN class=koubun><B>set</B></SPAN> \2',$sql);
	$sql = preg_replace('/insert\s+([\s\S]+)\s+set\s+([^ ]+)/i','<SPAN class=koubun><B>insert</B></SPAN> <B>\1</B> <SPAN class=koubun><B>set</B></SPAN> \2',$sql);
	$sql = preg_replace('/show\s+index +from +([^ ]+)/i','<SPAN class=koubun><B>show</B></SPAN> <SPAN class=sqlWord>index</SPAN> <SPAN class=koubun><B>from</B></SPAN> <B>\1</B>',$sql);
	$sql = preg_replace('/show\s+tables/i','<SPAN class=koubun><B>show</B></SPAN> <SPAN class=sqlWord>tables</SPAN>',$sql);
	$sql = preg_replace('/show\s+databases/i','<SPAN class=koubun><B>show</B></SPAN> <SPAN class=sqlWord>databases</SPAN>',$sql);
	$sql = preg_replace('/desc\s+([^ ]+)/i','<SPAN class=koubun><B>desc</B></SPAN> \1',$sql);
	$sql = preg_replace('/CASE([\s\S]+?)END/i','<BR><table border=0 class=BlueBorder><tr><td><SPAN class=hojo><B>CASE</B></SPAN><BR>\1<SPAN class=hojo><B>END</B></SPAN></td></tr></table>',$sql);
	$sql = preg_replace('/WHEN(.+?)THEN\s([0-9]+|\'.+?\')/i','&nbsp;<SPAN class=BlueBorder><SPAN class=hojo><B>WHEN</B></SPAN>\1<SPAN class=hojo><B>THEN</B> </SPAN>\2</SPAN><BR>',$sql);
	$sql = preg_replace('/ELSE\s+([^\s]+)/i','&nbsp;<SPAN class=BlueBorder><SPAN class=hojo><B>ELSE</B></SPAN> \1</SPAN><BR>',$sql);
	$sql = eregi_replace(" where "," <SPAN class=koubun><B>where</B></SPAN> ",$sql);
	$sql = eregi_replace("group by +([^ ]+)",'<nobr><SPAN class=BlueBorder><SPAN class=koubun>group by</SPAN> \1</SPAN></nobr>',$sql);
	$sql = eregi_replace("order by +(([^ ]+( desc)?)+)",'<nobr><SPAN class=BlueBorder><SPAN class=koubun>order by</SPAN> \1</SPAN></nobr>',$sql);
	$sql = eregi_replace("limit +([^ ]+)",'<nobr><SPAN class=BlueBorder><SPAN class=koubun>limit</SPAN> \1</SPAN></nobr>',$sql);
	$sql = eregi_replace(" desc"," <SPAN class=koubun>desc</SPAN>",$sql);
	
	$sql = preg_replace("/(?<= )(?=like )like/","<SPAN class=hojo>like</SPAN>",$sql);
	$sql = preg_replace("/(?<=\s)(?=as )as/","<SPAN class=hojo>as</SPAN>",$sql);
	
	$sql = preg_replace("/((?<= )|(?<=,)|(?=count )|(?=count ))count/i",'<SPAN class=kansu>count</SPAN>',$sql);
	$sql = preg_replace("/((?<= )|(?<=,)|(?=sum )|(?=sum ))sum/i",'<SPAN class=kansu>sum</SPAN>',$sql);
	$sql = preg_replace("/((?<= )|(?<=,)|(?=avg )|(?=avg ))avg/i",'<SPAN class=kansu>avg</SPAN>',$sql);
	$sql = preg_replace("/((?<= )|(?<=,)|(?=stddev )|(?=stddev ))stddev/i",'<SPAN class=kansu>stddev</SPAN>',$sql);
	$sql = preg_replace("/((?<= )|(?<=,)|(?=FIND_IN_SET )|(?=FIND_IN_SET ))FIND_IN_SET/i",'<SPAN class=kansu>FIND_IN_SET</SPAN>',$sql);
	$sql = str_replace("(","<SPAN class=kansu>(</SPAN>",$sql);
	$sql = str_replace(")","<SPAN class=kansu>)</SPAN>",$sql);
	
	$sql = eregi_replace("databases","<SPAN class=sqlWord>databases</SPAN>",$sql);
	$sql = eregi_replace("tables","<SPAN class=sqlWord>tables</SPAN>",$sql);
	
	$sql = str_replace(",","<SPAN class=momo>,</SPAN></FONT>",$sql);

	
	$sql = preg_replace("/ (OR) /i"," <SPAN class=koubun>OR</SPAN></FONT> ",$sql);
	$sql = preg_replace("/ (AND) /i"," <BR><SPAN class=koubun>AND</SPAN></FONT> ",$sql);
	/*************ここから文字列******************/
	//$sql=preg_replace("/('.+?')/i",' <FONT color=#e00000>\1</FONT> ',$sql);
	//$sql=preg_replace('/(".+?")/i',' <FONT color=#e00000>\1</FONT> ',$sql);
	/*************ここまで文字列******************/

print <<< _EOD_
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
/****************ここからテキストカラー******************/
.koubun {
	color: #0000ff;
}
.sqlWord {
	color: #408080;
}
.hojo {
	color: #004b00;
}
.kansu {
	color: #ff0000;
}
/****************ここまでテキストカラー******************/
/****************ここからバックグラウンドカラー******************/
.ao {
	background-color: #dddddd;
}
.midori{
	background-color: #D6F8DA;
}
.momo {
	background-color: #ffd6d7;}
.black{
	/*background-color: #000000;*/
	color: #000000;
	margin: 0px;
	padding: 10px;
}
/****************ここまでバックグラウンドカラー******************/
/****************ここからボーダー******************/
.BlueBorder {
	color: #000000;
	/*background-color: #111111;*/
}
/****************ここまでボーダー******************/
/****************ここからHREF******************/
.sqlColor a:link,.sqlColor a:visited,.sqlColor a:active,.sqlColor a:hover  {
	FONT-family: "ＭＳ Ｐゴシック";
	text-decoration: none;
	color: #000000;
}
/****************ここまでHREF******************/
-->
</style>    
_EOD_;
        
        return $sql;

    }

        
    function sqlAHref($table, $sql, $moji){
	return "<a target = _blank href = http://localhost/mvc_framework/www/debug/sqlQueryForm.php?DB="."mvc_framework"."&TB=".$this->regexEscape($table)."&SQL=".urlencode($sql)." >".$moji."</a>";

    }    
        
        
    function systemOnlySqlColorPrint($sql){
	/*
        リモートサーバーでのデバッグかどうかで切り分け
        */
        if($_SESSION[debug] == "on"){
            
        }else{
            return "";
            
	}
	
        print "<div class=black><span class=sqlColor>";
	$sqlColor = $this->sqlColor($sql);
	
        if(preg_match('/select\s+([\s\S]+)\s+from\s+([^ ]+)/i', $sql, $regexArray)){
            //print_r($regexArray);
            print $this->sqlAHref($regexArray[2], $sql, "☆")."☆";
            $dbsArray=split(",",$regexArray[2]);
		
            foreach($dbsArray as $key => $val){
                $www = $this->sqlAHref($val, "", $val);
		$val = $this->regexEscape($val);
                $sqlColor = preg_replace("/(>.*?)".$val."(.*?<)/i", '\1'.$www.'\2', $sqlColor);
		
            }
        
	} elseif(preg_match('/delete\s+from\s+([^ ]+)/i', $sql, $regexArray)){
            //print_r($regexArray);
            print "☆☆";
            $sqlColor = ereg_replace($regexArray[1], $this->sqlAHref($regexArray[1], "", $regexArray[1]), $sqlColor);
	
        }elseif(preg_match('/update\s+([^ ]+)\s+set\s+([\s\S]+)/i', $sql, $regexArray)){
            //print_r($regexArray);
            print "☆☆";
            $sqlColor = ereg_replace($regexArray[1], $this->sqlAHref($regexArray[1], "", $regexArray[1]), $sqlColor);
	
        }elseif(preg_match('/insert\s+([^ ]+)\s+set\s+([\s\S]+)/i', $sql, $regexArray)){
            //print_r($regexArray);
            print "☆☆";
            $sqlColor = ereg_replace($regexArray[1], $this->sqlAHref($regexArray[1], "", $regexArray[1]), $sqlColor);
	
        } else {
            print "☆☆";
	
        }

	print $sqlColor;
	print "☆☆";
	print "</span></div>\n";
    
    }    
        
}
?>