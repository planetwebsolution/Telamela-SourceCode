<?php

require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_support_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objSupport = new Support();
//echo '<pre>';print_r($_REQUEST);die;
$varContinue = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'wholesaler_support_enquiry_manage_uil.php';


if ($_SESSION['sessUserType'] == 'super-admin' || in_array('delete-user-enquiries', $_SESSION['sessAdminPerMission'])) {

    global $objGeneral;
    $varq = ($_REQUEST['frm'] == 'outbox') ? 'fkToUserID' : 'fkFromUserID';
    $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], $varq);

    if ($_REQUEST['frmChangeAction'] == 'Delete') {

        if ($objSupport->removeSupport($_REQUEST, $varPortalFilter)) {
            $objCore->setSuccessMsg("Deleted Successfully.");
            header('location:'.$varContinue);
            die;
        } else {
            $objCore->setErrorMsg("Not deleted Successfully.");
            header('location:'.$varContinue);
            die;
        }
    }
    if (!empty($_REQUEST['frmID'])) {

        if ($objSupport->removeAllSupport($_REQUEST, $varPortalFilter)) {
            $objCore->setSuccessMsg("Selected Enquiry(s) Deleted Successfully.");
            header('location:'.$varContinue);
            die;
        } else {
            $objCore->setErrorMsg("Selected Enquiry(s) Not deleted Successfully.");
            header('location:'.$varContinue);
            die;
        }
    }
} else {
    $objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
    header('location:'.$varContinue);
}
?>