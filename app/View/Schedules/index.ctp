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
<div class="btn-toolbar">
<?php
	$venue = "";
	// btn-groupを日数分追加
	for ($j = 0; $j < count($schedules); $j++) {
		$sch = $schedules[$j];
		if ($day == $sch['Schedule']['date']) {
			if ($venue != $sch['Schedule']['venue']) {
				$venue = $sch['Schedule']['venue'];
				echo '<div class="btn-group-vertical" role="group">';
				echo '<button type="button" class="btn btn-info btn-large">' . $sch['Schedule']['venue'] . '</button>';
			}
			echo '<button type="button" class="btn btn-default btn-large" data-toggle="popover" data-trigger="hover" data-placement="top" title="Category: '. $sch['Schedule']['category'] .'" data-content=" '. $sch['Schedule']['start_time'] . '~' . $sch['Schedule']['end_time'] . ' " >' . $sch['Schedule']['venue'] . '' . $sch['Schedule']['order'] . '</button>';
			if($j == count($schedules)-1 || $venue != $schedules[$j+1]['Schedule']['venue']){
				echo '</div>';  // button-group end
			}
		}
	}
	echo '</div>'; // tab-pane end
	echo '</div>'; // btn-toolbar end
	echo '</div>'; // container end
	} // day loop end
?>
</div>  <!-- tab-content end -->
