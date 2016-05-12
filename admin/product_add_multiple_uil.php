<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_PRODUCT_CTRL;
require_once CLASSES_ADMIN_PATH . 'class_adminuser_bll.php';

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

        <title><?php echo ADMIN_PANEL_NAME; ?> : Add Multiple Product</title>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <link type="text/css"  rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
        <script type="text/javascript">
            Cal = jQuery.noConflict();
            Cal(document).ready(function () {
                Cal('.inputDate').datepick({dateFormat: 'dd-mm-yyyy'});
            });
        </script>

        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <?php require_once 'inc/img_crop_js_css.inc.php'; ?>

        <link rel="stylesheet" href="css/colorbox.css" />
        <script src="../colorbox/jquery.colorbox.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <script type="text/javascript">
            function jscall(arg1) {
                $(".delete").colorbox({inline: true, width: "900px", height: "700px"});
                $('#cancel' + arg1).click(function () {
                    parent.jQuery.fn.colorbox.close();
                });
            }

            function ShowWholesaler() {
                var str = $('#frmCountryID').val();
                $.post("ajax.php", {action: 'ShowWholesaler', ctid: str},
                function (data)
                {
                    $('#frmfkWholesalerID').html(data);
                }
                );
                ShowcountryportalShippingGateway(str); 
            }

            function ShowcountryportalShippingGateway(str) { 
            	   
            	$.post("ajax.php",{
                    action:'Showcurrentcountrygateway',
                    ctid:str
                },
                function(data){
                        $('#shippingGateways').html('<input type="checkbox" value="All" name="all[]" id="sAll" onclick="javascript:toggleShippingOption(this);"> Select All <br>'+data);
                    });
            }

            function ShowWholesalerShippingGateway(str) {

                $.post("ajax.php", {action: 'ShowWholesalerShippingGateway', wid: str},
                function (data)
                {
                    $('#shippingGateways').html(data);
                }
                );
                $.post("ajax.php", {action: 'ShowWholesalerPackage', wid: str},
                function (data)
                {
                    $('.frmfkPackageId').html(data);
                }
                );
            }

            function hideInputType(Id) {

                document.getElementById(Id).innerHTML = '';
            }

            function addImage(showId) {
                var addDiv = $('#addinput_' + showId);
                var i = $('#addinput_' + showId + ' .imgimg').size() + 1;
                $('#addinput_' + showId + ' .imgimg :last span').html('');
                $('<div class="imgimg" id="' + showId + i + '"><div class="responce"></div><input type="file" name="file_upload[]" class="file_upload_multi" size="1" style="width:120px"><span>&nbsp;<a href="javascript:void(0);" onclick="addImage(' + showId + ')" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span><a href="javascript:void(0)" onclick="hideImg(' + showId + ',' + showId + i + ')" id="remNew"><img src="images/minus.png" alt="Remove" title="Remove" /></a></div>').appendTo(addDiv);
                // $('<div class="imgimg" id="'+showId+i+'"><input type="file" size="1" style="width:120px" name="frmProductImg['+showId+']['+i+']" id="frmProductImg'+showId+'" value="" class="prod_img"/><input type="hidden" name="image_error" value="0" class="image_error" id="image_error'+i+'"><span>&nbsp;<a href="javascript:void(0);" onclick="addImage('+showId+')" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span><a href="javascript:void(0)" onclick="hideImg('+showId+','+showId+i+')" id="remNew"><img src="images/minus.png" alt="Remove" title="Remove" /></a></div>').appendTo(addDiv);
                addRemoveDeleteMoreImages('addinput_' + showId);
                return false;
            }
            function hideImg(showId, rId) {
                var i = $('#addinput_' + showId + ' .imgimg').size() + 1;
                if (i > 2) {
                    $('#' + rId).remove();
                    $('#addinput_' + showId + ' .imgimg:last span').html('<span><a href="javascript:void(0);" onclick="addImage(' + showId + ')" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>');
                }
                addRemoveDeleteMoreImages('addinput_' + showId);
                return false;
            }

            function jCropPopupOpen(str) {
                $('#' + str).show();
                $('#CropDynId').val(str);

            }
            function addRemoveDeleteMoreImages(row) {
                var i = 0;

                $("#" + row).find(".imgimg").each(function () {
                    i++;
                });

                if (i > 1) {
                    $("#" + row).find(".imgimg").first().find('a').last().show();
                } else {
                    $("#" + row).find(".imgimg").first().find('a').last().hide();
                }
            }

            function jCropPopupClose(str) {
                $('#' + str).hide();
            }
            $(function () {
                //attrbutes images

                Cal('.imagetype').live('change', function () {
                    var objAttr = $(this);
                    var OptId = objAttr.val();
                    var rowNum = objAttr.parent().parent().attr('row');
                    if (objAttr.is(':checked')) {
                        objAttr.siblings('.res_attr').html('<div class="responce"></div><input type="text" name="frmOptCaption[' + rowNum + '][' + OptId + ']" value="' + objAttr.attr('caption') + '" class="input-small"><input name="file_upload_attr[' + OptId + ']" class="file_upload_attr_multi" type="file" style="width:120px" size="1" />');
                    } else {
                        objAttr.siblings('.res_attr').html('');
                    }
                });

                Cal('.otherstype').live('change', function () {

                    var objCaption = $(this);
                    var OptId = objCaption.val();
                    var rowNum = objCaption.parent().parent().attr('row');
                    if (objCaption.is(':checked')) {
                        objCaption.siblings('.res_caption').html('<input type="text" name="frmOptCaption[' + rowNum + '][' + OptId + ']" value="' + objCaption.attr('caption') + '" class="input-small">');
                    } else {
                        objCaption.siblings('.res_caption').html('');
                    }
                });

                //    $('.inputDate').datepick({dateFormat: 'dd-mm-yyyy'});
            });

            /*
             var MAX_PRODUCT_IMAGE_SIZE = '<?php echo MAX_PRODUCT_IMAGE_SIZE; ?>';
             var MIN_PRODUCT_IMAGE_WIDTH = '<?php echo MIN_PRODUCT_IMAGE_WIDTH; ?>';
             var MIN_PRODUCT_IMAGE_HEIGHT = '<?php echo MIN_PRODUCT_IMAGE_HEIGHT; ?>';
             var MAX_PRODUCT_IMAGE_WIDTH = '<?php echo MAX_PRODUCT_IMAGE_WIDTH; ?>';
             var MAX_PRODUCT_IMAGE_HEIGHT = '<?php echo MAX_PRODUCT_IMAGE_HEIGHT; ?>';
             var MIN_PRODUCT_SLIDER_IMAGE_WIDTH = '<?php echo MIN_PRODUCT_SLIDER_IMAGE_WIDTH; ?>';
             var MIN_PRODUCT_SLIDER_IMAGE_HEIGHT = '<?php echo MIN_PRODUCT_SLIDER_IMAGE_HEIGHT; ?>';
             var MIN_PRODUCT_DETAIL_IMAGE_HEIGHT = '<?php echo MIN_PRODUCT_DETAIL_IMAGE_HEIGHT; ?>';
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
             
             if(name.substr(0,19)=='frmProductSliderImg' && (this.width < MIN_PRODUCT_SLIDER_IMAGE_WIDTH || this.height < MIN_PRODUCT_IMAGE_HEIGHT || this.width >MAX_PRODUCT_IMAGE_WIDTH || this.height > MAX_PRODUCT_IMAGE_HEIGHT || this.size > MAX_PRODUCT_IMAGE_SIZE) ){
             alert('Please upload image in between ('+MIN_PRODUCT_SLIDER_IMAGE_WIDTH+'-'+MAX_PRODUCT_IMAGE_WIDTH+')px width and ('+MIN_PRODUCT_IMAGE_HEIGHT+'-'+MAX_PRODUCT_IMAGE_HEIGHT+')px height!');
             dd.parent().find('.image_error').val('0');
             this.focus();
             
             } else if (name.substr(0,20)=='frmProductDefaultImg' && (this.width < MIN_PRODUCT_IMAGE_WIDTH || this.height < MIN_PRODUCT_IMAGE_HEIGHT || this.width >MAX_PRODUCT_IMAGE_WIDTH || this.height > MAX_PRODUCT_IMAGE_HEIGHT || this.size > MAX_PRODUCT_IMAGE_SIZE)){
             alert('Please upload image in between ('+MIN_PRODUCT_IMAGE_WIDTH+'-'+MAX_PRODUCT_IMAGE_WIDTH+')px width and ('+MIN_PRODUCT_IMAGE_HEIGHT+'-'+MAX_PRODUCT_IMAGE_HEIGHT+')px height!');
             dd.parent().find('.image_error').val('0');
             this.focus();
             //$('#image_error').val(parseInt($('#image_error').val())+1);
             //return false;
             }else if (name.substr(0,13)=='frmProductImg' && (this.width < MIN_PRODUCT_IMAGE_WIDTH || this.height < MIN_PRODUCT_IMAGE_HEIGHT || this.width >MAX_PRODUCT_IMAGE_WIDTH || this.height > MAX_PRODUCT_IMAGE_HEIGHT || this.size > MAX_PRODUCT_IMAGE_SIZE)){
             alert('Please upload image in between ('+MIN_PRODUCT_IMAGE_WIDTH+'-'+MIN_PRODUCT_IMAGE_WIDTH+')px width and ('+MAX_PRODUCT_IMAGE_HEIGHT+'-'+MAX_PRODUCT_IMAGE_HEIGHT+')px height!');
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

            $(document).on('change', '.FetchFromDb', function () {
                var opnid = $(this).val();
                if ($(this).is(":checked")) {
                    var chkSrcPath = $('#existing_product_img_' + opnid).attr('src');
                    //if (!chkSrcPath) {
                    var popid = $($(this)).attr('Popup_ID');
                    var imgHdnId = $('#frmAttributeDefaultImg_' + opnid + '_' + popid).val();
                    var path = $('#frmAttributeDefaultImg_' + opnid + '_' + popid).attr('path');
                    console.log(opnid);
                    console.log(imgHdnId);
                    console.log(popid);
                    if (imgHdnId) {
                        $('#AttIconDefault_' + opnid + '_' + popid).append('<img id="dyn_img_' + opnid + '" width="25" height="25" src="' + path + '/' + imgHdnId + '">');
                        //}
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
        </script>
    </head>
    <body>

        <?php require_once 'inc/header_new.inc.php'; ?>

        <!-- Old code -->
        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Add Multiple Product</h1>
                        </div>
                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="category_manage_uil.php">Catalog</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="product_manage_uil.php">Manage Products</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <span>Add Multiple Product</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php
                    if ($_SESSION['sessUserType'] == 'super-admin' || in_array('add-products', $_SESSION['sessAdminPerMission'])) {
                        ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <?php
                                if ($objCore->displaySessMsg()) {
                                    echo $objCore->displaySessMsg();
                                    $objCore->setSuccessMsg('');
                                    $objCore->setErrorMsg('');
                                }
                                ?>
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>
                                            Add Multiple Product
                                        </h3>
                                        <a id="buttonDecoration" href="product_manage_uil.php" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>


                                    </div>
                                    <form action="" method="post" name="frm_page" id="frm_page" onsubmit="return validateMultipleProductAddForm('frm_page');" enctype="multipart/form-data" class='form-horizontal form-bordered'>
                                        <div class="box-content nopadding">
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <div class="box box-color box-bordered ">
                                                        <h5>Choose Wholesaler (under whom this product will be added) </h5>
                                                        <div class="nopadding">
                                                            <?php
                                                            if ($_SESSION['sessAdminCountry'] == '0') {
                                                                ?>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Country : </label>
                                                                    <div class="controls">
                                                                        <select name="frmCountryID" id="frmCountryID"  onchange="ShowWholesaler()" class='select2-me input-xlarge'>
                                                                            <option value="0">Select Country</option>
                                                                            <?php
                                                                            foreach ($objPage->arrCountryList as $valCT) {
                                                                                if (in_array($valCT['country_id'], $PortalIDs)) {
                                                                                    ?>
                                                                                    <option value="<?php echo $valCT['country_id']; ?>"><?php echo $valCT['name']; ?></option>
                                                                                <?php }
                                                                            } ?>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <input type="hidden" name="frmCountryID" id="frmCountryID" value="<?php echo $_SESSION['sessAdminCountry']; ?>" />
                                                            <?php }
                                                            // onchange="ShowWholesalerShippingGateway(this.value);"
                                                            ?>
                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">*Wholesaler Name: </label>
                                                                <div class="controls">
                                                                    <select name="frmfkWholesalerID" id="frmfkWholesalerID" class='select2-me input-xlarge'>
                                                                        <option value="0">Select Wholesaler</option>
                                                                    </select>
                                                                    <input type="hidden" name="frmMarginCast" id="frmMarginCast" value="<?php echo $objPage->arrMarginCost[0]['MarginCast']; ?>" />
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">*Shipping Gateway: </label>
                                                                <div class="controls">
                                                                    <div id="shippingGateways">Please Select Wholesaler</div>
                                                                    <input type="hidden" name="frmMarginCast" id="frmMarginCast" value="<?php echo $objPage->arrMarginCost[0]['MarginCast']; ?>" />
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dataTables_scrollBody" style="overflow: auto; width: 100%;">
                                                <table class="table table-bordered dataTable-scroll-x" id="MultipleProduct">
                                                    <thead>
                                                        <tr>
                                                            <th>*Product</th>
                                                            <th>*Price (in $)</th>
                                                            <th>Upload&nbsp;Product&nbsp;Images&nbsp;(600x600)</th>
                                                            <th>*Stock Quanity</th>
                                                            <th>*Category</th>
                                                            <th>Select Package</th>
                                                            <!--2nd-Sep-2014-->
                                                            <!--<th>Date</th>-->
                                                            <!--2nd-Sep-2014-->
                                                            <th>Weight</th>
                                                            <th>Dimensions</th>
                                                            <th>Details</th>
                                                            <th>Meta Details</th>
                                                            <th>More Details</th>
                                                            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input name="frmProductName[]" type="text" value="" placeholder="Product Name" class="input-medium"/>
                                                                <br /><br />
                                                                <input name="frmProductRefNo[]" type="text" value="" placeholder="Product Ref No." autocomplete="off" class="input-medium" onkeyup="checkProductRefNoForMultiple(this.value, 1);" onmousemove="checkProductRefNoForMultiple(this.value, 1);" onchange="checkProductRefNoForMultiple(this.value, 1);" />
                                                                <br/>
                                                                <span id="refmsg1" class="text-danger"><input type="hidden" name="frmIsRefNo[]" value="0" /></span>
                                                            </td>
                                                            <td>
                                                                <input name="frmWholesalePrice[]" id="frmWholesalePrice1" type="text" value="" placeholder="Wholesale Price" autocomplete="off" class="input-medium" onkeyup="showFinalPriceForMultipleProduct(1);" onchange="showFinalPriceForMultipleProduct(1);" />
                                                                <br/>
                                                                <span id="FinalPrice1"></span><input name="frmProductPrice[]" id="frmProductPrice1" type="hidden" value="" class="input" />
                                                                <br/> <br/>
                                                                <input name="frmDiscountPrice[]" id="frmDiscountPrice1" type="text" value="" placeholder="Discount Price" autocomplete="off" class="input-medium" onkeyup="showFinalDiscountPriceForMultipleProduct(1);" onchange="showFinalDiscountPriceForMultipleProduct(1);" />
                                                                <br/>
                                                                <span id="DiscountFinalPrice1"></span><input name="frmDiscountFinalPrice[]" id="frmDiscountFinalPrice1" type="hidden" value="" />

                                                            </td>
                                                            <td>
                                                                <div id="addinput_1">
                                                                    <div class="imgimg" id="11">
                                                                        <div class="responce"></div>
                                                                        <input type="file" name="file_upload[]" class="file_upload_multi" size="1" style="width:120px" />
                                                                        <span><a href="javascript:void(0);" onclick="addImage(1)" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>
                                                                        <a id="remNew" onclick="hideImg(1, 11)" href="javascript:void(0)" style="display: none"><img title="Remove" alt="Remove" src="images/minus.png"></a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input name="frmQuantity[]" type="text" value="" class="input-small" /><br>
                                                                <span class="text-danger">Quantity alert:</span><br>
                                                                <input type="text" name="frmQuantityAlert[]" value="" class="input-small"/>
                                                            </td>
                                                            <td>
    <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmfkCategoryID[]', 'frmfkCategoryID', array(0), 'Select Category', 0, ' onchange="ShowAttributeMultipleProduct(this.value,1);" class="select2-me input-medium"'); ?>
                                                                <br/>
                                                                <a onclick="return jscall(1)" href="#listed1" class="delete">Add Attribute</a>
                                                                <div style="display:none;">
                                                                    <div id="listed1">
                                                                        <div style="width: 95%; font-weight: bold;">Select Attributes</div>
                                                                        <div id="attribute1">
                                                                            <input type="hidden" name="frmIsAttribute[]" value="0" />Please Select Category
                                                                        </div>
                                                                        <br/>
                                                                        <input type="button" name="cancel1" id="cancel1" value="Ok" class="btn btn-blue"/>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <select name="frmfkPackageId[]" class='select2-me input-medium frmfkPackageId'>
                                                                    <option value="0">Select Package</option>
    <?php
    foreach ($objPage->arrPackageDropDown as $keyPackage => $valPackage) {
        ?>
                                                                        <option value="<?php echo $valPackage['pkPackageId']; ?>"><?php echo $valPackage['PackageName']; ?></option>
                                                                    <?php } ?>

                                                                </select>
                                                                <!--2nd-Sep-2014-->
                                                                <!--<br/>
                                                                <label class="checkbox"><input type="checkbox" name="frmIsFeatured[0]" value="1" />&nbsp;Featured </label>-->
                                                                <!--2nd-Sep-2014-->

                                                            </td>
                                                            <!--2nd-Sep-2014-->
                                                            <!--<td>
                                                                Date Start<br/>
                                                                <input type="text" name="frmDateStart[]" class="inputDate input-small" value="<?php //echo DATE_NULL_VALUE_SITE;    ?>" readonly="true" />
                                                                <br/><br/>
                                                                Date End<br/>
                                                                <input type="text" name="frmDateEnd[]" class="inputDate input-small" value="<?php //echo DATE_NULL_VALUE_SITE;    ?>" readonly="true" />
                                                            </td>-->
                                                            <!--2nd-Sep-2014-->
                                                            <td>
                                                                <select name="frmWeightUnit[]" class='select2-me input-small'>
                                                                    <option selected="selected" value="kg">Kilogram</option>
                                                                    <option value="g">Gram</option>
                                                                    <option value="lb">Pound </option>
                                                                    <option value="oz">Ounce</option>
                                                                </select>
                                                                <br/>
                                                                <input type="text" name="frmWeight[]" value="" placeholder="Weight" class="input-small" />
                                                            </td>
                                                            <td>
                                                                <select name="frmDimensionUnit[]" class='select2-me input-medium'>
                                                                    <option selected="selected" value="cm">Centimeter</option>
                                                                    <option value="mm">Millimeter</option>
                                                                    <option value="in">Inch</option>
                                                                </select>
                                                                <br/>
                                                                <input type="text" name="frmLength[]" value="" placeholder="Length" class="input-small" /><br>
                                                                <input type="text" name="frmWidth[]" value="" placeholder="Width" class="input-small" /><br>
                                                                <input type="text" name="frmHeight[]" value="" placeholder="Height" class="input-small" /><br>

                                                            </td>
                                                            <td>
                                                                <textarea name="frmProductDescription[]" rows="1" class="input-block-level textarea-small" placeholder="Description" maxlength="250"></textarea>
                                                                <br/>
                                                                <textarea name="frmProductTerms[]" rows="1" class="input-block-level textarea-small" placeholder="Terms & Condition"></textarea>
                                                                <br/>
                                                                <span class="text-danger">https://www.youtube.com/embed/ </span><br/>
                                                                <input type="text" name="frmYoutubeCode[]" placeholder="Youtube Code" class="input-medium"/>
                                                            </td>
                                                            <td>
                                                                <textarea name="frmMetaTitle[]" rows="1" class="input-block-level textarea-small" placeholder="Meta Title"></textarea>
                                                                <br/>
                                                                <textarea name="frmMetaKeywords[]" rows="1" class="input-block-level textarea-small" placeholder="Meta Keywords"></textarea>
                                                                <br/>
                                                                <textarea name="frmMetaDescription[]" rows="1" class="input-block-level textarea-small" placeholder="Meta Description" ></textarea>
                                                            </td>
                                                            <td>
                                                                <script type="text/javascript">
                                                                    var editor
                                                                    function createEditor(arg1) {
                                                                        if (editor)
                                                                            return;
                                                                        // Create a new editor inside the <div id="editor">, setting its value to html
                                                                        document.getElementById('shwhde' + arg1).innerHTML = '<input onclick="removeEditor(' + arg1 + ');" type="button" class="btn" value="Hide Editor" />';
                                                                        var config = {enterMode: CKEDITOR.ENTER_BR,
                                                                            toolbar: [['Bold'], ['Italic'], ['Strike'], ['Subscript'], ['Superscript'], ['RemoveFormat'], ['NumberedList'], ['BulletedList'], ['Link'], ['Unlink'],
                                                                                ['Table'], ['TextColor'], ['BGColor'], [['FontSize'], ['Font'], ['Styles']]]
                                                                        };
                                                                        var htm = document.getElementById('editorcontents' + arg1).innerHTML;
                                                                        // alert(htm);

                                                                        editor = CKEDITOR.appendTo('editor' + arg1, config, htm);

                                                                    }

                                                                    function removeEditor(arg1)
                                                                    {
                                                                        if (!editor)
                                                                            return;

                                                                        // Retrieve the editor contents. In an Ajax application, this data would be
                                                                        // sent to the server or used in any other way.
                                                                        document.getElementById('editorcontents' + arg1).innerHTML = editor.getData();
                                                                        document.getElementById('frmHtmlEditor' + arg1).innerHTML = editor.getData();
                                                                        //html = editor.getData();
                                                                        //document.getElementById( 'contents' ).style.display = '';

                                                                        // Destroy the editor.
                                                                        document.getElementById('shwhde' + arg1).innerHTML = '<input onclick="createEditor(' + arg1 + ');" type="button" class="btn" value="Show Editor" />';
                                                                        editor.destroy();
                                                                        editor = null;
                                                                    }

                                                                    //]]>
                                                                </script>
                                                                <span id="shwhde1"><input onclick="createEditor(1);" type="button" class="btn" value="Show Editor" /></span>
                                                                <div id="editorcontents1" style="display: none">

                                                                </div>
                                                                <div style="display: none">
                                                                    <textarea name="frmHtmlEditor[]" id="frmHtmlEditor1"></textarea>

                                                                </div>

                                                                <div id="editor1" style="z-index: 999; position: absolute; width:420px; margin-left: -220px"></div>
                                                            </td>
                                                            <td>
                                                                <i><span style="cursor: pointer;" onclick="addDynamicRowToTableForMultipleProduct('MultipleProduct');"><img src="images/plus.png" /></span></i>
                                                            </td>
                                                        </tr>


                                                    </tbody>
                                                </table>
                                                <table class="table table-bordered dataTable-scroll-x" id="MultipleProduct">
                                                    <tfoot>
                                                        <tr>
                                                            <td>Note : * Indicates mandatory fields.</td>
                                                        </tr>
                                                        <tr>
                                                            <td>

                                                                <input type="submit" class="btn btn-primary" name="btnPage" value="Upload Products"/>
                                                                <a id="buttonDecoration" href="product_manage_uil.php">
                                                                    <input type="button" class="btn btn-primary" name="btnTagSettings" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" /></a>
                                                                <input type="hidden" name="frmHidenAdd" id="frmHidenAdd" value="addMultiple" />
                                                                <input type="hidden" id="CropDynId" >
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                        </div>
                                    </form>
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
    </body>

</html>