<?php 

/*
* Artemis Framework
* 
* Object Class
* @author : Saeed Moqadam Zade
**/
 
class Artemis_Object
{
	/**
	 * destroy chid class on destruct
	 * 
	 */
	function __destruct()
	{
		$this = NULL;
	}
}