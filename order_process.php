<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_ORDERPROCESSS_CTRL;

if (isset($_SESSION['sessUserInfo']['id']) && isset($_POST['PayByGiftCard'])) {
    $CustomerID = $_SESSION['sessUserInfo']['id'];
    $objPage = new OrderProcessPageCtrl();
    $txnID = 'GIFT'.  strtoupper(uniqid());
    $paymentAmount = 0.00;
    $objPage->pageLoad($CustomerID,$txnID,$paymentAmount);
    header('location:' . SITE_ROOT_URL . 'payment_success.php');
} else {
    header('location:' + SITE_ROOT_URL);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Order Process</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>		
        <link rel="stylesheet" type="text/css" href="common/css/layout.css"/>  
        <link rel="stylesheet" type="text/css" href="common/css/fonts.css"/>
        <link rel="stylesheet" href="common/js/validation/template.css" type="text/css"/>
    </head>
    <body>
        <div style="text-align: center; font-size: 16px; margin-top: 100px;">
            Please wait your order is processing................
        </div>
    </body>
</html> 
