<?PHP
	/*DB*/
	class Db_conn
	{
		var $Hosts = array();
		var $Querys;
		var $CONN;
		var $Result;

		function db_arrs($B , $H, $D , $U , $P)
		{
			$this ->Hosts[$B]  = array("HOST"=>$H , "Database"=>$D , "User" =>$U , "Password"=>$P);
		}

		function connect($B) # DataBase 연결
		{
			$this->CONN = mysql_connect( $this ->Hosts[$B][HOST] , $this ->Hosts[$B][User] ,$this ->Hosts[$B][Password]  ) or die(__LINE__.mysql_error());
			mysql_select_db($this ->Hosts[$B][Database]) or die(mysql_error());
			mysql_query("set names utf8") or die(mysql_error());
		}

		function close($B) # DataBase 종료
		{
			mysql_close($this->CONN);
		}

		function sql($B,$QueryString) #Query 실행
		{
			$this-> connect($B);
			$this->Querys = mysql_query($QueryString) or die(__LINE__.mysql_error()."<br> Err : $QueryString");
			return $this->Querys;
		}

		function sqlROWS()
		{
			return mysql_num_rows($this->Querys);
		}
		function insert_id()
		{
			return mysql_insert_id();
		}

		function sqlCount()
		{
			list($cnt)=mysql_fetch_array($this->Querys);
			return $cnt;
		}


		function sqlShowData_adminTable($B,$QueryString, $PositionArr) # 관리자 게시판 목록 보기
		{
			global $board_skin_dir, $path;
			$RST = $this-> sql($B,$QueryString);
			$ReturnValue="	<tbody>\n";
			while($Datas=mysql_fetch_array($RST))
			{
				$ReturnValue .="<tr>\n";
				$ReturnValue .="	<td class=\"$PositionArr[0]\"><input type=\"checkbox\" value=\"".$Datas['id']."\" class=\"checkGroup\" /></td>\n";
				$ReturnValue .="	<td class=\"$PositionArr[1]\">".$Datas['id']."</td>\n";
				$ReturnValue .="	<td class=\"$PositionArr[2]\">".$Datas['sTableName']."</td>";
				$ReturnValue .="	<td class=\"$PositionArr[3]\">".$Datas['sBoardSubject']."</td>";
				
				$ReturnValue .="	<td class=\"$PositionArr[4]\">".$Datas['sMenuName']."</td>";
				$ReturnValue .="	<td class=\"$PositionArr[5]\"><a href=\"".$Datas['sMenuUrl']."\" target=\"_blank\">".$Datas['sMenuUrl']."</a></td>";
				
				$ReturnValue .="	<td class=\"$PositionArr[6]\">".$Datas['sSkinDir'] ."</td>";
				$ReturnValue .="	<td class=\"$PositionArr[7]\"><span class=\"button medium\"><a href=\"".$path."/board/board.php?mode=M&id=".$Datas['id']."\">수정</a></span></td>\n";
				
				$ReturnValue.="</tr>\n";
			}
			$ReturnValue.="	</tbody>\n";
			$ReturnValue.="</table>\n";
			return $ReturnValue;
		}
		
		function sqlShowData_adminUserList($B,$QueryString, $PositionArr, $num) # 관리자 회원관리 리스트 페이지
		{
			global $board_skin_dir, $path, $USER_TYPE, $USER_STATUS, $iUserStatus;
			$RST = $this-> sql($B,$QueryString);
			$ReturnValue="	<tbody>\n";
			while($Datas=mysql_fetch_array($RST))
			{
				$print_day = $iUserStatus == '10' ? $Datas['dOutDate'] : $Datas['dInDate'];
				if($Datas['logid']) {
					if ($Datas['iActive']) {
						$diffTime = "<span style=\"color:#f30\"><span class=\"blind\">a</span>접속중</span>";
					} else {
						$diffTime = userLoginDiffTime($Datas['dLogDate']);
					}
				} else {
					$diffTime = "<span style=\"color:#ccc\"><span class=\"blind\">f</span>기록없음</span>";
				}
				
				$ReturnValue .="<tr>\n";
				$ReturnValue .="	<td class=\"$PositionArr[0]\"><input type=\"checkbox\" class=\"checkGroup\" value=\"".$Datas['id']."\" /></td>\n";
				$ReturnValue .="	<td class=\"$PositionArr[1]\">". $num-- ."</td>\n";
				$ReturnValue .="	<td class=\"$PositionArr[2]\">".$Datas['iMLevel']."</td>\n";
				$ReturnValue .="	<td class=\"$PositionArr[3]\">".$Datas['iHLevel']."</td>";
				$ReturnValue .="	<td class=\"$PositionArr[4]\">".$Datas['sUserId']."</td>";
				$ReturnValue .="	<td class=\"$PositionArr[5]\">".$Datas['sUserName'] ."</td>";
				$ReturnValue .="	<td class=\"$PositionArr[6]\">".$USER_STATUS[$Datas['iUserStatus']] ."</td>";
				$ReturnValue .="	<td class=\"$PositionArr[7]\">".$USER_TYPE[$Datas['eUserType']] ."</td>";
				$ReturnValue .="	<td class=\"$PositionArr[8]\">".$print_day ."</td>";
				$ReturnValue .="	<td class=\"$PositionArr[9]\">".$diffTime."</td>";
				$ReturnValue .="	<td class=\"$PositionArr[10]\"><span class=\"button medium\"><a href=\"javascript:;\" onclick=\"user_modify_dialog('".$Datas['id']."')\">수정</a></span></td>\n";
				
				$ReturnValue.="</tr>\n";
			}
			$ReturnValue.="	</tbody>\n";
			$ReturnValue.="</table>\n";
			return $ReturnValue;
		}
		
		function sqlShowData_adminUserList2($B,$QueryString, $PositionArr, $num) # 관리자 회원관리 리스트 페이지
		{
			global $board_skin_dir, $path, $USER_TYPE, $USER_STATUS, $iUserStatus;
			$RST = $this-> sql($B,$QueryString);
			$ReturnValue="	<tbody>\n";
			while($Datas=mysql_fetch_array($RST))
			{
				$print_day = $iUserStatus == '10' ? $Datas['dOutDate'] : $Datas['dInDate'];
				if($Datas['logid']) {
					if ($Datas['iActive']) {
						$diffTime = "<span style=\"color:#f30\"><span class=\"blind\">a</span>접속중</span>";
					} else {
						$diffTime = userLoginDiffTime($Datas['dLogDate']);
					}
				} else {
					$diffTime = "<span style=\"color:#ccc\"><span class=\"blind\">f</span>기록없음</span>";
				}
				
				$ReturnValue .="<tr>\n";
				$ReturnValue .="	<td class=\"$PositionArr[0]\"><input type=\"checkbox\" class=\"checkGroup\" value=\"".$Datas['id']."\" /></td>\n";
				$ReturnValue .="	<td class=\"$PositionArr[1]\">". $num-- ."</td>\n";
				$ReturnValue .="	<td class=\"$PositionArr[4]\">".$Datas['sUserId']."</td>";
				$ReturnValue .="	<td class=\"$PositionArr[5]\">".$Datas['sUserName'] ."</td>";
				$ReturnValue .="	<td class=\"$PositionArr[2]\">".$Datas['sBusinessType']."</td>\n";
				$ReturnValue .="	<td class=\"$PositionArr[3]\">".$Datas['sCenterName']."</td>";
				$ReturnValue .="	<td class=\"$PositionArr[6]\">".$USER_STATUS[$Datas['iUserStatus']] ."</td>";
				$ReturnValue .="	<td class=\"$PositionArr[7]\">".$USER_TYPE[$Datas['eUserType']] ."</td>";
				$ReturnValue .="	<td class=\"$PositionArr[8]\">".$print_day ."</td>";
				$ReturnValue .="	<td class=\"$PositionArr[9]\">".$diffTime."</td>";
				$ReturnValue .="	<td class=\"$PositionArr[10]\"><span class=\"button medium\"><a href=\"javascript:;\" onclick=\"user_modify_dialog('".$Datas['id']."')\">수정</a></span></td>\n";
				
				$ReturnValue.="</tr>\n";
			}
			$ReturnValue.="	</tbody>\n";
			$ReturnValue.="</table>\n";
			return $ReturnValue;
		}
				
		function pagingFun($iTotal , $page ,$limite, $page_per_list, $parameter, $urls)
		{
			$page = ($page!="") ? $page : 1;
			$BNUM = $iTotal;
			$first=($page-1)*$limite;
			$last=$limite;
			if($BNUM < $last) $last = $BNUM;
			$limit="limit $first , $last";
			//넘길변수들
			$LinkString=$parameter;
			$nav=$this -> page_nav($BNUM,$limite,$page_per_list,$page,$LinkString, $urls , $iType);
			$st_num=$BNUM-$first; //한페이지에 순차번호
			$pagingValueArr = array($st_num , $nav , $LinkString , $limit);
			return $pagingValueArr;
		}


		function page_nav($total,$scale,$p_num,$page,$parameters , $urls )
		{
			$total_page = ceil($total/$scale);
			
			if (!$page) $page = 1;
			$page_list = ceil($page/$p_num)-1;
			if ($page_list>0) {
				$prev_page = ($page_list)*$p_num;
				$navigation .= "<a href=\"$urls?$parameters\" class=\"first sendpost\">◀</a>";
				$navigation .= "<a href=\"$urls?page=$prev_page&$parameters\" class=\"prev sendpost\">◀</a>";
			}

			// 페이지 목록 가운데 부분 출력
			$page_end=($page_list+1)*$p_num;
			$last_page = $total_page;
			if ($page_end>$total_page) $page_end=$total_page;

			for ($setpage=$page_list*$p_num+1;$setpage<=$page_end;$setpage++) {
				if ($setpage==$page){
					$navigation .="<b>$setpage</b>";
				} else {
					$navigation .= "<a href=\"$urls?page=$setpage&$parameters\" class=\"sendpost\">$setpage</a>";
				}
			}

			// 페이지 목록 맨 끝이 $total_page 보다 작을 경우에만, [next]...[$total_page] 버튼을 생성한다.
			if ($page_end<$total_page) {
				$next_page = ($page_list+1)*$p_num+1;
				$navigation .="<a href=\"$urls?page=$next_page&$parameters\" class=\"next sendpost\">▶</a>";
				$navigation .="<a href=\"$urls?page=$last_page&$parameters\" class=\"last sendpost\">▶</a>"; 
			}
			
			return $navigation;
		}

		function rc4crypt($txt,$mode=1)
		{
			$encrypt_key = "xkdkrjldkemrndkduiropaielrkqpekaldkjvxkdkrjldkemrndkduiropaielrkqpekaldkjvxkdkrjldkemrndkduiropaielrkqpekaldkjv"; #key 변경시 값변경
			$tmp = "";
			if (!$mode) $txt = unserialize(base64_decode($txt));
			$ctr = 0;
			$cnt = strlen($txt);
			for ($i=0; $i<$cnt; $i++) {
				if ($ctr==$cnt) $ctr=0;
				$tmp .= substr($txt,$i,1) ^ substr($encrypt_key,$ctr,1);
				$ctr++;
			}
			return ($mode) ? base64_encode(serialize($tmp)) : $tmp;
		}
		
		function LoginInfoDecode($string)
		{
			$CookieArray = explode("|*|",$string);
			foreach($CookieArray as $val) {
				$temp = explode('|:|', $val);
				$MEMBER[$this -> rc4crypt($temp[0],0)] = $this -> rc4crypt($temp[1],0);
			}
			return $MEMBER;
		}
		
		function LoginInfoEncode($array) {
			$MEMBER ="";
			if(is_array($array)) {
				foreach ($array as $key => $val) {
					if(!empty($MEMBER)) {
						$MEMBER .= "|*|";
					}
					$MEMBER .= $this-> rc4crypt($key)."|:|". $this-> rc4crypt($val);
				}
			} 
			return $MEMBER;
		}
	}
	/*// DB*/

	/*게시판 */
	class Board
	{
		var $Page;
		var $SearchType;
		var $SearchString;

		function boardHeader($varr, $carr,  $TablePositionArr, $TableSorter , $caption) # 일반 테이블 해더
		{
			$ReturnValue=
			"
			<table>\n
				<caption>". $caption ."</caption>\n
			";
			foreach ($carr as $cols )
			{
				$ReturnValue.="<col width=\"$cols\"/>\n";
			}
			$ReturnValue.="<thead>\n";
			$ReturnValue.="		<tr>\n";
			foreach ($varr as $key => $headers)
			{
				$ReturnValue.="			<th class=\"$TablePositionArr[$key] $TableSorter[$key]\">$headers</th>\n";
			}
			$ReturnValue.="		</tr>\n";
			$ReturnValue.="	</thead>\n";
			return $ReturnValue;
		}

		function boardHeader2($varr, $carr,  $TablePositionArr, $caption, $userlevel) # 게시판 해더 관리자 체크박스
		{
			global $root, $board_config_id ;
			$ReturnValue = "";
			if ($userlevel == 1) {
				$ReturnValue .= "<form action=\"$root/board/board_proc.php\" method=\"post\" class=\"board_check_del\" >";
				$ReturnValue .= "<input type=\"hidden\" name=\"mode\" value=\"D\" />";
				$ReturnValue .= "<input type=\"hidden\" name=\"board_config_id\" value=\"". $board_config_id."\" />";
				$ReturnValue .= "<input type=\"hidden\" name=\"returnUrl\" value=\"". $_SERVER['PHP_SELF'] ."\" />";
			}
			$ReturnValue .= "<table>\n
								<caption>". $caption ."</caption>\n
							";
			$len = count($varr);
			for ($i=0; $i<$len; $i++) {
				if ($i==0 && $userlevel != 1) {
					continue;
				} 
				$ReturnValue.="<col width=\"$carr[$i]\"/>\n";
				
			}
			$ReturnValue.="	<thead>\n";
			$ReturnValue.="		<tr>\n";
			for ($i=0; $i<$len; $i++) {
				if ($i==0 && $userlevel != 1) {
					continue; // 관리자가 아니면 넘김
				}
				$ReturnValue.="			<th class=\"$TablePositionArr[$i]\">$varr[$i]</th>\n";
			}
			
			$ReturnValue.="		</tr>\n";
			$ReturnValue.="	</thead>\n";
			return $ReturnValue;
		}
		function newBoardHeader($HeaderVal, $caption) {
			$ReturnValue=
			"
			<table>\n
				<caption>". $caption ."</caption>\n
			";
			foreach ($HeaderVal as $val )
			{
				$ReturnValue.="<col width=\"".$val['col']."\"/>\n";
			}
			$ReturnValue.="<thead>\n";
			$ReturnValue.="		<tr>\n";
			foreach ($HeaderVal as $val)
			{
				$ReturnValue.="<th class=\"".$val['pos'] ." ". $val['sort']. "\">".$val['title']."</th>\n";
			}
			$ReturnValue.="		</tr>\n";
			$ReturnValue.="	</thead>\n";
			return $ReturnValue;
			
		}
		function noDatas($varr) // 관리자 데이터 없음표시
		{
			$ReturnValue="		<tbody>\n";
			$ReturnValue.= "	<tr height=\"150\">\n";
			$ReturnValue.= "		<td class=\"center\" colspan=\"".count($varr)."\" >검색된 자료가 없습니다.</td>\n";
			$ReturnValue.= "	</tr>\n";
			$ReturnValue.="		</tbody>\n";
			$ReturnValue.= "</table>\n";
			return $ReturnValue;
		}
		function noDatas2($varr, $userLevel) // 홈페이지 데이터 없음 표시
		{
			$cols = count($varr);
			if ($userLevel != 1) {
				$cols--;
			}
			$ReturnValue="		<tbody>\n";
			$ReturnValue.= "	<tr height=\"200\">\n";
			$ReturnValue.= "		<td class=\"center\" colspan=\"".$cols."\" >검색된 자료가 없습니다.</td>\n";
			$ReturnValue.= "	</tr>\n";
			$ReturnValue.="		</tbody>\n";
			$ReturnValue.= "</table>\n";
			return $ReturnValue;
		}

	}
?>