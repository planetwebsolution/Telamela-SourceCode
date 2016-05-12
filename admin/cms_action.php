<?php

require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_cms_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objCms = new cms();
//echo '<pre>';print_r($_REQUEST);die;

if ($_SESSION['sessUserType'] == 'super-admin' || in_array('delete-cms', $_SESSION['sessAdminPerMission']))
{

    if ($_REQUEST['frmChangeAction'] == 'Delete')
    {

        if ($objCms->removeCms($_REQUEST))
        {
            global $oCache;
            if ($oCache->bEnabled)
            {
                $oCache->flushData();
            }
            $objCore->setSuccessMsg("Deleted Successfully.");
            header('location:cms_manage_uil.php');
            die;
        }
        else
        {
            $objCore->setErrorMsg("Not deleted Successfully.");
            header('location:cms_manage_uil.php');
            die;
        }
    }
    if (!empty($_REQUEST['frmID']))
    {

        if ($objCms->removeAllCms($_REQUEST))
        {
            global $oCache;
            if ($oCache->bEnabled)
            {
                $oCache->flushData();
            }
            $objCore->setSuccessMsg("Selected CMS Deleted Successfully.");
            header('location:cms_manage_uil.php');
            die;
        }
        else
        {
            $objCore->setErrorMsg("Selected CMS Not deleted Successfully.");
            header('location:cms_manage_uil.php');
            die;
        }
    }
}
else
{
    $objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
    header('location:cms_manage_uil.php');
}
?>