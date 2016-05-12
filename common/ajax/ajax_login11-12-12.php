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
require_once CLASSES_PATH . 'class_customer_user_bll.php';
require_once CLASSES_PATH . 'class_wholesaler_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

$objCore = new Core();
$objCustomer = new Customer();
$objWholesaler = new Wholesaler();

$varcase = $_POST['action'];

switch ($varcase) {

    case 'Login':
        if ($_POST['frmUserType'] == 'customer') { 
            //pre($_POST);
            echo $status = $objCustomer->userLogin($_POST);
        } else if ($_POST['frmUserType'] == 'wholesaler') {
            echo $status = $objWholesaler->wholesalerLogin($_POST);
        }
        break;

    case 'forgetPassword':

        if ($_POST['frmUserType'] == 'customer') {
            echo $status = $objCustomer->sendForgotPasswordEmail($_POST);
        } else if ($_POST['frmUserType'] == 'wholesaler') {
            echo $status = $objWholesaler->sendForgotPasswordEmailWholesaler($_POST);
        }
        break;
      case 'LoginToSaveProduct':
        if ($_POST['frmUserType'] == 'customer') {  
            //pre($_POST);
            echo $status = $objCustomer->userLoginToSaveProduct($_POST);
        } 
        break;  
        
}
?>