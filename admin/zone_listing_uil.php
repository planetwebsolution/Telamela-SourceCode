<?php
//phpinfo();die;
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_ZONE_CTRL;
require_once CLASSES_ADMIN_PATH . 'class_adminuser_bll.php';
//pre(CONTROLLERS_ADMIN_PATH . FILENAME_LOGICTIC_Portal_CTRL);
//pre($objPage);
global $objGeneral;

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
                            <h1>Zones</h1>
                        </div>
                    </div>
                    <?php
                    // pre($_SESSION['sessAdminPerMission']);
                    require_once('javascript_disable_message.php');
                    ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin') {
                        ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                <li>
                                    <a href="zone_manage_uil.php">Logistic companies</a>
                                    <i class="icon-angle-right"></i>
                                </li>
                                <li><span>Manage Zones</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>

                        <div class="row-fluid">
                            <div class="span12 margin_top20">
                                <div class="fleft">
                                    <!--<button class="btn btn-inverse" onClick="showSearchBox('search', 'show');">Search </button>-->
                                    <a href="zone_add_uil.php?type=add&LogisticId=<?php echo $objPage->logisticId; ?>&countryId=<?php echo $objPage->countryId; ?>"><button class="btn btn-inverse">Add New</button></a>
                                </div>
                                <div class="fright">

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
//                                pre($objPage->arrRows);
                                //pre("here");
                                ?>
                                <p class="sucessmsg"></p>
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>
                                            Manage Zones
                                        </h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php if (!empty($objPage->zoneListing)) {
                                                ?>
                                                <form id="frmCountryPortalList" name="frmCountryPortalList" action="" method="post">
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>
                                                            <tr>
                                                                <th class='hidden-480'>Zone Name</th>
                                                                <th class='hidden-480'>Logistic Company</th>

                                                                <th class='hidden-1024'>Action</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
//                                                            pre($objPage->zoneListing);
                                                            foreach ($objPage->zoneListing as $val) {
                                                                ?>
                                                                <tr>
                                                                    <?php
//                                                                     pre($val);
                                                                    ?>
                                                                    <!--<td><a href="ship_price_detail_uil.php?EditId=<?php // echo $val['pkpriceid'];   ?>&type=edit"><?php // echo $val['logisticTitle'];   ?></a></td>-->
                                                                    <td><?php echo $val['title']; ?></td>
                                                                    <td><?php echo $objPage->LogisticDetail[0]['logisticTitle']; ?></td>

                                                                                                                                <!--<td class="hidden-480"><?php //echo $val['modified'];      ?></td>-->
                                                                    <td class="hidden-480">
                                                                        <?php /*<a class="btn" href="zone_add_uil.php?type=add&LogisticId=<?php echo $objPage->logisticId; ?>&countryId=<?php echo $objPage->countryId; ?>" rel="tooltip" title="" data-original-title="Add zone">
                                                                            <i class="icon-plus">
                                                                            </i>
                                                                        </a> */ ?>
                                                                        <a class="btn" href="zone_detail_edit_uil1.php?type=editzonedetail&LogisticId=<?php echo $val['fklogisticid'];?>&zoneid=<?php echo $val['zoneid'];?>&countryId=<?php echo $objPage->countryId;?>" rel="tooltip" title="" data-original-title="Edit zones">
                                                                        <!--<a class="btn" href="zone_detail_edit_uil.php" rel="tooltip" title="" data-original-title="Edit zones">-->
                                                                            <i class="icon-eye-open">
                                                                            </i>
                                                                        </a>
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