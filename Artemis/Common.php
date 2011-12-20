<?php
/**
 * Artemis Framework
 * common function 
 */

 
//set_exception_handler(array(Artemis_Error ,'artemis_ex_handler'));
set_exception_handler('artemis_ex_handler');

function artemis_ex_handler($ex)
{
	echo $ex->getMessage() , '<br>';
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
	
	include_once($classPath.'/'.$className);
}

/**
 * 
 * print_r debug function
 * @param array $var
 */
function _p(array $var) 
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
