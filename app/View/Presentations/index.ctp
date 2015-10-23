<script type="text/javascript">
$(function(){
	ダッシュボードのPresentationを選択状態にする
	$('#dashboard #gNav #gNavPre').addClass('current');
});

// 「Add Presentation From CSV File」ボタンを押すと、ファイル選択ボタンを作動させる
function selectFile(){
	$('#selectFile').trigger('click');
}

</script>
<h2>CSV Import</h2>
<p>CSV Format is Number,Title,Abstract,Keyword,Author,Author Belongs</p>


<p><?php echo $this->Html->tag('button', 'Add Presentation From CSV File', array('class'=>'btn btn-custom', 'onClick'=>"selectFile()")); ?></p>
<?php echo $this->Form->create('Presentation',array('action'=>'import','type'=>'file', 'name'=>'presentationImport')); ?>
<?php echo $this->Form->input('CsvFile', array('label'=>'', 'type'=>'file', 'accept'=>'text/csv', 'class'=>'disno', 'id'=>'selectFile', 'onChange'=>'presentationImport.submit()')); ?>
<?php echo $this->Form->end(array('label'=>'Upload', 'div'=> array('class' => 'disno'))); ?>

<p> </p>
<h2>Presentation List</h2>
<table border="1">
    <thead>
        <tr>
            <th>No.</th>
            <th>Title</th>
			<th>Author</th>
        </tr>
    </thead>
    <tbody>
    	<?php if(count($presentations)== 0){
    	echo '<tr>';
    		echo "<td height='20'>	  </td>";
    		echo "<td>    </td>";
    		echo "<td>    </td>";
    		echo '</tr>';
    	echo '<tr>';
    		echo "<td height='20'>	  </td>";
    		echo "<td>    </td>";
    		echo "<td>    </td>";
    		echo '</tr>';
    	echo '<tr>';
    		echo "<td height='20'>	  </td>";
    		echo "<td>    </td>";
    		echo "<td>    </td>";
    		echo '</tr>';
    	}
    	?>
        <?php foreach ($presentations as $presentation) :
		echo '<tr>';
		echo "<td>{$presentation['Presentation']['number']}</td>";
		echo "<td>{$presentation['Presentation']['title']}</td>";
		echo "<td>{$presentation['Presentation']['authors_name']}</td>";
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
