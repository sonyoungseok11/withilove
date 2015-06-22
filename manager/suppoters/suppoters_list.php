<?php
	$iAnswer = empty($_POST['iAnswer']) ? 0 : $_POST['iAnswer'];
	$limite = empty($_POST['limite']) ? 20 : $_POST['limite'];
	$page = empty($_POST['page'])?1:$_POST['page'];
	$page_per_list = 10;
	
	$parameter = "iAnswer=$iAnswer";
	
	$where = " WHERE eType='$eType' ";
	if ($iAnswer > 0) {
		$where .= " AND iAnswer='$iAnswer' ";
	} 
	
	switch ($eType) {
		case 'K':
			$head_text['caption'] = "키맨 지원 리스트";
			$head_text['sName'] = "성명";
			$head_text['sText'] = "업종";
			break;
		case 'S' :
			$head_text['caption'] = "연사 지원 리스트";
			$head_text['sName'] = "성명";
			$head_text['sText'] = "영역";
			break;
		case 'C' :
			$head_text['caption'] = "협력업체 신청 리스트";
			$head_text['sName'] = "업체명";
			$head_text['sText'] = "담당자";
			break;
	}
	
	
	$HeaderVal = array(
		array("title" =>"No",				'col' => '5%',		'pos' => 'center',	'sort' => "sorter-false"),
		array("title" =>$head_text['sName'],'col' => '20%',		'pos' => 'center',	'sort' => ""),
		array("title" =>"연락처",			'col' => '20%',		'pos' => 'center',	'sort' => ""),
		array("title" =>$head_text['sText'],'col' => 'auto',	'pos' => 'center',	'sort' => ""),
		array("title" =>"신청일",			'col' => '20%',		'pos' => 'center',	'sort' => ""),
		array("title" =>"답변",				'col' => '10%',		'pos' => 'center',	'sort' => "sorter-false"),
	);
	
	$caption = $head_text['caption'] ." - " . $SUPPORTERS['iAnswer'][$iAnswer] . "
		<span class=\"side\">
			<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" style=\"display: inline;\">
				표시 :
				<select name=\"limite\" class=\"auto_submit_select\">
					".getSelectOption($LIMITE, $limite)."
				</select>
				<select name=\"iAnswer\" class=\"auto_submit_select\">
					".getSelectOption($SUPPORTERS['iAnswer'], $iAnswer)."
				</select>
			</form>
			<a href=\"javascript:;\" onclick=\"table2XLS.download_this_table(this);\" class=\"jButton small\">엑셀저장</a>
		</span>
	";
	$thead = $b -> newBoardHeader($HeaderVal, $caption);
	
	$SCSQL = "
		SELECT COUNT(id) FROM `supporters`
		". $where ."
	";
	$SCRES = $db_conn -> sql($default_db, $SCSQL);
	list ($iTotal) = mysql_fetch_row($SCRES);
	if ($iTotal) {
		list($st_num, $nav , $LinkString , $limit)= $db_conn -> pagingFun($iTotal , $page ,$limite, $page_per_list, $parameter, $_SERVER['PHP_SELF']);
		$SSQL = "
			SELECT id, iAnswer, sName, sTel, sText, dInDate FROM `supporters`
			".$where ." ORDER BY id DESC ". $limit ." 
		";		
		$SRES = $db_conn -> sql($default_db, $SSQL);
		$tbody = "<tbody>";
		$i=0;
		while ($Datas = mysql_fetch_assoc($SRES)) {
			$tbody .="<tr>";
			$tbody .="<td class=\"center\">". $st_num-- ."</td>";
			$tbody .="<td class=\"center\">". $Datas['sName'] ."</td>";
			$tbody .="<td class=\"center\">". $Datas['sTel'] ."</td>";
			$tbody .="<td class=\"center\">". $Datas['sText'] ."</td>";
			$tbody .="<td class=\"center\">". $Datas['dInDate'] ."</td>";
			if ($Datas['iAnswer'] == 2) {
				$tbody .="<td class=\"center\">답변완료</td>";
			} else {
				$tbody .="<td class=\"center\"><a href=\"javascript:;\" onclick=\"suppoters_answer(". $Datas['id'] .")\" class=\"jButton small\">답변처리</a></td>";
			}
			$tbody .="</tr>";
		}
		$tbody .= "</tbody>";
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
