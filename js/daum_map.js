function MapWalker(position){
    //커스텀 오버레이에 사용할 map walker 엘리먼트
    var content = document.createElement('div');
    var figure = document.createElement('div');
    var angleBack = document.createElement('div');

    //map walker를 구성하는 각 노드들의 class명을 지정 - style셋팅을 위해 필요
    content.className = 'MapWalker';
    figure.className = 'figure';
    angleBack.className = 'angleBack';

    content.appendChild(angleBack);
    content.appendChild(figure);

    //커스텀 오버레이 객체를 사용하여, map walker 아이콘을 생성
    var walker = new daum.maps.CustomOverlay({
        position: position,
        content: content,
        yAnchor: 1
    });

    this.walker = walker;
    this.content = content;
}

//로드뷰의 pan(좌우 각도)값에 따라 map walker의 백그라운드 이미지를 변경 시키는 함수
//background로 사용할 sprite 이미지에 따라 계산 식은 달라 질 수 있음
MapWalker.prototype.setAngle = function(angle){
    var threshold = 22.5; //이미지가 변화되어야 되는(각도가 변해야되는) 임계 값
    for(var i=0; i<16; i++){ //각도에 따라 변화되는 앵글 이미지의 수가 16개
        if(angle > (threshold * i) && angle < (threshold * (i + 1))){
            //각도(pan)에 따라 아이콘의 class명을 변경
            var className = 'm' + i;
            this.content.className = this.content.className.split(' ')[0];
            this.content.className += (' ' + className);
            break;
        }
    }
};
//map walker의 위치를 변경시키는 함수
MapWalker.prototype.setPosition = function(position){
    this.walker.setPosition(position);
};
MapWalker.prototype.getPosition = function(){
    return this.walker.getPosition();
};
MapWalker.prototype.setVisible = function(bool) {
	this.walker.setVisible(bool);
}
//map walker를 지도위에 올리는 함수
MapWalker.prototype.setMap = function(map){
    this.walker.setMap(map);
};
var mapWalker = null;

var dMap = {
	FILEMAX : 5,
	overlayOn : false,
	useRoadView : true,
	container : document.getElementById('container'),
	mapWrapper : document.getElementById('mapWrapper'),

	mapCont : document.getElementById('map'),
	mapOptions : {
		center : new daum.maps.LatLng(0, 0),
		level :3
	},
	map : null,
	geocoder : new daum.maps.services.Geocoder(),
	typeControl : new daum.maps.MapTypeControl(),
	zoomControl : new daum.maps.ZoomControl(),
	marker : null,
	infoWindow : null,
	roadCont : document.getElementById('road'),
	roadview : null,
	roadviewClient : null,
	infomation : null,
	rMarker : null,
	rInfoWindow : null,
	init : function() {
		dMap.map = new daum.maps.Map(dMap.mapCont, dMap.mapOptions);
		var address = document.getElementById('pac_input').value;
		if (address) {
			dMap.setGeocoder(address);
		}
		dMap.map.addControl(dMap.typeControl, daum.maps.ControlPosition.TOPRIGHT);
		dMap.map.addControl(dMap.zoomControl, daum.maps.ControlPosition.RIGHT);
		dMap.roadview = new daum.maps.Roadview(dMap.roadCont);
		dMap.roadviewClient = new daum.maps.RoadviewClient();
		
		daum.maps.event.addListener(dMap.roadview, 'position_changed', function() {
			if (dMap.overlayOn) {
				var rvPosition = dMap.roadview.getPosition();
				dMap.map.setCenter(rvPosition);
				var title  = document.getElementById('pac_title').value;
				mapWalker.setPosition(rvPosition);
			}
		});
		
		daum.maps.event.addListener(dMap.roadview, 'viewpoint_changed', function() {
			var viewpoint = dMap.roadview.getViewpoint();
			mapWalker.setAngle(viewpoint.pan);
		});
		
		daum.maps.event.addListener(dMap.map, 'click', function(e){
			//console.log(dMap.overlayOn);
			if (dMap.overlayOn) {
					var position = e.latLng;
					mapWalker.setPosition(position);
					mapWalker.setVisible(true);
					dMap.toggleRoadview(position);
			}
		});
		
	},
	setGeocoder : function (address) {
		dMap.geocoder.addr2coord(address, function(status, result){
			if (status == daum.maps.services.Status.OK) {
				var coords = new daum.maps.LatLng(result.addr[0].lat, result.addr[0].lng);
				dMap.map.setCenter(coords);

				dMap.setMarker(coords);
				var title  = document.getElementById('pac_title').value
				dMap.setInfoWindow(title);
				
				dMap.setRoadView(coords);
				
				if (mapWalker == null) {
					mapWalker = new MapWalker(coords);
					mapWalker.setMap(dMap.map);
				} else {
					mapWalker.setPosition(coords);
					if (dMap.overlayOn) {
						dMap.toggleRoadview(coords);
					}
				}
				mapWalker.setVisible(dMap.overlayOn);
			} else {
				alert ('지도 검색에 실패 하였습니다.\n\n검색어 입력를 입력해주세요');
			}
		}); 
	},
	setMarker : function (coords) {
		if (dMap.marker == null) {
			dMap.marker = new daum.maps.Marker({
				position : coords,
			});
			dMap.marker.setMap(dMap.map);
			
			dMap.rMarker = new daum.maps.Marker({
				position: coords,
				map: dMap.roadview
			});
			dMap.rMarker.setAltitude(8);
			
			daum.maps.event.addListener(dMap.marker, 'click', function() {
				var position = dMap.marker.getPosition();
				dMap.toggleRoadview(position);
				if (!dMap.overlayOn) {
					dMap.toggleRoadviewRoad();
				}
			});
		} else {
			dMap.marker.setPosition(coords);
			dMap.rMarker.setPosition(coords);
		}
		
		
	},
	setInfoWindow : function(title) {
		title = title ?  title : '학원명을 입력하세요';
		var content = '<div style="padding:5px">' +  title + '</div>'
		if (dMap.infoWindow == null) {
			dMap.infoWindow = new daum.maps.InfoWindow({
				content : content,
			});
			dMap.rInfoWindow = new daum.maps.InfoWindow({
				content : content,
			});
		} else {
			dMap.infoWindow.close();
			dMap.rInfoWindow.close();
			dMap.infoWindow.setContent(content);
			dMap.rInfoWindow.setContent(content);
		}
		dMap.infoWindow.open(dMap.map, dMap.marker);
		dMap.rInfoWindow.open(dMap.roadview, dMap.rMarker);
		
	},
	setRoadView : function (position) {
		dMap.roadviewClient.getNearestPanoId(position, 100, function(panoId){
			dMap.roadview.setPanoId(panoId, position);
		});
	},
	toggleRoadview : function(position) {
		dMap.roadviewClient.getNearestPanoId(position, 100, function(panoId){
			if (panoId == null) {
				dMap.toggleMapWrapper(true, position);
			} else {
				dMap.toggleMapWrapper(false, position);
				dMap.roadview.setPanoId(panoId, position);
			}
		});
		var projection = dMap.roadview.getProjection();
		var viewpoint = projection.viewpointFromCoords(dMap.rMarker.getPosition(), dMap.rMarker.getAltitude());
		dMap.roadview.setViewpoint(viewpoint);
	},
	toggleMapWrapper : function(active, position) {
		if (active) {
			dMap.container.className = '';
			dMap.map.relayout();
			dMap.map.setCenter(position);
			if (!dMap.overlayOn) {
				mapWalker.setVisible(false);
			}
		} else {
			if (!$(dMap.container).hasClass('view_roadview')) {
				$(dMap.container).addClass('view_roadview');
				dMap.map.relayout();
				dMap.map.setCenter(position);
			}
		}
	},
	toggleOverlay : function (active) {
		if (active) {
			dMap.overlayOn = true;
			mapWalker.setVisible(true);
			dMap.map.addOverlayMapTypeId(daum.maps.MapTypeId.ROADVIEW);
			//dMap.marker.setMap(dMap.map);
			//dMap.marker.setPosition(dMap.map.getCenter());
			dMap.toggleRoadview(dMap.marker.getPosition());
		} else {
			dMap.overlayOn = false;
			dMap.closeRoadview();
		}
	},
	toggleRoadviewRoad : function() {
		var control = document.getElementById('roadviewControl');
		if ($(control).hasClass('active')) {
			$(control).removeClass('active');
			dMap.toggleOverlay(false);
			
		} else {
			$(control).addClass('active');
			dMap.toggleOverlay(true);
		}
	},
	closeRoadview : function() {
		dMap.map.removeOverlayMapTypeId(daum.maps.MapTypeId.ROADVIEW);
		var position = dMap.marker.getPosition();
		dMap.toggleMapWrapper(true, position);
	},
	getInfo : function() {
		//console.log(dMap.marker.getPosition());
		dMap.infomation = {
			center : dMap.map.getCenter(),
			marker : {
				Lat : dMap.marker.getPosition().getLat(),
				Lng : dMap.marker.getPosition().getLng()
			},
			roadview : {
				viewpoint : dMap.roadview.getViewpoint(),
				str : dMap.roadview.getViewpoint().toString()
			}
		}
		//console.log(dMap.infomation);
	},
	setAddress : function(addr) {
		$('#pac_input').val(addr);
	},
	setZone : function(addr) {
		var zoneSel = document.getElementById('pac_zone');
		for (var i in Zone) {
			if (addr.indexOf(Zone[i]+' ') > -1) {
				zoneSel.value = i;
			}
			
		}
	},
	ps : null,
	placeOverlay : null,
	currCategory : 'AC5',
	setCategory : function() {
		$('#roadviewControl').css('display','none');
		dMap.placeOverlay = new daum.maps.CustomOverlay({zIndex:1});
		dMap.marker = [];
		
		dMap.mapOptions.center = new daum.maps.LatLng(Geo.Lat, Geo.Lng);
		//dMap.mapOptions.center = new daum.maps.LatLng(37.534624, 127.006884);
		dMap.map = new daum.maps.Map(dMap.mapCont, dMap.mapOptions);
		dMap.map.addControl(dMap.typeControl, daum.maps.ControlPosition.TOPRIGHT);
		dMap.map.addControl(dMap.zoomControl, daum.maps.ControlPosition.RIGHT);
		dMap.ps = new daum.maps.services.Places(dMap.map);
		
		daum.maps.event.addListener(dMap.map, 'idle', dMap.searchPlaces);
		dMap.searchPlaces();
		
	},
	searchPlaces : function() {
		dMap.ps.categorySearch(dMap.currCategory, dMap.placesSearch, {useMapBounds:true});
	},
	placesSearch : function(status, data, pagination) {
		if (status == daum.maps.services.Status.OK) {
			dMap.displayPlaces(data.places);
		}
	},
	displayPlaces: function(places) {
		// 지도에 표시되고 있는 마커를 제거합니다
		dMap.removeMarker();
	
		for ( var i=0; i<places.length; i++ ) {
	
				// 마커를 생성하고 지도에 표시합니다
				var marker = dMap.addMarker(new daum.maps.LatLng(places[i].latitude, places[i].longitude));
	
				// 마커와 검색결과 항목을 클릭 했을 때
				// 장소정보를 표출하도록 클릭 이벤트를 등록합니다
				(function(marker, place) {
					daum.maps.event.addListener(marker, 'click', function() {
						dMap.displayPlaceInfo(place);
					});
				})(marker, places[i]);
		}
	},
	removeMarker: function() {
		for ( var i = 0; i < dMap.marker.length; i++ ) {
			dMap.marker[i].setMap(null);
		}   
		dMap.marker = [];
	},
	addMarker : function(position) {
		
		var imageSrc = "http://i1.daumcdn.net/localimg/localimages/07/2012/img/marker_p.png";
		var imageSize = new daum.maps.Size(40, 42);
		var imgOptions = {
            offset : new daum.maps.Point(14, 30), // 스프라이트 이미지 중 사용할 영역의 좌상단 좌표
		};
		var markerImage = new daum.maps.MarkerImage(imageSrc, imageSize, imgOptions);
        var marker = new daum.maps.Marker({
            position: position, // 마커의 위치
            image: markerImage 
        });
		marker.setMap(dMap.map); // 지도 위에 마커를 표출합니다
		dMap.marker.push(marker);  // 배열에 생성된 마커를 추가합니다
	
		return marker;
	},
	displayPlaceInfo : function(place) {
		var content = '<div class="placeinfo_wrap">' + 
                        '   <div class="placeinfo">' +
						
                        '       <a class="title" href="' + place.placeUrl + '" target="_blank" title="' + place.title + '">' + place.title + '</a>' +   
						' 		<a href="javascript:;" onclick="dMap.hidePlaceInfo()" style="position:absolute;  display:block; right:0px; line-height:36px; font-size:26px; height:36px; width:20px; top:0px">&times;</a>	';		

		if (place.newAddress) {
			content += '        <span title="' + place.newAddress + '">' + place.newAddress + '</span>' +
							 '      <span class="jibun" title="' + place.address + '">(지번 : ' + place.address + ')</span>';
		}  else {
			content += '        <span title="' + place.address + '">' + place.address + '</span>';
		}                
	   
		content += '        <span class="tel">' + place.phone + '</span>' + 
						'   </div>' + 
						'   <div class="after"></div>' +
						'</div>';
	
		dMap.placeOverlay.setContent(content);
		dMap.placeOverlay.setPosition(new daum.maps.LatLng(place.latitude, place.longitude));
		dMap.placeOverlay.setMap(dMap.map);
	},
	hidePlaceInfo : function() {
		dMap.placeOverlay.setMap(null);
	}
}

var Geo = {
	Lat : null,
	Lng : null,
	getGeo : function() {
		window.navigator.geolocation.getCurrentPosition(Geo.getLocation, Geo.errLocation);
	},
	getLocation : function(event) {
		var latitude = event.coords.latitude;
		var longitude = event.coords.longitude;
		Geo.Lat = latitude;
		Geo.Lng = longitude;
		//console.log(event);
		dMap.setCategory();
		
	},
	errLocation : function(event) {
		//console.log(event)
		Geo.Lat = 37.48034;
		Geo.Lng = 126.88319;
		dMap.setCategory();
	}
}

$(document).ready(function(e) {
		
	$('#pac_input').keydown(function(e) {
		if(e.keyCode == 13 ) {
			e.preventDefault();
			dMap.setGeocoder(this.value);
		}
	});	
	$('#pac_button').click(function(e) {
		e.preventDefault();
		if ($('#pac_input').val().length > 0) {
			dMap.setGeocoder($('#pac_input').val());
		} else {
			alert('지도 검색어를 입력하세요.');
		}
	});
	$('#roadviewControl').click(function(e) {
		dMap.toggleRoadviewRoad();
	});
	$('#rvClose').click(function(e) {
		dMap.toggleRoadviewRoad();
	});
	$('#pac_title').change(function(e) {
		dMap.setInfoWindow(this.value);
	});
	
});