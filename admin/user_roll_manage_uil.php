<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_MODULE_LIST_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Role Management</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <!--<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.js"></script>-->
        <link rel="stylesheet" href="css/colorbox.css" />
        <!--<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>-->
        <script src="../colorbox/jquery.colorbox.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" />

        <script>
            $(document).ready(function(){
                $('#cancel').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });
            });
            function jscall(valID, process, action, type){
                $(".delete").colorbox({inline:true, width:"450px", height:"200px"});
                $('#cancel').click(function(){
                    parent.jQuery.fn.colorbox.close();
                });

                $('#frmConfirmDelete').click(function(){
                    window.location =('user_roll_action.php?frmID='+valID+'&frmProcess='+process+'&frmChangeAction='+action+'&deleteType='+type);
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
                            <h1>Role Management</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>


                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><span>Role Management List</span></li>
                        </ul>
                        <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12 margin_top20">
                            <div class="fleft">

                                <a href="user_roll_add_uil.php?type=add"><button class="btn btn-inverse">Add New</button></a>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="row-fluid" style="width:98%;margin:10px;">
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
                                    Role List
                                </h3>
                            </div>
                            <div class="box-content nopadding manage_categories">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                    <?php if ($objPage->NumberofRows > 0) { ?>
                                        <form id="frmUsersRollList" name="frmUsersRollList" action="user_roll_action.php" method="post">
                                            <table class="table table-hover table-nomargin table-bordered usertable">
                                                <thead>
                                                    <tr>
                                                        <th class='with-checkbox hidden-480'>
                                                            <input type="hidden" name="frmProcess" id="frmProcess" value="ManipulateRoll"  />
                                                            <input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" />
                                                        </th>
                                                        <th>Roll Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (is_array($objPage->arrRows)) {
                                                        foreach ($objPage->arrRows as $val) {
                                                            ?>
                                                            <tr>
                                                                <td valign="top" class="hidden-480">
                                                                    <input style="width:20px; border:none;" type="checkbox" class="singleCheck" name="frmID[]" id="frmID[]"  value="<?php echo $val['pkAdminRoleId']; ?>" onclick="singleSelectClick(this,'singleCheck');"/>
                                                                </td>
                                                                <td><?php echo $val['AdminRoleName']; ?></td>

                                                                <td>
                                                                    
                                                                    <a href="user_roll_add_uil.php?type=edit&rollid=<?php echo $val['pkAdminRoleId']; ?>" class="btn" rel="tooltip" title="" data-original-title="Edit"><i class="icon-edit"></i></a>

                                                                    <a href="user_roll_action.php?frmID=<?php echo $val['pkAdminRoleId']; ?>&frmProcess=ManipulateRoll&frmChangeAction=Delete&deleteType=sD" onClick="return fconfirm('Are you sure you want to delete this role?',this.href)" class="btn" rel="tooltip" title="" data-original-title="Delete"><i class="icon-remove"></i></a>
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
                                                <div class="controls hidden-480">
                                                    <select name="frmChangeAction" onchange="javascript:return setValidAction(this.value, this.form,'Role(s)');" ata-rule-required="true">
                                                        <option value="">-- Select Action --</option>
                                                        <option value="Delete All">Delete</option>
                                                    </select>
                                                    <label for="textfield" class="control-label">This action will be performed on the above selected record(s). </label>
                                                </div>
                                            </form>
                                            <?php
                                        }
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
                </div>

            </div>
            <?php require_once('inc/footer.inc.php'); ?>
        </div>

        <div style='display:none'>
            <div id='listed_delete'>
                <table id="colorBox_table">
                    <tr align="center">
                        <td style="font-family: Arial,Helvetica,sans-serif; font: 12px;">Would you really like to delete?</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center"><input type="submit" name="frmConfirmDelete" id="frmConfirmDelete" value="yes" style="cursor: pointer;"/>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="cancel" id="cancel" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" style="cursor: pointer;"/> </td>
                    </tr>

                </table>

            </div>
        </div>
    </body>
</html>