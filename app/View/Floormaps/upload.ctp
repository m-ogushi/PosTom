<?php
    $url="";
  if (file_exists("floormap/".$_SESSION["event_id"]."." ."jpg"))
  {
    $url="floormap/".$_SESSION["event_id"] ."." ."jpg";
    }
   else  if (file_exists("floormap/".$_SESSION["event_id"]."."  ."png"))
   {
   $url="floormap/".$_SESSION["event_id"] ."." ."png";
   }
   else  if (file_exists("floormap/".$_SESSION["event_id"]."."  ."gif"))
   {
    $url="floormap/".$_SESSION["event_id"] ."." ."gif";
   }
   ?>
<center>
<?php echo $message;?></br>
<img src="<?php echo $this->html->webroot.$url;?>"/>
</center>
<br/>