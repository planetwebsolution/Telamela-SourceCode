<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_SHIPPING_GATEWAY_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Add New</title>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <script type="text/javascript">
            Cal=jQuery.noConflict();
            Cal(document).ready(function(){
                showShippingMethod(<?php echo $objPage->arrRow[0]['fkShippingGatewaysID']; ?>,<?php echo $objPage->arrRow[0]['fkShippingMethodID']; ?>,'frmShippingMethodID');                              
            });
            
            function popupClose1(showId){
                $('#'+showId).hide();
            }
            
            function showZones(){                
                $('#zoneData').show();               
            }            
        </script>
        <?php require_once 'inc/common_css_js.inc.php'; ?>        
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>        
    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>
        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Edit Shipping Gateway</h1>
                        </div>
                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Dashboard</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <span>Shipping Gateway</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin') { ?>
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
                                        <h3>
                                            Edit
                                        </h3>
                                        <a id="buttonDecoration" href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>

                                    </div>
                                    <form action=""  method="post" id="frm_page" onsubmit="return validateShipplingGatewaysForm(this);" class='form-horizontal form-bordered'>
                                        <div class="box-content nopadding">
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <div class="box box-color box-bordered ">
                                                        <div class="nopadding">
                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">*Shipping Gateways : </label>
                                                                <div class="controls">
                                                                    <select name="frmShippingGatewayID" id="frmShippingGatewayID" onchange="showShippingMethod(this.value,<?php echo $objPage->arrRow[0]['fkShippingMethodID']; ?>,'frmShippingMethodID');" class='select2-me input-xlarge'>
                                                                        <option value="0">Select Shipping Gateways</option>
                                                                        <?php foreach ($objPage->arrShippingGatewaysList as $key => $val) { ?>
                                                                            <option value="<?php echo $val['pkShippingGatewaysID']; ?>" <?php
                                                                    if ($val['pkShippingGatewaysID'] == $objPage->arrRow[0]['fkShippingGatewaysID']) {
                                                                        echo 'selected="selected"';
                                                                    }
                                                                            ?>><?php echo $val['ShippingTitle']; ?></option>
                                                                                <?php } ?>
                                                                    </select>


                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">*Shipping Method: </label>
                                                                <div class="controls">
                                                                    <select name="frmShippingMethodID" id="frmShippingMethodID" class='selects2-me input-xlarge'>
                                                                        <option value="0">Select Shipping Method</option>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">
                                                                    *Price Table: <br><span class="req"><b>Note:</b><br />Weight in Kg<br />Zone Price in USD</span>
                                                                    <br/>
                                                                    <a href="javascript:void(0);" onclick="showZones()">View Zone wise Country</a>
                                                                </label>

                                                                <div class="controls" style="width: 72%; overflow: auto">
                                                                    <table class="table table-bordered dataTable-scroll-x" id="productRow">
                                                                        <tr>                                                                            
                                                                            <th>Weight</th>
                                                                            <th>Zone A</th>
                                                                            <th>Zone B</th>
                                                                            <th>Zone C</th>
                                                                            <th>Zone D</th>
                                                                            <th>Zone E</th>
                                                                            <th>Zone F</th>
                                                                            <th>Zone G</th>
                                                                            <th>Zone H</th>
                                                                            <th>Zone I</th>
                                                                            <th>Zone J</th>
                                                                            <th>Zone K</th>
                                                                            <th>&nbsp;</th>
                                                                        </tr>

                                                                        <?php
                                                                        $varSGNum = count($objPage->arrRow);
                                                                        foreach ($objPage->arrRow as $keyWP => $vslWP) {
                                                                            $keyWP++;
                                                                            ?>
                                                                            <tr>
                                                                                <td><input type="text" name="frmWeight[]" class="input0" style="width:51px" value="<?php echo $vslWP['Weight']; ?>"/></td>
                                                                                <td><input type="text" name="frmA[]" class="input0" style="width:51px" value="<?php echo $vslWP['ZoneA']; ?>"/></td>
                                                                                <td><input type="text" name="frmB[]" class="input0" style="width:51px" value="<?php echo $vslWP['ZoneB']; ?>"/></td>
                                                                                <td><input type="text" name="frmC[]" class="input0" style="width:51px"  value="<?php echo $vslWP['ZoneC']; ?>"/></td>
                                                                                <td><input type="text" name="frmD[]" class="input0" style="width:51px" value="<?php echo $vslWP['ZoneD']; ?>"/></td>
                                                                                <td><input type="text" name="frmE[]" class="input0" style="width:51px" value="<?php echo $vslWP['ZoneE']; ?>"/></td>
                                                                                <td><input type="text" name="frmF[]" class="input0" style="width:51px" value="<?php echo $vslWP['ZoneF']; ?>"/></td>
                                                                                <td><input type="text" name="frmG[]" class="input0" style="width:51px" value="<?php echo $vslWP['ZoneG']; ?>"/></td>
                                                                                <td><input type="text" name="frmH[]" class="input0" style="width:51px" value="<?php echo $vslWP['ZoneH']; ?>"/></td>
                                                                                <td><input type="text" name="frmI[]" class="input0" style="width:51px" value="<?php echo $vslWP['ZoneI']; ?>"/></td>
                                                                                <td><input type="text" name="frmJ[]" class="input0" style="width:51px" value="<?php echo $vslWP['ZoneJ']; ?>"/></td>
                                                                                <td><input type="text" name="frmK[]" class="input0" style="width:51px" value="<?php echo $vslWP['ZoneK']; ?>"/></td>
                                                                                <td><i>
                                                                                        <?php if ($keyWP == $varSGNum) { ?>
                                                                                            <span style="cursor: pointer;" onclick="addDynamicRowToTableForShippingGateways('productRow');">
                                                                                                <img src="images/plus.png"/><!--<i class="icon-plus-sign"></i>-->
                                                                                            </span>
                                                                                        <?php } ?>
                                                                                    </i> 
                                                                                    <?php if ($keyWP > 1) { ?>
                                                                                        <a onclick="removeDynamicRowToTableForShippingGateways('productRow','<?php echo $keyWP; ?>',this);return false;" href="#"><img src="images/minus.png"/></a>
                                                                                    <?php } ?>
                                                                                </td>
                                                                            </tr>
                                                                        <?php } ?>                                                                        
                                                                    </table>
                                                                </div>
                                                                <div class="note">Note : * Indicates mandatory fields.</div>
                                                                <div class="form-actions">
                                                                    <input type="submit"  class="btn btn-primary" name="btnPage" value="<?php echo ADMIN_SUBMIT_BUTTON; ?>" style="float:left; margin:5px 15px 0 0; width:80px;"/>
                                                                    <a id="buttonDecoration" href="<?php echo $httpRef; ?>"><input type="button"  class="btn" name="btnTagSettings" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" style="float:left; margin:5px 5px 0 0; width:80px;"/></a>
                                                                    <input type="hidden" name="httpRef" value="<?php echo $httpRef; ?>" />
                                                                    <input type="hidden" name="frmHidenEdit" id="frmHidenEdit" value="edit" />
                                                                </div>
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
                        <div id="zoneData" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;">                            
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="popupClose1('zoneData')">X</button>
                                <h3 id="myModalLabel">Zone wise country</h3>
                            </div>
                            <div class="modal-body" id="disputedHistoryData" style="padding-left:42px;padding-right:10px; overflow: auto;">                                      
                                <div class="box-content nopadding">
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <div class="box box-color box-bordered">
                                                <div class="nopadding">
                                                    <?php foreach ($objPage->arrZoneCountry as $val) { ?>
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label" style="font-size: 15px;font-weight: bold">Zone: <?php echo $val['zone']; ?></label>
                                                            <div class="controls">
                                                                <?php echo $val['Countries']; ?>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer"><input type="button" onclick="popupClose1('zoneData')" style="cursor: pointer;" value="Close" name="cancel" class="btn"></div>                            
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
