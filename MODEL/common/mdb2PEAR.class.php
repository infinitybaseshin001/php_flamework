<?php
/****************************************************/
/*ファイル名 : mdb2PEAR.class.php
/*概要   : デバッグ機能付加のPEARによるDB操作
/*引数   : なし
/*返却値 : なし
/*作成者 : 村上　慎一郎
/*作成日 : 2011/05/24
/*更新日、更新者、更新内容:
/****************************************************/
?>
<? require_once(MODEL_PLUGIN.'\debug\sqlDebug.php'); //SQLデバッグ機能取り込み ?>
<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?
class mdb2ex extends sqlDebug{
    var $mdb2;
    
    /****************************************************/    
    /*概要   : MDB2オブジェクトが生成された段階でDB接続
    /*引数   : なし
    /*返却値 : なし
    /*作成者 : 村上　慎一郎
    /*作成日 : 2011/05/24
    /*更新日、更新者、更新内容:
    /****************************************************/
    public function __construct(){
        //parent::__construct();
        require_once(PEAR."\MDB2.php"); //MDB2PEARロード
        require_once(CONF."\db.inc.php"); //DB環境ロード

        //PEARライブラリの仕様上、PEARのdir配置変えたらinclude_path設定しなおさないといけない
        //このフレームワークの便宜上のini_setなので通常はコメントアウト可
        ini_set('include_path', 'C:\xampp\htdocs\mvc_framework\PEAR');
        //$dsn = RESOURCE.'//'.USER.':@'.HOST.'/'.DB;
        $dsn = array(
            'phptype'  => RESOURCE,
            'hostspec' => HOST,
            'database' => DB,
            'username' => USER,
            'password' => ''
        );
        
        //接続
        $this->mdb2 =& MDB2::factory($dsn);
        
        // 接続が失敗したとき
        if( MDB2::isError($this->mdb2) ) {
            echo "データベースに接続できません。処理を中止します。";
            echo 'Standard Message: ' . $this->mdb2->getMessage() . "\n";
            echo 'Standard Code: ' . $this->mdb2->getCode() . "\n";
            echo 'DBMS/User Message: ' . $this->mdb2->getUserInfo() . "\n";
            echo 'DBMS/Debug Message: ' . $this->mdb2->getDebugInfo() . "\n";
            exit;
            
        } else {
            //Fetchmode
            $this->mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);         
            
        }
        
    }
    
    
    /****************************************************/    
    /*概要   : MDB2オブジェクトが破棄された段階でDB接続解放
    /*引数   : なし
    /*返却値 : なし
    /*作成者 : 村上　慎一郎
    /*作成日 : 2011/05/24
    /*更新日、更新者、更新内容:
    /****************************************************/
    public function __destruct(){ 
        $this->mdb2->disconnect();

    } 

    
    /****************************************************/    
    /*概要   : prepare⇨executeでデバッグ結果含むSelect発行し配列で返す
    /*引数   : なし
    /*返却値 : なし
    /*作成者 : 村上　慎一郎
    /*作成日 : 2011/05/24
    /*更新日、更新者、更新内容:
    /****************************************************/
    public function mdb2SelectQuery($sql, $array) {
        
        // PreparedStatementの作成
        $sth = $this->mdb2->prepare($sql);

        // クエリの実行
        // プレースホルダの位置にセットされる値のリスト
        $res = $sth->execute($array);
        $sth->free(); // リソース解放

        // 実行エラーのチェックを必ず行う
        if( MDB2::isError( $res ) ) {
            print "execute error: ".$res->getMessage();
            return null;
          
        } else;

        // 結果を1行ずつassoclistにフェッチ
        $inc = 0;
        while ($row = $res->fetchRow(MDB2_FETCHMODE_ASSOC)) {
            foreach($row as $key => $val) {
		$rtnArray[$inc][$key] = $val;
                
            }
            
            $inc++;
  
        }
  
        //デバッグオブジェクト表示
        if($_SESSION['debug'] == 'on') {
            //デバッグプリント
            $tmpSql = $sql;
            if(is_array($array)) {
                foreach($array as $key => $val) {
                    $tmpSql = str_replace('?', $val, $sql);

                }
            }

            $this->systemOnlySqlColorPrint($tmpSql);
            
            $dBug = new dBug($rtnArray);
            
        }
        
        return $rtnArray;
    
    }



    /****************************************************/    
    /*概要   : prepare⇨executeでデバッグ結果含むInsert発行
    /*引数   : なし
    /*返却値 : なし
    /*作成者 : 村上　慎一郎
    /*作成日 : 2011/05/24
    /*更新日、更新者、更新内容:
    /****************************************************/
    public function mdb2InsertQuery($sql, $array) {
        //デバッグプリント
        $tmpSql = $sql;
        if(is_array($array)) {
            foreach($array as $key => $val) {
                $tmpSql = str_replace($sql, '?', $val);
            
            }
        }
        
        $this->systemOnlySqlColorPrint($tmpSql);
        
        // PreparedStatementの作成
        //$sql = "select id,name from emp where dept_id=?";
        $sth = $this->mdb2->prepare($sql);

        $values = array($array); // プレースホルダの位置にセットされる値のリスト
        $res = $sth->execute($values);
        $sth->free(); // ここで解放して良いのか？

        // 実行エラーのチェックを必ず行う

        if (PEAR::isError($res)) {
            $msg = $res->getMessage();
            $this->mdb2->rollback();// トランザクションをロールバックする
            $this->mdb2->disconnect(); // データベース接続を解放
            throw new exception($msg);
        
        } else;

    }
    
    
    
    /****************************************************/    
    /*概要   : prepare⇨executeでデバッグ結果含むUpdate発行
    /*引数   : なし
    /*返却値 : なし
    /*作成者 : 村上　慎一郎
    /*作成日 : 2011/05/24
    /*更新日、更新者、更新内容:
    /****************************************************/
    public function mdb2UpdateQuery($sql, $array) {
        //デバッグプリント
        $tmpSql = $sql;
        if(is_array($array)) {
            foreach($array as $key => $val) {
                $tmpSql = str_replace($sql, '?', $val);
            
            }
        }
        
        $this->systemOnlySqlColorPrint($tmpSql);
        
        // PreparedStatementの作成
        //$sql = "select id,name from emp where dept_id=?";
        $sth = $this->mdb2->prepare($sql);

        $values = array($array); // プレースホルダの位置にセットされる値のリスト
        $res = $sth->execute($values);
        $sth->free(); // ここで解放して良いのか？

        // 実行エラーのチェックを必ず行う

        if (PEAR::isError($res)) {
            $msg = $res->getMessage();
            $this->mdb2->rollback();// トランザクションをロールバックする
            $this->mdb2->disconnect(); // データベース接続を解放
            throw new exception($msg);
        
        } else;

    }
    
    
    
    /****************************************************/    
    /*概要   : DeleteのQuery発行
    /*引数   : なし
    /*返却値 : なし
    /*作成者 : 村上　慎一郎
    /*作成日 : 2011/05/24
    /*更新日、更新者、更新内容:
    /****************************************************/
    public function mdb2DeleteQuery($sql) {
        $this->systemOnlySqlColorPrint($sql);
        $this->mdb2->query($sql);
        
    }
    
    
    
    
    /****************************************************/    
    /*概要   : alter/create/doropなど汎用のQuery発行
    /*引数   : なし
    /*返却値 : なし
    /*作成者 : 村上　慎一郎
    /*作成日 : 2011/05/24
    /*更新日、更新者、更新内容:
    /****************************************************/
    public function mdb2ExtraQuery($sql) {
        //$this->systemOnlySqlColorPrint($sql);
        $res =& $this->mdb2->query($sql);
        return $res;
        
    }
}
?>