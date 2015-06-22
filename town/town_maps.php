<?php
include_once ("./_common.php");
include_once("$root/subhead.php");
include_once("town_function.php");
?>
<script type="text/javascript" src="//apis.daum.net/maps/maps3.js?apikey=d1a0f4ce72bcbd2fd05dadf7e7a3a053&libraries=services"></script>
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
		//dMap.init();
		Geo.getGeo();
		
	});
</script>
<?php
include_once("$root/town/town_imgview.php");
include_once("$root/subfoot.php");
?> 