<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_BILLING_SHIPPING_CTRL;
//pre($objPage->arrCustomerDeatails[0]);
$address_count = 0;
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
                
                 $('#ShippingCountry').on('change', function () {
                    var countryid = this.value;
                     $('#ShippingCity1').val('');
                    $("#ShippingCity1").html('');
                   
                    // alert(countryid);
                     //$("#ShippingCity1").select2-me("val", "");
                    $.ajax({
                        type: "POST",
                        url: 'admin/ajax.php',
                        data: {action: 'showCountryState', q: countryid, },
                    }).done(function (data) {
                        console.log(data);
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
                
                $('#ShippingCountry2').on('change', function () {
                    var countryid = this.value;
                    // alert(countryid);
                    $.ajax({
                        type: "POST",
                        url: 'admin/ajax.php',
                        data: {action: 'showCountryState', q: countryid, },
                    }).done(function (data) {
                        console.log(data);
                        $("#ShippingState2").html(data);
                    });

                });

                $('#ShippingState2').on('change', function () {
                    var stateid = this.value;
                    // alert(countryid);
                    $.ajax({
                        type: "POST",
                        url: 'admin/ajax.php',
                        data: {action: 'showStateCity', q: stateid, },
                    }).done(function (data) {
                        $("#ShippingCity2").html(data);
                    });

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
            .customselect{
                background: #FFF;
                color: #3f3e3e;
                /* float: left; */
                height: 37px;
                moz-border-radius: 3px;
                padding: 0 25px 0 10px;
                width: 100%;border:1px solid #dcdcdc}
        </style>
        <script>
            function validateForm(){

                if ($("#ShippingCountry").val() == '' || $("#ShippingCountry").val() == '0'){
                    $('.ErrorfrmShippingCountry').html('<div style="opacity: 0.87; position: absolute; top: 180px; display: block; margin-top: -213px; left: 455px;" class="formError"><div class="formErrorContent">* <?php echo COUNTRY_REQ_MSG; ?><br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div><div>');
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
			<h3>Select a shipping address</h3>
			<?php
			
			$Cname = explode(',',$objPage->arrCustomerDeatails[0]['Cname']);
			//pre($objPage->arrCustomerDeatails[0]);
			if(!empty($objPage->arrCustomerDeatails[0]['ShippingCountry'])){
			    $address_count11 = 1;
			    ?>
                        <table class="shipping-table">
			    <form id="" action="" method="get" >
			    <tr><td><?php echo $objPage->arrCustomerDeatails[0]['ShippingFirstName']; ?> <?php echo $objPage->arrCustomerDeatails[0]['ShippingLastName']; ?></td></tr>
			    <tr><td><?php echo $objPage->arrCustomerDeatails[0]['ShippingAddressLine1']; ?> <?php echo $objPage->arrCustomerDeatails[0]['ShippingAddressLine2']; ?></td></tr>
			    <tr><td><?php echo $objPage->arrCustomerDeatails[0]['ShippingPostalCode']; ?></td></tr>
			    <tr><td>
			    <?php
			    
			    //pre($objPage->arrCustomerDeatails[0]['ShippingCountry']);
				    foreach ($objPage->arrCountryList as $k => $vCT)
				    {
					if($vCT['country_id'] == $objPage->arrCustomerDeatails[0]['ShippingCountry'] ){
					    echo $vCT['name']; 
					}
				    }
					?>
			    </td></tr>
			    <tr><td><?php 
                            $statearraybycountryid = $objGeneral->statelistbycountryid($objPage->arrCustomerDeatails[0]['ShippingCountry']);
                            foreach ($statearraybycountryid as $k => $vCT)
				    {
					if($vCT['id'] == $objPage->arrCustomerDeatails[0]['ShippingState'] ){
					    echo $vCT['name']; 
					}
				    }
                            ?></td></tr>
			    <tr><td><?php 
                             $cityarraybystateid = $objGeneral->countrylistbynewstateid($objPage->arrCustomerDeatails[0]['ShippingState']);
                            foreach ($cityarraybystateid as $k => $vCT)
				    {
					if($vCT['id'] == $objPage->arrCustomerDeatails[0]['ShippingCity'] ){
					    echo $vCT['name']; 
					}
				    }
                            ?></td></tr>
			    <tr><td><?php echo $objPage->arrCustomerDeatails[0]['ShippingPhone']; ?></td></tr>
			    <tr>
				<td>
					<input type="hidden" name="pkCustomerID" value="<?php echo $objPage->arrCustomerDeatails[0]['pkCustomerID']; ?>" />
					<input type="hidden" name="ShippingFirstName" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingFirstName']; ?>" >
					<input type="hidden" name="ShippingLastName" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingLastName']; ?>" >
					<input type="hidden" name="ShippingAddressLine1" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingAddressLine1']; ?>" >
					<input type="hidden" name="ShippingAddressLine2" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingAddressLine2']; ?>" >
					<input type="hidden" name="ShippingPostalCode" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingPostalCode']; ?>" >
					<input type="hidden" name="ShippingCountry" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingCountry']; ?>" >
					<input type="hidden" name="ShippingState" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingState']; ?>" >
					<input type="hidden" name="ShippingCity" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingCity']; ?>" >
					<input type="hidden" name="ShippingPhone" value="<?php echo $objPage->arrCustomerDeatails[0]['ShippingPhone']; ?>" >
					<input type="hidden" value="0" name="FormNo" />
					<a href="shipping_charge.php?RunShippingID=0" class="submit3">Deliver to this address</a>
                                        <input type="hidden" name="EditAdd" value="EditAddress" />
					<input type="submit" name="" value="Edit Address" class="submit3"/>
<!--                                        <a href="run_time_shipping_address.php?RunDeleteShippingID=0" class="submit3 half-width">Delete Address</a>-->
                    <!--<input type="submit" name="" value="Delete Address" class="submit3 half-width"/>-->
				</td></tr>
			    </form>
			</table>
			<?php } ?>
			<?php if(!empty($objPage->arrCustomerDeatails[0]['1_ShippingCountry'])){
			     $address_count11++;
			    ?>
			<table  class="shipping-table">
			    <form id="" action="" method="get" >
			    <tr><td><?php echo $objPage->arrCustomerDeatails[0]['1_ShippingFirstName']; ?> <?php echo $objPage->arrCustomerDeatails[0]['1_ShippingLastName']; ?></td></tr>
			    <tr><td><?php echo $objPage->arrCustomerDeatails[0]['1_ShippingAddressLine1']; ?>  <?php echo $objPage->arrCustomerDeatails[0]['1_ShippingAddressLine2']; ?></td></tr>
			    <tr><td><?php echo $objPage->arrCustomerDeatails[0]['1_ShippingPostalCode']; ?></td></tr>
			     <tr><td>
				<?php
			    
			    //pre($objPage->arrCustomerDeatails[0]['ShippingCountry']);
				    foreach ($objPage->arrCountryList as $k => $vCT)
				    {
					if($vCT['country_id'] == $objPage->arrCustomerDeatails[0]['1_ShippingCountry'] ){
					    echo $vCT['name']; 
					}
				    }
					?>
			     </td></tr>
                            <tr><td><?php 
                            $statearraybycountryid = $objGeneral->statelistbycountryid($objPage->arrCustomerDeatails[0]['1_ShippingCountry']);
                            foreach ($statearraybycountryid as $k => $vCT)
				    {
					if($vCT['id'] == $objPage->arrCustomerDeatails[0]['1_ShippingState'] ){
					    echo $vCT['name']; 
					}
				    }
                            ?></td></tr>
			    <tr><td><?php 
                             $cityarraybystateid = $objGeneral->countrylistbynewstateid($objPage->arrCustomerDeatails[0]['1_ShippingState']);
                            foreach ($cityarraybystateid as $k => $vCT)
				    {
					if($vCT['id'] == $objPage->arrCustomerDeatails[0]['1_ShippingCity'] ){
					    echo $vCT['name']; 
					}
				    }
                            ?></td></tr>
			    <tr><td><?php echo $objPage->arrCustomerDeatails[0]['1_ShippingPhone']; ?></td></tr>
			    <tr>
				<td>
					<input type="hidden" name="pkCustomerID" value="<?php echo $objPage->arrCustomerDeatails[0]['pkCustomerID']; ?>" />
					<input type="hidden" name="ShippingFirstName" value="<?php echo $objPage->arrCustomerDeatails[0]['1_ShippingFirstName']; ?>" >
					<input type="hidden" name="ShippingLastName" value="<?php echo $objPage->arrCustomerDeatails[0]['1_ShippingLastName']; ?>" >
					<input type="hidden" name="ShippingAddressLine1" value="<?php echo $objPage->arrCustomerDeatails[0]['1_ShippingAddressLine1']; ?>" >
					<input type="hidden" name="ShippingAddressLine2" value="<?php echo $objPage->arrCustomerDeatails[0]['1_ShippingAddressLine2']; ?>" >
					<input type="hidden" name="ShippingPostalCode" value="<?php echo $objPage->arrCustomerDeatails[0]['1_ShippingPostalCode']; ?>" >
					<input type="hidden" name="ShippingCountry" value="<?php echo $objPage->arrCustomerDeatails[0]['1_ShippingCountry']; ?>" >
					<input type="hidden" name="ShippingState" value="<?php echo $objPage->arrCustomerDeatails[0]['1_ShippingState']; ?>" >
					<input type="hidden" name="ShippingCity" value="<?php echo $objPage->arrCustomerDeatails[0]['1_ShippingCity']; ?>" >
					<input type="hidden" name="ShippingPhone" value="<?php echo $objPage->arrCustomerDeatails[0]['1_ShippingPhone']; ?>" >
					<input type="hidden" value="1" name="FormNo" >
					<a href="shipping_charge.php?RunShippingID=1" class="submit3">Deliver to this address</a>
					<input type="hidden" name="EditAdd" value="EditAddress" />
					<input type="submit" name="" value="Edit Address" class="submit3 half-width mar-0" />
                                        <a href="run_time_shipping_address.php?RunDeleteShippingID=1" class="submit3 half-width">Delete Address</a>
                    <!--<input type="submit" name="" value="delete Address" class="submit3 half-width" />-->
				</td>
			    </tr>
			    </form>
			</table>
			<?php }
			//pre($objPage->arrCustomerDeatails[0]['2_ShippingCountry']);
			?>
			<?php if(!empty($objPage->arrCustomerDeatails[0]['2_ShippingCountry'])){
			    $address_count11++;
			    ?>
			<table class="shipping-table">
			    <form id="" action="" method="get" >
				<tr><td><?php echo $objPage->arrCustomerDeatails[0]['2_ShippingFirstName']; ?> <?php echo $objPage->arrCustomerDeatails[0]['2_ShippingLastName']; ?></td></tr>
				<tr><td><?php echo $objPage->arrCustomerDeatails[0]['2_ShippingAddressLine1']; ?>  <?php echo $objPage->arrCustomerDeatails[0]['2_ShippingAddressLine2']; ?></td></tr>
				<tr><td><?php echo $objPage->arrCustomerDeatails[0]['2_ShippingPostalCode']; ?></td></tr>
				<tr><td>
				    <?php
			    
			    //pre($objPage->arrCustomerDeatails[0]['ShippingCountry']);
				    foreach ($objPage->arrCountryList as $k => $vCT)
				    {
					if($vCT['country_id'] == $objPage->arrCustomerDeatails[0]['2_ShippingCountry'] ){
					    echo $vCT['name']; 
					}
				    }
					?>
				</td></tr>
                                <tr><td><?php 
                            $statearraybycountryid = $objGeneral->statelistbycountryid($objPage->arrCustomerDeatails[0]['2_ShippingCountry']);
                            foreach ($statearraybycountryid as $k => $vCT)
				    {
					if($vCT['id'] == $objPage->arrCustomerDeatails[0]['2_ShippingState'] ){
					    echo $vCT['name']; 
					}
				    }
                            ?></td></tr>
			    <tr><td><?php 
                             $cityarraybystateid = $objGeneral->countrylistbynewstateid($objPage->arrCustomerDeatails[0]['2_ShippingState']);
                            foreach ($cityarraybystateid as $k => $vCT)
				    {
					if($vCT['id'] == $objPage->arrCustomerDeatails[0]['2_ShippingCity'] ){
					    echo $vCT['name']; 
					}
				    }
                            ?></td></tr>
				<tr><td><?php echo $objPage->arrCustomerDeatails[0]['2_ShippingPhone']; ?></td></tr>
				<tr>
				    <td>
					<input type="hidden" name="pkCustomerID" value="<?php echo $objPage->arrCustomerDeatails[0]['pkCustomerID']; ?>" />
					<input type="hidden" name="ShippingFirstName" value="<?php echo $objPage->arrCustomerDeatails[0]['2_ShippingFirstName']; ?>" >
					<input type="hidden" name="ShippingLastName" value="<?php echo $objPage->arrCustomerDeatails[0]['2_ShippingLastName']; ?>" >
					<input type="hidden" name="ShippingAddressLine1" value="<?php echo $objPage->arrCustomerDeatails[0]['2_ShippingAddressLine1']; ?>" >
					<input type="hidden" name="ShippingAddressLine2" value="<?php echo $objPage->arrCustomerDeatails[0]['2_ShippingAddressLine2']; ?>" >
					<input type="hidden" name="ShippingPostalCode" value="<?php echo $objPage->arrCustomerDeatails[0]['2_ShippingPostalCode']; ?>" >
					
					<input type="hidden" name="ShippingCountry" value="<?php echo $objPage->arrCustomerDeatails[0]['2_ShippingCountry']; ?>" >
					<input type="hidden" name="ShippingState" value="<?php echo $objPage->arrCustomerDeatails[0]['2_ShippingState']; ?>" >
					<input type="hidden" name="ShippingCity" value="<?php echo $objPage->arrCustomerDeatails[0]['2_ShippingCity']; ?>" >
					<input type="hidden" name="ShippingPhone" value="<?php echo $objPage->arrCustomerDeatails[0]['2_ShippingPhone']; ?>" >
					<input type="hidden" value="2" name="FormNo" >
					<a href="shipping_charge.php?RunShippingID=2" class="submit3" >Deliver to this address</a>
					<input type="hidden" name="EditAdd" value="EditAddress" />
					<input type="submit" name="" value="Edit Address" class="submit3 half-width mar-0" />
                                        <a href="run_time_shipping_address.php?RunDeleteShippingID=2" class="submit3 half-width">Delete Address</a>
                                        <!--<input type="submit" name="" value="delete Address" class="submit3 half-width" />-->
				    </td>
				</tr>
			    </form>
			</table>
			<?php } ?>

                    </div>
		    <?php
//		    pre($_REQUEST);
		    if(empty($objPage->arrCustomerDeatails[0]['ShippingCountry'])){
			$address_count = '';
		    }
		    else if(empty($objPage->arrCustomerDeatails[0]['1_ShippingCountry'])){
			$address_count = 1;
		    } else if(empty($objPage->arrCustomerDeatails[0]['2_ShippingCountry'])){
			$address_count = 2;
		    } 
		    if($address_count11 < 3 && !isset($_REQUEST['EditAdd'])){ ?>
                    <div class="body_inner_bg radius">
                        <div class="add_edit_pakage aapplication_form">
                            <form id="billingShippingAddress" action="" method="post" onsubmit="return validateForm();">
                                
                                <div class="com_address_sec billing_sec left right1">
                                    <h3>Add New <?php echo SHIPPING_ADD; ?><small class="req_field" style="text-transform: capitalize">* <?php echo FILED_REQUIRED; ?> </small></h3>
                                    <ul class="left_sec">
                                        <li>
                                            <label style="padding-top:12px" ><?php echo RECIPIENT_FIRST_NAME; ?></label>
                                            <div class="input_star">
                                                <input type="text" name="<?php echo $address_count.'_';?>ShippingFirstName" id="ShippingFirstName" class="validate[required] focus" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo REC_LAST_NAME; ?></label>
                                            <input type="text" name="<?php echo $address_count.'_';?>ShippingLastName" id="ShippingLastName" class="focus"   />
                                        </li>
                                        <li>
                                            <label><?php echo ORG_NAME; ?> </label>
                                            <input type="text" name="<?php echo $address_count.'_';?>ShippingOrganizationName" class="focus" id="ShippingOrganizationName" />
                                        </li>
                                        <li>
                                            <label><?php echo ADD_1_ADDRESS; ?></label>
                                            <div class="input_star">
                                                <input type="text" name="<?php echo $address_count.'_';?>ShippingAddressLine1" id="ShippingAddressLine1" class="validate[required] focus" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo ADD_2_ADDRESS; ?> </label>
                                            <input type="text" name="<?php echo $address_count.'_';?>ShippingAddressLine2" class="focus" id="ShippingAddressLine2" />
                                        </li>
                                        <li>
                                            <label><?php echo COUNTRY; ?></label>
                                            <div class="input_star">
                                                <div class="drop4 dropdown_2" id="ship_country">
                                                    <div class="ErrorfrmShippingCountry"></div>
                                                    <select class="drop_down2"  tabindex="6" name="<?php echo $address_count.'_';?>ShippingCountry" id="ShippingCountry2">
                                                        <option value=""><?php echo SEL_CON; ?></option>
                                                        <?php
                                                        foreach ($objPage->arrCountryList as $vCT)
                                                        {
                                                            ?>
                                                            <option value="<?php echo $vCT['country_id']; ?>" <?php
							    
                                                            ?>><?php echo $vCT['name']; ?></option>
                                                                <?php } ?>
                                                    </select> 
                                                </div>
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                           <label>State</label>
                                            <div class="input_star">
                                                <select name="<?php echo $address_count.'_';?>ShippingState" id="ShippingState2" class='select2-me input-large resCheck customselect'>
                                                    <option value="0">Select State</option>
                                                    
                                                </select> 
                                            </div> 
                                        </li>
                                        
                                        <li>
                                           <label>City</label>
                                            <div class="input_star">
                                                <select name="<?php echo $address_count.'_';?>ShippingCity" id="ShippingCity2" class='select2-me input-large resCheck customselect'>
                                                    <option value="0">Select City</option>
                                                    
                                                </select> 
                                            </div> 
                                        </li>
                                        <li>
                                            <label><?php echo POSTAL_CODE_ZIP; ?></label>
                                            <div class="input_star">
                                                <input type="text" name="<?php echo $address_count.'_';?>ShippingPostalCode" id="ShippingPostalCode" maxlength="8" class="validate[required,minSize[4],maxSize[8]] focus" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo PHONE; ?></label>
                                            <div class="input_star">
                                                <input type="text" name="<?php echo $address_count.'_';?>ShippingPhone" id="ShippingPhone" class="validate[required,custom[phone]] focus" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <!--<li>
                                            <div class="radio_btn">
                                                <input type="radio" class="styled" value="Shipping" name="frmBusinessAddress" <?php
                                                               /* if ($objPage->arrCustomerDeatails[0]['BusinessAddress'] == 'Shipping')
                                                                {
                                                                    echo 'checked=checked';
                                                                }
                                                                ?> /><small><?php echo BUSINESS_ADD; */?></small></div>

                                        </li> -->
                                    </ul>
                                    <span class="btn" style="float:right; ">
                                        <input type="hidden" name="runTimeShippingAddress" value="update_runtime" />
					<input type="hidden" name="pkCustomerID" value="<?php echo $objPage->arrCustomerDeatails[0]['pkCustomerID']; ?>" />
                                        <input type="submit" name="submit" value="Update Detail" class="submit3" style="width:100%; float:right"/>                                              
                                    </span>
                                </div>
                            </form> 
                        </div>

                    </div>
		    <?php
			}  
		    if($_REQUEST['EditAdd'] == 'EditAddress'){ ?>
                    <div class="body_inner_bg radius">
                        <div class="add_edit_pakage aapplication_form">
                            <form id="billingShippingAddress" action="" method="post" onsubmit="return validateForm();">
                                
                                <div class="com_address_sec billing_sec left right1">
                                    <h3>Edit <?php  echo SHIPPING_ADD; ?><small class="req_field" style="text-transform: capitalize">* <?php echo FILED_REQUIRED; ?> </small></h3>
                                    <ul class="left_sec">
                                        <?php
//pre($objPage->arrCustomerDeatails);
                                        ?>
                                        <!-- <li><div class="check_box" style="margin-top:20px;" onclick="billingShipping()" >
                                                <input type="checkbox" name="frmBillingSame" id="frmBillingSame" class="styled" <?php echo $objPage->arrCustomerDeatails[0]['SameShipping'] == 1 ? 'checked="checked"' : ''; ?> /> <small><?php echo SAME_BILLING_ADDRESS; ?></small>
                                            </div>
                                        </li> -->
                                        <li>
                                            <label style="padding-top:12px" ><?php echo RECIPIENT_FIRST_NAME; ?></label>
                                            <div class="input_star">
                                                <input type="text" name="ShippingFirstName" value="<?php echo $_REQUEST['ShippingFirstName']; ?>" id="ShippingFirstName" class="validate[required] focus" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo REC_LAST_NAME; ?></label>
                                            <input type="text" name="ShippingLastName"  value="<?php echo $_REQUEST['ShippingLastName']; ?>" id="ShippingLastName" class="focus"   />
                                        </li>
                                        <li>
                                            <label><?php echo ORG_NAME; ?> </label>
                                            <input type="text" name="ShippingOrganizationName"  value="<?php echo $_REQUEST['ShippingOrganizationName']; ?>" class="focus" id="ShippingOrganizationName" />
                                        </li>
                                        <li>
                                            <label><?php echo ADD_1_ADDRESS; ?></label>
                                            <div class="input_star">
                                                <input type="text" name="ShippingAddressLine1"   value="<?php echo $_REQUEST['ShippingAddressLine1']; ?>" id="ShippingAddressLine1" class="validate[required] focus" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo ADD_2_ADDRESS; ?> </label>
                                            <input type="text" name="ShippingAddressLine2" value="<?php echo $_REQUEST['ShippingAddressLine2']; ?>" class="focus" id="ShippingAddressLine2" />
                                        </li>
                                        <li>
                                            <label><?php echo COUNTRY; ?></label>
                                            <div class="input_star">
                                                <div class="drop4 dropdown_2" id="ship_country">
                                                    <div class="ErrorfrmShippingCountry"></div>
                                                    <select class="drop_down2" name="ShippingCountry" id="ShippingCountry">
                                                        <option value=""><?php echo SEL_CON; ?></option>
                                                        <?php
                                                        foreach ($objPage->arrCountryList as $vCT)
                                                        {
                                                            ?>
                                                            <option value="<?php echo $vCT['country_id']; ?>" <?php
							    if ($vCT['country_id'] == $_REQUEST['ShippingCountry'])
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
                                           <label>State</label>
                                            <div class="input_star">
                                                <select name="ShippingState" id="ShippingState1" class='select2-me input-large resCheck customselect'>
                                                    <option value="0">Select State</option>
                                                    <?php
                                                                                 $statearraybycountryid = $objGeneral->statelistbycountryid($_REQUEST['ShippingCountry']);
                                                                                                foreach ($statearraybycountryid as $vv) {
                                                                                                    //in_array($gatway,)
                                                                                                    
                                                                                                    if ($_REQUEST['ShippingState'] == $vv['id'])
                                                                                                        echo '<option selected value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    else {
                                                                                                        echo '<option value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    }
                                                                                                }
                                                                                                ?>
                                                </select> 
                                            </div> 
                                        </li>
                                        
                                        <li>
                                           <label>City</label>
                                            <div class="input_star">
                                                <select name="ShippingCity" id="ShippingCity1" class='select2-me input-large resCheck customselect'>
                                                    <option value="0">Select City</option>
                                                    <?php
                                                                                  $cityarraybystateid = $objGeneral->countrylistbynewstateid($_REQUEST['ShippingState']);               
                                                                                                foreach ($cityarraybystateid as $vv) {

                                                                                                    //in_array($gatway,)
                                                                                                    if ($_REQUEST['ShippingCity'] == $vv['id']) {
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
                                            <label><?php echo POSTAL_CODE_ZIP; ?></label>
                                            <div class="input_star">
                                                <input type="text" name="ShippingPostalCode" value="<?php echo $_REQUEST['ShippingPostalCode']; ?>" id="ShippingPostalCode" maxlength="8" class="validate[required,minSize[4],maxSize[8]] focus" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <li>
                                            <label><?php echo PHONE; ?></label>
                                            <div class="input_star">
                                                <input type="text" name="ShippingPhone" value="<?php echo $_REQUEST['ShippingPhone']; ?>" id="ShippingPhone" class="validate[required,custom[phone]] focus" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                        <!--<li>
                                            <div class="radio_btn">
                                                <input type="radio" class="styled" value="Shipping" name="frmBusinessAddress" <?php
                                                               /* if ($objPage->arrCustomerDeatails[0]['BusinessAddress'] == 'Shipping')
                                                                {
                                                                    echo 'checked=checked';
                                                                }
                                                                ?> /><small><?php echo BUSINESS_ADD; */?></small></div>

                                        </li> -->
                                    </ul>
                                    <span class="btn" style="float:right; ">
                                        <input type="hidden" name="FormNo" value="<?php echo $_REQUEST['FormNo']; ?>" />
					<input type="hidden" name="pkCustomerID" value="<?php echo $objPage->arrCustomerDeatails[0]['pkCustomerID']; ?>" />
					<input type="hidden" name="EditDetailRunTime" value="EditDetailRunTime" />
                                        <input type="submit" name="" value="Submit" class="submit3" style="width:100%; float:right"/>                                              
                                    </span>
                                </div>
                            </form> 
                        </div>

                    </div>
		    <?php  } ?>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html> 