<?php
	include_once ("./_common.php");
	include_once ("$path/inc/header.php");
	
	/* 서브페이지 인포메이션 불러오기 */
	switch (getFileName()) {
		case 'career.php':
		case 'camp_memoirs.php':
		case 'basic_pds.php':
			$ca = isset($_REQUEST['caNum']) ? false : true;
			if (!$ca) {
				$caNum = $_REQUEST['caNum'];
				$caSubfix = "?caNum=$caNum";
				$PSQL ="
					SELECT s1.iGroup, s1.sMenuName AS GroupName, s2.id AS Parent_id, s2.sMenuName AS CategoryName, s3.id, s3.sMenuName AS MenuName  FROM sitemenu s1 
						INNER JOIN sitemenu s2 ON s1.id = s2.iParent_id 
						INNER JOIN sitemenu s3 ON s2.id = s3.iParent_id 
						WHERE s3.sMenuUrl='".$_SERVER['PHP_SELF'].$caSubfix."'
				";
			} else {
				$PSQL ="
					SELECT s1.iGroup, s1.sMenuName AS GroupName, s2.id AS Parent_id, s2.sMenuName AS CategoryName, s3.id, s3.sMenuName AS MenuName  FROM sitemenu s1 
						INNER JOIN sitemenu s2 ON s1.id = s2.iParent_id 
						INNER JOIN sitemenu s3 ON s2.id = s3.iParent_id 
						WHERE s2.sMenuUrl='".$_SERVER['PHP_SELF']."'
				";
			}
			break;
		default : 
			$PSQL ="
					SELECT s1.iGroup, s1.sMenuName AS GroupName, s2.id AS Parent_id, s2.sMenuName AS CategoryName, s3.id, s3.sMenuName AS MenuName  FROM sitemenu s1 
						INNER JOIN sitemenu s2 ON s1.id = s2.iParent_id 
						INNER JOIN sitemenu s3 ON s2.id = s3.iParent_id 
						WHERE s3.sMenuUrl='".$_SERVER['PHP_SELF']."'
				";
			break;
		
	}
	
	
	$PRES = $db_conn -> sql($default_db, $PSQL);
	
	
	$PageInfo = mysql_fetch_assoc($PRES);
	$PageInfo['info'] = "";
	if ($PageInfo['iGroup']=='99') {
		$PageInfo['HeadName'] = $PageInfo['MenuName'];
	} else {
		$PageInfo['HeadName'] = $PageInfo['CategoryName'];
		$PageInfo['info'] .=  $PageInfo['GroupName'] . " <span class=\"gt\">&gt;</span> ";
	}
	if (!$ca) {
		$PageInfo['info'] .= $PageInfo['CategoryName'] . " <span class=\"gt\">&gt;</span> <strong>". $PageInfo['MenuName']."</strong>";
	} else {
		$PageInfo['info'] .= $PageInfo['CategoryName'] . " <span class=\"gt\">&gt;</span> <strong>전체</strong>";
	}
	/* //서브페이지 인포메이션 불러오기 */

	// 상단 메뉴 만들기 

	if (!empty($PageInfo['iGroup']) && $PageInfo['iGroup'] < 99) {
		$SMSQL = "
			SELECT * FROM `sitemenu`
			WHERE iActive='1' AND iParent_id='". $PageInfo['Parent_id'] ."' ORDER BY iSort
		";
		$SMRES = $db_conn -> sql($default_db, $SMSQL);
		$rows = mysql_num_rows($SMRES);
		$tab_width = 1000 / $rows;
		$tabMenu = "<ul class=\"myTabStyle\">";
		
		while ($TMENU = mysql_fetch_assoc($SMRES)) {
			$tabMenu .= "<li style=\"width:". $tab_width ."px;\">";
			if ($TMENU['id'] == $PageInfo['id']) {
				$tabMenu .= "<div>".$TMENU['sMenuName']."</div>";
			} else {
				$tabMenu .= "<a href=\"". $TMENU['sMenuUrl'] ."\">".$TMENU['sMenuName']."</a>";
			}
			$tabMenu .= "</li>";
		}
		$tabMenu .= "</ul>";
	} else {
		$tabMenu = "<div style=\"height:2px; background:#4383fc;\"></div>";
	}
?>
<div class="wrap_Top">
<?php 
	include_once ("$path/inc/gnb.php");
?>
<div class="sub_container">
	<div class="container_wrap">
		<?php include_once("$path/inc/shortcutmenu.php");?>
		<div class="sub_content">
			<div class="sub_info"><img src="<?=$root?>/images/icon_home.gif" alt="홈" /> <span class="gt">&gt;</span> <?=$PageInfo['info']?> </div>
			<h3 class="pagename"><?=$PageInfo['HeadName']?></h3>
			<?=$tabMenu?>
		