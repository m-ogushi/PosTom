<center>
Please select click the select button to upload your floor map:
<form action="floormaps/upload" method="post"
enctype="multipart/form-data">
<br />
<br />
<br />
Filename:<input type="file" name="file" id="file" />
<br />
<input type="submit" name="submit" value="Submit" />
</form>
</br>
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


    if($url!="")
    {
        echo "This picture is set now:";
        echo "</br>";
        echo '<img src="'.$this->html->webroot.$url.'" height="920px" width="720px"/>';
    }

   ?>
   </center>