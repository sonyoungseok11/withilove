<?php
include_once("./_common.php");
include_once("$root/lib/phpheader.php");
include_once("$root/lib/function.php");
include_once("$root/lib/class.php");
include_once("$root/lib/db_info.php");
include_once("$root/lib/config.php");

$mode = $_REQUEST['mode'];

switch($mode) {
	case 'contract_step_change': // 세무계약 스텝 변경
		$id = $_POST['cid'];
		$iStep = $_POST['iStep'];
		$USQL = "
			UPDATE `tax_contact` SET 
				iStep = '".$iStep."'
			WHERE id='".$id."'
		";
		$URES = $db_conn ->sql ($default_db, $USQL);
		break;
	case 'user_contract_dialog' : // 세무계약 유저 상세보기
		$id = $_POST['id'];
		$SSQL = "
			SELECT u.sUserId, u.sUserName, u.sHphone, u.sEmail, t.*
			FROM `users` u
			INNER JOIN `tax_contact` t  ON u.id=t.user_id
			WHERE t.id='".$id."'
		";
		$SRES = $db_conn -> sql($default_db, $SSQL);
		$Data = mysql_fetch_assoc($SRES);
		$Data['sSince'] = $Data['sSince'] . " 년";
		$Data['eLicense'] = $CONTRACT['eLicense'][$Data['eLicense']];
		$Data['iCounselingTime'] = $CONTRACT['iCounselingTime'][$Data['iCounselingTime']];
		$Data['iTotalSales'] = number_format($Data['iTotalSales']);
		$Data['iSalary'] = number_format($Data['iSalary']);
		$Data['iRent'] = number_format($Data['iRent']);
		$Data['eBookeep'] = $CONTRACT['eBookeep'][$Data['eBookeep']];
		$Data['iStep'] = $CONTRACT['iStep'][$Data['iStep']];
		echo json_encode($Data);
		break;
	case 'user_contract_ManagerNote_update' : // 세무계약 매니저 노트 업데이트
		$id = $_POST['id'];
		$sManagerNote = trim($_POST['sManagerNote']);
		$USQL = "
			UPDATE `tax_contact` SET 
				sManagerNote = '".$sManagerNote."'
			WHERE id='".$id."'
		";
		$URES = $db_conn ->sql ($default_db, $USQL);
		break;
	
	
	case 'Search_Mebmber':
		//echo json_encode($_POST);
		$sMode = $_POST['sMode'];
		$searchType = $_POST['searchType'];
		$searchStr = trim($_POST['searchStr']);
		$SSQL = "SELECT id, sUserId, sUserName, sHphone FROM `users` WHERE ".$searchType." LIKE '%".$searchStr."%'";
		$SRES = $db_conn -> sql($default_db, $SSQL);
		while ($row = mysql_fetch_assoc($SRES)) {
			$Data[] = $row;
		}
		echo json_encode($Data);
		break;
	case 'smsSeminar_setup' :
		$sms_seminar = trim($_POST['sms_seminar']);
		$USQL ="UPDATE `home_config` SET sms_seminar='".$sms_seminar."'";
		$URES = $db_conn -> sql($default_db, $USQL);
		if ($URES) {
			echo 'Y';
		} else {
			echo 'N';
		}
		break;
	default :
		echo '모드가 없습니다.';
		break;

}
?>