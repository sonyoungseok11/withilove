<?php
include_once ("./_common.php");
include_once("$root/subhead.php");

/* 학원세무 메뉴 가지고 오기 */
	$MenuSQL = "
		SELECT s1.iHLevel, s1.sMenuName, s1.sMenuUrl, s2.iParent_id, s2.iSort, s2.sMenuName, s2.sMenuUrl 
		FROM  sitemenu s
		INNER JOIN sitemenu s1 ON s.id = s1.iParent_id
		INNER JOIN sitemenu s2 ON s1.id = s2.iParent_id
		WHERE s1.iActive=1 AND s2.iActive=1 AND s1.iGroup IN(1,99,3)
		ORDER BY s.iSort, s1.iSort, s2.iSort
	";
	$MenuRES = $db_conn -> sql($default_db, $MenuSQL);
	while (list($iHLevel, $MenuCategory, $CategoryUrl, $iParent, $iSort, $MenuName, $MenuUrl) = mysql_fetch_row($MenuRES)) {
		$SiteMapArr1[$iParent]['category'] = $MenuCategory;
		$SiteMapArr1[$iParent]['catogoryUrl'] = $CategoryUrl;
		$SiteMapArr1[$iParent]['iHLevel'] = $iHLevel;
		$SiteMapArr1[$iParent]['sub'][$iSort]['MenuName'] = $MenuName;
		$SiteMapArr1[$iParent]['sub'][$iSort]['MenuUrl'] = $MenuUrl;
	}
	$SiteMap1 = getSiteMap($SiteMapArr1);

/* 진로진학 메뉴 가지고 오기 */	
	$MenuSQL2 = "
		SELECT s1.iHLevel, s1.sMenuName, s1.sMenuUrl, s2.iParent_id, s2.iSort, s2.sMenuName, s2.sMenuUrl 
		FROM  sitemenu s
		INNER JOIN sitemenu s1 ON s.id = s1.iParent_id
		INNER JOIN sitemenu s2 ON s1.id = s2.iParent_id
		WHERE s1.iActive=1 AND s2.iActive=1 AND s1.iGroup IN(2,99,3)
		ORDER BY s.iSort, s1.iSort, s2.iSort
	";
	$MenuRES2 = $db_conn -> sql($default_db, $MenuSQL2);
	while (list($iHLevel, $MenuCategory, $CategoryUrl, $iParent, $iSort, $MenuName, $MenuUrl) = mysql_fetch_row($MenuRES2)) {
		$SiteMapArr2[$iParent]['category'] = $MenuCategory;
		$SiteMapArr2[$iParent]['catogoryUrl'] = $CategoryUrl;
		$SiteMapArr2[$iParent]['iHLevel'] = $iHLevel;
		$SiteMapArr2[$iParent]['sub'][$iSort]['MenuName'] = $MenuName;
		$SiteMapArr2[$iParent]['sub'][$iSort]['MenuUrl'] = $MenuUrl;
	}
	$SiteMap2 = getSiteMap($SiteMapArr2);
?>

<ul id="Tabs">
	<li><a href="sub1">세무/변호/법무/노무 관련</a></li>
	<li><a href="sub2">유치,초,중,고 학원 교육 관련</a></li>
</ul>
<div id="sub1" class="sitemap">
	<?=$SiteMap1?>
</div>

<div id="sub2" class="sitemap">
	<?=$SiteMap2?>
</div>

<script type="text/javascript">
var site_tab = new SiteTab('#Tabs');
if (location.hash) {
	site_tab.show(location.hash);
}
</script>
<?php
include_once("$root/subfoot.php");
?>