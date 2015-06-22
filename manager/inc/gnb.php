<?php
$LMSQL ="
	SELECT s2.iActive as ca_active, s2.sMenuName AS category, s2.iMLevel AS caLevel, s3.board_config_id, s3.iMLevel, s3.iActive as me_active, s3.sMenuName, s3.sMenuUrl, s3.sClass 
	FROM sitemenu s1 
	INNER JOIN sitemenu s2 ON s1.id = s2.iParent_id
	INNER JOIN sitemenu s3 ON s2.id = s3.iParent_id
	WHERE s1.iGroup = 4
	ORDER BY s2.iSort, s3.iSort
";
$LMRES = $db_conn -> sql($default_db, $LMSQL);
while($LM = mysql_fetch_assoc($LMRES)) {
	$mMENU[$LM['category']]['caLevel'] = $LM['caLevel'];
	$mMENU[$LM['category']]['active'] = $LM['ca_active'];
	$mMENU[$LM['category']][$LM['sMenuName']]['url'] = $LM['sMenuUrl'];
	$mMENU[$LM['category']][$LM['sMenuName']]['level'] = $LM['iMLevel'];
	$mMENU[$LM['category']][$LM['sMenuName']]['class'] = $LM['sClass'];
	$mMENU[$LM['category']][$LM['sMenuName']]['active'] = $LM['me_active'];
}
$lnb = "<ul>";
foreach ($mMENU as $category => $menu) {
	if ($MEMBER['iMLevel'] <= $menu['caLevel']) { // 중분류 레벨이 안되면 넘김
		if ($menu['active']) { 
			$lnb .= "<li>";
			$lnb .= "<div>".$category."</div>";
			$lnb .= "<ul>";
		}
			foreach($menu as $menuName => $v) { 
				if ($menuName == 'caLevel' || $menuName == 'active') continue; // 중분류 레벨 값이면 넘김
				if ($MEMBER['iMLevel'] <= $v['level']) { // 메뉴 레벨이 안되면 넘김
					$active = '';
					if ($v['url'] == $_SERVER['PHP_SELF']) {
						$currentPage['name'] = $menuName;
						$currentPage['category'] = $category;
						$active = 'active';
					}
					if ($v['active']) {
						$lnb .= "<li><a href=\"".$v['url']."\" class=\"". $v['class'] ." ". $active ."\">".$menuName."</a></li>";
					}
				}
			}
		if ($menu['active'] ) { 
			$lnb .= "</ul>";
		}
	}
}
$lnb .= "</ul>";

?>
<div class="mwrap">
	<h1><?=$HOME_CONFIG['HomeTitle']?> 관리자</h1>
	<div class="sitemenu"><a href="<?=$root?>/index.php">홈페이지 바로가기</a></div>
</div>
<div class="container">
	<div class="lnb">
		<?=$lnb?>
	</div>
	<div class="contents">
		<div class="page_title"><?=$currentPage['name']?><span class="side">Manager > <?=$currentPage['category']?> > <b><?=$currentPage['name']?></b> </span></div>
