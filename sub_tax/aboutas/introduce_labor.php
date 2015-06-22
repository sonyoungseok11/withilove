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
#tax_person ul li .person_detail .person_text:before {content:"· 경   력 :"; display:block; position:absolute; left:230px; top:26px; white-space:pre-wrap; color:#4383fc; font-size:11pt;font-weight:bold;}
#tax_person ul li .person_detail {line-height:20px}
#tax_person ul li .person_detail p.name {position:relative; font-size:11pt; margin-bottom:6px; font-weight:bold; font-size:15pt}
#tax_person ul li .person_detail p.name:before {content:"· 노무사 :"; display:block; position:absolute; left:-66px; top:0px; color:#4383fc; font-size:11pt; font-weight:bold;}
</style>
<div id="cont_box">
	<div class="page_title">노무사 소개</div>
	<div id="tax_person">
    	<ul>
        	<li>
				<div class="person_detail">
					<img src="<?=$path?>/images/sub/tax/photo_labor_1.jpg" width="240" height="240" alt="김제하 노무사 사진"/>
					<div class="person_text">
                   		<p class="name">김제하</p>
                   		<p>現 태평노무법인 대표공인노무사<br />
                   		  現 인천시 학원 연합회 자문노무사<br />
                   		  現 인천지방노동위원회 국선노무사 <br />
                          現 중앙노동위원회 국선노무사<br />
                   		  現 중앙육아보육지원센터 전문가상<br />
                          現 고용노동부 자율점검위촉노무사<br />
                   		  現 중소기업청 비즈니스 파트너<br /><br />
                        </p>
               		  	<p>
                             &lt; 학력 &gt;
                            <p>인천고등학교<br />
                            성균관대학교 경영학과 졸업
                        </p>
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