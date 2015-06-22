<?php
	include_once ("./_common.php");
	include_once ("$path/inc/header.php");
	include_once ("$path/inc/gnb.php");
	
	$mode = $_REQUEST['mode'];
	switch ($mode) {
		case 'I' :
			$subject = "신규 게시판 생성";
			$dir = getSearchDir($board_skin_dir_root);
			$skin_dir_opt = getSelectOption($dir);
			$edit_dir =  getSearchDir($board_editor_dir);
			$edit_dir_opt = getSelectOption($edit_dir);
			$listlevel_opt = getLevelOption();
			$readlevel_opt = getLevelOption();
			$writelevel_opt = getLevelOption();
			$answerlevel_opt = getMemberLevelOption();
			$replylevel_opt = getMemberLevelOption();
			$fileuplevel_opt = getMemberLevelOption();
			$filedownlevel_opt = getMemberLevelOption();
			$use_category = getSelectOption($use_arr);
			$use_secret  = getSelectOption($use_arr);
			$use_html = getSelectOption($use_arr,1);
			$use_reply = getSelectOption($use_arr);
			$name_stamp = getSelectOption($BOARD_SETUP['NameStamp']);
			$use_thumbnail = getSelectOption($use_arr);
			break;
		case 'M' :
			$id = $_REQUEST['id'];
			$readonly = "readonly=\"readonly\"";
			$subject = "게시판 수정";
			
			$SSQL = "SELECT * FROM `board_config` WHERE id='".$id."'";
			$SRES = $db_conn -> sql($default_db, $SSQL);
			$board = mysql_fetch_array($SRES);
			
			$dir = getSearchDir($board_skin_dir_root);
			$skin_dir_opt = getSelectOption($dir, $board['sSkinDir']);
			
			$edit_dir =  getSearchDir($board_editor_dir);
			$edit_dir_opt = getSelectOption($edit_dir, $board['sEditor']);
			
			$listlevel_opt = getLevelOption($board['iListLevel']);
			$readlevel_opt = getLevelOption($board['iReadLevel']);
			$writelevel_opt = getLevelOption($board['iWriteLevel']);
			$answerlevel_opt = getMemberLevelOption($board['iAnswerLevel']);
			$replylevel_opt = getMemberLevelOption($board['iReplyLevel']);
			$fileuplevel_opt = getMemberLevelOption($board['iUploadLevel']);
			$filedownlevel_opt = getMemberLevelOption($board['iDownloadLevel']);
			$use_category = getSelectOption($use_arr, $board['iUseCategory']);
			$use_secret  = getSelectOption($use_arr, $board['iUseSecret']);
			$use_html = getSelectOption($use_arr,$board['iUseHtmlEditor']);
			$use_reply = getSelectOption($use_arr, $board['iUseReply']);
			$name_stamp = getSelectOption($BOARD_SETUP['NameStamp'], $board['eNameStamp']);
			$use_thumbnail = getSelectOption($use_arr, $board['iUseThumbNail']);
			break;
	}

	
?>
<div class="ADM_Container">
	<h2 class="subject"><?=$subject?></h2>
	<form action="<?=$path?>/board/board_proc.php" method="post" onsubmit="return check_form(this)" >
		<input type="hidden" name="id" value="<?=$id?>" />
		<input type="hidden" name="mode" value="<?=$mode?>" />
		<ul class="inputs">
			<li>
				<label for="sTablePrefix">테이블 접두사</label>
				<input type="text" name="sTablePrefix" id="sTablePrefix" value="<?php echo empty($board['sTablePrefix']) ? 'bbs' : $board['sTablePrefix']; ?>" class="check_value" size="10" <?=$readonly?> />
			</li>
			<li>
				<label for="sTableName">테이블 이름</label>
				<input type="text" name="sTableName" id="sTableName" value="<?=$board['sTableName']?>" class="check_value" size="30" <?=$readonly?> /> DB 테이블명 영문작성
			</li>
			<li>
				<label for="sBoardSubject">게시판 이름</label>
				<input type="text" name="sBoardSubject" id="sBoardSubject" value="<?=$board['sBoardSubject']?>" class="check_value" size="30" /> 
			</li>
			<li>
				<label for="sSkinDir">스킨디렉터리</label>
				<select name="sSkinDir" id="sSkinDir">
					<?=$skin_dir_opt?>
				</select>
			</li>
			<li>
				<label for="iUseThumbNail">썸네일 이미지 생성</label>
				<select name="iUseThumbNail" id="iUseThumbNail">
					<?=$use_thumbnail?>
				</select>
				&nbsp;&nbsp;썸네일 이미지 &nbsp;&nbsp;넓이 : <input type="text" name="iThumb_w" value="<?=$board['iThumb_w']?>" size="4" />px
				&nbsp;&nbsp;높이 : <input type="text" name="iThumb_h" value="<?=$board['iThumb_h']?>" size="4" />px
			</li>
			<li>
				<label for="sBoardHead">보더 상단 파일</label>
				<input type="text" name="sBoardHead" id="sBoardHead" value="<?=$board['sBoardHead']?>" size="30" />
				경로까지 작성
			</li>
			<li>
				<label for="sBoardFoot">보더 하단 파일</label>
				<input type="text" name="sBoardFoot" id="sBoardFoot" value="<?=$board['sBoardFoot']?>" size="30" />
				경로까지 작성
			</li>
			<li>
				<label for="iListLevel">목록보기 권한</label>
				<select name="iListLevel" id="iListLevel">
					<?=$listlevel_opt?>
				</select>
				1:관리자 10:비회원
			</li>
			<li>
				<label for="iReadLevel">게시물보기 권한</label>
				<select name="iReadLevel" id="iReadLevel">
					<?=$readlevel_opt?>
				</select>
				1:관리자 10:비회원
			</li>
			<li>
				<label for="iWriteLevel">게시물작성 권한</label>
				<select name="iWriteLevel" id="iWriteLevel">
					<?=$writelevel_opt?>
				</select>
				1:관리자 10:비회원
			</li>
			<li>
				<label for="iAnswerLevel">답변글쓰기 권한</label>
				<select name="iAnswerLevel" id="iAnswerLevel">
					<?=$replylevel_opt?>
				</select>
				1:관리자 9:회원레벨
			</li>
			<li>
				<label for="iReplyLevel">리플달기 권한</label>
				<select name="iReplyLevel" id="iReplyLevel">
					<?=$replylevel_opt?>
				</select>
				1:관리자 9:회원레벨
			</li>
			<li>
				<label for="iUploadLevel">파일업로드 권한</label>
				<select name="iUploadLevel" id="iUploadLevel">
					<?=$fileuplevel_opt?>
				</select>
				1:관리자 9:회원레벨
			</li>
			<li>
				<label for="iDownloadLevel">파일다운로드 권한</label>
				<select name="iDownloadLevel" id="iDownloadLevel">
					<?=$filedownlevel_opt?>
				</select>
				1:관리자 9:회원레벨
			</li>
			<li>
				<label for="iUploadCount">파일업로드 최대개수</label>
				<input type="text" name="iUploadCount" id="" value="<?=$board['iUploadCount']?>" size="4"/>개
			</li>
			<li>
				<label for="iFileSize">업로드파일 사이즈</label>
				<input type="text" name="iFileSize" id="" value="<?=$board['iFileSize']?>" />bytes
			</li>
			<li>
				<label for="iUseCategory">카데고리 사용</label>
				<select name="iUseCategory" id="iUseCategory">
					<?=$use_category?>
				</select>
				카데고리 목록 :
				<input type="text" name="sCategoryList" id="sCategoryList" value="<?=$board['sCategoryList']?>" size="40" /> 
				| 로 구분
			</li>
			<li>
				<label for="iUseSecret">비밀글 사용</label>
				<select name="iUseSecret" id="iUseSecret">
					<?=$use_secret?>
				</select>
			</li>
			<li>
				<label for="iUseHtmlEditor">DHTML 에디터 사용</label>
				<select name="iUseHtmlEditor" id="iUseHtmlEditor">
					<?=$use_html?>
				</select>
				<select name="sEditor">
					<?=$edit_dir_opt?>
				</select>
			</li>
			<li>
				<label for="iUseReply">리플기능 사용</label>
				<select name="iUseReply" id="iUseReply">
					<?=$use_reply?>
				</select>
			</li>
			<li>
				<label for="iLimit">페이지당 불러올 목록수</label>
				<input type="text" name="iLimit" id="iLimit" value="<?php echo empty($board['iLimit']) ? '10' : $board['iLimit']; ?>" class="check_value" size="6" />
			</li>
			<li>
				<label for="iPage">페이징처리 개수</label>
				<input type="text" name="iPage" id="iPage" value="<?php echo empty($board['iPage']) ? '10' : $board['iPage']; ?>" class="check_value" size="6" />
			</li>
			<li>
				<label for="eNameStamp">이름표시</label>
				<select name="eNameStamp" id="eNameStamp">
					<?=$name_stamp?>
				</select>
			</li>
		</ul>
		<div class="center"><span class="button medium"><input type="submit" value="<?=$subject?>" /></span></div>
	</form>
</div>
	
<?php
	include_once ("$path/inc/footer.php");
?>