<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_COUNTRY_PORTAL_TRANSACTION_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Country portal Transactions </title>        
        <?php require_once 'inc/common_css_js.inc.php'; ?>

        <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>colorbox.css" />   
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . 'common/css/jquery.autocomplete.css'; ?>" />         
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" media="all" />
        <script type='text/javascript' src="<?php echo SITE_ROOT_URL; ?>colorbox/jquery.colorbox.js"></script>	
        <script type='text/javascript' src='<?php echo SITE_ROOT_URL . "common/js/jquery.autocomplete.js"; ?>'></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
        <style>
            /*.datepick-trigger{margin:-9px 0 -3px -34px;}*/

        </style>
        <script type="text/javascript">
            $(function() {
                $('.datepicks').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" class="trigger">'});
                
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
                            <h1>Country portal Transactions </h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php
                    if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-country-office-transactions', $_SESSION['sessAdminPerMission']))
                    {
                        ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                <li><span>Country portal Transactions</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div class="fleft">
                                    <button class="btn btn-inverse" onclick="showSearchBox('search','show');">Search Country portal Transactions  </button>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid" id="search">
                            <div class="span12">
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>Advanced Search  </h3>
                                    </div>
                                    <div class="box-content nopadding">
                                        <form id="frmSearch" method="get" action="" class="form-horizontal form-bordered" onsubmit="return dateCompare('frmSearch');">
                                            <div class="row-fluid">
                                                <div class="row-fluid search_margin" >
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Invoice ID:  </label>
                                                            <div class="controls">
                                                                <input type ="text" id="frmOrderId" name="frmOrderId" value="<?php echo stripslashes($_GET['frmOrderId']); ?>" class="input-large" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Payment Mode:  </label>
                                                            <div class="controls">
                                                                <select name="frmpaymentMode" id="frmpaymentMode" class='select2-me input-large'>
                                                                    <option value="">Select</option>
                                                                    <?php
                                                                    foreach ($paymentMode as $key => $val)
                                                                    {
                                                                        ?>
                                                                        <option value="<?php echo $key; ?>" <?php echo ($key == $_GET['frmpaymentMode'] ? 'selected="selected"' : ''); ?>><?php echo $val; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Transaction ID:  </label>
                                                            <div class="controls">
                                                                <input type ="text" id="frmTransactionId" name="frmTransactionId" value="<?php echo stripslashes($_GET['frmTransactionId']); ?>" class="input-large" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Payment date:  </label>
                                                            <div class="controls">
                                                                From &nbsp;<input type ="text" class="input-medium datepicks" placeholder="" name="frmDateFrom" value="<?php echo stripslashes($_GET['frmDateFrom']); ?>" style="width:105px; " />
                                                                <span style="margin-left: 15px;">To</span>&nbsp;<input type ="text" class="input-medium datepicks" placeholder="" name="frmDateTo" value="<?php echo stripslashes($_GET['frmDateTo']); ?>" style="width:105px; " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="form-actions span12  search">
                                                        <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                        <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
                                                        <?php
                                                        if ($_GET['frmSearch'] != '')
                                                        {
                                                            ?>
                                                            <input type="button" onclick="location.href = 'country_portal_transaction_manage_uil.php'" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <input type="button" onclick="showSearchBox('search','hide');" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />
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
                                if ($objCore->displaySessMsg() <> '')
                                {
                                    echo $objCore->displaySessMsg();
                                    $objCore->setSuccessMsg('');
                                    $objCore->setErrorMsg('');
                                }
                                ?>
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>
                                            Manage Country Portal
                                        </h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php
                                            if ($objPage->NumberofRows > 0)
                                            {
                                                ?>
                                                <form id="frmCountryPortalList" name="frmCountryPortalList" action="country_portal_transaction_action.php" method="post">
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
                                                                <th class='with-checkbox hidden-480'><input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" /></th>
                                                                <?php echo $objPage->varSortColumn; ?>
                                                                <th class="hidden-480">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($objPage->arrRows as $val)
                                                            {
                                                                ?>

                                                                <tr>
                                                                    <td valign="top" class="hidden-480">
                                                                        <input style="width:20px; border:none;" type="checkbox" class="singleCheck" name="frmID[]" id="frmID[]"  value="<?php echo $val['pkAdminPaymentID']; ?>" onclick="singleSelectClick(this,'singleCheck');"/>
                                                                    </td>
                                                                    <td class="hidden-480"><?php echo $val['fkInvoiceID']; ?></td>
                                                                    <td class="hidden-480" ><?php echo $val['pkAdminPaymentID']; ?></td>
                                                                    <td><?php echo $val['AdminUserName']; ?></td>
                                                                    <td class="hidden-480"><?php echo $val['PaymentMode']; ?></td>
                                                                    <td><?php echo $objCore->price_format($val['PaymentAmount']); ?></td>
                                                                    <td class="hidden-480"><?php echo $val['Comment']; ?></td>
                                                                    <td class="hidden-1024"><?php echo $objCore->localDateTime($val['PaymentDate'], DATE_FORMAT_SITE); ?></td>
                                                                    <td class="hidden-480">
                                                                        <a class='btn' data-original-title="Delete" rel="tooltip" title="" href="country_portal_transaction_action.php?frmID=<?php echo $val['pkAdminPaymentID']; ?>&frmChangeAction=Delete" onClick='return fconfirm("Are you sure you want to delete this transaction ?",this.href);'><i class="icon-remove"></i></a>
                                                                    </td>

                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>


                                                    <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
                                                        <?php
                                                        if ($objPage->varNumberPages > 1)
                                                        {
                                                            $objPage->displayPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                        }
                                                        ?></div>

                                                    <div class="controls hidden-480" style="margin: 1%;">
                                                        <select name="frmChangeAction" onchange="javascript:return setValidAction(this.value, this.form,'Country portal Transaction(s)');" ata-rule-required="true">
                                                            <option value="">-- Select Action --</option>
                                                            <option value="Delete All">Delete</option>
                                                        </select>
                                                        <label for="textfield" class="control-label">This action will be performed on the above selected record(s). </label>
                                                    </div>



                                                </form>
                                                <?php
                                            }
                                            else
                                            {
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
                }
                else
                {
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
if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes')
{
    ?>
            showSearchBox('search', 'show');
    <?php
}
else
{
    ?>
            showSearchBox('search', 'hide');
<?php } ?>
        </script>
    </body>
</html>
