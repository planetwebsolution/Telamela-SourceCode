<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_SHIPPING_METHOD_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Shipping Method</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>  
        <script type="text/javascript">
            function changeStatus(status, sgid) {

                $.ajax({
                    url: 'ajax.php',
                    type: "POST",
                    data: {action: 'Changeshippingmethodstatus', status: status, sgid: sgid},
                    //contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function (data) {
//                        var data1 = JSON.stringify(data);

                        $('.sg' + sgid).html(data.html);

                        if (data.status == "exist")
                        {
                            // $("#sortable_msg").html("Order updated successfully.").removeClass("bg-danger hidden").addClass("bg-success");
                            //$(".sucessmsg").html("<b>Status decactive Successfully</b>!").removeClass("success").addClass("error");
                            $(".error").html("<b>This Method is used not Deactivate.</b>!");
                            $(".error").css('display', 'block');
                        }
                        if (data.status == "1")
                        {
                            $(".sucessmsg").html("<b>Status Updated Successfully</b>!");
                            $(".sucessmsg").css('display', 'block');
                        }

                        setTimeout(function () {
                            $(".sucessmsg").hide();
                        }, 3000);
                        setTimeout(function () {
                            $(".error").hide();
                        }, 3000);
                    }
                });



//                $.post("ajax.php", {action: 'Changeshippingmethodstatus', status: status, sgid: sgid},
//                function (data) {
//                    console.log(data);
//                    $('.sg' + sgid).html(data);
//
//                });
            }



        </script>
        <style>
            .sucessmsg{
                color: green;
                padding-top: 10px;
            }
            .error
            {
                color: green;
                padding-top: 10px;
            }
        </style>
    </head>
    <body> 
        <?php require_once 'inc/header_new.inc.php'; ?>
        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Shipping Method</h1>
                        </div>

                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || $_SESSION['sessUserType'] == 'user-admin') { ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li>
                                    <a href="dashboard_uil.php">Home</a>	
                                    <i class="icon-angle-right"></i>
                                </li>	

                                <li>
                                    <span>Shipping Method</span>
                                </li>	
                            </ul>
                            <div class="close-bread">
                                <a href="#"><i class="icon-remove"></i></a>
                            </div>
                        </div>


                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div style="float:left">
                                    <a href="shipping_method_add_uil.php?type=add"><button class="btn btn-inverse">Add New Shipping Method</button></a>
                                </div>
                                <div class="fright"></div>
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
                                <p class="sucessmsg"></p>
                                <p class="error"></p>
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>Shipping Method</h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">  
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php if ($objPage->NumberofRows > 0) { ?>
                                                <form id="frmPackageList" name="frmPackageList" action="shipping_gateway_action.php" method="post">  
                                                    <input type="hidden" name="frmProcess" id="frmProcess" value="ManipulateAttribute"  />                                         
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>                                                                

                                                                <th class='hidden-480'>Method Name</th>

                                                                <th class='hidden-480'>Method Description</th>                                                                
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($objPage->arrRows as $val) {
                                                                ?>
                                                                <tr>

                                                                    <td><?php echo $val['MethodName']; ?></td>

                                                                    <td class="hidden-480"><?php echo $val['MethodDescription']; ?></td>                                                                    
                                                                    <td>
                                                                        <span class="sg<?php echo $val['pkShippingMethod']; ?>">
                                                                            <?php if (empty($val['MethodStatus'])) { ?>
                                                                                <a href="javascript:void(0);" title="click for active" class="active" onclick="changeStatus(1,<?php echo $val['pkShippingMethod']; ?>)">Active</a>
                                                                                <?php
                                                                            } else {
                                                                                echo '<span class="label label-satgreen">Active</span>';
                                                                            }
                                                                            ?>
                                                                            <?php if (!empty($val['MethodStatus'])) { ?>
                                                                                <a href="javascript:void(0);" title="click for deactive" class="deactive" onclick="changeStatus(0,<?php echo $val['pkShippingMethod']; ?>)">Deactive</a>
                                                                                <?php
                                                                            } else {
                                                                                echo '<a  href="" class="label label label-lightred">Deactive</a>';
                                                                            }
                                                                            ?>
                                                                        </span>
                                                                    </td>
                                                                    <td>	

                                                                        <a class="btn" rel="tooltip" title="Edit" href="shipping_method_edit_uil.php?smid=<?php echo $val['pkShippingMethod']; ?>&type=edit"><i class="icon-edit"></i></a>                                        
            <!--                                                                            <a class='btn' rel="tooltip" title="Delete" href="shipping_method_action.php?frmID=<?php echo $val['pkShippingMethod']; ?>&frmChangeAction=Delete&deleteType=sD" onClick="return fconfirm('Are you sure you want to delete this Shipping Method?',this.href)"><i class="icon-remove"></i></a>-->
                                                                        &nbsp;

                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>
                                                        </tbody>                                       
                                                    </table>
                                                    <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate"><?php
                                                        if ($objPage->varNumberPages > 1) {
                                                            $objPage->displayPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                        }
                                                        ?></div>
                                                </form>
                                            <?php } else { ?>
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
                <?php } else { ?>
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

    </body>
</html>