<!-- 얼럿 메시지 -->
<div id="Alert_Msg" title="">
	<div class="msg"></div>
</div>
<!-- go back 메시지 -->
<div id="Back_Msg" title="">
	<div class="msg"></div>
</div>
<!-- 주소검색 -->
<div id="Search_ZipCode" title="주소검색">
	<div class="tab list jx">
		<ul>
			<li class="active">
				<a href="#" class="tabzip">지번 주소검색</a>
				<ul>
					<li>예) 개포1동 
						<div class="search_form">
							<form class="zip_search_form">
							<input type="hidden" name="searchmode" value="old" class="searchmode" />
							<input type="text" name="search" class="zipinput" />
							<span class="button medium"><input type="submit" value="검색"></span>
							</form>
						</div>
						<ul class="zipResult"></ul>
					</li>
				</ul>
			</li>
			<li>
				<a href="#" class="tabzip">도로명 주소 검색</a>
				<ul>
					<li>예) 가산디지털1로
						<div class="search_form">
							<form class="zip_search_form">
							<input type="hidden" name="searchmode" value="new" class="searchmode" />
							<input type="text" name="search" class="zipinput" />
							<span class="button medium"><input type="submit" value="검색"></span>
							</form>
						</div>
						<ul class="zipResult"></ul>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</div>
<!-- 주소검색 -->
<div id="Search_ZipCode_New" title="주소검색">
	<div class="tab list jx">
		<ul>
			<li class="active">
				<a href="#" class="tabzip">지번 주소검색</a>
				<ul>
					<li>
						지번주소검색은 도로명 주소로 변환되어 저장됩니다.<br />
						지역선택 후 동읍면 지번본번-지번부번 형식으로 입력하세요.<br />
						예) 감물면 402-3
						<div class="search_form">
							<form class="zip_search_form_new">
							<select name="sido"><?=getSelectOption($ZIP_ZONE);?></select>
							<input type="hidden" name="searchmode" value="old" class="searchmode" />
							<input type="text" name="search" class="zipinput" />
							<span class="button medium"><input type="submit" value="검색"></span>
							</form>
						</div>
						<ul class="zipResult"></ul>
					</li>
				</ul>
			</li>
			<li>
				<a href="#" class="tabzip">도로명 주소 검색</a>
				<ul>
					<li>
					지역선택 후 도로명 건물본번-건물부번 형식으로 입력하세요.<br />
					예) 대명로47길 47-4
						<div class="search_form">
							<form class="zip_search_form_new">
							<select name="sido"><?=getSelectOption($ZIP_ZONE);?></select>
							<input type="hidden" name="searchmode" value="new" class="searchmode" />
							<input type="text" name="search" class="zipinput" />
							<span class="button medium"><input type="submit" value="검색"></span>
							</form>
						</div>
						<ul class="zipResult doro"></ul>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</div>
<script></script>
<!-- 회원로그인 -->
<div id="MemberJoin" title="회원 로그인">
	<form action="<?=$root?>/join/sign_in.php" method="post" onsubmit="return check_form(this);">
		<input type="hidden" name="url" value="<?=$_SERVER['PHP_SELF']?>" />
		<ul class="memberlogin">
			<li>
				<label for="sUserId">아이디</label>
				<input type="text" name="sUserId" id="sUserId" class="check_value" />
			</li>
			<li>
				<label for="sUserPw">비밀번호</label>
				<input type="password" name="sUserPw" id="sUserPw" class="check_value" />
			</li>
			<li class="member_login">
				<input type="submit" value="로그인" class="msButton" />
			</li>
		</ul>
	</form>
	<ul class="login_info">
		<li>
			아직 <?=$HOME_CONFIG['HomeTitle']?> 회원이 아닌가요? 
			<span class="button small"><a href="<?=$root?>/sub_etc/member/agrement.php">회원가입</a></span>
		</li>
		<li>
			아이디/비밀번호가 기억나지 않으세요?
			<span class="button small"><a href="javascript:alert('준비중');">ID/PW 찾기</a></span>
		</li>
	</ul>
</div>

<!-- ID/PW 찾기 -->
<div id="SearchIdPw" title="회원 아이디/비밀번호 찾기">
	<div class="tab list jx">
		<ul>
			<li class="active">
				<a href="#" class="tabzip">아이디 찾기</a>
				<ul>
					<li>
						<form action="search_ID" class="check_form_ajax">
						<ul class="search_form">
						
							<li>
								<label for="year">회원가입시 입력하신 생년월일</label>
								<select name="year" id="year" class="check_select">
									<option value="">선택</option>
									<?=getYearOption()?>
								</select> 년
								<select name="month" class="check_select">
									<option value="">선택</option>
									<?=getMonthOption()?>
								</select> 월
								
								<select name="day" class="check_select">
									<option value="">선택</option>
									<?=getDayOption()?>
								</select> 일
							</li>
							<li>
								<label for="email">회원가입시 입력하신 E-mail주소</label>
								<input type="text" name="email" id="email" class="check_email" />
							</li>
							<li>
								<input type="submit" value="아이디 찾기" class="msButton small white find_id" />
								<span class="ajax_loader"></span>
								<span class="result"></span>
							</li>
						
						</ul>
						</form>	
					</li>
					
				</ul>
			</li>
			<li>
				<a href="#" class="tabzip">비밀번호 찾기</a>
				<ul>
					<li>
						<form action="search_PW" class="check_form_ajax">
						<ul class="search_form2">
							
							<li>
								<label for="sUserId2">아이디</label>
								<input type="text" name="sUserId" id="sUserId2" class="check_value" />
							</li>
							<li>
								<label for="sEmail">이메일</label>
								<input type="text" name="sEmail" id="sEmail" class="check_email" />
							</li>

							<li>
								<label for="sHphone">휴대폰 번호</label>
								<input type="text" name="sHphone" id="sHphone" class="check_tel sHphone" />
							</li>
							<li class="lh">
								<input type="hidden" name="smslog_id" class="smslog_id" />
								<input type="hidden" name="sHpConfirm"  class="check_smsconfirm"/>
								<input type="hidden" name="smsMode" value="findPw" class="smsMode" />
								<button class="msButton small white send_sms_confirm">휴대폰 인증 문자받기</button>
								<input type="text" name="sms_confirm" id="sms_confirm" class="onlynumber inline" size="8" maxlength="6" />
								<button class="msButton small post_sms_confirm gray findPw">인증</button>
								<div class="confirm_ajax_loader"></div>
							</li>
						</ul>
						</form>	
						<div id="RESETPASSWORD">
							<div class="ajax_loader"></div>
							<div class="ajax_result"></div>
						</div>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</div>
<!-- 이용약관 -->

<div id="Clause_POP" title="이용약관">
	<div class="pre"><?=$HOME_CONFIG['Clause']?></div>
</div>
<div id="Private_POP" title="개인정보취급방침">
	<div class="pre"><?=$HOME_CONFIG['Private']?></div>
</div>
<div id="Email_POP" title="이메일 무단수집 거부">
	<div class="pre">본 사이트는 게시된 이메일 주소를 전자우편 수집 프로그램이나 그밖의 기술적 장치를 이용해 무단으로 수집되는것을 거부하며, 이를 위반시에는 정보통신망법에 의해 <span class="red">형사 처벌됨을 유념</span>하시기를 바랍니다. <br /> <br /> [게시일 2015년 01월 29일]</div>
</div>

<!-- 파워링크 업체 보기  -->
<div id="CooperativeDetail" title="업체소개">
	<div class="detail">
		<div class="imgbox">
		</div>
		<div class="content">
			<div class="title"><span></span></div>
			<div class="info">
				<p class="home"></p>
				<p class="phone"></p>
				<p class="address"></p>
			</div>
			<div class="comment"></div>
		</div>
	</div>
	<div class="logo"></div>
	<div class="manager">
		
	</div>
	<a href="#" class="dialog_close" title="닫기"></a> 
</div>

<? // if($_SERVER['PHP_SELF'] == '/index.php') {?>
<!--  동영상
<div id="Semina_MOV" title="제1회 세경학 세미나">
	<div>
		<embed width="420" height="315" src="http://www.youtube.com/v/y4ZzWpj7nS8?&loop=1&playlist=y4ZzWpj7nS8&autoplay=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true"></embed>
	</div>
</div>
-->
<? // } ?>

<div id="Suppoters" title="">
	<form class="suppoters_form">
		<input type="hidden" name="mode" value="suppoters" />
		<input type="hidden" name="eType" value="" />
		<ul class="dialog_form2">
			<li>
				<label>
				<div class="lh sName">업체명</div>
				<input type="text" name="sName" value="" class="check_length" />
				</label>
			</li>
			<li>
				<label>
				<div class="lh">연락처</div>
				<input type="text" name="sTel" value="" class="check_tel" />
				</label>
			</li>
			<li>
				<label>
				<div class="lh sText">담당자</div>
				<input type="text" name="sText" value="" class="check_length" />
				</label>
			</li>
		</ul>
		<div><input type="submit" value="신청하기" class="jButton" /></div>
	</form>
</div>

<div id="Education_Nomember_Ask" title="비회원으로 행사 신청을 하시겠습니까?" class="dialog_form edu_ask">
	<div class="info_text">하단의 간단한 기본정보를 작성하고 신청 버튼을 눌러주시면 신청 완료 됩니다.</div>
	
	<div class="title"></div>
	
	<form name="edu_nomember_ask">
	<input type="hidden" name="mode" value="edu_nomember_ask" />
	<input type="hidden" name="board_config_id" value="<?=$board_config_id?>" />
	<input type="hidden" name="board_table" value="<?=$table?>" />
	<input type="hidden" name="board_id" value="<?=$board_id?>" />
	<ul>
		<li>
			<label for="sName_N" class="lh">이름</label>
			<input type="text" name="sName_N" id="sName_N" value="" class="check_length"/>
		</li>
		<li>
			<label for="sHp_N" class="lh">휴대폰</label>
			<input type="text" name="sHp_N" id="sHp_N" value="" class="check_tel"/>
		</li>
		<li>
			<label for="sCenter_N" class="lh">학원명</label>
			<input type="text" name="sCenter_N" id="sCenter_N" value="" />
		</li>
		<li>
			<label for="iNumber_N" class="lh">참가예정인원</label>
			<input type="text" name="iNumber_N" id="iNumber_N" value="" class="onlynumber" />명
		</li>
	</ul>
	</form>
	<div class="info_text2">※ 참가신청 접수 확인을 위해 정확안 휴대전화 번호를 입력해 주시기 바랍니다.</div>
</div>

<script type="text/javascript" src="<?=$root?>/js/dialog.js"></script>