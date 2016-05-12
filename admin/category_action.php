<?php

require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_category_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objCategory = new category();
//echo '<pre>';print_r($_REQUEST);die;
$varProcess = $_REQUEST['frmChangeAction'];
if ($_SESSION['sessUserType'] == 'super-admin' || in_array('delete-categories', $_SESSION['sessAdminPerMission'])) {

    switch ($varProcess) {
        case 'delete':


            if ($objCategory->removeCategory($_REQUEST)) {
                global $oCache;
                if ($oCache->bEnabled) {
                    $oCache->flushData();
                }
                unset($_SESSION['arrCat']);
                unset($_SESSION['arrCatChild']);
                //UPDATE THE STATUS TABLE FOR API
                $objCategory->update(TABLE_CATEGORY_UPDATE_STATUS, array('CategoryUpdateReadByIphone' => '1', 'CategoryUpdateReadByAndroid' => '1', 'CategoryUpdateStatusDate' => 'now()'), '1');
                $objCore->setSuccessMsg(ADMIN_DELETE_SUCCUSS_MSG);
                header('location:' . $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                $objCore->setErrorMsg(ADMIN_DELETE_ERROR_MSG);
                header('location:' . $_SERVER['HTTP_REFERER']);
                exit;
            }

            break;

        case 'restore':

            if ($objCategory->restoreCategory($_REQUEST)) {
                global $oCache;
                if ($oCache->bEnabled) {
                    $oCache->flushData();
                }
                unset($_SESSION['arrCat']);
                unset($_SESSION['arrCatChild']);
                $objCore->setSuccessMsg("Record restore successfully.");
                header('location:category_manage_uil.php');
                exit;
            } else {
                $objCore->setErrorMsg("Record not restored.");
                header('location:category_manage_uil.php');
                exit;
            }

            break;
    }
} else {
    $objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
    header('location:' . $_SERVER['HTTP_REFERER']);
}
?>