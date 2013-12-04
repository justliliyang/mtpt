<?php
/**
* @date 2013-12-4 下午7:33:21
* @describe 网站header部分
*/
require_once ('include/bittorrent.php');
global $lang_functions;
global $CURUSER, $CURLANGDIR, $USERUPDATESET, $iplog1, $oldip, $SITE_ONLINE, $FUNDS, $SITENAME, $SLOGAN, $logo_main, $BASEURL, $offlinemsg, $showversion,$enabledonation, $staffmem_class, $titlekeywords_tweak, $metakeywords_tweak, $metadescription_tweak, $cssdate_tweak, $deletenotransfertwo_account, $neverdelete_account, $iniupload_main;
global $tstart;
global $Cache;
global $Advertisement;
$Cache->setLanguage($CURLANGDIR);
$title=$lang_index['head_home'];
$Advertisement = new ADVERTISEMENT($CURUSER['id']);

$cssupdatedate = $cssdate_tweak;
// Variable for Start Time
$tstart = getmicrotime(); // Start time
//Insert old ip into iplog
if ($CURUSER){
	if ($iplog1 == "yes") {
		if (($oldip != $CURUSER["ip"]) && $CURUSER["ip"])
			sql_query("INSERT INTO iplog (ip, userid, access) VALUES (" . sqlesc($CURUSER['ip']) . ", " . $CURUSER['id'] . ", '" . $CURUSER['last_access'] . "')");
	}
	$USERUPDATESET[] = "last_access = ".sqlesc(date("Y-m-d H:i:s"));
	$USERUPDATESET[] = "ip = ".sqlesc($CURUSER['ip']);
}
header("Content-Type: text/html; charset=utf-8; Cache-control:private");
//header("Pragma: No-cache");
if ($title == "")
	$title = $SITENAME;
else
	$title = $SITENAME." :: " . htmlspecialchars($title);
if ($titlekeywords_tweak)
	$title .= " ".htmlspecialchars($titlekeywords_tweak);
$title .= $showversion;
if ($SITE_ONLINE == "no") {
	if (get_user_class() < UC_ADMINISTRATOR) {
		die($lang_functions['std_site_down_for_maintenance']);
	}
	else
	{
		$offlinemsg = true;
	}
}
$smarty->assign("title",$title);
$smarty->assign("metakeywords_tweak",htmlspecialchars($metakeywords_tweak));
$smarty->assign("metadescription_tweak",htmlspecialchars($metadescription_tweak));
$smarty->assign("project_name",PROJECTNAME);
$smarty->assign("style_addicode",get_style_addicode());
$css_uri = get_css_uri();
$smarty->assign("css_uri",$css_uri);
$cssupdatedate=($cssupdatedate ? "?".htmlspecialchars($cssupdatedate) : "");
$smarty->assign("cssupdatedate",$cssupdatedate);
$smarty->assign("site_name",$SITENAME);
$smarty->assign("font_css_uri",get_font_css_uri());
$smarty->assign("forum_pic_folder",get_forum_pic_folder());
if ($CURUSER){
	$caticonrow = get_category_icon_row($CURUSER['caticon']);
$smarty->assign("css_file",htmlspecialchars($caticonrow['cssfile']));
	}else{
$smarty->assign("css_file","");	
	}

$smarty->assign("logo_main",$logo_main);
$smarty->assign("slogan",htmlspecialchars($SLOGAN));

if ($Advertisement->enable_ad()){
		$headerad=$Advertisement->get_ad('header');
		if ($headerad){
			$smarty->assign("headerad",$headerad[0]);
		}
}else{
	$smarty->assign("headerad","");
}
$smarty->assign("enabledonation",$enabledonation);
$smarty->assign("cur_user",$CURUSER);
$smarty->assign("lang_function",array('text_login'=>$lang_functions['text_login'],'text_signupcard'=>$lang_functions['text_signupcard'],'text_signupcard'=>$lang_functions['text_signupcard'],'text_invite_reg'=>$lang_functions['text_invite_reg'],'text_signup'=>$lang_functions['text_signup']));
$smarty->display(MTPTTEMPLATES."/header.html");
exit;
?>
<?php if (!$CURUSER) { ?>
			<a href="login.php"><font class="big"><b><?php echo $lang_functions['text_login'] ?></b></font></a>  ｜ <a href="signupcard.php"><font class="big"><b><?php echo $lang_functions['text_signupcard'] ?></b></font></a> ｜ <a href="signup.php?type=invite"><font class="big"><b><?php echo $lang_functions['text_invite_reg'] ?></b></font></a> ｜ <a href="signup.php"><font class="big"><b><?php echo $lang_functions['text_signup'] ?></b></font></a>  ｜ <a href="invitebox.php"><font class="big"><b>邀请申请区</b></font></a>
<?php } 
else {
	begin_main_frame();
	menu ();
	end_main_frame();

	$datum = getdate();
	$datum["hours"] = sprintf("%02.0f", $datum["hours"]);
	$datum["minutes"] = sprintf("%02.0f", $datum["minutes"]);
	$ratio = get_ratio($CURUSER['id']);

	//// check every 15 minutes //////////////////
	$messages = $Cache->get_value('user_'.$CURUSER["id"].'_inbox_count');
	if ($messages == ""){
		$messages = get_row_count("messages", "WHERE receiver=" . sqlesc($CURUSER["id"]) . " AND location<>0");
		$Cache->cache_value('user_'.$CURUSER["id"].'_inbox_count', $messages, 900);
	}
	$outmessages = $Cache->get_value('user_'.$CURUSER["id"].'_outbox_count');
	if ($outmessages == ""){
		$outmessages = get_row_count("messages","WHERE sender=" . sqlesc($CURUSER["id"]) . " AND saved='yes'");
		$Cache->cache_value('user_'.$CURUSER["id"].'_outbox_count', $outmessages, 900);
	}
	if (!$connect = $Cache->get_value('user_'.$CURUSER["id"].'_connect')){
		$res3 = sql_query("SELECT connectable FROM peers WHERE userid=" . sqlesc($CURUSER["id"]) . " LIMIT 1");
		if($row = mysql_fetch_row($res3))
			$connect = $row[0];
		else $connect = 'unknown';
		$Cache->cache_value('user_'.$CURUSER["id"].'_connect', $connect, 900);
	}

	if($connect == "yes")
		$connectable = "<b><font color=\"green\">".$lang_functions['text_yes']."</font></b>";
	elseif ($connect == 'no')
		$connectable = "<a href=\"faq.php#id21\"><b><font color=\"red\">".$lang_functions['text_no']."</font></b></a>";
	else
		$connectable = $lang_functions['text_unknown'];

	//// check every 60 seconds //////////////////
	$activeseed = $Cache->get_value('user_'.$CURUSER["id"].'_active_seed_count');
	if ($activeseed == ""){
		$activeseed = get_row_count("peers","WHERE userid=" . sqlesc($CURUSER["id"]) . " AND seeder='yes'");
		$Cache->cache_value('user_'.$CURUSER["id"].'_active_seed_count', $activeseed, 60);
	}
	$activeleech = $Cache->get_value('user_'.$CURUSER["id"].'_active_leech_count');
	if ($activeleech == ""){
		$activeleech = get_row_count("peers","WHERE userid=" . sqlesc($CURUSER["id"]) . " AND seeder='no'");
		$Cache->cache_value('user_'.$CURUSER["id"].'_active_leech_count', $activeleech, 60);
	}
	$unread = $Cache->get_value('user_'.$CURUSER["id"].'_unread_message_count');
	if ($unread == ""){
		$unread = get_row_count("messages","WHERE receiver=" . sqlesc($CURUSER["id"]) . " AND unread='yes'");
		$Cache->cache_value('user_'.$CURUSER["id"].'_unread_message_count', $unread, 60);
	}
	
	$inboxpic = "<img class=\"".($unread ? "inboxnew" : "inbox")."\" src=\"pic/trans.gif\" alt=\"inbox\" title=\"".($unread ? $lang_functions['title_inbox_new_messages'] : $lang_functions['title_inbox_no_new_messages'])."\" />";
if($connect == 'no'){
	if(!$Cache->get_value('connectfaq_'.$CURUSER['id'])){
/*
?>
<script type="text/javascript">
	jAlert('<?=$lang_functions['text_connectfaq']?>');
</script>
<?
*/
	$Cache->cache_value('connectfaq_'.$CURUSER['id'],'1',60);
	}
}
?>
<table id="info_block" cellpadding="4" cellspacing="0" border="0" width="100%"><tr>
	<td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
		<td class="bottom" align="left"><span class="medium"><?php echo $lang_functions['text_welcome_back'] ?>, <?php echo get_username($CURUSER['id'])?>  [<a href="logout.php"><?php echo $lang_functions['text_logout'] ?></a>]<?php if (get_user_class() == UC_UPLOADER) echo"[<a href='uploaders.php'>发布员考核</a>]";if (get_user_class() == UC_MODERATOR) echo"[<a href='moderators.php'>管理员考核</a>]";?> <?php if (get_user_class() >= UC_MODERATOR) { ?>[<a href="staffpanel.php"><?php echo $lang_functions['text_staff_panel'] ?></a>] <?php }?> <?php if (get_user_class() >= UC_SYSOP) { ?> [<a href="settings.php"><?php echo $lang_functions['text_site_settings'] ?></a>]<?php } ?> [<a href="torrents.php?inclbookmarked=1&amp;allsec=1&amp;incldead=0"><?php echo $lang_functions['text_bookmarks'] ?></a>] <font class = 'color_bonus'><?php echo $lang_functions['text_bonus'] ?></font>[<a href="mybonus.php"><?php echo $lang_functions['text_use'] ?></a>丨<a href="usebonus.php"><?=$lang_functions['text_app']?></a>]: <?php echo number_format((int)$CURUSER['seedbonus'], 0)?> <font class = 'color_invite'><?php echo $lang_functions['text_invite'] ?></font>[<a href="invite.php?id=<?php echo $CURUSER['id']?>"><?php echo $lang_functions['text_send'] ?></a>]: <?php echo $CURUSER['invites']?><br />

	<font class="color_ratio"><?php echo $lang_functions['text_ratio'] ?></font> <?php echo $ratio?> 
	<font class='color_uploaded'><?php echo $lang_functions['text_uploaded'] ?></font> <?php echo mksize($CURUSER['uploaded'])?>
	<font class='color_downloaded'> <?php echo $lang_functions['text_downloaded'] ?></font> <?php echo mksize($CURUSER['downloaded'])?> 
	<font class='color_active'><?php echo $lang_functions['text_active_torrents'] ?></font> <a href="userdetails.php?id=<?php echo $CURUSER['id'];?>&show=seeding"><img class="uploading" alt="Torrents seeding" title="<?php echo $lang_functions['title_torrents_seeding'] ?>"  src="pic/trans.gif" /><?php echo $activeseed?></a> 
	<a href="userdetails.php?id=<?php echo $CURUSER['id'];?>&show=leeching"><img class="downloading" alt="Torrents leeching" title="<?php echo $lang_functions['title_torrents_leeching'] ?>" src="pic/trans.gif" /><?php echo $activeleech?></a>
	<a href="userdetails.php?id=<?php echo $CURUSER['id'];?>&show=completed" title="已完成"><img class="completed" alt="completed" title="已完成"  src="pic/trans.gif" />--</a>
	<a href="userdetails.php?id=<?php echo $CURUSER['id'];?>&show=uploaded" title="已发布"><img class="uploaded" alt="uploaded" title="已发布"  src="pic/trans.gif" />--</a>
	<font class='color_connectable'><?php echo $lang_functions['text_connectable'] ?></font><?php echo $connectable?> <?php //echo maxslots();?></span></td>

	<td class="bottom" align="right"><span class="medium"><?php echo $lang_functions['text_the_time_is_now'] ?><?php echo $datum[hours].":".$datum[minutes]?><br />

<?php
	if (get_user_class() >= $staffmem_class){
	$totalreports = $Cache->get_value('staff_report_count');
	if ($totalreports == ""){
		$totalreports = get_row_count("reports");
		$Cache->cache_value('staff_report_count', $totalreports, 900);
	}
	$totalsm = $Cache->get_value('staff_message_count');
	if ($totalsm == ""){
		$totalsm = get_row_count("staffmessages");
		$Cache->cache_value('staff_message_count', $totalsm, 900);
	}
	$totalcheaters = $Cache->get_value('staff_cheater_count');
	if ($totalcheaters == ""){
		$totalcheaters = get_row_count("cheaters");
		$Cache->cache_value('staff_cheater_count', $totalcheaters, 900);
	}
	print("<a href=\"cheaterbox.php\"><img class=\"cheaterbox\" alt=\"cheaterbox\" title=\"".$lang_functions['title_cheaterbox']."\" src=\"pic/trans.gif\" />  </a>".$totalcheaters."  <a href=\"reports.php\"><img class=\"reportbox\" alt=\"reportbox\" title=\"".$lang_functions['title_reportbox']."\" src=\"pic/trans.gif\" />  </a>".$totalreports."  <a href=\"staffbox.php\"><img class=\"staffbox\" alt=\"staffbox\" title=\"".$lang_functions['title_staffbox']."\" src=\"pic/trans.gif\" />  </a>".$totalsm."  ");
	}

	print("<a href=\"messages.php\">".$inboxpic."</a> ".($messages ? $messages." (".$unread.$lang_functions['text_message_new'].")" : "0"));
	print("  <a href=\"messages.php?action=viewmailbox&amp;box=-1\"><img class=\"sentbox\" alt=\"sentbox\" title=\"".$lang_functions['title_sentbox']."\" src=\"pic/trans.gif\" /></a> ".($outmessages ? $outmessages : "0"));
	print(" <a href=\"friends.php\"><img class=\"buddylist\" alt=\"Buddylist\" title=\"".$lang_functions['title_buddylist']."\" src=\"pic/trans.gif\" /></a>");
	print(" <a href=\"getrss.php\"><img class=\"rss\" alt=\"RSS\" title=\"".$lang_functions['title_get_rss']."\" src=\"pic/trans.gif\" /></a>");
?>

	</span></td>
	</tr></table></td>
</tr></table>

</td></tr>

<tr><td id="outer" align="center" class="outer" style="padding-top: 20px; padding-bottom: 20px">
<?php
//每日登陆奖励
global $loginadd;require "./memcache.php";
if($loginadd == 'yes'){
if($memcache){
	if($memcache->get('continuelogin_'.$CURUSER['id'])!='1'){
	$res = sql_query("SELECT salary,salarynum FROM users WHERE id=".$CURUSER['id']) or sqlerr();
    $arr = mysql_fetch_assoc($res);
    $showtime=date("Y-m-d",time());
	$d1=strtotime($showtime);
	$d2=strtotime($arr['salary']);
	$Days=round(($d1-$d2)/3600/24);
  
		$addbonus = 4;
if($Days == 1){
	$salarynum = $arr['salarynum'];
	if($salarynum > 7) 
	{$addbonus= 15;}
	else
	$addbonus = $salarynum + 4;
	mysql_query("UPDATE users SET seedbonus=seedbonus+$addbonus , salary=now(), salarynum=salarynum + 1 WHERE id=".$CURUSER['id']);
?>
<script type="text/javascript">
	jAlert('<font color=red>连续登录<?=$salarynum?>天奖励，恭喜你获取了<?=$addbonus?>点麦粒，继续保持哦</font>', '每日登录奖励');
</script>
<?
}else if($Days > 0){
	mysql_query("UPDATE users SET seedbonus=seedbonus+$addbonus , salary=now(), salarynum=1 WHERE id=".$CURUSER['id']);
?>
<script type="text/javascript">
	jAlert('<font color=red>每日登录奖励，恭喜你获取了<?=$addbonus?>点麦粒，连续多天登录会有更多奖励哦</font>', '每日登录奖励');
</script>
<?
		}
	}
	$memcache->set('continuelogin_'.$CURUSER['id'],'1',false,3600) or die ("");
}}


	if ($Advertisement->enable_ad()){
			$belownavad=$Advertisement->get_ad('belownav');
			if ($belownavad)
			echo "<div align=\"center\" style=\"margin-bottom: 10px\" id=\"ad_belownav\">".$belownavad[0]."</div>";
	}

//信息色块提示
if ($msgalert)
{
	function msgalert($url, $text, $bgcolor = "red")
	{
		print("<p><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td style='border: none; padding: 9px; background: ".$bgcolor."'>\n");
		print("<b><a href=\"".$url."\"><font face=\"verdana\" size=\"3\" color=\"white\">".$text."</font></a></b>");
		print("</td></tr></table></p><br />");//修改于2011-11-23 @zhaojiajia
	}
	if($CURUSER['leechwarn'] == 'yes')
	{
		$kicktimeout = gettime($CURUSER['leechwarnuntil'], false, false, true);
		$text = $lang_functions['text_please_improve_ratio_within'].$kicktimeout.$lang_functions['text_or_you_will_be_banned'];
		msgalert("faq.php#id17", $text, "orange");
	}
	if($deletenotransfertwo_account) //inactive account deletion notice
	{
		if ($CURUSER['downloaded'] == 0 && ($CURUSER['uploaded'] == 0 || $CURUSER['uploaded'] == $iniupload_main))
		{
			$neverdelete_account = ($neverdelete_account <= UC_VIP ? $neverdelete_account : UC_VIP);
			if (get_user_class() < $neverdelete_account)
			{
				$secs = $deletenotransfertwo_account*24*60*60;
				$addedtime = strtotime($CURUSER['added']);
				if (TIMENOW > $addedtime+($secs/3)) // start notification if one third of the time has passed
				{
					$kicktimeout = gettime(date("Y-m-d H:i:s", $addedtime+$secs), false, false, true);
					$text = $lang_functions['text_please_download_something_within'].$kicktimeout.$lang_functions['text_inactive_account_be_deleted'];
					msgalert("rules.php", $text, "gray");
				}
			}
		}
	}
	if($CURUSER['showclienterror'] == 'yes')
	{
		$text = $lang_functions['text_banned_client_warning'];
		msgalert("faq.php#id29", $text, "black");
	}

	if ($unread) 
	{
		$unreadidres = sql_query("SELECT id FROM messages WHERE receiver=" . sqlesc($CURUSER["id"]) . " AND unread='yes'") or sqlerr(__FILE__,__LINE__);
		$unreadidrow = mysql_fetch_assoc($unreadidres);
		$text = $lang_functions['text_you_have'].$unread.$lang_functions['text_new_message'] . add_s($unread) . $lang_functions['text_click_here_to_read'];
		msgalert("messages.php?action=viewmessage&id=".$unreadidrow['id'],$text, "indigo");
	}

	/* if ($unread) // new message sound reminder,2010-12-23
	{
		$unreadsound = $Cache->get_value("unread_sound_".$CURUSER['id']);
		if($unreadsound != '1'){
		echo "<object type=\"application/x-mplayer2\" data=\"sound/message.wav\" width=\"0\" height=\"0\"> <param name=\"src\" value=\"sound/message.wav\"> <param name=\"autoplay\" value=\"1\"> </object>"; //support ie,firefox,chrome..
		}
		$Cache->cache_value("unread_sound_".$CURUSER['id'], '1', 120);
	}*/


/*
	$pending_invitee = $Cache->get_value('user_'.$CURUSER["id"].'_pending_invitee_count');
	if ($pending_invitee == ""){
		$pending_invitee = get_row_count("users","WHERE status = 'pending' AND invited_by = ".sqlesc($CURUSER[id]));
		$Cache->cache_value('user_'.$CURUSER["id"].'_pending_invitee_count', $pending_invitee, 900);
	}
	if ($pending_invitee > 0)
	{
		$text = $lang_functions['text_your_friends'].add_s($pending_invitee).is_or_are($pending_invitee).$lang_functions['text_awaiting_confirmation'];
		msgalert("invite.php?id=".$CURUSER[id],$text, "red");
	}*/
	$settings_script_name = $_SERVER["SCRIPT_FILENAME"];
	if (!preg_match("/index/i", $settings_script_name))
	{
		$new_news = $Cache->get_value('user_'.$CURUSER["id"].'_unread_news_count');
		if ($new_news == ""){
			$new_news = get_row_count("news","WHERE notify = 'yes' AND added > ".sqlesc($CURUSER['last_home']));
			$Cache->cache_value('user_'.$CURUSER["id"].'_unread_news_count', $new_news, 300);
		}
		if ($new_news > 0)
		{
			$text = $lang_functions['text_there_is'].is_or_are($new_news).$new_news.$lang_functions['text_new_news'];
			msgalert("index.php",$text, "green");
		}
	}

	if (get_user_class() >= $staffmem_class)
	{
		$numreports = $Cache->get_value('staff_new_report_count');
		if ($numreports == ""){
			$numreports = get_row_count("reports","WHERE dealtwith=0");
			$Cache->cache_value('staff_new_report_count', $numreports, 900);
		}
		if ($numreports){
			$text = $lang_functions['text_there_is'].is_or_are($numreports).$numreports.$lang_functions['text_new_report'] .add_s($numreports);
			msgalert("reports.php",$text, "blue");
		}
		$nummessages = $Cache->get_value('staff_new_message_count');
		if ($nummessages == ""){
			$nummessages = get_row_count("staffmessages","WHERE answered='no'");
			$Cache->cache_value('staff_new_message_count', $nummessages, 900);
		}
		if ($nummessages > 0) {
			$text = $lang_functions['text_there_is'].is_or_are($nummessages).$nummessages.$lang_functions['text_new_staff_message'] . add_s($nummessages);
			msgalert("staffbox.php",$text, "blue");
		}
		$numcheaters = $Cache->get_value('staff_new_cheater_count');
		if ($numcheaters == ""){
			$numcheaters = get_row_count("cheaters","WHERE dealtwith=0");
			$Cache->cache_value('staff_new_cheater_count', $numcheaters, 900);
		}
		if ($numcheaters){
			$text = $lang_functions['text_there_is'].is_or_are($numcheaters).$numcheaters.$lang_functions['text_new_suspected_cheater'] .add_s($numcheaters);
			msgalert("cheaterbox.php",$text, "blue");
		}
	}
}
		if ($offlinemsg)
		{
			print("<p><table width=\"737\" border=\"1\" cellspacing=\"0\" cellpadding=\"10\"><tr><td style='padding: 10px; background: red' class=\"text\" align=\"center\">\n");
			print("<font color=\"white\">".$lang_functions['text_website_offline_warning']."</font>");
			print("</td></tr></table></p><br />\n");
		}
}
