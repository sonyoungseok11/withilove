<div id="Add_Master" title="관리자 회원 등록">
	<form action="<?=$path?>/add_master.php" method="post" class="form_check">
	<ul class="dialog_form">
		<li>
			<label for="sUserId">아이디</label>
			<input type="text" name="sUserId" id="sUserId" class="check_id JIT_idoverlap" title="아이디는 영문과 숫자 조합 20자 이내 작성" />
		</li> 
		<li>
			<label for="sUserPw">비밀번호</label>
			<input type="text" name="sUserPw" id="sUserPw" class="check_pw" />
		</li>
		<li>
			<label for="sUserPw">이름</label>
			<input type="text" name="sUserName" id="sUserName" class="check_length" value="관리자" />
		</li>
	</ul>
	</form>
</div>
<script type="text/javascript" src="<?=$path?>/js/dialog.js"></script>