<?php

class EventsController extends AppController {

	public $helpers = array('Html', 'Form');
	public $uses =array('Event','Poster');

	public function index() {
		$this->set('events', $this->Event->find('all'));
		$this->set('title_for_layout', 'イベント一覧');
	}
	
	public function view($id = null) {

		$this->Event->id = $id;
		$this->set('event', $this->Event->read());


		$result=$this->Poster->find('all');
		$this->set('posters', $result);
	}
	
	public function add(){
		if($this->request->is('post')){
			if($this->Event->save($this->request->data)){
				$this->redirect(array('action'=>'index'));
			}else{
			}
		}
	}
	
	public function edit($id = null){
		$this->Event->id = $id;
		if($this->request->is('get')){
			$this->request->data = $this->Event->read();	
		}else{
			if($this->Event->save($this->request->data)){
				$this->Session->setFlash('Success!');
				$this->redirect(array('action'=>'index'));
			}else{
				$this->Session->setFlash('Failed!');	
			}
		}
	}
}

?>