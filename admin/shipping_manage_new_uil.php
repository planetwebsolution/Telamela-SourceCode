<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_SHIPPING_NEW_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Shipping Gateway</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script>
            function changeStatus(status,sgid){ 
                $.post("ajax.php",{action:'ChangeShippingGatewayStatusNew',status:status,sgid:sgid},
                function(data){
                   
                    $('.sg'+sgid).html(data);   
                    
                });              
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
                            <h1>Shipping Gateway</h1>
                        </div>

                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin') { ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li>
                                    <a href="dashboard_uil.php">Home</a>
                                    <i class="icon-angle-right"></i>
                                </li>
                               
                                <li>
                                    <span>Shipping Gateway</span>
                                </li>
                            </ul>
                            <div class="close-bread">
                                <a href="#"><i class="icon-remove"></i></a>
                            </div>
                        </div>


                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div style="float:left">
                                    <a href="shipping_add_new_uil.php?type=add"><button class="btn btn-inverse">Add New Shipping Gateway</button></a>
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
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>Shipping Gateway</h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php if ($objPage->NumberofRows > 0) { ?>
                                                <form id="frmPackageList" name="frmPackageList" action="shipping_action_new.php" method="post">
                                                    <input type="hidden" name="frmProcess" id="frmProcess" value="ManipulateAttribute"  />
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
                                                                <th class='hidden-480'>Shipping Gateway</th>
                                                                <!--<th>Shipping Code</th>-->
                                                                <th class='hidden-480'>Shipping Type</th>
                                                                <th class='hidden-480'>Shipping Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            //pre($objPage->arrRows);
                                                            $i = 1;
                                                            foreach ($objPage->arrRows as $val) {
                                                                ?>
                                                                <tr>
                                                                    <td class="hidden-480"><?php echo $val['ShippingTitle']; ?></td>
                                                                    <!--<td><?php // echo $val['ShippingAlias']; ?></td>-->
                                                                    <td class="hidden-480"><?php echo ucwords($val['ShippingType']); ?></td>
                                                                    <td class="hidden-480">                                                                    
                                                                        <span class="sg<?php echo $val['pkShippingGatewaysID']; ?>">
                                                                            <?php if (empty($val['ShippingStatus'])) { ?>
                                                                                <a href="javascript:void(0);" title="click for active" class="active" onclick="changeStatus(1,<?php echo $val['pkShippingGatewaysID']; ?>)">Active</a>
                                                                                <?php
                                                                            } else {
                                                                                echo '<span class="label label-satgreen">Active</span>';
                                                                            }
                                                                            ?>
                                                                            <?php if (!empty($val['ShippingStatus'])) { ?>
                                                                                <a href="javascript:void(0);" title="click for deactive" class="deactive" onclick="changeStatus(0,<?php echo $val['pkShippingGatewaysID']; ?>)">Deactive</a>
                                                                                <?php
                                                                            } else {
                                                                                echo '<a  href="" class="label label label-lightred">Deactive</a>';
                                                                            }
                                                                            ?>
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($val['ShippingType'] == 'admin') { ?>
                                                                            <a class="btn" rel="tooltip" title="Edit" href="shipping_edit_new_uil.php?smid=<?php echo $val['pkShippingGatewaysID']; ?>&type=edit"><i class="icon-edit"></i></a>
                                                                            <?php if ($val['noOfMethods'] == 0) { ?>
                                                                                <a class='btn' rel="tooltip" title="Delete" href="shipping_action_new.php?frmID=<?php echo $val['pkShippingGatewaysID']; ?>&shipName=<?php echo $val['ShippingTitle']; ?>&frmChangeAction=Delete&deleteType=sD" onClick="return fconfirm('Are you sure you want to delete this shipping gateway?',this.href)"><i class="icon-remove"></i></a>
                                                                            <?php } else { ?>
                                                                                <a class='btn' rel="tooltip" title="Delete" href="javascript:void(0);" onClick="return falert('This shipping gateway contains methods. So first delete it\'s methods .')"><i class="icon-remove"></i></a>
                                                                            <?php } ?>
                                                                        <?php } ?>&nbsp;
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