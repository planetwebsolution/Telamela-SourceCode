<?php
require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_enquiry_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objEnquiry = new Enquiry();

if($_SESSION['sessUserType']=='super-admin' || in_array('delete-user-enquiries', $_SESSION['sessAdminPerMission'])){

    if ($_REQUEST['frmChangeAction'] == 'Delete') {
             
            if ($objEnquiry->removeEnquiry($_REQUEST)) {
                $objCore->setSuccessMsg("Deleted Successfully.");
                header('location:user_enquiry_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg("Not deleted Successfully.");
                header('location:user_enquiry_manage_uil.php');
                die;
            }
        }
    if ($_REQUEST['frmChangeActionAll'] == 'Delete All') 
    {
        
        if ($objEnquiry->removeAllEnquiry($_REQUEST)) {            
            $objCore->setSuccessMsg("Deleted Successfully.");
            header('location:user_enquiry_manage_uil.php');
            exit;
        } else {
            $objCore->setErrorMsg("Not deleted Successfully.");
            header('location:user_enquiry_manage_uil.php');
            exit;
        }
    }
        
    if (!empty($_REQUEST['frmID'])) {
             
            if ($objEnquiry->removeAllEnquiry($_REQUEST)) {
                $objCore->setSuccessMsg("Selected Enquiry(s) Deleted Successfully.");
                 header('location:user_enquiry_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg("Selected Enquiry(s) Not deleted Successfully.");
                header('location:user_enquiry_manage_uil.php');
                die;
            }
        }
    
}else{
   // die('fsf');
$objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
 header('location:' . $_SERVER['HTTP_REFERER']);    
    
}
?>