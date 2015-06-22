<?php
include_once ("./_common.php");
include_once ("$path/inc/header.php");
include_once ("$path/inc/gnb.php");

$mode = $_POST['mode'];

$logofile = "<input type=\"file\" name=\"file_logo\" id=\"file_logo\" />";
$bannerfile = "<input type=\"file\" name=\"file_banner\" id=\"file_banner\" />";
for ($i=0; $i<5; $i++) {
	$imgfile[$i] = "<input type=\"file\" name=\"file_img[]\" class=\"block\" /><br />";
}

switch ($mode) {
	case 'M':
		$id = $_POST['id'];
		$SSQL = "
		SELECT l.*, u.sUserId, u.sUserName  FROM `cooperative_firm_list` l
		INNER JOIN users u ON l.user_id = u.id
		WHERE l.id='".$id."'
		";
		$SRES = $db_conn -> sql($default_db, $SSQL);
		$Data = mysql_fetch_assoc($SRES);
		
		$FSQL = "
			SELECT id, eType, sPath, sFile FROM `cooperative_firm_files` WHERE cooperative_id='".$id."'
		";
		$FRES = $db_conn -> sql($default_db, $FSQL);
		$i=0;
		while ($row = mysql_fetch_assoc($FRES)) {
			switch ($row['eType']) {
				case 'P' :
					$Files[$row['eType']][$i]['id'] = $row['id'];
					$Files[$row['eType']][$i]['sPath'] = $row['sPath'];
					$Files[$row['eType']][$i]['sFile'] = $row['sFile'];
					$i++;
					break;
				default :
					$Files[$row['eType']]['id'] = $row['id'];
					$Files[$row['eType']]['sPath'] = $row['sPath'];
					$Files[$row['eType']]['sFile'] = $row['sFile'];
					break;
			}
		}
		if (is_array($Files['L'])) {
			$logofile = "<img src=\"".$Files['L']['sPath'].'/'.$Files['L']['sFile']."\" /> <a href=\"javascript:;\" onclick=\"delfile_cooperative('L','".$Files['L']['id']."', this)\" class=\"jButton small\">삭제</a>";
		}
		
		if (is_array($Files['B'])) {
			$bannerfile = "<img src=\"".$Files['B']['sPath'].'/'.$Files['B']['sFile']."\" /> <a href=\"javascript:;\" onclick=\"delfile_cooperative('B','".$Files['B']['id']."', this)\" class=\"jButton small\">삭제</a>";
		}
		
		if (is_array($Files['P'])) {
			foreach ($Files['P'] as $key => $val) {
				$imgfile[$key] = "<img src=\"".$val['sPath'].'/thumb/'.$val['sFile']."\" /> <a href=\"javascript:;\" onclick=\"delfile_cooperative('P','".$val['id']."', this)\" class=\"jButton small\">삭제</a><br />";
			}
		}
		$eType = $Data['eType'];
		$iSort = $Data['iSort'];
		$user_name= $Data['sUserName'].'['.$Data['sUserId'].']';
		$btn_name = "수정";
		break;
	default:
		$eType = $_POST['eType'];
		$iSort = $_POST['iSort'];
		$btn_name = "등록";
		break;
}


?>
<form action="<?=$path?>/cooperative/cooperative_proc.php" method="post" enctype="multipart/form-data" onsubmit="return check_form(this);">
<input type="hidden" name="mode" value="<?=$mode?>" />
<input type="hidden" name="id" value="<?=$id?>" />
<input type="hidden" name="eType" value="<?=$eType?>" />
<input type="hidden" name="iSort" value="<?=$iSort?>" />
<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
<ul class="dialog_form">
	<li>
		<label class="lh" for="user_name">회원</label>
		<input type="hidden" name="user_id" value="<?=$Data['user_id']?>" />
		<input type="text" name="user_Name" id="user_Name"  value="<?=$user_name?>" class="check_length inline" readonly="readonly" />
		<a href="javascript:;" onclick="search_member('cooperative');" class="jButton small">검색</a> 
	</li>
	<li>
		<label class="lh" for="sTitle">업체명</label>
		<input type="text" name="sTitle" id="sTitle"  value="<?=$Data['sTitle']?>" class="check_length inline" /> 
	</li>
	<li>
		<label class="lh" for="sTitleSubfix">업체정보</label>
		<input type="text" name="sTitleSubfix" id="sTitleSubfix"  value="<?=$Data['sTitleSubfix']?>" class="box" /> 
	</li>
	<li>
		<label class="lh" for="sSimpleComment">간략정보</label>
		<input type="text" name="sSimpleComment" id="sSimpleComment"  value="<?=$Data['sSimpleComment']?>" class="box" /> 
	</li>
	<li>
		<label class="lh" for="sContents">상세정보</label>
		<textarea name="sContents" id="sContents" class="box" ><?=$Data['sContents']?></textarea>
	</li>
	<li>
		<label class="lh" for="sUrl">Home Page</label>
		<input type="text" name="sUrl" id="sUrl"  value="<?=$Data['sUrl']?>" class="check_url box" /> 
	</li>
	<li>
		<label class="lh" for="sTel">연락처</label>
		<input type="text" name="sTel" id="sTel"  value="<?=$Data['sTel']?>" class="box" /> 
	</li>
	<li>
		<label for="sAddrSub" class="lh">주소</label>
		<input type="text" name="sZipCode" value="<?=$Data['sZipCode']?>" readonly="readonly" size="8" class="inline" style="width:100px;" /> 
		<a href="Search_ZipCode_New" class="jButton small dialog_open">우편번호</a>
		<input type="text" name="sAddr" id="sAddr" value="<?=$Data['sAddr']?>" size="60" class="box block" readonly="readonly" />
		<input type="text" name="sAddrSub" id="sAddrSub" value="<?=$Data['sAddrSub']?>" size="60" class="box"  style="width:80%"/> 나머지 주소
	</li>
	<li>
		<label for="file_logo" class="lh">로고</label>
		<?=$logofile?> 130*40 size
	</li>
	<li>
		<label for="file_banner" class="lh">배너</label>
		<?=$bannerfile?> 파워링크 : 170*100, 일반링크 : 200*50
	</li>
	<li>
		<label for="file_img" class="lh">이미지</label>
		<?=$imgfile[0]?>
		<?=$imgfile[1]?>
		<?=$imgfile[2]?>
		<?=$imgfile[3]?>
		<?=$imgfile[4]?>
	</li>
</ul>
<div class="Btns"><input type="submit" value="<?=$btn_name?>" class="jButton"/></div>
</form>


<?php
include_once ("$path/inc/footer.php");
?>