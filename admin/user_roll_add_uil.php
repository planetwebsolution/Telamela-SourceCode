<?php
/* * ****************************************
  Module name : Users form
  Date created : 12th August 2010
  Date last modified : 12th August 2010
  Author : Pankaj Pandey
  Last modified by : Pankaj Pandey
  Comments : This is the user form , where client can add/edit categories.
  Copyright : Copyright (C) 1999-2010 Vinove
 * ***************************** */
require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_adminuser_bll.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_MODULE_LIST_CTRL;

//CREATING THE CLASS OBJECTS FOR INCLUDING CLASS FILES
$objUser = new AdminUser();
$objAdminLogin = new AdminLogin();
//check session

if (isset($_SESSION['sessArrUsers']) && $_SESSION['sessArrUsers'] != '') {
    $_SESSION['sessArrUsers'] = $objCore->removePrefix($_SESSION['sessArrUsers'], 3);
    @extract($objCore->addPrefix($_SESSION['sessArrUsers'], 'var'));
    $role = ((isset($_SESSION['sessArrUsers']['rType']) && ($_SESSION['sessArrUsers']['rType'] != "")) ? ($_SESSION['sessArrUsers']['rType']) : "");
    //echo '22'.$role;die;
    //echo '<pre>';print_r($_SESSION['sessArrUsers']);die;
} else {
    if ($_GET['UserID'] != '') {
        $varUserWhere = 'AND pkAdminID = \'' . $_GET['UserID'] . '\'';

        $arrUserList = $objAdminLogin->getAdminInfo($varUserWhere);
        if ($arrUserList == '') {
            header('location:user_list_uil.php');
            die;
        }
        @extract($objCore->addPrefix($arrUserList[0], 'var'));
        $role = ((isset($arrUserList[0]['UserType']) && ($arrUserList[0]['UserType'] != "")) ? ($arrUserList[0]['UserType']) : "");
    }
}//echo '<pre>';print_r($_SESSION['sessArrUsers']);die;
$displayUser = (!empty($_GET['UserID'])) ? 'Edit User' : 'Add User';
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
        <?php require_once 'inc/common_css_js.inc.php'; ?>

        <link rel="stylesheet" type="text/css" media="all" href="../components/cal/skins/aqua/theme.css" title="Aqua" />

        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <style>
            ul { list-style: none; margin: 5px 5px;}
            li {margin: 0 0 5px 0;}
        </style>

    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>

        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1> Role Management </h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>	
                                <i class="icon-angle-right"></i>
                            </li>	
                            <li>
                                <a href="settings_frm_uil.php">Settings</a>	
                                <i class="icon-angle-right"></i>
                            </li>	
                            <li>
                                <a href="user_roll_manage_uil.php">Role Management</a>
                                <i class="icon-angle-right"></i>

                            </li>
                            <li>
                                <!--<a href="user_roll_add_uil.php"><?php // echo ($_GET['type'] == 'edit') ? 'Edit' : 'Add New'; ?> Role</a>-->	
                                <span><?php echo ($_GET['type'] == 'edit') ? 'Edit' : 'Add New'; ?> Role</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>
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

                            <?php } ?>
                            <div class="box box-color box-bordered new-role">
                                <div class="box-title">
                                    <h3>      <?php
                                        if ($_GET['rollid']) {
                                            echo 'Edit Role ';
                                        } else {
                                            echo 'Add New Role';
                                        }
                                        ?>  </h3>

                                    <a id="buttonDecoration" href="user_roll_manage_uil.php" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>

                                </div>
                                <div class="box-content nopadding">                                                            
                                    <?php require_once 'javascript_disable_message.php'; ?>
                                    <form id="frmUsersAdd" name="frmModuleAdd" action="" onsubmit="return validateModule('frmModuleAdd');" method="post">
                                        <div class="control-group padding_10">
                                            <label class="control-label" for="textfield">* Role Name :</label>
                                            <div class="controls">
                                                <input type="text" maxlength="50" name="frmRollName" id="frmRollName" value="<?php echo $objPage->arrRow[0]['AdminRoleName']; ?>" class="input-large" <?php
                                                if (($objPage->arrRow[0]['AdminRoleName'] == 'Country Portal') || ($objPage->arrRow[0]['AdminRoleName'] == 'DefaultCountryPortal')) {
                                                    echo 'readonly="true"';
                                                }
                                                ?>  />

                                            </div>
                                        </div>
                                        <?php $arrPermission = explode(',', $objPage->arrRow[0]['AdminRolePermission']); ?>
                                        <div class="control-group padding_10">
                                            <label class="control-label" for="textfield"> Access Permission</label>										
                                        </div>
                                        <div class="row-fluid">

                                            <script>
                                                $(function () {
                                                    // Apparently click is better chan change? Cuz IE?
                                                    $('input[type="checkbox"]').change(function (e) {
                                                        var checked = $(this).prop("checked"),
                                                                container = $(this).parent(),
                                                                siblings = container.siblings();

                                                        container.find('input[type="checkbox"]').prop({
                                                            indeterminate: false,
                                                            checked: checked
                                                        });

                                                        function checkSiblings(el) {
                                                            var parent = el.parent().parent(),
                                                                    all = true;

                                                            el.siblings().each(function () {
                                                                return all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
                                                            });

                                                            if (all && checked) {
                                                                parent.children('input[type="checkbox"]').prop({
                                                                    indeterminate: false,
                                                                    checked: checked
                                                                });
                                                                checkSiblings(parent);
                                                            } else if (all && !checked) {
                                                                parent.children('input[type="checkbox"]').prop("checked", checked);
                                                                parent.children('input[type="checkbox"]').prop("indeterminate", (parent.find('input[type="checkbox"]:checked').length > 0));
                                                                checkSiblings(parent);
                                                            } else {
                                                                el.parents("li").children('input[type="checkbox"]').prop({
                                                                    indeterminate: true,
                                                                    checked: false
                                                                });
                                                            }
                                                        }

                                                        checkSiblings(container);
                                                    });
                                                });
                                            </script>

                                            <?php foreach ($objPage->arrModuleList as $valuecheckL1) { ?>
                                                <div class="span3 form-horizontal form-bordered" style=" margin-left:15px; float:left;">  
                                                    <div class="control-group"><input type="checkbox"  name="permission[]"  id="<?php echo $valuecheckL1['ModuleAlias']; ?>" value="<?php echo $valuecheckL1['ModuleAlias']; ?>" <?php
                                                        if (in_array($valuecheckL1['ModuleAlias'], $arrPermission)) {
                                                            echo 'checked="checked"';
                                                        }
                                                        ?>  />
                                                        <b><?php echo $valuecheckL1['ModuleName']; ?></b>
                                                        <ul>
                                                            <?php foreach ($valuecheckL1['l1'] as $valuecheckL2) { ?>

                                                                <li>
                                                                    <input type="checkbox" name="permission[]" id="<?php echo $valuecheckL2['ModuleAlias']; ?>" value="<?php echo $valuecheckL2['ModuleAlias']; ?>" <?php
                                                                    if (in_array($valuecheckL2['ModuleAlias'], $arrPermission)) {
                                                                        echo 'checked="checked"';
                                                                    }
                                                                    ?> />
                                                                           <?php echo $valuecheckL2['ModuleName']; ?>
                                                                    <ul>
                                                                        <?php foreach ($valuecheckL2['l2'] as $valuecheckL3) { ?>

                                                                            <li><input type="checkbox" name="permission[]" id="<?php echo $valuecheckL3['ModuleAlias']; ?>" value="<?php echo $valuecheckL3['ModuleAlias']; ?>" <?php
                                                                                if (in_array($valuecheckL3['ModuleAlias'], $arrPermission)) {
                                                                                    echo 'checked="checked"';
                                                                                }
                                                                                ?> />
                                                                                <?php echo $valuecheckL3['ModuleName']; ?></li>


                                                                        <?php } ?> </ul></li>
                                                            <?php } ?></ul> 
                                                    </div>
                                                </div>
                                            <?php } ?> 
                                        </div>



                                        <div class="form-actions">                                                                            
                                            <button name="frmBtnSubmit" type="submit"  class="btn btn-primary" style="width:80px;"  value="ButtonSubmit" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button>
                                            <input type="hidden" name="frmHidnAddEdit" id="frmHidnAddEditPage" value="addEditRole" />
                                            <a id="buttonDecoration" href="user_roll_manage_uil.php"><button name="frmCancel" type="button" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" style="width:80px;"  class="btn" ><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button></a>




                                        </div>
                                        <div class="note">Note : * Indicates mandatory fields.</div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php require_once 'inc/footer.inc.php'; ?>
        </div>

    </body>
</html>