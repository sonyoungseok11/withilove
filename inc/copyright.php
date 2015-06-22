<div class="partnership">
	<ul>
		<li><a href="http://withuni.semustar.com/" target="_blank"><img src="<?=$path?>/images/partner1.gif" alt="세무법인위드" title="세무법인위드" /></a></li>
		<li><a href="http://www.withvisa.com/" target="_blank"><img src="<?=$path?>/images/partner13.gif" alt="법무법인 세중" title="법무법인 세중" /></a></li>
		<li><a href="http://www.tplabor.com/" target="_blank"><img src="<?=$path?>/images/partner6.gif" alt="태평노무법인" title="태평노무법인" /></a></li>
		<li><a href="http://www.danbilaw.com/" target="_blank"><img src="<?=$path?>/images/partner7.gif" alt="법무사 정택근" title="법무사 정택근" /></a></li>
		<li><a href="http://www.withfriengs.com/" target="_blank"><img src="<?=$path?>/images/partner3.gif" alt="위드프랭즈교육원" title="위드프랭즈" /></a></li>
		<li><a href="http://www.moe.go.kr/" target="_blank"><img src="<?=$path?>/images/partner8.gif" alt="교육부" title="교육부" /></a></li>
		<li><a href="http://www.edu-bay.com" target="_blank"><img src="<?=$path?>/images/partner10.gif" alt="에듀베이몰" title="에듀베이몰" /></a></li>
		<li><a href="http://www.mw.go.kr/" target="_blank"><img src="<?=$path?>/images/partner16.gif" alt="보건복지부" title="보건복지부" /></a></li>
		<li><a href="http://iseoul.seoul.go.kr/" target="_blank"><img src="<?=$path?>/images/partner17.gif" alt="서울특별시 보육포털서비스" title="서울특별시 보육포털서비스" /></a></li>
		<li><a href="http://cpms.childcare.go.kr/" target="_blank"><img src="<?=$path?>/images/partner18.gif" alt="보육통합정보시스템" title="보육통합정보시스템" /></a></li>
		<li><a href="http://info.childcare.go.kr" target="_blank"><img src="<?=$path?>/images/partner19.gif" alt="어린이집정보공개포털" title="어린이집정보공개포털" /></a></li>
		<li><a href="http://www.w4c.go.kr/" target="_blank"><img src="<?=$path?>/images/partner20.gif" alt="사회복지시설정보시스템" title="사회복지시설정보시스템" /></a></li>
		<li><a href="http://www.khwis.or.kr/" target="_blank"><img src="<?=$path?>/images/partner21.gif" alt="한국보건복지 정보개발원" title="한국보건복지 정보개발원" /></a></li>
	</ul>
</div>
<script type="text/javascript">
$('.partnership').roll_partner({delay:0, width:'1000', showcount:'7', speed : 50000});
</script>

<?php
	if ($MEMBER['id']) {
		$clause_a = "<a href=\"Clause_POP\" class=\"clause dialog_open\"><span class=\"blind\">이용약관</span></a>";
		$private_a = "<a href=\"Private_POP\" class=\"private dialog_open\"><span class=\"blind\">개인정보취급방침</span></a>";
	} else {
		$clause_a = "<a href=\"$root/sub_etc/member/agrement.php\" class=\"clause\"><span class=\"blind\">이용약관</span></a>";
		$private_a = "<a href=\"$root/sub_etc/member/agrement.php\" class=\"private\"><span class=\"blind\">개인정보취급방침</span></a>";
	}
?>
<div class="copyright">
	<div>
		<img src="<?=$root?>/images/friengsedu/logo_gray.png" alt="세무법인위드" width="166" height="50" class="foot_logo" />
		<div class="foot_link">
			<?=$clause_a?>
			<?=$private_a?>
			<a href="Email_POP" class="email dialog_open"><span class="blind">이메일무단수집거부</span></a>
		</div>
		<em>
			상호 : 세무법인위드 | 주소 : 서울특별시 금천구 가산디지털1로 168 A-318(가산동,우림라이온스밸리)<br />
			사업자등록번호 : 119-86-90076 | Tel : 02-853-4560 | Fax : 0505-845-4560<br />
			관리책임자 : 세무법인위드 | 이메일 : iwithsemu@naver.com | copyright 세무법인위드 Co. Ltd. All rights reserved. 
		</em>
	</div>
</div>