<?php
require_once 'common/config/config.inc.php';


?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <title>Easy Responsive Tabs to Accordion</title>
      <!--HOME PAGE ONLY-->
      <link type="text/css" rel="stylesheet" href="<?php echo CSS_PATH; ?>easy-responsive-tabs.css" />
      <script src="<?php echo JS_PATH; ?>jquery-1.9.1.min.js"></script>
      <script src="<?php echo JS_PATH; ?>easyResponsiveTabs.js" type="text/javascript"></script>
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
      <link href="<?php echo CSS_PATH; ?>owl.carousel2.css" rel="stylesheet">
      <link href="<?php echo CSS_PATH; ?>font-awesome.min.css" rel="stylesheet">
      <!--end HOME PAGE ONLY-->
      <style>
         .layout {
         width:1140px;
         height:auto;
         margin:0px auto;
         }
      </style>
   </head>
   <body>
      <div class="layout">
         <!--Start Right Section-->
         <div class="section_right">
            <div class="banners_new"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>banner_!.png"></div>
            <div class="banners_new"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>banner_2.jpg"></div>
            <div class="banners_new"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>banner_3.jpg"></div>
            <div class="banners_new"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>banner_4.jpg"></div>
            <div class="banners_new"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>banner_5.jpg"></div>
         </div>
         <!--End Start Right Section-->
         <div class="demo">
            <!--Horizontal Tab-->
            <div class="horizontalTab">
               <ul class="resp-tabs-list">
                  <span  class="heading_main"> Best Seller</span>
                  <div class="border_bar"></div>
                  <li>ALL PRODUCTS</li>
                  <li>MEN'S</li>
                  <li>WOMEN'S</li>
               </ul>
               <div class="customNavigation"> <a class="prev"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>arrow_slider-left.png" alt=""> </a> <a class="next"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>arrow_slider-right.png" alt=""></a> </div>
               <div class="resp-tabs-container">
                  <div id="demo">
                     <div class="container">
                        <div class="row">
                           <div class="span12">
                              <div  class="owl-carousel owl-demo">
                                 <!--Section Start-->
                                 <div class="item">
                                    <div class="view view-first">
                                       <div class="image_new">
                                          <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                          <div class="new_heading">reebok shoes</div>
                                          <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                          <div class="price_new"><span>$799.00</span>$699.00</div>
                                       </div>
                                       <div class="mask">
                                          <h2>Product Name<br>dszfdsfds</h2>
                                          <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                         <div class="mask_box"> <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                       </div></div>
                                    </div>
                                 </div>
                                 <!--End Section Start--> 
                                 <!--Section Start-->
                                 <div class="item">
                                    <div class="view view-first">
                                       <div class="image_new">
                                          <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                          <div class="new_heading">reebok shoes</div>
                                          <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                          <div class="price_new"><span>$799.00</span>$699.00</div>
                                       </div>
                                       <div class="mask">
                                          <h2>Product Name</h2>
                                          <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                         <div class="mask_box"> <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                       </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!--End Section Start--> 
                                 <!--Section Start-->
                                 <div class="item">
                                    <div class="view view-first">
                                       <div class="image_new">
                                          <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                          <div class="new_heading">reebok shoes</div>
                                          <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                          <div class="price_new"><span>$799.00</span>$699.00</div>
                                       </div>
                                       <div class="mask">
                                          <h2>Product Name</h2>
                                          <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                          <div class="mask_box"> <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                       </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!--End Section Start--> 
                                 <!--Section Start-->
                                 <div class="item">
                                    <div class="view view-first">
                                       <div class="image_new">
                                          <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                          <div class="new_heading">reebok shoes</div>
                                          <div class="discount_new">25%<span>OFF</span></div>
                                          <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                          <div class="price_new"><span>$799.00</span>$699.00</div>
                                       </div>
                                       <div class="mask">
                                          <h2>Product Name</h2>
                                          <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                       <div class="mask_box"> <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                       </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!--End Section Start--> 
                                 <!--Section Start-->
                                 <div class="item">
                                    <div class="view view-first">
                                       <div class="image_new">
                                          <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                          <div class="new_heading">reebok shoes</div>
                                          <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                          <div class="price_new"><span>$799.00</span>$699.00</div>
                                       </div>
                                       <div class="mask">
                                          <h2>Product Name</h2>
                                          <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                          <div class="mask_box"> <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                       </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!--End Section Start--> 
                                 <!--Section Start-->
                                 <div class="item">
                                    <div class="view view-first">
                                       <div class="image_new">
                                          <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                          <div class="new_heading">reebok shoes</div>
                                          <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                          <div class="price_new"><span>$799.00</span>$699.00</div>
                                       </div>
                                       <div class="mask">
                                          <h2>Product Name</h2>
                                          <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                       <div class="mask_box"> <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                       </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!--End Section Start--> 
                                 <!--Section Start-->
                                 <div class="item">
                                    <div class="view view-first">
                                       <div class="image_new">
                                          <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                          <div class="new_heading">reebok shoes</div>
                                          <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                          <div class="price_new"><span>$799.00</span>$699.00</div>
                                       </div>
                                       <div class="mask">
                                          <h2>Product Name</h2>
                                          <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                         <div class="mask_box"> <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                       </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!--End Section Start--> 
                                 <!--Section Start-->
                                 <div class="item">
                                    <div class="view view-first">
                                       <div class="image_new">
                                          <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                          <div class="new_heading">reebok shoes</div>
                                          <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                          <div class="price_new"><span>$799.00</span>$699.00</div>
                                       </div>
                                       <div class="mask">
                                          <h2>Product Name</h2>
                                          <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                          <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                       </div>
                                    </div>
                                 </div>
                                 <!--End Section Start--> 
                                 <!--Section Start-->
                                 <div class="item">
                                    <div class="view view-first">
                                       <div class="image_new">
                                          <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                          <div class="new_heading">reebok shoes</div>
                                          <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                          <div class="price_new"><span>$799.00</span>$699.00</div>
                                       </div>
                                       <div class="mask">
                                          <h2>Product Name</h2>
                                          <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                          <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                       </div>
                                    </div>
                                 </div>
                                 <!--End Section Start--> 
                                 <!--Section Start-->
                                 <div class="item">
                                    <div class="view view-first">
                                       <div class="image_new">
                                          <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                          <div class="new_heading">reebok shoes</div>
                                          <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                          <div class="price_new"><span>$799.00</span>$699.00</div>
                                       </div>
                                       <div class="mask">
                                          <h2>Product Name</h2>
                                          <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                          <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                       </div>
                                    </div>
                                 </div>
                                 <!--End Section Start--> 
                                 <!--Section Start-->
                                 <div class="item">
                                    <div class="view view-first">
                                       <div class="image_new">
                                          <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                          <div class="new_heading">reebok shoes</div>
                                          <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                          <div class="price_new"><span>$799.00</span>$699.00</div>
                                       </div>
                                       <div class="mask">
                                          <h2>Product Name</h2>
                                          <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                          <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                       </div>
                                    </div>
                                 </div>
                                 <!--End Section Start--> 
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div>
                     <div id="demo">
                        <div class="container">
                           <div class="row">
                              <div class="span12">
                                 <div  class="owl-carousel owl-demo">
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>guess.png" alt="">
                                             <div class="new_heading">Guess Perfume</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$122.00</span>$600.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>shoes.png" alt="">
                                             <div class="new_heading">Girls Footwear</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$222.00</span>$5.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="discount_new">25%<span>OFF</span></div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div>
                     <div id="demo">
                        <div class="container">
                           <div class="row">
                              <div class="span12">
                                 <div  class="owl-demo1">
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                           <div class="mask_box">  <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> </div>
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="discount_new">25%<span>OFF</span></div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="discount_new">25%<span>OFF</span></div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
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
         <!-- Block Start-->
         <div class="demo">
            <!--Horizontal Tab-->
            <div class="horizontalTab  border_none">
               <ul class="resp-tabs-list">
                  <span  class="heading_main"> NEW ARRIVALS</span>
                  <div class="border_bar"></div>
                  <li>ALL PRODUCTS</li>
                  <li>MEN'S</li>
                  <li>WOMEN'S</li>
               </ul>
               <div class="customNavigation"> <a class="btn prev1"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>arrow_slider-left.png" alt=""> </a> <a class="btn next1"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>arrow_slider-right.png" alt=""></a> </div>
               <div class="resp-tabs-container">
                  <div>
                     <div id="demo">
                        <div class="container">
                           <div class="row">
                              <div class="span12">
                                 <div  class="owl-carousel owl-demo1">
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="discount_new">25%<span>OFF</span></div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div>
                     <div id="demo">
                        <div class="container">
                           <div class="row">
                              <div class="span12">
                                 <div  class="owl-carousel owl-demo">
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="discount_new">25%<span>OFF</span></div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div>
                     <div id="demo">
                        <div class="container">
                           <div class="row">
                              <div class="span12">
                                 <div  class="owl-carousel owl-demo">
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="discount_new">25%<span>OFF</span></div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
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
         <!-- End Block Start--> 
         <!-- Block Start-->
         <div class="demo border_outer" >
            <!--Horizontal Tab-->
            <div class="horizontalTab">
               <ul class="resp-tabs-list"  style="width:1140px">
                  <span  class="heading_main"> Top Rated</span>
                  <div class="border_bar"></div>
                  <li>ALL PRODUCTS</li>
                  <li>MEN'S</li>
                  <li>WOMEN'S</li>
               </ul>
               <a class="btn next2"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>arrow_slider-right.png" alt=""></a>
               <div class="resp-tabs-container" style="width:1140px;">
                  <div>
                     <div id="demo">
                        <a class="btn prev2"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>arrow_slider-left.png" alt=""> </a>
                        <div class="container">
                           <div class="row">
                              <div class="span12">
                                 <div  class="owl-carousel owl-demo2">
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first top_rated">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>chair.jpg" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2 class="heading_new">Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info btn_new">Quick View</a> <a href="#" class="info btn_new">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first top_rated">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>footwear.jpg" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2 class="heading_new">Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info btn_new">Quick View</a> <a href="#" class="info btn_new">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first top_rated">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>chair.jpg" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2 class="heading_new">Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info btn_new">Quick View</a> <a href="#" class="info btn_new">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first top_rated">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>footwear.jpg" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2 class="heading_new">Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info btn_new">Quick View</a> <a href="#" class="info btn_new">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first top_rated">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>footwear.jpg" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2 class="heading_new">Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info btn_new">Quick View</a> <a href="#" class="info btn_new">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first top_rated">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>chair.jpg" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2 class="heading_new">Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info btn_new">Quick View</a> <a href="#" class="info btn_new">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first top_rated">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>footwear.jpg" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2 class="heading_new">Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info btn_new">Quick View</a> <a href="#" class="info btn_new">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first top_rated">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>chair.jpg" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2 class="heading_new">Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info btn_new">Quick View</a> <a href="#" class="info btn_new">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first top_rated">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>chair.jpg" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2 class="heading_new">Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info btn_new">Quick View</a> <a href="#" class="info btn_new">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first top_rated">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>footwear.jpg" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2 class="heading_new">Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info btn_new">Quick View</a> <a href="#" class="info btn_new">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first top_rated">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>footwear.jpg" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2 class="heading_new">Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info btn_new">Quick View</a> <a href="#" class="info btn_new">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div>
                     <div id="demo">
                        <div class="container">
                           <div class="row">
                              <div class="span12">
                                 <div  class="owl-carousel owl-demo">
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="discount_new">25%<span>OFF</span></div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div>
                     <div id="demo">
                        <div class="container">
                           <div class="row">
                              <div class="span12">
                                 <div  class="owl-carousel owl-demo">
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="discount_new">25%<span>OFF</span></div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                    <!--Section Start-->
                                    <div class="item">
                                       <div class="view view-first">
                                          <div class="image_new">
                                             <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                             <div class="new_heading">reebok shoes</div>
                                             <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="price_new"><span>$799.00</span>$699.00</div>
                                          </div>
                                          <div class="mask">
                                             <h2>Product Name</h2>
                                             <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                             <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                          </div>
                                       </div>
                                    </div>
                                    <!--End Section Start--> 
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- End Block Start-->
         <div style="width:873px; float:left">
            <!-- Block Start-->
            <div class="demo">
               <!--Horizontal Tab-->
               <div class="horizontalTab">
                  <ul class="resp-tabs-list">
                     <span  class="heading_main"> NEW ARRIVALS</span>
                     <div class="border_bar"></div>
                     <li>ALL PRODUCTS</li>
                     <li>MEN'S</li>
                     <li>WOMEN'S</li>
                  </ul>
                  <div class="customNavigation"> <a class="btn prev3"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>arrow_slider-left.png" alt=""> </a> <a class="btn next3"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>arrow_slider-right.png" alt=""></a> </div>
                  <div class="resp-tabs-container">
                     <div>
                        <div id="demo">
                           <div class="container">
                              <div class="row">
                                 <div class="span12">
                                    <div  class="owl-carousel owl-demo3">
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="discount_new">25%<span>OFF</span></div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div>
                        <div id="demo">
                           <div class="container">
                              <div class="row">
                                 <div class="span12">
                                    <div  class="owl-carousel owl-demo">
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="discount_new">25%<span>OFF</span></div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div>
                        <div id="demo">
                           <div class="container">
                              <div class="row">
                                 <div class="span12">
                                    <div  class="owl-carousel owl-demo">
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="discount_new">25%<span>OFF</span></div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
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
            <!-- End Block Start--> 
            <!-- Block Start-->
            <div class="demo">
               <!--Horizontal Tab-->
               <div class="horizontalTab border_change">
                  <ul class="resp-tabs-list">
                     <span  class="heading_main recom">Recommendation for you </span>
                     <div class="border_bar recom"></div>
                  </ul>
                  <div class="customNavigation"> <a class="btn prev4"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>arrow_slider-left.png" alt=""> </a> <a class="btn next4"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>arrow_slider-right.png" alt=""></a> </div>
                  <div class="resp-tabs-container">
                     <div>
                        <div id="demo">
                           <div class="container">
                              <div class="row">
                                 <div class="span12">
                                    <div  class="owl-carousel owl-demo4">
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="discount_new">25%<span>OFF</span></div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                       <!--Section Start-->
                                       <div class="item">
                                          <div class="view view-first">
                                             <div class="image_new">
                                                <img src="<?php echo IMAGE_FRONT_PATH_URL;?>product_!.png" alt="">
                                                <div class="new_heading">reebok shoes</div>
                                                <div class="unactive">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                                <div class="price_new"><span>$799.00</span>$699.00</div>
                                             </div>
                                             <div class="mask">
                                                <h2>Product Name</h2>
                                                <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
                                                <a href="#" class="info">Quick View</a> <a href="#" class="info">Add to Cart</a> 
                                             </div>
                                          </div>
                                       </div>
                                       <!--End Section Start--> 
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div> </div>
                     <div> </div>
                  </div>
               </div>
            </div>
            <!-- End Block Start--> 
         </div>
         <div class="main_verified">
            <div class="verfied">
              <a class="btn prev6 veri_left"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>arrow_ver.jpg" alt=""> </a> <a class="btn next6 veri_right"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>arrow_ver_right.jpg" alt=""></a> 
               <div class="veri_heading">Verified Suppliers</div>
               <p>Trade with Confidence across the globe.</p>
               <div id="demo">
                  <div class="container">
                     <div class="row">
                        <div class="span12">
                           <div  class="owl-demo6">
                              <!--Section Start-->
                              <div class="item">
                                 <div class="heading_new1">China(Mainland)</div>
                                 <div class="veri_img"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>verfied.jpg" alt=""></div>
                                 <div class="veri_txt">Trade with Confidence athe globe</div>
                                 <p class="verified_txt" >Trade with Confidence athe globe.Trade with Confidence athe globe.Trade with Confidence athe globe.Trade with Confidence athe globe.Trade with Confidence athe globe. Trade with Confidence athe globe. Trade with Confidence athe globe.</p>
                                 <p class="connect"> Recents Connects  : 1992</p>
                              </div>
                              <!--End Section Start--> 
                              <!--Section Start-->
                              <div class="item">
                                 <div class="heading_new1">China(Mainland)</div>
                                 <div class="veri_img"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>verfied.jpg" alt=""></div>
                                 <div class="veri_txt">Trade with Confidence athe globe</div>
                                 <p class="verified_txt" >Trade with Confidence athe globe.Trade with Confidence athe globe.Trade with Confidence athe globe.Trade with Confidence athe globe.Trade with Confidence athe globe. Trade with Confidence athe globe. Trade with Confidence athe globe.</p>
                                 <p class="connect"> Recents Connects  : 1992</p>
                              </div>
                              <!--End Section Start--> 
                              <!--Section Start-->
                              <div class="item">
                                 <div class="heading_new1">China(Mainland)</div>
                                 <div class="veri_img"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>verfied.jpg" alt=""></div>
                                 <div class="veri_txt">Trade with Confidence athe globe</div>
                                 <p class="verified_txt" >Trade with Confidence athe globe.Trade with Confidence athe globe.Trade with Confidence athe globe.Trade with Confidence athe globe.Trade with Confidence athe globe. Trade with Confidence athe globe. Trade with Confidence athe globe.</p>
                                 <p class="connect"> Recents Connects  : 1992</p>
                              </div>
                              <!--End Section Start--> 
                              <!--Section Start-->
                              <div class="item">
                                 <div class="heading_new1">China(Mainland)</div>
                                 <div class="veri_img"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>verfied.jpg" alt=""></div>
                                 <div class="veri_txt">Trade with Confidence athe globe</div>
                                 <p class="verified_txt" >Trade with Confidence athe globe.Trade with Confidence athe globe.Trade with Confidence athe globe.Trade with Confidence athe globe.Trade with Confidence athe globe. Trade with Confidence athe globe. Trade with Confidence athe globe.</p>
                                 <p class="connect"> Recents Connects  : 1992</p>
                              </div>
                              <!--End Section Start--> 
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="bg_white">
                  <div class="content">Source by Region   :</div>
                  <ul class="country">
                     <li><img src="<?php echo IMAGE_FRONT_PATH_URL;?>us.jpg" alt=""><span>US</span></li>
                     <li><img src="<?php echo IMAGE_FRONT_PATH_URL;?>in.jpg" alt=""><span>India</span></li>
                     <li><img src="<?php echo IMAGE_FRONT_PATH_URL;?>ch.jpg" alt=""><span>China</span></li>
                     <li><img src="<?php echo IMAGE_FRONT_PATH_URL;?>mal.jpg" alt=""><span>Malaysia</span></li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
          
          <div id="nt-example1-container">
   <div class="fixed_card">My Cart (3)</div>
						<i  class="fa fa-angle-up" id="nt-example1-prev"></i>
		                <ul id="nt-example1">
		                    <li><div class="cart_img"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>cart.jpg" alt=""></div> <div class="new_heading">reebok shoes</div>
                                             <div class="cart_content">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="cart_price"><span>$799.00</span>$699.00</div></li>
											 
											   <li><div class="cart_img"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>cart.jpg" alt=""></div> <div class="new_heading">reebok shoes</div>
                                             <div class="cart_content">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="cart_price"><span>$799.00</span>$699.00</div></li>
											   <li><div class="cart_img"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>cart.jpg" alt=""></div> <div class="new_heading">reebok shoes</div>
                                             <div class="cart_content">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="cart_price"><span>$799.00</span>$699.00</div></li>
											   <li><div class="cart_img"><img src="<?php echo IMAGE_FRONT_PATH_URL;?>cart.jpg" alt=""></div> <div class="new_heading">reebok shoes</div>
                                             <div class="cart_content">Lorem ipsum dolor sit amet, consectetur adipiscing </div>
                                             <div class="cart_price"><span>$799.00</span>$699.00</div></li>
		                  
		                </ul>
		                <i  class="fa fa-angle-down" id="nt-example1-next"></i>
		            </div>
   </body>
   <script type="text/javascript">
      $(document).ready(function () {
          $('.horizontalTab').easyResponsiveTabs({
              type: 'default', //Types: default, vertical, accordion           
              width: '1000px', //auto or any width like 600px
              fit: true,   // 100% fit in a container
              closed: 'accordion', // Start closed if in accordion view
              activate: function(event) { // Callback function if tab is switched
                  var $tab = $(this);
                  
                  var $info = $('#tabInfo');
                  var $name = $('span', $info);
                  
                  $name.text($tab.text());
                  $info.show();
              }
          });
      
          $('.verticalTab').easyResponsiveTabs({
              type: 'vertical',
              width: 'auto',
              fit: true
          });
      });
   </script>
   <script src="<?php echo PATH_URL_CM; ?>js/owl.carousel.js"></script>
   <script>
      $(document).ready(function() {
      
        var owl = $(".owl-demo");
      
        owl.owlCarousel({
      
        items :3, //10 items above 1000px browser width
        itemsDesktop : [1000,5], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
        
        });
      
        // Custom Navigation Events
        $(".next").click(function(){
          owl.trigger('owl.next');
        })
        $(".prev").click(function(){
          owl.trigger('owl.prev');
        });
      
      
      
        var owl1 = $(".owl-demo1");
      
        owl1.owlCarousel({
      
        items :3, //10 items above 1000px browser width
        itemsDesktop : [1000,5], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
        
        });
      
        // Custom Navigation Events
        $(".next1").click(function(){
      
          owl1.trigger('owl.next');
        })
        $(".prev1").click(function(){
          owl1.trigger('owl.prev');
        })
      
      
      var owl2 = $(".owl-demo2");
      
        owl2.owlCarousel({
      
        items :5, //10 items above 1000px browser width
        itemsDesktop : [1000,5], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
        
        });
      
        // Custom Navigation Events
        $(".next2").click(function(){
      
          owl2.trigger('owl.next');
        })
        $(".prev2").click(function(){
          owl2.trigger('owl.prev');
        })
      
      
      var owl3 = $(".owl-demo3");
      
        owl3.owlCarousel({
      
        items :3, //10 items above 1000px browser width
        itemsDesktop : [1000,5], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
        
        });
      
        // Custom Navigation Events
        $(".next3").click(function(){
      
          owl3.trigger('owl.next');
        })
        $(".prev3").click(function(){
          owl2.trigger('owl.prev');
        })
      
      var owl4 = $(".owl-demo4");
      
        owl4.owlCarousel({
      
        items :3, //10 items above 1000px browser width
        itemsDesktop : [1000,5], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,5], // 3 items betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
        
        });
      
        // Custom Navigation Events
        $(".next4").click(function(){
      
          owl4.trigger('owl.next');
        })
        $(".prev4").click(function(){
          owl2.trigger('owl.prev');
        })
      
      var owl6 = $(".owl-demo6");
      
        owl6.owlCarousel({
      
        items :1, //10 items above 1000px browser width
        itemsDesktop : [1000,5], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,5], // 3 items betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
        
        });
      
        // Custom Navigation Events
        $(".next6").click(function(){
      
          owl6.trigger('owl.next');
        })
        $(".prev6").click(function(){
          owl6.trigger('owl.prev');
        })
      
       
      });
        </script> 
   <script src="<?php echo PATH_URL_CM; ?>js/jquery.newsTicker.js"></script>
    <script>
    		
            var nt_example1 = $('#nt-example1').newsTicker({
                row_height: 200,
                max_rows: 3,
                duration: 4000,
                prevButton: $('#nt-example1-prev'),
                nextButton: $('#nt-example1-next')
            });
         
        </script>
</html>