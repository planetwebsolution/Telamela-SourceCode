<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_CUSTOMER_CTRL;
$wid = $objCore->getFormatValue($_REQUEST['wid']);
//pre($_SESSION);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Wholesaler Profile - Customer View</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>wholesalerprofile_style.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>wholesalerprofile_owl.carousel.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>wholesalerprofile_owl.theme.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>wholesalerprofile_media.css"/>
         <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>main.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>jquery.jqzoom.css"/>
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery_cr.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.jqzoom-core.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>jQueryRotate.js"></script>
    <!--Lazy loading-->
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.lazy.js"></script>
    
    <script type="text/javascript" src="<?php echo JS_PATH ?>owl.carousel2.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>home.js"></script>
    <!--<script src="<?php echo JS_PATH; ?>easyResponsiveTabs.js" type="text/javascript" ></script>-->
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>easy-responsive-tabs.css" />
    <link href="<?php echo SITE_ROOT_URL; ?>common/wholesaler_template/template1/css/templateMenu.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo PATH_URL_CM; ?>dp/js/msdropdown/jquery.dd.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>wholeminishop.js" ></script>
     <script src="<?php echo SITE_ROOT_URL; ?>common/wholesaler_template/template1/js/template-custom.js"> </script>
    <!--<link type="text/css" rel="stylesheet" href="<?php echo CSS_PATH; ?>responsive.css" />-->
    <script type="text/javascript">
         var wID='<?php echo $wid;?>'; //alert(wID);
        $(document).ready(function() {
            jQuery("img.lazy").lazy({
                delay: 2000
            });
        });
    </script>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                // binds form submission and fields to the validation engine
                $("#reply_message_form").validationEngine();
                $('.drop_down1').sSelect();

            });
            
            function wholesalerReplyPopup(str){                
                $("."+str).colorbox({inline:true,width:"700px"});
                
                $('#compose_cancel').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });
		
		
		
            }   
        </script>
              
        <style>            
            .profile_left li p {margin:0px !important;}.reply_message{margin-top: 25px;}
			.cancel{ background:#7f7f7f; }
			.reply_message .right_m{width:410px;}
			.reply_message .left_m label {font-weight: 400; font-size:14px;}
			.reply_message .right_m textarea{width:408px !important;}
			.profile_right li .icons{height:28px;}
                        .demo{width:1140px !important}
                        /*.slide_wrapper .owl-item{width: 284px !important}*/
						.slide_wrapper .owl-item{width: 280px !important}
                        .slide_wrapper .owl-controls{display:none !important}
                        .slimage{height:350px !important;width:1140px !important}
                        .hid{display:none}
                        .reply_message .left_m label{width:71px;}
                        .nav ul li{position:relative}
                        .Menubar{display:none;position:absolute; background: #FFF; z-index: 999;}
                        /*.Menubar ul.MainMenu li:last-child{width:200px !important}*/
                        .colormy_righttd{width: 500px !important}
                        .cart_link1{width:288px!important}
                        .out_of_stock_cart_link1{width:288px!important}
                        .view{height:325px !important;}
                        .view a.info{width:49% !important;}
                        .view .mask{position: absolute; width: 100% !important; height: 100% !important;}
                        .mask_box{bottom:2px !important}
                        .view{width:259px !important;}
                        .email{height:auto !important}
                        .cart{height: 47px !important; width: 175px;}
                        .dd .ddTitle .ddTitleText{height: 45px !important;}
                      .stylish-select .categories .selectedTxt{white-space: nowrap;}
                      .categories{height: 45px !important;}
                      .customNavigation.new_custom{margin-right:-4px;}  
                      .new_tabs_list li:last-child{padding-right:0;}
					  
					  @media only screen and (max-width:1139px){
						  .slide_wrapper .owl-item{width: 244px !important}
						  .view{width:231px!important;}
						  .resp_main_div{padding:0 2px!important;}
						  .resp_heading{width:100%;margin-bottom:10px;}
						  .resp_demo .resp-tabs-list li{margin-bottom:2px;}
						  .outer_container{width:100%;}
					  }
		
        </style>
    </head>
    <body>
           <em> <div id="navBar">
            <?php include_once INC_PATH . 'top-header.inc.php'; ?>
        </div>
    
        </em>
       <div class="header"><div class="layout"> </div>
               <?php include_once INC_PATH . 'header.inc.php'; ?>
       
       </div>
        
        
      
          
        <!--<div id="ouderContainer" class="ouderContainer_1"><div style="width:100%; height:50px; padding-top:16px;	  border-bottom:1px solid #e7e7e7;"><div class="btn_top"><?php //include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>-->
            <div class="layout">
             
                <div>
               
                    <?php if ($objCore->displaySessMsg()) {
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


                </div>
               
                <div class="add_pakage_outer">
                    
                     <div class="outer_container">
			<div class="header">
				<div class="logo2">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr><td valign="middle">
                        <!--<a href="#">-->
                                             <?php if (file_exists(UPLOADED_FILES_SOURCE_PATH . "images/wholesaler_logo/" . $objPage->arrWholeSalerDetails['wholesalerLogo']) && isset($objPage->arrWholeSalerDetails['wholesalerLogo']) && $objPage->arrWholeSalerDetails['wholesalerLogo'] != '') {
                                                ?>
                                                <img src="<?php echo UPLOADED_FILES_URL . "images/wholesaler_logo/" . $objPage->arrWholeSalerDetails['wholesalerLogo']; ?>" alt="<?php echo $objPage->arrWholeSalerDetails['CompanyName']; ?>" width="190px" height="90px"/>
                                            <?php
                                            } else {
                                                ?>
                                                <img src="<?php echo IMAGE_PATH_URL?>/wholesaler_logo.png" alt="company Logo" />
                                            <?php } ?>
                                        <!--</a>-->
                    </td></tr></table>
                
				</div>
				<div class="h_fright">
					<ul class="feedbacks">
                    	<li><img src="<?php echo IMAGE_PATH_URL?>/thumbs_up.png" alt="img" /> Positive Feedbacks : <span><?php
                                        if ($objPage->arrwholesalerFeedback[0]['postiveFeedback'] != "") {
                                            echo $objPage->arrwholesalerFeedback[0]['postiveFeedback'];
                                        } else {
                                            echo "0";
                                        }
                                        ?></span></li>
                        <li><img src="<?php echo IMAGE_PATH_URL?>/thumbs_down.png" alt="img" /> <i>Negaitive Feedbacks : <span><?php
                                        if ($objPage->arrwholesalerFeedback[0]['negativeFeedback'] != "") {
                                            echo $objPage->arrwholesalerFeedback[0]['negativeFeedback'];
                                        } else {
                                            echo "0";
                                        }
                                        ?></span></i></li>
                    	<li><img src="<?php echo IMAGE_PATH_URL?>/beg.png" alt="img" /> Item Sold : <span><?php
                                        if ($objPage->arrwholesalerFeedback[0]['postiveFeedback'] != "") {
                                            echo $objPage->arrwholesalerFeedback[0]['itemSold'];
                                        } else {
                                            echo "0";
                                        }
                                        ?></span></li>
                    </ul>
				</div>

			</div>
            <div class="clear"></div>
		</div>
                    <div class="nav">
            <div class="outer_container">
				<ul>
					<li>
						<a href="javascript:void(0)" class="active" onclick="showWholesalerContent2('home', 'nav_home')" id="nav_home">Home</a>
					</li>
					<li>
						<a href="javascript:void(0)" onmouseenter="showWholesalerMenu('Menubar',event)" onmouseout="hideWholesalerMenu('Menubar',event)" class="template_men">My Shop</a>
                                                <?php require_once 'template_menu.php';?>
					</li>
					<li>
						<a href="javascript:void(0)" onclick="showWholesalerContent2('about_us')" id="nav_about_us">About</a>
					</li>
					<li>
						<a href="javascript:void(0)" onclick="showWholesalerContent2('services')" id="nav_services">Services</a>
					</li>
					<li>
						<a href="javascript:void(0)" onclick="showWholesalerContent2('testimonials')" id="nav_testimonials">Testimonials</a>
					</li>
					<li>
						<a href="javascript:void(0)" onclick="showWholesalerContent2('contact_us')" id="nav_contact_us">Contact Us</a>
					</li>
				
				</ul>
              <?php /*  <div class="address">Address : A/47 Los Angles, New York, United States</div> */?>
</div>
			</div>
                    
                    <div class="outer_container main_div resp_main_div" id="home">
			<div class="slide_section">

				<div class="slideshow">

					<div id="owl-demo" class="owl-carousel">
                                                <?php
                                               // pre($objPage->arrWholeSalerDetails['Sliderimage']);
                        if (count($objPage->arrWholeSalerDetails['Sliderimage']) > 0)
                        {
                            foreach ($objPage->arrWholeSalerDetails['Sliderimage'] as $slider)
                            {
                                if (file_exists(UPLOADED_FILES_SOURCE_PATH . "images/wholesaler_slider/" . $slider['sliderImage']))
                                {
                                    ?>							
                                    <div class="item"><img src="<?php echo UPLOADED_FILES_URL . "images/wholesaler_slider/" . $slider['sliderImage']; ?>"  alt="<?php echo $objPage->arrWholeSalerDetails['CompanyName']; ?>" class="slimage"/>
                                    
                                    </div>
            <?php
        }
    }
}
else
{
    ?>
                            <div class="item"><img src="<?php echo IMAGE_PATH_URL?>/slide1.jpg" alt="pic"/></div>
<?php } ?>
                                    
						

					</div>

				</div>

			</div>
			<div class="clear"></div>
			<div class="slide_wrapper">
                <div class="demo pos_relative resp_demo">
                	<!--Your thumb slider code paste here-->
					<!--Edited on 28/7/15D class added landing-->
                	<div class="demo resp_demo"> 
    <!--Horizontal Tab-->
    <div class="horizontalTab  border_none">
        <ul class="resp-tabs-list new_tabs_list">
			<!--28/7/15D---class resp_heading added-->
            <span  class="heading_main resp_heading"> NEW ARRIVALS</span>
            <div class="border_bar" style="width:125px;"></div>
            <?php
            $varCatCount = 0;
           // pre($objPage->arrData['arrCategoryLatestPoducts']);
            foreach ($objPage->arrData['arrCategoryLatestPoducts'] as $key=> $catPro)
            {
                ?>
                        <li><?php echo strtoupper($catPro['arrCategory']['CategoryName']); ?></li>
                        <?php
                        if($varCatCount==8){
                            break;
                        }
               
                 $varCatCount++;
            }
            ?>
        </ul>
		<!--Edited on 27/7/15D-->
        <div class="customNavigation new_custom"> <a class="btn prev21"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-left.png" alt=""> </a> <a class="btn next21"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-right.png" alt=""></a> </div>
        <div class="resp-tabs-container">
            <?php
            $varCatCountTabs = 0;
            foreach ($objPage->arrData['arrCategoryLatestPoducts'] as $catPro)
            {
                $varCatCountTabs++;
             ?>
                        <div>
                            <div id="demo resp_demo">
                                <div class="">
                                    <div class="row">
                                        <div class="span12">
                                            <div  class="owl-carousel owl-demo21">
                                                <?php
                                                $i = 0;
                                                foreach ($catPro['arrProducts'] as $key => $val)
                                                {  //echo $val['Quantity'];
                                                    if ($val['Quantity'] == 0)
                                                    {
                                                        $varAddCartUrl = 'class="cart2 outOfStock info"';
                                                        $addToCart = OUT_OF_STOCK;
                                                        $addToCartImg1 = 'outofstock_icon.png';
                                                    }
                                                    else
                                                    {
                                                        $addToCart = ADD_TO_CART;
                                                        $addToCartImg1 = 'cart_icon.png';
                                                        if ($val['Attribute'] == 0)
                                                        {
                                                            $varAddCartUrl = 'href="' . $objCore->getUrl('common/ajax/ajax_cart.php', array('action' => 'addToCart', 'pid' => $val['pkProductID'], 'qty' => '1')) . '" class="info cart2 addCart ' . $val['pkProductID'] . '" onclick="addToCart(' . $val['pkProductID'] . ')" ';
                                                        }
                                                        else
                                                        {
                                                            $varAddCartUrl = 'href="' . $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')) . '#addCart" class="info cart2 addCart" ';
                                                        }
                                                    }
                                                    ?>

                                                    <!--Section Start-->
                                                    <div class="item">
                                                        <div class="view view-first">
                                                            <div class="image_new">
                                                                <?php
                                                                $varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/208x185/' . $val['ProductImage'];
                                                                ?>
                                                                <img width="<?php echo $varImageSize[0]; ?>" height="<?php echo $varImageSize[1]; ?>" class="lazy" data-src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" src="" alt="<?php echo $val['ProductName'] ?>"/>


                                                                <div class="new_heading">
                                                                    <?php
                                                                    echo $objCore->getProductName($val['ProductName'], 39);
                                                                    ?>
                                                                </div>
                                                                <?php
                                                                if ($val['discountPercent'] > 0 && $val['discountPercent'] < 99)
                                                                {
                                                                    ?>
                                                                    <div class="discount_new"><?php echo $val['discountPercent']; ?>%<span>OFF</span></div>
                                                                <?php } ?>
                                                                <div class="price_new"><?php echo $objCore->getFinalPrice($val['FinalPrice'], $val['DiscountFinalPrice'], $val['FinalSpecialPrice'], 0, 1); ?></div>
                                                                <!--<div class="unactive"><?php // echo $objCore->getProductName($val['ProductDescription'], 20);                                                    ?> </div>-->
                                                            </div>
                                                            <div class="mask">
                                                                <h2><a href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')); ?>"><?php
                                                echo $val['ProductName'];
                                                                ?></a></h2>
                                                                <p class="productPointer"><?php //echo $objCore->getProductName($val['ProductDescription'], 40);                                                    ?></p>
                                                                <div class="mask_box">
                                                                    <a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $val['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $val['pkProductID']; ?>');" class="info qckView quick QuickView<?php echo $val['pkProductID']; ?>" title="<?php echo QUICK_OVERVIEW; ?>"><?php echo QUICK_OVERVIEW; ?></a>
                                                                    <?php
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
                                                                            if (in_array($val['pkProductID'], $objPage->arrData['arrWishListOfCustomer'], true))
                                                                            {
                                                                                ?>
                                                                                <a href='#' class='info afterSavedInWishList' style='background:red;color:white'>Saved</a>
                                                                                <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <a href="#" class="info saveTowishlist saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" btcheck="saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" id="<?php echo $val['pkProductID']; ?>" Pid="<?php echo $val['pkProductID']; ?>">Save</a>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        else
                                                                        {
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
                                                <!--End Section Start-->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    
               
            }
            ?>
        </div>
    </div>
    <br />
</div>
                </div>
            </div><!--slide_wrapper-->
            <div class="slide_wrapper">
                <div class="demo pos_relative resp_demo">
                	<!--Your thumb slider code paste here-->
                	<?php
$totalPageCount = 0;
if (count($objPage->arrData['topSellingProducts']) > 0)
{
    ?>
    <div class="demo all_pro resp_demo">
        <!--            Horizontal Tab-->
        <div class="horizontalTab">            <ul class="resp-tabs-list">
                <span  class="heading_main resp_heading"> Best Seller</span>
                <div class="border_bar" style="width:105px"></div>
                <li style="cursor:default" >ALL PRODUCTS</li>
                <!--                  <li>MEN'S</li>
                          <li>WOMEN'S</li>-->
            </ul>
            <div class="customNavigation"> <a class="btn prev22"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-left.png" alt=""> </a> <a class="btn next22"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-right.png" alt=""></a> </div>
            <div class="resp-tabs-container">
                <div>
                    <div id="demo resp_demo">
                        <div class="">
                            <div class="row">
                                <div class="span12">
                                    <div  class="owl-demo22">
                                        <!--                                    Section Start-->
                                        <?php
                                        foreach ($objPage->arrData['topSellingProducts'] as $key => $val)
                                        {
                                            if ($val['Quantity'] == 0)
                                            {
                                                $varAddCartUrl = 'class="cart2 outOfStock info"';
                                                $addToCart = OUT_OF_STOCK;
                                                $addToCartImg1 = 'outofstock_icon.png';
                                            }
                                            else
                                            {
                                                $addToCart = ADD_TO_CART;
                                                $addToCartImg1 = 'cart_icon.png';
                                                if ($val['Attribute'] == 0)
                                                {
                                                    $varAddCartUrl = 'href="' . $objCore->getUrl('common/ajax/ajax_cart.php', array('action' => 'addToCart', 'pid' => $val['pkProductID'], 'qty' => '1')) . '" class="info cart2 addCart ' . $val['pkProductID'] . '" onclick="addToCart(' . $val['pkProductID'] . ')" ';
                                                }
                                                else
                                                {
                                                    $varAddCartUrl = 'href="' . $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')) . '#addCart" class="info cart2 addCart" ';
                                                }
                                            }
                                            ?>
                                            <div class="item">
                                                <div class="view view-first">
                                                    <div class="image_new">
                                                        <?php
                                                        //$varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/208x185/' . $val['ProductImage'];
                                                        ?>
                                                        <img width="<?php echo $varImageSize[0]; ?>" height="<?php echo $varImageSize[1] ?>" src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" alt="<?php echo $val['ProductName']; ?>"/>
                                                        <div class="new_heading">
                                                            <?php
                                                            echo $objCore->getProductName($val['ProductName'], 39);
                                                            ?></div>
                                                        <?php
                                                        if ($val['discountPercent'] > 0 && $val['discountPercent'] < 99)
                                                        {
                                                            ?>
                                                            <div class="discount_new"><?php echo $val['discountPercent']; ?>%<span>OFF</span></div>
                                                        <?php } ?>
                                                        <div class="price_new"><?php echo $objCore->getFinalPrice($val['FinalPrice'], $val['DiscountFinalPrice'], $val['FinalSpecialPrice'], 0, 1); ?></div>
                                                        <!--<div class="unactive"><?php //echo $objCore->getProductName($val['ProductDescription'], 20);                                                      ?> </div>-->
                                                    </div>
                                                    <div class="mask">
                                                        <h2><a href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')); ?>"><?php echo $val['ProductName']; ?></a></h2>
                                                        <p class="productPointer"></p>
                                                        <div class="mask_box">
                                                            <a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $val['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $val['pkProductID']; ?>');" class="info quick QuickView<?php echo $val['pkProductID']; ?>" title="<?php echo QUICK_OVERVIEW; ?>"><?php echo QUICK_OVERVIEW; ?></a>
                                                            <?php
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
                                                                    if (in_array($val['pkProductID'], $objPage->arrData['arrWishListOfCustomer'], true))
                                                                    {
                                                                        ?>
                                                                        <a href='#' class='info afterSavedInWishList' style='background:red;color:white'>Saved</a>
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                        <a href="#" class="info saveTowishlist saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" btcheck="saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" id="<?php echo $val['pkProductID']; ?>" Pid="<?php echo $val['pkProductID']; ?>">Save</a>
                                                                        <?php
                                                                    }
                                                                }
                                                                else
                                                                {
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
                                        <!-- End Section Start -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br />
    </div>
<?php } ?>
                </div>
            </div><!--slide_wrapper-->
            <div class="slide_wrapper">
                <div class="demo pos_relative resp_demo">
                	<!--Your thumb slider code paste here-->
                        <?php
                        if(count($objPage->arrData['arrHotDeals'])>0){
                        ?>
                	  <div class="demo resp_demo">
        <!--Horizontal Tab-->
        <div class="horizontalTab">
            <!--<div class="customNavigation" style=" position:absolute; margin-left:1070px; z-index:2147483647;"> <a class="btn prev23"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-left.png" alt=""> </a> <a class="btn next23"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-right.png" alt=""></a> </div>-->
            <ul class="resp-tabs-list">
                <span  class="heading_main resp_heading"> Most Discounted</span>
                <div class="border_bar" style=" width:164px"></div>
                <?php
                $varCatDisCount = 0;
                foreach ($objPage->arrData['arrHotDeals'] as $catPro)
                {
                    $varCatDisCount++;

                    if (count($catPro['arrCategory']) > 0)
                    {
                        
                            ?>
                            <li><?php echo strtoupper($catPro['arrCategory']['CategoryName']); ?></li>
                            <?php
                        
                    }
                }
                ?>
            </ul>
			<div class="customNavigation"> <a class="btn prev23"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-left.png" alt=""> </a> <a class="btn next23"><img src="<?php echo IMAGE_PATH_URL; ?>arrow_slider-right.png" alt=""></a> </div>
            <div class="resp-tabs-container">
                <?php
                $varCatMostCountTabs = 0;
                foreach ($objPage->arrData['arrHotDeals'] as $catPro)
                {
                    $varCatMostCountTabs++;

                    if (count($catPro['arrProducts']) > 0)
                    {
                        
                            ?>
                            <div>
                                <div id="demo resp_demo">
                                    <div class="">
                                        <div class="row">
                                            <div class="span12">
                                                <div  class="owl-carousel owl-demo23">
                                                    <!--Section Start-->

                                                    <?php
                                                    $i = 0;
                                                    foreach ($catPro['arrProducts'] as $key => $val)
                                                    { //pre($val); //echo $val['Quantity'];
                                                        if ($val['Quantity'] == 0)
                                                        {
                                                            $varAddCartUrl = 'class="cart2 outOfStock info"';
                                                            $addToCart = OUT_OF_STOCK;
                                                            $addToCartImg1 = 'outofstock_icon.png';
                                                        }
                                                        else
                                                        {
                                                            $addToCart = ADD_TO_CART;
                                                            $addToCartImg1 = 'cart_icon.png';
                                                            if ($val['Attribute'] == 0)
                                                            {
                                                                $varAddCartUrl = 'href="' . $objCore->getUrl('common/ajax/ajax_cart.php', array('action' => 'addToCart', 'pid' => $val['pkProductID'], 'qty' => '1')) . '" class="info cart2 addCart ' . $val['pkProductID'] . '" onclick="addToCart(' . $val['pkProductID'] . ')" ';
                                                            }
                                                            else
                                                            {
                                                                $varAddCartUrl = 'href="' . $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')) . '#addCart" class="info cart2 addCart" ';
                                                            }
                                                        }

                                                        //$varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/208x185/' . $val['ProductImage'];
                                                        // if(file_exists($varImgPath) && $val['ProductImage']!=''){
                                                        ?>

                                                        <!--Section Start-->
                                                        <div class="item">
                                                            <div class="view view-first">
                                                                <div class="image_new">
                                                                    <?php
                                                                    //$varImgPath = UPLOADED_FILES_SOURCE_PATH . 'images/products/208x185/' . $val['ProductImage'];

                                                                    if (file_exists($varImgPath) && $val['ProductImage'] != '')
                                                                    {
                                                                        ?>

                                                                        <img width="<?php echo $varImageSize[0]; ?>" height="<?php echo $varImageSize[1]; ?>" class="lazy" data-src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" src="" alt="<?php echo $val['ProductName'] ?>"/>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <!--<img src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/208x185'); ?>" alt="<?php echo $val['ProductName'] ?>"/>-->
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                        <img src="<?php echo IMAGES_URL; ?>guess.png" alt="">
                                                                    <?php }
                                                                    ?>
                                                                    <div class="new_heading">
                                                                        <?php
                                                                        echo $objCore->getProductName($val['ProductName'], 39);
                                                                        ?></div>
                                                                    <?php
                                                                    if ($val['discountPercent'] > 0 && $val['discountPercent'] < 99)
                                                                    {
                                                                        ?>
                                                                        <div class="discount_new"><?php echo $val['discountPercent']; ?>%<span>OFF</span></div>
                                                                    <?php } ?>
                                                                    <div class="price_new"><?php echo $objCore->getFinalPrice($val['FinalPrice'], $val['DiscountFinalPrice'], $val['FinalSpecialPrice'], 0, 1); ?></div>
                                                                    <!--<div class="unactive"><?php //echo $objCore->getProductName($val['ProductDescription'], 20);                                                      ?> </div>-->
                                                                </div>
                                                                <div class="mask">
                                                                    <h2><a href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'], 'add' => 'addCart')); ?>"><?php echo $val['ProductName']; ?></a></h2>
                                                                    <p class="productPointer"><?php //echo $objCore->getProductName($val['ProductDescription'], 40);                                                       ?></p>
                                                                    <div class="mask_box">
                                                                        <a href="<?php echo $objCore->getUrl('quickview.php', array('pid' => $val['pkProductID'], 'action' => 'quickView')); ?>" onclick="jscallQuickView('QuickView<?php echo $val['pkProductID']; ?>');" class="info qckView quick QuickView<?php echo $val['pkProductID']; ?>" title="<?php echo QUICK_OVERVIEW; ?>"><?php echo QUICK_OVERVIEW; ?></a>
                                                                        <?php
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
                                                                                if (in_array($val['pkProductID'], $objPage->arrData['arrWishListOfCustomer'], true))
                                                                                {
                                                                                    ?>
                                                                                    <a href='#' class='info afterSavedInWishList' style='background:red;color:white'>Saved</a>
                                                                                    <?php
                                                                                }
                                                                                else
                                                                                {
                                                                                    ?>
                                                                                    <a href="#" class="info saveTowishlist saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" btcheck="saveTowishlist_<?php echo $totalPageCount; ?>_<?php echo $val['pkProductID']; ?>" id="<?php echo $val['pkProductID']; ?>" Pid="<?php echo $val['pkProductID']; ?>">Save</a>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            else
                                                                            {
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

                                                    <!--End Section Start-->

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        
                    }
                }
                ?>
            </div>
        </div>
        <br />
    </div>
                        <?php } ?>
                </div>
            </div><!--slide_wrapper-->
            
            
            <div class="clear"></div>
            </div>
                    
                    <div class="body_container_inner_bg radius hid about" id="about_us">
                        <div class="profile_sec add_edit_pakage" style="word-break:break-all">

                            <ul class="profile_left">
                                <li>
                                    <p>Company Name<strong>:</strong></p>
                                    <small><?php 
                                    //pre($objPage->arrWholeSalerDetails);
                                    echo ucfirst($objPage->arrWholeSalerDetails['CompanyName']); ?></small>
                                </li>
                                <li>
                                    <p>Country<strong>:</strong></p>
                                    <small><?php echo $objPage->countryDetails[0]['name']; ?></small>
                                </li>
                                <li>
                                    <p>State<strong>:</strong></p>
                                    <small>
                                        <?php echo $objPage->regionName[0]['RegionName']; ?>
                                    </small>
                                </li>
                                <li>
                                    <p>City<strong>:</strong></p>
                                    <small><?php echo ucfirst($objPage->arrWholeSalerDetails['CompanyCity']); ?></small>
                                </li>
                                
                            </ul>
                            
                            <ul style="clear:both;">
                                <li>
                                    <span>
                                    <h2>About Company</h2></span>
                                    <p class="abCompaby">
                                    <?php
                                    echo nl2br($objPage->arrWholeSalerDetails['AboutCompany']);
                                    ?>
                                    </p>    
                                </li>
                            </ul>
                           
                        </div>
                    </div>
                     <div class="body_container_inner_bg radius hid about" id="services">
                        <div class="profile_sec add_edit_pakage" style="word-break:break-all">

                            <ul style="clear:both;">
                                <li>
                                    <span>
                                    <h2>About Services</h2></span>
                                    <p class="abCompaby">
                                    <?php
                                    //echo nl2br($objPage->arrWholeSalerDetails['AboutCompany']);
                                   echo $objPage->arrWholeSalerDetails['Services']<>''?nl2br($objPage->arrWholeSalerDetails['Services']):'No record found'; 
                                   //pre($objPage->arrWholeSalerDetails);
                                    ?>
                                    </p>    
                                </li>
                            </ul>
                            
                        </div>
                    </div>
                     <div class="body_container_inner_bg radius hid about" id="testimonials">
                        <div class="profile_sec add_edit_pakage" style="word-break:break-all">

                            <ul style="clear:both;">
                                <li>
                                    <span>
                                    <h2>About Testimonials</h2></span>
                                    
                                    <p class="abCompaby">
                                        <ul><?php
                                            foreach ($objPage->arrWholeSalerDetails['Testimonial'] as $testimonial) {
                                                echo '<li><b>&#8658;&ensp;&ensp;' . $testimonial['customerName'] . '</b> ' . $testimonial['ReviewDateAdded'] . '<p>Review &ensp;:&ensp;&ensp;  ' . $testimonial['Reviews'] . '</p></li>';
                                            };
                                            ?></ul>
                                    </p>
				    <br>
                                </li>
                            </ul>
                            
                        </div>
                    </div>
                    
                    <div class="body_container_inner_bg radius hid about" id="contact_us">
                        <div class="profile_sec add_edit_pakage" style="word-break:break-all">

                            <ul style="clear:both;">
                                <li>
                                    <span>
                                    <h2>Contact Us</h2></span>
                                    <p class="abCompaby">
                                        <div id="reply_message" class="reply_message">
                <form name="reply_message_form" id="reply_message_form" method="POST" action="">
                    <div class="left_m"><label><?php echo NAME; ?> <span class="red">*</span></label> :</div><div class="right_m"><input type="text" name="frmName" value="" class="validate[required]" /></div>                    
                    <div class="left_m"><label><?php echo EMAIL; ?>  <span class="red">*</span></label> :</div><div class="right_m"><input type="text" name="frmEmail" value="<?php echo $_SESSION['sessUserInfo']['email']; ?>" class="validate[required,custom[email]]" /></div>                    
                    <div class="left_m"><label><?php echo SUBJECT; ?>  <span class="red">*</span></label>:</div><div class="right_m"><input type="text" name="frmSubject" value="" class="validate[required]" /></div>

                    <div class="left_m"><label><?php echo MESSAGE; ?>  <span class="red">*</span></label>:</div><div class="right_m"><textarea name="frmMessage" class="validate[required]" rows="9" cols="35"></textarea></div>

                    <div class="left_m">&nbsp;</div><div class="right_m">
                        <input type="submit" name="submit" value="Send" class="submit3" style="padding:10px 15px 9px !important;"/>
<!--                        <input type="button" name="cancel" value="Cancel" class="cancel" id="compose_cancel" />                          -->
                    </div>                    
                    <input type="hidden" name="frmWholeSalerEmailID" value="<?php echo $objPage->arrWholeSalerDetails['CompanyEmail']; ?>" />
                    <input type="hidden" name="frmWholeSalerEmailName" value="<?php echo $objPage->arrWholeSalerDetails['CompanyName']; ?>" />
                </form>
            </div>
                                    </p>    
                                </li>
                            </ul>
                            
                        </div>
                    </div>
                    <div class="body_container_inner_bg radius hid ndis" id="wh_product">
                <div class="content">
                    
                </div>
            </div>
                </div>
            </div>
        </div>        


        <div style="display: none;">
            <div id="reply_message" class="reply_message">
                <form name="reply_message_form" id="reply_message_form" method="POST" action="">
                    <div class="left_m"><label><?php echo NAME; ?> <span class="red">*</span></label> :</div><div class="right_m"><input type="text" name="frmName" value="" class="validate[required]" /></div>                    
                    <div class="left_m"><label><?php echo EMAIL; ?>  <span class="red">*</span></label> :</div><div class="right_m"><input type="text" name="frmEmail" value="<?php echo $_SESSION['sessUserInfo']['email']; ?>" class="validate[required,custom[email]]" /></div>                    
                    <div class="left_m"><label><?php echo SUBJECT; ?>  <span class="red">*</span></label>:</div><div class="right_m"><input type="text" name="frmSubject" value="" class="validate[required]" /></div>

                    <div class="left_m"><label><?php echo MESSAGE; ?>  <span class="red">*</span></label>:</div><div class="right_m"><textarea name="frmMessage" class="validate[required]" rows="9" cols="35"></textarea></div>

                    <div class="left_m">&nbsp;</div><div class="right_m">
                        <input type="submit" name="submit" value="Send" class="submit3" style="padding:10px 15px 9px !important;"/>
                        <input type="button" name="cancel" value="Cancel" class="cancel" id="compose_cancel" />                          
                    </div>                    
                    <input type="hidden" name="frmWholeSalerEmailID" value="<?php echo $objPage->arrWholeSalerDetails['CompanyEmail']; ?>" />
                    <input type="hidden" name="frmWholeSalerEmailName" value="<?php echo $objPage->arrWholeSalerDetails['CompanyName']; ?>" />
                </form>
            </div>
        </div>
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
        <?php include_once 'common/inc/footer.inc.php'; ?>
        
        	
<!--		<script src="<?php echo JS_PATH ?>jquery-1.9.1.min.js"></script>-->
		<script src="<?php echo JS_PATH ?>owl.carousel.js"></script>

		<script>
			$(document).ready(function() {

				$("#owl-demo").owlCarousel({
					autoPlay : 2500,
					stopOnHover : true,
					navigation : true,
					slideSpeed : 300,
					paginationSpeed : 400,
					singleItem : true,
					autoplay : 1000

					// "singleItem:true" is a shortcut for:
					// items : 1,
					// itemsDesktop : false,
					// itemsDesktopSmall : false,
					// itemsTablet: false,
					// itemsMobile : false

				});
                                 var i = $(".owl-demo21");
    i.owlCarousel({
        items :4, //10 items above 1000px browser width
        itemsDesktop : [1000,4], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,4], // 3 items betweem 900px and 601px
        itemsTablet: [767,4], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
    }), $(".next21").click(function() {
        i.trigger("owl.next")
    }), $(".prev21").click(function() {
        i.trigger("owl.prev")
    });
     var y = $(".owl-demo22");
    y.owlCarousel({
        items :4, //10 items above 1000px browser width
        itemsDesktop : [1000,4], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,4], // 3 items betweem 900px and 601px
        itemsTablet: [767,4], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
    }), $(".next22").click(function() {
        y.trigger("owl.next")
    }), $(".prev22").click(function() {
        y.trigger("owl.prev")
    });
     var z = $(".owl-demo23");
    z.owlCarousel({
        items :4, //10 items above 1000px browser width
        itemsDesktop : [1000,4], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,4], // 3 items betweem 900px and 601px
        itemsTablet: [767,4], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
    }), $(".next23").click(function() {
        z.trigger("owl.next")
    }), $(".prev23").click(function() {
        z.trigger("owl.prev")
    });
			

			$(".menu").click(function() {
				$(".nav").stop().slideToggle(350);

			});
                        });
		</script>
		<style>
		    .categorySubMenuProduct:hover{
			text-decoration: underline !important;
		    }
		</style>
    </body>
</html>