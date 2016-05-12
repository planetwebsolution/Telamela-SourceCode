<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_PAYPAL_EMAIL_CTRL;
//pre($_SESSION);
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
        <link rel="stylesheet" type="text/css" media="all" href="../components/cal/skins/aqua/theme.css" title="Aqua" />

    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>


        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Manage Paypal Accounts</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin') { ?>


                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                               
                                <li><span>Paypal Accounts</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div class="fleft">
                                    <button class="btn btn-inverse" onclick="showSearchBox('search','show');">Search  User</button>
                                    <a href="paypal_email_add_uil.php"><button class="btn btn-inverse">Add New </button></a>
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
                                        <form action="" method="get" id="frmSearch" onsubmit="return dateCompare('frmSearch');" class='form-horizontal form-bordered'>
                                            <div style="float:left; width:100%; margin-bottom:5px;">
                                                <div class="row-fluid">
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Country Name:  </label>
                                                            <div class="controls">
                                                                <select name="frmCompanyCountry" id="frmCompanyCountry" class='select2-me input-large'>
                                                                    <option value="0">All</option>
                                                                    <?php foreach ($objPage->arrCountryList as $vCT) { ?>
                                                                        <option value="<?php echo $vCT['country_id']; ?>" <?php
                                                                if (@$_GET['frmCompanyCountry'] == $vCT['country_id']) {
                                                                    echo "selected";
                                                                }
                                                                        ?>><?php echo $vCT['name']; ?></option>
                                                                            <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4 ">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Paypal Email Id:</label>
                                                            <div class="controls">
                                                                <input type="text" name="frmEmail" class="input-large" id="frmEmail" value="<?php echo @$_GET['frmEmail']; ?>" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row-fluid">
                                                    <div class="form-actions span12  search">

                                                        <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                        <input type="submit" name="frmSearch" value="Search" class="btn" style="width:70px;" />
                                                        <?php if ($_GET['frmSearch'] != '') { ?>
                                                            <input type="button" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" onclick="location.href = 'paypal_email_manage_uil.php'" class="btn" style="width:70px;" />
                                                        <?php } else { ?>
                                                            <input type="button" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" onclick="showSearchBox('search','hide');" class="btn" style="width:70px;" />
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
                                        Paypal Accounts
                                    </h3>
                                </div>
                                <div class="box-content nopadding manage_categories">
                                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                        <?php if ($objPage->NumberofRows > 0) { ?>
                                            <form id="frmAdsList" name="frmAdsList" action="paypal_action.php" method="post">

                                                <table class="table table-hover table-nomargin table-bordered usertable">
                                                    <thead>
                                                        <tr>
                                                            <th class='with-checkbox hidden-480'>
                                                                <input type="hidden" name="frmProcess" id="frmProcess" value="ManipulateUser"/>
                                                                <input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" />
                                                            </th>
                                                            <th>Country Name</td>
                                                                <?php echo $objPage->varSortColumn; ?>
                                                            <th>Action</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($objPage->arrRows as $val) {
                                                            ?>


                                                            <tr>
                                                                <td valign="top" class="hidden-480">
                                                                    <input style="width:20px; border:none;" type="checkbox" name="frmID[]" id="frmID[]"  value="<?php echo $val['pkPaypalID']; ?>" onclick="singleSelectClick(this,'singleCheck');" class="singleCheck"/>
                                                                </td>

                                                                <td><?php
                                                if ($val['countryName'] != '') {
                                                    echo $val['countryName'];
                                                } else {
                                                    echo "All";
                                                }
                                                            ?></td>
                                                                <td class="hidden-350"><?php echo $val['EmailId']; ?> </td>
                                                                <td class="hidden-480"><?php echo $objCore->localDateTime($val['EmailDateAdded'], DATE_FORMAT_SITE); ?></td>
                                                                <td>
                                                                    <a class="btn" data-original-title="Edit" rel="tooltip" href="paypal_email_edit_uil.php?paypalid=<?php echo $val['pkPaypalID']; ?>&type=edit"><i class="icon-edit"></i></a>&nbsp;
                                                                    <a class='btn' data-original-title="Delete" rel="tooltip" title="" href="paypal_action.php?frmID=<?php echo $val['pkPaypalID']; ?>&frmChangeAction=Delete" onClick='return fconfirm("Are you sure you want to delete this Paypal account ? ",this.href);'><i class="icon-remove"></i></a>
                                                                </td>
                                                            </tr>
                                                            <?php
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
                                                    <select name="frmChangeAction" onchange="javascript:return setValidAction(this.value, this.form,'Paypal account(s)');" ata-rule-required="true">
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
