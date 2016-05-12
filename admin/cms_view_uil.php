<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_CMS_CTRL;
require_once SOURCE_ROOT . 'components/html_editor/fckeditor/fckeditor.php';
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : CMS </title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>

        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.3.2.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
    </head>
    <body>

        <?php require_once 'inc/header_new.inc.php'; ?>



        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>View CMS</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><a href="cms_manage_uil.php">CMS</a><i class="icon-angle-right"></i></li>
<!--                            <li><a href="cms_view_uil.php?cmsid=<?php echo $_GET['cmsid']; ?>&type=<?php echo $_GET['type']; ?>">View CMS</a></li>-->
                            <li><span>View CMS</span></li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-cms', $_SESSION['sessAdminPerMission']))
                    {
                        ?>

                        <div class="row-fluid">
                            <div class="span12">
                                <div class="box box-color box-bordered">
                                    <?php
                                    if ($objCore->displaySessMsg())
                                    {
                                        ?>  

                                        <?php
                                        echo $objCore->displaySessMsg();
                                        $objCore->setSuccessMsg('');
                                        $objCore->setErrorMsg('');
                                        ?>

                                        <?php
                                    }
                                    ?>
                                    <div class="box-title">
                                        <a id="buttonDecoration" href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn" style="float:right;"> <i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                        <h3>View Page </h3>
                                    </div>
                                    <div class="box-content nopadding">
                                        <form action=""  method="post" id="frm_page" onsubmit="return validateCMSAddPageForm('frm_page');" class='form-horizontal form-bordered' >
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">Page Display Title: </label>
                                                <div class="controls">
    <?php echo $objPage->arrRow[0]['PageDisplayTitle']; ?>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">Page Title: </label>
                                                <div class="controls">
    <?php echo $objPage->arrRow[0]['PageTitle']; ?>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="" class="control-label">Content:</label>
                                                <div class="controls">
                                                    <div class='form-wysiwyg'>
    <?php echo html_entity_decode(stripslashes($objPage->arrRow[0]['PageContent'])); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">Meta Keywords: </label>
                                                <div class="controls">
    <?php echo $objPage->arrRow[0]['PageKeywords']; ?>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">Meta Description: </label>
                                                <div class="controls">
    <?php echo $objPage->arrRow[0]['PageDescription']; ?>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">Page Display Order: </label>
                                                <div class="controls">
    <?php echo $objPage->arrRow[0]['PageOrdering']; ?>
                                                </div>
                                            </div>
                                            <div class="form-actions">

                                                <a href="cms_edit_uil.php?cmsid=<?php echo $_GET['cmsid']; ?>&type=edit" class="btn btn-blue">Edit</a>
                                                <a href="cms_manage_uil.php" class="btn">Cancel</a>
                                                <input type="hidden" name="frmHidnCmsId" id="frmHidnCmsId" value="<?php echo $_GET['cmsid']; ?>" />
                                                <input type="hidden" name="frmHidenEdit" id="frmHidenEdit" value="edit" />
                                            </div>
                                        </form>
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
