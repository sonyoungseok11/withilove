<?php
include_once ("./_common.php");
include_once("$root/subhead.php");

$FSQL ="SELECT sName FROM family_academy WHERE iActive=1 ORDER BY iSort ASC";
$FRES = $db_conn -> sql($default_db, $FSQL);

$returnVal = "";
$i=0;
while (list($sName) = mysql_fetch_row($FRES)) {
	if ($i%4 == 0 ) {
		$returnVal .= "<li>";
	}
	
	$returnVal .= "<div class=\"list_detail\"><div class=\"list_text\">".$sName."</div></div>";
	$close = false;
	if ($i%4 == 3) {
		$returnVal .= "</li>";
		$close = true;
	}
	$i++;
}
if (!$close) {
	$returnVal .= "</li>";
}



?>
<style type="text/css">
.page_title{font-size:17pt;font-weight:bold;line-height:50px;padding:40px 0 20px 105px; position:relative;}
.page_title:before {content:"▶"; display:inline-block; font-size:15pt; color:#4383fc; position:absolute; top:40px; left:80px;}
#tax_list ul li {width:1000px; margin-bottom:30px; border-top:1px solid #ccc; padding-top:30px;}
#tax_list ul li:first-child {padding-top:none; border-top:none;}
#tax_list ul li:after {content:""; display:block; clear:both;}
#tax_list ul li .list_detail {width:250px; position:relative; float:left;}
#tax_list ul li .list_detail.right {float:left;}
#tax_list ul li .list_detail >img {float:left;}
#tax_list ul li .list_detail .list_text {padding-left:70px; position:relative}
#tax_list ul li .list_detail .list_text:before {content:"· 학원명 :"; display:block; position:absolute; left:0px; top:0px; white-space:pre-wrap; color:#4383fc; font-size:11pt;font-weight:bold;}
#tax_list ul li .list_detail {line-height:20px}
#tax_list ul li .list_detail p.name {position:relative; font-size:11pt; margin-bottom:6px; font-weight:bold; font-size:15pt}
#tax_list ul li .list_detail p.name:before {content:"· 학원명 :"; display:block; position:absolute; left:-66px; top:0px; color:#4383fc; font-size:11pt; font-weight:bold;}
</style>
<div id="cont_box">
	<div class="page_title">위드프랭즈 패밀리 학원</div>
	<div id="tax_list">
    	<ul>
        	<?=$returnVal?>
		</ul>
	</div>
    <!---end cont_box----------------------------------------------------------->
</div>
<?php
include_once("$root/subfoot.php");
?>