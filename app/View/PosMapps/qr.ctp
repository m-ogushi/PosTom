<script type="text/javascript">
	 window.onload=function()
	 {
		localStorage.clear();
	 }
</script>
<style type="text/css">
/* TODO: 外部ファイルに切り替えてください */
#viewMethodList li {
	float: left;
	width: 300px;
	margin-left: 10px;
}
#viewMethodList li:first-child {
	margin-left: 0;
}
#viewMethodList li a {
	display: block;
}
</style>
<h2>You can select one method to view on PosMapp:</h2>

<ul id="viewMethodList">
<!-- QR -->
<li>
<h3>QR Code</h3>
<?php
	$urlToEncode= 'http://'.$_SERVER['HTTP_HOST'].$this->Html->url(array('controller' => 'PosMapps', 'action' => 'phoneclear',$_SESSION['event_str']));
	generateQRfromGoogle($urlToEncode);
	function generateQRfromGoogle($chl,$widhtHeight ='150',$EC_level='L',$margin='0'){
		$url = urlencode($url);
		echo '<img src="http://chart.apis.google.com/chart?chs='.$widhtHeight.'x'.$widhtHeight.'&cht=qr&chld='.$EC_level.'|'.$margin.'&chl='.$chl.' " alt="QR code" style="width:120px;height:120px;border-width:1px;"/>';
	}
?>
</li>
<!-- //QR -->
<!-- email -->
<li>
<h3>Send a email with url</h3>
<a href="<?php echo $this->Html->url(array('controller' => 'PosMapps', 'action' => 'sendmail')) ?>">
<i class="fa fa-envelope fa-5" style="font-size: 100px"></i>
</a>
</li>
<!-- //email -->
</ul>