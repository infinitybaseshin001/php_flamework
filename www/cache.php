<?php
/****************************************************/
/*ファイル名 : cache.php
/*概要   : キャッシュを使用して処理時間を向上する（このファイル内定義関数は他処理や関数でも可）
/*引数   : なし
/*返却値 : なし
/*作成者 : 村上　慎一郎
/*作成日 : 2011/05/18
/*更新日、更新者、更新内容:
/****************************************************/
?>
<?php
/*
 * キャッシュというとページ単位のキャッシュを考える人も多いかもしれませんが、
 * もっと手軽なPEAR::Cache_Liteを使用した関数単位でのキャッシュを紹介します。
 * キャッシュはパフォーマンスをかなり向上させることができます。
 * パフォーマンスの低下に悩んでいる方はぜひ試してみてください。
 * キャッシュを使用する場合、まずはキャッシュのヒット率を考える必要があります。
 * 例えば、アクセスしているユーザーごとに異なる結果を返す場合は、10回のアクセスがあっても、
 * それが10人のユーザーからのアクセスであれば、キャッシュを作るだけになってしまいます。
 * 逆に、毎回同じ結果を返す場合は10回のアクセスがあると、はじめのアクセスでキャッシュを作成し、
 * 残りの9回のアクセスでは、キャッシュが使用されることになり、結果を作成するための処理を省略することができます。
 * では、以下のような関数にキャッシュ機能を追加することを考えてみましょう。
 * 
 */
?>
<? require_once('../CONF/ini.inc.php');?>
<?php
// Cache_Liteインクルード
require_once (PEAR."/Cache/Lite.php");

//キャッシュオプション設定
$cacheOptions = array(
    'cacheDir' => './tmp/',   //tmpディレクトリに設定
    'lifeTime' => '3600',     //1時間に設定
);

//キャッシュID設定
$id = "area";

//Cache_Liteオブジェクト生成
$Cache_Lite = new Cache_Lite($cacheOptions);

//キャッシュがあるかどうかテスト
if($data = $Cache_Lite->get($id)){
    //有効なキャッシュがある場合の処理
    // キャッシュデータを表示
    echo $data;

} else {

    //有効なキャッシュがない場合の処理
    //データを生成する

    function lwws($city,$day){

        //XMLデータ取得用ベースURL
        $req = "http://weather.livedoor.com/forecast/webservice/rest/v1";
     
        //XMLデータ取得用リクエストURL生成
        $req .= "?city=".$city."&day=".$day;
    
        //XMLファイルをパースし、オブジェクトを取得
        $xml = simplexml_load_file($req) or die("XMLパースエラー");
    
        //$xmlオブジェクトの中身を確認する場合は、以下のコメントを外す
        /*
        echo "<pre>";
        var_dump ($xml);
        echo "</pre>";
        */
        $ret = '<div class="lwws">';
        $ret .= "<div>".$xml->title."</div>";
        $ret .= "<div><img src=\"".$xml->image->url."\" alt=\"".$xml->image->title."\"></div>";
        $ret .= "<div>".$xml->description."</div>";
        $ret .= "<div>最高気温".$xml->temperature->max->celsius."度</div>";
        $ret .= "<div>最低気温".$xml->temperature->min->celsius."度</div>";
        $ret .= "</div>";

        return $ret;

    }

    function photozou($keyword,$limit){
   
        //XMLデータ取得用ベースURL
        $req = "http://api.photozou.jp/rest/search_public";
       
        //XMLデータ取得用リクエストURL生成
        $req .= "?type=photo&keyword=".urlencode($keyword)."&limit=".$limit;
      
        //XMLファイルをパースし、オブジェクトを取得
        $xml = simplexml_load_file($req) or die("XMLパースエラー");
       
        $ret = '<div class="photozou">';

        foreach ($xml->info->photo as $photo){
            $ret .= "<a href=\"".$photo->url."\">";
            $ret .= "<img src=\"".$photo->thumbnail_image_url."\" alt=\"".
            $photo->photo_title."\">";
            $ret .= "</a>\n";
        
        }

        $ret .= "</div>";

        return $ret;
    
    }
/*
    function youtube($keyword,$limit){

        //dev_idを設定
        $dev_id = "取得したDeveloper ID";
  
        //XMLデータ取得用ベースURL
        $req = "http://www.youtube.com/api2_rest";
      
        //XMLデータ取得用リクエストURL生成
        $req .= "?method=youtube.videos.list_by_tag";
        $req .= "&dev_id=".$dev_id."&tag=".urlencode($keyword)."&page=1&per_page=".$limit;
      
        //XMLファイルをパースし、オブジェクトに代入
        $xml = simplexml_load_file($req) or die("XMLパースエラー");
     
        $ret  = '<div class="youtube">';

        foreach ($xml->video_list->video as $video){
            $ret  .= '<object width="340" height="280"><param name="movie" value="http://www.youtube.com/v/';
            $ret .= $video->id;
            $ret .= '"></param><param name="wmode" value="transparent"></param>';
            $ret .= '<embed src="http://www.youtube.com/v/';
            $ret .= $video->id;
            $ret .= '" type="application/x-shockwave-flash" wmode="transparent" width="340" height="280">';
            $ret .= '</embed></object>'."\n";
        
        }

        $ret .= "</div>";

        return $ret;
 * 
 */   
    }

    $data = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
    $data .= "<h1>キャッシュを導入して、快適なページ表示を実現する</h1>\n";
  
    //リクエストパラメータ設定
    $city = "70"; //横浜を設定
    $day = "tomorrow"; //tomorrow（明日の天気）を設定
    $keyword = "横浜"; //横浜を設定
    $limit = 5;     //取得件数に5件を設定

    //それぞれの関数を順番にコールする
    $data .= lwws($city,$day);
    $data .= photozou($keyword,$limit);
    //$data .= youtube($keyword,$limit);

    //生成したデータを表示
    echo $data;

    //データをキャッシュ保存
    $Cache_Lite->save($data,$id);

?>