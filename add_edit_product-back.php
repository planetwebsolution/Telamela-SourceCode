<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_MANAGE_PRODUCT_CTRL;
?>

<?php
//echo $objGeneral->CategoryHtml($objPage->arrCategoryList, 'fkCategoryID', 'fkCategoryID', array($product['fkCategoryID']), 'Select Category', 0, 'onchange="showAttribute(this.value);" class="select2-me" style="width:100%"', '1','1'); 
//die;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo ADD_EDIT_PRODUCT_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <?php require_once INC_PATH . 'img_crop_js_css.inc.php'; ?>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>browse.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH ?>browse.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>product_add_edit.js"></script>
        <script type="text/javascript" src="<?php echo CKEDITOR_URL; ?>ckeditor.js"></script>
        <!-- select2 -->
        <link rel="stylesheet" href="<?php echo CSS_PATH ?>select2.css"/>
        <script src="<?php echo JS_PATH ?>select2.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                // binds form submission and fields to the validation engine
                jQuery("#add_edit_product").validationEngine({                    
                    'custom_error_messages': {                        
                        'minCheckbox': {
                            'message': "*Please select atleast 1 option."
                        },'min': {
                            'message': "*Entered value should be greator then 0."
                        }                        
                    }
                });
                $(".select2-me").select2();
                });
        </script>
        <style>.input_sec span{padding:0px;}.datepick-trigger{margin: 31px 0 0 -19px; position: relative;} .dashboard_title{background:#60494A; color: rgb(255, 255, 255); padding: 0px 9px; border-radius: 4px 4px 4px 4px; margin: 0px 0px 9px; width: 114%;}
            #cboxLoadedContent{margin-top:-2px !important;} .imgimg{float: left; width: 100%}.input_sec .select2-choice span{padding: 3px;}

        </style>

        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>dd.css" />
        <script src="<?php echo JS_PATH ?>jquery.dd.js"></script>

    </head>
    <body>
         <em> <div id="navBar">
            <?php include_once INC_PATH . 'top-header.inc.php'; ?>
        </div>
    
        </em>
       <div class="header" style="border-bottom:none"><div class="layout">
               <?php include_once INC_PATH . 'header.inc.php'; ?>
        </div>
       </div>
      
        <div id="ouderContainer" class="ouderContainer_1"><div style="width:100%; background:#f5f5ed;height:50px; padding-top:16px;	  border-bottom:1px solid #d9d9d9;"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">
        
                <div class="add_pakage_outer">
                    <div class="top_container">
                        <a href="<?php echo $objCore->getUrl('bulk_uploads.php'); ?>" class="multiple_link"><?php echo UP_PRODUCTS; ?></a>
  <a href="<?php echo $objCore->getUrl('add_multi_product.php', array('action' => 'addMutiple')); ?>" class="multiple_link"><?php echo ADD_MULTI_PRODUCT; ?></a>
   <div class="back_ankar_sec"><a href="<?php echo $objCore->getUrl('manage_products.php'); ?>" class="back_multiple"><span><?php echo BACK; ?></span></a></div>
                    </div>
                  
                    <?php $product = $objPage->productDetail[0]; ?>
                    <div class="body_inner_bg">
                        <form name="add_edit_product" id="add_edit_product" onsubmit="return ValidateForm();" action="" method="POST" enctype="multipart/form-data">
                            <div class="add_edit_pakage">
                               
                              <div class="edit_container"><div class="mandatory"><span>*</span> Mandatory Fields</div>  <ul class="left_sec">
                                    <li>
                                        <label><?php echo PROD_NAME; ?></label><br />
                                        <div class="input_sec input_star">
                                            <input class="validate[required]" type="text" name="ProductName" value="<?php echo $_POST['ProductName'] ? $_POST['ProductName'] : $product['ProductName'] ?>" />
                                            <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                        </div>
                                    </li>
                                    <?php if ($_REQUEST['action'] == 'add') { ?>
                                        <li>
                                            <label><?php echo PRO_REF_NO; ?></label>
                                            <div class="input_sec input_star">
                                                <input onkeyup="checkProductRefNoForMultiple(this.value,1);" onmousemove="checkProductRefNoForMultiple(this.value,1);" onchange="checkProductRefNoForMultiple(this.value,1);" class="validate[required]" type="text" name="ProductRefNo" id="ProductRefNo" value="<?php echo $_POST['ProductRefNo'] ? $_POST['ProductRefNo'] : $product['ProductRefNo'] ?>" />
                                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                                <span id="refmsg1"><input type="hidden" name="frmIsRefNo[]" value="0" /></span>
                                            </div>
                                        </li>
                                        <?php
                                    } else {
                                        echo '<input type="hidden" name="frmIsRefNo[]" value="0" />';
                                    }
                                    ?>
                                    <li>
                                        <label><?php echo SHIPPING_GATEWAY; ?></label>
                                        <!--<div class="ErrorfkShippingID" style=""></div>-->
                                        <div class="check_box">
                                            <?php
                                            foreach ($objPage->arrShippingGatwayList as $key => $val) {
                                                $varShipping = explode(',', $product['fkShippingID']);
                                                $selected = in_array($val['pkShippingGatewaysID'], $varShipping) ? 'checked="checked"' : '';
                                                echo '<div style="float:left;"><input class="validate[minCheckbox[1]] class_req" style="float:left;" type="checkbox" name="frmShippingGateway[]" value="' . $val['pkShippingGatewaysID'] . '"' . $selected . ' /><small>' . $val['ShippingTitle'] . '</small></div>';
                                                
                                            }
                                            ?>
                                        </div>
                                    </li>
                                    <li>
                                        <label><?php echo CATEGORY_TITLE; ?> </label>
                                        <div class="input_sec input_star">
                                            <div class="ErrorfkCategoryID" style="display: none;"></div>
                                            <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryList, 'fkCategoryID', 'fkCategoryID', array($product['fkCategoryID']), 'Select Category', 0, 'onchange="showAttribute(this.value);" class="select2-me" style="width:100%"', '1', '1'); ?>
                                            <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                        </div>
                                    </li>

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
                                    <li>
                                        <label><?php echo ATTR; ?></label>
                                        <div id="attribute" class="input_sec">
                                            <?php
                                            $strImgScript = '';
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
                                                                    $varCaptionInput = '<input type="text" name="frmOptCaption[' . $valueOpt['pkOptionID'] . ']" value="' . $objPage->arrProductOpt['optCaption'][$optIdInd] . '" style="width:100px;margin-bottom:5px;">';
                                                                    $varExtraPrice = '<input type="hidden" name="frmOptExtraPrice[' . $valueOpt['pkOptionID'] . ']" value="' . $objPage->arrProductOpt['optExtraPrice'][$optIdInd] . '">';
                                                                } else {
                                                                    $varcheck = '';
                                                                    $varCaptionInput = '';
                                                                    $varExtraPrice = '';
                                                                }
                                                                $varStr .= '<div class="product_attr_options">' . $varExtraPrice . '<input type="checkbox" name="frmAttribute[' . $keyAttr . '][]" value="' . $valueOpt['pkOptionID'] . '" ' . $varcheck . ' caption="' . $valueOpt['OptionTitle'] . '" class="otherstype" />&nbsp;' . $valueOpt['OptionTitle'] . '<div class="res_caption">' . $varCaptionInput . '</div></div>';
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
                                                                    $varStr .= '<div class="responce"></div>' . $varCaptionInput . '<input name="file_upload_attr[' . $valueOpt['pkOptionID'] . ']" class="customfile1-input file file_upload_attr" id="fileAttr' . $valueOpt['pkOptionID'] . '" type="file" />';
                                                                }
                                                                $varStr .='</div></div>';

                                                                $strImgScript .= '$("#fileAttr' . $valueOpt['pkOptionID'] . '").customFileInput1();';
                                                            }
                                                            $varStr .='</div>';
                                                        }
                                                    } else if ($valueAttr['AttributeInputType'] == 'text') {
                                                        $optIdInd = array_search($valueAttr['OptionsData']['0']['pkOptionID'], $objPage->arrProductOpt['optid']);
                                                        $varStr .= '<div class="product_attr" id="textInput"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</div><input type="text" name="frmAttributeText[' . $keyAttr . '-' . $valueAttr['OptionsData']['0']['pkOptionID'] . ']" value="' . $objPage->arrProductOpt['optval'][$optIdInd] . '" class="input2" /><span style="cursor: pointer;" onclick="hideInputType(' . "'" . 'textInput' . "'" . ');"><img src="admin/images/minus.png" alt="Remove" title="Remove" /></span></div>';
                                                    } else if ($valueAttr['AttributeInputType'] == 'textarea') {
                                                        $optIdInd = array_search($valueAttr['OptionsData']['0']['pkOptionID'], $objPage->arrProductOpt['optid']);
                                                        $varStr .= '<div class="product_attr" id="textAreaInput"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</div><textarea name="frmAttributeTextArea[' . $keyAttr . '-' . $valueAttr['OptionsData']['0']['pkOptionID'] . ']" rows="3" class="input3">' . $objPage->arrProductOpt['optval'][$optIdInd] . '</textarea><span onclick="hideInputType(' . "'" . 'textAreaInput' . "'" . ');"><img src="admin/images/minus.png" alt="Remove" title="Remove" align="top" /></span></div>';
                                                    }
                                                }
                                            } else {
                                                $varStr = '<input type="hidden" name="frmIsAttribute" value="0" class="input2" /><span class="req" style="padding-top:12px;">' . NO_ATTR . '</span>';
                                            }
                                            echo $varStr;
                                            ?>
                                        </div>
                                    </li>
                                    <li class="special">
                                        <?php
                                        $priceDisplay = 'display:none;';
                                        if (count($objPage->specialEvents) > 0) {
                                            $priceDisplay = 'display:block;';
                                            $varStr = '<label><b>' . SPECIAL_EVENT . '</b></label><div class="check_box" style="margin-top: 10px;">';
                                            foreach ($objPage->specialEvents as $key => $val) {
                                                $sel = ($objPage->specialProduct['fkFestivalID'] == $val['fkFestivalID']) ? 'checked="checked"' : '';
                                                $varStr .= '<input style="float:left;" type="radio" name="frmSpecialEvents" ' . $sel . ' value="' . $val['fkFestivalID'] . '" /><small style="margin-top: -3px; font-weight:bold;">' . $val['FestivalTitle'] . '</small><br/>';
                                            }
                                            $varStr .='</div>';
                                            echo $varStr;
                                        }
                                        ?>
                                    </li>
                                    <li class="specialPrice" style="<?php echo $priceDisplay; ?>">
                                        <label><b><?php echo SPECIAL_PRICE; ?></b></label>
                                        <div class="input_sec">
                                            <span style="font-size:10px;"><?php echo SEL_CURR; ?>:</span><br />
                                            <div style="width:70px" class="drop2">
                                                <select class="drop_down1" name="frmCurrency" id="frmCurrency0" style="width:83px;" onchange="showCurrencyInUSD(0);">
                                                    <?php
                                                    foreach ($arrCurrencyList as $ck => $cv) {
                                                        // $cselected = ($_SESSION['SiteCurrencyCode'] == $ck) ? 'selected="selected"' : '';
                                                        echo '<option value="' . $ck . '" >' . $ck . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div>
                                                <input numericOnly="yes" onchange="showCurrencyInUSD(0);" onkeyup="showCurrencyInUSD(0);" style="width: 70px!important; margin: 0px 15px 0px 20px;" id="frmWholesalePrice0" type="text" name="SpecialEventsPrice" value="<?php echo $_POST['SpecialEventsPrice'] ? $_POST['SpecialEventsPrice'] : $objPage->specialProduct['SpecialPrice'] ?>" />
                                                <span style="font-size:10px;"><?php echo SPECIAL_PRICE_IN_USD; ?></span>
                                                <span id="InUSD0"><?php echo '$' . $objPage->specialProduct['SpecialPrice'] ?></span>
                                                <input id="frmWholesalePriceInUSD0" type="hidden" value="<?php echo $objPage->specialProduct['SpecialPrice']; ?>" name="SpecialEventsPrice"/>
                                                <br /><br />
                                                <span style="font-size:10px;"><?php echo FINAL_SPECIAL_PRICE_IN_USD; ?></span>
                                                <span id="FinalPriceInUSD0"><?php echo '$' . $objPage->specialProduct['FinalSpecialPrice']; ?></span>
                                                <input id="frmProductPrice0" type="hidden" readonly="true" value="<?php echo $objPage->specialProduct['FinalSpecialPrice']; ?>" name="FinalSpecialEventsPrice"/>

                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <label><?php echo WHOL_PRICE; ?></label>
                                        <div class="input_sec">
                                            <span style="font-size:10px;"><?php echo SEL_CURR; ?>:</span><br />
                                            <div style="width:70px" class="drop2">
                                                <select class="drop_down1" name="frmCurrency" id="frmCurrency1" style="width:83px;" onchange="showCurrencyInUSD(1);">
                                                    <?php
                                                    foreach ($arrCurrencyList as $ck => $cv) {
                                                        // $cselected = ($_SESSION['SiteCurrencyCode'] == $ck) ? 'selected="selected"' : '';
                                                        echo '<option value="' . $ck . '" >' . $ck . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div>
                                                <input numericOnly="yes" onchange="showCurrencyInUSD(1);" onkeyup="showCurrencyInUSD(1);" style="width: 70px!important; margin: 0px 15px 0px 20px;" id="frmWholesalePrice1" class="validate[required,min[1]] text5" type="text" name="WholesalePrice" value="<?php echo $_POST['WholesalePrice'] ? $_POST['WholesalePrice'] : $product['WholesalePrice'] ?>"/>
                                                <span style="font-size:10px;"><?php echo PRICE_IN_USD; ?></span>
                                                <span id="InUSD1"><?php echo '$' . $product['WholesalePrice'] ?></span>
                                                <input id="frmWholesalePriceInUSD1" class="input1" type="hidden" value="<?php echo $product['WholesalePrice'] ?>" name="WholesalePrice"/>
                                                <br /><br />
                                                <span style="font-size:10px;"><?php echo FINAL_PRODUCT_PRICE; ?></span>
                                                <span id="FinalPriceInUSD1"><?php echo '$' . $product['FinalPrice'] ?></span>
                                                <input id="frmProductPrice1" class="input1" type="hidden" readonly="true" value="<?php echo $product['FinalPrice'] ?>" name="FinalPrice"/>

                                            </div>
                                        </div>

                                    </li>
                                    <li>
                                        <label><?php echo DIS_PRICE; ?></label>
                                        <div class="input_sec">
                                            <span style="font-size:10px;"><?php echo SEL_CURR; ?>:</span><br />
                                            <div style="width:70px" class="drop2">
                                                <select class="drop_down1" name="frmCurrency2" id="frmCurrency2" style="width:83px;" onchange="showCurrencyInUSD(2);">
                                                    <?php
                                                    foreach ($arrCurrencyList as $ck => $cv) {
                                                        // $cselected = ($_SESSION['SiteCurrencyCode'] == $ck) ? 'selected="selected"' : '';
                                                        echo '<option value="' . $ck . '" >' . $ck . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div>
                                                <input numericOnly="yes" onchange="showCurrencyInUSD(2);" onkeyup="showCurrencyInUSD(2);" style="width: 70px !important; margin: 0px 15px 0px 20px;" id="frmWholesalePrice2" type="text" name="DiscountPrice" value="<?php echo $_POST['DiscountPrice'] ? $_POST['DiscountPrice'] : $product['DiscountPrice'] ?>"  class="validate[min[1],lessThan[frmWholesalePrice1]] text5"/>

                                                <span style="font-size:10px;"><?php echo PRICE_IN_USD; ?></span>
                                                <span id="InUSD2"><?php echo '$' . $product['DiscountPrice'] ?></span>
                                                <input id="frmWholesalePriceInUSD2" class="input1" type="hidden" value="<?php echo $product['DiscountPrice'] ?>" name="DiscountPrice" />
                                                <br /><br />
                                                <span style="font-size:10px;"><?php echo FINAL_PRODUCT_PRICE; ?></span>
                                                <span id="FinalPriceInUSD2"><?php echo '$' . $product['DiscountFinalPrice'] ?></span>
                                                <input id="frmProductPrice2" class="input1" type="hidden" readonly="true" value="<?php echo $product['DiscountFinalPrice'] ?>" name="DiscountFinalPrice" />
                                            </div>
                                        </div>
                                    </li>
                                    <?php if (count($objPage->productImages) > 0) { ?>
                                        <li><label>&nbsp;</label>
                                            <div class="input_sec">
                                                <?php
                                                foreach ($objPage->productImages as $vImg) {
                                                    if ($vImg['ImageName'] <> '') {
                                                        ?>
                                                        <div style="width: 95px; float: left; border:1px solid #929291; height: 95px; margin: 0 5px 5px 0">
                                                            <div id="img<?php echo $vImg['pkImageID']; ?>">
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
                                        <label><?php echo PRO_IMAGE_600_800; ?></label>
                                        <div class="input_sec">
                                            <div class="imgimg">
                                                <div class="responce"></div>
                                                <input class="customfile1-input file file_upload" id="file1" type="file" name="file_upload[]" style="top: 0; left: 0px!important;"/><a href="#" class="delete_icon3" style="display: none;"></a>
                                            </div>
                                            <a href="#" class="more more_images"><small><?php echo ADD_MORE; ?></small> +</a>
                                        </div>
                                    </li>
                                    <li>
                                        <label><?php echo STOCK_QUAN; ?></label>
                                        <div class="input_sec input_star">
                                            <input numericOnly="yes" class="validate[required,custom[integer],min[1]]" type="text" name="Quantity" id="Quantity" value="<?php echo $_POST['Quantity'] ? $_POST['Quantity'] : $product['Quantity'] ?>"/>
                                            <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                            <div class="clear_gap"></div>
                                            <span style="float: left;"><a href="javascript:void(0);"><?php echo SEND_ALERT_MESSAGE; ?></a></span>
                                            <input numericOnly="yes" type="text" name="QuantityAlert" class="validate[lessThan[Quantity],min[1]] text5"  value="<?php echo $_POST['QuantityAlert'] ? $_POST['QuantityAlert'] : $product['QuantityAlert'] ?>" />
                                        </div>
                                    </li>

                                    <li>
                                        <label><?php echo SEL_PACK; ?></label>
                                        <div class="input_sec">
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
                                            </div>
                                            <a href="#packageAddBox" onclick="return jscallPackageAddBox()" class="more create_pkg_color_box"><small><?php echo CREATE_NEW_PACKAGE; ?></small></a>
                                        </div>
                                    </li>
                                    <li>
                                        <label><?php echo WAIGHT; ?> </label>
                                        <div class="input_sec">
                                            <div class="drop1">
                                                <select class="drop_down1" name="WeightUnit" style="width:83px;">
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
                                                <input numericOnly="yes" type="text" name="Weight" id="Weight" value="<?php echo $product['Weight']; ?>" class="input1" />
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <label><?php echo DIMEN; ?></label>
                                        <div class="input_sec">
                                            <div class="drop4">
                                                <select class="drop_down1" name="DimensionUnit" style="width:83px;">
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
                                                <input numericOnly="yes" style=" margin: 10px 20px 0 0;width: 113px; float: left;" type="text" name="Length" id="Length" value="<?php echo $product['Length']; ?>" class="input1" />
                                                <input numericOnly="yes" style=" margin: 10px 20px 0 0;width: 113px; float: left;" type="text" name="Width" id="Width" value="<?php echo $product['Width']; ?>" class="input1" />
                                                <input numericOnly="yes" style="margin: 10px 0 0 0; width: 113px; float: left;" type="text" name="Height" id="Height" value="<?php echo $product['Height']; ?>" class="input1" />
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <label class="margin_none"><?php echo DETAILS; ?><br/><small class="red"><?php echo MAXDETAILS; ?></small></label>
                                        <div class="input_sec">
                                            <textarea name="ProductDescription" cols="5" rows="5" maxlength="250"><?php echo $_POST['ProductDescription'] ? $_POST['ProductDescription'] : $product['ProductDescription'] ?></textarea>
                                        </div>
                                    </li>
                                    <li>
                                        <label class="margin_none"><?php echo TC; ?> </label>
                                        <div class="input_sec">
                                            <textarea name="ProductTerms" cols="5" rows="5"><?php echo $_POST['ProductTerms'] ? $_POST['ProductTerms'] : $product['ProductTerms'] ?></textarea>
                                        </div>
                                    </li>
                                    <li>
                                        <label class="margin_none"><?php echo YOUTUBE_EMB; ?></label>
                                        <div class="input_sec">
                                            https://www.youtube.com/embed/<input style="width: 200px!important; margin-top: -10px; float: right;" type="text" name="YoutubeCode" value="<?php echo $_POST['YoutubeCode'] ? $_POST['YoutubeCode'] : $product['YoutubeCode'] ?>" class="input1" />
                                        </div>
                                    </li>
                                    <li>
                                        <label class="margin_none"><?php echo HTML_EDI; ?></label>
                                        <div class="input_sec">
                                            <div class="html_editor">
                                                <textarea name="HtmlEditor" id="HtmlEditor"><?php echo $_POST['HtmlEditor'] ? $_POST['HtmlEditor'] : $product['HtmlEditor'] ?></textarea>
                                                <script type="text/javascript">
                                                    CKEDITOR.replace( 'HtmlEditor',
                                                    {
                                                        enterMode : CKEDITOR.ENTER_BR,
                                                        toolbar :[['Bold'],['Italic'],['Strike'],['Subscript'],['Superscript'],['RemoveFormat'],['NumberedList'],['BulletedList'],['Link'],['Unlink'],
                                                            ['Table'],['TextColor'],['BGColor'],['FontSize'],['Font'],['Styles']]
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <label class="margin_none"><?php echo META_TITLE; ?></label>
                                        <div class="input_sec">
                                            <textarea name="frmMetaTitle" cols="5" rows="2"><?php echo $_POST['frmMetaTitle'] ? $_POST['frmMetaTitle'] : $product['MetaTitle'] ?></textarea>
                                        </div>
                                    </li>
                                    <li>
                                        <label class="margin_none"><?php echo META_KEY; ?></label>
                                        <div class="input_sec">
                                            <textarea name="frmMetaKeywords" cols="5" rows="2"><?php echo $_POST['frmMetaKeywords'] ? $_POST['frmMetaKeywords'] : $product['MetaKeywords'] ?></textarea>
                                        </div>
                                    </li>
                                    <li>
                                        <label class="margin_none"><?php echo META_DES; ?></label>
                                        <div class="input_sec">
                                            <textarea name="frmMetaDescription" cols="5" rows="2"><?php echo $_POST['frmMetaDescription'] ? $_POST['frmMetaDescription'] : $product['MetaDescription'] ?></textarea>
                                        </div>
                                    </li>
                                    <li class="create_cancle_btn">
                                        <label style="visibility: hidden">.</label>
                                        <input type="hidden" name="fkWholesalerID" value="<?php echo $_SESSION['sessUserInfo']['id'] ?>" />
                                        <input type="hidden" name="action" value="update" />
                                        <input type="hidden" name="view" value="<?php echo $_REQUEST['action'] ?>" />
                                        <input type="hidden" name="pid" value="<?php echo $_REQUEST['pid'] ?>" />
                                        <input type="submit" name="submit" value="Submit" class="update_btn update1"/>
                                        <?php if (isset($_GET['action']) && $_GET['action'] == 'add') { ?><input type="submit" name="save_add_more" value="Save & Add" class="submit_and_add_more"/><?php } ?>
                                        <a href="<?php echo $objCore->getUrl('manage_products.php'); ?>"> <input type="button" value="Cancel" class="cancel"/></a>
                                    </li>
                                </ul>
                               </div> <div class="right_sec">
                                  
                                    <div class="clear_gap" style=""></div>
                                  
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
                        <td colspan="5"><strong><?php echo ADD_NEW_PACKAGE; ?></strong><div id="PkgAdded" style="color: green; width: 300px; margin-left: 200px;"></div></td>
                    </tr>
                    <tr align="left">
                        <td><?php echo PACKAGE_NAME; ?>:</td>
                        <td colspan="2">
                            <div class="input_star">
                                <input type="text" name="frmPackageName" id="frmPackageName" />
                                <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                            </div>
                        </td>
                        <td colspan="2">&nbsp;</td>
                    </tr>

                    <tr>
                        <td colspan="5">
                            <table border="0" id="productRow" cellpadding="5">
                                <tr align="left">
                                    <th>&nbsp;</th>
                                    <th><?php echo SEL; ?></th>
                                    <th colspan="2"><?php echo ORG_PRICE; ?></th>
                                </tr>
                                <tr align="left">
                                    <td><?php echo PRO_1; ?>:</td>
                                    <td> <div class="input_star">
                                            <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryList, 'frmCategoryId[]', '', array(0), 'Select Category', 0, 'onchange="ShowProductForPackage(this.value,1)" class="select2-me" style="width:429px"', '1', '1'); ?>
                                            <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input_star">
                                            <div class="drop4 dropdown_2" id="product1">
                                                <select name="frmProductId[]" style="width:170px" onchange="ShowProductPriceForPackage(this.value,1)" >
                                                    <option value="0"><?php echo PRODUCTS; ?></option>
                                                </select>
                                            </div>
                                            <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                        </div>
                                    </td>
                                    <td><span id="price1"><input type="hidden" name="frmPrice[]" value="0.00" /><b>0.00</b></span></td><td>&nbsp;</td>
                                </tr>
                                <tr align="left">
                                    <td><?php echo PRO_2; ?>:</td>
                                    <td>
                                        <div class="input_star">
                                            <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryList, 'frmCategoryId[]', '', array(0), 'Select Category', 0, 'onchange="ShowProductForPackage(this.value,2)" class="select2-me" style="width:429px"', '1', '1'); ?>
                                            <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input_star">
                                            <div class="drop4 dropdown_2" id="product2">
                                                <select name="frmProductId[]" style="width:170px;" onchange="ShowProductPriceForPackage(this.value,2)">
                                                    <option value="0"><?php echo PRODUCTS; ?></option>
                                                </select>
                                            </div>
                                            <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                        </div>
                                    </td>
                                    <td><span id="price2"><input type="hidden" name="frmPrice[]" value="0.00" /><b>0.00</b></span></td>
                                    <td><span style="cursor: pointer;" onclick="addDynamicRowToTableForPackage('productRow');"><img src="admin/images/plus.png" /></span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr align="left">
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><?php echo TOTAL_PRICE; ?>:</td>
                        <td colspan="4"><span id="asc" style="font-weight: bold;">0.00</span><input type="hidden" name="frmTotalPrice" id="frmTotalPrice" value="0.00"  /></td>
                    </tr>
                    <tr align="left">
                        <td style="font-family: Arial,Helvetica,sans-serif; font: 12px;"><?php echo OFF_PRICE; ?>:</td>
                        <td>
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
                    <tr>   <td>&nbsp;</td>
                        <td align="left" colspan="4">
                            <input type="submit" name="frmConfirmDelete" id="frmConfirmDelete" value="Create"  />
                            <input type="button" name="cancel" id="cancel" value="<?php echo CANCEL; ?>" />
                        </td>
                    </tr>

                </table>

            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
             $('#cboxOverlay').css('z-index','9');       
<?php echo $strImgScript; ?>

    });
        </script>
        
        <style type="text/css" >
            .select2-drop.select2-with-searchbox.select2-drop-active{
                z-index: 2147483647 !important;
            }
            #productRow{font-size:13px !important;}
        </style>
        
    </body>
</html>
