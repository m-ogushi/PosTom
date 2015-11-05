<?php

class PostersController extends AppController {
    public $helpers = array('Html', 'Form', 'Text');

	public function index(){
		$this->set('data',$this->Poster->find('all'));
	}

	public function savesql(){
		$uses = array('Poster');
		if ($this->request->is('ajax')) {
			$savedata = array_slice($this->request->data, 2);
			$this->Poster->deleteAll('1 = 1', false);
			$this->Poster->saveAll($savedata);
		}
	}
}
?>
