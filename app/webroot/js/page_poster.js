/*-------------------------------------------------
 
  Poster javascript
 
 --------------------------------------------------*/
 
 /********************************************************
 *		グローバルナビゲーション カレント処理					*
 ********************************************************/
 $(function(){
	// ダッシュボードのPosterを選択状態にする
	$('#dashboard #gNav #gNavPos').addClass('current');
	//var a = <?php echo $a; ?>;
	//var data = <?php var_dump($data) ?>

			/*for(i=0; i<json.length; i++){
			var instance = createObject(parseInt(objectList[i].x), parseInt(objectList[i].y), parseInt(objectList[i].w), parseInt(objectList[i].h), objectList[i].color);
			instance.cursor = "pointer";
			instance.__deleteSelected = false;
			instance.__title = objectList[i].title;
            instance.__presenter = objectList[i].presenter;
            instance.__abstract = objectList[i].abstract;
			stage.addChild(instance);
			instance.addEventListener("mousedown", startDrag);
		}
		stage.update();*/
});
 
 /********************************************************
 *							変数定義										*
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
// 現在のモード
var selectMode = "create";
// 削除対象を記憶する配列
var deleteArray = [];
// サイズ変更を受け付ける領域のサイズ（１辺の長さ）
var resizeArea = 10;
// サイズ変更ができる状態であるかどうか
var resizeFlg = false;
// サイズ変更中であるかどうか
var onResizing = false;
// sprint1 デフォルトの色
var defaultColor = "#999999";
// 会場図画像ファイル名
var backGroundFileName = "";
// キャンバを基準にクリックした位置
var pointerX= 0;
var pointerY=0;
// オブジェクトを基準にクリックした位置
var onPointX = 0;
var onPointY =0;
// ?
var objectArray=[];
// 選択されているオブジェクト
var selectedObject;
// 選択されているオブジェクトがあるかどうか
var selectFlag=true;
// 選択状態でFrameをドラッグしているとき、どのFrameをドラックしているか
var nowwwhite;
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


/********************************************************
 *							読み込み時の処理							*
 ********************************************************/
$(function() {
	$( '#demoCanvas' ).get( 0 ).width = canvasWidth;
	$( '#demoCanvas' ).get( 0 ).height = canvasHeight;
	$('[name^="objectWidth"]').attr("max",canvasWidth/gridSize);
	$('[name^="objectHeight"]').attr("max",canvasHeight/gridSize);
	
	canvasElement = document.getElementById("demoCanvas");
	stage = new createjs.Stage(canvasElement);
	stage.enableMouseOver();
	stage.enableDOMEvents(true);
    document.getElementById("demoCanvas").addEventListener("click",cancelFrame);
});

/********************************************************
 *					ブラウザのリサイズ時の処理						*
 ********************************************************/
$(window).on('load resize', function(){
});


/********************************************************
 *	オブジェクトのリサイズ領域にマウスポインタがあるか検査	*
 ********************************************************/
function checkResize(x, y){
	if(selectMode == "create" && !onResizing){
		childArray = stage.children;
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
 *							オブジェクト処理							*
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
		var object = createObject(initX, initY, objectWidth , objectHeight , objectCreateColor);
		stage.addChild(object);
		stage.update();
		object.addEventListener("mousedown", startDrag);
        var tempevent=object;
        tempevent.target=object;
        click(object);
	}
}

// オブジェクト生成処理
function createObject(x, y, w, h, color) {
	var object = new createjs.Shape();
	object.x = x;
	object.y = y;
	object.width = w;
	object.height = h;
	object.color=color;
    object.__title = "";
    object.__presenter = "";
    object.__abstract = "";
	object.graphics.beginFill(color);

	var OUT;
	if(stage.children.length !=0){
		OUT:for(var ynow=0;ynow<=canvasHeight-h;ynow=ynow+gridSize){
			for(var xnow=0;xnow<=canvasWidth-w;xnow=xnow+gridSize){
				for(var k=stage.children.length-1;k>=0;k--){
					if(stage.children[k].__type == "selectSquare"){
						continue;
					}
					if(xnow > stage.children[k].x - w && xnow < stage.children[k].x + (stage.children[k].graphics.command.w) && ynow > stage.children[k].y- h && ynow < stage.children[k].y + (stage.children[k].graphics.command.h)){
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
	return object;
}

/********************************************************
 *							マウスイベント処理							*
 ********************************************************/
// ドラッグの開始処理
function startDrag(eventObject) {
    selectFlag=false;
	var instance = eventObject.target;
	// キャンバスを基準にクリックした位置
    pointerX= eventObject.stageX;
    pointerY=eventObject.stageY;
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
		if(instance.x > stage.children[k].x - (instance.graphics.command.w) && instance.x < stage.children[k].x + (stage.children[k].graphics.command.w) && instance.y > stage.children[k].y- (instance.graphics.command.h) && instance.y < stage.children[k].y + (stage.children[k].graphics.command.h)){
			instance.x =previewscalex;
			instance.y =previewscaley;
			if(instance.array!=null){
				updateFrame(instance.x,instance.y,instance.graphics.command.w,instance.graphics.command.h);
			}
			break;
		}
	}
	stage.update();
}
/********************************************************
 *						オブジェクトの選択処理						*
 ********************************************************/
// オブジェクトを選択
function click(eventObject){
	selectFlag=false;
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
	selectedObject=eventObject.target;
	select();
	selectedObject.array=objectArray;
	inputEditForm();
}

// ドロップ中の再描画
function updateFrame(x,y,w,h) {
	var white="#FFFFFF";
	var black="#000000";
	for (var i = 0, p = 0; i < 3; i++) {
		for (var j = 0; j < 3; j++) {
			if (!(i == 1 && j == 1)) {
				objectArray[p].graphics.clear();
				objectArray[p].graphics.beginFill(black);
				objectArray[p].graphics.drawRect(x - 5 + j * w / 2, y - 5 + i * h / 2, 10, 10);
				objectArray[p].graphics.beginFill(white);
				objectArray[p].graphics.drawRect(x - 4 + j * w / 2, y - 4 + i * h / 2, 8, 8);
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

	var white="#FFFFFF";
	var black="#000000";
	var x = selectedObject.x;
	var y = selectedObject.y;
	var w = parseInt(selectedObject.graphics.command.w);
	var h = parseInt(selectedObject.graphics.command.h);

	for(var i=0; i<3; i++){
		for(var j=0;j<3;j++){
			if (!(i == 1 && j == 1)) {
				var sq = new createjs.Shape();
				sq.graphics.beginFill(black);
				sq.graphics.drawRect(x - 5 + j * w / 2, y - 5 + i * h / 2, 10, 10);
				sq.graphics.beginFill(white);
				sq.graphics.drawRect(x - 4 + j * w / 2, y - 4 + i * h / 2, 8, 8);
				// フレーム毎に番号を振る
				sq.__number=i*3+j;
				sq.addEventListener("stagemousemove",FrameMouseOver(sq));
				sq.addEventListener("mousedown",FramDragStart);
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
                changeSelectObject(selectedObject, $('[name^="title"]').val(), $('[name^="presenter"]').val(), $('[name^="abstract"]').val(), formColor);  //　JSが先にselectedObjectとフォーム内容を消すので引数で渡しておく
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
function FramDragStart(eventObject){
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
	
	var i=stage.children.length-1;
	while(selectedObject!= stage.children[i]){
		i=i-1;
	}
	for(var k=stage.children.length-1;k>=0;k--){
		if(k==i || stage.children[k].__type =="selectSquare"){//sq.__type="selectSquare";
			continue;
		}
//他のオブジェクトと重なった場合は、位置、大きさ共に元に戻す
		if(stage.children[i].x > stage.children[k].x - (stage.children[i].graphics.command.w) && stage.children[i].x < stage.children[k].x + (stage.children[k].graphics.command.w) && stage.children[i].y > stage.children[k].y- (stage.children[i].graphics.command.h) && stage.children[i].y < stage.children[k].y + (stage.children[k].graphics.command.h)){
			stage.children[i].graphics.command.w =previewbigx;
			stage.children[i].graphics.command.h =previewbigy;
			stage.children[i].x =previewscalex;
			stage.children[i].y =previewscaley;
			previewscalex=instance.x;
		previewscaley=instance.y;
			updateFrame(stage.children[i].x,stage.children[i].y,stage.children[i].graphics.command.w,stage.children[i].graphics.command.h);
			stage.update();
			break;
		}
	}
	onResizing = false;
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
	// 0:左上		1:中央上		2:右上
	// 3:左中央	4:-			5:右中央
	// 6:左下		7:中央下		8:右下
	// 図形の右部分
	if(changeFrame == 2 || changeFrame == 5 || changeFrame==8){
		instance.graphics.command.w = Math.ceil((eventObject.stageX - instance.x)/gridSize)*gridSize;
	}
	// 図形の下部分
	if(changeFrame == 6 || changeFrame == 7 || changeFrame==8){
		instance.graphics.command.h =  Math.ceil((eventObject.stageY - instance.y)/gridSize)*gridSize;
	}
	// 図形の左部分
	if(changeFrame == 0 || changeFrame==3 || changeFrame==6){
		instance.x = Math.round((eventObject.stageX - onPointX)/gridSize)*gridSize;
		instance.graphics.command.w = nowright-instance.x;
	}
	// 図形の上部分
	if(changeFrame == 0 || changeFrame==1 || changeFrame==2){
		instance.y = Math.round((eventObject.stageY - onPointY)/gridSize)*gridSize;
		instance.graphics.command.h = nowbottom-instance.y;
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
	}
	// 高さがグリッドサイズより小さいとき
	if(instance.graphics.command.h < gridSize){
		instance.graphics.command.h = gridSize;
	}
    if(instance.array!=null){
        updateFrame(instance.x,instance.y,instance.graphics.command.w,instance.graphics.command.h);
    }
	stage.update();
	onResizing = true;
}

//　選択オブジェクトが変わったときの編集内容確認ダイアログ処理
function changeSelectObject(editObject, title, presenter, abstract, formColor){
    $( "#dialogEditConfirm" ).dialog({
        resizable: false,
        height:140,
        modal: true,
        buttons: {
            "確定": function() {
                // 編集フォームの内容を書き込む
                editObject.__title=title;
                editObject.__presenter=presenter;
                editObject.__abstract=abstract;
                editObject.color = formColor; // 独自で準備した変数に格納したのみ
                editObject.graphics._fill.style = formColor; // ここに格納しなければ色は反映されない
                stage.update();
                $( this ).dialog( "close" );
            },
            "キャンセル": function() {
                $( this ).dialog( "close" );
            }
        }
    });
}

/********************************************************
 *					オブジェクトのサイズ変更処理					*
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
		/* もう少しスマートな方法さがしています */
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
 *								JSON処理									*
 ********************************************************/
/* JSON 書き込み処理 */
function saveJson(){
	var objectArray = [];
    var child;              //stage.children[i]格納
	var id, x, y, w, h,title,presenter,abstract,color,relation;
	for(i=0; i<stage.children.length; i++) {
        child = stage.children[i];
		if(child.__type=="selectSquare" || child.__type=="text"){
			continue;
		}
		id= child.id;
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
	/*
	if($(canvasElement).css("background-image").indexOf(searchImageFileName) != -1){
		objectArray.unshift({'filename':searchImageFileName});
	}
	*/
	
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
	$.ajax({
		type: "POST",
		url: "php/save_demo.php",
		data: { "data": demoArray },
		dataType: "json",
		success: function(msg){
			alert(msg);
		}
	});
}

/* JSON 読み込み処理 */
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
			$(canvasElement).css("background-image","url("+webroot+"img/dot.png), url("+webroot+"img/"+file.filename.toString()+"?"+$.now()+")");
			$(canvasElement).css("background-repeat","repeat, no-repeat");
		}
		
		// マップのサイズを読み込む（この方法だとjsonの並びが変わったときに動作しない）
		if(json[0].mapWidth != null && json[1].mapHeight != null){
			// グローバル変数を更新
			canvasWidth = json[0].mapWidth;
			canvasHeight = json[1].mapHeight;
			// マップのサイズ変更
			$( '#demoCanvas' ).get( 0 ).width = canvasWidth;
			$( '#demoCanvas' ).get( 0 ).height = canvasHeight;
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
			var instance = createObject(parseInt(objectList[i].x), parseInt(objectList[i].y), parseInt(objectList[i].w), parseInt(objectList[i].h), objectList[i].color);
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

/********************************************************
 *						モードを切り替え処理							*
 ********************************************************/
function changeMode(){
	selectMode = $('[name^="selectMode"]').val();
	if(selectMode == "delete"){
		cancelFrame();
		// 生成フォームを利用不可に
		$('[name^="objectWidth"]').prop("disabled", true);
		$('[name^="objectHeight"]').prop("disabled", true);
		$('[name^="objectCreateColor"]').prop("disabled", true);
		$('[name^="createButton"]').prop("disabled", true);
		// JSON保存・読み込みボタンを利用不可に
		$('[name^="saveButton"]').prop("disabled", true);
		$('[name^="loadButton"]').prop("disabled", true);
		// 会場設置ボタンを利用不可に
		$('[name^="selectFile"]').prop("disabled", true);
		// 削除ボタンを利用可能に
		$('[name^="deleteButton"]').prop("disabled", false);
		// 編集フォームを利用不可に
		$('[name="title"]').prop("disabled", true);
		$('[name="presenter"]').prop("disabled", true);
		$('[name="abstract"]').prop("disabled", true);
		$('[name="objectEditColor"]').prop("disabled", true);
		$('[name="inputForm"]').prop("disabled", true);
		// マップフォームを利用不可に
		$('[name^="checkRatio"]').prop("disabled", true);
		$('[name^="mapWidth"]').prop("disabled", true);
		$('[name^="mapHeight"]').prop("disabled", true);
		$('[name^="resizeMap"]').prop("disabled", true);
		cancelFrame();
	}else if(selectMode == "create"){
		/* もう少しスマートな方法さがしています */
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
		// 生成フォームを利用可能に
		$('[name^="objectWidth"]').prop("disabled", false);
		$('[name^="objectHeight"]').prop("disabled", false);
		$('[name^="objectCreateColor"]').prop("disabled", false);
		$('[name^="createButton"]').prop("disabled", false);
		// JSON保存・読み込みボタンを利用可能に
		$('[name^="saveButton"]').prop("disabled", false);
		$('[name^="loadButton"]').prop("disabled", false);
		// 会場設置ボタンを利用可能に
		$('[name^="selectFile"]').prop("disabled", false);
		// 削除ボタンを利用不可に
		$('[name^="deleteButton"]').prop("disabled", true);
		// 編集フォームを利用可能に
		$('[name="title"]').prop("disabled", false);
		$('[name="presenter"]').prop("disabled", false);
		$('[name="abstract"]').prop("disabled", false);
		$('[name="objectEditColor"]').prop("disabled", false);
		$('[name="inputForm"]').prop("disabled", false);
		// マップフォームを利用可能に
		$('[name^="checkRatio"]').prop("disabled", false);
		$('[name^="mapWidth"]').prop("disabled", false);
		$('[name^="mapHeight"]').prop("disabled", false);
		$('[name^="resizeMap"]').prop("disabled", false);
	}
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
 *							会場図設置処理									*
 ********************************************************/
/* ボタンと連携してtype="file"のボタンが作動するようにする */
function selectFile(){
	$('#backGroundImage').trigger('click');
}

/* ajaxによるファイルのアップロード処理 */
function fileUpLoad(){
	var fd = new FormData($('#upLoadForm').get(0));
	$.ajax({
		url: "php/fileUploader.php",
		type: "POST",
		data: fd,
		processData: false,
		contentType: false
	})
	.done(function(msg) {
		alert(msg);
		backGroundFileName = "backGround.png";
		$(canvasElement).css("background-image","url("+webroot+"img/dot.png), url("+webroot+"img/"+backGroundFileName.toString()+"?"+$.now()+")");
		$(canvasElement).css("background-repeat","repeat, no-repeat");
	});
}

/********************************************************
 *				編集フォームのパラメータ格納	              		*
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
 *		セレクトボックスで色が変更されたときの処理			*
 ********************************************************/
// 生成フォームのカラーセレクトの色が変化したときの処理
function changeSelectColor(){
	var color = $('[name^="objectCreateColor"]').val();
	$('select[name="objectCreateColor"] + .btn-group > .selectpicker > span:first-child').css("background-color", color);
}

// 編集フォームのカラーセレクトの色が変化したときの処理
function editSelectColor(){
	var color = $('[name^="objectEditColor"]').val();
	$('select[name="objectEditColor"] + .btn-group > .selectpicker > span:first-child').css("background-color", color);
}

/********************************************************
 *						マップのサイズ変更処理						*
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
	$( '#demoCanvas' ).get( 0 ).width = canvasWidth;
	$( '#demoCanvas' ).get( 0 ).height = canvasHeight;
	$('input[name="objectWidth"]').attr("max",canvasWidth/gridSize);
	$('input[name="objectHeight"]').attr("max",canvasHeight/gridSize);
	stage.update();
}

// マップを小さくする際に、飛び出してしまうオブジェクトがあるかチェックします
function existMapOverObject(mapWidth, mapHeight){
	// オブジェクトの右下座標
	var objectRightBottom = {"x": 0, "y": 0};
	for(var i=0; i<stage.children.length; i++){
		if(stage.children[i].__type != "selectSquare"){
			// オブジェクトの右下座標がマップのサイズより上回っている場合
			objectRightBottom = {"x": stage.children[i].x + stage.children[i].width, "y": stage.children[i].y + stage.children[i].height };
			if(objectRightBottom.x > mapWidth || objectRightBottom.y > mapHeight){
				return true;
			}
		}
	}
	return false;
}

/********************************************************
 *									汎用処理								*
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
    if (color.substr(0, 1) === '#') {
        return color;
    }
    var digits = /(.*?)rgb\((\d+), (\d+), (\d+)\)/.exec(color);

    var red = parseInt(digits[2]);
    var green = parseInt(digits[3]);
    var blue = parseInt(digits[4]);

    var rgb = blue | (green << 8) | (red << 16);
    if((digits[1] + '#' + rgb.toString(16)).length == 5){
        return digits[1] + '#00' + rgb.toString(16);
    }
    return digits[1] + '#' + rgb.toString(16);
}

 /********************************************************
 *				プレゼン情報との関連付け							*
 ********************************************************/
$(function(){
$('li[draggable="true"]').on('dragstart', onDragStart);
$('#demoCanvas').on('dragover', onDragOver);
$('#demoCanvas').on('drop', onDrop);
});

function onDragStart(e){
	selectedPresentationID = this.id;
	selectedPresentationNum = $(e.target).attr('data-num');
	e.originalEvent.dataTransfer.setData('text', this.id); 
}

function onDragOver(e){
	//console.log('drag over');
	e.preventDefault();
	this.textContent = 'onDragOver';
}

function onDrop(e){
	// キャンバス上の位置を取得
	var onCanvasX = e.originalEvent.clientX - e.target.offsetLeft;
	var onCanvasY = e.originalEvent.clientY - e.target.offsetTop;
	
	// ステージ上に存在するオブジェクトを特定する
	for(var i=0; i<stage.children.length; i++){
		var target = stage.children[i];
		// ポスターオブジェクトであるかどうか判定（選択中の四角, テキストオブジェクトは無視する）
		if(target.__type != 'selectSquare' && target.__type != 'text'){
			// オブジェクトの内側かどうか判定
			if(target.x <= onCanvasX && onCanvasX <= target.x + target.width && target.y <= onCanvasY && onCanvasY <= target.y + target.height){
				// すでにそのオブジェクトがプレゼンテーションと関連済みであった場合
				if(target.__relation != null || target.__relation != ''){
					// 関連済みのプレゼンテーションを元の状態に戻す
					$('.presentationlist li#'+target.__relation).removeClass('related');
				}
				target.graphics._fill.style = '#063a5e';
				// ポスターオブジェクトに関連付けされたプレゼンテーションIDを付与
				target.__relation = selectedPresentationID;
				
				var text = new createjs.Text(selectedPresentationNum, '20px Meiryo', '#fff');
				var textWidth = text.getMeasuredWidth();
				var textHeight = text.getMeasuredHeight();
				// テキストをオブジェクトの中央に配置
				text.x = target.x + (target.width - textWidth)/2;
				text.y = target.y + (target.height - textHeight)/2;
				// テキストオブジェクトにオブジェクトタイプを付与
				text.__type = 'text';
				// テキストオブジェクトに親要素であるポスターオブジェクトのIDを付与（ポスターが移動した際に、テキストもついていくようにするため）
				text.__parent = target.id;
				
				stage.addChild(target, text);
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

 /********************************************************
 *					ページャーの切り替え処理							*
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
			$('.pager li a[data-target='+(parseInt(target_page)+(pos_pager))+']').parent().removeClass('disno');
			$('.pager li a[data-target='+(parseInt(target_page)+(pos_pager+1))+']').parent().removeClass('disno');
			$('.pager li a[data-target='+(parseInt(target_page)+(pos_pager+2))+']').parent().removeClass('disno');
			$('.pager li a[data-target='+(parseInt(target_page)+(pos_pager+3))+']').parent().removeClass('disno');
			$('.pager li a[data-target='+(parseInt(target_page)+(pos_pager+4))+']').parent().removeClass('disno');
		}
		
		// 現在のページ番号を更新
		current_page = target_page;
		console.log(current_page);
		
		/* 押されたボタンに関わらず必ず行う処理 */
		// いったん、すべてのボタンを利用可能状態にする
		$('.pager li.disabled').removeClass('disabled');
		// ページ番号が1であれば、prevボタンを使用不可にする
		if(current_page == 1){
			$('.pager .prev').addClass('disabled');
		// ページ番号が必要ページ数であれば、nextボタンを使用不可にする
		}else if(current_page == pages){
			$('.pager .next').addClass('disabled');
		}
	});
});
