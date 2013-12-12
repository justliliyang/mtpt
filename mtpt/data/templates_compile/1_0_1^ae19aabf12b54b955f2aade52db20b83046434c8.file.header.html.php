<?php /* Smarty version Smarty-3.1.13, created on 2013-12-11 13:36:41
         compiled from "E:\Apache\www\mtpt\templates\default\header.html" */ ?>
<?php /*%%SmartyHeaderCode:203152a86a69b8ff84-30639317%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ae19aabf12b54b955f2aade52db20b83046434c8' => 
    array (
      0 => 'E:\\Apache\\www\\mtpt\\templates\\default\\header.html',
      1 => 1386164814,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '203152a86a69b8ff84-30639317',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'metakeywords_tweak' => 0,
    'metakeywords' => 0,
    'metadescription_tweak' => 0,
    'projec_tname' => 0,
    'style_addicode' => 0,
    'title' => 0,
    'site_name' => 0,
    'font_css_uri' => 0,
    'cssupdatedate' => 0,
    'forum_pic_folder' => 0,
    'css_uri' => 0,
    'css_file' => 0,
    'logo_main' => 0,
    'slogan' => 0,
    'headerad' => 0,
    'enabledonation' => 0,
    'cur_user' => 0,
    'lang_function' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_52a86a69edbe57_00783539',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52a86a69edbe57_00783539')) {function content_52a86a69edbe57_00783539($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if ($_smarty_tpl->tpl_vars['metakeywords_tweak']->value!=''){?>
<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['metakeywords']->value;?>
" />
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['metadescription_tweak']->value!=''){?>
<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['metadescription_tweak']->value;?>
" />
<?php }?>
<meta name="generator" content="<?php echo $_smarty_tpl->tpl_vars['projec_tname']->value;?>
" />
<?php echo $_smarty_tpl->tpl_vars['style_addicode']->value;?>

<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<link rel="search" type="application/opensearchdescription+xml" title="<?php echo $_smarty_tpl->tpl_vars['site_name']->value;?>
 Torrents" href="opensearch.php" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['font_css_uri']->value;?>
<?php echo $_smarty_tpl->tpl_vars['cssupdatedate']->value;?>
" type="text/css" />
<link rel="stylesheet" href="styles/sprites.css<?php echo $_smarty_tpl->tpl_vars['cssupdatedate']->value;?>
" type="text/css" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['forum_pic_folder']->value;?>
/forumsprites.css<?php echo $_smarty_tpl->tpl_vars['cssupdatedate']->value;?>
" type="text/css" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['css_uri']->value;?>
theme.css<?php echo $_smarty_tpl->tpl_vars['cssupdatedate']->value;?>
" type="text/css" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['css_uri']->value;?>
DomTT.css<?php echo $_smarty_tpl->tpl_vars['cssupdatedate']->value;?>
" type="text/css" />
<link rel="stylesheet" href="styles/curtain_imageresizer.css<?php echo $_smarty_tpl->tpl_vars['cssupdatedate']->value;?>
" type="text/css" />
<link rel="stylesheet" href="jquerylib/jquery.alerts.css<?php echo $_smarty_tpl->tpl_vars['cssupdatedate']->value;?>
" type="text/css" />
<?php if ($_smarty_tpl->tpl_vars['css_file']->value!=''){?>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['css_file']->value;?>
<?php echo $_smarty_tpl->tpl_vars['cssupdatedate']->value;?>
" type="text/css" />
<?php }?>
<link rel="alternate" type="application/rss+xml" title="Latest Torrents" href="torrentrss.php" />
<script type="text/javascript" src="curtain_imageresizer.js<?php echo $_smarty_tpl->tpl_vars['cssupdatedate']->value;?>
"></script>
<script type="text/javascript" src="ajaxbasic.js<?php echo $_smarty_tpl->tpl_vars['cssupdatedate']->value;?>
"></script>
<script type="text/javascript" src="common.js<?php echo $_smarty_tpl->tpl_vars['cssupdatedate']->value;?>
"></script>
<script type="text/javascript" src="domLib.js<?php echo $_smarty_tpl->tpl_vars['cssupdatedate']->value;?>
"></script>
<script type="text/javascript" src="domTT.js<?php echo $_smarty_tpl->tpl_vars['cssupdatedate']->value;?>
"></script>
<script type="text/javascript" src="domTT_drag.js<?php echo $_smarty_tpl->tpl_vars['cssupdatedate']->value;?>
"></script>
<script type="text/javascript" src="fadomatic.js<?php echo $_smarty_tpl->tpl_vars['cssupdatedate']->value;?>
"></script>
<script type="text/javascript" src="jquerylib/jquery-1.5.2.min.js<?php echo $_smarty_tpl->tpl_vars['cssupdatedate']->value;?>
"></script>
<script type="text/javascript" src="jquerylib/jquery.alerts.js<?php echo $_smarty_tpl->tpl_vars['cssupdatedate']->value;?>
"></script>
<script type="text/javascript" src="jquerylib/jquery.ui.draggable.js<?php echo $_smarty_tpl->tpl_vars['cssupdatedate']->value;?>
"></script>
<script type="text/javascript" src="jquerylib/jquery.caretInsert.js<?php echo $_smarty_tpl->tpl_vars['cssupdatedate']->value;?>
"></script>
<link rel="stylesheet" href="userAutoTips.css" type="text/css" />
<style type="text/css">
html body {
_background-image:url(about:blank);
_background-attachment:fixed;
}
#roll_top,#roll_bottom {
    position:relative;
    cursor:pointer;
    height:52px;
    width:50px;
    }
#roll_top {
    background:url(pic/up.png) no-repeat;
    }
#roll_bottom {
    background:url(pic/up.png) no-repeat 0 -52px;
    }
#roll {
    display:block;
    width:50px;
    margin-right:-546px;  /*这个是距离的位置，请自行调整*/
    position:fixed;
    right:50%;
    top:80%;
    _margin-right:-545px;/*Hack IE6的，请用IE6打开自行调整*/
    _position:absolute;
    _margin-top:300px;
    _top:expression(eval(document.documentElement.scrollTop));
    }
</style>
<script type="text/javascript" src="userAutoTips.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#roll_top').click(function(){$('html,body').animate({scrollTop: '0px'}, 800);});
	$('#roll_bottom').click(function(){$('html,body').animate({scrollTop:$('#footer').offset().top}, 800);});
	t_ids = $('textarea');
	if(t_ids)
	{
		for(var i = 0 ;i<t_ids.length;i++)
		{
			userAutoTips({id:t_ids[i].id});
		}	
	}
	$('#roll_top').click(function(){$('html,body').animate({scrollTop: '0px'}, 800);});
	$('#roll_bottom').click(function(){$('html,body').animate({scrollTop:$('#footer').offset().top}, 800);});
});
</script>

</head>
<body>

<div id="roll"><div title="回到顶部" id="roll_top"></div><div title="转到底部" id="roll_bottom"></div></div>
<table class="head" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td class="clear">
<?php if ($_smarty_tpl->tpl_vars['logo_main']->value!=''){?>
			<div class="logo"><?php echo $_smarty_tpl->tpl_vars['site_name']->value;?>
</div>
			<div class="slogan"><?php echo $_smarty_tpl->tpl_vars['slogan']->value;?>
</div>
<?php }else{ ?>
			<div class="logo_img"><img src="<?php echo $_smarty_tpl->tpl_vars['logo_main']->value;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['site_name']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['site_name']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['slogan']->value;?>
" /></div>
<?php }?>
        </td>
		<td class="clear nowrap" align="right" valign="middle">
<?php if ($_smarty_tpl->tpl_vars['headerad']->value!=''){?>
        <span id="ad_header"><?php echo $_smarty_tpl->tpl_vars['headerad']->value;?>
</span>			
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['enabledonation']->value=="yes"){?>
		<a href="donate.php"><img src="<?php echo $_smarty_tpl->tpl_vars['forum_pic_folder']->value;?>
/donate.gif" alt="Make a donation" style="margin-left: 5px; margin-top: 50px;" /></a>
<?php }?>

		</td>
	</tr>
</table>

<table class="mainouter" width="982" cellspacing="0" cellpadding="5" align="center">
	<tr><td id="nav_block" class="text" align="center">
<?php if ($_smarty_tpl->tpl_vars['cur_user']->value==''){?>
<a href="login.php"><font class="big"><b><?php echo $_smarty_tpl->tpl_vars['lang_function']->value['text_login'];?>
</b></font></a>  ｜ <a href="signupcard.php"><font class="big"><b><?php echo $_smarty_tpl->tpl_vars['lang_function']->value['text_signupcard'];?>
</b></font></a> ｜ <a href="signup.php?type=invite"><font class="big"><b><?php echo $_smarty_tpl->tpl_vars['lang_function']->value['text_invite_reg'];?>
</b></font></a> ｜ <a href="signup.php"><font class="big"><b><?php echo $_smarty_tpl->tpl_vars['lang_function']->value['text_signup'];?>
</b></font></a>  ｜ <a href="invitebox.php"><font class="big"><b>邀请申请区</b></font></a>
<?php }else{ ?>
<table class="main" width="100" border="0" cellspacing="0" cellpadding="0">
	<tr><td class="embedded">
<?php }?>
<?php }} ?>