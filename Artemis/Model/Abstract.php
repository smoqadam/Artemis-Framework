<?php
 
abstract class Artemis_Model_Abstract
{
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
	 * validate $values according to $validation rules 
	 *
	 *  @param array 
	 * @access private
	 */
	public function validate($values)
	{
		$rules = $this->validation;
		 
		$validate = new Artemis_Helper_Validation();

		$error = $validate->validateFields($values , $rules);

		if(!empty($error))
		{
			$this->error = $error;
			return false;
		}else{
			return true;
		}
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