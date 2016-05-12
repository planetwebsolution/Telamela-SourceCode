<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_ATTRIBUTE_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Add Attribute </title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <script type="text/javascript" src="js/attribute_admin.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jscolor.js"></script>
        <style>
            .dNone{display:none;}
        </style> 
    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>

        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Add - Attribute</h1>
                        </div>

                    </div>
                    
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="catalog_manage_uil.php">Catalog</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="attribute_manage_uil.php">Manage Attribute</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <span>Add - Attribute</span>
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
                                            if ($objCore->displaySessMsg() <> '') {
                                                echo $objCore->displaySessMsg();
                                                $objCore->setSuccessMsg('');
                                                $objCore->setErrorMsg('');
                                            }
                                            ?>
                                            <div class="box-title">
                                                <a id="buttonDecoration" href="attribute_manage_uil.php" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                                <h3>Add - Attribute</h3>
                                            </div>
                                            <div class="box-content nopadding">
                                                <?php require_once('javascript_disable_message.php'); ?>
                                                <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('add-attributes', $_SESSION['sessAdminPerMission'])) { ?>
                                                    <form action=""  method="post" id="frm_page" onsubmit="return validateAttributeAddPageForm('frm_page',0);" enctype="multipart/form-data">
                                                        <div class="row-fluid">
                                                            <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Attribute Code:</label>
                                                                    <div class="controls">
                                                                        <input type="text" name="frmAttributeCode" id="frmAttributeCode" value="" class="input-large" maxlength="50" />
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Attribute Label:</label>
                                                                    <div class="controls">
                                                                        <input type="text" name="frmAttributeTitle" id="frmAttributeTitle" value="" class="input-large" maxlength="50" />
                                                                    </div>
                                                                </div>
                                                                <!--
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Attribute Description:</label>
                                                                    <div class="controls">
                                                                        <input type="text" name="frmAttributeDesc" id="frmAttributeDesc" value="" class="input-xlarge" maxlength="255">
                                                                    </div>
                                                                </div>
                                                                -->
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Visible on website:</label>
                                                                    <div class="controls">
                                                                        <select name="frmAttributeVisible" id="frmAttributeVisible" class='select2-me input-xlarge'>
                                                                            <option value="yes">Yes</option>
                                                                            <option value="no">No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Searchable:</label>
                                                                    <div class="controls">
                                                                        <select name="frmAttributeSearchable" id="frmAttributeSearchable" class='select2-me input-xlarge'>
                                                                            <option value="yes">Yes</option>
                                                                            <option value="no">No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Comparable:</label>
                                                                    <div class="controls">
                                                                        <select name="frmAttributeComparable" id="frmAttributeComparable" class='select2-me input-xlarge'>
                                                                            <option value="yes">Yes</option>
                                                                            <option value="no">No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Input Type:</label>
                                                                    <div class="controls">

                                                                        <select name="frmInputType" id="frmInputType" onchange="hidePlusButton(this.value)" class='select2-me input-xlarge'>
                                                                            <?php foreach ($objPage->arrInputType as $valInputType) { ?>
                                                                                <option value="<?php echo $valInputType['InputTypeAlias']; ?>">
                                                                                    <?php 
                                                                                     if($valInputType['InputTypeTitle']=='Image')
                                                                    {
                                                                        $valInputType['InputTypeTitle']='Colorpicker';
                                                                    }
                                                                                    echo $valInputType['InputTypeTitle']; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <div id="imageNote" style="display: none;">
                                                                            <span class="req">Image should be 35x35 px </span>
                                                                        </div>
                                                                        <br /><br />
                                                                        <div id="addinput">
                                                                            <strong>Input (Options):</strong>
                                                                            <p><input type="text" name="options[]" id="options" value="" class="input1" />&nbsp;<span><a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Input Validation:</label>
                                                                    <div class="controls">
                                                                        <select name="frmAttributeInputValidation" id="frmAttributeInputValidation" class='select2-me input-xlarge' style="display:none">
                                                                            <option value="none">Select</option>
                                                                            <option value="number">Number</option>
                                                                            <option value="email">Email</option>
                                                                            <option value="url">Url</option>
                                                                            <option value="letter">Letter</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label"> Apply to Category:</label>
                                                                    <div class="controls">
                                                                        <p>
                                                                            
                                                                            <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmCategoryId[]', 'frmCategory', array($_GET['frmCategory']), '', 1, 'style="height:350px; max-width: 300px;
    width: -moz-available;"', '1', '1'); ?>
                                                                            <br />
                                                                        <div style="margin-top:10px">Note : <span class="req">*</span> Use control(Ctrl) button to select multiple options.</div>
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <div class="note">Note : * Indicates mandatory fields.</div>

                                                                <div class="form-actions">

                                                                    <button name="frmBtnSubmit" type="submit" class="btn btn-blue" style="width:80px;"  value="ButtonSubmit" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button>
                                                                    <a id="buttonDecoration" href="attribute_manage_uil.php"><button name="frmCancel" type="button" value="Cancel" style="width:80px;"  class="btn" ><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button></a>
                                                                    <input type="hidden" name="frmHidenAdd" id="frmHidnAddPage" value="add" />

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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