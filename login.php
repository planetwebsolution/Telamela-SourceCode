<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_CUSTOMER_WHOLESALER_LOGIN_CTRL;
$objCore = new Core();
//print_r($_REQUEST);
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo LOGIN_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>        
        <link rel="stylesheet" href="<?php echo JS_PATH ?>validation/validationEngine.jquery.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo JS_PATH ?>validation/template.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo CSS_PATH ?>colorbox.css" />          
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL ?>colorbox/jquery.colorbox.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>validation/jquery-1.7.2.min.js" ></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>validation/jquery.validationEngine-en.js" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>validation/jquery.validationEngine.js" charset="utf-8"></script>
        <script>
            jQuery(document).ready(function() {
                // binds form submission and fields to the validation engine
                jQuery("#frmUserLogin").validationEngine();

            });

            $(document).ready(function() {
                //Examples of how to assign the Colorbox event to elements


                $(".vimeo2").colorbox({iframe: true, innerWidth: 500, innerHeight: 200});

                //Example of preserving a JavaScript event for inline calls.
                $("#click").click(function() {
                    $('#click').css({"background-color": "#f00", "color": "#fff", "cursor": "inherit"}).text("<?php echo WINDOW_AGAIN; ?>");
                    return false;
                });


            });
        </script>

        <style>
            .signin input{border:1px solid #929291; color:#3F3E3E;height:28px;padding:5px;width:268px; }
            .signin label, .signin .checkbox span{color:#3F3E3E; float:left;
                                                  font:13px/18px 'OpenSansRegular',arial;
                                                  margin:10px 20px 0 0;
                                                  width:160px;}

            .signin .checkbox input{width:auto; float:left; height:auto }
            .signin .checkbox label{width:auto; margin-top: 0}
            .signin .checkbox span{width:auto; margin-top: 0}
            .signin .button{background:url("common/images/submit_btn.png") repeat-x scroll 0 0 #DB9919; margin-top:10px;
                            border:1px solid #B69B68;
                            color:#FFFFFF;
                            cursor:pointer;
                            float:left;
                            font:bold 16px/39px 'OpenSansBold',arial;
                            height:39px;
                            margin-right:10px;
                            padding:0;
                            width:105px;}
            .signin .forgot{color:#3F3E3E;
                            float:right;
                            font:13px/18px 'OpenSansRegular',arial;
                            margin:0; }

        </style>

    </head>



    <body>           
        <form name="frmUserLogin" id="frmUserLogin" method="post" class="signin" action="">
            <?php if ($objCore->displaySessMsg()) {
                ?>  
                <div style="text-align:center; width: 500px; color:red">
                    <?php
                    echo $objCore->displaySessMsg();

                    $objCore->setSuccessMsg('');
                    $objCore->setErrorMsg('');
                    ?>
                </div>
            <?php }
            ?>

            <table>

                <tr>
                    <td>
                        <div class="checkbox"><span><?php echo SEL; ?> :</span>              
                            <input type="radio" name="frmUserType" checked="true" value="customer" class="validate[required] radio"/><label class="username"><?php echo CUSTOMER; ?></label>
                            <?php if (!isset($_REQUEST['pid'])) { ?>
                                <input type="radio" name="frmUserType" value="wholesaler"/><label class="username"><?php echo WHOLESALER; ?> </label>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="username">
                            <span><?php echo EM_ID; ?> :</span>
                            <input id="frmUserEmail" name="frmUserEmail" value="" type="text" autocomplete="on" placeholder="Email Id" class="validate[required,custom[email]] text-input"/>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="password">
                            <span><?php echo PASSWORD; ?> :</span>
                            <input id="frmUserpassword" name="frmUserpassword" value="" type="password" placeholder="Password" class="validate[required] text-input" >
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="submit button" type="submit" value="Sign in" name="frmHidenAdd"/>
                        <p>
                            <a class="vimeo2 forgot" href="<?php echo $objCore->getUrl('forgot_password.php'); ?>" ><?php echo FORGOT_PASSWORD; ?></a>
                        </p>
                    </td>
                </tr>

            </table> 
        </form>
    </body>
</html>