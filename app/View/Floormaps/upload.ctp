

<script type="text/javascript">
var i = 5;
var intervalid;
intervalid = setInterval("count_down()", 1000);

function count_down()
{
	if (i == 0)
	{
		window.location.href="<?php echo $this->Html->url(array('controller' => 'Floormaps', 'action' => 'index')) ?>";
		clearInterval(intervalid);
	}
	document.getElementById("show_sec_div").innerHTML =
	 "You will true back to FloorMap page in "+i+" seconds";
	i--;
}
</script>
<center>
<div id='show_sec_div'></div>
</center>


<?php
		$url="";
	if (file_exists("floormap/".$_SESSION["event_str"]."." ."jpg"))
	{
		$url="floormap/".$_SESSION["event_str"] ."." ."jpg";
		}
	 else  if (file_exists("floormap/".$_SESSION["event_str"]."."  ."png"))
	 {
	 $url="floormap/".$_SESSION["event_str"] ."." ."png";
	 }
	 else  if (file_exists("floormap/".$_SESSION["event_str"]."."  ."gif"))
	 {
		$url="floormap/".$_SESSION["event_str"] ."." ."gif";
	 }
	 ?>
<center>
<?php echo $message;?></br>
<img src="<?php echo $this->html->webroot.$url;?>" height="920px" width="720px"/>
</center>
<br/>
