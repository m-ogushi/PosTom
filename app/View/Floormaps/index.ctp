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
<h2>Floor Map</h2>
<div id="pageFloormap">
<<<<<<< HEAD
<p>・The file is encoded as PNG, GIF or JPG.</p>
<p>・The image size is less than 960px in width and 720px in height.</p>
=======
>>>>>>> 139a4019eebbd3237c81fb81a3e9b58339a1bfce
<form action="floormaps/upload" method="post" id="floormapImport" enctype="multipart/form-data">
<p><input value="Upload floor map image"  type="button"  class="btn btn-custom" onClick="GetFile()"></p>
<p><input type="file" name="file" id="file" class="disno" onChange="PostFrom()"></p>
<p><input type="submit" value="Submit" class="disno"></p>
</form>
<div>
<form action="floormaps/setmap" method="post" id="changeStateFrom" enctype="multipart/form-data">
<?php
	$url="";
	if (file_exists("floormap/".$_SESSION["event_str"]."." ."jpg")){
		$url="floormap/".$_SESSION["event_str"] ."." ."jpg";
	}else if (file_exists("floormap/".$_SESSION["event_str"]."."  ."png")){
		$url="floormap/".$_SESSION["event_str"] ."." ."png";
	}else if (file_exists("floormap/".$_SESSION["event_str"]."."  ."gif")){
		$url="floormap/".$_SESSION["event_str"] ."." ."gif";
	}

	if($url==""){
		echo "<p>・The file is encoded as PNG, GIF or JPG.</p>";
		echo "<p>・The image size is less than 720px in width and 960px in hight.</p>";
	}else{
		if($event['Event']['set_floormap']==true ){
			echo "<label> <input type='checkbox' name='useFloormap' onchange='changeState()' />Check the box to hide the floor map in PosMapp</label>";
		}else if($event['Event']['set_floormap']==false){
			echo "<label> <input type='checkbox' name='useFloormap' checked=true onchange='changeState()' />Check the box to hide the floor map in PosMapp</label>";
		}
	}
?>
</form>
</div>
<div>
<?php
if($url!=""){
?>
	<p>This picture is set now:</p>
	<div id="posmappImage">
	<p id="floormapImage"><img src="<?php echo $this->html->webroot.$url; ?>" width="320" height="349"></p>
	</div>
<?php
}
?>
</div>
</div>
