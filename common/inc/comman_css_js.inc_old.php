<?php $page =basename($_SERVER['PHP_SELF']);?>
<link rel="shortcut icon" href="<?php echo IMAGES_URL?>/favicon.ico" />
<meta name="google-translate-customization" content="1497b09e5524fc70-70348f034cf0b15f-gf96319608001e5a4-13" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>xhtml.css"/>
<link rel="stylesheet" href="<?php echo CSS_PATH; ?>font-awesome.min.css" />
<script type="text/javascript"> var SITE_ROOT_URL = '<?php echo SITE_ROOT_URL; ?>';</script>
<script type="text/javascript" src="<?php echo FRONT_JS_PATH ?>message.inc.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>validation/jquery-1.8.2.min.js"></script>
<?php 
// Telamela page wish css js call from here
if($page=='index.php'){ ?>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>main.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>jquery.jqzoom.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH ?>jquery_cr.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.jqzoom-core.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>jQueryRotate.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>home.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>owl.carousel2.js"></script>
        <script src="<?php echo JS_PATH; ?>easyResponsiveTabs.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>easy-responsive-tabs.css" />
        <style>
         .layout {width:1140px;height:auto;margin:0px auto;}
         .container{float:none}
         .btn{width:auto;}
         
      </style>
<?php }
if($page=='landing.php'){ ?>
          <script type="text/javascript" src="<?php echo JS_PATH ?>jquery-1.7.2.min.js"></script>
          <script type="text/javascript" src="<?php echo JS_PATH ?>bjqs-1.3.min.js"></script>
          <link type="text/css" rel="stylesheet" href="<?php echo CSS_PATH; ?>landing_slider.css"/>
          <script type="text/javascript" src="<?php echo JS_PATH ?>owl.carousel2.js"></script>
          <script src="<?php echo JS_PATH ?>easyResponsiveTabs.js" type="text/javascript"></script>
          <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>easy-responsive-tabs.css" />
          <script type="text/javascript" src="<?php echo JS_PATH ?>new_landing.js"></script>
          <script type="text/javascript" src="<?php echo JS_PATH ?>home.js"></script>
          <link type="text/css" rel="stylesheet" href="<?php echo CSS_PATH; ?>jquery.jqzoom.css"/>
          <script type="text/javascript" src="<?php echo JS_PATH ?>jQueryRotate.js"></script>
          <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.flip.min.js"></script>                
          <script type="text/javascript" src="<?php echo JS_PATH ?>jquery_cr.js" ></script>
          <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.jqzoom-core.js"></script>
   
      
<?php }
if($page=='category.php'){ ?>
       <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>mialn.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>style_responsive.css"/>
       
        <script type="text/javascript" src="<?php echo JS_PATH ?>owl.carousel3.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.mousewheel.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>stylish-select.js"></script>
<!--        <script type="text/javascript" src="<?php echo JS_PATH ?>bxsliderjs.js"></script>        -->
        <script type="text/javascript" src="<?php echo JS_PATH ?>jQueryRotate.js"></script>                
<!--       <script type="text/javascript" src="<?php echo JS_PATH ?>script.js"></script>-->
<!--        <script type="text/javascript" src="<?php echo JS_PATH ?>headerscroll.js"></script>-->
        <script type="text/javascript" src="<?php echo JS_PATH ?>checkboxradiojs.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo CSS_PATH ?>product.css"/>        
      <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>category.css"/>
        
        <script type="text/javascript" src="<?php echo JS_PATH ?>scriptbreaker-multiple-accordion-1.js"></script>
<!--        <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.bxslider.js"></script>-->
        <script src="<?php echo JS_PATH ?>jquery_cr.js" type="text/javascript"></script>
        <script src="<?php echo JS_PATH ?>jquery.jqzoom-core.js" type="text/javascript"></script>
<!--        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>skin.css"/>-->
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>jquery.jqzoom.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH ?>home.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>custom_js.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>jquery.range.css"/>
        <script src="<?php echo JS_PATH ?>jquery.range.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>category.js"></script>
        
        
<?php }
if($page=='product.php'){ ?>
       
        <script type="text/javascript" src="<?php echo JS_PATH ?>owl.carousel3.js"></script>
        <script src="<?php echo JS_PATH ?>easyResponsiveTabs.js" type="text/javascript"></script>
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
        <script type="text/javascript" src="<?php echo JS_PATH ?>home.js"></script>
      
<?php } if($page=='shopping_cart.php'){ ?>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>shopping_cart.css"/>
<?php } if($page=='shipping_charge.php'){ ?>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>shopping_cart.css"/>
<?php } if($page=='product_comparison.php'){ ?> 
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>compare.css"/>
<?php } if($page=='checkout.php'){ ?> 
 <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>checkout.css"/>
<?php } ?>

 <?php if ($_SESSION['sessUserInfo']['type'] == 'customer') { ?>
 <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>customer.css"/>
<?php } if($page=='payment.php'){ ?>
 <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>payment.css"/>
<?php } if($page=='registration_customer.php'){ ?>
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>registration.css"/> <?php } ?>
 <?php if ($_SESSION['sessUserInfo']['type'] == 'wholesaler') { ?> 
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>wholesaler.css"/>
 <?php } ?>


<!--[if IE 7]>
<style type="text/css" rel="stylesheet">
  a.setting{padding-left:37px!important;}
</style>
<![endif]-->
<script src="<?php echo JS_PATH; ?>easyResponsiveTabs.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery.cookie.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo PATH_URL_CM; ?>dp/css/msdropdown/flags.css" />
<script src="<?php echo JS_PATH ?>jquery.newsTicker.js"></script>
<link href="<?php echo CSS_PATH; ?>owl.carousel2.css" rel="stylesheet"/>
<link href="<?php echo CSS_PATH; ?>common.css" rel="stylesheet"/>
<script type="text/javascript" src="<?php echo JS_PATH ?>allpagejs.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo PATH_URL_CM; ?>dp/css/msdropdown/dd.css" />
<link rel="stylesheet" type="text/css" href="<?php echo PATH_URL_CM; ?>css/home.css" />
<script src="<?php echo PATH_URL_CM; ?>dp/js/msdropdown/jquery.dd.min.js"></script>
<script src="<?php echo PATH_URL_CM; ?>js/mega_menu.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH ?>xhtml.js"></script>