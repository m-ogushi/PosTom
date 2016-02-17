<script type="text/javascript">
	var schedules = <?php echo json_encode($schedules, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
	var rooms = <?php echo json_encode($rooms, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
	var name, session_id;
	var day_diff = <?php echo $day_diff; ?>;
	$(function(){
	// ダッシュボードのPresentationを選択状態にする
		$('#dashboard #gNav #gNavSch').addClass('current');
	});
	// 「Add Presentation From CSV File」ボタンを押すと、ファイル選択ボタンを作動させる
	function selectFile(){
		$('#selectFile').trigger('click');
	}
	/**************************************************
	**********************フォーマットの仕様表示非表示*****
	***************************************************/
	function disp(){
		$('#check-specification').css("cursor","pointer");
		slideDown($('#specifications'));

	}
	function undisp(){
		$('#specifications').css('display', 'none');
	}



	// popover
	$(document).ready(function(){
		// roomsを並び替える
		var sorted_room = [];
		for(var r_count=0; r_count<rooms.length; r_count++){
			for(rooms_count=0; rooms_count<rooms.length; rooms_count++){
				if(rooms[rooms_count]["Room"]["order"] == r_count+1+""){
					sorted_room.push(rooms[rooms_count]);
				}
			}
		}
		rooms = sorted_room;
		$('[data-toggle="popover"]').popover({container: 'body'});
		// cakeのtimeフォームは要素が変だから変更
		for (var i = 13; i < 25; i++) {
			$("#startHour").append($("<option>").val(i).text(i));
			$("#endHour").append($("<option>").val(i).text(i));
		};
		$('#startMeridian').remove();
		$('#endMeridian').remove();
		// イベントリスナー登録
		var dragElement = null, items = document.getElementsByClassName('room'), overItem = document.getElementsByClassName('drop-target');
		Array.prototype.forEach.call(items, function (item) {
			item.addEventListener('dragstart', dragStartHandler);
		});
		Array.prototype.forEach.call(overItem, function (item) {
			item.addEventListener('dragover', dragOverHandler);
			item.addEventListener('dragleave', dragLeaveHandler);
			item.addEventListener('drop', dropHandler);
		});
	});

	//room button drag and drop
	function dragStartHandler(event) {
		dragElement = event.target;
		event.dataTransfer.setData('dragItem', dragElement.innerHTML);
	}

	function dragOverHandler(event) {
		event.preventDefault();
		$(event.target).removeClass('hidden');
		$("#"+event.target.id).css('color', 'Blue');
	}
	function dragLeaveHandler(event) {
		event.preventDefault();
		$("#"+event.target.id).css('color', 'White');
	}

	function dropHandler(event) {
		$("#"+event.target.id).css('color', 'White');
		var dropElement = event.target;
		var drop = dropElement.id;
		var drag = dragElement.id;
		var drag_id = drag.split("-");
		var drop_id = drop.split("-");
		var drag_num = Number(drag_id[1]);
		var drop_num = Number(drop_id[1]);
		if(drag_check(drag_num, drop_num)){
			$('#from-order').val(drag_num);
			$('#to-order').val(drop_num);
			// var obj = document.getElementById("order-change-sub");
			$('#room-order-change').submit();
		}
		event.stopPropagation();
	}

	// session追加、編集用モーダル
	$(function(){
	// 「.modal-open」をクリック
	$('.session-modal-open').click(function(){
		// overflow: hidden
		$('html, body').addClass('lock');
		// 押されたボタンを認識してaddかeditか分岐、h2とformのvalue変更
		name = this.name;
		if(name == "add-new-session"){
			// modal window内のdeleteボタンを非表示にする
			$('#session_delete_btn').hide();
		$("#session-add-edit").text("Add New Session");
			var room = (this.id).slice(7);
			$('#room').val(room);
			$('#order').val("");
			$('#category').val("");
			$('#chair-name').val("");
			$('#chair-affili').val("");
			$('#com-name').val("");
			$('#com-affili').val("");
			$('#date').val("");
			$('#startHour').val("10");
			$('#startMinute').val("00");
			$('#endHour').val("11");
			$('#endMinute').val("30");
			// controllerでの判別用隠しデータflag_orAdd
			$('#root_flag').val("add-session");
			$('#id').val("");
		}else{
			// deleteボタン表示
			$('#session_delete_btn').show();
			$("#session-add-edit").text("Edit Session");
			session_id = (this.id).slice(3);
			// idに合致するセッションを検索
			var session = schedules.filter(function (elem, i){
				return elem.Schedule.id == session_id;
			});
			session = session[0].Schedule;
			var start = session.start_time.split(":");
			var end = session.end_time.split(":");
			$('#room').val(session.room);
			$('#order').val(session.order);
			$('#category').val(session.category);
			$('#chair-name').val(session.chairperson_name);
			$('#chair-affili').val(session.chairperson_affiliation);
			$('#com-name').val(session.commentator_name);
			$('#com-affili').val(session.commentator_affiliation);
			$('#date').val(session.date);
			$('#startHour').val(start[0]);
			$('#startMinute').val(start[1]);
			$('#endHour').val(end[0]);
			$('#endMinute').val(end[1]);
			// controllerでの判別用隠しデータflag_orAdd
			$('#root_flag').val("update-session");
			$('#id').val(session.id);

		}
		// オーバーレイ用の要素を追加
		$('body').append('<div class="modal-overlay"></div>');
		// オーバーレイをフェードイン
		$('.modal-overlay').fadeIn('slow');

		// モーダルコンテンツのIDを取得
		var modal = '#' + $(this).attr('data-target');
		// モーダルコンテンツの表示位置を設定
		modalResize();
		 // モーダルコンテンツフェードイン
		$(modal).fadeIn('slow');

		// 「.modal-overlay」あるいは「.modal-close」をクリック
		$('.modal-overlay, .modal-close').off().click(function(){
			// エラーボックス非表示
			$('.error-messages').addClass('disno');
			// 固定解除
			$('html, body').removeClass('lock');
			// モーダルコンテンツとオーバーレイをフェードアウト
			$(modal).fadeOut('slow');
			$('.modal-overlay').fadeOut('slow',function(){
				// オーバーレイを削除
				$('.modal-overlay').remove();
			});
		});

		// リサイズしたら表示位置を再取得
		$(window).on('resize', function(){
			modalResize();
		});

		// モーダルコンテンツの表示位置を設定する関数
		function modalResize(){
			// ウィンドウの横幅、高さを取得
			var w = $(window).width();
			var h = $(window).height();

			// モーダルコンテンツの表示位置を取得
			var x = (w - $(modal).outerWidth(true)) / 2;
			var y = (h - $(modal).outerHeight(true)) / 2;

			// モーダルコンテンツの表示位置を設定
			$(modal).css({'left': x + 'px','top': y + 'px'});
		}
	});
});
	// sessionのバリデーション
	$(function(){
		$('#ScheduleSaveRootingForm').submit(function(){
			// エラーメッセージを空に
			err_box = $('.error-messages');
			err_box.empty();
			// 要素が空でないか
			if($('#room').val() == "" || $('#order').val() == "" || $('#category').val() == "" || $('#date').val() == ""){
				err_elm = $('<p>').text("Unjust blank.");
				err_box.append(err_elm);
				slideDown(err_box);
				return false;
			}
			// 座長は一人か
			if(!chairperson_check()){
				err_elm = $('<p>').text("Chairperson is one.");
				err_box.append(err_elm);
				slideDown(err_box);
				return false;
			}
			// 時間の開始終了が逆転していないか
			if(!session_time_check()){
				err_elm = $('<p>').text("Unjust session time.");
				err_box.append(err_elm);
				slideDown(err_box);
				return false;
			}
			// 他の時間とかぶっていないか
			if(!othersession_cover_check()){
				err_elm = $('<p>').text("This session covers with the time of the other session.");
				err_box.append(err_elm);
				slideDown(err_box);
				return false;
			}
			// 存在するroom, orderの組み合わせじゃないか
			if(!session_order_check()){
				err_elm = $('<p>').text("This order is already exist in this room.");
				err_box.append(err_elm);
				slideDown(err_box);
				return false;
			}
			// 存在する日にちかチェック
			var d = Number($('#date').val());
			if($('#date').val() == "" || d > day_diff || d <= 0){
				err_elm = $('<p>').text("The date is not exist.");
				err_box.append(err_elm);
				slideDown(err_box);
				return false;
			}
		});
	});
	function chairperson_check(){
		var person = $('#chair-name').val();
		var affili = $('#chair-affili').val();
		if(person.indexOf(',') == -1 && affili.indexOf(',') == -1){
			return true;
		}
		return false;
	}
	function othersession_cover_check(){
		// 変更しようとする時間を格納
		check_start_hour = $('#startHour').val();
		check_start_min = $('#startMinute').val();
		check_end_hour = $('#endHour').val();
		check_end_min = $('#endMinute').val();
		var check_start = check_start_hour * 60 + check_start_min * 1;
		var check_end = check_end_hour * 60 + check_end_min * 1;
		for(var sch_count=0; sch_count<schedules.length; sch_count++){
			var target_start = strToMin(schedules[sch_count]['Schedule']['start_time']);
			var target_end = strToMin(schedules[sch_count]['Schedule']['end_time']);
			// dateとroomが同一のものだけ比較
			if($('#date').val() == schedules[sch_count]['Schedule']['date'] && $('#room').val() == schedules[sch_count]['Schedule']['room'] && $('#id').val() != schedules[sch_count]['Schedule']['id']){
				// 開始時刻が重なる場合
				if(target_start < check_start && check_start < target_end){
					return false;
				}
				// 終了時刻が重なる場合
				if(target_start < check_end && check_end < target_end){
					return false;
				}
				// sessionを内包してしまう場合
				if(check_start <= target_start && target_end <= check_end){
					return false;
				}
			}
			if($('#date').val() == schedules[sch_count]['Schedule']['date'] && $('#room').val() == 'ALL' && $('#id').val() != schedules[sch_count]['Schedule']['id']){
				// 開始時刻が重なる場合
				if(target_start < check_start && check_start < target_end){
					return false;
				}
				// 終了時刻が重なる場合
				if(target_start < check_end && check_end < target_end){
					return false;
				}
				// sessionを内包してしまう場合
				if(check_start <= target_start && target_end <= check_end){
					return false;
				}
			}
			if($('#date').val() == schedules[sch_count]['Schedule']['date'] && schedules[sch_count]['Schedule']['room'] == 'ALL' && $('#id').val() != schedules[sch_count]['Schedule']['id']){
				// 開始時刻が重なる場合
				if(target_start < check_start && check_start < target_end){
					return false;
				}
				// 終了時刻が重なる場合
				if(target_start < check_end && check_end < target_end){
					return false;
				}
				// sessionを内包してしまう場合
				if(check_start <= target_start && target_end <= check_end){
					return false;
				}
			}
		}
		return true;
	}
	// 文字列をもらって0時からの分数を計算して返す
	function strToMin(timeStr){
		timeStr = timeStr.split(":");
		min = timeStr[0]*60 + timeStr[1]*1;
		return min;
	}
	function session_order_check(){
		for(var sch_count=0; sch_count<schedules.length; sch_count++){
			if($('#room').val() == schedules[sch_count]['Schedule']['room'] && $('#order').val() == schedules[sch_count]['Schedule']['order'] && $('#id').val() != schedules[sch_count]['Schedule']['id']){
				if($('#order').val() != 0){
					return false;
				}
			}
		}
		return true;
	}
	function session_time_check(){
		var start_hour = Number($('#startHour').val());
		var start_min = Number($('#startMinute').val());
		var end_hour = Number($('#endHour').val());
		var end_min = Number($('#endMinute').val());

		// 開始時間と終了時間があり得る時間ならtrue
		if((end_hour * 60 + end_min)-(start_hour * 60 + start_min) > 0){
			return true;
		}else{
			return false;
		}
	}
	function slideDown(slideEle){
		slideEle.slideDown(300).removeClass('disno');
	}
	// session deleteボタンのconfirm
	function confirm_del_session(){
		if(window.confirm('Do you really delete this session ?')){
			$('#root_flag').val("delete-session");
			return true;
		}
		return false;
	}
	// roomのsave時バリデーション
	$(function(){
		$('#room_save_btn').click(function(){
			// エラーメッセージを空に
			err_box = $('.error-messages');
			err_box.empty();
			// empty error
			if($('#r-name').val() == ""){
					err_elm = $('<p>').text("Room name is empty.");
					err_box.append(err_elm);
					slideDown(err_box);
				return false;
			}
			// 予約語ALLを使わせない
			if($('#r-name').val().toLowerCase() == "all"){
					err_elm = $('<p>').text("~ALL~ is reserved word.");
					err_box.append(err_elm);
					slideDown(err_box);
				return false;
			}
			// 既に存在するroom名は弾く
			var check = true, r_count=0;
			for(r_count=0; r_count<rooms.length; r_count++){
				if($('#r-name').val() == rooms[r_count]['Room']['name']){
					err_elm = $('<p>').text("This room name already exist.");
					err_box.append(err_elm);
					slideDown(err_box);
					return false;
				}
			}
		});
	});
	// roomの入れ替え判定
	function drag_check(dra, dro){
		if(dra != dro && dra + 1 != dro){
			return true;
		}
	}

	// room編集、追加用modal
	$(function(){
	// 「.modal-open」をクリック
	$('.room-modal-open').click(function(){
		// overflow: hidden
		$('html, body').addClass('lock');
		// 押されたボタンを認識してaddかeditか分岐、h2とformのvalue変更
		var btn_id = this.id;
		if(btn_id == "add-new-room"){
			// 最後のorderに追加するのでroomのサイズを調べる
			var r_count = searchRoom()
			// modal window内のdeleteボタンを非表示にする
			$('#room_delete_btn').hide();
			$("#room-add-edit").text("Add New Room");
			$('#r-name').val("");
			// controllerでの判別用隠しデータflag_orAdd
			$('#r-root_flag').val("add-room");
			$('#r-id').val("");
			$('#r-order').val(r_count);
		}else{
			// deleteボタン表示
			$('#room_delete_btn').show();
			btn_id = btn_id.split("-");
			btn_id = btn_id[1];
			var r = rooms[btn_id]['Room'];
			$("#room-add-edit").text("Edit Room");
			$('#r-name').val(r['name']);
			// controllerでの判別用隠しデータflag_orAdd
			$('#r-root_flag').val("update-room");
			$('#r-id').val(r['id']);
			$('#r-order').val(Number(btn_id) + 1);
			$('#before').val(r['name']);

		}
		// オーバーレイ用の要素を追加
		$('body').append('<div class="modal-overlay"></div>');
		// オーバーレイをフェードイン
		$('.modal-overlay').fadeIn('slow');

		// モーダルコンテンツのIDを取得
		var modal = '#' + $(this).attr('data-target');
		// モーダルコンテンツの表示位置を設定
		modalResize();
		 // モーダルコンテンツフェードイン
		$(modal).fadeIn('slow');

		// 「.modal-overlay」あるいは「.modal-close」をクリック
		$('.modal-overlay, .modal-close').off().click(function(){
			// エラーボックス非表示
			$('.error-messages').addClass('disno');
			// 固定解除
			$('html, body').removeClass('lock');
			// モーダルコンテンツとオーバーレイをフェードアウト
			$(modal).fadeOut('slow');
			$('.modal-overlay').fadeOut('slow',function(){
				// オーバーレイを削除
				$('.modal-overlay').remove();
			});
		});

		// リサイズしたら表示位置を再取得
		$(window).on('resize', function(){
			modalResize();
		});

		// モーダルコンテンツの表示位置を設定する関数
		function modalResize(){
			// ウィンドウの横幅、高さを取得
			var w = $(window).width();
			var h = $(window).height();

			// モーダルコンテンツの表示位置を取得
			var x = (w - $(modal).outerWidth(true)) / 2;
			var y = (h - $(modal).outerHeight(true)) / 2;

			// モーダルコンテンツの表示位置を設定
			$(modal).css({'left': x + 'px','top': y + 'px'});
		}

	});
});
		function searchRoom(){
			for(var count in rooms){
			}
			count = Number(count) + 2;
			if(rooms.length == 0){
				count = 1;
			}
			return count;
		}
		// room deleteボタンのconfirm
		function confirm_del_room(){
			if(window.confirm('All session of this room will be deleted\nDo you really delete this room ?')){
				$('#r-root_flag').val("delete-room");
				return true;
			}
			return false;
		}
		// room edit save ボタンのconfirm
		function confirm_edit_room(){
			if($('#r-root_flag').val() == "update-room"){
				if(window.confirm('All session name of this room will be changed\nDo you really rename this room ?')){
					return true;
				}
				return false;
			}
		}
</script>
<?php
echo $this->Html->css('page_schedule');
?>
<h2>Import the session list</h2>
<p>・The data is saved as UTF-8 encoded CSV file.</p>
<p class="formatDownload">・<a href="<?php echo $this->Html->webroot;?>format/session_format.csv">Download the sample session list file</a></p>
	<p style="display:inline;">・</p><p id="check-specification" onmouseover="disp()" onmouseout="undisp()" style="display:inline;">A session includes the following attributes:</p>
<div id="specifications" div style="display:none">
	<p>  Room (required) :</p>
	<p>  Session number (required) : the number of session in the room.</p>
	<p>  Date (required): "1" means the first day, "2" means the second day.</p>
	<p>  Session name (required):</p>
	<p>  Start-time, End time (required) : They are specified as "HH:MM"</p>
	<p>  Chairperson's name and the affiliation</p>
	<p>  Commentators' name and their affiliations: Commtators are separated by comma(",").</p>
</div>
<p>・Coffee breaks can be added by specifying "ALL" as the Room and "0" as the Session number.</p>

<p></p>
<p></p>
<br>
<br>
<p><?php echo $this->Html->tag('button', 'Add Session From CSV File', array('class'=>'btn btn-custom', 'onClick'=>"selectFile()")); ?></p>
<?php echo $this->Form->create('Schedule',array('action'=>'import','type'=>'file', 'name'=>'scheduleImport')); ?>
<?php echo $this->Form->input('CsvFile', array('label'=>'', 'type'=>'file', 'accept'=>'text/csv', 'class'=>'disno', 'id'=>'selectFile', 'onChange'=>'scheduleImport.submit()')); ?>
<?php echo $this->Form->end(array('label'=>'Upload', 'div'=> array('class' => 'disno'))); ?>
<p> </p>

<h2>Session</h2>
<!-- タブ設置-->
<ul class="nav nav-tabs">
	<?php
	for($i=1; $i<=$day_diff; $i++){
	$day = "$i";
	?>
	<li class="<?php
	if($i==1)
		echo 'active';
	else
		echo'';
	?>"><a href="#tab<?= $day; ?>" data-toggle="tab">Day <?= $day; ?></a><li>
	<?php } ?>
</ul>
<!-- 内容設置 -->
<div class="tab-content">
	<?php
	// start day loop
	for($i=1; $i<=$day_diff; $i++){
		$day = "$i";
		if($i == 1){
			$orActive = "tab-pane active";
		}else{
			$orActive = "tab-pane";
		}
	?>
<div class="<?= $orActive; ?>" id="tab<?= $day; ?>">
<!-- タブの内容 -->
<p> </p>
<div class="container" style="width: 1680px;">
<?php
	$first = '23:59:59';
	$end = '0:0:0';
	$roomGroup = array();
	// selectboxのオプションに使用
	$option = array();
	foreach ($schedules as $sch) :
		if($first >= $sch['Schedule']['start_time']){
			$first = $sch['Schedule']['start_time'];
		}
		if($end <= $sch['Schedule']['end_time']){
			$end = $sch['Schedule']['end_time'];
		}
	endforeach;
	// // roomGroupにorder順でroomを格納
	$roomOrder = 1;
	$escape = 0;
	while($roomOrder <= count($rooms)){
		foreach ($rooms as $room) :
			if($room['Room']['order'] == $roomOrder){
			array_push($roomGroup, $room['Room']['name']);
			$option[$room['Room']['name']] = $room['Room']['name'];
			$roomOrder++;
			}
			if($escape > 300){
				$roomOrder++;
			}
			$escape++;
		endforeach;
	}
	// roomの選択肢に昼休み等の例外ALLを追加
	array_push($option, array('ALL'=>'ALL'));

	$first = substr($first,0,2);
	$first = (Int)$first;
	// 最後のセッションがはみ出さないようにする
	if(substr($end,3,2) == '00'){
		$end = substr($end,0,2);
	}else{
		$end = substr($end,0,2);
		$end++;
	}
	$end = (Int)$end;
	$time = $first;
	// first: 時間軸の最初 end: 時間軸の最後 (Int)
	// 時間構成設置
	echo '<div class="time-group">';
	for ($time; $time <= $end; $time++){
			echo '<p id="'. $time .'">'. $time .':00</p>';
	}
	echo '</div>';

	// roomボタン設置 $roomGroupの要素の数だけ回す
	echo '<div class="room-group">';
	for($countRoom = 0; $countRoom < count($roomGroup); $countRoom++){
		echo '<button draggable="true" type="button" id="' . $roomGroup[$countRoom] . '-'. $countRoom .'" class="btn btn-info room room-modal-open" data-target="room-edit">' . $roomGroup[$countRoom] . '</button>';
	}
	// room 追加ボタン
	echo '<button type="button" id="add-new-room" class="btn btn-default room-modal-open" data-target="room-edit">+</button>';
	echo '</div>';

	// roomの並び替え用ターゲット
	$drop_tar_left = 59;
	for($countRoom = 0; $countRoom <= count($roomGroup); $countRoom++){
		echo '<div id="tar-'. $countRoom .'" class="drop-target" droppable="true">|</div>';
		// style部分
		echo '<style type="text/css">';
		echo '<!-- #tar-'. $countRoom .'{ position: absolute; left: '. $drop_tar_left .'px; opacity: 0;} -->';
		echo '</style>';
		$drop_tar_left += 115;
	}

	// セッション設置
	echo '<div class="session-group">';
	for ($j = 0; $j < count($schedules); $j++){
		$sch = $schedules[$j];
		$date = $sch['Schedule']['date'];
		if ($day == $date) {
			// 長いので先に格納
			$id = $sch['Schedule']['id'];
			$room = $sch['Schedule']['room'];
			$order = $sch['Schedule']['order'];
			$category = $sch['Schedule']['category'];
			$chairName = $sch['Schedule']['chairperson_name'];
			$chairAffili = $sch['Schedule']['chairperson_affiliation'];
			$commentatorName = $sch['Schedule']['commentator_name'];
			$commentatorAffili = $sch['Schedule']['commentator_affiliation'];
			$sessionStart = $sch['Schedule']['start_time'];
			$sessionEnd = $sch['Schedule']['end_time'];
			$eventId = $sch['Schedule']['event_id'];
			// hover用のセッション時間(秒数部分を削除)
			$start_hover = substr($sessionStart, 0, 5);
			$end_hover = substr($sessionEnd, 0, 5);
			// hover用のchairperson & commentator
			$cha_name_hover = split(",", $chairName);
			$cha_affili_hover = split(",", $chairAffili);
			$com_name_hover = split(",", $commentatorName);
			$com_affili_hover = split(",", $commentatorAffili);
			// chairperson $ commentator 出力用
			$cha = "Chair Person: <br>　";
			$com = "Commentator: <br>　";
			if(count($cha_name_hover) != 0){
				for($cha_count = 0; $cha_count < count($cha_name_hover); $cha_count++){
					$cha .= $cha_name_hover[$cha_count] . " (" . $cha_affili_hover[$cha_count] . ") ";
				}
				$cha = $cha . "<br>";
			}
			if(count($com_name_hover) != 0){
				for($com_count = 0; $com_count < count($com_name_hover); $com_count++){
					$com .= $com_name_hover[$com_count] . " (" . $com_affili_hover[$com_count] . ") ";
				}
				$com = $com . "<br>";
			}


			$session = $room.$order;
			$give_id = "id-".$id;
			if($room != "ALL"){
			echo '<button id='. $give_id .' name="session-'. $id .'" type="button" class="btn btn-default session session-modal-open" data-toggle="popover" data-trigger="hover" data-html="true" data-target="session-edit" data-placement="top" data-content="'. $session .': ' . $category . '<br>'. $start_hover . '~' . $end_hover . '<br>'. $cha .''. $com .'" >' . $session . ': ' . $category . '</button>';
			}else{
			echo '<button id='. $give_id .' name="session-'. $id .'" type="button" class="btn btn-default session session-modal-open" data-toggle="popover" data-trigger="hover" data-html="true" data-target="session-edit" data-placement="top" data-content="' . $category . '<br>'. $start_hover . '~' . $end_hover . '" >' . $category . '</button>';
			}
			// 時間、分を格納
			$sessionStartTime = (Int)substr($sessionStart,0,2);
			$sessionStartMin = (Int)substr($sessionStart,3,2);
			$sessionEndTime = (Int)substr($sessionEnd,0,2);
			$sessionEndMin = (Int)substr($sessionEnd,3,2);
			// 何分間のセッションか計算
			$sessionMin = ($sessionEndTime - $sessionStartTime) * 60 + ($sessionEndMin - $sessionStartMin);
			// 差分計算 一時間で90px
			$sessionWidth = $sessionMin / 60 * 90;
			// セッションの開始時間計算
			$top = 56 + (($sessionStartTime - $first) * 90) + ($sessionStartMin / 60) * 90;
			// 配列の何番目のroomか検索
			$roomN = array_search($room, $roomGroup);
			$left = 75 + ($roomN * 115);
			$all_session_width = count($roomGroup)*100 + (count($roomGroup)-1)*15;
			echo '<style type="text/css">';
			echo '<!-- #'. $give_id .'{ position: absolute; top: '. $top .'px; left: '. $left .'px; height: '. $sessionWidth .'px; } -->';
			if($room == "ALL"){
				echo '<!-- #'. $give_id .'{ width: '. $all_session_width .'px; background-color: #fff; } -->';
			}
			echo '</style>';
		}
	}
	echo '</div>'; // session-group end
	echo '</div>'; // tab-pane end
	// session追加ボタン設置
	echo '<div class="add-session-group">';
	$top = 570 + ($end - $first) * 90;
	// sessionが一つもない時用
	if(($end - $first) < 0){
		$top = 675;
	}
	$left = 240;
	for($countRoom = 0; $countRoom < count($roomGroup); $countRoom++){
		echo '<button type="button" id="add-in-' . $roomGroup[$countRoom] . '" name="add-new-session" class="btn btn-default session-modal-open" data-target="session-edit">＋</button>';
		$left += 115;
		echo '<style type="text/css">';

		echo '<!-- #add-in-' . $roomGroup[$countRoom] . '{ position: absolute; top: '. $top .'px; left: '. $left .'px; } -->';

		echo '</style>';
	}
	echo '</div>';
	?>
<?php
	echo '</div>'; // container end
	} // day loop end
?>

</div>  <!-- tab-content end -->

<!-- modal content session-->
<div id="session-edit" class="modal-content">
	<h2 id="session-add-edit"></h2>
	<div class="error-messages disno"></div>
<?php
	echo $this->Form->create('Schedule', array('action'=>'save_rooting'));
	echo $this->Form->input('room', array('id'=>'room', 'class'=>'form-control', 'options'=>$option, 'required' => false));
	echo $this->Form->input('order', array('id'=>'order','class'=>'form-control', 'required' => false, 'min'=>'0'));
	echo $this->Form->input('category', array('id'=>'category','class'=>'form-control','label'=>'Session Name', 'required' => false));
	echo '<fieldset class="chair">';
	echo '<legend>ChairPerson</legend>';
	echo $this->Form->input('chairperson_name', array('id'=>'chair-name','class'=>'form-control', 'required' => false, 'label' => 'Name'));
	echo $this->Form->input('chairperson_affiliation', array('id'=>'chair-affili','class'=>'form-control', 'required' => false, 'label' => 'Affiliation'));
	echo'</fieldset>';
	echo '<fieldset class="commentator">';
	echo '<legend>Commentator</legend>';
	echo $this->Form->input('commentator_name', array('id'=>'com-name','class'=>'form-control', 'required' => false, 'label' => 'Name'));
	echo $this->Form->input('commentator_affiliation', array('id'=>'com-affili','class'=>'form-control', 'required' => false, 'label' => 'Affiliation'));
	echo '</fieldset>';
	echo $this->Form->input('date', array('id'=>'date','class'=>'form-control', 'required' => false, 'min'=>'1'));
	echo $this->Form->input('start_time', array('id'=>'start','class'=>'form-control', 'required' => false));
	echo $this->Form->input('end_time', array('id'=>'end','class'=>'form-control', 'required' => false));
	echo $this->Form->input('root_flag', array('id'=>'root_flag', 'type'=>'hidden', 'required' => false));
	echo $this->Form->input('id', array('id'=>'id', 'type'=>'hidden', 'required' => false));
	echo '<div class="box-group">';
	echo $this->Form->submit('Save', array('id'=>'session_save_btn', 'class'=>'btn btn-primary'));
	echo '<button id="session_cancel_btn" type="button" class="btn btn-default modal-close">cancel</button>';
	echo $this->Form->submit('Delete', array('id'=>'session_delete_btn', 'class'=>'btn btn-danger', 'onclick'=>'return confirm_del_session();'));
	echo '</div>';
	echo $this->Form->end();
?>
</div>
<!-- modal content room-->
<div id="room-edit" class="modal-content">
	<h2 id="room-add-edit"></h2>
	<div class="error-messages disno"></div>
<?php
	echo $this->Form->create('Room', array('id'=>'room-edit-form' , 'action'=>'save_rooting', 'controller'=>'rooms'));
	echo $this->Form->input('name', array('id'=>'r-name', 'class'=>'form-control', 'required' => false));
	echo $this->Form->input('root_flag', array('id'=>'r-root_flag', 'type'=>'hidden', 'required' => false));
	echo $this->Form->input('id', array('id'=>'r-id', 'type'=>'hidden', 'required' => false));
	echo $this->Form->input('room_before', array('id'=>'before', 'type'=>'hidden', 'required' => false));
	echo $this->Form->input('order', array('id'=>'r-order', 'type'=>'hidden', 'required' => false));
	echo '<div class="box-group">';
	echo $this->Form->submit('Save', array('id'=>'room_save_btn', 'class'=>'btn btn-primary', 'onclick'=>'return confirm_edit_room();'));
	echo '<button id="room_cancel_btn" type="button" class="btn btn-default modal-close">cancel</button>';
	echo $this->Form->submit('Delete', array('id'=>'room_delete_btn', 'class'=>'btn btn-danger', 'onclick'=>'return confirm_del_room();'));
	echo '</div>';
	echo $this->Form->end();

?>
</div>
<div id="modal-overlay"></div>
<?php
	echo $this->Form->create('Room', array('id'=>'room-order-change' , 'action'=>'order_change', 'controller'=>'rooms'));
	echo $this->Form->input('from', array('id'=>'from-order', 'type'=>'hidden', 'required' => false));
	echo $this->Form->input('to', array('id'=>'to-order', 'type'=>'hidden', 'required' => false));
	echo $this->Form->submit('Save', array('type'=>'hidden'));
	echo $this->Form->end();
?>