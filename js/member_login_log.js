// JavaScript Document
function update_user_login_log(id) {
	$.ajax({
		url : g_root + '/inc/ajax.php',
		type : 'POST',
		data : {
			'mode' : 'update_user_login_log',
			'user_id' : id
		}, success: function(text) {
			//console.log(text);
		}
	});
}
// 페이지 전환시 15초간격으로 접속로그를 갱신
update_user_login_log(g_MEMBER['id']);
var UULLTIME = setInterval(function(){
	update_user_login_log(g_MEMBER['id']);
},15000);
