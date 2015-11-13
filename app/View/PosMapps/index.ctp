<!DOCTYPE HTML>
<html>
<head>
	<title>PosMApp</title>
	<!-- metaで文字コードを指定しないと文字化けする -->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="shortcut icon" href="<?php echo $this->Html->webroot;?>favicon.ico" />

	<link rel="stylesheet" type="text/css" href="<?php echo $this->Html->webroot;?>css/lib/jquery-ui-1.11.2.custom.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->Html->webroot;?>css/lib/jquery.mobile-1.4.5.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->Html->webroot;?>css/button-icon.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->Html->webroot;?>css/map.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->Html->webroot;?>css/topmenu.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->Html->webroot;?>css/list.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->Html->webroot;?>css/taparea.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->Html->webroot;?>css/sessiontable.css" />


	<script type="text/javascript" charset="utf-8" src="<?php echo $this->Html->webroot;?>js/lib/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $this->Html->webroot;?>js/lib/jquery-ui-1.11.2.custom.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $this->Html->webroot;?>js/lib/jquery.mobile-1.4.5.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $this->Html->webroot;?>js/lib/hammer.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $this->Html->webroot;?>js/lib/jquery.hammer.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $this->Html->webroot;?>js/lib/md5.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $this->Html->webroot;?>js/lib/jquery.xpost.js"></script>

	<!-- DB用発表データ -->
	<script type="text/javascript" charset="utf-8" src="<?php echo $this->Html->webroot;?>js/data.js"></script>

	<script type="text/javascript" charset="utf-8" src="<?php echo $this->Html->webroot;?>js/logdata-function.js"></script>

	<script type="text/javascript" charset="utf-8" src="<?php echo $this->Html->webroot;?>js/toppage-function.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $this->Html->webroot;?>js/postermap-function.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $this->Html->webroot;?>js/postermap-function-download.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $this->Html->webroot;?>js/postermap-function-ui.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $this->Html->webroot;?>js/presenlist-function.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $this->Html->webroot;?>js/bookmarklist-function.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $this->Html->webroot;?>js/detail-function.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $this->Html->webroot;?>js/sessiontable-function.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $this->Html->webroot;?>js/postermap-function-hammer.js"></script>

	<script type="text/javascript" charset="utf-8" src="<?php echo $this->Html->webroot;?>js/index.js"></script>

	<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
</head>

<body>

<!-- ローディング画面 -->
<div id="loading">
	<img src="<?php echo $this->Html->webroot;?>img/loading.gif">
</div>

<!-- トップメニュー画面 -->
<div data-role="page" id="topPage">
	<!-- 背景画像 -->
	<img id="topPageBackground" src="<?php echo $this->Html->webroot;?>img/toppage.png"/>
	<!-- コンテンツ -->
	<div id="topPageContent">
		<!--
		<div id="reDownloadDIV" class="reDownloadDIV" align="center">
			<img src="<?php echo $this->Html->webroot;?>img/gif-load.gif" class="downloading" style="zoom: 25%;"><font class="downloadMsg"></font>
		</div>
		-->
		<button id="reDownloadDIV" class="reDownloadDIVCLS"><img src="<?php echo $this->Html->webroot;?>img/loading.gif" style="zoom: 18%;">DownLoad Data</button>
		<!--
		<div class="ui-grid-solo">
			<div class="ui-block-a">
				<div id="selectLocale">Japanese | <span style="text-decoration:line-through;color:lightgray;">English</span></div>
			</div>
		</div>
		-->
		<div class="ui-grid-a">
			<div class="ui-block-a">
				<div align="center">
					<img id="goToInformation" class="topmenuicon" src="<?php echo $this->Html->webroot;?>img/topmenu/schedule.png"/>
					<div class="topMenuIconLabel">Time Table</div>
				</div>
			</div>
			<div class="ui-block-b">
				<div align="center">
					<img id="goToVenue" class="topmenuicon" src="<?php echo $this->Html->webroot;?>img/topmenu/venue.png"/>
					<div class="topMenuIconLabel">Floor Map</div>
				</div>
			</div>
		</div>
		<div class="ui-grid-a">
			<div class="ui-block-a">
				<div align="center">
					<img id="goToList" class="topmenuicon" src="<?php echo $this->Html->webroot;?>img/topmenu/list.png"/>
					<div class="topMenuIconLabel">Presentation List</div>
				</div>
			</div>
			<div class="ui-block-b">
				<div align="center">
					<img id="goToMap" class="topmenuicon" src="<?php echo $this->Html->webroot;?>img/topmenu/map.png"></img>
					<div class="topMenuIconLabel">Poster Map</div>
				</div>
			</div>
		</div>
		<div class="ui-grid-solo">
			<div class="ui-block-a">
				<div id="copyright">
					<br />
					<span style="font-size:smaller;">Copyright &copy; <a href="http://www.cs.tsukuba.ac.jp/ITsoft/">Tsukuba University.Department of Computer Science</a></span><br />
					<span style="font-size:smaller;">Team S.A.Y. (<a href="https://twitter.com/posmapp_say">@posmapp_say</a>)</span>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- ポスターマップ画面 -->
<div data-role="page" id="posterMapPage">
 	<div id="menuPanel" data-display="overlay" data-role="panel" data-position="right">
		<!-- <div id="changelabel" data-position="fixed" style="border: 2px;">
 			<a data-role="button" href="#changeLabelDialog"
 					data-inline="true" data-rel="dialog"
 					data-transition="pop">Change Label</a>
 		</div> -->
 		<div style="text-align: center;">
			Change the poster's label display.
 		</div>
 		<a class="changelabel" id="label-presenid"
			href="#posterMapPage" data-role="button">Orator NO.</a>
		<a class="changelabel" id="label-title"
			href="#posterMapPage" data-role="button">Title</a>
		<a class="changelabel" id="label-authorname"
			href="#posterMapPage" data-role="button">Orator</a>
		<a class="changelabel" id="label-authorbelongs"
			href="#posterMapPage" data-role="button">Belong</a>
	</div>
	<div data-role="header"　data-tap-toggle="false" data-position:"fixed" style="z-index: 200;">
		<div class="ui-grid-b">
			<div class="ui-block-a" style="width: 70%;">
				<input type="search" id="search-bar-title"
	    		placeholder="検索" data-inline="true" style="width:75%;" onchange="searchChanged(this)"/>
			</div>
			<div class="ui-block-b" style="width: 25%;">
				<div id="searchResult"></div>
			</div>
			<div class="ui-block-c" style="width: 5%;">
				<a href="#menuPanel" style="top:12.5px"
				class="ui-btn ui-btn-right ui-icon-bars ui-btn-icon-notext ui-corner-all"></a>
			</div>
		</div>
	</div>
	<div style="position: relative;">
			<a data-role="button" class="ReDownloadBtn">Download Data</a>
		<div id="subheader" style="top: 0px;">
			<!-- 検索結果件数 -->
			<!--<div id="searchResult"
				style="position: fixed; z-index: 100;">
			</div>-->
			<!-- エリアタップ後のズームアウトボタン -->
			<div id="resetScaleButtonFrame" data-position="fixed" style="border: 2px;">
				<a id="resetScaleButton" data-role="button"
					data-inline="true">Back</a>
			</div>
		</div>
		<!-- ポスターマップ本体 -->
		<div id="mapFrame" style="z-index: 255;background-color:#FFFFFF">
			<div id="mapMain">
				<!-- ポスターマップ表示 -->
				<img id="mapImg" src="<?php echo $this->Html->webroot;?>img/postermap_1.png" border="0"
					style="position: relative; z-index: 1;"></img>
				<!-- ポスターアイコン -->
				<div id="posters"></div>
				<!-- ポスターエリア -->
				<div id="posterArea"></div>
			</div>
			<!-- 前の日 -->
			<img id="prevDayButton" src="<?php echo $this->Html->webroot;?>img/prevday.png"></img>
			<!-- 次の日 -->
			<img id="nextDayButton" src="<?php echo $this->Html->webroot;?>img/nextday.png"></img>
		</div>
		<!-- 基本情報パネル -->
		<div style="position: relative;">
			<div id="basicinfopanel" style="display:none;">
				<div id="basicinfo"></div>
				<!-- ブックマークボタン -->
				<!-- アイコンの切り替えはpostermap.jsで行う -->
				<img id="bookmarkbutton"></img>
				<!-- 詳細情報ボタン -->
				<img id="detailinfobutton" src="<?php echo $this->Html->webroot;?>img/detail.png"></img>
			</div>
		</div>
	</div>

	<!-- タブバー -->
	<!-- <div class="tabbar"></div> -->
	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="nav-tabicon" style="position:fixed; bottom:0px">
		<div data-role="navbar" height="100%" class="nav-tabicon" data-grid="d">
			<ul>
				<li><a class="topPageButton" id="totoppage" data-icon="toppage">Top</a></li>
				<li><a class="informationPageButton" id="information" data-icon="informationgray">TimeTable</a></li>
				<li><a class="venuePageButton"  id="venue"  data-icon="venue" >Floor Map</a></li>
				<li><a class="presenListPageButton" id="list" data-icon="list">Presentation List</a></li>
				<li><a class="posterMapPageButton" id="map" data-icon="map">Poster Map</a></li>
			</ul>
		</div>
	</div>
</div>

<!-- 詳細情報画面 -->
<div data-role="page" id="detailPage">
	<div data-role="header">
		<h1 style="text-align:center"　>Information</h1>
		<a href="#" class="ui-btn-left"  data-icon="carat-l" id="detailBackButton" >Back</a>
	</div>
	<div data-role="content">
	<div id="detail-presenid"></div>
		<h3 style="margin-left:2.5%; margin-right:2.5%;">
			<span id="detail-title"></span>
		</h3>
			<div id="detail-authors"></div>
		<p>
			<span id="detail-abstract"></span>
		</p>
		<p>キーワード：<br /><span id="detail-keywords"></span></p>

	</div>
	<!-- タブバー -->
	<!-- <div class="tabbar"></div> -->
	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="nav-tabicon" style="position:fixed; bottom:0px">
		<div data-role="navbar" height="100%" class="nav-tabicon" data-grid="d">
			<ul>
				<li><a class="topPageButton" id="totoppage" data-icon="toppage">Top</a></li>
				<li><a class="informationPageButton" id="information" data-icon="informationgray">TimeTable</a></li>
				<li><a class="venuePageButton"  id="venue"  data-icon="venue" >Floor Map</a></li>
				<li><a class="presenListPageButton" id="list" data-icon="list">Presentation List</a></li>
				<li><a class="posterMapPageButton" id="map" data-icon="map">Poster Map</a></li>
			</ul>
		</div>
	</div>
</div>

<!-- 発表リスト画面 -->
<div data-role="page" id="presenListPage">
	<!-- 検索のTIPS-->
	<div data-role="popup" data-position-to="window" id="search-tips">
		<a href="#" data-rel="back" data-role="button" data-icon="delete" data-iconpos="notext" class="ui-btn-right">閉じる</a>
		<div data-role="header">
			<h1>検索のヒント</h1>
		</div>
		<div data-role="main">
			<p style="padding: 0.5em;">Please use the browser search <br />if you want to search from all<br /></p>
			<p style="padding: 0.5em;">If you use the Google Chrome ,please touch the [Menu]<br /> button,then you can use the [search in the page] to search</p>
		</div>
	</div>
	<div id="presenHeader" data-role="header" data-position="fixed" data-tap-toggle="false">
		<h1 style="text-align:center">Presentation List</h1>
		<a href="#search-tips" data-rel="popup" data-transition="pop" class="ui-btn ui-btn-icon-notext ui-btn-right ui-icon-search ui-corner-all"></a>
		<div data-role="controlgroup" data-type="horizontal" class="ui-btn-left" style="top: 3px;">
			<a id="listIconAll" class="ui-btn
			ui-corner-all ui-btn-active" data-mini="true">All</a>
			<a id="listIconStar" class="ui-btn ui-corner-all" data-mini="true" >★</a>
		</div>
	</div>
	<div data-role="content">
			<a data-role="button" class="ReDownloadBtn">Download Data</a>
		<div style="overflow:auto; height:100%;">
			<!-- 発表リスト -->
			<div id="presenList" class="listcolor"></div>
			<div id="bookmarkList" class="listcolor"></div>
		</div>
	</div>
	<!-- タブバー -->
	<!-- <div class="tabbar"></div> -->
	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="nav-tabicon" style="position:fixed; bottom:0px">
		<div data-role="navbar" height="100%" class="nav-tabicon" data-grid="d">
			<ul>
				<li><a class="topPageButton" id="totoppage" data-icon="toppage">Top</a></li>
				<li><a class="informationPageButton" id="information" data-icon="informationgray">TimeTable</a></li>
				<li><a class="venuePageButton"  id="venue"  data-icon="venue" >Floor Map</a></li>
				<li><a class="presenListPageButton" id="list" data-icon="list">Presentation List</a></li>
				<li><a class="posterMapPageButton" id="map" data-icon="map">Poster Map</a></li>
			</ul>
		</div>
	</div>
</div>

<!-- 会場マップ画面 -->
<div data-role="page" id="venuePage">
	<div data-role="header" data-position="fixed">
		<h1 style="text-align:center"　>Floor Map</h1>
	</div>
	<div align="center">
			        <br/><br/><br/>
					<img id="floormap" width="720px" height="920px" src="<?php echo $this->Html->webroot;?>img/venue1.png"></img>
	</div>
	<!-- タブバー -->
	<!-- <div class="tabbar"></div> -->
	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="nav-tabicon" style="position:fixed; bottom:0px">
		<div data-role="navbar" height="100%" class="nav-tabicon" data-grid="d">
			<ul>
				<li><a class="topPageButton" id="totoppage" data-icon="toppage">Top</a></li>
				<li><a class="informationPageButton" id="information" data-icon="informationgray">TimeTable</a></li>
				<li><a class="venuePageButton"  id="venue"  data-icon="venue" >Floor Map</a></li>
				<li><a class="presenListPageButton" id="list" data-icon="list">Presentation List</a></li>
				<li><a class="posterMapPageButton" id="map" data-icon="map">Poster Map</a></li>
			</ul>
		</div>
	</div>
</div>


<!-- 表示切替ボタンのダイアログ -->
<div data-role="page" id="changeLabelDialog">
	<div data-role="header">
		<h1>Change Label</h1>
	</div>
	<div data-role="content">
		<a class="changelabel" id="label-presenid"
			href="#posterMapPage" data-role="button">Orator NO.</a>
		<a class="changelabel" id="label-title"
			href="#posterMapPage" data-role="button">Title</a>
		<a class="changelabel" id="label-authorname"
			href="#posterMapPage" data-role="button">Orator</a>
		<a class="changelabel" id="label-authorbelongs"
			href="#posterMapPage" data-role="button">Belong</a>
	</div>
</div>

<!-- セッションテーブル -->
<!-- DEIM2014のセッションテーブルの内容 -->
<div data-role="page" id="informationPage">
  <div data-role="header" data-position="fixed">
    <h1 id="sessionHyou" style="text-align:center">プログラム</h1>
  </div>
  <div data-role="content">
    <!--&lt;!&ndash;date切替ボタン&ndash;&gt; -->
    <!--<p id="changeDateButton" data-role="controlgroup" data-type="horizontal" align="center">-->
        <!--<a id="changeDate01" class="sessiontable1" href="#sessiontable1" data-role="button">3月2日</a>-->
        <!--<a id="changeDate02" class="sessiontable2" href="#sessiontable2" data-role="button">3月3日</a>-->
        <!--<a id="changeDate03" class="sessiontable3" href="#sessiontable3" data-role="button">3月4日</a>-->
      <!--</p>-->
    <!--<h3 align="center" id="sessionDate"></h3>-->
      <!--&lt;!&ndash; セッションテーブル本体 &ndash;&gt;-->
      <!--<div id="sessiontables">-->
      <!--<div id="sessiontable1" class="sessiontable">-->
        <!--<table class="session_table">-->
          <!--<tr><th>時間</th><th>会場</th><th>内容</th></tr>-->
          <!--<tr><th  class="showtime" rowspan="7" bgcolor="blue">13:00<br />-<br />14:30</th><td><a class="jumpToVenue">A</a></td><td><a id="presenlinkA1" class="jumpToPresen">A1：QA・ECサイト</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">B</a></td><td><a id="presenlinkB1" class="jumpToPresen">B1：情報伝搬・クラウドソーシング</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">C</a></td><td><a id="presenlinkC1" class="jumpToPresen">C1：食・レシピ情報</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">D</a></td><td><a id="presenlinkD1" class="jumpToPresen">D1：トピック分類</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">E</a></td><td><a id="presenlinkE1" class="jumpToPresen">E1：クラウド・IoT</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">F</a></td><td><a id="presenlinkF1" class="jumpToPresen">F1：音楽情報処理</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">G</a></td><td><a id="presenlinkG1" class="jumpToPresen">G1：プライバシー(1)</a></td></tr>-->
          <!--<tr><td class="rest" colspan="3"　bgcolor="red">休憩</td></tr>-->
          <!--<tr><th  class="showtime" rowspan="7" bgcolor="blue">14:45<br />-<br />16:15</th><td><a class="jumpToVenue">A</a></td><td><a id="presenlinkA2" class="jumpToPresen">A2：テキストマイニング</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">B</a></td><td><a id="presenlinkB2" class="jumpToPresen">B2：情報推薦(1)</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">C</a></td><td><a id="presenlinkC2" class="jumpToPresen">C2：ネットワーク・センシング</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">D</a></td><td><a id="presenlinkD2" class="jumpToPresen">D2：データ分析</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">E</a></td><td><a id="presenlinkE2" class="jumpToPresen">E2：マイニング・可視化</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">F</a></td><td><a id="presenlinkF2" class="jumpToPresen">F2：動画像データ分析</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">G</a></td><td><a id="presenlinkG2" class="jumpToPresen">G2：プライバシー(2-->
          	<!--)</a></td></tr>-->

          <!--<tr><td class="rest" colspan="3"　>休憩</td></tr>-->
          <!--<tr><th  class="showtime" rowspan="7" bgcolor="blue">16:30<br />-<br />18:00</th><td><a class="jumpToVenue">A</a></td><td><a id="presenlinkA3" class="jumpToPresen">A3:情報検索</a><p class="phdsession">（Ph.Dセッション）</p></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">B</a></td><td><a id="presenlinkB3" class="jumpToPresen">B3:情報推薦(2)</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">C</a></td><td><a id="presenlinkC3" class="jumpToPresen">C3:省電力</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">D</a></td><td><a id="presenlinkD3" class="jumpToPresen">D3:ユーザーレビュー</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">E</a></td><td><a id="presenlinkE3" class="jumpToPresen">E3:半構造データ・オープンデータ</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">F</a></td><td><a id="presenlinkF3" class="jumpToPresen">F3:学術情報</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">G</a></td><td><a id="presenlinkG3" class="jumpToPresen">G3:GPU・ストレージ</a></td></tr>-->
          <!--<tr><td class="rest" colspan="3"　>休憩</td></tr>-->
          <!--<tr style="height:30px"><th class="showtime">19:00<br />-<br />21:00</th><td class="banquetRoom"><a class="jumpToVenue">懇親会会場</a></td><td>インタラクティブ<br />セッション(1)</td></tr>-->
          <!--<tr>-->
          	<!--<th  class="showtime" >21:00<br />-<br />23:30</th>-->
            <!--<td colspan="2"　>ヤングリサーチャーディスカッション</td>-->
          <!--</tr>-->
        <!--</table>-->
      <!--</div>-->
      <!--&lt;!&ndash;二日目&ndash;&gt; -->
      <!--<div id="sessiontable2" class="sessiontable">-->
        <!--<table class="session_table">-->
          <!--<tr><th>時間</th><th>会場</th><th>内容</th></tr>-->
          <!--<tr><th  class="showtime" rowspan="7" >8:45<br />-<br />10:15</th><td><a class="jumpToVenue">A</a></td><td><a id="presenlinkA4" class="jumpToPresen">A4:Web情報システム<p class="phdsession">（Ph.Dセッション）</p></a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">B</a></td><td><a id="presenlinkB4" class="jumpToPresen">B4:情報抽出</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">C</a></td><td><a id="presenlinkC4" class="jumpToPresen">C4:マイクロブログ(1)</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">D</a></td><td><a id="presenlinkD4" class="jumpToPresen">D4:情報信頼性</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">E</a></td><td><a id="presenlinkE4" class="jumpToPresen">E4:データ処理基盤</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">F</a></td><td><a id="presenlinkF4" class="jumpToPresen">F4:HCI</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">G</a></td><td><a id="presenlinkG4" class="jumpToPresen">G4:データマイニング・マイクロブログ</a></td></tr>-->
          <!--<tr><td class="rest" colspan="3"　bgcolor="red">休憩</td></tr>-->
          <!--<tr><th  class="showtime" rowspan="7">10:30<br />-<br />12:00</th><td><a class="jumpToVenue">A</a></td><td><a id="presenlinkA5" class="jumpToPresen">A5:データマイニング(1)<p class="phdsession">（Ph.Dセッション）</p></a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">B</a></td><td><a id="presenlinkB5" class="jumpToPresen">B5:情報検索応用</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">C</a></td><td><a id="presenlinkC5" class="jumpToPresen">C5:クエリ高度化</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">D</a></td><td><a id="presenlinkD5" class="jumpToPresen">D5:ドキュメントと機械学習</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">E</a></td><td><a id="presenlinkE5" class="jumpToPresen">E5:グラフと分散処理</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">F</a></td><td><a id="presenlinkF5" class="jumpToPresen">F5:感情と感性</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">G</a></td><td><a id="presenlinkG5" class="jumpToPresen">G5:医療情報</a></td></tr>-->
          <!--<tr><td class="rest">12:00<br />-<br />13:00</td><td class="rest" colspan="2"　>昼食（＋DBS運営委員会/DE専門委員会）</td></tr>-->
          <!--<tr><th  class="showtime" rowspan="7" >13:00<br />-<br />14:30</th><td><a class="jumpToVenue">A</a></td><td><a>A6:データマイニング(2)(Ph.Dセッション)</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">B</a></td><td><a id="presenlinkB6" class="jumpToPresen">B6:分散処理・管理</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">C</a></td><td><a id="presenlinkC6" class="jumpToPresen">C6:クラウドソーシング・SNS</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">D</a></td><td><a id="presenlinkD6" class="jumpToPresen">D6:OLAP</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">E</a></td><td><a id="presenlinkE6" class="jumpToPresen">E6:グラフマイニング</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">F</a></td><td><a id="presenlinkF6" class="jumpToPresen">F6:位置情報</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">G</a></td><td><a id="presenlinkG6" class="jumpToPresen">G6:科学・医療データマイニング</a></td></tr>-->
          <!--<tr><td class="rest" colspan="3"　>休憩</td></tr>-->
          <!--<tr><th class="showtime">14:45<br />-<br />16:35</th><td><a class="jumpToVenue">A・B</a></td><td>招待講演</td></tr>-->
          <!--<tr><td class="rest" colspan="3"　>休憩</td></tr>-->
          <!--<tr><th class="showtime">16:45<br />-<br />18:15</th>-->
          <!--<td><a class="jumpToVenue">A・B</a></td><td>DBSJアワー<br />・功労賞記念講演</td></tr>-->
          <!--<tr><td class="rest" colspan="3"　>休憩</td></tr>-->
          <!--<tr>-->
            <!--<th  class="showtime"  >19:00<br />-<br />21:00</th>-->
            <!--<td class="banquetRoom"><a class="jumpToVenue">懇親会会場</a></td>-->
            <!--<td>インタラクティブ<br />セッション（２）</td>-->
          <!--</tr>-->
          <!--<tr>-->
            <!--<th  class="showtime">21:00<br />-<br />22:00</th>-->
            <!--<td><a class="jumpToVenue">懇親会会場</a></td>-->
            <!--<td>BoFセッション</td>-->
          <!--</tr>-->
          <!--<tr>-->
          	<!--<th  class="showtime" >22:00<br />-<br />23:30</th>-->
            <!--<td colspan="2"　>ヤングリサーチャーディスカッション</td>-->
          <!--</tr>-->
        <!--</table>-->
      <!--</div>-->
      <!--&lt;!&ndash;三日目&ndash;&gt; -->
      <!--<div id="sessiontable3" class="sessiontable">-->
        <!--<table class="session_table">-->
          <!--<tr><th>時間</th><th>会場</th><th>内容</th></tr>-->
          <!--<tr><th  class="showtime" rowspan="6" >8:45<br />-<br />10:15</th><td><a class="jumpToVenue">A・B</a></td><td><a id="presenlinkB7" class="jumpToPresen">特別セッション</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">C</a></td><td><a id="presenlistC7" class="jumpToPresen">C7:災害情報</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">D</a></td><td><a id="presenlistD7" class="jumpToPresen">D7:先進的応用</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">E</a></td><td><a id="presenlistE7" class="jumpToPresen">E7:プラットフォーム技術</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">F</a></td><td><a id="presenlistF7" class="jumpToPresen">F7:地理・観光</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">G</a></td><td><a id="presenlinkG7" class="jumpToPresen">G7:観光情報</a></td></tr>-->
          <!--<tr><td class="rest" colspan="3"　bgcolor="red">休憩</td></tr>-->
          <!--<tr><th  class="showtime" rowspan="7">10:30<br />-<br />12:00</th><td><a class="jumpToVenue">A</a></td><td><a id="presenlistA8" class="jumpToPresen">A8:マイクロブログ(2)</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">B</a></td><td><a id="presenlistB8" class="jumpToPresen">B8:音楽・動画推薦</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">C</a></td><td><a id="presenlistC8" class="jumpToPresen">C8:イベント抽出と地理情報</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">D</a></td><td><a id="presenlistD8" class="jumpToPresen">D8:SNSユーザ情報</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">E</a></td><td><a id="presenlistE8" class="jumpToPresen">E8:情報抽出・検索</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">F</a></td><td><a id="presenlistF8" class="jumpToPresen">F8:時系列データ</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">G</a></td><td><a id="presenlinkG8" class="jumpToPresen">G8:自然言語処理</a></td></tr>-->
       <!-- -->
          <!--<tr>-->
          	<!--<th id="closingH" class="showtime" >12:00<br />-<br />12:15</th>-->
          	<!--<td class="closingD" ><a class="jumpToVenue">A・B</a></td>-->
          	<!--<td class="closingD" >クロージング<br />表彰式</td>-->
          <!--</tr>-->
          <!--<tr>-->
          	<!--<th  class="showtime" >12:15<br />-<br />13:15</th>-->
          	<!--<td  colspan="2"　>昼食（＋コメンテータ委員会）</td>-->
          <!--</tr>-->

        <!--</table>-->
      <!--</div>-->
      <!--</div>-->
  </div>
  	<!-- タブバー -->
	<!-- <div class="tabbar"></div> -->
	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="nav-tabicon" style="position:fixed; bottom:0px">
		<div data-role="navbar" height="100%" class="nav-tabicon" data-grid="d">
			<ul>
				<li><a class="topPageButton" id="totoppage" data-icon="toppage">Top</a></li>
				<li><a class="informationPageButton" id="information" data-icon="informationgray">TimeTable</a></li>
				<li><a class="venuePageButton"  id="venue"  data-icon="venue" >Floor Map</a></li>
				<li><a class="presenListPageButton" id="list" data-icon="list">Presentation List</a></li>
				<li><a class="posterMapPageButton" id="map" data-icon="map">Poster Map</a></li>
			</ul>
		</div>
	</div>
</div>

<!-- 利用ログデータ回収許諾ダイアログ  -->
<div data-role="dialog" data-close-btn="none" id="checkCollectLogDialog">
	<div data-role="header">
		<h1>ログ送信に関するお願い</h1>
	</div>
	<div data-role="content">
		筑波大学高度ITコース・チームS.A.Y.では、ユーザの行動分析を行いアプリの改善をする研究を行っております。つきましては、本アプリの利用ログの回収にご協力頂きたいと考えております。利用ログには個人を特定できる情報は含まれず、統計的な分析のみに使用します。ご協力頂ける場合は、[はい]ボタンを押して下さい。<br />
		<a data-role="button" id="acceptCollectLog">Yes</a>
		<a data-role="button" id="denyCollectLog">No</a>
	</div>
</div>

<!-- ユーザカテゴリ選択ダイアログ -->
<div data-role="dialog" data-close-btn="none" id="selectUserCategoryDialog">
	<div data-role="header">
		<h1>Chose User Type</h1>
	</div>
	<div data-role="content">
		Please select the one what you are<br />
		<a data-role="button" class="selectUserCategoryButton" id="usercat-1">Orator</a>
		<a data-role="button" class="selectUserCategoryButton" id="usercat-2">Komennteetaa</a>
		<a data-role="button" class="selectUserCategoryButton" id="usercat-3">Other Orator</a>
		<a data-role="button" class="selectUserCategoryButton" id="usercat-4">other</a>
	</div>
</div>

<!-- ダウンロード失敗したダイアログ  -->
<div data-role="dialog" data-close-btn="none" id="downloadFailDialog">
	<div data-role="header">
		<h1>Load Failed</h1>
	</div>
	<div data-role="content">
		Load Failed<br />
		Try Again?<br />
		<a data-role="button" id="ReDownload">Yes</a>
		<a data-role="button" id="CancelDownload">No</a>
	</div>
</div>

<!-- 文字の大きさを調べる用div -->
<div id="emScale"></div>

</body>
</html>
