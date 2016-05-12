<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_SHIPPING_METHOD_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Shipping Method - Edit</title>
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
                            <h1>Edit - Shipping Method</h1>
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
                                <a href="shipping_method_manage_uil.php">Shipping Method</a>
                                <i class="icon-angle-right"></i>
                            </li>

                            <li>
<!--                                <a href="shipping_method_edit_uil.php?smid=<?php echo $_GET['smid']; ?>&type=add">Edit - Shipping Method</a>-->
                                <span>Edit - Shipping Method</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>


                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin'|| $_SESSION['sessUserType'] == 'user-admin')
                    { ?>
                        <div class="row-fluid">
                            <div class="span12">
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
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>Edit - Shipping Method</h3>
                                        <a id="buttonDecoration" href="shipping_method_manage_uil.php" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                    </div>
                                    <form action=""  method="post" id="frm_page" onsubmit="return validateShipplingMethodForm(this);" class='form-horizontal form-bordered'>
                                        <div class="box-content nopadding">
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <div class="box box-color box-bordered ">
                                                        <div class="nopadding">
                                                           

                                                            <div class="control-group">
                                                                <label for="textfield" class="control-label">*Name/Title:</label>
                                                                <div class="controls">
                                                                    <input type="text" name="frmMethodName" id="frmMethodName" class="input-large" value="<?php echo $objPage->arrRow[0]['MethodName']; ?>" />
                                                                </div>
                                                            </div>
                                                           
                                                            <div class="control-group">
                                                                <label for="" class="control-label">Method Description:</label>
                                                                <div class="controls">
                                                                    <textarea name="frmMethodDescription" id="frmMethodDescription" class="input-large" rows="4"><?php echo $objPage->arrRow[0]['MethodDescription']; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <?php 
                                                            //pre($objPage->arrRow[0]);
                                                            ?>
                                                            <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Method Status:</label>
                                                                    <div class="controls">       
                                                                                                                              
                                                                        <input type="radio" name="frmStatus" id="frmStatus" <?php echo ($objPage->arrRow[0]['MethodStatus'] == 1) ? 'checked="checked"' : ''; ?> value="1" />Active&nbsp;&nbsp;&nbsp; 
                                                                        <input type="radio" name="frmStatus" id="frmStatus" <?php echo ($objPage->arrRow[0]['MethodStatus'] == 0) ? 'checked="checked"' : ''; ?> value="0" />Deactive
                                                                    </div>
                                                                    
                                                                    <?php
                                                                    if ($_SESSION['sessUserType'] == 'user-admin') {
                                                                       // pre($_SESSION);
                                                                        $shippingportalvlaue=$_SESSION['sessUser'];
            	                                           
                                                                      }
                                                                      else
                                                                        $shippingportalvlaue=0;   
                                                                    ?>
                                                                    <input type="hidden" name="shippingportal" value="<?php echo $shippingportalvlaue ?>">
                                                               
                                                                </div>
                                                             
                                                            
                                                            <div class="note">Note : * Indicates mandatory fields.</div>

                                                            <div class="form-actions">

                                                                <button name="frmBtnSubmit" type="submit" class="btn btn-blue" value="<?php echo ADMIN_SUBMIT_BUTTON; ?>" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button>
                                                                <a id="buttonDecoration" href="<?php echo $httpRef; ?>">
                                                                    <button name="frmCancel" type="button" value="Cancel" class="btn" ><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button>
                                                                </a>
                                                                <input type="hidden" name="httpRef" value="<?php echo $httpRef; ?>" />
                                                                <input type="hidden" name="frmHidenEdit" id="frmHidenEdit" value="edit" />
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
