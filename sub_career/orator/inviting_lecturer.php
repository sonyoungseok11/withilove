<?php
include_once ("./_common.php");
include_once("$root/subhead.php");
?>

<style type="text/css">
.page_title{font-size:17pt;font-weight:bold;line-height:50px;padding:40px 0 20px 105px; position:relative;}
.page_title:before {content:"▶"; display:inline-block; font-size:15pt; color:#4383fc; position:absolute; top:40px; left:80px;}
#tax_person ul li {width:1000px; margin-bottom:30px; border-top:1px solid #ccc; padding-top:30px;}
#tax_person ul li:first-child {padding-top:none; border-top:none;}
#tax_person ul li:after {content:""; display:block; clear:both;}
#tax_person ul li .person_detail {width:500px; position:relative; float:left;}
#tax_person ul li .person_detail.right {float:left;}
#tax_person ul li .person_detail >img {float:left;}
#tax_person ul li .person_detail .person_text {padding-left:295px; position:relative}
#tax_person ul li .person_detail .person_text:before {content:"· 경      력 :"; display:block; position:absolute; left:220px; top:26px; white-space:pre-wrap; color:#4383fc; font-size:11pt;font-weight:bold;}
#tax_person ul li .person_detail {line-height:20px}
#tax_person ul li .person_detail p.name {position:relative; font-size:11pt; margin-bottom:6px; font-weight:bold; font-size:15pt; padding-left:0px;}
#tax_person ul li .person_detail p.name:before {content:"· 초청강사 :"; display:block; position:absolute; left:-76px; top:0px; color:#4383fc; font-size:11pt; font-weight:bold;}
</style>
<div id="cont_box">
	<div class="page_title">초청강사</div>
	<div id="tax_person">
    	<ul>
        	<li>
				<div class="person_detail">
					<img src="<?=$path?>/images/sub/career/photo_music.jpg" width="240" height="240" alt="강준혁 고래뮤직스튜디오 대표 사진"/>
					<div class="person_text">
               		  <p class="name">강준혁 대표</p>
						고래뮤직스튜디오 대표<br>
						4개지점 음악연습실 운영중<br>
						한국CRM경영자협회 부의장<br>
						일본 뮤즈음악대 졸업<br>
						한국, 일본, 미국에서  라이브&amp;레코딩<br>
						세션 드러머로 10여년간 활동하다가<br>
                        사업가의 삶을 연주하고 있음.<br>
					</div>
                </div>
				<div class="person_detail">
					<img src="<?=$path?>/images/sub/career/photo_hwang.jpg" width="240" height="240" alt="황태숙 사장님 사진"/>
					<div class="person_text">
               		  <p class="name">황태숙 대표</p>
						(현)<주>중앙아이비교육 설립<br>
						(청소년 영자신문 아이비뉴스 발행)<br>
						푸른영어 전국 총 본부장 역임<br>
						<주>틴타임즈 교육사업부 본부장 역임<br>
					</div>
                </div>
            </li>
			
			
		</ul>
	</div>
    <!---end cont_box----------------------------------------------------------->
</div>

<?php
include_once("$root/subfoot.php");
?>