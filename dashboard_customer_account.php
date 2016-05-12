<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_CUSTOMER_ACCOUNT_CTRL;
$objCustomer = new Customer();
//pre($_SESSION);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo DASHBOARD_CUSTOMER_AC; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.drop_down1').sSelect();
                $("#frmRecommendform").validationEngine();
                
                var firstBoxHeight=parseInt($('.account_information').height());
                var secBoxHeight=parseInt($('.billing_information').height());
                var thrBoxHeight=parseInt($('.shipping_information').height());
                if((firstBoxHeight >=secBoxHeight) && (firstBoxHeight>=thrBoxHeight)){
                    $('.account_information').height(firstBoxHeight+'px');
                    $('.billing_information').height(firstBoxHeight+'px');
                    $('.shipping_information').height(firstBoxHeight+'px');
                }else if((secBoxHeight >= firstBoxHeight) && (secBoxHeight>=thrBoxHeight)){
                    $('.account_information').height(secBoxHeight);
                    $('.billing_information').height(secBoxHeight);
                    $('.shipping_information').height(secBoxHeight);
                } else if((thrBoxHeight>=firstBoxHeight) && (thrBoxHeight>=secBoxHeight)){
                    $('.account_information').height(thrBoxHeight);
                    $('.billing_information').height(thrBoxHeight);
                    $('.shipping_information').height(thrBoxHeight);
                }
               
                $('body').on('click','#verify_email',function(){
                    var str=$('#frmFriendEmail').val();
                    $('#refferLinkError').html(' ');
                    if(str==''){
                        var er=errorMessageRefferLink();
                        $('#refferLinkError').html(er);
                        $('#frmFriendEmail').focus();
                        return false;
                    }
                    var afterSpStr = str.split(',');
                    var oldStr='';
                    var newStr='';
                    $.each( afterSpStr, function( key, value ) {
                        $.ajax({
                            url: SITE_ROOT_URL+"common/ajax/ajax.php",
                            type: 'POST',
                            data: {action:"verifyEmail",email:value},
                            async: false, //blocks window close
                            dataType: "json",
                            success: function(data){
                                if($.trim(data.exist)!='' && $.trim(data.exist)!='undefined'){
                                    oldStr+=data.exist+',';
                                }
                                if($.trim(data.notExist)!='' && $.trim(data.notExist)!='undefined'){
                                    newStr+=data.notExist+',';
                                }
                            }
                        });
                    });
                    var nStr=newStr.replace(/,(?=[^,]*$)/, '');
                    if(nStr.length>0){
                        $('#frmFriendEmail').val(nStr);
                        var gtBClass=$('*').hasClass('formErrorContent')?'1':'2';
                        if($('#frmRecommendform .formErrorContent').html()!='' && gtBClass==1){
                            $('#frmFriendEmail').prop('readonly',false);
                        }else{
                            $('#frmFriendEmail').attr('readonly','readonly');
                            $('#frmHidenSend').show();
                            $('#verify_email').hide();
                        }
                    }
                    var str=oldStr.replace(/,(?=[^,]*$)/, '');
                    if(str.length>0){
                        $('#msgError').html(str+'<br>Email already exists');
                    }
                    
                });
                
            });
            function wholesalerReplyPopup(str){
                $('#verify_email').show();
                $('#frmHidenSend').hide();
                $('#msgError').html('');
                $('#frmFriendEmail').prop('readonly',false);
                $("."+str).colorbox({inline:true,width:"700px"});

                $('#recommend_cancel').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });
            }
            function errorMessageRefferLink() {
                var errMsg = '* Required field';
                return '<div style="opacity: 0.87; position: absolute; top: 101px; left: 425px;" class="formError"><div class="formErrorContent">' + errMsg + '<br/></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>';
            }
        </script>
        <style>
            .dashboard .account_information ul li small  {width:142px; word-wrap:break-word}
            .red{ font-size:12px}
            .billing_information > ul, .shipping_information > ul{border:none;}
            .reply_message .left_m{width:300px !important}


        </style>
    </head>
    <body>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header" style="border-bottom:none"><div class="layout">

            </div>
        </div><?php include_once INC_PATH . 'header.inc.php'; ?>

        <div id="ouderContainer" class="ouderContainer_1">
            <div class="layout">


                <?php
                if ($objCore->displaySessMsg())
                {
                    echo $objCore->displaySessMsg();
                    $objCore->setSuccessMsg('');
                    $objCore->setErrorMsg('');
                }
                ?>

                <div class="add_pakage_outer">
                    <div class="top_header border_bottom">
                        <h1><?php echo MY; ?> <?php echo AC; ?></h1>

                    </div>

                    <div class="body_inner_bg">
                        <div class="add_edit_pakage order_detail dashboard">
                            <div class="topname_outer" style="padding-bottom:0px;">
                                <div class="topname_inner">
                                    Welcome <?php echo ($objPage->arrCustomerDeatails[0]['CustomerWebsiteVisitCount'] > 1) ? 'Back ' : ''; ?><span class="username"><?php echo $_SESSION['sessUserInfo']['screenName']; ?></span>
                                </div>
                                <div class="topname_links">
                                    <a href="<?php echo $objCore->getUrl('my_rewards.php'); ?>" class="edit2"><?php echo MY_REWARDS . ' (' . $objPage->arrCustomerDeatails[0]['BalancedRewardPoints'] . ')'; ?></a>
                                    <a href="<?php echo $objCore->getUrl('edit_my_account.php', array('type' => 'edit')); ?>" class="edit2"><?php echo EDIT_AC; ?></a>
                                    <a href="<?php echo $objCore->getUrl('edit_my_password.php', array('type' => 'edit')); ?>" class="edit2"><?php echo EDIT_PS; ?></a>
                                    <a href="#recommend_details" onclick="wholesalerReplyPopup('referal');" class="edit2 referal"><?php echo REFER_YOUR_FRIEND; ?></a>
                                </div>
                            </div>    
                            <div style='display:none'>
                                <div id="recommend_details" class="reply_message">
                                    <form name="frmRecommendform" id="frmRecommendform" method="POST" action="">
                                        <div class="left_m"><label><?php echo REFERAL_LINK; ?> :</label></div>
                                        <div class="right_m" style="font-weight: bold;">
                                            <?php echo $objCore->getUrl('registration_customer.php', array('type' => 'add', 'ref' => $objPage->arrCustomerDeatails[0]['ReferalID'])); ?>
                                        </div>
                                        <div class="left_m"><label><?php echo FR_EMAIL; ?> <span class="red">*</span>: </label><br /><small class="red" style="white-space:nowrap">(You can use multiple email with comma separated.)</small></div><div class="right_m">
                                            <span id="msgError" style="color: red;
                                                  clear: both;
                                                  display: block;
                                                  font-size: 11px;
                                                  margin-bottom: 10px;  word-wrap: break-word;
                                                  }"></span>                                   <div id="refferLinkError"></div>
                                            <textarea onkeypress="Javascript: if (event.keyCode==13)return false;" id="frmFriendEmail" name="frmFriendEmail" class="validate[required,custom[multiemail]]"></textarea>
                                        </div>
                                        <div class="left_m">&nbsp;</div><div class="right_m">
                                            <input type="button" name="verifyemail" value="MailCheck" id="verify_email" class="cart_link_blue"/>
                                            <input type="submit" name="frmHidenSend" class="watch_link" value="Send" style="display:none" id="frmHidenSend"/>
                                            <input type="hidden" name="referFriends" value="referFriends" />
                                            <input type="hidden" name="CustomerEmail" value="<?php echo $objPage->arrCustomerDeatails[0]['CustomerEmail']; ?>" />
                                            
                                            <input type="button" name="cancel" value="Cancel" class="cancel" id="recommend_cancel" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="boxes">
                                <div class="account_information" style="margin-right:19px;">
                                    <div class="heading"> <h3><?php echo PERSONAL_DETAILS; ?></h3>
                                    </div>
                                    <ul>                                        
                                         <?php
                                        if(!empty($objPage->arrCustomerDeatails[0]['CustomerScreenName']))
                                        {
                                        ?>
                                        <li><span><?php echo SCREEN_NAME; ?><strong>:</strong></span> <small><?php echo $objPage->arrCustomerDeatails[0]['CustomerScreenName']; ?></small></li>
                                        <?php
                                        }
                                        ?>
                                         <li><span><?php echo FIRST_NAME; ?><strong>:</strong></span> <small><?php echo $objPage->arrCustomerDeatails[0]['CustomerFirstName']; ?></small></li>
                                        <?php
                                        if (trim($objPage->arrCustomerDeatails[0]['CustomerLastName']) != '')
                                        {
                                            ?>
                                            <li><span><?php echo LAST_NAME; ?><strong>:</strong></span> <small><?php echo $objPage->arrCustomerDeatails[0]['CustomerLastName']; ?></small></li>
                                        <?php } ?>
                                        <li><span><?php echo EMAIL; ?><strong>:</strong></span> <small><a class="linkCustomeHover" href="mailto:<?php echo $objPage->arrCustomerDeatails[0]['CustomerEmail']; ?>"><?php echo $objPage->arrCustomerDeatails[0]['CustomerEmail']; ?></a></small></li>
                                        <li><span><?php echo ADD_1_ADDRESS; ?> <strong>:</strong></span>  <small><?php echo $objPage->arrCustomerDeatails[0]['ResAddressLine1']; ?></small></li>
                                        <?php
                                        if (trim($objPage->arrCustomerDeatails[0]['ResAddressLine2']) != '')
                                        {
                                            ?>
                                            <li><span><?php echo ADD_2_ADDRESS; ?><strong>:</strong></span>  <small><?php echo $objPage->arrCustomerDeatails[0]['ResAddressLine2']; ?></small></li>
                                        <?php } ?>
                                        <?php $varResCountry = $objCustomer->countryById($objPage->arrCustomerDeatails[0]['ResCountry']); ?>
                                        <li><span><?php echo COUNTRY; ?><strong>:</strong></span> <small><?php echo $varResCountry[0]['name']; ?></small></li>
                                        <?php
                                        if (trim($objPage->arrCustomerDeatails[0]['ResTown']) != '')
                                        {
                                            ?>
                                            <li><span><?php echo TOWN; ?><strong>:</strong></span>  <small><?php echo $objPage->arrCustomerDeatails[0]['ResTown']; ?></small></li>
                                        <?php } ?>
                                        <li><span>Zip Code<strong>:</strong></span> <small><?php echo $objPage->arrCustomerDeatails[0]['ResPostalCode']; ?></small></li>
                                        <li><span><?php echo PHONE; ?> <strong>:</strong></span> <small> <?php echo $objPage->arrCustomerDeatails[0]['ResPhone']; ?></small></li>
                                        <li><span><?php echo REFERAL_LINK; ?><strong>:</strong></span>  <small><a class="linkCustomeHover" style="cursor: text"><?php echo $objCore->getUrl('registration_customer.php', array('type' => 'add', 'ref' => $objPage->arrCustomerDeatails[0]['ReferalID'])); ?></a></small></li>                                        
                                    </ul>
                                </div>
                                <div class="billing_information" style="margin-right: 20px;margin-left: 0px;">
                                    <div class="heading"> <h3><?php echo BILLING_ADDRESS; ?></h3>
                                    </div>
                                    <ul>
                                        <li><span><?php echo RECIPIENT_FIRST_NAME; ?><strong>:</strong></span>  <small><?php echo $objPage->arrCustomerDeatails[0]['BillingFirstName']; ?></small></li>
                                        <?php
                                        if (trim($objPage->arrCustomerDeatails[0]['BillingLastName']) != '')
                                        {
                                            ?>
                                            <li><span><?php echo REC_LAST_NAME; ?><strong>:</strong></span><small><?php echo $objPage->arrCustomerDeatails[0]['BillingLastName']; ?></small></li>
                                        <?php } ?>
                                        <?php
                                        if (trim($objPage->arrCustomerDeatails[0]['BillingOrganizationName']) != '')
                                        {
                                            ?>
                                            <li><span><?php echo ORG_NAME; ?><strong>:</strong></span><small><?php echo $objPage->arrCustomerDeatails[0]['BillingOrganizationName']; ?></small></li>
                                        <?php } ?>
                                        <li><span><?php echo ADD_1_ADDRESS; ?><strong>:</strong></span> <small><?php echo $objPage->arrCustomerDeatails[0]['BillingAddressLine1']; ?></small></li>
                                        <?php
                                        if (trim($objPage->arrCustomerDeatails[0]['BillingAddressLine2']) != '')
                                        {
                                            ?>
                                            <li><span><?php echo ADD_2_ADDRESS; ?><strong>:</strong></span>  <small><?php echo $objPage->arrCustomerDeatails[0]['BillingAddressLine2']; ?></small></li>
                                        <?php } ?>
                                        <?php $varBillingCountry = $objCustomer->countryById($objPage->arrCustomerDeatails[0]['BillingCountry']); ?>
                                        <li><span><?php echo COUNTRY; ?><strong>:</strong></span>  <small><?php echo $varBillingCountry[0]['name']; ?></small></li>
                                        <?php
                                        if (trim($objPage->arrCustomerDeatails[0]['BillingTown']) != '')
                                        {
                                            ?>
                                            <li><span><?php echo TOWN; ?><strong>:</strong></span>  <small><?php echo $objPage->arrCustomerDeatails[0]['BillingTown']; ?></small></li>
                                        <?php } ?>
                                        <li><span><?php echo POSTAL_CODE_ZIP; ?><strong>:</strong></span>  <small><?php echo $objPage->arrCustomerDeatails[0]['BillingPostalCode']; ?></small></li>
                                        <li><span><?php echo PHONE; ?> <strong>:</strong></span>  <small><?php echo $objPage->arrCustomerDeatails[0]['BillingPhone']; ?></small></li>
                                        <?php
                                        if (($objPage->arrCustomerDeatails[0]['BusinessAddress']) == 'Billing')
                                        {
                                            ?>
                                            <li>

                                                <div class="radio_btn">
                                                    <input type="radio" checked="checked" class="styled" value="Billing" name="frmBusinessAddress"/><small style="width: auto;"><?php echo BUSINESS_ADD; ?></small>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="shipping_information" style="margin-right:0px;">
                                    <div class="heading"><h3><?php echo SHIPPING_ADD; ?></h3></div>
                                    <ul>
                                        <li><span><?php echo RECIPIENT_FIRST_NAME; ?><strong>:</strong></span> <small> <?php echo $objPage->arrCustomerDeatails[0]['ShippingFirstName']; ?></small></li>
                                        <?php
                                        if (trim($objPage->arrCustomerDeatails[0]['ShippingLastName']) != '')
                                        {
                                            ?>
                                            <li><span><?php echo REC_LAST_NAME; ?><strong>:</strong></span>  <small><?php echo $objPage->arrCustomerDeatails[0]['ShippingLastName']; ?></small></li>
                                        <?php } ?>
                                        <?php
                                        if (trim($objPage->arrCustomerDeatails[0]['ShippingOrganizationName']) != '')
                                        {
                                            ?>
                                            <li><span><?php echo ORG_NAME; ?><strong>:</strong></span> <small> <?php echo $objPage->arrCustomerDeatails[0]['ShippingOrganizationName']; ?></small></li>
                                        <?php } ?>
                                        <li><span><?php echo ADD_1_ADDRESS; ?> <strong>:</strong></span>  <small><?php echo $objPage->arrCustomerDeatails[0]['ShippingAddressLine1']; ?></small></li>
                                        <?php
                                        if (trim($objPage->arrCustomerDeatails[0]['ShippingAddressLine2']) != '')
                                        {
                                            ?>
                                            <li><span><?php echo ADD_2_ADDRESS; ?><strong>:</strong></span>  <small><?php echo $objPage->arrCustomerDeatails[0]['ShippingAddressLine2']; ?></small></li>
                                        <?php } ?>
                                        <?php $varShippingCountry = $objCustomer->countryById($objPage->arrCustomerDeatails[0]['ShippingCountry']); ?>
                                        <li><span><?php echo COUNTRY; ?><strong>:</strong></span> <small><?php echo $varShippingCountry[0]['name']; ?></small></li>
                                        <?php
                                        if (trim($objPage->arrCustomerDeatails[0]['ShippingTown']) != '')
                                        {
                                            ?>
                                            <li><span><?php echo TOWN; ?><strong>:</strong></span>  <small><?php echo $objPage->arrCustomerDeatails[0]['ShippingTown']; ?></small></li>
                                        <?php } ?>
                                        <li><span><?php echo POSTAL_CODE_ZIP; ?><strong>:</strong></span> <small><?php echo $objPage->arrCustomerDeatails[0]['ShippingPostalCode']; ?></small></li>
                                        <li><span><?php echo PHONE; ?> <strong>:</strong></span> <small> <?php echo $objPage->arrCustomerDeatails[0]['ShippingPhone']; ?></small></li>
                                        <?php
                                        if (($objPage->arrCustomerDeatails[0]['BusinessAddress']) == 'Shipping')
                                        {
                                            ?>

                                            <li>
                                                <div class="radio_btn">
                                                    <input type="radio" checked="checked" class="styled" value="Shipping" name="frmBusinessAddress" /><small style="width: auto;"><?php echo BUSINESS_ADD; ?></small>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="boxes2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once INC_PATH . 'footer.inc.php'; ?>
    </body>
</html>
