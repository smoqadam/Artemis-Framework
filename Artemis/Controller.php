<?php
/*
 *   Artemis Framework                               					  |
 *
 * @Author : Saeed Moqadam Zade
 * @file : Artemis/Controller.php
 */

class Artemis_Controller extends Artemis_Controller_Abstract
{
	/*
	 * view Object
	 **/
	public $view;

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
	 * create $view and $input object.
	 *
	 *
	 **/
	function __construct()
	{
		$this->view = new Artemis_Template(str_replace('Controller','',get_class($this)));
		$this->input = new Artemis_Input();
    }			
	
         	
	/**
	 *   Load Model
	 *  
	 * @param string $model_name
	 * @return Artemis_Model object
	*/
	function loadModel($model_name)
	{
			$file = APP_PATH.'Models/'.strtolower($model_name).'.php';
			if(!file_exists($file))
	        { 
	            throw new Artemis_Model_Exception("Model $model_name Not found! Please create $model_name.php model in App/Models directory  ");
	        }
			require_once $file;
        	$model = new $model_name();
        	 
        	return $model;
	}
	
	/**
         *
         * @param type $lib
         * @return lib 
         */
	function loadZend($lib)
	{
		$file_name = str_replace('Zend_','',$lib);
		$z = 'Artemis/Helper/Zend/'.$file_name.'.php';
		if(!file_exists($z)){
			throw new Artemis_Helper_Exception("$lib Zend Library Not Found! please create a copy of Zend library in Artemis/Helper");
		}
		require $z;
		return new $lib;
	}
	
}
