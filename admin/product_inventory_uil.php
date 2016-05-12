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

                Cal('.applyQty').live('click', function() {
                    var qtyVal = $('#frmQty');
                    var valQ = $.trim(qtyVal.val());

                    if(valQ==''){
                        alert('Please enter quantity');
                        qtyVal.focus();
                        return false;
                    }else if(IsDigits(valQ)){
                        alert("Please enter numeric value!");
                        qtyVal.focus();
                        return false;
                    }else{
                        $('.qty').val(valQ);
                    }
                });
            });
        </script>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <script type="text/javascript" src="js/product_admin.js"></script>
        <link rel="stylesheet" href="css/colorbox.css" />
        <script src="../colorbox/jquery.colorbox.js"></script>
        <script type="text/javascript">
            function validateProductInventoryForm(obj){
                var vobj = $(obj);
                var error = '';
                var foc;

                vobj.find('.qty').each(function(){
                    var valQty = $.trim($(this).val());
                    if(error==''){
                        if(valQty==''){
                            error = "Please enter quantity!";
                            foc = $(this);

                        }else if(IsDigits(valQty)){
                            error = "Please enter numeric value!";
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
                            <h1>Manage Inventory</h1>
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
                                <span>Manage Inventory</span>
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
                                                <h3>Manage Inventory</h3>
                                            </div>
                                            <div class="box-content nopadding">

                                                <?php require_once('javascript_disable_message.php'); ?>
                                                <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('edit-products', $_SESSION['sessAdminPerMission'])) { ?>
                                                    <?php $httpRef = (isset($_REQUEST['httpRef'])) ? $_REQUEST['httpRef'] : $_SERVER['HTTP_REFERER']; ?>

                                                    <form action=""  method="post" id="frm_page" onsubmit="return validateProductInventoryForm(this);" enctype="multipart/form-data" >
                                                        <div class="row-fluid">
                                                            <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                <?php if (count($objPage->arrCombinedAttrOpt) > 0) { ?>
                                                                    <table class="table table-hover table-nomargin table-bordered usertable">

                                                                        <thead>
                                                                            <tr>
                                                                                <th>Option Combination</th>
                                                                                <th>Quantity
                                                                                    <input type="text" name="frmQty" id="frmQty" value="" class="input-small" />
                                                                                    <a href="javascript:void(0);" class="applyQty" >Apply All</a>
                                                                                </th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                            <?php foreach ($objPage->arrCombinedAttrOpt as $key => $val) { ?>
                                                                                <tr>
                                                                                    <td>
                                                                                        * <?php echo $val['AttributeOptionValue']; ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="hidden" name="frmOptIds[]" value="<?php echo $val['fkAttributeOptionId']; ?>" />
                                                                                        <input type="text" name="frmQuantity[]" value="<?php echo $objPage->arrAttrOptQty[$val['fkAttributeOptionId']]; ?>" class="input-small qty" />
                                                                                    </td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </tbody>

                                                                    </table>
                                                                    <div class="note">Note : * Indicates mandatory fields.</div>
                                                                    <div class="form-actions">
                                                                        <button name="btnPage" type="submit" class="btn btn-blue" value="Save">Save</button>
                                                                        <a id="buttonDecoration" href="product_manage_uil.php">
                                                                            <button name="frmCancel" type="button" value="Cancel" class="btn"><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button>
                                                                        </a>
                                                                        <input type="hidden" name="httpRef" value="<?php echo $httpRef; ?>" />
                                                                        <input type="hidden" name="frmHidenAdd" id="frmHidenAdd" value="updateInventory" />
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