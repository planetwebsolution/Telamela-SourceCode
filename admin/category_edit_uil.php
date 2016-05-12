<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_CATEGORY_CTRL;
$mainCategoryImageSize = '186*293';
$mainCategoryImageDimen = @explode('*', $mainCategoryImageSize);

$mainCategoryIconSize = '60*60';
$mainCategoryIconDimen = @explode('*', $mainCategoryIconSize);

$subCategoryImageSize = '345*308';
$subCategoryImageDimen = @explode('*', $subCategoryImageSize);
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
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <script type="text/javascript">
            var msgR = 'Image should be <?php echo $mainCategoryImageSize; ?> px';
            var msgO = 'Image should be <?php echo $subCategoryImageSize; ?> px';
            var ids = '<?php echo $_GET["cid"]; ?>';
            function callCatChange(refer) {
                var str = 'action=findcatEditLavel&cid=' + $(refer).val();
                $.post('<?php echo SITE_ROOT_URL; ?>admin/ajax.php', str, function (response) {
                    if (response)
                    {

                        $('#findCategoryLavel').val(response.lavel);
                        if (response.lavel == 0) {
                            $('#bannerMsg').html(msgR);
                        } else if (response.lavel == 1)
                        {
                            $('#bannerMsg').html(msgO);
                        } else if (response.lavel == 2)
                        {
                            $('#bannerMsg').html("Not Applicable!");
                        }

                        $('#frmName').attr('onblur', 'checkEditExists(this.value,' + ids + ',' + response.parentId + ',' + response.lavel + ')');
                    }
                }, "json");
            }
            //Validate image field                     
            var url = window.URL || window.webkitURL;
            function changeCatImages(obj) {


                if ($('#findCategoryLavel').val() == 0)
                {
                    var hgt = '<?php echo $mainCategoryImageDimen[1]; ?>';
                    var wth = '<?php echo $mainCategoryImageDimen[0]; ?>';
                    var rhgt = '<?php echo $mainCategoryImageDimen[1]; ?>';
                    var rwth = '<?php echo $mainCategoryImageDimen[0]; ?>';

                }
                else if ($('#findCategoryLavel').val() == 1)
                {
                    var hgt = '<?php echo $subCategoryImageDimen[1]; ?>';
                    var wth = '<?php echo $subCategoryImageDimen[0]; ?>';
                    var rhgt = '<?php echo $subCategoryImageDimen[1]; ?>';
                    var rwth = '<?php echo $subCategoryImageDimen[0]; ?>';

                }
                if (obj.disabled) {
                    alert('Your browser does not support File upload.');
                } else {
                    var chosen = obj.files[0];
                    var image = new Image();
                    image.onload = function () {
                        if ($('#findCategoryLavel').val() == 0) {

                            if (this.height > rhgt || this.width > rwth || this.height < hgt || this.width < wth) {
                                alert('Please upload image of (' + rwth + ')px width and (' + rhgt + ')px height!');
                                $('#frmCategoryImage').val('');
                                obj.focus();
                            }
                        }
                        else
                        if ($('#findCategoryLavel').val() == 1)
                        {

                            if (this.height > hgt || this.width > wth || this.height < hgt || this.width < wth) {
                                alert('Please upload image of (' + wth + ')px width and (' + hgt + ')px height!');
                                $('#frmCategoryImage').val('');
                                obj.focus();
                            }

                        }
                        else if ($('#findCategoryLavel').val() == 2)
                        {
                            alert('Not Applicable!');
                            $('#frmCategoryImage').val('');
                            obj.focus();

                        }
                    }
                    image.onerror = function () {
                        alert('Accepted Image formats are: jpg, jpeg, gif, png ');
                        $('#frmCategoryImage').val('');
                    };
                    image.src = url.createObjectURL(chosen);
                }
            }

            function changeCatIcons(obj) {


                if ($('#findCategoryLavel').val() == 0)
                {
                    var hgt = '<?php echo $mainCategoryIconDimen[1]; ?>';
                    var wth = '<?php echo $mainCategoryIconDimen[0]; ?>';
                    var rhgt = '<?php echo $mainCategoryIconDimen[1]; ?>';
                    var rwth = '<?php echo $mainCategoryIconDimen[0]; ?>';

                }
                else if ($('#findCategoryLavel').val() == 1)
                {
                    var hgt = '<?php echo $mainCategoryIconDimen[1]; ?>';
                    var wth = '<?php echo $mainCategoryIconDimen[0]; ?>';
                    var rhgt = '<?php echo $mainCategoryIconDimen[1]; ?>';
                    var rwth = '<?php echo $mainCategoryIconDimen[0]; ?>';

                }
                if (obj.disabled) {
                    alert('Your browser does not support File upload.');
                } else {
                    var chosen = obj.files[0];
                    var image = new Image();
                    image.onload = function () {
                        if ($('#findCategoryLavel').val() == 0) {

                            if (this.height > rhgt || this.width > rwth || this.height < hgt || this.width < wth) {
                                alert('Please upload image of (' + rwth + ')px width and (' + rhgt + ')px height!');
                                $('#frmCategoryIcon').val('');
                                obj.focus();
                            }
                        }
                        else
                        if ($('#findCategoryLavel').val() == 1)
                        {

                            if (this.height > hgt || this.width > wth || this.height < hgt || this.width < wth) {
                                alert('Please upload image of (' + wth + ')px width and (' + hgt + ')px height!');
                                $('#frmCategoryIcon').val('');
                                obj.focus();
                            }

                        }
                        else if ($('#findCategoryLavel').val() == 2)
                        {
                            alert('Not Applicable!');
                            $('#frmCategoryIcon').val('');
                            obj.focus();

                        }
                    }
                    image.onerror = function () {
                        alert('Accepted Image formats are: jpg, jpeg, gif, png ');
                        $('#frmCategoryIcon').val('');
                    };
                    image.src = url.createObjectURL(chosen);
                }
            }

        </script> 

    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>
        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
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
                                <a href="category_manage_uil.php">Manage Category</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
<!--                                <a href="category_edit_uil.php?type=edit&cid=<?php echo $_GET['cid']; ?>">Edit - Category</a>-->
                                <span>Edit - Category</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Edit - Category</h1>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <?php
                            if ($objCore->displaySessMsg() <> '') {
                                echo $objCore->displaySessMsg();

                                $objCore->setSuccessMsg('');
                                $objCore->setErrorMsg('');
                            }
                            //  echo $objPage->arrRow[0]['CategoryParentId'];die;
                            ?>
                            <div class="tab-pane active" id="tabs-2">
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="box box-color box-bordered">
                                            <div class="box-title">
                                                <a id="buttonDecoration" href="category_manage_uil.php" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                                <h3>Edit - Category</h3>
                                            </div>
                                            <div class="box-content nopadding">
                                                <?php require_once('javascript_disable_message.php'); ?>
                                                <?php
                                                if ($_SESSION['sessUserType'] == 'super-admin' || in_array('edit-categories', $_SESSION['sessAdminPerMission'])) {
                                                    ?>
                                                    <form action="" method="post" id="frm_page" enctype="multipart/form-data" onsubmit="return validateCategoryAddEditForm(1);" >
                                                        <input type="hidden" name="findCategoryLavel" id="findCategoryLavel" value="<?php echo trim($objPage->arrRow[0]['CategoryParentId']) == '0' ? 0 : 1; ?>"/>
    <!--                                                        <input type="hidden" name="findCategoryLavel" id="findCategoryLavel" value="<?php echo $objPage->arrRow[0]['CategoryName'] != '' ? 1 : 0; ?>"/>-->
                                                        <div class="row-fluid">
                                                            <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Category Name:</label>
                                                                    <div class="controls">
                                                                        <?php
                                                                        //pre($objPage->arrRow[0]);
                                                                        ?>
                                                                        <input type="text" name="frmName" id="frmName" value="<?php echo $objPage->arrRow[0]['CategoryName']; ?>" class="input-xlarge" maxlength="50" onBlur="checkEditExists(this.value,<?php echo $_GET['cid']; ?>,<?php echo $objPage->arrRow[0]['CategoryParentId'] ?>,<?php echo $objPage->arrRow[0]['CategoryLevel'] ?>)"/>
                                                                        <span style="color: red;">Product name may be 50 character long only.</span>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Parent Category:</label>
                                                                    <div class="controls">
                                                                        <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmParentId', 'frmParentId', array($objPage->arrRow[0]['CategoryParentId']), 'Root Category', 0, 'class="select2-me input-xlarge" onchange="callCatChange(this)"', 1, 0, 'fromCategory'); ?>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Category Images:</label>
                                                                    <div class="controls">
                                                                        <?php //print_r($objPage->arrRow); ?>
                                                                        <img src="<?php echo $objPage->arrRow[0]['categoryImageUrl'] . $objPage->arrRow[0]['categoryImage']; ?>"  /><br/>
                                                                        <input type="file" name="frmCategoryImage" id="frmCategoryImage" value="" class="file_upload" onchange="changeCatImages(this)">
                                                                        &nbsp;&nbsp;<span class="req" id="bannerMsg">Main Category Image size <?php echo $mainCategoryImageSize; ?>px || Sub Category Image size <?php echo $subCategoryImageSize; ?> px</span>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Category Icon:</label>
                                                                    <div class="controls">
                                                                        <?php //print_r($objPage->arrRow); ?>
                                                                        <img src="<?php echo $objPage->arrRow[0]['categoryIconUrl'] . $objPage->arrRow[0]['categoryIconImage']; ?>"  /><br/>
                                                                        <input type="file" name="frmCategoryIcon" id="frmCategoryIcon" value="" class="file_upload" onchange="changeCatIcons(this)">
                                                                        &nbsp;&nbsp;<span class="req" id="bannerMsg">Icon Image size <?php echo $mainCategoryIconSize; ?> px </span>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Description: <br /><span class="req">Max 100 character</span></label>
                                                                    <div class="controls">
                                                                        <textarea name="frmCategoryDescription" id="frmCategoryDescription" maxlength="100" class="input-block-level" rows="4"><?php echo $objPage->arrRow[0]['CategoryDescription']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">Menu Display Order:</label>
                                                                    <div class="controls">
                                                                        <input type="text" name="frmCategoryOrdering" id="frmCategoryOrdering" value="<?php echo $objPage->arrRow[0]['CategoryOrdering']; ?>" class="input-large" maxlength="10" />
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="" class="control-label">Meta Title:</label>
                                                                    <div class="controls">
                                                                        <textarea name="frmMetaTitle" id="frmMetaTitle" class="input-block-level" rows="4"><?php echo $objPage->arrRow[0]['CategoryMetaTitle']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="" class="control-label">Meta Keywords:</label>
                                                                    <div class="controls">
                                                                        <textarea name="frmMetaKeywords" id="frmMetaKeywords" class="input-block-level" rows="4"><?php echo $objPage->arrRow[0]['CategoryMetaKeywords']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="" class="control-label">Meta Description:</label>
                                                                    <div class="controls">
                                                                        <textarea name="frmMetaDescription" id="frmMetaDescription" class="input-block-level" rows="4"><?php echo $objPage->arrRow[0]['CategoryMetaDescription']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="note">Note : * Indicates mandatory fields.</div>

                                                                <div class="form-actions">
                                                                    <button name="frmBtnSubmit" type="submit" class="btn btn-blue" style="width:80px;"  value="ButtonSubmit" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button>
                                                                    <a id="buttonDecoration" href="category_manage_uil.php"><button name="frmCancel" type="button" value="Cancel" style="width:80px;"  class="btn" ><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button></a>

                                                                    <?php
                                                                    if (isset($_GET['ref'])) {
                                                                        ?>
                                                                        <input type="hidden" name="frmRef" value="<?php echo $_REQUEST['ref']; ?>" />
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <input type="hidden" name="frmRef" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                                                    <?php } ?>
                                                                    <input type="hidden" name="frmHidnAddEditPage" id="frmHidnAddEditPage" value="addEditPage" />

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

                        <?php
                    } else {
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