<?php
/*
 *   Artemis Framework                               					  |
 *
 * @Author : Saeed Moghadam Zade

 */

require_once('Abstract/Abstract_Controller.php');

class Controller extends Abstract_Controller
{
	private $object;
	
	/*
	 * view Object
	 **/
	public $view;

	/**
	 * helpers name
	 *
	 **/
	protected $helper;
	/**
	 * plugins name
	 *
	 */
	protected $plugin;
	/**
	 * modles name
	 *
	 */
	protected $model;

	/**
	 * input object to manage POST and GET var
	 *
	 */
	public $input;

	/**
	 * create $view object. check and load helpers,plugins,models
	 *
	 *
	 **/
	function __construct()
	{
 
		$this->view = new Template(str_replace('Controller','',get_class($this)));
		$this->input = new Input();
			
		if(!empty($this->helper))
		{
			if(is_array($this->helper))
				$this->object['helper'] = $this->helper;
			else 
				$this->object['helper'][] = $this->helper;	
		}
		if(!empty($this->plugin))
		{
			if(is_array($this->plugin))
				$this->object['plugin'] = $this->plugin;
			else 
				$this->object['plugin'][] = $this->plugin;	
		}
		if(!empty($this->model))
		{
			if(is_array($this->model))
				$this->object['model'] = $this->model;
			else 
				$this->object['model'][] = $this->model;	
		}
		
 
			
	}
	
	/**
	 * 
	 *  
	 * @param unknown_type $obName
	 */
	function __get($obName)
	{
		if(in_array($obName , $this->object['helper']))
		{
			include_once('View/Helper/'.$obName.'.php');
			if(!is_object($obName))
				$this->view->$obName = new $obName;
		}
		elseif(in_array($obName , $this->object['plugin']))
		{
			include_once('Controller/Plugin/'.$obName.'.php');
			if(!is_object($plugin))
				return new $obName;
		}
		elseif(in_array($obName , $this->object['model']))
		{
			$file = APP_PATH.'models/'.strtolower($obName).'.php';
			if(!file_exists($file))
			{
				die("$obName Not found");
			}
			include_once $file;
			echo $file;
			return AppModel::factory(new $obName());

		}
 		else
 		{
 			throw new Exception("$obName File Not Found");	
 		}
	}
	
 	
	// /**
	 // * Load helpers
	 // *
	 // *
	 // **/
	// protected function helper($helper)
	// {
		// if(is_array($helper))
		// {
			// array_map(array('Controller','helper') , $helper);
		// }
		// else
		// {
			// include_once('View/Helper/'.$helper.'.php');
			// if(!is_object($helper))
			// $this->view->$helper = new $helper;
		// }
	// }
	// /**
	 // * Load plugin
	 // *
	 // *
	 // **/
	// protected function plugin($plugin)
	// {
		// if(is_array($plugin))
		// {
			// array_map(array('Controller','plugin') , $plugin);
		// }
		// else
		// {
			// include_once('Controller/Plugin/'.$plugin.'.php');
			// if(!is_object($plugin))
			$this->$helper =  new $helper();
			// $this->$plugin = new $plugin;
		// }
	// }
	
	
	
	// /**
	 // *
	 // * Load Model
	 // *
	 // **/
	
	// protected function model($model)
	// {
		// if(is_array($model))
		// {
			// array_map(array('Controller','model'),$model);
		// }
		// else
		// {
			// $file = APP_PATH.'models/'.strtolower($model).'.php';
			// if(!file_exists($file))
			// {
				// die("$model Not found");
			// }
			// include_once $file;
			
			// $this->$model = AppModel::factory(new $model());
		// }
	// }
	
}
