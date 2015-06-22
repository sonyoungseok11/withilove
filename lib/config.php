<?PHP
	$b = new Board;
	
	$HOME_CONFIG = getSiteConfig();
	$MEMBER = $db_conn -> LoginInfoDecode($_COOKIE[md5('EncodeData')]);
	
	// 회원 로그 ajax call
	if ($MEMBER['id']) {
		$member_login_log = "<script type=\"text/javascript\" src=\"$root/js/member_login_log.js\"></script>\n";
		$member_global_script = '
			var g_MEMBER = new Array();
			g_MEMBER["id"] = "'.$MEMBER['id'].'";
		';
	} else {
		$MEMBER = array(
			'iHLevel' => 10,
			'iMLevel' => 10
		);
	}
	
	/* 환경 설정 */
	$script_global="
		<script type=\"text/javascript\">
			var g_root = \"$root\";
			var g_path = \"$path\";
			".$member_global_script."
		</script>
	";
	
	$board_skin_dir_root = $root."/skin/board/"; // 보드스킨 절대 경로
	
	$board_skin_dir = $path."/skin/board/"; // 보드스킨 상대 경로
	$board_editor_dir = $root."/editor/";
	$board_upload_dir = $root."/data/"; // 업로드 폴더
	$use_arr = array("0"=>"미사용","1"=>"사용"); // 게시판 사용유무 선택
	//게시판 검색 타입
	$board_search_type = array(
		"sName" => "작성자",
		"sTitle" => "제목",
		"sComment" => "내용",
		"and" => "제목and내용",
		"or" => "제목or내용"
	);
	
	$BOARD_SETUP = array(
		"NameStamp" => array(
			"all" => '모두표시',
			"part" => '일부표시'
		)
	);
	
	$USER_STATUS = array(
		"1" => "승인",
		"2" => "블럭",
		"10" => "탈퇴"
	);
	
	$USER_SEARCH_TYPE = array(
		"sUserId" => "ID", 
		"sUserName" => "이름"
	);
	$LIMITE = array("10" => "10개", "20"=>"20개","50" => "50개","100" => "100개","200" => "200개");
	
	$USER_TYPE = array(
		"M" => "관리자",
		"T" => "과금회원",
		"S" => "일반회원"
	);
	
	$USER_SET = array(
		"BusinessType" => array(
			"영어",
			"수학",
			"과학",
			"영수",
			"논술",
			"국어",
			"보습",
			"입시",
			"음악",
			"미술",
			"무용",
			"태권도",
			"검도",
			"피아노",
			"요리",
			"미용",
			"사회",
			"기타"
		)
	);
	
	$USER_ACTIVE = array(
		"all" => "접속유무",
		"on" => "접속중",
		"off" => "비접속"
	);
	
	$CONTRACT = array(
		'eLicense' => array(
			"A" => "학원",
			"S" => "교습소",
		),
		'iCounselingTime' => array(
			"AM 09:00 ~ AM 10:00",
			"AM 10:00 ~ AM 11:00",
			"AM 11:00 ~ AM 12:00",
			"AM 12:00 ~ PM 01:00",
			"PM 01:00 ~ PM 02:00",
			"PM 02:00 ~ PM 03:00",
			"PM 03:00 ~ PM 04:00",
			"PM 04:00 ~ PM 05:00",
			"PM 05:00 ~ PM 06:00",
			"PM 06:00 ~ PM 07:00",
		),
		'searchType' => array(
			"t.sName" => "학원명",
			"u.sUserId" => "ID",
			"u.sUserName" => "이름"
		),
		'iStep' => array (
			"1" => "접수중",
			"2" => "접수완료",
			"3" => "답변완료"
		)
	);
	$SUPPORTERS = array(
		'iAnswer' => array(
			'0' => '전체',
			'1' => '미답변',
			'2' => '답변완료'
		)
	);
	
	$ZONESQL = "SELECT sSido, sTable FROM `zip_zone` ORDER BY iSort";
	$ZONERES = $db_conn -> sql($default_db, $ZONESQL);
	while($zrow = mysql_fetch_assoc($ZONERES)) {
		$ZIP_ZONE[$zrow['sTable']] = $zrow['sSido'];
	}
?>