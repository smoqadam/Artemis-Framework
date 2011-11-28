<?php

/*
*   Artemis Framework                               					  |
* 
*  

*/
class Paginator
{
	private $pages;
	var $limit;
 	//offset of limit
	var $offset;
	//current URL
	var $cur;
	//text of Prev link
	var $prev = 'Prev';
	//text of Next link
	var $next = 'Next';
	//text of Last link
	var $last = 'Last';
	//text of First link
	var $first = 'First';
	//link css class
	var $aclass = 'paginate';
	
	
	/**
	* calculate and create pages array
	*
	*
	**/
	public function paginate($total_rows, $rows_per_page, $page_num)
	{
		$arr = array();
		// calculate last page
		$last_page = ceil($total_rows / $rows_per_page);
		// make sure we are within limits
		$page_num = (int) $page_num;
		if ($page_num < 1)
		{
		   $page_num = 1;
		} 
		elseif ($page_num > $last_page)
		{
		   $page_num = $last_page;
		}
		$upto = ($page_num - 1) * $rows_per_page;

		$arr['limit'] =  ' '.$upto.',' . $rows_per_page;
		 		$this->limit = $upto;
 		$this->offset = $rows_per_page;
		$arr['current'] = $page_num;
		if ($page_num == 1)
			$arr['previous'] = $page_num;
		else
			$arr['previous'] = $page_num - 1;
		if ($page_num == $last_page)
			$arr['next'] = $last_page;
		else
			$arr['next'] = $page_num + 1;
		$arr['last'] = $last_page;
		$arr['info'] = 'Page ('.$page_num.' of '.$last_page.')';
		$arr['pages'] = $this->get_surrounding_pages($page_num, $last_page, $arr['next']);
		//$this->lim = $this->limit
		return $this->pages = $arr;
	}
	
	/**
	* 
	*
	**/
	function get_surrounding_pages($page_num, $last_page, $next)
	{
		$arr = array();
		$show = 5; // how many boxes
		// at first
		if ($page_num == 1)
		{
			// case of 1 page only
			if ($next == $page_num) return array(1);
			for ($i = 0; $i < $show; $i++)
			{
				if ($i == $last_page) break;
				array_push($arr, $i + 1);
			}
			return $arr;
		}
		// at last
		if ($page_num == $last_page)
		{
			$start = $last_page - $show;
			if ($start < 1) $start = 0;
			for ($i = $start; $i < $last_page; $i++)
			{
				array_push($arr, $i + 1);
			}
			return $arr;
		}
		// at middle
		$start = $page_num - $show;
		if ($start < 1) $start = 0;
		for ($i = $start; $i < $page_num; $i++)
		{
			array_push($arr, $i + 1);
		}
		for ($i = ($page_num + 1); $i < ($page_num + $show); $i++)
		{
			if ($i == ($last_page + 1)) break;
			array_push($arr, $i);
		}
		return $arr;
	}
	
	/**
	* Create paginator links
	*
	*/
	public function createLink()
	{
		
		$pages = $this->pages;
		$links = $pages['pages'];
		foreach($links as $link)
		{
			if($pages['current'] != $link)
				$out .= "<a href='$this->cur/$link' class='$this->aclass'>$link</a> "	;
			else	
				$out .= " <span style='padding:5px'>$link</span> ";
		}	
		
		// create Previus Link
		//create First Link		
		if($pages['current'] != 1)
		{
			$out = " <a href='$this->cur/".$pages['previous']."' class='$this->aclass'>$this->prev</a> " . $out;
			$out = " <a href='$this->cur/1' class='$this->aclass'>$this->first</a> " .$out;						
		}
		//create next Link
		//create last Link		
		if($pages['current'] != $pages['last'])
		{
			$out .= " <a href='$this->cur/".$pages['next']."' class='$this->aclass'>$this->next</a> " ;
			$out .= " <a href='$this->cur/".$pages['last']."' class='$this->aclass'>$this->last</a> " ;
		}
		return $out;
		
	}
}
