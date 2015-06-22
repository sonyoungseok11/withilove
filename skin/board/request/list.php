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
			$WhereIs = " WHERE ".$sSearchType." = '".$sSearchString."'";
			break;
		case 'and' :
			$WhereIs = " WHERE sTitle LIKE '%". $sSearchString ."%' AND sComment LIKE '%". $sSearchString ."%'";
			break;
		case 'or':
			$WhereIs = " WHERE sTitle LIKE '%". $sSearchString ."%' OR sComment LIKE '%". $sSearchString ."%'";
			break;
		default :
			$WhereIs = " WHERE ".$sSearchType." LIKE '%".$sSearchString."%'";
			break;
	}
	$parameter .="sSearchType=$sSearchType&sSearchString=$sSearchString";
}
$searchTypeOption = getSelectboxOption($board_search_type, $sSearchType);

$CSQL = "SELECT COUNT(id) FROM ". $table . $WhereIs;
$CRES = $db_conn -> sql($default_db, $CSQL);
list($iTotal) = mysql_fetch_row($CRES);


/* 테이블 해더 */
$headerValArr = array("<input type=\"checkbox\" class=\"allCheckDepth2\" />","위드프랭즈 교육일정","관심일정","신청하기");
$headerColArr = array("3%","auto","8%","8%");
$TableHeaderPositionArr = array("center","left gray","center blue","center pink"); // 해더 포지션
$TablePositionArr = array("center","left","center","center"); // 목록 포지션
$Header = $b -> boardHeader2($headerValArr, $headerColArr,  $TableHeaderPositionArr, $BOARD_CONFIG['sBoardSubject'], $userLevel);

if($iTotal) {
	list($st_num , $nav , $LinkString , $limit)= $db_conn -> pagingFun($iTotal , $page ,$limite, $page_per_list, $parameter,  $_SERVER['PHP_SELF']);
	$BSQL = "
		SELECT id, iOrder, iDepth, iCategory ,sTitle, dStartDate, dEndDate, DATEDIFF(dStartDate, NOW()) AS DiffDay
		FROM $table " .$WhereIs. " ORDER BY iOrder DESC " . $limit;
	$Data = sqlShowData_request($BSQL, $TablePositionArr);
	$ReturnValue=$Header.$Data;
} else {
	$Data = $b -> noDatas2($headerValArr, $userLevel);
	$ReturnValue=$Header.$Data;
}
?>
<div class="list_table">
	<?=$ReturnValue?>
</div>
<div class="command">
	<?php
		if ($is_WriteLevel) { 
			echo '<a href="'. $_SERVER['PHP_SELF'] .'?mode=W" class="msButton medium blue right sendpost">글쓰기</a>';
		}
		if ($MEMBER['iHLevel'] == 1) {
			echo '<a href="javascript:board_check_delete();" class="msButton medium red left">선택삭제</a>';
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