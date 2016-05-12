<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_PAYPAL_EMAIL_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Paypal Accounts</title>
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
                            <h1>Add - Paypal Account</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><a href="settings_frm_uil.php">Settings</a><i class="icon-angle-right"></i></li>
                            <li><a href="paypal_email_manage_uil.php">Paypal Accounts</a><i class="icon-angle-right"></i></li>
                            <li><span>Add Paypal Account</span></li>
                        </ul>
                        <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
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
                                            <div class="box-title">
                                                <h3>Add - Paypal Account</h3>
                                            </div>
                                            <div class="box-content nopadding">
                                                <?php require_once('javascript_disable_message.php'); ?>
                                                <?php if ($_SESSION['sessUserType'] == 'super-admin') { ?>
                                                    <form action=""  method="post" id="frm_page" onsubmit="return validatePaypalEmail();" >
                                                        <div class="row-fluid">
                                                            <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Country:</label>
                                                                    <div class="controls">
                                                                        <select class='select2-me input-large' name="frmCompanyCountry" id="frmCompanyCountry" onchange="showRegionForWholesaler(this.value,'frmCompanyRegion');">
                                                                            <option value="0">All</option>
                                                                            <?php foreach ($objPage->arrCountryList as $vCT) { ?>
                                                                                <option value="<?php echo $vCT['country_id']; ?>"><?php echo $vCT['name']; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Paypal Email:</label>
                                                                    <div class="controls">
                                                                        <input type="text" name="frmEmail" id="frmEmail" size="30" value="">
                                                                    </div>
                                                                </div>
                                                                <div class="note">Note : * Indicates mandatory fields.</div>

                                                                <div class="form-actions">

                                                                    <button name="frmBtnSubmit" type="submit" class="btn btn-blue" style="width:80px;"  value="ButtonSubmit" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button>
                                                                    <a id="buttonDecoration" href="paypal_email_manage_uil.php"><button name="frmCancel" type="button" value="Cancel" style="width:80px;"  class="btn" ><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button></a>
                                                                    <input type="hidden" name="frmHidenAdd" value="add" />

                                                                </div>
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