<?php
/****************************************************/
/*ファイル名 : mailSend.class.php
/*概要   : html/テキスト　メール送信
/*引数   : なし
/*返却値 : なし
/*作成者 : 村上　慎一郎
/*作成日 : 2011/06/08
/*更新日、更新者、更新内容:
/****************************************************/
?>
<?php
class mailSend {
    function mailSneder($type, $subject, $mailbody) {
        require_once('Mail.php');
        require_once('Mail/mime.php');
/*
        $subject = "HTMLメールですよー。結構長めに設定してmime変換されているかチェック。";  // 題名
        $text    = "e-mailのテストだよ";  // テキスト本文
    $html = <<<HTML
    <html>
    <HEAD>
    <META HTTP-EQUIV="content-type" CONTENT="text/html; charset=EUC-JP">
    </HEAD>
    <body>
    e-<font color="red">mail</font>のテストだよ<br />
    <img src="my_baby.gif" />
    </body>
    </html>
    HTML;
*/
        // EUC-JP => JIS
        $original = mb_internal_encoding();
        $subject = mb_convert_encoding( $subject, "ISO-2022-JP", "EUC-JP" );
        mb_internal_encoding( "ISO-2022-JP" );
        $subject = mb_encode_mimeheader( $subject, "ISO-2022-JP" );
        mb_internal_encoding( $original );

        $mailbody = mb_convert_encoding( $mailbody, "ISO-2022-JP", "EUC-JP" );

        $file = './secret_file.xls'; // application/octet-stream
        $img  = './my_baby.gif'; // image/gif
        $crlf = "\n"; // 現在の改行コード

        // ヘッダー情報
        $hdrs = array(
                      'From'    => 'dozo@matrix.jp',
                      'Sender'    => 'dozo@rgr.jp',
                      'Subject' => $subject,
                      );
        // インスタンス生成
        $mime = & new Mail_mime($crlf);

        $mime->setTXTBody($mailbody); // 
        $mime->setHTMLBody($mailbody);
        $mime->addAttachment($file);
        $mime->addHTMLImage($img, 'image/gif');

        // 出力用パラメータ
        $build_param = array(
            "html_charset" => "EUC-JP",
            "text_charset" => "ISO-2022-JP",
            "head_charset" => "ISO-2022-JP",
        );

        $body = $mime->get( $build_param );
        $hdrs = $mime->headers($hdrs);

        $mail =& Mail::factory('mail');
        $mail->send('dozo@rgr.jp', $hdrs, $body);

    }

}
?>