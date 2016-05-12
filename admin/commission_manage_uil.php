<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_COMMISSION_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Discount Coupons</title>
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
            jCal = jQuery.noConflict();
            jCal(function () {
                jCal('.datepicks').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" class="trigger">'});

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
                            <h1>Manage Commission</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php
//                    if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-invoices', $_SESSION['sessAdminPerMission'])) {
                    if ($_SESSION['sessUserType'] == 'super-admin' || $_SESSION['sessUserType'] == 'user-admin') {
                        ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                <li><span>Manage Commission</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
<!--                                <div class="fleft">
                                    <button class="btn btn-inverse" onClick="showSearchBox('search', 'show');">Search Commission </button>
                                </div>-->
<!--                                <div class="fright">
                                    <div class="export fleft">
                                        <form action="" method="post">
                                            <div>
                                                <label class="control-label" for="textfield">Export to: </label>
                                            </div>
                                            <div>
                                                <select name="fileType">
                                                    <option value="csv">CSV</option>
                                                    <option value="excel">Excel</option>
                                                </select>
                                            </div>
                                            <div>
                                                <input type="submit" class="btn btn-primary" name="Export" value="Export" />
                                            </div>
                                        </form>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                        <div class="row-fluid" id="search">
                            <div class="span12">
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>Advanced Search  </h3>
                                    </div>
                                    <div class="box-content nopadding">
                                        <form id="frmSearch" method="get" action="" class="form-horizontal form-bordered" onSubmit="return dateCompare('frmSearch');">
                                            <div class="row-fluid">
                                                <div class="row-fluid" style="margin-bottom:5px;">
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
                                                                <input type ="text" class="input-medium datepicks" placeholder="" name="iDateFrom" value="<?php echo stripslashes($_GET['iDateFrom']); ?>" />
                                                                &nbsp;&nbsp;&nbsp;
                                                                To&nbsp;<input type ="text" class="input-medium datepicks" placeholder="" name="iDateTo" value="<?php echo stripslashes($_GET['iDateTo']); ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Customer Name:  </label>
                                                            <div class="controls">
                                                                <input type ="text" id="cName" name="cName" value="<?php echo stripslashes($_GET['cName']); ?>" class="input-large" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Order ID:  </label>
                                                            <div class="controls">
                                                                <input type ="text" id="orderId" name="orderId" value="<?php echo stripslashes($_GET['orderId']); ?>" class="input-large" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Order Date:  </label>
                                                            <div class="controls">
                                                                <input type ="text" class="input-small datepicks" placeholder="" name="oDateFrom" value="<?php echo stripslashes($_GET['oDateFrom']); ?>" />
                                                                &nbsp;&nbsp;&nbsp;
                                                                To&nbsp;<input type ="text" class="input-small datepicks" placeholder="" name="oDateTo" value="<?php echo stripslashes($_GET['oDateTo']); ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
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
                                                        <a  <?php
                                                        if (isset($_REQUEST['frmSearch'])) {
                                                            ?> href="invoice_manage_uil.php" <?php
                                                            } else {
                                                                ?> onClick="showSearchBox('search', 'hide');" <?php } ?> class="btn"><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></a>
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
                                <div class="box box-color box-bordered">
                                    <?php
                                    if ($objCore->displaySessMsg() <> '') {
                                        echo $objCore->displaySessMsg();
                                        $objCore->setSuccessMsg('');
                                        $objCore->setErrorMsg('');
                                    }
                                    ?>
                                    <div class="box-title">
                                        <h3>
                                            Commission
                                        </h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php
                                            if ($objPage->NumberofRows > 0) {
                                                ?>
                                                <form id="frmProcess" name="frmProcess" action="invoice_action.php" method="post">
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
                                                                <th class='with-checkbox hidden-480'>
                                                                    <input type="hidden" name="frmProcess" id="frmProcess" value="ManipulateInvoice"  />
                                                                    <input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" /></th>
                                                                <th class='hidden-480'>Order Date</th>
                                                                <th class='hidden-1024'>Order ID</th>
                                                                <th class='hidden-480'>Sub Order ID</th>
                                                                
                                                                <th class='hidden-480'>Item Name</th>
                                                                <th class='hidden-480'>Country Portal Name</th>
                                                                <th class='hidden-480'>Price</th>
                                                                <th class='hidden-480'>Quantity</th>
                                                                <th class='hidden-480'>Commission</th>
                                                                <!--<th>Action</th>-->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            //pre($objPage->arrRows);die;
                                                            foreach ($objPage->arrRows as $val) {
                                                                //pre($val);die;
                                                                ?>

                                                                <tr>
                                                                    <td class='with-checkbox hidden-480'><input style="width:20px; border:none;" type="checkbox" name="frmID[]" id="frmID[]"  value="<?php echo $val['pkInvoiceID']; ?>" onClick="singleSelectClick(this, 'singleCheck');" class="singleCheck"/></td>
                                                                    <td class='hidden-480'><?php echo $objCore->localDateTime($val['OrderDateAdded'], DATE_FORMAT_SITE); ?> </td>
                                                                    <td class='hidden-1024'><?php echo $val['fkOrderID']; ?> </td>
                                                                    <td class='hidden-480'><?php echo $val['fkSubOrderID']; ?> </td>
                                                                    
                                                                    <td class='hidden-480'><?php echo $val['ItemName']; ?> </td>
                                                                    <td class='hidden-480'><?php echo $val['AdminTitle']; ?> </td>
                                                                    <td class='hidden-480'><?php echo $val['ItemPrice']; ?> </td>
                                                                    <td class='hidden-480'><?php echo $val['Quantity']; ?> </td>
                                                                    <td class='hidden-480'><?php echo $val['AdminMarginProduct'] + $val['AdminCommissionProduct']; ?> </td>
<!--                                                                    <td>
                                                                        <?php
//                                                                        $filename = INVOICE_URL . 'customer/' . $val['InvoiceFileName'];
//                                                                       // $filename = 'customer/' . $val['InvoiceFileName'];
//                                                                       // echo $filename; 
//                                                                       
//                                                                         $file_headers = @get_headers($filename);
//                                                                        // print_r($file_headers);
//                                                                        (string) $file_headers[3];
//                                                                        
//                                                                        if(substr($file_headers[3], -7) == '404.php') {
//                                                                        	$exists = false;
//                                                                        }
//                                                                        else {
//                                                                        	$exists = true;
//                                                                        }
//
//                                                                        if ($exists) {
//                                                                            ?>
                                                                            <a class="btn" href="////<?php //echo INVOICE_URL . 'customer/' . $val['InvoiceFileName']; ?>" rel="tooltip" title="" data-original-title="View" target="_blank"><i class="icon-eye-open"></i></a>
                                                                            //<?php
//                                                                        } else {
//                                                                            //echo $val['TransactionStatus'].'&nbsp&nbsp';
//                                                                            echo 'No Invoice';
//                                                                            
//                                                                        }
                                                                        ?>
                                                                        <?php // if ($val['InvoiceFileName']) { ?>
                                                                                                                                                                                          <a class="btn" href="//<?php //echo INVOICE_URL . 'customer/' . $val['InvoiceFileName']; ?>" rel="tooltip" title="" data-original-title="View" target="_blank"><i class="icon-eye-open"></i></a>
                                                                        <?php // }  ?>
                                                                        <a class='btn' data-original-title="Delete" rel="tooltip" title="" href="commission_action.php?frmID=<?php //echo $val['pkInvoiceID']; ?>&frmProcess=ManipulateInvoice&frmChangeAction=Delete&deleteType=sD" onClick='return fconfirm("Are you sure you want to delete this discount invoice?", this.href);'><i class="icon-remove"></i></a>

                                                                    </td>-->
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
   <!--                                                 <div class="controls hidden-480" style="margin: 1%;">
                                                         <select name="frmChangeAction" onChange="javascript: return setValidAction(this.value, this.form, ' invoice(s)');" ata-rule-required="true"> -->
<!--                                                             <option value="">-- Select Action --</option> -->
<!--                                                             <option value="Delete All">Delete</option> -->
<!--                                                         </select> -->
<!--                                                         <label for="textfield" class="control-label">This action will be performed on the above selected record(s). </label> -->
<!--                                                     </div> -->

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
