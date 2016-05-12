<?php
require_once '../common/config/config.inc.php';

if (isset($_GET['code']) && isset($_GET['mid'])) {
    $arrColumns = array('pkAdminID');
    $varWhereCondition = 'pkAdminID = \'' . $_GET['mid'] . '\' AND AdminForgotPWCode = \'' . $_GET['code'] . '\'';
    $arrMemberDetails = $objGeneral->getRecord(TABLE_ADMIN, $arrColumns, $varWhereCondition);
} else if ($_GET['op'] != 'result') {
    //if no GET parameters, we skip to the index page.
    header('location:index.php');
    exit;
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <!-- Apple devices fullscreen -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Apple devices fullscreen -->
        <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />

        <title><?php echo ADMIN_PANEL_NAME; ?> - Login</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>bootstrap.min.css">
        <!-- Bootstrap responsive -->
        <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>bootstrap-responsive.min.css">
        <!-- icheck -->
        <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>plugins/icheck/all.css">
        <!-- Theme CSS -->
        <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>style.css">
        <!-- Color CSS -->
        <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>themes.css">


        <!-- jQuery -->
        <script src="<?php echo ADMIN_JS_PATH; ?>jquery.min.js"></script>

        <!-- Nice Scroll -->
        <script src="<?php echo ADMIN_JS_PATH; ?>plugins/nicescroll/jquery.nicescroll.min.js"></script>
        <!-- Validation -->
        <script src="<?php echo ADMIN_JS_PATH; ?>plugins/validation/jquery.validate.min.js"></script>
        <script src="<?php echo ADMIN_JS_PATH; ?>plugins/validation/additional-methods.min.js"></script>
        <!-- icheck -->
        <script src="<?php echo ADMIN_JS_PATH; ?>plugins/icheck/jquery.icheck.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo ADMIN_JS_PATH; ?>bootstrap.min.js"></script>
        <script src="<?php echo ADMIN_JS_PATH; ?>eakroko.js"></script>
        <script type="text/javascript" src="<?php echo AJAX_JS; ?>"></script>
        <script type="text/javascript" src="<?php echo VALIDATE_JS; ?>"></script>
        <!--[if lte IE 9]>
                <script src="js/plugins/placeholder/jquery.placeholder.min.js"></script>
                <script>
                        $(document).ready(function() {
                                $('input, textarea').placeholder();
                        });
                </script>
        <![endif]-->


        <!-- Favicon -->
        <link rel="shortcut icon" href="img/favicon.ico" />
        <!-- Apple devices Homescreen icon -->
        <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-precomposed.png" />

    </head>
    <body class='login' onload="document.getElementById('frmAdminUserName').focus();">
        <div class="wrapper">
            <h1><a href="index.php"><img src="images/logo.png" alt="<?php echo SITE_NAME; ?>" title="<?php echo SITE_NAME; ?>" class='retina-ready'></a></h1>
            <div class="login-body">
                <?php
                if ($arrMemberDetails) {
                    ?>
                    <h2>Reset Password</h2>
                    <form action="reset_password_action.php" method="post" name="frm_login" id="frm_login" onsubmit="return validateAdminLogin('frm_login');" class="form-validate">
                        <div class="control-group text-danger">
                            <?php
                            if ($objCore->displaySessMsg()) {
                                echo $objCore->displaySessMsg();
                                $objCore->setSuccessMsg('');
                                $objCore->setErrorMsg('');
                            }
                            ?>
                        </div>
                        <div class="control-group">
                            <div class="email controls">
                                <input type="password" id="frmNewPassword" name="frmNewPassword" tabindex="1" placeholder="New Password" class='input-block-level' data-rule-required="true" autocomplete="off">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="pw controls">
                                <input type="password" name="frmConfirmNewPassword" id="frmConfirmNewPassword" tabindex="2" value="" placeholder="Confirm New Password" class='input-block-level' data-rule-required="true">
                            </div>
                            Password must contain only a-z, A-Z, 0-9, -, _, #, @ or ! characters.
                        </div>
                        <div>

                            <input type="hidden" name="frmCode" value="<?php echo $_GET['code']; ?>" />
                            <input type="hidden" name="frmMember" value="<?php echo $_GET['mid']; ?>" />
                            <input type="submit" name="btnResetPassword" value="Change Password"  tabindex="3" class='btn btn-primary'>
                        </div>
                    </form>
                    <br/>
                    <?php
                } else if ($_GET['op'] == 'result') {
                    ?>

                    <br/><br/>
                    <div class="control-group">
                        <div style="margin-left: 10px; color: green">
                            Your password has been reset successfully. You can now <a href="index.php">login</a> with your new password.
                        </div>
                    </div>
                    <br/><br/>
                    <?php
                } else {
                    ?>



                    <br/><br/>
                    <div class="control-group">
                        <div style="margin-left: 10px;" class="req">
                            The link for resetting your password is incorrect or it is expired. Kindly check the link you followed.
                        </div>
                    </div>
                    <br/><br/>
                    <?php
                }
                ?>
            </div>
        </div>
    </body>

</html>
