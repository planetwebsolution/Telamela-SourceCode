<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_TEMPLATE_CTRL;
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;

$templateId = $_REQUEST['tmpid'];
$templateName = $templateId;
$wholasaler = $objPage->arrwholesalerDetails[0];
$TopSellingCatProduct = $objPage->arrwholesalerTopSellingByCategory;
$arrCatImages = array('1' => 'first_icon', '2' => 'second_icon', '3' => 'third_icon', '4' => 'forth_icon');
//$arrCatImages = array('1' => 'first_icon', '2' => 'first_icon', '3' => 'first_icon', '4' => 'first_icon');
$arrBoxColor = array('1' => 'shown', '2' => 'red', '3' => 'yellow', '4' => 'purple');
//pre($wholasaler['Sliderimage']);

?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $wholasaler['CompanyName']; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link rel="stylesheet" href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/skeleton.css">
        <link href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/owl.carousel.css" rel="stylesheet">
        <link href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/owl.theme.css" rel="stylesheet">
<!--        <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>-->
        <script src="<?php echo TEMPLATE_PATH . $templateName; ?>/js/template-custom.js">     </script>
         <link href="<?php echo TEMPLATE_PATH . $templateName; ?>/css/templateMenu.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo JS_PATH ?>validation/jquery-1.8.2.min.js" ></script>      
        <script type="text/javascript" src="<?php echo TEMPLATE_PATH . $templateName; ?>/js/template-custom.js"></script>
        <script src="<?php echo TEMPLATE_PATH . $templateName; ?>/js/owl.carousel.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
        <script>
               SITE_ROOT_URL='<?php echo SITE_ROOT_URL; ?>';
                var wID='<?php echo $wholasaler['pkWholesalerID']?>'; //alert(wID);
        </script>
          <script type="text/javascript" src="<?php echo JS_PATH ?>template10menujs.js" ></script>
	  <script>
	    $('document').ready(function() {               
		$('.categorySubMenuProduct').live("click",function(){
                    //alert("SGf");
		    var listItems = $("div.navDiv").find('ul');
                    //alert(listItems.html());
                    listItems.each(function(idx, li) {
			//alert($(this).html());
			$(this).find('li') .removeClass('active');
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
        <div class="container">
            <div class="header">

                <div class="logo_container">
                    <a  class="logo">
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
                    </a>
                </div>
                <div class="navigation navDiv">
                    <h3 class="mobileMenu">Menu</h3>
                    <ul class="nav">
                        <li class="active">                         
                            <a href="javascript:void(0)" onclick="showWholesalerContent('home', 'nav_home')" id="nav_home" class="active">Home</a>
                        </li>
                         <li>
			<a  href="javascript:void(0)" onmouseenter="showWholesalerMenu('Menubar',event)" onmouseout="hideWholesalerMenu('Menubar',event)" class="template_men hand_remove">My Shop</a>
                                                
                            <?php require_once 'template_menu.php'; ?>
                    </li>
                        <li class="active">
                            <a href="javascript:void(0)" onclick="showWholesalerContent('about_us')" id="nav_about_us" >About Us</a>
                            <!--<a class="active" href="javascript:void(0)" onclick="showWholesalerContent('about_us')" id="nav_about_us">About Us</a>-->
                        </li>
                        <li>                         
                            <a href="javascript:void(0)" onclick="showWholesalerContent('services')" id="nav_services">Services</a>
                        </li>
<!--                        <li>                         
                            <a href="javascript:void(0)" onclick="showWholesalerContent('business_plan')" id="nav_business_plan">Business Plan</a>
                        </li>-->
                        <li>                         
                            <a href="javascript:void(0)" onclick="showWholesalerContent('testimonials')" id="nav_testimonials">Testimonials</a>
                        </li>
<!--                        <li>                           
                            <a href="javascript:void(0)" onclick="showWholesalerContent('shipping')" id="nav_shipping">Shipping</a>
                        </li>-->
                        <li>                          
                            <a href="javascript:void(0)" onclick="showWholesalerContent('contact_us')" id="nav_contact_us">Contact Us</a>
                        </li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>

            <div class="slider">
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
                        <div class="item"><img src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/banner.png" alt="pic"></div>
                    <?php } ?>

                </div>

                <div class="absolute_text">
                    <h3>Company Slogan</h3>
                    <!--<h5>Lorem Ispum dor</h5>-->
                    <p><?php echo strlen($wholasaler['AboutCompany']) > 330 ? substr($wholasaler['AboutCompany'], 0, 330) . "..." : $wholasaler['AboutCompany']; ?></p>
                    <div class="simpleBox">
                        <a href="javascript:void(0)" class="readmore" onclick="showWholesalerContent('about_us')" >Read More</a>
                    </div>
                </div>
            </div>
           <div class="min-height-box ndis" id="wh_product" style="clear:both; overflow: hidden;" ><div class="content"></div></div>
            <div id="home" style="padding:0 1em;" class="main-div">
               
  
               <?php /*<div><a target="_blank" href="<?php echo SITE_ROOT_URL . 'category/all/0/' . $wholasaler['CompanyName'] ?>" class="viewAll">View All</a></div> */?>
                <div class="fourBoxcollumn">
                    <?php
                    $temp = 1;
                    $idTempCount = 0;
                    foreach (array_slice($TopSellingCatProduct, 0, 4) as $catPro)
                    {
                         if($idTempCount==0){
                                    $cat_name= $catPro['arrCategory']['CategoryName'];
                                }
                        ?>
                        <div class="oneforth Col<?php echo ($temp == 1) ? '' : $temp; ?>">
                            <div class="imageBox">
    <!--                                <img src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/<?php echo $arrCatImages[$temp]; ?>.png" />-->
                                <?php
                                if ($catPro['arrCategory']['categoryImage'])
                                {
                                    ?>
                                    <img style="width:153px;height:154px;"  src="<?php echo $catPro['arrCategory']['categoryImageUrl'] . $catPro['arrCategory']['categoryImage']; ?>" alt="<?php echo $catPro['arrCategory']['CategoryName'] ?>"/>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <img src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/cat_1.jpg" alt=""/>
                                <?php }
                                ?>
                            </div>
                            <h3 id="cat_name_show_<?php echo $idTempCount;  ?>"><?php echo strtoupper($catPro['arrCategory']['CategoryName']); ?></h3>
                            <?php
                            if ($catPro['arrCategory']['CategoryDescription'])
                            {
                                ?>
                                <p>
                                    <?php
                                    echo strlen($catPro['arrCategory']['CategoryDescription']) > 150 ? substr($catPro['arrCategory']['CategoryDescription'], 0, 150) . "..." : $catPro['arrCategory']['CategoryDescription'];
                                    ?>
                                </p>
                                <?php
                            }
                            ?>

                        </div>
                        <?php
                        $temp++;
                        $idTempCount++;
                    }
                    ?>
                </div>

                <div class="outerbox">
                    <h3 id="product_cat"><?php echo $cat_name  ?></h3>
                    <?php
                    $varTemp = 1;

                    foreach (array_slice($TopSellingCatProduct, 0, 8) as $catPro)
                    {
                        ?>
                        <div class="boxedBox <?php echo $arrBoxColor[$varTemp]; ?>">
                            <span><img src="<?php echo TEMPLATE_PATH . $templateName; ?>/images/<?php echo $arrCatImages[$varTemp]; ?>.png" /></span>
                            <ul>
                                <?php
                                foreach ($catPro['arrProducts'] as $val)
                                {
                                    ?>

                                    <li>
                                        <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'])); ?>">
                                            <img width="<?php echo $varImageSize[0]; ?>" height="<?php echo $varImageSize[1]; ?>" class="lazy" src="<?php echo $objCore->getImageUrl($val['ProductImage'], 'products/' . $arrProductImageResizes['global']); ?>" alt="<?php echo $val['ProductName'] ?>"/>
                                        </a>
                                        <div class="productName">
                                            <a target="_blank" href="<?php echo $objCore->getUrl('product.php', array('id' => $val['pkProductID'], 'name' => $val['ProductName'], 'refNo' => $val['ProductRefNo'])); ?>"><?php echo strlen($val['ProductName']) > 16 ? substr($val['ProductName'], 0, 15) . "..." : $val['ProductName']; ?></a>
                                        </div>
                                        <div class="price">   <?php echo $objCore->getFinalPrice($val['FinalPrice'], $val['DiscountFinalPrice'], $val['FinalSpecialPrice'], 0, 1); ?></div>
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
            
            <div id="services" class="ndis main-div">
                <p><?php echo ($wholasaler['Services']) ? $wholasaler['Services'] : 'NA'; ?></p>
            </div>
            <div id="business_plan" class="ndis main-div">

                <?php
                if ($wholasaler['BusinessPlan'])
                {
                    ?>
                    <p>
                    <ul>
                        <?php
                        foreach ($wholasaler['BusinessPlan'] as $BusinessPlan)
                        {
                            if (file_exists(UPLOADED_FILES_SOURCE_PATH . 'files/wholesaler/' . $BusinessPlan['DocumentName']))
                            {
                                echo '<li><p><a href="' . UPLOADED_FILES_URL . 'files/wholesaler/' . $BusinessPlan['DocumentName'] . '" target="_blank">' . $BusinessPlan['FileName'] . '</a></p></li>';
                            }
                        }
                        ?>
                        </p>
                    </ul>
                    <?php
                }
                else
                {
                    echo 'NA';
                }
                ?>

            </div>
            <div id="testimonials" class="ndis main-div">
                <p>
                    <?php
                    if ($wholasaler['Testimonial'])
                    {
                        echo "<ul>";

                        foreach (array_slice($wholasaler['Testimonial'], 0, 10) as $testimonial)
                        {
                            echo '<li><p><b>' . $testimonial['customerName'] . '</b> ' . $testimonial['ReviewDateAdded'] . '</p><p>' . $testimonial['Reviews'] . '</p></li>';
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
            <div id="shipping" class="ndis main-div">
                <p>
                    <?php
                    if ($wholasaler['Shipping'])
                    {

                        echo "<ul>";
                        foreach ($wholasaler['Shipping'] as $shipping)
                        {
                            echo '<li><p>' . $shipping['ShippingTitle'] . '</p></li>';
                        }
                        echo "</ul>";
                    }
                    else
                    {
                        echo 'NA';
                    }
                    ?>
                </p>
            </div>
            <div id="contact_us" class="ndis main-div">
               <?php /* <p>
                    <label>Name: </label><?php echo $wholasaler['ContactPersonName']; ?>(<?php echo $wholasaler['ContactPersonPosition']; ?>)<br/>
                    <label>Phone: </label><?php echo $wholasaler['ContactPersonPhone']; ?><br/>
                    <label>Email: </label><?php echo $wholasaler['ContactPersonEmail']; ?><br/>
                    <label>Address: </label><?php echo $wholasaler['ContactPersonAddress']; ?><br/>
                </p>*/ ?>
                   <h2 class="heading contact_form_heading">Contact Form</h2>
                 <p id="messageTemplate" style="display:none;color:green" >Message sent! </p>
                 <div style="clear:both; display: block;"></div>
                        <form class="pure-form pure-form-aligned" method="post" action="" name="whlContactForm" id="whlContactForm" >
                            <input type="hidden" name="whlemail" id="whlemail" value="<?php echo $wholasaler['ContactPersonEmail'] ?>">
                            <fieldset  class="contform_fieldset">
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
                                    <input type="button" id="temSubmit" style="float:right;" value="Send" name="submit" class="pure-button pure-button-primary" onclick="validateWhlFrm()"/>
                                </div>
                            </fieldset>
                        </form>
            </div>
            <div id="about_us" class="ndis main-div">
                <p>
                    <?php echo $wholasaler['AboutCompany']; ?>
                </p>
            </div>

            <div class="clear"></div>
        </div>
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