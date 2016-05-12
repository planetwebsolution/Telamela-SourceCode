<?php
require_once 'common/config/config.inc.php';
require_once CLASSES_PATH . 'class_customer_user_bll.php';
$objCustomer = new Customer();	
$cid = $_SESSION['sessUserInfo']['id'];
        if ($_REQUEST['frmChangeAction'] == 'Delete') {
             
            if ($objCustomer->messageRemove($_REQUEST,$cid)) {
                $objCore->setSuccessMsg(FRONT_SUPPORT_DELETE_MSG);
                header('location:'.$_SERVER['HTTP_REFERER']);
                exit;
            } else {
                $objCore->setErrorMsg(FRONT_DELETE_ERROR_MSG);
                header('location:'.$_SERVER['HTTP_REFERER']);
                exit;
            }
   
          }
?>