<?php
include_once("./_common.php");
include_once("$root/lib/phpheader.php");
include_once("$root/lib/class.php");
include_once("$root/lib/function.php");
include_once("$root/lib/db_info.php");
include_once("$root/lib/config.php");
include_once("$path/lib/adm_config.php");

$HomeTitle = trim($_POST['HomeTitle']);
$MemberJoinSmsMsg = trim($_POST['MemberJoinSmsMsg']);
$MemberFindPwSmsMsg = trim($_POST['MemberFindPwSmsMsg']);
$Clause = trim($_POST['Clause']);
$Private = trim($_POST['Private']);
$SkinCSS = trim($_POST['SkinCSS']);
$sms_url = trim($_POST['sms_url']);
$sms_user_id = trim($_POST['sms_user_id']);
$sms_secure = trim($_POST['sms_secure']);
$sms_sphone = trim($_POST['sms_sphone']);
$sms_seminar = trim($_POST['sms_seminar']);

$HUSQL ="
	UPDATE `home_config` SET 
	HomeTitle = '". $HomeTitle ."',
	MemberJoinSmsMsg = '". $MemberJoinSmsMsg ."',
	MemberFindPwSmsMsg = '". $MemberFindPwSmsMsg ."',
	Clause = '". $Clause ."',
	Private = '". $Private ."',
	SkinCSS = '". $SkinCSS ."',
	sms_url = '".$sms_url."',
	sms_user_id = '".$sms_user_id."',
	sms_secure = '".$sms_secure."',
	sms_sphone = '".$sms_sphone."',
	sms_seminar = '".$sms_seminar."'
	
	
";
$HURES = $db_conn -> sql($default_db, $HUSQL);
$url = "$path/config/config_modify.php";
if ($HURES) {
	$msg = '홈페이지 설정이 변경 되었습니다.';
} else {
	$msg = '홈페이지 설정 변경을 실패하였습니다.';
}
goMsg($url, $msg);
?>