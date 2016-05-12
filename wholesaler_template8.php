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
<!doctype html>
<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
        <!-- CSS -->
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/normalize.css">
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/skeleton.css">
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/style.css"> <!-- Resource style -->
 <link rel="stylesheet" href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/templateMenu.css">
        <script src="<?php echo TEMPLATE_PATH . $templateName; ?>/js/modernizr.js"></script> <!-- Modernizr -->
        <script type="text/javascript" src="<?php echo JS_PATH ?>validation/jquery-1.8.2.min.js" ></script>
        <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
        <script src="<?php echo TEMPLATE_PATH . $templateName; ?>/js/responsiveslides.min.js"></script>
        <script src="<?php echo TEMPLATE_PATH . $templateName; ?>/js/main.js"></script> <!-- Resource jQuery -->
        <script type="text/javascript">
            SITE_ROOT_URL='<?php echo SITE_ROOT_URL; ?>';
             var wID='<?php echo $wholasaler['pkWholesalerID']?>'; //alert(wID);
        </script>
        <script src="<?php echo TEMPLATE_PATH . $templateName; ?>/js/template-custom.js">     </script>
         <script type="text/javascript" src="<?php echo JS_PATH ?>template8menujs.js" ></script>
        <title><?php echo $wholasaler['CompanyName']; ?></title>
	<script>
	    $('document').ready(function() {               
		$('.categorySubMenuProduct').live("click",function(){
                    //alert("SGf");
		    var listItems = $("div.nav").find('ul');
                    //alert(listItems.html());
                    listItems.each(function(idx, li) {
			//alert($(this).attr('class'));
                        $(this).find('li').removeClass('active');
			$(this).find('li').find('a').removeClass('active');
                    });
                    $('.template_men').parent().addClass('active');
		    $('.template_men').addClass('active')
                });    
                //$('.scroll-pane').jScrollPane();
            });
	</script>
    </head>
    <body>
        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="three columns logo">
                        <?php
                        if (file_exists(UPLOADED_FILES_SOURCE_PATH . "images/wholesaler_logo/" . $wholasaler['wholesalerLogo']) && isset($wholasaler['wholesalerLogo']) && $wholasaler['wholesalerLogo'] != '')
                        {
                            ?>
<!--                            <img class="logo" src="<?php echo UPLOADED_FILES_URL . "images/wholesaler_logo/" . $wholasaler['wholesalerLogo']; ?>" alt="<?php echo $wholasaler['CompanyName']; ?>"/>-->
                            <?php
                        }
                        else
                        {
                            ?>
<!--                            <img class="logo" src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/logo.png" alt="Company Logo"/>-->
                        <?php } ?>
                        <h2><?php echo ($wholasaler['CompanyName']); ?></h2>
                    </div>
                    <div class="nine columns nav">
                        <ul class="menu">                           
                            <li class="active">
                                <!--<a href="#">Payment</a>-->
                                <a class="active" href="javascript:void(0)" onclick="showWholesalerContent('about_us')" id="nav_about_us">About Us</a>
                            </li>
                             <li>
			<a  href="javascript:void(0)" onmouseenter="showWholesalerMenu('Menubar',event)" onmouseout="hideWholesalerMenu('Menubar',event)" class="template_men hand_remove">My Shop</a>
                                                
                            <?php require_once 'template_menu.php'; ?>
                    </li>
                            <li>
                                <!--<a href="#">Shipment</a>-->
                                <a href="javascript:void(0)" onclick="showWholesalerContent('services')" id="nav_services">Services</a>
                            </li>
                            <li>
                                <!--<a href="#">Gurantee</a>-->
                                <a href="javascript:void(0)" onclick="showWholesalerContent('business_plan')" id="nav_business_plan">Business Plan</a>
                            </li>
                            <li>
                                <!--<a href="#">Contact us</a>-->
                                <a href="javascript:void(0)" onclick="showWholesalerContent('testimonials')" id="nav_testimonials">Testimonials</a>
                            </li>
                            <li>
                                <!--<a href="#">Return</a>-->
                                <a href="javascript:void(0)" onclick="showWholesalerContent('shipping')" id="nav_shipping">Shipping</a>
                            </li>
                            <li>
                                <!--<a href="#">About us</a>-->
                                <a href="javascript:void(0)" onclick="showWholesalerContent('contact_us')" id="nav_contact_us">Contact Us</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="containerbanner">
            <div class="row"><div class="callbacks_container">
                    <ul class="rslides" id="slider4">
                        <?php
                        if (count($wholasaler['Sliderimage']) > 0)
                        {
                            foreach ($wholasaler['Sliderimage'] as $slider)
                            {
                                if (file_exists(UPLOADED_FILES_SOURCE_PATH . "images/wholesaler_slider/" . $slider['sliderImage']))
                                {
                                    ?>
                                    <li><img  src="<?php echo UPLOADED_FILES_URL . "images/wholesaler_slider/" . $slider['sliderImage']; ?>" alt="<?php echo $wholasaler['CompanyName']; ?>"></li>
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
                </div></div>
             
            <div class="row">
                <div class="twelve columns about main_div" id="about_us">
                   
                    <span><?php
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
                        <?php } ?></span>
                    <h1>About us</h1>
                    <hr>
                    <p><?php echo $wholasaler['AboutCompany']; ?></p>
                </div>
                <div class="twelve columns about main_div ndis" id="services">
                    <span><img src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/icon.png" alt=""></span>
                    <h1>Services</h1>
                    <hr>
                    <p><?php echo ($wholasaler['Services']) ? $wholasaler['Services'] : 'NA'; ?></p>
                </div>
                <div class="twelve columns about main_div ndis" id="business_plan">
                    <span><img src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/icon.png" alt=""></span>
                    <h1>Business Plan</h1>
                    <hr>
                    <p>
                        <?php
                        if ($wholasaler['BusinessPlan'])
                        {
                            ?>
                        <ul><?php
                        foreach ($wholasaler['BusinessPlan'] as $BusinessPlan)
                        {
                            if (file_exists(UPLOADED_FILES_SOURCE_PATH . 'files/wholesaler/' . $BusinessPlan['DocumentName']))
                            {
                                echo '<li><p><a href="' . UPLOADED_FILES_URL . 'files/wholesaler/' . $BusinessPlan['DocumentName'] . '" target="_blank">' . $BusinessPlan['FileName'] . '</a></p></li>';
                            }
                        }
                            ?></ul>
                        <?php
                    }
                    else
                    {
                        echo 'NA';
                    }
                    ?>
                    </p>
                </div>
                <div class="twelve columns about main_div ndis" id="testimonials">
                    <span><img src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/icon.png" alt=""></span>
                    <h1>Testimonials</h1>
                    <hr>
                    <p>
                    <ul>
                        <?php
                        foreach (array_slice($wholasaler['Testimonial'], 0, 10) as $testimonial)
                        {
                            echo '<li><p><b>' . $testimonial['customerName'] . '</b> ' . $testimonial['ReviewDateAdded'] . '</p><p>' . $testimonial['Reviews'] . '</p></li>';
                        }
                        ?>
                    </ul>
                    </p>
                </div>
                <div class="twelve columns main_div about ndis" id="shipping">
                    <span><img src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/icon.png" alt=""></span>
                    <h1>Shipping</h1>
                    <hr>
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
                <div class="twelve columns about main_div ndis" id="contact_us">
                    <span><img src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/icon.png" alt=""></span>
                  <?php /*  <h1>Contact Us</h1>
                    <hr>
                    <p>
                        <label>Name: </label><?php echo $wholasaler['ContactPersonName']; ?>(<?php echo $wholasaler['ContactPersonPosition']; ?>)<br/>
                        <label>Phone: </label><?php echo $wholasaler['ContactPersonPhone']; ?><br/>
                        <label>Email: </label><?php echo $wholasaler['ContactPersonEmail']; ?><br/>
                        <label>Address: </label><?php echo $wholasaler['ContactPersonAddress']; ?><br/>
                    </p> */?>
                     <div class="container">
                <div class="row">
                    <div class="ten columns contact offset-by-one">
                        <h6>Contact us</h6>
                        <div class="contact-sec">
                            <p>Please fill the below details, we will contact you back within 24 hours.</p>
                             <p id="messageTemplate" class="success" style="display:none;color:green">Message sent! </p>
                           
                        </div>

                        <form method="post" action="" name="whlContactForm" id="whlContactForm"  enctype="text/plain">
                            <input type="hidden" name="whlemail" id="whlemail" value="<?php echo $wholasaler['ContactPersonEmail'] ?>">
                              <input id="name" type="text" placeholder="Name" name="name" id="name" onfocus="onKeySignUp(this.id);">
                            <input type="text" name="email" id="email" placeholder="your mail" onfocus="onKeySignUp(this.id);">
<!--                            <input type="text" maxlength="150" name="address" id="address" placeholder="your address" onfocus="onKeySignUp(this.id);">
                            <input type="text" maxlength="20" name="phone" id="phone" placeholder="your telephone" onfocus="onKeySignUp(this.id);"><br>-->
                          
                            <textarea  maxlength="200" name="message" id="message" placeholder="your message" style="width:356px; height:100px" size="50" onfocus="onKeySignUp(this.id);"></textarea>
                            <input type="button" id="temSubmit" value="Send" name="submit" class="pure-button pure-button-primary" onclick="validateWhlFrm()"/>
                        </form>

                    </div>

                </div>

            </div>
                </div>
            </div>

        </div>
<div class="min-height-box ndis" id="wh_product" style="clear:both;"><div class="content"></div></div>
        
        <div class="color_blue">
            <div class="container">
                <div class="row">                    
                     <?php /*<a target="_blank" href="<?php echo SITE_ROOT_URL . 'category/all/0/' . $wholasaler['CompanyName'] ?>" class="view">View All</a>*/?>
                    <div class="clear"></div>
                    <div class="cd-tabs">
                        <nav>
                            <ul class="cd-tabs-navigation">
                                <?php
                                $temp = 1;
                                foreach (array_slice($TopSellingCatProduct, 0, 7) as $catPro)
                                {
                                    ?>
                                    <li class="first"><a  id="cat_name" class="<?php echo $temp == 1 ? ' selected' : ''; ?>" data-content="<?php echo strtoupper($catPro['arrCategory']['CategoryName']); ?>" href="javascript:void(0)"><?php echo strtoupper($catPro['arrCategory']['CategoryName']); ?></a></li>
                                    <?php
                                    $temp++;
                                }
                                ?>
                            </ul> <!-- cd-tabs-navigation -->
                        </nav>

                        <ul class="cd-tabs-content">
                            <h5 id="product_cat" style="color:white;margin-bottom:0 !important;">BEST SELLER </h5>
                            <?php
                            $varTemp = 1;
                            $varTempcat = 1;
                            foreach (array_slice($TopSellingCatProduct, 0, 6) as $catPro)
                            {
                                ?>
                                <li data-content="<?php echo strtoupper($catPro['arrCategory']['CategoryName']); ?>" class="<?php echo $varTempcat == 1 ? ' selected' : ''; ?>">
                                    <div class="container">
                                        <div class="row">
                                            <?php
                                            foreach (array_slice($catPro['arrProducts'], 0, 6) as $val)
                                            {
                                                ?>
                                                <div class="four columns box<?php echo $varTemp % 4 == 0 ? ' del_space' : ''; ?>">
                                                    <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'])); ?>">
                                                        <img width="<?php echo $varImageSize[0]; ?>" height="<?php echo $varImageSize[1]; ?>" class="lazy" src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" alt="<?php echo $val['ProductName'] ?>"/>
                                                    </a>
                                                    <h4>
                                                        <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'])); ?>"><?php echo strlen($val['ProductName']) > 16 ? substr($val['ProductName'], 0, 15) . "..." : $val['ProductName']; ?></a>
                                                    </h4>
                                                    <div class="price">
                                                        <?php echo $objCore->getFinalPrice($val['FinalPrice'], $val['DiscountFinalPrice'], $val['FinalSpecialPrice'], 0, 1); ?>
                                                    </div>
                                                    <?php
//                                                    if ($val['ProductDescription'])
//                                                    {
                                                        ?>
                                                        <!--<p><?php //echo strlen($val['ProductDescription']) > 18 ? substr($val['ProductDescription'], 0, 18) . "..." : $val['ProductDescription']; ?> </p>-->
                                                        <?php
//                                                    }
                                                    if ($val['discountPercent'] > 0 && $val['discountPercent'] < 99)
                                                    {
                                                        ?>

                                                        <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'])); ?>" class="discount"> <?php echo $val['discountPercent'] . '%'; ?></a>
                                                    <?php }
                                                    ?>
                                                </div>
                                                <?php
                                                $varTemp++;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </li>
                                <?php
                                $varTempcat++;
                                $varTemp = 1;
                            }
                            ?>
                        </ul> <!-- cd-tabs-content -->
                    </div>
                </div>
            </div>

        </div>

        <!-- second color -->
        <div class="color_black">



            <div class="container">
                <h5>New Arrival</h5>
                <div class="row">
                    <?php
                    foreach (array_slice($wholasaler['NewproductRan'], 0, 6) as $product)
                    {
                        $tc++;
                        ?>
                        <div class="four columns box<?php echo $tc % 4 == 0 ? ' del_space' : ''; ?>">
                            <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>">
                                <img  src="<?php echo $objCore->getImageUrl($product['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>"  title="<?php echo $product['ProductName']; ?>" />
                            </a>
                            <h4><a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>"><?php echo strlen($product['ProductName']) > 16 ? substr($product['ProductName'], 0, 15) . "..." : $product['ProductName']; ?></a></h4>
                            <div class="price">
                                <?php echo $objCore->getFinalPrice($product['FinalPrice'], $product['DiscountFinalPrice'], $product['FinalSpecialPrice'], 0, 1); ?>
                            </div>
                            <?php
//                            if ($product['ProductDescription'])
//                            {
                                ?>
                                <!--<p><?php //echo strlen($product['ProductDescription']) > 18 ? substr($product['ProductDescription'], 0, 18) . "..." : $product['ProductDescription']; ?> </p>-->
                                <?php
//                            }
                            if ($product['discountPercent'] > 0 && $product['discountPercent'] < 99)
                            {
                                ?>
                                <a href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>" class="discount">
                                    <?php echo $product['discountPercent'] . '%'; ?>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
           

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