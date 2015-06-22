<?php
include_once ("./_common.php");
include_once("$root/subhead.php");

$mode = $_POST['mode'];
$agree1 = $_POST['agree1'];
$agree2 = $_POST['agree2'];
if ($agree1==1 && $agree2==1) {
	$btn_submit_name = "가입하기";
	$btn_cancle = "<button onClick=\"history.go(-1);\" class=\"msButton gray\">가입취소</button>";
	$default_checked = 'checked="checked"';
	$id_info = "영문 또는 숫자를 사용하여 6~20자 이내로 입력해 주세요. 한글 및 특수문자는 입력이 불가능합니다.";
	$pw_info = "영문, 숫자를 혼합하여 6~20자 이내로 입력하여 주세요.";
	$pw2_info = "비밀번호 확인을 위해 다시 한 번 입력하여 주세요.";
	$id_class = "check_id JIT_idoverlap";
} else {
	goBackScript('접근 오류', '이용약관에 동의 하셔야 가입이 이루어집니다.');
}

?>
<div class="member_join_step">
	<span class="step1"><span class="blind">1 약관확인</span></span>
	<span class="step2 on"><span class="blind">2 회원정보 입력</span></span>
	<span class="step3"><span class="blind">3 회원가입 완료</span></span>
</div>


<?php
include_once("$root/sub_etc/member/member_form.php");
include_once("$root/subfoot.php");
?>