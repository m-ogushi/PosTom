<?php
//改行コードを正しく読み込むための設定
ini_set('auto_detect_line_endings', true);
class SchedulesController extends AppController {
	public $helpers = array('Html', 'Form', 'Text');
	public $uses = array('Schedule','Event','Room');
	public function index(){
		$event_id = $_SESSION['event_id'];
		$this->set('schedules', $this->Schedule->find('all', array('conditions' => array('event_id' => $event_id))));
		$this->set('day_diff', $this->Event->dayDiff());
		$this->set('rooms', $this->Room->find('all', array('conditions' => array('event_id' => $event_id))));
	}
	public function import(){
		if($this->request->is('post')){

			// event内のsession, roomを削除
			$this->Schedule->deleteAll(array('event_id'=>$_SESSION['event_id']));
			$this->Room->deleteAll(array('event_id'=>$_SESSION['event_id']));

			$up_file = $this->data['Schedule']['CsvFile']['tmp_name'];
			$fileName = 'ScheduleTest.csv';
			if(is_uploaded_file($up_file)){
				move_uploaded_file($up_file, $fileName);
				$this->Schedule->loadCSV($fileName);
				// $this->Schedule->setFlash('');
				$this->redirect(array('action'=>'index'));
			}
		}else{
			echo "error";
		}
	}
	public function save_rooting(){
		$this->autoRender = false;
		// セッションからイベントid格納
		$this->request->data['Schedule']['event_id'] = $_SESSION['event_id'];
		if($this->request->is('post')){
			if($this->request->data['Schedule']['root_flag'] == "add-session"){
				// roomがALLだったらいらない情報を消す & order=0
				if($this->request->data['Schedule']['room'] == "ALL"){
					debug("ALLLLLLLLLLLLLL");
				}
				if($this->Schedule->add_session($this->request->data)){
					$this->redirect(array('action'=>'index'));
				}
			}
			if($this->data['Schedule']['root_flag'] == "update-session"){
				if($this->Schedule->update_session($this->request->data)){
					$this->redirect(array('action'=>'index'));
				}
			}
			if($this->data['Schedule']['root_flag'] == "delete-session"){
				if($this->Schedule->delete_session($this->request->data)){
					$this->redirect(array('action'=>'index'));
				}
			}
		}
	}
	public function del_session_ofRoom(){
		$this->autoRender = false;
		$options = array('event_id'=>$_SESSION['event_id'], 'room'=>$this->request->params['pass'][0]);
		if($this->Schedule->deleteAll($options)){
			$this->redirect(array('action'=>'index'));
		}
	}
	public function rename_session(){
		$this->autoRender = false;
		$newName = $this->request->params['named']['new'];
		unset($this->request->params['named']['new']);
		if($this->Schedule->hasAny($this->request->params['named'])){
			$this->Schedule->updateAll(array('room'=>"'" .$newName. "'"), $this->request->params['named']);
		}
		$this->redirect(array('action'=>'index'));
	}
}
?>
