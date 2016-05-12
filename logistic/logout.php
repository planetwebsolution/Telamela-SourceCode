<?php
require_once '../common/config/config.inc.php';

$objAdminlogisticLogin=new AdminLogistic();
//$objAdminlogisticLogin = new doAdminLogin();
$objAdminlogisticLogin->doAdminLogout();
//pre("here");
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
        <link rel="shortcut icon" href="../admin/img/favicon.ico" />
        <!-- Apple devices Homescreen icon -->
        <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-precomposed.png" />

    </head>
    <body class='login' onload="document.getElementById('frmAdminUserName').focus();">
        <div class="wrapper">            
            <h1><a href="index.php"><img src="../admin/images/logo.png" alt="<?php echo SITE_NAME; ?>" title="<?php echo SITE_NAME; ?>" class='retina-ready'></a></h1>
            <div class="login-body">
                <br/><br/>
                <div class="control-group">                    
                    <div style="margin-left: 10px">
                        You have been successfully logged out.&nbsp;  <a href="index.php">Click here</a>&nbsp; to login again.
                    </div>                    
                </div>
                <br/><br/>
            </div>
        </div>
    </body>

</html>
