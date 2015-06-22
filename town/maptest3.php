<?php
include_once ("./_common.php");
include_once("$root/subhead.php");
?>
<script type="text/javascript" src="//apis.daum.net/maps/maps3.js?apikey=d1a0f4ce72bcbd2fd05dadf7e7a3a053&libraries=services"></script>

<input id="pac_title"  value="" size="20" >
<input id="pac_input" type="text" placeholder="Enter a location" value="방학동 698-13"  size="60" >
<a href="#" id="pac_button" class="jButton small">지도검색</a>

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
<a href="javascript:;" onclick="dMap.getInfo();">정보</a>
<div id="info"></div>

<script type="text/javascript" src="<?=$root?>/js/daum_map.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
	dMap.useRoadView = true;
	dMap.init();
});
</script>
<label for="sAddrSub" class="lh">주소</label>
			<input type="text" name="sZipCode" value="<?=$MEMBER['sZipCode']?>" readonly="readonly" size="8" class="check_zipcode" /> 
			<a href="Search_ZipCode_New" class="msButton small blue dialog_open">우편번호</a>
			<input type="text" name="sAddr" id="sAddr" value="<?=$MEMBER['sAddr']?>" size="60" class="block" readonly="readonly" />
			<input type="text" name="sAddrSub" id="sAddrSub" value="<?=$MEMBER['sAddrSub']?>" size="60" class="check_value" /> 나머지 주소
<?php
include_once("$root/subfoot.php");
?> 