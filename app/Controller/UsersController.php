<?php

App::uses('CakeEmail', 'Network/Email');
class UsersController extends AppController {
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('signup', 'activate', 'login', 'interim'));
	}
	// ユーザ登録 (フォームの入力をDBに保存して仮登録し、本登録のためのメールを送信)
	public function signup() {
		if ($this->request->is('post')) {
			if ($this->User->save($this->data)) {
				// 本登録用のリンクを作成
				$url = 'activate/' . $this->User->id . '/' . $this->User->getActivationHash();
				$url = Router::url($url, true);

				// 本登録の案内メールを送信
				$email = new CakeEmail('gmail');
				$email->from(array('tkb.tsss@gmail.com' => 'PosTom'));
				$email->to($this->data['User']['email']);
				$email->subject('Please finish registration');
				$mailText = "You are still a state of the temporary registration in PosTom.\n Please click the following URL and complete this registration.\n".$url;
				$email->send($mailText); // メール本文に本登録用リンクを記す
				$this->Session->setFlash('Email was sent. Please finish registration');
				$this->redirect(array('action' => 'interim'));
			} else {
				$this->Session->setFlash('Input error happened');
			}
		}
	}
	// 仮登録終了
	public function interim() {
	}

	// 本登録
	public function activate($user_id = null, $in_hash = null) {
		$this->User->id = $user_id;
		if ($this->User->exists() && $in_hash == $this->User->getActivationHash()) {
			$this->User->saveField('active', 1);
			$this->Session->setFlash('Registration was completed');
		} else {
			$this->Session->setFlash('Unjust Link');
		}
	}

	// ログイン
	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				// UserID 格納
				$this->User->id = $this->Auth->user('id');
				// セッションにログインユーザーのIDを記憶
				$_SESSION['login_user_id'] = $this->Auth->user('id');
				// ログイン後はイベント一覧ページへリダイレクト
				return $this->redirect(array('controller'=>'events', 'action'=>'index'));
			}else{
				$active = $this->User->field('active', array('username' => $this->data['User']['username']));
				if ($active === 0) {
					$this->Session->setFlash('Do not finish registration');
				}else{
					$this->Session->setFlash('Wrong User Name or Password');
				}
			}
		}
	}

	// ログアウト
	public function logout() {
		$this->Session->setFlash('Sign Out');
		// セッションに記憶していたユーザ情報・イベント情報をクリア
		unset($_SESSION['login_user_id']);
		unset($_SESSION['event_id']);
		unset($_SESSION['event_str']);
		return $this->redirect($this->Auth->logout());
	}
	
	// すでにアカウントが登録されているかどうかをチェックするアクション
	public function checkAlreadyRegisted(){
		$this->autoRender = FALSE;
		if($this->request->is('ajax')){
			$results = $this->User->find('all', array(
				'conditions' => array('username' => $this->data['name'])
			));
			if($results == NULL){
				// 1件も登録されていない場合
				return "false";
			}
			return "true";		
		}
	}
}
?>
