<?php

/*
*   Artemis Framework                               					  |
* 
* @Author : Saeed Moghadam Zade
*/
class Artemis_Plugin_Auth 
{
	public $error;
	protected $table = 'admin', $model;
	private $user_data, $session;

	/**
	* 
	*/
	function Artemis_Plugin_Auth()
	{
		$model = new Artemis_Model('admin');
		//$model->table = 'admin';//$this->table;
		$model->pk = 'username';
		$this->model = $model;
		$this->session = new Artemis_Helper_Session();
	}

	/**
	* Login method 
	* @access public
	**/
	function login($username , $password)
	{
		$password = md5($password);
		$user = $this->model->db->find()->where(array('username'=>$username,'password'=>$password));
		
		if($user->numRows() > 0 )
		{
			$this->set_user_data($user->fetchOne());
			return true;
		}
		else 
			return false;
	}
	
  /**
	*
	* @param type $username
	* @param type $password
	* @param type $conf_pass
	* @return type 
	*/
	function register($username , $password , $conf_pass)
	{
		if($this->has_user($username)) 
		{
			$this->errors('Username already exists');
			return false;
		}

		if($password === $conf_pass)
		{
			$data = array('username'=>$username,'password'=>md5($password),'role_id'=>3);
			if($this->model->db->create($data))
			{
				$this->model->db->save();
				return true;
			}
			$this->errors('Can not create');
			return false;
		}
		else
			$this->errors('Password does not match');

		return false;	
	}
	
  /**
	*
	* @param type $username 
	*/
	function logout($username)
	{
		unset($_SESSION['user_data']);
	}

	/**
	*
	* @param type $restrict
	* @return type 
	*/
	function logged_in($restrict = '1')
	{
		if($this->session->is_set('user_data') AND $this->session->get('user_data' ,'role_id') === $restrict)
			return true;

		 return false;
	}

  /**
	*
	* @param type $u
	* @return type 
	*/
	function has_user($u)
	{
		$user = $this->model->db->find()->where(array('username'=>$u));

		if($user->numRows() > 0)
			return true;

		return false;	
	}
 
	/**
	* set user data in session
	*
	**/
	private function set_user_data($user_data = array())
	{
		//_p($user_data);
		if(empty($user_data))
			return false;

		foreach($user_data as $data)
         $this->session->set('user_data' , $data);
	}
	
	/**
	* get user data from session
	*
	*
	**/
	public function data($key)
	{
		if(!empty($key))
			return $this->session->get('user_data');

      return $this->session->get('user_data');	
		//return $_SESSION['user_data'];	
	}

	/**
	* get errors
	*
	*/
	function errors($e)
	{
		$this->error .= $e;
		return $this->error;
	}
}