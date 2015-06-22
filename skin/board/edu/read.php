<?php
if ($Datas['iHaveFile'] > 0 ) {
	$filezone = "<div class=\"downfiles\">
					<img src=\"".$skin_dir."/img/icon_file.gif\" alt=\"첨부파일\"/>";
	$filezone .= $linkfile;
	$filezone .="</div>";
}

//print_r($Datas)
$print_date = "";
$print_date .= getPrintDate($Datas['dStartDate']);
if ($Datas['dEndDate'] != '0000-00-00') {
	$print_date .= ' ~ '. getPrintDate($Datas['dEndDate']);
}

// 위시 리스트 불러오기
if ($MEMBER['iMLevel'] == 1) {
	$WCSQL = "SELECT COUNT(id) FROM `board_user_wishlist` WHERE board_config_id='". $board_config_id ."' AND board_id='".$board_id."' AND eWishType='ASK'";
	$WCRES = $db_conn -> sql($default_db, $WCSQL);
	list ($wish_count) = mysql_fetch_row($WCRES);
	
	$wishlist = "<div class=\"wishlist\">";
	$wishlist .="<h5>신청자 목록 : <span class=\"total\">".$wish_count."명</span></h5>";
	
	if ($wish_count > 0) {
		$wishlist .="<ul>";
		$WSQL = "
			SELECT w.sName_N, w.sHp_N, u.sUserId, u.sUserName FROM `board_user_wishlist` w
			LEFT JOIN users u ON w.user_id = u.id 
			WHERE w.board_config_id='". $board_config_id ."' AND w.board_id='".$board_id."' AND w.eWishType='ASK'
			ORDER BY w.id DESC
		";
		$WRES = $db_conn -> sql($default_db, $WSQL);
			while ($WISHLIST = mysql_fetch_assoc($WRES)) {
				if ($WISHLIST['sUserId']) {
					$isMEMBER = $WISHLIST['sUserId'];
				} else {
					$isMEMBER = "비회원";
				}
				$wishlist .="<li>";
				$wishlist .="<span>".$WISHLIST['sUserName'].$WISHLIST['sName_N']."(".$isMEMBER.")</span>";
				$wishlist .="</li>";
			}
		$wishlist .="</ul>";
	}
	
	$wishlist .="</div>";
}
?>
<div class="read_table">
	<h4>
		제목 : <?=$Datas['sTitle']?> [ <?=$print_date?> ]
		<span>작성자: <?=$Datas['sName']?> <!--(<?=$Datas['sIp']?>) --></span>
		<span class="side">조회수(<b><?=$Datas['iSee']?></b>) | 작성일 : <?=$Datas['dInDate']?> </span>
	</h4>
	<?=$itemURL?>
	<?php
		if ($Datas['iDepth']) {
			echo $filezone;
		}
	?>
	<div class="board_contents">
		<div class="cssReset"><?=$Datas['sComment']?></div>
	</div>
</div>
<div class="command">
	<?php
	$ReturnValue ="";
	if ($Datas['DiffDay'] > 0) {					
		if ($MEMBER['id']) {
			$WSQL = "SELECT COUNT(id), id, eWishType FROM `board_user_wishlist` WHERE board_table='".$table."' AND board_id='".$Datas['id']."' AND user_id='".$MEMBER['id']."'";
			$WRES = $db_conn->sql($default_db, $WSQL);
			list ($WISH['count'], $WISH['id'], $WISH['type']) = mysql_fetch_row($WRES);
			if ($WISH['count']) {
				switch ($WISH['type']) {
					case 'HOBBY' :
						$ReturnValue .="	<span class=\"hobby\"></span>\n";
						$ReturnValue .="	<span class=\"ask\"><a href=\"javascript:;\" onclick=\"Wishlist.update('".$WISH['id']."','ASK', this);\" class=\"msButton medium pink\">세미나 신청</a></span>\n";
						break;
					case 'ASK' :
						$ReturnValue .="	<span class=\"hobby\"></span>\n";
						$ReturnValue .="	<span class=\"ask\"></span>\n";
						break;
				}
			} else {
				$ReturnValue .="	<span class=\"hobby\"><a href=\"javascript:;\" onclick=\"Wishlist.insert('".$BOARD_CONFIG['id']."','".$table."','".$Datas['id']."','".$MEMBER['id']."','HOBBY', this);\" class=\"msButton medium blue\">관심일정추가</a></span>\n";
				$ReturnValue .="	<span class=\"ask\"><a href=\"javascript:;\" onclick=\"Wishlist.insert('".$BOARD_CONFIG['id']."','".$table."','".$Datas['id']."','".$MEMBER['id']."','ASK', this);\" class=\"msButton medium pink\">세미나 신청</a></span>\n";
			}
			
		} else {
			$ReturnValue .="	<span class=\"hobby\"><a href=\"javascript:;\" onclick=\"needMember();\" class=\"msButton medium blue\">관심일정추가</a></span>\n";
			$ReturnValue .="	<span class=\"ask\"><a href=\"javascript:;\" onclick=\"Wishlist.nomember_insert(".$Datas['id'].",this);\" class=\"msButton medium pink\">세미나 신청</a></span>\n";
		}
	} 
	echo $ReturnValue;
	?>
</div>
<?=$wishlist?>
<!-- 명령 버튼 -->
<div class="command">
	<a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$page?>" class="msButton medium blue left sendpost">목록보기</a>
	<?php
		if ($is_AnswerLevel && $Datas['iDepth'] < 2) { 
			echo '<a href="'. $_SERVER['PHP_SELF'] .'?mode=A&id='. $board_id .'" class="msButton medium blue right sendpost">답글쓰기</a>';
		}
		if ($MEMBER['iHLevel'] == 1 || $MEMBER['id'] == $Datas['user_id']) {
			if ($ThisDel) {
				echo '<a href="'.$root.'/board/board_proc.php?mode=D&board_config_id='.$board_config_id.'&id='.$board_id.'" class="msButton medium gray left sendpost">삭제</a>';
			}
		}
		if ($MEMBER['iHLevel'] == 1 || $MEMBER['id'] == $Datas['user_id']) {
			echo '<a href="'. $_SERVER['PHP_SELF'] .'?mode=M&id='. $board_id .'" class="msButton medium red left sendpost">수정</a>';
		}
	?>
</div>

<!-- 덧글 사용이면 불러오기 -->
<? if($BOARD_CONFIG['iUseReply']) { ?> 
<div class="reply_list">
	<?=$replyList?>
	<? if ($is_ReplyLevel) { //덧글쓰기 권한이 있으면 글쓰기 불러오기 ?>
	<div class="reply_write">
		<form name="reply" action="<?=$root?>/board/board_proc.php" method="post" onsubmit="return check_form(this)">
			<input type="hidden" name="mode" value="reply_W" />
			<input type="hidden" name="board_config_id" value="<?=$board_config_id?>" />
			<input type="hidden" name="board_id" value="<?=$board_id?>" />
			<input type="hidden" name="user_id" value="<?=$MEMBER['id']?>" />
			<input type="hidden" name="sName" value="<?=$MEMBER['sUserName']?>" />
			<textarea name="sComment" id="sComment" class="check_text"></textarea>
			<input type="submit" value="덧글달기" class="msButton medium blue reply_write_btn" />
		</form>
	</div>
	<? } ?>
</div>
<? } ?>
<!-- //덧글 사용이면 불러오기 -->

<!-- 연관글 불러오기 -->
<div class="list_table">
	<?=$assocVal?>
</div>
<div class="bbs_bottom"></div>