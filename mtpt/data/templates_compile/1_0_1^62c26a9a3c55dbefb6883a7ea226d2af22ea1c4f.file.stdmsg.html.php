<?php /* Smarty version Smarty-3.1.13, created on 2013-12-12 08:21:20
         compiled from "E:\Apache\www\mtpt\templates\default\stdmsg.html" */ ?>
<?php /*%%SmartyHeaderCode:2019352a97200336f25-25416919%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '62c26a9a3c55dbefb6883a7ea226d2af22ea1c4f' => 
    array (
      0 => 'E:\\Apache\\www\\mtpt\\templates\\default\\stdmsg.html',
      1 => 1386836477,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2019352a97200336f25-25416919',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'heading' => 0,
    'text' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52a9720038c170_15568513',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a9720038c170_15568513')) {function content_52a9720038c170_15568513($_smarty_tpl) {?><table align="center" class="main" width="500" border="0" cellpadding="0" cellspacing="0"><tr><td class="embedded">
	<?php if ($_smarty_tpl->tpl_vars['heading']->value!=''){?>
	<h2><?php echo $_smarty_tpl->tpl_vars['heading']->value;?>
</h2>
	<?php }?>
	<table width="100%" border="1" cellspacing="0" cellpadding="10"><tr><td class="text">
	<?php echo $_smarty_tpl->tpl_vars['text']->value;?>

	</td></tr></table></td></tr></table>
<?php }} ?>