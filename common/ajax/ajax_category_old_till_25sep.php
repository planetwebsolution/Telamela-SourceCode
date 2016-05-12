<?php
/* * ****************************************
  Module name : Ajax Calls
  Date created : 06 June, 2013
  Date last modified : 06 June, 2013
  Author : Suraj Kumar Maurya
  Last modified by :  Suraj Kumar Maurya
  Comments : This file includes the funtions for AJAX calls.
  Copyright : Copyright (C) 1999-2011 Vinove Software and Services
 * **************************************** */
require_once '../../solarium.php';
require_once('../config/config.inc.php');
//require_once CLASSES_PATH . 'class_category_bll.php';
//require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;
require_once CONTROLLERS_PATH . FILENAME_CATEGORY_CTRL;
$objComman = new ClassCommon();
$objPaging = new Paging();
$varcase = $_REQUEST['action'];
//sleep(150);
if (isset($_REQUEST['page'])) {
    $varPage = $_REQUEST['page'];
} else {
    $varPage = '';
}

$varPageStart = $objPaging->getPageStartLimit($varPage, PRODUCT_LISTING_LIMIT_PER_PAGE);

switch ($varcase) {

    case 'SelectProductCategory':
        //echo '<pre>';print_r($_REQUEST);echo '</pre>';

        if (isset($_REQUEST['searchKey']) && $_REQUEST['searchKey'] <> '' && $_REQUEST['searchKey'] <> SEARCH_FOR_BRAND) {
            echo '<li class="first"><strong>' . $_REQUEST['searchKey'] . '</strong></li>';
        } else if (isset($_REQUEST['cid'])) {
            echo $objPage->varBreadcrumbs;
        } else if (isset($_REQUEST['wid'])) {
            echo '<li class="first"><strong>' . $objPage->arrWholeSalerDetails[0]['CompanyName'] . '</strong></li>';
        } else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'new') {
            echo '<li class="first"><strong>What\'s New</strong></li>';
        }
        echo '###skm###';
        ?>

        <div class="scroll-pane category_mid">
            <?php if (count($objPage->arrProductDetails) > 0) { ?>
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
                        <img src="<?php echo IMAGES_URL ?>loader100.gif"/>
                    <?php } ?>
                </div>
                <?php
            } else {
                ?>
                <p style="text-align: center; float: left; font-weight: bold; width: 100%"><?php echo NO_PRODUCT; ?></p> 
            <?php }
            ?>
        </div>

        <?php
        break;

    case 'productLazyLoading':

        foreach ($objPage->arrProductDetails as $productdetails) {
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
                    $varAddCartUrl = 'href="' . $objCore->getUrl('product.php', array('id' => $productdetails['pkProductID'], 'name' => $productdetails['ProductName'], 'refNo' => $productdetails['ProductRefNo'])) . '" class="cart2 addCart" ';
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
        break;


    case 'SelectLeftPanel':

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
                            $aryWholesaler = explode(",", $_REQUEST['wid']);
                            foreach ($objPage->arrWholeSalerList as $wholeSalerList) {
                                ?>
                                <li>
                                    <input type="checkbox" class="whl stsyled" id="frmCategoryWholeSalerId<?php echo $cnt + 1; ?>" name="frmCategoryWholeSaler[]" value="<?php echo ucfirst($wholeSalerList['pkWholesalerID']); ?>"  <?php echo in_array($wholeSalerList['pkWholesalerID'], $aryWholesaler) ? 'checked="checked"' : ''; ?> />
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
                            <?php
                            if (count($objPage->arrProductDetails) > 0 && isset($_REQUEST['cid']) && $_REQUEST['cid']>0) {
                                $varCheckedOpt = array();
                                $varCheckedOpt1 = explode('#', $_REQUEST['attr']);
                                foreach ($varCheckedOpt1 as $AtrOpt) {
                                    $varCheckedOpt2 = explode(':', $AtrOpt);
                                    $varCheckedOpt = array_merge($varCheckedOpt, explode(',', $varCheckedOpt2[1]));
                                }
                                //echo '<pre>';print_r($varCheckedOpt);echo '</pre>';die;
                                $attributesVariable = '';
                                ?>
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
                                        <input type="checkbox" class="Attribute styleda"  name="frmAttribute_<?php echo $valAttributeDetail['pkAttributeId']; ?>" value="<?php echo $valAttributeDetail['pkOptionID']; ?>" <?php
                    if (in_array($valAttributeDetail['pkOptionID'], $varCheckedOpt)) {
                        echo 'checked="checked"';
                    }
                                    ?>/> 
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
                                <option value="0.00-<?php echo FILTER_PRICE_LIMIT; ?>" <?php echo ('0.00-' . FILTER_PRICE_LIMIT == $_REQUEST['pid'] || '' == $_REQUEST['pid']) ? 'selected="selected"' : ''; ?>>All</option>
                                <?php
                                $cnt = 1;
                                foreach ($objPage->PriceRange as $k => $priceAry) {
                                    if ($priceAry['productNum'] > 0) {
                                        $cnt++
                                        ?>
                                        <option value="<?php echo $priceAry['value']; ?>" <?php echo ($priceAry['value'] == $_REQUEST['pid']) ? 'selected="selected"' : ''; ?>>
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
                        <input type="text" name="frmPriceFrom" id="frmPriceFrom" onkeyup="Javascript: if (event.keyCode==13) prc('1');" value="<?php echo floor($objCore->getRawPrice($objPage->arrPriceRange['min'],0)); //($_REQUEST['frmPriceFrom'] != '' ? $_REQUEST['frmPriceFrom'] : '');            ?>"/>
                        <small></small>
                        <input type="text" name="frmPriceTo" id="frmPriceTo" onkeyup="Javascript: if (event.keyCode==13) prc('1');" value="<?php echo ceil($objCore->getRawPrice($objPage->arrPriceRange['max'],0)); //($_REQUEST['frmPriceTo'] != '' ? $_REQUEST['frmPriceTo'] : '');            ?>"/>
                        <input type="button" onclick="prc('1')" value="Go"/>
                    </div>
                </div>
            </div>  
        </div>
        <input type="hidden" id="all_att_val" name="all_att_val" value="<?php echo $attributesVariable; ?>" /> 
        <?php
        break;
}
?>
