<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;
?>

<div class="footer_section">
    <div class="wrapper">
        <div class="sec_1">
            <h5>About Market</h5>
            <ul>
                <?php
                foreach ($objPage2->arrCmsList as $v)
                {
                    if ($v['PageDisplayTitle'] == 'About Market')
                    {
                        ?>
                        <li> <i class="fa fa-angle-right"></i> <a href="<?php echo $objCore->getUrl('content.php', array('cms' => 'cms', 'id' => $v['PagePrifix'])); ?>"> <?php echo $v['PageTitle']; ?> </a> </li>
                    <?php
                    }
                }
                ?>
            </ul>
        </div>
        <div class="sec_1">
            <h5>Customer Service</h5>
            <ul>
                <?php
                foreach ($objPage2->arrCmsList as $v)
                {
                    if ($v['PageDisplayTitle'] == 'Customer Service')
                    {
                        ?>
                        <li> <i class="fa fa-angle-right"></i> <a href="<?php echo $objCore->getUrl('content.php', array('cms' => 'cms', 'id' => $v['PagePrifix'])); ?>"> <?php echo $v['PageTitle']; ?> </a> </li>
                    <?php
                    }
                }
                ?>
                <li><i class="fa fa-angle-right"></i><a href="<?php echo $objCore->getUrl('contact.php'); ?>"><?php echo CONTACT_TITLE; ?> <?php echo US; ?></a></li>
                <li><i class="fa fa-angle-right"></i><a href="<?php echo $objCore->getUrl('rewards.php'); ?>"><?php echo REWARDS; ?></a></li>
            </ul>
        </div>
        <div class="sec_1">
            <h5>Payment & Shipping</h5>
            <ul>
                <?php
                foreach ($objPage2->arrCmsList as $v)
                {
                    if ($v['PageDisplayTitle'] == 'Payment & Shipping')
                    {
                        ?>
                        <li> <i class="fa fa-angle-right"></i> <a href="<?php echo $objCore->getUrl('content.php', array('cms' => 'cms', 'id' => $v['PagePrifix'])); ?>"> <?php echo $v['PageTitle']; ?> </a> </li>
                    <?php
                    }
                }
                ?>
            </ul>
        </div>
        <div class="sec_2">
            <h5>Contact Us</h5>
            <img src="<?php echo IMAGE_FRONT_PATH_URL; ?>footer-logo.png" alt="" /> 
            <!--<p>P.O. Box 3395, Road Town, Demo, Country Loream Ipsum, VG1110</p>
<ul>
<li><i class="fa fa-phone"></i>(284) 443 3236</li>
<li><i class="fa fa-envelope"></i><a href="mailto:telamela@gmail.com">telamela@gmail.com</a></li>-->
            <?php
            foreach ($objPage2->arrCmsList as $v)
            {
                if ($v['PageDisplayTitle'] == 'Contact Us')
                {
                    echo $v['PageContent'];
                }
            }
            ?>
            </ul>
        </div>
        <div class="sec_2">
            <h5>Special Offers </h5>
            <p class="special_txt">Sign Up To Access Our Special Offers</p>
            <div style="">
                <div id="mce-responses" class="clear">
                    <div class="response" id="mce-error-response"><?php echo TEST_MESSAGE; ?></div>
                    <div class="response" id="mce-success-response"></div>
                </div>
                <form action="http://wordpress.us3.list-manage.com/subscribe/post?u=bfaa572207936af58c5d53d7f&amp;id=6b4e1562db" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate onsubmit="return checkEmail(this);">
                       <input type="email" value="<?php echo ENTER_EMAIL; ?>" name="EMAIL" class="required email" id="mce-EMAIL"  onfocus="if (this.value == '<?php echo ENTER_EMAIL; ?>') {
                           this.value = '';
                       }" onblur="if (this.value == '') {
                       this.value = '<?php echo ENTER_EMAIL; ?>';
                   }">
                    <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button_subscribe" >
                </form>
            </div>
            <h6>Connect With Us </h6>
            <ul class="social_icon">
                <li><a target="_blank" href="<?php echo YOUTUBE_URL; ?>" title="Youtube"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>email.jpg" alt="" border="0" class="social" /></a></li>
                <li><a target="_blank" href="<?php echo FACEBOOK_URL; ?>" title="Facebook"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>fb.jpg" alt="" border="0" class="social" /></a></li>
                <li><a target="_blank" href="<?php echo TWITTER_URL; ?>" title="Twitter"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>tt.jpg" alt="" border="0" class="social" /></a></li>
                <li><a  target="_blank" href="<?php echo GPLUS_URL; ?>" title="Google Plus"><img src="<?php echo IMAGE_FRONT_PATH_URL; ?>link.jpg" alt="" border="0" class="social" /></a></li>
                <li>   <img class="footer_google_play" src="<?php echo IMAGE_FRONT_PATH_URL; ?>google_play.jpg" alt="" /> </li>
            </ul>

        </div>
    </div>
    <div></div>
    <script>var RET_TO = '<?php echo basename($_SERVER['SCRIPT_NAME']); ?>';</script>
    <div class="footer_middle">
        <p><strong>100% Secure and Trusted Payment</strong><br />
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis at molestie ligula. Integer nisi mi, congue sed nisi a, consectetur aliquet justo. </p>
        <div class="img"> <img src="<?php echo IMAGE_FRONT_PATH_URL; ?>footer_visa.jpg"  alt=""/></div>
        <p class="copy">&copy; <?php echo date('Y'); ?> telamela.com. All rights reserved.</p>
    </div>
</div>
</div>
<!--<script type="text/javascript" src="<?php echo JS_PATH ?>mailchimpScript.js"></script>-->
<!--<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>-->
<script type="text/javascript" >
setInterval(function(){ $('.success,.error').html(''); }, 3000);
$(window).load(function(){
    if($('#homeRightFirst').val()>1){
    setInterval(function(){
       $.post(SITE_ROOT_URL + 'common/ajax/ajax.php', {
                    action: 'homeBannerAdvertisment1'
                }, function(data) { 
                    $('#banners_1').html(data);
                    
                });
    }, 9000);
    }
    if($('#homeRightTwo').val()>1){
    setInterval(function(){
       $.post(SITE_ROOT_URL + 'common/ajax/ajax.php', {
                    action: 'homeBannerAdvertisment2'
                }, function(data) { 
                    $('#banners_2').html(data);
                    
                });
    }, 9000);
    }
    if($('#homeRightThree').val()>1){
    setInterval(function(){
       $.post(SITE_ROOT_URL + 'common/ajax/ajax.php', {
                    action: 'homeBannerAdvertisment3'
                }, function(data) { 
                    $('#banners_3').html(data);
                    
                });
    }, 9000);
    }
    if($('#homeRightFour').val()>1){
    setInterval(function(){
       $.post(SITE_ROOT_URL + 'common/ajax/ajax.php', {
                    action: 'homeBannerAdvertisment4'
                }, function(data) { 
                    $('#banners_4').html(data);
                    
                });
    }, 9000);
    }
    if($('#homeRightFive').val()>1){
    setInterval(function(){
       $.post(SITE_ROOT_URL + 'common/ajax/ajax.php', {
                    action: 'homeBannerAdvertisment5'
                }, function(data) { 
                    $('#banners_5').html(data);
                    
                });
    }, 9000);
    }
});
</script>
