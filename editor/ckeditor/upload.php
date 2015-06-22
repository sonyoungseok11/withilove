<?php
if ($_FILES["upload"]["size"] > 0 ) {
	// 현재시간 추출
	$current_time = time();
	$time_info  = getdate($current_time);
	$date_filedir   = $time_info["year"].$time_info["mon"].$time_info["time"].$time_info[seconds].$time_info[minutes].$time_info[hours];
	//오리지널 파일 이름.확장자
	$ext = substr(strrchr($_FILES["upload"]["name"],"."),1);
	$ext = strtolower($ext);
	$savefilename = $date_filedir."_editor_image".".".$ext;
	$uploadpath  = $_SERVER['DOCUMENT_ROOT']."/data/upload";
	$uploadsrc = $_SERVER['HTTP_HOST']."/data/upload/";
	$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';
	//php 파일업로드하는 부분
	if($ext=="jpg" or $ext=="gif" or $ext =="png"){
		if(move_uploaded_file($_FILES['upload']['tmp_name'],$uploadpath."/".$savefilename)){
			$uploadfile = $savefilename;
			echo "<script type='text/javascript'>alertMsg('CKEditor','업로드성공');</script>;";
		}
	} else {
		echo "<script type='text/javascript'>alertMsg('CKEditor','jpg,gif,png파일만 업로드가능합니다.');</script>;";
	}
} else {
	exit;
}
echo "<script type='text/javascript'> window.parent.CKEDITOR.tools.callFunction({$_GET['CKEditorFuncNum']}, '".$http.$uploadsrc."$uploadfile');</script>;";
?>