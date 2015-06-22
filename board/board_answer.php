<?php
	echo $edit_script;
	echo $edit_start;
	
	$parent_id = $_POST['id'];
	//echo $parent_id;
	
	$PSQL = "SELECT iOrder, iDepth, sName, sTitle, sComment FROM ".$table." WHERE id='".$parent_id."'";
	$PRES = $db_conn -> sql($default_db, $PSQL);
	$PARENT = mysql_fetch_assoc($PRES);
	
	$Parent_info = "<fieldset class=\"parent_info\">\n";
	$Parent_info .= "<legend class=\"pname\">". $PARENT['sName'] ."님의 글 내용입니다.</legend>";
	$Parent_info .= "<div class=\"ptitle\">제목 : ". $PARENT['sTitle'] ."</div>";
	$Parent_info .= "<div class=\"pcontent cssReset\">". $PARENT['sComment'] ."</div>";
	$Parent_info .= "</fieldset>";
	
	$file_input = "<input type=\"file\"  name=\"file[]\" />";
	include_once("$skin_dir/write.php");
?>