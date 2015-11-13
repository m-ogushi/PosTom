<?php
class FloormapsController extends AppController {

    public $helpers = array('Html', 'Form', 'Text');
    public function index(){

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
                if (file_exists("floormap/".$_SESSION["event_id"]."." ."jpg"))
                {
                    unlink("floormap/".$_SESSION["event_id"]."." ."jpg");
                }
                if (file_exists("floormap/".$_SESSION["event_id"]."."  ."png"))
                {
                    unlink("floormap/".$_SESSION["event_id"]."." ."png");
                }
                if (file_exists("floormap/".$_SESSION["event_id"]."."  ."gif"))
                {
                    unlink("floormap/".$_SESSION["event_id"]."." ."gif");
                }
                move_uploaded_file($_FILES["file"]["tmp_name"],
                    $this->Html->webroot  ."floormap/".$_SESSION["event_id"].".". pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
                $this->set("message", $_FILES["file"]["name"] . " upload success!");
            }
        }
        else
        {
            $this->set("message",$_FILES["file"]["type"].$_FILES["file"]["size"]. "Invalid file");
        }
    }

}