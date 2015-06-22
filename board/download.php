<?PHP
include_once("./_common.php");
include_once("$root/lib/class.php");
include_once("$root/lib/db_info.php");

$file_id = $_POST['file_id'];
$FSQL = "SELECT sPath, sFile, sCopy FROM `board_file` WHERE id='". $file_id ."'";
$FRES = $db_conn -> sql($default_db, $FSQL);
$FileInfo = mysql_fetch_array($FRES);

$DownPath = $root.$FileInfo['sPath'].'/'.$FileInfo['sCopy'];
$FileName = iconv("UTF-8","cp949//IGNORE", $FileInfo['sFile']);

header("Content-Type: file/unknown");
header("Content-Disposition: attachment; filename=". $FileName ."");
header("Content-Length: ". filesize($DownPath));
header("Content-Transfer-Encoding: binary");
header("Pragma: no-cahe");
header("Expires: 0");
flush();

if ($fp = fopen($DownPath, 'r')) {
	print fread($fp, filesize($DownPath));
}
fclose($fp);

$USQL = "UPDATE `board_file` SET iDownload = iDownload+1 WHERE id='". $file_id ."'";
$URES = $db_conn -> sql($default_db, $USQL);
?>