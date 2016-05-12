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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage CMS </title>
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
                            <h1>Edit CMS</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><a href="cms_manage_uil.php">CMS</a><i class="icon-angle-right"></i></li>
                            <li><span>Edit CMS</span></li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('edit-cms', $_SESSION['sessAdminPerMission']))
                    { ?>

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
                                        <a id="buttonDecoration" href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn" style="float: right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                        <h3>Edit Cms Page </h3>
                                    </div>
                                    <div class="box-content nopadding">
                                        <form action=""  method="post" id="frm_page" onsubmit="return validateCMSAddPageForm('frm_page');" class='form-horizontal form-bordered' >
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">*Page Display Title: </label>
                                                <div class="controls">
                                                    <!-- <input name="frmDisplayPageTitle" id="frmDisplayPageTitle" type="text" class="input-large" maxlength="100" value="<?php echo $objPage->arrRow[0]['PageDisplayTitle']; ?>" />
                                                    <span style="text-align:left; padding-left:7px; font-size: 11px; color: red">Maximum of 100 Characters.</span>
                                                --> 
                                                <?php
                                                //pre($objPage->arrRow[0]['PageDisplayTitle']);
                                                ?>
                                                <select name="frmDisplayPageTitle" id="frmDisplayPageTitle" style="width: 272px;"  class='select2-me input-large'>
                                                                            <option value="About Market" <?php
                                                                    if ( $objPage->arrRow[0]['PageDisplayTitle'] == 'About Market')
                                                                    {
                                                                        echo 'selected="selected"';
                                                                    }
                                                    ?>>About Market</option>
                                                                            <option value="Customer Service" <?php
                                                                                if ($objPage->arrRow[0]['PageDisplayTitle'] == 'Customer Service')
                                                                                {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                                ?>> Customer Service</option>
                                                                            <option value="Payment & Shipping" <?php
                                                                                if ($objPage->arrRow[0]['PageDisplayTitle'] == 'Payment & Shipping')
                                                                                {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                                ?>> Payment & Shipping Image </option>
                                                                            
                                                                        </select>
                                            </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">*Page Title: </label>
                                                <div class="controls">
                                                    <input name="frmPageTitle" id="frmPageTitle" type="text" class="input-large" maxlength="100" value="<?php echo $objPage->arrRow[0]['PageTitle']; ?>" />
                                                    <span style="text-align:left; padding-left:7px; font-size: 11px; color: red">Maximum of 100 Characters.</span>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">*Page Prifix: </label>
                                                <div class="controls">
                                                    <input type="text" name="frmPagePrifix" id="frmPagePrifix" placeholder="" class="input-large" maxlength="100" value="<?php echo $objPage->arrRow[0]['PagePrifix']; ?>" >
                                                    <span style="text-align:left; padding-left:7px; font-size: 11px; color: red">Maximum of 100 Characters.</span>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="" class="control-label">Content:</label>
                                                <div class="controls">
                                                    <div class='form-wysiwyg'>
    <?php $varContent = stripslashes($objPage->arrRow[0]['PageContent']); ?>
                                                        <textarea name="frmPageContent" id="frmPageContent"  class='ckeditor span12' rows="5"><?php echo $varContent; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">Meta Keywords: </label>
                                                <div class="controls">
                                                    <textarea name="frmPageKeywords" class="input-block-level" rows="4" ><?php echo $objPage->arrRow[0]['PageKeywords']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">Meta Description: </label>
                                                <div class="controls">
                                                    <textarea name="frmPageDescription" class="input-block-level" rows="4"><?php echo $objPage->arrRow[0]['PageDescription']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">*Page Display Order: </label>
                                                <div class="controls">
                                                    <input type="text" name="frmPageDisplayOrder" id="frmPageDisplayOrder" value="<?php echo $objPage->arrRow[0]['PageOrdering']; ?>" style="width: 80px;"/>
                                                    <span style="text-align:left; padding-left:7px; font-size: 11px; color: red">Number should be greater than zero.</span>
                                                </div>
                                            </div>
                                            <div class="note">Note : * Indicates mandatory fields.</div>
                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-primary"><?php echo ADMIN_SUBMIT_BUTTON; ?></button>
                                                <a id="buttonDecoration" href="cms_manage_uil.php"><button type="button" class="btn">Cancel</button></a>
                                                <input type="hidden" name="frmHidnCmsId" id="frmHidnCmsId" value="<?php echo $_GET['cmsid']; ?>" />
                                                <input type="hidden" name="frmHidenEdit" id="frmHidenEdit" value="edit" />
                                            </div>
                                        </form>
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
