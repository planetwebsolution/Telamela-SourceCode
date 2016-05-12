<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;
?> 
<div id="outerFooter">
    <div class="layout">
        <div class="footer_inner">
            <div class="footerRight">
                <a class="logo" title="<?php echo SITE_NAME; ?>" href="#"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>footer-logo.png" alt="" /></a>
                <ul class="footSocial">
                    <li><a href="<?php echo YOUTUBE_URL; ?>" target="_blank"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>y_icon.png" alt="" /></a></li> 
                    <li><a href="<?php echo TWITTER_URL; ?>" target="_blank" ><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>t_icon.png" alt="" /></a></li>
                    <li><a href="<?php echo FACEBOOK_URL; ?>" target="_blank"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>f_icon.png" alt="" /></a></li>
                    <li><a href="<?php echo GPLUS_URL; ?>" target="_blank"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>g_icon.png" alt="" /></a></li>

                </ul>
                <span class="follow"></span>
            </div>
            <div class="footerLeft">
                <h3><?php echo CATEGORY_TITLE; ?></h3>
                <div class="footerLink">
                    <div class="linkBlock">
                        <ul>
                            <li><a href="<?php echo $objCore->getUrl('landing.php', array('cid' => $objPage2->arrData['arrCategoryListing'][0]['pkCategoryId'], 'name' => $objPage2->arrData['arrCategoryListing'][0]['CategoryName'])); ?>"><?php echo ucfirst($objPage2->arrData['arrCategoryListing'][0]['CategoryName']); ?></a></li>
                            <li><a href="<?php echo $objCore->getUrl('landing.php', array('cid' => $objPage2->arrData['arrCategoryListing'][1]['pkCategoryId'], 'name' => $objPage2->arrData['arrCategoryListing'][1]['CategoryName'])); ?>"><?php echo ucfirst($objPage2->arrData['arrCategoryListing'][1]['CategoryName']); ?></a></li>
                            <li><a href="<?php echo $objCore->getUrl('landing.php', array('cid' => $objPage2->arrData['arrCategoryListing'][2]['pkCategoryId'], 'name' => $objPage2->arrData['arrCategoryListing'][2]['CategoryName'])); ?>"><?php echo ucfirst($objPage2->arrData['arrCategoryListing'][2]['CategoryName']); ?></a></li>                                
                        </ul>
                    </div>
                    <div class="linkBlock b2">
                        <ul>                                
                            <li><a href="<?php echo $objCore->getUrl('landing.php', array('cid' => $objPage2->arrData['arrCategoryListing'][3]['pkCategoryId'], 'name' => $objPage2->arrData['arrCategoryListing'][3]['CategoryName'])); ?>"><?php echo ucfirst($objPage2->arrData['arrCategoryListing'][3]['CategoryName']); ?></a></li>
                            <li><a href="<?php echo $objCore->getUrl('landing.php', array('cid' => $objPage2->arrData['arrCategoryListing'][4]['pkCategoryId'], 'name' => $objPage2->arrData['arrCategoryListing'][4]['CategoryName'])); ?>"><?php echo ucfirst($objPage2->arrData['arrCategoryListing'][4]['CategoryName']); ?></a></li>
                            <li><a href="<?php echo $objCore->getUrl('landing.php', array('cid' => $objPage2->arrData['arrCategoryListing'][5]['pkCategoryId'], 'name' => $objPage2->arrData['arrCategoryListing'][5]['CategoryName'])); ?>"><?php echo ucfirst($objPage2->arrData['arrCategoryListing'][5]['CategoryName']); ?></a></li>                                
                        </ul>
                    </div>
                    <div class="linkBlock b3">
                        <ul>                               
                            <li><a href="<?php echo $objCore->getUrl('landing.php', array('cid' => $objPage2->arrData['arrCategoryListing'][6]['pkCategoryId'], 'name' => $objPage2->arrData['arrCategoryListing'][6]['CategoryName'])); ?>"><?php echo ucfirst($objPage2->arrData['arrCategoryListing'][6]['CategoryName']); ?></a></li>
                            <li><a href="<?php echo $objCore->getUrl('landing.php', array('cid' => $objPage2->arrData['arrCategoryListing'][7]['pkCategoryId'], 'name' => $objPage2->arrData['arrCategoryListing'][7]['CategoryName'])); ?>"><?php echo ucfirst($objPage2->arrData['arrCategoryListing'][7]['CategoryName']); ?></a></li>
                            <li><a href="<?php echo $objCore->getUrl('landing.php', array('cid' => $objPage2->arrData['arrCategoryListing'][8]['pkCategoryId'], 'name' => $objPage2->arrData['arrCategoryListing'][8]['CategoryName'])); ?>"><?php echo ucfirst($objPage2->arrData['arrCategoryListing'][8]['CategoryName']); ?></a></li>
                        </ul>
                    </div>
                    <div class="linkBlock b4">
                        <ul>                               
                            <li><a href="<?php echo $objCore->getUrl('landing.php', array('cid' => $objPage2->arrData['arrCategoryListing'][9]['pkCategoryId'], 'name' => $objPage2->arrData['arrCategoryListing'][9]['CategoryName'])); ?>"><?php echo ucfirst($objPage2->arrData['arrCategoryListing'][9]['CategoryName']); ?></a></li>
                            <li><a href="<?php echo $objCore->getUrl('landing.php', array('cid' => $objPage2->arrData['arrCategoryListing'][10]['pkCategoryId'], 'name' => $objPage2->arrData['arrCategoryListing'][10]['CategoryName'])); ?>"><?php echo ucfirst($objPage2->arrData['arrCategoryListing'][10]['CategoryName']); ?></a></li>
                            <?php if (count($objPage2->arrData['arrCategoryListing']) > 12) { ?>
                                <li class="moreLink"><a href="javascript:void(0);" class="categoryLink"><?php echo MORE; ?></a></li>
                                <li class="lessLink" style="display:none"><a href="javascript:void(0);" class="categoryLink"><?php echo LESS; ?></a></li>
                            <?php } else { ?>
                                <li><a href="<?php echo $objCore->getUrl('landing.php', array('cid' => $objPage2->arrData['arrCategoryListing'][11]['pkCategoryId'], 'name' => $objPage2->arrData['arrCategoryListing'][11]['CategoryName'])); ?>"><?php echo ucfirst($objPage2->arrData['arrCategoryListing'][11]['CategoryName']); ?></a></li>
                            <?php } ?>

                        </ul>
                        <ul class="categoryDropList" id="category_list_old" style="display:none;">
                            <?php /* $counts = 11;
                              $num=  count($objPage2->arrData['arrCategoryListing']);
                              for($i=$counts; $i<$num; $i++)
                              {?>
                              <li><a href="<?php echo $objCore->getUrl('category.php',array('cid'=>$objPage2->arrData['arrCategoryListing'][$i]['pkCategoryId'],'name'=>$objPage2->arrData['arrCategoryListing'][$i]['CategoryName']));?>"><?php echo $objPage2->arrData['arrCategoryListing'][$i]['CategoryName']; ?></a></li>
                              <?php } */ ?>
                        </ul>

                    </div>
                </div>



            </div> 

            <ul class="footLink">
                <?php
                $cnt = 0;
                $nums = count($objPage2->arrCmsList);
                foreach ($objPage2->arrCmsList as $v) {
                    ?>
                    <li><a class="underline" href="<?php echo $objCore->getUrl('content.php', array('cms' => 'cms', 'id' => $v['pkCmsID'])); ?>" <?php
                if ($cnt == 0) {
                    echo "class='first'";
                }
                    ?>><?php echo $v['PageTitle']; ?></a></li>
                           <?php
                           $cnt++;
                       }
                       ?>

                <li><a href="<?php echo $objCore->getUrl('contact.php'); ?>"><?php echo CONTACT_TITLE; ?> <?php echo US; ?></a></li>
                <li class="last"><a href="<?php echo $objCore->getUrl('rewards.php'); ?>"><?php echo REWARDS; ?></a></li>

            </ul>

            <div class="dropdowns_outer" style="display: none;" id="category_list">
                <ul class="dropdetail_inner">                
                    <?php
                    $counts = 11;
                    $num = count($objPage2->arrData['arrCategoryListing']);
                    for ($i = $counts; $i < $num; $i++) {
                        if ($i % $count == 0) {
                            ?>
                        </ul><ul class="dropdetail_inner">
                            <?php
                        }
                        ?>
                        <li><a href="<?php echo $objCore->getUrl('landing.php', array('cid' => $objPage2->arrData['arrCategoryListing'][$i]['pkCategoryId'], 'name' => $objPage2->arrData['arrCategoryListing'][$i]['CategoryName'])); ?>"><?php echo $objPage2->arrData['arrCategoryListing'][$i]['CategoryName']; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>

    </div> 
</div>


<style>
    .mce_inline_error{clear:both; text-align:center;}
    .back-to-top {
        position: fixed;
        bottom: 2em;
        right: 0px;
        text-decoration: none;
        color: #000000;
        background-color: rgba(235, 235, 235, 0.80);
        font-size: 12px;
        padding: 1em;
        display: none;
    }

    .back-to-top:hover {    
        background-color: rgba(135, 135, 135, 0.50);
    }
</style>
<script>var RET_TO = '<?php echo basename($_SERVER['SCRIPT_NAME']); ?>';</script>
<div id="subscribe">
    <div class="layout">
        <div id="mce-responses" class="clear">
            <div class="response" id="mce-error-response" style="display:none;text-align: left; padding-left:300px;color:#fff; margin-bottom: -10px"><?php echo TEST_MESSAGE; ?></div>
            <div class="response" id="mce-success-response" style="display:none;text-align: left; padding-left:300px;color:#fff; margin-bottom: -10px"></div>
        </div>
        <div class="newsletter" id="mc_embed_signup">
            <div class="center_newsletter">
                <small class="nwLtr"><?php echo NEWSLETTER; ?> <span><?php echo SUBSCRIPTION; ?></span></small>
                <form action="http://wordpress.us3.list-manage.com/subscribe/post?u=bfaa572207936af58c5d53d7f&amp;id=6b4e1562db" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate onsubmit="return checkEmail(this);">
                    <!--input type="text" value=" Enter your email address" onfocus="if(this.value=='Email Here')this.value=''" onblur="if(this.value=='')this.value=' Email Here'"/-->
                    <input type="email" value="<?php echo ENTER_EMAIL; ?>" name="EMAIL" class="required email" id="mce-EMAIL"  onfocus="if(this.value=='<?php echo ENTER_EMAIL; ?>'){this.value='';}" onblur="if(this.value==''){this.value='<?php echo ENTER_EMAIL;?>';}">
                    <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button" >
                </form>

                <p class="copyrightp">&#169; <?php echo date('Y'); ?> telamela. All Rights Reserved.</p>
            </div>
        </div>
    </div>
    <a class="back-to-top" href="#" style="display: none;z-index:999">Back to Top</a>   
    <!-- Begin MailChimp Signup Form -->

    <!--div id="mc_embed_signup">
    <form action="http://iworklab.us7.list-manage.com/subscribe/post?u=ec4e59279b5c238563de5d63f&amp;id=41897597a5" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
            
    <div class="mc-field-group">
            <label for="mce-EMAIL">Email Address </label>
            <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" value=" Enter your email address" onfocus="if(this.value==' Enter your email address')this.value=''" onblur="if(this.value=='')this.value=' Enter your email address'">
    </div>
            <div id="mce-responses" class="clear">
                    <div class="response" id="mce-error-response" style="display:none"></div>
                    <div class="response" id="mce-success-response" style="display:none"></div>
            </div>	<div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
    </form>
    </div-->
    <script type="text/javascript" src="<?php echo JS_PATH ?>mailchimpScript.js"></script>

    <!--End mc_embed_signup-->
    <script>
        $(function() {
            $('body').scrollTop(0);
        });
        $(document).ready(function(){
            $('body').on('click','#feedbackUpdate',function(){
                var fid=$(this).attr('fid');
                $.ajax({
                    type: 'POST',
                    url: SITE_ROOT_URL+'common/ajax/ajax.php',
                    data:{action : 'updateFeedback',fid:fid},
                    dataType: "json",
                    success:function(data){
                        console.log(data);
                    }
                
                });
      
            }); 
            $('.successMessage').fadeOut(2000);
            $(window).scroll(function () {
                if ($(this).scrollTop() > 40) {
                    $('.header').addClass("f-nav");
                    $('.body').addClass('slHeaderAdd');
                    $('.body').removeClass('slHeaderRemove');
                } else {
                    $('.header').removeClass("f-nav");
                    $('.body').removeClass('slHeaderAdd');
                    $('.body').addClass('slHeaderRemove');
                }
            });
    
            var offset = 220;
            var duration = 500;
            $(window).scroll(function() {
                if ($(this).scrollTop() > offset) { 
                    $('.back-to-top').fadeIn(duration);
                } else {
                    $('.back-to-top').fadeOut(duration);
                }
            });
    
            $('.back-to-top').click(function(event) {
                event.preventDefault();
                $('html,body').animate({scrollTop: 0}, duration);
                return false;
            });
    
    
        }); 
    
        $(window).load(function(){
            setTimeout(function(){ 
                var tranlatorHtml=$('#WidgetFloaterPanels').html();
                $('.LTRStyle').remove();
                $('.language').html('<div id="WidgetFloaterPanels">'+tranlatorHtml+'</div>');
       
            }, 100);

        });
        
        $('.reviewWholesaler').hide();
        $('.supportWholesaler').hide();
        $('.orderWholesaler').hide();
        $('.ratingWholesaler').hide();
        $('.feedbackWholesaler').hide();
        $('.invoiceWholesaler').hide();
        $(window).load(function(){
 
            setInterval(function() {
                $.ajax({
                    type: 'POST',
                    url: SITE_ROOT_URL+'common/ajax/ajax.php',
                    data:{action : 'notification'},
                    dataType: "json",
                    success:function(data){
                        (data.wholesalerSupport)>0 && (data.wholesalerSupport)< 999?($('.supportWholesaler').show(),$('.supportWholesaler').html(data.wholesalerSupport)):$('.supportWholesaler').hide();
                        (data.wholesalerOrder)>0 && (data.wholesalerOrder)< 999?($('.orderWholesaler').show(),$('.orderWholesaler').html(data.wholesalerOrder)):$('.orderWholesaler').hide();
                        (data.wholesaleReview)>0 && (data.wholesaleReview)< 999?($('.reviewWholesaler').show(),$('.reviewWholesaler').html(data.wholesaleReview)):$('.reviewWholesaler').hide();
                        (data.wholesaleFeedback)>0 && (data.wholesaleFeedback)< 999?($('.feedbackWholesaler').show(),$('.feedbackWholesaler').html(data.wholesaleFeedback)):$('.feedbackWholesaler').hide();
                        (data.wholesaleInvoive)>0 && (data.wholesaleInvoive)< 999?($('.invoiceWholesaler').show(),$('.invoiceWholesaler').html(data.wholesaleInvoive)):$('.invoiceWholesaler').hide();
                        (data.wholesaleProductRating)>0 && (data.wholesaleProductRating)< 999?($('.ratingWholesaler').show(),$('.ratingWholesaler').html(data.wholesaleProductRating)):$('.ratingWholesaler').hide();
                        (data.customerSupport)>0 && (data.customerSupport)< 999?($('.supportCustomerNew').html('New'),$('.supportCustomer').html(data.customerSupport)):$('.supportCustomerNew').hide();
                    }
                
                });
            
                //$('.topBar').load(SITE_ROOT_URL+'common/inc/top-header.inc.php');
            }, 2000);

        });
    </script>
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