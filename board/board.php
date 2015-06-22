<?php
/*
include_once("./_common.php");
include_once("$root/lib/phpheader.php");
include_once("$root/lib/function.php");
include_once("$root/lib/class.php");
include_once("$root/lib/db_info.php");
include_once("$root/lib/config.php");
*/
include_once("$root/board/board_function.php");

$mode = $_REQUEST['mode'];

$BCSQL = "SELECT * FROM `board_config` WHERE id='".$board_config_id."'";
$BCRES = $db_conn -> sql($default_db,$BCSQL);
$BOARD_CONFIG = mysql_fetch_assoc($BCRES);

$table = $BOARD_CONFIG['sTablePrefix'].'_'.$BOARD_CONFIG['sTableName'];
$skin_dir = $board_skin_dir.$BOARD_CONFIG['sSkinDir'];
$userLevel = empty($MEMBER['iHLevel'])  ? 10 : $MEMBER['iHLevel'];
echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"".$skin_dir."/skin.css\" />";

$is_ListLevel = getAccessLevel($BOARD_CONFIG['iListLevel']);
$is_ReadLevel = getAccessLevel($BOARD_CONFIG['iReadLevel']);
$is_WriteLevel = getAccessLevel($BOARD_CONFIG['iWriteLevel']);
$is_AnswerLevel = getAccessLevel($BOARD_CONFIG['iAnswerLevel']);
$is_ReplyLevel = getAccessLevel($BOARD_CONFIG['iReplyLevel']);
$is_UploadLevel = getAccessLevel($BOARD_CONFIG['iUploadLevel']);
$is_DownloadLevel = getAccessLevel($BOARD_CONFIG['iDownloadLevel']);

if($BOARD_CONFIG['iUseCategory']) {
	$BOARD_CONFIG['Category'] = explode('|', $BOARD_CONFIG['sCategoryList']);
}

if ($BOARD_CONFIG['iUseHtmlEditor']) {
	switch ($BOARD_CONFIG['sEditor']) {
		case 'EXeditor':
			$edit_class = "EXeditor";
			$edit_script = "<script type=\"text/javascript\" src=\"".$root."/editor/EXeditor/EXeditor.js\"></script>";
			$edit_start = "<script type=\"text/javascript\"> 
				$(document).ready(function(e) {
				 	$('.EXeditor').EXeditor({userLevel : ".$MEMBER['iMLevel']."});
				});
				</script>";
			break;
		case 'smarteditor':
			$edit_class = "smarteditor";
			$edit_script = "<script type=\"text/javascript\" src=\"".$root."/editor/smarteditor/js/HuskyEZCreator.js\"></script>";
			$edit_start = "<script type=\"text/javascript\"> 
				var oEditors = [];
				$('#sComment').css({'width': $('#sComment').width()-2 ,'height':'400px'});
				nhn.husky.EZCreator.createInIFrame({
					oAppRef: oEditors,
					elPlaceHolder: 'sComment',
					sSkinURI: '".$root."/editor/smarteditor/SmartEditor2Skin.html',
					fCreator: 'createSEditor2'
				});
				</script>";
			break;
		default :
			$edit_class = "ckeditor";
			$edit_script = "<script type=\"text/javascript\" src=\"".$root."/editor/ckeditor/ckeditor.js\"></script>";
			
			break;
	}
}


$fileuploadsize = getFileSize($BOARD_CONFIG['iFileSize']);

switch($mode) {
	case 'L' : // 게시물 목록보기
		if ($is_ListLevel) {
			include_once("$root/board/board_list.php");
		} else {
			goBackScript('접근 권한 오류','게시물 목록보기 권한이 없습니다.<br /><br />회원로그인, 회원가입을 해주세요.');
		}
		break;
	case 'W' : // 게시물 작성
		if ($is_WriteLevel) {
			include_once("$root/board/board_write.php");
		} else {
			goBackScript('접근 권한 오류','게시물 작성 권한이 없습니다.<br /><br />회원로그인, 회원가입을 해주세요.');
		}
		break;
	case 'R' : // 게시물 읽기
		if ($is_ReadLevel) {
			include_once("$root/board/board_read.php");
		} else {
			goBackScript('접근 권한 오류','게시물 읽기 권한이 없습니다.<br /><br />회원로그인, 회원가입을 해주세요.');
			//goBack('접근 권한이 없습니다.');
		}
		break;
	case 'M' : // 게시물 수정
		include_once("$root/board/board_modify.php");
		break;
	case 'A' : // 게시물 답변쓰기
		if ($is_AnswerLevel) {
			include_once("$root/board/board_answer.php");
		} else {
			goBackScript('접근 권한 오류','게시물 답변쓰기 권한이 없습니다.<br /><br />회원로그인, 회원가입을 해주세요.');
		}
		break;
	case 'D' : // 게시물 삭제
		include_once("$root/board/board_delete.php");
		break;
	default : // 모드가 없으면 게시물 목록보기
		if ($is_ListLevel) {
			$mode="L";
			include_once("$root/board/board_list.php");
		} else {
			goBackScript('접근 권한 오류','게시물 목록보기 권한이 없습니다.<br /><br />회원로그인, 회원가입을 해주세요.');
		}
		break;
}
?>

