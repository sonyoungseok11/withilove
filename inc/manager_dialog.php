<div id="UserModify" title="회원 정보 신규등록/수정">
	<div class="ajax_loader"></div>
	<div class="user_form">
		<form action="<?=$path?>/member/member_proc.php" method="post">
			<input type="hidden" name="mode" value="" />
			<input type="hidden" name="id" value="" />
			<ul>
				<li>
					<label for="sUserId" class="lh">아이디</label>
					<input type="text" name="sUserId" id="sUserId" value="" readonly="readonly" /> 
				</li>
				<li>
					<label for="iMLevel" class="lh">관리자레벨</label>
					<select name="iMLevel" id="iMLevel">
						<?=getLevelOption()?>
					</select> 관리자 페이지 접근 권한
				</li>
				<li>
					<label for="iHLevel" class="lh">홈페이지레벨</label>
					<select name="iHLevel" id="iHLevel">
						<?=getLevelOption()?>
					</select> 게시판 접근 권한
				</li>
				<li>
					<label for="iUserStatus" class="lh">상태</label>
					<select name="iUserStatus" id="iUserStatus">
						<?=getUserStatusOption()?>
					</select> 회원상태
				</li>
				<li>
					<label for="eUserType" class="lh">Type</label>
					<select name="eUserType" id="eUserType">
						<?=getUserTypeOption()?>
					</select>
				</li>
				<li>
					<label for="sUserName" class="lh">성명</label>
					<input type="text" name="sUserName" id="sUserName" value="" class="check_value"/>
				</li>
				<li>
					<label for="sUserPw" class="lh">비밀번호</label> 
					<input type="password" name="sUserPw" id="sUserPw" value="" class="check_pw change_pw"/> 
					<span class="passInfo">비밀번호 입력시 변경됩니다.</span>
				</li>
				<li>
					<label for="sUserPw2" class="lh">비밀번호 확인</label>
					<input type="password" name="sUserPw2" id="sUserPw2" value="" class="check_pw2 change_pw"/>
				</li>
				<li>
					<label for="year" class="lh">생년월일</label>
					<input type="text" name="dBirth" value="" class="check_ymd" />
				</li>
				<li>
					<div class="lh" >성별</div>
					<input type="radio" name="eGender" id="eGender_M" value="M" /><label for="eGender_M" > 남</label>
					<input type="radio" name="eGender" id="eGender_F" value="F" /><label for="eGender_F"> 여</label>
				</li>
				<li>
					<label for="sHphone" class="lh">휴대폰</label>
					<input type="text" name="sHphone" id="sHphone" value="" class="check_tel sHphone" />
					<label><input type="checkbox" name="eSms" value="Y" /> SMS 수신</label>
				</li>
				<li>
					<label for="sEmail" class="lh">이메일</label>
					<input type="text" name="sEmail" id="sEmail" value="" class="check_email" />
					<label><input type="checkbox" name="eEmailService" value="Y"  /> 메일링 수신</label>
				</li>
				<li>
					<label for="sBusinessType" class="lh">업종</label>
					<select name="sBusinessType" class="check_select">
						<option value="">선택</option>
						<?=getSelectOption_value($USER_SET['BusinessType'], $MEMBER['sBusinessType'])?>
					</select>
				</li>
				<li>
					<label for="sCenterName" class="lh">학원명</label>
					<input type="text" name="sCenterName" id="sCenterName" value="<?=$MEMBER['sCenterName']?>" />
				</li>
				<li>
					<label for="sAddrSub" class="lh">주소</label>
					<input type="text" name="sZipCode" value="" readonly="readonly" size="8" class="check_zipcode" /> 
					<a href="Search_ZipCode_New" class="msButton small blue dialog_open">우편번호</a>
					<input type="text" name="sAddr" id="sAddr" value="" size="40" class="block" readonly="readonly" />
					<input type="text" name="sAddrSub" id="sAddrSub" value="" size="40" class="check_value" />
				</li>
			</ul>
		</form>
	</div>
</div>

<div id="SMS_Manager" title="문자 전송 관리자">
	<div class="sms_top">
		<b>문자 잔여건수</b> : <span class="sms_total_count blue"></span>건
		<span class="side"><b>받는사람</b> : (<span class="user_total blue"></span>)명</span>
	</div>
	<div class="sms_left">
		<textarea id="SMS_TEXT" onkeyup="sms_manager.set_bytes();"></textarea>
		<div class="left_buttonset">
			<a href="javascript:;" class="jButton small" onclick="sms_manager.insert_preset(this);">문자 프리셋 저장</a>
			<a href="javascript:;" class="jButton small" onclick="sms_manager.setText_name();">{name}님</a>
			<span class="bytes"></span>
		</div>
	</div>
	<div class="sms_right">
		<ul class="user_list">
		</ul>
		<div class="add_user">
			<form action="#" onsubmit="return sms_manager.insert_user_check();">
				<input type="text" id="smsAddName" class="check_length" />
				<input type="text" id="smsAddHp" class="check_tel" />
				<input type="submit" value="추가" class="jButton small">
			</form>
		</div>
	</div>
	<div class="sms_bottom">
		
	</div>
</div>

<!-- 회원검색 -->
<div id="Search_Mebmber" title="회원 검색" class="dialog_form">
	<form>
	<input type="hidden" name="search_mode" value="" />
	<ul >
		<li>
			<label for="MsearchType" class="lh">검색방법</label>
			<select name="MsearchType" id="MsearchType" class="check_select">
				<option value="sUserId">ID</option>
				<option value="sUserName">이름</option>
			</select>
		</li>
		<li>
			<label for="MsearchStr" class="lh">검색어</label>
			<input name="MsearchStr" id="MsearchStr" value="" class="check_length" />
		</li>
	</ul>
	</form>
	<div class="search_result">
	
	</div>
</div>
<script type="text/javascript" src="<?=$root?>/js/manager_dialog.js"></script>