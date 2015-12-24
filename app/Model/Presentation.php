<?php
ini_set('auto_detect_line_endings', true);
class Presentation extends AppModel {
	public function loadCSV($filename){
			$this->begin();
			try{
				// 一度、すべてのデータを削除する前に対象となるプレゼンテーションが関連付けされているポスターのデータを初期化する
				self::checkRelatedPoster();
				$handle = fopen($filename,"r");
				while(($row = fgetcsv($handle, 1000, ",")) !== FALSE){

				mb_convert_variables("UTF-8", "auto", $row);
					$presenData = array(
						'room' => $row[0],
						'session_order' => $row[1],
						'presentation_order' => $row[2],
						'date' => $row[3],
						'title' => $row[4],
						'abstract' => $row[5],
						'keyword' =>  $row[6],
						'authors_name' => $row[7],
						'authors_affiliation' => $row[8],
						'event_id' => $_SESSION['event_id']
					);
					if($row[0] != "room") {
							$this->create($presenData);
							$this->save();
					}
				}
				$this->commit();
			}catch(Exception $e){
				$this->rollback();
			}
	}

	// 関連済みプレゼンテーションを削除しようとするとき、それを参照するポスターがある場合、ポスターの情報を変更する処理
	public function checkRelatedPoster(){
		// 現時点では、一度すべてのプレゼンテーションのデータを削除するため、すべてのデータを取得する
		$presentations = $this->requestAction('/presentations/getall');
		// 削除対象プレゼンテーションがポスターデータで関連付けされているかどうかチェック
		foreach($presentations as $id => $presentation){
			// 削除対象プレゼンテーションのIDを変数に格納
			$target_id = $presentation['Presentation']['id'];
			// 削除対象プレゼンテーションを関連付けIDとしているポスターの情報を更新する
			self::updateRelatedPoster($target_id);
		}
	}

	// 引数のIDを関連付けIDとして保持しているポスターの情報を更新する
	public function updateRelatedPoster($target_id){
		// 対象IDを関連付けIDとして保持しているポスターを取得
		$posters = $this->requestAction('/posters/getRelatedPoster/'.$target_id);
		foreach($posters as $id => $poster){
			// 関連付けIDの項目を初期化（0）にする
			$this->requestAction('/posters/initRelatedPoster/'.$poster['Poster']['id']);
		}
	}
    public $validate = array(
		'room' => array(
			'rule' => 'notBlank',
			'message' => 'Required field'
		),
		'session_order' =>  array(
			'Session_order_rule-1' =>  array(
				'rule' => 'notBlank',
				'message' => 'Required field'
		),
			'Session_order_rule-2' =>  array(
				'rule'    => 'naturalNumber',
				'message' => 'Please supply the number of wheels.'
		)
	),
		'presentation_order' =>  array(
			'Presentation_order_rule-1' =>  array(
				'rule' => 'notBlank',
				'message' => 'Required field'
		),
			'Presentation_order_rule-2' =>  array(
				'rule'    => 'naturalNumber',
				'message' => 'Please supply the number of wheels.'
		)
	),
		'date' =>  array(
			'date_rule-1' =>  array(
				'rule' => 'notBlank',
				'message' => 'Required field'
		),
			'date_rule-2' =>  array(
				'rule'    => 'naturalNumber',
				'message' => 'Please supply the number of wheels.'
		)
	),
		'title' =>  array(
			'rule' => 'notBlank',
			'message' => 'Required field'
		),
		'authors_name' =>  array(
			'rule' => 'notBlank',
			'message' => 'Required field'
		),
		'authors_affiliation' => array(
			'rule' => 'notBlank',
			'message' => 'Required field'
    ),
	);
}
?>
