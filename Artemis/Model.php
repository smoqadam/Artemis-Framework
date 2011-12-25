<?php
/*
* Artemis Framework
* AppModel Class
*
* @author : Saeed Moqadam Zede
*
*/
 
class Artemis_Model 
{
    /**
    * store database object
    * 
    * @var Object
    */
    public $db;

    protected $table = ''; 
    
    protected $validation;
    
    public  $pk = 'id';
    
    function __construct($table = '')
    {
  	   // $this->table = get_class($this);
  	    $table = ($table == '') ? get_class($this) : $table; 
		$vars = get_class_vars($this);
		$pk = (isset($vars['pk'])) ? $vars['pk'] : 'id';
		$validation = (isset($vars['validation'])) ? $vars['validation'] : array();
		
		$driver = Artemis_Config::get('driver');
		
		if(preg_match('/^pdo_.*/i', $driver))
		{
			$class = 'Artemis_Model_'.$driver;
  			$this->db = new $class($table , $pk , $validation);
		}
		elseif(preg_match('/Mysql.*/i' , $driver))
        {
		    $class = 'Artemis_Model_Mysql';
		    $this->db = new $class($table ,$pk  , $validation ); 
        }
        else
        {
            throw new Artemis_Model_Exception("Driver $diruver Not Found");
        }
    }
	/**
    * load database driver
    * 
    * @param $model
    * @return Database Object
    */
	static function factory(&$model)
	{                  
		$table = get_class($model);
		$vars = get_class_vars($model);
		$pk = (isset($vars['pk'])) ? $vars['pk'] : 'id';
		$validation = (isset($vars['validation'])) ? $vars['validation'] : array();
		
		$driver = Artemis_Config::get('driver');
		
		if(preg_match('/^pdo_.*/i', $driver))
		{
			$class = 'Artemis_Model_'.$driver;
  			return new $class($table , $pk , $validation);
		}
		elseif(preg_match('/Mysql.*/i' , $driver))
        {
		    $class = 'Artemis_Model_Mysql';
		    return new $class($table ,$pk  , $validation ); 
        }
        else
        {
            throw new Artemis_Model_Exception("Driver $diruver Not Found");
        }
		
	}


	
    /**
    *   return child class name
    * 
     */ 
	function  __toString()
	{
		return get_class($this);
	}
    
}