<?php
include_once("./_common.php");
include_once("$root/lib/phpheader.php");
include_once("$root/lib/function.php");
include_once("$root/lib/class.php");
include_once("$root/lib/db_info.php");
include_once("$root/lib/config.php");
include_once("town_function.php");

$mode = $_POST['mode'];

switch ($mode) {
	case 'getGroup2':
		$id= $_POST['id'];
		$CSQL = "SELECT COUNT(id) FROM `town_group2` WHERE town_group1_id='". $id ."'";
		$CRES = $db_conn -> sql($default_db, $CSQL);
		list($count) = mysql_fetch_row($CRES);
		if ($count > 0) {
			$SSQL = "SELECT id, sGroupName FROM `town_group2` WHERE town_group1_id='". $id ."' ORDER BY iSort";
			$SRES = $db_conn -> sql($default_db, $SSQL);
			while (list($gid, $gName) = mysql_fetch_row($SRES)) {
				$Data['group'][$gName] = $gid; // 자바스크립트 for in 정렬관계상 id를 gName을 key값으로
			}
		}
		$Data['count'] = $count;
		echo json_encode($Data);
		break;
		
	case 'getSigun' :
		$table = $_POST['table'];
		$GSQL = "SELECT sSigun FROM ".$table." GROUP BY sSigun";
		$GRES = $db_conn -> sql($default_db, $GSQL);
		while (list($sigun) = mysql_fetch_row($GRES)) {
			$Data[] = $sigun;
		}
		sort($Data);
		echo json_encode($Data);
		break;
	
	case 'getDong' :
		$table = $_POST['table'];
		$sigun = $_POST['sigun'];
		$DSQL = "SELECT sEupmyon, sDong FROM ".$table." WHERE sSigun='".$sigun."' GROUP BY sEupmyon , sDong";
		$DRES = $db_conn -> sql($default_db, $DSQL);
		while (list($E, $D)= mysql_fetch_row($DRES)) {
			$Data[] = trim($E.$D);
		}
		sort($Data);
		echo json_encode($Data);
		break;
		
	case 'viewImg':
		$id=$_POST['id'];
		$SSQL = "SELECT sPath, sFile FROM `town_file` WHERE town_academy_id='".$id."' AND eType='P' ORDER BY id";
		$SRES = $db_conn -> sql($default_db, $SSQL);
		while ($row = mysql_fetch_assoc($SRES)) {
			$Data[] = $row;
		}
		echo json_encode($Data);
		break;
	case 'town_compare_password' :
		$id = $_POST['id'];
		$pw = md5($db_conn -> rc4crypt(trim($_POST['pw'])));
		$CSQL = "SELECT COUNT(id) FROM `town_academy` WHERE id='".$id."' AND sPw='".$pw."'";
		$CRES = $db_conn->sql($default_db, $CSQL);
		list($count) = mysql_fetch_row($CRES);
		if ($count == 1) {
			echo 'Y';
		} else {
			echo 'N';
		}
		break;
	case 'active_change' :
		$id = $_POST['id'];
		$iActive = $_POST['iActive'];
		
		$USQL = "UPDATE `town_academy` SET iActive='".$iActive."' WHERE id='".$id."'";
		$URES = $db_conn -> sql($default_db, $USQL);
		if ($URES) {
			echo 'Y';
		} else {
			echo 'N';
		}
		break;
	case 'delete_town' :
		$id = $_POST['id'];
		
		// 파일 삭제
		$FCSQL = "SELECT COUNT(id) FROM `town_file` WHERE town_academy_id='".$id."'";
		$FCRES = $db_conn -> sql($default_db, $FCSQL);
		list($fcnt) = mysql_fetch_row($FCRES);
		if($fcnt > 0) {
			$FSQL = "SELECT id FROM `town_file` WHERE town_academy_id='".$id."'";
			$FRES = $db_conn -> sql($default_db, $FSQL);
			while(list($fid) = mysql_fetch_row($FRES)){
				$delfile[] = $fid;
			}
			delete_files_town($delfile);
		}
		
		//데이터 삭제
		$DSQL = "DELETE FROM `town_academy` WHERE id='".$id."'";
		$DRES = $db_conn->sql($default_db, $DSQL);
		if ($DRES) {
			echo 'Y';
		} else {
			echo 'N';
		}
		
		break;
	default :
		print_r($_POST);
		//echo '모드가 없습니다.';
		break;
}
?>