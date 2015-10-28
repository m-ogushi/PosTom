<?php
echo 'http://'.$_SERVER['HTTP_HOST'].$this->Html->url(array('controller' => 'PosMapps', 'action' => 'index'));

$urlToEncode = 'http://'.$_SERVER['HTTP_HOST'].$this->Html->url(array('controller' => 'PosMapps', 'action' => 'index'));
generateQRfromGoogle($urlToEncode);
function generateQRfromGoogle($chl,$widhtHeight ='150',$EC_level='L',$margin='0'){
	$url = urlencode($url);
	echo '<img src="http://chart.apis.google.com/chart?chs='.$widhtHeight.'x'.$widhtHeight.'&cht=qr&chld='.$EC_level.'|'.$margin.'&chl='.$chl.' " alt="QR code" widhtHeight="'.$size.'" widhtHeight="'.$size.'"/>';
}
?>