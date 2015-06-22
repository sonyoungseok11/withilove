<?php
//print_r($BOARD_CONFIG);
$page = empty($_REQUEST['page']) ? 1 : $_REQUEST['page']; // 보는 페이지 없음 1페이지
$limite = $BOARD_CONFIG['iLimit'];
$page_per_list = $BOARD_CONFIG['iPage'];

$parameter ="";
$sSearchType = $_POST['sSearchType'];
$sSearchString = $_POST['sSearchString'];
$caNum = isset($_REQUEST['caNum']) ? $_REQUEST['caNum'] : -1;


if($BOARD_CONFIG['iUseCategory']) {
	if ($caNum > -1) {
		$WhereIs .= " WHERE iCategory=$caNum ";
	} else {
		$WhereIs .= " WHERE iCategory >= 0 ";
		$caActive = 'active';
	}
	//카데고리 텝스
	$category_tab = "";
	$category_tab .= "<ul>";
	
	$category_tab .= "<li><a href=\"".$_SERVER['PHP_SELF']."?".$parameter."\" class=\"sendpost ".$caActive."\">전체</a></li>";
	foreach ($BOARD_CONFIG['Category'] as $key => $val) {
		$ca_parameter = $parameter."&caNum=$key";
		if ($caNum == $key) {
			$caActive = 'active';
			
		} else {
			$caActive = '';
		}
		$category_tab .= "<li><a href=\"".$_SERVER['PHP_SELF']."?".$ca_parameter."\" class=\"sendpost ".$caActive."\">".$val."</a></li>";
	}
	$category_tab .= "</ul>";

} else {
	$WhereIs .= " WHERE iCategory >= 0 ";
}


if($sSearchString) {
	switch ($sSearchType) {
		case 'sName' : 
			$WhereIs .= " AND ".$sSearchType." = '".$sSearchString."'";
			break;
		case 'and' :
			$WhereIs .= " AND sTitle LIKE '%". $sSearchString ."%' AND sComment LIKE '%". $sSearchString ."%'";
			break;
		case 'or':
			$WhereIs .= " AND sTitle LIKE '%". $sSearchString ."%' OR sComment LIKE '%". $sSearchString ."%'";
			break;
		default :
			$WhereIs .= " AND ".$sSearchType." LIKE '%".$sSearchString."%'";
			break;
	}
}

$parameter .="sSearchType=$sSearchType&sSearchString=$sSearchString&caNum=$caNum";
$searchTypeOption = getSelectboxOption($board_search_type, $sSearchType);



$CSQL = "SELECT COUNT(id) FROM ". $table . $WhereIs;
$CRES = $db_conn -> sql($default_db, $CSQL);
list($iTotal) = mysql_fetch_row($CRES);






/* 테이블 해더 */
$headerValArr = array("<input type=\"checkbox\" class=\"allCheckDepth2\" />","번호","제목","작성자","등록일","조회수");
$headerColArr = array("3%","5%","auto","8%","12%","6%");
$TableHeaderPositionArr = array("center","center","center","center","center","center"); // 해더 포지션
$TablePositionArr = array("center","center","left","center","center","center"); // 목록 포지션
$Header = $b -> boardHeader2($headerValArr, $headerColArr,  $TableHeaderPositionArr, $BOARD_CONFIG['sBoardSubject'], $userLevel);

if($iTotal) {
	list($st_num , $nav , $LinkString , $limit)= $db_conn -> pagingFun($iTotal , $page ,$limite, $page_per_list, $parameter,  $_SERVER['PHP_SELF']);
	$BSQL = "
		SELECT id, user_id, iOrder, iDepth, sName, sTitle, iCategory , iSecret, iHaveFile, iSee, DATE_FORMAT(dInDate, '%Y-%m-%d') AS dInDate 
		FROM $table " .$WhereIs. " ORDER BY iOrder DESC " . $limit;
	$Data = sqlShowData_basic($BSQL, $st_num,  $TablePositionArr);
	$ReturnValue=$Header.$Data;
} else {
	$Data = $b -> noDatas2($headerValArr, $userLevel);
	$ReturnValue=$Header.$Data;
}

?>

<div class="tab_list">
	<?=$category_tab?>
</div>
<div class="list_table">
	<?=$ReturnValue?>
</div>
<div class="command">
	<?php
		if ($is_WriteLevel) { 
			echo '<a href="'. $_SERVER['PHP_SELF'] .'?mode=W" class="msButton medium blue right sendpost">글쓰기</a>';
		} else {
			echo '<a href="javascript:;" onclick="needMember();" class="msButton medium blue right">글쓰기</a>';
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