<script type="text/javascript">
	$(function(){
	// ダッシュボードのPresentationを選択状態にする
		$('#dashboard #gNav #gNavSch').addClass('current');
	});
	// 「Add Presentation From CSV File」ボタンを押すと、ファイル選択ボタンを作動させる
	function selectFile(){
		$('#selectFile').trigger('click');
	}
	$(document).ready(function(){
		$('[data-toggle="popover"]').popover({container: 'body'});
	});
</script>
<?php
echo $this->Html->css('page_schedule');
?>
<h2>CSV Import</h2>
<p>CSV Format is Room, Order, Date, Category, StartTime, EndTime, ChairpersonName, ChairpersonAffiliation, CommentatorsName, CommentatorsAffiliation</p>
<p class="formatDownload"><a href="<?php echo $this->Html->webroot;?>format/session_format.csv">Download CSV Sample</a></p>
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
	// 後述css生成部分でfirstTimeを使用
	$firstTime = $first;
	$first = substr($first,0,2);
	$first = (Int)$first;
	// 最後のセッションがはみ出さないようにする
	if(substr($end,3,2) == '00'){
		$end = substr($end,0,2);
	}else{
		$end = substr($end,0,2);
		$end++;
	}
	// 時間構成設置
	echo '<div class="time-group">';
	$venu = "";
	for ($first; $first <= $end; $first++){
			echo '<p id="'. $first .'">'. $first .':00</p>';
	}
	echo '</div>';
	// roomボタン設置
	echo '<div class="room-group">';
	for($countRoom = 0; $countRoom < count($roomGroup); $countRoom++){
		echo '<button type="button" id="' . $roomGroup[$countRoom] . '" class="btn btn-info room">' . $roomGroup[$countRoom] . '</button>';
	}
	echo '</div>';
	// セッション設置
	echo '<div class="session-group">';
	for ($j = 0; $j < count($schedules); $j++){
		$sch = $schedules[$j];
		if ($day == $sch['Schedule']['date']) {
			// $position = _calcPosition();
			$session = $sch['Schedule']['room'].$sch['Schedule']['order'];
			$id = $sch['Schedule']['room'].$sch['Schedule']['date'].$sch['Schedule']['order'];
			echo '<button type="button" id='. $id .' class="btn btn-default session" data-toggle="popover" data-trigger="hover" data-placement="top" data-content=" '. $sch['Schedule']['start_time'] . '~' . $sch['Schedule']['end_time'] . ' " >' . $session . ': ' . $sch['Schedule']['category'] . '</button>';
			// 秒数削除で格納
			$sessionStart = substr($sch['Schedule']['start_time'],0,5);
			$sessionEnd = substr($sch['Schedule']['end_time'],0,5);
			// 差分計算
			$sessionWidth = (strtotime($sessionEnd)-strtotime($sessionStart))/60/60*90;
			// セッションの開始時間計算
			$top = strtotime(substr($sch['Schedule']['start_time'],0,5)) - strtotime(substr($firstTime,0,5));
			$roomN = array_search($sch['Schedule']['room'], $roomGroup);
			$left = 75 + ($roomN * 114);
			$top = 56 + ($top / 60 / 60 * 90);
			echo '<style type="text/css">';
			echo '<!-- #'. $id .'{ position: absolute; top: '. $top .'px; left: '. $left .'px; height: '. $sessionWidth .'px; } -->';

			echo '</style>';
		}
	}
	echo '</div>'; // session-group end
	echo '</div>'; // tab-pane end
	echo '</div>'; // container end
	} // day loop end
?>
</div>  <!-- tab-content end -->
