<?php
// 접근권한이 있는지 비교하여 반환
function getAccessLevel($LV) {
	global $userLevel;
	return $LV >= $userLevel ? true : false;
}

function getNameStamp($name) {
	global $BOARD_CONFIG, $userLevel;
	if ($userLevel !=1 && $name !='관리자' && $BOARD_CONFIG['eNameStamp'] == 'part' ) {
		$len = mb_strlen($name, "UTF-8")-1;
		$temp = mb_substr($name, 0, 1, "UTF-8" );
		for ($i=0; $i < $len; $i++) {
			$temp .= '*';
		}
		$name= $temp;
	} 
	return $name;
}

// basic 스킨 목록 보기
function sqlShowData_basic($QueryString, $no , $PositionArr) { 
	global $db_conn, $default_db, $skin_dir, $BOARD_CONFIG, $MEMBER, $userLevel, $page, $table; 
	$RST = $db_conn -> sql($default_db, $QueryString);
	
	$ReturnValue ="	<tbody>\n";
	while($Datas=mysql_fetch_array($RST))
	{
		$ReturnValue .="<tr>\n";
		if ($userLevel ==1) { // 관리자일경우 체크박스 표시
			$ReturnValue .="	<td class=\"$PositionArr[0]\"><input type=\"checkbox\" name=\"id[]\" value=\"".$Datas['id']."\" class=\"checkDepth".$Datas['iDepth']."\" /></td>\n";
		}
		
		$ReturnValue .="	<td class=\"$PositionArr[1]\">". $no-- ."</td>\n";
		$ReturnValue .="	<td class=\"$PositionArr[2]\">\n
								<div class=\"subject\">\n";
		// 카데고리 사용						
		if($BOARD_CONFIG['iUseCategory']) {
			$category = "[". $BOARD_CONFIG['Category'][$Datas['iCategory']] ."] ";
		}
								
		$url = $_SERVER['PHP_SELF']."?page=".$page."&mode=R&id=" . $Datas['id'];
		$href = "<a href=\"". $url ."\" class=\"sendpost\">". $category . $Datas['sTitle'] ."</a>";
		
		//비밀글 이라면 비빌글 아이콘을 표시
		if ($Datas['iSecret'] == 1) {
			$ReturnValue .="		<img src=\"". $skin_dir ."/img/icon_secret.gif\" alt=\"답글\" class=\"secret\" />\n";
			//비밀글 url 설정
			if ($userLevel != 1) { // 관리자아니면
				if ($Datas['iDepth'] == 0) {
					$secret_top_user_id = $Datas['user_id'];
					$secret_top_id  = $Datas['id'];
				}
				if ($Datas['user_id'] > 0 &&  $secret_top_user_id == $MEMBER['id'] ) { //회원글이거나 회원글 하위글
					$url .= "&source_id=" . $secret_top_id;
					$href = "<a href=\"". $url ."\" class=\"sendpost\">". $category. $Datas['sTitle'] ."</a>";
				} else {  // 회원글이 아니거나 하위글
					$href = "<a href=\"". $Datas['id'] . "," . $secret_top_id . ",". $table ."\" class=\"boardsecretview\">". $category. $Datas['sTitle']."</a>";
				}
			}
		} else {
			$secret_top_user_id='';
			$secret_top_id = '';
		}
		// 답글이라면 답글 아이콘 표시
		if($Datas['iDepth'] > 0) {
			$depth = ($Datas['iDepth']-1) * 20;
			$ReturnValue .="<span class=\"reply\" style=\"padding-left:".$depth."px;\"><img src=\"". $skin_dir . "/img/icon_reply.gif\" alt=\"답글\" /></span>";
		}
		
		$ReturnValue .=  $href; //"<a href=\"". $url ."\" class=\"sendpost\">". $Datas['sTitle'] ."</a>";
		// 파일이 있다면 파일아이콘 표시
		if ($Datas['iHaveFile'] > 0 ) {
			$ReturnValue .="<img src=\"". $skin_dir . "/img/icon_file.gif\" alt=\"파일첨부\" class=\"file\" />";
		}
				
		$ReturnValue .="		</div>\n
							</td>\n";
		$ReturnValue .="	<td class=\"$PositionArr[3]\">".getNameStamp($Datas['sName']) ."</td>\n";
		$ReturnValue .="	<td class=\"$PositionArr[4]\">".$Datas['dInDate']."</td>\n";
		$ReturnValue .="	<td class=\"$PositionArr[5]\">".$Datas['iSee'] ."</td>\n";
		$ReturnValue.="</tr>\n";
	}
	$ReturnValue.="	</tbody>\n";
	$ReturnValue.="</table>\n";
	if($userLevel == 1) {
		$ReturnValue.= "</form>";
	}
	return $ReturnValue;
}

function sqlShowData_basic_ReadList($Datas, $current_id, $PositionArr, $carr) { // 글보기 하단 리스트
	global $db_conn, $default_db, $skin_dir, $BOARD_CONFIG, $MEMBER, $userLevel, $page, $table;
	$source_id = $_POST['source_id'];
	$source_pw = $_POST['source_pw'];
	$count = count($Datas);
	$no = $count-2;
	$ReturnValue = "<table>";
	foreach ($carr as $cols ){
		$ReturnValue.="<col width=\"$cols\"/>\n";
	}
	
	$ReturnValue .="	<tbody>\n";
	
	for ($i=0; $i<$count; $i++) {
		$trClass = "";
		$secret_view = false;
		if ($i == 0 ) {
			if( is_array($Datas[$i])) {
				$trClass = "class=\"first\"";
				$secret_view = true;
			} else {
				$no--;
				continue;
			}
		}
		if ($i == ($count-1)) {
			if (is_array($Datas[$i])) {
				$trClass = "class=\"last\"";
				$secret_view = true;
			} else {
				continue;
			}
		}
		
		$ReturnValue .="<tr $trClass>\n";
		if ($i==0) {
			$td_first ="	<td class=\"$PositionArr[0]\">다음글▲</td>\n";
		} else if ($i==($count-1)) {
			$td_first ="	<td class=\"$PositionArr[0]\">이전글▼</td>\n";
		} else {
			$td_first ="	<td class=\"$PositionArr[0]\"></td>\n";
		}
		
		if ($Datas[$i]['id'] == $current_id) {
			$td_first ="	<td class=\"$PositionArr[0]\">현재글▶</td>\n";
			
		} 
		
		$ReturnValue .= $td_first;
		
		$ReturnValue .="	<td class=\"$PositionArr[1] white\">\n
								<div class=\"subject\">\n";
								
		// 카데고리 사용						
		if($BOARD_CONFIG['iUseCategory']) {
			$category = "[". $BOARD_CONFIG['Category'][$Datas[$i]['iCategory']] ."] ";
		}
		
		//비밀글 이라면 비빌글 아이콘을 표시
		
		$url = $_SERVER['PHP_SELF']."?page=".$page."&mode=R&id=" . $Datas[$i]['id'];
		$href = "<a href=\"". $url ."\" class=\"sendpost\">".$category . $Datas[$i]['sTitle'] ."</a>";
		
		if ($Datas[$i]['iSecret'] == 1) {
			$ReturnValue .="		<img src=\"". $skin_dir ."/img/icon_secret.gif\" alt=\"답글\" class=\"secret\" />\n";
			//비밀글 url 설정
			if ($secret_view) { //관련글이 아니면
				$secret_top_id  = ($Datas[$i]['iDepth'] == 0) ? $Datas[$i]['id'] : $secret_top_id;
				$href = "<a href=\"". $Datas[$i]['id'] . "," . $secret_top_id . ",". $table ."\" class=\"boardsecretview\">".$category . $Datas[$i]['sTitle'] ."</a>";
			} else { //관련글이면
				$url .= "&source_id=".$source_id."&source_pw=".$source_pw;
				$href = "<a href=\"". $url ."\" class=\"sendpost\">".$category . $Datas[$i]['sTitle'] ."</a>";
			}
		}
		
		// 답글이라면 답글 아이콘 표시
		if($Datas[$i]['iDepth'] > 0) {
			$depth = ($Datas[$i]['iDepth']-1) * 20;
			$ReturnValue .="<span class=\"reply\" style=\"padding-left:".$depth."px;\"><img src=\"". $skin_dir . "/img/icon_reply.gif\" alt=\"답글\" /></span>";
		}
		
		$ReturnValue .= $href;
		// 파일이 있다면 파일아이콘 표시
		if ($Datas[$i]['iHaveFile'] > 0 ) {
			$ReturnValue .="<img src=\"". $skin_dir . "/img/icon_file.gif\" alt=\"파일첨부\" class=\"file\" />";
		}
				
		$ReturnValue .="		</div>\n
							</td>\n";
		$ReturnValue .="	<td class=\"$PositionArr[2] white\">".getNameStamp($Datas[$i]['sName']) ."</td>\n";
		$ReturnValue .="	<td class=\"$PositionArr[3] white\">".$Datas[$i]['dInDate']."</td>\n";
		$ReturnValue .="	<td class=\"$PositionArr[4] white\">".$Datas[$i]['iSee'] ."</td>\n";
		$ReturnValue.="</tr>\n";
	}
	
	$ReturnValue.="	</tbody>\n";
	$ReturnValue.="</table>\n";
	return $ReturnValue;
}

function sqlShowData_reply_basic() { // basic 스킨 리플 목록 보기
	global $db_conn, $default_db, $board_config_id, $board_id, $MEMBER, $root;
	
	$RSQL = "SELECT * FROM `board_reply` WHERE board_config_id='".$board_config_id."' AND board_id='".$board_id."'";
	$RRES = $db_conn -> sql($default_db, $RSQL);

	$ReturnVal ="<ul>\n";
	while($Datas = mysql_fetch_array($RRES)) {
		$ReturnVal .= "<li>\n";
		$ReturnVal .= '<span class="reply_name">작성자: '. getNameStamp($Datas['sName']) .'</span> 작성일: <span class="reply_date">'.$Datas['dInDate'].'</span> IP: <span class="reply_ip">'.$Datas['sIp'].'</span>';
		$ReturnVal .= '<div class="reply_comment">'.$Datas['sComment'].'</div>';
		if($MEMBER['iHLevel'] == 1 || $MEMBER['id'] == $Datas['user_id'] ) {
			$ReturnVal .= "
				<div class=\"btn\">
					<a href=\"". $Datas['id'].",". $board_id ."\" class=\"msButton verysmall blue reply_modify\">수정</a>
					<a href=\"".$root."/board/board_proc.php?mode=reply_D&board_id=". $board_id ."&reply_id=". $Datas['id'] ."\" class=\"msButton verysmall red reply_delete sendpost\">삭제</a>
				</div>
			";
		}
	}
	$ReturnVal .="</ul>\n";
	return $ReturnVal;
}

function getWeekend ($date) {
	$week = array('일','월','화','수','목','금','토');
	$y = substr($date, 0,4);
	$m = substr($date, 5,2);
	$d = substr($date, 8,2);
	$re = $m.'/'.$d.'/'.$y;
	$to = date('w', strtotime($re));
	return  $week[$to];
}
function getPrintDate ($date) {
	$reg = "/[\d]{4}-[0]?([\d]{1,2})-[0]?([\d]{1,2})/";
	preg_match($reg, $date, $match);
	//print_r($match);
	return $match[1].'/'.$match[2].'('.getWeekend ($date).')';
}

function sqlShowData_request($QueryString, $PositionArr) { // request
	global $db_conn, $default_db, $skin_dir, $BOARD_CONFIG, $MEMBER, $userLevel, $page, $table; 
	$RST = $db_conn -> sql($default_db, $QueryString);
	
	$ReturnValue ="	<tbody>\n";
	while($Datas=mysql_fetch_array($RST))
	{
		$ReturnValue .="<tr>\n";
		if ($userLevel ==1) { // 관리자일경우 체크박스 표시
			$ReturnValue .="	<td class=\"$PositionArr[0]\"><input type=\"checkbox\" name=\"id[]\" value=\"".$Datas['id']."\" class=\"checkDepth".$Datas['iDepth']."\" /></td>\n";
		}
		//id, iOrder, iDepth, sTitle, dStartDate, dEndDate
		$print_date = "";
		$print_date .= getPrintDate($Datas['dStartDate']);
		if ($Datas['dEndDate'] != '0000-00-00') {
			$print_date .= ' ~ '. getPrintDate($Datas['dEndDate']);
		}
		
		$ReturnValue .="	<td class=\"$PositionArr[1]\">\n
								<div class=\"subject\">\n";
								
		if($BOARD_CONFIG['iUseCategory']) {
			$category = "[". $BOARD_CONFIG['Category'][$Datas['iCategory']] ."] ";
		}
								
		$url = $_SERVER['PHP_SELF']."?page=".$page."&mode=R&id=" . $Datas['id'];
		$href = "<a href=\"". $url ."\" class=\"sendpost\">".$category."<span class=\"blue\">".$print_date."</span> ". $Datas['sTitle'] ."</a>";
		
		$ReturnValue .=  $href; //"<a href=\"". $url ."\" class=\"sendpost\">". $Datas['sTitle'] ."</a>";
				
		$ReturnValue .="		</div>\n
							</td>\n";
		if ($Datas['DiffDay'] > 0) {					
			if ($MEMBER['id']) {
				$WSQL = "SELECT COUNT(id), id, eWishType FROM `board_user_wishlist` WHERE board_table='".$table."' AND board_id='".$Datas['id']."' AND user_id='".$MEMBER['id']."'";
				$WRES = $db_conn->sql($default_db, $WSQL);
				list ($WISH['count'], $WISH['id'], $WISH['type']) = mysql_fetch_row($WRES);
				if ($WISH['count']) {
					switch ($WISH['type']) {
						case 'HOBBY' :
							$ReturnValue .="	<td class=\"$PositionArr[2] hobby\"><a href=\"javascript:;\" onclick=\"Wishlist.del('".$WISH['id']."', this);\" class=\"msButton verysmall blue\">취소</a></td>\n";
							$ReturnValue .="	<td class=\"$PositionArr[3] ask\"><a href=\"javascript:;\" onclick=\"Wishlist.update('".$WISH['id']."','ASK', this);\" class=\"msButton verysmall pink\">신청</a></td>\n";
							break;
						case 'ASK' :
							$ReturnValue .="	<td class=\"$PositionArr[2] hobby\"></td>\n";
							$ReturnValue .="	<td class=\"$PositionArr[3] ask\"><a href=\"javascript:;\" onclick=\"Wishlist.del('".$WISH['id']."', this);\" class=\"msButton verysmall pink \">신청취소</a></td>\n";
							break;
					}
					
				} else {
					$ReturnValue .="	<td class=\"$PositionArr[2] hobby\"><a href=\"javascript:;\" onclick=\"Wishlist.insert('".$BOARD_CONFIG['id']."','".$table."','".$Datas['id']."','".$MEMBER['id']."','HOBBY', this);\" class=\"msButton verysmall blue\">담기</a></td>\n";
					$ReturnValue .="	<td class=\"$PositionArr[3] ask\"><a href=\"javascript:;\" onclick=\"Wishlist.insert('".$BOARD_CONFIG['id']."','".$table."','".$Datas['id']."','".$MEMBER['id']."','ASK', this);\" class=\"msButton verysmall pink\">신청</a></td>\n";
				}
				
			} else {
				$ReturnValue .="	<td class=\"$PositionArr[2] hobby\"><a href=\"javascript:;\" onclick=\"needMember();\" class=\"msButton verysmall blue\">담기</a></td>\n";
				$ReturnValue .="	<td class=\"$PositionArr[3] ask\"><a href=\"javascript:;\" onclick=\"needMember();\" class=\"msButton verysmall pink\">신청</a></td>\n";
			}
		} else {
			$ReturnValue .="	<td class=\"$PositionArr[2] hobby\"><span class=\"blue\">마감<span></td>\n";
			$ReturnValue .="	<td class=\"$PositionArr[3] ask\"><span class=\"pink\">마감</span></td>\n";
		}
		$ReturnValue.="</tr>\n";
	}
	$ReturnValue.="	</tbody>\n";
	$ReturnValue.="</table>\n";
	if($userLevel == 1) {
		$ReturnValue.= "</form>";
	}
	return $ReturnValue;
}

function sqlShowData_edu($QueryString) { // request
	global $db_conn, $default_db, $skin_dir, $BOARD_CONFIG, $MEMBER, $userLevel, $page, $table, $path, $root; 
	$RST = $db_conn -> sql($default_db, $QueryString);
	
/*
<div class="item">
		<div class="subject">위드프랭즈 비전 디자이너 과정(2014/12/17)</div>
		<div class="comment">
			<img src="../../../images/p_img1.png" />
			<p>위드 프랭즈 교육원 진로/진학/세미나 위드 프랭즈 교육원 진로/진학/세미나 위드 프랭즈 교육원 진로/진학/세미나
위드 프랭즈 교육원 진로/진학/세미나
			</p>
		</div>
	</div>
*/	
	
	
	while($Datas=mysql_fetch_array($RST))
	{
		$ReturnValue .="<div class=\"item\">\n";
		
		//b.id, b.iOrder, b.iDepth, b.iCategory ,b.sTitle, b.sPreface, b.iHavefile, f.sPath, f.sFile
				
		$print_date = "";
		$print_date .= getPrintDate($Datas['dStartDate']);
		if ($Datas['dEndDate'] != '0000-00-00') {
			$print_date .= ' ~ '. getPrintDate($Datas['dEndDate']);
		}
								
		if($BOARD_CONFIG['iUseCategory']) {
			$category = "[". $BOARD_CONFIG['Category'][$Datas['iCategory']] ."] ";
		}
		
		$url = $_SERVER['PHP_SELF']."?page=".$page."&mode=R&id=" . $Datas['id'];
		$href = "<a href=\"". $url ."\" class=\"sendpost\">".$category. $Datas['sTitle'] . " <span class=\"blue\">(".$print_date.")</span>";
		$ReturnValue .="<div class=\"subject\">". $href ."</div>";
		$ReturnValue .="<div class=\"comment\">";
		if ($Datas['iHavefile']) {
			$ReturnValue .="<img src=\"".$root .$Datas['sPath'] . "/".$Datas['sCopy']."\" alt=\"".$Datas['sTitle']."\"  width=\"330\" height=\"165\" />";
		}
		$ReturnValue .="<p>".$Datas['sPreface']."</p>"; 
		
		if ($Datas['DiffDay'] > 0) {					
			if ($MEMBER['id']) {
				$WSQL = "SELECT COUNT(id), id, eWishType FROM `board_user_wishlist` WHERE board_table='".$table."' AND board_id='".$Datas['id']."' AND user_id='".$MEMBER['id']."'";
				$WRES = $db_conn->sql($default_db, $WSQL);
				list ($WISH['count'], $WISH['id'], $WISH['type']) = mysql_fetch_row($WRES);
				if ($WISH['count']) {
					switch ($WISH['type']) {
						case 'HOBBY' :
							$ReturnValue .="	<div class=\"hobby\"></div>\n";
							$ReturnValue .="	<div class=\"ask\"><a href=\"javascript:;\" onclick=\"Wishlist.update('".$WISH['id']."','ASK', this);\" class=\"msButton verysmall pink\">세미나 신청</a></div>\n";
							break;
						case 'ASK' :
							$ReturnValue .="	<div class=\"hobby\"></div>\n";
							$ReturnValue .="	<div class=\"ask\"></div>\n";
							break;
					}
					
				} else {
					$ReturnValue .="	<div class=\"hobby\"><a href=\"javascript:;\" onclick=\"Wishlist.insert('".$BOARD_CONFIG['id']."','".$table."','".$Datas['id']."','".$MEMBER['id']."','HOBBY', this);\" class=\"msButton verysmall blue\">관심일정추가</a></div>\n";
					$ReturnValue .="	<div class=\"$PositionArr[3] ask\"><a href=\"javascript:;\" onclick=\"Wishlist.insert('".$BOARD_CONFIG['id']."','".$table."','".$Datas['id']."','".$MEMBER['id']."','ASK', this);\" class=\"msButton verysmall pink\">세미나 신청</a></div>\n";
				}
				
			} else {
				$ReturnValue .="	<div class=\"hobby\"><a href=\"javascript:;\" onclick=\"needMember();\" class=\"msButton verysmall blue\">관심일정추가</a></div>\n";
				$ReturnValue .="	<div class=\"ask\"><a href=\"javascript:;\" onclick=\"Wishlist.nomember_insert(".$Datas['id'].",this);\" class=\"msButton verysmall pink\">세미나 신청</a></div>\n";
			}
		} else {
			$ReturnValue .="	<div class=\"hobby\"></div>\n";
			$ReturnValue .="	<div class=\"ask\"></div>\n";
		}
		
		$ReturnValue .="</a>";
		
		
		$ReturnValue .="</div>";
		$ReturnValue.="</div>\n";
	}
	
	
	return $ReturnValue;
}

function sqlShowData_gallery ($QueryString) {
	global $db_conn, $default_db, $skin_dir, $BOARD_CONFIG, $MEMBER, $userLevel, $page, $table, $path; 
	$RST = $db_conn -> sql($default_db, $QueryString);
	/*
	<li>
		<a href="#">
			<div class="img" style="background-image:url(../../../images/p_img1.png)"></div>
			<div class="subject">1회 세경학 행사 사진 입니다 어쩌고 저쪼구 이러쿵 저러쿵</div>
			<div class="new"></div>
			<div class="info">Date:2015-01-14 | 조회수:257</div>
		</a>
	</li>
	*/
	$ReturnValue ="<ul>";
	while($Datas=mysql_fetch_array($RST)) {
		$url = $_SERVER['PHP_SELF']."?page=".$page."&mode=R&id=" . $Datas['id'];
		$img_url = $path. "/" .$Datas['sPath'].$Datas['sCopy'];
		$icon = "hit";
		if ($Datas['DiffDay'] > -8) {
			if ($Datas['iSee'] < 10 ) {
				$icon = "new";
			}
		}

		$ReturnValue .= "<li>";
		$ReturnValue .= "<a href=\"". $url ."\" class=\"sendpost\">";
		$ReturnValue .= "<div class=\"img\" style=\"background-image:url(".$img_url.")\"></div>";
		$ReturnValue .= "<div class=\"subject\">". $Datas['sTitle'] ."</div>";
		$ReturnValue .= "<div class=\"".$icon."\"></div>";
		$ReturnValue .= "<div class=\"info\">Date:".$Datas['dInDate']." | 조회수:".$Datas['iSee']."</div>";
		$ReturnValue .= "</a>";
		$ReturnValue .= "</li>";
	}
	$ReturnValue .="</ul>";
	return $ReturnValue;
}

function sqlShowData_gallery2 ($QueryString) {  // 썸네일 이미지 사용
	global $db_conn, $default_db, $skin_dir, $BOARD_CONFIG, $MEMBER, $userLevel, $page, $table, $path, $root; 
	$RST = $db_conn -> sql($default_db, $QueryString);
	/*
	<li>
		<a href="#">
			<div class="img" style="background-image:url(../../../images/p_img1.png)"></div>
			<div class="subject">1회 세경학 행사 사진 입니다 어쩌고 저쪼구 이러쿵 저러쿵</div>
			<div class="new"></div>
			<div class="info">Date:2015-01-14 | 조회수:257</div>
		</a>
	</li>
	*/
	$ReturnValue ="<ul>";
	while($Datas=mysql_fetch_array($RST)) {
		$url = $_SERVER['PHP_SELF']."?page=".$page."&mode=R&id=" . $Datas['id'];
		$img_url = $root. '/'. $Datas['sPath'].'/thumb/'.$Datas['sCopy'];
		$icon = "hit";
		if ($Datas['DiffDay'] > -8) {
			if ($Datas['iSee'] < 10 ) {
				$icon = "new";
			}
		}

		$ReturnValue .= "<li>";
		$ReturnValue .= "<a href=\"". $url ."\" class=\"sendpost\">";
		$ReturnValue .= "<div class=\"img\" style=\"background-image:url(".$img_url.")\"></div>";
		$ReturnValue .= "<div class=\"subject\">". $Datas['sTitle'] ."</div>";
		$ReturnValue .= "<div class=\"".$icon."\"></div>";
		$ReturnValue .= "<div class=\"info\">Date:".$Datas['dInDate']." | 조회수:".$Datas['iSee']."</div>";
		$ReturnValue .= "</a>";
		$ReturnValue .= "</li>";
	}
	$ReturnValue .="</ul>";
	return $ReturnValue;
}

function sqlShowData_manager_edu($QueryString, $tableArr, $num) {
	global $db_conn, $default_db, $skin_dir, $BOARD_CONFIG, $MEMBER, $userLevel, $page, $table, $path, $USER_TYPE; 
	$RST = $db_conn -> sql($default_db, $QueryString);
	$ReturnValue = "<tbody>";
	while($Datas = mysql_fetch_array($RST)) {
		$ReturnValue .="<tr>\n";
		$ReturnValue .="	<td class=\"".$tableArr[0]['pos']."\"><input type=\"checkbox\" class=\"checkGroup\" value=\"".$Datas['user_id']."\" /></td>\n";
		$ReturnValue .="	<td class=\"".$tableArr[1]['pos']."\">". $num-- ."</td>\n";
		$ReturnValue .="	<td class=\"".$tableArr[2]['pos']."\">".$Datas['sUserId']."</td>\n";
		$ReturnValue .="	<td class=\"".$tableArr[2]['pos']."\">".$Datas['sCenterName'].$Datas['sCenter_N']."</td>\n";
		
		if ($Datas['iNumber_N'] > 1) {
			$name_subfix = '('. $Datas['iNumber_N'] .'명)';
		} else {
			$name_subfix ='';
		}
		
		$ReturnValue .="	<td class=\"".$tableArr[3]['pos']."\">".$Datas['sUserName']. $Datas['sName_N'] .$name_subfix."</td>";
		$ReturnValue .="	<td class=\"".$tableArr[4]['pos']."\">".$Datas['sHphone']. $Datas['sHp_N'] ."</td>";
		$ReturnValue .="	<td class=\"".$tableArr[5]['pos']."\">".$Datas['sEmail'] ."</td>";
		$ReturnValue .="	<td class=\"".$tableArr[6]['pos']."\">".$USER_TYPE[$Datas['eUserType']] ."</td>";
		if ($Datas['user_id']) {
			$ReturnValue .="	<td class=\"".$tableArr[7]['pos']."\"><span class=\"button medium\"><a href=\"javascript:;\" onclick=\"user_modify_dialog('".$Datas['user_id']."')\">수정</a></span></td>\n";
		} else {
			$ReturnValue .="	<td class=\"".$tableArr[7]['pos']."\"><span class=\"button medium\"><a href=\"javascript:;\" onclick=\"Wishlist.user_del('".$Datas['id']."', this)\">삭제</a></span></td>\n";
		}
		
		$ReturnValue.="</tr>\n";
	}
	$ReturnValue .= "</tbody>";
	$ReturnValue .= "</table>";
	return $ReturnValue;
}
// answer 스킨 목록 보기
function sqlShowData_answer($QueryString, $no , $PositionArr) { 
	global $db_conn, $default_db, $skin_dir, $BOARD_CONFIG, $MEMBER, $userLevel, $page, $table; 
	$RST = $db_conn -> sql($default_db, $QueryString);
	
	$ReturnValue ="	<tbody>\n";
	while($Datas=mysql_fetch_array($RST))
	{
		$ReturnValue .="<tr>\n";
		if ($userLevel ==1) { // 관리자일경우 체크박스 표시
			$ReturnValue .="	<td class=\"$PositionArr[0]\"><input type=\"checkbox\" name=\"id[]\" value=\"".$Datas['id']."\" class=\"checkDepth".$Datas['iDepth']."\" /></td>\n";
		}
		
		$ReturnValue .="	<td class=\"$PositionArr[1]\">". $no-- ."</td>\n";
		$ReturnValue .="	<td class=\"$PositionArr[2]\">\n
								<div class=\"subject\">\n";
		// 카데고리 사용						
		if($BOARD_CONFIG['iUseCategory']) {
			$category = "[". $BOARD_CONFIG['Category'][$Datas['iCategory']] ."] ";
		}
								
		$url = $_SERVER['PHP_SELF']."?page=".$page."&mode=R&id=" . $Datas['id'];
		$href = "<a href=\"". $url ."\" class=\"sendpost\">". $category . $Datas['sTitle'] ."</a>";
		
		//비밀글 이라면 비빌글 아이콘을 표시
		if ($Datas['iSecret'] == 1) {
			$ReturnValue .="		<img src=\"". $skin_dir ."/img/icon_secret.gif\" alt=\"답글\" class=\"secret\" />\n";
			//비밀글 url 설정
			if ($userLevel != 1) { // 관리자아니면
				if ($Datas['iDepth'] == 0) {
					$secret_top_user_id = $Datas['user_id'];
					$secret_top_id  = $Datas['id'];
				}
				if ($Datas['user_id'] > 0 &&  $secret_top_user_id == $MEMBER['id'] ) { //회원글이거나 회원글 하위글
					$url .= "&source_id=" . $secret_top_id;
					$href = "<a href=\"". $url ."\" class=\"sendpost\">". $category. $Datas['sTitle'] ."</a>";
				} else {  // 회원글이 아니거나 하위글
					$href = "<a href=\"". $Datas['id'] . "," . $secret_top_id . ",". $table ."\" class=\"boardsecretview\">". $category. $Datas['sTitle']."</a>";
				}
			}
		} else {
			$secret_top_user_id='';
			$secret_top_id = '';
		}
		// 답글이라면 답글 아이콘 표시
		if($Datas['iDepth'] > 0) {
			$depth = ($Datas['iDepth']-1) * 20;
			$ReturnValue .="<span class=\"reply\" style=\"padding-left:".$depth."px;\"><img src=\"". $skin_dir . "/img/icon_reply.gif\" alt=\"답글\" /></span>";
		}
		
		$ReturnValue .=  $href; //"<a href=\"". $url ."\" class=\"sendpost\">". $Datas['sTitle'] ."</a>";
		// 파일이 있다면 파일아이콘 표시
		if ($Datas['iHaveFile'] > 0 ) {
			$ReturnValue .="<img src=\"". $skin_dir . "/img/icon_file.gif\" alt=\"파일첨부\" class=\"file\" />";
		}
		
		$RCSQL = "SELECT COUNT(id) FROM `board_reply` WHERE board_config_id='".$BOARD_CONFIG['id']."' AND board_id='".$Datas['id']."'";
		$RCRES = $db_conn->sql($default_db, $RCSQL);
		list($Rcount) = mysql_fetch_row($RCRES);
		if ($Rcount > 0) { // 답변이 있다면
			$ReturnValue .="<img src=\"". $skin_dir . "/img/icon_reply2.gif\" alt=\"답변완료\" class=\"reply2\" />";
		}
		
				
		$ReturnValue .="		</div>\n
							</td>\n";
		$ReturnValue .="	<td class=\"$PositionArr[3]\">".getNameStamp($Datas['sName']) ."</td>\n";
		$ReturnValue .="	<td class=\"$PositionArr[4]\">".$Datas['dInDate']."</td>\n";
		$ReturnValue .="	<td class=\"$PositionArr[5]\">".$Datas['iSee'] ."</td>\n";
		$ReturnValue.="</tr>\n";
	}
	$ReturnValue.="	</tbody>\n";
	$ReturnValue.="</table>\n";
	if($userLevel == 1) {
		$ReturnValue.= "</form>";
	}
	return $ReturnValue;
}
?>
