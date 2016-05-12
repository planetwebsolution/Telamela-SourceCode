<?php
/* * ****************************************
  Module name : dashboard admin
  Date created : 27 May 2013
  Comments : This will show various info to the admin
  Copyright : Copyright (C) 1999-2009 Vinove Software and Services (P) Ltd.
 * ***************************** */
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_DASHBOARD_CTRL;
//pre($_SESSION);
$IsOrderPerMission = ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-orders', $_SESSION['sessAdminPerMission'])) ? 1 : 0;
$IsEnqueryPerMission = ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-user-enquiries', $_SESSION['sessAdminPerMission'])) ? 1 : 0;
$IsWholesalerAppPerMission = ($_SESSION['sessUserType'] == 'super-admin' || in_array('manage-wholesaler-applications', $_SESSION['sessAdminPerMission'])) ? 1 : 0;
//$IsSupportPerMission = ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-customer-support', $_SESSION['sessAdminPerMission'])) ? 1 : 0;
$IsCustomerPerMission = ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-customers', $_SESSION['sessAdminPerMission'])) ? 1 : 0;
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
        <?php require_once 'inc/common_css_js.inc.php'; ?>
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
<?php require_once 'inc/header_new.inc.php'; ?>
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
                    <table class="table table-bordered usertable" cellpadding="0" cellspacing="0" width="100%">
                              <tbody>
                        <tr>
                                  <td style="vertical-align: top" class="float_left hidden-480 firsttd"><table class="calender_outer" cellpadding="0" cellspacing="0" width="100%">
                                      <tr>
                                      <td><div class="box-title" id="box-title" style="margin-top:0;">
                                          <h3> Events </h3>
                                        </div></td>
                                    </tr>
                                      <tr>
                                      <td><!--<div id="loading">Loading...</div>-->
                                          
                                          <div id="calendar"></div></td>
                                    </tr>
                                    </table></td>
                                  <td style="border:none; vertical-align: top;" class="secondtd"><table cellpadding="0" cellspacing="0" width="100%">
                                      <tr>
                                      <td><div class="box-title" style="margin-top:0">
                                          <h3> Sales </h3>
                                        </div></td>
                                    </tr>
                                      <tr>
                                      <td><div class="visit_row inner_pad">
                                          <div class="visit_outer">
                                          <div class="visit_left"><img src="images/visit_icon.png" alt=""/></div>
                                          <div class="visit_right">
                                              <?php
                                                                                        $cur = $objPage->arrData['SalesTotal']['Visitor']['curMonth'];
                                                                                        $prev = $objPage->arrData['SalesTotal']['Visitor']['prevMonth'];
                                                                                        $perIncrease = $objCore->getPercentage($cur, $prev);
                                                                                        $clss = ($perIncrease >= 0) ? 'class="up"' : 'class="down"';
                                                                                        ?>
                                              <span style=" clear:inherit; display:inline-block; vertical-align:top; margin-right:5px; font-size: 23px; font-weight:bold;line-height: 20px;"><?php echo ($cur) ?> </span><small>Visits</small> <span <?php echo $clss ?>><?php echo $perIncrease ?>% from the previous month</span> </div>
                                        </div>
                                          <div class="visit_outer">
                                          <div class="visit_left"><img src="images/visit_icon1.png" alt=""/></div>
                                          <div class="visit_right">
                                              <?php
                                                                                        $cur = $objPage->arrData['SalesTotal']['Ads']['curMonth'];
                                                                                        $prev = $objPage->arrData['SalesTotal']['Ads']['prevMonth'];
                                                                                        $perIncrease = $objCore->getPercentage($cur, $prev);
                                                                                        $clss = ($perIncrease >= 0) ? 'class="up"' : 'class="down"';
                                                                                        ?>
                                              <span style=" clear:inherit; display:inline-block; vertical-align:top; margin-right:5px; font-size: 23px; font-weight:bold;line-height: 20px;">$<?php echo $objCore->price_format($cur / 1000) ?>K </span><small>Advertisement</small> <span <?php echo $clss ?>><?php echo $perIncrease ?>% from the previous month</span> </div>
                                        </div>
                                          <div class="visit_outer" style="margin-right: 0">
                                          <div class="visit_left"><img src="images/visit_icon2.png" alt=""/></div>
                                          <div class="visit_right">
                                              <?php
                                                                                        $cur = $objPage->arrData['SalesTotal']['Sales']['curMonthAmount'];
                                                                                        $prev = $objPage->arrData['SalesTotal']['Sales']['prevMonthAmount'];
                                                                                        $perIncrease = $objCore->getPercentage($cur, $prev);
                                                                                        $clss = ($perIncrease >= 0) ? 'class="up"' : 'class="down"';
                                                                                        ?>
                                              <span style="clear:inherit; display:inline-block; vertical-align:top; margin-right:5px; font-size: 23px; font-weight:bold;line-height: 20px;"><?php echo $objCore->price_format($cur / 1000) ?>K </span><small>Revenue</small> <span <?php echo $clss ?>><?php echo $perIncrease ?>% from the previous month</span> </div>
                                        </div>
                                        </div></td>
                                    </tr>
                                      <?php if ($IsOrderPerMission) { ?>
                                      <tr>
                                      <td><div class="tab-pane" id="tabs-5">
                                          <div class="row-fluid">
                                          <div class="span12">
                                              <div class="box box-color box-bordered inner_pad">
                                              <div class="box-title gray_bg gray_border">
                                                  <h3> Recently Ordered Items </h3>
                                                  <a href="order_manage_uil.php" class="pull-right btn">View All</a> </div>
                                              <div class="box-content nopadding gray_border showScroll">
                                                  <table width="100%" cellpadding="0" cellspacing="0" class="table table-hover table-nomargin table-bordered usertable">
                                                  <?php if (count($objPage->arrData['RecentlyOrderedItem']) > 0) { ?>
                                                  <thead>
                                                      <tr>
                                                      <th>Order ID</th>
                                                      <th class="hidden-480">Sub Order ID</th>
                                                      <th class='hidden-480'>Items</th>
                                                      <th class="hidden-1024">Wholesaler</th>
                                                      <th class="hidden-300">Customer</th>
                                                      <th class='hidden-1024'>Date</th>
                                                      <th class='hidden-350'>Price (<?php echo ADMIN_CURRENCY_SYMBOL ?>)</th>
                                                      <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                  <tbody>
                                                      <?php foreach ($objPage->arrData['RecentlyOrderedItem'] as $val) { ?>
                                                      <tr class="content">
                                                      <td><?php echo $val['fkOrderID']; ?></td>
                                                      <td class="hidden-480"><?php echo $val['SubOrderID']; ?></td>
                                                      <td class="hidden-480"><?php
                                                                                                                            echo $val['Items'];
                                                                                                                            if ($val['ItemType'] == 'gift-card') {
                                                                                                                                echo ' <b>Gift Cart</b>';
                                                                                                                            }
                                                                                                                            ?></td>
                                                      <td class="hidden-1024"><?php echo $val['CompanyName']; ?></td>
                                                      <td class="hidden-300"><span style="display:block; width:150px; word-wrap:break-word;"><?php echo $val['CustomerEmail']; ?></span></td>
                                                      <td class='hidden-1024'><?php echo $objCore->localDateTime($val['OrderDateAdded'], DATE_FORMAT_SITE); ?></td>
                                                      <td class='hidden-350'><?php echo $objCore->price_format($val['ItemTotal']); ?></td>
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
                                        </div></td>
                                    </tr>
                                      <?php } ?>
                                    </table></td>
                                </tr>
                      </tbody>
                            </table>
                  </div>
                        </div>
              </div>
                    </div>
          </div>
                  <?php if ($IsEnqueryPerMission) { ?>
                  <div class="tab-pane" id="tabs-3">
            <div class="row-fluid">
                      <div class="span12">
                <div class="box box-color box-bordered">
                          <div class="box-title">
                    <h3> Recent User Enquiries </h3>
                    <a href="user_enquiry_manage_uil.php" class="pull-right btn">View All</a> </div>
                          <div class="box-content nopadding">
                    <table class="table table-hover table-nomargin table-bordered usertable">
                              <?php if (count($objPage->arrData['RecentEnquiry']) > 0) { ?>
                              <thead>
                        <tr>
                                  <th >Sender Name </th>
                                  <th class="hidden-300">Sender Email</th>
                                  <th class='hidden-1024'>Date</th>
                                  <th class='hidden-350'>Subject</th>
                                  <th>Action</th>
                                </tr>
                      </thead>
                              <tbody>
                        <?php foreach ($objPage->arrData['RecentEnquiry'] as $val) { ?>
                        <tr class="content">
                                  <td><?php echo $val['EnquirySenderName']; ?></td>
                                  <td class="hidden-300"><?php echo $val['EnquirySenderEmail']; ?></td>
                                  <td class='hidden-1024'><?php echo $objCore->localDateTime($val['EnquiryDateAdded'], DATE_FORMAT_SITE); ?></td>
                                  <td class="hidden-350"><span class="label <?php
                                                                            if ($val['EnquirySubject'] == 'Complain') {
                                                                                echo 'label-lightred';
                                                                            } if ($val['EnquirySubject'] == 'Enquiry') {
                                                                                echo 'label-satgreen';
                                                                            }
                                                                            ?>"><?php echo $val['EnquirySubject']; ?></span></td>
                                  <td><a href="user_enquiry_view_uil.php?id=<?php echo $val['pkEnquiryID']; ?>&type=view" class="btn" rel="tooltip" title="View"><i class="icon-eye-open"></i></a></td>
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
                  <?php } ?>
                  <?php if ($IsWholesalerAppPerMission) { ?>
                  <div class="tab-pane" id="tabs-4">
            <div class="row-fluid">
                      <div class="span12">
                <div class="box box-color box-bordered">
                          <div class="box-title">
                    <h3> Wholesaler </h3>
                  </div>
                          <div class="box-content nopadding">
                    <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                              
                                <td class="float_left" style="vertical-align: top">
                              
                              <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                                  <td><div class="inner_pad">
                                      <div class="box-title gray_bg gray_border">
                                      <h3> Recent Wholesaler Applications </h3>
                                      <a href="wholesaler_application_manage_uil.php" class="pull-right btn">View All</a> </div>
                                      <div class="box-content nopadding gray_border">
                                      <table class="table table-hover table-nomargin table-bordered usertable">
                                          <?php if (count($objPage->arrData['RecentWholesalerApplication']) > 0) { ?>
                                          <thead>
                                          <tr>
                                              <th>Request Sender (Wholesaler)</th>
                                              <th class='hidden-300'>Email</th>
                                              <th class="phone_150">Phone</th>
                                              <th class='hidden-1024'>Country</th>
                                              <th class='hidden-350'>Request Date</th>
                                              <th>Action</th>
                                            </tr>
                                        </thead>
                                          <tbody>
                                          <?php foreach ($objPage->arrData['RecentWholesalerApplication'] as $val) { ?>
                                          <tr class="content">
                                              <td><?php echo $val['CompanyName']; ?></td>
                                              <td class='hidden-300'><?php echo $val['CompanyEmail']; ?></td>
                                              <td class="phone_150"><?php echo $val['CompanyPhone']; ?></td>
                                              <td class='hidden-1024'><?php echo $val['CountryName']; ?></td>
                                              <td class='hidden-350'><?php echo $objCore->localDateTime($val['WholesalerDateAdded'], DATE_FORMAT_SITE); ?></td>
                                              <td><a href="wholesaler_view_uil.php?id=<?php echo $val['pkWholesalerID']; ?>&type=edit" class="btn" rel="tooltip" title="View"><i class="icon-eye-open"></i></a></td>
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
                                    </div></td>
                                </tr>
                          <tr>
                        
                          <td style="vertical-align: top">
                        
                        <table cellpadding="0" cellspacing="0" width="100%">
                                <tr><td>
                                <div class="inner_pad">
                            <div class="box-title  gray_bg gray_border">
                                      <h3> Wholesaler support inbox|outbox </h3>
                                      <a href="wholesaler_support_enquiry_manage_uil.php" class="pull-right btn">View All</a> </div>
                            <div class="box-content nopadding gray_border">
                                      <table class="table table-hover table-nomargin table-bordered usertable" cellpadding="0" cellspacing="0" width="100%">
                                <?php if (count($objPage->arrData['RecentWholesalerSupport']) > 0) { ?>
                                <thead>
                                          <tr>
                                    <th>Ticket ID</th>
                                    <th class='hidden-480'>Subject</th>
                                    <th class='hidden-480'>Name</th>
                                    <th class="hidden-300">Email</th>
                                    <th class='hidden-1024'>Phone</th>
                                    <th class='hidden-350'>Date</th>
                                    <th>Action</th>
                                  </tr>
                                        </thead>
                                <tbody>
                                          <?php foreach ($objPage->arrData['RecentWholesalerSupport'] as $val) { ?>
                                          <tr class="content">
                                    <td><?php echo $val['pkSupportID']; ?></td>
                                    <td class='hidden-480'><?php echo $val['Subject']; ?></td>
                                    <td class="hidden-300"><?php echo $val['wholesalerName']; ?></td>
                                    <td class="hidden-300"><?php echo $val['wholesalerEmail']; ?></td>
                                    <td class='hidden-1024'><?php echo $val['wholesalerPhone']; ?></td>
                                    <td class='hidden-350'><?php echo $objCore->localDateTime($val['SupportDateAdded'], DATE_FORMAT_SITE); ?></td>
                                    <td><?php if ($val['FromUserType'] == 'admin') {
                                                                                                            ?>
                                              <a href="wholesaler_support_outbox_view_uil.php?id=<?php echo $val['pkSupportID']; ?>&type=edit" class="btn" rel="tooltip" title="View"><i class="icon-eye-open"></i></a></td>
                                    <?php
                                                                                                            } else if ($val['FromUserType'] == 'wholesaler') {
                                                                                                                ?>
                                    <a href="wholesaler_support_enquiry_view_uil.php?id=<?php echo $val['pkSupportID']; ?>&type=edit" class="btn" rel="tooltip" title="View"><i class="icon-eye-open"></i></a>
                                  </td>
                                
                                <?php } ?>
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
                         			</td></tr>
                                </table>
                          </td>
                        
                          </tr>
                        
                      </table>
                                </td>
                              
                              
                        <td style="vertical-align: top" class="clear_both hidden-480"><div class="inner_pad">
                            <div class="box-title gray_border gray_bg">
                              <h3> Wholesaler KPI </h3>
                            </div>
                            <div class="inner_pad box-content nopadding gray_border">
                              <div class="visit_row width">
                                <div class="visit_outer">
                                  <div class="visit_left"><img alt="" src="images/visit_icon3.png"/></div>
                                  <div class="visit_right">
                                    <h3>Performance</h3>
                                  </div>
                                </div>
                                <div class="drop_drown">
                                  <select name="kpiCountry" id="kpiCountry" onChange="drawChart()" class="select2-me input-large">
                                    <?php foreach ($objPage->arrData['arrCountry'] as $val) { ?>
                                    <option value="<?php echo $val['country_id'] ?>"><?php echo $val['name'] ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                                <div class="drop_drown">
                                  <select name="timeWise" id="timeWise" onChange="drawChart()" class="select2-me input-large">
                                    <option value="year">Year</option>
                                    <option value="month">Month</option>
                                  </select>
                                </div>
                                <div class="drop_drown" style="display:none;" id="timeDiv">
                                  <select name="timeMonth" id="timeMonth" onChange="drawChart()" class="select2-me input-large">
                                    <?php
                                                                                    $arrMonthShort = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
                                                                                    $sel = date('m');
                                                                                    foreach ($arrMonthShort as $key => $val) {
                                                                                        ?>
                                    <option value="<?php echo $key ?>" <?php echo ($key == $sel) ? 'selected="selected"' : '' ?>><?php echo $val; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                                <div class="drop_drown">
                                  <select name="timeYear" id="timeYear" onChange="drawChart()" class="select2-me input-large">
                                    <?php
                                                                                    $from = '2013';
                                                                                    $to = date('Y');
                                                                                    for ($i = $from; $i <= $to; $i++) {
                                                                                        ?>
                                    <option value="<?php echo $i ?>" <?php echo ($i == $to) ? 'selected="selected"' : '' ?>><?php echo $i ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="visit_row width" style="text-align: center" id="chart_div1"></div>
                              
                              <!--Div that will hold the pie chart-->
                              <div id="chart_div"></div>
                            </div>
                          </div></td>
                      </tr>
                            </table>
                    <div style="height: 15px; width: 100%;padding: 0;margin: 0;clear: both"></div>
                  </div>
                        </div>
              </div>
                    </div>
          </div>
                  <?php } ?>
                  <?php if ($IsCustomerPerMission) { ?>
                  <div class="tab-pane" id="tabs-4">
            <div class="row-fluid">
                      <div class="span12">
                <div class="box box-color box-bordered">
                          <div class="box-title">
                    <h3> Customer </h3>
                  </div>
                          <div class="box-content nopadding">
                    <table>
                              <tr>
                        <td class="float_left"><table>
                            <tr>
                              <td><div class="inner_pad">
                                  <div class="box-title gray_border gray_bg">
                                    <h3> Recent Product Review </h3>
                                    <a href="product_review_manage_uil.php" class="pull-right btn">View All</a> </div>
                                  <div class="box-content nopadding gray_border">
                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                      <?php if (count($objPage->arrData['RecentProductReview']) > 0) { ?>
                                      <thead>
                                        <tr>
                                          <th>Product ID</th>
                                          <th class='hidden-480'>Product Name</th>
                                          <th class="hidden-300">Product Category</th>
                                          <th class='hidden-1024'>Customer Name</th>
                                          <th class='hidden-350'>Review</th>
                                          <th>Status</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php foreach ($objPage->arrData['RecentProductReview'] as $val) { ?>
                                        <tr class="content">
                                          <td><?php echo $val['fkProductID']; ?></td>
                                          <td class='hidden-480'><?php echo $val['ProductName']; ?></td>
                                          <td class="hidden-300"><?php echo $val['CategoryName']; ?></td>
                                          <td class='hidden-1024'><?php echo $val['csName']; ?></td>
                                          <td class='hidden-350'><?php echo substr($val['Reviews'], 0, 20); ?></td>
                                          <!-- Commented by Krishna Gupta -->
                                          <?php /* ?>
                                                                                                          <td><?php  if($val['ApprovedStatus']=="Allow") {echo "Approved";} else {echo "Disapproved"; } ?></td>
                                                                                                          <?php */ ?>
                                          <td class='hidden-1024'><?php if ($val['ApprovedStatus'] == "Allow") {
                                                                                                echo 'Approved';
                                                                                            } elseif ($val['ApprovedStatus'] == "Disallow") {
                                                                                                echo 'Disapproved';
                                                                                            } else {
                                                                                                echo 'Pending';
                                                                                            } ?></td>
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
                                </div></td>
                            </tr>
                            <tr>
                              <td><div class="inner_pad">
                                  <div class="box-title gray_border gray_bg">
                                    <h3> Customer support inbox|outbox </h3>
                                    <a href="customer_support_enquiry_manage_uil.php" class="pull-right btn">View All</a> </div>
                                  <div class="box-content nopadding gray_border">
                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                      <?php if (count($objPage->arrData['RecentCustomerSupport']) > 0) { ?>
                                      <thead>
                                        <tr>
                                          <th>Ticket ID</th>
                                          <th class='hidden-480'>Subject</th>
                                          <th class='hidden-480'>Name</th>
                                          <th class="hidden-300">Email</th>
                                          <th class='hidden-1024'>Phone</th>
                                          <th class='hidden-350'>Date</th>
                                          <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php foreach ($objPage->arrData['RecentCustomerSupport'] as $val) { ?>
                                        <tr class="content">
                                          <td><?php echo $val['pkSupportID']; ?></td>
                                          <td class='hidden-480'><?php echo $val['Subject']; ?></td>
                                          <td class="hidden-300"><?php echo $val['customerName']; ?></td>
                                          <td class='hidden-1024'><?php echo $val['customerEmail']; ?></td>
                                          <td class='hidden-1024'><?php echo $val['customerPhone']; ?></td>
                                          <td class='hidden-350'><?php echo $objCore->localDateTime($val['SupportDateAdded'], DATE_FORMAT_SITE); ?></td>
                                          <td><?php if ($val['FromUserType'] == 'customer') {
                ?>
                                            <a href="customer_support_enquiry_view_uil.php?id=<?php echo $val['pkSupportID']; ?>&type=edit" class="btn" rel="tooltip" title="View"><i class="icon-eye-open"></i></a>
                                            <?php
                                                                                                    } else if ($val['FromUserType'] == 'admin') {
                                                                                                        ?>
                                            <a href="customer_support_outbox_view_uil.php?id=<?php echo $val['pkSupportID']; ?>&type=edit" class="btn" rel="tooltip" title="View"><i class="icon-eye-open"></i></a>
                                            <?php } ?></td>
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
                                </div></td>
                            </tr>
                          </table></td>
                        <td class="inner_pad clear_both" style="vertical-align: top"><table>
                            <tr>
                              <td><div class="box-title gray_border gray_bg">
                                  <h3> Customer feedback List </h3>
                                </div></td>
                            </tr>
                            <tr>
                              <td><div class="tab-pane" id="tabs-5">
                                  <div class="row-fluid">
                                    <div class="span12">
                                      <div class="box box-color box-bordered" style="margin-top: -2px;">
                                        <div class="box-content nopadding gray_border inner_pad" style="padding-top: 10px!important">
                                          <div class="compare_row">
                                            <div class="good_sec">
                                              <h3><?php echo $objPage->arrData['CustomerFeedbackCount'][0]['good'] ?></h3>
                                              <span>Positive</span> </div>
                                            <!--
                                                                                                                                                            <div class="fair_sec">
                                                                                                                                                                <h3>5236</h3>
                                                                                                                                                                <span>Fair</span>
                                                                                                                                                            </div>-->
                                            <div class="bad_sec">
                                              <h3><?php echo $objPage->arrData['CustomerFeedbackCount'][0]['bad'] ?></h3>
                                              <span>Negative</span> </div>
                                          </div>
                                          <table class="table table-hover table-nomargin table-bordered usertable" style="clear:both">
                                            <?php if (count($objPage->arrData['WholesalerFeedbackKpiList']) > 0) { ?>
                                            <thead>
                                              <tr>
                                                <th class="hidden-480">Wholesaler ID/Name</th>
                                                <th class='hidden-1024'>Date</th>
                                                <th class="hidden-300">kpi</th>
                                                <th class='hidden-350'>Feedback</th>
                                                <th>Action</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?php
        $arrFd = array('0' => 'Bad', '1' => 'Good');
        foreach ($objPage->arrData['WholesalerFeedbackKpiList'] as $val) {
            ?>
                                              <tr class="content">
                                                <td class="hidden-480"><?php echo $val['fkWholesalerID'] . ' / ' . $val['CompanyName'] ?></td>
                                                <td class="hidden-1024"><?php echo $objCore->localDateTime($val['FeedbackDateAdded'], DATE_FORMAT_SITE) ?></td>
                                                <td class="hidden-300"><?php echo $val['kpi'] ?></td>
                                                <td class="hidden-350"><?php echo $arrFd[$val['IsPositive']] ?></td>
                                                <td><a rel="tooltip" class="btn" href="wholesaler_view_uil.php?id=<?php echo $val['fkWholesalerID'] ?>&type=edit" title="View Wholesaler"><i class="icon-eye-open"></i></a></td>
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
                                </div></td>
                            </tr>
                          </table></td>
                      </tr>
                            </table>
                    <div style="height: 15px; width: 100%;padding: 0;margin: 0;clear: both"></div>
                  </div>
                        </div>
              </div>
                    </div>
          </div>
                  <?php } ?>
                </div>
      </div>
            </div>
  </div>
          <?php require_once('inc/footer.inc.php'); ?>
        </div>
</body>
</html>