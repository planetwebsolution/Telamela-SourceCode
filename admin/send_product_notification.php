<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . 'notification_ctrl.php';
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Send Product Notification</title>
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
                            <h1>Send Product Notification</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="settings_frm_uil.php">Setting</a>
                                <i class="icon-angle-right"></i>
                            </li>

                            <li>
                                <span>Send Product Notification</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>


                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin') { ?>
                        <?php $httpRef = (isset($_REQUEST['httpRef'])) ? $_REQUEST['httpRef'] : $_SERVER['HTTP_REFERER']; ?>
                        <div class="row-fluid">
                            <div class="span12">
                                <?php
                                if ($objCore->displaySessMsg()) {
                                    ?>

                                    <?php
                                    echo $objCore->displaySessMsg();
                                    $objCore->setSuccessMsg('');
                                    $objCore->setErrorMsg('');
                                    ?>

                                    <?php
                                }
                                ?>
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>Send Product Notification</h3>
                                    </div>
                                    <form action=""  method="post" id="frm_page" onsubmit="return validateNotificationForm(this);" class='form-horizontal form-bordered'>
                                        <div class="box-content nopadding">
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <div class="box box-color box-bordered ">
                                                        <div class="nopadding">                                                            
                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">*Title:</label>
                                                                <div class="controls">                                                                    
                                                                    <input type="text" name="frmnotificationTitle" id="frmnotificationTitle" class="input-large" value="<?php echo $_POST['title']; ?>" />
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">*Description:</label>
                                                                <div class="controls">                                                                    
                                                                    <textarea type="text" name="frmnotificationDescription" id="frmnotificationDescription" class="input-large" /><?php echo $_POST['description']; ?></textarea>
                                                                </div>
                                                            </div>
															
															<div class="control-group">
                                                                <label for="textfield" class="control-label">*Product Url:</label>
                                                                <div class="controls">                                                                    
                                                                    <input type="text" name="frmnotificationUrl" id="frmnotificationUrl" class="input-large" value="<?php echo $_POST['url']; ?>" />
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="note">Note : * Indicates mandatory fields.</div>
                                                            <div class="form-actions">                        
                                                                <button name="frmBtnSubmit" type="submit" class="btn btn-blue" value="<?php echo ADMIN_SUBMIT_BUTTON; ?>" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button>  
                                                                <a id="buttonDecoration" href="<?php echo $httpRef; ?>">
                                                                    <button name="frmCancel" type="button" value="Cancel" class="btn" ><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button>
                                                                </a>                                                                           
                                                                <input type="hidden" name="frmHidenAdd" id="frmHidenAdd" value="add" />
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
<?php require_once('inc/footer.inc.php'); ?>

        </div>


    </body>
</html>
