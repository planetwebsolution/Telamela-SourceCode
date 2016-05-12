<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_MANAGE_PRODUCT_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo WHOLESALER_ADD_MULTI_PRODUCT_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <?php require_once INC_PATH . 'img_crop_js_css.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.mousewheel.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>browse.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH ?>browse.js"></script>
        <link rel="stylesheet" href="<?php echo CSS_PATH ?>select2.css"/>           
        <script src="<?php echo JS_PATH ?>select2.min.js"></script>
        <?php
        $VarShipping = '<div class="check_box">';
        foreach ($objPage->arrShippingGatwayList as $key => $val)
        {
            $varShipping = explode(',', $product['fkShippingID']);
            $selected = in_array($val['pkShippingGatewaysID'], $varShipping) ? 'checked="checked"' : '';
            $VarShipping .= '<div style="float:left;width:99%"><input class="validate[minCheckbox[1]]" style="float:left;" type="checkbox" name="frmShippingGateway[0][]" value="' . $val['pkShippingGatewaysID'] . '" /><small>' . $val['ShippingTitle'] . '</small></div>';
        }
        $VarShipping .= '</div>';
        ?>
        <script>
		
            jQuery(document).ready(function(){
                // binds form submission and fields to the validation engine
                //jQuery("#frm_page").validationEngine();
                
                $('.scroll-pane').jScrollPane();
			
                $('.mutli_product').css('height','100%');
                $('.jspContainer').css('height','320px');
                $(".select2-me").select2();
                $('.checkradios').checkradios();
            });
        
            var SHIPPINGDETAILS ='<?php echo $VarShipping; ?>';

        </script>
        <link rel="stylesheet" href="<?php echo SITE_ROOT_URL ?>asdmin/css/colorbox.css" />
        <script src="<?php echo JS_PATH ?>functions_js.js"></script>
        <script src="<?php echo JS_PATH ?>multi_product_js.js"></script>
        <script  type="text/javascript" src="<?php echo JS_PATH ?>product_multiple_add.js"></script>
        <script type="text/javascript" src="<?php echo CKEDITOR_URL; ?>ckeditor.js"></script>
        <script  type="text/javascript" src="<?php echo JS_PATH ?>jquery.checkradios.min.js"></script>
        <link rel="stylesheet" href="<?php echo CSS_PATH ?>jquery.checkradios.min.css" type="text/css"/>       
        <link rel="stylesheet" href="<?php echo CSS_PATH ?>product_multiple_add.css" />
        <style>
            .input_star .star_icon{ right:0px; }
            .input_star{ margin-right:8px;}
            .check_box small{ line-height:20px;}
            .customfile1 { background:#fff; width:60%;  }
            .customfile1-input{ position:static}
            .check_box small{float:none;}
			
			

        </style>
    </head>
    <body>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout"></div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>

        </div>

        <div id="ouderContainer" class="ouderContainer_1">
            <div style="width:100%;height:50px; padding-top:20px;	  border-bottom:1px solid #e7e7e7;">
                <div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div>
            </div>
            <div class="layout">

                <div class="add_pakage_outer">
                    <div class="top_container">
                        <div class="top_header border_bottom">
                            <h1><?php echo ADD; ?> &amp; <?php echo EDIT; ?> <?php echo PRODUCTS; ?></h1>
                        </div>
                    </div>

                    <?php $product = $objPage->productDetail[0]; ?>
                    <div class="body_inner_bg">
                        <div class="add_edit_pakage">
                            <div class="back_ankar_sec" style="padding-top:0px;"><a href="<?php echo $objCore->getUrl('manage_products.php'); ?>" class="back"><span><?php echo BACK; ?></span></a></div>
                           
                            <div class="mutli_product scroll-pane">
                                <form onsubmit="return validateMultipleProductAddForm('frm_page');" autocomplete="off" action="" method="post" name="frm_page" id="frm_page" enctype="multipart/form-data">
                                    <input type="hidden" name="frmMarginCast" id="frmMarginCast" value="<?php echo $objPage->arrMarginCost[0]['MarginCast']; ?>" />
                                    <input type="hidden" name="frmfkWholesalerID" id="frmfkWholesalerID" value="<?php echo $objPage->wid; ?>" />
                                    <input type="hidden" name="multiAdd" id="multiAdd" value="1" />
                                    <input type="hidden" name="action" id="action" value="addMulti" />
                                    <table width="99%" border="0" cellspacing="0" cellpadding="0" style="float:left;padding:20px;background-color: #f5f5f5;" class="left_content">
                                        <tr>
                                            <td>
                                                <table cellpadding="0" cellspacing="0" border="0" class="left_content" style="width:100%" id="MultipleProduct" >
                                                    <tr class="content" style="">
                                                        <td valign="top"><label><?php echo PRO_REF_NO; ?></label></td>
                                                        <td valign="top"><label><?php echo PROD_NAME; ?></label></td>
                                                        <td valign="top"><label><?php echo SHIPPING_GATEWAY; ?></label></td>
                                                        <td valign="top"><label><?php echo PRICE; ?> <?php echo IN_D; ?></label></td>
                                                        <td valign="top"><label><?php echo FIN; ?>&nbsp;<?php echo PRICE; ?><?php echo IN_D; ?></label></td>
                                                        <td valign="top"><label><?php echo UPLOAD_IMAGE; ?></label></td>
                                                        <td valign="top"><label><?php echo CATEGORY_TITLE; ?></label></td>
                                                        <td valign="top"><label><?php echo SEL_PACK; ?></label></td>
                                                        <td valign="top"><label><?php echo STOCK_QUAN; ?></label></td>
                                                        <td valign="top"><label title="<?php echo SEND_ALERT_MESSAGE; ?>"><?php echo STOCK_ALERT; ?></label></td>
                                                        <td valign="top"><label><?php echo WAIGHT; ?></label></td>
                                                        <td valign="top"><label><?php echo DIMEN; ?></label></td>
                                                        <td valign="top"><label><?php echo DETAILS; ?></label></td>
                                                        <td valign="top"><label><?php echo TC; ?></label></td>
                                                        <td valign="top"><label><?php echo YOUTUBE_EMB; ?></label></td>
                                                        <td valign="top"><label><?php echo META_TITLE; ?></label></td>
                                                        <td valign="top"><label><?php echo META_KEY; ?></label></td>
                                                        <td valign="top"><label><?php echo META_DES; ?></label></td>
                                                        <td valign="top"><label><?php echo HTML_EDI; ?></label></td>
                                                        <td valign="top"><label>&nbsp;</label></td>
                                                        <td valign="top"><label>&nbsp;</label></td>
                                                    </tr>
                                                    <!--tr><td>&nbsp;</td></tr-->
                                                    <tr class="content">
                                                        <td valign="top">
                                                            <div class="input_star"><input name="frmProductRefNo[]" type="text" value="" class="input1 validate[required,custom[integer]]" onkeyup="checkProductRefNoForMultiple(this.value,1);" onmousemove="checkProductRefNoForMultiple(this.value,1);" onchange="checkProductRefNoForMultiple(this.value,1);" /><small class="star_icon"><img alt="" src="common/images/star_icon.png"></small></div><br />
                                                            <span id="refmsg1" class="req"><input type="hidden" name="frmIsRefNo[]" value="0" /></span>
                                                        </td>
                                                        <td valign="top"><div class="input_star"><input name="frmProductName[]" type="text" value="" class="input1 validate[required,maxSize[100]]" /><small class="star_icon"><img alt="" src="common/images/star_icon.png"></small></div></td>
                                                        <td valign="top">
                                                            <div class="check_box">
                                                                <?php
                                                                foreach ($objPage->arrShippingGatwayList as $key => $val)
                                                                {
                                                                    $varShipping = explode(',', $product['fkShippingID']);
                                                                    $selected = in_array($val['pkShippingGatewaysID'], $varShipping) ? 'checked="checked"' : '';
                                                                    echo '<div style="float:left;width:100%"><input class="validate[minCheckbox[1]] checkradios" style="float:left;" type="checkbox" name="frmShippingGateway[0][]" value="' . $val['pkShippingGatewaysID'] . '" /><small>' . $val['ShippingTitle'] . '</small></div>';
                                                                }
                                                                ?>


                                                            </div>
                                                        </td>
                                                        <td valign="top">
                                                            <div class="input_star"><input numericOnly="yes" style="margin-bottom: 5px;" placeholder="Wholesale Price" name="frmWholesalePrice[]" id="frmWholesalePrice1" type="text" value="" class="input0 validate[required,custom[integer]]" onkeyup="showFinalPriceForMultipleProduct(1);" onchange="showFinalPriceForMultipleProduct(1);" onBlur="checkPositive(this.value,this.id);" /><small class="star_icon"><img alt="" src="common/images/star_icon.png"></small></div><br/>
                                                            <input numericOnly="yes" name="frmDiscountPrice[]" placeholder="Discount Price" id="frmDiscountPrice1" type="text" value="" class="input0 validate[required,custom[integer]]" onkeyup="showDiscountPriceForMultipleProduct(1);" onchange="showDiscountPriceForMultipleProduct(1);" onBlur="checkPositive(this.value,this.id);"/></td>
                                                            <td valign="top">
                                                                <span style="line-height: 34px;" id="FinalPrice1"></span><input name="frmProductPrice[]" id="frmProductPrice1" type="hidden" value="" class="input0" /><br />
                                                                <span style="line-height: 28px;" id="DiscountFinalPrice1"></span><input name="frmDiscountFinalPrice[]" id="frmDiscountFinalPrice1" type="hidden" value="" class="input0" />

                                                            </td>
                                                        
                                                        <td valign="top">
                                                            <div id="addinput_1"> 
                                                                <div class="imgimg">
                                                                    <div class="responce"></div>
                                                                    <input type="file" name="file_upload[]" id="frmProductImg1" class="customfile1-input file file_upload_multi" value="" size="1"  />
                                                                    <a class="delete_icon2" href="#" style="display: none;"></a>
                                                                </div>
                                                                <div class="add_more_images"><a row="1" class="more more_images" href="#"><small class="multi"> <?php echo ADD_MORE ?> +</small></a></div>
                                                            </div> 
                                                        </td>


                                                        <td valign="top">
                                                            <div class="drogp1 dropdgown_4">
                                                                <div class="input_star">
                                                                    <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryList, 'frmfkCategoryID[]', '', array($product['fkCategoryID']), SEL_CAT, 0, 'onchange="ShowAttributeMultipleProduct(this.value,1);" class="select2-me" style="width:178px"', '1', '1'); ?>
                                                                    <small class="star_icon"><img alt="" src="common/images/star_icon.png"></small>
                                                                </div>
                                                            </div>
                                                            <span><a onclick="return jscall33(1)" href="#listed1" class="cboxElement create_pkg_color_box more"><small class="multi"><?php echo ADD_ATTR; ?></small></a></span>


                                                            <div style="display:none;">
                                                                <div id="listed1" style="padding:15px 10px 10px 20px;">
                                                                    <div style="width: 95%; font-weight: bold; padding-bottom: 10px;"><?php echo SEL_ATTR; ?></div>
                                                                    <div id="attribute1">
                                                                        <input type="hidden" name="frmIsAttribute[]" value="0" /><?php echo SEL_CAT; ?>
                                                                    </div><br /><br />
                                                                    <input type="button" name="cancel1" id="cancel1" value="Ok" class="button" style="margin:10px 0 10px 0" />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td valign="top">
                                                            <div class="drop1 dropdown_4">
                                                                <select class="drop_down1"  name="frmfkPackageId[]" style="width:100px;">
                                                                    <option value="0"><?php echo SEL_PACK; ?></option>
                                                                    <?php
                                                                    foreach ($objPage->packageList as $keyPackage => $valPackage)
                                                                    {
                                                                        ?>
                                                                        <option value="<?php echo $valPackage['pkPackageId']; ?>"><?php echo $valPackage['PackageName']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>

                                                        </td>
                                                        <td valign="top">
                                                            <div class="input_star"><input numericOnly="yes" name="frmQuantity[]" id="frmQuantity_1" placeholder="Stock Quantity" type="text" value="" class="input0 validate[required,custom[integer]]" onBlur="checkPositive(this.value,this.id);"/><small class="star_icon"><img alt="" src="common/images/star_icon.png"></small></div>&nbsp;&nbsp;
                                                        </td>
                                                        <td valign="top">
                                                            <input numericOnly="yes" name="frmQuantityAlert[]" id="frmQuantityAlert_1" placeholder="Stock Quantity Alert" type="text" value="" class="input0 validate[required,custom[integer]]" onBlur="checkPositive(this.value,this.id);"/>&nbsp;&nbsp;
                                                        </td>
                                                        <td valign="top">
                                                            <div class="drop6">
                                                                <div class="cent_box">
                                                                    <select class="drop_down1" name="frmWeightUnit[]" style="width:83px;">
                                                                        <?php
                                                                        $varArr = array('kg' => 'Kilogram', 'g' => 'Gram', 'lb' => 'Pound', 'oz' => 'Ounce');
                                                                        foreach ($varArr as $key => $varArrValue)
                                                                        {
                                                                            ?>

                                                                            <option value="<?php echo $key; ?>"><?php echo $varArrValue; ?></option>
                                                                        <?php } ?>
                                                                    </select></div><div class="cb"></div>
                                                                <input numericOnly="yes" style="margin: 10px 0 0 0; width: 158px !important;" type="text" name="frmWeight[]" id="Weight" value="" class="input1" />
                                                            </div>
                                                        </td>
                                                        <td valign="top">
                                                            <div class="drop6">
                                                                <div class="cent_box">
                                                                    <select class="drop_down1" name="frmDimensionUnit[]" style="width:83px;">
                                                                        <option selected="selected" value="cm" ><?php echo CENTI; ?></option>
                                                                        <option value="mm" <?php
                                                                        if ($product['DimensionUnit'] == 'mm')
                                                                        {
                                                                            echo 'selected="selected"';
                                                                        }
                                                                        ?>><?php echo MILLI; ?></option>
                                                                        <option value="in" <?php
                                                                                if ($product['DimensionUnit'] == 'in')
                                                                                {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                        ?>><?php echo INCH; ?></option>
                                                                    </select></div>
                                                                <div class="cb"></div>
                                                                <input numericOnly="yes" placeholder="L" style="margin: 10px 5px 0 0;width: 41px !important; text-align:center; float: left;" type="text" name="frmLength[]" id="Length" value="" class="input1" />
                                                                <input numericOnly="yes" placeholder="W" style="margin: 10px 5px 0 0;width: 41px !important; float: left;text-align:center;" type="text" name="frmWidth[]" id="Width" value="" class="input1" />
                                                                <input numericOnly="yes" placeholder="H" style="margin: 10px 10px 0 0; width: 41px !important; float: left;text-align:center;" type="text" name="frmHeight[]" id="Height" value="" class="input1" />
                                                            </div>
                                                        </td>

                                                        <td valign="top">
                                                            <textarea style="width: 300px;margin:0 10px 10px 0;" name="frmProductDescription[]" rows="3" class="input1" maxlength="250"></textarea>
                                                        </td>

                                                        <td valign="top">
                                                            <textarea style="width: 300px; margin:0 10px 10px 0;" name="frmProductTerms[]" rows="3" class="input1"></textarea>                                                </td>
                                                        <td valign="top">
                                                            <textarea style="width: 300px; margin:0 10px 10px 0;" name="frmYoutubeCode[]" rows="3" class="input1"></textarea>
                                                        </td>



                                                        <td valign="top">
                                                            <textarea style="width: 300px;margin:0 10px 10px 0;" name="frmMetaTitle[]" rows="3" class="input1"></textarea>
                                                        </td>

                                                        <td valign="top">
                                                            <textarea style="width: 300px; margin:0 10px 10px 0;" name="frmMetaKeywords[]" rows="3" class="input1"></textarea>                                                </td>
                                                        <td valign="top">
                                                            <textarea style="width: 300px; margin:0 10px 10px 0;" name="frmMetaDescription[]" rows="3" class="input1"></textarea>
                                                        </td>

                                                        <td valign="top" style="width: 30%;">
                                                            <script type="text/javascript">
                                                                var editor
                                                                function createEditor(arg1)
                                                                {
                                                                    if ( editor ){
                                                                        alert('<?php echo HIDE_OPEN_EDITOR; ?>');
                                                                        return;
                                                                    }
                                                                    // Create a new editor inside the <div id="editor">, setting its value to html
                                                                    document.getElementById('shwhde'+arg1).innerHTML='<input onclick="removeEditor('+arg1+');" type="button" value="Hide Editor" class="show_editor"/>';
                                                                    var config = {enterMode : CKEDITOR.ENTER_BR,
                                                                        toolbar :[['Bold'],['Italic'],['Strike'],['Subscript'],['Superscript'],['RemoveFormat'],['NumberedList'],['BulletedList'],['Link'],['Unlink'],
                                                                            ['Table'],['TextColor'],['BGColor'],['FontSize'],['Font'],['Styles']]
                                                                    };
                                                                    var htm = document.getElementById('editorcontents'+arg1).innerHTML;
                                                                    // alert(htm);
                                                                    var hit = parseInt($('.jspContainer').css('height'))+80+'px';

                                                                    $('.jspContainer').css('height',hit);
                                                                    editor = CKEDITOR.appendTo( 'editor'+arg1, config, htm);



                                                                }

                                                                function removeEditor(arg1)
                                                                {
                                                                    if ( !editor )
                                                                        return;

                                                                    // Retrieve the editor contents. In an Ajax application, this data would be
                                                                    // sent to the server or used in any other way.
                                                                    document.getElementById('editorcontents'+arg1).innerHTML = editor.getData();
                                                                    document.getElementById('frmHtmlEditor'+arg1).innerHTML = editor.getData();
                                                                    //html = editor.getData();
                                                                    //document.getElementById( 'contents' ).style.display = '';

                                                                    // Destroy the editor.
                                                                    document.getElementById('shwhde'+arg1).innerHTML='<input onclick="createEditor('+arg1+');" type="button" value="Show Editor"  class="show_editor"/>';
                                                                    var hit = parseInt($('.jspContainer').css('height'))-80+'px';

                                                                    $('.jspContainer').css('height',hit);
                                                                    editor.destroy();
                                                                    editor = null;
                                                                }

                                                                //]]>
                                                            </script>
                                                            <span id="shwhde1"><input onclick="createEditor(1);" type="button" value="Show Editor"  class="show_editor"/></span>
                                                            <br/>
                                                            <div id="editorcontents1" style="display: none;z-index: 9999999;">

                                                            </div>
                                                            <div style="display: none;">
                                                                <textarea name="frmHtmlEditor[]" id="frmHtmlEditor1"></textarea>
                                                            </div>
                                                            <div id="editor1" style="z-index: 999; position: absolute; width:500px; margin-left: -200px"></div>

                                                        </td>
                                                        <td valign="top"><i><span style="cursor: pointer;" onclick="addDynamicRowToTableForMultipleProduct('MultipleProduct');"><img src="common/images/addmore.png" style="margin-left: -0px;margin-top: 15px;" /></span></i></td>
                                                        <td valign="top">&nbsp;</td>
                                                    </tr></table>



                                                <table cellpadding="" cellspacing="0" border="0" class="left_content" style="width:100%">
                                                    <tr class="content">
                                                        <td><?php echo NOTE; ?> : <span class="req">*</span><?php echo MANDATORY; ?></td>
                                                    </tr>
                                                    <tr><td>&nbsp;</td></tr>
                                                    <tr class="content">
                                                        <td class="create_cancle_btn">
                                                            <input type="submit" class="submit3" name="btnPage" value="Upload" style="float:left;" />
                                                            <input type="hidden" name="frmHidenAdd" id="frmHidenAdd" value="addMultiple" />
                                                            <a id="buttonDecoration" href="<?php echo $objCore->getUrl('manage_products.php'); ?>">
                                                                <input type="button" class="cancel" name="btnTagSettings" value="Cancel" /></a>
                                                        </td>

                                                    </tr>

                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                            

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>



    </body>
</html>