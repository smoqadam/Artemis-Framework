<?php
class Artemis_Controller_Exeption extends Artemis_Exception
{
	function __construct($m)
	{
		parent::__construct("Controller Exeption with error $m");
	}
}