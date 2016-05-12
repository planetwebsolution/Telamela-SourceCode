<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_COUNTRY_PORTAL_COMMISSION_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Country portal Commissions</title>
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


        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>

        <link type="text/css" rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
        <script>
            $(document).ready(function(){
                $('#frmpaymentDate').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<span style="margin-left:5px;">&nbsp;</span><img id="imgDate" src="../common/images/calendar.gif" alt="Popup" class="trigger">'});
                $('#frmpaymentDate1').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img id="imgDate" src="../common/images/calendar.gif" alt="Popup" class="trigger">'});
                $('#frmInvoiceDateAddedFrom').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" class="trigger">'});
                $('#frmInvoiceDateAddedTo').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" class="trigger">'});
            });
            function jscall(amount, userEmail, InvoiceID, userID){
                $('#modal-1').show();
                $("#frmpaymentAmount").val(amount);
                $('#frmConfirmPayment').click(function(){
                    var paymentMode = document.getElementById('frmpaymentMode');
                    var paymentAmount = document.getElementById('frmpaymentAmount');
                    var paymentDate = document.getElementById('frmpaymentDate');
                    var paymentComment = document.getElementById('frmpaymentComment');

                    if(paymentMode.value==''){
                        alert('Payment mode is required!');
                        paymentMode.focus();
                        return false;
                    }else if(paymentAmount.value==''){
                        alert('Payment amount is required!');
                        paymentAmount.focus();
                        return false;
                    }else if(paymentAmount.value<=0){
                        alert('please provide valid amount!');
                        paymentAmount.focus();
                        return false;
                    }
                    else if(parseFloat(paymentAmount.value) > parseFloat(amount)){
                        alert('Sorry, you can not pay more than the due payment!');
                        paymentAmount.focus();
                        return false;
                    }
                    else if(paymentDate.value=='00-00-0000' || paymentDate.value==''){
                        alert('Payment date is required!');
                        paymentDate.focus();
                        return false;
                    }else{
                        $('#listed_payment').html('<span class="green">Sending.....</span>');
                        $.post("ajax.php",{
                            action:'MakeCountryPortalPayment',paymentMode:paymentMode.value,paymentAmount:paymentAmount.value,paymentDate:paymentDate.value,
                            paymentComment:paymentComment.value,userEmail:userEmail,InvoiceID:InvoiceID,userID:userID
                        },
                        function(data)
                        {
                            //$('#listed_payment').html(data);
                            $('#listed_payment').html('<span class="green">Payment has been added successfully </span>');
                            setTimeout(function a(){$('#modal-1').hide();location.reload();}, 1500);
                        }
                    );
                    }
                });
            }
            function dateCompare()
            {
                return true;
            }
            function popupClose1(){

                $('#modal-1').hide();
                return false;

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
                            <h1>Manage Country portal Commissions</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php
                    if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-categories', $_SESSION['sessAdminPerMission']))
                    {
                        ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                <li><span>Manage Country portal Commissions</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div class="fleft">
                                    <button class="btn btn-inverse" onclick="showSearchBox('search','show');">Search Country Portal </button>
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
                                        <form id="frmSearch" method="get" action="" class="form-horizontal form-bordered" onsubmit="return dateCompare('frmSearch');">
                                            <div class="row-fluid">
                                                <div class="row-fluid search_margin">
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Invoice Ref.No:  </label>
                                                            <div class="controls">
                                                                <input type ="text" id="frmpkInvoiceID" name="frmpkInvoiceID" value="<?php echo stripslashes($_GET['frmpkInvoiceID']); ?>" class="input-large" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Invoice Date:  </label>
                                                            <div class="controls">
                                                                From :&nbsp;<input type ="text" class="input-medium datepicks" placeholder="Select Date" name="frmInvoiceDateAddedFrom" value="<?php echo stripslashes($_GET['frmInvoiceDateAddedFrom']); ?>" style="width:100px;" /><br>
                                                                To :&nbsp;<input type ="text" class="input-medium datepicks" placeholder="Select Date" name="frmInvoiceDateAddedTo" value="<?php echo stripslashes($_GET['frmInvoiceDateAddedTo']); ?>" style="width:100px; margin-left: 17px; margin-top: 5px;" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Country Office:  </label>
                                                            <div class="controls">
                                                                <input type ="text" id="frmCompanyName" name="frmCompanyName" value="<?php echo stripslashes($_GET['frmCompanyName']); ?>" class="input-large" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">

                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Percentage: </label>
                                                            <div class="controls">
                                                                <input type ="text" id="frmCommission" name="frmCommission" value="<?php echo stripslashes($_GET['frmCommission']); ?>" class="input-large" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4 ">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Status: </label>
                                                            <div class="controls">
                                                                <select name="frmTransactionStatus" class='select2-me input-large'>
                                                                    <option value="" <?php
                        if ($_GET['frmTransactionStatus'] == 'All')
                        {
                            echo 'Selected';
                        }
                        ?>>All</option>
                                                                    <option value="Completed" <?php
                        if ($_GET['frmTransactionStatus'] == 'Completed')
                        {
                            echo 'Selected';
                        }
                        ?>>Completed</option>
                                                                    <option value="Pending" <?php
                        if ($_GET['frmTransactionStatus'] == 'Pending')
                        {
                            echo 'Selected';
                        }
                        ?>>Pending</option>
                                                                    <option value="<?php echo TRANSACTION_DAYS_ALERT; ?> Days Pending" <?php
                                                                if ($_GET['frmTransactionStatus'] == TRANSACTION_DAYS_ALERT . ' Days Pending')
                                                                {
                                                                    echo 'Selected';
                                                                }
                                                                ?>><?php echo TRANSACTION_DAYS_ALERT; ?> Days Pending</option>
                                                                </select>
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
                                                            <input type="button" onclick="location.href = 'country_portal_commission_manage_uil.php'" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />
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
                                                <form id="frmWholesalerList" name="frmWholesalerList" action="" method="post">
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
        <?php echo $objPage->varSortColumn; ?>
                                                                <th class="hidden-480">Due Payments</th>
                                                                <th class="hidden-480">Actions</th>
                                                                <th>Transaction Status</th>
                                                                <th class="hidden-1024">Commission Percentage</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($objPage->arrRows as $val)
                                                            {
                                                                $date1 = date_create($val['InvoiceDateAdded']);
                                                                $date2 = date_create($objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB));
                                                                $diff = date_diff($date1, $date2);
                                                                $varDays = $diff->format("%r%a");
                                                                ?>

                                                                <tr>
                                                                    <td><?php echo $val['pkInvoiceID']; ?></td>
                                                                    <td class="hidden-480"><?php echo $val['InvoiceDateAdded']; ?></td>
                                                                    <td class="hidden-1024"><?php echo $val['pkAdminID']; ?></td>
                                                                    <td class="hidden-350"><?php echo $val['AdminTitle']; ?></td>
                                                                    <td class="hidden-480"><?php echo $objCore->price_format($val['AmountPayable']); ?></td>
                                                                    <td class="hidden-480"><?php echo $objCore->price_format($val['AmountDue']); ?></td>
                                                                    <td class="hidden-480"><?php
                                                            if ($val['AmountDue'] > 0)
                                                            {
                                                                    ?><a onclick="return jscall('<?php echo $objCore->price_format($val['AmountDue']); ?>','<?php echo $val['AdminEmail']; ?>','<?php echo $val['pkInvoiceID']; ?>','<?php echo $val['FromUserID']; ?>')" href="#modal-1" class="payment cboxElement">Make Payment & Send Remittance advice</a><?php } ?></td>
                                                                    <td>
                                                                        <?php
                                                                        echo $val['TransactionStatus'] . '&nbsp;&nbsp;&nbsp;';
                                                                        if ($varDays > TRANSACTION_DAYS_ALERT && $val['AmountDue'] > 0)
                                                                        {
                                                                            ?>
                                                                            <img src="images/alert.png" title="Please pay now" alt="Please pay now" />
                                                                <?php } ?>
                                                                    </td>
                                                                    <td class="hidden-1024"><?php echo $val['Commission']; ?></td>
                                                                </tr>
            <?php
            $i++;
        }
        ?>
                                                        </tbody>
                                                    </table>
                                                    <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate"><?php
                                                if ($objPage->varNumberPages > 1)
                                                {
                                                    $objPage->displayPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                }
        ?></div>
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
        <div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="popupClose1()">X</button>
                <h3 id="myModalLabel">Make Payment</h3>
            </div>
            <div id='listed_Warning'></div>
            <div class="modal-body" style="padding-left:42px;padding-right:10px; overflow: hidden;">
                <div id='listed_payment'>&nbsp;</div>
                <table id="colorBox_table" style="width:600px;">
                    <tr align="left">
                        <td><span class="req">*</span>Payment Mode:</td><td>
                            <select name="frmpaymentMode" id="frmpaymentMode">
<?php
foreach ($paymentMode as $key => $val)
{
    ?>
                                    <option value="<?php echo $key; ?>" <?php echo ($key == $frmpaymentMode ? 'selected="selected"' : ''); ?>><?php echo $val; ?></option>
<?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr align="left">
                        <td><span class="req">*</span>Payment Amount:</td><td><input type="text" class="input1" id="frmpaymentAmount" name="frmpaymentAmount" value="<?php echo $frmpaymentAmount; ?>" /></td>
                    </tr>
                    <tr align="left">
                        <td><span class="req">*</span>Payment Date:</td>
                        <td>
                            <input type="text" class="input1" id="frmpaymentDate" name="frmpaymentDate" value="<?php echo date(DATE_FORMAT_SITE); ?>" /><div class="inpt"></div>
                        </td>
                    </tr>
                    <tr align="left">
                        <td valign="top" style="padding-left:9px;">Comment:</td><td><textarea name="frmpaymentComment" id="frmpaymentComment" rows="8" class="input4"><?php echo $frmpaymentComment; ?></textarea></td>
                    </tr>
                    <tr align="left">
                        <td><br /><br /></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <!--				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                   <button class="btn btn-primary" data-dismiss="modal">Save changes</button>-->

                <input type="submit" name="frmConfirmPayment" id="frmConfirmPayment" value="Make Payment" style="cursor: pointer;" class="btn"/>
                &nbsp;&nbsp;<input type="button" class="btn" name="cancel" id="cancelPayment" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" style="cursor: pointer;" onclick="popupClose1()"/>

            </div>

    </body>
</html>
