<?php
/**
 * Created by PhpStorm.
 * User: tianhang
 * Date: 2015/10/21
 * Time: 16:11
 */

class PosMappsController extends AppController {
    public $helpers = array('Html', 'Form', 'Text');

    public function index(){
//        $this->set('posters', $this->Poster->find('all'));
        $this->autoLayout=false;

    }
    public function makejson()
    {
        $result=$this->Poster->find('all'
//            ,
//            array(
//                'fields' =>array(
//                    'Posters.id',
//                    'Posters.width',
//                    'Posters.height',
//                    'Posters.x',
//                    'Posters.y',
//                    'Posters.area_id',
//                    'Posters.date'
//                ),
//                'order' => 'Posters.id ASC'
//            )
        );
//        ,array('id','presentation_id','width','height','x','y','area_id','date')
        $this->set('posters', $result);

    }

    public function  test()
    {

    }
}
?>