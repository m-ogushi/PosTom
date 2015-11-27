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
	if (file_exists("floormap/".$_SESSION["event_id"]."." ."jpg")){
		$url="floormap/".$_SESSION["event_id"] ."." ."jpg";
	}else if (file_exists("floormap/".$_SESSION["event_id"]."."  ."png")){
		$url="floormap/".$_SESSION["event_id"] ."." ."png";
	}else if (file_exists("floormap/".$_SESSION["event_id"]."."  ."gif")){
		$url="floormap/".$_SESSION["event_id"] ."." ."gif";
	}
	
	if($url==""){
		echo "<Label>Please set your floor map first.</Label>";
	}else{
		if($event['Event']['set_floormap']==true ){
			echo "<label> <input type='checkbox' name='useFloormap' onchange='changeState()' />&nbsp;If you want to disuse the floormap, please check this box. </label>";
		}else if($event['Event']['set_floormap']==false){
			echo "<label> <input type='checkbox' name='useFloormap' checked=true onchange='changeState()' />if you want to hide the picture,please check this box. </label>";
		}
	}
?>
</form>
</div>
<div>
<form action="floormaps/upload" method="post" id="floormapImport" enctype="multipart/form-data">
<p>Please click the select button to upload your floor map:</p>
<p><input value="Upload floor map image"  type="button"  class="btn btn-custom" onClick="GetFile()"></p>
<p><input type="file" name="file" id="file" class="disno" onChange="PostFrom()"></p>
<p><input type="submit" value="Submit" class="disno"></p>
</form>
<?php
	if($url!=""){
		echo "<p>This picture is set now:</p>";
		echo '<p><img src="'.$this->html->webroot.$url.'" height="960px" width="720px"></p>';
	}
?>
</div>
</div>