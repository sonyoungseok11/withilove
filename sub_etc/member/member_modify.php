<?php
include_once ("./_common.php");
include_once("$root/subhead.php");

$mode = 'M';
if (empty($MEMBER['id'])) {
	goBackScript('접근 오류', '비정상적인 접근입니다.');
} else {
	$btn_submit_name = "회원정보수정";
	//$btn_cancle = "<button onClick=\"history.go(-1);\" class=\"msButton gray\">뒤로가기</button>";
	$readOnly =  'readonly="readonly"';
	$id_info = "아이디는 수정하실 수 없습니다.";
	$pw_info = "비밀번호 입력시 비밀번호가 변경됩니다.";
	$pw2_info = "비밀번호 변경 확인을 위해 다시 한 번 입력하여 주세요.";
	$change_pw ='change_pw';
	$birthArr = explode("-",$MEMBER['dBirth']);
	$gender['M'] = $MEMBER['eGender'] == 'M' ? 'checked="checked"' : '';
	$gender['F'] = $MEMBER['eGender'] == 'F' ? 'checked="checked"' : '';
	$check_sms = $MEMBER['eSms'] == 'Y' ? 'checked="checked"' : '';
	$check_mailing = $MEMBER['eEmailService'] == 'Y' ? 'checked="checked"' : '';
	$btnStyle ="style=\"width:160px;\"";
	if ($_COOKIE['change'] == 'change') {
		echo "
			<script type=\"text/javascript\">
				$(document).ready(function(e){
					setCookie('change','',0);
					alertMsg('개인정보수정','개인정보수정이 완료되었습니다.');
				});
			</script>
		";
	}
	include_once("$root/sub_etc/member/member_form.php");
}
?>
<?php

include_once("$root/subfoot.php");
?>