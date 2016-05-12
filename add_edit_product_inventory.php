<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_PRODUCT_PRICE_INVENTORY_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo ADD_EDIT_PRODUCT_INVENTORY_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once INC_PATH . 'comman_css_js.inc.php'?>
        <?php require_once INC_PATH . 'img_crop_js_css.inc.php'?>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>browse.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH?>browse.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH?>product_add_edit.js"></script>
        <script type="text/javascript" src="<?php echo CKEDITOR_URL?>ckeditor.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function(){
            // binds form submission and fields to the validation engine
            jQuery("#add_edit_product_inventory").validationEngine();
            var errReq = '<div class="frmQtyformError parentFormadd_edit_product_inventory formError" style="opacity: 0.87; position: absolute; top: 0px; left: 457px; margin-top: 46px;"><div class="formErrorContent">*This field is required!<br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>';
            var errInt = '<div class="frmQtyformError parentFormadd_edit_product_inventory formError" style="opacity: 0.87; position: absolute; top: 0px; left: 457px; margin-top: 46px;"><div class="formErrorContent">* Not a valid integer!<br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>';
                
            jQuery('.applyQty').live('click', function() {
            var qtyVal = jQuery('#frmQty');
            var valQ = jQuery.trim(qtyVal.val());

            if(valQ==''){
            //alert('Please enter quanty');
            jQuery('#errApplyAll').html(errReq);
            qtyVal.focus();
            return false;
            }else if(IsDigits(valQ)){
            // alert("Please Enter numeric value!");
            jQuery('#errApplyAll').html(errInt);
            qtyVal.focus();
            return false;
            }else{
            jQuery('.qty').val(valQ);
            }
            });
            });
            
            function IsDigits(str){
            str = trim(str);    
            var regDigits = /[^\d]/g;
            return regDigits.test(str);

            }
        </script>
        <style>.input_sec span{padding:0px;}.datepick-trigger{margin: 31px 0 0 -19px; position: relative;} .dashboard_title{background:#60494A; color: rgb(255, 255, 255); padding: 0px 9px; border-radius: 4px 4px 4px 4px; margin: 0px 0px 9px; width: 114%;}
            #cboxLoadedContent{margin-top:-2px !important;} .imgimg{ float: left;}
            .add_edit_pakage label{ width:320px; margin-right:10px;}

        </style>
        <script src="<?php echo JS_PATH ?>jquery.dd.js"></script>
    </head>
    <body>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout"> </div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>

        </div>

        <div id="ouderContainer" class="ouderContainer_1"><div style="width:100%;height:50px; padding-top:16px;	border-bottom:1px solid #e7e7e7;"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>

            <div class="add_pakage_outer" style="float:none; margin:0px auto">
                <div class="top_container">
                    <div class="top_header border_bottom"><h1>Manage Inventory</div>
                </div>

                <?php $product = $objPage->productDetail[0]; ?>
                <div class="body_inner_bg">
                    <form name="add_edit_product_inventory" id="add_edit_product_inventory" action="" method="POST" enctype="multipart/form-data">
                        <div class="add_edit_pakage">
                            <div class="back_ankar_sec">
                                <a href="<?php echo $objCore->getUrl('manage_products.php'); ?>" class="back"><span><?php echo BACK; ?></span></a>
                            </div>
                            <?php if (count($objPage->arrCombinedAttrOpt) > 0) { ?>
                                <span class="red">
                                    * Fields are required.
                                </span> <ul class="left_sec" style="width:90%;">
                                    <li class="pro_invent_hd">

                                        <label><span style="font-weight:700; margin-right:110px;"><?php echo 'Option Combination'; ?></span>
                                            <span style="font-weight:700;"> Quantity</span>
                                        </label>
                                        <div class="input_sec">                                                                                        
                                            <div id="errApplyAll"></div>                                           
                                            <input type="text" name="frmQty" id="frmQty" value="" class="" />
                                            <a href="javascript:void(0);" class="applyQty qty_apply_btn">Apply All</a> 
                                        </div>
                                    </li>
                                    <?php
                                    foreach ($objPage->arrCombinedAttrOpt as $val) {
                                        $varChecked = ($vOpt['OptionIsDefault'] == 1) ? 'checked="checked"' : '';
                                        $varReadonly = ($varChecked <> '') ? 'readonly' : '';
                                        ?>
                                        <li class="heading cb list_height">
                                            <label>
                                                <?php echo $val['AttributeOptionValue']; ?><strong>:</strong>
                                            </label>
                                            <?php
                                            //pre($objPage->arrAttrOptQty);
                                            $combVal=explode(',',$val['fkAttributeOptionId']);
                                            sort($combVal);
                                            $combValNew=implode(',',$combVal);
                                            
                                            foreach($objPage->arrAttrOptQty as $key=>$values){
                                                $comb=explode(',',$key);
                                                sort($comb);
                                                $combValNewCom=implode(',',$comb);
                                                $arrAttrOptQty[$combValNewCom]=$values;
                                            }
                                            //pre($arrAttrOptQty);
                                            
                                            ?>
                                            <div class="input_sec input_star pro_invent_fld">                                                
                                                <input type="hidden" name="frmOptIds[]" value="<?php echo $val['fkAttributeOptionId']; ?>" />
                                                <input type="text" name="frmQuantity[]" value="<?php echo $arrAttrOptQty[$combValNew]; ?>"  class="qty validate[required,custom[integer],min[1]]" />
                                                <small class="star_icon" style="right:1px;"><img src="common/images/star_icon.png" alt=""/></small>
                                            </div>
                                        </li>
                                    <?php }
                                    ?>
                                </ul>                                
                                <ul class="left_sec" style="width:90%;">                                        
                                    <li>
                                        <label>&nbsp;</label>

                                    </li>
                                    <li class="create_cancle_btn cb">
                                        <label style="visibility: hidden">.</label>
                                        <input type="hidden" name="fkWholesalerID" value="<?php echo $_SESSION['sessUserInfo']['id'] ?>" />
                                        <input type="hidden" name="frmHidenAdd" id="frmHidenAdd" value="updateInventory" />                                        
                                        <input type="hidden" name="pid" value="<?php echo $_REQUEST['pid'] ?>" />
                                        <input type="submit" name="submit" value="Submit" class="submit3"/>
                                        <?php if (isset($_GET['action']) && $_GET['action'] == 'add') { ?><input type="submit" name="save_add_more" value="Save & Add" class="submit3"/><?php } ?>
                                        <a href="<?php echo $objCore->getUrl('manage_products.php'); ?>"> <input type="button" value="Cancel" class="cancel"/></a>
                                    </li>
                                </ul><?php } else { ?>
                                <ul class="left_sec">
                                    <li><span class="red"><b> There is no attribute(s) in this product</b></span></li>
                                </ul>
                            <?php } ?>


                            <!--
                            <div class="right_sec">
                                <a href="<?php echo $objCore->getUrl('bulk_uploads.php'); ?>" class="update"><?php echo UP_PRODUCTS; ?></a>
                                <div class="clear_gap" style=""></div>
                                <a href="<?php echo $objCore->getUrl('add_multi_product.php', array('action' => 'addMutiple')); ?>" class="add_m_product update"><?php echo ADD_MULTI_PRODUCT; ?></a>
                            </div>-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>        
    </body>
</html>
