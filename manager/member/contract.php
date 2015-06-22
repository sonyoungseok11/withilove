<?php
	include_once ("./_common.php");
	include_once ("$path/inc/header.php");
	include_once ("$path/inc/gnb.php");
	
	$search_Type =  $_POST['search_Type'];
	$search_STR = $_POST['search_STR'];
	
	$limite = empty($_POST['limite']) ? 10 : $_POST['limite'];
	$page = empty($_POST['page'])?1:$_POST['page'];
	$page_per_list = 10;
	
	$parameter = "search_Type=$search_Type&search_STR=$search_STR";
	
	$where = " WHERE u.iUserStatus=1 ";
	if (!empty($search_STR)) {
		$where .=" AND $search_Type LIKE '%$search_STR%' ";
	}
	
	$HeaderVal = array(
		array("title" =>"<input type=\"checkbox\" class=\"allCheck\" />",'col' => '4%','pos' => 'center','sort' => "sorter-false"),
		array("title" =>"No",		'col' => '5%',		'pos' => 'center',	'sort' => "sorter-false"),
		array("title" =>"ID",		'col' => '10%',		'pos' => 'center',	'sort' => ""),
		array("title" =>"이름",		'col' => '8%',		'pos' => 'center',	'sort' => ""),
		array("title" =>"학원명",	'col' => 'auto',	'pos' => 'center',	'sort' => ""),
		array("title" =>"휴대폰",	'col' => '10%',		'pos' => 'center',	'sort' => ""),
		array("title" =>"전화번호",	'col' => '10%',		'pos' => 'center',	'sort' => ""),
		array("title" =>"상담시간",	'col' => '14%',		'pos' => 'center',	'sort' => ""),
		array("title" =>"신청일",	'col' => '8%',		'pos' => 'center',	'sort' => ""),
		array("title" =>"진행상황",	'col' => '8%',		'pos' => 'center',	'sort' => ""),
		array("title" =>"상세보기",	'col' => '7%',		'pos' => 'center',	'sort' => "sorter-false")
	);
	$caption = "
		세무계약목록
		<span class=\"side\">
			<a href=\"#\" onclick=\"sms_manager.open(this);\" class=\"jButton small\">문자전송</a>
			<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" style=\"display: inline;\">
				표시 :
				<select name=\"limite\" class=\"auto_submit_select\">
					".getSelectOption($LIMITE, $limite)."
				</select>
				<select name=\"search_Type\">
					".getSelectOption($CONTRACT['searchType'], $search_Type)."
				</select>
				<input type=\"text\" name=\"search_STR\" value=\"".$search_STR."\" size=\"8\">
				<span class=\"button small\"><input type=\"submit\" value=\"검색\"></span>
			</form>
			<a href=\"javascript:;\" onclick=\"table2XLS.download_this_table(this);\" class=\"jButton small\">엑셀저장</a>
		</span>
	" ;
	$thead = $b -> newBoardHeader($HeaderVal, $caption);
	$SCSQL = "
		SELECT COUNT(t.id) FROM `tax_contact` t
		INNER JOIN `users` u ON u.id = t.user_id
		". $where ."
	";
	$SCRES = $db_conn -> sql($default_db, $SCSQL);
	list ($iTotal) = mysql_fetch_row($SCRES);
	if ($iTotal) {
		list($st_num, $nav , $LinkString , $limit)= $db_conn -> pagingFun($iTotal , $page ,$limite, $page_per_list, $parameter, $_SERVER['PHP_SELF']);
		$SSQL = "
			SELECT t.id AS contact_id, t.user_id, t.iStep, t.sName, t.sTel, t.iCounselingTime, DATE_FORMAT(t.dInDate,'%Y-%m-%d') AS dInDate, u.sUserID, u.sUserName, u.sHphone 
			FROM `tax_contact` t
			INNER JOIN `users` u ON u.id = t.user_id
			".$where . $limit ." 
		";		
		$SRES = $db_conn -> sql($default_db, $SSQL);
		$tbody = "<form>";
		$tbody .= "<tbody>";
		$i=0;
		while ($Datas = mysql_fetch_assoc($SRES)) {
			$tbody .="<tr>";
			$tbody .="<td class=\"center\"><input type=\"checkbox\" class=\"checkGroup\" value=\"".$Datas['user_id']."\" /></td>";
			$tbody .="<td class=\"center\">". $st_num-- ."</td>";
			$tbody .="<td class=\"center\">". $Datas['sUserID'] ."</td>";
			$tbody .="<td class=\"center\"><a href=\"javascript:;\" onclick=\"user_modify_dialog(". $Datas['user_id'].")\" >". $Datas['sUserName'] ."</a></td>";
			$tbody .="<td class=\"center\">". $Datas['sName'] ."</td>";
			$tbody .="<td class=\"center\">". $Datas['sHphone'] ."</td>";
			$tbody .="<td class=\"center\">". $Datas['sTel'] ."</td>";
			$tbody .="<td class=\"center\">". $CONTRACT['iCounselingTime'][$Datas['iCounselingTime']] ."</td>";
			$tbody .="<td class=\"center\">". $Datas['dInDate'] ."</td>";
			$tbody .="<td class=\"center\"> <select class=\"contract_step_change\" data-cid=\"".$Datas['contact_id']."\">". getSelectOption($CONTRACT['iStep'], $Datas['iStep']) ."</select></td>";
			$tbody .="<td class=\"center\"><a href=\"javascript:;\" onclick=\"user_contract_dialog(". $Datas['contact_id'] .")\" class=\"jButton small\">상세보기</a></td>";
			$tbody .="</tr>";
		}
		$tbody .= "</tbody>";
		$tbody .= "</form>";
		$tbody .= "</table>";
	} else {
		$tbody = $b -> noDatas($HeaderVal);
	}
	$returnVal = $thead.$tbody;
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