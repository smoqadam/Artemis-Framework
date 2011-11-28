<?php
class Artemis
{
	static function getConfig($key)
	{
		include ROOT.'/config/config.php';
		if(isset($config[$key]))
		{
			return $config[$key];
		}else 
			return false;
	}
	
	
 
}