<?php
class PosMappsController extends AppController {

    public $helpers = array('Html', 'Form', 'Text');
    public $uses =array('Poster');
    public function index(){
//        $this->set('posters', $this->Poster->find('all'));
        $this->autoLayout=false;

    }
    public function makejson()
    {
        $result=$this->Poster->find('all');
        $this->set('posters', $result);
    }
    public function qr($id)
    {
        $this->set("id",$id);
    }
    public function  sendmail()
    {
            $content= Router::url('/PosMapps/index/', true);
            App::uses('CakeEmail','Network/Email');
            $Email = new CakeEmail('gmail');
            $Email->from(array('tkb.tsss@gmail.com' => 'POSTOM'))
                ->to('tkb.tsss@gmail.com')
                ->subject('PosMapp URL')
                ->send('<a href="'.$content.'"/>');
    }

}
?>