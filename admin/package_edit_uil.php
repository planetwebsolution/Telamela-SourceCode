<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_PACKAGE_CTRL;
require_once CLASSES_PATH . 'class_home_bll.php';
$varNum = count($objPage->arrRow['Package']);
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
                            <h1>Edit Package</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><a href="package_manage_uil.php">Manage Packages</a><i class="icon-angle-right"></i></li>
                            <!--<li><a href="package_edit_uil.php?pkgid=<?php echo $_GET['pkgid'] ?>&type=add">Edit Package</a></li>-->
                            <li><span>Edit Package</span></li>
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
                                                    Edit Package
                                                </h3>
                                            </div>

                                            <div class="box-content nopadding">

                                                <?php require_once('javascript_disable_message.php'); ?>


                                                <?php
                                                if ($_SESSION['sessUserType'] == 'super-admin' || in_array('edit-package', $_SESSION['sessAdminPerMission']))
                                                {
                                                    ?>
                                                    <?php
                                                    if ($varNum > 0)
                                                    {
                                                        ?>
                                                        <form action="" method="post" id="frm_page" onsubmit="return validatePackageAddPageForm('frm_page');" enctype="multipart/form-data" >

                                                            <div class="row-fluid">
                                                                <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">

                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Package Name:   </label>
                                                                        <div class="controls">

                                                                            <input type="text" onblur="return checkPackage();" name="frmPackageName" id="frmPackageName" class="input-large" oldp="<?php echo $objPage->arrRow['Package'][0]['PackageName']; ?>" package="<?php echo $_GET['pkgid']; ?>"  value="<?php echo $objPage->arrRow['Package'][0]['PackageName']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Select Wholesaler: </label>
                                                                        <div class="controls">
                                                                            <?php $whid = (isset($_GET['whid'])) ? (int) $_GET['whid'] : $objPage->arrRow['Package'][0]['fkWholesalerID']; ?>
                                                                            <select name="frmWholesalerId" id="frmWholesalerId" onchange="window.location='package_edit_uil.php?type=edit&pkgid=<?php echo $_GET['pkgid']; ?>&whid='+this.value; restore();" class='select2-me input-large'>
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
                                                                        <table align="center" width="100%" border="0" id="productRow" cellpadding="5">

                                                                            <tr>
                                                                                <td>&nbsp;</td>
                                                                                <td><b>*Select Category</b></td>
                                                                                <td><b>*Select Product</b></td>
                                                                                <td colspan="2"><b>Original&nbsp;Price</b></td>
                                                                            </tr>

                                                                            <?php
                                                                            if (isset($_GET['whid']) && ($_GET['whid'] <> $objPage->arrRow['Package'][0]['fkWholesalerID']))
                                                                            {
                                                                                ?>
                                                                                <tr>
                                                                                    <td>Product&nbsp;1:</td>
                                                                                    <td><?php echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmCategoryId[]', 'frmCategoryId', array($objPage->arrRow[0]['fkCategoryID']), 'Select Category', 0, 'onChange="ShowProductForPackage(this.value,1)" class="select2-me input-large"', 1, 1); ?></td>
                                                                                    <td><span id="product1">
                                                                                            <select name="frmProductId[]" onchange="ShowProductPriceForPackage(this.value,1)" class="select2-me input-large">
                                                                                                <option value="0">Product</option>
                                                                                            </select>
                                                                                        </span>
                                                                                    </td>
                                                                                    <td valign="top"><span id="price1"><input type="hidden" name="frmPrice[]" class="input-large" value="0.00" /><b>0.00</b></span></td><td>&nbsp;</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Product&nbsp;2:</td>
                                                                                    <td><?php echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmCategoryId[]', 'frmCategoryId', array($objPage->arrRow[0]['fkCategoryID']), 'Select Category', 0, 'onChange="ShowProductForPackage(this.value,2)" class="select2-me input-large"', 1, 1); ?></td>
                                                                                    <td><span id="product2">
                                                                                            <select name="frmProductId[]" onchange="ShowProductPriceForPackage(this.value,2)" class="select2-me input-large">
                                                                                                <option value="0">Product</option>
                                                                                            </select>
                                                                                        </span>
                                                                                    </td>
                                                                                    <td  valign="top"><span id="price2"><input type="hidden" name="frmPrice[]" class="input-large" value="0.00" /><b>0.00</b></span></td><td><i style="cursor: pointer;" onclick="addDynamicRowToTableForPackage('productRow');"><img src="images/plus.png" /></i></td>
                                                                                </tr>

                                                                                <?php
                                                                            }
                                                                            else
                                                                            {

                                                                                $varLast = count($objPage->arrRow['PackageToProduct']);
                                                                                $PackageToProductCount = 0;
                                                                                //pre($objPage->arrRow['PackageToProduct']);
                                                                                foreach ($objPage->arrRow['PackageToProduct'] as $keyTo => $valTo)
                                                                                {
                                                                                    $keyTo++;
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td>Product&nbsp;<?php echo $keyTo; ?>:</td>
                                                                                        <td>
                                                                                            <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmCategoryId[]', 'frmCategoryId', array($valTo['fkCategoryID']), 'Select Category', 0, 'onchange="ShowProductForPackage(this.value,' . $keyTo . ')"" class="select2-me input-large"', 1, 1); ?>
                                                                                        </td>
                                                                                        <td><span id="product<?php echo $keyTo; ?>">
                                                                                                <select name="frmProductId[]" onchange="ShowProductPriceForPackage(this.value,<?php echo $keyTo; ?>,'edit',<?php echo $valTo['fkProductId']; ?>)" class="select2-me input-large">

                                                                                                    <option value="0">Product</option>
                                                                                                    <?php
                                                                                                    foreach ($valTo['ProductList'] as $keyPro => $valPro)
                                                                                                    {
                                                                                                        ?>
                                                                                                        <option value="<?php echo $valPro['pkProductID']; ?>" <?php
                                                                                    if ($valTo['fkProductId'] == $valPro['pkProductID'])
                                                                                    {
                                                                                        echo 'selected';
                                                                                        $varPrice = $valPro['FinalPrice'];
                                                                                    }
                                                                                                        ?> ><?php echo $valPro['ProductName']; ?></option>
                                                                                                            <?php } ?>
                                                                                                </select>
                                                                                                <div id="ajaxAttribute" class="ajaxAttribute_<?php echo $valTo['fkProductId']; ?>"></div>
                                                                                                <div id="editAttribute" class="editAttribute_<?php echo $valTo['fkProductId']; ?>">
                                                                                                    <?php
                                                                                                    //echo $objPage->arrRow['PackageToProductSelected'][$PackageToProductCount]['pkProductID'].'..'.$valTo['fkProductId'];
                                                                                                   // pre($objPage->arrRow['PackageToProductSelected']);
                                                                                                    if ($valTo['fkProductId'] == $objPage->arrRow['PackageToProductSelected'][$PackageToProductCount]['pkProductID'])
                                                                                                    {
                                                                                                        $arrproductAttrbuteOptionId = explode(",", $objPage->arrRow['PackageToProductSelected'][$PackageToProductCount]['attrbuteOptionId']);
                                                                                                        $arrproductFkAttributeId = explode(",", $objPage->arrRow['PackageToProductSelected'][$PackageToProductCount]['fkAttributeId']);
                                                                                                        $arrproductAttributeLabel = explode(",", $objPage->arrRow['PackageToProductSelected'][$PackageToProductCount]['AttributeLabel']);
                                                                                                        $arrproductOptionTitle = explode(",", $objPage->arrRow['PackageToProductSelected'][$PackageToProductCount]['OptionTitle']);
                                                                                                        $arrproductoptionColorCode = explode(",", $objPage->arrRow['PackageToProductSelected'][$PackageToProductCount]['optionColorCode']);
                                                                                                        $arrproductOptionImage = explode(",", $objPage->arrRow['PackageToProductSelected'][$PackageToProductCount]['OptionImage']);
                                                                                                        $arrproductOptionExtraPrice = explode(",", $objPage->arrRow['PackageToProductSelected'][$PackageToProductCount]['OptionExtraPrice']);
                                                                                                        //pre($arrproductFkAttributeId);
                                                                                                        if (count($arrproductFkAttributeId) > 1)
                                                                                                        {
                                                                                                            foreach ($arrproductFkAttributeId as $k => $valproductAttribute)
                                                                                                            {
                                                                                                                echo '<br>&nbsp;&nbsp;<input onclick="shAttr(' . $keyTo . ',' . $valproductAttribute . ',' . $valTo['fkProductId'] . ',this.id)" type="checkbox" name="pattribute_' . $keyTo . '[' . $valproductAttribute . '_' . $keyTo . ']" id="attr_' . $valproductAttribute . '_' . $keyTo . '" class="pattr" checked="checked">' . $arrproductAttributeLabel[$k] . '<br>';
                                                                                                                $arrData = Home::getAttributeStaticViewDetails($valproductAttribute, $valTo['fkProductId']);
                                                                                                                $arrproductDetailsIsImgUploaded = explode(",", $arrData[0]['IsImgUploaded']);
                                                                                                                $arrproductDetailsOptionImage = explode(",", $arrData[0]['AttributeOptionImage']);
                                                                                                                $arrproductDetailsOptionTitle = explode(",", $arrData[0]['AttributeOptionValue']);
                                                                                                                $arrproductDetailsColorcode = explode(",", $arrData[0]['colorcode']);
                                                                                                                $arrproductDetailsOptionId = explode(",", $arrData[0]['pkOptionID']);
                                                                                                                $arrproductDetailsOptionPrice = explode(",", $arrData[0]['OptionExtraPrice']);
                                                                                                                $varCountAtrributeOption = 0;
                                                                                                                $radioVal = count($arrproductDetailsOptionTitle);
                                                                                                                foreach ($arrproductDetailsOptionTitle as $valoptionTitle)
                                                                                                                {
                                                                                                                    $varOptPrice .=$arrproductDetailsOptionId[$varCountAtrributeOption] . '=' . $objCore->getPrice($arrproductDetailsOptionPrice[$varCountAtrributeOption]) . ',';
                                                                                                                    if ($arrproductDetailsOptionImage[$varCountAtrributeOption] != '')
                                                                                                                    {
                                                                                                                        ?>
                                                                                                                        <img src="<?php echo UPLOADED_FILES_URL; ?>images/products/85x67/<?php echo $arrproductDetailsOptionImage[$varCountAtrributeOption]; ?>">
                                                                                                                    <?php }
                                                                                                                    ?>
                                                                                                                    <input <?php echo ($arrproductAttrbuteOptionId[$k] == $arrproductDetailsOptionId[$varCountAtrributeOption]) ? 'checked="checked"' : ''; ?> type="radio" value="<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>" name="frmAttribute_<?php echo $arrData[0]['pkAttributeId'] . '_' . $keyTo; ?>" class="frmAttribute_<?php echo $arrData[0]['pkAttributeId'] . '_' . $keyTo; ?>" id="frmAttribute_<?php echo $arrData[0]['pkAttributeId'] . '_' . $keyTo; ?>" onclick="getPric(this.id,'<?php echo $keyTo; ?>','<?php echo $arrproductDetailsOptionPrice[$varCountAtrributeOption]; ?>')"/>
                                                                                                                    <?php
                                                                                                                    echo $valoptionTitle;
                                                                                                                    if (($arrproductAttrbuteOptionId[$k] == $arrproductDetailsOptionId[$varCountAtrributeOption]))
                                                                                                                    {
                                                                                                                        $varP +=$arrproductDetailsOptionPrice[$varCountAtrributeOption];
                                                                                                                    }
                                                                                                                    $varCountAtrributeOption++;
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                        ?>
                                                                                                        <?php
                                                                                                    }
                                                                                                    //echo $varP;
                                                                                                    $varPrice+=$varP;
                                                                                                    ?>
                                                                                                </div>
                                                                                            </span>
                                                                                        </td>
                                                                                        <td valign="top"><span id="price<?php echo $keyTo; ?>"><?php
                                                                                    if ($varPrice > 0.00)
                                                                                    {
                                                                                        $varPPrice = $varPrice;
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        $varPPrice = '0.00';
                                                                                    }
                                                                                    echo '<b>' . $varPPrice . '</b>';
                                                                                                    ?>
                                                                                                <input type="hidden" name="frmPrice[]" class="input-large" value="<?php echo $varPPrice; ?>" /></span></td>
                                                                                        <td>
                                                                                            <i>
                                                                                                <?php
                                                                                                if ($keyTo == $varLast)
                                                                                                {
                                                                                                    ?>
                                                                                                    <span style="cursor: pointer;" onclick="addDynamicRowToTableForPackage('productRow');"><img src="images/plus.png" /></span>
                                                                                                <?php } ?>
                                                                                            </i>

                                                                                            <?php
                                                                                            if ($keyTo > 2)
                                                                                            {
                                                                                                ?><a onclick="removeRowFromTableForPackage('productRow','<?php echo $keyTo; ?>',this);return false;" href="#"><img src="images/minus.png"></a><?php } ?>


                                                                                            &nbsp;</td>
                                                                                    </tr>
                                                                                    <?php
                                                                                    $varTotalPrice +=$varPPrice;
                                                                                    $PackageToProductCount++;
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </table>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="" class="control-label">Total Price:</label>
                                                                        <div class="controls">
                                                                            <span id="asc" style="font-weight: bold;"><?php echo $objCore->price_format($varTotalPrice); ?></span><input type="hidden" name="frmTotalPrice" id="frmTotalPrice" value="<?php echo $objCore->price_format($varTotalPrice); ?>"  />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="" class="control-label">*Offer Price:</label>
                                                                        <div class="controls">
                                                                            <input type="text" name="frmOfferPrice" id="frmOfferPrice" class="input-large" value="<?php echo $objCore->price_format($objPage->arrRow['Package'][0]['PackagePrice']); ?>"/>

                                                                        </div>
                                                                    </div>


                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">Package&nbsp;Image:   </label>
                                                                        <div class="controls">
                                                                            <?php
                                                                            if ($objPage->arrRow['Package'][0]['PackageImage'] <> '')
                                                                            {
                                                                                ?>
                                                                                <img src="<?php echo UPLOADED_FILES_URL; ?>images/package/<?php echo PACKAGE_IMAGE_RESIZE1 . '/' . $objPage->arrRow['Package'][0]['PackageImage']; ?>" height="30" width="30" /> <br/>
                                                                            <?php } ?>
                                                                            <input type="file" name="frmPackageImage" id="frmPackageImage" class="input2" />&nbsp;<span style="color: red;">Use image formats : jpg, png, gif</span>
                                                                            <input type="hidden" name="PackageImageHide"  value="<?php echo $objPage->arrRow['Package'][0]['PackageImage']; ?>" class="input2" />
                                                                        </div>
                                                                    </div>

                                                                    <div class="note">Note : * Indicates mandatory fields.</div>

                                                                    <div class="form-actions">
                                                                        <input type="submit" class="btn btn-blue" name="btnPage" value="<?php echo ADMIN_SUBMIT_BUTTON; ?>" style="float:left; margin:5px 15px 0 0; width:80px;"/>
                                                                        <a id="buttonDecoration" href="package_manage_uil.php"><input type="button" class="btn" name="btnTagSettings" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" style="float:left; margin:5px 5px 0 0; width:80px;"/></a>
                                                                        <input type="hidden" name="frmHidenEdit" id="frmHidenEdit" value="edit" />
                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </form>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <table>
                                                            <tr class="content">
                                                                <td valign="top" colspan="2" style="text-align: center;"><?php echo ADMIN_NO_RECORD_FOUND; ?></td>
                                                            </tr>
                                                        </table>
                                                    <?php } ?>
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
