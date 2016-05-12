<?php
require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_newsletter_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

 $objNewsLetter = new NewsLetter();
//echo '<pre>';print_r($_REQUEST);die;
 
 

if($_SESSION['sessUserType']=='super-admin' || in_array('delete-newsletters', $_SESSION['sessAdminPerMission'])){
    
    global $objGeneral;    
    $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'CreatedID');
    $varAdmin="";
        if ($_SESSION['sessAdminCountry'] > 0) {
            $varAdmin = " AND CreatedID = '" . $_SESSION['sessUser'] . "'";
        }
    
    if ($_REQUEST['frmChangeAction'] == 'Delete') {
             
            if ($objNewsLetter->removeNewsLetter($_REQUEST,$varPortalFilter,$varAdmin)) {
                $objCore->setSuccessMsg("Deleted Successfully.");
                header('location:newsletter_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg("Not deleted Successfully.");
                header('location:newsletter_manage_uil.php');
                die;
            }
        }
    if ($_REQUEST['frmID']!= '') {
             
            if ($objNewsLetter->removeAllNewsLetter($_REQUEST,$varPortalFilter,$varAdmin)) {
                $objCore->setSuccessMsg("Selected newsletter Deleted Successfully.");
                header('location:newsletter_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg("Selected newsletter not deleted Successfully.");
                header('location:newsletter_manage_uil.php');
                die;
            }
        }
    
}else{
$objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
header('location:newsletter_manage_uil.php');    
    
    
}
?>