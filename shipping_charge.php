<?php
//pre($_SESSION['MyCart']);
require_once 'common/config/config.inc.php';
//pre($_SESSION['MyCart']);
require_once CONTROLLERS_PATH . FILENAME_SHIPPING_CHARGE_CTRL;
//require_once CONTROLLERS_PATH . FILENAME_ORDER_PAGE_CTRL;
$productQuatity = 0;
//pre($objPage->arrData['CustomerDeatails']);
//unset($_SESSION['MyCart']['CouponCode']);
//pre($_SESSION['MyCart']['CouponCode']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Shipping charges</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.mousewheel.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>shipping_charge.js"></script>
        <script type="text/javascript">

            $(document).ready(function () {
                $('#GrandTot').val();
                var Min = <?php echo MINIMUM_ORDER_PRICE; ?>;
                if ($('#GrandTot').val() < Min) {
                    $('.proceed2').remove();
                }

            });
        </script>
        <style>
            .adimg{ margin-left:-63px !important }
            .shoping_cart{ margin-top:10px}
            .shoping_cart_sec{ width:1140px;}
            .shoping_cart li{ width:1102px; margin-bottom:10px;}
            .total_sec li{ border-bottom:1px solid #f3f3f3}
            .total_sec li:last-child{ border-bottom:0px	}
            .shipping_type li{ border-bottom: none !important}
            .jspPane { padding: 0 73px 0 60px !important; }
            .shipping_information ul li small{width: auto;}
        </style>
    </head>
    <body>
        <?php
        //pre($objPage->arrData['CustomerDeatails']);

        if ($_SESSION['RunShippingID'] == 1) {
            $arrCustomerDetails[0]['ShippingFirstName'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingFirstName'];
            $arrCustomerDetails[0]['ShippingLastName'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingLastName'];
            $arrCustomerDetails[0]['ShippingOrganizationName'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingOrganizationName'];
            $arrCustomerDetails[0]['ShippingAddressLine1'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingAddressLine1'];
            $arrCustomerDetails[0]['ShippingAddressLine2'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingAddressLine2'];
            $arrCustomerDetails[0]['ShippingCountry'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingCountry'];
            $arrCustomerDetails[0]['ShippingState'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingState'];
            $arrCustomerDetails[0]['ShippingCity'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingCity'];
            $arrCustomerDetails[0]['ShippingCountryName'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingCountryName'];
            $arrCustomerDetails[0]['ShippingPostalCode'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingPostalCode'];
            $arrCustomerDetails[0]['ShippingPhone'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingPhone'];
        } else if ($_SESSION['RunShippingID'] == 2) {
            $arrCustomerDetails[0]['ShippingFirstName'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingFirstName'];
            $arrCustomerDetails[0]['ShippingLastName'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingLastName'];
            $arrCustomerDetails[0]['ShippingOrganizationName'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingOrganizationName'];
            $arrCustomerDetails[0]['ShippingAddressLine1'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingAddressLine1'];
            $arrCustomerDetails[0]['ShippingAddressLine2'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingAddressLine2'];
            $arrCustomerDetails[0]['ShippingCountry'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingCountry'];
            $arrCustomerDetails[0]['ShippingState'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingState'];
            $arrCustomerDetails[0]['ShippingCity'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingCity'];
            $arrCustomerDetails[0]['ShippingCountryName'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingCountryName'];
            $arrCustomerDetails[0]['ShippingPostalCode'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingPostalCode'];
            $arrCustomerDetails[0]['ShippingPhone'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingPhone'];
        } else {
            $arrCustomerDetails[0]['ShippingFirstName'] = $objPage->arrData['CustomerDeatails'][0]['ShippingFirstName'];
            $arrCustomerDetails[0]['ShippingLastName'] = $objPage->arrData['CustomerDeatails'][0]['ShippingLastName'];
            $arrCustomerDetails[0]['ShippingOrganizationName'] = $objPage->arrData['CustomerDeatails'][0]['ShippingOrganizationName'];
            $arrCustomerDetails[0]['ShippingAddressLine1'] = $objPage->arrData['CustomerDeatails'][0]['ShippingAddressLine1'];
            $arrCustomerDetails[0]['ShippingAddressLine2'] = $objPage->arrData['CustomerDeatails'][0]['ShippingAddressLine2'];
            $arrCustomerDetails[0]['ShippingCountry'] = $objPage->arrData['CustomerDeatails'][0]['ShippingCountry'];
            $arrCustomerDetails[0]['ShippingState'] = $objPage->arrData['CustomerDeatails'][0]['ShippingState'];
            $arrCustomerDetails[0]['ShippingCity'] = $objPage->arrData['CustomerDeatails'][0]['ShippingCity'];
            $arrCustomerDetails[0]['ShippingCountryName'] = $objPage->arrData['CustomerDeatails'][0]['ShippingCountryName'];
            $arrCustomerDetails[0]['ShippingPostalCode'] = $objPage->arrData['CustomerDeatails'][0]['ShippingPostalCode'];
            $arrCustomerDetails[0]['ShippingPhone'] = $objPage->arrData['CustomerDeatails'][0]['ShippingPhone'];
        }
        ?>
        <div id="navBar">
            <?php include_once 'common/inc/top-header.inc.php'; ?>
        </div>
        <div class="header"><div class="layout">

            </div>
        </div><?php include_once INC_PATH . 'header.inc.php'; ?>
        <div>
            <div class="layout">

                <div class="add_pakage_outer">
                    <div class="top_header border_bottom">
                        <h1>Shipping Charge</h1>

                    </div>
                    <div class="body_container_inner_bg radius">
                        <input type="hidden" name="customerCurrencyCode" id="customerCurrencyCode" value="<?php echo $_SESSION['SiteCurrencySign']; ?>" />
                        <form method="post" action="order_detail_page.php" id="shippingForm">
                            <div class="shoping_cart_sec wish_sec">
                                <?php
                                if ($objCore->displaySessMsg()) {
                                    ?>
                                    <div class="successMessage">
                                        <?php
                                        echo $objCore->displaySessMsg();
                                        $objCore->setSuccessMsg('');
                                        $objCore->setErrorMsg('');
                                        ?>
                                    </div>
                                <?php } ?>
                                <!--<div class="shoping_top_sec">
                                    <ul>
                                        <li><a href="<?php echo SITE_ROOT_URL; ?>" class="con_shoping"><span><?php echo CON_SHOPING ?></span></a></li>
                                        <li class="proceed2">
                                            <input type="submit" name="UpdateMyCart" class="shopping_update2" value="<?php echo PROCESSED_TO; ?>" />
                                        </li>
                                    </ul>
                                </div>-->
                                <ul class="shoping_cart shipping_charges shoping_cart2" id="shoping_cart">  <li class="first" style="padding:19px 0 20px 23px">
                                        <div class="left_product_h" style="text-align:center">
                                            <h4><?php echo ITEM; ?></h4>
                                        </div>
                                        <div class="price_sec marg">
                                            <h4><?php echo PRICE; ?></h4>
                                        </div>
                                        <div class="input_S" style="margin-left:90px;">
                                            <h4><?php echo SHIPPING_METHOD; ?></h4>

                                        </div>

                                        <div class="sub_total marg" style="margin-left:0px">
                                            <h4><?php echo SUBTOTAL; ?></h4>
                                        </div>

                                    </li>
                                    <?php
                                    $varCartSubTotal = 0;
                                    $varCartItemTotal = 0;
                                    $varCartTotal = 0;
                                    $varDiscountCoupon = 0;
                                    $i = 0;
                                    $j = 0;
                                    $k = 0;
                                    $isShip = '1';
//                                    pre($objPage->arrData['arrCartDetails'] );
                                    foreach ($objPage->arrData['arrCartDetails']['Product'] as $kCart => $vCart) {
                                        $varCartItemTotal = $vCart['qty'] * $objCore->getProductCalCurrencyPrice($vCart['FinalPrice']);
                                        $productQuatity = $vCart['attrOptMaxQty'] > 0 ? $vCart['attrOptMaxQty'] : 0;
                                        ?>
                                        <li class="myItem">
                                            <div class="thumb">
                                                <div class="border2">
                                                    <?php $varSrc = $objCore->getImageUrl($vCart['ImageName'], 'products/' . $arrProductImageResizes['global']); ?>
                                                    <a href="<?php echo $objCore->getUrl('product.php', array('id' => $vCart['pkProductID'], 'name' => $vCart['ProductName'], 'refNo' => $vCart['ProductRefNo'])); ?>">
                                                        <img src="<?php echo $varSrc; ?>" alt="<?php echo $valCart['ProductName']; ?>"/>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="left_product">
                                                <a href="<?php echo $objCore->getUrl('product.php', array('id' => $vCart['pkProductID'], 'name' => $vCart['ProductName'], 'refNo' => $vCart['ProductRefNo'])); ?>">
                                                    <h4>
                                                        <?php echo $vCart['ProductName']; ?>
                                                    </h4>
                                                </a>

                                                </h4>
                                                <span><?php echo $vCart['attribute']; ?></span>
                                                <span><?php echo BY; ?> : <a href="<?php echo $objCore->getUrl('wholesaler_profile_customer_view.php', array('action' => 'view', 'wid' => $vCart['fkWholesalerID'])); ?>"><small><?php echo $vCart['CompanyName']; ?></small></a></span>
                                                <p><small><?php echo $vCart['CategoryName']; ?></small> </p>
                                            </div>
                                            <div class="price_sec marg">
                                                <!--<h4>Product Cost</h4>-->
                                                <p><?php echo $_SESSION['SiteCurrencySign'] . ' ' . $varCartItemTotal; ?></p>
                                            </div>
                                            <div class="shipping_type">
                                                <!--<h4>Shipping Method</h4>-->
                                                <div class="sgm" id="<?php echo $i; ?>">
                                                    <ul class="radio_list scroll-pane" id="<?php echo 'pro' . $vCart['pkProductID']; ?>">
                                                        <?php
                                                        //pre($vCart['ShippingDetails']);
                                                        $i++;
                                                        $l = 0;
                                                        $ch = 0;
                                                        if (count($vCart['ShippingDetails']) > 0) {
                                                            foreach ($vCart['ShippingDetails'] as $k3 => $v3) {
                                                                $checked = '';
                                                                ?>
                                                                <li>
                                                                    <h5><?php echo $v3['logisticTitle'] ?></h5>
                                                                    <ul>
                                                                        <?php
                                                                        if (!empty($v3['Methods'][$l]['ServiceType'])) {
                                                                            foreach ($v3['Methods'] as $value) {
                                                                                $checked = '';

                                                                                $smCost = $objCore->getPrice($value['costperkg']);
                                                                                $smCostUSD = $value['ShippingCost'];
                                                                                if ($ch == 0) {
                                                                                    $checked = 'checked="checked"';
                                                                                    $ch++;
                                                                                }
                                                                                ?>
                                                                                <li>
                                                                                    <label>
                    <!--                                                                                     <input type="radio" class="styled" name="proRad[<?php echo $kCart; ?>]" value="<?php echo $vm['fkShippingGatewayID'] . '-' . $vm['pkShippingMethod'] . '-' . $smCostUSD; ?>" onclick="showShippingPrice(this,<?php echo $vm['fkShippingGatewayID']; ?>,<?php echo $vm['pkShippingMethod']; ?>,'product',<?php echo $vCart['pkProductID']; ?>,<?php echo $vCart['qty']; ?>);" <?php echo $checked; ?> /> -->
                                                                                        <input type="radio" class="styled"
                                                                                               name="proRad[<?php echo $kCart; ?>]"
                                                                                               value="<?php echo $v3['pkShippingGatewaysID'] . '-' . $v3['ShippingTitle'] . '-' . $smCostUSD; ?>"
                                                                                               onclick="showShippingPrice(this,<?php echo $v3['pkShippingGatewaysID']; ?>,<?php echo (!empty($v3['Methods'][0]['pkShippingMethod'])) ? $v3['Methods'][0]['pkShippingMethod'] : '0'; ?>, 'product',<?php echo $vCart['pkProductID']; ?>,<?php echo $vCart['qty']; ?>);" <?php echo $checked; ?> />
                                                                                        <!--  
                                                                                        <input type="hidden" name="fkShippingGatewayID" value="<?php echo $v3['pkShippingGatewaysID']; ?>"/>
                                                                                         <input type="hidden" name="methodname" value="<?php echo $v3['ShippingTitle']; ?>"/>
                                                                                        -->
                                                                                        <small>
                                                                                            <?php echo $value['ServiceType']; ?>
                                                                                            <span class="amt"><?php echo $smCost; ?></span>
                                                                                        </small>
                                                                                    </label>
                                                                                </li>
                                                                                <?php
                                                                            }
                                                                        } else {

                                                                            $l++;

//                                                                            pre($v3);
                                                                            //$smCost = $objCore->getPrice($v3['Methods'][0]['ShippingCost']);
                                                                            $smCostUSD = $v3['Methods'][0]['ShippingCost'];
                                                                            ?>
                                                                            <?php
//                                                                            echo '<pre>';
//                                                                            print_r($v3['Methods']);
                                                                            foreach ($v3['Methods'] as $kvv => $vv) {

                                                                                //if ($vv['tostate'] != 0 && $arrCustomerDetails[0]['ShippingState'] == $vv['tostate']) {
                                                                                    //if ($vv['tocity'] != 0 && $arrCustomerDetails[0]['ShippingCity'] == $vv['tocity']) {
                                                                                        $checked = '';
                                                                                        if ($ch == 0) {
                                                                                            $checked = 'checked="checked"';
                                                                                            $ch++;
                                                                                        }
                                                                                        ?>
                                                                                        <li>
                                                                                            <label>
                                                                                                <input type="radio" class="styled"
                                                                                                       name="proRad[<?php echo $kCart; ?>]"
                                                                                                       value="<?php echo $v3['Methods'][0]['fklogisticidvalue'] . '-' . $v3['Methods'][0]['shippingmethod'] . '-' . $vv['ShippingCost']; ?>"
                                                                                                       val="<?php echo $l; ?>"
                                                                                                       onclick="showShippingPrice(this, '',<?php echo (!empty($v3['Methods'][0]['fklogisticidvalue'])) ? $v3['Methods'][0]['shippingmethod'] : '0'; ?>, 'product',<?php echo $vCart['pkProductID']; ?>,<?php echo $vCart['qty']; ?>);" <?php echo $checked; ?>
                                                                                                       />
                                                                                                       <?php /* onclick="showShippingPrice(this,<?php echo $v3['Methods'][0]['fkShippingGatewaysID']; ?>,<?php echo (!empty($v3['Methods'][0]['pkShippingMethod'])) ? $v3['Methods'][0]['pkShippingMethod'] : '0'; ?>, 'product',<?php echo $vCart['pkProductID']; ?>,<?php echo $vCart['qty']; ?>);" <?php echo $checked; ?> */ ?>
                                                                                                <small>
                                                                                                    <?php echo $vv['MethodName']; ?>
                                                                                                    <span class="amt <?php echo $vv['ShippingCost']; ?>"><?php echo $objCore->getPrice($vv['ShippingCost']); ?></span>
                                                                                                </small>
                                                                                            </label>
                                                                                        </li>
                                                                                        <?php
                                                                                    //}
                                                                                //}
                                                                            }
                                                                            ?>
                                                                        </ul>
                                                                    </li>
                                                                    <?php
                                                                }
                                                            }
                                                            //$ch++;
                                                        } else {
                                                            $isShip = '0';
                                                            ?>
                                                            <li><span class="red fix-width"><?php echo NO_SHIPP_METHOD_AVAIL ?></span></li>
                                                        <?php }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="sub_total marg">
                                                <!--<h4>Total Cost</h4>-->
                                                <p><?php
                                                    $varCartSubTotal = ($varCartItemTotal) + ($objCore->getProductCalCurrencyPrice($vCart['ShippingDetails'][0]['Methods'][0]['ShippingCost']));
                                                    $varCartSubTotal2[] = ($varCartItemTotal) + ($objCore->getProductCalCurrencyPrice($vCart['ShippingDetails'][0]['Methods'][0]['ShippingCost']));
                                                    echo $_SESSION['SiteCurrencySign'] . ' ' . $varCartSubTotal;
                                                        ?></p>
                                            </div>
                                        </li>
                                        <?php
                                        $varDiscountCoupon += (float) $vCart['Discount'];
                                        $varCartTotal += $varCartSubTotal;
                                    }
                                    // pre($objPage->arrData['arrCartDetails']['Package']);
                                    foreach ($objPage->arrData['arrCartDetails']['Package'] as $kPKG => $vPKG) {
                                        $varCartItemTotal = $vPKG['qty'] * $objCore->getProductCalCurrencyPrice($vPKG['PackagePrice']);
                                        $productQuatity = 1;
                                        ?>
                                        <li class="myItem">
                                            <div class="thumb">
                                                <div class="border2">
                                                    <?php
                                                    $varSrc = $objCore->getImageUrl($vPKG['PackageImage'], 'package/161x148');
                                                    ?>
                                                    <a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>"><img src="<?php echo $varSrc; ?>" alt="<?php echo $vPKG['PackageName']; ?>"  /></a>
                                                </div>
                                            </div>
                                            <div class="left_product">
                                                <a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>"><h4><?php echo $vPKG['PackageName']; ?></h4></a>
                                                <span class="package_products">
                                                    <?php
                                                    echo $vPKG['productDetail'];
                                                    ?>
                                                </span>
                                                <span><?php echo BY; ?> : <a href="<?php echo $objCore->getUrl('wholesaler_profile_customer_view.php', array('action' => 'view', 'wid' => $vPKG['fkWholesalerID'])); ?>"><small><?php echo $vPKG['CompanyName']; ?></small></a></span>
                                                <p><small><?php echo PACKAGE; ?></small> </p>
                                            </div>
                                            <div class="price_sec marg">
                                                <h4>Package Cost</h4>
                                                <p><?php echo $_SESSION['SiteCurrencySign'] . ' ' . $varCartItemTotal; ?></p>
                                            </div>
                                            <div class="shipping_type">
                                                <!--<h4>Shipping Method</h4>-->
                                                <div class="sgm" id="<?php echo $i; ?>">
                                                    <ul class="radio_list scroll-pane" id="<?php echo 'pkg' . $vPKG['pkPackageId']; ?>">
                                                        <?php
                                                        $i++;
                                                        $l = 0;
                                                        if (count($vPKG['ShippingDetails']) > 0) {

                                                            foreach ($vPKG['ShippingDetails'] as $k3 => $v3) {

                                                                $display = ($k3 == 0) ? 'block' : 'block';
                                                                ?>
                                                                <li>
                                                                    <h5><?php echo $v3['ShippingTitle'] ?></h5>
                                                                    <ul>
                                                                        <?php
                                                                        foreach ($v3['Methods'] as $km => $vm) {
                                                                            $l++;
                                                                            $checked = '';
                                                                            $smCost = $objCore->getPrice($vm['ShippingCost']);
                                                                            $smCostUSD = $vm['ShippingCost'];

                                                                            if ($l == 1) {
                                                                                $checked = 'checked="checked"';
                                                                            }
                                                                            ?>
                                                                            <li>
                                                                                <label>
                                                                                    <input type="radio" class="styled" name="pkgRad[<?php echo $kPKG; ?>]" value="<?php echo $vm['fkShippingGatewayID'] . '-' . $vm['pkShippingMethod'] . '-' . $smCostUSD; ?>" onclick="showShippingPrice(this,<?php echo $vm['fkShippingGatewayID']; ?>,<?php echo $vm['pkShippingMethod']; ?>, 'package',<?php echo $vPKG['pkPackageId']; ?>,<?php echo $vPKG['qty']; ?>);" <?php echo $checked; ?> />
                                                                                    <?php echo html_entity_decode(trim($vm['MethodName']), null, 'utf-8'); ?>
                                                                                    <span class="amt"><?php echo $smCost; ?></span>
                                                                                </label>
                                                                            </li>
                                                                        <?php } ?>
                                                                    </ul>
                                                                </li>
                                                                <?php
                                                            }
                                                        } else {
                                                            $isShip = '0';
                                                            ?>
                                                            <li><span class="red fix-width"><?php echo NO_SHIPP_METHOD_AVAIL ?></span></li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="sub_total marg">
                                                <!--<h4>Total Cost</h4>-->
                                                <p><?php
                                                        //$varCartSubTotal = $varCartItemTotal + $vPKG['ShippingDetails'][0]['Methods'][0]['ShippingCost'];
                                                        // echo $objCore->getPrice($varCartSubTotal);
                                                        $varCartSubTotal = ($varCartItemTotal) + ($objCore->getProductCalCurrencyPrice($vPKG['ShippingDetails'][0]['Methods'][0]['ShippingCost']));
                                                        $varCartSubTotal2[] = ($varCartItemTotal) + ($objCore->getProductCalCurrencyPrice($vPKG['ShippingDetails'][0]['Methods'][0]['ShippingCost']));
                                                        echo $_SESSION['SiteCurrencySign'] . ' ' . $varCartSubTotal;
                                                        ?>
                                                </p>
                                            </div>

                                        </li>
                                        <?php
                                        $varCartTotal += $varCartSubTotal;
                                    }

//$giftCardCount=0;                 
//pre($objPage->arrData);
                                    foreach ($objPage->arrData['arrCartDetails']['GiftCard'] as $key => $giftCards) {
                                        $varCartItemTotal = $giftCards['qty'] * $objCore->getProductCalCurrencyPrice($giftCards['amount']);
                                        $productQuatity = 1;
                                        ?>

                                        <li class="myItem">
                                            <div class="thumb">
                                                <div class="border2">
                                                    <?php
                                                    $varSrc = $objCore->getImageUrl('', 'gift_card');
                                                    ?>
                                                    <img src="<?php echo $varSrc; ?>" alt="<?php echo $giftCards['message']; ?>" />
                                                </div>
                                            </div>
                                            <div class="left_product">
                                                <h4><?php echo strtoupper(GIFT_CARD); ?><?php //echo $giftCards['message'];         ?></h4>
                                                <span><?php echo BY; ?> : <small><?php echo $giftCards['fromName']; ?></small></span>
                                                <p><small><?php echo $giftCards['message']; ?></small> </p>
                                            </div>
                                            <div class="price_sec marg">
                                                <h4>Gift Cost</h4>
                                                <p><?php echo $_SESSION['SiteCurrencySign'] . ' ' . $varCartItemTotal; ?></p>
                                            </div>
                                            <div class="shipping_type">
                                                <p class="na">NA</p>
                                            </div>
                                            <div class="sub_total marg">
                                                <!--<h4>Total Cost</h4>-->
                                                <p><?php
                                                $varCartSubTotal = $varCartItemTotal;
                                                $varCartSubTotal2[] = $varCartItemTotal;
                                                echo $_SESSION['SiteCurrencySign'] . ' ' . $varCartSubTotal;

                                                // echo $objCore->getPrice($varCartSubTotal); 
                                                    ?></p>
                                            </div>
                                        </li>
                                        <?php
                                        $varCartTotal += $varCartSubTotal;
                                    }
                                    ?>
                                </ul>
                                <div class="shoping_bottom_sec" style="padding-bottom:0px;"><div style=" margin-bottom: 110px;
                                                                                                 background: #f6f6f6;
                                                                                                 padding: 5px;
                                                                                                 height:38px;
                                                                                                 ">  <a class="back_shoping clear_cart" href="<?php echo $objCore->getUrl('shopping_cart.php'); ?>">Back to Shopping Cart</a><a href="<?php echo SITE_ROOT_URL; ?>" class="con_shoping countinue_shopping"><?php echo CON_SHOPING; ?></a>
                                        <input type="hidden" name="UpdateMyCart" value="<?php echo PROCESSED_TO; ?>" />
                                        <input type="button" class="shopping_update2" value="<?php echo PROCESSED_TO; ?>" />
                                    </div></div>

                                <?php /* <div class="shoping_bot_left boxes boxes_width">
                                  <div class="shipping_information" style="float: left;margin-right: 0PX;MARGIN-LEFT: 1px;width: 547px !important;">
                                  <div class="heading"> <h3>Current Shipping Information</h3>
                                  <a href="run_time_shipping_address.php" class="edit_btn_o"><i class="fa fa-pencil"></i> Edit</a>
                                  </div>
                                  <ul>
                                  <li><span>Recipient First Name <strong>:</strong></span> <small>  <?php echo $arrCustomerDetails[0]['ShippingFirstName']; ?></small></li>
                                  <li><span>Recipient Last Name<strong>:</strong></span>  <small>  <?php echo $arrCustomerDetails[0]['ShippingLastName']; ?></small></li>
                                  <li><span>Organization Name<strong>:</strong></span>  <small> <?php echo $arrCustomerDetails[0]['ShippingOrganizationName']; ?></small></li>
                                  <li><span>Address Line 1<strong>:</strong> </span>  <small>  <?php echo $arrCustomerDetails[0]['ShippingAddressLine1']; ?></small></li>
                                  <li><span>Address Line 2<strong>:</strong></span>  <small>  <?php echo $arrCustomerDetails[0]['ShippingAddressLine2']; ?></small></li>
                                  <li><span>Country<strong>:</strong></span>  <small>  <?php echo $arrCustomerDetails[0]['ShippingCountryName']; ?></small></li>
                                  <li><span>Post Code or Zip Code <strong>:</strong></span>  <small>  <?php echo $arrCustomerDetails[0]['ShippingPostalCode']; ?></small></li>
                                  </ul>
                                  </div>
                                  </div> */ ?>
                                <div class="shoping_bot_right"><div class="total_box">CART TOTALS<span></span></div>
                                    <ul class="total_sec">
                                        <li>
                                            <span>Sub Total</span>
                                            <strong id="subTot"><?php echo $_SESSION['SiteCurrencySign'] . ' ' . array_sum($varCartSubTotal2); // echo $objCore->getPrice($varCartTotal);          ?></strong>
                                        </li>
                                        <li>
                                            <span>Discount (Coupon)</span>
                                            <strong>-<strong id="discountTot" style="padding-left:0px;"><?php echo $objCore->getPrice($varDiscountCoupon); ?></strong></strong>
                                        </li>
                                        <li class="last">
                                            <span>Grand Total</span>
                                            <strong id="grandTot"><?php
                                $varGrandTotal = array_sum($varCartSubTotal2) - $objCore->getProductCalCurrencyPrice($varDiscountCoupon);
                                echo $_SESSION['SiteCurrencySign'] . ' ' . $varGrandTotal;
                                ?>
                                            </strong>
                                        </li>
                                    </ul>
                                    <ul>

                                        <?php
                                        if ($varGrandTotal < MINIMUM_ORDER_PRICE) {
                                            ?>
                                            <li>
                                                <input type="submit" name="MinimumOrder" class="minimum_order" value="<?php echo 'Minmum Order is' . ' ' . $objCore->getPrice(MINIMUM_ORDER_PRICE); ?>" />
                                                <input type="hidden" id="GrandTot" value="<?php echo $varGrandTotal; ?>"/>
                                                <input type="hidden" name="UpdateMyCart" value="<?php echo PROCESSED_TO; ?>" />
                                            </li>
                                            <?php
                                        } else {
                                            ?>
                                            <!-- <li class="proceed2">
                                                 <input type="submit" name="UpdateMyCart" class="shopping_update2" value="<?php echo PROCESSED_TO; ?>" />
                                             </li>-->
                                        <?php } ?>

                                    </ul>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
        <script type="text/javascript">
            msgC = 1;
            $(document).ready(function () {

                var ship = '<?php echo $isShip ?>';
                var productQuatity = '<?php echo $productQuatity ?>';
                //alert(productQuatity);
                var erMess = $('.successMessage').find('.error').html();
                var svMsg = erMess;
                $('.shopping_update2').on('click', function () {
                    var attr = $('*').hasClass('successMessage') ? "1" : "2";

                    if (ship == '0') {
                        if (parseInt(msgC) == 1) {
                            $(this).parent().before('<div id="shippingQuantityAlert"><span style="color:red;font-size:12px;">Shipping is mandatory for all product</span></div>');
                            msgC = 2;
                        }
                        setTimeout(function () {
                            $('#shippingQuantityAlert').remove();
                            msgC = 1;
                        }, 8000);

                        return false;
                    }
                    if (parseInt(attr) == 1) {
                        if (parseInt(msgC) == 1) {
                            $(this).parent().before('<div id="shippingQuantityAlert"><span style="color:red;font-size:12px;">' + svMsg + '</span></div>');
                            msgC = 2;
                        }
                        setTimeout(function () {
                            $('#shippingQuantityAlert').remove();
                            msgC = 1;
                        }, 8000);

                    } else if (parseInt(productQuatity) == 0) {
                        if (parseInt(msgC) == 1) {
                            $(this).parent().before('<div id="shippingQuantityAlert"><span style="color:red;font-size:12px;"> The quantity you have entered is out of stock</span></div>');
                            msgC = 2;
                        }
                        setTimeout(function () {
                            $('#shippingQuantityAlert').remove();
                            msgC = 1;
                        }, 8000);
                    } else {
                        $('#shippingForm').submit();
                    }
                });

                $(".myItem").each(function () {
                    if ($(this).find('.red').html() != undefined) {
                        $(this).css('background', '#eee', 'width', '200px');
                    }
                });
            });
        </script>
    </body>
</html>