<?php
class Artemis_Model_Exception extends Artemis_Exception
{
	function __construct($m)
	{
		parent::__construct("Model Exeption with error : $m " , 000);
	}
}