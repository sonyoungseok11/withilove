<?php
	include_once ("./_common.php");
	include_once ("$path/inc/header.php");
	include_once ("$path/inc/gnb.php");
	
	$FSQL ="SELECT id, iActive, sName, sUrl FROM family_academy ORDER BY iActive DESC, iSort ASC";
	$FRES = $db_conn -> sql($default_db, $FSQL);
	$iTotal = mysql_num_rows($FRES);
	$next_isort = $iTotal+1;
	
	$data = "";
	while ($row = mysql_fetch_array($FRES)) {
		if (!$row['iActive']) {
			$disable = "disable";
			$actStr = "노출함";
		} else {
			$disable = "";
			$actStr = "노출안함";
		}
		$data .= "<li class=\"ui-state-default ".$disable."\">";
		$data .= "<span class=\"ui-icon ui-icon-arrowthick-2-n-s\"></span>";
		$data .= "<input type=\"hidden\" name=\"ids[]\" value=\"".$row['id']."\">";
		$data .= "<label>학원명 : <input type=\"text\" name=\"sName\" value=\"". $row['sName'] ."\" /></label>";
		$data .= "<label>Url : <input type=\"text\" name=\"sUrl\" value=\"". $row['sUrl'] ."\" /></label>";
		$data .= "<a href=\"javascript:;\" onclick=\"academy.update(".$row['id'].", this);\" class=\"jButton small\">수정</a>";
		$data .= "<a href=\"javascript:;\" onclick=\"academy.activeChange(".$row['id'].", ".$row['iActive'].");\" class=\"jButton small\">".$actStr."</a>";
		$data .= "<a href=\"javascript:;\" onclick=\"academy.del(".$row['id'].");\" class=\"jButton small\">삭제</a>";
		$data .= "</li>";
	}
	
?>

<div class="academy_list">
	<form name="sort_change" action="<?=$path?>/etc/family_academy_list_proc.php" method="post">
	<input type="hidden" name="mode" value="S" />
	<ul class="sortable">
		<?=$data?>
	</ul>
	</form>
</div>
<script type="text/javascript">
$('.sortable').sortable();
</script>

<form name="family_academy" action="<?=$path?>/etc/family_academy_list_proc.php" method="post" >
<input type="hidden" name="mode" value="I"/>
<input type="hidden" name="iActive" value="1"/>
<input type="hidden" name="iSort" value="<?=$next_isort?>"/>
<div class="line_update">
	<div class="title">신규등록</div>
	<label for="sName">학원명 :</label>
	<input type="text" name="sName" id="sName" value=""  class="check_length"/>
	<label for="sUrl">Url :</label>
	<input type="text" name="sUrl" id="sUrl" value="" />
	<input type="submit" value="신규등록"  class="jButton small"/>
	<a href="javascript:;" onclick="academy.resort();" class="jButton medium">정렬순서 변경</a>
</div>
</form>
<?php
	include_once ("$path/inc/footer.php");
?>