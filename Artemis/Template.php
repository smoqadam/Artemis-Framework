<?php
/**
*
* Artemis/Template.php
* Artemis Framework
* @author : Saeed Moqadam Zade
*/



class Artemis_Template extends  Artemis_Object
{
	/**
	* vars 
	*
	* @access : private
	**/
	private $vars  = array();
	
	/**
	* separator title
	*
	**/
	private $separator   = ' - ';
	
	/**
	*  default theme
	*
	**/
	public  $theme ;
	
	
	/** 
	*  
	*/
	private $controller;
	
	
	/**
	* constructor 
	*
	* set Controller name
	*/
	function __construct($controller)
	{
		$this->controller = $controller;	
		$this->theme = Artemis_Config::get('theme');
	}
	
	/**
	* get vars
	*/
	public function __get($name) {
		if(isset($this->vars[$name]))
			return $this->vars[$name];
	}
	
	/**
	* set vars to use in view
	*
	*/
	public function __set($name, $value) 
	{
		$this->vars[$name] = $value;
	}
	
	
	/**
	* create elements
	*/
	function elem($elem , $vars)
	{
		
		ob_start();
		include('app/views/Elements/'.$elem.'.php');
		$this->{elem.ucfirst($elem)} = ob_get_clean();
		return ob_get_clean();
	}
	
	/**
	* render and show view in controllers name directory
	* 
	* @param string Page Title 
	* @param bool true to return with layout
	* @return render view 
	* @access public
	*/
	public function render($title ='', $tp = true)
	{
		//get action called view
		$b = debug_backtrace();
		$action = ($b[1]['function']);
		
		//check view exists
		$view = 'app/views/'.$this->controller.'/'.$action.'.php';
		if(!file_exists($view))
			throw new Artemis_File_Exception(" File $view Not Found.");
		
		ob_start();
		include($view);
		if($tp == true )
		{
				$this->content = ob_get_clean();
				ob_start();
				include("app/layout/$this->theme/index.php");
				echo ob_get_clean();
		}
		else	
		{
				echo   ob_get_clean();	 
		}
	}
	

	/**
	* Set layout title
	*
	*@access private
	*/
	private function setTitle($title = '')
	{
		if(!empty($title))
		{
			if(isset($this->vars['title']))
				$this->title = $this->title .$this->separator.$title;
			else
				$this->title = $title;		
		}
	}
	
	/**
	* Set Separator to separate titles
	**/
	private function setSeparator($s = ' - ')
	{
		$this->separator = $s;		
	}
	
	/**
	 * 
	 * clean string 
	 */
	function c($str)
	{
		return stripslashes(htmlentities($str , ENT_QUOTES , 'UTF-8'));		
	}	
}