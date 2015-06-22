// JavaScript Document
$('#UserModify').dialog({
	autoOpen : false,
	modal : true,
	width : 500,
	buttons: {
		'등록/수정': function() {
			form_submit($(this).find('form'));
		},
		'닫기': function() {
			$( this ).dialog( "close" );
		},
		'회원 상태 변경' : function() {
			$(this).find('input[name="mode"]').val('S');
			$(this).find('input[name="iUserStatus"]').val('10');
			$(this).find('form').submit();
		}
	}
});

$('#SMS_Manager').dialog({
	autoOpen : false,
	modal : true,
	width : 580,
	buttons: {
		'문자 전송' : function(e) {
			var me = $(e.target).parent();
			sms_manager.send(me);
		},
		'닫기': function() {
			$( this ).dialog( "close" );
		}
	}
});

$('#Search_Mebmber').dialog({
	autoOpen : false,
	width : 400,
	buttons : {
		'검색' : function() {
			var me = $(this);
			var result = me.find('.search_result');
			var form = $(this).find('form');
			var validate = check_values(form[0]);
			if (validate) {
				$.ajax({
					url : g_path + '/inc/ajax.php',
					type: 'post',
					dataType:"json",
					data : {
						mode : 'Search_Mebmber',
						sMode : form[0].search_mode.value,
						searchType : form[0].MsearchType.value,
						searchStr : form[0].MsearchStr.value
					},
					success: function(data) {
						console.log(data);
						
						if (data) {
							result.html('').css({'line-height':'normal','text-align':'left'});
							var len = data.length;
							for (var i=0; i<len; i++) {
								var div = $("<div></div>").addClass('item').appendTo(result);
								var span1 = $('<span></span>').addClass('id').text(data[i].sUserId).appendTo(div);
								var span2 = $('<span></span>').addClass('name').text(data[i].sUserName).appendTo(div);
								var span3 = $('<span></span>').addClass('tel').text(data[i].sHphone).appendTo(div);
								var span4 = $('<span></span>').addClass('cmd').appendTo(div);
								var a = $('<a></a>').attr({'href' : 'javascript:;','onclick':'memberSelect('+ data[i].id +', "'+ data[i].sUserId +'", "' + data[i].sUserName + '", "'+ me.attr("id") +'")'}).text('선택').addClass('jButton').addClass('small').button().appendTo(span4);
							}
						} else {
							result.html('회원정보가 없습니다.').css({'line-height':'200px','text-align':'center'});
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