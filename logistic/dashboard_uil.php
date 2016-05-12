<?php
/* * ****************************************
  Module name : dashboard admin
  Date created : 27 May 2013
  Comments : This will show various info to the admin
  Copyright : Copyright (C) 1999-2009 Vinove Software and Services (P) Ltd.
 * ***************************** */
require_once '../common/config/config.inc.php';

require_once CONTROLLERS_LOGISTIC_PATH . FILENAME_LOGISTICPORTAL_ORDER_CTRL;
require_once CLASSES_LOGISTIC_PATH . 'class_logisticportal_order_bll.php';
$objOrder = new logisticOrder();
$arrOrderItem = $objPage->dashboardlist;
//pre($objPage->arrRow);
//
//$IsOrderPerMission = ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-orders', $_SESSION['sessAdminPerMission'])) ? 1 : 0;
//$IsEnqueryPerMission = ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-user-enquiries', $_SESSION['sessAdminPerMission'])) ? 1 : 0;
//$IsWholesalerAppPerMission = ($_SESSION['sessUserType'] == 'super-admin' || in_array('manage-wholesaler-applications', $_SESSION['sessAdminPerMission'])) ? 1 : 0;
////$IsSupportPerMission = ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-customer-support', $_SESSION['sessAdminPerMission'])) ? 1 : 0;
//$IsCustomerPerMission = ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-customers', $_SESSION['sessAdminPerMission'])) ? 1 : 0;
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
        <title><?php echo ADMIN_PANEL_NAME; ?>: Dashboard</title>
        <link rel="stylesheet" href='<?php echo ADMIN_JS_PATH; ?>plugins/eventcal/fullcalendar.css' />
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src='<?php echo ADMIN_JS_PATH; ?>plugins/eventcal/moment.min.js'></script>
        <script type="text/javascript" src='<?php echo ADMIN_JS_PATH; ?>plugins/eventcal/fullcalendar.min.js'></script>
        <script>
            Cal = jQuery.noConflict();
            Cal(document).ready(function () {
                Cal('#calendar').fullCalendar({
                    header: {left: 'prev,next today', center: 'title', right: 'month,basicWeek,basicDay'},
                    defaultDate: '<?php echo $objCore->localDateTime(date('Y-m-d'), DATE_FORMAT_DB); ?>',
                    editable: false,
                    events: "ajax.php?action=dashboardEvents",
                    eventDrop: function (event, delta) {
                        alert(event.title + ' was moved ' + delta + ' days\n' + '(should probably update your database)');
                    },
                    loading: function (bool) {
                        if (bool) { //$('#loading').show();else $('#loading').hide();
                        }
                    }
                });

            });
        </script>
        <?php require_once '../admin/inc/common_css_js.inc.php'; ?>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
            // Load the Visualization API and the piechart package.
            google.load('visualization', '1', {'packages': ['corechart']});

            // Set a callback to run when the Google Visualization API is loaded.
            google.setOnLoadCallback(drawChart);

            function drawChart() {

                $('#chart_div1').html('loading...');
                var ct = $('#kpiCountry').val();
                var timeWise = $('#timeWise').val();
                var timeYear = $('#timeYear').val();
                var timeMonth = $('#timeMonth').val();

                if (timeWise == 'month') {
                    $('#timeDiv').show();
                } else {
                    $('#timeDiv').hide();
                }
                var dt = 'action=dashboardKpi&ct=' + ct + '&timeWise=' + timeWise + '&timeYear=' + timeYear + '&timeMonth=' + timeMonth;

                var jsonData = $.ajax({
                    url: "ajax.php",
                    dataType: "json",
                    data: dt,
                    async: false
                }).responseText;
                //alert(jsonData);
                // Create our data table out of JSON data loaded from server.
                var data = new google.visualization.DataTable(jsonData);
                $('#chart_div1').html('');
                // Instantiate and draw our chart, passing in some options.
//                var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
                var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                chart.draw(data, {width: 400, height: 'auto'});
            }

        </script>
    </head>
    <body>
        <div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h3 id="myModalLabel">Modal header</h3>
            </div>
            <div class="modal-body">
                <p>One fine body…</p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn btn-primary" data-dismiss="modal">Save changes</button>
            </div>
        </div>
        <div id="modal-2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Modal header</h3>
            </div>
            <div class="modal-body">
                <p>One fine body…</p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn btn-primary" data-dismiss="modal">Save changes</button>
            </div>
        </div>
        <div id="modal-3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Modal header</h3>
            </div>
            <div class="modal-body">
                <p>One fine body…</p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
                <button class="btn btn-primary" data-dismiss="modal">Yes</button>
            </div>
        </div>
        <div id="modal-4" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Modal header</h3>
            </div>
            <div class="modal-body">
                <p>One fine body…</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">Ok</button>
            </div>
        </div>
        <?php
//pre($_SESSION);
//pre("here");
        require_once '../admin/inc/header_logistic.inc.php';
//pre($_SESSION);
        ?>

        <div class="container-fluid deshboard" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Dashboard</h1>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="tab-pane active" id="tabs-2">
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="box box-color box-bordered">
                                            <div class="box-content nopadding" style=" border:2px solid #368EE0;">
                                                <div class="box-title" id="box-title" style="margin-top:0;">
                                                    <h3>  Recently Ordered Items </h3> 
                                                    <a href="logisticorder_manage_uil.php" class="pull-right btn">View All</a> 
                                                </div>
                                                <div class="box-content1 nopadding gray_border showScroll">
                                                    <table width="100%" cellpadding="0" cellspacing="0" class="table table-hover table-nomargin table-bordered usertable">
                                                        <?php
                                                       // pre($arrOrderItem);
                                                        if (count($arrOrderItem) > 0) {
                                                            ?>
                                                            <thead>
                                                                <tr>

                                                                    <th class="hidden-480">Order No.</th>
                                                                    <th class='hidden-480'>Source</th>
                                                                    <th class="hidden-1024">Destination</th>
                                                                    <th class="hidden-300">Methods</th>

                                                                    <th class='hidden-350'> Total Price ($)</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                $varSubTotal = 0;
                                                                $varShippingSubTotal = 0;
                                                                $varTotal = 0;

                                                                foreach ($arrOrderItem as $val) {
                                                                    $wholesaler = $objOrder->wholesaleridshippingid($val['pkOrderItemID']);
                                                                    $wholesalerid = $wholesaler[0]['fkWholesalerID'];
                                                                    $fkShippingIDs = $wholesaler[0]['fkShippingIDs'];
                                                                    $wholesalercountryid = $objOrder->wholesalercountry($wholesalerid);
                                                                    $wholesalercountry = $wholesalercountryid[0]['CompanyCountry'];
                                                                    ?>
                                                                    <tr class="content">

                                                                        <td class="hidden-480"><?php echo $val['SubOrderID']; ?></td>
                                                                        <td><?php
                                                                            $countrydata = $objGeneral->getCountrynamebyid($wholesalercountry);
                                                                            echo $countrydata[0]['name'];
                                                                            ?></td>

                                                                        <td class="hidden-480 input-medium"><?php
                                                                            $countrydata = $objGeneral->getCountrynamebyid($val['ShippingCountry']);
                                                                            echo $countrydata[0]['name'];
                                                                            ?></td>
                                                                        
                                                                        <td class="hidden-1024"><?php
                                                                         $Methoddata = $objGeneral->getshippingmethodnamebyid($val['fkMethodID']);
                                                                            echo $Methoddata[0]['MethodName'];
                                                                        
                                                                        echo $val['Quantity']; ?></td>
                                                                        <td class="hidden-300"><?php echo number_format($val['ShippingPrice'], 2); ?></td>
                                                                       
                                                                        <td><a href="order_view_uil.php?type=edit&soid=<?php echo $val['SubOrderID']; ?>" class="btn" rel="tooltip" title="View Order Details"><i class="icon-eye-open"></i></a></td>
                                                                    </tr>
                                                            <?php } ?>
                                                            </tbody>
<?php } else { ?>
                                                            <tr class="content">
                                                                <th style="text-align: center;"><?php echo ADMIN_NO_RECORD_FOUND ?></th>
                                                            </tr>
<?php } ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
<?php require_once('../admin/inc/footer.inc.php'); ?>
        </div>
    </body>
</html>