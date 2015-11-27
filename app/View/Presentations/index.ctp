<h2>CSV Import</h2>
<p>CSV Format is Number, Title, Abstract, Keyword, Author, AuthorAffiliation</p>
<p class="formatDownload"><a href="<?php echo $this->Html->webroot;?>format/presentation_format.csv">Download CSV Sample</a></p>
<p><?php echo $this->Html->tag('button', 'Add Presentation From CSV File', array('class'=>'btn btn-custom', 'onClick'=>"selectFile()")); ?></p>
<?php echo $this->Form->create('Presentation',array('action'=>'import','type'=>'file', 'name'=>'presentationImport')); ?>
<?php echo $this->Form->input('CsvFile', array('label'=>'', 'type'=>'file', 'accept'=>'text/csv', 'class'=>'disno', 'id'=>'selectFile', 'onChange'=>'presentationImport.submit()')); ?>
<?php echo $this->Form->end(array('label'=>'Upload', 'div'=> array('class' => 'disno'))); ?>

<h2>Presentation List</h2>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>No.</th>
            <th>Title</th>
			<th>Author</th>
        </tr>
    </thead>
    <tbody>
    	<?php if(count($presentations) == 0){
    		for($i=0; $i<10; $i++){
				echo '<tr>';
				echo "<td height='20'>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo '</tr>';
			}
    	}
    	?>
        <?php foreach ($presentations as $presentation) :
			echo '<tr>';
			echo '<td>'.$presentation['Presentation']['room'].$presentation['Presentation']['session_order'].'-'.$presentation['Presentation']['presentation_order'].'</td>';
			echo '<td>'.$presentation['Presentation']['title'].'</td>';
			echo '<td>'.$presentation['Presentation']['authors_name'].'</td>';
			echo '</tr>';
		endforeach;
        ?>
    </tbody>
</table>

<!-- 別の表示方法なので一応コメントアウト -->
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
