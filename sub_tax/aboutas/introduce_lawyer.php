<?php
include_once ("./_common.php");
include_once("$root/subhead.php");
?>
<style type="text/css">
.page_title{font-size:17pt;font-weight:bold;line-height:50px;padding:40px 0 20px 105px; position:relative;}
.page_title:before {content:"▶"; display:inline-block; font-size:15pt; color:#4383fc; position:absolute; top:40px; left:80px;}
#tax_person {padding-bottom:100px;}
#tax_person ul li {width:1000px; margin-bottom:30px; border-top:1px solid #ccc; padding-top:30px;}
#tax_person ul li:first-child {padding-top:none; border-top:none;}
#tax_person ul li:after {content:""; display:block; clear:both;}
#tax_person ul li .person_detail {width:500px; position:relative; float:left;}
#tax_person ul li .person_detail.right {float:left;}
#tax_person ul li .person_detail >img {float:left;}
#tax_person ul li .person_detail .person_text {padding-left:295px; position:relative}
#tax_person ul li .person_detail .person_text:before {content:"· 경   력 :"; display:block; position:absolute; left:230px; top:26px; white-space:pre-wrap; color:#4383fc; font-size:11pt;font-weight:bold;}
#tax_person ul li .person_detail {line-height:20px}
#tax_person ul li .person_detail p.name {position:relative; font-size:11pt; margin-bottom:6px; font-weight:bold; font-size:15pt}
#tax_person ul li .person_detail p.name:before {content:"· 세   중 :"; display:block; position:absolute; left:-66px; top:0px; color:#4383fc; font-size:11pt; font-weight:bold; white-space:pre-wrap;}
</style>
<div id="cont_box">
	<div class="page_title">변호사 소개</div>
	<div id="tax_person">
    	<ul>
        	<li>
				<div class="person_detail">
					<img src="<?=$path?>/images/sub/tax/photo_sejoong1.jpg" width="240" height="240" alt="이상국 변호사 사진"/>
					<div class="person_text">
                   		<p class="name">이상국 대표변호사</p>
						중앙대학교법학과 졸업<br/>
						사법시험 27회 합격<br/>
						UC BERKELEY 연수<br/>
						서울시청 법률상담 변호사<br/>
						북한이탈주민 법률지원변호사<br/>
						외국법연수과정수료(외국법연수원)<br/>
						한양대학교 최고경영자과정 수료<br/>
						법무법인 세중 창립<br/><br/>
                        
                        < 활동 ><br/>
                        San Francisco International Program 한국담당<br/>
                        미국이민/투자/비자업무 수행<br/>
                        사단법인 아시아과학인재포럼 감사<br/>
                        신용보증기금, 기술신용보증기금, 대한주택공사 고문<br/>
                    </div>
                </div>
				<div class="person_detail right">
					<img src="<?=$path?>/images/sub/tax/photo_sejoong2.jpg" width="240" height="240" alt="김지영 센터장 사진"/>
				  <div class="person_text">
                        <p class="name">김지영 센터장</p>
						사단법인 해외이주협회 이사<br />
						국민이주(주), 국민에듀(주) 대표이사<br />
						고려대학교 최고경영자과정 수료<br />
						고려대학교 교육대학원<br />
						호주 Charles Sturt 대학교 Business 전공<br />
						전남대 전자공학과<br /><br/>
                        
                        < 활동 >					  
						15년 경력, 약 2,000케이스 이상을 진행한 이민/유학 전문가<br />
						국내 최초 건실한 사업체를 발굴하여 해외투자와 이민병합<br />
						프로그램 탄생(대교, 웅진씽크빅, 카페베네, 교촌치킨, 모닝글로리,
에듀왕, 더페이스샵, 페르마, 리딩타운, 왕수학 등등)<br />
						KB 국민은행, 중앙일보, 알리안츠 생명 업무제휴, 강의<br />
                  </div>
                </div>
            </li>
		</ul>
	</div>

</div>
<?php
include_once("$root/subfoot.php");
?>