<?php
require_once 'solarium.php';
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;
require_once CONTROLLERS_PATH . FILENAME_CATEGORY_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo isset($_GET['name']) ? $_GET['name'] : CATEGORY_TITLE; ?></title>
        <meta name="description" content="<?php echo $objPage->arrCategoryDetails[0]['CategoryMetaKeywords']; ?>"/>
        <meta name="keywords" content="<?php echo $objPage->arrCategoryDetails[0]['CategoryMetaDescription']; ?>"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <script>var pageLimit = <?php echo $objPage->lagyPageLimit; ?>;</script>
        <style>
            .primium_wholeseller.scroll-pane{height:100px !important;}
            .parent_child_mid .scroll-pane{width: 100% !important;}
            .price_slider .back-bar .pointer-label:nth-child(2){right:1px !important;text-align:right !important;}
            .parent_child_left{margin-bottom:20px !important;}
            .toggle .scroll-pane .jspPane{position: static !important;}
            .banner_cat img{max-width: 100%;}
            @media screen and (max-width:1023px){
            .parent_child_mid .scroll-pane{width: 100% !important;}
            }
            .category_list ul.parent_check li {cursor: default;}
            .btmbrd{
                cursor:default;
                display:inline-block;
                width: 100%;
            }
        </style>
        <script>
            $(function(){
                $('.scroll-pane').jScrollPane();
                //$('.btmbrd').on('click',function(){
                //    return false;
                //});
              
            });
        </script>
    </head>
    <body>
        <div id="navBar">
            <?php include_once INC_PATH . 'top-header.inc.php'; ?>
        </div>
        <div class="header" >
            <div class="layout">
            </div>
        </div> <?php include_once INC_PATH . 'header.inc.php'; ?>

        <div class="layout">
            <div class="parent_child_sec">
                <ul class="parent_top" id="parent_top">
                    <?php
                    //echo "<pre>";
                    //print_r($_REQUEST);
                    //die;
                    if (isset($_REQUEST['searchKey']) && $_REQUEST['searchKey'] <> '' && $_REQUEST['searchKey'] <> SEARCH_FOR_BRAND)
                    {
                        echo '<li class="first"><strong>' . $_REQUEST['searchKey'] . '</strong></li>';
                    }
                    else if (isset($_REQUEST['searchVal']) && $_REQUEST['searchVal'] <> '' && $_REQUEST['searchVal'] <> SEARCH_FOR_BRAND)
                    {
                        echo '<li class="first"><strong>' . $_REQUEST['searchVal'] . '</strong></li>';
                    }
                    else if (isset($_REQUEST['cid']))
                    {
                        echo $objPage->varBreadcrumbs;
                    }
                    else if (isset($_REQUEST['wid']))
                    {
                        echo '<li class="first"><strong>' . $objPage->arrWholeSalerDetails[0]['CompanyName'] . '</strong></li>';
                    }
                    else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'new')
                    {
                        echo '<li class="first"><strong>What\'s New</strong></li>';
                    }
                    ?>                    
                </ul>
                <!--START H1-->
                <div class="top_header compareheader">
                    <div class="newCompareBox" style="<?php echo count($objPage->varCompareProduct)>0?'display:block':'display:none';?>">
                        
<!--                        <div class="cross_icon"><a href="#" id="closeCompareSection">X</a></div>-->
                                        
                        <div class="leftUlCompare">
                            <ul class="myCompareUl">
                                <?php
                                for ($i = 0; $i <= 3; $i++)
                                {
                                    if ($objPage->varCompareProduct[$i][0]['pkProductID'])
                                    {
                                        $varSrc = $objCore->getImageUrl($objPage->varCompareProduct[$i][0]['ImageName'], 'products/' . $arrProductImageResizes['default']);
                                        ?>
                                        <li>
                                            <div class="compare_products"> <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $objPage->varCompareProduct[$i][0]['pkProductID'], 'name' => $objPage->varCompareProduct[$i][0]['ProductName'], 'refNo' => $objPage->varCompareProduct[$i][0]['ProductRefNo'])); ?>"><img src="<?php echo $varSrc; ?>" alt="<?php echo $objPage->varCompareProduct[$i][0]['ProductName'] ?>" border="0" /></a>
                                                <div class="name_comp"> <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $objPage->varCompareProduct[$i][0]['pkProductID'], 'name' => $objPage->varCompareProduct[$i][0]['ProductName'], 'refNo' => $objPage->varCompareProduct[$i][0]['ProductRefNo'])); ?>"> <?php echo ucfirst($objCore->getProductName($objPage->varCompareProduct[$i][0]['ProductName'], 22)); ?></a> </div>
                                            </div>
                                            <div class="cross_icon"><a href="javascript:void(0)" onclick="RemoveProductFromCompare(<?php echo $objPage->varCompareProduct[$i][0]['pkProductID']; ?>);" title="Remove">X</a></div>
                                        </li>
                                        <?php
                                    }
                                    else
                                    {
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

                    <h1><?php echo $_GET['name']; ?> Product</h1>

                </div>

                <!--END H1-->
                <?php
                if($objPage->arrProductDetails==232){
                mail('sandeep.sharma@mail.vinove.com','hi'.$_SESSION['sessUserInfo']['id'],print_r($objPage->arrProductDetails,1));    
                }
                
                //echo "<pre>";
                //print_r($objPage->arrProductDetails);
                //die;
                if (count($objPage->arrProductDetails) > 0)
                {
                    ?>
                    <div>
                        <input type="hidden" name="page" value="<?php echo ($_REQUEST['page'] > 0 ? $_REQUEST['page'] : 0); ?>" id="page" />
                        <input type="hidden" name="typ" id="typ" value="<?php echo ($_REQUEST['type'] != '' ? $_REQUEST['type'] : ''); ?>" />
                        <input type="hidden" id="searchPageKey" value="<?php echo $_GET['name']; ?>"/>
                        <!--                       id="leftPanelId"-->
                        <div class="parent_child_left">
                            <?php
                            if (count($objPage->CategoryChildList) > 0)
                            {
                                ?>

                                <div class="category_list">
                                    <div class="btmbrd">
                                        <h3><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>arrdown.png" /><?php echo CATEGORY_TITLE; ?></h3>
                                    </div>
                                    <div class="toggle">
                                        <div class="scroll-pane category_left">
                                            <div class="main_left">
                                                <div class="listing_1">
                                                    <?php if (isset($_REQUEST['cid'])){?>
                                                    <a class="ajax_category active_lisitng mainCatText" href="<?php echo $_REQUEST['cid'];?>">
                                                        <label>All <?php echo $_GET['name'] != '' ? $_GET['name'] : 'Category'; ?></label>
                                                    </a>                                                    
                                                    <?php }else{?>
                                                    <a href="" class="active_lisitng mainCatText">All <?php echo $_GET['name'] != '' ? $_GET['name'] : 'Category'; ?></a>
                                                    <?php }?>                                                    
                                                    <ul class="parent_check">
                                                        <?php
                                                        foreach ($objPage->CategoryChildList as $CategoryChildList)
                                                        {
                                                            echo '<li><a class="ajax_category" href="' . $CategoryChildList['pkCategoryID'] . '"><label>' . $CategoryChildList['CategoryName'] . ' (' . $CategoryChildList['ProductNum'] . ')</label></a></li>';
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <?php
                            }
                            else
                            {
                                ?>
                                <div class="category_list">
                                    <div class="btmbrd">
                                        <h3 style="width:144px;"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>arrdown.png" /><?php echo CATEGORY_TITLE; ?></h3>
                                    </div>
                                    <div class="toggle">
                                        <div class="category_left">
                                            <div class="main_left">
                                                <div class="listing_1"><a href="<?php echo $objCore->getUrl('category.php', array('cid' => $objPage->parentDetailsCategory[0]['pkCategoryId'], 'name' => $objPage->parentDetailsCategory[0]['CategoryName'])); ?>" class="active_lisitng_category">All <?php echo $objPage->parentDetailsCategory[0]['CategoryName']; ?></a>
                                                    <ul class="parent_check">
                                                        <li><label><?php echo $_GET['name']; ?></label></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            <?php } ?>
                            <input  type="hidden" name="chooseCategory" value="<?php echo $_REQUEST['cid']; ?>" id="chooseCategoryId" class="chooseCategory"/>
                            <div id="leftPanelId">
                                <?php
                                if ($objPage->CategoryLevel < 2)
                                {
                                    $dispay = 'style="display:none"';
                                }
                                ?>
                                <div id="exCategory">
                                    <?php
                                    $varWhlNum = count($objPage->arrWholeSalerList);
                                   // pre($objPage->arrWholeSalerList);
                                    if ($varWhlNum > 0)
                                    {
                                        ?>

                                        <div class="category_list">
                                            <div class="btmbrd">
                                                <h3><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>arrdown.png" /><?php echo WHOLESALER; ?></h3>
                                            </div>
                                            <div class="toggle">
                                                <div class="parent_search_outer">
                                                    <div class="parent_search" >
                                                        <input type="text" value="<?php echo SEARCH_BY . WHOLESALER ?>" onblur="if (this.value == '') {
                                                            this.value = '<?php echo SEARCH_BY . WHOLESALER ?>';
                                                        }" onfocus="if (this.value == '<?php echo SEARCH_BY . WHOLESALER ?>') {
                                                        this.value = '';
                                                    }" onclick="if (this.value == '<?php echo SEARCH_BY . WHOLESALER ?>') {
                                                    this.value = '';
                                                }" class="go_icon" />
                                                        <!--<input type="button" value="Go"/>-->
                                                    </div>
                                                </div>

                                                <div class="scroll-pane category_left">
                                                    <ul class="parent_check"   style="padding-bottom:2px;">
                                                        <?php
                                                        $cnt = 0;
                                                        
                                                        foreach ($objPage->arrWholeSalerList as $wholeSalerList)
                                                        {
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
                                    </div>
                                <?php } ?>
                                <div>
                                    <div>
                                        <div>
                                            <ul>
                                                <?php
                                                if (count($objPage->arrProductDetails) > 0 && isset($_REQUEST['cid']) && $_REQUEST['cid'] > 0)
                                                {
                                                    ?>
                                                    <?php
                                                    $attributesVariable = $old_pkAttributeId = '';

                                                    foreach ($objPage->arrData['arrAttributeDetail'] as $valAttributeDetail)
                                                    {
                                                        if ($valAttributeDetail['pkAttributeId'] != $old_pkAttributeId)
                                                        {
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
                                                            <input type="text" value="<?php echo SEARCH_BY . ucfirst($valAttributeDetail['AttributeLabel']) ?>" onblur="if (this.value == '') {
                                                    this.value = '<?php echo SEARCH_BY . ucfirst($valAttributeDetail['AttributeLabel']) ?>';
                                                }" onfocus="if (this.value == '<?php echo SEARCH_BY . ucfirst($valAttributeDetail['AttributeLabel']) ?>') {
                                                this.value = '';
                                            }" onclick="if (this.value == '<?php echo SEARCH_BY . ucfirst($valAttributeDetail['AttributeLabel']) ?>') {
                                            this.value = '';
                                        }"/>
                <!--                                                            <input type="button" value="Search"/>-->
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

                                                            <label>
                                                                <?php
                                                                if ($valAttributeDetail['AttributeLabel'] == 'Color')
                                                                {
                                                                    ?>
                                                                    <a href="javascript:void(0)" class="color_checkbox" style="cursor: default;background:<?php echo $valAttributeDetail['OptionTitle']; ?>"></a>
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
            var p1 = '<?php echo (int) trim(floor($objCore->getRawPrice($objPage->arrPriceRange['min'], 0))); ?>';
            var p2 = '<?php echo (int) trim(ceil($objCore->getRawPrice($objPage->arrPriceRange['max'], 0))); ?>';
            //var pp1=0;
            //var pp2=0;
            $(document).ready(function(){
                                p2=parseInt(p2);
                                p1=parseInt(p1);
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

                                });
                                </script>
                                <div class="category_list">
                                    <div class="btmbrd">
                                        <h3><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>arrdown.png" /><?php echo PRICE; ?></h3>
                                    </div>
                                    <div class="toggle">

                                        <div class="price_range">
                                            <label>Set Price range</label>
                                            <input type="text" name="frmPriceFrom" id="frmPriceFrom" onkeyup="Javascript: if (event.keyCode == 13)
                        prc('1');" value="<?php echo (int) trim(floor($objCore->getRawPrice($objPage->arrPriceRange['min'], 0)));?>"/>
                                            <small></small>
                                            <input type="text" name="frmPriceTo" id="frmPriceTo" onkeyup="Javascript: if (event.keyCode == 13)
                        prc('1');" value="<?php echo (int) trim(ceil($objCore->getRawPrice($objPage->arrPriceRange['max'], 0)));?>"/>
                                            <input type="button" onclick="prc('1')" value="Search"/>
                                        </div>
                                        <div class='price_slider'>
                                            <input class="range-slider" type="text" value="<?php echo (int) trim(floor($objCore->getRawPrice($objPage->arrPriceRange['min'], 0))); ?>,<?php echo (int) trim(ceil($objCore->getRawPrice($objPage->arrPriceRange['max'], 0))); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php
                                if (count($objPage->arrData['arrAdsDetails']) > 0)
                                {
                                    foreach ($objPage->arrData['arrAdsDetails'] as $key => $val)
                                    {
                                        if ($val['AdType'] == 'link')
                                        {
                                            ?>
                                            <div class="banner_cat"><a href="<?php echo $val['AdUrl'] ?>" target="_blank"><img src="<?php echo UPLOADED_FILES_URL; ?>images/ads/<?php echo $val['ImageSize'] ?>/<?php echo $val['ImageName'] ?>" alt="<?php echo $val['Title'] ?>" border="0" title="<?php echo $val['Title'] ?>" width="158px" /></a></div>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <input type="hidden" id="all_att_val" name="all_att_val" value="<?php echo $attributesVariable; ?>" />
                        <input type="hidden" id="showCurrentDiv" value="orenge"/>
                    </div>
                </div>
				
            
				
                <div class="parent_child_mid" id="middle_section">

                    <?php
                        $totalPageCount = 0;
                        if (count($objPage->arrData['arrWeekPremium']) > 0) {
                       ?>
                    <div class="primium_wholeseller_hrz orengeActive" style="display:none">
                            <div class="customNavigation"> <a class="btn prev7"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-left.png" alt=""> </a> <a class="btn next7"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-right.png" alt=""></a> </div>
                            <div class="topwhole_heading_hrz"><h2>Premium Wholesaler <span class="border_bar1"></span></h2></div>

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
    



                    <div class="sort_by">
                        <div class="griding">
                            <a href="#" class="bg orenge"><i class="fa fa-th-large fa-5"></i></a>
                            <a href="#" class="grey"><i class="fa fa-bars fa-5"></i></a>
                        </div>
                        <div class="sorting1"><form name="frmSorting" id="frmSorting" action="" method="post">
                                <span class="sort_section">Sort By :</span>
                                <select id="sortingId" name="sortingId" onchange="sorting_product_up();">
                                    <option value="<?php echo RECENT_ADD; ?>" <?php
                            if ($_POST['sortingId'] == '' . RECENT_ADD . '')
                            {
                                echo 'selected';
                            }
                                ?>><?php echo RECENT_ADD; ?></option>
                                    <option value="A-Z" <?php
                                        if ($_POST['sortingId'] == 'A-Z')
                                        {
                                            echo 'selected';
                                        }
                                ?>>A-Z</option>
                                    <option value="Z-A" <?php
                                        if ($_POST['sortingId'] == 'Z-A')
                                        {
                                            echo 'selected';
                                        }
                                ?>>Z-A</option>
                                    <option value="Price (Low > High)" <?php
                                        if ($_POST['sortingId'] == 'Price (Low > High)')
                                        {
                                            echo 'selected';
                                        }
                                ?>><?php echo PRICE_LOW; ?></option>
                                    <option value="Price (High > Low)" <?php
                                        if ($_POST['sortingId'] == 'Price (High > Low)')
                                        {
                                            echo 'selected';
                                        }
                                ?>><?php echo PRICE_HIGH; ?></option>
                                    <option value="Popularity" <?php
                                        if ($_POST['sortingId'] == 'Popularity')
                                        {
                                            echo 'selected';
                                        }
                                ?>><?php echo POPULARITY; ?></option>

                                </select>
                            </form>

                        </div></div>

                    <div class="scroll-pane category_mid">
					
			
                        <div class="category_grey">
                            <?php include_once INC_PATH . 'category_middle_grey.php'; ?>
                        </div>
                        <div class="category_orenge">
                            <?php include_once INC_PATH . 'category_middle_orenge.php'; ?>
                        </div>
                        <div class="datail_block"></div>
                        <div id="marker-end" limit="<?php echo $objPage->lagyPageLimit; ?>" data-end="<?php echo ($i < $objPage->lagyPageLimit) ? 1 : 0; ?>">
                            <?php
                            if ($i > $objPage->lagyPageLimit)
                            {
                                ?>
                                <img src="<?php echo IMAGES_URL ?>loader100.gif" title="Loading more results..." alt="Loading..." />
                            <?php } ?>
                        </div>					
                    </div>










                    </div>
				
				<!--RIGHT PANEL CSS-->
                                <?php
                                if(count($objPage->arrData['arrWeekPremium'])>0){
                                ?>
				<div class="parent_right_panel">
				<div class="primium_wholeseller"> 			
                                <div class="topwhole_heading">Premium Wholesaler</div>   
                                <ul  class="cart_complete scroll-pane" style=" width:175px; overflow:auto">
                        <?php
                        
                        foreach ($objPage->arrData['arrWeekPremium'] as $key => $wholeVal)
                        {
                           
                            ?>
                            <li>
                                <div class="new_heading"><a href="<?php echo $objCore->getUrl('wholesaler_profile_customer_view.php', array('action' => 'view', 'wid' => $wholeVal['pkWholesalerID'])); ?>" style="color:#565655;"> <?php echo $objCore->getProductName($wholeVal['CompanyName'], 39); ?></a></div>
                                
                                
                               
                            </li>
                            <?php
                            
                        }
                        
                        ?>

                    </ul>

                                    
                                
				
				</div>
				</div>
                                <?php } ?>
				
				 	
            </div>
       
          
            <?php
        }
        else
        {
            ?>
            <div class="parent_child_mid" style="width:797px;">
                <div class="noProductAvail">
                    <strong><?php echo NO_PRODUCT; ?></strong>
                </div>
            </div>
        <?php }
        ?>

        </div>
        </div> 
        <input type="hidden" id="defaultfromPrice" value="<?php echo floor($objCore->getRawPrice($objPage->arrPriceRange['min'], 0)); ?>"/>
        <input type="hidden" id="defaultToPrice" value="<?php echo ceil($objCore->getRawPrice($objPage->arrPriceRange['max'], 0)); ?>"/>
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
        <div style="width:1140px;margin:0 auto;"><br style="clear:both" />
 <?php
                        $totalPageCount = 0;
                        if (count($objPage->arrData['arrMonthPremium']) > 0) {
                            ?>
            <div style="margin-left:180px;width:780px;">
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
</div>

                        <?php } ?></div>
        <?php include_once INC_PATH . 'footer.inc.php'; ?>
    </body>
</html>