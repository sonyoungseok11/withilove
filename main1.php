<div class="container bg1">
	<div class="container_wrap">
		<h2 class="bg_title"><span class="blind">학원세무전문교육 위드프랭즈</span></h2>
		<?php include_once("$path/inc/shortcutmenu.php");?>
		<!-- main content -->
		<div class="main_content">
			<ul class="grid">
				<li class="col1">
					<div class="seminar">
						<a href="./sub_etc/acadmy_schedule/event_seminar.php"><span class="blind">학원세무세미나</span></a>
					</div>
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
							<li class="pic1"><a href="<?=$root?>/sub_tax/aboutas/introduce.php" style="display:block; height:100%;"></a></li>
							<li class="pic2"><a href="<?=$root?>/sub_tax/aboutas/introduce.php" style="display:block; height:100%;"></a></li>
							<li class="pic3"><a href="<?=$root?>/sub_tax/aboutas/introduce.php" style="display:block; height:100%;"></a></li>
							<li class="pic4"><a href="<?=$root?>/sub_tax/aboutas/introduce.php" style="display:block; height:100%;"></a></li>
                            <li class="pic5"><a href="<?=$root?>/sub_tax/aboutas/introduce.php" style="display:block; height:100%;"></a></li>
                            <li class="pic6"><a href="<?=$root?>/sub_tax/aboutas/introduce.php" style="display:block; height:100%;"></a></li>
                            <li class="pic7"><a href="<?=$root?>/sub_tax/aboutas/introduce.php" style="display:block; height:100%;"></a></li>
                            <li class="pic8"><a href="<?=$root?>/sub_tax/aboutas/introduce_labor.php" style="display:block; height:100%;"></a></li>
                            <li class="pic9"><a href="<?=$root?>/sub_tax/aboutas/introduce_lawyer.php" style="display:block; height:100%;"></a></li>
                            <li class="pic10"><a href="<?=$root?>/sub_tax/aboutas/introduce_legalstaff.php" style="display:block; height:100%;"></a></li>
						</ul>
						<a href="#" class="prev">◀</a>
						<a href="#" class="next">▶</a>
						<ul class="roll_navi">
							<li><a href="./sub_tax/aboutas/introduce.php"></a></li>
							<li><a href="./sub_tax/aboutas/introduce.php"></a></li>
							<li><a href="sub_tax/aboutas/introduce.php"></a></li>
							<li><a href="sub_tax/aboutas/introduce.php"></a></li>
                            <li><a href="sub_tax/aboutas/introduce.php"></a></li>
                            <li><a href="sub_tax/aboutas/introduce.php"></a></li>
                            <li><a href="sub_tax/aboutas/introduce.php"></a></li>
                            <li><a href="sub_tax/aboutas/introduce_labor.php.php"></a></li>
                            <li><a href="sub_tax/aboutas/introduce_law.php"></a></li>
						</ul>
					</div>
					<script type="text/javascript">
						$('.roll_banner').roll_banner({'delay' : 3000, navi : 'hide'});
					</script>
				</li>
			</ul>
			<ul class="grid">
				<li class="col1">
					<div class="info_tip">
						<a href="javascript:alert('준비중 입니다.');"><img src="<?=$path?>/images/friengsedu/tip1_1.png" alt="영어지도사" /></a>
						<a href="/sub_tax/academy/cash_receipt.php"><img src="<?=$path?>/images/friengsedu/tip1_2.png" alt="학원어플" /></a>
						<a href="http://withfriengs.com/" target="_blank"><img src="<?=$path?>/images/friengsedu/tip2_1.png" alt="학원전용교육원 위드프랭즈" /></a>
						<a href="./sub_tax/saving_tip/evidence.php"><img src="<?=$path?>/images/friengsedu/tip2_2.png" alt="원장님만의 절세Tip" /></a>
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