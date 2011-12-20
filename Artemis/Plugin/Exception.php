<?php
class Artemis_Plugin_Exeption extends Artemis_Exception
{
	function __construct($m)
	{
		$message = "<hr>";
		$message .="Artemis Plugin Exeption <pre>  $m </pre> "; 
		$message .= "<hr>";
		parent::__construct($message);
	}
}