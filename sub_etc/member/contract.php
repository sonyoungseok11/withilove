<?php
include_once ("./_common.php");
include_once("$root/subhead.php");

$STSQL = "SELECT COUNT(t.id) AS cnt , t.*  FROM `tax_contact` t WHERE user_id='".$MEMBER['id']."'";
$STRES = $db_conn -> sql($default_db, $STSQL);
$contact = mysql_fetch_assoc($STRES);
if ($contact['cnt']) {
	$contact['submit'] = "수정하기";
	$mode = "M";
	$contact['iTotalSales'] = number_format($contact['iTotalSales']);
	$contact['iSalary'] = number_format($contact['iSalary']);
	$contact['iRent'] = number_format($contact['iRent']);
	$contact['info'] = ' - '. $CONTRACT['iStep'][$contact['iStep']];
} else {
	$contact['submit'] = "신청하기";
	$mode = "I";
}

if ($contact['eBookeep'] == 'N') {
	$eBookeep['N'] = "checked=\"checked\"";
	$sTaxNameClass2 = "hide";
	
} else {
	$eBookeep['Y'] = "checked=\"checked\"";
	$sTaxNameClass = "check_length";
}

?>
<style>
	.hide {display:none;}
</style>
<div class="page_title"><?=$PageInfo['MenuName']?></div>
<form action="<?=$path?>/sub_etc/member/contract_proc.php" method="post" onsubmit="return check_form(this);">
<input type="hidden" name="mode" value="<?=$mode?>" />
<input type="hidden" name="contract_id" value="<?=$contact['id']?>" />
<div class="member_contact">
	<div class="caption">기본정보</div>
	<ul>
		<li>
			<label class="lh">성명</label><?=$MEMBER['sUserName']?>
		</li>
		<li>
			<label class="lh">아이디</label><?=$MEMBER['sUserId']?>
		</li>
		<li>
			<label class="lh">휴대폰</label><?=$MEMBER['sHphone']?>
		</li>
		<li>
			<label class="lh">이메일</label><?=$MEMBER['sEmail']?>
		</li>
	</ul>
	<div class="caption">추가정보 <span><?=$contact['info']?></span></div>
	
	<ul>
		<li>
			<label for="sName" class="lh">학원명</label>
			<input type="text" name="sName" id="sName" value="<?=$contact['sName']?>" size="30" class="check_length" />
		</li>
		<li class="absolute year">
			<label for="sSince" class="lh">개업년도</label>
			<select name="sSince" id="sSince" class="check_select"><?=getYearOption($contact['sSince'])?></select> 년
		</li>
		<li class="absolute since">
			<label for="eLicense" class="lh">인허가</label>
			<select name="eLicense" id="eLicense" class="check_select"><?=getSelectboxOption($CONTRACT['eLicense'], $contact['eLicense'])?></select>
		</li>
		<li>
			<label for="sTel" class="lh">학원 전화</label>
			<input type="text" name="sTel" id="sTel" value="<?=$contact['sTel']?>" size="30" class="check_tel" />
		</li>
		<li>
			<label for="sAddrSub" class="lh">학원 소재지</label>
			<input type="text" name="sAddrSub" id="sAddrSub" value="<?=$contact['sAddrSub']?>" size="60" class="check_value" /> 시,구,동 단위까지만 적어주세요.
		</li>
		<li>
			<label for="iCounselingTime" class="lh">상담가능시간</label>
			<select name="iCounselingTime" id="iCounselingTime" class="check_select"><?=getSelectboxOption($CONTRACT['iCounselingTime'], $contact['iCounselingTime'])?></select>
		</li>
		<li>
			<label for="iTotalSales" class="lh">월평균 매출액</label>
			<input type="text" name="iTotalSales" id="iTotalSales" value="<?=$contact['iTotalSales']?>" size="8" class="check_length setcomma" /> 만원
		</li>
		<li>
			<label for="iTeacher" class="lh">강사</label>
			<input type="text" name="iTeacher" id="iTeacher" value="<?=$contact['iTeacher']?>" size="4" class="check_length onlynumber" /> 명
		</li>
		<li class="absolute salary">
			<label for="iSalary" class="lh">강사 인건비</label>
			<input type="text" name="iSalary" id="iSalary" value="<?=$contact['iSalary']?>" size="8" class="check_length setcomma" /> 만원(월평균)
		</li>
		<li>
			<label for="iRent" class="lh">월 임차료</label>
			<input type="text" name="iRent" id="iRent" value="<?=$contact['iRent']?>" size="8" class="check_length setcomma" /> 만원
		</li>
		<li>
			<label for="eBookeep" class="lhw">현재 세무사 기장여부</label>
			<label><input type="radio" name="eBookeep" id="eBookeep" value="Y" <?=$eBookeep['Y']?> /> 기장을 하고 있다.</label>
			<span class="<?=$sTaxNameClass2?>"><input type="text" name="sTaxName" value="<?=$contact['sTaxName']?>" size="20" class="<?=$sTaxNameClass?>" /> 세무사 &nbsp;&nbsp;</span>
			<label><input type="radio" name="eBookeep" id="eBookeep2" value="N" <?=$eBookeep['N']?> /> 기장을 하고 있지 않다.</label>
			
		</li>
		<li>
			<label for="sNote" class="lh">기타문의사항</label>
			<textarea name="sNote" id="sNote"><?=$contact['sNote']?></textarea>
		</li>
	</ul>
	<div class="command">
		<input type="submit" value="<?=$contact['submit']?>" class="msButton" />
	</div>
</div>
</form>
<script type="text/javascript">
	$('input[name="eBookeep"]').change(function(e) {
		$('input[name="sTaxName"]').toggleClass('check_length').parent().toggleClass('hide');
	});
</script>

<?php
include_once("$root/subfoot.php");
?>