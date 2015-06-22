<?php
include_once ("./_common.php");
include_once ("$path/inc/header.php");
include_once ("$path/inc/gnb.php");

	$eType = 'N'; // 일반

	$FSQL ="
			SELECT l.id, l.user_id , l.iActive, l.iSort, l.sTitle, l.sTitleSubfix, l.sUrl, l.dInDate, f.sPath, f.sFile, u.sUserId, u.sUserName 
			FROM `cooperative_firm_list` l
			INNER JOIN `cooperative_firm_files` f ON l.id = f.cooperative_id
			INNER JOIN `users` u ON u.id = l.user_id
			WHERE l.eType='".$eType."' AND f.eType='B' ORDER BY l.iSort ASC
			";
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
			$data .= "<span class=\"logo\">
						<input type=\"hidden\" name=\"ids[]\" value=\"".$row['id']."\">
						<span class=\"ui-icon ui-icon-arrowthick-2-n-s\"></span>
						<img src=\"".$row['sPath'] .'/'. $row['sFile']."\" alt=\"".$row['sTitle']."\" style=\"border:1px solid #acacac\" />
					</span>";
		$data .= "<span class=\"stitle\"><a href=\"".$row['sUrl']."\" target=\"_blank\">".$row['sTitle']."</a></span>";
		$data .= "<span class=\"stitlesubfix\">".$row['sTitleSubfix']."</span>";
		$data .= "<span class=\"userinfo\"><a href=\"javascript:;\" onclick=\"user_modify_dialog(".$row['user_id'].")\">".$row['sUserName']."(". $row['sUserId'].")</a></span>";
		$data .= "	<span class=\"command\">
						<a href=\"javascript:;\" onclick=\"Cooperative.Modify(".$row['id'].")\" class=\"jButton small\">수정</a>
						<a href=\"javascript:;\" onclick=\"Cooperative.Del(".$row['id'].")\" class=\"jButton small\">삭제</a>
					</span>";
		$data .= "</li>";
	}


?>
<style type="text/css">
.cooperative_list {}
.cooperative_list .header {width:100%; background:#f0f0f0; height:30px; display:table; border-top:1px solid #ccc; border-left:1px solid #ccc; border-right:1px solid #ccc; box-sizing:border-box;}
.cooperative_list .header > span {font-size: 12px; display:table-cell; text-align:center; line-height:30px; font-weight:bold;}
.cooperative_list .logo {width:300px}
.cooperative_list .stitle {width:200px; border-left:1px solid #ccc;}
.cooperative_list .stitlesubfix {width:auto; border-left:1px solid #ccc;}
.cooperative_list .userinfo {width:120px;border-left:1px solid #ccc;}
.cooperative_list .command {width:150px; border-left:1px solid #ccc;}
.cooperative_list .sortable li {height:66px; position:relative; display:table; width:100%; box-sizing:border-box;}
.cooperative_list .sortable li > span {display:table-cell; text-align:center; vertical-align:middle;}
.cooperative_list .sortable .ui-icon {display:inline-block; top:24px; position:absolute; left:8px;}
.cooperative_list .Btns {margin:10px 0px; text-align:right;}
</style>
<div class="cooperative_list">
	<form name="sort_change" action="<?=$path?>/cooperative/cooperative_proc.php" method="post">
	<input type="hidden" name="mode" value="S" />
	<input type="hidden" name="eType" value="<?=$eType?>" />
	<div class="header">
		<span class="logo">배너</span>
		<span class="stitle">업체명</span>
		<span class="stitlesubfix">업체정보</span>
		<span class="userinfo">유저 정보</span>
		<span class="command">명령</span>
	</div>
	<ul class="sortable">
		<?=$data?>
	</ul>
	</form>
	<div class="Btns">
		<a href="javascript:;" onclick="Cooperative.reSort();" class="jButton">정렬순서변경</a>
		<a href="javascript:;" onclick="Cooperative.NewInsert('<?=$eType?>','<?=$next_isort?>');" class="jButton">신규등록</a>
	</div>
</div>
<script type="text/javascript">
$('.sortable').sortable();
</script>

<?php
include_once ("$path/inc/footer.php");
?>