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
         <input type="hidden" id="showCurrentDiv" value="orenge"/>
        <div class="parent_child_mid" id="middle_section">
                                          <?php
                        $totalPageCount = 0;
                        if (count($objPage->arrData['arrWeekPremium']) > 0) {
                       ?>
                    <div class="primium_wholeseller_hrz orengeActive" <?php echo $_REQUEST['disPDiv']=='grey'?'style="display:block"':'style="display:none"';?>>
                            <div class="customNavigation"> <a class="btn prev7"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-left.png" alt=""> </a> <a class="btn next7"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-right.png" alt=""></a> </div>
                            <div class="topwhole_heading_hrz"><h2>Top 50 Premium Wholesaler <span class="border_bar1"></span></h2></div>

                            <div class="Wholseller_block_hrz">
                                <div class="demo landing">
                                    <div class="resp-tabs-container">

                                        <div>
                                            <div id="demo">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="span12">
                                                            <div  class="owl-demo7">
                                                                <?php
                                                                foreach ($objPage->arrData['arrWeekPremium'] as $key => $wholeVal) {
                                                                    ?>
                                                                <div class="item">
                                                                    <div class="thum_block">
                                                                        <a href="<?php echo $objCore->getUrl('wholesaler_profile_customer_view.php', array('action' => 'view', 'wid' => $wholeVal['pkWholesalerID'])); ?>">
                                                                                    <img class="img" src="<?php echo $objCore->getImageUrl($wholeVal['wholesalerLogo'], 'wholesaler_logo'); ?>" src="" alt="<?php echo $wholeVal['CompanyName'] ?>"/>
                                                                                </a>
                                                                        
                                                                            <div class="thum_nameblock"><a href="<?php echo $objCore->getUrl('wholesaler_profile_customer_view.php', array('action' => 'view', 'wid' => $wholeVal['pkWholesalerID'])); ?>" style="color:black;"><?php echo $objCore->getProductName($wholeVal['CompanyName'], 39); ?></a></div>
                                                                    </div>
                                                                </div>
                                                                <?php } ?>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div></div>
                        </div>
                        <?php } ?>
    <br style="clear:both;" /><br/>
            
					<div class="sort_by">
                                        <div class="griding">
                                            <a href="#" class="bg orenge"><i class="fa fa-th-large fa-5"></i></a>
                                            <a href="#" class="grey"><i class="fa fa-bars fa-5"></i></a>
                                            <a href="#" class="clear_search">Clear search</a>
                                            
                                        </div>
                                            <div class="sorting1"><form name="frmSorting" id="frmSorting" action="" method="post">
                                                    <span class="sort_section">Sort By :</span>
                                                    <select id="sortingId" name="sortingId" onchange="sorting_product_up();">
                                                    <option value="<?php echo RECENT_ADD;?>" <?php
                                        if ($_POST['sortingId'] == ''.RECENT_ADD.'') {
                                            echo 'selected';
                                        }
                                            ?>><?php echo RECENT_ADD;?></option>
                                                    <option value="A-Z" <?php
                                                        if ($_POST['sortingId'] == 'A-Z') {
                                                            echo 'selected';
                                                        }
                                            ?>>A-Z</option>
                                                    <option value="Z-A" <?php
                                                        if ($_POST['sortingId'] == 'Z-A') {
                                                            echo 'selected';
                                                        }
                                            ?>>Z-A</option>
                                                    <option value="Price (Low > High)" <?php
                                                        if ($_POST['sortingId'] == 'Price (Low > High)') {
                                                            echo 'selected';
                                                        }
                                            ?>><?php echo PRICE_LOW;?></option>
                                                    <option value="Price (High > Low)" <?php
                                                        if ($_POST['sortingId'] == 'Price (High > Low)') {
                                                            echo 'selected';
                                                        }
                                            ?>><?php echo PRICE_HIGH;?></option>
                                                    <option value="Popularity" <?php
                                                        if ($_POST['sortingId'] == 'Popularity') {
                                                            echo 'selected';
                                                        }
                                            ?>><?php echo POPULARITY;?></option>

                                                </select>
                                            </form></div></div>
        <?php if (count($objPage->arrProductDetails) > 0) { ?>
            <div class="scroll-pane category_mid">
               
                    <div class="category_grey" <?php echo $_REQUEST['disPDiv']=='grey'?'style="display:block"':'style="display:none"';?>>
                        <?php include_once INC_PATH . 'category_middle_grey.php'; ?>
                    </div>
                    <div class="category_orenge" <?php echo $_REQUEST['disPDiv']=='orenge'?'style="display:block"':'style="display:none"';?>>
                        <?php include_once INC_PATH . 'category_middle_orenge.php'; ?>
                    </div>
         </div>
    <br style="clear:both" />
 <?php
                        $totalPageCount = 0;
                        if (count($objPage->arrData['arrMonthPremium']) > 0) {
                            ?>
 <div class="primium_wholeseller_hrz">
                            <div class="customNavigation"> <a class="btn prev7"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-left.png" alt=""> </a> <a class="btn next7"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-right.png" alt=""></a> </div>
                            <div class="topwhole_heading_hrz"><h2>Monthly Wholesaler <span class="border_bar1"></span></h2></div>

                            <div class="Wholseller_block_hrz">
                                <div class="demo landing">
                                    <div class="resp-tabs-container">

                                        <div>
                                            <div id="demo">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="span12">
                                                            <div  class="owl-demo7">
                                                                <?php
                                                                foreach ($objPage->arrData['arrMonthPremium'] as $key => $wholeVal) {
                                                                    ?>
                                                                <div class="item">
                                                                    <div class="thum_block">
                                                                        <a href="<?php echo $objCore->getUrl('wholesaler_profile_customer_view.php', array('action' => 'view', 'wid' => $wholeVal['pkWholesalerID'])); ?>">
                                                                                    <img class="img" src="<?php echo $objCore->getImageUrl($wholeVal['wholesalerLogo'], 'wholesaler_logo'); ?>" src="" alt="<?php echo $wholeVal['CompanyName'] ?>"/>
                                                                                </a>
                                                                        
                                                                            <div class="thum_nameblock"><a href="<?php echo $objCore->getUrl('wholesaler_profile_customer_view.php', array('action' => 'view', 'wid' => $wholeVal['pkWholesalerID'])); ?>" style="color:black;"><?php echo $objCore->getProductName($wholeVal['CompanyName'], 39); ?></a></div>
                                                                    </div>
                                                                </div>
                                                                <?php } ?>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div></div>
                        </div>
                        <?php } ?>
    
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
                $addToCartImg = 'outofstock_icon.png';
            } else {
                $addToCart = ADD_TO_CART;
                $addToCartImg = 'cart_icon.png';
                if (count($productdetails['arrAttributes']) == 0) {
                    //$varAddCartUrl = 'href="#product' . $productdetails['pkProductID'] . '" class="cart2 addCart" onclick="addToCart(' . $productdetails['pkProductID'] . ')" ';
                    $varAddCartUrl = 'href="' . $objCore->getUrl('common/ajax/ajax_cart.php', array('action' => 'addToCart', 'pid' => $productdetails['pkProductID'], 'qty' => '1')) . '" class="cart2 addCart ' . $productdetails['pkProductID'] . '" onclick="addToCart(' . $productdetails['pkProductID'] . ')" ';
                } else {
                    $varAddCartUrl = 'href="' . $objCore->getUrl('product.php', array('id' => $productdetails['pkProductID'], 'name' => $productdetails['ProductName'], 'refNo' => $productdetails['ProductRefNo'])) . '" class="cart2 addCart" ';
                }
            }
            $varImageSize = @explode('x', (string) $arrProductImageResizes['global']);
            $varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/' . $arrProductImageResizes['global'] . '/' . $productdetails['ProductImage'];
             ?>
         <div class="view view-first category_orenge category_orenge_ajax" <?php echo $_REQUEST['showCurrentDiv']=='orenge'?'style="display:block"':'style="display:none"' ?>>
                             <div class="image_new">
                                 <img  width="<?php echo $varImageSize[0]; ?>" height="<?php echo $varImageSize[1]; ?>"src="<?php echo $objCore->getImageUrl($productdetails['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" alt="<?php echo $productdetails['ProductName'] ?>"/>
                                 <div class="new_heading"><?php echo $objCore->getProductName($productdetails['ProductName'], 39); ?></div>
                                 <?php
                                 $arrPrice = $objCore->getFinalPriceWithOffer($productdetails['FinalPrice'], $productdetails['DiscountFinalPrice'], $productdetails['SpecialFinalPrice']);
                                 if ($arrPrice['off'] > 0) {
                                     ?>
                                     <div class="discount_new"><?php echo $arrPrice['off']; ?>%<span>OFF</span></div>
                                 <?php } ?>
                                 <div class="price_new"><?php echo $objCore->getFinalPrice($productdetails['FinalPrice'], $productdetails['DiscountFinalPrice'], $arrSpecialProductPrice[$productdetails['pkProductID']]['FinalSpecialPrice'], 0, 1); ?></div>
                                 <!--<div class="unactive"><?php //echo $objCore->getProductName($productdetails['ProductDescription'], 20);  ?> </div>-->
                             </div>
                             <div class="mask">
                                 <h2><a href="<?php echo $objCore->getUrl('product.php', array('id' => $productdetails['pkProductID'], 'name' => $productdetails['ProductName'], 'refNo' => $productdetails['ProductRefNo'], 'add' => 'addCart')); ?>"><?php echo $productdetails['ProductName']; ?></a></h2>
                                 <p class="productPointer"><?php //echo $objCore->getProductName($val['ProductDescription'], 20);   ?></p>
                                 <div class="mask_box">
                                     <a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $productdetails['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $productdetails['pkProductID']; ?>');" class="info quick QuickView<?php echo $productdetails['pkProductID']; ?>" title="<?php echo QUICK_OVERVIEW; ?>"><?php echo QUICK_OVERVIEW; ?></a>
                                     <?php if ($addToCart == OUT_OF_STOCK) {
                                         ?>
                                         <a <?php echo $varAddCartUrl; ?> title="<?php echo $addToCart; ?>"><?php echo $addToCart; ?></a>
                                         <?php
                                     } else {
                                         if ($_SESSION['sessUserInfo']['type'] == 'customer') {
                                             if (in_array($productdetails['pkProductID'], $objPage->arrData['arrWishListOfCustomer'])) {
                                                 ?>
                                                 <a href='#' class='info afterSavedInWishList' style='background:red;color:white'>Saved</a>
                                             <?php
                                             } else {
                                                 ?>
                                                 <a href="#" class="info saveTowishlist orenge_<?php echo $productdetails['pkProductID']; ?>"  Pid="<?php echo $productdetails['pkProductID']; ?>" tp="category_orenge">Save</a>
                                             <?php
                                             }
                                         } else {
                                             ?>
                                             <a href="#loginBoxReview" class="info jscallLoginBoxReview" onclick="jscallLoginBoxCustomer('jscallLoginBoxReview', 'wish',<?php echo $productdetails['pkProductID']; ?>);" >Save</a>
                                         <?php
                                         }
                                     }
                                     ?>
                                 </div>

                             </div>
                         </div> 
            
                <div class="grid_product category_grey category_grey_ajax" <?php echo $_REQUEST['showCurrentDiv']=='grey'?'style="display:block"':'style="display:none"' ?>>

            <div class="cart_img">
                <a href="<?php echo $objCore->getUrl('product.php', array('id' => $productdetails['pkProductID'], 'name' => $productdetails['ProductName'], 'refNo' => $productdetails['ProductRefNo'], 'add' => 'addCart')); ?>">
                    <img  width="<?php echo $varImageSize[0]; ?>" height="<?php echo $varImageSize[1]; ?>" src="<?php echo $objCore->getImageUrl($productdetails['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" alt="<?php echo $productdetails['ProductName'] ?>"/>
                </a>
            </div>
            <div class="right_product"><div class="quick_title_1"><span><?php echo $objCore->getProductName($productdetails['ProductName'], 30); ?></span>	</div>

                <div class="content_left"><div class="price"><?php echo $objCore->getFinalPrice($productdetails['FinalPrice'], $productdetails['DiscountFinalPrice'], $arrSpecialProductPrice[$productdetails['pkProductID']]['FinalSpecialPrice'], 0, 1); ?>
                        <span>You Save <cite><?php echo $objCore->getPrice($productdetails['FinalPrice'] - $productdetails['DiscountFinalPrice']); ?></cite></span>
                    </div>
                    <div class="inner_rating avg_rating rating category_rating">
                        <?php
                        $arrRatingDetails = $objComman->myRatingDetails($productdetails['pkProductID']);
                        $productRate = ($arrRatingDetails[0]['numRating']) / ($arrRatingDetails[0]['numCustomer']);
                        echo $objComman->getRatting($productRate);
                        ?>
                    </div>
                    <p class="content_txt1"><?php echo $objCore->getProductName($productdetails['ProductDescription'], 200); ?></p>



                </div>

                <div class="contnet_right">

                    <p class="" style="padding-top:10px;background:none;">

                        <?php
                        if ($_SESSION['sessUserInfo']['type'] == 'customer')
                        {
                            ?>
                            <a class="watch_link1" href="javascript:void('0');" onclick="addToWishlist(<?php echo $productdetails['pkProductID']; ?>)">Add to Save List</a>
                            <?php
                        }
                        else
                        {
                            ?>
                            <a class="watch_link1" href="javascript:void('0');" onclick="addToWishlistLogin(<?php echo $productdetails['pkProductID']; ?>)">Add to Save List</a>
                        <?php } ?>
                        <a cmCid="<?php echo $productdetails['pkCategoryId']; ?>" cmPid="<?php echo $productdetails['pkProductID']; ?>" id="CompareCheckBox<?php echo $productdetails['pkProductID']; ?>" class="compare_quick" onclick="addToCompare(<?php echo $productdetails['pkProductID']; ?>,<?php echo $productdetails['pkCategoryId']; ?>,'<?php echo $objCore->getUrl('product_comparison.php'); ?>');" href="javascript:void('0');">Compare</a> </p>
                    <div class="succCategoryCart" id="<?php echo $productdetails['pkProductID']; ?>">&nbsp;</div>
                    <div id="addtoCompareMessage<?php echo $productdetails['pkProductID']; ?>" class="addtoCompareMessage"></div>
                    </p>

                </div>

                <div class="save_sction">
                    <a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $productdetails['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $productdetails['pkProductID']; ?>');" class=" compare_btn_sh quick QuickView<?php echo $productdetails['pkProductID']; ?>" title="<?php echo QUICK_OVERVIEW; ?>">Quick View</a>     <?php
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
                            if (in_array($productdetails['pkProductID'], $objPage->arrData['arrWishListOfCustomer']))
                            {
                                ?>
                                <a href='#' class='cart_link_1 afterSavedInWishList' style='background:red;color:white'>Saved</a>
                                <?php
                            }
                            else
                            {
                                ?>
                                <a href="#" class="cart_link_1 saveTowishlist <?php echo $productdetails['pkProductID']; ?>" id="<?php echo $productdetails['pkProductID']; ?>" Pid="<?php echo $productdetails['pkProductID']; ?>" tp="category_grey">Save</a>
                                <?php
                            }
                        }
                        else
                        {
                            ?>
                            <a href="#loginBoxReview" class=" shopping_update2  cart_link_1 jscallLoginBoxReview" onclick="jscallLoginBoxCustomer('jscallLoginBoxReview', 'wish',<?php echo $productdetails['pkProductID']; ?>);" >Save</a>
                            <?php
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
           <?php
        }
        break;


    case 'SelectLeftPanel':
       
        
            ?>
        
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
                        <div class="listing_1"><a href="#" class="active_lisitng clear_search" >clear search</a></div>
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
                                <div class="scroll-pane category_left" style="height:150px;">
                                    <ul class="parent_check"   style="padding-bottom:3px;">
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
                                        
                                        <label>
                                            <?php if($valAttributeDetail['AttributeLabel']=='Color' || $valAttributeDetail['AttributeLabel']=='COLOR'){ ?>
                                                            <a href="#" class="color_checkbox" style="background:<?php echo $valAttributeDetail['OptionTitle'];?>"></a>
                                                            <?php } ?>
                                            <?php echo $valAttributeDetail['OptionTitle']; ?> (<?php echo substr_count($valAttributeDetail['ProductId'], ",") + 1; ?>)</label>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>                                                
            </div>
            
            <script>
                                var p1='<?php echo (int) $_REQUEST['frmPriceFrom']!=''?(int) $_REQUEST['frmPriceFrom']:0;?>';
                                var p2='<?php echo (int) $_REQUEST['frmPriceTo']!=''?(int) $_REQUEST['frmPriceTo']:0; ?>';
                                var priceSliderFrom=document.getElementById('defaultfromPrice').value;
                                var priceSliderTo=document.getElementById('defaultToPrice').value;
                                $(document).ready(function(){
                                p2=parseInt(priceSliderTo);
                                p1=parseInt(priceSliderFrom);
                                $('.range-slider').jRange({
                                    from: p1,
                                    to: p2,
                                    step: 1,
                                    scale: [p1,p2],
                                    format: '%s',
                                    width: 230,
                                    showLabels: true,
                                    isRange : true,
                                    onstatechange: function(event) {
                                        var vvl=event.split(',');
                                        var pp1=parseInt(vvl[0]);
                                        var pp2=parseInt(vvl[1]);
                                        pp1=parseInt(vvl[0]);
                                        pp2=parseInt(vvl[1]);
                                        $('#frmPriceFrom').val(pp1);
                                        $('#frmPriceTo').val(pp2);
                                    }
                                });

                                })
                            </script>
            <div class="category_list">
                <div class="btmbrd">
                    <h3><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>arrdown.png" /><?php echo PRICE; ?></h3>
                </div>
                <div class="toggle">
                    <div class="listing_1"><a href="#" class="active_lisitng clear_search" >clear search</a></div>
                   <div class="price_range">
                        <label>Set Price range</label>
                        <label>Search Price range <span><?php echo (int) $_REQUEST['frmPriceFrom']!=''?(int) $_REQUEST['frmPriceFrom']:0;?>-<?php echo (int) $_REQUEST['frmPriceTo']!=''?(int) $_REQUEST['frmPriceTo']:0; ?></span> </label>
                        
                        <input type="text" name="frmPriceFrom" id="frmPriceFrom" onkeyup="Javascript: if (event.keyCode==13) prc('1');" value="<?php echo (int) $objPage->arrPriceRange['min']!=''?(int) floor($objCore->getRawPrice($objPage->arrPriceRange['min'],0)):(int) $_REQUEST['frmPriceFrom'];?>"/>
                        <small></small>
                        <input type="text" name="frmPriceTo" id="frmPriceTo" onkeyup="Javascript: if (event.keyCode==13) prc('1');" value="<?php echo (int) $objPage->arrPriceRange['max']!=''?(int) ceil($objCore->getRawPrice($objPage->arrPriceRange['max'],0)):(int) $_REQUEST['frmPriceTo'];?>"/>
                        <input type="button" onclick="prc('1')" value="Go"/>
                    </div>
                    <div class='price_slider'>
                        <input class="range-slider" type="hidden" value="<?php echo (int) floor($objCore->getRawPrice($objPage->arrPriceRange['min'],0));?>,<?php echo (int) ceil($objCore->getRawPrice($objPage->arrPriceRange['max'],0));?>"/>
                    </div>
                </div>
            </div> 
                            <?php 
                            
                            
                            if (count($objPage->arrData['arrAdsDetails']) > 0) {
                                          foreach($objPage->arrData['arrAdsDetails'] as $key=>$val){
                                              if ($val['AdType'] == 'link') {
                                            ?>
                                    <div class="banner_cat"><a href="<?php echo $val['AdUrl'] ?>" target="_blank"><img src="<?php echo UPLOADED_FILES_URL; ?>images/ads/<?php echo $val['ImageSize'] ?>/<?php echo $val['ImageName'] ?>" alt="<?php echo $val['Title'] ?>" title="<?php echo $val['Title'] ?>" /></a></div>
                                              <?php } } } ?>
        </div>
        <input type="hidden" id="all_att_val" name="all_att_val" value="<?php echo $attributesVariable; ?>" /> 
        <?php
        break;
}
?>
