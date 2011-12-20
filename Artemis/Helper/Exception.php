<?php
class Artemis_Helper_Exeption extends Artemis_Exception
{
	function __construct($m)
	{
		$message = "<hr>";
		$message .="Artemis Helper Exeption <pre>  $m </pre> "; 
		$message .= "<hr>";
		parent::__construct($message);
	}
}