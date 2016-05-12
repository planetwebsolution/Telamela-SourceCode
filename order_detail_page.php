<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_ORDER_PAGE_CTRL;
//pre($_POST);
//pre($_SESSION['MyCart']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Order Detail Page</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <link rel="stylesheet" type="text/css" href="common/css/layout1.css"/>
        <style>
            .comment_box label{ width:168px;}
            .total_amount ul li.pay_button a{ padding: 0 5px 0 7px;
                                              margin-left: 6px;}
            </style>
        </head>
        <body>
            <div id="navBar">
                <?php include_once 'common/inc/top-header.inc.php'; ?>
        </div>
        <div class="header" style=" border:none"><div class="layout"></div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>

        </div>
        <div id="ouderContainer" class="ouderContainer_1">
            <div class="layout">

                <div class="add_pakage_outer">
                    <div class="top_container">
                        <div class="top_header border_bottom">
                            <h1>Order Details</h1>
                        </div>
                    </div>
                    <div class="body_inner_bg">
                        <div class="add_edit_pakage order_details">
                            <form action="payment.php" name="payNow" method="post">
                                <div class="boxes boxes_width">
                                    <div class="account_information" style="margin-left:0px">
                                        <div class="heading">
                                            <h3>Account Information</h3>
                                        </div>
                                        <ul>
                                            <li><span>Your Name <strong>:</strong></span> <small> <?php echo $objPage->arrData['CustomerDeatails'][0]['CustomerFirstName'] . ' ' . $objPage->arrData['CustomerDeatails'][0]['CustomerLastName']; ?></small></li>
                                            <li><span>Your Email <strong>:</strong> </span> <a href="mailto:<?php echo $objPage->arrData['CustomerDeatails'][0]['CustomerEmail']; ?>"> <?php echo $objPage->arrData['CustomerDeatails'][0]['CustomerEmail']; ?></a></li>
                                            <li><span>Mobile <strong>:</strong> </span><small><?php echo $objPage->arrData['CustomerDeatails'][0]['BillingPhone']; ?></small></li>
                                        </ul>
                                    </div>
                                    <div class="shipping_handling" style="height: 159px;">
                                        <div class="heading"><h3>Shipping &amp; Handling Information</h3>
                                        </div>
                                        <ul>
                                            <li><span>Shipping Charges</span> : <?php echo $objCore->getPrice($objPage->arrData['ShippingCost']); ?></li>
                                            <li><p>&nbsp;</p></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="boxes boxes_width">
                                    <div class="billing_information" style="margin-left:0px;">
                                        <div class="heading"> <h3>Billing Information</h3>
                                            <a href="billing_and_shipping_address.php" class="edit_btn_o"><i class="fa fa-pencil"></i> Edit</a></div>
                                        <ul>
                                            <li><span>Recipient First Name <strong>:</strong></span> <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['BillingFirstName']; ?></small></li>
                                            <li><span>Recipient Last Name<strong>:</strong></span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['BillingLastName']; ?></small></li>
                                            <li><span>Organization Name<strong>:</strong></span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['BillingOrganizationName']; ?></small></li>
                                            <li><span>Address Line 1<strong>:</strong> </span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['BillingAddressLine1']; ?></small></li>
                                            <li><span>Address Line 2<strong>:</strong></span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['BillingAddressLine2']; ?></small></li>
                                            <li><span>Country<strong>:</strong></span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['BillingCountryName']; ?></small></li>
                                            <li><span>Post Code or Zip Code <strong>:</strong></span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['BillingPostalCode']; ?></small></li>
                                        </ul>
                                    </div>
                                    <?php
                                    //pre($objPage->arrData['CustomerDeatails']);

                                    if ($_SESSION['RunShippingID'] == 1) {
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingFirstName'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingFirstName'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingLastName'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingLastName'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingOrganizationName'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingOrganizationName'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingAddressLine1'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingAddressLine1'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingAddressLine2'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingAddressLine2'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingCountry'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingCountry'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingCountryName'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingCountryName'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingPostalCode'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingPostalCode'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingPhone'] = $objPage->arrData['CustomerDeatails'][0]['1_ShippingPhone'];
                                    } else if ($_SESSION['RunShippingID'] == 2) {
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingFirstName'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingFirstName'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingLastName'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingLastName'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingOrganizationName'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingOrganizationName'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingAddressLine1'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingAddressLine1'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingAddressLine2'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingAddressLine2'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingCountry'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingCountry'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingCountryName'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingCountryName'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingPostalCode'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingPostalCode'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingPhone'] = $objPage->arrData['CustomerDeatails'][0]['2_ShippingPhone'];
                                    } else {
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingFirstName'] = $objPage->arrData['CustomerDeatails'][0]['ShippingFirstName'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingLastName'] = $objPage->arrData['CustomerDeatails'][0]['ShippingLastName'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingOrganizationName'] = $objPage->arrData['CustomerDeatails'][0]['ShippingOrganizationName'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingAddressLine1'] = $objPage->arrData['CustomerDeatails'][0]['ShippingAddressLine1'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingAddressLine2'] = $objPage->arrData['CustomerDeatails'][0]['ShippingAddressLine2'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingCountry'] = $objPage->arrData['CustomerDeatails'][0]['ShippingCountry'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingCountryName'] = $objPage->arrData['CustomerDeatails'][0]['ShippingCountryName'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingPostalCode'] = $objPage->arrData['CustomerDeatails'][0]['ShippingPostalCode'];
                                        $objPage->arrData['CustomerDeatails'][0]['ShippingPhone'] = $objPage->arrData['CustomerDeatails'][0]['ShippingPhone'];
                                    }
                                    ?>
                                    <div class="shipping_information" style="float: left;margin-right: 0PX;MARGIN-LEFT: 1px;">
                                        <div class="heading"> <h3>Shipping Information</h3>
                                            <a href="billing_and_shipping_address.php" class="edit_btn_o"><i class="fa fa-pencil"></i> Edit</a>
                                        </div>
                                        <ul>
                                            <li><span>Recipient First Name <strong>:</strong></span> <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['ShippingFirstName']; ?></small></li>
                                            <li><span>Recipient Last Name<strong>:</strong></span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['ShippingLastName']; ?></small></li>
                                            <li><span>Organization Name<strong>:</strong></span>  <small> <?php echo $objPage->arrData['CustomerDeatails'][0]['ShippingOrganizationName']; ?></small></li>
                                            <li><span>Address Line 1<strong>:</strong> </span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['ShippingAddressLine1']; ?></small></li>
                                            <li><span>Address Line 2<strong>:</strong></span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['ShippingAddressLine2']; ?></small></li>
                                            <li><span>Country<strong>:</strong></span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['ShippingCountryName']; ?></small></li>
                                            <li><span>Post Code or Zip Code <strong>:</strong></span>  <small>  <?php echo $objPage->arrData['CustomerDeatails'][0]['ShippingPostalCode']; ?></small></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="scrollable">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <th align="center">Items Ordered</th>
                                            <th align="center">Price</th>
                                            <th align="center">Qty.</th>
                                            <th align="center">SubTotal</th>
                                            <th align="center">Discount</th>
                                            <th align="right" class="last">Grand Total</th>
                                        </tr>
                                        <?php
                                        $varRowSubTotal = 0;
                                        $varRowGrantTotal = 0;
                                        $varCartSubTotal = 0;
                                        $varDiscountCoupon = 0;
                                        $varDiscountGiftCart = 0;
                                        $i = 0;
                                        $noQuantity = array();

                                        // pre($objPage->arrData['arrCartDetails']);

                                        foreach ($objPage->arrData['arrCartDetails']['Product'] as $keyCart => $valCart) {

                                            $varClass = ($i++ % 2 == 0) ? 'odd' : 'even';
                                            $varRowSubTotal = $objCore->getProductCalCurrencyPrice($valCart['FinalPrice']) * $valCart['qty'];
                                            $varDiscountCoupon = (float) $valCart['Discount'];
                                            $varRowGrantTotal = $varRowSubTotal - $objCore->getProductCalCurrencyPrice($varDiscountCoupon);
                                            $varRowGrantTotal2[] = $varRowSubTotal - $objCore->getProductCalCurrencyPrice($varDiscountCoupon);
                                            $vProduct = $objCore->verifyProductQuantity($valCart['pkProductID'], $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$keyCart]['qty']);
                                            if ($vProduct > 0) {
                                                $noQuantity['products'][] = $valCart['ProductName'];
                                            }
                                            ?>
                                            <tr class="<?php echo $varClass; ?>">
                                                <td align="center" class="border_left"><a  href="<?php echo $objCore->getUrl('product.php', array('id' => $valCart['pkProductID'], 'name' => $valCart['ProductName'], 'refNo' => $valCart['ProductRefNo'])); ?>"><?php echo $valCart['ProductName']; ?></a><br/><span><?php echo $valCart['attribute']; ?></span></td>
                                                <td align="center"><?php echo $objCore->getPrice($valCart['FinalPrice']); ?></td>
                                                <td align="center"><?php echo $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$keyCart]['qty']; ?></td>
                                                <td align="center"><?php echo $_SESSION['SiteCurrencySign'] . ' ' . $varRowSubTotal; ?></td>
                                                <td align="center"><?php echo $objCore->getPrice($varDiscountCoupon); ?></td>
                                                <td align="right" class="last"><?php echo $_SESSION['SiteCurrencySign'] . ' ' . $varRowGrantTotal; ?></td>
                                            </tr>
                                            <?php
                                            $varCartSubTotal +=$varRowGrantTotal;
                                        }

                                        // pre($objPage->arrData['arrCartDetails']['Package']);
                                        foreach ($objPage->arrData['arrCartDetails']['Package'] as $keyCart => $valCart) {
                                            $varClass = ($i++ % 2 == 0) ? 'odd' : 'even';
                                            $varRowSubTotal = $objCore->getProductCalCurrencyPrice($valCart['PackagePrice']) * $valCart['qty'];
                                            $varDiscountCoupon = (float) $valCart['Discount'];
                                            $varRowGrantTotal = $varRowSubTotal - $objCore->getProductCalCurrencyPrice($varDiscountCoupon);
                                            $varRowGrantTotal2[] = $varRowSubTotal - $objCore->getProductCalCurrencyPrice($varDiscountCoupon);
                                            $vPackage = $objCore->verifyPackageQuantity($valCart['pkPackageId'], $_SESSION['MyCart']['Package'][$valCart['pkPackageId']][$keyCart]['qty']);
                                            if ($vPackage > 0) {
                                                $noQuantity['package'][] = $valCart['PackageName'];
                                            }
                                            ?>
                                            <tr class="<?php echo $varClass; ?>">
                                                <td align="center" class="border_left">
                                                    <a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $valCart['pkPackageId'])); ?>"><?php echo $valCart['PackageName']; ?></a>
                                                    <br/><span><?php echo $valCart['productDetail']; ?></span>
                                                </td>
                                                <td align="center"><?php echo $objCore->getPrice($valCart['PackagePrice']); ?></td>
                                                <td align="center"><?php echo $_SESSION['MyCart']['Package'][$valCart['pkPackageId']][$keyCart]['qty']; ?></td>
                                                <td align="center"><?php echo $_SESSION['SiteCurrencySign'] . ' ' . $varRowSubTotal; ?></td>
                                                <td align="center"><?php echo $objCore->getPrice($varDiscountCoupon); ?></td>
                                                <td align="right" class="last"><?php echo $_SESSION['SiteCurrencySign'] . ' ' . $varRowGrantTotal; ?></td>
                                            </tr>
                                            <?php
                                            $varCartSubTotal +=$varRowGrantTotal;
                                        }
                                        foreach ($objPage->arrData['arrCartDetails']['GiftCard'] as $keyCart => $valCart) {
                                            $varClass = ($i++ % 2 == 0) ? 'odd' : 'even';
                                            $varRowSubTotal = $objCore->getProductCalCurrencyPrice($valCart['amount']) * $valCart['qty'];

                                            $varRowGrantTotal = $varRowSubTotal;
                                            $varRowGrantTotal2[] = $varRowSubTotal;
                                            $vGift = $objCore->verifyGiftCartQuantity($valCart['pkGiftCardID'], $valCart['qty']);
                                            if ($vGift > 0) {
                                                $noQuantity['gift'][] = $valCart['PackageName'];
                                            }
                                            ?>
                                            <tr class="<?php echo $varClass; ?>">
                                                <td align="center" class="border_left"><?php echo ucwords(GIFT_CARD); ?></td>                                                
                                                <td align="center"><?php echo $objCore->getPrice($valCart['amount']); ?></td>
                                                <td align="center"><?PHP echo $valCart['qty']; ?></td>
                                                <td align="center"><?php echo $_SESSION['SiteCurrencySign'] . ' ' . $varRowSubTotal; ?></td>
                                                <td align="center"><?php echo $objCore->getPrice('0.00'); ?></td>
                                                <td align="right" class="last"><?php echo $_SESSION['SiteCurrencySign'] . ' ' . $varRowGrantTotal; ?></td>
                                            </tr>
                                            <?php
                                            $varCartSubTotal +=$varRowGrantTotal;
                                        }
                                        ?>
                                    </table>
                                </div>
                                <?php if (count($noQuantity) > 0) { ?>
                                    <div class="scrollable">
                                        <h2>Product who have less quantity then order</h2>
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                            <tr>
                                                <th align="center">Items Ordered</th>
                                                <th align="center">Items type</th>

                                            </tr>

                                            <?php
                                            foreach ($noQuantity['products'] as $key => $pVal) {
                                                $varClass = ($key++ % 2 == 0) ? 'odd' : 'even';
                                                ?>
                                                <tr class="<?php echo $varClass; ?>">
                                                    <td align="center" class="border_left"><?php echo $pVal; ?></td>
                                                    <td align="center">Product</td>
                                                </tr>  
                                            <?php } ?>
                                            <?php
                                            foreach ($noQuantity['package'] as $key => $pVal) {
                                                $varClass = ($key++ % 2 == 0) ? 'odd' : 'even';
                                                ?>
                                                <tr class="<?php echo $varClass; ?>">
                                                    <td align="center" class="border_left"><?php echo $pVal; ?></td>
                                                    <td align="center">Package</td>
                                                </tr>  
                                            <?php } ?>
                                            <?php
                                            foreach ($noQuantity['gift'] as $key => $pVal) {
                                                $varClass = ($key++ % 2 == 0) ? 'odd' : 'even';
                                                ?>
                                                <tr class="<?php echo $varClass; ?>">
                                                    <td align="center" class="border_left"><?php echo $pVal; ?></td>
                                                    <td align="center">Gift</td>
                                                </tr>  
                                            <?php } ?>

                                        </table>
                                    </div>  
                                <?php }
                                ?>
                                <div class="last_box">
                                    <div class="comment_box">
                                        <label>Comments History</label>
                                        <textarea cols="5" rows="5" name="frmComment" placeholder="Add Order Comment"></textarea>
                                    </div>
                                    <div class="total_amount">
                                        <h3>Cart totals<span></span></h3>

                                        <ul>
                                            <li><small>Sub Total</small> <span><?php echo $_SESSION['SiteCurrencySign'] . ' ' . array_sum($varRowGrantTotal2); ?></span></li>
                                            <li><small>Shipping &amp; Handling</small> <span><?php echo $objCore->getPrice($objPage->arrData['ShippingCost']); ?></span></li>
                                            <li><small>Grand Total</small>
                                                <span>
                                                    <?php
                                                    $varCartGrantTotal = array_sum($varRowGrantTotal2) + $objCore->getProductCalCurrencyPrice($objPage->arrData['ShippingCost']);
                                                    echo $_SESSION['SiteCurrencySign'] . ' ' . $varCartGrantTotal;
                                                    ?>
                                                </span>
                                            </li>
                                            <?php
                                            if ($varCartGrantTotal < MINIMUM_ORDER_PRICE) {
                                                $_SESSION['MyCart']['Common']['IsMinimum'] = '1';
                                                ?>
                                                <li>
                                                    <b class="red">Minimum order is <?php echo $objCore->getPrice(MINIMUM_ORDER_PRICE); ?>. <br/>You have to pay <?php echo $objCore->getPrice(MINIMUM_ORDER_PRICE); ?> for this order.</b>
                                                </li>
                                                <?php
                                            }
                                            ?>


                                        </ul>

                                        <div  class="pay_button"><a class="back_shoping" href="<?php echo $objCore->getUrl('shipping_charge.php'); ?>">Back to Shipping</a>
                                            <?php
                                            if (count($noQuantity) > 0) {
                                                echo '<span style="color:red;font-size:12px;">Please check which product have less quantity then order</span>';
                                            } else {
                                                ?>   
                                                <a href="javascript:void(0)" onclick="document.payNow.submit()" class="cart_link countinue_shopping " style="padding:3px 0px; height:auto;">Pay Now</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        //unset($_SESSION['MyCart']['CouponCode']);
        include_once 'common/inc/footer.inc.php';
        ?>
    </body>
</html>



