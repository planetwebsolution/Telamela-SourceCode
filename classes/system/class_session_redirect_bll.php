<?php
/**
*
* Module name : Session
*
* Parent module : None
*
* Date created : 28 March 2013
*
* Date last modified :  28 March 2013
*
* Author :  Prashant Bhardwaj
*
* Last modified by : Prashant Bhardwaj
*
* Comments : The Category class contains various functions related to the categories
*
*/	
class SessionRedirectUrl
{
	function SessionRedirectUrl()
	{ 
		//default constructor for this class 
	}
	/**
	*
	* Function Name :  setBackRedirectUrl
	*
	* Return type : string
	*
	* Date created : 28 March 2013
	*
	* Date last modified :  28 March 2013
	*
	* Author : Prashant Bhardwaj
	*
	* Last Modified By :  Prashant Bhardwaj
	*
	* Comments : This function returns the actual back url from add/update form

	* User instruction : obj->setBackRedirectUrl($argUrlFullPath)
	*
	*/	
	function setBackRedirectUrl($argUrlFullPath)
	{
		$varUrlFullPath = $argUrlFullPath;
		$arrExplodeCurrentURL = explode("/", $varUrlFullPath);
		$varLengthForArray = count($arrExplodeCurrentURL);
		$varUserRedirectURL = $arrExplodeCurrentURL[($varLengthForArray - 1)];
		return $varUserRedirectURL;
	}
}?>	
