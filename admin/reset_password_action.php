<?php
require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH.'class_adminlogin_bll.php';
require_once $arrConfig['sourceRoot'].'components/class.validation.inc.php';
require_once CLASSES_PATH.'class_email_template_bll.php';
/* This is used to forgot password purpose */

if(isset($_POST['btnResetPassword']))
{
	/* Create users instance*/
	$objAdminLogin = new AdminLogin();
	if($objAdminLogin->resetPassword($_POST))
    {
	 header('location:reset_password.php?op=result');	
	 exit;
	}
	else
	{
	 header('location:reset_password.php?mid='.$_POST['frmMember'].'&code='.$_POST['frmCode']);	
	 exit;
	}
}
?>