<?php
	include_once ("./_common.php");
	include_once ("$path/inc/header.php");
	include_once ("$path/inc/gnb.php");
	
	$PrefixSQL = "
		SELECT sTablePrefix FROM `board_config` GROUP BY sTablePrefix
	";
	$PrefixRES = $db_conn -> sql ($default_db, $PrefixSQL);
	$Prefix_count = mysql_num_rows($PrefixRES);
	$returnVal = "";
	if ($Prefix_count) {
		while(list($TablePrefix) = mysql_fetch_row($PrefixRES)) {
			$returnVal .= "<div class=\"table tableSort\">";
			$caption = $TablePrefix." 게시판 그룹";
			$headerValArr = array("<input type=\"checkbox\" class=\"allCheck\" />","ID","테이블 이름","게시판이름","메뉴이름", "URL", "게시판스킨", "수정");
			$headerColArr = array("5%","5%","12%","12%","12%","auto","8%","8%");
			$TablePositionArr = array("center","center","center","center","center","left", "center","center");
			$TableSorter = array("sorter-false", "", "","","", "","", "sorter-false", "sorter-false");
			$Header = $b -> boardHeader($headerValArr, $headerColArr ,$TablePositionArr, $TableSorter, $caption);

			$TbSQL = "
				SELECT c.id, c.sTableName, c.sBoardSubject, c.sSkinDir , s.sMenuName, s.sMenuUrl FROM `board_config` c
				LEFT JOIN `sitemenu` s ON s.board_config_id = c.id
				WHERE c.sTablePrefix='".$TablePrefix."' GROUP BY c.id ORDER BY s.id ";
			$Data = $db_conn -> sqlShowData_adminTable($default_db, $TbSQL, $TablePositionArr);
			
			$returnVal .= $Header.$Data."</div>";
			
		}
	} else {
		$returnVal = "<div class=\"nodata\">게시판이 없습니다.</div>";
	}

	
?>
<div class="ADM_Container">
	<div class="board_top_btns">
		<span class="button medium"><a href="<?=$path?>/board/board.php?mode=I" >신규게시판 생성</a></span>
	</div>
	<form>
	<div class="board_list">
		<?=$returnVal?>
	</div>
	</form>
</div>	
<?php
	include_once ("$path/inc/footer.php");
?>