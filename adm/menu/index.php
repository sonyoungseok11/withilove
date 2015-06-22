<?php
	include_once ("./_common.php");
	include_once ("$path/inc/header.php");
	include_once ("$path/inc/gnb.php");
?>
<script type="text/javascript" src="<?=$path?>/js/menu_admin.js"></script>
<div class="menuADM">
	<div id="menu1">
		<h3>
			대분류
			<div>
				<span class="button small icon"><span class="refresh"></span><a href="#" class="refresh1">새로고침</a></span>
				<span class="ajax_loader"></span>
			</div>
		</h3>
		<ul class="sortable">
		
		</ul>
		<div class="new">
			<span class="title">대분류 등록</span>
			<input type="hidden" name="iParent_id" value="0" />
			<label>SORT : <input type="text" name="iSort" value="" size="2" class="center" readonly="readonly"/></label>
			<label>Group ID : <input type="text" name="iGroup" value="" size="3" class="center"/></label>
			<label>Menu Name : <input type="text" name="sMenuName" value="" size="15" /></label>
			<label>M Lv : 
				<select name="iMLevel">
					<?=getLevelOption(10)?>
				</select>
			</label>
			<label>H Lv : 
				<select name="iHLevel">
					<?=getLevelOption(10)?>
				</select>
			</label>
			<select name="iActive" style="display:none;">
				<option value="0">비활성</option>
			</select>
			<span class="button medium"><a href="#" class="menu_insert">신규 등록</a></span>
			<span class="button medium"><a href="#" class="menu_sort_update">정렬순서 저장</a></span>
		</div>
	</div>
	<div id="menu2" style="display:none;">
		<h3>
			중분류
			<span></span>
			<div>
				<span class="button small"><a href="#" class="disable_toggle">비활성 숨기기</a></span>
				<span class="button small"><a href="#" class="style_toggle">Style 보이기</a></span>
				<span class="button small icon"><span class="refresh"></span><a href="#" class="refresh2">새로고침</a></span>
				<span class="ajax_loader"></span>
			</div>
		</h3>
		<ul class="sortable">
		
		</ul>
		<div class="new">
			<span class="title">중분류 등록</span>
			<input type="hidden" name="iParent_id" value="" />
			<label>SORT : <input type="text" name="iSort" value="" size="2" class="center" readonly="readonly"/></label>
			<label>Group ID : <input type="text" name="iGroup" value="" size="3" class="center" readonly="readonly"/></label>
			<label>중분류이름 : <input type="text" name="sMenuName" value="" size="15" /></label>
			<label>Url : <input type="text" name="sMenuUrl" size="30" /></label>
			<label>Class : <input type="text" name="sClass" size="20" /></label>
			<label style="display:none;">Style : <input type="text" name="sStyle" size="20"/></label>
			<label>M Lv : 
				<select name="iMLevel">
					<?=getLevelOption(10)?>
				</select>
			</label>
			<label>H Lv : 
				<select name="iHLevel">
					<?=getLevelOption(10)?>
				</select>
			</label>
			<select name="iActive">
				<option value="1">활성</option>			
				<option value="0">비활성</option>
			</select>
			<span class="button medium"><a href="#" class="menu_insert">신규 등록</a></span>
			<span class="button medium"><a href="#" class="menu_sort_update">정렬순서 저장</a></span>
		</div>
	</div>
	<div id="menu3" style="display:none;">
		<h3>
			소분류
			<span></span>
			<div>
				<span class="button small"><a href="#" class="disable_toggle">비활성 숨기기</a></span>
				<span class="button small"><a href="#" class="style_toggle">Style 보이기</a></span>
				<span class="button small icon"><span class="refresh"></span><a href="#" class="refresh3">새로고침</a></span>
				<span class="ajax_loader"></span>
			</div>
		</h3>
		<ul class="sortable">
		
		</ul>
		<div class="new">
			<span class="title">소메뉴 등록</span>
			<input type="hidden" name="iParent_id" value="" />
			<label>SORT : <input type="text" name="iSort" value="" size="2" class="center" readonly="readonly"/></label>
			<label>Group ID : <input type="text" name="iGroup" value="" size="3" class="center" readonly="readonly"/></label>
			<label>소메뉴이름 : <input type="text" name="sMenuName" value="" size="15"  /></label>
			<label>Url : <input type="text" name="sMenuUrl" size="30" /></label>
			<label>Class : <input type="text" name="sClass" size="20" /></label>
			<label style="display:none;">Style : <input type="text" name="sStyle" size="20"/></label>
			<label>M Lv : 
				<select name="iMLevel">
					<?=getLevelOption(10)?>
				</select>
			</label>
			<label>H Lv : 
				<select name="iHLevel">
					<?=getLevelOption(10)?>
				</select>
			</label>
			<select name="iActive">
				<option value="1">활성</option>
				<option value="0">비활성</option>
			</select>
			<span class="button medium"><a href="#" class="menu_insert">신규 등록</a></span>
			<span class="button medium"><a href="#" class="menu_sort_update">정렬순서 저장</a></span>
		</div>
	</div>
</div>
<?php
	include_once ("$path/inc/footer.php");
?>