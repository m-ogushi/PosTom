<?php
//改行コードを正しく読み込むための設定
ini_set('auto_detect_line_endings', true);
class SchedulesController extends AppController {
	public $helpers = array('Html', 'Form', 'Text');
	public $uses = array('Schedule','Event','Room');
	public $checkResult = array();
	public $sesGroup = array();
	public $timeGroup = array();
	public $error = "";
	public $check = true;
	public function index(){
		$event_id = $_SESSION['event_id'];
		$this->set('schedules', $this->Schedule->find('all', array('conditions' => array('event_id' => $event_id))));
		$this->set('day_diff', $this->Event->dayDiff());
		$this->set('rooms', $this->Room->find('all', array('conditions' => array('event_id' => $event_id))));
	}
	public function checked(){
		$this->set('checkResult', $this->checkResult);
	}
	public function import(){
		$this->check = true;
		if($this->request->is('post')){
			$up_file = $this->data['Schedule']['CsvFile']['tmp_name'];
			$fileName = 'ScheduleTest.csv';
			if(is_uploaded_file($up_file)){
				move_uploaded_file($up_file, $fileName);
				$this->_checkFile($fileName);
				if($this->check == true){
					// event内のsession, roomを削除
					$this->Schedule->deleteAll(array('event_id'=>$_SESSION['event_id']));
					$this->Room->deleteAll(array('event_id'=>$_SESSION['event_id']));
					$this->Schedule->loadCSV($fileName);
					$this->redirect(array('action'=>'index'));
				}else{
					$this->set('checkResult', $this->checkResult);
					$this->render('checked');
					// $this->redirect(array('action'=>'checked'));
				}
			}
		}else{
			echo "error";
		}
	}

/******************************************************************
*******************import前のバリデーションチェック****************************
*******************************************************************/
	public function _checkFile($file){
		try{
				$handle = fopen($file,"r");
				$countRow = 1;
				while(($row = fgetcsv($handle, 1000, ",")) !== FALSE){
					mb_convert_variables("UTF-8", "auto", $row);
					$this->error = "";
					$targetrow = $this->_setContent($row);
					if($row[0] != "room"){
						// バリデーションチェック関数呼び出し
						$this->_elementNum($row);
						$this->_orBlank($row);
						$this->_checkHyphen($row[0]);
						$this->_integerOverZero($row[1]);
						$this->_checkSessionCombi($row[0], $row[1]);
						$this->_checkDate($row[3]);
						$this->_checkTime($row[0], $row[4], $row[5], $row[3]);
						$this->_chairPersonOne($row[6], $row[7]);
						$this->_commentatorsCheck($row[8], $row[9]);

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
			$content .= $row[$rowN];
			$content .= "  ";
			$rowN++;
		}
		return $content;
	}
	// 要素数は１０
	public function _elementNum($row){
		if(count($row) != 10){
			$this->error .= "Element number is wrong. Format needs 10 elements. <br>";
			$this->check = false;
		}
	}
	// 空項目がないか
	public function _orBlank($row){
		if($row[0] == "" || $row[1] == "" || $row[2] == "" || $row[3] == "" || $row[4] == "" || $row[5] == ""){
			$this->error .= "Blank element exists. <br>";
			$this->check = false;
		}
	}
	// roomのハイフン拒否
	public function _checkHyphen($room){
		if(strpos($room, "-") || $room[0] == "-"){
			$this->error .= "Can't use hyphen(-) in room. <br>";
			$this->check = false;
		}
	}
	// session order が0以上の整数どうか
	public function _integerOverZero($sesOrder){
		if((Int)$sesOrder < 0 || (string)$sesOrder !== (string)(Int)$sesOrder){
			$this->error .= "Session order needs an integer of 0 or more. <br>";
			$this->check = false;
		}
	}
	// room, orderの組み合わせが他と被らないこと
	public function _checkSessionCombi($room, $sesOrder){
		$i=0;
		while($i < count($this->sesGroup)){
			$targetRoom = key($this->sesGroup[$i]);
			$targetSesOrder = array_values($this->sesGroup[$i]);
			if($targetRoom == $room && $targetSesOrder[0] == $sesOrder && strtolower($room) != "all"){
				$r = $i+1;
				$this->error .= "Already exist this combination of this room and this order. ";
				$this->error .= "Overlap in row".$r." .<br>";
				$this->check = false;
				break;
			}
			$i++;
		}
		array_push($this->sesGroup, array($room => $sesOrder));
	}
	// dateがイベントに存在するかどうか
	public function _checkDate($date){
		if((Int)$date < 1 || $this->Event->dayDiff() < (Int)$date || (string)$date !== (string)(Int)$date){
			$this->error .= "Nothing date in this event. <br>";
			$this->check = false;
		}
	}
	// 時間として有効であること
	public function _checkTime($room, $start, $end, $date){

		$start = $this->_strToMin($start);
		$end = $this->_strToMin($end);
		$date = (Int)$date;
		if($end-$start <= 0 || $start < 0 || $start > 1440 || $end < 0 || $end > 1440){
			$this->error .= "Incorrect time value. <br>";
			$this->check = false;
		}
		$this->_overSession($room, $start, $end, $date);
	}
	// 同じ日のsessionと時間が被らないこと
	public function _overSession($r, $s, $e, $d){
		$i = 0;
		$gr = $this->timeGroup;
		while($i < count($gr)){
			$dupliRow = $i+1;
			if($gr[$i]['room'] == $r && $gr[$i]['date'] == $d){
				if(!($gr[$i]['end'] <= $s || $e <= $gr[$i]['start'])){
					$this->error .= "Over other session. row $dupliRow <br>";
					$this->check = false;
				}
			}
			// ALLとの比較
			if(strtolower($gr[$i]['room']) == 'all' && $gr[$i]['date'] == $d){
				if(!($gr[$i]['end'] <= $s || $e <= $gr[$i]['start'])){
					$this->error .= "Over other session. row $dupliRow <br>";
					$this->check = false;
				}
			}
			// ALL追加時
			if(strtolower($r) == 'all' && $gr[$i]['date'] == $d){
				if(!($gr[$i]['end'] <= $s || $e <= $gr[$i]['start'])){
					$this->error .= "Over other session. row $dupliRow <br>";
					$this->check = false;
				}
			}
			$i++;
		}
		array_push($this->timeGroup, array('room'=>$r, 'start'=>$s, 'end'=>$e, 'date'=>$d));
	}
	// 文字列を糞数で返す(ex. 12:30 -> 750)
	public function _strToMin($time){
		$timeStr = split(":", $time);
		// 時間が間違い
		if((string)$timeStr[0] !== (string)(Int)$timeStr[0] || (string)$timeStr[1] !== (string)(Int)$timeStr[1]){
			if($timeStr[1] != "00" && $timeStr != "0"){
				$this->error .= "Incorrect time value. <br>";
				$this->check = false;
			}
		}
		$t = (Int)$timeStr[0];
		$m = (Int)$timeStr[1];
		if(count($timeStr) != 2 || $t < 0 || 24 <  $t || $m < 0 || 60 <  $m){
			$this->error .= "Incorrect time value. <br>";
			$this->check = false;
		}
		return $t * 60 + $m;
	}
	// chair personは一人であること
	public function _chairPersonOne($name, $affili){
		if(strpos($name, ",") || strpos($affili, ",")){
			$this->error .= "Chair person is one. Can't use comma.<br>";
			$this->check = false;
		}
	}
	// commentatorsの名前と所属の項目数が合致すること
	public function _commentatorsCheck($name, $affili){
		if(substr_count($name, ',') !== substr_count($affili, ',')){
			$this->error .= "Commentators name and commentators affiliation is not match number. <br>";
			$this->check = false;
		}
	}

/******************************************************************
*******************saveのルーティング処理****************************
*******************************************************************/

	public function save_rooting(){
		$this->autoRender = false;
		// セッションからイベントid格納
		$this->request->data['Schedule']['event_id'] = $_SESSION['event_id'];
		if($this->request->is('post')){
			if($this->request->data['Schedule']['root_flag'] == "add-session"){
				// TODO roomがALLだったらいらない情報を消す & order=0
				if($this->request->data['Schedule']['room'] == "ALL"){
					$this->request->data['Schedule']['order'] = 0;
				}
				if($this->Schedule->add_session($this->request->data)){
					$this->redirect(array('action'=>'index'));
				}
			}
			if($this->data['Schedule']['root_flag'] == "update-session"){
				if($this->Schedule->update_session($this->request->data)){
					$this->redirect(array('action'=>'index'));
				}
			}
			if($this->data['Schedule']['root_flag'] == "delete-session"){
				if($this->Schedule->delete_session($this->request->data)){
					$this->redirect(array('action'=>'index'));
				}
			}
		}
	}
	public function del_session_ofRoom(){
		$this->autoRender = false;
		$options = array('event_id'=>$_SESSION['event_id'], 'room'=>$this->request->params['pass'][0]);
		if($this->Schedule->deleteAll($options)){
			$this->redirect(array('action'=>'index'));
		}
	}
	public function rename_session(){
		$this->autoRender = false;
		$newName = $this->request->params['named']['new'];
		unset($this->request->params['named']['new']);
		if($this->Schedule->hasAny($this->request->params['named'])){
			$this->Schedule->updateAll(array('room'=>"'" .$newName. "'"), $this->request->params['named']);
		}
		$this->redirect(array('action'=>'index'));
	}
}
?>