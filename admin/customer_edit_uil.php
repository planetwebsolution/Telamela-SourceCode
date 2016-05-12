<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_CUSTOMER_CTRL;
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <!-- Apple devices fullscreen -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Apple devices fullscreen -->
        <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Customer </title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script src="<?php echo ADMIN_JS_PATH; ?>plugins/jquery-ui/jquery.ui.sortable.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <script type="text/javascript">
            function billingShipping(){
                if($("#frmBillingSame").is(':checked')){
                    $("#ShippingFirstName").val($('#BillingFirstName').val());
                    $("#ShippingLastName").val($('#BillingLastName').val());
                    $("#ShippingOrganizationName").val($('#BillingOrganizationName').val());
                    $("#ShippingAddressLine1").val($('#BillingAddressLine1').val());
                    $("#ShippingAddressLine2").val($('#BillingAddressLine2').val());
                    $("#ShippingCountry").val($('#BillingCountry').val());
                    $("#ShippingCountry").select2();
                    $("#ShippingPostalCode").val($('#BillingPostalCode').val());
                    $("#ShippingPhone").val($('#BillingPhone').val());
                    $("#frmShippingTown").val($('#frmBillingTown').val());                  
                }else{
                    $("#ShippingFirstName").val('');
                    $("#ShippingLastName").val('');
                    $("#ShippingOrganizationName").val('');
                    $("#ShippingAddressLine1").val('');
                    $("#ShippingAddressLine2").val('');
                    $("#ShippingCountry").val('');
                    $("#ShippingCountry").select2();
                    $("#ShippingPostalCode").val('');
                    $("#ShippingPhone").val('');
                    $("#frmShippingTown").val('');
                }
            }
            function resBilling(){
                if($("#frmResSame").is(':checked')){
                    $("#BillingAddressLine1").val($('#frmResAddressLine1').val());
                    $("#BillingAddressLine2").val($('#frmResAddressLine2').val());
                    $("#BillingCountry").val($('#frmResCountry1').val());
                    $("#BillingCountry").select2();
                    $("#BillingPostalCode").val($('#ResPostalCode').val());
                    $("#frmBillingTown").val($('#frmResTown').val());                   
                    $("#BillingPhone").val($('#frmResPhone').val());
                 
                }else{
                    $("#BillingAddressLine1").val('');
                    $("#BillingAddressLine2").val('');                   
                    $("#BillingCountry").val('');
                    $("#BillingCountry").select2();
                    $("#BillingPostalCode").val('');
                    $("#frmBillingTown").val('');
                    $("#BillingPhone").val('');
                }
            }
            $(document).ready(function(){            
                $('.resCheck').on('keypress change', function() {
                    if($("#frmResSame").is(':checked')){$('#frmResSame').attr('checked', false);}
                    if($("#frmBillingSame").is(':checked')){$('#frmBillingSame').attr('checked', false);}
                });
                $('.shipCheck').on('keypress change', function() {
                    if($("#frmBillingSame").is(':checked')){$('#frmBillingSame').attr('checked', false);}
                });
                
                 $('#frmResCountry1').on('change', function () {
                    var countryid = this.value;
                    // alert(countryid);
                    $.ajax({
                        type: "POST",
                        url: 'ajax.php',
                        data: {action: 'showCountryState', q: countryid, },
                    }).done(function (data) {
                        $("#frmResState1").html(data);
                    });

                });

                $('#frmResState1').on('change', function () {
                    var stateid = this.value;
                    // alert(countryid);
                    $.ajax({
                        type: "POST",
                        url: 'ajax.php',
                        data: {action: 'showStateCity', q: stateid, },
                    }).done(function (data) {
                        $("#frmResCity1").html(data);
                    });

                });

                 $('#BillingCountry').on('change', function () {
                    var countryid = this.value;
                    // alert(countryid);
                    $.ajax({
                        type: "POST",
                        url: 'ajax.php',
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
                        url: 'ajax.php',
                        data: {action: 'showStateCity', q: stateid, },
                    }).done(function (data) {
                        $("#BillingCity1").html(data);
                    });

                });
                
                 $('#ShippingCountry').on('change', function () {
                    var countryid = this.value;
                    // alert(countryid);
                    $.ajax({
                        type: "POST",
                        url: 'ajax.php',
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
                        url: 'ajax.php',
                        data: {action: 'showStateCity', q: stateid, },
                    }).done(function (data) {
                        $("#ShippingCity1").html(data);
                    });

                });
            });
        </script>  
    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>
        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Add Customer</h1>
                        </div>
                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><a href="customer_manage_uil.php">Customer</a><i class="icon-angle-right"></i></li>
<!--                            <li><a href="customer_edit_uil.php?id=<?php echo $_GET['id']; ?>&type=<?php echo $_GET['type']; ?>">Edit Customer</a></li>-->
                            <li><span>Edit Customer</span></li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            
                            <div class="tab-content padding tab-content-inline tab-content-bottom">
                                <div class="tab-pane active" id="tabs-2">
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <?php
                                            if ($objCore->displaySessMsg())
                                            {
                                                ?>

                                                <?php
                                                echo $objCore->displaySessMsg();
                                                $objCore->setSuccessMsg('');
                                                $objCore->setErrorMsg('');
                                                ?>

                                                <?php
                                                
                                            }
                                            ?>
                                            <div class="box box-color box-bordered">
                                                <div class="box-title">
                                                    <a id="buttonDecoration" href="<?php echo SITE_ROOT_URL; ?>admin/customer_manage_uil.php" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                                    <h3>
                                                        Personal Details
                                                    </h3>
                                                </div>

                                                <div class="box-content nopadding">
                                                    <?php require_once('javascript_disable_message.php'); ?>
                                                    <?php
                                                    if ($_SESSION['sessUserType'] == 'super-admin' || in_array('edit-customers', $_SESSION['sessAdminPerMission']))
                                                    {
                                                       
                                                        ?>
                                                        <form action=""  method="post" id="frm_page" onsubmit="return validateCustomerAddForm(this);" >
                                                            <div class="row-fluid">
                                                                <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*First Name:  </label>
                                                                        <div class="controls">

                                                                            <input name="CustomerFirstName" id="CustomerFirstName"  placeholder=""  type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['CustomerFirstName']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Last Name:  </label>
                                                                        <div class="controls">

                                                                            <input name="CustomerLastName" id="CustomerLastName"  placeholder=""  type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['CustomerLastName']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Email:  </label>
                                                                        <div class="controls">
                                                                            <input name="frmEmail" id="frmEmail"  onkeyup="checkCustomerEmail('<?php echo $objPage->arrRow[0]['pkCustomerID']; ?>');" onchange="checkCustomerEmail('<?php echo $objPage->arrRow[0]['pkCustomerID']; ?>');"  placeholder=""  type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['CustomerEmail']; ?>" />
                                                                            <input type="hidden" name="frmCEmail" id="frmCEmail" value="0" /> <span id="CustomerEmail" class="help-block"></span>
                                                                            <input name="frmOldEmail" id="frmOldEmail" type="hidden" value="<?php echo $objPage->arrRow[0]['CustomerEmail']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Confirm Email:  </label>
                                                                        <div class="controls">

                                                                            <input name="frmConfirmEmail" id="frmConfirmEmail"  placeholder=""  type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['CustomerEmail']; ?>" />
                                                                            <input type="hidden" name="frmStatus" id="frmStatus" value="<?php
                                                    if ($objPage->arrRow[0]['CustomerStatus'] == "Active")
                                                    {
                                                        echo "Active";
                                                    }
                                                    else
                                                    {
                                                        echo "Deactive";
                                                    }
                                                        ?>">

                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Password:  </label>
                                                                        <div class="controls">
                                                                            <input name="frmPassword" id="frmPassword" type="password" class="input-large" value="<?php echo ADMIN_XXX; ?>" />
                                                                            <input name="frmOldPassword" id="frmOldPassword" type="hidden" value="<?php echo $objPage->arrRow[0]['CustomerPassword']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Confirm Password:  </label>
                                                                        <div class="controls">
                                                                            <input name="frmConfirmPassword" id="frmConfirmPassword" type="password" class="input-large" value="<?php echo ADMIN_XXX; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="box-title nomargin"><h3> Residential Address</h3></div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Address Line 1:  </label>
                                                                        <div class="controls">

                                                                            <input name="frmResAddressLine1" id="frmResAddressLine1"  placeholder=""  type="text" class="input-large resCheck" value="<?php echo $objPage->arrRow[0]['ResAddressLine1'] ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Address Line 2:  </label>
                                                                        <div class="controls">

                                                                            <input name="frmResAddressLine2" id="frmResAddressLine2"  placeholder=""  type="text" class="input-large resCheck" value="<?php echo $objPage->arrRow[0]['ResAddressLine2'] ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Country:  </label>
                                                                        <div class="controls">
                                                                            <select name="frmResCountry" id="frmResCountry1" class='select2-me input-large resCheck'>
                                                                                <option value="0">Select</option>
                                                                                <?php
                                                                                
                                                                                foreach ($objPage->arrCountryList as $vCT)
                                                                                {
                                                                                    ?>
                                                                                    <option value="<?php echo $vCT['country_id']; ?>" <?php
                                                                            if ($vCT['country_id'] == $objPage->arrRow[0]['ResCountry'])
                                                                            {
                                                                                echo 'selected="selected"';
                                                                            }
                                                                                    ?>><?php echo $vCT['name']; ?></option>
                                                                                        <?php
                                                                                        }
                                                                                       
                                                                                     
                                                                                        ?>
                                                                            </select>
                                                                        </div>
                                                                    </div> 
                                                                     <div class="control-group">
                                                                        <label for="textfield" class="control-label">State:  </label>
                                                                        <div class="controls">
                                                                            <select name="frmResState" id="frmResState1" class='select2-me input-large resCheck'>
                                                                                <option value="0">Select State</option>
                                                                                <?php
                                                                                 $statearraybycountryid = $objGeneral->statelistbycountryid($objPage->arrRow[0]['ResCountry']);
                                                                                                foreach ($statearraybycountryid as $vv) {
                                                                                                    //in_array($gatway,)
                                                                                                    
                                                                                                    if ($objPage->arrRow[0]['ResState'] == $vv['id'])
                                                                                                        echo '<option selected value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    else {
                                                                                                        echo '<option value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    }
                                                                                                }
                                                                                                ?>
                                                                            </select> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">City:  </label>
                                                                        <div class="controls">
                                                                            <select name="frmResCity" id="frmResCity1" class='select2-me input-large resCheck'>
                                                                                <option value="0">Select City</option>
                                                                                <?php
                                                                                  $cityarraybystateid = $objGeneral->countrylistbynewstateid($objPage->arrRow[0]['ResState']);               
                                                                                                foreach ($cityarraybystateid as $vv) {

                                                                                                    //in_array($gatway,)
                                                                                                    if ($objPage->arrRow[0]['ResCity'] == $vv['id']) {
                                                                                                        $frmDistanceEnable = true;
                                                                                                        echo '<option selected value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    } else {
                                                                                                        echo '<option value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    }
                                                                                                }
                                                                                                
                                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Post Code or Zip Code: </label>
                                                                        <div class="controls">

                                                                            <input name="ResPostalCode" id="ResPostalCode"  placeholder=""  type="text" class="input-large resCheck" value="<?php echo $objPage->arrRow[0]['ResPostalCode']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Suburb/Town:  </label>
                                                                        <div class="controls">

                                                                            <input name="frmResTown" id="frmResTown"  placeholder=""  type="text" class="input-large resCheck" value="<?php echo $objPage->arrRow[0]['ResTown']; ?>" />
                                                                        </div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Phone:  </label>
                                                                        <div class="controls">

                                                                            <input name="frmResPhone" id="frmResPhone"  placeholder=""  type="text" class="input-large resCheck" value="<?php echo $objPage->arrRow[0]['ResPhone']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="box-title nomargin">
                                                                        <h3 style="width: 100%"> Billing Address</h3>
                                                                        <div class="check_box" onclick="resBilling()" >
                                                                            <input type="checkbox" <?php echo ($objPage->arrRow[0]['SameShipping']) ? "checked" : ''; ?> name="frmResSame" id="frmResSame" class="styled" />
                                                                            <span><?php echo SAME_RES_ADDRESS; ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Recipient First Name:  </label>
                                                                        <div class="controls">

                                                                            <input name="BillingFirstName" id="BillingFirstName"  placeholder=""  type="text" class="input-large resCheck" value="<?php echo $objPage->arrRow[0]['BillingFirstName']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Recipient Last Name: </label>
                                                                        <div class="controls">
                                                                            <input name="BillingLastName" id="BillingLastName"  placeholder=""  type="text" class="input-large resCheck" value="<?php echo $objPage->arrRow[0]['BillingLastName']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Organization Name:  </label>
                                                                        <div class="controls">

                                                                            <input name="BillingOrganizationName" id="BillingOrganizationName"  placeholder=""  type="text" class="input-large resCheck" value="<?php echo $objPage->arrRow[0]['BillingOrganizationName']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Address Line 1:  </label>
                                                                        <div class="controls">

                                                                            <input name="BillingAddressLine1" id="BillingAddressLine1"  placeholder=""  type="text" class="input-large resCheck" value="<?php echo $objPage->arrRow[0]['BillingAddressLine1'] ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Address Line 2:  </label>
                                                                        <div class="controls">

                                                                            <input name="BillingAddressLine2" id="BillingAddressLine2"  placeholder=""  type="text" class="input-large resCheck" value="<?php echo $objPage->arrRow[0]['BillingAddressLine2'] ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Country:  </label>
                                                                        <div class="controls">
                                                                            <select name="BillingCountry" id="BillingCountry" class='select2-me input-large resCheck'>
                                                                                <option value="0">Select</option>
                                                                                <?php
                                                                                foreach ($objPage->arrCountryList as $vCT)
                                                                                {
                                                                                    ?>
                                                                                    <option value="<?php echo $vCT['country_id']; ?>" <?php
                                                                            if ($vCT['country_id'] == $objPage->arrRow[0]['BillingCountry'])
                                                                            {
                                                                                echo 'selected="selected"';
                                                                            }
                                                                                    ?>><?php echo $vCT['name']; ?></option>
                                                                                        <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div> 
                                                                     <div class="control-group">
                                                                        <label for="textfield" class="control-label">State:  </label>
                                                                        <div class="controls">
                                                                            <select name="BillingState" id="BillingState1" class='select2-me input-large resCheck'>
                                                                                <option value="0">Select State</option>
                                                                                <?php
                                                                                 $statearraybycountryid = $objGeneral->statelistbycountryid($objPage->arrRow[0]['BillingCountry']);
                                                                                                foreach ($statearraybycountryid as $vv) {
                                                                                                    //in_array($gatway,)
                                                                                                    
                                                                                                    if ($objPage->arrRow[0]['BillingState'] == $vv['id'])
                                                                                                        echo '<option selected value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    else {
                                                                                                        echo '<option value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    }
                                                                                                }
                                                                                                ?>
                                                                            </select> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">City:  </label>
                                                                        <div class="controls">
                                                                            <select name="BillingCity" id="BillingCity1" class='select2-me input-large resCheck'>
                                                                                <option value="0">Select City</option>
                                                                                <?php
                                                                                  $cityarraybystateid = $objGeneral->countrylistbynewstateid($objPage->arrRow[0]['BillingState']);               
                                                                                                foreach ($cityarraybystateid as $vv) {

                                                                                                    //in_array($gatway,)
                                                                                                    if ($objPage->arrRow[0]['BillingCity'] == $vv['id']) {
                                                                                                        $frmDistanceEnable = true;
                                                                                                        echo '<option selected value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    } else {
                                                                                                        echo '<option value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    }
                                                                                                }
                                                                                                
                                                                                                ?>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Post Code or Zip Code: </label>
                                                                        <div class="controls">

                                                                            <input name="BillingPostalCode" id="BillingPostalCode"  placeholder=""  type="text" class="input-large resCheck" value="<?php echo $objPage->arrRow[0]['BillingPostalCode']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Suburb/Town:  </label>
                                                                        <div class="controls">

                                                                            <input name="frmBillingTown" id="frmBillingTown"  placeholder=""  type="text" class="input-large resCheck" value="<?php echo $objPage->arrRow[0]['BillingTown']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Phone:  </label>
                                                                        <div class="controls">

                                                                            <input name="BillingPhone" id="BillingPhone"  placeholder=""  type="text" class="input-large resCheck" value="<?php echo $objPage->arrRow[0]['BillingPhone']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <div class="controls">
                                                                            <?php
                                                                            if ($objPage->arrRow[0]['BusinessAddress'] == "Billing")
                                                                            {
                                                                                $getBusAdd1 = 'checked="checked"';
                                                                            }
                                                                            ?>
                                                                            <input type="checkbox" name="BillingBsinessAddress" value="1" id="BillingBsinessAddress" <?php echo $getBusAdd1; ?> onclick="if(this.checked){document.getElementById('ShippingBsinessAddress').checked = false;}"> &nbsp; This is a Business Address
                                                                        </div>
                                                                    </div>
                                                                    <div class="box-title nomargin">
                                                                        <h3 style="width: 100%">Shipping Address</h3>
                                                                        <div class="check_box" onclick="billingShipping()" >
                                                                            <input type="checkbox" <?php echo ($objPage->arrRow[0]['SameBillAsShip'] == 1) ? 'checked' : ''; ?> name="frmBillingSame" id="frmBillingSame" class="styled" />
                                                                            <span><?php echo SAME_BILLING_ADDRESS; ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Recipient First Name:  </label>
                                                                        <div class="controls">
                                                                            <input name="ShippingFirstName" id="ShippingFirstName"  placeholder=""  type="text" class="input-large shipCheck" value="<?php echo $objPage->arrRow[0]['ShippingFirstName']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Recipient Last Name: </label>
                                                                        <div class="controls">
                                                                            <input name="ShippingLastName" id="ShippingLastName"  placeholder=""  type="text" class="input-large shipCheck" value="<?php echo $objPage->arrRow[0]['ShippingLastName']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Organization Name:  </label>
                                                                        <div class="controls">

                                                                            <input name="ShippingOrganizationName" id="ShippingOrganizationName"  placeholder=""  type="text" class="input-large shipCheck" value="<?php echo $objPage->arrRow[0]['ShippingOrganizationName']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Address Line 1:  </label>
                                                                        <div class="controls">

                                                                            <input name="ShippingAddressLine1" id="ShippingAddressLine1"  placeholder=""  type="text" class="input-large shipCheck" value="<?php echo $objPage->arrRow[0]['ShippingAddressLine1']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Address Line 2:  </label>
                                                                        <div class="controls">

                                                                            <input name="ShippingAddressLine2" id="ShippingAddressLine2"  placeholder=""  type="text" class="input-large shipCheck" value="<?php echo $objPage->arrRow[0]['ShippingAddressLine2']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Country:  </label>
                                                                        <div class="controls">
                                                                            <select name="ShippingCountry" id="ShippingCountry" class='select2-me input-large shipCheck'>
                                                                                <option value="0">Select</option>
                                                                                <?php
                                                                                foreach ($objPage->arrCountryList as $vCT)
                                                                                {
                                                                                    ?>
                                                                                    <option value="<?php echo $vCT['country_id']; ?>" <?php
                                                                            if ($vCT['country_id'] == $objPage->arrRow[0]['ShippingCountry'])
                                                                            {
                                                                                echo 'selected="selected"';
                                                                            }
                                                                                    ?>><?php echo $vCT['name']; ?></option>
                                                                                        <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">State:  </label>
                                                                        <div class="controls">
                                                                            <select name="ShippingState" id="ShippingState1" class='select2-me input-large resCheck'>
                                                                                <option value="0">Select State</option>
                                                                                <?php
                                                                                 $statearraybycountryid = $objGeneral->statelistbycountryid($objPage->arrRow[0]['ShippingCountry']);
                                                                                                foreach ($statearraybycountryid as $vv) {
                                                                                                    //in_array($gatway,)
                                                                                                    
                                                                                                    if ($objPage->arrRow[0]['ShippingState'] == $vv['id'])
                                                                                                        echo '<option selected value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    else {
                                                                                                        echo '<option value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    }
                                                                                                }
                                                                                                ?>
                                                                            </select> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">City:  </label>
                                                                        <div class="controls">
                                                                            <select name="ShippingCity" id="ShippingCity1" class='select2-me input-large resCheck'>
                                                                                <option value="0">Select City</option> 
                                                                                <?php
                                                                                  $cityarraybystateid = $objGeneral->countrylistbynewstateid($objPage->arrRow[0]['ShippingState']);               
                                                                                                foreach ($cityarraybystateid as $vv) {

                                                                                                    //in_array($gatway,)
                                                                                                    if ($objPage->arrRow[0]['ShippingCity'] == $vv['id']) {
                                                                                                        $frmDistanceEnable = true;
                                                                                                        echo '<option selected value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    } else {
                                                                                                        echo '<option value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    }
                                                                                                }
                                                                                                
                                                                                                ?>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Post Code or Zip Code: </label>
                                                                        <div class="controls">

                                                                            <input name="ShippingPostalCode" id="ShippingPostalCode"  placeholder=""  type="text" class="input-large shipCheck" value="<?php echo $objPage->arrRow[0]['ShippingPostalCode']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Suburb/Town:  </label>
                                                                        <div class="controls">

                                                                            <input name="frmShippingTown" id="frmShippingTown"  placeholder=""  type="text" class="input-large shipCheck" value="<?php echo $objPage->arrRow[0]['ShippingTown']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Phone:  </label>
                                                                        <div class="controls">

                                                                            <input name="ShippingPhone" id="ShippingPhone"  placeholder=""  type="text" class="input-large shipCheck" value="<?php echo $objPage->arrRow[0]['ShippingPhone']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <div class="controls">
                                                                            <?php
                                                                            if ($objPage->arrRow[0]['BusinessAddress'] == "Shipping")
                                                                            {
                                                                                $getBusAdd = 'checked="checked"';
                                                                            }
                                                                            ?>
                                                                            <input type="checkbox" name="ShippingBsinessAddress" id="ShippingBsinessAddress" value="1" <?php echo $getBusAdd; ?> onclick="if(this.checked){document.getElementById('BillingBsinessAddress').checked = false;}"> &nbsp; This is a Business Address
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-actions">
                                                                        <button type="submit" class="btn btn-blue"><?php echo ADMIN_SUBMIT_BUTTON; ?></button>
                                                                        <a id="buttonDecoration" href="customer_manage_uil.php"><button type="button" class="btn"><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button></a>
                                                                        <input type="hidden" name="frmHidenEdit" id="frmHidnAddPage" value="edit" />
                                                                        <input type="hidden" name="id" value="<?php echo $objPage->arrRow[0]['pkCustomerID']; ?>" />
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>


                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
                else
                {
                    ?>
                    <table width="100%">
                        <tr>
                            <th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th></tr>
                        <tr><td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td></tr>
                    </table>

                <?php }
                ?>


            </div>
        </div>

        <?php require_once('inc/footer.inc.php'); ?>
    </div>

</body>
</html>
