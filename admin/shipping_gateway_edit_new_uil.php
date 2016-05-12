<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_SHIPPING_GATEWAY_NEW_CTRL;
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
            Cal = jQuery.noConflict();
            Cal(document).ready(function () {
                //showShippingMethod(<?php echo $objPage->arrRow[0]['fkShippingGatewaysID']; ?>,<?php echo $objPage->arrRow[0]['fkShippingMethodID']; ?>, 'frmShippingMethodID');
            });

            function popupClose1(showId) {
                $('#' + showId).hide();
            }

            function frontPrice() {
                $('#frontPrice').show();
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
                            <h1>Edit Shipping Price</h1>
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
                                    <form action=""  method="post" id="frm_page"  class='form-horizontal form-bordered'>
                                        <div class="box-content nopadding">
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <div class="box box-color box-bordered ">
                                                        <div class="nopadding">


                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">*Available Country Portal: </label>
                                                                <div class="controls">
    <!--                                                                    <select name="frmShippingMethodID" id="frmShippingMethodID" class='selects2-me input-xlarge'>
                                                                        <option value="0">Select Shipping Method</option>
                                                                    </select>-->
                                                                    <input type="text" disabled="disabled" id="pkAdminID" value="<?php echo $objPage->arrRow[0]['AdminUserName']; ?>" >

                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <?php //pre($objPage->arrRow); ?>
                                                                <label for="textfield" class="control-label">*Shipping Gateway: </label>
                                                                <div class="controls">
                                                                    <input type="text" id="frmShippingGatewayID" disabled="disabled" value="<?php echo $objPage->arrRow[0]['ShippingTitle']; ?>" >
                                                                    <a href="javascript:void(0);" onclick="frontPrice()" style="float: right;">
                                                                        Front Price
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">
                                                                    *Price Table: <br><span class="req"><b>Note:</b><br />Weight in Kg<br />Zone Price in USD</span>
                                                                    <br/>
                                                                    <!--<a href="javascript:void(0);" onclick="showZones()">View Zone wise Country</a>-->
                                                                </label>

                                                                <div class="controls" style="overflow: auto">
                                                                    <table class="table table-bordered dataTable-scroll-x" id="productRow">
                                                                        <tr>
                                                                            <th>&nbsp;</th>
                                                                            <th>Min. Weight</th>
                                                                            <th>Max. Weight</th>
                                                                            <th>Price($)</th>
                                                                            <!--<th>Front Price($)</th>-->
                                                                            <th>&nbsp;</th>
                                                                        </tr>

                                                                        <?php
                                                                        $varSGNum = count($objPage->arrRow);
                                                                        //pre($objPage->arrRow);
                                                                        foreach ($objPage->arrRow as $keyWP => $vslWP) {
                                                                            
                                                                            //$keyWP++;
                                                                            //$selected_CID[$keyWP] = $vslWP['country_id'];
                                                                            ?>
                                                                        
                                                                        
                                                                            <tr>
                                                                                <td>
                                                                                    <select name="frmShippingMultiCountryID[]" id="frmShippingMultiCountryID" class='input-large'>
                                                                                        <option value="<?php echo $vslWP['country_id']; ?>"><?php echo $vslWP['name']; ?> </option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="hidden" name="pkShippingPriceID[]" value="<?php echo $vslWP['pkShippingPriceID']; ?>" >
                                                                                    <input type="text" name="minWeight[]" value="<?php echo $vslWP['minWeight']; ?>" id="minWeight" ></td>
                                                                                <td><input type="text" name="maxWeight[]" id="maxWeight" value="<?php echo $vslWP['maxWeight']; ?>" ></td>
                                                                                <td><input type="text" name="price[]" id="price" value="<?php echo $vslWP['shippingPrice']; ?>" ></td>
                                                                                <!--<td><?php // echo $objPage->OldEntry[$keyWP]['shippingPrice'];    ?></td>-->
                                                                                <td class="PlusMinus">
        <!--                                                                                    <i>
                                                                                        <span style="cursor: pointer;width:51px;"  onclick="addDynamicRowToTableForShippingGateways('productRow');"><img src="images/plus.png"/></span>
                                                                                    </i>-->
                                                                                    <a onclick="removeDynamicRowToTableForShippingGatewaysNew(this,<?php echo $vslWP['pkShippingPriceID']; ?>,<?php echo $objPage->arrRow[0]['fkShippingPortalID']; ?>,<?php echo $objPage->arrRow[0]['fkShippingGatewaysID']; ?>,<?php echo $vslWP['country_id']; ?>,<?php echo $vslWP['minWeight']; ?>,<?php echo $vslWP['maxWeight']; ?>);"><img src="images/minus.png" /></a>
                                                                                </td>
                                                                            </tr>

                                                                            <?php
                                                                        }

                                                                        //pre($objPage->RemainingCountries);
                                                                        //pre($selected_CID);
                                                                        ?>
                                                                        <div id="AllowedCountries" style="display:none;" >
                                                                            <?php
                                                                            foreach ($objPage->RemainingCountries as $kk => $vv) {
                                                                                //if (!in_array($vv['fkcountry_id'], $selected_CID)) {
                                                                                $abc[$kk] = $vv;
                                                                                ?>

                                                                                <option value="<?php echo $vv['fkcountry_id']; ?>"><?php echo $vv['name']; ?></option>

                                                                                <?php
                                                                                //}
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <?php
//                                                                        pre($abc);
                                                                        if (!empty($objPage->RemainingCountries)) {
                                                                            //foreach ($objPage->arrRow['RemainingCountries'] as $keyWP => $vslWP) {
                                                                            ?>


                                                                            <tr class='newTrEdit' >
                                                                                <td>
                                                                                    <?php
                                                                                    //$abc = $objPage->RemainingCountries;
                                                                                    //if(in_array(,$abc))
//                                                                                    $html_entity = "onchange='showShippingPortal(this.value, 0, " . '"frmShippingGatewayID"' . ", " . '"frmShippingMultiCountryID"' . " );' class='input-xlarge newdemo' style='width:100%' ";
                                                                                    $html_entity = "class='input-large newdemo' ";
                                                                                    echo $objGeneral->CountryHtmlRemaining($objPage->RemainingCountries, 'frmShippingMultiCountryID[]', 'fkcountry_id', $SelectedCountry = array(), '', 0, $html_entity, '1', '1');
                                                                                    ?>
                                                                                </td>
                                                                                <td><input type="text" name="minWeight[]"  id="minWeight" ></td>
                                                                                <td><input type="text" name="maxWeight[]" id="maxWeight"  ></td>
                                                                                <td><input type="text" name="price[]" id="price"  ></td>
                                                                                <td class="PlusMinus">
                                                                                    <i><span style="cursor: pointer;width:51px;"  onclick="addDynamicRowToTableForShippingGatewaysEdit('productRow');"><img src="images/plus.png"/></span>

                                                                                    </i>

                                                                                </td>
                                                                            </tr>

                                                                            <?php
                                                                            //}
                                                                        }
                                                                        ?>                                                                        
                                                                    </table>
                                                                </div>
                                                                <div class="note">Note : * Indicates mandatory fields.</div>
                                                                <div class="form-actions">
                                                                    <a class="btn btn-primary" href="javascript:void(0);" onclick="validateShipplingGatewaysFormEdit(frm_page);" style="float:left; margin:5px 15px 0 0; width:80px;" ><?php echo ADMIN_SUBMIT_BUTTON; ?></a>
                                                                    <!--<input type="submit" onclick="validateShipplingGatewaysFormEdit(this);"  class="btn btn-primary" name="btnPage" value="<?php echo ADMIN_SUBMIT_BUTTON; ?>" style="float:left; margin:5px 15px 0 0; width:80px;"/>-->
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
                        <div id="frontPrice" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;">                            
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="popupClose1('frontPrice')">X</button>
                                <h3 id="myModalLabel">Front Price</h3>
                            </div>
                            <div class="modal-body" id="disputedHistoryData" style="padding-left:42px;padding-right:10px; overflow: auto;">                                      
                                <div class="box-content nopadding">
                                    <div class="row-fluid">
                                        <table class="table table-bordered dataTable-scroll-x" id="productRow">
                                            <tr>
                                                <th>Countries</th>
                                                <th>Min. Weight</th>
                                                <th>Max. Weight</th>
                                                <th>Price($)</th>
                                            </tr>

                                            <?php
                                            $varSGNum = count($objPage->arrRow);
                                            //pre($objPage->OldEntry);
                                            foreach ($objPage->OldEntry as $keyWP => $vslWP) {
                                                //$keyWP++;
                                                //$selected_CID[$keyWP] = $vslWP['country_id'];
                                                ?>
                                                <tr>
                                                    <td><?php echo $vslWP['name']; ?></td>
                                                    <td><?php echo $vslWP['minWeight']; ?></td>
                                                    <td><?php echo $vslWP['maxWeight']; ?></td>
                                                    <td><?php echo $vslWP['shippingPrice']; ?></td>
                                                </tr>

                                                <?php
                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer"><input type="button" onclick="popupClose1('frontPrice')" style="cursor: pointer;" value="Close" name="cancel" class="btn"></div>                            
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
