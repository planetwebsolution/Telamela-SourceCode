<?php
require_once SOURCE_ROOT . 'classes/class_shopping_cart_bll.php';
$varCartDetailsForHeader = new ShoppingCart();
$cartD = $varCartDetailsForHeader->myCartDetails();
?>
<style>
    #classACus,#classACusNew{
        position: relative;
    }
    #classACus .classBCus{
        position: absolute;
        right: -18px;
        font-weight:bold;
        color: red;
    }
    #classACusNew .classBCusNew{
        position: absolute;
        right: -18px;
        font-weight:bold;
        color: red;
        top:9px;
    }
    .jspContainer{
        width:auto !important;
    }
    .editMyOneCartData{
        display: none;
    }
    .deleteMyOneCartData{
        display: none;
    }
    .noCartHeaderValue{
        background:#eee; color:#000; text-align:center;    color: #000;
    display: block;
    padding: 20px;
    text-align: center;
   


    }
	.fa-frown-o:before{ padding:20px; font-size:60px; color:#CCC}

</style>
<script type="text/javascript">
    $(function(){
        $('.scroll-pane').jScrollPane();

    });
</script> 

<div class="topBar">
    <div class="layout">
        <div class="navBlock">
            <div class="navRight">
                <div class="myCart">

                   <div  class="cart-btn2"> <a href ="#" class="cart"><?php echo MY_CART; ?></a>
                    <span class="cartValue" id="cartValue"><?php echo (int) $cartD['Common']['CartCount']; ?></span></div>
                    <!--Cart drop down -->
                    <div class="cart_div"  style="display:none;">
                        <h5 class="added_items">Added Items</h5>

                        <?php if ($cartD['Common']['CartCount'] > 0) { ?>
                            <div class="scroll-pane">
                                <div class="cart_complete">
                                    <?php
                                    $varCartSubTotal = 0;
                                    $varCartTotal = 0;
                                    $varDiscountCoupon = 0;
                                    $i = 0;
                                    foreach ($cartD['Product'] as $kCart => $vCart) {
                                        $varCartSubTotal = $_SESSION['MyCart']['Product'][$vCart['pkProductID']][$kCart]['qty'] * $vCart['FinalPrice'];
                                        ?>
                                        <div class="cart_row RemoveFromCart<?php echo $i; ?>">
                                            <div class="newcart_img">
                                                <a  href="<?php echo $objCore->getUrl('product.php', array('id' => $vCart['pkProductID'], 'name' => $vCart['ProductName'], 'refNo' => $vCart['ProductRefNo'])); ?>"><img  class="product_img1" src="<?php echo $objCore->getImageUrl($vCart['ImageName'], 'products/' . $arrProductImageResizes['default']); ?>" alt="<?php echo $vCart['ProductName']; ?>" /></a>
                                            </div>
                                            <div class="product_cart_value">
                                                <h5><?php echo $vCart['ProductName']; ?></h5>
                                                <p><input type="text" name="frmProductQuantity" class="cart_input changeQuantityHeader" pid="<?php echo $vCart['pkProductID']; ?>" ind="<?php echo $kCart; ?>" tp="product" stUrl="<?php echo SITE_ROOT_URL; ?>" inr="<?php echo $i; ?>" pri="<?php echo $vCart['FinalPrice']; ?>"  id="frmProductQuantity<?php echo $i; ?>" value="<?PHP echo $_SESSION['MyCart']['Product'][$vCart['pkProductID']][$kCart]['qty']; ?>" maxlength="3"/> X <span class="cartQuantityPriceUpdate<?php echo $i; ?>"><?php echo $objCore->getPrice($vCart['FinalPrice'] * $_SESSION['MyCart']['Product'][$vCart['pkProductID']][$kCart]['qty']); ?></span>
                                                    <input type="hidden" name="frmGiftCardQtyOld"  id="frmProductQuantityOld<?php echo $i; ?>" value="<?php echo $_SESSION['MyCart']['Product'][$vCart['pkProductID']][$kCart]['qty']; ?>"/>
                                                </p>
                                            </div>
                                            <div class="editCart">
                                                <a class="editKart_button" pid="<?php echo $vCart['pkProductID']; ?>" ind="<?php echo $kCart; ?>" tp="product" stUrl="<?php echo SITE_ROOT_URL; ?>" inr="<?php echo $i; ?>" pri="<?php echo $vCart['FinalPrice']; ?>"></a>
                                                <span class="editMyOneCartData" id="pro_<?php echo $i; ?>"><img src="<?php echo IMAGE_PATH_URL ?>ajax-loader.gif" /></span>
                                            </div>
                                            <div class="deletecart">
                                                <a class="deletecart_button" pid="<?php echo $vCart['pkProductID']; ?>" ind="<?php echo $kCart; ?>" tp="product" stUrl="<?php echo SITE_ROOT_URL; ?>" inr="<?php echo $i; ?>"></a>
                                                <span class="deleteMyOneCartData" id="pro_<?php echo $i; ?>"><img src="<?php echo IMAGE_PATH_URL ?>ajax-loader.gif" /></span>
                                            </div>
                                        </div>

                                        <?php
                                        $varDiscountCoupon += (float) $vCart['Discount'];
                                        $varCartTotal += $varCartSubTotal;
                                        $i++;
                                    }
                                    $counter2 = 0;
                                    foreach ($cartD['Package'] as $kPKG => $vPKG) {
                                        $varCartSubTotal = $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty'] * $vPKG['PackagePrice'];
                                        $counter2++;
                                        ?>
                                        <div class="cart_row RemoveFromCartPkg<?php echo $counter2; ?>">
                                            <div class="newcart_img">
                                                <?php
                                                $varSrc = $objCore->getImageUrl($vPKG['PackageImage'], 'package/' . PACKAGE_IMAGE_RESIZE1);
                                                ?>
                                                <a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>">
                                                    <img src="<?php echo $varSrc; ?>" alt="<?php echo $valCart['PackageName']; ?>" />
                                                </a>

                                            </div>


                                            <div class="product_cart_value">
                                                <h5><?php echo $vPKG['PackageName']; ?></h5>

                                                <p><input type="text" name="frmPackageQuantity" class="cart_input changeQuantityHeader" pid="<?php echo $vPKG['pkPackageId']; ?>" ind="<?php echo $kPKG; ?>" tp="package" stUrl="<?php echo SITE_ROOT_URL; ?>" inr="<?php echo $i; ?>" pri="<?php echo $vPKG['PackagePrice']; ?>"  id="frmProductQuantity<?php echo $counter2; ?>" value="<?PHP echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']; ?>" maxlength="3" style="width:45px;"/> X <span class="cartQuantityPriceUpdate<?php echo $counter2; ?>"><?php echo $objCore->getPrice($vPKG['PackagePrice'] * $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']); ?></span>
                                                    <input type="hidden" name="frmGiftCardQtyOld"  id="frmProductQuantityOld<?php echo $counter2; ?>" value="<?php echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']; ?>"/>
                                                </p>

                                            </div>

                                            <div class="editCart">
                                                <a class="editKart_button" pid="<?php echo $vPKG['pkPackageId']; ?>" ind="<?php echo $kPKG; ?>" tp="package" stUrl="<?php echo SITE_ROOT_URL; ?>" inr="<?php echo $i; ?>" pri="<?php echo $vPKG['PackagePrice']; ?>"></a>
                                                <span class="editMyOneCartData" id="pro_<?php echo $i; ?>"><img src="<?php echo IMAGE_PATH_URL ?>ajax-loader.gif" /></span>
                                            </div>
                                            <div class="deletecart">
                                                <a class="deletecart_button" pid="<?php echo $vPKG['pkPackageId']; ?>" ind="<?php echo $kPKG; ?>" tp="package" stUrl="<?php echo SITE_ROOT_URL; ?>" inr="<?php echo $counter2; ?>"></a>
                                                <span class="deleteMyOneCartData" id="pk_<?php echo $counter2; ?>"><img src="<?php echo IMAGE_PATH_URL ?>ajax-loader.gif" /></span>

                                            </div>
                                        </div>

                                        <?php
                                        $varCartTotal += $varCartSubTotal;
                                    }

                                    $giftCardCount = 0;
                                    foreach ($cartD['GiftCard'] as $key => $giftCards) {
                                        $varCartSubTotal = $giftCards['qty'] * $giftCards['amount'];
                                        $giftCardCount++;
                                        ?>
                                        <div class="cart_row RemoveFromCartGiftCard<?php echo $giftCardCount; ?>">
                                            <div class="newcart_img">
                                                <?php
                                                $varSrc = $objCore->getImageUrl('', 'gift_card');
                                                ?>
                                                <img src="<?php echo $varSrc; ?>" alt="<?php echo $giftCards['message']; ?>" />
                                            </div>


                                            <div class="product_cart_value">
                                                <h5><?php echo $giftCards['message']; ?></h5>

                                                <p><input type="text" name="frmGiftCardQty" class="cart_input changeQuantityHeader" pid="<?php echo $key; ?>" ind="<?php echo $giftCardCount; ?>" tp="giftcard" stUrl="<?php echo SITE_ROOT_URL; ?>" inr="<?php echo $giftCardCount; ?>" pri="<?php echo $giftCards['amount']; ?>"   id="frmProductQuantity<?php echo $giftCardCount; ?>" value="<?php echo $_SESSION['MyCart']['GiftCard'][$key]['qty']; ?>" maxlength="3" style="width:45px;"/> X <span class="cartQuantityPriceUpdate<?php echo $counter2; ?>"><?php echo $objCore->getPrice($giftCards['amount'] * $_SESSION['MyCart']['GiftCard'][$key]['qty']); ?></span>
                                                    <input type="hidden" name="frmGiftCardQtyOld"  id="frmProductQuantityOld<?php echo $giftCardCount; ?>" value="<?php echo $_SESSION['MyCart']['GiftCard'][$key]['qty']; ?>"/>
                                                </p>
                                            </div>

                                            <div class="editCart">
                                                <a class="editKart_button" pid="<?php echo $key; ?>" ind="<?php echo $giftCardCount; ?>" tp="giftcard" stUrl="<?php echo SITE_ROOT_URL; ?>" inr="<?php echo $giftCardCount; ?>" pri="<?php echo $giftCards['amount']; ?>"></a>
                                                <span class="editMyOneCartData" id="pro_<?php echo $i; ?>"><img src="<?php echo IMAGE_PATH_URL ?>ajax-loader.gif" /></span>
                                            </div>
                                            <div class="deletecart">
                                                <a class="deletecart_button" pid="<?php echo $key; ?>" tp="giftcard" stUrl="<?php echo SITE_ROOT_URL; ?>" inr="<?php echo $giftCardCount; ?>"></a>
                                                <span class="deleteMyOneCartData" id="gf_<?php echo $giftCardCount; ?>"><img src="<?php echo IMAGE_PATH_URL ?>ajax-loader.gif" /></span>

                                            </div>
                                        </div>

                                        <?php
                                        $varCartTotal += $varCartSubTotal;
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="cart_row">
                                <div class="newcart_img">
                                    <a href="<?php echo $objCore->getUrl('shopping_cart.php') ?>"><input type="button"  class="view_all" value="View All"/></a>
                                </div>
                                <div class="product_cart_value">
                                    <a href="<?php echo $objCore->getUrl('checkout.php') ?>"><input type="button" class="proceed_ch"  value="Proceed to Checkout"/></a>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="scroll-pane">
                                <div class="cart_complete">
                                    <div class="noCartHeaderValue"><i class="fa fa-frown-o"></i><br />There is no Item</div>
                                </div>
                            </div>
                            <div class="cart_row" style="display:none">
                                <div class="newcart_img">
                                    <a href="<?php echo $objCore->getUrl('shopping_cart.php') ?>"><input type="button"  class="view_all" value="View All"/></a>
                                </div>
                                <div class="product_cart_value">
                                    <a href="<?php echo $objCore->getUrl('checkout.php') ?>"><input type="button" class="proceed_ch"  value="Proceed to Checkout"/></a>
                                </div>
                            </div>
                        <?php } ?>

                    </div> 
                </div>


                <ul class="topMenu" id="go_topMenu">
                    <li class="link1 send_gift_card"><a href="#"><?php echo SEND_GIFT; ?></a></li>
                    <?php
                    if ($_SESSION['sessUserInfo']['email'] != '' && $_SESSION['sessUserInfo']['id'] != "" && $_SESSION['sessUserInfo']['type'] == 'customer') {
                        $notify = json_decode($objCore->getNotification($_SESSION['sessUserInfo']['type'], $_SESSION['sessUserInfo']['id']));
                        ?>
                        <li class="link4 customerLink">
                            <a href="<?php echo $objCore->getUrl('dashboard_customer_account.php') ?>" id="classACusNew"><?php echo substr($_SESSION['sessUserInfo']['screenName'], 0, 15); ?><span class="classBCusNew supportCustomerNew"></a>                            
                            <ul id="customerDrop">
                                <li class="link6"><a href="<?php echo $objCore->getUrl('dashboard_customer_account.php') ?>">  <?php echo 'Dashboard'; ?></a></li>
                                <li class="link6"><a href="<?php echo $objCore->getUrl('my_rewards.php') ?>"> <?php echo MY_REWARDS; ?></a></li>
                                <li class="link5"><a href="<?php echo $objCore->getUrl('my_orders.php') ?>">  <?php echo MY_OR; ?></a></li>
                                <li class="link6"><a href="<?php echo $objCore->getUrl('my_wishlist.php') ?>"> <?php echo MY_WISH; ?></a></li>                                
                                <li class="link7"><a href="<?php echo $objCore->getUrl('messages_inbox.php', array('place' => 'inbox')) ?>" id="classACus"><?php echo SUPP; ?><span class="classBCus supportCustomer"><?php echo $notify->customerSupport; ?></span></a></li>
                            </ul>
                        </li>
                        <li class="link2"><a href="javascript:void(0);" onclick="document.getElementById('mce-EMAIL').focus();"><?php echo SUBSCRIBE; ?></a></li>
                        <!--<li class="link4"><a href="<?php echo $objCore->getUrl('dashboard_customer_account.php') ?>"><?php echo MY_AC; ?></a></li>
                        <li class="link5"><a href="<?php echo $objCore->getUrl('my_orders.php') ?>">  <?php echo MY_OR; ?></a></li>
                        <li class="link6"><a href="<?php echo $objCore->getUrl('my_wishlist.php') ?>"> <?php echo MY_WISH; ?></a></li>
                        <li class="link7"><a href="<?php echo $objCore->getUrl('messages_inbox.php', array('place' => 'inbox')) ?>"><?php echo SUPP; ?></a></li>-->

                    <?php } elseif ($_SESSION['sessUserInfo']['email'] != '' && $_SESSION['sessUserInfo']['id'] != "" && $_SESSION['sessUserInfo']['type'] == 'wholesaler') { ?>
                        <li class="link2"><a href="javascript:void(0);" onclick="document.getElementById('mce-EMAIL').focus();"><?php echo SUBSCRIBE; ?></a></li>
                        <li class="link4"><a href="<?php echo $objCore->getUrl('dashboard_wholesaler_account.php') ?>"><?php echo MY_AC; ?></a></li>
                    <?php } ?>
                </ul>
                <div class="newBlock">
                    <small><a href="<?php echo SITE_ROOT_URL ?>products/new" style="color:white;"><?php echo WH_NEW; ?></a></small>
                </div>
            </div>

            <?php if ($_SESSION['sessUserInfo']['email'] != '' && $_SESSION['sessUserInfo']['id'] != "") { ?>
                <ul class="loginBlock">
                    <li class="signOut"><a href="<?php echo $objCore->getUrl('logout.php') ?>"><?php echo SI_OUT; ?></a></li>
                </ul>
            <?php } else { ?>

                <ul class="loginBlock">
                    <li><a href="#loginBox" onclick="return jscallLoginBox('jscallLoginBox');" class="jscallLoginBox"><?php echo LOGIN; ?></a>
                        <!-- Login Box Start-->
                        <div style="display: none;">
                            <div id="loginBox">
                                <div class="login_box">
                                    <div class="login_inner">
                                        <div class="heading">
                                            <h3><?php echo SI_IN; ?></h3>
                                            <div class="signup">
                                                <a href="#NewSignupBox" onclick="return jscallLoginBox('jscallNewSignupBox');" class="jscallNewSignupBox"><?php echo NEW_U_SI; ?></a>
                                            </div>
                                        </div>
                                        <div class="red" id="LoginErrorMsg"></div>
                                        <div class="out_btn">
                                            <div class="radio_btn">
                                                <input type="radio" name="frmUserTypeLn" value="customer" u="<?php echo isset($_COOKIE['email_id']) ? $_COOKIE['email_id'] : ''; ?>" p="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>" class="styled" checked="checked" />
                                                <small><?php echo CUSTOMER; ?></small>
                                            </div>
                                            <div class="radio_btn" id="wholesalerRadio">
                                                <input type="radio" name="frmUserTypeLn" value="wholesaler" u="<?php echo isset($_COOKIE['wemail_id']) ? $_COOKIE['wemail_id'] : ''; ?>" p="<?php echo isset($_COOKIE['wpassword']) ? $_COOKIE['wpassword'] : ''; ?>"  class="styled"/>
                                                <small><?php echo WHOLESALER; ?></small>
                                            </div>
                                        </div>
                                        <div class="form">
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
                                            <div class="password">
                                                <span>&nbsp;</span>
                                                <div class="check_box">
                                                    <input type="checkbox" name="remember_me" value="yes" class="styled" <?php echo isset($_COOKIE['email_id']) ? "checked" : ''; ?>/>
                                                    <small><?php echo REMEMBER_ME; ?></small>
                                                </div>
                                            </div>
                                            <p>
                                                <input type="button" onclick="loginAction()" name="frmHidenAdd" value="Sign In" class="submit button">
                                                <a href="#forgetPassword" onclick="return jscallLoginBox('jscallForgetPasswordBox','1');" class="jscallForgetPasswordBox"><?php echo FORGOT_PASSWORD; ?></a>
                                            </p>
                                            <p>
                                            <div id="idps" class="social_login_icons">
                                                <span><h3>OR</h3> <?php echo SI_IN ?> with </span>
                                                <img class="idpico" idp="google" src="<?php echo IMAGE_FRONT_PATH_URL; ?>socialicons/google.png" title="google" />
                                                <!--<img class="idpico" idp="twitter" src="<?php echo IMAGE_FRONT_PATH_URL; ?>socialicons/twitter.png" title="twitter" />-->
                                                <img class="idpico" idp="facebook" src="<?php echo IMAGE_FRONT_PATH_URL; ?>socialicons/facebook.png" title="facebook" />
                                                <img class="idpico" idp="linkedin" src="<?php echo IMAGE_FRONT_PATH_URL; ?>socialicons/linkedin.png" title="linkedin" />
                                            </div>
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
                                    <div class="login_inner">
                                        <div class="heading">
                                            <h3><?php echo FORGOT_PASSWORD; ?></h3>
                                            <div class="signup">
                                                <a href="#NewSignupBox" onclick="return jscallLoginBox('jscallNewSignupBox');" class="jscallNewSignupBox"><?php echo NEW_U_SI; ?></a>
                                            </div>
                                        </div>
                                        <div class="red" id="ForgetPasswordErrorMsg"></div>
                                        <div class="out_btn">
                                            <div class="radio_btn">
                                                <input type="radio" name="frmUserTypeFp" value="customer" class="styled" checked="checked" />
                                                <small><?php echo CUSTOMER; ?></small>
                                            </div>
                                            <div class="radio_btn">
                                                <input type="radio" name="frmUserTypeFp" value="wholesaler" class="styled"/>
                                                <small><?php echo WHOLESALER; ?></small>
                                            </div>
                                        </div>

                                        <div class="form">
                                            <label class="username">
                                                <span><?php echo EM_ID; ?> :</span>
                                                <input type="text" placeholder="Email Id" autocomplete="off" value="" name="frmUserEmailFp" id="frmUserEmailFp" onKeyup="Javascript: if (event.keyCode==13) forgetPasswordAction();">
                                                <div class="frmUserEmailFp"></div>
                                            </label>
                                            <p>
                                                <input type="button" onclick="forgetPasswordAction()" name="frmHidenAdd" value="Send" class="submit button">
                                                <a href="#loginBox" onclick="return jscallLoginBox('jscallLoginBox');" class="jscallLoginBox"><?php echo SI_IN; ?></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- forget password end -->

                    </li>
                    <li class="signUp"><a href="#NewSignupBox" onclick="return jscallLoginBox('jscallNewSignupBox');" class="jscallNewSignupBox"><?php echo SIGN_UP; ?></a>
                        <!-- sign up start-->
                        <div style="display: none;">
                            <div id="NewSignupBox">
                                <div class="login_box">
                                    <div class="login_inner">
                                        <div class="heading">
                                            <h3><?php echo NEW_U_SI; ?></h3>
                                            <div class="signup">
                                                <a href="#loginBox" onclick="return jscallLoginBox('jscallLoginBox');" class="jscallLoginBox"><?php echo SI_IN; ?></a>
                                            </div>
                                        </div>

                                        <div class="form">
                                            <div><?php echo CHOOSE_FOLLOWING; ?>:</div>
                                            <p>
                                                <input type="button" onclick="window.location='<?php echo $objCore->getUrl('registration_customer.php', array('type' => 'add')) ?>'" value="Customer" class="submit button" style="margin-right:20px; min-width:100px; ">

                                                <input type="button" onclick="window.location='<?php echo $objCore->getUrl('application_form_wholesaler.php') ?>'"  name="frmHidenAdd" value="Wholesaler" class="submit button" style="min-width: 100px;">
                                            </p>

                                            <div style="clear:both;"></div>
                                            <div class="signup_selector_instruction">* <?php echo WHOLESALER_BUTTON; ?></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- sign up end-->
                    </li>
                </ul>
            <?php } ?>
        </div>
    </div>
</div>


<div class="pop_up_sec">
    <form name="frmGiftCard" id="frmGiftCard" onsubmit="sendToGiftCard(this);return false;">
        <div class="pop_up_left">
            <span><img alt="" src="<?php echo IMAGE_FRONT_PATH_URL; ?>gift-icon.png"></span>
            <strong><?php echo MAIL_DEL; ?>:</strong>
            <div class="calender_sec">
                <input type="hidden" style="z-index: 33; background:transparent;" id="giftCardCalender" name="giftCardCalender"/>
                <input type="text" style="visibility:hidden;" class="validate[required] text-input" value="" id="dateRequiredValidation" name="dateRequiredValidation">
                <span id="defaultInline" class="inlinePicker"></span>
            </div>
        </div>
        <div class="pop_up_right">
            <h3><?php echo EM_GIFT_CARD; ?></h3>
            <ul class="popup_form">
                <li><input type="text" name="frmGiftCardAmount" placeholder="Enter Amount" class="validate[required,custom[integer]] text-input"></li>
                <li><input type="text" name="frmGiftCardFromName" placeholder="From Name"  class="validate[required] text-input"></li>
                <li><input type="text" name="frmGiftCardToName" placeholder="To Name"  class="validate[required] text-input"></li>
                <li><input type="text" name="frmGiftCardToEmail" placeholder="To Email"  class="validate[required,custom[email]] text-input"></li>
                <li><textarea rows="5" cols="5" name="frmGiftCardMessage" placeholder="Message"  class="validate[required] text-area"></textarea></li>
                <li><input type="text" placeholder="Qty" name="frmGiftCardQty" class="validate[required,custom[onlyNumberSp]] text-input small-text">
                    <input type="hidden" name="frmGiftCardPage" value="<?php echo basename($_SERVER['PHP_SELF']); ?>"/>
                    <input type="submit" value="Add to Cart" id="addGiftCard">
                </li>
            </ul>
        </div>
    </form>
    <a class="popup-cross gift_card_close"><img alt="" src="<?php echo IMAGE_FRONT_PATH_URL; ?>cross1.png"></a>
</div>
<div class="popups" id="popupAddToCart">
    <div class="addtocart"></div>
    <a href="javascript:void(0);" class="cross"></a>
</div>

<div id="fancybox-overlay" style="cursor: pointer; opacity: 0.9;"></div>