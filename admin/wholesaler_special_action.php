<?php
require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_wholesaler_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objWholesaler = new Wholesaler();
//pre($_REQUEST);

if($_SESSION['sessUserType']=='super-admin' || in_array('delete-wholesalers', $_SESSION['sessAdminPerMission'])){
    
    global $objGeneral;    
    $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs']);

    if ($_REQUEST['frmChangeAction'] == 'Delete') {             
            if ($objWholesaler->removeWholesalerSpecial($_REQUEST,$varPortalFilter)) {
                $objCore->setSuccessMsg("Deleted Successfully.");
            } else {
                $objCore->setErrorMsg("Not deleted Successfully.");
            }
        }        
        else if ($_REQUEST['frmChangeAction'] == 'Delete All') 
        {
             
            if ($objWholesaler->removeAllWholesalerSpecial($_REQUEST,$varPortalFilter)) {
                $objCore->setSuccessMsg("Deleted Successfully.");
            } else {
                $objCore->setErrorMsg("Not deleted Successfully.");                
            }
        }
        header('location:wholesaler_special_application_manage_uil.php'); die;
}else{
$objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
header('location:wholesaler_special_application_manage_uil.php');  
die;
}
?>
