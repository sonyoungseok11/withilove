<?php
include_once("./_common.php");
include_once("$root/lib/phpheader.php");
include_once("$root/lib/function.php");
include_once("$root/lib/class.php");
include_once("$root/lib/db_info.php");
include_once("$root/lib/config.php");
/*
print_r($_POST);
print_r($_FILES);
print_r($_SERVER);
*/
$mode = $_POST['mode'];
$board_config_id = $_POST['board_config_id'];
$board_id = $_POST['board_id'];
$user_id = $_POST['user_id'];
$iCategory = empty($_POST['iCategory']) ? 0 : $_POST['iCategory'];
$sName = $_POST['sName'];
$iSecret = empty($_POST['iSecret']) ? 0 : 1;
$sPw = empty($_POST['sPw']) ? $MEMBER['sUserPw'] :  md5($db_conn -> rc4crypt(trim($_POST['sPw'])));
$sEmail = $_POST['sEmail'];
$sTitle = $_POST['sTitle'];
$sComment = strip_tag_arrays(trim($_POST['sComment']), array('script','object','iframe'));
$fileArr = $_FILES['file'];
$delfile = $_POST['delfile'];
$parent_id = $_POST['parent_id'];
$parent_iOrder = $_POST['parent_iOrder'];
$parent_iDepth = $_POST['parent_iDepth'];
$reply_id = $_POST['reply_id'];
$dStartDate = empty($_POST['dStartDate']) ? '0000-00-00' : $_POST['dStartDate'] ;
$dEndDate = empty($_POST['dEndDate']) ? '0000-00-00' : $_POST['dEndDate'] ;
$sPreface = strip_tags(trim($_POST['sPreface']));
$sSMS = trim($_POST['sSMS']);

$BCSQL = "
	SELECT b.*, s.sMenuUrl FROM `board_config` b
	INNER JOIN sitemenu s ON b.id = s.board_config_id
	WHERE b.id='". $board_config_id ."'
";
$BCRES = $db_conn -> sql($default_db,$BCSQL);
$BOARD_CONFIG = mysql_fetch_assoc($BCRES);

$table = $BOARD_CONFIG['sTablePrefix'].'_'.$BOARD_CONFIG['sTableName'];

$returnUrl = empty($_POST['returnUrl']) ? $BOARD_CONFIG['sMenuUrl'] : $_POST['returnUrl'] ;

//print_r($BOARD_CONFIG);

switch ($mode) {
	case 'W' : // 신규글작성
		$MaxSQL = "SELECT iOrder FROM ". $table ." ORDER BY iOrder DESC LIMIT 0,1";
		$MaxRES = $db_conn -> sql($default_db, $MaxSQL);
		list ($Max_iOrder) = mysql_fetch_row($MaxRES);
		
		$iOrder = ceil($Max_iOrder/1000)*1000+1000;
		
		// 파일 업로드가 있는지 확인
		if (is_array($fileArr)) {
			foreach ($fileArr['error'] as $fk => $fv) {
				if ($fv == 0) {
					$iHaveFile = 1;
					break;
				}
			}
		}
		$iHaveFile = empty($iHaveFile) ? 0 : 1;
		
		$ISQL ="
			INSERT INTO ". $table. " SET
				user_id = '".$user_id ."',
				iOrder = '". $iOrder ."',
				iDepth = '0',
				sName = '". $sName ."',
				sEmail = '". $sEmail ."',
				sPw = '". $sPw ."',
				iCategory = '". $iCategory ."',
				sTitle = '". $sTitle ."',
				sPreface = '". $sPreface ."',
				sComment = '". $sComment ."',
				iSecret = '". $iSecret ."',
				iHaveFile = '". $iHaveFile ."',
				iSee = '0',
				sIp = '". $_SERVER['REMOTE_ADDR'] ."',
				dIndate = NOW(),
				dStartDate ='".$dStartDate."',
				dEndDate = '".$dEndDate."',
				sSMS = '".$sSMS."'
		";
		$IRES = $db_conn -> sql($default_db, $ISQL);
		$board_id = mysql_insert_id();
		if ($iHaveFile) {
			$filemsg = filesUpload($fileArr, $board_id);
		}
		//echo $_SERVER['HTTP_REFERER'];
		$url = $returnUrl."?mode=R&id=".$board_id; //substr($_SERVER['HTTP_REFERER'], 0, strpos($_SERVER['HTTP_REFERER'],'?'));
		$msg = '게시물이 등록 되었습니다.\n\n' . $filemsg;
		
		goMsg($url, $msg);
		break;
		
	case 'M' :// 글 수정
		// 파일 삭제 부터 하고
		if (is_array($delfile)) {
			delete_files($delfile);
		}
		
		// 업로드가 없다면 업로드한 파일중 삭제후 남은 파일이 있는지 확인
		$CFSQL ="SELECT COUNT(id) FROM `board_file` WHERE board_config_id='". $board_config_id ."' AND board_id='".$board_id."'";
		$CFRES = $db_conn -> sql($default_db, $CFSQL);
		list($fileCount) = mysql_fetch_row($CFRES);
		$iHaveFile = ($fileCount > 0) ? 1 : 0;
		
		// 파일 업로드가 있는지 확인
		if (is_array($fileArr)) {
			foreach ($fileArr['error'] as $fk => $fv) {
				if ($fv == 0) {
					$iHaveFile = 1;
					$iHaveUpFile = true;
					break;
				}
			}
		} else {
			$iHaveUpFile = false;
		}
	
		$USQL ="
			UPDATE ". $table ." SET
				sEmail = '". $sEmail ."',
				sPw = '". $sPw ."',
				iCategory = '". $iCategory ."',
				sTitle = '". $sTitle ."',
				sPreface = '". $sPreface ."',
				sComment = '". $sComment ."',
				iSecret = '". $iSecret ."',
				iHaveFile = '". $iHaveFile ."',
				dStartDate ='".$dStartDate."',
				dEndDate = '".$dEndDate."',
				sSMS = '".$sSMS."'
			WHERE id='".$board_id."'
		";
		$URES = $db_conn -> sql($default_db, $USQL);
		
		if ($iHaveUpFile) {
			$filemsg = filesUpload($fileArr, $board_id);
		}
		$url = $_SERVER['HTTP_REFERER']."?mode=R&id=".$board_id;; 
		$msg = '게시물이 등록 되었습니다.\n\n' . $filemsg;
		goMsg($url, $msg);
		break;
	
	case 'A' : // 답글쓰기
		if ($parent_iOrder%1000 > 0) {
			$prev_parent_iOrder = floor($parent_iOrder/1000)*1000; 
		}
		else {
			$prev_parent_iOrder = $parent_iOrder - 1000;
		}

		$OUSQL = "UPDATE ". $table ." SET iOrder=iOrder-1 WHERE iOrder > $prev_parent_iOrder AND iOrder < $parent_iOrder";
		$OURES = $db_conn -> sql($default_db, $OUSQL);
		
		// 파일 업로드가 있는지 확인
		if (is_array($fileArr)) {
			foreach ($fileArr['error'] as $fk => $fv) {
				if ($fv == 0) {
					$iHaveFile = 1;
					break;
				}
			}
		}
		$iHaveFile = empty($iHaveFile) ? 0 : 1;
		
		$ISQL ="
			INSERT INTO ". $table. " SET
				user_id = '".$user_id ."',
				iOrder = '". ($parent_iOrder-1) ."',
				iDepth = '". ($parent_iDepth+1) ."',
				sName = '". $sName ."',
				sEmail = '". $sEmail ."',
				sPw = '". $sPw ."',
				iCategory = '". $iCategory ."',
				sTitle = '". $sTitle ."',
				sPreface = '". $sPreface ."',
				sComment = '". $sComment ."',
				iSecret = '". $iSecret ."',
				iHaveFile = '". $iHaveFile ."',
				iSee = '0',
				sIp = '". $_SERVER['REMOTE_ADDR'] ."',
				dIndate = NOW(),
				dStartDate ='".$dStartDate."',
				dEndDate = '".$dEndDate."',
				sSMS = '".$sSMS."'
		";
		$IRES = $db_conn -> sql($default_db, $ISQL);
		$board_id = mysql_insert_id();
		if ($iHaveFile) {
			$filemsg = filesUpload($fileArr, $board_id);
		}
		
		$url = $returnUrl."?mode=R&id=".$board_id; //substr($_SERVER['HTTP_REFERER'], 0, strpos($_SERVER['HTTP_REFERER'],'?'));
		$msg = '게시물이 등록 되었습니다.\n\n' . $filemsg;
		
		goMsg($url, $msg);
		break;
		
	case 'D' :// 게시물 삭제
		$id = $_POST['id'];
		if (is_array($id)) { // 목록 선택삭제
			$i=0;
			foreach($id as $b_id) {
				$returnVal =  board_item_delete($b_id);
				$i++;
			}
		} else { // 글보기 한개 삭제
			$returnVal = board_item_delete($id);
			$i=1;
		}
		
		if ($returnVal) {
			$msg = $i.'개의 게시물이 삭제 되었습니다.';
		} else {
			$msg = '개시물 삭제에 실패하였습니다.';
		}
		$url = $returnUrl."?mode=L";
		goMsg($url, $msg);
		break;
	case 'reply_W' : // 신규 덧글작성
		$sComment = trim(strip_tags($_POST['sComment']));
		$ISQL = "
			INSERT INTO `board_reply` SET
				board_config_id = '". $board_config_id ."',
				board_id = '". $board_id ."',
				user_id = '". $user_id ."',
				sName = '". $sName ."',
				sComment = '". $sComment ."',
				sIp = '". $_SERVER['REMOTE_ADDR'] ."',
				dInDate = NOW()
		";
		$IRES = $db_conn -> sql($default_db, $ISQL);
		$url = $returnUrl ."?mode=R&id=".$board_id;
		echo '
			<script type="text/javascript">
				location.href="'.$url.'";
			</script>
		';
		break;
	case 'reply_M' : // 덧글 수정
		$sComment = trim(strip_tags($_POST['sComment']));
		$USQL = "
			UPDATE `board_reply` SET
				sComment = '". $sComment ."'
			WHERE id='". $reply_id ."'
		";
		$URES = $db_conn -> sql($default_db, $USQL);
		$url = $returnUrl."?mode=R&id=".$board_id;
		echo '
			<script type="text/javascript">
				
				location.href="'.$url.'";
			</script>
		';
		break;
	case 'reply_D' : // 덧글 삭제
		$DSQL = "DELETE FROM `board_reply` WHERE id='". $reply_id ."'";
		$DRES = $db_conn -> sql($default_db, $DSQL);
		$url = $_SERVER['HTTP_REFERER'] ."?mode=R&id=".$board_id;
		echo '
			<script type="text/javascript">
				location.href="'.$url.'";
			</script>
		';
		break;
	case 'Wishlist_insert':
		//print_r($_POST);
		$board_config_id = $_POST['board_config_id'];
		$table = $_POST['board_table'];
		$board_id = $_POST['board_id'];
		$user_id = $_POST['user_id'];
		$eWishType = $_POST['eWishType'];
		$IWSQL = "
			INSERT INTO `board_user_wishlist` SET 
				board_config_id = '".$board_config_id."',
				board_table = '".$table."',
				board_id = '".$board_id."',
				user_id = '".$user_id."',
				eWishType = '".$eWishType."',
				dInDate = NOW()
		";
		$IWRES = $db_conn -> sql($default_db, $IWSQL);
		if ($IWRES) {
			$Data['result'] = 'Y';
			$Data['id'] = mysql_insert_id();
			// 여기에 문자
			if ($eWishType =='ASK') {
				$Data['re'] = seminar_send_sms($Data['id']);
			}
		} else {
			$Data['result'] = 'N';
		}
		echo json_encode($Data);
		break;
	case 'Wishlist_update':
		//print_r($_POST);
		$wish_id = $_POST['wish_id'];
		$eWishType = $_POST['eWishType'];
		$UWSQL = "
			UPDATE `board_user_wishlist` SET 
				eWishType = '".$eWishType."',
				dInDate = NOW()
			WHERE id='".$wish_id."'
		";
		$UWRES = $db_conn -> sql($default_db, $UWSQL);
		if ($UWRES) {
			echo 'Y';
			// 여기에 문자
			seminar_send_sms($wish_id);
		} else {
			echo 'N';
		}
		break;
	case 'Wishlist_del':
		//print_r($_POST);
		$wish_id = $_POST['wish_id'];
		$DWSQL = "DELETE FROM `board_user_wishlist` WHERE id='".$wish_id."'";
		$DWRES = $db_conn -> sql($default_db, $DWSQL);
		if ($DWRES) {
			echo 'Y';
		} else {
			echo 'N';
		}
		break;
}

?>