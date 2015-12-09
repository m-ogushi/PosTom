<?php
//改行コードを正しく読み込むための設定
ini_set('auto_detect_line_endings', true);
class PresentationsController extends AppController {
	public $helpers = array('Html', 'Form', 'Text');
	public $uses = array('Schedule','Presentation');

	public function index(){
		$event_id = $_SESSION['event_id'];
		$this->set('presentations', $this->Presentation->find('all', array('conditions' => array('event_id' => $event_id))));
		$key_arrays= $this->Schedule->find('all', array('conditions' => array('event_id' => $event_id),
				'fields'=>array('id')
	));
		$val_arrays= $this->Schedule->find('all', array('conditions' => array('event_id' => $event_id),
				'fields'=>array('room','order')
	));
	$key_array=array();
	$val_array=array();
		for($i=0;$i<count($val_arrays);$i++){
		array_push($key_array,$key_arrays[$i]["Schedule"]["id"]);
		array_push($val_array,$val_arrays[$i]["Schedule"]["room"].$val_arrays[$i]["Schedule"]["order"]);
		}
		$this->set('options', array_combine($key_array,$val_array));
	}

	public function getall(){
		return $this->Presentation->find('all');
	}

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
				// $this->Presentation->setFlash('Uploaded');
				$this->redirect(array('action'=>'index'));
			}
		}else{
			echo "error";
		}
	}
	
	public function edit(){
		$event_id = $_SESSION['event_id'];
	if($this->request->is('post')){
		if(isset($this->request->data['Save'])) {
			$presentations = $this->Presentation->find('all', array('conditions' => array('event_id' => $event_id),
			'fields'=>array('id')));
			$presenid = $this->request->data["Presentation"]["sessionid"];
			$this->request->data["Presentation"]["id"] = $presentations[$presenid]["Presentation"]["id"];
			unset($this->request->data["Presentation"]["sessionid"]);
			// 更新する内容を設定
			$data = array('Presentation' => 
			array(
			'id' => $this->request->data["Presentation"]["id"], 
			'room' => $this->request->data["Presentation"]["Room"],
			'session_order' => $this->request->data["Presentation"]["Session_order"],
			'presentation_order' => $this->request->data["Presentation"]["Presentation_order"],
			'title' => $this->request->data["Presentation"]["Title"],
			'authors_name' => $this->request->data["Presentation"]["Author"],
			'session_id' => $this->request->data["Session"]
			));
 
			// 更新する項目（フィールド指定）
			$fields = array('room','session_order','presentation_order','title','authors_name','session_id');
 
			// 更新
			$this->Presentation->save($data, false, $fields);
			}
		else if(isset($this->request->data['Make'])) {
			$data = array('Presentation' => 
			array( 
			'room' => $this->request->data["Presentation"]["Room"],
			'session_order' => $this->request->data["Presentation"]["Session_order"],
			'presentation_order' => $this->request->data["Presentation"]["Presentation_order"],
			'title' => $this->request->data["Presentation"]["Title"],
			'authors_name' => $this->request->data["Presentation"]["Author"],
			'session_id' => $this->request->data["Session"],
			'event_id' => $_SESSION['event_id']
			));
			// 更新する項目（フィールド指定）
			$fields = array('room','session_order','presentation_order','title','authors_name','session_id','event_id');
			 
			 $this->Presentation->save($data, false, $fields);
			}
		}
	}
}
?>
