<?php
include_once ("./_common.php");
include_once("$root/subhead.php");
?>
<style type="text/css">
.page_title{font-size:17pt;font-weight:bold;line-height:50px;padding:40px 0 20px 105px; position:relative;}
.page_title:before {content:"▶"; display:inline-block; font-size:15pt; color:#4383fc; position:absolute; top:40px; left:80px;}
#cont_box .page_sub_text {font-size:15pt; color:#4383fc;font-weight:bold; margin-bottom:20px; letter-spacing: -1px; padding-left:130px;}
#cont_box .page_sub_text > span {font-size:20pt; color:#c6c6c6}
#cont_box .sub_text > span {color:#4383fc}
#cont_box .page_sub_text + .page_sub_text {padding-left:330px;}
#cont_box .sub_text {padding:20px 0px 100px 130px; line-height:25px; font-size:10pt;}
#cont_box > dl {padding:0px 0px 100px 130px; line-height:25px; font-size:10pt;}
.sub_ol_padding { padding:10px 0 10px 20px;} 
#cont_box dt, li > span{color:#4383fc}
#cont_box dt{padding-top:20px;}
</style>

<div id="cont_box">
  <div class="page_title">공제 활용</div>
  <div class="page_sub_text">소득공제 및 세액공제 100% 활용하기</div>
	<dl>
        <dt><strong>1)소득공제</strong></dt>
        <dd>
             <ol class="sub_ol_padding">
                 <li>
                 	(1) 기본공제: 1인당 150만 원 공제
                      <ol class="sub_ol__padding">
                    	<li>① 본인공제</li>
                        <li>② 배우자공제- 연간 소득금액 100만 원 이하</li>
                        <li>
                        	③ 부양가족공제 - 연간 소득금액 100만 원 이하<br>
                        	&nbsp;&nbsp;&nbsp;- 20세 이하 60세 이상(단, 장애인은 나이제한 없음)
                      </li>
                    </ol>
                 </li>
                 <li>
                 	(2) 추가공제
                    <ol class="sub_ol__padding">
                    	<li>① 경로우대자공제- 70세 이상(1인당 100만 원)</li>
                        <li>② 장애인공제- (1인당 200만 원)</li>
                        <li>③ 한부모공제- 배우자 없는 직계비속, 입양(1인당 100만 원)</li>
                        <li>
                        	④ 부녀자공제- 배우자 없이 부양가족있는 세대주 or 배우자 있는 여성(1인당 50만원)<br>
                        	&nbsp;&nbsp;&nbsp;- 종소금액 3,000만 이하 만 적용하며, 근로장려금과 중복 불가<br>
                            &nbsp;&nbsp;&nbsp;<span>* 한부모공제와 부녀자공제 모두 해당하는 경우 한부모공제만 적용</span>
                        </li>
                    </ol>
                 </li>
                 <li>
                 	(3) 조세제한특례법상 소득공제
                    <ol class="sub_ol__padding">
                    	<li>
                        	① 고용유지중소기업에 대한 소득공제<br/>
                            &nbsp;:(직전상시근로자 1인당 연간임금총액-당해상시근로자 1인당 연간임금총액) x 당해상시근로자수  x 50%
                        </li>
                        <li>
                        	② 고용유지중소기업의 상시근로자에 대한 소득공제<br/>
                            &nbsp;:min(① 직전근로자 연간 임금총액-당해 근로자 연간 임금총액)*50%, ② 1,000만원)
                        </li>
                        <li>
                        	 ③ 소기업·소상공인 공제부금에 대한 소득공제<br/>
                            &nbsp;:min(공제부금 납부액, 300만원)
                        </li>
                    </ol>
                 </li>
                 <li>
                 	(4) 종합소득공제 한도<br/>
                    &nbsp;&nbsp;&nbsp;소득공제 합계액이 2,500만원을 한도로 공제<br/>
                 </li>
            </ol>
        </dd>
        <dt><strong>2) 세액공제</strong></dt>
        <dd>
             <ol class="sub_ol__padding">
                 <li>
                 	(1) 기장세액공제<br/>
                        &nbsp;&nbsp;&nbsp;간편장부대상자가 복식부기에 따라 종합소득세 확정신고를 한 경우 <br/>
                        &nbsp;&nbsp;&nbsp;min(산출세액의 20%, 100만원)
                 </li>
                <li>
                 	(2) 자녀세액공제(소득공제에서 세액공제로 전환)<br/>
                    &nbsp;&nbsp;&nbsp;1명*15만원이며 3명째부터는 20만원 합산공제
                </li>
                <li>
                 	(3) 연금계좌세액공제(소득공제에서 세액공제로 전환)<br/>
                    &nbsp;&nbsp;&nbsp;연금(연금저축, 퇴직연금)계좌에 납입- 연 400만 원*12% 
                </li>
                <li>
                 	(4) 특별세액공제 : 연 7만원 
                </li>
                <li>
                 	(5) 기부금세액공제 
                </li>
            </ol>
        </dd>
    </dl>
</div>
<?php
include_once("$root/subfoot.php");
?>


