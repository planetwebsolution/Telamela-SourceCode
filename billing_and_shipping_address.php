<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_BILLING_SHIPPING_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo BILL_SHIPP_ADD; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>

        <script type="text/javascript">

            $(document).ready(function(){
                $('.drop_down1').sSelect();
                $('.drop_down2').sSelect();
                $("#billingShippingAddress").validationEngine();
                $('#frmBillingCountry').change(function() {
                    if ($("#frmBillingCountry ").val() == '' || $("#frmBillingCount r y  ").val() == '0'){
                        $('.ErrorfrmBillingCountry').html('<div style="opacity: 0.87; position: absolute; top: 180px; display: block; margin-top: -213px; left: 456px;" class="formError"><div class="formErrorContent">* country required!<br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div><div>');
                        return false;   }else{
                        $('.ErrorfrmBillingCountry').html('');
                    }
                });
                
                $('#frmShippingCountry').change(function() {
                    if($("#frmShippingCountry").val()=='' || $("#frmShippingCountry").val()=='0'){
                        $('.ErrorfrmShippingCountry').html('<div style="opacity: 0.87; position: absolute; top: 180px; display: block; margin-top: -213px; left: 455px;" class="formError"><div class="formErrorContent">* country required!<br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div><div>');
                        return false;
                    }else{
                        $('.ErrorfrmShippingCountry').html('');
                    }
                });
            });
        </script>
        <script type="text/javascript">
            var sm = 0;
            function billingShipping(){
                if ($("#frmBillingSame").is(':checked')){
                    $("#frmShippingFirstName").val($('#frmBillingFirstName').val());
                    $("#frmShippingLastName").val($('#frmBillingLastName').val());
                    $("#frmShippingOrganizationName").val($('#frmBillingOrganizationName').val());
                    $("#frmShippingAddressLine1").val($('#frmBillingAddressLine1').val());
                    $("#frmShippingAddressLine2").val($('#frmBillingAddressLine2').val());
                    $("#frmShippingCountry").val($('#frmBillingCountry').val());
                    //$('#ship_country .newListSelected').remove();
                    //$('.drop_down2').sSelect();
                    $("#frmShippingPostalCode").val($('#frmBillingPostalCode').val());
                    $("#frmShippingPhone").val($('#frmBillingPhone').val());
                    $('.formError').remove();
                    sm = 1;
                } else{
                    $("#frmShippingFirstName").val('');
                    $("#frmShippingLastName").val('');
                    $("#frmShippingOrganizationName").val('');
                    $("#frmShippingAddressLine1").val('');
                    $("#frmShippingAddressLine2").val('');
                    $("#frmShippingCountry").val('');
                    //$('#ship_country .newListSelected').remove();
                    ///$('.drop_down2').sSelect();
                    $("#frmShippingPostalCode").val('');
                    $("#frmShippingPhone").val('');
                    sm = 0;
                }
                    
                $.post(SITE_ROOT_URL + "common/ajax/ajax_customer.php", {
                    action:'sameShippingAddess',
                    sm:sm
                }, function(d){ });
            }
        </script>
        <style> .stylish-select .dropdown_2 .selectedTxt{ background:url("common/images/select2.png") no-repeat scroll 399px 7px #fff; width:374px;}
            .stylish-select .dropdown_2 .newListSelected{ width:427px  }
            .input_star .star_icon{ right:1px; }
            .billing_sec.right1 h3{ padding-bottom:0px;}
            .billing_sec{border-right: 1px solid #eee;
                         padding-right: 62px;
                         width: 500px; }
													input:focus{border: 1px solid #F90 !important;}												
																									
            .left_sec label{ clear:both; display:block; padding-top:30px;}
            .left_sec{ width:98%; float:left}.add_edit_pakage input[type="text"]{ width:484px;}
        </style>
        <script>
            function validateForm(){

                if ($("#frmBillingCountry").val() == '' || $("#frmBillingCountry").val() == '0'){
                    $('.ErrorfrmBillingCountry').html('<div style="opacity: 0.87; position: absolute; top: 180px; display: block; margin-top: -213px; left: 455px;" class="formError"><div class="formErrorContent">* <?php echo COUNTRY_REQ_MSG; ?><br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div><div>');
                    return false;
                }
                if ($('#frmShippingCountry').val() == '' || $("#frmShippingCountry").val() == '0'){
                    $('.ErrorfrmShippingCountry').html('<div style="opacity: 0.87; position: absolute; top: 180px; display: block; margin-top: -213px; left: 455px;" class="formError"><div class="formErrorContent">* <?php echo COUNTRY_REQ_MSG; ?><br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div><div>');
                    return false;
                }


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
                        <h1><?php echo BILL_SHIPP; ?> <?php echo ADDRESS; ?></h1>

                    </div>   
                    <div class="body_inner_bg radius">
                        <div class="add_edit_pakage aapplication_form">
                            <form id="billingShippingAddress" action="" method="post" onsubmit="return validateForm();">
                                <div class="com_address_sec billing_sec left">
                                    <h3 style="margin-left:10px;">Billing Address<small class="req_field" style="text-transform: capitalize">* Fields are required </small></h3>
                                    <ul class="left_sec">
                                        <li><div class="check_box">&nbsp;</div></li>
                                        <li>
                                            <label><?php echo RECIPIENT_FIRST_NAME; ?></label>
                                            <div class="input_star">
                                                <input type="text" name="frmBillingFirstName" tabindex="1" id="frmBillingFirstName" class="validate[required] text-01" value="<?php echo $objPage->arrCustomerDeatails[0]['BillingFirstName']; ?>" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo REC_LAST_NAME; ?></label>                                            
                                            <input type="text" name="frmBillingLastName" tabindex="2" id="frmBillingLastName" class="text-01" value="<?php echo $objPage->arrCustomerDeatails[0]['BillingLastName']; ?>" />                                                
                                        </li>
                                        <li>
                                            <label><?php echo ORG_NAME; ?> </label>
                                            <input type="text" class="text-01" tabindex="3" name="frmBillingOrganizationName" id="frmBillingOrganizationName" value="<?php echo $objPage->arrCustomerDeatails[0]['BillingOrganizationName']; ?>"/>
                                        </li>
                                        <li>
                                            <label><?php echo ADD_1_ADDRESS; ?></label>
                                            <div class="input_star">
                                                <input type="text" name="frmBillingAddressLine1" tabindex="4" id="frmBillingAddressLine1" class="validate[required] text-01" value="<?php echo $objPage->arrCustomerDeatails[0]['BillingAddressLine1']; ?>" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo ADD_2_ADDRESS; ?> </label>
                                            <input type="text" class="text-01" name="frmBillingAddressLine2" tabindex="5" id="frmBillingAddressLine2" value="<?php echo $objPage->arrCustomerDeatails[0]['BillingAddressLine2']; ?>"/>
                                        </li>
                                        <li>
                                            <label><?php echo COUNTRY; ?></label>
                                            <div class="input_star">
                                                <div class="drop4  dropdown_2">
                                                    <div class="ErrorfrmBillingCountry"></div>
   <select class="drop_down2" tabindex="6" name="frmBillingCountry" id="frmBillingCountry">
                                                        <option value=""><?php echo SEL_CON; ?></option>
                                                        <?php
                                                        foreach ($objPage->arrCountryList as $vCT)
                                                        {
                                                            ?>
                                                            <option value="<?php echo $vCT['country_id']; ?>" <?php
                                                        if ($vCT['country_id'] == $objPage->arrCustomerDeatails[0]['BillingCountry'])
                                                        {
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
                                            <label><?php echo POSTAL_CODE_ZIP; ?></label>
                                            <div class="input_star">
                                                <input type="text" name="frmBillingPostalCode" id="frmBillingPostalCode" maxlength="8" class="validate[required,minSize[4],maxSize[8]] text-01" value="<?php echo $objPage->arrCustomerDeatails[0]['BillingPostalCode']; ?>" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo PHONE; ?></label>
                                            <div class="input_star">
                                                <input type="text" name="frmBillingPhone" id="frmBillingPhone" class="validate[required,custom[phone]] focus" value="<?php echo $objPage->arrCustomerDeatails[0]['BillingPhone']; ?>" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="radio_btn">
                                                <input type="radio" class="styled" value="Billing" name="frmBusinessAddress" <?php
                                                                if ($objPage->arrCustomerDeatails[0]['BusinessAddress'] == 'Billing')
                                                                {
                                                                    echo 'checked=checked';
                                                                }
                                                                ?> /><small><?php echo BUSINESS_ADD; ?></small></div>

                                        </li>

                                    </ul>
                                </div>

                                <div class="com_address_sec billing_sec right right1">
                                    <h3><?php echo SHIPPING_ADD; ?><small class="req_field" style="text-transform: capitalize">* <?php echo FILED_REQUIRED; ?> </small></h3>
                                    <ul class="left_sec">
                                        <?php
//pre($objPage->arrCustomerDeatails);
                                        ?>
                                        <li><div class="check_box" style="margin-top:20px;" onclick="billingShipping()" >
                                                <input type="checkbox" name="frmBillingSame" id="frmBillingSame" class="styled" <?php echo $objPage->arrCustomerDeatails[0]['SameShipping'] == 1 ? 'checked="checked"' : ''; ?> /> <small><?php echo SAME_BILLING_ADDRESS; ?></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label style="padding-top:12px" ><?php echo RECIPIENT_FIRST_NAME; ?></label>
                                            <div class="input_star">
                                                <input type="text" name="frmShippingFirstName" id="frmShippingFirstName" class="validate[required] focus" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingFirstName']; ?>"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo REC_LAST_NAME; ?></label>
                                            <input type="text" name="frmShippingLastName" id="frmShippingLastName" class="focus"  value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingLastName']; ?>" />
                                        </li>
                                        <li>
                                            <label><?php echo ORG_NAME; ?> </label>
                                            <input type="text" name="frmShippingOrganizationName" class="focus" id="frmShippingOrganizationName" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingOrganizationName']; ?>"/>
                                        </li>
                                        <li>
                                            <label><?php echo ADD_1_ADDRESS; ?></label>
                                            <div class="input_star">
                                                <input type="text" name="frmShippingAddressLine1" id="frmShippingAddressLine1" class="validate[required] focus" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingAddressLine1']; ?>"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo ADD_2_ADDRESS; ?> </label>
                                            <input type="text" name="frmShippingAddressLine2" class="focus" id="frmShippingAddressLine2" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingAddressLine2']; ?>"/>
                                        </li>
                                        <li>
                                            <label><?php echo COUNTRY; ?></label>
                                            <div class="input_star">
                                                <div class="drop4 dropdown_2" id="ship_country">
                                                    <div class="ErrorfrmShippingCountry"></div>
                                                    <select class="drop_down2" name="frmShippingCountry" id="frmShippingCountry">
                                                        <option value=""><?php echo SEL_CON; ?></option>
                                                        <?php
                                                        foreach ($objPage->arrCountryList as $vCT)
                                                        {
                                                            ?>
                                                            <option value="<?php echo $vCT['country_id']; ?>" <?php
                                                        if ($vCT['country_id'] == $objPage->arrCustomerDeatails[0]['ShippingCountry'])
                                                        {
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
                                            <label><?php echo POSTAL_CODE_ZIP; ?></label>
                                            <div class="input_star">
                                                <input type="text" name="frmShippingPostalCode" id="frmShippingPostalCode" maxlength="8" class="validate[required,minSize[4],maxSize[8]] focus" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingPostalCode']; ?>"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo PHONE; ?></label>
                                            <div class="input_star">
                                                <input type="text" name="frmShippingPhone" id="frmShippingPhone" class="validate[required,custom[phone]] focus" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingPhone']; ?>"/>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="radio_btn">
                                                <input type="radio" class="styled" value="Shipping" name="frmBusinessAddress" <?php
                                                                if ($objPage->arrCustomerDeatails[0]['BusinessAddress'] == 'Shipping')
                                                                {
                                                                    echo 'checked=checked';
                                                                }
                                                                ?> /><small><?php echo BUSINESS_ADD; ?></small></div>

                                        </li>
                                    </ul>
                                    <span class="btn" style="float:right; ">
                                        <input type="hidden" name="frmBillingShippingAddress" value="update" />
                                        <input type="submit" name="submit" value="Update Detail" class="submit3" style="width:100%; float:right"/>                                              
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