
<?php

class Ajax
{
	
	
	var $attrib = array();
	var $jsPath = '';
	var $loadingImage = '';
	
	var $errors = array();
	
	private static $instance;
	
	
	
	function Ajax()
	{
	}
	
	public static function getInstance()
	{
		if(empty(self::$instance))
		{
			return new Ajax();
		}
	}
	
	/*
	*	Create Ajax link
	*
	*	@param : $attribs : etc. array("href"=>"target.php" , "text"=>"Click here!"); 
	*	@param : $option : array('method'=>'get',
								 'url'=>'add.php',
								 'target'=>'.result' // continer to chang
								 'loadPage'=>'', // call js function loadPage or sendForm
								 'param'=>array('id'=>1));
					
	*
	*
	*/
	function link($attribs = array() , $option = array())
	{
		
		if(is_array($attribs))
		{
			if(!isset($attribs['href']))
				$attribs['href'] = $option['url'];
			$attrib = $this->set_attrib($attribs);
		}
		else
			$this->errors[] = "Attribute is not array!";
		
		//set options
		$opt = $this->set_option($option);

			$link = "<a $attrib $opt>".$attribs['text']."</a>" ;
		

		return ($link);
	}
	

	/*
	*
	*	$attribs : etc. array("value"=>"Click Here!" , class"=>"alink"); 
	*	$url : target Ajax url
	*	$method : set Post or Get method To send data
	*	$param : etc. array("id"=>21 ,"name"=>"Saeed"); parameter to send  ajax
	*	$div : class name of element to change
	*
	*/
	function button($attribs = array() , $option = array())
	{
		
		if(is_array($attribs))
			$attrib = $this->set_attrib($attribs);
		else
			$this->errors[] = "Attribute is not array!";
		
		$opt = $this->set_option($option);

		$link = "<input $attrib type='submit' $opt />" ;
		 
		return ($link);
	}
	
	function image($attribs = array() , $option = array())
	{
		if(is_array($attribs))
			$attrib = $this->set_attrib($attribs);
		else
			$this->errors[] = "Attribute is not array!";
		
		$opt = $this->set_option($option);

		//$link = "<input $attrib type='image' $opt /><br /><a href='#' $opt>".$attribs['text'].'</a>' ;
		$link = "<a href='#' $opt><img $attrib /><br>".$attribs['text']."</a>" ;
		 
		return ($link);
	}
	
	/*
	* Set Option 
	* 
	*
	*
	*
	*/
	function set_option($options)
	{
		$confirm = '';
		if(!is_array($options))
			return false;
		 
		foreach($options as $key=>$value)
		{
			// set method Get or Post
			if($key=='method') $method = $value;	
			
			//	set function ajax
			if($key == 'sendForm')
			{
				$frmID  = $value;	
				$function = 'sendForm';
			}
			else if($key == 'loadPage')
					{
						 $function = 'loadPage';
						 
					}
			/*
			
				url=>array('controller'=>'home','action'=>send');
			
			
			*/			
			//set url to send
			if($key == 'url') 
			{
				
				if(is_array($value))
				{
					if(array_key_exists('param' , $value))
					{
						if(is_array($value['param']))
							$prameter = implode('/',$value['param']);
						else
							$prameter = $value['param'];		
					}
					else
						$prameter = '';
					$url = BASE_URL.$value['controller'].'/'.$value['action'].'/'.$prameter;
				}   
			}
			
			
			//set target to change
			if($key == 'target') $target = $value;
			
			if($key == 'confirm') $confirm = $value;
			
			
		}//end for each
		
		 
		 if($function == 'sendForm')
			 $onclick .= "onclick=\"sendForm('$url' , '$target' , '$frmID');return false;\"";
 		 else if($function == 'loadPage')
		 	$onclick = "onclick=\"loadPage('$url' , '$target' , '$confirm');return false;\"";
		
		return $onclick;
	}
	/*
	*
	*	 
	*	$attribs : convert attribs array to formated string
	*	array("href"=>"target.php" ,"text"=>"Click Here", "class"=>"acls");
	*	 <a href="target.php" class="acls">Click Here</a>
	*
	*/
	function set_attrib($attribs = array())
	{	
		foreach($attribs as $key=>$value)
		{
			
			$attrib[] =   $key.'=\''.$value.'\' ';
		}	
		return implode(' ',$attrib);
	}

	function loading($loading = '')
	{
		if(empty($loading))
		echo '
			<div class="loading">
				<img src="'.IMG_FOLDER.'loading.gif"/>
			</div>';	
		else
			echo $loading;	
	}

	 

}

