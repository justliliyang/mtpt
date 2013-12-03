<?php
/**
* @describe smarty模版的一个简单示例
*/
require "include/bittorrent.php";//该文件中对smarty相关参数做了配置
$title="smarty模版的一个简单示例";
$smarty->assign("title",$title);
$name=array("张三","李四","王五");
$smarty->assign("name",$name);
$letter=array(array("A","B","C","D"), array("E", "F", "G", "H"),array("I", "J", "K", "L"), array("M", "N", "O", "P"));
$smarty->assign("letter",$letter);
$smarty->display(MTPTTEMPLATES."/demo.html");
?>

