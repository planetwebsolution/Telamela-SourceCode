<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_ATTRIBUTE_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Attribute Edit</title>
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
                            <h1>Edit - Attribute</h1>
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
                                <!--<a href="attribute_edit_uil.php?type=edit&attrbuteid=<?php echo $_GET['attrbuteid']; ?>">Edit - Attribute</a>-->
                                <span>Edit - Attribute</span>
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
                                            if ($objCore->displaySessMsg() <> '')
                                            {
                                                echo $objCore->displaySessMsg();
                                                $objCore->setSuccessMsg('');
                                                $objCore->setErrorMsg('');
                                            }
                                            ?>
                                            <div class="box-title">
                                                <a id="buttonDecoration" href="attribute_manage_uil.php" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                                <h3>Edit - Attribute</h3>
                                            </div>
                                            <div class="box-content nopadding">
                                                <?php require_once('javascript_disable_message.php'); ?>
<?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('edit-attributes', $_SESSION['sessAdminPerMission']))
{ ?>
                                                    <form action=""  method="post" id="frm_page" onsubmit="return validateAttributeAddPageForm('frm_page');" enctype="multipart/form-data">
                                                        <div class="row-fluid">
                                                            <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Attribute Code:</label>
                                                                    <div class="controls">
                                                                        <input type="text" name="frmAttributeCode" id="frmAttributeCode" value="<?php echo $objPage->arrRow['arrAttributeData'][0]['AttributeCode']; ?>" class="input-large" maxlength="50" />
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Attribute Label:</label>
                                                                    <div class="controls">
                                                                        <input type="text" name="frmAttributeTitle" id="frmAttributeTitle" value="<?php echo $objPage->arrRow['arrAttributeData'][0]['AttributeLabel']; ?>" class="input-large" maxlength="50" />
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Visible on website:</label>
                                                                    <div class="controls">
                                                                        <select name="frmAttributeVisible" id="frmAttributeVisible" class='select2-me input-xlarge'>
                                                                            <option value="yes" <?php
    if ($objPage->arrRow['arrAttributeData'][0]['AttributeVisible'] == 'yes')
    {
        echo 'selected';
    }
    ?>>Yes</option>
                                                                            <option value="no" <?php
                                                                        if ($objPage->arrRow['arrAttributeData'][0]['AttributeVisible'] == 'no')
                                                                        {
                                                                            echo 'selected';
                                                                        }
                                                                        ?>>No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Searchable:</label>
                                                                    <div class="controls">
                                                                        <select name="frmAttributeSearchable" id="frmAttributeSearchable" class='select2-me input-xlarge'>
                                                                            <option value="yes" <?php
                                                                        if ($objPage->arrRow['arrAttributeData'][0]['AttributeSearchable'] == 'yes')
                                                                        {
                                                                            echo 'selected';
                                                                        }
    ?>>Yes</option>
                                                                            <option value="no" <?php
                                                                                if ($objPage->arrRow['arrAttributeData'][0]['AttributeSearchable'] == 'no')
                                                                                {
                                                                                    echo 'selected';
                                                                                }
                                                                                ?>>No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Comparable:</label>
                                                                    <div class="controls">
                                                                        <select name="frmAttributeComparable" id="frmAttributeComparable" class='select2-me input-xlarge'>
                                                                            <option value="yes" <?php
                                                                                if ($objPage->arrRow['arrAttributeData'][0]['AttributeComparable'] == 'yes')
                                                                                {
                                                                                    echo 'selected';
                                                                                }
                                                                                ?>>Yes</option>
                                                                            <option value="no" <?php
                                                                                if ($objPage->arrRow['arrAttributeData'][0]['AttributeComparable'] == 'no')
                                                                                {
                                                                                    echo 'selected';
                                                                                }
                                                                                ?>>No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Input Type:</label>
                                                                    <div class="controls">

                                                                        <select name="frmInputType" id="frmInputType" onchange="hidePlusButton(this.value)" class='select2-me input-xlarge'>
                                                                        <?php foreach ($objPage->arrInputType as $valInputType)
                                                                        { ?>
                                                                                <option value="<?php echo $valInputType['InputTypeAlias']; ?>" <?php
                                                                    if ($objPage->arrRow['arrAttributeData'][0]['AttributeInputType'] == $valInputType['InputTypeAlias'])
                                                                    {
                                                                        echo 'selected';
                                                                    }
                                                                    ?>><?php 

                                                                    if($valInputType['InputTypeTitle']=='Image')
                                                                    {
                                                                        $valInputType['InputTypeTitle']='Colorpicker';
                                                                    }
                                                                    echo $valInputType['InputTypeTitle']; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                            <?php
                                                                            $varDisplayNote = ($objPage->arrRow['arrAttributeData'][0]['AttributeInputType'] == 'image') ? 'block' : 'none';
                                                                            ?>

                                                                        <div id="imageNote" style="display: <?php echo $varDisplayNote; ?>;">
                                                                            <span class="req">Image should be 35x35 px</span>
                                                                        </div>
                                                                        <br /><br />
                                                                        <div id="addinput">
                                                                            <?php
                                                                            $varLast = count($objPage->arrRow['arrAttributeOptionData']);
                                                                            if ($objPage->arrRow['arrAttributeData'][0]['AttributeInputType'] != 'text' && $objPage->arrRow['arrAttributeData'][0]['AttributeInputType'] != 'textarea' && $objPage->arrRow['arrAttributeData'][0]['AttributeInputType'] != 'date')
                                                                            {
                                                                                ?>
                                                                                <strong>Input (Options):</strong>
                                                                                <?php
                                                                                //pre($objPage->arrRow['arrAttributeOptionData']);
                                                                                foreach ($objPage->arrRow['arrAttributeOptionData'] as $keyOpt => $valueOpt)
                                                                                {
                                                                                    if ($objPage->arrRow['arrAttributeData'][0]['AttributeInputType'] == 'image')
                                                                                    {
                                                                                       if(!empty($valueOpt['OptionImage'])){
                                                                                       $demoImg = '<img src="' . $objCore->getImageUrl($valueOpt['OptionImage'], 'products/' . $arrProductImageResizes['default']) . '" height="30"/>';
                                                                                       }else{$demoImg = '';}
$varImg = '<input type="hidden" name="attr_old_img[]" value="' . $valueOpt['OptionImage'] . '" />&nbsp;'.$demoImg;
                                                                                        $varImgInp = '<input class="attr_img" type="file" size="1" value="" name="attr_img[]">&nbsp;';
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        $varImg = '';
                                                                                        $varImgInp = '';
                                                                                    }
                                                                                    ?>

                                                                                    <p>
                                                                                        <input type="hidden" name="optionsIds[]" value="<?php echo $valueOpt['pkOptionID']; ?>" />
                                                                                    <?php echo $varImgInp;
                                                                                   if ($objPage->arrRow['arrAttributeData'][0]['AttributeInputType'] == 'image')
                                                                                   {
                                                                                     ?>

                                                                                        <input class="color {hash:true,caps:false}" value="<?php echo $valueOpt['optionColorCode']; ?>" name="attributeColorCode[]">&nbsp; 
                                                                                        <?php }?>
                                                                                        <input type="text" name="options[]" value="<?php echo $valueOpt['OptionTitle']; ?>" class="input1" />
                                                                                    <?php echo $varImg; ?>
                                                                                        <span>
            <?php if ($keyOpt == $varLast - 1)
            { ?><a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a><?php } ?>
                                                                                        </span>

            <?php if ($keyOpt > 0)
            { ?><a id="remNew" href="#"><img src="images/minus.png" alt="Remove" title="Remove" /></a><?php } ?>


                                                                                    </p>


                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Input Validation:</label>
                                                                    <div class="controls">


                                                                        <select name="frmAttributeInputValidation" id="frmAttributeInputValidation" class='select2-me input-xlarge' <?php if ($objPage->arrRow['arrAttributeData'][0]['AttributeInputType'] != 'text' && $objPage->arrRow['arrAttributeData'][0]['AttributeInputType'] != 'textarea')
                                                                                {
                                                                                    echo 'style="display:none"';
                                                                                } ?>>
                                                                            <option value="none">Select</option>
                                                                            <option value="number" <?php
                                                                        if ($objPage->arrRow['arrAttributeData'][0]['AttributeValidation'] == 'number')
                                                                        {
                                                                            echo 'selected';
                                                                        }
                                                                        ?>>Number</option>
                                                                            <option value="email" <?php
                                                                        if ($objPage->arrRow['arrAttributeData'][0]['AttributeValidation'] == 'email')
                                                                        {
                                                                            echo 'selected';
                                                                        }
                                                                            ?>>Email</option>
                                                                            <option value="url" <?php
                                                                    if ($objPage->arrRow['arrAttributeData'][0]['AttributeValidation'] == 'url')
                                                                    {
                                                                        echo 'selected';
                                                                    }
                                                                    ?>>Url</option>
                                                                            <option value="letter" <?php
                                                                    if ($objPage->arrRow['arrAttributeData'][0]['AttributeValidation'] == 'letter')
                                                                    {
                                                                        echo 'selected';
                                                                    }
                                                                    ?>>Letter</option>
                                                                        </select>
                                                                    </div>
                                                                </div>



                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label"> Apply to Category:</label>
                                                                    <div class="controls">
    <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmCategoryId[]', 'frmCategory', $objPage->arrRow['arrAttributeCategoryData'], '', 1, 'style="height:350px; max-width: 300px;
    width: -moz-available;"', '1', '1'); ?>
<?php //echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmCategoryId[]', 'frmCategory', $objPage->arrRow['arrAttributeCategoryData'], '', 1, 'style="height:350px; max-width: 300px;width: -moz-available;"'); ?>
                                                                    </div>
                                                                </div>

                                                                <div class="note">Note : * Indicates mandatory fields.</div>

                                                                <div class="form-actions">

                                                                    <button name="frmBtnSubmit" type="submit" class="btn btn-blue" value="ButtonSubmit" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button>
                                                                    <a id="buttonDecoration" href="attribute_manage_uil.php">
                                                                        <button name="frmCancel" type="button" value="Cancel" class="btn" ><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button></a>

    <?php if (isset($_GET['ref']))
    { ?>
                                                                        <input type="hidden" name="frmRef" value="<?php echo $_REQUEST['ref']; ?>" />
    <?php }
    else
    { ?>
                                                                        <input type="hidden" name="frmRef" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
    <?php } ?>
                                                                    <input type="hidden" name="frmHidenEdit" id="frmHidnAddPage" value="edit" />

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