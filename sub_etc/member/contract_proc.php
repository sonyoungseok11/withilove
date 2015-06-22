<?php
include_once("./_common.php");
include_once("$root/lib/phpheader.php");
include_once("$root/lib/function.php");
include_once("$root/lib/class.php");
include_once("$root/lib/db_info.php");
include_once("$root/lib/config.php");

$mode = $_POST['mode'];
$contract_id = $_POST['contract_id'];
$sName = $_POST['sName'];
$sSince = $_POST['sSince'];
$eLicense = $_POST['eLicense'];
$sTel = $_POST['sTel'];
$sZipCode = $_POST['sZipCode'];
$sAddr = $_POST['sAddr'];
$sAddrSub = $_POST['sAddrSub'];
$iCounselingTime = $_POST['iCounselingTime'];
$iTotalSales = str_replace(',','',$_POST['iTotalSales']);
$iTeacher = $_POST['iTeacher'];
$iSalary = str_replace(',','',$_POST['iSalary']);
$iRent = str_replace(',','',$_POST['iRent']);
$eBookeep = $_POST['eBookeep'];
$sTaxName = $_POST['sTaxName'];
$sNote = trim(strip_tags($_POST['sNote']));

$url = $path ."/sub_etc/member/contract.php";

switch($mode) {
	case 'I' : // 신규등록
		$ISQL = "
			INSERT INTO `tax_contact` SET
				user_id ='". $MEMBER['id']."',
				iStep ='1',
				sName = '".$sName."',
				sSince = '".$sSince."',
				eLicense = '".$eLicense."',
				sTel = '".$sTel."',
				sZipCode = '".$sZipCode."',
				sAddr = '".$sAddr."',
				sAddrSub = '".$sAddrSub."',
				iCounselingTime = '".$iCounselingTime."',
				iTotalSales = '".$iTotalSales."',
				iTeacher = '".$iTeacher."',
				iSalary = '".$iSalary."',
				iRent ='".$iRent."',
				eBookeep ='".$eBookeep."',
				sTaxName ='".$sTaxName."',
				sNote = '".$sNote."',
				dInDate =NOW()
		";
		$IRES = $db_conn -> sql($default_db, $ISQL);
		$msg = "세무대리계약 신청이 완료 되었습니다.";
		goMsg($url, $msg);
		break;
		
	case 'M' : // 수정
		$USQL = "
			UPDATE `tax_contact` SET
				sName = '".$sName."',
				sSince = '".$sSince."',
				eLicense = '".$eLicense."',
				sTel = '".$sTel."',
				sZipCode = '".$sZipCode."',
				sAddr = '".$sAddr."',
				sAddrSub = '".$sAddrSub."',
				iCounselingTime = '".$iCounselingTime."',
				iTotalSales = '".$iTotalSales."',
				iTeacher = '".$iTeacher."',
				iSalary = '".$iSalary."',
				iRent ='".$iRent."',
				eBookeep ='".$eBookeep."',
				sTaxName ='".$sTaxName."',
				sNote = '".$sNote."'
			WHERE id=".$contract_id."
		";
		$URES = $db_conn -> sql($default_db, $USQL);
		$msg = "세무대리계약 신청 정보가 변경되었습니다.";
		goMsg($url, $msg);
		break;
}
?>