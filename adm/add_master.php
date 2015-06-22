<?php
include_once("./_common.php");
include_once("$root/lib/phpheader.php");
include_once("$root/lib/class.php");
include_once("$root/lib/db_info.php");
include_once("$root/lib/config.php");
include_once("$path/lib/adm_config.php");

$sUserId = trim($_POST['sUserId']);
$sUserPw = md5($db_conn -> rc4crypt(trim($_POST['sUserPw'])));
$sUserName = trim($_POST['sUserName']);

$ISQL= "
	INSERT INTO `users` SET 
		iMLevel='1',
		iHLevel='1',
		sUserId='".$sUserId."',
		sUserPw='".$sUserPw."', 
		sUserName='".$sUserName."',
		eUserType='M',
		iUserStatus='1'
";
$IRES = $db_conn -> sql($default_db, $ISQL);

if ($IRES) {
	setcookie('addMaster','true,'. $sUserId .'', 0,'/');
} else {
	setcookie('addMaster','false,'. $sUserId .'', 0,'/');
}

?>

<script type="text/javascript">
	location.href="<?=$path?>/index.php";
</script>
