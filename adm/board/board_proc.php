<?php
include_once("./_common.php");
include_once("$root/lib/phpheader.php");
include_once("$root/lib/function.php");
include_once("$root/lib/class.php");
include_once("$root/lib/db_info.php");
include_once("$root/lib/config.php");
include_once("$path/lib/adm_config.php");

$mode = $_REQUEST['mode'];
$id = $_REQUEST['id'];
$sTablePrefix = trim($_POST['sTablePrefix']);
$sTableName = trim($_POST['sTableName']);
$sBoardSubject = trim($_POST['sBoardSubject']);
$sSkinDir = trim($_POST['sSkinDir']);
$sBoardHead = trim($_POST['sBoardHead']);
$sBoardFoot = trim($_POST['sBoardFoot']);
$iListLevel = trim($_POST['iListLevel']);
$iReadLevel = trim($_POST['iReadLevel']);
$iWriteLevel = trim($_POST['iWriteLevel']);
$iAnswerLevel = trim($_POST['iAnswerLevel']);
$iReplyLevel = trim($_POST['iReplyLevel']);
$iUploadLevel = trim($_POST['iUploadLevel']);
$iDownloadLevel = trim($_POST['iDownloadLevel']);
$iUploadCount = trim($_POST['iUploadCount']);
$iFileSize = trim($_POST['iFileSize']);
$iUseCategory = trim($_POST['iUseCategory']);
$sCategoryList = trim($_POST['sCategoryList']);
$iUseSecret = trim($_POST['iUseSecret']);
$iUseHtmlEditor = trim($_POST['iUseHtmlEditor']);
$sEditor = trim($_POST['sEditor']);
$iUseReply = trim($_POST['iUseReply']);
$iLimit = trim($_POST['iLimit']);
$iPage = trim($_POST['iPage']);
$eNameStamp = $_POST['eNameStamp'];
$iUseThumbNail = $_POST['iUseThumbNail'];
$iThumb_w = $_POST['iThumb_w'];
$iThumb_h = $_POST['iThumb_h'];

$table_name = $sTablePrefix.'_'.$sTableName;

switch($mode) {
	case 'I' : // 신규게시판 생성
		$NSQL ="SELECT COUNT(id) FROM `board_config` WHERE sTablePrefix='".$sTablePrefix."' AND sTableName='".$sTableName."'";
		$NRES = $db_conn -> sql ($default_db, $NSQL);
		list($count) = mysql_fetch_row($NRES);
		if ($count > 0) {
			$msg = "이미 테이블이 존재 합니다.";
			goBack($msg);
			exit;
		} 
		//게시판 테이블을 생성
		$TBSQL = "
			CREATE TABLE ".$table_name." (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '일련번호',
			  `user_id` int(10) unsigned NOT NULL COMMENT '일련번호',
			  `iOrder` int(10) unsigned NOT NULL COMMENT '내부정렬번호',
			  `iDepth` int(10) unsigned NOT NULL COMMENT '계층 깊이 값',
			  `sName` varchar(50) NOT NULL COMMENT '작성자 이름',
			  `sEmail` varchar(50) NOT NULL COMMENT '작성자 이메일',
			  `sPw` varchar(50) NOT NULL COMMENT '게시물 비밀번호',
			  `iCategory` tinyint(1) unsigned NOT NULL  DEFAULT '0' COMMENT '카데고리사용시 입력',
			  `sTitle` varchar(255) NOT NULL COMMENT '게시물 제목',
			  `sPreface` text COMMENT '게시물 서문',
			  `sComment` text NOT NULL COMMENT '게시물 내용',
			  `iSecret` tinyint(1) NOT NULL DEFAULT '0' COMMENT '비밀글',
			  `iHaveFile` tinyint(1) NOT NULL DEFAULT '0' COMMENT '파일소유유무',
			  `iSee` int(2) NOT NULL DEFAULT '0' COMMENT '글 조회수',
			  `sIp` varchar(20) NOT NULL COMMENT '작성자 IP',
			  `dInDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '작성날자',
			  `dStartDate` date NOT NULL DEFAULT '0000-00-00' COMMENT '이벤트시작일',
			  `dEndDate` date NOT NULL DEFAULT '0000-00-00' COMMENT '이벤트시작일',
			  `sSMS` varchar(255) COMMENT '고객응대 SMS발송문자내용',
			  PRIMARY KEY (`id`),
			  KEY `user_id` (`user_id`),
			  KEY `iOrder` (`iOrder`)
			)
		";
		$TBRES = $db_conn -> sql ($default_db, $TBSQL);
		if(!$TBRES) {
			$msg = "게시판 생성에 실패 하였습니다.";
			goBack($msg);
			exit;
		}
		// 보드정보를 넣는다
		$ISQL ="
			INSERT INTO `board_config` SET 
				sTablePrefix = '". $sTablePrefix ."',
				sTableName = '". $sTableName ."',
				sBoardSubject = '". $sBoardSubject ."',
				sSkinDir = '". $sSkinDir ."',
				sBoardHead = '". $sBoardHead ."',
				sBoardFoot = '". $sBoardFoot ."',
				iListLevel = '". $iListLevel ."',
				iReadLevel = '". $iReadLevel ."',
				iWriteLevel = '". $iWriteLevel ."',
				iAnswerLevel = '". $iAnswerLevel ."',
				iReplyLevel = '". $iReplyLevel ."',
				iUploadLevel = '". $iUploadLevel ."',
				iDownloadLevel = '". $iDownloadLevel ."',
				iUploadCount = '". $iUploadCount ."',
				iFileSize = '". $iFileSize ."',
				iUseCategory = '". $iUseCategory ."',
				sCategoryList = '". $sCategoryList ."',
				iUseSecret = '". $iUseSecret ."',
				iUseHtmlEditor = '". $iUseHtmlEditor ."',
				sEditor = '".$sEditor."',
				iUseReply = '". $iUseReply ."',
				iLimit = '". $iLimit ."',
				iPage = '". $iPage ."',
				eNameStamp = '".$eNameStamp."',
				iUseThumbNail = '". $iUseThumbNail ."',
				iThumb_w = '". $iThumb_w ."',
				iThumb_h = '". $iThumb_h."'
		";
		$IRES = $db_conn -> sql ($default_db, $ISQL);
		if($IRES) {
			@mkdir($board_upload_dir.$sTablePrefix.'_'.$sTableName.'/',0777);
			@mkdir($board_upload_dir.$sTablePrefix.'_'.$sTableName.'/thumb/',0777);
			$msg = $sBoardSubject. " 게시판을 생성하였습니다.";
			$url = $path."/board/index.php";
			goMsg($url, $msg);
		} else {
			$msg = "게시판 정보입력을 실패 하였습니다.";
			goBack($msg);
			exit;
		}
		break;
	
	case 'M' : //게시판 수정
		$USQL ="
			UPDATE `board_config` SET 
				sBoardSubject = '". $sBoardSubject ."',
				sSkinDir = '". $sSkinDir ."',
				sBoardHead = '". $sBoardHead ."',
				sBoardFoot = '". $sBoardFoot ."',
				iListLevel = '". $iListLevel ."',
				iReadLevel = '". $iReadLevel ."',
				iWriteLevel = '". $iWriteLevel ."',
				iAnswerLevel = '". $iAnswerLevel ."',
				iReplyLevel = '". $iReplyLevel ."',
				iUploadLevel = '". $iUploadLevel ."',
				iDownloadLevel = '". $iDownloadLevel ."',
				iUploadCount = '". $iUploadCount ."',
				iFileSize = '". $iFileSize ."',
				iUseCategory = '". $iUseCategory ."',
				sCategoryList = '". $sCategoryList ."',
				iUseSecret = '". $iUseSecret ."',
				iUseHtmlEditor = '". $iUseHtmlEditor ."',
				sEditor = '".$sEditor."',
				iUseReply = '". $iUseReply ."',
				iLimit = '". $iLimit ."',
				iPage = '". $iPage ."',
				eNameStamp = '".$eNameStamp."',
				iUseThumbNail = '". $iUseThumbNail ."',
				iThumb_w = '". $iThumb_w ."',
				iThumb_h = '". $iThumb_h."'
			WHERE id='".$id."'
		";
		$URES = $db_conn -> sql ($default_db, $USQL);
		if($URES) {
			$msg = $sBoardSubject. " 게시판을 수정하였습니다.";
			$url = $path."/board/board.php?mode=M&id=".$id."";
			goMsg($url, $msg);
		} else {
			$msg = "게시판 정보수정을 실패 하였습니다.";
			goBack($msg);
			exit;
		}
		break;
}

?>