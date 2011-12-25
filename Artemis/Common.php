<?php
/**
 * Artemis Framework
 * common function 
 */

 

set_exception_handler('artemis_ex_handler');
/**
 * custom theme Exception Handler
 *  
 * @param Exception $ex
 */
function artemis_ex_handler($ex)
{
	
	$errorArr = $ex->getTrace();
	
	$file = $errorArr[0]['file'];
	$line = $errorArr[0]['line'];
	$func = $errorArr[0]['function'];
	
	$message = "<hr>";
	
	$message .= $ex->getMessage();
	$message .= 'Exception occured in :';
	$message .= "<pre>"; 
	$message .= "File : $file<br>";
	$message .= "Line : $line<br>";
	$message .= "Function : $func<br>";
	$message .= "</pre>";
	$message .= "<hr>";
	echo  $message, '<br>';
}
/**
 * 
 * set autoloading to auto load classes
 * @param string class name
 */
function __autoload($class)
{
	//create array class path
	$class = explode('_',$class);
	//splite class name
	$className = array_pop($class).'.php';
	
	$classPath = implode('/' , $class);
	if(!file_exists($classPath.'/'.$className))
		throw new Artemis_Router_Exception("Class $class name not found!");
	include_once($classPath.'/'.$className);
}

/**
 * 
 * print_r debug function
 * @param array $var
 */
function _p($var) 
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}
/**
 * Return base url
 *
 */
function baseUrl()
{
	return BASE_URL;
}
	
/**
 * 
 * Redirect function
 * @param string $controller 
 * @param string $action
 * @param string $param
 */
function redirect($controller , $action = NULL, $param = NULL)
{
	$location = baseUrl();
	$location .= $controller;
	$location .= ($action != NULL )? '/' . $action : '';
	$location .= ($param != NULL ) ? '/'.$param : '';
	ob_start();
	header('Location: '.$location);
	ob_clean();

}
