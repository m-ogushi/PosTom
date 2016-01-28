<?php
class EachdaysController extends AppController {

	public $helpers = array('Html', 'Form', 'Text');
	public $uses = array('Eachday');

	// キャンバスの横幅・高さが変更されたときの処理
	public function modifyCanvasSize(){
		$this->autoRender = false;
		if ($this->request->is('ajax')){
			$data = $this->request->data;
			// すでに登録されているかどうか調べる
			$results = $this->Eachday->find('all', array(
				'conditions' => array(
					'event_id' => $data['event_id'],
					'date' => $data['date']
				)
			));
			
			if($results == NULL){
				// 1件も登録されていない場合、新規登録
				if($this->Eachday->save($data)){
					// 追加成功
				}
			}else{
				// すでに登録されている場合、更新
				$this->Eachday->updateAll(
					array('canvas_width' => $data['canvas_width'], 'canvas_height' => $data['canvas_height']),
					array('event_id' => $data['event_id'], 'date' => $data['date'])
				);
			}
		}
	}
	
	// キャンバスの幅・高さを取得する
	public function getCanvasSize($event_id, $date){
		$results = $this->Eachday->find('all', array(
			'conditions' => array(
				'event_id' => $event_id,
				'date' => $date
			)
		));
		
		if($results == NULL){
			// 1件も登録されていない場合、デフォルト値を設定してもらうようにする
			return false;
		}else{
			// すでに登録されている場合、幅と高さを取得する
			return $results;
		}
		
	}
	
	// イベントごとのキャンバスの幅・高さを取得
	public function getCanvasWidthHeight($event_id){
		return $this->Eachday->find('all', array(
			'conditions' => array(
				'event_id' => $event_id,
			)
		));
	}
}
