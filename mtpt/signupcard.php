<?php
require_once("include/bittorrent.php");
dbconn();
require_once(get_langfile_path("", false, $CURLANGDIR));
cur_user_check ();
registration_check("cardreg");
failedloginscheck ("Signup");
$emailnotice = ($restrictemaildomain == 'yes' ? $lang_signup['text_email_note'].allowedemails() : "");
$smarty->assign("$emailnotice",$$emailnotice);

$select = 'signupcard';
$smarty->assign("select",$select);
$smarty->assign("show",'yes');
$signuplist = $smarty->fetch(MTPTTEMPLATES.'/signuplist.html');
$smarty->assign("signuplist",$signuplist);

$smarty->display(MTPTTEMPLATES.'/signupcard.html');
stdfoot();
