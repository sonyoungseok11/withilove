<?php

?>
<form action="<?=$root?>/board/board_proc.php" method="post" enctype="multipart/form-data" onsubmit="return check_form(this);">
	<input type="hidden" name="mode" value="<?=$mode?>" />
	<input type="hidden" name="board_config_id" value="<?=$BOARD_CONFIG['id']?>" />
	<input type="hidden" name="board_id" value="<?=$board_id?>" />
	<input type="hidden" name="user_id" value="<?=$MEMBER['id']?>" />
	<input type="hidden" name="MAX_FILE_SIZE" value="<?=$BOARD_CONFIG['iFileSize']?>" />
	<input type="hidden" name="parent_id" value="<?=$parent_id?>" />
	<input type="hidden" name="parent_iOrder" value="<?=$PARENT['iOrder']?>" />
	<input type="hidden" name="parent_iDepth" value="<?=$PARENT['iDepth']?>" />
	<ul class="write_table">
		<!-- 카데고리 사용에 따른 처리 -->
		<? if ($BOARD_CONFIG['iUseCategory']) { ?>
		<li>
			<label for="iCategory" class="bh">카데고리</label>
			<?=$categorySelect?>
		</li>
		<? } ?>
		<!-- //카데고리 사용에 따른 처리 -->
	
		<!-- 회원 유무에 따른 처리 -->
		<? if ($MEMBER['id']) { ?>
			<input type="hidden" name="sName" value="<?=$MEMBER['sUserName']?>" />
			<input type="hidden" name="sPw" value="" />
			<input type="hidden" name="sEmail" value="<?=$MEMBER['sEmail']?>"; />
		<? } else { ?>
		<li>
			<label for="sName" class="bh">성명</label> 
			<input type="text"  name="sName" id="sName" value="<?=$Datas['sName']?>" class="check_value" size="20" $readonly />
		</li>
		<li>
			<label for="sPw" class="bh">비밀번호</label>
			<input type="password"  name="sPw" id="sPw" class="check_value" size="20" />
		</li>
		<li>
			<label for="sEmail" class="bh">이메일</label>
			<input type="text"  name="sEmail" id="sEmail" value="<?=$Datas?>" class="check_value" size="40" />
		</li>
		<? } ?>
		<!-- //회원 유무에 따른 처리 -->
		
		<li>
			<label for="sTitle" class="bh">제목</label>
			<input type="text"  name="sTitle" id="sTitle" value="<?=$Datas['sTitle']?>" class="check_value" size="70"/>
		<!-- 비밀글 사용에 따른 처리 -->	
			<?php if ($BOARD_CONFIG['iUseSecret']) { ?>
				<label><input type="checkbox" name="iSecret" id="iSecret" value='1' /> 비밀글</label>
			<?php } //비밀글설정 ?>
		<!-- //비밀글 사용에 따른 처리 -->
		</li>
		<li>
			<label for="dStartDate" class="bh">행사 일정</label>
			<input type="text"  name="dStartDate" id="dStartDate" value="<?=$Datas['dStartDate']?>" class="check_ymd" size="12"/> 
			~ 
			<input type="text"  name="dEndDate" id="dEndDate" value="<?=$Datas['dEndDate']?>" class="check_ymd nocheck" size="12"/>
			하루 일정일 경우 시작일정만 입력
		</li>
		<!-- 파일 업로드 권한에 대한 설정 -->
		<? if ($is_UploadLevel) { ?>
		<!--li>
			<label class="bh">
				목록 이미지
			</label>
			<?=$file_input?>
		</li-->
		<? } ?>
		<li>
			<label for="sComment" class="bh">내용</label>
			<textarea name="sComment" id="sComment" rows="10" class="check_text <?=$edit_class?>"><?=$Datas['sComment']?></textarea>
			<?=$Parent_info?>
		</li>
		<!-- 파일 업로드 사용 및 권한에 대한 설정 -->
	</ul>
	<div class="submit_zone">
		<input type="submit" value="작성하기" class="msButton"/>
		<a href="#" class="msButton gray write_cancle">취소</a>
	</div>
</form>