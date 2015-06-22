// JavaScript Document
$('#Alert_Msg').dialog({
		autoOpen : false,
		modal : true,
		resizable: false,
		buttons: {
			'확인' : function() {
				$(this).dialog('close');
			}
		}
})

$('#Back_Msg').dialog({
		autoOpen : false,
		modal : true,
		resizable: false,
		buttons: {
			'회원가입' : function() {
				location.href= g_root + "/sub_etc/member/agrement.php";
			},
			'로그인' : function() {
				$(this).dialog('close');
				$('#MemberJoin').dialog('open');
			},
			'뒤로가기' : function() {
				history.go(-1);
				$(this).dialog('close');
			}
		}
})

$('#Search_ZipCode').dialog({
	autoOpen : false,
	modal : false,
	resizable: false,
	width: 500,
	height:402,
	buttons: {
		'닫기' : function() {
			$(this).dialog('close');
		}
	}
});

$('#Search_ZipCode_New').dialog({
	autoOpen : false,
	modal : false,
	resizable: false,
	width: 600,
	height:422,
	buttons: {
		'닫기' : function() {
			$(this).dialog('close');
		}
	}
});

$('#MemberJoin').dialog({
	autoOpen : false,
	modal : false,
	resizable: false,
	width: 330,
	height:210
});

$('#SearchIdPw').dialog({
	autoOpen : false,
	modal : false,
	resizable: false,
	width: 301,
	height:402,
	buttons: {
		'닫기' : function() {
			$(this).dialog('close');
		}
	}
});

$('#Clause_POP').dialog({
	autoOpen : false,
	modal : false,
	resizable: false,
	width: 500,
	height: 600,
	buttons: {
		'닫기' : function() {
			$(this).dialog('close');
		}
	}
});

$('#Private_POP').dialog({
	autoOpen : false,
	modal : false,
	resizable: false,
	width: 500,
	height: 600,
	buttons: {
		'닫기' : function() {
			$(this).dialog('close');
		}
	}
});

$('#Email_POP').dialog({
	autoOpen : false,
	modal : false,
	resizable: false,
	width: 400,
	buttons: {
		'닫기' : function() {
			$(this).dialog('close');
		}
	}
});

$('#CooperativeDetail').dialog({
	autoOpen : false,
	modal : true,
	resizable: false,
	width : 950,
	height : 500
});


$('#Semina_MOV').dialog({
	autoOpen : true,
	modal : false,
	resizable: false,
	width:445,
	height:435,
	buttons : {
		'제2회 세경학 세미나 신청하러가기' : function() {
			location.href = g_root+"/sub_etc/acadmy_schedule/event_seminar.php";
		},
		'닫기' : function() {
			$(this).dialog('close');
		}
	}
});

$('#Suppoters').dialog({
	autoOpen : false,
	modal : true,
	resizable: false,
	height : 200
});

function suppoters(eType) {
	var title, subName1, subName3;
	switch (eType) {
		case 'K':
			title = "위드프랭즈 Key-Man 지원하기";
			subName1 = "성명";
			subName3 = "업종";
			break;
		case 'S':
			title = "위드프랭즈 연사 지원하기";
			subName1 = "성명";
			subName3 = "영역";
			break;
		case 'C':
			title = "위드프랭즈 협력업체 신청하기";
			subName1 = "업체명";
			subName3 = "담당자";
			break;
	}
	
	$('#Suppoters').prev().find('.ui-dialog-title').text(title);
	$('#Suppoters').find('.sName').text(subName1);
	$('#Suppoters').find('.sText').text(subName3);
	$('#Suppoters').find('input[name="eType"]').val(eType);
	$('#Suppoters').dialog('open');
}

function suppoters_answer(id) {
	$.ajax({
		url : g_root + "/inc/ajax.php",
		type : 'POST',
		data : {
			'mode' : 'suppoters_answer',
			'id' : id
		},
		success: function(text) {
			console.log(text);
			alert('답변처리 하였습니다.');
			location.reload();
		}
	});
	
}

$(document).ready(function(e) {
	$('.suppoters_form').submit(function(e) {
		e.preventDefault();
		var me = this;
		var valid = check_form(this);
		if(valid) {
			$.ajax({
				url : g_root + "/inc/ajax.php",
				type : 'post',
				data : {
					'mode' : me.mode.value,
					'eType' : me.eType.value,
					'sName' : me.sName.value,
					'sTel' : me.sTel.value,
					'sText' : me.sText.value
				},
				success: function(text) {
					console.log(text);
					$(me).closest('#Suppoters').dialog('close');
					alertMsg('알림',text);
				}
			});
		}
	});
});

$('#Education_Nomember_Ask').dialog({
	autoOpen : false,
	modal : true,
	resizable: false,
	width : 500,
	buttons : {
		'회원가입' : function() {
			location.href= g_root + "/sub_etc/member/agrement.php";
		},
		'로그인' : function() {
			$(this).dialog('close');
			$('#MemberJoin').dialog('open');
		},
		'신청' : function() {
			var form = $(this).find('form');
			if (check_values(form[0])) {
				$.ajax({
					url : g_root + '/inc/ajax.php',
					type: 'post',
					data : {
						mode : form[0].mode.value,
						board_config_id : form[0].board_config_id.value,
						board_table : form[0].board_table.value,
						board_id : form[0].board_id.value,
						sName_N : form[0].sName_N.value,
						sHp_N : form[0].sHp_N.value,
						sCenter_N : form[0].sCenter_N.value,
						iNumber_N : form[0].iNumber_N.value
					},
					success: function(text) {
						if (text == 'Y') {
							Wishlist.nomember_end();
						}
					}
				});
			}
		},
		'닫기' : function() {
			$(this).dialog('close');
		}
	}
});