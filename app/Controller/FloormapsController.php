<?php
class FloormapsController extends AppController {

	public $helpers = array('Html', 'Form', 'Text');
	public $uses = array('Event');
	public function index(){
		$this->Event->id = $_SESSION['event_id'];
		$this->set('event', $this->Event->read());
	}
	public function setmap()
	{
		$content= Router::url('/floormaps', true);
		$this->Event->id = $_SESSION['event_id'];
		$eventOld=$this->Event->read();
		$test="";
		if($eventOld['Event']['set_floormap']==true)
		{
			$eventNew=array('Event'=>array('id'=>$_SESSION['event_id'],'set_floormap'=>false));
			$fields=array('set_floormap');
			$this->Event->save($eventNew,false,$fields);

			$this->Event->id = $_SESSION['event_id'];
			$eventNew=$this->Event->read();
			$test="this is true   ".$eventNew['Event']['set_floormap'];
		}
		else if($eventOld['Event']['set_floormap']==false) {
			$eventNew=array('Event'=>array('id'=>$_SESSION['event_id'],'set_floormap'=>true));
			$fields=array('set_floormap');
			$this->Event->save($eventNew,false,$fields);

			$this->Event->id = $_SESSION['event_id'];
			$eventNew=$this->Event->read();
			$test="this is false   ".$eventNew['Event']['set_floormap'];
		}
		$this->set('message',$eventOld['Event']['set_floormap']."        ".$test);
		header("Location: ".$content);
	}

	public function upload()
	{

		if ((($_FILES["file"]["type"] == "image/gif")
				|| ($_FILES["file"]["type"] == "image/jpg")
				|| ($_FILES["file"]["type"] == "image/jpeg")
				|| ($_FILES["file"]["type"] == "image/png")
				|| ($_FILES["file"]["type"] == "image/pjpeg"))
			&& ($_FILES["file"]["size"] < 2000000))
		{
			if ($_FILES["file"]["error"] > 0)
			{
				$this->set("message","Return Code: " . $_FILES["file"]["error"] . "<br />") ;
			}
			else
			{
				if (file_exists("floormap/".$_SESSION["event_str"]."." ."jpg"))
				{
					unlink("floormap/".$_SESSION["event_str"]."." ."jpg");
				}
				if (file_exists("floormap/".$_SESSION["event_str"]."."  ."png"))
				{
					unlink("floormap/".$_SESSION["event_str"]."." ."png");
				}
				if (file_exists("floormap/".$_SESSION["event_str"]."."  ."gif"))
				{
					unlink("floormap/".$_SESSION["event_str"]."." ."gif");
				}
				move_uploaded_file($_FILES["file"]["tmp_name"],
					$this->Html->webroot  ."floormap/".$_SESSION["event_str"].".". pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
				$this->set("message", $_FILES["file"]["name"] . " upload success!");
				$event=array('Event'=>array('id'=>$_SESSION['event_id'],'set_floormap'=>true));
				$fields=array('set_floormap');
				$this->Event->save($event,false,$fields);
			}
		}
		else
		{
			$this->set("message",$_FILES["file"]["type"].$_FILES["file"]["size"]. "Invalid file");
		}
	}

}
