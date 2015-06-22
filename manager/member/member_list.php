<?php
	include_once ("./_common.php");
	include_once ("$path/inc/header.php");
	include_once ("$path/inc/gnb.php");
	
	$iUserStatus = empty($_POST['iUserStatus']) ? 1 : $_POST['iUserStatus'];
	$search_Type =  $_POST['search_Type'];
	$search_STR = $_POST['search_STR'];
	$eUserType = $_POST['eUserType'];
	$iActive = empty($_POST['iActive']) ? 'all' : $_POST['iActive'] ;
	$sBusinessType = $_POST['sBusinessType'];
	
	$limite = empty($_POST['limite']) ? 20 : $_POST['limite'];
	$page = empty($_POST['page'])?1:$_POST['page'];
	$page_per_list = 10;
	
	$where = " WHERE u.iUserStatus='". $iUserStatus ."' ";
	if (!empty($search_STR)) {
		$where .=" AND u.$search_Type LIKE '%$search_STR%'";
	}
	
	if (empty($eUserType)) {
		$typeStr = "전체";
	} else {
		$typeStr = $USER_TYPE[$eUserType];
		$where .= " AND u.eUserType='". $eUserType ."'";
	}
	
	if (!empty($sBusinessType)) {
		$typeStr .= " - ".$sBusinessType;
		$where .= " AND u.sBusinessType='".$sBusinessType."' ";
	}
	
	switch ($iActive) {
		case 'on':
			$typeStr .= " - 접속중";
			$where .= " AND l.iActive='1' ";
			break;
		case 'off':
			$typeStr .= " - 비접속";
			$where .= " AND l.iActive='0' ";
			break;
	}
	
	switch ($iUserStatus) {
		case '10':
			$print_day = "탈퇴날자";
			break;
		default:
			$print_day = "가입날자";
			break;
	}
	
	$parameter = "iUserStatus=$iUserStatus&search_Type=$search_Type&search_STR=$search_STR&sBusinessType=$sBusinessType";
	
	$headerValArr = array("<input type=\"checkbox\" class=\"allCheck\" />","No.","ID", "이름","업종","학원명", "상태", "Type",$print_day, "접속여부","수정");
	$headerColArr = array("4%","5%","10%","10%","8%","auto","8%","8%","8%","15%","7%","8%");
	$TablePositionArr = array("center","center","center","center", "center","center","center","center", "center", "center", "center");
	$TableSorter = array("sorter-false","", "", "", "", "", "","","","","sorter-false");
	$caption = "회원목록 - ".$USER_STATUS[$iUserStatus]." - ". $typeStr ."
				<span class=\"side\">
					<a href=\"#\" onclick=\"sms_manager.open(this);\" class=\"jButton small\">문자전송</a>
					<a href=\"javascript:;\" onclick=\"user_insert_dialog();\" class=\"jButton small\">신규회원등록</a>
					<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" style=\"display: inline;\">
						표시 :
						<select name=\"limite\" class=\"auto_submit_select\">
							".getSelectOption($LIMITE, $limite)."
						</select>
						<select name=\"iUserStatus\" class=\"auto_submit_select\">
							".getSelectOption($USER_STATUS, $iUserStatus)."
						</select>
						<select name=\"eUserType\" class=\"auto_submit_select\">
							<option value=\"\">Type</option>
							".getSelectOption($USER_TYPE, $eUserType)."
						</select>
						<select name=\"sBusinessType\" class=\"auto_submit_select\">
							<option value=\"\">업종</option>
							".getSelectOption_value($USER_SET['BusinessType'], $sBusinessType)."
						</select>
						<select name=\"iActive\" class=\"auto_submit_select\">
							".getSelectOption($USER_ACTIVE, $iActive)."
						</select>
						<select name=\"search_Type\">
							".getSelectOption($USER_SEARCH_TYPE, $search_Type)."
						</select>
						<input type=\"text\" name=\"search_STR\" value=\"".$search_STR."\" size=\"8\">
						<span class=\"button small\"><input type=\"submit\" value=\"검색\"></span>
					</form>
					<a href=\"javascript:;\" onclick=\"table2XLS.download_this_table(this);\" class=\"jButton small\">엑셀저장</a>
				</span>" ;
	$Header = $b -> boardHeader($headerValArr, $headerColArr ,$TablePositionArr, $TableSorter , $caption);
	
	$CSQL = "
		SELECT COUNT(id) 
		FROM `users` u 
		LEFT JOIN `user_login_log` l ON u.id = l.user_id  
		". $where ."
	";
	$CRES = $db_conn -> sql($default_db, $CSQL);
	list($iTotal) = mysql_fetch_row($CRES);
	list($st_num, $nav , $LinkString , $limit)= $db_conn -> pagingFun($iTotal , $page ,$limite, $page_per_list, $parameter, $_SERVER['PHP_SELF']);
	$TbSQL = "
		SELECT u.id, u.iMLevel, u.iHLevel, u.sUserId, u.sUserName, u.eUserType, u.iUserStatus, u.sBusinessType, u.sCenterName,
		DATE_FORMAT(u.dInDate,'%Y-%m-%d') AS dInDate, DATE_FORMAT(u.dOutDate,'%Y-%m-%d') AS dOutDate,
		l.user_id AS logid, l.iActive, l.dLogDate
		FROM `users` u
		LEFT JOIN `user_login_log` l ON u.id = l.user_id 
	 ". $where ." ORDER BY u.id DESC ". $limit ." 
	";
	$Data = $db_conn -> sqlShowData_adminUserList2($default_db, $TbSQL, $TablePositionArr, $st_num);
	$returnVal = $Header.$Data;
?>
<div class="table tableSort">
	<?=$returnVal?>	
</div>
<div class="pageing">
	<?=$nav?>
</div>
<?php
	include_once ("$path/inc/footer.php");
?>