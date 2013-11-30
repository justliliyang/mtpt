<?php
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");

require_once("include/bittorrent.php");
dbconn();
require_once(get_langfile_path());
loggedinorreturn();
parked();

//if ($CURUSER["uploadpos"] == 'no')
	//stderr($lang_upload['std_sorry'], $lang_upload['std_unauthorized_to_upload'],false);

if ($enableoffer == 'yes')
	$has_allowed_offer = get_row_count("offers","WHERE allowed='allowed' AND userid = ". sqlesc($CURUSER["id"]));
else $has_allowed_offer = 0;
$uploadfreely = user_can_upload("torrents");
$allowtorrents = ($has_allowed_offer || $uploadfreely)||true;
$allowspecial = user_can_upload("music");

//if (!$allowtorrents && !$allowspecial)
//	stderr($lang_upload['std_sorry'],$lang_upload['std_please_offer'],false);
$allowtwosec = ($allowtorrents && $allowspecial);

$brsectiontype = $browsecatmode;
$spsectiontype = $specialcatmode;
$showsource = (($allowtorrents && get_searchbox_value($brsectiontype, 'showsource')) || ($allowspecial && get_searchbox_value($spsectiontype, 'showsource'))); //whether show sources or not
$showmedium = (($allowtorrents && get_searchbox_value($brsectiontype, 'showmedium')) || ($allowspecial && get_searchbox_value($spsectiontype, 'showmedium'))); //whether show media or not
$showcodec = (($allowtorrents && get_searchbox_value($brsectiontype, 'showcodec')) || ($allowspecial && get_searchbox_value($spsectiontype, 'showcodec'))); //whether show codecs or not
$showstandard = (($allowtorrents && get_searchbox_value($brsectiontype, 'showstandard')) || ($allowspecial && get_searchbox_value($spsectiontype, 'showstandard'))); //whether show standards or not
$showprocessing = (($allowtorrents && get_searchbox_value($brsectiontype, 'showprocessing')) || ($allowspecial && get_searchbox_value($spsectiontype, 'showprocessing'))); //whether show processings or not
$showteam = (($allowtorrents && get_searchbox_value($brsectiontype, 'showteam')) || ($allowspecial && get_searchbox_value($spsectiontype, 'showteam'))); //whether show teams or not
$showaudiocodec = (($allowtorrents && get_searchbox_value($brsectiontype, 'showaudiocodec')) || ($allowspecial && get_searchbox_value($spsectiontype, 'showaudiocodec'))); //whether show languages or not

stdhead($lang_upload['head_upload']);
//加入做种版权类问题公告信息

/*?>
<table align="center">
<tr><td><?=$lang_upload['text_zhuyi']?></td></tr>
<tr><td></td></tr>
</table>*/
print("<div align=\"center\"><form method=\"get\" action=\"torrents.php?\" target=\"_blank\">".$lang_upload['text_search_offer_note']."&nbsp;&nbsp;<input type=\"text\" name=\"search\">&nbsp;&nbsp;<input type=\"hidden\" name=\"incldead\" value=0>");
print("<input type=\"submit\" class=\"btn\" value=\"".$lang_upload['submit_search']."\" /></form></div>");

?>
	<form id="compose" enctype="multipart/form-data" action="takeupload.php" method="post" name="upload">
			<table border="1" cellspacing="0" cellpadding="5" width="940">
				<tr>
					<td class='colhead' colspan='2' align='center'>
						<?php echo $lang_upload['text_tracker_url'] ?>: &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo  get_protocol_prefix() . $announce_urls[0]?></b>
						<?php
						if(!is_writable($torrent_dir))
						print("<br /><br /><b>ATTENTION</b>: Torrent directory isn't writable. Please contact the administrator about this problem!");
						if(!$max_torrent_size)
						print("<br /><br /><b>ATTENTION</b>: Max. Torrent Size not set. Please contact the administrator about this problem!");
						?>
					</td>
				</tr>
				<tr>
					<td class='colhead' colspan='2' align='center'>
						<?php print($lang_upload['text_notice']);?>
					</td>
				</tr>
<script type="text/javascript">
$(document).ready(function(){
	uplist("source_sel",new Array(['0','请先选择一级类型']));
	$("#browsecat").change(function(){
		secondtype($("#browsecat").val());
		removeSubcat();
	});

	function catChange()
	{
		secondtype($("#browsecat").val());
		removeSubcat();
	}

	$("#source_sel").change(function(){
		//start modified by SamuraiMe,2013.05.17 
		//用于自动生成种子标题
		removeSubcat();

		$.getJSON("guize.php?id="+$("#browsecat").val()+"&source_sel="+$(this).val()+"&t="+new Date(), function(result){
			$("#gstishi").html(result[0]);
			$("td td:has('#name')").prepend(result[1]);
			$("#subcat").slideDown();
		});
	});

	$("#subcat input:checkbox, #subcat input:radio").live("click", function() {
		var name = $(this).attr("name");
		var index = $(this).index("#subcat input[name="+name+"]");
		var length = $("#subcat input[name="+name+"]").length;
		if ($(this).next().next().is("[id=temp_input]")) {
			$(this).next().toggle().next().toggle();
		} else {
			if (index == length-1) {
				var input = $(this).next().text();
				$(this).next().hide().after('<input type="text" id="temp_input" value="'+input+'"/>').focus();
				$(this).val($(this).next().next().val());
				$(this).next().text($(this).next().next().val());
			} else {
				removeTempInput();
			}
		}
	});

	$("#temp_input").live("blur", function() {
		$(this).prev().text($(this).val()).show();;
		$(this).prev().prev().val($(this).val());
		$(this).remove();
		generateName();
	});


	$("#subcat input").live("change", function() {
		generateName();
	});

	function removeSubcat()
	{
		if ($("#subcat").length>0) {
			$("#subcat").slideUp(function() {
				$(this).remove();
			})
		};
	}

	function removeTempInput() {
		$("#temp_input").prev().text($("#temp_input").val())
			.prev().val($("#temp_input").val());
		$("#temp_input").prev().show().end().remove();
		//$("#temp_input").remove();
	}

	function generateName () {
		var names = new Array();
		var tempName = '';
		var name = '';
		$("#subcat input:checked, #subcat input[value!=''][id!=temp_input]:text, #subcat input[type=hidden]").each(function() {
			if ($(this).attr("name") == tempName) {
				names[names.length-1] += "/" + $(this).val();
			} else {
				names[names.length] = $(this).val();
			}
			tempName = $(this).attr("name");
		});

		for (var i = 0; i < names.length; i++) {
			name += "[" + names[i] + "]";
		};
		$("#name").val(name);
	}
	//end modified by SamuraiMe,2013.05.17

	//modified by SamuraiMe,2013.05.19 获取豆瓣与IMDB的URL
	//获取豆瓣url
	$("#browsecat").change(function() {
		var cat = $(this).val();
		if (401!=cat && 402!=cat && 405!=cat && 414 !=cat && 404!=cat) {
			$("#select_douban").remove();
			$("#reselect_douban").remove();
		}
	});
	//中文名改变时刷新显示可能的豆瓣链接
	$("[name=chinese_name]").live("blur", function (){
		$("#reselect_douban").remove();
		displayDoubanItem();
	});
	$("#reselect_douban").live("click", function() {
		$(this).remove();
		displayDoubanItem();
	});
	//豆瓣链接被选中时
	$(".douban_item").live("click", function () {
		$a = $(this).find("a");
		var url = $a.first().attr("href");
		$("[name=dburl]").val(url);
		$("#select_douban").remove();
		$("[name=dburl]").after("<input type=\"button\" id=\"reselect_douban\"value=\"重新选择\"/>");
	});

	function displayDoubanItem() 
	{
		var q = $("[name=chinese_name]").val();
		var cat = $("#browsecat").val();
		if (q && (401==cat || 402==cat || 405==cat || 414 ==cat || 404==cat) ) {
			var requestUrl = "imdb/imdb_url.php?res=douban&title=" + q + "&type=" + $("#browsecat").val();
			$.get(requestUrl, function (data) {
				if ($("#select_douban").length>0) {
					$("#select_douban").remove();
				}
				if (data.length>0) {
					$("[name=dburl]").after(data);
				};
			});
		}
	}


	//英文名改变时刷新显示可能的imdb链接
	$("[name=english_name]").live("blur", function (){
		$("#reselect_imdb").remove();
		displayImdbItem();
	});
	$("#reselect_imdb").live("click", function() {
		$(this).remove();
		displayImdbItem();
	});
	//imdb链接被选中时
	$(".imdb_item").live("click", function () {
		$a = $(this).find("a");
		var url = $a.first().attr("href");
		$("[name=imdburl]").val(url);
		$("#select_imdb").remove();
		$("[name=imdburl]").after("<input type=\"button\" id=\"reselect_imdb\"value=\"重新选择\"/>");
	});

	function displayImdbItem() 
	{
		var q = $("[name=english_name]").val();
		var cat = $("#browsecat").val();
		if (q && (401==cat || 402==cat || 405==cat || 414 ==cat || 404==cat) ) {
			var requestUrl = "imdb/imdb_url.php?res=imdb&title=" + q + "&type=" + $("#browsecat").val();
			$.get(requestUrl, function (data) {
				if ($("#select_imdb").length>0) {
					$("#select_imdb").remove();
				}
				if (data.length>0) {
					$("[name=imdburl]").after(data);
				};
			});
		}
	}
	//获取豆瓣与IMDB的URL结束

	//引用发布功能开始
	if ($("#cite_torrent").val() != "") {
		citeTorrent();
	};
	$("#cite_torrent_btn").click(function(){
		citeTorrent();
	});

	function citeTorrent()
	{
		var id = $("#cite_torrent").val();
		//需要判断id是否合法
		if (id != '') {
			if ($("#cite_hint").length > 0) {
				$("#cite_hint").remove();
			};
			$.getJSON("./citetorrent.php?torrent_id="+id, function(data){
				if (data["exist"] == "yes") {
					$("#browsecat").val(data["category"]);
					catChange();
					$("#source_sel").val(data["source"]);
					$("#name").val(data["name"]);
					$("input[name=small_descr]").val(data["small_descr"]);
					$("input[name=url]").val(data["url"]);
					$("input[name=dburl]").val(data["dburl"]);
					$("#descr").text(data["descr"]);
				} else {
					$("#cite_torrent_btn").after("<span id=\"cite_hint\">所引用的种子不存在..<span>");
				}
			});
		};
	}
	//引用发布功能结束

	$("#qr").click(function(){
		var err = "";
		if($("#browsecat").val() == 0)  err += "请选择[类型]\n\n";
		if($("#source_sel").val() == 0)	err += "请选择[子类型]\n\n";
		if($("#torrent").val() == "") err += "请选择[种子文件]\n\n";
		if($("#name").val().length < 10) err += "[标题]内容不得少于10个字符\n\n";
		if($("#descr").val().length < 50) err += "[简介]内容不得少于50个字符\n\n";
		if($("#descr").val().search(/attach|img/) == -1) err += "[简介]内容必须包含图片\n\n";
		if(err == "") return true;
		jAlert(err);
		return false;
	});
});

function uplist(name,list) {
	var childRet = document.getElementById(name);
	for (var i = childRet.childNodes.length-1; i >= 0; i--) { 
		childRet.removeChild(childRet.childNodes.item(i)); 
	} 
	for (var j=0; j<list.length; j++) {
		var ret = document.createDocumentFragment();
		var newop = document.createElement("option");
		newop.id = list[j][0];
		newop.value = list[j][0]; 
		newop.appendChild(document.createTextNode(list[j][1])); 
		ret.appendChild(newop); 
		document.getElementById(name).appendChild(ret); 
	}
}

function secondtype(value) {
<?
	$cats = genrelist($browsecatmode);
        foreach ($cats as $row){
	$catsid = $row['id'];
	$secondtype = searchbox_item_list("sources",$catsid);
	$secondsize = count($secondtype,0);
	$cachearray = $cachearray."var lid".$catsid." = new Array(['0','请选择子类型']";
	for($i=0; $i<$secondsize; $i++){
		$cachearray = $cachearray.",['".$secondtype[$i]['id']."','".$secondtype[$i]['name']."']";
	}
	$cachearray = $cachearray.");\n";
	}
        $cats = genrelist($browsecatmode);
	$cachearray = $cachearray."switch(value){\n";
        foreach ($cats as $row){
        $catsid = $row['id'];
	$cachearray = $cachearray."\tcase \"".$catsid."\": ";
	$cachearray = $cachearray."uplist(\"source_sel\",lid".$catsid.");";
	$cachearray = $cachearray."break;\n";
	}
	$cachearray = $cachearray."}\n";
	print($cachearray);
?>
}
</script>
<?php
$torrent_id = isset($_GET["cite_torrent_id"]) ? 0+$_GET["cite_torrent_id"] : "";
tr("引用发布", "<input type=\"text\" id=\"cite_torrent\" name=\"cite_torrent\" value=\"$torrent_id\" /><input type=\"button\" id=\"cite_torrent_btn\" value=\"引用\"/>", 1);
tr($lang_upload['row_torrent_file']."<font color=\"red\">*</font>", "<input type=\"file\" class=\"file\" id=\"torrent\" name=\"file\" />\n", 1);
if ($allowtorrents){
		$disablespecial = " onchange=\"disableother('browsecat','specialcat')\"";
		$s = "<select name=\"type\" id=\"browsecat\" ".($allowtwosec ? $disablespecial : "").">\n<option value=\"0\">".$lang_upload['select_choose_one']."</option>\n";
		$cats = genrelist($browsecatmode);
                                        foreach ($cats as $row)
                                                $s .= "<option value=\"" . $row["id"] . "\">" . htmlspecialchars($row["name"]) . "</option>\n";
                                        $s .= "</select>\n";
                                }
                                else $s = "";
                                if ($allowspecial){
                                        $disablebrowse = " onchange=\"disableother('specialcat','browsecat')\"";
                                        $s2 = "<select name=\"type\" id=\"specialcat\" ".$disablebrowse.">\n<option value=\"0\">".$lang_upload['select_choose_one']."</option>\n";
                                        $cats2 = genrelist($specialcatmode);
                                        foreach ($cats2 as $row)
                                                $s2 .= "<option value=\"" . $row["id"] . "\">" . htmlspecialchars($row["name"]) . "</option>\n";
                                        $s2 .= "</select>\n";
                                }
                                else $s2 = "";
                                tr($lang_upload['row_type']."<font color=\"red\">*</font>", ($allowtwosec ? $lang_upload['text_to_browse_section'] : "").$s.($allowtwosec ? $lang_upload['text_to_special_section'] : "").$s2.($allowtwosec ? $lang_upload['text_type_note'] : ""),1);

				if ($showsource || $showmedium || $showcodec || $showaudiocodec || $showstandard || $showprocessing){
                                        if ($showsource){
                                               $source_select = torrent_selection($lang_upload['text_source'],"source_sel","sources");
                                        }
                                        else $source_select = "";

                                        if ($showmedium){
                                                $medium_select = torrent_selection($lang_upload['text_medium'],"medium_sel","media");
                                        }
                                        else $medium_select = "";

                                        if ($showcodec){
                                                $codec_select = torrent_selection($lang_upload['text_codec'],"codec_sel","codecs");
                                        }
                                        else $codec_select = "";

                                        if ($showaudiocodec){
                                                $audiocodec_select = torrent_selection($lang_upload['text_audio_codec'],"audiocodec_sel","audiocodecs");
                                        }
                                        else $audiocodec_select = "";

                                        if ($showstandard){
                                                $standard_select = torrent_selection($lang_upload['text_standard'],"standard_sel","standards");
                                        }
                                        else $standard_select = "";

                                        if ($showprocessing){
                                                $processing_select = torrent_selection($lang_upload['text_processing'],"processing_sel","processings");
                                        }
                                        else $processing_select = "";

                                        //tr($lang_upload['row_quality']."<font color=red>*</font>", $source_select . $medium_select. $codec_select . $audiocodec_select. $standard_select . $processing_select, 1 );
                                        tr($lang_upload['row_quality']."<font color=red>*</font>", "<select id='source_sel' name='source_sel'></select>", 1 );
                                }

				//tr($lang_upload['row_torrent_file']."<font color=\"red\">*</font>", "<input type=\"file\" class=\"file\" id=\"torrent\" name=\"file\" onchange=\"getname()\" />\n", 1);
				//tr($lang_upload['row_torrent_file']."<font color=\"red\">*</font>", "<input type=\"file\" class=\"file\" id=\"torrent\" name=\"file\" />\n", 1);
				if ($altname_main == 'yes'){
					tr($lang_upload['row_torrent_name'], "<b>".$lang_upload['text_english_title']."</b>&nbsp;<input type=\"text\" style=\"width: 250px;\" name=\"name\" />&nbsp;&nbsp;&nbsp;
<b>".$lang_upload['text_chinese_title']."</b>&nbsp;<input type=\"text\" style=\"width: 250px\" name=\"cnname\"><br /><font class=\"medium\">".$lang_upload['text_titles_note']."</font>", 1);
				}
				else
					tr($lang_upload['row_torrent_name'], "<input type=\"text\" style=\"width: 650px;\" id=\"name\" name=\"name\" /><br /><font class=\"medium\">".$lang_upload['text_torrent_name_note']."</font>", 1);
				if ($smalldescription_main == 'yes')
				tr($lang_upload['row_small_description'], "<input type=\"text\" style=\"width: 650px;\" name=\"small_descr\" /><br /><font class=\"medium\">".$lang_upload['text_small_description_note']."</font>", 1);
				tr($lang_upload['row_description_note'],"<br /><font size=+1 color=brown>".$lang_upload['text_description_note']."</font>", 1);
				
				get_external_tr();
				get_dbexternal_tr();
				if ($enablenfo_main=='yes')
					tr($lang_upload['row_nfo_file'], "<input type=\"file\" class=\"file\" name=\"nfo\" /><br /><font class=\"center\">".$lang_upload['text_only_viewed_by'].get_user_class_name($viewnfo_class,false,true,true).$lang_upload['text_or_above']."</font>", 1);
				print("<tr><td class=\"rowhead\" style='padding: 3px' valign=\"top\">".$lang_upload['row_description']."<font color=\"red\">*</font></td><td class=\"rowfollow\">");
				textbbcode("upload","descr","",false);
				print("</td></tr>\n");


				if ($showteam){
					if ($showteam){
						$team_select = torrent_selection($lang_upload['text_team'],"team_sel","teams");
					}
					else $showteam = "";

					tr($lang_upload['row_content'],$team_select,1);
				}

				//==== offer dropdown for offer mod  from code by S4NE
				$offerres = sql_query("SELECT id, name FROM offers WHERE userid = ".sqlesc($CURUSER[id])." AND allowed = 'allowed' ORDER BY name ASC") or sqlerr(__FILE__, __LINE__);
				if (mysql_num_rows($offerres) > 0)
				{
					$offer = "<select name=\"offer\"><option value=\"0\">".$lang_upload['select_choose_one']."</option>";
					while($offerrow = mysql_fetch_array($offerres))
						$offer .= "<option value=\"" . $offerrow["id"] . "\">" . htmlspecialchars($offerrow["name"]) . "</option>";
					$offer .= "</select>";
					tr($lang_upload['row_your_offer']. (!$uploadfreely && !$allowspecial ? "<font color=red>*</font>" : ""), $offer.$lang_upload['text_please_select_offer'] , 1);
				}
				//===end

				if(get_user_class()>=$beanonymous_class)
				{
					tr($lang_upload['row_show_uploader'], "<input type=\"checkbox\" name=\"uplver\" value=\"yes\" />".$lang_upload['checkbox_hide_uploader_note'], 1);
				}
				?>
				<tr><td class="toolbox" align="center" colspan="2"><input id="qr" type="submit" class="btn" value="<?php echo $lang_upload['submit_upload']?>" />
				<input id="preDIv" type="button" class="btn" onClick="javascript:preview_torrent();return false;" value="预览" />
					<input id="EditDIv" type="button" style="display:none;" onClick="javascript:edit_torrent();return false;" class="btn" value="继续编辑" />
					</td>

				</td></tr>	</table>
	</form>
<?php
stdfoot();
