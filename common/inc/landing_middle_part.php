<style>.resp-tab-content{ padding-left:0px;}
    .not-active { pointer-events: none;cursor: default;background:#e9e9e9;}
</style>
<div id="banner-fade" style="width:1140px;max-width:1140px!important; "> 

    <!-- start Basic Jquery Slider -->
    <?php
    $catName = $objPage->catName;
    //echo $catName;
    //die;
    //echo count($objPage->arrBanner);
    if (count($objPage->arrBanner)) {
        ?>
        <ul class="bjqs">
            <?php
            $varCount = 1;
            foreach ($objPage->arrBanner as $ban) {
                ?>
                <li>
                    <?php
                    if ($varCount == 1) {
                        ?>
                        <a href="<?php echo ($ban['UrlLinks'] != '') ? $ban['UrlLinks'] : 'javascript:void(0)' ?>" <?php if ($ban['UrlLinks'] != '') { ?>target="_blank" <?php } ?>><img src="<?php echo $objCore->getImageUrl($ban['BannerImageName'], 'banner/' . $arrSpecialPageBannerImage['big']); ?>" alt="<?php echo $ban['BannerTitle']; ?>" /></a>
                        <?php
                    } else {
                        ?>
                        <a href="<?php echo ($ban['UrlLinks'] != '') ? $ban['UrlLinks'] : 'javascript:void(0)' ?>" <?php if ($ban['UrlLinks'] != '') { ?>target="_blank" <?php } ?>><img class="lazy" data-src="<?php echo $objCore->getImageUrl($ban['BannerImageName'], 'banner/' . $arrSpecialPageBannerImage['big']); ?>" src="" alt="<?php echo $ban['BannerTitle']; ?>" /></a>
                        <?php
                    }
                    ?>
                </li>

                <?php
                $varCount++;
            }
            ?>
        </ul>
        <?php
    } else {
        ?>
        <ul class="bjqs">
            <li><img src="<?php echo IMAGE_PATH_URL ?>banner01.jpg" /></li>
            <li><img class="lazy" data-src="<?php echo IMAGE_PATH_URL ?>banner02.jpg" src="" /></li>
            <li><img class="lazy" data-src="<?php echo IMAGE_PATH_URL ?>banner03.jpg" src="" /></li>

        </ul>
    <?php } ?>
    <!-- end Basic jQuery Slider --> 

</div>
<div class="breadcrumb"><a href="<?php echo SITE_ROOT_URL; ?>">Home</a> <i class="arrow"></i>  <span> <?php echo $catName; ?>  Products</span>       </div>
<!--START H1-->
<div class="top_header compareheader">
    <div class="newCompareBox" style="<?php echo count($objPage->varCompareProduct) > 0 ? 'display:block' : 'display:none'; ?>">
        <div class="leftUlCompare">
            <ul class="myCompareUl">
                <?php
                for ($i = 0; $i <= 3; $i++) {
                    if ($objPage->varCompareProduct[$i][0]['pkProductID']) {
                        $varSrc = $objCore->getImageUrl($objPage->varCompareProduct[$i][0]['ImageName'], 'products/' . $arrProductImageResizes['default']);
                        ?>
                        <li>
                            <div class="compare_products"> <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $objPage->varCompareProduct[$i][0]['pkProductID'], 'name' => $objPage->varCompareProduct[$i][0]['ProductName'], 'refNo' => $objPage->varCompareProduct[$i][0]['ProductRefNo'])); ?>"><img src="<?php echo $varSrc; ?>" alt="<?php echo $objPage->varCompareProduct[$i][0]['ProductName'] ?>" border="0" /></a>
                                <div class="name_comp"> <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $objPage->varCompareProduct[$i][0]['pkProductID'], 'name' => $objPage->varCompareProduct[$i][0]['ProductName'], 'refNo' => $objPage->varCompareProduct[$i][0]['ProductRefNo'])); ?>"> <?php echo ucfirst($objCore->getProductName($objPage->varCompareProduct[$i][0]['ProductName'], 22)); ?></a> </div>
                            </div>
                            <div class="cross_icon"><a href="javascript:void(0)" onclick="RemoveProductFromCompare(<?php echo $objPage->varCompareProduct[$i][0]['pkProductID']; ?>);" title="Remove">X</a></div>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li><div class="blankCompare">Add another product</div></li>
                        <?php
                    }
                }
                ?>
            </ul>


        </div>
        <div class="compareButton">
            <a target="_blank" href="<?php echo $objCore->getUrl('product_comparison.php'); ?>" class="submit4 <?php echo (count($objPage->varCompareProduct) < 2) ? 'not-active' : '' ?>">Compare<?php if (count($objPage->varCompareProduct) > 0) echo ' (' . count($objPage->varCompareProduct) . ')'; ?></a>

        </div>
    </div>
    <h1><?php echo $catName; ?> Product</h1>

</div>

<!--END H1--> 

<!--MIDDLE SECTION CATEGORY SECTION-->
<?php
if (count($objPage->arrLeftCat) > 0) {
    //pre($objPage->arrLeftCat);
    ?>

    <div class="cat_section">
        <div class="<?php echo count($objPage->arrLeftCat) > 6 ? 'scroll-pane' : '' ?>">
            <?php
            //pre($objPage->arrLeftCat);
            foreach ($objPage->arrLeftCat as $ctk => $cat) {
                $varImageLink = Home::getCategoryImage($cat['pkCategoryId']);
                ?>

                <a href="<?php echo $objCore->getUrl('category.php', array('cid' => $cat['pkCategoryId'], 'name' => $cat['CategoryName'])); ?>" class="img-caption">
                    <figure><span class="boxgrid">
                            <?php
                            if ($varImageLink != '') {
                                ?>
                                <img src="<?php echo $varImageLink['categoryImageUrl'] . $varImageLink['categoryImage']; ?>"  alt="" border="0" style="width:345px;height:308px;" />
                                <?php
                            } else {
                                ?>
                                <img src="<?php echo LANDING_IMAGE_PATH_URL; ?>jwell.jpg"  alt="" border="0" style="width:345px;height:308px;"/>
                            <?php } ?>
                        </span>

                        <figcaption>
                            <h3><?php echo $cat['CategoryName']; ?></h3>
        <!--                            <span>25% Off Summer Styles</span> </figcaption>-->
                    </figure>
                </a>
            <?php } ?>
        </div>
    </div>
<?php } ?>

<!--END MIDDLE SECTION-->
<?php
if (count($objPage->arrData['arrCategoryLatestPoducts']) > 0) {
    ?>
    <div class="landing_title">
        <span  class="heading_main recom best">NEW ARRIVAL
            <div class="border_bar1" style="width:73%"></div></span>
    </div>
    <div class="landing_section">
        <div class="section_divide">
            <!-- Left Block big image section -->
            <div class="left_block">
                <a href="javascript:void(0)"><img src="<?php echo IMAGE_PATH_URL; ?>landing_big_img.jpg" alt="" class="bidImage" /><img src="<?php echo IMAGE_PATH_URL; ?>loading_all.gif" alt="" class="bidImageLoader" style="display:none"/></a>
            </div>
            <!-- Left Block big image section -->
            <!-- Right Block small image section -->

            <div class="right_block">
                <?php
                foreach ($objPage->arrData['arrCategoryLatestPoducts'] as $catPro) {
                    $i = 0;
                    foreach ($catPro['arrProducts'] as $key => $val) { //pre($val);
                        $varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/' . $arrProductImageResizes['landing3'] . '/' . $val['ProductImage'];
                        //if (file_exists($varImgPath) && $val['ProductImage'] != '') {
                        $i++;
                        ?>

                        <div class="small_box">
                            <img src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/' . $arrProductImageResizes['landing3']); ?>"   alt="" id="newArrivalImage_<?php echo $i; ?>"  class="small_image" style="cursor:pointer" stRoot="<?php echo SITE_ROOT_URL; ?>"/>
                            <a href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')); ?>" class=" small_link"><?php echo $objCore->getProductName($val['ProductName'], 15); ?></a>
                            <div><?php echo $objCore->getFinalPrice($val['FinalPrice'], $val['DiscountFinalPrice'], $val['FinalSpecialPrice'], 0, 1); ?></div>
                        </div>
                        <?php
                        //}
                        if ($i == 8) {
                            break;
                        }
                    }
                }
                ?>



            </div>
            <!-- Right Block small image section -->
        </div>

    </div>
<?php } ?>
<!-- Block Start-->

<?php
$totalPageCount = 0;
if (count($objPage->arrData['topSellingProducts']) > 0) {
    ?>
    <div class="demo landing">
        <!--            Horizontal Tab-->
        <div class="horizontalTab border_change">
            <ul class="resp-tabs-list">
                <span  class="heading_main recom best"> Best Seller
                    <div class="border_bar1" style=" width:67%"></div></span>
            </ul>
            <div class="customNavigation"> <a class="btn prev7"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-left.png" alt=""> </a> <a class="btn next7"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-right.png" alt=""></a> </div>
            <div class="resp-tabs-container">

                <div>
                    <div id="demo">
                        <div class="container">
                            <div class="row">
                                <div class="span12">
                                    <div  class="owl-demo7">
                                        <!--                                    Section Start-->
                                        <?php
                                        foreach ($objPage->arrData['topSellingProducts'] as $key => $val) { //pre($val);
                                            if ($val['Quantity'] == 0) {
                                                $varAddCartUrl = 'class="cart2 outOfStock info"';
                                                $addToCart = OUT_OF_STOCK;
                                                $addToCartImg1 = 'outofstock_icon.png';
                                            } else {
                                                $addToCart = ADD_TO_CART;
                                                $addToCartImg1 = 'cart_icon.png';
                                                if ($val['Attribute'] == 0) {
                                                    $varAddCartUrl = 'href="' . $objCore->getUrl('common/ajax/ajax_cart.php', array('action' => 'addToCart', 'pid' => $val['pkProductID'], 'qty' => '1')) . '" class="info cart2 addCart ' . $val['pkProductID'] . '" onclick="addToCart(' . $val['pkProductID'] . ')" ';
                                                } else {
                                                    $varAddCartUrl = 'href="' . $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')) . '#addCart" class="info cart2 addCart" ';
                                                }
                                            }

                                            $varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/' . $arrProductImageResizes['global'] . '/' . $val['ProductImage'];
                                            //if (file_exists($varImgPath) && $val['ProductImage'] != '') {
                                            ?>

                                            <div class="item">
                                                <div class="view view-first">
                                                    <div class="image_new">
                                                        <?php
                                                        $varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/' . $arrProductImageResizes['global'] . '/' . $val['ProductImage'];
                                                        ?>
                                                        <img class="lazy" data-src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>"  src="" alt="<?php echo $val['ProductName'] ?>"/>
                                                        <div class="new_heading"><?php
                                                            echo $objCore->getProductName($val['ProductName'], 39);
                                                            ?></div>
                                                        <?php
                                                        if ($val['discountPercent'] > 0) {
                                                            ?>
                                                            <div class="discount_new"><?php echo $val['discountPercent']; ?>%<span>OFF</span></div>
                                                        <?php } ?>
                                                        <div class="price_new">
                                                            <?php
                                                            if ($val['offerPrice'] == '') {
                                                                echo $objCore->getFinalPrice($val['FinalPrice'], $val['DiscountFinalPrice'], $val['FinalSpecialPrice'], 0, 1);
                                                            } else {
                                                                echo $objCore->getFinalPrice($val['FinalPrice'], $val['offerPrice'], $val['FinalSpecialPrice'], 0, 1);
                                                            }
                                                            ?>
                                                        </div>
                                                        <!--<div class="unactive"><?php //echo $objCore->getProductName($val['ProductDescription'], 20);                        ?> </div>-->
                                                    </div>
                                                    <div class="mask">
                                                        <h2><a href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')); ?>"><?php echo $val['ProductName']; ?></a></h2>
                                                        <p class="productPointer"><?php //echo $objCore->getProductName($val['ProductDescription'], 20);                                    ?></p>
                                                        <div class="mask_box">
                                                            <a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $val['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $val['pkProductID']; ?>');" class="info quick QuickView<?php echo $val['pkProductID']; ?>" title="<?php echo QUICK_OVERVIEW; ?>"><?php echo QUICK_OVERVIEW; ?></a>
                                                            <?php
                                                            if ($addToCart == OUT_OF_STOCK) {
                                                                ?>
                                                                <a <?php echo $varAddCartUrl; ?> title="<?php echo $addToCart; ?>"><?php echo $addToCart; ?></a>
                                                                <?php
                                                            } else {
                                                                if ($_SESSION['sessUserInfo']['type'] == 'customer') {

                                                                    if (in_array($val['pkProductID'], $objPage->arrData['arrWishListOfCustomer'], true)) {
                                                                        ?>
                                                                        <a href='#' class='info afterSavedInWishList' style='background:red;color:white'>Saved</a>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <a href="#" class="info saveTowishlist saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" btcheck="saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" id="<?php echo $val['pkProductID']; ?>" Pid="<?php echo $val['pkProductID']; ?>">Save</a>
                                                                        <?php
                                                                    }
                                                                } else {
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
<!-- End Block Start--> 
<!-- Block Start-->
<?php
if (count($objPage->arrData['topRatedProducts']) > 0) {
    ?>
    <div class="demo landing">
        <!--Horizontal Tab-->
        <div class="horizontalTab border_change">
            <ul class="resp-tabs-list">
                <span  class="heading_main recom best">Top Rated
                    <div class="border_bar1"></div>
                </span>
            </ul>
            <div class="customNavigation"> <a class="btn prev8"><img src="<?php echo IMAGE_PATH_URL ?>arrow_slider-left.png" alt=""> </a> <a class="btn next8"><img src="<?php echo IMAGE_PATH_URL ?>arrow_slider-right.png" alt=""></a> </div>
            <div class="resp-tabs-container">
                <div>
                    <div id="demo">
                        <div class="container">
                            <div class="row">
                                <div class="span12">
                                    <div  class="owl-demo8">
                                        <!--Section Start-->
                                        <?php
                                        //pre($objPage->arrData['topRatedProducts']);
                                        foreach ($objPage->arrData['topRatedProducts'][0] as $key => $val) { //pre($val);
                                            if ($val['Quantity'] == 0) {
                                                $varAddCartUrl = 'class="cart2 outOfStock info btn_new"';
                                                $addToCart = OUT_OF_STOCK;
                                                $addToCartImg1 = 'outofstock_icon.png';
                                            } else {
                                                $addToCart = ADD_TO_CART;
                                                $addToCartImg1 = 'cart_icon.png';
                                                if ($val['Attribute'] == 0) {
                                                    $varAddCartUrl = 'href="' . $objCore->getUrl('common/ajax/ajax_cart.php', array('action' => 'addToCart', 'pid' => $val['pkProductID'], 'qty' => '1')) . '" class="info btn_new cart2 addCart ' . $val['pkProductID'] . '" onclick="addToCart(' . $val['pkProductID'] . ')" ';
                                                } else {
                                                    $varAddCartUrl = 'href="' . $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')) . '#addCart" class="info btn_new cart2 addCart" ';
                                                }
                                            }
                                            $varImgPathRight = UPLOADED_FILES_SOURCE_PATH . 'images/products/' . $arrProductImageResizes['global'] . '/' . $val['ProductImage'];
                                            //if (file_exists($varImgPathRight) && $val['ProductImage'] != '') {
                                            ?>
                                            <div class="item">
                                                <div class="view view-first">
                                                    <div class="image_new">
                                                        <?php
                                                        $varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/' . $arrProductImageResizes['global'] . '/' . $val['ProductImage'];
                                                        //if (file_exists($varImgPath) && $val['ProductImage'] != '') {
                                                        ?>
                                                        <img class="lazy" data-src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>"  src="" alt="<?php echo $val['ProductName'] ?>"/>


                                                        <div class="new_heading"><?php echo $objCore->getProductName($val['ProductName'], 39); ?></div>
                                                        <?php
                                                        if ($val['discountPercent'] > 0) {
                                                            ?>
                                                            <div class="discount_new"><?php echo $val['discountPercent']; ?>%<span>OFF</span></div>
                                                        <?php } ?>
                                                        <div class="price_new">
                                                            <?php
                                                            if ($val['offerPrice'] == '') {
                                                                echo $objCore->getFinalPrice($val['FinalPrice'], $val['DiscountFinalPrice'], $val['FinalSpecialPrice'], 0, 1);
                                                            } else {
                                                                echo $objCore->getFinalPrice($val['FinalPrice'], $val['offerPrice'], $val['FinalSpecialPrice'], 0, 1);
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="unactive"><?php echo $objCore->getProductName($val['ProductDescription'], 40); ?> </div>
                                                    </div>
                                                    <div class="mask">
                                                        <h2 class="heading_new"><a href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')); ?>"><?php echo $val['ProductName']; ?></a></h2>
                                                        <p class="productPointer"><?php //echo $objCore->getProductName($val['ProductDescription'], 40);                               ?></p>

                                                        <div class="mask_box">
                                                            <a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $val['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $val['pkProductID']; ?>');" class="info btn_new qckView quick QuickView<?php echo $val['pkProductID']; ?>" title="<?php echo QUICK_OVERVIEW; ?>"><?php echo QUICK_OVERVIEW; ?></a>
                                                            <?php
                                                            if ($addToCart == OUT_OF_STOCK) {
                                                                ?>
                                                                <a <?php echo $varAddCartUrl; ?> title="<?php echo $addToCart; ?>"><?php echo $addToCart; ?></a>
                                                                <?php
                                                            } else {
                                                                if ($_SESSION['sessUserInfo']['type'] == 'customer') {
                                                                    if (in_array($val['pkProductID'], $objPage->arrData['arrWishListOfCustomer'], true)) {
                                                                        ?>
                                                                        <a href='#' class='info afterSavedInWishList' style='background:red;color:white'>Saved</a>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <a href="#" class="info saveTowishlist saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" btcheck="saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" id="<?php echo $val['pkProductID']; ?>" Pid="<?php echo $val['pkProductID']; ?>">Save</a>
                                                                        <?php
                                                                    }
                                                                } else {
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
<!-- End Block Start-->



<?php
//Advertisement Start Here//
$arrAds = $objPage->arrData['ads'];



$addStr = '<div class="landing_banner">';
for ($a = 0; $a < 8; $a++) {
    if ($arrAds[0][$arrAds[1][$objPage->arrData['pkCategoryId']][$a]] == '') {
        break;
    }
    $addStr.= '<div class="banne_img">';
    $addStr.= $arrAds[0][$arrAds[1][$objPage->arrData['pkCategoryId']][$a]];
    $addStr.= '</div>';
}
$addStr.= '</div>';

echo $addStr;
?>          


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
                        <div class="remember_div">
                            <div class="check_box">
                                <input type="checkbox" name="remember_me" value="yes" class="styled" <?php echo isset($_COOKIE['email_id']) ? "checked" : ''; ?>/>
                                <small><?php echo REMEMBER_ME; ?></small> </div>
                        </div>
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