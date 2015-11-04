<?php
class PosMappsController extends AppController {

    public $helpers = array('Html', 'Form', 'Text');
    public $uses =array('Poster');
    public function index(){
//        $this->set('posters', $this->Poster->find('all'));
        $this->autoLayout=false;

    }
    public function makejson($id = null)
    {
        $result=$this->Poster->find('all');
        $this->set('posters', $result);
        $this->set('id',$id);
    }
    public function qr($id)
    {
        $this->set("id",$id);
    }
    public function  sendmail()
    {
            $content= Router::url('/PosMapps/phoneclear/', true);
            App::uses('CakeEmail','Network/Email');
            $Email = new CakeEmail('gmail');
            $Email->from(array('tkb.tsss@gmail.com' => 'POSTOM'))
                ->to('tkb.tsss@gmail.com')
                ->subject('PosMapp URL')
                ->send('<a href="'.$content.'"/>');
    }
    public function deletestorage()
    {}
    public function phoneclear()
    {
        $this->autoLayout=false;
    }
}
?>