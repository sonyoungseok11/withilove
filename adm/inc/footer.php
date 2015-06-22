<?php
	include_once ("$path/inc/dialog.php");
	include_once ("$root/inc/manager_dialog.php");
	include_once ("$root/inc/dialog.php");
	
	if ($_COOKIE['addMaster']) {
		$addmember = explode(',',$_COOKIE['addMaster']);
		switch($addmember[0]) {
			case 'true' :
				$alert['title'] ='관리자등록완료' ;
				$alert['msg'] = $addmember[1].'님이 관리자로 등록 되었습니다.';
				break;
			case 'false':
				$alert['title'] ='관리자등록실패' ;
				$alert['msg'] = $addmember[1].'님의 관리자 등록이 실패 하였습니다.';
				break;
		}
		echo "
			<script type=\"text/javascript\">
				$(document).ready(function(){
					setCookie('addMaster','',0);
					alertMsg('". $alert['title'] ."', '".$alert['msg']."');
				});
			</script>
		";
	}
?>
	</body>
</html>