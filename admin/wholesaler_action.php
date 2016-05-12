<?php
require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_wholesaler_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objWholesaler = new Wholesaler();
//echo '<pre>';print_r($_REQUEST);die;

if($_SESSION['sessUserType']=='super-admin' || in_array('delete-wholesalers', $_SESSION['sessAdminPerMission'])){
    
    global $objGeneral;    
    $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'pkWholesalerID');

    if ($_REQUEST['frmChangeAction'] == 'Delete') {             
            if ($objWholesaler->removeWholesaler($_REQUEST,$varPortalFilter)) {
                $objCore->setSuccessMsg("Deleted Successfully.");
            } else {
                $objCore->setErrorMsg("Not deleted Successfully.");
            }
        }        
        else if ($_REQUEST['frmChangeAction'] == 'Delete All') 
        {
             
            if ($objWholesaler->removeAllWholesaler($_REQUEST,$varPortalFilter)) {
                $objCore->setSuccessMsg("Deleted Successfully.");
            } else {
                $objCore->setErrorMsg("Not deleted Successfully.");                
            }
        }
        header('location:' . $_SERVER['HTTP_REFERER']); die;
}else{
$objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
header('location:wholesaler_manage_uil.php');  
die;
}
?>
