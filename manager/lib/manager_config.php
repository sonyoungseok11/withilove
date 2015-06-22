<?php
	if (empty($MEMBER['id']) || $MEMBER['iMLevel'] > 9 ) {
		echo '
			<script type="text/javascript">
				alert("접근권한이 없습니다.");
				location.href="'.$root.'/index.php";
			</script>
		';
		exit;
	}
?>