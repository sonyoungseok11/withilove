<?php
include_once ("./_common.php");
include_once("$root/subhead.php");
?>
<style type="text/css">
.page_title{font-size:17pt;font-weight:bold;line-height:50px;padding:40px 0 20px 105px; position:relative;}
.page_title:before {content:"▶"; display:inline-block; font-size:15pt; color:#4383fc; position:absolute; top:40px; left:80px;}
.withsign{font-size:15pt; color:#4383fc; font-weight:bold; text-align:right; position:relative; text-align:right; margin:-50px 300px 200px 0px;}
.withsign img{ vertical-align: bottom;}
#cont_box .page_sub_text {font-size:15pt; color:#4383fc;font-weight:bold; margin-bottom:20px; letter-spacing: -1px; padding-left:130px;}
#cont_box .page_sub_text > span {font-size:20pt; color:#c6c6c6}
#cont_box .sub_text > span {color:#4383fc}
#cont_box .page_sub_text + .page_sub_text {padding-left:330px;}
#cont_box .sub_text {padding:20px 0px 100px 130px; line-height:25px; font-size:10pt;}
</style>

<ul id="Tabs">
	<li><a href="sub1">대표 인사말</a></li>
	<li><a href="sub2">원장 인사말</a></li>
</ul>
<div id="sub1">
	<div id="cont_box">
      <div class="page_title">대표 인사말</div>
        <span class="page_sub_text">교육원 설립의  목적</span>
              <p class="sub_text">
                십수년동안 교육사업에 매진하면서 일선 원장님들이 학원의 운영외에도<br/>
                많은 애로 사항들이 있다는 것을 보면서 좀 더 현실적으로 도움을 드릴 수 있는<br/>
                부분이 없을까 고심을 한 끝에 교육원을 설립하게 되었습니다.<br /><br/>
                
                그리고 다양한 업종의 학원경영및 운영등에 도움이 될 전문분야의 지식인과<br />
                연사분들이 위드프랭즈교육원과 함께 원장님들을 보필하게 될 것입니다.<br/><br/>
                
                앞으로는 학원의 어렵고 힘든 부분을 전문적이고 노하우가 있는 분들을<br />
                더 많이 모셔서 원장님들은  아이들 교육에만 전념하실 수 있도록<br />
                도움을 주는 교육원이 되겠습니다.<br />
                <br />
                <br />
                원장님 with 프랭즈<br />
                감사합니다.<br/>
                <br />
              </p>
                <div class="withsign">
                    <span><img src="../../images/sub/career/sign2.png" /> 올림</span>
                </div>
        
    </div>
</div>
<div id="sub2">
	<div id="cont_box">
      <div class="page_title">원장 인사말</div>
        <span class="page_sub_text">위드프랭즈교육원을 방문해 주신 것을 진심으로 환영합니다.</span>
              <p class="sub_text">
                <span>
                21세기는 지식을 많이 알고 있는 것보다는 가지고 있는 지식을 잘 활용하고,<br/>
                이를 바탕으로 새로운 지식을 창출해내는 능력을 발휘하는 창의적 인재를 요구합니다.<br/>
                </span>
                또한 무한 경쟁시대에 글로벌 리더로 성장하기 위해서는<br />
                리더십 뿐만 아니라 의사소통, 인성교육이 우선되어야 합니다.<br />
                새로운 시대를 이끌어갈 창의적 글로벌 인재를 양성하고자 하는 것이<br/>
                원장님들의 궁극적인 방향이고<br />
                이를 위해서는 원장님들의 변화 또한 절실합니다.<br />
                <span>
                본 교육원은 시대가 요구하는 다양한 맞춤형 교육을 통해 아이들의 교육과 원을 운영하는데<br />
                실질적인 도움을 줄 수 있는 견인차 역할을 수행할 수 있도록 최선을 다하고 있습니다.
                </span>
                <br />
                <br />
                또한 위드프랭즈 교육원은 원장님과 함께 하는 창의 공동체로서<br />
                원장님의 수요에 따른 수준 높은 교육 프로그램을 운영하기 위해<br/>
                최선의 노력을 기울일 것을 약속드립니다.<br />
                <br />
                <br />
                뜻을 같이하는 많은 원장님과 호흡하고 함께 갈 수 있기에 멀리 갈 수 있다고 생각합니다.<br />
                오늘도 고되지만 성장하시는 하루 되시길 기원합니다.<br/>
                감사합니다.
              </p>
                <div class="withsign">
                    원장
                    <img src="../../images/sub/career/sign.png" width="120" height="56" />
                </div>
        
    </div>
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




