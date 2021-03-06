<?php

require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_shipping_gateway_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objShippingGateway = new ShippingGateway();
//echo '<pre>';print_r($_REQUEST);die;

if ($_SESSION['sessUserType'] == 'super-admin') {

    if ($_REQUEST['frmChangeAction'] == 'Delete') {
        if ($objShippingGateway->removeShippingcountries($_REQUEST)) {
            $objCore->setSuccessMsg("Deleted Successfully.");
        } else {
            $objCore->setErrorMsg("Not deleted Successfully.");
        }
    }
} else {
    $objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
}

header('location:shipping_countries_uil.php');
die;
?>