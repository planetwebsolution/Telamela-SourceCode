<?php 
$data  = explode('/telamela/pro/',$_SERVER['SCRIPT_NAME']);
$page = $data[1];
//$page = basename($_SERVER['PHP_SELF']); ?>
<link rel="shortcut icon" href="<?php echo IMAGES_URL ?>/favicon.ico" />
<meta name="google-translate-customization" content="1497b09e5524fc70-70348f034cf0b15f-gf96319608001e5a4-13" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">	
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>xhtml.css"/>
<link rel="stylesheet" href="<?php echo CSS_PATH; ?>font-awesome.min.css" />
<script type="text/javascript"> var SITE_ROOT_URL = '<?php echo SITE_ROOT_URL; ?>';
    var SiteCurrencySign = '<?php echo html_entity_decode($_SESSION['SiteCurrencySign']); ?>';</script>
<script type="text/javascript" src="<?php echo FRONT_JS_PATH ?>message.inc.js" ></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>validation/jquery-1.8.2.min.js" ></script>
<!--<script  type="text/javascript" src="<?php echo JS_PATH ?>validation/jquery.validationEngine-en.js"></script>-->


<?php
// Telamela page wish css js call from here
//pre($_SESSION);
if ($page == 'index.php')
{
    ?>
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
    <!--<link type="text/css" rel="stylesheet" href="<?php echo CSS_PATH; ?>responsive.css" />-->
    <script type="text/javascript">
        $(document).ready(function() {
            jQuery("img.lazy").lazy({
                delay: 2000
            });
        });
    </script>
    <?php
}
if ($page == 'landing.php')
{
    ?>
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>bjqs-1.3.min.js" ></script>
    <link type="text/css" rel="stylesheet" href="<?php echo CSS_PATH; ?>landing_slider.css"/>
    <script type="text/javascript" src="<?php echo JS_PATH ?>owl.carousel2.js"></script>
    <!--<script src="<?php echo JS_PATH ?>easyResponsiveTabs.js" type="text/javascript"></script>-->
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>easy-responsive-tabs.css" />
    <script type="text/javascript" src="<?php echo JS_PATH ?>new_landing.js"></script>
    <!--Lazy loading-->
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.lazy.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>home.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo CSS_PATH; ?>jquery.jqzoom.css"/>
    <script type="text/javascript" src="<?php echo JS_PATH ?>jQueryRotate.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.flip.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery_cr.js" ></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.jqzoom-core.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.mousewheel.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            jQuery("img.lazy").lazy({
                delay: 1000
            });
        });
    </script>



    <?php
}
if ($page == 'special.php')
{
    ?>
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>bjqs-1.3.min.js" ></script>
    <link type="text/css" rel="stylesheet" href="<?php echo CSS_PATH; ?>landing_slider.css"/>
    <script type="text/javascript" src="<?php echo JS_PATH ?>owl.carousel2.js"></script>
    <!--<script src="<?php echo JS_PATH ?>easyResponsiveTabs.js" type="text/javascript"></script>-->
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>easy-responsive-tabs.css" />
    <script type="text/javascript" src="<?php echo JS_PATH ?>special.js"></script>
    <!--Lazy loading-->
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.lazy.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>home.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo CSS_PATH; ?>jquery.jqzoom.css"/>
    <script type="text/javascript" src="<?php echo JS_PATH ?>jQueryRotate.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.flip.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery_cr.js" ></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.jqzoom-core.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.mousewheel.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            jQuery("img.lazy").lazy({
                delay: 2000
            });
        });
    </script>



    <?php
}
if ($page == 'category.php')
{
    ?>
    <script type="text/javascript" src="<?php echo JS_PATH ?>bjqs-1.3.min.js" ></script>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>mialn.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>style_responsive.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>easy-responsive-tabs.css" />
    <script type="text/javascript" src="<?php echo JS_PATH ?>owl.carousel3.js"></script>
   
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.mousewheel.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>stylish-select.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>jQueryRotate.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>checkboxradiojs.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo CSS_PATH ?>product.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>category.css"/>
    <script type="text/javascript" src="<?php echo JS_PATH ?>scriptbreaker-multiple-accordion-1.js"></script>
    <script src="<?php echo JS_PATH ?>jquery_cr.js" type="text/javascript"></script>
    <script src="<?php echo JS_PATH ?>jquery.jqzoom-core.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>jquery.jqzoom.css"/>
    <!--Lazy loading-->
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.lazy.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>home.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>custom_js.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>jquery.range.css"/>
    <script src="<?php echo JS_PATH ?>jquery.range.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>category.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            jQuery("img.lazy").lazy({
                delay: 2000
            });
            var owl7 = $(".owl-demo7");

    owl7.owlCarousel({
        items: 4, //10 items above 1000px browser width
        itemsDesktop: [1000, 4], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
        itemsTablet: [767, 1], //2 items between 600 and 0;
        itemsMobile: false // itemsMobile disabled - inherit from itemsTablet option

    });

    // Custom Navigation Events
    $(".next7").click(function() {

        owl7.trigger('owl.next');
    })
    $(".prev7").click(function() {
        owl7.trigger('owl.prev');
    })
        });
    </script>
    <style>
        .mainblock_wholseler_hrz .view{ height:200px !important; margin-bottom:20px;}
        .mainblock_wholseler_hrz .demo{ width: 951px !important;}
        .slider-container{width:125px !important}
        .Wholseller_block_hrz .owl-item{ width:168px !important}
        .primium_wholeseller ul{margin: 0; padding: 0;min-height:627px;float: none}
        .primium_wholeseller ul li{float: none; padding:0; margin:.2em auto; box-sizing: border-box;}
        .primium_wholeseller ul li .new_heading{text-align: left; padding: 1em; border-bottom: 1px solid #ccc; width: 100%; margin:0 auto;  box-sizing: border-box; font-size: 13px;} 
        .primium_wholeseller ul li .new_heading :hover{text-decoration:underline;}
        .parent_right_panel{background:none repeat scroll 0 0 #ddd}
    </style>
    <?php
}
if ($page == 'product.php')
{
    ?>

    <script type="text/javascript" src="<?php echo JS_PATH ?>owl.carousel3.js"></script>
    <!--<script src="<?php echo JS_PATH ?>easyResponsiveTabs.js" type="text/javascript"></script>-->
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>easy-responsive-tabs.css" />
    <!--        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>product.css"/>-->
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>jquery.jqzoom.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>detail.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>owl.carousel_details.css"/>
    <script type="text/javascript" src="<?php echo JS_PATH ?>script.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.bxslider.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery_cr.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.jqzoom-core.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>product.js"></script>
    <!--Lazy loading-->
    <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.lazy.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH ?>home.js"></script>
	<link rel="stylesheet" href="<?php echo CSS_PATH ?>select2.css"/>           
    <script src="<?php echo JS_PATH ?>select2.min.js"></script>


    <?php
} if ($page == 'shopping_cart.php')
{
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>shopping_cart.css"/>
    <?php
} if ($page == 'shipping_charge.php')
{
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>shopping_cart.css"/>
    <?php
} if ($page == 'product_comparison.php')
{
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>compare.css"/>
    <?php
} if ($page == 'checkout.php')
{
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>checkout.css"/>
    <?php
} if ($page == 'contact.php')
{
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>contact_us.css"/>
<?php } ?>

<?php
if ($_SESSION['sessUserInfo']['type'] == 'customer')
{
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>customer.css"/>
    <?php
} if ($page == 'payment.php')
{
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>payment.css"/>
    <?php
} if ($page == 'registration_customer.php')
{
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>registration.css"/>
    <script type="text/javascript" src="<?php echo JS_PATH ?>custom_js.js"></script>
    <?php
} if ($page == 'application_form_wholesaler.php')
{
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>registration.css"/>
    <script type="text/javascript" src="<?php echo JS_PATH ?>custom_js.js"></script>

    <?php
} if ($page == 'my_wishlist.php')
{
    ?>
    <script type="text/javascript" src="<?php echo JS_PATH ?>owl.carousel2.js"></script>

<?php } ?>


<?php
if ($_SESSION['sessUserInfo']['type'] == 'wholesaler')
{
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>wholesaler.css"/>
<?php } ?>


<!--[if IE 7]>
<style type="text/css" rel="stylesheet">
  a.setting{padding-left:37px!important;}
</style>
<![endif]-->
<script src="<?php echo JS_PATH; ?>easyResponsiveTabs.js" type="text/javascript" ></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery.cookie.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo PATH_URL_CM; ?>dp/css/msdropdown/flags.css" />
<script src="<?php echo JS_PATH ?>jquery.newsTicker.js" ></script>
<link href="<?php echo CSS_PATH; ?>owl.carousel2.css" rel="stylesheet"/>
<link href="<?php echo CSS_PATH; ?>common.css" rel="stylesheet"/>
<script type="text/javascript" src="<?php echo JS_PATH ?>allpagejs.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo PATH_URL_CM; ?>dp/css/msdropdown/dd.css" />
<link rel="stylesheet" type="text/css" href="<?php echo PATH_URL_CM; ?>css/home.css" />
<script src="<?php echo PATH_URL_CM; ?>dp/js/msdropdown/jquery.dd.min.js"></script>
<script src="<?php echo PATH_URL_CM; ?>js/mega_menu.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>xhtml.js"></script>
<!--<link href="<?php echo CSS_PATH; ?>tooltip.css" rel="stylesheet" type="text/css" />
<script src="<?php echo JS_PATH; ?>tooltip.js" type="text/javascript"></script>-->
<link href="<?php echo CSS_PATH; ?>responsive.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>accordian.css"/>
<script type="text/javascript" src="<?php echo JS_PATH ?>accordian.js"></script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="<?php echo JS_PATH ?>mailchimpScript.js"></script>