<?php
header('X-XSS-Protection: 0');
include_once ("./_common.php");
include_once("$root/subhead.php");
$result = stripslashes($_POST[sComment]);
?>
<div>
<?=$result?>
</div>
<script type="text/javascript" src="<?=$root?>/editor/EXeditor/EXeditor.js"></script>
<form action="#" method="post">
	<textarea name="sComment" id="sComment" class="EXeditor cssReset"><?=$result?></textarea>
	<input type="submit" value="전송">
</form>
<a href="#" class="getT">텍스트</a>
<script type="text/javascript">
	$(document).ready(function() {
        $('.EXeditor').EXeditor({userLevel : <?=$MEMBER['iMLevel']?>});
		$('.getT').click(function(e){
			e.preventDefault();
			var text = $('.EXeditor').EXeditor('getData');
			console.log(text);
		});
    });
</script>
<?php
include_once("$root/subfoot.php");
?> 