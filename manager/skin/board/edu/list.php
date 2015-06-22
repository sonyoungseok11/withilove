<?php
//print_r($BOARD_CONFIG);
$page = empty($_REQUEST['page']) ? 1 : $_REQUEST['page']; // 보는 페이지 없음 1페이지
$limite = $BOARD_CONFIG['iLimit'];
$page_per_list = $BOARD_CONFIG['iPage'];

$parameter ="";
$sSearchType = $_POST['sSearchType'];
$sSearchString = $_POST['sSearchString'];

if($sSearchString) {
	switch ($sSearchType) {
		case 'sName' : 
			$WhereIs = " WHERE f.board_config_id='".$board_config_id."' AND b.iDepth='0' AND b.".$sSearchType." = '".$sSearchString."'";
			break;
		case 'and' :
			$WhereIs = " WHERE f.board_config_id='".$board_config_id."' AND b.iDepth='0' AND b.sTitle LIKE '%". $sSearchString ."%' AND b.sComment LIKE '%". $sSearchString ."%'";
			break;
		case 'or':
			$WhereIs = " WHERE f.board_config_id='".$board_config_id."' AND b.iDepth='0' AND b.sTitle LIKE '%". $sSearchString ."%' OR b.sComment LIKE '%". $sSearchString ."%'";
			break;
		default :
			$WhereIs = " WHERE f.board_config_id='".$board_config_id."' AND b.iDepth='0' AND b.".$sSearchType." LIKE '%".$sSearchString."%'";
			break;
	}
	$parameter .="sSearchType=$sSearchType&sSearchString=$sSearchString";
} else {
	$WhereIs = " WHERE f.board_config_id='".$board_config_id."' AND b.iDepth='0' ";
}
$searchTypeOption = getSelectboxOption($board_search_type, $sSearchType);

$CSQL = "SELECT COUNT(b.id) FROM ".$table." b LEFT JOIN `board_file` f ON b.id = f.board_id" . $WhereIs;
$CRES = $db_conn -> sql($default_db, $CSQL);
list($iTotal) = mysql_fetch_row($CRES);


if($iTotal) {
	list($st_num , $nav , $LinkString , $limit)= $db_conn -> pagingFun($iTotal , $page ,$limite, $page_per_list, $parameter,  $_SERVER['PHP_SELF']);
	$BSQL = "
		SELECT b.id, b.iOrder, b.iDepth, b.iCategory, b.sTitle, b.sPreface, b.dStartDate, b.dEndDate, DATEDIFF(b.dStartDate, NOW()) AS DiffDay, b.iHavefile, f.sPath, f.sCopy
		FROM ".$table." b
		LEFT JOIN `board_file` f ON b.id = f.board_id
		".$WhereIs. " ORDER BY iOrder DESC " . $limit;
	$Data = sqlShowData_edu($BSQL, $TablePositionArr);
	$ReturnValue=$Data;
} else {
	$Data = "<div class=\"nodatas\">검색된 자료가 없습니다.</div>";
	$ReturnValue=$Data;
}
?>

<div class="list_div">
	<?=$ReturnValue?>
</div>
<div class="command">
	<?php
		if ($is_WriteLevel) { 
			echo '<a href="'. $_SERVER['PHP_SELF'] .'?mode=W" class="msButton medium blue right sendpost">글쓰기</a>';
		}

	?>
</div>
<div class="page">
	<?=$nav?>
</div>

<div class="searchbar">
	<form action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="return check_form(this);" >
		<select name="sSearchType">
			<?=$searchTypeOption?>
		</select>
		<input type="text" name="sSearchString" size="40" value="<?=$sSearchString?>" placeholder="검색어를 입력하세요." class="check_values" />
		<input type="submit" value="검색" class="msButton verysmall blue" />
	</form>
</div>