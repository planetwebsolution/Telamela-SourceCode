<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_WHOLESALER_COMMISSION_CTRL;
$httpRef = (isset($_REQUEST['httpRef'])) ? $_REQUEST['httpRef'] : $_SERVER['HTTP_REFERER'];
$varNum = count($objPage->arrRow[0]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo ADMIN_PANEL_NAME; ?></title>
        <link href="<?php echo ADMIN_CSS; ?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo VALIDATE_JS; ?>"></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <script>var SITE_ROOT_URL = '<?php echo SITE_ROOT_URL; ?>';</script>

    </head>
    <body>
        <div class="header"><!--header start-->
            <?php require_once 'inc/header.inc.php'; ?>
        </div><!--header end-->
        <div class="body_container"><!--body container start-->
            <div class="container_left">
                <div class="container_left_title">
                    <?php require_once('inc/wholesaler.inc.php'); ?>
                </div>

                <div class="container_left_content">
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('edit-orders', $_SESSION['sessAdminPerMission'])) { ?>

                        <div >&nbsp;</div>
                        <table width="99%" border="0" cellspacing="0" cellpadding="0">
                            <?php
                            if ($objCore->displaySessMsg()) {
                                ?>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td valign="top" class="table_msg">
                                        <?php
                                        echo $objCore->displaySessMsg();
                                        $objCore->setSuccessMsg('');
                                        $objCore->setErrorMsg('');
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <a id="buttonDecoration" href="<?php echo $httpRef; ?>">
                            <input class="button" type="button" style="float:right; margin:6px 2px 0 0; width:107px;" value="<?php echo ADMIN_BACK_BUTTON; ?>" name="btnTagSettings" />
                        </a>
                        <div class="dashboard_title" style=" width:99.3%; margin-bottom:0px;">View Invoice </div>
                        <table width="99%" border="0" cellspacing="0" cellpadding="0" style="float:left;" class="left_content">
                            <?php if ($varNum > 0) { ?>
                            <tr class="content">
                                <td>
                                    <div style="margin-top: 20px;"><?php echo html_entity_decode(stripslashes($objPage->arrRow[0]['InvoiceDetails'])); ?></div>
                                </td>                                
                            </tr>
                            <?php } else { ?>
                                    <tr class="content">
                                        <td valign="top" colspan="2" style="text-align: center;"><?php echo ADMIN_NO_RECORD_FOUND; ?></td>
                                    </tr>
                                <?php } ?>
                            
                        </table>
                        <div >&nbsp;</div> <?php } else { ?>
                        <table width="100%">
                            <tr>
                                <th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th></tr>
                            <tr><td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td></tr>
                        </table>

                    <?php }
                    ?>
                </div>
            </div>
        </div>
        <!--body container end-->

        <div id="footer"><!--footer start-->
            <?php require_once('inc/footer.inc.php'); ?>
        </div><!--footer end-->
    </body>
</html>