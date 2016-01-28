/*-------------------------------------------------

  Poster javascript

 --------------------------------------------------*/

/********************************************************
 * グローバルナビゲーション カレント処理
 ********************************************************/
 $(function(){
	// ダッシュボードのPosterを選択状態にする
	$('#dashboard #gNav #gNavPos').addClass('current');
});

/********************************************************
 * 変数定義
 ********************************************************/
// キャンバスの横幅, 高さ
var canvasWidth = 720;
var canvasHeight = 960;
// キャンバスの縦横比(4:3)
var canvasRatio = 4/3;
// 入力フォームの横幅
var formWidth = 240;
// 1グリッドあたりのサイズ（１辺の長さ）
var gridSize = 10;
// 生成時における最初の位置（x, y）
var initX = 0, initY = 0;
// グリッドにおける番地
var gridX, gridY;
// 現在のモード(create, delete, presentation, disuse)
var selectMode = "create";
// 前回のモード
var formerMode = "create";
// 削除対象を記憶する配列
var deleteArray = [];
// サイズ変更を受け付ける領域のサイズ（１辺の長さ）
var resizeArea = 10;
// サイズ変更ができる状態であるかどうか
var resizeFlg = false;
// サイズ変更中であるかどうか
var onResizing = false;
// デフォルトの色
var defaultColor = "#999999";
// 関連済みを示すの色
var relatedColor = "#063a5e";
// 色の定義
var whiteColor = "#ffffff";
var blackColor = "#000000";
// 会場図画像ファイル名
var backGroundFileName = "";
// キャンバスを基準にクリックした位置
var pointerX = 0;
var pointerY = 0;
// オブジェクトを基準にクリックした位置
var onPointX = 0;
var onPointY = 0;
// ポスターオブジェクトでのセレクトスクエア配列？？
var objectArray = [];
// エリアオブジェクトでのセレクトスクエア配列
var selectSquareArray = [];
// 選択されているポスターオブジェクト
var selectedObject;
// 選択されているエリアオブジェクト
var selectedAreaObject;
// 選択されているポスターオブジェクトがあるかどうか
var selectFlag = false;
// 選択されているエリアオブジェクトがあるかどうか
var selectFlagAreaObject = false;
// ?
var nowwhite;
// 選択しているオブジェクトの右端の座標
var nowright;
// 選択してるオブジェクトの左下の座標
var nowbottom;
// サイズ変更前の位置
var previewscalex;
var previewscaley;
// サイズ変更前の大きさ
var previewbigx;
var previewbigy;
// マップサイズの最小値・最大値
var mapMinWidth = 300;
var mapMinHeight = 400;
var mapMaxWidth = 1500;
var mapMaxHeight = 2000;
// 選択中のプレゼンテーションID
var selectedPresentationID = 0;
// 選択中のプレゼンテーションナンバー
var selectedPresentationNum = '';
// 次のid
var NextId=1;
// 読み込み中
var loading = true;
// 選択中のポスターキャンバスタブの日数
var selectedDay = 1;
// 前状態のポスターキャンバスタブの日数
var previousDay = 1;
// 複数日対応 ポスターキャンバス要素配列
var canvasPosterElementArray = new Array();
// 複数日対応 エリアキャンバス要素配列
var canvasAreaElementArray = new Array();
// 複数日対応 ポスターステージ配列
var stagePosterArray = new Array();
// 複数日対応 エリアステージ配列
var stageAreaArray = new Array();
// 選択中のcanvas要素
var canvasElement;
// 選択中のstage
var stage;
// エリアオブジェクトを生成中であるか否か
var createFlagAreaObject = false;
// エリアオブジェクト生成用変数
var areaObject;
var areaObjectX = 0;
var areaObjectY = 0;
var areaObjectWidth = 0;
var areaObjectHeight = 0;
var areaObjectColor = '';
// エリアオブジェクト生成初期変数
var areaObjectInitWidth = 10;
var areaObjectInitHeight = 10;
// エリアオブジェクト生成の際の閾値（2*3グリッドほどの距離がないとエリアオブジェクトとしない）
var areaObjectThreshold = Math.abs(Math.sqrt(Math.pow(2*gridSize,2)+Math.pow(3*gridSize,2)));
// エリアオブジェクトの色配列（page_poster.cssの#inputArea .bgの順序と同じにしてください）
var areaObjectColorArray = ['#ff2800', '#faf500', '#35a16b', '#0041ff', '#66ccff', '#ff99a0', '#ff9900', '#9a0079', '#663300'];
// エリアオブジェクトの色配列の登場回数
var areaObjectColorCountArray = [0, 0, 0, 0, 0, 0, 0, 0, 0];
// エリアオブジェクト生成で選定したカラー番号変数
var areaObjectColorNum = 0;

/********************************************************
 * 読み込み時の処理
 ********************************************************/
$(function() {
	$('[name^="objectWidth"]').attr("max",canvasWidth/gridSize);
	$('[name^="objectHeight"]').attr("max",canvasHeight/gridSize);
	$('[name^="areaWidth"]').attr("max",canvasWidth/gridSize);
	$('[name^="areaHeight"]').attr("max",canvasHeight/gridSize);

	// 複数日対応 ポスターキャンバス要素配列・エリアキャンバス要素配列・ステージ配列の格納
	for(var i=0; i<eventDays; i++){
		// ポスターキャンバス・エリアキャンバスサイズを指定
		/*
		$('#posterCanvas'+(i+1)).get(0).width = canvasWidth;
		$('#posterCanvas'+(i+1)).get(0).height = canvasHeight;
		$('#areaCanvas'+(i+1)).get(0).width = canvasWidth;
		$('#areaCanvas'+(i+1)).get(0).height = canvasHeight;
		*/
		// ポスターキャンバスにプレゼンテーションからの関連づけのマウスイベントを受け付ける
		$('#posterCanvas'+(i+1)).on('dragover', onDragOver);
		$('#posterCanvas'+(i+1)).on('drop', onDrop);
		// ポスターキャンバス要素配列
		canvasPosterElementArray[i] = document.getElementById("posterCanvas"+(i+1));
		// エリアキャンバス要素配列
		canvasAreaElementArray[i] = document.getElementById("areaCanvas"+(i+1));
		// ポスターステージ配列
		stagePosterArray[i] = new createjs.Stage(canvasPosterElementArray[i]);
		stagePosterArray[i].enableMouseOver();
		stagePosterArray[i].enableDOMEvents(true);
		// エリアステージ配列
		stageAreaArray[i] = new createjs.Stage(canvasAreaElementArray[i]);
		stageAreaArray[i].enableMouseOver();
		stageAreaArray[i].enableDOMEvents(true);
		
		// ポスターキャンバスをクリックした際には、選択中を解除する処理をデフォルトで埋め込む
		document.getElementById("posterCanvas"+(i+1)).addEventListener("click",cancelFrame);
		// エリアキャンバスをクリックした際には、選択中を解除する処理をデフォルトで埋め込む
		document.getElementById("areaCanvas"+(i+1)).addEventListener("click", cancelFrameAreaObject);
		// エリアキャンバスはキャンバス上でドラッグアンドドロップすることで生成もおこなうことができる
		document.getElementById("areaCanvas"+(i+1)).addEventListener("mousedown", startDragCreateAreaObject);
		document.getElementById("areaCanvas"+(i+1)).addEventListener("mousemove", draggingCreateAreaObject);
		document.getElementById("areaCanvas"+(i+1)).addEventListener("mouseup", stopDragCreateAreaObject);
	}

	// イベントの初日にdisuseが設定されていたらメニューの利用可能状態を利用できない状態にする
	if(disuses[0]){
		// 読み込みのタイミングによってはモード選択のセレクトボックスの生成のほうが遅れるため、モード選択のセレクトボックスが生成されるまで繰り返す
		timerCheckExistSelectBox = setInterval(function(){
			if($('[name^="selectMode"] + div.btn-group > button').length){
				// セレクトボックスが生成されたとき
				changeDisabledState(true, true, false);
				// canvasの背景色を変更する
				$('#posterCanvas1').addClass('disuse');
				// タイマーを停止させる
				clearInterval(timerCheckExistSelectBox);
			}else{
				// セレクトボックスがまだなければ何もしない
			}
		}, 100);
	}
	
	// 読み込みのタイミングによってはエリアオブジェクトの編集フォームの色セレクターの生成が遅れるため、色セレクターが生成されるまで繰り返して待つ
	timerCheckExistColorSelector = setInterval(function(){
		if($('[name^="areaColor"] + div.btn-group > button').length){
			$('[name^="areaColor"]').val(defaultColor);
			$('select[name="areaColor"] + .btn-group > .selectpicker > span:first-child').css("background-color", defaultColor);
			$('[name^="areaColor"] + div.btn-group > button').prop('disabled', true);
			// タイマーを停止させる
			clearInterval(timerCheckExistColorSelector);
		}else{
			// セレクトボックスがまだなければ何もしない
		}
	}, 100);

	// 初日のキャンバスのサイズをマップ編集フォームの項目にセットする
	$('input[name="mapWidth"]').attr('value', $('#posterCanvas1').attr('width'));
	$('input[name="mapHeight"]').attr('value', $('#posterCanvas1').attr('height'));
	

	/********************************************************
	 * データベースから取得したポスターを各日数におけるポスターキャンバスに描写する処理
	 ********************************************************/
	// イベントの日数分繰り返す
	for(j=0; j<eventDays; j++){
		// stageを次の日に差し替える
		stage = stagePosterArray[j];
		// データベースから取得したポスター分繰り返す
		for(i=0; i<poster.length; i++){
			// ポスターのdateが(j+1)日と一致していれば、そのキャンバスに描写する
			if(poster[i].date == (j+1)){
				//ポスター情報を反映
				var instance = createObject(parseInt(poster[i].x), parseInt(poster[i].y), parseInt(poster[i].width), parseInt(poster[i].height), poster[i].color, poster[i].date);
				instance.NextId = poster[i].NextId;
				if(poster[i].NextId >= NextId){
					NextId = poster[i].NextId+1;
				}
				instance.cursor = "pointer";
				instance.__deleteSelected = false;
				instance.__relation = poster[i].presentation_id;
				instance.__id = poster[i].id;
				stage.addChild(instance);
				instance.addEventListener("mousedown", startDrag);

				// ポスターに関連済みプレゼンテーションがあれば、テキストオブジェクトを生成する
				if(instance.__relation != undefined && instance.__relation != '' && instance.__relation != '0'){
					// ポスターの色を関連済みの色に変更する
					instance.graphics._fill.style = relatedColor;
					instance.color = relatedColor;
					// 関連済みプレゼンテーションのIDを変数に格納
					var presentationIDStr = presentations[i].room + presentations[i].session_order + "-" + presentations[i].presentation_order;
					// テキストオブジェクトを生成する
					var text = new createjs.Text(presentationIDStr, '20px Meiryo', '#fff');
					var textWidth = text.getMeasuredWidth();
					var textHeight = text.getMeasuredHeight();
					// テキストをオブジェクトの中央に配置
					text.x = instance.x + (instance.width - textWidth)/2;
					text.y = instance.y + (instance.height - textHeight)/2;
					// テキストオブジェクトにオブジェクトタイプを付与
					text.__type = 'text';
					// テキストオブジェクトに親要素であるポスターオブジェクトのIDを付与（ポスターが移動した際に、テキストもついていくようにするため）
					text.__parent = instance.id;

					stage.addChild(text);

					// 選択中のプレゼンテーションの要素を関連付けされた状態にする
					$('.presentationlist li#'+instance.__relation).addClass('related').attr('data-relation', instance.id);
				} // end if
			} // end if
		} // end for
		// stageの状態をcanvasに反映させる
		stage.update();
		// stageの状態を配列に格納
		stagePosterArray[j] = stage;
	} // end for
	
	
	/********************************************************
	 * データベースから取得したエリアを各日数におけるエリアキャンバスに描写する処理
	 ********************************************************/
	// イベントの日数分繰り返す
	for(j=0; j<eventDays; j++){
		// stageを次の日に差し替える
		stage = stageAreaArray[j];
		// データベースから取得したエリア分繰り返す
		for(i=0; i<areas.length; i++){
			// エリアのdateが(j+1)日と一致していれば、そのキャンバスに描写する
			if(areas[i].date == (j+1)){
				// エリア情報を反映
				var instance = createAreaObject(parseInt(areas[i].x), parseInt(areas[i].y), parseInt(areas[i].width), parseInt(areas[i].height), areas[i].color);
				instance.cursor = "pointer";
				instance.__id = areas[i].id;
				instance.name = areas[i].name;
				instance.addEventListener("mousedown", startDragAreaObject);
				stage.addChild(instance);
				stage.update();
				
				// エリアオブジェクト使用色配列のカウントアップ
				for(var k=0; k<areaObjectColorArray.length; k++){
					if(areaObjectColorArray[k] == instance.color){
						areaObjectColorCountArray[k]++;
					}
				}
				

			} // end if
		} // end for
		// stageの状態をcanvasに反映させる
		stage.update();
		// stageの状態を配列に格納
		stageAreaArray[j] = stage;
	} // end for
	
	loading = false;

	// 初期状態は、canvas要素, stageともにイベント初日とする
	canvasElement = canvasPosterElementArray[0];
	stage = stagePosterArray[0];

});

/********************************************************
 * ブラウザのリサイズ時の処理
 ********************************************************/
$(window).on('load resize', function(){
});

/********************************************************
 * 任意の要素が存在するかどうか確認する関数
 ********************************************************/
function isExistElement(ele){
	if($(ele).get(0)){
		return true;
	}else{
		return false;
	}
}

/********************************************************
 * オブジェクトのリサイズ領域にマウスポインタがあるか検査
 ********************************************************/
function checkResize(x, y){
	if(selectMode == "create" && !onResizing){
		childArray = stagePosterArray[selectedDay-1].children;
		resizeFlg = false;
		for(i=0; i<childArray.length; i++){
			objectX = childArray[i].x;
			objectY = childArray[i].y;
			objectWidth = parseInt(childArray[i].graphics.command.w);
			objectHeight = parseInt(childArray[i].graphics.command.h);
			objectRightBottom = {'x': objectX + objectWidth, 'y': objectY + objectHeight};
			if(x < objectRightBottom.x && x > objectRightBottom.x - resizeArea && y < objectRightBottom.y && y > objectRightBottom.y - resizeArea){
				resizeFlg = true;
				// サイズ変更用のカーソルに変更
				childArray[i].cursor = "se-resize";
				break;
			}else{
				childArray[i].cursor = "pointer";
			}
		}
	}
}

/********************************************************
 * オブジェクト処理
 ********************************************************/
// オブジェクト配置処理
function setObject(){
	var objectWidth = $('[name^="objectWidth"]').val() * gridSize;
	var objectHeight = $('[name^="objectHeight"]').val() * gridSize;
	if( objectWidth == '' || objectHeight == '' ){
		alert("something not input");
	}else if( objectWidth <= 0 || objectHeight <= 0 ){
		alert("you must input bigger than 0");
	}else if( objectWidth > canvasWidth || objectHeight > canvasHeight ){
		alert("you must input smaller than width"+canvasWidth/gridSize+"grid, height"+canvasHeight/gridSize+"grid");
	}else{
		var objectCreateColor = $('[name^="objectCreateColor"]').val();
		var object = createObject(initX, initY, objectWidth , objectHeight , objectCreateColor, selectedDay);
		stage.addChild(object);
		stage.update();
		object.addEventListener("mousedown", startDrag);
        var tempevent=object;
        tempevent.target=object;
        click(object);
	}
}

// オブジェクト生成処理
function createObject(x, y, w, h, color, date) {
	var object = new createjs.Shape();
	object.x = x;
	object.y = y;
	object.width = w;
	object.height = h;
	object.color=color;
    object.__title = "";
    object.__presenter = "";
    object.__abstract = "";
	object.__id = '';
	object.__date = date;
	object.NextId=NextId;
	NextId++;
	object.graphics.beginFill(color);

	var OUT;
	if(stage.children.length !=0){
		OUT:for(var ynow=0;ynow<=canvasHeight-h;ynow=ynow+gridSize){
			for(var xnow=0;xnow<=canvasWidth-w;xnow=xnow+gridSize){
				for(var k=stage.children.length-1;k>=0;k--){
					if(stage.children[k].__type == "selectSquare"){
						continue;
					}
					if(xnow > stage.children[k].x - w && xnow < stage.children[k].x + (stage.children[k].width) && ynow > stage.children[k].y- h && ynow < stage.children[k].y + (stage.children[k].height)){
						break;
					}
					if(k==0){
						break OUT;
					}
					if(ynow>=canvasHeight-h && xnow >=canvasWidth-w){
						alert("you can't create any more");
						return false;
					}
				}
			}
		}
		object.graphics.drawRect(0,0, w, h);
		// 生成ボタンを押したときによる生成の場合
		if(x==initX && y==initY){
			object.x =xnow;
			object.y =ynow;
		}
	}else{
		object.graphics.drawRect(0,0, w, h);
	}
	object.cursor = "pointer";
	if(loading == false){
	//生成終了後、保存
		singlesaveJson(object);
	}
	return object;
}

/********************************************************
 * マウスイベント処理
 ********************************************************/
// ドラッグの開始処理
function startDrag(eventObject) {
    selectFlag=false;
	var instance = eventObject.target;
	// キャンバスを基準にクリックした位置
    pointerX = eventObject.stageX;
    pointerY = eventObject.stageY;
	// オブジェクトを基準にクリックした位置
	onPointX = eventObject.stageX - instance.x;
	onPointY = eventObject.stageY - instance.y;

	if(selectMode == "create"){
		if(!resizeFlg){
			// 移動
			instance.addEventListener("pressmove", drag);
			instance.addEventListener("pressup", stopDrag);
			previewscalex=instance.x;
			previewscaley=instance.y;
		}else if(resizeFlg){
			// サイズ変更
			instance.addEventListener("pressmove", resizeDrag);
			instance.addEventListener("pressup", stopResizeDrag);
		}
	}else if(selectMode == "delete"){
		// 削除対象選択
		instance.addEventListener("pressup", selectDelete);
	}
}

// ＜移動＞ドラッグ中の処理
function drag(eventObject) {
	var instance = eventObject.target;
	var dragedID = instance.id;
	var width = parseInt(instance.graphics.command.w);
	var height = parseInt(instance.graphics.command.h);
	var leftTop = { x: instance.x, y: instance.y };
	var rightTop = { x: instance.x + width , y: instance.y };
	var rightBottom = { x:instance.x + width , y: instance.y + height };
	var leftBottom = { x: instance.x , y: instance.y + height };
	// ドラッグ中のオブジェクトが関連付け済みである場合、関連付けされているプレゼンテーションテキストも移動させる
	if(instance.__relation != "" && instance.__relation != undefined){
		// 関連付けされているプゼンテーションテキストを特定する
		for(var i=0; i<stage.children.length; i++){
			var object = stage.children[i];
			if(object.__parent == dragedID){
				object = relocateCenter(object, instance);
				break;
			}
		}
	}
	// ポインタ位置が画面外だった時の分岐
	if((onPointX <= eventObject.stageX)&&(eventObject.stageX <= canvasWidth - width + onPointX)
	&&(onPointY <= eventObject.stageY)&&(eventObject.stageY <= canvasHeight -height + onPointY)){
		// in canvas
		instance.x = Math.round((eventObject.stageX - onPointX)/gridSize)*gridSize;
		instance.y = Math.round((eventObject.stageY - onPointY)/gridSize)*gridSize;
		if(instance.array!=null){
			updateFrame(instance.x,instance.y,width,height);
		}
	}else if((onPointX <= eventObject.stageX)&&(eventObject.stageX <= canvasWidth - width + onPointX)
	&&(0 <= eventObject.stageY)&&(eventObject.stageY < onPointY)){
		// over top
		instance.x = Math.round((eventObject.stageX - onPointX)/gridSize)*gridSize;
		if(instance.array!=null){
			updateFrame(instance.x,instance.y,width,height);
		}
	}else if((canvasWidth - width + onPointX < eventObject.stageX)&&(eventObject.stageX <= canvasWidth)
	&&(onPointY <= eventObject.stageY)&&(eventObject.stageY <= canvasHeight -height + onPointY)){
		// over right
		instance.y = Math.round((eventObject.stageY - onPointY)/gridSize)*gridSize;
		if(instance.array!=null){
			updateFrame(instance.x,instance.y,width,height);
		}
	}else if((onPointX <= eventObject.stageX)&&(eventObject.stageX <= canvasWidth - width + onPointX)
	&&(canvasHeight - height + onPointY < eventObject.stageY)&&(eventObject.stageY <= canvasHeight)){
		// over bottom
		instance.x = Math.round((eventObject.stageX - onPointX)/gridSize)*gridSize;
		if(instance.array!=null){
			updateFrame(instance.x,instance.y,width,height);
		}
	}else if((0 <= eventObject.stageX)&&(eventObject.stageX <= onPointX)
	&&(onPointY <= eventObject.stageY)&&(eventObject.stageY <= canvasHeight -height + onPointY)){
		// over left
		instance.y = Math.round((eventObject.stageY - onPointY)/gridSize)*gridSize;
		if(instance.array!=null){
			updateFrame(instance.x,instance.y,width,height);
		}
	}
	stage.update();
}

// ＜移動＞ドラッグの終了処理
function stopDrag(eventObject) {
	var instance = eventObject.target;
	instance.removeEventListener("pressmove", drag);
	instance.removeEventListener("pressup", stopDrag);
	// マウスダウンした位置からマウスアップした位置までの移動距離（３平方の定理）
	var dragDistant = Math.sqrt(Math.pow(eventObject.stageX-pointerX,2) + Math.pow(eventObject.stageY-pointerY,2));
	// 限りなくクリックに近いドラッグの場合
	if(dragDistant < 3){
        	click(eventObject);
	}
	var i = stage.children.length - 1;
	while(instance.x != stage.children[i].x || instance.y != stage.children[i].y  || stage.children[i].__type =="selectSquare"){
		i=i-1;
	}
	for(var k=stage.children.length-1;k>=0;k--){
		if(k==i || stage.children[k].__type =="selectSquare"){
            continue;
		}
		// 他のオブジェクトと重なった場合は移動する前に戻す
		if(instance.x > stage.children[k].x - (instance.width) && instance.x < stage.children[k].x + (stage.children[k].width) && instance.y > stage.children[k].y- (instance.height) && instance.y < stage.children[k].y + (stage.children[k].height)){
			instance.x = previewscalex;
			instance.y = previewscaley;
			// SelectSquareの更新
			if(instance.array != null){
				updateFrame(instance.x,instance.y,instance.width,instance.height);
			}

			// 関連済みポスターの場合、テキストオブジェクトも元の位置に戻す
			if(instance.__relation != undefined && instance.__relation != '' && instance.__relation != '0'){
				// テキストオブジェクトを特定
				for(var i=0; i<stage.children.length; i++){
					var object = stage.children[i];
					if(object.__parent == instance.id){
						object = relocateCenter(object, instance);
						break;
					}
				}
			}
			break;
		}
	}
	stage.update();
	//移動終了後、保存
	singlesaveJson(instance);
}
/********************************************************
 * オブジェクトの選択処理
 ********************************************************/
// オブジェクトを選択
function click(eventObject){
	selectFlag = false;
	// 既に選択されているオブジェクトをクリックした場合
	if(eventObject.target==selectedObject){
		return;
	}
	// 選択されているオブジェクト以外をクリックした場合
	if(selectedObject!=null){
		selectFlag=true;
		cancelFrame();
		selectFlag=false;
	}
	selectedObject = eventObject.target;
	select();
	selectedObject.array=objectArray;
	inputEditForm();
}

// ドロップ中の再描画
function updateFrame(x,y,w,h) {
	for (var i = 0, p = 0; i < 3; i++) {
		for (var j = 0; j < 3; j++) {
			if (!(i == 1 && j == 1)) {
				if(selectMode == 'create' || selectMode == 'delete'){
					objectArray[p].graphics.clear();
					objectArray[p].graphics.beginFill(blackColor);
					objectArray[p].graphics.drawRect(x - 5 + j * w / 2, y - 5 + i * h / 2, 10, 10);
					objectArray[p].graphics.beginFill(whiteColor);
					objectArray[p].graphics.drawRect(x - 4 + j * w / 2, y - 4 + i * h / 2, 8, 8);
				}else if(selectMode == 'area'){
					selectSquareArray[p].graphics.clear();
					selectSquareArray[p].graphics.beginFill(blackColor);
					selectSquareArray[p].graphics.drawRect(x - 5 + j * w / 2, y - 5 + i * h / 2, 10, 10);
					selectSquareArray[p].graphics.beginFill(whiteColor);
					selectSquareArray[p].graphics.drawRect(x - 4 + j * w / 2, y - 4 + i * h / 2, 8, 8);
				}
				p++;
			}
		}
	}
}

// 選択した時の選択枠描画
function select(){
	// 編集フォームを利用可能に
	$('[name="title"]').prop("disabled", false);
	$('[name="presenter"]').prop("disabled", false);
	$('[name="abstract"]').prop("disabled", false);
	$('[name="objectEditColor"]').prop("disabled", false);
	$('select[name="objectEditColor"] + .btn-group > button').removeClass("disabled");
	$('select[name="objectEditColor"] + .btn-group > button + .dropdown-menu > ul > li ').removeClass("disabled");
	$('[name="inputForm"]').prop("disabled", false);

	var x = selectedObject.x;
	var y = selectedObject.y;
	var w = parseInt(selectedObject.graphics.command.w);
	var h = parseInt(selectedObject.graphics.command.h);

	for(var i=0; i<3; i++){
		for(var j=0;j<3;j++){
			if (!(i == 1 && j == 1)) {
				var sq = new createjs.Shape();
				sq.graphics.beginFill(blackColor);
				sq.graphics.drawRect(x - 5 + j * w / 2, y - 5 + i * h / 2, 10, 10);
				sq.graphics.beginFill(whiteColor);
				sq.graphics.drawRect(x - 4 + j * w / 2, y - 4 + i * h / 2, 8, 8);
				// フレーム毎に番号を振る
				sq.__number=i*3+j;
				sq.addEventListener("stagemousemove",FrameMouseOver(sq));
				sq.addEventListener("mousedown",FrameDragStart);
				stage.addChild(sq);
				objectArray.push(sq);
				sq.__type="selectSquare";
			}
		}
	}
	stage.update();
}

// 選択枠を消す
function cancelFrame(eventObject){
    if(selectFlag==true) {
        if (selectedObject != null) {  // canvasクリック2回連続以降は呼ばれないようにする
            var formColor = $('select[name="objectEditColor"] + .btn-group > .selectpicker > span:first-child').css('background-color');//　rgb
			if (selectedObject.__title != $('[name^="title"]').val() || selectedObject.__presenter != $('[name^="presenter"]').val() || selectedObject.__abstract != $('[name^="abstract"]').val() || rgbToHex(formColor).toLowerCase() != rgbToHex(selectedObject.color).toLowerCase()) {
                //changeSelectObject(selectedObject, $('[name^="title"]').val(), $('[name^="presenter"]').val(), $('[name^="abstract"]').val(), formColor);  //　JSが先にselectedObjectとフォーム内容を消すので引数で渡しておく
            }
        }
        $('input[name="title"]').val("");
        $('input[name="presenter"]').val("");
        $('textarea[name="abstract"]').val("");
        if(objectArray.length!=0) {
            for (var i = 0; i < 8; i++) {
                objectArray[i].graphics.clear();
                stage.removeChild(objectArray[i]);
            }
            stage.update();
            selectedObject.array = null;
            objectArray = [];
        }
        selectedObject=null;
		// 編集フォームを利用不可に
		$('[name="title"]').prop("disabled", true);
		$('[name="presenter"]').prop("disabled", true);
		$('[name="abstract"]').prop("disabled", true);
		$('[name="objectEditColor"]').prop("disabled", true);
		$('[name="inputForm"]').prop("disabled", true);
		$('select[name="objectEditColor"] + .btn-group > .selectpicker > span:first-child').css('background-color', defaultColor);
    }else{
        selectFlag=true;
    }
}

//　mouse overのポインター処理
function FrameMouseOver(sq){
	resizeFlg = false;
	//　フレームによってマウスカーソルを変える
	if(sq.__number== 0 || sq.__number==8){
		sq.cursor = "se-resize";
	}
	if(sq.__number== 2 || sq.__number==6){
		sq.cursor = "sw-resize";
	}
	if(sq.__number== 1 || sq.__number==7){
		sq.cursor = "s-resize";
	}
	if(sq.__number== 3 || sq.__number==5){
		sq.cursor = "e-resize";
	}
}

//ドラッグの開始処理
function FrameDragStart(eventObject){
	selectFlag=false;
	var instance = selectedObject;
	// オブジェクト上のどの位置をクリックしたか
	pointerX= eventObject.stageX;
	pointerY= eventObject.stageY;
	onPointX = eventObject.stageX - instance.x;
	onPointY = eventObject.stageY - instance.y;
	if(selectMode == "create") {
		// サイズ変更
		eventObject.target.addEventListener("pressmove", FrameDrag);
		eventObject.target.addEventListener("pressup", FrameDragOver);
		//ドラック開始時のオブジェクトの大きさ取得
		previewbigx = instance.graphics.command.w;
		previewbigy = instance.graphics.command.h;
		//ドラック開始時のオブジェクトの座標取得
		previewscalex=instance.x;
		previewscaley=instance.y;
		//ドラック開始時のオブジェクトの右端と下端の座標取得
		nowright= instance.x+previewbigx;
		nowbottom= instance.y+previewbigy;
			var nowdistance=1000;
		//最も近いフレームを、今回サイズ変更するフレームとみなす
		for(var k =stage.children.length-1;k>=0;k--){
			if(stage.children[k].__type =="selectSquare"){
				if(nowdistance >Math.abs(Math.ceil((stage.children[k].graphics.command.x)/gridSize)*gridSize-Math.ceil((eventObject.stageX)/gridSize)*gridSize)+Math.abs(Math.ceil((stage.children[k].graphics.command.y)/gridSize)*gridSize-Math.ceil((eventObject.stageY)/gridSize)*gridSize)){
				nowdistance =Math.abs(Math.ceil((stage.children[k].graphics.command.x)/gridSize)*gridSize-Math.ceil((eventObject.stageX)/gridSize)*gridSize)+Math.abs(Math.ceil((stage.children[k].graphics.command.y)/gridSize)*gridSize-Math.ceil((eventObject.stageY)/gridSize)*gridSize);
				nowwhite=k;
				}
			}
		}
	}
}

// ドラッグ中処理
function FrameDrag(eventObject){
	var eb=eventObject;
	eb.target=selectedObject;
	resizeDrag(eb);
	var instance =eventObject.target;
}

// ドラッグ終わり処理
function FrameDragOver(eventObject){
	var instance =eventObject.target;
	instance.removeEventListener("pressmove", resizeDrag);
	instance.removeEventListener("pressup", stopResizeDrag);
	var x =Math.ceil(eventObject.stageX/gridSize) * gridSize;
	var y =Math.ceil(eventObject.stageY/gridSize) * gridSize;
	var instance = eventObject.target;
	instance.graphics.command.w = Math.ceil((eventObject.stageX - instance.x)/gridSize)*gridSize;
	instance.graphics.command.h =  Math.ceil((eventObject.stageY - instance.y)/gridSize)*gridSize;
	instance.width = Math.ceil((eventObject.stageX - instance.x)/gridSize)*gridSize;
	instance.height =  Math.ceil((eventObject.stageY - instance.y)/gridSize)*gridSize;

	var i=stage.children.length-1;
	while(selectedObject!= stage.children[i]){
		i=i-1;
	}
	for(var k=stage.children.length-1;k>=0;k--){
		if(k==i || stage.children[k].__type =="selectSquare"){//sq.__type="selectSquare";
			continue;
		}
		//他のオブジェクトと重なった場合は、位置、大きさ共に元に戻す
		if(stage.children[i].x > stage.children[k].x - (stage.children[i].width) && stage.children[i].x < stage.children[k].x + (stage.children[k].width) && stage.children[i].y > stage.children[k].y- (stage.children[i].height) && stage.children[i].y < stage.children[k].y + (stage.children[k].height)){
			stage.children[i].graphics.command.w =previewbigx;
			stage.children[i].graphics.command.h =previewbigy;
			stage.children[i].width = previewbigx;
			stage.children[i].height = previewbigy;
			stage.children[i].x = previewscalex;
			stage.children[i].y = previewscaley;
			previewscalex = instance.x;
			previewscaley=instance.y;
			updateFrame(stage.children[i].x,stage.children[i].y,stage.children[i].graphics.command.w,stage.children[i].graphics.command.h);
			
			// 対象オブジェクトが関連付け済みである場合、関連付けされているプレゼンテーションテキストも移動させる
			if(stage.children[i].__relation != "" && stage.children[i].__relation != undefined){
				// 関連付けされているプゼンテーションテキストを特定する
				for(var j=0; j<stage.children.length; j++){
					var object = stage.children[j];
					if(object.__parent == stage.children[i].id){
						object = relocateCenter(object, stage.children[i]);
						break;
					}
				}
			}
			
			stage.update();
			break;
		}
	}
	onResizing = false;
	//サイズ変更終了後、保存
	singlesaveJson(stage.children[i]);
}

// 選択されたオブジェクトが持つデータを編集フォームに反映する
function inputEditForm(){
    $('input[name="title"]').val(selectedObject.__title);
    $('input[name="presenter"]').val(selectedObject.__presenter);
    $('textarea[name="abstract"]').val(selectedObject.__abstract);
    $('select[name="objectEditColor"] + .btn-group > .selectpicker > span:first-child').css('background-color',selectedObject.color);
}

// ＜サイズ変更＞ドラック中の処理
function resizeDrag(eventObject) {
	var changeFrame = stage.children[nowwhite].__number;
	var instance = eventObject.target;
	var dragedID = instance.id;
	/*
	// 他のオブジェクトとの衝突判定
	var collisionFlg = false;
	// 移動中オブジェクトの中心座標・幅・高さ
	var centerX = instance.x + (instance.width/2);
	var centerY = instance.y + (instance.height/2);
	var width = instance.width;
	var height = instance.height
	
	for(var i=0; i<stage.children.length; i++){
		// 衝突判定のターゲットオブジェクト
		var target = stage.children[i];
		// セレクトスクエアやテキストオブジェクトや自分自身のオブジェクトは判定に除く
		if(!(target.__type=="selectSquare") && !(target.__type=="text") && !(target.id==dragedID)){
			// ターゲットの中心座標・幅・高さ
			var targetCenterX = target.x + (target.width/2);
			var targetCenterY = target.y + (target.height/2);
			var targetWidth = target.width;
			var targetHeight = target.height;
			
			// 水平方向での衝突判定
			var horizontal = false;
			// 水平方向チェック
			if(Math.abs(centerX - targetCenterX) < (width/2 + targetWidth/2)){
				horizontal = true;
			}
			console.log("horizontal: "+horizontal);
			
			// 垂直方向での衝突判定
			var vertical = false;
			if(Math.abs(centerY - targetCenterY) < (height/2 + targetHeight/2)){
				vertical = true;
			}
			console.log("vertical: "+vertical);
			
			// 水平方向も垂直方向も衝突していれば、衝突している
			if(horizontal && vertical){
				collisionFlg = true;
			}
		}
	}
	*/	
	// 0:左上	1:中央上	2:右上
	// 3:左中央	4:-			5:右中央
	// 6:左下	7:中央下	8:右下
	
	// 図形の右部分（右方向への更新処理）
	if(changeFrame == 2 || changeFrame == 5 || changeFrame==8){
		instance.graphics.command.w = Math.ceil((eventObject.stageX - instance.x)/gridSize)*gridSize;
		instance.width = Math.ceil((eventObject.stageX - instance.x)/gridSize)*gridSize;
	}
	// 図形の下部分（下方向への更新処理）
	if(changeFrame == 6 || changeFrame == 7 || changeFrame==8){
		instance.graphics.command.h =  Math.ceil((eventObject.stageY - instance.y)/gridSize)*gridSize;
		instance.height =  Math.ceil((eventObject.stageY - instance.y)/gridSize)*gridSize;
	}
	// 図形の左部分（左方向への更新処理）
	if(changeFrame == 0 || changeFrame==3 || changeFrame==6){
		instance.x = Math.round((eventObject.stageX - onPointX)/gridSize)*gridSize;
		instance.graphics.command.w = nowright-instance.x;
		instance.width = nowright-instance.x;
	}
	// 図形の上部分（上方向への更新処理）
	if(changeFrame == 0 || changeFrame==1 || changeFrame==2){
		instance.y = Math.round((eventObject.stageY - onPointY)/gridSize)*gridSize;
		instance.graphics.command.h = nowbottom-instance.y;
		instance.height = nowbottom-instance.y;
	}
	//　x座標は右端より左
	if(instance.x>=nowright){
		instance.x=nowright-gridSize;
	}
	//　y座標は下端より上
	if(instance.y>=nowbottom){
		instance.y=nowbottom-gridSize;
	}
	// 横幅がグリッドサイズより小さいとき
	if(instance.graphics.command.w < gridSize){
		instance.graphics.command.w = gridSize;
		instance.width = gridSize;
	}
	// 高さがグリッドサイズより小さいとき
	if(instance.graphics.command.h < gridSize){
		instance.graphics.command.h = gridSize;
		instance.height = gridSize;
	}
	if(instance.array!=null){
		updateFrame(instance.x,instance.y,instance.graphics.command.w,instance.graphics.command.h);
	}
	// ドラッグ中のオブジェクトが関連付け済みである場合、関連付けされているプレゼンテーションテキストも移動させる
	if(instance.__relation != "" && instance.__relation != undefined){
		// 関連付けされているプゼンテーションテキストを特定する
		for(var i=0; i<stage.children.length; i++){
			var object = stage.children[i];
			if(object.__parent == dragedID){
				object = relocateCenter(object, instance);
				break;
			}
		}
	}
	stage.update();
	onResizing = true;
}

/********************************************************
 * オブジェクトのサイズ変更処理
 ********************************************************/
// ＜サイズ変更＞ドラッグの終了処理
function stopResizeDrag(eventObject) {
	var instance = eventObject.target;
	instance.removeEventListener("pressmove", resizeDrag);
	instance.removeEventListener("pressup", stopResizeDrag);
	onResizing = false;
}


// ＜削除＞削除対象の選択
function selectDelete(eventObject){
	var instance = eventObject.target;
	var width = parseInt(instance.graphics.command.w);
	var height = parseInt(instance.graphics.command.h);

	if(instance.__deleteSelected == null || instance.__deleteSelected == false){
		instance.__deleteSelected = true;
		var checkImage = new createjs.Bitmap(webroot + 'img/ico_check.png');
		checkImage.x = instance.x + width - (checkImage.image.width / 2);
		checkImage.y = instance.y - (checkImage.image.height / 2);
		checkImage.__relationID = instance.id;
		stage.addChild(checkImage);
		deleteArray.push(instance.id);
	}else{
		instance.__deleteSelected = false;
		var array = stage.children;
		for(i=0; i<array.length; i++){
			if(array[i].__relationID == instance.id){
				stage.removeChildAt(i);
			}
		}
		for(i=0; i<deleteArray.length; i++){
			if(deleteArray[i] == instance.id){
				deleteArray.splice(i,1);
			}
		}
	}
	stage.update();
	instance.removeEventListener("pressup", selectDelete);
}

/********************************************************
 * JSON処理
 ********************************************************/
//データベースにポスター情報を保存
function singlesaveJson(object){
	id = object.__id;
	x = object.x;
	y = object.y;
	w = parseInt(object.graphics.command.w);
	h = parseInt(object.graphics.command.h);
	color = rgbToHex(object.color);
	relation = object.__relation;
	date = object.__date;
	poster = {'id': id,'x': x, 'y': y, 'width': w, 'height': h, 'color': color, 'presentation_id': relation, 'date': date, 'event_id': selectedEventID};
	$.ajax({
		type: "POST",
		cache : false,
		url: "posters/singlesavesql",
		data: { "data": poster },
		success: function(response){
			// 直前に更新されたプライマリーキー(id)をオブジェクトにセットする
			if(response != ""){
				object.__id = response;
			}
		}
	});
}
	
	//データベースから、ポスター情報を削除
	function deleteJson(object){
		$.ajax({
			type: "POST",
			cache : false,
			url: "posters/deletesql",
			data: { "id": object.NextId },
			success: function(msg){}
		});
	}
/* JSON 書き込み処理 */
/*
function saveJson(){
	var objectArray = [];
    var child;              //stage.children[i]格納
	var id, x, y, w, h,title,presenter,abstract,color,relation;
	for(i=0; i<stage.children.length; i++) {
        child = stage.children[i];
		if(child.__type=="selectSquare" || child.__type=="text"){
			continue;
		}
		id= child.NextId;
        x = child.x;
        y = child.y;
        w = parseInt(child.graphics.command.w);
        h = parseInt(child.graphics.command.h);
        color = rgbToHex(child.color);
		relation = child.__relation;
        if (child.__title != undefined) {
            title = child.__title;
        } else {
            title = "";
        }
        if (child.__presenter != undefined) {
            presenter = child.__presenter;
        } else {
            presenter = "";
        }
        if (child.__abstract != undefined) {
            abstract = child.__abstract;
        } else {
            abstract = "";
        }
        array = {'id': id,'x': x, 'y': y, 'width': w, 'height': h, 'color': color, 'title': title, 'presenter': presenter, 'abstract': abstract, 'presentation_id': relation};
        if (child.__type != "selectSquare") {
            objectArray.push(array);
        }
	}

	// キャンバスのサイズ情報を、配列の先頭に格納
	// TODO: データベースに格納するだけなので、この情報はいりません。
	objectArray.unshift({'mapHeight': canvasHeight});
	objectArray.unshift({'mapWidth': canvasWidth});

	// 既に会場図が設置してあれば、画像情報を配列の先頭に格納
	var searchImageFileName = "backGround.png";
	// TODO: データベースに格納するだけなので、この情報はいりません。
	//if($(canvasElement).css("background-image").indexOf(searchImageFileName) != -1){
	//	objectArray.unshift({'filename':searchImageFileName});
	//}

	$.ajax({
		type: "POST",
		cache : false,
		url: "posters/savesql",
		data: { "data": objectArray },
		success: function(msg){
		}
	});

	// TODO: 必要なくなったので削除してください
	// 第一リリース用にPosMAppに合わせた形式のJSONファイルをもう一つ生成します
	var demoArray = {};
	demoArray['toppage_img'] = webroot+"img/toppage_pbla.png";
	var demoPosmappBgArray = []
	demoPosmappBgArray.push("http://tkb-tsss.sakura.ne.jp/release1/img/" + searchImageFileName);
	demoArray['posmapp_bg'] = demoPosmappBgArray;
	demoArray['STATIC_WIDTH'] = canvasWidth;
	demoArray['STATIC_HEIGHT'] = canvasHeight;

	// 各種（position, author, presen, poster） 配列を作成
	var demoPositionArray = [];
	var demoAuthorArray = [];
	var demoPresenArray = [];
	var demoPosterArray = [];
	for(var i=0; i<stage.children.length; i++) {
		// objectPresenId, objectBlongs, objectFirst, についてはデモ時点で入力フォームがないため自動的に付与しています
		child = stage.children[i];
		if(child.__type=="selectSquare" || child.__type=="text"){
		continue;
		}
		objectId = child.id;
		objectX = child.x;
		objectY = child.y;
		objectWidth = child.graphics.command.w;
		objectHeight = child.graphics.command.h;
		//objectWidth = child.width;
		//objectHeight = child.height;
		objectPresenId = "A1-"+(i+1);
		objectPresenter = child.__presenter;
		objectBelongs = "筑波大";
		objectTitle = child.__title;
		objectAbstract = child.__abstract;

		demoPositionData = {'id': objectId,'x': objectX, 'y': objectY, 'width': objectWidth, 'height': objectHeight, 'direction': 'sideways'};
		demoAuthorData = {'presenid': objectPresenId, 'name': objectPresenter, 'belongs': objectBelongs, 'first': 1};
		demoPresenData = {'presenid': objectPresenId, 'title': objectTitle, 'abstract': objectAbstract, 'bookmark': 0};
		demoPosterData = {'presenid': objectPresenId, 'posterid': objectId, 'star': 1, 'date': 1};

		if (child.__type != "selectSquare") {
			demoPositionArray.push(demoPositionData);
			demoAuthorArray.push(demoAuthorData);
			demoPresenArray.push(demoPresenData);
			demoPosterArray.push(demoPosterData);
		}
	}
	demoArray['position'] = demoPositionArray;
	demoArray['author'] = demoAuthorArray;
	demoArray['presen'] = demoPresenArray;
	demoArray['poster'] = demoPosterArray;
//	$.ajax({
//		type: "POST",
//		url: "php/save_demo.php",
//		data: { "data": demoArray },
//		dataType: "json",
//		success: function(msg){
//			alert(msg);
//		}
//	});
}
*/

/* JSON 読み込み処理 */
/*
function loadJson(){
	alert(webroot);
	var objectList;
	stage.removeAllChildren();
	$.getJSON("json/data.json?"+$.now(), function(json){
		// 背景画像を読み込む（この方法だとjsonの並びが変わったときに動作しない）
		if(json[0].filename!=null){
			var file = json[0];
			json.splice(0, 1);
			backGroundFileName=file.filename.toString();
//			$(canvasElement).css("background-image","url("+webroot+"img/dot.png), url("+webroot+"img/"+file.filename.toString()+"?"+$.now()+")");
//			$(canvasElement).css("background-repeat","repeat, no-repeat");
			$(canvasPosterElementArray[selectedDay-1]).css("background-image","url("+webroot+"img/dot.png), url("+webroot+"img/"+file.filename.toString()+"?"+$.now()+")");
			$(canvasPosterElementArray[selectedDay-1]).css("background-repeat","repeat, no-repeat");

		}

		// マップのサイズを読み込む（この方法だとjsonの並びが変わったときに動作しない）
		if(json[0].mapWidth != null && json[1].mapHeight != null){
			// グローバル変数を更新
			canvasWidth = json[0].mapWidth;
			canvasHeight = json[1].mapHeight;
			// マップのサイズ変更
			$('#posterCanvas'+(selectedDay-1)).get( 0 ).width = canvasWidth;
			$('#posterCanvas'+(selectedDay-1)).get( 0 ).height = canvasHeight;
			// 生成できるオブジェクトサイズ上限値の更新
			$('[name^="objectWidth"]').attr("max",canvasWidth/gridSize);
			$('[name^="objectHeight"]').attr("max",canvasHeight/gridSize);
			// マップのサイズ変更フォームの値の更新
			$('input[name="mapWidth"]').val(canvasWidth);
			$('input[name="mapHeight"]').val(canvasHeight);
			json.splice(0, 2);
		}

		objectList=json;

		for(i=0; i<json.length; i++){
			var instance = createObject(parseInt(objectList[i].x), parseInt(objectList[i].y), parseInt(objectList[i].width), parseInt(objectList[i].height), objectList[i].color);
			instance.cursor = "pointer";
			instance.__deleteSelected = false;
			instance.__title = objectList[i].title;
            instance.__presenter = objectList[i].presenter;
            instance.__abstract = objectList[i].abstract;
			stage.addChild(instance);
			instance.addEventListener("mousedown", startDrag);
		}
		stage.update();
	})
	.error(function(jqXHR, textStatus, errorThrown) {
		alert("JSONファイルがありません");
	});
}
*/

/********************************************************
 * モードを切り替え処理
 ********************************************************/
function changeMode(){
	selectMode = $('[name^="selectMode"]').val();
	if(selectMode == "delete"){
		cancelFrame();
		changeDisabledState(true, false, false);
	}else if(selectMode == "create"){
		// 削除対象に付与したチェック画像を削除する
		var array = stage.children;
		for(i=array.length-1; i>=0; i--){
			if(array[i].__relationID){
				stage.removeChildAt(i);
				stage.update();
			}else{
				array[i].__deleteSelected = false;
			}
		}
		deleteArray = [];
		changeDisabledState(false, false, true);
	}
 }

// メニューの使用可能状態を変更させる関数
/*
 * changeState: 生成フォーム, 編集フォーム, 各種ボタンの状態
 * selectState: 生成・削除を選択するセレクトボックスの状態
 * deleteState: 削除ボタンの状態
 *
 */
function changeDisabledState(chageState, selectState, deleteState){
	// 生成フォーム
	$('[name^="objectWidth"]').prop("disabled", chageState);
	$('[name^="objectHeight"]').prop("disabled", chageState);
	$('[name^="objectCreateColor"]').prop("disabled", chageState);
	$('[name^="createButton"]').prop("disabled", chageState);
	// 保存・読み込みボタン
	$('[name^="saveButton"]').prop("disabled", chageState);
	$('[name^="loadButton"]').prop("disabled", chageState);
	// 会場設置ボタン
	$('[name^="selectFile"]').prop("disabled", chageState);
	// 削除ボタン
	$('[name^="deleteButton"]').prop("disabled", deleteState);
	// 編集フォーム
	$('[name="title"]').prop("disabled", chageState);
	$('[name="presenter"]').prop("disabled", chageState);
	$('[name="abstract"]').prop("disabled", chageState);
	$('[name="objectEditColor"]').prop("disabled", chageState);
	$('[name="inputForm"]').prop("disabled", chageState);
	// マップフォーム
	$('[name^="checkRatio"]').prop("disabled", chageState);
	$('[name^="mapWidth"]').prop("disabled", chageState);
	$('[name^="mapHeight"]').prop("disabled", chageState);
	$('[name^="resizeMap"]').prop("disabled", chageState);
	// モード選択
	$('[name^="selectMode"] + div.btn-group > button').prop("disabled", selectState);
}

function deleteObject(){
	if(deleteArray.length == 0){
		alert("削除する対象のオブジェクトが選択されていません");
	}else{
		/* 確認ダイアログの表示 */
		$( "#dialogDeleteConfirm" ).dialog({
			resizable: false,
			height:140,
			modal: true,
			buttons: {
			"Yes": function() {
				// 削除対象のオブジェクトと付与したチェック画像を削除する
				var childArray = stage.children;
				for(i=deleteArray.length - 1; i>=0; i--){
					for(j=childArray.length - 1; j>=0; j--){
						if(childArray[j].id == deleteArray[i] || childArray[j].__relationID == deleteArray[i]){
							if(childArray[j].id == deleteArray[i]){
								var targetID = childArray[j].id;
								
								// __parentにtargetIDを持つテキストオブジェクトを削除する
								for(var k=0; k<stage.children.length; k++){
									if(stage.children[k].__parent == targetID){
										stage.removeChildAt(k);
									}
								}
								
								//解除するポスター情報を、データベースから削除
								deleteJson(childArray[j]);
							}
							stage.removeChildAt(j);
							stage.update();
						}
					}
					deleteArray.splice(i,1);
				}
				$( this ).dialog( "close" );
			},
			"No": function() {
				$( this ).dialog( "close" );
			}
			}
		});
	}
}

/********************************************************
 * 会場図設置処理
 ********************************************************/
/* ボタンと連携してtype="file"のボタンが作動するようにする */
function selectFile(){
	$('#backGroundImage').trigger('click');
}

/* ajaxによるファイルのアップロード処理 */
function fileUpLoad(event_str){
	var fd = new FormData($('#upLoadForm').get(0));
	$.ajax({
		url: "php/fileUploader.php",
		type: "POST",
		data: fd,
		processData: false,
		contentType: false,
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			alert( "ERROR" );
			alert( textStatus );
			alert( errorThrown );
		}
	})
	.done(function(msg) {
		alert(msg);
		// データベースにポスター背景がセットされていることを格納する
		savePosterBg();
		backGroundFileName = selectedEventStr+"_"+selectedDay+".png";
		// アップロードした画像を背景として挿入する
		for(var i=0; i<canvasPosterElementArray.length; i++){
			$(canvasPosterElementArray[selectedDay-1]).css("background-image","url("+webroot+"img/dot.png), url("+webroot+"img/bg/"+backGroundFileName.toString()+"?"+$.now()+")");
			$(canvasPosterElementArray[selectedDay-1]).css("background-repeat","repeat, no-repeat");
		}
	});
}

// イベントにポスター背景図がセットされていることをデータベースに格納する
function savePosterBg(){
	$.ajax({
		url: "events/setPosterBackground",
		type: "POST",
		data: { 'selectedEventID' : selectedEventID },
		dataType: "text",
		success : function(response){
			//alert(response);
		},
		error: function(){
			alert('Error');
		}
	});
}


/********************************************************
 * 編集フォームのパラメータ格納
 ********************************************************/
function setParam(){
	var title = $('[name^="title"]').val();
	var presenter = $('[name^="presenter"]').val();
	var abstract = $('[name^="abstract"]').val();
	var color = $('select[name="objectEditColor"] + .btn-group > .selectpicker > span:first-child').css('background-color');
	selectedObject.__title=title;
	selectedObject.__presenter=presenter;
	selectedObject.__abstract=abstract;

	var targetChild = getChildById(selectedObject.id);
	targetChild.color = color; // 独自で準備した変数に格納したのみ
	targetChild.graphics._fill.style = color; //  ここに格納しなければ色は反映されない
	stage.update();
}

/********************************************************
 * セレクトボックスで色が変更されたときの処理
 ********************************************************/
// 生成フォームのカラーセレクトの色が変化したときの処理
function changeSelectColor(){
	var color = $('[name^="objectCreateColor"]').val();
	$('select[name="objectCreateColor"] + .btn-group > .selectpicker > span:first-child').css("background-color", color);
}

// エリアオブジェクトの編集フォームのカラーセレクトの色が変化したときの処理
function changeSelectColorAreaObject(){
	var color = $('[name^="areaColor"]').val();
	$('select[name="areaColor"] + .btn-group > .selectpicker > span:first-child').css("background-color", color);
}

// 編集フォームのカラーセレクトの色が変化したときの処理
function editSelectColor(){
	var color = $('[name^="objectEditColor"]').val();
	$('select[name="objectEditColor"] + .btn-group > .selectpicker > span:first-child').css("background-color", color);
}

/********************************************************
 * マップのサイズ変更処理
 ********************************************************/
// widthの値入力後、フォーカスが外れたときの処理
function onBlurMapWidth(){
	var checkMapRatio = $('input[name="checkRatio"]').prop('checked');
	var mapWidth = $('input[name="mapWidth"]').val();
	// 比率を保持するにチェックされている場合
	if(checkMapRatio){
		var keepRatioHeight = Math.round(mapWidth * canvasRatio);
		$('input[name="mapHeight"]').val(keepRatioHeight);
	}
}

// heightの値入力後、フォーカスが外れたときの処理
function onBlurMapHeight(){
	var checkMapRatio = $('input[name="checkRatio"]').prop('checked');
	var mapHeight = $('input[name="mapHeight"]').val();
	// 比率を保持するにチェックされている場合
	if(checkMapRatio){
		var keepRatioWidth = Math.round(mapHeight / canvasRatio);
		$('input[name="mapWidth"]').val(keepRatioWidth);
	}
}

// マップサイズ変更ボタンが押されたときの処理
function resizeMap(){
	var mapWidth = $('input[name^="mapWidth"]').val();
	var mapHeight = $('input[name^="mapHeight"]').val();

	// マップの最小値より小さい場合
	if(mapWidth < mapMinWidth || mapHeight < mapMinHeight ){
		alert("The min map size is width："+mapMinWidth+"px，height："+mapMinHeight+"px");
		return false;
	}
	// マップの最大値より大きい場合
	if(mapWidth > mapMaxWidth || mapHeight > mapMaxHeight ){
		alert("The max map size is width："+mapMaxWidth+"px，height："+mapMaxHeight+"px");
		return false;
	}
	// グリッドサイズに合わせるため四捨五入
	mapWidth = Math.round(mapWidth / gridSize) * gridSize;
	mapHeight = Math.round(mapHeight / gridSize) * gridSize;

	// マップを小さくする際に、入りきらないオブジェクトがある場合
	if(existMapOverObject(mapWidth, mapHeight)){
		alert("Some object are out of map");
		return false;
	}
	// フォームにグリッド単位にそろえた値を入力
	$('input[name^="mapWidth"]').val(mapWidth);
	$('input[name^="mapHeight"]').val(mapHeight);
	// グローバル変数の更新
	canvasWidth = mapWidth;
	canvasHeight = mapHeight;
	// マップサイズの変更を反映
	$('#posterCanvas'+selectedDay).get( 0 ).width = canvasWidth;
	$('#posterCanvas'+selectedDay).get( 0 ).height = canvasHeight;
	$('#posterCanvas'+selectedDay).css('width', canvasWidth).css('height', canvasHeight);
	$('#areaCanvas'+selectedDay).get( 0 ).width = canvasWidth;
	$('#areaCanvas'+selectedDay).get( 0 ).height = canvasHeight;
	$('#areaCanvas'+selectedDay).css('width', canvasWidth).css('height', canvasHeight);
	
	$('input[name="objectWidth"]').attr("max",canvasWidth/gridSize);
	$('input[name="objectHeight"]').attr("max",canvasHeight/gridSize);
	stage.update();
	stageAreaArray[selectedDay-1].update();
	stage.update();
	
	// eachdaysテーブルに格納
	eachday = {'event_id': parseInt(selectedEventID), 'date': selectedDay, 'canvas_width': canvasWidth, 'canvas_height': canvasHeight};
	$.ajax({
		type: "POST",
		cache : false,
		url: "eachdays/modifyCanvasSize",
		data: { "data": eachday },
		success: function(response){
			// 格納成功
		}
	});
}

// マップを小さくする際に、飛び出してしまうオブジェクトがあるかチェックします
function existMapOverObject(mapWidth, mapHeight){
	// 飛び出しをしているか否か
	var outFlg = false;
	// オブジェクトの右下座標
	var objectRightBottom = {"x": 0, "y": 0};
	// ポスターステージにて検証
	for(var i=0; i<stage.children.length; i++){
		if(stage.children[i].__type != "selectSquare"){
			// オブジェクトの右下座標がマップのサイズより上回っている場合
			objectRightBottom = {"x": stage.children[i].x + stage.children[i].width, "y": stage.children[i].y + stage.children[i].height };
			if(objectRightBottom.x > mapWidth || objectRightBottom.y > mapHeight){
				outFlg = true;
			}
		}
	}
	
	// エリアステージの取得
	var areaStage = stageAreaArray[selectedDay - 1];
	// エリアステージにて検証
	for(var i=0; i<areaStage.children.length; i++){
		if(areaStage.children[i].__type != "selectSquare"){
			// オブジェクトの右下座標がマップのサイズより上回っている場合
			objectRightBottom = {"x": areaStage.children[i].x + areaStage.children[i].width, "y": areaStage.children[i].y + areaStage.children[i].height };
			if(objectRightBottom.x > mapWidth || objectRightBottom.y > mapHeight){
				outFlg = true;
			}
		}
	}
	
	return outFlg;
}

/********************************************************
 * 汎用処理
 ********************************************************/
// ステージチルドレンの中から特定のidをもつオブジェクトを取得する
function getChildById(id){
	for(var i=0; i<stage.children.length; i++){
		if(id == stage.children[i].id){
			return stage.children[i];
		}
	}
	return null;
}

// インプットテキストに数字が入力されたかどうかチェックする
function checkTextIsNumeric(inputElement){
	// 数字以外は入力できないようにする
	inputElement.value=inputElement.value.replace(/[^0-9a-z]+/i,'');
}

// RGB to HEX
function rgbToHex(color) {
	// すでにHEX(#123456)の形式をとっている場合は、返す
    if (color.substr(0, 1) === '#') {
        return color;
    }
    var digits = /(.*?)rgb\((\d+), (\d+), (\d+)\)/.exec(color);

    var red = parseInt(digits[2]);
    var green = parseInt(digits[3]);
    var blue = parseInt(digits[4]);

    var rgb = blue | (green << 8) | (red << 16);
	// ex. rgb(6, 58, 94) => #63a5e のように最初の0が表示されず6文字の場合、0を埋める
    if((digits[1] + '#' + rgb.toString(16)).length == 6){
        return digits[1] + '#0' + rgb.toString(16);
    }
    return digits[1] + '#' + rgb.toString(16);
}

/********************************************************
 * サイドメニュータブ切り替え時の処理
 ********************************************************/
$(function(){
	// Presentationタブでのプレゼンテーションリストにドラッグ処理を追加
	$('li[draggable="true"]').on('dragstart', onDragStart);

	// Presentationタブがクリックされたとき、ポスターの移動・サイズ変更はできないようにする
	$('#tab #presentationTab').click(function(){
		cancelFrame();
		cancelFrameAreaObject();
		// 直前のモードが生成または削除である場合（Poster Editタブからの遷移の場合）
		if(selectMode == 'create' || selectMode == 'delete'){
			// 現在のモードを記憶しておく
			formerMode = selectMode;
		}else{
			// エリアタブからの遷移の場合
			stage = stagePosterArray[selectedDay-1];
		}
		selectMode = 'presentation';
		// ポスターキャンバスを手前にする
		exchangeCanvasLayerOrder($('.posterCanvas'), $('.areaCanvas'));
	});
	// Areaタブがクリックされたとき、ポスターの移動・サイズ変更はできないようにする
	$('#tab #areaTab').click(function(){
		cancelFrame();
		cancelFrameAreaObject();
		// 直前のモードが生成または削除である場合（Poster Editタブからの遷移の場合）
		if(selectMode == 'create' || selectMode == 'delete'){
			// 現在のモードを記憶しておく
			formerMode = selectMode;
		}
		// Poster EditタブまたはPresentationタブからの遷移の場合
		if(selectMode == 'create' || selectMode == 'delete' || selectMode == 'presentation'){
			// ステージの情報を保存する
			stagePosterArray[selectedDay - 1] = stage;
		}
		// モードを変更
		selectMode = 'area';
		// エリアキャンバスを手前にする
		exchangeCanvasLayerOrder($('.areaCanvas'), $('.posterCanvas'));
		// ステージの切り替え
		stage = stageAreaArray[selectedDay - 1];
	});
	// PosterEditタブがクリックされたとき、ポスターの移動・サイズ変更ができるようにする
	$('#tab #posterEditTab').click(function(){
		// 直前のモードが生成または削除でない場合（PresentationタブまたはAreaタブからの遷移の場合）
		if(selectMode !== 'create' && selectMode !== 'delete'){
			// 切り替え時に保存した直前のモードに戻す
			selectMode = formerMode;
		}
		// ポスターキャンバスを手前にする
		exchangeCanvasLayerOrder($('.posterCanvas'), $('.areaCanvas'));
		// ステージの切り替え
		stage = stagePosterArray[selectedDay - 1];
	});
});

// ポスターキャンバスとエリアキャンバスの前後切り替え処理
function exchangeCanvasLayerOrder(front_ele, back_ele){
	// レイヤーを前に
	$(front_ele).css('z-index', 2).css('opacity', 0.7);
	// レイヤーを後ろに
	$(back_ele).css('z-index', 1).css('opacity', 0.3);
}


/********************************************************
 * プレゼン情報との関連付けに関する処理
 ********************************************************/
// ドラッグが開始したときの処理
function onDragStart(e){
	selectedPresentationID = this.id;
	selectedPresentationNum = $(e.target).attr('data-num');
	e.originalEvent.dataTransfer.setData('text', this.id);
}

// ドラッグ中のときの処理
function onDragOver(e){
	e.preventDefault();
}

// ドロップしたときの処理
function onDrop(e){
	// スクロール量を取得（ドロップした位置がウィンドウからの相対位置となってしまうため）
	var scrollX = $(window).scrollLeft();
	var scrollY = $(window).scrollTop();
	//console.log('スクロール量: ('+scrollX+', '+scrollY+')');
	// キャンバスパネル要素の位置を取得（キャンバスは絶対位置配置のため）
	var tabPaneX = $('#canvasArea #tcCanvas'+selectedDay).offset().left;
	var tabPaneY = $('#canvasArea #tcCanvas'+selectedDay).offset().top;
	//console.log('タブパネルの位置: ('+tabPaneX+', '+tabPaneY+')');
	// キャンバス上の位置を取得
	var onCanvasX = e.originalEvent.clientX - tabPaneX - e.target.offsetLeft + scrollX;
	var onCanvasY = e.originalEvent.clientY - tabPaneY - e.target.offsetTop + scrollY;
	//console.log('キャンバスの位置: ('+e.target.offsetLeft+', '+e.target.offsetTop+')');
	//console.log('ドロップした位置: ('+e.originalEvent.clientX+', '+e.originalEvent.clientY+')');
	//console.log('キャンバス上の位置: ('+onCanvasX+', '+onCanvasY+')');
	// ステージ上に存在するオブジェクトを特定する
	for(var i=0; i<stage.children.length; i++){
		var target = stage.children[i];
		// ポスターオブジェクトであるかどうか判定（選択中の四角, テキストオブジェクトは無視する）
		if(target.__type != 'selectSquare' && target.__type != 'text'){
			//console.log((i+1)+'番目のオブジェクト: ('+target.x+', '+target.y+')');
			// オブジェクトの内側かどうか判定
			if(target.x <= onCanvasX && onCanvasX <= target.x + target.width && target.y <= onCanvasY && onCanvasY <= target.y + target.height){
				// すでにそのプレゼンテーションが別のポスターに関連済みであった場合
				if($('.presentationlist li#'+selectedPresentationID).hasClass('related') == true){
					// もともと関連済みであったポスターのIDを取得
					var formerRelatedPosterID = $('.presentationlist li#'+selectedPresentationID).attr('data-relation');
					// 複数日にまたがる可能性があるためポスターのステージすべてをチェックします
					for(var k=0; k<stagePosterArray.length; k++){
						// チェックを行うステージ
						var targetStage = stagePosterArray[k];
						
						for(var j=0; j<targetStage.children.length; j++){
							var object = targetStage.children[j];
							// もともと関連済みであったポスターを特定
							if(object.id == formerRelatedPosterID){
								// ポスターを元の状態に戻す
								object.graphics._fill.style = defaultColor;
								object.color = defaultColor;
								object.__relation = '';
								// もともと関連済みであったポスターも変更部分をデータベースに反映させる
								// もともと関連済みであったポスターが選択中のタブとは限らない
								singlesaveJson(object);
							}
							// もともと関連済みであったポスターを親とするテキストオブジェクトを特定
							if(object.__parent == formerRelatedPosterID){
								// テキストオブジェクトを削除する
								targetStage.removeChildAt(j);
							}
							targetStage.update();
						}
					}
				}

				// すでにそのポスターがプレゼンテーションと関連済みであった場合
				if(target.__relation != undefined && target.__relation != '' && target.__relation != '0'){
					// もともと関連済みであったプレゼンテーションを元の状態に戻す
					$('.presentationlist li#'+target.__relation).removeClass('related').attr('data-relation', null);
				}

				target.graphics._fill.style = relatedColor;
				target.color = relatedColor;
				// ポスターオブジェクトに関連付けされたプレゼンテーションIDを付与
				target.__relation = selectedPresentationID;

				var text = new createjs.Text(selectedPresentationNum, '20px Meiryo', '#fff');
				// テキストを中央に配置
				text = relocateCenter(text, target);
				// テキストオブジェクトにオブジェクトタイプを付与
				text.__type = 'text';
				// テキストオブジェクトに親要素であるポスターオブジェクトのIDを付与（ポスターが移動した際に、テキストもついていくようにするため）
				text.__parent = target.id;

				stage.addChild(target, text);
				singlesaveJson(target);
				stage.update();

				// 選択中のプレゼンテーションの要素を関連付けされた状態にする
				$('.presentationlist li#'+selectedPresentationID).addClass('related').attr('data-relation',target.id);

				break;
			}
		}
	}
	// 選択中のプレゼンテーションID・ナンバーを初期化する
	selectedPresentationID = 0;
	selectedPresentationNum = '';
}

// テキストオブジェクトをポスターオブジェクトの中央に配置する処理
function relocateCenter(textObj, posterObj){
	// テキストオブジェクトの横幅と高さを取得
	var textWidth = textObj.getMeasuredWidth();
	var textHeight = textObj.getMeasuredHeight();
	// テキストをポスターオブジェクトの中央に配置
	textObj.x = posterObj.x + (posterObj.width - textWidth)/2;
	textObj.y = posterObj.y + (posterObj.height - textHeight)/2;
	return textObj;
}

/********************************************************
 * ページャーの切り替え処理
 ********************************************************/
$(function(){
	// 現在のページ番号
	var current_page = 1;
	// 必要ページ数
	var pages = $('.pager li').length - 2; // prev, next の2つ分減らす必要がある

	$(".pager li a").click(function(e){
		// クリックしたボタンが使用不可またはすでにアクディブである場合、何もしない
		if($(this).parent().hasClass('disabled') || $(this).parent().hasClass('active')){
			return false;
		}

		// クリックされたターゲットページ番号を取得する
		var target_page = $(this).attr('data-target');

		/* 押されたボタン別に行う処理 */
		// prevボタンの場合
		if(target_page == 'prev'){
			// ターゲットページ番号を現在のページ番号-1にする
			target_page = parseInt(current_page) - 1;

		// nextボタンの場合
		}else if(target_page == 'next'){
			// ターゲットページ番号を現在のページ番号+1にする
			target_page = parseInt(current_page) + 1;

		} // end if

		// アクティブになっているページャーを元に戻す
		$('.pager li.active').removeClass('active');
		// クリックされたページャーをアクティブにする
		$('.pager li a[data-target='+target_page+']').parent().addClass('active');
		// いったん、すべてのページ内容を非表示にする
		$('#tcPresentation .page').each(function(index, element) {
			$(this).stop().fadeOut(300, 'linear').addClass('disno');
		});
		// ターゲットページを表示させる
		$("#tcPresentation #page"+("0"+target_page).slice(-2)).stop().removeClass('disno').fadeIn(300, 'linear');

		/* 6ページ目以降をページャの真ん中にくるように調整する処理 */
		if(pages > 5){
			// いったん、すべてのページャを非表示にする
			$('.pager li').each(function(index, element) {
				// prevボタン, nextボタンである場合は何もしない
				if(!$(this).hasClass('prev') && !$(this).hasClass('next')){
					$(this).addClass('disno');
				}
			});
			// ページャ内での位置
			var pos_pager = -2; // ターゲットページが真ん中であれば、左には２つのページャ, 右には２つのページャが存在するため開始ページはターゲットページ番号マイナス２
			if(target_page == 1){
				// 1ページ目の場合、1番左に表示する
				pos_pager = 0;
			}else if(target_page == 2){
				// 2ページ目の場合、左から2番目に表示する
				pos_pager = -1;
			}else if(target_page == pages-1){
				// 最終ページから2ページ目の場合、右から2番目に表示する
				pos_pager = -3;
			}else if(target_page == pages){
				// 最終ページの場合、1番右に表示する
				pos_pager = -4;
			}

			// 5つのページャーを表示する
			for(var i=0; i<5; i++){
				$('.pager li a[data-target='+(parseInt(target_page)+(pos_pager+i))+']').parent().removeClass('disno');
			}
		}

		// 現在のページ番号を更新
		current_page = target_page;

		/* 押されたボタンに関わらず必ず行う処理 */
		// いったん、すべてのボタンを利用可能状態にする
		$('.pager li.disabled').removeClass('disabled');
		// ページ番号が1であれば、prevボタンを使用不可にする
		if(current_page == 1){
			$('.pager .prev').addClass('disabled');
		}
		// ページ番号が必要ページ数であれば、nextボタンを使用不可にする
		if(current_page == pages){
			$('.pager .next').addClass('disabled');
		}
	});
});


/********************************************************
 * ポスターキャンバスタブに関する処理
 ********************************************************/
$(function(){
	// ポスターキャンバスタブ（日数選択）をクリックしたときの処理
	$('#canvasArea .nav li > a').click(function(){
		// 選択される前の日数を一時的に記憶しておく
		previousDay = selectedDay;
		// 選択されたタブの日数を最新のものに更新する
		selectedDay = $(this).attr('data-days');
		// 背景画像アップロードフォームのバリューを更新する
		$('[name^="EventDate"]').attr('value', selectedDay);
		// 選択中の日数のタブをクリックしたときは処理をおこなわない
		if(previousDay != selectedDay){
			// 選択された日数をセッションに記録する(ajax)
			$.ajax({
				type: "POST",
				cache : false,
				url: "posters/saveSelectedDay",
				data: { "day": selectedDay },
				success: function(msg){}
			});

			// 現在までのstageの状態をstage配列に格納する
			stagePosterArray[previousDay-1] = stage;

			// 選択中のcanvas要素を切り替える
			canvasElement = canvasPosterElementArray[selectedDay-1];
			// 選択中のstageを切り替える
			stage = stagePosterArray[selectedDay-1];
		}

		// 選択したタブのDisuseが有効である場合
		if(disuses[selectedDay-1]){
			// メニューを利用不可状態に
			changeDisabledState(true, true, true);
			formerMode = selectMode;
			selectMode = "disuse";
		}else{
			// メニューを利用可能状態に
			changeDisabledState(false, false, true);
			formerMode = selectMode;
			selectMode = "create";
		}
		
		// マップ編集フォームの値をキャンバスのサイズに更新する
		$('input[name="mapWidth"]').attr('value', canvasElement.width);
		$('input[name="mapHeight"]').attr('value', canvasElement.height);
	});
});


/********************************************************
 * Disuseチェックボックスに関する処理
 ********************************************************/
function onChangeDisuse(obj, day){
	var checkState = $(obj).prop("checked");
	// チェックを入れたときの処理
	if(checkState){
		// canvas上にオブジェクトが１つでもあればアラートを表示
		if(stage.children.length > 0){
			alert("Remove all posters to disuse the layout.");
			// チェックを外した状態に戻す
			$(obj).prop({'checked': false});
		}else{
			// canvas上にオブジェクトが何もない場合、ータベースに選択中のイベントIDと日数を格納
			var insert_data = { 'event_id': selectedEventID, 'date': selectedDay };
			$.ajax({
				type: "POST",
				cache : false,
				url: "disuses/add",
				data: { 'data': insert_data },
				success: function(msg){}
			});
			// キャンバスへの生成や削除の操作を不可能にする ここではDisuseというモードがあるという設定
			formerMode = selectMode;
			selectMode = "disuse";
			changeDisabledState(true, true, true);
			// canvasの背景色を変更する
			changeBackgroundColorCanvas($(obj).parent('p').next('canvas'), true);
			// disuse配列の更新
			disuses[day-1] = true;
		}

	// チェックを外したときの処理
	}else{
		// データベースに選択中のイベントIDと日数があれば削除
		var delete_data = { 'event_id': selectedEventID, 'date': selectedDay };
		$.ajax({
			type: "POST",
			cache : false,
			url: "disuses/delete",
			data: { 'data': delete_data },
			success: function(msg){}
		});
		// モードの状態を元に戻す
		selectMode = formerMode;
		changeDisabledState(false, false, true);
		// canvasの背景色をもとに戻す
		changeBackgroundColorCanvas($(obj).parent('p').next('canvas'), false);
		// disuse配列の更新
		disuses[day-1] = false;
	}
}

// Disuseにチェックがはいっている状態のときにキャンバスの背景色を変更する処理
function changeBackgroundColorCanvas(canvas, disuseState){
	if(disuseState){
		// チェックがはいっている状態のとき
		$(canvas).addClass('disuse');
	}else{
		// チェックがはいっていない状態のとき
		$(canvas).removeClass('disuse');
	}
}


/********************************************************
 * エリアオブジェクトに関する処理
 ********************************************************/
// エリアオブジェクト配置処理（現状利用していない）
function setAreaObject(){
	var areaWidth = $('[name^="areaWidth"]').val() * gridSize;
	var areaHeight = $('[name^="areaHeight"]').val() * gridSize;
	var areaPositionX = $('[name^="areaPositionX"]').val() * gridSize;
	var areaPositionY = $('[name^="areaPositionY"]').val() * gridSize;
	var areaColor = $('[name^="areaColor"]').val();
	var areaName = $('[name^="areaName"]').val();
	if( areaWidth == '' || areaHeight == '' ){
		alert("something not input");
	}else if( areaWidth <= 0 || areaHeight <= 0 ){
		alert("you must input bigger than 0");
	}else if( areaWidth > canvasWidth || areaHeight > canvasHeight ){
		alert("you must input smaller than width"+canvasWidth/gridSize+"grid, height"+canvasHeight/gridSize+"grid");
	}else{
		var object = createAreaObject(areaPositionX, areaPositionY, areaWidth , areaHeight , areaColor);
		object.name = areaName;
		stage.addChild(object);
		stage.update();
		// object.addEventListener("mousedown", startDragAreaObject);
        var tempevent=object;
        tempevent.target=object;
		// エリアオブジェクトをクリックしたときと同様の処理をとる
        clickAreaObject(object);
	}
}

// エリアオブジェクト生成処理
function createAreaObject(x, y, w, h, color) {
	var object = new createjs.Shape();
	object.x = x;
	object.y = y;
	object.width = w;
	object.height = h;
	object.color = color;
	object.__id = '';
	object.graphics.beginFill(color);

	object.graphics.drawRect(initX, initY, w, h);
	
	object.cursor = "pointer";
	
	// エリアオブジェクトをデータベースへ更新
	//saveAreaObject(object);
	return object;
}

// エリアオブジェクトを選択
function clickAreaObject(eventObject){
	selectFlagAreaObject = false;
	// 既に選択されているエリアオブジェクトをクリックした場合
	if(eventObject.target == selectedAreaObject){
		return;
	}
	// 選択されているエリアオブジェクト以外をクリックした場合
	if(selectedAreaObject != null){
		selectFlagAreaObject = true;
		cancelFrameAreaObject();
		selectFlagAreaObject = false;
	}
	selectedAreaObject = eventObject.target;
	selectAreaObject();
	selectedAreaObject.array = selectSquareArray;
	inputEditFormAreaObject();
}

// エリアオブジェクトの選択
function selectAreaObject(){
	// 編集フォームを利用可能に
	$('[name="areaWidth"]').prop("disabled", false);
	$('[name="areaHeight"]').prop("disabled", false);
	$('[name="areaPositionX"]').prop("disabled", false);
	$('[name="areaPositionY"]').prop("disabled", false);
	$('[name="areaColor"]').prop("disabled", false).val(defaultColor);
	$('select[name="areaColor"] + .btn-group > .selectpicker > span:first-child').css("background-color", defaultColor);
	$('[name^="areaColor"] + div.btn-group > button').prop('disabled', false);
	$('[name="areaName"]').prop("disabled", false);
	$('[name="updateAreaButton"]').prop("disabled", false);
	$('[name="deleteAreaButton"]').prop("disabled", false);
	
	var x = selectedAreaObject.x;
	var y = selectedAreaObject.y;
	var w = parseInt(selectedAreaObject.graphics.command.w);
	var h = parseInt(selectedAreaObject.graphics.command.h);

	// 選択中のエリアオブジェクトの8方向に四角形を設置する
	for(var i=0; i<3; i++){
		for(var j=0; j<3; j++){
			// 真ん中である場合は設置をしない
			if (!(i == 1 && j == 1)) {	
				var sq = new createjs.Shape();
				sq.graphics.beginFill(blackColor);
				sq.graphics.drawRect(x - 5 + j * w / 2, y - 5 + i * h / 2, 10, 10);
				sq.graphics.beginFill(whiteColor);
				sq.graphics.drawRect(x - 4 + j * w / 2, y - 4 + i * h / 2, 8, 8);
				// フレーム毎に番号を振る
				sq.__number = i * 3 + j;
				sq.addEventListener("stagemousemove", FrameMouseOverAreaObject(sq));
				sq.addEventListener("mousedown", FrameDragStartAreaObject);
				stage.addChild(sq);
				// セレクトスクエア配列に格納
				selectSquareArray.push(sq);
				sq.__type="selectSquare";
			}
		}
	}
	stage.update();
}

// データベースにエリアオブジェクトを保存
function saveAreaObject(object){
	id = object.__id;
	x = object.x;
	y = object.y;
	w = parseInt(object.graphics.command.w);
	h = parseInt(object.graphics.command.h);
	color = rgbToHex(object.color);
	name = object.name;
	
	area = {'id': id, 'x': x, 'y': y, 'width': w, 'height': h, 'color': color, 'date': selectedDay, 'event_id': selectedEventID, 'name': name};
	
	$.ajax({
		type: "POST",
		cache : false,
		url: "areas/update",
		data: { "data": area },
		success: function(response){
			// 直前に更新されたプライマリーキー(id)をオブジェクトにセットする
			if(response != ""){
				object.__id = response;
			}
		}
	});
}

// エリアオブジェクトの削除
function deleteAreaObject(){
	if(selectedAreaObject !== null){
		// 選択中のオブジェクトを特定
		for(var i=0; i<stage.children.length; i++){
			if(stage.children[i].id == selectedAreaObject.id){
				// 削除対象オブジェクト
				var target = stage.children[i];
				// エリアオブジェクトの色登場回数配列をカウントダウン
				for(var j=0; j<areaObjectColorArray.length; j++){
					if(selectedAreaObject.color == areaObjectColorArray[j]){
						areaObjectColorCountArray[j]--;
						break;
					}
				}
				// 削除を実行
				stage.removeChildAt(i);
				cancelFrameAreaObject();
				stage.update();
				
				// データベースのエリアオブジェクト削除を反映
				$.ajax({
					type: "POST",
					cache : false,
					url: "areas/delete",
					data: { "data": target.__id },
					success: function(response){
						// データベースのエリアオブジェクト削除完了
					}
				});
			}
		}
	}
}

// エリアオブジェクトを選択されている状態から外す
function cancelFrameAreaObject(){
	// console.log("cancelFrameAreaObject");
	if(selectFlagAreaObject == true) {
		// 編集フォームの値を空に
        $('input[name="areaWidth"]').val("");
		$('input[name="areaHeight"]').val("");
		$('input[name="areaPositionX"]').val("");
        $('input[name="areaPositionY"]').val("");
		$('input[name="areaName"]').val("");
		
		if(selectSquareArray.length != 0) {
			for (var i=0; i<8; i++) {
				selectSquareArray[i].graphics.clear();
				stage.removeChild(selectSquareArray[i]);
			}
			stage.update();
			selectedAreaObject.array = null;
			selectSquareArray = [];
		}
		selectedAreaObject = null;
		// 編集フォームを利用不可に
		$('[name="areaWidth"]').prop("disabled", true);
		$('[name="areaHeight"]').prop("disabled", true);
		$('[name="areaPositionX"]').prop("disabled", true);
		$('[name="areaPositionY"]').prop("disabled", true);
		$('[name="areaColor"]').prop("disabled", true);
		$('[name^="areaColor"]').val(defaultColor);
		$('select[name="areaColor"] + .btn-group > .selectpicker > span:first-child').css("background-color", defaultColor);
		$('[name^="areaColor"] + div.btn-group > button').prop('disabled', true);
		$('[name="areaName"]').prop("disabled", true);
		$('[name="updateAreaButton"]').prop("disabled", true);
		$('[name="deleteAreaButton"]').prop("disabled", true);
	}else{
		selectFlagAreaObject = true;
	}
}


/********************************************************
 * エリアオブジェクトのマウスイベントに関する処理
 ********************************************************/
// エリアオブジェクト ドラッグの開始処理
function startDragAreaObject(eventObject) {	
	selectFlagAreaObject = false;
	var instance = eventObject.target;
	// キャンバスを基準にクリックした位置
	pointerX = eventObject.stageX;
	pointerY = eventObject.stageY;
	
	// オブジェクトを基準にクリックした位置
	onPointX = eventObject.stageX - instance.x;
	onPointY = eventObject.stageY - instance.y;

	if(!resizeFlg){
		// 移動
		instance.addEventListener("pressmove", dragAreaObject);
		instance.addEventListener("pressup", stopDragAreaObject);
		previewscalex = instance.x;
		previewscaley = instance.y;
	}else if(resizeFlg){
		// サイズ変更
		instance.addEventListener("pressmove", resizeDragAreaObject);
		instance.addEventListener("pressup", stopResizeDragAreaObject);
	}
}

// エリアオブジェクト ＜移動＞ドラッグ中の処理
function dragAreaObject(eventObject) {
	var instance = eventObject.target;
	var dragedID = instance.id;
	var width = parseInt(instance.graphics.command.w);
	var height = parseInt(instance.graphics.command.h);
	var leftTop = { x: instance.x, y: instance.y };
	var rightTop = { x: instance.x + width , y: instance.y };
	var rightBottom = { x:instance.x + width , y: instance.y + height };
	var leftBottom = { x: instance.x , y: instance.y + height };

	// ポインタ位置が画面外だった時の分岐
	if((onPointX <= eventObject.stageX)&&(eventObject.stageX <= canvasWidth - width + onPointX)
	&&(onPointY <= eventObject.stageY)&&(eventObject.stageY <= canvasHeight -height + onPointY)){
		// in canvas
		instance.x = Math.round((eventObject.stageX - onPointX)/gridSize)*gridSize;
		instance.y = Math.round((eventObject.stageY - onPointY)/gridSize)*gridSize;
		if(instance.array!=null){
			updateFrameAreaObject(instance.x,instance.y,width,height);
		}
	}else if((onPointX <= eventObject.stageX)&&(eventObject.stageX <= canvasWidth - width + onPointX)
	&&(0 <= eventObject.stageY)&&(eventObject.stageY < onPointY)){
		// over top
		instance.x = Math.round((eventObject.stageX - onPointX)/gridSize)*gridSize;
		if(instance.array!=null){
			updateFrameAreaObject(instance.x,instance.y,width,height);
		}
	}else if((canvasWidth - width + onPointX < eventObject.stageX)&&(eventObject.stageX <= canvasWidth)
	&&(onPointY <= eventObject.stageY)&&(eventObject.stageY <= canvasHeight -height + onPointY)){
		// over right
		instance.y = Math.round((eventObject.stageY - onPointY)/gridSize)*gridSize;
		if(instance.array!=null){
			updateFrameAreaObject(instance.x,instance.y,width,height);
		}
	}else if((onPointX <= eventObject.stageX)&&(eventObject.stageX <= canvasWidth - width + onPointX)
	&&(canvasHeight - height + onPointY < eventObject.stageY)&&(eventObject.stageY <= canvasHeight)){
		// over bottom
		instance.x = Math.round((eventObject.stageX - onPointX)/gridSize)*gridSize;
		if(instance.array!=null){
			updateFrameAreaObject(instance.x,instance.y,width,height);
		}
	}else if((0 <= eventObject.stageX)&&(eventObject.stageX <= onPointX)
	&&(onPointY <= eventObject.stageY)&&(eventObject.stageY <= canvasHeight -height + onPointY)){
		// over left
		instance.y = Math.round((eventObject.stageY - onPointY)/gridSize)*gridSize;
		if(instance.array!=null){
			updateFrameAreaObject(instance.x,instance.y,width,height);
		}
	}
	stage.update();
}

// エリアオブジェクト ＜移動＞ドラッグの終了処理
function stopDragAreaObject(eventObject) {
	var instance = eventObject.target;
	instance.removeEventListener("pressmove", dragAreaObject);
	instance.removeEventListener("pressup", stopDragAreaObject);
	// マウスダウンした位置からマウスアップした位置までの移動距離（３平方の定理）
	var dragDistant = Math.sqrt(Math.pow(eventObject.stageX-pointerX,2) + Math.pow(eventObject.stageY-pointerY,2));
	// 限りなくクリックに近いドラッグの場合
	if(dragDistant < 3){
		clickAreaObject(eventObject);
	}else{
		// ドラッグとみなされた場合
		
		var i = stage.children.length - 1;
		// x座標が異なる または y座標が異なる または セレクトスクエア である場合
		while(instance.x != stage.children[i].x || instance.y != stage.children[i].y  || stage.children[i].__type =="selectSquare"){
			// 何のための処理なのかわからない
			i=i-1;
		}
		
		for(var k=stage.children.length-1; k>=0; k--){
			// iのオブジェクトまたはセレクトスクエアの場合は処理はおこなわない
			if(k==i || stage.children[k].__type =="selectSquare"){
				continue;
			}
			// 他のオブジェクトと重なった場合は移動する前に戻す
			if(instance.x > stage.children[k].x - (instance.width)
			&& instance.x < stage.children[k].x + (stage.children[k].width)
			&& instance.y > stage.children[k].y - (instance.height)
			&& instance.y < stage.children[k].y + (stage.children[k].height)){
				instance.x = previewscalex;
				instance.y = previewscaley;
				// セレクトスクエアの更新
				if(instance.array != null){
					updateFrameAreaObject(instance.x, instance.y, instance.width, instance.height);
				}
				break;
			}
		}
		stage.update();
		// 移動終了後、保存
		saveAreaObject(instance);
		
		// エリアオブジェクトを選択している場合
		if(selectedAreaObject !== null){
			// 選択中のエリアオブジェクト情報を編集フォームに反映
			inputEditFormAreaObject();
		}
	}
}

// エリアオブジェクト ＜サイズ変更＞ドラック中の処理
function resizeDragAreaObject(eventObject) {
	var changeFrame = stage.children[nowwhite].__number;
	var instance = eventObject.target;
	var dragedID = instance.id;
	// 0:左上		1:中央上		2:右上
	// 3:左中央	4:-			5:右中央
	// 6:左下		7:中央下		8:右下
	// 図形の右部分
	if(changeFrame == 2 || changeFrame == 5 || changeFrame==8){
		instance.graphics.command.w = Math.ceil((eventObject.stageX - instance.x)/gridSize)*gridSize;
		instance.width = Math.ceil((eventObject.stageX - instance.x)/gridSize)*gridSize;
	}
	// 図形の下部分
	if(changeFrame == 6 || changeFrame == 7 || changeFrame==8){
		instance.graphics.command.h =  Math.ceil((eventObject.stageY - instance.y)/gridSize)*gridSize;
		instance.height =  Math.ceil((eventObject.stageY - instance.y)/gridSize)*gridSize;
	}
	// 図形の左部分
	if(changeFrame == 0 || changeFrame==3 || changeFrame==6){
		instance.x = Math.round((eventObject.stageX - onPointX)/gridSize)*gridSize;
		instance.graphics.command.w = nowright-instance.x;
		instance.width = nowright-instance.x;
	}
	// 図形の上部分
	if(changeFrame == 0 || changeFrame==1 || changeFrame==2){
		instance.y = Math.round((eventObject.stageY - onPointY)/gridSize)*gridSize;
		instance.graphics.command.h = nowbottom-instance.y;
		instance.height = nowbottom-instance.y;
	}
	//　x座標は右端より左
	if(instance.x>=nowright){
		instance.x=nowright-gridSize;
	}
	//　y座標は下端より上
	if(instance.y>=nowbottom){
		instance.y=nowbottom-gridSize;
	}
	// 横幅がグリッドサイズより小さいとき
	if(instance.graphics.command.w < gridSize){
		instance.graphics.command.w = gridSize;
		instance.width = gridSize;
	}
	// 高さがグリッドサイズより小さいとき
	if(instance.graphics.command.h < gridSize){
		instance.graphics.command.h = gridSize;
		instance.height = gridSize;
	}
    if(instance.array!=null){
        updateFrameAreaObject(instance.x,instance.y,instance.graphics.command.w,instance.graphics.command.h);
    }
	// ドラッグ中のオブジェクトが関連付け済みである場合、関連付けされているプレゼンテーションテキストも移動させる
	if(instance.__relation != "" && instance.__relation != undefined){
		// 関連付けされているプゼンテーションテキストを特定する
		for(var i=0; i<stage.children.length; i++){
			var object = stage.children[i];
			if(object.__parent == dragedID){
				object = relocateCenter(object, instance);
				break;
			}
		}
	}

	stage.update();
	onResizing = true;
}

// エリアオブジェクト ＜サイズ変更＞ドラッグの終了処理
function stopResizeDragAreaObject(eventObject) {
	var instance = eventObject.target;
	instance.removeEventListener("pressmove", resizeDragAreaObject);
	instance.removeEventListener("pressup", stopResizeDragAreaObject);
	onResizing = false;
}


/********************************************************
 * エリアオブジェクトのセレクトスクエアに関する処理
 ********************************************************/
// エリアオブジェクト セレクトスクエア マウスオーバー処理
function FrameMouseOverAreaObject(sq){
	resizeFlg = false;
	//　フレームによってマウスカーソルを変える
	if(sq.__number== 0 || sq.__number==8){
		sq.cursor = "se-resize";
	}
	if(sq.__number== 2 || sq.__number==6){
		sq.cursor = "sw-resize";
	}
	if(sq.__number== 1 || sq.__number==7){
		sq.cursor = "s-resize";
	}
	if(sq.__number== 3 || sq.__number==5){
		sq.cursor = "e-resize";
	}
}

// エリアオブジェクト セレクトスクエア ドラッグの開始処理
function FrameDragStartAreaObject(eventObject){
	selectFlag=false;
	var instance = selectedAreaObject;
	// オブジェクト上のどの位置をクリックしたか
	pointerX= eventObject.stageX;
	pointerY= eventObject.stageY;
	onPointX = eventObject.stageX - instance.x;
	onPointY = eventObject.stageY - instance.y;
	
	eventObject.target.addEventListener("pressmove", FrameDragAreaObject);
	eventObject.target.addEventListener("pressup", FrameDragOverAreaObject);
	
	// ドラック開始時のオブジェクトの大きさ取得
	previewbigx = instance.graphics.command.w;
	previewbigy = instance.graphics.command.h;
	// ドラック開始時のオブジェクトの座標取得
	previewscalex = instance.x;
	previewscaley = instance.y;
	// ドラック開始時のオブジェクトの右端と下端の座標取得
	nowright = instance.x+previewbigx;
	nowbottom = instance.y+previewbigy;
	var nowdistance = 1000;
	// 最も近いフレームを、今回サイズ変更するフレームとみなす
	for(var k=stage.children.length-1; k>=0; k--){
		if(stage.children[k].__type =="selectSquare"){
			if(nowdistance > Math.abs(Math.ceil((stage.children[k].graphics.command.x)/gridSize)*gridSize-Math.ceil((eventObject.stageX)/gridSize)*gridSize)+Math.abs(Math.ceil((stage.children[k].graphics.command.y)/gridSize)*gridSize-Math.ceil((eventObject.stageY)/gridSize)*gridSize)){
				nowdistance =Math.abs(Math.ceil((stage.children[k].graphics.command.x)/gridSize)*gridSize-Math.ceil((eventObject.stageX)/gridSize)*gridSize)+Math.abs(Math.ceil((stage.children[k].graphics.command.y)/gridSize)*gridSize-Math.ceil((eventObject.stageY)/gridSize)*gridSize);
				nowwhite = k;
			}
		}
	}
}

// エリアオブジェクト セレクトスクエア ドラッグ中処理
function FrameDragAreaObject(eventObject){
	var eb = eventObject;
	eb.target = selectedAreaObject;
	resizeDrag(eb);
	var instance = eventObject.target;
}

// エリアオブジェクト セレクトスクエア ドラッグ終了処理
function FrameDragOverAreaObject(eventObject){
	var instance = eventObject.target;
	instance.removeEventListener("pressmove", resizeDragAreaObject);
	instance.removeEventListener("pressup", stopResizeDragAreaObject);
	var x = Math.ceil(eventObject.stageX/gridSize) * gridSize;
	var y = Math.ceil(eventObject.stageY/gridSize) * gridSize;
	var instance = eventObject.target;
	instance.graphics.command.w = Math.ceil((eventObject.stageX - instance.x)/gridSize)*gridSize;
	instance.graphics.command.h =  Math.ceil((eventObject.stageY - instance.y)/gridSize)*gridSize;
	instance.width = Math.ceil((eventObject.stageX - instance.x)/gridSize)*gridSize;
	instance.height =  Math.ceil((eventObject.stageY - instance.y)/gridSize)*gridSize;

	var i = stage.children.length-1;
	while(selectedAreaObject != stage.children[i]){
		i=i-1;
	}
	for(var k=stage.children.length-1; k>=0; k--){
		if(k==i || stage.children[k].__type == "selectSquare"){
			continue;
		}
		//他のオブジェクトと重なった場合は、位置、大きさ共に元に戻す
		if(stage.children[i].x > stage.children[k].x - (stage.children[i].width) 
		&& stage.children[i].x < stage.children[k].x + (stage.children[k].width) 
		&& stage.children[i].y > stage.children[k].y- (stage.children[i].height) 
		&& stage.children[i].y < stage.children[k].y + (stage.children[k].height)){
			stage.children[i].graphics.command.w = previewbigx;
			stage.children[i].graphics.command.h = previewbigy;
			stage.children[i].x = previewscalex;
			stage.children[i].y = previewscaley;
			previewscalex = instance.x;
			previewscaley = instance.y;
			updateFrameAreaObject(stage.children[i].x, stage.children[i].y, stage.children[i].graphics.command.w, stage.children[i].graphics.command.h);
			stage.update();
			break;
		}
	}
	onResizing = false;
	//サイズ変更終了後、保存
	saveAreaObject(stage.children[i]);
}


/********************************************************
 * ドラッグアンドドロップによるエリアオブジェクト生成に関する処理
 ********************************************************/
// エリアオブジェクト生成 ドラッグ開始
function startDragCreateAreaObject(e){
	
	// スクロール量を取得（ドロップした位置がウィンドウからの相対位置となってしまうため）
	var scrollX = $(window).scrollLeft();
	var scrollY = $(window).scrollTop();
	//console.log('スクロール量: ('+scrollX+', '+scrollY+')');
	// キャンバスパネル要素の位置を取得（キャンバスは絶対位置配置のため）
	var tabPaneX = $('#canvasArea #tcCanvas'+selectedDay).offset().left;
	var tabPaneY = $('#canvasArea #tcCanvas'+selectedDay).offset().top;
	//console.log('タブパネルの位置: ('+tabPaneX+', '+tabPaneY+')');
	// キャンバス上の位置を取得
	var onCanvasX = e.clientX - tabPaneX - e.target.offsetLeft + scrollX;
	var onCanvasY = e.clientY - tabPaneY - e.target.offsetTop + scrollY;
	//console.log('キャンバスの位置: ('+e.target.offsetLeft+', '+e.target.offsetTop+')');
	//console.log('クリックした位置: ('+e.clientX+', '+e.clientY+')');
	//console.log('キャンバス上の位置: ('+onCanvasX+', '+onCanvasY+')');
	
	// エリアオブジェクト生成開始位置
	areaObjectX = Math.floor(onCanvasX / gridSize)*gridSize;
	areaObjectY = Math.floor(onCanvasY / gridSize)*gridSize;
	areaObjectWidth = areaObjectInitWidth;
	areaObjectHeight = areaObjectInitHeight;
	//console.log('エリアオブジェクト生成開始位置: ('+areaObjectX+', '+areaObjectY+')');
	
	// 他のエリアオブジェクトとの重なりチェック
	var isOverlapped = false;
	for(var i=0; i<stage.children.length; i++){
		// セレクトスクエアは除く
		if(stage.children[i].__type !== 'selectSquare'){
			// 他のエリアオブジェクトと重なっている場合
			if(areaObjectX >= stage.children[i].x
			&& areaObjectX <= stage.children[i].x + stage.children[i].width
			&& areaObjectY >= stage.children[i].y
			&& areaObjectY <= stage.children[i].y + stage.children[i].height){
				isOverlapped = true;
			}
		}
	}
	
	// 移動またはサイズ変更をしようとしていなければ（ドラッグ開始位置が他のオブジェクトと重なっていない場合）
	if(!isOverlapped){
		// エリアオブジェクト生成フラグを真に
		createFlagAreaObject = true;
		
		// 色の選定（まだ利用していない色があればその色を、一通り利用していれば回数の少ない色を）
		var colorCountMin = 999;
		for(var i=0; i<areaObjectColorArray.length; i++){
			// 最小値より登場回数の少ない色がある場合
			if(colorCountMin > areaObjectColorCountArray[i]){
				// 最小値を更新
				colorCountMin = areaObjectColorCountArray[i];
				// カラー番号を格納
				areaObjectColorNum = i;
			}
		}
		
		// エリアオブジェクトの生成
		areaObjectColor = areaObjectColorArray[areaObjectColorNum];
		areaObject = createAreaObject(areaObjectX, areaObjectY, areaObjectWidth , areaObjectHeight , areaObjectColor);
		stage.addChild(areaObject);
		stage.update();
		areaObject.addEventListener("mousedown", startDragAreaObject);
		var tempevent = areaObject;
		tempevent.target = areaObject;
		// 選択状態にする
		clickAreaObject(areaObject);
	}
}

// エリアオブジェクト生成 ドラッグ中の処理
function draggingCreateAreaObject(e){
	// ドラッグ中でなくても処理は実行されているため、エリアオブジェクト生成中の時のみ以下の処理をおこなう（＝ドラッグ中と判断する）
	if(createFlagAreaObject){
		// ドラッグ中のキャンバス上の座標を取得
		
		// スクロール量を取得（ドロップした位置がウィンドウからの相対位置となってしまうため）
		var scrollX = $(window).scrollLeft();
		var scrollY = $(window).scrollTop();
		//console.log('スクロール量: ('+scrollX+', '+scrollY+')');
		// キャンバスパネル要素の位置を取得（キャンバスは絶対位置配置のため）
		var tabPaneX = $('#canvasArea #tcCanvas'+selectedDay).offset().left;
		var tabPaneY = $('#canvasArea #tcCanvas'+selectedDay).offset().top;
		//console.log('タブパネルの位置: ('+tabPaneX+', '+tabPaneY+')');
		// キャンバス上の位置を取得
		var onCanvasX = e.clientX - tabPaneX - e.target.offsetLeft + scrollX;
		var onCanvasY = e.clientY - tabPaneY - e.target.offsetTop + scrollY;
		//console.log('キャンバスの位置: ('+e.target.offsetLeft+', '+e.target.offsetTop+')');
		//console.log('クリックした位置: ('+e.clientX+', '+e.clientY+')');
		//console.log('キャンバス上の位置: ('+onCanvasX+', '+onCanvasY+')');
		
		// グリッドサイズに合わせる
		var onCanvasXFitGrid = Math.floor(onCanvasX / gridSize)*gridSize;
		var onCanvasYFitGrid = Math.floor(onCanvasY / gridSize)*gridSize;
		
		// エリアオブジェクト生成開始位置からの距離から横幅・高さを求める
		areaObjectWidth = onCanvasXFitGrid - areaObjectX;
		areaObjectHeight = onCanvasYFitGrid - areaObjectY;
		
		// 基本的に左上から右下にしかエリアオブジェクトは生成できない（横幅・高さをマイナスに設定できない）
		if(areaObjectWidth < 0){
			areaObjectWidth = gridSize;
		}
		if(areaObjectHeight < 0){
			areaObjectHeight = gridSize;
		}
		
		// オブジェクトの横幅・高さを更新
		areaObject.graphics.command.w = areaObjectWidth;
		areaObject.width = areaObjectWidth;
		areaObject.graphics.command.h = areaObjectHeight;
		areaObject.height = areaObjectHeight;
		// セレクトスクエアの更新
		updateFrame(areaObject.x, areaObject.y, areaObject.width, areaObject.height);
		
		stage.update();
		
	}
}

// エリアオブジェクト生成 ドラッグ終了処理
function stopDragCreateAreaObject(e){
	// エリアオブジェクト生成中の時のみ以下の処理をおこなう（＝ドロップと判断する）
	if(createFlagAreaObject){
		// エリアオブジェクト生成フラグを偽に
		createFlagAreaObject = false;
		
		// 他のオブジェクトと重なっているかチェック
		var isOverlapped = false;
		// 生成中のオブジェクトの中心座標
		var centerX = areaObject.x + (areaObject.width/2);
		var centerY = areaObject.y + (areaObject.height/2);
		// 当たり判定
		for(var i=0; i<stage.children.length; i++){
			// 生成中のオブジェクトやセレクトスクエアは除く
			if(stage.children[i].id !== areaObject.id && stage.children[i].__type !== 'selectSquare'){
				// 当たり判定
				var isOverlappedHorizontal = false;
				var isOverlappedVertical = false;
				// 対象エリアオブジェクトの中心座標
				var targetX = stage.children[i].x + (stage.children[i].width/2);
				var targetY = stage.children[i].y + (stage.children[i].height/2);
				
				// 横について（2つのオブジェクトのX座標の距離より、2つのオブジェクトの横幅/2を足した距離の方が大きければ横方向で衝突している）
				if(Math.abs(centerX - targetX) < (areaObject.width/2 + stage.children[i].width/2)){
					isOverlappedHorizontal = true;
				}
				// 縦について（2つのオブジェクトのY座標の距離より、2つのオブジェクトの高さ/2を足した距離の方が大きければ縦方向で衝突している）
				if(Math.abs(centerY - targetY) < (areaObject.height/2 + stage.children[i].height/2)){
					isOverlappedVertical = true;
				}
				// 横方向についても縦方向についても衝突していれば当たり判定がつく
				if(isOverlappedHorizontal && isOverlappedVertical){
					isOverlapped = true;
					break;
				}
			}
		}
		
		// ドラッグ距離を求める（三平方の定理）
		var dragDistance = Math.abs(Math.sqrt(Math.pow(areaObject.width,2) + Math.pow(areaObject.height,2)));
		// 閾値より小さい場合や、他のエリアオブジェクトと重なっている場合はエリアオブジェクトとして認めず、削除する
		if(dragDistance < areaObjectThreshold || isOverlapped){
			// 削除
			stage.removeChild(areaObject);
			cancelFrameAreaObject();
			stage.update();
		}else{
			// 正常にエリアオブジェクトが生成完了
			// エリアオブジェクトの情報を編集フォームに反映
			inputEditFormAreaObject();
			// エリアオブジェクトの色登場回数配列のカウントアップ
			areaObjectColorCountArray[areaObjectColorNum]++;
			// データベースへ保存
			saveAreaObject(areaObject);
		}
	}
}

// ドラッグ中のセレクトスクエアの再描画
function updateFrameAreaObject(x,y,w,h) {
	// 8方向のセレクトスクエアを更新する
	for (var i=0, p=0; i<3; i++) {
		for (var j=0; j<3; j++) {
			// 真ん中である場合は処理を除く
			if (!(i == 1 && j == 1)) {
				selectSquareArray[p].graphics.clear();
				selectSquareArray[p].graphics.beginFill(blackColor);
				selectSquareArray[p].graphics.drawRect(x - 5 + j * w / 2, y - 5 + i * h / 2, 10, 10);
				selectSquareArray[p].graphics.beginFill(whiteColor);
				selectSquareArray[p].graphics.drawRect(x - 4 + j * w / 2, y - 4 + i * h / 2, 8, 8);
				p++;
			}
		}
	}
}


// 選択されたエリアオブジェクトが持つデータを編集フォームに反映する
function inputEditFormAreaObject(){
	$('input[name="areaWidth"]').val(parseInt(selectedAreaObject.width) / gridSize);
	$('input[name="areaHeight"]').val(parseInt(selectedAreaObject.height) / gridSize);
	$('input[name="areaPositionX"]').val(selectedAreaObject.x / gridSize);
	$('input[name="areaPositionY"]').val(selectedAreaObject.y / gridSize);
	$('select[name="areaColor"]').val(selectedAreaObject.color);
	$('select[name="areaColor"] + .btn-group > .selectpicker > span:first-child').css("background-color", selectedAreaObject.color);
	$('input[name="areaName"]').val(selectedAreaObject.name);
}

// 編集フォームからの更新処理
function updateAreaObject(){
	// フォーム内の各項目の値を取得
	var valAreaWidth = $('input[name="areaWidth"]').val() * gridSize;
	var valAreaHeight = $('input[name="areaHeight"]').val() * gridSize;
	var valAreaPositionX = $('input[name="areaPositionX"]').val() * gridSize;
	var valAreaPositionY = $('input[name="areaPositionY"]').val() * gridSize;
	var valAreaColor = $('select[name="areaColor"]').val();
	var valAreaName = $('input[name="areaName"]').val();
	
	// 変更前の色を記憶
	var previousAreaColor = selectedAreaObject.color;
	
	// 更新しようとしているエリアオブジェクトの中心座標
	var centerX = valAreaPositionX + (valAreaWidth/2);
	var centerY = valAreaPositionY + (valAreaHeight/2);
	
	// その他のエリアオブジェクトと重なっていないかチェック
	var isOverlapped = false;
	var errMsg = 'This area object is overlapped.';
	for(var i=0; i<stage.children.length; i++){
		// セレクトスクエアまたは選択中のオブジェクトは除く
		if(stage.children[i].__type !== "selectSquare" && stage.children[i].id !== selectedAreaObject.id){
			// 対象エリアオブジェクトの中心座標
			var targetX = stage.children[i].x + (stage.children[i].width/2);
			var targetY = stage.children[i].y + (stage.children[i].height/2);
			
			// 当たり判定
			// 横について（2つのオブジェクトのX座標の距離より、2つのオブジェクトの横幅/2を足した距離の方が大きければ横方向で衝突している）
			var isOverlappedHorizontal = false;
			if(Math.abs(centerX - targetX) < (valAreaWidth/2 + stage.children[i].width/2)){
				isOverlappedHorizontal = true;
			}
			// 縦について（2つのオブジェクトのY座標の距離より、2つのオブジェクトの高さ/2を足した距離の方が大きければ縦方向で衝突している）
			var isOverlappedVertical = false;
			if(Math.abs(centerY - targetY) < (valAreaHeight/2 + stage.children[i].height/2)){
				isOverlappedVertical = true;
			}
			// 横方向についても縦方向についても衝突していれば当たり判定がつく
			if(isOverlappedHorizontal && isOverlappedVertical){
				isOverlapped = true;
			}
		}
	}
	
	// 当たり判定がついていなければ更新する
	if(!isOverlapped){
		// エリアオブジェクトの更新
		selectedAreaObject.graphics.command.w = valAreaWidth;
		selectedAreaObject.width = valAreaWidth;
		selectedAreaObject.graphics.command.h = valAreaHeight;
		selectedAreaObject.height = valAreaHeight;
		selectedAreaObject.x = valAreaPositionX;
		selectedAreaObject.y = valAreaPositionY;
		selectedAreaObject.color = valAreaColor;
		selectedAreaObject.graphics._fill.style = valAreaColor; // ここに格納しなければ色は反映されない
		selectedAreaObject.name = valAreaName;
		
		// セレクトスクエアの更新
		updateFrame(selectedAreaObject.x, selectedAreaObject.y, selectedAreaObject.width, selectedAreaObject.height);
		
		// ステージのアップデート
		stage.update();
		
		// エリアオブジェクトの色登場回数の更新
		// 変更前の色の登場回数をカウントダウン
		for(var i=0; i<areaObjectColorArray.length; i++){
			if(previousAreaColor == areaObjectColorArray[i]){
				areaObjectColorCountArray[i]--;
				break;
			}
		}
		// 変更後の色の登場回数をカウントアップ
		for(var i=0; i<areaObjectColorArray.length; i++){
			if(valAreaColor == areaObjectColorArray[i]){
				areaObjectColorCountArray[i]++;
				break;
			}
		}
		
		// データベースへ保存
		saveAreaObject(selectedAreaObject);
		
	}else{
		// 衝突メッセージをアラートで表示
		alert(errMsg);
	}
}