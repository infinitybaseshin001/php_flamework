<?php
/****************************************************/
/*ファイル名 : smartyEx.class.php
/*概要   : Smarty拡張
/*引数   : なし
/*返却値 : なし
/*作成者 : 村上　慎一郎
/*作成日 : 2011/06/22
/*更新日、更新者、更新内容:
/****************************************************/
?>
<?php
/**
 * Smarty 拡張クラス
 *
 * - Smarty のデフォルト環境を設定<br>
 * - 静的ページ作成用メソッドの追加<br>
 */
?>
<? require_once(BASE.'/Smarty/libs/Smarty.class.php'); //Smarty取り込み?>
<?
/**
 * Smarty を継承し、ジェネレータ用のメソッドと 漢字コードを設定したHTMLページを
 * 表示するメソッドを追加
 */
class smartyEx extends Smarty {
    /**
     * 出力ファイル名
     *
     * @access  private
     * @var     string
     * @see generate(), halt()
     */
    var $sGenFilename = "";

    /**
     * コンストラクタ - Smarty の環境を設定
     *
     * @access  public
     * @param   string  $sDirTop            Smarty作業ディレクトリー
     */
    function smartyEx($sDirTop="") {
        // 親クラスのコンストラクタ
        parent::__construct();

        $sDirTop = VIEW;
        if ($sDirTop) {
            $this->template_dir = $sDirTop . "/templates";
            $this->compile_dir  = $sDirTop . "/templates_c";
            $this->config_dir   = $sDirTop . "/configs";
            $this->cache_dir    = $sDirTop . "/cache";
            
            }
            
        }

    /**
     * ジェネレート - テンプレートをもとに、HTML ファイルを作成する
     *
     * @access  public
     * @param   string  $sTemplateFilename  テンプレートファイル
     * @param   string  $sGenFilename       ジェネレート先ファイル
     * @return  bool    true:成功 false:失敗
     */
    function generate($sTemplateFilename, $sGenFilename) {
        $this->sGenFilename = $sGenFilename;

        // ディレクトリがない場合は作成
        $sDirName = dirname($this->sGenFilename);
        if (!is_dir($sDirName)) {
            // -p: 存在しない場合は親ディレクトリを作成
            //exec("mkdir -p $sDirName");
            mkdir($sDirName, 0777, true);
            
        }

        // テンプレート置換後のデータ
        $sContents = $this->fetch($sTemplateFilename);

        // ページ生成
        $fp = fopen($this->sGenFilename,"w");
        if (!$fp) {
            $this->halt("ERROR: Can not open ".$this->sGenFilename."\n");
            return false;
           
        } else {
            fputs($fp, $sContents);
            fclose($fp);
            return true;
            
        }
    }

    /**
     * エラー処理 - エラーが発生した場合、処理を中断する。
     *
     * @access  public
     * @param   string  $sMsg               エラーメッセージ
    */
    function halt($sMsg) {
        echo "ERROR: Generating ".$this->sGenFilename.".\n";
        if (isset($sMsg)) {
            echo "$sMsg\n";
    
        }
        
        exit;
        
    }

    /**
     * エラーページ表示 - エラー原因を表示する
     *
     * @access  public
     * @param   string  $sMsg               エラーメッセージ
     * @param   string  $sTemplates         テンプレートファイル
     */
    function show_error($sMsg, $sTemplate) {
        $this->assign("message", $sMsg);
        $this->display($sTemplate);
        exit;
        
    }
    
}
?>

