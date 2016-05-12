<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_MANAGE_PACKAGE_CTRL;
require_once CLASSES_PATH . 'class_home_bll.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo EDIT_PACKAGE_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
<!--        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>browse.css"/>-->
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>cropic2.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>croppic.css"/>
        <script type="text/javascript" src="<?php echo JS_PATH ?>browse.js"></script>
        <script type="text/javascript">
            ImageExist='<?php echo count($objPage->arrPackageDetail[0]['PackageImage']); ?>';
        </script>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
        <script type="text/javascript" src="<?php echo JS_PATH ?>bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>jquery.mousewheel.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>croppic.min.product.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>main.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>package_add_edit.js"></script>
        <link rel="stylesheet" href="<?php echo CSS_PATH ?>select2.css"/>
        <script src="<?php echo JS_PATH ?>select2.min.js"></script>
        <script>
            jQuery(document).ready(function() {
                // binds form submission and fields to the validation engine
                jQuery("#update_package").validationEngine();
                $(".select2-me").select2();
            });
        </script>
        <style>.edit_left_sec.edit_left_sec1{ position:relative }
            .offer_price h4{ padding-right:0px;}
            .add_pakage_with .edit_left_sec2{ position:relative}
            .customfile1-feedback-populated{ color:#000000 !important; background:#FFF}
            #s2id_frmCategoryId{ width:414px;}
            .attrDetailsId{ margin-bottom:10px; margin-top:0px; font-weight:normal}
            .select2-container .select2-choice span{ background-position:377px 10px}
            .text{ border:1px solid #bebebf !important}
            #editAttribute .pattr{ margin-top:0px; margin-bottom:0px;}
            #update_package .blankAt{ clear:none; padding-top:0px; width:352px   }
            #editAttribute{ font-size: 13px;width: 294px; padding-top:0px; font-weight:bold; clear:none;float: left;}
            .add_pakage_with li{ width:101%}
            .blankAt{ font-size: 13px;width: 352px; padding-top:0px; font-weight:bold; clear:none;float: left;}
            .delete_icon1{float:right;margin:0px; }
        </style>
    </head>
    <body>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout"></div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>

        </div>

        <div id="ouderContainer" class="ouderContainer_1"><div style="width:100%; height:50px; padding-top:16px;	  border-bottom:1px solid #e7e7e7;"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">
                <div class="add_pakage_outer">
                    <div class="top_container" style="padding-bottom:0px">
                        <div class="top_header border_bottom"><h1><?php echo EDIT; ?> Package</h1></div>

                        <?php
                        if ($objCore->displaySessMsg())
                        {
                            ?>
                            <div style="text-align:center; width: 1000px; color:red">
                                <?php
                                echo $objCore->displaySessMsg();

                                $objCore->setSuccessMsg('');
                                $objCore->setErrorMsg('');
                                ?>
                            </div>
                        <?php }
                        ?>
                    </div>

                    <div class="body_inner_bg" id="edit_style">
                    <?php
	                /**
	                * To show an error if package is created already.
	                * 
	                * @author : Krishna Gupta
	                * 
	                * @created : 29-10-2015
	                */
	                if($objPage->checkUniquePackage) { ?>
                    	<span style="color: red; margin-left: 500px;"> <b>This package is created already.</b> </span>
                    <?php } ?>
                        <form name="packageUpdate" id="update_package" action="" method="POST" onsubmit="return validatePackageForm();" enctype="multipart/form-data">
                            <div class="add_pakage edit_pakage">
                                <!--<div class="back_ankar_sec"><a href="<?php //echo $objCore->getUrl('manage_packages.php');     ?>" class="back"><span><?php //echo BACK;     ?></span></a></div>-->
                                <ul class="add_pakage_inner add_pakage_with">
                                    <?php if (count($objPage->arrPackageDetail) > 0)
                                    {
                                        ?>
                                        <li class="first">
                                            <h3><?php echo PACKAGE_NAME; ?> <span class="red">*</span></h3>
                                            <input class="validate[required] text" name="frmPackageName" id="frmPackageName" package="<?php echo $objPage->arrPackageDetail[0]['pkPackageId']; ?>" oldP="<?php echo $objPage->arrPackageDetail[0]['PackageName'] ?>" type="text" value="<?php echo $objPage->arrPackageDetail[0]['PackageName'] ?>"  style="font-weight:bold; width:400px"/>
                                        </li>
                                        <?php
                                        $varCounter = 0;
                                        $varTotalPrice = 0; //pre($objPage->arrPackageProducts);
                                        $PackageToProductCount = 0;
                                        //pre($objPage->arrPackageProducts);
                                        foreach ($objPage->arrPackageProducts as $keyTo => $val)
                                        {
                                            $keyTo++;
                                            $varTotalPrice+=$val['FinalPrice'];
                                            $varCounter++;
                                            ?>
                                            <li>
                                                <div class="edit_left_sec edit_left_sec1">
                                                    <h3><?php echo SEL_PRO; ?> <?php echo $varCounter; ?><span class="price"><?php echo ORG_PRICE; ?> <span class="red">*</span></span></h3>
                                                    <div class="drop21 dropd2own_2" style="width:423px; float: left">
        <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryList, 'frmCategoryId[]', '', array($val['fkCategoryID']), SEL_CAT, 0, 'onchange="ShowProductForPackage(this.value,' . $keyTo . ');" class="select2-me" style="width:415px"', '1', '1'); ?>
                                                    </div>

                                                    <div class="drop1 dropdown_4" id="product<?php echo $varCounter; ?>">
                                                        <select onchange="ShowProductPriceForPackage(this.value,<?php echo $varCounter; ?>, 'edit',<?php echo $val['pkProductID']; ?>)" name="frmProductId[]" class="drop_down1">
                                                            <?php
                                                            $catProducts = $objPage->getCategoryProduct($val['fkCategoryID']);
                                                            foreach ($catProducts as $arrProduct)
                                                            {
                                                                $selected = $val['pkProductID'] == $arrProduct['pkProductID'] ? 'selected' : '';
                                                                echo '<option ' . $selected . ' value="' . $arrProduct['pkProductID'] . '">' . $arrProduct['ProductName'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <input type="hidden" id="hiddenPrice_<?php echo $varCounter; ?>" value="<?php echo number_format($val['FinalPrice'], 2, '.', '') ?>"/>
                                                    <?php
                                                    //pre($objPage->packageToProductSelected);
                                                    ?>
                                                    <div id="editAttribute" class="editAttribute_<?php echo $val['pkProductID']; ?>">
                                                        <?php
                                                        //pre($objPage->packageToProductSelected);
                                                        //echo $val['pkProductID'].'..'.$objPage->packageToProductSelected[$PackageToProductCount]['pkProductID'];
                                                        if ($val['pkProductID'] == $objPage->packageToProductSelected[$PackageToProductCount]['pkProductID'])
                                                        {
                                                            $arrproductAttrbuteOptionId = explode(",", $objPage->packageToProductSelected[$PackageToProductCount]['attrbuteOptionId']);
                                                            $arrproductFkAttributeId = explode(",", $objPage->packageToProductSelected[$PackageToProductCount]['fkAttributeId']);
                                                            $arrproductAttributeLabel = explode(",", $objPage->packageToProductSelected[$PackageToProductCount]['AttributeLabel']);
                                                            $arrproductOptionTitle = explode(",", $objPage->packageToProductSelected[$PackageToProductCount]['OptionTitle']);
                                                            $arrproductoptionColorCode = explode(",", $objPage->packageToProductSelected[$PackageToProductCount]['optionColorCode']);
                                                            $arrproductOptionImage = explode(",", $objPage->packageToProductSelected[$PackageToProductCount]['OptionImage']);
                                                            $arrproductOptionExtraPrice = explode(",", $objPage->packageToProductSelected[$PackageToProductCount]['OptionExtraPrice']);
                                                            //echo 'hi';
                                                             //echo '<pre>';print_r($arrproductFkAttributeId);
                                                            if (count($arrproductFkAttributeId) >= 1 && $arrproductFkAttributeId[0] != '')
                                                            {
                                                                foreach ($arrproductFkAttributeId as $k => $valproductAttribute)
                                                                {
                                                                    echo '&nbsp;&nbsp;<input onclick="shAttr(' . $keyTo . ',' . $valproductAttribute . ',' . $val['pkProductID'] . ',this.id)" type="checkbox" name="pattribute_' . $keyTo . '[' . $valproductAttribute . '_' . $keyTo . ']" id="attr_' . $valproductAttribute . '_' . $keyTo . '" class="pattr" checked="checked">' . $arrproductAttributeLabel[$k] . '<br>';
                                                                    $arrData = Home::getAttributeStaticViewDetails($valproductAttribute, $val['pkProductID']);
                                                                    $arrproductDetailsIsImgUploaded = explode(",", $arrData[0]['IsImgUploaded']);
                                                                    $arrproductDetailsOptionImage = explode(",", $arrData[0]['AttributeOptionImage']);
                                                                    $arrproductDetailsOptionTitle = explode(",", $arrData[0]['OptionTitle']);
                                                                    $arrproductDetailsOptionAttributeOptionValue = explode(",", $arrData[0]['AttributeOptionValue']);
                                                                    $arrproductDetailsColorcode = explode(",", $arrData[0]['colorcode']);
                                                                    $arrproductDetailsOptionId = explode(",", $arrData[0]['pkOptionID']);
                                                                    $arrproductDetailsOptionPrice = explode(",", $arrData[0]['OptionExtraPrice']);
                                                                    $varCountAtrributeOption = 0;
                                                                    $radioVal = count($arrproductDetailsOptionTitle);
                                                                    ?>
                                                                    <div id="attrDetailsId_attr_<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>_<?php echo $keyTo; ?>" class="attrDetailsId">
                                                                        <?php
                                                                        foreach ($arrproductDetailsOptionTitle as $valoptionTitle)
                                                                        {
                                                                            $varOptPrice .=$arrproductDetailsOptionId[$varCountAtrributeOption] . '=' . $objCore->getPrice($arrproductDetailsOptionPrice[$varCountAtrributeOption]) . ',';
                                                                            if ($arrproductDetailsOptionImage[$varCountAtrributeOption] != '')
                                                                            {
                                                                                ?>
                                                                                <img src="<?php echo UPLOADED_FILES_URL; ?>images/products/85x67/<?php echo $arrproductDetailsOptionImage[$varCountAtrributeOption]; ?>">
                                                                                <?php }
                                                                                ?>
                                                                                <input <?php echo ($arrproductAttrbuteOptionId[$k] == $arrproductDetailsOptionId[$varCountAtrributeOption]) ? 'checked="checked"' : ''; ?> type="radio" value="<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>" vl="<?php echo $arrproductDetailsOptionPrice[$varCountAtrributeOption]; ?>" name="frmAttribute_<?php echo $arrData[0]['pkAttributeId'] . '_' . $keyTo; ?>" class="frmAttribute_<?php echo $arrData[0]['pkAttributeId'] . '_' . $keyTo; ?>" id="frmAttribute_<?php echo $arrData[0]['pkAttributeId'] . '_' . $keyTo; ?>" onclick="getPric(this.parentNode.id, this.id, '<?php echo $keyTo; ?>', '<?php echo $arrproductDetailsOptionPrice[$varCountAtrributeOption]; ?>', 'edit')"/>
                                                                                <?php
                                                                                echo $valoptionTitle;
                                                                                if (($arrproductAttrbuteOptionId[$k] == $arrproductDetailsOptionId[$varCountAtrributeOption]))
                                                                                {
                                                                                    //echo $arrproductDetailsOptionPrice[$varCountAtrributeOption];
                                                                                    $varP +=$arrproductDetailsOptionPrice[$varCountAtrributeOption];
                                                                                    //echo  $varP;die;
                                                                                }
                                                                                $varCountAtrributeOption++;
                                                                            }
                                                                            ?>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                            <?php
                                                        }
                                                        
                                                        $val['FinalPrice']+=$varP;
                                                        $varTotalPrice+=$varP;
                                                        $varP=0;
                                                        ?>
                                                    </div>
                                                    <input id="price<?php echo $varCounter; ?>" class="validate[required]" readonly="true" name="frmPrice[]" type="text" value="<?php echo number_format($val['FinalPrice'], 2, '.', '') ?>"/>

                                                </div>
                                                <?php if ($varCounter > 2)
                                                {
                                                    ?>
                                                    <a href="#" class="delete_icon1"></a>
                                            <?php } ?>
                                            </li>
                                            <?php
                                            $PackageToProductCount++;
                                        }
                                        ?>
                                        <li class="last">
                                            <div class="edit_left_sec">
                                                <div class="offer_price right">
                                                    <h4><?php echo TOTAL_PRICE; ?></h4>
                                                    <input id="frmTotalPrice" readonly="true" type="text" value="<?php echo number_format($varTotalPrice, 2, '.', '') ?>"/>
                                                    <a href="#" class="add_product"><?php echo ADD_MORE_PRODUCT; ?></a>
                                                </div>
                                                <div class="offer_price">
                                                    <h4><?php echo OFF_PRICE; ?> <span class="red">*</span></h4>
<!--                                                    <input numericOnly="yes" class="validate[required,custom[number],min[1],lessThan[frmTotalPrice]]" name="frmOfferPrice" type="text" value="<?php echo number_format($objPage->arrPackageDetail[0]['PackagePrice'], 2, '.', '') ?>" style="text-align:left"/>-->
                                                    
                                                 <div class="msgOffer" style="float: left; width: 146px;">
                                                    <input type="text" style="text-align: left; width: 100%; float: left;" name="frmOfferPrice" class="validate[required,custom[number],min[1],lessThan[frmTotalPrice]]" numericonly="yes" value="<?php echo number_format($objPage->arrPackageDetail[0]['PackagePrice'], 2, '.', '') ?>"/>
                                                    
                                                </div>
                                                    <span style="width: 100%; float: left; margin-top: 10px; font-weight: 600; font-size: 11px;">Note : Offer price should included with margin cost</span>
                                                </div>

                                            </div>

                                        </li>
                                        <li>
                                            <h3  class="simpleBox"><?php echo UPLOAD_PACKAGE_IMAGE; ?><strong> (600x600)</strong></h3>
                                            <?php
                                            $varImg = $objCore->getImageUrl($objPage->arrPackageDetail[0]['PackageImage'], 'package/' . PACKAGE_IMAGE_RESIZE1);
                                            ?>
                                            <div class="uploadImageouter" style="width:100%; float:left;">
                                                <a href="#cropimg_1" onclick="jCroppicPopupOpen('cropimg',1)" class="cropimg" style="z-index:9999999">Upload Image</a>
                                                <div id="cropimg_1" style="display:none;"></div>    
                                                <input type="hidden" name="frmPackageImage" id="after_cropimg_1" value="<?php echo $objPage->arrPackageDetail[0]['PackageImage']; ?>"/>
                                                <span class="myImgSpan" style="margin-left: 15px;"><img src="<?php echo $varImg; ?>"/></span>
                                                </div>
                                            
                                        </li>
                                        <li class="create_cancle_btn">
                                            <input type="hidden" name="frmPackageImg" value="<?php echo $objPage->arrPackageDetail[0]['PackageImage']; ?>" />
                                            <input type="hidden" value="update" name="action" />
                                            <input type="hidden" name="frmWholesalerId" id="frmWholesalerId" value="<?php echo $_SESSION['sessUserInfo']['id']; ?>" />
                                            <input type="hidden" name="pkid" value="<?php echo $objPage->arrPackageDetail[0]['pkPackageId'] ?>" />
                                            <input type="submit" value="Update" class="submit3" style="float:left;" />
                                            <!--<a href="<?php echo $objCore->getUrl('manage_packages.php'); ?>">-->
                                            <input onclick="window.location.href='<?php echo $objCore->getUrl('manage_packages.php'); ?>'" type="button" value="Cancel" class="cancel"/>
                                            <!--</a>-->
                                        </li>
                                    <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <li><?php echo ADMIN_NO_RECORD_FOUND; ?></li>
<?php } ?>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php include_once 'common/inc/footer.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH ?>crop.js"></script>
    </body>
</html>
