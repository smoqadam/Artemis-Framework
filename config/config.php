<?php
/**************** Config ********************/
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
$config['database'] = 'ar_blog';

/**
 *  Driver name
 *
 * PDO_Mysql , PDO_Mssql , PDO_Sqllite , ... 
 * 
 */
$config['driver'] = 'PDO_Mysql';

//set default controller
$config['base_controller'] = 'index';


$config['theme'] = 'default';

