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
require_once CLASSES_ADMIN_PATH . 'class_module_list_bll.php';
$objModuleList = new moduleList();
$arrRollList = $objModuleList->getRollList();



//CREATING THE CLASS OBJECTS FOR INCLUDING CLASS FILES
$objUser = new AdminUser();
$objAdminLogin = new AdminLogin();
//check session
$arrCountry = $objUser->getCountry();
$arrPortal = $objUser->getPortal();

foreach ($arrPortal as $k => $v) {
    $PortalIDs[] = $v['AdminCountry'];
}
//pre($PortalIDs);
//echo '<pre>';print_r($_SESSION['sessArrUsers']);die;
//if (isset($_SESSION['sessArrUsers']) && $_SESSION['sessArrUsers'] != '')
//{
//    $_SESSION['sessArrUsers'] = $objCore->removePrefix($_SESSION['sessArrUsers'], 3);
//    @extract($objCore->addPrefix($_SESSION['sessArrUsers'], 'var'));
//    $role = ((isset($_SESSION['sessArrUsers']['rType']) && ($_SESSION['sessArrUsers']['rType'] != "")) ? ($_SESSION['sessArrUsers']['rType']) : "");
//    //echo '22'.$role;die;
//    //echo '<pre>';print_r($_SESSION['sessArrUsers']);die;
//}
//else
//{
if ($_GET['UserID'] != '') {
    //pre($_REQUEST);
    $varUserWhere = 'AND pkAdminID = \'' . trim(mysql_real_escape_string($_GET['UserID'])) . '\'';

    $arrUserList = $objAdminLogin->getAdminInfo($varUserWhere);
    //pre($arrUserList);
    if ($arrUserList == '') {
        header('location:user_list_uil.php');
        die;
    }
    @extract($objCore->addPrefix($arrUserList[0], 'var'));
    $role = ((isset($arrUserList[0]['UserType']) && ($arrUserList[0]['UserType'] != "")) ? ($arrUserList[0]['UserType']) : "");
}
//}
//echo '<pre>';print_r($arrUserList);die;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Add Admin User</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <link type="text/css"  rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <script type="text/javascript">
            var SITE_ROOT_URL = '<?php echo SITE_ROOT_URL; ?>';
        </script>

    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>
        <?php
        if (isset($_GET['UserID'])) {
            $add = 'Edit';
            $url = '?UserID=' . $_GET['UserID'];
        } else {
            $add = 'Add New';
            $url = '';
        }
        ?>
        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1><?php echo $add ?>  Admin</h1>
                        </div>
                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><a href="user_manage_uil.php">Admin User</a><i class="icon-angle-right"></i></li>
<!--                            <li><a href="user_add_uil.php<?php echo $url; ?>"><?php echo $add; ?> User</a></li>-->
                            <li><span><?php echo $add; ?> Admin</span></li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <div class="row-fluid">						
                        <div class="span12">
                            <div class="tab-pane active" id="tabs-2">
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
                                                <a id="buttonDecoration" href="<?php if (!isset($_GET['type'])) { ?>user_manage_uil.php <?php } else { ?>country_portal_manage_uil.php <?php } ?>"><input type="button" class="btn" name="btnTagSettings" value="<?php echo ADMIN_BACK_BUTTON; ?>" style="float:right; margin:6px 2px 0 0; width:107px;"/></a>
                                                <h3>
                                                    <?php
                                                    if ($_GET['UserID']) {
                                                        echo 'Edit Admin Details';
                                                    } else {
                                                        echo 'Add New Admin';
                                                    }
                                                    ?>
                                                </h3>                                                            
                                            </div>

                                            <div class="box-content nopadding"> 

                                                <?php require_once('javascript_disable_message.php'); ?>


                                                <?php
                                                if ($_SESSION['sessUserType'] == 'super-admin') {
                                                    ?>

                                                    <form id="frmUsersAdd" name="frmUsersAdd" action="user_action.php" onsubmit="return validateUser('frmUsersAdd');" method="post">


                                                        <div class="row-fluid">
                                                            <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*User Title:   </label>
                                                                    <div class="controls">
                                                                        <input type="text" maxlength="50" name="frmTitle" id="frmTitle" value="<?php echo (isset($arrUserList[0]['AdminTitle']) && $arrUserList[0]['AdminTitle'] != "") ? stripslashes($arrUserList[0]['AdminTitle']) : (isset($_SESSION['sessArrUsers']['Name']) && ($_SESSION['sessArrUsers']['Name'] != '') ? $_SESSION['sessArrUsers']['Name'] : "") ?>" class="input-large"/>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*User Name: </label>
                                                                    <div class="controls">
                                                                        <input type="text" maxlength="50" name="frmName" id="frmFirstName" value="<?php echo (isset($arrUserList[0][AdminUserName]) && $arrUserList[0][AdminUserName] != "") ? stripslashes($arrUserList[0][AdminUserName]) : (isset($_SESSION['sessArrUsers']['Name']) && ($_SESSION['sessArrUsers']['Name'] != '') ? $_SESSION['sessArrUsers']['Name'] : "") ?>" class="input-large"/>

                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*User Email:  </label>
                                                                    <div class="controls">
                                                                        <input type="text" maxlength="200" name="frmUserEmail" id="frmUserEmail" value="<?php echo (isset($arrUserList[0][AdminEmail]) && $arrUserList[0][AdminEmail] != "") ? stripslashes($arrUserList[0][AdminEmail]) : (isset($_SESSION['sessArrUsers']['UserEmail']) && ($_SESSION['sessArrUsers']['UserEmail'] != '') ? $_SESSION['sessArrUsers']['UserEmail'] : "") ?>" class="input-large"/>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="" class="control-label">*Password:</label>
                                                                    <div class="controls">
                                                                        <input type="password" maxlength="20" name="frmPassword" id="frmPassword" value="<?php echo (isset($arrUserList[0]['AdminPassword']) && $arrUserList[0]['AdminPassword'] != "") ? $arrUserList[0]['AdminPassword'] : (isset($_SESSION['sessArrUsers']['Password']) && ($_SESSION['sessArrUsers']['Password'] != '') ? $_SESSION['sessArrUsers']['Password'] : "") ?>" class="input-large"/>
                                                                        <span class="help-block">Password must contain minimum 6 chars.</span>

                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="" class="control-label">*Re-Type Password:</label>
                                                                    <div class="controls">
                                                                        <input type="password" maxlength="20" name="frmConfirmPassword" id="frmConfirmPassword" value="<?php echo (isset($arrUserList[0]['AdminPassword']) && $arrUserList[0]['AdminPassword'] != "") ? $arrUserList[0]['AdminPassword'] : (isset($_SESSION['sessArrUsers']['ConfirmPassword']) && ($_SESSION['sessArrUsers']['ConfirmPassword'] != '') ? $_SESSION['sessArrUsers']['ConfirmPassword'] : "") ?>" class="input-large"/>

                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textarea" class="control-label">*Role:   </label>
                                                                    <div class="controls">

                                                                        <?php $varRoll = (isset($arrUserList[0]['fkAdminRollId']) && $arrUserList[0]['fkAdminRollId'] != "") ? stripslashes($arrUserList[0]['fkAdminRollId']) : (isset($_SESSION['sessArrUsers']['AdminRoll']) && ($_SESSION['sessArrUsers']['AdminRoll'] != '') ? $_SESSION['sessArrUsers']['AdminRoll'] : "") ?>
                                                                        <select name="frmAdminRoll" id="frmAdminRoll" class='select2-me input-large'>

                                                                            <option value="">Select Role</option>
                                                                            <?php
                                                                            foreach ($arrRollList as $keyRoll => $valueRoll) {
                                                                                ?>
                                                                                <option value="<?php echo $valueRoll['pkAdminRoleId']; ?>"<?php
                                                                                if ($valueRoll['pkAdminRoleId'] == $varRoll || ($_GET[type] == 'cp' && $valueRoll['AdminRoleName'] == 'Country Portal')) {
                                                                                    echo 'selected';
                                                                                }
                                                                                ?>><?php echo $valueRoll['AdminRoleName']; ?></option>
                                                                                    <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textarea" class="control-label">Country:   </label>
                                                                    <div class="controls">
                                                                        <?php $varCntry = (isset($arrUserList[0]['AdminCountry']) && $arrUserList[0]['AdminCountry'] != "") ? stripslashes($arrUserList[0]['AdminCountry']) : (isset($_SESSION['sessArrUsers']['Country']) && ($_SESSION['sessArrUsers']['Country'] != '') ? $_SESSION['sessArrUsers']['Country'] : "") ?>
                                                                        <select name="frmCountry" id="frmCountry" onchange="ShowRegion(this.value);" class='select2-me input-large'>
                                                                         <?php foreach ($arrCountry as $keyCty => $valueCty) { 
                                                                                            if(in_array($valueCty['country_id'], $PortalIDs)){
                                                                                            ?>
                                                                                            <option value="<?php echo $valueCty['country_id']; ?>"
                                                                                            <?php
                                                                                if ($valueCty['country_id'] == $varCntry) {
                                                                                    echo 'selected';
                                                                                }
                                                                                ?>
                                                                                            
                                                                                            ><?php echo $valueCty['name']; ?></option>
                                                                                            <?php } } ?>
                                                                        
                                                                         
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                               
                                                                <div class="note">Note : * Indicates mandatory fields.</div>

                                                                <div class="form-actions">

                                                                    <input type="hidden" name="frmSubmitPress" id="frmSubmitPress" value="Yes" />
                                                                    <input type="hidden" name="frmUserID" value="<?php echo $_GET['UserID']; ?>" />
                                                                    <input type="hidden" name="type" value="<?php echo $_GET['type']; ?>"  />
                                                                    <?php
                                                                    if ($_GET['UserID'] != '') {
                                                                        ?>
                                                                        <input type="hidden" name="frmProcess" value="EditModeratorUser"  />
                                                                        <button name="frmBtnEdit" type="submit" class="btn btn-blue" value="ButtonEdit" >Submit</button>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <input type="hidden" name="frmProcess" value="AddModeratorUser"  />

                                                                        <button name="frmBtnSubmit" type="submit" class="btn btn-blue" value="ButtonSubmit" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button> 
                                                                    <?php } ?>
                                                                    <a id="buttonDecoration" href="javascript:history.go(-1)"><button name="frmCancel" type="button" value="Cancel" class="btn" ><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button></a>


                                                                </div>


                                                            </div>
                                                        </div>

                                                    </form>
                                                    <form id="frmArchive" name="frmArchive" action="user_action.php" method="post">
                                                        <table width="100%" border="0">
                                                            <tr>
                                                                <td>
                                                                    <input type="hidden" name="frmStartDate" value="<?php echo $varSalesTargetStartDate; ?>" />
                                                                    <input type="hidden" name="frmEndDate" value="<?php echo $varSalesTargetEndDate; ?>" />
                                                                    <input type="hidden" name="frmCommission" value="<?php echo $arrUserList[0]['Commission']; ?>" />
                                                                    <input type="hidden" name="frmSalesTarget" value="<?php echo $arrUserList[0]['SalesTarget']; ?>" />
                                                                    <input type="hidden" name="frmUserID" value="<?php echo $_GET['UserID']; ?>" />
                                                                    <input type="hidden" name="frmProcess" value="AddArchive" />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </form>
                                                </div>

                                            </div>


                                        </div>
                                    </div>
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
