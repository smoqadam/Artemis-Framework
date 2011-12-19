<?php

class IndexController extends Artemis_Controller
{
	function index()
	{
  		$this->view->post = "Hello Artemis Framework";
		$this->view->view();
	}

}