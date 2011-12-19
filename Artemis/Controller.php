<?php
/*
 *   Artemis Framework                               					  |
 *
 * @Author : Saeed Moqadam Zade
 * @file : Artemis/Controller.php
 */

class Artemis_Controller extends Artemis_Controller_Abstract
{
	private $object;
	
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
	 *   Load Model Object
	 *  
	 * 
	*/
	function loadModel($model_name)
	{
        $file = APP_PATH.'Models/'.strtolower($model_name).'.php';
        if(!file_exists($file))
        { 
            throw new Artemis_Model_Exception("Model $model Not found! ");
        }
        require $file;
        $model = new $model_name;
        $model->db = Artemis_Model::factory($model); 
        return $model;
	}
	
	
}
