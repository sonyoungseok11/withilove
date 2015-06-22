<?PHP
function getRSS($url)
{
	$fd = fopen ($url, "r");
	while (!feof ($fd))
	{
		$buffer .= fgets($fd, 4096);
	}
	fclose ($fd);
	return $buffer;
}

function GetHTMLContent($strTag , $content)
{
	$qur =sprintf("/\<%s[^>]*\>(.+?)\<\/%s\>/is", $strTag,$strTag);
	preg_match($qur,  $content , $match);
	return $match[1];
}

function tagListData($strTag, $content)
{
	$reg =  sprintf("/\<%s[^>]*\>(.+?)\<\/%s\>/is" , $strTag, $strTag) ;
	preg_match_all($reg , $content, $matches , PREG_PATTERN_ORDER );
	return $matches[1];
}

// 현제 페이지의 파일명을 반환
function getFileName() {
	$arr = explode("/",$_SERVER['PHP_SELF']);
	$filename = $arr[count($arr)-1];
	return $filename;
}

//브라우저 체크
function getBrowser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";
 
    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) { $platform = 'linux'; }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) { $platform = 'mac'; }
    elseif (preg_match('/windows|win32/i', $u_agent)) { $platform = 'windows'; }
     
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) { $bname = 'Internet Explorer'; $ub = "MSIE"; } 
	elseif(preg_match('/Trident/i',$u_agent)) { $bname = 'Internet Explorer'; $ub = "rv"; } 
    elseif(preg_match('/Firefox/i',$u_agent)) { $bname = 'Mozilla Firefox'; $ub = "Firefox"; } 
    elseif(preg_match('/Chrome/i',$u_agent)) { $bname = 'Google Chrome'; $ub = "Chrome"; } 
    elseif(preg_match('/Safari/i',$u_agent)) { $bname = 'Apple Safari'; $ub = "Safari"; } 
    elseif(preg_match('/Opera/i',$u_agent)) { $bname = 'Opera'; $ub = "Opera"; } 
    elseif(preg_match('/Netscape/i',$u_agent)) { $bname = 'Netscape'; $ub = "Netscape"; } 
     
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known).')([/ ]|:)?(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
     
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){ $version= $matches['version'][0]; }
        else { $version= $matches['version'][1]; }
    }
    else { $version= $matches['version'][0]; }
     
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
    return array('userAgent'=>$u_agent, 'name'=>$bname, 'version'=>$version, 'platform'=>$platform, 'pattern'=>$pattern);
}


// 해당 경로의 디렉터리를 배열로 반환
function getSearchDir($dir) {
	$dh = opendir($dir);
	while (($file = readdir($dh)) !== false) {
		if(strpos($file,'.') === false) {
			$arr[$file] = $file;
		}
	}
	return  $arr;
}

// 배열을 받아 옵션을 만든다 같은값이 있으면 셀렉트
function getSelectOption($arr, $value='') {
	if (!is_array($arr)) return;
	$opt = "";
	foreach ($arr as $k => $v) {
		if ($k == $value) {
			$opt .= "<option value=\"$k\" selected=\"selected\">$v</option>";
		} else {
			$opt .= "<option value=\"$k\">$v</option>";
		}
	}
	return $opt;
}

// 배열을 받아 옵션을 만든다 같은값이 있으면 셀렉트 값 => 값형태
function getSelectOption_value($arr, $value='') {
	$opt = "";
	if (!is_array($arr)) return;
	foreach ($arr as $v) {
		if ($v == $value) {
			$opt .= "<option value=\"$v\" selected=\"selected\">$v</option>";
		} else {
			$opt .= "<option value=\"$v\">$v</option>";
		}
	}
	return $opt;
}

// 게시판을 권한 레벨 셀렉트 옵션 값이 같으면 셀렉트	
function getLevelOption($value=''){
	$opt='';
	for ($i=1; $i<=10; $i++) {
		if ($i == $value) {
			$opt .= "<option value=\"$i\" selected=\"selected\">$i</option>";
		} else {
			$opt .= "<option value=\"$i\">$i</option>";
		}
	}
	return $opt;
}
function getMemberLevelOption($value=''){
	$opt='';
	for ($i=1; $i<10; $i++) {
		if ($i == $value) {
			$opt .= "<option value=\"$i\" selected=\"selected\">$i</option>";
		} else {
			$opt .= "<option value=\"$i\">$i</option>";
		}
	}
	return $opt;
}

function getUserStatusOption($value='') {
	global $USER_STATUS;
	$opt='';
	foreach ($USER_STATUS as $key => $val) {
		if ($key == $value) {
			$opt .= "<option value=\"$key\" selected=\"selected\">$val</option>";
		} else {
			$opt .= "<option value=\"$key\">$val</option>";
		}
	}
	return $opt;
}

function getUserTypeOption($value='') {
	global $USER_TYPE;
	$opt='';
	foreach ($USER_TYPE as $key => $val) {
		if ($key == $value) {
			$opt .= "<option value=\"$key\" selected=\"selected\">$val</option>";
		} else {
			$opt .= "<option value=\"$key\">$val</option>";
		}
	}
	return $opt;
}

function goBack($msg) {
	echo '
	<script type="text/javascript">
		alert("'.$msg.'");
		history.go(-1);	
	</script>';
}
function goMsg($url, $msg) {
	echo '
	<script type="text/javascript">
		alert("'.$msg.'");
		location.href="'.$url.'";
	</script>';
}

// 여러 파일을 배열로 받아 업로드 시키고 DB에 추가한다.
function filesUpload($files, $board_id) {
	global $db_conn, $default_db, $BOARD_CONFIG, $board_upload_dir, $table;
	$len = count($files['name']);
	for($i=0; $i<$len; $i++) {
		if (!empty($files['name'][$i])) {
			if ($files['error'][$i] > 0) {
				$msg = 'error : No.' . $files['error'][$i] . '\n\n' .  $files['name'][$i] . '\n\n';
				switch ($files['error'][$i]) {
					case '1':
					case '2':
						$msg .= '파일용량이 큽니다.';
						break;
					case '3':
					case '4':
						$msg .= '파일 전송이 실패하였습니다.';
					default :
						$msg .= '파일 쓰기에 실패하였습니다.';
						break;
				}
				goBack($msg);
				return false;
			}
		
			if ($files['error'][$i] == 0) {
				$upfile_ext = substr(strrchr($files['name'][$i],'.'),1);
				if(eregi("php|cgi|exe|jsp|asp|aspx", $upfile_ext)) {
					$msg = $files['name'][$i].'\n\n파일은 업로드하실 수 없습니다.';
					return $msg;
				}
			}
			if (strlen($files['name'][$i]) > 150) {
				$msg = $files['name'][$i].'\n\n파일 이름이 너무 깊니다.';
				return $msg;
			}
			
			$sPath = $board_upload_dir.$BOARD_CONFIG['sTablePrefix'].'_'.$BOARD_CONFIG['sTableName'];
			$tPath = $sPath.'/thumb';
			
			$sFile = $files['name'][$i];
			$sCopy = md5($files['name'][$i].microtime()).'.'.$upfile_ext;
			$sFileType = $files['type'][$i];
			$iFileSize = $files['size'][$i];
			
			if (!move_uploaded_file($files['tmp_name'][$i], $sPath.'/'.$sCopy)){
				$msg = $sFile.'\n\n 파일 업로드에 실패하였습니다.';
				return $msg;
			}
			// 썸네일 이미지 생성
			if ($BOARD_CONFIG['iUseThumbNail'] && eregi("gif|png|jpg",$upfile_ext)) {
				create_thumbnail($sPath, $tPath, $sCopy, $BOARD_CONFIG['iThumb_w'], $BOARD_CONFIG['iThumb_h']);
			}
			$sPath = str_replace('.','',$sPath);
			$FISQL = "
				INSERT INTO `board_file` SET
					board_config_id = '". $BOARD_CONFIG['id'] ."',
					board_id = '". $board_id ."',
					sPath = '". $sPath ."',
					sFile = '". $sFile ."',
					sCopy = '". $sCopy ."',
					iDownload = '0',
					sFileType = '". $sFileType ."',
					iFileSize = '". $iFileSize ."',
					dInDate = NOW()
			";
			$FIRES = $db_conn -> sql($default_db, $FISQL);
		}
	}
	$msg = '파일이 모두 업로드에 성공하였습니다.';
	return $msg;
}

//연곤배열을 받아 매치되는 옵션을 셀렉트 하여 옵션을 반환
function getSelectboxOption($arr, $match) {
	$returnVal = "";
	foreach($arr as $key => $val) {
		if ($key == $match) {
			$selected = 'selected="selected"';
		} else {
			$selected = '';
		}
		$returnVal .= "<option value=\"". $key ."\" ".$selected .">". $val ."</option>";
	}
	return $returnVal;
}
// 파일 사이즈를 받아 구분지어 반환 
function getFileSize($size) {
	if ($size < 1024) {
		$suffix = "bytes";
	} else if (($size = $size/1024) < 1024) {
		$size = (round($size*100))/100;
		$suffix = "Kb";
	} else {
		$size = $size/1024;
		$size = (round($size*100))/100;
		$suffix = "Mb";
	}
	return $size.$suffix;
}

function goBackScript($title, $msg) {
	echo '
	<script type="text/javascript">
		$(document).ready(function(e) {
			goBackMsg("'. $title .'","'. $msg .'");
		});
	</script>';
}
// 파일 아이디를 배열로 받아 삭제 후 DB삭제
function delete_files($delfile) {
	global $db_conn, $default_db, $board_config_id, $board_id, $root;
	
	$delfile_ids = array_for_sql_IN($delfile);
	$SFSQL = "SELECT sPath, sCopy FROM `board_file` WHERE id IN(". $delfile_ids .")";
	$SFRES = $db_conn -> sql($default_db, $SFSQL);
	while(list($sPath, $sCopy) = mysql_fetch_row($SFRES)) {
		$filename= $root.$sPath.'/'.$sCopy;
		$thumbname =  $root.$sPath.'/thumb/'.$sCopy;
		@unlink($filename);
		@unlink($thumbname);
	}
	$DFSQL = "DELETE FROM `board_file` WHERE id IN(". $delfile_ids .")";
	$DFRES = $db_conn -> sql($default_db, $DFSQL);
}

// sql 쿼리 IN 절에 사용할 배열을 받아 아디,아디,아디 식으로 반환
function array_for_sql_IN($arr) {
	$returnVal = "";
	foreach ($arr as $val) {
		$returnVal .= $comma.$val;
		$comma = ',';
	}
	return $returnVal;
}

// 게시물 개별 삭제
function board_item_delete($board_id) {
	global $db_conn, $default_db, $board_config_id, $table;
	// 먼저 파일지울것이 있는가 보자
	$FCSQL = "SELECT COUNT(id) FROM `board_file` WHERE board_config_id='".$board_config_id."' AND board_id='".$board_id."'";
	$FCRES = $db_conn -> sql($default_db, $FCSQL);
	list($fileCount) = mysql_fetch_row($FCRES);
	
	if ($fileCount) { // 파일 있으면 삭제
		$FSSQL = "SELECT id FROM `board_file` WHERE board_config_id='".$board_config_id."' AND board_id='".$board_id."'";
		$FSRES = $db_conn -> sql($default_db, $FSSQL);
		$i=0;
		while($FSROW = mysql_fetch_row($FSRES)) {
			$delfile[$i++]= $FSROW[0];
		}
		delete_files($delfile);
	}
	// 관련 덧글 삭제
	$DRSQL = "DELETE FROM `board_reply` WHERE board_config_id='".$board_config_id."' AND board_id='".$board_id."'";
	$DRRES = $db_conn -> sql($default_db, $DRSQL);
	
	$DSQL = "DELETE FROM ". $table ." WHERE id='".$board_id."'";
	$DRES = $db_conn -> sql($default_db, $DSQL);
	if ($DRES) {
		return true;
	} else {
		return false;
	}
}

//특정 명을 배열로 받아 제거 예 $str, array('iframe','script')
function strip_tag_arrays($str, $strip_tags) {
	$len = count($strip_tags);
	for ($i=0; $i< $len; $i++) {
		$null[$i] = '';
		$regEx[$i] = "/<".$strip_tags[$i]."[^>]*>.*<\/".$strip_tags[$i].">/i";
	}
	$str = preg_replace($regEx, $null, $str);
	return $str;
}
// 년도를 셀렉트 옵션으로 반환한다. 
function getYearOption($select=0) {
	$y = date('Y');
	$returnVal = '';
	for($i=0; $i<100; $i++) {
		$selected = '';
		$year = $y-$i;
		if ($year == $select) {
			$selected = 'selected="selected"';
		}
		$returnVal .= '<option value="'. $year .'" '.$selected.'>'. $year .'</option>';
	}
	return $returnVal;
}
// 달을 셀렉트 옵션으로 반환한다.
function getMonthOption($select=0) {
	$returnVal = '';
	for($i=1; $i<=12; $i++) {
		$selected = '';
		if($i == $select) {
			$selected = 'selected="selected"';
		}
		$returnVal .= '<option value="'. $i .'" '.$selected.'>'. $i .'</option>';
	}
	return $returnVal;
}
// 날을 셀렉트 옵션으로 반환한다.
function getDayOption($select=0) {
	$returnVal = '';
	for($i=1; $i<=31; $i++) {
		$selected = '';
		if($i == $select) {
			$selected = 'selected="selected"';
		}
		$returnVal .= '<option value="'. $i .'" '.$selected.'>'. $i .'</option>';
	}
	return $returnVal;
}
// 배열을 받아 사이트맵 형식 반환
function getSiteMap($SiteMapArr) {	
	global $MEMBER;
	$i=0;
	$SiteMap = "";
	foreach ($SiteMapArr as $iParent => $ca) {
		if($i%5 == 0) {
			$SiteMap .="<div style=\"clear:both; height:20px;\"></div>";
		}
		$SiteMap .= "<ul>\n";
		$SiteMap .= "<li>\n";
		if ($ca['iHLevel'] >= $MEMBER['iHLevel']) {
			$SiteMap .= "	<a href=\"". $ca['catogoryUrl']."\">".$ca['category']."</a>\n";
			$SiteMap .= "	<ul>\n";
			foreach($ca['sub'] as $iSort => $me ) {
				
				$SiteMap .= "<li>";
				$SiteMap .= "<a href=\"". $me['MenuUrl']."\">". $me['MenuName']."</a>\n";
				$SiteMap .= "</li>";
			}
			$SiteMap .= "</ul>\n";
			$SiteMap .= "</li>\n";
			
		} else {
			$SiteMap .= "	<a href=\"MemberJoin\" class=\"dialog_open\">로그인</a>\n";
		}
		$SiteMap .= "</ul>\n";
		$i++;
	}
	return $SiteMap;
}
// 홈페이지 설정을 가지고 온다.
function getSiteConfig() {
	global $db_conn, $default_db;
	
	$HSQL = "SELECT * FROM `home_config`";
	$HRES = $db_conn -> sql($default_db, $HSQL);
	$config = mysql_fetch_assoc($HRES);
	return $config;
}
// 회원 마지막 로그인 기록을 반환한다;
function userLoginDiffTime($logTime) {
//	$logTime = "2014-12-29 11:34:00";
	$diff_time = strtotime($logTime);
	$diff = time() - $diff_time;
	$day = 86400;
	$hour = 3600;
	$min = 60;
	if ($diff > $day) {
		$count = floor($diff / $day);
		if ($count > 365) {
			$returnVal = '<span style="color:#ccc;"><span class="blind">e</span> 1년이상</span>';
		} else {
			$returnVal = '<span class="blind">d</span>'. $count."일 전";
		}
	} else if ($diff > $hour) {
		$count = floor($diff / $hour);
		$returnVal = '<span class="blind">c</span>'. $count."시간 전";
	} else {
		$count = floor($diff / $min);
		$returnVal = '<span class="blind">b</span>'. $count."분 전";
	}
	return $returnVal;
}

// 최근 게시물 가져오기
function getBoardLatest($board_config_id, $count, $class='') {
	global $db_conn, $default_db, $path;
	
	$BCSQL = "
		SELECT c.sTablePrefix, c.sTableName, c.iUseCategory, c.sCategoryList, s.sMenuName, s.sMenuUrl FROM `board_config` c 
		INNER JOIN `sitemenu` s ON c.id = s.board_config_id
		WHERE c.id='".$board_config_id."'
	";
	$BCRES = $db_conn -> sql($default_db, $BCSQL);
	list ($sTablePrefix, $sTableName, $iUseCategory, $sCategoryList, $sMenuName, $sMenuUrl) = mysql_fetch_row($BCRES);
	$table = $sTablePrefix."_".$sTableName;
	
	if($iUseCategory) {
		$Category = explode('|', $sCategoryList);
	}
	
	$LSQL = "SELECT id, sTitle, iCategory, DATE_FORMAT(dInDate, '%Y-%m-%d') FROM ".$table." ORDER BY iOrder DESC LIMIT ".$count;
	$LRES = $db_conn -> sql($default_db, $LSQL);
		
	$returnVal = "<li class=\"". $class ."\"><a href=\"#\"><span>".$sMenuName."</span></a>\n";
	$returnVal .= "<ul>";
	while(list($board_id, $sTitle, $iCategory, $dInDate) = mysql_fetch_row($LRES)) {
		if($iUseCategory) {
			$ca = '[' . $Category[$iCategory] .'] ';
		}
		
		$returnVal .= "<li><a href=\"".$path.$sMenuUrl."?mode=R&id=".$board_id."\" style=\"overflow: hidden; white-space: nowrap; width: 290px; display: block; text-overflow: ellipsis;\" class=\"sendpost\">".$ca.$sTitle."</a><span class=\"side\">". $dInDate ."</span></li>";
	}
	$returnVal .= "<li class=\"more\"><a href=\"".$path.$sMenuUrl."\">더보기 <span>▶</span></a></li>";
	$returnVal .= "</ul>";
	$returnVal .= "</li>";
	return $returnVal;

}

/*SMS 발송*/
function sendsms($sd) {
	global $HOME_CONFIG;
	$sms_url = $HOME_CONFIG['sms_url']; // 전송요청 URL
	// $sms_url = "https://sslsms.cafe24.com/sms_sender.php"; // HTTPS 전송요청 URL
	$sms['user_id'] = base64_encode($HOME_CONFIG['sms_user_id']); //SMS 아이디.
	$sms['secure'] = base64_encode($HOME_CONFIG['sms_secure']) ;//인증키
	$sms['msg'] = base64_encode(stripslashes($sd['msg']));
	if (empty($sd['rphone'])) { // 이름변경 단체발송시. 010-0000-0000|홍길동,010-0000-0000|김영희
		$sms['rphone'] = base64_encode($sd['rphone']);
		$sms['destination'] = urlencode(base64_encode($sd['destination']));
	} else { // 
		$sms['rphone'] = base64_encode($sd['rphone']);
	}
	$sp_arr = explode("-",$HOME_CONFIG['sms_sphone']);
	$sms['sphone1'] = base64_encode($sp_arr[0]);
    $sms['sphone2'] = base64_encode($sp_arr[1]);
    $sms['sphone3'] = base64_encode($sp_arr[2]);
	$sms['mode'] = base64_encode("1");
	$sms['testflag'] = 'Y'; // 테스트시 Y
	
	// 문자발송
	$host_info = explode("/", $sms_url);
    $host = $host_info[2];
    $path = $host_info[3]."/".$host_info[4];

    srand((double)microtime()*1000000);
    $boundary = "---------------------".substr(md5(rand(0,32000)),0,10);
    //print_r($sms);

    // 헤더 생성
    $header = "POST /".$path ." HTTP/1.0\r\n";
    $header .= "Host: ".$host."\r\n";
    $header .= "Content-type: multipart/form-data, boundary=".$boundary."\r\n";

    // 본문 생성
    foreach($sms AS $index => $value){
        $data .="--$boundary\r\n";
        $data .= "Content-Disposition: form-data; name=\"".$index."\"\r\n";
        $data .= "\r\n".$value."\r\n";
        $data .="--$boundary\r\n";
    }
    $header .= "Content-length: " . strlen($data) . "\r\n\r\n";

    $fp = fsockopen($host, 80);

    if ($fp) { 
        fputs($fp, $header.$data);
        $rsp = '';
        while(!feof($fp)) { 
            $rsp .= fgets($fp,8192); 
        }
        fclose($fp);
        $msg = explode("\r\n\r\n",trim($rsp));
        $rMsg = explode(",", $msg[1]);
        $Result['result']= $rMsg[0]; //발송결과
        $Result['count']= $rMsg[1]; //잔여건수
    } else {
        $Result = "failed";
    }
	return $Result;
}
// SMS 잔여건수 조회
function countsms() {
	global $HOME_CONFIG;
//	$sms_url = $HOME_CONFIG['sms_url']; // 전송요청 URL
	$sms_url = "http://sslsms.cafe24.com/sms_remain.php"; // SMS 잔여건수 요청 URL
	$sms['user_id'] = base64_encode($HOME_CONFIG['sms_user_id']); //SMS 아이디.
	$sms['secure'] = base64_encode($HOME_CONFIG['sms_secure']) ;//인증키
	$sms['mode'] = base64_encode("1");
	
	$host_info = explode("/", $sms_url);
	$host = $host_info[2];
	$path = $host_info[3]."/".$host_info[4];
	srand((double)microtime()*1000000);
	$boundary = "---------------------".substr(md5(rand(0,32000)),0,10);
	
	// 헤더 생성
	$header = "POST /".$path ." HTTP/1.0\r\n";
	$header .= "Host: ".$host."\r\n";
	$header .= "Content-type: multipart/form-data, boundary=".$boundary."\r\n";
	
	// 본문 생성
	foreach($sms AS $index => $value){
		$data .="--$boundary\r\n";
		$data .= "Content-Disposition: form-data; name=\"".$index."\"\r\n";
		$data .= "\r\n".$value."\r\n";
		$data .="--$boundary\r\n";
	}
	$header .= "Content-length: " . strlen($data) . "\r\n\r\n";
	
	$fp = fsockopen($host, 80);
	
	if ($fp) {
		fputs($fp, $header.$data);
		$rsp = '';
		while(!feof($fp)) {
			$rsp .= fgets($fp,8192);
		}
		fclose($fp);
		$msg = explode("\r\n\r\n",trim($rsp));
		$Result['count'] = $msg[1]; //잔여건수
		$Result['conn'] = 'Y';
	} else {
		$Result['conn'] = 'N';
	}
	return $Result;
}

// 한자리 숫자는 자리로 반환
function getTowDigit($val) {
	if ($val <10) {
		$val = '0'.$val;
	}
	return $val;
}
// 애니메이션 gif 인지 검사
function is_animated_gif($filename) {
    if(!($fh = @fopen($filename, 'rb')))
        return false;
    $count = 0;
    while(!feof($fh) && $count < 2) {
        $chunk = fread($fh, 1024 * 100); //read 100kb at a time
        $count += preg_match_all('#\x00\x21\xF9\x04.{4}\x00(\x2C|\x21)#s', $chunk, $matches);
   }

    fclose($fh);
    return $count > 1;
}
// 이미지 샤픈 적용 ( 80 , 0.5 3)
function UnsharpMask($img, $amount, $radius, $threshold)    {
    // Attempt to calibrate the parameters to Photoshop:
    if ($amount > 500)    $amount = 500;
    $amount = $amount * 0.016;
    if ($radius > 50)    $radius = 50;
    $radius = $radius * 2;
    if ($threshold > 255)    $threshold = 255;

    $radius = abs(round($radius));     // Only integers make sense.
    if ($radius == 0) {
        return $img; imagedestroy($img); break;        }
    $w = imagesx($img); $h = imagesy($img);
    $imgCanvas = imagecreatetruecolor($w, $h);
    $imgBlur = imagecreatetruecolor($w, $h);


    // Gaussian blur matrix:
    //
    //    1    2    1
    //    2    4    2
    //    1    2    1
    //
    //////////////////////////////////////////////////


    if (function_exists('imageconvolution')) { // PHP >= 5.1
            $matrix = array(
            array( 1, 2, 1 ),
            array( 2, 4, 2 ),
            array( 1, 2, 1 )
        );
        $divisor = array_sum(array_map('array_sum', $matrix));
        $offset = 0;

        imagecopy ($imgBlur, $img, 0, 0, 0, 0, $w, $h);
        imageconvolution($imgBlur, $matrix, $divisor, $offset);
    }
    else {

    // Move copies of the image around one pixel at the time and merge them with weight
    // according to the matrix. The same matrix is simply repeated for higher radii.
        for ($i = 0; $i < $radius; $i++)    {
            imagecopy ($imgBlur, $img, 0, 0, 1, 0, $w - 1, $h); // left
            imagecopymerge ($imgBlur, $img, 1, 0, 0, 0, $w, $h, 50); // right
            imagecopymerge ($imgBlur, $img, 0, 0, 0, 0, $w, $h, 50); // center
            imagecopy ($imgCanvas, $imgBlur, 0, 0, 0, 0, $w, $h);

            imagecopymerge ($imgBlur, $imgCanvas, 0, 0, 0, 1, $w, $h - 1, 33.33333 ); // up
            imagecopymerge ($imgBlur, $imgCanvas, 0, 1, 0, 0, $w, $h, 25); // down
        }
    }

    if($threshold>0){
        // Calculate the difference between the blurred pixels and the original
        // and set the pixels
        for ($x = 0; $x < $w-1; $x++)    { // each row
            for ($y = 0; $y < $h; $y++)    { // each pixel

                $rgbOrig = ImageColorAt($img, $x, $y);
                $rOrig = (($rgbOrig >> 16) & 0xFF);
                $gOrig = (($rgbOrig >> 8) & 0xFF);
                $bOrig = ($rgbOrig & 0xFF);

                $rgbBlur = ImageColorAt($imgBlur, $x, $y);

                $rBlur = (($rgbBlur >> 16) & 0xFF);
                $gBlur = (($rgbBlur >> 8) & 0xFF);
                $bBlur = ($rgbBlur & 0xFF);

                // When the masked pixels differ less from the original
                // than the threshold specifies, they are set to their original value.
                $rNew = (abs($rOrig - $rBlur) >= $threshold)
                    ? max(0, min(255, ($amount * ($rOrig - $rBlur)) + $rOrig))
                    : $rOrig;
                $gNew = (abs($gOrig - $gBlur) >= $threshold)
                    ? max(0, min(255, ($amount * ($gOrig - $gBlur)) + $gOrig))
                    : $gOrig;
                $bNew = (abs($bOrig - $bBlur) >= $threshold)
                    ? max(0, min(255, ($amount * ($bOrig - $bBlur)) + $bOrig))
                    : $bOrig;



                if (($rOrig != $rNew) || ($gOrig != $gNew) || ($bOrig != $bNew)) {
                        $pixCol = ImageColorAllocate($img, $rNew, $gNew, $bNew);
                        ImageSetPixel($img, $x, $y, $pixCol);
                    }
            }
        }
    }
    else{
        for ($x = 0; $x < $w; $x++)    { // each row
            for ($y = 0; $y < $h; $y++)    { // each pixel
                $rgbOrig = ImageColorAt($img, $x, $y);
                $rOrig = (($rgbOrig >> 16) & 0xFF);
                $gOrig = (($rgbOrig >> 8) & 0xFF);
                $bOrig = ($rgbOrig & 0xFF);

                $rgbBlur = ImageColorAt($imgBlur, $x, $y);

                $rBlur = (($rgbBlur >> 16) & 0xFF);
                $gBlur = (($rgbBlur >> 8) & 0xFF);
                $bBlur = ($rgbBlur & 0xFF);

                $rNew = ($amount * ($rOrig - $rBlur)) + $rOrig;
                    if($rNew>255){$rNew=255;}
                    elseif($rNew<0){$rNew=0;}
                $gNew = ($amount * ($gOrig - $gBlur)) + $gOrig;
                    if($gNew>255){$gNew=255;}
                    elseif($gNew<0){$gNew=0;}
                $bNew = ($amount * ($bOrig - $bBlur)) + $bOrig;
                    if($bNew>255){$bNew=255;}
                    elseif($bNew<0){$bNew=0;}
                $rgbNew = ($rNew << 16) + ($gNew <<8) + $bNew;
                    ImageSetPixel($img, $x, $y, $rgbNew);
            }
        }
    }
    imagedestroy($imgCanvas);
    imagedestroy($imgBlur);
    return true;
}

function create_thumbnail($sourceDir, $thumbDir, $filename, $width="", $height="", $quality="80") {
	$file = $sourceDir."/".$filename;
	$ext = strtolower(substr(strrchr($file,"."),1));
	switch ($ext) {
		case 'jpg':
			$src_img = imagecreatefromjpeg($file); 
			break;
		case 'gif':
			if (is_animated_gif($file)) {
				copy ($file, $thumbDir."/".$filename);
				return;
			} else {
				$src_img = imagecreatefromgif($file); 
				$src_transparency = imagecolortransparent($src_img);
			}
			break;
		case 'png':
			$src_img = imagecreatefrompng($file);
			imagealphablending($src_img, true); 
			break;
	}
	
	$sx = imagesx($src_img);
	$sy = imagesy($src_img);
	if ($sx > $width || $sy > $height) {
		if ($sx>$sy) {
			$targ_X = $width;
			$targ_Y = ceil(($sy*$width)/$sx);
		} else {
			$targ_X = ceil(($sx*$height)/$sy);
			$targ_Y = $height;
		}
		$is_resize = true;
	} else {
		$targ_X = $sx;
		$targ_Y = $sy;
		$is_resize = false;
	}
	$dst_img=imagecreatetruecolor($targ_X,$targ_Y); //결과물 이미지 생성 
	
	// 투명값 처리
	switch ($ext) {
		case 'gif':
			if ($src_transparency != -1) {
				$transparent_color   = @imagecolorsforindex($src_img, $src_transparency);
				$current_transparent = @imagecolorallocate($dst_img, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']); 
	            imagefill($dst_img, 0, 0, $current_transparent); 
		        imagecolortransparent($dst_img, $current_transparent); 
			}
			break;
		case 'png':
			 imagealphablending($dst_img, false);
			 imagesavealpha($dst_img, true);
			break;
	}
	imagecopyresampled($dst_img,$src_img,0,0,0,0,$targ_X,$targ_Y,$sx,$sy); //만들기
	// 샤픈 적용
	if($is_resize) {
		UnsharpMask($dst_img,80,0.5,3);
	}

	$ext = strtolower(substr(strrchr($filename,"."),1));
	switch ($ext) {
		case 'jpg':
			imagejpeg($dst_img, $thumbDir."/".$filename, $quality); 
			break;
		case 'gif':
			imagegif($dst_img, $thumbDir."/".$filename); 
			break;
		case 'png':
			imagepng($dst_img, $thumbDir."/".$filename); 
			break;
	}
	// 메모리 해제
	imagedestroy($src_img);
	imagedestroy($dst_img);	
}

function filesUpload_cooperative($file, $eType, $id) {
	global $db_conn, $default_db, $board_upload_dir;
	
	$current_time = time();
	$time_info  = getdate($current_time);
	$date_filedir   = $time_info["year"].getTowDigit($time_info["mon"]).getTowDigit($time_info["mday"]).getTowDigit($time_info["hours"]).getTowDigit($time_info["minutes"]).getTowDigit($time_info["seconds"]);
	
	$uploadpath  = $board_upload_dir.'cooperative';
	
	switch ($eType) {
		case 'P' :
			$w = 426;
			$h = 283;
			$t_w = 73;
			$t_h = 48;
			
			$len = count($file['name']);
			for ($i=0; $i<$len; $i++) {
				if ($file['error'][$i] == 0) {
					$ext = strtolower(substr(strrchr($file["name"][$i],"."),1));
					$savefilename = strtolower($date_filedir."_upload_image_".$eType.$i.".".$ext);
					if(move_uploaded_file($file['tmp_name'][$i],$uploadpath."/".$savefilename)){
						create_thumbnail($uploadpath,$uploadpath."/thumb",$savefilename,$t_w,$t_h);
						create_thumbnail($uploadpath,$uploadpath,$savefilename,$w,$h);
						$ISQL = "
							INSERT INTO `cooperative_firm_files` SET
								cooperative_id = '".$id."',
								eType = '".$eType."',
								sPath = '".str_replace("../..",'',$uploadpath)."',
								sFile = '".$savefilename."'
						";
						$IRES = $db_conn -> sql($default_db, $ISQL);
					}
				}
			}
			break;
		default :
			//오리지널 파일 이름.확장자
			$ext = strtolower(substr(strrchr($file["name"],"."),1));
			$savefilename = strtolower($date_filedir."_upload_image_".$eType.".".$ext);
			
			
			//php 파일업로드하는 부분
			if(move_uploaded_file($file['tmp_name'],$uploadpath."/".$savefilename)){
				$ISQL = "
					INSERT INTO `cooperative_firm_files` SET
						cooperative_id = '".$id."',
						eType = '".$eType."',
						sPath = '".str_replace("../..",'',$uploadpath)."',
						sFile = '".$savefilename."'
				";
				$IRES = $db_conn -> sql($default_db, $ISQL);
			}
			break;
	}
	
}

function delete_files_cooperative($delfile) {
	global $db_conn, $default_db, $root;
	
	$delfile_ids = array_for_sql_IN($delfile);
	$SFSQL = "SELECT sPath, sFile FROM `cooperative_firm_files` WHERE id IN(". $delfile_ids .")";
	$SFRES = $db_conn -> sql($default_db, $SFSQL);
	while(list($sPath, $sFile) = mysql_fetch_row($SFRES)) {
		$filename= $root.$sPath.'/'.$sFile;
		$thumbname =  $root.$sPath.'/thumb/'.$sFile;
		@unlink($filename);
		@unlink($thumbname);
	}
	$DFSQL = "DELETE FROM `cooperative_firm_files` WHERE id IN(". $delfile_ids .")";
	$DFRES = $db_conn -> sql($default_db, $DFSQL);
}

function has_new($board_config_id) {
	global $db_conn, $default_db;
	
	$BSQL = "SELECT sTablePrefix, sTableName FROM `board_config` WHERE id='".$board_config_id."'";
	$BRES = $db_conn -> sql($default_db, $BSQL);
	list($sTablePrefix, $sTableName) = mysql_fetch_row($BRES);
	$table = $sTablePrefix .'_'. $sTableName;
	
	$CSQL = "SELECT DATEDIFF(dInDate, NOW()) FROM ".$table." ORDER BY dInDate DESC LIMIT 1";
	$CRES = $db_conn -> sql($default_db, $CSQL);
	list($diff) = mysql_fetch_row($CRES);
	
	if ($diff > -8) {
		$new = "<span class=\"new\"></span>";
	}
	return $new;
}

// 세미나 신청 SMS보내기
function seminar_send_sms($id) {
	global $db_conn, $default_db, $HOME_CONFIG;
	$MSSQL = "
			SELECT w.board_table, w.board_id, u.sUserName, u.sHphone FROM `board_user_wishlist` w
			INNER JOIN `users` u ON w.user_id = u.id
			WHERE w.id='".$id."'
	";
	$MSRES = $db_conn -> sql($default_db, $MSSQL);
	list($table, $board_id, $sUserName, $sHphone) = mysql_fetch_row($MSRES);
	
	$MSQL = "
		SELECT sSMS FROM ".$table." WHERE id='".$board_id."'
	";
	$MRES =$db_conn -> sql($default_db, $MSQL);
	list($sSMS) = mysql_fetch_row($MRES);
	
	$sd['msg'] = str_replace('{name}',$sUserName, $sSMS);
	$sd['msg'] = str_replace('{HOMETITLE}', $HOME_CONFIG['HomeTitle'], $sd['msg']);
	$sd['rphone'] = $sHphone;
	$s =  sendsms($sd);
	$s['msg'] = $sd['msg'];
	$s['rphone'] = $sd['rphone'];
	return $s;
}
?>