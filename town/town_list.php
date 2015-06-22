<?php
include_once ("./_common.php");
include_once("$root/subhead.php");
include_once("town_function.php");

$town_search_type = array(
	"sName" => "학원명",
	"sCeo" => "원장명",
	"sTel" => "전화번호",
	"sAddr" => "주소"
);

$page = empty($_REQUEST['page']) ? 1 : $_REQUEST['page']; // 보는 페이지 없음 1페이지
$limite = empty($_REQUEST['limite']) ? 20 : $_REQUEST['limite'];
$page_per_list = 10;

$zip_table = $_REQUEST['zip_table'];
$sSigun = $_REQUEST['sSigun'];
$sDong = $_REQUEST['sDong'];

$ZIP_SIGUN = '';
$ZIP_DONG = '';

$group1_id = $_REQUEST['group1_id'];
$group2_id = $_REQUEST['group2_id'];


$parameter ="";
$sSearchType = $_REQUEST['sSearchType'];
$sSearchString = $_REQUEST['sSearchString'];

$WhereIs = " WHERE iActive='1' ";
if ($zip_table) {
	$WhereIs .= " AND zip_table='$zip_table' ";
	$parameter .= "zip_table=".$zip_table."&";
	
	$GUNSQL = "SELECT sSigun FROM ".$zip_table." GROUP BY sSigun";
	$GUNRES = $db_conn -> sql($default_db, $GUNSQL);
	while (list($sigun) = mysql_fetch_row($GUNRES)) {
		$ZIP_SIGUN[] = $sigun;
	}
	sort($ZIP_SIGUN);
}
if ($sSigun) {
	$WhereIs .= " AND sSigun='$sSigun' ";
	$parameter .= "sSigun=".$sSigun."&";
	$DONGSQL = "SELECT sEupmyon, sDong FROM ".$zip_table." WHERE sSigun='".$sSigun."' GROUP BY sEupmyon , sDong";
	$DONGRES = $db_conn -> sql($default_db, $DONGSQL);
	while (list($E, $D)= mysql_fetch_row($DONGRES)) {
		$ZIP_DONG[] = trim($E.$D);
	}
	sort($ZIP_DONG);
}
if ($sDong) {
	$WhereIs .= " AND sDong='$sDong' ";
	$parameter .= "sDong=".$sDong."&";
}


if ($group1_id) {
	$WhereIs .= " AND town_group1_id='$group1_id' ";
	$parameter .= "group1_id=".$group1_id."&";
	/* 2차 분류 가져오기 */
	$GCSQL = "SELECT COUNT(id) FROM `town_group2` WHERE town_group1_id='".$group1_id."'";
	$GCRES = $db_conn -> sql($default_db, $GCSQL);
	list($gCount) = mysql_fetch_row($GCRES);
	if ($gCount > 0) {
		$GSQL2 = "SELECT id, sGroupName FROM `town_group2` WHERE town_group1_id='".$group1_id."' ORDER BY iSort";
		$GRES2 = $db_conn -> sql($default_db, $GSQL2);
		while ($row = mysql_fetch_assoc($GRES2)) {
			$Group2[$row['id']] = $row['sGroupName'];
		}
		
		if ($group2_id) {
			$WhereIs .= " AND town_group2_id='$group2_id' ";
			$parameter .= "group2_id=".$group2_id."&";
		} 
	}
}

if ($sSearchString) {
	switch ($sSearchType) {
		default:
			$WhereIs .= " AND ". $sSearchType ." LIKE '%".$sSearchString."%'";
			$parameter .= "sSearchType=".$sSearchType."&sSearchString=".$sSearchString;
			break;
	}
}
$searchTypeOption = getSelectboxOption($town_search_type, $sSearchType);

$Order = " ORDER BY id DESC ";

/*//지역 DB 가져오기
$ZoneSQL = "SELECT id, sArea FROM `town_zone` ORDER BY iSort";
$ZoneRES = $db_conn -> sql($default_db, $ZoneSQL);
while ($row = mysql_fetch_assoc($ZoneRES)) {
	$Zone[$row['id']] = $row['sArea'];
}
*/
/* 1차 분류 가져오기 */
$GSQL1 = "SELECT id, sGroupName FROM `town_group1` ORDER BY iSort";
$GRES1 = $db_conn -> sql($default_db, $GSQL1);
while ($row = mysql_fetch_assoc($GRES1)) {
	$Group1[$row['id']] = $row['sGroupName'];
}

// 모든 학원수 가지고 오기
$ATCSQL = "SELECT COUNT(id) FROM `town_academy` WHERE iActive='1'";
$ATCRES = $db_conn -> sql($default_db, $ATCSQL);
list($AllCount) = mysql_fetch_row($ATCRES);

$HeaderVal = array(
//	array("title" =>"<input type=\"checkbox\" class=\"allCheck\" />",'col' => '4%','pos' => 'center','sort' => "sorter-false"),
	array("title" =>"No",		'col' => '5%',		'pos' => 'center',	'sort' => ""),
	array("title" =>"이미지",	'col' => '15%',		'pos' => 'center',	'sort' => "sorter-false"),
	array("title" =>"학원명",	'col' => 'auto',	'pos' => 'center',	'sort' => ""),
	//array("title" =>"원장명",	'col' => '10%',		'pos' => 'center',	'sort' => ""),		
	array("title" =>"전화번호",	'col' => '15%',		'pos' => 'center',	'sort' => ""),
	array("title" =>"홈페이지",	'col' => '15%',		'pos' => 'center',	'sort' => ""),
	array("title" =>"주소",	'col' => '25%',		'pos' => 'left',	'sort' => ""),
	
);
$caption = "
	<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" style=\"display: inline;\">
		<div class=\"left\">
			<select name=\"limite\" class=\"auto_submit_select\">
				".getSelectOption($LIMITE, $limite)."
			</select>
			<select name=\"zip_table\" class=\"town_zone1\">
				<option value=\"\">지역 - 전체</option>
				".getSelectOption($ZIP_ZONE, $zip_table)."
			</select>
			<select name=\"sSigun\" class=\"town_zone2\">
				<option value=\"\">시군구 - 전체</option>
				".getSelectOption_value($ZIP_SIGUN, $sSigun)."
			</select>
			<select name=\"sDong\" class=\"town_zone3\">
				<option value=\"\">읍면동 - 전체</option>
				".getSelectOption_value($ZIP_DONG, $sDong)."
			</select>
			<select name=\"group1_id\" class=\"town_group1\">
				<option value=\"\">업종 - 전체</option>
				".getSelectOption($Group1, $group1_id)."
			</select>
			<select name=\"group2_id\" class=\"town_group2\">
				<option value=\"\">과목 - 전체</option>
				".getSelectOption($Group2, $group2_id)."
			</select>
			<input type=\"submit\" value=\"찾기\" class=\"jButton small\" />
		</div>
	</form>
	
	<span class=\"side\">
		<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" style=\"display: inline;\">	
			<select name=\"sSearchType\">
				".$searchTypeOption."
			</select>
			<input type=\"text\" name=\"sSearchString\" value=\"".$sSearchString."\" size=\"20\">
			<input type=\"submit\" value=\"검색\" class=\"jButton small\">
		</form>
		
	</span>
" ;
$thead = $b -> newBoardHeader($HeaderVal, $caption);


// 검색결과내 학원수 가지고 오기
$CSQL = "SELECT COUNT(id) FROM `town_academy` ". $WhereIs;
$CRES = $db_conn -> sql($default_db, $CSQL);
list($iTotal) = mysql_fetch_row($CRES);

$parameter = preg_replace("/&$/",'',$parameter);
$parameter .= "&limite=".$limite;
if ($iTotal > 0) {
	list($st_num, $nav , $LinkString , $limit)= $db_conn -> pagingFun($iTotal , $page ,$limite, $page_per_list, $parameter, $_SERVER['PHP_SELF']);
	
	$SSQL = "
		SELECT id, sName, sCeo, sTel, sAddr, sAddrSub, sUrl FROM `town_academy`
		".$WhereIs . $Order. $limit ." 
	";
	$tbody = sqlShowData_town($SSQL, $st_num);
} else {
	$tbody = $b -> noDatas($HeaderVal);
}
$returnVal = $thead.$tbody;
?>
<div class="udonghak_list">
	<div class="total">
		 우리동네학원 전국학원정보
		 <div class="count">검색결과 - 총 <span><?=number_format($AllCount)?></span> 개의 학원이 검색되었습니다.</div>
		 <span class="side"><a href="<?=$root?>/town/town_write.php" class="jButton">우리동네학원 등록 신청</a></span>
	</div>
</div>
<div class="table2 even">
	<?=$returnVal?>
</div>
<div class="pageing" style="margin-bottom:20px;">
	<?=$nav?>
</div>
<?php
include_once("$root/town/town_imgview.php");
include_once("$root/subfoot.php");
?> 