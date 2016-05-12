<?php

/* * ****************************************
  Module name : Ajax Calls
  Date created : 06 June, 2013
  Date last modified : 06 June, 2013
  Author : Suraj Kumar Maurya
  Last modified by :  Suraj Kumar Maurya
  Comments : This file includes the funtions for AJAX calls.
  Copyright : Copyright (C) 1999-2011 Vinove Software and Services
 * **************************************** */
require_once('../config/config.inc.php');
require_once(CLASSES_PATH . 'class_customer_user_bll.php');


$varcase = $_POST['action'];
switch ($varcase) {

    case 'ShowAdmin':
        $objCustomer = new Customer();
        $cid = $_SESSION['sessUserInfo']['id'];
        $selectedId = $_REQUEST['id']; 
        $arrRows = $objCustomer->wholeSalerList();
        echo '<option value="0">'.SEL_WHOL.'</option>';
        foreach ($arrRows as $k => $v) {
            $varSel = ($selectedId==$v['pkWholesalerID'])?'selected=selected':'';
            echo '<option value="' . $v['pkWholesalerID'] . '" '.$varSel.'>' . $v['CompanyName'] . '</option>';
        }
        //echo '</select>';


        break;
    Case 'deleteFromWishlist':
        $objCustomer = new Customer();
        if (!empty($_SESSION['sessUserInfo']['id'])) {
            if ($objCustomer->deleteProductFromWishlist($_SESSION['sessUserInfo']['id'], $_REQUEST['pid'])) {
                echo "1";
            } else {
                echo "0";
            }
        } else {
            echo "0";
        }
        break;
    
    case 'checkCurrentCustomerPassword':
        $objCustomer = new Customer();
        $currentP=trim($_REQUEST['pid']);
        echo $objCustomer->varifyCurrentPassword($currentP);
    break;

    case 'invoice':
        $objCustomer = new Customer();
        echo $cid = $_SESSION['sessUserInfo']['id'];
        echo $oid = $_REQUEST['oid'];
        $arrRows = $objCustomer->getInvoiceDetails($oid, $cid);

        echo '<link type="text/css" rel="stylesheet" href="' . CSS_PATH . 'invoice.css" /><link type="text/css" rel="stylesheet" href="' . CSS_PATH . 'print.css" media="print" />';
         echo '<table border="0" width="100%" class="no-print"><td align="right"><button onclick="window.close();"> '.CLOSE.'</button>&nbsp;&nbsp;<button onclick="window.print();">'.PRINT_DATA.'</button></td></tr></table>';
        echo html_entity_decode($arrRows[0]['InvoiceDetails']);
        echo '<div style="height: 50px; clear: both;"></div>';

        break;
    case 'addTowish':
        $objCustomer = new Customer();
        $pid = $_REQUEST['pid'];
        echo $arrRows = $objCustomer->myWishlistAdd($pid);
        break;
    case 'sameShippingAddess':
    $objCustomer = new Customer();
    $array=array('SameShipping'=>$_REQUEST['sm']);     
    $objCustomer->sameShippingAddess($array);    
    break;    
    
    
    
    
}
?>