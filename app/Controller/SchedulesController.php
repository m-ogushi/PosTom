<?php
//改行コードを正しく読み込むための設定
ini_set('auto_detect_line_endings', true);
class SchedulesController extends AppController {
	public $helpers = array('Html', 'Form', 'Text');
	
	public function index(){
		$this->set('schedules', $this->Schedule->find('all'));
    }

	public function import(){
        if($this->request->is('post')){
            $up_file = $this->data['Schedule']['CsvFile']['tmp_name'];
            $fileName = 'ScheduleTest.csv';
            if(is_uploaded_file($up_file)){
                move_uploaded_file($up_file, $fileName);
                $this->Schedule->loadCSV($fileName);
                // $this->Schedule->setFlash('Uploaded');
                $this->redirect(array('action'=>'index'));
            }
        }else{
//            <script type="text/javascript">
//            alert(Upload Failed);
//            </script>
        	echo "error";
        }
            //$this->redirect(array('action'=>'index'));
    }
}
?>