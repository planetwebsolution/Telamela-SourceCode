<?php
/* * ****************************************
  Module name : Ajax Calls
  Date created : 23 July, 2015
  Date last modified : 23 July, 2015
  Author : Sandeep Sharma
  Last modified by :  Sandeep Sharma
  Comments : This file includes the funtions for AJAX calls.
  Copyright : Copyright (C) 1999-2011 Vinove Software and Services
 * **************************************** */
require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_reports_bll.php';
require_once CLASSES_PATH . 'class_common.php';
require_once CLASSES_ADMIN_PATH . 'class_product_bll.php';
$varSection = $_REQUEST['section'];
$varAction = $_REQUEST['action'];
$data='';
if(isset($_REQUEST['action'])){
    $data=$_REQUEST['data'];
}

$objClassCommon = new ClassCommon();
$objReports= new Reports();

switch ($varSection)
{
    case 'orders':    
        $arrData=$objReports->getOrdersData($varAction,$data);
        break;
    case 'revenue':    
        $arrData=$objReports->getRevenuesData($varAction,$data);
        break;
    case 'sales':    
        $arrData=$objReports->getSalesData($varAction,$data);
        break;
}
?>
