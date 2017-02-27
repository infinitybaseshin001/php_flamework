<?php
/****************************************************/
/*ファイル名 : mailMagazine.inc.php
/*概要   : クーロンでメルマガを実行する
/*引数   : なし
/*返却値 : なし
/*作成者 : 村上　慎一郎
/*作成日 : 2011/04/19
/*更新日、更新者、更新内容:
/****************************************************/
?>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/* メルマガクーロン実行ログ */
print date("Y/m/d H:i:s ").microtime()." : メルマガクーロンSTART!\n";

require_once('/home/navi/slrmmax/CONF/init.inc');
require_once(DIR_CONF."/mysql.inc");//DB操作関数定義
require_once(DIR_CONF."/common.inc");
require_once(DIR_DEBUG."/function_SystemOnlySqlColorPrint.inc");//SystemOnlySqlColorPrint();定義

/****************************************************/
/* 修正:2006/06/01 村上
/* ソラリアムMAX仕様で作成
/****************************************************/
function sendMailFromSystemServer($to , $from , $fromName , $targetCareer , $return , $sub , $body){
	$pcMailServerArray[0] = "210.239.172.235:80";
	$pcMailServerArray[1] = "210.239.172.235:81";
	
	$mobileMailServerArray[0]="210.239.172.236:80";
	$mobileMailServerArray[1]="210.239.172.236:81";
	$mobileMailServerArray[2]="210.239.172.236:82";
	//$mobileMailServerArray[3]="210.239.172.236:83";
	$mobileMailServerArray[3]="210.239.172.236:84";
	$mobileMailServerArray[4]="210.239.172.236:85";
	$mobileMailServerArray[5]="210.239.172.236:86";
	$mobileMailServerArray[6]="210.239.172.236:87";
	$mobileMailServerArray[7]="210.239.172.236:88";
	$mobileMailServerArray[8]="210.239.172.236:89";
	$mobileMailServerArray[9]="210.239.172.236:90";
	
	(string)$mailServerIp = "210.239.172.235:80";//デフォルト
	
	/* 携帯判別 */
	if($targetCareer == "mobile"){
		$mailServerIp = $mobileMailServerArray[rand(0,9)];
	}else{
		$mailServerIp = $pcMailServerArray[rand(0,1)];
	}

	$ml_header  = "&from=".$from;
	$ml_header .= "&from_nm=".$fromName;
	$ml_header .= "&rtn_path=".$return;
	$ml_header .= "&rep_to=".$from;
	
	if($targetCareer == "mobile"){
		$curl_post = "to=".$to."&sbj=".urlencode($sub)."&body=".urlencode($body).$ml_header;
	}else{
		$curl_post = "to=".$to."&sbj=".urlencode($sub)."&body=".base64_encode($body).$ml_header;
	}
	//print $curl_post;
	//$rand = rand(0,1);
	$ch     = curl_init();
	
	if($targetCareer == "mobile"){
		curl_setopt($ch,CURLOPT_URL,$mailServerIp."/mail.php");//$mail_server_ip[$rand]
		//mail2.phpはPC用サーバーにしかない仕様Σ（￣Д￣;）
	}else{
		curl_setopt($ch,CURLOPT_URL,$mailServerIp."/mail_html.php");//$mail_server_ip[$rand]
	}
	curl_setopt($ch,CURLOPT_POSTFIELDS,$curl_post);
	curl_setopt($ch,CURLOPT_POST,1);
	$result=curl_exec($ch);//0が出力
	curl_close($ch);

}

// ブラウザが閉じても実行
ignore_user_abort(1);
set_time_limit(0);

/* メルマガクーロン実行ログ */
print date("Y/m/d H:i:s ").microtime()." : SQL実行前\n";

#######################　送信情報取得ここから　##################################
####################### mail_magazineから送信情報取得 ###########################
$sql  = "SELECT M.*, S.senderAddress, S.senderName FROM mail_magazine as M";
$sql .= " LEFT JOIN sender as S";
$sql .= " ON M.senderId = S.senderId";
$sql .= " WHERE M.reserveTime <= '".date("YmdHis")."' ";
$sql .= " AND M.sendStatus = 'not_end' ";
$sql .= " AND S.senderName is not null ";
$sql .= " ORDER BY M.reserveTime";
$sql .= " LIMIT 0,1";
/* メルマガクーロン実行ログ */
print date("Y/m/d H:i:s ").microtime()." : ".$sql."\n";
print "↑送信対象メルマガの取得\n";

$magaQueueArray = mysqlSelectQuery($sql);
$magaArray = $magaQueueArray[0];
if(count($magaQueueArray) == 0){
	/* メルマガクーロン実行ログ */
	print date("Y/m/d H:i:s ").microtime()." : メルマガ予約なっしんぐ\n";
	exit;
}
##################################################################################

########################　送信先情報取得 #########################################
$sql  = "SELECT * FROM recipient ";
$sql .= "WHERE mailMagazineId='".$magaArray[mailMagazineId]."'";
$recipientArray = mysqlSelectQuery($sql);
#################################################################################
#######################　送信情報取得ここまで　##################################



####################### sendStatus更新 ###########################################
$sql  = "UPDATE mail_magazine SET";
$sql .= " sendStatus='sending' ";
$sql .= " WHERE mailMagazineId='".$magaArray['mailMagazineId']."' ";
$sql .= " LIMIT 1";
/* メルマガクーロン実行ログ */
print date("Y/m/d H:i:s ").microtime()." : ".$sql."\n";										//メルマガクーロン実行ログ
print "メルマガ送信フラグの変更(miling)\n";

mysql_query($sql);
##################################################################################


$fp = fopen(DIR_LOG."/".date("Ymd_His").".txt","a");
fwrite($fp,"########################################\n");
fwrite($fp,"ソラリアムMAXメールアドレスリストより"."\n");
fwrite($fp,"suject:\n".$magaArray['subject']."\n");
fwrite($fp,"body:\n".$magaArray['body']."\n");
fwrite($fp,"########################################\n");


/* メルマガクーロン実行ログ */
print date("Y/m/d H:i:s ").microtime()." : 送信開始！\n";

$mailAddressRow=sizeof($recipientArray);

/* メルマガクーロン実行ログ */
print date("Y/m/d H:i:s ").microtime()." : ".$mailAddressRow."件へ送信\n";
sendMailFromSystemServer("murakami@wrk.jp" , $magaArray['senderAddress'] , $magaArray['senderName'] , $magaArray['targetCareer'] , $magaArray['returnPathMailAddress'] , "リストメルマガ".$mailAddressRow."件開始--".$magaArray['subject'] , $magaArray['body']);

$no = 1;
for($i=0; $i < $mailAddressRow; $i+=1){
	$mailAddress = $recipientArray[$i]['mailAddress'];
	fwrite($fp,$no.",".$mailAddress."\r\n");
	sendMailFromSystemServer($mailAddress , $magaArray['senderAddress'] , $magaArray['senderName'] , $magaArray['targetCareer'] , $magaArray['returnPathMailAddress'] , $magaArray['subject'] , $magaArray['body']);
		
	if($no%(floor($mailAddressRow/200))==0){
		print $no."件目途中経過".$mailAddress;
		print "\n";
		?>
		<script language="javascript">
		document.all.aiueo.innerHTML="<?=$no?>";
		</script>
		<?
	}
	flush();
	ob_end_flush();
	$no++;
}

/* メルマガクーロン実行ログ */
print date("Y/m/d H:i:s ").microtime()." : 送信終了！\n";
sendMailFromSystemServer("murakami@wrk.jp" , $magaArray['senderAddress'] , $magaArray['senderName'] , $magaArray['targetCareer'] , $magaArray['returnPathMailAddress'] , "リストメルマガ".$mailAddressRow."件終了--".$magaArray['subject'] , $magaArray['body']);


########################### sendStatus更新 ######################################
$sql  = "UPDATE mail_magazine SET";
$sql .= " sendStatus='end' ";
$sql .= " WHERE mailMagazineId ='".$magaArray['mailMagazineId']."' ";
$sql .= " LIMIT 1";

/* メルマガクーロン実行ログ */
print date("Y/m/d H:i:s ").microtime()." : ".$sql."\n";
print "メルマガ送信フラグの変更(end)\n";

mysql_query($sql);
##################################################################################
?>