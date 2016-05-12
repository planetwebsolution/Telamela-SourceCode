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
require_once CLASSES_LOGISTIC_PATH . 'class_add_zone_bll.php';
$objAdminlogisticLogin=new AdminLogistic();

if($_POST['action'])
{	
	if($objAdminlogisticLogin->doAdminLogin($_POST))
	{	
           // pre("yes");
           // pre($_SESSION);
             $objZoneGateway = new ZoneGatewayNew();
             $arrRecords = $objZoneGateway->checkzonecreateonece($_SESSION['sessLogistic']);
            //pre($arrRecords);
             if(!empty($arrRecords[0]['zoneid']))
             {
                 header('location:setup_manage_uil.php');
		exit;
             }
             else
             {
                 header('location:zone_add_uil.php');
		exit;
             }
					
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
