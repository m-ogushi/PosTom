<?php

class PresentationsController extends AppController {
	public $helpers = array('Html', 'Form', 'Text');
	
	public function index(){
		$this->set('presentations', $this->Presentation->find('all'));
	}

	public function import(){
        if($this->request->is('post')){
            $up_file = $this->data['Presentation']['CsvFile']['tmp_name'];
            $fileName = 'Test.csv';
            if(is_uploaded_file($up_file)){
                move_uploaded_file($up_file, $fileName);
                $this->Presentation->loadCSV($fileName);
                $this->Session->setFlash('Uploaded');
                $this->redirect(array('action'=>'index'));
            }
        }else{
        	echo "error";
        }
            //$this->redirect(array('action'=>'index'));
    }
}

?>