<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_CUSTOMER_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Customer</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>

        <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>colorbox.css" />
        <script type='text/javascript' src="<?php echo SITE_ROOT_URL; ?>colorbox/jquery.colorbox.js"></script>
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL . "common/js/ajax_js.js"; ?>"></script>
        <script>
            $(document).ready(function(){
                $('#cancelWarn').click(function(){
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
            $(document).ready(function(){
                $('#cancelSus').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });
            });
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
                        function(data)
                        {
                            $('#listed_Suspend').html('<span class="green">Wholesaler Suspended.</span>');
                            setTimeout(function b(){parent.jQuery.fn.colorbox.close();location.reload();}, 1500);

                        }
                    );
                    }
                });
            }
            function changeStatus(status,emailid,id){
                var showid = '#customer'+id;

                $.post("ajax.php",{action:'customerChangeStatus',status:status,emailid:emailid,id:id},

                function(data)
                {
                    $(showid).html(data);
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
                            <h1>Manage Customer</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-customers', $_SESSION['sessAdminPerMission']))
                    { ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                <li><span>Manage Customer</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div class="fleft">
                                    <button class="btn btn-inverse" onClick="showSearchBox('search','show');">Search Customer </button>
                                    <a href="customer_reward_history_uil.php"><button class="btn btn-inverse">Reward Point History</button></a>
                                    <a href="customer_add_uil.php?type=add"><button class="btn btn-inverse">Add Customer</button></a>
                                </div>
                                <div class="fright">
                                    <div class="export fleft">
                                        <form action="" method="post">
                                            <div>
                                                <label class="control-label" for="textfield">Export to: </label>
                                            </div>
                                            <div>
                                                <select name="fileType">
                                                    <option value="csv">CSV</option>
                                                    <option value="excel">Excel</option>
                                                </select>
                                            </div>
                                            <div>
                                                <input type="submit" class="btn btn-primary" name="Export" value="Export" />
                                            </div>
                                        </form>
                                    </div>
                                    <div class="import fleft">
                                        <a href="bulk_upload_uil.php?type=customers" target="_blank"><button class="btn btn-inverse">Import</button></a>
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
                                        <form id="frmSearch" method="get" action="" onSubmit="return dateCompare('frmSearch');" class="form-horizontal form-bordered">
                                            <div class="row-fluid">
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">First Name:  </label>
                                                        <div class="controls">
                                                            <input type ="text" id="CustomerFirstName" name="CustomerFirstName" value="<?php echo stripslashes($_GET['CustomerFirstName']); ?>" class="input-large" placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Last Name:  </label>
                                                        <div class="controls">
                                                            <input type ="text" id="CustomerLastName" name="CustomerLastName" value="<?php echo stripslashes($_GET['CustomerLastName']); ?>" class="input-large" placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Phone: </label>
                                                        <div class="controls">
                                                            <input type ="text" id="BillingPhone" name="BillingPhone" value="<?php echo stripslashes($_GET['BillingPhone']); ?>" class="input-large" placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Email Address: </label>
                                                        <div class="controls">
                                                            <input type ="text" id="CustomerEmail" name="CustomerEmail" value="<?php echo stripslashes($_GET['CustomerEmail']); ?>" class="input-large" placeholder="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="form-actions span12  search">
                                                        <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                        <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
                                                        <?php if ($_GET['frmSearch'] != '')
                                                        { ?>
                                                            <input type="button" onClick="location.href = 'customer_manage_uil.php'" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />
                                                        <?php }
                                                        else
                                                        { ?>
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
                                            Customer List
                                        </h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                                            <?php if ($objPage->NumberofRows > 0)
                                                            { ?>
                                                <form id="frmCategoryList" name="frmCategoryList" action="customer_action.php" method="post">
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
                                                                <th class='with-checkbox hidden-480'><input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" /></th>
                                                            <?php echo $objPage->varSortColumn; ?>
                                                                <th class='hidden-480'>Email Verified</th>
                                                                <th class='hidden-480'>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
        <?php
        $i = 1;
        foreach ($objPage->arrRows as $val)
        {
            ?>
                                                                <tr>
                                                                    <td class='with-checkbox hidden-480'>
                                                                        <input style="width:20px; border:none;" type="checkbox" name="frmID[]" id="frmID[]"  value="<?php echo $val['pkCustomerID']; ?>" onClick="singleSelectClick(this,'singleCheck');" class="singleCheck"/>
                                                                    </td>
                                                                    <td class="hidden-480"><?php echo $val['pkCustomerID']; ?></td>
                                                                    <td><?php echo $val['CustomerFirstName']; ?></td>
                                                                    <td><?php echo $val['CustomerLastName']; ?></td>
                                                                    <td class="hidden-480"><?php echo $objCore->localDateTime($val['CustomerDateAdded'], DATE_FORMAT_SITE); ?></td>
                                                                    <td class='hidden-1024'><?php echo $val['CustomerEmail']; ?></td>
                                                                    <td class='hidden-1024'><?php echo $val['BillingPhone']; ?></td>
                                                                    <td class='hidden-1024'>
                                                                        <a data-original-title="View reward history" rel="tooltip" href="customer_reward_history_uil.php?id=<?php echo $val['pkCustomerID']; ?>&frmSearchPressed=Yes"><?php echo $val['BalancedRewardPoints']; ?></a>
                                                                    </td>
                                                                    <td class='hidden-1024'><?php echo ($val['IsEmailVerified'] == '1') ? 'Yes' : 'No'; ?></td>
                                                                    <td class='hidden-480'><span id="customer<?php echo $val['pkCustomerID']; ?>">
                                                                            <?php if (empty($val['CustomerStatus']))
                                                                            { ?><a href="javascript:void(0);" class="active" onClick="changeStatus('1','<?php echo $val['CustomerEmail']; ?>','<?php echo $val['pkCustomerID']; ?>')" title="Click here to active this customer.">Active</a><?php
                                                            }
                                                            else
                                                            {
                                                                echo '<span class="label label-satgreen">Active</span>';
                                                            }
                                                            ?>
            <?php if (!empty($val['CustomerStatus']))
            { ?><a href="javascript:void(0);" class="deactive" onClick="changeStatus('0','<?php echo $val['CustomerEmail']; ?>','<?php echo $val['pkCustomerID']; ?>')" title="Click here to deactive this customer.">Deactive</a><?php
            }
            else
            {
                echo '<a  href="" class="label label label-lightred">Deactive</a>';
            }
            ?>
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a class='btn' data-original-title="View" rel="tooltip" title=""  href="customer_view_uil.php?id=<?php echo $val['pkCustomerID']; ?>&type=view"><i class="icon-eye-open"></i></a>
                                                                        <a class="btn" data-original-title="Edit" rel="tooltip" title="" href="customer_edit_uil.php?id=<?php echo $val['pkCustomerID']; ?>&type=edit"><i class="icon-edit"></i></a>
                                                                        <a class='btn' data-original-title="Delete" rel="tooltip" title="" href="customer_action.php?frmID=<?php echo $val['pkCustomerID']; ?>&frmChangeAction=Delete" onClick='return fconfirm("Are you sure you want to delete this Customer? ",this.href);'><i class="icon-remove"></i></a>
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
                                                    <div class="controls hidden-480" style="margin: 1%;">
                                                        <select name="frmChangeAction" onChange="javascript:return setValidAction(this.value, this.form,'Customer(s)');" ata-rule-required="true">
                                                            <option value="">-- Select Action --</option>
                                                            <option value="Delete All">Delete</option>
                                                        </select>
                                                        <label for="textfield" class="control-label">This action will be performed on the above selected record(s). </label>
                                                    </div>

                                                </form>
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
        <div style='display:none'>
            <div id='listed_Warning'>
                <table id="colorBox_table">
                    <tr align="left">
                        <td style="font-family: Arial,Helvetica,sans-serif; font: 12px;">Write Message:</td>
                    </tr>
                    <tr>
                        <td align="left"><textarea name="WarningMsg" id="WarningMsg" rows="8" class="input4"></textarea></td>
                    </tr>
                    <tr>
                        <td align="left"><input type="submit" name="frmConfirmWarning" id="frmConfirmWarning" value="Send Message" style="cursor: pointer;"/>
                            &nbsp;&nbsp;<input type="submit" name="cancel" id="cancelWarn" value="cancel" style="cursor: pointer;"/> </td>
                    </tr>

                </table>

            </div>
        </div>
        <div style='display:none'>
            <div id='listed_Suspend'>
                <table id="colorBox_table">

                    <tr align="left">
                        <td style="font-size:18px; font-weight: bold;">Do you wish to suspend this Wholesaler?</td>
                    </tr>

                    <tr align="left">
                        <td style="font-family: Arial,Helvetica,sans-serif; font:12px;">Write Message:</td>
                    </tr>
                    <tr>
                        <td align="left"><textarea name="SuspendMsg" id="SuspendMsg" rows="4" class="input4"></textarea></td>
                    </tr>
                    <tr>
                        <td align="left">
                            <input type="submit" name="frmConfirmSuspend" id="frmConfirmSuspend" value="Suspend" style="cursor: pointer;"/>
                            &nbsp;&nbsp;<input type="submit" name="cancel" id="cancelSus" value="Ignore" style="cursor: pointer;"/> </td>
                    </tr>

                </table>

            </div>
        </div>
    </body>
</html>