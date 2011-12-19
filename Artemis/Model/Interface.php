<?php

interface Artemis_Model_Interface 
{
		
	/**
	 * connect to database
	 * 
	 */
	public  function connect();
	
	/**
	 * 
	 * fetch all field name in table and store that to $fields property
	 */
 	public function set_field_name();
 	
 	/**
 	 * 
 	 * create SELECT $fields FROM $table
 	 * 
 	 * $fields must be an array.
 	 * $fields = array('id','name','fname')
 	 * @param array $fields
 	 */
 	public function find($fields = array());
 	
 	/**
 	 * set condition for fetch data
 	 * $fields must be an array such as : 
 	 * $fields = array('id'=>$id , 'name'=>'Artemis');
 	 * @param array $fields
 	 */
 	public function where($fields);
 	
 	/**
 	 * join tow table 
 	 * 
 	 * @param string $wiht 
 	 * @param string $field_table1
 	 * @param string $field_table2
 	 * @param array $cond
 	 */
 	public function join($wiht, $field_table1, $field_table2, $cond=array());
 	
 	/**
 	 * 
 	 * order data
 	 * @param string $order field name to order
 	 * @param string $dir ASC or DESC
 	 */
 	public function order($order ='id', $dir = 'ASC');
 	
 	/**
 	 * 
 	 * limit fetch data
 	 * @param int $start
 	 * @param int $results
 	 */
 	public function limit($start , $results);
 	
 	/**
 	 * fetch all rows from last query;
 	 * 
 	 */
 	public function fetchAll();
 	
 	/**
 	 * fetch one row from last query
 	 * 
 	 */
 	public function fetchOne();
 	
 	/**
 	 * 
 	 * create dynamic  findBy[$field] method
 	 * @param string $method field name
 	 * @param string $args
 	 * @return $this 
 	 */
 	public function __call($method, $args);
 	
 	/**
 	 * 
 	 * return number of rows from last query
 	 * @return int
 	 */
 	 public function numRows();
 	
 	/**
 	 * 
 	 * create and validating data to create or update
 	 * @param array $values
 	 * @param bool $escape
 	 * @return true or false
 	 */
 	public function create($values = array(), $escape = false);
 	
 	/**
 	 * 
 	 * insert data to db
 	 * 
 	 */
 	public function insert();
 	
 	/**
 	 * 
 	 * update data
 	 * @param string $pk_value
 	 */
 	public function update($pk_value);
 	
 	/**
 	 * Delete a row
 	 * 
 	 * @param string $pkValue
 	 */
 	 public function delete($pkValue = 0);	
}
