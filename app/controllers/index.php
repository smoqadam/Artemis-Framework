<?php

class IndexController extends Artemis_Controller
{
	function index()
	{	
                $this->view->post = 'فریم ورک آرتمیس';
		$this->view->render('صفحه اصلی');
	}
        
        
}