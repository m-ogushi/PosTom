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
<p>CSV Format is Number,Category,StartTime,EndTime,ChairpersonName,ChairpersonBelongs,CommentatorsName,CommentatorsBelongs</p>
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
	// 時間が最遅時間のセッションがあるroomを特定
	$max_room = "";
	$max_order = 0;
	foreach ($schedules as $sch) :
		if($day == $sch['Schedule']['date']){
			if($max_order < $sch['Schedule']['order']){
				$max_room = $sch['Schedule']['room'];
				$max_order = $sch['Schedule']['order'];
			}
		}
	endforeach;
	// 時間構成設置
	echo '<div class="time-group">';
	$venu = "";
	for ($j = 0; $j < count($schedules); $j++){
		$sch = $schedules[$j];
		if($day == $sch['Schedule']['date'] && $max_room == $sch['Schedule']['room']){
			echo '<p>'. substr($sch['Schedule']['start_time'], 0, 5) .' ~ '. substr($sch['Schedule']['end_time'], 0, 5) .'</p>';
		}
	}
	echo '</div>';

	// セッション設置
	$room = "";
	for ($j = 0; $j < count($schedules); $j++){
		$sch = $schedules[$j];
		if ($day == $sch['Schedule']['date']) {
			if ($room != $sch['Schedule']['room']){
				$room = $sch['Schedule']['room'];
				echo '<div class="btn-group-vertical">';
				echo '<button type="button" class="btn btn-info">' . $sch['Schedule']['room'] . '</button>';
			}
			echo '<button type="button" class="btn btn-default" data-toggle="popover" data-trigger="hover" data-placement="top" data-content=" '. $sch['Schedule']['start_time'] . '~' . $sch['Schedule']['end_time'] . ' " >' . $sch['Schedule']['room'] . '' . $sch['Schedule']['order'] . ': ' . $sch['Schedule']['category'] . '</button>';
			if($j == count($schedules)-1 || $room != $schedules[$j+1]['Schedule']['room']){
				echo '</div>';  // venu-group end
			}
		}
	}
	echo '</div>'; // tab-pane end
	echo '</div>'; // container end
	} // day loop end
?>
</div>  <!-- tab-content end -->
