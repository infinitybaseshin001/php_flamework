<?php
/****************************************************/
/*ファイル名 : benchmark.php
/*概要   : 処理時間を計測する（キャッシュと併用して効果測定もありかも）
/*引数   : なし
/*返却値 : なし
/*作成者 : 村上　慎一郎
/*作成日 : 2011/05/18
/*更新日、更新者、更新内容:
/****************************************************/
?>
<? require_once('../CONF/ini.inc.php');?>
<?php
require_once (PEAR."/Benchmark/Timer.php");	//クラスのロード
    
$timer = new Benchmark_Timer;		//インスタンスの生成
$timer->start();				//ベンチスタート

for($i=0;$i<30000;$i++){}			//計測したいPHP文

$timer->setMarker('Marker 1');		//マーキング（ラップ）

while($j<30000){ $j++; }			//計測したいPHP文２

$timer->stop();				//ベンチストップ
    
$profile = $timer->getProfiling();		//結果を連想配列に格納
echo "Total " . $profile[2][total];		//Stopまでの合計秒

//echo "<pre>".print_r($profile)."</pre>";
echo $profile[1][name] ."=". $profile[1][diff]."<br>";//Marker1まで
?>