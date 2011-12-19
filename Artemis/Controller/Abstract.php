<?php
/**
 * 
 * Abstract Controller clss
 * Artemis Framework
 * @author saeed moqadam zade
 *
 */

 
abstract class Artemis_Controller_Abstract
{
	/*
	* Redirect page
	*
	* @param string : location to redirect
	* return void
	*/
	public function redirect($loc)
	{
		if(is_array($loc))
		{
			$location = BASE_URL;
			$location .= $loc['controller'];
			$location .= '/';
			$location .= $loc['action'];
		}
		else
			$location = $loc;
		 //  print_r($location);
		ob_start();
   		header('Location: '.$location);
 		ob_clean();
		 
	}


}