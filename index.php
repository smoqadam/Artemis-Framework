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
require 'Artemis/Common.php';
/**
* extract url and load controller and execute action
*/
Artemis_Router::init();
Artemis_Router::load();

 

  

 
