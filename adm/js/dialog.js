// JavaScript Document
$('#Add_Master').dialog({
	autoOpen : false,
	width : 400,
	buttons: {
		'등록': function() {
			form_submit($(this).find('form'));
		},
		'닫기': function() {
			$( this ).dialog( "close" );
		}
	}
});
