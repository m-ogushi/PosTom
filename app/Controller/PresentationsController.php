<?php
//改行コードを正しく読み込むための設定
ini_set('auto_detect_line_endings', true);
class PresentationsController extends AppController {
	public $helpers = array('Html', 'Form', 'Text');
	public $uses = array('Schedule','Presentation','Event');
	public $checkResult = array();
	public $preGroup = array();
	public $error = "";
	public $check = true;
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
			// import前にevent内のpresentationを削除
			$this->Presentation->deleteAll(array('event_id'=>$_SESSION['event_id']));

			$up_file = $this->data['Presentation']['CsvFile']['tmp_name'];
			$fileName = 'PresentationTest.csv';
			if(is_uploaded_file($up_file)){
				move_uploaded_file($up_file, $fileName);
				$this->_checkFile($fileName);
				if($this->check == true){
					$this->Presentation->loadCSV($fileName);
					$this->redirect(array('action'=>'index'));
				}else{
					$this->set('checkResult', $this->checkResult);
					$this->render('checked');
				}
			}
		}else{
			echo "error";
		}
	}

	public function edit(){
		$event_id = $_SESSION['event_id'];
	if($this->request->is('post')){
		if(!isset($this->request->data["Presentation"]["Title"])){
			$this->request->data["Presentation"]["Title"] = "";
		}
		if(!isset($this->request->data["Presentation"]["Author"])){
			$this->request->data["Presentation"]["Author"] = "";
		}
		if(!isset($this->request->data["Session"])){
			$this->request->data["Session"] = 0;
		}
		
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
		else if(isset($this->request->data['Delete'])) {
			$presentations = $this->Presentation->find('all', array('conditions' => array('event_id' => $event_id),
			'fields'=>array('id')));
			$presenid = $this->request->data["Presentation"]["sessionid"];
			$this->request->data["Presentation"]["id"] = $presentations[$presenid]["Presentation"]["id"];
			unset($this->request->data["Presentation"]["sessionid"]);
			$this->Presentation->delete($this->request->data["Presentation"]["id"]);
			}
		}
		$this->redirect(['action'=>'index']);
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

	/******************************************************************
	*******************import前のバリデーションチェック*********************
	*******************************************************************/
	public function _checkFile($file){
	try{
			$handle = fopen($file,"r");
			$countRow = 1;
			while(($row = fgetcsv($handle, 1000, ",")) !== FALSE){
				mb_convert_variables("UTF-8", "auto", $row);
				$this->error = "";
				$this->check = true;
				$targetrow = $this->_setContent($row);
				if($row[0] != "room"){
					// バリデーションチェック関数呼び出し
					$this->_elementNum($row);
					$this->_orBlank($row);
					$this->_checkHyphen($row[0]);
					$this->_checkNumeric($row[1]);
					$this->_checkNumeric($row[2]);
					$this->_checkPresenCombi($row[0], $row[1], $row[2]);
					$this->_checkDate($row[3]);
					$this->_authorsCheck($row[7], $row[8]);

					array_push($this->checkResult, array('row' => $countRow, 'content' => $targetrow, 'error' => $this->error));
					$countRow++;
				}
			}
		}catch(Exception $e){
			$this->rollback();
		}
	}
	// 読み込んだ内容を補完
	public function _setContent($row){
		$content = "";
		$rowN = 0;
		while($rowN < count($row)){
			if(strlen($row[$rowN]) > 30){
				$content .= substr($row[$rowN], 0, 30).".....";
			}else{
				$content .= $row[$rowN];
			}
			$content .= "  ";
			$rowN++;
		}
		return $content;
	}
	// 要素数は１０
	public function _elementNum($row){
		if(count($row) != 9){
			$this->error .= "Element number is wrong. Format needs 10 elements. <br>";
			$this->check = false;
		}
	}
	// 空項目がないか
	public function _orBlank($row){
		if($row[0] == "" || $row[1] == "" || $row[2] == ""){
			$this->error .= "Blank element exists. <br>";
			$this->check = false;
		}
	}
	// roomのハイフン拒否
	public function _checkHyphen($room){
		if(strpos($room, "-")){
			$this->error .= "Can't use hyphen(-) in room. <br>";
			$this->check = false;
		}
		// 先頭にある時
		 if($room != ""){
		 	if($room[0] == "-"){
				$this->error .= "Can't use hyphen(-) in room. <br>";
				$this->check = false;
		 	}
		 }
	}
	// session order が0以上の整数どうか
	public function _checkNumeric($order){
		if((Int)$order < 0 || (string)$order !== (string)(Int)$order){
			$this->error .= "Order needs an integer of 1 or more. <br>";
			$this->check = false;
		}
	}
	// room, orderの組み合わせが他と被らないこと
	public function _checkPresenCombi($room, $sesOrder, $preOrder){
		$i=0;
		while($i < count($this->preGroup)){
			$targetRoom = $this->preGroup[$i]['room'];
			$targetSesOrder = $this->preGroup[$i]['sesorder'];
			$targetPreOrder = $this->preGroup[$i]['preorder'];
			if($targetRoom == $room && $targetSesOrder == $sesOrder && $targetPreOrder == $preOrder){
				$r = $i+1;
				$this->error .= "Already exist this combination of room and this session,presentation order. ";
				$this->error .= "Overlap in row".$r." .<br>";
				$this->check = false;
				break;
			}
			$i++;
		}
		array_push($this->preGroup, array('room' => $room, 'sesorder' => $sesOrder, 'preorder' => $preOrder));
	}
	// dateがイベントに存在するかどうか
	public function _checkDate($date){
		// 空は許可
		if($date != ""){
			if((Int)$date < 1 || $this->Event->dayDiff() < (Int)$date || (string)$date !== (string)(Int)$date){
				$this->error .= "Nothing date in event. <br>";
				$this->check = false;
			}
		}
	}
	// commentatorsの名前と所属の項目数が合致すること
	public function _authorsCheck($name, $affili){
		if(substr_count($name, ',') !== substr_count($affili, ',')){
			$this->error .= "authors name and affiliation is not match number. <br>";
			$this->check = false;
		}
	}



}

?>
