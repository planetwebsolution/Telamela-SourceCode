<?php // pre($objPage->arrData['arrCartDetails']);  ?>

<div class="my_cart">
    <h5 onclick="window.location='<?php echo $objCore->getUrl('shopping_cart.php'); ?>'">My <span>Cart</span></h5>
    <?php if ($objPage->arrData['arrCartDetails']['Common']['CartCount'] != 0) { ?>
        <div class="my_cart_inner">
            <div <?php if (count($objPage->arrData['arrCartDetails']['Product']) + count($objPage->arrData['arrCartDetails']['Package']) + count($objPage->arrData['arrCartDetails']['GiftCard']) > LIST_CART_BOX_LIMIT) { ?> class="scroll-pane" <?php } ?>>

                <ul>
                    <?php
                    $varCartTotal = 0;
                    $varCartSubTotal = 0;
                    $i = 0;
                    foreach ($objPage->arrData['arrCartDetails']['Product'] as $kCart => $valCart) {
                        $varCartSubTotal = $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty'] * $valCart['FinalPrice'];
                        ?>
                        <li id="cart<?php echo $valCart['pkProductID']; ?>" class="cart<?php echo $i; ?>">
                            <div class="bottom_border">
                                <?php
                                $varSrc = $objCore->getImageUrl($valCart['ImageName'], 'products/' . $arrProductImageResizes['default']);
                                ?>
                                <div class="image"><a href="<?php echo $objCore->getUrl('product.php', array('id' => $valCart['pkProductID'], 'name' => $valCart['ProductName'], 'refNo' => $valCart['ProductRefNo'])); ?>"><img src="<?php echo $varSrc; ?>" alt="<?php echo $valCart['ProductName']; ?>" width="40" height="38" border="0" /></a>

                                </div>
                                <div class="details">
                                    <a href="<?php echo $objCore->getUrl('product.php', array('id' => $valCart['pkProductID'], 'name' => $valCart['ProductName'], 'refNo' => $valCart['ProductRefNo'])); ?>"><?php echo $objCore->getProductName($valCart['ProductName'], 15); ?></a><br />
                                    <span><?php echo $valCart['attribute']; ?></span><br/>
                                    <span class="amt_qty"><?php echo $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty']; ?> x <?php echo $objCore->getPrice($valCart['FinalPrice']); ?></span>
                                    <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                </div></div>
                            <div class="delete"><a href="#" onclick="RemoveProductFromCart(<?php echo $valCart['pkProductID']; ?> , <?php echo $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty']; ?>,'<?php echo $kCart; ?>');"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" border="0" /></a></div>
                        </li>
                        <?php
                        $i++;
                        $varCartTotal += $varCartSubTotal;
                    }

                    $counter2=0;
                    foreach ($objPage->arrData['arrCartDetails']['Package'] as $kPKG => $vPKG) {
                        $varCartSubTotal = $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty'] * $vPKG['PackagePrice'];
                        $counter2++;
                        ?>
                        <li id="cart<?php echo $vPKG['pkProductID']; ?>" class="cart<?php echo $counter2; ?>">
                            <div class="bottom_border">
                                <?php
                                
                                $varPackageSrc = $objCore->getImageUrl($vPKG['PackageImage'], 'package/' . PACKAGE_IMAGE_RESIZE1);
                                ?>
                                <div class="image">
                                    <a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>"><img src="<?php echo $varPackageSrc; ?>" alt="<?php echo $vPKG['PackageName']; ?>" width="40" height="38" border="0" /></a>
                                </div>
                                <div class="details">
                                    <a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>"><?php echo ucfirst($vPKG['PackageName']); ?></a><br />
                                    <span class="amt_qty"><?PHP echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']; ?> x <?php echo $objCore->getPrice($vPKG['PackagePrice']); ?></span>
                                    <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                </div></div>
                            <div class="delete"><a href="#" onclick="RemovePackageFromCart(<?php echo $vPKG['pkPackageId']; ?>,<?PHP echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']; ?>,'<?php echo $kPKG; ?>');"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" border="0" /></a></div>
                        </li>
                        <?php
                        $varCartTotal += $varCartSubTotal;
                    }
                    $counter3=0;
                    foreach ($objPage->arrData['arrCartDetails']['GiftCard'] as $key => $valGiftCards) {
                        $varCartSubTotal = $valGiftCards['qty'] * $valGiftCards['amount'];
                        ?>
                        <li id="RemoveGiftCard<?php echo $key; ?>" class="cart<?php echo $counter3; ?>">
                            <div class="bottom_border">
                                <?php                                
                                 $varSrc = $objCore->getImageUrl('', 'gift_card');
                                ?>
                                <div class="image"><img src="<?php echo $varSrc; ?>" alt="<?php echo ucfirst(substr($valGiftCards['message'], 0, 15)); ?>" width="40" height="38" />

                                </div>
                                <div class="details">
                                    <?php echo ucfirst(substr($valGiftCards['message'], 0, 15)); ?><br />
                                    <span class="amt_qty"><?php echo $valGiftCards['qty']; ?> x <?php echo $valGiftCards['amount']; ?></span>
                                    <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                </div></div>
                            <div class="delete"><a href="javascript:void(0);" onclick="RemoveGiftCardFromCart('<?php echo $key; ?>','<?php echo $valGiftCards['qty']; ?>');"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" border="0" /></a></div>
                        </li>
                        <?php
                        $varCartTotal += $varCartSubTotal;
                    }
                    ?>



                </ul>

            </div>
        </div>

        <div class="checkout_cart">
            <div class="subtotal">
                SUBTOTAL
                <span><?php echo $objCore->getPrice($varCartTotal); ?></span>
            </div>
            <a href="<?php echo $objCore->getUrl('shopping_cart.php'); ?>" class="checkout_button">Checkout</a>
        </div>
    <?php } else {
        ?>
        <div class="my_cart_inner noProduct">No items added into the cart</div>
        <?php
    }
    ?>
</div>