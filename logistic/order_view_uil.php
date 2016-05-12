<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_LOGISTIC_PATH . FILENAME_LOGISTICPORTAL_ORDER_CTRL;
//pre($objPage->arrRow);
$arrOrder = $objPage->arrRow['arrOrder'][0];
$gatewaymail = $objPage->arrRow['gatwaymail'];
//pre($gatewaymail);
$arrCountryList = $objPage->arrRow['arrCountryList'];
$arrOrderItem = $objPage->arrRow['arrOrderItems'];
//pre($arrOrderItem);
$arrOrderComment = $objPage->arrRow['arrOrderComments'];
$arrOrderTotal = $objPage->arrRow['arrOrderTotal'];

$arrDisputedCommentsHistory = $objPage->arrRow['arrDisputedCommentsHistory'];
$snipat = $objPage->snipatCareer;
$httpRef = (isset($_REQUEST['httpRef'])) ? $_REQUEST['httpRef'] : $_SERVER['HTTP_REFERER'];
$varNum = count($arrOrder);
$arrDisputedComments = $objCore->getDisputedCommentArray();
//$objPage->shipmentRow
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Orders View</title>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <link type="text/css"  rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
        <script type="text/javascript">
            Cal = jQuery.noConflict();
            Cal(document).ready(function () {
                Cal('.frmDateStart').datepick({dateFormat: 'dd-mm-yyyy', minDate: new Date(), showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" class="trigger">'});
                Cal('.frmDate').datepick({dateFormat: 'dd-mm-yyyy', minDate: new Date(), showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" class="trigger">'});
            });
        </script>
        <?php require_once '../admin/inc/common_css_js.inc.php'; ?>
        <script type="text/javascript">
            function validateShipment(str) {

                var shipId = '#tran' + str;
                if ($(shipId).val() == '') {
                    alert('Transaction Id is required !');
                    $(shipId).focus()
                    return false;
                }
                // if($('.frmDateStart').val()==''){
                //     alert('Start date is required !');
                //     $('.frmDateStart').focus()
                //     return false;
                // }
                // if($('.frmDate').val()==''){
                //     alert('End date is required !');
                //     $('.frmDate').focus()
                //     return false;
                // }

            }
            function validateDisputedFeedback() {

                var feedback = '#frmFeedback';
                if ($(feedback).val() == '') {
                    alert('Post Your Feedback is required !');
                    $(feedback).focus();
                    return false;
                }

            }
            function jscall1(showId) {
                $('#' + showId).show();
            }
            function popupClose1(showId) {
                $('#' + showId).hide();
            }
            $(document).on('click', '#sendtrakingno', function () {
                //alert("hello");
                var Trackingid = $("#trackingno").val();
                var DateStart = $(".frmDateStart").val();
                var Dateend = $(".frmDate").val();
                //var shippingtitle = $("#shippingtitle1").val();
                var customer_name = $("#customer_name").val();
                var customer_email = $("#customer_email").val();
                var ShippingFirstName = $("#ShippingFirstName").val();
                var ShippingLastName = $("#ShippingLastName").val();
                var ShippingAddressLine1 = $("#ShippingAddressLine1").val();
                var ShippingAddressLine2 = $("#ShippingAddressLine2").val();
                var ShippingCountry = $("#ShippingCountry").val();
                var ShippingPostalCode = $("#ShippingPostalCode").val();
                var ShippingPhone = $("#ShippingPhone").val();
                var trackingurlid = $("#trackingurl").val();
                var pkOrderID = $("#pkOrderID").val();

                var startDate = DateStart;
                var endDate = Dateend;
                // alert(startDate+endDate);
                if ((startDate.length == 0) || (endDate.length == 0))
                {
                    alert("Please select date");
                    return false;
                }

                if (startDate > endDate) {

                    alert("End date should be greater than Start date");
                    return false;
                }


                $.post("../admin/ajax.php", {action: 'Sendtrackingnumber', name: customer_name, emailid: customer_email, id: Trackingid, startdate: DateStart, enddate: Dateend, trackingurl: trackingurlid, shfirst: ShippingFirstName, shlast: ShippingLastName, shadd1: ShippingAddressLine1, shadd2: ShippingAddressLine2, scountry: ShippingCountry, spcode: ShippingPostalCode, sphone: ShippingPhone, pkOrderID: pkOrderID},
                        function (data)
                        {
                            //alert(data);
                            $('#listed_Warning').html('<span class="green">Trackingid Sent Sucessfully.</span>');
                            $("input[type=text], textarea").val("");
                            setTimeout(function b() {
                                $('#modal-2').hide();
                              //  location.reload();
                            }, 1500);

                        }
                );
            });
            //sendtrakingno
        </script>

        <script>
            function IsEmail(email) {
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (!regex.test(email)) {
                    return false;
                } else {
                    return true;
                }
            }
        </script>
    </head>
    <body>
        <?php //require_once 'inc/header_new.inc.php'; ?>

        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>View Orders</h1>
                        </div>
                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="order_manage_uil.php">Sales</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="order_manage_uil.php">Orders</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
<!--                                <a href="order_view_uil.php?type=edit&soid=<?php echo $_GET['soid']; ?>">View Order</a>-->
                                <span>View Order</span>
                            </li>
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
                                            echo $objCore->displaySessMsg();
                                            $objCore->setSuccessMsg('');
                                            $objCore->setErrorMsg('');
                                        }
                                        ?>

                                        <div class="box box-color box-bordered">
                                            <div class="box-title">
                                                <a id="buttonDecoration" href="<?php echo $httpRef; ?>" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>

                                                <h3>
                                                    View Orders Details
                                                </h3>
                                            </div>
                                            <div class="box-content nopadding" style="width: 100%; overflow: auto">
                                                <?php //require_once('javascript_disable_message.php'); ?>
                                                <?php
                                                //if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-orders', $_SESSION['sessAdminPerMission'])) {
                                                ?>
                                                <table class="table table-hover table-nomargin table-bordered usertable">
                                                    <?php
                                                    if ($varNum > 0) {
                                                        ?>
                                                        <tbody>
                                                            <tr>
                                                                <td width="50%" valign="top" align="left" style="border:none">
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                        <tr>
                                                                            <td colspan="2" class="detailshead">Order Details </td>
                                                                        </tr>
                                                                        <tr><td colspan="2">&nbsp;</td></tr>
                                                                        <tr>
                                                                            <td>Order ID</td>
                                                                            <td><?php echo $arrOrder['pkOrderID']; ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Order Date</td>
                                                                            <td><?php echo $objCore->localDateTime($arrOrder['OrderDateAdded'], DATE_TIME_FORMAT_SITE); ?>
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>Order Status</td>
                                                                            <td><?php echo $arrOrderItem[0]['Status']; ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Transaction Id</td>
                                                                            <td><?php echo $arrOrderItem[0]['transaction_ID']; ?>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                                <td width="2%" style="border:none;">&nbsp;</td>
                                                                <td width="48%" valign="top" align="left" style="border:none">
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                        <tr>
                                                                            <td colspan="2" class="detailshead">Account Information</td>
                                                                        </tr>
                                                                        <tr><td colspan="2">&nbsp;</td></tr>
                                                                        <tr>
                                                                            <td> Customer Name:</td>
                                                                            <td>
                                                                                <?php echo $arrOrder['CustomerFirstName']; ?> <?php echo $arrOrder['CustomerLastName']; ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td> Email:</td>
                                                                            <td><?php echo $arrOrder['CustomerEmail']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Phone</td>
                                                                            <td><?php echo $arrOrder['CustomerPhone']; ?></td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr><td colspan="3" style="border:none;">&nbsp;</td></tr>
                                                            <tr>
                                                                <td width="48%" valign="top" align="left" style="border:none">
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                        <tr>
                                                                            <td colspan="2" class="detailshead">Billing Information</td>
                                                                        </tr>
                                                                        <tr><td colspan="2">&nbsp;</td></tr>
                                                                        <tr>
                                                                            <td> Recipient First Name:</td>
                                                                            <td><?php echo $arrOrder['BillingFirstName']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td> Recipient Last Name:</td>
                                                                            <td><?php echo $arrOrder['BillingLastName']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Organization Name:</td>
                                                                            <td><?php echo $arrOrder['BillingOrganizationName']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td> Address Line 1:</td>
                                                                            <td> <?php echo $arrOrder['BillingAddressLine1']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Address Line 2</td>
                                                                            <td><?php echo $arrOrder['BillingAddressLine2']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td> Country</td>
                                                                            <td><?php echo $arrOrder['BillingCountryName']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td> Post Code or Zip Code:</td>
                                                                            <td><?php echo $arrOrder['BillingPostalCode']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td> Phone:</td>
                                                                            <td><?php echo $arrOrder['BillingPhone']; ?></td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                                <td width="2%" style="border:none;">&nbsp;</td>
                                                                <td width="48%" valign="top" align="left" style="border:none">
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                        <tr>
                                                                            <td colspan="2" class="detailshead">Shipping Information</td>
                                                                        </tr>
                                                                        <tr><td colspan="2">&nbsp;</td></tr>
                                                                        <tr>
                                                                            <td> Recipient First Name:</td>
                                                                            <td><?php echo $arrOrder['ShippingFirstName']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td> Recipient Last Name:</td>
                                                                            <td><?php echo $arrOrder['ShippingLastName']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Organization Name:</td>
                                                                            <td><?php echo $arrOrder['ShippingOrganizationName']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td> Address Line 1:</td>
                                                                            <td><?php echo $arrOrder['ShippingAddressLine1']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Address Line 2</td>
                                                                            <td><?php echo $arrOrder['ShippingAddressLine2']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td> Country</td>
                                                                            <td><?php echo $arrOrder['ShippingCountryName']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td> Post Code or Zip Code:</td>
                                                                            <td><?php echo $arrOrder['ShippingPostalCode']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td> Phone:</td>
                                                                            <td><?php echo $arrOrder['ShippingPhone']; ?></td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="48%" colspan="3" valign="top" align="left" style="border:none">
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                        <tr>
                                                                            <td class="detailshead">Sub Order Id</td>
                                                                            <td class="detailshead">Items Ordered</td>

                                                                            <td class="detailshead">Qty.</td>

                                                                            <td class="detailshead">Shipping</td>
                                                                            <td class="detailshead">Grand Total</td>
                                                                            <td class="detailshead">Shipment</td>
                                                                        </tr>
                                                                        <?php
                                                                        $varSubTotal = 0;
                                                                        $varShippingSubTotal = 0;
                                                                        $varTotal = 0;
                                                                        //  pre($arrOrderItem);
                                                                        foreach ($arrOrderItem as $item) {
                                                                            $varSubTotal += ($item['ItemSubTotal'] + $item['AttributePrice'] - $item['DiscountPrice']);
                                                                            $varShippingSubTotal += $item['ShippingPrice'];
                                                                            ?>
                                                                            <tr id="tr<?php echo $item['pkOrderItemID']; ?>">
                                                                                <td><?php echo $item['SubOrderID']; ?></td>
                                                                                <td><?php echo '<b>' . $item['ItemName'] . '</b><br/>' . $item['OptionDet']; ?></td>
                                                                                <td><?php echo $item['Quantity']; ?></td>

                                                                                <td><?php echo number_format($item['ShippingPrice'], 2); ?></td>

                                                                                <td><?php echo (number_format($item['ShippingPrice'], 2) * $item['Quantity']); ?></td>
                                                                                <td>
                                                                                    <?php
                                                                                    $showId = 'modal-' . $item['pkOrderItemID'];
                                                                                    $frmId = 'frm-' . $item['pkOrderItemID'];
                                                                                    $tranId = 'tranfrm-' . $item['pkOrderItemID'];
                                                                                    ?>
                                                                                    <?php
                                                                                    if ($item['ItemType'] != 'gift-card') {
                                                                                        ?>
                                                                                        <a class="suspend cboxElement" href="#listed_Suspend" onclick="return jscall1('<?php echo $showId; ?>');"><span><?php ?><?php echo ($item['Shipments']['pkShipmentID'] <> '') ? 'Update' : 'Add'; ?></span></a>

                                                                                    <?php } ?>
                                                                                    <div id="<?php echo $showId; ?>" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;">
                                                                                        <form name="<?php echo $frmId; ?>" id="<?php echo $frmId; ?>" method="post" action="" onsubmit="return validateShipment('<?php echo $frmId; ?>')" >
                                                                                            <div class="modal-header">
                                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="popupClose1('<?php echo $showId; ?>')">X</button>
                                                                                                <h3 id="myModalLabel">Order Status History</h3>
                                                                                            </div>

                                                                                            <div id='listed_Warning'></div>
                                                                                            <div class="modal-body" style="padding-left:42px;padding-right:10px; overflow: hidden;">
                                                                                                <div id='listed_payment'>&nbsp;</div>

                                                                                                <table id="colorBox_table" style="width:600px;">
<!--                                                                                                    <tr>
                                                                                                        <td>Shipping Gateway</td>
                                                                                                        <td>
                                                                                                            <?php echo $item['ShippingTitle']; ?>
                                                                                                        </td>
                                                                                                    </tr>-->
                                                                                                    <tr>
                                                                                                        <td>Transaction Id</td>
                                                                                                        <td>
                                                                                                            <input type="text" name="frmTransactionNo" id="<?php echo $tranId; ?>" value="<?php echo $item['Shipments']['TransactionNo']; ?>" class="input-medium" />
                                                                                                        </td>
                                                                                                    </tr> 

                                                                                                    <tr>
                                                                                                        <td>Tracking Id</td>
                                                                                                        <td>
                                                                                                            <input type="text" name="frmTrackingNo" id="trackingno" value="<?php echo $item['Shipments']['TrackingNo']; ?>" class="input-medium" />
                                                                                                            <input type="hidden" name="shippingtitlename" id="shippingtitle1" value="<?php echo $item['ShippingTitle']; ?>" class="input-medium" />

                                                                                                            <input type="hidden" name="customer_name" id="customer_name"value="<?php echo $arrOrder['CustomerFirstName']; ?> <?php echo $arrOrder['CustomerLastName']; ?>"/>
                                                                                                            <input type="hidden" name="customer_email" id="customer_email" value="<?php echo $arrOrder['CustomerEmail']; ?>"/>
                                                                                                        </td>

                                                                                                    </tr>

                                                                                                    <tr>
                                                                                                        <td> Url For Tracking Id</td>
                                                                                                        <td>

                                                                                                            <textarea rows="" cols="" name="frmTrackingemail" id="trackingurl"></textarea>
                                                                                                            <input type="hidden" name="ShippingFirstName" id="ShippingFirstName" value="<?php echo $arrOrder['ShippingFirstName']; ?>"/>
                                                                                                            <input type="hidden" name="ShippingLastName" id="ShippingLastName" value="<?php echo $arrOrder['ShippingLastName']; ?>"/>
                                                                                                            <input type="hidden" name="ShippingAddressLine1" id="ShippingAddressLine1" value="<?php echo $arrOrder['ShippingAddressLine1']; ?>"/>
                                                                                                            <input type="hidden" name="ShippingAddressLine2" id="ShippingAddressLine2" value="<?php echo $arrOrder['ShippingAddressLine2']; ?>"/>
                                                                                                            <input type="hidden" name="ShippingCountry" id="ShippingCountry" value="<?php
                                                                                                            $countryname = $objGeneral->getCountrynamebyid($data['customer_detail']['ShippingCountry']);
                                                                                                            echo $countryname[0]['name'];
                                                                                                            //pre($item['Shipments']);
                                                                                                            ?>"/>
                                                                                                            <input type="hidden" name="ShippingPostalCode" id="ShippingPostalCode" value="<?php echo $data['customer_detail']['ShippingPostalCode']; ?>"/>
                                                                                                            <input type="hidden" name="ShippingPhone" id="ShippingPhone" value="<?php echo $data['customer_detail']['ShippingPhone']; ?>"/>

                                                                                                    </tr>
                                                                                                    <tr>

                                                                                                    <tr>
                                                                                                        <td>Date</td>
                                                                                                        <td>
                                                                                                            Start &nbsp;<input type="text" name="frmDateFrom" value="<?php echo ($item['Shipments']['ShipStartDate']) ? $objCore->localDateTime($item['Shipments']['ShipStartDate'], DATE_FORMAT_SITE) : ''; ?>" readonly="true" class="frmDateStart input-small" />&nbsp;
                                                                                                            &nbsp;&nbsp;&nbsp;&nbsp;End &nbsp;<input type="text" name="frmDateTo" value="<?php echo ($item['Shipments']['ShippedDate1']) ? $objCore->localDateTime($item['Shipments']['ShippedDate1'], DATE_FORMAT_SITE) : ''; ?>" readonly="true" class="frmDate input-small" />
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>Status</td>
                                                                                                        <td>
                                                                                                            <select name="frmShippingStatus" class="select2-me input-medium">
                                                                                                                <option value="Pending"  <?php
                                                                                                                if ($item['Status'] == 'Pending') {
                                                                                                                    echo 'selected="selected"';
                                                                                                                }
                                                                                                                ?>>Pending</option>
                                                                                                                <option value="Processing" <?php
                                                                                                                if ($item['Status'] == 'Processing') {
                                                                                                                    echo 'selected="selected"';
                                                                                                                }
                                                                                                                ?>>Processing</option>
                                                                                                                <option value="Processed" <?php
                                                                                                                if ($item['Status'] == 'Processed') {
                                                                                                                    echo 'selected="selected"';
                                                                                                                }
                                                                                                                ?>>Processed</option>
                                                                                                                <option value="Shipped" <?php
                                                                                                                if ($item['Status'] == 'Shipped') {
                                                                                                                    echo 'selected="selected"';
                                                                                                                }
                                                                                                                ?>>Shipped</option>

                                                                                                            </select>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </div>
                                                                                            <?php
                                                                                            if ($item['Status'] == 'Shipped')
                                                                                                $btnstatus = 'enable';
                                                                                            else
                                                                                                $btnstatus = 'disabled';
                                                                                            ?>
                                                                                            <div class="modal-footer">
                                                                                                <input type="hidden" name="frmShipmentGatways" value="<?php echo $item['fkShippingIDs']; ?>" />
                                                                                                <input type="hidden" name="frmOrderItemID" value="<?php echo $item['pkOrderItemID']; ?>" />
                                                                                                <input type="hidden" name="frmOrderDateAdded" value="<?php echo $arrOrder['OrderDateAdded'] ?>" />
                                                                                                <input type="hidden" name="frmShipmentID" value="<?php echo $item['Shipments']['pkShipmentID'] ?>" />
                                                                                                <input type="hidden" name="frmShippment" value="Update" />
                                                                                                <input type="hidden" name="suborderid" value="<?php echo $item['SubOrderID'] ?>" />
                                                                                                <input type="hidden" name="gatewaymail" value="<?php echo $gatewaymail ?>" />
                                                                                                <input type="hidden" name="ShippingTitle" value="<?php echo $item['ShippingTitle']; ?>" />
                                                                                                <input type="hidden" name="pkOrderID" id="pkOrderID" value="<?php echo $item['fkOrderID']; ?>"/>

                                                                                                <input <?php echo $btnstatus; ?> type="button" class="btn btn-blue" name="Submitmail" id="sendtrakingno" value="Send Mail"/> &nbsp;&nbsp;

                                                                                                <input type="submit" class="btn btn-blue" name="Submit" value="Submit"/> &nbsp;&nbsp;
                                                                                                <input type="button" onclick="popupClose1('<?php echo $showId; ?>')" style="cursor: pointer;" value="Cancel" id="cancelPayment" name="cancel" class="btn">
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr><td colspan="3" style="border:none;">&nbsp;</td></tr>
                                                            <tr>
                                                                <td width="48%" valign="top" align="left" style="border:none; vertical-align: top;">
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                        <tr>
                                                                            <td colspan="2" class="detailshead">Comments History</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                <?php
                                                                                foreach ($arrOrderComment as $vc) {
                                                                                    echo '<p>' . $vc['Comment'] . '</p><p align="right"><b> - ' . $vc[$vc['CommentedBy'] . 'Name'] . ' (' . ucwords($vc['CommentedBy']) . ') </b></p>';
                                                                                }
                                                                                ?>
                                                                                <br />
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                                <td width="2%" style="border:none;">&nbsp;</td>
                                                                <td width="48%" valign="top" align="left" style="border:none">
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                        <tr>
                                                                            <td colspan="2" class="detailshead">Shipping Totals</td>
                                                                        </tr>
                                                                        <?php
                                                                        $varSubTotal = (number_format($item['ShippingPrice'], 2) * $item['Quantity']);
                                                                        $varShippingSubTotal = number_format($item['ShippingPrice'], 2);
                                                                        ?>

                                                                        <tr>
                                                                            <td><?php echo 'Sub Total'; ?></td>
                                                                            <td><?php echo ADMIN_CURRENCY_SYMBOL . $varSubTotal; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><?php echo 'Shipping Charge'; ?></td>
                                                                            <td><?php echo ADMIN_CURRENCY_SYMBOL . $varShippingSubTotal; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><?php echo 'Total'; ?></td>
                                                                            <td>
                                                                                <?php
                                                                                $varTotal = ($varSubTotal);
                                                                                echo ADMIN_CURRENCY_SYMBOL . number_format($varTotal, 2, ".", ",");
                                                                                ?></td>
                                                                        </tr>
                                                                        <?php
                                                                        if ($varDescription) {
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo 'Description'; ?></td>
                                                                                <td><?php echo $varDescription; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr><td colspan="3" style="border:none;">&nbsp;</td></tr>

                                                            <?php
                                                        } else {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo ADMIN_NO_RECORD_FOUND; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (count($arrDisputedCommentsHistory) > 0) {
                        ?>
                        <div id="disputedHistory" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;">
                            <form name="frmdisputedHistory" id="frmdisputedHistory" method="post" action="" onsubmit="return validateDisputedFeedback()" >
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="popupClose1('disputedHistory')">X</button>
                                    <h3 id="myModalLabel">Disputed History Details</h3>
                                </div>
                                <div id='listed_Warning'></div>
                                <div class="modal-body" style="padding-left:42px;padding-right:10px; overflow: auto;">
                                    <table id="colorBox_table" style="width:600px;" border="0">
                                        <?php
                                        if ($arrOrderItem[0]['DisputedStatus'] == 'Resolved') {
                                            ?>
                                            <tr>
                                                <td>
                                                    <b class="green"><?php echo DISPUTE_RESOLVED; ?></b>
                                                    <br/><br/>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                        <?php
                                        foreach ($arrDisputedCommentsHistory as $kkk => $vvv) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <b>By <?php echo $vvv[$vvv['CommentedBy']] . ' (' . $vvv['CommentedBy'] . ') <small class="green">' . $objCore->localDateTime($vvv['CommentDateAdded'], DATE_TIME_FORMAT_SITE_FRONT) . '</small>'; ?></b>
                                                    <br/>
                                                </td>
                                            </tr>
                                            <?php
                                            if ($vvv['CommentOn'] == 'Disputed') {
                                                $Qdata = unserialize($vvv['CommentDesc']);
                                                ?>
                                                <tr>
                                                    <td><b><?php echo $arrDisputedComments['Q1']; ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $arrDisputedComments[$Qdata['Q1']]; ?></td>
                                                </tr>
                                                <?php
                                                if ($Qdata['Q1'] == 'A11') {
                                                    ?>
                                                    <tr>
                                                        <td><b><?php echo $arrDisputedComments['Q11']; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo $Qdata['Q11']; ?></td>
                                                    </tr>
                                                    <?php
                                                    $additionalCommentsQ = $arrDisputedComments['Q12'];
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td><b><?php echo $arrDisputedComments['Q21']; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <?php
                                                            $arrQ21 = explode(',', $Qdata['Q21']);
                                                            $Q21 = '';
                                                            foreach ($arrQ21 as $v10) {
                                                                if (key_exists($v10, $arrDisputedComments)) {
                                                                    $Q21 .= $arrDisputedComments[$v10] . ',';
                                                                } else {
                                                                    $Q21 .= $v . ',';
                                                                }
                                                            }
                                                            echo trim($Q21, ',');
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b><?php echo $arrDisputedComments['Q22']; ?></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <?php echo $arrDisputedComments[$Qdata['Q22']]; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b><?php echo $arrDisputedComments['Q23']; ?></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <?php echo $arrDisputedComments[$Qdata['Q23']]; ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $additionalCommentsQ = $arrDisputedComments['Q24'];
                                                }
                                            } else {
                                                $additionalCommentsQ = 'Feedback';
                                            }
                                            ?>
                                            <tr><td><b><?php echo $additionalCommentsQ; ?></b></td></tr>
                                            <tr>
                                                <td><?php echo $vvv['AdditionalComments']; ?></td>
                                            </tr>
                                            <tr><td><hr/></td></tr>

                                        <?php } ?>

                                        <tr>
                                            <td><b><?php echo 'Post Your Feedback'; ?></b></td>
                                        </tr>
                                        <tr>
                                            <td><textarea name="frmFeedback" id="frmFeedback" rows="3" cols="35" class="input-block-level"></textarea></td>
                                        </tr>
                                        <tr>
                                            <td align="right">
                                                <input type="hidden" name="type" value="disputeFeedback" />
                                                <input type="hidden" name="oid" value="<?php echo $arrOrderItem[0]['fkOrderID'] ?>" />
                                                <input type="hidden" name="soid" value="<?php echo $arrOrderItem[0]['SubOrderID'] ?>" />

                                                <input type="submit" class="btn btn-blue" name="Submit" value="Submit"/> &nbsp;&nbsp;
                                                <input type="button" onclick="popupClose1('disputedHistory')" style="cursor: pointer;" value="Cancel" name="cancel" class="btn">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="modal-footer"><input type="button" onclick="popupClose1('disputedHistory')" style="cursor: pointer;" value="Close" name="cancel" class="btn"></div>

                            </form>
                        </div>
                        <?php
                    }
                    // } //else {
                    ?>

                    <?php // }
                    ?>

                </div>
            </div>
            <?php require_once('../admin/inc/footer.inc.php'); ?>
        </div>
    </body>
</html>