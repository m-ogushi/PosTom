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
						$option = array('new'=>$this->request->data['Room']['name'], 'Schedule.room'=>$this->request->data['Room']['room_before'], 'Schedule.event_id'=>$this->request->data['Room']['event_id']);
						$this->requestAction(array('controller'=>'schedules', 'action'=>'rename_session', 'pass'=>$option));
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
		public function order_change(){
			$this->autoRender = false;
			$from = $this->request->data['Room']['from'];
			$to = $this->request->data['Room']['to'];
			$from += 1;
			$option = array('order'=>$from, 'event_id'=>(Int)$_SESSION['event_id']);
			// orderがかぶったらまずいので退避して最後にupdate
			$last_move = $this->Room->find('all', array('conditions' => $option));
			// roomを右に動かした場合
			if(($to - $from) >= 1){
				for($i=$from+1; $i<=$to; $i++){
					$option['order'] = $i;
					$change = array('order'=>$i-1);
					$this->Room->updateAll($change, $option);
				}
				$last_move[0]['Room']['order'] = $to;
				$this->Room->save($last_move[0]['Room']);
			//roomを左に動かした場合
			}else{
				for($i=$from; $i>$to+1; $i--){
					$option['order'] = $i-1;
					$change = array('order'=>$i);
					$this->Room->updateAll($change, $option);
				}
				$last_move[0]['Room']['order'] = $to+1;
				$this->Room->save($last_move[0]['Room']);
			}
			$this->redirect(array('controller'=>'schedules', 'action'=>'index'));
		}
	}
?>