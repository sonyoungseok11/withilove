<?php
	/*  로그인 유무 사이트 상단 변경 */
	$outlogin = "";
	if(empty($MEMBER['id'])) {
		$outlogin .= '
			<div class="outlogin_layer">
				<form action="'.$path.'/join/sign_in.php" method="post"  onsubmit="return check_form(this);">
					<input type="text" name="sUserId" class="check_value" placeholder="ID" />
					<input type="password" name="sUserPw" class="check_value" placeholder="PW" />
					<input type="submit" value="LOG IN" />
				</form>
			</div>
			<a href="#" class="text_login"><span class="blind">로그인</span></a>
            <a href="'.$path.'/sub_etc/member/agrement.php" class="text_register"><span class="blind">회원가입</span></a>
            <a href="SearchIdPw" class="text_findId dialog_open"><span class="blind">ID/PW찾기</span></a>
            <a href="#" class="text_customers"><span class="blind">고객센터</span></a>
            <a href="'.$path.'/sub_etc/sitemap.php" class="text_map"><span class="blind">사이트맵</span></a>
		';
	} else {
		$outlogin .= '
			<a href="'.$path.'/join/sign_out.php" class="text_logout"><span class="blind">로그아웃</span></a>
            <a href="'.$path.'/sub_etc/member/confirm_course.php" class="text_modify"><span class="blind">마이페이지</span></a>
            <a href="#" class="text_customers"><span class="blind">고객센터</span></a>
            <a href="'.$path.'/sub_etc/sitemap.php" class="text_map"><span class="blind">사이트맵</span></a>
		';
		if ($MEMBER['iMLevel'] < 9) {
			$outlogin .= '
				<a href="'.$path.'/manager/index.php" class="text_manager"><span class="blind">관리자</span></a>
			';
		}
		if ($MEMBER['iMLevel'] == 1) {
			$outlogin .= '
				<a href="'.$path.'/adm/index.php" class="text_adm"><span class="blind">admin</span></a>
			';
		}
	}
	/*  //로그인 유무 사이트 상단 변경 */
	
	/* 메뉴 카데고리 가지고 오기 */
	$MenuSQL = "
		SELECT s1.iGroup, s1.sMenuName, s1.sMenuUrl, s2.iParent_id, s2.iSort, s2.sMenuName, s2.sMenuUrl FROM sitemenu s1
		INNER JOIN sitemenu s2 ON s1.id = s2.iParent_id
		WHERE s1.iActive=1 AND s2.iActive=1 AND s1.iGroup IN(1,2)
		ORDER BY s1.iGroup, s1.iSort, s2.iSort
	";
	$MenuRES = $db_conn -> sql($default_db, $MenuSQL);
	while (list($iGroup, $MenuCategory, $CategoryUrl, $iParent, $iSort, $MenuName, $MenuUrl) = mysql_fetch_row($MenuRES)) {
		$Menu[$iGroup][$iParent]['category'] = $MenuCategory;
		$Menu[$iGroup][$iParent]['catogoryUrl'] = $CategoryUrl;
		$Menu[$iGroup][$iParent]['sub'][$iSort]['MenuName'] = $MenuName;
		$Menu[$iGroup][$iParent]['sub'][$iSort]['MenuUrl'] = $MenuUrl;
	}
	
	$MenuArr = array();
	foreach ($Menu as $MenuGroup => $Category) {
		
		$MenuArr[$MenuGroup] = "";
		$MenuArr[$MenuGroup] .= "<ul>\n";
		//$MenuArr[$MenuGroup] .= "<li><a href=\"$root/sub_etc/community/notice.php\">공지사항</a></li>\n";
		foreach($Category as $ca) {
			
			$MenuArr[$MenuGroup] .= "<li>\n";
			$MenuArr[$MenuGroup] .= "<a href=\"$root". $ca['catogoryUrl']."\">".$ca['category']."</a>\n";
			$MenuArr[$MenuGroup] .= "<ul>\n";
			foreach ($ca['sub'] as $me) {
				$MenuArr[$MenuGroup] .= "<li>";
				$MenuArr[$MenuGroup] .= "<a href=\"$root". $me['MenuUrl']."\">". $me['MenuName']."</a>\n";
				$MenuArr[$MenuGroup] .= "</li>";
			}
			$MenuArr[$MenuGroup] .= "</ul>\n";
			$MenuArr[$MenuGroup] .= "</li>\n";
		}
		
		$MenuArr[$MenuGroup] .= "</ul>\n";
	}
	$current_file_name = getFileName(); 
	switch ($current_file_name) {
		case 'index.php' :
			$main_Select = "selected";
			break;
		case 'index2.php' :
			$main_Select2 = "selected";
			break;
		default :
			break;
	}
	
	/* //메뉴 카데고리 가지고 오기 */
	
?>

<!-- gnb -->
	<div class="gnb">
    	<h1 class="top_logo"><a href="<?=$path?>/index.php"><span class="blind">위드프랭즈교육원</span></a></h1>
        <div class="sitemenu">
        	<!--div class="site_search">
        	<form method="get" action="search.php"  onsubmit="return check_form(this);">
				<!--input type="hidden" name="sfl" value="wr_subject||wr_content">
           		<input type="hidden" name="sop" value="and"-->
        		<!--input type="text" name="SearchStr" id="SearchStr" value="" maxlength="20" placeholder="검색어를 입력하세요." class="check_value"/>
                <input type="submit" value="" id="SearchBtn" />
            </form>
            </div-->
			<?=$outlogin?>
        </div>
        <ul class="gnb_top">
        	<li><a href="<?=$path?>/sub_etc/community/introduction.php" class="text_topmenu1"><span class="blind">위드프랭즈소개</span></a></li>
            <li><a href="<?=$path?>/sub_career/student_report/camp_memoirs.php" class="text_topmenu2"><span class="blind">학원운영자료실</span></a></li>
            <li><a href="<?=$path?>/sub_career/resource/career.php" class="text_topmenu3"><span class="blind">학부모,강사자료실</span></a></li>
            <li><a href="<?=$path?>/sub_career/pds/basic_pds.php" class="text_topmenu4"><span class="blind">교육자료실</span></a></li>
            <li><a href="<?=$path?>/sub_tax/academy/academytax.php" class="text_topmenu5"><span class="blind">세무자료실</span></a></li>
            <li><a href="<?=$path?>/sub_tax/academy/academylaw.php" class="text_topmenu6"><span class="blind">법무자료실</span></a></li>
            <li><a href="<?=$path?>/sub_tax/academy/academyinfo.php" class="text_topmenu7"><span class="blind">노무자료실</span></a></li>
        </ul>
    </div>
    <div class="navi">
    	<div class="navi_menutitle">
        	<div class="menu1">
				<a href="<?=$path?>/index.php" class="<?=$main_Select?>"><span class="blind">학원세무관련</span></a>
				<div class="submenu">
					<div>
						<?=$MenuArr[1]?>
					</div>
				</div>
			</div>
            <div class="menu2">
				<a href="<?=$path?>/index2.php" class="<?=$main_Select2?>"><span class="blind">진로진학관련</span></a>
				<div class="submenu">
					<div>
						<?=$MenuArr[2]?>
					</div>
				</div>
			</div>
        </div>
    </div>
    <!-- //gnb -->
