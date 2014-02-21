<?php
require_once("include/bittorrent.php");
dbconn();

$langid = 0 + $_GET['sitelanguage'];
if ($langid)
{
	$lang_folder = validlang($langid);
	if(get_langfolder_cookie() != $lang_folder)
	{
		set_langfolder_cookie($lang_folder);
		header("Location: " . $_SERVER['PHP_SELF']);
	}
}
require_once(get_langfile_path("", false, $CURLANGDIR));

failedloginscheck ();
cur_user_check () ;


unset($returnto);
if (!empty($_GET["returnto"])) {
	$returnto = $_GET["returnto"];
	if (!$_GET["nowarn"]) {
		print("<h1>" . $lang_login['h1_not_logged_in']. "</h1>\n");
		print("<p><b>" . $lang_login['p_error']. "</b> " . $lang_login['p_after_logged_in']. "</p>\n");
	}
}

//show_image_code ();

//stdhead($lang_login['head_login']);
$select = 'login';
$smarty->assign("select",$select);
$smarty->assign("show",'no');
$signuplist = $smarty->fetch(MTPTTEMPLATES.'/signuplist.html');
$smarty->assign("signuplist",$signuplist);

$smarty->assign("returnto",$returnto);
$smarty->assign("showhelpbox_main",$showhelpbox_main);
$smarty->assign("BASEURL",$BASEURL);
$smarty->assign("prefix",get_protocol_prefix());
$smarty->assign("smtptype",$smtptype);
$smarty->display(MTPTTEMPLATES.'/login.html');
stdfoot();
?>
