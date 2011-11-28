<?php
 
abstract class Database_Abstract
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
		include 'View/Helper/Validation.php';
		$validate = new Validation();

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
	
 
	
	/**
	 * 
	 * set table nam and primary key and validations ruls
	 * @param string $table
	 * @param string $pk
	 * @param array $validation
	 */
	abstract function __construct($table , $pk , $validation);
	
	
	/**
	 * connect to database
	 * 
	 */
	abstract  function connect();
	
	/**
	 * 
	 * fetch all field name in table and store that to $fields property
	 */
 	abstract function set_field_name();
 	
 	/**
 	 * 
 	 * create SELECT $fields FROM $table
 	 * 
 	 * $fields must be an array.
 	 * $fields = array('id','name','fname')
 	 * @param array $fields
 	 */
 	abstract function find($fields = array());
 	
 	/**
 	 * set condition for fetch data
 	 * $fields must be an array such as : 
 	 * $fields = array('id'=>$id , 'name'=>'Artemis');
 	 * @param array $fields
 	 */
 	abstract function where($fields);
 	
 	/**
 	 * join tow table 
 	 * 
 	 * @param string $wiht 
 	 * @param string $field_table1
 	 * @param string $field_table2
 	 * @param array $cond
 	 */
 	abstract function join($wiht, $field_table1, $field_table2, $cond=array());
 	
 	/**
 	 * 
 	 * order data
 	 * @param string $order field name to order
 	 * @param string $dir ASC or DESC
 	 */
 	abstract function order($order ='id', $dir = 'ASC');
 	
 	/**
 	 * 
 	 * limit fetch data
 	 * @param int $start
 	 * @param int $results
 	 */
 	abstract function limit($start , $results);
 	
 	/**
 	 * fetch all rows from last query;
 	 * 
 	 */
 	abstract function fetchAll();
 	
 	/**
 	 * fetch one row from last query
 	 * 
 	 */
 	abstract function fetchOne();
 	
 	/**
 	 * 
 	 * create dynamic  findBy[$field] method
 	 * @param string $method field name
 	 * @param string $args
 	 * @return $this 
 	 */
 	abstract function __call($method, $args);
 	
 	/**
 	 * 
 	 * return number of rows from last query
 	 * @return int
 	 */
 	abstract function numRows();
 	
 	/**
 	 * 
 	 * create and validating data to create or update
 	 * @param array $values
 	 * @param bool $escape
 	 * @return true or false
 	 */
 	abstract function create($values = array(), $escape = false);
 	
 	/**
 	 * 
 	 * insert data to db
 	 * 
 	 */
 	abstract function insert();
 	
 	/**
 	 * 
 	 * update data
 	 * @param string $pk_value
 	 */
 	abstract function update($pk_value);
 	
 	/**
 	 * Delete a row
 	 * 
 	 * @param string $pkValue
 	 */
 	abstract public function delete($pkValue = 0);
}