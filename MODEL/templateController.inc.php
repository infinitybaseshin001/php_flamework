<?php
/****************************************************/
/*ファイル名 : templeteController.inc.php
/*概要   : 表示テンプレート群の一括取り込みセットアップ
/*引数   : なし
/*返却値 : なし
/*作成者 : 村上　慎一郎
/*作成日 : 2011/05/18
/*更新日、更新者、更新内容:
/****************************************************/
?>
<? $smarty->display(VIEW_COMMON.'/header.tpl'); //ヘッダの取り込み?>
<? 
//各ページで必要なファイルを取り込み
if(is_array($templateControlArray)) {
    for($i = 0; $i < sizeof($templateControlArray); $i++) {
        $smarty->display($templateControlArray[$i]);
        //require_once($templateControlArray[$i]);
            
    }
        
}
?>
<? $smarty->display(VIEW_COMMON.'/footer.tpl'); //フッタの取り込み?>
