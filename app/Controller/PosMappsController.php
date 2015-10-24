<?php
/**
 * Created by PhpStorm.
 * User: tianhang
 * Date: 2015/10/21
 * Time: 16:11
 */

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

}
?>