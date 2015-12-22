<?php
	class RoomsController extends AppController{
		public $helpers = array('Html', 'Form', 'Text');
		public function save_rooting(){
			$this->autoRender = false;
			if($this->request->is('post')){
				$this->request->data['Room']['event_id'] = $_SESSION['event_id'];
				if($this->request->data['Room']['root_flag'] == "add-room"){
					if($this->Room->save($this->request->data)){
						$this->redirect(array('controller'=>'schedules', 'action'=>'index'));
					}
				}
				if($this->request->data['Room']['root_flag'] == "update-room"){
					unset($this->request->data['Room']['order']);
					if($this->Room->save($this->request->data)){
						$this->redirect(array('controller'=>'schedules', 'action'=>'rename_session', $this->request->data['Room']['name'], $this->request->data['Room']['room_before']));
					}
				}
				if($this->request->data['Room']['root_flag'] == "delete-room"){
					if($this->Room->delete($this->request->data['Room']['id'])){
						// room削除後にroomのorderに空白ができないようにする
						$deleteOrder = $this->request->data['Room']['order'];
						$targets = $this->Room->find('all', array('conditions' => array('event_id' => $_SESSION['event_id'])));
						foreach ($targets as $target) :
							if($target['Room']['order'] > $deleteOrder){
								$target['Room']['order']--;
								$this->Room->save($target);
							}
						endforeach;
						$this->redirect(array('controller'=>'schedules', 'action'=>'del_session_ofRoom', $this->request->data['Room']['name']));
					}
				}
			}
		}
	}
?>