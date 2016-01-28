<script type="text/javascript">
// イベントの開催日数を取得
var eventDays = "<?php echo $this->requestAction('/events/getEventDays/'.$_SESSION['event_id']); ?>";

// データベースから取得したポスターデータを格納するためのポスター配列変数
var poster = new Array();
// データベースから取得したポスターデータを元に関連するプレゼンテーションデータを格納するためのプレゼンテーション配列変数
var presentations = new Array();
// データベースから取得したエリアデータを格納するためのエリア配列変数
var areas = new Array();

// データベースから取得したeachdaysデータを格納するための配列変数
var eachdays = new Array();

// Disuseになっている日数を格納するための配列
var disuses = new Array(eventDays);
// Disuseの初期化　はじめはすべてdisuseにチェックが入っていない状態とする
for(var i=0; i<eventDays; i++){
	disuses[i] = false;
}

//データベースの情報をローカルに格納
<?php for ($i = 0; $i <= count($data)-1; $i++) { ?>
	poster[<?php echo $i ?>] = new Array();
	poster[<?php echo $i ?>].id = <?php echo $data[$i]["Poster"]["id"]; ?>;
	poster[<?php echo $i ?>].NextId = <?php echo $data[$i]["Poster"]["id"]; ?>;
	poster[<?php echo $i ?>].width = <?php echo $data[$i]["Poster"]["width"]; ?>;
	poster[<?php echo $i ?>].height = <?php echo $data[$i]["Poster"]["height"]; ?>;
	poster[<?php echo $i ?>].x = <?php echo $data[$i]["Poster"]["x"]; ?>;
	poster[<?php echo $i ?>].y = <?php echo $data[$i]["Poster"]["y"]; ?>;
	poster[<?php echo $i ?>].color = "<?php echo $data[$i]["Poster"]["color"]; ?>";
	poster[<?php echo $i ?>].presentation_id = <?php echo $data[$i]["Poster"]["presentation_id"]; ?>;
	poster[<?php echo $i ?>].date = <?php echo $data[$i]["Poster"]["date"]; ?>;
	poster[<?php echo $i ?>].event_id = <?php echo $data[$i]["Poster"]["event_id"]; ?>;

	// もし関連済みプレゼンテーションがあれば、そのプレゼンテーション情報を取得する
	<?php
	if($data[$i]["Poster"]["presentation_id"] != '0' && $data[$i]["Poster"]["presentation_id"] != NULL){
		// 別のモデル（Presentation）から必要なアクションを呼び出す
		$relatedPresentation = $this->requestAction('/presentations/getByID/'.$data[$i]["Poster"]["presentation_id"]);
	?>
		// PHPから関連付けされたプレゼンテーション情報を取得する（IDをキーとして取得するため1件のみ）
		presentations[<?php echo $i; ?>] = <?php echo json_encode($relatedPresentation[0]['Presentation']); ?>;
<?php
	} // end if
} // end for

// 選択中のイベントのエリアを全て取得する
$areas = $this->requestAction('/areas/getByEventID/'.$_SESSION['event_id']);

for($i=0; $i<count($areas); $i++){
?>
	areas[<?php echo $i ?>] = new Array();
	areas[<?php echo $i ?>].id = <?php echo $areas[$i]["Area"]["id"]; ?>;
	areas[<?php echo $i ?>].width = <?php echo $areas[$i]["Area"]["width"]; ?>;
	areas[<?php echo $i ?>].height = <?php echo $areas[$i]["Area"]["height"]; ?>;
	areas[<?php echo $i ?>].x = <?php echo $areas[$i]["Area"]["x"]; ?>;
	areas[<?php echo $i ?>].y = <?php echo $areas[$i]["Area"]["y"]; ?>;
	areas[<?php echo $i ?>].color = "<?php echo $areas[$i]["Area"]["color"]; ?>";
	areas[<?php echo $i ?>].date = <?php echo $areas[$i]["Area"]["date"]; ?>;
	areas[<?php echo $i ?>].event_id = <?php echo $areas[$i]["Area"]["event_id"]; ?>;
	areas[<?php echo $i ?>].name = "<?php echo $areas[$i]["Area"]["name"]; ?>";
<?php
} // end for

// 選択中のイベントに関するeachdaysデータを取得する
$eachdays = $this->requestAction('/eachdays/getCanvasWidthHeight/'.$_SESSION['event_id']);

for($i=0; $i<count($eachdays); $i++){
?>
	var list = {
		canvas_width: <?php echo $eachdays[$i]['Eachday']['canvas_width']; ?>,
		canvas_height: <?php echo $eachdays[$i]['Eachday']['canvas_height']; ?>
	}
	eachdays['<?php echo $eachdays[$i]['Eachday']['date']; ?>'] = list;
<?php
}


// イベントの開催日数を取得
$days = $this->requestAction('/events/getEventDays/'.$_SESSION['event_id']);

// Disuseの状態を格納するための配列を初期化（はじめはすべて利用する状態にしておく）
for($i=0; $i<$days; $i++){
	$disuses[$i] = false;
}
// Disuseになっている日程を取得する
$disuseArray = $this->requestAction('/disuses/getByEventID/'.$_SESSION['event_id']);

for($i=0; $i<count($disuseArray); $i++){
	// Disuseにチェックがついている日数のみをtrueに変更させる
	$disuses[$disuseArray[$i]['Disuse']['date']-1] = true;
?>
	disuses[<?php echo $disuseArray[$i]['Disuse']['date']-1; ?>] = true;
<?php
} // end for
?>
</script>
<div>

<!-- canvasArea -->
<div id="canvasArea">
<!-- tab -->
<div id="tab">
<ul class="nav nav-tabs">
<?php

	// イベントの開催日数分のタブを生成する
	for($i=1; $i<=$days; $i++){
?>
<li id="canvasTab<?php echo $i; ?>" class="<?php echo $i==1?'active':''; ?>"><a href="#tcCanvas<?php echo $i ?>" data-toggle="tab" data-days="<?php echo $i; ?>"><?php echo "Day ".$i; ?></a></li>
<?php
	} // end for
?>
</ul>
</div>
<!-- //tab -->
<!-- tab contents -->
<div class="tab-content">
<?php
	// イベントの開催日数分のキャンバスを生成する
	for($i=1; $i<=$days; $i++){
		
		// キャンバスサイズの初期化
		$canvas_width = 720;
		$canvas_height = 960;
		// eachdaysデータからキャンバスの幅・高さを取得する
		for($j=0; $j<count($eachdays); $j++){
			// もしdateが一致するならば、キャンバスの幅・高さを更新する
			if($eachdays[$j]['Eachday']['date'] == $i){
				$canvas_width = $eachdays[$j]['Eachday']['canvas_width'];
				$canvas_height = $eachdays[$j]['Eachday']['canvas_height'];
			}
		}
?>
<div id="tcCanvas<?php echo $i; ?>" class="tab-pane <?php echo $i==1?'active':''; ?>">
<p><input type="checkbox" name="checkDisuse<?php  echo $i; ?>" onChange="onChangeDisuse(this, <?php echo $i; ?>)" <?php echo $disuses[$i-1]==true?'checked':''; ?>>&nbsp;Disuse</p>
<!-- poster canvas -->
<canvas id="posterCanvas<?php echo $i; ?>" class="posterCanvas <?php echo $disuses[$i-1]?'disuse':''; ?>" dropzone="copy" style="
<?php
	// ポスター背景図がセットされていればstyle属性に書き込む 引数1: イベントID 引数2: 日数
	if($this->requestAction('/events/isSetPosterBackground/'.$_SESSION['event_str'].'/'.$i)){
		echo "background-image: ";	
		echo "url(".$this->webroot."img/dot.png), url(".$this->webroot."img/bg/".$_SESSION['event_str']."_".$i.".png); ";
		echo "background-repeat: ";
		echo "repeat, no-repeat; ";
	}
	
	// disuseにチェックが入っていれば、背景画像を上塗りする
	/*
	if($disuses[$i-1]){
		echo "background-image: ";
		echo "url(".$this->webroot."img/bg_canvas_disuse.png);";
		echo "background-repeat: ";
		echo "no-repeat; ";
	}
	*/
	
	// キャンバスの幅と高さ設定
	echo "width: ".$canvas_width."px; ";
	echo "height: ".$canvas_height."px;";
?>
" width="<?php echo $canvas_width; ?>" height="<?php echo $canvas_height; ?>"></canvas>
<!-- // poster canvas -->
<!-- area canvas -->
<canvas id="areaCanvas<?php echo $i; ?>" class="areaCanvas <?php echo $disuses[$i-1]?'disuse':''; ?>" style="
<?php
	// キャンバスの幅と高さ設定
	echo "width: ".$canvas_width."px; ";
	echo "height: ".$canvas_height."px;";
?>
" width="<?php echo $canvas_width; ?>" height="<?php echo $canvas_height; ?>"></canvas>
<!-- // area canvas -->
</div>
<?php
	} // end for
?>
</div>
<!-- //tab contents -->
</div>
<!-- //canvasArea -->

<!-- inputArea -->
<div id="inputArea">
<!-- tab -->
<div id="tab">
<ul class="nav nav-tabs">
<li id="posterEditTab" class="active"><a href="#tcPoster" data-toggle="tab">Poster<br>Edit</a></li>
<li id="presentationTab"><a href="#tcPresentation" data-toggle="tab">Presen<br>tation</a></li>
<li id="areaTab"><a href="#tcArea" data-toggle="tab">Area</a></li>
</ul>
</div>
<!-- //tab -->
<!-- tab contents -->
<div class="tab-content">
<!-- tab contents Poster -->
<div id="tcPoster" class="tab-pane active">

<!-- selectForm -->
<select name="selectMode" class="selectpicker" onChange="changeMode()">
<option value="create">Create Mode</option>
<option value="delete">Delete Mode</option>
</select>
<!-- //selectForm -->
<!-- uploadForm -->
<div id="uploadFormDiv" class="form">
<form id="upLoadForm" class="disno" value="set background">
<input  type="file" id="backGroundImage" class="btn btn-default" accept="image/png" name="backGroundImage" onChange="fileUpLoad('<?php echo $_SESSION['event_str']; ?>')">
<input type="text" name="EventStr" value="<?php echo $_SESSION['event_str']; ?>">
<input type="text" name="EventDate" value="1">
</form>
<!-- 全件削除 -->
<p><a class="btn btn-default disno" href="/kodera_postom/posters/deletePosterAll">Delete All</a></p>
<p>
<button id="selectFile" name="selectFile" class="btn btn-default" type="button" onClick="selectFile()">background picture</button>
</p>
<p><a href="<?php echo $this->Html->webroot;?>img/bg/<?php echo isset($_SESSION['event_str'])? $_SESSION['event_str'] : ''; ?>.png" target="_blank">background picture</a></p>
</div>
<!-- //uploadForm -->
<!-- createForm -->
<div id="createForm" class="form">
<fieldset>
<legend>Create</legend>
<p>width :<input  type="number" class="form-control" name="objectWidth" inputmode="numeric" size="10" value="6" min="1" onKeyup="checkTextIsNumeric(this)"></p>
<p>height :<input type="number" class="form-control" name="objectHeight" inputmode="numeric" size="10" value="4" min="1" onKeyup="checkTextIsNumeric(this)"></p>
<p class="disno">color:<br>
<select name="objectCreateColor" class="selectpicker disno" onChange="changeSelectColor()">
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
<!-- fileForm -->
<!--
<div id="fileForm" class="form">
<p>
<input type="button" name="saveButton" class="btn btn-default" onClick="if(confirm('Do you want to save?'))saveJson()" value="save">
</p>
-->
<!-- loadボタンの削除
<p>
<input type="button" name="loadButton" class="btn btn-default" onClick="loadJson()" value="Read">
</p>
-->
<!-- JSONファイルへのリンクの削除
<p><a href="json/data_nosession.json" target="_blank">JSON file</a></p>
</div>
-->
<!-- //fileForm -->

</div>
<!-- //tab contents Poster -->
<!-- tab contents Presentation -->
<div id="tcPresentation" class="tab-pane">
<?php
// 選択中のイベントに含まれるすべてのプレゼンテーションを取得する
$presentations = $this->requestAction('/presentations/getByEventID/'.$_SESSION['event_id']);

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
<li class="next disabled"><a href="#" data-target="next"><i class="fa fa-angle-double-right"></i></a></li>
</ul>

<?php
// ページ識別用変数
$page = 1;
// カウント用変数
$ct = 0;

// すべてのプレゼンテーション情報を出力する
foreach($presentations as $presentation){
	// プレゼンテーションのroom, session_order, presentation_orderの情報からナンバー（A1-1）を変数として格納
	$presentationNum = $presentation['Presentation']['room'].$presentation['Presentation']['session_order'].'-'.$presentation['Presentation']['presentation_order'];
	// ページ内の一番最初のプレゼンテーションであるか判定
	if($ct == 0){
?>
<div id="page<?php echo sprintf('%02d', $page); ?>" class="page <?php echo $page==1?'':'disno';  ?>">
<ul class="presentationlist">
<?php
	}
?>
<li id="<?php echo $presentation['Presentation']['id']; ?>" data-num="<?php echo $presentationNum; ?>" draggable="true">
<?php
// プレゼンテーションナンバーの表示
echo $presentationNum.": ";
// プレゼンテーションタイトルの表示
echo $presentation['Presentation']['title'];
?>
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
</div>
<!-- //tab contents Presentation -->
<!-- //tab contents Area -->
<div id="tcArea" class="tab-pane">
<!-- createForm -->
<div id="createForm" class="form">
<fieldset>
<legend>Create</legend>
<p>width :<input  type="number" class="form-control" name="areaWidth" inputmode="numeric" size="10" value="" min="1" onKeyup="checkTextIsNumeric(this)" disabled="disabled"></p>
<p>height :<input type="number" class="form-control" name="areaHeight" inputmode="numeric" size="10" value="" min="1" onKeyup="checkTextIsNumeric(this)" disabled="disabled"></p>
<p>position x :<input type="number" class="form-control" name="areaPositionX" inputmode="numeric" size="10" value="" min="1" onKeyup="checkTextIsNumeric(this)" disabled="disabled"></p>
<p>position y :<input type="number" class="form-control" name="areaPositionY" inputmode="numeric" size="10" value="" min="1" onKeyup="checkTextIsNumeric(this)" disabled="disabled"></p>
<p>color:<br>
<select name="areaColor" class="selectpicker" onChange="changeSelectColorAreaObject()">
<option value='#ff2800' class='bg1' >&nbsp;</option>
<option value='#faf500' class='bg2' >&nbsp;</option>
<option value='#35a16b' class='bg3' >&nbsp;</option>
<option value='#0041ff' class='bg4' >&nbsp;</option>
<option value='#66ccff' class='bg5' >&nbsp;</option>
<option value='#ff99a0' class='bg6' >&nbsp;</option>
<option value='#ff9900' class='bg7' >&nbsp;</option>
<option value='#9a0079' class='bg8' >&nbsp;</option>
<option value='#663300' class='bg9' >&nbsp;</option>
</select>
</p>
<p>name :<input type="text" class="form-control" name="areaName" value="" onKeyup="" disabled="disabled"></p>
<p><input type="button" name="updateAreaButton" class="btn btn-default" onClick="updateAreaObject()" value="Update" disabled="disabled"></p>
</fieldset>
</div>
<!-- //createForm -->
<!-- deleteForm -->
<div id="deleteForm" class="form">
<p>
<input type="button" name="deleteAreaButton" class="btn btn-default" onClick="deleteAreaObject()" value="Delete" disabled="disabled">
</p>
</div>
<!-- //deleteForm -->
</div>
<!-- //tab contents Area -->
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
<!--
<div id="dialogEditConfirm" class="disno" title="Edit check">
<p>Are you make sure to do this?</p>
</div>
-->
<!-- //dialogEditConfirm -->
