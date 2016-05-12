<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_CUSTOMER__FEEDBACK_VIEW_CTRL;
//pre($objPage->arrPerform);
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Feedback</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script>var SITE_ROOT_URL = '<?php echo SITE_ROOT_URL; ?>';</script>
        <link rel="stylesheet" href="css/colorbox.css" />
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <script src="../colorbox/jquery.colorbox.js"></script>

        <script type="text/javascript" src="<?php echo SITE_ROOT_URL . "common/js/ajax_js.js"; ?>"></script>
        <script>
            $(document).ready(function(){
                $('#cancelWarn').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });

                $('#cancelSus').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });
            });
            function jscall(emailid,id){
                $(".warning").colorbox({inline:true, width:"500px", height:"290px"});
                $('#cancelWarn').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });


                $('#frmConfirmWarning').click(function(){

                    var WarningMsg = document.getElementById('WarningMsg');
                    if(WarningMsg.value==''){
                        alert('Message is Required!');
                        WarningMsg.focus();
                        return false;
                    }else{
                        $('#listed_Warning').html('<span class="green">Sending.....</span>');
                        $.post("ajax.php",{action:'SendWarningToWholesaler',msg:WarningMsg.value,emailid:emailid,id:id},
                        function(data)
                        {
                            //$('#listed_Warning').html(data);
                            $('#listed_Warning').html('<span class="green">Warning Sent Successfully </span>');
                            setTimeout(function a(){parent.jQuery.fn.colorbox.close();location.reload();}, 1500);

                        }
                    );
                    }
                });
            }

            function jscall1(emailid,id){
                $(".suspend").colorbox({inline:true, width:"500px", height:"290px"});
                $('#cancelSus').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });

                $('#frmConfirmSuspend').click(function(){

                    var SuspendMsg = document.getElementById('SuspendMsg');
                    if(SuspendMsg.value==''){
                        alert('Message is Required!');
                        WarningMsg.focus();
                        return false;
                    }else{
                        $('#listed_Suspend').html('<span class="green">Sending.....</span>');
                        $.post("ajax.php",{action:'SuspendingWholesaler',msg:SuspendMsg.value,emailid:emailid,id:id},
                        function(data){
                            $('#listed_Suspend').html('<span class="green">Wholesaler Suspended.</span>');
                            setTimeout(function b(){parent.jQuery.fn.colorbox.close();location.reload();}, 1500);

                        });
                    }
                });
            }
            function changeStatus(status,emailid,id){

                $.post("ajax.php",{action:'customerChangeStatus',status:status,emailid:emailid,id:id},

                function(data)
                {
                    //$('#criA'+id).html(data);
                    location.reload();

                }
            );

            }
        </script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        
        <script type="text/javascript">
            google.load("visualization", "1", {packages:["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Task', 'Hours per Day'],
                    ['Have you received the goods in the timeframe mentioned by the wholesaler?',<?php echo $objPage->arrPerform[0]['numQuestion1']; ?>],
                    ['Does the product match the description provided by the wholesaler?',<?php echo $objPage->arrPerform[0]['numQuestion2']; ?>],
                    ['Are you happy with the product?',<?php echo $objPage->arrPerform[0]['numQuestion3']; ?>]
                ]);
                
                var options = {
                    title: 'Customer Feedback'
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
            }

            function jscall_feedback(id){
                $(".feedback").colorbox({inline:true, width:"530px", height:"400px"});
                $('#feedback_cancel').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });
            };
        </script>
    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>
        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>View Customer Feedback</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('manage-customer-feedback', $_SESSION['sessAdminPerMission']))
                    { ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                <li><a href="customer_feedback_uil.php?frmfeedback=yes">Manage Customer Feedback</a> <i class="icon-angle-right"></i></li>
                                <!--<li><a href="customer_feedback_view_uil.php?frmfeedback=yes&wid=<?php echo $_GET['wid']; ?>&type=view">View Customer Feedback</a></li>-->
                                <li><span>View Customer Feedback</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div class="fleft">
                                    <button class="btn btn-inverse" onclick="showSearchBox('search','show');">Search Feedback</button>
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
                                        <form id="frmSearch" method="get" action="" onsubmit="return dateCompare('frmSearch');" class="form-horizontal form-bordered">
                                            <div class="row-fluid">
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Product ID:</label>
                                                        <div class="controls">
                                                            <input type ="text" name="ProductId" value="<?php echo stripslashes($_GET['ProductId']); ?>" class="input-large"  />
                                                            <input type="hidden" name="wid" value="<?php echo stripslashes($_GET['wid']); ?>" />

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Customer Name:</label>
                                                        <div class="controls">
                                                            <input type ="text" name="CustomerName" value="<?php echo stripslashes($_GET['CustomerName']); ?>" class="input-large" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="form-actions span12  search">
                                                        <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                        <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
                                                        <?php if ($_GET['frmSearch'] != '')
                                                        { ?>
                                                            <input type="button" onclick="location.href = 'customer_feedback_view_uil.php?frmfeedback=yes&wid=<?php echo $_GET['wid']; ?>&type=view'" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />
                                                        <?php }
                                                        else
                                                        { ?>
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
                                        <h3>View Customer Feedback</h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
    <?php if ($objPage->NumberofRows > 0)
    { ?>
                                                <form id="frmCategoryList" name="frmCategoryList" action="" method="post">
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
                                                                <th class='hidden-480'>Product ID</th>
                                                                <th class='hidden-480'>Sub-Order ID</th>
                                                                <th>Product Name</th>
                                                                <th class='hidden-480'>Customer Name</th>
                                                                <th class='hidden-480'>Feedback Date</th>
                                                                <th>View Feedbacks</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
        <?php
        $i = 1;
        //pre($objPage->arrRows);
        foreach ($objPage->arrRows as $val)
        {
            ?>
                                                                <tr>
                                                                    <td class="hidden-480"><?php echo $val['pkProductID']; ?></td>
                                                                    <td class="hidden-480"><?php echo $val['SubOrderID']; ?></td>
                                                                    <td><?php echo ucfirst($val['ProductName']); ?></td>
                                                                    <td class="hidden-480"><?php echo ucfirst($val['CustomerFirstName']); ?></td>
                                                                    <td class="hidden-480"><?php echo $objCore->localDateTime($val['FeedbackDateAdded'], DATE_FORMAT_SITE); ?></td>
                                                                    <td><a href="#feedback_details<?php echo $val['pkFeedbackID']; ?>" class="feedback" onclick="return jscall_feedback()" >View Details</a>
                                                                        <div style='display:none'>
                                                                            <div id='feedback_details<?php echo $val['pkFeedbackID']; ?>' style="padding:10px 10px 70px 27px">

                                                                                <table border="0" id="colorBox_table">
                                                                                    <tbody>

                                                                                        <tr>
                                                                                            <td><strong>Have you received the goods in the timeframe mentioned by the wholesaler?</strong></td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
            <?php
            if ($val['Question1'] == 1)
            {
                echo "Yes";
            }
            else
            {
                echo "No";
            }
            ?>

                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><strong>Does the product match the description provided by the wholesaler?</strong></td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
            <?php
            if ($val['Question2'] == 1)
            {
                echo "Yes";
            }
            else
            {
                echo "No";
            }
            ?>

                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><strong>Are you happy with the product?</strong></td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
            <?php
            if ($val['Question3'] == 1)
            {
                echo "Yes";
            }
            else
            {
                echo "No";
            }
            ?>

                                                                                            </td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><strong>Comments:</strong></td>



                                                                                        </tr>
                                                                                        <tr>

                                                                                            <td>
            <?php
            if ($val['Comment'] != "")
            {
                echo $val['Comment'];
            }
            else
            {
                echo "No Comments";
            }
            ?>

                                                                                            </td>


                                                                                        </tr>

                                                                                    </tbody></table>

                                                                            </div>
                                                                        </div>

                                                                    </td>

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
                        <?php if ($objPage->NumberofRows > 0)
                        { ?>
                                                    <div class="pi_chart" style="text-align:center; margin-bottom: 20px;">
                                                        <div id="piechart" style="width: 400px; height: 400px; margin:auto; border:1px solid #dddddd;"></div>
                                                    </div>
        <?php } ?>
    <?php }
    else
    { ?>

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
<?php }
else
{ ?>
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
<?php if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes')
{ ?>
        showSearchBox('search', 'show');
<?php }
else
{ ?>
        showSearchBox('search', 'hide');
<?php } ?>
        </script>
        <div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;">



            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="popupClose1()">X</button>
                <h3 id="myModalLabel">Do you wish to send warning ?</h3>
            </div>
            <div id='listed_Warning'></div>
            <div class="modal-body" style="padding-left:42px;padding-right:10px;">

                <div class="rowlbinp">
                    <div class="lbl"><strong>Write Message:</strong></div><div class="inpt"><textarea name="WarningMsg" id="WarningMsg" rows="8" class="input4" style="width:600px"></textarea></div>
                </div>
            </div>
            <div class="modal-footer">
                <!--				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                                <button class="btn btn-primary" data-dismiss="modal">Save changes</button>-->

                <input type="submit" name="frmConfirmWarning" id="frmConfirmWarning" value="Send Message" style="cursor: pointer;" class="btn"/>
                &nbsp;&nbsp;<input type="button" class="btn" name="cancel" id="cancelWarn" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" style="cursor: pointer;" onclick="popupClose1()"/>

            </div>


        </div>

        <div id="modal-2" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:700px;">



            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="popupClose1()">X</button>
                <h3 id="myModalLabel">Do you wish to suspend this Wholesaler?</h3>
            </div>
            <div id='listed_Suspend'></div>
            <div class="modal-body" style="padding-left:42px;padding-right:10px;">

                <div class="rowlbinp">
                    <div class="lbl"><strong>Write Message:</strong></div><textarea name="SuspendMsg" id="SuspendMsg" rows="4" class="input4" style="width:600px"></textarea> <div class="inpt"></div>
                </div>
            </div>
            <div class="modal-footer">
                <!--				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                                <button class="btn btn-primary" data-dismiss="modal">Save changes</button>-->
                <input type="submit" name="frmConfirmSuspend" id="frmConfirmSuspend" value="Suspend" style="cursor: pointer;" class="btn"/>
                &nbsp;&nbsp;<input type="submit" name="cancel" id="cancelSus" value="Ignore" style="cursor: pointer;" class="btn" onclick="popupClose1()">




            </div>


        </div>
    </body>
</html>