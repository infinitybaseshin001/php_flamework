<?php
/**
 *  Index.php
 *
 *  @author    {$author}
 *  @package   Exam
 *  @version   $Id: app.action.default.php 387 2006-11-06 14:31:24Z cocoitiban $
 */

/**
 *  index�t�H�[���̎���
 *
 *  @author    {$author}
 *  @access    public
 *  @package   Exam
 */

class Exam_Form_Index extends Exam_ActionForm
{
    /** @var    bool    �o���f�[�^�Ƀv���O�C�����g���t���O */
    var $use_validator_plugin = false;

    /**
     *  @access   private
     *  @var      array   �t�H�[���l��`
     */
     var $form = array(
       /*
        *  TODO: ���̃A�N�V�������g�p����t�H�[�����L�q���Ă�������
        *
        *  �L�q��(type�������S�Ă̗v�f�͏ȗ��\)�F
        *
        *  'sample' => array(
        *  // �t�H�[���̒�`
        *      'type'        => VAR_TYPE_INT,        // ���͒l�^
        *      'form_type'   => FORM_TYPE_TEXT,      // �t�H�[���^
        *      'name'        => '�T���v��',          // �\����
        *  
        *  // �o���f�[�^(�L�q���Ƀo���f�[�^�����s����܂�)
        *      'required'    => true,                        // �K�{�I�v�V����(true/false)
        *      'min'         => null,                        // �ŏ��l
        *      'max'         => null,                        // �ő�l
        *      'regexp'      => null,                        // ������w��(���K�\��)
        *
        *  // �t�B���^
        *      'filter'      => null,                        // ���͒l�ϊ��t�B���^�I�v�V����
        *  ),
        */
      );
}

/**
 *  index�A�N�V�����̎���
 *
 *  @author     {$author}
 *  @access     public
 *  @package    Exam
 */
class Exam_Action_search_Index extends Exam_ActionClass
{
        /**
         *  index�A�N�V�����̑O����
         *
         *  @access    public
         *  @return    string  Forward��(����I���Ȃ�null)
         */
        function prepare()
        {
                return null;
        }

        /**
         *  index�A�N�V�����̎���
         *
         *  @access    public
         *  @return    string  �J�ږ�
         */
        function perform()
        {
                return 'index';
        }
}
?>
