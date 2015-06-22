<?php
include_once("./_common.php");
include_once("$root/lib/phpheader.php");
include_once("$root/lib/function.php");
include_once("$root/lib/class.php");
include_once("$root/lib/db_info.php");
include_once("$root/lib/config.php");

$mode = $_REQUEST['mode'];

switch($mode) {
	case 'get_menu1': // 대분류 불러오기
		$STSQL = "SELECT id, iGroup, iSort, iMLevel, iHLevel, sMenuName FROM `sitemenu` WHERE iParent_id=0 ORDER BY iSort";
		$STRES = $db_conn -> sql($default_db, $STSQL);
		$i=0;
		while($row = mysql_fetch_assoc($STRES)) {
			$Data[$i++] = $row;
		}
		echo json_encode($Data);
		break;
	case 'get_menu2': // 중분류 불러오기
		$iParent_id = $_POST['parent_id'];
		$STSQL = "SELECT id, iActive, iGroup, iSort, iMLevel, iHLevel, sMenuName, sMenuUrl, sClass, sStyle FROM sitemenu WHERE iParent_id='".$iParent_id."' ORDER BY iActive DESC, iSort";
		$STRES = $db_conn -> sql($default_db, $STSQL);
		$i=0;
		while($row = mysql_fetch_assoc($STRES)) {
			$Data[$i++] = $row;
		}
		echo json_encode($Data);
		break;
	case 'get_menu3' : //소메뉴 불러오기
		$iParent_id = $_POST['parent_id'];
		$STSQL = "SELECT id, board_config_id , iActive, iGroup, iSort, iMLevel, iHLevel, sMenuName, sMenuUrl, sClass, sStyle FROM sitemenu WHERE iParent_id='".$iParent_id."' ORDER BY iActive DESC, iSort";
		$STRES = $db_conn -> sql($default_db, $STSQL);
		$i=0;
		while($row = mysql_fetch_assoc($STRES)) {
			$Data['menu'][$i++] = $row;
		}
		// 게시판 목록 불러오기
		$SBSQL = "SELECT id, sBoardSubject FROM `board_config`";
		$SBRES = $db_conn -> sql($default_db, $SBSQL);
		$j=0;
		while($row2 = mysql_fetch_assoc($SBRES)) {
			$Data['board'][$j++] = $row2;
		}
		echo json_encode($Data);
		break;
	case 'menu_update' : // 메뉴 수정
		$id =  $_POST['id'];
		$board_config_id = isset($_POST['board_config_id']) ? $_POST['board_config_id'] : 0 ;
		$iActive =  isset($_POST['iActive']) ? $_POST['iActive'] : 0 ;
		$sMenuName = trim($_POST['sMenuName']);
		$sMenuUrl = trim($_POST['sMenuUrl']);
		$sClass = trim($_POST['sClass']);
		$sStyle = trim($_POST['sStyle']);
		$iMLevel = $_POST['iMLevel'];
		$iHLevel = $_POST['iHLevel'];
		$USQL = "
			UPDATE `sitemenu` SET
				board_config_id = '".$board_config_id."',
				iActive = '".$iActive."',
				iMLevel = '".$iMLevel."',
				iHLevel = '".$iHLevel."',
				sMenuName = '".$sMenuName."',
				sMenuUrl = '".$sMenuUrl."',
				sClass = '".$sClass."',
				sStyle = '".$sStyle."'
			WHERE id='".$id."'
		";
		$URES = $db_conn -> sql($default_db, $USQL);
		if ($URES) {
			echo 'Y';
		} else {
			echo 'N';
		}
		break;
	case 'menu_insert' : // 신규메뉴 등록
		//print_r($_POST);
		$data = $_POST['data'];
		$board_config_id = $data['board_config_id'];
		$iActive = $data['iActive'];
		$iGroup = $data['iGroup'];
		$iParent_id = $data['iParent_id'];
		$iSort = $data['iSort'];
		$sMenuName = $data['sMenuName'];
		$sMenuUrl = $data['sMenuUrl'];
		$sClass = $data['sClass'];
		$sStyle = $data['sStyle'];
		$iMLevel = $data['iMLevel'];
		$iHLevel = $data['iHLevel'];
		
		$ISQL ="
			INSERT INTO `sitemenu` SET 
				board_config_id = '".$board_config_id."',
				iActive = '".$iActive."',
				iGroup = '".$iGroup."',
				iParent_id = '".$iParent_id."',
				iSort = '".$iSort."',
				iMLevel = '".$iMLevel."',
				iHLevel = '".$iHLevel."',
				sMenuName = '".$sMenuName."',
				sMenuUrl = '".$sMenuUrl."',
				sClass = '".$sClass."',
				sStyle = '".$sStyle."'
		";
		$IRES = $db_conn -> sql($default_db, $ISQL);
		if ($IRES) {
			echo 'Y';
		} else {
			echo 'N';
		}
		break;
	case 'menu_delete' :  // 메뉴삭제
		$id = $_POST['id'];
		$DSQL = "DELETE FROM `sitemenu` WHERE id='".$id."'";
		$DRES = $db_conn -> sql($default_db, $DSQL);
		if ($DRES) {
			echo 'Y';
		} else {
			echo 'N';
		} 
		break;
	case 'menu_sort_update' : // 메뉴 정렬 Update
		$idArr = $_POST['idArr'];
		$sort=1;
		foreach($idArr as $id) {
			$USQL = "UPDATE `sitemenu` SET iSort='". $sort++ ."' WHERE id='". $id ."'";
			$URES = $db_conn -> sql($default_db, $USQL);
		}
		if ($URES) {
			echo 'Y';
		} else {
			echo 'N';
		}
		break;
	default :
		echo '모드가 없습니다.';
		break;

}
?>