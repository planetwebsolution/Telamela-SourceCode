<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_CUSTOMER_WHOLESALER_LOGIN_CTRL;
require_once CONTROLLERS_PATH . FILENAME_CUSTOMER_CTRL;

if (isset($_SESSION['sessUserInfo']['type']) && $_SESSION['sessUserInfo']['type'] == 'customer') {
    //header('location:order_detail_page.php');   
    header('location:run_time_shipping_address.php');
    die;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo CHECKOUT_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>		
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery("#existingCustomer").validationEngine();
                jQuery("#newCustomer").validationEngine({
                    'custom_error_messages': {                                    
                        'minSize': {
                            'message': "*Minimum 6 characters allowed"
                        }
                    }
                });
            });
        </script>
		<style>.formErrorContent{ margin-left:-138px;}
		.error{ line-height:30px; color:red}
		
		</style>
    </head>
    <body>
      <em>
            <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>
        </em>
        <div class="header"> </div>
        <?php include_once INC_PATH . 'header.inc.php'; ?>
        <div id="">
            <div class="layout">
		<div class="add_pakage_outer">
                          <div class="top_header border_bottom">
    <h1><?php echo CHECKOUT_TITLE; ?></h1>
   
</div>     
                    <div class="body_inner_bg radius"> <div>
                    
                    <?php
                    if ($objCore->displaySessMsg()) {
                        echo $objCore->displaySessMsg();
                        $objCore->setSuccessMsg('');
                        $objCore->setErrorMsg('');
                    }
                    ?>
                </div>
                        <div class="add_edit_pakage aapplication_form">
                            <div class="com_address_sec billing_sec">
                                <form id="existingCustomer" action="" method="post">
                                  <div class="quick_title"><span><?php echo EXIST_CUS; ?></span></div> 


                                    <ul class="left_sec">
                                        <li>
                                            <label><?php echo EMAIL; ?></label>
                                            <div class="input_star">
                                                <input type="text" name="frmUserEmail" id="frmUserEmail" value="<?php echo isset($_COOKIE['email_id']) ? $_COOKIE['email_id'] : ''; ?>" class="validate[required,custom[email]]" />
                                                <small class="star_icon" style="right:-1px"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo PASSWORD; ?></label>
                                            <div class="input_star">
                                                <input type="password" name="frmUserpassword" id="frmUserpassword" class="validate[required]" value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>"/>
                                                <small class="star_icon"  style="right:-1px"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="check_box">
                                                <input type="checkbox" name="remember_me" value="yes" class="styled" <?php echo isset($_COOKIE['remember_me']) ? "checked" : ''; ?>/><small><?php echo REMEMBER_ME; ?></small>
                                                <a class="jscallForgetPasswordBox forget" onclick="return jscallLoginBox('jscallForgetPasswordBox','1');" href="#forgetPassword"><?php echo FORGOT_PASSWORD; ?></a>                                                
                                            </div>
                                        </li>
                                        <li class="last">
                                            <span class="btn" style="width: auto; float:right; margin-left:21px;">
                                                <input type="hidden" name="frmUserType" value="customer" />
                                                <input type="hidden" name="frmRef" value="order" />
                                                <input type="submit" name="frmHidenAdd" value="Sign in" class="sign_btn submit3" style=" margin-top:9px; " />
                                            </span>


<!--                                            <p>
                                                <div id="idps" class="social_login_icons_checkout">
                                                    <div class="title"> <span>OR</span> <?php echo SI_IN ?> with </div>
													
                                                    <div class="img_1">
                                                     <i class="fa fa-google-plus idpico" idp="google" style="  border-radius: 3px;     padding: 10px; border:1px solid #eee"></i> 
                                                        <img class="idpico" idp="twitter" src="<?php echo IMAGE_FRONT_PATH_URL; ?>socialicons/twitter.png" title="twitter" />
                                                     <i class="fa fa-facebook idpico"  idp="facebook" style="  border-radius: 3px;  border:1px solid #eee ;   padding: 10px;"></i>  
													 <i class="fa fa-linkedin idpico" idp="linkedin" style="  border-radius: 3px;  border:1px solid #eee ;  padding: 10px;"></i>
                                                       
                                                    </div>
                                                </div>
                                            </p>-->
                                        </li>
                                    </ul>
                                </form>
                            </div>

                            <div class="com_address_sec billing_sec right1">
                                <form action="" id="newCustomer" method="post">
                                      <div class="quick_title"><span><?php echo NEW_CUS; ?></div>

                                    <ul class="left_sec">
                                        <li>
                                            <label><?php echo FIRST_NAME; ?></label>
                                            <div class="input_star"> 
                                                <input type="text" name="frmCustomerFirstName" id="frmCustomerFirstName" value="<?php echo $_POST['frmCustomerFirstName']; ?>" class="validate[required]"/>
                                                <small class="star_icon" style="right:-1px"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo LAST_NAME; ?> </label>
                                            <div class="input_star"> 
                                                <input type="text" name="frmCustomerLastName" id="frmCustomerLastName" value="<?php echo $_POST['frmCustomerLastName']; ?>" class="validate[required]"/>
                                                <small class="star_icon"  style="right:-1px"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo EMAIL; ?> </label>
                                            <div class="input_star"> 
                                                <input type="text" name="frmCustomerEmail" id="frmCustomerEmail" value="" class="validate[required,custom[email]]" />
                                                <small class="star_icon"  style="right:-1px"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo CONFIRM_EMAIL; ?> </label>
                                            <div class="input_star"> 
                                                <input type="text" name="frmCustomerConfirmEmail" id="frmCustomerConfirmEmail" value="" class="validate[required,equals[frmCustomerEmail]]" />
                                                <small class="star_icon"  style="right:-1px"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo PASSWORD; ?> </label>
                                            <div class="input_star"> 
                                                <input type="password" name="frmCustomerPassword" id="frmCustomerPassword" value="" class="validate[required,minSize[6]]" />
                                                <small class="star_icon"  style="right:-1px"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo CONFIRM_PASSWORD; ?> </label>
                                            <div class="input_star"> 
                                                <input type="password" name="frmCustomerConfirmPassword" id="frmCustomerConfirmPassword" value="" class="validate[required,equals[frmCustomerPassword]]" />
                                                <small class="star_icon"  style="right:-1px"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="last">
                                            <span class="btn" style="float:right">
                                                <input type="hidden" name="frmRef" value="shippingBilling" />
                                                <input type="hidden" name="frmHidenAdd" value="add" /> 
                                                <input type="submit" value="Continue" class="watch_link" style="float:right; margin-top:20px; margin-right:-16px"/>
                                            </span>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html> 