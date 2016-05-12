<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_LOGISTIC_PATH . FILENAME_ZONE_ADD_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Zone</title>
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
        <script type="text/javascript">
            var TitleName = null;
            var TitleId = null;
            JCal = jQuery.noConflict();
            JCal(function() {
                JCal('.datepicks').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" class="trigger">'});

            });
        </script>
        <style>
            .sucessmsg{
                color: green;
                padding-top: 10px;
            }
           
        </style>
    </head>
    <body>
        <?php require_once '../admin/inc/header_logistic.inc.php'; ?>
        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Manage Zone</h1>
                        </div>
                    </div>
                    <?php// require_once('javascript_disable_message.php'); ?>
                    <?php //if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-coupon', $_SESSION['sessAdminPerMission'])) { ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                <li><span>Manage Zone</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div class="fleft">
                                    <?php
                                     $objZoneGateway = new ZoneGatewayNew();
                                    $arrRecords = $objZoneGateway->checkzonecreateonece($_SESSION['sessLogistic']);
            //pre($arrRecords);
             if(empty($arrRecords[0]['zoneid']))
             {
                 ?>
                <a href="zone_add_uil.php"><button class="btn btn-inverse">Create New Zone</button></a>
         <?php    }
             else
             { ?>
              <a href="zone_edit_uil.php"><button class="btn btn-inverse">Edit Zone</button></a>  
         <?php    }
					
                                    ?>
<!--                                    <button class="btn btn-inverse" onclick="showSearchBox('search','show');">Search Zone </button>-->


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
                                        <form id="frmSearch" method="get" action="" class="form-horizontal form-bordered" onsubmit="return dateCompare('frmSearch');">
                                            <div class="row-fluid">
                                                <div class="row-fluid">
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Coupon Name:  </label>
                                                            <div class="controls">
                                                                <input type ="text" id="frmCouponName" name="frmCouponName" value="<?php echo stripslashes($_GET['frmCouponName']); ?>" class="input-large" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Coupon Code:  </label>
                                                            <div class="controls">
                                                                <input type ="text" id="frmCouponCode" name="frmCouponCode" value="<?php echo stripslashes($_GET['frmCouponCode']); ?>" class="input-large" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Discount(%):  </label>
                                                            <div class="controls">
                                                                <input type ="text" id="frmDiscount" name="frmDiscount" value="<?php echo stripslashes($_GET['frmDiscount']); ?>" class="input-large" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Start Date:  </label>
                                                            <div class="controls">
                                                                <input type ="text" class="input-medium datepicks" placeholder="Select Date" name="frmDateStart" value="<?php echo stripslashes($_GET['frmDateStart']); ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">End Date:  </label>
                                                            <div class="controls">
                                                                <input type ="text" class="input-medium datepicks" placeholder="Select Date" name="frmDateEnd" value="<?php echo stripslashes($_GET['frmDateEnd']); ?>"  />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="form-actions span12  search">
                                                        <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                        <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
                                                        <a  <?php if (isset($_REQUEST['frmSearch'])) { ?> href="coupon_manage_uil.php" <?php } else { ?> onclick="showSearchBox('search', 'hide');" <?php } ?> class="btn"><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></a>
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
                                 <p class="sucessmsg"></p>
                                <div class="box box-color box-bordered" >
                                    <div class="box-title">
                                        <h3>
                                            Zone List
                                        </h3>
                                    </div>
                                     <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php if ($objPage->NumberofRows > 0) { ?>
                                                <form id="frmUsersList" name="frmUsersList" action="coupon_action.php" method="post">
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
<!--                                                                <th class='with-checkbox hidden-480'><input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" /></th>
                                                                <?php echo $objPage->varSortColumn; ?>
                                                                <th class="hidden-480">
                                                                    Active (From-To Date)
                                                                </th>-->
                                                                <th>
                                                                    Title
                                                                </th>


                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($objPage->arrRows as $val) {
                                                                ?>

                                                                <tr>
                                                                     <td class="hidden-480"> <a href="#"  class="mytext"  data-toggle="modal" data-target="#myModal1" onclick="javascript : TitleName='<?php echo $val['title']; ?>',TitleId='<?php echo $val['zoneid']; ?>'" ><?php echo $val['title']; ?> </a></td>
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
<!--                                                    <div class="controls hidden-480" style="margin: 1%;">
                                                        <select name="frmChangeAction" onchange="javascript: return setValidAction(this.value, this.form, ' coupon(s)');" ata-rule-required="true">
                                                            <option value="">-- Select Action --</option>
                                                            <option value="Delete All">Delete</option>
                                                        </select>
                                                        <label for="textfield" class="control-label">This action will be performed on the above selected record(s). </label>
                                                    </div>-->
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
<!--                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php if ($objPage->NumberofRows > 0) { ?>
                                                <form id="frmUsersList" name="frmUsersList" action="coupon_action.php" method="post">
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
                                                                <th class='with-checkbox hidden-480'><input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" /></th>
                                                                <?php echo $objPage->varSortColumn; ?>
                                                                <th class="hidden-480">
                                                                    Active (From-To Date)
                                                                </th>
                                                                <th>
                                                                    Action
                                                                </th>


                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($objPage->arrRows as $val) {
                                                                ?>

                                                                <tr>
                                                                    <td class='with-checkbox hidden-480'><input style="width:20px; border:none;" type="checkbox" name="frmID[]" id="frmID[]"  value="<?php echo $val['pkCouponID']; ?>" onclick="singleSelectClick(this,'singleCheck');" class="singleCheck"/></td>
                                                                    <td><?php echo $val['CouponName']; ?></td>
                                                                    <td class="hidden-480"><?php echo $val['CouponCode']; ?> </td>
                                                                    <td class="hidden-350"><?php echo $val['Discount']; ?> </td>
                                                                    <td class="hidden-480"><?php echo date(DATE_FORMAT_SITE, strtotime($val['DateStart'])) . ' - ' . date(DATE_FORMAT_SITE, strtotime($val['DateEnd'])); ?></td>
                                                                    <td>
                                                                        <a class="btn" data-original-title="Edit" rel="tooltip" title="" href="coupon_edit_uil.php?id=<?php echo $val['pkCouponID']; ?>&type=edit"><i class="icon-edit"></i></a>
                                                                        <a class='btn' data-original-title="Delete" rel="tooltip" title="" href="coupon_action.php?frmID=<?php echo $val['pkCouponID']; ?>&frmChangeAction=Delete&deleteType=sD" onClick='return fconfirm("Are you sure you want to delete this discount coupon?",this.href);'><i class="icon-remove"></i></a>

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
                                                    <div class="controls hidden-480" style="margin: 1%;">
                                                        <select name="frmChangeAction" onchange="javascript: return setValidAction(this.value, this.form, ' coupon(s)');" ata-rule-required="true">
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
                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                <?php //} else { ?>
<!--                    <table width="100%">
                        <tr>
                            <th align="left">//<?php echo ADMIN_USER_PERMISSION_TITLE; ?></th>
                        </tr>
                        <tr>-->
<!--                            <td><?php// echo ADMIN_USER_PERMISSION_MSG; ?></td>
                        </tr>
                    </table>-->
                <?php //} ?>
            </div>
            <?php require_once('../admin/inc/footer.inc.php'); ?>
        </div>
        <div class="modal fade modalShowClass" id="myModal1" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Change Zone Name</h4>
            </div>
            <div class="modal-body">
                <form>
                    <table>
                        <tr>
                            <td><label name="zone" class="zonefix" >zone </label></td>
                            <td><input type="text" name="zonename" class="changetxt"value=""></td>
                        </tr>
                    
                    
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button name="frmBtnSubmit" type="submit" class="btn btn-blue change"  value="Change" >Change</button> 
<!--                <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>-->
            </div>
        </div>

    </div>
</div>
        <script type="text/javascript">
            
            
    $('#myModal1').on('show.bs.modal', function (e) {
       var text = TitleName;
var new_text = text.replace("zone", "");
       
      $('.changetxt').val(new_text);
        //console.log(TitleId);
        
        $('.change').on('click', function (e) {
            var changename=$('.changetxt').val();
            $.post("../admin/ajax.php", {
        action: "updatezonetitle",
        data: {id: TitleId, name: changename},

    }, function (e) {
       // $(".sucessmsg").html("<b> Title Changed Successfully</b>!");
        $(".close").click();
        location.reload();
        //$("#" + r).html(e)
       // $(".controles_" + jv + " .DyZoneDiv_" + jv).append(e)
    })

        });
       
    });

<?php if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') { ?>
        showSearchBox('search', 'show');
<?php } else { ?>
        showSearchBox('search', 'hide');
<?php } ?>
        </script>
    </body>
</html>