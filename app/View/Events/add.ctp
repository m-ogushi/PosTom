<script type="text/javascript">
 $(function(){
	$(document).ready(function(){
		// cakeのtimeフォームは要素が変だから変更
		for (var i = 13; i < 25; i++) {
			$("#EventEventBeginTimeHour").append($("<option>").val(i).text(i));
			$("#EventEventEndTimeHour").append($("<option>").val(i).text(i));
		};
		$('#EventEventBeginTimeMeridian').remove();
		$('#EventEventEndTimeMeridian').remove();
	});
	$('#EventAddForm').submit(function(){
		var startdate = new Date($('#EventEventBeginDateYear').val() + "/" + $('#EventEventBeginDateMonth').val() + "/" + $('#EventEventBeginDateDay').val());
		var enddate = new Date($('#EventEventEndDateYear').val() + "/" + $('#EventEventEndDateMonth').val() + "/" + $('#EventEventEndDateDay').val());
		var daysDiff = getDiff(startdate, enddate);

		// エラーメッセージを空に
		err_box = $('.error-messages');
		err_box.empty();

		if(daysDiff < 1){
			// 開始日時の方が小さい場合
			err_elm = $('<p>').text("Event Begin Date must be earlier than Event End Date.");
			err_box.append(err_elm);
			slideDown(err_box);
			return false;
		}else if(daysDiff > 10){
			// 開催日数が10日を超える場合
			err_elm = $('<p>').text("Event Days must be 10 days or less.");
			err_box.append(err_elm);
			slideDown(err_box);
			return false;
		}
	})

	function getDiff(startdate, enddate){
		var msDiff = enddate.getTime() - startdate.getTime();
		var daysDiff = Math.floor(msDiff / (1000 * 60 * 60 * 24));
		return ++daysDiff;
	}

	function slideDown(slideEle){
		slideEle.slideDown(300).removeClass('disno');
	}
 })
</script>
<h2>Add event</h2>
<p class="attention">* : Required</p>
<div class="error-messages disno"></div>
<?php
echo $this->Form->create('Event');
echo $this->Form->input('event_name', array('class'=>'form-control required', 'required' => false));
echo $this->Form->input('event_location', array('class'=>'form-control'));
echo $this->Form->input('event_begin_date', array('class'=>'form-control'));
echo $this->Form->input('event_begin_time', array('class'=>'form-control', 'value' => '00:00:00'));
echo $this->Form->input('event_end_date', array('class'=>'form-control'));
echo $this->Form->input('event_end_time', array('class'=>'form-control', 'value' => '00:00:00'));
echo $this->Form->submit('Create', array('class'=>'btn btn-custom'));
?>
