<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_WHOLESALER_SUPPORT_OUTBOX_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Wholesalers Kpi</title>        
        <?php require_once 'inc/common_css_js.inc.php'; ?>

    </head>
    <body>

        <?php require_once 'inc/header_new.inc.php'; ?>

        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Wholesaler Support outbox</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-cms', $_SESSION['sessAdminPerMission'])) { ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>	
                                <li><span>Wholesaler Support outbox</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
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
                                            Wholesaler Support outbox
                                        </h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">  
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php if ($objPage->NumberofRows > 0) { ?>
                                                <form id="frmUserEnquiryList" name="frmUserEnquiryList" action="wholesaler_support_enquiry_action.php" method="post">                                      
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>    
                                                            <tr>
                                                                <th class="hidden-480"><input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" /></th>
                                                                <?php echo $objPage->varSortColumn; ?>
                                                                <th>Action</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            $varPrevId = 0;
                                                            foreach ($objPage->arrRows as $val) {
                                                                ?>
                                                                <tr>
                                                                    <td class="hidden-480"><input style="width:20px; border:none;" type="checkbox" name="frmID[]" id="frmID[]"  value="<?php echo $val['pkSupportID']; ?>" onClick="singleSelectClick(this,'singleCheck');" class="singleCheck"/></td>
                                                                    <td><?php echo ($val['fkParentID'] <> $varPrevId) ? $val['fkParentID'] : ''; ?></td>
                                                                    <td class="hidden-480"><?php echo $val['Subject']; ?></td>
                                                                    <td><?php echo $val['wholesalerName']; ?></td>
                                                                    <td class="hidden-1024"><?php echo $val['wholesalerEmail']; ?></td>
                                                                    <td class="hidden-1024"><?php echo $val['wholesalerPhone']; ?></td>
                                                                    <td class="hidden-480"><?php echo $objCore->localDateTime($val['SupportDateAdded'], DATE_FORMAT_SITE); ?></td>                                            
                                                                    <td>
                                                                        <a href="wholesaler_support_outbox_view_uil.php?id=<?php echo $val['pkSupportID']; ?>&type=edit" class="btn" rel="tooltip" data-original-title="View"><i class="icon-eye-open"></i></a>                                           
                                                                        <a href="wholesaler_support_enquiry_action.php?frmID=<?php echo $val['pkSupportID']; ?>&frmChangeAction=Delete&frm=outbox" onClick="return fconfirm('Are you sure you want to delete this wholesaler support ?',this.href)" class="btn" rel="tooltip" title="" data-original-title="Delete"><i class="icon-remove"></i></a>
                                                                        &nbsp;
                                                                    </td>    

                                                                </tr>

                                                                <?php
                                                                $i++;
                                                                $varPrevId = $val['fkParentID'];
                                                            }
                                                            ?>
                                                        </tbody>                                       
                                                    </table>
                                                    <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate"><?php
                                                    if ($objPage->varNumberPages > 1) {
                                                        $objPage->displayPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                    }
                                                            ?></div>
                                                    <div class="controls hidden-480" style="margin: 1%;">
                                                        <select name="frmChangeAction" onChange="javascript:return setValidAction(this.value, this.form,'wholesaler support(s)');" ata-rule-required="true">
                                                            <option value="">-- Select Action --</option>
                                                            <option value="Delete All">Delete</option>
                                                        </select> 
                                                        <label for="textfield" class="control-label">This action will be performed on the above selected record(s). </label>
                                                    </div>
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