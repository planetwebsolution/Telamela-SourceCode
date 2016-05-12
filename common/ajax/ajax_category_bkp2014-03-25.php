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
        ?>
        <?php
        if (isset($_REQUEST['cid'])) {
            //echo ucfirst($objPage->arrCategoryDetails[0]['CategoryName']);
            //echo $objPage->varBreadcrumbs;
            //echo $objPage->varBreadcrumbs;
        }
        ?>

        <div class="breadcurmb">
            <?php
            if (isset($_REQUEST['searchVal']) && $_REQUEST['searchVal'] <> '' && $_REQUEST['searchKey'] <> SEARCH_FOR_BRAND && $_REQUEST['searchVal'] <> ENTER_KEY) {
                echo '<strong>' . $_REQUEST['searchVal'] . '</strong>';
            } else if (isset($_REQUEST['cid'])) {
                echo $objPage->varBreadcrumbs;
            } else if (isset($_REQUEST['wid'])) {
                echo '<strong>' . $objPage->arrWholeSalerDetails[0]['CompanyName'] . '</strong>';
            } else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'new') {
                echo "<strong>What's New</strong>";
            }
            ?>&nbsp;
        </div>
        <div class="product_gradient">
            <div class="product_list">
                <div class="bottom_option">
                    <?php
                    if (count($objPage->arrProductDetails) > 0) {
                        $pagIng = '<div class="view"><span>Viewing <span>' . ($varPageStart + 1) . '</span>-<span>' . (($objPage->varNumberofRows < PRODUCT_LISTING_LIMIT_PER_PAGE) ? $objPage->NumberofRows : $varPageStart + $objPage->varNumberofRows) . '</span> of <span>' . $objPage->NumberofRows . '</span> results</span></div>';
                        //$pagIng = '<div class="view"><span><span>' . $objPage->NumberofRows . '</span> results</span></div>';
                        echo $pagIng;
                        ?>    
                        <div class="pagination">
                            <?php
                            if ($objPage->varNumberPages > 1) {
                                $objPage->displaySolrPaging($_REQUEST['page'], $objPage->varNumberPages, PRODUCT_LISTING_LIMIT_PER_PAGE);
                            }
                            ?>                           </div>

                        <div class="sorting" style="float:right !important;">
                            <label><?php echo SORT_BY; ?></label> 
                            <form name="frmSorting" id="frmSorting" action="" method="POST">
                                <div class="tl-short">
                                    <select id="sortingId" name="sortingId" class="my_dropdown" onchange="sorting_product_up();">
                                        <option value="<?php echo RECENT_ADD; ?>" <?php
                if ($_POST['sortingId'] == 'Recently Added') {
                    echo 'selected';
                }
                            ?>><?php echo RECENT_ADD; ?></option>
                                        <option value="A-Z" <?php
                                    if ($_POST['sortingId'] == 'A-Z') {
                                        echo 'selected';
                                    }
                            ?>><?php echo 'A - Z'; ?></option>
                                        <option value="Z-A" <?php
                                    if ($_POST['sortingId'] == 'Z-A') {
                                        echo 'selected';
                                    }
                            ?>><?php echo 'Z - A'; ?></option>
                                        <option value="Price (Low > High)" <?php
                                    if ($_POST['sortingId'] == 'Price (Low > High)') {
                                        echo 'selected';
                                    }
                            ?>><?php echo PRICE_LOW; ?></option>
                                        <option value="Price (High > Low)" <?php
                                    if ($_POST['sortingId'] == 'Price (High > Low)') {
                                        echo 'selected';
                                    }
                            ?>><?php echo PRICE_HIGH; ?></option>
                                        <option value="Popularity" <?php
                                    if ($_POST['sortingId'] == 'Popularity') {
                                        echo 'selected';
                                    }
                            ?>><?php echo POPULARITY; ?></option>
                                    </select>
                                </div>
                            </form>
                        </div></div>
                    <div class="products">
                        <ul>
                            <?php
                            $productnums = 1;
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
                                <li <?php
                if ($productnums % 3 == 0) {
                    echo 'class="last"';
                }
                                ?>>
                                    <div class="single_product"><img src="<?php echo $varSrc; ?>" align="middle" alt="" />
                                        <div class="prdouct_rollover">
                                            <ul>
                                                <li><a <?php echo $varAddCartUrl; ?>><small><?php echo $addToCart; ?></small><span><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>shop-iocn-2.png" alt=""/></span></a></li>
                                                <li><a href="<?php echo $objCore->getUrl('product.php', array('id' => $productdetails['pkProductID'], 'name' => $productdetails['ProductName'], 'refNo' => $productdetails['ProductRefNo'])); ?>" class="detial"><small><?php echo PRODUCT_DETAILS; ?></small><span><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>search-icon2.png" alt=""/></span></a></li>
                                                <li><a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $productdetails['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $productdetails['pkProductID']; ?>')" class="quick QuickView<?php echo $productdetails['pkProductID']; ?>"><small><?php echo QUICK_OVERVIEW; ?></small><span><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>eyes_iocn.png" alt=""/></span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <a href="<?php echo $objCore->getUrl('product.php', array('id' => $productdetails['pkProductID'], 'name' => $productdetails['ProductName'], 'refNo' => $productdetails['ProductRefNo'])); ?>" class="product_name"><?php echo $objCore->getProductName($productdetails['ProductName'], 16); ?></a>
                                    <p><?php echo $objCore->getProductName($productdetails['ProductDescription'], 20); ?>&nbsp;</p>
                                    <div class="outer_rating">
                                        <div class="rating">
                                            <?php
                                            $productRate = ($productdetails['numRating'] / $productdetails['numCustomer']);
                                            echo $objComman->getRatting($productRate);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="product_price">
                                        <?php
                                        if ($productdetails['DiscountFinalPrice'] != 0) {
                                            ?>
                                            <span><?php echo $objCore->getPrice($productdetails['FinalPrice']); ?></span><br/><?php echo $objCore->getPrice($productdetails['DiscountFinalPrice']); ?>
                                            <?php
                                        } else {
                                            echo $objCore->getPrice($productdetails['FinalPrice']) . "<br/> &nbsp;";
                                        }
                                        ?>
                                    </div>

                                    <input type="checkbox" name="addtoCompareCheckBox<?php echo $productdetails['pkProductID']; ?>" id="addtoCompareCheckBox<?php echo $productdetails['pkProductID']; ?>" <?php
                        if (isset($_SESSION['MyCompare']['Product'][$productdetails['pkProductID']])) {
                            echo "checked";
                        }
                                        ?> onclick="addToCompareToggleId(<?php echo $productdetails['pkProductID']; ?>);"/>  <?php echo COMPARE; ?>
                                    <div id="addtoCompareMessage<?php echo $productdetails['pkProductID']; ?>" style="color:green;">&nbsp;</div>


                                    <!-- POPUP CONTENT Added Start-->
                                    <?php
                                    $varStr = '<div style="display: none;">
                                                <div id="product' . $productdetails['pkProductID'] . '">                                                   
                                                    <div class="cart_inner">
                                                        <h3>' . PRODUCT_ADD_IN_SHOPING_CART . '.</h3>
                                                        <div class="cart_detail">
                                                            <span class="proimg">                                                               
                                                                <img src="' . $varSrc . '" width="110" height="110" class="prodImg"/>
                                                            </span>
                                                            <div class="detail_right">
                                                                <h4>' . $productdetails['ProductName'] . '</h4>
                                                                <ul style="min-height:70px;">';
                                    if ($productdetails['DiscountFinalPrice'] > 0) {
                                        $varStr .= '<li><small>' . PRICE . '</small>:<span style="text-decoration: line-through;"> ' . $objCore->getPrice($productdetails['FinalPrice']) . '</span></li>
                                                                    <li><small>&nbsp;</small><span>&nbsp; ' . $objCore->getPrice($productdetails['DiscountFinalPrice']) . '</span></li>';
                                    } else {
                                        $varStr .= '<li><small>' . PRICE . '</small><span style="text-decoration:lign-through;">: ' . $objCore->getPrice($productdetails['FinalPrice']) . '</span></li>';
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


                                    <!-- Quick CONTENT Added Start-->




                                    <!-- Quick CONTENT Added end-->


                                </li>
                                <?php
                                $productnums++;
                            }
                            ?> 
                        </ul></div>
                    <div class="bottom_option">
                        <?php echo $pagIng; ?>

                        <div class="pagination">
                            <?php
                            if ($objPage->varNumberPages > 1) {
                                $objPage->displaySolrPaging($_REQUEST['page'], $objPage->varNumberPages, PRODUCT_LISTING_LIMIT_PER_PAGE);
                            }
                            ?>          
                        </div>
                        <div class="sorting"   style="float:right !important; margin-left:38px !important"><label><?php echo SORT_BY; ?> </label>
                            <form name="frmSorting2" id="frmSorting2" action="" method="POST">
                                <div class="tl-short">
                                    <select id="sortingId2" name="sortingId" class="my_dropdown" onchange="sorting_product_down()">
                                        <option value="Recently Added" <?php
                if ($_POST['sortingId'] == 'Recently Added') {
                    echo 'selected';
                }
                            ?>><?php echo RECENT_ADD; ?></option>
                                        <option value="A-Z" <?php
                                    if ($_POST['sortingId'] == 'A-Z') {
                                        echo 'selected';
                                    }
                            ?>><?php echo 'A - Z'; ?></option>
                                        <option value="Z-A" <?php
                                    if ($_POST['sortingId'] == 'Z-A') {
                                        echo 'selected';
                                    }
                            ?>><?php echo 'Z - A'; ?></option>
                                        <option value="Price (Low > High)" <?php
                                    if ($_POST['sortingId'] == 'Price (Low > High)') {
                                        echo 'selected';
                                    }
                            ?>><?php echo PRICE_LOW; ?></option>
                                        <option value="Price (High > Low)" <?php
                                    if ($_POST['sortingId'] == 'Price (High > Low)') {
                                        echo 'selected';
                                    }
                            ?>><?php echo PRICE_HIGH; ?></option>
                                        <option value="Popularity" <?php
                                    if ($_POST['sortingId'] == 'Popularity') {
                                        echo 'selected';
                                    }
                            ?>><?php echo POPULARITY; ?></option>
                                    </select>
                                </div>
                            </form>
                        </div></div>
                    <?php
                } else {
                    ?>
                    <span style="text-align: center; float: left; font-weight: bold; width: 100%"><?php echo NO_PRODUCT; ?></span> 
                <?php }
                ?>
            </div>
        </div>

        <?php
        break;


    case 'SelectLeftPanel':
        ?>
        <div class="category_list"><h6><?php
        if (count($objPage->CategoryChildList) > 0) {
            echo CATEGORY_TITLE;
        }
        ?></h6>
            <div class="">
                <div id="pageWrap" class="pageWrap">
                    <div id="ddsidemenubar" class="markermenu">
                        <ul id="sidemenu">
                            <?php
                            foreach ($objPage->CategoryChildList as $CategoryChildList) {
                                echo '<li><a class="ajax_category" href="' . $CategoryChildList['pkCategoryID'] . '">' . $CategoryChildList['CategoryName'] . ' (' . $CategoryChildList['ProductNum'] . ')</a></li>';
                            }
                            ?>

                        </ul>
                    </div>
                </div>
                <input  type="hidden" name="chooseCategory" value="<?php echo $_REQUEST['cid']; ?>" id="chooseCategoryId" class="chooseCategory"/>
            </div>
        </div>
        <?php
        if ($objPage->CategoryLevel < 2) {
            $dispay = 'style="display:none"';
        }
        ?>
        <div id="exCategory" <?php echo $dispay; ?>>
            <?php //if (count($objPage->arrProductDetails) > 0) { ?>
            <div class="category_list btmbrd"><div><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>arrright.png"><h6><?php echo PRICE; ?></h6></div>
                <ul>
                    <?php $cnt = 1; ?>
                    <li> <input type="radio" name="frmProductPrice" id="prc<?php echo $cnt; ?>" class='prc' <?php echo ('0.00-' . FILTER_PRICE_LIMIT == $_REQUEST['pid'] || '' == $_REQUEST['pid']) ? 'checked="checked"' : ''; ?> value="0.00-<?php echo FILTER_PRICE_LIMIT ?>"/> <?php echo ALL; ?></li>
                    <?php
                    foreach ($objPage->PriceRange as $k => $priceAry) {
                        if ($priceAry['productNum'] > 0) {
                            $cnt++;
                            ?>
                            <li <?php echo ($cnt - 1 == count($objPage->PriceRange) ? 'class="last"' : ""); ?>> <input type="radio" name="frmProductPrice" id="prc<?php echo $cnt; ?>" class='prc' value="<?php echo $priceAry['value']; ?>" <?php echo ($priceAry['value'] == $_REQUEST['pid']) ? 'checked="checked"' : ''; ?>/> <?php echo $objCore->getPrice($priceAry['from']) . ($priceAry['to'] == '' ? ' And Above' : " - " . $objCore->getPrice($priceAry['to'])); ?> (<?php echo $priceAry['productNum']; ?>)</li>
                            <?php
                        }
                    }
                    ?>                                                          
                </ul>
            </div>

            <?php
            //}
            $varWhlNum = count($objPage->arrWholeSalerList);
            if ($varWhlNum > 0) {
                ?>
                <div class="category_list btmbrd"><div><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>arrright.png"><h6><?php echo WHOLESALER; ?></h6></div>                                  

                    <ul class="atrscroll">
                        <?php
                        $cnt = 0;
                        $aryWholesaler = explode(",", $_REQUEST['wid']);
                        foreach ($objPage->arrWholeSalerList as $wholeSalerList) {
                            ?>
                            <li <?php
                if ($varWhlNum == $cnt + 1) {
                    echo 'class="last"';
                }
                            ?>>
                                <input type="checkbox" id="frmCategoryWholeSalerId<?php echo $cnt + 1; ?>" class="whl" name="frmCategoryWholeSaler[]" value="<?php echo ucfirst($wholeSalerList['pkWholesalerID']); ?>" <?php echo in_array($wholeSalerList['pkWholesalerID'], $aryWholesaler) ? 'checked="checked"' : ''; ?> /> <?php echo ucfirst($wholeSalerList['CompanyName']); ?> (<?php echo $wholeSalerList['ProductNum']; ?>)                                          
                                <?php
                                $cnt++;
                            }
                            ?>
                    </ul>
                </div>

            <?php } ?>
            <div><ul>
                    <?php
                    if (count($objPage->arrProductDetails) > 0) {
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
                        <div class="category_list btmbrd"><div><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>arrright.png"><h6><?php echo ucfirst($valAttributeDetail['AttributeLabel']); ?></h6></div>
                            <ul class="atrscroll">
                                <?php
                            }
                            $old_pkAttributeId = $valAttributeDetail['pkAttributeId'];
                            ?>	
                            <li>
                                <input type="checkbox" class="Attribute"  name="frmAttribute_<?php echo $valAttributeDetail['pkAttributeId']; ?>" value="<?php echo $valAttributeDetail['pkOptionID']; ?>" <?php
                if (in_array($valAttributeDetail['pkOptionID'], $varCheckedOpt)) {
                    echo 'checked="checked"';
                }
                            ?> /> <?php echo $valAttributeDetail['OptionTitle']; ?> (<?php echo substr_count($valAttributeDetail['ProductId'], ",") + 1; ?>)
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                    }
                    ?>
                </ul></div>
        </div>
        <input type="hidden" id="all_att_val" name="all_att_val" value="<?php echo $attributesVariable; ?>" /> 
        <?php
        break;
}
?>
