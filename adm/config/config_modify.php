<?php
	include_once ("./_common.php");
	include_once ("$path/inc/header.php");
	include_once ("$path/inc/gnb.php");
?>
<style type="text/css">
.home_config {padding:15px;}
.home_config h3 {font-size:16px; margin-bottom:20px;}
.home_config li {border-top:1px solid #ccc; padding:10px;}
.home_config li label {font-size:14px; font-weight:bold;}
.home_config li label + span {color:#f60; font-weight:normal; font-size:11px; cursor:text;}
.home_config li input[type="text"], .home_config li textarea {display:block; width:100%; padding:10px; box-sizing:border-box; margin-top:8px;}
.home_config li textarea {height:150px;}
.home_config ul + div {text-align:center; padding:15px;}
</style>
<div class="home_config">
	<h3>환경설정</h3>
	<form name="siteConfig" action="<?=$path?>/config/config_proc.php" method="post" onsubmit="return check_form(this);">
		<ul>
			<li>
				<label for="HomeTitle">홈페이지 제목</label>
				<input type="text" name="HomeTitle" id="HomeTitle" value="<?=$HOME_CONFIG['HomeTitle']?>" class="check_value" />
			</li>
			<li>
				<label for="SkinCSS">홈페이지 스킨 css 파일명</label> <span>확장자 빼고 순수 css파일이름만 css폴더에 파일이 있어야 함</span>
				<input type="text" name="SkinCSS" id="SkinCSS" value="<?=$HOME_CONFIG['SkinCSS']?>" class="check_value" />
			</li>
			<li>
				<label for="sms_url">SMS URL</label>
				<input type="text" name="sms_url" id="sms_url" value="<?=$HOME_CONFIG['sms_url']?>" class="check_value" />
			</li>
			<li>
				<label for="sms_user_id">SMS ID</label>
				<input type="text" name="sms_user_id" id="sms_user_id" value="<?=$HOME_CONFIG['sms_user_id']?>" class="check_value" />
			</li>
			<li>
				<label for="sms_secure">SMS 인증키</label>
				<input type="text" name="sms_secure" id="sms_secure" value="<?=$HOME_CONFIG['sms_secure']?>" class="check_value" />
			</li>
			<li>
				<label for="sms_sphone">SMS 발신번호</label>
				<input type="text" name="sms_sphone" id="sms_sphone" value="<?=$HOME_CONFIG['sms_sphone']?>" class="check_tel" />
			</li>
			<li>
				<label for="MemberJoinSmsMsg">회원가입 SMS 메시지</label> <span>[HOMETITLE] => 홈페이지제목, [SMSNUMBER] => 인증번호, [MEMNAME] => 회원이름</span>
				<input type="text" name="MemberJoinSmsMsg" id="MemberJoinSmsMsg" value="<?=$HOME_CONFIG['MemberJoinSmsMsg']?>" class="check_value" />
			</li>
			<li>
				<label for="MemberFindPwSmsMsg">비밀번호찾기 SMS 메시지</label> <span>[HOMETITLE] => 홈페이지제목, [SMSNUMBER] => 인증번호, [MEMNAME] => 회원이름</span>
				<input type="text" name="MemberFindPwSmsMsg" id="MemberFindPwSmsMsg" value="<?=$HOME_CONFIG['MemberFindPwSmsMsg']?>" class="check_value"/>
			</li>
			<li>
				<label for="Clause">이용약관</label>
				<textarea name="Clause" id="Clause"><?=$HOME_CONFIG['Clause']?></textarea>
			</li>
			<li>
				<label for="Private">개인정보 보호정책</label>
				<textarea name="Private" id="Private"><?=$HOME_CONFIG['Private']?></textarea>
			</li>
			<li>
				<label for="sms_seminar">세미나신청 SMS 메시지</label> <span>{HOMETITLE} => 홈페이지제목,  {name} => 회원이름</span>
				<input type="text" name="sms_seminar" id="sms_seminar" value="<?=$HOME_CONFIG['sms_seminar']?>" class="check_value" />
			</li>
		</ul>
		<div>
			<span class="button large icon"><span class="check"></span><input type="submit" value="수 정" /></span>
		</div>
	</form>
</div>
<?php
	include_once ("$path/inc/footer.php");
?>