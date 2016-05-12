<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_PRODUCT_PRICE_INVENTORY_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo ADD_EDIT_PRODUCT_PRICE_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once INC_PATH . 'comman_css_js.inc.php'; ?>
        <?php require_once INC_PATH . 'img_crop_js_css.inc.php'; ?>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>browse.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH ?>browse.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>product_add_edit.js"></script>
        <script type="text/javascript" src="<?php echo CKEDITOR_URL; ?>ckeditor.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                // binds form submission and fields to the validation engine
                jQuery("#add_edit_product_price").validationEngine();
                jQuery('.default').live('change', function() {         
                    var objOptAttr = $(this);
                    //alert($(this).val());
                    objOptAttr.parent().parent().parent().parent().find('.price_opt').attr('readonly',false);
                    objOptAttr.parent().parent().find('.price_opt').attr('readonly',true);
                    //objOptAttr.parent().siblings('.price_opt').attr('readonly',true);
                    objOptAttr.parent().parent().find('.price_opt').val('0.0000');
                });    
            });
        </script>
        <style>.input_sec span{padding:0px;}.datepick-trigger{margin: 31px 0 0 -19px; position: relative;} .dashboard_title{background:#60494A; color: rgb(255, 255, 255); padding: 0px 9px; border-radius: 4px 4px 4px 4px; margin: 0px 0px 9px; width: 114%;}
            #cboxLoadedContent{margin-top:-2px !important;} .imgimg{ float: left;}

        </style>
         <script src="<?php echo JS_PATH ?>jquery.dd.js"></script>
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
                        <div class="top_header border_bottom"><h1>Manage Price</h1></div>
                    </div>
                    
                    <?php $product = $objPage->productDetail[0]; ?>
                    <div class="body_inner_bg">
                                                <br/>
                        <form name="add_edit_product_price" id="add_edit_product_price" action="" method="POST" enctype="multipart/form-data" class="ad_edit_pro_price_input_fld">
                          <small style=" float:left !important; clear:both;padding-bottom:20px;" class="req_field">* Fields are required </small>  <div class="add_edit_pakage">
                                <!--<div class="back_ankar_sec">
                                    <a href="<?php// echo $objCore->getUrl('manage_products.php'); ?>" class="back"><span><?php// echo BACK; ?></span></a>
                                </div>-->
                                <?php
                                if (count($objPage->productToAttributeOptions) > 0) {
                                    $ctr = 0;
                                    //pre($objPage->productToAttributeOptions);
                                    foreach ($objPage->productToAttributeOptions as $val) {
                                        ?><ul class="left_sec">
                                            <li style="background-color: #FFFFFF;"><h3><?php echo $val['AttributeLabel'] . ' (' . $val['AttributeCode'] . ')' ?></h3></li>
                                            <?php
                                             foreach ($val['options'] as $key=>$vOpt) {
                                                ?>
                                                <li class="heading">
                                                    <label><?php echo $val['AttributeCode'] . ' (' . $vOpt['AttributeOptionValue'] . ')' ?><strong>:</strong></label>
                                                    <div class="input_sec input_star">
                                                        <div class="">
                                                            <input type="radio" name="default_<?php echo $val['pkAttributeID']; ?>" value="<?php echo $vOpt['pkProductAttributeId']; ?>" <?php if($vOpt['OptionIsDefault']==1){
                                                                echo 'checked="checked"';
                                                            }else if($key==0){
                                                                echo 'checked="checked"';
                                                            };?> class="default validate[required]" />Default
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            Additional&nbsp;Price
                                                        </div>
                                                        <div class="frmPrice_box">
                                                        <input type="text" name="frmPrice[<?php echo $val['pkAttributeID']; ?>][<?php echo $vOpt['pkProductAttributeId']; ?>]" value="<?php echo $vOpt['OptionExtraPrice'] ?>" <?php if($vOpt['OptionIsDefault']==1){
                                                                echo 'readonly="readonly"';
                                                            }else if($key==0){
                                                                echo 'readonly="readonly"';
                                                            } ?>  class="price_opt validate[required,custom[numberPositive]] pro_price_input_box" />
                                                        <small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php }
                                            ?>
                                        </ul>
                                        <?php
                                   $ctr++; }
                                    ?> 
                                    <ul class="left_sec" style="clear:both">
                                        <li>
                                            <span class="red">
                                              
                                                <b>Note:</b> Every type of attributes should have a default option. So default price should be 0
                                            </span>
                                        </li>
                                        <li class="create_cancle_btn">
                                            <!--<label style="visibility: hidden">.</label>-->
                                            <input type="hidden" name="fkWholesalerID" value="<?php echo $_SESSION['sessUserInfo']['id'] ?>" />
                                            <input type="hidden" name="frmHidenAdd" id="frmHidenAdd" value="updatePrice" />                                        
                                            <input type="hidden" name="pid" value="<?php echo $_REQUEST['pid'] ?>" />
                                            <input type="submit" name="submit" value="Submit" class="submit3"/>
                                            <?php if (isset($_GET['action']) && $_GET['action'] == 'add') { ?><input type="submit" name="save_add_more" value="Save & Add" class="submit3"/><?php } ?>
                                            <a href="<?php echo $objCore->getUrl('manage_products.php'); ?>"> <input type="button" value="Cancel" class="cancel"/></a>
                                        </li>
                                    </ul>

                                <?php } else { ?>
                                    <ul class="left_sec">
                                        <li><span class="red"><b> There is no attribute(s) in this product</b></span></li>
                                    </ul>
                                <?php } ?>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>        
    </body>
</html>
