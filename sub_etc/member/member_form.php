<form action="<?=$root?>/join/member_proc.php" method="post" onsubmit="return check_form(this)">
	<input type="hidden" name="mode" value="<?=$mode?>" />
	<input type="hidden" name="user_id" value="<?=$MEMBER['id']?>" />
	<ul class="member_join_form">
		<li>
			<label for="sUserName" class="lh">성명</label>
			<input type="text" name="sUserName" id="sUserName" value="<?=$MEMBER['sUserName']?>" class="check_value"/>
		</li>
		<li>
			<label for="sUserId" class="lh">아이디</label>
			<input type="text" name="sUserId" id="sUserId" value="<?=$MEMBER['sUserId']?>" class="<?=$id_class?>" <?=$readOnly?> /> 
			<span><?=$id_info?></span>
		</li>
		<li>
			<label for="sUserPw" class="lh">비밀번호</label>
			<input type="password" name="sUserPw" id="sUserPw" value="" class="check_pw <?=$change_pw?>"/>
			<span><?=$pw_info?></span>
		</li>
		<li>
			<label for="sUserPw2" class="lh">비밀번호 확인</label>
			<input type="password" name="sUserPw2" id="sUserPw2" value="" class="check_pw2 <?=$change_pw?>"/>
			<span><?=$pw2_info?></span>
		</li>
		<li>
			<label for="year" class="lh">생년월일</label>
			<select name="year" id="year" class="check_select">
				<option value="">선택</option>
				<?=getYearOption($birthArr[0]);?>
			</select>년
			<select name="month" class="check_select">
				<option value="">선택</option>
				<?=getMonthOption($birthArr[1]);?>
			</select>월
			<select name="day" class="check_select">
				<option value="">선택</option>
				<?=getDayOption($birthArr[2]);?>
			</select> 일 
		</li>
		<li>
			<div class="lh" >성별</div>
			<input type="radio" name="eGender" id="eGender_M" value="M" <?=$default_checked?> <?=$gender['M']?> /><label for="eGender_M" > 남</label>
			<input type="radio" name="eGender" id="eGender_F" value="F" <?=$gender['F']?> /><label for="eGender_F"> 여</label>
		</li>
		<li>
			<label for="sHphone" class="lh">휴대폰</label>
			<input type="text" name="sHphone" id="sHphone" value="<?=$MEMBER['sHphone']?>" class="check_tel sHphone" />
			<label><input type="checkbox" name="eSms" value="Y" <?=$check_sms?> /> SMS 수신</label>
		</li>
<? if ($mode=='I') { ?>
<!-- 휴대폰 인증 -->	
		<li>
			<label for="sms_confirm" class="lh">휴대폰인증</label>
			<a href="#" class="msButton small blue send_sms_confirm">휴대폰 인증 문자받기</a>
			<span class="confirm_ajax_loader"></span>
			<input type="text" name="sms_confirm" id="sms_confirm" class="onlynumber" size="8" maxlength="6" />
			<input type="hidden" class="smslog_id" />
			<input type="hidden" name="smsMode" value="join" class="smsMode" />
			<input type="hidden" name="sHpConfirm"  class="check_smsconfirm"/>
			<a href="#" class="msButton small gray post_sms_confirm">인증</a>
		</li>
<!-- //휴대폰 인증 -->
<? } ?>	
		<li>
			<label for="sEmail" class="lh">이메일</label>
			<input type="text" name="sEmail" id="sEmail" value="<?=$MEMBER['sEmail']?>" class="check_email" />
			<label><input type="checkbox" name="eEmailService" value="Y" <?=$check_mailing?> /> 메일링 수신</label>
		</li>
		<li>
			<label for="sBusinessType" class="lh">업종</label>
			<select name="sBusinessType" class="check_select">
				<option value="">선택</option>
				<?=getSelectOption_value($USER_SET['BusinessType'], $MEMBER['sBusinessType'] )?>
			</select>
		</li>
		<li>
			<label for="sCenterName" class="lh">학원명</label>
			<input type="text" name="sCenterName" id="sCenterName" value="<?=$MEMBER['sCenterName']?>" />
		</li>
		<li>
			<label for="sAddrSub" class="lh">주소</label>
			<input type="text" name="sZipCode" value="<?=$MEMBER['sZipCode']?>" readonly="readonly" size="8" class="check_zipcode" /> 
			<a href="Search_ZipCode_New" class="msButton small blue dialog_open">우편번호</a>
			<input type="text" name="sAddr" id="sAddr" value="<?=$MEMBER['sAddr']?>" size="60" class="block" readonly="readonly" />
			<input type="text" name="sAddrSub" id="sAddrSub" value="<?=$MEMBER['sAddrSub']?>" size="60" class="check_value" /> 나머지 주소
		</li>
	</ul>
	<div class="member_join_command">
			<input type="submit" value="<?=$btn_submit_name?>" class="msButton" <?=$btnStyle?> />
			<?=$btn_cancle?>
	</div>
</form>