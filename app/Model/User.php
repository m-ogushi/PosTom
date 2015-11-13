<?php

class User extends AppModel {
	//入力チェック機能
	public $validate = array(
		'username' => array(
			array(
				'rule' => 'notBlank',
				'message' => 'Please input this field'
			),
			array(
				'rule' => 'isUnique', //重複禁止
				'message' => 'already in use'
			),
			array(
				'rule' => 'alphaNumeric', //半角英数字のみ
				'message' => 'Alphanumeric characters only'
			),
			array(
				'rule' => array('between', 1, 50), //1～50文字
				'message' => 'Less than 50 characters'
			)
		),
		'email' => array(
			array(
				'rule' => array('email', true),
				'message' => array('Please input email address')
				),
		),
		'password' => array(
			array(
				'rule' => 'alphaNumeric',
				'message' => 'Alphanumeric characters only'
			),
			array(
				'rule' => array('between', 8, 50),
				'message' => 'More than 8 characters'
			)
		),
		'password_confirm' => array(
			'compare' => array(
				'rule' => array('password_match', 'password'),
				'message' => 'Password does not accord',
			),
			'length' => array(
				'rule' => array('between', 8, 20),
				'message' => 'More than 8 characters',
			),
			'empty' => array(
				'rule' => 'notBlank',
				'message' => 'Brank useless',
			),
		)
	);

	// パスワードと確認入力が一致するかチェックする
	public function password_match($field, $password) {
		//return ($field['password_confirm'] === $this->data['User']['password']);
		return ($field['password_confirm'] === $this->data[$this->name][$password]);
	}

	// 本登録用のリンクに含めるハッシュを生成する
	public function getActivationHash() {
		if (!isset($this->id)) {
			return false;
		} else {
			return Security::hash($this->field('modified'), 'md5', true);
		}
	}

	// データが保存される前に実行される
	public function beforeSave($options = array()) {
		// 平文パスワードをハッシュ化
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}
}
?>
