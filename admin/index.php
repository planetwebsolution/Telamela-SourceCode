<?php
/* * ****************************************
  Module name : index page admin
  Date created : 28th Feb 2008
  Date last modified : 28th Feb 2008
  Author : Sandeep Kumar
  Last modified by : Sandeep Kumar
  Comments : This will show the amdin login form.
  Copyright : Copyright (C) 1999-2008 Vinove Software and Services (P) Ltd.
 * ***************************** */
require_once '../common/config/config.inc.php';
if ($_SESSION['sessUser'] > 0) {
    header('location:dashboard_uil.php');
    exit();
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

                <h2>SIGN IN</h2>
                <form action="login_action.php" method="post" name="frm_login" id="frm_login" onsubmit="return validateAdminLogin('frm_login');" class="form-validate">
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
                            <input type="text" id="frmAdminUserName" name="frmAdminUserName" tabindex="1" value="<?php
                        if (isset($_COOKIE['AdminUserName'])) {
                            echo $_COOKIE['AdminUserName'];
                        }
                        ?>" onblur="checkUserName();"  placeholder="Email address" class='input-block-level' data-rule-required="true">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="pw controls">
                            <input type="password" name="frmAdminPassword" id="frmAdminPassword" tabindex="2" value="<?php
                                   if (isset($_COOKIE['AdminPassword'])) {
                                       echo $_COOKIE['AdminPassword'];
                                   }
                        ?>" placeholder="Password" class='input-block-level' data-rule-required="true">
                            
                        </div>
                    </div>
                    <script>
<?php /*
  $(document).ready(function() {
  // cache references to the input elements into variables
  var passwordField = $('input[name=frmAdminPassword]');

  // add a password placeholder field to the html
  passwordField.after('<input id="frmAdminPassword" type="text" value="Password" autocomplete="off" />');
  var passwordPlaceholder = $('#frmAdminPassword');

  // show the placeholder with the prompt text and hide the actual password field
  passwordPlaceholder.show();
  passwordField.hide();

  // when focus is placed on the placeholder hide the placeholder and show the actual password field
  passwordPlaceholder.focus(function() {
  passwordPlaceholder.hide();
  passwordField.show();
  passwordField.focus();
  });
  // and vice versa: hide the actual password field if no password has yet been entered
  passwordField.blur(function() {
  if(passwordField.val() == '') {
  passwordPlaceholder.show();
  passwordField.hide();
  }
  });
  });
 */


?>            
                    </script>
                    <div class="submit">
                        <div class="remember">
                            <input type="checkbox" name="remember" <?php
if (isset($_COOKIE['remember'])) {
    echo "checked";
}
?> class='icheck-me' data-skin="square" data-color="blue" id="remember"> <label for="remember">Remember me</label>
                        </div>
                        <input type="hidden" name="action" value="login" />
                        <input type="submit" value="SIGN IN" class='btn btn-primary'>
                    </div>
                </form>
                <div class="forget">
                    <a href="forgot_password.php" ><span class="linkHover">Forgot password?</span></a>
                </div>
            </div>
        </div>
    </body>
     <style>
        .linkHover:hover{
            text-decoration:underline;
        }
    </style>
</html>
