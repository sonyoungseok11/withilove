<?php
include_once ("./_common.php");
include_once("$root/subhead.php");
?>
<style>
.ivy {text-align:center; padding-bottom:100px;}
.ivy .blue_table {margin-top:20px;}
.ivy .blue_table table {border-collapse:collapse; margin:0 auto;}
.ivy .blue_table table th, .ivy .blue_table table td {font-size:16px; font-weight:bold; border:1px solid #081c6a; padding:10px 14px; text-align:left; line-height:30px}
.ivy .blue_table table th {background:#3563c2; color:#FFF; padding:inherit 26px; text-align:right }
.ivy .blue_table table .center {text-align:center;}
.ivy .blue_table table .left {text-align:left;}
.ivy .blue_table table td > ul > li {position:relative; padding-left:14px;}
.ivy .blue_table table td > ul.detail {font-size:14px; line-height:24px;}
.ivy .blue_table table td > ul > li .bull {
	position: absolute;
	left: -10px;
}
.ivy .blue_table table td.img {padding:0; text-align:center; line-height:normal;}
.ivy .blue_table table tr.brown td {background:#c8a67a; color:#FFF; padding:15px 25px; vertical-align:top; font-size:12px; line-height:22px}
.ivy .blue_table table tr.hotel_th th {font-size:14px;}
.ivy .titleimg {background: url(../../images/ivy_league/titles.png) no-repeat; height:40px; margin-bottom:10px; margin-top:50px;}
.ivy .titleimg.t2 {background-position: 0 -50px;}
.ivy .titleimg.t3 {background-position: 0 -100px;}
.ivy .titleimg.t4 {background-position: 0 -150px;}
.ivy .titleimg.t5 {background-position: 0 -200px; margin-top:0px;}
.ivy .titleimg.t6 {background-position: 0 -250px; height: 216px; margin-bottom:0px;}
.ivy .titleimg.t7 {background-position: 0 -500px;}
.ivy .titleimg.t8 {background-position: 0 -550px; height:42px;}
.ivy .titleimg.t9 {background-position: 0 -600px; height:42px;}

.ivy .red {color:#ff1c5c}
.ivy .right20 { text-align:right; padding-right:150px;}
.ivy .red .big { font-size:22px; font-family:times}
.ivy .blue {color:#3563c2;}
.ivy .red2 {color:#d32620;}
.ivy .sky {color: #2eafc7}

.ivy .t_info {margin-top:8px; font-size:14px;}
.ivy p.t_info {text-align:left; padding-left:110px;}
.ivy .air_info {width:790px; margin:0 auto; font-size:16px; font-weight:bold; text-align:right;line-height:30px; box-sizing:border-box;}
.ivy .air_info .air_text {padding-right: 300px; background:url(../../images/ivy_league/air.jpg) no-repeat bottom right; width:700px; box-sizing:border-box; }
.ivy .letter {height:910px; width:790px; background:url(../../images/ivy_league/letter.jpg) no-repeat center bottom; margin:0 auto;}
.ivy .letter .letter_text {text-align:left; padding-left:85px; padding-top:40px; font-size:14px; line-height:30px; font-family:'Batang';}
.ivy .blue_table .topic {width:86%; margin:0 auto; padding-left:40px; position:relative; font-family:'Batang'; font-size:14px; text-align:left; box-sizing:border-box;}
.ivy .blue_table .topic:before { content:"주제 :" ; color: #ff1c5c; position:absolute; left:0px;}
</style>
<div class="ivy">
	<img src="<?=$path?>/images/ivy_league/img_top.jpg" alt="아이비리그투어 소개" />
	<div class="blue_table">
		<table width="790">
			<caption class="titleimg t1"><span class="blind">명품아이비리그 투어 개요</span></caption>
			<colgroup>
				<col  width="150">
				<col  width="auto">
			</colgroup>
			<thead>
				<tr>
					<th>구분</th>
					<th class="center">내용</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>기간</th>
					<td>6박 8일</td>
				</tr>
				<tr>
					<th>대상</th>
					<td>초등 4 ~ 고등 1학년</td>
				</tr>
				<tr>
					<th>탐방대학</th>
					<td>
						프린스턴, 콜럼비아, 뉴욕대, 예일, MIT, 하버드
						<div class="red right20">→ 재학생 또는 현지 전문 인솔자 주관 및 랩실 체험</div>
					</td>
				</tr>
				<tr>
					<th>탐방 도시</th>
					<td>워싱턴, 뉴저지, 뉴욕, 뉴헤이븐, 보스턴등 미국 5개도시 견학</td>
				</tr>
				<tr>
					<th>문화체험</th>
					<td>백악관, 자연사 박물관, 한국전참전기념비, 엠파이어빌딩 전망대, 페리 탑승 등</td>
				</tr>
				<tr>
					<th>특장점</th>
					<td>
						<ul class="red">
							<li><span class="bull">&bull;</span>미국 현지에서 성공한 주지사 및 대학 교수들과의 글로벌 리더쉽에 관한 좌담회 개최!</li>
							<li><span class="bull">&bull;</span>명문 MIT & 하버드대학교 <span class="big blue">1-day Study!</span></li>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div class="blue_table">
		<table width="790">
			<caption class="titleimg t2"><span class="blind">아이비리그투어 출발 일정안내</span></caption>
			<colgroup>
				<col  width="12.5%">
				<col  width="12.5%">
				<col  width="12.5%">
				<col  width="12.5%">
				<col  width="12.5%">
				<col  width="12.5%">
				<col  width="12.5%">
				<col  width="12.5%">
			</colgroup>
			<thead>
				<tr>
					<th class="center">월</th>
					<th class="center">출발</th>
					<th class="center">시간</th>
					<th class="center">귀국</th>
					<th class="center">시간</th>
					<th class="center">가격</th>
					<th class="center">항공</th>
					<th class="center">좌석</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="center">FEB</td>
					<td class="center">2/23(월)</td>
					<td class="center">11 : 45</td>
					<td class="center">3/2(월)</td>
					<td class="center">19 : 30</td>
					<td class="center">300만</td>
					<td class="center">별도</td>
					<td class="center">10</td>
				</tr>
				<tr>
					<td class="center">MAR</td>
					<td class="center">3/23(월)</td>
					<td class="center">11 : 45</td>
					<td class="center">3/30(월)</td>
					<td class="center">19 : 30</td>
					<td class="center">300만</td>
					<td class="center">별도</td>
					<td class="center">10</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="t_info"> * 일정마다 모집인원이 다 채워지지 않으면, 다음 일정으로 연기됩니다. 연기되는 일정은 사전에 안내 드리겠습니다. </div>
	<div class="air_info">
		<div class="titleimg t3"><span class="blind">아이비리그 투어 이용 항공 안내</span></div>
		<div class="air_text">
			아이비리그 투어와 함께 할 <span class="red">델타항공!<br />
			미국 애틀란타에 본사를 두고 있는 항공사로서</span><br />
			전 세계 88개국 2487개의 도시로 운항을 하고 있습니다.
		</div>
	</div>
	<div class="letter">
		<div class="titleimg t4"><span class="blind">아이비리그 투어 개요</span></div>
		<div class="letter_text">
			<span class="sky">자사는 오랜 기간 미국과 캐나다 등지로 <br />
			국내 많은 학생들을 교환학생 및 유학을 진행해 왔습니다. <br /></span>
			미국과 캐나다라는 나라에 대해 잘 알고, 또한 두 나라의 교육 환경도 잘 알고 있어서 <br />
			다른 여타 모객만으로 끝나는 여행사 또는 유학원과는 다른 <span class="sky">프로그램부터 기획하여 <br />
			현지에서 직접 일일이 다 진행을 해 보면서 꼼꼼하게 시뮬레이션을 하여 진행</span>을 해왔으며,<br />
			아이비리그 대학을 탐방만으로 그치지 않고, <br />
			<span class="red2">아이비리그를 졸업하고 현지에서 성공한 <br />
			주지사, 의원, 대학교수 와의 업무 현장과 연구실을 방문하여 <br />
			그들로부터 글로벌한 시각과 리더쉽에 관해 생생한 내용을 들을 수 있는 시간을 준비하였습니다. <br /></span>
			<br />
			현지의 성공한 사람들을 만나서 나의 꿈과 미래의 나를 간접적으로나마 보여줌으로써,<br />
			미국 아이비리그투어가 단순히 갔다 왔다는 자랑이 되는 것만이 아닌, <br />
			나의 미래의 자화상을 그릴 수 있는 로드맵이 되길 바랍니다. <br />
			<br />
			귀한 자녀들을 보내주시는 만큼, 첫째도 안전, 둘째도 안전을 원칙으로 국내에서 함께 가는 인솔자와 <br />
			현지에서의 가이드가 더블 케어를 함으로써 소중한 자녀들을 안심하고 보내실 수 있습니다.
		</div>
	</div>
	<div class="blue_table">
		<table width="790">
			<caption class="titleimg t5"><span class="blind">아이비리그투어 출발 일정안내</span></caption>
			<colgroup>
				<col  width="90">
				<col  width="126">
				<col  width="auto">
				<col  width="140">
			</colgroup>
			<thead>
				<tr>
					<th class="center">일정</th>
					<th class="center">도시/대학</th>
					<th class="left">세부일정 내역</th>
					<th class="center">비고</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="center">1 day</td>
					<td class="center blue">인청공항/<br />워싱턴D.C</td>
					<td>
						<ul class="detail">
							<li><span class="bull">&bull;</span>인천공항에서 출국 수속 후 DL158편으로 11:45 출발</li>
							<li><span class="bull">&bull;</span>워싱턴 D.C 공항에 16:47pm 도착 후 입국심사</li>
							<li><span class="bull">&bull;</span>현지 전문가이드와 미팅 후 한식당에서 석식</li>
							<li><span class="bull">&bull;</span>호텔로 이동하여 체크인 후 휴식</li>
						</ul>
					</td>
					<td class="img"><img src="<?=$path?>/images/ivy_league/air2.jpg" alt="" /></td>
				</tr>
				<tr>
					<td class="center">2 day</td>
					<td class="center blue">워싱턴D.C</td>
					<td>
						<ul class="detail">
							<li><span class="bull">&bull;</span>호텔 조식 후 워싱턴 D.C 투어</li>
							<li><span class="bull">&bull;</span>세계 정치의 중심부인 <span class="red">백악관</span>과 <span class="red">국회의사당</span> 방문</li>
							<li><span class="bull">&bull;</span>한국전쟁참전을 기념하는 <span class="red">한국전참전기념비</span> 방문</li>
							<li><span class="bull">&bull;</span>역대 미국 대통령 중 최고로 꼽히는 <span class="red">링컨기념관</span> 및 <span class="red">제퍼슨 기념관</span> 방문</li>
							<li><span class="bull">&bull;</span>박물관이 살아있다라는 영화의 배경이 되었던 <span class="red">자연사 박물관</span> 방문 </li>
							<li><span class="bull">&bull;</span>워싱턴 D.C 투어를 마치고 중식 후 이동</li>
							<li><span class="bull">&bull;</span>글로벌 리더쉽에 관해 미국에서 성공한 한인</li>
							<li><span class="bull">&bull;</span>[<span class="red">Mark Keam 버지니아 주의원 강연</span>]에 <span class="red">참석 및 좌담회</span></li>
							<li><span class="bull">&bull;</span>좌담회 후 석식을 위해 이동</li>
							<li><span class="bull">&bull;</span>석식 후 호텔 투숙 및 휴식</li>
						</ul>
					</td>   
					<td class="img"><img src="<?=$path?>/images/ivy_league/img2.jpg" alt="" /></td>
				</tr>
				<tr>
					<td class="center">3 day</td>
					<td class="center blue">뉴저지, 뉴욕/<br /> 프린스턴,<br />콜럼비아 대학</td>
					<td>
						<ul class="detail">
							<li><span class="bull">&bull;</span>호텔 조식 후 캠퍼스 투어를 위해 이동</li>
							<li><span class="bull">&bull;</span><span class="red">프린스턴(PRINCETON)대학교</span> 방문하여 현지 재학생이 학교 곳곳을 안내하는 투어 진행</li>
							<li><span class="bull">&bull;</span><span class="red">콜럼비아(COLUBIA)대학교</span> 방문하여 현지 가이드와 함께 학교 곳곳을 안내하는 투어 진행</li>
							<li><span class="bull">&bull;</span>투어 후 석식을 위해 이동</li>
							<li><span class="bull">&bull;</span>석식 후 호텔 투숙 및 휴식</li>
						</ul>
					</td>   
					<td class="img"><img src="<?=$path?>/images/ivy_league/img3.jpg" alt="" /></td>
				</tr>
				<tr>
					<td class="center">4 day</td>
					<td class="center blue">뉴욕 / <br />뉴욕대학</td>
					<td>
						<ul class="detail">
							<li><span class="bull">&bull;</span>호텔 조식 후 뉴욕 시내 투어를 위해 이동</li>
							<li><span class="bull">&bull;</span>뉴욕시내를 한눈에 볼 수 있는 <span class="red">엠파이어 빌딩</span> 전망대 방문</li>
							<li><span class="bull">&bull;</span>전세계 경제와 문화의 중심지 <span class="red">타임스퀘어 광장</span> 방문</li>
							<li><span class="bull">&bull;</span>미국의 독립을 기념하기 위해 세워진  높이 47M에 달하는 <span class="red">자유의 여신상</span> 방문</li>
							<li><span class="bull">&bull;</span>자유의 여신상 페리호 탑승하여 <span class="red">허드슨 강</span> 투어.</li>
							<li><span class="bull">&bull;</span><span class="red">메트로폴리탄 박물관</span> 관람</li>
							<li><span class="bull">&bull;</span>투어 후 석식을 위해 이동</li>
							<li><span class="bull">&bull;</span>석식 후 호텔 투숙및 휴식</li>
						</ul>
					</td>   
					<td class="img"><img src="<?=$path?>/images/ivy_league/img4.jpg" alt="" /></td>
				</tr>
				<tr>
					<td class="center">5 day</td>
					<td class="center blue">뉴헤이븐,<br />보스턴 /<br />예일,<br />MIT 대학교</td>
					<td>
						<ul class="detail">
							<li><span class="bull">&bull;</span>호텔 조식 후 이동</li>
							<li><span class="bull">&bull;</span><span class="red">예일 대학교</span> 방문하여 현재 재학중인 학생들의 안내로 학교 곳곳을 투어</li>
							<li><span class="bull">&bull;</span>예일 대학교 학생회관에서 학생들과 함께 캠퍼스의 분위기를 느끼며 점심 식사 </li>
							<li><span class="bull">&bull;</span><span class="red">MIT 대학교</span> 방문하여 현지 전문 가이드의 안내로 학교 곳곳을 투어</li>
							<li><span class="bull">&bull;</span>현재 MIT 대학교에 재학중인 박사님을 만나 그분이 연구하는 랩실 방문 및 미래과학에 대한 미국에서의 교육에 대한 강연 및 좌담회 진행 (1-day study)</li>
							<li><span class="bull">&bull;</span>MIT 대학교 학생회관에서 현지 학생들과 함께 저녁 식사 후 이동</li>
							<li><span class="bull">&bull;</span>호텔 투숙 및 휴식</li>
						</ul>
					</td>   
					<td class="img"><img src="<?=$path?>/images/ivy_league/img5.jpg" alt="" /></td>
				</tr>
                <tr>
					<td class="center">6 day</td>
					<td class="center blue">보스턴 /<br /> 하버드<br /> 대학교</td>
					<td>
						<ul class="detail">
							<li><span class="bull">&bull;</span>호텔 조식 후 이동</li>
							<li><span class="bull">&bull;</span><span class="red">하버드(HARVARD) 대학교</span> 방문하여 투어 전담 가이드의 안내로 학교 곳곳을 투어</li>
							<li><span class="bull">&bull;</span><span class="red">하버드 대학교</span> 학생회관에서 점심 식사 </li>
							<li><span class="bull">&bull;</span><span class="red">하버드 대학교</span> 치과대학 내에 있는 랩실에서 체험 실습 진행 (1-day study)</li>
							<li><span class="bull">&bull;</span>강연회 진행 후 퀸스 마켓 관광을 위해 이동</li>
							<li><span class="bull">&bull;</span>관람 후 석식을 위해 이동</li>
							<li><span class="bull">&bull;</span>호텔 투숙 및 휴식</li>
						</ul>
					</td>   
					<td class="img"><img src="<?=$path?>/images/ivy_league/img6.jpg" alt="" /></td>
				</tr>
                <tr>
					<td class="center">7 day</td>
					<td class="center blue">보스턴</td>
					<td>
						<ul class="detail">
							<li><span class="bull">&bull;</span>호텔 또는 공항에서 조식 후  이동</li>
							<li><span class="bull">&bull;</span>DL1342편으로 이륙</li>
							<li>------ 일자 변경선 통과 ---------</li>
						</ul>
					</td>   
					<td class="img"><img src="<?=$path?>/images/ivy_league/air3.jpg" alt="" /></td>
				</tr>
                <tr>
					<td class="center">8 day</td>
					<td class="center blue">인천 도착</td>
					<td>
						<ul class="detail">
							<li><span class="bull">&bull;</span>19:30분 인천공항 도착 후 입국심사 및 위탁 수화물 수령</li>
							<li><span class="bull">&bull;</span>기내 작성한 세관신고서 제출</li>
							<li><span class="bull">&bull;</span>입국장 B 게이트 통과하여 보호자 미팅 후 귀가</li>
							<li>----- 수고하셨습니다, 또 만나요~ -------</li>
						</ul>
					</td>   
					<td class="img"><img src="<?=$path?>/images/ivy_league/img7.jpg" alt="" /></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="blue_table">
		<table width="790">
			<caption class="titleimg t6"><span class="blind">아이비리그투어 스페셜 행사</span></caption>
			<colgroup>
				<col  width="50%">
				<col  width="auto">
			</colgroup>
			<thead>
				<tr>
					<th class="center">MARK KEAM - 버지니아 주 의원</th>
					<th class="center">JASON KIM - 뉴저지주 펠팍 부시장</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="center">
						<div class="topic">차세대 글로벌 리더가 갖추어야 할 덕목</div>
						<img src="../../images/ivy_league/topic1.jpg" alt="" />
					</td>
					<td class="center">
						<div class="topic">우리가 꿈꿔야 할 글로벌한 미래의 세계</div>
						<img src="../../images/ivy_league/topic2.jpg" alt="" />
					</td>
				</tr>
				<tr class="brown">
					<td class="left">
						<ul class="detail">
							<li><span class="bull">&bull;</span>첫 한국계 주하원의원으로 3선 의원</li>
							<li><span class="bull">&bull;</span>1966년 서울 태생</li>
							<li><span class="bull">&bull;</span>1978년 미국 캘리포니아주로 이민</li>
						</ul>
					</td>
					<td class="left">
						<ul class="detail">
							<li><span class="bull">&bull;</span>한인 최초 팰리세이즈팍 시의회 의장겸 부시장</li>
							<li><span class="bull">&bull;</span>미동부지역 최초의 한인교육위원장 역임</li>
							<li><span class="bull">&bull;</span>1980년부터 제이슨 김 아카데미 운영</li>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="blue_table">
		<table width="790">
			<caption></caption>
			<colgroup>
				<col  width="50%">
				<col  width="auto">
			</colgroup>
			<thead>
				<tr>
					<th class="center">노영찬 교수 – 조지메이슨대 한국학 연구소 소장</th>
					<th class="center">배수찬 박사 – 현 하버드대 메디컬센터 전문의</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="center">
						<div class="topic">사이언스 비즈니스, <br />IT가 기업에 미치는 영향과 리더쉽</div>
						<img src="../../images/ivy_league/topic3.jpg" alt="" />
					</td>
					<td class="center">
						<div class="topic">우리가 꿈꿔야 할 글로벌한 미래의 세계 <br />&nbsp;</div>
						<img src="../../images/ivy_league/topic4.jpg" alt="" />
					</td>
				</tr>
				<tr class="brown">
					<td class="left">
						<ul class="detail">
							<li><span class="bull">&bull;</span>연세대학교 대학원 석사</li>
							<li><span class="bull">&bull;</span>미국 조지메이슨대학교 종교학과 교수 </li>
							<li><span class="bull">&bull;</span>미국 조지메이슨대학교 한국연구소 소장</li>
						</ul>
					</td>
					<td class="left">
						<ul class="detail">
							<li><span class="bull">&bull;</span>하버드 의과대학 교수</li>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<p class="t_info"> * 현지 연사들의 일정에 따라 변경이 될 수 있습니다.</p>
	<div class="blue_table">
		<table width="790">
			<caption class="titleimg t7"><span class="blind">아이비리그투어 숙박내역</span></caption>
			<colgroup>
				<col  width="50%">
				<col  width="auto">
			</colgroup>
			<thead>
				<tr class="hotel_th">
					<th class="center">Comfort Inn New Columbia Hotel @ Pennsylvania</th>
					<th class="center">Holiday Inn Express Bloomsburg  @ Pennsylvania</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="center">
						<img src="../../images/ivy_league/hotel1.jpg" alt="" />
					</td>
					<td class="center">
						<img src="../../images/ivy_league/hotel2.jpg" alt="" />
					</td>
				</tr>
				<tr class="brown">
					<td class="left">
						Add : 330 commerce Park, New Columbia, PA 17856<br />
						Tel : 570-568-8000
					</td>
					<td class="left">
						Add : 14 Mitchell Drive, Bloomsburg, PA 17815<br />
						Tel : 570-387-6702 
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="blue_table">
		<table width="790">
			<colgroup>
				<col  width="50%">
				<col  width="auto">
			</colgroup>
			<thead>
				<tr class="hotel_th">
					<th class="center">Springhill Suites Herdon Hotel @ Washington D.C</th>
					<th class="center">Turf Valley Resrt Hotel @ Washington D.C</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="center">
						<img src="../../images/ivy_league/hotel3.jpg" alt="" />
					</td>
					<td class="center">
						<img src="../../images/ivy_league/hotel4.jpg" alt="" />
					</td>
				</tr>
				<tr class="brown">
					<td class="left">
						Add : 138 Spring Street Herndon, VA 20170<br />
						Tel : 703-435-3100 
					</td>
					<td class="left">
						Add : 195 Davidson Avenue Somerset, NJ 08873<br />
						Tel : 410-465-1500 
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="blue_table">
		<table width="790">
			<colgroup>
				<col  width="50%">
				<col  width="auto">
			</colgroup>
			<thead>
				<tr class="hotel_th">
					<th class="center">Radisson Picataway Hotel @ New York</th>
					<th class="center">Holiday Inn Somerset Hotel @New York</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="center">
						<img src="../../images/ivy_league/hotel5.jpg" alt="" />
					</td>
					<td class="center">
						<img src="../../images/ivy_league/hotel6.jpg" alt="" />
					</td>
				</tr>
				<tr class="brown">
					<td class="left">
						Add :  21 Kingsbridge Road, Piscataway NJ 08854<br />
						Tel : 723-980-0400
					</td>
					<td class="left">
						Add :  195 Davidson Avenue Somerset, NJ 08873<br />
						Tel : 723-356-1700
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="blue_table">
		<table width="790">
			<caption><span class="blind">아이비리그투어 숙박내역</span></caption>
			<colgroup>
				<col  width="50%">
				<col  width="auto">
			</colgroup>
			<thead>
				<tr class="hotel_th">
					<th class="center">Holiday Inn Milford Hotel @ Boston</th>
					<th class="center">Sheraton Colonial Hotel @ Boston</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="center">
						<img src="../../images/ivy_league/hotel7.jpg" alt="" />
					</td>
					<td class="center">
						<img src="../../images/ivy_league/hotel8.jpg" alt="" />
					</td>
				</tr>
				<tr class="brown">
					<td class="left">
						Add :  50 Fortune Boulevard, Milford MA 01757<br />
						Tel : 508-634-1054
					</td>
					<td class="left">
						Add :  One Audubon Road, Wakefield, MA 01880<br />
						Tel : 781-245-9300
					</td>
				</tr>
			</tbody>
		</table>
	</div>
    <p class="t_info"> * 위의 호텔 중에서 숙발할 예정입니다.</p>
    <div class="blue_table">
		<table width="790">
		  <caption class="titleimg t8"><span class="blind">아이비리그투어 출발 일정안내</span></caption>
			<colgroup>
			<col  width="20%">
			<col  width="auto">
			</colgroup>
			<tbody>
				<tr>
					<th class="center">특이사항</td>
					<td>
                    	<ul class="detail">
							<li><span class="bull">&bull;</span> 각  일정마다 단독 그룹으로 진행이 되므로 출발 3주전까지 최소인원 10명이  예약확정시   해당 일정을 진행합니다.</li>
							<li><span class="bull">&bull;</span>최소인원이  예약이 되지 않을 시에 다음  일정으로 변경 될 수 있습니다.</li>
							<li><span class="bull">&bull;</span>오랜 경험의 전문 인솔자가 출국/귀국에 동반하며, 현지에서는 현지 전문 가이드가 진행을 합니다.</li>
							<li><span class="bull">&bull;</span>각 일정 별로 단독 차량을 이용하므로, 각 일정 별 인원에 따라서 차량은 달라 질 수 있습니다.</li>
							<li><span class="bull">&bull;</span>항공료 및 유류할증료는 각 일정마다 상이합니다.</li>
							<li><span class="bull">&bull;</span>노 팁/ 노 옵션, 기사/가이드 팁 및 관광지 입장료는 포함되어 있습니다.</li>
							<li><span class="bull">&bull;</span>유가인상 및 환율 변동에 따른 기존 유류할증료(포함)외 추가 인상분은 별도로 반영 될 수 있습니다.</li>
						</ul>
                    </td>
			  </tr>
			  <tr>
					<th class="center">유의사항</td>
				<td>
                    	<ul class="detail">
							<li><span class="bull">&bull;</span>호텔은 3~4인실입니다.</li>
							<li><span class="bull">&bull;</span>여행자 보험은 탐방 기간 동안 1억원 해외여행자 보험에 가입되며, 출국 전에 전달됩니다.</li>
							<li><span class="bull">&bull;</span>소아 요금은  기간에 따라 적용이 되지 않는 경우도 있습니다.</li>
						</ul>
                </td>
				</tr>
			  <tr>
					<th class="center">환불 규정</td>
				<td>
                    	<ul class="detail">
							<li><span class="bull">&bull;</span>[취소료] 여행자의 여행계약 해제 요청에 따른 경우</li>
							<li><span class="bull">&bull;</span>여행 출발일 기준 20일전 취소시 예약금 및 입금액 전액 환불 가능</li>
							<li><span class="bull">&bull;</span>여행 출발일 기준 19~10일전 취소 시 상품가의 5% 취소수수료 부과</li>
							<li><span class="bull">&bull;</span>여행 출발일 기준 9~8일전 취소 시 상품가의 10% 취소수수료 부과</li>
							<li><span class="bull">&bull;</span>여행 출발일 기준 7~1일전 취소 시 상품가의 20% 취소수수료 부과</li>
							<li><span class="bull">&bull;</span>여행 출발일 기준 당일 취소 시 상품가의 50% 취소 수수료 부과</li>
						</ul>
                </td>
			  </tr>
				<tr>
					<th class="center">입금 계좌</td>
				  <td>
                  	<ul class="detail">
                    	<li><span class="bull">&bull;</span>
                    	  <p>외환은행  381-18-25601-5  ㈜중앙아이비 황태숙</p></li>
                   </ul>
                  </td>
				</tr>
				<tr>
					<th class="center">입금 및 계약 시기</td>
					<td>
                    	<ul class="detail">
							<li><span class="bull">&bull;</span>상담 후 예약을 원하실 경우에는 3일 이내에 예약금 100만원을 위의 계좌로 입금하시면 예약이 성립이 됩니다.</li>
							<li><span class="bull">&bull;</span>각 일정별 출발 4주 전까지 잔금을 완납하셔야 계약이 완료됩니다.</li>
						</ul>
                    </td>
				</tr>
			</tbody>
		</table>
	</div>
    <div class="blue_table">
		<table width="790">
			<caption class="titleimg t9"><span class="blind">타사 아이비리그 투어와의 차이점</span></caption>
			<colgroup>
				<col  width="20%">
				<col  width="40%">
				<col  width="40%">
			</colgroup>
			<thead>
				<tr class="hotel_th">
					<th class="center">투어 개요</th>
					<th class="center">아이비 투어 프로그램</th>
					<th class="center">국내일반 / 교민 여행사 프로그램</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th class="center">투어 내용</th>
					<td>
                    	<ul class="detail">
							<li><span class="bull">&bull;</span>본사가 직접 기획 및 전 일정 주관</li>
							<li><span class="bull">&bull;</span>출발에서부터 귀국까지 단일 그룹으로 진행.</li>
							<li><span class="bull">&bull;</span>전 일정 전문인솔자가 진행하며, 더 세세한 케어가 진행됨.</li>
						</ul>
                    </td>
					<td>
                    	<ul class="detail">
							<li><span class="bull">&bull;</span>단독팀이 아닌 여행사별 그리고 현지 교민여행사가 모객한 여러 개의 팀이 미국공항에서 모임.</li>
							<li><span class="bull">&bull;</span>45인승 큰 버스로 함께 이동.</li>
						</ul>
                    </td>
				</tr>
				<tr>
					<th class="center">학교 행사</th>
					<td>
                    	<ul class="detail">
							<li><span class="bull">&bull;</span>아이비리그 대학 캠퍼스 투어</li>
							<li><span class="bull">&bull;</span>재학생 또는 전문인솔자의 인솔하에 탐방</li>
                            <li><span class="bull">&bull;</span>재직중인 교수들이 진행하는 랩실 탐방 및 실험 체험</li>
						</ul>
                    </td>
					<td>
                    	<ul class="detail">
                        	<li><span class="bull">&bull;</span>아이비리그 대학 캠퍼스 투어</li>
                        </ul>    
                    </td>
				</tr>
				<tr>
					<th class="center">글로벌 리더십<br> 관련 행사</th>
					<td>
						<ul class="detail">
							<li><span class="bull">&bull;</span>현지에서 성공한 한인들과의 미팅</li>
							<li><span class="bull">&bull;</span>글로벌 리더십 및 성공과 관련하여 강연을 듣고 미래의 꿈에 대해 동기부여를 얻음</li>
						</ul>
					</td>
					<td>
                    	<ul class="detail">
                    		<li><span class="bull">&bull;</span>없음</li>
                        </ul>
                    </td>
				</tr>
				<tr>
					<th class="center">부모 동반</th>
					<td>
                    	<ul class="detail">
                    		<li><span class="bull">&bull;</span>전문인솔자 출국/귀국 전 일정 동반</li>
                        </ul>
                    </td>
					<td>
                    	<ul class="detail">
                    		<li><span class="bull">&bull;</span>인솔자 미정으로 학생만 참여 불가 또는 학부모 동반 필수</li>
                        </ul>
                    </td>
				</tr>
				<tr>
					<th class="center">투어 조건</th>
					<td>
                    	<ul class="detail">
							<li><span class="bull">&bull;</span> 각 일정에 따른 합리적이고 투명한 항공료 제시!
</li>
							<li><span class="bull">&bull;</span>가이드/기사 팁 포함. 노 옵션, 노 팁!</li>
						</ul>
                    </td>
					<td>
                    	<ul class="detail">
							<li><span class="bull">&bull;</span>일정에 상관없는 동일 가격</li>
							<li><span class="bull">&bull;</span>기사/가이드 팁 별도, 호텔/식사 팁 개별 지불</li>
							<li><span class="bull">&bull;</span>일부 관광상품 옵션 진행</li>
						</ul>
                    </td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php
include_once("$root/subfoot.php"); 
?>