<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_CUSTOMER__FEEDBACK_CTRL;
//pre($_SESSION);
global $objGeneral;
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
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL . "common/js/ajax_js.js"; ?>"></script>
        <script>
            function jscall(emailid,id,warn){
                $('#modal-1').show(); 
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
                            setTimeout(function a(){ $('#modal-1').hide();location.reload();}, 1500);
                                
                        }
                    );                    
                    }
                });
                
               
            }
                       
        </script>
        <script>
            function jscall1(emailid,id){
                $('#modal-2').show(); 
                $('#frmConfirmSuspend').click(function(){
                    
                    var SuspendMsg = document.getElementById('SuspendMsg');
                    if(SuspendMsg.value==''){                        
                        alert('Message is Required!');
                        WarningMsg.focus();
                        return false;
                    }else{ 
                        
                        $('#listed_Suspend').html('<span class="green">Sending.....</span>');
                        $.post("ajax.php",{action:'SuspendingWholesaler',msg:SuspendMsg.value,emailid:emailid,id:id},
                        function(data)
                        { 
                            $('#listed_Suspend').html('<span class="green">Wholesaler Suspended.</span>');
                            setTimeout(function b(){$('#modal-2').hide();location.reload();}, 1500);
                                
                        }
                    );                    
                    }        
                });
              
            }         
        </script>
        <script type="text/javascript">
            function popupClose1(){
                $('#modal-1').hide();
                $('#modal-2').hide();
                return false;
            
            } 
        </script>
        <script>
            function changeStatus(status,emailid,id){
                
                $.post("ajax.php",{action:'WholesalerChangeStatus',status:status,emailid:emailid,id:id},
                
                function(data)
                {
                    //$('#criA'+id).html(data); 
                    location.reload();
                         
                }
            );
              
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
                            <h1>Manage Customer Feedback</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('manage-customer-feedback', $_SESSION['sessAdminPerMission']))
                    {
                        ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                <!--<li><a href="customer_feedback_uil.php?frmfeedback=yes">Manage Customer Feedback</a></li>-->
                                <li><span>Manage Customer Feedback</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div class="fleft">
                                    <button class="btn btn-inverse" onclick="showSearchBox('search','show');">Search Customer Feedback </button>
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
                                                        <label for="textfield" class="control-label">Wholesaler ID:  </label>
                                                        <div class="controls">
                                                            <input type ="text" id="WholesalerID" name="WholesalerID" value="<?php echo stripslashes($_GET['WholesalerID']); ?>" class="input-large" placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Wholesaler Name:</label>
                                                        <div class="controls">
                                                            <input type ="text" id="WholesalerName" name="WholesalerName" value="<?php echo stripslashes($_GET['WholesalerName']); ?>" class="input-large" placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="form-actions span12  search">
                                                        <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                        <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
                                                        <?php if ($_GET['frmSearch'] != '')
                                                        {
                                                            ?>
                                                            <input type="button" onclick="location.href = 'customer_feedback_uil.php?frmfeedback=yes'" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />
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
                                            Customer Feedback List
                                        </h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
    <?php if ($objPage->NumberofRows > 0)
    {
        ?>
                                                <form id="frmCategoryList" name="frmCategoryList" action="" method="post">
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
                                                                <th class='hidden-480'>Wholesaler ID</th>
                                                                <th>Wholesaler Name</th>
                                                                <th class='hidden-480'>Date</th>
                                                                <th class='hidden-350'>KPI</th>
                                                                <th>View Feedbacks</th>
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
                                                                    <td class="hidden-480"><?php echo $val['fkWholesalerID']; ?></td>
                                                                    <td><?php echo ucfirst($val['CompanyName']); ?></td>
                                                                    <td class="hidden-480"><?php echo $objCore->localDateTime($val['date'], DATE_FORMAT_SITE); ?></td>
                                                                        <?php
                                                                        $objPage->kpi = $objGeneral->wholesalerKpi($val['fkWholesalerID']);
                                                                        ?>
                                                                    <td class="hidden-350"><?php echo $objPage->kpi['kpi']; ?></td>
                                                                    <td><a href="customer_feedback_view_uil.php?frmfeedback=yes&wid=<?php echo $val['fkWholesalerID']; ?>&type=view">View Details</a></td>
                                                                    <td class="hidden-480">
                                                                        <?php
                                                                        if ($val['numWarn'] != "")
                                                                        {
                                                                            $warn = $val['numWarn'];
                                                                        }
                                                                        else
                                                                        {
                                                                            $warn = 0;
                                                                        }
                                                                        ?>
                                                                        <?php if ($warn > 2)
                                                                        {
                                                                            ?>
                                                                            <a href="#" onclick="return alert('Three warning has been sent to wholesaler !');"><span class="req">Send warning</span></a>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <a class="warning cboxElement" href="#model-1" onclick="return jscall('<?php echo $val['CompanyEmail']; ?>',<?php echo $val['fkWholesalerID']; ?>)"><span class="req">Send warning</span></a>

                                                                            <?php }
                                                                            ?>
                                                                        &nbsp;&nbsp;&nbsp;
                                                                        <span id="criA<?php echo $val['fkWholesalerID']; ?>">
                                                                            <?php if ($val['WholesalerStatus'] == 'suspend')
                                                                            {
                                                                                ?><a href="#listed_Suspend" onclick="changeStatus('active','<?php echo $val['CompanyEmail']; ?>',<?php echo $val['fkWholesalerID']; ?>)"><span>Activate</span></a>
                                                                <?php
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                                <a class="Suspend cboxElement" href="#model-2" onclick="return jscall1('<?php echo $val['CompanyEmail']; ?>',<?php echo $val['fkWholesalerID']; ?>)"><span>Suspend</span></a>
            <?php } ?></span>

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
<?php if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes')
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