<?PHP
	include_once("./_common.php");
	include_once("$root/lib/phpheader.php");
	include_once("$root/lib/class.php");
	include_once("$root/lib/function.php");
	include_once("$root/lib/db_info.php");
	include_once("$root/lib/config.php");
	
	setcookie('last', intval($_COOKIE['last']+1) ,0,'/');
	if ($_COOKIE['last']%2) {
		$last2 = 'active';
	} else {
		$last1 = 'active';
	}
	
	$HTML5 = true;
	$UserAgent = getBrowser();
	if($UserAgent['name'] == 'Internet Explorer') {
		if ($UserAgent['version'] < 10) {
			$HTML5 = false;
		}
	} else {
		$HTML5 = true;
	}
	
	if ($HTML5) {
		$jquery_include = "<script type=\"text/javascript\" src=\"//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js\"></script>\n";
	} else {
		$jquery_include = "<script type=\"text/javascript\" src=\"//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js\"></script>\n";
	}
	
	if ($MEMBER['iMLevel'] != 1) {
		$block_script ="
			<script type=\"text/javascript\">
			$(document).ready(function(e) {
				$('.board_contents , body').on('contextmenu', function(e){
					e.preventDefault();
				}).on('dragstart',function(e){
					e.preventDefault();
				}).on('selectstart', function(e){
					e.preventDefault();
				});
			});
			</script>
		";
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?=$HOME_CONFIG['HomeTitle']?></title>
        <link type="text/css" rel="stylesheet" href="<?=$root?>/css/common.css" />
		<link type="text/css" rel="stylesheet" href="<?=$root?>/css/<?=$HOME_CONFIG['SkinCSS']?>.css" />
		<link type="text/css" rel="stylesheet" href="<?=$root?>/css/smoothness/jquery-ui-1.9.2.custom.css" />
		<link type="text/css" rel="stylesheet" href="<?=$root?>/editor/EXeditor/EXeditor.css" />
		<?=$script_global?>
		<?=$jquery_include?>
		<script type="text/javascript" src="<?=$root?>/js/jquery-ui-1.9.2.custom.min.js"></script>
		<script type="text/javascript" src="<?=$root?>/js/jquery.form.min.js"></script>
		<!--script type="text/javascript" src="<?=$root?>/ckeditor/ckeditor.js"></script-->
		<script type="text/javascript" src="<?=$root?>/js/common.js"></script>
		<script type="text/javascript" src="<?=$root?>/js/check_form.js"></script>
		<script type="text/javascript" src="<?=$path?>/js/roll_banner.js"></script>
		<?=$member_login_log?>
		<?=$block_script?>
	</head>
	<body>