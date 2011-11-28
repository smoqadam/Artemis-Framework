<?php
require('config/config.php');
error_reporting(E_ALL);
/******************** Defins ************************ - E_NOTICE*/
define("ROOT",dirname(__FILE__));
define("DS",DIRECTORY_SEPARATOR);
define("BASE",'');
define("BASE_URL",$config['base_url']);
define('APP_PATH' , ROOT.DS.'app/');

define("SERVER",$config['server']);
define("DATABASE",$config['database']);
define("PASSWORD",$config['password']);
define("USERNAME",$config['username']);

define('IMG_FOLDER' , BASE_URL.'public/image/');
define('JS_FOLDER',BASE_URL.'public/js/');
define('CSS_FOLDER',BASE_URL.'public/css/');

set_include_path("Artemis/");
require_once('Artemis.php');
require_once('Object.php');
require_once('Router.php');

require_once('Model/AppModel.php');
require_once('Input.php');
require_once('Controller/Controller.php');
require_once('View/Template/Template.php');


 
/**
*
* extract url and load controller and execute action
*
*/
//set base controller
Router::init(Artemis::getConfig('base_controller'));
Router::load();

 

  

 
