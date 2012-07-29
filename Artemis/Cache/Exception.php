<?php

class Artemis_Cache_Exception extends Artemis_Exception
{
	function __construct($m)
	{
		parent::__constrct("Artemis cache exception <pre>{$m}</pre>");
	}	
}