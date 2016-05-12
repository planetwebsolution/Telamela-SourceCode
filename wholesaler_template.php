<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_PRODUCT_CTRL;
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;
$templateId = $_REQUEST['tmpid'];
$templateName = "template".$templateId;
$wholasaler = $objPage->arrwholesalerDetails[0]; 

if($templateId==1){
	/*
	 
	 array
(
    [0] => Array
        (
            [pkProductID] => 6705
            [fkCategoryID] => 16
            [ProductRefNo] => my test product 101
            [fkWholesalerID] => 5
            [fkShippingID] => 2,3,4
            [ProductName] => my test product 101
            [ProductImage] => 20140701_114045_524602701.jpg
            [ProductSliderImage] => 
            [wholesalePrice] => 58.0000
            [FinalPrice] => 60.9000
            [DiscountPrice] => 0.0000
            [DiscountFinalPrice] => 0.0000
            [DateStart] => 0000-00-00
            [DateEnd] => 0000-00-00
            [Quantity] => 8
            [QuantityAlert] => 1
            [Weight] => 4.53000000
            [WeightUnit] => kg
            [Length] => 10.00000000
            [Width] => 10.00000000
            [Height] => 10.00000000
            [DimensionUnit] => cm
            [fkPackageId] => 6
            [ProductDescription] => my test product 101
            [ProductTerms] => my test product 101
            [YoutubeCode] => u-j1nx_HY5o
            [HtmlEditor] => my test product 101
            [MetaTitle] => my test product 101
            [MetaKeywords] => my test product 101
            [MetaDescription] => my test product 101
            [IsFeatured] => 0
            [ProductStatus] => 1
            [CreatedBy] => admin
            [fkCreatedID] => 1
            [UpdatedBy] => wholesaler
            [fkUpdatedID] => 5
            [IsAddedBulkUpload] => 0
            [LastViewed] => 2014-09-01 00:26:56
            [Sold] => 1
            [ProductDateAdded] => 2014-01-06 23:30:32
            [ProductDateUpdated] => 2014-07-17 19:30:14
            [ProductCronUpdate] => 2014-07-18
        )
        
Array
(
    [0] => Array
        (
            [pkWholesalerID] => 5
            [CompanyName] => Suraj Saler
            [AboutCompany] => this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing 
            [Services] => this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing this is testing 
            [Commission] => 90.00
            [CompanyAddress1] => f-2
            [CompanyAddress2] =>  udhog nagar
            [CompanyCity] => Boca Raton
            [CompanyCountry] => 223
            [CompanyRegion] => 0
            [CompanyPostalCode] => 85705
            [CompanyWebsite] => http://google.com
            [CompanyEmail] => suraj.maurya@mail.vinove.com
            [CompanyPassword] => e10adc3949ba59abbe56e057f20f883e
            [PaypalEmail] => suraj.maurya@mail.vinove.com
            [CompanyPhone] => 1236547890
            [CompanyFax] => 
            [Opt1CompanyAddress1] => 
            [Opt1CompanyAddress2] => 
            [Opt1CompanyCity] => 
            [Opt1CompanyCountry] => 0
            [Opt1CompanyPostalCode] => 
            [Opt1CompanyWebsite] => 
            [Opt1CompanyEmail] => 
            [Opt1Companyphone] => 
            [Opt1CompanyFax] => 
            [Opt2CompanyAddress1] => 
            [Opt2CompanyAddress2] => 
            [Opt2CompanyCity] => 
            [Opt2CompanyCountry] => 0
            [Opt2CompanyPostalCode] => 
            [Opt2CompanyWebsite] => 
            [Opt2CompanyEmail] => 
            [Opt2Companyphone] => 
            [Opt2CompanyFax] => 
            [ContactPersonName] => Suraj Kumar Maurya
            [ContactPersonPosition] => developer
            [ContactPersonPhone] => 123456987
            [ContactPersonEmail] => suraj@mail.com
            [ContactPersonAddress] => 1234567890
            [OwnerName] => Suraj Kumar Maurya
            [OwnerPhone] => 43534535
            [OwnerEmail] => abc@gmail.co
            [OwnerAddress] => 110041
            [Ref1Name] => suraj
            [Ref1Phone] => 558976
            [Ref1Email] => sur@as.com
            [Ref1CompanyName] => vss
            [Ref1CompanyAddress] => sector 44
            [Ref2Name] => suraj
            [Ref2Phone] => 456987
            [Ref2Email] => suraj@mail.vom
            [Ref2CompanyName] => vss
            [Ref2CompanyAddress] => sector44
            [Ref3Name] => suraj
            [Ref3Phone] => 4587961
            [Ref3Email] => suraj@mail.com
            [Ref3CompanyName] => vss
            [Ref3CompanyAddress] => sector44
            [WholesalerStatus] => active
            [IsEmailVerified] => 1
            [WholesalerAPIKey] => 326B079FC0867D99EC3CB5E2B7586A88
            [WholesalerDateAdded] => 2014-01-14 23:05:49
            [WholesalerDateUpdated] => 2014-09-03 22:19:02
            [WholesalerForgotPWCode] => 
        )

)	 
	 * */
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />    
		<title>Wholesaler template</title>
		<meta name="author"  />
		<link href="<?php echo SITE_ROOT_URL;?>common/wholesaler_template/<?php echo $templateName;?>/css/style.css" rel="stylesheet" type="text/css"  />
		<link href="common/wholesaler_template/<?php echo $templateName;?>/css/owl.carousel.css" rel="stylesheet" type="text/css" />
		<link href="common/wholesaler_template/<?php echo $templateName;?>/css/owl.theme.css" rel="stylesheet" type="text/css" />
		<link href="common/wholesaler_template/<?php echo $templateName;?>/css/media.css" rel="stylesheet" type="text/css" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'/>
		<!-- Date: 2014-08-25 -->
		<script>
		function showWholesalerContent(conId)
		{
				//home products_outer  about_us services business_plan testimonials shipping contact_us
				/*if(conId=='home'){
					$('.products_outer').css({'display':'block'});
					$('#about_us').css({'display':'block'});
					//,'height':'200px','overflow-y':'scroll'
				}else{
					$('.products_outer').css({'display':'none'});
					$('.content').css({'display':'none'});
					$('#'+conId).css({'display':'block'});
					$('.nav').find('li').removeClass();
					$('#nav_'+conId).parent().addClass('activeli');
				}	*/	
			$('.min-height-box').css({'display':'none'});	
			$('#'+conId).css({'display':'block'});
			$('.nav').find('li').removeClass();
			$('#nav_'+conId).parent().addClass('activeli');
		}
		</script>
	</head>
	<body>
		<div class="outer_container">
			<div class="header">
				<?php if(file_exists(UPLOADED_FILES_SOURCE_PATH . "images/wholesaler_logo/" . $wholasaler['wholesalerLogo'])){ ?>
				<img src="<?php echo UPLOADED_FILES_URL."images/wholesaler_logo/".$wholasaler['wholesalerLogo']; ?>" alt="<?php echo $wholasaler['CompanyName']; ?>" style="height:93px;"  />
				<?php }else{ ?>
				<img src="common/wholesaler_template/<?php echo $templateName;?>/images/logo.png" alt="Company Logo"  />
				<?php } ?>
			</div>
			<div class="menu"><h3>Menu</h3></div>
			<div class="nav">
				<ul>
					<li class="activeli">
						<a href="javascript:void(0)" onclick="showWholesalerContent('home','nav_home')" id="nav_home">Home</a>
					</li>
					<li>
						<a href="javascript:void(0)" onclick="showWholesalerContent('about_us')" id="nav_about_us">About</a>
					</li>
					<li>
						<a href="javascript:void(0)" onclick="showWholesalerContent('services')" id="nav_services">Services</a>
					</li>
					<li>
						<a href="javascript:void(0)" onclick="showWholesalerContent('business_plan')" id="nav_business_plan">Business Plan</a>
					</li>
					<li>
						<a href="javascript:void(0)" onclick="showWholesalerContent('testimonials')" id="nav_testimonials">Testimonials</a>
					</li>
					<li>
						<a href="javascript:void(0)" onclick="showWholesalerContent('contact_us')" id="nav_contact_us">Contact Us</a>
					</li>
				</ul>

			</div>
			<div class="slide_section">
				
					<div class="slideshow">

						<div id="owl-demo" class="owl-carousel">
							<?php if(count($wholasaler['Sliderimage'])>0){ 
									foreach($wholasaler['Sliderimage'] as $slider){
										if(file_exists(UPLOADED_FILES_SOURCE_PATH . "images/wholesaler_slider/" . $slider['sliderImage'])){
							?>							
							<div class="item"><img src="<?php echo UPLOADED_FILES_URL."images/wholesaler_slider/".$slider['sliderImage']; ?>" style="width:784px;height:311px;" alt="<?php echo $wholasaler['CompanyName']; ?>">
								<h2 class="big"><?php echo $wholasaler['CompanyName']; ?></h2>
							</div>
							<?php
										}
									}	 
								}else{ ?>							
							<div class="item"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/slide1.jpg" alt="pic">
								<h2 class="big">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h2>
							</div>
							<?php } ?>						
						</div>

					</div>

			</div>
			<div class="min-height-box" id="home">
				<div class="products_outer">
					<div class="products_box">
						<?php foreach($wholasaler['Topproduct'] as $product){
							$tc++;  
						?>
						<div class="my_product <?php echo $tc==1?'mlz':''; ?>">
							<div class="pro_img">
								<div class="img_center">
									<a target="_parent" href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>"><img src="<?php echo $objCore->getImageUrl($product['ProductImage'], 'products/' . $arrProductImageResizes['detail']); ?>"  title="<?php echo $product['ProductName']; ?>"  style="width:235px; height:210px" /></a>
								</div>
							</div>
							<div class="pro_details">
								<div class="fleft">
									<h3><a target="_parent" href="<?php echo $objCore->getUrl('product.php', array('id' => $product['pkProductID'], 'name' => $product['ProductName'], 'refNo' => $product['ProductRefNo'])); ?>"><?php echo strlen($product['ProductName'])>20?substr($product['ProductName'],0,20)."...":$product['ProductName'];?></a></h3>
									<!-- <p>
										<span class="label">Color :</span><span class="value">blue</span>
									</p>
									<p>
										<span class="label">Size :</span><span class="value">M</span>
									</p> -->
								</div>
								<div class="fright">
									<?php echo $objCore->getFinalPrice($product['FinalPrice'], $product['DiscountFinalPrice'], $product['FinalSpecialPrice'], 0, 1); ?>
								</div>
	
							</div>
						</div>
						<?php } ?>
						<?php foreach($wholasaler['Newproduct'] as $product){
							$nc++;  
						?>
						<div class="my_product <?php echo $nc==1?'mlz':''; ?>">
							<div class="pro_img">
								<div class="img_center">
									<a href="#"><img src="<?php echo $objCore->getImageUrl($product['ProductImage'], 'products/' . $arrProductImageResizes['detail']); ?>"  title="<?php echo $product['ProductName']; ?>"  style="width:235px; height:210px" /></a>
								</div>
							</div>
							<div class="pro_details">
								<div class="fleft">
									<h3><a href="#"><?php echo strlen($product['ProductName'])>20?substr($product['ProductName'],0,20)."...":$product['ProductName'];?></a></h3>
									<!-- <p>
										<span class="label">Color :</span><span class="value">blue</span>
									</p>
									<p>
										<span class="label">Size :</span><span class="value">M</span>
									</p> -->
								</div>
								<div class="fright">
									<?php echo $objCore->getFinalPrice($product['FinalPrice'], $product['DiscountFinalPrice'], $product['FinalSpecialPrice'], 0, 1); ?>
								</div>
	
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="content">
					<h2 class="heading">About Us</h2>
					<p><?php echo (strlen($wholasaler['AboutCompany'])>300?substr($wholasaler['AboutCompany'],0,300)."...":$wholasaler['AboutCompany']);?></p>
				</div>
			</div>			
			<div class="min-height-box ndis" id="about_us">
				<div class="content">
					<h2 class="heading">About Us</h2>
					<p><?php echo $wholasaler['AboutCompany'];?></p>
				</div>
			</div>
			<div class="min-height-box ndis" id="services">
				<div class="content">
					<h2 class="heading">Services</h2>
					<p><?php echo $wholasaler['Services'];?></p>
				</div>
			</div>
			<div class="min-height-box ndis" id="business_plan">
				<div class="content">
					<h2 class="heading">Business Plan</h2>
					<p><ul><?php foreach($wholasaler['BusinessPlan'] as $BusinessPlan){if(file_exists(UPLOADED_FILES_SOURCE_PATH.'files/wholesaler/'.$BusinessPlan['DocumentName'])){echo '<li><a href="'.UPLOADED_FILES_URL.'files/wholesaler/'.$BusinessPlan['DocumentName'].'" target="_parent">'.$BusinessPlan['FileName'].'</a></li>';}};?></ul></p>
				</div>
			</div>
			<div class="min-height-box ndis" id="testimonials">
				<div class="content">
					<h2 class="heading">Testimonials</h2>
					<p><ul><?php foreach($wholasaler['Testimonial'] as $testimonial){echo '<li><b>'.$testimonial['customerName'].'</b> on '.$testimonial['ReviewDateAdded'].'<p>'.$testimonial['Reviews'].'</p></li>';};?></ul></p>
				</div>
			</div>
			<div class="min-height-box ndis" id="shipping">
				<div class="content">
					<h2 class="heading">Shipping</h2>
					<p><ul><?php foreach($wholasaler['Shipping'] as $shipping){echo '<li>'.$shipping['ShippingTitle'].'</span></li>';}?></ul></p>
				</div>
			</div>
			<div class="min-height-box ndis" id="contact_us">
			<div class="content">
				<h2 class="heading">Contact Us</h2>
				<p><label>Name: </label><?php echo $wholasaler['ContactPersonName']; ?>(<?php echo $wholasaler['ContactPersonPosition']; ?>)<br/>
				<label>Phone: </label><?php echo $wholasaler['ContactPersonPhone']; ?><br/>
				<label>Email: </label><?php echo $wholasaler['ContactPersonEmail']; ?><br/>
				<label>Address: </label><?php echo $wholasaler['ContactPersonAddress']; ?><br/>
				</p>
			</div>
			</div>
			<div class="footer">                                     
				<ul class="footerlinks">
					<li><a href="javascript:void(0)" onclick="showWholesalerContent('home')">Home</a></li>
					<li><a href="javascript:void(0)" onclick="showWholesalerContent('about_us')">About</a></li>
					<li><a href="javascript:void(0)" onclick="showWholesalerContent('services')">Services</a></li>
					<li><a href="javascript:void(0)" onclick="showWholesalerContent('business_plan')">Business Plan</a></li>
					<li><a href="javascript:void(0)" onclick="showWholesalerContent('testimonials')">Testimonials</a></li>
					<li><a href="javascript:void(0)" onclick="showWholesalerContent('shipping')">Shipping</a></li>
					<li><a target="_parent" href="<?php echo SITE_ROOT_URL."messages_inbox.php?&place=inbox" ?>">Support</a></li>
					<li><a href="javascript:void(0)" onclick="showWholesalerContent('contact_us')">Contact Us</a></li>
				</ul>
				
				<p class="copyright">Copyright © <?php echo date("Y")." ".$wholasaler['CompanyName'];?>. All Rights Reserved.</p>

			</div>

			<div class="clear"></div>
		</div>
		
		<script src="common/wholesaler_template/<?php echo $templateName;?>/js/jquery-1.9.1.min.js"></script>
		<script src="common/wholesaler_template/<?php echo $templateName;?>/js/owl.carousel.js"></script>
	
		<!-- Demo -->

		<style>
			#owl-demo .item img {
				display: block;
				width: 100%;
				height: auto;
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

					// "singleItem:true" is a shortcut for:
					// items : 1,
					// itemsDesktop : false,
					// itemsDesktopSmall : false,
					// itemsTablet: false,
					// itemsMobile : false

				});
			});
			
			
			$(".menu").click(function(){
				$(".nav").stop().slideToggle(350);
				
			});
		</script>

	</body>
</html>
<?php 
}else if($templateId==2){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Wholesaler template</title>
		<meta name="author"  />
		<link href="<?php echo SITE_ROOT_URL;?>common/wholesaler_template/<?php echo $templateName;?>/css/style.css" rel="stylesheet" type="text/css"  />
		<link href="common/wholesaler_template/<?php echo $templateName;?>/css/owl.carousel.css" rel="stylesheet" type="text/css" />
		<link href="common/wholesaler_template/<?php echo $templateName;?>/css/owl.theme.css" rel="stylesheet" type="text/css" />
		<link href="common/wholesaler_template/<?php echo $templateName;?>/css/media.css" rel="stylesheet" type="text/css" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'/>
		<!-- Date: 2014-08-25 -->
	</head>
	<body>

		<div class="outer_container">
			<div class="header">
				<div class="logo">
					<a href="" class="logoimg"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/logo.png" alt="company Logo" /></a>

				</div>
				<div class="h_fright">
					<ul class="social">
						<li>
							<a href="#"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/fb.png" /></a>
						</li>
						<li>
							<a href="#"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/twitter.png" /></a>
						</li>
						<li>
							<a href="#"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/linkedin.png" /></a>
						</li>
						<li>
							<a href="#"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/rss.png" /></a>
						</li>
						<li>
							<a href="#"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/google.png" /></a>
						</li>
					</ul>

					<div class="search_box">
						<input type="text" />
						<input type="button" class="searchbutton" />

					</div>

				</div>

			</div>
	<div class="menu"><h3>Menu</h3></div>			
<div class="nav">
				<ul>
					<li>
						<a href="#">Home</a>
					</li>
					<li>
						<a href="#">Products</a>
					</li>
					<li>
						<a href="#">Services</a>
					</li>
					<li>
						<a href="#">Offers</a>
					</li>
					<li>
						<a href="#">Services</a>
					</li>
					<li>
						<a href="#">Testimonials</a>
					</li>
					<li>
						<a href="#">Contact Us</a>
					</li>

				</ul>

			</div>
			<div class="slide_section">

				<div class="slideshow">

					<div id="owl-demo" class="owl-carousel">

						<div class="item"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/slide1.jpg" alt="pic">
						</div>

						<div class="item"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/slide1.jpg" alt="pic">
						</div>

						<div class="item"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/slide1.jpg" alt="pic">
						</div>

					</div>

				</div>

			</div>
			<div class="padd_content">
				<div class="offers">
					<div class="offer_sec">
						<div class="offer_img">
							<a href="#"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/offer1.jpg" /></a>
						</div>

						<a class="more" href="#">Click here for more details</a>

					</div>
					<div class="offer_sec">
						<div class="offer_img">
							<a href="#"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/offer2.jpg" /></a>

						</div>
						<a class="more" href="#">Click here for more details</a>
					</div>
				</div>

				<h3 class="heading">New Products</h3>

				<div class="product_box" >
					<div class="product">
						<div class="myimg">
							<a href="#"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/product_img.jpg"   /></a>
						</div>
						<div class="img_details">
							<p class="pname">
								JBL LSR43125P 12 Inch Subwoofer
							</p>
							<p class="price">
								$73.12
							</p>
							<div class="fullwidth">
								<a class="addtocart" href="#">ADD to cart</a>
							</div>

						</div>

					</div>
					<div class="product">
						<div class="myimg">
							<a href="#"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/product_img2.jpg"   /></a>
						</div>
						<div class="img_details">
							<p class="pname">
								JBL LSR43125P 12 Inch Subwoofer
							</p>
							<p class="price">
								$73.12
							</p>
							<div class="fullwidth">
								<a class="addtocart" href="#">ADD to cart</a>
							</div>

						</div>
						
					</div>
					<div class="product">
						
						<div class="myimg">
							<a href="#"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/product_img3.jpg"   /></a>
						</div>
						<div class="img_details">
							<p class="pname">
								JBL LSR43125P 12 Inch Subwoofer
							</p>
							<p class="price">
								$73.12
							</p>
							<div class="fullwidth">
								<a class="addtocart" href="#">ADD to cart</a>
							</div>

						</div>
					</div>
					<div class="product mrz">
						<div class="myimg">
							<a href="#"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/product_img4.jpg"   /></a>
						</div>
						<div class="img_details">
							<p class="pname">
								JBL LSR43125P 12 Inch Subwoofer
							</p>
							<p class="price">
								$73.12
							</p>
							<div class="fullwidth">
								<a class="addtocart" href="#">ADD to cart</a>
							</div>

						</div>
						
					</div>
					<div class="product">
						<div class="myimg">
							<a href="#"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/product_img.jpg"   /></a>
						</div>
						<div class="img_details">
							<p class="pname">
								JBL LSR43125P 12 Inch Subwoofer
							</p>
							<p class="price">
								$73.12
							</p>
							<div class="fullwidth">
								<a class="addtocart" href="#">ADD to cart</a>
							</div>

						</div>
						
					</div>
					<div class="product">
						<div class="myimg">
							<a href="#"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/product_img2.jpg"   /></a>
						</div>
						<div class="img_details">
							<p class="pname">
								JBL LSR43125P 12 Inch Subwoofer
							</p>
							<p class="price">
								$73.12
							</p>
							<div class="fullwidth">
								<a class="addtocart" href="#">ADD to cart</a>
							</div>

						</div>
						
					</div>
					<div class="product">
						<div class="myimg">
							<a href="#"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/product_img3.jpg"   /></a>
						</div>
						<div class="img_details">
							<p class="pname">
								JBL LSR43125P 12 Inch Subwoofer
							</p>
							<p class="price">
								$73.12
							</p>
							<div class="fullwidth">
								<a class="addtocart" href="#">ADD to cart</a>
							</div>

						</div>
						
						
					</div>
					<div class="product mrz">
						<div class="myimg">
							<a href="#"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/product_img4.jpg"   /></a>
						</div>
						<div class="img_details">
							<p class="pname">
								JBL LSR43125P 12 Inch Subwoofer
							</p>
							<p class="price">
								$73.12
							</p>
							<div class="fullwidth">
								<a class="addtocart" href="#">ADD to cart</a>
							</div>

						</div>
						
					</div>
					

				</div>

			</div>
			<div class="footer">
				<div class="copyright">
					<p>© 2014 Audio Gear 2 Store. All Rights Reserved.</p>
				</div>
				<div class="address">
					<p>8901 Marmora Road,Glasgow, D04 89GR
						<br/>
+1(800)2345-6789, sales@radiostore.com</p>
					
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<script src="common/wholesaler_template/<?php echo $templateName;?>/js/jquery-1.9.1.min.js"></script>
		<script src="common/wholesaler_template/<?php echo $templateName;?>/js/owl.carousel.js"></script>

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
			});

			$(".menu").click(function() {
				$(".nav").stop().slideToggle(350);

			});
		</script>

	</body>
</html>

<?php 	
}else if($templateId==3){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Wholesaler template</title>
		<meta name="author"  />
		<link href="common/wholesaler_template/<?php echo $templateName;?>/css/style.css" rel="stylesheet" type="text/css"  />
		<link href="common/wholesaler_template/<?php echo $templateName;?>/css/owl.carousel.css" rel="stylesheet" type="text/css" />
		<link href="common/wholesaler_template/<?php echo $templateName;?>/css/owl.theme.css" rel="stylesheet" type="text/css" />
		<link href="common/wholesaler_template/<?php echo $templateName;?>/css/media.css" rel="stylesheet" type="text/css" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'/>
		<!-- Date: 2014-08-25 -->
	</head>
	<body>

		<div class="outer_container">
			<div class="header">
				<div class="logo">
					<a href="" class="logoimg"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/logo.png" alt="company Logo" /></a>

				</div>
				<div class="h_fright">
					<ul class="social">
						<li>
							<a href="#">Home</a>
						</li>
						<li>
							<a href="#">Contact</a>
						</li>
					</ul>

					<div class="search_box">
						<input type="text" value="Search our site" />
						<input type="button" class="searchbutton" />
					</div>

				</div>

			</div>
			<div class="menu">
				<h3>Menu</h3>
			</div>
			<div class="nav">
				<ul>
					<li>
						<a href="#">Home</a>
					</li>
					<li>
						<a href="#">About Us</a>
					</li>
					<li>
						<a href="#">Our Products</a>
					</li>
					<li>
						<a href="#">Latest Trends</a>
					</li>
					<li>
						<a href="#">Offers</a>
					</li>
					<li>
						<a href="#">Testimonials</a>
					</li>
					<li>
						<a href="#">Contact Us</a>
					</li>

				</ul>

			</div>
			<div class="slide_section">

				<div class="slideshow">

					<div id="owl-demo" class="owl-carousel">

						<div class="item"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/slide1.jpg" alt="pic">

							<h2 class="big"><strong>Fashion</strong> Is here</h2>

						</div>
						<div class="item"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/slide1.jpg" alt="pic">

							<h2 class="big"><strong>Fashion</strong> Is here</h2>

						</div>
						<div class="item"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/slide1.jpg" alt="pic">

							<h2 class="big"><strong>Fashion</strong> Is here</h2>

						</div>

					</div>

				</div>

			</div>
			<div class="padd_content">
				<div class="offers">
					<div class="offers_sec">
						<div class="offer_img">
							<img src="common/wholesaler_template/<?php echo $templateName;?>/images/offer1.jpg" />

						</div>
						<div class="offer_content">
							<h3>Products</h3>
							<p>
								Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
							</p>
						</div>

					</div>
					<div class="offers_sec">
						<div class="offer_img">
							<img src="common/wholesaler_template/<?php echo $templateName;?>/images/offer2.jpg" />

						</div>
						<div class="offer_content">
							<h3>Offers</h3>
							<p>
								Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
							</p>
						</div>

					</div>

				</div>
				<h2 class="heading">About Us</h2>
				<p>
					This text is temporary. Your approved content draft will be integrated into your design. This is merely to show you what your content area will look like after the development of your web site.
				</p>
				<p class="biggerp">
					Lorem Ipsum has been the industry's standard dummy text
				</p>
				<ul class="unorderedlist">
					<li>
						Lorem ipsum text will here
					</li>
					<li>
						Lorem ipsum text will here Lorem ipsum text
					</li>
					<li>
						Lorem ipsum text here
					</li>
					<li>
						Lorem ipsum text will here Lorem
					</li>
				</ul>

				<p class="biggerp">
					Lorem Ipsum has been the industry's standard dummy text
				</p>

			</div>
			<div class="blaquot">
				<p>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras tempor velit diam, id interdum tortor lacinia ut. Pellentesque ac lobortis ipsum, id interdum dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras tempor velit diam, id interdum tortor lacinia ut. Pellentesque ac lobortis ipsum, id interdum dolor.
				</p>

			</div>

			<div class="footer">
				<div class="footer_left">
					<div class="side_padded">
						<div class="social_container">
							<div class="follow">
								Follow Us On
							</div>
							<div class="socialicons">
								<ul>
									<li>
										<a href="#"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/fb.png" /></a>
									</li>
									<li>
										<a href="#"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/twitter.png" /></a>
									</li>
									<li>
										<a href="#"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/linkedIn.png" /></a>
									</li>
									<li>
										<a href="#"><img src="common/wholesaler_template/<?php echo $templateName;?>/images/rss.png" /></a>
									</li>

								</ul>

							</div>

						</div>
						<p class="copyright">
							© 2014 <a href="#">Fast Shop Inc.</a> All Rights Reserved.
						</p>

						<ul class="disclaim">
							<li>
								<a href="#"> Disclaimer</a>
							</li>
							<li>
								<a href="#">Site Map</a>
							</li>
							<li>
								<a href="#">Privacy Policy</a>
							</li>
							<li>
								<a href="#">Contact Us</a>
							</li>
						</ul>
					</div>

				</div>
				<div class="footer_right">
					<div class="side_padded">
						<h3>Fast Shop</h3>
						<div class="half">
							<h4>PRIMARY OFFICE
</h4>
<p>714 Lyndon Lane, Suite 4
Louisville, KY 40222
</p>
<p><a href="#">Map & Directions</a></p>
							
						</div>
						<div class="half">
							
					<p><label>Louisville -</label> 800-392-0352</p> 
<p><label>Jeffersonville -</label> 502-412-2254</p>
<p><label>Fax -</label> 502-412-2258</p>
							
						</div>
					</div>

				</div>
			</div>
			<div class="clear"></div>
		</div>
		<script src="common/wholesaler_template/<?php echo $templateName;?>/js/jquery-1.9.1.min.js"></script>
		<script src="common/wholesaler_template/<?php echo $templateName;?>/js/owl.carousel.js"></script>

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
			});

			$(".menu").click(function() {
				$(".nav").stop().slideToggle(350);

			});
		</script>

	</body>
</html>	
<?php 
}	
?>
