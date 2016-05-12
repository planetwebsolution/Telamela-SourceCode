<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_SHIPPING_NEW_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Shipping Gateway - Edit</title>
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
                            <h1>Edit - Shipping Gateway</h1>
                        </div>
                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="settings_frm_uil.php">Setting</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="shipping_manage_new_uil.php">Shipping Gateway</a>
                                <i class="icon-angle-right"></i>
                            </li>

                            <li>
<!--                                <a href="shipping_edit_uil.php?smid=<?php echo $_GET['smid']; ?>&type=add">Edit - Shipping Gateway</a>-->
                                <span>Edit - Shipping Gateway</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>


                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin') {
                        ?>
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
                                        <h3>Edit - Shipping Gateway</h3>
                                        <a id="buttonDecoration" href="shipping_manage_new_uil.php" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                    </div>
                                    <form action=""  method="post" id="frm_page" onsubmit="return validateShipplingForm(this);" class='form-horizontal form-bordered'>
                                        <div class="box-content nopadding">
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <div class="box box-color box-bordered ">
                                                        <div class="nopadding">
                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">*Shipping Title:</label>
                                                                <div class="controls">
                                                                    <?php // pre($objPage->arrRow); ?>
                                                                    <input type="text" name="frmShippingName" id="frmShippingName" class="input-large" value="<?php echo $objPage->arrRow[0]['ShippingTitle']; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">Shipping Description:</label>
                                                                <div class="controls">                                                                    
                                                                    <textarea type="text" name="frmShippingDescription" id="frmShippingDescription" class="input-large" /><?php echo $objPage->arrRow[0]['ShippingDescription']; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <!--                                                            <div class="control-group">
                                                                                                                            <label for="textfield" class="control-label">*Shipping Code:</label>
                                                                                                                            <div class="controls">
                                                                                                                                <input type="text" name="frmShippingCode" id="frmShippingCode" class="input-large" value="<?php echo $objPage->arrRow[0]['ShippingAlias']; ?>" />
                                                                                                                            </div>
                                                                                                                        </div>-->
                                                            <?php /* <div class="control-group">
                                                              <label for="textarea" class="control-label">*Avaliable Country Portal:</label>
                                                              <div class="controls">
                                                              <div id="mul_countriesID" class="input_sec input_star input_boxes multiple <?php //echo ($productmulcountrydetail[0]['producttype'] == 'multiple') ? '' : 'mulcountries';   ?> ">
                                                              <div class="ErrorfkCategoryID" style="display: none"></div>
                                                              <?php
                                                              $abc = $objGeneral->getCountryPortal();
                                                              //pre($abc);
                                                              foreach ($objPage->arrRow['selectedCountry'] as $kk => $vv) {
                                                              $SelectedCountry[$kk] = $vv['fkportalID'];
                                                              }
                                                              //pre($SelectedCountry);
                                                              echo $objGeneral->CountryPortalHtml($abc, 'AdminUserName[]', 'pkAdminID', $SelectedCountry, '', 1, '" class="select2-me input-xlarge" style="width:auto"', '1', '1');
                                                              ?>
                                                              <!-- <small class="star_icon" style=" right:0px ; top:10px;"><img src="common/images/star_icon.png" alt=""/></small> -->
                                                              </div>

                                                              </div>
                                                              </div> */ ?>
                                                            <div class="control-group">
                                                                <label for="textarea" class="control-label">*Avaliable Country Portal:</label>
                                                                <div class="controls">
                                                                    <table class="table table-bordered dataTable-scroll-x" id="productRow">
                                                                        <tr>
                                                                            <th>Country portal</th>
                                                                            <th>Mail Id</th>

                                                                            <th>&nbsp;</th>
                                                                        </tr>
                                                                        <?php
                                                                        //pre($objPage->arrRow);
                                                                        $abc = $objGeneral->getCountryPortal();
                                                                        //pre($abc);
                                                                        foreach ($objPage->arrRow['selectedCountry'] as $kk => $vv) {
                                                                            $SelectedCountry[$kk] = $vv['fkportalID'];
//                                                                            pre($SelectedCountry);
                                                                            ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <select name="AdminUserName[]" id="AdminUserName" class='input-large'>
                                                                                        <option value="<?php echo $vv['fkportalID']; ?>"><?php echo $vv['AdminUserName']; ?> </option>
                                                                                    </select>

                                                                                    <?php
                                                                                    //echo $objGeneral->CountryPortalHtml($SelectedCountry, 'AdminUserName[]', 'pkAdminID', $SelectedCountry=array(), '', 0, '" class="select2-me input-xlarge" style="width:auto"', '1', '1');
                                                                                    ?>
                                                                                </td>
                                                                                <td><input type="text" name="gatewayEmail[]" value="<?php echo $objPage->arrRow['selectedCountry'][$kk]['gatewayEmail']; ?>" id="gatewayEmail" ></td>
                                                                                <td class="PlusMinus">
        <!--                                                                                    <i>
                                                                                        <span style="cursor: pointer;width:51px;"  onclick="addDynamicRowToTableForShippingGatewaysemail('productRow');"><img src="images/plus.png"/></span>
                                                                                    </i>-->
                                                                                    <a onclick="removeDynamicRowToTableForShippingGatewaysNewEditEmail(this,<?php echo $vv['pkID']; ?><?php //echo $vv['fkportalID']; ?>);"><img src="images/minus.png" /></a>
                                                                                </td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <tr>
                                                                            <td>

                                                                                <?php
                                                                                echo $objGeneral->CountryPortalHtml($abc, 'AdminUserName[]', 'AdminUserName', $SelectedCountry = array(), '', 0, '" class="select2-me input-large" style="width:auto"', '1', '1');
                                                                                ?>
                                                                            </td>
                                                                            <td><input type="text" name="gatewayEmail[]" id="gatewayEmail" ></td>
                                                                            <td class="PlusMinus"><i><span style="cursor: pointer;width:51px;"  onclick="addDynamicRowToTableForShippingGatewaysemail('productRow');"><img src="images/plus.png"/></span></i></td>
                                                                        </tr>
                                                                    </table>

                                                                </div>
                                                            </div>
                                                            <div id="AllowedCountries" style="display:none;" >
                                                                <?php foreach ($abc as $kk => $vv) { ?>
                                                                    <option value="<?php echo $vv['pkAdminID']; ?>"><?php echo $vv['AdminUserName']; ?></option>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">*Shipping Status:</label>
                                                                <div class="controls">
                                                                    <input type="radio" name="frmStatus" id="frmStatus" <?php echo ($objPage->arrRow[0]['ShippingStatus'] == 1) ? 'checked="checked"' : ''; ?> value="1" />Active&nbsp;&nbsp;&nbsp;
                                                                    <input type="radio" name="frmStatus" id="frmStatus" <?php echo ($objPage->arrRow[0]['ShippingStatus'] == 0) ? 'checked="checked"' : ''; ?> value="0" />Deactive
                                                                </div>
                                                            </div>
                                                            <div class="note">Note : * Indicates mandatory fields.</div>

                                                            <div class="form-actions">

                                                                <button name="frmBtnSubmit" type="submit" class="btn btn-blue" value="<?php echo ADMIN_SUBMIT_BUTTON; ?>" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button>
                                                                <a id="buttonDecoration" href="shipping_manage_new_uil.php">
                                                                    <button name="frmCancel" type="button" value="Cancel" class="btn" ><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button>
                                                                </a>
                                                                <input type="hidden" name="httpRef" value="<?php echo $httpRef; ?>" />
                                                                <input type="hidden" name="frmHidenEdit" id="frmHidenEdit" value="edit" />
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
                        <?php
                    } else {
                        ?>
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
