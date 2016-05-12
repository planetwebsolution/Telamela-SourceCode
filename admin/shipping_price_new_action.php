<?php

require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_shipping_gateway_bll.php';
$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objShippingGateway = new ShippingGateway();
//pre($_REQUEST);

if ($_SESSION['sessUserType'] == 'super-admin') {

    if (!empty($_REQUEST['frmID'])) {

        if ($objShippingGateway->removeShippingGateway($_REQUEST)) {
            $objCore->setSuccessMsg("Deleted Successfully.");
            header('location:shipping_gateway_manage_uil.php');
            die;
        } else {
            $objCore->setErrorMsg("Not deleted Successfully.");
            header('location:shipping_gateway_manage_uil.php');
            die;
        }
    }
} else {
    $objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
    header('location:shipping_gateway_manage_uil.php');
}
?>