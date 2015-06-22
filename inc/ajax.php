<?php
include_once("./_common.php");
include_once("$root/lib/phpheader.php");
include_once("$root/lib/function.php");
include_once("$root/lib/class.php");
include_once("$root/lib/db_info.php");
include_once("$root/lib/config.php");

$mode = $_POST['mode'];

switch($mode) {
	case 'boardSecretPwCheck' : // 게시판 비밀글 상위 비밀번호 체크
		$table = $_POST['table'];
		$board_id = $_POST['id'];
		$pw =  md5($db_conn -> rc4crypt(trim($_POST['pw'])));
		$CSQL = "SELECT COUNT(id) FROM ". $table ." WHERE id='". $board_id ."' AND sPw='". $pw ."'";
		$CRES = $db_conn -> sql($default_db, $CSQL);
		list ($count) = mysql_fetch_row($CRES);
		if ($count == 1) {
			$arr['pass'] = 'Y';
			$arr['pw'] = $pw;
		} else {
			$arr['pass'] ='N';
		}
		echo json_encode($arr);
		break;
		
	case 'id_overlap_check' : // 아이디 중복검사
		$sUserId= $_POST['sUserId'];
		$SSQL = "
			SELECT COUNT(id) FROM `users` WHERE sUserId='". $sUserId ."'
		";
		$SRES = $db_conn -> sql($default_db, $SSQL);
		list($count) = mysql_fetch_row($SRES);
		if($count == 0) {
			echo 'Y';
		} else {
			echo 'N';
		}
		break;
	case 'searchZipCode' : // 주소검색
		$searchType = $_POST['searchType'];
		$searchStr = $_POST['searchStr'];
		switch ($searchType) {
			case 'old' : // 구주소 검색
				$SSQL = "SELECT sZipcode, sSido, sGugun, sDong, sBunji FROM zipcodes WHERE sDong LIKE '%".$searchStr."%'";
				break;
			case 'new' : // 신주소 검색
				$SSQL = "SELECT CODE, SIDO, SIGUN, STREET, BUILDINGNUM2, BUILDING, BUILDINGDETAIL FROM zipcode2 WHERE STREET LIKE '%".$searchStr."%' ORDER BY BUILDINGNUM2";
				break;
		}
		$SRES = $db_conn -> sql($default_db, $SSQL);
		$i=0;
		while($zip = mysql_fetch_array($SRES)) {
			switch ($searchType) {
				case 'old' : // 구주소 검색
					$Data[$i]['zipcode'] = $zip['sZipcode'];
					$Data[$i]['addr'] = trim($zip['sSido'].' '. $zip['sGugun'].' '.$zip['sDong'].' '.$zip['sBunji']);
					break;
				case 'new' : // 신주소 검색
					$Data[$i]['zipcode'] = substr($zip['CODE'],0,3) .'-'. substr($zip['CODE'],3,3);
					$Data[$i]['addr'] = trim($zip['SIDO'].' '. $zip['SIGUN'].' '.$zip['STREET'].' '.$zip['BUILDINGNUM2']);
					if ($zip['BUILDING'] > 0) {
						$Data[$i]['addr'] .= '-'.$zip['BUILDING'];
					}
					$Data[$i]['addr'] .= ' '.$zip['BUILDINGDETAIL'];
					break;
			}
			$i++;
		}
		echo json_encode($Data);
		break;
	case 'searchZipCode_new' :
		$searchType = $_POST['searchType'];
		$searchStr = $_POST['searchStr'];
		$table = $_POST['sido'];
		
		$strtemp = explode(' ',$searchStr);
		$nums = explode('-', $strtemp[1]);
		
		$search['str'] = $strtemp[0];
		$search['no1'] = $nums[0];
		$search['no2'] = $nums[1];
		
		switch ($searchType) {
			case 'old' : // 구주소 검색
				$SSQL = "SELECT * FROM ".$table." 
					WHERE (sEupmyon='".$search['str']."' OR sDong='".$search['str']."') AND iBunji1 LIKE '%".$search['no1']."%' AND iBunji2 LIKE '%".$search['no2']."%'
					ORDER BY iBunji1, iBunji2
				";
				break;
			case 'new' : // 신주소 검색
				$SSQL = "SELECT * FROM ".$table." 
					WHERE sStreet='".$search['str']."' AND iBuildingNo1 LIKE '%".$search['no1']."%' AND iBuildingNo2 LIKE '%".$search['no2']."%'
					ORDER BY iBuildingNo1, iBuildingNo2
				";
				break;
		}

		$SRES = $db_conn -> sql($default_db, $SSQL);
		$i=0;
		while($zip = mysql_fetch_assoc($SRES)) {
			$Data[$i] = $zip;
			$Data[$i]['zipcode'] = substr($zip['sZipCode'],0,3) .'-'. substr($zip['sZipCode'],3,3);
			$Data[$i]['doro'] = $Data[$i]['zibun'] = $zip['sSido'].' '. $zip['sSigun'].' ';
			if (empty($zip['sEupmyon'])) {
				$Data[$i]['zibun'] .= $zip['sDong'].' ';
			} else {
				$Data[$i]['zibun'] .= $zip['sEupmyon'].' '. $zip['sRi'].' ';
			}
			$Data[$i]['zibun'] .= $zip['iSan'] == 1 ? '산 ' : '';
			$Data[$i]['zibun'] .= $zip['iBunji1'];
			$Data[$i]['zibun'] .= $zip['iBunji2']=='0' ? '' : '-'.$zip['iBunji2'];
			
			$Data[$i]['doro'] .= empty($zip['sEupmyon']) ? '': $zip['sEupmyon'].' ';
			$Data[$i]['doro'] .= $zip['sStreet'].' ';
			//$Data[$i]['doro'] .= $zip['iUnder'] ==1 ? '지하 ' : '';
			$Data[$i]['doro'] .= $zip['iBuildingNo1'];
			$Data[$i]['doro'] .= $zip['iBuildingNo2']=='0' ? '' : '-'.$zip['iBuildingNo2'];
			
			$Data[$i]['addr_sub'] = '(';
			if ($zip['sDong']) {
				$Data[$i]['addr_sub'] .= $zip['sDong'];
				if($zip['sBuilding']) {
					$Data[$i]['addr_sub'] .= ', ';
				}
			}
			$Data[$i]['addr_sub'] .= empty($zip['sBuilding']) ? ')' : $zip['sBuilding'].')';
			$i++;
		}
		echo json_encode($Data);
		
		break;
	case 'send_sms_confirm' : // 회원가입 인증 문자 보내기
		$sHphone = $_POST['hp'];
		$smsMode = $_POST['smsMode'];
		switch ($smsMode) {
			case 'join' :
				$MSG = $HOME_CONFIG['MemberJoinSmsMsg'];
				break;
			case 'findPw' :
				$MSG = $HOME_CONFIG['MemberFindPwSmsMsg'];
				break;
		}
		$numbers = '0123456789012345678901234567890123456789';
		$shuffle = str_shuffle($numbers);
		$sConfirmNum = substr($shuffle,0,6);
		$sComment = str_replace('[HOMETITLE]', $HOME_CONFIG['HomeTitle'] , $MSG);
		$sComment = str_replace('[SMSNUMBER]', $sConfirmNum, $sComment );
		$LSQL = "
			INSERT INTO `sms_log` SET 
				sHphone='".$sHphone."',
				sComment='".$sComment."',
				dInDate=NOW()
		";
		$LRES = $db_conn -> sql($default_db, $LSQL);
		if ($LRES) {
			$log_id = mysql_insert_id();
			// 이곳에서 문자 발송 처리
			$sd['msg'] = $sComment;
			$sd['rphone'] = $sHphone;
			$Data['Result'] = sendsms($sd);
			$Data['send'] = 'Y';
			$Data['id'] = $log_id;
		} else {
			$Data['send'] = 'N';
			$Data['id'] = 0;
		}
		$Data['smsMode'] = $smsMode;
		echo json_encode($Data);
		break;
		
	case 'post_sms_confirm' : // 회원가입 휴대폰 인증하기
		$smslog_id = $_POST['smslog_id'];
		$sConfirmNum = $_POST['sConfirmNum'];
		$CSQL = "
			SELECT COUNT(id) FROM `sms_log` 
			WHERE id='". $smslog_id ."' AND sComment LIKE '%". $sConfirmNum ."%';
		";
		$CRES = $db_conn -> sql($default_db, $CSQL);
		list($count) = mysql_fetch_row($CRES);
		if ($count == 1) {
			echo 'Y';
		} else {
			echo 'N';
		}
		break;
	case 'search_ID' : // 회원  ID 찾기
		$dBirth = $_POST['data']['year'] .'-'. $_POST['data']['month'] .'-'. $_POST['data']['day'];
		$sEmail = $_POST['data']['email'];
		$SSQL ="SELECT COUNT(id), sUserId FROM `users` WHERE dBirth ='".$dBirth."' AND sEmail='".$sEmail."'";
		$SRES = $db_conn -> sql($default_db, $SSQL);
		list ($data['cnt'], $data['sUserId']) = mysql_fetch_row($SRES);
		$data['mode'] = $mode;
		echo json_encode($data);
		break;
	case 'search_PW' : // 회원 pw 찾기 인증
		//echo json_encode($_POST);
		$smslog_id = $_POST['data']['smslog_id'];
		$sConfirmNum = $_POST['data']['sms_confirm'];
		$sUserId = $_POST['data']['sUserId'];
		$sHphone = $_POST['data']['sHphone'];
		$sEmail = $_POST['data']['sEmail'];
		$CSQL = "
			SELECT COUNT(id) FROM `sms_log` 
			WHERE id='". $smslog_id ."' AND sComment LIKE '%". $sConfirmNum ."%';
		";
		$CRES = $db_conn -> sql($default_db, $CSQL);
		list($count) = mysql_fetch_row($CRES);
		if ($count == 1) {
			$SCSQL = "SELECT COUNT(id), id , sHphone  FROM `users` WHERE sUserId='".$sUserId."' AND sHphone='".$sHphone."' AND sEmail='".$sEmail."'";
			$SCRES = $db_conn -> sql($default_db, $SCSQL);
			list ($idCount, $id, $sHp) = mysql_fetch_row($SCRES);
			if ($idCount == 1) {
				$Data['valid'] = true;
				if ($sHphone == $sHp) {
					$Data['hpChange'] = false;
					$Data['msg'] = '';
				} else {
					$Data['hpChange'] = true;
					$Data['msg'] = '휴대폰 번호가 변경되어 인증받은 번호로 저장됩니다.';
				}
				$Data['id'] = $id;
				$Data['sHphone'] = $sHphone;
			} else {
				$Data['valid'] = false;
				$Data['msg'] = '일치하는 회원이 없습니다.';
			}
		} else {
			$Data['msg'] = '번호인증이 변경되었습니다.';
			$Data['valid'] = false;
		}
		$Data['mode'] = $mode;
		echo json_encode($Data);
		break;
		
	case 'change_password':  // 회원비밀번호 찾기 변경 - 전화번호 같이 변경
		//echo  json_encode($_POST);
		$sUserPw = md5($db_conn -> rc4crypt(trim($_POST['data']['sUserPw'])));
		$sHphone = $_POST['data']['sHphone'];
		$id = $_POST['data']['id'];
		
		$USQL = "
			UPDATE `users` SET 
				sUserPw = '". $sUserPw ."',
				sHphone = '". $sHphone ."'
			WHERE id='". $id ."'
		";
		$URES = $db_conn -> sql($default_db, $USQL);
		if($URES) {
			$Data['valid'] = true;
		} else {
			$Data['valid'] = false;
		}
		$Data['mode'] = $mode;
		echo json_encode($Data);
		break;
		
	case 'update_user_login_log': // 유저 로그인 기록을 업데이트 한다.
		$user_id = $_POST['user_id'];
		
		// 로그기록 30초 이전것은 iActive를 0으로 초기화
		$ASQL = "
			UPDATE `user_login_log` SET
				iActive ='0'
			WHERE dLogDate < NOW() - INTERVAL 30 SECOND
		";
		$ARES = $db_conn -> sql($default_db, $ASQL);
		
		$LSQL = "
			UPDATE `user_login_log` SET
				iActive ='1',
				dLogDate = NOW()
			WHERE user_id = '".$user_id."'
		";
		$LRES = $db_conn -> sql($default_db, $LSQL);
		break;
	case 'getSmsCheckGroup' : // 유저 id 배열을 받아 이름과 전화번호 반환
		//print_r($_POST);
		$ids = array_for_sql_IN($_POST['idArr']);
		$SSQL = "SELECT sUserName, sHphone FROM `users` WHERE id IN(".$ids.")";
		$SRES = $db_conn -> sql($default_db, $SSQL);
		$i=0;
		while($row = mysql_fetch_assoc($SRES)) {
			$Data[$i]['name'] = $row['sUserName'];
			$Data[$i++]['hp'] = $row['sHphone'];
		}
		echo json_encode($Data);
		break;
	case 'insert_sms_preset' : // 프리셋 입력
		$sText = trim($_POST['sText']);
		$ISQL = "INSERT INTO `sms_preset` SET sText='".$sText."'";
		$IRES = $db_conn -> sql($default_db, $ISQL);
		break;
	case 'get_sms_preset': // 프리셋 가져오기 
		$page = $_POST['page'];
		$count = $_POST['count'];
		$limite = ($page-1) * $count;
		$limite = " LIMIT ". $limite . ", ". $count;
		
		$CSQL = "SELECT COUNT(id) FROM `sms_preset`";
		$CRES = $db_conn -> sql($default_db, $CSQL);
		list($total) = mysql_fetch_row($CRES);
		
		$SSQL = "SELECT * FROM `sms_preset` ORDER BY id DESC " . $limite;
		$SRES = $db_conn->sql($default_db, $SSQL);
		$i=0;
		while ($row = mysql_fetch_assoc($SRES)) {
			$Data['set'][$i]['id'] = $row['id'];
			$Data['set'][$i++]['sText'] = $row['sText'];
		}
		$Data['page'] = array(
			'current_page' => intval($page),
			'limite' => intval($count),
			'total' => $total,
			'total_page' => ceil($total/$count),
			'page_list' => ceil(intval($page)/10)-1
		);
		echo json_encode($Data);
		break;
	case 'sms_preset_delete' : // sms 프리셋 삭제
		$id = $_POST['id'];
		$DSQL = "DELETE FROM `sms_preset` WHERE id='".$id."'";
		$DRES = $db_conn -> sql($default_db, $DSQL);
		break;
	case 'manager_sms_send' : // 문자 전송하기
		//print_r($_POST);
		$sd['destination'] = array_for_sql_IN($_POST['data']);
		$sd['msg'] = $_POST['msg'];
		$Data = sendsms($sd);
		echo json_encode($Data);
		break;
	case 'getSmsTotalCount' : // 문자 잔여건수 조회
		$Data = countsms();
		echo json_encode($Data);
		break;
	case 'tableToCsv' : // 테이블 정보를 받아 CSV 파일 출력
		print_r($_POST);
		$title = $_POST['title'];
		$row = $_POST['row'];
		
		$file = $root . "/data/excel.csv";
		if (file_exists($file)) {
			unlink($file);
		}
		
		$newline = chr(10);
		$fp = fopen($file,'w');
		fwrite($fp, array_for_sql_IN($title));
		foreach ($row as $val) {
			fwrite($fp, $newline);
			fwrite($fp, array_for_sql_IN($val));
		}
		fclose($fp);
		/*
		header('Content-Description: File Transfer');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachement; filename="' . $file . '"');
        header('Content-Transfer-Encoding: binary');
		*/
		
		break;
	case 'getCooperative' : //  업체정보 받아오기
		//echo json_encode($_POST);
		$id = $_POST['id'];
		$SSQL ="SELECT id, user_id, sTitle, sTitleSubfix, sContents, sUrl, sTel, sAddr, sAddrSub, iCount FROM `cooperative_firm_list` WHERE id='".$id."'";
		$SRES = $db_conn -> sql($default_db, $SSQL);
		$Data['contents'] = mysql_fetch_assoc($SRES);
		if ($MEMBER['id'] == $Data['contents']['user_id']) {
			$Data['contents']['manager'] = true;
		} else {
			$Data['contents']['manager'] = false;
		}
		
		if ($MEMBER['iHLevel'] == 1) {
			$Data['contents']['admin'] = true;
		} else {
			$Data['contents']['admin'] = false;
		}
		
		$FSQL = "SELECT eType, sPath, sFile FROM `cooperative_firm_files` WHERE cooperative_id='".$id."' ORDER BY id";
		$FRES = $db_conn -> sql($default_db, $FSQL);
		$i=0;
		while (list($eType, $sPath, $sFile) = mysql_fetch_row($FRES)) {
			if ($eType == 'P') {
				$Data[$eType][$i]['sPath'] = $sPath;
				$Data[$eType][$i]['sFile'] = $sFile;
				$i++;
			} else {
				$Data[$eType]['sPath'] = $sPath;
				$Data[$eType]['sFile'] = $sFile;
			}
		}
		echo json_encode($Data);
		break;
	case 'CooperativeUpdateCount' : // 협력업체 링크 클릭시 카운트 업데이트 하기
		$id = $_POST['id'];
		$USQL = "UPDATE `cooperative_firm_list` SET iCount = iCount+1 WHERE id='".$id."'";
		$URES = $db_conn -> sql($default_db, $USQL);
		break;
	case 'suppoters': // 키맨,연사,협력업체 신청
		$eType = $_POST['eType'];
		$sName = $_POST['sName'];
		$sTel = $_POST['sTel'];
		$sText = $_POST['sText'];
		
		$ISQL = "
			INSERT INTO `supporters` SET 
				eType = '".$eType."',
				iAnswer = '1',
				sName = '".$sName."',
				sTel = '".$sTel."',
				sText = '".$sText."',
				dInDate = NOW()
		";
		$IRES = $db_conn -> sql($default_db, $ISQL);
		switch ($eType) {
			case 'K':
				$msg = '위드프랭즈 Key-Man에 지원 해주셔서 감사드립니다.<br /><br />빠른 시일내로 연락 드리겠습니다.';
				break;
			case 'S':
				$msg = '위드프랭즈 연사에 지원 해주셔서 감사드립니다.<br /><br />빠른 시일내로 연락 드리겠습니다.';
				break;
			case 'C':
				$msg = '위드프랭즈 협력업체에 신청 해주셔서 감사드립니다.<br /><br />빠른 시일내로 연락 드리겠습니다.';
				break;
		}
		echo $msg;
		break;
	case 'suppoters_answer' : // 키맨, 연사, 협력업체 답변 처리
		$id = $_POST['id'];
		$USQL = "UPDATE `supporters` SET iAnswer='2' WHERE id='$id'";
		$URES = $db_conn->sql($default_db, $USQL);
		break;
	case 'edu_nomember_ask' :
		$ISQL ="
			INSERT INTO `board_user_wishlist` SET 
				board_config_id = '".$_POST['board_config_id']."',
				board_table = '".$_POST['board_table']."',
				board_id = '".$_POST['board_id']."',
				user_id = '0',
				eWishType = 'ASK',
				sName_N = '".$_POST['sName_N']."',
				sHp_N = '".$_POST['sHp_N']."',
				sCenter_N = '".trim($_POST['sCenter_N'])."',
				iNumber_N = '". trim($_POST['iNumber_N']) ."',
				dInDate = NOW()
		";
		$IRES = $db_conn -> sql($default_db, $ISQL);
		
		if ($IRES) {
			echo "Y";
		} else {
			echo "N";
		}
		
		break;
	default :
		print_r($_POST);
		echo '모드가 없습니다.';
		break;

}
?>