<?php
ini_set('auto_detect_line_endings', true);
class Presentation extends AppModel {
	public function loadCSV($filename){
	        $this->begin();
            try{
                //最初にTable:resentationを初期化
                $this->deleteAll('1=1',false);
                $handle = fopen($filename,"r");
                while(($row = fgetcsv($handle, 1000, ",")) !== FALSE){
                mb_convert_variables("UTF-8","SJIS", $row);
                    $presenData = array(
						'room' => $row[0],
						'session_order' => $row[1],
						'presentation_order' => $row[2],
						'title' => $row[3],
						'abstract' => $row[4],
						'keyword' =>  $row[5],
						'authors_name' => $row[6],
						'authors_affiliation' => $row[7]
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
}
?>