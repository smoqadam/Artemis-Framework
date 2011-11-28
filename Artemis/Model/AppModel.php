<?php
/*
* Artemis Framework
* AppModel Class
*
* @author : Saeed Moghadam Zede
*
*/
 
class AppModel 
{
	
	 
	function AppModel()
	{
	 
	}
	
	static function factory(&$model)
	{
		$table = get_class($model);
		$vars = get_class_vars($model);
		$pk = (isset($vars['pk'])) ? $vars['pk'] : '';
		$validation = (isset($vars['validation'])) ? $vars['validation'] : array();
		
		$driver = Artemis::getConfig('driver');
		
		if(preg_match('/^pdo_.*/i', $driver))
		{
			$class = str_replace('PDO_' , '' , $driver);
			include_once 'Model/PDO/'.$class.'.php';
			return new $class($table , $pk , $validation);
		}
		elseif(preg_match('/^adodb_.*/i', $driver))
		{
			$class = str_replace('ADODB_' , '' , $driver);
			include_once 'Model/ADODB/'.$class.'.php';
			return new $class($table , $pk , $validation);	
		}
		
		require_once('Model/Mysql.php');
		return new Mysql($table ,$pk  , $validation ); 
		
	}
	
	function  __toString()
	{
		return get_class($this);
	}
}