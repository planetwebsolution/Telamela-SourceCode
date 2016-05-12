<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_ADMIN_NEWSLETTER_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Newsletter</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>


        <link rel="stylesheet" href="css/colorbox.css" />
<!--        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>-->
        <script src="../colorbox/jquery.colorbox.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" />
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL . "components/cal/calendar.js"; ?>"></script>
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL . "components/cal/lang/calendar-en.js"; ?>"></script>
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL . "components/cal/calendar-setup.js"; ?>"></script>

        <script type="text/javascript">
            function changeStatus(id) {
                var showid = '#newsletter' + id;
                $.post("ajax.php", {action: 'newsletterChangeStatus', id: id},
                function (data) {
                    $(showid).html(data);
                });
            }
            $(window).load(function () {
                $('.table.table-bordered th:eq(1)').css('width', '100px');
            });

        </script>
    </head>
    <body>

        <?php require_once 'inc/header_new.inc.php'; ?>



        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Manage Newsletter</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php
                    if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-newsletters', $_SESSION['sessAdminPerMission'])) {
                        ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                <li><span>Manage Newsletter</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div class="fleft">
                                    <button class="btn btn-inverse" onClick="showSearchBox('search', 'show');">Search  Newsletters</button>
                                    <a href="newsletter_add_uil.php?type=add"><button class="btn btn-inverse">Create Newsletters</button></a>
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
                                        <form id="frmSearch" method="get" action="" style="float:left" class='form-horizontal form-bordered'>

                                            <div style="float:left; width:100%; margin-bottom:5px;">
                                                <div class="row-fluid">
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Title:  </label>
                                                            <div class="controls">
                                                                <input type="text" name="frmTitle" id="frmTitle" value="<?php echo $_GET['frmTitle']; ?>" class="input-large"/>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span5">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Status: </label>
                                                            <div class="controls">
                                                                <select name="frmStatus" class='select2-me input-large nomargin'>
                                                                    <option value="" <?php
                                                                    if ($_GET['frmStatus'] == "") {
                                                                        echo 'Selected';
                                                                    }
                                                                    ?>>Select Type</option>
                                                                    <option value="Pending" <?php
                                                                    if ($_GET['frmStatus'] == "Pending") {
                                                                        echo 'Selected';
                                                                    }
                                                                    ?>>Pending</option>
                                                                    <option value="Active" <?php
                                                                    if ($_GET['frmStatus'] == "Active") {
                                                                        echo 'Selected';
                                                                    }
                                                                    ?>>Active</option>
                                                                    <option value="Delivered" <?php
                                                                    if ($_GET['frmStatus'] == "Delivered") {
                                                                        echo 'Selected';
                                                                    }
                                                                    ?>>Delivered</option>


                                                                </select>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="span3">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Created By: </label>
                                                            <div class="controls">
                                                                <input type="text" name="frmCreatedBy" id="frmCreatedBy" value="<?php echo $_GET['frmCreatedBy']; ?>" class="input-large"/>

                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="row-fluid">
                                                    <div class="form-actions span12  search">
                                                        <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                        <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
                                                        <?php
                                                        if ($_GET['frmSearch'] != '') {
                                                            ?>
                                                            <input type="button" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" onClick="location.href = 'newsletter_manage_uil.php'" class="btn" />
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <input type="button" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" onClick="showSearchBox('search', 'hide');" class="btn" />
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
                                    <h3>Newsletters List</h3>
                                </div>
                                <div class="box-content nopadding manage_categories">
                                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                        <?php
                                        if ($objPage->NumberofRows > 0) {
                                            ?>
                                            <form id="frmNewsLetter" name="frmNewsLetter" action="newsletter_action.php" method="post">

                                                <table class="table table-hover table-nomargin table-bordered usertable">
                                                    <thead>
                                                        <tr>
                                                            <th class='with-checkbox hidden-480'>

                                                                <input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" />
                                                            </th>

                                                            <?php
                                                            echo $objPage->varSortColumn;
                                                            ?>
                                                            <th class="hidden-480">Delivery Date</th>
                                                            <th class="hidden-480">Status</th>
                                                            <th>Action</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;

                                                        foreach ($objPage->arrRows as $val) {
                                                            ?>


                                                            <tr>
                                                                <td valign="top" class="hidden-480">
                                                                    <input style="width:20px; border:none;" type="checkbox" name="frmID[]" id="frmID[]"  value="<?php echo $val['pkNewsLetterID']; ?>" onClick="singleSelectClick(this, 'singleCheck');" class="singleCheck"/>
                                                                </td>
                                                                <td class="hidden-480">
                                                                    <?php echo $objCore->localDateTime($val['NewsLetterDateAdded'], DATE_FORMAT_SITE); ?>
                                                                    <?php //echo $objCore->localDateTime($val['DeliveryDate'], DATE_FORMAT_SITE); ?>
                                                                </td>
                                                                <td><?php echo ucfirst($val['Title']); ?> </td>
                                                                <td class="hidden-480"><?php echo ($val['CreatedBy'] != 'Admin') ? $val['CompanyName'] : $val['CreatedBy']; //echo $val['CreatedBy']; ?></td>
                                                                <td class="hidden-480"><?php echo $objCore->localDateTime($val['DeliveryDate'], DATE_FORMAT_SITE); ?></td>
                                                                <!-- Commented by Krishna Gupta (08-10-15) -->
                                                                <?php /* ?><td class="hidden-480"><?php echo ($val['Name']);?></td><?php */ ?>
                                                                <td class="hidden-480">
                                                                    <span id="newsletter<?php echo $val['pkNewsLetterID']; ?>">

                                                                        <?php
                                                                        if ($val['DeliveryStatus'] == 'Delivered') {
                                                                            echo "<span class='green'>Delivered</span>";
                                                                        } else {
                                                                            if ($val['DeliveryStatus'] == 'Pending') {
                                                                                echo "<span class='red' style='margin:0px 4px 0px 0px'>Pending</span>";
                                                                            }
                                                                            if ($val['DeliveryStatus'] == 'Active') {
                                                                                echo "<span class='yellow'>Active</span>";
                                                                            } else {
                                                                                ?><a href="javascript:void(0);" class="active" onClick="changeStatus('<?php echo $val['pkNewsLetterID']; ?>')" title="Click here to active this Newsletter.">Active</a><?php
                                                                            }
                                                                        }
                                                                        ?>

                                                                    </span>
                                                                </td>
                                                                <td>

                                                                    <a href="newsletter_view_uil.php?type=view&id=<?php echo $val['pkNewsLetterID']; ?>" class="btn" rel="tooltip" title="" data-original-title="View"><i class="icon-eye-open"></i></a>&nbsp;
                                                                    <a onClick="return fconfirm('Are you sure you want to delete this newsletter !', this.href)" href="newsletter_action.php?frmID=<?php echo $val['pkNewsLetterID']; ?>&frmChangeAction=Delete" class="btn" rel="tooltip" title="" data-original-title="Delete"><i class="icon-remove"></i></a>&nbsp;


                                                                </td>

                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate"><?php
                                                    if ($objPage->varNumberPages > 1) {
                                                        $objPage->displayPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                    }
                                                    ?></div>
                                                <div class="controls hidden-480" style="margin: 10px 5px;">
                                                    <select name="frmChangeAction" onChange="javascript:return setValidAction(this.value, this.form, 'Advertisement(s)');" ata-rule-required="true">
                                                        <option value="">-- Select Action --</option>
                                                        <option value="Delete">Delete</option>
                                                    </select>
                                                    <label for="textfield" class="control-label">This action will be performed on the above selected record(s). </label>
                                                </div>

                                            </form>
                                            <?php
                                        } else {
                                            ?>
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

                    <?php
                } else {
                    ?>
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
<?php
if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') {
    ?>
                showSearchBox('search', 'show');
    <?php
} else {
    ?>
                showSearchBox('search', 'hide');
<?php } ?>
        </script>

    </body>
</html>