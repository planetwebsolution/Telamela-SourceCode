<?php
require_once '../config/config.inc.php';
require_once(CLASSES_PATH . 'class_common.php');
require_once(CLASSES_PATH . 'class_shopping_cart_bll.php');
require_once CLASSES_PATH . 'class_category_bll.php';
require_once CLASSES_PATH . 'class_product_bll.php';
$objClassCommon = new ClassCommon();
$objShoppingCart = new ShoppingCart();
$objCore = new Core();
$objCategory = new Category();
$objGeneral = new General();

//Get Posted data
$case = $_REQUEST['action'];
switch ($case)
{
    case 'addToCart':
        // echo 'hi';die;
        $qty = 1;
        if ($objShoppingCart->productInStock($_REQUEST['pid'], $qty))
        {
            if (isset($_SESSION['MyCart']['Product'][$_REQUEST['pid']]))
            {
                $_SESSION['MyCart']['Product'][$_REQUEST['pid']][$_REQUEST['pid'] . "-0"]['qty'] += $qty;
            }
            else
            {
                $_SESSION['MyCart']['Product'][$_REQUEST['pid']][$_REQUEST['pid'] . "-0"]['qty'] = $qty;
            }

            $_SESSION['MyCart']['Total'] += $qty;

            $class = '';
            $msg = COMP_PRODUCT_ADD_IN_SHOPING_CART;
        }
        else
        {
            $class = 'class="red"';
            $msg = PRODUCT_ADD_IN_SHOPING_CART_OUT_OF_STOCK;
        }

        $arrRow = $objClassCommon->getProduct("ProductName,ProductImage as ImageName,FinalPrice,DiscountFinalPrice", " pkProductID = '" . $_REQUEST['pid'] . "' ");
        $FinalPrice = ($arrRow[0]['DiscountFinalPrice'] > 0) ? $arrRow[0]['DiscountFinalPrice'] : $arrRow[0]['FinalPrice'];
        $varPrice = $objCore->getPrice($FinalPrice);


        $varSrc = $objCore->getImageUrl($arrRow[0]['ImageName'], 'products/' . $arrProductImageResizes['landing3']);

        if ($arrRow[0]['DiscountFinalPrice'] != 0)
        {
            ?>
            <?php
            $price1 = $objCore->getPrice($arrRow[0]['FinalPrice']);
            $price2 = $objCore->getPrice($arrRow[0]['DiscountFinalPrice']);
            ?>
            <?php
        }
        else
        {
            ?>
            <?php $price1 = $objCore->getPrice($arrRow[0]['FinalPrice']); ?>
            <?php
        }
        $varStr = '<div class="cart_inner">
                                <h3 ' . $class . '>' . $msg . '.</h3>
                                <div id="my_cart_detail" class="cart_detail">
                                    <span class="proimg">
                                        <img src="' . $varSrc . '" class="prodImg"/>
                                    </span>
                                    <div class="detail_right">
                                        <h4>' . $arrRow[0]['ProductName'] . '</h4>
                                        <ul>';
        if (!empty($price2))
        {
            $varStr .= '<li><small>' . PRICE . ': </small><span style="text-decoration: line-through; color:#555;">' . $price1 . '</span></li>
                                            <li><small>&nbsp;</small><span>' . $price2 . '</span></li>';
        }
        else
        {
            $varStr .= '<li><small>' . PRICE . ': </small><span style="text-decoration:lign-through;">' . $price1 . '</span></li>';
        }

        $varStr .= '</ul>
            <div class="cart_button">
                                                                    <input class="submit button continue_btn_my" type="submit" name="Shopping" value="' . SHOPPING_CART . '" onclick="window.location=' . "'" . $objCore->getUrl('shopping_cart.php') . "'" . '" />
                                                                    <input class="submit button close shopping_btn_my" type="button" name="Continue Shoping" value="' . CON_SHOPING . '" />
                                                                </div>
                                    </div>
                                </div>
                            </div>';
        echo $varStr;
//         setcookie('email_id', $argArrPost['frmUserEmail'], time() + 3600, '/');
//         
//        if(isset($_SESSION['MyCart']) && $_SESSION['MyCart']!='' && count($_SESSION['MyCart'])>0 && count($_COOKIE["MyCart"])==0){ //die();
//        isset($_SESSION['MyCart']) && $_SESSION['MyCart']!='' && count($_SESSION['MyCart'])>0?setcookie("MyCart", serialize($_SESSION['MyCart']), time()+3600, '/'):'';     
//        $_SESSION['MyCart']=$_SESSION['MyCart'];
//        return false;
//        
//        }else if(count($_COOKIE["MyCart"])>0 && count($_SESSION['MyCart'])==0){
//            $_SESSION['MyCart']=unserialize($_COOKIE["MyCart"]);
//            return false;
//        }

        break;

    case 'RemoveProductFromCart':

        //pre($_SESSION['MyCart']['Product']);
        $qty = isset($_SESSION['MyCart']['Product'][$_REQUEST['pid']][$_REQUEST['index']]['qty']) ? $_SESSION['MyCart']['Product'][$_REQUEST['pid']][$_REQUEST['index']]['qty'] : $_REQUEST['qty'];


        $_SESSION['MyCart']['Total'] = $_SESSION['MyCart']['Total']-  (int)$qty;

        if (isset($_SESSION['MyCart']['Product'][$_REQUEST['pid']][$_REQUEST['index']]))
        {
            unset($_SESSION['MyCart']['Product'][$_REQUEST['pid']][$_REQUEST['index']]);

            if (empty($_SESSION['MyCart']['Product'][$_REQUEST['pid']]))
            {
                unset($_SESSION['MyCart']['Product'][$_REQUEST['pid']]);
            }

            if (empty($_SESSION['MyCart']['Product']))
            {
                unset($_SESSION['MyCart']['Product']);
            }
        }

        $arrRow = $objClassCommon->getProduct("ProductName", " pkProductID = '" . $_REQUEST['pid'] . "' ");

        //echo (int) $_SESSION['MyCart']['Total'] . ',' . $arrRow[0]['ProductName'];
        $totel = (isset($_SESSION['MyCart']['Total']) && $_SESSION['MyCart']['Total'] > 0) ? (int) $_SESSION['MyCart']['Total'] : 0;
        echo json_encode(array('Total' => $totel, 'ProductName' => $arrRow[0]['ProductName']));

        break;

    case 'RemoveProductFromCartOnBox':

        $_SESSION['MyCart']['Total'] -= $_SESSION['MyCart']['Product'][$_REQUEST['pid']][$_REQUEST['index']]['qty'];

        if (isset($_SESSION['MyCart']['Product'][$_REQUEST['pid']][$_REQUEST['index']]))
        {
            unset($_SESSION['MyCart']['Product'][$_REQUEST['pid']][$_REQUEST['index']]);

            if (empty($_SESSION['MyCart']['Product'][$_REQUEST['pid']]))
            {
                unset($_SESSION['MyCart']['Product'][$_REQUEST['pid']]);
            }
            if (empty($_SESSION['MyCart']['Product']))
            {
                unset($_SESSION['MyCart']['Product']);
            }
        }

        $arrRow = $objClassCommon->getProduct("ProductName", " pkProductID = '" . $_REQUEST['pid'] . "' ");

//(int) $_SESSION['MyCart']['Total'] . ',' . $arrRow[0]['ProductName'];
        $arrData['arrCartDetails'] = $objShoppingCart->myCartDetails();
        ?>
        <div class="my_cart">
            <h5>My <span>Cart</span></h5>
            <?php
            if ($arrData['arrCartDetails']['Common']['CartCount'] != 0)
            {
                ?>
                <div class="my_cart_inner">
                    <div <?php
            if (count($arrData['arrCartDetails']['Product']) + count($arrData['arrCartDetails']['Package']) + count($arrData['arrCartDetails']['GiftCard']) > LIST_CART_BOX_LIMIT)
            {
                    ?> class="scroll-pane" <?php } ?>>


                        <ul>
                            <?php
                            $varCartTotal = 0;
                            $varCartSubTotal = 0;
                            $i = 0;
                            foreach ($arrData['arrCartDetails']['Product'] as $kCart => $valCart)
                            {
                                $varCartSubTotal = $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty'] * $valCart['FinalPrice'];
                                ?>
                                <li id="cart<?php echo $valCart['pkProductID']; ?>">
                                    <div class="bottom_border">
                                        <?php
                                        $varSrc = $objCore->getImageUrl($valCart['ImageName'], 'products/' . $arrProductImageResizes['default']);
                                        ?>
                                        <div class="image"><a href="<?php echo $objCore->getUrl('product.php', array('id' => $valCart['pkProductID'], 'name' => $valCart['ProductName'], 'refNo' => $valCart['pkProductID'])); ?>"><img src="<?php echo $varSrc; ?>" alt="<?php echo $valCart['ProductName']; ?>" width="40" height="38" /></a>

                                        </div>
                                        <div class="details">
                                            <a href="<?php echo $objCore->getUrl('product.php', array('id' => $valCart['pkProductID'], 'name' => $valCart['ProductName'], 'refNo' => $valCart['pkProductID'])); ?>"><?php echo $objCore->getProductName($valCart['ProductName'], 15); ?></a><br />
                                            <span><?php echo $valCart['attribute']; ?></span><br/>
                                            <span class="amt_qty"><?php echo $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty']; ?> x <?php echo $objCore->getPrice($valCart['FinalPrice']); ?></span>
                                            <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                        </div></div>
                                    <div class="delete"><a href="#" onclick="RemoveProductFromCart(<?php echo $valCart['pkProductID']; ?>,<?php echo $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty']; ?>,'<?php echo $kCart; ?>');"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" /></a></div>
                                </li>
                                <?php
                                $varCartTotal += $varCartSubTotal;
                                $i++;
                            }


                            foreach ($arrData['arrCartDetails']['Package'] as $kPKG => $vPKG)
                            {
                                $varCartSubTotal = $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty'] * $vPKG['PackagePrice'];
                                ?>
                                <li id="cart<?php echo $vPKG['pkProductID']; ?>">
                                    <div class="bottom_border">
                                        <?php
                                        $varPackageSrc = $objCore->getImageUrl($vPKG['PackageImage'], 'package/' . PACKAGE_IMAGE_RESIZE1);
                                        ?>
                                        <div class="image"><a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>"><img src="<?php echo $varPackageSrc; ?>" alt="<?php echo $vPKG['PackageName']; ?>" width="40" height="38" /></a>
                                        </div>
                                        <div class="details">
                                            <a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>"><?php echo ucfirst($vPKG['PackageName']); ?></a><br />
                                            <span class="amt_qty"><?PHP echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']; ?> x <?php echo $objCore->getPrice($vPKG['PackagePrice']); ?></span>
                                            <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                        </div></div>
                                    <div class="delete"><a href="#" onclick="RemovePackageFromCart(<?php echo $vPKG['pkPackageId']; ?>,<?PHP echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']; ?>,'<?php echo $kPKG; ?>');"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" /></a></div>
                                </li>
                                <?php
                                $varCartTotal += $varCartSubTotal;
                            }
                            foreach ($arrData['arrCartDetails']['GiftCard'] as $key => $valGiftCards)
                            {
                                $varCartSubTotal = $valGiftCards['qty'] * $valGiftCards['amount'];
                                ?>
                                <li id="RemoveGiftCard<?php echo $key; ?>">
                                    <div class="bottom_border">
                                        <?php
                                        $varSrc = $objCore->getImageUrl('', 'gift_cart');
                                        ?>
                                        <div class="image"><img src="<?php echo $varSrc; ?>" alt=" <?php echo ucfirst(substr($valGiftCards['message'], 0, 15)); ?>" width="40" height="38" />

                                        </div>
                                        <div class="details">
                                            <?php echo ucfirst(substr($valGiftCards['message'], 0, 15)); ?><br />
                                            <span class="amt_qty"><?php echo $valGiftCards['qty']; ?> x <?php echo $valGiftCards['amount']; ?></span>
                                            <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                        </div></div>
                                    <div class="delete"><a href="javascript:void(0);" onclick="RemoveGiftCardFromCart('<?php echo $key; ?>',<?php echo $valGiftCards['qty']; ?>);"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" /></a></div>
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
                        <?php echo SUBTOTAL; ?>
                        <span><?php echo $objCore->getPrice($varCartTotal); ?></span>
                    </div>
                    <a href="<?php echo $objCore->getUrl('shopping_cart.php'); ?>" class="checkout_button"><?php echo CHECKOUT; ?></a>
                </div>
            </div>
            <?php
        }
        else
        {
            echo '<div class="my_cart_inner noProduct">' . NO_ITEMS_ADD . '</div>';
        }
        break;


    case 'RemoveGiftCardFromCartOnBox':
        $_SESSION['MyCart']['Total'] -= $_SESSION['MyCart']['GiftCard'][$_REQUEST['pid']]['qty'];

        if (isset($_SESSION['MyCart']['GiftCard'][$_REQUEST['pid']]))
        {
            unset($_SESSION['MyCart']['GiftCard'][$_REQUEST['pid']]);
        }

        $arrRow = $objClassCommon->getProduct("ProductName", " pkProductID = '" . $_REQUEST['pid'] . "' ");

//(int) $_SESSION['MyCart']['Total'] . ',' . $arrRow[0]['ProductName'];
        $arrData['arrCartDetails'] = $objShoppingCart->myCartDetails();
        ?>
        <div class="my_cart">
            <h5><?php echo MY; ?> <span><?php echo CART; ?></span></h5>
            <?php
            if ($arrData['arrCartDetails']['Common']['CartCount'] != 0)
            {
                ?>
                <div class="my_cart_inner">
                    <div <?php
            if (count($arrData['arrCartDetails']['Product']) + count($arrData['arrCartDetails']['Package']) + count($arrData['arrCartDetails']['GiftCard']) > LIST_CART_BOX_LIMIT)
            {
                    ?> class="scroll-pane" <?php } ?>>
                        <ul>
                            <?php
                            $varCartTotal = 0;
                            $varCartSubTotal = 0;
                            $i = 0;
                            foreach ($arrData['arrCartDetails']['Product'] as $kCart => $valCart)
                            {
                                $varCartSubTotal = $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty'] * $valCart['FinalPrice'];
                                ?>
                                <li id="cart<?php echo $valCart['pkProductID']; ?>">
                                    <div class="bottom_border">
                                        <?php
                                        $varSrc = $objCore->getImageUrl($valCart['ImageName'], 'products/' . $arrProductImageResizes['default']);
                                        ?>
                                        <div class="image"><a href="<?php $objCore->getUrl('product.php', array('id' => $valCart['pkProductID'], 'name' => $valCart['ProductName'], 'refNo' => $valCart['ProductRefNo'])); ?>"><img src="<?php echo $varSrc; ?>" alt="<?php echo $valCart['ProductName']; ?>" width="40" height="38" /></a>

                                        </div>
                                        <div class="details">
                                            <a href="<?php $objCore->getUrl('product.php', array('id' => $valCart['pkProductID'], 'name' => $valCart['ProductName'], 'refNo' => $valCart['ProductRefNo'])); ?>"><?php echo ucfirst($valCart['ProductName']); ?></a><br />
                                            <span><?php echo $valCart['attribute']; ?></span><br/>
                                            <span class="amt_qty"><?php echo $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty']; ?> x <?php echo $objCore->getPrice($valCart['FinalPrice']); ?></span>
                                            <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                        </div></div>
                                    <div class="delete"><a href="#" onclick="RemoveProductFromCart(<?php echo $valCart['pkProductID']; ?>,<?php echo $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty']; ?>,'<?php echo $kCart; ?>');"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" /></a></div>
                                </li>
                                <?php
                                $varCartTotal += $varCartSubTotal;
                                $i++;
                            }


                            foreach ($arrData['arrCartDetails']['Package'] as $kPKG => $vPKG)
                            {
                                $varCartSubTotal = $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty'] * $vPKG['PackagePrice'];
                                ?>
                                <li id="cart<?php echo $vPKG['pkProductID']; ?>">
                                    <div class="bottom_border">
                                        <?php
                                        $varPackageSrc = $objCore->getImageUrl($vPKG['PackageImage'], 'package/' . PACKAGE_IMAGE_RESIZE1);
                                        ?>

                                        <div class="image"><a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>"><img src="<?php echo $varPackageSrc; ?>" alt="<?php echo $vPKG['PackageName']; ?>" width="40" height="38" /></a>

                                        </div>
                                        <div class="details">
                                            <a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>"><?php echo ucfirst($vPKG['PackageName']); ?></a><br />
                                            <span class="amt_qty"><?php echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']; ?> x <?php echo $objCore->getPrice($vPKG['PackagePrice']); ?></span>
                                            <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                        </div></div>
                                    <div class="delete"><a href="#" onclick="RemovePackageFromCart(<?php echo $vPKG['pkPackageId']; ?>,<?PHP echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']; ?>,'<?php echo $kPKG; ?>');"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" /></a></div>
                                </li>
                                <?php
                                $varCartTotal += $varCartSubTotal;
                            }

                            foreach ($arrData['arrCartDetails']['GiftCard'] as $key => $valGiftCards)
                            {
                                $varCartSubTotal = $valGiftCards['qty'] * $valGiftCards['amount'];
                                ?>
                                <li id="RemoveGiftCard<?php echo $key; ?>">
                                    <div class="bottom_border">
                                        <?php
                                        $varSrc = $objCore->getImageUrl('', 'gift_card');
                                        ?>
                                        <div class="image"><img src="<?php echo $varSrc; ?>" alt=" <?php echo ucfirst(substr($valGiftCards['message'], 0, 15)); ?>" width="40" height="38" />

                                        </div>
                                        <div class="details">
                                            <?php echo ucfirst(substr($valGiftCards['message'], 0, 15)); ?><br />
                                            <span class="amt_qty"><?php echo $valGiftCards['qty']; ?> x <?php echo $valGiftCards['amount']; ?></span>
                                            <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                        </div></div>
                                    <div class="delete"><a href="javascript:void(0);" onclick="RemoveGiftCardFromCart('<?php echo $key; ?>',<?php echo $valGiftCards['qty']; ?>);"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" /></a></div>
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
                        <?php echo SUBTOTAL; ?>
                        <span><?php echo $objCore->getPrice($varCartTotal); ?></span>
                    </div>
                    <a href="<?php echo $objCore->getUrl('shopping_cart.php') ?>" class="checkout_button"><?php echo CHECKOUT; ?></a>
                </div>
            </div>
            <?php
        }
        else
        {
            echo '<div class="my_cart_inner noProduct">' . NO_ITEMS_ADD . '</div>';
        }
        break;

    case 'RemovePackageFromCart':

        //$_SESSION['MyCart']['Total'] -= $_SESSION['MyCart']['Package'][$_REQUEST['pid']][$_REQUEST['pkgIndex']]['qty'];

        $qty = isset($_SESSION['MyCart']['Package'][$_REQUEST['pid']][$_REQUEST['pkgIndex']]['qty']) ? $_SESSION['MyCart']['Package'][$_REQUEST['pid']][$_REQUEST['pkgIndex']]['qty'] : $_REQUEST['qty'];

        $_SESSION['MyCart']['Total'] -= $qty;

        if (isset($_SESSION['MyCart']['Package'][$_REQUEST['pid']][$_REQUEST['pkgIndex']]))
        {
            unset($_SESSION['MyCart']['Package'][$_REQUEST['pid']][$_REQUEST['pkgIndex']]);

            if (empty($_SESSION['MyCart']['Package'][$_REQUEST['pid']]))
            {
                unset($_SESSION['MyCart']['Package'][$_REQUEST['pid']]);
            }

            if (empty($_SESSION['MyCart']['Package']))
            {
                unset($_SESSION['MyCart']['Package']);
            }
        }
        echo $_SESSION['MyCart']['Total'];

        break;

    case 'RemovePackageFromCartOnBox':
        $_SESSION['MyCart']['Total'] -= $_SESSION['MyCart']['Package'][$_REQUEST['pid']][$_REQUEST['pkgIndex']]['qty'];

        if (isset($_SESSION['MyCart']['Package'][$_REQUEST['pid']][$_REQUEST['pkgIndex']]))
        {
            unset($_SESSION['MyCart']['Package'][$_REQUEST['pid']][$_REQUEST['pkgIndex']]);

            if (empty($_SESSION['MyCart']['Package'][$_REQUEST['pid']]))
            {
                unset($_SESSION['MyCart']['Package'][$_REQUEST['pid']]);
            }

            if (empty($_SESSION['MyCart']['Package']))
            {
                unset($_SESSION['MyCart']['Package']);
            }
        }
        $arrData['arrCartDetails'] = $objShoppingCart->myCartDetails();
        ?>
        <div class="my_cart">
            <h5 onclick="window.location='<?php echo $objCore->getUrl('shopping_cart.php'); ?>'"><?php echo MY; ?> <span><?php echo CART; ?></span></h5>
            <?php
            if ($arrData['arrCartDetails']['Common']['CartCount'] != 0)
            {
                ?>
                <div class="my_cart_inner">
                    <div <?php
            if (count($arrData['arrCartDetails']['Product']) + count($arrData['arrCartDetails']['Package']) + count($arrData['arrCartDetails']['GiftCard']) > LIST_CART_BOX_LIMIT)
            {
                    ?> class="scroll-pane" <?php } ?>>


                        <ul>
                            <?php
                            $varCartTotal = 0;
                            $varCartSubTotal = 0;
                            $i = 0;
                            foreach ($arrData['arrCartDetails']['Product'] as $kCart => $valCart)
                            {
                                $varCartSubTotal = $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty'] * $valCart['FinalPrice'];
                                ?>
                                <li id="cart<?php echo $valCart['pkProductID']; ?>">
                                    <div class="bottom_border">
                                        <?php
                                        $varSrc = $objCore->getImageUrl($valCart['ImageName'], 'products/' . $arrProductImageResizes['default']);
                                        ?>
                                        <div class="image"><a href="<?php echo $objCore->getUrl('product.php', array('id' => $valCart['pkProductID'], 'name' => $valCart['ProductName'], 'refNo' => $valCart['ProductRefNo'])) ?>"><img src="<?php echo $varSrc; ?>" alt="<?php echo $valCart['ProductName']; ?>" width="40" height="38" /></a>

                                        </div>
                                        <div class="details">
                                            <a href="<?php echo $objCore->getUrl('product.php', array('id' => $valCart['pkProductID'], 'name' => $valCart['ProductName'], 'refNo' => $valCart['ProductRefNo'])) ?>"><?php echo ucfirst($valCart['ProductName']); ?></a><br />
                                            <span><?php echo $valCart['attribute']; ?></span><br/>
                                            <span class="amt_qty"><?php echo $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty']; ?> x <?php echo $objCore->getPrice($valCart['FinalPrice']); ?></span>
                                            <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                        </div></div>
                                    <div class="delete"><a href="#" onclick="RemoveProductFromCart(<?php echo $valCart['pkProductID']; ?>,<?php echo $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty']; ?>,'<?php echo $kCart; ?>');"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" /></a></div>
                                </li>
                                <?php
                                $i++;
                                $varCartTotal += $varCartSubTotal;
                            }


                            foreach ($arrData['arrCartDetails']['Package'] as $kPKG => $vPKG)
                            {
                                $varCartSubTotal = $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty'] * $vPKG['PackagePrice'];
                                ?>
                                <li id="cart<?php echo $vPKG['pkProductID']; ?>">
                                    <div class="bottom_border">
                                        <?php
                                        $varPackageSrc = $objCore->getImageUrl($vPKG['PackageImage'], 'package/' . PACKAGE_IMAGE_RESIZE1);
                                        ?>
                                        <div class="image"><a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>"><img src="<?php echo $varPackageSrc; ?>" alt="<?php echo $vPKG['PackageName']; ?>" width="40" height="38" /></a>

                                        </div>
                                        <div class="details">
                                            <a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>"><?php echo ucfirst($vPKG['PackageName']); ?></a><br />
                                            <span class="amt_qty"><?php echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']; ?> x <?php echo $objCore->getPrice($vPKG['PackagePrice']); ?></span>
                                            <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                        </div></div>
                                    <div class="delete"><a href="#" onclick="RemovePackageFromCart(<?php echo $vPKG['pkPackageId']; ?>,<?php echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']; ?>,'<?php echo $kPKG; ?>');"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" /></a></div>
                                </li>
                                <?php
                                $varCartTotal += $varCartSubTotal;
                            }

                            foreach ($arrData['arrCartDetails']['GiftCard'] as $key => $valGiftCards)
                            {
                                $varCartSubTotal = $valGiftCards['qty'] * $valGiftCards['amount'];
                                ?>
                                <li id="RemoveGiftCard<?php echo $key; ?>">
                                    <div class="bottom_border">
                                        <?php
                                        $varSrc = $objCore->getImageUrl('', 'gift_card');
                                        ?>
                                        <div class="image"><img src="<?php echo $varSrc; ?>" alt=" <?php echo ucfirst(substr($valGiftCards['message'], 0, 15)); ?>" width="40" height="38" />

                                        </div>
                                        <div class="details">
                                            <?php echo ucfirst(substr($valGiftCards['message'], 0, 15)); ?><br />
                                            <span class="amt_qty"><?php echo $valGiftCards['qty']; ?> x <?php echo $valGiftCards['amount']; ?></span>
                                            <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                        </div></div>
                                    <div class="delete"><a href="javascript:void(0);" onclick="RemoveGiftCardFromCart('<?php echo $key; ?>',<?php echo $valGiftCards['qty']; ?>);"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" /></a></div>
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
                        <?php echo SUBTOTAL; ?>
                        <span><?php echo $objCore->getPrice($varCartTotal); ?></span>
                    </div>
                    <a href="<?php echo $objCore->getUrl('shopping_cart.php') ?>" class="checkout_button"><?php echo CHECKOUT; ?></a>
                </div>
            </div>
            <?php
        }

        break;

    case 'RemoveCart':

        $_SESSION['MyCart']['Total'] = 0;

        if (isset($_SESSION['MyCart']))
        {
            unset($_SESSION['MyCart']);
            if (isset($_SESSION['MyCart']['Product']))
            {
                unset($_SESSION['MyCart']['Product']);
            }
            if (isset($_SESSION['MyCart']['Package']))
            {
                unset($_SESSION['MyCart']['Package']);
            }
            if (isset($_SESSION['MyCart']['GiftCard']))
            {
                unset($_SESSION['MyCart']['GiftCard']);
            }
        }
        if ($_SESSION['sessUserInfo']['id'] != "" && $_SESSION['sessUserInfo']['type'] == 'customer')
        {
            $objShoppingCart->removeAllCartDetails($_SESSION['sessUserInfo']['id']);
        }
        break;

    case 'ApplyCouponCode':

        $varWhr = "md5(CouponCode) = '" . md5($objCore->getFormatValue($_REQUEST['code'])) . "' AND DateStart <='" . date(DATE_FORMAT_DB) . "' AND DateEnd >='" . date(DATE_FORMAT_DB) . "'";
        $arrRowCoupon = $objClassCommon->getCoupon(array('pkCouponID', 'IsApplyAll'), $varWhr);


        if ($arrRowCoupon)
        {
            if(count($_SESSION['MyCart']['Product'])>0){
            $varCartIDS = implode(',', array_keys($_SESSION['MyCart']['Product']));
            
            $varWher = "AND fkProductID in (" . $varCartIDS . ")";
            $varNumPro = $objClassCommon->countCoupon('fkProductID', $varWher);
            }
            if (($arrRowCoupon[0]['IsApplyAll'] == 1) || ($arrRowCoupon[0]['IsApplyAll'] == 0 && $varNumPro > 0))
            {

                $_SESSION['MyCart']['CouponCode'] = $_REQUEST['code'];
                $arrRows = $objShoppingCart->myCartDetails();
                $varCartSubTotal = 0;
                $varCartTotal = 0;
                $varCartTotal1=0;
                $varDiscountCoupon = 0;
                $i = 0;
                //for product
                foreach ($arrRows['Product'] as $kCart => $vCart)
                {
                    
                    $varPr=$objCore->getProductCalCurrencyPrice($vCart['FinalPrice']); 
                    $varCartSubTotal2 = $varPr * $_SESSION['MyCart']['Product'][$vCart['pkProductID']][$kCart]['qty'];
                    $varCartSubTotal3[]=$varCartSubTotal2;                        
                    $varCartSubTotal = $_SESSION['MyCart']['Product'][$vCart['pkProductID']][$kCart]['qty'] * $vCart['FinalPrice'];
                    $varDiscountCoupon += (float) $vCart['Discount'];
                    $varCartTotal += $varCartSubTotal;
                    $varCartTotal1 += $varCartSubTotal;
                    $i++;
                }

                //for package
                foreach ($arrRows['Package'] as $kPKG => $vPKG)
                {
                    $varCartSubTotal = $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty'] * $vPKG['PackagePrice'];
                    $varCartSubTotal3[]=$varCartSubTotal;  
                    $varCartTotal += $varCartSubTotal;
                }

                //for gift cart
                if ($_SESSION['MyCart']['GiftCard'])
                {
                    foreach ($_SESSION['MyCart']['GiftCard'] as $kGC => $vGC)
                    {
                        $varCartSubTotal = $vGC['qty'] * $vGC['amount'];
                        $varCartSubTotal3[]=$varCartSubTotal; 
                        $varCartTotal += $varCartSubTotal;
                    }
                }
               // echo $varCartTotal;
                //$varGrandTotal = $varCartTotal - $varDiscountCoupon;
                //echo array_sum($varCartSubTotal3);
                //echo $varDiscountCoupon;
                $varGrandTotal = array_sum($varCartSubTotal3) - $objCore->getProductCalCurrencyPrice($varDiscountCoupon);
                 
                $getPercent = $varDiscountCoupon * 100 / $varCartTotal1;

                echo '<li><span>Sub Total</span><strong id="subTotalP">' . $_SESSION['SiteCurrencySign']." ".array_sum($varCartSubTotal3) . '</strong></li>
<li><span>Discount (Coupon)</span><strong id="DiscountCouponP">- ' . $objCore->getPrice($varDiscountCoupon) . '</strong><input type="hidden" id="DiscountCouponPValue" value="' . $getPercent . '"/></li>
<li class="last"><span>Grand Total</span><strong>' .$_SESSION['SiteCurrencySign'].' '.$varGrandTotal. '</strong></li>';
            }
            else
            {

                echo '1';
            }
        }
        else
        {
            echo '0';
        }

        break;

    case 'addToProductCart':
        //pre($_REQUEST);
        $attrFormate = strip_tags($_REQUEST['attrFormate']);
       // pre($attrFormate);
        $arrAttr = explode("#", $attrFormate);
        if ($objShoppingCart->productInStock($_REQUEST['pid'], $_REQUEST['qty'], $_REQUEST['optIds'], $arrAttr))
        {
            if (isset($_SESSION['MyCart']['Product'][$_REQUEST['pid']]))
            {
                if ($attrFormate)
                {
                    $flag = 0;

                    foreach ($_SESSION['MyCart']['Product'][$_REQUEST['pid']] AS $key => $prod)
                    {
                        if ($prod['attribute'] == $arrAttr)
                        {
                            $flag = 1;
                            $_SESSION['MyCart']['Product'][$_REQUEST['pid']][$key]['qty'] += $_REQUEST['qty'];
                            break;
                        }
                    }
                    if ($flag == 0)
                    {
                        $len = count($_SESSION['MyCart']['Product'][$_REQUEST['pid']]);
                        $_SESSION['MyCart']['Product'][$_REQUEST['pid']][$_REQUEST['pid'] . "-" . $len]['attribute'] = $arrAttr;
                        $_SESSION['MyCart']['Product'][$_REQUEST['pid']][$_REQUEST['pid'] . "-" . $len]['qty'] = $_REQUEST['qty'];
                    }
                }
                else
                {
                    $_SESSION['MyCart']['Product'][$_REQUEST['pid']][$_REQUEST['pid'] . "-0"]['qty'] += $_REQUEST['qty'];
                }
            }
            else
            {
                $_SESSION['MyCart']['Product'][$_REQUEST['pid']][$_REQUEST['pid'] . "-0"]['qty'] = $_REQUEST['qty'];

                if ($attrFormate)
                {
                    $arrAttr = explode("#", $attrFormate);

                    $_SESSION['MyCart']['Product'][$_REQUEST['pid']][$_REQUEST['pid'] . "-0"]['attribute'] = $arrAttr;
                }
            }
            $_SESSION['MyCart']['Total'] += $_REQUEST['qty'];

            if (isset($_REQUEST['page']))
            {
                //$msg = '<div class="success">' . PRODUCT_ADD_IN_SHOPING_CART . '</div>';
                $msg = '<span class="green">' . PRODUCT_ADD_IN_SHOPING_CART . '</span>';
            }
            else
            {
                $msg = PRODUCT_ADD_IN_SHOPING_CART . ' <a href="' . $objCore->getUrl('shopping_cart.php') . '">My Cart</a>';
            }
        }
        else
        {
            if (isset($_REQUEST['page']))
            {
                //$msg = '<div class="error">' . PRODUCT_ADD_IN_SHOPING_CART_OUT_OF_STOCK . '</div>';
                $msg = '<span class="red">' . PRODUCT_ADD_IN_SHOPING_CART_OUT_OF_STOCK . '</span>';
            }
            else
            {
                $msg = '<b class="red">' . PRODUCT_ADD_IN_SHOPING_CART_OUT_OF_STOCK . '</b>';
            }
        }
        echo $msg;

        break;

    case 'addToPackage':
        $attrFormate = strip_tags($_REQUEST['attrFormate']);
       //pre($_SESSION['MyCart']['Package']);
        if (isset($_SESSION['MyCart']['Package'][$_REQUEST['pkPackageId']]))
        {
            $packageSession = $_SESSION['MyCart']['Package'][$_REQUEST['pkPackageId']];
            $flag = 1;
            foreach ($packageSession AS $key => $packageProduct)
            {
                $attr = '';
                foreach ($packageProduct['product'] AS $pid => $attributes)
                {
                    $attr .= $pid . '$' . implode('#', $attributes) . "|";
                }
                if ($attr == $attrFormate)
                {
                    $flag = 0;
                    $_SESSION['MyCart']['Package'][$_REQUEST['pkPackageId']][$key]['qty'] += $_REQUEST['qty'];
                    break;
                }
            }
            if ($flag)
            {
                $len = count($_SESSION['MyCart']['Package'][$_REQUEST['pkPackageId']]);
                $_SESSION['MyCart']['Package'][$_REQUEST['pkPackageId']][$_REQUEST['pkPackageId'] . "-" . $len]['qty'] = $_REQUEST['qty'];
                $productAttribute = explode('|', $attrFormate);
                $lastIndex = count($productAttribute) - 1;
                unset($productAttribute[$lastIndex]);
                foreach ($productAttribute AS $key => $val)
                {
                    $prodIdAttribute = explode('$', $val);
                    $arrAttr = explode('#', $prodIdAttribute[1]);
                    $_SESSION['MyCart']['Package'][$_REQUEST['pkPackageId']][$_REQUEST['pkPackageId'] . "-" . $len]['product'][$prodIdAttribute[0]] = $arrAttr;
                }
            }
        }
        else
        {
           // pre($_REQUEST);
            $_SESSION['MyCart']['Package'][$_REQUEST['pkPackageId']][$_REQUEST['pkPackageId'] . "-0"]['qty'] = $_REQUEST['qty'];
            $productAttribute = explode('|', $attrFormate);
           
            $lastIndex = count($productAttribute) - 1;
            unset($productAttribute[$lastIndex]);
             //pre($productAttribute);
            foreach ($productAttribute AS $key => $val)
            {
                $prodIdAttribute = explode('$', $val);
                $arrAttr = explode('#', $prodIdAttribute[1]);
                $_SESSION['MyCart']['Package'][$_REQUEST['pkPackageId']][$_REQUEST['pkPackageId'] . "-0"]['product'][$prodIdAttribute[0]] = $arrAttr;
            }
        }


        $_SESSION['MyCart']['Total'] += $_REQUEST['qty'];
        $varCartTotal = 0;
        $varCartSubTotal = 0;

        $arrData['arrCartDetails'] = $objShoppingCart->myCartDetails();
        //pre($arrData['arrCartDetails']);
        ?>
        <div class="my_cart">
            <h5 onclick="window.location='<?php echo $objCore->getUrl('shopping_cart.php'); ?>'"><?php echo MY; ?> <span><?php echo CART; ?></span></h5>
            <div class="my_cart_inner">
                <div <?php
        if (count($arrData['arrCartDetails']['Product']) + count($arrData['arrCartDetails']['Package']) + count($arrData['arrCartDetails']['GiftCard']) > LIST_CART_BOX_LIMIT)
        {
            ?> class="scroll-pane" <?php } ?>>


                    <ul>
                        <?php
                        $i = 0;
                        foreach ($arrData['arrCartDetails']['Product'] as $kCart => $valCart)
                        {
                            $varCartSubTotal = $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty'] * $valCart['FinalPrice'];
                            ?>
                            <li id="cart<?php echo $valCart['pkProductID']; ?>">
                                <div class="bottom_border">
                                    <?php
                                    $varSrc = $objCore->getImageUrl($valCart['ImageName'], 'products/' . $arrProductImageResizes['default']);
                                    ?>
                                    <div class="image"><a href="<?php echo $objCore->getUrl('product.php', array('id' => $valCart['pkProductID'], 'name' => $valCart['ProductName'], 'refNo' => $valCart['pkProductID'])); ?>"><img src="<?php echo $varSrc; ?>" alt="<?php echo $valCart['ProductName']; ?>" width="40" height="38" /></a>

                                    </div>
                                    <div class="details">
                                        <a href="<?php echo $objCore->getUrl('product.php', array('id' => $valCart['pkProductID'], 'name' => $valCart['ProductName'], 'refNo' => $valCart['pkProductID'])); ?>"><?php echo $objCore->getProductName($valCart['ProductName'], 15); ?></a><br />
                                        <span><?php echo $valCart['attribute']; ?></span><br/>
                                        <span class="amt_qty"><?php echo $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty']; ?> x <?php echo $objCore->getPrice($valCart['FinalPrice']); ?></span>
                                        <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                    </div></div>
                                <div class="delete"><a href="#" onclick="RemoveProductFromCart(<?php echo $valCart['pkProductID']; ?>, <?php echo $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty']; ?>,'<?php echo $kCart; ?>');"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" /></a></div>
                            </li>
                            <?php
                            $varCartTotal += $varCartSubTotal;
                            $i++;
                        }


                        foreach ($arrData['arrCartDetails']['Package'] as $kPKG => $vPKG)
                        {
                            $varCartSubTotal = $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty'] * $vPKG['PackagePrice'];
                            ?>
                            <li id="cart<?php echo $vPKG['pkProductID']; ?>">
                                <div class="bottom_border">
                                    <?php
                                    $varPackageSrc = $objCore->getImageUrl($vPKG['PackageImage'], 'package/' . PACKAGE_IMAGE_RESIZE1);
                                    ?>
                                    <div class="image"><a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>"><img src="<?php echo $varPackageSrc; ?>" alt="<?php echo $vPKG['PackageName']; ?>" width="40" height="38" /></a>

                                    </div>
                                    <div class="details">
                                        <a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>"><?php echo ucfirst($vPKG['PackageName']); ?></a><br />
                                        <span class="amt_qty"><?php echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']; ?> x <?php echo $objCore->getPrice($vPKG['PackagePrice']); ?></span>
                                        <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                    </div></div>
                                <div class="delete"><a href="#" onclick="RemovePackageFromCart(<?php echo $vPKG['pkPackageId']; ?>,<?php echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']; ?>,'<?php echo $kPKG; ?>');"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" /></a></div>
                            </li>
                            <?php
                            $varCartTotal += $varCartSubTotal;
                        }

                        foreach ($arrData['arrCartDetails']['GiftCard'] as $key => $valGiftCards)
                        {
                            $varCartSubTotal = $valGiftCards['qty'] * $valGiftCards['amount'];
                            ?>
                            <li id="RemoveGiftCard<?php echo $key; ?>">
                                <div class="bottom_border">
                                    <?php
                                    $varSrc = $objCore->getImageUrl('', 'gift_card');
                                    ?>
                                    <div class="image"><img src="<?php echo $varSrc; ?>" alt=" <?php echo ucfirst(substr($valGiftCards['message'], 0, 15)); ?>" width="40" height="38" />

                                    </div>
                                    <div class="details">
                                        <?php echo ucfirst(substr($valGiftCards['message'], 0, 15)); ?><br />
                                        <span class="amt_qty"><?php echo $valGiftCards['qty']; ?> x <?php echo $valGiftCards['amount']; ?></span>
                                        <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                    </div></div>
                                <div class="delete"><a href="javascript:void(0);" onclick="RemoveGiftCardFromCart('<?php echo $key; ?>,<?php echo $valGiftCards['qty']; ?>');"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" /></a></div>
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
                    <?php echo SUBTOTAL; ?>
                    <span><?php echo $objCore->getPrice($varCartTotal); ?></span>
                </div>
                <a href="<?php echo $objCore->getUrl('shopping_cart.php') ?>" class="checkout_button"><?php echo CHECKOUT; ?></a>
            </div>
        </div>
        <?php
//print_r($_SESSION);
        break;


    case 'quickDetails':
        $arrRow = $objClassCommon->getProduct("ProductName,ImageName,FinalPrice,DiscountFinalPrice", " pkProductID = '" . $_REQUEST['pid'] . "' ");
        $FinalPrice = ($arrRow[0]['DiscountFinalPrice'] > 0) ? $arrRow[0]['DiscountFinalPrice'] : $arrRow[0]['FinalPrice'];
        $varPrice = $objCore->getPrice($FinalPrice);

        $varSrc = $objCore->getImageUrl($arrRow[0]['ImageName'], 'products/' . $arrProductImageResizes['listing']);

        $varStr = '<table border="0" width="100%" cellspacing="13">
        <tr><td rowspan="2" style="width:80px;"><img src="' . $varSrc . '" width="60" height="60" /></td><td>' . $arrRow[0]['ProductName'] . '</td></tr>
        <tr><td>Price: <span>' . $varPrice . '</span></td></tr><tr><td colspan="2"><div style="display: inline-block; text-align: center;width: 100%;"><input class="button"type="button" name="Shopping" value="' . SHOPPING_CART . '" onclick="window.location=' . $objCore->getUrl('shopping_cart.php') . '" />&nbsp;<input class="button" type="button" name="Continue" onclick="addToCartClose()" value="' . CON_SHOPING . '" /></div></td> </tr></table>';
        echo $varStr;

        break;

    case 'addToAjaxCart':

        $varCartTotal = 0;
        $varCartSubTotal = 0;
        $arrData['arrCartDetails'] = $objShoppingCart->myCartDetails();
        ?>
        <div class="my_cart">
            <h5><?php echo MY; ?> <span><?php echo CART; ?></span></h5>
            <?php
            if ($_SESSION['MyCart']['Total'] > 0)
            {
                ?>
                <div class="my_cart_inner">
                    <div <?php
            if (count($arrData['arrCartDetails']['Product']) + count($arrData['arrCartDetails']['Package']) + count($arrData['arrCartDetails']['GiftCard']) > LIST_CART_BOX_LIMIT)
            {
                    ?> class="scroll-pane" <?php } ?>>
                        <ul>
                            <?php
                            $i = 0;
                            foreach ($arrData['arrCartDetails']['Product'] as $kCart => $valCart)
                            {
                                $varCartSubTotal = $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty'] * $valCart['FinalPrice'];
                                ?>
                                <li id="cart<?php echo $valCart['pkProductID']; ?>" class="cart<?php echo $i; ?>">
                                    <div class="bottom_border">
                                        <?php
                                        $varSrc = $objCore->getImageUrl($valCart['ImageName'], 'products/' . $arrProductImageResizes['default']);
                                        ?>
                                        <div class="image"><a href="<?php echo $objCore->getUrl('product.php', array('id' => $valCart['pkProductID'], 'name' => $valCart['ProductName'], 'refNo' => $valCart['pkProductID'])); ?>"><img src="<?php echo $varSrc; ?>" alt="<?php echo $valCart['ProductName']; ?>" width="40" height="38" /></a>

                                        </div>
                                        <div class="details">
                                            <a href="<?php echo $objCore->getUrl('product.php', array('id' => $valCart['pkProductID'], 'name' => $valCart['ProductName'], 'refNo' => $valCart['pkProductID'])); ?>"><?php echo ucfirst($valCart['ProductName']); ?></a><br />
                                            <span><?php echo $valCart['attribute']; ?></span><br/>
                                            <span class="amt_qty"><?php echo $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty']; ?> x <?php echo $objCore->getPrice($valCart['FinalPrice']); ?></span>
                                            <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                        </div></div>
                                    <div class="delete"><a href="#" onclick="RemoveProductFromCart(<?php echo $valCart['pkProductID']; ?>,<?php echo $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty']; ?>,'<?php echo $kCart; ?>');"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" /></a></div>
                                </li>
                                <?php
                                $varCartTotal += $varCartSubTotal;
                                $i++;
                            }


                            foreach ($arrData['arrCartDetails']['Package'] as $kPKG => $vPKG)
                            {
                                $varCartSubTotal = $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty'] * $vPKG['PackagePrice'];
                                ?>
                                <li id="cart<?php echo $vPKG['pkProductID']; ?>">
                                    <div class="bottom_border">
                                        <?php
                                        $varPackageSrc = $objCore->getImageUrl($vPKG['PackageImage'], 'package/' . PACKAGE_IMAGE_RESIZE1);
                                        ?>
                                        <div class="image"><a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>"><img src="<?php echo $varPackageSrc; ?>" alt="<?php echo $vPKG['PackageName']; ?>" width="40" height="38" /></a>

                                        </div>
                                        <div class="details">
                                            <a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>"><?php echo ucfirst($vPKG['PackageName']); ?></a><br />
                                            <span class="amt_qty"><?PHP echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']; ?> x <?php echo $objCore->getPrice($vPKG['PackagePrice']); ?></span>
                                            <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                        </div></div>
                                    <div class="delete"><a href="#" onclick="RemovePackageFromCart(<?php echo $vPKG['pkPackageId']; ?>,<?PHP echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']; ?>,'<?php echo $kPKG; ?>');"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" /></a></div>
                                </li>
                                <?php
                                $varCartTotal += $varCartSubTotal;
                            }

                            foreach ($arrData['arrCartDetails']['GiftCard'] as $key => $valGiftCards)
                            {
                                $varCartSubTotal = $valGiftCards['qty'] * $valGiftCards['amount'];
                                ?>
                                <li id="RemoveGiftCard<?php echo $key; ?>">
                                    <div class="bottom_border">
                                        <?php
                                        $varSrc = $objCore->getImageUrl('', 'gift_card');
                                        ?>
                                        <div class="image"><img src="<?php echo $varSrc; ?>" alt=" <?php echo ucfirst(substr($valGiftCards['message'], 0, 15)); ?>" width="40" height="38" />

                                        </div>
                                        <div class="details">
                                            <?php echo ucfirst(substr($valGiftCards['message'], 0, 15)); ?><br />
                                            <span class="amt_qty"><?php echo $valGiftCards['qty']; ?> x <?php echo $valGiftCards['amount']; ?></span>
                                            <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                        </div></div>
                                    <div class="delete"><a href="javascript:void(0);" onclick="RemoveGiftCardFromCart('<?php echo $key; ?>',<?php echo $valGiftCards['qty']; ?>);"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" /></a></div>
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
                        <?php echo SUBTOTAL; ?>
                        <span><?php echo $objCore->getPrice($varCartTotal); ?></span>
                    </div>
                    <a href="<?php echo $objCore->getUrl('shopping_cart.php') ?>" class="checkout_button"><?php echo CHECKOUT; ?></a>
                </div>
                <?php
            }
            else
            {
                ?>
                <div class="my_cart_inner noProduct">No items added into the cart</div>
            </div>
            <?php
        }
        break;
    case 'addToAjaxCartHeader':

        $varCartTotal = 0;
        $varCartSubTotal = 0;
        $i = 0;
        $arrData['arrCartDetails'] = $objShoppingCart->myCartDetails(); //print_r($arrData['arrCartDetails']['GiftCard']);die;
        ?>

        <?php
        foreach ($arrData['arrCartDetails']['Product'] as $kCart => $vCart)
        {
            $varCartSubTotal = $_SESSION['MyCart']['Product'][$vCart['pkProductID']][$kCart]['qty'] * $vCart['FinalPrice'];
            ?>
            <li class="RemoveFromCart<?php echo $vCart['pkProductID']; ?>">
                <div class="cart_img">
                    <a  href="<?php echo $objCore->getUrl('product.php', array('id' => $vCart['pkProductID'], 'name' => $vCart['ProductName'], 'refNo' => $vCart['ProductRefNo'])); ?>">
                        <img  src="<?php echo $objCore->getImageUrl($vCart['ImageName'], 'products/' . $arrProductImageResizes['global']); ?>" alt="<?php echo $vCart['ProductName']; ?>" style="width:116px;height:101px;margin-bottom:10px;margin-top:10px;margin-left:10px;"/></a></div>
                <div style="clear:both;margin-top:10px"></div>
                <div class="new_heading" style="margin-top:10px">
                    <?php echo $objCore->getProductName($vCart['ProductName'], 15); ?>
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
        foreach ($arrData['arrCartDetails']['Package'] as $kPKG => $vPKG)
        {
            $varCartSubTotal = $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty'] * $vPKG['PackagePrice'];
            $counter2++;
            ?>
            <li class="RemovePackageFromCart<?php echo $vPKG['pkPackageId']; ?>"><div class="cart_img">
                    <?php
                    $varSrc = $objCore->getImageUrl($vPKG['PackageImage'], 'package/' . PACKAGE_IMAGE_RESIZE1);
                    ?>
                    <a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>">
                        <img src="<?php echo $varSrc; ?>" alt="<?php echo $valCart['PackageName']; ?>" style="width:116px;height:101px;margin-bottom:10px;margin-top:10px;margin-left:10px;"/>
                    </a>
                </div>
                <div style="clear:both;margin-top:10px"></div>
                <div class="new_heading" style="margin-top:10px">
                    <?php echo $vPKG['PackageName']; ?></div>
                <div class="cart_content">Lorem ipsum dolor sit amet</div>

                <div class="cart_price"><?php echo $objCore->getPrice($vPKG['PackagePrice'] * $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']); ?></div>
            </li>

            <?php
            $varCartTotal += $varCartSubTotal;
        }

        $giftCardCount = 0;
        foreach ($arrData['arrCartDetails']['GiftCard'] as $key => $giftCards)
        {
            $varCartSubTotal = $giftCards['qty'] * $giftCards['amount'];
            $giftCardCount++;
            ?>
            <li class="RemoveGiftFromCart<?php echo $key; ?>">
                <div class="cart_img">
                    <?php
                    $varSrc = $objCore->getImageUrl('', 'gift_card');
                    ?>
                    <img src="<?php echo $varSrc; ?>" alt="<?php echo $giftCards['message']; ?>" style="width:116px;height:101px;margin-bottom:10px;margin-top:10px;margin-left:10px;"/>
                </div>
                <div style="clear:both;margin-top:10px"></div>
                <div class="new_heading" style="margin-top:10px">
                    <?php echo $giftCards['message']; ?></div>
                <div class="cart_content">Lorem ipsum dolor sit amet</div>
                <div class="cart_price"><?php echo $objCore->getPrice($giftCards['amount'] * $_SESSION['MyCart']['GiftCard'][$key]['qty']); ?></div>
            </li>

            <?php
            $varCartTotal += $varCartSubTotal;
        }
        ?>
        <!--                            <div class="cart_row">
                                        <div class="newcart_img">
                                            <a href="<?php echo $objCore->getUrl('shopping_cart.php') ?>"><input type="button"  class="view_all" value="View All"/></a>
                                        </div>
                                        <div class="product_cart_value">
                                            <a href="<?php echo $objCore->getUrl('checkout.php') ?>"><input type="button" class="proceed_ch"  value="Proceed to Checkout"/></a>
                                        </div>
                                    </div>-->

        <?php
        break;
    case 'UpdateMyCartHeader':
        $Qty = 0;
        $pri = 0;

        $pri = (int) $_REQUEST['pri'];
        $oldQty = (int) $_REQUEST['oldQty'];
        //print_r($_REQUEST);die;
        if ($_REQUEST['type'] == 'product')
        {
            $arrD = array('frmProductId' => $_REQUEST['pid'], 'frmProductIndex' => $_REQUEST['pkgIndex'], 'frmProductQuantity' => $_REQUEST['qty']);

            if ($objShoppingCart->productInStockShoppingPage($_REQUEST['pid'], $arrD, $_REQUEST['pkgIndex']))
            {
                $varqty = (int) $_REQUEST['qty'];
                if ($varqty > 0)
                {
                    $_SESSION['MyCart']['Product'][$_REQUEST['pid']][$_REQUEST['pkgIndex']]['qty'] = $varqty;
                    $Qty += $varqty;
                }
            }
            else
            {
                //echo '1';die;
                $Qty += $_SESSION['MyCart']['Product'][$_REQUEST['pid']][$_REQUEST['pkgIndex']]['qty'];
                $arrError[$valC] = $objShoppingCart->getProductById($valC) . ' : ' . PRODUCT_ADD_IN_SHOPING_CART_OUT_OF_STOCK;
            }

            $updatePrice = $pri * $_SESSION['MyCart']['Product'][$_REQUEST['pid']][$_REQUEST['pkgIndex']]['qty'];
        }
        else if ($_REQUEST['type'] == 'package')
        {
            $varqty1 = (int) $_REQUEST['qty'];
            if ($varqty1 > 0)
            {
                $packageIndex = $_REQUEST['pkgIndex'];
                $_SESSION['MyCart']['Package'][$_REQUEST['pid']][$packageIndex]['qty'] = $varqty1;
                $Qty += $varqty1;
            }

            $updatePrice = $pri * $_SESSION['MyCart']['Package'][$_REQUEST['pid']][$packageIndex]['qty'];
        }
        else if ($_REQUEST['type'] == 'gift')
        {
             $varqty2 = (int) $_REQUEST['qty'];
            if ($varqty2 > 0)
            {
                //pre($_REQUEST);
                $packageIndex = $_REQUEST['pkgIndex'];
                $_SESSION['MyCart']['GiftCard'][$_REQUEST['pid']]['qty'] = $varqty2;
                $Qty += $varqty2;
            }

            $updatePrice = $pri * $_SESSION['MyCart']['GiftCard'][$_REQUEST['pid']]['qty'];
        }
        //echo $_SESSION['MyCart']['Total'].'...'.$Qty.'...'.$oldQty.'...';
        //$ypdateQuentity = $Qty - $oldQty;
        if ($Qty == $oldQty)
        {
            $_SESSION['MyCart']['Total'] = $_SESSION['MyCart']['Total'];
        }
        else if ($Qty > $oldQty)
        {
            $_SESSION['MyCart']['Total'] = $_SESSION['MyCart']['Total'] + ($Qty - $oldQty);
        }
        else if ($Qty < $oldQty)
        {
            $_SESSION['MyCart']['Total'] = $_SESSION['MyCart']['Total'] - ($oldQty - $Qty);
        }
        else
        {
            $_SESSION['MyCart']['Total'] = $_SESSION['MyCart']['Total'];
        }
        //echo $_SESSION['MyCart']['Total'];
//        if($ypdateQuentity<0){ echo $ypdateQuentity.'minus';
//          $_SESSION['MyCart']['Total'] = $_SESSION['MyCart']['Total']+$ypdateQuentity;  
//        }else{ echo $ypdateQuentity.'plus';
//            $_SESSION['MyCart']['Total'] = $_SESSION['MyCart']['Total']+$ypdateQuentity;
//        }
        // echo $_SESSION['MyCart']['Total'];die;
        //$_SESSION['MyCart']['Total'] =$_SESSION['MyCart']['Total'];
        $updatePrice = $objCore->getPrice($updatePrice);
        echo json_encode(array('Total' => $_SESSION['MyCart']['Total'], 'updatePrice' => $updatePrice, 'oldVal' => $Qty));
        break;

    case 'addToAjaxCartValue':
        echo $_SESSION['MyCart']['Total'];
        break;


    case 'sentToGiftCard':
        //pre($_POST);
        $arrGiftCard = $_POST;
        unset($arrGiftCard['action']);
        //pre($arrGiftCard);
        $_SESSION['MyCart']['GiftCard'][] = $arrGiftCard;
        $_SESSION['MyCart']['Total'] += (int) $_REQUEST['qty'];
        
        $varCartTotal = 0;
        $varCartSubTotal = 0;
        
        $arrData['arrCartDetails'] = $objShoppingCart->myCartDetails();
        //pre($arrData['arrCartDetails']);
        ?>
        <div class="my_cart">
            <h5 onclick="window.location='<?php echo $objCore->getUrl('shopping_cart.php'); ?>'"><?php echo MY; ?> <span><?php echo CART; ?></span></h5>
            <div class="my_cart_inner">
                <div <?php
        if (count($arrData['arrCartDetails']['Product']) + count($arrData['arrCartDetails']['Package']) + count($arrData['arrCartDetails']['GiftCard']) > LIST_CART_BOX_LIMIT)
        {
            ?> class="scroll-pane" <?php } ?>>


                    <ul>
                        <?php
                        $i = 0;
                        foreach ($arrData['arrCartDetails']['Product'] as $kCart => $valCart)
                        {
                            $varCartSubTotal = $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty'] * $valCart['FinalPrice'];
                            ?>
                            <li id="cart<?php echo $valCart['pkProductID']; ?>">
                                <div class="bottom_border">
                                    <?php
                                    $varSrc = $objCore->getImageUrl($valCart['ImageName'], 'products/' . $arrProductImageResizes['default']);
                                    ?>
                                    <div class="image"><a href="<?php echo $objCore->getUrl('product.php', array('id' => $valCart['pkProductID'], 'name' => $valCart['ProductName'], 'refNo' => $valCart['pkProductID'])); ?>"><img src="<?php echo $varSrc; ?>" alt="<?php echo $valCart['ProductName']; ?>" width="40" height="38" /></a>

                                    </div>
                                    <div class="details">
                                        <a href="<?php echo $objCore->getUrl('product.php', array('id' => $valCart['pkProductID'], 'name' => $valCart['ProductName'], 'refNo' => $valCart['pkProductID'])); ?>"><?php echo ucfirst($valCart['ProductName']); ?></a><br />
                                        <span><?php echo $valCart['attribute']; ?></span><br/>
                                        <span class="amt_qty"><?php echo $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty']; ?> x <?php echo $objCore->getPrice($valCart['FinalPrice']); ?></span>
                                        <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                    </div></div>
                                <div class="delete"><a href="#" onclick="RemoveProductFromCart(<?php echo $valCart['pkProductID']; ?>, <?php echo $_SESSION['MyCart']['Product'][$valCart['pkProductID']][$kCart]['qty']; ?>,'<?php echo $kCart; ?>');"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" /></a></div>
                            </li>
                            <?php
                            $varCartTotal += $varCartSubTotal;
                            $i++;
                        }


                        foreach ($arrData['arrCartDetails']['Package'] as $kPKG => $vPKG)
                        {
                            $varCartSubTotal = $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty'] * $vPKG['PackagePrice'];
                            ?>
                            <li id="cart<?php echo $vPKG['pkProductID']; ?>">
                                <div class="bottom_border">
                                    <?php
                                    $varPackageSrc = $objCore->getImageUrl($vPKG['PackageImage'], 'package/' . PACKAGE_IMAGE_RESIZE1);
                                    ?>
                                    <div class="image"><a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>"><img src="<?php echo $varPackageSrc; ?>" alt="<?php echo $vPKG['PackageName']; ?>" width="40" height="38" /></a>

                                    </div>
                                    <div class="details">
                                        <a href="<?php echo $objCore->getUrl("package.php", array('pkgid' => $vPKG['pkPackageId'])); ?>"><?php echo ucfirst($vPKG['PackageName']); ?></a><br />
                                        <span class="amt_qty"><?php echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']; ?> x <?php echo $objCore->getPrice($vPKG['PackagePrice']); ?></span>
                                        <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                    </div></div>
                                <div class="delete"><a href="#" onclick="RemovePackageFromCart(<?php echo $vPKG['pkPackageId']; ?>,<?php echo $_SESSION['MyCart']['Package'][$vPKG['pkPackageId']][$kPKG]['qty']; ?>,'<?php echo $kPKG; ?>');"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" /></a></div>
                            </li>
                            <?php
                            $varCartTotal += $varCartSubTotal;
                        }

                        foreach ($arrData['arrCartDetails']['GiftCard'] as $key => $valGiftCards)
                        {
                            $varCartSubTotal = $valGiftCards['qty'] * $valGiftCards['amount'];
                            ?>
                            <li id="RemoveGiftCard<?php echo $key; ?>">
                                <div class="bottom_border">
                                    <?php
                                    $varSrc = $objCore->getImageUrl('', 'gift_card');
                                    ?>
                                    <div class="image"><img src="<?php echo $varSrc; ?>" alt=" <?php echo ucfirst(substr($valGiftCards['message'], 0, 15)); ?>" width="40" height="38" />

                                    </div>
                                    <div class="details">
                                        <?php echo ucfirst(substr($valGiftCards['message'], 0, 15)); ?><br />
                                        <span class="amt_qty"><?php echo $valGiftCards['qty']; ?> x <?php echo $valGiftCards['amount']; ?></span>
                                        <h5><?php echo $objCore->getPrice($varCartSubTotal); ?></h5>
                                    </div></div>
                                <div class="delete"><a href="javascript:void(0);" onclick="RemoveGiftCardFromCart('<?php echo $key; ?>',<?php echo $valGiftCards['qty']; ?>);"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>close.png" alt="Close" /></a></div>
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
                    <?php echo SUBTOTAL; ?>
                    <span><?php echo $objCore->getPrice($varCartTotal); ?></span>
                </div>
                <a href="<?php echo $objCore->getUrl('shopping_cart.php') ?>" class="checkout_button"><?php echo CHECKOUT; ?></a>
            </div>
        </div>
        <?php
//print_r($_SESSION);
        break;

    case 'RemoveGiftCardFromCart':
        //echo $_SESSION['MyCart']['Total'] -= $_SESSION['MyCart']['GiftCard'][$_REQUEST['pid']]['qty'];

        $qty = isset($_SESSION['MyCart']['GiftCard'][$_REQUEST['pid']]['qty']) ? $_SESSION['MyCart']['GiftCard'][$_REQUEST['pid']]['qty'] : $_REQUEST['qty'];

        echo $_SESSION['MyCart']['Total'] -= $qty;

        if (isset($_SESSION['MyCart']['GiftCard'][$_REQUEST['pid']]))
        {
            unset($_SESSION['MyCart']['GiftCard'][$_REQUEST['pid']]);
        }

        break;

    case 'checkCartProductQuantity':
        $objProduct = new Product();
        $flag = 1;
        foreach ($_SESSION['MyCart']['Product'] AS $key => $prod)
        {
            $arrClms = array('Quantity');
            $argWhere = 'pkProductID = ' . $key;
            $varTable = TABLE_PRODUCT;
            $arrRes = $objProduct->select($varTable, $arrClms, $argWhere, $varOrderBy);
            if ($arrRes[0]['Quantity'] < $prod['qty'])
            {
                $flag = "0";
                break;
            }
        }
        echo $flag;
        break;
}
$objShoppingCart->updateCart();
?>
