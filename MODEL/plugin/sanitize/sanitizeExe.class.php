<?php
/****************************************************/
/*ファイル名 : sanitize.class.php
/*概要   : 各サニタイズ
/*引数   : なし
/*返却値 : なし
/*作成者 : 村上　慎一郎
/*作成日 : 2011/04/19
/*更新日、更新者、更新内容:
/****************************************************/
?>
<?php
class sanitize {
    function sanitizeExe($str, $various) {
	switch($various) {
            case 'html':
		$str = htmlspecialchars($str, ENT_NOQUOTES);
		break;
		
            case 'mysql':
		$str = mysql_real_escape_string($str);
		break;	
		
            case 'escape':
		$str = addslashes($str);
		break;			
		
            default:
		$str = addslashes($str);
		break;			
			
	}
	
	return $str;
    
    }
	
}
?>