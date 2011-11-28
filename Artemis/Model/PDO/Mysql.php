<?php
/**
 * Artemis Framework
 *
 */


require_once('Model/Abstract/Database_Abstract.php');
class Mysql extends Database_Abstract
{
	private $bindValues;
	/**
	 *
	 * store PDO object
	 * @var Object
	 */
	private $db;

	/**
	 * store all fields name in the table
	 * @access private
	 * @var array
	 */
	private $fields;

	/**
	 *
	 * store fields name for create and update command
	 * @var array
	 */
	private $cu_fields;

	/**
	 *
	 * store last query
	 * @var string
	 */
	private $query;

	/**
	 *
	 * store error
	 * @var string;
	 */
	protected $error;

	/**
	 *
	 * store table name
	 * @var string
	 */
	private $table;

	/**
	 *
	 * store result
	 * @var array
	 */

	private $reult;
	/**
	 *
	 * fields of that need to validate
	 * @var array
	 */
	protected  $validation;

	/**
	 *
	 * store table primary key
	 * @var string
	 */
	private $pk = 'id';

	/**
	 *
	 * construct of class.create connection and set $this->table
	 * @param string $table
	 */
	public function __construct($table , $pk = 'id', $validation = array())
	{
		$this->table = strtolower($table);
		$this->pk = $pk;
		$this->validation = $validation;
 	
		$this->connect();
	}

	function connect()
	{
		if(!class_exists('PDO',false))
			throw new Exception("PHP PDO package is required.");

		$server = Artemis::getConfig('server') ;
		$username = Artemis::getConfig('username');
		$password = Artemis::getConfig('password');
		$database = Artemis::getConfig('database');
			
		$this->db = new PDO('mysql:host='.$server.';dbname='.$database ,$username, $password);

	}


	function set_field_name()
	{
		$table = $this->table;
		//select all fields from $this->table
		$result = $this->db->prepare("select * from $table");
		$result->execute();
		// $result;
		$i = 0 ;
		while($i < $result->columnCount())
		{
			//  $i;
			$meta = $result->getColumnMeta($i);
			$this->fields[$meta['name']]=  '' ;
			$i++;
		}


	}
	/**
	 *
	 * set field name
	 * @param array $fields
	 */
	public function find($fields = array())
	{
		if(!empty($fields))
		{
			$field = implode(',', $fields);
		}else {
			$field = '*';
		}

		$this->query = "SELECT $field FROM $this->table ";

		return $this;
	}

	/**
	 *
	 * set condition to fetch
	 * @param array $where
	 */
	public function where($where = array())
	{
		if(!is_array($where))
		{
			$this->error = 'WHERE claus must be an array!';
			return false;
		}

		foreach($where as $field=>$value)
		{
			$q[] = $field . ' = :'.$field;
		}

		$this->query .= ' WHERE '.implode(' AND ', $q);

		foreach($where as $field=>$value)
		{

			$this->bindValues[":$field"] = $value;
		}

		return $this;
	}

	/**
	 *
	 * Join tow table
	 * @param $wiht join with which table
	 * @param $field_table1 primary key of table one
	 * @param $field_table2 forign key in table two
	 * @param $cond WHERE condition
	 */
	function join($wiht , $field_table1 , $field_table2, $cond = array())
	{
		if(empty($cond))
		$this->query .= " LEFT JOIN $wiht ON $field_table1 = $field_table2 ";
		elseif(is_array($cond) AND !empty($cond))
		{
			foreach($cond as $k=>$v)
			{
				$condition[] = $k.'='.$v;
			}
			$cond = implode(' AND ',$condition);
			$this->query .= " INNER JOIN $table ON $table1 = $table2  WHERE $cond ";
			//$this->bindValues[':join'] = $value;
		}else
		{
			$this->query .= " INNER JOIN $table ON $table1 = $table2  WHERE $cond ";
		}

		return $this;
	}

	/**
	 *
	 * set ORDER BY in query
	 * @param $order : order by field
	 * @param $dir : direction DESC or ASC
	 */
	function order($order = '',$dir = '')
	{
		$this->query .= " ORDER BY $order $dir ";
		return $this;
	}

	function limit($start , $results)
	{
		$this->query .= " LIMIT :start , :results ";
		$this->bindValues[':start']= $start ;
		$this->bindValues[':results']= $results ;

		return $this;
	}

	/**
	 *
	 * fetch all rows with last query
	 *
	 */
	public function fetchAll()
	{
		$this->result = $this->db->prepare($this->query);

		if(!empty($this->bindValues))
		{
			foreach($this->bindValues as $key=>$value)
			{
				if(is_int($value))
				$this->result->bindValue($key , $value , PDO::PARAM_INT);
				else
				$this->result->bindValue($key , $value);
			}
		}
		$this->result->execute();
		$this->result->errorInfo();
		return $this->result->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 *
	 * fetch one row of last query
	 */
	public function fetchOne()
	{
		$this->result = $this->db->prepare($this->query);

		foreach($this->bindValues as $key=>$value)
		{
			if(is_int($value))
			$this->result->bindValue($key , $value , PDO::PARAM_INT);
			else
			$this->result->bindValue($key , $value);
		}
		$this->result->execute();
		return $this->result->fetch(PDO::FETCH_ASSOC);
	}

	/**
	 *
	 * set dynamic method to find rows with similar function name
	 *
	 * this method used to call findBy[fieldName] method.
	 * the findByID method search a ro with id value
	 *
	 * @param method name $method
	 * @param unknown_type $args
	 */
	public function __call( $method, $args )
	{
			
		if (preg_match( '/findBy(.*)/i', $method, $found ) )
		{
			$field = strtolower($found[1]);//get field name
			$this->set_field_name();
			if ( array_key_exists(  $field, $this->fields ) )
			{
				$sql = "SELECT * FROM $this->table WHERE  $field = :$field";
				$this->query = $sql;

				foreach($args as $k=>$v)
				$this->bindValues[':'.$field] = $v;
					
				return $this;
			}
		}

		return false;
	}

	/**
	 *
	 * return number of rows in last query
	 */
	public function numRows()
	{

		$this->result = $this->db->prepare($this->query);
		if(!empty($this->bindValues))
			foreach($this->bindValues as $key=>$value)
			{
				if(is_int($value))
				$this->result->bindValue($key , $value , PDO::PARAM_INT);
				else
				$this->result->bindValue($key , $value);
			}

		$this->result->execute();
		return $this->result->rowCount();
	}


	/**
	 *
	 * create $this->cu_fields to pass a array of fields value
	 * @param $values
	 * @param $escape
	 */
	public function create($values = array(), $escape = false)
	{

		if(!is_array($values)) return false;
		try
		{

			if(!empty($this->validation) AND !$this->validate($values))
			return false;

			if($escape)
			{
				$values = $this->sanitize($values);
			}
			$this->set_field_name();
			foreach($values as $field=>$value)
			{
				if(in_array($field , array_keys($this->fields)))
				{
					$this->cu_fields[$field] = $value;
				}
			}

			return true;
		}
		catch(Exception $e)
		{
			$e->getMessage();
			return false;
		}

	}

	/**
	 *
	 * insert values store in $this->cu_fields array
	 */
	public function insert()
	{
		//print_r($this->cu_fields);
		foreach($this->cu_fields as $field=>$v)
		$ins[] = ':'.$field;

		$ins = implode(',' , $ins);
		$fields = implode(',',array_keys($this->cu_fields));
		$sql = "INSERT INTO $this->table ($fields) VALUES ($ins)";

		$this->result = $this->db->prepare($sql);
		foreach($this->cu_fields as $f=>$v)
		{
			$this->result->bindValue(':'.$f , $v);
		}
		$this->result->execute();
		//print_r($this->result->errorInfo());
		// 'Insert Cat';
	}


	/**
	 *
	 * update a row
	 * @param string $pk_value
	 */
	public function update($pk_value = false)
	{
		foreach($this->cu_fields as $field=>$v)
		{
			if($field !== $this->pk)
			{
				$up[] = $field.'= :'.$field;
				//$values[] = $v;
			}
		}

		$up = implode(',' , $up);

		$sql = "UPDATE $this->table SET $up WHERE $this->pk = :$this->pk";
		$this->cu_fields[$this->pk] = $pk_value;


		$this->result = $this->db->prepare($sql);

		foreach($this->cu_fields as $f=>$v)
		{
			$this->result->bindValue(':'.$f , $v);
		}

		$this->result->execute();
			
	}

	/**
	 *
	 * Delete a row
	 * @param $pkValue value of primary key
	 */
	public function delete($pkValue = 0)
	{
		if($pkValue == 0) return false;

		$sql = "DELETE FROM $this->table WHERE $this->pk = $pkValue";
		$this->result = $this->db->prepare($sql);
		$this->result->execute();
		return true;
	}

	/**
	 * return last query
	 *
	 *@return string
	 *@access public
	 */
	public function lastQuery()
	{
		return $this->query;
	}




}