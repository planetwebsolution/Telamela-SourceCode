<?php
require_once SOURCE_ROOT . 'classes/class_shopping_cart_bll.php';
require_once SOURCE_ROOT . 'classes/class_customer_user_bll.php';
require_once SOURCE_ROOT . 'classes/class_home_bll.php';
//pre($_SESSION);
$objCore = new Core();

$arrCurrencyList = $objCore->currencyList();
$arrCurrencyListNew = $objCore->currencyListNew();
//Fatch Cart data here
$varCartDetailsForHeader = new ShoppingCart();
$cartD = $varCartDetailsForHeader->myCartDetails();

//Fatch Recently viewed data here
$objHome = new Home();
$arrTodayOffer = $objHome->getTodayOfferProduct();
$arrRecentViewData = $objHome->RecentlyViewedProducts($arrTodayOffer['offer_details']['0']['fkProductId']);
//pre($arrRecentViewData);
//Fatch Saved List data here
$cid = $_SESSION['sessUserInfo']['id'];
if (!empty($cid))
{
    $objCustomer = new Customer();
    $arrSavedList = $objCustomer->getWishlistProducts($cid);
    //Fetch Customer Reward points
    $objcustomer = new Customer();
    $argWhere = "pkCustomerID='" . $cid . "' ";
    $arrCustomerRewards = $objCustomer->select(TABLE_CUSTOMER, array('BalancedRewardPoints'), $argWhere);
}
?>
<!--Include the right side menu-->
<?php
if ($_SESSION['sessUserInfo']['type'] != 'wholesaler')
{
    include_once INC_PATH . 'right-side-menu.inc.php';
}
?>
<!--Right side menu ends here-->
<div class="topBar">
    <div class="layout">
        <div class="navBlock">
            <div class="navRight <?php echo ($_SESSION['sessUserInfo']['email'] != '' && $_SESSION['sessUserInfo']['id'] != "") ? 'navRightAfterLogin' : '' ?>">
                <?php
                if ($_SESSION['sessUserInfo']['type'] != 'wholesaler')
                {
                    ?>
                    <div class="myCart">
                        <div  class="cart-btn2"> <a href ="<?php
                if ($cartD['Common']['CartCount'] > 0)
                {
                    echo $objCore->getUrl('shopping_cart.php');
                }
                else
                {
                    echo "javascript:void(0)";
                }
                    ?>"  <?php
                if ($cartD['Common']['CartCount'] > 0)
                {
                    echo "style='cursor:pointer'";
                }
                else
                {
                    echo "style='cursor:default'";
                }
                    ?> class="cart"><span class="mycart_txt"><?php echo MY_CART; ?></span> <span id="cartValue" <?php echo ($cartD['Common']['CartCount'] == 0) ? 'style="background-color:gray"' : ''; ?>><strong><?php echo (int) $cartD['Common']['CartCount']; ?></strong> <?php echo ($cartD['Common']['CartCount'] == 1 || $cartD['Common']['CartCount'] == 0) ? 'Item' : 'Items'; ?></span> </a> </div>
                        <!--Cart drop down -->
                    </div>
                    <?php
                }
                else
                {
                    ?>
                    <div class="myCart">
                        <div  class="cart-btn2"> <a href ="javascript:void(0)" class="cart" style="cursor:default;"><span class="mycart_txt"><?php echo MY_CART; ?></span> <span id="cartValue" style="background-color:gray" ><strong>Not</strong> allow</span> </a> </div>
                        <!--Cart drop down -->
                    </div>
                    <?php
                }
                ?>

                <div class="rightTop">
                    <div class="Currency Currency_3">
                       
                        <select id="countries" onchange="changeCurrency(this.value);" onlick="hideLanguage()">
                            <option><?php echo CURRENCY; ?></option>
                            <?php
                            
                            foreach ($arrCurrencyListNew as $ck => $cv)
                            {
                                $cselected = ($_SESSION['SiteCurrencyCode'] == $ck) ? 'selected="selected"' : '';
                                echo '<option value="' . $ck . '" data-image="' . IMAGE_FRONT_PATH_URL . 'blank.gif" data-imagecss="flag ' . $cv[2] . '" data-title="' . $ck . ' ' . $cv[1] . '" ' . $cselected . '>' . $ck . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <!--                    <div class="language" style=""> <span id="ldr"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>zoomloader.gif"/></span>
    <script src="http://microsofttranslator.com/ajax/v3/widgetv3.ashx" type="text/javascript"></script>
    <script type="text/javascript">
        document.onreadystatechange = function () {
            if (document.readyState == 'complete') { Microsoft.Translator.Widget.Translate('en', 'en', null, null, null, null, 2000);}
        }
    </script>
</div>--> 
                </div>
                <ul class="mytelamela">
                    <li>
                        <?php
                        // print_r($_SESSION['sessUserInfo']);
                        if ($_SESSION['sessUserInfo']['email'] != '' && $_SESSION['sessUserInfo']['id'] != "" && $_SESSION['sessUserInfo']['type'] == 'customer')
                        {
                            ?>
                            <a href="<?php echo $objCore->getUrl('dashboard_customer_account.php') ?>" id="classACusNew"><?php echo $_SESSION['sessUserInfo']['screenName'] != '' ? substr($_SESSION['sessUserInfo']['screenName'], 0, 15) : substr($objCore->getCusName($_SESSION['sessUserInfo']['id']), 0, 15); ?><span class="classBCusNew supportCustomerNew"></a>
                            <?php
                        }
                        else if ($_SESSION['sessUserInfo']['email'] != '' && $_SESSION['sessUserInfo']['id'] != "" && $_SESSION['sessUserInfo']['type'] == 'wholesaler')
                        {
                            ?>
                            <a href="<?php echo $objCore->getUrl('dashboard_wholesaler_account.php') ?>"><?php echo MY_AC; ?></a>
                            <?php
                        }
                        else
                        {
                            ?>
                            <a href="#">My Telamela</a>
                        <?php } ?>
                        <ul class="drop_down">
                            <?php
                            if (isset($_SESSION['sessUserInfo']['type']))
                            {
                                if ($_SESSION['sessUserInfo']['type'] == 'customer')
                                {
                                    $notify = json_decode($objCore->getNotification($_SESSION['sessUserInfo']['type'], $_SESSION['sessUserInfo']['id']));
                                    $order = $objCore->getCustomerOder();
                                    $savedItem = $objCore->getCustomerSavedItems();
                                    ?>
                                    <li><a href="<?php echo $objCore->getUrl('my_rewards.php'); ?>">My Rewards</a></li>
                                    <li class="link1 send_gift_card"><a href="#"><?php echo SEND_GIFT; ?></a></li>
                                    <li><a href="<?php echo $objCore->getUrl('dashboard_customer_account.php') ?>"> <?php echo 'Dashboard'; ?></a></li>
                                    <!--<li><a href="<?php echo $objCore->getUrl('my_rewards.php') ?>"> <?php echo MY_REWARDS; ?></a></li>-->
                                    <li><a id="classACus" href="<?php echo $objCore->getUrl('my_orders.php') ?>"> <?php echo MY_OR; ?><span class="classBCus supportCustomer">
                                                <?php if ($order > 0) echo '(' . $order . ')'; ?>
                                            </span></a></li>
                                    <li><a id="classACus" href="<?php echo $objCore->getUrl('my_wishlist.php') ?>"> <?php echo MY_WISH; ?><span class="classBCus supportCustomer">
                                                <?php if ($savedItem > 0) echo '(' . $savedItem . ')'; ?>
                                            </span></a></li>
                                    <li><a href="<?php echo $objCore->getUrl('messages_inbox.php', array('place' => 'inbox')) ?>" id="classACus"><?php echo SUPP; ?><span class="classBCus supportCustomer">
                                                <?php if ($notify->customerSupport > 0) echo '(' . $notify->customerSupport . ')'; ?>
                                            </span></a></li>
                                    <?php
                                }
                                else if ($_SESSION['sessUserInfo']['type'] == 'wholesaler')
                                {
                                    ?>
                                    <!--<li><a href="javascript:void(0);" onclick="document.getElementById('mce-EMAIL').focus();"><?php echo SUBSCRIBE; ?></a></li>-->
                                    <!--<li><a href="<?php echo $objCore->getUrl('dashboard_wholesaler_account.php') ?>"><?php echo MY_AC; ?></a></li>-->
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <li><a href="<?php echo $objCore->getUrl('rewards.php'); ?>">My Rewards</a></li>
                            <?php } ?>
                            <li><a href="<?php echo SITE_ROOT_URL ?>products/new"><?php echo WH_NEW; ?></a></li>
                        </ul>
                    </li>
                </ul>
                <?php
                //echo $_SESSION['sessUserInfo']['email'].'..test'; 
                if ($_SESSION['sessUserInfo']['email'] != '' && $_SESSION['sessUserInfo']['id'] != "")
                {
                    ?>
                    <ul class="loginBlock">
                        <li class="signOut"><a href="<?php echo $objCore->getUrl('logout.php') ?>"><span><?php echo SI_OUT; ?></span></a></li>
                    </ul>
                    <?php
                }
                else
                {
                    ?>
                    <ul class="loginBlock">
                        <li><a href="#loginBox" onclick="return jscallLoginBox('jscallLoginBox');" class="jscallLoginBox"><?php echo LOGIN; ?></a> </li>
                        <li class="signUp"><a href="#NewSignupBox" onclick="return jscallLoginBox('jscallNewSignupBox');" class="jscallNewSignupBox"><?php echo SIGN_UP; ?></a></li>
                    </ul>
                <?php } ?>

                <!-- Login Box Start-->
                <div style="display: none;">
                    <div id="loginBox">
                        <div class="login_box">
                            <div class="login_inner">
                                <div class="heading">
                                    <h3><?php echo SI_IN; ?></h3>
                                    <div class="loginborder_bar"></div>
                                    <div class="signup"> <a href="#NewSignupBox" onclick="return jscallLoginBox('jscallNewSignupBox');" class="jscallNewSignupBox"><?php echo SIGN_UP; ?></a> </div>
                                </div>
                                <div class="red" id="LoginErrorMsg"></div>
                                <div class="out_btn">
                                    <div class="radio_btn">
                                        <input type="radio" name="frmUserTypeLn" value="customer" u="<?php echo isset($_COOKIE['email_id']) ? $_COOKIE['email_id'] : ''; ?>" p="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>" class="styled" checked="checked" />
                                        <small><?php echo CUSTOMER; ?></small> </div>
                                    <div class="radio_btn" id="wholesalerRadio">
                                        <input type="radio" name="frmUserTypeLn" value="wholesaler" u="<?php echo isset($_COOKIE['wemail_id']) ? $_COOKIE['wemail_id'] : ''; ?>" p="<?php echo isset($_COOKIE['wpassword']) ? $_COOKIE['wpassword'] : ''; ?>"  class="styled"/>
                                        <small><?php echo WHOLESALER; ?></small> </div>
                                </div>
                                <div class="form">
                                    <?php
                                    if($_COOKIE['email_id']!=''){
                                    ?>
                                    <label class="username">
                                        <span><?php echo EM_ID; ?> :</span>
                                        <input type="text" placeholder="Email Id" autocomplete="off" value="<?php echo isset($_COOKIE['email_id']) ? $_COOKIE['email_id'] : ''; ?>" name="frmUserEmailLn" id="frmUserEmailLn" onKeyup="Javascript: if (event.keyCode==13) loginAction();">
                                        <div class="frmUserEmailLn"></div>
                                    </label>
                                    <label class="password">
                                        <span><?php echo PASSWORD; ?> :</span>
                                        <input type="password" placeholder="Password" value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>" autocomplete="off" name="frmUserPasswordLn" id="frmUserPasswordLn" onKeyup="Javascript: if (event.keyCode==13) loginAction();">
                                        <div class="frmUserPasswordLn"></div>
                                    </label>
                                    <div class="simpleBox paddtop20">
									<div class="password"> <span>&nbsp;</span>
                                        <div class="check_box" style="width: 180px;
                                             float: left; ">
                                            <input type="checkbox" name="remember_me" value="yes" class="styled" <?php echo isset($_COOKIE['email_id']) ? "checked='checked'" : ''; ?>/>
                                            <small><?php echo REMEMBER_ME; ?></small> </div>
                                        <div> <a href="#forgetPassword" onclick="return jscallLoginBox('jscallForgetPasswordBox','1');" class="jscallForgetPasswordBox "><?php echo FORGOT_PASSWORD; ?></a> </div>
                                    </div>
				</div>
                                    <?php }else if($_COOKIE['wemail_id']!=''){ ?>
                                    <label class="username">
                                        <span><?php echo EM_ID; ?> :</span>
                                        <input type="text" placeholder="Email Id" autocomplete="off" value="<?php echo isset($_COOKIE['wemail_id']) ? $_COOKIE['wemail_id'] : ''; ?>" name="frmUserEmailLn" id="frmUserEmailLn" onKeyup="Javascript: if (event.keyCode==13) loginAction();">
                                        <div class="frmUserEmailLn"></div>
                                    </label>
                                    <label class="password">
                                        <span><?php echo PASSWORD; ?> :</span>
                                        <input type="password" placeholder="Password" value="<?php echo isset($_COOKIE['wpassword']) ? $_COOKIE['wpassword'] : ''; ?>" autocomplete="off" name="frmUserPasswordLn" id="frmUserPasswordLn" onKeyup="Javascript: if (event.keyCode==13) loginAction();">
                                        <div class="frmUserPasswordLn"></div>
                                    </label>
                                    <div class="simpleBox paddtop20">
									<div class="password"> <span>&nbsp;</span>
                                        <div class="check_box" style="width: 180px;
                                             float: left; ">
                                            <input type="checkbox" name="remember_me" value="yes" class="styled" <?php echo isset($_COOKIE['wemail_id']) ? "checked='checked'" : ''; ?>/>
                                            <small><?php echo REMEMBER_ME; ?></small> </div>
                                        <div> <a href="#forgetPassword" onclick="return jscallLoginBox('jscallForgetPasswordBox','1');" class="jscallForgetPasswordBox "><?php echo FORGOT_PASSWORD; ?></a> </div>
                                    </div>
				</div>
                                    <?php } else{ ?>
                                    <label class="username">
                                        <span><?php echo EM_ID; ?> :</span>
                                        <input type="text" placeholder="Email Id" autocomplete="off" value="<?php echo isset($_COOKIE['email_id']) ? $_COOKIE['email_id'] : ''; ?>" name="frmUserEmailLn" id="frmUserEmailLn" onKeyup="Javascript: if (event.keyCode==13) loginAction();">
                                        <div class="frmUserEmailLn"></div>
                                    </label>
                                    <label class="password">
                                        <span><?php echo PASSWORD; ?> :</span>
                                        <input type="password" placeholder="Password" value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>" autocomplete="off" name="frmUserPasswordLn" id="frmUserPasswordLn" onKeyup="Javascript: if (event.keyCode==13) loginAction();">
                                        <div class="frmUserPasswordLn"></div>
                                    </label>
                                    <div class="simpleBox paddtop20">
									<div class="password"> <span>&nbsp;</span>
                                        <div class="check_box" style="width: 180px;
                                             float: left; ">
                                            <input type="checkbox" name="remember_me" value="yes" class="styled" <?php echo isset($_COOKIE['email_id']) ? "checked" : ''; ?>/>
                                            <small><?php echo REMEMBER_ME; ?></small> </div>
                                        <div> <a href="#forgetPassword" onclick="return jscallLoginBox('jscallForgetPasswordBox','1');" class="jscallForgetPasswordBox "><?php echo FORGOT_PASSWORD; ?></a> </div>
                                    </div>
				</div>
                                    <?php } ?>

					<div id="idps" class="social_login_icons">
                                        <span><h3>OR</h3> <?php echo SI_IN ?> with </span>
                                        <img class="idpico" idp="google" src="<?php echo IMAGE_FRONT_PATH_URL; ?>socialicons/google.png" title="google" />
<!--                                                <img class="idpico" idp="twitter" src="<?php echo IMAGE_FRONT_PATH_URL; ?>socialicons/twitter.png" title="twitter" />-->
                                        <img class="idpico" idp="facebook" src="<?php echo IMAGE_FRONT_PATH_URL; ?>socialicons/facebook.png" title="facebook" />
                                        <img class="idpico" idp="linkedin" src="<?php echo IMAGE_FRONT_PATH_URL; ?>socialicons/linkedin.png" title="linkedin" />
                                       </div>
                                    <div style="float:right;  width:200px"> <input type="button" onclick="loginAction()" name="frmHidenAdd" value="Sign In" class="submit3" style=" float: right;
                                                                                   margin-right: 56px;"></div>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Login Box End-->
                <!-- forget password start-->
                <div style="display: none;">
                    <div id="forgetPassword">
                        <div class="login_box">
                            <div class="login_inner" style="height:190px;">
                                <div class="heading">
                                    <h3><?php echo FORGOT_PASSWORD; ?></h3>
                                    <div class="loginborder_bar" style="width:258px;"></div>
                                    <div class="signup"> <a href="#NewSignupBox" onclick="return jscallLoginBox('jscallNewSignupBox');" class="jscallNewSignupBox"><?php echo NEW_U_SI; ?></a> </div>
                                </div>
                                <div class="out_btn" style="width:384px;">
                                    <div class="radio_btn">
                                        <input type="radio" name="frmUserTypeFp" value="customer" class="styled" checked="checked" />
                                        <small><?php echo CUSTOMER; ?></small> </div>
                                    <div class="radio_btn">
                                        <input type="radio" name="frmUserTypeFp" value="wholesaler" class="styled"/>
                                        <small><?php echo WHOLESALER; ?></small> </div>
                                </div>
                                <div class="form forget_password">
                                    <label class="username">
                                        <span><?php echo EM_ID; ?> :</span>
                                        <input type="text" placeholder="Email Id" autocomplete="off" value="" name="frmUserEmailFp" id="frmUserEmailFp" onKeyup="Javascript: if (event.keyCode==13) forgetPasswordAction();">
                                        <div class="alert_1">Please enter your email id.We will send you an email with link to reset password.</div>
                                        <div class="successForgotPass" style="clear: both;color: green;margin-left: 93px;margin-top: 0px;display:none;"><?php echo FRONT_END_FORGET_PASSWORD_SUCCESS_MSG; ?></div>
                                        <div class="red" id="ForgetPasswordErrorMsg" style="display:none;margin-left: 61px;margin-top:0px;"><?php echo FRONT_END_FORGET_PASSWORD_ERROR_MSG; ?></div>
                                        <div class="frmUserEmailFp"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="forget_pass">
                            <input type="button" onclick="forgetPasswordAction()" name="frmHidenAdd" value="Send" class="watch_link"  style="height: 46px;margin-right: 16px;" >
                            <a href="#loginBox" onclick="return jscallLoginBox('jscallLoginBox');" class="jscallLoginBox cart_link" style="height: 46px;width: 76px;"><?php echo SI_IN; ?></a> </div>
                    </div>
                </div>
                <!-- forget password end -->


                <!-- sign up start-->
                <div style="display: none;">
                    <div id="NewSignupBox">
                        <div class="login_box">
                            <div class="login_inner">
                                <div class="heading">
                                    <h3><?php echo NEW_U_SI; ?></h3>
                                    <div class="signinborder_bar"></div>
                                    <div class="signup"> <a href="#loginBox" onclick="return jscallLoginBox('jscallLoginBox');" class="jscallLoginBox"><?php echo SI_IN; ?></a> </div>
                                </div>
                                <div class="form">
                                    <div class="text_light"><?php echo CHOOSE_FOLLOWING; ?>:</div>
                                    <p>
                                        <input type="button" onclick="window.location='<?php echo $objCore->getUrl('registration_customer.php', array('type' => 'add')) ?>'" value="Customer" class="watch_link  " style="height: 46px; margin-right: 16px; width: 150px;">
                                        <input type="button" onclick="window.location='<?php echo $objCore->getUrl('application_form_wholesaler.php') ?>'"  name="frmHidenAdd" value="Wholesaler" class="cart_link" style=" height: 47px;min-width: 161px">
                                    </p>
                                    <div style="clear:both;"></div>
                                    <div class="signup_selector_instruction">* <?php echo WHOLESALER_BUTTON; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- sign up end-->

            </div>
        </div>
    </div>
</div>
<div class="pop_up_sec">
    <form name="frmGiftCard" id="frmGiftCard" onsubmit="sendToGiftCard(this);return false;">
        <div class="pop_up_left"> <span><img alt="" src="<?php echo IMAGE_FRONT_PATH_URL; ?>gift-icon.png"></span> <strong><?php echo MAIL_DEL; ?>:</strong>
            <div class="calender_sec">
                <input type="hidden" style="z-index: 33; background:transparent;" id="giftCardCalender" name="giftCardCalender"/>
                <input type="text" style="visibility:hidden;" class="validate[required] text-input" value="" id="dateRequiredValidation" name="dateRequiredValidation">
                <span id="defaultInline" class="inlinePicker"></span> </div>
        </div>
        <div class="pop_up_right">
            <h3><?php echo EM_GIFT_CARD; ?></h3>
            <ul class="popup_form">
                <li>
                    <div class="input_sec" style="padding-top: 12px;font-size:11px;color:blue;float:right">1 USD=<?php echo $objCore->getPrice(1, 2) ?></div>
                    <input type="text"  name="frmGiftCardAmount" placeholder="Enter Amount in USD" numericonly="yes" class="validate[required,custom[number],min[1],maxSize[5]] text-input">
                </li>
                <li>
                    <input type="text" name="frmGiftCardFromName" placeholder="From Name"  class="validate[required] text-input">
                </li>
                <li>
                    <input type="text" name="frmGiftCardToName" placeholder="To Name"  class="validate[required] text-input">
                </li>
                <li>
                    <input type="text" name="frmGiftCardToEmail" placeholder="To Email"  class="validate[required,custom[email]] text-input">
                </li>
                <li>
                    <span style="color:red;font-size:12px">Only 100 characters allowed.</span>
                    <textarea maxlength="100" rows="5" cols="5" name="frmGiftCardMessage" placeholder="Message"  class="validate[required,maxSize[100]] text-area"></textarea>
                </li>
                <li>
                    <input type="text" placeholder="Qty" name="frmGiftCardQty" numericonly="yes" class="validate[required,custom[onlyNumberSp],maxSize[3]] text-input small-text">
                    <input type="hidden" name="frmGiftCardPage" value="<?php echo basename($_SERVER['PHP_SELF']); ?>"/>
                    <input type="submit" value="Add to Cart" id="addGiftCard">
                </li>
            </ul>
        </div>
    </form>
    <a class="popup-cross gift_card_close"><img alt="" src="<?php echo IMAGE_FRONT_PATH_URL; ?>login_cross.png"></a> </div>
<div class="popups" id="popupAddToCart">
    <div class="addtocart"></div>
    <a href="javascript:void(0);" class="cross"></a> </div>
<div id="fancybox-overlay" style="cursor: pointer; opacity: 0.9;"></div>
