<?php
if($_POST['data'] == null) $errorMsg = 'data have not input';
if(count($_POST['data']) == 0) $errorMsg = 'you must set object first';

if (!isset($errorMsg)) {
	//JSONへ変換して書き込み
	$filename = '../json/data.json';
	$handle = fopen($filename, 'w');
	fwrite($handle,json_encode($_POST['data'], JSON_UNESCAPED_UNICODE));
	fclose($handle);
	echo 'save successed!';
}else{
	echo $errorMsg;
}
?>