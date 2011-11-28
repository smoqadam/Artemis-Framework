<?php
/**
* Artemis Framework
* Router class
* Artemis/Router.php
*  
* @author : Saeed Moqadam zade
*/

class Router
{
	
	/**
	* store controller name
	*
	*@access private
	*/
	private static $controller ;
	
	/**
	*  store action name
	*
	* @access private
	*/
	private static $action ;
	
	/**
	* store parameters in an array 
	*
	*@access private
	*/
	private static $params = array();
	
	/**
	* store controller file name and path
	*
	*@access private
	*/
	private static $file;
	
	/**
	* store base controller 
	*
	* base controller set in config.php
	*
	*@access private
	*/
	private static $base_controller;
	

	/**
	* set base controller
	*
	*@param string base controller
	*@access public
	*/
	public static function init($base_controller)
	{
		self::$base_controller = $base_controller;
	}
	
	/**
	*
	*@access private
	*@return void
	**/
	private static function getController()
	{
		
		$url = (isset($_GET['artemis'])) ? $_GET['artemis'] : '';	
		
		//extract url
		$parts = explode('/',$url);
 
		//set controller

			//if controller file is found
			if(file_exists(APP_PATH.'controllers/'.$parts[0].'.php'))
			{
				self::$controller = ($parts[0]);
				array_shift($parts);	
			}
			//set default controller in config.php
			else if(file_exists(APP_PATH.'controllers/'.self::$base_controller.'.php'))
			{
				self::$controller = self::$base_controller;	
			}
			else if(file_exists(APP_PATH.'controllers/index.php'))
			{
				 //set index default controller
				 self::$controller = 'index';
			}
			else
			{
				die("Controller Not Found");	
			}
		
		self::$params = $parts;
		 
		self::$file = ROOT.DS.'app/controllers/'.self::$controller.'.php';
	}
	
	/**
	*
	*
	*@access private
	*@return void
	*/
	public static function load()
	{
		
		//check if app controller is exists
		$appcontroller =  ROOT.DS.'app/controllers'.DS.'AppController.php';
		if(file_exists($appcontroller))
			include $appcontroller;
			
		self::getController();
		
		//check controller exists
		if(!is_file(self::$file))
		{
			die("self::$file Not Found");	
		}
		
		//include controller
		require_once(self::$file);
		
		//create controller class name 
		$class = ucfirst(self::$controller).'Controller';
		//create controller object 
		$controller = new $class();
		
	
		//if action is set in url
		if(!isset(self::$params[0]) OR !is_callable(array($controller , self::$params[0])))
		{
			//default action
			$action = 'index';	
		}
		else
		{
			$action = self::$params[0];	
			array_shift(self::$params);
		}
		
		//execute action
		call_user_func_array(array($controller,$action), self::$params);
	}
	

}