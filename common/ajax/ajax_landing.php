<?php
/* * ****************************************
  Module name : Ajax Calls
  Date created : 13 March, 2014
  Date last modified : 13 March, 2014
  Author : Suraj Kumar Maurya
  Last modified by :  Suraj Kumar Maurya
  Comments : This file used to get special product for AJAX calls.
  Copyright : Copyright (C) 1999-2014 Vinove Software and Services
 * **************************************** */

require_once('../config/config.inc.php');
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;
require_once CONTROLLERS_PATH . FILENAME_LANDING_CTRL;
$objComman = new ClassCommon();

$action = $_REQUEST['action'];
//pre($_REQUEST);
switch ($action) {

    case 'showLandingProducts':

        $i = 1;
        foreach ($objPage->arrProduct as $key => $val) {
            $last = ($i % 5 == 0) ? 'class="last sec"' : 'class="sec"';
            if ($val['Quantity'] == 0) {
                $varAddCartUrl = 'class="cart2 outOfStock"';
                $addToCart = OUT_OF_STOCK;
				$addToCartImg = 'outofstock_icon.png';
            } else {
                $addToCart = ADD_TO_CART;
				$addToCartImg = 'cart_icon.png';
                if ($val['Attribute'] == 0) {
                    $varAddCartUrl = 'href="' . $objCore->getUrl('common/ajax/ajax_cart.php', array('action' => 'addToCart', 'pid' => $val['pkProductID'], 'qty' => '1')) . '" class="cart2 addCart ' . $val['pkProductID'] . '" onclick="addToCart(' . $val['pkProductID'] . ')" ';
                } else {
                    $varAddCartUrl = 'href="' . $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' =>  $val['ProductName'], 'refNo' =>  $val['ProductRefNo'],'add'=>'addCart')) . '#addCart" class="cart2 addCart" ';
                }
            }
            $varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/157x157/'.$val['ProductImage'];
            if(file_exists($varImgPath) && $val['ProductImage']!=''){
            ?>
            <li <?php echo $last; ?>>
                <div class="thumbdetail_outer">
                    <div class="thumb_outer">
                        <div class="thumb_img">
                            <img src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/' . $arrProductImageResizes['special']); ?>" alt="<?php echo $val['ProductName'] ?>"/>
                            <div class="miniBoxHoverSpecial">
								<div class="in_hoverbox">
                                    <a <?php echo $varAddCartUrl; ?> title="<?php echo $addToCart; ?>"><img src="<?php echo IMAGES_URL.$addToCartImg; ?>" /></a>
                                <a href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'])); ?>" class="proBtn"><img src="<?php echo IMAGES_URL; ?>details_icon.png" /></a>
                                <a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $val['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $val['pkProductID']; ?>');" class="qckView quick QuickView<?php echo $val['pkProductID']; ?>"><img src="<?php echo IMAGES_URL; ?>quickview_icon.png" /></a>
									<div class="clear"></div>
								</div>
                            </div>
                        </div>
                    </div>
                    <div class="detail_bot">
						<div class="in_hoverbox">
                        <p><?php echo $objCore->getProductName($val['ProductName'], 35); ?></p>
                        <strong>
                            <?php
                            // echo $val['FinalPrice'];
                            $arrPrice = $objCore->getFinalPriceWithOffer($val['FinalPrice'], $val['DiscountFinalPrice'], $arrSpecialProductPrice[$val['pkProductID']]['FinalSpecialPrice']);
                            echo $arrPrice['price'];
                            ?>
                        </strong>
						</div>
                    </div>
                    <?php if ($arrPrice['off'] > 0) { ?>
                        <div class="offer">
                            <div class="offPriceText"><span><?php echo $arrPrice['off']; ?>% off</span></div>
                        </div>
                    <?php } ?>
                </div>
            </li>
            <?php
            $i++;
            }
        }

        break;
}
?>
