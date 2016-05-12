<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_PAYMENT_CTRL;
//pre($newCountry);
//pre($objPage->arrData);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Payment</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
		<style>.input_star .star_icon{ right:1px; }
		.back_shoping{ padding:7px 11px 8px 13px; border:none }
		.save{ border:none}
		.radio_sec{ padding-top:0px }
		@media screen and (max-width: 1139px){
.pament_left > .quick_title > ul > li { width:100% !important; }
.pvp-lbl { width: 100% !important; }
}
		</style>
        <script  type="text/javascript">
            $(document).ready(function(){
                $('.drop_down1').sSelect();
                $("#giftcard").validationEngine();
            });
            function paymentSubmit(){
                if(!$("#agree").is(':checked')){
                    $('#terms_terms').html('<div class="errorBox_1 formError" style="opacity: 0.87; position:inherit; top: 180px; display: block; margin-top: 0px; left: 164px;"><div class="formErrorContent">* accept terms & conditions is <?php echo REQUIRED; ?><br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>');
                    return false;
                }else{
                    $('#terms_terms').html('');
                }
            }

            $(document).ready(function(){
                $(".pament_right_sec .check_box").click(function(e){
                    if($(this).find('input:checkbox').is(':checked')){
                        $('#terms_terms').html('');
                    }else{
                        $('#terms_terms').html('<div class="errorBox_1 formError" style="opacity: 0.87; position:inherit; top: 180px; display: block; margin-top: 0px; left: 164px;"><div class="formErrorContent">* accept terms & conditions is <?php echo REQUIRED; ?><br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>');
                    }
                });

            });

            function termsPopup(a){
                $("."+a).colorbox({
                    width:"900px",
                    height:"800px"
                });
            }
        </script>
    </head>
    <body>
     <div id="navBar">
            <?php include_once 'common/inc/top-header.inc.php'; ?>
        </div>
        <div class="header"><div class="layout">
               
        </div>
       </div><?php include_once INC_PATH . 'header.inc.php'; ?>
        <div id="ouderContainer" class="ouderContainer_1">
            <div class="layout">
                
                <div class="add_pakage_outer">
                   <div class="top_header border_bottom">
    <h1>PAYMENT</h1>
   
</div>   
                    <div class="body_container_inner_bg radius">
                        <div class="pament_sec add_edit_pakage payment-line">
                            
                            <ul class="radio_sec">
                                <!--<li>
                                    <div class="radio_btn method"><input type="radio" name="frmMethod" value="paypal" checked="checked" class="styled"/><small>PayPal</small></div>
                                </li>
                                <li>
                                    <div class="radio_btn method"><input type="radio" name="frmMethod" value="gift-card" class="styled"/><small>Gift card</small></div>
                                </li>-->
                            </ul>
                            <div class="pament_left">
                                <?php echo $objPage->arrData['setMsg']; ?>
                              <div class="quick_title" style="width:482px;"><span>FINAL PAYMENT DETAILS</span></div>  <ul>
                                    <li class="pvp-lbl" style="background:#eee; padding:10px; width:95%; padding-top:20px;">
                                        <label><strong>Total Payment</strong></label>
                                        <div class="pvp-value myvalue">
                                            <span><?php echo //$objCore->getProductCalCurrencyPrice($objPage->arrData['CartTotalPrice']);
$objCore->getPrice($objPage->arrData['CartTotalPrice']); ?></span>
                                            <div style="" class="floatedtick">&nbsp;</div>
                                        </div>
                                    </li>
                                    <?php if (isset($_SESSION['MyCart']['Common']['IsMinimum']) && $_SESSION['MyCart']['Common']['IsMinimum'] == '1') { ?>
                                        <li class="pvp-lbl">
                                            <em class="red">
                                                Minimum order is <?php echo $objCore->getPrice(MINIMUM_ORDER_PRICE); ?>. You have to pay <?php echo $objCore->getPrice($objPage->arrData['CartTotalPrice']); ?> for this order.
                                            </em>
                                        </li>
                                    <?php } ?>

                                    <li class="pvp-lbl">
                                        <ul class="left_sec">
                                            <li>
                                                <h4>Pay via Gift Card:</h4>
                                                <form action="" name="giftcard" id="giftcard" method="post">
                                                    <div class="input_star">
                                                        <input type="text" name="frmCardName" autocomplete="off" placeholder="Enter your code here" style="line-height:28px; width:261px;"   value="" class="validate[required] myshortinput code_btn" />
                                                        <small class="star_icon" style="right: 1px;
position: absolute;
top: 3px !important;"><img src="<?php echo IMAGE_FRONT_PATH_URL ?>star_icon.png" alt="" /></small>                                                                                                            </div>
                                                    <div class="apply_sec myapply">
                                                        <input type="submit" name="frmBtnApply" id="frmBtnApply" value="Apply" style="float: left"  class="apply_btn"/>
                                                    </div>
                                                </form>
                                                <div class="pvp-value myvalue">
                                                    <span>- <?php echo $objCore->getPrice($objPage->arrData['arrGiftCard']['2']); ?></span>
                                                    <div style="" class="floatedtick">
                                                        <?php if ($objPage->arrData['arrGiftCard']['2'] > 0) { ?>
                                                            <form action="" name="frmBtnRemove" method="post">
                                                                <input type="hidden" name="frmBtnRemove" id="frmBtnRemove" value="Remove" />
                                                            </form>
                                                            <a href="javascript:void(0);" onclick="document.frmBtnRemove.submit();">
                                                                <img src="<?php echo IMAGE_FRONT_PATH_URL ?>cross-hover.png" title="Cancel" alt="Cancel" />
                                                            </a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php
                                    if ($objPage->arrData['arrReward']['RewardStatus'] == '1' && $objPage->arrData['arrReward']['RewardCanRedeem'] == '1') {
										//pre( $objPage->arrData['arrReward']['RewardPointsBalance']);
                                    	?>
                                        <li class="pvp-lbl">
                                            <div class="check_box" id="check_box">
                                                <small>
                                                    Use Reward Points (<?php echo $objPage->arrData['arrReward']['RewardPoints']; ?>)
                                                    <br/>
                                                    Balance points (<?php echo $objPage->arrData['arrReward']['RewardPointsBalance']; ?>)
                                                </small>
                                            </div>
                                            <div class="apply_sec myapply">
                                                <form action="" method="post">
                                                    <input type="submit" name="frmBtnApplyRewards" id="frmBtnApplyRewards" value="Apply" style="float: left;" class="apply_btn" />
                                                </form>
                                            </div>
                                            <div class="pvp-value myvalue">
                                                <span>- <?php echo $objCore->getPrice($objPage->arrData['arrReward']['RewardValue']); ?></span>
                                                <div style="" class="floatedtick">
                                                    <?php if ($objPage->arrData['arrReward']['RewardValue'] > 0) { ?>
                                                        <form action="" name="frmBtnRemoveReward" method="post">
                                                            <input type="hidden" name="frmBtnRemoveReward" id="frmBtnRemoveReward" value="Remove" />
                                                        </form>
                                                        <a href="javascript:void(0);" onclick="document.frmBtnRemoveReward.submit();">
                                                            <img src="<?php echo IMAGE_FRONT_PATH_URL ?>cross-hover.png" title="Cancel" alt="Cancel" />
                                                        </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                    <li>
                                        <div style="margin: 0 5px 0 0; border:1px #dadada solid"></div>
                                    </li>
                                    <li class="pvp-lbl">
                                        <label>Balance amount to be paid</label>
                                        <div class="pvp-value myvalue" id="remBalance">
                                            <?php $remBal = $objPage->arrData['CartTotalPrice'] - $objPage->arrData['arrReward']['RewardValue']; ?>
                                            <span><?php echo $objCore->getPrice($objPage->arrData['CartTotalBalancedPrice']); ?></span>
                                            <div class="floatedtick">&nbsp;</div>
                                        </div>

                                    </li>
                                    <li class="pvp-lbl">
                                        <a class="back_shoping clear_cart" href="<?php echo $objCore->getUrl('order_detail_page.php'); ?>">Back to Order Detail</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="pament_right_sec"><div class="quick_title" style="width:449px;"><span>CHOOSE YOUR PAYMENT METHOD</span></div> 
                                <ul class="right_pament">
                                    <li class="first"><img src="<?php echo IMAGE_FRONT_PATH_URL ?>v_viza.png" alt=""/></li>
                                    <li><img src="<?php echo IMAGE_FRONT_PATH_URL ?>right_card.png" alt=""/></li>
                                    <li><img src="<?php echo IMAGE_FRONT_PATH_URL ?>pay_pal.png" alt=""/></li>
                                    <li><img src="<?php echo IMAGE_FRONT_PATH_URL ?>s_master.png" alt=""/></li>
                                </ul>
                                <p align="justify" style="padding-bottom:14px;">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nam cursus. Aliquam vehicula mi at mauris. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nam cursus. Aliquam vehicula mi at mauris. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nam cursus. Aliquam vehicula mi at mauris. Maecenas placerat, nisl at consequat Maecenas placerat, nisl at consequat</p>
                                <div class="check_box" style=" padding-bottom:30px;">
                                    <div id="terms_terms"></div>
                                    <input type="checkbox" class="styled" name="agree" id="agree" value="1" /><small>I accept <a href="<?php echo $objCore->getUrl('terms.php'); ?>" class="termsPopup" onclick="termsPopup('termsPopup')">Terms &amp; Conditions</a>.</small>
                                </div>
                                <?php $varButton = ($objPage->arrData['CartTotalPrice'] > 0) ? PAYMENT_PAYNOW_BUTTON : ' Order Now '; ?>
                                <form action="paypal_process.php" name="payment" id="payment" method="post" onsubmit="return paymentSubmit()">
                                    <input type="hidden" name="frmGrandTotal" value="<?php echo $objPage->arrData['CartTotalBalancedPrice']; ?>" />
                                    <span class="btn"><input type="submit" name="frmButtonPaypal" value="<?php echo $varButton; ?>" class="save shopping_update2"/></span>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html>