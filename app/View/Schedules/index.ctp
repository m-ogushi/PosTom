<script type="text/javascript">
	var schedules = <?php echo json_encode($schedules, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
	var name, session_id;
	$(function(){
	// ダッシュボードのPresentationを選択状態にする
		$('#dashboard #gNav #gNavSch').addClass('current');
	});
	// 「Add Presentation From CSV File」ボタンを押すと、ファイル選択ボタンを作動させる
	function selectFile(){
		$('#selectFile').trigger('click');
	}
	// popover
	$(document).ready(function(){
		$('[data-toggle="popover"]').popover({container: 'body'});
		// cakeのtimeフォームは要素が変だから変更
		for (var i = 13; i < 25; i++) {
			$("#startHour").append($("<option>").val(i).text(i));
			$("#endHour").append($("<option>").val(i).text(i));
		};
		$('#startMeridian').remove();
		$('#endMeridian').remove();
	});

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
    		$('#delete-session').hide();
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
    		$('#delete-session').show();
			$("#session-add-edit").text("Edit Session");
			session_id = name.slice(8);
			var session = schedules.filter(function (elem, i){
				return elem.Schedule.id == session_id;
			});
			session = session[0].Schedule;
			// console.log(session.end_time);
			var start = session.start_time.split(":");
			var end = session.end_time.split(":");
			console.log(start);
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
	function confirm_del_session(){
		if(window.confirm('Do you really delete this session ?')){
			$('#root_flag').val("delete-session");
			return true;
		}
		return false;
	}
</script>
<?php
echo $this->Html->css('page_schedule');
?>
<h2>CSV Import</h2>
<p>CSV Format is Room, Order, Date, Category, StartTime, EndTime, ChairpersonName, ChairpersonAffiliation, CommentatorsName, CommentatorsAffiliation</p>
<p class="formatDownload"><a href="<?php echo $this->Html->webroot;?>format/session_format.csv">Download Format Sample</a></p>
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
<div class="container">
<?php
	$first = '23:59:59';
	$end = '0:0:0';
	$roomGroup = array();
	foreach ($schedules as $sch) :
		if($first >= $sch['Schedule']['start_time']){
			$first = $sch['Schedule']['start_time'];
		}
		if($end <= $sch['Schedule']['end_time']){
			$end = $sch['Schedule']['end_time'];
		}
		// 存在するroomを洗い出す
		if(!in_array($sch['Schedule']['room'], $roomGroup)){
			array_push($roomGroup, $sch['Schedule']['room']);
		}
	endforeach;
	sort($roomGroup);
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
		echo '<button type="button" id="' . $roomGroup[$countRoom] . '" class="btn btn-info room">' . $roomGroup[$countRoom] . '</button>';
	}
	echo '</div>';
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
			$give_id = $room.$date."-".$order;
			echo '<button id='. $give_id .' name="session-'. $id .'" type="button" class="btn btn-default session session-modal-open" data-toggle="popover" data-trigger="hover" data-html="true" data-target="session-edit" data-placement="top" data-content="'. $session .': ' . $category . '<br>'. $start_hover . '~' . $end_hover . '<br>'. $cha .''. $com .'" >' . $session . ': ' . $category . '</button>';
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

			echo '<style type="text/css">';
			echo '<!-- #'. $give_id .'{ position: absolute; top: '. $top .'px; left: '. $left .'px; height: '. $sessionWidth .'px; } -->';

			echo '</style>';
		}
	}
	echo '</div>'; // session-group end
	echo '</div>'; // tab-pane end
	// session追加ボタン設置
	echo '<div class="add-session-group">';
	$top = 540 + ($end - $first) * 90;
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

<!-- modal content -->
<div id="session-edit" class="modal-content">
	<h2 id="session-add-edit"></h2>
<?php
	echo $this->Form->create('Schedule', array('action'=>'save_rooting'));
	echo $this->Form->input('room', array('id'=>'room', 'class'=>'form-control', 'required' => false));
	echo $this->Form->input('order', array('id'=>'order','class'=>'form-control', 'required' => false));
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
	echo $this->Form->input('date', array('id'=>'date','class'=>'form-control', 'required' => false));
	echo $this->Form->input('start_time', array('id'=>'start','class'=>'form-control', 'required' => false));
	echo $this->Form->input('end_time', array('id'=>'end','class'=>'form-control', 'required' => false));
	echo $this->Form->input('root_flag', array('id'=>'root_flag', 'type'=>'hidden', 'required' => false));
	echo $this->Form->input('id', array('id'=>'id', 'type'=>'hidden', 'required' => false));
	echo '<div class="box-group">';
	echo $this->Form->submit('Save', array('id'=>'session_save_btn', 'class'=>'btn btn-primary inline'));
	echo '<button id="session_cancel_btn" type="button" class="btn btn-default modal-close">cancel</button>';
	echo $this->Form->submit('Delete', array('id'=>'session_delete_btn', 'class'=>'btn btn-danger inline', 'onclick'=>'return confirm_del_session();'));
	echo '</div>';
?>

</div>
<div id="modal-overlay"></div>
