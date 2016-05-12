<?php
require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_paypal_email_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objPaypal = new Paypal_email();
//echo '<pre>';print_r($_REQUEST);die;

if($_SESSION['sessUserType']=='super-admin'){

    if ($_REQUEST['frmChangeAction'] == 'Delete') {
             
            if ($objPaypal->removePaypal($_REQUEST)) {
                $objCore->setSuccessMsg("Deleted Successfully.");
                header('location:paypal_email_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg("Not deleted Successfully.");
                header('location:paypal_email_manage_uil.php');
                die;
            }
        }
    if (!empty($_REQUEST['frmID'])) {
             
            if ($objPaypal->removeAllPaypal($_REQUEST)) {
                $objCore->setSuccessMsg("Selected Record Deleted Successfully.");
                header('location:paypal_email_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg("Selected Record Not deleted Successfully.");
                header('location:paypal_email_manage_uil.php');
                die;
            }
        }
    
}else{
$objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
header('location:paypal_email_manage_uil.php');    
    
    
}
?>