<?php
require_once 'common/config/config.inc.php';
require_once CLASSES_PATH . 'class_order_process_bll.php';

if (isset($_SESSION['MyCart'])){
    unset($_SESSION['MyCart']);
}
 $_SESSION['MyCart']=array();
//pre($_SESSION['MyCart']);
$objOrderProcess = new OrderProcess();

$shippedDays = $objOrderProcess->getMaxShippedDays($_SESSION['sessUserInfo']['id']);
$shippedDays = (int) $shippedDays;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thanks for Payment</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>		
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script type="text/javascript">
            $(document).ready(function(){ 
                $('.drop_down1').sSelect();
            });
        </script>
    </head>
    <body>
        <div id="navBar">
            <?php include_once 'common/inc/top-header.inc.php'; ?>
        </div>
        <div class="header"><div class="layout">
               
        </div>
       </div><?php include_once INC_PATH . 'header.inc.php'; ?>
        <div id="ouderContainer" class="ouderContainer_1">
            <div class="layout">
                

                <div class="add_pakage_outer">
                       <div class="top_header border_bottom">
    <h1>Thank You</h1>
   
</div>            
                    <div class="body_inner_bg radius">
                        <div class="thans_sec">
                            <h1>Congratulations</h1>
                            <p><strong>Thank you for purchasing the gift card .</strong></p>
<!--                            <p style="font-weight: bold;">Your order will be shipped in <?php echo ($shippedDays > 0) ? $shippedDays : 2; ?> days.</p>-->
                            <span style="padding-top: 43px"><img src="common/images/right_img.png" alt=""/></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php';
       
        ?>

    </body>
</html> 
