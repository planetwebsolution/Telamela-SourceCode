<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_REWARDS_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Telamela Rewards</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>reward-banner.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH ?>bxsliderjs.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.slider_inner').bxSlider({
                    auto:true
                });
            });
        </script>
    </head>
    <body>
        <div id="navBar">
            <?php include_once INC_PATH . 'top-header.inc.php'; ?>
        </div>
        <div class="header"><div class="layout">
               
        </div>
       </div><?php include_once INC_PATH . 'header.inc.php'; ?>
        <div id="ouderContainer" class="ouderContainer_1">
            <div class="layout">
                <div class="header">
                    <?php include_once INC_PATH . 'header.inc.php'; ?>
                </div>
                <div class="reward-banner"> <h2 class="shop_icon1">REWARD POINTS</h2>
                    <div class="sliderbox_outer">
                        <div class="slider_box">
                            <ul class="slider_inner">
                                <?php
                                //pre($objPage->arrBanner);
                                if (count($objPage->arrBanner) > 0) {
                                    foreach ($objPage->arrBanner as $ban) {
                                        ?>
                                        <li><img src="<?php echo $objCore->getImageUrl($ban['BannerImageName'], 'banner/' . $arrSpecialPageBannerImage['reward']); ?>" alt="<?php echo $ban['BannerTitle']; ?>" /></li>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <li><img src="<?php echo IMAGES_URL;?>reward-banner.png" alt=""/></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <em class="bdrBtm"></em>
        </div>

        <!-- div reward start -->
        <div id="outerContainer">
            <div class="layout">
                <div class="container"> 
                    <div class="rewardsImageContainer">
<div class="reward_1"><img src="<?php echo IMAGES_URL ?>reward_1.jpg" alt="" /><span>Making Purchase</span></div>
<div class="reward_1"><img src="<?php echo IMAGES_URL ?>reward_2.jpg" alt="" /><span>Writing Review on Your Purchase</span></div>
<div class="reward_1"><img src="<?php echo IMAGES_URL ?>reward_3.jpg" alt="" /><span>Liking our Product</span></div>
</div>
                    <div class="reward-checkout">
                        <div class="reward-inner">
                            <h3>Redeem Points at Checkout</h3>
                            <p class="checkout-para">Whether it's about purchasing products, writing reviews, or referring products to your dear ones, Tela Mela has a kitty of reward points for almost every one. Simply login to our website, shop your desired products, and link them with your earned reward points</p>
                            <div class="reward-calc">
                                <div class="left-point-rew">
                                    <h3>You have 2899 Points</h3>
                                    <p>use your points to get off on purchases</p>
                                    <span><img src="<?php echo IMAGES_URL ?>reward-point-meter.png" alt=""/></span>
                                    <!--<span class="tag">You will use 1700 points</span>-->
                                </div>
                                <div class="mid-point-rew">
                                    <span><label>You will spend</label><strong>1700 Points</strong></span>
                                    <span><label>You will earn</label><strong>350 Points</strong></span>
                                    <span><label>Subtotal</label><strong>$50</strong></span>
                                    <span><label>You Save</label><strong>$100</strong></span>
                                    <span><label>Tax</label><strong>$5.5</strong></span>
                                    <span><label class="ttl">Total</label><strong class="ttl">$645</strong></span>
                                </div>
                                <div class="right-point-rew">
                                    <span><img src="<?php echo IMAGES_URL ?>reward-checkout-ico.png" alt=""/></span>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- div reward end -->
        <?php include_once INC_PATH . 'footer.inc.php'; ?>
    </body>
</html>