<?php
if ($Datas['iHaveFile'] > 0 ) {
	$filezone = "<div class=\"downfiles\">
					<img src=\"".$skin_dir."/img/icon_file.gif\" alt=\"첨부파일\"/>";
	$filezone .= $linkfile;
	$filezone .="</div>";
}

//print_r($Datas)
?>
<div class="read_table">
	<h4>
		제목 : <?=$Datas['sTitle']?>
		<span>작성자: <?=getNameStamp($Datas['sName'])?> <!--(<?=$Datas['sIp']?>) --></span>
		<span class="side">조회수(<b><?=$Datas['iSee']?></b>) | 작성일 : <?=$Datas['dInDate']?> </span>
	</h4>
	<?=$itemURL?>
	<?=$filezone?>
	
	<div class="board_contents">
		<div class="cssReset"><?=$Datas['sComment']?></div>
	</div>
</div>

<!-- 명령 버튼 -->
<div class="command">
	<a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$page?>" class="msButton medium blue left sendpost">목록보기</a>
	<?php
		if ($is_AnswerLevel && $Datas['iDepth'] < 2) { 
			echo '<a href="'. $_SERVER['PHP_SELF'] .'?mode=A&id='. $board_id .'" class="msButton medium blue right sendpost">답글쓰기</a>';
		} else {
			echo '<a href="javascript:;" onclick="needMember();" class="msButton medium blue right">글쓰기</a>';
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