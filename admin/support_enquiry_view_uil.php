<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_SUPPORT_ENQUIRY_CTRL;
//pre($_SESSION);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo ADMIN_PANEL_NAME; ?></title>
        <link href="<?php echo ADMIN_CSS; ?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo VALIDATE_JS; ?>"></script>
        <script>var SITE_ROOT_URL = '<?php echo SITE_ROOT_URL; ?>';</script>         
        <link rel="stylesheet" href="css/colorbox.css" />
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <script src="../colorbox/jquery.colorbox.js"></script>	
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo SITE_ROOT_URL . "components/cal/skins/aqua/theme.css"; ?>" title="Aqua" />
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL . "common/js/ajax_js.js"; ?>"></script>

    </head>
    <body>
        <div class="header"><!--header start-->
            <?php require_once 'inc/header.inc.php'; ?>
        </div><!--header end-->
        <div class="body_container"><!--body container start-->
            <div class="container_left">
                <div class="container_left_title">
                    <div class="content_title">
                        <div id="submenu"><!--submenu start-->
                            <ul>
                                <li><a class="current">Support Enquiries </a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="container_left_content">
                    <?php require_once('javascript_disable_message.php'); ?>

                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('reply-customer-support', $_SESSION['sessAdminPerMission'])) { ?>

                        <a id="buttonDecoration" href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><input type="button" class="button" name="btnTagSettings" value="<?php echo ADMIN_BACK_BUTTON;?>" style="float:right; margin:6px 2px 0 0; width:107px;"/></a>
                        <input type="button" class="button" name="btnTagSettings" value="<?php echo ADMIN_REPLY_BUTTON;?>" style="float:right; margin:6px 5px 0 0; width:80px;"/>
                        <table width="99%" border="0" cellspacing="0" cellpadding="0" style="float:left;" class="left_content">
                            <div class="dashboard_title" style=" width:99.3%; margin-bottom:0px;">Support Enquiries Page</div>                           

                            <tr>
                                <td>
                                    <form action=""  method="post" id="frm_page" onsubmit="return validateProductAddForm(this);" enctype="multipart/form-data" >
                                        <table cellpadding="0" cellspacing="0" border="0" class="left_content" style="width:100%" >
                                            <tr class="content">
                                                <td valign="top" style="width:30%;"><strong>Sender:</strong> </td>
                                                <td><?php echo $objPage->arrRow[0][$objPage->arrRow[0]['FromUserType'] . 'Name'] . ' (' . $objPage->arrRow[0]['FromUserType'] . ')'; ?></td>
                                                <td><?php echo $objCore->localDateTime($objPage->arrRow[0]['SupportDateAdded'], DATE_FORMAT_SITE); ?></td>
                                            </tr><tr class="content">
                                                <td valign="top" style="width:30%;"><strong>Subject:</strong> </td>
                                                <td colspan="2"><?php echo $objPage->arrRow[0]['Subject']; ?></td>
                                            </tr><tr class="content">
                                                <td valign="top" style="width:30%;"><strong>Message:</strong> </td>
                                                <td colspan="2"><?php echo $objPage->arrRow[0]['Message']; ?></td>
                                            </tr>


                                            <tr class="content">
                                                <td>&nbsp;</td>
                                                <td colspan="2"><input type="button" class="button" name="btnPage" value="<?php echo ADMIN_REPLY_BUTTON;?>" style="float:left; margin:5px 15px 0 0; width:80px;"/>

                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </td>
                            </tr>

                        </table>
                    <?php } else { ?> 
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