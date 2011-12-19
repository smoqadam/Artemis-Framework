<?php
require('config/config.php');

/**
 * Set error reporting
 */
error_reporting(E_ALL);

 
/**
 * 
 * set global constants 
 * 
 */
define("ROOT",dirname(__FILE__));
define("DS",DIRECTORY_SEPARATOR);
define("BASE",'');
define("BASE_URL",$config['base_url']);
define('APP_PATH' , ROOT.DS.'app/');
define('IMG_FOLDER' , BASE_URL.'public/image/');
define('JS_FOLDER',BASE_URL.'public/js/');
define('CSS_FOLDER',BASE_URL.'public/css/');

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

function _p($var) 
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}
 

/**
*
* extract url and load controller and execute action
* 
*/
Artemis_Router::init();
Artemis_Router::load();

 

  

 
