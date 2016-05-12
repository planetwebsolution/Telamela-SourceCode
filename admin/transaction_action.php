<?php
require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_wholesaler_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objWholesaler = new Wholesaler();


if($_SESSION['sessUserType']=='super-admin' || in_array('delete-wholesaler-transactions', $_SESSION['sessAdminPerMission'])){
    
    global $objGeneral;    
    $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'ToUserID');

    if ($_REQUEST['frmChangeAction'] == 'Delete') {             
            if ($objWholesaler->removeTransaction($_REQUEST,$varPortalFilter)) {
                $objCore->setSuccessMsg("Deleted Successfully.");
                header('location:wholesaler_transaction_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg("Not deleted Successfully.");
                header('location:wholesaler_transaction_manage_uil.php');
                die;
            }
        }
        
        else if (!empty($_REQUEST['frmID'])) 
        {
             
            if ($objWholesaler->removeAllTransaction($_REQUEST,$varPortalFilter)) {
                $objCore->setSuccessMsg("Deleted Successfully.");
                 header('location:wholesaler_transaction_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg("Not deleted Successfully.");
                 header('location:wholesaler_transaction_manage_uil.php');
                die;
            }
            
            
        }
    
}else{
$objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
header('location:wholesaler_transaction_manage_uil.php');
die;
}
?>