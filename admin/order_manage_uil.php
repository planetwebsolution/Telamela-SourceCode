<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_ORDER_CTRL;
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_session_redirect_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_order_bll.php';
$objOrder = new Order();
//print_r($_SESSION);
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Orders</title>

        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
        <script type="text/javascript">
            Cal = jQuery.noConflict();
            Cal(document).ready(function () {
                Cal('#frmDateFrom').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" class="trigger">'});
                Cal('#frmDateTo').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" class="trigger">'});
            });
        </script>
        <?php require_once 'inc/common_css_js.inc.php'; ?>

        <link rel="stylesheet" href="css/colorbox.css" />
        <script src="../colorbox/jquery.colorbox.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" />
        <script type="text/javascript">
            function changeOrderStatus(status, soid, portalmail,gatwayname, posted) {
                //alert(status);
                if (posted == '1' && status == 'Disputed') {
                    alert('Order Posted. You can not ' + status + ' this Order');
                } else {
                    $.post("ajax.php", {action: 'changeOrderStatus', status: status, soid: soid,portalmail: portalmail,gatwayname: gatwayname},
                    function (data) {
                        alert('Order Status updated!');
                        //location.reload();
                        //$(showid).html(data);
                    });
                }
            }
        </script>
        <script>


            function  setEnquiryAction(value, formname, listname)
            {
                if ($("input[name='frmID[]']").serializeArray().length == 0)
                {
                    $('#modal-1').show();

                    //message = " "+DELETED_SEL+listname;
                } else if ($("input[name='frmID[]']").serializeArray().length > 0) {

                    $('#modal-2').show();

                } else {
                    $('#modal-1').hide();


                }
            }

            function dele(id) {
                $('#deltid').val(id);
                $('#modal-3').show();


            }
            function redir() {

                document.location.href = 'wholesaler_action.php?frmID=' + $('#deltid').val() + '&frmChangeAction=Delete';

            }
            function popupClose() {

                $('#modal-1').hide();
                $('#modal-2').hide();
                $('#modal-3').hide();

            }

            function formSubmit() {

                document.getElementById('frmUsersList').submit();

            }

            function viewDisputedHistory(soid, feedback) {
                $('#disputedHistory').show();
                $.post("ajax.php", {action: 'viewDisputedHistory', soid: soid, feedback: feedback, DisputedStatus: '1'},
                function (data) {
                    $('#disputedHistoryData').html(data);

                });
            }
            function popupClose1(showId) {
                $('#' + showId).hide();
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
                            <h1>Orders</h1>
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
                                <span>Orders</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php
                    if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-orders', $_SESSION['sessAdminPerMission'])) {
                        ?>
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div style="float:left">

                                    <button class="btn btn-inverse" onClick="showSearchBox('search', 'show');">Search Orders</button>
                                </div>
                                <div class="fright">
                                    <div class="export fleft">
                                        <form action="" method="post">
                                            <div>
                                                <label class="control-label" for="textfield">Export to: </label>
                                            </div>
                                            <div>
                                                <select name="fileType" class="select2-me input-small">
                                                    <option value="csv">CSV</option>
                                                    <option value="excel">Excel</option>
                                                </select>
                                            </div>
                                            <div>
                                                <input type="submit" class="btn btn-primary" name="Export" value="Export" />
                                            </div>
                                        </form>
                                    </div>
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
                                        <form id="frmSearch" method="get" action="" class='form-horizontal form-bordered'>
                                            <div class="row-fluid">
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Item Name:  </label>
                                                        <div class="controls">
                                                            <input type ="text" name="frmItemName" value="<?php echo stripslashes($_GET['frmItemName']); ?>" class="input-large"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Wholesaler: </label>
                                                        <div class="controls">
                                                            <select name="frmWhid" class='select2-me input-large'>
                                                                <option value="0" <?php
                                                                if ($_GET['frmWhid'] == '0') {
                                                                    echo 'Selected';
                                                                }
                                                                ?>>All</option>
                                                                        <?php
                                                                        foreach ($objPage->arrWholesaler as $wh) {
                                                                            ?>
                                                                    <option value="<?php echo $wh['pkWholesalerID']; ?>" <?php
                                                                    if ($_GET['frmWhid'] == $wh['pkWholesalerID']) {
                                                                        echo 'Selected';
                                                                    }
                                                                    ?>><?php echo $wh['CompanyName'] ?></option>
                                                                        <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Order Status: </label>
                                                        <div class="controls">
                                                            <select name="frmStatus" class='select2-me input-large'>
                                                                <option value="">Select Order Status</option>
                                                                <option value="Pending" <?php
                                                                if ($_GET['frmStatus'] == 'Pending') {
                                                                    echo 'Selected';
                                                                }
                                                                ?>>Pending</option>

                                                                <?php /* <option value="Posted" <?php
                                                                  if ($_GET['frmStatus'] == 'Posted') {
                                                                  echo 'Selected';
                                                                  }
                                                                  ?>>Posted</option> */ ?>

                                                                <option value="Processing" 
                                                                <?php
                                                                if ($_GET['frmStatus'] == 'Processing') {
                                                                    echo 'Selected';
                                                                }
                                                                ?>>Processing</option>

                                                                <option value="Processed" 
                                                                <?php
                                                                if ($_GET['frmStatus'] == 'Processed') {
                                                                    echo 'Selected';
                                                                }
                                                                ?>>Processed</option>

                                                                <option value="Shipped" 
                                                                <?php
                                                                if ($_GET['frmStatus'] == 'Shipped') {
                                                                    echo 'Selected';
                                                                }
                                                                ?>>Shipped</option>

                                                                <option value="Delivered" 
                                                                <?php
                                                                if ($_GET['frmStatus'] == 'Delivered') {
                                                                    echo 'Delivered';
                                                                }
                                                                ?>>Delievered</option>

                                                                <option value="Completed" <?php
                                                                if ($_GET['frmStatus'] == 'Completed') {
                                                                    echo 'Selected';
                                                                }
                                                                ?>>Completed</option>
                                                                <option value="Canceled" <?php
                                                                if ($_GET['frmStatus'] == 'Canceled') {
                                                                    echo 'Selected';
                                                                }
                                                                ?>>Cancelled</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row-fluid">
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Order ID:  </label>
                                                        <div class="controls">
                                                            <input type ="text" name="frmOrderId" value="<?php echo stripslashes($_GET['frmOrderId']); ?>" class="input-large"/>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span8">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Date: </label>
                                                        <div class="controls">
                                                            <?php
                                                            $frmDateFrom = isset($_GET['frmDateFrom']) ? $_GET['frmDateFrom'] : '';
                                                            $frmDateTo = isset($_GET['frmDateTo']) ? $_GET['frmDateTo'] : '';
                                                            ?>
                                                            <input type="text" name="frmDateFrom" id="frmDateFrom" placeholder="" value="<?php echo $frmDateFrom; ?>" readonly class="input-small" />
                                                            &nbsp;&nbsp;&nbsp;
                                                            To&nbsp;<input type="text" name="frmDateTo" id="frmDateTo" placeholder="" value="<?php echo $frmDateTo; ?>" readonly class="input-small" />

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="form-actions span12  search">
                                                        <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                        <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
                                                        <input type="button" <?php
                                                        if (isset($_REQUEST['frmSearch'])) {
                                                            ?> onclick="location.href = 'order_manage_uil.php'"<?php
                                                               } else {
                                                                   ?> onclick="showSearchBox('search', 'hide');" <?php } ?> value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />

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
                                            Orders
                                        </h3>
                                    </div>

                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php
                                            if ($objPage->NumberofRows > 0) {
                                                ?>
                                                <form id="frmUsersList" name="frmUsersList" action="order_action.php" method="post">
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <th class='with-checkbox hidden-480'>
                                                            <input type="hidden" name="frmProcess" id="frmProcess" value="ManipulateOrder"  />
                                                            <input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" />
                                                        </th>
                                                        <th class="hidden-480">Order ID</th>
                                                        <th>Sub Order ID</th>
                                                        <th>Transaction Id</th>
                                                        <th class="hidden-1024">Items Name</th>
                                                        <th class="hidden-480">Customer</th>
                                                        <th class="hidden-480 date">Date</th> 
                                                        <th class="hidden-480 price">Total Price</th>
                                                        <th class='hidden-480 status'>Order Item Status</th>
                                                        <th>Action</th>  
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                           // pre($objPage->arrRows);
                                                            foreach ($objPage->arrRows as $val) {
                                                            	//pre($objPage->arrRows);
                                                            	//$wholesalerid=25;
                                                            	//$fkShippingIDs=4;
                                                            	
                                                            	
                                                            	$wholesaler= $objOrder->wholesaleridshippingid($val['pkOrderItemID']);
                                                            	$wholesalerid=$wholesaler[0]['fkWholesalerID'];
                                                            	$fkShippingIDs=$wholesaler[0]['fkShippingIDs'];
                                                            	$wholesalercountryid= $objOrder->wholesalercountry($wholesalerid);
                                                            	$wholesalercountry = $wholesalercountryid[0]['CompanyCountry'];
                                                            	 
                                                            	$wholesalercountryportalid= $objOrder->wholesalercountryportal($wholesalercountry);
                                                            	$portalid=$wholesalercountryportalid[0]['pkAdminID'];
                                                            	//pre($portalid);
                                                            	//echo $portalid .'&'. $fkShippingIDs;
                                                            	//$gatwaymailid=$objOrder->getwaymailidusingportal($portalid,$fkShippingIDs);
                                                            	$gatwaymailid=$objGeneral->GetCompleteDetailsofLogisticPortalbyid($val['fkShippingIDs']);
                                                                //pre($gatwaymailid);
                                                            	$portalmail=$gatwaymailid[0]['logisticEmail'];
                                                            	$gatwaynamearray=$objGeneral->getshippingcompanyname($fkShippingIDs);
                                                            	//$gatwayname= $gatwaynamearray[0]['ShippingTitle'];
                                                            	$gatwayname= $gatwaymailid[0]['logisticTitle'];
                                                            	//pre($gatwayname);
                                                            	
//                                                             	if(empty($portalmail))
//                                                             	{
//                                                             		$portalmail='test@gmail.com';
//                                                             	}
                                                                ?>

                                                                <tr>
                                                                    <td class="with-checkbox hidden-480">
                                                                        <input style="width:20px; border:none;" type="checkbox" name="frmID[]" id="frmID[]"  value="<?php echo $val['SubOrderID']; ?>" onClick="singleSelectClick(this, 'singleCheck');" class="singleCheck"/>
                                                                    </td>
                                                                    <td class="hidden-480"><?php echo $val['fkOrderID']; ?></td>
                                                                    <td><?php echo $val['SubOrderID']; ?></td>
                                                                    <td><?php echo $val['transaction_ID']; ?></td>
                                                                    <td class="hidden-1024"><?php echo $val['ItemType'] == 'gift-card' ? ucwords(GIFT_CARD) : $val['Items']; ?></td>
                                                                    <td class="hidden-480 input-medium"><?php echo $val['CustomerName']; ?></td>
                                                                    <td class="hidden-480 input-medium date"><?php echo $objCore->localDateTime($val['OrderDateAdded'], DATE_FORMAT_SITE); ?> </td>
                                                                    <td class="hidden-480 input-medium price"><?php echo ADMIN_CURRENCY_SYMBOL . $objCore->price_format($val['ItemTotal']); ?> </td>
                                                                    <td class="hidden-480 status">
                                                                        <?php $varPosted = ($val['Status'] == 'Posted') ? 1 : 0; ?>
                                                                        <select name="frmStatus" onChange="changeOrderStatus(this.value, '<?php echo $val['SubOrderID']; ?>','<?php echo $portalmail; ?>','<?php echo $gatwayname; ?>',<?php echo $varPosted; ?>);" class='select2-me input-medium'>
                                                                            <option value="Pending" <?php
                                                                            if ($val['Status'] == 'Pending') {
                                                                                echo 'Selected';
                                                                            }
                                                                            ?>>Pending</option>

                                                                            <?php /*<option value="Posted" <?php
                                                                            if ($val['Status'] == 'Posted') {
                                                                                echo 'Selected';
                                                                            }
                                                                            ?>>Posted</option> */ ?>

                                                                            <option value="Processing" 
                                                                            <?php
                                                                            if ($val['Status'] == 'Processing') {
                                                                                echo 'Selected';
                                                                            }
                                                                            ?>>Processing</option>

                                                                            <option value="Processed" 
                                                                            <?php
                                                                            if ($val['Status'] == 'Processed') {
                                                                                echo 'Selected';
                                                                            }
                                                                            ?>>Processed</option>

                                                                            <option value="Shipped" 
                                                                            <?php
                                                                            if ($val['Status'] == 'Shipped') {
                                                                                echo 'Selected';
                                                                            }
                                                                            ?>>Shipped</option>

                                                                            <option value="Delivered" 
                                                                            <?php
                                                                            if ($val['Status'] == 'Delivered') {
                                                                                echo 'Selected';
                                                                            }
                                                                            ?>>Delivered</option>

                                                                            <option value="Completed" <?php
                                                                            if ($val['Status'] == 'Completed') {
                                                                                echo 'Selected';
                                                                            }
                                                                            ?>>Completed</option>
                                                                            <option value="Canceled" <?php
                                                                            if ($val['Status'] == 'Canceled') {
                                                                                echo 'Selected';
                                                                            }
                                                                            ?>>Canceled</option>
                                                                        </select>
                                                                    </td>
                                                                    <td class="input-xlarge">

                                                                        <a class="btn" href="order_view_uil.php?type=edit&soid=<?php echo $val['SubOrderID']; ?>" rel="tooltip" data-original-title="View"><i class="icon-eye-open"></i></a>
                                                                        <a class="btn" href="order_edit_uil.php?type=edit&soid=<?php echo $val['SubOrderID']; ?>" rel="tooltip" data-original-title="Edit"><i class="icon-edit"></i></a>
                                                                        <a href="order_invoice_uil.php?type=edit&soid=<?php echo $val['SubOrderID']; ?>" rel="tooltip" data-original-title="Send Invoice to Customer">Send Invoice to Customer</a>
                                                                        <?php
                                                                        if ($val['DisputedStatus'] == 'Resolved') {
                                                                            ?>
                                                                            &nbsp;
                                                                            <a href="javascript:void(0)" onClick="viewDisputedHistory('<?php echo $val['SubOrderID']; ?>', 0);" rel="tooltip" data-original-title="Click here to View Disputed history">Disputed History</a>
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>
                                                            <?php ?>
                                                        </tbody>


                                                    </table>

                                                    <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
                                                        <?php
                                                        $objPage->displayPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                        ?>
                                                    </div>
                                                    <div class="controls hidden-480" style="margin: 1%;">
                                                        <select name="frmChangeAction" onChange="javascript:return setValidAction(this.value, this.form, 'Order(s)');" ata-rule-required="true">
                                                            <option value="">-- Select Action --</option>
                                                            <option value="Delete All">Delete</option>
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
                            <div id="disputedHistory" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;">
                                <form name="frmdisputedHistory" id="frmdisputedHistory" method="post" action="" onSubmit="return validateDisputedFeedback()" >
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="popupClose1('disputedHistory')">X</button>
                                        <h3 id="myModalLabel">Disputed History Details</h3>
                                    </div>
                                    <div class="modal-body" id="disputedHistoryData" style="padding-left:42px;padding-right:10px; overflow: auto;">Feching Data....</div>
                                    <div class="modal-footer"><input type="button" onClick="popupClose1('disputedHistory')" style="cursor: pointer;" value="Close" name="cancel" class="btn"></div>
                                </form>
                            </div>

                            <?php
                        } else {
                            ?>
                            <table width="100%">
                                <tr>
                                    <th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th></tr>
                                <tr><td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td></tr>
                            </table>

                        <?php } ?>

                    </div>
                </div>
            </div>
            <?php require_once('inc/footer.inc.php'); ?>
        </div>

        <div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="popupClose()">X</button>
                <h3 id="myModalLabel">Delete Request</h3>
            </div>
            <div class="modal-body">
                <p>Please select at least one option to delete</p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true" onClick="popupClose()">OK</button>
                <!--				<button class="btn btn-primary" data-dismiss="modal">Save changes</button>-->
            </div>
        </div>

        <div id="modal-2" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="popupClose()">X</button>
                <h3 id="myModalLabel">Delete Request</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure to delete?</p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true" onClick="return popupClose();">Cancel</button>
                <button class="btn btn-primary" data-dismiss="modal" onClick="formSubmit()">Delete</button>
            </div>
        </div>
        <div id="modal-3" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="popupClose()">X</button>
                <h3 id="myModalLabel">Delete Request</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure to delete?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="deltid" value=""/>
                <button class="btn" data-dismiss="modal" aria-hidden="true" onClick="return popupClose();">Cancel</button>
                <button class="btn btn-primary" data-dismiss="modal" onClick="redir()">Delete</button>
            </div>
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