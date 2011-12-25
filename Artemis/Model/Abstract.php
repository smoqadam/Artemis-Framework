<?php
 
abstract class Artemis_Model_Abstract
{
	private $error = array();
	/**
	 * 
	 * Escape string
	 * @param $str
	 */
	function escape($str)
	{
		return mysql_real_escape_string($str);
		
	}
        
        /**
         *
         * @param type $values
         * @return type 
         */
	public function validate($values)
	{
		$rules = $this->validation;
		 
		$validate = new Artemis_Helper_Validation();
                
		$error = $validate->validateFields($values , $rules);
                
		if(!empty($error))
		{
			$this->setError($error);
			return false;
		}else{
			return true;
		}
	}
        
        /**
         * set error
         * @param type $k 
         */
        function setError($k)
        {
            $this->error =  $k;
        }

        /**
	 * 
	 * get errors
	 */
	public function getError()
	{
		return implode('</br>' , $this->error);
	}
	
	
	/**
	 * 
	 * return last query string
	 */
	function lastQuery(){
		return $this->query;
	}

}