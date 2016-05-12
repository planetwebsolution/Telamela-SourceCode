<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_MANAGE_PRODUCT_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo ADD_EDIT_PRODUCT_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <?php require_once INC_PATH . 'img_crop_js_css.inc.php'; ?>
<!--        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>browse.css"/>-->
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>cropic2.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>croppic.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH ?>browse.js"></script>
        <script type="text/javascript">
            ImageExist = '<?php echo count($objPage->productImages); ?>';
        </script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>product_add_edit.js"></script>
        <script type="text/javascript" src="<?php echo CKEDITOR_URL; ?>ckeditor.js"></script>
        <!-- select2 -->
        <link rel="stylesheet" href="<?php echo CSS_PATH ?>select2.css"/>
        <script src="<?php echo JS_PATH ?>select2.js"></script>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

<!--        <script  type="text/javascript" src="<?php echo JS_PATH ?>jquery.checkradios.min.js"></script>
<link rel="stylesheet" href="<?php echo CSS_PATH ?>jquery.checkradios.min.css" type="text/css"/>-->

        <!-- CheckRadios Usage Examples -->

        <script type="text/javascript">
            jQuery(document).ready(function () {
                // binds form submission and fields to the validation engine
                jQuery("#add_edit_product").validationEngine({
                    'custom_error_messages': {
                        'minCheckbox': {
                            'message': "*Please select atleast 1 option."
                        }, 'min': {
                            'message': "*Entered value should be greater than 1."
                        }
                    }
                });
                /*
                 $("#mulcountry").change(function () 
                 {
                 //alert("hii");
                 $('.mulcountries').css('display','block');
                 });
                 
                 $(".a").change(function () 
                 {
                 //alert("hii");
                 $('.mulcountries').css('display','none');
                 }  
                 );*/
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

                    $(".cnangevalue").html('');
                    $('#country_id').select2("val", "");
                    var unitofweight = $('select.weightunit option:selected').val();
                    var weight = $('input:text[name=Weight]').val();

                    var unitofDimention = $('select.lengthunit option:selected').val();
                    var Length = $('input:text[name=Length]').val();
                    var Width = $('input:text[name=Width]').val();
                    var Height = $('input:text[name=Height]').val();


                    var location = $('input[name=radio]:checked').val();
                    var Currentcountry = $('input:hidden[name=Currentcountry]').val();

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
                        $.post("admin/ajax.php", {
                            action: "getlogistcompaybyarea",
                            data: {unitweight: unitofweight, weightvalue: weight, unitlength: unitofDimention, Lengthvalue: Length, Widthvalue: Width, Heightvalue: Height, locationvalue: location, currentcountryid: Currentcountry,dimentionunit:unitofDimention},
                        }, function (e) {
                            $(".cnangevalue").html(e)
                            // $(".controles_" + jv + " .DyZoneDiv_" + jv).append(e)
                        })
                    }

                    if (location == 'multiple')
                    {

//                        $(document).on('change', '.multilecountries', function () {
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
                                $.post("admin/ajax.php", {
                                    action: "getlogistcompaybyarea",
                                    data: {unitweight: unitofweight, weightvalue: weight, unitlength: unitofDimention, Lengthvalue: Length, Widthvalue: Width, Heightvalue: Height, locationvalue: location, currentcountryid: Currentcountry, multiplecountriesvalue: multiplecountries,dimentionunit:unitofDimention},
                                }, function (e) {
                                    $(".cnangevalue").html(e)
                                    // $(".controles_" + jv + " .DyZoneDiv_" + jv).append(e)
                                })
                            }

                        }

                    }


                });
                $(document).on('change', '.multilecountries', function () {

                    var unitofweight = $('select.weightunit option:selected').val();
                    var weight = $('input:text[name=Weight]').val();

                    var unitofDimention = $('select.lengthunit option:selected').val();
                    var Length = $('input:text[name=Length]').val();
                    var Width = $('input:text[name=Width]').val();
                    var Height = $('input:text[name=Height]').val();


                    var location = $('input[name=radio]:checked').val();
                    var Currentcountry = $('input:hidden[name=Currentcountry]').val();

                    var multiplecountries = [];
                    $("#country_id option:selected").each(function (i) {
                        multiplecountries.push($(this).val());
                    });
                    console.log(multiplecountries);
                    if (multiplecountries != '')
                    {
                        $.post("admin/ajax.php", {
                            action: "getlogistcompaybyarea",
                            data: {unitweight: unitofweight, weightvalue: weight, unitlength: unitofDimention, Lengthvalue: Length, Widthvalue: Width, Heightvalue: Height, locationvalue: location, currentcountryid: Currentcountry, multiplecountriesvalue: multiplecountries,dimentionunit:unitofDimention},
                        }, function (e) {
                            $(".cnangevalue").html(e)
                            // $(".controles_" + jv + " .DyZoneDiv_" + jv).append(e)
                        })
                    }

                });
                //changeradio
                jQuery(".select2-me").select2();
                // jQuery('.checkradios').checkradios();
                //inputtxt.value.toFixed(2);

            });

        </script>


        <style>
            .customfile1-button{ width:124px}
            #productRow tr{ height:44px;}
            .th_box th{color:#666; line-height:40px;}
            .th_box th:first-child{ background:none; border:none; color:#fff; line-height:40px;}
            .input_star .star_icon{ right:1px; position:absolute;}
            .input_sec span{padding:0px;}.datepick-trigger{margin: 31px 0 0 -19px; position: relative;} .dashboard_title{background:#60494A; color: rgb(255, 255, 255); padding: 0px 9px; border-radius: 4px 4px 4px 4px; margin: 0px 0px 9px; width: 114%;}
            #cboxLoadedContent{margin-top:-2px !important; /* height: 350px; */} .imgimg{float: left; width: 100%}.input_sec .select2-choice span{padding: 3px;}
            /*            .back_ankar_sec{ width:7.5%;}*/
            .mulcountries{display: none;padding-top: 10px};
            .new_txt{ border-bottom: 1px solid #e7e7e7;
                      color: #414141;
                      font: 600 18px/24px "Open Sans",sans-serif;
                      margin-bottom: 10px;
                      padding-bottom: 10px;
                      text-transform: uppercase;}
            .stylish-select .drop4 .newListSelected{width:464px}
            .mandatory{color:red;}
            .stylish-select .drop4 .selectedTxt {
                background: url("common/images/select2.png") no-repeat scroll 112% 5px #fff;
                width: 412px;}
            #sel_box_edit .newListSelected{width:106px}
            #sel_box_edit .selectedTxt{background: url("common/images/select2.png") no-repeat scroll 278% 5px #fff; width: 64px;}
            textarea{border:1px solid #dcdcdc; box-sizing:border-box; padding:8px;}
            .select2-container .select2-choice span{background: url("common/images/select2.png") no-repeat scroll 110% 2px #fff;    width: 100%;}
            .customfile1-button{ box-sizing: border-box; line-height:38px; padding-left:2px;}
            .delete_icon3{float:left;}
            .stylish-select .drop4 .selectedTxt{ height:31px; line-height:30px }
            .selectedTxt1{ background: url("common/images/select2.png") no-repeat scroll 156% 8px #fff; height:38px;}
            #Weight.input1{width:332px;}
            .input1{ height:32px;}
            .rdmsg{float: left;}
            .specialPrice{width: 100%; clear: both; display: inline-block;}
            @media screen and (max-width: 768px){
                .rdmsg{float: none; margin-top: .5em;}
                #add_edit_product input.text5.inputwdth{width: 100% !important;}
                .input_star.kgg{margin-left: 10px;}
                input_sec.default_img{clear:both;float:left;}

            }

        </style>
        <script src="<?php echo JS_PATH ?>jquery.dd.js"></script>
        <!--Below js are related to crop image -->
        <script type="text/javascript" src="<?php echo JS_PATH ?>bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.mousewheel.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>croppic.min.product.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>main.js"></script>
    </head>
    <body>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>


        <div class="header" style="border-bottom:none"><div class="layout"></div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>

        </div>

        <div id="ouderContainer" class="ouderContainer_1"><div style="width:100%;height:50px; padding-top:16px;border-bottom:1px solid #e7e7e7;" class="wholesalerHeaderSection"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">
                <div class="add_pakage_outer">
                    <div class="top_container">
                        <!--<a href="<?php echo $objCore->getUrl('bulk_uploads.php'); ?>" class="multiple_link"><?php echo UP_PRODUCTS; ?></a>-->
                        <a href="<?php echo $objCore->getUrl('bulk_uploads.php', array('action' => 'addMutiple')); ?>" class="multiple_link"><?php echo BULK_UPLOAD_TITLE; ?></a>
                        <div class="back_ankar_sec">
                            <?php
                            if (isset($_GET['action']) && $_GET['action'] == 'edit') {
                                if (isset($_SESSION['query_string']['wholesaler']['products_listing']) && $_SESSION['query_string']['wholesaler']['products_listing'] != '') {
                                    ?>
                                    <a href="<?php echo $objCore->getUrl('manage_products.php?' . $_SESSION['query_string']['wholesaler']['products_listing']); ?>" class="back_multiple"><span><?php echo BACK; ?></span>                                    
                                    <?php } else { ?>
                                        <a href="<?php echo $objCore->getUrl('manage_products.php'); ?>" class="back_multiple"><span><?php echo BACK; ?></span>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <a href="<?php echo $objCore->getUrl('manage_products.php'); ?>" class="back_multiple"><span><?php echo BACK; ?></span>
                                        <?php } ?>


                                    </a>
                                    </div>
                                    </div>

                                    <?php $product = $objPage->productDetail[0]; ?>
                                    <?php $productmulcountrydetail = $objPage->productmulcountrydetail; ?>
                                    <?php
                                    //pre($productmulcountrydetail);
                                    ?>

                                    <div class="body_inner_bg">
                                        <form name="add_edit_product" id="add_edit_product" action="" onsubmit="return ValidateForm();" method="POST" enctype="multipart/form-data">
                                            <div id="add_edit_pakage_my" class="add_edit_pakage">

                                                <div class="edit_container" style="margin-top:10px;"><div class="mandatory"><span>*</span> Fields are required</div>
                                                    <div class="left_section"> <label><?php echo PROD_NAME; ?></label>  <div class="input_sec input_star input_boxes">
                                                            <input class="validate[required,maxSize[100]]" type="text" name="ProductName" value="<?php echo $_POST['ProductName'] ? $_POST['ProductName'] : $product['ProductName']; ?>" data-validation-placeholder="Company name"/>
                                                            <small class="star_icon" style=" right:-58px"><img src="common/images/star_icon.png" alt=""/></small>
                                                        </div></div>

                                                    <div class="right_section" style="width:473px; float:left; margin-left:112px">   <label><?php echo PRO_REF_NO; ?></label>
                                                        <div class="input_sec input_star input_boxes">
                                                            <input onkeyup="checkProductRefNoForMultiple(this.value, 1,<?php echo (int) $product['pkProductID']; ?>);" onmousemove="checkProductRefNoForMultiple(this.value, 1,<?php echo (int) $product['pkProductID']; ?>);" onchange="checkProductRefNoForMultiple(this.value, 1,<?php echo (int) $product['pkProductID']; ?>);" class="validate[required]" type="text" name="ProductRefNo" id="ProductRefNo" value="<?php echo $_POST['ProductRefNo'] ? $_POST['ProductRefNo'] : $product['ProductRefNo'] ?>" />
                                                            <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                                            <span id="refmsg1"><input type="hidden" name="frmIsRefNo[]" value="0" /></span>
                                                        </div></div>




                                                    <div class="cb"></div>
                                                    <ul class="left_sec">
                                                        <br />
                                                        <?php
                                                        if ($_REQUEST['action'] == 'add') {
                                                            ?>
                                                            <li>

                                                            </li>
                                                            <?php
                                                        } else {
                                                            echo '<input type="hidden" name="frmIsRefNo[]" value="0" />';
                                                        }
                                                        ?>

                                                        <li>
                                                            <label style="width:100%;"><?php echo CATEGORY_TITLE; ?> </label>
                                                            <div class="input_sec input_star input_boxes">
                                                                <div class="ErrorfkCategoryID" style="display: none;"></div>
                                                                <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryList, 'fkCategoryID', 'fkCategoryID', array($product['fkCategoryID']), 'Select Category', 0, 'onchange="showAttribute(this.value);" class="select2-me" style="width:100%"', '1', '1'); ?>
                                                                <small class="star_icon" style=" right:0px ; top:10px;"><img src="common/images/star_icon.png" alt=""/></small>
                                                            </div>
                                                        </li>


                                                        <li>
                                                            <?php
//pre($product);
                                                            if ($_REQUEST['action'] == 'add') {
                                                                ?>
                                                                <label style="width:100%;">Product Type: </label>
                                                                <input type="checkbox" name="dangerous" value="dangerous">Dangerous &nbsp;&nbsp;

                                                                    <input type="checkbox" name="fragile" value="fragile"  > Fragile

                                                                        <?php
                                                                    } elseif ($_REQUEST['action'] == 'edit') {
                                                                        ?>
                                                                        <label style="width:100%;">Product Type: </label>
                                                                        <input type="checkbox" name="dangerous" <?php echo ($product['productdangerous'] == 'dangerous') ? 'checked' : ''; ?> value="dangerous">Dangerous &nbsp;&nbsp;

                                                                            <input type="checkbox" name="fragile" <?php echo ($product['productfragile'] == 'fragile') ? 'checked' : ''; ?>  value="fragile"  > Fragile 
                                                                            <?php } ?>
                                                                            </li>
                                                                            </ul>
                                                                            <?php /*

                                                                              <li>
                                                                              <label><?php echo CATEGORY_TITLE; ?> </label>
                                                                              <div class="input_sec input_star">
                                                                              <div class="drop4 dropdown_2">
                                                                              <div class="ErrorfkCategoryID" style="display: none;"></div>
                                                                              <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryList, 'fkCategoryID', 'fkCategoryID', array($product['fkCategoryID']), 'Select Category', 0, 'onchange="showAttribute(this.value);" class="drop_down1"', '1'); ?>
                                                                              </div>
                                                                              <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                                                              </div>
                                                                              <script> $(document).ready(function(e) {$("select").msDropdown({roundedBorder:false});}); </script>
                                                                              </li>
                                                                             */ ?>


                                                                            <ul>
                                                                                <li>
                                                                                    <div class="full_section padding-10" style="overflow:hidden;"><label style="width:100%; border-top:1px solid #eee; line-height:60px;"><?php echo ATTR; ?></label>
                                                                                        <div id="attribute"  style="width:100%;" class="attributeClass">
                                                                                            <?php
                                                                                            $strImgScript = '';
                                                                                            if ($objPage->arrAttribute) {
                                                                                                $varStr = '<input type="hidden" name="frmIsAttribute" value="1" class="input2" />';
                                                                                                foreach ($objPage->arrAttribute as $keyAttr => $valueAttr) {

                                                                                                    if ($valueAttr['AttributeInputType'] == 'select' || $valueAttr['AttributeInputType'] == 'radio' || $valueAttr['AttributeInputType'] == 'checkbox') {
                                                                                                        if ($valueAttr['OptionsRows'] > 0) {
                                                                                                            $varStr .= '<div class="product_attr"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . ') &nbsp; &nbsp; &nbsp; :</div>';
                                                                                                            foreach ($valueAttr['OptionsData'] as $keyOpt => $valueOpt) {
                                                                                                                $optIdInd = (string) array_search($valueOpt['pkOptionID'], $objPage->arrProductOpt['optid']);

                                                                                                                if (in_array($valueOpt['pkOptionID'], $objPage->arrProductOpt['optid'])) {
                                                                                                                    $varcheck = 'checked';
                                                                                                                    $varCaptionInput = '<input type="text" name="frmOptCaption[' . $valueOpt['pkOptionID'] . ']" value="' . $objPage->arrProductOpt['optCaption'][$optIdInd] . '" style="width:100px;margin-bottom:5px;">';
                                                                                                                    $varExtraPrice = '<input type="hidden" name="frmOptExtraPrice[' . $valueOpt['pkOptionID'] . ']" value="' . $objPage->arrProductOpt['optExtraPrice'][$optIdInd] . '">';
                                                                                                                } else {
                                                                                                                    $varcheck = '';
                                                                                                                    $varCaptionInput = '';
                                                                                                                    $varExtraPrice = '';
                                                                                                                }
                                                                                                                $varStr .= '<div class="product_attr_options">' . $varExtraPrice . '<input type="checkbox" name="frmAttribute[' . $keyAttr . '][]" value="' . $valueOpt['pkOptionID'] . '" ' . $varcheck . ' caption="' . $valueOpt['OptionTitle'] . '" class="otherstype checkradios" />&nbsp;' . $valueOpt['OptionTitle'] . '<div class="res_caption">' . $varCaptionInput . '</div></div>';
                                                                                                            }
                                                                                                            $varStr .='</div>';
                                                                                                        }
                                                                                                    } if ($valueAttr['AttributeInputType'] == 'image') {
                                                                                                        if ($valueAttr['OptionsRows'] > 0) {
                                                                                                            $varStr .= '<div class="product_attr"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</div>';
                                                                                                            foreach ($valueAttr['OptionsData'] as $keyOpt => $valueOpt) {
                                                                                                                $optIdInd = (string) array_search($valueOpt['pkOptionID'], $objPage->arrProductOpt['optid']);

                                                                                                                if (in_array($valueOpt['pkOptionID'], $objPage->arrProductOpt['optid'])) {
                                                                                                                    $varcheck = 'checked';
                                                                                                                    $varCaptionInput = '<input type="text" name="frmOptCaption[' . $valueOpt['pkOptionID'] . ']" value="' . $objPage->arrProductOpt['optCaption'][$optIdInd] . '" style="width:100px;margin-bottom:5px;">';
                                                                                                                    $varExtraPrice = '<input type="hidden" name="frmOptExtraPrice[' . $valueOpt['pkOptionID'] . ']" value="' . $objPage->arrProductOpt['optExtraPrice'][$optIdInd] . '" >';
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

                                                                                                                $varStr .= '<div class="product_attr_img_options">' . $varExtraPrice . '<input type="checkbox" name="frmAttribute[' . $keyAttr . '][]" value="' . $valueOpt['pkOptionID'] . '"  ' . $varcheck . ' caption="' . $valueOpt['OptionTitle'] . '" class="imagetype" />
                                                                <input type="hidden" name="frmAttributeImgUploaded[' . $keyAttr . '][' . $valueOpt['pkOptionID'] . ']" value="' . $defAttrImgUp . '" />
                                                                    <input type="hidden" name="frmAttributeDefaultImg[' . $keyAttr . '][' . $valueOpt['pkOptionID'] . ']" value="' . $defAttrImgVal . '" />&nbsp;' . $valueOpt['OptionTitle'] . '
                                                                <img src="' . $objCore->getImageUrl($objPage->arrProductOpt['optimg'][$optIdInd], 'products/' . $arrProductImageResizes['default']) . '" width="25" height="25" />
                                                                <div class="res_attr">';
                                                                                                                if ($varcheck <> '') {
                                                                                                                    $varStr .= '<div class="responce"></div>' . $varCaptionInput; //'<input name="file_upload_attr[' . $valueOpt['pkOptionID'] . ']" class="file file_upload_attr" id="fileAttr' . $valueOpt['pkOptionID'] . '" type="file" />';
                                                                                                                }
                                                                                                                $varStr .='</div></div>';

                                                                                                                //$strImgScript .= '$("#fileAttr' . $valueOpt['pkOptionID'] . '").customFileInput1();';
                                                                                                            }
                                                                                                            $varStr .='</div>';
                                                                                                        }
                                                                                                    } else if ($valueAttr['AttributeInputType'] == 'text') {
                                                                                                        $optIdInd = array_search($valueAttr['OptionsData']['0']['pkOptionID'], $objPage->arrProductOpt['optid']);
                                                                                                        $varStr .= '<div class="product_attr" id="textInput"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</div><input type="text" name="frmAttributeText[' . $keyAttr . '-' . $valueAttr['OptionsData']['0']['pkOptionID'] . ']" value="' . $objPage->arrProductOpt['optval'][$optIdInd] . '" class="input2 input_boxfix" /><span style="cursor: pointer;" onclick="hideInputType(' . "'" . 'textInput' . "'" . ');"><img src="admin/images/my_minus.png" alt="Remove" title="Remove" /></span></div>';
                                                                                                    } else if ($valueAttr['AttributeInputType'] == 'textarea') {
                                                                                                        $optIdInd = array_search($valueAttr['OptionsData']['0']['pkOptionID'], $objPage->arrProductOpt['optid']);
                                                                                                        $varStr .= '<div class="product_attr" id="textAreaInput"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</div><textarea name="frmAttributeTextArea[' . $keyAttr . '-' . $valueAttr['OptionsData']['0']['pkOptionID'] . ']" rows="3" class="input3">' . $objPage->arrProductOpt['optval'][$optIdInd] . '</textarea><span onclick="hideInputType(' . "'" . 'textAreaInput' . "'" . ');"><img src="admin/images/my_minus.png" alt="Remove" title="Remove" align="top" /></span></div>';
                                                                                                    }
                                                                                                }
                                                                                            } else {
                                                                                                $varStr = '<input type="hidden" name="frmIsAttribute" value="0" class="input2" /><span class="req" style="padding-top:12px;">' . NO_ATTR . '</span>';
                                                                                            }
                                                                                            echo $varStr;
                                                                                            ?>
                                                                                        </div>
                                                                                        <br />

                                                                                    </div>
                                                                                </li>

                                                                                <li class="">
                                                                                    <?php
                                                                                    $priceDisplay = 'display:none;';
                                                                                    if (count($objPage->specialEvents) > 0) {
                                                                                        $priceDisplay = 'display:block;';
                                                                                        $varStr = '<label><b>' . SPECIAL_EVENT . '</b></label><div class="check_box" style="margin-top: 10px;">';
                                                                                        foreach ($objPage->specialEvents as $key => $val) {
                                                                                            $sel = ($objPage->specialProduct['fkFestivalID'] == $val['fkFestivalID']) ? 'checked="checked"' : '';
                                                                                            $varStr .= '<input style="float:left;" type="radio" name="frmSpecialEvents" ' . $sel . ' value="' . $val['fkFestivalID'] . '" /><small style=" font-weight:bold;">' . $val['FestivalTitle'] . '</small><br/>';
                                                                                        }
                                                                                        $varStr .='</div>';
                                                                                        echo $varStr;
                                                                                    }
                                                                                    ?>
                                                                                </li>



                                                                                <li style="<?php echo $priceDisplay; ?>" class="specialPrice">
                                                                                    <div class="left_section">
                                                                                        <label><b><?php echo SPECIAL_PRICE; ?></b></label><br>
                                                                                            <div>
                                                                                                <!--<span style="font-size:10px;"><?php echo SEL_CURR; ?>:</span><br />-->
                                                                                                <div style="width:100%; float:left;" class="drop2">
                                                                                                    <div class="seltd_box">
                                                                                                        <select class="drop_dodwn1 selectedTxt1" name="frmCurrency" id="frmCurrency0"  onchange="showCurrencyInUSD(0);">
                                                                                                            <?php
                                                                                                            foreach ($arrCurrencyList as $ck => $cv) {
                                                                                                                // $cselected = ($_SESSION['SiteCurrencyCode'] == $ck) ? 'selected="selected"' : '';
                                                                                                                echo '<option value="' . $ck . '" >' . $ck . '</option>';
                                                                                                            }
                                                                                                            ?>
                                                                                                        </select>
                                                                                                    </div>

                                                                                                    <div class="new_input_bx">
                                                                                                        <input numericOnly="yes" onchange="showCurrencyInUSD(0);" onkeyup="showCurrencyInUSD(0);" style="width: 70px!important; margin: 0px 15px 0px 6px;" id="frmWholesalePrice0" type="text" name="SpecialEventsPrice" value="<?php echo $_POST['SpecialEventsPrice'] ? $_POST['SpecialEventsPrice'] : $objPage->specialProduct['SpecialPrice'] ?>"  class="validate[lessThan[frmWholesalePrice1]] text5"/>
                                                                                                    </div>
                                                                                                    <div class="newcurnc_info">
                                                                                                        <span style="font-size:13px;"><?php echo SPECIAL_PRICE_IN_USD; ?></span>
                                                                                                        <span id="InUSD0"><?php echo '$' . $objPage->specialProduct['SpecialPrice'] ?></span>
                                                                                                    </div><br/>
                                                                                                    <input id="frmWholesalePriceInUSD0" type="hidden" value="<?php echo $objPage->specialProduct['SpecialPrice']; ?>" name="SpecialEventsPrice"/>
                                                                                                    <span style="font-size:13px;"><?php echo FINAL_SPECIAL_PRICE_IN_USD; ?></span>
                                                                                                    <span id="FinalPriceInUSD0"><?php echo '$' . $objPage->specialProduct['FinalSpecialPrice']; ?></span>
                                                                                                    <input id="frmProductPrice0" type="hidden" readonly="true" value="<?php echo $objPage->specialProduct['FinalSpecialPrice']; ?>" name="FinalSpecialEventsPrice"/>

                                                                                                </div></div></div></li>







                                                                                <li style="padding-top: 20px;"><div class="">     <label style="width:100%"><?php echo WHOL_PRICE; ?></label><br />
                                                                                        <div>
                                                                                            <!--<span class="curr_txt"><?php echo SEL_CURR; ?>:</span>-->
                                                                                            <div style="width:100%; float:left;" class="drop2">
                                                                                                <div class="seltd_box">
                                                                                                    <select class="selectedTxt1" name="frmCurrency" id="frmCurrency1" onchange="showCurrencyInUSD(1);">
                                                                                                        <?php
                                                                                                        foreach ($arrCurrencyList as $ck => $cv) {
                                                                                                            // $cselected = ($_SESSION['SiteCurrencyCode'] == $ck) ? 'selected="selected"' : '';
                                                                                                            echo '<option value="' . $ck . '" >' . $ck . '</option>';
                                                                                                        }
                                                                                                        ?>
                                                                                                    </select>                                                            
                                                                                                </div>
                                                                                                <div class="new_input_bx">
                                                                                                    <input numericOnly="yes" onchange="showCurrencyInUSD(1);" onkeyup="showCurrencyInUSD(1);" style="width: 70px!important; margin: 0px 15px 0px 6px; height:38px;" id="frmWholesalePrice1" class="validate[required,min[1]] text5" type="text" name="WholesalePrice" value="<?php echo $_POST['WholesalePrice'] ? $_POST['WholesalePrice'] : number_format($product['WholesalePrice'], 2) ?>"/></div>
                                                                                                <div class="newcurnc_info">
                                                                                                    <span style="font-size:13px;"><?php echo PRICE_IN_USD; ?></span>
                                                                                                    <span id="InUSD1"><?php echo '$' . $product['WholesalePrice'] ?></span>
                                                                                                </div>
                                                                                                <input id="frmWholesalePriceInUSD1" class="input1" type="hidden" value="<?php echo $product['WholesalePrice'] ?>" name="WholesalePrice"/><br />
                                                                                                <span style="font-size:13px;color:#666666 !important;"><?php echo FINAL_PRODUCT_PRICE; ?></span>
                                                                                                <span id="FinalPriceInUSD1"><?php echo '$' . $product['FinalPrice'] ?></span>
                                                                                                <input id="frmProductPrice1" class="input1" type="hidden" readonly="true" value="<?php echo $product['FinalPrice'] ?>" name="FinalPrice"/>
                                                                                            </div>
                                                                                            <div>


                                                                                            </div>
                                                                                        </div>
                                                                                    </div>


                                                                                    <div class="">  <label style="width:100%"><?php echo DIS_PRICE; ?></label>

                                                <!--<span class="curr_txt"><?php echo SEL_CURR; ?>:</span>-->
                                                                                        <div style="width: 100%;float: left;" class="drop2">
                                                                                            <div class="new_input_bx">
                                        <!--                                                        <select disabled class="selectedTxt1" name="frmCurrency2" id="frmCurrency2" onchange="showCurrencyInUSD(2);">
                                                                                                <?php
                                                                                                foreach ($arrCurrencyList as $ck => $cv) {
                                                                                                    // $cselected = ($_SESSION['SiteCurrencyCode'] == $ck) ? 'selected="selected"' : '';
                                                                                                    echo '<option value="' . $ck . '" >' . $ck . '</option>';
                                                                                                }
                                                                                                ?>
                                                                                                </select>-->
                                                                                                <input disabled style=" margin-top:0px; margin-right:10px;width: 70px !important;height:38px;background-color: #fff;"  type="text" name="frmCurrency2" id="frmCurrency2" value="<?php echo 'USD' ?>"  class="text5"/>
                                                                                            </div>
                                                                                            <div class="new_input_bx">
                                                                                                <input numericOnly="yes" onchange="showCurrencyInUSD(2);" onkeyup="showCurrencyInUSD(2);" style=" margin-top:0px; margin-right:10px;margin-left:10px;width: 70px !important;height:38px;" id="frmWholesalePrice2" type="text" name="DiscountPrice" value="<?php echo $_POST['DiscountPrice'] ? $_POST['DiscountPrice'] : number_format($product['DiscountPrice'], 2) ?>"  class="validate[lessThan[frmWholesalePrice1]] text5"/>
                                                                                            </div>
                                                                                            <div class="newcurnc_info">
                                                                                                <span style="font-size:13px;"><?php echo PRICE_IN_USD; ?></span>
                                                                                                <span id="InUSD2"><?php echo '$' . $product['DiscountPrice'] ?></span>
                                                                                                <input id="frmWholesalePriceInUSD2" class="input1" type="hidden" value="<?php echo $product['DiscountPrice'] ?>" name="DiscountPrice" /><br />

                                                                                                <span style="font-size:13px;"><?php echo FINAL_PRODUCT_PRICE; ?></span>
                                                                                                <span id="FinalPriceInUSD2"><?php echo '$' . $product['DiscountFinalPrice'] ?></span>
                                                                                                <input id="frmProductPrice2" class="input1" type="hidden" readonly="true" value="<?php echo $product['DiscountFinalPrice'] ?>" name="DiscountFinalPrice" /></div>
                                                                                            <div>

                                                                                            </div>
                                                                                        </div>



                                                                                </li>
                                                                                <li>

                                                                                </li>
                                                                                <?php
                                                                                if (count($objPage->productImages) > 0) {
                                                                                    ?>
                                                                                    <li><label>&nbsp;</label>
                                                                                        <div class="input_sec default_img" >
                                                                                            <?php
                                                                                            foreach ($objPage->productImages as $vImg) {
                                                                                                if ($vImg['ImageName'] <> '') {
                                                                                                    ?>
                                                                                                    <div style="width: 95px; float: left; border:1px solid #929291; margin: 0 5px 5px 0; clear:both;" class="editDefaultOuter">
                                                                                                        <div stle="width:100%; float:left; box-sizing:border-box;" id="img<?php echo $vImg['pkImageID']; ?>">
                                                                                                            <a href="<?php echo $objCore->getImageUrl($vImg['ImageName'], 'products/original'); ?>" target="_blank">
                                                                                                                <img src="<?php echo $objCore->getImageUrl($vImg['ImageName'], 'products/' . $arrProductImageResizes['default']); ?>" border="1" />
                                                                                                            </a>

                                                                                                            &nbsp;&nbsp;
                                                                                                            <?php
                                                                                                            if ($product['ProductImage'] == $vImg['ImageName']) {
                                                                                                                $ckd = 'checked="checked"';
                                                                                                            } else {
                                                                                                                $ckd = '';
                                                                                                                ?>
                                                                                                                <span style="cursor: pointer;" onclick="deleteImage(<?php echo $vImg['pkImageID']; ?>)">
                                                                                                                    <img src="<?php echo SITE_ROOT_URL . 'admin/images/cross.png'; ?>" alt="Delete" title="Delete" />
                                                                                                                </span>
                                                                                                            <?php } ?>
                                                                                                            <div style="width: 100%; float: left; padding: 5px;">
                                                                                                                <input type="radio" name="default" class="default" value="<?php echo $vImg['ImageName'] ?>" <?php echo $ckd; ?> />Default
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    <?php }
                                                                                                    ?>
                                                                                                </div>
                                                                                                <?php
                                                                                            }
                                                                                            ?>

                                                                                        </div>
                                                                                    </li>
                                                                                <?php } ?>
                                                                                <li>
                                                                                    <div class="full_section padding-10" >    <label style="width:100%"><?php echo PRO_IMAGE_600_800 . " (Atleast One image is " . REQUIRED . ")"; ?></label>


                                                                                        <div class="uploadImageouter" style="width:600px; float:left;">
                                                                                            <a href="#cropimg_1" onclick="jCroppicPopupOpen('cropimg', 1, 'croppicLogo')" class="cropimg" style="z-index:9999999; float:left;">Upload Image</a>
                                                                                            <div id="cropimg_1" style="display:none;"></div>    
                                                                                            <input type="hidden" name="frmProductImg[]" id="after_cropimg_1" value=""/>
                                                                                            <span class="defaultRadio"><input type="radio" name="default" class="default" value="" id="after_cropimg_default_1"/> <span class="innerDefault">Default</span></span>    
                                                                                            <a href="#" class="more more_images"><small><?php echo ADD_MORE; ?></small> +</a>
                                                                                        </div>



                                                                                        <div class="more_image_to_crop"></div>


                                                                                        <!--  <div class="">
                                                                                            <div class="imgimg">
                                                                                                <div class="responce"></div>
                                                                                                                                                        <input class="customfile1-input file file_upload" id="file1" type="file" name="file_upload[]" style="top: 0; left: 0px!important;"/>
                                                                                                                                                        <a href="#" style="z-index:9999999" class="more more_images"><small><?php echo ADD_MORE; ?></small> +</a>
                                                                                                <a href="#" class="delete_icon3" style="display: none;"></a>
                                                                                            </div>
                                                                                        </div>-->
                                                                                    </div>
                                                                                </li>
                                                                                <li>
                                                                                    <div class="left_section"><label><?php echo STOCK_QUAN; ?></label>
                                                                                        <div class="input_sec input_star input_boxes">
                                                                                            <input numericOnly="yes" class="validate[required,custom[integer],min[1]]" type="text" name="Quantity" id="Quantity" value="<?php echo $_POST['Quantity'] ? $_POST['Quantity'] : $product['Quantity'] ?>"/>
                                                                                            <small class="star_icon" style="right:-46px"><img src="common/images/star_icon.png" alt=""/></small></div>  </div>
                                                                                    <div class="right_section">
                                                                                        <div class="rdmsg"><label style="width:100%; color:red; font-weight:100"><?php echo SEND_ALERT_MESSAGE; ?></label></div>
                                                                                        <input numericOnly="yes" type="text" name="QuantityAlert" class="validate[lessThan[Quantity],min[1]] text5 inputwdth"  value="<?php echo $_POST['QuantityAlert'] ? $_POST['QuantityAlert'] : $product['QuantityAlert'] ?>" /></div>


                                                                                </li>

                                                                                <li style="float:left; width:100%;">
                                                                                    <label class="leb_margin"><?php echo SEL_PACK; ?></label>
                                                                                    <div class="full_section padding-10">
                                                                                        <div class="drop4 dropdown_2" id="packages">
                                                                                            <select name="fkPackageId" class="drop_down1">
                                                                                                <option value="0"><?php echo SEL_PACK; ?></option>
                                                                                                <?php
                                                                                                foreach ($objPage->packageList as $key => $val) {
                                                                                                    $selected = $val['pkPackageId'] == $product['fkPackageId'] ? 'selected' : '';
                                                                                                    echo '<option ' . $selected . ' value="' . $val['pkPackageId'] . '">' . $val['PackageName'] . '</option>';
                                                                                                }
                                                                                                ?>
                                                                                            </select> 
                                        <!--                                                    <a href="#packageAddBox" onclick="return jscallPackageAddBox()" class="more create_pkg_color_box"><small><?php echo CREATE_NEW_PACKAGE; ?></small></a>-->
                                                                                            <a href="<?php echo SITE_ROOT_URL; ?>add_new_package.php?&action=add" target="_blank" title="After create your package, Kindly refresh your page to view package in drop down."><small class="create_add"><?php echo CREATE_NEW_PACKAGE; ?></small></a>
                                                                                        </div>

                                                                                    </div>
                                                                                </li>
                                                                                <li>

                                                                                </li>
                                                                                <li> <div class="left_section cb"> <label class="leb_margin"><?php echo WAIGHT; ?> </label>
                                                                                        <div>
                                                                                            <div id="sel_box_edit" class="drop4" style="width:100%;">
                                                                                                <select class="drop_down1 weightunit" name="WeightUnit">
                                                                                                    <option value="kg" <?php
                                                                                                    if ($product['WeightUnit'] == 'kg') {
                                                                                                        echo 'selected="selected"';
                                                                                                    }
                                                                                                    ?>><?php echo KIL; ?></option>
                                                                                                    <option value="g" <?php
                                                                                                    if ($product['WeightUnit'] == 'g') {
                                                                                                        echo 'selected="selected"';
                                                                                                    }
                                                                                                    ?>><?php echo GRA; ?></option>
                                                                                                    <option value="lb" <?php
                                                                                                    if ($product['WeightUnit'] == 'lb') {
                                                                                                        echo 'selected="selected"';
                                                                                                    }
                                                                                                    ?>><?php echo POU; ?></option>
                                                                                                    <option value="oz" <?php
                                                                                                    if ($product['WeightUnit'] == 'oz') {
                                                                                                        echo 'selected="selected"';
                                                                                                    }
                                                                                                    ?>><?php echo OUN; ?></option>
                                                                                                </select>
                                                                                                <div class="input_star kgg">
                                                                                                    <input numericOnly="yes" type="text" name="Weight" id="Weight" value="<?php echo $product['Weight']; ?>" class="validate[required,min[1]] input1" />
                                                                                                    <small class="star_icon" style=" right:0px"><img alt="" src="common/images/star_icon.png"></small>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div></div>
                                                                                    <div class="right_section"> <label class="leb_margin"><?php echo DIMEN; ?></label>
                                                                                        <div>
                                                                                            <div id="sel_box_edit" class="drop4" style="width:100%;">
                                                                                                <select class="drop_down1 lengthunit" name="DimensionUnit" style="width:83px;">
                                                                                                    <option selected="selected" value="cm" <?php
                                                                                                    if ($product['DimensionUnit'] == 'cm') {
                                                                                                        echo 'selected="selected"';
                                                                                                    }
                                                                                                    ?>><?php echo CENTI; ?></option>
                                                                                                    <option value="mm" <?php
                                                                                                    if ($product['DimensionUnit'] == 'mm') {
                                                                                                        echo 'selected="selected"';
                                                                                                    }
                                                                                                    ?>><?php echo MILLI; ?></option>
                                                                                                    <option value="in" <?php
                                                                                                    if ($product['DimensionUnit'] == 'in') {
                                                                                                        echo 'selected="selected"';
                                                                                                    }
                                                                                                    ?>><?php echo INCH; ?></option>
                                                                                                </select>
                                                                                                <div class="input_star">
                                                                                                    <input numericOnly="yes" style=" margin: 0px 10px 0 10px;width: 90px !important; float: left;" type="text" name="Length" id="Length" value="<?php echo $product['Length']; ?>" class="validate[required,min[1]] input1" />
                                                                                                    <small class="star_icon" style=" right:11px"><img alt="" src="common/images/star_icon.png"></small>
                                                                                                </div>
                                                                                                <div class="input_star">
                                                                                                    <input numericOnly="yes" style="margin: 0px 10px 0 0;width:90px !important; float: left;" type="text" name="Width" id="Width" value="<?php echo $product['Width']; ?>" class="validate[required,min[1]] input1" />
                                                                                                    <small class="star_icon" style=" right:11px"><img alt="" src="common/images/star_icon.png"></small>
                                                                                                </div>
                                                                                                <div class="input_star">
                                                                                                    <input numericOnly="yes" style="margin: 0px 10px 0 0;width:90px !important; float: left;" type="text" name="Height" id="Height" value="<?php echo $product['Height']; ?>" class="validate[required,min[1]] input1" />
                                                                                                    <small class="star_icon" style=" right:11px"><img alt="" src="common/images/star_icon.png"></small>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                                <li class="liTxt">
                                                                                    <div class="left_section">
                                                                                        <?php
                                                                                        if ($_REQUEST['action'] == 'add') {
                                                                                            ?>
                                                                                            <label style="width:100%;"> Avaliable Country </label>
                                                                                            <input type="radio" name="radio" value="gloabal" class="a mulcountryClass changeradio">Gloabal &nbsp;&nbsp;
                                                                                                <input type="radio" name="radio" value="local"  class="a mulcountryClass changeradio">Local &nbsp;&nbsp;
                                                                                                    <input type="radio" name="radio" id="mulcountry" class="changeradio" value="multiple"> Multiple country

                                                                                                        <?php
                                                                                                    } elseif ($_REQUEST['action'] == 'edit' && empty($productmulcountrydetail[0]['producttype'])) {
                                                                                                        ?> 	
                                                                                                        <label style="width:100%;"> Avaliable Country </label>
                                                                                                        <input type="radio" name="radio" value="gloabal"  class="a mulcountryClass changeradio">Gloabal &nbsp;&nbsp;
                                                                                                            <input type="radio" name="radio" value="local"  class="a mulcountryClass changeradio">Local &nbsp;&nbsp;
                                                                                                                <input type="radio" name="radio" id="mulcountry" class=" changeradio" value="multiple"> Multiple country
                                                                                                                    <?php
                                                                                                                } else {
                                                                                                                    //pre($productmulcountrydetail[0]['producttype']);
                                                                                                                    ?>
                                                                                                                    <label style="width:100%;"> Avaliable Country </label>
                                                                                                                    <input type="radio" name="radio" value="gloabal" <?php echo ($productmulcountrydetail[0]['producttype'] == 'gloabal') ? 'checked' : ''; ?>  class="a mulcountryClass changeradio">Gloabal &nbsp;&nbsp;
                                                                                                                        <input type="radio" name="radio" value="local" <?php echo ($productmulcountrydetail[0]['producttype'] == 'local') ? 'checked' : ''; ?> class="a mulcountryClass changeradio">Local &nbsp;&nbsp;
                                                                                                                            <input type="radio" name="radio" id="mulcountry" <?php echo ($productmulcountrydetail[0]['producttype'] == 'multiple') ? 'checked' : ''; ?> class=" changeradio" value="multiple"> Multiple country

                                                                                                                                <?php
                                                                                                                            }
                                                                                                                            $CompanyCountry = $objPage->wholesalercountry_id[0]['CompanyCountry'];
                                                                                                                            if (!empty($CompanyCountry)) {
                                                                                                                                $companycountryid = $CompanyCountry;
                                                                                                                            } else
                                                                                                                                $companycountryid = '';
                                                                                                                            ?>
                                                                                                                            <input type="hidden"name="CompanyCountry" value="<?php echo $companycountryid ?>"/>
                                                                                                                            <input type="hidden"name="Currentcountry" value="<?php echo $_SESSION['sessUserInfo']['countryid']; ?>"/>
                                                                                                                            </br>

                                                                                                                            <div id="mul_countriesID" class="input_sec input_star input_boxes <?php echo ($productmulcountrydetail[0]['producttype'] == 'multiple') ? '' : 'mulcountries'; ?> ">
                                                                                                                                <div class="ErrorfkCategoryID" style="display: none"></div>
                                                                                                                                <?php
                                                                                                                                $a = $objGeneral->getCountry();
                                                                                                                                foreach ($productmulcountrydetail as $kk => $vv) {
                                                                                                                                    $SelectedCountry[$kk] = $vv['country_id'];
                                                                                                                                }
//pre($SelectedCountry);
                                                                                                                                echo $objGeneral->CountryHtml($a, 'name[]', 'country_id', $SelectedCountry, '', 1, 'onchange="showAttribute(this.value);" class="select2-me multilecountries" style="width:100%"', '1', '1');
                                                                                                                                ?>
                                                                                                                                <!-- <small class="star_icon" style=" right:0px ; top:10px;"><img src="common/images/star_icon.png" alt=""/></small> -->
                                                                                                                            </div>
                                                                                                                            </div> 
                                                                                                                            </li> 
                                                                                                                            <li class="liTxt">
                                                                                                                                <div class="full_section"><label>Logistic Company(s):</label><div class="cb"></div>   
                                                                                                                                    <div class="check_box cnangevalue">

                                                                                                                                        <?php 
                                                                                                                                        if ($_REQUEST['action'] == 'edit')
                                                                                                                                        {
                                                                                                                                          foreach ($objPage->arrShippingGatwayList as $key => $val) {
                                                                                                                                            $varShipping = explode(',', $product['fkShippingID']);
                                                                                                                                            $selected = in_array($val['logisticportalid'], $varShipping) ? 'checked="checked"' : '';
                                                                                                                                            echo '<div class="ad_pro_check"><input class="validate[minCheckbox[1]] class_req checkradios" type="checkbox" name="frmShippingGateway[]" value="' . $val['logisticportalid'] . '"' . $selected . ' /><span>' . $val['logisticTitle'] . '</span></div>';
                                                                                                                                        }  
                                                                                                                                        }
                                                                                                                                        //pre($objPage->arrShippingGatwayList);
                                                                                                                                        
                                                                                                                                        ?>
                                                                                                                                    </div> </div>
                                                                                                                            </li>
                                                                                                                            <li class="liTxt">
                                                                                                                                <div class="left_section">
                                                                                                                                    <label style="width:100%;" class="leb_margin"><?php echo DETAILS; ?><br /><div class="red" style="float:left; font-weight:100; display:block; margin-right:11px;"><?php echo MAXDETAILS; ?></div></label>
                                                                                                                                    <div class="full_section padding-10">
                                                                                                                                        <textarea name="ProductDescription" style="width: 98%!important; "  cols="5" rows="5" maxlength="2000"><?php echo $_POST['ProductDescription'] ? $_POST['ProductDescription'] : $product['ProductDescription'] ?></textarea>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                                <div class="right_section" style=" margin-top:19px;">
                                                                                                                                    <label class="leb_margin" style="width:100%; margin-left:5px;"><?php echo TC; ?> </label>
                                                                                                                                    <div  class="full_section padding-10" >
                                                                                                                                        <textarea name="ProductTerms"  style="width: 95% !important; margin-left:8px " cols="5" rows="5"><?php echo $_POST['ProductTerms'] ? $_POST['ProductTerms'] : $product['ProductTerms'] ?></textarea>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </li>
                                                                                                                            <li>


                                                                                                                            </li>
                                                                                                                            <li>
                                                                                                                                <label class="leb_margin" style="width:100%;"><?php echo YOUTUBE_EMB; ?></label>
                                                                                                                                <div class="full_section" style=" padding-top:6px;">
                                                                                                                                    <span class="fst_url">https://www.youtube.com/embed/</span><input style="width:96.5%!important; " type="text" name="YoutubeCode" value="<?php echo $_POST['YoutubeCode'] ? $_POST['YoutubeCode'] : $product['YoutubeCode'] ?>" class="input1" />
                                                                                                                                </div>
                                                                                                                            </li>
                                                                                                                            <!--<li>
                                                                                                                                <div class="full_section">
                                                                                                                                    <label  style="width:100%;"><?php echo HTML_EDI; ?></label>
                                                                                                                                    <div class="html_editor" style="width:100%">
                                                                                                                                        <textarea name="HtmlEditor" ST  id="HtmlEditor"><?php echo $_POST['HtmlEditor'] ? $_POST['HtmlEditor'] : $product['HtmlEditor'] ?></textarea>
                                                                                                                                        <script type="text/javascript">
                                                                                                                                            CKEDITOR.replace('HtmlEditor',
                                                                                                                                            {
                                                                                                                                                enterMode: CKEDITOR.ENTER_BR,
                                                                                                                                                toolbar: [['Bold'], ['Italic'], ['Strike'], ['Subscript'], ['Superscript'], ['RemoveFormat'], ['NumberedList'], ['BulletedList'], ['Link'], ['Unlink'],
                                                                                                                                                    ['Table'], ['TextColor'], ['BGColor'], ['FontSize'], ['Font'], ['Styles']]
                                                                                                                                            });
                                                                                                                                        </script>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </li>-->

                                                                                                                            <li>
                                                                                                                                <div class="left_section">
                                                                                                                                    <label><?php echo META_TITLE; ?></label>
                                                                                                                                    <div  class="padding-10">
                                                                                                                                        <textarea name="frmMetaTitle" style="width:98%" cols="5" rows="6"><?php echo $_POST['frmMetaTitle'] ? $_POST['frmMetaTitle'] : $product['MetaTitle'] ?></textarea>
                                                                                                                                    </div>
                                                                                                                                </div>

                                                                                                                                <div class="right_section">
                                                                                                                                    <label><?php echo META_KEY; ?></label>
                                                                                                                                    <div class="padding-10">
                                                                                                                                        <textarea name="frmMetaKeywords" style="width:98%"  cols="5" rows="6"><?php echo $_POST['frmMetaKeywords'] ? $_POST['frmMetaKeywords'] : $product['MetaKeywords'] ?></textarea>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </li>
                                                                                                                            <li>
                                                                                                                                <div class="left_section">
                                                                                                                                    <label><?php echo META_DES; ?></label>
                                                                                                                                    <div class="padding-10">
                                                                                                                                        <textarea name="frmMetaDescription" style="width:98%" cols="5" rows="6"><?php echo $_POST['frmMetaDescription'] ? $_POST['frmMetaDescription'] : $product['MetaDescription'] ?></textarea>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </li>
                                                                                                                            <li class="create_cancle_btn">
                                                                                                                                <div class="full_section">
                                                                                                                                    <input type="hidden" name="fkWholesalerID" value="<?php echo $_SESSION['sessUserInfo']['id'] ?>" />
                                                                                                                                    <input type="hidden" name="action" value="update" />
                                                                                                                                    <input type="hidden" name="view" value="<?php echo $_REQUEST['action'] ?>" />
                                                                                                                                    <input type="hidden" name="pid" value="<?php echo $_REQUEST['pid'] ?>" />
                                                                                                                                    <?php
                                                                                                                                    if (isset($_GET['action']) && $_GET['action'] == 'add') {
                                                                                                                                        ?><input type="submit" name="save_add_more" value="Save & Add More" class="submit3" style="margin-top:0px;float:left; margin-right:8px;" /><?php } ?>
                                                                                                                                    <input type="submit" name="submit" value="Submit" class="submit3" style="margin-top:0px; float:left;width:144px;" />
                                                                                                                                    <!--<a href="">-->
                                                                                                                                    <?php
                                                                                                                                    if (isset($_GET['action']) && $_GET['action'] == 'edit') {
                                                                                                                                        if (isset($_SESSION['query_string']['wholesaler']['products_listing']) && $_SESSION['query_string']['wholesaler']['products_listing'] != '') {
                                                                                                                                            ?>
                                                                                                                                            <input onclick="window.location.href = '<?php echo $objCore->getUrl('manage_products.php?' . $_SESSION['query_string']['wholesaler']['products_listing']); ?>'" type="button" value="Cancel" class="cancel" style="float:left;width:144px;" />
                                                                                                                                        <?php } else { ?>
                                                                                                                                            <input onclick="window.location.href = '<?php echo $objCore->getUrl('manage_products.php'); ?>'" type="button" value="Cancel" class="cancel" style="float:left;width:144px;" />
                                                                                                                                            <?php
                                                                                                                                        }
                                                                                                                                    } else {
                                                                                                                                        ?>
                                                                                                                                        <input onclick="window.location.href = '<?php echo $objCore->getUrl('manage_products.php'); ?>'" type="button" value="Cancel" class="cancel" style="float:left;width:144px;" />
                                                                                                                                    <?php } ?>

                                                                                                                                    <!--</a>-->
                                                                                                                                    <label style="visibility: hidden;" >. </label>
                                                                                                                                </div>
                                                                                                                                <div class="cb"></div>
                                                                                                                            </li>
                                                                                                                            </ul>
                                                                                                                            </div>
                                                                                                                            </div>
                                                                                                                            </form>

                                                                                                                            </div>

                                                                                                                            </div>

                                                                                                                            </div>
                                                                                                                            </div>
                                                                                                                            <?php include_once 'common/inc/footer.inc.php'; ?>

                                                                                                                            <div style="display:none;">
                                                                                                                                <div id="packageAddBox">
                                                                                                                                    <table id="colorBox_table" border="0">
                                                                                                                                        <tr align="left" >
                                                                                                                                            <td colspan="5"><h4 class="new_txt"> Create New Package</h4><div id="PkgAdded" style="color: green; width: 300px; margin-left: 200px;"></div></td>
                                                                                                                                        </tr>
                                                                                                                                        <tr align="left">
                                                                                                                                            <td width="118"><?php echo PACKAGE_NAME; ?>:</td>
                                                                                                                                            <td colspan="2">
                                                                                                                                                <div class="input_star">
                                                                                                                                                    <input type="text" name="frmPackageName" id="frmPackageName" />
                                                                                                                                                    <small class="star_icon" style="right:0px;"><img src="common/images/star_icon.png" alt=""/></small>
                                                                                                                                                </div>
                                                                                                                                            </td>
                                                                                                                                            <td width="24" colspan="2">&nbsp;</td>
                                                                                                                                        </tr>

                                                                                                                                        <tr>
                                                                                                                                            <td colspan="5">
                                                                                                                                                <table border="0" id="productRow" cellpadding="5">
                                                                                                                                                    <tr align="left" class="th_box">
                                                                                                                                                        <th width="67">&nbsp;</th>
                                                                                                                                                        <th width="51" style="width:380px;"><?php echo SEL; ?></th>
                                                                                                                                                        <th colspan="2" style="text-align:right"><?php echo ORG_PRICE; ?></th>
                                                                                                                                                    </tr>
                                                                                                                                                    <tr align="left">
                                                                                                                                                        <td><?php echo PRO_1; ?>:</td>
                                                                                                                                                        <td> <div class="input_star">
                                                                                                                                                                <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryList, 'frmCategoryId[]', '', array(0), 'Select Category', 0, 'onchange="ShowProductForPackage(this.value,1)" class="select2-me"', '1', '1'); ?>
                                                                                                                                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                                                                                                                                            </div>
                                                                                                                                                        </td>
                                                                                                                                                        <td width="201" style="width:400px;">
                                                                                                                                                            <div class="input_star">
                                                                                                                                                                <div class="drop4 dropdown_2" id="product1">
                                                                                                                                                                    <select name="frmProductId[]" style="width:170px; text-align:center" onchange="ShowProductPriceForPackage(this.value, 1)" >
                                                                                                                                                                        <option value="0"><?php echo PRODUCTS; ?></option>
                                                                                                                                                                    </select>
                                                                                                                                                                </div>
                                                                                                                                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                                                                                                                                            </div>
                                                                                                                                                        </td>
                                                                                                                                                        <td width="78"><span id="price1" style="text-align:center"><input type="hidden" name="frmPrice[]" value="0.00" /><b>0.00</b></span></td><td width="37">&nbsp;</td>
                                                                                                                                                    </tr>
                                                                                                                                                    <tr align="left">
                                                                                                                                                        <td><?php echo PRO_2; ?>:</td>
                                                                                                                                                        <td>
                                                                                                                                                            <div class="input_star">
                                                                                                                                                                <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryList, 'frmCategoryId[]', '', array(0), 'Select Category', 0, 'onchange="ShowProductForPackage(this.value,2)" class="select2-me"', '1', '1'); ?>
                                                                                                                                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                                                                                                                                            </div>
                                                                                                                                                        </td>
                                                                                                                                                        <td>
                                                                                                                                                            <div class="input_star">
                                                                                                                                                                <div class="drop4 dropdown_2" id="product2">
                                                                                                                                                                    <select name="frmProductId[]" style="width:170px; text-align:center" onchange="ShowProductPriceForPackage(this.value, 2)">
                                                                                                                                                                        <option value="0"><?php echo PRODUCTS; ?></option>
                                                                                                                                                                    </select>
                                                                                                                                                                </div>
                                                                                                                                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                                                                                                                                            </div>
                                                                                                                                                        </td>
                                                                                                                                                        <td><span id="price2" style="text-align:center"><input type="hidden" name="frmPrice[]" value="0.00" /><b>0.00</b></span></td>
                                                                                                                                                        <td style="width:50px;"><span style="cursor: pointer;" onclick="addDynamicRowToTableForPackage('productRow');"><img src="admin/images/my_plus.png" /></span></td>
                                                                                                                                                    </tr>
                                                                                                                                                </table>
                                                                                                                                            </td>
                                                                                                                                        </tr>
                                                                                                                                        <tr align="left">
                                                                                                                                            <td colspan="5">&nbsp;</td>
                                                                                                                                        </tr>
                                                                                                                                        <tr>
                                                                                                                                            <td height="45"><?php echo TOTAL_PRICE; ?>:</td>
                                                                                                                                            <td colspan="4"><span id="asc" style="font-weight: bold;">0.00</span><input type="hidden" name="frmTotalPrice" id="frmTotalPrice" value="0.00"  /></td>
                                                                                                                                        </tr>
                                                                                                                                        <tr align="left">
                                                                                                                                            <td style=""><?php echo OFF_PRICE; ?>:</td>
                                                                                                                                            <td width="352">
                                                                                                                                                <div class="input_star">
                                                                                                                                                    <input type="text" name="frmOfferPrice" id="frmOfferPrice" />
                                                                                                                                                    <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                                                                                                                                </div>
                                                                                                                                            </td>
                                                                                                                                            <td colspan="3">&nbsp;
                                                                                                                                                <input type="hidden" name="frmWholesalerId" id="frmWholesalerId" value="<?php echo $_SESSION['sessUserInfo']['id'] ?>"/></td>
                                                                                                                                        </tr>

                                                                                                                                        <tr align="left">
                                                                                                                                            <td colspan="5">&nbsp;</td>
                                                                                                                                        </tr>
                                                                                                                                        <tr>   <td colspan="5" align="center">
                                                                                                                                                <div style="margin:0px auto; width:306px;">
                                                                                                                                                    <input type="submit" name="frmConfirmDelete" id="frmConfirmDelete" value="Submit" class="pop_btns"  />
                                                                                                                                                    <input type="button" name="cancel" id="cancel" value="<?php echo CANCEL; ?>" class="pop_btns" style="background-color:#414141;" /></div>
                                                                                                                                            </td>
                                                                                                                                        </tr>

                                                                                                                                    </table>

                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <script type="text/javascript">
                                                                                                                                $(document).ready(function () {
                                                                                                                                    $('#cboxOverlay').css('z-index', '999999');
<?php echo $strImgScript; ?>

                                                                                                                                });
                                                                                                                            </script>
                                                                                                                            <script>
                                                                                                                                function jCroppicPopupOpen(str, con, cls) {    //alert(str);return false;    
                                                                                                                                    $('#cropimg_' + con).show();

                                                                                                                                    var htmlCrop = '<div class="col-lg-6 cropHeaderWrapper"><div id="croppic' + con + '" class="' + cls + '"></div><span class="btn cropContainerHeaderButton" id="cropContainerHeaderButton' + con + '" style="cursor:pointer;margin-right:10px;">Upload Image</span></div>';
                                                                                                                                    $('#cropimg_' + con).html(htmlCrop);
                                                                                                                                    $("." + str).colorbox({
                                                                                                                                        inline: true
                                                                                                                                    });
                                                                                                                                    var croppicHeaderOptions = {
                                                                                                                                        //uploadUrl:'img_save_to_file.php',
                                                                                                                                        cropData: {"dummyData": 1, "dummyData2": "asdas"},
                                                                                                                                        cropUrl: 'img_crop_to_file.php',
                                                                                                                                        customUploadButtonId: 'cropContainerHeaderButton' + con + '',
                                                                                                                                        modal: false,
                                                                                                                                        processInline: true,
                                                                                                                                        loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
                                                                                                                                        onBeforeImgUpload: function () {
                                                                                                                                            console.log('onBeforeImgUpload')
                                                                                                                                        },
                                                                                                                                        onAfterImgUpload: function () {
                                                                                                                                            console.log('onAfterImgUpload')
                                                                                                                                        },
                                                                                                                                        onImgDrag: function () {
                                                                                                                                            console.log('onImgDrag')
                                                                                                                                        },
                                                                                                                                        onImgZoom: function () {
                                                                                                                                            console.log('onImgZoom')
                                                                                                                                        },
                                                                                                                                        onBeforeImgCrop: function () {
                                                                                                                                            console.log('onBeforeImgCrop')
                                                                                                                                        },
                                                                                                                                        onAfterImgCrop: function () {
                                                                                                                                            console.log('onAfterImgCrop')
                                                                                                                                        },
                                                                                                                                        onError: function (errormessage) {
                                                                                                                                            console.log('onError:' + errormessage)
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                    var croppic = new Croppic('croppic' + con + '', croppicHeaderOptions);


                                                                                                                                    var croppicContainerModalOptions = {
                                                                                                                                        uploadUrl: 'img_save_to_file.php',
                                                                                                                                        cropUrl: 'img_crop_to_file.php',
                                                                                                                                        modal: true,
                                                                                                                                        imgEyecandyOpacity: 0.4,
                                                                                                                                        loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
                                                                                                                                    }
                                                                                                                                    var cropContainerModal = new Croppic('cropContainerModal', croppicContainerModalOptions);


                                                                                                                                    var croppicContaineroutputOptions = {
                                                                                                                                        uploadUrl: 'img_save_to_file.php',
                                                                                                                                        cropUrl: 'img_crop_to_file.php',
                                                                                                                                        outputUrlId: 'cropOutput',
                                                                                                                                        modal: false,
                                                                                                                                        loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
                                                                                                                                    }
                                                                                                                                    var cropContaineroutput = new Croppic('cropContaineroutput', croppicContaineroutputOptions);

                                                                                                                                    var croppicContainerEyecandyOptions = {
                                                                                                                                        uploadUrl: 'img_save_to_file.php',
                                                                                                                                        cropUrl: 'img_crop_to_file.php',
                                                                                                                                        imgEyecandy: false,
                                                                                                                                        loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
                                                                                                                                    }
                                                                                                                                    var cropContainerEyecandy = new Croppic('cropContainerEyecandy', croppicContainerEyecandyOptions);

                                                                                                                                    var croppicContaineroutputMinimal = {
                                                                                                                                        uploadUrl: 'img_save_to_file.php',
                                                                                                                                        cropUrl: 'img_crop_to_file.php',
                                                                                                                                        modal: false,
                                                                                                                                        doubleZoomControls: false,
                                                                                                                                        rotateControls: false,
                                                                                                                                        loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
                                                                                                                                    }
                                                                                                                                    var cropContaineroutput = new Croppic('cropContainerMinimal', croppicContaineroutputMinimal);

                                                                                                                                    var croppicContainerPreloadOptions = {
                                                                                                                                        uploadUrl: 'img_save_to_file.php',
                                                                                                                                        cropUrl: 'img_crop_to_file.php',
                                                                                                                                        loadPicture: 'assets/img/night.jpg',
                                                                                                                                        enableMousescroll: true,
                                                                                                                                        loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
                                                                                                                                    }
                                                                                                                                    var cropContainerPreload = new Croppic('cropContainerPreload', croppicContainerPreloadOptions);

                                                                                                                                    $('#cboxClose,#cboxOverlay').click(function () {
                                                                                                                                        $('#cropimg_' + con).hide();
                                                                                                                                        parent.jQuery.fn.colorbox.close();
                                                                                                                                    });

                                                                                                                                }
                                                                                                                            </script>

                                                                                                                            <style type="text/css" >
                                                                                                                                .select2-drop.select2-with-searchbox.select2-drop-active{
                                                                                                                                    z-index: 2147483647 !important;
                                                                                                                                }

                                                                                                                                #productRow {
                                                                                                                                    background-color: #f6f6f6;
                                                                                                                                    border: 1px solid #eee;
                                                                                                                                    font-size: 13px !important;
                                                                                                                                    padding: 0px 10px 20px; margin-top:15px;
                                                                                                                                }
                                                                                                                                #productRow .select2-me{width:350px !important;}
                                                                                                                                #productRow .select2-container .select2-choice span {
                                                                                                                                    background: url("common/images/select2.png") no-repeat scroll 314px 2px rgba(0, 0, 0, 0);}

                                                                                                                                #productRow .drop4 .selectedTxt {
                                                                                                                                    background: url("common/images/select2.png") no-repeat scroll 116% 6px #fff;
                                                                                                                                    width: 308px;
                                                                                                                                }
                                                                                                                                #productRow .drop4 .newListSelected{width:350px !important;}

                                                                                                                                #productRow .drop4 .select2-container{width:350px !important;}
                                                                                                                                #packageAddBox input[type="text"]{border-radius:0px;}

                                                                                                                            </style>

                                                                                                                            </body>
                                                                                                                            </html>
