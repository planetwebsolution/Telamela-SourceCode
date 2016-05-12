<?php
//phpinfo();die;
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_SHIP_PRICE_CTRL;
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
                            <h1>Shipping Price Details</h1>
                        </div>
                    </div>
                    <?php
                    // pre($_SESSION['sessAdminPerMission']);
                    require_once('javascript_disable_message.php');
                    ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('Listing- Logistic- Portal', $_SESSION['sessAdminPerMission'])) {
                        ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                                <li><a href="ship_price_manage_uil1.php">Manage Price</a><i class="icon-angle-right"></i></li>
                                <li><span>Details Shipping Price</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>

                        <div class="row-fluid">
                            <div class="span12 av">
                                <?php
//                                pre($objPage->arrDetail);
                                if ($objCore->displaySessMsg() != '') {
                                    echo $objCore->displaySessMsg();
                                    $objCore->setSuccessMsg('');
                                    $objCore->setErrorMsg('');
                                }
//                                pre($objPage->arrDetail[0]);
                                //pre("here");
                                ?>
                                <p class="sucessmsg"></p>
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>
                                            Shipping Price Details
                                        </h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php // pre($objPage->arrDetail);
                                            ?>

                                            <table class="table table-bordered dataTable-scroll-x" >
                                                <tr>
                                                    <td style="width: 20%;"> Zone Name</td>
                                                    <td><?php echo $objPage->arrDetail[0]['title']; ?></td>


                                                </tr>
                                                <tr>
                                                    <td> Shipping Method</td>
                                                    <td><?php echo $objPage->arrDetail[0]['MethodName']; ?></td>


                                                </tr>
                                                <tr>
                                                    <td> From Address</td>
                                                    <td><?php echo (!empty($objPage->arrDetail[0]['fromcityName']) ? $objPage->arrDetail[0]['fromcityName'] . ', ' : '') . (!empty($objPage->arrDetail[0]['fromstateName']) ? $objPage->arrDetail[0]['fromstateName'] . ', ' : '') . (!empty($objPage->arrDetail[0]['frmCountryName']) ? $objPage->arrDetail[0]['frmCountryName'] : ''); ?></td>


                                                </tr>
                                                <tr>
                                                    <td> To Address</td>
                                                    <td><?php echo (!empty($objPage->arrDetail[0]['tocityName']) ? $objPage->arrDetail[0]['tocityName'] . ', ' : '') . (!empty($objPage->arrDetail[0]['tostateName']) ? $objPage->arrDetail[0]['tostateName'] . ', ' : '') . (!empty($objPage->arrDetail[0]['toCountryName']) ? $objPage->arrDetail[0]['toCountryName'] : ''); ?></td>

                                                </tr>
                                                <tr>
                                                    <td> Maximum Dimension(L*W*H)</td>
                                                    <td><?php echo $objPage->arrDetail[0]['maxlength'] . '*' . $objPage->arrDetail[0]['maxwidth'] . '*' . $objPage->arrDetail[0]['maxheight']; ?></td>

                                                </tr>
                                                <tr>
                                                    <td>Min. Weight(kg)</td>
                                                    <td><?php echo $objPage->arrDetail[0]['minkg']; ?></td>

                                                </tr>
                                                <tr>
                                                    <td>Max. Weight(kg)</td>
                                                    <td><?php echo $objPage->arrDetail[0]['maxkg']; ?></td>

                                                </tr>


                                                <tr>
                                                    <td> Cost Per Kg</td>
                                                    <td><?php echo $objPage->arrDetail[0]['costperkg']; ?></td>

                                                </tr>
                                                <tr>
                                                    <td> Handling cost ($) per item</td>
                                                    <td><?php echo $objPage->arrDetail[0]['handlingcost']; ?></td>

                                                </tr>
                                                <tr>
                                                    <td> Fragile Handling cost ($)</td>
                                                    <td><?php echo $objPage->arrDetail[0]['fragilecost']; ?></td>

                                                </tr>
                                                <tr>
                                                    <td> Delivery (Days)</td>
                                                    <td><?php echo $objPage->arrDetail[0]['deliveryday']; ?></td>

                                                </tr>
                                                <tr>
                                                    <td> Cubic weight (cm3/kg)</td>
                                                    <td><?php echo $objPage->arrDetail[0]['cubicweight']; ?></td>

                                                </tr>
                                            </table>
                                            <form id="" name="" action="ship_price_detail_uil.php" method="post">
                                                <div class="form-actions formactionleft">     
                                                    <input type="hidden" value="<?php echo $objPage->arrDetail[0]['pkpriceid']; ?>" name="pkpriceid" >
                                                    <!--<input type="hidden" value="approved" name="approveForm" >-->
                                                    <button style="margin-left: -8px;" name="approveForm" type="submit" class="btn btn-blue" <?php echo ($objPage->arrDetail[0]['pricestatus'] == 1) ? 'disabled' : ''; ?>  value="approved" ><?php echo ($objPage->arrDetail[0]['pricestatus'] == 1) ? 'Approved' : 'Approve'; ?></button>  
                                                    <?php if($objPage->arrDetail[0]['pricestatus'] != 1){ ?>

                                                    <button style="" type="submit" name="rejectForm" class="btn btn-blue" <?php echo ($objPage->arrDetail[0]['pricestatus'] == 2) ? 'disabled' : ''; ?>  value="rejected" ><?php echo ($objPage->arrDetail[0]['pricestatus'] == 2) ? 'Rejected' : 'Reject'; ?></button>  
                                                    <?php } ?>
                                                </div>
                                            </form>

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