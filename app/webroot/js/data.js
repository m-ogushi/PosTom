// 共通のデータを格納するグローバル変数
var poster 			= [],
    basic_info      = null,
	author 			= null,
	keyword 		= null,
	presen 			= null,
	presents 		= null,
	session 		= null,
	session_map     = {},
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
//var posMAppDataURL = "http://localhost:63342/PosMApp2/PosMApp/www/api/webdb2015.json";
//var posMAppDataVersionURL = "http://localhost:63342/PosMApp2/PosMApp/www/api/webdb2015_version.json";

//var posMAppDataURL = "../../json/webdb2015.json";


var url= window.location.href;
var event_str = url.substring(url.lastIndexOf('/')+1, url.length);
var posMAppDataURL = "../../json/"+event_str+".json";
var posMAppDataVersionURL = "../../json/"+event_str+"_version.json";

function ViewModel(){
	this.forum = forum;
}

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
//		poster_days 	= Math.ceil(poster.length/position.length);
		poster_days		= posmapp_bg.length;
		timetable 		= JSON.parse(localStorage.getItem("timetable"));
		venuemap		= JSON.parse(localStorage.getItem("venuemap"));
	    basic_info      = JSON.parse(localStorage.getItem("basic_info"));

		makeSessionMap();

	}

	// BlockFinderにかけた画像の幅
	STATIC_WIDTH =  720;
	STATIC_HEIGHT = 960;

	setMapSize();

	ko.applyBindings(new ViewModel());

}

function makeSessionMap(){
	for(var s in session){
		session_map[session[s].sessionid] = session[s];
	}
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
