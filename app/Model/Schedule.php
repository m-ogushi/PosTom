<?php
ini_set('auto_detect_line_endings', true);
class Schedule extends AppModel {
	public function loadCSV($filename){
			$this->begin();
			try{
				$handle = fopen($filename,"r");
				$roomGroup = array();
				$saveRooms = array();
				$roomOrder = 1;
				$event_id = $_SESSION['event_id'];
				while(($row = fgetcsv($handle, 1000, ",")) !== FALSE){
					mb_convert_variables("UTF-8", "auto", $row);
					$scheduleData = array(
						'room' => $row[0],
						'order' => $row[1],
						'category' => $row[2],
						'date' => $row[3],
						'start_time' =>  $row[4],
						'end_time' => $row[5],
						'chairperson_name' => $row[6],
						'chairperson_affiliation' => $row[7],
						'commentator_name' => $row[8],
						'commentator_affiliation' => $row[9],
						'event_id' => $_SESSION['event_id']
					);
					//すでに登録しているroomでないか、一行目の説明でないか
					if(!in_array($row[0], $roomGroup) && $row[0] != "room"){
						// 予約語ALLは小文字大文字関わらずroomには登録しない、allの場合はALLに変換してsession保存
						if(strtolower($row[0]) != 'all'){
							array_push($roomGroup, $row[0]);
							array_push($saveRooms, array('name' => $row[0], 'order' => $roomOrder, 'event_id' => $event_id));
							$roomOrder++;
						}else{
							$scheduleData['room'] = 'ALL';
							$scheduleData['order'] = 0;
							$scheduleData['chairperson_name'] = "";
							$scheduleData['chairperson_affiliation'] = "";
							$scheduleData['commentator_name'] = "";
							$scheduleData['commentator_affiliation'] = "";
						}
					}
					// フォーマットヘッダー無視用
					if($row[0] != "room") {
							$this->create($scheduleData);
							$this->save();
					}
				}
				$this->commit();
				self::_import_rooms($saveRooms);
			}catch(Exception $e){
				$this->rollback();
			}
	}
	public function add_session($data){
		return $this->save($data);
	}
	public function update_session($data){
		return $this->save($data);
	}
	public function delete_session($data){
		return $this->delete($data['Schedule']['id']);
	}
	public function _import_rooms($data){
		App::import('Model', 'Room');
		$Room = new Room;
		$Room->saveAll($data);
	}
}
?>
