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
				mb_convert_variables("UTF-8","SJIS", $row);
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
					if(!in_array($row[0], $roomGroup) && $row[0] != "room"){
						array_push($roomGroup, $row[0]);
						array_push($saveRooms, array('name' => $row[0], 'order' => $roomOrder, 'event_id' => $event_id));
						$roomOrder++;
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
