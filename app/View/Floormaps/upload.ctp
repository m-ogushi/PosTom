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