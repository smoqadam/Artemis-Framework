<?php
/*
*   Artemis Framework                               					  |
* 
* @Author : Saeed Moghadam Zade

*/

class Auth extends AppModel
{
	 
	public $error;
	protected $table = 'users';
	
	private $user_data;
	
	function Auth()
	{
		session_start();
		parent::__construct();
	}
	
	/**
	* Login method 
	* @access public
	**/
	function login($username , $password)
	{
		$password = md5($password);
		$user = $this->find()->where(array("username"=>$username,"password"=>$password));
		
 		// print_r($user->numRows());
		if($user->numRows() > 0 )
		{
			$this->set_user_data($user->fetch());
			return true;
		}else 
			return false;
	}
	
	/**
	* Register Method
	***/
	function register($username , $password , $conf_pass)
	{
		if($this->has_user($username)) 
		{
			$this->errors("Username already exists");
			return false;
		}
		
		if($password === $conf_pass)
		{
			$data = array('username'=>$username,'password'=>md5($password),'role_id'=>3);
			if($this->create($data))
			{
				$this->save();
				return true;
			}
			$this->errors("Can not create");
			return false;
		}
		else
			$this->errors("Password does not match");
			
		return false;	
	}
	
	/**
	* Logout and unset sessions
	* 
	*
	**/
	function logout($username)
	{
		unset($_SESSION['user_data']);
	}
	
	/**
	* check user is logged in
	* 
	*
	**/
	function logged_in($restrict = '1')
	{
		if(isset($_SESSION['user_data']) AND $_SESSION['user_data']['role_id'] === $restrict)
		    return true;
		 
		 return false;
	}
	
	/** 
	*  check if exists User
	*
	**/
	function has_user($u)
	{
		$user = $this->find()->where(array("username"=>$u));
		if($user->numRows() > 0)
			return true;
		
		return false;	
	}
	
	/**
	* check if user has a permission
	* if user has persmission return tru else false
	*
	* 
	**/
	function hasPermission($username , $permission = '')
	{
		
		if($this->data('username') === $username) return true;
		
		return false;
		 
	}
	
 
	/**
	* set user data in session
	*
	**/
	private function set_user_data($user_data = array())
	{
		if(empty($user_data)) return false;
		
		foreach($user_data as $data)
			$_SESSION['user_data'] = $data;
	}
	
	/**
	* get user data from session
	*
	*
	*
	**/
	public function data($key)
	{
		if(!empty($key))
			return $_SESSION['user_data'][$key];
			
		return $_SESSION['user_data'];	
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