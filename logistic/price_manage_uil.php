<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_LOGISTIC_PATH . FILENAME_ZONE_PRICE_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?>: Manage Price</title>
        <link rel="shortcut icon" href="../admin/img/favicon.ico" />
        <?php require_once '../admin/inc/common_css_js.inc.php'; ?>
        <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>colorbox.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . 'common/css/jquery.autocomplete.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" media="all" />
        <script type='text/javascript' src="<?php echo SITE_ROOT_URL; ?>colorbox/jquery.colorbox.js"></script>
        <script type='text/javascript' src='<?php echo SITE_ROOT_URL . "common/js/jquery.autocomplete.js"; ?>'></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
        <style>
            .sucessmsg { color: green; padding-top: 10px; }
            .zone-fw { width:224px !important; border-radius:none; }
        </style>
    </head>
    <body>
        <?php require_once '../admin/inc/header_logistic.inc.php'; ?>
        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Manage Price</h1>
                        </div>
                    </div>
                    <?php // require_once('javascript_disable_message.php'); ?>
                    <?php //if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-coupon', $_SESSION['sessAdminPerMission'])) { ?>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><span>Manage price</span></li>
                        </ul>
                        <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12 margin_top20">
                            <div class="fleft"> <a href="price_add_uil.php">
                                    <button class="btn btn-inverse">Add Price</button>
                                </a>
                                <button class="btn btn-inverse" onClick="showSearchBox('search', 'show');">Search Zone Price </button>
                            </div>
<!--                            <div class="fright">
                                <input type="button" class="btn btn-primary" name="" data-toggle="modal" data-target="#myModal" value="Front Price">
                            </div>-->
                        </div>
                    </div>
                    <div class="row-fluid" id="search">
                        <div class="span12">
                            <div class="box box-color box-bordered">
                                <div class="box-title">
                                    <h3>Advance Search </h3>
                                </div>
                                <div class="box-content nopadding">
                                    <form id="frmSearch" method="get" action="" class="form-horizontal form-bordered" onSubmit="return dateCompare('frmSearch');">
                                        <div class="row-fluid">
                                            <div class="row-fluid">
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Zone Name: </label>
                                                        <div class="controls">
                                                            <?php
//pre($_GET);
                                                            $currentzonearry = $objGeneral->zonelistofcurrentlogist($_SESSION['sessLogistic']);
//$SelectedZone = $objPage->arrRow['detailById'][0]['zonetitleid'];stripslashes($_GET['frmCouponName']);
//$SelectedCountry = array();
                                                            $SelectedZone = $_GET['zoneid'];

                                                            echo $objGeneral->zonelistofcurrentlogistichtml($currentzonearry, 'zoneid', 'zoneid', $SelectedZone, 'Select Zone', 0, 'class="select2-me1 input-large zoneid zone-fw" ', 1, 0, 1);
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Method Name: </label>
                                                        <div class="controls">
                                                            <?php
                                                            $shippingmethodarray = $objGeneral->shippingmethodlist();

                                                            $Selectedshippingmethod = $_GET['shippingmethod'];

                                                            echo $objGeneral->shippingmethodlisthtml($shippingmethodarray, 'shippingmethod', 'shippingmethodid', $Selectedshippingmethod, 'Select Shipping Method', 0, 'class="select2-me input-large zone-fw" ', 1, 0, 1);
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">&nbsp;</label>
                                                        <div class="controls">
                                                            &nbsp;</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Minimum Weight: </label>
                                                        <div class="controls">
                                                            <input type ="text" id="frmDiscount" name="minweight" value="<?php echo stripslashes($_GET['minweight']); ?>" class="input-large" placeholder="Min kg" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Maximum Weight: </label>
                                                        <div class="controls">
                                                            <input type ="text" id="frmDiscount" name="maxweight" value="<?php echo stripslashes($_GET['maxweight']); ?>" class="input-large" placeholder="Max kg" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Cost Price: </label>
                                                        <div class="controls">
                                                            <input type ="text" id="frmDiscount" name="cost" value="<?php echo stripslashes($_GET['cost']); ?>" class="input-large" placeholder="cost" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="form-actions span12  search">
                                                    <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                    <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
                                                    <a  <?php if (isset($_REQUEST['frmSearch'])) { ?> href="price_manage_uil.php" <?php } else { ?> onClick="showSearchBox('search', 'hide');" <?php } ?> class="btn"><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></a> </div>
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
                            <p class="sucessmsg"></p>
                            <div class="box box-color box-bordered" >
                                <div class="box-title">
                                    <h3> Zones Price List </h3>
                                </div>
                                <div class="box-content nopadding manage_categories">
                                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                        <?php if ($objPage->NumberofRows > 0) { ?>
                                            <form id="frmUsersList" name="frmUsersList" action="coupon_action.php" method="post">
                                                <table class="table table-hover table-nomargin table-bordered usertable">
                                                    <thead>
                                                        <tr> 
                                                          <!--                                                                <th class='with-checkbox hidden-480'><input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" /></th>--> 
                                                            <?php echo $objPage->varSortColumn; ?> 
                                                          <!--                                                                <th>
                                                                                            Zone
                                                                                          </th>
                                                                                          <th>
                                                                                             Method
                                                                                          </th>
                                                                                          <th>
                                                                                             Maximum Dimension
                                                                                          </th>
                                                                                          <th>
                                                                                            Minimum Weight(kg)
                                                                                          </th>
                                                                                          <th>
                                                                                            
                                                                                              Maximum Weight(kg)
                                                                                          </th>
                                                                                          <th>
                                                                                            Cost Per Kg($)
                                                                                          </th>-->
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
//                                                        pre($objPage->arrRows);
                                                        $i = 1;
                                                        foreach ($objPage->arrRows as $val) {
                                                            $dimention = $val['maxlength'] . 'X' . $val['maxwidth'] . 'X' . $val['maxheight'];
                                                            ?>
                                                            <tr>
                                                                <td class="hidden-480"><?php echo $val['title']; ?></td>
                                                                <td class="hidden-480"><?php
                                                                    $varmethodname = $objGeneral->getshippingmethodnamebyid($val['shippingmethod']);
                                                                    echo $varmethodname[0]['MethodName'];
                                                                    ?></td>
                                                                <td class="hidden-480"><?php echo $dimention; ?></td>
                                                                <td class="hidden-480"><?php echo $val['minkg']; ?></td>
                                                                <td class="hidden-480"><?php echo $val['maxkg']; ?></td>
                                                                <td class="hidden-480"><?php echo $val['costperkg']; ?></td>
                                                                <td class="hidden-480">
                                                                    <?php
                                                                    if ($val['pricestatus'] == 1) {
                                                                        echo 'Accepted';
                                                                    } else if ($val['pricestatus'] == 2) {
                                                                        echo 'Rejected';
                                                                    } else {
                                                                        echo 'Pending';
                                                                    }
                                                                    ?></td>
                                                                <td>
                                                                    <a class="btn" rel="tooltip" title="Edit" href="price_edit_uil.php?type=edit&id=<?php echo $val['pkpriceid']; ?>">
                                                                        <i class="icon-edit"></i>
                                                                    </a> 
        <!--                                                                    <a class='btn' rel="tooltip" title="Delete" href="zonepriceaction.php?frmID=<?php echo $val['pkpriceid']; ?>&frmChangeAction=Delete&deleteType=sD" onClick="return fconfirm('Are you sure you want to delete this zone price ?', this.href)">
                                                                        <i class="icon-remove"></i>
                                                                    </a>-->
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
                                                    <?php
                                                    if ($objPage->varNumberPages > 1) {
                                                        $objPage->displayPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                    }
                                                    ?>
                                                </div>

                                            </form>
                                        <?php } else { ?>
                                            <table class="table table-hover table-nomargin table-bordered usertable">
                                                <tr class="content">
                                                    <td colspan="10" style="text-align:center"><strong>No record(s) found.</strong></td>
                                                </tr>
                                            </table>
                                        <?php } ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <?php //} else {   ?>
                <!--                    <table width="100%">
                            <tr>
                                <th align="left">//<?php echo ADMIN_USER_PERMISSION_TITLE; ?></th>
                            </tr>
                            <tr>--> 
                <!--                            <td><?php // echo ADMIN_USER_PERMISSION_MSG;                        ?></td>
                            </tr>
                        </table>-->
                <?php //}   ?>
            </div>
            <?php require_once('../admin/inc/footer.inc.php'); ?>
        </div>
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-lg"> 

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> Front Shipping Price</h4>
                    </div>
                    <div class="modal-body">

                        <table class="table table-hover table-nomargin table-bordered">
                            <tr>
                                <th>Zone</th>
                                <th>Method</th>
                                <th>Minimum Weight(kg)</th>
                                <th>Maximum Weight(kg)</th>
                                <th>Cost Per Kg($)</th>
                            </tr>
                            <?php foreach ($objPage->frontRows as $key => $value) { ?>
                                <tr>
                                    <td><?php echo $value['title'] ?></td>
                                    <td><?php echo $value['MethodName'] ?></td>
                                    <td><?php echo $value['minkg'] ?></td>
                                    <td><?php echo $value['maxkg'] ?></td>
                                    <td><?php echo $value['costperkg'] ?></td>
                                </tr>
                            <?php } ?>
                        </table>

                    </div>
                    <div class="modal-footer">
                        <!--<button name="frmBtnSubmit" type="submit" class="btn btn-blue change"  value="Change" >Change</button>-->
                        <!--                <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>--> 
                    </div>
                </div>
            </div>
        </div>
        <?php
//        pre();
        ?>
    </body>
</html>
<script type="text/javascript">
<?php if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') { ?>
        showSearchBox('search', 'show');
<?php } else { ?>
        showSearchBox('search', 'hide');
<?php } ?>
</script>