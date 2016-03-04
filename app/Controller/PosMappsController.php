<?php
class PosMappsController extends AppController {
    public $helpers = array('Html', 'Form', 'Text');
    public $uses =array('Poster','Event','Schedule','Area','Disuse','Room');
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('index', 'deletestorage', 'makejson', 'phoneclear', 'qr', 'sendmail'));
    }
    public function index(){
//        $this->set('posters', $this->Poster->find('all'));
        $this->autoLayout=false;
    }
    public function makejson()
    {
        $this->Event->id = $_SESSION['event_id'];
        $event = $this->Event->read();



        $floormap = false;
        if ($event['Event']['set_floormap'] == true) {
            $floormap = true;
        }
        $disuses=$this->Disuse->find('all', array(
            'conditions' => array('event_id' => $_SESSION['event_id'])
        ));
        $posters =
            $this->Poster->find('all', array(
                'conditions' => array('event_id' => $_SESSION['event_id'])
            ));
        $where=array(
            'conditions' => array('event_id' => $_SESSION['event_id']), //検索条件の配列
            "order" => array("room" => "ASC","order" => "ASC")
        );
        $schedules = $this->Schedule->find('all',$where);
        $areas =
            $this->Area->find('all', array(
                'conditions' => array('event_id' => $_SESSION['event_id'])
            ));
        $rooms=
            $this->Room->find('all', array(
                'conditions' => array('event_id' => $_SESSION['event_id'])
            ));
        //--------------------------------------------------------------------------------------------------floor map----------------------------------------------------------------------
        $url = '"venuemap":"",';
        if ($floormap == true) {
            if (file_exists("floormap/" . $_SESSION["event_str"] . "." . "jpg")) {
                $url = '"venuemap":"' . str_replace('/', '\/', $this->webroot) . 'floormap\/' . $_SESSION["event_str"] . '.jpg",';
            } else if (file_exists("floormap/" . $_SESSION["event_str"] . "." . "png")) {
                $url = '"venuemap":"' . str_replace('/', '\/', $this->webroot) . 'floormap\/' . $_SESSION["event_str"] . '.png",';
            } else if (file_exists("floormap/" . $_SESSION["event_str"] . "." . "gif")) {
                $url = '"venuemap":"' . str_replace('/', '\/', $this->webroot) . 'floormap\/' . $_SESSION["event_str"] . '.gif",';
            }
        }
        //--------------------------------------------------------------------------------------------------top image----------------------------------------------------------------------
        $topImg = 'img\/thumb\/toppage_pbla.png';
        if (file_exists("img/thumb/" . $_SESSION["event_str"] . "." . "jpeg")) {
            $topImg = 'img\/thumb\/' . $_SESSION["event_str"] . '.jpeg';
        } else if (file_exists("img/thumb/" . $_SESSION["event_str"] . "." . "jpg")) {
            $topImg = 'img\/thumb\/' . $_SESSION["event_str"] . '.jpg';
        } else if (file_exists("img/thumb/" . $_SESSION["event_str"] . "." . "png")) {
            $topImg = 'img\/thumb\/' . $_SESSION["event_str"] . '.png';
        } else if (file_exists("img/thumb/" . $_SESSION["event_str"] . "." . "gif")) {
            $topImg = 'img\/thumb\/' . $_SESSION["event_str"] . '.gif';
        }
        //--------------------------------------------------------------------------------------------------posmapp BG--------------------------------------------------------
        $startDate = $event['Event']['event_begin_date'];
        $endDate = $event['Event']['event_end_date'];
        $dif = $this->diffBetweenTwoDays($startDate, $endDate) + 1;
        //$this->set("message", $startDate . $endDate . "dif:" . $dif);
        $posmapp_bg = '';

        $j=0;
        for($i=1;$i<=$dif;$i++)
        {
            if($i==$disuses[$j]['Disuse']['date']) {
                $j++;
            }else{
                $posmapp_tmp='';
                if (file_exists("img/bg/".$_SESSION["event_str"]."_".$i.".jpeg"))
                {
                    $posmapp_tmp.=str_replace('/','\/',$this->webroot).'img\/bg\/'.$_SESSION["event_str"] .'_'.$i.'.jpeg';
                }
                else if (file_exists("img/bg/".$_SESSION["event_str"]."_".$i .".jpg"))
                {
                    $posmapp_tmp.=str_replace('/','\/',$this->webroot).'img\/bg\/'.$_SESSION["event_str"] .'_'.$i.'.jpg';
                }
                else if (file_exists("img/bg/".$_SESSION["event_str"]."_".$i.".png"))
                {
                    $posmapp_tmp.=str_replace('/','\/',$this->webroot).'img\/bg\/'.$_SESSION["event_str"] .'_'.$i.'.png';
                }
                else if (file_exists("img/bg/".$_SESSION["event_str"]."_".$i.".gif"))
                {
                    $posmapp_tmp.=str_replace('/','\/',$this->webroot).'img\/bg\/'.$_SESSION["event_str"] .'_'.$i.'.gif';
                }
                if ($posmapp_tmp == '') {
                    $posmapp_tmp =str_replace('/','\/',$this->webroot).'img\/thumb\/toppage_pbla.png';
                }
                $posmapp_bg.='"'.$posmapp_tmp.'",';
            }
        }
        if(substr($posmapp_bg,-1)==",") {
            $posmapp_bg = substr($posmapp_bg, 0, strlen($posmapp_bg) - 1);
        }
        //--------------------------------------------------------------------------------------------------Basic Info------------------------------------------------------------------------------------
        $JsonFile='{
        "basic_info" : {
            "event_name_full" : "' . $event['Event']['event_name'] . '",
            "event_name_short" : "' . $event['Event']['short_event_name'] . '",
            "start_date" : "' . $event['Event']['event_begin_date'] . '",
            "end_date" : "' .$event['Event']['event_end_date'] . '",
            "venue" : "'. $event['Event']['event_location'] .'",
            "event_webpage" : "' . $event['Event']['event_webpage'] . '"
        },
        "toppage_img":"'. str_replace('/','\/',$this->webroot).$topImg.'",
        "posmapp_bg":['.$posmapp_bg.'],'.$url.'

        "STATIC_WIDTH":"720",
        "STATIC_HEIGHT":"960",';
        //echo str_replace('/','\/',$this->webroot);
        $JsonArea='"taparea" : [';
        $JsonComentator='"commentator":[';
        $JsonPosition='"position":[';
        $JsonAuthor='"author":[';
        $JsonPresent='"presen":[';
        $JsonPoster='"poster":[';
        $JsonKeyword = '"keyword":[';
        $JsonSession='"session":[';
        $JsonDay='
        "timetable":[
        ';

        $pointer=0;
        foreach($areas as $area):
            $JsonArea.='{';
            $JsonArea.='"id":'.$area['Area']['id'].',';
            $JsonArea.='"x":'. $area['Area']['x'].',';
            $JsonArea.='"y":'. $area['Area']['y'].',';
            $JsonArea.='"width":'.$area['Area']['width'].',';
            $JsonArea.='"height":'.$area['Area']['height'].',';
            $JsonArea.='"date":'.$area['Area']['date'].',';
            $JsonArea.='"direction":"longways",';
            $JsonArea.='"date":'.$area['Area']['date'].',';
            $JsonArea.='"name":"'.$area['Area']['name'].'",';

            $color=$area['Area']['color'];
            $color_r=hexdec("$color[1]"."$color[2]") ;
            $color_g=hexdec("$color[3]"."$color[4]");
            $color_b=hexdec("$color[5]"."$color[6]");
            $JsonArea.='"color":"rgb('.$color_r.','.$color_g.','.$color_b.')"';
            $JsonArea.='}';
            if($pointer< count($areas))
            {
                $JsonArea.=',';
            }
        endforeach;


        //----------------------------------------------------------------------------------------------------------------position,poster------------------------------------------------------------------------------------
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


                // TODO: Authorをさらにコンマで分割してJSONに記述する必要がある
                $JsonAuthor.='{';
                $JsonAuthor.='"presenid":"No Presen'.$pointerPresen.'",';
                $JsonAuthor.='"name":"No data",';
                $JsonAuthor.='"affiliation":"No data",';
                $JsonAuthor.='"first":"1"';
                $JsonAuthor.='}';


                // TODO: Keyword?ｿｽ?ｿｽ?ｿｽ?ｿｽ?ｿｽ?ｿｽﾉコ?ｿｽ?ｿｽ?ｿｽ}?ｿｽﾅ包ｿｽ?ｿｽ?ｿｽ?ｿｽ?ｿｽ?ｿｽ?ｿｽJSON?ｿｽﾉ記?ｿｽq?ｿｽ?ｿｽ?ｿｽ?ｿｽK?ｿｽv?ｿｽ?ｿｽ?ｿｽ?ｿｽ?ｿｽ?ｿｽ
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

        //--------------------------------------------------------------------------------------------------present,author,keyword----------------------------------------------------------------------
        $pointer=1;
        $relatedPre = $this->requestAction('/presentations/getByEventID/'.$_SESSION['event_id']);
        foreach($relatedPre as $presentation):
            $abs=str_replace("\\",'\\\\',$presentation['Presentation']['abstract']);
            $JsonPresent.='{';
            $JsonPresent.='"presenid":"'.$presentation['Presentation']['room'].$presentation['Presentation']['session_order'].'-'.$presentation['Presentation']['presentation_order'].'",';
            $JsonPresent.='"title":"'.$presentation['Presentation']['title'].'",';
            $JsonPresent.='"abstract":"'.$abs.'",';
            $JsonPresent.='"bookmark":"0"';
            $JsonPresent.='}';

            // TODO: Authorをさらにコンマで分割してJSONに記述する必要がある

            $arr = explode(",",$presentation['Presentation']['authors_name']);
            $brr = explode(",",$presentation['Presentation']['authors_affiliation']);
            if(count($arr)==0)
            {
                $JsonAuthor .= '{';
                $JsonAuthor .= '"presenid":"' . $presentation['Presentation']['room'] . $presentation['Presentation']['session_order'] . '-' . $presentation['Presentation']['presentation_order'] . '",';
                $JsonAuthor .= '"name":"' .$presentation['Presentation']['authors_name'] . '",';
                $JsonAuthor .= '"affiliation":"' . $presentation['Presentation']['authors_affiliation'] . '",';
                $JsonAuthor .= '"first":"1"';
                $JsonAuthor .= '}';
            }
            else{
                for($i=0;$i<count($arr);$i++) {
                    $JsonAuthor .= '{';
                    $JsonAuthor .= '"presenid":"' . $presentation['Presentation']['room'] . $presentation['Presentation']['session_order'] . '-' . $presentation['Presentation']['presentation_order'] . '",';
                    $JsonAuthor .= '"name":"' . $arr[$i] . '",';
                    $JsonAuthor .= '"affiliation":"' . $brr[$i] . '",';
                    if($i==0) {
                        $JsonAuthor .= '"first":"1"';
                    }else{
                        $JsonAuthor.= '"first":"0"';
                    }

                    if($i==count($arr)-1) {
                        $JsonAuthor .= '}';
                    }
                    else{$JsonAuthor .= '},';}

                }
            }
            // TODO: Keywordをさらにコンマで分割してJSONに記述する必要がある
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

        //--------------------------------------------------------------------------------------------------session--------------------------------------------------------
        $pointer=1;
        foreach($schedules as $schedule):
            if($schedule['Schedule']['room']!="break"&&$schedule['Schedule']['order']!=0) {

                $JsonSession .= '{';
                $JsonSession .= '"sessionid":"' . $schedule['Schedule']['room'] . $schedule['Schedule']['order'] . '",';
                $JsonSession .= '"title":"' . $schedule['Schedule']['category'] . '",';
                $JsonSession .= '"chairpersonname":"' . $schedule['Schedule']['chairperson_name'] . '",';
                $JsonSession .= '"chairpersonaffiliation":"' . $schedule['Schedule']['chairperson_affiliation'] . '"';
                $JsonSession .= '}';
                $arr = explode(",",$schedule['Schedule']['commentator_name']);
                $brr = explode(",",$schedule['Schedule']['commentator_affiliation']);
                for($i=0;$i<count($arr);$i++) {
                    $JsonComentator .= '{';
                    $JsonComentator .= '"sessionid":"' . $schedule['Schedule']['room'] . $schedule['Schedule']['order'] . '",';
                    $JsonComentator .= '"name":"' .$arr[$i] . '",';
                    $JsonComentator .= '"affiliation":"'  .$brr[$i]  . '"';
                    $JsonComentator .= '},';
                }


                if ($pointer < count($schedules)) {
                    $pointer = $pointer + 1;
                    $JsonSession .= ',';
                }
            }


        endforeach;


        //---------------------------------------------------------------------------------------------------timetable--------------------------------------------------------------------------------------------------

        $where=array(
            'conditions' => array('event_id' => $_SESSION['event_id']), //検索条件の配列
            'group' => array('date')
        );

        $schedules = $this->Schedule->find('all',$where);
        $dateplus=0;
        for($i=$schedules[0]['Schedule']['date']-1;$i<$schedules[count($schedules)-1]['Schedule']['date'];$i++)
        {

            $this->Event->id = $_SESSION['event_id'];
            $event= $this->Event->read();
            $date=$event['Event']['event_begin_date'];
            $monthday=explode("-",date('Y-m-d',strtotime('+'.$dateplus++.' day',strtotime($date))));
            $monthdayStr=$monthday[1]."/".(string)(((int)$monthday[2]));
            //TODO:時間確認

            $JsonDay .= '{';
            $JsonDay .= '"day_id":"' . $schedules[$i]['Schedule']['date'] . '",';
            $JsonDay .= '"day":"' . $monthdayStr . '",';
            $JsonDay .= '"schedule":[';

            //------------------------------------------------------------------------------------------------schedule--------------------------------------------------------------------------------------------------
            $where=array(
                'conditions' => array('event_id' => $_SESSION['event_id'],'date'=>(string)$schedules[$i]['Schedule']['date']), //検索条件の配列
                "order" => array("start_time"=>"ASC")
            );
            $sessions = $this->Schedule->find('all',$where);

            for($j=0;$j<count($sessions);$j++)
            {
                $JsonDay .= '{';
                $startTime= explode(":",$sessions[$j]['Schedule']['start_time'] );
                $endTime= explode(":",$sessions[$j]['Schedule']['end_time'] );

                $JsonDay .= '"start_time":"' .$startTime[0].":".$startTime[1] . '",';
                $JsonDay .= '"end_time":"'.$endTime[0].":".$endTime[1]  . '",';
                if( $sessions[$j]['Schedule']['room']=="ALL") {
                    $JsonDay .= '"slot_type":"break",';
                }
                else{
                    $JsonDay .= '"slot_type":"session",';
                }
                $JsonDay .= '"time_display":"all",';
                $JsonDay .= '"sessions": [';

                //-------------------------------------------------------------------------------------------------sessions--------------------------------------------------------------------------------------------------
                $whilePointStart=$j;
                $whilePointEnd=$j;
                while(true)
                {

                    if( $sessions[$whilePointEnd]['Schedule']['end_time']== $sessions[$whilePointEnd+1]['Schedule']['end_time']&& $sessions[$whilePointEnd]['Schedule']['start_time']== $sessions[$whilePointEnd+1]['Schedule']['start_time'])
                    {
                        $j++;
                        $whilePointEnd++;
                    }
                    else
                    {
                        break;
                    }
                }
                $sessionList = null;
                if($sessions[$whilePointStart]['Schedule']['room']=="ALL")
                {
                    $sessionList[1]=$sessions[$whilePointStart];
                }
                else {

                    for ($a = 0; $a <= $whilePointEnd - $whilePointStart; $a++) {
                        for ($b = 0; $b < count($rooms); $b++) {
                            if ($rooms[$b]['Room']['name'] == $sessions[$whilePointStart + $a]['Schedule']['room']) {
                                $sessionList[$rooms[$b]['Room']['order']] = $sessions[$whilePointStart + $a];
                            }

                        }
                    }
                }
                for($p=1;$p<=count($rooms) ;$p++)
                {
                    if($sessionList[$p]!=null) {
                        $JsonDay .= '{';
                        if ($sessionList[$p]['Schedule']['room'] == "break") {
                            $JsonDay .= '"room":"",';
                        } else {
                            if($sessionList[$p]['Schedule']['room']!="ALL") {
                                $JsonDay .= '"room":"' . $sessionList[$p]['Schedule']['room'] . '",';
                            }
                            else{
                                $JsonDay .= '"room":"",';
                            }
                        }
                        if ($sessionList[$p]['Schedule']['order'] == 0) {
                            $JsonDay .= '"sessionid": "",';
                        } else {
                            $JsonDay .= '"sessionid":"' . $sessionList[$p]['Schedule']['room'] . $sessionList[$p]['Schedule']['order'] . '",';
                        }
                        $JsonDay .= '"session_name":"' . $sessionList[$p]['Schedule']['category'] . '"},';
                    }
                }
                if(substr($JsonDay,-1)==",") {
                    $JsonDay = substr($JsonDay, 0, strlen($JsonDay) - 1);
                }
                $JsonDay .= ']';
                if($j==count($sessions)-1) {
                    $JsonDay .= '}';
                }else{
                    $JsonDay .= '},';
                }
            }
            if($i===$schedules[count($schedules)-1]['Schedule']['date']) {
                $JsonDay .= ']}';
            }else{
                $JsonDay .= ']},';
            }
        }

        //---------------------------------------------------------------------------------------------------------delete last "," ------------------------------------------------------------------------------------------------------------------------------
        if(substr($JsonArea,-1)==",")
        {
            $JsonArea=substr($JsonArea, 0, strlen($JsonArea) - 1);
        }

        if(substr($JsonComentator,-1)==",")
        {
            $JsonComentator=substr($JsonComentator, 0, strlen($JsonComentator) - 1);
        }
        if(substr($JsonPosition,-1)==",") {
            $JsonPosition = substr($JsonPosition, 0, strlen($JsonPosition) - 1);
            $JsonPoster = substr($JsonPoster, 0, strlen($JsonPoster) - 1);
        }
        if(substr($JsonAuthor,-1)==",") {
            $JsonAuthor = substr($JsonAuthor, 0, strlen($JsonAuthor) - 1);
        }
        if(substr($JsonPresent,-1)==",") {
            $JsonPresent = substr($JsonPresent, 0, strlen($JsonPresent) - 1);
        }
        if(substr($JsonKeyword,-1)==",") {
            $JsonKeyword = substr($JsonKeyword, 0, strlen($JsonKeyword) - 1);
        }
        if(substr($JsonSession,-1)==",") {
            $JsonSession = substr($JsonSession, 0, strlen($JsonSession) - 1);
        }
        if(substr($JsonDay,-1)==",") {
            $JsonDay = substr($JsonDay, 0, strlen($JsonDay) - 1);
        }


        //------------------------------------------------------------------------------------------------------- plus "]"------------------------------------------------------------------------------------------------------------------------------
        $JsonArea.='],';
        $JsonComentator.='],';
        $JsonPosition.='],';
        $JsonAuthor.='],';
        $JsonPresent.='],';
        $JsonPoster.='],';
        $JsonKeyword .= '],';
        $JsonSession .= '],';
        $JsonDay .= ']';

        //---------------------------------------------------------------------------------------------------------make all together------------------------------------------------------------------------------------------------------------------------------
        $JsonFile.=$JsonArea.$JsonComentator.$JsonPosition.$JsonAuthor.$JsonPresent.$JsonPoster.$JsonKeyword.$JsonSession.$JsonDay.'}';
        //echo $JsonFile;


        //-----------------------------------------------------------------------------------------------------------Save Json------------------------------------------------------------------------------------------------------------------------------
        // JSONへ変換して書き込み
        $filename ='../webroot/json/'.$_SESSION['event_str'].'.json';

        $handle = fopen($filename, 'w');
        fwrite($handle,$JsonFile);
        fclose($handle);
        $version ="1.00";
        $filenameVersion="json/".$_SESSION["event_str"]."_version.json";
        if(file_exists($filenameVersion))
        {
            $version=file_get_contents($filenameVersion);
            $arr = json_decode($version,true);
            $version =$arr["version"]+0.01;
        }
        $versionContent='{
  "version" : '.$version.'
}';
        $handleVersion= fopen($filenameVersion, 'w');
        fwrite($handleVersion,$versionContent);
        fclose($handleVersion);

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
        $this->autoLayout=false;
        $this->makejson();
    }
    public function phoneclear()
    {
        $this->autoLayout=false;
    }
    public function clear()
    {
        $this->autoLayout=false;
    }
    function diffBetweenTwoDays ($day1, $day2)
    {
        $second1 = strtotime($day1);
        $second2 = strtotime($day2);

        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }
        return ($second1 - $second2) / 86400;
    }
}
?>
