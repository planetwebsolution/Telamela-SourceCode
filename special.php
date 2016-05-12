<?php 
  require_once 'common/config/config.inc.php';
  require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;
  $objComman = new ClassCommon();
  require_once CONTROLLERS_PATH . FILENAME_SPECIAL_CTRL;
  //$menuHide = 0;
  ?>
<?php
//require_once 'common/config/config.inc.php';
//require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;
//$objComman = new ClassCommon();
//require_once CONTROLLERS_PATH . FILENAME_LANDING_CTRL;
//require_once CLASSES_PATH . 'class_home_bll.php';
//$arrSpecialProductPrice = $objPage->arrData['arrSpecialProductPrice'];
//$objPage->varBreadcrumbs;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Tela Mela</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>		
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>    
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>mialn.css"/>              
<!--        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>owl.carousel.css"/>-->
        <!--
        this js conficting with color box for login and signup
        <script type="text/javascript" src="<?php echo JS_PATH ?>jquery-1.9.0.min.js"></script>
        -->       
<!--        <script type="text/javascript" src="<?php echo JS_PATH ?>stylish-select.js"></script>-->
<!--        <script type="text/javascript" src="<?php echo JS_PATH ?>bxsliderjs.js"></script> -->
<!--        <script type="text/javascript" src="<?php echo JS_PATH ?>owl.carousel.js"></script>       -->
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>product.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.flip.min.js"></script>        
<!--        <script type="text/javascript" src="<?php echo JS_PATH ?>script.js"></script>-->
<!--        <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.bxslider.js"></script>-->
        <script src="<?php echo JS_PATH ?>jquery_cr.js" type="text/javascript"></script>
        <script src="<?php echo JS_PATH ?>jquery.jqzoom-core.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>skin.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>jquery.jqzoom.css"/>
        <script src="<?php echo JS_PATH ?>jQueryRotate.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>home.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>special.js"></script>
        <script>
        $('document').ready(function(){
           $('#banner-fade').bjqs({
           height      : 268,
           width       : 1134,
           responsive  : true
         });
        });
        </script>
        <style>
            .heading_border{ bottom: 0;
    color: #3c3c3c;
    float: left;
    font-size: 18px;
    font-weight: 600;
    line-height: 38px;
    padding-top: 5px;
    text-transform: uppercase; border-bottom: 4px solid #5c5c5c}
            
            
        </style>
    </head>
    <body>
       <em>
            <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>
        </em>
        <div class="header"> </div>
        <?php include_once INC_PATH . 'header.inc.php'; ?>
        
        <div id="ouderContainer">
            <div class="layout">

                <div class="successMessage"><div class="addToCartMess" style="display:none;"></div></div>
                <?php
                if ($objCore->displaySessMsg())
                {
                    ?>
                    <div class="successMessage">
                        <?php
                        echo $objCore->displaySessMsg();
                        $objCore->setSuccessMsg('');
                        $objCore->setErrorMsg('');
                        ?>
                    </div>
                <?php }
                ?>
                <div class="addToCart">
                    <div class="addToCartClose" onclick="addToCartClose();">&nbsp;&nbsp;&nbsp;&nbsp;</div>
                    <div class="addToCartMsg"></div>
                </div>

                
                
                <div id="banner-fade" style="width:1140px!important;max-width:1140px!important; "> 

    <!-- start Basic Jquery Slider -->
    <?php
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
                        <img src="<?php echo $objCore->getImageUrl($ban['BannerImageName'], 'banner/' . $arrSpecialPageBannerImage['big']); ?>" alt="<?php echo $ban['BannerTitle']; ?>" />
                        <?php
                    } else {
                        ?>
                        <img class="lazy" data-src="<?php echo $objCore->getImageUrl($ban['BannerImageName'], 'banner/' . $arrSpecialPageBannerImage['big']); ?>" src="" alt="<?php echo $ban['BannerTitle']; ?>" />
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
                
            </div>
        </div>
        <div class="spacial_page">
            <div class="layout" id="SpecialProduct">
                <?php
                //pre($objPage->arrData['arrWishListOfCustomer']);
                if (count($objPage->arrProduct) > 0)
                {
                    ?>

                    <?php
                    foreach ($objPage->arrProduct as $k => $v)
                    {
                        $k++;
                        ?>
                        
                          <div class="demo landing">
        <!--Horizontal Tab-->
        <div class="horizontalTab border_change">
            <ul class="resp-tabs-list">
                <span  class="heading_border">Top Special in <?php echo $v['CategoryName']; ?>
                    
                </span>
            </ul>
            <div class="customNavigation"> <a class="btn prev<?php echo $k;?>"><img src="<?php echo IMAGE_PATH_URL ?>arrow_slider-left.png" alt=""> </a> <a class="btn next<?php echo $k;?>"><img src="<?php echo IMAGE_PATH_URL ?>arrow_slider-right.png" alt=""></a> </div>
            <div class="resp-tabs-container">
                <div>
                    <div id="demo">
                        <div class="container">
                            <div class="row">
                                <div class="span12">
                                    <div  class="owl-demo" id="owl-demo_<?php echo $k;?>">
                                        <!--Section Start-->
                                        <?php
                                        foreach ($v['Products'] as $key => $val) { //pre($val);
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
                                                        <div class="price_new"><?php echo $objCore->getFinalPrice($val['FinalPrice'], $val['DiscountFinalPrice'], $val['FinalSpecialPrice'], 0, 1); ?></div>
                                                        <div class="unactive"><?php echo $objCore->getProductName($val['ProductDescription'], 40); ?> </div>
                                                    </div>
                                                    <div class="mask">
                                                        <h2 class="heading_new"><a href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')); ?>"><?php echo $val['ProductName']; ?></a></h2>
                                                        <p class="productPointer"><?php //echo $objCore->getProductName($val['ProductDescription'], 40);                             ?></p>

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
                                                                        <a href="#" class="info saveTowishlist saveTowishlist_<?php echo $totalPageCount;?>_<?php echo $val['pkProductID'];?>" btcheck="saveTowishlist_<?php echo $totalPageCount;?>_<?php echo $val['pkProductID'];?>" id="<?php echo $val['pkProductID']; ?>" Pid="<?php echo $val['pkProductID']; ?>">Save</a>
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
                      
                        <?php
                    }
                }
                else
                {
                    ?>
                    <div class="no_product_special">
                        <?php echo NO_PRODUCT; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php include_once INC_PATH . 'footer.inc.php'; ?>
        <div style="display: none;">
    <div id="loginBoxReview">
        <div class="login_box">
            <div class="login_inner">
                <div class="heading">
                    <h3><?php echo SI_IN; ?> (Customer)</h3>
                    <div class="signup">
                        <a href="<?php echo $objCore->getUrl('registration_customer.php', array('type' => 'add')) ?>"><?php echo NEW_U_SI; ?></a>
                    </div>
                </div>
                <div class="red" id="LoginErrorMsgRev"></div>
                <div class="out_btn">
                    <?php /*
                      <div class="radio_btn">
                      <input type="radio" name="frmUserTypeLn" value="customer" class="styled" checked="checked" />
                      <small><?php echo CUSTOMER; ?></small>
                      </div>
                     */ ?>
                </div>

                <div class="form" style="margin-top:0px;">
                    <label class="username">
                        <span><?php echo EM_ID; ?> :</span>
                        <input type="text" style="margin-bottom:20px;" class="saved" placeholder="Email Id" autocomplete="off" value="<?php echo isset($_COOKIE['email_id']) ? $_COOKIE['email_id'] : ''; ?>" name="frmUserEmailLn" id="frmUserEmailLnRev"/>
                        <div class="frmUserEmailLn"></div>
                    </label>
                    <div style="height:30px; clear:both"></div>  <label class="password">
                        <span><?php echo PASSWORD; ?> :</span>
                        <input type="password" class="saved" placeholder="Password" value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>" autocomplete="off" name="frmUserPasswordLn" id="frmUserPasswordLnRev"/>
                        <div class="frmUserPasswordLn"></div>
                    </label>
                    <div class="password">
                        <span>&nbsp;</span>
                        <div style="clear:both; display:block">
                            <div class="remember_div"> <div class="check_box" style=" margin-top:40px; clear:both;">
                                    <input type="checkbox" name="remember_me" value="yes" class="styled" <?php echo isset($_COOKIE['email_id']) ? "checked" : ''; ?>/>
                                    <small style="line-height:20px;"><?php echo REMEMBER_ME; ?></small>  </div></div>
                            <div class="password_div">
                                <a style=" margin-top:-17px; " href="#forgetPassword" onclick="return jscallLoginBox('jscallForgetPasswordBox', '1');" class="jscallForgetPasswordBox save_for"><?php echo FORGOT_PASSWORD; ?></a></div>

                        </div>
                    </div>
                    <input type="hidden" name="frmProductToWish" id="frmProductToWish" value=""/>
                    <input type="button" style="display: block;
                           margin: 0px auto;
                           clear: both;
                           float: none;" name="frmHidenAdd" onclick="loginActionCustomerToWish('review')" value="Sign In"  class="submit3" id="signUptoSave" saveTo="addwishlist"/>
<!--                    <p>
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
</div>
        
    </body>
</html> 