<?php
/****************************************************/
/*ファイル名 : setupController.inc.php
/*概要   : モジュール群の一括取り込みセットアップ
/*引数   : なし
/*返却値 : なし
/*作成者 : 村上　慎一郎
/*作成日 : 2011/05/18
/*更新日、更新者、更新内容:
/****************************************************/
?>
<? //require_once(PEAR);?>
<? require_once(MODEL_PLUGIN.'/debug/sqlDebug.php'); //デバッグプリント取り込み?>
<? require_once(MODEL_COMMON.'/mdb2PEAR.class.php'); //DB操作取り込み?>
<? require_once(MODEL_COMMON.'/smartyEx.class.php'); //DB操作取り込み?>

<? 
/* モジュール群を取り込み(plugin)
 * 主にそのページで必要なプラグインの定義
 */
if(is_array($pluginControlArray)) {
    for($i = 0; $i < sizeof($pluginControlArray); $i++) {
	require_once($pluginControlArray[$i]);
                
    }
    
}
?>
<? 
/* モジュール群を取り込み(MODEL)
 * 主にそのページで必要なモジュールの取り込み
 */
if(is_array($modelControlArray)) {
    for($i = 0; $i < sizeof($modelControlArray); $i++) {
	require_once($modelControlArray[$i]);
                
    }
    
}
?>