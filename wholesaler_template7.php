<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_TEMPLATE_CTRL;
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;

$templateId = $_REQUEST['tmpid'];
$templateName = $templateId;
$wholasaler = $objPage->arrwholesalerDetails[0];
//pre($wholasaler['Sliderimage']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Wholesaler Template</title>
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS-->
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/normalize.css">
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/skeleton.css">
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/style.css">
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/demo.css">
        <link href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/templateMenu.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo JS_PATH ?>validation/jquery-1.8.2.min.js" ></script>
<!--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->
        <script src="<?php echo TEMPLATE_PATH . $templateName; ?>/js/responsiveslides.min.js"></script>
        <script type="text/javascript">
            var wID='<?php echo $wholasaler['pkWholesalerID']?>'; //alert(wID);
            SITE_ROOT_URL='<?php echo SITE_ROOT_URL; ?>'
            $(window).load(function () {
                var maxHeight = 0;
                $(".box").each(function(){
                    if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
                });
                $(".box").height(maxHeight);
            });
        </script>
        <script src="<?php echo TEMPLATE_PATH . $templateName; ?>/js/template-custom.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>template7menujs.js" ></script>
	<script>
	    function showWholesalerContent1(conId)
            {
		//alert(conId);
                conId != 'home' ? $('.main_div').hide() : $('.main_div').show();
                $('.min-height-box').css({'display': 'none'});
                $('#' + conId).css({'display': 'block'});
		var listItems = $("div.nav").find('ul');
		listItems.each(function(idx, li) {
		    //alert($(this).attr('class'));
		    $(this).children('li').find('a').removeClass('active');
		});
                //$('.nav').children('ul li').find('a').removeClass();
                $('#nav_' + conId).addClass('active');
            }
	    $('document').ready(function() {               
		$('.categorySubMenuProduct').live("click",function(){
                    //alert("SGf");
		    var listItems = $("div.nav").find('ul');
                    //alert(listItems.html());
                    listItems.each(function(idx, li) {
			//alert($(this).attr('class'));
			$(this).children('li').find('a').removeClass('active');
                    });
		    $('.template_men').addClass('active')
                });    
                //$('.scroll-pane').jScrollPane();
            });
	</script>
    </head>
    <body>
        <div class="section bg">
            <div class="container">
                <div class="row">
                    <div class="two columns">
                        <div class="logo"> <h2><?php echo ($wholasaler['CompanyName']); ?></h2></div>
                    </div>
                    <div class="ten columns width">
			<div class="nav">
			    <nav class="clearfix">
				<ul class="clearfix">
				    <li>
					<!--<a href="#">About us</a>-->
					<a class="active" href="javascript:void(0)" onclick="showWholesalerContent('home','nav_home');showWholesalerContent1('home','nav_home')" id="nav_home">Home</a>
				    </li>
				    <li>
			    <a  href="javascript:void(0)" onmouseenter="showWholesalerMenu('Menubar',event)" onmouseout="hideWholesalerMenu('Menubar',event)" class="template_men hand_remove">My Shop</a>
						    
				<?php require_once 'template_menu.php'; ?>
			    </li>
				    <li>
					<!--<a href="#">Payment</a>-->
					<a href="javascript:void(0)" onclick="showWholesalerContent('about_us');showWholesalerContent1('about_us')" id="nav_about_us">About Us</a>
				    </li>
				    <li>
					<!--<a href="#">Shipment</a>-->
					<a href="javascript:void(0)" onclick="showWholesalerContent('services');showWholesalerContent1('services')" id="nav_services">Services</a>
				    </li>
    <!--                                <li>
					<a href="#">Gurantee</a>
					<a href="javascript:void(0)" onclick="showWholesalerContent('business_plan')" id="nav_business_plan">Business Plan</a>
				    </li>-->
				    <li>
					<!--<a href="#">Contact us</a>-->
					<a href="javascript:void(0)" onclick="showWholesalerContent('testimonials');showWholesalerContent1('testimonials')" id="nav_testimonials">Testimonials</a>
				    </li>
    <!--                                <li>
					<a href="#">Return</a>
					<a href="javascript:void(0)" onclick="showWholesalerContent('shipping')" id="nav_shipping">Shipping</a>
				    </li>-->
				    <li>
					<!--<a href="#">Return</a>-->
					<a href="javascript:void(0)" onclick="showWholesalerContent('contact_us');showWholesalerContent1('contact_us')" id="nav_contact_us">Contact Us</a>
				    </li>
    
				</ul>
				<a href="#" id="pull">Menu</a> </nav>
			</div>
                    </div>
                </div>
                <!--  slider  -->
                <div class="row">
                    <div class="twelve columns">
                        <div class="slider">
                            <div class="row">
                                <div class="twelve columns">
                                    <div class="callbacks_container">
                                        <ul class="rslides" id="slider4">
                                            <?php
                                            if (count($wholasaler['Sliderimage']) > 0)
                                            {
                                                foreach ($wholasaler['Sliderimage'] as $slider)
                                                {
                                                    if (file_exists(UPLOADED_FILES_SOURCE_PATH . "images/wholesaler_slider/" . $slider['sliderImage']))
                                                    {
                                                        ?>
                                                        <li><img src="<?php echo UPLOADED_FILES_URL . "images/wholesaler_slider/" . $slider['sliderImage']; ?>" alt="<?php echo $wholasaler['CompanyName']; ?>"></li>
                                                        <?php
                                                    }
                                                }
                                            }
                                            else
                                            {
                                                ?>
                                                <li><img src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/1.jpg" alt="pic"></li>

                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                             <!--   <div class="four columns">
                                    <h1>About us</h1>
                                    <p>
                                        <?php // echo strlen($wholasaler['AboutCompany']) > 320 ? substr($wholasaler['AboutCompany'], 0, 320) . "..." : $wholasaler['AboutCompany']; ?>
                                        <a href="javascript:void(0)" class="readmore" onclick="showWholesalerContent('about_us')" >Read More</a>
                                    </p>

                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section2 main_div" id="home">
            <div class="container">
                <div class="row space">
                    <h3>Best Seller  <?php /*<a target="_blank" href="<?php echo SITE_ROOT_URL . 'category/all/0/' . $wholasaler['CompanyName'] ?>" class="viewAll">View All</a> */?>
                    </h3>

                    <div class="twelve columns">
                        <?php
                        foreach (array_slice($wholasaler['Topproduct'], 0, 6) as $product)
                        {
                            $tc++;
                            ?>
                            <div class="box four columns <?php echo $tc % 4 == 0 ? 'del_space' : ''; ?>">
                                <div class="img_box">
                                    <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>">
                                        <img src="<?php echo $objCore->getImageUrl($product['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>"  title="<?php echo $product['ProductName']; ?>" />
                                    </a>
                                </div>
                                <div class="detail">
                                    <h5><a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>"><?php echo strlen($product['ProductName']) > 14 ? substr($product['ProductName'], 0, 14) . "..." : $product['ProductName']; ?></a></h5>
                                    <div class="price">
                                        <?php echo $objCore->getFinalPrice($product['FinalPrice'], $product['DiscountFinalPrice'], $product['FinalSpecialPrice'], 0, 1); ?>
                                    </div>
                                    <?php
//                                    if ($product['ProductDescription'])
//                                    {
                                    ?>
                                        <!--<p><?php // echo strlen($product['ProductDescription']) > 60 ? substr($product['ProductDescription'], 0, 60) . "..." : $product['ProductDescription'];  ?> </p>-->
                                    <?php // } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>      
        <!--CMS content display will be start from here-->
        <div class="section2 min-height-box ndis" id="about_us">
            <div class="container width_1 ">
                <div class="row content">
                    <div class="twelve columns">
                        <h1>About us</h1>
                        <p><?php echo $wholasaler['AboutCompany']; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="section2 min-height-box ndis" id="services">
            <div class="container width_1 ">
                <div class="row content">
                    <div class="twelve columns">
                        <h1>Services</h1>
                        <p><?php echo ($wholasaler['Services']) ? $wholasaler['Services'] : 'NA'; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="section2 min-height-box ndis" id="business_plan">
            <div class="container width_1 ">
                <div class="row content">
                    <div class="twelve columns">
                        <h1>Business Plan</h1>
                        <p>
                        <ul><?php
                        foreach ($wholasaler['BusinessPlan'] as $BusinessPlan)
                        {
                            if (file_exists(UPLOADED_FILES_SOURCE_PATH . 'files/wholesaler/' . $BusinessPlan['DocumentName']))
                            {
                                echo '<li><a href="' . UPLOADED_FILES_URL . 'files/wholesaler/' . $BusinessPlan['DocumentName'] . '" target="_blank">' . $BusinessPlan['FileName'] . '</a></li>';
                            }
                        };
                        ?></ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="section2 min-height-box ndis" id="testimonials">
            <div class="container width_1 ">
                <div class="row content">
                    <div class="twelve columns">
                        <h1>Testimonials</h1>
                        <p>
                        <ul>
                            <?php
                            foreach (array_slice($wholasaler['Testimonial'], 0, 10) as $testimonial)
                            {
                                echo '<li><b>' . $testimonial['customerName'] . '</b> ' . $testimonial['ReviewDateAdded'] . '<p>' . $testimonial['Reviews'] . '</p></li>';
                            };
                            ?>
                        </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="section2 min-height-box ndis" id="shipping">
            <div class="container width_1 ">
                <div class="row content">
                    <div class="twelve columns">
                        <h1>Shipping</h1>
                        <p>
                        <ul>
                            <?php
                            foreach ($wholasaler['Shipping'] as $shipping)
                            {
                                echo '<li>' . $shipping['ShippingTitle'] . '</span></li>';
                            }
                            ?>
                        </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>
         <div class="section2 min-height-box ndis" id="contact_us">
            <div class="container width_1 ">
                <div class="row content">
                       <h2 class="heading contact_form_heading">Contact Form</h2>
                    <div class="twelve columns contact_form_margin">
                         
                        <p id="messageTemplate">Message sent! </p>
                        <div style="clear:both; display: block;color:green"></div>
                        <form class="pure-form pure-form-aligned" method="post" action="" name="whlContactForm" id="whlContactForm" >
                            <input type="hidden" name="whlemail" id="whlemail" value="<?php echo $wholasaler['ContactPersonEmail'] ?>">
                            <fieldset style="width:300px; flaot:left; clear:left;" class="contform_fieldset">
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
        </div>
        <div class="min-height-box ndis" id="wh_product"><div class="content"></div></div>
        <!--  footer start  -->
        
        <!--  footer end  -->

    </body>
    <style>
	.categorySubMenuProduct:hover{
	    text-decoration: underline !important;
	}
	.contform_fieldset textarea {
	    height:200px;
	    max-height:160px !important;
	}
    </style>
</html>
