<?php
include_once ("./_common.php");
include_once("$root/subhead.php");
?>
<!-- 가입 순서 스텝 -->
<div class="member_join_step">
	<span class="step1 on"><span class="blind">1 약관확인</span></span>
	<span class="step2"><span class="blind">2 회원정보 입력</span></span>
	<span class="step3"><span class="blind">3 회원가입 완료</span></span>
</div>
<!-- 가입 순서 스텝 -->
<form action="<?=$root?>/sub_etc/member/member_create.php" method="post" onSubmit="return check_form(this);">
	<input type="hidden" name="mode" value="I" />
	<ul class="member_join_agreement">
		<li>
			<div class="lh">이용약관</div>
			<div class="comment"><?=$HOME_CONFIG['Clause']?><div></div></div>
			<input type="checkbox" name="agree1" id="agree1" value="1" class="check_checkbox" />
			<label for="agree1">이용약관에 동의합니다.</label>
		</li>
		<li>
			<div class="lh">개인정보취급방침</div>
			<div class="comment"><?=$HOME_CONFIG['Private']?><div></div></div>
			<input type="checkbox" name="agree2" id="agree2" value="1" class="check_checkbox" />
			<label for="agree2">개인정보의 수집 및 이용 목적에 동의합니다.</label>
		</li>
	</ul>

	<div class="member_join_command">
		<input type="submit" value="가입하기" class="msButton"/>
		<button onClick="history.go(-1);" class="msButton gray">가입취소</button>
	</div>
</form>

<?php
include_once("$root/subfoot.php");
?>