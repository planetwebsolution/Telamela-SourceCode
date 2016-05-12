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
require_once CONTROLLERS_PATH . FILENAME_SPECIAL_CTRL;
$objComman = new ClassCommon();

$action = $_REQUEST['action'];

switch ($action) {

    case 'showSpecialProducts':
        // pre($objPage->arrProduct);

        if (count($objPage->arrProduct) > 0) {
            ?>
            <div class="breadcurmb_spcl">
                <?php
                if (isset($_REQUEST['cid'])) {
                    echo $objPage->varBreadcrumbs;
                }
                ?>&nbsp;
            </div>
            <?php
            foreach ($objPage->arrProduct as $k => $v) {
                ?>

                <div class="spacial_head">
                    <h3>
                        <span>Top Special in <?php echo $v['CategoryName']; ?></span>
                    </h3>
                </div>
                <div class="owl-carousel carousel_slider">
                    <?php
                    foreach ($v['Products'] as $key => $val) {
                        if ($val['Quantity'] == 0) {
                            $varAddCartUrl = 'class="cart2 outOfStock"';
                            $addToCart = OUT_OF_STOCK;
                        } else {
                            $addToCart = ADD_TO_CART;
                            if ($val['Attribute'] == 0) {
                                $varAddCartUrl = 'href="' . $objCore->getUrl('common/ajax/ajax_cart.php', array('action' => 'addToCart', 'pid' => $val['pkProductID'], 'qty' => '1')) . '" class="cart2 addCart ' . $val['pkProductID'] . '" onclick="addToCart(' . $val['pkProductID'] . ')" ';
                            } else {
                                $varAddCartUrl = 'href="' . $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'],'add'=>'addCart')) . '#addCart" class="cart2 addCart" ';
                            }
                        }
                        ?>
                        <div class="item">
                            <div class="thumbdetail_outer">
                                <div class="thumb_outer">
                                    <div class="thumb_img">
                                        <img src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/' . $arrProductImageResizes['special']); ?>" alt="<?php echo $val['ProductName'] ?>"/>
                                        <div class="miniBoxHoverSpecial">
                                            <a <?php echo $varAddCartUrl; ?>><span><?php echo $addToCart; ?></span></a>
                                            <a href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'])); ?>" class="proBtn"><span><?php echo PRODUCT_DETAILS; ?></span></a>
                                            <a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $val['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $val['pkProductID']; ?>');" class="qckView quick QuickView<?php echo $val['pkProductID']; ?>"><span><?php echo QUICK_OVERVIEW; ?></span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="detail_bot">
                                    <p><?php echo $objCore->getProductName($val['ProductName'], 35); ?></p>
                                    <strong><?php echo $objCore->getPrice($val['FinalSpecialPrice']); ?></strong>
                                </div>                                    
                                <?php
                                $dis = (($val['FinalPrice'] - $val['FinalSpecialPrice']) / $val['FinalPrice']) * 100;
                                ?>                                    
                                <div class="offer">
                                    <div class="offPriceText">
                                        <span><?php echo round($dis); ?>% off</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="no_product_special">
                <?php echo NO_PRODUCT; ?>
            </div>
        <?php } ?>
        <?php
        break;
}
?>
