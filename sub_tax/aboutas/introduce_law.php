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
#tax_person ul li .person_detail p.name:before {content:"· 법무사 :"; display:block; position:absolute; left:-66px; top:0px; color:#4383fc; font-size:11pt; font-weight:bold;}
</style>
<div id="cont_box">
	<div class="page_title">법무사 소개</div>
	<div id="tax_person">
    	<ul>
        	<li>
				<div class="person_detail">
					<img src="<?=$path?>/images/sub/tax/photo_law_1.jpg" width="240" height="240" alt="김제하 노무사 사진"/>
					<div class="person_text">
               		  <p class="name">정택근</p>
                   		<p>경남 진주생<br />
                   		  고대 법대졸<br />
                   		  법무사 시험(11회)<br />
                   		  성문사무소(이혼,개명 등 가사)<br />
                   		  로하임사무소(소액소송)<br />
                   		  호주제폐지(성.본결정,최초,최다결정)<br />
                   		  소비자보호원상담<br />
                   		  중앙지방법원상담위원<br />
               		    법무사저널 자문<br />
               		    다수 세무법인 자문<br />
               		    로&amp;택스인(주)대표이사<br />
                   		  <br />
               		  </p>
               		  	<p>
                             &lt; 저서 &gt;
                            <p>&ldquo; 종합실무 &rdquo;(민사,집행,가사,등기,공탁,형사(2012 법률&amp;출판)<br />
                        &ldquo; 성과본,개명,친양자&rdquo; (2010 법률&amp;출판)</p>
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