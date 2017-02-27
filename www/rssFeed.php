<?php
/****************************************************/
/*ファイル名 : rssFeed.php
/*概要   : rssを取り込み表示する（便宜上MVCに分けていません）
/*引数   : なし
/*返却値 : なし
/*作成者 : 村上　慎一郎
/*作成日 : 2011/05/18
/*更新日、更新者、更新内容:
/****************************************************/
?>
<? require_once('../CONF/ini.inc.php');?>
<html>
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <title>ブログのRSSフィードを表示する</title>
 </head>
 <body>
 <?php
 //XML_RSS読み込み
 require_once(PEAR."/XML/RSS.php");
 
 //RSSフィードからオブジェクトを生成
 $rss =& new XML_RSS("http://www.asial.co.jp/blog/rss/rss2.0.php");
  
 //parse()メソッドによりRSSをパース
 $rss->parse();
  
 echo "<h1>ブログのRSSフィードを表示する</h1>\n";
 echo "<dl>\n";
 
 //getItems() メソッドを使って、解析した各項目要素を$itemとして取得
 foreach ($rss->getItems() as $item) {
    //RSSフィードのlink,title情報を表示
    echo "<dt><a href=\"" . $item['link'] . "\">" . $item['title'] . 
    "</a></dt>\n";
    //RSSフィードのdescription情報の先頭200文字をHTMLタグを取り除いて表示
    echo "<dd>";
    echo mb_strimwidth(strip_tags($item['description']), 0, 200, "...", 
    "UTF-8");
    echo "</dd>\n";
    
 }
 echo "</dl>\n";
 ?>
 </body>
 </html> 