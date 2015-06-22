<?php
include_once ("./_common.php");
include_once ("$path/inc/header.php");
include_once ("$path/inc/gnb.php");
include_once("$root/town/town_function.php");

$mode = empty($_REQUEST['mode']) ? 'I' : $_REQUEST['mode'];

switch ($mode) {
	case 'M':
		$id = $_POST['id'];
		$pw = empty($MEMBER['sUserPw']) ? md5($db_conn -> rc4crypt(trim($_POST['pw']))) : $MEMBER['sUserPw'];
		$SSQL = "SELECT user_id, sPw, zip_table, sSigun, sDong, town_group1_id, town_group2_id, sName, sCeo, sTel, sHphone, sZipCode, sAddr, sAddrSub, sMapSearch, sUrl, sContent FROM `town_academy` WHERE id='".$id."'";
		$SRES = $db_conn->sql($default_db, $SSQL);
		$TOWN = mysql_fetch_assoc($SRES);
		
		if (!($MEMBER['iHLevel'] == 1 || $MEMBER['id'] == $TOWN['user_id'])) {
			if ($TOWN['sPw'] != $pw) {
				goBack('접근 권한이 없습니다.');
				exit;
			}
		}
		//print_r($TOWN);
		
		//2차 분류 그룹 가져오기
		if ($TOWN['town_group2_id'] > 0) {
			$GSQL2 = "SELECT id, sGroupName FROM `town_group2` WHERE town_group1_id='".$TOWN['town_group1_id']."' ORDER BY iSort";
			$GRES2 = $db_conn -> sql($default_db, $GSQL2);
			while ($row = mysql_fetch_assoc($GRES2)) {
				$Group2[$row['id']] = $row['sGroupName'];
			}
			$Gsel2 ="";
			$Gsel2 .= "<select class=\"check_select group2\" name=\"town_group2_id\">";
			$Gsel2 .= "<option value=\"\"> - 2차 분류 - </option>";
			$Gsel2 .= getSelectOption($Group2, $TOWN['town_group2_id']);
			$Gsel2 .= "</select>";
			
		} else {
			$Gsel2 = "<input type=\"hidden\" name=\"town_group2_id\" class=\"group2\" value=\"0\">";
		}
		
		// 첨부파일 처리 
		$CFSQL = "SELECT COUNT(id) FROM `town_file` WHERE town_academy_id='".$id."' AND eType='P' ";
		$CFRES = $db_conn->sql($default_db, $CFSQL);
		list($fcnt) = mysql_fetch_row($CFRES);
		$file_inputs ="";
		if ($fcnt > 0 ) {
			$FSQL = "SELECT id, sPath, sFile FROM `town_file` WHERE town_academy_id='".$id."' AND eType='P' ORDER BY id";
			$FRES = $db_conn->sql($default_db, $FSQL);
			while($img = mysql_fetch_assoc($FRES)) {
				$file_inputs .= "<a href=\"".$img['id']."\" class=\"imgpreview\"><span style=\"background-image:url(".$root.$img['sPath']."/thumb/".$img['sFile'].");\"></span>삭제</a>";
			}
		}
		if ($fcnt < 5) {
			$file_inputs .= "<input type=\"file\" name=\"files[]\" accept=\"image/*\" />";
		}
		
		$change_pw = "change_pw";
		$btn_title = "우리 동네 학원 정보 수정";
		$pw_info = "입력시 비밀번호가 변경됩니다.";
		break;
	default :
		$btn_title = "우리 동네 학원 신청";
		$file_inputs = "<input type=\"file\" name=\"files[]\" accept=\"image/*\" />";
		break;
}

/* 지역 정보 DB 가져오기 
$ZoneSQL = "SELECT id, sArea, sSearch FROM `town_zone` ORDER BY iSort";
$ZoneRES = $db_conn -> sql($default_db, $ZoneSQL);
while ($row = mysql_fetch_assoc($ZoneRES)) {
	$Zone[$row['id']] = $row['sArea'];
	$ZoneSearch[$row['id']] = $row['sSearch'];
}
*/
/* 지역정보 javascript 변수에 담기 검색용*/
$Zone_script =  '<script type="text/javascript">
		var Zone = {';
foreach ($ZIP_ZONE as $key => $value) {
	$Zone_script .=  $key .' : "'	.$value .'",';
}
$Zone_script .= '
			};
		</script>';
echo $Zone_script;

/* 1차 분류 가져오기 */
$GSQL1 = "SELECT id, sGroupName FROM `town_group1` ORDER BY iSort";
$GRES1 = $db_conn -> sql($default_db, $GSQL1);
while ($row = mysql_fetch_assoc($GRES1)) {
	$Group1[$row['id']] = $row['sGroupName'];
}

?>

<script type="text/javascript" src="//apis.daum.net/maps/maps3.js?apikey=d1a0f4ce72bcbd2fd05dadf7e7a3a053&libraries=services"></script>

<form action="<?=$root?>/town/town_proc.php" method="post" enctype="multipart/form-data" onSubmit="return check_form(this);">
<input type="hidden" name="mode" value="<?=$mode?>" />
<input type="hidden" name="id" value="<?=$id?>" />
<input type="hidden" name="manager" value="true" />
<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
<ul class="town_form">
	<li>
		<label for="pac_title" class="lh">학원명</label>
		<input type="text" id="pac_title" name="sName" value="<?=$TOWN['sName']?>" class="check_value" size="30">
	</li>
	<? if (!$MEMBER['id']) { ?>
	<li>
		<label for="sPw" class="lh">비밀번호</label>
		<input type="password" id="sPw" name="sPw" value="" class="check_pw <?=$change_pw?>" size="30">
		<span class="info"><?=$pw_info?></span>
	</li>
	<li>
		<label for="sPw2" class="lh">비밀번호 확인</label>
		<input type="password" id="sPw2" name="sPw2" value="" class="check_pw2 <?=$change_pw?>" size="30">
	</li>
	<? } ?>
	<li>
		<label for="sCeo" class="lh">학원장명</label>
		<input type="text" id="sCeo" name="sCeo" value="<?=$TOWN['sCeo']?>" class="check_value" size="30">
	</li>
	<li>
		<label for="town_group1_id" class="lh">학원분류</label>
		<select name="town_group1_id" id="town_group1_id" class="check_select">
			<option value=""> - 1차분류 -</option>
			<?=getSelectOption($Group1,$TOWN['town_group1_id'])?>
		</select>
		<?=$Gsel2?>
	</li>
	<li>
		<label for="sTel" class="lh">학원전화</label>
		<input type="text" id="sTel" name="sTel" value="<?=$TOWN['sTel']?>" class="check_tel" size="30">
	</li>
	<li>
		<label for="sHphone" class="lh">휴대전화</label>
		<input type="text" id="sHphone" name="sHphone" value="<?=$TOWN['sHphone']?>" class="check_tel" size="30">
	</li>
	<li>
		<label for="sUrl" class="lh">학원 홈페이지</label>
		<input type="text" id="sUrl" name="sUrl" value="<?=$TOWN['sUrl']?>" placeholder="ex) http://<?=$_SERVER['SERVER_NAME']?>/" size="30">
	</li>
	<li>
		<label for="sContent" class="lh">학원 소개</label>
		<textarea name="sContent" id="sContent"><?=$TOWN['sContent']?></textarea>
	</li>
	<li>
		<label for="sAddrSub" class="lh">주소</label>
		<input type="text" name="sZipCode" value="<?=$TOWN['sZipCode']?>" readonly="readonly" size="8" class="check_zipcode " /> 
		<a href="Search_ZipCode_New" class="jButton small dialog_open">주소검색</a> <br />
		<input type="text" name="sAddr" id="sAddr" value="<?=$TOWN['sAddr']?>" size="60" class="block" readonly="readonly" />
		<input type="hidden" name="sSigun" value="<?=$TOWN['sSigun']?>" /> 
		<input type="hidden" name="sDong" value="<?=$TOWN['sDong']?>" /> 
		<input type="text" name="sAddrSub" id="sAddrSub" value="<?=$TOWN['sAddrSub']?>" size="60" class="check_value" /> 나머지 주소
	</li>
	<li>
		<label for="pac_input" class="lh">지도 검색</label>
		<select name="zip_table" class="check_select" id="pac_zone">
			<option value=""> - 지역선택 -</option>
			<?=getSelectOption($ZIP_ZONE, $TOWN['zip_table'])?>
		</select>
		<input id="pac_input" name="sMapSearch" type="text" value="<?=$TOWN['sMapSearch']?>"  size="60" class="check_value" >
		<a href="#" id="pac_button" class="jButton small">지도검색</a>
		<div id="container">
			<div id="mapWrapper">
				<div id="map"></div>
				<div id="roadviewControl"><span>로드뷰</span></div>
			</div>
			<div id="rvWrapper">
				<div id="road"></div>
				<div id="rvClose"><span class="img"></span></div>
			</div>
		</div>
	</li>
	<li>
		<div class="lh">
			학원 이미지
			<a href="#" class="jButton small filePlus">+</a>
			<a href="#" class="jButton small fileMinus">_</a>
		</div>
		<?=$file_inputs?>
	</li>
</ul>
<div class="town_form_command">
	<input type="submit" value="<?=$btn_title?>" class="jButton">
	<a href="javascript:;" onclick="history.go(-1)" class="jButton">취소</a>
</div>
</form>

<script type="text/javascript" src="<?=$root?>/js/daum_map.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
	dMap.useRoadView = true;
	dMap.init();
	
	$('.filePlus').click(function(e){
		Town.filePlus(e);
	});
	$('.fileMinus').click(function(e){
		Town.fileMinus(e);
	});
	$('.imgpreview').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('href');
		Town.delfile(e, id);
	});
	
	$('#town_group1_id').change(function(e) {
		var id = this.value;
		var parent = $(this).closest('li');
		$.ajax({
			url : '/town/town_ajax.php',
			type : 'post',
			dataType:"json",
			data : {
				'mode' : 'getGroup2',
				'id' : id
			},
			success: function(data) {
				parent.find('.group2').remove();
				if (data.count > 0) {
					var sel = $('<select></select>');
					sel.addClass('check_select').addClass('group2').attr('name','town_group2_id').appendTo(parent);
					var option = $('<option></option>').text(' - 2차 분류 - ').val('').appendTo(sel);
					for (var i in data.group) {
						$('<option></option>').val(data.group[i]).text(i).appendTo(sel);
					}
				} else {
					var input = $('<input>');
					input.attr({'type': 'hidden', 'name' : 'town_group2_id'}).addClass('group2').val(0).appendTo(parent);
				}
			}
		});
	});
});
</script>

<?php
include_once("$root/town/town_imgview.php");
include_once ("$path/inc/footer.php");
?> 