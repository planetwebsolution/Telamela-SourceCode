<?php
require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_customer_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objCustomer = new customer();
//echo '<pre>';print_r($_REQUEST);die;

if($_SESSION['sessUserType']=='super-admin' || in_array('delete-customers', $_SESSION['sessAdminPerMission'])){

    if ($_REQUEST['frmChangeAction'] == 'Delete') {
             
            if ($objCustomer->removeCustomer($_REQUEST)) {
                $objCore->setSuccessMsg("Deleted Successfully.");
                header('location:customer_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg("Not deleted Successfully.");
                header('location:customer_manage_uil.php');
                die;
            }
        }
        
        else  if (!empty($_REQUEST['frmID'])){
            
             
            if ($objCustomer->removeAllCustomer($_REQUEST)) {
                $objCore->setSuccessMsg("Deleted Successfully.");
                header('location:customer_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg("Not deleted Successfully.");
                header('location:customer_manage_uil.php');
                die;
            }
            
        }
    
}else{
$objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
header('location:customer_manage_uil.php');  
die;
}
?>