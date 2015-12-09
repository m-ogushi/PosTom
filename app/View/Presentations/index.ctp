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
			<th>Session</th>
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
        <?php 
			$roop = 0;
			foreach ($presentations as $presentation) :
			echo '<tr id=Presentable'.$roop++.'>';
			echo '<td class="Num">'.$presentation['Presentation']['room'].$presentation['Presentation']['session_order'].'-'.$presentation['Presentation']['presentation_order'].'</td>';
			echo '<td class="Room" style="display: none;">'.$presentation['Presentation']['room'].'</td>';
			echo '<td class="Session_order" style="display: none;">'.$presentation['Presentation']['session_order'].'</td>';
			echo '<td class="Presentation_order" style="display: none;">'.$presentation['Presentation']['presentation_order'].'</td>';
			echo '<td class="Title">'.$presentation['Presentation']['title'].'</td>';
			echo '<td class="Author">'.$presentation['Presentation']['authors_name'].'</td>';
			echo '<td class="Session">';
			if($presentation['Presentation']['session_id']!=0){
			$session_text = $presentation['Presentation']['session_id'];
			echo $options[$session_text];
			echo '</td>';
			echo '<td class="Sessionvalue"  style="display: none;">';
			echo $presentation['Presentation']['session_id'];
			}
			echo '</td>';
			echo '</tr>';
		endforeach;
        ?>
    </tbody>
</table>
<div id="plus">
+
</div>

<!-- dialogDeleteConfirm -->
<div id="dialogDeleteConfirm" class="disno" title="Confirm Delete">
<h2>Add presentation</h2>
</div>
<!-- //dialogDeleteConfirm -->
<!-- dialogSelectConfirm -->
<div id="dialogSelectConfirm" class="disno" title="Confirm Select">
<h2>Edit presentation</h2>
<?php
echo $this->Form->create('Presentation', array('action'=>'edit'));
echo $this->Form->hidden('sessionid', array('class'=>'form-control required','required' => false));
echo $this->Form->input('Room', array('class'=>'form-control required','default' => $datas["Event"]["event_name"],'required' => false));
echo "(Part of No.)";
echo $this->Form->input('Session_order', array('class'=>'form-control required','default' => $datas["Event"]["event_name"],'required' => false));
echo "(Part of No. Please input a numerical value.)";
echo $this->Form->input('Presentation_order', array('class'=>'form-control required','default' => $datas["Event"]["event_name"],'required' => false));
echo "(Part of No. Please input a numerical value.)";
echo $this->Form->input('Title', array('class'=>'form-control','default' => $datas["Event"]["event_location"],'required' => false));
echo $this->Form->input('Author', array('class'=>'form-control','default' => $datas["Event"]["event_begin_date"],'required' => false));
echo $this->form->input('Session', array(
  'class'=>'form-control',
  'div'=>false,
  'label' => array(
            'text'=>'Session'
        ),
  'options'=>$options
  )); 
echo $this->Form->submit('Make', array('name'=>'Make','id'=>'session_make_btn', 'class'=>'btn btn-primary'));
echo $this->Form->submit('Save', array('name'=>'Save','id'=>'session_save_btn', 'class'=>'btn btn-primary'));
echo '<button id="session_cancel_btn" type="button" class="btn btn-default modal-close">cancel</button>';
echo $this->Form->submit('Delete', array('id'=>'session_delete_btn', 'class'=>'btn btn-danger', 'onclick'=>'return confirm_del_session();'));
?>
</div>
<!-- //dialogSelectConfirm -->