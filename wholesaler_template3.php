<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_TEMPLATE_CTRL;
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;

$templateId = $_REQUEST['tmpid'];
$templateName = $templateId;
$wholasaler = $objPage->arrwholesalerDetails[0];
//pre($wholasaler['Topproduct']);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Wholesaler template</title>
        <meta name="author"  />
         <link rel="stylesheet" href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/skeleton.css">
        <link href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/style.css" rel="stylesheet" type="text/css"  />
        <link href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/owl.carousel.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/owl.theme.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/media.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/templateMenu.css" rel="stylesheet" type="text/css" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'/>
        <script type="text/javascript" src="<?php echo JS_PATH ?>validation/jquery-1.8.2.min.js" ></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>wholersaler_template_jsscrollpane.js"></script>
        <!-- Date: 2014-08-25 -->

        <script>
             SITE_ROOT_URL='<?php echo SITE_ROOT_URL; ?>';
          var wID='<?php echo $wholasaler['pkWholesalerID']?>'; //alert(wID);
            function showWholesalerContent1(conId)
            { //alert(conId);
                conId!='home'?$('.main_div').hide():$('.main_div').show();
                $('.min-height-box').css({'display':'none'});	
                $('#'+conId).css({'display':'block'});
                $('.nav').find('li').removeClass();
                $('#nav_'+conId).parent().addClass('activeli active');
            }
            $('document').ready(function() {
                $('.template_support').on('click', function(e) {
                    var uType = $.trim($(this).attr('tp'));
                    var alertTypeClass = $('*').hasClass('alertUserTypeTemplate') ? '1' : '2';
                    if (uType != 'customer') {
                        if (alertTypeClass == '2') {
                            $(this).parent().parent().after('<div class="alertUserTypeTemplate" style="clear:both;"><span style="color:red;font-size:12px">Please login as customer to support.</span></div>');
                        }
                        setTimeout(function() {
                            $('.alertUserTypeTemplate').remove();
                        }, 8000);
                        return false;
                    }
                });
		$('.categorySubMenuProduct').live("click",function(){
                    
		    var listItems = $("div.nav").find('ul');
                    //alert(listItems.html());
                    listItems.each(function(idx, li) {
			//alert($(this).attr('class'));
                        $(this).find('li').removeClass('activeli');
                    });
                    $('.template_men').parent().addClass('activeli');
                });    
                $('.scroll-pane').jScrollPane();
            });
        </script>
        <script src="<?php echo TEMPLATE_PATH . $templateName; ?>/js/template-custom.js">     </script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>template3menujs.js" ></script>
    </head>
    <body>

        <div class="outer_container">
            <div class="header">
                <div class="logo">
                    <?php
                    if (file_exists(UPLOADED_FILES_SOURCE_PATH . "images/wholesaler_logo/" . $wholasaler['wholesalerLogo']) && isset($wholasaler['wholesalerLogo']) && $wholasaler['wholesalerLogo'] != '')
                    {
                        ?>
                        <img src="<?php echo UPLOADED_FILES_URL . "images/wholesaler_logo/" . $wholasaler['wholesalerLogo']; ?>" alt="<?php echo $wholasaler['CompanyName']; ?>" style="margin-left: 12px;float: left;display: block"/>
                        <?php
                    }
                    else
                    {
                        ?>
                        <img src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/logo.png" alt="company Logo" style="margin-left: 12px;float: left;display: block"/>
                    <?php } ?>
                </div>

            </div>
            <div class="menu">
                <h3>Menu</h3>
            </div>
            <div class="nav">

                <ul>
                    <li class="activeli active">
                        <a href="javascript:void(0)" onclick="showWholesalerContent1('home')" id="nav_home">Home</a>
                    </li>
                    <li>
			<a  href="javascript:void(0)" onmouseenter="showWholesalerMenu('Menubar',event)" onmouseout="hideWholesalerMenu('Menubar',event)" class="template_men hand_remove">My Shop</a>
                                                
                            <?php require_once 'template_menu.php'; ?>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="showWholesalerContent('about_us');showWholesalerContent1('about_us')" id="nav_about_us">About Us</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="showWholesalerContent('services');showWholesalerContent1('services')" id="nav_services">Services</a>
                    </li>
<!--                    <li>
                        <a href="javascript:void(0)" onclick="showWholesalerContent('business_plan')" id="nav_business_plan">Business Plan</a>
                    </li>-->
                    <li>
                        <a href="javascript:void(0)" onclick="showWholesalerContent('testimonials');showWholesalerContent1('testimonials')" id="nav_testimonials">Testimonials</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="showWholesalerContent('contact_us');showWholesalerContent1('contact_us')" id="nav_contact_us">Contact Us</a>
                    </li>
<!--                    <li>
                        <a href="javascript:void(0)" onclick="showWholesalerContent('shipping')" id="nav_shipping">Shipping</a>
                    </li>-->
                </ul>

            </div>
            <div class="slide_section">

                <div class="slideshow">

                    <div id="owl-demo" class="owl-carousel">

                        <?php
                        if (count($wholasaler['Sliderimage']) > 0)
                        {
                            foreach ($wholasaler['Sliderimage'] as $slider)
                            {
                                if (file_exists(UPLOADED_FILES_SOURCE_PATH . "images/wholesaler_slider/" . $slider['sliderImage']))
                                {
                                    ?>							
                                    <div class="item"><img src="<?php echo UPLOADED_FILES_URL . "images/wholesaler_slider/" . $slider['sliderImage']; ?>" alt="<?php echo $wholasaler['CompanyName']; ?>">
                                        <h2 class="big"><?php echo $wholasaler['CompanyName']; ?></h2>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        else
                        {
                            ?>
                            <div class="item"><img src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/slide1.jpg" alt="pic">
                                <h2 class="big"><?php echo $wholasaler['CompanyName']; ?></h2>
                            </div>
                        <?php } ?>


                    </div>

                </div>

            </div>

            <div class="padd_content main_div">
                <div class="offers">
                    
                    <?php
                    if (count($wholasaler['NewproductRan']) > 0)
                    {
                        ?>
                        <h3>New Arrivals<?php/*  <a target="_blank" href="<?php echo SITE_ROOT_URL . 'category/all/0/' . $wholasaler['CompanyName'] ?>" class="viewAll">View All</a>*/?></h3>
                        <?php
                        $randaomValue = $wholasaler['NewproductRan'];
                        //print_r($randaomValue);
                        foreach ($randaomValue as $key => $v)
                        {
                            ?>
                            <div class="offers_sec">
                                <div class="offer_img">
                                    <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $v['pkProductID'], 'name' => $v['ProductName'], 'refNo' => $v['ProductRefNo'])); ?>"><img src="<?php echo $objCore->getImageUrl($v['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" alt="<?php echo $v['ProductName'] ?>"/></a>
                                </div>
                                <div class="offer_content">
                                    <h3><a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $v['pkProductID'], 'name' => $v['ProductName'], 'refNo' => $v['ProductRefNo'])); ?>"><?php echo strtoupper($v['ProductName']) ?></a></h3>
                                    <p> <?php echo strlen($v['ProductDescription']) > 200?substr($v['ProductDescription'], 0, 200) . ' ..<a target="_blank" href="'.$objCore->getUrl('product.php', array('id' => $v['pkProductID'], 'name' => $v['ProductName'], 'refNo' => $v['ProductRefNo'])).'">view details</a>':$v['ProductDescription']; ?></p>
                                    <p class="price">
                                        <?php
                                        echo $objCore->getFinalPrice($v['FinalPrice'], $v['DiscountFinalPrice'], $v['FinalSpecialPrice'], 0, 1);
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                        <?php
                    if (count($wholasaler['Topproduct']) > 0)
                    {
                        ?>
                        <h3>Top Selling</h3>
                        <?php
                        $randaomValue = $wholasaler['Topproduct'];
                        //print_r($randaomValue);
                        foreach ($randaomValue as $key => $v)
                        {
                            ?>

                            <div class="offers_sec">
                                <div class="offer_img">
                                    <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $v['pkProductID'], 'name' => $v['ProductName'], 'refNo' => $v['ProductRefNo'])); ?>"><img src="<?php echo $objCore->getImageUrl($v['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" alt="<?php echo $v['ProductName'] ?>"/></a>
                                </div>
                                <div class="offer_content">
                                    <h3><a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $v['pkProductID'], 'name' => $v['ProductName'], 'refNo' => $v['ProductRefNo'])); ?>"><?php echo strtoupper($v['ProductName']) ?></a></h3>
                                    <p> <?php echo strlen($v['ProductDescription']) > 200?substr($v['ProductDescription'], 0, 200) . ' ..<a target="_blank" href="'.$objCore->getUrl('product.php', array('id' => $v['pkProductID'], 'name' => $v['ProductName'], 'refNo' => $v['ProductRefNo'])).'">view details</a>':$v['ProductDescription']; ?></p>
                                    <p class="price">
                                        <?php
                                        echo $objCore->getFinalPrice($v['FinalPrice'], $v['DiscountFinalPrice'], $v['FinalSpecialPrice'], 0, 1);
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <h2 class="heading">About Us</h2>
                <p><?php echo (strlen($wholasaler['AboutCompany']) > 300 ? substr($wholasaler['AboutCompany'], 0, 300) . '...<a href=\'javascript:void(0)\' onclick=\'showWholesalerContent("about_us")\'>Read More</a>' : $wholasaler['AboutCompany']); ?></p>
            </div>

            <div class="min-height-box" id="about_us">
                <div class="padd_content">
                    <h2 class="heading">About Us</h2>
                    <div class="scroll-pane">
                        <p><?php echo $wholasaler['AboutCompany']; ?></p>
                    </div>
                </div>
            </div>
            <div class="min-height-box ndis" id="services">
                <div class="padd_content">
                    <h2 class="heading">Services</h2>
                    <p><?php echo $wholasaler['Services']; ?></p>
                </div>
            </div>
            <div class="min-height-box ndis" id="shipping">
                <div class="padd_content">
                    <h2 class="heading">Shipping</h2>
                    <p><ul><?php
                    foreach ($wholasaler['Shipping'] as $shipping)
                    {
                        echo '<li>' . $shipping['ShippingTitle'] . '</span></li>';
                    }
                    ?></ul></p>
                </div>
            </div>
            <div class="min-height-box ndis" id="business_plan">
                <div class="padd_content">
                    <h2 class="heading">Business Plan</h2>
                    <p><ul><?php
                        foreach ($wholasaler['BusinessPlan'] as $BusinessPlan)
                        {
                            if (file_exists(UPLOADED_FILES_SOURCE_PATH . 'files/wholesaler/' . $BusinessPlan['DocumentName']))
                            {
                                echo '<li><a href="' . UPLOADED_FILES_URL . 'files/wholesaler/' . $BusinessPlan['DocumentName'] . '" target="_blank">' . $BusinessPlan['FileName'] . '</a></li>';
                            }
                        };
                    ?></ul></p>
                </div>
            </div>
            <div class="min-height-box ndis" id="testimonials">
                <div class="padd_content">
                    <h2 class="heading">Testimonials</h2>
                    <p><ul><?php
                        foreach ($wholasaler['Testimonial'] as $testimonial)
                        {
                            echo '<li><b>' . $testimonial['customerName'] . '</b> ' . $testimonial['ReviewDateAdded'] . '<p>' . $testimonial['Reviews'] . '</p></li>';
                        };
                    ?></ul></p>
                </div>
            </div>
            <div class="min-height-box ndis" id="shipping">
                <div class="padd_content">
                    <h2 class="heading">Shipping</h2>
                    <p><ul><?php
                        foreach ($wholasaler['Shipping'] as $shipping)
                        {
                            echo '<li>' . $shipping['ShippingTitle'] . '</span></li>';
                        }
                    ?></ul></p>
                </div>
            </div>
            <div class="min-height-box ndis" id="contact_us">
                <div class="padd_content">
                    <?php /* <h2 class="heading">Contact Us</h2>
                    <p><label>Name: </label><?php echo $wholasaler['ContactPersonName']; ?>(<?php echo $wholasaler['ContactPersonPosition']; ?>)<br/>
                        <label>Phone: </label><?php echo $wholasaler['ContactPersonPhone']; ?><br/>
                        <label>Email: </label><?php echo $wholasaler['ContactPersonEmail']; ?><br/>
                        <label>Address: </label><?php echo $wholasaler['ContactPersonAddress']; ?><br/>
                    </p> */?>
                     <h2 class="heading contact_form_heading">Contact Form</h2>
                      <div class="four columns left_float contact_form_margin">
                       
                        <p id="messageTemplate" style="display:none;color:green">Message sent! </p>
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
                                    <input type="button" id="temSubmit" value="Send" name="submit" class="pure-button pure-button-primary" onclick="validateWhlFrm()"/>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="min-height-box ndis" id="wh_product"><div class="content"></div></div>
            <div class="footer">
                <div class="footer_left" style="width:100%">
                    <div class="side_padded">
                        <div class="logo">
                            <?php
                            if (file_exists(UPLOADED_FILES_SOURCE_PATH . "images/wholesaler_logo/" . $wholasaler['wholesalerLogo']))
                            {
                                ?>
<!--                                <img src="<?php echo UPLOADED_FILES_URL . "images/wholesaler_logo/" . $wholasaler['wholesalerLogo']; ?>" alt="<?php echo $wholasaler['CompanyName']; ?>" style="margin-left: 12px;float: left;display: block"/>-->
                                <?php
                            }
                            else
                            {
                                ?>
<!--                                <img src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/logo.png" alt="company Logo" style="margin-left: 12px;float: left;display: block"/>-->
                            <?php } ?>
                            <h2><?php echo ($wholasaler['CompanyName']); ?></h2>
                        </div>


                        <ul class="disclaim">
                            <li><a href="javascript:void(0)" onclick="showWholesalerContent1('home')">Home</a></li>
                            <li><a href="javascript:void(0)" onclick="showWholesalerContent('about_us');showWholesalerContent1('about_us')">About</a></li>
                            <li><a href="javascript:void(0)" onclick="showWholesalerContent('services');showWholesalerContent1('services')">Services</a></li>
<!--                            <li><a href="javascript:void(0)" onclick="showWholesalerContent('business_plan')">Business Plan</a></li>-->
                            <li><a href="javascript:void(0)" onclick="showWholesalerContent('testimonials');showWholesalerContent1('testimonials')">Testimonials</a></li>
<!--                            <li><a href="javascript:void(0)" onclick="showWholesalerContent('shipping')">Shipping</a></li>-->
                            <li><a target="_blank" href="<?php echo SITE_ROOT_URL . "messages_inbox.php?&place=inbox" ?>" tp="<?php echo $_SESSION['sessUserInfo']['type']; ?>" class="template_support">Support</a></li>
                            <li><a href="javascript:void(0)" onclick="showWholesalerContent('contact_us');showWholesalerContent1('contact_us')">Contact Us</a></li>
                        </ul>
                    </div>

                </div>
                 <?php /* <div class="footer_right">
                   <div class="side_padded">
                        <h3>Wholesaler Details</h3>
                        <div class="half">
                            <h4>PRIMARY OFFICE</h4>
                            <?php
                            $cnDetails = '';
                            foreach ($objPage->arrCountryList as $vCT)
                            {
                                if ($vCT['country_id'] == $wholasaler['CompanyCountry'])
                                {
                                    $cnDetails = $vCT['name'];
                                }
                            }
                            ?>
                             <p><?php echo $wholasaler['CompanyAddress1'] . ' ' . $wholasaler['CompanyAddress2'] . ' ' . $cnDetails . ' ' . $wholasaler['CompanyCity']; ?></p> 
                        </div>
                       <div class="half">
                            <p><label>Phone -</label> <?php echo ($wholasaler['CompanyPhone']) ? $wholasaler['CompanyPhone'] : 'NA'; ?></p>
                            <p><label>Fax -</label> <?php echo ($wholasaler['CompanyFax']) ? $wholasaler['CompanyFax'] : 'NA'; ?></p>
                        </div>
                    </div>
                     *  */?>
                     
                </div>
            </div>
            <div class="clear"></div>
        </div>
<!--        <script src="<?php echo TEMPLATE_PATH . $templateName; ?>/js/jquery-1.9.1.min.js"></script>-->
        <script src="<?php echo TEMPLATE_PATH . $templateName; ?>/js/owl.carousel.js"></script>
    <style>
        #owl-demo .item img {
            display: block;
            width: 100%;
            height: auto;
        }
        .min-height-box{
            display: none;
        }
    </style>
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
            });
        });

        $(".menu").click(function() {
            $(".nav").stop().slideToggle(350);

        });
    </script>
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