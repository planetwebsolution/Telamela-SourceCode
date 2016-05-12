<?php

require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_ads_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objAds = new Ads();
global $oCache;
//echo '<pre>';print_r($_REQUEST);die;

if ($_SESSION['sessUserType'] == 'super-admin' || in_array('delete-ads', $_SESSION['sessAdminPerMission']))
{

    if ($_REQUEST['frmChangeAction'] == 'Delete')
    {
        if ($oCache->bEnabled)
        {
            $oCache->flushData();
        }
        if ($objAds->removeAds($_REQUEST))
        {
            unset($_SESSION['arrCatAds']);
            $objCore->setSuccessMsg("Deleted Successfully.");
            header('location:ads_manage_uil.php');
            die;
        }
        else
        {
            $objCore->setErrorMsg("Not deleted Successfully.");
            header('location:ads_manage_uil.php');
            die;
        }
    }

    if ($_REQUEST['frmID'] != '')
    {
        unset($_SESSION['arrCatAds']);
        if ($oCache->bEnabled)
        {
            $oCache->flushData();
        }
        if ($objAds->removeAllAds($_REQUEST))
        {
            $objCore->setSuccessMsg("Selected Advertisement(s) Deleted Successfully.");
            header('location:ads_manage_uil.php');
            die;
        }
        else
        {
            $objCore->setErrorMsg("Not deleted Successfully.");
            header('location:ads_manage_uil.php');
            die;
        }
    }
}
else
{
    $objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
    header('location:ads_manage_uil.php');
}
?>