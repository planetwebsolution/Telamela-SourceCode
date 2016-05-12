<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_PRODUCT_CTRL;
require_once CLASSES_ADMIN_PATH . 'class_adminuser_bll.php';
//pre($_SESSION['sessAdminCountry']);
$arrCurrencyList = $objCore->currencyList();

$objUser = new AdminUser();
$arrPortal = $objUser->getPortal();

foreach ($arrPortal as $k => $v) {
    $PortalIDs[] = $v['AdminCountry'];
}
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Product Add</title>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>

        <script type="text/javascript">
            Cal = jQuery.noConflict();
            Cal(document).ready(function () {
                var dd = '';

                //Cal('#frmDateEnd').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" style=" margin:-1px 0 0 -25px"  class="trigger">'});
                Cal('#frmDateStart').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif"  alt="Popup" style=" margin: -1px 0 0 -31px;" class="trigger">', minDate: '<?php echo date('d-m-Y') ?>', onSelect: function (selectedDate) {
                        dd = Cal(this).val();
                        //Cal('#frmDateEnd').datepick("destroy");
                        Cal('#frmDateEnd').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" style=" margin:-1px 0 0 -25px"  class="trigger">', minDate: dd});
                    }
                });
                // ShowWholesaler();
            });
        </script>
        <?php require_once 'inc/common_css_js.inc.php'; ?>

        <?php require_once 'inc/img_crop_js_css.inc.php'; ?>

        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <script type="text/javascript" src="js/product_admin.js"></script>

        <link rel="stylesheet" href="css/colorbox.css" />
        <script src="../colorbox/jquery.colorbox.js"></script>
        <script type="text/javascript">
            /*
             var url = window.URL || window.webkitURL;
             //var prod_img = document.getElementsByClassName("prod_img");
             Cal(document).ready(function(){
             Cal('.prod_img').live('change',function(){
             var dd = Cal(this);
             var name = dd.attr('name');
             if( this.disabled ){
             alert('Your browser does not support File upload.');
             }else{
             var chosen = this.files[0];
             var image = new Image();
             image.onload = function() {
             if(name=='frmProductSliderImg' && (this.width < MIN_PRODUCT_SLIDER_IMAGE_WIDTH || this.height < MIN_PRODUCT_IMAGE_HEIGHT || this.width >MAX_PRODUCT_IMAGE_WIDTH || this.height > MAX_PRODUCT_IMAGE_HEIGHT || this.size > MAX_PRODUCT_IMAGE_SIZE) ){
             alert('Please upload image in between ('+MIN_PRODUCT_SLIDER_IMAGE_WIDTH+'-'+MAX_PRODUCT_IMAGE_WIDTH+')px width and ('+MIN_PRODUCT_IMAGE_HEIGHT+'-'+MAX_PRODUCT_IMAGE_HEIGHT+')px height!');
             dd.parent().find('.image_error').val('0');
             this.focus();
             
             } else if (name=='frmProductDefaultImg' && (this.width < MIN_PRODUCT_IMAGE_WIDTH || this.height < MIN_PRODUCT_IMAGE_HEIGHT || this.width >MAX_PRODUCT_IMAGE_WIDTH || this.height > MAX_PRODUCT_IMAGE_HEIGHT || this.size > MAX_PRODUCT_IMAGE_SIZE)){
             alert('Please upload image in between ('+MIN_PRODUCT_IMAGE_WIDTH+'-'+MAX_PRODUCT_IMAGE_WIDTH+')px width and ('+MIN_PRODUCT_IMAGE_HEIGHT+'-'+MAX_PRODUCT_IMAGE_HEIGHT+')px height!');
             dd.parent().find('.image_error').val('0');
             this.focus();
             //$('#image_error').val(parseInt($('#image_error').val())+1);
             //return false;
             }else if (name.substr(0,13)=='frmProductImg' && (this.width < MIN_PRODUCT_IMAGE_WIDTH || this.height < MIN_PRODUCT_DETAIL_IMAGE_HEIGHT || this.width >MAX_PRODUCT_IMAGE_WIDTH || this.height > MAX_PRODUCT_IMAGE_HEIGHT || this.size > MAX_PRODUCT_IMAGE_SIZE)){
             alert('Please upload image in between ('+MIN_PRODUCT_IMAGE_WIDTH+'-'+MAX_PRODUCT_IMAGE_WIDTH+')px width and ('+MIN_PRODUCT_DETAIL_IMAGE_HEIGHT+'-'+MAX_PRODUCT_IMAGE_HEIGHT+')px height!');
             dd.parent().find('.image_error').val('0');
             this.focus();
             //$('#image_error').val(parseInt($('#image_error').val())+1);
             //return false;
             }
             else
             {
             dd.parent().find('.image_error').val('1');
             }
             };
             image.onerror = function() {
             alert('Not a valid file type: '+ chosen.type);
             dd.parent().find('.image_error').val('0');
             };
             image.src = url.createObjectURL(chosen);
             }
             
             });
             });*/

            $(document).on('change', '.FetchFromDb', function () {
                var opnid = $(this).val();
                if ($(this).is(":checked")) {
                    var chkSrcPath = $('#existing_product_img_' + opnid).attr('src');
                    //if (!chkSrcPath) {

                    var imgHdnId = $('#frmAttributeDefaultImg_' + opnid).val();
                    var path = $('#frmAttributeDefaultImg_' + opnid).attr('path');
                    if (imgHdnId) {
                        $('#AttIconDefault_' + opnid).append('<img id="dyn_img_' + opnid + '" width="25" height="25" src="' + path + '/' + imgHdnId + '">');
                    }
                    /*$.post("ajax.php", {
                     action: "UpdateAttIcon",
                     opnId: $(this).val(),
                     }, function (e) {
                     //alert(opnid);
                     $('#AttIconDefault_'+opnid).append('<img src="'+e+'">');
                     //alert(e);
                     })*/
                    //}
                } else {
                    $('#dyn_img_' + opnid).remove();
                }
            });

            $(document).on('change', "#mulcountry", function ()
            {
                if ($(this).is(':checked')) {
                    $('#mul_countriesID').removeClass('mulcountries');
                } else {
                    $('#mul_countriesID').addClass('mulcountries');
                }
            });
            $(document).on('change', '.mulcountryClass', function () {
                $('#mul_countriesID').addClass('mulcountries');
            });
            $(document).on('change', '.changeradio', function () {
                $("#shippingGateways1").html('')
                var unitofweight = $('select.weightunit option:selected').val();
                var weight = $('input:text[name=frmWeight]').val();

                var unitofDimention = $('select.lengthunit option:selected').val();
                var Length = $('input:text[name=frmLength]').val();
                var Width = $('input:text[name=frmWidth]').val();
                var Height = $('input:text[name=frmHeight]').val();


                var location = $('input[name=radio]:checked').val();
                var Currentcountry = $('#frmCountryID').val();
                if (weight == '')
                {
                    alert("please select weight");
                    return false;
                }
                if (Length == '')
                {
                    alert("please select Length");
                    return false;
                }
                if (Width == '')
                {
                    alert("please select width");
                    return false;
                }
                if (Height == '')
                {
                    alert("please select height");
                    return false;
                }
                // alert("hello");
                if (location != 'multiple')
                {
                    $.post("ajax.php", {
                        action: "getlogistcompaybyarea",
                        data: {unitweight: unitofweight, weightvalue: weight, unitlength: unitoflength, Lengthvalue: Length, Widthvalue: Width, Heightvalue: Height, locationvalue: location, currentcountryid: Currentcountry,dimentionunit:unitofDimention},
                    }, function (e) {
                        $("#shippingGateways1").html(e)
                        // $(".controles_" + jv + " .DyZoneDiv_" + jv).append(e)
                    })
                }

                if (location == 'multiple')
                {
                        $('#country_id').select2("val", "");

                    $(document).on('change', '.multilecountries', function () {

                        var unitofweight = $('select.weightunit option:selected').val();
                        var weight = $('input:text[name=frmWeight]').val();

                        var unitofDimention = $('select.lengthunit option:selected').val();
                        var Length = $('input:text[name=frmLength]').val();
                        var Width = $('input:text[name=frmWidth]').val();
                        var Height = $('input:text[name=frmHeight]').val();


                        var location = $('input[name=radio]:checked').val();
                        var Currentcountry = $('#frmCountryID').val();

                        var multiplecountries = [];
                        $("#country_id option:selected").each(function (i) {
                            multiplecountries.push($(this).val());
                        });
                        console.log(multiplecountries);
                        if (multiplecountries != '')
                        {
                            $.post("ajax.php", {
                                action: "getlogistcompaybyarea",
                                data: {unitweight: unitofweight, weightvalue: weight, unitlength: unitoflength, Lengthvalue: Length, Widthvalue: Width, Heightvalue: Height, locationvalue: location, currentcountryid: Currentcountry, multiplecountriesvalue: multiplecountries,dimentionunit:unitofDimention},
                            }, function (e) {
                                $("#shippingGateways1").html(e)
                                // $(".controles_" + jv + " .DyZoneDiv_" + jv).append(e)
                            })
                        }

                    });

                }


            });
        </script>
        <style>
            .dNone{display:none !important;}
            .mulcountries {
                display: none;
                padding-top: 10px;
            }
        </style>
    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>

        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Add- Product</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="catalog_manage_uil.php">Catalog</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="product_manage_uil.php">Manage Product</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
<!--                                <a href="product_edit_uil.php?type=edit&id=<?php echo $_GET['id']; ?>">Add - Product</a>-->
                                <span>Add - Product</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">

                            <?php
                            if ($objCore->displaySessMsg() <> '') {
                                echo $objCore->displaySessMsg();

                                $objCore->setSuccessMsg('');
                                $objCore->setErrorMsg('');
                            }
                            ?>
                            <div class="tab-pane active" id="tabs-2">
                                <div class="row-fluid">
                                    <div class="span12">

                                        <div class="box box-color box-bordered">
                                            <a href="product_manage_uil.php" id="buttonDecoration"><input type="button" style="float:right; margin:6px 2px 0 0;" value="<?php echo ADMIN_BACK_BUTTON; ?>" name="btnTagSettings" class="btn"></a>

                                            <div class="box-title">
                                                <h3>Add - Product</h3>
                                            </div>
                                            <div class="box-content nopadding">

                                                <?php require_once('javascript_disable_message.php'); ?>
                                                <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('add-products', $_SESSION['sessAdminPerMission'])) {
                                                    ?>
                                                    <?php $httpRef = (isset($_REQUEST['httpRef'])) ? $_REQUEST['httpRef'] : $_SERVER['HTTP_REFERER']; ?>

                                                    <form action=""  method="post" id="frm_page" onsubmit="return validateProductAddForm(this, 0);" enctype="multipart/form-data" >
                                                        <div class="row-fluid">
                                                            <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Product Name:</label>
                                                                    <div class="controls">
                                                                        <input type="text" name="frmProductName" id="frmProductName" value="" class="input-xlarge" maxlength="100">
                                                                        <span style="color: red;">Product name may be 100 character long only.</span>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Product Ref No:</label>
                                                                    <div class="controls">
                                                                        <input name="frmProductRefNo" id="frmProductRefNo" type="text" value="" autocomplete="off"  class="input-xlarge" onkeyup="checkProductRefNo(this.value);"   />
                                                                        <span id="refmsg" class="req"><input type="hidden" name="frmIsRefNo" value="0" /></span>

                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Category:</label>
                                                                    <div class="controls">
                                                                        <?php //pre($objPage->arrCat[3]);  ?>

                                                                        <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmfkCategoryID', 'frmfkCategoryID', array(0), 'Select Category', 0, ' onchange="showAttribute(this.value);" class="select2-me input-xlarge"', 1, 1); ?>

                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Attribute:</label>
                                                                    <div class="controls">
                                                                        <div id="attribute">
                                                                            <input type="hidden" name="frmIsAttribute" value="0" class="input2" />Select category
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--2nd-Sep-2014-->
                                                                <!--<div class="control-group">
                                                                    <label for="textfield" class="control-label">Featured:</label>
                                                                    <div class="controls">
                                                                        <input type="checkbox" name="frmIsFeatured" value="1" />&nbsp;Featured Product
                                                                        &nbsp;&nbsp;
                                                                        Start Date: <input type="text" name="frmDateStart" style="margin-right:10px" id="frmDateStart" class="input-small" value="<?php //echo DATE_NULL_VALUE_SITE;      ?>" readonly />&nbsp;&nbsp;
                                                                        End Date: <input type="text" name="frmDateEnd" id="frmDateEnd" class="input-small" value="<?php //echo DATE_NULL_VALUE_SITE;      ?>" readonly />
                                                                    </div>
                                                                </div>-->
                                                                <!--2nd-Sep-2014-->
                                                                <div class="control-group" onmousemove="checkProductRefNo(document.getElementById('frmProductRefNo').value);">
                                                                    <label for="textfield" class="control-label">*Weight:</label>
                                                                    <div class="controls">
                                                                        <select name="frmWeightUnit" class="select2-me input-large weightunit">
                                                                            <option value="kg">Kilogram</option>
                                                                            <option value="g">Gram</option>
                                                                            <option value="lb">Pound </option>
                                                                            <option value="oz">Ounce</option>
                                                                        </select>&nbsp;
                                                                        <input type="text" name="frmWeight" id="frmWeight" value="" class="input-small" />
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Dimensions (LxWxH):</label>
                                                                    <div class="controls">
                                                                        <select name="frmDimensionUnit" class="select2-me input-large lengthunit">
                                                                            <option selected="selected" value="cm">Centimeter</option>
                                                                            <option value="mm">Millimeter</option>
                                                                            <option value="in">Inch</option>
                                                                        </select>&nbsp;
                                                                        <input type="text" name="frmLength" id="frmLength" value="" class="input-small" />&nbsp;
                                                                        <input type="text" name="frmWidth" id="frmWidth" value="" class="input-small" />&nbsp;
                                                                        <input type="text" name="frmHeight" id="frmHeight" value="" class="input-small" />
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Wholesale Price:</label>
                                                                    <div class="controls">

                                                                        <div style="float: left; width: 100px">
                                                                            <span style="font-size:10px;">Choose Currency:</span><br />
                                                                            <select name="frmCurrency" id="frmCurrency1" class="select2-me input-small" onchange="showCurrencyInUSD(1);">
                                                                                <?php
                                                                                foreach ($arrCurrencyList as $ck => $cv) {
                                                                                    // $cselected = ($_SESSION['SiteCurrencyCode'] == $ck) ? 'selected="selected"' : '';
                                                                                    echo '<option value="' . $ck . '" >' . $ck . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>&nbsp;
                                                                        </div>
                                                                        <div style="float: left; width:120px">
                                                                            <span style="font-size:10px;">Wholesale Price:</span><br />
                                                                            <input name="frmWholesalePrice" id="frmWholesalePrice1" type="text" value="" class="input-small" onkeyup="showCurrencyInUSD(1);" onchange="showCurrencyInUSD(1);" />&nbsp;
                                                                        </div>

                                                                        <div style="float: left; width:150px">
                                                                            <span style="font-size:10px;">Price in USD:</span><br />
                                                                            &nbsp;<span id="InUSD1"></span>
                                                                            <input name="frmWholesalePriceInUSD" id="frmWholesalePriceInUSD1" type="hidden" value="0.00" />
                                                                        </div>

                                                                        <div style="float: left; width:150px">
                                                                            <span style="font-size:10px;">Final Product Price (in USD):</span><br />
                                                                            &nbsp;<span id="FinalPriceInUSD1" style="font-size:10px;"></span>
                                                                            <input name="frmProductPrice" id="frmProductPrice1" type="hidden" value="0.00" />&nbsp;
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Discount Price:</label>
                                                                    <div class="controls">
                                                                        <div style="float: left; width: 100px">
                                                                            <span style="font-size:10px;">Choose Currency:</span><br />
                                                                            <input style="width:75px;" name="frmCurrency2" id="frmCurrency2" type="text" value="USD" class="input-small" disabled/>&nbsp;
    <!--                                                                            <select name="frmCurrency2" id="frmCurrency2" class="select2-me input-small" onchange="showCurrencyInUSD(2);" disabled>
                                                                            <?php
                                                                            foreach ($arrCurrencyList as $ck => $cv) {
                                                                                // $cselected = ($_SESSION['SiteCurrencyCode'] == $ck) ? 'selected="selected"' : '';
                                                                                echo '<option value="' . $ck . '" >' . $ck . '</option>';
                                                                            }
                                                                            ?>
                                                                            </select>&nbsp;-->
                                                                        </div>
                                                                        <div style="float: left; width:120px">
                                                                            <span style="font-size:10px;">Discount Price:</span><br />
                                                                            <input name="frmDiscountPrice" id="frmWholesalePrice2" type="text" value="" class="input-small" onkeyup="showCurrencyInUSD(2);" onchange="showCurrencyInUSD(2);" />&nbsp;
                                                                        </div>

                                                                        <div style="float: left; width:150px">
                                                                            <span style="font-size:10px;">Price in USD:</span><br />
                                                                            &nbsp;<span id="InUSD2"></span>
                                                                            <input name="frmDiscountPriceInUSD" id="frmWholesalePriceInUSD2" type="hidden" value="" />
                                                                        </div>

                                                                        <div style="float: left; width:150px">
                                                                            <span style="font-size:10px;">Final Discount Price (in USD):</span><br />
                                                                            &nbsp;<span id="FinalPriceInUSD2" style="font-size:10px;"></span>
                                                                            <input name="frmDiscountFinalPriceInUSD" id="frmProductPrice2" type="hidden" value="0.00" />&nbsp;
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">* Stock Quantity:</label>
                                                                    <div class="controls">
                                                                        <input name="frmQuantity" id="frmQuantity" type="text" value="" class="input-small" />&nbsp;&nbsp;
                                                                        <span class="req">Sent alert message when quantity is:&nbsp;&nbsp;</span><input type="text" name="frmQuantityAlert" id="frmQuantityAlert" class="input-small" value="" />
                                                                    </div>
                                                                </div>
                                                                <?php if ($_SESSION['sessAdminCountry'] == '0') {
                                                                    ?>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Country:</label>
                                                                        <div class="controls">
                                                                            <select name="frmCountryID" id="frmCountryID" class="select2-me input-xlarge" onchange="ShowWholesaler()">
                                                                                <option value="0">Select Country</option>
                                                                                <?php
                                                                                foreach ($objPage->arrCountryList as $valCT) {
                                                                                    if (in_array($valCT['country_id'], $PortalIDs)) {
                                                                                        ?>
                                                                                        <option value="<?php echo $valCT['country_id']; ?>" ><?php echo $valCT['name']; ?></option>
                                                                                    <?php }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <input type="hidden" name="frmCountryID" id="frmCountryID" value="<?php echo $_SESSION['sessAdminCountry']; ?>" />
                                                                    <?php
                                                                }
                                                                //onchange="ShowWholesalerShippingGateway(this.value);"
                                                                ?>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Wholesaler Name:</label>
                                                                    <div class="controls">
                                                                        <select name="frmfkWholesalerID" id="frmfkWholesalerID" class="select2-me input-xlarge" >
                                                                            <option value="0">Select Wholesaler</option>
                                                                            <?php foreach ($objPage->arrWholesaler as $valWS) {
                                                                                ?>
                                                                                <option value="<?php echo $valWS['pkWholesalerID']; ?>" ><?php echo $valWS['CompanyName']; ?></option>

    <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label for="textarea" class="control-label">*Product Image (600x600):</label>
                                                                    <input type="hidden" id="CropDynId" >
                                                                    <input type="hidden" id="TargetDynId" >


                                                                    <div class="controls">
                                                                        <div id="addinput">
                                                                            <div class="imgimg">
                                                                                <div class="responce"></div>
                                                                                Image1<input type="file" name="file_upload[]" class="file_upload">
                                                                                <span><a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>
                                                                                <a id="remNew" href="#" style="display: none;"><img title="Remove" alt="Remove" src="images/minus.png"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Select Package:</label>
                                                                    <div class="controls">

                                                                        <span id="packages">
                                                                            <select name="frmfkPackageId" class="select2-me input-xlarge" onchange="showPackageProduct(this.value);">
                                                                                <option value="0">Select Package</option>
                                                                                <?php
                                                                                foreach ($objPage->arrPackageDropDown as $keyPackage => $valPackage) {
                                                                                    ?>
                                                                                    <option value="<?php echo $valPackage['pkPackageId']; ?>"><?php echo $valPackage['PackageName']; ?></option>
    <?php } ?>
                                                                            </select>
                                                                        </span>

                                                                        &nbsp;
                                                                        <!--<a class="delete" href="#listed_delete" onclick="return packagePopup()">Create New Package</a>-->
                                                                        <a class="delete" target="_blank" title="After create your package, Kindly refresh your page to view package in drop down." href="<?php echo SITE_ROOT_URL; ?>admin/package_add_uil.php?type=add" >Create New Package</a>
                                                                        <br /><br />
                                                                        <script type="text/javascript">
                                                                            function showPkgDet() {
                                                                                $('#shwhde').html('<a href="javascript:void(0)" onclick="hidePkgDet()">Hide Package Detail</a>');
                                                                                $('#showPackageProduct').css("display", 'block');
                                                                            }

                                                                            function hidePkgDet()
                                                                            {

                                                                                $('#showPackageProduct').css('display', 'none');
                                                                                $('#shwhde').html('<a href="javascript:void(0)" onclick="showPkgDet()">Show Package Detail</a>');

                                                                            }
                                                                        </script>
                                                                        <span id="shwhde">
                                                                        </span>
                                                                        <div id="showPackageProduct" style="z-index: 999; border: 2px solid #368EE0; position: absolute; width:350px; display:none; background-color: #F6F6F6;">
                                                                            <table border="0" width="100%">
                                                                                <tr><td colspan="3">Please Select Package</td></tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label for="textarea" class="control-label">Avaliable Countries:</label>
                                                                    <div class="controls">
                                                                        <input type="radio" name="radio" value="gloabal"checked  class="a mulcountryClass changeradio">Gloabal &nbsp;&nbsp;
                                                                        <input type="radio" name="radio" value="local" class="a mulcountryClass changeradio">Local &nbsp;&nbsp;
                                                                        <input type="radio" name="radio" value="multiple" id="mulcountry" class="changeradio" > Multiple country


                                                                        <div id="mul_countriesID" class="input_sec input_star input_boxes <?php echo ($productmulcountrydetail[0]['producttype'] == 'multiple') ? '' : 'mulcountries'; ?> ">
                                                                            <div class="ErrorfkCategoryID" style="display: none"></div>
                                                                            <?php
                                                                            $abc = $objGeneral->getCountry();
                                                                            foreach ($productmulcountrydetail as $kk => $vv) {
                                                                                $SelectedCountry[$kk] = $vv['country_id'];
                                                                            }
                                                                            //pre($abc);
                                                                            echo $objGeneral->CountryHtml($abc, 'name[]', 'country_id', $SelectedCountry = array(), '', 1, 'onchange="showAttribute(this.value);" class="select2-me input-xlarge multilecountries" style="width:auto"', '1', '1');
                                                                            ?>
                                                                            <!-- <small class="star_icon" style=" right:0px ; top:10px;"><img src="common/images/star_icon.png" alt=""/></small> -->
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Logistic Company(s):</label>
                                                                    <div class="controls">
                                                                        <div id="shippingGateways1">
                                                                            <?php
                                                                            foreach ($objPage->arrShippingGateway as $valShipping) {
                                                                                ?>
            <!--                                                                                <input type="checkbox" name="frmShippingGateway[]" value="<?php echo $valShipping['pkShippingGatewaysID']; ?>" /><?php echo $valShipping['ShippingTitle']; ?><br />-->
    <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label for="textarea" class="control-label">Product Type:</label>
                                                                    <div class="controls">
                                                                        <input type="checkbox" name="dangerous" value="dangerous"  class="a mulcountryClass">Dangerous &nbsp;&nbsp;
    <!--                                                                        <input type="checkbox" name="good" value="good" class="a mulcountryClass">Good &nbsp;&nbsp;-->
                                                                        <input type="checkbox" name="fragile" value="fragile"  > Fragile


                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label for="" class="control-label">Details: <br />
                                                                        <span class="req" style="font-size: 10px;">Max 250 character</span></label>
                                                                    <div class="controls">
                                                                        <textarea name="frmProductDescription" id="frmProductDescription" maxlength="2000" class="input-block-level" rows="4"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="" class="control-label"> Terms & Condition:</label>
                                                                    <div class="controls">
                                                                        <textarea name="frmProductTerms" id="frmProductTerms" class="input-block-level" rows="4"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Youtube Embedd Code:</label>
                                                                    <div class="controls">
                                                                        <span>https://www.youtube.com/embed/ </span><input type="text" name="frmYoutubeCode" id="frmYoutubeCode" value="" class="input-medium" />
                                                                        &nbsp;&nbsp;&nbsp;<span class="req">Example : https://www.youtube.com/embed/<strong>rbdAmVtqXBM</strong></span>
                                                                    </div>
                                                                </div>
                                                                <!--<div class="control-group">
                                                                    <label for="" class="control-label">More Details:</label>
                                                                    <div class="controls">
                                                                        <div class='form-wysiwyg'>
                                                                            <textarea name="frmHtmlEditor" id="frmHtmlEditor" rows="4"></textarea>
                                                                        </div>

                                                                        <script type="text/javascript">
                                                                            CKEDITOR.replace( 'frmHtmlEditor', {
                                                                                enterMode: CKEDITOR.ENTER_BR,
                                                                                toolbar :[['Bold'],['Italic'],['Strike'],['Subscript'],['Superscript'],['RemoveFormat'],['NumberedList'],['BulletedList'],['Link'],['Unlink'],
                                                                                    ['Table'],['TextColor'],['BGColor'],['FontSize'],['Font'],['Styles']]
                                                                            });
                                                                        </script>

                                                                    </div>
                                                                </div>-->
                                                                <div class="control-group">
                                                                    <label for="" class="control-label"> Meta Title:</label>
                                                                    <div class="controls">
                                                                        <textarea name="frmMetaTitle" id="frmMetaTitle" class="input-block-level" rows="4"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="" class="control-label">Meta Keywords:</label>
                                                                    <div class="controls">
                                                                        <textarea name="frmMetaKeywords" id="frmMetaKeywords" rows="4"class="input-block-level"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="" class="control-label">Meta Description:</label>
                                                                    <div class="controls">
                                                                        <textarea name="frmMetaDescription" id="frmMetaDescription" rows="4" class="input-block-level"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="note">Note : * Indicates mandatory fields.</div>

                                                                <div class="form-actions">
                                                                    <button name="btnPage" type="submit" class="btn btn-blue" value="Save">Save</button>
                                                                    <button name="saveAndAddNore" type="submit" class="btn" value="<?php echo ADMIN_ADDMORE_BUTTON; ?>"><?php echo ADMIN_ADDMORE_BUTTON; ?></button>
                                                                    <a id="buttonDecoration" href="product_manage_uil.php">
                                                                        <button name="frmCancel" type="button" value="Cancel" class="btn"><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button>
                                                                    </a>
                                                                    <input type="hidden" name="httpRef" value="<?php echo $httpRef; ?>" />
                                                                    <input type="hidden" name="frmHidenAdd" id="frmHidenAdd" value="add" />
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

                        <?php
                    } else {
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


        <div style='display:none'>
            <div id='listed_delete'>
                <table id="colorBox_table" border="0">
                    <tr align="left" >
                        <td colspan="5"><div class="dashboard_title">Add New Package</div></td>
                    </tr>
                    <tr align="left">
                        <td>Package&nbsp;Name:</td>
                        <td colspan="2"><input type="text" name="frmPackageName" id="frmPackageName" class="input2" /></td>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td valign="top" style="width:30%;">Select Wholesaler:</td>
                        <td>
                            <select name="frmWholesalerId" id="frmWholesalerId" onchange="ResetProductForPackage();" style="width: 170px;">
                                <option value="0">Select Wholesaler</option>
                                <?php
                                foreach ($objPage->arrWholesalerDropDown as $key => $val) {
                                    ?>
                                    <option value="<?php echo $val['pkWholesalerID']; ?>"><?php echo $val['CompanyName']; ?></option>
<?php } ?>
                            </select></td><td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <table border="0" id="productRow" cellpadding="5">

                                <tr align="left">
                                    <th>&nbsp;</th>
                                    <th>Select</th>
                                    <th>Select</th>
                                    <th colspan="2">Original&nbsp;Price</th>
                                </tr>
                                <tr align="left">
                                    <td>Product&nbsp;1:</td>
                                    <td>
<?php echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmCategoryId[]', '', 0, 'Category', 0, 'onchange="ShowProductForPackage(this.value,1);" class="packageCategory" style="width:170px;"'); ?>
                                    </td>
                                    <td><span id="product1">
                                            <select name="frmProductId[]" style="width:170px;" class="packageProduct" onchange="ShowProductPriceForPackage(this.value, 1)">
                                                <option value="0">Product</option>
                                            </select>
                                        </span>
                                    </td>
                                    <td><span id="price1"><input type="hidden" name="frmPrice[]" class="input1" value="0.00" /><b class="packageProductPrice">0.00</b></span></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                </tr>
                                <tr align="left">
                                    <td>Product&nbsp;2:</td>
                                    <td>
<?php echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmCategoryId[]', '', 0, 'Category', 0, 'onchange="ShowProductForPackage(this.value,2);" class="packageCategory" style="width:170px;"'); ?>
                                    </td>
                                    <td><span id="product2">
                                            <select name="frmProductId[]" class="packageProduct" style="width:170px;" onchange="ShowProductPriceForPackage(this.value, 2)">
                                                <option value="0">Product</option>
                                            </select>
                                        </span>
                                    </td>
                                    <td><span id="price2"><input type="hidden" name="frmPrice[]" class="input1" value="0.00" /><b class="packageProductPrice">0.00</b></span></td><td><i style="cursor: pointer;" onclick="addDynamicRowToTableForPackage('productRow');"><img src="images/plus.png" /></i></td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <tr align="left">
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Total Price:</td>
                        <td colspan="4"><span id="asc" style="font-weight: bold;">0.00</span><input type="hidden" name="frmTotalPrice" id="frmTotalPrice" value="0.00"  /></td>
                    </tr>
                    <tr align="left">
                        <td style="font-family: Arial,Helvetica,sans-serif; font: 12px;">Offer Price:</td>
                        <td><input type="text" name="frmOfferPrice" id="frmOfferPrice" class="input1" /></td>
                        <td colspan="3">&nbsp;</td>
                    </tr>

                    <tr align="left">
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>   <td>&nbsp;</td>
                        <td align="left" colspan="4">
                            <input type="submit" name="frmConfirmDelete" id="frmConfirmDelete" value="Create"  class="btn btn-blue" style="cursor: pointer;"/>
                            &nbsp;&nbsp;<input type="submit" name="cancel" id="cancel" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" style="cursor: pointer;"/> </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>