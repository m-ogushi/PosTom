<?php
//改行コードを正しく読み込むための設定
ini_set('auto_detect_line_endings', true);
class SettingsController extends AppController {
	public $helpers = array('Html', 'Form', 'Text');
	public $uses =array('Event', 'Poster', 'Editor');
	public function index(){
		$this->set('events', $this->Event->find('all'));
	}

	// イベント編集アクション
	public function eventedit() {
		$this->set('datas', $this->Event->find('first', array(
			'conditions' => array('id' =>$this->params["pass"][0])
		)));
		if($this->request->is('post')){
			$save = $this->request->data;
			$save["Event"]["id"] = $this->params["pass"][0];
			if($save["Event"]["event_top_image"]["name"] =="" and $save["Event"]["event_top_image"]["type"] ==""){
				unset($save["Event"]["event_top_image"]);
			}
			if($this->Event->save($save)){
				$path = IMAGES;
				$image = $this->request->data["Event"]["event_top_image"];
				$name = $_SESSION['event_str'].".".explode("/",$image['type'])[1];
				$this->Session->setFlash('画像を登録しました');
				move_uploaded_file($image['tmp_name'], $path .'thumb'. DS . $name);
			}
			$this->redirect(array('action'=>'eventedit', $_SESSION['event_id']));
		}
	}
	
	// ログイン中のユーザが、そのイベントの編集権限を持っているかどうか
	public function checkPermission($account_id, $event_id) {
		$editors = $this->Editor->find('all', array(
			'conditions'=>array(
				'account_id' => $account_id,
				'event_id' => $event_id
			)
		));
		// IDによる検索のため結果は高々1件
		if(empty($editors[0])){
			// 権限がない場合
			return false;
		}else{
			// 権限がある場合
			return true;
		}
	}
}
?>
