<div id="nt-example1-container" <?php echo ($cartD['Common']['CartCount'] > 0) ? 'style="display:block;"' : 'style="display:none;"'; ?>> <a href="#" class="topCartClose"><img src="<?php echo IMAGE_PATH_URL ?>cross-hover.png" style="float:right;"/></a>
    <div class="fixed_card">My Cart (<span id="cartValue2"><?php echo (int) $cartD['Common']['CartCount']; ?></span>)</div>
    <i  class="fa fa-angle-up" id="nt-example1-prev"></i>
    <ul id="nt-example1" class="cart_complete">
        <?php
        if ($cartD['Common']['CartCount'] > 0)
        {
            $varCartSubTotal = 0;
            $varCartTotal = 0;
            $varDiscountCoupon = 0;
            $i = 0;
            foreach ($cartD['Product'] as $kCart => $vCart)
            {
                $varCartSubTotal = $_SESSION['MyCart']['Product'][$vCart['pkProductID']][$kCart]['qty'] * $vCart['FinalPrice'];
                ?>
                <li class="RemoveFromCart<?php echo $vCart['pkProductID']; ?>">
                    <div class="cart_img"> <a  href="<?php echo $objCore->getUrl('product.php', array('id' => $vCart['pkProductID'], 'name' => $vCart['ProductName'], 'refNo' => $vCart['ProductRefNo'])); ?>"> <img  src="<?php echo $objCore->getImageUrl($vCart['ImageName'], 'products/' . $arrProductImageResizes['cart']); ?>" alt="<?php echo $vCart['ProductName']; ?>" border="0" class="remove_cart"/> </a> </div>
                    <div class="clr_1"></div>
                    <div class="new_heading" style="margin-top:10px"> <a href="<?php echo $objCore->getUrl('product.php', array('id' => $vCart['pkProductID'], 'name' => $vCart['ProductName'], 'refNo' => $vCart['ProductRefNo'])); ?>" class="product_name rgt-my-cart"><?php echo ucfirst($objCore->getProductName($vCart['ProductName'], 15)); ?></a>
                        <?php // echo $objCore->getProductName($vCart['ProductName'], 15);  ?>
                    </div>
                    <div class="cart_content"><?php echo isset($vCart['ProductDescription']) && $vCart['ProductDescription'] != '' ? $objCore->getProductName($vCart['ProductDescription'], 23) : 'Lorem ipsum dolor sit amet'; ?></div>
                    <div class="cart_price">
                        <?php
                        if ($vCart['DiscountPrice1'] != 0)
                        {
                            echo $objCore->getFinalPrice($vCart['FinalPrice'], $vCart['DPrice'], 0, 0, 1);
                        }
                        else
                        {
                            echo $objCore->getPrice($vCart['FinalPrice']);
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
            foreach ($cartD['Package'] as $kPKG => $vPKG)
            {
                $varCartSubTotal = $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty'] * $vPKG['PackagePrice'];
                $counter2++;
                ?>
                <li class="RemoveFromCartPkg<?php echo $vPKG['pkPackageId']; ?>">
                    <div class="cart_img">
                        <?php
                        $varSrc = $objCore->getImageUrl($vPKG['PackageImage'], 'package/' . PACKAGE_IMAGE_RESIZE1);
                        ?>
                        <a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>"> <img src="<?php echo $varSrc; ?>" alt="<?php echo $valCart['PackageName']; ?>" border="0" class="remove_cart"/> </a> </div>
                    <div class="clr_1"></div>
                    <div class="new_heading" style="margin-top:10px"> <?php echo $objCore->getProductName($vPKG['PackageName'], 15); ?> </div>
                    <div class="cart_content">Lorem ipsum dolor sit amet</div>
                    <div class="cart_price"><?php echo $objCore->getPrice($vPKG['PackagePrice'] * $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']); ?></div>
                </li>
                <?php
                $varCartTotal += $varCartSubTotal;
            }
            $giftCardCount = 0;
            foreach ($cartD['GiftCard'] as $key => $giftCards)
            {
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
                    <div class="new_heading" style="margin-top:10px"> <?php echo $objCore->getProductName($giftCards['message'], 15); ?> </div>
                    <div class="cart_content">Lorem ipsum dolor sit amet</div>
                    <div class="cart_price"><?php echo $objCore->getPrice($giftCards['amount'] * $_SESSION['MyCart']['GiftCard'][$key]['qty']); ?></div>
                </li>
                <?php
            }
        }
        ?>
    </ul>
    <i  class="fa fa-angle-down" id="nt-example1-next"></i>
</div>
<!--  Right cart section end here -->
