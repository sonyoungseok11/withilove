<?php
@header ('Content-type: text/html; charset=utf-8');
@ini_set("session.use_trans_sid", 0);    // PHPSESSID를 자동으로 넘기지 않음
@ini_set("url_rewriter.tags","");				// 링크에 PHPSESSID가 따라다니는것을 무력화함
@header("Expires: 0"); // rfc2616 - Section 14.21
@header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
@header("Cache-Control: no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0");  // HTTP/1.1
@header("Pragma: no-cache"); // HTTP/1.0
?>