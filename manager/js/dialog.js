// JavaScript Document
$('#UserContract_Detail').dialog({
	autoOpen : false,
	modal : true,
	resizable: true,
	width : 700,
	buttons : {
		'메니저 노트 Update' : function() {
			var text = $(this).find('#sManagerNote').val();
				if (text.length > 0) {
				var label = {
					target : $(this).find('label'),
					source : $(this).find('label').html()
				};
				label.target.html('<img src="'+ g_root +'/images/ajax-loader.gif">');
				
				var id = $(this).find('#contract_id').val();
				var text = $(this).find('#sManagerNote').val();
				$.ajax({
					url : g_path + '/inc/ajax.php',
					type : 'POST',
					data : {
						'mode' : 'user_contract_ManagerNote_update',
						'id' : id,
						'sManagerNote' : text
					},
					success: function(data) {
						console.log(data)
						label.target.html(label.source);
					}
				});
			}
			
		},
		'인쇄' : function() {
			dialog_print(this);
		},
		'닫기' : function() {
			$(this).dialog('close');
		}
	}
});



