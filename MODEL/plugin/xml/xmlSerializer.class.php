<?php
/****************************************************/
/*ファイル名 : xmlSerializer.class.php
/*概要   : XML⇔配列
/*引数   : なし
/*返却値 : なし
/*作成者 : 村上　慎一郎
/*作成日 : 2011/05/18
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
class xmlSerializer {
    
    function arrayXml() {
        require_once(PEAR.'/XML/Serializer.php'); //PEARモジュール取り込み
        
        $options = array(
            "indent" => " ",
            "linebreak" => "\n",
            "typeHints" => false,
            "addDecl" => true,
            "encoding" => "UTF-8",
            "rootName" => "rdf:RDF",
            "rootAttributes" => array("version" => "0.91"),
            "defaultTagName" => "item",
        );

        $serializer = new XML_Serializer($options);
        $rdf = array(
            "channel" => array(
                array(
                    "title" => "年齢と誕生日の変換プログラム[PHP]",
                    "description" => "PHPで年齢を引数にして誕生日を返す関数とその逆の関数のサンプルです。結構使いどころが多いんですよね、最近。というわけでメモっておこうと思います。",
                    "link" => "http://webtech-walker.com/archive/2007/04/03143317.html",
                    "guid" => "http://webtech-walker.com/archive/2007/04/03143317.html",
                    "pubDate" => "Tue, 03 Apr 2007 14:33:17 +0900",
                ),

                array(
                    "title" => "IEでfloatさせたボックスのmarginが2倍になるバグ",
                    "description" => "有名なバグではありますが、久しぶりに遭遇して困ったことになったので書き残しておきます。実際どういう感じで表示されるかというと、下記のような感じです。",
                    "link" => "http://webtech-walker.com/archive/2007/03/29171705.html",
                    "guid" => "http://webtech-walker.com/archive/2007/03/29171705.html",
                    "pubDate" => "Thu, 29 Mar 2007 17:17:05 +0900",
                ),

                array(
                    "title" => "ページの高さを自動調節するjavascript",
                    "description" => "コンテンツの量が少ないページだと、極端にページの高さが小さくなったりすることがあります。cssのheightプロパティで高さをしてしまえばいいのですが、コンテンツの内容が変わる度にcssを編集するのは管理が大変になってしまいます。",
                    "link" => "http://webtech-walker.com/archive/2007/03/26231718.html",
                    "guid" => "http://webtech-walker.com/archive/2007/03/26231718.html",
                    "pubDate" => "Mon, 26 Mar 2007 23:17:18 +0900",
                )
            )
        );

        $status = $serializer->serialize($rdf);

        if ($status === true) {
            $xml = $serializer->getSerializedData();
            echo "<pre>".htmlspecialchars($xml)."</pre>";

        }
     
    }
    
    

    function xmlArray() {
        require_once(PEAR.'/XML/Unserializer.php'); //PEARモジュール取り込み
        
        $xml = file_get_contents("http://webtech-walker.com/sample/html/070406.xml");

        $Unserializer =& new XML_Unserializer();
        $Unserializer->setOption('parseAttributes', TRUE);

        $status = $Unserializer->unserialize($xml);

        if ($status === true) {
            $res_array = $Unserializer->getUnserializedData();
            print_r($res_array);

        }
              
    }
    
}
 