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
		echo "<Label>Please set your floor map first.</Label>";
	}else{
		if($event['Event']['set_floormap']==true ){
			echo "<label> <input type='checkbox' name='useFloormap' onchange='changeState()' />check this box on to hide the floor map in PosmApp.</label>";
		}else if($event['Event']['set_floormap']==false){
			echo "<label> <input type='checkbox' name='useFloormap' checked=true onchange='changeState()' />check this box on to hide the floor map in PosmApp.</label>";
		}
	}
?>
</form>
</div>
<div>
<form action="floormaps/upload" method="post" id="floormapImport" enctype="multipart/form-data">
<p>Please click the following button to upload your floor map:</p>
<p><input value="Upload floor map image"  type="button"  class="btn btn-custom" onClick="GetFile()"></p>
<p><input type="file" name="file" id="file" class="disno" onChange="PostFrom()"></p>
<p><input type="submit" value="Submit" class="disno"></p>
</form>
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
