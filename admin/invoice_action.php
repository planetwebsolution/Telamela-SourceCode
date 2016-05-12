<?php

require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_invoice_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objInvoice = new Invoice();
//pre($_REQUEST);
$varProcess = $_REQUEST['frmProcess'];
if ($_SESSION['sessUserType'] == 'super-admin' || in_array('delete-invoices', $_SESSION['sessAdminPerMission'])) {

    global $objGeneral;
    $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs']);

    switch ($varProcess) {
        case 'ManipulateInvoice':
            if ($_REQUEST['frmChangeAction'] == 'Delete') {

                if ($objInvoice->removeInvoice($_REQUEST, $varPortalFilter)) {
                    $objCore->setSuccessMsg(ADMIN_DELETE_SUCCUSS_MSG);
                    header('location:' . $_SERVER['HTTP_REFERER']);
                    exit;
                } else {
                    $objCore->setErrorMsg(ADMIN_DELETE_ERROR_MSG);
                    header('location:' . $_SERVER['HTTP_REFERER']);
                    exit;
                }
            }else if (!empty($_REQUEST['frmID'])) {

                if ($objInvoice->removeInvoice($_REQUEST, $varPortalFilter)) {                    
                    $objCore->setSuccessMsg(ADMIN_DELETE_SUCCUSS_MSG);                    
                    header('location:' . $_SERVER['HTTP_REFERER']);
                    exit;
                } else {
                    $objCore->setErrorMsg(ADMIN_DELETE_ERROR_MSG);                     
                    header('location:' . $_SERVER['HTTP_REFERER']);
                    exit;
                }
            }
            
            
            break;
    }
} else {
    $objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
    header('location:' . $_SERVER['HTTP_REFERER']);
}
?>