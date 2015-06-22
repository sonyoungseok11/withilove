<?php
$uploadpath  = '/town/images';

function filesUpload_town($file, $eType, $id) {
	global $db_conn, $default_db, $uploadpath, $root;
	
	$current_time = time();
	$time_info  = getdate($current_time);
	$date_filedir   = $time_info["year"].getTowDigit($time_info["mon"]).getTowDigit($time_info["mday"]).getTowDigit($time_info["hours"]).getTowDigit($time_info["minutes"]).getTowDigit($time_info["seconds"]);
	
	switch ($eType) {
		case 'P' :
			$w = 500;
			$h = 500;
			$t_w = 100;
			$t_h = 100;
			
			$len = count($file['name']);
			for ($i=0; $i<$len; $i++) {
				if ($file['error'][$i] == 0) {
					$ext = strtolower(substr(strrchr($file["name"][$i],"."),1));
					$savefilename = strtolower($date_filedir."_academy_image_".$eType.$i.".".$ext);
					if(move_uploaded_file($file['tmp_name'][$i],$root.$uploadpath."/".$savefilename)){
						create_thumbnail($root.$uploadpath,$root.$uploadpath."/thumb",$savefilename,$t_w,$t_h);
						create_thumbnail($root.$uploadpath,$root.$uploadpath,$savefilename,$w,$h);
						$ISQL = "
							INSERT INTO `town_file` SET
								town_academy_id = '".$id."',
								eType = '".$eType."',
								sPath = '".$uploadpath."',
								sFile = '".$savefilename."'
						";
						$IRES = $db_conn -> sql($default_db, $ISQL);
					}
				}
			}
			break;
		default :
			//오리지널 파일 이름.확장자
			$ext = strtolower(substr(strrchr($file["name"],"."),1));
			$savefilename = strtolower($date_filedir."_upload_image_".$eType.".".$ext);
			
			
			//php 파일업로드하는 부분
			if(move_uploaded_file($file['tmp_name'],$root.$uploadpath."/".$savefilename)){
				$ISQL = "
					INSERT INTO `town_file` SET
						town_academy_id = '".$id."',
						eType = '".$eType."',
						sPath = '". $uploadpath."',
						sFile = '".$savefilename."'
				";
				$IRES = $db_conn -> sql($default_db, $ISQL);
			}
			break;
	}
	
}

function delete_files_town($delfile) {
	global $db_conn, $default_db, $root;
	
	$delfile_ids = array_for_sql_IN($delfile);
	$SFSQL = "SELECT sPath, sFile FROM `town_file` WHERE id IN(". $delfile_ids .")";
	$SFRES = $db_conn -> sql($default_db, $SFSQL);
	while(list($sPath, $sFile) = mysql_fetch_row($SFRES)) {
		$filename= $root.$sPath.'/'.$sFile;
		$thumbname =  $root.$sPath.'/thumb/'.$sFile;
		@unlink($filename);
		@unlink($thumbname);
	}
	$DFSQL = "DELETE FROM `town_file` WHERE id IN(". $delfile_ids .")";
	$DFRES = $db_conn -> sql($default_db, $DFSQL);
}

function sqlShowData_town($SSQL, $st_num) {
	global $db_conn, $default_db, $root, $page;

	$SRES = $db_conn -> sql($default_db, $SSQL);
	$tbody .= "<tbody>";
	while ($Datas = mysql_fetch_assoc($SRES)) {
		$tbody .="<tr>";
		$tbody .="<td class=\"center\">". $st_num-- ."</td>";
		
		$FCSQL = "SELECT COUNT(id) FROM `town_file` WHERE town_academy_id='". $Datas['id'] ."' AND eType='P'";
		$FCRES = $db_conn-> sql($default_db, $FCSQL);
		list($fcnt) = mysql_fetch_row($FCRES);
		if ($fcnt) {
			$FSSQL = "SELECT sPath, sFile FROM `town_file` WHERE town_academy_id='". $Datas['id'] ."' AND eType='P' ORDER BY id";
			$FSRES = $db_conn -> sql($default_db, $FSSQL);
			$img = mysql_fetch_assoc($FSRES);
			$tbody .="<td class=\"center\"><a href=\"javascript:;\" onclick=\"Town.viewImg(".$Datas['id'].")\" style=\"background:url('".$root.$img['sPath']."/thumb/".$img['sFile']."') no-repeat center center; display:inline-block; width:100px; height:100px;\" title=\"이미지보기\"></a></td>";
		} else {
			$tbody .="<td class=\"center\"><span style=\"background:url('".$root."/town/images/thumb/noimage.png') no-repeat center center; display:inline-block; height:100px; width:100px;\" title=\"이미지없음\"><span></td>";
		}
		
		
		$tbody .="<td class=\"center\"><a href=\"town_view.php?id=".$Datas['id']."&page=".$page."\" >".$Datas['sName']."</a></td>";
		//$tbody .="<td class=\"center\">". $Datas['sCeo'] ."</td>";
		$tbody .="<td class=\"center\">". $Datas['sTel'] ."</td>";
		if ($Datas['sUrl']) {
			$tbody .="<td class=\"center\"><a href=\"".$Datas['sUrl']."\" target=\"_blank\">". $Datas['sUrl'] ."</a></td>";
		} else {
			$tbody .="<td class=\"center\">". $Datas['sUrl'] ."</td>";
		}
		$tbody .="<td class=\"left\">". $Datas['sAddr'] . ' '. $Datas['sAddrSub'] ."</td>";
		$tbody .="</tr>";
	}
	$tbody .= "</tbody>";
	$tbody .= "</table>";

	return $tbody;
}
function sqlShowData_town_manager($SSQL, $st_num) {
	global $db_conn, $default_db, $root, $page, $iActive;

	$SRES = $db_conn -> sql($default_db, $SSQL);
	$tbody .= "<tbody>";
	while ($Datas = mysql_fetch_assoc($SRES)) {
		$tbody .="<tr>";
		$tbody .="<td class=\"center\"><input type=\"checkbox\" class=\"checkGroup\" value=\"".$Datas['user_id']."\" /></td>\n";
		$tbody .="<td class=\"center\">". $st_num-- ."</td>";
		
		$FCSQL = "SELECT COUNT(id) FROM `town_file` WHERE town_academy_id='". $Datas['id'] ."' AND eType='P'";
		$FCRES = $db_conn-> sql($default_db, $FCSQL);
		list($fcnt) = mysql_fetch_row($FCRES);
		if ($fcnt) {
			$FSSQL = "SELECT sPath, sFile FROM `town_file` WHERE town_academy_id='". $Datas['id'] ."' AND eType='P' ORDER BY id";
			$FSRES = $db_conn -> sql($default_db, $FSSQL);
			$img = mysql_fetch_assoc($FSRES);
			$tbody .="<td class=\"center\"><a href=\"javascript:;\" onclick=\"Town.viewImg(".$Datas['id'].")\" style=\"background:url('".$root.$img['sPath']."/thumb/".$img['sFile']."') no-repeat center center; display:inline-block; width:100px; height:100px;\" title=\"이미지보기\"></a></td>";
		} else {
			$tbody .="<td class=\"center\"><span style=\"background:url('".$root."/town/images/thumb/noimage.png') no-repeat center center; display:inline-block; height:100px; width:100px;\" title=\"이미지없음\"><span></td>";
		}
		
		
		$tbody .="<td class=\"center\"><a href=\"town_view.php?id=".$Datas['id']."&page=".$page."\" >".$Datas['sName']."</a></td>";
		$tbody .="<td class=\"center\">". $Datas['sCeo'] ."</td>";
		$tbody .="<td class=\"center\">". $Datas['sHphone'] ."</td>";
		if ($Datas['sUrl']) {
			$tbody .="<td class=\"center\"><a href=\"".$Datas['sUrl']."\" target=\"_blank\">". $Datas['sUrl'] ."</a></td>";
		} else {
			$tbody .="<td class=\"center\">". $Datas['sUrl'] ."</td>";
		}
		$tbody .="<td class=\"left\">". $Datas['sAddr'] . ' '. $Datas['sAddrSub'] ."</td>";
		$tbody .="<td class=\"center\">";
		if ($iActive) {
			$tbody .="<a href=\"javascript:;\" onclick=\"Town.active(".$Datas['id'].", 0)\" class=\"jButton small\">대기</a>";
		} else {
			$tbody .="<a href=\"javascript:;\" onclick=\"Town.active(".$Datas['id'].", 1)\" class=\"jButton small\">등록</a>";
			$tbody .= " <a href=\"\javascript:;\" onclick=\"Town.delTown(".$Datas['id'].")\" class=\"jButton small\">삭제<a>";
		}
		
		$tbody .="</td>";
		$tbody .="</tr>";
	}
	$tbody .= "</tbody>";
	$tbody .= "</table>";

	return $tbody;
}
?>