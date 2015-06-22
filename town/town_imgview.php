<style>
#TownImgView .imgBox {text-align:center;}
#TownImgView .imgBox ul {height:500px; width:500px; margin:0px auto;}
#TownImgView .imgBox li {height:500px; background-repeat:no-repeat; background-position:center center; width:500px; position:absolute;}
#TownImgView .imgBox a {display:inline-block; height:100px; width:100px; margin:10px 6px 0px;  background-repeat:no-repeat; background-position:center center;}
#TownImgView .imgBox a.on,
#TownImgView .imgBox a:hover {outline:5px solid #4383fc;}
</style>
<div id="TownImgView" title="학원 이미지 상세 보기">
	<div class="imgBox"></div>
</div>

<script type="text/javascript">
$('#TownImgView').dialog({
	autoOpen : false,
	modal : true,
	resizable: false,
	width : 600,
	height : 666,
	show: {
        effect: "fade",
        duration: 300
      },
      hide: {
        effect: "fade",
        duration: 300
      }
});

Town = {
	viewImg : function(id, v) {
		$.ajax({
			url : g_root+"/town/town_ajax.php",
			type : 'POST',
			dataType:"json",
			data : {
				'mode' : 'viewImg',
				'id' : id
			},
			success: function(data) {
				console.log(data);
				Town.setImgs(data,v);
				$('#TownImgView').dialog('open');
			}
		});
	},
	setImgs : function(img,v) {
		//console.log(img);
		var box = $('#TownImgView').find('.imgBox');
		box.html('');
		var ul = $('<ul></ul>').appendTo(box);
		var len = img.length;
		for (var i=0; i<len; i++) {
			var file = img[i].sPath + '/' + img[i].sFile;
			var thumb = img[i].sPath + '/thumb/' + img[i].sFile;
			var li = $('<li></li>').css('background-image', 'url('+ file +')').appendTo(ul);
			var a = $('<a></a>').attr('href','#').css('background-image', 'url('+ thumb +')');
			if (i==0) {
				a.addClass('first');
			}
			a.appendTo(box);
		}
		Town.playImgset(box,v);
	},
	playImgset : function(box, v) {
		var li =  box.find('li');
		var a = box.find('a');
		li.css('display','none');
		var num = v ? v : 0;
		li.eq(num).css('display','block').addClass('on');
		a.eq(num).addClass('on');
		a.click(function(e){
			e.preventDefault();
			if ($(this).hasClass('on')) {
				return;
			}
			var idx = $(this).index()-1;
			box.find('li.on').fadeOut(300).removeClass('on');
			li.eq(idx).fadeIn(300).addClass('on');
			box.find('a.on').removeClass('on')
			$(this).addClass('on');
			//console.log(box);
		});
	},
	id : null,
	Modify : function(id) {
		Town.id = id;
		$('#mod_text').fadeToggle(300);
	},
	ModValid : function() {
		var pw = $('#Town_modpw').val();
		var id = Town.id;
		$.ajax({
			url : g_root+"/town/town_ajax.php",
			type : 'POST',
			data : {
				'mode' : 'town_compare_password',
				'id' : id,
				'pw' : pw
			},
			success: function(data) {
				console.log(data);
				if (data == 'Y') {
					var form = $('<form></form>').attr({'action':'town_write.php','method':'post'}).appendTo('body');
					var Input1 = $('<input>').attr({'type':'hidden','name':'mode',}).val('M').appendTo(form);
					var Input2 = $('<input>').attr({'type':'hidden','name':'id',}).val(id).appendTo(form);
					var Input2 = $('<input>').attr({'type':'hidden','name':'pw',}).val(pw).appendTo(form);
					form.submit();
					
				} else {
					alert('비밀번호가 맞지 않습니다.');
				}
			}
		});
	},
	filePlus : function(e) {
		e.preventDefault();
		var parent = $(e.target).closest('li');
		var files = parent.find('input[type="file"]');
		var preview = parent.find('.imgpreview');
		var cnt = files.length + preview.length;
		if (cnt < dMap.FILEMAX) {
			$("<input>").attr({'type':'file', 'name' : 'files[]','accept':'image/*'}).appendTo(parent);
		} else {
			alert('학원 이미지는 최대 '+ dMap.FILEMAX +'개 입니다.');
		}
	},
	fileMinus : function(e) {
		e.preventDefault();
		var parent = $(e.target).closest('li');
		var files = parent.find('input[type="file"]');
		var cnt = files.length
		if (cnt > 1) {
			files.eq(cnt-1).remove();
		}
	},
	delfile : function(e, id) {
		var ok = confirm('첨부이미지를 삭제 하시겠습니까?');
		if (ok) {
			var me = $(e.target).closest('a');
			var parent = $(e.target).closest('li');
			var files = parent.find('input[type="file"]');
			var cnt = files.length;
			var input = $('<input>').attr({'type':'hidden','name':'delfile[]'}).val(id).appendTo(parent);
			$(me).remove();
			if (cnt == 0) {
				$("<input>").attr({'type':'file', 'name' : 'files[]','accept':'image/*'}).appendTo(parent);
			}
		}
	},
	active: function(id, act) {
		$.ajax({
			url : g_root+"/town/town_ajax.php",
			type: 'post',
			data : {
				'mode' : 'active_change',
				'id' : id,
				'iActive' : act
			},
			success: function(text) {
				var msg = act==1 ? '등록' : '대기';
				if (text == 'Y') {
					alert(msg+' 상태로 변경되었습니다.');
					location.reload();
				} else {
					alert(msg+' 상태 변경이 실패하였습니다.');
				}
			}
		});
	},
	delTown : function(id) {
		var valid = confirm('학원을 삭제 하시면 절대 복원되지 않습니다.\n\n학원을 삭제 하시겠습니까?');
		if (valid) {
			$.ajax({
				url : g_root+"/town/town_ajax.php",
				type : 'post',
				data : {
					'mode' : 'delete_town',
					'id' : id
				},
				success: function(text) {
					if(text == 'Y') {
						location.reload();
					} else {
						alert("학원 삭제에 실패하였습니다.")
					}
				}
			});
		}
	},
	setGroup2 : function (target, data) {
		//console.log(data);
		target.find('option').remove();
		$('<option></option>').val('').text('과목 - 전체').appendTo(target);
		for (var i in data) {
			$('<option></option>').val(data[i]).text(i).appendTo(target);
		}
		
	},
	setSelect : function (target, data, mode) {
		target.find('option').remove();
		var title = mode=='getDong' ? '읍면동 - 전체' : '시군구 - 전체';
		$('<option></option>').val('').text(title).appendTo(target);
		for (var i in data) {
			$('<option></option>').val(data[i]).text(data[i]).appendTo(target);
		}
	}
}
$(document).ready(function(e) {
	$('#Town_modpw').keydown(function(e) {
		if(e.keyCode == 13 ) {
			e.preventDefault();
			Town.ModValid();
		}
	});
	$('#mod_text a').click(function(e) {
		e.preventDefault();
		Town.ModValid();
	});
	
	$('.town_group1').change(function(e) {
		var target = $('.town_group2');
		target.find('option').remove();
		$('<option></option>').text('loading...').appendTo(target);
		var id= this.value;
		$.ajax({
			url : g_root + '/town/town_ajax.php',
			type: 'POST',
			dataType:"json",
			data : {
				'mode' : 'getGroup2',
				'id' : id
			},
			success: function(data) {
				Town.setGroup2(target, data.group);
			}
		});
	});
	
	$('.town_zone1').change(function(e) {
		var table = $(this).val();
		var mode;
		var sigun = null;
		var target = $('.town_zone2');
		
		
		if (table == 'zip_sejong') {
			target.css('display','none');
			target = $('.town_zone3');
			mode = 'getDong';
		} else {
			target.css('display','');
			mode = 'getSigun';
		}
		var title1 = '시군구 - 전체';
		var title2 = '읍면동 - 전체';
		target.find('option').remove();
		$('.town_zone3').find('option').remove();
		$('<option></option>').val('').text(title2).appendTo($('.town_zone3'));
		if (table) {
			$('<option></option>').text('loading...').appendTo(target);
			$.ajax({
				url : g_root + '/town/town_ajax.php',
				type: 'POST',
				dataType:"json",
				data : {
					'mode' : mode,
					'table' : table,
					'sigun' : sigun
				},
				success: function(data) {
					console.log(data);
					Town.setSelect(target, data, mode);
				}
			});
		} else {
			$('<option></option>').val('').text(title1).appendTo(target);
			$('.town_zone3').find('option').remove();
			$('<option></option>').val('').text(title2).appendTo($('.town_zone3'));
		}
		
	});
	
	$('.town_zone2').change(function(e){
		var table = $('.town_zone1').val();
		var mode = 'getDong';
		var sigun = $(this).val();
		var target = $('.town_zone3');
		var title = '읍면동 - 전체';
		target.find('option').remove();
		if (sigun) {
			$('<option></option>').text('loading...').appendTo(target);
			$.ajax({
				url : g_root + '/town/town_ajax.php',
				type: 'POST',
				dataType:"json",
				data : {
					'mode' : mode,
					'table' : table,
					'sigun' : sigun
				},
				success: function(data) {
					console.log(data);
					Town.setSelect(target, data, mode);
				}
			});
		} else {
			$('<option></option>').val('').text(title).appendTo(target);
		}
		
	});
});
</script>