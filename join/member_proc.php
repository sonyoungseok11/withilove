<!--<?php
include_once("./_common.php");
include_once("$root/lib/phpheader.php");
include_once("$root/lib/function.php");
include_once("$root/lib/class.php");
include_once("$root/lib/db_info.php");
include_once("$root/lib/config.php");

$mode  = $_POST['mode'];
$user_id = $_POST['user_id'];
$sUserName = trim($_POST['sUserName']);
$sUserId = trim($_POST['sUserId']);
$sUserPw = empty($_POST['sUserPw']) ? false : md5($db_conn -> rc4crypt(trim($_POST['sUserPw'])));
$dBirth = trim($_POST['year']).'-'.trim($_POST['month']).'-'.trim($_POST['day']);
$eGender = trim($_POST['eGender']);
$sHphone = trim($_POST['sHphone']);
$eSms = empty($_POST['eSms']) ? 'N' : 'Y';
$sEmail = trim($_POST['sEmail']);
$eEmailService = empty($_POST['eEmailService']) ? 'N' : 'Y';
$sZipCode = trim($_POST['sZipCode']);
$sAddr = trim($_POST['sAddr']);
$sAddrSub = trim($_POST['sAddrSub']);
$eUserType = empty($_POST['eUserType']) ? 'S' : $_POST['eUserType'];
$iMLevel= empty($_POST['iMLevel']) ? 9 : $_POST['iMLevel'];
$iHLevel = empty($_POST['iHLevel']) ? 9 : $_POST['iHLevel'];
$sBusinessType = $_POST['sBusinessType'];
$sCenterName = trim($_POST['sCenterName']);

switch($mode) {
	case 'I': // 신규회원가입
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
		echo "
			<form action=\"".$root."/sub_etc/member/member_complete.php\" id=\"complete\" method=\"post\">
				<input type=\"hidden\" name=\"sUserName\" value=\"".$sUserName."\" />
			</form>
			<script type=\"text/javascript\">
				document.getElementById('complete').submit();
			</script>
		";
		break;
	case 'M': // 회원정보수정
		$USQL = "
			UPDATE `users` SET
			";
		if ($sUserPw) { // 비밀번호 입력시에만 변경
			$USQL .= "sUserPw='".$sUserPw."',
			";
			$change_pw = true;
		}
		$USQL .="
				sUserName='".$sUserName."',
				dBirth='".$dBirth."',
				eGender='".$eGender."',
				sZipCode='".$sZipCode."',
				sAddr='".$sAddr."',
				sAddrSub='".$sAddrSub."',
				sHphone='".$sHphone."',
				eSms='".$eSms."',
				sEmail='".$sEmail."',
				eEmailService='".$eEmailService."',
				sBusinessType='".$sBusinessType."',
				sCenterName = '".$sCenterName."'
			WHERE id='".$user_id."'
		";
		$sPwEncode = $change_pw == true ? $sUserPw : $MEMBER['sUserPw'] ;
		$URES = $db_conn -> sql($default_db, $USQL);
		
		setcookie(md5('EncodeData'),'',0,'/');
		echo "
			<form action=\"".$root."/join/sign_in.php\" id=\"complete\" method=\"post\">
				<input type=\"hidden\" name=\"mode\" value=\"modify\" />
				<input type=\"hidden\" name=\"url\" value=\"/sub_etc/member/member_modify.php\" />
				<input type=\"hidden\" name=\"sUserId\" value=\"". $sUserId ."\" />
				<input type=\"hidden\" name=\"sPwEncode\" value=\"". $sPwEncode ."\" />
			</form>
			<script type=\"text/javascript\">
				document.getElementById('complete').submit();
			</script>
		";
		
		break;
}
?> -->