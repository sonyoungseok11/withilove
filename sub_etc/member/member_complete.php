<?php
include_once ("./_common.php");
include_once("$root/subhead.php");
$username= $_POST['sUserName'];
?>
<div class="member_join_step">
	<span class="step1"><span class="blind">1 약관확인</span></span>
	<span class="step2"><span class="blind">2 회원정보 입력</span></span>
	<span class="step3 on"><span class="blind">3 회원가입 완료</span></span>
</div>
<div class="member_join_complete">
	<p><span class="username"><?=$username?></span>님, 위드프랭즈 교육원에 가입해 주셔서 감사합니다.</p>
	<p>개인정보확인 및 수정은 로그인 후 개인정보 수정에서 하실 수 있습니다.</p>
</div>
<div class="member_complete_command">
	<a href="MemberJoin" class="msButton dialog_open">로그인</a>
	<a href="<?=$root?>/index.php" class="msButton gray">메인으로</a>
</div>
<?php
include_once("$root/subfoot.php");
?>