<?php

require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_country_portal_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objCountryPortal = new CountryPortal();
//pre($_REQUEST);

if ($_SESSION['sessUserType'] == 'super-admin' || in_array('delete-country-office-transactions', $_SESSION['sessAdminPerMission'])) {

    //global $objGeneral;    
    // $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'ToUserID');

    if ($_REQUEST['frmChangeAction'] == 'Delete') {
        if ($objCountryPortal->removeTransaction($_REQUEST)) {
            $objCore->setSuccessMsg("Deleted Successfully.");
            header('location:country_portal_transaction_manage_uil.php');
            die;
        } else {
            $objCore->setErrorMsg("Not deleted Successfully.");
            header('location:country_portal_transaction_manage_uil.php');
            die;
        }
    } else if (!empty($_REQUEST['frmID'])) {

        if ($objCountryPortal->removeAllTransaction($_REQUEST)) {
            $objCore->setSuccessMsg("Deleted Successfully.");
            header('location:country_portal_transaction_manage_uil.php');
            die;
        } else {
            $objCore->setErrorMsg("Not deleted Successfully.");
            header('location:country_portal_transaction_manage_uil.php');
            die;
        }
    }
} else {
    $objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
    header('location:country_portal_transaction_manage_uil.php');
    die;
}
?>