<!--Start Right Section-->
<?php
//Advertisement Start Here//
$arrAds = $objPage->arrData['ads'];
//pre($arrAds[0]['one']);

$i = 0;
$varImageSize = @explode('x', (string) $arrProductImageResizes['global']);
?>

<div class="section_right" id="section_right_add_home">
    <input type="hidden" id="homeRightFirst" value="<?php echo (int) $arrAds[0]['one'];?>"/>
    <input type="hidden" id="homeRightTwo" value="<?php echo (int) $arrAds[0]['two'];?>"/>
    <input type="hidden" id="homeRightThree" value="<?php echo (int) $arrAds[0]['three'];?>"/>
    <input type="hidden" id="homeRightFour" value="<?php echo (int) $arrAds[0]['four'];?>"/>
    <input type="hidden" id="homeRightFive" value="<?php echo (int) $arrAds[0]['five'];?>"/>
    <?php
    if (count($arrAds) > 0)
    {
       // pre($arrAds);
        $cou=1;
        foreach ($arrAds as $ads)
        {
            if ($ads['AdType'] == 'link' && $ads['ImageName'] != '')
            {
                ?>
                <div class="banners_new" id="banners_<?php echo $cou;?>"><a href="<?php echo $ads['AdUrl']; ?>" target="_blank">
                        <img src="<?php echo UPLOADED_FILES_URL . "images/ads/276x160/" . $ads['ImageName']; ?>"  alt="<?php echo $ads['Title']; ?>" title="<?php echo $ads['Title']; ?>">
                    </a>
                </div>
                <?php
            }
            else if ($ads['AdType'] == 'html' && $ads['HtmlCode'] != '')
            {
                echo html_entity_decode($ads['HtmlCode']);
            }
        $cou++;}
        for($i=$cou;$i<=4;$i++)
        {
            ?>
          <div class="banners_new"><a href="contact.php"><img class="lazy" data-src="<?php echo UPLOADED_FILES_URL . 'images/ads/323x129/ads.jpg'; ?>" src="" alt="Post your Ads" title="Post your Ads"/></a></div>  
       <?php }
        
    }
    else
    {
        ?>
        <div class="banners_new"><a href="contact.php"><img  src="<?php echo UPLOADED_FILES_URL . 'images/ads/323x129/ads.jpg'; ?>" alt="Post your Ads" title="Post your Ads"/></a></div>
        <div class="banners_new"><a href="contact.php"><img class="lazy" data-src="<?php echo UPLOADED_FILES_URL . 'images/ads/323x129/ads.jpg'; ?>" src="" alt="Post your Ads" title="Post your Ads"/></a></div>
        <div class="banners_new"><a href="contact.php"><img class="lazy" data-src="<?php echo UPLOADED_FILES_URL . 'images/ads/323x129/ads.jpg'; ?>" src="" alt="Post your Ads" title="Post your Ads"/></a></div>
        <div class="banners_new"><a href="contact.php"><img class="lazy" data-src="<?php echo UPLOADED_FILES_URL . 'images/ads/323x129/ads.jpg'; ?>" src="" alt="Post your Ads" title="Post your Ads"/></a></div>
    <?php } ?>
</div>
<!--End Start Right Section-->
<?php
$totalPageCount = 0;
if (count($objPage->arrData['topSellingProducts']) > 0)
{
    ?>
    <div class="demo all_pro">
        <!--            Horizontal Tab-->
        <div class="horizontalTab">            <ul class="resp-tabs-list">
                <span  class="heading_main"> Best Seller</span>
                <div class="border_bar" style="width:105px"></div>
                <li style="cursor:default" >ALL PRODUCTS</li>
                <!--                  <li>MEN'S</li>
                          <li>WOMEN'S</li>-->
            </ul>
            <div class="customNavigation"> <a class="prev"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-left.png" alt=""> </a> <a class="next"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-right.png" alt=""></a> </div>
            <div class="resp-tabs-container">
                <div>
                    <div id="demo">
                        <div class="container">
                            <div class="row">
                                <div class="span12">
                                    <div  class="owl-demo1">
                                        <!--                                    Section Start-->
                                        <?php
                                        foreach ($objPage->arrData['topSellingProducts'] as $key => $val)
                                        {
                                            if ($val['Quantity'] == 0)
                                            {
                                                $varAddCartUrl = 'class="cart2 outOfStock info"';
                                                $addToCart = OUT_OF_STOCK;
                                                $addToCartImg1 = 'outofstock_icon.png';
                                            }
                                            else
                                            {
                                                $addToCart = ADD_TO_CART;
                                                $addToCartImg1 = 'cart_icon.png';
                                                if ($val['Attribute'] == 0)
                                                {
                                                    $varAddCartUrl = 'href="' . $objCore->getUrl('common/ajax/ajax_cart.php', array('action' => 'addToCart', 'pid' => $val['pkProductID'], 'qty' => '1')) . '" class="info cart2 addCart ' . $val['pkProductID'] . '" onclick="addToCart(' . $val['pkProductID'] . ')" ';
                                                }
                                                else
                                                {
                                                    $varAddCartUrl = 'href="' . $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')) . '#addCart" class="info cart2 addCart" ';
                                                }
                                            }
                                            ?>
                                            <div class="item">
                                                <div class="view view-first">
                                                    <div class="image_new">
                                                        <?php
                                                        //$varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/208x185/' . $val['ProductImage'];
                                                        ?>
                                                        <img width="<?php echo $varImageSize[0]; ?>" height="<?php echo $varImageSize[1] ?>" src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" alt="<?php echo $val['ProductName']; ?>"/>
                                                        <div class="new_heading">
                                                            <?php
                                                            echo $objCore->getProductName($val['ProductName'], 39);
                                                            ?></div>
                                                        <?php
                                                        if ($val['discountPercent'] > 0 && $val['discountPercent'] < 99)
                                                        {
                                                            ?>
                                                            <div class="discount_new"><?php echo $val['discountPercent']; ?>%<span>OFF</span></div>
                                                        <?php } ?>
                                                        <div class="price_new"><?php echo $objCore->getFinalPrice($val['FinalPrice'], $val['DiscountFinalPrice'], $val['FinalSpecialPrice'], 0, 1); ?></div>
                                                        <!--<div class="unactive"><?php //echo $objCore->getProductName($val['ProductDescription'], 20);                                                      ?> </div>-->
                                                    </div>
                                                    <div class="mask">
                                                        <h2><a href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')); ?>"><?php echo $val['ProductName']; ?></a></h2>
                                                        <p class="productPointer"></p>
                                                        <div class="mask_box">
                                                            <a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $val['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $val['pkProductID']; ?>');" class="info quick QuickView<?php echo $val['pkProductID']; ?>" title="<?php echo QUICK_OVERVIEW; ?>"><?php echo QUICK_OVERVIEW; ?></a>
                                                            <?php
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
                                                                    if (in_array($val['pkProductID'], $objPage->arrData['arrWishListOfCustomer'], true))
                                                                    {
                                                                        ?>
                                                                        <a href='#' class='info afterSavedInWishList' style='background:red;color:white'>Saved</a>
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                        <a href="#" class="info saveTowishlist saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" btcheck="saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" id="<?php echo $val['pkProductID']; ?>" Pid="<?php echo $val['pkProductID']; ?>">Save</a>
                                                                        <?php
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                    <a href="#loginBoxReview" class="info jscallLoginBoxReview" onclick="jscallLoginBoxCustomer('jscallLoginBoxReview', 'wish',<?php echo $val['pkProductID']; ?>);" >Save</a>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            //}
                                            $totalPageCount++;
                                        }
                                        ?>
                                        <!-- End Section Start -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br />
    </div>
<?php } ?>
<!-- Block Start-->
<div class="demo"> 
    <!--Horizontal Tab-->
    <div class="horizontalTab  border_none">
        <ul class="resp-tabs-list">
            <span  class="heading_main"> NEW ARRIVALS</span>
            <div class="border_bar" style="width:125px;"></div>
            <?php
            $varCatCount = 0;
           // pre($objPage->arrData['arrCategoryLatestPoducts']);
            foreach ($objPage->arrData['arrCategoryLatestPoducts'] as $catPro)
            {
                $varCatCount++;

                if (count($catPro['arrProducts']) > 2)
                {
                    if ($varCatCount < 7)
                    {
                        ?>
                        <li><?php echo strtoupper($catPro['arrCategory']['CategoryName']); ?></li>
                        <?php
                    }
                }
            }
            ?>
        </ul>
        <div class="customNavigation"> <a class="btn prev1"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-left.png" alt=""> </a> <a class="btn next1"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-right.png" alt=""></a> </div>
        <div class="resp-tabs-container">
            <?php
            $varCatCountTabs = 0;
            foreach ($objPage->arrData['arrCategoryLatestPoducts'] as $catPro)
            {
                $varCatCountTabs++;

                if (count($catPro['arrProducts']) > 2)
                {
                    if ($varCatCountTabs < 7)
                    {
                        ?>
                        <div>
                            <div id="demo">
                                <div class="container">
                                    <div class="row">
                                        <div class="span12">
                                            <div  class="owl-carousel owl-demo2">
                                                <?php
                                                $i = 0;
                                                foreach ($catPro['arrProducts'] as $key => $val)
                                                {  //echo $val['Quantity'];
                                                    if ($val['Quantity'] == 0)
                                                    {
                                                        $varAddCartUrl = 'class="cart2 outOfStock info"';
                                                        $addToCart = OUT_OF_STOCK;
                                                        $addToCartImg1 = 'outofstock_icon.png';
                                                    }
                                                    else
                                                    {
                                                        $addToCart = ADD_TO_CART;
                                                        $addToCartImg1 = 'cart_icon.png';
                                                        if ($val['Attribute'] == 0)
                                                        {
                                                            $varAddCartUrl = 'href="' . $objCore->getUrl('common/ajax/ajax_cart.php', array('action' => 'addToCart', 'pid' => $val['pkProductID'], 'qty' => '1')) . '" class="info cart2 addCart ' . $val['pkProductID'] . '" onclick="addToCart(' . $val['pkProductID'] . ')" ';
                                                        }
                                                        else
                                                        {
                                                            $varAddCartUrl = 'href="' . $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')) . '#addCart" class="info cart2 addCart" ';
                                                        }
                                                    }
                                                    ?>

                                                    <!--Section Start-->
                                                    <div class="item">
                                                        <div class="view view-first">
                                                            <div class="image_new">
                                                                <?php
                                                                $varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/208x185/' . $val['ProductImage'];
                                                                ?>
                                                                <img width="<?php echo $varImageSize[0]; ?>" height="<?php echo $varImageSize[1]; ?>" class="lazy" data-src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" src="" alt="<?php echo $val['ProductName'] ?>"/>


                                                                <div class="new_heading">
                                                                    <?php
                                                                    echo $objCore->getProductName($val['ProductName'], 39);
                                                                    ?>
                                                                </div>
                                                                <?php
                                                                if ($val['discountPercent'] > 0 && $val['discountPercent'] < 99)
                                                                {
                                                                    ?>
                                                                    <div class="discount_new"><?php echo $val['discountPercent']; ?>%<span>OFF</span></div>
                                                                <?php } ?>
                                                                <div class="price_new"><?php echo $objCore->getFinalPrice($val['FinalPrice'], $val['DiscountFinalPrice'], $val['FinalSpecialPrice'], 0, 1); ?></div>
                                                                <!--<div class="unactive"><?php // echo $objCore->getProductName($val['ProductDescription'], 20);                                                    ?> </div>-->
                                                            </div>
                                                            <div class="mask">
                                                                <h2><a href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')); ?>"><?php
                                                echo $val['ProductName'];
                                                                ?></a></h2>
                                                                <p class="productPointer"><?php //echo $objCore->getProductName($val['ProductDescription'], 40);                                                    ?></p>
                                                                <div class="mask_box">
                                                                    <a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $val['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $val['pkProductID']; ?>');" class="info qckView quick QuickView<?php echo $val['pkProductID']; ?>" title="<?php echo QUICK_OVERVIEW; ?>"><?php echo QUICK_OVERVIEW; ?></a>
                                                                    <?php
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
                                                                            if (in_array($val['pkProductID'], $objPage->arrData['arrWishListOfCustomer'], true))
                                                                            {
                                                                                ?>
                                                                                <a href='#' class='info afterSavedInWishList' style='background:red;color:white'>Saved</a>
                                                                                <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <a href="#" class="info saveTowishlist saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" btcheck="saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" id="<?php echo $val['pkProductID']; ?>" Pid="<?php echo $val['pkProductID']; ?>">Save</a>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <a href="#loginBoxReview" class="info jscallLoginBoxReview" onclick="jscallLoginBoxCustomer('jscallLoginBoxReview', 'wish',<?php echo $val['pkProductID']; ?>);" >Save</a>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    //}
                                                    $totalPageCount++;
                                                }
                                                ?>
                                                <!--End Section Start-->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </div>
    </div>
    <br />
</div>
<!-- End Block Start--> 
<!-- Block Start-->
<?php
$arrTopRatedProds = $objPage->arrData['topRatedProducts'];

if (count($arrTopRatedProds) > 0)
{
    ?>
    <div class="demo border_outer pos_relative" >
        <!--Horizontal Tab-->
        <div class="horizontalTab" style="position:relative">
            <ul class="resp-tabs-list"  style="width:1140px">
                <span  class="heading_main">Top Rated</span>
                <div class="border_bar" style="width:93px;"></div>
                <?php
                $varTopCatCount = 0;

                foreach ($objPage->arrData['topRatedProducts'] as $key => $topCatPro)
                {
                    $varTopCatCount++;
                    if (count($objPage->arrData['topRatedProducts'][$key]))
                    {
                        ?>
                        <li><?php echo strtoupper($topCatPro[0]['CategoryName']); ?></li>
                        <?php
                    }
                }
                ?>
            </ul>
            <a class="btn next2 prev3my"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-right.png" alt=""></a>
            <div class="resp-tabs-container my_resp-tabs-container top_rated1" style="width:1140px;">
                <?php
                $varTopCatTabCount = 0;
                //pre($arrTopRatedProds);
                foreach ($objPage->arrData['topRatedProducts'] as $key => $topCatPro)
                {
                    $varTopCatTabCount++;
                    if (count($objPage->arrData['topRatedProducts'][$key]))
                    {
                        ?>
                        <div>
                            <div id="demo"> <a class="btn prev2 prev2my"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-left.png" alt=""> </a>
                                <div class="container">
                                    <div class="row">
                                        <div class="span12">
                                            <div  class="owl-carousel owl-demo3">
                                                <!--Section Start-->
                                                <?php
                                                foreach ($objPage->arrData['topRatedProducts'][$key] as $key => $val)
                                                {
                                                    if ($val['Quantity'] == 0)
                                                    {
                                                        $varAddCartUrl = 'class="cart2 outOfStock info btn_new"';
                                                        $addToCart = OUT_OF_STOCK;
                                                        $addToCartImg1 = 'outofstock_icon.png';
                                                    }
                                                    else
                                                    {
                                                        $addToCart = ADD_TO_CART;
                                                        $addToCartImg1 = 'cart_icon.png';
                                                        if ($val['Attribute'] == 0)
                                                        {
                                                            $varAddCartUrl = 'href="' . $objCore->getUrl('common/ajax/ajax_cart.php', array('action' => 'addToCart', 'pid' => $val['pkProductID'], 'qty' => '1')) . '" class="info btn_new cart2 addCart ' . $val['pkProductID'] . '" onclick="addToCart(' . $val['pkProductID'] . ')" ';
                                                        }
                                                        else
                                                        {
                                                            $varAddCartUrl = 'href="' . $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')) . '#addCart" class="info btn_new cart2 addCart" ';
                                                        }
                                                    }
                                                    // $varImgPathRight = UPLOADED_FILES_SOURCE_PATH . 'images/products/208x185/' . $val['ProductImage'];
                                                    //if(file_exists($varImgPathRight) && $val['ProductImage']!=''){
                                                    ?>
                                                    <div class="item">
                                                        <div class="view view-first">
                                                            <div class="image_new">
                                                                <?php
                                                                //$varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/208x185/' . $val['ProductImage'];

                                                                if (file_exists($varImgPath) && $val['ProductImage'] != '')
                                                                {
                                                                    ?>

                                                                    <img width="<?php echo $varImageSize[0]; ?>" height="<?php echo $varImageSize[1]; ?>" class="lazy" data-src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" src="" alt="<?php echo $val['ProductName'] ?>"/>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <!--<img src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/208x185'); ?>" alt="<?php echo $val['ProductName'] ?>"/>-->
                                                                    <?php
                                                                }
                                                                ?>

                                                                <div class="new_heading">
                                                                    <?php
                                                                    echo $objCore->getProductName($val['ProductName'], 39);
                                                                    ?>
                                                                </div>
                                                                <?php
                                                                if ($val['discountPercent'] > 0 && $val['discountPercent'] < 99)
                                                                {
                                                                    ?>
                                                                    <div class="discount_new"><?php echo $val['discountPercent']; ?>%<span>OFF</span></div>
                                                                <?php } ?>
                                                                <div class="price_new"><?php echo $objCore->getFinalPrice($val['FinalPrice'], $val['DiscountFinalPrice'], $val['FinalSpecialPrice'], 0, 1); ?></div>
                                                                <!--<div class="unactive"><?php //echo $objCore->getProductName($val['ProductDescription'], 40);                                                     ?> </div>-->
                                                                <div class="customer_rating home_top_rating">
                                                                    <?php
                                                                    $arrRatingDetails = $objComman->myRatingDetails($val['pkProductID']);
                                                                    //echo $arrRatingDetails[0]['numRating'];
                                                                    //echo $arrRatingDetails[0]['numCustomer'];
                                                                     $productRate = ($arrRatingDetails[0]['numRating']) / ($arrRatingDetails[0]['numCustomer']);
                                                                    echo $objComman->getRatting($productRate);
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class="mask">
                                                                <h2 class="heading_new"><a href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')); ?>"><?php echo $val['ProductName']; ?></a></h2>
                                                                <p class="productPointer"><?php //echo $objCore->getProductName($val['ProductDescription'], 40);                                                      ?></p>

                                                                <div class="mask_box">
                                                                    <a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $val['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $val['pkProductID']; ?>');" class="info btn_new qckView quick QuickView<?php echo $val['pkProductID']; ?>" title="<?php echo QUICK_OVERVIEW; ?>"><?php echo QUICK_OVERVIEW; ?></a>
                                                                    <?php
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
                                                                            if (in_array($val['pkProductID'], $objPage->arrData['arrWishListOfCustomer'], true))
                                                                            {
                                                                                ?>
                                                                                <a href='#' class='info afterSavedInWishList' style='background:red;color:white'>Saved</a>
                                                                                <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <a href="#" class="info saveTowishlist saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" btcheck="saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" id="<?php echo $val['pkProductID']; ?>" Pid="<?php echo $val['pkProductID']; ?>">Save</a>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <a href="#loginBoxReview" class="info jscallLoginBoxReview" onclick="jscallLoginBoxCustomer('jscallLoginBoxReview', 'wish',<?php echo $val['pkProductID']; ?>);" >Save</a>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    //}
                                                    $totalPageCount++;
                                                }
                                                ?>
                                                <!--End Section Start-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
<?php } ?>
<!-- End Block Start-->
<div class="media100">
    <div class="demo">
        <!--Horizontal Tab-->
        <div class="horizontalTab">
            <div class="customNavigation" style=" position:absolute; margin-left:760px; z-index:2147483647"> <a class="btn prev3"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-left.png" alt=""> </a> <a class="btn next3"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-right.png" alt=""></a> </div>
            <ul class="resp-tabs-list">
                <span  class="heading_main"> Most Discounted</span>
                <div class="border_bar" style=" width:164px"></div>
                <?php
                $varCatDisCount = 0;
                foreach ($objPage->arrData['arrHotDeals'] as $catPro)
                {
                    $varCatDisCount++;

                    if (count($catPro['arrCategory']) > 0)
                    {
                        if ($varCatDisCount < 7)
                        {
                            ?>
                            <li><?php echo strtoupper($catPro['arrCategory']['CategoryName']); ?></li>
                            <?php
                        }
                    }
                }
                ?>
            </ul>
            <div class="resp-tabs-container">
                <?php
                $varCatMostCountTabs = 0;
                foreach ($objPage->arrData['arrHotDeals'] as $catPro)
                {
                    $varCatMostCountTabs++;

                    if (count($catPro['arrProducts']) > 0)
                    {
                        if ($varCatMostCountTabs < 7)
                        {
                            ?>
                            <div>
                                <div id="demo">
                                    <div class="container">
                                        <div class="row">
                                            <div class="span12">
                                                <div  class="owl-carousel owl-demo4">
                                                    <!--Section Start-->

                                                    <?php
                                                    $i = 0;
                                                    foreach ($catPro['arrProducts'] as $key => $val)
                                                    { //pre($val); //echo $val['Quantity'];
                                                        if ($val['Quantity'] == 0)
                                                        {
                                                            $varAddCartUrl = 'class="cart2 outOfStock info"';
                                                            $addToCart = OUT_OF_STOCK;
                                                            $addToCartImg1 = 'outofstock_icon.png';
                                                        }
                                                        else
                                                        {
                                                            $addToCart = ADD_TO_CART;
                                                            $addToCartImg1 = 'cart_icon.png';
                                                            if ($val['Attribute'] == 0)
                                                            {
                                                                $varAddCartUrl = 'href="' . $objCore->getUrl('common/ajax/ajax_cart.php', array('action' => 'addToCart', 'pid' => $val['pkProductID'], 'qty' => '1')) . '" class="info cart2 addCart ' . $val['pkProductID'] . '" onclick="addToCart(' . $val['pkProductID'] . ')" ';
                                                            }
                                                            else
                                                            {
                                                                $varAddCartUrl = 'href="' . $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')) . '#addCart" class="info cart2 addCart" ';
                                                            }
                                                        }

                                                        //$varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/208x185/' . $val['ProductImage'];
                                                        // if(file_exists($varImgPath) && $val['ProductImage']!=''){
                                                        ?>

                                                        <!--Section Start-->
                                                        <div class="item">
                                                            <div class="view view-first">
                                                                <div class="image_new">
                                                                    <?php
                                                                    //$varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/208x185/' . $val['ProductImage'];

                                                                    if (file_exists($varImgPath) && $val['ProductImage'] != '')
                                                                    {
                                                                        ?>

                                                                        <img width="<?php echo $varImageSize[0]; ?>" height="<?php echo $varImageSize[1]; ?>" class="lazy" data-src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" src="" alt="<?php echo $val['ProductName'] ?>"/>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <!--<img src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/208x185'); ?>" alt="<?php echo $val['ProductName'] ?>"/>-->
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                        <img src="<?php echo IMAGES_URL; ?>guess.png" alt="">
                                                                    <?php }
                                                                    ?>
                                                                    <div class="new_heading">
                                                                        <?php
                                                                        echo $objCore->getProductName($val['ProductName'], 39);
                                                                        ?></div>
                                                                    <?php
                                                                    if ($val['discountPercent'] > 0 && $val['discountPercent'] < 99)
                                                                    {
                                                                        ?>
                                                                        <div class="discount_new"><?php echo $val['discountPercent']; ?>%<span>OFF</span></div>
                                                                    <?php } ?>
                                                                    <div class="price_new"><?php echo $objCore->getFinalPrice($val['FinalPrice'], $val['DiscountFinalPrice'], $val['FinalSpecialPrice'], 0, 1); ?></div>
                                                                    <!--<div class="unactive"><?php //echo $objCore->getProductName($val['ProductDescription'], 20);                                                      ?> </div>-->
                                                                </div>
                                                                <div class="mask">
                                                                    <h2><a href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')); ?>"><?php echo $val['ProductName']; ?></a></h2>
                                                                    <p class="productPointer"><?php //echo $objCore->getProductName($val['ProductDescription'], 40);                                                       ?></p>
                                                                    <div class="mask_box">
                                                                        <a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $val['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $val['pkProductID']; ?>');" class="info qckView quick QuickView<?php echo $val['pkProductID']; ?>" title="<?php echo QUICK_OVERVIEW; ?>"><?php echo QUICK_OVERVIEW; ?></a>
                                                                        <?php
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
                                                                                if (in_array($val['pkProductID'], $objPage->arrData['arrWishListOfCustomer'], true))
                                                                                {
                                                                                    ?>
                                                                                    <a href='#' class='info afterSavedInWishList' style='background:red;color:white'>Saved</a>
                                                                                    <?php
                                                                                }
                                                                                else
                                                                                {
                                                                                    ?>
                                                                                    <a href="#" class="info saveTowishlist saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" btcheck="saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" id="<?php echo $val['pkProductID']; ?>" Pid="<?php echo $val['pkProductID']; ?>">Save</a>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <a href="#loginBoxReview" class="info jscallLoginBoxReview" onclick="jscallLoginBoxCustomer('jscallLoginBoxReview', 'wish',<?php echo $val['pkProductID']; ?>);" >Save</a>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        //}
                                                        $totalPageCount++;
                                                    }
                                                    ?>

                                                    <!--End Section Start-->

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
            </div>
        </div>
        <br />
    </div>
    <!--             Block Start-->
    <?php
    if (count($objPage->arrData['arrWholesalerDetails']) > 0)
    {
        ?>
        <div class="main_verified">
            <div class="verfied"> <a class="btn prev6 veri_left"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_ver.jpg" alt=""> </a> <a class="btn next6 veri_right"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_ver_right.jpg" alt=""></a>
                <div class="veri_heading">Verified Suppliers</div>
                <p>Trade with Confidence across the globe.</p>
                <div id="demo">
                    <div class="container">
                        <div class="row">
                            <div class="span12">
                                <div  class="owl-demo6">
                                    <!--Section Start-->
                                    <?php
                                    //echo '<pre>';print_r($objPage->arrData['arrWholesalerDetails']);
                                    foreach ($objPage->arrData['arrWholesalerDetails'] as $wholeVal)
                                    {
//                               pre($wholeVal);
                                        ?>

                                        <div class="item">
                                            <div class="heading_new1">
                                                <a class="verified-supplier" href="<?php echo $objCore->getUrl('wholesaler_profile_customer_view.php', array('action' => 'view', 'wid' => $wholeVal['pkWholesalerID'])); ?>"><small><?php echo ucfirst($wholeVal['CompanyName']); ?></small></a>
                                            </div>
                                            <div class="veri_img">
                                                <a href="<?php echo $objCore->getUrl('wholesaler_profile_customer_view.php', array('action' => 'view', 'wid' => $wholeVal['pkWholesalerID'])); ?>">
                                                    <img class="lazy" data-src="<?php echo $objCore->getImageUrl($wholeVal['wholesalerLogo'], 'wholesaler_logo'); ?>" src="" alt="<?php echo $val['ProductName'] ?>" style='width:175px;height:90px;'/>
                                                </a>
                                            </div>
                                            <!--<div class="veri_txt"><?php echo $objCore->getProductName($wholeVal['Services'], 15); ?></div>-->
                                            <p class="verified_txt" ><?php echo $objCore->getProductName($wholeVal['AboutCompany'], 195); ?></p>
                                            <p class="connect"> Recents Connects  : <?php echo $wholeVal['CompanyPhone']; ?></p>
                                        </div>
                                    <?php } ?>
                                    <!--End Section Start-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

</div>

<?php
if (count($objPage->arrData['arrRecentlyViewedPoducts']) > 0)
{
    ?>
    <div class="demo border_outer pos_relative">	<!--Horizontal Tab-->
        <div class="horizontalTab border_change">
            <ul class="resp-tabs-list">
                <span  class="heading_main recom">Recently viewed</span>
                <div class="border_bar recom"></div>
            </ul>
            <div class="customNavigation"> <a class="btn prev4 myprev2"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-left.png" alt=""> </a> <a class="btn next4 myprev3"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-right.png" alt=""></a> </div>
            <div class="resp-tabs-container recnetly my_resp-tabs-container">
                <div>
                    <div id="demo">
                        <div class="container">
                            <div class="row">
                                <div class="span12">
                                    <div  class="owl-carousel owl-demo5">
                                        <!-- Section Start-->

                                        <?php
                                        foreach ($objPage->arrData['arrRecentlyViewedPoducts'] as $key => $val)
                                        {
                                            if ($val['Quantity'] == 0)
                                            {
                                                $varAddCartUrl = 'class="cart2 outOfStock info"';
                                                $addToCart = OUT_OF_STOCK;
                                                $addToCartImg1 = 'outofstock_icon.png';
                                            }
                                            else
                                            {
                                                $addToCart = ADD_TO_CART;
                                                $addToCartImg1 = 'cart_icon.png';
                                                if ($val['Attribute'] == 0)
                                                {
                                                    $varAddCartUrl = 'href="' . $objCore->getUrl('common/ajax/ajax_cart.php', array('action' => 'addToCart', 'pid' => $val['pkProductID'], 'qty' => '1')) . '" class="info cart2 addCart ' . $val['pkProductID'] . '" onclick="addToCart(' . $val['pkProductID'] . ')" ';
                                                }
                                                else
                                                {
                                                    $varAddCartUrl = 'href="' . $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')) . '#addCart" class="info cart2 addCart" ';
                                                }
                                            }

                                            //$varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/208x185/' . $val['ProductImage'];
                                            //if(file_exists($varImgPath) && $val['ProductImage']!=''){
                                            ?>
                                            <div class="item">
                                                <div class="view view-first">
                                                    <div class="image_new">
                                                        <?php
                                                        //$varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/208x185/' . $val['ProductImage'];
                                                        if (file_exists($varImgPath) && $val['ProductImage'] != '')
                                                        {
                                                            ?>

                                                            <img width="<?php echo $varImageSize[0]; ?>" height="<?php echo $varImageSize[1]; ?>" class="lazy" data-src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" src="" alt="<?php echo $val['ProductName'] ?>"/>
                                                                        <!--<img src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/208x185'); ?>" alt="<?php echo $val['ProductName'] ?>"/>-->
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <img src="<?php echo IMAGES_URL; ?>guess.png" alt="">
                                                        <?php }
                                                        ?>
                                                        <div class="new_heading">
                                                            <?php
                                                            echo $objCore->getProductName($val['ProductName'], 39);
                                                            ?></div>
                                                        <?php
                                                        if ($val['discountPercent'] > 0 && $val['discountPercent'] < 99)
                                                        {
                                                            ?>
                                                            <div class="discount_new"><?php echo $val['discountPercent']; ?>%<span>OFF</span></div>
                                                        <?php } ?>
                                                        <div class="price_new"><?php echo $objCore->getFinalPrice($val['FinalPrice'], $val['DiscountFinalPrice'], $val['FinalSpecialPrice'], 0, 1); ?></div>
                                                        <!--<div class="unactive"><?php //echo $objCore->getProductName($val['ProductDescription'], 20);                                                     ?> </div>-->
                                                    </div>
                                                    <div class="mask">
                                                        <h2><a href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')); ?>">
                                                                <?php echo $val['ProductName']; ?>
                                                            </a></h2>
                                                        <p class="productPointer"><?php //echo $objCore->getProductName($val['ProductDescription'], 20);                                                        ?></p>
                                                        <div class="mask_box">
                                                            <a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $val['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $val['pkProductID']; ?>');" class="info quick QuickView<?php echo $val['pkProductID']; ?>" title="<?php echo QUICK_OVERVIEW; ?>"><?php echo QUICK_OVERVIEW; ?></a>
                                                            <?php
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
                                                                    if (in_array($val['pkProductID'], $objPage->arrData['arrWishListOfCustomer'], true))
                                                                    {
                                                                        ?>
                                                                        <a href='#' class='info afterSavedInWishList' style='background:red;color:white'>Saved</a>
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                        <a href="#" class="info saveTowishlist saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" btcheck="saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" id="<?php echo $val['pkProductID']; ?>" Pid="<?php echo $val['pkProductID']; ?>">Save</a>
                                                                        <?php
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                    <a href="#loginBoxReview" class="info jscallLoginBoxReview" onclick="jscallLoginBoxCustomer('jscallLoginBoxReview', 'wish',<?php echo $val['pkProductID']; ?>);" >Save</a>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            //}
                                            $totalPageCount++;
                                        }
                                        ?>
                                        <!--End Section Start -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div> </div>
                <div> </div>
            </div>
        </div>
    </div>
<?php } ?>
<!--  End Block Start -->
<div style="display: none;">
    <div id="loginBoxReview">
        <div class="login_box">
            <div class="login_inner">
                <div class="heading">
                    <h3><?php echo SI_IN; ?> (Customer)</h3>
                    <div class="signup"> <a href="<?php echo $objCore->getUrl('registration_customer.php', array('type' => 'add')) ?>"><?php echo NEW_U_SI; ?></a> </div>
                </div>
                <div class="red" id="LoginErrorMsgRev"></div>

                <div class="form">
                    <label class="username">
                        <span><?php echo EM_ID; ?> :</span>
                        <input type="text" class="saved" placeholder="Email Id" autocomplete="off" value="<?php echo isset($_COOKIE['email_id']) ? $_COOKIE['email_id'] : ''; ?>" name="frmUserEmailLn" id="frmUserEmailLnRev"/>
                        <div class="frmUserEmailLn"></div>
                    </label>
                    <label class="password">
                        <span><?php echo PASSWORD; ?> :</span>
                        <input type="password" class="saved" placeholder="Password" value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>" autocomplete="off" name="frmUserPasswordLn" id="frmUserPasswordLnRev"/>
                        <div class="frmUserPasswordLn"></div>
                    </label>

                    <input type="hidden" name="frmProductToWish" id="frmProductToWish" value=""/>
                    <div class="simpleBox paddtop20">
                        
                        <div class="password_div"> <a href="#forgetPassword" onclick="return jscallLoginBox('jscallForgetPasswordBox', '1');" class="jscallForgetPasswordBox save_for"><?php echo FORGOT_PASSWORD; ?></a></div>
                    </div>


                    <div class="socialSignIn">
                        <span class="orSignIn"><h3>OR</h3> <?php echo SI_IN ?> with </span>
                        <span class="imagesSpan">   <img class="idpico" idp="google" src="<?php echo IMAGE_FRONT_PATH_URL; ?>socialicons/google.png" title="google" />
<!--                                                <img class="idpico" idp="twitter" src="<?php echo IMAGE_FRONT_PATH_URL; ?>socialicons/twitter.png" title="twitter" />-->
                            <img class="idpico" idp="facebook" src="<?php echo IMAGE_FRONT_PATH_URL; ?>socialicons/facebook.png" title="facebook" />
                            <img class="idpico" idp="linkedin" src="<?php echo IMAGE_FRONT_PATH_URL; ?>socialicons/linkedin.png" title="linkedin" />
                        </span>

                    </div>
                </div>
                <input type="button" style="display: block;
                       margin: 0px auto;
                       clear: both;
                       float: none;" name="frmHidenAdd" onclick="loginActionCustomerToWish('review')" value="Sign In"  class="submit3" id="signUptoSave" saveTo="addwishlist"/>
                                <!--                <p>
                <div id="idps" class="social_login_icon icons_saved">
                    <span><h3>OR</h3> <?php echo SI_IN ?> with </span>
                    <img class="idpico" idp="google" src="<?php echo IMAGE_FRONT_PATH_URL; ?>socialicons/google.png" title="google" />
                    <img class="idpico" idp="twitter" src="<?php echo IMAGE_FRONT_PATH_URL; ?>socialicons/twitter.png" title="twitter" />
                    <img class="idpico" idp="facebook" src="<?php echo IMAGE_FRONT_PATH_URL; ?>socialicons/facebook.png" title="facebook" />
                    <img class="idpico" idp="linkedin" src="<?php echo IMAGE_FRONT_PATH_URL; ?>socialicons/linkedin.png" title="linkedin" />
                </div>
                </p>--> 
            </div>
        </div>
    </div>
</div>