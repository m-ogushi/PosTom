<?php
	echo $this->Html->css('page_checked');
	echo '<h3>File Check Result</h3>';
	echo '<div name="result">';
	echo '<p>File content is followings.<br>room,session_order,presentation_order,date,title,abstract,keyword,authors_name,authors_belongs</p>';
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