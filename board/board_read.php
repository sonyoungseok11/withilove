<?php
$board_id = $_REQUEST['id'];
$page = $_POST['page'];

$RSQL = "SELECT *, DATEDIFF(dStartDate, NOW()) AS DiffDay FROM ". $table ." WHERE id='".$board_id."'";
$RRES = $db_conn -> sql($default_db, $RSQL);
$Datas = mysql_fetch_assoc($RRES);

/* 비밀글 이라면 */
if($Datas['iSecret'] == 1) {
	$source_id = $_POST['source_id'];
	$source_pw = empty($_POST['source_pw']) ? $MEMBER['sUserPw'] : $_POST['source_pw'];
	if ($MEMBER['iHLevel'] != 1) {
		if (empty($source_id)) {
			goBack('잘못된 접근 입니다.');
			exit;
		}
		if ( $Datas['id'] == $source_id ) {
			if ($Datas['sPw'] != $source_pw) {
				goBack('접근권한이 없습니다.');
				exit;
			}
		} else {
			$SCRSQL = "SELECT sPw FROM " .$table. " WHERE id='".$source_id."'";
			$SCRRES = $db_conn -> sql($default_db, $SCRSQL);
			list($sPw) = mysql_fetch_row($SCRRES);
			if ($sPw != $source_pw ) {
				goBack('접근권한이 없습니다.');
				exit;
			}
		}
	}
}

/* 조회수 증가 */
$UCSQL = "UPDATE ". $table ." SET iSee=iSee+1 WHERE id='".$board_id."'";
$UCRES = $db_conn -> sql($default_db, $UCSQL);
$Datas['iSee']++;

if($Datas['iHaveFile'] > 0) {
	$FSQL = "SELECT * FROM `board_file` WHERE board_config_id='". $board_config_id ."' AND board_id='". $board_id ."'";
	$FRES = $db_conn -> sql($default_db, $FSQL);
	$i=0;
	$linkfile = "";
	$sComment_update = false;
	while($Frow = mysql_fetch_assoc($FRES)) {
		$DownFile[$i] = $Frow;
		$i++;
		$ext = strtolower(substr(strrchr($Frow["sCopy"],"."),1));
		if (eregi("gif|png|jpg", $ext)) {
			if (strpos($Datas['sComment'], $Frow['sCopy']) === false) {
				$img_link = "<img src=\"".$root.'/'. $Frow['sPath']. '/' . $Frow['sCopy']. "\" alt=\"".$Frow['sFile']."\">";
				$Datas['sComment'] = $Datas['sComment']. $img_link;
				$sComment_update = true;
			}
		} else {
			if ($is_DownloadLevel) {
				$linkfile .= "<a href=\"javascript:;\" onclick=\"filedownload(". $Frow['id'].");\">" . $Frow['sFile'];
				$linkfile .= " <span class=\"filesize\">(". getFileSize($Frow['iFileSize']) .")</span>";
				$linkfile .= " <span class=\"downcount\">[". $Frow['iDownload'] ."]</span></a>";
			} else {
				$linkfile .= "<a href=\"javascript:;\" onclick=\"alertMsg('알림','파일 다운로드 권한이 없습니다.');\">" . $Frow['sFile'];
				$linkfile .= " <span class=\"filesize\">(". getFileSize($Frow['iFileSize']) .")</span>";
				$linkfile .= " <span class=\"downcount\">[". $Frow['iDownload'] ."]</span></a>";
			}
		}
	}
}

$UCSQL2 = "UPDATE ". $table ." SET sComment='". $Datas['sComment'] ."' WHERE id='".$board_id."'";
$UCRES2 = $db_conn -> sql($default_db, $UCSQL2);


/* 연관글 불러오기 */
$iOrder_start = (ceil($Datas['iOrder']/1000)-1)*1000; //연관글 시작
$iOrder_end = ceil($Datas['iOrder']/1000)*1000; // 다음글
$iOrder_prev = $iOrder_end + 1000; // 이전글

$ASSQL = "SELECT id, iOrder, iDepth, sName, iCategory, sTitle, iSecret, iHaveFile, iSee, DATE_FORMAT(dInDate, '%Y-%m-%d') as dInDate FROM ". $table ." WHERE iOrder=".$iOrder_prev;
$ASRES = $db_conn -> sql($default_db, $ASSQL);
$ASSQL2 = "SELECT id, iOrder, iDepth, sName, iCategory, sTitle, iSecret, iHaveFile, iSee, DATE_FORMAT(dInDate, '%Y-%m-%d') as dInDate FROM ". $table ." WHERE iOrder BETWEEN ".$iOrder_start." AND ".$iOrder_end." ORDER BY iOrder DESC";
$ASRES2 = $db_conn -> sql($default_db, $ASSQL2);

$i=0;
$ASSDatas[$i++] = mysql_fetch_assoc($ASRES);
while ($ASS = mysql_fetch_assoc($ASRES2)) {
	$ASSDatas[$i++] = $ASS;
}

$headerValArr = array("번호","제목","작성자","등록일","조회수");
$headerColArr = array("8%","auto","8%","12%","6%");
$TableHeaderPositionArr = array("center","center","center","center","center"); // 해더 포지션
$TablePositionArr = array("center","left","center","center","center"); // 목록 포지션

//$assocHeader = $b -> boardHeader($headerValArr, $headerColArr,  $TableHeaderPositionArr, $BOARD_CONFIG['sBoardSubject']);
$assocList = sqlShowData_basic_ReadList($ASSDatas, $board_id, $TablePositionArr, $headerColArr);
$assocVal = $assocHeader.$assocList; 

/* 글삭제가 가능한지 보기 하위 목록이 있으면 글삭제를 못함 */
$SDSQL = "SELECT iDepth FROM ". $table ." WHERE iOrder < ". $Datas['iOrder']." ORDER BY iOrder DESC LIMIT 1";
$SDRES = $db_conn -> sql($default_db, $SDSQL);
list($child_depth) = mysql_fetch_row($SDRES);
$ThisDel =  ($child_depth > $Datas['iDepth']) ? false : $ThisDel = true;

/* 덧글 목록 불러오기 */
if ($BOARD_CONFIG['iUseReply']) {
	$replyList = sqlShowData_reply_basic();
}
// 관리자 라면 게시물 링크를 표시
if ($MEMBER['iHLevel'] == 1) {
	$itemURL = '<div class="url">게시물 주소 : <input type="text" value="'. $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?mode=R&id=".$Datas['id'] . '" style="width: 800px;"/></div>';
}

include_once("$skin_dir/read.php");
?>