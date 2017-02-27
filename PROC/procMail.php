<?php
/****************************************************/
/*ファイル名 : procMail.php
/*概要   : proc処理（主に空メールを送らせての登録処理など）
/*引数   : なし
/*返却値 : なし
/*作成者 : 村上　慎一郎
/*作成日 : 2011/06/27
/*更新日、更新者、更新内容:
/****************************************************/
?>
<? require_once('../CONF/ini.inc.php');?>
<? require_once(PEAR.'/Mail/mimeDecode.php');?>
<?php
// メールデータ取得
$params['include_bodies'] = true;
$params['decode_bodies']  = true;
$params['decode_headers'] = true;
$params['input'] = file_get_contents("php://stdin"); //メールデータは標準入出力（stdin）として取り込みます
$params['crlf'] = "\r\n";
$structure = Mail_mimeDecode::decode($params);

//送信者のメールアドレスを抽出
$mail = $structure->headers['from'];
$mail = addslashes($mail);
$mail = str_replace('"','',$mail);

//署名付きの場合の処理を追加
preg_match("/<.*>/",$mail,$str);
if($str[0]!=""){
    $str = substr($str[0],1,strlen($str[0])-2);
    $mail = $str;
    
}
/*
 *「$structure->headers['to']」で送信元のメールアドレスも取得できます。
 */

// 件名を取得
$diary_subject = $structure->headers['subject'];
  
switch(strtolower($structure->ctype_primary)){
    case "text": // シングルパート(テキストのみ)
       $diary_body = $structure->body;
        break;
    
    case "multipart":  // マルチパート(画像付き)
        foreach($structure->parts as $part){
            switch(strtolower($part->ctype_primary)){
                case "text": // テキスト
                    $diary_body = $part->body;
                    break;
            
                case "image": // 画像
                    //画像の拡張子を取得する(小文字に変換
                    $type = strtolower($part->ctype_secondary);
                    //JPEGチェック（GIFやPNG形式の画像チェックなども可
                    if($type != "jpeg" and $type != "jpg"){
                        continue;
                        
                    }
                    //添付内容をファイルに保存
                    $fp = fopen("/tmp/picture.jpg" . $type,"w" );
                    $length = strlen( $part->body );
                    fwrite( $fp, $part->body, $length );
                    fclose( $fp );
                    break;
           }
        }
        break;
    
    default:
        $diary_body = "";
        
}
  /*
   * 取得したメールアドレス、タイトル、本文、画像を使用してデータベースなどに取り込む
   */
?> 
<?
/*
    $diary_subjectにはメールのタイトルが格納されています。
    $diary_bodyにはメール本文が格納されています。
    「/tmp/picture.jpg」には添付した画像が保存されます。

上記の内容に加えて、Fromのメールアドレスからユーザ情報と結びつけることができます。
 * これで特定のメールアドレスにメールを送信するだけで、日記としてデータベースなどに登録することができますね。

ここでは日記として説明しましたが、携帯ではPCのように<input type="file">を対応している機種が少ないので、
 * 携帯からの画像UPLOADの用途として使用することもできます。

このようにメールと組み合わせることによって、いろいろな用途で使うことができると思います。
 * 
 */
?>