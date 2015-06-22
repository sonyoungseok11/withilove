// trim 
String.prototype.trim = function() {
	return str = this.replace(/^(\s|&nbsp;)*|(\s|&nbsp;)*$/gi, "");
} 

// 쿠키 세팅
function setCookie(name, value, expiredays ){ 
	var todayDate = new Date(); 
	todayDate.setDate( todayDate.getDate() + expiredays ); 
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";" ;
}

// SMS 매니저 
var sms_manager = {
	obj : null,
	target : null,
	user_list : null,
	user_total : null,
	user_count : 0,
	bytes : 0,
	sms_bottom : null,
	sms_total_count : null,
	page : new Object(),
	
	clear : function() {
		this.user_list.html('');
		this.user_total.text(this.user_count);
		this.set_bytes();
		this.user_count = 0;
		this.get_sms_preset(1);
		this.getTotalCount();
	},
	getTotalCount : function() {
		$.ajax({
			url : g_root + '/inc/ajax.php',
			type : 'POST',
			dataType:"json",
			data : {
				'mode' : 'getSmsTotalCount'
			},
			success: function(data) {
				//console.log(data);
				sms_manager.sms_total_count.text(data.count);
			}
		});
	},
	setPresetList : function(data) {
		var len = data.length;
		var target = this.sms_bottom;
		var ul = $("<ul></ul>").addClass('sms_text_preset').appendTo(target);
		for (var i=0; i<len ; i++) {
			var li = $('<li></li>').appendTo(ul);
			var div = $('<div></div>').appendTo(li).addClass('preset').text(data[i].sText);
			var a1 = $('<a></a>').attr({'href' : '#'}).addClass('jButton').addClass('small').text('선택').button().appendTo(li).click(function(e) {
				e.preventDefault();
				$('#SMS_TEXT').val($(this).prev().text());
				sms_manager.set_bytes();
			});
			var a2 = $('<a></a>').attr({'href' : '#', 'data-id' : data[i].id}).addClass('jButton').addClass('small').text('삭제').button().appendTo(li).click(function(e) {
				e.preventDefault();
				var cmd = confirm('프리셋을 삭제 하시겠습니까?');
				if (cmd) {
					$.ajax({
						url : g_root + "/inc/ajax.php",
						type: 'post',
						data : {
							mode : 'sms_preset_delete',
							id : $(this).attr('data-id')
						},
						success: function(data) {
							sms_manager.get_sms_preset(sms_manager.page.current_page);
						}
					});
				}
			});
		}
	},
	set_smsPresetPage : function() {
		var target = this.sms_bottom;
		var page = this.page;
		//console.log(page);
		var div = $('<div></div>').appendTo(target).addClass('preset_nav');
		if (page.page_list > 0) {
			var prev_page = page.page_list * 10
			var input1 = $('<input>').attr({'type':'radio','name':'page', 'id' : 'prev_page'}).val(prev_page).appendTo(div);
			var label1 = $('<label></label>').attr('for','prev_page').text('◀').appendTo(div);
		}
		var page_end = (page.page_list+1) * 10
		var last_page = page.total_page;
		if (page_end > page.total_page) {
			page_end = page.total_page
		}
		for (var setpage=page.page_list*10+1 ; setpage<=page_end; setpage++) {
			var input = $('<input>').attr({'type':'radio','name':'page', 'id' : 'page'+setpage}).val(setpage).appendTo(div);
			var label = $('<label></label>').attr('for','page'+setpage).text(setpage).appendTo(div);
			if (setpage == page.current_page) {
				input.prop('checked', true);
			}
		}
		if (page_end < page.total_page) {
			var next_page = (page.page_list+1) * 10+1;
			var input1 = $('<input>').attr({'type':'radio','name':'page', 'id' : 'next_page'}).val(next_page).appendTo(div);
			var label1 = $('<label></label>').attr('for','next_page').text('▶').appendTo(div);
		}
		div.buttonset().find('input').change(function(){
			sms_manager.get_sms_preset($(this).val());
		});
	},
	get_sms_preset : function(page) {
		var target = this.sms_bottom;
		target.html('');
		target.addClass('loader');
		$.ajax({
			url : g_root + "/inc/ajax.php",
			type : 'POST',
			dataType : 'json',
			data : {
				'mode' : 'get_sms_preset',
				'page' : page,
				'count' : '4'
			},success: function(data) {
				//console.log(data);
				target.removeClass('loader');
				sms_manager.page = data.page;
				sms_manager.setPresetList(data.set);
				sms_manager.set_smsPresetPage();
			}
		});
	},
	getCheckGroup : function() {
		var checkbox = sms_manager.target.find('.checkGroup:checked');
		var idArr = new Array();
		var noMem = new Array();
		checkbox.each(function(idx, el) {
			if (el.value > 0) {
				idArr[idArr.length] = el.value;
			} else {
				var tr = $(el).closest('tr');
				switch (location.pathname) {
					case '/manager/schedule/education.php' :
						var str = tr.find('td').eq(4).text();
						noMem[idx] = {
							name : str.replace(/\(.*\)/, ''),
							hp : tr.find('td').eq(5).text()
						}
						break;
					case '/manager/town/town_list.php':
					case '/manager/town/town_standby.php':
						noMem[idx] = {
							name : tr.find('td').eq(4).text(),
							hp: tr.find('td').eq(5).text()
						}
						break;
				}
			}
		});
		//console.log(noMem);
		if (idArr.length > 0) {
			$.ajax({
				url : g_root + '/inc/ajax.php',
				type : 'post',
				dataType:"json",
				data : {
					'mode' : 'getSmsCheckGroup',
					'idArr' : idArr
				},
				success: function(data) {
					//console.log(data)
					sms_manager.userListSet(data);
				}
			});
		}
		
		sms_manager.userListSet(noMem);
	},
	sms_text_len : function(str) {
		var i;
		var msglen=0;
		for(i=0;i< str.length ;i++){
			var ch = str.charAt(i);
			if(escape(ch).length >4){
				msglen += 2;
			}else{
				msglen++;
			}
		}
		return msglen;
	},
	insert_preset: function(el) {
		var text = $('#SMS_TEXT').val();
		var sms_len = this.sms_text_len(text);
		if (sms_len == 0) {
			alert('문자 메시지를 입력하세요.');
			return;
		}
		if (sms_len > 80) {
			alert ('문자 메시지는 90bytes 이하로 작성하세요.');
			return;
		}
		
		$(el).hide();
		var loader = $('<span></span>').css({'display':'inline-block', 'text-align':'center' , 'width': $(el).width()}).insertAfter($(el));
		var img = $('<img>').attr('src', g_root+'/images/ajax-loader2.gif').appendTo(loader);
		$.ajax({
			url : g_root + "/inc/ajax.php",
			type : 'post',
			data : {
				'mode' : 'insert_sms_preset',
				'sText' : text
			},
			success: function(data) {
				//console.log(data);
				sms_manager.get_sms_preset(sms_manager.page.current_page);
				loader.remove();
				$(el).show();
			}
		})
	},
	set_bytes : function() {
		var text = $('#SMS_TEXT').val();
		var sms_len = this.sms_text_len(text);
		this.bytes.text(sms_len+"/80");
	},
	setText_name : function() {
		var text = $('#SMS_TEXT').val();
		text = '{name}님'+text;
		$('#SMS_TEXT').val(text);
		this.set_bytes();
	},
	insert_user : function(name, hp) {
		this.user_count++;
		this.user_total.text(this.user_count);
		
		var li = $('<li></li>').appendTo(this.user_list);
		var div1 = $('<div></div>').addClass('name').text(name).appendTo(li);
		var div2 = $('<div></div>').addClass('hp').text(hp).appendTo(li);
		var a = $('<a></a>').addClass('jButton').addClass('small').text('삭제').appendTo(li).click(function(e) {
			e.preventDefault();
			li.remove();
			sms_manager.user_count--;
			sms_manager.user_total.text(sms_manager.user_count);
		}).button();
	},
	userListSet : function(data) {
		var i, len;
		for (var i in data) {
			this.insert_user(data[i].name, data[i].hp);
		}
	},
	insert_user_check : function() {
		var validate = false;
		var name = $('#smsAddName').val();
		var hp = $('#smsAddHp').val();
		if (name.length > 0) {
			validate = check_reg($('#smsAddHp')[0], RegEx_Tel, '올바른 전화번호를 입력하세요.');
		} else {
			error_msg_bubble( $('#smsAddName')[0],'이름을 입력하세요.');
		}
		
		if(validate) {
			sms_manager.insert_user(name, hp);
			$('#smsAddName').val('');
			$('#smsAddHp').val('');
		}
		
		return false;
	},
	open : function (el) {
		this.obj = $('#SMS_Manager');
		this.target = $(el).closest('table');
		this.user_list = this.obj.find('.user_list');
		this.user_total = this.obj.find('.user_total');
		this.bytes = this.obj.find('.bytes');
		this.sms_bottom = this.obj.find('.sms_bottom');
		this.sms_total_count = this.obj.find('.sms_total_count');
		
		this.clear();
		
		this.getCheckGroup();
		
		this.obj.dialog('open');
	},
	send : function(el) {
		var list = this.user_list.find('li');
		if (list.length == 0) {
			alert('받는 사람이 없습니다.');
			return;
		}
		var text = $('#SMS_TEXT').val();
		var sms_len = this.sms_text_len(text);
		if (sms_len == 0) {
			alert('문자 메시지를 입력하세요.');
			return;
		}
		if (sms_len > 90) {
			alert ('문자 메시지는 80bytes 이하로 작성하세요.');
			return;
		}
		
		var arr = new Array();
		list.each(function(idx,el){
			var name = $(el).find('.name').text();
			var hp = $(el).find('.hp').text();
			arr[idx] = hp + '|' + name.trim();
		});
		el.hide()
		var loader = $('<span></span>').css({'display':'inline-block', 'text-align':'center' , 'width': el.width()}).insertAfter(el);
		var img = $('<img>').attr('src', g_root+'/images/ajax-loader2.gif').appendTo(loader);
		$.ajax({
			url : g_root + '/inc/ajax.php',
			type : 'POST',
			dataType:"json",
			data : {
				'mode' : 'manager_sms_send',
				'data' : arr,
				'msg' : text
			},
			success: function(Data) {
				//console.log(Data);
				el.show();
				loader.remove();
				if (Data.result=='success') {
					alert(arr.length + '명에게 문자를 발송하였습니다.');
					sms_manager.sms_total_count.text(Data.count);
				} else {
					alert('문자를 발송에 실패하였습니다.');
				}
			}
		});
	}
}

/* 사이트 텝 네비게이션  */
var SiteTab = function (tab) {
	//console.log(tab)
	var tab = $(tab);
	var li = tab.children('li');
	var len = li.length;
	li.css('width', tab.width()/len);
	var contents_id = new Array();
	
	var all_hide = function() {
		for(var i=0; i<len; i++) {
			contents_id[i] = '#' + li.eq(i).find('a').attr('href');
			$(contents_id[i]).css('display','none');
		}
		tab.find('.selected').removeClass('selected');
	}
	
	this.show = function(str) {
		var href = str.replace('#','');
		li.find('a[href="'+ href +'"]').click();
		//li.eq(n).find('a').click();
	}
	
	li.children('a').click(function(e) {
		e.preventDefault();
		all_hide();
		var href = '#' + $(this).attr('href')
		$(href).css('display','block');
		$(this).addClass('selected');
	});
	
	this.show('#sub1');
}
/* //사이트 텝 네비게이션  */
/* tab list */
jQuery(function($){
	// List Tab Navigation
	var tab_list = $('div.tab.list');
	var tab_list_i = tab_list.find('>ul>li');
	tab_list.removeClass('jx');
	if($(document).width()<=640){
		tab_list.addClass('jx');	
	}
	$(window).resize(function(){
		if($(document).width()<=640){
		tab_list.addClass('jx');
		tab_list.css('height','auto');
		} else {
		tab_list.removeClass('jx');
		tab_list.css('height', tab_list.find('>ul>li.active>ul').height()+40);
		}
	});
	tab_list_i.find('>ul').hide();
	tab_list.find('>ul>li[class=active]').find('>ul').show();
	if (!tab_list.hasClass('jx')){
		tab_list.css('height', tab_list.find('>ul>li.active>ul').height()+40);
	} else {
		tab_list.css('height','auto');
	}
	function listTabMenuToggle(event){
		if (!tab_list.hasClass('jx')){
			var t = $(this);
			tab_list_i.find('>ul').hide();
			t.next('ul').show();
			tab_list_i.removeClass('active');
			t.parent('li').addClass('active');
			tab_list.css('height', t.next('ul').height()+40);
			return false;
		}
	}
	tab_list_i.find('>a[href=#]').click(listTabMenuToggle).focus(listTabMenuToggle);
});

// 얼럿메시지 (타이틀, 메시지(html)
function alertMsg(title,msg) {
	$('#Alert_Msg').parent().find('.ui-dialog-title').text(title);
	$('#Alert_Msg').html(msg);
	$('#Alert_Msg').dialog('open');
}

// 얼럿메시지 (타이틀, 메시지(html)
function goBackMsg(title,msg) {
	$('#Back_Msg').parent().find('.ui-dialog-title').text(title);
	$('#Back_Msg').html(msg);
	$('#Back_Msg').dialog('open');
}

//서브페이지 내용이 적어도 화면꽉차게 나오게 하기
function subcontentHeight() {
	var gh =$('.gnb').height();
	var nh =$('.navi').height();
	var sh =$('.shortcut_menu').height();
	var ph =$('.partnership').height();
	var ch =$('.copyright').height();
	var wh =$(window).height();
	$('.sub_content').css('min-height', wh-gh-nh-sh-ph-ch);
}

//게시판 파일 다운로드 함수
function filedownload(id) {
	var form = $('<form></form>');
	var action = g_root+"/board/download.php";
	var input = $('<input>')
	input.attr('type','hidden');
	input.attr('name', 'file_id');
	input.val(id);
	form.append(input);
	
	form.attr('action', action);
	form.attr('method','post');
	$('body').append(form);
	form.submit();
	form.remove();
}

/* 3단 체크 위에 아래 선택 함수 */
function prevCheckDepth(el) {
	var prev = new Object();
	try {
		prev.el = el.closest('tr').prev('tr').find('input[class^=checkDepth]');
		prev.iDepth = prev.el.attr('class').substr(-1,1);
		prev.prop = prev.el.prop('checked');
	} catch (e) {
		prev = false;
	}
	return prev;
}
function nextCheckDepth(el) {
	var next = new Object();
	try {
		next.el = el.closest('tr').next('tr').find('input[class^=checkDepth]');
		next.iDepth = next.el.attr('class').substr(-1,1);
		next.prop = next.el.prop('checked');
	} catch (e) {
		next = false;
	}
	return next;
}
/* //3단 체크 위에 아래 선택 함수 */

// 게시판 목록 체크 삭제
function board_check_delete() {
	var checklen = $('input[class^=checkDepth]:checked').length;
	if (!checklen) {
		alertMsg('게시물 삭제','한개이상 선택하셔야 합니다.');
		return false;
	}
	var validate = confirm('선택목록을 삭제 하시겠습니까?')
	if (validate) {
		$('.board_check_del').submit();
	}
}
// 회원등급이상 사용 알림
function needMember() {
	alertMsg('안내','<div style="padding-top:10px; line-height:20px;">비회원 또는 회원레벨이 낮아 사용할 수 없습니다.</div>');
}

var Wishlist = {
	insert : function(board_config_id, board_table, board_id, user_id, type, el) {
		var loader = $('<img>').attr('src',g_root+'/images/ajax-loader.gif');
		$(el).hide().after(loader);
		$.ajax({
			url : g_root + '/board/board_proc.php',
			type : 'POST',
			dataType: "json",
			data : {
				'mode' : 'Wishlist_insert',
				'board_config_id' : board_config_id,
				'board_table' : board_table,
				'board_id' : board_id,
				'user_id' : user_id,
				'eWishType' : type
			},
			success: function(data) {
				//console.log(data);
				//console.log($(el).parent()[0].nodeName);
				if (data.result == 'Y') {
					if ($(el).parent()[0].nodeName == 'TD') {
						var matchStr = $(el).closest('tr').find('.subject a').text().match(/(.+( ~ .+)?\)) (.+)/);
						var msg = '<div style="padding:8px">' + matchStr[1] + '<br />' + matchStr[3] + '<br/><br/>';
					} else {
						if ($('h4').length) {
							var matchStr = $('.read_table h4').text().match(/제목 : (.+) \[ (.+) \]/);
							var msg = '<div style="padding:8px">' + matchStr[2] + '<br />' + matchStr[1] + '<br/><br/>';
						} else {
							var matchStr = $(el).closest('.item').find('.subject a').text().match(/(.+) \((.+( ~ .+)?\))\)/);
							//console.log(matchStr);
							var msg = matchStr[1] + '\n' + matchStr[2] + '\n\n';
						}
					}
					
					switch (type) {
						case 'HOBBY' :
							msg += '관심일정으로 등록하였습니다.<br /><br />신청내역은 마이페이지에서 확인 하실 수 있습니다.</div>';
							alertMsg('알림',msg);
							$(el).next('img').remove();
							if ($(el).parent()[0].nodeName == 'TD') {
								$(el).closest('tr').find('.ask a').attr({'onclick' : 'Wishlist.update("'+ data.id +'", "ASK", this);'});
							} else {
								$('.ask a').attr({'onclick' : 'Wishlist.update("'+ data.id +'", "ASK", this);'});
							}
							$(el).remove();
							break;
						case 'ASK' :
							msg += '신청 완료 하였습니다.<br /><br />신청내역은 마이페이지에서 확인 하실 수 있습니다.</div>';
							if ($(el).parent()[0].nodeName == 'TD') {
								$(el).closest('tr').find('.hobby a').remove();
							} else {
								$('.hobby a').remove();
							}
							alertMsg('알림',msg);
							$(el).next('img').remove();
							$(el).remove();
							break;
					}
				} else {
					alertMsg('에러','등록에 실패하였습니다.');
					$(el).show();
					$(el).next('img').remove();
				}
			}
		});
	},
	update : function(wish_id, type, el) {
		var loader = $('<img>').attr('src',g_root+'/images/ajax-loader.gif');
		$(el).hide().after(loader);
		$.ajax({
			url : g_root + '/board/board_proc.php',
			type : 'POST',
			data : {
				'mode' : 'Wishlist_update',
				'wish_id' : wish_id,
				'eWishType' : type
			},
			success: function(t) {
				//console.log(t);
				if(t == 'Y') {
					if ($(el).parent()[0].nodeName == 'TD') {
						var matchStr = $(el).closest('tr').find('.subject a').text().match(/(.+( ~ .+)?\)) (.+)/);
						//console.log(matchStr);
						var msg = '<div style="padding:8px">' + matchStr[1] + '<br />' + matchStr[3] + '<br/><br/>';
						$(el).closest('tr').find('.hobby a').remove();
					} else {
						if ($('h4').length) {
							var matchStr = $('h4').text().match(/제목 : (.+) \[ (.+) \]/);
							var msg = '<div style="padding:8px">' + matchStr[2] + '<br />' + matchStr[1] + '<br/><br/>';
							$('.hobby a').remove();
						}else {
							var matchStr = $(el).closest('.item').find('.subject a').text().match(/(.+) \((.+( ~ .+)?\))\)/);
							//console.log(matchStr);
							var msg = matchStr[1] + '\n' + matchStr[2] + '\n\n';
						}
					}
					alertMsg('알림',msg);
					$(el).next('img').remove();
					$(el).remove();
				} else {
					alertMsg('에러','등록에 실패하였습니다.');
					$(el).show();
					$(el).next('img').remove();
				}
			}
		});
	},
	user_update : function(wish_id, type, el) {
		var loader = $('<img>').attr('src',g_root+'/images/ajax-loader.gif');
		$(el).hide().after(loader);
		$.ajax({
			url : g_root + '/board/board_proc.php',
			type : 'POST',
			data : {
				'mode' : 'Wishlist_update',
				'wish_id' : wish_id,
				'eWishType' : type
			},
			success: function(t) {
				if(t == 'Y') {
					var subject = $(el).closest('tr').find('td:first').text();
					msg = subject + '\n\n신청 하였습니다.<br /><br />신청내역은 마이페이지에서 확인 하실 수 있습니다.';
					alert(msg);
					location.href= g_root + "/sub_etc/member/confirm_course.php";
				} else {
					alertMsg('에러','취소에 실패하였습니다.');
					$(el).show();
					$(el).next('img').remove();
				}
			}
		});
	},
	del : function(wish_id, el) {
		var loader = $('<img>').attr('src',g_root+'/images/ajax-loader.gif');
		$(el).hide().after(loader);
		
		$.ajax({
			url : g_root + '/board/board_proc.php',
			type : 'POST',
			data : {
				'mode' : 'Wishlist_del',
				'wish_id' : wish_id
			},
			success: function(t) {
				if(t == 'Y') {
					if ($(el).parent()[0].nodeName == 'TD') {
						var matchStr = $(el).closest('tr').find('.subject a').text().match(/(.+( ~ .+)?\)) (.+)/);
						var msg = matchStr[1] + '\n' + matchStr[3] + '\n\n';
					} else  {
						if ($('h4').length) {
							var matchStr = $('h4').text().match(/제목 : (.+) \[ (.+) \]/);
							var msg = matchStr[2] + '\n' + matchStr[1] + '\n\n';
						} else {
							var matchStr = $(el).closest('.item').find('.subject a').text().match(/(.+) \((.+( ~ .+)?\))\)/);
							var msg = matchStr[1] + '\n' + matchStr[2] + '\n\n';
						}
					}
					var td = $(el).parent();
					if (td.hasClass('hobby')) {
						msg += '관심일정을 취소 하였습니다.';
					} else if (td.hasClass('ask')) {
						msg += '신청 취소 하였습니다.';
					}
					alert(msg);
					location.reload();
				} else {
					alertMsg('에러','취소에 실패하였습니다.');
					$(el).show();
					$(el).next('img').remove();
				}
			}
		});
	},
	user_del : function(wish_id, el) {
		if(confirm('신청하신 내역을 수정하시겠습니까?')) {
			var loader = $('<img>').attr('src',g_root+'/images/ajax-loader.gif');
			$(el).hide().after(loader);
			$.ajax({
				url : g_root + '/board/board_proc.php',
				type : 'POST',
				data : {
					'mode' : 'Wishlist_del',
					'wish_id' : wish_id
				},
				success: function(t) {
					if(t == 'Y') {
						var subject = $(el).closest('tr').find('td:first').text();
						msg = subject + '\n\n수정 하였습니다.';
						alert(msg);
						location.reload();
					} else {
						alertMsg('에러','수정에 실패하였습니다.');
						$(el).show();
						$(el).next('img').remove();
					}
				}
			});
		}
	},
	nomember_insert : function(board_id, el) {
		var dialog = $('#Education_Nomember_Ask');
		//dialog.dialog('open');
		dialog.next().find('button').eq(0).css({'position':'absolute','left':'20px'});
		dialog.next().find('button').eq(1).css({'position':'absolute','left':'107px'});
		dialog.next().find('button').eq(2).css({'font-weight': 'bold', 'border' : '2px solid #7aa6ec'});
		if ($(el).parent()[0].nodeName == 'TD') {
			var matchStr = $(el).closest('tr').find('.subject a').text().match(/(.+( ~ .+)?\)) (.+)/);
			var title = matchStr[1] + '[' + matchStr[3] + ']';
		} else  {
			if ($('h4').length) {
				var matchStr = $('h4').text().match(/제목 : (.+) \[ (.+) \]/);
				var title = matchStr[1] + '[' + matchStr[2] + ']';
			} else {
				var matchStr = $(el).closest('.item').find('.subject a').text().match(/(.+) \((.+( ~ .+)?\))\)/);
				var title = matchStr[1] + '[' + matchStr[2] + ']';
			}
		}
		dialog.find('.title').text(title);
		dialog.find('input[name="board_id"]').val(board_id);
		dialog.dialog('open');
	},
	nomember_end : function() {
		var dialog = $('#Education_Nomember_Ask');
		var msg = dialog.find('.title').text()  + '<br /><br /> 신청 완료 하였습니다.<br /><br />세미나 관련 문의는 02-6433-6001로 연락 주시기 바랍니다.';
		dialog.dialog('close');
		alertMsg('알림',msg);
	}
}
// 디알로그 프린트 함수
function dialog_print(el) {
	var body_temp = document.body.innerHTML;
	var target = $(el).closest('.ui-dialog').clone();
	target.css({'left':'0px', 'top':'0px'}).find('.ui-dialog-buttonpane').css('display','none');
	target.find('.ui-dialog-titlebar-close').css('display','none');
	
	window.open('', 'print' , 'width=700, height=600, left=10, top=10');
	var form = $('<form></form>').attr({'action' : g_root + '/inc/print.php', 'method' : 'post', 'target' :'print' }).appendTo('body');
	var input = $('<input>').attr({'type':'hidden','name':'print'}).val(target[0].outerHTML).appendTo(form);
	form.submit();
}

/* 협력업체 관련 함수 */
Cooperative = {
	NewInsert : function(eType, iSort) {
		var form = $('<form></form>').attr({'action' : g_root+'/manager/cooperative/cooperative_write.php', 'method' : 'post' }).appendTo('body');
		var input1 = $('<input>').attr({'type':'hidden', 'name':'mode'}).val('I').appendTo(form);
		var input2 = $('<input>').attr({'type':'hidden', 'name':'eType'}).val(eType).appendTo(form);
		var input3 = $('<input>').attr({'type':'hidden', 'name':'iSort'}).val(iSort).appendTo(form);
		form.submit();
	},
	ShowDetail : function(id) {
		$.ajax({
			url : g_root + '/inc/ajax.php',
			type : 'post',
			dataType: "json",
			data : {
				'mode' : 'getCooperative',
				'id' : id
			},
			success: function(data) {
				//console.log(data);
				Cooperative.setLogo(data.L);
				Cooperative.setImgs(data.P);
				Cooperative.setContens(data.contents);
				$('#CooperativeDetail').prev('div').css('display','none');
				$('#CooperativeDetail').dialog('open');
			}
			
		});
	},
	Modify : function(id) {
		var form = $('<form></form>').attr({'action' : g_root+'/manager/cooperative/cooperative_write.php', 'method' : 'post' }).appendTo('body');
		var input1 = $('<input>').attr({'type':'hidden', 'name':'mode'}).val('M').appendTo(form);
		var input2 = $('<input>').attr({'type':'hidden', 'name':'id'}).val(id).appendTo(form);
		form.submit();
	},
	Del : function(id) {
		if (confirm('업체를 삭제 하시겠습니까?')) {
			var form = $('<form></form>').attr({'action' : g_root+'/manager/cooperative/cooperative_proc.php', 'method' : 'post' }).appendTo('body');
			var input1 = $('<input>').attr({'type':'hidden', 'name':'mode'}).val('D').appendTo(form);
			var input2 = $('<input>').attr({'type':'hidden', 'name':'id'}).val(id).appendTo(form);
			form.submit();
		}
	},
	setLogo : function(img) {
		//console.log(img);
		var logo = $('#CooperativeDetail').find('.logo');
		logo.css({'background-image':'url(' + g_root+ img.sPath + '/'+ img.sFile +')'});
		
	},
	setImgs : function(img) {
		//console.log(img);
		var box = $('#CooperativeDetail').find('.imgbox');
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
		Cooperative.playImgset(box);
	},
	playImgset : function(box) {
		var li =  box.find('li');
		var a = box.find('a');
		li.css('display','none');
		li.eq(0).css('display','block').addClass('on');
		a.eq(0).addClass('on');
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
	setContens : function(data) {
		//console.log(data);
		var cont = $('#CooperativeDetail').find('.content');
		cont.find('.title').html(data.sTitle + ' <span>' + data.sTitleSubfix + '</span>');
		cont.find('.home').html('<a href="'+data.sUrl +'" target="_blank" onclick="Cooperative.countUpdate('+data.id+');">'+ data.sUrl +'</a>');
		cont.find('.phone').html(data.sTel);
		cont.find('.address').html(data.sAddr + ' ' + data.sAddrSub);
		cont.find('.comment').text(data.sContents);
		var manager = $('#CooperativeDetail').find('.manager');
		manager.html('');
		if (data.admin) {
			$('<a></a>').attr({'href':'javascript:;','onclick': 'Cooperative.Modify('+ data.id +')'}).text('수정').addClass('jButton').addClass('small').button().appendTo(manager);
		}
		if (data.admin || data.manager) {
			$('<span></span>').text(' 링크제공횟수 : ' + data.iCount+ '회').appendTo(manager);
		}
	},
	countUpdate : function(id) {
		$.ajax({
			url : g_root+ '/inc/ajax.php',
			type : 'post',
			data : {
				'mode' : 'CooperativeUpdateCount',
				'id' : id
			},
			success: function(text) {
				//console.log(text);
			}
		});
	},
	reSort : function() {
		document.sort_change.submit();
	}
};

// 리스너 등록
$(document).ready(function(e) {
	//dialog_open 클래스 클릭시 href 이름의 팝업을 띄움
	$('body').delegate('.dialog_open','click',function(e) {
		e.preventDefault();
		var openrId = $(this).attr('href');
		$('#'+openrId).dialog('open');
	});
	// 상단 로그인 버튼 클릭시 로그인 레이어를 보여줌
	$('.text_login').click(function(e) {
		e.preventDefault();
		$('.outlogin_layer').slideToggle('fast');
	});	
	
	// 현제 디알로그 닫기
	$('body').delegate('.dialog_close', 'click', function(e) {
		e.preventDefault();
		$(this).closest('.ui-dialog-content').dialog('close');
	});
	
	//상단 메뉴 드롭다운
	$('.navi').find('div[class^=menu]>a').on('mouseenter',function(e){
		//console.log($('.navi').find('.selected').length);
		if ($('.navi').find('.selected').length) {
				if ($(this).hasClass('selected')){
				var selected = $('.navi').find('.selected');
				var me = $(this);
				selected.removeClass('selected');
				me.addClass('select');
				$('.navi').find('.submenu').stop(true,true);
				$(this).parent().find('.submenu').slideDown('fast');
				$(this).parent().on('mouseleave', function(e){
					$(this).find('.submenu').slideUp('fast');
					me.removeClass('select');
					selected.addClass('selected');
				});
			}
		} else {
			var me = $(this);
			me.addClass('select');
			$('.navi').find('.submenu').stop(true,true);
			$(this).parent().find('.submenu').slideDown('fast');
			$(this).parent().on('mouseleave', function(e){
				$(this).find('.submenu').slideUp('fast');
				me.removeClass('select');
			});
		}
	});
	
	// 서브페이지 높이 조절
	$(window).on('resize',function() {
		subcontentHeight();
	});
	
	/*sendpost 클래스가 있는 링크는 form을 만들어 post로 링크시킴*/
	$('a.sendpost').click(function(e) {
		e.preventDefault();
		var form = $('<form></form>');
		var arr = $(this).attr('href').split('?');
		var action = arr[0];
		var values = arr[1].split('&');
		var len = values.length;
		for(var i=0; i<len ; i++ ) {
			if(values[i] == '') {
				continue;
			}
			var valarr = values[i].split('=');
			var input = $('<input>')
			input.attr('type','hidden');
			input.attr('name', valarr[0]);
			input.val(valarr[1]);
			form.append(input);
		}
		form.attr('action', action);
		form.attr('method','post');
		$('body').append(form);
		form.submit();
	});
	//게시판 글쓰기 파일 추가 버튼 액션
	$('.fileinsert').click(function(e) {
		e.preventDefault();
		var uploadCount = $('#iUploadCount').text();
		var inputCount = $(this).parent().find('input[name="file[]"]').length;
		inputCount += $(this).parent().find('.delfile').length
		if (uploadCount > inputCount) {
			var input = $('<input>');
			input.attr({
				'type' : 'file',
				'name' : 'file[]'
			});
			$(this).parent().append(input);
		}
	});
	
	// 게시판 글 수정에서 파일 삭제 기능
	$('.delFile').click(function(e) {
		e.preventDefault()
		var file_id = $(this).attr('href');
		var parent = $(this).closest('li');
		var input = $('<input>')
		input.attr('type','hidden');
		input.attr('name', 'delfile[]');
		input.val(file_id);
		parent.append(input);
		$(this).parent().remove();
		if (!parent.find('input[type="file"]').length) {
			var file = $('<input>').attr({'type' : 'file','name' : 'file[]'}).appendTo(parent);
		}
		
	});
	
	/* 1단 모든 체크 */
	$('body').delegate('.allCheck','change', function(e) {
		var checks = $(this).closest('div').find('.checkGroup');
		if (checks.length == 0) {
			checks = $(this).closest('table').find('.checkGroup');
		}
		checks.prop('checked', $(this).prop('checked'));
	});
	$('.checkGroup').change(function(e) {
		var checks = $(this).closest('div').find('.checkGroup');
		var checked = $(this).closest('div').find('.checkGroup:checked');
		if (checks.length == checked.length) {
			$(this).closest('div').find('.allCheck').prop('checked', true);
		} else {
			$(this).closest('div').find('.allCheck').prop('checked', false);
		}
	});
	/* //1단 모든 체크 */
	
	/* 3단 모든 체크 */
	$('.allCheckDepth2').change(function(e) {
		var checks = $(this).closest('form').find('input[class^=checkDepth]');
		checks.prop('checked', $(this).prop('checked'));
	});
	$('input[class^=checkDepth]').change(function(e) {
		var me = new Object();
		var prev = new Object();
		var next = new Object();
		
		me.iDepth = $(this).attr('class').substr(-1,1);
		me.prop = $(this).prop('checked');
	
		next = nextCheckDepth($(this));
		while(next && me.iDepth < next.iDepth) {
			next.el.prop('checked', me.prop);
			next = nextCheckDepth(next.el);
		}
		
		prev = prevCheckDepth($(this));
		if (!me.prop) {
			while(prev && true) {
				if(me.iDepth > prev.iDepth) {
					prev.el.prop('checked', me.prop);
					me.iDepth --;
				}
				if (prev.iDepth == 0) {
					break;
				}
				prev = prevCheckDepth($(prev.el));
			}
		}
		
	});
	/* //3단 모든 체크 */
	/* 게시판 비밀글 보기 클릭(비번입력창띄우기) */
	$('.boardsecretview').click(function(e) {
		e.preventDefault();
		$('.bubble').remove();
		var span = $('<span></span>');
		span.addClass('bubble gray');
		span.html('<span style="font-size:12px;">비밀번호:</span> <input type="password" id="secretPw" size="8" style="height:12px; line-height:12px; font-size:12px;" /> <span class="button small" style="postion:relative; top:7px;"><a href="#" class="boardsecretok">확인</a></span> <span class="button small" style="postion:relative; top:7px;"><a href="#" class="boardsecretcancle">취소</a></span>');
		var offset_top = $(this).context.offsetTop + $(this).height();
		var offset_left = $(this).context.offsetLeft;
		span.css({'top' : offset_top , 'left' : offset_left, 'z-index' : '100' })
		$(this).parent().append(span);
		
	});
	$('body').delegate('.boardsecretok','click',function(e){
		e.preventDefault();
		var href = $(this).closest('div').find('a.boardsecretview').attr('href');
		var id_arr = href.split(',');
		var target_id = id_arr[0];
		var source_id = id_arr[1];
		var table = id_arr[2];
		var pw = $(this).closest('div').find('input[type="password"]').val();
		var page = $('.page').find('b').text();
		$.ajax({
			url : g_root + "/inc/ajax.php",
			type: 'POST',
			dataType:"json",
			data: {
				'mode' : 'boardSecretPwCheck',
				'id' : source_id,
				'pw' : pw,
				'table' : table
			},
			success: function(data) {
				//console.log(data);
				if (data.pass == 'Y') {
					var inputs = new Array();
					var form = $('<form></form>').attr({action : location.href,method : 'post'});
					inputs[0] = $('<input>').attr({type:'hidden', name:'mode', value:'R'});
					inputs[1] = $('<input>').attr({type:'hidden', name:'page', value:page});
					inputs[2] = $('<input>').attr({type:'hidden', name:'id', value:target_id});
					inputs[3] = $('<input>').attr({type:'hidden', name:'source_id', value:source_id});
					inputs[4] = $('<input>').attr({type:'hidden', name:'source_pw', value: data.pw});
					var len = inputs.length;
					for (var i=0; i<len; i++) {
						form.append(inputs[i]);
					}
					$('body').append(form);
					form.submit();
				} else {
					alert ('비밀번호가 맞지 않습니다.');
				}
			}
			
		});
		
	});
	$('body').delegate('.boardsecretcancle','click',function(e){
		e.preventDefault();
		$('.bubble').remove();
	});
	/* //게시판 비밀글 보기 클릭(비번입력창띄우기) */
	
	/* 덧글 수정 */
	$('body').delegate('.reply_modify','click',function(e) {
		e.preventDefault();
		var li = $(this).closest('li');
		var source = li.find('.reply_comment').text();
		var href = $(this).attr('href');
		var id_arr = href.split(',');
		//console.log(id_arr);
		var form = $('<form></form>');
		form.attr({
			action : g_root +'/board/board_proc.php',
			method : 'post',
			class : 'check_form',
			onsubmit : 'return check_form(this)'
		});
		
		form.html("<input type=\"hidden\" name=\"returnUrl\" value=\"" + location.href + "\" /><input type=\"hidden\" name=\"mode\" value=\"reply_M\" /> <input type=\"hidden\" name=\"reply_id\" value=\"" + id_arr[0] + "\" /> <input type=\"hidden\" name=\"board_id\" value=\""+ id_arr[1] +"\" /> <textarea name=\"sComment\" class=\"check_text\">"+ source + "</textarea><input type=\"submit\" value=\"덧글수정\" class=\"msButton medium blue reply_write_btn\"/>");
		
		li.children('*').remove();
		li.text('');
		li.append(form);
	});
	// 주소검색버튼 눌르면 팝업 열어주기
	$('.search_zipcode').click(function(e) {
		$('#Search_ZipCode').dialog('open');
	});
	
	$('.jButton').button();
	
	$('body').delegate('select', 'change', function(e) {
		var me = $(this);
		var value = $(this).val();
		$(this).find('option').removeAttr('selected');
		$(this).find('option').each(function(idx, el) {
			if (el.value == value) {
				$(el).attr('selected','selected');
				me.val(value);
			}
		});
	});
	// 셀렉트 선택시 바로 폼 서밋
	$(".auto_submit_select").change(function(e) {
		$(this).closest('form').submit();
	});
	
	$('.mb_length').keyup(function(e) {
		var txt_len = sms_manager.sms_text_len(this.value)
		$('.mb_length_view').text(txt_len + '/80');
	});
});


