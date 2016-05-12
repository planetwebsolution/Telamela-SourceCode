<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_WHOLESALER_SUPPORT_OUTBOX_CTRL;
$rowsNum = count($objPage->arrRow);
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Wholesaler support</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <link rel="stylesheet" href="css/colorbox.css" />
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <script src="../colorbox/jquery.colorbox.js"></script>	
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" />


    </head>
    <body>

        <?php require_once 'inc/header_new.inc.php'; ?>


        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Support outbox view</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="wholesaler_support_outbox_manage_uil.php">Wholesaler Support</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
<!--                                <a href="wholesaler_support_outbox_view_uil.php?id=<?php echo $_GET['id']; ?>&type=edit">Wholesaler Support outbox view</a>-->
                                <span>Wholesaler Support outbox view</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <div class="box box-bordered box-color top-box">
                                <a id="buttonDecoration" href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><input type="button" class="btn" name="btnTagSettings" value="<?php echo ADMIN_BACK_BUTTON; ?>" style="float:right; margin:6px 2px 0 0; width:107px;"/></a>

                                <div class="box-content nopadding">

                                    <div class="tab-content padding tab-content-inline tab-content-bottom">
                                        <div class="tab-pane active" id="tabs-2">
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <div class="box box-color box-bordered">
                                                        <div class="box-title">
                                                            <h3>
                                                                Support outbox view
                                                            </h3>
                                                        </div>
                                                        <div class="box-content nopadding">

                                                            <?php require_once('javascript_disable_message.php'); ?>
                                                            <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('reply-customer-support', $_SESSION['sessAdminPerMission']))
                                                            {
                                                                ?>

                                                                <table class="table table-hover table-nomargin table-bordered usertable">
                                                                    <tbody>
                                                                        <?php
                                                                        if ($rowsNum > 0)
                                                                        {
                                                                            foreach ($objPage->arrRow as $valRows)
                                                                            {
                                                                                ?>
                                                                                <tr class="content">
                                                                                    <td>
                                                                                        <table cellpadding="0" cellspacing="0" border="0" class="left_content" style="width:100%;" >
                                                                                            <tr>
                                                                                                <td valign="top" style="width:30%;"><strong>Recipient:</strong> </td>
                                                                                                <?php
                                                                                                if ($varRow['wholesalerName'] != "")
                                                                                                {
                                                                                                    $varRecipientName = $varRow['wholesalerName'];
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    $varRecipientName = "Admin";
                                                                                                }
                                                                                                ?>
                                                                                                <td><?php echo $varRecipientName; ?></td>
                                                                                                <td><?php echo $objCore->localDateTime($objPage->arrRow[0]['SupportDateAdded'], DATE_FORMAT_SITE); ?></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td valign="top" style="width:30%;"><strong>Subject:</strong> </td>
                                                                                                <td colspan="2"><?php echo $valRows['Subject']; ?></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td valign="top" style="width:30%;"><strong>Message:</strong> </td>
                                                                                                <td colspan="2"><?php echo $valRows['Message']; ?></td>
                                                                                            </tr>
                                                                                        </table>

                                                                                    </td>
                                                                                </tr>
                                                                            <?php } ?>

                                                                        <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <tr class="content">
                                                                                <td style="text-align:center;">
                                                                            <?php echo ADMIN_NO_RECORD_FOUND; ?>

                                                                                </td>
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
                                </div>
                            </div>
                        </div>

<?php
}
else
{
    ?>
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