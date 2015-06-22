<?php
include_once("./_common.php");
include_once("$root/lib/phpheader.php");
include_once("$root/lib/function.php");
include_once("$root/lib/class.php");
include_once("$root/lib/db_info.php");
include_once("$root/lib/config.php");

$mode = $_REQUEST['mode'];

switch($mode) {
	case 'UserModify' :  // 유저 정보 가져오기
		$id = $_POST['id'];
		$SSQL = "SELECT id, iMLevel,iHLevel, sUserId, sUserName, eUserType, dBirth, eGender, sZipCode, sAddr, sAddrSub, sTel, sHphone, eSms, sEmail,eEmailService,iUserStatus, sBusinessType, sCenterName FROM `users` WHERE id='".$id."'";
		$SRES = $db_conn -> sql($default_db, $SSQL);
		$USER = mysql_fetch_assoc($SRES);
		echo json_encode($USER);
		break;
	default :
		echo '모드가 없습니다.';
		break;

}