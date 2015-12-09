<?php
ini_set('auto_detect_line_endings', true);
class Presentation extends AppModel {
	public function loadCSV($filename){
			$this->begin();
			try{
				// �?度、すべての�?ータを削除する前に対象となる�?�レゼン�?ーションが関連付けされて�?る�?�スターの�?ータを�?�期化す�?
				self::checkRelatedPoster();
				$handle = fopen($filename,"r");
				while(($row = fgetcsv($handle, 1000, ",")) !== FALSE){
				mb_convert_variables("UTF-8","auto", $row);
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

	// 関連済みプレゼン�?ーションを削除しよ�?とするとき�?�それを参�?�するポスターがある�?�合�?��?�スターの�?報を変更する処�?
	public function checkRelatedPoster(){
		// 現時点では、�?度すべてのプレゼン�?ーションの�?ータを削除するため、すべての�?ータを取得す�?
		$presentations = $this->requestAction('/presentations/getall');
		// 削除対象プレゼン�?ーションが�?�スター�?ータで関連付けされて�?るかど�?かチェ�?ク
		foreach($presentations as $id => $presentation){
			// 削除対象プレゼン�?ーションのIDを変数に格�?
			$target_id = $presentation['Presentation']['id'];
			// 削除対象プレゼン�?ーションを関連付けIDとして�?る�?�スターの�?報を更新する
			self::updateRelatedPoster($target_id);
		}
	}

	// 引数のIDを関連付けIDとして保持して�?る�?�スターの�?報を更新する
	public function updateRelatedPoster($target_id){
		// 対象IDを関連付けIDとして保持して�?る�?�スターを取�?
		$posters = $this->requestAction('/posters/getRelatedPoster/'.$target_id);
		foreach($posters as $id => $poster){
			// 関連付けIDの�?目を�?�期化�?0?��にする
			$this->requestAction('/posters/initRelatedPoster/'.$poster['Poster']['id']);
		}
	}
}
?>
