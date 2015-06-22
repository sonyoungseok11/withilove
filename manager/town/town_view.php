<?php
include_once ("./_common.php");
include_once ("$path/inc/header.php");
include_once ("$path/inc/gnb.php");
include_once("$root/town/town_function.php");


$id = $_REQUEST['id'];
$page = empty($_REQUEST['page']) ? 1 : $_REQUEST['page'];

$TSQL = "SELECT id, user_id, zip_table, town_group1_id, town_group2_id, iActive, sName, sCeo, sTel, sHphone, sAddr, sAddrSub, sMapSearch, sUrl, sContent FROM `town_academy` WHERE id='".$id."'";
$TRES = $db_conn->sql($default_db, $TSQL);
$TOWN = mysql_fetch_assoc($TRES);
//print_r($TOWN);

$zone_id = $TOWN['town_zone_id'];
$group1_id = $TOWN['town_group1_id'];
$group2_id = $TOWN['town_group2_id'];

// 1차 분류 가져오기 
$GSQL1 = "SELECT id, sGroupName FROM `town_group1` ORDER BY iSort";
$GRES1 = $db_conn -> sql($default_db, $GSQL1);
while ($row = mysql_fetch_assoc($GRES1)) {
	$Group1[$row['id']] = $row['sGroupName'];
}

// 2차 분류 가져오기 
if ($group2_id > 0) {
	$GSQL2 = "SELECT id, sGroupName FROM `town_group2` WHERE town_group1_id='".$group1_id."' ORDER BY iSort";
	$GRES2 = $db_conn -> sql($default_db, $GSQL2);
	while ($row = mysql_fetch_assoc($GRES2)) {
		$Group2[$row['id']] = $row['sGroupName'];
	}
	$TOWN['group'] = $Group1[$group1_id].' - ' .$Group2[$group2_id];
} else {
	$TOWN['group'] = $Group1[$group1_id];
}

//홈페이지 링크
if ($TOWN['sUrl']) {
	$TOWN['url'] = "<li>
						<div class=\"lh\">홈페이지</div>
						<a href=\"".$TOWN['sUrl']."\">".$TOWN['sUrl']."</a>
					</li>";
}

// 이미지 가져오기
$FSQL = "SELECT sPath, sFile FROM `town_file` WHERE town_academy_id='".$id."' ORDER BY id";
$FRES = $db_conn -> sql($default_db, $FSQL);
$Frows = mysql_num_rows($FRES);
if ($Frows > 0) {
	$TOWN['thumb'] = "<li>";
	$TOWN['thumb'] .= "<div class=\"lh\">학원 이미지</div>";
	$i=0;
	while ($img = mysql_fetch_assoc($FRES)) {
		if ($i) {
			$margin = "margin-left:6px;";
		}
		$TOWN['thumb'] .= "<a href=\"javascript:;\" onclick=\"Town.viewImg(".$id.",".$i++.")\" style=\"background:url('".$root.$img['sPath']."/thumb/".$img['sFile']."') no-repeat center center; display:inline-block; width:104px; height:104px; border:1px solid #ccc;". $margin ."\" title=\"이미지보기\"></a>";
	}
	$TOWN['thumb'] .= "</li>";
}

// 목록 버튼 /* <a href="town_list.php?page=$page" class="jButton">목록</a>*/
if($TOWN['iActive']) {
	$list_btn = "<a href=\"town_list.php?page=$page\" class=\"jButton\">목록</a>";
} else {
	$list_btn = "<a href=\"town_standby.php?page=$page\" class=\"jButton\">목록</a>";
}

// 학원 정보 수정 버튼
if ($MEMBER['iHLevel'] == 1 || $MEMBER['id'] == $TOWN['user_id']) {
	$mod_btn = "<a href=\"town_write.php?mode=M&id=".$id."\"  class=\"jButton right sendpost\">학원수정</a>";
} else {
	$mod_btn = "<a href=\"javascript:;\" onclick=\"Town.Modify(".$id.")\"  class=\"jButton right\">학원수정</a>
		<div id=\"mod_text\" style=\"display:none;\">비밀번호 : <input type=\"password\" id=\"Town_modpw\" /> <a href=\"#\" class=\"jButton small\">확인</a></div>
	";
}
?>
<script type="text/javascript" src="//apis.daum.net/maps/maps3.js?apikey=d1a0f4ce72bcbd2fd05dadf7e7a3a053&libraries=services"></script>
<div class="udonghak_view">
	<div class="title">
		학원명 : <?=$TOWN['sName']?>
		 <input type="hidden" id="pac_title" value="<?=$TOWN['sName']?>" />
	</div>
	<ul class="town_form">
		<li>
			<div class="lh">학원전화</div>
			<?=$TOWN['sTel']?>
		</li>
		<li>
			<div class="lh">휴대전화</div>
			<?=$TOWN['sHphone']?>
		</li>
		<li>
			<div class="lh">원장명</div>
			<?=$TOWN['sCeo']?>
		</li>
		<li>
			<div class="lh">분류</div>
			<?=$TOWN['group']?>
		</li>
		<?=$TOWN['url']?>
		<li>
			<div class="lh">학원소개</div>
			<div class="pre"><?=$TOWN['sContent']?> </div>
		</li>
		<?=$TOWN['thumb']?>
		<li>
			<div class="lh">주소</div>
			<?=$TOWN['sAddr']?> <?=$TOWN['sAddrSub']?>
		</li>
		<li class="nopadding">
			
			<input type="hidden" id="pac_input" value="<?=$TOWN['sMapSearch']?>" />
			<div id="container">
				<div id="mapWrapper">
					<div id="map"></div>
					<div id="roadviewControl"><span>로드뷰</span></div>
				</div>
				<div id="rvWrapper">
					<div id="road"></div>
					<div id="rvClose"><span class="img"></span></div>
				</div>
			</div>
			<script type="text/javascript" src="<?=$root?>/js/daum_map.js"></script>
			<script type="text/javascript">
				$(document).ready(function(e) {
					dMap.useRoadView = true;
					dMap.init();
				});
			</script>
		</li>
	</ul>
	<div class="command">
		<?=$list_btn?>
		<?=$mod_btn?>
	</div>
</div>
<?php
include_once("$root/town/town_imgview.php");
include_once ("$path/inc/footer.php");
?> 