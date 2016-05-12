<?php
require_once 'common/config/config.inc.php';
if (isset($_SESSION['sessUserInfo']['id']) && $_SESSION['sessUserInfo']['type'] == 'customer') {
    header('location:' . SITE_ROOT_URL . 'dashboard_customer_account.php');
    die;
}
require_once CONTROLLERS_PATH . FILENAME_CUSTOMER_CTRL;
//print_r($_SESSION)
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo REGISTRATION_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <script type="text/javascript" src="<?php echo FRONT_JS_PATH; ?>message.inc.js"></script>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH ?>custom_js.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                // binds form submission and fields to the validation engine
                jQuery("#frmCustomerRegistration").validationEngine({
                    'custom_error_messages': {
                        'equals': {
                            'message': "*Password does not match."
                        }, 'equalss': {
                            'message': "*Email does not match."
                        }
                    }
                });
            });

            $(document).ready(function () {
                $('.drop_down1').sSelect();
                $('.drop_down2').sSelect();
                //On change check the Billing country
                $('#frmBillingCountry').change(function () {
                    var cid = parseInt($(this).val());

                    if (cid > 0) {
                        $('.ErrorBillingCountry').css('display', 'none');
                    } else {
                        $('.ErrorBillingCountry').css('display', 'block');
                    }
                });
                //On change check the Shipping country
                $('#frmShippingCountry').change(function () {
                    var cid = parseInt($(this).val());

                    if (cid > 0) {
                        $('.ErrorShippingCountry').css('display', 'none');
                    } else {
                        $('.ErrorShippingCountry').css('display', 'block');
                    }
                });
                //On change check the Residential country
                $('#frmResCountry').change(function () {
                    var cid = parseInt($(this).val());

                    if (cid > 0) {
                        $('.ErrorResCountry').css('display', 'none');
                    } else {
                        $('.ErrorResCountry').css('display', 'block');
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

            function validateForm() {
                var billContId = $('#frmBillingCountry').val();

                if (billContId > 0) {
                    $('.ErrorBillingCountry').css('display', 'none');
                    //   return false;
                } else {
                    $('.ErrorBillingCountry').css('display', 'block');
                }

                var shipContId = $('#frmShippingCountry').val();
                if (shipContId > 0) {
                    $('.ErrorShippingCountry').css('display', 'none');
                    //  return false;
                } else {
                    $('.ErrorShippingCountry').css('display', 'block');
                }
                var resContId = $('#frmResCountry').val();
                if (resContId > 0) {
                    $('.ErrorResCountry').css('display', 'none');
                    // return false;
                } else {
                    $('.ErrorResCountry').css('display', 'block');
                }
            }
        </script>
        <script type="text/javascript">
            function billingShipping() {
                if ($("#frmBillingSame").is(':checked')) {
                    $("#frmShippingFirstName").val($('#frmBillingFirstName').val());
                    $("#frmShippingLastName").val($('#frmBillingLastName').val());
                    $("#frmShippingOrganizationName").val($('#frmBillingOrganizationName').val());
                    $("#frmShippingAddressLine1").val($('#frmBillingAddressLine1').val());
                    $("#frmShippingAddressLine2").val($('#frmBillingAddressLine2').val());
                    $("#frmShippingCountry").getSetSSValue($('#frmBillingCountry').val());
                    // $('#ship_country .newListSelected').remove();
                    //$('.drop_down2').sSelect();
                    $("#frmShippingPostalCode").val($('#frmBillingPostalCode').val());
                    $("#frmShippingPhone").val($('#frmBillingPhone').val());
                    $("#frmShippingTown").val($('#frmBillingTown').val());
                    $('.formError').remove();
                } else {
                    $("#frmShippingFirstName").val('');
                    $("#frmShippingLastName").val('');
                    $("#frmShippingOrganizationName").val('');
                    $("#frmShippingAddressLine1").val('');
                    $("#frmShippingAddressLine2").val('');
                    $("#frmShippingCountry").val('');
                    //$('#ship_country .newListSelected').remove();
                    //$('.drop_down2').sSelect();
                    $("#frmShippingPostalCode").val('');
                    $("#frmShippingPhone").val('');
                    $("#frmShippingTown").val('');
                }
            }

            function resBilling() {
                if ($("#frmResSame").is(':checked')) {

                    $("#frmBillingAddressLine1").val($('#frmResAddressLine1').val());
                    $("#frmBillingAddressLine2").val($('#frmResAddressLine2').val());
                    $("#frmBillingCountry").getSetSSValue($('#frmResCountry').val());
                    // $('#bil_country .newListSelected').remove();
                    $("#frmBillingPostalCode").val($('#frmResPostalCode').val());
                    $("#frmBillingTown").val($('#frmResTown').val());
                    $("#frmBillingPhone").val($('#frmResPhone').val());
                    $('.formError').remove();
                } else {
                    $("#frmBillingAddressLine1").val('');
                    $("#frmBillingAddressLine2").val('');
                    $("#frmBillingCountry").val('');
                    //$('#bil_country .newListSelected').remove();
                    // $('.drop_down2').sSelect();
                    $("#frmBillingPostalCode").val('');
                    $("#frmBillingTown").val('');
                    $("#frmBillingPhone").val('');
                }
            }



        </script>
        <style>

            .edit_acc h3 {
                padding:10px; line-height:21px;
            }
            .req_field{ float:left !important; padding-left:8px; display:block; width:100%; text-transform:none}
            .left_sec right li{ padding-bottom:10px; }
            .add_edit_pakage{ width:1087px;}
            .stylish-select .dropdown_2 .newListSelected{ width:425px;}

            .stylish-select .dropdown_2 .selectedTxt{ background:url("common/images/select2.png") no-repeat scroll 398px 7px}
             
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
        <em>
            <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>
        </em>
        <div class="header"> </div>
        <?php include_once INC_PATH . 'header.inc.php'; ?>
        <div id="">
            <div class="layout">
                <div class="add_pakage_outer">
                    <div class="top_header border_bottom">
                        <h1><?php echo CUSTOMER; ?> <?php echo REGISTRATION; ?></h1>

                    </div>
                    <div class="body_inner_bg radius">
                        <div class="add_edit_pakage aapplication_form">
                            <form onsubmit="return validateForm();"  name="frmCustomerRegistration" id="frmCustomerRegistration" method="post" action="">
                                <div class="com_address_sec edit_acc">

                                    <?php PERSONAL_DETAILS; ?>
                                    <small class="req_field">* <?php echo FILED_REQUIRED; ?></small>
                                    <?php
                                    if ($objCore->displaySessMsg()) {
                                        ?>
                                        <div style="text-align:center; width: auto; color:red">
                                            <?php
                                            echo $objCore->displaySessMsg();
                                            $objCore->setSuccessMsg('');
                                            $objCore->setErrorMsg('');
                                            ?>
                                        </div>
                                    <?php }
                                    ?>
                                    <ul class="left_sec myFullWidth">
                                        <li>
                                            <label><?php echo FIRST_NAME; ?></label>
                                            <div class="input_star">
                                                <input type="text" tabindex="1" name="frmCustomerFirstName" id="frmCustomerFirstName" value="<?php echo @$_POST['frmCustomerFirstName'] ?>"  class="validate[required] text-input" maxlength="50" /><small class="star_icon" style="position:absolute;"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo LAST_NAME; ?> </label>
                                            <input type="text" class="text-input" value="<?php echo @$_POST['frmCustomerLastName'] ?>" tabindex="2" name="frmCustomerLastName" id="frmCustomerLastName" maxlength="50" />
                                        </li>
                                        <li>
                                            <label><?php echo EMAIL; ?></label>
                                            <div class="red" id="customerEmailExistsErrorMsg" style="display:none;"><?php echo FRONT_USER_EMAIL_ALREADY_EXIST; ?></div>
                                            <div class="input_star">

                                                <input type="text" tabindex="3" value="<?php echo @$_GET['email'] ?>" name="frmCustomerEmail" id="frmCustomerEmail" class="validate[required,custom[email]] text-input"  ajexU="<?php echo PATH_URL_CM; ?>" style="position:relative"/>
                                                <small class="star_icon" style="position:absolute;"><img src="common/images/star_icon.png" alt=""/></small> </div>

                                        </li>
                                        <li class="toRight">
                                            <label> <?php echo CONFIRM_EMAIL; ?></label>
                                            <div class="input_star">
                                                <input tabindex="4" type="text" value="<?php echo @$_GET['email'] ?>" name="frmCustomerConfirmEmail" id="frmCustomerConfirmEmail" class="validate[required,custom[email],equalss[frmCustomerEmail]] text-input" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small> </div>
                                        </li>

                                        <div class="clear"></div>
                                        <li>
                                            <label><?php echo PASSWORD; ?></label>
                                            <div class="input_star">
                                                <input tabindex="5" type="password" value="" name="frmCustomerPassword" id="frmCustomerPassword"  class="validate[required,minSize[6]] text-input" maxlength="50"  />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small> </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo CONFIRM_PASSWORD; ?></label>
                                            <div class="input_star">
                                                <input tabindex="6" type="password" value="" name="frmConfirmPassword" id="frmConfirmPassword"  class="validate[required,,minSize[6],equals[frmCustomerPassword]] text-input" maxlength="50"  />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small> </div>
                                        </li>

                                    </ul>

                                    <h3 class="regHeading"><?php echo RES_ADDRESS; ?></h3>
                                    <ul class="left_sec myFullWidth">
                                        <li>
                                            <label> <?php echo ADD_1_ADDRESS; ?></label>
                                            <div class="input_star">
                                                <input tabindex="7" type="text" value="<?php echo @$_POST['frmResAddressLine1']; ?>" name="frmResAddressLine1" id="frmResAddressLine1" class="validate[required] text-input" maxlength="256" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small> </div>
                                        </li>
                                        <li class="toRight">
                                            <label> <?php echo ADD_2_ADDRESS; ?></label>
                                            <input tabindex="8" class="text-input" type="text" value="<?php echo @$_POST['frmResAddressLine2'] ?>" name="frmResAddressLine2" id="frmResAddressLine2" maxlength="256" />
                                        </li>
                                        <li>
                                            <label><?php echo COUNTRY; ?></label>
                                            <div class="input_star">
                                                <div class="drop4 dropdown_2" id="res_country">
                                                    <div class="ErrorResCountry formError" style="opacity: 0.87; position: absolute; top: 180px; display: none; margin-top: -213px; left: 461px;">
                                                        <div class="formErrorContent">* <?php echo $valproductAttribute['AttributeLabel']; ?> <?php echo COUNTRY_REQ_MSG; ?><br>
                                                        </div>
                                                        <div class="formErrorArrow">
                                                            <div class="line10"><!-- --></div>
                                                            <div class="line9"><!-- --></div>
                                                            <div class="line8"><!-- --></div>
                                                            <div class="line7"><!-- --></div>
                                                            <div class="line6"><!-- --></div>
                                                            <div class="line5"><!-- --></div>
                                                            <div class="line4"><!-- --></div>
                                                            <div class="line3"><!-- --></div>
                                                            <div class="line2"><!-- --></div>
                                                            <div class="line1"><!-- --></div>
                                                        </div>
                                                    </div>
                                                    <select class="drop_down2" name="frmResCountry" id="frmResCountry" tabindex="11" >
                                                        <option value="0">Select Country</option>
                                                        <?php
                                                        foreach ($objPage->arrCountryList as $vCT) {
                                                            ?>
                                                            <option value="<?php echo $vCT['country_id']; ?>"><?php echo $vCT['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small> </div>

                                        </li> 
                                        <li class="toRight">
                                            <label><?php echo PHONE; ?></label>
                                            <div class="input_star">
                                                <input tabindex="10" type="text" value="<?php echo @$_POST['frmResPhone'] ?>" name="frmResPhone" id="frmResPhone" class="validate[required,custom[phone]] text-input"  />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small> </div>
                                        </li>
                                        <li>
                                            <label>State</label>
                                            <div class="input_star">
                                                <select name="frmResState" id="frmResState1" class='customselect' >
                                                    <option value="0">Select State</option>

                                                </select> 
                                            </div>


                                        </li>
                                        <li class="toRight">
                                            <label><?php echo POSTAL_CODE_ZIP; ?> </label>
                                            <div class="input_star">
                                                <input tabindex="12" type="text" value="<?php echo @$_POST['frmResPostalCode'] ?>" name="frmResPostalCode" id="frmResPostalCode" maxlength="8" class="validate[required,minSize[4],maxSize[8]] text-input"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small> </div>
                                        </li>
                                        <li>
                                            <label>City</label>
                                            <div class="input_star">
                                                <select name="frmResCity" id="frmResCity1" class='customselect'>
                                                    <option value="0">Select City</option>

                                                </select>
                                            </div>


                                        </li>
                                    </ul>

                                    <h3 class="regHeading"><?php echo BILLING_ADDRESS; ?></h3>
                                    <ul class="left_sec myFullWidth">
                                        <div class="simpleBox">
                                            <div class="check_box" onclick="resBilling()" >
                                                <input type="checkbox" name="frmResSame" id="frmResSame" class="styled" />
                                                <small><?php echo SAME_RES_ADDRESS; ?></small> </div>
                                        </div>

                                        <li>
                                            <label><?php echo RECIPIENT_FIRST_NAME; ?></label>
                                            <div class="input_star">
                                                <input tabindex="13" type="text" value="<?php echo @$_POST['frmBillingFirstName'] ?>" name="frmBillingFirstName" id="frmBillingFirstName" class="validate[required] text-input" maxlength="50" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small> </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo REC_LAST_NAME; ?></label>
                                            <input tabindex="14" type="text" class="text-input" value="<?php echo @$_POST['frmBillingLastName'] ?>" name="frmBillingLastName" id="frmBillingLastName" maxlength="50" />
                                        </li>

                                        <li>
                                            <label><?php echo ORG_NAME; ?></label>
                                            <input tabindex="15" type="text" value="<?php echo @$_POST['frmBillingOrganizationName'] ?>" name="frmBillingOrganizationName" id="frmBillingOrganizationName" class="text-input" maxlength="100" />
                                        </li>
                                        <li class="toRight">
                                            <label>Country</label>
                                            <div class="input_star">
                                                <div class="drop4 dropdown_2" id="bil_country">
                                                    <div class="ErrorBillingCountry formError" style="opacity: 0.87; position: absolute; top: 180px; display: none; margin-top: -213px; left: 461px;">
                                                        <div class="formErrorContent">* <?php echo $valproductAttribute['AttributeLabel']; ?> <?php echo COUNTRY_REQ_MSG; ?><br>
                                                        </div>
                                                        <div class="formErrorArrow">
                                                            <div class="line10"><!-- --></div>
                                                            <div class="line9"><!-- --></div>
                                                            <div class="line8"><!-- --></div>
                                                            <div class="line7"><!-- --></div>
                                                            <div class="line6"><!-- --></div>
                                                            <div class="line5"><!-- --></div>
                                                            <div class="line4"><!-- --></div>
                                                            <div class="line3"><!-- --></div>
                                                            <div class="line2"><!-- --></div>
                                                            <div class="line1"><!-- --></div>
                                                        </div>
                                                    </div>
                                                    <select name="frmBillingCountry" id="frmBillingCountry" class="drop_down2" tabindex="16">
                                                        <option value="0">Select Country</option>
                                                        <?php
                                                        foreach ($objPage->arrCountryList as $vCT) {
                                                            ?>
                                                            <option value="<?php echo $vCT['country_id']; ?>"><?php echo $vCT['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small> </div>
                                        </li>

                                        <li>
                                            <label> <?php echo ADD_1_ADDRESS; ?></label>
                                            <div class="input_star">
                                                <input tabindex="17" type="text" value="<?php echo @$_POST['frmBillingAddressLine1'] ?>" name="frmBillingAddressLine1" id="frmBillingAddressLine1" class="validate[required] text-input" maxlength="256" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li> 

                                        <li class="toRight">
                                            <label> <?php echo ADD_2_ADDRESS; ?> </label>
                                            <input tabindex="18" class="text-input" type="text" value="<?php echo @$_POST['frmBillingAddressLine2'] ?>" name="frmBillingAddressLine2" id="frmBillingAddressLine2" maxlength="256" />
                                        </li>
                                        <li>
                                            <label><?php echo PHONE; ?> </label>
                                            <div class="input_star"><input numericOnly="yes" tabindex="19" type="text" value="" name="frmBillingPhone" id="frmBillingPhone" class="validate[required,custom[phone]] text-input" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>

                                        <li  class="toRight">
                                            <label>State</label>
                                            <div class="input_star">
                                                <select name="BillingState" id="BillingState1" class='customselect'>
                                                    <option value="0">Select State</option>

                                                </select> 
                                            </div>
                                        </li>

                                        <li  class="toRight">
                                            <label>City</label> 
                                            <div class="input_star">
                                                <select name="BillingCity" id="BillingCity1" class='select2-me input-large resCheck customselect'>
                                                    <option value="0">Select City</option>

                                                </select>
                                            </div>
                                        </li>

                                        <li >
                                            <div class="radio_btn">
                                                <input tabindex="21" type="radio" checked="true" name="frmBusinessAddress" value="Billing" class="styled"/>
                                                <small><?php echo BUSINESS_ADD; ?></small></div>
                                        </li>

                                        <li class="" >
                                            <label><?php echo POSTAL_CODE_ZIP; ?></label>
                                            <div class="input_star">
                                                <input tabindex="22" type="text" value="<?php echo @$_POST['frmBillingPostalCode'] ?>" name="frmBillingPostalCode" id="frmBillingPostalCode" maxlength="8" class="validate[required,minSize[4],maxSize[8]] text-input"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small> </div>
                                        </li>


                                    </ul>

                                    <h3 class="regHeading"><?php echo SHIPPING_ADD; ?></h3>
                                    <ul class="left_sec myFullWidth">
                                        <div class="simpleBox">
                                            <div class="check_box" onclick="billingShipping()" >
                                                <input type="checkbox" name="frmBillingSame" id="frmBillingSame" class="styled" />
                                                <small><?php echo SAME_BILLING_ADDRESS; ?></small> </div>
                                        </div>
                                        <li>
                                            <label><?php echo RECIPIENT_FIRST_NAME; ?> </label>
                                            <div class="input_star">
                                                <input tabindex="23" type="text" value="<?php echo @$_POST['frmShippingFirstName'] ?>" name="frmShippingFirstName" id="frmShippingFirstName" class="validate[required] text-input" maxlength="50" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small> </div>
                                        </li>
                                        <li class="toRight">
                                            <label><?php echo REC_LAST_NAME; ?> </label>
                                            <input tabindex="24" type="text" value="<?php echo @$_POST['frmShippingLastName'] ?>" name="frmShippingLastName" id="frmShippingLastName" class="text-input" maxlength="50" />
                                        </li>

                                        <li>
                                            <label><?php echo ORG_NAME; ?> </label>
                                            <input tabindex="25" type="text" value="<?php echo @$_POST['frmShippingOrganizationName'] ?>" name="frmShippingOrganizationName" id="frmShippingOrganizationName" class="text-input" maxlength="100" />
                                        </li> 
                                        <li class="toRight">
                                            <label><?php echo COUNTRY; ?></label>
                                            <div class="input_star">
                                                <div class="drop4 dropdown_2" id="ship_country">
                                                    <div class="ErrorShippingCountry formError" style="opacity: 0.87; position: absolute; top: 180px; display: none; margin-top: -213px; left: 461px;">
                                                        <div class="formErrorContent">* <?php echo $valproductAttribute['AttributeLabel']; ?> <?php echo COUNTRY_REQ_MSG; ?><br>
                                                        </div>
                                                        <div class="formErrorArrow">
                                                            <div class="line10"><!-- --></div>
                                                            <div class="line9"><!-- --></div>
                                                            <div class="line8"><!-- --></div>
                                                            <div class="line7"><!-- --></div>
                                                            <div class="line6"><!-- --></div>
                                                            <div class="line5"><!-- --></div>
                                                            <div class="line4"><!-- --></div>
                                                            <div class="line3"><!-- --></div>
                                                            <div class="line2"><!-- --></div>
                                                            <div class="line1"><!-- --></div>
                                                        </div>
                                                    </div>
                                                    <select tabindex="26" class="drop_down2" name="frmShippingCountry" id="frmShippingCountry" >
                                                        <option value="0">Select Country</option>
                                                        <?php
                                                        foreach ($objPage->arrCountryList as $vCT) {
                                                            ?>
                                                            <option value="<?php echo $vCT['country_id']; ?>"><?php echo $vCT['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small> </div>
                                        </li> 
                                        <li>
                                            <label> <?php echo ADD_1_ADDRESS; ?></label>
                                            <div class="input_star">
                                                <input tabindex="27" type="text" value="<?php echo @$_POST['frmShippingAddressLine1'] ?>" name="frmShippingAddressLine1" id="frmShippingAddressLine1" class="validate[required] text-input" maxlength="256" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small> </div>
                                        </li>	
                                        <li class="toRight">
                                            <label> <?php echo ADD_2_ADDRESS; ?></label>
                                            <input tabindex="28" class="text-input" type="text" value="<?php echo @$_POST['frmShippingAddressLine2'] ?>" name="frmShippingAddressLine2" id="frmShippingAddressLine2" maxlength="256" />
                                        </li>


                                        <li>
                                            <label><?php echo PHONE; ?> </label>
                                            <div class="input_star">
                                                <input tabindex="29" type="text" value="<?php echo @$_POST['frmShippingPhone'] ?>" name="frmShippingPhone" id="frmShippingPhone" class="validate[required,custom[phone]] text-input"  />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small> </div>
                                        </li>
                                        <li class="toRight">
                                            <label>State</label>
                                            <div class="input_star">
                                                <select name="ShippingState" id="ShippingState1" class='select2-me input-large resCheck customselect'>
                                                    <option value="0">Select State</option>

                                                </select> 
                                            </div>
                                        </li>

                                        <li class="toRight">
                                            <label>City</label>
                                            <div class="input_star">
                                                <select name="ShippingCity" id="ShippingCity1" class='select2-me input-large resCheck customselect'>
                                                    <option value="0">Select City</option>

                                                </select>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="radio_btn">
                                                <input tabindex="31" type="radio" name="frmBusinessAddress" value="Shipping" class="styled"/>
                                                <small><?php echo BUSINESS_ADD; ?></small></div>
                                        </li>

                                        <li class="">
                                            <label><?php echo POSTAL_CODE_ZIP; ?> </label>
                                            <div class="input_star">
                                                <input tabindex="32" type="text" value="<?php echo @$_POST['frmShippingPostalCode'] ?>" name="frmShippingPostalCode" id="frmShippingPostalCode" maxlength="8" class="validate[required,minSize[4],maxSize[8]] text-input" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small> </div>
                                        </li>


                                    </ul>

                                    <span class="btn registr_btn cstmRegister">
                                        <input tabindex="33" type="submit" value="Register" name="" class="watch_link"  style="float:right; margin-bottom:20px;"/>
                                        <input type="hidden" name="frmReferal" value="<?php echo (isset($_REQUEST['ref'])) ? $_REQUEST['ref'] : ''; ?>" />
                                        <input type="hidden" name="frmHidenAdd" id="frmHidnAddPage" value="add" />
                                    </span> 
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
