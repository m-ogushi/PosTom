<?php
class AreasController extends AppController {
	public $helpers = array('Html', 'Form', 'Text');

	public function index(){
	}

	// 特定イベントのエリアをすべて取得する
	public function getByEventID($event_id){
		return $this->Area->find('all', array(
			'conditions' => array('event_id' => $event_id)
		));
	}
	
	// エリア更新処理
	public function update(){
		$this->autoRender = FALSE;
		if ($this->request->is('ajax')) {
			$this->Area->save($this->request->data);
			// 直前にsaveしたレコードのidを取得する
			$last_id = $this->Area->getLastInsertID();
			return $last_id;
		}
		return false;
	}
	
	// エリア削除処理
	public function delete(){
		$this->autoRender = FALSE;
		if ($this->request->is('ajax')) {
			$this->Area->deleteAll(array('id' => $this->request->data), false);
			return true;
		}
		return false;
	}
	
	// 裏コマンド：全件削除
	public function deleteAreaAll(){
		// 選択中のイベントのすべてのポスターを削除する
		$this->Area->deleteAll(array('event_id' => $_SESSION['event_id']), false);
		
		// ポスター配置画面へ戻る
		$this->redirect(array('controller' => 'posters', 'action'=>'index'));
	}
}
?>
