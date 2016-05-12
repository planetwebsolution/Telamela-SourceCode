<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_COUNTRY_PORTAL_INVOICE_CTRL;
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_session_redirect_bll.php';
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Country Portal Invoice</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>

        <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>colorbox.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . 'common/css/jquery.autocomplete.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" media="all" />
        <script type='text/javascript' src="<?php echo SITE_ROOT_URL; ?>colorbox/jquery.colorbox.js"></script>
        <script type='text/javascript' src='<?php echo SITE_ROOT_URL . "common/js/jquery.autocomplete.js"; ?>'></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
        <script type="text/javascript">
            $(function() {
                $('.datepicks').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" class="trigger">'});

            });
        </script>
        <script type="text/javascript">
            function changeOrderStatus(status,oid){
                var showid = '#product'+oid;
                $.post("ajax.php",{action:'changeOrderStatus',status:status,oid:oid},
                function(data){
                    //$(showid).html(data);
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
                            <h1>Country Portal Invoice</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-country-office-invoice', $_SESSION['sessAdminPerMission'])) { ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                <li><span>Country Portal Invoice</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div class="fleft">
                                    <button class="btn btn-inverse" onClick="showSearchBox('search','show');">Search Country Portal Invoice </button>
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
                                                <div class="row-fluid search_margin" >
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Invoice ID:  </label>
                                                            <div class="controls">
                                                                <input type ="text" id="invoiceID" name="invoiceID" value="<?php echo stripslashes($_GET['invoiceID']); ?>" class="input-large" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Invoice Date:  </label>
                                                            <div class="controls">
                                                                <input type ="text" class="input-medium datepicks" placeholder="Select Date" name="iDateFrom" value="<?php echo stripslashes($_GET['iDateFrom']); ?>" style="width:105px; " />
                                                                <span style="margin-left: 15px"> To</span> &nbsp;<input type ="text" class="input-medium datepicks" placeholder="Select Date" name="iDateTo" value="<?php echo stripslashes($_GET['iDateTo']); ?>" style="width:105px; " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Country Office Name:  </label>
                                                            <div class="controls">
                                                                <input type ="text" id="cName" name="cName" value="<?php echo stripslashes($_GET['cName']); ?>" class="input-large" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Amount:  </label>
                                                            <div class="controls">
                                                                <input type ="text" id="amount" name="amount" value="<?php echo stripslashes($_GET['amount']); ?>" class="input-large" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="form-actions span12  search">
                                                        <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                        <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
                                                        <?php if ($_GET['frmSearch'] != '') { ?>
                                                            <input type="button" onClick="location.href = 'country_portal_invoice_manage_uil.php'" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />
                                                        <?php } else { ?>
                                                            <input type="button" onClick="showSearchBox('search','hide');" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />
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
                                ?>
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>
                                            Manage Country Portal Invoice
                                        </h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php if ($objPage->NumberofRows > 0) { ?>
                                                <form id="frmCountryPortalList" name="frmCountryPortalList" action="" method="post">
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
                                                                <th>Invoice ID</th>
                                                                <th class='hidden-480'>Invoice Date</th>
                                                                <th class='hidden-480'>Month Year</th>
                                                                <th>Country Office Name</th>
                                                                <th class='hidden-480'>Amount</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($objPage->arrRows as $val) {
                                                                ?>

                                                                <tr>
                                                                    <td><?php echo $val['pkInvoiceID']; ?></td>
                                                                    <td class="hidden-480"><?php echo $objCore->localDateTime($val['InvoiceDateAdded'], DATE_FORMAT_SITE); ?></td>
                                                                    <td class="hidden-480"><?php echo $objCore->localDateTime($val['OrderDateAdded'], DATE_FORMAT_MONTH_YEAR_SITE); ?></td>
                                                                    <td><?php echo $val['AdminTitle']; ?> </td>
                                                                    <td class="hidden-480"><?php echo ADMIN_CURRENCY_SYMBOL . $objCore->price_format($val['Amount']); ?></td>
                                                                    <td>
                                                                        <a class='btn' data-original-title="View" rel="tooltip" title=""  href="<?php echo INVOICE_URL . 'country_portal/' . $val['InvoiceFileName']; ?>" target="_blank"><i class="icon-eye-open"></i></a>
                                                                        <a class='btn' data-original-title="Delete" rel="tooltip" title="" href="country_portal_invoice_manage_uil.php?type=delete&iid=<?php echo $val['pkInvoiceID']; ?>" onClick='return fconfirm("Would you really like to delete ?",this.href);'><i class="icon-remove"></i></a>
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
