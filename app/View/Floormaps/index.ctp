<script type="text/javascript">
	function GetFile(){
		$('#file').trigger('click');
	}
	function PostFrom()
	{
	    $('#floormapImport').submit();
	}
	function changeState()
	{
        $('#changeStateFrom').submit();
	}
</script>
<center>
<form action="floormaps/setmap" method="post" id="changeStateFrom" enctype="multipart/form-data">
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

    if($url=="")
    {
        echo "<Label>Please set your floor map first.</Label>";
    }
    else
    {
            if($event['Event']['set_floormap']==true )
            {
            echo "<label> <input type='checkbox' name='useFloormap' onchange='changeState()' />if you want to hide the picture,please check this box. </label>";
            }
            else if($event['Event']['set_floormap']==false)
            {
             echo "<label> <input type='checkbox' name='useFloormap' checked=true onchange='changeState()' />if you want to hide the picture,please check this box. </label>";
            }
    }
 ?>
 </form>
 </br>


</br>
</br>
</br>
</br>
<Label>Please select click the select button to upload your floor map:</Label>
<form action="floormaps/upload" method="post" id="floormapImport" enctype="multipart/form-data">
<br />

<input value="Add floor map from local"  type="button"  class="btn btn-custom" onClick="GetFile()"/>
<input type="file" name="file" id="file"  onChange="PostFrom()" style="display:none" />
<br />
<input type="submit" value="Submit" style="display:none" />
</form>




</br>
    <?php



    if($url!="")
    {
        echo "This picture is set now:";
        echo "</br>";
        echo '<img src="'.$this->html->webroot.$url.'" height="920px" width="720px"/>';
    }

   ?>
   </center>