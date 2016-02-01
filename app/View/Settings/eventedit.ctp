<?php

// 編集しようとしているイベントID
$event_id = $this->params['pass'][0];
// ログイン中のユーザーID
$login_user_id = $_SESSION['login_user_id'];

// 権限があるかどうかチェック
if(! $this->requestAction('/settings/checkPermission/'.$login_user_id.'/'.$event_id)){
	// 編集権限がなければイベントトップページへリダイレクト
	echo "Event ID:".$event_id." の編集権限がありません";
}else{
	// 編集権限があればレンダーを開始する

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
		// イベント名
		var eventName = $('#EventEventName').val();
		// 開始日付
		var startYear = $('#EventEventBeginDateYear').val();
		var startMonth = $('#EventEventBeginDateMonth').val();
		var startDay = $('#EventEventBeginDateDay').val();
		var startdate = new Date( startYear + "/" + startMonth + "/" + startDay );
		// 終了日付
		var endYear = $('#EventEventEndDateYear').val();
		var endMonth = $('#EventEventEndDateMonth').val();
		var endDay = $('#EventEventEndDateDay').val();
		var enddate = new Date( endYear + "/" + endMonth + "/" + endDay );
		
		var daysDiff = getDiff(startdate, enddate);
		
		var starttime = parseInt($('#EventEventBeginTimeHour').val()*60) + parseInt($('#EventEventBeginTimeMin').val());
		var endtime = parseInt($('#EventEventEndTimeHour').val()*60) + parseInt($('#EventEventEndTimeMin').val());
		
		if($('#EventEventBeginTimeMeridian').val() == 'pm'){
			starttime=starttime+720;
		}
		if($('#EventEventEndTimeMeridian').val() == 'pm'){
			endtime=endtime+720;
		}
		
		// エラーフラグ
		var errFlg = false;
		// エラーメッセージを空に
		err_box = $('.error-messages');
		err_box.empty();
		
		if(eventName == '' || eventName == undefined || eventName == null){
			// イベント名が空の場合
			err_elm = $('<p>').text("Event Name is required.");
			err_box.append(err_elm);
			errFlg = true;
		}
		
		if(!dateValidate(startYear, startMonth, startDay)){
			// 開始日が存在しない日付の場合
			err_elm = $('<p>').text("Event Start Date ("+startYear+"/"+startMonth+"/"+startDay+") is not exist.");
			err_box.append(err_elm);
			errFlg = true;
		}
		if(!dateValidate(endYear, endMonth, endDay)){
			// 終了日が存在しない日付の場合
			err_elm = $('<p>').text("Event End Date ("+endYear+"/"+endMonth+"/"+endDay+") is not exist.");
			err_box.append(err_elm);
			errFlg = true;
		}
		
		if(daysDiff == 1){
			if(endtime<=starttime){
			//イベントが一日の時、開始日時が終了日時より遅い場合
				err_elm = $('<p>').text("Event Begin Time must be earlier than Event End Time.");
				err_box.append(err_elm);
				errFlg = true;
			}
		}
		if(daysDiff < 1){
			// 開始日時の方が小さい場合
			err_elm = $('<p>').text("Event Begin Date must be earlier than Event End Date.");
			err_box.append(err_elm);
			errFlg = true;
		}else if(daysDiff > 10){
			// 開催日数が10日を超える場合
			err_elm = $('<p>').text("Event Days must be 10 days or less.");
			err_box.append(err_elm);
			errFlg = true;
		}
		
		// エラーが１つでもあればエラーメッセージを表示する
		if(errFlg){
			slideDown(err_box);
			return false;
		}
	})
	
	// 開始日と終了日の差の日数を算出する処理
	function getDiff(startdate, enddate){
		var msDiff = enddate.getTime() - startdate.getTime();
		var daysDiff = Math.floor(msDiff / (1000 * 60 * 60 * 24));
		return ++daysDiff;
	}
	
	// エラーメッセージをスライドで表示させる
	function slideDown(slideEle){
		slideEle.slideDown(300).removeClass('disno');
	}
	
	// 存在する日かどうかチェック
	function dateValidate(y, m, d){
		var date = new Date(y, (m-1), d);
		return(date.getFullYear() == y && date.getMonth() == (m-1) && date.getDate() == d);
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
echo $this->Form->input('short_event_name', array('class'=>'form-control','default' => $datas["Event"]["short_event_name"],'required' => false));
echo $this->Form->input('event_location', array('class'=>'form-control','default' => $datas["Event"]["event_location"],'required' => false));
echo $this->Form->input('event_begin_date', array('class'=>'form-control','default' => $datas["Event"]["event_begin_date"],'required' => false));
echo $this->Form->input('event_begin_time', array('class'=>'form-control','default' => $datas["Event"]["event_begin_time"],'required' => false));
echo $this->Form->input('event_end_date', array('class'=>'form-control','default' => $datas["Event"]["event_end_date"],'required' => false));
echo $this->Form->input('event_end_time', array('class'=>'form-control','default' => $datas["Event"]["event_end_time"],'required' => false));
echo $this->Form->input('event_webpage', array('class'=>'form-control','default' => $datas["Event"]["event_webpage"],'required' => false));
echo $this->Form->input('event_top_image', array('type'=>'file','required' => false));
echo $this->Form->submit('Update', array('class'=>'btn btn-custom'));
// 既にトップページ用画像がアップロードされている場合、トップページのイメージを表示
if($url!=""){
?>
	<div id="posmappImage">
	<p id="topImage"><img src="<?php echo $this->html->webroot.$url; ?>"></p>
	<p id="menuImage"><img src="<?php echo $this->html->webroot; ?>img/fr_posmapp_top_menu.png" alt="PosMAppメニュー画像" width="320" height="460"></p>
	<div id="textInfo">
		<p class="textBigger"><?= $datas["Event"]["short_event_name"] ?></p>
		<p><?= $datas["Event"]["event_name"] ?></p>
		<p><?= $datas["Event"]["event_begin_date"] ?> - <?= $datas["Event"]["event_end_date"] ?></p>
		<p><?= $datas["Event"]["event_location"] ?></p>
	</div>
	</div>
<?php
}
?>
</div>

<?php
} // 編集権限ありの場合のレンダーを終了
?>
