<?php

class PostersController extends AppController {
	public $helpers = array('Html', 'Form', 'Text');

	public function index(){
		// 選択中のイベントをevent_idにもつポスターのみ抽出
		$this->set('data',
			$this->Poster->find('all', array(
				'conditions' => array('event_id' => $_SESSION['event_id'])
			))
		);
	}

	public function savesql(){
		$uses = array('Poster');
		if ($this->request->is('ajax')) {
			$savedata = array_slice($this->request->data, 2);
			$this->Poster->deleteAll('1 = 1', false);
			$this->Poster->saveAll($savedata);
		}
	}

	public function singlesavesql(){
		$this->autoRender = FALSE;
		$uses = array('Poster');
		if ($this->request->is('ajax')) {
			$this->Poster->save($this->request->data);
			// 直前にsaveしたレコードのidを取得する
			$last_id = $this->Poster->getLastInsertID();
			return $last_id;
		}
	}

	public function deletesql(){
		$uses = array('Poster');
		if ($this->request->is('ajax')) {
		$id = $this->request->data["id"];
			$this->Poster->delete($id);
		}
	}

	// ポスター配置画面でポスターキャンバスタブが切り替わった際に呼び出されるセッション記録用処理
	public function saveSelectedDay(){
		if ($this->request->is('ajax')) {
			$day = $this->request->data["day"];
			// セッションに選択中の日数を記録
			$_SESSION['selected_day'] = $day;
			return true;
		}
	}

	// 任意のプレゼンテーションを関連付けしているポスターを取得する関数
	public function getRelatedPoster($presentation_id){
		return $this->Poster->find('all', array(
			'conditions' => array('presentation_id' => $presentation_id)
		));
	}

	// ポスターの関連付けプレゼンテーションID属性を初期化する
	public function initRelatedPoster($id){
		$data = array('id' => $id, 'presentation_id' => 0, 'color' => '#999999');
		$this->Poster->save($data);
	}
	
	// 裏コマンド：全件削除
	public function deletePosterAll(){
		// 選択中のイベントのすべてのポスターを削除する
		$this->Poster->deleteAll(array('event_id' => $_SESSION['event_id']), false);
		
		// ポスター配置画面へ戻る
		$this->redirect(array('action'=>'index'));
	}
	
	// 選択中のイベントのすべてのポスターの関連付け情報を初期化する
	public function initRelation(){
		// 選択中のイベントのすべてのポスターを削除する
		$posters = $this->Poster->find('all', array(
			'conditions' => array('event_id' => $_SESSION['event_id'])
		));
		foreach($posters as $id => $poster){
			$target_id = $poster['Poster']['id'];
			$this->Poster->save(array('id' => $target_id, 'presentation_id' => 0, 'color' => '#999999'));
		}
	}
}
?>
