<?php

class Artemis_Exception_Exception extends Exception
{
    function __constrct($message , $code = null )
    {
        parent::__construct($message , $code );
    }
    
    function __toString()
    {
        return $this->text($this);
    }
    
    function text(Exception $e)
    {
      return sprintf('[%s] : %s ~ %s [ %d ]',
            get_class($e) , strip_tags($e->getMessage()), $e->getFile(), $e->getLine());
    
    }
}
?>
