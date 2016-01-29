// ポスターマップ画面に遷移
$.fn.goToMapPage = function(ev) {
	$(this).on(ev, function() {
		changePage("#posterMapPage");
	});	
};

// リスト画面に遷移
$.fn.goToListPage = function(ev) {
	$(this).on(ev, function() {
		changePage("#presenListPage");
	});	
};

// 会議情報画面に遷移
$.fn.goToInformationPage = function(ev) {
	$(this).on(ev, function() {
		changePage("#informationPage");
		$("#changeDate01").trigger("click");
	});	
};

//会場図画面に遷移
$.fn.goToVenuePage = function(ev) {
	$(this).on(ev, function() {
		changePage("#venuePage");
	});	
};

// タブのボタン
// トップページボタン
$.fn.goToTopPage = function(ev) {
	var nextPage = "#topPage";
	$(this).on(ev, function() {
		changePage(nextPage);
	});
};

// pagenameのページに遷移
function changePage(pagename) {
	if (pagename === "#presenListPage") {
		var p = sessionStorage.getItem("currentListPage");
		saveLog("show_page", {page:p});
	} else {
		saveLog("show_page", {page:pagename});
	}
	resetZoom();
	changeActiveTab(pagename);
	window.location.href = pagename;
	return pagename;
}

// アクティブなタブバーをpagenameのものに切り替える
function changeActiveTab(pagename) {
	$(".topPageButton").removeClass("ui-btn-active ui-state-persist");
	$(".presenListPageButton").removeClass("ui-btn-active ui-state-persist");
	$(".venuePageButton").removeClass("ui-btn-active ui-state-persist");
	$(".posterMapPageButton").removeClass("ui-btn-active ui-state-persist");
	$(".informationPageButton").removeClass("ui-btn-active ui-state-persist");
	$("." + pagename.substring(1) + "Button").addClass("ui-btn-active ui-state-persist");
}

$.fn.showBasicInfo = function(){
    $(this).append($("<div/>")
           .attr("id","topPageEventName")
           .text(basic_info.event_name_short));
    var desc = $("<div>").attr("id","topPageEventDescription")
                .append($("<span/>").text(basic_info.event_name_full))
                .append($("<br/>"));

    if(basic_info.start_date!=basic_info.end_date){
        desc.append($("<span/>").text(basic_info.start_date + " - " +basic_info.end_date)).append($("<br/>"));
    }
    else{
        desc.append($("<span/>").text(basic_info.start_date)).append($("<br/>"));
    }
	desc.append($("<span/>").text(basic_info.venue));
    $(this).append(desc);
	if(basic_info.event_webpage.indexOf("http")>=0)
	{
		$("#event-webpage").append($("<a/>").attr("href",basic_info.event_webpage).text(basic_info.event_name_short));
	}
	else{
		$("#event-webpage").append($("<a/>").attr("href","http://"+basic_info.event_webpage).text(basic_info.event_name_short));
	}
}

function setTopPageProperties(){
    var browser_width = window.parent.screen.width;
    if(browser_width <= 640){
        $("#topPageEventName").css("font-size","20px");
        $("#topPageEventDescription").css("font-size","10px");
    }else{
        $("#topPageEventName").css("font-size","40px");
        $("#topPageEventDescription").css("font-size","20px");
    }
}