<?php
class Artemis_Controller_Exeption extends Artemis_Exception
{
	function __construct($m)
	{
		$message = "<hr>";
		$message .="Artemis Controller Exeption <pre>  $m </pre> "; 
		$message .= "<hr>";
		parent::__construct($message);
	}
}