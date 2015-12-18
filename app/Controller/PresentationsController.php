<?php
//改行コードを正しく読み込むための設定
ini_set('auto_detect_line_endings', true);
class PresentationsController extends AppController {
	public $helpers = array('Html', 'Form', 'Text');


	public function index(){
		$event_id = $_SESSION['event_id'];
		$this->set('presentations', $this->Presentation->find('all', array('conditions' => array('event_id' => $event_id))));
	}

	// すべてのプレゼンテーションを取得する
	public function getall(){
		return $this->Presentation->find('all');
	}

	// 特定イベントのプレゼンテーションをすべて取得する
	public function getByEventID($event_id){
		return $this->Presentation->find('all', array(
			'conditions' => array('event_id' => $event_id)
		));
	}

	// 固有のプレゼンテーションを１つ取得する
	public function getByID($id){
		return $this->Presentation->find('all', array(
			'conditions' => array('id' => $id)
		));
	}

	public function import(){
		if($this->request->is('post')){
			$up_file = $this->data['Presentation']['CsvFile']['tmp_name'];
			$fileName = 'PresentationTest.csv';
			if(is_uploaded_file($up_file)){
				move_uploaded_file($up_file, $fileName);
				$this->Presentation->loadCSV($fileName);
				$this->redirect(array('action'=>'index'));
			}
		}else{
			echo "error";
		}
	}
	
	// 裏コマンド：全件削除
	public function deletePresentationAll(){
		// 選択中のイベントのすべてのプレゼンテーションを取得
		$presentations = self::getByEventID($_SESSION['event_id']);
		// それぞれのプレゼンテーションを削除する前に、そのプレゼンテーションを関連づけているポスターがないかチェック
		foreach($presentations as $id => $presentation){
			// 削除対象プレゼンテーションのIDを変数に格納
			$target_id = $presentation['Presentation']['id'];
			// 削除対象プレゼンテーションを関連付けIDとしているポスターの情報を更新する
			self::updateRelatedPoster($target_id);
			// 削除対象プレゼンテーションを削除する
			$this->Presentation->delete($target_id);
		}
		// プレゼンテーショントップページへ戻る
		$this->redirect(array('action'=>'index'));
	}
	
	// 引数のIDを関連付けIDとして保持しているポスターの情報を更新する
	public function updateRelatedPoster($target_id){
		// 対象IDを関連付けIDとして保持しているポスターを取得
		$posters = $this->requestAction('/posters/getRelatedPoster/'.$target_id);
		foreach($posters as $id => $poster){
			// 関連付けIDの項目を初期化（0）にする
			$this->requestAction('/posters/initRelatedPoster/'.$poster['Poster']['id']);
		}
	}
}
?>
