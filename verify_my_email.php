<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_VERIFY_MY_EMAIL_CTRL;
$objCore = new Core();
//$vcode = $objGeneral->getEmailVerificationEncode('suraj.maurya@mail.vinove.com' . ',' . '5' . ',' . '2013-07-08 23:34:59');
//echo $VerificationUrl = $objCore->getUrl('verify_my_email.php', array('action' => md5('wholesaler'), 'vcode' => $vcode, 'ref' => 'checkout.php'));
$varRef = (isset($_REQUEST['ref'])) ? $_REQUEST['ref'] : 'index.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Verify my email</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script type="text/javascript">
            $(document).ready(function(){              
                // setTimeout(function(){ window.location.href="<?php echo $varRef; ?>" }, 15000);
            });
        </script>
    </head>
    <body>
         <div class="outer_wrapper">
            <div id="navBar">	<?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>
            <div class="header" style=" border:none">
                <div class="layout"> </div>
            </div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>
            <div id="ouderContainer" class="ouderContainer_1">
                <div class="layout">
                    <div class="header">
                    <?php
                    if ($objCore->displaySessMsg()) {
                        $objCore->setSuccessMsg('');
                        $objCore->setErrorMsg('');
                    }
                    ?>
                </div>
                <div class="add_pakage_outer">
                    <div class="top_container">
                        <h2>Email <span>Verification</span></h2>
                    </div>
                    <div class="body_inner_bg radius">
                        <div class="thans_sec">
                            <?php if ($_REQUEST['msg'] == 1) { ?>
                                <h1>Congratulations</h1>
                                <p align = "center"><strong>Thank you for verifying your email address.</strong></p>
                                <?php if($varRef=='checkout.php'){?>
                                <p align="center"><a href="<?php echo $objCore->getUrl($varRef); ?>">Click here to return your cart </a></p>
                                <?php }?>
                                <span><img src = "common/images/right_img.png" alt = ""/></span>
                            <?php }else if ($_REQUEST['msg'] == 2) { ?>
                                <h1>Opps !</h1>
                                <p align = "center"><strong class="red">Your email id has been already verified.</strong></p>
                                <?php if($varRef=='checkout.php'){?>
                                <p align="center"><a href="<?php echo $objCore->getUrl($varRef); ?>">Click here to return your cart </a></p>
                                <?php }?>                                
                            <?php } else {
                                ?>
                                <h1>Opps !</h1>
                                <p align="center"><strong class="red">Either you are using invalid verification url or your account has been deleted. </strong></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>

    </body>
</html>