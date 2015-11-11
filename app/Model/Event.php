<?php

class Event extends AppModel {
	// イベント日数計算
    public function dayDiff(){
    	$event = $this->find('first');
        $begin = $event['Event']['event_begin_date'];
        $end = $event['Event']['event_end_date'];
        $timeStamp1 = strtotime($begin);
        $timeStamp2 = strtotime($end);
        $timeDiff = abs($timeStamp2 - $timeStamp1);
        $diff = ($timeDiff / (60 * 60 * 24)) + 1;
    	return $diff;
    }

    public $validate = array(
		'event_name' => array(
			'rule' => 'notEmpty',
			'message' => 'Please input 100 characters or less.'
		),
		'event_begin_date' =>  array(
			'rule' => 'notEmpty'
		),
		'event_begin_time' =>  array(
			'rule' => 'notEmpty'
		),
		'event_end_date' =>  array(
			'rule' => 'notEmpty'
		),
		'event_end_time' =>  array(
			'rule' => 'notEmpty'
		),
		'event_top_image' => array(

        // ルール：uploadError => errorを検証 (2.2 以降)
        'upload-file' => array( 
            'rule' => array('uploadError'),
            'message' => array( 'Error uploading file')
        ),

        // ルール：extension => pathinfoを使用して拡張子を検証
        'extension' => array(
            'rule' => array( 'extension', array( 
                'jpg', 'jpeg', 'png', 'gif')  // 拡張子を配列で定義
            ),
            'message' => array( 'file extension error')
        ),

        // ルール：mimeType => 
        // finfo_file(もしくは、mime_content_type)でファイルのmimeを検証 (2.2 以降)
        // 2.5 以降 - MIMEタイプを正規表現(文字列)で設定可能に
        'mimetype' => array( 
            'rule' => array( 'mimeType', array( 
                'image/jpeg', 'image/png', 'image/gif')  // MIMEタイプを配列で定義
            ),
            'message' => array( 'MIME type error')
        ),

        // ルール：fileSize => filesizeでファイルサイズを検証(2GBまで)  (2.3 以降)
        'size' => array(
            'maxFileSize' => array( 
                'rule' => array( 'fileSize', '<=', '10MB'),  // 10M以下
                'message' => array( 'file size error')
            ),
            'minFileSize' => array( 
                'rule' => array( 'fileSize', '>',  0),    // 0バイトより大
                'message' => array( 'file size error')
            ),
        ),
    ),
	);
}

?>