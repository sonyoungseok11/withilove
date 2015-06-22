<?php
include_once("./_common.php");
include_once("$root/lib/phpheader.php");
include_once("$root/lib/function.php");
include_once("$root/lib/class.php");
include_once("$root/lib/db_info.php");
include_once("$root/lib/config.php");

$mode = $_POST['mode'];

$id = $_POST['id'];
$iSort = $_POST['iSort'];
$iActive = $_POST['iActive'];
$sName = $_POST['sName'];
$sUrl = $_POST['sUrl'];

$url = $path . '/etc/family_academy_list.php';

switch ($mode) {
	case 'I' : // 신규등록
		$ISQL = "
			INSERT INTO `family_academy` SET
				iSort = '". $iSort ."',
				iActive = '". $iActive ."',
				sName = '". $sName ."',
				sUrl = '". $sUrl ."',
				dInDate = NOW()
		";
		$IRES = $db_conn -> sql($default_db, $ISQL);
		goMsg($url , '신규등록 되었습니다.');
		break;
	case 'M' :	// 수정
		$USQL ="
			UPDATE `family_academy` SET
				iActive = '".$iActive."',
				sName = '".$sName."',
				sUrl = '".$sUrl."'
			WHERE id='".$id."'
		";
		$URES = $db_conn -> sql($default_db, $USQL);
		goMsg($url , '수정 되었습니다.');
		break;
	case 'A' :	// 활성 비활성 수정
		$USQL ="
			UPDATE `family_academy` SET
				iActive = '".$iActive."'
			WHERE id='".$id."'
		";
		$URES = $db_conn -> sql($default_db, $USQL);
		goMsg($url , '수정 되었습니다.');
		break;
	case 'D' :	//삭제
		$DSQL ="DELETE FROM `family_academy` WHERE id='".$id."'";
		$DRES = $db_conn -> sql($default_db, $DSQL);
		goMsg($url , '삭제 되었습니다.');
		break;
	case 'S' :	//정렬수정
		$ids = $_POST['ids'];
		$iSort=1;
		foreach ($ids as $id) {
			$USQL ="
				UPDATE `family_academy` SET
					iSort = '".$iSort."'
				WHERE id='".$id."'
			";
			$URES = $db_conn -> sql($default_db, $USQL);
			$iSort++;
		}
		goMsg($url , '정렬순서가 변경되었습니다.');
		break;
}
?>