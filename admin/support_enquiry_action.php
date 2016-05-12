<?php
require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_support_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objSupport = new Support();
//echo '<pre>';print_r($_REQUEST);die;

if($_SESSION['sessUserType']=='super-admin' || in_array('delete-user-enquiries', $_SESSION['sessAdminPerMission'])){

    if ($_REQUEST['frmChangeAction'] == 'Delete') {
             
            if ($objSupport->removeSupport($_REQUEST)) {
                $objCore->setSuccessMsg("Deleted Successfully.");
                header('location:support_enquiry_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg("Not deleted Successfully.");
                header('location:support_enquiry_manage_uil.php');
                die;
            }
        }
    if ($_REQUEST['frmChangeAction'] == 'Delete All') {
             
            if ($objSupport->removeAllSupport($_REQUEST)) {
                $objCore->setSuccessMsg("Selected Enquiry(s) Deleted Successfully.");
                 header('location:support_enquiry_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg("Selected Enquiry(s) Not deleted Successfully.");
                header('location:support_enquiry_manage_uil.php');
                die;
            }
        }
    
}else{
$objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
 header('location:support_enquiry_manage_uil.php');    
    
}
?>