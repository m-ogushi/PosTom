<?php
ini_set('auto_detect_line_endings', true);
class Presentation extends AppModel {
	public function loadCSV($filename){
	        $this->begin();
            try{
                //最初にpresentationを初期化
                $this->deleteAll('1=1',false);
                $handle = fopen($filename,"r");
                //ヘッダー回避用
                $isHead = true;
                while(($row = fgetcsv($handle, 1000, ",")) !== FALSE){
                mb_convert_variables("UTF-8","SJIS", $row);

                    $presenData = array(
                        'number' => $row[0],
                        'title' => $row[1],
                        'abstract' => $row[2],
                        'keyword' =>  $row[3],
                        'authors_name' => $row[4],
                        'authors_belongs' => $row[5]
                    );

                    if($isHead == false) {
                        $this->create($presenData);
                        $this->save();
                    }
                    $isHead = false;
                }
                $this->commit();

            }catch(Exception $e){
				echo $e;
                $this->rollback();
            }
        }
}

?>