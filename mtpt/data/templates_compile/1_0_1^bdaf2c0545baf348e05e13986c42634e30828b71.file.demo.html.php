<?php /* Smarty version Smarty-3.1.13, created on 2013-12-03 10:12:16
         compiled from "E:\Apache\www\mtpt\templates\default\demo.html" */ ?>
<?php /*%%SmartyHeaderCode:32160529dae80370e19-79161566%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bdaf2c0545baf348e05e13986c42634e30828b71' => 
    array (
      0 => 'E:\\Apache\\www\\mtpt\\templates\\default\\demo.html',
      1 => 1386065454,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '32160529dae80370e19-79161566',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'name' => 0,
    'k' => 0,
    'letter' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_529dae803e5108_79066597',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_529dae803e5108_79066597')) {function content_529dae803e5108_79066597($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
</head>
<body>
<ul>
<?php  $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['k']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['name']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['k']->key => $_smarty_tpl->tpl_vars['k']->value){
$_smarty_tpl->tpl_vars['k']->_loop = true;
?>
<li><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
</li>
<?php } ?>
</ul>


<ul>
<?php  $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['k']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['letter']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['k']->key => $_smarty_tpl->tpl_vars['k']->value){
$_smarty_tpl->tpl_vars['k']->_loop = true;
?>
<li>
<ul>
<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['k']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
<li><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</li>
<?php } ?>
</ul>
</li>
<?php } ?>

</ul>
</body>
</html><?php }} ?>