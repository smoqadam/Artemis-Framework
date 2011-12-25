<?php
class Artemis_Plugin_Exception extends Artemis_Exception
{
	function __construct($m)
	{
		parent::__construct("Artemis Plugin Exception <pre>  $m </pre> ");
	}
}