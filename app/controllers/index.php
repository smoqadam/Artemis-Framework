<?php

class IndexController extends AppController
{
	function index()
	{
		$this->view->post = "Hello Artemis Framework";
		$this->view->view();
		
	}

}