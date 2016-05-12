<?php
require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_region_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objRegion = new region();
if($_SESSION['sessUserType']=='super-admin' || in_array('delete-regions', $_SESSION['sessAdminPerMission'])){

    if ($_REQUEST['frmChangeAction'] == 'Delete') {
            if ($objRegion->removeRegion($_REQUEST)) {
                $objCore->setSuccessMsg("Deleted Successfully.");
                header('location:region_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg("Not deleted Successfully.");
                header('location:region_manage_uil.php');
                die;
            }
        }
}else{
$objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
header('location:region_manage_uil.php');
}
?>
