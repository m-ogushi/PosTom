<script type="text/javascript">
$(function(){
	$('#dashboard #gNav #gNavPre').addClass('current');
});
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

<p><?php echo $this->Html->link('Add Presentation From CSV File', array('controller'=>'presentations', 'action'=>'add_csv'), array('class'=>'btn btn-custom')); ?></p>
<p><?php //echo $this->Html->link('Add Presentation', array('controller'=>'presentations', 'action'=>'add'), array('class'=>'btn btn-custom')); ?></p>

<h3>CSV Import</h3>
<?php
    echo $this->Form->create('Presentation',array('action'=>'import','type'=>'file'));
    echo $this->Form->input('CsvFile',array('label'=>'','type'=>'file'));
    echo $this->Form->end('Upload');
?>