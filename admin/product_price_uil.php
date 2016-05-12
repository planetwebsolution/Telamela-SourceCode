<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_PRODUCT_PRICE_INVENTORY_CTRL;
//pre($_SESSION['sessAdminCountry']);
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
            Cal=jQuery.noConflict();
            Cal(document).ready(function(){
                Cal('#frmDateStart').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif"  alt="Popup" style=" margin: -1px 0 0 -31px;" class="trigger">'});
                Cal('#frmDateEnd').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" style=" margin:-1px 0 0 -25px"  class="trigger">'});
            
                Cal('.default').live('change', function() {        
                    var objOptAttr = $(this);         
                    
                    objOptAttr.parent().parent().parent().find('.price_opt').attr('readonly',false);
                    objOptAttr.parent().parent().find('.price_opt').attr('readonly',true);
                    objOptAttr.parent().parent().find('.price_opt').val('0.0000');
                    
                });
            
            
            });
            
            
        </script>
        <?php require_once 'inc/common_css_js.inc.php'; ?>

        <?php require_once 'inc/img_crop_js_css.inc.php'; ?>

        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <script type="text/javascript" src="js/product_admin.js"></script>

        <link rel="stylesheet" href="css/colorbox.css" />
        <script src="../colorbox/jquery.colorbox.js"></script>
        <script type="text/javascript">
            function validateProductPriceForm(obj){
                var vobj = $(obj);
                
                var error = '';
                var foc;
                
                 
                vobj.find('.price_opt').each(function(){                                                       
                    if(error==''){                        
                       
                        var defn = $(this).parent().parent().find('input:radio').attr('name');                                                
                        if(vobj.find('input:radio[name='+defn+']').is(':checked')==false){
                            error = "Please select Default Price value!";
                            foc = $(this).parent().parent().find('input:radio');                           
                        
                        }else if($(this).val()==''){
                            error = "Please Enter Extra price!";
                            foc = $(this);                       
                        
                        }else if($(this).val()<0){
                            error = "Please Enter numric price!";
                            foc = $(this);                       
                        
                        }else if(!AcceptDecimal($(this).val())){
                            error = "Please Enter numeric or decimal value!";
                            foc = $(this);                       
                        
                        }                        
                    }
                });
                
                
                if(error!=''){
                    alert(error);
                    foc.focus();
                    return false;
                }
                
                
                
            }
            
        </script>
    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>

        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Manage Price</h1>
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
                                <span>Manage Price</span>
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
                                            <!--<a href="product_add_multiple_uil.php?type=addMultiple" id="buttonDecoration"><input type="button" style="float:right; margin:6px 2px 0 0;" value="Click to add multiple Products" name="btnTagSettings" class="btn"></a>-->

                                            <div class="box-title">
                                                <h3>Manage Price</h3>
                                            </div>
                                            <div class="box-content nopadding">

                                                <?php require_once('javascript_disable_message.php'); ?>
                                                <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('edit-products', $_SESSION['sessAdminPerMission'])) { ?>
                                                    <?php $httpRef = (isset($_REQUEST['httpRef'])) ? $_REQUEST['httpRef'] : $_SERVER['HTTP_REFERER']; ?>

                                                    <form action=""  method="post" id="frm_page" onsubmit="return validateProductPriceForm(this);" enctype="multipart/form-data" >
                                                        <div class="row-fluid">
                                                            <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                <?php if (count($objPage->productToAttributeOptions) > 0) { ?>
                                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 200px">Attributes/Options</th>                                                                            
                                                                                <th style="width: 120px">Additional Price</th>
                                                                                <th style="width: 50px">Default</th>
                                                                                <th>&nbsp;</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <?php foreach ($objPage->productToAttributeOptions as $val) {
                                                                            ?>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td colspan="4"><b><?php echo $val['AttributeLabel'] . ' (' . $val['AttributeCode'] . ')' ?></b></td>
                                                                                </tr>
                                                                                <?php
                                                                                $i = 0;
                                                                                foreach ($val['options'] as $vOpt) {
                                                                                    $varChecked = '';
                                                                                    $varReadonly = '';
                                                                                    if ($vOpt['OptionIsDefault'] == 1 && $i == 0) {
                                                                                        $varChecked = 'checked="checked"';
                                                                                        $varReadonly = 'readonly';
                                                                                        $i++;
                                                                                    }
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td>* <?php echo $val['AttributeCode'] . ' (' . $vOpt['AttributeOptionValue'] . ')' ?></td>
                                                                                        <td><input type="text" name="frmPrice[<?php echo $val['pkAttributeID']; ?>][<?php echo $vOpt['pkProductAttributeId']; ?>]" value="<?php echo $vOpt['OptionExtraPrice'] ?>" <?php echo $varReadonly ?>  class="input-small price_opt"></td>
                                                                                        <td style="text-align: center;"><input type="radio" name="default_<?php echo $val['pkAttributeID']; ?>" value="<?php echo $vOpt['pkProductAttributeId']; ?>" <?php echo $varChecked; ?> class="default"><?php //echo $vOpt['OptionIsDefault'];  ?></td>                                                                    
                                                                                        <td>&nbsp;</td>
                                                                                    </tr>                                                                                
                                                                                <?php }
                                                                                ?></tbody>

                                                                            <?php
                                                                        }
                                                                        ?>

                                                                    </table>


                                                                    <?php /*
                                                                      <?php foreach ($objPage->productToAttributeOptions as $val) {
                                                                      ?>
                                                                      <div class="box-title nomargin"><h3> <?php echo $val['AttributeLabel'] . ' (' . $val['AttributeCode'] . ')' ?></h3></div>
                                                                      <div>

                                                                      <?php
                                                                      foreach ($val['options'] as $vOpt) {
                                                                      $varChecked = ($vOpt['OptionIsDefault'] == 1) ? 'checked="checked"' : '';
                                                                      $varReadonly = ($varChecked <> '') ? 'readonly' : '';
                                                                      ?>
                                                                      <div class="control-group">
                                                                      <label for="textfield" class="control-label">*<?php echo $val['AttributeCode'] . ' (' . $vOpt['AttributeOptionValue'] . ')' ?>:</label>
                                                                      <div class="controls">
                                                                      <input type="radio" name="default_<?php echo $val['pkAttributeID']; ?>" value="<?php echo $vOpt['pkProductAttributeId']; ?>" <?php echo $varChecked; ?> class="default">Default
                                                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                      Extra Price <input type="text" name="frmPrice[<?php echo $val['pkAttributeID']; ?>][<?php echo $vOpt['pkProductAttributeId']; ?>]" value="<?php echo $vOpt['OptionExtraPrice'] ?>" <?php echo $varReadonly ?>  class="input-xlarge price_opt">
                                                                      </div>
                                                                      </div>


                                                                      <?php
                                                                      }
                                                                      echo '</div>';
                                                                      } */
                                                                    ?>




                                                                    <div class="note">
                                                                        <span class="req">Note : Every type of attributes should have a default option. So default price should be 0</span><br/>
                                                                        Note : * Indicates mandatory fields.</div>
                                                                    <div class="form-actions">
                                                                        <button name="btnPage" type="submit" class="btn btn-blue" value="Save">Save</button>                                                                    
                                                                        <a id="buttonDecoration" href="product_manage_uil.php">
                                                                            <button name="frmCancel" type="button" value="Cancel" class="btn"><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button>
                                                                        </a>
                                                                        <input type="hidden" name="httpRef" value="<?php echo $httpRef; ?>" />
                                                                        <input type="hidden" name="frmHidenAdd" id="frmHidenAdd" value="updatePrice" />
                                                                    </div>
                                                                <?php } else { ?>
                                                                    <div class="note">There is no attributes in this products</div>      

                                                                <?php } ?>
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

                    <?php } else { ?>
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