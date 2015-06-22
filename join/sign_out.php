<!--<?php
include_once("./_common.php");
include_once("$root/lib/phpheader.php");
include_once("$path/lib/function.php");
include_once("$root/lib/class.php");
include_once("$root/lib/db_info.php");
include_once("$path/lib/config.php");

	$LSQL = "
			UPDATE `user_login_log` SET
				iActive ='0',
				dLogDate = NOW()
			WHERE user_id = '".$MEMBER['id']."'
		";
	$LRES = $db_conn -> sql($default_db, $LSQL);
	setcookie(md5('EncodeData'),'',0,'/');
	
?>
<script type="text/javascript">
	location.href= "<?=$root?>/index.php";
</script> -->