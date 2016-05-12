<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_PACKAGE_CTRL;
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;
$objProduct = new Product();
$objComman = new ClassCommon();
//print_r($_SESSION['MyCart']);
//print_r($_REQUEST);
//pre($objPage->arrProductPackageDetails);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Package <?php echo $objPage->arrproductDetails[0]['MetaTitle']; ?></title>
        <meta name="description" content="<?php echo $objPage->arrproductDetails[0]['MetaKeywords']; ?>"/>
        <meta name="keywords" content="<?php echo $objPage->arrproductDetails[0]['MetaDescription']; ?>"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>combo.css"/>
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH ?>owl.carousel3.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>owl.carousel_details.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>product.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH ?>script.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.bxslider.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>product.js"></script>          
        <script type="text/javascript" src="<?php echo JS_PATH ?>home.js"></script>      
        <script src="<?php echo JS_PATH ?>jquery_cr.js" type="text/javascript"></script>
        <script src="<?php echo JS_PATH ?>jquery.jqzoom-core.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>jquery.jqzoom.css"/>
        <style>
            .price_details span{width:auto; line-height:44px; padding-left:0px;}
            .price_details span{color:black;}
            .zoomWindow{ left:279px !important}
        </style>
        <script>
            $(document).ready(function() {
                $(".drop_down1").sSelect();
            });
        </script>
        <script>
            function addToWishlist(prodid) {

                $.post(SITE_ROOT_URL + 'common/ajax/ajax_compare.php', {
                    action: 'addToWishlist',
                    pid: prodid
                }, function(data) {
                    $('#wishList_' + prodid).html('&nbsp; ' + ADD_WISHLIST_SUCC);
                    setTimeout(function() {
                        $('#wishList_' + prodid).html('&nbsp')
                    }, 4000);
                });
            }

            function addToWishlistLogin(prodid) {
                $('#wishList_' + prodid).html('<span class="red">&nbsp; Please login to add wishlist.</span>');
                setTimeout(function() {
                    $('#wishList_' + prodid).html('&nbsp')
                }, 4000);
            }
        </script>
        <script type="text/javascript">
            FB.init({appId: "647192451965551", status: true, cookie: true});
            function postToFeed() {
                // calling the API ...
                var obj = {
                    method: 'feed',
                    redirect_uri: SITE_ROOT_URL,
                    link: '<?php echo $objCore->getUrl('package.php', array('pkgid' => $objPage->arrProductPackageDetails[0]['pkPackageID'], 'name' => $objPage->arrProductPackageDetails[0]['PackageName'])) ?>',
                    picture: '<?php echo $objCore->getImageUrl($objPage->arrProductPackageDetails[0]['PackageImage'], 'package/65x65/'); ?>',
                    name: '<?php echo ucfirst(addslashes($objPage->arrProductPackageDetails[0]['PackageName'])); ?>',
                    //caption: 'Reference Documentation',
                    //description: '<?php //echo ucfirst(addslashes($objPage->arrproductDetails[0]['ProductDescription']));                                                                             ?>'
                    description: $('#tab1 p').text()
                };

                function callback(response) {
                    // alert(response);
                    if (response == null) {
                        document.getElementById('msg').innerHTML = "";
                    } else {
                        //document.getElementById('msg').innerHTML = "<span style='color:green'><?php echo PRODUCT_SHARE_SUCC; ?></span>";
                        //setTimeout(function(){$('#msg').html('&nbsp')},4000);

                        $.post(SITE_ROOT_URL + "common/ajax/ajax_compare.php", {
                            action: "addSocialRewards",
                            SocialMedia: 'Facebook'
                        }, function(data) {
                            //alert(data);
                        });
                    }
                }
                FB.ui(obj, callback);
            }
        </script>
        <script type="text/javascript">
            var callback = function(e) {
                if (e && e.data) {
                    var data;
                    try {
                        data = JSON.parse(e.data);
                    } catch (e) {

                    }
                    if (data && data.params && data.params.indexOf('tweet') > -1) {
                        $.post(SITE_ROOT_URL + "common/ajax/ajax_compare.php", {
                            action: "addSocialRewards",
                            SocialMedia: 'Twitter'
                        }, function(data) {
                            //alert(data);
                        });
                        // alert('Thanks for the tweet!');


                    }
                }
            }
            window.addEventListener ? window.addEventListener("message", callback, !1) : window.attachEvent("onmessage", callback)
        </script>
        <script type="text/javascript">
                    (function() {
                        var po = document.createElement('script');
                        po.type = 'text/javascript';
                        po.async = true;
                        po.src = 'https://apis.google.com/js/client:plusone.js';
                        var s = document.getElementsByTagName('script')[0];
                        s.parentNode.insertBefore(po, s);
                    })();

            function plusOneClick(response) {
                //alert(response.state);//console.log( response );

                if (response.state == 'on') {
                    $.post(SITE_ROOT_URL + "common/ajax/ajax_compare.php", {
                        action: "addSocialRewards",
                        SocialMedia: 'Google'
                    }, function(data) {
                        //alert(data);
                    });
                }
            }

        </script>
    </head>
    <body>
        <div class="outer_wrapper">
            <em> <div id="navBar">
                    <?php include_once INC_PATH . 'top-header.inc.php'; ?>
                </div>
                <div class="header" > <div class="layout">
                    </div>
                </div><?php include_once INC_PATH . 'header.inc.php'; ?>
            </em>
            <div id="ouderContainer" class="ouderContainer_1">
                <div class="layout">
                    <div class="header">
                        <div class="successMessage"><div class="success" style="display:none;">Package Added to your shopping cart.</div></div>
                        <?php
                        if ($objCore->displaySessMsg()) {
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
                    </div>
                    <?php //pre($_SESSION);  ?>
                    <div class="add_pakage_outer">
                        <ul class="parent_top">
                            <?php
                            if ($objPage->varBreadcrumbs) {
                                echo $objPage->varBreadcrumbs;
                                ?>
                                <li><?php echo html_entity_decode($objPage->arrproductDetails[0]['ProductName']); ?></li>
                            <?php } ?>
                        </ul>
                        <div class="body_container product_sec">
                            <div class="products_left_outer">
                                <h1><?php echo $objPage->arrProductPackageDetails[0]['PackageName']; ?></h1>
                                <div class="left_product_gradient">
                                    <div class="left_products_sec">
                                        <!--Package Product Start Here-->

                                        <?php
                                        if ($objPage->arrProductPackageDetails[0]['pkPackageID'] > 0) {
                                            ?>
                                            <?php
                                            $id = 0;
                                            $totalPackagePrice = 0;
                                            $varCartQty = 0;
                                            foreach ($objPage->arrProductPackageDetails AS $arrProduct) {

                                                $attributesVariable = "";
                                                $productDetails = $objPage->getProductsDetails($arrProduct['pkProductID']);
                                                $arrproductAttrbuteOptionId = explode(",", $arrProduct['attrbuteOptionId']);
                                                $arrproductFkAttributeId = explode(",", $arrProduct['fkAttributeId']);
                                                $arrproductAttributeLabel = explode(",", $arrProduct['AttributeLabel']);
                                                $arrproductOptionTitle = explode(",", $arrProduct['OptionTitle']);
                                                $arrproductoptionColorCode = explode(",", $arrProduct['optionColorCode']);
                                                $arrproductOptionImage = explode(",", $arrProduct['OptionImage']);
                                                $arrproductOptionExtraPrice = explode(",", $arrProduct['OptionExtraPrice']);
                                                //  echo "<pre>";
                                                //  print_r($arrproductOptionImage);
                                                //  echo "</pre>";
                                                $pid = $arrProduct['pkProductID'];

                                                $varProductPrice1 = $objCore->getFinalPrice($productDetails['arrproductDetails'][0]['FinalPrice'], $productDetails['arrproductDetails'][0]['DiscountFinalPrice'], $productDetails['arrproductDetails'][0]['FinalSpecialPrice'], 1, 1);
                                                $varProductPrice = $objCore->getPrice($varProductPrice1);
                                                ?>
                                                <div class="products_quickview" style="margin-top:20px;">
                                                    <div id="colorBox_table">
                                                        <div class="colormy_lefttd">
                                                            <div class="clearfix product_img" id="content" >
                                                                <div class="clearfix clearfix2  imgs">
                                                                    <?php
                                                                    if (count($arrproductOptionImage) > 1) {
                                                                        foreach ($arrproductOptionImage as $attrImage) {
                                                                            if ($attrImage != '') {
                                                                                $varSrc = $objCore->getImageUrl($attrImage, 'products/' . $arrProductImageResizes['global']);
                                                                                $varSrcHover = $objCore->getImageUrl($attrImage, 'products/' . $arrProductImageResizes['detailHover']);
                                                                            } else {
                                                                                $varSrc = $objCore->getImageUrl($valProductPackage['ImageName'], 'products/' . $arrProductImageResizes['global']);
                                                                                $varSrcHover = $objCore->getImageUrl($valProductPackage['ImageName'], 'products/' . $arrProductImageResizes['detailHover']);
                                                                            }
                                                                        }
                                                                    } else {
                                                                        $varSrc = $objCore->getImageUrl($valProductPackage['ImageName'], 'products/' . $arrProductImageResizes['global']);
                                                                        $varSrcHover = $objCore->getImageUrl($valProductPackage['ImageName'], 'products/' . $arrProductImageResizes['detailHover']);
                                                                    }
                                                                    ?>
                                                                    <a href="<?php echo $varSrcHover; ?>" class="jqzoom" rel='<?php echo "gal" . $arrProduct['pkProductID']; ?>'>
                                                                        <img src="<?php echo $varSrc; ?>"  title="triumph"/>
                                                                    </a>
                                                                    <?php
                                                                    $days = $objComman->dateDiffInDays($productDetails['arrproductDetails'][0]['ProductDateAdded'], date('Y-m-d H:i:s'));
                                                                    if ($days <= NEW_PRODUCT_BASED_ON_DAYS) {
                                                                        ?>
                                                                                <!--<div class="new"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>new_product.png" alt=""/></div>-->
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="colormy_righttd">
                                                            <div class="products_detail" id="products_detail_<?php echo $pid; ?>">
                                                                <div class="top_casual">
                                                                    <div class="quick_title">
                                                                        <h1><a href="<?php echo $objCore->getUrl('product.php', array('id' => $pid, 'name' => $productDetails['arrproductDetails'][0]['ProductName'], 'refNo' => $productDetails['arrproductDetails'][0]['ProductRefNo'])); ?>" class="product_name"><?php echo html_entity_decode($productDetails['arrproductDetails'][0]['ProductName']); ?></a></h1>
                                                                    </div>
                                                                    <?php if($productDetails['arrproductDetails'][0]['ProductDescription']!=''){?>
                                                                    <p class="detail_txt border_btm"><?php echo $productDetails['arrproductDetails'][0]['ProductDescription']; ?></p>
                                                                    <?php } 
                                                                    
                                                                    if(count($arrproductAttributeLabel)>1){
                                                                    ?>
                                                                    <div class="outer_blog" style="padding-top:0px;">
                                                                        <span class="price_details">

                                                                            <?php
                                                                            foreach ($arrproductAttributeLabel as $key => $attDetails) {
                                                                                if ($arrproductOptionTitle[$key] != '') {
                                                                                    ?>
                                                                                    <span style="float:left;clear:left"><?php echo $attDetails; ?> : </span>
                                                                                    <span style="float:left; font-weight:bold;clear: right"><?php echo $arrproductOptionTitle[$key]; ?></span>
                                                                                    <?php
                                                                                }
                                                                                $attributes = array($arrproductFkAttributeId[$key] => $arrproductAttrbuteOptionId[$key]);

                                                                                $attr = $valProductPackage['pkProductID'] . '$' . implode('#', $attributes) . "|";
                                                                                $extraP +=$arrproductOptionExtraPrice[$key];
                                                                            }
                                                                            
                                                                            ?>     

                                                                        </span>


                                                                    </div>
                                                                    <?php }
                                                                    $totalPackagePrice +=$productDetails['arrproductDetails'][0]['FinalPrice'] + $extraP;
                                                                    ?>
                                                                    <span style="clear:left">Price:</span>
                                                                    <strong style="clear:right" class="txt_price"><?php echo $objCore->getPrice($productDetails['arrproductDetails'][0]['FinalPrice'] + $extraP); ?></strong>       

                                                                </div>

                                                                <!--Recommend section starts from here-->
                                                                <div style='display:none'>
                                                                    <div id="recommend_details_<?php echo $pid; ?>" class="reply_message">
                                                                        <form name="frmRecommendform" id="frmRecommendform" method="POST" action="">
                                                                            <div class="left_m"><label><?php echo Y_NAME; ?> *</label> :</div><div class="right_m">
                                                                                <input type="text" name="frmName" value="<?php echo ucfirst($objPage->arrCustomerDetails[0]['CustomerFirstName']) . " " . $objPage->arrCustomerDetails[0]['CustomerLastName']; ?>" class="validate[required]" />
                                                                            </div>
                                                                            <div class="left_m"><label><?php echo Y_EMAIL; ?> *</label> :</div><div class="right_m">
                                                                                <input type="text" name="frmEmail" value="<?php echo $objPage->arrCustomerDetails[0]['CustomerEmail']; ?>" class="validate[required,custom[email]]" />
                                                                            </div>

                                                                            <div class="left_m"><label><?php echo FR_EMAIL; ?> *</label>:</div><div class="right_m">
                                                                                <textarea id="frmFriendEmail" name="frmFriendEmail" class="validate[required,custom[multiemail]]"></textarea>
                                                                            </div>

                                                                            <div class="left_m">&nbsp;</div><div class="right_m">
                                                                                <input type="submit" name="frmHidenSend" class="cart_link"  value="Send" />
                                                                                <input type="button" name="cancel" value="Cancel" class="watch_link" id="recommend_cancel" />
                                                                            </div>
                                                                            <input type="hidden" name="proName" id="proName"  value="<?php echo $productDetails['arrproductDetails'][0]['ProductName']; ?>" />
                                                                            <input type="hidden" name="proId" id="proId" value="<?php echo $pid; ?>" />
                                                                            <input type="hidden" name="RefUrl" value="<?php echo 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$_SERVER['REQUEST_URI']}"; ?>">
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <!--Recommend section ends here-->
                                                                <!--Write a review section starts from here-->

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($id + 1 < count($objPage->arrProductPackageDetails)) {
                                                        ?>   
                                                        <div style="  clear: both;
                                                             color: #fff;
                                                             font-size: 30px;
                                                             font-weight: 600;
                                                             margin: 0 auto 60px;
                                                             text-align: center;
                                                             width: 45px; background:#565655">
                                                            +
                                                        </div>

                                                        <?php
                                                    }
                                                    $totalPackagePrice += $prodPrice + $totalProductPrice;
                                                    $id++;
                                                }
                                                ?>

                                            </div>
                                            <div class="social_icon1">
                                                <div class="social_share">
                                                    <a onclick='postToFeed();
                    return false;' class="fb_icon"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>fb-icon.png" alt="Facebook Share"/></a>
                                                    <a href="javascript:void(0);" class="tiwtter" onclick="(function() {
                        var url = 'https://twitter.com/intent/tweet?tw_p=tweetbutton&amp;url=' + encodeURI('<?php echo $objCore->getUrl('package.php', array('pkgid' => $objPage->arrProductPackageDetails[0]['pkPackageID'], 'name' => $objPage->arrProductPackageDetails[0]['PackageName'])) ?>') + '&amp;text=<?php echo SITE_NAME ?>';
                        url = encodeURI(url);
                        window.open(url, 'Tweet', 'height=500,width=700');
                    })()" >
                                                        <img src="<?php echo IMAGE_FRONT_PATH_URL; ?>tiwtter.png" alt="Twitter" />
                                                    </a>
                                                    <div class="g-plusone" data-size="tall" data-annotation="none" data-href="<?php echo $objCore->getUrl('package.php', array('pkgid' => $objPage->arrProductPackageDetails[0]['pkPackageID'], 'name' => $objPage->arrProductPackageDetails[0]['PackageName'])) ?>" data-callback="plusOneClick" ></div>
                                                </div>
                                            </div>
                                            <!--                                    <div class="left_bottom">
                                                                                                                            <p class="" id="add_cart_link" style="padding-top:10px; background:none;">
                                            <?php
                                            if ($_SESSION['sessUserInfo']['type'] == 'customer') {
                                                ?>
                                                                                                                                            <a class="watch_link1" href="javascript:void('0');" onclick="addToWishlist(<?php echo $arrProduct['pkProductID']; ?>)"><?php echo ADD_WISH; ?></a>
                                                <?php
                                            } else {
                                                ?>
                                                                                                                                            <a class="watch_link1" href="javascript:void('0');" onclick="addToWishlistLogin(<?php echo $arrProduct['pkProductID']; ?>)"><?php echo ADD_WISH; ?></a>
                                            <?php } ?>
                                            
                                                                                                                                <a cmCid="<?php echo $arrProduct['pkProductID']; ?>" cmPid="<?php echo $arrProduct['pkProductID']; ?>" id="CompareCheckBox<?php echo $arrProduct['pkProductID']; ?>" class="compare_quick" onclick="addToCompare(<?php echo $arrProduct['pkProductID']; ?>,<?php echo $arrProduct['fkCategoryID']; ?>,'<?php echo $objCore->getUrl('product_comparison.php'); ?>');" href="javascript:void('0');">Compare</a>
                                                                                                                            </p>
                                                                                                                            <div class="succCart" id="wishList_<?php echo $pid; ?>">&nbsp;</div>
                                                                                                                            <div id="addtoCompareMessage<?php echo $arrProduct['pkProductID']; ?>" class="addtoCompareMessage"> </div>
                                            
                                                                                                                        </div>-->
                                            <!--                                        <div class="quick_left">  <?php
                                            $feedbacks = $objComman->getProductFeedbacks($pid);
                                            // pre($productDetails);
                                            ?>
                                                                                                                    <strong><?php echo $feedbacks[0]['positive'] + $feedbacks[0]['negative']; ?></strong>
                                                                                                                    <span class="red" style="color:#8c8c8c"><?php echo round(($feedbacks[0]['positive'] / ($feedbacks[0]['positive'] + $feedbacks[0]['negative'])) * 100, 2) ?> % Rating</span>
                                            <?php $productRate = ($productDetails['arrproductDetails'][0]['numRating']) / ($productDetails['arrproductDetails'][0]['numCustomer']); ?>
                                                                                                                    <div class="red" style="padding-left:30px;"><?php echo $objComman->getRatting($productRate); ?></div>
                                                                                                                    <span class="cust_review"><?php echo CUS_REVIEW; ?></span> (<strong class="ornage_text"><?php echo count($productDetails['arrproductReview'][0]['customerReviews']) ?></strong>)
                                                                                                                </div>
                                                                                                                <div class="quick_right">
                                                                                                                    <p>
                                                                                                                        <a class="review_txt" href="#"><?php echo WRITE_REVIEW; ?></a>
                                                                                                                        <a class="review_txt" href="#reviewSec_<?php echo $pid; ?>"  onclick="return product_review_page()"><?php echo WRITE_REVIEW; ?></a>
                                                                                                                        <a href="#recommend_details_<?php echo $pid; ?>" class="active recommend" onclick="return jscall_recommend(<?php echo $pid; ?>)" ><?php echo RECOMMEN; ?></a>
                                                                                                                    </p>
                                                                                                                </div>-->
                                            <div class="package_add_tocart_sec" style="padding:30px; background:#f8f8f8; text-align:center ">
                                                <div class="left">
                                                    <div class="price_box"><span>Package Price:</span>
                                                        <strong><?php echo $objCore->getPrice($objPage->arrProductPackageDetails[0]['PackagePrice']); ?></strong>
                                                    </div>
                                                    <div class="save_box">  <span>Save:</span>
                                                        <strong> <?php echo $objCore->getPrice($totalPackagePrice - $objPage->arrProductPackageDetails[0]['PackagePrice']); ?></strong>
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <?php
                                                    if ($varCartQty) {
                                                        ?>
                                                        <a onclick="return false;" id="cart_link1" class="cart_link1 campare_link" href="javascript:void(0)">Out Of Stock</a>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <a href="javascript:void(0)" class="cart_link1" id="cart_link1" onclick="addToCartPackage('<?php echo $objPage->arrProductPackageDetails[0]['pkPackageID']; ?>', this.className)"><?php echo ADD_TO_CART; ?></a>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                        } else {
                                            ?> <div class="noProductAvail"><strong> Package does not exist !</strong></div>
                                            <?php
                                        }
                                        ?>
                                        <!-- Login Box Start-->
                                        <!--                        <div class="top_customer" id="top_customer">
                                                                    <div class="review_sec1">-->
                                        <div style="display: none;">

                                            <div id = "loginBoxReview">
                                                <div class = "login_box">
                                                    <div class = "login_inner">
                                                        <div class = "heading">
                                                            <h3><?php echo SI_IN; ?> (Customer)</h3>
                                                            <div class="signup">
                                                                <a href="<?php echo $objCore->getUrl('registration_customer.php', array('type' => 'add')) ?>"><?php echo NEW_U_SI; ?></a>
                                                            </div>
                                                        </div>
                                                        <div class="red" id="LoginErrorMsgRev"></div>
                                                        <div class="out_btn">
                                                            <?php
                                                            /*
                                                              <div class="radio_btn">
                                                              <input type="radio" name="frmUserTypeLn" value="customer" class="styled" checked="checked" />
                                                              <small><?php echo CUSTOMER; ?></small>
                                                              </div>
                                                             */
                                                            ?>
                                                        </div>

                                                        <div class="form" style="margin-top:0px;">
                                                            <label class="username">
                                                                <span><?php echo EM_ID; ?> :</span>
                                                                <input type="text" style="margin-bottom:20px;" class="saved" placeholder="Email Id" autocomplete="off" value="<?php echo isset($_COOKIE['email_id']) ? $_COOKIE['email_id'] : ''; ?>" name="frmUserEmailLn" id="frmUserEmailLnRev" onKeyup="Javascript: if (event.keyCode == 13)
                    loginActionCustomer('review');"/>
                                                                <div class="frmUserEmailLn"></div>
                                                            </label>
                                                            <div style="height:30px; clear:both"></div>  <label class="password">
                                                                <span><?php echo PASSWORD; ?> :</span>
                                                                <input type="password" class="saved" placeholder="Password" value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>" autocomplete="off" name="frmUserPasswordLn" id="frmUserPasswordLnRev" onKeyup="Javascript: if (event.keyCode == 13)
                    loginActionCustomer('review');"/>
                                                                <div class="frmUserPasswordLn"></div>
                                                            </label>
                                                            <div class="password">
                                                                <span>&nbsp;</span>
                                                                <div class="check_box">
                                                                    <input type="checkbox" name="remember_me" value="yes" class="styled" <?php echo isset($_COOKIE['email_id']) ? "checked" : ''; ?>/>
                                                                    <small><?php echo REMEMBER_ME; ?></small>  <a href="#forgetPassword" onclick="return jscallLoginBox('jscallForgetPasswordBox', '1');" class="jscallForgetPasswordBox save_for" style="padding-right:80px"><?php echo FORGOT_PASSWORD; ?></a>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="frmProductToWish" id="frmProductToWish" value=""/>
                                                            <input type="button" style="display: block;
                                                                   margin: 0px auto;
                                                                   clear: both;
                                                                   float: none;" name="frmHidenAdd" onclick="loginActionCustomerToWish('review')" value="Sign In"  class="submit3" id="signUptoSave" saveTo="addwishlist"/>
    <!--                                                        <p>
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
                                        <!--                            </div>
                                                                </div>-->
                                        <!-- Login Box End-->
                                    </div>
                                </div>
                            </div>

                            <div class="right_section" style="width:288px; margin-left:11px; float:left;">
                                <!--<div class="right_side">-->
                                <!--                                    <div class="gradient" id="idAddToProductCart">
                                <?php include_once(INC_PATH . 'right_side_cart.php'); ?>
                                                                    </div>-->
                                <div class="gradient2" <?php
                                     if (count($objPage->arrData['arrCompareDetails']) == 0) {
                                         echo "style='background:none'";
                                     }
                                     ?>>
                                         <?php // include_once(INC_PATH . 'right_side_recommend_good_search.php');         ?>
                                         <?php include_once(INC_PATH . 'right_side_recommend_good_search_new.php'); ?>
                                </div>
                            </div>
                        </div>
                        <!--Package Product End Here-->

                    </div>
                </div>
            </div>
            <?php include_once INC_PATH . 'footer.inc.php'; ?>
    </body>
</html>
