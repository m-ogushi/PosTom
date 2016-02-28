//　ポスターデータのダウンロード
function downloadPoster(pageName){
	//loading画像の表示
	$(".downloading").css("display", "inline");
	if(!pageName){
		pageName = "#topPage";
	}

	// LocalStorageの整合性が取れていない場合ダウンロードし直す
	if (localStorage.getItem("downloadSuccess") === "true" && !isValidLocalStorage()) {
		console.log("Invalid Local Storage, Redownload");
		localStorage.removeItem("downloadSuccess");
	}
	if (sessionStorage.getItem("clickDiv")) {
		setTimeout("ajaxdownload('"+pageName+"')",500);
	}else{
		ajaxdownload(pageName);
	}
	
}

function checkDataVersion(){
		$.ajax({
		   		url: posMAppDataVersionURL,
				type: "POST",
				dataType: "json",
				async: false,
				data: "",
				timeout: 10000, // タイムアウトにするまでの時間は要検討
				success: function(data) {

					version		= data.version;
					//alert(version);
					var cur_version = localStorage.getItem("version");
					if(cur_version==null || version > cur_version){
						localStorage.setItem("version",version);
						localStorage.setItem("downloadSuccess",false);
					}
				}
		});

}

function ajaxdownload(pageName){
	var flag = localStorage.getItem("downloadSuccess");
	if(flag === "false" || flag === null){
		localStorage.clear();
		
		$.ajax({
		   		url: posMAppDataURL,
				type: "POST",
				dataType: "json",
				async: false,
				data: "",
				timeout: 10000, // タイムアウトにするまでの時間は要検討
				success: function(data) {
					console.log("Download Success");

					// データを格納
					basic_info      = data.basic_info;
					poster 			= data.poster;
					author 			= data.author;
					keyword 		= data.keyword;
					presen 			= data.presen;
					presents 		= data.presents;
					session 		= data.session;
					timetable		= data.timetable;
					commentator 	= data.commentator;
					position 		= data.position;
					taparea 		= data.taparea;
					venuemap		= data.venuemap;
					toppage_img		= data.toppage_img;
					posmapp_bg		= data.posmapp_bg;
					STATIC_WIDTH 	= data.STATIC_WIDTH;
					STATIC_HEIGHT 	= data.STATIC_HEIGHT;

                    if(basic_info != null){
                        localStorage.setItem("basic_info",JSON.stringify(data.basic_info));
                    }
					localStorage.setItem("poster",JSON.stringify(data.poster));
					localStorage.setItem("author",JSON.stringify(data.author));
					if(keyword != null){
						localStorage.setItem("keyword",JSON.stringify(data.keyword));
					}
					localStorage.setItem("presen",JSON.stringify(data.presen));
					if(presents != null){
						localStorage.setItem("presents",JSON.stringify(data.presents));
					}
					if(session != null){
						localStorage.setItem("session",JSON.stringify(data.session));
					}
					localStorage.setItem("timetable",JSON.stringify(data.timetable));
					if(commentator != null){
						localStorage.setItem("commentator",JSON.stringify(data.commentator));
					}
					localStorage.setItem("position",JSON.stringify(data.position));
					if(taparea != null){
						localStorage.setItem("taparea",JSON.stringify(data.taparea));
					}
					if(toppage_img != null){
						localStorage.setItem("toppage_img", JSON.stringify(data.toppage_img));
					}
					if(posmapp_bg != null){
						localStorage.setItem("posmapp_bg", JSON.stringify(data.posmapp_bg));
					}
					localStorage.setItem("venuemap",JSON.stringify(data.venuemap));
					localStorage.setItem("STATIC_WIDTH",JSON.stringify(data.STATIC_WIDTH));
					localStorage.setItem("STATIC_HEIGHT",JSON.stringify(data.STATIC_HEIGHT));

					// ポスターマップの大きさに関するデータを計算して格納 in data.js
					setMapSize();

					// 成功フラグを立てる
					localStorage.setItem("downloadSuccess","true");
					// $("#downloading").css("display", "none");
					$("#reDownloadDIV").css("display", "none");
					$("#reDownloadDIVList").css("display", "none");
					$("#reDownloadDIVMap").css("display", "none");
					localStorage.removeItem("downloadResult");
					
					// 再描画
					//init();
					$("#posters").show();
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.error("Download Error:  " + errorThrown);
					localStorage.setItem("pageName",pageName);
					localStorage.setItem("downloadResult","downloadResult");
					setTimeout("$('.reDownloadDIVCLS').html('データを再ダウンロード')",3000);
					setTimeout("$('.ReDownloadBtn').html('データを再ダウンロード')",3000);
					window.location.href = pageName;
					window.location.href = "#downloadFailDialog";
					//データがない時、マップ画面のundefineを表示しない
					$("#posters").hide();
				},
				complete: function(data) {
					console.log("Download Complete");
					//initUserData();　//一時的にログ機能を止める
					sessionStorage.removeItem("clickDiv");
				}
		});
	}
}

// LocalStorageのデータの整合性チェック
function isValidLocalStorage() {
	if (localStorage.getItem("poster") === null) return false;
	if (localStorage.getItem("author") === null) return false;
	if (localStorage.getItem("presen") === null) return false;
	if (localStorage.getItem("position") === null) return false;
	if (localStorage.getItem("STATIC_WIDTH") === null) return false;
	if (localStorage.getItem("STATIC_HEIGHT") === null) return false;
	if (localStorage.getItem("version") === null) return false;
	return true;
}

//「ダウンロード失敗」ダイアログの「cancel」をクリックする時呼び出す
$.fn.cancelDownload = function() {
	$(this).on("click", function(e){
		window.location.href = localStorage.getItem("pageName");
		// loading画像を表示しない
		// $("#downloading").css("display", "none");
		setTimeout("$('.reDownloadDIVCLS').html('データを再ダウンロード')",3000);
		setTimeout("$('.ReDownloadBtn').html('データを再ダウンロード')",3000);
		//initUserData(); //一時的にログ機能を止める
		$("#posters").html("");
	});
};

//「ダウンロード失敗」ダイアログの「再ダウンロード」をクリックする時呼び出す
$.fn.reDownload = function() {
	$(this).on("click", function(e){
		$(".downloading").css("display", "inline");
		$(".reDownloadDIVCLS").html("<img src='img/loading.gif' style='height:1.0em;vertical-align: middle;'>データ読み込み中");
		$(".ReDownloadBtn").html("<img src='img/loading.gif' style='height:100%;vertical-align: middle;'>データ読み込み中");
		downloadPoster(localStorage.getItem("pageName"));
		$("#posters").html("");
	});
};

//「データ読み込み中」divをクリックする時呼び出す
$.fn.reDownloadFun = function() {
	$(this).on("click", function(e){
		var pageName = "#" + window.location.href.split("#")[1];
		$(".reDownloadDIVCLS").html("<img src='img/loading.gif' style='height:1.0em;vertical-align: middle;'>データ読み込み中");
		$(".ReDownloadBtn").html("<img src='img/loading.gif' style='height:100%;vertical-align: middle;'>データ読み込み中");
		sessionStorage.setItem("clickDiv", "clickDiv");
		downloadPoster(pageName);
	});
};
