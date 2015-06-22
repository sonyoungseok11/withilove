<?php
include_once("./_common.php");
include_once("$root/lib/phpheader.php");
include_once("$root/lib/function.php");
include_once("$root/lib/class.php");
include_once("$root/lib/db_info.php");
include_once("$root/lib/config.php");

$mode = $_POST['mode'];

$id= $_POST['id'];
$sUserId = $_POST['sUserId'];
$iMLevel = $_POST['iMLevel'];
$iHLevel = $_POST['iHLevel'];
$iUserStatus = $_POST['iUserStatus'];
$eUserType = $_POST['eUserType'];
$sUserName = $_POST['sUserName'];
$dBirth = $_POST['dBirth'];
$eGender = $_POST['eGender'];
$sHphone = $_POST['sHphone'];
$eSms = empty($_POST['eSms']) ? 'N' : 'Y';
$sEmail = $_POST['sEmail'];
$eEmailService = empty($_POST['eEmailService']) ? 'N' : 'Y';
$sZipCode = $_POST['sZipCode'];
$sAddr = $_POST['sAddr'];
$sAddrSub = $_POST['sAddrSub'];
$sUserPw = empty($_POST['sUserPw']) ? false : md5($db_conn -> rc4crypt(trim($_POST['sUserPw'])));
$sBusinessType = $_POST['sBusinessType'];
$sCenterName = trim($_POST['sCenterName']);

switch($mode) {
	case 'I' :
		$ISQL = "
			INSERT INTO `users` SET
				iMLevel='".$iMLevel."',
				iHLevel='".$iHLevel."',
				sUserId='".$sUserId."',
				sUserPw='".$sUserPw."',
				sUserName='".$sUserName."',
				eUserType='".$eUserType."',
				dBirth='".$dBirth."',
				eGender='".$eGender."',
				sZipCode='".$sZipCode."',
				sAddr='".$sAddr."',
				sAddrSub='".$sAddrSub."',
				sHphone='".$sHphone."',
				eSms='".$eSms."',
				sEmail='".$sEmail."',
				eEmailService='".$eEmailService."',
				iUserStatus='1',
				sBusinessType='".$sBusinessType."',
				sCenterName = '".$sCenterName."',
				dInDate=NOW()
		";
		$IRES = $db_conn -> sql($default_db, $ISQL);
		goMsg("$path/member/member_list.php", $sUserId. ' 회원이 등록 되었습니다.' );
		break;
		
	case 'M' : // 회원정보수정
		
		$USQL ="
			UPDATE `users` SET
				iMLevel = '". $iMLevel ."',
				iHLevel = '". $iHLevel ."',
			";
		if ($sUserPw) { // 비밀번호 입력시에만 변경
			$USQL .= "sUserPw='".$sUserPw."',
			";
		}
		$USQL .= "
				sUserName = '". $sUserName ."',
				eUserType = '". $eUserType ."',
				dBirth = '". $dBirth ."',
				eGender = '". $eGender ."',
				sZipCode = '". $sZipCode ."',
				sAddr = '". $sAddr ."',
				sAddrSub = '". $sAddrSub ."',
				sHphone = '". $sHphone ."',
				eSms = '". $eSms ."',
				sEmail = '". $sEmail ."',
				eEmailService = '". $eEmailService ."',
				sBusinessType='".$sBusinessType."',
				sCenterName = '".$sCenterName."'
			WHERE id='". $id ."'
		";
		
		$URES = $db_conn -> sql($default_db, $USQL);
		
		goMsg("$path/member/member_list.php", $sUserId. ' 회원 정보가 수정 되었습니다.' );
		break;
	case 'S': // 회원상태 변경
		$OSQL ="
			UPDATE `users` SET
				iUserStatus	= '".$iUserStatus."'
			";
		if($iUserStatus == '10') { // 탈퇴 회원변경이면 탈퇴시간 등록
			$OSQL .= ", dOutDate=NOW()";
		}
		$OSQL .=" WHERE id='". $id ."'";
		$ORES = $db_conn -> sql($default_db, $OSQL);
		goMsg("$path/member/member_list.php", $sUserId. ' 회원 상태가 변경 되었습니다.' );
		break;
}