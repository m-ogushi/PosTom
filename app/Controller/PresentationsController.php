<?php
//改行コードを正しく読み込むための設定
ini_set('auto_detect_line_endings', true);
class PresentationsController extends AppController {
	public $helpers = array('Html', 'Form', 'Text', 'Paginator');
	public $components = array('Paginator');
	
	public function index(){
		$this->set('presentations', $this->Presentation->find('all'));
	}
	
	public function getall(){
		return $this->Presentation->find('all');
	}

	public function import(){
        if($this->request->is('post')){
            $up_file = $this->data['Presentation']['CsvFile']['tmp_name'];
            $fileName = 'PresentationTest.csv';
            if(is_uploaded_file($up_file)){
                move_uploaded_file($up_file, $fileName);
                $this->Presentation->loadCSV($fileName);
                $this->Presentation->setFlash('Uploaded');
                $this->redirect(array('action'=>'index'));
            }
        }else{
//            <script type="text/javascript">
//            alert("Upload Failed");
//            </script>
            echo "error";
        }
            //$this->redirect(array('action'=>'index'));
    }
}

?>