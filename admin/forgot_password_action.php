<?php
require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH.'class_adminlogin_bll.php';
require_once SOURCE_ROOT.'components/class.validation.inc.php';
require_once CLASSES_PATH.'class_email_template_bll.php';
/* This is used to forgot password purpose */

if(isset($_POST['btnMailPassword']))
{
    //echo "hi";die;
	/* Create users instance*/
    $objAdminLogin = new AdminLogin();    
    $objAdminLogin->forgotPasswordMail($_POST);
    header('location:forgot_password.php');	
	//echo "hi";die;
    exit;
}
?>