<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_ACNT_CTRL;
//pre($_SESSION['sessUserInfo']);
//echo '<pre>';
//print_r($_SESSION['sessUserInfo']);die;
//echo $_SESSION['sessUserInfo']['email']; die;
//print_r($objpage[arrMonthShort); die;
//echo $objpage['arrWholesalerDeatails']->CompanyEmail; die;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo EDIT_PASSWORD_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                // binds form submission and fields to the validation engine
                jQuery("#frmWholesalerRegistration").validationEngine({
                    'custom_error_messages': {
                        'minSize': {
                            'message': "*Minimum 6 characters allowed"
                        },
                        'equals': {
                            'message': "New Passwords must be same"
                        }
                    }
                });

                $('.drop_down1').sSelect();
                $('.cancel').click(function() {
                    window.location.href = '<?php echo $objCore->getUrl('dashboard_wholesaler_account.php'); ?>';

                });
            });
            
            
            function errorMessageRefferLink() {
                var errMsg = '* Required field';
                return '<div style="opacity: 0.87; position: absolute; top: 101px; left: 425px;" class="formError"><div class="formErrorContent">' + errMsg + '<br/></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>';
            }
        </script>
        <style>
            /*.input_star .star_icon{ right:9px;}*/
            .com_address_sec h3{ background:none}
            .add_edit_pakage label{width:100%; margin-bottom:5px;}
            .input_star input{box-sizing:border-box; height:37px; width:455px; border: 1px solid #d9d9d9; padding:8px;}
            .btn_wrap input,.btn_wrap button{margin-top:10px;}
			/*29/7/15D*/
			.w_left_sec{width:55%;}
            @media screen and (max-width:1140px){
                .input_star .star_icon{ right:1px;}
            }


        </style>
    </head>
    <body>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout">

            </div>
        </div><?php include_once INC_PATH . 'header.inc.php'; ?>

        <div id="ouderContainer" class="ouderContainer_1">
            <?php
            if ($_SESSION['sessUserInfo']['type'] == 'wholesaler') {
                ?>

            <?php } ?>
            <div class="layout">

                <div class="add_pakage_outer">
                    <div class="top_header border_bottom">
                        <h1><?php echo CHANGE; ?> <?php echo MY_PASS; ?></h1>
                    </div>

                    <div class="body_inner_bg radius">

                        <div class="add_edit_pakage aapplication_form" style=" padding-top:0px;">
                            <form name="frmCustomerRegistration" id="frmCustomerRegistration" method="post">
                                <input type="hidden" value="<?php echo $_SESSION['sessUserInfo']['email'];?>" name="wid" id="wid" />
                                <div class="com_address_sec edit_acc">
                                                                 <?php
                                    if ($objCore->displaySessMsg()) {
                                        ?>
                                        <div class="req_field" style="text-align:center; width: 100%">
                                        <?php
                                        echo $objCore->displaySessMsg();

                                        $objCore->setSuccessMsg('');
                                        $objCore->setErrorMsg('');
                                        ?>
                                        </div>
                                        <?php }
                                        ?>
                                    <ul class="left_sec editpass w_left_sec" >
                                        <small class="req_field" style="float:left!important;"> * Fields are required
                                        </small>
                                        <li>
                                            <label><?php echo CUR_PASS; ?>:</label>
                                            <div id="passError"><span style="color:red;font-size:12px;"></span></div>
											
											<div class="input_star">
                                               
                                                <input tabindex="5" type="password" value="" name="frmCurrentWholesalerPassword" id="frmCurrentWholesalerPassword"  class="validate[required] text-input" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo NEW_PASS; ?>:</label>
                                            <div class="input_star">
                                                <input tabindex="5" type="password" value="" name="frmNewWholesalerPassword" id="frmNewWholesalerPassword" class="validate[required,minSize[6]] text-input" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo CON_NEW_PASS; ?>:</label>
                                            <div class="input_star">
                                                <input tabindex="5" type="password" value="" name="frmConfirmNewWholesalerPassword" id="frmConfirmNewWholesalerPassword"  class="validate[required,equals[frmNewWholesalerPassword]] text-input" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                    </ul>
                                    <div style="clear:both; margin-top:10px;"></div>
                                    <div class="btn_wrap">
                                        <input type="submit"  name="frmHidenWholesalerPasswordEdit" value="<?php echo UPDATE; ?>" class="submit3" style="cursor:pointer"/>

                                        <button class="cancel" style="width: 124px;" value="<?php echo CANCEL; ?>" type="button" name="frmCancel"><?php echo CANCEL; ?></button>

                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php 

//print_r($_POST['frmHidenWholesalerPasswordEdit']);
include_once 'common/inc/footer.inc.php'; 

?>
    </body>
</html>