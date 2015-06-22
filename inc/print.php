<?PHP
	include_once("./_common.php");
	include_once("$root/lib/phpheader.php");
	include_once("$root/lib/class.php");
	include_once("$root/lib/function.php");
	include_once("$root/lib/db_info.php");
	include_once("$root/lib/config.php");
	
	$HTML5 = true;
	$UserAgent = getBrowser();
	if($UserAgent['name'] == 'Internet Explorer') {
		$print_obj = '<object id="IEPageSetupX" classid="clsid:41C5BC45-1BE8-42C5-AD9F-495D6C8D7586" codebase="'.$root.'/js/IEPageSetupX.cab#version=1,4,0,3" width=0 height=0>	
			<param name="copyright" value="http://withfriengs.com"></object>';
		$print_script = "<script type=\"text/javascript\">
			$(document).ready(function(e) {
				window.IEPageSetupX.PrintBackground = true;
				window.IEPageSetupX.ShrinkToFit = true;
				window.IEPageSetupX.Preview();
				window.close();
			});
		</script>";
		if ($UserAgent['version'] < 10) {
			$HTML5 = false;
		}
	} else {
		$HTML5 = true;
		$print_script ="<script type=\"text/javascript\">
			$(document).ready(function(e) {
				window.print();
				window.close();
			});
		</script>";
	}
	
	if ($HTML5) {
		$jquery_include = "<script type=\"text/javascript\" src=\"//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js\"></script>\n";
	} else {
		$jquery_include = "<script type=\"text/javascript\" src=\"//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js\"></script>\n";
	}
	
	
	$print =  stripslashes($_POST['print']);
	if (!empty($print)) {
		$print .= $print_script;
	}
	//print_r($print);
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?=$HOME_CONFIG['HomeTitle']?></title>
        <link type="text/css" rel="stylesheet" href="<?=$root?>/css/common.css" />
		<link type="text/css" rel="stylesheet" href="<?=$root?>/css/<?=$HOME_CONFIG['SkinCSS']?>.css" />
		<link type="text/css" rel="stylesheet" href="<?=$root?>/adm/css/<?=$HOME_CONFIG['SkinCSS']?>.css" />
		<link type="text/css" rel="stylesheet" href="<?=$root?>/manager/css/<?=$HOME_CONFIG['SkinCSS']?>.css" />
		<link type="text/css" rel="stylesheet" href="<?=$root?>/css/smoothness/jquery-ui-1.9.2.custom.css" />
		<link type="text/css" rel="stylesheet" href="<?=$root?>/editor/EXeditor/EXeditor.css" />
		<?=$script_global?>
		<?=$jquery_include?>
		<script type="text/javascript" src="<?=$root?>/js/jquery-ui-1.9.2.custom.min.js"></script>
		<script type="text/javascript" src="<?=$root?>/js/jquery.form.min.js"></script>
		<script type="text/javascript" src="<?=$root?>/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="<?=$root?>/js/common.js"></script>
		<script type="text/javascript" src="<?=$root?>/js/check_form.js"></script>
		<script type="text/javascript" src="<?=$path?>/js/roll_banner.js"></script>
		<?=$member_login_log?>
	</head>
	<body>
		<?=$print_obj?>
		<?=$print?>
	</body>
</html>
