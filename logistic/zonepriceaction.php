<?php

require_once '../common/config/config.inc.php';
require_once CLASSES_LOGISTIC_PATH . 'class_zone_price_bll.php';

//$objAdminLogin = new AdminLogin();
////check admin session
//$objAdminLogin->isValidAdmin();

$objPriceZoneGateway = new ZonePriceNew();
//echo '<pre>';print_r($_REQUEST);die;
if (!empty($_REQUEST['frmID'])) {
   
    $objPriceZoneGateway->removezonepric($_REQUEST);
       
            $objCore->setSuccessMsg("Deleted Successfully.");
            header('location:price_manage_uil.php');
            die;
        
    }
    else {
           // pre("hed");
            $objCore->setErrorMsg("Not deleted Successfully.");
            header('location:price_manage_uil.php');
            die;
        }

//if ($_REQUEST['frmChangeAction'] == 'Delete') {
//        if ($objPriceZoneGateway->removezonepric($_REQUEST)) {
//            $objCore->setSuccessMsg("Deleted Successfully.");
//            header('location:price_manage_uil.php');
//            die;
//            
//        } else {
//            $objCore->setErrorMsg("Not deleted Successfully.");
//            header('location:price_manage_uil.php');
//            die;
//        }
//    } else if (!empty($_REQUEST['frmID'])) {
//        if ($objPriceZoneGateway->removezonepric($_REQUEST)) {
//            $objCore->setSuccessMsg("Deleted Successfully.");
//            header('location:price_manage_uil.php');
//            die;
//        } else {
//            $objCore->setErrorMsg("Not deleted Successfully.");
//            header('location:price_manage_uil.php');
//            die;
//        }
//    }
?>