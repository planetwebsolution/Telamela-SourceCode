<?php
/* * ****************************************
  Module name : Footer admin
  Date created : 0th Oct 201210th Oct 2012
  Date last modified : 10th Oct 2012
  Author : Aditya
  Last modified by : Aditya
  Comments : This will show the amdin login form.
  Copyright : Copyright (C) 1999-2008 Vinove Software and Services (P) Ltd.
 * ***************************** */
require_once CLASSES_ADMIN_PATH . 'class_reports_bll.php';
$reports = new Reports;
$varFileName = basename($_SERVER['PHP_SELF']);
if ($varFileName == 'logout.php' || $varFileName == 'index.php' || $varFileName == 'forgot_password.php' || $varFileName == 'Thanks_forgot_password.php')
{
    $varImageName = 'powered_by_logo.png';
}
else
{
    $varImageName = 'powered_by_logo.png';
}
$varAltName = 'Powered By Vinove';
?>
<div style="text-align:center">
    <div>&copy; <?php echo date("Y") . ' ' . SITE_NAME; ?>. All rights reserved.</div>
    <div style="padding-top:10px;"></div>
</div>
<script type="text/javascript">
//    $(document).ready(function(){
        setTimeout(function(){
            $('.success,.error,.span12 .success,.span12 .error').hide();
        },15000);
//    });
   
</script>

<?php $reports->getLoader('page'); ?>