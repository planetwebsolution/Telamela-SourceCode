<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_ORDER_DISPUTED_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Disputed Orders</title>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
        <script type="text/javascript">
            Cal=jQuery.noConflict();
            Cal(document).ready(function(){
                Cal('#frmDateFrom').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" class="trigger">'});
                Cal('#frmDateTo').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" class="trigger">'});
            });
        </script>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <link rel="stylesheet" href="css/colorbox.css" />
        <script src="../colorbox/jquery.colorbox.js"></script>
        <script type="text/javascript">
            function changeOrderStatus(status,soid){
                $.post("ajax.php",{action:'changeOrderStatus',DisputedStatus:status,soid:soid},
                function(data){
                    alert('Disputed Order Resolved');
                    location.reload();
                    //$(showid).html(data);
                });
            }

            function viewDisputedHistory(soid,feedback){
                $('#disputedHistory').show();
                $.post("ajax.php",{action:'viewDisputedHistory',soid:soid,feedback:feedback,DisputedStatus:'0'},
                function(data){
                    $('#disputedHistoryData').html(data);
                });
            }
            function popupClose1(showId){
                $('#'+showId).hide();
            }
            function validateDisputedFeedback(){
                var feedback = '#frmFeedback';
                if($(feedback).val()==''){
                    alert('Post Your Feedback is required !');
                    $(feedback).focus();
                    return false;
                }
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
                            <h1>Disputed Orders</h1>
                        </div>
                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="order_manage_uil">Sales</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <span>Disputed Orders</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php
                    if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-orders', $_SESSION['sessAdminPerMission']))
                    {
                        ?>
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div style="float:left">
                                    <button class="btn btn-inverse" onClick="showSearchBox('search','show');">Search Disputed Orders</button>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid" id="search">
                            <div class="span12">
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>Advance Search  </h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">
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
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Wholesaler: </label>
                                                        <div class="controls">
                                                            <select name="frmWhid" class='select2-me input-large'>
                                                                <option value="0" <?php
                    if ($_GET['frmWhid'] == '0')
                    {
                        echo 'Selected';
                    }
                        ?>>All</option>
                                                                        <?php
                                                                        foreach ($objPage->arrWholesaler as $wh)
                                                                        {
                                                                            ?>
                                                                    <option value="<?php echo $wh['pkWholesalerID']; ?>" <?php
                                                                    if ($_GET['frmWhid'] == $wh['pkWholesalerID'])
                                                                    {
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
                                                        <label for="textfield" class="control-label">Status: </label>
                                                        <div class="controls">
                                                            <select name="frmStatus" class='select2-me input-large'>
                                                                <option value="">Select option</option>
                                                                <option value="Completed" <?php
                                                                    if ($_GET['frmStatus'] == 'Completed')
                                                                    {
                                                                        echo 'Selected';
                                                                    }
                                                                        ?>>Completed
                                                                </option>
                                                                <option value="Pending" <?php
                                                                    if ($_GET['frmStatus'] == 'Pending')
                                                                    {
                                                                        echo 'Selected';
                                                                    }
                                                                        ?>>Pending
                                                                </option>

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
                                                        <label for="textfield" class="control-label">Order Date: </label>
                                                        <div class="controls" style="width:290px">
                                                            <?php
                                                            $frmDateFrom = isset($_GET['frmDateFrom']) ? $_GET['frmDateFrom'] : '';
                                                            $frmDateTo = isset($_GET['frmDateTo']) ? $_GET['frmDateTo'] : '';
                                                            ?>
                                                            From :&nbsp;<input type="text" name="frmDateFrom" id="frmDateFrom" placeholder="" value="<?php echo $frmDateFrom; ?>" readonly class="input-small" />
                                                            <br/>
                                                            To :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="frmDateTo" id="frmDateTo" placeholder="" value="<?php echo $frmDateTo; ?>" readonly class="input-small" style="margin-left: 2px; margin-top: 5px;" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="form-actions span12  search">
                                                    <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                    <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
                                                    <input type="button" <?php
                                                        if (isset($_REQUEST['frmSearch']))
                                                        {
                                                                ?> onclick="location.href = 'order_disputed_manage_uil.php'"<?php
                                                   }
                                                   else
                                                   {
                                                                ?> onclick="showSearchBox('search', 'hide');" <?php } ?> value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />
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
                                if ($objCore->displaySessMsg())
                                {
                                    echo $objCore->displaySessMsg();
                                    $objCore->setSuccessMsg('');
                                    $objCore->setErrorMsg('');
                                }
                                ?>
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3> Disputed Orders</h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php
                                            if ($objPage->NumberofRows > 0)
                                            {
                                                ?>
                                                <form id="frmUsersList" name="frmUsersList" action="order_action.php" method="post">
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <th class='hidden-480'>Order ID</th>
                                                        <th>Sub Order ID</th>
                                                        <th class='hidden-480'>Items Name</th>
                                                        <th class='hidden-480'>Customer</th>
                                                        <th class='hidden-480'>Order Date</th>
                                                        <th class='hidden-480'>Total Price</th>
                                                        <th class="hidden-480">Status</th>
                                                        <th>Action</th>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            
                                                            /* $newdisputed = array();
                                                            foreach ($objPage->disputed as $disputed) {
                                                            	$newdisputed[] = $disputed['fkSubOrderID'];
                                                            }
                                                            
                                                            function multi_array_search($search_for, $newdisputed) {
                                                            	 
                                                            	if (in_array($search_for, $newdisputed)) {
                                                            		return true;
                                                            	} else {
                                                            		return false;
                                                            	}
                                                            }
                                                            $j = 1; */
                                                            
                                                            foreach ($objPage->arrRows as $val)
                                                            {
                                                            	/* This condition is used to varify disputed orders by Krishna Gupta (19-10-2015) */
                                                            	//if (multi_array_search($val['SubOrderID'], $newdisputed)) {
                                                            		//$j++;
                                                                ?>
                                                                <tr>
                                                                    <td class='hidden-480'><?php echo $val['fkOrderID']; ?></td>
                                                                    <td><?php echo $val['SubOrderID']; ?></td>
                                                                    <td class='hidden-480'><?php echo $val['Items']; ?></td>
                                                                    <td class='hidden-480'><?php echo $val['CustomerName']; ?></td>
                                                                    <td class='hidden-480'><?php echo $objCore->localDateTime($val['ItemDateAdded'], DATE_FORMAT_SITE); ?> </td>
                                                                    <td class='hidden-480'><?php echo ADMIN_CURRENCY_SYMBOL . $objCore->price_format($val['ItemTotal']); ?> </td>
                                                                    <td class='hidden-480'><?php echo $val['Status']; ?></td>
                                                                    <td><a href="javascript:void(0)" onClick="viewDisputedHistory('<?php echo $val['SubOrderID']; ?>',1);" rel="tooltip" data-original-title="Click here to View Disputed history">Disputed History</a>&nbsp;&nbsp;&nbsp;
                                                                        <a href="javascript:void(0)" onClick="changeOrderStatus('Resolved','<?php echo $val['SubOrderID']; ?>');" rel="tooltip" data-original-title="Click here to resolved Order">Resolve</a>&nbsp;&nbsp;&nbsp;
                                                                        <a class="btn" href="order_view_uil.php?type=edit&soid=<?php echo $val['SubOrderID']; ?>" rel="tooltip" data-original-title="View order and disputed history"><i class="icon-eye-open"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                //}
                                                                $i++;
                                                            }	
                                                            
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
                                                        <?php
                                                        	
                                                        	//$paggg = $objPage->paging($j);
                                            				/* echo $_GET['page'].'a';// current page
                                            				echo $objPage->varNumberPages.'b';// total pages
                                            				echo $objPage->varPageLimit.'c'; */ // per page limit
                                                        	$objPage->displayPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                        
                                                            ?>
                                                       
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
                        <div id="disputedHistory" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;">
                            <form name="frmdisputedHistory" id="frmdisputedHistory" method="post" action="" onSubmit="return validateDisputedFeedback()">                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="popupClose1('disputedHistory')">X</button>
                                    <h3 id="myModalLabel">Disputed History Details</h3>
                                </div>
                                <div class="modal-body" id="disputedHistoryData" style="padding-left:42px;padding-right:10px; overflow: auto;">Feching Data....</div>
                                <div class="modal-footer"><input type="button" onClick="popupClose1('disputedHistory')" style="cursor: pointer;" value="Close" name="cancel" class="btn"></div>
                            </form>
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <table width="100%">
                            <tr><th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th></tr>
                            <tr><td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td></tr>
                        </table>
                    <?php } ?>
                </div>
            </div>
             <?php require_once('inc/footer.inc.php'); ?>
        </div>
        <script type="text/javascript">
<?php
if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes')
{
    ?>
            showSearchBox('search', 'show');<?php
}
else
{
    ?>
            showSearchBox('search', 'hide');<?php }
?>
        </script>
    </body>
</html>