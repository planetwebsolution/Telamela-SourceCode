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
        <title>template 11</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/skeleton.css">
        <link href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/owl.carousel.css" rel="stylesheet">
        <link href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/owl.theme.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
         <link href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/templateMenu.css" rel="stylesheet" type="text/css" />
        <!--header terminates here-->
        <script type="text/javascript" src="<?php echo JS_PATH ?>validation/jquery-1.8.2.min.js" ></script>
        <script type="text/javascript" src="<?php echo TEMPLATE_PATH . $templateName; ?>/js/custom.js"></script>
        <script src="<?php echo TEMPLATE_PATH . $templateName; ?>/js/owl.carousel.js"></script>
        <script src="<?php echo TEMPLATE_PATH . $templateName; ?>/js/template-custom.js"></script>
        <script>
             SITE_ROOT_URL='<?php echo SITE_ROOT_URL; ?>';
               var wID='<?php echo $wholasaler['pkWholesalerID']?>'; //alert(wID);
        </script>
           <script type="text/javascript" src="<?php echo JS_PATH ?>template11menujs.js" ></script>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <div class="logo_container">
                    <p class="logo">
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
                            <img class="logo" src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/logo.png" alt="company Logo"/>
                        <?php } ?>
                    </p>
                    <h3><?php echo $wholasaler['CompanyName']; ?></h3>
                </div>

                <div class="reviewsSlider">
                    <div id="owl-demo" class="owl-carousel">
                        <?php
                        foreach (array_slice($wholasaler['Testimonial'], 0, 6) as $val)
                        {
                            ?>
                            <div class="item">
                                <h3>Reviews</h3>
                                <p><?php echo $objCore->getProductName($val['Reviews'], 100); ?></p>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="navigation">
                <div class="mobileMenu">Menu</div>
                <ul class="nav">
                    <li class="active">
                        <a  href="javascript:void(0)" onclick="showWholesalerContent('home','nav_home')" id="nav_home">Home</a>
                    </li>
                    <li>
			<a  href="javascript:void(0)" onmouseenter="showWholesalerMenu('Menubar',event)" onmouseout="hideWholesalerMenu('Menubar',event)" class="template_men hand_remove">My Shop</a>
                                                
                            <?php require_once 'template_menu.php'; ?>
                    </li>
                    <li>                       
                        <a href="javascript:void(0)" onclick="showWholesalerContent('about_us')" id="nav_about_us">About Us</a>
                    </li>
                    <li>                       
                        <a href="javascript:void(0)" onclick="showWholesalerContent('services')" id="nav_services">Services</a>
                    </li>
<!--                    <li>                    
                        <a href="javascript:void(0)" onclick="showWholesalerContent('business_plan')" id="nav_business_plan">Business Plan</a>
                    </li>-->
                    <li>                       
                        <a href="javascript:void(0)" onclick="showWholesalerContent('testimonials')" id="nav_testimonials">Testimonials</a>
                    </li>
<!--                    <li>                      
                        <a href="javascript:void(0)" onclick="showWholesalerContent('shipping')" id="nav_shipping">Shipping</a>
                    </li>-->
                    <li>                       
                        <a href="javascript:void(0)" onclick="showWholesalerContent('contact_us')" id="nav_contact_us">Contact Us</a>
                    </li>
                </ul>

             <?php /*  <a target="_blank" href="<?php echo SITE_ROOT_URL . 'category/all/0/' . $wholasaler['CompanyName'] ?>" class="ViewAbs">View All</a> */?>



            </div>

            <div class="home main_div" id="home">
                <div class="belowNav">
                    <div class="rightbar">

                        <div id="owl-demo2" class="owl-carousel">                           
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


                    <div class="leftbar">
                        <ul class="category">
                            <?php
                            $temp = 1;
                            $idTempCount = 0;
                            foreach (array_slice($TopSellingCatProduct, 0, 4) as $catPro)
                            {
                                if($idTempCount==0){
                                    $cat_name= $catPro['arrCategory']['CategoryName'];
                                }
                                ?>
                                <li class="<?php echo ($temp == 1) ? 'active' : '' ?>"><h3 id="cat_name_show_<?php echo $idTempCount;  ?>"><?php echo strtoupper($catPro['arrCategory']['CategoryName']); ?></h3>
                                    <div class="innerimage">
                                        <?php
                                        if ($catPro['arrCategory']['categoryImage'])
                                        {
                                            ?>
                                            <img src="<?php echo $catPro['arrCategory']['categoryImageUrl'] . $catPro['arrCategory']['categoryImage']; ?>" alt="<?php echo $catPro['arrCategory']['CategoryName'] ?>"/>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <img src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/cat.jpg" alt="Category" />
                                        <?php }
                                        ?>

                                    </div>
                                </li>
                                <?php
                                $temp++;
                                $idTempCount++;
                            }
                            ?>
                        </ul>

                    </div>
                </div>
                <div class="boxedBox">
                    <h3 id="product_cat" style="margin-bottom:0 !important;"><?php echo $cat_name  ?></h3>
                    <?php
                    $varTemp = 1;

                    foreach (array_slice($TopSellingCatProduct, 0, 10) as $catPro)
                    {
                        ?>
                        <div class="itemsContainer <?php echo ($varTemp == 1) ? 'shown' : '' ?>">
                            <ul class="fullUl">
                                <?php
                                foreach ($catPro['arrProducts']as $val)
                                {
                                    ?>
                                    <li>
                                        <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'])); ?>">
                                            <img width="<?php echo $varImageSize[0]; ?>" height="<?php echo $varImageSize[1]; ?>" class="lazy" src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" alt="<?php echo $val['ProductName'] ?>"/>
                                        </a>
                                        <div class="productName">
                                            <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'])); ?>"><?php echo strlen($val['ProductName']) > 16 ? substr($val['ProductName'], 0, 15) . "..." : $val['ProductName']; ?></a>
                                        </div>
                                        <div class="moreAbout">   <?php echo $objCore->getFinalPrice($val['FinalPrice'], $val['DiscountFinalPrice'], $val['FinalSpecialPrice'], 0, 1); ?></div>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <?php
                        $varTemp++;
                    }
                    ?>
                </div>
            </div>
            <div class="min-height-box ndis" id="wh_product" style="clear:both;"><div class="content"></div></div>
            <!--CMS content display will be start from here-->
            <div class="content-box ndis home " id="about_us">
                <div class="content">
                    <h1>About us</h1>
                    <p><?php echo $wholasaler['AboutCompany']; ?></p>
                </div>
            </div>
            <div class="content-box ndis home" id="services">
                <div class="content">
                    <h1>Services</h1>
                    <p><?php echo ($wholasaler['Services']) ? $wholasaler['Services'] : 'NA'; ?></p>
                </div>
            </div>
            <div class="content-box ndis home" id="business_plan">
                <div class="content">
                    <h1>Business Plan</h1>
                    <p>
                        <?php
                        if ($wholasaler['BusinessPlan'])
                        {
                            echo "<ul>";
                            foreach ($wholasaler['BusinessPlan'] as $BusinessPlan)
                            {
                                if (file_exists(UPLOADED_FILES_SOURCE_PATH . 'files/wholesaler/' . $BusinessPlan['DocumentName']))
                                {
                                    echo '<li><a href="' . UPLOADED_FILES_URL . 'files/wholesaler/' . $BusinessPlan['DocumentName'] . '" target="_blank">' . $BusinessPlan['FileName'] . '</a></li>';
                                }
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

            <div class="content-box ndis home" id="testimonials">
                <div class="content">
                    <h1>Testimonials</h1>
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
            <div class="content-box ndis home" id="shipping">
                <div class="content">
                    <h1>Shipping</h1>
                    <p>
                        <?php
                        if ($wholasaler['Shipping'])
                        {
                            echo "<ul>";
                            foreach ($wholasaler['Shipping'] as $shipping)
                            {
                                echo '<li>' . $shipping['ShippingTitle'] . '</span></li>';
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
            <div class="content-box ndis home" id="contact_us">
                <div class="content">
                   
                    <?php /*<p>
                        <label>Name: </label><?php echo $wholasaler['ContactPersonName']; ?>(<?php echo $wholasaler['ContactPersonPosition']; ?>)<br/>
                        <label>Phone: </label><?php echo $wholasaler['ContactPersonPhone']; ?><br/>
                        <label>Email: </label><?php echo $wholasaler['ContactPersonEmail']; ?><br/>
                        <label>Address: </label><?php echo $wholasaler['ContactPersonAddress']; ?><br/>
                    </p> */?>
                     <h1 class="contact_form_heading">Contact Form</h1>
                     <div style="clear:both;"></div>
                       <div class="four columns left_float contact_form_margin">
                       <div style="clear:both;"></div>
                        <p id="messageTemplate" style="display:none;color:green">Message sent! </p>
                        <div style="clear:both;"></div>
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

            <div class="clear"></div>
        </div>
	<style>
	    .categorySubMenuProduct:hover{
		text-decoration: underline !important;
	    }
	    .contform_fieldset textarea {
		height:200px;
		max-height:200px !important;
	    }
	</style>
    </body>
</html>
