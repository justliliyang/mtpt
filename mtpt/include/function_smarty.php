<?php
function stdmsg($heading, $text, $htmlstrip = false)
{
	if ($htmlstrip) {
		$heading = htmlspecialchars(trim($heading));
		$text = htmlspecialchars(trim($text));
	}
	global $smarty;
	$smarty->assign("heading",$heading);
	$smarty->assign("text",$text);
	$content=$smarty->fetch(MTPTTEMPLATES.'/stdmsg.html');
	echo $content;
}

