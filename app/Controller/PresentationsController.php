<?php

class PresentationsController extends AppController {
	public $helpers = array('Html', 'Form', 'Text');
	
	public function index(){
		$this->set('presentations', $this->Presentation->find('all'));
	}
}

?>