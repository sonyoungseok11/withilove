// JavaScript Document
function getLevelOption(target, value) {
	for (var i=1; i<=10; i++) {
		var opt = $('<option></option>').val(i).text(i).appendTo(target);
		if (i == value) {
			opt.attr('selected','selected');
		}
	}
}

// 회원목록 - 신규회원등록
function user_insert_dialog() {
	$('#UserModify').closest('.ui-dialog').find('.ui-dialog-buttonset button:last').css('display','none');
	$('#UserModify input[type="text"], #UserModify input[type="password"], #UserModify input[type="hidden"]').val('');
	$('#UserModify input[type="radio"]:first').prop('checked', true);
	$('#UserModify input[type="checkbox"]').prop('checked', false);
	$('#UserModify input[name="mode"]').val('I');
	$('#UserModify .passInfo').hide();
	var sUserId = $('#UserModify input[name="sUserId"]');
	sUserId.removeAttr('readonly');
	sUserId.addClass('check_id').addClass('JIT_idoverlap');
	$('#UserModify input[type="password"]').removeClass('change_pw');
	
	$('#UserModify .user_form').css('display','block');
	$('#UserModify .ajax_loader').css('display','none');
	$('#UserModify').dialog('open');
}
// 회원목록 회원정보수정
function user_modify_dialog(id) {
	$('#UserModify').closest('.ui-dialog').find('.ui-dialog-buttonset button:last').css({'display':'inline', 'position': 'absolute' ,'left': '20px'});
	$('#UserModify input[name="mode"]').val('M');
	var sUserId = $('#UserModify input[name="sUserId"]');
	sUserId.attr('readonly','readonly');
	sUserId.removeClass('check_id').removeClass('JIT_idoverlap');
	$('#UserModify input[type="password"]').addClass('change_pw');
	$('#UserModify .passInfo').show();
	$('#UserModify .user_form').css('display','none');
	$('#UserModify .ajax_loader').css('display','block');
	$('#UserModify').dialog('open');
	$.ajax({
		url : g_root + '/inc/manager_ajax.php',
		type : 'post',
		dataType:"json",
		data : {
			mode : 'UserModify',
			'id' : id
		},
		success: function(USER) {
			console.log(USER);
			var form = $('#UserModify').find('form');
			setFormData(USER, form);
			$('#UserModify .user_form').css('display','block');
			$('#UserModify .ajax_loader').css('display','none');
		}
	});
}
// 받은 데이터를 폼값에 세팅
function setFormData(Data, form) {
	for (var key in Data) {
		var nPos = form.find('*[name="' + key + '"]');
		try {
			switch (nPos[0].nodeName) {
				case 'INPUT':
					//console.log(nPos.attr('type'));
					switch (nPos.attr('type')) {
						case 'radio':
							nPos.each(function(idx,el){
								if (el.value == Data[key]) {
									$(el).prop('checked', true);
								} else {
									$(el).prop('checked', false);	
								}
							});
							break;
						case 'checkbox' :
							if(Data[key] == 'Y') {
								nPos.prop('checked', true);
							} else {
								nPos.prop('checked', false);	
							}
							break;
						default  :
							nPos.val(Data[key]);
							break;
					}
					break;
				case 'SELECT' :
					nPos.find('option').each(function(idx, el){
						if (el.value == Data[key]) {
							$(el).attr('selected',"selected");
						} else {
							$(el).removeAttr('selected');
						}
					});
					break;
			}
				
		} catch(e) {
		}
	}
}




// table to excel
var table2XLS = {
	target : null,
	name : null,
	action : function() {
		this.target.find('.blind').remove();
		var tr = this.target.find('tr');
		//console.log(tr);
		var data = {
			title : new Array(),
			row : new Array()
		}
		tr.each(function(idx, items){
			var td = $(items).find('td');
			if (!td.length) {
				td = $(items).find('th');
				td.each(function(i, th) {
					data.title[i] = $(th).text();
				});
			} else {
				data.row[data.row.length] = new Array();
				td.each(function(i, td) {
					if ($(td).find('select').length == 1) {
						data.row[data.row.length-1][i] = $(td).find('select option:selected').text();
					} else {
						data.row[data.row.length-1][i] = $(td).text();
					}
				});
			}
		});
		var form = $('<form></form>').attr({'action' : g_root+'/inc/xls.php', 'method':'post'}).appendTo('body');
		var input = $('<input>').attr({'type':'hidden', 'name': 'fname', 'value': this.name}).appendTo(form);
		var input1 = $('<input>').attr({'type':'hidden', 'name': 'title', 'value': data.title}).appendTo(form);
		for (var idx in data.row) {
			var input2 =  $('<input>').attr({'type':'hidden', 'name': 'row[]', 'value': data.row[idx]}).appendTo(form);
		}
		form.submit();
		form.remove();
	},
	get_name : function() {
		console.log(location);
		var arr = location.pathname.split('/');
		this.name = arr[arr.length-1].replace(/\..+/,'');
	},
	download_this_table : function(el) {
		this.target = $(el).closest('table').clone();
		this.get_name();
		this.action();
	},
	download_target_table : function(id) {
		var id = '#'+id;
		this.target = $(id).clone();
		this.get_name();
		this.action();
	}
}

/*협력업체 관련 함수*/
function search_member(smode) {
	$('#Search_Mebmber').find('input[name="search_mode"]').val(smode);
	$('#Search_Mebmber').dialog('open');
}

function memberSelect(uid, sUserId, sUserName, dialog) {
	$('input[name="user_id"]').val(uid);
	$('input[name="user_Name"]').val(sUserName+'['+sUserId+']');
	$('#'+dialog).dialog('close');
}

function delfile_cooperative(mode, id, el) {
	var action = confirm('이미지를 삭제 하시겠습니까?');
	if (!action) {
		return;
	}
	var li = $(el).closest('li');
	var img = $(el).prev('img');
	var form_file = null;
	switch (mode) {
		case 'L':
			form_file = $('<input>').attr({'type':'file','name':'file_logo','id':'file_logo'}).addClass('check_length');
			break;
		case 'B':
			form_file = $('<input>').attr({'type':'file','name':'file_banner','id':'file_banner'}).addClass('check_length');
			break;
		case 'P':
			form_file = $('<input>').attr({'type':'file','name':'file_img[]'}).addClass('block');
			break;
	}
	var hidden = $('<input>').attr({'type' : 'hidden', 'name': 'delfile[]'}).val(id).appendTo(li);
	$(el).after(form_file);
	$(el).remove();
	img.remove();
	
}


$(document).ready(function(e) {
	
	
	$(".tableSort > table").tablesorter();
	
});