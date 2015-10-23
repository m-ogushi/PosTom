<!DOCTYPE HTML>
<html>
<head>
	<title>PosMApp</title>
	<!-- meta�ŕ����R�[�h���w�肵�Ȃ��ƕ����������� -->
	<meta http-equiv="Content-Type" content="text/html; charset=Shift-JIS" />
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

	<!-- DB�p���\�f�[�^ -->
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

<!-- ���[�f�B���O��� -->
<div id="loading">
	<img src="<?php echo $this->Html->webroot;?>img/loading.gif">
</div>

<!-- �g�b�v���j���[��� -->
<div data-role="page" id="topPage">
	<!-- �w�i�摜 -->
	<img id="topPageBackground" src="<?php echo $this->Html->webroot;?>img/toppage.png"/>
	<!-- �R���e���c -->
	<div id="topPageContent">
		<!--
		<div id="reDownloadDIV" class="reDownloadDIV" align="center">
			<img src="<?php echo $this->Html->webroot;?>img/gif-load.gif" class="downloading" style="zoom: 25%;"><font class="downloadMsg"></font>
		</div>
		-->
		<button id="reDownloadDIV" class="reDownloadDIVCLS"><img src="<?php echo $this->Html->webroot;?>img/loading.gif" style="zoom: 18%;">�f�[�^���_�E�����[�h</button>
		<!--
		<div class="ui-grid-solo">
			<div class="ui-block-a">
				<div id="selectLocale">���{�� | <span style="text-decoration:line-through;color:lightgray;">English</span></div>
			</div>
		</div>
		-->
		<div class="ui-grid-a">
			<div class="ui-block-a">
				<div align="center">
					<img id="goToInformation" class="topmenuicon" src="<?php echo $this->Html->webroot;?>img/topmenu/schedule.png"/>
					<div class="topMenuIconLabel">�^�C���e�[�u��</div>
				</div>
			</div>
			<div class="ui-block-b">
				<div align="center">
					<img id="goToVenue" class="topmenuicon" src="<?php echo $this->Html->webroot;?>img/topmenu/venue.png"/>
					<div class="topMenuIconLabel">���}</div>
				</div>
			</div>
		</div>
		<div class="ui-grid-a">
			<div class="ui-block-a">
				<div align="center">
					<img id="goToList" class="topmenuicon" src="<?php echo $this->Html->webroot;?>img/topmenu/list.png"/>
					<div class="topMenuIconLabel">���\�ꗗ</div>
				</div>
			</div>
			<div class="ui-block-b">
				<div align="center">
					<img id="goToMap" class="topmenuicon" src="<?php echo $this->Html->webroot;?>img/topmenu/map.png"></img>
					<div class="topMenuIconLabel">�|�X�^�[�}�b�v</div>
				</div>
			</div>
		</div>
		<div class="ui-grid-solo">
			<div class="ui-block-a">
				<div id="copyright">
					<br />
					<span style="font-size:smaller;">Copyright &copy; <a href="http://www.cs.tsukuba.ac.jp/ITsoft/">�}�g��wCS��U ���xIT�R�[�X</a></span><br />
					<span style="font-size:smaller;">Team S.A.Y. (<a href="https://twitter.com/posmapp_say">@posmapp_say</a>)</span>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- �|�X�^�[�}�b�v��� -->
<div data-role="page" id="posterMapPage">
 	<div id="menuPanel" data-display="overlay" data-role="panel" data-position="right">
		<!-- <div id="changelabel" data-position="fixed" style="border: 2px;">
 			<a data-role="button" href="#changeLabelDialog"
 					data-inline="true" data-rel="dialog"
 					data-transition="pop">���x���ؑ�</a>
 		</div> -->
 		<div style="text-align: center;">
 			�|�X�^�[�̃��x���\���ύX
 		</div>
 		<a class="changelabel" id="label-presenid"
			href="#posterMapPage" data-role="button">���\�ԍ�</a>
		<a class="changelabel" id="label-title"
			href="#posterMapPage" data-role="button">�^�C�g��</a>
		<a class="changelabel" id="label-authorname"
			href="#posterMapPage" data-role="button">��\�Җ�</a>
		<a class="changelabel" id="label-authorbelongs"
			href="#posterMapPage" data-role="button">����</a>
	</div>
	<div data-role="header"�@data-tap-toggle="false" data-position:"fixed" style="z-index: 200;">
		<div class="ui-grid-b">
			<div class="ui-block-a" style="width: 70%;">
				<input type="search" id="search-bar-title"
	    		placeholder="����" data-inline="true" style="width:75%;" onchange="searchChanged(this)"/>
			</div>
			<div class="ui-block-b" style="width: 25%;">
				<div id="searchResult"></div>
			</div>
			<div class="ui-block-c" style="width: 5%;">
				<a href="#menuPanel" style="top:12.5px"
				class="ui-btn ui-btn-right ui-icon-bars ui-btn-icon-notext ui-corner-all"></a>
			</div>
		</div>
	</div>??
	<div style="position: relative;">
			<a data-role="button" class="ReDownloadBtn">�f�[�^���_�E�����[�h</a>
		<div id="subheader" style="top: 0px;">
			<!-- �������ʌ��� -->
			<!--<div id="searchResult"
				style="position: fixed; z-index: 100;">
			</div>-->
			<!-- �G���A�^�b�v��̃Y�[���A�E�g�{�^�� -->
			<div id="resetScaleButtonFrame" data-position="fixed" style="border: 2px;">
				<a id="resetScaleButton" data-role="button"
					data-inline="true">�߂�</a>
			</div>
		</div>
		<!-- �|�X�^�[�}�b�v�{�� -->
		<div id="mapFrame" style="z-index: 255;background-color:#FFFFFF">
			<div id="mapMain">
				<!-- �|�X�^�[�}�b�v�\�� -->
				<img id="mapImg" src="<?php echo $this->Html->webroot;?>img/postermap_1.png" border="0"
					style="position: relative; z-index: 1;"></img>
				<!-- �|�X�^�[�A�C�R�� -->
				<div id="posters"></div>
				<!-- �|�X�^�[�G���A -->
				<div id="posterArea"></div>
			</div>
			<!-- �O�̓� -->
			<img id="prevDayButton" src="<?php echo $this->Html->webroot;?>img/prevday.png"></img>
			<!-- ���̓� -->
			<img id="nextDayButton" src="<?php echo $this->Html->webroot;?>img/nextday.png"></img>
		</div>
		<!-- ��{���p�l�� -->
		<div style="position: relative;">
			<div id="basicinfopanel" style="display:none;">
				<div id="basicinfo"></div>
				<!-- �u�b�N�}�[�N�{�^�� -->
				<!-- �A�C�R���̐؂�ւ���postermap.js�ōs�� -->
				<img id="bookmarkbutton"></img>
				<!-- �ڍ׏��{�^�� -->
				<img id="detailinfobutton" src="<?php echo $this->Html->webroot;?>img/detail.png"></img>
			</div>
		</div>
	</div>

	<!-- �^�u�o�[ -->
	<!-- <div class="tabbar"></div> -->
	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="nav-tabicon" style="position:fixed; bottom:0px">
		<div data-role="navbar" height="100%" class="nav-tabicon" data-grid="d">
			<ul>
				<li><a class="topPageButton" id="totoppage" data-icon="toppage">�g�b�v</a></li>
				<li><a class="informationPageButton" id="information" data-icon="informationgray">TimeTable</a></li>
				<li><a class="venuePageButton"  id="venue"  data-icon="venue" >���}</a></li>
				<li><a class="presenListPageButton" id="list" data-icon="list">���\�ꗗ</a></li>
				<li><a class="posterMapPageButton" id="map" data-icon="map">�|�X�^�[</a></li>
			</ul>
		</div>
	</div>
</div>

<!-- �ڍ׏���� -->
<div data-role="page" id="detailPage">
	<div data-role="header">
		<h1 style="text-align:center"�@>�ڍ׏��</h1>
		<a href="#" class="ui-btn-left"  data-icon="carat-l" id="detailBackButton" >�߂�</a>
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
		<p>�L�[���[�h�F<br /><span id="detail-keywords"></span></p>

	</div>
	<!-- �^�u�o�[ -->
	<!-- <div class="tabbar"></div> -->
	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="nav-tabicon" style="position:fixed; bottom:0px">
		<div data-role="navbar" height="100%" class="nav-tabicon" data-grid="d">
			<ul>
				<li><a class="topPageButton" id="totoppage" data-icon="toppage">�g�b�v</a></li>
				<li><a class="informationPageButton" id="information" data-icon="informationgray">TimeTable</a></li>
				<li><a class="venuePageButton"  id="venue"  data-icon="venue" >���}</a></li>
				<li><a class="presenListPageButton" id="list" data-icon="list">���\�ꗗ</a></li>
				<li><a class="posterMapPageButton" id="map" data-icon="map">�|�X�^�[</a></li>
			</ul>
		</div>
	</div>
</div>

<!-- ���\���X�g��� -->
<div data-role="page" id="presenListPage">
	<!-- ������TIPS-->
	<div data-role="popup" data-position-to="window" id="search-tips">
		<a href="#" data-rel="back" data-role="button" data-icon="delete" data-iconpos="notext" class="ui-btn-right">����</a>
		<div data-role="header">
			<h1>�����̃q���g</h1>
		</div>
		<div data-role="main">
			<p style="padding: 0.5em;">�ꗗ�̌����ɂ́A<br />�u���E�U�̌����@�\�������p������</p>
			<p style="padding: 0.5em;">Google Chrome�ł͉E��̃��j���[<br />�{�^������u�y�[�W�������v��I�����邱�ƂŌ����ł��܂�</p>
		</div>
	</div>
	<div id="presenHeader" data-role="header" data-position="fixed" data-tap-toggle="false">
		<h1 style="text-align:center">���\�ꗗ</h1>
		<a href="#search-tips" data-rel="popup" data-transition="pop" class="ui-btn ui-btn-icon-notext ui-btn-right ui-icon-search ui-corner-all"></a>
		<div data-role="controlgroup" data-type="horizontal" class="ui-btn-left" style="top: 3px;">
			<a id="listIconAll" class="ui-btn
			ui-corner-all ui-btn-active" data-mini="true">All</a>
			<a id="listIconStar" class="ui-btn ui-corner-all" data-mini="true" >��</a>
		</div>
	</div>
	<div data-role="content">
			<a data-role="button" class="ReDownloadBtn">�f�[�^���_�E�����[�h</a>
		<div style="overflow:auto; height:100%;">
			<!-- ���\���X�g -->
			<div id="presenList" class="listcolor"></div>
			<div id="bookmarkList" class="listcolor"></div>
		</div>
	</div>
	<!-- �^�u�o�[ -->
	<!-- <div class="tabbar"></div> -->
	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="nav-tabicon" style="position:fixed; bottom:0px">
		<div data-role="navbar" height="100%" class="nav-tabicon" data-grid="d">
			<ul>
				<li><a class="topPageButton" id="totoppage" data-icon="toppage">�g�b�v</a></li>
				<li><a class="informationPageButton" id="information" data-icon="informationgray">TimeTable</a></li>
				<li><a class="venuePageButton"  id="venue"  data-icon="venue" >���}</a></li>
				<li><a class="presenListPageButton" id="list" data-icon="list">���\�ꗗ</a></li>
				<li><a class="posterMapPageButton" id="map" data-icon="map">�|�X�^�[</a></li>
			</ul>
		</div>
	</div>
</div>

<!-- ���}�b�v��� -->
<div data-role="page" id="venuePage">
	<div data-role="header" data-position="fixed">
		<h1 style="text-align:center"�@>���}</h1>
	</div>
	<div align="center">
			        <br/><br/><br/>
					<img style="width:100%"; src="<?php echo $this->Html->webroot;?>img/venue1.png"></img>
					<br/><br/><br/><br/>
					<img  style="width:100%"; src="<?php echo $this->Html->webroot;?>img/venue2.png"></img>

	</div>
	<!-- �^�u�o�[ -->
	<!-- <div class="tabbar"></div> -->
	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="nav-tabicon" style="position:fixed; bottom:0px">
		<div data-role="navbar" height="100%" class="nav-tabicon" data-grid="d">
			<ul>
				<li><a class="topPageButton" id="totoppage" data-icon="toppage">�g�b�v</a></li>
				<li><a class="informationPageButton" id="information" data-icon="informationgray">TimeTable</a></li>
				<li><a class="venuePageButton"  id="venue"  data-icon="venue" >���}</a></li>
				<li><a class="presenListPageButton" id="list" data-icon="list">���\�ꗗ</a></li>
				<li><a class="posterMapPageButton" id="map" data-icon="map">�|�X�^�[</a></li>
			</ul>
		</div>
	</div>
</div>


<!-- �\���ؑփ{�^���̃_�C�A���O -->
<div data-role="page" id="changeLabelDialog">
	<div data-role="header">
		<h1>���x���̕\���؂�ւ�</h1>
	</div>
	<div data-role="content">
		<a class="changelabel" id="label-presenid"
			href="#posterMapPage" data-role="button">���\�ԍ�</a>
		<a class="changelabel" id="label-title"
			href="#posterMapPage" data-role="button">�^�C�g��</a>
		<a class="changelabel" id="label-authorname"
			href="#posterMapPage" data-role="button">��\�Җ�</a>
		<a class="changelabel" id="label-authorbelongs"
			href="#posterMapPage" data-role="button">����</a>
	</div>
</div>

<!-- �Z�b�V�����e�[�u�� -->
<!-- DEIM2014�̃Z�b�V�����e�[�u���̓��e -->
<div data-role="page" id="informationPage">
  <div data-role="header" data-position="fixed">
    <h1 id="sessionHyou" style="text-align:center">�v���O����</h1>
  </div>
  <div data-role="content">
    <!--&lt;!&ndash;date�ؑփ{�^��&ndash;&gt; -->
    <!--<p id="changeDateButton" data-role="controlgroup" data-type="horizontal" align="center">-->
        <!--<a id="changeDate01" class="sessiontable1" href="#sessiontable1" data-role="button">3��2��</a>-->
        <!--<a id="changeDate02" class="sessiontable2" href="#sessiontable2" data-role="button">3��3��</a>-->
        <!--<a id="changeDate03" class="sessiontable3" href="#sessiontable3" data-role="button">3��4��</a>-->
      <!--</p>-->
    <!--<h3 align="center" id="sessionDate"></h3>-->
      <!--&lt;!&ndash; �Z�b�V�����e�[�u���{�� &ndash;&gt;-->
      <!--<div id="sessiontables">-->
      <!--<div id="sessiontable1" class="sessiontable">-->
        <!--<table class="session_table">-->
          <!--<tr><th>����</th><th>���</th><th>���e</th></tr>-->
          <!--<tr><th  class="showtime" rowspan="7" bgcolor="blue">13:00<br />-<br />14:30</th><td><a class="jumpToVenue">A</a></td><td><a id="presenlinkA1" class="jumpToPresen">A1�FQA�EEC�T�C�g</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">B</a></td><td><a id="presenlinkB1" class="jumpToPresen">B1�F���`���E�N���E�h�\�[�V���O</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">C</a></td><td><a id="presenlinkC1" class="jumpToPresen">C1�F�H�E���V�s���</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">D</a></td><td><a id="presenlinkD1" class="jumpToPresen">D1�F�g�s�b�N����</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">E</a></td><td><a id="presenlinkE1" class="jumpToPresen">E1�F�N���E�h�EIoT</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">F</a></td><td><a id="presenlinkF1" class="jumpToPresen">F1�F���y��񏈗�</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">G</a></td><td><a id="presenlinkG1" class="jumpToPresen">G1�F�v���C�o�V�[(1)</a></td></tr>-->
          <!--<tr><td class="rest" colspan="3"�@bgcolor="red">�x�e</td></tr>-->
          <!--<tr><th  class="showtime" rowspan="7" bgcolor="blue">14:45<br />-<br />16:15</th><td><a class="jumpToVenue">A</a></td><td><a id="presenlinkA2" class="jumpToPresen">A2�F�e�L�X�g�}�C�j���O</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">B</a></td><td><a id="presenlinkB2" class="jumpToPresen">B2�F��񐄑E(1)</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">C</a></td><td><a id="presenlinkC2" class="jumpToPresen">C2�F�l�b�g���[�N�E�Z���V���O</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">D</a></td><td><a id="presenlinkD2" class="jumpToPresen">D2�F�f�[�^����</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">E</a></td><td><a id="presenlinkE2" class="jumpToPresen">E2�F�}�C�j���O�E����</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">F</a></td><td><a id="presenlinkF2" class="jumpToPresen">F2�F���摜�f�[�^����</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">G</a></td><td><a id="presenlinkG2" class="jumpToPresen">G2�F�v���C�o�V�[(2-->
          	<!--)</a></td></tr>-->

          <!--<tr><td class="rest" colspan="3"�@>�x�e</td></tr>-->
          <!--<tr><th  class="showtime" rowspan="7" bgcolor="blue">16:30<br />-<br />18:00</th><td><a class="jumpToVenue">A</a></td><td><a id="presenlinkA3" class="jumpToPresen">A3:��񌟍�</a><p class="phdsession">�iPh.D�Z�b�V�����j</p></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">B</a></td><td><a id="presenlinkB3" class="jumpToPresen">B3:��񐄑E(2)</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">C</a></td><td><a id="presenlinkC3" class="jumpToPresen">C3:�ȓd��</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">D</a></td><td><a id="presenlinkD3" class="jumpToPresen">D3:���[�U�[���r���[</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">E</a></td><td><a id="presenlinkE3" class="jumpToPresen">E3:���\���f�[�^�E�I�[�v���f�[�^</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">F</a></td><td><a id="presenlinkF3" class="jumpToPresen">F3:�w�p���</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">G</a></td><td><a id="presenlinkG3" class="jumpToPresen">G3:GPU�E�X�g���[�W</a></td></tr>-->
          <!--<tr><td class="rest" colspan="3"�@>�x�e</td></tr>-->
          <!--<tr style="height:30px"><th class="showtime">19:00<br />-<br />21:00</th><td class="banquetRoom"><a class="jumpToVenue">���e����</a></td><td>�C���^���N�e�B�u<br />�Z�b�V����(1)</td></tr>-->
          <!--<tr>-->
          	<!--<th  class="showtime" >21:00<br />-<br />23:30</th>-->
            <!--<td colspan="2"�@>�����O���T�[�`���[�f�B�X�J�b�V����</td>-->
          <!--</tr>-->
        <!--</table>-->
      <!--</div>-->
      <!--&lt;!&ndash;�����&ndash;&gt; -->
      <!--<div id="sessiontable2" class="sessiontable">-->
        <!--<table class="session_table">-->
          <!--<tr><th>����</th><th>���</th><th>���e</th></tr>-->
          <!--<tr><th  class="showtime" rowspan="7" >8:45<br />-<br />10:15</th><td><a class="jumpToVenue">A</a></td><td><a id="presenlinkA4" class="jumpToPresen">A4:Web���V�X�e��<p class="phdsession">�iPh.D�Z�b�V�����j</p></a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">B</a></td><td><a id="presenlinkB4" class="jumpToPresen">B4:��񒊏o</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">C</a></td><td><a id="presenlinkC4" class="jumpToPresen">C4:�}�C�N���u���O(1)</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">D</a></td><td><a id="presenlinkD4" class="jumpToPresen">D4:���M����</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">E</a></td><td><a id="presenlinkE4" class="jumpToPresen">E4:�f�[�^�������</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">F</a></td><td><a id="presenlinkF4" class="jumpToPresen">F4:HCI</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">G</a></td><td><a id="presenlinkG4" class="jumpToPresen">G4:�f�[�^�}�C�j���O�E�}�C�N���u���O</a></td></tr>-->
          <!--<tr><td class="rest" colspan="3"�@bgcolor="red">�x�e</td></tr>-->
          <!--<tr><th  class="showtime" rowspan="7">10:30<br />-<br />12:00</th><td><a class="jumpToVenue">A</a></td><td><a id="presenlinkA5" class="jumpToPresen">A5:�f�[�^�}�C�j���O(1)<p class="phdsession">�iPh.D�Z�b�V�����j</p></a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">B</a></td><td><a id="presenlinkB5" class="jumpToPresen">B5:��񌟍����p</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">C</a></td><td><a id="presenlinkC5" class="jumpToPresen">C5:�N�G�����x��</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">D</a></td><td><a id="presenlinkD5" class="jumpToPresen">D5:�h�L�������g�Ƌ@�B�w�K</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">E</a></td><td><a id="presenlinkE5" class="jumpToPresen">E5:�O���t�ƕ��U����</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">F</a></td><td><a id="presenlinkF5" class="jumpToPresen">F5:����Ɗ���</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">G</a></td><td><a id="presenlinkG5" class="jumpToPresen">G5:��Ï��</a></td></tr>-->
          <!--<tr><td class="rest">12:00<br />-<br />13:00</td><td class="rest" colspan="2"�@>���H�i�{DBS�^�c�ψ���/DE���ψ���j</td></tr>-->
          <!--<tr><th  class="showtime" rowspan="7" >13:00<br />-<br />14:30</th><td><a class="jumpToVenue">A</a></td><td><a>A6:�f�[�^�}�C�j���O(2)(Ph.D�Z�b�V����)</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">B</a></td><td><a id="presenlinkB6" class="jumpToPresen">B6:���U�����E�Ǘ�</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">C</a></td><td><a id="presenlinkC6" class="jumpToPresen">C6:�N���E�h�\�[�V���O�ESNS</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">D</a></td><td><a id="presenlinkD6" class="jumpToPresen">D6:OLAP</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">E</a></td><td><a id="presenlinkE6" class="jumpToPresen">E6:�O���t�}�C�j���O</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">F</a></td><td><a id="presenlinkF6" class="jumpToPresen">F6:�ʒu���</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">G</a></td><td><a id="presenlinkG6" class="jumpToPresen">G6:�Ȋw�E��Ãf�[�^�}�C�j���O</a></td></tr>-->
          <!--<tr><td class="rest" colspan="3"�@>�x�e</td></tr>-->
          <!--<tr><th class="showtime">14:45<br />-<br />16:35</th><td><a class="jumpToVenue">A�EB</a></td><td>���ҍu��</td></tr>-->
          <!--<tr><td class="rest" colspan="3"�@>�x�e</td></tr>-->
          <!--<tr><th class="showtime">16:45<br />-<br />18:15</th>-->
          <!--<td><a class="jumpToVenue">A�EB</a></td><td>DBSJ�A���[<br />�E���J�܋L�O�u��</td></tr>-->
          <!--<tr><td class="rest" colspan="3"�@>�x�e</td></tr>-->
          <!--<tr>-->
            <!--<th  class="showtime"  >19:00<br />-<br />21:00</th>-->
            <!--<td class="banquetRoom"><a class="jumpToVenue">���e����</a></td>-->
            <!--<td>�C���^���N�e�B�u<br />�Z�b�V�����i�Q�j</td>-->
          <!--</tr>-->
          <!--<tr>-->
            <!--<th  class="showtime">21:00<br />-<br />22:00</th>-->
            <!--<td><a class="jumpToVenue">���e����</a></td>-->
            <!--<td>BoF�Z�b�V����</td>-->
          <!--</tr>-->
          <!--<tr>-->
          	<!--<th  class="showtime" >22:00<br />-<br />23:30</th>-->
            <!--<td colspan="2"�@>�����O���T�[�`���[�f�B�X�J�b�V����</td>-->
          <!--</tr>-->
        <!--</table>-->
      <!--</div>-->
      <!--&lt;!&ndash;�O����&ndash;&gt; -->
      <!--<div id="sessiontable3" class="sessiontable">-->
        <!--<table class="session_table">-->
          <!--<tr><th>����</th><th>���</th><th>���e</th></tr>-->
          <!--<tr><th  class="showtime" rowspan="6" >8:45<br />-<br />10:15</th><td><a class="jumpToVenue">A�EB</a></td><td><a id="presenlinkB7" class="jumpToPresen">���ʃZ�b�V����</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">C</a></td><td><a id="presenlistC7" class="jumpToPresen">C7:�ЊQ���</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">D</a></td><td><a id="presenlistD7" class="jumpToPresen">D7:��i�I���p</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">E</a></td><td><a id="presenlistE7" class="jumpToPresen">E7:�v���b�g�t�H�[���Z�p</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">F</a></td><td><a id="presenlistF7" class="jumpToPresen">F7:�n���E�ό�</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">G</a></td><td><a id="presenlinkG7" class="jumpToPresen">G7:�ό����</a></td></tr>-->
          <!--<tr><td class="rest" colspan="3"�@bgcolor="red">�x�e</td></tr>-->
          <!--<tr><th  class="showtime" rowspan="7">10:30<br />-<br />12:00</th><td><a class="jumpToVenue">A</a></td><td><a id="presenlistA8" class="jumpToPresen">A8:�}�C�N���u���O(2)</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">B</a></td><td><a id="presenlistB8" class="jumpToPresen">B8:���y�E���搄�E</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">C</a></td><td><a id="presenlistC8" class="jumpToPresen">C8:�C�x���g���o�ƒn�����</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">D</a></td><td><a id="presenlistD8" class="jumpToPresen">D8:SNS���[�U���</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">E</a></td><td><a id="presenlistE8" class="jumpToPresen">E8:��񒊏o�E����</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">F</a></td><td><a id="presenlistF8" class="jumpToPresen">F8:���n��f�[�^</a></td></tr>-->
          <!--<tr><td><a class="jumpToVenue">G</a></td><td><a id="presenlinkG8" class="jumpToPresen">G8:���R���ꏈ��</a></td></tr>-->
       <!-- -->
          <!--<tr>-->
          	<!--<th id="closingH" class="showtime" >12:00<br />-<br />12:15</th>-->
          	<!--<td class="closingD" ><a class="jumpToVenue">A�EB</a></td>-->
          	<!--<td class="closingD" >�N���[�W���O<br />�\����</td>-->
          <!--</tr>-->
          <!--<tr>-->
          	<!--<th  class="showtime" >12:15<br />-<br />13:15</th>-->
          	<!--<td  colspan="2"�@>���H�i�{�R�����e�[�^�ψ���j</td>-->
          <!--</tr>-->

        <!--</table>-->
      <!--</div>-->
      <!--</div>-->
  </div>
  	<!-- �^�u�o�[ -->
	<!-- <div class="tabbar"></div> -->
	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="nav-tabicon" style="position:fixed; bottom:0px">
		<div data-role="navbar" height="100%" class="nav-tabicon" data-grid="d">
			<ul>
				<li><a class="topPageButton" id="totoppage" data-icon="toppage">�g�b�v</a></li>
				<li><a class="informationPageButton" id="information" data-icon="informationgray">TimeTable</a></li>
				<li><a class="venuePageButton"  id="venue"  data-icon="venue" >���}</a></li>
				<li><a class="presenListPageButton" id="list" data-icon="list">���\�ꗗ</a></li>
				<li><a class="posterMapPageButton" id="map" data-icon="map">�|�X�^�[</a></li>
			</ul>
		</div>
	</div>
</div>

<!-- ���p���O�f�[�^��������_�C�A���O  -->
<div data-role="dialog" data-close-btn="none" id="checkCollectLogDialog">
	<div data-role="header">
		<h1>���O���M�Ɋւ��邨�肢</h1>
	</div>
	<div data-role="content">
		�}�g��w���xIT�R�[�X�E�`�[��S.A.Y.�ł́A���[�U�̍s�����͂��s���A�v���̉��P�����錤�����s���Ă���܂��B���܂��ẮA�{�A�v���̗��p���O�̉���ɂ����͒��������ƍl���Ă���܂��B���p���O�ɂ͌l�����ł�����͊܂܂ꂸ�A���v�I�ȕ��݂͂̂Ɏg�p���܂��B�����͒�����ꍇ�́A[�͂�]�{�^���������ĉ������B<br />
		<a data-role="button" id="acceptCollectLog">�͂�</a>
		<a data-role="button" id="denyCollectLog">������</a>
	</div>
</div>

<!-- ���[�U�J�e�S���I���_�C�A���O -->
<div data-role="dialog" data-close-btn="none" id="selectUserCategoryDialog">
	<div data-role="header">
		<h1>���[�U�����̑I��</h1>
	</div>
	<div data-role="content">
		�ȉ��̒��ŁA���Ă͂܂鑮����I�����ĉ������B<br />
		<a data-role="button" class="selectUserCategoryButton" id="usercat-1">���\��</a>
		<a data-role="button" class="selectUserCategoryButton" id="usercat-2">�����E�R�����e�[�^</a>
		<a data-role="button" class="selectUserCategoryButton" id="usercat-3">����ȊO�̎Q����</a>
		<a data-role="button" class="selectUserCategoryButton" id="usercat-4">���̑�</a>
	</div>
</div>

<!-- �_�E�����[�h���s�����_�C�A���O  -->
<div data-role="dialog" data-close-btn="none" id="downloadFailDialog">
	<div data-role="header">
		<h1>�ǂݍ��݂Ɏ��s���܂���</h1>
	</div>
	<div data-role="content">
		�ǂݍ��݂Ɏ��s���܂����B<br />
		������x�擾���܂����H<br />
		<a data-role="button" id="ReDownload">�͂�</a>
		<a data-role="button" id="CancelDownload">������</a>
	</div>
</div>

<!-- �����̑傫���𒲂ׂ�pdiv -->
<div id="emScale"></div>

</body>
</html>
