<?php
ini_set('auto_detect_line_endings', true);
class Presentation extends AppModel {
	public function loadCSV($filename){
	        $this->begin();
            try{
                $handle = fopen($filename,"r");
                while(($row = fgetcsv($handle, 1000, ",")) !== FALSE){
                mb_convert_variables("UTF-8","SJIS", $row);
                    $presenData = array(
                        'number' => $row[0],
                        'title' => $row[1],
                        'abstract' => $row[2],
                        'keyword' =>  $row[3]
                    );
                    $this->create($presenData);
                    $this->save();

                    $authorData = array(
                        'authorname' => $row[4],
                        'authorbelong' => $row[5],
                    );
                    // $this->create($authorData);
                    // $this->save();
            }

                $this->commit();
            }catch(Exception $e){
                $this->rollback();
            }
        }

}

?>