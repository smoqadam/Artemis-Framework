<?php

class IndexController extends Artemis_Controller
{
	function index()
	{	
		//$p = $this->loadZend('Post');
		$this->view->post = "Hello Artemis Framework";
		$this->view->render();
	}
}