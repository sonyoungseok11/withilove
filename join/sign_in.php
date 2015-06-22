<!--<?php

include_once("./_common.php");
include_once("$root/lib/phpheader.php");
include_once("$path/lib/function.php");
include_once("$root/lib/class.php");
include_once("$root/lib/db_info.php");
include_once("$path/lib/config.php");

$mode = $_POST['mode'];
$url = empty($_POST['url']) ? $root.'/index.php' : $_POST['url'];
$sUserId = trim($_POST['sUserId']);

switch ($mode) {
	case 'modify' :
		$sUserPw = $_POST['sPwEncode'];
		setcookie('change','change',0,'/');
		break;
	default :
		$sUserPw = md5($db_conn -> rc4crypt(trim($_POST['sUserPw'])));
		break;
}

$CSQL ="SELECT COUNT(id) FROM `users` WHERE sUserId='".$sUserId."' AND sUserPw='".$sUserPw."'";
$CRES = $db_conn -> sql($default_db, $CSQL);
list($count) = mysql_fetch_row($CRES);

if ($count==1) {
	$SSQL = "SELECT * FROM `users` WHERE sUserId='".$sUserId."' AND sUserPw='".$sUserPw."'";
	$SRES = $db_conn -> sql($default_db, $SSQL);
		
	while ($arr = mysql_fetch_assoc($SRES)) {
		$user = $arr;
	}
	switch ($user['iUserStatus']) {
		case '1' : // 정상적인 로그인
			$EncodeData = $db_conn -> LoginInfoEncode($user);
				setcookie(md5('EncodeData'), $EncodeData,0,'/');
				$login = true;
			// 로그인 기록을 남김
			$LSQL = "SELECT COUNT(user_id) FROM `user_login_log` WHERE user_id='". $user['id'] ."'";
			$LRES = $db_conn -> sql($default_db, $LSQL);
			list ($log_count) = mysql_fetch_row($LRES);
			
			// 최초 로그인 이라면 로그인 기록을 남긴다.
			if ($log_count == 0) { 
				$ULSQL = "
					INSERT INTO `user_login_log` SET
						user_id = '". $user['id'] ."',
						iActive = '1',
						dLogDate = NOW()
				";
				$ULRES = $db_conn -> sql($default_db, $ULSQL);
			}
			break;
		case '2' : //임시블럭 회원
			$login = false;
			$msg = '임시블럭중인 회원입니다. \n\n관리자에게 문의하세요.';
			break;
		case '10' : //탈퇴 회원
			$login = false;
			$msg = '탈퇴하신 회원입니다.';
			break;
	}
} else {
	$login = false;
	$msg = '아이디 또는 비밀번호가 맞지 않습니다.';
}

if ($login) {
	echo '
		<script type="text/javascript">
			location.href="'. $url .'";
		</script>
	';
} else {
	goMsg ($url, $msg);
}
?> -->