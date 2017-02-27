<?php
/****************************************************/
/*ファイル名 : index.php
/*概要   : 一部モジュール使用のサンプルコーディング
/*引数   : なし
/*返却値 : なし
/*作成者 : 村上　慎一郎
/*作成日 : 2011/06/22
/*更新日、更新者、更新内容:
/****************************************************/
?>
<? require_once('../CONF/ini.inc.php');?>

<?
/*
//プラグイン機能を取り込む(plugin名…validater⇒入力チェック等)⇒フレームワークとして必要
$pluginControlArray = array(MODEL_PLUGIN.'/extend/mailSend.class.php',
                            MODEL_PLUGIN.'/sanitize/sanitizeExe.class.php');
*/

//取り込む機能郡を指定⇒フレームワークとして必要
$modelControlArray = array(MODEL.'/action/index.inc.php',
                           MODEL.'/validate/check.inc.php',
                           MODEL_COMMON.'/adCode.inc.php'); 
?>

<? require_once(MODEL.'/setupController.inc.php'); //上記指定を元に、初期設定と必要関数を取り込む?>


<?
/* 
 * ここは通常のページ処理 
 */

//サニタイズしとこ（関数の定義は上記setupContoroller.inc.phpから）
/*
$san = new sanitize();
$mode = $san->sanitizeExe($_REQUEST[mode], 'escape');
$id = $san->sanitizeExe($_REQUEST[id], 'mysql');
*/

//埋め込むデータを取り込んどこ（関数の定義は上記setupContoroller.inc.phpから）
$im = new indexModule();
$memberArray = $im->getMemberArray();
/* ここまで通常のページ処理 */

//Smartyで取り込んだデータを埋め込み
$smarty = new smartyEx();
$smarty->assign('memberArray', $memberArray);
?>


<?
//取り込むテンプレートを指定（複数可能、ヘッダ・フッダはデフォルトで取り込み）⇒フレームワークとして必要
/*
$templateControlArray = array(VIEW_COMMON.'/loginForm.tpl', 
                              VIEW_MEMBER.'/search_member.tpl' );
 * 
 */
$templateControlArray = array(VIEW.'/index.tpl',
                              VIEW_COMMON.'/memberList.tpl');
?>


<? require_once(MODEL.'/templateController.inc.php'); //ヘッダ・指定したテンプレート・フッタを取り込む?>

<? require_once(MODEL.'/exitController.inc.php'); //mysql開放・アクセスログ記録・exitで終了?>
