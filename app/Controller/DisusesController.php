<?php
class DisusesController extends AppController {

	public $helpers = array('Html', 'Form', 'Text');
	public $uses = array('Disuse');

	// Disuseチェックボックスにチェックがはいった時、データベースに保存する
	public function add(){
		if ($this->request->is('ajax')) {
			// まだ登録されていないことを確認
			// TODO: checkRegistedがうまく動作しない
			//if(!self::checkRegisted($this->request->data["event_id"], $this->request->data["date"])){
				if($this->Disuse->save($this->request->data)){
					// 追加成功
				}
			//}
		}
	}

	// Disuseチェックボックスからチェックが外れた時、データベースから削除する
	public function delete(){
		if ($this->request->is('ajax')) {
			// すでに登録されていることを確認
			// TODO: checkRegistedがうまく動作しない
			//if(self::checkRegisted($this->request->data["event_id"], $this->request->data["date"])){
				$param = array(
					'event_id' => $this->request->data["event_id"],
					'date' => $this->request->data["date"]
				);
				$this->Disuse->deleteAll($param, false);
			//}
		}
	}

	// すでに登録されているかどうかチェックする関数（すでに登録済みの場合はtrue）
	public function checkRegisted($event_id, $date){
		$result = $this->Disuse->find('all', array(
			'conditions' => array('event_id' => $event_id, 'date' => $date)
		));
		if(count($result['Disuse']) > 0){
			return true;
		}else{
			return false;
		}
	}

	// イベントIDからレコードを取得する
	public function getByEventID($event_id){
		return $this->Disuse->find('all', array(
			'conditions' => array('event_id' => $event_id)
		));
	}
}
