<?php
if ($_FILES['backGroundImage']) {
	header('Content-type: text/html');
	$imageFile = $_FILES['backGroundImage']['name']; //formのinput name属性="backGroundImage" アップロードファイル名
	
	if (isset($imageFile)){
		$upload_path = "../img/bg/backGround.png"; //階層が変わるなら書き換え
		move_uploaded_file($_FILES['backGroundImage']['tmp_name'],$upload_path);
		echo 'upload successed';
	}else{
		echo 'can not find the file';
	}
}
?>