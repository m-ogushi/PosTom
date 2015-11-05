<?php

App::uses('CakeEmail', 'Network/Email');
class UsersController extends AppController {
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('signup', 'activate', 'login'));
	}
	// ユーザ登録 (フォームの入力をDBに保存して仮登録し、本登録のためのメールを送信)
	public function signup() {
		if ($this->request->is('post')) {
			if ($this->User->save($this->data)) {
				// 本登録用のリンクを作成
				$url = 'activate/' . $this->User->id . '/' . $this->User->getActivationHash();
				$url = Router::url($url, true);
				//--------------------------------------------------------------
				// 本登録の案内メールを送信
				$email = new CakeEmail('gmail');
				$email->from(array('tkb.tsss@gmail.com' => 'PosTom'));
				$email->to($this->data['User']['email']);
				$email->subject('Please finish registration');
				$email->send($url); // メール本文に本登録用リンクを記す
				//--------------------------------------------------------------
				$this->Session->setFlash('Email was sent. Please finish registration');
			} else {
				$this->Session->setFlash('Input error happened');
			}
		}
	}

	// 本登録
	public function activate($user_id = null, $in_hash = null) {
		$this->User->id = $user_id;
		if ($this->User->exists() && $in_hash == $this->User->getActivationHash()) {
			$this->User->saveField('active', 1);
			$this->Session->setFlash('Registration was complete');
		} else {
		$this->Session->setFlash('Unjust Link');
		}
	}

	// ログイン
	public function login() {
	//TODO 後で実装
	}

	// ログアウト
	public function logout() {
	//TODO 後で実装
	}

	// ダッシュボード (ログイン直後に表示されるホーム画面)
	public function dashboard() {
	//TODO 後で実装
	}

	// パスワード変更
	public function password() {
	//TODO 後で実装
	}
}
?>
