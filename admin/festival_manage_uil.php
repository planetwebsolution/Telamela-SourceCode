<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_FESTIVAL_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Home Banner</title>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <script type="text/javascript">
            Cal=jQuery.noConflict();
            Cal(document).ready(function(){
                $('.saveorder').click(function(){
                    $("#frmHomeBanner").submit();
                });    
            });
        </script>
        <?php require_once 'inc/common_css_js.inc.php'; ?>

        <script type="text/javascript">
            function changeStatus(status,bid){
                
                    var showid = '#banner'+bid;
                    $.post("ajax.php",{action:'ChangeFestivalStatus',status:status,bid:bid},
                    function(data)
                    {
                        $(showid).html(data);
                        popClose('modal--1');
                    });
                
                
            }
            
            function fconfirm1(e,t,n){
                //alert(t+'=='+n);
                return $("body").append('<div id="modalOverlay"> </div>'),$("body").append('<div id="modal--1" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-header box-title"><button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="popClose(\'modal--1\')">X</button><h3 id="myModalLabel">!</h3></div><div class="modal-body"><p>'+e+'</p></div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true" onclick="return changeStatus('+t+','+n+')">OK</button><button class="btn" data-dismiss="modal" aria-hidden="true" onclick="popClose(\'modal--1\')">Cancel</button></div></div>'),!1
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
                            <h1>Manage Festival</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-home-slider', $_SESSION['sessAdminPerMission'])) { ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                <li><a href="cms_manage_uil.php">Content</a><i class="icon-angle-right"></i></li>
                                <li><span>Manage Festival</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div class="fleft">
                                    <button class="btn btn-inverse" onclick="showSearchBox('search','show');">Search Festival</button>
                                    <a href="festival_add_uil.php?type=add"><button class="btn btn-inverse">Create New</button></a>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid" id="search">
                            <div class="span12">
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>Advance Search</h3>
                                    </div>
                                    <div class="box-content nopadding">
                                        <form id="frmSearch" method="get" action="" class="form-horizontal form-bordered">
                                            <div class="row-fluid">
                                                <div class="row-fluid">                                                    
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Title:</label>
                                                            <div class="controls">
                                                                <input type="text" name="frmTitle" id="frmTitle" value="<?php echo $_GET['frmTitle']; ?>" class="input-large" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Country:</label>
                                                            <div class="controls">
                                                                <select name="frmCountry" class="select2-me input-large">
                                                                    <option value="">Select</option>
                                                                    <option value="0" <?php echo ($_GET['frmCountry'] == '0') ? 'selected="selected"' : '' ?>>All Country</option>
                                                                    <?php
                                                                    $arrCountry[0]['country_id'] = '0';
                                                                    $arrCountry[0]['name'] = 'Default';
                                                                    foreach ($objPage->arrCountry as $v) {
                                                                        $arrCountry[$v['country_id']] = $v;
                                                                        ?>
                                                                        <option value="<?php echo $v['country_id']; ?>" <?php echo ($_GET['frmCountry'] == $v['country_id']) ? 'selected="selected"' : '' ?>><?php echo $v['name']; ?></option>
                                                                    <?php } ?>
                                                                </select>                                                                
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Status:</label>
                                                            <div class="controls">
                                                                <select name="frmStatus" class="select2-me input-large">
                                                                    <option value="1" <?php
                                                                if ($_GET['frmStatus'] == '1') {
                                                                    echo 'Selected';
                                                                }
                                                                    ?>>Active</option>
                                                                    <option value="0" <?php
                                                                        if ($_GET['frmStatus'] == '0') {
                                                                            echo 'Selected';
                                                                        }
                                                                    ?>>Deactive</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="form-actions span12  search">
                                                        <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                        <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
                                                        <a <?php if (isset($_GET['frmSearchPressed'])) { ?> href="festival_manage_uil.php" <?php } else { ?>onclick="showSearchBox('search','hide');" <?php } ?>><input type="button" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" /></a>
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
                                if ($objCore->displaySessMsg() <> '') {
                                    echo $objCore->displaySessMsg();
                                    $objCore->setSuccessMsg('');
                                    $objCore->setErrorMsg('');
                                }
                                ?>
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>Manage Festival</h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php if ($objPage->NumberofRows > 0) { ?>
                                                <form id="frmHomeBanner" name="frmHomeBanner" action="" method="post">
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
                                                                <th class='with-checkbox hidden-480'><input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" /></th>
                                                                <?php 
                                                               // pre($objPage->varSortColumn);
                                                                echo $objPage->varSortColumn; ?>                                                                
                                                                <th class='hidden-1024'>Display Order <input type="hidden" name="frmUpdateOrder" id="frmUpdateOrder" value="order" /><a title="Save Order" class="saveorder" href="javascript: void(0);"></a></th>
                                                                <th class='hidden-480'>Status </th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($objPage->arrRows as $val) { 
                                                                ?>
                                                                <tr>
                                                                    <td class='with-checkbox hidden-480'>
                                                                        <input style="width:20px; border:none;" type="checkbox" name="frmID[]" id="frmID[]"  value="<?php echo $val['pkFestivalID']; ?>" onclick="singleSelectClick(this,'singleCheck');" class="singleCheck"/>
                                                                    </td>
                                                                  <td><?php echo $val['pkFestivalID'] ?></td>
                                                                   <td><a href="<?php echo $objCore->getUrl('special.php', array('name' => $val['FestivalTitle'],'cid'=>$val['pkFestivalID'])); ?>" target="_bank" class="whl-app-link"><?php echo ucwords($val['FestivalTitle']) ?></a></td>
                                                                    <td class="hidden-480"><?php echo $objCore->localDateTime($val['FestivalStartDate'], DATE_FORMAT_SITE); ?></td>
                                                                    <td class="hidden-480"><?php echo $objCore->localDateTime($val['FestivalEndDate'], DATE_FORMAT_SITE); ?></td>                                                                    
                                                                    <td class='hidden-1024'>
                                                                        <input type="text" onblur="return order_validation(this.value,'frmOrderId<?php echo $val['pkFestivalID']; ?>')" id="frmOrderId<?php echo $val['pkFestivalID']; ?>" class="input-small" value="<?php echo $val['FestivalOrder']; ?>" size="4" name="order[]" >
                                                                        <input type="hidden" value="<?php echo $val['pkFestivalID']; ?>" name="orderId[]">
                                                                    </td>
                                                                    <td class='hidden-480'>
                                                                        <span id="banner<?php echo $val['pkFestivalID']; ?>">
                                                                            <?php if (empty($val['FestivalStatus'])) { ?><a href="javascript:void(0);" class="active" onclick="fconfirm1('Are you sure you want to activate the banner?','1',<?php echo $val['pkFestivalID']; ?>)" title="Click here to active this banner.">Active</a><?php
                                                            } else {
                                                                echo '<span class="label label-satgreen">Active</span>';
                                                            }
                                                                            ?>

                                                                            <?php if (!empty($val['FestivalStatus'])) { ?><a href="javascript:void(0);" class="deactive" onclick="fconfirm1('Are you sure you want to deactivate the banner ?','0',<?php echo $val['pkFestivalID']; ?>)" title="Click here to deactive this banner.">Deactive</a><?php
                                                            } else {
                                                                echo '<span  class="label label label-lightred">Deactive</span>';
                                                            }
                                                                            ?>
                                                                        </span>
                                                                    </td>                                                                   
                                                                    <td>
                                                                        <a class="btn" data-original-title="Edit" rel="tooltip" title="" href="festival_edit_uil.php?id=<?php echo $val['pkFestivalID']; ?>&type=edit"><i class="icon-edit"></i></a>
                                                                        <a class='btn' data-original-title="Delete" rel="tooltip" title="" href="festival_action.php?frmID=<?php echo $val['pkFestivalID']; ?>&frmChangeAction=Delete&deleteType=sD" onClick='return fconfirm("Are you sure you want to delete this festival ?",this.href);'><i class="icon-remove"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <?php
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
                                                        <select name="frmChangeAction" onchange="javascript: return setValidAction(this.value, this.form, ' festival(s)');" ata-rule-required="true">
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
        <script type="text/javascript">
<?php if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') { ?>
        showSearchBox('search', 'show');
<?php } else { ?>
        showSearchBox('search', 'hide');
<?php } ?>
        </script>
    </body>
</html>