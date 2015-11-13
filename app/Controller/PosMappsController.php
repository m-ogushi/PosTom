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
        $result=$this->Poster->find('all');
        $this->set('posters', $result);
        $this->set("id",$id);
    }
    public function  sendmail()
    {
        $user = AuthComponent::user();
        $mailAdress = $user['email'];

        $this->Email->sendAs = 'html';
        $content= Router::url('/PosMapps/phoneclear/', true);
        App::uses('CakeEmail','Network/Email');
        $Email = new CakeEmail('gmail');
        $Email->from(array('tkb.tsss@gmail.com' => 'POSTOM'))
            ->to($mailAdress)
            ->subject('PosMapp Preview')
            ->send('Please click the following link if you want to preview PosmApp :'.$content);
    }
    public function deletestorage()
    {
        $result=$this->Poster->find('all');
        $this->set('posters', $result);
    }
    public function phoneclear()
    {
        $this->autoLayout=false;
    }
}
?>
