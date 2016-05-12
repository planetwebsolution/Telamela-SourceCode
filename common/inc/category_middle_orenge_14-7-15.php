<?php
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
            $varAddCartUrl = 'class="cart2 outOfStock info"';
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
        <div class="view view-first">
            <div class="image_new">
                <img  width="<?php echo $varImageSize[0]; ?>" height="<?php echo $varImageSize[1]; ?>"src="<?php echo $objCore->getImageUrl($productdetails['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" alt="<?php echo $productdetails['ProductName'] ?>"/>
                <div class="new_heading"><?php echo $objCore->getProductName($productdetails['ProductName'], 39); ?></div>
        <?php
        //echo $productdetails['FinalPrice'].'..'.$productdetails['offerPrice'].'..'.$productdetails['SpecialFinalPrice'];
        if($productdetails['offerPrice']>0 && $productdetails['offerPrice']!=''){ 
         $arrPrice = $objCore->getFinalPriceWithOffer($productdetails['FinalPrice'], $productdetails['offerPrice'], $productdetails['SpecialFinalPrice']);
        }else{
        $arrPrice = $objCore->getFinalPriceWithOffer($productdetails['FinalPrice'], $productdetails['DiscountFinalPrice'], $productdetails['SpecialFinalPrice']);    
        }
        //echo $arrPrice['off'];
        if ($arrPrice['off'] > 0)
        {
            ?>
        <div class="discount_new"><?php echo $productdetails['DiscountPercent']; ?>%<span>OFF</span></div>
        <?php } ?>
                <div class="price_new">
                    <?php
                    if($productdetails['offerPrice']>0 && $productdetails['offerPrice']!=''){
                    echo $objCore->getFinalPrice($productdetails['FinalPrice'], $productdetails['offerPrice'], $productdetails['FinalSpecialPrice'], 0, 1);
                    }else{
                     echo $objCore->getFinalPrice($productdetails['FinalPrice'], $productdetails['DiscountFinalPrice'], $productdetails['FinalSpecialPrice'], 0, 1);   
                    }
                    
                    //echo $objCore->getFinalPrice($productdetails['FinalPrice'], $productdetails['DiscountFinalPrice'], $productdetails['FinalSpecialPrice'], 0, 1);
                    ?></div>
                <!--<div class="unactive"><?php //echo $objCore->getProductName($productdetails['ProductDescription'], 20); ?> </div>-->
            </div>
            <div class="mask">
                <h2><a href="<?php echo $objCore->getUrl('product.php', array('id' => $productdetails['pkProductID'], 'name' => $productdetails['ProductName'], 'refNo' => $productdetails['ProductRefNo'], 'add' => 'addCart')); ?>"><?php echo $productdetails['ProductName']; ?></a></h2>
                <p class="productPointer"><?php //echo $objCore->getProductName($val['ProductDescription'], 20);  ?></p>
                <div class="mask_box">
                    <a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $productdetails['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $productdetails['pkProductID']; ?>');" class="info quick QuickView<?php echo $productdetails['pkProductID']; ?>" title="<?php echo QUICK_OVERVIEW; ?>"><?php echo QUICK_OVERVIEW; ?></a>
                    <?php if ($addToCart == OUT_OF_STOCK)
                    { ?>
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
                                <a href='#' class='info afterSavedInWishList' style='background:red;color:white'>Saved</a>
                <?php }
                else
                { ?>
                                <a href="#" class="info saveTowishlist orenge_<?php echo $productdetails['pkProductID']; ?>"  Pid="<?php echo $productdetails['pkProductID']; ?>" tp="category_orenge">Save</a>
                <?php }
            }
            else
            {
                ?>
                            <a href="#loginBoxReview" class="info jscallLoginBoxReview" onclick="jscallLoginBoxCustomer('jscallLoginBoxReview', 'wish',<?php echo $productdetails['pkProductID']; ?>);" >Save</a>
            <?php }
        }
        ?>
                </div>

            </div>
        </div>

    <?php } $i++;
} ?>