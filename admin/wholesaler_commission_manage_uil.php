<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_WHOLESALER_COMMISSION_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Wholesaler</title>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <link type="text/css"  rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
        <script type="text/javascript">
            Cal=jQuery.noConflict();
            Cal(document).ready(function(){                
                Cal('#frmpaymentDate').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<span style="margin-left:5px;">&nbsp;</span><img id="imgDate" src="../common/images/calendar.gif" alt="Popup" class="trigger">'});
                Cal('#frmpaymentDate1').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img id="imgDate" src="../common/images/calendar.gif" alt="Popup" class="trigger">'});
                Cal('#frmInvoiceDateAddedFrom').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" class="trigger">'});
                Cal('#frmInvoiceDateAddedTo').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" class="trigger">'});                
            });
        </script>
        
       
        
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <link rel="stylesheet" href="css/colorbox.css" />       
        <script src="../colorbox/jquery.colorbox.js"></script>
        <script>
            $(document).ready(function(){
                $('#cancelPayment').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });
                $('#cancelRemitance').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });
                
            });
            function jscall(amount, wholesalerEmail, InvoiceID, WholesalerID){
                $('#modal-1').show();
                //$(".payment").colorbox({inline:true, width:"680px", height:"500px"});
                $("#frmpaymentAmount").val(amount);

                $('#cancelPayment').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });

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
                            action:'MakeWholesalerPayment',paymentMode:paymentMode.value,paymentAmount:paymentAmount.value,paymentDate:paymentDate.value,
                            paymentComment:paymentComment.value,wholesalerEmail:wholesalerEmail,InvoiceID:InvoiceID,WholesalerID:WholesalerID
                        },
                        function(data)
                        {
                            $('#listed_payment').html('<span class="green">Payment has been added successfully </span>');
                            setTimeout(function a(){parent.jQuery.fn.colorbox.close();location.reload();}, 1500);
                        }
                    );
                    }
                });
            }
            function jscall1(amount, wholesalerEmail, InvoiceID, WholesalerID){

                $(".remittance").colorbox({inline:true, width:"680px", height:"500px"});
                $("#frmpaymentAmount1").val(amount);

                $('#cancelRemittance').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });

                $('#frmConfirmRemittance').click(function(){
                    var paymentMode = document.getElementById('frmpaymentMode1');
                    var paymentAmount = document.getElementById('frmpaymentAmount1');
                    var paymentDate = document.getElementById('frmpaymentDate1');
                    var paymentComment = document.getElementById('frmpaymentComment1');

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
                            action:'SendWholesalerRemitaance',paymentMode:paymentMode.value,paymentAmount:paymentAmount.value,paymentDate:paymentDate.value,
                            paymentComment:paymentComment.value,wholesalerEmail:wholesalerEmail,InvoiceID:InvoiceID,WholesalerID:WholesalerID
                        },
                        function(data)
                        {
                            $('#listed_remittance').html('<span class="green">Remittance has been sent successfully </span>');
                            setTimeout(function a(){parent.jQuery.fn.colorbox.close();location.reload();}, 1500);
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
                            <h1>Wholesaler's commission [Invoice]</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php
                    if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-wholesalers', $_SESSION['sessAdminPerMission']))
                    {
                        ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                <li><span>Wholesaler's commission [Invoice]</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div class="fleft">
                                    <button class="btn btn-inverse" onClick="showSearchBox('search','show');">Search</button>

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
                                        <form id="frmSearch" method="get" action="" onSubmit="return dateCompare('frmSearch');" class="form-horizontal form-bordered">
                                            <div class="row-fluid">
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Invoice Ref.No:  </label>
                                                        <div class="controls">
                                                            <input type ="text" name="frmpkInvoiceID" value="<?php echo stripslashes($_GET['frmpkInvoiceID']); ?>"  class="input-large"/>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Invoice Date: </label>
                                                        <div class="controls">
                                                        <span style="display:inline-block; width:50px;">From :</span><input type="text" name="frmInvoiceDateAddedFrom" id="frmInvoiceDateAddedFrom" value="<?php echo $_GET['frmInvoiceDateAddedFrom']; ?>" readonly class="input-large" />
                                                            <br/><span style="display:inline-block; width:50px;">To :</span><input type="text" name="frmInvoiceDateAddedTo" id="frmInvoiceDateAddedTo" value="<?php echo $_GET['frmInvoiceDateAddedTo']; ?>" readonly class="input-large" style=" margin-top: 5px;"/>
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
                                                                <option value="<?php echo TRANSACTION_DAYS_ALERT; ?>" <?php
                                                                    if ($_GET['frmTransactionStatus'] == TRANSACTION_DAYS_ALERT)
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
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Order Id: </label>
                                                        <div class="controls">
                                                            <input type ="text" name="frmfkOrderID" value="<?php echo stripslashes($_GET['frmfkOrderID']); ?>" class="input-large" />

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span8">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">SubOrder Id: </label>
                                                        <div class="controls">
                                                            <input type ="text" name="frmfkSubOrderID" value="<?php echo stripslashes($_GET['frmfkSubOrderID']); ?>"  class="input-large"/>

                                                        </div>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="row-fluid">
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Wholesaler Name: </label>
                                                        <div class="controls">
                                                            <input type ="text" name="frmCompanyName" value="<?php echo stripslashes($_GET['frmCompanyName']); ?>"  class="input-large"/>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span8">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Commission Percentage: </label>
                                                        <div class="controls">
                                                            <input type ="text" name="frmCommission" value="<?php echo stripslashes($_GET['frmCommission']); ?>" class="input-large"/>
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
                                                            <input type="button" onClick="location.href = 'wholesaler_commission_manage_uil.php'" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
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
                                            Wholesaler's commission [Invoice]
                                        </h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php
                                            if ($objPage->NumberofRows > 0)
                                            {
                                                ?>
                                                <form id="frmWholesalerList" name="frmWholesalerList" action="wholesaler_action.php" method="post">
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
                                                                <?php echo $objPage->varSortColumn; ?>
                                                                <th class='hidden-480'>Due Payments</th>
                                                                <th class='hidden-480'>Action</th>
                                                                <th class='hidden-480'>Transaction Status</th>
                                                                <th class='hidden-1024'>Commission Percentage</th>
                                                                <th>Invoice</th>
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
                                                                    <td class="hidden-1024"><?php echo $objCore->localDateTime($val['InvoiceDateAdded'], DATE_TIME_FORMAT_SITE); ?></td>
                                                                    <td class="hidden-1024"><?php echo $val['fkOrderID']; ?></td>
                                                                    <td class="hidden-480"><?php echo $val['fkSubOrderID']; ?></td>
                                                                    <td class="hidden-1024"><?php echo $val['fkWholesalerID']; ?></td>
                                                                    <td><?php echo $val['CompanyName']; ?></td>
                                                                    <td class="hidden-480"><?php echo $objCore->price_format($val['AmountPayable']); ?></td>
                                                                    <td class="hidden-480"><?php echo $objCore->price_format($val['AmountDue']); ?></td>
                                                                    <td class="hidden-480"><?php
                                                    if ($val['AmountDue'] > 0)
                                                    {
                                                                    ?><a onClick="return jscall('<?php echo $objCore->price_format($val['AmountDue']); ?>','<?php echo $val['CompanyEmail']; ?>','<?php echo $val['pkInvoiceID']; ?>','<?php echo $val['fkWholesalerID']; ?>')" href="#listed_payment" class="payment cboxElement">Make Payment & Send Remittance advice</a><?php } ?></td>
                                                                    <td class="hidden-480"><?php
                                                            echo $val['TransactionStatus'] . '&nbsp;&nbsp;&nbsp;';
                                                            if ($varDays > TRANSACTION_DAYS_ALERT && $val['AmountDue'] > 0)
                                                            {
                                                                    ?>
                                                                            <img src="images/alert.png" title="Please pay now" alt="Please pay now" />
                                                                        <?php } ?></td>

                                                                    <td class="hidden-1024"><?php echo $val['Commission']; ?></td>
                                                                   <td>
    <?php
    // this code is use for check fileexist.html
    $url = INVOICE_URL . 'wholesaler/' . $val['InvoiceFileName'];
    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);

    /* Get the HTML or whatever is linked in $url. */
    $response = curl_exec($handle);

    /* Check for 404 (file not found). */
     $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    
    if ($httpCode == 302) {
        /* Handle 404 here. */
        echo "No Invoice";
    } else {
        ?>
        <a href="<?php echo INVOICE_URL . 'wholesaler/' . $val['InvoiceFileName']; ?>" target="_blank" class='btn' data-original-title="View" rel="tooltip" title=""><i class="icon-eye-open"></i></a>   
        <?php
    }

    curl_close($handle);
    ?>
<td>
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


        <div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="popupClose1()">X</button>
                <h3 id="myModalLabel">Make Payment</h3>
            </div>
            <div id="listed_payment" style="padding-left:42px"></div>
            <div class="modal-body" style="padding-left:42px;padding-right:10px;">

                <div class="rowlbinp">
                    <div class="lbl"><strong>Payment Mode:</strong></div>
                    <select name="frmpaymentMode" id="frmpaymentMode" class="select2-me input-small">
                        <?php
                        foreach ($paymentMode as $key => $val)
                        {
                            ?>
                            <option value="<?php echo $key; ?>" <?php echo ($key == $frmpaymentMode ? 'selected="selected"' : ''); ?>><?php echo $val; ?></option>
                        <?php } ?>
                    </select> <div class="inpt"></div>
                </div>
                <div class="rowlbinp">
                    <div class="lbl"><strong>*Payment Amount:</strong></div>
                    <input type="text" class="input1" id="frmpaymentAmount" name="frmpaymentAmount" due="<?php echo $frmpaymentAmount; ?>" value="<?php echo $frmpaymentAmount; ?>" /> <div class="inpt"></div>
                </div>
                <div class="rowlbinp">
                    <div class="lbl"><strong>*Payment Date:</strong></div>
                    <input type="text" class="input1" id="frmpaymentDate" name="frmpaymentDate" value="<?php echo date(DATE_FORMAT_SITE); ?>" /><div class="inpt"></div>
                </div>
                <div class="rowlbinp">
                    <div class="lbl"><strong>Comment:</strong></div>
                    <textarea name="frmpaymentComment" id="frmpaymentComment" rows="8" class="input4" style="width:400px"><?php echo $frmpaymentComment; ?></textarea> <div class="inpt"></div>
                </div>
            </div>
            <div class="modal-footer">


                <input class="btn btn-primary" type="submit" name="frmConfirmPayment" id="frmConfirmPayment" value="Make Payment" style="cursor: pointer;"/>
                &nbsp;&nbsp;<input class="btn" type="submit" name="cancel" id="cancelPayment" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" style="cursor: pointer;" onClick="popupClose1()"/>
            </div>
        </div>

    </body>
</html>
