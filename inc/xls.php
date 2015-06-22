<?php

$fname = empty($_POST['fname']) ? 'excel' : $_POST['fname'] ;
$title = explode(',',$_POST['title']);
foreach ($_POST['row'] as $trs) {
	$row[] = explode(',',$trs);
}

header( "Content-type: application/vnd.ms-excel" );   
header( "Content-type: application/vnd.ms-excel; charset=utf-8");  // 본인의 인코딩형식에 유의하여 작성한다. 잘못 기재시 엑셀파일이 깨짐.
$filename= $fname."_".date('Y-m-d').".xls";  //파일명 변수 지정 -> 파일명에 오늘날짜를 동적으로 넣어주고싶다. 필자는 excel_2014-06-09.xls식으로 저장.
header( "Content-Disposition: attachment; filename = $filename" );   
header( "Content-Description: PHP4 Generated Data" );   
  
// 테이블 상단 만들기  
$EXCEL_STR = "<table border='1'>";

if (is_array($title)) {
	$EXCEL_STR .= "<tr>";
	foreach ($title as $val) {
		$EXCEL_STR .= "<td bgcolor='#eeeeee' align='center'>".$val."</td>";
	}
	$EXCEL_STR .= "</tr>";
}

//테이블 몸뚱이 채우기
foreach ($row as $tr) {  
	$EXCEL_STR .= "<tr>";  
	foreach ($tr as $td) {
		$EXCEL_STR .= "<td>".$td."</td>";
	}
	$EXCEL_STR .= "</tr>";  
}  
$EXCEL_STR .= "</table>";  

$EXCEL_STR = str_replace("<tr></tr>","",$EXCEL_STR); // 인터넷 올렷을때 이상하게 빈 tr태그가 row개수만큼 생김 

echo "<meta content=\"application/vnd.ms-excel; charset=UTF-8\" name=\"Content-type\"> ";  // 인코딩형식에 유의
echo $EXCEL_STR;  
?>