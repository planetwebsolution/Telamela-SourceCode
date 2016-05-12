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
            });

            function popupClose1(showId) {
                $('#' + showId).hide();
            }

            function showZones() {
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
                            <h1>Add Shipping Price</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Dashboard</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <span>Shipping Price</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>


                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('add-products', $_SESSION['sessAdminPerMission'])) { ?>
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
                                            Add New
                                        </h3>
                                        <a id="buttonDecoration" href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>


                                    </div>
                                    <form action=""  method="post" id="frm_page"  class='form-horizontal form-bordered'>
                                        <div class="box-content nopadding">
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <div class="box box-color box-bordered">
                                                        <div class="nopadding">

                                                            <div class="control-group">
                                                                <label for="textarea" class="control-label">*Available Country Portal:</label>
                                                                <div class="controls">
                                                                    <div id="" class="input_sec input_star input_boxes multiple <?php //echo ($productmulcountrydetail[0]['producttype'] == 'multiple') ? '' : 'mulcountries';   ?> ">
                                                                        <div class="ErrorfkCategoryID" style="display: none"></div>
                                                                        <?php
                                                                        $abc = $objGeneral->getCountryPortal();
                                                                        //pre($abc);
                                                                        foreach ($productmulcountrydetail as $kk => $vv) {
                                                                            $SelectedCountry[$kk] = $vv['pkAdminID'];
                                                                        }
                                                                        //pre($SelectedCountry);
                                                                        $html_entity = "onchange='showShippingPortal(this.value, 0, " . '"frmShippingGatewayID"' . ", " . '"frmShippingMultiCountryID"' . " );' class='select2-me input-xlarge newdemo' style='width:auto' ";
                                                                        echo $objGeneral->CountryPortalHtml($abc, 'CountryPortalID', 'pkAdminID', $SelectedCountry = array(), 'Select Country Portal', 0, $html_entity, '1', '1');
                                                                        ?>
                                                                        <!-- <small class="star_icon" style=" right:0px ; top:10px;"><img src="common/images/star_icon.png" alt=""/></small> -->
                                                                    </div>

                                                                </div>
                                                            </div> 

                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">*Shipping Gateway: </label>
                                                                <div class="controls">
                                                                    <select name="frmShippingGatewayID" onchange="showShippingCountryAllowed(this.value, 0, 'frmShippingMultiCountryID', '');" id="frmShippingGatewayID" class='select2-me input-large'>
                                                                        <option value="0">Select Shipping Geteway</option>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <div id="AllowedCountries" style="display:none;" ></div>
                                                            <input id="CountriesCount" value="" type="hidden" >
                                                            <input id="CountriesPortalID" value="" type="hidden" >
                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">*Allowed Countries: </label>
                                                                <div class="controls">


                                                                    <table class="table table-bordered dataTable-scroll-x" id="productRow">
                                                                        <tr>
                                                                            <th>&nbsp;</th>
                                                                            <th>Min. Weight</th>
                                                                            <th>Max. Weight</th>
                                                                            <th>Price($)</th>
                                                                            <th>&nbsp;</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <select name="frmShippingMultiCountryID[]" id="frmShippingMultiCountryID" class='input-large'>
                                                                                    <option value="0">Select Allowed Countries </option>
                                                                                </select>
                                                                            </td>
                                                                            <td><input type="text" name="minWeight[]" id="minWeight" ></td>
                                                                            <td><input type="text" name="maxWeight[]" id="maxWeight" ></td>
                                                                            <td><input type="text" name="price[]" id="price" ></td>
                                                                            <td class="PlusMinus"><i><span style="cursor: pointer;width:51px;"  onclick="addDynamicRowToTableForShippingGateways('productRow');"><img src="images/plus.png"/></span></i></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="note">Note : * Indicates mandatory fields.</div>
                                                            <div class="form-actions">
                                                                <a class="btn btn-primary" href="javascript:void(0);" onclick="validateShipplingGatewaysForm(frm_page);" style="float:left; margin:5px 15px 0 0; width:80px;" ><?php echo ADMIN_SUBMIT_BUTTON; ?></a>
                                                                <!--<input type="submit" class="btn btn-primary" name="btnPage" value="<?php echo ADMIN_SUBMIT_BUTTON; ?>" style="float:left; margin:5px 15px 0 0; width:80px;"/>-->
                                                                <a id="buttonDecoration" href="shipping_gateway_manage_new_uil.php"><input type="button" class="btn" name="btnTagSettings" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" style="float:left; margin:5px 5px 0 0; width:80px;"/></a>
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
