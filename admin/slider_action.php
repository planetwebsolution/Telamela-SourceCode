<?php

require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_slider_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objSlider = new Slider();
//echo '<pre>';print_r($_REQUEST);die;

if ($_SESSION['sessUserType'] == 'super-admin' || in_array('delete-home-slider', $_SESSION['sessAdminPerMission']))
{

    if ($_REQUEST['frmChangeAction'] == 'Delete')
    {

        if ($objSlider->removeSlider($_REQUEST))
        {
            global $oCache;
            if ($oCache->bEnabled)
            {
                $oCache->flushData();
            }
            $objCore->setSuccessMsg("Deleted Successfully.");
        }
        else
        {
            $objCore->setErrorMsg("Not deleted Successfully.");
        }
    }
    else if ($_REQUEST['frmID'] != '')
    {

        if ($objSlider->removeAllSlider($_REQUEST))
        {
            global $oCache;
            if ($oCache->bEnabled)
            {
                $oCache->flushData();
            }
            $objCore->setSuccessMsg("Selected Banner(s) Deleted Successfully.");
        }
        else
        {
            $objCore->setErrorMsg("Not deleted Successfully.");
        }
    }
}
else
{
    $objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
    //header('location:slider_manage_uil.php');
}
header('location:slider_manage_uil.php');
die;
?>