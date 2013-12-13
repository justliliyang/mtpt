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
	$content=$smarty->fetch(MTPTTEMPLATES.'/function_smarty/stdmsg.html');
	echo $content;
}
function begin_main_frame($caption = "", $center = false, $width = 100)
{
	$tdextra = "";
	if ($center)
	$tdextra .= " align=\"center\"";
	$width = 940 * $width /100;
	$smarty->assign("tdextra",$tdextra);
	$smarty->assign("caption",$caption);
	$smarty->assign("width",$width);
	$smarty->display(FUNCTIONSMARTY.'/begin_main_frame.html');
}
function end_main_frame()
{
	$smarty->display(FUNCTIONSMARTY.'/end_main_frame.html');
}
function begin_frame($caption = "", $center = false, $padding = 10, $width="100%", $caption_center="left")
{
	$tdextra = "";
	if ($center)
	$tdextra .= " align=\"center\"";
	$smarty->assign("caption",$caption);
	$smarty->assign("caption_center",$caption_center);
	$smarty->assign("width",$width);
	$smarty->assign("padding",$padding);
	$smarty->assign("tdextra",$tdextra);
	$smarty->display(FUNCTIONSMARTY.'/begin_frame.html');
}
function end_frame()
{
	$smarty->display(FUNCTIONSMARTY.'/end_frame.html');
}
function begin_table($fullwidth = false, $padding = 5)
{
	$width = "";
	if ($fullwidth)
	$width .= " width=50%";
	$smarty->assign("width",$width);
	$smarty->assign("padding",$padding);
	$smarty->display(FUNCTIONSMARTY.'/begin_table.html');
}
function end_table()
{
	$smarty->display(FUNCTIONSMARTY.'/end_table.html');
}

function tr($x,$y,$noesc=0,$relation='') {
	if ($noesc)
	$a = $y;
	else {
		$a = htmlspecialchars($y);
		$a = str_replace("\n", "<br />\n", $a);
	}
	$smarty->assign("relation",$relation);
	$smarty->assign("x",$x);
	$smarty->assign("a",$a);
	$smarty->display(FUNCTIONSMARTY.'/tr.html');
}
function tr_small($x,$y,$noesc=0,$relation='') {
	if ($noesc)
	$a = $y;
	else {
		$a = htmlspecialchars($y);
		//$a = str_replace("\n", "<br />\n", $a);
	}
	$smarty->assign("relation",$relation);
	$smarty->assign("v",$v);
	$smarty->assign("a",$a);
	$smarty->display(FUNCTIONSMARTY.'/tr_small.html');
}

