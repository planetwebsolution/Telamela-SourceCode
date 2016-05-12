<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_PACKAGE_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Package </title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script type="text/javascript">
            ImageExist='<?php echo count($objPage->arrRow['Package'][0]['PackageImage']); ?>';
        </script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <script type="text/javascript">
            function checkPackage()
            {
                var pk = $('#frmPackageName').val();
                var packageID = $('#frmPackageName').attr('package');
                var oldP = $('#frmPackageName').attr('oldP');
                $.post(SITE_ROOT_URL + "common/ajax/ajax_wholesaler.php", {
                    action: 'varifyDuplicatePackage',
                    pk: pk,
                    package: packageID
                }, function(d) {
                    if (d == 1) {
                        $('#frmPackageName').val('');
                        var existPackageMessage = $('*').hasClass('existPackage') ? 1 : 2;
                        if (existPackageMessage == 2) {
                            $('#frmPackageName').before('<div class="existPackage"><span style="color:red;font-size:12px">This package name already exists.</span></div>');
                        }
                        setTimeout(function() {
                            if (oldP != '') {
                                $('#frmPackageName').val(oldP);
                            }
                            $('.existPackage').remove();
                        }, 5000);
                    }
                });
              
            }
          
           
        </script>
        <style>
            .dNone{display:none !important;}
        </style>
    </head>
    <body>

        <?php require_once 'inc/header_new.inc.php'; ?>
        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Add Package</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><a href="category_manage_uil.php">Catalog</a><i class="icon-angle-right"></i></li>
                            <li><a href="package_manage_uil.php">Manage Packages</a><i class="icon-angle-right"></i></li>
                            <li><span>Add Package</span></li>
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
                                            <a id="buttonDecoration" href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><input type="button" class="btn" name="btnTagSettings" value="<?php echo ADMIN_BACK_BUTTON; ?>" style="float:right; margin:6px 2px 0 0; width:107px;"/></a>
                                            <div class="box-title">
                                                <h3>
                                                    Add New Package
                                                </h3>                                                            
                                            </div>

                                            <div class="box-content nopadding"> 

                                                <?php require_once('javascript_disable_message.php'); ?>


                                                <?php
                                                if ($_SESSION['sessUserType'] == 'super-admin' || in_array('add-package', $_SESSION['sessAdminPerMission']))
                                                {
                                                    ?>

                                                    <form action=""  method="post" name="frm_page" id="frm_page" onsubmit="return validatePackageAddPageForm('frm_page');" enctype="multipart/form-data" >

                                                        <div class="row-fluid">
                                                            <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Package Name:   </label>
                                                                    <div class="controls">

                                                                        <input type="text" onblur="return checkPackage();" name="frmPackageName" id="frmPackageName" class="input-large" oldp="" package="" value="" />
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Select Wholesaler: </label>
                                                                    <div class="controls">
                                                                        <?php $whid = (isset($_GET['whid'])) ? (int) $_GET['whid'] : 0; ?>
                                                                        <select name="frmWholesalerId" id="frmWholesalerId" onchange="window.location='package_add_uil.php?type=add&whid='+this.value; restore();" class='select2-me input-large'>
                                                                            <option value="0">Select Wholesaler</option>
                                                                            <?php
                                                                            foreach ($objPage->arrWholesaler as $key => $val)
                                                                            {
                                                                                ?>
                                                                                <option value="<?php echo $val['pkWholesalerID']; ?>" <?php
                                                                        if ($whid == $val['pkWholesalerID'])
                                                                        {
                                                                            echo 'selected="selected"';
                                                                        }
                                                                                ?>><?php echo $val['CompanyName']; ?></option>
                                                                                    <?php } ?>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <table style="width:100%">
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                <table align="center" width="90%" border="0" id="productRow" cellpadding="5">

                                                                                    <tr>
                                                                                        <td>&nbsp;</td>
                                                                                        <td><b>*Select Category</b></td>
                                                                                        <td><b>*Select Product</b></td>
                                                                                        <td colspan="2"><b>Original&nbsp;Price</b></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Product&nbsp;1:</td>
                                                                                        <td>
                                                                                            <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmCategoryId[]', '', 0, 'Category', 0, 'onchange="ShowProductForPackage(this.value,1);" class="select2-me input-large"', 1, 1); ?>
                                                                                        </td>
                                                                                        <td><span id="product1">
                                                                                                <select name="frmProductId[]" onchange="ShowProductPriceForPackage(this.value,1)" class="select2-me input-large">
                                                                                                    <option value="0">Product</option>
                                                                                                </select>
                                                                                            </span>
                                                                                        </td>
                                                                                        <td  valign="top"><span id="price1"><input type="hidden" name="frmPrice[]" class="input-large" value="0.00" /><b>0.00</b></span></td><td>&nbsp;</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Product&nbsp;2:</td>
                                                                                        <td>
                                                                                            <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmCategoryId[]', '', 0, 'Category', 0, 'onchange="ShowProductForPackage(this.value,2);" class="select2-me input-large"', 1, 1); ?>
                                                                                        </td>
                                                                                        <td><span id="product2">
                                                                                                <select name="frmProductId[]" onchange="ShowProductPriceForPackage(this.value,2)" class="select2-me input-large">
                                                                                                    <option value="0">Product</option>
                                                                                                </select>
                                                                                            </span>
                                                                                        </td>
                                                                                        <td valign="top"><span id="price2"><input type="hidden" name="frmPrice[]" class="input-large" value="0.00" /><b>0.00</b></span></td><td><i style="cursor: pointer;" onclick="addDynamicRowToTableForPackage('productRow');"><img src="images/plus.png" /></i></td>
                                                                                    </tr>
                                                                                </table>

                                                                            </td>
                                                                        </tr></table>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="" class="control-label">Total Price:</label>
                                                                    <div class="controls">
                                                                        <span id="asc" style="font-weight: bold;">0.00</span><input type="hidden" name="frmTotalPrice" id="frmTotalPrice" value="0.00"  />
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="" class="control-label">*Offer Price:</label>
                                                                    <div class="controls">
                                                                        <input type="text" name="frmOfferPrice" id="frmOfferPrice" class="input-large" />

                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label for="textarea" class="control-label">Package&nbsp;Image:   </label>
                                                                    <div class="controls">
                                                                        <input type="file" name="frmPackageImage" id="frmPackageImage" class="input-large" />&nbsp;<span style="color: red;">Use image formats : jpg, png, gif</span>
                                                                    </div>
                                                                </div>

                                                                <div class="note">Note : * Indicates mandatory fields.</div>

                                                                <div class="form-actions">
    <!--                                        <input type="submit" class="btn" name="btnPage" value="<?php echo ADMIN_SUBMIT_BUTTON; ?>" style="float:left; margin:5px 15px 0 0; width:80px;"/>-->
                                                                    <button type="submit" class="btn btn-blue"><?php echo ADMIN_SUBMIT_BUTTON; ?></button>

                                                                <!--                                        <a id="buttonDecoration" href="wholesaler_manage_uil.php"><input type="button" class="btn" name="btnTagSettings" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" style="float:left; margin:5px 5px 0 0; width:80px;"/></a>                                              -->


                                                                    <a id="buttonDecoration" href="package_manage_uil.php"><button type="button" class="btn"><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button></a>                                      <input type="hidden" name="frmHidenAdd" id="frmHidnAddPage" value="add" />
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
