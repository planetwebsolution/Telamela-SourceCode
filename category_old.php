<?php
require_once 'solarium.php';
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;
require_once CONTROLLERS_PATH . FILENAME_CATEGORY_CTRL;
//print_r($_SESSION['MyCart']);
//pre($objPage->arrProductDetails);
//pre($_REQUEST);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo CATEGORY_TITLE; ?> <?php echo $objPage->arrCategoryDetails[0]['CategoryMetaTitle']; ?></title>
        <meta name="description" content="<?php echo $objPage->arrCategoryDetails[0]['CategoryMetaKeywords']; ?>"/>
        <meta name="keywords" content="<?php echo $objPage->arrCategoryDetails[0]['CategoryMetaDescription']; ?>"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>mialn.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>style_responsive.css"/>
        <!--
       this js conficting with color box for login and signup
       <script type="text/javascript" src="<?php echo JS_PATH ?>jquery-1.9.0.min.js"></script>
        -->
        <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.mousewheel.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>stylish-select.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>bxsliderjs.js"></script>        
        <script type="text/javascript" src="<?php echo JS_PATH ?>jQueryRotate.js"></script>                
        <!--<script type="text/javascript" src="<?php echo JS_PATH ?>script.js"></script>-->
        <script type="text/javascript" src="<?php echo JS_PATH ?>checkboxradiojs.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo CSS_PATH ?>product.css"/>        
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>category.css"/>
        <script>var pageLimit = <?php echo $objPage->lagyPageLimit;?>;</script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>category.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>scriptbreaker-multiple-accordion-1.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.bxslider.js"></script>
        <script src="<?php echo JS_PATH ?>jquery_cr.js" type="text/javascript"></script>
        <script src="<?php echo JS_PATH ?>jquery.jqzoom-core.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>skin.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>jquery.jqzoom.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH ?>home.js"></script>       
    </head>
    <body>
        <div id="navBar">
            <?php include_once INC_PATH . 'top-header.inc.php'; ?>
        </div>
        <div class="layout">
            <div class="header">
                <?php include_once INC_PATH . 'header.inc.php'; ?>
                <!--div class="addToCart">
                   <div class="addToCartClose" onclick="addToCartClose();">&nbsp;&nbsp;&nbsp;&nbsp;</div>
                   <div class="addToCartMsg"></div>
               </div-->
            </div>
        </div>
        <div class="layout">
            <div class="parent_child_sec">
                <ul class="parent_top" id="parent_top">
                    <?php
                    if (isset($_REQUEST['searchKey']) && $_REQUEST['searchKey'] <> '' && $_REQUEST['searchKey'] <> SEARCH_FOR_BRAND) {
                        echo '<li class="first"><strong>' . $_REQUEST['searchKey'] . '</strong></li>';
                    } else if (isset($_REQUEST['cid'])) {
                        echo $objPage->varBreadcrumbs;
                    } else if (isset($_REQUEST['wid'])) {
                        echo '<li class="first"><strong>' . $objPage->arrWholeSalerDetails[0]['CompanyName'] . '</strong></li>';
                    } else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'new') {
                        echo '<li class="first"><strong>What\'s New</strong></li>';
                    }
                    ?>                    
                </ul>
                <?php if (count($objPage->arrProductDetails) > 0) { ?>
                    <div>
                        <input type="hidden" name="page" value="<?php echo ($_REQUEST['page'] > 0 ? $_REQUEST['page'] : 0); ?>" id="page" />
                        <input type="hidden" name="typ" id="typ" value="<?php echo ($_REQUEST['type'] != '' ? $_REQUEST['type'] : ''); ?>" />
                        <!--
                        <input type="hidden" name="frmPriceTo" id="frmPriceTo" value="<?php echo ($_REQUEST['frmPriceTo'] != '' ? $_REQUEST['frmPriceTo'] : ''); ?>" />
                        <input type="hidden" name="frmPriceFrom" id="frmPriceFrom" value="<?php echo ($_REQUEST['frmPriceFrom'] != '' ? $_REQUEST['frmPriceFrom'] : ''); ?>" />
                        -->
                        <div class="parent_child_left" id="leftPanelId">
                            <?php
                            if (count($objPage->CategoryChildList) > 0) {
                                ?>
                                <div class="category_list">
                                    <div class="btmbrd">                                    
                                        <h3><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>arrdown.png" /><?php echo CATEGORY_TITLE; ?></h3>
                                    </div>
                                    <div class="toggle">
                                        <div class="scroll-pane category_left">
                                            <ul class="parent_check">
                                                <?php
                                                foreach ($objPage->CategoryChildList as $CategoryChildList) {
                                                    echo '<li><a class="ajax_category" href="' . $CategoryChildList['pkCategoryID'] . '"><label>' . $CategoryChildList['CategoryName'] . ' (' . $CategoryChildList['ProductNum'] . ')</label></a></li>';
                                                }
                                                ?>                                
                                            </ul>                            
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <input  type="hidden" name="chooseCategory" value="<?php echo $_REQUEST['cid']; ?>" id="chooseCategoryId" class="chooseCategory"/>
                            <?php
                            if ($objPage->CategoryLevel < 2) {
                                $dispay = 'style="display:none"';
                            }
                            ?>
                            <div id="exCategory">
                                <?php
                                $varWhlNum = count($objPage->arrWholeSalerList);
                                if ($varWhlNum > 0) {
                                    ?>
                                    <div class="category_list">
                                        <div class="btmbrd">                                    
                                            <h3><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>arrdown.png" /><?php echo WHOLESALER; ?></h3>
                                        </div>                                        
                                        <div class="toggle">
                                            <div class="parent_search_outer">
                                                <div class="parent_search">
                                                    <input type="text" value="<?php echo SEARCH_BY . WHOLESALER ?>" onblur="if(this.value==''){this.value = '<?php echo SEARCH_BY . WHOLESALER ?>';}" onfocus="if(this.value=='<?php echo SEARCH_BY . WHOLESALER ?>'){this.value = '';}" onclick="if(this.value=='<?php echo SEARCH_BY . WHOLESALER ?>'){this.value = '';}" />
                                                    <!--<input type="button" value="Go"/>-->
                                                </div>
                                            </div>

                                            <div class="scroll-pane category_left">
                                                <ul class="parent_check">
                                                    <?php
                                                    $cnt = 0;
                                                    foreach ($objPage->arrWholeSalerList as $wholeSalerList) {
                                                        ?>
                                                        <li>
                                                            <input type="checkbox" class="whl stsyled" id="frmCategoryWholeSalerId<?php echo $cnt + 1; ?>" name="frmCategoryWholeSaler[]" value="<?php echo ucfirst($wholeSalerList['pkWholesalerID']); ?>" />
                                                            <label><?php echo ucfirst($wholeSalerList['CompanyName']); ?> (<?php echo $wholeSalerList['ProductNum']; ?>)</label>
                                                        </li>
                                                        <?php
                                                        $cnt++;
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>    
                                <?php } ?>
                                <div>
                                    <div>
                                        <div>
                                            <ul>
                                                <?php if (count($objPage->arrProductDetails) > 0) { ?>
                                                    <?php
                                                    $attributesVariable = $old_pkAttributeId = '';
                                                    foreach ($objPage->arrData['arrAttributeDetail'] as $valAttributeDetail) {
                                                        if ($valAttributeDetail['pkAttributeId'] != $old_pkAttributeId) {
                                                            if ($attributesVariable != '')
                                                                $attributesVariable .= ";";
                                                            $attributesVariable .= $valAttributeDetail['pkAttributeId'] . ":checkbox";
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="category_list" <?php echo $dispay; ?>>
                                                <div class="btmbrd">                                    
                                                    <h3><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>arrdown.png" /><?php echo ucfirst($valAttributeDetail['AttributeLabel']); ?></h3>
                                                </div>
                                                <div class="toggle">
                                                    <div class="parent_search_outer">
                                                        <div class="parent_search">
                                                            <input type="text" value="<?php echo SEARCH_BY . ucfirst($valAttributeDetail['AttributeLabel']) ?>" onblur="if(this.value==''){this.value = '<?php echo SEARCH_BY . ucfirst($valAttributeDetail['AttributeLabel']) ?>';}" onfocus="if(this.value=='<?php echo SEARCH_BY . ucfirst($valAttributeDetail['AttributeLabel']) ?>'){this.value = '';}" onclick="if(this.value=='<?php echo SEARCH_BY . ucfirst($valAttributeDetail['AttributeLabel']) ?>'){this.value = '';}"/>
                                                           <!-- <input type="button" value="Go"/>-->
                                                        </div>
                                                    </div>

                                                    <div class="scroll-pane category_left">
                                                        <ul class="parent_check">
                                                            <?php
                                                        }
                                                        $old_pkAttributeId = $valAttributeDetail['pkAttributeId'];
                                                        ?>
                                                        <li>
                                                            <input type="checkbox" class="Attribute styleda"  name="frmAttribute_<?php echo $valAttributeDetail['pkAttributeId']; ?>" value="<?php echo $valAttributeDetail['pkOptionID']; ?>"/> 
                                                            <label><?php echo $valAttributeDetail['OptionTitle']; ?> (<?php echo substr_count($valAttributeDetail['ProductId'], ",") + 1; ?>)</label>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>                                                
                                </div>
                                <div class="category_list">
                                    <div class="btmbrd">
                                        <h3><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>arrdown.png" /><?php echo PRICE; ?></h3>
                                    </div>
                                    <div class="toggle">
                                        <div class="parent_search_outer">
                                            <div class="parent_search drop13">
                                                <select name="frmProductPrice" id="prc" class="drop_down1 prc" onchange="prc('0')">
                                                    <option value="0.00-<?php echo FILTER_PRICE_LIMIT; ?>" selected="selected">All</option>
                                                    <?php
                                                    $cnt = 1;
                                                    foreach ($objPage->PriceRange as $k => $priceAry) {
                                                        if ($priceAry['productNum'] > 0) {
                                                            $cnt++
                                                            ?>
                                                            <option value="<?php echo $priceAry['value']; ?>">
                                                                <?php echo $objCore->getPrice($priceAry['from']) . ($priceAry['to'] == '' ? ' And Above' : " - " . $objCore->getPrice($priceAry['to'])); ?> (<?php echo $priceAry['productNum']; ?>)
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="price_range">
                                            <label>Enter a Price range</label>
                                            <input type="text" name="frmPriceFrom" id="frmPriceFrom" onkeyup="Javascript: if (event.keyCode==13) prc('1');" value="<?php echo floor($objCore->getRawPrice($objPage->arrPriceRange['min'],0)); //($_REQUEST['frmPriceFrom'] != '' ? $_REQUEST['frmPriceFrom'] : '');                       ?>"/>
                                            <small></small>
                                            <input type="text" name="frmPriceTo" id="frmPriceTo" onkeyup="Javascript: if (event.keyCode==13) prc('1');" value="<?php echo ceil($objCore->getRawPrice($objPage->arrPriceRange['max'],0)); //($_REQUEST['frmPriceTo'] != '' ? $_REQUEST['frmPriceTo'] : '');                       ?>"/>
                                            <input type="button" onclick="prc('1')" value="Go"/>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <input type="hidden" id="all_att_val" name="all_att_val" value="<?php echo $attributesVariable; ?>" />
                        </div>
                    </div>
                    <div class="parent_child_mid" id="middle_section">
                        <div class="scroll-pane category_mid">
                            <ul class="datail_block">
                                <?php
                                $i = 1;
                                foreach ($objPage->arrProductDetails as $productdetails) {
                                    if ($i > $objPage->lagyPageLimit) {
                                        break;
                                    } else {
                                        $varSrc = $objCore->getImageUrl($productdetails['ProductImage'], 'products/' . $arrProductImageResizes['listing']);
                                        if ($productdetails['Quantity'] == 0) {
                                            $varAddCartUrl = 'class="cart2 outOfStock"';
                                            $addToCart = OUT_OF_STOCK;
                                        } else {
                                            $addToCart = ADD_TO_CART;
                                            if (count($productdetails['arrAttributes']) == 0) {
                                                //$varAddCartUrl = 'href="#product' . $productdetails['pkProductID'] . '" class="cart2 addCart" onclick="addToCart(' . $productdetails['pkProductID'] . ')" ';
                                                $varAddCartUrl = 'href="' . $objCore->getUrl('common/ajax/ajax_cart.php', array('action' => 'addToCart', 'pid' => $productdetails['pkProductID'], 'qty' => '1')) . '" class="cart2 addCart ' . $productdetails['pkProductID'] . '" onclick="addToCart(' . $productdetails['pkProductID'] . ')" ';
                                            } else {
                                                $varAddCartUrl = 'href="' . $objCore->getUrl('product.php', array('id' => $productdetails['pkProductID'], 'name' => $productdetails['ProductName'], 'refNo' => $productdetails['ProductRefNo'],'add'=>'addCart')) . '#addCart" class="cart2 addCart" ';
                                            }
                                        }
                                        ?>
                                        <li>
                                            <div class="thumbdetail_outer">
                                                <div class="thumb_outer">
                                                    <div class="thumb_img">
                                                        <img src="<?php echo $objCore->getImageUrl($productdetails['ProductImage'], 'products/' . $arrProductImageResizes['special']); ?>" alt="<?php echo $productdetails['ProductName'] ?>"/>
                                                        <div class="miniBoxHoverSpecial">
                                                            <a <?php echo $varAddCartUrl; ?>><span><?php echo $addToCart; ?></span></a>
                                                            <a href="<?php echo $objCore->getUrl('product.php', array('id' => $productdetails['pkProductID'], 'name' => $productdetails['ProductName'], 'refNo' => $productdetails['ProductRefNo'])); ?>" class="proBtn"><span><?php echo PRODUCT_DETAILS; ?></span></a>
                                                            <a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $productdetails['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $productdetails['pkProductID']; ?>');" class="qckView quick QuickView<?php echo $productdetails['pkProductID']; ?>"><span><?php echo QUICK_OVERVIEW; ?></span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="detail_bot">
                                                    <p><?php echo $objCore->getProductName($productdetails['ProductName'], 35); ?></p>
                                                    <strong>
                                                        <?php
                                                        // echo $val['FinalPrice'];
                                                        $arrPrice = $objCore->getFinalPriceWithOffer($productdetails['FinalPrice'], $productdetails['DiscountFinalPrice'], $productdetails['SpecialFinalPrice']);
                                                        echo $arrPrice['price'];
                                                        ?>
                                                    </strong>
                                                </div>
                                                <?php if ($arrPrice['off'] > 0) { ?>
                                                    <div class="offer">
                                                        <div class="offPriceText"><span><?php echo $arrPrice['off']; ?>% off</span></div>
                                                    </div>
                                                <?php } ?>

                                            </div>
                                        </li>
                                        <?php
                                    }
                                    $i++;
                                }
                                ?>
                            </ul>
                            <div id="marker-end" limit="<?php echo $objPage->lagyPageLimit; ?>" data-end="<?php echo ($i < $objPage->lagyPageLimit) ? 1 : 0; ?>">                            
                                <?php if ($i > $objPage->lagyPageLimit) { ?>
                                    <img src="<?php echo IMAGES_URL ?>loader100.gif" title="Loading more results..." alt="Loading..." />
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="parent_child_mid" style="width:797px;">
                        <div class="noProductAvail">
                            <strong><?php echo NO_PRODUCT; ?></strong>
                        </div>
                    </div>
                <?php }
                ?>
                <div class="parent_child_right">
                    <div class="cart_sec">
                        <h3 onclick="window.location='<?php echo $objCore->getUrl('shopping_cart.php'); ?>'">My Cart</h3>
                        <div class="cart_bottm">
                            <?php
                            if ($_SESSION['MyCart']['Total']) {
                                $item = ' item';
                                $item .= ($_SESSION['MyCart']['Total'] > 1) ? 's' : '';
                                ?>
                                <p>You have <?php echo $_SESSION['MyCart']['Total'] . $item; ?> <br/>in your cart</p>
                                <span><a href="<?php echo $objCore->getUrl('shopping_cart.php'); ?>">&#187;view cart </a></span>
                            <?php } else { ?>
                                <p>No items added into <br/> the cart</p>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if (count($objPage->arrData['arrAdsDetails'][0]) > 0) { ?>
                        <div class="cat_img">
                            <?php
                            if ($objPage->arrData['arrAdsDetails'][0]['AdType'] == 'link') {
                                ?>
                                <a href="<?php echo $objPage->arrData['arrAdsDetails'][0]['AdUrl'] ?>" target="_blank"><img src="<?php echo UPLOADED_FILES_URL; ?>images/ads/189x207/<?php echo $objPage->arrData['arrAdsDetails'][0]['ImageName'] ?>" alt="<?php echo $objPage->arrData['arrAdsDetails'][0]['Title'] ?>" title="<?php echo $objPage->arrData['arrAdsDetails'][0]['Title'] ?>" width="189" height="207"  /></a>
                            <?php } else { ?>
                                <?php echo html_entity_decode(stripslashes($objPage->arrData['arrAdsDetails'][0]['HtmlCode'])); ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>         
        <?php include_once INC_PATH . 'footer.inc.php'; ?>       
    </body>
</html>