<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_PRODUCT_CTRL;
require_once CLASSES_ADMIN_PATH . 'class_adminuser_bll.php';
$varNum = count($objPage->arrRow['0']['pkProductID']);
//pre($objPage->arrRow['0']);
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Product Edit</title>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
        <script type="text/javascript">
            Cal = jQuery.noConflict();
            Cal(document).ready(function () {
                Cal('#frmDateStart').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif"  alt="Popup" style=" margin: -1px 0 0 -31px;" class="trigger">', onSelect: calEqual, minDate: new Date()});
                Cal('#frmDateEnd').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" style=" margin:-1px 0 0 -25px"  class="trigger">', onSelect: calDateCompare, minDate: new Date()});
            });
        </script>
        <style>
            .dNone{display:none !important;}
        </style>

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
             });
             */
            function calEqual(stDt, enDt)
            {
                $('#frmDateEnd').val($('#frmDateStart').val());
            }
            function calDateCompare(SelectedDates) {

                var d = new Date(SelectedDates);
                var d_formatted = d.getDate() + '-' + d.getMonth() + '-' + d.getFullYear();
                var sdate = d_formatted.split("-");

                var StartDate = $('#frmDateStart').val();
                var CurrDate = StartDate.split("-");
                /*********************** From Date *****************/
                var CY = parseInt(CurrDate[2]);  //Year
                var CM = parseInt(CurrDate[1]);  //Month
                var CD = parseInt(CurrDate[0]);  //Date
                /******************* To Date *********************/

                var sY = parseInt(sdate[2]);  //Year
                var sM = parseInt(sdate[1]) + 1;  //Month
                var sD = parseInt(sdate[0]);  //Date

                var ctr = 0;

                if (sY < CY) {
                    ctr = 1;
                } else if (sY == CY && sM < CM) {
                    ctr = 1;
                } else if (sY == CY && sM == CM && sD < CD) {
                    ctr = 1;
                }
                if (ctr == 1) {
                    $('#frmDateEnd').val(StartDate);
                    alert('End Date should be greater than or equal to Start Date');
                }
            }

            $(document).on('change', '.FetchFromDb', function () {
                var opnid = $(this).val();
                if ($(this).is(":checked")) {
                    var chkSrcPath = $('#existing_product_img_' + opnid).attr('src');
                    if (!chkSrcPath) {

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
                    }
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
            })
            $(document).on('change', '.changeradio', function () {
                $("#shippingGateways").html('')
                var unitofweight = $('select.weightunit option:selected').val();
                var weight = $('input:text[name=frmWeight]').val();

                var unitoflength = $('select.lengthunit option:selected').val();
                var Length = $('input:text[name=frmLength]').val();
                var Width = $('input:text[name=frmWidth]').val();
                var Height = $('input:text[name=frmHeight]').val();


                var location = $('input[name=radio]:checked').val();
                var Currentcountry = $('#frmCountryID').val();
                // alert("hello");
                if (location != 'multiple')
                {
                    $.post("ajax.php", {
                        action: "getlogistcompaybyarea",
                        data: {unitweight: unitofweight, weightvalue: weight, dimentionunit: unitoflength, Lengthvalue: Length, Widthvalue: Width, Heightvalue: Height, locationvalue: location, currentcountryid: Currentcountry},
                    }, function (e) {
                        $("#shippingGateways").html(e)
                        // $(".controles_" + jv + " .DyZoneDiv_" + jv).append(e)
                    })
                }

                if (location == 'multiple')
                {
                    $('#country_id').select2("val", "");
                    if (typeof $("#country_id option:selected").val() != 'undefined') {
                        var thisnew = $("#country_id option:selected");
                        console.log($("#country_id option:selected"));
                        var multiplecountries = [];
                        $("#country_id option:selected").each(function (i) {
                            multiplecountries.push(thisnew.val());
                        });
                        console.log(multiplecountries);
                        if (multiplecountries != '')
                        {
                            $.post("ajax.php", {
                                action: "getlogistcompaybyarea",
                                data: {unitweight: unitofweight, weightvalue: weight, dimentionunit: unitoflength, Lengthvalue: Length, Widthvalue: Width, Heightvalue: Height, locationvalue: location, currentcountryid: Currentcountry, multiplecountriesvalue: multiplecountries},
                            }, function (e) {
                                $("#shippingGateways").html(e)
                                // $(".controles_" + jv + " .DyZoneDiv_" + jv).append(e)
                            })
                        }

                    }


                }
                $(document).on('change', '.multilecountries', function () {

                    var unitofweight = $('select.weightunit option:selected').val();
                    var weight = $('input:text[name=frmWeight]').val();

                    var unitoflength = $('select.lengthunit option:selected').val();
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
                            data: {unitweight: unitofweight, weightvalue: weight, dimentionunit: unitoflength, Lengthvalue: Length, Widthvalue: Width, Heightvalue: Height, locationvalue: location, currentcountryid: Currentcountry, multiplecountriesvalue: multiplecountries},
                        }, function (e) {
                            $("#shippingGateways").html(e)
                            // $(".controles_" + jv + " .DyZoneDiv_" + jv).append(e)
                        })
                    }

                });

            });

        </script>
        <style>
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
                            <h1>Edit- Product</h1>
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
<!--                                <a href="product_edit_uil.php?type=edit&id=<?php echo $_GET['id']; ?>">Edit - Product</a>-->
                                <span>Edit - Product</span>
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
                                            <?php if (isset($_SESSION['query_string']['admin']['products_listing']) && $_SESSION['query_string']['admin']['products_listing'] != '') { ?>                                                
                                                <a href="product_manage_uil.php<?php echo '?' . $_SESSION['query_string']['admin']['products_listing']; ?>" id="buttonDecoration">
                                                    <input type="button" style="float:right; margin:6px 2px 0 0;" value="<?php echo ADMIN_BACK_BUTTON; ?>" name="btnTagSettings" class="btn"></a>
                                                </a>
                                            <?php } else { ?>
                                                <a href="product_manage_uil.php" id="buttonDecoration">
                                                    <input type="button" style="float:right; margin:6px 2px 0 0;" value="<?php echo ADMIN_BACK_BUTTON; ?>" name="btnTagSettings" class="btn"></a>
                                                </a>
                                            <?php } ?>
                                            <div class="box-title">
                                                <h3>Edit - Product</h3>
                                            </div>
                                            <div class="box-content nopadding">

                                                <?php require_once('javascript_disable_message.php'); ?>
                                                <?php
                                                if ($_SESSION['sessUserType'] == 'super-admin' || in_array('edit-products', $_SESSION['sessAdminPerMission'])) {
                                                    ?>
                                                    <?php $httpRef = (isset($_REQUEST['httpRef'])) ? $_REQUEST['httpRef'] : $_SERVER['HTTP_REFERER']; ?>
                                                    <?php
                                                    if ($varNum > 0) {
                                                        ?>
                                                        <form action=""  method="post" id="frm_page" onSubmit="return validateProductAddForm(this, 1);" enctype="multipart/form-data" >
                                                            <div class="row-fluid">
                                                                <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Product Name:</label>
                                                                        <div class="controls">
                                                                            <input type="text" name="frmProductName" id="frmProductName" value="<?php echo $objPage->arrRow[0]['ProductName']; ?>" class="input-xlarge" maxlength="100">
                                                                            <span style="color: red;">Product name may be 100 character long only.</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Product Ref No:</label>
                                                                        <div class="controls">
                                                                            <?php echo $objPage->arrRow['0']['ProductRefNo']; ?>
                                                                            <input name="frmProductRefNo" id="frmProductRefNo" type="hidden" value="<?php echo $objPage->arrRow['0']['ProductRefNo']; ?>" />
                                                                            <span id="refmsg" class="req"><input type="hidden" name="frmIsRefNo" value="0" /></span>

                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Category:</label>
                                                                        <div class="controls">
                                                                            <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmfkCategoryID', 'frmfkCategoryID', array($objPage->arrRow[0]['fkCategoryID']), 'Select Category', 0, ' onchange="showAttribute(this.value);" class="select2-me input-xlarge"', 1, 1); ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Attribute:</label>
                                                                        <div class="controls">
                                                                            <div id="attribute">
                                                                                <?php
                                                                                // pre($objPage->arrAttribute);
                                                                                if ($objPage->arrAttribute) {
                                                                                    $varStr = '<input type="hidden" name="frmIsAttribute" value="1" class="input2" />';
                                                                                    foreach ($objPage->arrAttribute as $keyAttr => $valueAttr) {

                                                                                        if ($valueAttr['AttributeInputType'] == 'select' || $valueAttr['AttributeInputType'] == 'radio' || $valueAttr['AttributeInputType'] == 'checkbox') {
                                                                                            if ($valueAttr['OptionsRows'] > 0) {
                                                                                                $varStr .= '<div class="product_attr"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</div>';
                                                                                                foreach ($valueAttr['OptionsData'] as $keyOpt => $valueOpt) {
                                                                                                    $optIdInd = (string) array_search($valueOpt['pkOptionID'], $objPage->arrProductOpt['optid']);

                                                                                                    if (in_array($valueOpt['pkOptionID'], $objPage->arrProductOpt['optid'])) {
                                                                                                        $varcheck = 'checked';
                                                                                                        $varCaptionInput = '<input type="text" name="frmOptCaption[' . $valueOpt['pkOptionID'] . ']" value="' . $objPage->arrProductOpt['optCaption'][$optIdInd] . '" class="input-small">';
                                                                                                        $varExtraPrice = '<input type="hidden" name="frmOptExtraPrice[' . $valueOpt['pkOptionID'] . ']" value="' . $objPage->arrProductOpt['optExtraPrice'][$optIdInd] . '" class="input-small">';
                                                                                                    } else {
                                                                                                        $varcheck = '';
                                                                                                        $varCaptionInput = '';
                                                                                                        $varExtraPrice = '';
                                                                                                    }
                                                                                                    $varStr .= '<div class="product_attr_options">' . $varExtraPrice . '<input type="checkbox" name="frmAttribute[' . $keyAttr . '][]" value="' . $valueOpt['pkOptionID'] . '" ' . $varcheck . ' caption="' . $valueOpt['OptionTitle'] . '" class="otherstype" />&nbsp;' . $valueOpt['OptionTitle'] . '<div class="res_caption">' . $varCaptionInput . '</div></div>';
                                                                                                }
                                                                                                $varStr .='</div>';
                                                                                            }
                                                                                        }

                                                                                        // print_r($objPage->arrProductOpt['optimg']);
                                                                                        // pre($objPage->arrProductOpt['optid']);
                                                                                        //pre($valueAttr);
                                                                                        if ($valueAttr['AttributeInputType'] == 'image') {

                                                                                            if ($valueAttr['OptionsRows'] > 0) {
                                                                                                //echo "<pre>";
                                                                                                //print_r($objPage->arrProductOpt);
                                                                                                $varStr .= '<div class="product_attr"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</div>';
                                                                                                foreach ($valueAttr['OptionsData'] as $keyOpt => $valueOpt) {
                                                                                                    $optIdInd = (string) array_search($valueOpt['pkOptionID'], $objPage->arrProductOpt['optid']);

                                                                                                    if (in_array($valueOpt['pkOptionID'], $objPage->arrProductOpt['optid'])) {
                                                                                                        $varcheck = 'checked';
                                                                                                        $varCaptionInput = '<input type="text" name="frmOptCaption[' . $valueOpt['pkOptionID'] . ']" value="' . $objPage->arrProductOpt['optCaption'][$optIdInd] . '" class="input-small">';
                                                                                                        $varExtraPrice = '<input type="hidden" name="frmOptExtraPrice[' . $valueOpt['pkOptionID'] . ']" value="' . $objPage->arrProductOpt['optExtraPrice'][$optIdInd] . '" class="input-small">';
                                                                                                    } else {
                                                                                                        $varcheck = '';
                                                                                                        $varCaptionInput = '';
                                                                                                        $varExtraPrice = '';
                                                                                                    }

                                                                                                    if ($optIdInd == '') {
                                                                                                        $defAttrImgVal = $valueOpt['OptionImage'];
                                                                                                    } else {
                                                                                                        $defAttrImgVal = $objPage->arrProductOpt['optimg'][$optIdInd];
                                                                                                    }


                                                                                                    $defAttrImgUp = (in_array($valueOpt['pkOptionID'], $objPage->arrProductOpt['optid']) && $objPage->arrProductOpt['optimg'][$optIdInd] <> $valueOpt['OptionImage'] && $objPage->arrProductOpt['optimg'][$optIdInd] <> '') ? 1 : 0;
                                                                                                    $varColorCodeUpdate = $valueOpt['optionColorCode'] != "" ? $valueOpt['optionColorCode'] : $valueOpt['OptionTitle'];
                                                                                                    //echo $varColorCodeUpdate;
                                                                                                    $clrCode = '<a href="#" style="background:' . $varColorCodeUpdate . ';margin-right: 10px;padding-left: 20px;"></a>';

                                                                                                    if (!empty($objPage->arrProductOpt['optimg'][$optIdInd])) {
                                                                                                        $demoimg = '<img id="existing_product_img_' . $valueOpt['pkOptionID'] . '" src="' . $objCore->getImageUrl($objPage->arrProductOpt['optimg'][$optIdInd], 'products/' . $arrProductImageResizes['default']) . '" width="25" height="25" />';
                                                                                                    } else {
                                                                                                        $demoimg = '';
                                                                                                    }
                                                                                                    $varStr .= '<div class="product_attr_img_options" id="AttIconDefault_' . $valueOpt['pkOptionID'] . '">' . $varExtraPrice . $clrCode . '<input type="checkbox" name="frmAttribute[' . $keyAttr . '][]" value="' . $valueOpt['pkOptionID'] . '"  ' . $varcheck . ' caption="' . $valueOpt['OptionTitle'] . '" class="imagetype FetchFromDb" />
                                                                                                        <input type="hidden" name="frmAttributeImgUploaded[' . $keyAttr . '][' . $valueOpt['pkOptionID'] . ']" value="' . $defAttrImgUp . '" />
                                                                                                            <input type="hidden" path="' . UPLOADED_FILES_URL . 'images/products/' . $arrProductImageResizes['default'] . '" id="frmAttributeDefaultImg_' . $valueOpt['pkOptionID'] . '" name="frmAttributeDefaultImg[' . $keyAttr . '][' . $valueOpt['pkOptionID'] . ']" value="' . $defAttrImgVal . '" />&nbsp;' . $valueOpt['OptionTitle'] . '
                                                                                                            ' . $demoimg . '<div class="res_attr">';
                                                                                                    if ($varcheck) {
                                                                                                        $varStr .= '<div class="responce"></div>' . $varCaptionInput . '<input name="file_upload_attr[' . $valueOpt['pkOptionID'] . ']" class="file_upload_attr" type="file" />';
                                                                                                    }
                                                                                                    $varStr .= '</div></div>';
                                                                                                }
                                                                                                $varStr .='</div>';
                                                                                            }
                                                                                        } else if ($valueAttr['AttributeInputType'] == 'text') {
                                                                                            $optIdInd = array_search($valueAttr['OptionsData']['0']['pkOptionID'], $objPage->arrProductOpt['optid']);
                                                                                            $varStr .= '<div class="product_attr" id="textInput"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</div><input type="text" name="frmAttributeText[' . $keyAttr . '-' . $valueAttr['OptionsData']['0']['pkOptionID'] . ']" value="' . $objPage->arrProductOpt['optval'][$optIdInd] . '" class="input2" /><span style="cursor: pointer;" onclick="hideInputType(' . "'" . 'textInput' . "'" . ');"><img src="images/minus.png" alt="Remove" title="Remove" /></span></div>';
                                                                                        } else if ($valueAttr['AttributeInputType'] == 'textarea') {
                                                                                            $optIdInd = array_search($valueAttr['OptionsData']['0']['pkOptionID'], $objPage->arrProductOpt['optid']);
                                                                                            $varStr .= '<div class="product_attr" id="textAreaInput"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</div><textarea name="frmAttributeTextArea[' . $keyAttr . '-' . $valueAttr['OptionsData']['0']['pkOptionID'] . ']" rows="3" class="input3">' . $objPage->arrProductOpt['optval'][$optIdInd] . '</textarea><span onclick="hideInputType(' . "'" . 'textAreaInput' . "'" . ');"><img src="images/minus.png" alt="Remove" title="Remove" align="top" /></span></div>';
                                                                                        }
                                                                                    }
                                                                                } else {
                                                                                    $varStr = '<input type="hidden" name="frmIsAttribute" value="0" class="input2" /><span class="req">There is no attribute in this category !</span>';
                                                                                }
                                                                                echo $varStr;
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!--2nd-Sep-2014-->
                                                                    <!--<div class="control-group">
                                                                        <label for="textfield" class="control-label">Featured:</label>
                                                                        <div class="controls">
                                                                            <input type="checkbox" name="frmIsFeatured" value="1" <?php
                                                                    /* if ($objPage->arrRow[0]['IsFeatured'] == 1) {
                                                                      echo 'checked';
                                                                      } */
                                                                    ?>  />&nbsp;Featured Product
                                                                    <?php
                                                                    /*   $varDateStart = $objCore->localDateTime($objPage->arrRow['0']['DateStart'], DATE_FORMAT_SITE);
                                                                      $varDateEnd = $objCore->localDateTime($objPage->arrRow['0']['DateEnd'], DATE_FORMAT_SITE); */
                                                                    ?>
                                                                            &nbsp;&nbsp;Start Date: <input type="text" name="frmDateStart" id="frmDateStart" style="margin-right:10px" class="input-small" value="<?php echo $varDateStart; ?>" readonly />&nbsp;&nbsp;
                                                                            End Date: <input type="text" name="frmDateEnd" id="frmDateEnd" class="input-small" value="<?php // echo $varDateEnd;            ?>" readonly />
                                                                        </div>
                                                                    </div>-->
                                                                    <!--2nd-Sep-2014-->
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label ">Weight:</label>
                                                                        <div class="controls">
                                                                            <select name="frmWeightUnit" class="select2-me input-large weightunit">
                                                                                <option value="kg" <?php
                                                                                if ($objPage->arrRow['0']['WeightUnit'] == 'kg') {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                                ?>>Kilogram</option>
                                                                                <option value="g" <?php
                                                                                if ($objPage->arrRow['0']['WeightUnit'] == 'g') {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                                ?>>Gram</option>
                                                                                <option value="lb" <?php
                                                                                if ($objPage->arrRow['0']['WeightUnit'] == 'lb') {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                                ?>>Pound </option>
                                                                                <option value="oz" <?php
                                                                                if ($objPage->arrRow['0']['WeightUnit'] == 'oz') {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                                ?>>Ounce</option>
                                                                            </select>&nbsp;
                                                                            <input type="text" name="frmWeight" id="frmWeight" value="<?php echo $objCore->price_format($objPage->arrRow['0']['Weight']); ?>" class="input-small" />
                                                                        </div>
                                                                    </div>


                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Dimensions (L x W x H):</label>
                                                                        <div class="controls">

                                                                            <select name="frmDimensionUnit" class="select2-me input-large lengthunit">
                                                                                <option selected="selected" value="cm" <?php
                                                                                if ($objPage->arrRow['0']['DimensionUnit'] == 'cm') {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                                ?>>Centimeter</option>
                                                                                <option value="mm" <?php
                                                                                if ($objPage->arrRow['0']['DimensionUnit'] == 'mm') {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                                ?>>Millimeter</option>
                                                                                <option value="in" <?php
                                                                                if ($objPage->arrRow['0']['DimensionUnit'] == 'in') {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                                ?>>Inch</option>
                                                                            </select>&nbsp;
                                                                            <input type="text" name="frmLength" id="frmLength" value="<?php echo $objCore->price_format($objPage->arrRow['0']['Length']); ?>" class="input-small" />&nbsp;
                                                                            <input type="text" name="frmWidth" id="frmWidth" value="<?php echo $objCore->price_format($objPage->arrRow['0']['Width']); ?>" class="input-small" />&nbsp;
                                                                            <input type="text" name="frmHeight" id="frmHeight" value="<?php echo $objCore->price_format($objPage->arrRow['0']['Height']); ?>" class="input-small" />

                                                                        </div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Wholesale Price:</label>
                                                                        <div class="controls">

                                                                            <div style="float: left; width: 100px">
                                                                                <span style="font-size:10px;">Choose Currency:</span><br />
                                                                                <select name="frmCurrency"id="frmCurrency1" class="select2-me input-small" onChange="showCurrencyInUSD(1);">
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
                                                                                <input name="frmWholesalePrice" id="frmWholesalePrice1" type="text" value="<?php echo $objPage->arrRow['0']['WholesalePrice']; ?>" class="input-small" onKeyUp="showCurrencyInUSD(1);" onChange="showCurrencyInUSD(1);" />&nbsp;
                                                                            </div>

                                                                            <div style="float: left; width:150px">
                                                                                <span style="font-size:10px;">Price in USD:</span><br />
                                                                                &nbsp;<span id="InUSD1">$&nbsp;<?php echo $objCore->price_format($objPage->arrRow['0']['WholesalePrice']); ?></span>
                                                                                <input name="frmWholesalePriceInUSD" id="frmWholesalePriceInUSD1" type="hidden" value="<?php echo $objPage->arrRow['0']['WholesalePrice']; ?>" />
                                                                            </div>

                                                                            <div style="float: left; width:150px">
                                                                                <span style="font-size:10px;">Final Product Price (in USD):</span><br />
                                                                                &nbsp;<span id="FinalPriceInUSD1" style="font-size:10px;">$&nbsp;<?php echo $objCore->price_format($objPage->arrRow['0']['FinalPrice']); ?></span>

                                                                                <input name="frmProductPrice" id="frmProductPrice1" type="hidden" value="<?php echo $objPage->arrRow['0']['FinalPrice']; ?>" />&nbsp;
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Discount Price:</label>
                                                                        <div class="controls">
                                                                            <div style="float: left; width: 100px">
                                                                                <span style="font-size:10px;">Choose Currency:</span><br />
                                                                                <input style="width:75px;" name="frmCurrency2" id="frmCurrency2" type="text" value="USD" class="input-small" disabled/>&nbsp;
        <!--                                                                                <select name="frmCurrency2"id="frmCurrency2" class="select2-me input-small" onchange="showCurrencyInUSD(2);">
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
                                                                                <input name="frmDiscountPrice" id="frmWholesalePrice2" type="text" value="<?php echo $objPage->arrRow['0']['DiscountPrice']; ?>" class="input-small" onKeyUp="showCurrencyInUSD(2);" onChange="showCurrencyInUSD(2);" />&nbsp;
                                                                            </div>

                                                                            <div style="float: left; width:150px">
                                                                                <span style="font-size:10px;">Price in USD:</span><br />
                                                                                &nbsp;<span id="InUSD2">$&nbsp;<?php echo $objCore->price_format($objPage->arrRow['0']['DiscountPrice']); ?></span>
                                                                                <input name="frmDiscountPriceInUSD" id="frmWholesalePriceInUSD2" type="hidden" value="<?php echo $objPage->arrRow['0']['DiscountPrice']; ?>" />
                                                                            </div>

                                                                            <div style="float: left; width:150px">
                                                                                <span style="font-size:10px;">Final Discount Price (in USD):</span><br />
                                                                                &nbsp;<span id="FinalPriceInUSD2" style="font-size:10px;">$&nbsp;<?php echo $objCore->price_format($objPage->arrRow['0']['DiscountFinalPrice']); ?></span>
                                                                                <input name="frmDiscountFinalPriceInUSD" id="frmProductPrice2" type="hidden" value="<?php echo $objPage->arrRow['0']['DiscountFinalPrice']; ?>" />&nbsp;
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">* Stock Quantity:</label>
                                                                        <div class="controls">
                                                                            <input name="frmQuantity" id="frmQuantity" type="text" value="<?php echo $objPage->arrRow['0']['Quantity']; ?>" class="input-small" />&nbsp;&nbsp;
                                                                            <span class="req">Sent alert message when quantity is:&nbsp;&nbsp;</span><input type="text" name="frmQuantityAlert" id="frmQuantityAlert" class="input-small" value="<?php echo $objPage->arrRow['0']['QuantityAlert']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                    if ($_SESSION['sessAdminCountry'] == '0') {
                                                                        ?>
                                                                        <div class="control-group">
                                                                            <label for="textfield" class="control-label">*Country:</label>
                                                                            <div class="controls">
                                                                                <select name="frmCountryID" id="frmCountryID" class="select2-me input-xlarge" onChange="ShowWholesaler(this.value)">
                                                                                    <option value="0">Select Country</option>
                                                                                    <?php
                                                                                    foreach ($objPage->arrCountryList as $valCT) {
                                                                                        if (in_array($valCT['country_id'], $PortalIDs)) {
                                                                                            ?>
                                                                                            <option value="<?php echo $valCT['country_id']; ?>"<?php
                                                                                            if ($valCT['country_id'] == $objPage->arrRow['0']['CompanyCountry']) {
                                                                                                echo 'selected=selected';
                                                                                            }
                                                                                            ?>><?php echo $valCT['name']; ?></option>
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
//onChange="ShowWholesalerShippingGateway(this.value);"
                                                                    ?>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Wholesaler Name:</label>
                                                                        <div class="controls">
                                                                            <select name="frmfkWholesalerID" id="frmfkWholesalerID" class="select2-me input-xlarge" >
                                                                                <option value="0">Select Wholesaler</option>
                                                                                <?php
                                                                                foreach ($objPage->arrWholesaler as $valWS) {
                                                                                    ?>
                                                                                    <option value="<?php echo $valWS['pkWholesalerID']; ?>" <?php
                                                                                    if ($valWS['pkWholesalerID'] == $objPage->arrRow['0']['fkWholesalerID']) {
                                                                                        echo 'selected=selected';
                                                                                    }
                                                                                    ?>><?php echo $valWS['CompanyName']; ?></option>

        <?php } ?>


                                                                            </select>
                                                                        </div>
                                                                    </div>


                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">Product Image (600x600):</label>
                                                                        <input type="hidden" id="CropDynId" >
                                                                        <input type="hidden" id="TargetDynId" >
                                                                        <div class="controls">
                                                                            <?php
                                                                            foreach ($objPage->arrImageRows as $vImg) {
                                                                                if ($vImg['ImageName'] <> '') {
                                                                                    ?>
                                                                                    <div style="width: 100px;height: 100px; float: left; margin-right:5px; border: 1px solid #dddddd;">
                                                                                        <span id="img<?php echo $vImg['pkImageID']; ?>">

                                                                                            <img src="<?php echo UPLOADED_FILES_URL . 'images/products/' . $arrProductImageResizes['default'] . '/' . $vImg['ImageName']; ?>" border="0" />

                                                                                            <?php
                                                                                            if ($objPage->arrRow['0']['ProductImage'] == $vImg['ImageName']) {
                                                                                                $ckd = 'checked="checked"';
                                                                                            } else {
                                                                                                $ckd = '';
                                                                                                ?>
                                                                                                <span style="cursor: pointer;vertical-align: top; float: right" onClick="deleteImage(<?php echo $vImg['pkImageID']; ?>)">
                                                                                                    <img src="<?php echo SITE_ROOT_URL . 'admin/images/cross.png'; ?>" alt="Delete" title="Delete" />
                                                                                                </span>
                <?php } ?>
                                                                                            <div style="width: 100%; float: left; padding: 5px;">
                                                                                                <input type="radio" name="default" class="default" value="<?php echo $vImg['ImageName'] ?>" <?php echo $ckd; ?> />Default
                                                                                            </div>
                                                                                        </span>
                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>

                                                                            <div id="addinput" style="float: left;margin-top:26px;width: 100%;">
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
                                                                                <select name="frmfkPackageId" class="select2-me input-xlarge" onChange="showPackageProduct(this.value);">
                                                                                    <option value="0">Select Package</option>
                                                                                    <?php
                                                                                    foreach ($objPage->arrPackageDropDown as $keyPackage => $valPackage) {
                                                                                        ?>
                                                                                        <option value="<?php echo $valPackage['pkPackageId']; ?>"<?php
                                                                                        if ($objPage->arrRow['0']['fkPackageId'] == $valPackage['pkPackageId']) {
                                                                                            echo 'selected';
                                                                                        }
                                                                                        ?>><?php echo $valPackage['PackageName']; ?></option>
        <?php } ?>
                                                                                </select>
                                                                            </span>

                                                                            &nbsp;
                                                                            <!--<a class="delete" href="#listed_delete" onClick="return packagePopup()">Create New Package</a>-->
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
                                                                    <?php
                                                                    //pre($objPage);

                                                                    $product = $objPage->productDetail[0];
                                                                    $productmulcountrydetail = $objPage->productmulcountrydetail;
                                                                    //pre($productmulcountrydetail[0]);  
                                                                    ?>

                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">Avaliable Countries:</label>
                                                                        <div class="controls">
                                                                            <input type="radio" name="radio" value="gloabal" <?php echo (($productmulcountrydetail[0]['producttype'] != 'local') && ($productmulcountrydetail[0]['producttype'] != 'multiple')) ? 'checked' : ''; ?>  class="a mulcountryClass changeradio">Gloabal &nbsp;&nbsp;
                                                                            <input type="radio" name="radio" value="local" <?php echo ($productmulcountrydetail[0]['producttype'] == 'local') ? 'checked' : ''; ?> class="a mulcountryClass changeradio">Local &nbsp;&nbsp;
                                                                            <input type="radio" name="radio" value="multiple" class="changeradio" id="mulcountry" <?php echo ($productmulcountrydetail[0]['producttype'] == 'multiple') ? 'checked' : ''; ?> > Multiple country


                                                                            <div id="mul_countriesID" class="input_sec input_star input_boxes <?php echo ($productmulcountrydetail[0]['producttype'] == 'multiple') ? '' : 'mulcountries'; ?> ">
                                                                                <div class="ErrorfkCategoryID" style="display: none"></div>
                                                                                <?php
                                                                                //pre($a);
                                                                                $a = $objGeneral->getCountry();
                                                                                foreach ($productmulcountrydetail as $kk => $vv) {
                                                                                    $SelectedCountry[$kk] = $vv['country_id'];
                                                                                }
                                                                                //pre($a);
                                                                                echo $objGeneral->CountryHtml($a, 'name[]', 'country_id', $SelectedCountry, '', 1, 'onchange="showAttribute(this.value);" class="select2-me input-xlarge  multilecountries" style="width:auto"', '1', '1');
                                                                                ?>
                                                                                <!-- <small class="star_icon" style=" right:0px ; top:10px;"><img src="common/images/star_icon.png" alt=""/></small> -->
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Logistic Company(s):</label>
                                                                        <div class="controls">
                                                                            <div id="shippingGateways">
                                                                                <?php
                                                                               // pre($objPage->arrShippingGateway);
                                                                                $arrShipping = explode(',', $objPage->arrRow['0']['fkShippingID']);

                                                                               foreach ($objPage->arrShippingGateway as $valShipping) {
                                                                                    ?>
                                                                                   <input type="checkbox" name="frmShippingGateway[]" value="<?php echo $valShipping['logisticportalid']; ?>" <?php
                                                                                    if (in_array($valShipping['logisticportalid'], $arrShipping)) {
                                                                                        echo 'checked="checked"';
                                                                                    }
                                                                                    ?> /><?php echo $valShipping['logisticTitle']; ?><br />
                                                                                 <?php } ?>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">Product Type:</label>
                                                                        <div class="controls">
                                                                            <?php /*
                                                                            <input type="checkbox" name="dangerous" value="dangerous" <?php echo ($objPage->arrRow['0']['productdangerous'] == 'dangerous') ? 'checked' : ''; ?>  class="a mulcountryClass">Dangerous &nbsp;&nbsp;
        <!--                                                                        <input type="checkbox" name="good" value="good" class="a mulcountryClass">Good &nbsp;&nbsp;-->
                                                                             * */ ?>
                                                                            <input type="checkbox" name="fragile" value="fragile" <?php echo ($objPage->arrRow['0']['productfragile'] == 'fragile') ? 'checked' : ''; ?> > Fragile/Dangerous


                                                                        </div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label for="" class="control-label">Details: <br />
                                                                            <span class="req" style="font-size: 10px;">Max 250 character</span></label>
                                                                        <div class="controls">
                                                                            <textarea name="frmProductDescription" id="frmProductDescription" maxlength="2000" class="input-block-level" rows="4"><?php echo $objPage->arrRow['0']['ProductDescription']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="" class="control-label"> Terms & Condition:</label>
                                                                        <div class="controls">
                                                                            <textarea name="frmProductTerms" id="frmProductTerms" class="input-block-level" rows="4"><?php echo $objPage->arrRow['0']['ProductTerms']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Youtube Embedd Code:</label>
                                                                        <div class="controls">

                                                                            <span class="req">https://www.youtube.com/embed/ </span><input type="text" name="frmYoutubeCode" id="frmYoutubeCode" value="<?php echo $objPage->arrRow['0']['YoutubeCode']; ?>" class="input-medium" />
                                                                            &nbsp;&nbsp;&nbsp;<span>Example : https://www.youtube.com/embed/<strong>rbdAmVtqXBM</strong></span>
                                                                        </div>
                                                                    </div>
                                                                    <!--<div class="control-group">
                                                                        <label for="" class="control-label">More Details:</label>
                                                                        <div class="controls">
                                                                            <div class='form-wysiwyg'>
                                                                                <textarea name="frmHtmlEditor" id="frmHtmlEditor" rows="4"><?php echo $objPage->arrRow['0']['HtmlEditor']; ?></textarea>
                                                                            </div>

                                                                            <script type="text/javascript">
                                                                                CKEDITOR.replace( 'frmHtmlEditor', {
                                                                                    allowedContent: {
                                                                                        'b i ul ol big small': true,
                                                                                        'h1 h2 h3 p blockquote li': {
                                                                                            styles: 'text-align'
                                                                                        },
                                                                                        a: { attributes: '!href,target' },
                                                                                        img: {
                                                                                            attributes: '!src,alt',
                                                                                            styles: 'width,height',
                                                                                            classes: 'left,right'
                                                                                        }
                                                                                    },
                                                                                    disabled:true,
                                                                                    enterMode: CKEDITOR.ENTER_BR,
                                                                                    toolbar :[['Source'],'-',['Bold'],['Italic'],['Strike'],['Subscript'],['Superscript'],['RemoveFormat'],['NumberedList'],['BulletedList'],['Link'],['Unlink'],
                                                                                        ['Table'],['TextColor'],['BGColor'],['FontSize'],['Font'],['Styles']]

                                                                                } );
                                                                                /*
                                                                                CKEDITOR.replace( 'frmHtmlEditor', {
                                                                                    enterMode: CKEDITOR.ENTER_BR,
                                                                                    toolbar :[['Source'],'-',['Bold'],['Italic'],['Strike'],['Subscript'],['Superscript'],['RemoveFormat'],['NumberedList'],['BulletedList'],['Link'],['Unlink'],
                                                                                        ['Table'],['TextColor'],['BGColor'],['FontSize'],['Font'],['Styles']]
                                                                                });  */
                                                                            </script>

                                                                        </div>
                                                                    </div> -->
                                                                    <div class="control-group">
                                                                        <label for="" class="control-label"> Meta Title:</label>
                                                                        <div class="controls">
                                                                            <textarea name="frmMetaTitle" id="frmMetaTitle" class="input-block-level" rows="4"><?php echo $objPage->arrRow[0]['MetaTitle']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="" class="control-label">Meta Keywords:</label>
                                                                        <div class="controls">
                                                                            <textarea name="frmMetaKeywords" id="frmMetaKeywords" rows="4"class="input-block-level" ><?php echo $objPage->arrRow[0]['MetaKeywords']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="" class="control-label">Meta Description:</label>
                                                                        <div class="controls">
                                                                            <textarea name="frmMetaDescription" id="frmMetaDescription" rows="4" class="input-block-level"><?php echo $objPage->arrRow[0]['MetaDescription']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="note">Note : * Indicates mandatory fields.</div>

                                                                    <div class="form-actions">
                                                                        <button name="btnPage" type="submit" class="btn btn-blue" style="width:80px;"  value="<?php echo ADMIN_SUBMIT_BUTTON; ?>" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button>
                                                                        <a id="buttonDecoration" href="<?php echo $httpRef; ?>"><button name="frmCancel" type="button" value="Cancel" style="width:80px;"  class="btn" ><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button></a>
                                                                        <input type="hidden" name="httpRef" value="<?php echo $httpRef; ?>" />
                                                                        <input type="hidden" name="frmHidenEdit" id="frmHidenEdit" value="edit" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </form>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <div class="control-group">
                                                            <div class="controls" style="text-align: center;">
        <?php echo ADMIN_NO_RECORD_FOUND; ?>
                                                            </div>
                                                        </div>

    <?php } ?>
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
                        <td colspan="5"> <div class="dashboard_title">Add New Package</div></td>
                    </tr>

                    <tr align="left">
                        <td>Package&nbsp;Name:</td>
                        <td colspan="2"><input type="text" name="frmPackageName" id="frmPackageName" class="input2" /></td>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td valign="top" style="width:30%;">Select Wholesaler:</td>
                        <td>
                            <select name="frmWholesalerId" id="frmWholesalerId" onChange="ResetProductForPackage();" style="width: 170px;">
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
                                            <select name="frmProductId[]" style="width:170px;" class="packageProduct" onChange="ShowProductPriceForPackage(this.value, 1)">
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
                                            <select name="frmProductId[]" class="packageProduct" style="width:170px;" onChange="ShowProductPriceForPackage(this.value, 2)">
                                                <option value="0">Product</option>
                                            </select>
                                        </span>
                                    </td>
                                    <td><span id="price2"><input type="hidden" name="frmPrice[]" class="input1" value="0.00" /><b class="packageProductPrice">0.00</b></span></td><td><i style="cursor: pointer;" onClick="addDynamicRowToTableForPackage('productRow');"><img src="images/plus.png" /></i></td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <tr align="left">
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Total Price:</td>
                        <td colspan="4"><span id="asc" style="font-weight: bold;">0.00</span><input type="hidden" name="frmTotalPrice" id="frmTotalPrice" class="input1" value="0.00"  /></td>
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