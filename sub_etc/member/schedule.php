<?php
include_once ("./_common.php");
include_once("$root/subhead.php");

$ASK['caption'] = "관심일정";
$ASK['headerValArr'] = array("구분","과정명","일자","신청/삭제");
$ASK['headerColArr'] = array("15%","50%","auto","10%");
$ASK['TablePositionArr'] = array("center","center","center","center");
$ASK['TableSorter'] = array(" ", " ", " ", " ");

$ASK['head'] = $b-> boardHeader($ASK['headerValArr'], $ASK['headerColArr'], $ASK['TablePositionArr'] , $ASK['TableSorter'], $ASK['caption']);

$CCSQL = "
	SELECT COUNT(w.id)
	FROM `board_user_wishlist` w
	INNER JOIN bbs_education b ON b.id = w.board_id
	INNER JOIN board_config c ON c.id = w.board_config_id
	INNER JOIN `sitemenu` s ON c.id = s.board_config_id
	WHERE w.user_id='".$MEMBER['id']."' AND w.eWishType='HOBBY' AND b.dStartDate > NOW()
";
$CCRES = $db_conn -> sql($default_db, $CCSQL);
list ($ASK['count']) = mysql_fetch_row($CCRES);

if ($ASK['count'] > 0) {
	$CSSQL = "
		SELECT w.id AS wish_id, w.board_id, b.iCategory, b.sTitle, b.dStartDate, b.dEndDate, c.sCategoryList, s.sMenuUrl
		FROM `board_user_wishlist` w
		INNER JOIN bbs_education b ON b.id = w.board_id
		INNER JOIN board_config c ON c.id = w.board_config_id
		INNER JOIN `sitemenu` s ON c.id = s.board_config_id
		WHERE w.user_id='".$MEMBER['id']."' AND w.eWishType='HOBBY' AND b.dStartDate > NOW() GROUP BY w.id
	";
	$CSRES = $db_conn -> sql($default_db, $CSSQL);
	$i=0;
	while($row = mysql_fetch_assoc($CSRES)) {
		$ASK['Data'][$i++] = $row;
	}
	$ASK['Category'] = explode("|",$ASK['Data'][0]['sCategoryList']);
	
	$ASK['body'] = "<tbody>";
	foreach ($ASK['Data'] as $data) {
		$ASK['body'] .= "<tr>";
		$ASK['body'] .= "<th><span class=\"category_icons icon".$data['iCategory']."\">".$ASK['Category'][$data['iCategory']]."</span></th>";
		$ASK['body'] .= "<td><a href=\"".$data['sMenuUrl']."?mode=R&id=".$data['board_id']."\" class=\"sendpost\">". $data['sTitle'] ."</a></td>";
		
		$ASK['body'] .= "<td class=\"center\">".$data['dStartDate'];
		if ($data['dEndDate'] != "0000-00-00") {
			$ASK['body'] .= " ~ ".$data['dEndDate'];
		}
		$ASK['body'] .= "</td>";
		
		$ASK['body'] .= "<td class=\"center\">
							<a href=\"javascript:;\" onclick=\"Wishlist.user_update('".$data['wish_id']."','ASK',this)\" class=\"msButton small red\">신청</a>
							<a href=\"javascript:;\" onclick=\"Wishlist.user_del('".$data['wish_id']."',this)\" class=\"msButton small gray\">삭제</a>
						</td>";
		$ASK['body'] .= "</tr>";
	}
	$ASK['body'] .= "</tbody>";
	$ASK['body'] .= "</table>";
} else {
	$ASK['body'] = $b -> noDatas($ASK['headerValArr']);
}
$ASK['returnVal'] = $ASK['head'].$ASK['body'];
?>
<div class="page_title"><?=$PageInfo['MenuName']?></div>
<div class="sub_page">
	<div class="myRequestTable"><?=$ASK['returnVal']?></div>
</div>
<?php
include_once("$root/subfoot.php");
?>