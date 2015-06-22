// JavaScript Document
// 폼에 숫자만 입력가능 el은  jqeury 셀렉트로 보냄
/*
function numeric(el){
	el.keydown(function(e)
	{
		// 키입력에 사용되는 몇몇 키는 허용..delete, backspace, esc 등등
		if (e.keyCode==46 || e.keyCode==8 || e.keyCode==9 || e.keyCode==27 || e.keyCode==13 || (e.keyCode==65 && e.ctrlKey===true) || (e.keyCode>=35 && e.keyCode<=39)){
		  return;
		} else {
			if(e.shiftKey || (e.keyCode<48 || e.keyCode>57) && (e.keyCode<96 || e.keyCode>105)) {
			 //모바일 IE 브라우저의 경우 문자입력시 빈값이 남는다
				 if($(this).val().length == 0) {
					 $(this).val('');
				 }
				 //모바일 크롬 브라우저의 경우 특수문자가 다 0으로 넘어오고  e.preventDefault(); 이벤트 실행이 안되는 버그수정
				 if(e.keyCode == 0) {
					 $(this).val('');
				 } else {
				 e.preventDefault();
		 		 }
			}
		}
	});
}
*/

var RegEx_Email = /^([a-z0-9]+)([._-]([0-9a-z_-]+))*@([a-z0-9]+)([._-]([0-9a-z]+))*([.]([a-z0-9]+){2,4})$/;
var RegEx_Id = /^[a-z0-9-_]{6,20}$/;
var RegEx_Tel = /^0[\d]{1,2}-[\d]{3,4}-[\d]{4}$/;
var RegEx_Zipcode = /^[\d]{3}-[\d]{3}$/;
var RegEx_Zipcode_suffix = /\([\d]+∼[\d]+.*\)$|[\d]+∼[\d]+$|\d+$/;
var RegEx_Zipcode_suffix2 = /(^.+\s\d+(-\d+)?)(\s.*)$/;

var RegEx_Ymd =/[\d]{4}-[\d]{1,2}-[\d]{1,2}/;

// 주소 결과값을 결과 창에 넣기
function add_search_zip_result(target, data, type) {
	var li= $('<li></li>');
	var span = $('<span></span>').addClass('sZip').text(data.zipcode).appendTo(li);
	var span2 = $('<span></span>').addClass('sAddr').text(data.addr).appendTo(li);
	var span3 = $('<span></span>').addClass('button').addClass('medium').appendTo(li);
	//console.log(type);
	if (type == 'old') {
		var button = $('<button></button>').addClass('zipResultBtn').text('선택').appendTo(span3);
	} else {
		var button = $('<button></button>').addClass('zipResultBtn2').text('선택').appendTo(span3);
	}
	li.appendTo(target);
}

function add_search_zip_result_new(target, data, type) {
	var doro = '';
	var li =$('<li></li>');
	var span = $('<span></span>').addClass('sZip').text(data.zipcode).appendTo(li);
	var span2 = $('<div></div>').addClass('sZibun').text(data.zibun).appendTo(li);
	if (data.addr_sub == "()") {
		doro = data.doro;
	} else {
		doro = data.doro + ' ' + data.addr_sub;
	}
	var span2 = $('<div></div>').addClass('sDoro').text(doro).appendTo(li);
	var span3 = $('<span></span>').addClass('button').addClass('medium').appendTo(li);
	var button = $('<button></button>').attr({
		'data-zipcode': data.zipcode,
		'data-sido' : data.sSido,
		'data-sigun' : data.sSigun,
		'data-dong' : data.sDong + data.sEupmyon,
		'data-doro' : data.doro,
		'data-addr_sub' : data.addr_sub,
		'data-zibun' : data.zibun
	}).addClass('zipResultBtn_new').text('선택').appendTo(span3);
	
	li.appendTo(target);
}

function setComma(el) {
	el.val(el.val().replace(/[^\d]/gi,""));
	value = el.val();
	if (value.length >3) {
		value = number_format(value);
	}
	el.val(value);
}

function number_format(data) {
	var tmp = '';
	var number = '';
	var cutlen = 3;
	var comma = ',';
	var i;
   
	len = data.length;
	mod = (len % cutlen);
	k = cutlen - mod;
	for (i=0; i<data.length; i++) 
	{
		number = number + data.charAt(i);
		
		if (i < data.length - 1) 
		{
			k++;
			if ((k % cutlen) == 0) 
			{
				number = number + comma;
				k = 0;
			}
		}
	}
	return number;
}

// 숫자만입력받기
function onlyNumber(el) {
	el.val(el.val().replace(/[^\d]/gi,""));
}

// 전화번호 형식 입력
function AutoHyphen(InputData){
	Inputdata = InputData.replace(/[^\d]/gi,"");
	if(Inputdata.substring(0,2)=="02"){
		if(Inputdata.length > 9){
			Inputdata = Inputdata.substring(0,2)+"-"+Inputdata.substring(2,6)+"-"+Inputdata.substring(6,10);
		}else if(Inputdata.length > 5){
			Inputdata = Inputdata.substring(0,2)+"-"+Inputdata.substring(2,5)+"-"+Inputdata.substring(5,9);
		}else{
			Inputdata = Inputdata.substring(0,2)+"-"+Inputdata.substring(2);
		}
	}else{
		if(Inputdata.length > 10){
			Inputdata = Inputdata.substring(0,3)+"-"+Inputdata.substring(3,7)+"-"+Inputdata.substring(7,11);
		}else if(Inputdata.length > 6){
			Inputdata = Inputdata.substring(0,3)+"-"+Inputdata.substring(3,6)+"-"+Inputdata.substring(6,10);
		}else if(Inputdata.length > 3){
			Inputdata = Inputdata.substring(0,3)+"-"+Inputdata.substring(3);
		}
	}
	return Inputdata;
}
// 날자형식 입력받기
function AutoHyphenYmd(InputData) {
	var In = InputData.replace(/[^\d]/g,'');
	var pattern = /^([\d]{4})([01]{0,1}[\d]{1})([\d]{1,2})(.*)/;
	var replce = "$1-$2-$3";
	In = In.replace( pattern, replce);
	return In;
}

// 아이디 중복검사 ajax
function JIT_id(e) {
	var str = $(e).val();
	var validate = false;
	var msg;
	if(RegEx_Id.test(str)) {
		$.ajax({
			url : g_root + '/inc/ajax.php',
			type : 'POST',
			async: false,
			data : {
				mode : 'id_overlap_check',
				sUserId : str
			},
			success: function(returnVal) {
				//console.log(returnVal);
				if (returnVal == "Y") {
					validate = true;
					msg = "사용가능 한 아이디 입니다.";
				} else {
					msg = "중복된 아이디 입니다.";
				}
			}
		});
	} else {
		msg = "사용할 수 없는 아이디 입니다.";
	}
	//console.log(msg);
	if(!validate) {
		JIT_msg_bubble(e,msg, 'bubble_jiterr');
	} else {
		JIT_msg_bubble(e,msg, 'bubble_jitok');
	}
	return validate;
}
/* 풍선말 **/
// 실시간검사 풍선 도움말 표시
function JIT_msg_bubble(el, msg, cl) {
	var JIT_timer;
	e = $(el);
	e.addClass('jitOk');
	var span = $('<span></span>');
	span.addClass(cl);
	span.text(msg);
	span.css({'top' : e.context.offsetTop + -30 , 'left' : e.context.offsetLeft, 'z-index' : '100' })
	span.appendTo(e.parent());
	e.keydown(function(e){
		$('.'+cl).remove();
		clearInterval(JIT_timer);
	});
	JIT_timer = setInterval(function() {
		$('.'+cl).remove();
		clearInterval(JIT_timer);
	},3000);
}
// 풍선도움말 오류 메시지
function error_msg_bubble(el, msg) {
	e = $(el);
	e.addClass('err');
	var span = $('<span></span>');
	span.addClass('bubble_err');
	span.text(msg);
	span.css({'top' : e.context.offsetTop + e.height()+10 , 'left' : e.context.offsetLeft, 'z-index' : '100' })
	span.appendTo(e.parent());
	e.on('blur', function(e){
		error_msg_hide();
	});
}
// 풍선도움말 숨기기
function error_msg_hide() {
	var check = $('.bubble_err').parent().find('*[class^="check"]');
	check.removeClass('err');
	$('.bubble_err').remove();
}
/* //풍선말 **/

// 폼전송전 전화번호 확인 검사
function check_reg(e, RegEx, msg) {
	var value = $(e).val();
	var validate = false;
	if (RegEx.test(value)) {
		validate = true;
	} 
	if(!validate) {
		error_msg_bubble(e, msg);
	}
	return validate;
}

// 아이디 정규식 검사 및 ajax 중복검사 폼전송전 다시 한번 검사
function check_id(e) {
	var str = $(e).val();
	var validate = false;
	var msg;
	if(RegEx_Id.test(str)) {
		$.ajax({
			url : g_root + '/inc/ajax.php',
			type : 'POST',
			async: false,
			data : {
				mode : 'id_overlap_check',
				sUserId : str
			},
			success: function(returnVal) {
				//console.log(returnVal);
				if (returnVal == "Y") {
					validate = true;
				} else {
					msg = "중복된 아이디 입니다.";
				}
			}
		});
	} else {
		msg = "사용할 수 없는 아이디 입니다.";
	}
	if(!validate) {
		error_msg_bubble(e,msg);
	}
	return validate;
}

// 폼 값 길이 검사 함수
function check_length(e ,v_min, v_max) {
	var str = $(e).val();
	var validate = false;
	var msg;
	var len = str.length;
	if(v_min > 0) {
		if(v_max > 0) {
			if(len >= v_min && len <= v_max) {
				validate = true;
			} else {
				msg = v_min + "자 이상 " + v_max + "자 이하 입력.";
			}
		} else {
			if(len >= v_min) {
				validate = true;
			} else {
				msg = "글 내용을 작성하셔야 합니다.";
			}
		}
	} else {
		if(len > v_min) {
			validate = true;
		} else {
			msg = $(e).closest('li').find('label:first').text() + ' 항목은 필수 입력입니다.';
		}
	}
	
	if (!validate) {
		error_msg_bubble(e,msg);
	}
	//console.log(validate);
	return validate;
}
// 폼 전송전 비밀번호 확인 검사
function comp_password(e) {
	var validate = false;
	var msg;
	var pw = $(e).closest('form').find('.check_pw');
	var pw2 = $(e);
	if (pw.val() == pw2.val()) {
		validate = true;
	} else {
		pw2.val('').removeClass('validate');
		pw.val('').removeClass('validate');
		msg = '비밀번호 확인 오류입니다.';
		error_msg_bubble(pw[0],msg);
	}
	//console.log(validate);
	return validate;
}

// 폼서밋 전 필수 체크박스 체크
function check_checkbox(e) {
	var checked = $(e).prop('checked');
	if (!checked) {
		error_msg_bubble(e, '필수 체크입니다.');
	}
	return checked;
}
// 폼서밋 전 필수 셀렉트 박스를 검사한다.
function check_select(e){
	var validate = false;
	
	var selected = $(e).find('option:selected').val();
	if(selected.length) {
		validate = true;
	} else {
		error_msg_bubble(e, '필수 선택입니다.');
	}
	return validate;
}

function check_smsconfirm(e) {
	var validate = false;
	if ($(e).val() == 'Y') {
		validate = true;
	} else {
		var target = $(e).closest('li').find('.send_sms_confirm')[0];
		error_msg_bubble(target,'휴대폰 인증 필수 입니다.');
	}
	return validate;
}
//폼서밋을 하기전 유효성 검사를 분류 검사 한다.
function form_submit(form) {
	var required = form.find('*[class^=check]').not('.validate');
	var validate = true;
	required.each(function(idx, el){
		validate = validate && check_Validate(el);
	});
	
	//console.log(validate);
	if(validate) {
		form.submit();
	}
}
// 폼 전송 함수
function check_form(e) {
	var required = $(e).find('*[class^=check]').not('.validate');
	var validate = true;
	required.each(function(idx, el){
		validate = validate && check_Validate(el);
	});
	return validate;
}
// 폼 전송 ajax 함수
function check_form_ajax(e) {
	var required = $(e).find('*[class^=check]').not('.validate');
	var validate = true;
	required.each(function(idx, el){
		validate = validate && check_Validate(el);
	});
	if (validate) {
		var action = $(e).attr('action');
		switch (action) {
			case 'search_PW' :
				var loader = $('#RESETPASSWORD .ajax_loader');
				var result = $('#RESETPASSWORD .ajax_result');
				break;
			default :
				var loader = $(e).find('.ajax_loader');
				var result = $(e).find('.result');
				break;
		}
		loader.html('<img src="'+ g_path +'/images/ajax-loader.gif" />');
		
		var data = get_ajax_data($(e).find('*[name]'));
		$.ajax({
			url : g_path + '/inc/ajax.php',
			type: 'POST',
			dataType:"json",
			data : {
				'mode' : action,
				'data' : data
			},
			success: function(DATA) {
				success_form_ajax(DATA, loader, result);
			}
		});
	}
}

// 폼 값 유효 검사 후 리턴
function check_values(e) {
	var required = $(e).find('*[class^=check]').not('.validate');
	var validate = true;
	required.each(function(idx, el){
		validate = validate && check_Validate(el);
	});
	return validate;
}

function get_ajax_data(datas) {
	var len = datas.length;
	var Data = new Object();
	for (var i=0; i<len ; i++) {
		Data[$(datas[i]).attr('name')] = $(datas[i]).val();
	}
	return Data;
}

function success_form_ajax(data, loader, result) {
	loader.html('');
	result.html('');
	switch(data.mode) {
		case 'search_ID':
			if (data.cnt == 1) {
				result.text(data.sUserId);
			} else {
				result.html('<span style="color:red">일치하는 아이디가 없습니다.</span>');
			}
			break;
		case 'search_PW' :
			//console.log(data);
			loader.html(data.msg).css({'color':'red', 'font-size' : '11px'});
			if (data.valid) {
				$('#SearchIdPw .search_form2').css('display', 'none');
				loader.html(data.msg);
				var form = $('<form></form>').attr('action','change_password').addClass('check_form_ajax').appendTo(result);
				var input1 = $('<input>').attr({'type' : 'hidden', 'name' : 'sHphone', 'value' : data.sHphone}).appendTo(form);
				var input2 = $('<input>').attr({'type' : 'hidden', 'name' : 'id', 'value' : data.id}).appendTo(form);
				var ul = $('<ul></ul>').appendTo(form);
				var li3 = $('<li></li>').appendTo(ul);
				var label3 = $('<label></label>').attr('for','sUserPw').text('비밀번호').appendTo(li3);
				var input3 = $('<input>').attr({'type' : 'password', 'name' : 'sUserPw', 'id' : 'sUserPw'}).addClass('check_pw').appendTo(li3);
				var li4 = $('<li></li>').appendTo(ul);
				var label4 = $('<label></label>').attr('for','sUserPw2').text('비밀번호 확인').appendTo(li4);
				var input4 = $('<input>').attr({'type' : 'password', 'name' : 'sUserPw2', 'id' : 'sUserPw2'}).addClass('check_pw2').appendTo(li4);
				var div5 = $('<div></div>').css({'margin-top':'10px', 'text-align':'center'}).appendTo(form);
				var span5 = $('<span></span>').addClass('button').addClass('medium').appendTo(div5);
				var input5 = $('<input>').attr({'type':'submit', 'value':'비밀번호 변경'}).appendTo(span5);
				var div6 = $('<div></div>').addClass('result').css('text-align','center').appendTo(form);
				var span6 = $('<span></span>').addClass('ajax_loader').appendTo(div6);
			} 
			break;
		case 'change_password' :
			console.log(data);
			if (data.valid) {
				result.html('<span class="button medium"><a href="MemberJoin" class="dialog_open">비밀번호 변경 완료 - 로그인하러 가기</a></span>');
			} else {
				result.html('<span style="color:red">비밀번호 변경에 실패 하였습니다.</span>');
			}
			break;
		default:
			console.log(data);
			break;
			
	}
	
}


// 폼전송 검사 함수
function check_Validate(e) {
	var RegEx=/check_[a-z0-9]+/g;
	var check_name = $(e).attr('class').match(RegEx)[0];
	var value;
	var validate = false;
	value = $(e).val().trim();
	$(e).val(value);
//	console.log(check_name);
	switch (check_name) {
		case 'check_id' :
			validate = check_id(e);
			break;
		case 'check_pw' :
			if ($(e).hasClass('change_pw')) {
				var len = $(e).val();
				if (len) {
					validate = check_length(e, 6, 20);
				} else {
					validate = true;
				}
			} else {
				validate = check_length(e, 6, 20);
			}
			break;
		case 'check_pw2' :
			if ($(e).hasClass('change_pw')) {
				var len = $(e).val();
				var pw = $('.check_pw').val();
				if (len || pw.length) {
					validate = comp_password(e);
				} else {
					validate = true;
				}
			} else {
				validate = comp_password(e);
			}
			break;
		case 'check_text' :
			var ClearTimer ;
			var useEditor = false;
			if($(e).hasClass('ckeditor')) {  // ck에디터 사용이라면
				var value = CKEDITOR.instances.sComment.getData();
				useEditor = true;
			} else if($(e).hasClass('EXeditor')) {
				var value = $(e).EXeditor('getData');
				useEditor = true;
			} else if ($(e).hasClass('smarteditor')) {
				oEditors.getById["sComment"].exec("UPDATE_CONTENTS_FIELD", []);
				var value = document.getElementById("sComment").value;
				useEditor = true;
			}
			if (useEditor) {
				if (value.length < 4) {
					error_msg_bubble($(e).next()[0], '글 내용을 작성하셔야 합니다.');
					ClearTimer = setInterval(function(){
						$('.bubble_err').remove();
						clearInterval(ClearTimer);
					},5000);
					validate = false;
				} else {
					validate = true;
				}
			} else {
				validate = check_length(e,4,0);
			}
			break;
		case 'check_checkbox':
			validate = check_checkbox(e);
			break;
		case 'check_tel':
			validate = check_reg(e, RegEx_Tel, '올바른 전화번호를 입력하세요.');
			break;
		case 'check_email' :
			validate = check_reg(e, RegEx_Email, '올바른 이메일 주소를 입력하세요.');
			break;
		case 'check_zipcode':
			if ($(e).val().length) {
				validate = true;
			} else {
				validate = check_reg($(e).next('a.dialog_open')[0], RegEx_Zipcode, '우편번호 버튼을 클릭하여 주소를 입력하세요');
			}
			break;
		case 'check_select':
			validate = check_select(e);
			break;
		case 'check_smsconfirm':
			validate = check_smsconfirm(e);
			break;
		case 'check_ymd' :
			if ($(e).hasClass('nocheck') && $(e).val().length == 0) {
				validate = true;
			} else {
				validate = check_reg(e, RegEx_Ymd, '날자형식으로 입력하세요. YYYY-MM-DD');
			}
			break;
		default :
			validate = check_length(e, 0, 60000);
			break;
	}
	if (validate) {
		$(e).addClass('validate');
	}
	return validate;
}


$(document).ready(function(e) {
	// 전화번호 입력 이벤트 핸들러 등록
	$('body').delegate('.onlynumber','keyup', function(e) {onlyNumber($(this));});
	$('body').delegate('.setcomma','keyup', function(e) {setComma($(this));});
	$('.check_tel').keyup(function (e){
		$(this).val(AutoHyphen($(this).val()));
	});
	
	$('.check_ymd').keyup(function (e){
		$(this).val(AutoHyphenYmd($(this).val()));
	}).datepicker({'dateFormat':'yy-mm-dd'});

	$('body').delegate('input[title]','blur', function(e) {
		$('.bubble').remove();
	});
	
	// 폼전송 ajax
	$('body').delegate('.check_form_ajax','submit', function(e) {
		e.preventDefault();
		check_form_ajax(this);
	});
	
	// 유효성검사한 필드를 바꾸면 유효성검사를 다시한다.
	$('body').delegate('.validate','change', function(e){
		$(e.target).removeClass('validate');
		var RegEx=/check_[a-z0-9]+/g;
		var check_name = $(this).attr('class');
		check_name = check_name.match(RegEx)[0];
		check_name = check_name.replace('check_','');
		if(check_name.substr(0,2) == 'pw') {
			$('.check_pw, .check_pw2').removeClass('validate');
		}
	});
	
	$('body').delegate('input[title]:not(.err)','focus', function(e) {
		var el = $(e.target);
		var title = el.attr('title')
		var span = $('<span></span>');
		span.addClass('bubble');
		span.text(title);
		span.css({'top' : el.context.offsetTop + el.height()+10 , 'left' : el.context.offsetLeft, 'z-index' : '100' })
		span.appendTo(el.parent());
		
	});
	// 아이디 JIT 검사 이벤트 등록
	$('body').delegate('.JIT_idoverlap','change',function(e){
		JIT_id(this);
	});
	// 주소검색 하기
	$('.search_form').delegate('.zip_search_form','submit',function(e) {
		e.preventDefault();
		var target = $(this).closest('li').find('.zipResult');
		var type = $(this).find('input[name="searchmode"]').val();
		var searchStr = $(this).find('input[name="search"]').val();
		if (searchStr.length<1) {
			error_msg_bubble($(this).find('input[name="search"]')[0], '검색어를 입력하세요.');
			return;
		}
		target.html('<div style="text-align:center"><img src="' + g_root +'/images/ajax-loader.gif"></div>');
		$.ajax({
			url : g_root+ "/inc/ajax.php",
			type : 'POST',
			dataType:"json",
			data : {
				'mode' : 'searchZipCode',
				'searchType': type,
				'searchStr' : searchStr
			},
			success: function(Data) {
				//console.log(Data);
				target.html('');
				try {
					var len = Data.length;
				} catch(e) {
					len = 0;
				}
				if (len == 0) {
					target.html("<div style=\"text-align:center\">검색결과가 없습니다.</div>");
				} else {
					for(var i=0; i<len; i++) {
						add_search_zip_result(target, Data[i], type);
					}
				}
			}
		});
	});
	// 주소 선택시 해당 input 에 값을 넘기고 dialog를 닫음
	$('#Search_ZipCode').delegate('.zipResultBtn','click',function(e){
		e.preventDefault();
		var li = $(this).closest('li');
		var zip = li.find('.sZip').text();
		var addr = li.find('.sAddr').text();
		addr = addr.replace(RegEx_Zipcode_suffix,'').trim();
		$('input[name="sZipCode"]').val(zip);
		$('input[name="sAddr"]').val(addr);
		$('#Search_ZipCode').dialog('close');
		if(dMap){
			dMap.setAddress(addr);
			dMap.setGeocoder(addr);
			dMap.setZone(addr);
		}
	});
	
	// 주소 선택시 해당 input 에 값을 넘기고 dialog를 닫음
	$('#Search_ZipCode').delegate('.zipResultBtn2','click',function(e){
		e.preventDefault();
		var li = $(this).closest('li');
		var zip = li.find('.sZip').text();
		var addr = li.find('.sAddr').text();
		addr = addr.replace(RegEx_Zipcode_suffix2,'$1').trim();
		$('input[name="sZipCode"]').val(zip);
		$('input[name="sAddr"]').val(addr);
		$('#Search_ZipCode').dialog('close');
		if(dMap){
			dMap.setAddress(addr);
			dMap.setGeocoder(addr);
			dMap.setZone(addr);
		}
	});
	
	$('#Search_ZipCode_New').delegate('.zipResultBtn_new', 'click', function(e) {
		e.preventDefault();
		var me = $(this);
		var zip = {
			'zipcode' : me.attr('data-zipcode'),
			'sido' : me.attr('data-sido'),
			'sigun' : me.attr('data-sigun'),
			'dong' : me.attr('data-dong'),
			'doro' : me.attr('data-doro'),
			'addr_sub' : me.attr('data-addr_sub'),
			'zibun' : me.attr('data-zibun')
		}
		$('input[name="sZipCode"]').val(zip.zipcode);
		$('input[name="sAddr"]').val(zip.doro);
		$('input[name="sAddrSub"]').val(zip.addr_sub);
		try {
			if(dMap){
				$('input[name="sSido"]').val(zip.sido);
				$('input[name="sSigun"]').val(zip.sigun);
				$('input[name="sDong"]').val(zip.dong);
				dMap.setAddress(zip.doro);
				dMap.setGeocoder(zip.doro);
				dMap.setZone(zip.doro);
			}
		} catch(e) {}
		$('#Search_ZipCode_New').dialog('close');
	});
	
	// 주소검색 하기
	$('.search_form').delegate('.zip_search_form_new','submit',function(e) {
		e.preventDefault();
		var target = $(this).closest('li').find('.zipResult');
		var type = $(this).find('input[name="searchmode"]').val();
		var searchStr = $(this).find('input[name="search"]').val();
		var sido = $(this).find('select[name="sido"]').val();
		if (searchStr.length<1) {
			error_msg_bubble($(this).find('input[name="search"]')[0], '검색어를 입력하세요.');
			return;
		}
		target.html('<div style="text-align:center"><img src="' + g_root +'/images/ajax-loader.gif"></div>');
		$.ajax({
			url : g_root+ "/inc/ajax.php",
			type : 'POST',
			dataType:"json",
			data : {
				'mode' : 'searchZipCode_new',
				'searchType': type,
				'searchStr' : searchStr,
				'sido' : sido
			},
			success: function(Data) {
				console.log(Data);
				target.html('');
				try {
					var len = Data.length;
				} catch(e) {
					len = 0;
				}
				if (len == 0) {
					target.html("<div style=\"text-align:center\">검색결과가 없습니다.</div>");
				} else {
					
					for(var i=0; i<len; i++) {
						add_search_zip_result_new(target, Data[i], type);
					}
					
				}
			}
		});
	});
	
var sendSmsTime = 1;
/*  휴대폰 인증 문자 발송 */
	$('.send_sms_confirm').click(function(e){
		e.preventDefault();
		var me = $(this)
		if ($(this).hasClass('gray')) {
			return;
		}
		var telnum = $(this).closest('form').find('.sHphone');
		var smsMode = $(this).closest('form').find('.smsMode').val();
		var sms_confirm = $(this).closest('form').find('input[name="sms_confirm"]');
		var telnumvalue = telnum.val();
		var resultSpan = $('.confirm_ajax_loader');
		var target = $('.smslog_id');
		if (RegEx_Tel.test(telnumvalue)) {
			resultSpan.html("<img src=\""+ g_root +"/images/ajax-loader.gif\" style=\"position:relative; top:5px;\"/>");
			$.ajax({
				url : g_root + '/inc/ajax.php',
				type : 'POST',
				dataType:"json",
				data : {
					mode : 'send_sms_confirm',
					hp : telnumvalue,
					smsMode : smsMode
				},
				success: function(Data) {
					console.log(Data);
					if (Data.send == 'Y'){
						target.val(Data.id);
						if (Data.Result.result=='success') {
							resultSpan.html('인증문자를 발송하였습니다.');
						} else {
							resultSpan.html('문자를 발송에 실패하였습니다.');
						}
						me.text('인증 재전송 대기(30)');
						$('.post_sms_confirm').removeClass('gray');
						me.addClass('gray');
						sms_confirm.removeAttr('readonly');
						var sendSmsTimer = setInterval(function(){
							if (sendSmsTime > 29) {
								sendSmsTime = 1;
								me.removeClass('gray');
								me.text('인증문자 재전송');
								clearInterval(sendSmsTimer);
							} else {
								tvalue = "인증 재전송 대기("+ (30-sendSmsTime) +")";
								sendSmsTime++;
								me.text(tvalue);
								//console.log(sendSmsTime);
							}
						},1000);
					} else {
						resultSpan.html('문자를 발송에 실패하였습니다.').css('color','red');
					}
				}
			});
		} else {
			error_msg_bubble(telnum[0],'올바른 휴대폰 번호를 입력하세요');
		}
	});
	
/*  휴대폰 인증 문자 확인 */
	$('.post_sms_confirm').click(function(e){
		e.preventDefault();
		if ($(this).hasClass('gray')){
			return ;
		}
		var me = $(this);
		var id = $('.smslog_id').val();
		var sms_confirm = $(this).closest('form').find('input[name="sms_confirm"]');
		var resultSpan = $('.confirm_ajax_loader');
		if (sms_confirm.val().length != 6) {
			resultSpan.html('인증번호 6자리를 입력하세요.').css('color','red');
			return ;
		}
		
		resultSpan.html("<img src=\""+ g_root +"/images/ajax-loader.gif\" style=\"position:relative; top:5px;\"/>");
		$.ajax({
			url : g_root + '/inc/ajax.php',
			type : 'POST',
			data : {
				mode : 'post_sms_confirm',
				'smslog_id' : id,
				'sConfirmNum' : sms_confirm.val()
			},
			success: function(text) {
				if (text == 'Y') {
					sms_confirm.attr('readonly','readonly');
					me.closest('li').find('.send_sms_confirm').addClass('gray');
					resultSpan.html('휴대폰인증이 완료되었습니다.').css('color','blue');
					me.closest('li').find('.check_smsconfirm').val(text);
					me.addClass('gray');
					if (me.hasClass('findPw')) {
						resultSpan.html("<span class=\"button medium\"><input type=\"submit\" value=\"비밀번호 찾기\" /></span>").css('text-align','center');
					}
				} else {
					resultSpan.html('휴대폰인증에 실패하였습니다.').css('color','red');
				}
			}
		});
	});
	
});


