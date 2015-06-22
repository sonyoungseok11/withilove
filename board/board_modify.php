<?php
	echo $edit_script;
	
	
	$board_id = $_POST['id'];
	
	$SSQL = "SELECT * FROM ". $table ." WHERE id='". $board_id ."'";
	$SRES = $db_conn -> sql($default_db, $SSQL);
	$Datas = mysql_fetch_assoc($SRES);
	
	$file_input = "";
	if ($Datas['iHaveFile']) {
		
		$FSQL = "SELECT * FROM `board_file` WHERE board_config_id='". $board_config_id ."' AND board_id='". $board_id ."'";
		$FRES = $db_conn -> sql($default_db, $FSQL);
		$file_cnt =0;
		while($Frow = mysql_fetch_assoc($FRES)) {
			$file_input .= "<div class=\"delfile\">".$Frow['sFile']." <a href=\"".$Frow['id']."\" class=\"delFile\">삭제</a></div>"; 
			$file_cnt++;
		}
		if ($file_cnt < $BOARD_CONFIG['iUploadCount']) {
			$file_input .= "<input type=\"file\"  name=\"file[]\" />";	
		}
	} else {
		$file_input .= "<input type=\"file\"  name=\"file[]\" />";
	}
	
	$readonly = 'readonly="readonly"';
	include_once("$skin_dir/write.php");
	
	echo $edit_start;
?>