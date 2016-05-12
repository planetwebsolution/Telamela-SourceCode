<?php

require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_coupon_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objCoupon = new Coupon();
//echo '<pre>';print_r($_REQUEST);die;

if ($_SESSION['sessUserType'] == 'super-admin' || in_array('delete-coupon', $_SESSION['sessAdminPerMission'])) {

    if ($_REQUEST['frmChangeAction'] == 'Delete') {
        if ($objCoupon->removeCoupon($_REQUEST)) {
            $objCore->setSuccessMsg("Deleted Successfully.");
            header('location:coupon_manage_uil.php');
            die;
        } else {
            $objCore->setErrorMsg("Not deleted Successfully.");
            header('location:coupon_manage_uil.php');
            die;
        }
    } else if (!empty($_REQUEST['frmID'])) {
        if ($objCoupon->removeCoupon($_REQUEST)) {
            $objCore->setSuccessMsg("Deleted Successfully.");
            header('location:coupon_manage_uil.php');
            die;
        } else {
            $objCore->setErrorMsg("Not deleted Successfully.");
            header('location:coupon_manage_uil.php');
            die;
        }
    }
} else {
    $objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
    header('location:coupon_manage_uil.php');
}
?>