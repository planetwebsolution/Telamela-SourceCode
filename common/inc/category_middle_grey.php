<?php
//pre($objPage->arrProductDetails);
$i = 1;
$varImageSize = @explode('x', (string) $arrProductImageResizes['global']);
foreach ($objPage->arrProductDetails as $productdetails)
{
    if ($i > $objPage->lagyPageLimit)
    {
        break;
    }
    else
    {
        $varSrc = $objCore->getImageUrl($productdetails['ProductImage'], 'products/' . $arrProductImageResizes['listing']);
        if ($productdetails['Quantity'] == 0)
        {
            $varAddCartUrl = 'class="cart2 outOfStock info clear_stock"';
            $addToCart = OUT_OF_STOCK;
            $addToCartImg = 'outofstock_icon.png';
        }
        else
        {
            $addToCart = ADD_TO_CART;
            $addToCartImg = 'cart_icon.png';

            if (count($productdetails['arrAttributes']) == 0)
            {
                //$varAddCartUrl = 'href="#product' . $productdetails['pkProductID'] . '" class="cart2 addCart" onclick="addToCart(' . $productdetails['pkProductID'] . ')" ';
                $varAddCartUrl = 'href="' . $objCore->getUrl('common/ajax/ajax_cart.php', array('action' => 'addToCart', 'pid' => $productdetails['pkProductID'], 'qty' => '1')) . '" class="info cart2 addCart ' . $productdetails['pkProductID'] . '" onclick="addToCart(' . $productdetails['pkProductID'] . ')" ';
            }
            else
            {
                $varAddCartUrl = 'href="' . $objCore->getUrl('product.php', array('id' => $productdetails['pkProductID'], 'name' => $productdetails['ProductName'], 'refNo' => $productdetails['ProductRefNo'], 'add' => 'addCart')) . '#addCart" class="info cart2 addCart" ';
            }
        }
        $varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/' . $arrProductImageResizes['global'] . '/' . $productdetails['ProductImage'];
        ?>
        <div class="grid_product">

            <div class="cart_img">
                <a href="<?php echo $objCore->getUrl('product.php', array('id' => $productdetails['pkProductID'], 'name' => $productdetails['ProductName'], 'refNo' => $productdetails['ProductRefNo'], 'add' => 'addCart')); ?>">
                    <img  width="<?php echo $varImageSize[0]; ?>" height="<?php echo $varImageSize[1]; ?>" src="<?php echo $objCore->getImageUrl($productdetails['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" alt="<?php echo $productdetails['ProductName'] ?>"/>
                </a>
            </div>
            <div class="right_product"><div class="quick_title_1"><span><?php echo $objCore->getProductName($productdetails['ProductName'], 30); ?></span>	</div>

                <div class="content_left">
                    <?php
                    if($productdetails['offerPrice']>0 && $productdetails['offerPrice']!=''){ ?>
                        <div class="price">
                        <?php echo $objCore->getFinalPrice($productdetails['FinalPrice'], $productdetails['offerPrice'], $productdetails['SpecialFinalPrice'], 0, 1);
                        $varProductPrice = $objCore->getFinalPrice($productdetails['FinalPrice'], $productdetails['offerPrice'], $productdetails['SpecialFinalPrice'], 1, 1);
                        $varProductPrice = $objCore->getPrice($varProductPrice);
                        if ($productdetails['offerPrice'] > 0) {
                        $getDValue = $productdetails['FinalPrice'] - $objCore->getSavePrice($productdetails['DiscountFinalPrice'],$productdetails['offerPrice']);
                        ?>
                        <span>You Save <cite><?php echo $objCore->getPrice($getDValue); ?></cite></span>
                        <?php } ?>
                    </div>
                    <?php }else{ ?>
                        <div class="price">
                        <?php echo $objCore->getFinalPrice($productdetails['FinalPrice'], $productdetails['DiscountFinalPrice'], $productdetails['SpecialFinalPrice'], 0, 1); ?>
                        <?php if($productdetails['DiscountFinalPrice']> 0){ ?>
                        <span>You Save <cite><?php echo $objCore->getPrice($productdetails['FinalPrice'] - $objCore->getSavePrice($productdetails['DiscountFinalPrice'],$productdetails['FinalSpecialPrice'])); ?></cite></span>
                        <?php } ?>
                    </div>
                   <?php }  ?>
                    
                    <div class="inner_rating avg_rating rating category_rating">
                        <?php
                        $arrRatingDetails = $objComman->myRatingDetails($productdetails['pkProductID']);
                        $productRate = ($arrRatingDetails[0]['numRating']) / ($arrRatingDetails[0]['numCustomer']);
                        echo $objComman->getRatting($productRate);
                        ?>
                    </div>
                    <p class="content_txt1"><?php echo $objCore->getProductName($productdetails['ProductDescription'], 200); ?></p>



                </div>

                <div class="contnet_right">

                    <p class="" style="padding-top:10px;background:none;">

                        <?php
                        if ($_SESSION['sessUserInfo']['type'] == 'customer')
                        {
                            ?>
                            <a class="watch_link1" href="javascript:void('0');" onclick="addToWishlist(<?php echo $productdetails['pkProductID']; ?>)">Add to Save List</a>
                            <?php
                        }
                        else
                        {
                            ?>
                            <a class="watch_link1" href="javascript:void('0');" onclick="addToWishlistLogin(<?php echo $productdetails['pkProductID']; ?>)">Add to Save List</a>
                        <?php } ?>
                        <a cmCid="<?php echo $productdetails['pkCategoryId']; ?>" cmPid="<?php echo $productdetails['pkProductID']; ?>" id="CompareCheckBox<?php echo $productdetails['pkProductID']; ?>" class="compare_quick" onclick="addToCompare(<?php echo $productdetails['pkProductID']; ?>,<?php echo $productdetails['pkCategoryId']; ?>,'<?php echo $objCore->getUrl('product_comparison.php'); ?>');" href="javascript:void('0');">Compare</a> </p>
                    <div class="succCategoryCart" id="<?php echo $productdetails['pkProductID']; ?>">&nbsp;</div>
                    <div id="addtoCompareMessage<?php echo $productdetails['pkProductID']; ?>" class="addtoCompareMessage"></div>
                    
                    </p>

                </div>

                <div class="save_sction">
                    <a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $productdetails['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $productdetails['pkProductID']; ?>');" class=" compare_btn_sh quick QuickView<?php echo $productdetails['pkProductID']; ?>" title="<?php echo QUICK_OVERVIEW; ?>">Quick View</a>     <?php
                if ($addToCart == OUT_OF_STOCK)
                {
                            ?>
                        <a <?php echo $varAddCartUrl; ?> title="<?php echo $addToCart; ?>"><?php echo $addToCart; ?></a>
                        <?php
                    }
                    else
                    {
                        if ($_SESSION['sessUserInfo']['type'] == 'customer')
                        {
                            if (in_array($productdetails['pkProductID'], $objPage->arrData['arrWishListOfCustomer']))
                            {
                                ?>
                                <a href='#' class='cart_link_1 afterSavedInWishList' style='background:red;color:white'>Saved</a>
                                <?php
                            }
                            else
                            {
                                ?>
                                <a href="#" class="cart_link_1 saveTowishlist <?php echo $productdetails['pkProductID']; ?>" id="<?php echo $productdetails['pkProductID']; ?>" Pid="<?php echo $productdetails['pkProductID']; ?>" tp="category_grey">Save</a>
                                <?php
                            }
                        }
                        else
                        {
                            ?>
                            <a href="#loginBoxReview" class=" shopping_update2  cart_link_1 jscallLoginBoxReview" onclick="jscallLoginBoxCustomer('jscallLoginBoxReview', 'wish',<?php echo $productdetails['pkProductID']; ?>);" >Save</a>
                            <?php
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
        <?php
    } $i++;
}
?>
