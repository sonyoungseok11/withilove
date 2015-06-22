<?php
include_once ("./_common.php");
include_once("$root/subhead.php");
?>
<style type="text/css">
.page_title{font-size:17pt;font-weight:bold;line-height:50px;padding:40px 0 20px 105px; position:relative;}
.page_title:before {content:"▶"; display:inline-block; font-size:15pt; color:#4383fc; position:absolute; top:40px; left:80px;}
.page_stitle{font-size:15pt;font-weight:bold;line-height:30px;padding:10px 0 20px 125px; position:relative;}
.page_stitle:before {content:"●"; display:inline-block; font-size:8pt; color:#ff5e52; position:absolute; top:10px; left:105px;}
#cont_box .page_sub_text {font-size:15pt; color:#4383fc;font-weight:bold; margin-bottom:20px; letter-spacing: -1px; padding-left:130px;}
#tax_appinfo ul li {width:1000px; margin-bottom:30px;padding-top:30px;}
#tax_appinfo ul li:after {content:""; display:block; clear:both;}
#tax_appinfo ul li .appinfo_detail {width:1000px; position:relative; float:left;}
#tax_appinfo ul li .appinfo_detail.right {float:left;}
#tax_appinfo ul li .appinfo_detail >img {float:left; padding-right:30px;}
#tax_appinfo ul li .appinfon_detail .appinfo_text {padding-left:0px; position:relative}
#tax_appinfo ul li .appinfo_detail {line-height:20px; padding:0px 0px 0px 130px;}
#tax_appinfo ul li .appinfo_detail p.name {position:relative; font-size:11pt; margin-bottom:6px; font-weight:bold; font-size:15pt}
.appinfo_text span{color:#4383fc;}
</style>


<div id="cont_box">
	<div class="page_title">학원 어플 이용 안내</div>
  <div class="page_stitle">위드 세무 어플</div>
    <div class="page_sub_text">세무 내역을 홈페이지와 동시에 어플에서도 확인 하실 수 있습니다.</div>
  <div id="tax_appinfo">
    	<ul>
       	  <li>
				<div class="appinfo_detail">
					<img src="<?=$path?>/images/sub/tax/appinfo1.jpg" width="496" height="278"/>
					<div class="appinfo_text">
                   		<p><span>위드에서는 추가 비용 없이 홈페이지 및 어플(핸드폰)<br/>
                      서비스를 제공합니다.</span></p>
						· 홈페이지 및 어플을 통해서 월별 수입금액 자동조회 및<br>
						&nbsp;인건비 등의 주요비용을 매달 간편하게 확인할 수 있습니다.<br/>
						· 한 눈에 보이는 동종업종과의 비율분석을 통해 손쉽게 현황<br/>
						&nbsp;을 파악하고 자기진단이 가능합니다.<br/><br/>
						· 구글 플레이 스토어에서 ‘세무법인 위드 학원 세무관리’<br/>
						&nbsp;로 검색하시면 어플을 다운 받으실 수 있습니다.<br/>
                  </div>
                </div>
				
            </li>
		</ul>
	</div>
    <div class="page_stitle">위드 출석 어플</div>
    <div class="page_sub_text">학생의 출석 상황을 학부모님과 학생이 동시에 어플에서 확인할 수 있습니다.</div>
      <div id="tax_appinfo">
            <ul>
              <li>
                    <div class="appinfo_detail">
                        <img src="<?=$path?>/images/sub/tax/appinfo2.jpg" width="232" height="330"/>
                        <div class="appinfo_text">
                            <p><span>※ 사용 방법</span></p>
                            1) 태그 스티커를 학원 출입구에 부착합니다.<br>
                            2) 원장님이 다운받은 태그 조회 어플을 실행시켜 태그를 조회합니다.<br/>
                            3) 학부모님은 학부모님용 어플을, 학생은 학생용 어플을 각각 다운 받습니다.<br/>
                            4) 학생이 어플을 실행 시킨 상태에서 휴대폰을 학원 스티커에 태그시킵니다.<br/>
                            5) 출석 상황이 어플에 기록됩니다.<br/>
                            6) 태그 된 내용을 각각의 어플에서 확인하실 수 있습니다.<br />
                            <span>※ 원장님은 학원.biz홈페이지에서 전체적인 출석 상황을 확인하실 수 있습니다. </span><br />
                            <br/>
                        </div>
                    </div>
                    
              </li>
            </ul>
      </div>
      <div class="page_stitle">위드 학원 버스 위치 조회 어플</div>
  	  <div class="page_sub_text">실시간 학원 버스 위치 조회 어플을 통해 학생의 안전한 통학을 학부모님이 확인하실 수 있습니다.</div>
      <div id="tax_appinfo">
            <ul>
              <li>
                    <div class="appinfo_detail">
                        <img src="<?=$path?>/images/sub/tax/appinfo3.jpg" width="321" height="390"/>
                        <div class="appinfo_text">
                            <p class=""><span>※ 사용 방법</span></p>
                            1) 태그를 학원 버스 기사님 또는 인솔 교사님의 핸드폰에 부착합니다.<br>
                            2) 학원 버스 위치 조회 어플을 학부모님 핸드폰에 다운 받습니다.<br/>
                            3)어플을 실행시키시면 지도상에 버스 위치가 실시간으로 표시됩니다.<br /><br />
                            <span>※ 이렇게 활용하세요.</span><br />
                            1) 학생의 안전한 통학을 확인하세요.<br/>
                            2) 실시간 위치 확인 후 대략적인 버스 도착 시간에 맞춰 나가시면<br/>
                           밖에서 버스를 기다리는 시간을 줄이실 수 있습니다. 
                        </div>
                    </div>
                    
              </li>
            </ul>
      </div>
</div>
<?php
include_once("$root/subfoot.php");
?>