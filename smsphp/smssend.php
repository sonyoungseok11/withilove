<?php

function sendsms ($sd) {
	global $HOME_CONFIG;
	$sms_url = $HOME_CONFIG['sms_url']; // ���ۿ�û URL
	// $sms_url = "https://sslsms.cafe24.com/sms_sender.php"; // HTTPS ���ۿ�û URL
	$sms['user_id'] = base64_encode($HOME_CONFIG['sms_user_id']); //SMS ���̵�.
	$sms['secure'] = base64_encode($HOME_CONFIG['sms_secure']) ;//����Ű
	$sms['msg'] = base64_encode(stripslashes($sd['msg']));
	if (empty($data['rphone'])) { // �̸����� ��ü�߼۽�. 010-0000-0000|ȫ�浿,010-0000-0000|�迵��
		$sms['rphone'] = base64_encode($sd['rphone']);
		$sms['destination'] = urlencode(base64_encode($sd['destination']));
	} else { // 
		$sms['rphone'] = base64_encode($sd['rphone']);
	}
	$sp_arr = explode("-",$HOME_CONFIG['sms_sphone']);
	$sms['sphone1'] = base64_encode($sp_arr[0]);
    $sms['sphone2'] = base64_encode($sp_arr[1]);
    $sms['sphone3'] = base64_encode($sp_arr[2]);
	$sms['mode'] = base64_encode("1");
	
	// ���ڹ߼�
	$host_info = explode("/", $sms_url);
    $host = $host_info[2];
    $path = $host_info[3]."/".$host_info[4];

    srand((double)microtime()*1000000);
    $boundary = "---------------------".substr(md5(rand(0,32000)),0,10);
    //print_r($sms);

    // ��� ����
    $header = "POST /".$path ." HTTP/1.0\r\n";
    $header .= "Host: ".$host."\r\n";
    $header .= "Content-type: multipart/form-data, boundary=".$boundary."\r\n";

    // ���� ����
    foreach($sms AS $index => $value){
        $data .="--$boundary\r\n";
        $data .= "Content-Disposition: form-data; name=\"".$index."\"\r\n";
        $data .= "\r\n".$value."\r\n";
        $data .="--$boundary\r\n";
    }
    $header .= "Content-length: " . strlen($data) . "\r\n\r\n";

    $fp = fsockopen($host, 80);

    if ($fp) { 
        fputs($fp, $header.$data);
        $rsp = '';
        while(!feof($fp)) { 
            $rsp .= fgets($fp,8192); 
        }
        fclose($fp);
        $msg = explode("\r\n\r\n",trim($rsp));
        $rMsg = explode(",", $msg[1]);
        $Result= $rMsg[0]; //�߼۰��
        $Count= $rMsg[1]; //�ܿ��Ǽ�
    }
    else {
        $Result = "failed";
    }
	return $Result;
}


?>
