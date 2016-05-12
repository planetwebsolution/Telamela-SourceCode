<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_SHOPPING_CART_CTRL;
//unset($_SESSION['MyCart']['CouponCode']);
//unset($_SESSION['MyCart']);
//unset($_SESSION['MyCart']['Product']);
//pre($_SESSION['MyCart']['Package']);
//pre($objPage->arrData['arrCartDetails']);
//pre($objPage->arrData['arrCartDetails']['Product']);
//pre($_SESSION['MyCart']['Package']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo SHIPPING_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH ?>shopping_cart.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.drop_down1').sSelect();
                $('#GrandTot').val();
                var Min = <?php echo MINIMUM_ORDER_PRICE; ?>;
                if($('#GrandTot').val()<Min){
                    $('.proceed2').remove();
                }
                $("#frmCouponCode").on('keydown',function(event){
                if(event.keyCode == 13){
                    ApplyCouponCode('coupon_btn1');
                    return false;
                }
            });   
            });
            
            function setDisable(obj)
            {
                obj.disabled = true;
                var attributeValue=obj.getAttribute('onclick');
                obj.removeAttribute('onclick');
                $(obj).css('cursor','default');
                $(obj).css('opacity','0.36');
                setTimeout(function() {
                    obj.disabled = false;
                    $(obj).css('cursor','pointer');
                    $(obj).css('opacity','1');
                    obj.setAttribute("onclick",''+attributeValue+'');
                }, 2000);
                
            }
                    
        </script>
        <style>
            .price_sec p{
                text-align: center;
            }

            .left_product_h h4{
                text-align: center;
            }
            .input_S h4{
                margin-left: 78px;width: 270px;
            }
            .adimg{ margin-left:-63px !important }

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
                        <h1><?php echo SHOPPING; ?>&nbsp;<?php echo CART; ?></h1>

                    </div>
                    <div class="body_container_inner_bg radius">
                        <div class="shoping_cart_sec wish_sec">
                            <?php
                            if ($objCore->displaySessMsg())
                            {
                                ?>
                                <div class="successMessage">
                                    <?php
                                    echo $objCore->displaySessMsg();
                                    $objCore->setSuccessMsg('');
                                    $objCore->setErrorMsg('');
                                    ?>
                                </div>
                            <?php } ?><div style="clear:both"></div>
                            <?php
                            if ($objPage->arrData['arrCartDetails']['Common']['CartCount'] == 0)
                            {
                                ?>
                                <div class="shoping_top_secEmpty" style="min-height:341px;">
                                    <p align="center"><?php echo EMPTY_CART; ?></p>
                                    <ul>
                                        <li><a href="<?php echo SITE_ROOT_URL; ?>" class="con_shoping countinue_shopping"><span><?php echo CON_SHOPING; ?></span></a></li>
                                    </ul>
                                </div>
                                <?php
                            }
                            else
                            {
                                ?>
                                <form action="" name="MyCart" id="MyCart" method="post">

                                    <ul class="shoping_cart shoping_cart2">
                                        <li class="first" style="padding:19px 0 20px 23px">
                                            <div class="left_product_h">
                                                <h4><?php echo ITEM; ?></h4>
                                            </div>
                                            <div class="price_sec">
                                                <h4><?php echo UNIT_P; ?></h4>
                                            </div>
                                            <div class="input_S">
                                                <h4><?php echo QTY; ?></h4>

                                            </div>

                                            <div class="sub_total">
                                                <h4><?php echo SUBTOTAL; ?></h4>
                                            </div>
                                        </li>
                                        <?php
                                        $varCartSubTotal = 0;
                                        $varCartTotal = 0;
                                        $varDiscountCoupon = 0;
                                        $i = 0;
                                        $varCheckedForCoupan = 0;
                                        $varCartSubTotal4='';
//                                        echo "<pre>";
//                                        print_r($_SESSION);
//                                        print_r($objPage->arrData['arrCartDetails']['Product']);
//                                        echo "</pre>";
//                                        die;
                                        foreach ($objPage->arrData['arrCartDetails']['Product'] as $kCart => $vCart)
                                        {   //echo $vCart['FinalPrice'];
                                            $varCheckedForCoupan = 1;
                                            $varPr = $objCore->getProductCalCurrencyPrice($vCart['FinalPrice']);
                                            $varCartSubTotal2 = $varPr * $_SESSION['MyCart']['Product'][$vCart['pkProductID']][$kCart]['qty'];
                                            $varCartSubTotal = $_SESSION['MyCart']['Product'][$vCart['pkProductID']][$kCart]['qty'] * $vCart['FinalPrice'];
                                            $varCartSubTotal3[] = $varCartSubTotal2;
                                            $varCartSubTotal4[] = $varCartSubTotal2;
                                           // pre($_SESSION['MyCart']['Product'][$vCart['pkProductID']][$kCart]['qty']);
                                            ?>
                                            <li id="RemoveFromCart<?php echo $vCart['pkProductID']; ?>_<?php echo $i; ?>">
                                                <div class="thumb">
                                                    <div class="border2">
                                                        <a href="<?php echo $objCore->getUrl('product.php', array('id' => $vCart['pkProductID'], 'name' => $vCart['ProductName'], 'refNo' => $vCart['ProductRefNo'])); ?>">
                                                            <img src="<?php echo $objCore->getImageUrl($vCart['ImageName'], 'products/' . $arrProductImageResizes['global']); ?>" alt="<?php echo $vCart['ProductName']; ?>" />
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="left_product">
                                                    <a href="<?php echo $objCore->getUrl('product.php', array('id' => $vCart['pkProductID'], 'name' => $vCart['ProductName'], 'refNo' => $vCart['ProductRefNo'])); ?>"><h4><?php echo $vCart['ProductName']; ?></h4></a>
                                                    <span><?php echo $vCart['attribute']; ?></span>
                                                    <span><?php echo BY; ?> : <a href="<?php echo $objCore->getUrl('wholesaler_profile_customer_view.php', array('action' => 'view', 'wid' => $vCart['fkWholesalerID'])); ?>"><small><?php echo $vCart['CompanyName']; ?></small></a></span>
                                                    <p><small><?php echo $vCart['CategoryName']; ?></small> </p>
                                                </div>
                                                <div class="price_sec">
                                                    <p><?php echo $objCore->getPrice($vCart['FinalPrice']); ?></p>
                                                </div>
                                                <div class="input_S">
                                                    <p>
                                                        <!--<input type="text" name="frmProductQuantity[]" class="quant validate[required,min[1],max[<?php echo (int) $vCart['attrOptMaxQty']; ?>]],custom[integer]" value="<?PHP echo $_SESSION['MyCart']['Product'][$vCart['pkProductID']][$kCart]['qty']; ?>" maxlength="3"/>-->
                                                        <div class="quantity" style="position: relative;">
                                                            <div class="maxqty" id="maxqty_<?php echo $vCart['pkProductID'] ?>_<?php echo $i; ?>"></div>
                                                            <input type="text" class="quantitiy_box" name="frmProductQuantity[]"  id="frmCartQty_<?php echo $vCart['pkProductID'] ?>_<?php echo $i; ?>"  value="<?PHP echo $_SESSION['MyCart']['Product'][$vCart['pkProductID']][$kCart]['qty']; ?>" maxlength="3" readonly="" />
                                                            <input type='button' name='add' id="add_<?php echo $vCart['pkProductID'] ?>_<?php echo $i; ?>" onclick="quantityCartPlusMinus(1,'<?php echo $vCart['pkProductID'] ?>','<?php echo $objCore->getPrice($vCart['FinalPrice']); ?>','<?php echo $_SESSION['SiteCurrencySign']; ?>','product','<?php echo $kCart; ?>','<?php echo $i; ?>','<?php echo $vCart['FinalPrice']; ?>','<?php echo $vCart['attrOptMaxQty']; ?>',this);return setDisable(this);" value='+' class="plus plus_icon product<?php echo $vCart['pkProductID']; ?>_<?php echo $i; ?>" />
                                                            <input type='button' name='subtract' id="sub_<?php echo $vCart['pkProductID'] ?>_<?php echo $i; ?>"  onclick="quantityCartPlusMinus(0,'<?php echo $vCart['pkProductID'] ?>','<?php echo $objCore->getPrice($vCart['FinalPrice']); ?>','<?php echo $_SESSION['SiteCurrencySign']; ?>','product','<?php echo $kCart; ?>','<?php echo $i; ?>','<?php echo $vCart['FinalPrice']; ?>','<?php echo $vCart['attrOptMaxQty']; ?>',this);return setDisable(this);" value='-' class="minus minus_icon" />
                                                            <input type="hidden" name="frmGiftCardQtyOld"  id="frmProductQuantityOld<?php echo $i; ?>" value="<?php echo $_SESSION['MyCart']['Product'][$vCart['pkProductID']][$kCart]['qty']; ?>"/>
                                                            <span></span>
                                                        </div>
                                                        <input type="hidden" name="frmProductId[]" value="<?php echo $vCart['pkProductID']; ?>" />
                                                        <input type="hidden" name="frmProductIndex[]" value="<?php echo $kCart; ?>" />
                                                    </p>
                                                </div>
                                                <div class="sub_total">
                                                    <p id="totalCartCost_<?php echo $vCart['pkProductID'] ?>_<?php echo $i; ?>"><?php echo $_SESSION['SiteCurrencySign'] . ' ' . $objCore->price_format($varCartSubTotal2); ?></p>
                                                </div>
                                                <a href="javascript:void(0)" onclick="RemoveProductFromCart(<?php echo $vCart['pkProductID']; ?>,'<?php echo $kCart; ?>','<?php echo $i; ?>');" class="black_cross" title="Remove"></a>
                                            </li>
                                            <?php
                                            $varDiscountCoupon += (float) $vCart['Discount'];
                                            //echo $varDiscountCoupon.'==';
                                            $varCartTotal += $varCartSubTotal;
                                            $i++;
                                        }
                                        $ppk = $i;
                                        foreach ($objPage->arrData['arrCartDetails']['Package'] as $kPKG => $vPKG)
                                        {
                                            $varCartSubTotal = $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty'] * $vPKG['PackagePrice'];
                                            $varCartSubTotalNew = $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty'] * $objCore->getProductCalCurrencyPrice($vPKG['PackagePrice']);
                                            $varCartSubTotal2 = $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty'] * $objCore->getProductCalCurrencyPrice($vPKG['PackagePrice']);
                                            $varCartSubTotal3[] = $varCartSubTotal2;
                                            ?>
                                            <li id="RemoveFromCartPkg<?php echo $vPKG['pkPackageId']; ?>">
                                                <div class="thumb">
                                                    <div class="border2">
                                                        <?php
                                                        $varSrc = $objCore->getImageUrl($vPKG['PackageImage'], 'package/161x148');
                                                        ?>
                                                        <a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>">
                                                            <img src="<?php echo $varSrc; ?>" alt="<?php echo $valCart['PackageName']; ?>" />
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="left_product">
                                                    <a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>"><h4><?php echo $vPKG['PackageName']; ?></h4></a>
                                                    <span class="package_products">
                                                        <?php
                                                        echo $vPKG['productDetail'];
                                                        ?>
                                                    </span>
                                                    <span><?php echo BY; ?> :  <a href="<?php echo $objCore->getUrl('wholesaler_profile_customer_view.php', array('action' => 'view', 'wid' => $vPKG['fkWholesalerID'])); ?>"><small><?php echo $vPKG['CompanyName']; ?></small></a></span>
                                                    <p><small><?php echo PACKAGE; ?></small> </p>
                                                </div>
                                                <div class="price_sec">
                                                    <p><?php echo $objCore->getPrice($vPKG['PackagePrice']); ?></p>
                                                </div>
                                                <div class="input_S">
                                                    <p>
                                                        <!--<input type="text" name="frmProductQuantity[]" class="quant validate[required,min[1],max[<?php echo (int) $vCart['attrOptMaxQty']; ?>]],custom[integer]" value="<?PHP echo $_SESSION['MyCart']['Product'][$vCart['pkProductID']][$kCart]['qty']; ?>" maxlength="3"/>-->
                                                        <div class="quantity">
                                                            <input type="text" class="quantitiy_box" name="frmPackageQuantity[]"  id="frmCartQty_<?php echo $vPKG['pkPackageId']; ?>_<?php echo $i; ?>"  value="<?php echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']; ?>" maxlength="3" readonly="" />
                                                            <input type='button' name='add' onclick="quantityCartPlusMinus(1,'<?php echo $vPKG['pkPackageId']; ?>','<?php echo $vPKG['PackagePrice']; ?>','<?php echo $_SESSION['SiteCurrencySign']; ?>','package','<?php echo $kPKG; ?>','<?php echo $ppk; ?>','<?php echo $vPKG['PackagePrice']; ?>','<?php echo $vPKG['Quantity']; ?>',this)" value='+' class="plus plus_icon package<?php echo $vPKG['pkPackageId']; ?>_<?php echo $i; ?>" />
                                                            <input type='button' name='subtract' onclick="quantityCartPlusMinus(0,'<?php echo $vPKG['pkPackageId'] ?>','<?php echo $vPKG['PackagePrice']; ?>','<?php echo $_SESSION['SiteCurrencySign']; ?>','package','<?php echo $kPKG; ?>','<?php echo $ppk; ?>','<?php echo $vPKG['PackagePrice']; ?>','<?php echo $vPKG['Quantity']; ?>',this)" value='-' class="minus minus_icon" />
                                                            <input type="hidden" name="frmGiftCardQtyOld"  id="frmProductQuantityOld<?php echo $ppk; ?>" value="<?php echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']; ?>"/>
                                                            <span></span>
                                                        </div>
                                                        <input type="hidden" name="frmPackageId[]" value="<?php echo $vPKG['pkPackageId']; ?>" />
                                                        <input type="hidden" name="frmPackageIndex[]" value="<?php echo $kPKG; ?>" />
                                                    </p>
                                                </div>
                                                <!--    <div class="input_S">
                                                    <input type="text" name="frmPackageQuantity[]" class="validate[required,min[1]],custom[integer]" value="<?php echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']; ?>" />
                                                    <input type="hidden" name="frmPackageId[]" value="<?php echo $vPKG['pkPackageId']; ?>" />
                                                    <input type="hidden" name="frmPackageIndex[]" value="<?php echo $kPKG; ?>" />
                                                </div>-->
                                                <div class="sub_total">
                                                    <p id="totalCartCost_<?php echo $vPKG['pkPackageId']; ?>_<?php echo $i; ?>"><?php echo $objCore->getCurPrice($varCartSubTotalNew); ?></p>
                                                </div>
                                                <a href="javascript:void(0)" onclick="RemovePackageFromCart(<?php echo $vPKG['pkPackageId']; ?>,'<?php echo $kPKG; ?>');" class="black_cross" title="Remove"></a>
                                            </li>
                                            <?php
                                            $varCartTotal += $varCartSubTotal;
                                            $ppk++;
                                        }

                                        $giftCardCount = 0;
                                        //pre($objPage->arrData['arrCartDetails']['GiftCard']);
                                        foreach ($objPage->arrData['arrCartDetails']['GiftCard'] as $key => $giftCards)
                                        {

                                             $varCartSubTotal = $giftCards['qty'] * $giftCards['amount'];
                                             $varCartSubTotalNew = $giftCards['qty'] * $objCore->getProductCalCurrencyPrice($giftCards['amount']);
                                             $varCartSubTotal2 = $giftCards['qty'] * $objCore->getProductCalCurrencyPrice($giftCards['amount']);
                                           // echo $varCartSubTotal2;
                                            $varCartSubTotal3[] = $varCartSubTotal2;
                                            ?>
                                            <li id="RemoveFromCartGiftCard<?php echo $key; ?>">
                                                <div class="thumb">
                                                    <div class="border2">
                                                        <?php
                                                        $varSrc = $objCore->getImageUrl('', 'gift_card');
                                                        ?>
                                                        <img src="<?php echo $varSrc; ?>" alt="<?php echo $giftCards['message']; ?>" />
                                                    </div>
                                                </div>
                                                <div class="left_product">
                                                    <h4><?php echo strtoupper(GIFT_CARD); ?><?php //echo $giftCards['message']; ?></h4>
                                                    <span><?php echo BY; ?> : <small><?php echo $giftCards['fromName']; ?></small></span>
                                                    <p><small><?php echo $giftCards['message']; ?></small> </p>
                                                </div>
                                                <div class="price_sec">
                                                    <p><?php echo $objCore->getPrice($giftCards['amount']); ?></p>
                                                </div>
                                                <div class="input_S">

                                                    <p>
                                                        <div class="quantity" style="position: relative;">

                                                            <input type="text" class="quantitiy_box" name="frmGiftCardQty[]"  id="frmCartQty_<?php echo $giftCardCount; ?>_<?php echo $key; ?>"  value="<?php echo $_SESSION['MyCart']['GiftCard'][$key]['qty']; ?>" maxlength="3" readonly="" />
                                                            <input type='button' name='add' id="add_<?php echo $giftCardCount; ?>_<?php echo $key; ?>" onclick="quantityCartPlusMinus(1,'<?php echo $giftCardCount ?>','<?php echo $objCore->getPrice($giftCards['amount']); ?>','<?php echo $_SESSION['SiteCurrencySign']; ?>','gift','<?php echo $key; ?>','<?php echo $key; ?>','<?php echo $giftCards['amount']; ?>','1000',this);return setDisable(this);" value='+' class="plus plus_icon gift<?php echo $key; ?>_<?php echo $key; ?>" />
                                                            <input type='button' name='subtract' id="sub_<?php echo $key ?>_<?php echo $key; ?>"  onclick="quantityCartPlusMinus(0,'<?php echo $key; ?>','<?php echo $objCore->getPrice($giftCards['amount']); ?>','<?php echo $_SESSION['SiteCurrencySign']; ?>','gift','<?php echo $key; ?>','<?php echo $key; ?>','<?php echo $giftCards['amount']; ?>','1000',this);return setDisable(this);" value='-' class="minus minus_icon" />
                                                            <input type="hidden" name="frmGiftCardQtyOld"  id="frmProductQuantityOld<?php echo $key; ?>" value="<?php echo $_SESSION['MyCart']['GiftCard'][$key]['qty']; ?>"/>
                                                            <span></span>
                                                        </div>

                        <!--                                                        <input type="text" class="quantitiy_box" name="frmGiftCardQty[]"  value="<?php echo $_SESSION['MyCart']['GiftCard'][$key]['qty']; ?>" maxlength="3" readonly="" />
                        <input type='button' name='add' value='+' class="plus plus_icon" />
                        <input type='button' name='subtract'  value='-' class="minus minus_icon" />-->
                                                        <input type="hidden" name="frmGiftCardId[]" value="<?php echo $key; ?>" />
                                                    </p>
                                                </div>
                                                <div class="sub_total">
                                                    <p id="totalCartCost_<?php echo $giftCardCount ?>_<?php echo $key; ?>"><?php echo $objCore->getCurPrice($varCartSubTotalNew); ?></p>
                                                </div>
                                                <a href="javascript:void(0)" onclick="RemoveGiftCardFromCart(<?php echo $key; ?>);" class="black_cross" title="Remove"></a>
                                            </li>
                                            <?php
                                            $varCartTotal += $varCartSubTotal;
                                            $giftCardCount++;
                                        }
                                        ?>
                                    </ul>
                                    <div class="shoping_bottom_sec">
                                        <div style=" margin-bottom: 110px;
                                             background: #f6f6f6;
                                             padding: 5px;
                                             height:38px;
                                             ">
                                            <!--<a href="<?php echo $objCore->getUrl('product_comparison.php'); ?>" class="compare_btn_sh">COMPARE PRODUCTS</a>-->
                                            <a href="javascript:void(0)" onclick="RemoveCart();" class="con_shoping clear_cart"><?php echo CLEAR_SHOP; ?></a>
                                            <a href="<?php echo SITE_ROOT_URL; ?>" class="con_shoping countinue_shopping"><?php echo CON_SHOPING; ?></a>
                                            <input type="submit" name="UpdateMyCart" class="shopping_update2" value="<?php echo PROCESSED_TO; ?>" />
                                        </div>
                                        <ul class="gift_sec">
                                            <li class="last">

                                                <div id="CouponCodeMsg" style="float: left;"></div>
                                                <div id="coupancodenoteligable" style="display:none"><span style="color:red;font-size:12px;">Coupon code applied for products only</span></div>
                                                <div class="apply_sec">
                                                    <input type="text" name="frmCouponCode" class="coupon_code" id="frmCouponCode" value="<?php
                                    if ($objPage->arrData['arrCartDetails']['Common']['CouponCode'] <> '')
                                    {
                                        echo $objPage->arrData['arrCartDetails']['Common']['CouponCode'];
                                    }
                                    else
                                    {
                                        echo ENTER_CODE;
                                    }
                                        ?>" onfocus="if(this.value=='<?php echo ENTER_CODE; ?>') this.value=''" onblur="if(this.value=='') this.value='<?php echo ENTER_CODE; ?>'" autocomplete="off"/>
                                                    <input type="button" coupanCheck="<?php echo $varCheckedForCoupan; ?>" class="coupon_btn1" onclick="ApplyCouponCode(this.className);" value="<?php echo APPLY; ?>"/>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="shoping_bot_right">
                                            <!--  <ul>

                                                  <li class="proceed1">
                                                      <input type="submit" name="UpdateMyCart" class="shopping_update" value="<?php echo UPDATE_SHOP; ?>" />
                                                  </li>
                                              </ul>-->
                                            <div class="total_box">CART TOTALS<span></span></div>
                                            <ul class="total_sec" id="total_sec">
                                                <li style="border-bottom:1px solid #f3f3f3">
                                                    <span><?php echo SUBTOTAL; ?></span>
                                                    <strong id="subTotalP"><?php //$objCore->getPrice($varCartSubTotal);
                                                       //echo $varCartSubTotal;
                                                       echo $_SESSION['SiteCurrencySign'] . ' ' . array_sum($varCartSubTotal3);
                                        ?></strong>                                                </li>
                                                <li  style="border-bottom:1px solid #f3f3f3">
                                                    <span><?php echo DISCOUNT; ?> <?php echo COUPON; ?></span>

                                                    <strong id="DiscountCouponP">- <?php echo $objCore->getPrice($varDiscountCoupon); ?></strong>
                                                    <?php $getPercent = $varDiscountCoupon * 100 / array_sum($varCartSubTotal4);
                                                    //echo "<pre>";
                                                    //print_r($varCartSubTotal4);
                                                    //echo "</pre>";
                                                    //echo $varDiscountCoupon;
                                                    ?>
                                                    <input type="hidden" id="DiscountCouponPValue" value="<?php echo (int) $getPercent; ?>"/>
                                                </li>
                                                <li class="last">
                                                    <span><?php echo GRAND_TOTAL; ?></span>
                                                    <strong>
                                                        <?php
                                                        $varGrandTotal = array_sum($varCartSubTotal3) - $objCore->getProductCalCurrencyPrice($varDiscountCoupon);
                                                        //echo $objCore->getPrice($varGrandTotal);
                                                        echo $_SESSION['SiteCurrencySign'] . ' ' . $varGrandTotal;
                                                        ?>
                                                    </strong>
                                                </li>
                                            </ul>
                                            <!--<ul class="proceed_ul">
                                            <?php
                                            if ($varGrandTotal < MINIMUM_ORDER_PRICE)
                                            {
                                                ?>
                                                                                                    <li>
                                                                                                        <input type="submit" name="UpdateMyCart" class="minimum_order" value="<?php echo 'Minmum Order is' . ' ' . $objCore->getPrice(MINIMUM_ORDER_PRICE); ?>" />
                                                                                                        <input type="hidden" id="GrandTot" value="<?php echo $varGrandTotal; ?>"/>
                                                                                                    </li>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                                                                    <li class="proceed2 secproceed">
                                                                                                        <input type="submit" name="UpdateMyCart" class="shopping_update2" value="<?php echo PROCESSED_TO; ?>" />
                                                                                                    </li>
                                            <?php } ?>
                                            </ul>-->
                                            <?php /* <a href="javascript:void(0);" class="proceed con_shoping" onclick="if(checkQuantity()){window.location='checkout.php';}"><span><?php echo PROCESSED_TO; ?></span></a> */ ?>
                                        </div>
                                    </div>
                                </form><?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html>