<?php
// イベント識別文字列を取得
$event_str = $_POST['EventStr'];
$event_date = $_POST['EventDate'];

if ($_FILES['backGroundImage']) {
	header('Content-type: text/html');
	$imageFile = $_FILES['backGroundImage']['name']; //formのinput name属性="backGroundImage" アップロードファイル名
	
	if (isset($imageFile)){
		// ファイルが既に存在すれば削除
		$path_jpg = "../img/bg/".$event_str."_".$event_date.".jpg";
		$path_png = "../img/bg/".$event_str."_".$event_date.".png";
		$path_gif = "../img/bg/".$event_str."_".$event_date.".gif";
		
		if (file_exists($path_jpg)){
			unlink($path_jpg);
		}
		if (file_exists($path_png)){
			unlink($path_png);
		}
		if (file_exists($path_gif)){
			unlink($path_gif);
		}
		// 画像をアップロード
		$upload_file = $_FILES['backGroundImage']['tmp_name'];
		$upload_path = "../img/bg/".$event_str."_".$event_date.".png"; //階層が変わるなら書き換え
		move_uploaded_file($_FILES['backGroundImage']['tmp_name'],$upload_path);
		
		// TODO: PosMApp側がまだ_1.png, _2.pngの表示に対応していないので、ノーマルのバージョンでもアップロードします 実装されたら消してください
		$upload_path = "../img/bg/".$event_str.".png";
		move_uploaded_file($upload_file, $upload_path);
		echo 'upload successed';
	}else{
		echo 'can not find the file';
	}
}else{
	echo 'error!';
}
?>