<?php
ini_set('auto_detect_line_endings', true);
class Schedule extends AppModel {
    public function loadCSV($filename){
	        $this->begin();
            try{
                //最初にTable:sessionを初期化
                $this->deleteAll('1=1',false);
                $handle = fopen($filename,"r");
                while(($row = fgetcsv($handle, 1000, ",")) !== FALSE){
                mb_convert_variables("UTF-8","SJIS", $row);
                    $scheduleData = array(
                        'number' => $row[0],
                        'category' => $row[1],
                        'date' => $row[2],
                        'start_time' =>  $row[3],
                        'end_time' => $row[4],
                        'chairperson_name' => $row[5],
                        'chairperson_belongs' => $row[6],
                        'commentator_name' => $row[7],
                        'commentator_belongs' => $row[6]
                    );
                    if($row[0] != "number") {
                            $this->create($scheduleData);
                            $this->save();
                    }
                }
                $this->commit();
            }catch(Exception $e){
                $this->rollback();
            }
        }
}
?>