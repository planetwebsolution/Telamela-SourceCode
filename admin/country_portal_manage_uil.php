<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_COUNTRY_PORTAL_CTRL;
//pre($objPage->arrPeriod);
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Country Portal</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>

        <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>colorbox.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . 'common/css/jquery.autocomplete.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" media="all" />
        <script type='text/javascript' src="<?php echo SITE_ROOT_URL; ?>colorbox/jquery.colorbox.js"></script>
        <script type='text/javascript' src='<?php echo SITE_ROOT_URL . "common/js/jquery.autocomplete.js"; ?>'></script>
        <script type="text/javascript">
            function changeStatus(status, emailid, id) {
                var showid = '#countryPortal' + id;

                $.post("ajax.php", {action: 'CountryPortalChangeStatus', status: status, emailid: emailid, id: id},
                function (data) {
                    $(showid).html(data);
                });
            }

            function jscallSendWarningPopup(emailid, id) {
                $(".warning").colorbox({inline: true, width: "500px", height: "290px"});

                $('#cancelWarn').click(function () {
                    parent.jQuery.fn.colorbox.close();
                });

                $('#frmConfirmWarning').click(function () {

                    var WarningMsg = $('#WarningMsg').val();

                    if (WarningMsg == '') {
                        alert('Message is Required!');
                        $('#WarningMsg').focus();
                        return false;
                    } else {
                        $('#listed_Warning').html('<span class="green">Sending.....</span>');
                        $.post("ajax.php", {action: 'SendWarningToCountryPortal', msg: WarningMsg, emailid: emailid, id: id},
                        function (data) {
                            $('#listed_Warning').html('<span class="green">Warning Sent Successfully </span>');
                            //$('#listed_Warning').html(data);
                            setTimeout(function a() {
                                parent.jQuery.fn.colorbox.close();
                                location.reload();
                            }, 1500);
                        }
                        );
                    }
                });
            }
        </script>
    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>
        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Manage Country Portal</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-country-office', $_SESSION['sessAdminPerMission'])) {
                        ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                <li><span>Manage Country Portal</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div class="fleft">
                                    <button class="btn btn-inverse" onClick="showSearchBox('search', 'show');">Search Country Portal </button>
                                    <?php if ($_SESSION['sessUserType'] == 'super-admin') {
                                        ?>
                                        <a href="user_add_uil.php?type=cp"><button class="btn btn-inverse">Add New Country Portal </button></a>
                                    <?php } ?>
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
                                        <form id="frmSearch" method="get" action="" class="form-horizontal form-bordered" onSubmit="return dateCompare('frmSearch');">
                                            <div class="row-fluid">
                                                <div class="row-fluid">
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Country Office Name:  </label>
                                                            <div class="controls">
                                                                <input type ="text" id="frmName" name="frmName" value="<?php echo stripslashes($_GET['frmName']); ?>" class="input-large" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4 ">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Country: </label>
                                                            <div class="controls">
                                                                <select name="frmCountry" class='select2-me input-large nomargin'>
                                                                    <option value="0" <?php
                                                                    if ($_GET['frmCountry'] == '0') {
                                                                        echo 'Selected';
                                                                    }
                                                                    ?>>All Country</option>
                                                                            <?php foreach ($objPage->arrCountryList as $vCT) {
                                                                                ?>
                                                                        <option value="<?php echo $vCT['country_id']; ?>" <?php
                                                                        if ($_GET['frmCountry'] == $vCT['country_id']) {
                                                                            echo 'Selected';
                                                                        }
                                                                                ?>><?php echo html_entity_decode($vCT['name']); ?>
                                                                        </option>
                                                                            <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Status:  </label>
                                                            <div class="controls">
                                                                <select name="frmStatus" class='select2-me input-large'>
                                                                    <option value="Active" <?php
                                                                        if ($_GET['frmStatus'] == 'Active') {
                                                                            echo 'Selected';
                                                                        }
                                                                            ?>>Active</option>
                                                                    <option value="Inactive" <?php
                                                                    if ($_GET['frmStatus'] == 'Inactive') {
                                                                        echo 'Selected';
                                                                    }
                                                                    ?>>Deactive</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="form-actions span12 search">
                                                        <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                        <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
    <?php if ($_GET['frmSearch'] != '') {
        ?>
                                                            <input type="button" onClick="location.href = 'country_portal_manage_uil.php'" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />
                                                        <?php
                                                        } else {
                                                            ?>
                                                            <input type="button" onClick="showSearchBox('search', 'hide');" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="span12">
    <?php
    if ($objCore->displaySessMsg() <> '') {
        echo $objCore->displaySessMsg();
        $objCore->setSuccessMsg('');
        $objCore->setErrorMsg('');
    }
    //pre($objPage);
    ?>
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>
                                            Manage Country Portal
                                        </h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
    <?php if ($objPage->NumberofRows > 0) {
        ?>
                                                <form id="frmCountryPortalList" name="frmCountryPortalList" action="" method="post">
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
                                                                <th>Period</th>
        <?php echo $objPage->varSortColumn; ?>
                                                                <th class='hidden-480' title="Revenue KPI % = [(total sale done by wholesalers under this country portal)/Total Sales target] x 100">Revenue KPI(%)</th>
                                                                <th class='hidden-480'title="This is the average of wholesaler's KPIs">Performance KPI(%)</th>
                                                                <th class='hidden-1024'>No. of Sold Products</th>
                                                                <th class='hidden-1024'>Total Sales( <?php echo ADMIN_CURRENCY_SYMBOL; ?>)</th>
                                                                <th class='hidden-480'>Total Commission ( <?php echo ADMIN_CURRENCY_SYMBOL; ?>)</th>
                                                                <th>Wholesalers</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
        <?php
        $i = 1;
        foreach ($objPage->arrRows as $val) {
            ?>
                                                                <tr>
                                                                    <td style="text-align: center;"><?php echo $objCore->localDateTime($val['SalesTargetStartDate'], DATE_FORMAT_SITE) . ' To ' . $objCore->localDateTime($val['SalesTargetEndDate'], DATE_FORMAT_SITE); ?></td>
                                                                    <td><?php echo $val['pkAdminID']; ?></td>
                                                                    <td class="hidden-480"><a href="user_add_uil.php?UserID=<?php echo $val['pkAdminID']; ?>&type=portal"><?php echo $val['AdminTitle']; ?></a></td>
                                                                    <td class="hidden-480"><?php echo number_format($val['RevenueKpi'], 2); ?></td>
                                                                    <td class="hidden-480"><?php echo number_format($val['PerformanceKpi'], 2); ?></td>
                                                                    <td class="hidden-1024"><?php echo $val['NoOfSoldItems']; ?></td>
                                                                    <td class="hidden-1024"><?php echo number_format($val['TotalSoldAmount'], 2); ?></td>
                                                                    <td class="hidden-480"><?php echo number_format($val['TotalCommission'], 2); ?></td>
                                                                    <td>
                                                                        <a class="btn" href="country_portal_wholesalers_uil.php?cid=<?php echo $val['pkAdminID']; ?>" rel="tooltip" title="" data-original-title="View"><i class="icon-eye-open"></i></a>
                                                                        <a href="country_portal_archive_uil.php?type=archive&cid=<?php echo $val['pkAdminID']; ?>" title="Archive">Archive</a>
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
<?php if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') {
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