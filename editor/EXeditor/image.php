<?php
include_once("./_common.php");
include_once("$root/lib/phpheader.php");
include_once("$root/lib/class.php");
include_once("$root/lib/function.php");
include_once("$root/lib/db_info.php");
include_once("$root/lib/config.php");

$dir = '/data/upload';
$thumb_dir = '/data/upload/thumb';

$mode = $_POST['mode'];

switch($mode) {
	case 'upload' :
		if ($_FILES["upload"]["size"] > 0 ) {
			// 현재시간 추출
			$current_time = time();
			$time_info  = getdate($current_time);
			$date_filedir   = $time_info["year"].getTowDigit($time_info["mon"]).getTowDigit($time_info["mday"]).getTowDigit($time_info["hours"]).getTowDigit($time_info["minutes"]).getTowDigit($time_info["seconds"]);
			//오리지널 파일 이름.확장자
			$ext = strtolower(substr(strrchr($_FILES["upload"]["name"],"."),1));
			$savefilename = strtolower($date_filedir."_editor_image".".".$ext);
			$uploadpath  = $_SERVER['DOCUMENT_ROOT'].$dir;
			$uploadsrc = $_SERVER['HTTP_HOST'].$dir;
			$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';
			//php 파일업로드하는 부분
			if($ext=="jpg" or $ext=="gif" or $ext =="png"){
				if(move_uploaded_file($_FILES['upload']['tmp_name'],$uploadpath."/".$savefilename)){
					$uploadfile = $savefilename;
					$data['mode'] = "Y";
					$data['msg'] = "업로드 성공";
					$data['filename'] =$uploadsrc."/".$savefilename;
				}
			} else {
				$data['mode'] = "N";
				$data['msg'] = 'jpg,gif,png파일만 업로드가능합니다.';
			}
		} else {
			$data['mode'] = "N";
			$data['msg'] = "업로드 실패";
		}
		echo $data['mode']."|".$data['msg']."|".$data['filename'];
		break;
	case 'deleteImg' :
		$file = $_POST['file'];
		$dir = $_SERVER['DOCUMENT_ROOT'] . $dir;
		$thumb_dir = $_SERVER['DOCUMENT_ROOT'] . $thumb_dir;
		unlink($dir."/".$file);
		unlink($thumb_dir."/".$file);
		break;
	case 'getImg' :
		$dir = $_SERVER['DOCUMENT_ROOT'] . $dir;
		$thumb_dir = $_SERVER['DOCUMENT_ROOT'] . $thumb_dir;
		
		$count = empty($_POST['count']) ? 10 : $_POST['count'];
		$page = empty($_POST['page']) ? 1 : $_POST['page'];
		$total = 0;
		
		$pageStart = ($page-1) * $count;
		$pageEnd = $pageStart+$count;
		
		$dirhandler = opendir($dir);
		while (false !== ($filename = readdir($dirhandler))) {
			$ext = substr(strrchr($filename,"."),1);
			if ($ext == 'jpg' || $ext=='gif' || $ext == 'png' ) {
				$files[] = $filename;
				$total++;
			}
		}
		rsort($files);// 역순정렬
		
		for ($i=$pageStart ; $i<$pageEnd; $i++) {
			if ($i >= $total) {
				break;
			}
			$data['files'][] = $files[$i];
			if (!is_file($thumb_dir."/".$files[$i])) {
				create_thumbnail($dir,$thumb_dir,$files[$i],150,150);
			}
		}
		$data['page'] = array(
			'current_page' => intval($page),
			'limite' => intval($count),
			'total' => $total,
			'total_page' => ceil($total/$count),
			'page_list' => ceil(intval($page)/10)-1
		);
		echo json_encode($data);
		break;
	default :
		$current_time = time();
		$time_info  = getdate($current_time);
		print_r($time_info);
		break;
}
?>