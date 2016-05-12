<?php
/**
*
*  Module name : Visitor
*
*  Parent module : None
*
*  Date created : 27th december 2013
*
*  Date last modified : 
*
*  Author :  pankaj katiyar
*
*  Last modified by : pankaj katiyar
*
*  Comments : The visitor class contains various functions related to the visitor listing
*
*/ 	
class Url 
{
	//Constructor
	function Url()
	{ 
	  //default constructor for this class 
	}

	public function get_url()
	{
	    if($_SERVER['HTTPS'])
	    {
		$linkurl = 'https://';
	    }
	    else
	    {
		$linkurl = 'http://';
	    }
	
	    $linkurl .= $_SERVER['HTTP_HOST'];
	
	    if($show_port)
	    {
		$my_url .= ':' . $_SERVER['SERVER_PORT'];
	    }
	
	    $linkurl .= $_SERVER['SCRIPT_NAME'];
	
	    if($_SERVER['QUERY_STRING'] != null)
	    {    
		$linkurl .= '?' . $_SERVER['QUERY_STRING'];
	    }
	
	    return $linkurl;
	}	
			
		
}
/**  
*
*  end of class
*
*/

?>

