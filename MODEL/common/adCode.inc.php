<?php
/****************************************************/
/*ファイル名 : adCode.inc.php
/*概要   : 広告効果統計ログを/LOGに吐き出し⇨DB格納してCRONで吐き出しでも可
/*引数   : なし
/*返却値 : なし
/*作成者 : 村上　慎一郎
/*作成日 : 2011/04/19
/*更新日、更新者、更新内容:
/****************************************************/
?>
<?
//生ログ書き込み
/* ドメインチェック用ドメイン */
$check_domain = "localhost";

//ファーストアクセスの場合(/* クッキー(PHPSESSID)がある場合 *//* リファラー情報がある場合 */)
if(($_REQUEST[PHPSESSID] == "") && !ereg($check_domain,$_SERVER['HTTP_REFERER'])){
    $folder1 = BASE."/LOG/".date("Ym");
    
    if(!is_dir($folder1)){
        mkdir($folder1);
        chmod($folder1,0777);
            
    }
	
    if(!file_exists($folder1."/".date("Ymd").".tsv")) {
        touch($folder1."/".date("Ymd").".tsv");
        chmod($folder1."/".date("Ymd").".tsv",0777);
            
    }
	
    $fp = fopen($folder1."/".date("Ymd").".tsv","a");
    $tmp = $_SESSION[ad_code]."\t";
    $tmp .= $_SERVER['HTTP_REFERER']."\t";
    $tmp .= gethostbyaddr($_SERVER['REMOTE_ADDR'])."\t";
    $tmp .= $_SERVER['REMOTE_ADDR']."\t";
    $tmp .= $_SERVER['HTTP_USER_AGENT']."\t";
    $tmp .= date("Y-m-d-H-i-s(D)")."\t";
    $tmp .= time()."\t";
    $tmp .= $_SERVER['REQUEST_URI'];
    fwrite($fp,"\r\n".$tmp);
    
}
?>