<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_TEMPLATE_CTRL;
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;

$templateId = $_REQUEST['tmpid'];
$templateName = $templateId;
$wholasaler = $objPage->arrwholesalerDetails[0];
$TopSellingCatProduct = $objPage->arrwholesalerTopSellingByCategory;

//pre($wholasaler['Sliderimage']);
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $wholasaler['CompanyName']; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content=""/>
        <meta name="copyright" content=""/>
          <link rel="stylesheet" href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/skeleton.css">
        <link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/kickstart.css" media="all"/>
        <link href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/owl.carousel.css" rel="stylesheet">
        <link href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/owl.theme.css" rel="stylesheet">
        <!-- KICKSTART -->
        <link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/style.css" media="all"/>
        <link href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/templateMenu.css" rel="stylesheet" type="text/css" />
        <!-- CUSTOM STYLES -->
        <script type="text/javascript" src="<?php echo JS_PATH ?>validation/jquery-1.8.2.min.js" ></script>
        <link href='http://fonts.googleapis.com/css?family=Exo:400,700,800' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="<?php echo TEMPLATE_PATH . $templateName; ?>/js/kickstart.js"></script>
        <script src="<?php echo TEMPLATE_PATH . $templateName; ?>/js/owl.carousel.js"></script>
        <script src="<?php echo TEMPLATE_PATH . $templateName; ?>/js/template-custom.js">     </script>
        <script type="text/javascript">
             var wID='<?php echo $wholasaler['pkWholesalerID']?>'; //alert(wID);
            SITE_ROOT_URL='<?php echo SITE_ROOT_URL; ?>'
        </script>
         <script type="text/javascript" src="<?php echo JS_PATH ?>template9menujs.js" ></script>
	 <script>
	    $('document').ready(function() {               
		$('.categorySubMenuProduct').live("click",function(){
                    //alert("SGf");
		    var listItems = $("div.nav").find('ul');
                    //alert(listItems.html());
                    listItems.each(function(idx, li) {
			//alert($(this).attr('class'));
                        $(this).find('li').removeClass('current');
                    });
                    $('.template_men').parent().addClass('current');
                });    
                //$('.scroll-pane').jScrollPane();
            });
	</script>
        <!-- KICKSTART -->
    </head>
    <body>
        <!-- Menu Horizontal -->
        <div class="grid headerGrid">
            <div class="col_3 logoField companyname">
                <h2><?php echo ($wholasaler['CompanyName']) ?></h2>
            </div>
            <div class="col_9 nav">
                <ul class="menu">
                    <li class="current">
                        <a href="javascript:void(0)" onclick="showWholesalerContent('home')" id="nav_home">Home</a>
                        <span class="menu_span"></span>
                    </li>
                    <li>
			<a  href="javascript:void(0)" onmouseenter="showWholesalerMenu('Menubar',event)" onmouseout="hideWholesalerMenu('Menubar',event)" class="template_men hand_remove">My Shop</a>
                                             <span class="menu_span"></span>   
                            <?php require_once 'template_menu.php'; ?>
                          </li>
                    <li>                       
                        <a href="javascript:void(0)" onclick="showWholesalerContent('about_us')" id="nav_about_us">About Us</a>
                        <span class="menu_span"></span>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="showWholesalerContent('services')" id="nav_services">Services</a>
                        <span class="menu_span"></span>
                    </li>
<!--                    <li>
                        <a href="javascript:void(0)" onclick="showWholesalerContent('policy')" id="nav_policy">Policy</a>
                        <span class="menu_span"></span>
                    </li>-->
                    <li>
                        <a href="javascript:void(0)" onclick="showWholesalerContent('testimonials')" id="nav_testimonials">Testimonials</a>
                        <span class="menu_span"></span>
                    </li>
<!--                    <li>
                        <a href="javascript:void(0)" onclick="showWholesalerContent('shipping')" id="nav_shipping">Shipping</a>
                        <span class="menu_span"></span>
                    </li>-->
                    <li>
                        <a href="javascript:void(0)" onclick="showWholesalerContent('contact_us')" id="nav_contact_us">Contact Us</a>
                        <span class="menu_span"></span>
                    </li>
                </ul>
            </div></div>
        
        <div class="bg_1">
            <div class="grid">
                <div class="col_12">
                    <div id="slideshow-example" class="tab-content">
                        <div class="left_half">

                            <?php
                            if (file_exists(UPLOADED_FILES_SOURCE_PATH . "images/wholesaler_logo/" . $wholasaler['wholesalerLogo']) && isset($wholasaler['wholesalerLogo']) && $wholasaler['wholesalerLogo'] != '')
                            {
                                ?>
                                <img class="logo" src="<?php echo UPLOADED_FILES_URL . "images/wholesaler_logo/" . $wholasaler['wholesalerLogo']; ?>" alt="<?php echo $wholasaler['CompanyName']; ?>"/>
                                <?php
                            }
                            else
                            {
                                ?>
                                <img class="logo" src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/logo.png" alt="Company Logo"/>
                            <?php } ?>
                            <p>
                                <?php echo strlen($wholasaler['AboutCompany']) > 340 ? substr($wholasaler['AboutCompany'], 0, 340) . "..." : $wholasaler['AboutCompany']; ?>
                                <a href="javascript:void(0)" class="readmore" onclick="showWholesalerContent('about_us')" >Read More</a>
                            </p>

                        </div>
                        <div class="right_half">
                            <div id="owl-demo" class="owl-carousel">
                                <?php
                                if (count($wholasaler['Sliderimage']) > 0)
                                {
                                    foreach ($wholasaler['Sliderimage'] as $slider)
                                    {
                                        if (file_exists(UPLOADED_FILES_SOURCE_PATH . "images/wholesaler_slider/" . $slider['sliderImage']))
                                        {
                                            ?>
                                            <div class="item"><img src="<?php echo UPLOADED_FILES_URL . "images/wholesaler_slider/" . $slider['sliderImage']; ?>" alt="<?php echo $wholasaler['CompanyName']; ?>"></div>
                                            <?php
                                        }
                                    }
                                }
                                else
                                {
                                    ?>
                                    <div class="item"><img src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/1.jpg" alt="pic"></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div class="min-height-box ndis" id="wh_product"><div class="content"></div></div>
        <div class="grid">
            <div class="col_12" style="margin:0px">
                <div id="home" class="main-div">
                    <ul class="tabs">
                        <?php
                        $temp = 1;
                        foreach (array_slice($TopSellingCatProduct, 0, 4) as $catPro)
                        {
                            if($temp==1){
                                    $cat_name= $catPro['arrCategory']['CategoryName'];
                                }
                            ?>
                            <li class="first">
                                <a href="#<?php echo strtoupper($catPro['arrCategory']['CategoryName']); ?>">
                                    <div class="cat">
                                        <?php echo strtoupper($catPro['arrCategory']['CategoryName']); ?>
                                    </div>
                                    <div class="image">
                                        <?php
                                        if ($catPro['arrCategory']['categoryImage'])
                                        {
                                            ?>
                                            <img style="width:186px;height:293px;"  src="<?php echo $catPro['arrCategory']['categoryImageUrl'] . $catPro['arrCategory']['categoryImage']; ?>" alt="<?php echo $catPro['arrCategory']['CategoryName'] ?>"/>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <img src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/cat_<?php echo ($temp % 2 == 0) ? '2' : '1'; ?>.png" alt="">
                                        <?php }
                                        ?>

                                    </div>
                                    <p class="cat_p">
                                        <?php
                                        if ($catPro['arrCategory']['CategoryDescription'])
                                        {
                                            echo strlen($catPro['arrCategory']['CategoryDescription']) > 150 ? substr($catPro['arrCategory']['CategoryDescription'], 0, 150) . "..." : $catPro['arrCategory']['CategoryDescription'];
                                        }
                                        ?>
                                    </p>
                                    <!--<h5 onclick="">Learn More</h5>-->

                                </a>
                            </li>
                            <?php
                            $temp++;
                        }
                        ?>    

                    </ul>
                    <?php
                    $varTemp = 1;

                    foreach (array_slice($TopSellingCatProduct, 0, 10) as $catPro)
                    {
                        ?>
                        <div id="<?php echo strtoupper($catPro['arrCategory']['CategoryName']); ?>" class="tab-content clearfix" >
                            <div class="innerheader">
                                <h2 class="innerheading asd" ><?php echo $cat_name  ?><?php /* <a target="_blank" href="<?php echo SITE_ROOT_URL . 'category/all/0/' . $wholasaler['CompanyName'] ?>" class="viewAll">View All</a>*/?></h2>
                                <?php
                                if (count($catPro['arrProducts']) > 3)
                                {
                                    ?>
                                    <div class="owlicons customNavigation">
                                        <ul>
                                            <li class="prev<?php echo $varTemp; ?>"><img src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/prev.png" alt="prev"></li>
                                            <li class="next<?php echo $varTemp; ?>"><img src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/next.png" alt="next"></li>
                                        </ul>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div id="owl-demo<?php echo $varTemp; ?>" class="owl-carousel">
                                <?php
                                foreach ($catPro['arrProducts']as $val)
                                {
                                    ?>

                                    <div class="item">
                                        <div class="innerProduct">
                                            <div class="imgBox">
                                                <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'])); ?>">
                                                    <img width="<?php echo $varImageSize[0]; ?>" height="<?php echo $varImageSize[1]; ?>" class="lazy" src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" alt="<?php echo $val['ProductName'] ?>"/>
                                                </a>
                                                <?php
                                                if ($val['discountPercent'] > 0 && $val['discountPercent'] < 99)
                                                {
                                                    ?>
                                                    <div class = "absdiscount">
                                                        <?php
                                                        echo $val['discountPercent'] . '% <br/>OFF';
                                                        ?>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="productName">
                                                <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'])); ?>"><?php echo strlen($val['ProductName']) > 16 ? substr($val['ProductName'], 0, 15) . "..." : $val['ProductName']; ?></a>
                                            </div>
                                            <div class="moreAbout">   <?php echo $objCore->getFinalPrice($val['FinalPrice'], $val['DiscountFinalPrice'], $val['FinalSpecialPrice'], 0, 1); ?></div>
                                            <div class="full_width">
                                                <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'])); ?>" class="readMore">read more</a>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                }
                                ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <?php
                        $varTemp++;
                    }
                    ?>

                </div>
                <div class="segment main_div ndis" id="wh_product"></div>
                <div id="services" class="segment ndis main-div">
                    <div class="col_12">
                        <div class="innerheader">
                            <h2 class="innerheading">Services</h2>
                        </div>
                        <p><?php echo ($wholasaler['Services']) ? $wholasaler['Services'] : 'NA'; ?></p>
                    </div>
                </div>

                <div id="policy" class="segment ndis main-div">
                    <div class="col_12">
                        <div class="innerheader">
                            <h2 class="innerheading">policy</h2>
                        </div>
                        <p>
                            <?php
                            if ($wholasaler['BusinessPlan'])
                            {
                                ?>
                            <ul>
                                <?php
                                foreach ($wholasaler['BusinessPlan'] as $BusinessPlan)
                                {
                                    if (file_exists(UPLOADED_FILES_SOURCE_PATH . 'files/wholesaler/' . $BusinessPlan['DocumentName']))
                                    {
                                        echo '<li><a href="' . UPLOADED_FILES_URL . 'files/wholesaler/' . $BusinessPlan['DocumentName'] . '" target="_blank">' . $BusinessPlan['FileName'] . '</a></li>';
                                    }
                                }
                                ?>
                            </ul>
                            <?php
                        }
                        else
                        {
                            echo 'NA';
                        }
                        ?>
                        </p>
                    </div>
                </div>
                <div id="testimonials" class="segment ndis main-div">
                    <div class="col_12">
                        <div class="innerheader">
                            <h2 class="innerheading">Testimonial</h2>
                        </div>
                        <p>
                            <?php
                            if ($wholasaler['Testimonial'])
                            {
                                echo "<ul>";

                                foreach (array_slice($wholasaler['Testimonial'], 0, 10) as $testimonial)
                                {
                                    echo '<li><b>' . $testimonial['customerName'] . '</b> ' . $testimonial['ReviewDateAdded'] . '' . $testimonial['Reviews'] . '</li>';
                                }
                                echo "</ul>";
                            }
                            else
                            {
                                echo "NA";
                            }
                            ?>
                        </p>
                    </div>
                </div>
                <div id="shipping" class="segment ndis main-div">
                    <div class="col_12">
                        <div class="innerheader">
                            <h2 class="innerheading">Shipment</h2>
                        </div>
                        <p>
                            <?php
                            if ($wholasaler['Shipping'])
                            {
                                ?>
                            <ul>
                                <?php
                                foreach ($wholasaler['Shipping'] as $shipping)
                                {
                                    echo '<li><p>' . $shipping['ShippingTitle'] . '</p></li>';
                                }
                                ?>
                            </ul>
                            <?php
                        }
                        else
                        {
                            echo 'NA';
                        }
                        ?>
                        </p>
                    </div>
                </div>
                <div id="contact_us" class="segment ndis main-div">
                    <div class="col_12">
                        <div class="innerheader">
                            <h2 class="innerheading">Contact Form</h2>
                        </div>
                       <?php /*<p>
                            <label>Name: </label><?php echo $wholasaler['ContactPersonName']; ?>(<?php echo $wholasaler['ContactPersonPosition']; ?>)<br/>
                            <label>Phone: </label><?php echo $wholasaler['ContactPersonPhone']; ?><br/>
                            <label>Email: </label><?php echo $wholasaler['ContactPersonEmail']; ?><br/>
                            <label>Address: </label><?php echo $wholasaler['ContactPersonAddress']; ?><br/>
                        </p> */ ?>
                           <div class="four columns left_float contact_form_heading" >
                      
                        <p id="messageTemplate"  style="display:none;color:green">Message sent! </p>
                        <div style="clear:both; display: block;"></div>
                        <form class="pure-form pure-form-aligned" method="post" action="" name="whlContactForm" id="whlContactForm" >
                            <input type="hidden" name="whlemail" id="whlemail" value="<?php echo $wholasaler['ContactPersonEmail'] ?>">
                            <fieldset class="contform_fieldset">
                                <div class="pure-control-group">
                                    <input id="name" type="text" placeholder="Name" name="name" onfocus="onKeySignUp(this.id);">
                                </div>
                                <div class="pure-control-group">
                                    <input id="email" type="email" placeholder="Email Address" name="email" onfocus="onKeySignUp(this.id);">
                                </div>
                                <div class="pure-control-group">
                                    <textarea  name="message" id="message" cols="" rows="" placeholder="Message" onfocus="onKeySignUp(this.id);"></textarea>
                                </div>
                                <div class="pure-controls">
                                    <input type="button" id="temSubmit" value="Send" name="submit" class="submit_btn"  onclick="validateWhlFrm()"/>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    </div>
                </div>
                <div id="about_us" class="segment ndis main-div">
                    <div class="col_12">
                        <div class="innerheader">
                            <h2 class="innerheading">About Us</h2>
                        </div>
                        <p><?php echo ($wholasaler['AboutCompany']); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- END GRID -->
        <div class="clear">
        </div>
    <style>
	.categorySubMenuProduct:hover{
	    text-decoration: underline !important;
	}
	.contform_fieldset textarea {
	    height:200px;
	    max-height:160px !important;
	}
    </style>
    </body>
</html>