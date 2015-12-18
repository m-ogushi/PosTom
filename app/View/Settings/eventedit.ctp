<?php
	$url="";
	if (file_exists("img/thumb/".$_SESSION["event_str"]."." ."jpg")){
		$url="img/thumb/".$_SESSION["event_str"] ."." ."jpg";
	}else if (file_exists("img/thumb/".$_SESSION["event_str"]."."  ."png")){
		$url="img/thumb/".$_SESSION["event_str"] ."." ."png";
	}else if (file_exists("img/thumb/".$_SESSION["event_str"]."."  ."gif")){
		$url="img/thumb/".$_SESSION["event_str"] ."." ."gif";
	}
?>
<script type="text/javascript">
 $(function(){
	$('#EventEventeditForm').submit(function(){
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

<h2>Edit event</h2>
<div id="pageSetting">
<p class="attention">* : Required</p>
<div class="error-messages disno"></div>
<?php
echo $this->Form->create('',array('enctype' => 'multipart/form-data'));
echo $this->Form->input('event_name', array('class'=>'form-control required','default' => $datas["Event"]["event_name"],'required' => false));
echo $this->Form->input('event_location', array('class'=>'form-control','default' => $datas["Event"]["event_location"],'required' => false));
echo $this->Form->input('event_begin_date', array('class'=>'form-control','default' => $datas["Event"]["event_begin_date"],'required' => false));
echo $this->Form->input('event_begin_time', array('class'=>'form-control','default' => $datas["Event"]["event_begin_time"],'required' => false));
echo $this->Form->input('event_end_date', array('class'=>'form-control','default' => $datas["Event"]["event_end_date"],'required' => false));
echo $this->Form->input('event_end_time', array('class'=>'form-control','default' => $datas["Event"]["event_end_time"],'required' => false));
echo $this->Form->input('event_top_image', array('type'=>'file','required' => false));
echo $this->Form->submit('Update', array('class'=>'btn btn-custom'));
// 既にトップページ用画像がアップロードされている場合、トップページのイメージを表示
if($url!=""){
?>
	<div id="posmappImage">
	<p id="floormapImage"><img src="<?php echo $this->html->webroot.$url; ?>" width="320" height="349"></p>
	</div>
<?php
}
?>
</div>
