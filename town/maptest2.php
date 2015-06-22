<?php
include_once ("./_common.php");
include_once("$root/subhead.php");
?>
<style type="text/css">
#map_canvas {width:1000px; height:500px; margin:0 auto; background:#f9f9f9;}
#pano {width:400px; height:400px; position:absolute; top:50px; right:30px;}
</style>
<script type="text/javascript"src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDbYKwEdJIj5V4kpvIYYvhNDuLxOgNRjrE&libraries=places&signed_in=true&sensor=false"></script>
<input id="pac_title"  value="우리학원" size="20" >
<input id="pac_input" type="text" placeholder="Enter a location" value="경기도 시흥시 은행로 140"  size="60" >

<div id="map_canvas"></div>


<script type="text/javascript">
var gMap = {
	geocoder : new google.maps.Geocoder(),
	mapOptions : {
		zoom : 16
	},
	map_div : document.getElementById('map_canvas'),
	map : null,
	title : document.getElementById('pac_title'),
	input : document.getElementById('pac_input'),
	inputOptions : {
		componentRestrictions: {country : 'kr'}
	},
	autocomplete : null,
	
	infowindow : new google.maps.InfoWindow(),
	marker : null,
	init : function () {
		var address = gMap.input.value;
		gMap.geocoder.geocode({'address' : address} , function (results, status){
			if (status == google.maps.GeocoderStatus.OK) {
				//gMap.marker.setVisible(false);
				//gMap.infowindow.close();
				//gMap.map.setCenter(results[0].geometry.location);
				gMap.mapOptions.center = results[0].geometry.location;
				gMap.map = new google.maps.Map(gMap.map_div, gMap.mapOptions);
				//gMap.marker.setPosition(results[0].geometry.location);
				gMap.marker = new google.maps.Marker({
					map : gMap.map,
					position : results[0].geometry.location,
					anchorPoint : new google.maps.Point(0,-29)
				});
				gMap.infowindow.setContent('<div style="font-family:Nanum Gothic; font-size:12px; font-">'+ gMap.title.value +'</div>');
				gMap.infowindow.open(gMap.map, gMap.marker);
				google.maps.event.addListener(gMap.marker, 'click', function(){
					gMap.infowindow.open(gMap.map, gMap.marker);
				});
			}
			gMap.autocomplete = new google.maps.places.Autocomplete(gMap.input, gMap.inputOptions);
			google.maps.event.addListener(gMap.autocomplete, 'place_changed', gMap.place_change);
		});
	},
	noaddress : function() {
		gMap.map = new google.maps.Map(gMap.map_div, gMap.mapOptions);
		gMap.marker = new google.maps.Marker({
			map : gMap.map,
			anchorPoint : new google.maps.Point(0,-29)
		});
		google.maps.event.addListener(gMap.marker, 'click', function(){
			gMap.infowindow.open(gMap.map, gMap.marker);
		});
		gMap.autocomplete = new google.maps.places.Autocomplete(gMap.input, gMap.inputOptions);
		google.maps.event.addListener(gMap.autocomplete, 'place_changed', gMap.place_change);
	},
	place_change : function() {
		gMap.infowindow.close();
		gMap.marker.setVisible(false);
		var place = gMap.autocomplete.getPlace();
		if (!place.geometry) {
			return;
		}
		gMap.map.setCenter(place.geometry.location);
		gMap.map.setZoom(16);
			
		gMap.marker.setPosition(place.geometry.location);
		gMap.marker.setVisible(true);
		
		gMap.infowindow.setContent('<div style="font-family:Nanum Gothic; font-size:12px; font-">'+ gMap.title.value +'</div>');
		gMap.infowindow.open(gMap.map, gMap.marker);
		console.log(place);
		gMap.input.value = gMap.input.value.replace('대한민국 ', '');
	},
	address_code : function (address) {
		gMap.geocoder.geocode({'address' : address} , function (results, status){
			if (status == google.maps.GeocoderStatus.OK) {
				gMap.marker.setVisible(false);
				gMap.infowindow.close();
				
				gMap.map.setCenter(results[0].geometry.location);
				
				gMap.marker.setPosition(results[0].geometry.location);
				gMap.marker.setVisible(true);
				gMap.infowindow.setContent('<div style="font-family:Nanum Gothic; font-size:12px; font-">'+ gMap.title.value +'</div>');
				gMap.infowindow.open(gMap.map, gMap.marker);
				console.log(results);
			}
		});
	},
	title_change : function() {
		gMap.infowindow.setContent('<div style="font-family:Nanum Gothic; font-size:12px; font-">'+ gMap.title.value +'</div>');
	}
}

$(document).ready(function(e) {
	gMap.init();
	$(gMap.input).keydown(function(e) {
		if (e.keyCode == 13) {
			e.preventDefault();
			gMap.address_code(this.value);
		}
	});
	$(gMap.title).change(function(e) {
		e.preventDefault();
		gMap.title_change();
	});
});

</script>

<?php
include_once("$root/subfoot.php");
?> 