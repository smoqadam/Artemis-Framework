<?php
class Artemis_Controller_Exception extends Artemis_Exception
{
	function __construct($m)
	{
		$message = "<hr>";
		$message .="Artemis Controller Exception <pre>  $m </pre> "; 
		$message .= "<hr>";
		parent::__construct($message);
	}
}