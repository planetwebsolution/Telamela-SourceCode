<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_CUSTOMER_ACCOUNT_CTRL;
$objCustomer = new Customer();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo EDIT_PASSWORD_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                // binds form submission and fields to the validation engine
                jQuery("#frmCustomerRegistration").validationEngine({
                    'custom_error_messages': {
                        'minSize': {
                            'message': "*Minimum 6 characters allowed"
                        },
                        'equals': {
                            'message': "New Passwords must be same"
                        }
                    }
                });

                $('.drop_down1').sSelect();
                $('.cancel').click(function() {
                    window.location.href = '<?php echo $objCore->getUrl('dashboard_customer_account.php'); ?>';

                });

                function wholesalerReplyPopup(str) {
                    $("." + str).colorbox({inline: true, width: "700px"});

                    $('#recommend_cancel').click(function() {
                        parent.jQuery.fn.colorbox.close();
                    });
                }
                //Refer friend email will check here
                $("#frmRecommendform").validationEngine();
                $('body').on('click', '#verify_email', function() {
                    var str = $('#frmFriendEmail').val();
                    $('#refferLinkError').html(' ');
                    if (str == '') {
                         var er = errorMessageRefferLink();
                        $('#refferLinkError').html(er);
                        $('#frmFriendEmail').focus();
                        return false;
                    }
                    var afterSpStr = str.split(',');
                    var oldStr = '';
                    var newStr = '';
                    $.each(afterSpStr, function(key, value) {
                        $.ajax({
                            url: SITE_ROOT_URL + "common/ajax/ajax.php",
                            type: 'POST',
                            data: {action: "verifyEmail", email: value},
                            async: false, //blocks window close
                            dataType: "json",
                            success: function(data) {
                                if ($.trim(data.exist) != '' && $.trim(data.exist) != 'undefined') {
                                    oldStr += data.exist + ',';
                                }
                                if ($.trim(data.notExist) != '' && $.trim(data.notExist) != 'undefined') {
                                    newStr += data.notExist + ',';
                                }
                            }
                        });
                    });
                    var nStr = newStr.replace(/,(?=[^,]*$)/, '');
                    if (nStr.length > 0) {
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
                    var str = oldStr.replace(/,(?=[^,]*$)/, '');
                    if (str.length > 0) {
                        $('#msgError').html(str + '<br>Email already exists');
                        return false;
                    }

                });
            });
            //This will show Refer friend pop up
            function wholesalerReplyPopup(str) {
                $('#verify_email').show();
                $('#frmHidenSend').hide();
                $('#msgError').html('');
                $('#frmFriendEmail').prop('readonly',false); 
              $("." + str).colorbox({inline: true, width: "700px"});

                $('#recommend_cancel').click(function() {
                    parent.jQuery.fn.colorbox.close();
                });
            }
            function errorMessageRefferLink() {
                var errMsg = '* Required field';
                return '<div style="opacity: 0.87; position: absolute; top: 101px; left: 425px;" class="formError"><div class="formErrorContent">' + errMsg + '<br/></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>';
            }
        </script>
        <style>.input_star .star_icon{ right:1px;}
            .com_address_sec h3{ background:none}
            .add_edit_pakage label{width:100%; margin-bottom:5px;}
            .input_star input{box-sizing:border-box; height:37px; width:455px; border: 1px solid #d9d9d9; padding:8px;}
            .btn_wrap input,.btn_wrap button{margin-top:10px;}
            .reply_message .left_m{width:300px !important}
			.d_left_sec{width:61%;}

        </style>
    </head>
    <body>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout">

            </div>
        </div><?php include_once INC_PATH . 'header.inc.php'; ?>

        <div id="ouderContainer" class="ouderContainer_1">
            <?php
            if ($_SESSION['sessUserInfo']['type'] == 'wholesaler') {
                ?>

            <?php } ?>
            <div class="layout">

                <div class="add_pakage_outer">
                    <div class="top_header border_bottom">
                        <h1><?php echo CHANGE; ?> <span><?php echo MY_PASS; ?></h1>
                    </div>

                    <div class="body_inner_bg radius">

                        <div class="topname_outer space_bot">
                            <div class="topname_inner">
                                &nbsp;
                            </div>
                            <div class="topname_links">
                                <a href="<?php echo $objCore->getUrl('my_rewards.php'); ?>" class="edit2"><?php echo MY_REWARDS . ' (' . $objPage->arrCustomerDeatails[0]['BalancedRewardPoints'] . ')'; ?></a>
                                <a href="<?php echo $objCore->getUrl('edit_my_account.php', array('type' => 'edit')); ?>" class="edit2"><?php echo EDIT_AC; ?></a>
                                <a href="<?php echo $objCore->getUrl('edit_my_password.php', array('type' => 'edit')); ?>" class="edit2 edit2active"><?php echo EDIT_PS; ?></a>
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
                                    <div class="left_m editpass"><label><?php echo FR_EMAIL; ?> *: </label><br /><small class="red">(You can use multiple email with comma separated.)</small></div><div class="right_m">
                                        <span id="msgError" style="color: red;
                                              clear: both;
                                              display: block;
                                              font-size: 11px;
                                              margin-bottom: 10px;
                                              "></span>
                                        <div id="refferLinkError"></div>
                                        <textarea onkeypress="Javascript: if (event.keyCode == 13)
                    return false;" id="frmFriendEmail" name="frmFriendEmail" class="validate[required,custom[multiemail]]"></textarea>
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

                        <div class="add_edit_pakage aapplication_form" style=" padding-top:0px;">
                            <form name="frmCustomerRegistration" id="frmCustomerRegistration" method="post" action="">
                                <div class="com_address_sec edit_acc">
                                    <h2><a href="<?php echo $objCore->getUrl('dashboard_customer_account.php'); ?>" class="back"><span><?php echo BACK; ?></span></a></h2>

                                    <?php
                                    if ($objCore->displaySessMsg()) {
                                        ?>
                                        <div class="req_field" style="text-align:center; width: 100%">
                                        <?php
                                        echo $objCore->displaySessMsg();

                                        $objCore->setSuccessMsg('');
                                        $objCore->setErrorMsg('');
                                        ?>
                                        </div>
                                        <?php }
                                        ?>
                                    <ul class="left_sec editpass d_left_sec" >
                                        <small class="req_field" style="float:left!important;"> * Fields are required
                                        </small>
                                        <li>
                                            <label><?php echo CUR_PASS; ?>:</label>
                                            
                                            <div class="input_star">
                                                
                                                <input tabindex="5" type="password" value="" name="frmCurrentCustomerPassword" id="frmCurrentCustomerPassword"  class="validate[required] text-input" autocomplete="off"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                            <div id="passError" style="float:left; margin-top: 12px;"><span style="color:red;font-size:12px;"></span></div>
                                        </li>
                                        <li>
                                            <label><?php echo NEW_PASS; ?>:</label>
                                            <div class="input_star">
                                                <input tabindex="5" type="password" value="" name="frmNewCustomerPassword" id="frmNewCustomerPassword" class="validate[required,minSize[6]] text-input" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo CON_NEW_PASS; ?>:</label>
                                            <div class="input_star">
                                                <input tabindex="5" type="password" value="" name="frmConfirmNewCustomerPassword" id="frmConfirmNewCustomerPassword"  class="validate[required,equals[frmNewCustomerPassword]] text-input" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                    </ul>
                                    <div style="clear:both; margin-top:10px;"></div>
                                    <div class="btn_wrap">
                                        <input type="submit"  name="frmHidenCustomerPasswordEdit" value="<?php echo UPDATE; ?>" class="submit_update" style="cursor:pointer"/>

                                        <button class="cancel" style="width: 124px;" value="<?php echo CANCEL; ?>" type="button" name="frmCancel"><?php echo CANCEL; ?></button>

                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html>
