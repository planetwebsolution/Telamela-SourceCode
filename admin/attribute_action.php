<?php
require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_attribute_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

$objAttribute = new attribute();
//echo '<pre>';print_r($_REQUEST);die;
$varProcess = $_REQUEST['frmProcess'];
if($_SESSION['sessUserType']=='super-admin' || in_array('delete-attributes', $_SESSION['sessAdminPerMission'])){
switch ($varProcess) {
    case 'ManipulateAttribute':
        if (!empty($_REQUEST['frmID']) || $_REQUEST['frmChangeAction'] == 'Delete') {
             
            if ($objAttribute->removeAttribute($_REQUEST)) {
                $objCore->setSuccessMsg(ADMIN_DELETE_SUCCUSS_MSG);
                header('location:'.$_SERVER['HTTP_REFERER']);
                exit;
            } else {
                $objCore->setErrorMsg(ADMIN_DELETE_ERROR_MSG);
                header('location:'.$_SERVER['HTTP_REFERER']);
                exit;
            }
        }
        else if(isset($_REQUEST['frmUpdateOrder']) && $_REQUEST['frmUpdateOrder'] == 'order')
		      {
                         $varUpdateAttributeOrder = $objAttribute->updateAttributeOrder($_REQUEST);
                                      $objCore->setMultipleSuccessMsg($varUpdateAttributeOrder);
			             //$objCore->setSuccessMsg(ADMIN_Order_UPDATE_SUCCUSS_MSG);
				         header('location:'.$_SERVER['HTTP_REFERER']);
                                exit;
		      }	
        break;
}
}else{
$objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE);
header('location:'.$_SERVER['HTTP_REFERER']);    
    
    
}
?>