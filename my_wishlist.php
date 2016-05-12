<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_CUSTOMER_WISHLIST_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo MY_WISH_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <link rel="stylesheet" type="text/css" href="common/css/layout1.css"/>
        <link rel="stylesheet" type="text/css" href="common/css/css3-2.css"/>         
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>product.css"/>
        <script src="<?php echo JS_PATH ?>jquery_cr.js" type="text/javascript"></script>
        <script src="<?php echo JS_PATH ?>jquery.jqzoom-core.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>skin.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>jquery.jqzoom.css"/>
        <script src="<?php echo JS_PATH ?>jQueryRotate.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>home.js"></script>
        <style>.addCart{ margin-right:0px }</style>

        <script type="text/javascript">
            $(document).ready(function(){
                              
                $('.jqzoom').jqzoom({
                    zoomType: 'standard',
                    lens:true,
                    preloadImages: false,
                    alwaysOn:false
                });
                /*$('.product_img .jcarousel-clip ul').each(function(i){
                $(this).jcarousel();
            });*/
            });
            
            function deleteFromWishList(pid,wishId)
            {
                $.post('<?php echo SITE_ROOT_URL; ?>common/ajax/ajax_customer.php',{pid:pid,wishId:wishId, action: "deleteFromWishlist"}, function(data){
                    if(data){
                        $('#wishlist_item'+pid).hide();
                    }
                    location.reload();
                });
            }
            $(window).load(function() {
                function equalHeight(group) {
                    tallest = 0;
                    var e=0;
                    group.each(function() {
                        e++;
                        thisHeight = $(this).height();
                        if(thisHeight > tallest) {
                            // alert(thisHeight);
                            tallest = thisHeight;
                            $('.pr'+e).height(thisHeight);
                            $('.of'+e).height(thisHeight);
                            $('.or'+e).height(thisHeight);
                            $('.ac'+e).height(thisHeight);

                        }else{
                            $('.pr'+e).height(thisHeight);
                            $('.of'+e).height(thisHeight);
                            $('.or'+e).height(thisHeight);
                            $('.ac'+e).height(thisHeight);
                        }
                    });
                    //alert(x);

                    //group.height(tallest);

                }
                equalHeight($(".gre"));
            });
        </script>
        <style>.linking_1{ color:#000 !important}
            .cart2 { color: orange;
                     float: left;
                     line-height: 50px;}
            .quick { color: WHITE;
float: left;
line-height: 34px;
BACKGROUND: ORANGE;
PADDING: 0PX 20px 0px 20px;
margin-top: 10px;
border-radius: 4px;} .quick:hover{ opacity:0.7}
.cart2{color: WHITE;
float: left;
line-height: 34px;
BACKGROUND: ORANGE;
PADDING: 0PX 20px 0px 20px;
margin-top: 10px;
border-radius: 4px;}.cart2:hover{ opacity:0.7}
            .red{ color:red !important}


        </style>
    </head>
    <body>
        <div id="navBar">
            <?php include_once 'common/inc/top-header.inc.php'; ?>
        </div>
        <div class="header" style=" border:none"><div class="layout">

            </div>
        </div><?php include_once INC_PATH . 'header.inc.php'; ?>
        <div id="ouderContainer" class="ouderContainer_1">
            <div class="layout">


                <div class="add_pakage_outer">
                    <div class="top_header border_bottom">
                        <h1>My Saved List</h1>

                    </div>           <div class="body_inner_bg radius">
                        <div class="add_edit_pakage wish_sec">


                            <table border="0" class="manage_table">
                                <tr>
                                    <th><?php echo PROD_IMAGE; ?></th>
                                    <th><?php echo PROD_NAME; ?></th>
                                    <th><?php echo TOTAL_PRICE; ?></th>
                                    <th><?php echo DATE; ?></th>
                                    <th><?php echo ACTION; ?></th>
                                </tr>
                                <?php
                                // pre($objPage->arrWishlistProducts);
                                $varCounter = 0;
                                if (count($objPage->arrWishlistProducts) > 0)
                                {
                                    foreach ($objPage->arrWishlistProducts as $arrDetail)
                                    {
                                        $varCounter++;
                                        ?>                       
                                        <tr class="<?php echo $varCounter % 2 == 0 ? 'even' : 'odd'; ?>" id="wishlist_item<?php echo $arrDetail['pkProductID']; ?>">
                                            <td width="25%">
                                                <a class="" href="<?php echo $objCore->getUrl('product.php', array('id' => $arrDetail['pkProductID'], 'name' => $arrDetail['ProductName'], 'refNo' => $arrDetail['ProductRefNo'])); ?>">
                                                    <img src="<?php echo $objCore->getImageUrl($arrDetail['ProductImage'], 'products/208x185'); ?>" alt="<?php echo $val['ProductName'] ?>"/>
                                                </a>
                                            </td>
                                            <td  width="25%"><a class="linking_1" href="<?php echo $objCore->getUrl('product.php', array('id' => $arrDetail['pkProductID'], 'name' => $arrDetail['ProductName'], 'refNo' => $arrDetail['ProductRefNo'])); ?>"><?php echo $arrDetail['ProductName']; ?> </a></td>
                                            <td><?php
                                if ($arrDetail['OfferPrice'] <> '' && $arrDetail['OfferPrice'] > 0)
                                {
                                    echo $objCore->getPrice($arrDetail['OfferPrice']);
                                }
                                else if ($arrDetail['DiscountFinalPrice'] > 0)
                                {
                                    echo $objCore->getPrice($arrDetail['DiscountFinalPrice']);
                                }
                                else
                                {
                                    echo $objCore->getPrice($arrDetail['FinalPrice']);
                                }
                                if ($arrDetail['Quantity'] == 0)
                                {
                                    $varAnchor = 'class="cart2 red"';
                                    $addToCart = OUT_OF_STOCK;
                                }
                                else
                                {
                                    $addToCart = ADD_TO_CART;
                                    if ($arrDetail['attributes'] > 0)
                                    {
                                        //$varAnchor = 'href="#quickView' . $arrDetail['pkProductID'] . '" onclick="jscallQuickViewWishlist(\'quickView' . $arrDetail['pkProductID'] . '\');" class="qckView quick quickView' . $arrDetail['pkProductID'] . '"';
                                        $varAnchor = 'href="' . $objCore->getUrl('quickview.php', array('pid' => $arrDetail['pkProductID'], 'action' => 'quickView')) . '" onclick="return jscallQuickView(\'QuickView' . $arrDetail['pkProductID'] . '\');" class="quick QuickView' . $arrDetail['pkProductID'] . '"';
                                    }
                                    else
                                    {
                                        //$varAnchor = 'href="#top' . $arrDetail['pkProductID'] . '" class="cart2 addCart" onclick="addToCart(' . $arrDetail['pkProductID'] . ')" ';
                                        $varAnchor = 'href="' . $objCore->getUrl('common/ajax/ajax_cart.php', array('action' => 'addToCart', 'pid' => $arrDetail['pkProductID'], 'qty' => '1')) . '" class="cart2 addCart ' . $arrDetail['pkProductID'] . '" onclick="addToCart(' . $arrDetail['pkProductID'] . ')" ';
                                    }
                                }
                                        ?></td>
                                            <td><?php echo $objCore->localDateTime(date($arrDetail['WishlistDateAdded']), DATE_FORMAT_SITE_FRONT); ?></td>
                                            <td><a <?php echo $varAnchor; ?>><?php echo $addToCart; ?></a>
                                                <a title="click here to delete from save list" class="red_cross2 active" href="javascript:void(0);" onclick="if(confirm('<?php echo R_U_SURE; ?>')){deleteFromWishList('<?php echo $arrDetail['pkProductID']; ?>','<?php echo $arrDetail['pkWishlistId']; ?>')}" style="float: left;"></a>


                                                <!--  POPUP CONTENT Added Start-->
                                                <?php
                                                if ($arrDetail['ProductImage'] <> '')
                                                {
                                                    $varSrc = UPLOADED_FILES_URL . "images/products/160x140/" . $arrDetail['ProductImage'];
                                                }
                                                else
                                                {
                                                    $varSrc = UPLOADED_FILES_URL . "images/products/160x140/no-image.jpeg";
                                                }

                                                $varStr = '<div style="display: none;">
                                                <div id="top' . $arrDetail['pkProductID'] . '">
                                                    <div class="cart_inner">
                                                        <h3>' . PRODUCT_ADD_IN_SHOPING_CART . '.</h3>
                                                        <div class="cart_detail">
                                                            <span class="proimg">
                                                                <img src="' . $varSrc . '" width="110" height="110" class="prodImg"/>
                                                            </span>
                                                            <div class="detail_right">
                                                                <h4>' . $arrDetail['ProductName'] . '</h4>
                                                                <ul style="min-height:70px;">';

                                                if ($arrDetail['OfferPrice'] <> '' && $arrDetail['OfferPrice'] > 0)
                                                {
                                                    $varStr .= '<li><small>' . PRICE . '</small><span style="text-decoration:lign-through;">: ' . $objCore->getPrice($arrDetail['OfferPrice']) . '</span></li>';
                                                }
                                                else
                                                {

                                                    if ($arrDetail['DiscountFinalPrice'] > 0)
                                                    {
                                                        $varStr .= '<li><small>' . PRICE . '</small>:<span style="text-decoration: line-through;"> ' . $objCore->getPrice($arrDetail['FinalPrice']) . '</span></li>
                                                                    <li><small>&nbsp;</small><span>&nbsp; ' . $objCore->getPrice($arrDetail['DiscountFinalPrice']) . '</span></li>';
                                                    }
                                                    else
                                                    {
                                                        $varStr .= '<li><small>' . PRICE . '</small><span style="text-decoration:lign-through;">: ' . $objCore->getPrice($arrDetail['FinalPrice']) . '</span></li>';
                                                    }
                                                }
                                                $varStr .= '</ul>
                                                        <div class="cart_button">
                                                                    <input class="submit button" type="submit" name="Shopping" value="' . SHOPPING_CART . '" onclick="window.location=' . "'" . $objCore->getUrl('shopping_cart.php') . "'" . '" />
                                                                        <input class="submit button close" type="button" name="Continue Shoping" value="' . CON_SHOPING . '" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                            </div>';
                                                echo $varStr;
                                                ?>
                                                <!--  POPUP CONTENT Added End-->


                                                <!--POPUP CONTENT Start-->
                                                <div style='display:none'>
                                                    <div id="quickView<?php echo $arrDetail['pkProductID']; ?>" class="quick_color" style="padding:5px;">
                                                        <table id="colorBox_table" border="0">
                                                            <tr>
                                                                <td rowspan="2" style="width:150px;">
                                                                    <div class="clearfix product_img" id="content" >
                                                                        <div class="clearfix imgs">
                                                                            <?php
                                                                            $varImageCount = count($arrDetail['arrproductImages']);
                                                                            if ($varImageCount > 0)
                                                                            {
                                                                                ?>
                                                                                <a href="<?php echo UPLOADED_FILES_URL; ?>images/products/<?php echo $arrDetail['arrproductImages'][0]['ImageName']; ?>" class="jqzoom" rel='<?php echo "gal" . $arrDetail['pkProductID']; ?>'  >
                                                                                    <img src="<?php echo UPLOADED_FILES_URL; ?>images/products/<?php echo PRODUCT_IMAGE_RESIZE4; ?>/<?php echo $arrDetail['arrproductImages'][0]['ImageName']; ?>"  title="<?php echo INDEX_TRIUMPH; ?>"  style="border: 2px solid #666;" />
                                                                                </a>
                                                                                <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <a href="<?php echo UPLOADED_FILES_URL; ?>images/products/no-image.jpeg" class="jqzoom" rel='<?php echo "gal" . $arrDetail['pkProductID']; ?>'>
                                                                                    <img src="<?php echo UPLOADED_FILES_URL; ?>images/products/<?php echo PRODUCT_IMAGE_RESIZE4; ?>/no-image.jpeg"  title="<?php echo INDEX_TRIUMPH; ?>"  style="border: 2px solid #666;" />
                                                                                </a>
                                                                            <?php } ?>
                                                                            <?php
                                                                            $days = $objComman->dateDiffInDays($arrDetail['ProductDateAdded'], date('Y-m-d H:i:s'));
                                                                            if ($days <= NEW_PRODUCT_BASED_ON_DAYS)
                                                                            {
                                                                                ?>
                                                                                <div class="new"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>new_product.png" alt=""/></div>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <div class="clearfix">
                                                                            <div style="float: left; margin-top: 14px;margin-left: 30px;" class="jcarousel-skin-tango">
                                                                                <div style="position: relative; display: block;" class="jcarousel-container jcarousel-container-horizontal">
                                                                                    <div style="position: relative;" class="jcarousel-clip jcarousel-clip-horizontal">

                                                                                        <ul  class="clearfix small_imgs" id="<?php echo "thumblist" . $arrDetail['pkProductID']; ?>" class="thumblist">
                                                                                            <?php
                                                                                            if ($varImageCount > 0)
                                                                                            {
                                                                                                $varImageStart = 0;
                                                                                                foreach ($arrDetail['arrproductImages'] as $varThumbImages)
                                                                                                {
                                                                                                    ?>
                                                                                                    <li><a <?php
                                                                                    if ($varImageStart == 0)
                                                                                    {
                                                                                                        ?>class="zoomThumbActive" <?php } ?> href='javascript:void(0);' rel="{gallery: '<?php echo "gal" . $arrDetail['pkProductID']; ?>', smallimage: '<?php echo UPLOADED_FILES_URL; ?>images/products/<?php echo PRODUCT_IMAGE_RESIZE4; ?>/<?php echo $varThumbImages['ImageName']; ?>',largeimage: '<?php echo UPLOADED_FILES_URL; ?>images/products/<?php echo $varThumbImages['ImageName']; ?>'}"><img src='<?php echo UPLOADED_FILES_URL; ?>images/products/70x70/<?php echo $varThumbImages['ImageName']; ?>' width="73" height="73" /></a></li>
                                                                                                            <?php
                                                                                                            $varImageStart++;
                                                                                                        }
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        ?>
                                                                                                <li><a <?php
                                                                                            if ($varImageStart == 0)
                                                                                            {
                                                                                                            ?>class="zoomThumbActive" <?php } ?> href='javascript:void(0);' rel="{gallery: '<?php echo "gal" . $arrDetail['pkProductID']; ?>', smallimage: '<?php echo UPLOADED_FILES_URL; ?>images/products/<?php echo PRODUCT_IMAGE_RESIZE4; ?>/no-image.jpeg',largeimage: '<?php echo UPLOADED_FILES_URL; ?>images/products/no-image.jpeg'}"><img src='<?php echo UPLOADED_FILES_URL; ?>images/products/70x70/no-image.jpeg'></a></li>

                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </ul></div>
                                                                                    <div disabled="disabled" style="display: block;" class="jcarousel-prev jcarousel-prev-horizontal jcarousel-prev-disabled jcarousel-prev-disabled-horizontal"></div>
                                                                                    <div style="display: block;" class="jcarousel-next jcarousel-next-horizontal"></div>
                                                                                </div></div>
                                                                        </div>
                                                                        <p id='msg'></p>
                                                                    </div>
                                                                </td>

                                                                <td colspan="2" valign="top">

                                                                    <div class="products_detail">
                                                                        <div class="outer_rating">
                                                                            <ul class="views_sec">
                                                                                <li><a href="javascript:void(0)"><span><?php echo $arrDetail['customerReviews']; ?></span> <?php echo CUS_REVIEW; ?></a></li>
                                                                                <li><a href="javascript:void(0)">|</a></li>
                                                                                <li class="active">
                                                                                    <a href="<?php echo $objCore->getUrl('product.php', array('id' => $arrDetail['pkProductID'], 'name' => $arrDetail['ProductName'], 'refNo' => $arrDetail['ProductRefNo'])); ?>#reviewSec"><?php echo WRITE_REVIEW; ?></a>
                                                                                </li>
                                                                            </ul>

                                                                            <div class="rating" style="margin:0 0 0 0 !important">
                                                                                <?php
                                                                                $productRate = ($objPage->arrRatingDetails[0]['numRating']) / ($objPage->arrRatingDetails[0]['numCustomer']);
                                                                                ?>
                                                                                <?php echo $objComman->getRatting($arrDetail['Rating']); ?>
                                                                            </div>
                                                                        </div>

                                                                        <div class="product_wholseler">
                                                                            <h1><a href="<?php echo $objCore->getUrl('product.php', array('id' => $arrDetail['pkProductID'], 'name' => $arrDetail['ProductName'], 'refNo' => $arrDetail['ProductRefNo'])); ?>" class="product_name"><?php echo ucfirst($arrDetail['ProductName']); ?></a></h1>
                                                                            <p>
                                                                                <?php echo BY; ?>: <strong><a href="<?php echo $objCore->getUrl('wholesaler_profile_customer_view.php', array('wid' => $arrDetail['fkWholesalerID'])); ?>"><?php echo ucfirst($arrDetail['CompanyName']); ?></a></strong>
                                                                            </p>
                                                                            <span class="price_details">
                                                                                <?php
                                                                                if ($arrDetail['DiscountFinalPrice'] != 0)
                                                                                {
                                                                                    ?>
                                                                                    <small><?php echo $objCore->getPrice($arrDetail['FinalPrice']); ?></small><strong><?php echo $objCore->getPrice($arrDetail['DiscountFinalPrice']); ?></strong>
                                                                                    <?php
                                                                                }
                                                                                else
                                                                                {
                                                                                    ?>
                                                                                    <strong><?php echo $objCore->getPrice($arrDetail['FinalPrice']); ?></strong>
                                                                                <?php }
                                                                                ?>
                                                                            </span>
                                                                            <p align="justify"><?php echo $arrDetail['ProductDescription']; ?></p>
                                                                        </div>
                                                                    </div>
                                                                    <div style="border:0px solid #006FEB; float: left">

                                                                        <?php
                                                                        // print_r($arrDetail['arrAttributes']);

                                                                        if (count($arrDetail['arrAttributes']) > 0)
                                                                        {
                                                                            ?>
                                                                            <ul class="select_color_sec">
                                                                                <?php
                                                                                foreach ($arrDetail['arrAttributes'] as $valproductAttribute)
                                                                                {
                                                                                    //echo '<pre>',print_r($valproductAttribute),'</pre>';

                                                                                    $arrproductDetailsOptionTitle = explode(",", $valproductAttribute['OptionTitle']);
                                                                                    $arrproductDetailsOptionId = explode(",", $valproductAttribute['pkOptionID']);
                                                                                    $attrName = 'frmAttribute_top_' . $arrDetail['pkProductID'] . $valproductAttribute['pkAttributeId'];
                                                                                    ?>
                                                                                    <li type="<?php echo $valproductAttribute['AttributeInputType']; ?>" class="MyAttr" attrId="<?php echo $valproductAttribute['pkAttributeId']; ?>">
                                                                                        <strong style="float: left"><?php echo $valproductAttribute['AttributeLabel']; ?></strong>
                                                                                        <?php
                                                                                        if ($valproductAttribute['AttributeInputType'] == "select")
                                                                                        {
                                                                                            ?>
                                                                                            <div class="drop11">
                                                                                                <div class="errorBox" style="display: block;"></div>
                                                                                                <select class="drop_down1 GetAttributeValues" name="<?php echo $attrName; ?>">
                                                                                                    <option value="">Select</option>
                                                                                                    <?php
                                                                                                    $varCountAtrributeOption = 0;
                                                                                                    $selectVal = count($arrproductDetailsOptionTitle);
                                                                                                    foreach ($arrproductDetailsOptionTitle as $valoptionTitle)
                                                                                                    {
                                                                                                        ?>
                                                                                                        <option value="<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>" <?php
                                                                                if ($selectVal == 1)
                                                                                {
                                                                                    echo 'selected';
                                                                                }
                                                                                                        ?>><?php echo $valoptionTitle; ?></option>
                                                                                                                <?php
                                                                                                                $varCountAtrributeOption++;
                                                                                                            }
                                                                                                            ?>
                                                                                                </select>
                                                                                            </div>

                                                                                            <?php
                                                                                        }

                                                                                        // for radio button  type
                                                                                        if ($valproductAttribute['AttributeInputType'] == "radio")
                                                                                        {
                                                                                            ?>
                                                                                            <div class="check_box">
                                                                                                <div class="errorBox" style="display: block;"></div>
                                                                                                <?php
                                                                                                $varCountAtrributeOption = 0;
                                                                                                $radioVal = count($arrproductDetailsOptionTitle);
                                                                                                foreach ($arrproductDetailsOptionTitle as $valoptionTitle)
                                                                                                {
                                                                                                    ?>
                                                                                                    <input type="radio" name="<?php echo $attrName; ?>" value="<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>" class="GetAttributeValues" <?php
                                                                            if ($radioVal == 1)
                                                                            {
                                                                                echo 'checked';
                                                                            }
                                                                                                    ?> tabindex="24"/>&nbsp; <span style="float: left; padding-left: 5px;padding-right: 5px;"><?php echo $valoptionTitle; ?></span>

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
                                                                                            <div class="check_box">
                                                                                                <div class="errorBox" style="display: block;"></div>
                                                                                                <?php
                                                                                                $varCountAtrributeOption = 0;
                                                                                                $checkboxVal = count($arrproductDetailsOptionTitle);
                                                                                                foreach ($arrproductDetailsOptionTitle as $valoptionTitle)
                                                                                                {
                                                                                                    ?>
                                                                                                    <input type="checkbox"  name="<?php echo $attrName; ?>" value="<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>" class="GetAttributeValues" <?php
                                                                            if ($checkboxVal == 1)
                                                                            {
                                                                                echo 'checked';
                                                                            }
                                                                                                    ?>  /> <span style="padding-left: 5px;padding-right: 5px;"><?php echo $valoptionTitle; ?></span>
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

                                                                                        <?php }
                                                                                        ?> </li><?php
                                                                    }
                                                                                    ?>

                                                                            </ul>
                                                                        <?php } ?>

                                                                        <div class="qty_sec">
                                                                            <div class="succCart"><?php echo PRODUCT_ADD_IN_SHOPING_CART; ?>.</div>
                                                                            <strong><?php echo QTY; ?>.</strong>
                                                                            <div class="input_S">
                                                                                <div class="errorQuantity"></div>
                                                                                <input type="text" value="1" name="frmQuantity" class="frmQuantity" maxlength="3"/>
                                                                            </div>
                                                                            <span><?php echo IN_STOCK; ?></span>
                                                                            <small></small>
                                                                            <a href="javascript:void(0);" class="add_cart_link" pv="<?php echo $arrDetail['pkProductID']; ?>"><?php echo ADD_TO_CART; ?></a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!--POPUP CONTENT END-->
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                else
                                {
                                    echo ' <tr class="odd"><td colspan="5">' . FRONT_CUSTOMER_WISHLIST_ERROR_MSG1 . '</td></tr>';
                                }
                                ?>


                            </table> 
                            <?php
                            if (count($objPage->arrWishlistProducts) > 0)
                            {
                                ?>
                                <table width="100%">
                                    <tr><td colspan="10">&nbsp;</td></tr>
                                    <tr>
                                        <td colspan="10">
                                            <table width="100%" border="0" align="center">
                                                <tr>
                                                    <td style="font-weight:bolder; text-align:right;" colspan="10" align="right">
                                                        <?php
                                                        if ($objPage->varNumberPages > 1)
                                                        {
                                                            $objPage->displayFrontPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>

                                            </table>
                                        </td>
                                    </tr></table>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>

    </body>
</html>
