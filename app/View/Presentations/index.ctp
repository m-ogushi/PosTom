<script type="text/javascript"> 
//現在編集しているプレゼンのidを格納する
var clickid;
function validate(){
	//console.log($("#PresentationRoom").val()+$("#PresentationSessionOrder").val()+"-"+$("#PresentationPresentationOrder").val());
	var validation = true;
	var editNum =$("#PresentationRoom").val()+$("#PresentationSessionOrder").val()+"-"+$("#PresentationPresentationOrder").val();
	console.log($("#PresentationSessionOrder").val());
	console.log(isFinite($("#PresentationSessionOrder").val()));
	console.log($("#PresentationPresentationOrder").val());
	console.log(isFinite($("#PresentationPresentationOrder").val()));
	
	if (!$("#PresentationRoom").val().match(/\S/g)　||!$("#PresentationSessionOrder").val().match(/\S/g)　|| !$("#PresentationPresentationOrder").val().match(/\S/g)){
		window.confirm("Room and Session Order and Presentation Order are required fields");
		validation = false;
		return false;
	}
	
	
		//Session OrderとPresentation Orderに数値が入っているかどうかチェックする
	if(isFinite($("#PresentationSessionOrder").val()) == false || isFinite($("#PresentationPresentationOrder").val())== false){
		window.confirm("Session Order and Presentation Order are must be numeric character");
		validation = false;
		return false;
	}
	
		//Session OrderとPresentation Orderが数値かどうかチェックする
	if(isFinite($("#PresentationSessionOrder").val()) == false || isFinite($("#PresentationPresentationOrder").val())== false){
		window.confirm("Session Order and Presentation Order are must be numeric character");
		validation = false;
	}
	
	        $(".Num").each(function(i){
	if(i == clickid){
		return true;
	}
    var l;
    l = $(this).text();
	if(l == editNum){
		window.confirm("「No.」 Have values ​​that are already in use is input");
		validation = false;
		return false;
	}
	
});
	
	if(validation){
		if(window.confirm('送信してよろしいですか？')){ // 確認ダイアログを表示

			return true; // 「OK」時は送信を実行

		}
		else{ // 「キャンセル」時の処理

		window.alert('キャンセルされました'); // 警告ダイアログを表示
		return false; // 送信を中止

		}
	}else{
		return false;
	}
}

function confirmer(){
//console.log("あら!");
		if(window.confirm('Are you really sure you want to delete')){ // 確認ダイアログを表示

			return true; // 「OK」時は送信を実行

		}
		else{ // 「キャンセル」時の処理

		window.alert('Delete is canceled'); // 警告ダイアログを表示
		return false; // 送信を中止

		}
	}

// -->
</script>

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
<button type="button" id="plus" name="add-new-session" class="btn btn-default session-modal-open" data-target="session-edit">＋</button>
<!-- dialogDeleteConfirm -->
<div id="dialogDeleteConfirm" class="disno" title="Confirm Delete">
<h2>Add presentation</h2>
</div>
<!-- //dialogDeleteConfirm -->
<!-- dialogSelectConfirm -->
<div id="dialogSelectConfirm" class="disno modal-content" title="Confirm Select">
<h2 id="presentitle">Edit presentation</h2>
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
echo $this->Form->submit('Make', array('name'=>'Make','id'=>'session_make_btn', 'class'=>'btn btn-primary', 'onclick'=>'return confirm_del_session();'));
echo $this->Form->submit('Save', array('name'=>'Save','id'=>'session_save_btn', 'class'=>'btn btn-primary', 'onclick'=>'return validate();'));
echo '<button id="session_cancel_btn" type="button" class="btn btn-default modal-close">cancel</button>';
echo $this->Form->submit('Delete', array('name'=>'Delete','id'=>'session_delete_btn', 'class'=>'btn btn-danger', 'onclick'=>'return confirmer();'));
?>
</div>
<!-- //dialogSelectConfirm -->