<?php
/****************************************************/
/*ファイル名 : exitController.inc.php
/*概要   : 一括終了処理
/*引数   : なし
/*返却値 : なし
/*作成者 : 村上　慎一郎
/*作成日 : 2011/05/18
/*更新日、更新者、更新内容:
/****************************************************/
?>
<? require_once(ACCESS_ADMIN.'\writeLog.class.php'); //最後にアクセスログを記録 ?>
<? exit; //終了処理 ?>