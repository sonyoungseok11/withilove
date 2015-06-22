// 세무계약 상세보기
function user_contract_dialog(id) {
	$.ajax({
		url : g_path + "/inc/ajax.php",
		type : 'post',
		dataType:"json",
		data : {
			'mode' : 'user_contract_dialog',
			'id' : id
		},
		success: function(data) {
			//console.log(data)
			var popup = $('#UserContract_Detail');
			popup.find('.user_name').text(data.sUserName);
			popup.find('.user_id').text(data.sUserId);
			popup.find('.user_hp').text(data.sHphone);
			popup.find('.user_email').text(data.sEmail);
			popup.find('.center_sName').text(data.sName);
			popup.find('.center_sSince').text(data.sSince);
			popup.find('.center_eLicense').text(data.eLicense);
			popup.find('.center_sTel').text(data.sTel);
//			popup.find('.center_sZipCode').text(data.sZipCode);
//			popup.find('.center_sAddr').text(data.sAddr);
			popup.find('.center_sAddrSub').text(data.sAddrSub);
			popup.find('.center_iCounselingTime').text(data.iCounselingTime);
			popup.find('.center_iTotalSales').text(data.iTotalSales);
			popup.find('.center_iTeacher').text(data.iTeacher);
			popup.find('.center_iSalary').text(data.iSalary);
			popup.find('.center_iRent').text(data.iRent);
			popup.find('.center_eBookeep').text(data.eBookeep);
			popup.find('.center_sTaxName').text(data.sTaxName);
			popup.find('.center_sNote').text(data.sNote);
			popup.find('.center_iStep').text(data.iStep);
			popup.find('.center_dInDate').text(data.dInDate);
			popup.find('#contract_id').val(data.id);
			popup.find('#sManagerNote').val(data.sManagerNote);
			popup.dialog('open');
		}
	});
}

var academy = {
	update : function(id, el) {
		var li = $(el).closest('li');
		var sName = li.find('input[name="sName"]').val();
		var sUrl = li.find('input[name="sUrl"]').val();
		var form = $('<form></form>').attr({'action' : g_path +'/etc/family_academy_list_proc.php', 'method' : 'post'}).appendTo('body');
		var input1 = $('<input>').attr({'type':'hidden', 'name' : 'sName' , 'value' : sName}).appendTo(form);
		var input2 = $('<input>').attr({'type':'hidden', 'name' : 'sUrl' , 'value' : sUrl}).appendTo(form);
		var input3 = $('<input>').attr({'type':'hidden', 'name' : 'mode' , 'value' : 'M'}).appendTo(form);
		var input4 = $('<input>').attr({'type':'hidden', 'name' : 'iActive' , 'value' : '1'}).appendTo(form);
		var input5 = $('<input>').attr({'type':'hidden', 'name' : 'id' , 'value' : id}).appendTo(form);
		form.submit();
	},
	activeChange : function(id, act) {
		var iActive = act==1 ? 0 : 1;
		var form = $('<form></form>').attr({'action' : g_path +'/etc/family_academy_list_proc.php', 'method' : 'post'}).appendTo('body');
		var input1 = $('<input>').attr({'type':'hidden', 'name' : 'mode' , 'value' : 'A'}).appendTo(form);
		var input2 = $('<input>').attr({'type':'hidden', 'name' : 'id' , 'value' : id}).appendTo(form);
		var input3 = $('<input>').attr({'type':'hidden', 'name' : 'iActive' , 'value' : iActive}).appendTo(form);
		form.submit();
	},
	del : function(id) {
		var form = $('<form></form>').attr({'action' : g_path +'/etc/family_academy_list_proc.php', 'method' : 'post'}).appendTo('body');
		var input1 = $('<input>').attr({'type':'hidden', 'name' : 'mode' , 'value' : 'D'}).appendTo(form);
		var input2 = $('<input>').attr({'type':'hidden', 'name' : 'id' , 'value' : id}).appendTo(form);
		form.submit();
	},
	resort : function() {
		document.sort_change.submit();
	}
}

$(document).ready(function(e) {
	// 세무계약 스텝 변경
	$('.contract_step_change').change(function(e) {
		var me = $(this);
		var parent = $(this).parent();
		me.hide();
		var loader = $('<img>').attr('src', g_root+ "/images/ajax-loader.gif").appendTo(parent);
		var contact_id = $(this).attr('data-cid');
		var value = $(this).val();
		$.ajax({
			url : g_path + '/inc/ajax.php',
			type : 'POST',
			data : {
				'mode' : 'contract_step_change',
				'cid' : contact_id,
				'iStep' : value
			},
			success: function(data) {
				//console.log(data)
				me.show();
				loader.remove();
			}
		});
	});
	
	$('.smsSeminar_setup').submit(function(e){
		e.preventDefault();
		var sms_seminar = this.sms_seminar.value;
		
		var txt_len = sms_manager.sms_text_len(sms_seminar);
		
		if(txt_len < 80) {
			$.ajax({
				url : g_path + '/inc/ajax.php',
				type : 'post',
				data : {
					'mode' : 'smsSeminar_setup',
					'sms_seminar' : sms_seminar
				},
				success: function(text) {
					if (text == 'Y') {
						alert('고객응대 메시지가 변경되었습니다.');
					}
				}
			});
		} else {
			alert('80자 이내로 작성하세요(한글 2자)');
		}
		
	});
	
});