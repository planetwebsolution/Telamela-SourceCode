<?php

require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH.'class_module_list_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objModuleList = new moduleList();
//echo '<pre>';print_r($_REQUEST);die;
$varProcess = $_REQUEST['frmProcess'];
 
switch ($varProcess) {
    case 'ManipulateRoll':
        if (!empty($_REQUEST['frmID'])) {
            //pre($_REQUEST);  
            if ($objModuleList->removeRoll($_REQUEST)) {
                $objCore->setSuccessMsg("Deleted Successfully.");
                header('location:user_roll_manage_uil.php');
                exit;
            } else {
                $objCore->setErrorMsg("Not deleted Successfully.");
                header('location:user_roll_manage_uil.php');
                exit;
            }
        }
        break;
}
?>