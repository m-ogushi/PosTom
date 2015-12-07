<?php
class PosMappsController extends AppController {
	public $helpers = array('Html', 'Form', 'Text');
	public $uses =array('Poster','Event','Schedule');
	public function index(){
//        $this->set('posters', $this->Poster->find('all'));
		$this->autoLayout=false;
	}
	public function makejson()
	{
		$this->Event->id = $_SESSION['event_id'];
		$event= $this->Event->read();
		$floormap=false;
		if($event['Event']['set_floormap']==true)
		{
			$floormap=true;
		}
		$posters=
			$this->Poster->find('all', array(
				'conditions' => array('event_id' => $_SESSION['event_id'])
			));

		$url="";
		if($floormap==true)
		{
			if (file_exists("floormap/".$_SESSION["event_str"]."." ."jpg"))
			{
				$url='"venuemap":"'.str_replace('/','\/', $this->webroot).'floormap\/'.$_SESSION["event_str"] .'.jpg",';
			}
			else  if (file_exists("floormap/".$_SESSION["event_str"]."."  ."png"))
			{
				$url='"venuemap":"'.str_replace('/','\/', $this->webroot).'floormap\/'.$_SESSION["event_str"] .'.png",';
			}
			else  if (file_exists("floormap/".$_SESSION["event_str"]."."  ."gif"))
			{
				$url='"venuemap":"'.str_replace('/','\/', $this->webroot).'floormap\/'.$_SESSION["event_str"] .'.gif",';
			}
		}

		$topImg='img\/thumb\/toppage_pbla.png';
		if (file_exists("img/thumb/".$_SESSION["event_str"]."." ."jpeg"))
		{
			$topImg='img\/thumb\/'.$_SESSION["event_str"] .'.jpeg';
		}
		else if (file_exists("img/thumb/".$_SESSION["event_str"]."." ."jpg"))
		{
			$topImg='img\/thumb\/'.$_SESSION["event_str"] .'.jpg';
		}
		else if (file_exists("img/thumb/".$_SESSION["event_str"]."."  ."png"))
		{
			$topImg='img\/thumb\/'.$_SESSION["event_str"] .'.png';
		}
		else if (file_exists("img/thumb/".$_SESSION["event_str"]."."  ."gif"))
		{
			$topImg='img\/thumb\/'.$_SESSION["event_str"] .'.gif';
		}

		$posmapp_bg='img\/thumb\/toppage_pbla.png';
		if (file_exists("img/bg/".$_SESSION["event_str"]."." ."jpeg"))
		{
			$posmapp_bg='img\/bg\/'.$_SESSION["event_str"] .'.jpeg';
		}
		else if (file_exists("img/bg/".$_SESSION["event_str"]."." ."jpg"))
		{
			$posmapp_bg='img\/bg\/'.$_SESSION["event_str"] .'.jpg';
		}
		else if (file_exists("img/bg/".$_SESSION["event_str"]."."  ."png"))
		{
			$posmapp_bg='img\/bg\/'.$_SESSION["event_str"] .'.png';
		}
		else if (file_exists("img/bg/".$_SESSION["event_str"]."."  ."gif"))
		{
			$posmapp_bg='img\/bg\/'.$_SESSION["event_str"] .'.gif';
		}
		$JsonFile='{"toppage_img":"'. str_replace('/','\/',$this->webroot).$topImg.'","posmapp_bg":["'.str_replace('/','\/',$this->webroot).$posmapp_bg.'"],'.$url.'"STATIC_WIDTH":"720","STATIC_HEIGHT":"960",';
		//echo str_replace('/','\/',$this->webroot);
		$JsonPosition='"position":[';
		$JsonAuthor='"author":[';
		$JsonPresent='"presen":[';
		$JsonPoster='"poster":[';
		$JsonKeyword = '"keyword":[';

		$pointerPoster=1;
		$pointerPresen=1;
		foreach($posters as $poster):
			$JsonPosition.='{';
			$JsonPosition.='"id":'.'"'.$poster['Poster']['id'].'",';
			$JsonPosition.='"x":'.'"'.$poster['Poster']['x'].'",';
			$JsonPosition.='"y":'.'"'.$poster['Poster']['y'].'",';
			$JsonPosition.='"width":'.'"'.$poster['Poster']['width'].'",';
			$JsonPosition.='"height":'.'"'.$poster['Poster']['height'].'",';
			$JsonPosition.='"direction":'.'"sideways"';
			$JsonPosition.='}';


			if($poster['Poster']['presentation_id'] == 0){
				$JsonPoster.='{';
				$JsonPoster.='"presenid":"No Presen'.$pointerPresen.'",';
				$JsonPoster.='"posterid":"'  .$poster['Poster']['id'].  '",';
				$JsonPoster.='"star":"1",';
				$JsonPoster.='"date":"'.$poster['Poster']['date'].'"';
				$JsonPoster.='}';

				$JsonPresent.='{';
				$JsonPresent.='"presenid":"No Presen'.$pointerPresen.'",';
				$JsonPresent.='"title":"No data",';
				$JsonPresent.='"abstract":"No data",';
				$JsonPresent.='"bookmark":"0"';
				$JsonPresent.='}';

				// TODO: Author������ɃR���}�ŕ�������JSON�ɋL�q����K�v������
				$JsonAuthor.='{';
				$JsonAuthor.='"presenid":"No Presen'.$pointerPresen.'",';
				$JsonAuthor.='"name":"No data",';
				$JsonAuthor.='"belongs":"No data",';
				$JsonAuthor.='"first":"1"';
				$JsonAuthor.='}';

				// TODO: Keyword������ɃR���}�ŕ�������JSON�ɋL�q����K�v������
				$JsonKeyword .= '{';
				$JsonKeyword .= '"presenid":"No Presen'.$pointerPresen.'",';
				$JsonKeyword .= '"keyword":"No data"';
				$JsonKeyword .= '}';

				$pointerPresen++;

				$relatedPre = $this->requestAction('/presentations/getByEventID/'.$_SESSION['event_id']);
				if($pointerPoster<count($posters)) {
						$JsonPresent .=',';
						$JsonAuthor .=',';
						$JsonKeyword .=',';
				}
				else if($relatedPre!=null) {
						$JsonPresent .=',';
						$JsonAuthor .=',';
						$JsonKeyword .=',';
				}

			} else{
				$thispresen = $this->requestAction('/presentations/getByID/'.$poster['Poster']['presentation_id']);

				$JsonPoster.='{';
				$JsonPoster.='"presenid":"'.$thispresen[0]['Presentation']['room'].$thispresen[0]['Presentation']['session_order'].'-'.$thispresen[0]['Presentation']['presentation_order'].'",';
				$JsonPoster.='"posterid":"'  .$poster['Poster']['id'].  '",';
				$JsonPoster.='"star":"1",';
				$JsonPoster.='"date":"'.$poster['Poster']['date'].'"';
				$JsonPoster.='}';
			}



			if($pointerPoster<count($posters)){
				$pointerPoster++;
				$JsonPoster.=',';
				$JsonPosition.=',';
			}

		endforeach;
		$pointer=1;
		$relatedPre = $this->requestAction('/presentations/getByEventID/'.$_SESSION['event_id']);
		foreach($relatedPre as $presentation):
			$JsonPresent.='{';
			$JsonPresent.='"presenid":"'.$presentation['Presentation']['room'].$presentation['Presentation']['session_order'].'-'.$presentation['Presentation']['presentation_order'].'",';
			$JsonPresent.='"title":"'.$presentation['Presentation']['title'].'",';
			$JsonPresent.='"abstract":"'.$presentation['Presentation']['abstract'].'",';
			$JsonPresent.='"bookmark":"0"';
			$JsonPresent.='}';

			// TODO: Author������ɃR���}�ŕ�������JSON�ɋL�q����K�v������
			$JsonAuthor.='{';
			$JsonAuthor.='"presenid":"'.$presentation['Presentation']['room'].$presentation['Presentation']['session_order'].'-'.$presentation['Presentation']['presentation_order'].'",';
			$JsonAuthor.='"name":"' .$presentation['Presentation']['authors_name']. '",';
			$JsonAuthor.='"belongs":"' .$presentation['Presentation']['authors_affiliation']. '",';
			$JsonAuthor.='"first":"1"';
			$JsonAuthor.='}';

			// TODO: Keyword������ɃR���}�ŕ�������JSON�ɋL�q����K�v������
			$JsonKeyword .= '{';
			$JsonKeyword .= '"presenid":"'.$presentation['Presentation']['room'].$presentation['Presentation']['session_order'].'-'.$presentation['Presentation']['presentation_order'].'",';
			$JsonKeyword .= '"keyword":"' .$presentation['Presentation']['keyword']. '"';
			$JsonKeyword .= '}';

			if($pointer<count($relatedPre)){
				$pointer=$pointer+1;
				$JsonAuthor.=',';
				$JsonPresent.=',';
				$JsonKeyword .= ',';
			}
		endforeach;
//        $pointer=1;
//        foreach($schedules as $schedule):
//
//
//            $JsonSession .= '{';
//            $JsonSession .= '"sessionid":"' .$schedule['Schedule']['room'].$schedule['Schedule']['order']. '",';
//            $JsonSession .= '"title":"' .$schedule['Schedule']['category']. '"';
//            $JsonSession .= '"chairpersonname":"' .$schedule['Schedule']['chairperson_name']. '"';
//            $JsonSession .= '"chairpersonaffiliation":"' .$schedule['Schedule']['chairperson_affiliation']. '"';
//            $JsonSession .= '"date":"' .$schedule['Schedule']['date']. '"';
//            $JsonSession .= '"start_time":"' .$schedule['Schedule']['start_time']. '"';
//            $JsonSession .= '"end_time":"'.$schedule['Schedule']['end_time']. '"';
//            $JsonSession .= '}';
//
//            if($pointer<count($posters)){
//                $pointer=$pointer+1;
//                $JsonSession .= ',';
//            }
//        endforeach;
		if(substr($JsonPosition,-1)==",")
		{
			$JsonPosition=substr($JsonPosition,0,strlen($JsonPosition)-1);
			$JsonAuthor=substr($JsonAuthor,0,strlen($JsonAuthor)-1);
			$JsonPresent=substr($JsonPresent,0,strlen($JsonPresent)-1);
			$JsonPoster=substr($JsonPoster,0,strlen($JsonPoster)-1);
			$JsonKeyword=substr($JsonKeyword,0,strlen($JsonKeyword)-1);
		}


		$JsonPosition.='],';
		$JsonAuthor.='],';
		$JsonPresent.='],';
		$JsonPoster.='],';
		$JsonKeyword .= ']';

		$JsonFile.=$JsonPosition.$JsonAuthor.$JsonPresent.$JsonPoster.$JsonKeyword.'}';
		//echo $JsonFile;

		// JSON�֕ϊ����ď�������
		$filename ='../webroot/json/'.$_SESSION['event_str'].'.json';

		$handle = fopen($filename, 'w');
		fwrite($handle,$JsonFile);
		fclose($handle);
		//echo 'save successed!';

	}
	public function qr($id)
	{
		$this->makejson();
	}
	public function  sendmail()
	{
		$user = AuthComponent::user();
		$mailAdress = $user['email'];

		$this->Email->sendAs = 'html';
		$content= Router::url('/PosMapps/phoneclear/'.$_SESSION['event_str'], true);
		App::uses('CakeEmail','Network/Email');
		$Email = new CakeEmail('gmail');
		$Email->from(array('tkb.tsss@gmail.com' => 'POSTOM'))
			->to($mailAdress)
			->subject('PosMapp Preview')
			->send('Please click the following link if you want to preview PosmApp :'.$content);
	}
	public function deletestorage()
	{
		$this->makejson();
	}
	public function phoneclear()
	{
		$this->autoLayout=false;
	}
}
?>
