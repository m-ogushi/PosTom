<?php
ini_set('auto_detect_line_endings', true);
class Presentation extends AppModel {
	public function loadCSV($filename){
			$this->begin();
			try{
				//self::checkRelatedPoster();
				$handle = fopen($filename,"r");
				while(($row = fgetcsv($handle, 3000, ",")) !== FALSE){
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
	
	/*
	// プレゼンが関連付けされたポスターをチェックする処理
	public function checkRelatedPoster(){
		//$presentations = $this->requestAction('/presentations/getall');
		$presentations = $this->requestAction('/presentations/getByEventID/'.$_SESSION['event_id']);
		foreach($presentations as $id => $presentation){
			$target_id = $presentation['Presentation']['id'];
			// 選択中のイベントに含まれるプレゼンテーションすべてにおいて以下の更新処理をおこなう
			self::updateRelatedPoster($target_id);
		}
	}

	// プレゼンが関連付けされたポスターを更新する処理
	public function updateRelatedPoster($target_id){
		// 対象のプレゼンテーションIDをもつポスターを取得する
		$posters = $this->requestAction('/posters/getRelatedPoster/'.$target_id);
		foreach($posters as $id => $poster){
			$this->requestAction('/posters/initRelatedPoster/'.$poster['Poster']['id']);
		}
	}
	*/
}
?>
