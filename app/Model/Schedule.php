<?php
ini_set('auto_detect_line_endings', true);
class Schedule extends AppModel {
    public function loadCSV($filename){
	        $this->begin();
            try{
                $handle = fopen($filename,"r");
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
                    // フォーマットヘッダー無視用
                    if($row[0] != "room") {
                            $this->create($scheduleData);
                            $this->save();
                    }
                }
                $this->commit();
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
    public function add_room(){

    }
    public function update_room(){

    }
}
?>
