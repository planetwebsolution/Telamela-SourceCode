<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_WHOLESALER_SPECIAL_APPLICATION_CTRL;

$varNum = count($objPage->arrRow['details']['pkApplicationID']);
//pre($objPage->arrSoldProductDetails);
//print_r($objPage->arrPaidInvoiceProductDetails);
//print_r($objPage->arrUnPaidInvoiceProductDetails);
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : View Wholesaler</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
    </head>
    <body>

        <?php require_once 'inc/header_new.inc.php'; ?>

        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>View Special Application</h1>
                        </div>
                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="wholesaler_special_application_manage_uil.php">Special Application</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
<!--                                <a href="wholesaler_special_application_view_uil.php?id=<?php echo $_GET['id']; ?>&type=view">View Special Application</a>-->
                                <span>View Special Application</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <div class="tab-pane active" id="tabs-2">
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="box box-color box-bordered">
                                            <?php
                                            if ($objCore->displaySessMsg())
                                            {
                                                echo $objCore->displaySessMsg();
                                                $objCore->setSuccessMsg('');
                                                $objCore->setErrorMsg('');
                                            }
                                            ?>
                                            <div class="box-title">
                                                <a id="buttonDecoration" href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                                <h3>
                                                    View Special Application
                                                </h3>
                                            </div>
                                            <div class="box-content nopadding">
                                                <?php require_once('javascript_disable_message.php'); ?>
<?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-wholesalers', $_SESSION['sessAdminPerMission']) || in_array('manage-wholesaler-applications', $_SESSION['sessAdminPerMission']))
{ ?>
                                                    <div >&nbsp;</div>
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
    <?php if ($varNum > 0)
    { ?>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Application ID: </td>
                                                                    <td>
        <?php echo $objPage->arrRow['details']['pkApplicationID']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Transaction ID: </td>
                                                                    <td>
        <?php echo $objPage->arrRow['details']['TransactionID']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Wholesaler Name: </td>
                                                                    <td>
        <?php echo $objPage->arrRow['details']['CompanyName']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Specials/Events: </td>
                                                                    <td>
        <?php echo $objPage->arrRow['details']['FestivalTitle']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Country: </td>
                                                                    <td>
        <?php echo $objPage->arrRow['details']['CountryName']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Amount: </td>
                                                                    <td>
        <?php echo $objPage->arrRow['details']['TotalAmount']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Status: </td>
                                                                    <td>
        <?php echo $objPage->arrRow['details']['IsApproved']; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2" class="detailshead">Category Details</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Category Name</th>
                                                                    <th>Product Quantiy</th>
                                                                </tr>
        <?php foreach ($objPage->arrRow['cat'] as $k => $v)
        { ?>
                                                                    <tr>
                                                                        <td><?php echo $v['CategoryName']; ?></td>
                                                                        <td><?php echo $v['ProductQty']; ?></td>
                                                                    </tr>
        <?php } ?>

                                                            <?php }
                                                            else
                                                            { ?>
                                                                <tr>
                                                                    <td><?php echo ADMIN_NO_RECORD_FOUND; ?></td>
                                                                </tr>
    <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php }
                    else
                    { ?>
                        <table width="100%">
                            <tr>
                                <th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th></tr>
                            <tr><td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td></tr>
                        </table>
<?php }
?>
                </div>
            </div>
            <?php require_once('inc/footer.inc.php'); ?>
        </div>

    </body>
</html>
