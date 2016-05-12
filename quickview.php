<?php
require_once 'common/config/config.inc.php';
require_once CLASSES_PATH . 'class_home_bll.php';
require_once CLASSES_PATH . 'class_product_bll.php';
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;
$objComman = new ClassCommon();
$objHome = new Home();
$objProduct = new Product();
$varPid = trim($_REQUEST['pid']);
$arrData = $objHome->getQuickViewDetails($varPid);
$valTop = $arrData[0];
//echo $valTop['pkProductID'];
//Get the review of the product
$varRateReview = $objProduct->getUserReview($varPid);
if ($_SESSION['sessUserInfo']['type'] == 'customer' && $_SESSION['sessUserInfo']['id'] > 0)
{
    $objProduct->productViewUpdate($varPid);
}
//pre($valTop);
//echo 'test';
?>


<style>
    #cboxLoadedContent { overflow:hidden !important;height:auto !important; }
    div#mcTooltip, div#mcTooltip div{display:block !important;}
    .recommmend_blog .errorBox{position: absolute;top:-32px;}
    .errorQuantity{position: absolute;top:-34px;}
    /*.check_box,.input_S{position: relative;}*/
    .formError{position: static !important;}
    .pro_info_tooltip{ background-color: #fff;border: 1px solid #ccc; border-radius: 4px; display: none;left: -5px;padding: 3px;
    position: absolute;top: 48px;z-index: 999;width: 35px;height: 35px;}
    .pro_info_tooltip_arrow{ background: url("<?php echo SITE_ROOT_URL; ?>common/images/tooltip_arrow.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    color: #ccc;font-size: 28px; height: 13px; left: 17px;position: absolute;top: -13px;width: 17px;z-index: 9999; }
    </style>
    <script>
        function showtip(count)
        {
            $('#pro_info_tooltip_'+count).show();
        }
        function hidetip(count)
        {

            $('#pro_info_tooltip_'+count).hide();
        }
    </script>

    <div class="products_quickview">
    <script>
		
        (function() {
            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
            po.src = 'https://apis.google.com/js/client:plusone.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
        })();

        function plusOneClick(response) {
            //alert(response.state);//console.log( response );

            if(response.state=='on'){
                $.post(SITE_ROOT_URL+"common/ajax/ajax_compare.php",{
                    action:"addSocialRewards",
                    SocialMedia:'Google'
                },function(data){
                    //alert(data);
                });
            }
        }
     
    </script>
    <div id='fb-root'></div>
    <script src='http://connect.facebook.net/en_US/all.js'></script>
    <script type="text/javascript">
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '647192451965551',
                status     : true,
                cookie     : true,
                xfbml      : true
            });
        };
        //        FB.init({appId: "647192451965551", status: true, cookie: true});

        function postToFeed() {

            // calling the API ...
            var obj = {
                method: 'feed',
                redirect_uri: SITE_ROOT_URL,
                link: '<?php echo $objCore->getUrl('product.php', array('id' => $objPage->arrproductDetails[0]['pkProductID'], 'name' => $objPage->arrproductDetails[0]['ProductName'], 'refNo' => $objPage->arrproductDetails[0]['ProductRefNo'])) ?>',
                picture: '<?php echo $objCore->getImageUrl($objPage->arrproductDetails[0]['ImageName'], 'products/' . $arrProductImageResizes['detail']); ?>',
                name: '<?php echo ucfirst(addslashes($objPage->arrproductDetails[0]['ProductName'])); ?>',
                //caption: 'Reference Documentation',
                //description: '<?php //echo ucfirst(addslashes($objPage->arrproductDetails[0]['ProductDescription']));                                                          ?>'
                description: $('#tab1 p').text()
            };

            function callback(response) {
                // alert(response);
                if (response == null){
                    document.getElementById('msg').innerHTML = "";
                }else{
                    //document.getElementById('msg').innerHTML = "<span style='color:green'><?php echo PRODUCT_SHARE_SUCC; ?></span>";
                    //setTimeout(function(){$('#msg').html('&nbsp')},4000);

                    $.post(SITE_ROOT_URL+"common/ajax/ajax_compare.php",{
                        action:"addSocialRewards",
                        SocialMedia:'Facebook'
                    },function(data){
                        //alert(data);
                    });
                }
            }
            FB.ui(obj, callback);
        }
        function validateRecommend()
        {
            $("#frmRecommendform").validationEngine();
        }
        //Show review popup here
        function product_reviews(){
            $('#show_review').show();
            $(".reviews").colorbox({
                inline:!0,
                width:"60%"
            }),$("#cboxClose").click(function(){
                parent.jQuery.fn.colorbox.close();
                $('#show_review').hide();
            })
        }
    </script>
    <div id="QuickView<?php echo $valTop['pkProductID']; ?>" class="quick_color">
        <div id="colorBox_table">
            <div class="colormy_lefttd">
                <div class="clearfix product_img" id="content">
                    <div class="clearfix imgs">
                        <?php
                        $varImageCount = count($valTop['arrproductImages']);
                        if ($varImageCount > 0)
                        {
                            ?>
                            <a href="<?php echo $objCore->getImageUrl($valTop['ProductImage'], 'products/' . $arrProductImageResizes['detailHover']); ?>" class="jqzoom" rel='<?php echo "gal" . $valTop['pkProductID']; ?>'  > <img src="<?php echo $objCore->getImageUrl($valTop['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" border="0"  title="<?php echo INDEX_TRIUMPH; ?>" /> </a>
                            <?php
                        }
                        else
                        {
                            ?>
                            <a href="<?php echo $objCore->getImageUrl('', 'products/' . $arrProductImageResizes['detailHover']); ?>" class="jqzoom" rel='<?php echo "gal" . $valTop['pkProductID']; ?>'  > <img src="<?php echo $objCore->getImageUrl('', 'products/' . $arrProductImageResizes['global']); ?>" border="0"  style="border: 2px solid #666;"  title="<?php echo INDEX_TRIUMPH; ?>" /> </a>
                        <?php } ?>
                        <?php
                        $days = $objComman->dateDiffInDays($valTop['ProductDateAdded'], date('Y-m-d H:i:s'));
                        if ($days <= NEW_PRODUCT_BASED_ON_DAYS)
                        {
                            ?>
                            <div class="new"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>new_product.png" alt="" border="0"/></div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="clearfix">
                        <div style="float: left; margin-top: 14px;margin-left: 3px;" class=" jcarousel-skin-tango">
                            <div style="position: relative; display: block;" class="jcarousel-container jcarousel-container-horizontal">
                                <div style="position: relative;" class="jcarousel-clip jcarousel-clip-horizontal">
                                    <ul  class="clearfix small_imgs thumblist" id="<?php echo "top-thumblist" . $valTop['pkProductID']; ?>">
                                        <?php
                                        if ($varImageCount > 0)
                                        {
                                            $varImageStart = 0;
                                            foreach ($valTop['arrproductImages'] as $varThumbImages)
                                            {
                                                ?>

                                                <li>
                                                    <div class="border2"> <a  href='javascript:void(0);' rel="{gallery: 'gal<?php echo $valTop['pkProductID']; ?>', smallimage: '<?php echo $objCore->getImageUrl($varThumbImages['ImageName'], 'products/' . $arrProductImageResizes['global']); ?>',largeimage: '<?php echo $objCore->getImageUrl($varThumbImages['ImageName'], 'products/' . $arrProductImageResizes['detailHover']); ?>'}"> <img src='<?php echo $objCore->getImageUrl($varThumbImages['ImageName'], 'products/' . $arrProductImageResizes['default']); ?>' border="0"/> </a> </div>
                                                </li>
                                                <?php
                                                $varImageStart++;
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                            <li>
                                                <div class="border2"> <a href='javascript:void(0);' rel="{gallery: 'gal<?php echo $valTop['pkProductID']; ?>', smallimage: '<?php echo $objCore->getImageUrl('', 'products/' . $arrProductImageResizes['global']); ?>',largeimage: '<?php echo $objCore->getImageUrl('', 'products/' . $arrProductImageResizes['detailHover']); ?>'}"> <img src='<?php echo $objCore->getImageUrl('', 'products/' . $arrProductImageResizes['default']); ?>' border="0" /> </a> </div>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div disabled="disabled" style="display: block;" class="jcarousel-prev jcarousel-prev-horizontal jcarousel-prev-disabled jcarousel-prev-disabled-horizontal"></div>
                                <div style="display: block;" class="jcarousel-next jcarousel-next-horizontal"></div>
                            </div>
                        </div>
                    </div>
                    <p id='msg'></p>
                    <div class="social_icon1">
                        <div class="social_share"> <a onclick='postToFeed(); return false;' class="fb_icon"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>fb-icon.png" alt="Facebook Share" border="0"/></a>
                         <a href="javascript:void(0);" class="tiwtter" onclick="(function(){var url = 'https://twitter.com/intent/tweet?tw_p=tweetbutton&amp;url='+encodeURI('<?php echo $objCore->getUrl('product.php', array('id' => $objPage->arrproductDetails[0]['pkProductID'], 'name' => $objPage->arrproductDetails[0]['ProductName'], 'refNo' => $objPage->arrproductDetails[0]['ProductRefNo'])) ?>')+'&amp;text=<?php echo SITE_NAME ?>';url=encodeURI(url);window.open(url, 'Tweet', 'height=500,width=700');})()" ><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>tiwtter.png" alt="Twitter" /></a>
                         <div class="g-plusone" data-size="tall" data-annotation="none" data-href="<?php echo $objCore->getUrl('product.php', array('id' => $objPage->arrproductDetails[0]['pkProductID'], 'name' => $objPage->arrproductDetails[0]['ProductName'], 'refNo' => $objPage->arrproductDetails[0]['ProductRefNo'])) ?>" data-callback="plusOneClick" ><meta property="og:url" content="<?php echo $objCore->getImageUrl($varThumbImages['ImageName'], 'products/' . $arrProductImageResizes['default']); ?>"/></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="colormy_righttd">
                <div class="products_detail attribute_quick_view">
                    <div class="top_casual">

                        <div class="quick_title">
                            <h1><a href="<?php echo $objCore->getUrl('product.php', array('id' => $valTop['pkProductID'], 'name' => $valTop['ProductName'], 'refNo' => $valTop['ProductRefNo'])); ?>" class="product_name"><?php echo ucfirst($valTop['ProductName']); ?></a></h1>
                        </div>
                        <div class="quick_left">
                            <?php $feedbacks = $objComman->getProductFeedbacks($valTop['pkProductID']); ?>
                            <div class="red"><?php echo $objComman->getRatting($valTop['Rating']); ?>
                                <div class="red" style="color: #8c8c8c;margin-top: -17px;margin-left: 112px;
                                     float: left;"><?php echo floatval(number_format($valTop['Rating'], 1)); //$feedbacks[0]['positive'] + $feedbacks[0]['negative'];                        ?> Rating
                                </div>
                            </div>
                            <?php //$productRate = ($objPage->arrRatingDetails[0]['numRating']) / ($objPage->arrRatingDetails[0]['numCustomer']);    ?>

                            <!--<div class="review"> <span class="cust_review"><?php echo CUS_REVIEW; ?></span> (<strong class="ornage_text"><?php echo $valTop['customerReviews']; ?></strong>)</div>-->
                            <div class="review"> <span class="cust_review"><?php echo CUS_REVIEW; ?></span> (<a  <?php
                            if ($valTop['customerReviews'] > 0)
                            {
                                ?>
                                        href="#show_review" title="Click here to see reviews and rating"  onclick="return product_reviews()"
                                        <?php
                                    }
                                    else
                                    {
                                        echo "style='cursor:default;'";
                                    }
                                    ?> class="ornage_text reviews" ><?php echo $valTop['customerReviews']; ?></a>)
                            </div>
                        </div>
                        <div class="quick_right"><p>
                                <!--<a class="review_txt" href="<?php echo $objCore->getUrl('product.php', array('id' => $valTop['pkProductID'], 'name' => $valTop['ProductName'], 'refNo' => $valTop['ProductRefNo'])); ?>#reviewSec"><?php echo WRITE_REVIEW; ?></a>-->
<!--                                <a href="#recommend_details" class="active recommend" onclick="return jscall_recommend(<?php echo $valTop['pkProductID']; ?>)" ><?php echo RECOMMEN; ?></a>-->
                            </p>
                        </div>
                        <p class="detail_txt"><?php echo $valTop['ProductDescription']; ?></p>
                        <div style='display:none'>
                            <div id="recommend_details" class="reply_message">
                                <form name="frmRecommendform" id="frmRecommendform" method="POST" action="" onsubmit="return validateRecommend()">
                                    <small class="req_field">* Fields are required</small>  <div class="left_m">
                                        <label><span class="red">*</span><?php echo Y_NAME; ?></label>:</div>
                                    <div class="right_m">
                                        <input type="text" name="frmName" value="<?php echo ucfirst($objPage->arrCustomerDetails[0]['CustomerFirstName']) . " " . $objPage->arrCustomerDetails[0]['CustomerLastName']; ?>" class="validate[required]" />
                                    </div>
                                    <div class="left_m">
                                        <label><span class="red">*</span><?php echo Y_EMAIL; ?> </label>:</div>
                                    <div class="right_m">
                                        <input type="text" name="frmEmail" value="<?php echo $objPage->arrCustomerDetails[0]['CustomerEmail']; ?>" class="validate[required,custom[email]]" />
                                    </div>
                                    <div class="left_m">
                                        <label><span class="red">*</span><?php echo FR_EMAIL; ?> </label>:</div>
                                    <div class="right_m">
                                        <textarea id="frmFriendEmail" name="frmFriendEmail" class="validate[required,custom[multiemail]]"></textarea>
                                    </div>
                                    <div class="left_m">&nbsp;</div>
                                    <div class="right_m">
                                        <input type="submit" name="frmHidenSend" class="cart_link"  value="Send" />
                                        <input type="button" name="cancel" value="Cancel" class="watch_link" id="recommend_cancel" style="width:141px;" />
                                    </div>
                                    <input type="hidden" name="proName" id="proName"  value="<?php echo $objPage->arrproductDetails[0]['ProductName']; ?>" />
                                    <input type="hidden" name="proId" id="proId" value="<?php echo $valTop['pkProductID']; ?>" />
                                </form>
                            </div>
                        </div>
                        <div class="outer_blog">
<!--                            <h2> <span class="price_details">
                                              <span><?php echo PRICE; ?>:</span>
                            <?php
                            echo $objCore->getFinalPrice($valTop['FinalPrice'], $valTop['DiscountFinalPrice'], $valTop['FinalSpecialPrice'], 0, 1);

                            $varProductPrice = $objCore->getFinalPrice($valTop['FinalPrice'], $valTop['DiscountFinalPrice'], $valTop['FinalSpecialPrice'], 1, 1);

                            $varProductPrice = $objCore->getPrice($varProductPrice);
                            if ($valTop['DiscountFinalPrice'] > 0)
                            {
                                $getDValue = $valTop['FinalPrice'] - $objCore->getSavePrice($valTop['DiscountFinalPrice'], $valTop['FinalSpecialPrice']);
                                ?>
                                            <div class="save_amt">You Save <cite><?php echo $objCore->getPrice($getDValue); ?></cite></div>
                            <?php } ?>
                                </span> </h2>-->
                            <h2>
                                <?php
                                if ($valTop['offerPrice'] == '')
                                {
                                    ?>
                                    <span class="price_details">
                                      <!--  <span><?php echo PRICE; ?>:</span>-->
                                        <?php
                                        echo $objCore->getFinalPrice($valTop['FinalPrice'], $valTop['DiscountFinalPrice'], $valTop['FinalSpecialPrice'], 0, 1);

                                        $varProductPrice = $objCore->getFinalPrice($valTop['FinalPrice'], $valTop['DiscountFinalPrice'], $valTop['FinalSpecialPrice'], 1, 1);

                                        $varProductPrice = $objCore->getPrice($varProductPrice);
                                        if ($valTop['DiscountFinalPrice'] > 0)
                                        {
                                            $getDValue = $valTop['FinalPrice'] - $objCore->getSavePrice($valTop['DiscountFinalPrice'], $valTop['FinalSpecialPrice']);
                                            ?>

                                            <div class="save_amt">You Save <cite><?php echo $objCore->getPrice($getDValue); ?></cite></div>
                                    <?php } ?>

                                    </span>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <span class="price_details">
                                      <!--  <span><?php echo PRICE; ?>:</span>-->
                                        <?php
                                        echo $objCore->getFinalPrice($valTop['FinalPrice'], $valTop['offerPrice'], $valTop['FinalSpecialPrice'], 0, 1);

                                        $varProductPrice = $objCore->getFinalPrice($valTop['FinalPrice'], $valTop['offerPrice'], $valTop['FinalSpecialPrice'], 1, 1);

                                        $varProductPrice = $objCore->getPrice($varProductPrice);
                                        if ($valTop['offerPrice'] > 0)
                                        {
                                            $getDValue = $valTop['FinalPrice'] - $objCore->getSavePrice($valTop['DiscountFinalPrice'], $valTop['offerPrice']);
                                            ?>

                                            <div class="save_amt">You Save <cite><?php echo $objCore->getPrice($getDValue); ?></cite></div>
    <?php } ?>
                                    </span>
                            <?php } ?>

                            </h2>
                        </div>
                        <ul class="recommmend_blog">
                            <?php
                            if (count($valTop['arrAttributes']) > 0)
                            {
                                ?>
                                <?php
                                $varOptPrice = '';
                                $attributesVariable = '';
                                $functions = '';
                                foreach ($valTop['arrAttributes'] as $valproductAttribute)
                                {
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
                                    ?>
                                    <li type="<?php echo $valproductAttribute['AttributeInputType']; ?>" class="MyAttr" attrId="<?php echo $valproductAttribute['pkAttributeId']; ?>">
                                        <?php
                                        if ($valproductAttribute['AttributeInputType'] == "image" || $valproductAttribute['AttributeLabel'] == 'Color' || $valproductAttribute['AttributeLabel'] == 'color')
                                        {
                                            ?>
                                            <label style="float: left;">Also available in</label>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <label style="float: left;"><?php echo $valproductAttribute['AttributeLabel']; ?></label>
        <?php } ?>
        <?php
        if ($valproductAttribute['AttributeInputType'] == "select")
        {
            ?>
                                            <div class="drop11">
                                                <div class="errorBox" style="display: block;"></div>
                                                <select class="drop_down1 GetAttributeValues changePriceSelect" name="<?php echo $attrName; ?>" id="frmAttribute_<?php echo $valproductAttribute['pkAttributeId']; ?>">
                                                    <option value="">Select</option>
                                                    <?php
                                                    $varCountAtrributeOption = 0;
                                                    $selectVal = count($arrproductDetailsOptionTitle);
                                                    foreach ($arrproductDetailsOptionTitle as $valoptionTitle)
                                                    {
                                                        $varOptPrice .=$arrproductDetailsOptionId[$varCountAtrributeOption] . '=' . $objCore->getPrice($arrproductDetailsOptionPrice[$varCountAtrributeOption]) . ',';
                                                        ?>
                                                        <option value="<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>"<?php
                                        if ($selectVal == 1)
                                        {
                                            echo 'selected';
                                            //  $functions .= "textSelect('" . $arrproductDetailsOptionId[$varCountAtrributeOption] . "', '" . $valproductAttribute['pkAttributeId'] . "','" . $valproductAttribute['AttributeInputType'] . "');";
                                        }
                                        ?>><?php echo $valoptionTitle; ?></option>
                <?php
                $varCountAtrributeOption++;
            }
            ?>
                                                </select>
                                                <script>
                                                    $(document).ready(function(){
            <?php
            $varCountAtrributeOption = 0;
            $selectVal = count($arrproductDetailsOptionTitle);
            $cl = 1;
            foreach ($arrproductDetailsOptionTitle as $valoptionTitle)
            {
                if ($valproductAttribute['AttributeLabel'] == 'Color-type')
                {
                    ?>
                                    //$('.coloroption').next().find('div:eq(1)').find('li:eq(<?php echo $cl; ?>)').find('a').html('&nbsp;');
                                    $('.coloroption').next().find('div:eq(1)').find('li:eq(<?php echo $cl; ?>)').find('a').css('background','<?php echo $valoptionTitle; ?>');
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
                                        if ($valproductAttribute['AttributeInputType'] == "radio")
                                        {
                                            ?>
                                            <div class="size check_box <?php echo ($valproductAttribute['AttributeLabel'] == 'Color' || $valproductAttribute['AttributeLabel'] == 'color') ? 'redio_color' : ''; ?>" id="attrdiv_<?php echo $valproductAttribute['pkAttributeId']; ?>">
                                                <div class="errorBox" style="display: block;"></div>
                                                <?php
                                                $varCountAtrributeOption = 0;
                                                $radioVal = count($arrproductDetailsOptionTitle);
                                                sort($arrproductDetailsOptionTitle);
                                                foreach ($arrproductDetailsOptionTitle as $valoptionTitle)
                                                {
                                                    $varOptPrice .=$arrproductDetailsOptionId[$varCountAtrributeOption] . '=' . $objCore->getPrice($arrproductDetailsOptionPrice[$varCountAtrributeOption]) . ',';
                                                    ?>
                                                    <input type="radio" value="<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>" name="frmAttribute_<?php echo $valproductAttribute['pkAttributeId']; ?>" class="GetAttributeValues" <?php
                                    if ($radioVal == 1)
                                    {
                                        echo 'checked';
                                        $functions .= "textSelect('" . $arrproductDetailsOptionId[$varCountAtrributeOption] . "', '" . $valproductAttribute['pkAttributeId'] . "','" . $valproductAttribute['AttributeInputType'] . "');";
                                    }
                                                    ?> tabindex="24" style="display:none" />
                                                    <a href="javascript:void(0)" title="<?php echo $valoptionTitle; ?>" class="" id="frmAttribute_<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>" onclick="textSelect('<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>', '<?php echo $valproductAttribute['pkAttributeId']; ?>','<?php echo $valproductAttribute['AttributeInputType']; ?>')" <?php echo ($valproductAttribute['AttributeLabel'] == 'Color' || $valproductAttribute['AttributeLabel'] == 'color') ? 'style="background:' . $valoptionTitle . '"' : '' ?>><?php echo ($valproductAttribute['AttributeLabel'] == 'Color' || $valproductAttribute['AttributeLabel'] == 'color') ? '' : $valoptionTitle ?><span class="rollover_2 " id="check_<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>"></span></a>
                                                <?php
                                                $varCountAtrributeOption++;
                                            }
                                            ?>
                                            </div>
                                            <?php
                                        }
                                        //For checkbox type
                                        if ($valproductAttribute['AttributeInputType'] == "checkbox")
                                        {
                                            ?>
                                            <div class="check_box branding">
                                                <div class="errorBox" style="display: block;"></div>
                                                <?php
                                                $varCountAtrributeOption = 0;
                                                $checkboxVal = count($arrproductDetailsOptionTitle);
                                                sort($arrproductDetailsOptionTitle);
                                                foreach ($arrproductDetailsOptionTitle as $valoptionTitle)
                                                {
                                                    $varOptPrice .=$arrproductDetailsOptionId[$varCountAtrributeOption] . '=' . $objCore->getPrice($arrproductDetailsOptionPrice[$varCountAtrributeOption]) . ',';
                                                    ?>
                                                    <input type="checkbox"  name="frmAttribute_<?php echo $valproductAttribute['pkAttributeId']; ?>" value="<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>" class="GetAttributeValues changePriceCheckBox" <?php
                                    if ($checkboxVal == 1)
                                    {
                                        echo 'checked';
                                        $functions .= "textSelect('" . $arrproductDetailsOptionId[$varCountAtrributeOption] . "', '" . $valproductAttribute['pkAttributeId'] . "','" . $valproductAttribute['AttributeInputType'] . "');";
                                    }
                                                    ?>  />
                                                    <span style="padding-left: 5px;padding-right: 5px;" class="name_brand"><?php echo $valoptionTitle; ?></span>
                                                <?php
                                                $varCountAtrributeOption++;
                                            }
                                            ?>
                                            </div>
                                            <?php
                                        }
                                        //for textbox type
                                        if ($valproductAttribute['AttributeInputType'] == "text")
                                        {
                                            ?>
                                            <div class="errorBox" style="display: block;"></div>
                                            <input type="text" name="<?php echo $attrName; ?>" value="<?php echo $valproductAttribute['AttributeOptionValue']; ?>" class="GetAttributeValues" />
                                            <?php
                                        }
                                        //for textarea type
                                        if ($valproductAttribute['AttributeInputType'] == "textarea")
                                        {
                                            ?>
                                            <div class="errorBox" style="display: block;"></div>
                                            <textarea  name="<?php echo $attrName; ?>" class="GetAttributeValues"></textarea>
                                            <?php
                                        }
                                        //for Date type
                                        if ($valproductAttribute['AttributeInputType'] == "date")
                                        {
                                            ?>
                                            <div class="errorBox" style="display: block;"></div>
                                            <input type="text" name="<?php echo $attrName; ?>" value="<?php echo $valproductAttribute['AttributeOptionValue']; ?>" class="GetAttributeValues" />
                                            <?php
                                        }
                                        //For Image type
                                        if ($valproductAttribute['AttributeInputType'] == "image")
                                        {
                                            ?>
                                            <div class="outer_pics check_box imagecheckbox" id="attrdiv_<?php echo $valproductAttribute['pkAttributeId']; ?>">
                                                <div class="errorBox" style="display: block;"></div>
                                                <?php
                                                $varCountAtrributeOption = 0;
                                                $radioVal = count($arrproductDetailsOptionTitle);
                                                foreach ($arrproductDetailsOptionTitle as $keyoptionTitle => $valoptionTitle)
                                                {
                                                    $varOptPrice .=$arrproductDetailsOptionId[$varCountAtrributeOption] . '=' . $objCore->getPrice($arrproductDetailsOptionPrice[$varCountAtrributeOption]) . ',';
                                                    ?>
                                                    <input type="radio" value="<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>" name="frmAttribute_<?php echo $valproductAttribute['pkAttributeId']; ?>" class="GetAttributeValues" <?php
                                    if ($radioVal == 1)
                                    {
                                        echo 'checked';
                                        $functions .= "textSelect('" . $arrproductDetailsOptionId[$varCountAtrributeOption] . "', '" . $valproductAttribute['pkAttributeId'] . "','" . $valproductAttribute['AttributeInputType'] . "');";
                                    }
                                                    ?> tabindex="24" style="display:none" />
						    <?php //print_r($arrproductDetailsColorcode); ?>
                                                    <span class="pics"  id="frmAttribute_<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>">
                                                        <a
							onmouseout="hidetip('<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>')"
							onmouseover="showtip('<?php echo (!empty($arrproductDetailsOptionImage[$varCountAtrributeOption])) ? $arrproductDetailsOptionId[$varCountAtrributeOption] : ''; ?>')"
							id="imageAnchar_<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>"
							href='javascript:void(0);' <?php
                                            $checkFiles = UPLOADED_FILES_SOURCE_PATH . 'images/products/35x35/' . $arrproductDetailsOptionImage[$varCountAtrributeOption];
                                            //if ($arrproductDetailsIsImgUploaded[$keyoptionTitle] == 1){
                                                ?>
						<?php if(!empty($arrproductDetailsOptionImage[$varCountAtrributeOption])) {?>rel="{gallery: 'gal<?php echo $valTop['pkProductID']; ?>', smallimage: '<?php echo $objCore->getImageUrl($arrproductDetailsOptionImage[$varCountAtrributeOption], 'products/' . $arrProductImageResizes['global']); ?>',largeimage: '<?php echo $objCore->getImageUrl($arrproductDetailsOptionImage[$varCountAtrributeOption], 'products/' . $arrProductImageResizes['detailHover']); ?>'}" <?php } ?>
						style="<?php if (file_exists($checkFiles)){ ?>padding:3px<?php } ?>;background:<?php echo $arrproductDetailsColorcode[$keyoptionTitle] != '' ? $arrproductDetailsColorcode[$keyoptionTitle] : $valoptionTitle ?>"
						onclick="textSelect('<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>','<?php echo $valproductAttribute['pkAttributeId']; ?>','<?php echo $valproductAttribute['AttributeInputType']; ?>')">
                                                            <p> <?php if ($arrproductDetailsOptionImage[$varCountAtrributeOption] != '' && file_exists($checkFiles))
                                            { ?>
                                                                    <img src="<?php echo $objCore->getImageUrl($arrproductDetailsOptionImage[$varCountAtrributeOption], 'products/' . $arrProductImageResizes['color']); ?>">
                <?php } ?>
                                                            </p>
                                                        </a>
                                                        <small class="rollover_1" id="check_<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>"></small>
                                                        <div class="pro_info_tooltip" id="pro_info_tooltip_<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>">
                                                            <i class="pro_info_tooltip_arrow"></i>
                                                            <img style="width: 35px;height: 35px;"  src="<?php echo (!empty($arrproductDetailsOptionImage[$varCountAtrributeOption])) ? $objCore->getImageUrl($arrproductDetailsOptionImage[$varCountAtrributeOption], 'products/' . $arrProductImageResizes['default']) : ''; ?>" alt="" />
                                                                <!--<div id="demo2_<?php // echo $arrproductDetailsOptionId[$varCountAtrributeOption];                                      ?>">
                                                                       <img src="<?php // echo $objCore->getImageUrl($arrproductDetailsOptionImage[$varCountAtrributeOption], 'products/' . $arrProductImageResizes['landing3']);                                      ?>" alt="" />
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
if ($valTop['Quantity'] > 0)
{
    ?>
                                    <label><?php echo QTY; ?></label>
                                    <div class="quantity">
                                        <div class="input_S">
                                            <div class="errorQuantity"></div>
                                        </div>
                                        <input type="text" name="frmQuantity" id="frmQty" value="1" maxlength="3" readonly="" />
                                        <input type='button' name='add' onclick="quantityPlusMinus(1,'qv')" value='+' class="plus" />
                                        <input type='button' name='subtract' onclick="quantityPlusMinus(0,'qv')" value='-' class="minus" />
                                        <span></span> </div>
                                    <p style="margin-left:80px;"> <span style="font-size:14px; color:#4b4c4e">Stock :</span> <span style=" background:<?php echo $valTop['Quantity'] == 0 ? '#c3c3c3' : '#FFFFFF'; ?>; border:1px solid #d2d2d2; padding:8px 40px 7px 10px; margin-left:10px;"> <?php echo '<span id="stock">' . $valTop['Quantity'] . '</span> ' . IN_STOCK; ?>&nbsp;&nbsp;</span> </p>

                                    <div style="clear:both; margin-top:40px;">
                                        <div style="width:100%; clear:both">
                                            <p class="" id="add_cart_link" style="padding-top:10px; background:none;">
                                                <?php
                                                if ($_SESSION['sessUserInfo']['type'] == 'customer')
                                                {
                                                    ?>
                                                    <a class="watch_link1" href="javascript:void('0');" onclick="addToWishlist(<?php echo $valTop['pkProductID']; ?>)"><?php echo ADD_WISH; ?></a>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <a class="watch_link1" href="javascript:void('0');" onclick="addToWishlistLogin('<?php echo $valTop['pkProductID']; ?>')"><?php echo ADD_WISH; ?></a>
    <?php } ?>
                                                <a cmCid="<?php echo $valTop['fkCategoryID']; ?>" cmPid="<?php echo $valTop['pkProductID']; ?>" id="CompareCheckBox<?php echo $valTop['pkProductID']; ?>" class="compare_quick" onclick="addToCompare(<?php echo $valTop['pkProductID']; ?>,<?php echo $valTop['fkCategoryID']; ?>,'<?php echo $objCore->getUrl('product_comparison.php'); ?>','quickView');" href="javascript:void('0');">Compare</a>
                                            </p>  <a href="javascript:void(0);" class="cart_link1" tp="<?php echo $_SESSION['sessUserInfo']['type']; ?>" pv="<?php echo $valTop['pkProductID']; ?>" pmv="<?php echo $valTop['Quantity']; ?>"><?php echo ADD_TO_CART; ?></a>  <div class="blue"><span><?php echo $objCore->getPoints($valTop['DiscountFinalPrice'] != 0 ? $valTop['DiscountFinalPrice'] : $valTop['FinalPrice']); ?> Points</span> to be earned on each item.</div>
                                        </div>

                                    </div>


    <?php
}
else
{
    ?>
                                    <label>&nbsp;</label>
                                    <div class="input_S">
                                        <div class="errorQuantity"></div>
                                        <input type="hidden" value="0" name="frmQuantity" id="frmQuantity" maxlength="3" disabled />
                                    </div>

                                    <div style="clear:both; margin-top:40px;">
                                        <div style="width:100%; clear:both"> <p class="" style="padding-top:10px;background:none;">
                                                <?php
                                                if ($_SESSION['sessUserInfo']['type'] == 'customer')
                                                {
                                                    ?>
                                                    <a class="watch_link1" href="javascript:void('0');" onclick="addToWishlist(<?php echo $valTop['pkProductID']; ?>)">Add to Save List</a>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <a class="watch_link1" href="javascript:void('0');" onclick="addToWishlistLogin('<?php echo $valTop['pkProductID']; ?>')">Add to Save List</a>
    <?php } ?>
                                                <a cmCid="<?php echo $valTop['fkCategoryID']; ?>" cmPid="<?php echo $valTop['pkProductID']; ?>" id="CompareCheckBox<?php echo $valTop['pkProductID']; ?>" class="compare_quick" onclick="addToCompare('<?php echo $valTop['pkProductID']; ?>','<?php echo $valTop['fkCategoryID']; ?>','<?php echo $objCore->getUrl('product_comparison.php'); ?>','quickView');" href="javascript:void('0');">Compare</a> </p><a href="javascript:void(0);" class="out_of_stock_cart_link1"><?php echo OUT_OF_STOCK; ?></a></div>
                                    </div>
<?php } ?>
                                <div style="float: left">
                                    <div class="succCart"></div>

                                    <div id="addtoCompareMessage<?php echo $valTop['pkProductID']; ?>" class="addtoCompareMessage"></div>
                                    <div id="addtoCompareMessage_quick_<?php echo $valTop['pkProductID']; ?>" class="addtoCompareMessage"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="show_review" style="display: none">     
<?php
if (count($varRateReview) > 0)
{
    foreach ($varRateReview as $valReview)
    {
        ?>
                <div class="top_customer">
                    <span class="iocn_2"><img  src="<?php echo IMAGE_FRONT_PATH_URL; ?>customer_icon.png" alt=""/></span>
                    <div class="review_sec1">
                        <h3>
        <?php echo ($valReview['CustomerScreenName'] == '') ? $valReview['CustomerName'] : $valReview['CustomerScreenName']; ?>
                            <span><?php echo $objProduct->_ago($objCore->localDateTime($valReview['ReviewDateUpdated'], DATE_TIME_FORMAT_DB)); ?></span>
                            <div style="float: right">
                        <?php
                        echo $objComman->getRatting($valReview['Rating']);
                        ?>
                            </div>
                        </h3>
                <?php echo ucfirst($valReview['Reviews']);
                ?>
                    </div>
                </div>
        <?php
    }
}
?>
    </div>
    <script>
        $(document).ready(function(){
<?php echo $functions; ?>        
    });
    </script>
</div>
<div class="bottom_line">
    <ul>
        <li>90 Day Money Back </li>
        <li>Free Shipping </li>
        <li>Safe Shopping </li>
    </ul>
</div>
