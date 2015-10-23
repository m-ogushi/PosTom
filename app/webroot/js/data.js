// 共通のデータを格納するグローバル変数
var poster 			= [],
	author 			= null,
	keyword 		= null,
	presen 			= null,
	presents 		= null,
	session 		= null,
	timetable		= null,
	commentator 	= [],
//	position_map 	= null,
	position 		= null,
	taparea 		= null,
	venuemap		= null,
	toppage_img		= null,
	posmapp_bg		= [],
	poster_days		= null,
	STATIC_WIDTH 	= null,
	STATIC_HEIGHT 	= null,
	MAP_AREA_WIDTH 	= null,
	MAP_AREA_HEIGHT = null,
	INIT_SCALE 		= null,
	SCALE_BY 		= null;

// json ファイルの置き場所（URL, 仮）
//var posMAppDataURL = "http://posmapp.tk/api/data.php";
//var posMAppDataURL = "http://localhost:63342/PosMApp_forked/PosMApp/www/api/data_nosession.json";
var posMAppDataURL = "../json/data_nosession.json";

function initData() {

	if(localStorage.getItem("downloadSuccess")){
		poster 			= JSON.parse(localStorage.getItem("poster"));
		author 			= JSON.parse(localStorage.getItem("author"));
		keyword 		= JSON.parse(localStorage.getItem("keyword"));
		presen 			= JSON.parse(localStorage.getItem("presen"));
		presents 		= JSON.parse(localStorage.getItem("presents"));
		session 		= JSON.parse(localStorage.getItem("session"));
        commentator     = JSON.parse(localStorage.getItem("commentator"));
//		position_map 	= JSON.parse(localStorage.getItem("position_map"));
		position 		= JSON.parse(localStorage.getItem("position"));
		taparea 		= JSON.parse(localStorage.getItem("taparea"));
		toppage_img		= JSON.parse(localStorage.getItem("toppage_img"));
		posmapp_bg		= JSON.parse(localStorage.getItem("posmapp_bg"));
		STATIC_WIDTH 	= parseInt(localStorage.getItem("STATIC_WIDTH"));
		STATIC_HEIGHT 	= parseInt(localStorage.getItem("STATIC_HEIGHT"));
		poster_days 	= Math.ceil(poster.length/position.length);
	}

	// BlockFinderにかけた画像の幅
	STATIC_WIDTH =  720;
	STATIC_HEIGHT = 960;

	setMapSize();

}

// ポスターマップの大きさに関するデータを計算して格納
function setMapSize() {
	// マップエリアの幅
	MAP_AREA_WIDTH = screen.width;
	// マップエリアの高さ（55がヘッダー、68がフッター分）
	MAP_AREA_HEIGHT = screen.height - 55 - 68 - 68;

	// マップのスケールを決定
	INIT_SCALE = MAP_AREA_WIDTH / STATIC_WIDTH;
	SCALE_BY = "width";
	if (STATIC_HEIGHT * INIT_SCALE > MAP_AREA_HEIGHT) {
	    INIT_SCALE = MAP_AREA_HEIGHT / STATIC_HEIGHT;
	    SCALE_BY = "height";
	}
}