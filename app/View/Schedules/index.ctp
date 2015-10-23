<script type="text/javascript">
$(function(){
	// ダッシュボードのPresentationを選択状態にする
	$('#dashboard #gNav #gNavSch').addClass('current');
});

// 「Add Presentation From CSV File」ボタンを押すと、ファイル選択ボタンを作動させる
function selectFile(){
	$('#selectFile').trigger('click');
}

</script>
<h2>CSV Import</h2>
<p>CSV Format is Number,Category,StartTime,EndTime,ChairpersonName,ChairpersonBelongs,CommentatorsName,CommentatorsBelongs</p>

<p><?php echo $this->Html->tag('button', 'Add Session From CSV File', array('class'=>'btn btn-custom', 'onClick'=>"selectFile()")); ?></p>
<?php echo $this->Form->create('Schedule',array('action'=>'import','type'=>'file', 'name'=>'scheduleImport')); ?>
<?php echo $this->Form->input('CsvFile', array('label'=>'', 'type'=>'file', 'accept'=>'text/csv', 'class'=>'disno', 'id'=>'selectFile', 'onChange'=>'scheduleImport.submit()')); ?>
<?php echo $this->Form->end(array('label'=>'Upload', 'div'=> array('class' => 'disno'))); ?>

<!-- <p> </p>
<h2>Session List</h2>
<table border="1">
    <thead>
        <tr>
            <th>No.</th>
            <th>Category</th>
			<th>ChairPerson</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($schedules as $schedule) :
		echo '<tr>';
		echo "<td>{$schedule['Schedule']['number']}</td>";
		echo "<td>{$schedule['Schedule']['category']}</td>";
		echo "<td>{$schedule['Schedule']['chairpersonName']}</td>";
		echo '</tr>';
		endforeach;
        ?>
    </tbody>
</table> -->

<!--
<ul id="presentationlist">
<?php foreach($presentations as $presentation) : ?>
<li>
<a href="<?php echo '/postom/presentations/view/'.$presentation['Presentation']['id']; ?>">

<span class="tit"><?php echo h($presentation['Presentation']['id']); ?> : <?php echo h($presentation['Presentation']['title']); ?></span>
<span>Abstract : 
<?php
echo $this->Text->truncate(
	$presentation['Presentation']['abstract'],
	50,
	array(
		'ellipsis' => '...', // テキストの終わりは「...」で終了
	)
);
?></span>
</a>
</li>
<?php endforeach; ?>
</ul>
-->
