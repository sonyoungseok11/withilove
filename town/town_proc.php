<?php
include_once("./_common.php");
include_once("$root/lib/phpheader.php");
include_once("$root/lib/function.php");
include_once("$root/lib/class.php");
include_once("$root/lib/db_info.php");
include_once("$root/lib/config.php");
include_once("$root/town/town_function.php");

/*
print_r($_POST);
print_r($_FILES);
*/

$mode = $_POST['mode'];
$manager = $_POST['manager'];

$id = $_POST['id'];
$sName = $_POST['sName'];
$user_id = empty($MEMBER['id']) ? 0 : $MEMBER['id'];

$sZipCode = $_POST['sZipCode'];
$sAddr = $_POST['sAddr'];
$sAddrSub = trim($_POST['sAddrSub']);
$zip_table = $_POST['zip_table'];
$sSigun = $_POST['sSigun'];
$sDong = $_POST['sDong'];
$sMapSearch = trim($_POST['sMapSearch']);
$sCeo = trim($_POST['sCeo']);
$town_group1_id = $_POST['town_group1_id'];
$town_group2_id = $_POST['town_group2_id'];
$sTel = $_POST['sTel'];
$sHphone = $_POST['sHphone'];
$sUrl = trim($_POST['sUrl']);
$sContent = trim($_POST['sContent']);

$delfile = $_POST['delfile'];

if (empty($manager)) {
	$rePath = $root."/town/";
} else {
	$repath = $root."/manager/town/";
}

switch ($mode) {
	case 'I' : // 신규등록
		$sPw =  empty($_POST['sPw']) ? $MEMBER['sUserPw'] : md5($db_conn -> rc4crypt(trim($_POST['sPw'])));
		
		$ISQL = "
			INSERT INTO `town_academy` SET 
				user_id = '". $user_id ."',
				sPw = '". $sPw ."',
				zip_table = '". $zip_table ."',
				sSigun = '". $sSigun ."',
				sDong = '". $sDong ."',
				town_group1_id = '". $town_group1_id ."',
				town_group2_id = '". $town_group2_id ."',
				iActive = '0',
				iPower = '0',
				sName = '". $sName ."',
				sCeo = '". $sCeo ."',
				sTel = '". $sTel ."',
				sHphone = '". $sHphone ."',
				sZipCode = '". $sZipCode ."',
				sAddr = '". $sAddr ."',
				sAddrSub = '". $sAddrSub ."',
				sMapSearch = '". $sMapSearch ."',
				sUrl = '". $sUrl ."',
				sContent = '". $sContent ."',
				dInDate  = NOW()
		";
		$IRES = $db_conn -> sql($default_db, $ISQL);
		$id = mysql_insert_id();
		filesUpload_town($_FILES['files'], 'P', $id);
		$reUrl = $repath."town_list.php";
		goMsg($reUrl, '우리동네학원 신청이 완료 되었습니다.\n\n관리자 확인 후 연락드리겠습니다.');
		break;
	case 'M':
		$sPw = empty($_POST['sPw']) ? false : md5($db_conn -> rc4crypt(trim($_POST['sPw'])));
		$USQL = "UPDATE `town_academy` SET ";
		
		if ($sPw) {
			$USQL .= " sPw = '". $sPw ."', ";
		}
		
		$USQL .= " zip_table = '". $zip_table ."',
				sSigun = '". $sSigun ."',
				sDong = '". $sDong ."',
				town_group1_id = '". $town_group1_id ."',
				town_group2_id = '". $town_group2_id ."',
				sName = '". $sName ."',
				sCeo = '". $sCeo ."',
				sTel = '". $sTel ."',
				sHphone = '". $sHphone ."',
				sZipCode = '". $sZipCode ."',
				sAddr = '". $sAddr ."',
				sAddrSub = '". $sAddrSub ."',
				sMapSearch = '". $sMapSearch ."',
				sUrl = '". $sUrl ."',
				sContent = '". $sContent ."'
			WHERE id='".$id."'
		";
		$URES = $db_conn->sql($default_db, $USQL);
		// 파일처리
		if (is_array($delfile)) {
			delete_files_town($delfile);
		}
		filesUpload_town($_FILES['files'], 'P', $id);
		$reUrl = $repath. "town_view.php?id=".$id;
		goMsg($reUrl, $sName .' 수정이 완료 되었습니다.');
		break;
	default :
		break;
}
?>