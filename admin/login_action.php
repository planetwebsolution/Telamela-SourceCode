<?php
/******************************************
Module name : Login form Check File  
Parent module : None
Date created : 7th January 2008
Date last modified : 24h October 2007
Last modified by : Vivek Avasthi
Comments : Admin Login Checked here. If Login is correct user will redirect to dashboard page, otherwise will redirect to login page with a Error Message. 
**********************************/

require_once '../common/config/config.inc.php';
require_once $arrConfig['sourceRoot'].'components/class.validation.inc.php';

$objAdminLogin=new AdminLogin();

if($_POST['action'])
{	
	if($objAdminLogin->doAdminLogin($_POST))
	{		
		header('location:dashboard_uil.php');
		exit;			
	}	
	else
	{
		header('location: index.php');
		exit;
	}			
}
else
{
	header('location:index.php');
	die;
}
?>
