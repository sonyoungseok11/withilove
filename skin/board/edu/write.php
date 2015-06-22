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
			<select name="iCategory" id="iCategory">
				<?=getSelectOption($BOARD_CONFIG['Category'], $Datas['iCategory'])?>
			</select>
			
			<? //$categorySelect ?>
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
		
		<? if ($is_UploadLevel && $mode != 'A') { ?>
		<li>
			<label class="bh">
				목록 이미지
			</label>
			<!-- 파일 업로드 기록이 있으면 목록을 가지고온다.  -->
			<?=$file_input?>
			<div class="file_info">330 X 165 사이즈 이미지 파일 만 업로드 하세요</div>
		</li>
		
		<li>
			<label for="sPreface" class="bh">목록 표시글</label>
			<textarea name="sPreface" id="sPreface" rows="3" class="check_text"><?=$Datas['sPreface']?></textarea>
		</li>
		<li>
			<label for="sSMS" class="bh">고객응대 설정</label>
			<input type="text" name="sSMS" id="sSMS" value="<?=$Datas['sSMS']?>" class="check_text mb_length" size="80"> <span class="mb_length_view"></span>
			<div class="file_info">{HOMETITLE} = 홈페이지타이틀, {name} = 회원이름</div>
		</li>
		<? 	} ?>
		
		
		<li>
			<label for="sComment" class="bh">내용</label>
			<textarea name="sComment" id="sComment" rows="10" class="check_text <?=$edit_class?>"><?=$Datas['sComment']?></textarea>
			<?=$Parent_info?>
		</li>
		
		<!-- 파일 업로드 사용 및 권한에 대한 설정 -->
		<? if ($is_UploadLevel && $parent_id > 0) { ?>
		<li class="file">
			<a href="#" class="msButton verysmall fileinsert">추가하기</a>
			<label class="bh">
				첨부파일<br />
				<span class="small">최대 <span id="iUploadCount"><?=$BOARD_CONFIG['iUploadCount']?></span>개</span><br />
				<span class="small">파일당 <?=$fileuploadsize?></span>
			</label>
			<!-- 파일 업로드 기록이 있으면 목록을 가지고온다.  -->
			
			<?=$file_input?>
		</li>
		<? } ?>
	</ul>
	<div class="submit_zone">
		<input type="submit" value="작성하기" class="msButton"/>
		<a href="<?=$_SERVER['PHP_SELF']?>" class="msButton gray">취소</a>
	</div>
</form>