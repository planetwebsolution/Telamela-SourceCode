<?php

require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_order_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objOrder = new Order();
//pre($_REQUEST);

$varProcess = $_REQUEST['frmProcess'];
if ($_SESSION['sessUserType'] == 'super-admin' || in_array('delete-orders', $_SESSION['sessAdminPerMission'])) {
    global $objGeneral;
    $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs']);

    switch ($varProcess) {
        case 'ManipulateOrder':
            if ($_REQUEST['frmChangeAction'] == 'Delete') {
                if ($objOrder->removeOrder($_REQUEST, $varPortalFilter)) {
                    $objCore->setSuccessMsg(ADMIN_DELETE_SUCCUSS_MSG);
                    header('location:' . $_SERVER['HTTP_REFERER']);
                    exit;
                } else {
                    $objCore->setErrorMsg(ADMIN_DELETE_ERROR_MSG);
                    header('location:' . $_SERVER['HTTP_REFERER']);
                    exit;
                }
            } else if (!empty($_REQUEST['frmID'])) {
              
                if ($objOrder->removeOrder($_REQUEST, $varPortalFilter)) {
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