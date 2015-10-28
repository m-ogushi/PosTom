
<div>

<!-- canvasArea -->
<div id="canvasArea">
<canvas id="demoCanvas" dropzone="copy"></canvas>
</div>
<!-- //canvasArea -->


<!-- inputArea -->
<div id="inputArea">
<!-- tab -->
<div id="tab">
<ul class="nav nav-tabs">
<li class="active"><a href="#tcPoster" data-toggle="tab">Poster Edit</a></li>
<li><a href="#tcPresentation" data-toggle="tab">Presentation</a></li>
</ul>
</div>
<!-- //tab -->
<!-- tab contents -->
<div id="tabContents" class="tab-content">
<!-- tab contents Poster -->
<div id="tcPoster" class="tab-pane active">

<!-- selectForm -->
<select name="selectMode" class="selectpicker" onChange="changeMode()">
<option value="create">Create Mode</option>
<option value="delete">Delete Mode</option>
</select>
<!-- //selectForm -->
<!-- createForm -->
<div id="createForm" class="form">
<fieldset>
<legend>Create</legend>
<p>width :<input  type="number" class="form-control" name="objectWidth" inputmode="numeric" size="10" value="10" min="1" onKeyup="checkTextIsNumeric(this)"></p>
<p>height :<input type="number" class="form-control" name="objectHeight" inputmode="numeric" size="10" value="10" min="1" onKeyup="checkTextIsNumeric(this)"></p>
<p>color:<br>
<select name="objectCreateColor" class="selectpicker" onChange="changeSelectColor()">
<option value='#999999' class='bg1' >&nbsp;</option>
<option value='#000000' class='bg2' >&nbsp;</option>
<option value='#ffffff' class='bg3' >&nbsp;</option>
<option value='#E60012' class='bg4' >&nbsp;</option>
<option value='#F39800' class='bg5' >&nbsp;</option>
<option value='#FFF100' class='bg6' >&nbsp;</option>
<option value='#8FC31F' class='bg7' >&nbsp;</option>
<option value='#009944' class='bg8' >&nbsp;</option>
<option value='#009E96' class='bg9' >&nbsp;</option>
<option value='#00A0E9' class='bg10' >&nbsp;</option>
<option value='#0068B7' class='bg11' >&nbsp;</option>
<option value='#1D2088' class='bg12' >&nbsp;</option>
<option value='#920783' class='bg13' >&nbsp;</option>
<option value='#E4007F' class='bg14' >&nbsp;</option>
<option value='#E5004F' class='bg15' >&nbsp;</option>
</select>
</p>
<p><input type="button" name="createButton" class="btn btn-default" onClick="setObject()" value="Create"></p>
</fieldset>
</div>
<!-- //createForm -->
<!-- deleteForm -->
<div id="deleteForm" class="form">
<p>
<input type="button" name="deleteButton" class="btn btn-default" onClick="deleteObject()" value="Delete" disabled>
</p>
</div>
<!-- //deleteForm -->
<!-- editForm-->
<div id="editForm" class="form">
<fieldset>
<legend>Edit</legend>
<p>Title:<input type="text" class="form-control" name="title" disabled="disabled"></p>
<p>Presentor:<input type="text" class="form-control" name="presenter" disabled="disabled"></p>
<p>Content:<textarea class="form-control"  name="abstract" rows="5" disabled="disabled"></textarea></p>
<p>color:<br>
<select name="objectEditColor" class="selectpicker" onChange="editSelectColor()" disabled="disabled">
<option value='#999999' class='bg1' >&nbsp;</option>
<option value='#000000' class='bg2' >&nbsp;</option>
<option value='#ffffff' class='bg3' >&nbsp;</option>
<option value='#E60012' class='bg4' >&nbsp;</option>
<option value='#F39800' class='bg5' >&nbsp;</option>
<option value='#FFF100' class='bg6' >&nbsp;</option>
<option value='#8FC31F' class='bg7' >&nbsp;</option>
<option value='#009944' class='bg8' >&nbsp;</option>
<option value='#009E96' class='bg9' >&nbsp;</option>
<option value='#00A0E9' class='bg10' >&nbsp;</option>
<option value='#0068B7' class='bg11' >&nbsp;</option>
<option value='#1D2088' class='bg12' >&nbsp;</option>
<option value='#920783' class='bg13' >&nbsp;</option>
<option value='#E4007F' class='bg14' >&nbsp;</option>
<option value='#E5004F' class='bg15' >&nbsp;</option>
</select>
</p>
<p><input type="button" class="btn btn-default" name="inputForm"  onClick="setParam()" value="submit" disabled="disabled"></p>
</fieldset>
</div>
<!-- //editForm-->
<!-- mapForm-->
<div id="mapForm" class="form">
<fieldset>
<legend>Map</legend>
<p><input type="checkbox" name="checkRatio" checked="checked">&nbsp;keep (4:3)</p>
<p>width:<input type="number" class="form-control" name="mapWidth" size="10" value="720" min="300" max="1500" onKeyup="checkTextIsNumeric(this)" onBlur="onBlurMapWidth()">&nbsp;px</p>
<p>height:<input type="number" class="form-control" name="mapHeight" size="10" value="960" min="400" max="2000" onKeyup="checkTextIsNumeric(this)" onBlur="onBlurMapHeight()">&nbsp;px</p>
<p><input type="button" class="btn btn-default" name="resizeMap"  onClick="resizeMap()" value="switch map size"></p>
</fieldset>
</div>
<!-- //mapForm-->
<!-- uploadForm -->
<div id="uploadFormDiv" class="form">
<form id="upLoadForm" class="disno" value="set background">
<input  type="file" id="backGroundImage" class="btn btn-default" accept="image/png" name="backGroundImage" onChange="fileUpLoad()">
</form>
<p>
<button id="selectFile" name="selectFile" class="btn btn-default" type="button" onClick="selectFile()">background picture</button>
</p>
<p><a href="<?php echo $this->Html->webroot;?>img/backGround.png" target="_blank">background picture</a></p>
</div>
<!-- //uploadForm -->
<!-- fileForm -->
<div id="fileForm" class="form">
<p>
<input type="button" name="saveButton" class="btn btn-default" onClick="if(confirm('Do you want to save?'))saveJson()" value="save">
</p>
<p>
<input type="button" name="loadButton" class="btn btn-default" onClick="loadJson()" value="Read">
</p>
<p><a href="json/data_nosession.json" target="_blank">JSON file</a></p>
</div>
<!-- //fileForm -->

</div>
<!-- //tab contents Poster -->
<!-- tab contents Presentation -->
<div id="tcPresentation" class="tab-pane">
<?php
// 別のモデル（Presentation）から必要なアクションを呼び出す
$presentations = $this->requestAction('/presentations/getall');

// cakephpで用意されているPaginationを利用すると、ページ遷移が発生してしまうため、独自のページャーで実装する
// 1ページあたりのプレゼンテーション表示数
$per_page = 10;
// 必要ページ数をプレゼンテーション数から算出
$pages = ceil(count($presentations) / $per_page);
?>

<ul class="pager">
<li class="prev disabled"><a href="#" data-target="prev"><i class="fa fa-angle-double-left"></i></a></li>
<?php
// 必要ページ数だけページャーを設置（6ページ以降は非表示にする）
for($i=0; $i<$pages; $i++){
?>
<li class="
<?php
echo $i == 0 ? 'active' : '';
echo $i > 4 ? ' disno' : '';
?>
"><a href="#" data-target="<?php echo $i+1; ?>"><?php echo $i+1; ?></a></li>
<?php
}
?>
<li class="next"><a href="#" data-target="next"><i class="fa fa-angle-double-right"></i></a></li>
</ul>

<?php
// ページ識別用変数
$page = 1;
// カウント用変数
$ct = 0;

// すべてのプレゼンテーション情報を出力する
foreach($presentations as $presentation){
	// ページ内の一番最初のプレゼンテーションであるか判定
	if($ct == 0){
?>
<div id="page<?php echo sprintf('%02d', $page); ?>" class="page <?php echo $page==1?'':'disno';  ?>">
<ul class="presentationlist">
<?php
	}
?>
<li id="<?php echo $presentation['Presentation']['id']; ?>" data-num="<?php echo $presentation['Presentation']['number']; ?>" draggable="true">
<?php echo $presentation['Presentation']['title']; ?>
</li>
<?php
	// カウントアップ
	$ct ++;
	
	// 1ページあたりのプレゼンテーション表示数に達したら、ページ番号を加算しカウント変数を初期化する
	if($ct == $per_page){
		$page ++;
		$ct = 0;
		// ulタグ, divタグを閉じる
?>
</ul>
</div>
<?php
	}
}
?>

</div>
<!-- //tab contents Presentation -->
</div>
<!-- //tab contents -->




</div>
<!-- //inputArea -->


</div>


<!-- dialogDeleteConfirm -->
<div id="dialogDeleteConfirm" class="disno" title="Confirm Delete">
<p>Are you sure?</p>
</div>
<!-- //dialogDeleteConfirm -->
<!-- dialogEditConfirm -->
<div id="dialogEditConfirm" class="disno" title="Edit check">
<p>Are you make sure to do this?</p>
</div>
<!-- //dialogEditConfirm -->
