<?php
include_once ("./_common.php");
include_once ("$path/inc/header.php");
if (!empty($MEMBER['id'])) {
	include_once("$path/sub_etc/member/contract.php");
} else {
	include_once("$root/subhead.php");
	echo '<script type="text/javascript">
		$(document).ready(function(e) {
			goBackMsg("알림","회원가입, 로그인이 필요한 페이지 입니다.");
		});
	</script>';
}
?>


<?php
if (empty($MEMBER['id'])) {
	include_once("$root/subfoot.php");
}

?>