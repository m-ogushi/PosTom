<script type="text/javascript">
			 window.onload=function()
             {
        localStorage.clear();
        }
</script>
<center>
<h1>
You can select one method to view on PosMapp:
</h1>
</br>

<div style="clear:both;margin-left: auto; margin-right: auto;">
<div style="float:left;margin-left: auto; margin-right: auto;"><h3>QR Code</h3>
</br>
<?php
$urlToEncode= 'http://'.$_SERVER['HTTP_HOST'].$this->Html->url(array('controller' => 'PosMapps', 'action' => 'phoneclear'));
generateQRfromGoogle($urlToEncode);
function generateQRfromGoogle($chl,$widhtHeight ='150',$EC_level='L',$margin='0')
{
 $url = urlencode($url);
 echo '<img src="http://chart.apis.google.com/chart?chs='.$widhtHeight.'x'.$widhtHeight.'&cht=qr&chld='.$EC_level.'|'.$margin.'&chl='.$chl.' " alt="QR code" style="width:120px;height:120px;border-width:1px;"/>';
}

?>
</div>



<div style="float:left;margin-left: auto; margin-right: auto;"><h3>Send a email with url</h3>
</br>
<a href="
<?php echo $this->Html->url(array('controller' => 'PosMapps', 'action' => 'sendmail')) ?>
">

<img src="<?php echo $this->Html->webroot; ?>img/email.jpg" style=" width:120px;height:120px;border-width:1px;"></a>
</div>
</div>
</center>
