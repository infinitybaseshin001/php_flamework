<?php
/****************************************************/
/*ファイル名 : spreadSheet.class.php
/*概要   : スプレッドシート作成（Excelで.xlsファイル作成）
/*引数   : なし
/*返却値 : なし
/*作成者 : 村上　慎一郎
/*作成日 : 2011/06/08
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
class spreadSheet {
    function spreadSheetWriter($file, $sheet) {
    
        require_once 'Spreadsheet/Excel/Writer.php';

        // ワークブックを作成します
        $workbook = new Spreadsheet_Excel_Writer();

        // HTTP ヘッダを送信します
        //$workbook->send('test.xls');
        $workbook->send($file);
        
        // ワークシートを作成します
        //$worksheet =& $workbook->addWorksheet('My first worksheet');
        $worksheet =& $workbook->addWorksheet($sheet);
        
        // データを書き込みます
        $worksheet->write(0, 0, 'Name');
        $worksheet->write(0, 1, 'Age');
        $worksheet->write(1, 0, 'John Smith');
        $worksheet->write(1, 1, 30);
        $worksheet->write(2, 0, 'Johann Schmidt');
        $worksheet->write(2, 1, 31);
        $worksheet->write(3, 0, 'Juan Herrera');
        $worksheet->write(3, 1, 32);

        // ファイルを送信します
        $workbook->close();
    
    }
    
}
?> 