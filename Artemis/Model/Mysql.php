<?php
require_once('Model/Abstract/Database_Abstract.php');
class Mysql extends Database_Abstract
{
	private $table;
	
	private $result;
	
	private $connection;
	
	private $cu_fields;
	
	private $query;
	
	private $fields;
	
	private $pk = 'id';
	
	protected $validation = array();
	
	/**
	 * constructor
	 * set $table , $pk and $validation 
	 * @param string $table
	 * @param string $pk
	 * @param array $validation
	 */
	function __construct($table , $pk , $validation)
	{
		$this->table = strtolower($table);
		$this->pk = $pk;
		$this->validation = $validation;
		
		$this->connect();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Database_Abstract::connect()
	 */
	function connect()
	{
		 
		$this->connection = mysql_connect(Artemis::getConfig('server'),Artemis::getConfig('username'),Artemis::getConfig('password'))
		or die(mysql_errno());
		if($this->connection)
		{
			mysql_select_db(Artemis::getConfig('database'));
		}else 	
			return false;
		return true;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Database_Abstract::set_field_name()
	 */
	public function set_field_name()
	{
		  $q = "select * from $this->table";
		//select all fields from $this->table
		 $result = mysql_query($q)or die(mysql_error());
		
		$i = 0 ;
		while ($i < mysql_num_fields($result)) 
		{
			$meta  = mysql_fetch_field($result , $i);
			 
			$this->fields[$meta->name]=  '' ;
			$i++;
		}
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see Database_Abstract::find()
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
	 * (non-PHPdoc)
	 * @see Database_Abstract::where()
	 */
	function where($fields)
	{
		if(!is_array($fields))
		{
			return false;
		}
		
		foreach($fields as $field=>$value)
		{
			$where[] = $field.'='.mysql_real_escape_string($value);
		}
		$where = implode(' AND ',$where);
		
		$this->query .= $where;
		
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Database_Abstract::join()
	 */
	function join($wiht, $field_table1, $field_table2, $cond=array())
	{
		if(!empty($cond))
		{
			foreach($cond as $k=>$v)
			{
				$where[] = $k.'='.mysql_real_escape_string($v);
			}
			$where = implode(' AND ',$where);
		}else {
			$where = ' 1=1 ';
		}
		$this->query .= " INNER JOIN $whit ON $field_table1 = $field_table2 $where";

		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Database_Abstract::order()
	 */
	function order($order ='id', $dir = 'ASC')
	{
		$this->query .= " ORDER BY $order $dir";
		
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Database_Abstract::limit()
	 */
	function limit($start , $results)
	{
		$this->query .= " LIMIT $start , $results";
		
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Database_Abstract::fetchAll()
	 */
	function fetchAll()
	{
		$this->result = mysql_query($this->query);
		
		if($this->result)
		{
			while($row = mysql_fetch_assoc($this->result))
			{
				$rows[] = $row;
			}
		}else 
		{
			return false;
		}
		
		return $rows;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Database_Abstract::fetchOne()
	 */
	function fetchOne()
	{
		$this->result = mysql_query($this->query);
		if($this->result)
		{
			return mysql_fetch_assoc($this->result);
		}
		return false;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Database_Abstract::__call()
	 */
	function __call($method, $args)
	{
		if (preg_match( '/findBy(.*)/i', $method, $found ) )
		{
			$field = strtolower($found[1]);//get field name
			$this->set_field_name();
			if ( array_key_exists(  $field, $this->fields ) )
			{
				$val = $this->escape($args[0]);
				$sql = "SELECT * FROM $this->table WHERE  $field = $val";
				
				$this->query = $sql;
				return $this;
			}
		}

		return false;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Database_Abstract::numRows()
	 */
	function numRows()
	{
		$num = mysql_num_rows(mysql_query($this->query));
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see Database_Abstract::create()
	 */
	function create($values = array(), $escape = false)
	{
		if(!is_array($values)) return false;
		try
		{

			if(!empty($this->validation) AND !$this->validate($values))
			return false;

			if($escape)
			{
				$values = $this->escape($values);
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
	 * (non-PHPdoc)
	 * @see Database_Abstract::insert()
	 */
	function insert()
	{
		
		foreach($this->cu_fields as $field=>$value)
		{
			$f[] = '`'.$field.'`';
			$v[] = '\''.$this->escape($value).'\'';
		}	

		$field = implode(',' , $f);
		$value = implode(',',$v);
		
		  $sql = "INSERT INTO $this->table ($field) VALUES ($value)";

		$this->result = mysql_query($sql);
		if($this->result)
			return true;

		return false;	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Database_Abstract::update()
	 */
	public function update($pk_value = false)
	{
		foreach($this->cu_fields as $field=>$v)
		{
			if($field !== $this->pk)
			{
				$up[] = '`'.$field.'` = \''.$this->escape($v).'\'';
				
			}
		}

		$up = implode(',' , $up);

		$sql = "UPDATE $this->table SET $up WHERE $this->pk = $pk_value";

		$this->result = mysql_query($sql);

		if($this->result)
			return true;

		return false;
			
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Database_Abstract::delete()
	 */
	public function delete($pkValue = 0)
	{
		if($pkValue == 0) return false;

		echo $sql = "DELETE FROM $this->table WHERE $this->pk = $pkValue";
		$this->result = mysql_query($sql);
		if($this->result)
			return true;

		return false;
	}
}