<?php
include_once ("./_common.php");
include_once("$root/subhead.php");

$ASK['caption'] = "신청한 세미나";
$ASK['headerValArr'] = array("구분","과정명","일자","신청여부");
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
	WHERE w.user_id='".$MEMBER['id']."' AND w.eWishType='ASK' AND b.dStartDate > NOW()
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
		WHERE w.user_id='".$MEMBER['id']."' AND w.eWishType='ASK' AND b.dStartDate > NOW() GROUP BY w.id
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

		$ASK['body'] .= "<td class=\"center\"><a href=\"javascript:;\" onclick=\"Wishlist.user_del('".$data['wish_id']."',this)\" class=\"msButton small gray\">완료</a></td>";
		$ASK['body'] .= "</tr>";
	}
	$ASK['body'] .= "</tbody>";
	$ASK['body'] .= "</table>";
} else {
	$ASK['body'] = $b -> noDatas($ASK['headerValArr']);
}
$ASK['returnVal'] = $ASK['head'].$ASK['body'];
/* 수강현황 */
$ASK2['caption'] = "참석한 세미나";
$ASK2['headerValArr'] = array("구분","과정명","일자","참석여부");
$ASK2['headerColArr'] = array("15%","50%","auto","10%");
$ASK2['TablePositionArr'] = array("center","center","center","center");
$ASK2['TableSorter'] = array(" ", " ", " ", " ");

$ASK2['head'] = $b-> boardHeader($ASK2['headerValArr'], $ASK2['headerColArr'], $ASK2['TablePositionArr'] , $ASK2['TableSorter'], $ASK2['caption']);

$CCSQL2 = "
	SELECT COUNT(w.id)
	FROM `board_user_wishlist` w
	INNER JOIN bbs_education b ON b.id = w.board_id
	INNER JOIN board_config c ON c.id = w.board_config_id
	INNER JOIN `sitemenu` s ON c.id = s.board_config_id
	WHERE w.user_id='".$MEMBER['id']."' AND w.eWishType='ASK' AND b.dStartDate <= NOW()
";
$CCRES2 = $db_conn -> sql($default_db, $CCSQL2);
list ($ASK2['count']) = mysql_fetch_row($CCRES2);

if ($ASK2['count'] > 0) {
	$CSSQL2 = "
		SELECT w.id AS wish_id, w.board_id, b.iCategory, b.sTitle, b.dStartDate, b.dEndDate, DATEDIFF(b.dEndDate, NOW()) AS endDiff, c.sCategoryList, s.sMenuUrl
		FROM `board_user_wishlist` w
		INNER JOIN bbs_education b ON b.id = w.board_id
		INNER JOIN board_config c ON c.id = w.board_config_id
		INNER JOIN `sitemenu` s ON c.id = s.board_config_id
		WHERE w.user_id='".$MEMBER['id']."' AND w.eWishType='ASK' AND b.dStartDate <= NOW() GROUP BY w.id
	";
	$CSRES2 = $db_conn -> sql($default_db, $CSSQL2);
	$i=0;
	while($row = mysql_fetch_assoc($CSRES2)) {
		$ASK2['Data'][$i++] = $row;
	}
	$ASK2['Category'] = explode("|",$ASK2['Data'][0]['sCategoryList']);
	
	$ASK2['body'] = "<tbody>";
	foreach ($ASK2['Data'] as $data) {
		$ASK2['body'] .= "<tr>";
		$ASK2['body'] .= "<th><span class=\"category_icons icon".$data['iCategory']."\">".$ASK2['Category'][$data['iCategory']]."</span></th>";
		$ASK2['body'] .= "<td><a href=\"".$data['sMenuUrl']."?mode=R&id=".$data['board_id']."\" class=\"sendpost\">". $data['sTitle'] ."</a></td>";
		
		$ASK2['body'] .= "<td class=\"center\">".$data['dStartDate'];
		if ($data['dEndDate'] != "0000-00-00") {
			$ASK2['body'] .= " ~ ".$data['dEndDate'];
		}
		$ASK2['body'] .= "</td>";
		
		if ($data['endDiff'] >= 0) {
			$ASK2['body'] .= "<td class=\"center\"><span class=\"msButton small green\">완료</span></td>";
		} else {
			$ASK2['body'] .= "<td class=\"center\"><span class=\"msButton small blue\">완료</span></td>";
		}
		$ASK2['body'] .= "</tr>";
	}
	$ASK2['body'] .= "</tbody>";
	$ASK2['body'] .= "</table>";
} else {
	$ASK2['body'] = $b -> noDatas($ASK2['headerValArr']);
}
$ASK2['returnVal'] = $ASK2['head'].$ASK2['body'];

?>
<div class="page_title"><?=$PageInfo['MenuName']?></div>
<div class="sub_page">
	<div class="myRequestTable">
		<table width="100%">
			<caption>회원정보</caption>
			<colgroup>
				<col width="10%" />
				<col width="35%" />
				<col width="35%" />
				<col width="10%" />
				<col width="10%" />
			</colgroup>
			<thead>
				<tr>
					<th>아이디</th>
					<th>휴대폰</th>
					<th>이메일</th>
					<th>회원구분</th>
					<th>수정</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="5"  class="right">*  수강 신청 진행사항이 현재 정보로 발송됩니다. 과정 신청 전에 휴대폰 번호와 이메일을 확인해주세요.</td>
				</tr>
			</tfoot>
			<tbody>
				<th class="center"><?=$MEMBER['sUserId']?></td>
				<td class="center"><?=$MEMBER['sHphone']?></td>
				<td class="center"><?=$MEMBER['sEmail']?></td>
				<td class="center"><?=$USER_TYPE[$MEMBER['eUserType']]?></td>
				<td class="center"><a href="<?=$path?>/sub_etc/member/member_modify.php" class="msButton small red">변경하기</a></td>
			</tbody>
		</table>
	</div>
	<div class="myRequestTable" style="margin-bottom: 50px;"><?=$ASK['returnVal']?></div>
	<div class="myRequestTable"><?=$ASK2['returnVal']?></div>
</div>

<?php
include_once("$root/subfoot.php");
?>