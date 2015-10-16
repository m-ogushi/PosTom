<script type="text/javascript">
$(function(){
	// ダッシュボードのPresentationを選択状態にする
	$('#dashboard #gNav #gNavPre').addClass('current');
});

// 「Add Presentation From CSV File」ボタンを押すと、ファイル選択ボタンを作動させる
function selectFile(){
	$('#selectFile').trigger('click');
}

/* 選択中のファイルがチェンジ（onChange）されたら、ファイルをアップロードするボタンを作動させる */
function fileUpLoad(){
	$('#PresentationImportForm input[type="submit"]').trigger('click');
	//var targetForm = $('#PresentationImportForm');
	//targetForm.submit();
}
</script>
<h2>Presentation List</h2>
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

<h3>CSV Import</h3>
<p><?php echo $this->Html->tag('button', 'Add Presentation From CSV File', array('class'=>'btn btn-custom', 'onClick'=>"selectFile()")); ?></p>
<?php echo $this->Form->create('Presentation',array('action'=>'import','type'=>'file', 'name'=>'presentationImport')); ?>
<p><?php echo $this->Form->input('CsvFile', array('label'=>'', 'type'=>'file', 'class'=>'disno', 'id'=>'selectFile', 'onChange'=>'presentationImport.submit()')); ?></p>
<p><?php echo $this->Form->end(array('label'=>'Upload', 'div'=> array('class' => 'disno'))); ?></p>