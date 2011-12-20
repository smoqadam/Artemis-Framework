<?php

class IndexController extends Artemis_Controller
{
	function index()
	{
		$p = $this->loadModel('Postss');
		$p = $this->loadModel('Posts');
		 $p->db->find()->where(array('id'=>'22'))->fetchAll();//
  		$this->view->post = "Hello Artemis Framework";
		$this->view->render();
	}
	
	function g()
	{
		$this->view->render();
	}

}