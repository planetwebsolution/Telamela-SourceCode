<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_CUSTOMER_ACCOUNT_CTRL;
$objCustomer = new Customer();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo EDIT_ACCOUNT_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH ?>customer_profile.js"></script> 
        <link rel="stylesheet" href="<?php echo CSS_PATH ?>select2.css"/>
        <script src="<?php echo JS_PATH ?>select2.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                // binds form submission and fields to the validation engine
                jQuery("#frmCustomerRegistration").validationEngine();
                $('.drop_down1').sSelect();
                $('.drop_down2').sSelect();
                $('.cancel').click(function () {
                    window.location.href = 'dashboard_customer_account.php';

                });

                $('#frmBillingCountry').change(function () {
                    if ($('#frmBillingCountry').val() == '0' || $('#frmBillingCountry').val() == '') {
                        $('.ErrorfrmBillingCountry').css('display', 'block');
                        var error = errorMessage();
                        $('.ErrorfrmBillingCountry').html(error);
                    } else {
                        $('.ErrorfrmBillingCountry').css('display', 'none');
                    }

                });


                $('#frmShippingCountry').change(function () {
                    if ($('#frmShippingCountry').val() == '0' || $('#frmShippingCountry').val() == '') {
                        $('.ErrorfrmShippingCountry').css('display', 'block');
                        var error = errorMessage();
                        $('.ErrorfrmShippingCountry').html(error);
                    } else {
                        $('.ErrorfrmShippingCountry').css('display', 'none');
                    }

                });

                $('#checkAvial').on('click', function () {
                    var q = $('#frmCustomerScreenName').val();
                    if ($.trim(q) != '') {
                        $.post('', {action: 'ScreenName', q: q}, function (data) {
                            $('#screenmsg').html(data);
                        });
                    } else {
                        $('#frmCustomerScreenName').focus();
                    }
                });
                //Refer friend email will check here
                $("#frmRecommendform").validationEngine();
                $('body').on('click', '#verify_email', function () {
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
                    $.each(afterSpStr, function (key, value) {
                        $.ajax({
                            url: SITE_ROOT_URL + "common/ajax/ajax.php",
                            type: 'POST',
                            data: {action: "verifyEmail", email: value},
                            async: false, //blocks window close
                            dataType: "json",
                            success: function (data) {
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
                        if ($('#frmRecommendform .formErrorContent').html() != '' && typeof $('#frmRecommendform .formErrorContent').html() !== 'undefined') {
                            $('#frmFriendEmail').prop('readonly', false);
                        } else {
                            $('#frmFriendEmail').attr('readonly', 'readonly');
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

                $('#frmResCountry').on('change', function () {
                    var countryid = this.value;
                    // alert(countryid);
                    $.ajax({
                        type: "POST",
                        url: 'admin/ajax.php',
                        data: {action: 'showCountryState', q: countryid, },
                    }).done(function (data) {
                        console.log(data);
                        $("#frmResState1").html(data);
                    });

                });

                $('#frmResState1').on('change', function () {
                    var stateid = this.value;
                    // alert(countryid);
                    $.ajax({
                        type: "POST",
                        url: 'admin/ajax.php',
                        data: {action: 'showStateCity', q: stateid, },
                    }).done(function (data) {
                        $("#frmResCity1").html(data);
                    });

                });

                $('#frmBillingCountry').on('change', function () {
                    var countryid = this.value;
                    // alert(countryid);
                    $.ajax({
                        type: "POST",
                        url: 'admin/ajax.php',
                        data: {action: 'showCountryState', q: countryid, },
                    }).done(function (data) {
                        $("#BillingState1").html(data);
                    });

                });

                $('#BillingState1').on('change', function () {
                    var stateid = this.value;
                    // alert(countryid);
                    $.ajax({
                        type: "POST",
                        url: 'admin/ajax.php',
                        data: {action: 'showStateCity', q: stateid, },
                    }).done(function (data) {
                        $("#BillingCity1").html(data);
                    });

                });

                $('#frmShippingCountry').on('change', function () {
                    var countryid = this.value;
                    // alert(countryid);
                    $.ajax({
                        type: "POST",
                        url: 'admin/ajax.php',
                        data: {action: 'showCountryState', q: countryid, },
                    }).done(function (data) {
                        $("#ShippingState1").html(data);
                    });

                });

                $('#ShippingState1').on('change', function () {
                    var stateid = this.value;
                    // alert(countryid);
                    $.ajax({
                        type: "POST",
                        url: 'admin/ajax.php',
                        data: {action: 'showStateCity', q: stateid, },
                    }).done(function (data) {
                        $("#ShippingCity1").html(data);
                    });

                });
            });
            //This will show Refer friend pop up
            function wholesalerReplyPopup(str) {
                $('#frmFriendEmail').focus();
                $('#verify_email').show();
                $('#frmHidenSend').hide();
                $('#msgError').html('');
                $('#frmFriendEmail').prop('readonly', false);
                $("." + str).colorbox({inline: true, width: "700px"});


                $('#recommend_cancel').click(function () {
                    parent.jQuery.fn.colorbox.close();
                });
            }
        </script>
        <script type="text/javascript">
            var sm = 0;
            function billingShipping() {
                if ($("#frmBillingSame").is(':checked')) {
                    $("#frmShippingFirstName").val($('#frmBillingFirstName').val());
                    $("#frmShippingLastName").val($('#frmBillingLastName').val());
                    $("#frmShippingOrganizationName").val($('#frmBillingOrganizationName').val());
                    $("#frmShippingAddressLine1").val($('#frmBillingAddressLine1').val());
                    $("#frmShippingAddressLine2").val($('#frmBillingAddressLine2').val());
                    $("#frmShippingCountry").val($('#frmBillingCountry').val());
                    $('#ship_country .newListSelected').remove();
                    $('.drop_down2').sSelect();
                    $("#frmShippingPostalCode").val($('#frmBillingPostalCode').val());
                    $("#frmShippingPhone").val($('#frmBillingPhone').val());
                    $("#frmShippingTown").val($('#frmBillingTown').val());
                    $('.formError').remove();
                    sm = 1;
                } else {
                    $("#frmShippingFirstName").val('');
                    $("#frmShippingLastName").val('');
                    $("#frmShippingOrganizationName").val('');
                    $("#frmShippingAddressLine1").val('');
                    $("#frmShippingAddressLine2").val('');
                    $("#frmShippingCountry").val('');
                    $('#ship_country .newListSelected').remove();
                    $('.drop_down2').sSelect();
                    $("#frmShippingPostalCode").val('');
                    $("#frmShippingPhone").val('');
                    $("#frmShippingTown").val('');
                    sm = 0;
                }
                $.post(SITE_ROOT_URL + "common/ajax/ajax_customer.php", {
                    action: 'sameShippingAddess',
                    sm: sm
                }, function (d) {
                });
            }
            function errorMessageRefferLink() {
                var errMsg = '* Required field';
                return '<div style="opacity: 0.87; position: absolute; top: 101px; left: 425px;" class="formError"><div class="formErrorContent">' + errMsg + '<br/></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>';
            }
        </script>
        <style>.input_star .star_icon{ right:1px;}

            .customfile1-button{ padding-left:2px}
            .ship_left ul li{ line-height:30px;}
            .add_edit_pakage label{ width:100%; margin-bottom:5px; float:left;}
            .add_edit_pakage{ background:none !important}
            .com_address_sec{float: left;width: 100%;}
            .reply_message .left_m{width:300px !important}
            .newListSelHover{ width:467px !important;}
            .customselect{
                background: #FFF;
                color: #3f3e3e;
                /* float: left; */
                height: 37px;
                moz-border-radius: 3px;
                padding: 0 25px 0 10px;
                width: 100%;border:1px solid #dcdcdc}



        </style>
    </head>
    <body>
        <?php
        //pre($objPage->arrCustomerDeatails);
        ?>
        <div id="navBar">
            <?php include_once 'common/inc/top-header.inc.php'; ?>
        </div>
        <div class="header" style=" border:none"><div class="layout">

            </div>
        </div><?php include_once INC_PATH . 'header.inc.php'; ?>
        <div id="ouderContainer" class="ouderContainer_1">
            <div class="layout">

                <div class="">

                    <?php
                    if ($objCore->displaySessMsg()) {
                        ?>
                        <div style="">
                            <?php
                            echo $objCore->displaySessMsg();
                            $objCore->setSuccessMsg('');
                            $objCore->setErrorMsg('');
                            ?>
                        </div>
                    <?php }
                    ?>

                </div>
                <div class="add_pakage_outer" style="background:none">
                    <div class="top_container" >
                        <div class="top_header border_bottom">
                            <h1><?php echo EDIT; ?> <?php echo MY_AC; ?></h1>
                        </div>

                    </div>
                    <div class="body_inner_bg radius">

                        <div class="topname_outer space_bot">
                            <div class="topname_inner">
                                &nbsp;
                            </div>
                            <div class="topname_links">
                                <a href="<?php echo $objCore->getUrl('my_rewards.php'); ?>" class="edit2"><?php echo MY_REWARDS . ' (' . $objPage->arrCustomerDeatails[0]['BalancedRewardPoints'] . ')'; ?></a>
                                <a href="<?php echo $objCore->getUrl('edit_my_account.php', array('type' => 'edit')); ?>" class="edit2 edit2active"><?php echo EDIT_AC; ?></a>
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
                                    <div class="left_m"><label><?php echo FR_EMAIL; ?> *: </label><br /><small class="red">(You can use multiple email with comma separated.)</small></div><div class="right_m">
                                        <span id="msgError" style="color: red;clear: both;display: block;font-size: 11px;margin-bottom: 10px; word-wrap: break-word;"></span>
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


                        <div class="add_edit_pakage aapplication_form">
                            <form name="frmCustomerRegistration" id="frmCustomerRegistration" method="post" action=""  onsubmit="return validateForm();">
                                <div class="com_address_sec edit_acc">
                                    <h2><a style=" margin-top:-6px; margin-bottom:20px;" href="<?php echo $objCore->getUrl('dashboard_customer_account.php'); ?>" class="back"><span><?php echo BACK; ?></span></a></h2>
                                    <h3 style="background: #eee;padding: 10px;border-radius: 3px;">
                                        <?php echo PERSONAL_DETAILS; ?>
                                        <small class="req_field">* <?php echo FILED_REQUIRED; ?> </small>
                                    </h3>

                                    <ul class="left_sec myFullWidth editacc" >
                                        <li>
                                            <label><?php echo FIRST_NAME; ?></label>
                                            <div class="input_star"><input type="text" tabindex="1" name="frmCustomerFirstName" id="frmCustomerFirstName" value="<?php echo $objPage->arrCustomerDeatails[0]['CustomerFirstName']; ?>"  class="validate[required] text-input" maxlength="50" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo LAST_NAME; ?> </label>
                                            <input type="text" value="<?php echo $objPage->arrCustomerDeatails[0]['CustomerLastName']; ?>" tabindex="2" name="frmCustomerLastName" id="frmCustomerLastName" maxlength="50" />
                                        </li>
                                        <li>
                                            <label><?php echo SCREEN_NAME; ?></label>
                                            <div class="input_star">
                                                <input type="text" tabindex="3" name="frmCustomerScreenName" style="505px" maxlength="15" id="frmCustomerScreenName" value="<?php echo $objPage->arrCustomerDeatails[0]['CustomerScreenName']; ?>"  class="validate[required]"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                            <div class="red" id="screenmsg"><?php echo SCREEN_NAME_MESSAGE ?></div>
                                            <div style="font-size: 12px; float:left">                                                <a style="color: #0F77EC" id="checkAvial">
                                                    Check Screen Name Availability
                                                </a>
                                            </div>
                                        </li>
                                    </ul>



                                    <h3 class="regHeading"><?php echo RES_ADDRESS; ?></h3>
                                    <ul class="left_sec myFullWidth editacc">
                                        <li>
                                            <label> <?php echo ADD_1_ADDRESS; ?></label>
                                            <div class="input_star"> <input tabindex="4" type="text" value="<?php echo $objPage->arrCustomerDeatails[0]['ResAddressLine1']; ?>" name="frmResAddressLine1" id="frmResAddressLine1" class="validate[required] text-input" maxlength="256" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo COUNTRY; ?></label>
                                            <div class="input_star">
                                                <div class="drop4 dropdown_2" id="res_country">
                                                    <div class="ErrorResCountry formError" style="opacity: 0.87; position: absolute; top: 180px; display: none; margin-top: -213px; left: 395px;"><div class="formErrorContent">* <?php echo $valproductAttribute['AttributeLabel']; ?> <?php echo COUNTRY_REQ_MSG; ?><br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>
                                                    <select tabindex="5" class="drop_down2" name="frmResCountry" id="frmResCountry" >
                                                        <option value="0">Select Country</option>
                                                        <?php
                                                        foreach ($objPage->arrCountryList as $vCT) {
                                                            ?>
                                                            <option value="<?php echo $vCT['country_id']; ?>"<?php
                                                            if ($vCT['country_id'] == $objPage->arrCustomerDeatails[0]['ResCountry']) {
                                                                echo 'selected="selected"';
                                                            }
                                                            ?>><?php echo $vCT['name']; ?></option>
                                                                <?php } ?>
                                                    </select>
                                                </div>

                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label> <?php echo ADD_2_ADDRESS; ?></label>
                                            <input tabindex="6" type="text" value="<?php echo $objPage->arrCustomerDeatails[0]['ResAddressLine2']; ?>" name="frmResAddressLine2" id="frmResAddressLine2" maxlength="256" />

                                        </li>
                                        <li class="toRight">
                                            <label>State</label>
                                            <div class="input_star">
                                                <select name="frmResState" id="frmResState1" class='customselect' >
                                                    <option value="0">Select State</option>
                                                    <?php
                                                    $statearraybycountryid = $objGeneral->statelistbycountryid($objPage->arrCustomerDeatails[0]['ResCountry']);
                                                    foreach ($statearraybycountryid as $vv) {
                                                        //in_array($gatway,)

                                                        if ($objPage->arrCustomerDeatails[0]['ResState'] == $vv['id'])
                                                            echo '<option selected value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                        else {
                                                            echo '<option value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                        }
                                                    }
                                                    ?>

                                                </select> 
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label>City</label>
                                            <div class="input_star">
                                                <select name="frmResCity" id="frmResCity1" class='customselect'>
                                                    <option value="0">Select City</option>
                                                    <?php
                                                    $cityarraybystateid = $objGeneral->countrylistbynewstateid($objPage->arrCustomerDeatails[0]['ResState']);
                                                    foreach ($cityarraybystateid as $vv) {

                                                        //in_array($gatway,)
                                                        if ($objPage->arrCustomerDeatails[0]['ResCity'] == $vv['id']) {
                                                            $frmDistanceEnable = true;
                                                            echo '<option selected value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                        } else {
                                                            echo '<option value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </li>
                                        <li class="">
                                            <label><?php echo POSTAL_CODE_ZIP; ?> </label>
                                            <div class="input_star"><input tabindex="8" type="text" value="<?php echo $objPage->arrCustomerDeatails[0]['ResPostalCode']; ?>" name="frmResPostalCode" id="frmResPostalCode" maxlength="8" class="validate[required,minSize[4],maxSize[8]]"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>

                                        </li>
                                        <li class="">
                                            <label><?php echo PHONE; ?></label>
                                            <div class="input_star">
                                                <input numericOnly="yes" tabindex="9" type="text" value="<?php echo $objPage->arrCustomerDeatails[0]['ResPhone']; ?>" name="frmResPhone" id="frmResPhone" class="validate[required,custom[phone]]"/>

                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                    </ul>

                                    <h3  class="regHeading"><?php echo BILLING_ADDRESS; ?></h3>
                                    <ul class="left_sec myFullWidth editacc">
                                        <li>
                                            <label><?php echo RECIPIENT_FIRST_NAME; ?> </label>
                                            <div class="input_star"><input tabindex="10" type="text" value="<?php echo $objPage->arrCustomerDeatails[0]['BillingFirstName']; ?>" name="frmBillingFirstName" id="frmBillingFirstName" class="validate[required] text-input" maxlength="50" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li  class="toRight">
                                            <label><?php echo REC_LAST_NAME; ?> </label>
                                            <input tabindex="11" type="text" value="<?php echo $objPage->arrCustomerDeatails[0]['BillingLastName']; ?>" name="frmBillingLastName" id="frmBillingLastName" maxlength="50" />
                                        </li>

                                        <li>
                                            <label><?php echo ORG_NAME; ?></label>

                                            <input tabindex="12" type="text" value="<?php echo $objPage->arrCustomerDeatails[0]['BillingOrganizationName']; ?>" name="frmBillingOrganizationName" id="frmBillingOrganizationName" class="" maxlength="100" />


                                        </li>
                                        <li class="toRight">
                                            <label><?php echo COUNTRY; ?></label>
                                            <div class="input_star">
                                                <div class="drop4 dropdown_2">
                                                    <div class="ErrorfrmBillingCountry" style="display: none;"></div>

                                                    <select tabindex="13" name="frmBillingCountry" id="frmBillingCountry" class="drop_down1">
                                                        <option value=""><?php echo SEL_CON; ?></option>
                                                        <?php
                                                        foreach ($objPage->arrCountryList as $vCT) {
                                                            ?>
                                                            <option value="<?php echo $vCT['country_id']; ?>" <?php
                                                        if ($vCT['country_id'] == $objPage->arrCustomerDeatails[0]['BillingCountry']) {
                                                            echo 'selected="selected"';
                                                        }
                                                            ?>><?php echo $vCT['name']; ?></option>
                                                                <?php } ?>
                                                    </select>
                                                </div>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>

                                        <li>
                                            <label> <?php echo ADD_1_ADDRESS; ?></label>
                                            <div class="input_star"><input tabindex="14" type="text" value="<?php echo $objPage->arrCustomerDeatails[0]['BillingAddressLine1']; ?>" name="frmBillingAddressLine1" id="frmBillingAddressLine1" class="validate[required] text-input" maxlength="256" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>   
                                        <li class="toRight">
                                            <label> <?php echo ADD_2_ADDRESS; ?> </label>
                                            <input tabindex="15" type="text" value="<?php echo $objPage->arrCustomerDeatails[0]['BillingAddressLine2']; ?>" name="frmBillingAddressLine2" id="frmBillingAddressLine2" maxlength="256" />
                                        </li>
                                        <li>

                                            <label>State</label>
                                            <div class="input_star">
                                                <select name="BillingState" id="BillingState1" class='customselect'>
                                                    <option value="0">Select State</option>
                                                    <?php
                                                                                 $statearraybycountryid = $objGeneral->statelistbycountryid($objPage->arrCustomerDeatails[0]['BillingCountry']);
                                                                                                foreach ($statearraybycountryid as $vv) {
                                                                                                    //in_array($gatway,)
                                                                                                    
                                                                                                    if ($objPage->arrCustomerDeatails[0]['BillingState'] == $vv['id'])
                                                                                                        echo '<option selected value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    else {
                                                                                                        echo '<option value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    }
                                                                                                }
                                                                                                ?>
                                                </select> 
                                            </div>
                                        </li>

                                        <li class="toRight">

                                            <label>City</label>
                                            <div class="input_star">
                                                <select name="BillingCity" id="BillingCity1" class='select2-me input-large resCheck customselect'>
                                                    <option value="0">Select City</option>
                                                    <?php
                                                                                  $cityarraybystateid = $objGeneral->countrylistbynewstateid($objPage->arrCustomerDeatails[0]['BillingState']);               
                                                                                                foreach ($cityarraybystateid as $vv) {

                                                                                                    //in_array($gatway,)
                                                                                                    if ($objPage->arrCustomerDeatails[0]['BillingCity'] == $vv['id']) {
                                                                                                        $frmDistanceEnable = true;
                                                                                                        echo '<option selected value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    } else {
                                                                                                        echo '<option value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    }
                                                                                                }
                                                                                                
                                                                                                ?>
                                                </select>
                                            </div>
                                        </li>				
                                        <li >
                                            <label><?php echo POSTAL_CODE_ZIP; ?></label>
                                            <div class="input_star"><input tabindex="17" type="text" value="<?php echo $objPage->arrCustomerDeatails[0]['BillingPostalCode']; ?>" name="frmBillingPostalCode" id="frmBillingPostalCode" maxlength="8" class="validate[required,minSize[4],maxSize[8]]"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo PHONE; ?> </label>
                                            <div class="input_star"><input numericOnly="yes" tabindex="18" type="text" value="<?php echo $objPage->arrCustomerDeatails[0]['BillingPhone']; ?>" name="frmBillingPhone" id="frmBillingPhone" class="validate[required,custom[phone]] text-input"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <div class="radio_btn">
                                                <input type="radio" class="styled" value="Billing" name="frmBusinessAddress" <?php
                                                                if ($objPage->arrCustomerDeatails[0]['BusinessAddress'] == 'Billing') {
                                                                    echo 'checked=checked';
                                                                }
                                                                ?> /><small><?php echo BUSINESS_ADD; ?></small></div>

                                        </li>
                                    </ul>

                                    <h3 class="regHeading"><?php echo SHIPPING_ADD; ?></h3>
                                    <ul class="left_sec myFullWidth editacc">
                                        <li>
                                            <div class="check_box" onclick="billingShipping()" >
                                                <input tabindex="19" type="checkbox" name="frmBillingSame" id="frmBillingSame" class="styled" <?php echo $objPage->arrCustomerDeatails[0]['SameShipping'] == 1 ? 'checked="checked"' : ''; ?>/> <small><?php echo SAME_BILLING_ADDRESS; ?></small>
                                            </div>
                                        </li>
                                        <div class="clear"></div>
                                        <li>
                                            <label><?php echo RECIPIENT_FIRST_NAME; ?></label>
                                            <div class="input_star"><input tabindex="20" type="text" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingFirstName']; ?>" name="frmShippingFirstName" id="frmShippingFirstName" class="validate[required] text-input" maxlength="50" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo REC_LAST_NAME; ?></label>
                                            <input tabindex="21" type="text" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingLastName']; ?>" name="frmShippingLastName" id="frmShippingLastName" maxlength="256" />
                                        </li>
                                        <li>
                                            <label><?php echo ORG_NAME; ?> </label>

                                            <input tabindex="22" type="text" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingOrganizationName']; ?>" name="frmShippingOrganizationName" id="frmShippingOrganizationName" class="" maxlength="100" />

                                        </li>
                                        <li class="toRight">
                                            <label><?php echo COUNTRY; ?></label>
                                            <div class="input_star">

                                                <div class="drop4 dropdown_2" id="ship_country">
                                                    <div class="ErrorfrmShippingCountry" style="display: none;"></div>
                                                    <select class="drop_down2" name="frmShippingCountry" id="frmShippingCountry" tabindex="23">
                                                        <option value=""><?php echo SEL_CON; ?></option>
                                                        <?php
                                                        foreach ($objPage->arrCountryList as $vCT) {
                                                            ?>
                                                            <option value="<?php echo $vCT['country_id']; ?>" <?php
                                                        if ($vCT['country_id'] == $objPage->arrCustomerDeatails[0]['ShippingCountry']) {
                                                            echo 'selected="selected"';
                                                        }
                                                            ?>><?php echo $vCT['name']; ?></option>
                                                                <?php } ?>
                                                    </select>
                                                </div>

                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo ADD_1_ADDRESS; ?></label>
                                            <div class="input_star"> <input tabindex="24" type="text" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingAddressLine1']; ?>" name="frmShippingAddressLine1" id="frmShippingAddressLine1" class="validate[required] text-input" maxlength="256" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">

                                            <label>State</label>
                                            <div class="input_star">
                                                <select name="ShippingState" id="ShippingState1" class='select2-me input-large resCheck customselect'>
                                                    <option value="0">Select State</option>
                                                    <?php
                                                                                 $statearraybycountryid = $objGeneral->statelistbycountryid($objPage->arrCustomerDeatails[0]['ShippingCountry']);
                                                                                                foreach ($statearraybycountryid as $vv) {
                                                                                                    //in_array($gatway,)
                                                                                                    
                                                                                                    if ($objPage->arrCustomerDeatails[0]['ShippingState'] == $vv['id'])
                                                                                                        echo '<option selected value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    else {
                                                                                                        echo '<option value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    }
                                                                                                }
                                                                                                ?>
                                                </select> 
                                            </div>
                                        </li>
                                        <li class="toRight">

                                            <label>City</label>
                                            <div class="input_star">
                                                <select name="ShippingCity" id="ShippingCity1" class='select2-me input-large resCheck customselect'>
                                                    <option value="0">Select City</option>
                                                    <?php
                                                                                  $cityarraybystateid = $objGeneral->countrylistbynewstateid($objPage->arrCustomerDeatails[0]['ShippingState']);               
                                                                                                foreach ($cityarraybystateid as $vv) {

                                                                                                    //in_array($gatway,)
                                                                                                    if ($objPage->arrCustomerDeatails[0]['ShippingCity'] == $vv['id']) {
                                                                                                        $frmDistanceEnable = true;
                                                                                                        echo '<option selected value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    } else {
                                                                                                        echo '<option value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    }
                                                                                                }
                                                                                                
                                                                                                ?>
                                                </select>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo ADD_2_ADDRESS; ?></label>
                                            <input tabindex="26" type="text" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingAddressLine2']; ?>" name="frmShippingAddressLine2" id="frmShippingAddressLine2" maxlength="256" />

                                        </li>
                                        <li class="toRight">
                                            <label><?php echo PHONE; ?> </label>
                                            <div class="input_star"><input in-gm4pixelcrayons tabindex="27" type="text" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingPhone']; ?>" name="frmShippingPhone" id="frmShippingPhone" class="validate[required,custom[phone]] text-input" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo POSTAL_CODE_ZIP; ?></label>
                                            <div class="input_star"><input tabindex="28" type="text" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingPostalCode']; ?>" name="frmShippingPostalCode" id="frmShippingPostalCode" maxlength="8" class="validate[required,minSize[4],maxSize[8]]"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <div class="radio_btn">
                                                <input tabindex="30" type="radio" class="styled" value="Shipping" name="frmBusinessAddress" <?php echo ($objPage->arrCustomerDeatails[0]['BusinessAddress'] == 'Shipping') ? 'checked=checked' : ''; ?> />
                                                <small><?php echo BUSINESS_ADD; ?></small>
                                            </div>
                                        </li>
                                    </ul>


                                    <div class="btn text-center">
                                        <input type="submit" tabindex="31"    name="frmHidenEdit" value="<?php echo UPDATE; ?>" class="submit3"/>
                                        <button tabindex="32" class="cancel"  value="<?php echo CANCEL; ?>" type="button" name="frmCancel"><?php echo CANCEL; ?></button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once INC_PATH . 'footer.inc.php'; ?>
    </body>
</html>
