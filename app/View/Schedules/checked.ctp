
<script type="text/javascript">
	$(function(){
	// ダッシュボードのPresentationを選択状態にする
		$('#dashboard #gNav #gNavSch').addClass('current');
	});
</script>
<?php
	echo $this->Html->css('page_checked');
	echo '<h3>File(Schedule) Check Result</h3>';
	echo '<div name="result">';
	echo '<p>File content is followings.<br>room,order,session_name,date,start_time,end_time,chairperson_name,chairperson_affiliation,commentators_name,commentators_affiliation</p>';
	echo '<br><p>※File check is failed</p><p class="formatDownload"><a href="./">go back to schedule page</a></p>';
	$i = 0;
	while($i < count($checkResult)){
		// debug($checkResult);
		$errorText = "";
		if($checkResult[$i]['error'] != ""){
			$errorText = 'Error '.$checkResult[$i]['error'];
			echo '<hr>';
			echo '<p>Row '. $checkResult[$i]['row'] .' <br>Content '. $checkResult[$i]['content'].'</p>';
			echo '<p class="error">'.$errorText.'</p>';
		}
		$i++;
	}
	echo '</div>';
?>