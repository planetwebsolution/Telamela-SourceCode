<?php

require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_product_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objProduct = new Product();
global $oCache;
//echo '<pre>';print_r($_REQUEST);die;
$varProcess = $_REQUEST['frmProcess'];
if ($_SESSION['sessUserType'] == 'super-admin' || in_array('delete-products', $_SESSION['sessAdminPerMission'])) {

    $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs']);
    //pre($varPortalFilter);

    switch ($varProcess) {
        case 'ManipulateProduct':
            if ($_REQUEST['frmChangeAction'] == 'Delete') {
                if ($objProduct->removeProduct($_REQUEST, $varPortalFilter)) {
                    $objCore->setSuccessMsg(ADMIN_DELETE_SUCCUSS_MSG);
                } else {
                    $objCore->setErrorMsg(ADMIN_DELETE_ERROR_MSG);
                }
                
            } else if (!empty($_REQUEST['frmID'])) {
                if ($objProduct->removeProduct($_REQUEST, $varPortalFilter)) {
                    $objCore->setSuccessMsg(ADMIN_DELETE_SUCCUSS_MSG);
                } else {
                    $objCore->setErrorMsg(ADMIN_DELETE_ERROR_MSG);
                }
               
            }
            break;
    }

    header('location:' . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    $objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
    header('location:' . $_SERVER['HTTP_REFERER']);
}
?>