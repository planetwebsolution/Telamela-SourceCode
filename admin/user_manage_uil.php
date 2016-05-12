<?php
/* * ****************************************
  Module name : Single level user listing
  Date created : 3 May 2008
  Date last modified : 18th Oct 2012
  Author : Prashant Bhardwaj
  Last modified by : Aditya Pratap Singh
  Comments : This file will show all blogs as listing to the admin
  Copyright : Copyright (C) 1999-2009 Vinove Software and Services (P) Ltd.
 * ***************************************** */
require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_user_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_session_redirect_bll.php';
$objAdminLogin = new AdminLogin();
//pre($_REQUEST);
//-----------------------------------------
//check admin session
$objAdminLogin->isValidAdmin();
//$varWhr = " AND UserType != 'SuperAdmin'";
//$arrAdminResult = $objAdminLogin->getAdminEmail($varWhr);
//CREATING THE CLASS OBJECTS FOR INCLUDING CLASS FILES
$objUser = new User();
$objPaging = new Paging();
$objSessionRedirectUrl = new SessionRedirectUrl();
//CREATING THE FIELDS ARRAYS TO SHOW & TABLE (IF JOIN OR OTHER CONDITION EXISTS) & A WHERE CONDITION
//GET THE SEARCHING CONDITION ON THE SPECIFIC SEARCHING
if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') {
    $varSearchWhere = $objUser->getUserString($_REQUEST);
    //echo $varSearchWhere;die;
    if (!empty($varSearchWhere)) {
        $varSearchWhere = $varSearchWhere;
    } else {
        die('sdf');
        $varSearchWhere = " AND AdminType = 'user-moderator' ";
    }
} else {
    $varSearchWhere = " AND (AdminType = 'user-moderator' OR AdminType = 'super-admin') ";
}
//pre($varSearchWhere);
//$varSearchWhere = 'GROUP BY cat.UserName';
if ($_SESSION['sessAdminPageLimit'] == '' || $_SESSION['sessAdminPageLimit'] < 1) {
    $varPageLimit = ADMIN_RECORD_LIMIT;
} else {
    $varPageLimit = $_SESSION['sessAdminPageLimit'];
}
if (isset($_GET['page'])) {
    $varPage = $_GET['page'];
} else {
    $varPage = 0;
}
$varPageStart = $objPaging->getPageStartLimit($varPage, $varPageLimit);
$varLimit = $varPageStart . ',' . $varPageLimit;

$arrRecords = $objAdminLogin->getAdminUserList($varSearchWhere, '');
//$arrColumn = array('pkUserID', 'UserFirstName','UserMiddleName','UserLastName','UserEmail', 'UserStatus', 'UserType', 'UserDiscount', 'UserDateAdded','UserDateUpdated');
//$arrRecords = $objUser->getUserList(TABLE_ADMIN, $arrColumn, $varLimit, $varSearchWhere);
//pre($arrRecords);

$NumberofRows = count($arrRecords);
$varNumberPages = $objPaging->calculateNumberofPages($NumberofRows, $varPageLimit);
$arrAdminResult = $objAdminLogin->getAdminUserList($varSearchWhere, $varLimit);

require_once CLASSES_ADMIN_PATH . 'class_module_list_bll.php';
$objModuleList = new moduleList();
$arrRollList = $objModuleList->getRollList();
$varSortColumn = $objAdminLogin->getSortColumn($_REQUEST);
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Admin</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="../components/cal/skins/aqua/theme.css" title="Aqua" />
        <script type="text/javascript" src="../components/cal/calendar.js"></script>
        <script type="text/javascript" src="../components/cal/lang/calendar-en.js"></script>
        <script type="text/javascript" src="../components/cal/calendar-setup.js"></script>

    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>


        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Manage Admin</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin') { ?>


                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                <li><span>Admin User</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div class="fleft">
                                    <button class="btn btn-inverse" onclick="showSearchBox('search', 'show');">Search  Admin</button>
                                    <a href="admin_user_add_uil.php"><button class="btn btn-inverse">Add New Admin</button></a>
                                </div>

                            </div>
                        </div>
                        <div class="row-fluid" id="search">
                            <div class="span12">
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>Advance Search  </h3>
                                    </div>
                                    <div class="box-content nopadding">
                                        <form action="user_manage_uil.php" method="get" id="frmSearch" onsubmit="return dateCompare('frmSearch');" class='form-horizontal form-bordered'>
                                            <div style="float:left; width:100%; margin-bottom:5px;">
                                                <div class="row-fluid">
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Name:  </label>
                                                            <div class="controls">
                                                                <input type="text"  name="frmSearchUserNameResult" value="<?php echo stripslashes($_GET['frmSearchUserNameResult']); ?>" class="input-large"/>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4 ">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Email: </label>
                                                            <div class="controls">
                                                                <input type="text"  name="frmSearchUserMailResult" value="<?php echo stripslashes($_GET['frmSearchUserMailResult']); ?>" class="input-large"/>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4 ">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">User Type: </label>
                                                            <div class="controls">
                                                                <select name="frmRoll" class='select2-me input-large nomargin'>
                                                                    <option value="0">Select</option>
                                                                    <?php foreach ($arrRollList as $keyRoll => $valueRoll) { ?>
                                                                        <option value="<?php echo $valueRoll['pkAdminRoleId']; ?>" <?php
                                                                if ($_GET['frmRoll'] == $valueRoll['pkAdminRoleId']) {
                                                                    echo 'selected';
                                                                }
                                                                        ?>><?php echo $valueRoll['AdminRoleName']; ?></option>
                                                                            <?php } ?>
                                                                </select>

                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="row-fluid">
                                                    <div class="form-actions span12  search">

                                                        <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                        <input type="submit" name="frmSearch" value="Search" class="btn" style="width:70px;" />
                                                        <?php if ($_GET['frmSearch'] != '') { ?>
                                                            <input type="button" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" onclick="location.href = 'user_manage_uil.php'" class="btn" style="width:70px;" />
                                                        <?php } else { ?>
                                                            <input type="button" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" onclick="showSearchBox('search', 'hide');" class="btn" style="width:70px;" />
                                                        <?php } ?>

                                                    </div>
                                                </div>


                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row-fluid" style="width:98%;margin:10px;">
                        <div class="span12">
                            <?php
                            if ($objCore->displaySessMsg() <> '') {
                                echo $objCore->displaySessMsg();
                                $objCore->setSuccessMsg('');
                                $objCore->setErrorMsg('');
                            }
                            ?>
                            <div class="box box-color box-bordered">
                                <div class="box-title">
                                    <h3>
                                        Admin User List
                                    </h3>
                                </div>
                                <div class="box-content nopadding manage_categories">
                                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                        <?php if ($NumberofRows > 0) { ?>
                                            <form id="frmUsersList" name="frmUsersList" action="user_action.php" method="post">
                                                <input type="hidden" name="frmPage" value="<?php echo $_GET['page']; ?>" />
                                                <input type="hidden" name="frmProcess" id="frmProcess" value="ManipulateUser"  />
                                                <input type="hidden" name="frmUserID" id="frmUserID" value=""  />
                                                <table class="table table-hover table-nomargin table-bordered usertable">
                                                    <thead>
                                                        <tr>
                                                            <th class='with-checkbox hidden-480'>
                                                                <input type="hidden" name="frmProcess" id="frmProcess" value="ManipulateUser"/>
                                                                <input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" />
                                                            </th>

                                                            <?php
                                                            echo $varSortColumn;
                                                            ?>
                                                            <th>Action</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($arrAdminResult as $varKey => $varValue) {
                                                            ?>


                                                            <tr>
                                                                <td valign="top" class="hidden-480">
                                                                    <?php if ($varValue['AdminType'] == 'user-moderator') { ?><input style="width:20px; border:none;" type="checkbox" name="frmUsersID[]" id="frmUsersID[]"  value="<?php echo $varValue['pkAdminID']; ?>" onclick="singleSelectClick(this, 'singleCheck');" class="singleCheck"/><?php } ?>
                                                                </td>
                                                                <td class="hidden-480"><?php echo trim(stripslashes($varValue['AdminTitle'])); ?></td>
                                                                <td><?php echo trim(stripslashes($varValue['AdminUserName'])); ?></td>
                                                                <td class="hidden-480"><?php echo trim(stripslashes($varValue['AdminEmail'])); ?></td>
                                                                <td class="hidden-350"><?php
                                                                    if ($varValue['AdminType'] == 'super-admin') {
                                                                        echo 'Super Admin';
                                                                    } else {
                                                                        echo trim(stripslashes($varValue['AdminRoleName']));
                                                                    }
                                                                    ?></td>
                                                                <td>
                                                                    <?php if ($varValue['AdminType'] == 'user-moderator') { ?>
                                                                        <a href="admin_user_add_uil.php?UserID=<?php echo $varValue['pkAdminID']; ?>" class="btn" rel="tooltip" title="" data-original-title="Edit"><i class="icon-edit"></i></a>&nbsp;
                                                                        <a onclick="return fconfirm('Are you sure you want to delete this User ?', this.href)" href="user_action.php?frmProcess=deleteUser&frmUserID=<?php echo $varValue['pkAdminID']; ?>" class="btn" rel="tooltip" title="" data-original-title="Delete"><i class="icon-remove"></i></a>&nbsp;
                                                                    <?php } ?>
                                                                </td>

                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate"><?php
                                                if ($varNumberPages > 1) {
                                                    $objPaging->displayPaging($_GET['page'], $varNumberPages, $varPageLimit);
                                                }
                                                        ?></div>
                                                <div class="controls hidden-480">
                                                    <select name="frmChangeAction" onchange="javascript:return setValidAction(this.value, this.form, 'User(s)');" ata-rule-required="true">
                                                        <option value="">-- Select Action --</option>
                                                        <option value="Delete">Delete</option>
                                                    </select>
                                                    <label for="textfield" class="control-label">This action will be performed on the above selected record(s). </label>
                                                </div>

                                            </form>
                                        <?php } else { ?>
                                            <table class="table table-hover table-nomargin table-bordered usertable">
                                                <tr class="content">
                                                    <td colspan="10" style="text-align:center">
                                                        <strong>No record(s) found.</strong>
                                                    </td>
                                                </tr>
                                            </table>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } else { ?>
                    <table width="100%">
                        <tr>
                            <th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th>
                        </tr>
                        <tr>
                            <td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td>
                        </tr>
                    </table>
                <?php } ?>
            </div>
            <?php require_once('inc/footer.inc.php'); ?>
        </div>


        <script type="text/javascript">
<?php if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') { ?>
                showSearchBox('search', 'show');
<?php } else { ?>
                showSearchBox('search', 'hide');
<?php } ?>
        </script>


    </body>
</html>
