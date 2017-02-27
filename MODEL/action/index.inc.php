<?php
/****************************************************/
/*ファイル名 : index.class.php
/*概要   : index.phpのモジュール
/*引数   : なし
/*返却値 : なし
/*作成者 : 村上　慎一郎
/*作成日 : 2011/06/09
/*更新日、更新者、更新内容:
/****************************************************/
?>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
class indexModule {
    function getMemberArray(){
        ##################################################################################################
        $sql  = "select * from member ";
        $sql .= " where id = ? ";
        //$sql .= " AND passwd= ? ";
        $sql .= " limit 0, 10";
        
        $array = array(1);
        ###################################################################################################
        
        $mdb2 = new mdb2ex();
        $memArray = $mdb2->mdb2SelectQuery($sql, $array);
        
        return $memArray;
        
    }
    
    
    
}