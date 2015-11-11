<?php
//改行コードを正しく読み込むための設定
ini_set('auto_detect_line_endings', true);
class SettingsController extends AppController {
    public $helpers = array('Html', 'Form', 'Text');
	public $uses =array('Event','Poster');
	
	public function index(){
		$this->set('events', $this->Event->find('all'));
	}
	
	public function eventedit() {
		$this->set('datas', $this->Event->find('first', array(
		'conditions' => array('id' =>$this->params["pass"][0])
		)));
		if($this->request->is('post')){
			 $save = $this->request->data;
			 $save["Event"]["id"] = $this->params["pass"][0];
			if($this->Event->save($save)){
			$this->redirect(array('action'=>'index'));
			}else{
			}
		}
	}

}
?>