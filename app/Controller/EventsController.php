<?php

class EventsController extends AppController {
	
	public $helpers = array('Html', 'Form');
	
	public function index() {
		$this->set('events', $this->Event->find('all'));
		$this->set('title_for_layout', 'イベント一覧');
	}
	
	public function view($id = null) {
		$this->Event->id = $id;
		$this->set('event', $this->Event->read());
	}
	
	public function add(){
		if($this->request->is('post')){
			if($this->Event->save($this->request->data)){
				$this->redirect(array('action'=>'index'));
			}else{
			}
		}
	}
}

?>