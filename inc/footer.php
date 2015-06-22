<?php
	include_once("$root/inc/dialog.php");
/*	
	if ($_SERVER['PHP_SELF'] == '/index.php' && $_COOKIE['popup1'] != 'opend') {
		echo $popup1 = '
			<div class="popup_layer">
				<img src="'.$root.'/images/popup/new2015_1.jpg" alt="새해복많이받으세요" />
				<div class="close">
					<input type="hidden" name="pop_name" value="popup1">
					<label><input type="checkbox" value="Y" /> 하루동안 열지 않기</label>
					<a href="#" class="layer_close jButton small" >닫기</a>
				</div>
			</div>
		';
	}
*/
/*	
	if ($_SERVER['PHP_SELF'] == '/index.php' && $_COOKIE['popup2'] != 'opend') {
		echo $popup2 = '
			<div class="popup_layer seminar">
				<img src="'.$root.'/images/popup/seminar2.jpg" alt="새해복많이받으세요" />
				<div class="close">
					<input type="hidden" name="pop_name" value="popup2">
					<label><input type="checkbox" value="Y" /> 하루동안 열지 않기</label>
					<a href="#" class="layer_close jButton small" >닫기</a>
				</div>
			</div>
		';
	}
*/
?>
<style type="text/css">
	.popup_layer {position:absolute; width:391px; height:514px; left:30px; top:225px; background:#fff; z-index: 1000; border:1px solid #333;}
	.popup_layer >img {margin-bottom:-3px;}
	.popup_layer .close {height:26px; background:#333; line-height:26px; color:#FFF; position:relative; padding-left:20px; text-align:right;}
	.popup_layer .close input[type="checkbox"] {position:relative; top:2px;}
	.popup_layer .close a {margin:0px 20px}
	.popup_layer.seminar {left:auto;right:30px;}
</style>

	<script type="text/javascript">
		$('.layer_close').click(function(e){
			e.preventDefault();
			var layer = $(this).closest('.popup_layer');
			var check = layer.find('input[type="checkbox"]:checked').length;
			if (check) {
				var pop_name = layer.find('input[name="pop_name"]').val();
				setCookie(pop_name, 'opend', 1);
			}
			layer.fadeOut('fast');
		});
		subcontentHeight();
	</script>
	</body>
</html>