<?php
/* * ****************************************
  Module name : logistic add form
  Date created : 20th march 2016
  Date last modified : 20th march 2016
  Author : Avinesh mathur

  Comments : This is the Logistic form , where client can add/edit categories.

 * ***************************** */
require_once '../common/config/config.inc.php';

require_once CLASSES_ADMIN_PATH . 'class_adminuser_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_module_list_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_logistic_portal_bll.php';
$objModuleList = new moduleList();
$arrRollList = $objModuleList->getRollList();

//pre($_SESSION);
//CREATING THE CLASS OBJECTS FOR INCLUDING CLASS FILES
$objUser = new AdminUser();
$objAdminLogin = new AdminLogin();
$objlogisticPortal = new logistic();
//check session
$arrCountry = $objUser->getCountry();
$arrPortal = $objUser->getPortal();

foreach ($arrPortal as $k => $v) {
    $PortalIDs[] = $v['AdminCountry'];
}

if ($_GET['UserID'] != '') {
    //pre($_REQUEST);
    $varUserWhere = 'AND logisticportalid = \'' . trim(mysql_real_escape_string($_GET['UserID'])) . '\'';

    $arrUserList = $objlogisticPortal->getlogisticInfo($varUserWhere);
    $logisticportalselectedid = $arrUserList[0]['logisticportal'];
    //pre($arrUserList);
    if ($arrUserList == '') {
        header('location:user_list_uil.php');
        die;
    }
    @extract($objCore->addPrefix($arrUserList[0], 'var'));
    $role = ((isset($arrUserList[0]['UserType']) && ($arrUserList[0]['UserType'] != "")) ? ($arrUserList[0]['UserType']) : "");
} else {
    $logisticportalselectedid = null;
}

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
        <title><?php echo ADMIN_PANEL_NAME; ?> : <?php echo (isset($_GET['UserID'])) ? 'Edit' : 'Add New'; ?> Logistic Portal</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <link type="text/css"  rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <script type="text/javascript">
            var SITE_ROOT_URL = '<?php echo SITE_ROOT_URL; ?>';


        </script>
        <style>

            #frmCountry{width:224px; border-radius:0px; -webkit-border-radius:0px; -moz-border-radius:0px;}
        </style>


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
                            <h1><?php echo $add ?>  Logistic Portal</h1>
                        </div>
                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><a href="logistic_portal_manage_uil.php">Logistic Portal</a><i class="icon-angle-right"></i></li>
<!--                            <li><a href="user_add_uil.php<?php echo $url; ?>"><?php echo $add; ?> User</a></li>-->
                            <li><span><?php echo $add; ?> Logistic Portal</span></li>
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
                                                <a id="buttonDecoration" href="<?php if (!isset($_GET['type'])) { ?>user_manage_uil.php <?php } else { ?>logistic_portal_manage_uil.php <?php } ?>"><input type="button" class="btn" name="btnTagSettings" value="<?php echo ADMIN_BACK_BUTTON; ?>" style="float:right; margin:6px 2px 0 0; width:107px;"/></a>
                                                <h3>
                                                    <?php
                                                    if ($_GET['UserID']) {
                                                        echo 'Edit Logistic Portal Details';
                                                    } else {
                                                        echo 'Add Logistic Portal';
                                                    }
                                                    ?>
                                                </h3>                                                            
                                            </div>

                                            <div class="box-content nopadding"> 

                                                <?php require_once('javascript_disable_message.php'); ?>


                                                <?php
                                                if ($_SESSION['sessUserType'] == 'super-admin' || in_array('AddLogisticPortal', $_SESSION['sessAdminPerMission'])) {
                                                    // pre($arrUserList[0]);
                                                    ?>

                                                    <form id="frmUsersAdd" name="frmUsersAdd" action="logistic_action.php" onsubmit="return validateLogistic('frmUsersAdd');" method="post">


                                                        <div class="row-fluid">
                                                            <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Company Name:   </label>
                                                                    <div class="controls">
                                                                        <input type="text" maxlength="50" name="frmTitle" id="frmTitle" value="<?php echo (isset($arrUserList[0]['logisticTitle']) && $arrUserList[0]['logisticTitle'] != "") ? stripslashes($arrUserList[0]['logisticTitle']) : (isset($_SESSION['sessArrUsers']['Name']) && ($_SESSION['sessArrUsers']['Name'] != '') ? $_SESSION['sessArrUsers']['Name'] : "") ?>" class="input-large"/>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*User Name: </label>
                                                                    <div class="controls">
                                                                        <input type="text" maxlength="50" name="frmName" id="frmFirstName" value="<?php echo (isset($arrUserList[0][logisticUserName]) && $arrUserList[0][logisticUserName] != "") ? stripslashes($arrUserList[0][logisticUserName]) : (isset($_SESSION['sessArrUsers']['Name']) && ($_SESSION['sessArrUsers']['Name'] != '') ? $_SESSION['sessArrUsers']['Name'] : "") ?>" class="input-large"/>

                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*User Email:  </label>
                                                                    <div class="controls">
                                                                        <input type="text" maxlength="200" name="frmUserEmail" id="frmUserEmail" value="<?php echo (isset($arrUserList[0][logisticEmail]) && $arrUserList[0][logisticEmail] != "") ? stripslashes($arrUserList[0][logisticEmail]) : (isset($_SESSION['sessArrUsers']['UserEmail']) && ($_SESSION['sessArrUsers']['UserEmail'] != '') ? $_SESSION['sessArrUsers']['UserEmail'] : "") ?>" class="input-large"/>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label for="" class="control-label">*Password:</label>
                                                                    <div class="controls">
                                                                        <input type="password" maxlength="20" name="frmPassword" id="frmPassword" value="<?php echo (isset($arrUserList[0]['logisticPassword']) && $arrUserList[0]['logisticPassword'] != "") ? $arrUserList[0]['logisticPassword'] : (isset($_SESSION['sessArrUsers']['Password']) && ($_SESSION['sessArrUsers']['Password'] != '') ? $_SESSION['sessArrUsers']['Password'] : "") ?>" class="input-large"/>

                                                                        <span class="help-block">Password must contain minimum 6 chars.</span>

                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="" class="control-label">*Re-Type Password:</label>
                                                                    <div class="controls">
                                                                        <input type="password" maxlength="20" name="frmConfirmPassword" id="frmConfirmPassword" value="<?php echo (isset($arrUserList[0]['logisticPassword']) && $arrUserList[0]['logisticPassword'] != "") ? $arrUserList[0]['logisticPassword'] : (isset($_SESSION['sessArrUsers']['ConfirmPassword']) && ($_SESSION['sessArrUsers']['ConfirmPassword'] != '') ? $_SESSION['sessArrUsers']['ConfirmPassword'] : "") ?>" class="input-large"/>


                                                                    </div>
                                                                </div>
                                                                <?php
                                                                if ($_SESSION['sessUserType'] == 'super-admin') {
                                                                    ?>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Country Name:   </label>
                                                                        <div class="controls">
                                                                            <div id="" class="input_sec input_star input_boxes multiple <?php //echo ($productmulcountrydetail[0]['producttype'] == 'multiple') ? '' : 'mulcountries';        ?> ">
                                                                                <?php
                                                                                $abc = $objGeneral->getCountry();
                                                                                $varCntry = (isset($arrUserList[0]['logisticportal']) && $arrUserList[0]['logisticportal'] != "") ? stripslashes($arrUserList[0]['logisticportal']) : (isset($_SESSION['sessArrUsers']['Country']) && ($_SESSION['sessArrUsers']['Country'] != '') ? $_SESSION['sessArrUsers']['Country'] : "")
                                                                                ?>
                                                                                <select name="CountryPortalID" id="frmCountry"  class='select2-me input-large'>
                                                                                    <?php
                                                                                    foreach ($abc as $keyCty => $valueCty) {
                                                                                        if (in_array($valueCty['country_id'], $PortalIDs)) {
                                                                                            ?>
                                                                                            <option value="<?php echo $valueCty['country_id']; ?>" <?php
                                                                                            if ($valueCty['country_id'] == $varCntry) {
                                                                                                echo 'selected';
                                                                                            }
                                                                                            ?>><?php echo $valueCty['name']; ?></option>
                                                                                                <?php }
                                                                                            }
                                                                                            ?>
                                                                                </select>
                                                                                <?php
//                                                                            $abc = $objGeneral->getCountry();
//                                                                            if(!empty($arrUserList[0]['logisticportal']))
//                                                                            {
//                                                                                $SelectedCountryid=$arrUserList[0]['logisticportal'];
//                                                                            }
//                                                                            else {
//                                                                                $SelectedCountryid='';
//                                                                            }
                                                                                //pre($SelectedCountryid);
                                                                                //$SelectedCountry = array()
                                                                                // echo $objGeneral->CountryHtml($abc, 'CountryPortalID', 'country_id',$SelectedCountryid , '', 0, '1', '1');
//                                                                        $abc = $objGeneral->getCountryPortal();
//                                                                         echo $objGeneral->CountryPortalHtml($abc, 'CountryPortalID', 'pkAdminID', $logisticportalselectedid, 'Select Country Portal', 0, '1', '1');
//                                                                        
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if (in_array('AddLogisticPortal', $_SESSION['sessAdminPerMission'])) {
                                                                    //sessUser
                                                                    ?>
                                                                    <input type="hidden" name="CountryPortalID" value="<?php echo $_SESSION['sessAdminCountry'] ?>"/>
    <?php } ?>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Logical Portal Status:</label>
                                                                    <div class="controls">       
                                                                        <?php
                                                                        if ($arrUserList[0]['logisticStatus'] == '') {
                                                                            $arrUserList[0]['logisticStatus'] = 1;
                                                                        }
                                                                        // pre($arrUserList[0]['logisticStatus']);
                                                                        ?>                                                             
                                                                        <input type="radio" name="frmStatus" id="frmStatus" <?php echo ($arrUserList[0]['logisticStatus'] == 1) ? 'checked="checked"' : ''; ?> value="1" />Active&nbsp;&nbsp;&nbsp; 
                                                                        <input type="radio" name="frmStatus" id="frmStatus" <?php echo ($arrUserList[0]['logisticStatus'] == 0) ? 'checked="checked"' : ''; ?> value="0" />Deactive
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
                                                                        <input type="hidden" name="frmProcess" value="EditUser"  />
                                                                        <button name="frmBtnEdit" type="submit" class="btn btn-blue" value="ButtonEdit" >Submit</button>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <input type="hidden" name="frmProcess" value="AddUser"  />

                                                                        <button name="frmBtnSubmit" type="submit" class="btn btn-blue" value="ButtonSubmit" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button>  <?php } ?>
                                                                    <button  id="cancelbutton" name="frmCancel" type="reset" value="Cancel" class="btn" ><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button>


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

                        <?php
                    } else {
                        // pre("here565666");
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
