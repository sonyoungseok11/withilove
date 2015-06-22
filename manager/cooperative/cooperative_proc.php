<?php
include_once("./_common.php");
include_once("$root/lib/phpheader.php");
include_once("$root/lib/function.php");
include_once("$root/lib/class.php");
include_once("$root/lib/db_info.php");
include_once("$root/lib/config.php");

$mode = $_REQUEST['mode'];
$id = $_POST['id'];
$eType = $_POST['eType'];
$iSort = $_POST['iSort'];
$user_id = $_POST['user_id'];
$sTitle = trim($_POST['sTitle']);
$sTitleSubfix = trim($_POST['sTitleSubfix']);
$sSimpleComment = trim($_POST['sSimpleComment']);
$sContents = trim($_POST['sContents']);
$sUrl = trim($_POST['sUrl']);
$sTel = trim($_POST['sTel']);
$sZipCode = $_POST['sZipCode'];
$sAddr  = $_POST['sAddr'];
$sAddrSub = trim($_POST['sAddrSub']);

$logo = $_FILES['file_logo'];
$banner = $_FILES['file_banner'];
$imgs = $_FILES['file_img'];

$delfile = $_POST['delfile'];

switch ($eType) {
	case 'N':
		$reUrl = $path."/cooperative/cooperative_list2.php";
		break;
	default :
		$reUrl = $path."/cooperative/cooperative_list.php";
		break;
}

switch($mode) {
	case 'I' :	// 신규등록
		$ISQL = "
			INSERT INTO `cooperative_firm_list` SET 
				user_id = '".$user_id."',
				eType = '".$eType."',
				iActive = '1',
				iSort = '".$iSort."',
				sTitle = '".$sTitle."',
				sTitleSubfix = '".$sTitleSubfix."',
				sSimpleComment = '".$sSimpleComment."',
				sContents = '".$sContents."',
				sUrl = '".$sUrl."',
				sTel = '".$sTel."',
				sZipCode = '".$sZipCode."',
				sAddr = '".$sAddr."',
				sAddrSub = '".$sAddrSub."',
				iCount = '0',
				dInDate = NOW()
		";
		$IRES = $db_conn -> sql($default_db, $ISQL);
		$id = mysql_insert_id();
		
		filesUpload_cooperative($logo, 'L', $id);
		filesUpload_cooperative($banner, 'B', $id);
		if(is_array($imgs)) {
			filesUpload_cooperative($imgs, 'P', $id);
		}
		$msg = $sTitle." 업체를 등록하였습니다.";
		goMsg($reUrl, $msg);
		break;
	case 'M' :	// 수정
		//print_r($_POST);
		//print_r($_FILES);
		if (is_array($delfile)) { // 삭제할 파일이 있다면 파일 삭제
			delete_files_cooperative($delfile);
		} 
		
		$USQL = "
			UPDATE `cooperative_firm_list` SET 
				user_id = '".$user_id."',
				eType = '".$eType."',
				sTitle = '".$sTitle."',
				sTitleSubfix = '".$sTitleSubfix."',
				sSimpleComment = '".$sSimpleComment."',
				sContents = '".$sContents."',
				sUrl = '".$sUrl."',
				sTel = '".$sTel."',
				sZipCode = '".$sZipCode."',
				sAddr = '".$sAddr."',
				sAddrSub = '".$sAddrSub."'
			WHERE id='". $id ."'
		";
		$URES = $db_conn -> sql($default_db, $USQL);
		
		if (is_array($logo)) {
			filesUpload_cooperative($logo, 'L', $id);
		}
		if (is_array($banner)) {
			filesUpload_cooperative($banner, 'B', $id);
		}
		if(is_array($imgs)) {
			filesUpload_cooperative($imgs, 'P', $id);
		}
		$msg = $sTitle." 업체를 수정하였습니다.";
		goMsg($reUrl, $msg);
		
		break;
	case 'D':	// 삭제
		// 파일부터 삭제
		$FSSQL = "
			SELECT id FROM `cooperative_firm_files` WHERE cooperative_id=".$id."
		";
		$FSRES = $db_conn -> sql($default_db, $FSSQL);
		while (list($f_id) = mysql_fetch_row($FSRES)) {
			$delfile[] = $f_id;
		}
		delete_files_cooperative($delfile);
		$DSQL = "
			DELETE FROM `cooperative_firm_list` WHERE id='".$id."'
		";
		$DRES = $db_conn -> sql($default_db, $DSQL);
		$msg = "업체를 삭제하였습니다.";
		goMsg($reUrl, $msg);
		break;
	case 'S': // 정렬순서 변경
		$ids = $_POST['ids'];
		$iSort=1;
		foreach ($ids as $id) {
			$USQL ="
				UPDATE `cooperative_firm_list` SET
					iSort = '".$iSort."'
				WHERE id='".$id."'
			";
			$URES = $db_conn -> sql($default_db, $USQL);
			$iSort++;
		}
		$msg = "정렬순서를 변경하였습니다.";
		goMsg($reUrl, $msg);
		break;
}

?>
