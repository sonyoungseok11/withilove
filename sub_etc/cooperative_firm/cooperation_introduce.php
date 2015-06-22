<?php
include_once ("../../sub_tax/offer/_common.php");
include_once("../../sub_tax/offer/$root/subhead.php");
$PSQL = "
	SELECT l.id, l.sTitle, f.sPath, f.sFile
	FROM `cooperative_firm_list` l
	INNER JOIN `cooperative_firm_files` f ON  l.id= f.cooperative_id
	WHERE l.eType='P' AND f.eType='B' ORDER BY l.iSort
	";
$PRES = $db_conn -> sql($default_db, $PSQL);
$Pvalue = "";
while ($P = mysql_fetch_assoc($PRES)) {
	$Pvalue .= "<a href=\"javascript:;\" onclick=\"Cooperative.ShowDetail(". $P['id'] .")\" title=\"".$P['sTitle']."\"><img src=\"".$path.$P['sPath']."/".$P['sFile']."\" alt=\"".$P['sTitle']."\"/></a>";
}

$NSQL ="
	SELECT l.sTitle, l.sUrl, f.sPath, f.sFile
	FROM `cooperative_firm_list` l
	INNER JOIN `cooperative_firm_files` f ON  l.id= f.cooperative_id
	WHERE l.eType='N' AND f.eType='B' ORDER BY l.iSort
";
$NRES = $db_conn -> sql($default_db, $NSQL);
$Nvalue = "";
while ($N = mysql_fetch_assoc($NRES)) {
	$Nvalue .= "<a href=\"".$N['sUrl']."\" target=\"_blank\"><img src=\"".$path.$N['sPath']."/".$N['sFile']."\" alt=\"".$N['sTitle']."\"/></a>";
}

?>
<style type="text/css">
.page_title{font-size:17pt;font-weight:bold;line-height:50px;padding:40px 0 20px 105px; position:relative;}
.page_title:before {content:"▶"; display:inline-block; font-size:15pt; color:#4383fc; position:absolute; top:40px; left:80px;}
#cont_box .page_sub_text {font-size:15pt; color:#4383fc;font-weight:bold; margin-bottom:20px; letter-spacing: -1px; padding-left:100px;}
#cont_box .page_sub_text > span {font-size:20pt; color:#c6c6c6;}
#cont_box .sub_text > span {color:#4383fc}
#cont_box .red {color:#F06; font-weight:bold;}
#cont_box .page_sub_text + .page_sub_text {padding-left:330px;}
#cont_box .sub_text {padding:20px 0px 150px 0px; line-height:25px; font-size:10pt; margin-left:100px; }
#cont_box .page_sub_text > img{float:left;}
#career_text {margin-left:300px; margin-top:-250px; line-height:25px; text-align:left; padding-top:57px;}
.cooperative_info {list-style:disc; padding-left:100px; font-size:13px; line-height:22px;}
.list_title {font-size:17pt;font-weight:bold;line-height:50px;padding:40px 0 20px 105px; position:relative;}
.list_title:before {content:"●"; display:inline-block; font-size:8pt; color:#ff5e52; position:absolute; top:40px; left:89px;}

.cooperative_list.power {width:885px; margin-left:60px;}
.cooperative_list.power a {display:inline-block; margin-left:40px; margin-bottom:20px; height:100px; width:170px; position:relative;}
.cooperative_list.normal a:hover, .cooperative_list.power a:hover {outline:5px solid #4383fc;}
.cooperative_list.power a:hover:after {content:"상세보기"; display:block; position:absolute; left:0px; bottom:10px; width:100%; text-align:center; font-size:14px; font-weight:bold; background:#000; background:rgba(0,0,0,0.7); line-height:24px; color:#FFF;}
.cooperative_list.normal {width:840px; margin-left:94px;}
.cooperative_list.normal a {display:inline-block; margin-left:5px; margin-bottom:20px; height:50px; border:1px solid #acacac;}
</style>

<div id="cont_box">
	<div class="page_title">
		<p>협력업체를 모십니다.</p>
	</div>
	<ul class="cooperative_info">
		<li>위드프랭즈 교육원에서는 원장님께서 필요로 하는 보다 편리하고 종합적인 서비스를 제공해 드리기 위해서 함께 하실 협력업체를 모십니다.</li>
		<li>위드프랭즈 교육원과 함께 서로 도와가며 WIN-WIN 할 수 있는 업체면 좋겠습니다.</li>
		<li>협력업체 문의 : <span class="red">010-9023-7171</span><br />협력업체 담당 : 남기훈 이사<br /><a href="javascript:;" onclick="suppoters('C');" class="jButton">위드프랭즈 협력업체 신청하기</a></li>
	</ul>
	
	<div class="list_title">협력업체 리스트</div>
	<div class="cooperative_list power">
		<?=$Pvalue?>
	</div>
	<div class="cooperative_list normal">
		<?=$Nvalue?>
	</div>
</div>
<?php
include_once("../../sub_tax/offer/$root/subfoot.php");
?>



