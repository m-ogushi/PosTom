
<!-- js -->
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script src="https://code.createjs.com/easeljs-0.8.0.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-select.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script>
/********************************************************
 *							�ϐ���`										*
 ********************************************************/
// �L�����o�X�̉���, ����
var canvasWidth = 720;
var canvasHeight = 960;
// �L�����o�X�̏c����(4:3)
var canvasRatio = 4/3;
// ���̓t�H�[���̉���
var formWidth = 240;
// 1�O���b�h������̃T�C�Y�i�P�ӂ̒����j
var gridSize = 10;
// �������ɂ�����ŏ��̈ʒu�ix, y�j
var initX = 0, initY = 0;
// �O���b�h�ɂ�����Ԓn
var gridX, gridY;
// ���݂̃��[�h
var selectMode = "create";
// �폜�Ώۂ��L������z��
var deleteArray = [];
// �T�C�Y�ύX���󂯕t����̈�̃T�C�Y�i�P�ӂ̒����j
var resizeArea = 10;
// �T�C�Y�ύX���ł����Ԃł��邩�ǂ���
var resizeFlg = false;
// �T�C�Y�ύX���ł��邩�ǂ���
var onResizing = false;
// sprint1 �f�t�H���g�̐F
var defaultColor = "#999999";
// ���}�摜�t�@�C����
var backGroundFileName = "";
// �L�����o����ɃN���b�N�����ʒu
var pointerX= 0;
var pointerY=0;
// �I�u�W�F�N�g����ɃN���b�N�����ʒu
var onPointX = 0;
var onPointY =0;
// ?
var objectArray=[];
// �I������Ă���I�u�W�F�N�g
var selectedObject;
// �I������Ă���I�u�W�F�N�g�����邩�ǂ���
var selectFlag=true;
// �I����Ԃ�Frame���h���b�O���Ă���Ƃ��A�ǂ�Frame���h���b�N���Ă��邩
var nowwwhite;
// �I�����Ă���I�u�W�F�N�g�̉E�[�̍��W
var nowright;
// �I�����Ă�I�u�W�F�N�g�̍����̍��W
var nowbottom;
// �T�C�Y�ύX�O�̈ʒu
var previewscalex;
var previewscaley;
// �T�C�Y�ύX�O�̑傫��
var previewbigx;
var previewbigy;
// �}�b�v�T�C�Y�̍ŏ��l�E�ő�l
var mapMinWidth = 300;
var mapMinHeight = 400;
var mapMaxWidth = 1500;
var mapMaxHeight = 2000;


/********************************************************
 *							�ǂݍ��ݎ��̏���							*
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
 *					�u���E�U�̃��T�C�Y���̏���						*
 ********************************************************/
$(window).on('load resize', function(){
});


/********************************************************
 *	�I�u�W�F�N�g�̃��T�C�Y�̈�Ƀ}�E�X�|�C���^�����邩����	*
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
				// �T�C�Y�ύX�p�̃J�[�\���ɕύX
				childArray[i].cursor = "se-resize";
				break;
			}else{
				childArray[i].cursor = "pointer";
			}
		}
	}
}

/********************************************************
 *							�I�u�W�F�N�g����							*
 ********************************************************/
// �I�u�W�F�N�g�z�u����
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

// �I�u�W�F�N�g��������
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
		// �����{�^�����������Ƃ��ɂ�鐶���̏ꍇ
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
 *							�}�E�X�C�x���g����							*
 ********************************************************/
// �h���b�O�̊J�n����
function startDrag(eventObject) {
    selectFlag=false;
	var instance = eventObject.target;
	// �L�����o�X����ɃN���b�N�����ʒu
    pointerX= eventObject.stageX;
    pointerY=eventObject.stageY;
	// �I�u�W�F�N�g����ɃN���b�N�����ʒu
	onPointX = eventObject.stageX - instance.x;
	onPointY = eventObject.stageY - instance.y;
	
	if(selectMode == "create"){
		if(!resizeFlg){
			// �ړ�
			instance.addEventListener("pressmove", drag);
			instance.addEventListener("pressup", stopDrag);
			previewscalex=instance.x;
			previewscaley=instance.y;
		}else if(resizeFlg){
			// �T�C�Y�ύX
			instance.addEventListener("pressmove", resizeDrag);	
			instance.addEventListener("pressup", stopResizeDrag);
		}
	}else if(selectMode == "delete"){
		// �폜�ΏۑI��
		instance.addEventListener("pressup", selectDelete);
	}
}

// ���ړ����h���b�O���̏���
function drag(eventObject) {
	var instance = eventObject.target;
	var width = parseInt(instance.graphics.command.w);
	var height = parseInt(instance.graphics.command.h);
	var leftTop = { x: instance.x, y: instance.y };
	var rightTop = { x: instance.x + width , y: instance.y };
	var rightBottom = { x:instance.x + width , y: instance.y + height };
	var leftBottom = { x: instance.x , y: instance.y + height };
	// �|�C���^�ʒu����ʊO���������̕���
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

// ���ړ����h���b�O�̏I������
function stopDrag(eventObject) {
	var instance = eventObject.target;
	instance.removeEventListener("pressmove", drag);
	instance.removeEventListener("pressup", stopDrag);
	// �}�E�X�_�E�������ʒu����}�E�X�A�b�v�����ʒu�܂ł̈ړ������i�R�����̒藝�j
	var dragDistant = Math.sqrt(Math.pow(eventObject.stageX-pointerX,2) + Math.pow(eventObject.stageY-pointerY,2));
	// ����Ȃ��N���b�N�ɋ߂��h���b�O�̏ꍇ
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
		// ���̃I�u�W�F�N�g�Əd�Ȃ����ꍇ�͈ړ�����O�ɖ߂�
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
 *						�I�u�W�F�N�g�̑I������						*
 ********************************************************/
// �I�u�W�F�N�g��I��
function click(eventObject){
	selectFlag=false;
	// ���ɑI������Ă���I�u�W�F�N�g���N���b�N�����ꍇ
	if(eventObject.target==selectedObject){
		return;
	}
	// �I������Ă���I�u�W�F�N�g�ȊO���N���b�N�����ꍇ
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

// �h���b�v���̍ĕ`��
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

// �I���������̑I��g�`��
function select(){
	// �ҏW�t�H�[���𗘗p�\��
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
				// �t���[�����ɔԍ���U��
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

// �I��g������
function cancelFrame(eventObject){
    if(selectFlag==true) {
        if (selectedObject != null) {  // canvas�N���b�N2��A���ȍ~�͌Ă΂�Ȃ��悤�ɂ���
            var formColor = $('select[name="objectEditColor"] + .btn-group > .selectpicker > span:first-child').css('background-color');//�@rgb
            if (selectedObject.__title != $('[name^="title"]').val() || selectedObject.__presenter != $('[name^="presenter"]').val() || selectedObject.__abstract != $('[name^="abstract"]').val() || rgbToHex(formColor).toLowerCase() != rgbToHex(selectedObject.color).toLowerCase()) {
                changeSelectObject(selectedObject, $('[name^="title"]').val(), $('[name^="presenter"]').val(), $('[name^="abstract"]').val(), formColor);  //�@JS�����selectedObject�ƃt�H�[�����e�������̂ň����œn���Ă���
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
		// �ҏW�t�H�[���𗘗p�s��
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

//�@mouse over�̃|�C���^�[����
function FrameMouseOver(sq){
	resizeFlg = false;
	//�@�t���[���ɂ���ă}�E�X�J�[�\����ς���
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

//�h���b�O�̊J�n����
function FramDragStart(eventObject){
	selectFlag=false;
	var instance = selectedObject;
	// �I�u�W�F�N�g��̂ǂ̈ʒu���N���b�N������
	pointerX= eventObject.stageX;
	pointerY= eventObject.stageY;
	onPointX = eventObject.stageX - instance.x;
	onPointY = eventObject.stageY - instance.y;
	if(selectMode == "create") {
		// �T�C�Y�ύX
		eventObject.target.addEventListener("pressmove", FrameDrag);
		eventObject.target.addEventListener("pressup", FrameDragOver);
		//�h���b�N�J�n���̃I�u�W�F�N�g�̑傫���擾
		previewbigx = instance.graphics.command.w;
		previewbigy = instance.graphics.command.h;
		//�h���b�N�J�n���̃I�u�W�F�N�g�̍��W�擾
		previewscalex=instance.x;
		previewscaley=instance.y;
		//�h���b�N�J�n���̃I�u�W�F�N�g�̉E�[�Ɖ��[�̍��W�擾
		nowright= instance.x+previewbigx;
		nowbottom= instance.y+previewbigy;
			var nowdistance=1000;
		//�ł��߂��t���[�����A����T�C�Y�ύX����t���[���Ƃ݂Ȃ�
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

// �h���b�O������
function FrameDrag(eventObject){
	var eb=eventObject;
	eb.target=selectedObject;
	resizeDrag(eb);
	var instance =eventObject.target;
}

// �h���b�O�I��菈��
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
//���̃I�u�W�F�N�g�Əd�Ȃ����ꍇ�́A�ʒu�A�傫�����Ɍ��ɖ߂�
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

// �I�����ꂽ�I�u�W�F�N�g�����f�[�^��ҏW�t�H�[���ɔ��f����
function inputEditForm(){
    $('input[name="title"]').val(selectedObject.__title);
    $('input[name="presenter"]').val(selectedObject.__presenter);
    $('textarea[name="abstract"]').val(selectedObject.__abstract);
    $('select[name="objectEditColor"] + .btn-group > .selectpicker > span:first-child').css('background-color',selectedObject.color);
}

// ���T�C�Y�ύX���h���b�N���̏���
function resizeDrag(eventObject) {
	var changeFrame = stage.children[nowwhite].__number;
	var instance = eventObject.target;
	// 0:����		1:������		2:�E��
	// 3:������	4:-			5:�E����
	// 6:����		7:������		8:�E��
	// �}�`�̉E����
	if(changeFrame == 2 || changeFrame == 5 || changeFrame==8){
		instance.graphics.command.w = Math.ceil((eventObject.stageX - instance.x)/gridSize)*gridSize;
	}
	// �}�`�̉�����
	if(changeFrame == 6 || changeFrame == 7 || changeFrame==8){
		instance.graphics.command.h =  Math.ceil((eventObject.stageY - instance.y)/gridSize)*gridSize;
	}
	// �}�`�̍�����
	if(changeFrame == 0 || changeFrame==3 || changeFrame==6){
		instance.x = Math.round((eventObject.stageX - onPointX)/gridSize)*gridSize;
		instance.graphics.command.w = nowright-instance.x;
	}
	// �}�`�̏㕔��
	if(changeFrame == 0 || changeFrame==1 || changeFrame==2){
		instance.y = Math.round((eventObject.stageY - onPointY)/gridSize)*gridSize;
		instance.graphics.command.h = nowbottom-instance.y;
	}
	//�@x���W�͉E�[��荶
	if(instance.x>=nowright){
		instance.x=nowright-gridSize;
	}
	//�@y���W�͉��[����
	if(instance.y>=nowbottom){
		instance.y=nowbottom-gridSize;
	}
	// �������O���b�h�T�C�Y��菬�����Ƃ�
	if(instance.graphics.command.w < gridSize){
		instance.graphics.command.w = gridSize;
	}
	// �������O���b�h�T�C�Y��菬�����Ƃ�
	if(instance.graphics.command.h < gridSize){
		instance.graphics.command.h = gridSize;
	}
    if(instance.array!=null){
        updateFrame(instance.x,instance.y,instance.graphics.command.w,instance.graphics.command.h);
    }
	stage.update();
	onResizing = true;
}

//�@�I���I�u�W�F�N�g���ς�����Ƃ��̕ҏW���e�m�F�_�C�A���O����
function changeSelectObject(editObject, title, presenter, abstract, formColor){
    $( "#dialogEditConfirm" ).dialog({
        resizable: false,
        height:140,
        modal: true,
        buttons: {
            "�m��": function() {
                // �ҏW�t�H�[���̓��e����������
                editObject.__title=title;
                editObject.__presenter=presenter;
                editObject.__abstract=abstract;
                editObject.color = formColor; // �Ǝ��ŏ��������ϐ��Ɋi�[�����̂�
                editObject.graphics._fill.style = formColor; // �����Ɋi�[���Ȃ���ΐF�͔��f����Ȃ�
                stage.update();
                $( this ).dialog( "close" );
            },
            "�L�����Z��": function() {
                $( this ).dialog( "close" );
            }
        }
    });
}

/********************************************************
 *					�I�u�W�F�N�g�̃T�C�Y�ύX����					*
 ********************************************************/
// ���T�C�Y�ύX���h���b�O�̏I������
function stopResizeDrag(eventObject) {
	var instance = eventObject.target;
	instance.removeEventListener("pressmove", resizeDrag);
	instance.removeEventListener("pressup", stopResizeDrag);
	onResizing = false;
}


// ���폜���폜�Ώۂ̑I��
function selectDelete(eventObject){
	var instance = eventObject.target;
	var width = parseInt(instance.graphics.command.w);
	var height = parseInt(instance.graphics.command.h);
	
	if(instance.__deleteSelected == null || instance.__deleteSelected == false){
		instance.__deleteSelected = true;
		var checkImage = new createjs.Bitmap('<?php echo $this->Html->webroot;?>img/ico_check.png');
		checkImage.x = instance.x + width - (checkImage.image.width / 2);
		checkImage.y = instance.y - (checkImage.image.height / 2);
		checkImage.__relationID = instance.id;
		stage.addChild(checkImage);
		deleteArray.push(instance.id);
	}else{
		instance.__deleteSelected = false;
		var array = stage.children;
		/* ���������X�}�[�g�ȕ��@�������Ă��܂� */
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
 *								JSON����									*
 ********************************************************/
/* JSON �������ݏ��� */
function saveJson(){
	var objectArray = [];
    var child;              //stage.children[i]�i�[
	var id, x, y, w, h,title,presenter,abstract,color;
	for(i=0; i<stage.children.length; i++) {
        child = stage.children[i];
        x = child.x;
        y = child.y;
        w = parseInt(child.graphics.command.w);
        h = parseInt(child.graphics.command.h);
        color = child.color;
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
        array = {'x': x, 'y': y, 'w': w, 'h': h, 'color': color, 'title': title, 'presenter': presenter, 'abstract': abstract};
        if (child.__type != "selectSquare") {
            objectArray.push(array);
        }
	}
	
	// �L�����o�X�̃T�C�Y�����A�z��̐擪�Ɋi�[
	objectArray.unshift({'mapHeight': canvasHeight});
	objectArray.unshift({'mapWidth': canvasWidth});
	
	// ���ɉ��}���ݒu���Ă���΁A�摜����z��̐擪�Ɋi�[
	var searchImageFileName = "backGround.png";
	if($(canvasElement).css("background-image").indexOf(searchImageFileName) != -1){
		objectArray.unshift({'filename':searchImageFileName});
	}
	
	$.ajax({
		type: "POST",
		url: "php/save.php",
		data: { "data": objectArray },
		success: function(msg){
			alert(msg);
		}
	});
	
	// ��ꃊ���[�X�p��PosMApp�ɍ��킹���`����JSON�t�@�C����������������܂�
	var demoArray = {};
	demoArray['toppage_img'] = "<?php echo $this->Html->webroot;?>img/toppage_pbla.png";
	var demoPosmappBgArray = []
	demoPosmappBgArray.push("http://tkb-tsss.sakura.ne.jp/release1/img/" + searchImageFileName);
	demoArray['posmapp_bg'] = demoPosmappBgArray;
	demoArray['STATIC_WIDTH'] = canvasWidth;
	demoArray['STATIC_HEIGHT'] = canvasHeight;
	
	// �e��iposition, author, presen, poster�j �z����쐬
	var demoPositionArray = [];
	var demoAuthorArray = [];
	var demoPresenArray = [];
	var demoPosterArray = [];
	for(var i=0; i<stage.children.length; i++) {
		// objectPresenId, objectBlongs, objectFirst, �ɂ��Ă̓f�����_�œ��̓t�H�[�����Ȃ����ߎ����I�ɕt�^���Ă��܂�
		child = stage.children[i];
		objectId = child.id;
		objectX = child.x;
		objectY = child.y;
		objectWidth = child.graphics.command.w;
		objectHeight = child.graphics.command.h;
		//objectWidth = child.width;
		//objectHeight = child.height;
		objectPresenId = "A1-"+(i+1);
		objectPresenter = child.__presenter;
		objectBelongs = "�}�g��";
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

/* JSON �ǂݍ��ݏ��� */
function loadJson(){
	var objectList;
	stage.removeAllChildren();
	$.getJSON("json/data.json?"+$.now(), function(json){
		// �w�i�摜��ǂݍ��ށi���̕��@����json�̕��т��ς�����Ƃ��ɓ��삵�Ȃ��j
		if(json[0].filename!=null){
			var file = json[0];
			json.splice(0, 1);
			backGroundFileName=file.filename.toString();
			$(canvasElement).css("background-image","url(<?php echo $this->Html->webroot;?>img/dot.png), url(<?php echo $this->Html->webroot;?>img/"+file.filename.toString()+"?"+$.now()+")");
			$(canvasElement).css("background-repeat","repeat, no-repeat");
		}
		
		// �}�b�v�̃T�C�Y��ǂݍ��ށi���̕��@����json�̕��т��ς�����Ƃ��ɓ��삵�Ȃ��j
		if(json[0].mapWidth != null && json[1].mapHeight != null){
			// �O���[�o���ϐ����X�V
			canvasWidth = json[0].mapWidth;
			canvasHeight = json[1].mapHeight;
			// �}�b�v�̃T�C�Y�ύX
			$( '#demoCanvas' ).get( 0 ).width = canvasWidth;
			$( '#demoCanvas' ).get( 0 ).height = canvasHeight;
			// �����ł���I�u�W�F�N�g�T�C�Y����l�̍X�V
			$('[name^="objectWidth"]').attr("max",canvasWidth/gridSize);
			$('[name^="objectHeight"]').attr("max",canvasHeight/gridSize);
			// �}�b�v�̃T�C�Y�ύX�t�H�[���̒l�̍X�V
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
		alert("JSON�t�@�C��������܂���");
	});
}

/********************************************************
 *						���[�h��؂�ւ�����							*
 ********************************************************/
function changeMode(){
	selectMode = $('[name^="selectMode"]').val();
	if(selectMode == "delete"){
		cancelFrame();
		// �����t�H�[���𗘗p�s��
		$('[name^="objectWidth"]').prop("disabled", true);
		$('[name^="objectHeight"]').prop("disabled", true);
		$('[name^="objectCreateColor"]').prop("disabled", true);
		$('[name^="createButton"]').prop("disabled", true);
		// JSON�ۑ��E�ǂݍ��݃{�^���𗘗p�s��
		$('[name^="saveButton"]').prop("disabled", true);
		$('[name^="loadButton"]').prop("disabled", true);
		// ���ݒu�{�^���𗘗p�s��
		$('[name^="selectFile"]').prop("disabled", true);
		// �폜�{�^���𗘗p�\��
		$('[name^="deleteButton"]').prop("disabled", false);
		// �ҏW�t�H�[���𗘗p�s��
		$('[name="title"]').prop("disabled", true);
		$('[name="presenter"]').prop("disabled", true);
		$('[name="abstract"]').prop("disabled", true);
		$('[name="objectEditColor"]').prop("disabled", true);
		$('[name="inputForm"]').prop("disabled", true);
		// �}�b�v�t�H�[���𗘗p�s��
		$('[name^="checkRatio"]').prop("disabled", true);
		$('[name^="mapWidth"]').prop("disabled", true);
		$('[name^="mapHeight"]').prop("disabled", true);
		$('[name^="resizeMap"]').prop("disabled", true);
		cancelFrame();
	}else if(selectMode == "create"){
		/* ���������X�}�[�g�ȕ��@�������Ă��܂� */
		// �폜�Ώۂɕt�^�����`�F�b�N�摜���폜����
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
		// �����t�H�[���𗘗p�\��
		$('[name^="objectWidth"]').prop("disabled", false);
		$('[name^="objectHeight"]').prop("disabled", false);
		$('[name^="objectCreateColor"]').prop("disabled", false);
		$('[name^="createButton"]').prop("disabled", false);
		// JSON�ۑ��E�ǂݍ��݃{�^���𗘗p�\��
		$('[name^="saveButton"]').prop("disabled", false);
		$('[name^="loadButton"]').prop("disabled", false);
		// ���ݒu�{�^���𗘗p�\��
		$('[name^="selectFile"]').prop("disabled", false);
		// �폜�{�^���𗘗p�s��
		$('[name^="deleteButton"]').prop("disabled", true);
		// �ҏW�t�H�[���𗘗p�\��
		$('[name="title"]').prop("disabled", false);
		$('[name="presenter"]').prop("disabled", false);
		$('[name="abstract"]').prop("disabled", false);
		$('[name="objectEditColor"]').prop("disabled", false);
		$('[name="inputForm"]').prop("disabled", false);
		// �}�b�v�t�H�[���𗘗p�\��
		$('[name^="checkRatio"]').prop("disabled", false);
		$('[name^="mapWidth"]').prop("disabled", false);
		$('[name^="mapHeight"]').prop("disabled", false);
		$('[name^="resizeMap"]').prop("disabled", false);
	}
 }
function deleteObject(){
	if(deleteArray.length == 0){
		alert("�폜����Ώۂ̃I�u�W�F�N�g���I������Ă��܂���");
	}else{
		/* �m�F�_�C�A���O�̕\�� */
		$( "#dialogDeleteConfirm" ).dialog({
			resizable: false,
			height:140,
			modal: true,
			buttons: {
			"�͂�": function() {
				// �폜�Ώۂ̃I�u�W�F�N�g�ƕt�^�����`�F�b�N�摜���폜����
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
			"������": function() {
				$( this ).dialog( "close" );
			}
			}
		});
	}
}


/********************************************************
 *							���}�ݒu����									*
 ********************************************************/
/* �{�^���ƘA�g����type="file"�̃{�^�����쓮����悤�ɂ��� */
function selectFile(){
	$('#backGroundImage').trigger('click');
}

/* ajax�ɂ��t�@�C���̃A�b�v���[�h���� */
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
		$(canvasElement).css("background-image","url(<?php echo $this->Html->webroot;?>img/dot.png), url(<?php echo $this->Html->webroot;?>img/"+backGroundFileName.toString()+"?"+$.now()+")");
		$(canvasElement).css("background-repeat","repeat, no-repeat");
	});
}

/********************************************************
 *				�ҏW�t�H�[���̃p�����[�^�i�[	              		*
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
	targetChild.color = color; // �Ǝ��ŏ��������ϐ��Ɋi�[�����̂�
	targetChild.graphics._fill.style = color; //  �����Ɋi�[���Ȃ���ΐF�͔��f����Ȃ�
	stage.update();
}

/********************************************************
 *		�Z���N�g�{�b�N�X�ŐF���ύX���ꂽ�Ƃ��̏���			*
 ********************************************************/
// �����t�H�[���̃J���[�Z���N�g�̐F���ω������Ƃ��̏���
function changeSelectColor(){
	var color = $('[name^="objectCreateColor"]').val();
	$('select[name="objectCreateColor"] + .btn-group > .selectpicker > span:first-child').css("background-color", color);
}

// �ҏW�t�H�[���̃J���[�Z���N�g�̐F���ω������Ƃ��̏���
function editSelectColor(){
	var color = $('[name^="objectEditColor"]').val();
	$('select[name="objectEditColor"] + .btn-group > .selectpicker > span:first-child').css("background-color", color);
}

/********************************************************
 *						�}�b�v�̃T�C�Y�ύX����						*
 ********************************************************/
// width�̒l���͌�A�t�H�[�J�X���O�ꂽ�Ƃ��̏���
function onBlurMapWidth(){
	var checkMapRatio = $('input[name="checkRatio"]').prop('checked');
	var mapWidth = $('input[name="mapWidth"]').val();
	// �䗦��ێ�����Ƀ`�F�b�N����Ă���ꍇ
	if(checkMapRatio){
		var keepRatioHeight = Math.round(mapWidth * canvasRatio);
		$('input[name="mapHeight"]').val(keepRatioHeight);
	}
}

// height�̒l���͌�A�t�H�[�J�X���O�ꂽ�Ƃ��̏���
function onBlurMapHeight(){
	var checkMapRatio = $('input[name="checkRatio"]').prop('checked');
	var mapHeight = $('input[name="mapHeight"]').val();
	// �䗦��ێ�����Ƀ`�F�b�N����Ă���ꍇ
	if(checkMapRatio){
		var keepRatioWidth = Math.round(mapHeight / canvasRatio);
		$('input[name="mapWidth"]').val(keepRatioWidth);
	}
}

// �}�b�v�T�C�Y�ύX�{�^���������ꂽ�Ƃ��̏���
function resizeMap(){
	var mapWidth = $('input[name^="mapWidth"]').val();
	var mapHeight = $('input[name^="mapHeight"]').val();
	
	// �}�b�v�̍ŏ��l��菬�����ꍇ
	if(mapWidth < mapMinWidth || mapHeight < mapMinHeight ){
		alert("The min map size is�Awidth�Awidth�F"+mapMinWidth+"px�Cheight�F"+mapMinHeight+"px");
		return false;
	}
	// �}�b�v�̍ő�l���傫���ꍇ
	if(mapWidth > mapMaxWidth || mapHeight > mapMaxHeight ){
		alert("The max map size is�Awidth�F"+mapMaxWidth+"px�Cheight�F"+mapMaxHeight+"px");
		return false;
	}
	// �O���b�h�T�C�Y�ɍ��킹�邽�ߎl�̌ܓ�
	mapWidth = Math.round(mapWidth / gridSize) * gridSize;
	mapHeight = Math.round(mapHeight / gridSize) * gridSize;
	
	// �}�b�v������������ۂɁA���肫��Ȃ��I�u�W�F�N�g������ꍇ
	if(existMapOverObject(mapWidth, mapHeight)){
		alert("Some object are out of map");
		return false;
	}
	// �t�H�[���ɃO���b�h�P�ʂɂ��낦���l�����
	$('input[name^="mapWidth"]').val(mapWidth);
	$('input[name^="mapHeight"]').val(mapHeight);
	// �O���[�o���ϐ��̍X�V
	canvasWidth = mapWidth;
	canvasHeight = mapHeight;
	// �}�b�v�T�C�Y�̕ύX�𔽉f
	$( '#demoCanvas' ).get( 0 ).width = canvasWidth;
	$( '#demoCanvas' ).get( 0 ).height = canvasHeight;
	$('input[name="objectWidth"]').attr("max",canvasWidth/gridSize);
	$('input[name="objectHeight"]').attr("max",canvasHeight/gridSize);
	stage.update();
}

// �}�b�v������������ۂɁA��яo���Ă��܂��I�u�W�F�N�g�����邩�`�F�b�N���܂�
function existMapOverObject(mapWidth, mapHeight){
	// �I�u�W�F�N�g�̉E�����W
	var objectRightBottom = {"x": 0, "y": 0};
	for(var i=0; i<stage.children.length; i++){
		if(stage.children[i].__type != "selectSquare"){
			// �I�u�W�F�N�g�̉E�����W���}�b�v�̃T�C�Y�������Ă���ꍇ
			objectRightBottom = {"x": stage.children[i].x + stage.children[i].width, "y": stage.children[i].y + stage.children[i].height };
			if(objectRightBottom.x > mapWidth || objectRightBottom.y > mapHeight){
				return true;
			}
		}
	}
	return false;
}

/********************************************************
 *									�ėp����								*
 ********************************************************/
// �X�e�[�W�`���h�����̒���������id�����I�u�W�F�N�g���擾����
function getChildById(id){
	for(var i=0; i<stage.children.length; i++){
		if(id == stage.children[i].id){
			return stage.children[i];
		}
	}
	return null;
}

// �C���v�b�g�e�L�X�g�ɐ��������͂��ꂽ���ǂ����`�F�b�N����
function checkTextIsNumeric(inputElement){
	// �����ȊO�͓��͂ł��Ȃ��悤�ɂ���
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

</script>

<!-- css -->
<link rel="stylesheet" href="<?php echo $this->Html->webroot;?>css/reset.css">
<link rel="stylesheet" href="<?php echo $this->Html->webroot;?>css/base.css">
<link rel="stylesheet" href="<?php echo $this->Html->webroot;?>css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $this->Html->webroot;?>css/bootstrap-select.css">
<link rel="stylesheet" href="<?php echo $this->Html->webroot;?>css/jquery-ui.min.css">
<style>
#inputArea {
	position: absolute;
	right: 0;
	top : 0;
	background: #fff;
	width: 240px;
	height: 100%;
	padding: 20px;
}
#inputArea .form {
	margin-bottom: 20px;
}
#inputArea .bgGRY {
	background-color: #999999;
}
#inputArea .bg1 { background-color: #999999; }
#inputArea .bg2 { background-color: #000000; }
#inputArea .bg3 { background-color: #ffffff; }
#inputArea .bg4 { background-color: #E60012; }
#inputArea .bg5 { background-color: #F39800; }
#inputArea .bg6 { background-color: #FFF100; }
#inputArea .bg7 { background-color: #8FC31F; }
#inputArea .bg8 { background-color: #009944; }
#inputArea .bg9 { background-color: #009E96; }
#inputArea .bg10 { background-color: #00A0E9; }
#inputArea .bg11 { background-color: #0068B7; }
#inputArea .bg12 { background-color: #1D2088; }
#inputArea .bg13 { background-color: #920783; }
#inputArea .bg14 { background-color: #E4007F; }
#inputArea .bg15 { background-color: #E5004F; }
select[name="objectCreateColor"] + .btn-group > .selectpicker > span:first-child,
select[name="objectEditColor"] + .btn-group > .selectpicker > span:first-child {
	background-color: #999999;
	border: 1px solid #f1f1f1;
}
#mapForm .form-control {
	display: inline-block;
	width: 140px;
}

/* boostrap hack */
.btn {
	width: 100%;
}
fieldset {
	padding: 15px;
	margin: 0;
	border: 1px solid silver;
	border-radius: 10px;
}
legend {
	text-align: center;
	font-size: 16px;
	width: 80%;
}
/* bootstrap-select hack */
ul.dropdown-menu li {
	list-style: none;
}
.bootstrap-select {
	width: 120px !important;
	margin-bottom: 20px;
}
.dropdown-menu {
	width: auto !important;
}
/* jquery-ui hack */
#dialogDeleteConfirm {
	height: auto !important;
}
#dialogEditConfirm {
    height: auto !important;
}
</style>

<div>

<!-- canvasArea -->
<div id="canvasArea" style="float:left;left-boarding:230px;">
<canvas id="demoCanvas" width="1180" height="960"></canvas>
</div>
<!-- //canvasArea -->
<!-- inputArea -->


<div id="inputArea">
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
<!-- bootstrap �f�t�H���g��type="file"�͂�������邢�̂�display:none ����͂����� -->
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

