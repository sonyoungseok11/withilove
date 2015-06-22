<?PHP
	include_once("./_common.php");
	include_once("$root/lib/phpheader.php");
	include_once("$root/lib/class.php");
	include_once("$root/lib/function.php");
	include_once("$root/lib/db_info.php");
	include_once("$root/lib/config.php");
	include_once("$path/lib/manager_config.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?=$HOME_CONFIG['HomeTitle']?> - 관리자</title>
        <link type="text/css" rel="stylesheet" href="<?=$root?>/css/common.css" />
		<link type="text/css" rel="stylesheet" href="<?=$path?>/css/default_skin.css" />
		<link type="text/css" rel="stylesheet" href="<?=$root?>/css/smoothness/jquery-ui-1.9.2.custom.css" />
		<link type="text/css" rel="stylesheet" href="<?=$root?>/css/tablesorter_theme.default.css" />
		<link type="text/css" rel="stylesheet" href="<?=$root?>/editor/EXeditor/EXeditor.css" />
		<link type="text/css" rel="stylesheet" href="<?=$root?>/css/daum_map.css" />
		<?=$script_global?>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="<?=$root?>/js/jquery-ui-1.9.2.custom.min.js"></script>
		<script type="text/javascript" src="<?=$root?>/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="<?=$root?>/js/common.js"></script>
		<script type="text/javascript" src="<?=$root?>/js/check_form.js"></script>
		<script type="text/javascript" src="<?=$root?>/js/jquery.tablesorter.min.js"></script>
		<script type="text/javascript" src="<?=$root?>/js/manager.js"></script>
		<script type="text/javascript" src="<?=$path?>/js/common.js"></script>
		<?=$member_login_log?>
	</head>
	<body>