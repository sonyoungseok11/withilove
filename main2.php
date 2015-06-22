<div class="container bg2">
	<div class="container_wrap">
		<h2 class="bg2_title"><span class="blind">진로 진학 교육 위드프랭즈</span></h2>
		<?php include_once("$path/inc/shortcutmenu.php");?>
		<!-- main content -->
		<div class="main_content">
			<ul class="grid">
				<li class="col1">
					<embed width="300" height="165" src="http://www.youtube.com/v/y4ZzWpj7nS8" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true"></embed>
				</li>
				<li class="col2">
					<div class="board_tab ">
						<div class="tab list jx">
							<ul>
								<?=getBoardLatest(1,5,$last1)?>
								<?=getBoardLatest(33,5,$last2)?>
							</ul>
						</div>
					</div>
				</li>
				<li class="col3">
					<div class="roll_banner">
						<ul class="roll">
							<li class="fpic1"><a href="<?=$root?>/sub_career/orator/instructor.php" style="display:block; height:100%;"></a></li>
							<li class="fpic2"><a href="<?=$root?>/sub_career/orator/instructor2.php" style="display:block; height:100%;"></a></li>
							<li class="fpic3"><a href="<?=$root?>/sub_career/orator/inviting_lecturer.php" style="display:block; height:100%;"></a></li>
							<li class="fpic4"><a href="<?=$root?>/sub_career/orator/inviting_lecturer.php" style="display:block; height:100%;"></a></li>
						</ul>
						<a href="#" class="prev">◀</a>
						<a href="#" class="next">▶</a>
					</div>
					<script type="text/javascript">
						$('.roll_banner').roll_banner({'delay' : 3000, navi : 'hide'});
					</script>
				</li>
			</ul>
			<ul class="grid">
				<li class="col1">
					<div class="info_tip">
						<a href="http://edu-bay.com" class="tip1"><img src="<?=$path?>/images/main2/ftip1.png" alt="홍보물,전단,배너,에듀베이바로가기" /></a>
						<a href="http://onetwokids.co.kr/" class="tip2"><img src="<?=$path?>/images/friengsedu/tip2.png" alt="교재교구원투교육사" /></a>
						<a href="http://neenglish.co.kr" target="_blank" class="tip3"><img src="<?=$path?>/images/main2/ftip3.png" alt="네잉글리쉬페이지" /></a>
					</div>
				</li>
				<li class="col2">
					<div class="info_tip2">
						<a href="http://www.학원.biz" class="tip4_1" target="_blank"><img src="<?=$path?>/images/friengsedu/tip4_1.jpg" alt="학원.biz 이용하기" /></a>
						<a href="./sub_tax/offer/contract_counsel.php" class="tip5"><img src="<?=$path?>/images/friengsedu/tip5_6.jpg" alt="학원노무상담" /></a>
						<a href="./sub_tax/aboutas/list.php" class="tip4_2"><img src="<?=$path?>/images/friengsedu/tip4_2.jpg" alt="위드프랭즈 교육원 세무계약 리스트" /></a>
						<a href="./sub_tax/offer/contract_counsel.php" class="tip7"><img src="<?=$path?>/images/friengsedu/tip7_8.jpg" alt="학원법률상담" /></a>
					</div>
				</li>
				<li class="col3">
					<div class="info_tip3">
						<a href="./sub_etc/cooperative_firm/cooperation_introduce.php" class="tip8"><img src="<?=$path?>/images/main1/btn_email.jpg" alt="협력업체를 모십니다" /></a>
						<a href="./sub_etc/community/keyman.php" class="tip9"><img src="<?=$path?>/images/main1/btn_board.jpg" alt="키맨을 모십니다" /></a>
						<a href="./sub_etc/community/speaker.php" class="tip10"><img src="<?=$path?>/images/main1/btn_tax.jpg" alt="연사를 모십니다" /></a>
					</div>
				</li>
			</ul>
		</div>
		<!-- //main content -->
	</div>
</div>