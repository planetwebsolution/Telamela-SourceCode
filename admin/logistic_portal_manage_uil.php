<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_LOGICTIC_Portal_CTRL;
require_once CLASSES_ADMIN_PATH . 'class_adminuser_bll.php';
//pre(CONTROLLERS_ADMIN_PATH . FILENAME_LOGICTIC_Portal_CTRL);
//pre($_SESSION['sessAdminPerMission']);
global $objGeneral;
//pre($_SESSION);
$objUser = new AdminUser();
$arrPortal = $objUser->getPortal();

foreach ($arrPortal as $k => $v) {
    $PortalIDs[] = $v['AdminCountry'];
}
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Logistic Portal</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>

        <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>colorbox.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . 'common/css/jquery.autocomplete.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" media="all" />
        <script type='text/javascript' src="<?php echo SITE_ROOT_URL; ?>colorbox/jquery.colorbox.js"></script>
        <script type='text/javascript' src='<?php echo SITE_ROOT_URL . "common/js/jquery.autocomplete.js"; ?>'></script>
        <script type="text/javascript">
             function changeStatus(status, sgid) {

                $.ajax({
                    url: 'ajax.php',
                    type: "POST",
                    data: {action: 'Changelogisticportalstatus', status: status, sgid: sgid},
                    //contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function (data) {
//                        var data1 = JSON.stringify(data);

                        $('.sg' + sgid).html(data.html);

                        if (data.status == "exist")
                        {
                            // $("#sortable_msg").html("Order updated successfully.").removeClass("bg-danger hidden").addClass("bg-success");
                            //$(".sucessmsg").html("<b>Status decactive Successfully</b>!").removeClass("success").addClass("error");
                            $(".error").html("<b>This Logistic Portal is used, can not Deactivate.</b>!");
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
//            function changeStatus(status, sgid) {
//
//                var statuss = status;
//                console.log(statuss);
//                $.post("ajax.php", {action: 'Changelogisticportalstatus', status: status, sgid: sgid},
//                function (data) {
//                    
//                    $('.sg' + sgid).html(data);
//                    //alert(data);
//
//
//
//                });
//                if (statuss == "0")
//                {
//                    // $("#sortable_msg").html("Order updated successfully.").removeClass("bg-danger hidden").addClass("bg-success");
//                    //$(".sucessmsg").html("<b>Status decactive Successfully</b>!").removeClass("success").addClass("error");
//                    $(".sucessmsg").html("<b>Status Updated Successfully</b>!");
//                    $(".sucessmsg").css('display','block');
//                }
//                if (statuss == "1")
//                {
//                    $(".sucessmsg").html("<b>Status Updated Successfully</b>!");
//                    $(".sucessmsg").css('display','block');
//                }
//
//                setTimeout(function() { $(".sucessmsg").hide(); }, 3000);
//                // $objCore->setSuccessMsg("Status change Successfully");
//            }



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
        <?php
        require_once 'inc/header_new.inc.php';
        // echo $sucessmsg;
        ?>
        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Manage Logistic Portal</h1>
                        </div>
                    </div>
                    <?php
                    //pre($_SESSION);
                    require_once('javascript_disable_message.php');
                    ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('Listing- Logistic- Portal', $_SESSION['sessAdminPerMission'])) {
                        ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                <li><span>Manage Logistic Portal</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div class="fleft">
                                    <button class="btn btn-inverse" onClick="showSearchBox('search', 'show');">Search Logistic Portal </button>
                                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('Listing- Logistic- Portal', $_SESSION['sessAdminPerMission'])) {
                                        ?>
                                        <a href="logistic_add_uil.php?type=cp"><button class="btn btn-inverse">Add New Logistic Portal </button></a>
                                    <?php } ?>
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
                                        <form id="frmSearch" method="get" action="" class="form-horizontal form-bordered" onSubmit="return dateCompare('frmSearch');">
                                            <div class="row-fluid">
                                                <div class="row-fluid">
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Logistic Title:  </label>
                                                            <div class="controls">
                                                                <input type ="text" id="frmTitle" name="frmTitle" value="<?php echo stripslashes($_GET['frmTitle']); ?>" class="input-large" placeholder="" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    //pre($_SESSION);
                                                    if ($_SESSION['sessUserType'] != 'user-admin') {
                                                        $varWhereClause .= "  logisticportal = '" . $_SESSION['sessAdminCountry'] . "'";
                                                        ?>
                                                        <div class="span4 ">
                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">Country Portal: </label>
                                                                <div class="controls">
                                                                    <div id="" class="input_sec input_star input_boxes multiple <?php
                                                                    $abc = $objGeneral->getCountry();
                                                                    //echo ($productmulcountrydetail[0]['producttype'] == 'multiple') ? '' : 'mulcountries';   
                                                                    ?> ">
                                                                        <select name="CountryPortalID" class='select2-me input-large nomargin'>
                                                                            <option value="0" <?php
                                                                            if ($_GET['frmCountry'] == '0') {
                                                                                echo 'Selected';
                                                                            }
                                                                            ?>>All Country</option>
                                                                                    <?php foreach ($abc as $vCT) {
                                                                                        if(in_array($vCT['country_id'], $PortalIDs)){
                                                                                        ?>
                                                                                <option value="<?php echo $vCT['country_id']; ?>" <?php
                                                                                if ($_GET['frmCountry'] == $vCT['country_id']) {
                                                                                    echo 'Selected';
                                                                                }
                                                                                ?>><?php echo html_entity_decode($vCT['name']); ?>
                                                                                </option>
                                                                                    <?php }} ?>
                                                                        </select>
                                                                        <?php
//                                                                        $abc = $objGeneral->getCountryPortal();
//                                                                        
//                                                                        if($_GET['CountryPortalID'])
//                                                                        {
//                                                                        	$logisticportalselectedid=$_GET['CountryPortalID'];
//                                                                        }
//                                                                        else {
//                                                                        	$logisticportalselectedid=null;
//                                                                        }
//                                                                        echo $objGeneral->CountryPortalHtml($abc, 'CountryPortalID', 'pkAdminID', $logisticportalselectedid, 'Select Country Portal', 0, '1', '1');
//                                                                        
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php } ?>
                                                    <div class="span4">
                                                        <div class="control-group">
                                                            <label for="textfield" class="control-label">Status:  </label>
                                                            <div class="controls">
                                                                <select name="frmStatus" class='select2-me input-large'>
                                                                    <option value="Active" <?php
                                                                    if ($_GET['frmStatus'] == 'Active') {
                                                                        echo 'Selected';
                                                                    }
                                                                    ?>>Active</option>
                                                                    <option value="Inactive" <?php
                                                                    if ($_GET['frmStatus'] == 'Inactive') {
                                                                        echo 'Selected';
                                                                    }
                                                                    ?>>Deactive</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <div class="form-actions span12 search">

                                                        <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                                                        <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
                                                        <?php if ($_GET['frmSearch'] != '') {
                                                            ?>
                                                            <input type="button" onClick="location.href = 'logistic_portal_manage_uil.php'" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <input type="button" onClick="showSearchBox('search', 'hide');" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" class="btn" />
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
                            <div class="span12 av">
                                <?php
                                //pre($objCore->displaySessMsg());
                                if ($objCore->displaySessMsg() != '') {
                                    echo $objCore->displaySessMsg();
                                    $objCore->setSuccessMsg('');
                                    $objCore->setErrorMsg('');
                                }
                                //pre($objPage);
                                //pre("here");
                                ?>
                                <p class="sucessmsg"></p>
                                <p class="error"></p>
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>
                                            Manage Logistic Portal
                                        </h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php if ($objPage->NumberofRows > 0) {
                                                ?>
                                                <form id="frmCountryPortalList" name="frmCountryPortalList" action="" method="post">
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
                                                                <th class='hidden-480'>Company Name</th>

                                                                <th class='hidden-480'>User Name</th>

                                                                <th class='hidden-1024'>Email</th>
                                                                <th class='hidden-1024'>Country Name</th>

                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($objPage->arrRows as $val) {
                                                                ?>
                                                                <tr>
                                                                    <?php
                                                                    // pre($varportalname);
                                                                    ?>
                                                                    <td><a href="logistic_add_uil.php?UserID=<?php echo $val['logisticportalid']; ?>&type=portal"><?php echo $val['logisticTitle']; ?></a></td>
                                                                    <td><?php echo $val['logisticUserName']; ?></td>
                                                                    <td class="hidden-480"><?php echo $val['logisticEmail']; ?></td>

                                                                    <td class="hidden-480"><?php
                                                                        $varportalname = $objGeneral->getcountrynamebyid($val['logisticportal']);
                                                                        echo $varportalname[0]['name'];
                                                                        ?></td>
                                                                    <td class="hidden-480">
                                                                        <span class="sg<?php echo $val['logisticportalid']; ?>">
                                                                            <?php if (empty($val['logisticStatus'])) { ?>
                                                                                <a href="javascript:void(0);" title="click for active" class="active" onclick="changeStatus(1,<?php echo $val['logisticportalid']; ?>)">Active</a>
                                                                                <?php
                                                                            } else {
                                                                                echo '<span class="label label-satgreen">Active</span>';
                                                                            }
                                                                            ?>
                                                                            <?php if (!empty($val['logisticStatus'])) { ?>
                                                                                <a href="javascript:void(0);" title="click for deactive" class="deactive" onclick="changeStatus(0,<?php echo $val['logisticportalid']; ?>)">Deactive</a>
                                                                                <?php
                                                                            } else {
                                                                                echo '<a  href="" class="label label label-lightred">Deactive</a>';
                                                                            }
                                                                            ?>
                                                                        </span>


                                                                        <?php //echo $val['logisticStatus']; ?></td>

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
                                                <?php
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
                    <?php
                } else {
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
<?php if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') {
    ?>
                showSearchBox('search', 'show');
    <?php
} else {
    ?>
                showSearchBox('search', 'hide');
<?php } ?>
        </script>
    </body>
</html>