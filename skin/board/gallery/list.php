<?php
//print_r($BOARD_CONFIG);
$page = empty($_REQUEST['page']) ? 1 : $_REQUEST['page']; // 보는 페이지 없음 1페이지
$limite = empty($_POST['iLimit']) ? $BOARD_CONFIG['iLimit'] : $_POST['iLimit'];
$caNum = isset($_REQUEST['caNum'])  ? $_REQUEST['caNum'] : -1 ;
$page_per_list = $BOARD_CONFIG['iPage'];

$parameter ="iLimit=$limite";
$sSearchType = $_POST['sSearchType'];
$sSearchString = $_POST['sSearchString'];

$limiteArr = array(
	'12' => '12개',
	'24' => '24개',
	'36' => '36개',
	'48' => '48개'
);

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
	$parameter .="&sSearchType=$sSearchType&sSearchString=$sSearchString";
} else {
	$WhereIs = " WHERE f.board_config_id='".$board_config_id."' AND b.iDepth='0' ";
}

if($BOARD_CONFIG['iUseCategory']) {
	if ($caNum > -1) {
		$WhereIs .= " AND b.iCategory=$caNum ";
	} else {
		$caActive = 'active';
	}
	//카데고리 텝스
	$category_tab = "";
	$category_tab .= "<ul>";
	
	$category_tab .= "<li><a href=\"".$_SERVER['PHP_SELF']."?".$parameter."\" class=\"sendpost ".$caActive."\">전체</a></li>";
	krsort($BOARD_CONFIG['Category']);
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

}


$searchTypeOption = getSelectboxOption($board_search_type, $sSearchType);

$CSQL = "SELECT COUNT(b.id) FROM ".$table." b LEFT JOIN `board_file` f ON b.id = f.board_id" . $WhereIs;
$CRES = $db_conn -> sql($default_db, $CSQL);
list($iTotal) = mysql_fetch_row($CRES);


if($iTotal) {
	list($st_num , $nav , $LinkString , $limit)= $db_conn -> pagingFun($iTotal , $page ,$limite, $page_per_list, $parameter,  $_SERVER['PHP_SELF']);
	$BSQL = "
		SELECT b.id, b.iOrder, b.iDepth, b.sTitle, b.iHavefile, b.iSee, DATE_FORMAT(b.dIndate , '%Y-%m-%d') AS dInDate, DATEDIFF(b.dInDate, NOW()) AS DiffDay ,f.sPath, f.sCopy 
		FROM ".$table." b
		LEFT JOIN `board_file` f ON b.id = f.board_id
		".$WhereIs. " ORDER BY iOrder DESC " . $limit;
	$Data = sqlShowData_gallery($BSQL, $TablePositionArr);
	$ReturnValue=$Data;
} else {
	$Data = "<div class=\"nodatas\">검색된 자료가 없습니다.</div>";
	$ReturnValue=$Data;
}
?>
<div class ="list_tabs">
	<?=$category_tab?>
	<div class="limit_select">
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<input type="hidden" name="caNum" value="<?=$caNum?>" />
			<input type="hidden" name="sSearchType" value="<?=$sSearchType?>" />
			<input type="hidden" name="sSearchString" value="<?=$sSearchString?>" />
			<select name="iLimit" class="auto_submit_select">
				<?=getSelectOption($limiteArr, $limite)?>
			</select>
		</form>
	</div>
</div>
<style>

</style>
<div class="list_gallery">
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
		<input type="hidden" name="caNum" value="<?=$caNum?>" />
		<select name="sSearchType">
			<?=$searchTypeOption?>
		</select>
		<input type="text" name="sSearchString" size="40" value="<?=$sSearchString?>" placeholder="검색어를 입력하세요." class="check_values" />
		<input type="submit" value="검색" class="msButton verysmall blue" />
	</form>
</div>