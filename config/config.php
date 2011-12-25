<?php
/**
 * Config artemis framework
 */

//root folder
$config['base'] = '/artemis/';

$config['base_url'] = 'http://127.0.0.1'.$config['base'];

//server db
$config['server'] = 'localhost';

//username db
$config['username'] = 'root';
//pass db
$config['password'] = '';

/**
 * Database name
 * 
 */
$config['database'] = 'blog';

/**
 *  Driver name
 *
 * Mysql , PDO_Mysql , PDO_Mssql , PDO_Sqllite , ... 
 * 
 */
$config['driver'] = 'PDO_Mysql';

//set default controller
$config['base_controller'] = 'index';

//default theme name
$config['theme'] = 'default';

