<?php

class Artemis_Config
{
	static function get($key)
	{
		include ROOT.'/config/config.php';

		if(isset($config[$key]))
		{
		return $config[$key];
		}else 
		return false;
	}
}