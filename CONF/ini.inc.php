<?
// セッションの有効時間を一日にする
/* ********************************************* */
ini_set("session.gc_maxlifetime", 86400);

/* 自動実行範囲START */
//アドコードをセッションにぶっこむ＆引き継ぐ
session_start();

if($_REQUEST[amc] != ""){
	$_SESSION[ad_code] = $_REQUEST[amc];
        
}elseif($_REQUEST[ad_code] != ""){
	$_SESSION[ad_code] = $_REQUEST[ad_code];
        
}else if($_SESSION[ad_code] == ""){
	$_SESSION[ad_code] = 999;
        
}

if($_REQUEST[debug]!=""){
	$_SESSION[debug] = $_REQUEST[debug];
}
/* ********************************************* */
/* 自動実行範囲END */
?>

<?
/* フルパス指定はメンドクサイので短縮定義 */
/* ********************************************* */
define("BASE", "C:\\xampp\htdocs\mvc_framework");
define("CONF", BASE."\CONF");
define("PEAR", BASE."\PEAR");
define("MODEL", BASE."\MODEL");
define("MODEL_PLUGIN", MODEL."\plugin");
define("MODEL_COMMON", MODEL."\common");
define("VIEW", BASE."\VIEW");
define("VIEW_COMMON", VIEW."\common");
define("MODEL_ADMIN", BASE."\MODEL\ADMIN");
define("ACCESS_ADMIN", MODEL_ADMIN."\accessAdmin");
define("SITE_ADMIN", MODEL_ADMIN."\siteAdmin");
define("user_ADMIN", MODEL_ADMIN."\userAdmin");
//define("DIR_FRAME",$docRoot."FRAME");
//define("DIR_TMP",$docRoot."TMP");
//define("DIR_LOG",$docRoot."LOG");
//define("DIR_DEBUG",$docRoot."CONF/DEBUG");
/* ********************************************* */
?>

<?php
/*
 * exam-ini.php
 *
 * update:
 */
$config = array(
    // site
    'url' => '',

    // debug
    // (to enable ethna_info and ethna_unittest, turn this true)
    'debug' => false,

    // db
    // sample-1: single db
    // 'dsn' => 'mysql://user:password@server/database',
    //
    // sample-2: single db w/ multiple users
    // 'dsn'   => 'mysql://rw_user:password@server/database', // read-write
    // 'dsn_r' => 'mysql://ro_user:password@server/database', // read-only
    //
    // sample-3: multiple db (slaves)
    // 'dsn'   => 'mysql://rw_user:password@master/database', // read-write(master)
    // 'dsn_r' => array(
    //     'mysql://ro_user:password@slave1/database',         // read-only(slave)
    //     'mysql://ro_user:password@slave2/database',         // read-only(slave)
    // ),

    // log
    // sample-1: sigile facility
    'log_facility'          => 'echo',
    'log_level'             => 'warning',
    'log_option'            => 'pid,function,pos',
    'log_filter_do'         => '',
    'log_filter_ignore'     => 'Undefined index.*%%.*tpl',
    // sample-2: mulitple facility
    //'log' => array(
    //    'echo'  => array(
    //        'level'         => 'warning',
    //    ),
    //    'file'  => array(
    //        'level'         => 'notice',
    //        'file'          => '/var/log/exam.log',
    //        'mode'          => 0666,
    //    ),
    //    'alertmail'  => array(
    //        'level'         => 'err',
    //        'mailaddress'   => 'alert@ml.example.jp',
    //    ),
    //),
    //'log_option'            => 'pid,function,pos',
    //'log_filter_do'         => '',
    //'log_filter_ignore'     => 'Undefined index.*%%.*tpl',

    // memcache
    // sample-1: single (or default) memcache
    // 'memcache_host' => 'localhost',
    // 'memcache_port' => 11211,
    // 'memcache_use_connect' => false,
    // 'memcache_retry' => 3,
    // 'memcache_timeout' => 3,
    //
    // sample-2: multiple memcache servers (distributing w/ namespace and ids)
    // 'memcache' => array(
    //     'namespace1' => array(
    //         0 => array(
    //             'memcache_host' => 'cache1.example.com',
    //             'memcache_port' => 11211,
    //         ),
    //         1 => array(
    //             'memcache_host' => 'cache2.example.com',
    //             'memcache_port' => 11211,
    //         ),
    //     ),
    // ),

    // csrf
    // 'csrf' => 'Session',
);
?>
