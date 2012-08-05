<?php

class Artemis_Helper_Exception extends Artemis_Exception
{
	function __construct($m)
	{	
		parent::__construct("Artemis Helper Exeption <pre> {$m} </pre> ");
	}
}