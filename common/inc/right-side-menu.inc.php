<!--<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>accordian.css"/>
<script type="text/javascript" src="<?php echo JS_PATH ?>accordian.js"></script>-->
<?php //$_SESSION['ForRewardPopup'] = 1; ?>
<div class="nt-example1-container" id="activity" <?php echo (!empty($_SESSION['ForRewardPopup']) ? 'style="display: none;"' : ''); ?>>
    <?php $_SESSION['ForRewardPopup'] = 0; ?>
    <a href="#" class="topCartClose"><img src="<?php echo IMAGE_PATH_URL ?>cross-hover.png" style="float:right;"/></a>
    <div id="accordian">
        <ul>         
            <li class="active">
                <h3>My Cart (<span id="cartValue2"><?php echo (int) $cartD['Common']['CartCount']; ?></span>)</h3>
                <?php
                if ($cartD['Common']['CartCount'] > 0) {
                    ?>
                    <ul  class="cart_complete nt-example1" style=" width:175px; overflow:auto">
                        <?php
                        $varCartSubTotal = 0;
                        $varCartTotal = 0;
                        $varDiscountCoupon = 0;
                        $i = 0;
                        foreach ($cartD['Product'] as $kCart => $vCart) {
                            $varCartSubTotal = $_SESSION['MyCart']['Product'][$vCart['pkProductID']][$kCart]['qty'] * $vCart['FinalPrice'];
                            ?>
                            <li class="RemoveFromCart<?php echo $vCart['pkProductID']; ?>">
                                <div class="cart_img"> <a  href="<?php echo $objCore->getUrl('product.php', array('id' => $vCart['pkProductID'], 'name' => $vCart['ProductName'], 'refNo' => $vCart['ProductRefNo'])); ?>"> <img  src="<?php echo $objCore->getImageUrl($vCart['ImageName'], 'products/' . $arrProductImageResizes['cart']); ?>" alt="<?php echo $vCart['ProductName']; ?>" border="0" class="remove_cart"/> </a> </div>
                                <div class="clr_1"></div>
                                <div class="new_heading" style="margin-top:10px"> <a href="<?php echo $objCore->getUrl('product.php', array('id' => $vCart['pkProductID'], 'name' => $vCart['ProductName'], 'refNo' => $vCart['ProductRefNo'])); ?>" class="product_name rgt-my-cart"><?php echo ucfirst($objCore->getProductName($vCart['ProductName'], 15)); ?></a>
        <?php // echo $objCore->getProductName($vCart['ProductName'], 15);    ?>
                                </div>
                                <div class="cart_content"><?php echo isset($vCart['ProductDescription']) && $vCart['ProductDescription'] != '' ? $objCore->getProductName($vCart['ProductDescription'], 23) : ''; ?></div>
                                <div class="cart_price">
        <?php
        if ($vCart['DiscountPrice1'] != 0) {
            echo $objCore->getFinalPrice($varCartSubTotal, $vCart['DPrice'], 0, 0, 1);
        } else {
            echo $objCore->getPrice($varCartSubTotal);
        }
        ?>
                                </div>
                            </li>
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
                            <li class="RemoveFromCartPkg<?php echo $vPKG['pkPackageId']; ?>">
                                <div class="cart_img">
                            <?php
                            $varSrc = $objCore->getImageUrl($vPKG['PackageImage'], 'package/161x148');
                            ?>
                                    <a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>"> <img src="<?php echo $varSrc; ?>" alt="<?php echo $valCart['PackageName']; ?>" border="0" class="remove_cart"/> </a> </div>
                                <div class="clr_1"></div>
                                <div class="new_heading" style="margin-top:10px"> <?php echo "Package"; ?> </div>
                                <div class="cart_content"><?php echo $objCore->getProductName($vPKG['PackageName'], 23); ?></div>
                                <div class="cart_price"><?php echo $objCore->getCurPrice($objCore->getProductCalCurrencyPrice($vPKG['PackagePrice']) * $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']); ?></div>
                            </li>
        <?php
        $varCartTotal += $varCartSubTotal;
    }
    $giftCardCount = 0;
    foreach ($cartD['GiftCard'] as $key => $giftCards) {
        $varCartSubTotal = $giftCards['qty'] * $giftCards['amount'];
        $giftCardCount++;
        ?>
                            <li>
                                <div class="cart_img">
                            <?php
                            //$varSrc = $objCore->getImageUrl('', 'gift_card');
                            ?>
                                    <img src="<?php echo SITE_ROOT_URL; ?>common/images/gift_icon_img.png" alt="<?php echo $giftCards['message']; ?>" class="gift_card"/> </div>
                                <div class="clr_1"></div>
                                <div class="new_heading" style="margin-top:10px"> <?php echo "Gift Card" ?> </div>
                                <div class="cart_content"><?php echo $objCore->getProductName($giftCards['message'], 23); ?></div>
                                <div class="cart_price"><?php echo $objCore->getCurPrice($objCore->getProductCalCurrencyPrice($giftCards['amount']) * $_SESSION['MyCart']['GiftCard'][$key]['qty']); ?></div>
                            </li>
                                    <?php
                                }
                                ?>

                    </ul>

                    <div class="slide_arrows right-menu-arrows">
                        <i  class="fa fa-angle-up nt-example1-prev" id=""></i>
                        <i  class="fa fa-angle-down nt-example1-next" id=""></i>
                    </div>
    <?php
}
?>
            </li>
<?php
if ($_SESSION['sessUserInfo']['type'] == 'customer') {
    ?>
                <li>
                    <h2 onclick="window.location = '<?php echo SITE_ROOT_URL; ?>my_rewards.php'">My Rewards (<span id="cartValue2" class="RewardPop"><?php echo (int) $arrCustomerRewards[0]['BalancedRewardPoints']; ?></span>)</h2>
                </li>
                <li>
                    <h3>My Saved List (<span><?php echo (int) count($arrSavedList); ?></span>)</h3>
                <?php
                if (count($arrSavedList) > 0) {
                    ?>
                        <ul  class="cart_complete nt-example2">
        <?php
        foreach ($arrSavedList as $key => $arrDetail) {
            ?>
                                <li>
                                    <div class="cart_img">
                                        <a  href="<?php echo $objCore->getUrl('product.php', array('id' => $arrDetail['pkProductID'], 'name' => $arrDetail['ProductName'], 'refNo' => $arrDetail['ProductRefNo'])); ?>">
                                            <img src="<?php echo $objCore->getImageUrl($arrDetail['ProductImage'], 'products/' . $arrProductImageResizes['cart']); ?>" alt="<?php echo $arrDetail['ProductName'] ?>"/>
                                        </a>
                                    </div>
                                    <div class="new_heading" style="margin-top:10px">
                                        <a href="<?php echo $objCore->getUrl('product.php', array('id' => $arrDetail['pkProductID'], 'name' => $arrDetail['ProductName'], 'refNo' => $arrDetail['ProductRefNo'])); ?>" class="product_name rgt-my-cart">
                                <?php echo ucfirst($objCore->getProductName($arrDetail['ProductName'], 15)); ?>
                                        </a>
                                    </div>
                                    <div class="cart_content"><?php echo $objCore->getProductName($arrDetail['ProductDescription'], 23); ?></div>
                                    <div class="cart_price">
            <?php
            if ($arrDetail['DiscountFinalPrice'] > 0) {
                echo $objCore->getFinalPrice($arrDetail['DiscountFinalPrice'], $arrDetail['FinalPrice'], 0, 0, 1);
            } else {
                echo $objCore->getPrice($arrDetail['FinalPrice']);
            }
            ?>
                                    </div>
                                </li>
                                        <?php
                                    }
                                    ?>

                        </ul>
                        <div class="slide_arrows right-menu-arrows">
                            <i  class="fa fa-angle-up nt-example2-prev" id=""></i>
                            <i  class="fa fa-angle-down nt-example2-next" id=""></i>
                        </div>
                                    <?php
                                }
                                ?>
                </li>
                        <?php
                    }
                    ?>
            <li>
                <h3>Recently Viewed (<span><?php echo (int) count($arrRecentViewData) ?></span>)</h3>
<?php
if (count($arrRecentViewData) > 0) {
    ?>
                    <ul class="cart_complete nt-example3">
                    <?php
                    foreach ($arrRecentViewData as $key => $arrDetail) {
                        ?>
                            <li>
                                <div class="cart_img">
                                    <a  href="<?php echo $objCore->getUrl('product.php', array('id' => $arrDetail['pkProductID'], 'name' => $arrDetail['ProductName'], 'refNo' => $arrDetail['ProductRefNo'])); ?>">
                                        <img  src="<?php echo $objCore->getImageUrl($arrDetail['ProductImage'], 'products/' . $arrProductImageResizes['cart']); ?>" alt="<?php echo $arrDetail['ProductName']; ?>" border="0" class="remove_cart"/>
                                    </a>
                                </div>
                                <div class="new_heading" style="margin-top:10px">
                                    <a href="<?php echo $objCore->getUrl('product.php', array('id' => $arrDetail['pkProductID'], 'name' => $arrDetail['ProductName'], 'refNo' => $arrDetail['ProductRefNo'])); ?>" class="product_name rgt-my-cart">
                        <?php echo ucfirst($objCore->getProductName($arrDetail['ProductName'], 15)); ?>
                                    </a>
                                </div>
                                <div class="cart_content">
                            <?php echo $objCore->getProductName($arrDetail['ProductDescription'], 23); ?>
                                </div>
                                <div class="cart_price">
        <?php
        if ($arrDetail['DiscountFinalPrice'] > 0) {
            echo $objCore->getFinalPrice($arrDetail['FinalPrice'], $arrDetail['DiscountFinalPrice'], 0, 0, 1);
        } else {
            echo $objCore->getPrice($arrDetail['FinalPrice']);
        }
        ?>
                                </div>
                            </li>
        <?php
    }
    ?>
                    </ul>

                    <div class="slide_arrows right-menu-arrows">
                        <i  class="fa fa-angle-up nt-example3-prev" id=""></i>
                        <i  class="fa fa-angle-down nt-example3-next" id=""></i>
                    </div>
                            <?php } ?>
            </li>
        </ul><!--accordian closed here-->
    </div>

</div>
<!--  Right menu section end here -->






<script type="text/javascript">
    $(document).ready(function () {

        var timeout;

        // Action on mouseover from pop-up
        $('#activity').on("mouseover", function (e) {
            clearTimeout(timeout);
        });

        // Action on mouseout from pop-up
        $('#activity').on("mouseout", function () {
            timeout = setTimeout(function () {
                $("#activity").fadeOut(1500);
            }, 15000);
        });

        timeout = setTimeout(function () {
            $("#activity").fadeOut(1500);
        }, 15000)

        
    });

</script>