<?php
require_once '../common/config/config.inc.php';

//pre(CONTROLLERS_LOGISTIC_PATH);
//require_once CONTROLLERS_LOGISTIC_PATH . FILENAME_ZONE_ADD_CTRL;
require_once CONTROLLERS_LOGISTIC_PATH . FILENAME_ZONE_PRICE_CTRL;
//pre("herecode");
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
        <link rel="shortcut icon" href="../admin/img/favicon.ico" />
        <title><?php echo ADMIN_PANEL_NAME; ?> : Add-Price</title>
        <?php require_once '../admin/inc/common_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <style>
            .zone-country .input-xlarge{ width:210px !important}  
            .label-csc label{ display:  inline-block}
            .label-csc a{ display:inline-block; vertical-align: middle; margin-left:20px}
            .formactionleft{margin-left: 0px !important;
                            padding-left: 20px !important;}

        </style>
        <script>
            var number = document.getElementById('number');

number.onkeydown = function(e) {
    if(!((e.keyCode > 95 && e.keyCode < 106)
      || (e.keyCode > 47 && e.keyCode < 58) 
      || e.keyCode == 8)) {
        return false;
    }
}
//            $(".number").keydown(function () {
//                alert("Handler for .keydown() called.");
//            });
//            $(document).on('keydown', ".number", function ()
//            {
//                //var number =$('.number').val();
//                if (!((e.keyCode > 95 && e.keyCode < 106)
//                        || (e.keyCode > 47 && e.keyCode < 58)
//                        || e.keyCode == 8)) {
//                    return false;
//                }
//            });
//            $(document).ready(function () {
//                
//                var number =$('.number').val();
//               
//               // console.log("ready!");
//                number.onkeydown = function (e) {
//                    if (!((e.keyCode > 95 && e.keyCode < 106)
//                            || (e.keyCode > 47 && e.keyCode < 58)
//                            || e.keyCode == 8)) {
//                        return false;
//                    }
//                }
//            });



        </script>
    </head>
    <body>
        <?php // pre($_SESSION); ?>
        <?php require_once '../admin/inc/header_logistic.inc.php'; ?>
        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Add-Price</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>

                            <li>
                                <a href="price_manage_uil.php">Price</a>
                                <i class="icon-angle-right"></i>
                            </li>

                            <li>
                                <span>Add-Price</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>


                    <?php //require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || $_SESSION['sessLogistictype'] == 'logistic-admin') { ?>
                        <?php $httpRef = (isset($_REQUEST['httpRef'])) ? $_REQUEST['httpRef'] : $_SERVER['HTTP_REFERER']; ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <?php
                                if ($objCore->displaySessMsg()) {
                                    ?>

                                    <?php
                                    echo $objCore->displaySessMsg();
                                    $objCore->setSuccessMsg('');
                                    $objCore->setErrorMsg('');
                                    ?>

                                    <?php
                                }
                                ?>
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>Add-Price</h3>
                                        <a id="buttonDecoration" href="price_manage_uil.php" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                    </div>
                                    <form novalidate action="" name="frmzoneadd" method="post" id="frm_page" onsubmit="return validateprice();" class='form-horizontal form-bordered'>
                                        <div class="box-content nopadding">
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <div class="box box-color box-bordered ">
                                                        <div class="nopadding">                                                            
                                                            <div class="control-group"> 

                                                                <div class="control-block" style="">
                                                                    <div class="TemplateBlock">
                                                                        <table class="table table-bordered dataTable-scroll-x" style="border: 1px solid #ccc;margin-bottom: 25px;float: left;">

                                                                            <tr>
                                                                                <td> *Zone</td>
                                                                                <td>
                                                                                    <?php
                                                                                    $currentzonearry = $objGeneral->zonelistofcurrentlogist($_SESSION['sessLogistic']);

                                                                                    $SelectedCountry = array();

                                                                                    echo $objGeneral->zonelistofcurrentlogistichtml($currentzonearry, 'zoneid[]', 'zoneid', $SelectedCountry, 'Select Zone', 0, 'class="select2-me1 input-xlarge zoneid" ', 1, 0, 1);
                                                                                    ?>

                                                                                </td>
                                                                                <td>&nbsp;</td>
                                                                                <td>&nbsp;</td>

                                                                            </tr>
                                                                            <tr>
                                                                                <td> *Shipping Method</td>
                                                                                <td>
                                                                                    <?php
                                                                                    $shippingmethodarray = $objGeneral->shippingmethodlist();

                                                                                    $SelectedCountry = array();

                                                                                    echo $objGeneral->shippingmethodlisthtml($shippingmethodarray, 'shippingmethod[]', 'shippingmethodid', $SelectedCountry, 'Select Shipping Method', 0, 'class="select2-me1 input-xlarge" ', 1, 0, 1);
                                                                                    ?>

                                                                                </td>
                                                                                <td>&nbsp;</td>
                                                                                <td>&nbsp;</td>

                                                                            </tr>
                                                                            <tr>
                                                                                <td> *Maximum Dimension(L*W*H)</td>
                                                                                <td> <input type="number" id="number" name="length[]"  min="0" placeholder="cm"/></td>
                                                                                <td> <input type="number" class="number" name="width[]" min="0" placeholder="cm"/></td>
                                                                                <td> <input type="number" class="number" name="height[]" min="0"placeholder="cm"/></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> *Weight (Kg)</td>
                                                                                <td> <input type="number" class="number" name="minweight[]" min="0"placeholder="Min (kg)"/></td>
                                                                                <td> <input type="number" class="number" name="maxweight[]" min="0"placeholder="Max (kg)"/></td>
                                                                                <td>&nbsp;</td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td> *Cost Per Kg</td>
                                                                                <td> <input type="number" class="number" name="cost[]" min="0" placeholder="cost"/></td>
                                                                                <td>&nbsp;</td>
                                                                                <td>&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> Handling cost ($) per item</td>
                                                                                <td> <input type="number" class="number" name="handlingcost[]" min="0"placeholder="handling cost"/></td>
                                                                                <td>&nbsp;</td>
                                                                                <td>&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> Fragile Handling cost ($)</td>
                                                                                <td> <input type="number" class="number" name="fragilecost[]" min="0" placeholder="fragile cost"/></td>
                                                                                <td>&nbsp;</td>
                                                                                <td>&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> *Delivery (Days)</td>
                                                                                <td> <input type="number" class="number" name="deliveryday[]" min="0" placeholder="days"/></td>
                                                                                <td>&nbsp;</td>
                                                                                <td>&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> Cubic weight (cm3/kg)</td>
                                                                                <td> <input type="number" class="number" name="cubic[]"min="0" placeholder="cubic weight"/></td>
                                                                                <td>&nbsp;</td>
                                                                                <td>&nbsp;</td>
                                                                            </tr>
                                                                        </table>
                                                                        <div style="float:left;margin-left: -21px;position: relative;left: 43px;display: inline-block; " class="PlusMinus">
                                                                            <i>
                                                                                <span style="cursor: pointer;width:51px;" class="plusPriceForm">
                                                                                    <img src="../admin/images/plus.png">
                                                                                </span>
                                                                            </i>
            <!--                                                                            <i><span valueOfJ="0" valueOfI="1" zoneid="11"style="cursor: pointer;width:51px;" title="Delete Complete zone" class="zoneeditRemove"><img src="../admin/images/minus.png"/></span></i>-->
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="form-actions formactionleft">                        
                                                                <button style="margin-left: -8px;" name="frmBtnSubmit" type="submit" class="btn btn-blue"  value="<?php echo ADMIN_SUBMIT_BUTTON; ?>" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button>  



                                                                <input type="hidden" name="frmHidenAdd" id="frmHidenAdd" value="add" />
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </form>
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
            <?php require_once('../admin/inc/footer.inc.php'); ?>

        </div>
        <div id="randomValue"></div>

    </body>
</html>





