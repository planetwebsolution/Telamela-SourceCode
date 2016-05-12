<?php

require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_package_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objPackage = new Package();
//pre(count($_REQUEST['frmID']));
if ($_SESSION['sessUserType'] == 'super-admin' || in_array('delete-package', $_SESSION['sessAdminPerMission'])) {
    
    $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs']);

    //if ($_REQUEST['frmChangeAction'] == 'Delete') {
    if(!empty($_REQUEST['frmID'])){
        if ($objPackage->removePackage($_REQUEST,$varPortalFilter)) {
            $objCore->setSuccessMsg("Deleted Successfully.");
            header('location:package_manage_uil.php');
            die;
        } else {
            $objCore->setErrorMsg("Not deleted Successfully.");
            header('location:package_manage_uil.php');
            die;
        }
    }
} else {
    $objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
    header('location:package_manage_uil.php');
}
?>