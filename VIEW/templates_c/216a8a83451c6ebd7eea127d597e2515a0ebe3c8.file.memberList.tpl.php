<?php /* Smarty version Smarty-3.0.7, created on 2011-06-24 04:00:34
         compiled from "C:\xampp\htdocs\mvc_framework\VIEW\common/memberList.tpl" */ ?>
<?php /*%%SmartyHeaderCode:302734e03efc21d3645-62328960%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '216a8a83451c6ebd7eea127d597e2515a0ebe3c8' => 
    array (
      0 => 'C:\\xampp\\htdocs\\mvc_framework\\VIEW\\common/memberList.tpl',
      1 => 1308631662,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '302734e03efc21d3645-62328960',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<table border = 1>
    <tr>
        <td>番号</td>
        <td>カテゴリー</td>
        <td>名前</td>
        <td>アドレス</td>
        <td>詳細</td>
        <td>年齢</td>
        <td>画像</td>
    </tr>
    <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['cell']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['name'] = 'cell';
$_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('memberArray')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['cell']['total']);
?>
    <tr>
        <td><?php echo $_smarty_tpl->getVariable('memberArray')->value[$_smarty_tpl->getVariable('smarty')->value['section']['cell']['index']]['id'];?>
</td>
        <td><?php echo $_smarty_tpl->getVariable('memberArray')->value[$_smarty_tpl->getVariable('smarty')->value['section']['cell']['index']]['category_id'];?>
</td>
        <td><?php echo $_smarty_tpl->getVariable('memberArray')->value[$_smarty_tpl->getVariable('smarty')->value['section']['cell']['index']]['name'];?>
</td>
        <td><?php echo $_smarty_tpl->getVariable('memberArray')->value[$_smarty_tpl->getVariable('smarty')->value['section']['cell']['index']]['address'];?>
</td>
        <td><?php echo $_smarty_tpl->getVariable('memberArray')->value[$_smarty_tpl->getVariable('smarty')->value['section']['cell']['index']]['detail'];?>
</td>
        <td><?php echo $_smarty_tpl->getVariable('memberArray')->value[$_smarty_tpl->getVariable('smarty')->value['section']['cell']['index']]['age'];?>
</td>
        <td><?php echo $_smarty_tpl->getVariable('memberArray')->value[$_smarty_tpl->getVariable('smarty')->value['section']['cell']['index']]['image'];?>
</td>
    </tr>
    <?php endfor; endif; ?>
</table>
<br>
<br>