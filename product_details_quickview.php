<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_PRODUCT_CTRL;
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;
require_once CLASSES_PATH . 'class_home_bll.php';
require_once CLASSES_PATH . 'class_product_bll.php';
$objProduct = new Product();
$objComman = new ClassCommon();
$objHome = new Home();
$varPid = trim($_REQUEST['id']);
$customer_id = $_SESSION['sessUserInfo']['id'];

//$arrData = $objHome->getQuickViewDetails($varPid);
//pre($_SESSION);
$varRateReview = $objProduct->getUserReviewCustomer($valTop['pkProductID'], $customer_id);
//  pre($varRateReview);
?>
<style>
    #cboxLoadedContent{ overflow:hidden !important}
    .errorBox{position: absolute;top:-32px;}
    .errorQuantity{position: absolute;top:-34px;}
    /*    .check_box,.input_S{position: relative;}*/
    .recommmend_blog .formError{position: static !important;}
    .review_sec1 .formError{position: absolute !important; margin-top: 100px!important;}
    .pro_info_tooltip{background-color: #fff;border: 1px solid #ccc; border-radius: 4px; display: none; left: -5px; padding: 3px;
                      position: absolute; top: 48px; z-index: 999;width: 35px;height: 35px;}
    .pro_info_tooltip_arrow{background: url("<?php echo SITE_ROOT_URL; ?>common/images/tooltip_arrow.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
                            color: #ccc;font-size: 28px;height: 13px;left: 17px;position: absolute;top: -13px;width: 17px;z-index: 9999;}
    .quick_title1 span{border-bottom:4px solid #909090}
    .nt-example-images{height:400px !important}
    .top-arrow{margin-bottom:17px !important; margin-left:46px !important;cursor:pointer}
    .bottom-arrow{margin-top:17px !important; margin-left:46px !important;cursor:pointer}
    .imgBorder{border: 1px solid !important;border-color: #b3b3b3 !important;}
    /*29/7/15D*/
    .fb_icon{margin:-1px 0 0;}
    #plusone{margin-top:3px!important;}
    .shipping-table1{ border:1px solid #eee}
    .shipping-table1 th{background: #f8f8f8;}
    .shipping-table1 th , .shipping-table1 td{ padding:10px 0; border:1px solid #eee; text-align:center}
    #showshippingdetails{ margin-top:60px }
    @media only screen and (max-width:1024px){
        .nt-example-images{height:auto !important}
        /*.nt-example-images { height: 340px !important; }*/
    }
    @media only screen and (max-width:1139px){
        .nt-example-images { height: 350px !important; }
    }
    @media only screen and (max-width:1024px){
        .nt-example-images { height: 330px !important; }
    }

    @media only screen and (max-width:767px){
        .nt-example-images { height: 330px !important; }
    }
    @media only screen and (max-width:479px){
        .top-arrow, .bottom-arrow{ margin-left:29px !important; }
        .zoomPad > img { height: auto; }
        .nt-example-images { height: 230px !important; }
        .newProductPage .social_icon1 {  margin-top: 30px; padding: 0 27px; }
    }
    @media only screen and (max-width:320px){
        #product-view > a { width: 56% !important; }
        .nt-example-images { height: 160px !important; }
        .newProductPage .social_icon1 {  margin-top: 30px; padding: 0 70px; }
        #product-view > a { width: 71% !important; }
        .newProductPage .social_icon1 { padding:0; }
    }

</style>
<script>
    function showtip(count)
    {
        count = $.trim(count);
        $('#pro_info_tooltip_' + count).show();
    }
    function hidetip(count)
    {
        count = $.trim(count);
        $('#pro_info_tooltip_' + count).hide();
    }
</script>
<div class="products_quickview newProductPage">
    <script>
        function addToWishlist(prodid) {
            $('#addtoCompareMessage' + prodid).hide();
            $('.succCart').show();

            $.post(SITE_ROOT_URL + 'common/ajax/ajax_compare.php', {
                action: 'addToWishlist',
                pid: prodid
            }, function (data) {
                $('.succCart').html('&nbsp; ' + ADD_WISHLIST_SUCC);
                setTimeout(function () {
                    $('.succCart').html('&nbsp')
                }, 4000);
            });
        }

        function addToWishlistLogin(prodid) {
            $('#addtoCompareMessage' + prodid).hide();
            $('.succCart').show();
            $('.succCart').html('<span class="red">&nbsp; Please login as customer to add save list.</span>');
            setTimeout(function () {
                $('.succCart').html('&nbsp')
            }, 4000);
        }
    </script>  
    <script type="text/javascript">
        (function () {
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
                }, function (data) {
                    //alert(data);
                });
            }
        }
        $("document").ready(function () {

            $("#checkShippingAvilable").click(function (e) {
                call_me_baby($("#productShippingCountry").val(), $(this).attr('data-attr-pid'));
                $("#showshippingdetails").html('')
                e.preventDefault();
            })

            $("#productShippingCountry").select2().select2('val', '<?php echo $_SESSION['SiteCurrencyCountryID']; ?>');

            $('.border2 img').on('click', function () {
                var obj = $(this);
                var pId = obj.parent().parent().parent().parent().attr('id');
                $('#' + pId).find('.border2 img').removeClass('imgBorder');
                //obj.parent().parent().parent().parent().removeClass('imgBorder');
                obj.addClass('imgBorder');
            });
        });

        function call_me_baby(country_id, product_id) {
            $(".show_country_error, .show_country_success").html("").css("display", "none");
            $.post(SITE_ROOT_URL + 'common/ajax/ajax_product_availablity.php', {
                action: 'check_country_availaibility',
                pid: product_id,
                cid: country_id
            }, function (data) {
                data = JSON.parse(data);

                if (data.value)
                {
                    $("#showshippingdetails").html(data.value)
                }
                if (data.status) {
                    setTimeout(function () {
                        $(".show_country_success").html("Product is available for this country").css("display", "block").fadeIn("slow")
                    }, 1000)

                } else {
                    setTimeout(function () {
                        $(".show_country_error").html("This product is not available for this country").css("display", "block").fadeIn("slow")
                    }, 1000)
                }
            });
        }

        call_me_baby('<?php echo $_SESSION['SiteCurrencyCountryID']; ?>', '<?php echo $valTop['pkProductID']; ?>', true);

    </script>

    <div id="QuickView<?php echo $valTop['pkProductID']; ?>" class="quick_color">
        <div id="colorBox_table">
            <div class="colormy_lefttd">
                <div class="clearfix product_img" id="content">
                    <div class="clearfix imgs" id="product-view">
                        <?php
                        $varImageCount = count($valTop['arrproductImages']);
                        list($width, $height) = explode('x', $arrProductImageResizes['landing']);
//echo $height;

                        if ($varImageCount > 0) {
                            ?>
                            <a href="<?php echo $objCore->getImageUrl($valTop['ProductImage'], 'products/' . $arrProductImageResizes['detailHover']); ?>" class="jqzoom" rel='<?php echo "gal" . $valTop['pkProductID']; ?>'  >
                                <img width="<?php echo $width ?>px" height="<?php echo $height ?>px" src="<?php echo $objCore->getImageUrl($valTop['ProductImage'], 'products/' . $arrProductImageResizes['landing']); ?>"  title="<?php echo INDEX_TRIUMPH; ?>"  />
                            </a>
                            <?php
                        } else {
                            ?>
                            <a href="<?php echo $objCore->getImageUrl('', 'products/' . $arrProductImageResizes['detailHover']); ?>" class="jqzoom" rel='<?php echo "gal" . $valTop['pkProductID']; ?>'  >
                                <img width="<?php echo $width ?>px" height="<?php echo $height ?>px" src="<?php echo $objCore->getImageUrl('', 'products/' . $arrProductImageResizes['landing']); ?>"  title="<?php echo INDEX_TRIUMPH; ?>"  style="border: 2px solid #666;" />
                            </a>
                        <?php } ?>
                        <?php
                        $days = $objComman->dateDiffInDays($valTop['ProductDateAdded'], date('Y-m-d H:i:s'));
                        if ($days <= NEW_PRODUCT_BASED_ON_DAYS) {
                            ?>
                            <div class="new"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>new_product.png" alt=""/></div>
                            <?php
                        }
                        ?>

                        <div class="social_icon1"><div class="social_share">
                                <a onclick='postToFeed();
                                        return false;' class="fb_icon"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>fb-icon.png" alt="Facebook Share" width="28" height="28"/></a>
                                <a href="javascript:void(0);" class="tiwtter" onclick="(function () {
                                            var url = 'https://twitter.com/intent/tweet?tw_p=tweetbutton&amp;url=' + encodeURI('<?php echo $objCore->getUrl('product.php', array('id' => $objPage->arrproductDetails[0]['pkProductID'], 'name' => $objPage->arrproductDetails[0]['ProductName'], 'refNo' => $objPage->arrproductDetails[0]['ProductRefNo'])) ?>') + '&amp;text=<?php echo SITE_NAME ?>';
                                            url = encodeURI(url);
                                            window.open(url, 'Tweet', 'height=500,width=700');
                                        })()" >
                                    <img src="<?php echo IMAGE_FRONT_PATH_URL; ?>tiwtter.png" alt="Twitter" width="28" height="28"/>
                                </a>
                                <div class="g-plusone" data-size="tall" data-annotation="none" data-href="<?php echo $objCore->getUrl('product.php', array('id' => $objPage->arrproductDetails[0]['pkProductID'], 'name' => $objPage->arrproductDetails[0]['ProductName'], 'refNo' => $objPage->arrproductDetails[0]['ProductRefNo'])) ?>" data-callback="plusOneClick" ><meta property="og:url" content="<?php echo $objCore->getImageUrl($varThumbImages['ImageName'], 'products/' . $arrProductImageResizes['default']); ?>"/></div>
                            </div></div>

                    </div>

                    <div class="clearfix newthumbNails" style="border-right:1px solid #eee;width:109px;overflow:auto">

                        <div class=" jcarousel-skin-tango">
                            <div style="position: relative; display: block;" class="jcarousel-container jcarousel-container-horizontal">
                                <div style="position: relative;" class="jcarousel-clip jcarousel-clip-horizontal">
                                    <div class="slide_arrows right-menu-arrows top-arrow">
                                        <i  class="fa fa-angle-up nt-example-images-prev" id=""></i>

                                    </div>
                                    <ul  class="clearfix small_imgs thumblist nt-example-images" id="<?php echo "top-thumblist" . $valTop['pkProductID']; ?>">
                                        <?php
                                        if ($varImageCount > 0) {
                                            $varImageStart = 0;
                                            //mail('sandeep.sharma@mail.vinove.com','hi2',print_r($valTop['arrproductImages'],1));
                                            foreach ($valTop['arrproductImages'] as $varThumbImages) {
                                                ?>
                                                <li>
                                                    <div class="border2">
                                                        <a href='javascript:void(0);' rel="{gallery: 'gal<?php echo $valTop['pkProductID']; ?>', smallimage: '<?php echo $objCore->getImageUrl($varThumbImages['ImageName'], 'products/' . $arrProductImageResizes['landing']); ?>',largeimage: '<?php echo $objCore->getImageUrl($varThumbImages['ImageName'], 'products/' . $arrProductImageResizes['detailHover']); ?>'}">
                                                            <img src='<?php echo $objCore->getImageUrl($varThumbImages['ImageName'], 'products/' . $arrProductImageResizes['default']); ?>'/>
                                                        </a>
                                                    </div>
                                                </li>
                                                <?php
                                                $varImageStart++;
                                            }
                                        } else {
                                            ?>
                                            <li>
                                                <div class="border2">
                                                    <a  href='javascript:void(0);' rel="{gallery: 'gal<?php echo $valTop['pkProductID']; ?>', smallimage: '<?php echo $objCore->getImageUrl('', 'products/' . $arrProductImageResizes['detail']); ?>',largeimage: '<?php echo $objCore->getImageUrl('', 'products/' . $arrProductImageResizes['detailHover']); ?>'}">
                                                        <img src='<?php echo $objCore->getImageUrl('', 'products/' . $arrProductImageResizes['default']); ?>' />
                                                    </a>
                                                </div>
                                            </li>

                                            <?php
                                        }
                                        ?>
                                    </ul>
                                    <div class="slide_arrows right-menu-arrows bottom-arrow">
                                        <i  class="fa fa-angle-down nt-example-images-next" id=""></i>
                                    </div>
                                </div>
                                <div disabled="disabled" style="display: block;" class="jcarousel-prev jcarousel-prev-horizontal jcarousel-prev-disabled jcarousel-prev-disabled-horizontal"></div>
                                <div style="display: block;" class="jcarousel-next jcarousel-next-horizontal"></div>
                            </div></div>
                    </div>
                    <p id='msg'></p>

                </div>

            </div>

            <div class="colormy_righttd">
                <div class="products_detail attribute_quick_view">
                    <div class="top_casual" >
                        <div class="quick_title">   <h1><?php echo ucfirst($valTop['ProductName']); ?></h1></div>

                        <div class="quick_left">  <?php $feedbacks = $objComman->getProductFeedbacks($valTop['pkProductID']); ?>
                            <div class="red"><?php echo $objComman->getRatting($valTop['Rating']); ?><div class="red" style="color: #8c8c8c;float: left; margin-right:15px;"><?php echo floatval(number_format($valTop['Rating'], 1)); ?> Rating</div></div>
                            <?php //$productRate = ($objPage->arrRatingDetails[0]['numRating']) / ($objPage->arrRatingDetails[0]['numCustomer']);      ?>

                            <div class="review"> <span class="cust_review"><?php echo CUS_REVIEW; ?></span> (<a  <?php
                                if ($valTop['customerReviews'] > 0) {
                                    ?>href="#show_review" title="Click here to see reviews and rating"  onclick="return product_reviews()" <?php
                                    } else {
                                        echo "style='cursor:default;'";
                                    }
                                    ?> class="ornage_text reviews" ><?php echo $valTop['customerReviews']; ?></a>)</div></div>
                        <div class="quick_right"><p>
                                <?php
                                if ($_SESSION['sessUserInfo']['type'] == 'customer') {
                                    $varRateReview = $objProduct->getUserReviewCustomer($valTop['pkProductID'], $customer_id);
                                    // pre($varRateReview);
                                    if (!empty($varRateReview)) {
                                        // pre("here");
                                        ?>
                                        <a class="review_txt customer_review_multiple_product" href="#"><?php echo WRITE_REVIEW; ?></a>
                                        <?php
                                    } else {
                                        //pre("there");
                                        ?>
                                        <a class="review_txt" href="#reviewSec"  onclick="return product_review_page()"><?php echo WRITE_REVIEW; ?></a>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <a class="review_txt customer_review_before_login" href="#"><?php echo WRITE_REVIEW; ?></a>
                                <?php } ?>
                                <a href="#recommend_details" class="active recommend" onclick="return jscall_recommend(<?php echo $valTop['pkProductID']; ?>)" ><?php echo RECOMMEN; ?></a></p></div>
<!--                      	<p class="detail_txt"><?php echo $valTop['ProductDescription']; ?></p>-->
                        <div style='display:none'>
                            <div id="recommend_details" class="reply_message">  
                                <form name="frmRecommendform" id="frmRecommendform" method="POST" action="">
                                    <div class="req_field" style="float:left !important">* Fields are required</div><br />   <div class="left_m" style="clear:both"><span class="red">*</span><label><?php echo Y_NAME; ?> </label> :</div><div class="right_m">
                                        <input type="text" name="frmName" value="<?php echo ucfirst($objPage->arrCustomerDetails[0]['CustomerFirstName']) . " " . $objPage->arrCustomerDetails[0]['CustomerLastName']; ?>" class="validate[required]" />
                                    </div>
                                    <div class="left_m"><span class="red">*</span><label><?php echo Y_EMAIL; ?> </label> :</div><div class="right_m">
                                        <input type="text" name="frmEmail" value="<?php echo $objPage->arrCustomerDetails[0]['CustomerEmail']; ?>" class="validate[required,custom[email]]" />
                                    </div>

                                    <div class="left_m"><span class="red">*</span><label><?php echo FR_EMAIL; ?> </label>:</div><div class="right_m">
                                        <textarea id="frmFriendEmail" name="frmFriendEmail" class="validate[required,custom[multiemail]]"></textarea>
                                    </div>

                                    <div class="left_m">&nbsp;</div><div class="right_m">
                                        <input type="submit" name="frmHidenSend" class="cart_link"  value="Send" />
                                        <input type="button" name="cancel" value="Cancel" class="watch_link" id="recommend_cancel" />
                                    </div>
                                    <input type="hidden" name="proName" id="proName"  value="<?php echo $objPage->arrproductDetails[0]['ProductName']; ?>" />
                                    <input type="hidden" name="proId" id="proId" value="<?php echo $valTop['pkProductID']; ?>" />
                                </form>
                            </div>
                        </div>
                        <div class="checkProductShipping">
                            <div class="productShippingImage">
                                Check Shipping Availability At
                            </div>
                            <div style="color:#e43137;" class="show_country_error"></div>
                            <div style="color:#00BB27; display:none" class="show_country_success"></div>  
                            <div class="productShipping">
                                <?php
                                $a = $objGeneral->getCountry();
                                foreach ($productmulcountrydetail as $kk => $vv) {
                                    $SelectedCountry[$kk] = $vv['country_id'];
                                }
                                echo $objGeneral->CountryHtml($a, 'name[]', 'productShippingCountry', $SelectedCountry, '', 0, 'class="select2-me" style="width:100%"', '1', '1');
                                ?>

                                <input type="hidden" name="checkShippingByProductId" id="checkShippingByProductId" value="<?php echo $valTop['pkProductID']; ?>" />
                            </div>
                            <div class="productShippingButton">
                                <input type="button" value="Check" id="checkShippingAvilable" data-attr-pid="<?php echo $valTop['pkProductID']; ?>"/>
                            </div>
                            <div id="showshippingdetails">

                            </div>

                        </div>
                        <div class="productShippingMsgDiv">
                            <div class="productShippingMsg" style="clear:both;"></div>
                        </div>
                        <div class="outer_blog"  style="background: #f8f8f8;" >

                            <h2>
                                <?php
                                if ($valTop['offerPrice'] == '') {
                                    ?>
                                    <span class="price_details" style="padding-left: 14px;">
                                          <!--  <span><?php echo PRICE; ?>:</span>-->
                                        <?php
                                        echo $objCore->getFinalPrice($valTop['FinalPrice'], $valTop['DiscountFinalPrice'], $valTop['FinalSpecialPrice'], 0, 1);

                                        $varProductPrice = $objCore->getFinalPrice($valTop['FinalPrice'], $valTop['DiscountFinalPrice'], $valTop['FinalSpecialPrice'], 1, 1);

                                        $varProductPrice = $objCore->getPrice($varProductPrice);
                                        if ($valTop['DiscountFinalPrice'] > 0) {
                                            $getDValue = $valTop['FinalPrice'] - $objCore->getSavePrice($valTop['DiscountFinalPrice'], $valTop['FinalSpecialPrice']);
                                            ?>

                                            <div class="save_amt">You Save <cite><?php echo $objCore->getPrice($getDValue); ?></cite></div>
                                        <?php } ?>

                                    </span>
                                    <?php
                                } else {
                                    ?>
                                    <span class="price_details" style="padding-left: 14px;">
                                          <!--  <span><?php echo PRICE; ?>:</span>-->
                                        <?php
                                        echo $objCore->getFinalPrice($valTop['FinalPrice'], $valTop['offerPrice'], $valTop['FinalSpecialPrice'], 0, 1);

                                        $varProductPrice = $objCore->getFinalPrice($valTop['FinalPrice'], $valTop['offerPrice'], $valTop['FinalSpecialPrice'], 1, 1);

                                        $varProductPrice = $objCore->getPrice($varProductPrice);
                                        if ($valTop['offerPrice'] > 0) {
                                            $getDValue = $valTop['FinalPrice'] - $objCore->getSavePrice($valTop['DiscountFinalPrice'], $valTop['offerPrice']);
                                            ?>

                                            <div class="save_amt">You Save <cite><?php echo $objCore->getPrice($getDValue); ?></cite></div>
                                        <?php } ?>
                                    </span>
                                <?php } ?>

                            </h2>

                        </div>
                        <ul class="recommmend_blog" style="background: #f8f8f8;padding: 14px 0px 0px 14px;width:97%" > 
                            <?php
//pre($valTop);
                            if (count($valTop['arrAttributes']) > 0) {
                                ?>
                                <?php
                                $varOptPrice = '';
                                $attributesVariable = '';
                                $functions = '';
                                //  pre($valTop);
                                foreach ($valTop['arrAttributes'] as $valproductAttribute) {
                                    if ($attributesVariable != '')
                                        $attributesVariable .= ";";
                                    $attributesVariable .= $valproductAttribute['pkAttributeId'] . ":" . $valproductAttribute['AttributeInputType'];

                                    $arrproductDetailsIsImgUploaded = explode(",", $valproductAttribute['IsImgUploaded']);
                                    $arrproductDetailsOptionImage = explode(",", $valproductAttribute['AttributeOptionImage']);
                                    $arrproductDetailsOptionTitle = explode(",", $valproductAttribute['AttributeOptionValue']);
                                    $arrproductDetailsColorcode = explode(",", $valproductAttribute['colorcode']);
                                    $arrproductDetailsOptionId = explode(",", $valproductAttribute['pkOptionID']);
                                    $arrproductDetailsOptionPrice = explode(",", $valproductAttribute['OptionExtraPrice']);
                                    $attrName = 'frmAttribute_top_' . $valTop['pkProductID'] . $valproductAttribute['pkAttributeId'];
                                    //for select box type
//                                    pre($arrproductDetailsColorcode);
                                    ?>
                                    <li type="<?php echo $valproductAttribute['AttributeInputType']; ?>" class="MyAttr" attrId="<?php echo $valproductAttribute['pkAttributeId']; ?>">
                                        <?php
                                        //echo $valproductAttribute['AttributeInputType'];
                                        if ($valproductAttribute['AttributeInputType'] == "image" || $valproductAttribute['AttributeLabel'] == 'Color' || $valproductAttribute['AttributeLabel'] == 'color') {
                                            ?>
                                            <label style="float: left;">Available in</label>
                                            <?php
                                        } else {
                                            ?>
                                            <label style="float: left;"><?php echo $valproductAttribute['AttributeLabel']; ?></label>
                                        <?php } ?>
                                        <?php
                                        if ($valproductAttribute['AttributeInputType'] == "select") {
                                            ?>
                                            <div class="drop11">
                                                <div class="errorBox" style="display: block;"></div>

                                                <select class="drop_down1 GetAttributeValues changePriceSelect <?php echo $valproductAttribute['AttributeLabel'] == 'Color-type' ? 'coloroption' : ''; ?>" name="<?php echo $attrName; ?>" id="frmAttribute_<?php echo $valproductAttribute['pkAttributeId']; ?>">
                                                    <option value="">Select</option>
                                                    <?php
                                                    $varCountAtrributeOption = 0;
                                                    $selectVal = count($arrproductDetailsOptionTitle);
                                                    foreach ($arrproductDetailsOptionTitle as $valoptionTitle) {
                                                        $varOptPrice .=$arrproductDetailsOptionId[$varCountAtrributeOption] . '=' . $objCore->getPrice($arrproductDetailsOptionPrice[$varCountAtrributeOption]) . ',';
                                                        ?>
                                                        <option value="<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>"<?php
                                                        if ($selectVal == 1) {
                                                            echo 'selected';
                                                            //  $functions .= "textSelect('" . $arrproductDetailsOptionId[$varCountAtrributeOption] . "', '" . $valproductAttribute['pkAttributeId'] . "','" . $valproductAttribute['AttributeInputType'] . "');";
                                                        }
                                                        ?> <?php echo $valproductAttribute['AttributeLabel'] == 'Color-type' ? 'style="background:' . $valoptionTitle . '"' : '' ?>><?php echo $valoptionTitle ?></option>
                                                                <?php
                                                                $varCountAtrributeOption++;
                                                            }
                                                            ?>
                                                </select>
                                                <script>
                                                    $(document).ready(function () {
            <?php
            $varCountAtrributeOption = 0;
            $selectVal = count($arrproductDetailsOptionTitle);
            $cl = 1;
            foreach ($arrproductDetailsOptionTitle as $valoptionTitle) {
                if ($valproductAttribute['AttributeLabel'] == 'Color-type') {
                    ?>
                                                                //$('.coloroption').next().find('div:eq(1)').find('li:eq(<?php echo $cl; ?>)').find('a').html('&nbsp;');
                                                                $('.coloroption').next().find('div:eq(1)').find('li:eq(<?php echo $cl; ?>)').find('a').css('background', '<?php echo $valoptionTitle; ?>');
                    <?php
                } $cl++;
            }
            ?>

                                                    });
                                                </script>
                                            </div>

                                            <?php
                                        }
                                        // for radio button  type
//                                        print_r($valproductAttribute);
                                        if ($valproductAttribute['AttributeInputType'] == "radio") {
//                                           pre($arrproductDetailsOptionTitle);
                                            ?>
                                            <div class="size check_box <?php echo ($valproductAttribute['AttributeLabel'] == 'Color' || $valproductAttribute['AttributeLabel'] == 'color') ? 'redio_color' : ''; ?>" id="attrdiv_<?php echo $valproductAttribute['pkAttributeId']; ?>">
                                                <div class="errorBox" style="display: block;"></div>
                                                <?php
                                                $varCountAtrributeOption = 0;
                                                $radioVal = count($arrproductDetailsOptionTitle);

//                                                sort($arrproductDetailsOptionTitle);
//                                                print_r($arrproductDetailsColorcode);
                                                foreach ($arrproductDetailsOptionTitle as $key => $valoptionTitle) {
                                                    $varOptPrice .=$arrproductDetailsOptionId[$varCountAtrributeOption] . '=' . $objCore->getPrice($arrproductDetailsOptionPrice[$varCountAtrributeOption]) . ',';
                                                    ?>
                                                    <input type="radio" value="<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>" name="frmAttribute_<?php echo $valproductAttribute['pkAttributeId']; ?>" class="GetAttributeValues" <?php
                                                    if ($radioVal == 1) {
                                                        echo 'checked';
                                                        $functions .= "textSelect('" . $arrproductDetailsOptionId[$varCountAtrributeOption] . "', '" . $valproductAttribute['pkAttributeId'] . "','" . $valproductAttribute['AttributeInputType'] . "');";
                                                    }
                                                    ?> tabindex="24" style="display:none" />
                                                           <?php // pre($valproductAttribute);  ?>
                                                    <a class="double" href="javascript:void(0)"
                                                       title="<?php echo $valoptionTitle; ?>" 
                                                       class="" 
                                                       id="frmAttribute_<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>"
                                                       onclick="textSelect('<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>', '<?php echo $valproductAttribute['pkAttributeId']; ?>', '<?php echo $valproductAttribute['AttributeInputType']; ?>')" 
                                                       <?php echo ($valproductAttribute['AttributeLabel'] == 'Color' || $valproductAttribute['AttributeLabel'] == 'color') ? 'style="background:' . $arrproductDetailsColorcode[$key] . '"' : '' ?>>
                                                           <?php echo ($valproductAttribute['AttributeLabel'] == 'Color' || $valproductAttribute['AttributeLabel'] == 'color') ? '' : $valoptionTitle ?>
                                                        <span class="rollover_2 " id="check_<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>"></span></a>

                                                    <?php
                                                    $varCountAtrributeOption++;
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        }
                                        //For checkbox type
                                        if ($valproductAttribute['AttributeInputType'] == "checkbox") {
                                            ?>
                                            <div class="check_box branding">
                                                <div class="errorBox" style="display: block;"></div>
                                                <?php
                                                $varCountAtrributeOption = 0;
                                                $checkboxVal = count($arrproductDetailsOptionTitle);
                                                sort($arrproductDetailsOptionTitle);
                                                foreach ($arrproductDetailsOptionTitle as $valoptionTitle) {
                                                    $varOptPrice .=$arrproductDetailsOptionId[$varCountAtrributeOption] . '=' . $objCore->getPrice($arrproductDetailsOptionPrice[$varCountAtrributeOption]) . ',';
                                                    ?>
                                                    <input type="checkbox"  name="frmAttribute_<?php echo $valproductAttribute['pkAttributeId']; ?>" value="<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>" class="GetAttributeValues changePriceCheckBox" <?php
                                                    if ($checkboxVal == 1) {
                                                        echo 'checked';
                                                        $functions .= "textSelect('" . $arrproductDetailsOptionId[$varCountAtrributeOption] . "', '" . $valproductAttribute['pkAttributeId'] . "','" . $valproductAttribute['AttributeInputType'] . "');";
                                                    }
                                                    ?>  /> <span style="padding-left: 5px;padding-right: 5px;" class="name_brand"><?php echo $valoptionTitle; ?></span>
                                                           <?php
                                                           $varCountAtrributeOption++;
                                                       }
                                                       ?>
                                            </div>
                                            <?php
                                        }
                                        //for textbox type
                                        if ($valproductAttribute['AttributeInputType'] == "text") {
                                            ?>
                                            <div class="errorBox" style="display: block;"></div>
                                            <input type="text" name="<?php echo $attrName; ?>" value="<?php echo $valproductAttribute['AttributeOptionValue']; ?>" class="GetAttributeValues" />
                                            <?php
                                        }
                                        //for textarea type
                                        if ($valproductAttribute['AttributeInputType'] == "textarea") {
                                            ?>
                                            <div class="errorBox" style="display: block;"></div>
                                            <textarea  name="<?php echo $attrName; ?>" class="GetAttributeValues"></textarea>
                                            <?php
                                        }
                                        //for Date type
                                        if ($valproductAttribute['AttributeInputType'] == "date") {
                                            ?>
                                            <div class="errorBox" style="display: block;"></div>
                                            <input type="text" name="<?php echo $attrName; ?>" value="<?php echo $valproductAttribute['AttributeOptionValue']; ?>" class="GetAttributeValues" />
                                            <?php
                                        }
                                        //For Image type
//                                        print_r($valproductAttribute);
                                        if ($valproductAttribute['AttributeInputType'] == "image") {
                                            ?>

                                            <div class="outer_pics check_box imagecheckbox " id="attrdiv_<?php echo $valproductAttribute['pkAttributeId']; ?>">
                                                <div class="errorBox" style="display: block;"></div>

                                                <?php
                                                $varCountAtrributeOption = 0;
                                                $radioVal = count($arrproductDetailsOptionTitle);
                                                // print_r($arrproductDetailsOptionImage);
                                                foreach ($arrproductDetailsOptionTitle as $keyoptionTitle => $valoptionTitle) {
                                                    $varOptPrice .=$arrproductDetailsOptionId[$varCountAtrributeOption] . '=' . $objCore->getPrice($arrproductDetailsOptionPrice[$varCountAtrributeOption]) . ',';
                                                    ?>
                                                    <input type="radio" value="<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>" name="frmAttribute_<?php echo $valproductAttribute['pkAttributeId']; ?>" class="GetAttributeValues" <?php
                                                    if ($radioVal == 1) {
                                                        echo 'checked';
                                                        $functions .= "textSelect('" . $arrproductDetailsOptionId[$varCountAtrributeOption] . "', '" . $valproductAttribute['pkAttributeId'] . "','" . $valproductAttribute['AttributeInputType'] . "');";
                                                    }
                                                    ?> tabindex="24" style="display:none" />
                                                           <?php //print_r($arrproductDetailsOptionImage);  ?>
                                                    <span class="pics"
                                                          id="frmAttribute_<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>">
                                                              <?php //print_r($arrproductDetailsOptionImage[$varCountAtrributeOption]);  ?>
                                                        <a class="double"
                                                           onmouseout="hidetip('<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>')"

                                                           onmouseover="showtip('<?php echo (!empty($arrproductDetailsOptionImage[$varCountAtrributeOption])) ? $arrproductDetailsOptionId[$varCountAtrributeOption] : ''; ?>')"
                                                           id="imageAnchar_<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>"
                                                           href='javascript:void(0);'
                                                           <?php
                                                           $checkFiles = UPLOADED_FILES_SOURCE_PATH . 'images/products/35x35/' . $arrproductDetailsOptionImage[$varCountAtrributeOption];
                                                           //if ($arrproductDetailsIsImgUploaded[$keyoptionTitle] == 1) {
                                                           ?>
                                                           <?php if (!empty($arrproductDetailsOptionImage[$varCountAtrributeOption])) { ?>rel="{gallery: 'gal<?php echo $valTop['pkProductID']; ?>', smallimage: '<?php echo $objCore->getImageUrl($arrproductDetailsOptionImage[$varCountAtrributeOption], 'products/' . $arrProductImageResizes['landing']); ?>',largeimage: '<?php echo $objCore->getImageUrl($arrproductDetailsOptionImage[$varCountAtrributeOption], 'products/' . $arrProductImageResizes['detailHover']); ?>'}" <?php } ?>
                                                           style="<?php if (file_exists($checkFiles)) { ?>padding:3px;<?php } ?>;background:<?php echo $arrproductDetailsColorcode[$keyoptionTitle] != '' ? $arrproductDetailsColorcode[$keyoptionTitle] : $valoptionTitle ?>"
                                                           onclick="textSelect('<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>', '<?php echo $valproductAttribute['pkAttributeId']; ?>', '<?php echo $valproductAttribute['AttributeInputType']; ?>');">
                                                            <p style="display: none;">
                                                                <?php
                                                                //pre($checkFiles);
                                                                if ($arrproductDetailsOptionImage[$varCountAtrributeOption] != '' && file_exists($checkFiles)) {
                                                                    ?>

                                                                    <img width="85px" height="67px" src="<?php echo $objCore->getImageUrl($arrproductDetailsOptionImage[$varCountAtrributeOption], 'products/' . $arrProductImageResizes['color']); ?>">
                                                                <?php } ?>
                                                            </p>
                                                        </a>
                                                        <small class="rollover_1"  id="check_<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>"></small>
                                                        <div class="pro_info_tooltip" id="pro_info_tooltip_<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>">
                                                            <i class="pro_info_tooltip_arrow"></i>
                                                            <?php //print_r($arrproductDetailsOptionImage[$varCountAtrributeOption]);  ?>

                                                            <img width="35px" height="35px" style="width: 35px;height: 35px;" src="<?php echo (!empty($arrproductDetailsOptionImage[$varCountAtrributeOption])) ? $objCore->getImageUrl($arrproductDetailsOptionImage[$varCountAtrributeOption], 'products/' . $arrProductImageResizes['default']) : ''; ?>" alt="" />
                                                                <!--<div id="demo2_<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>">
                                                                    <img src="<?php //echo $objCore->getImageUrl($arrproductDetailsOptionImage[$varCountAtrributeOption], 'products/' . $arrProductImageResizes['landing3']);                              ?>" alt="" />
                                                                </div>-->
                                                        </div>

                                                    </span>
                                                    <?php
                                                    $varCountAtrributeOption++;
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </li>
                                    <?php
                                }
                                ?>
                            <?php }
                            ?>
                            <input type="hidden" class="varifiedUser" value="<?php echo ($_SESSION['sessUserInfo']['type'] == 'customer') ? 'loginuser' : 'needtologin'; ?>" />
                            <input type="hidden" id="all_att_val" name="all_att_val" value="<?php echo $attributesVariable; ?>" />
                            <input type="hidden" name="optPriceVal" id="optPriceVal" class="optPriceVal" value="<?php echo trim($varOptPrice, ','); ?>" currencyCode ="<?php echo $_SESSION['SiteCurrencySign']; ?>" productPrice="<?php echo $varProductPrice; ?>" pid="<?php echo $valTop['pkProductID']; ?>" />
                            <input type="hidden" name="viewPageDetails" id ="viewPageDetails" value="attribute_quick_view"/>
                            <li class="qty_li_cls">
                                <?php
//                                pre($valTop);
                                if ($valTop['Quantity'] > 0) {
                                    ?>
                                    <label><?php echo QTY; ?></label>
                                    <div class="quantity">
                                        <div class="input_S">
                                            <div class="errorQuantity"></div>
                                        </div>
                                        <input type="text" name="frmQuantity" id="frmQty" value="1" maxlength="3" readonly="" />
                                        <input type='button' name='add' onclick="quantityPlusMinus(1, 'qv')" value='+' class="plus" />
                                        <input type='button' name='subtract' onclick="quantityPlusMinus(0, 'qv')" value='-' class="minus" />
                                        <span></span>
                                    </div>

                                    <p class="mylabelP">
                                        <span class="labelSpan">Stock :</span>
                                        <span class="inStockspan" style=" background:<?php echo $valTop['Quantity'] == 0 ? '#c3c3c3' : '#FFFFFF'; ?>;"> <?php echo '<span id="stock">' . $valTop['Quantity'] . '</span> ' . IN_STOCK; ?>&nbsp;&nbsp;</span>
                                    </p>
                                    <div class="clear"></div>
                                    <div class="martop20 simpleBox">
                                        <?php /* <div style="color:#e43137";>

                                          //print_r($_SESSION['SiteCurrencyCountryID']);
                                          //print_r($objPage->avalCountry);

                                          if($objPage->avalCountry[0] == 0){

                                          }else if(!in_array($_SESSION['SiteCurrencyCountryID'],$objPage->avalCountry)){
                                          //echo "This product is not available for current country";
                                          }; ?>
                                          </div> */ ?>
                                        <div class="simpleBox">

                                            <p class="" id="add_cart_link" style="background:none;">
                                                <?php
                                                if ($_SESSION['sessUserInfo']['type'] == 'customer') {
                                                    ?>
                                                    <a class="watch_link1" href="javascript:void('0');" onclick="addToWishlist('<?php echo $valTop['pkProductID']; ?>')"><?php echo ADD_WISH; ?></a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a class="watch_link1" href="javascript:void('0');" onclick="addToWishlistLogin('<?php echo $valTop['pkProductID']; ?>')"><?php echo ADD_WISH; ?></a>
                                                <?php } ?>

                                                <a cmCid="<?php echo $valTop['fkCategoryID']; ?>" cmPid="<?php echo $valTop['pkProductID']; ?>" id="CompareCheckBox<?php echo $valTop['pkProductID']; ?>" class="compare_quick" onclick="addToCompare(<?php echo $valTop['pkProductID']; ?>,<?php echo $valTop['fkCategoryID']; ?>, '<?php echo $objCore->getUrl('product_comparison.php'); ?>');" href="javascript:void('0');">Compare</a>
                                            </p>
                                            <a href="javascript:void(0);" class="cart_link1" tp="<?php echo $_SESSION['sessUserInfo']['type']; ?>" pv="<?php echo $valTop['pkProductID']; ?>" pmv="<?php echo $valTop['Quantity']; ?>"><?php echo ADD_TO_CART; ?></a>
                                        </div>
                                        <div class="simpleBox">
                                            <?php
                                            if (!empty($valTop['FinalSpecialPrice'])) {
                                                ?>

                                                <div class="blue"><?php echo $objCore->getPoints($valTop['FinalSpecialPrice'] != 0 ? floor($valTop['FinalSpecialPrice']) : floor($valTop['FinalSpecialPrice'])); ?> <span>Points</span>	 to be earned on each item.</div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="blue"><?php echo $objCore->getPoints($valTop['DiscountFinalPrice'] != 0 ? floor($valTop['DiscountFinalPrice']) : floor($valTop['FinalPrice'])); ?> <span>Points</span>   to be earned on each item.</div>
                                            <?php }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    ?>

                                    <div class="input_S simpleBox">
                                        <div class="errorQuantity"></div>
                                        <input type="hidden" value="0" name="frmQuantity" id="frmQuantity" maxlength="3" disabled />
                                    </div>
                                    <div style="clear:both; margin-top:20px;">
                                        <div class="left_bottom">
                                            <p class="" style="padding-top:10px;background:none;">

                                                <?php
                                                if ($_SESSION['sessUserInfo']['type'] == 'customer') {
                                                    ?>
                                                    <a class="watch_link1" href="javascript:void('0');" onclick="addToWishlist('<?php echo $valTop['pkProductID']; ?>')">Add to Save List</a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a class="watch_link1" href="javascript:void('0');" onclick="addToWishlistLogin('<?php echo $valTop['pkProductID']; ?>')">Add to Save List</a>
                                                <?php } ?>
                                                <a cmCid="<?php echo $valTop['fkCategoryID']; ?>" cmPid="<?php echo $valTop['pkProductID']; ?>" id="CompareCheckBox<?php echo $valTop['pkProductID']; ?>" class="compare_quick" onclick="addToCompare(<?php echo $valTop['pkProductID']; ?>,<?php echo $valTop['fkCategoryID']; ?>, '<?php echo $objCore->getUrl('product_comparison.php'); ?>');" href="javascript:void('0');">Compare</a>
                                            </p>
                                        </div>
                                        <div class="right_bottom">
                                            <a href="javascript:void(0);" class="out_of_stock_cart_link1"><?php echo OUT_OF_STOCK; ?></a>
                                        </div>
                                    </div>
                                <big></big>
                            <?php } ?>
                            <div style="float: left">
                                <div class="succCart"></div>
                                <div id="addtoCompareMessage<?php echo $valTop['pkProductID']; ?>" class="addtoCompareMessage"></div>
                            </div>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
<?php echo $functions; ?>
        });
    </script>
</div>
