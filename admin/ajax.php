<?php
/* * ****************************************
  Module name : Ajax Calls
  Date created : 06 June, 2013
  Date last modified : 06 June, 2013
  Author : Suraj Kumar Maurya
  Last modified by :  Suraj Kumar Maurya
  Comments : This file includes the funtions for AJAX calls.
  Copyright : Copyright (C) 1999-2011 Vinove Software and Services
 * **************************************** */
require_once '../common/config/config.inc.php';
//require_once CONTROLLERS_ADMIN_PATH . FILENAME_ATTRIBUTE_CTRL;
require_once CLASSES_ADMIN_PATH . 'class_attribute_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_category_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_product_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_slider_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_package_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_region_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_wholesaler_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_customer_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_ads_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_adminuser_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_shipping_gateway_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_shipping_gateway_new_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_coupon_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_country_portal_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_order_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_newsletter_bll.php';
require_once CLASSES_PATH . 'class_common.php';
require_once CLASSES_ADMIN_PATH . 'class_dashboard_bll.php';
require_once CLASSES_PATH . 'class_home_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_logistic_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_logistic_portal_bll.php';
require_once CLASSES_LOGISTIC_PATH . 'class_add_zone_bll.php';
require_once CLASSES_LOGISTIC_PATH . 'class_zone_price_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_zone_bll.php';
$varcase = $_REQUEST['action'];
//$categoryAry = $objGeneral->CategoryDropDownList("c.CategoryStatus=1 AND c.CategoryIsDeleted=0 ");
//$arrCategoryDropDownLevel = $objGeneral->CategoryDropDownListLevel("c.CategoryIsDeleted=0 ");


$objClassCommon = new ClassCommon();
$arrCat = $objClassCommon->getCategories();
global $oCache;

$varPortalFilterFK = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs']);
$varPortalFilterPK = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'pkWholesalerID');

function array_is_unique($array) {
    return array_unique($array) == $array;
}

//pre($_REQUEST);
switch ($varcase) {

    case 'checkExistsCategory':
        $objCategory = new category();
        echo $fetchCategoryByName = $objCategory->checkExistsCategory($_REQUEST['catName'], $_REQUEST['cid'], $_REQUEST['pid'], $_REQUEST['lave']);
        break;
    case 'checkEditExistsCategory':
        $objCategory = new category();
        echo $fetchCategoryByName = $objCategory->checkEditExistsCategory($_REQUEST['catName'], $_REQUEST['cid'], $_REQUEST['pid'], $_REQUEST['lave']);
        break;
    case 'ShowCategory':
        echo $objGeneral->CategoryHtml($arrCat, 'frmCategoryId[]', 'frmCategoryId', array(0), 'Select Category', 0, '');

        break;
    case 'ShowCategoryForPackage':
        $showId = $_REQUEST['row'];
        echo $objGeneral->CategoryHtml($arrCat, 'frmCategoryId[]', 'frmCategoryId', array(0), 'Category', 0, 'onChange="ShowProductForPackage(this.value,' . $showId . ')" class="select2-me input-large"', 1, 1);

        break;

    case 'ShowCategoryForPackageFront':
        $showId = $_REQUEST['row'];
        echo $objGeneral->CategoryHtml($arrCat, 'frmCategoryId[]', 'frmCategoryId', array(0), 'Category', 0, 'onChange="ShowProductForPackage(this.value,' . $showId . ')" style="width:429px;"', '1', '1');
        break;

    case 'UpdateAttIcon':
        $opnId = $_REQUEST['opnId'];
        $objAttribute = new attribute();
        $arrAttributeIcon = $objAttribute->GetAttIcon($opnId);
        echo $arrAttributeIcon['OptionImage'];
        break;

    case 'AdminShippingPriceError':
        $uCounryID = array();
        foreach ($_REQUEST['CountryIDArray'] as $key => $val) {
            $uCounryID[] = $val;

            if (in_array($val, $uCounryID)) {
                $minWt[$val][] = $_REQUEST['MinWeightIDArray'][$key];
                $maxWt[$val][] = $_REQUEST['MaxWeightIDArray'][$key];

//                $newarr[$val]=$maxWt;
            }
        }
        //echo array_is_unique($minWt) ? "min unique" : "min non-unique";
        //echo array_is_unique($maxWt) ? "max unique" : "max non-unique";

        foreach ($minWt as $k => $v) {
            if (array_is_unique($minWt[$k])) {
                
            } else {
                echo 'fail';
                die();
            }
        }
        foreach ($maxWt as $k => $v) {
            if (array_is_unique($maxWt[$k])) {
                
            } else {
                echo 'fail';
                die();
            }
        }
        echo 'success';
        break;

    case 'AdminGatewayEmailError':
        $uCounryID = array();
        foreach ($_REQUEST['PortalIDArray'] as $key => $val) {
            //$uCounryID[] = $val;

            if (in_array($val, $uCounryID)) {
                $uCounryID[] = $val;
            }
        }
        pre($uCounryID);
        //echo array_is_unique($minWt) ? "min unique" : "min non-unique";
        //echo array_is_unique($maxWt) ? "max unique" : "max non-unique";

        foreach ($minWt as $k => $v) {
            if (array_is_unique($minWt[$k])) {
                
            } else {
                echo 'fail';
                die();
            }
        }
        foreach ($maxWt as $k => $v) {
            if (array_is_unique($maxWt[$k])) {
                
            } else {
                echo 'fail';
                die();
            }
        }
        echo 'success';
        break;

    case 'ShowCategoryForMultipleProduct':
        $showId = $_REQUEST['row'];
        $varcategoryDrop .= $objGeneral->CategoryHtml($arrCat, 'frmfkCategoryID[]', 'frmCategoryId', array(0), 'Select Category', 0, 'onChange="ShowAttributeMultipleProduct(this.value,' . $showId . ');" style="width:170px;"');
        $varcategoryDrop .='<br /><span><a onclick="return jscall(' . $showId . ')" href="#listed' . $showId . '" class="delete cboxElement">Add Attribute</a></span><div style="display:none;"><div id="listed' . $showId . '"><div style="width: 95%; font-weight: bold;">Select Attributes</div>
            <div id="attribute' . $showId . '"><input type="hidden" name="frmIsAttribute[]" value="0" />Please Select Category</div><br /><input type="button" name="cancel' . $showId . '" id="cancel' . $showId . '" value="Ok" class="btn btn-blue" /></div></div>';
        echo $varcategoryDrop;
        break;
    
    case 'ListOfZones':
        
        $objZone = new Zone();
        $LogisticId = $_REQUEST['LogisticId'];
        $id = $objZone->checkZoneWithNumber($LogisticId);
        break;

    case 'ShowCategoryForMultipleProductFront':
        $showId = $_REQUEST['row'];


        $varcategoryDrop = '<div class="drop1 dropdown_4"><div class="input_star">';
        $varcategoryDrop .= $objGeneral->CategoryHtml($arrCat, 'frmfkCategoryID[]', 'frmfkCategory' . $showId, array(0), SEL_CAT, 0, 'onchange="ShowAttributeMultipleProduct(this.value,' . $showId . ');" class="drop_down1" style="width:178px"', '1', '1');

        $varcategoryDrop .='<small class="star_icon"><img alt="" src="common/images/star_icon.png"></small>
                                                                </div>
                                                            </div><br /><span><a onclick="return jscall33(' . $showId . ')" href="#listed' . $showId . '" class="create_pkg_color_box">Add Attribute</a></span><div style="display:none;"><div style="padding:15px 10px 10px 20px;" id="listed' . $showId . '"><div style="width: 95%; font-weight: bold; padding-bottom: 10px;">Select Attributes</div>
            <div id="attribute' . $showId . '"><input type="hidden" name="frmIsAttribute[]" value="0" />Please Select Category</div><br /><br /><br /><input type="button" name="cancel' . $showId . '" id="cancel' . $showId . '" value="Ok" class="button" style="margin:10px 0 10px 0;" /></div></div>';
        echo $varcategoryDrop;

        break;



    case 'ShowWholeSalersForMultipleProduct':
        $varWholeSalerDrop = '<select name="frmfkWholesalerID[]" style="width:100px;"><option value="0">Select Wholesaler</option>';
        $objwholesaler = new Wholesaler();
        $arrRows = $objwholesaler->WholesalerList();
        foreach ($arrRows as $keySelect => $valSelect) {
            $varWholeSalerDrop .='<option value="' . $valSelect['pkWholesalerID'] . '">' . $valSelect['CompanyName'] . '</option>';
        }
        $varWholeSalerDrop .='</select>';
        echo $varWholeSalerDrop;

        break;

    case 'ShowPackageForMultipleProduct':
        $varPackageDrop = '<select name="frmfkPackageId[]" class="select2-me input-medium frmfkPackageId" ><option value="0">Select package</option>';
        $objPackage = new Product();
        $arrRows = $objPackage->PackageFullDropDownList($varPortalFilterFK, $_POST['wid']);
        foreach ($arrRows as $keySelect => $valSelect) {
            $varPackageDrop .='<option value="' . $valSelect['pkPackageId'] . '">' . $valSelect['PackageName'] . '</option>';
        }
        $varPackageDrop .='</select>';
        echo $varPackageDrop;

        break;

    case 'ShowWholesalerPackage':
        $varPackageDrop = '<select name="frmfkPackageId[]" class="select2-me input-medium frmfkPackageId" ><option value="0">Select package</option>';
        $objPackage = new Product();
        $arrRows = $objPackage->WhlPackageFullDropDownList($_POST['wid']);
        foreach ($arrRows as $keySelect => $valSelect) {
            $varPackageDrop .='<option value="' . $valSelect['pkPackageId'] . '">' . $valSelect['PackageName'] . '</option>';
        }
        $varPackageDrop .='</select>';
        echo $varPackageDrop;

        break;

    case 'ShowPackageForMultipleProductFront':
        $showId = $_REQUEST['row'];
        $varPackageDrop = '<div class="drop1 dropdown_4"><select id="frmfkPackageId' . $showId . '" class="drop_down1" name="frmfkPackageId[]" style="width:100px;"><option value="0">Select package</option>';
        $objPackage = new Product();
        $arrRows = $objPackage->PackageFullDropDownList(" AND fkWholesalerID ='" . $_SESSION['sessUserInfo']['id'] . "'");
        foreach ($arrRows as $keySelect => $valSelect) {
            $varPackageDrop .='<option value="' . $valSelect['pkPackageId'] . '">' . $valSelect['PackageName'] . '</option>';
        }
        $varPackageDrop .='</select></div>';
        echo $varPackageDrop;

        break;

    case 'ChangeProductStatus':
        $objProduct = new Product();
        $varUpdate = $objProduct->updateProductStatus($_POST);
        if ($varUpdate) {
            //Create memcache object
            global $oCache;
            //Check memcache is enabled or not
            if ($oCache->bEnabled) {
                $oCache->flushData();
            }
        }
        $varReqStatus = $_POST['status'];
        //Check if offer product, We can not disable this
        if ($varUpdate == 'offer' && $varReqStatus == 0) {
            echo 'offer';
            die;
        } else if ($varReqStatus == 0) {
            $varSelected1 = '';
            $varSelected2 = 'selected';
        } else {
            $varSelected1 = 'selected';
            $varSelected2 = '';
        }

        if (empty($varSelected1)) {
            ?><a href="javascript:void(0);" class="active" onclick="changeStatus('1',<?php echo $_REQUEST['pid']; ?>)" title="Click here to active this product.">Active</a><?php
        } else {
            echo '<span class="label label-satgreen">Active</span>';
        }
        if (empty($varSelected2)) {
            ?><a href="javascript:void(0);" class="deactive" onclick="changeStatus('0',<?php echo $_REQUEST['pid']; ?>)" title="Click here to deactive this product.">Deactive</a><?php
        } else {
            echo '<span  class="label label label-lightred">Deactive</span>';
        }
        break;

    case 'ChangeHomeBannerStatus':
        $objSlider = new Slider();
        $varUpdate = $objSlider->updateBannerStatus($_POST);
        if ($varUpdate) {
            //Create memcache object
            global $oCache;
            //Check memcache is enabled or not
            if ($oCache->bEnabled) {
                $oCache->flushData();
            }
        }
        $varReqStatus = $_POST['status'];
        if ($varReqStatus == 0) {
            $varSelected1 = '';
            $varSelected2 = 'selected';
        } else {
            $varSelected1 = 'selected';
            $varSelected2 = '';
        }

        if (empty($varSelected1)) {
            ?><a href="javascript:void(0);" class="active" onclick="changeStatus('1',<?php echo $_REQUEST['bid']; ?>)" title="Click here to active this banner.">Active</a><?php
        } else {
            echo '<span class="label label-satgreen">Active</span> ';
        }

        if (empty($varSelected2)) {
            ?><a href="javascript:void(0);" class="deactive" onclick="changeStatus('0',<?php echo $_REQUEST['bid']; ?>)" title="Click here to deactive this banner.">Deactive</a><?php
        } else {
            echo ' <span  class="label label label-lightred">Deactive</span>';
        }

        break;

    case 'ChangeFestivalStatus':
        $objSlider = new Slider();
        $varUpdate = $objSlider->updateFestivalStatus($_POST);
        if ($varUpdate) {
            //Create memcache object
            global $oCache;
            //Check memcache is enabled or not
            if ($oCache->bEnabled) {
                $oCache->flushData();
            }
        }
        $varReqStatus = $_POST['status'];
        if ($varReqStatus == 0) {
            $varSelected1 = '';
            $varSelected2 = 'selected';
        } else {
            $varSelected1 = 'selected';
            $varSelected2 = '';
        }

        if (empty($varSelected1)) {
            ?><a href="javascript:void(0);" class="active" onclick="fconfirm1('Are you sure you want to activate the banner?', '1',<?php echo $_REQUEST['bid']; ?>)">Active</a><?php
        } else {
            echo '<span class="label label-satgreen">Active</span> ';
        }

        if (empty($varSelected2)) {
            ?><a href="javascript:void(0);" class="deactive" onclick="fconfirm1('Are you sure you want to deactivate the banner ?', '0',<?php echo $_REQUEST['bid']; ?>)" title="Click here to deactive this banner.">Deactive</a><?php
        } else {
            echo ' <span  class="label label label-lightred">Deactive</span>';
        }

        break;
    case 'ChangeAdsStatus':
        $objSlider = new Ads();
        $varUpdate = $objSlider->updateAdsStatus($_POST);
        if ($varUpdate) {
            //Create memcache object
            global $oCache;
            //Check memcache is enabled or not
            if ($oCache->bEnabled) {
                $oCache->flushData();
            }
        }
        $varReqStatus = $_POST['status'];
        if ($varReqStatus == 0) {
            $varSelected1 = '';
            $varSelected2 = 'selected';
        } else {
            $varSelected1 = 'selected';
            $varSelected2 = '';
        }

        if (empty($varSelected1)) {
            ?><a href="javascript:void(0);" class="active" onclick="changeStatus('1',<?php echo $_REQUEST['bid']; ?>)" title="Click here to active this banner.">Active</a><?php
        } else {
            echo '<span class="label label-satgreen">Active</span> ';
        }

        if (empty($varSelected2)) {
            ?><a href="javascript:void(0);" class="deactive" onclick="changeStatus('0',<?php echo $_REQUEST['bid']; ?>)" title="Click here to deactive this banner.">Deactive</a><?php
        } else {
            echo ' <span  class="label label label-lightred">Deactive</span>';
        }

        break;

    case 'showFestival':
        $objSlider = new Slider();
        $arrRes = $objSlider->getFestivalByCountry($_POST['cid']);
        $selId = $_POST['selId'];
        $varStr = '<option value="">Select</option>';
        foreach ($arrRes as $key => $val) {
            $sel = ($selId == $val['pkFestivalID']) ? 'selected' : '';
            $varStr .='<option value="' . $val['pkFestivalID'] . '" ' . $sel . '>' . $val['FestivalTitle'] . '</option>';
        }
        echo $varStr;
        break;

    case 'ChangeBannerStatus':
        $objSlider = new Slider();
        $varUpdate = $objSlider->updateStatus($_POST);
        if ($varUpdate) {
            //Create memcache object
            global $oCache;
            //Check memcache is enabled or not
            if ($oCache->bEnabled) {
                $oCache->flushData();
            }
        }
        $varReqStatus = $_POST['status'];
        if ($varReqStatus == 0) {
            $varSelected1 = '';
            $varSelected2 = 'selected';
        } else {
            $varSelected1 = 'selected';
            $varSelected2 = '';
        }

        if (empty($varSelected1)) {
            ?><a href="javascript:void(0);" class="active" onclick="changeStatus('1',<?php echo $_REQUEST['bid']; ?>)" title="Click here to active this banner.">Active</a><?php
        } else {
            echo '<span class="label label-satgreen">Active</span> ';
        }

        if (empty($varSelected2)) {
            ?><a href="javascript:void(0);" class="deactive" onclick="changeStatus('0',<?php echo $_REQUEST['bid']; ?>)" title="Click here to deactive this banner.">Deactive</a><?php
        } else {
            echo ' <span  class="label label label-lightred">Deactive</span>';
        }

        break;


    case 'ChangePackageStatus':
        $objProduct = new Package();
        $varUpdate = $objProduct->updatePackageStatus($_POST);
        $varReqStatus = $_POST['status'];
        if ($varReqStatus == 0) {
            $varSelected1 = '';
            $varSelected2 = 'selected';
        } else {
            $varSelected1 = 'selected';
            $varSelected2 = '';
        }
        ?>
        <?php
        if (empty($varSelected1)) {
            ?><a href="javascript:void(0);" class="active" onclick="changePackageStatus(1,<?php echo $_REQUEST['pkgid']; ?>)" title="Click here to active this package.">Active</a><?php
        } else {
            echo '<span class="label label-satgreen">Active</span>';
        }
        ?>
        <?php
        if (empty($varSelected2)) {
            ?><a href="javascript:void(0);" class="deactive" onclick="changePackageStatus(0,<?php echo $_REQUEST['pkgid']; ?>)" title="Click here to deactive this package.">Deactive</a><?php
        } else {
            echo '<span  class="label label label-lightred">Deactive</span>';
        }
//echo $varcategoryDrop;

        break;
    case 'ChangeCategoryStatus':
        $objCategory = new category();
        $varUpdate = $objCategory->updateCategoryStatus($_POST);
        $varReqStatus = $_POST['status'];
        if ($varReqStatus == 0) {
            $varSelected1 = '';
            $varSelected2 = 'selected';
        } else {
            $varSelected1 = 'selected';
            $varSelected2 = '';
        }

        if (empty($varSelected1)) {
            ?><a href="javascript:void(0);" title="click for active" class="active" onclick="changeStatus('1',<?php echo $_REQUEST['catid']; ?>)">Active</a><?php
        } else {
            echo '<span class="label label-satgreen">Active</span>';
        }
        if (empty($varSelected2)) {
            ?><a href="javascript:void(0);" title="click for deactive" class="deactive" onclick="changeStatus('0',<?php echo $_REQUEST['catid']; ?>)">Deactive</a><?php
        } else {
            echo '<span  class="label label label-lightred">Deactive</span>';
        }


        break;

    case 'ShowAttribute':
        $objAttribute = new attribute();
        $arrAttributeRes = $objAttribute->CategoryToAttribute($_POST['catid']);
        $varStr = '';
//echo '<pre>';
        if ($arrAttributeRes) {
            $varStr = '<input type="hidden" name="frmIsAttribute" value="1" class="input2" />';
            foreach ($arrAttributeRes as $keyAttr => $valueAttr) {

                if ($valueAttr['AttributeInputType'] == 'select' || $valueAttr['AttributeInputType'] == 'radio' || $valueAttr['AttributeInputType'] == 'checkbox') {
                    if ($valueAttr['OptionsRows'] > 0) {
                        $varStr .= '<div class="product_attr"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</div>';
                        foreach ($valueAttr['OptionsData'] as $keyOpt => $valueOpt) {
                            $varStr .= '<div class="product_attr_options"><input type="checkbox" name="frmAttribute[' . $keyAttr . '][]" value="' . $valueOpt['pkOptionID'] . '" caption="' . $valueOpt['OptionTitle'] . '" class="otherstype checkradios" />&nbsp;' . $valueOpt['OptionTitle'] . '<div class="res_caption"></div></div>';
                        }
                        $varStr .='</div>';
                    }
                } else if ($valueAttr['AttributeInputType'] == 'image') {
                    if ($valueAttr['OptionsRows'] > 0) {
                        $varStr .= '<div class="product_attr"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</div>';
                        foreach ($valueAttr['OptionsData'] as $keyOpt => $valueOpt) {
                            $varColorCodeUpdate = $valueOpt['optionColorCode'] != "" ? $valueOpt['optionColorCode'] : $valueOpt['OptionTitle'];
                            $clrCode = '<a href="#" style="background:' . $varColorCodeUpdate . ';margin-right: 10px;padding-left: 20px;"></a>';
                            $varStr .= '<div id="AttIconDefault_' . $valueOpt['pkOptionID'] . '" class="product_attr_img_options">' . $clrCode . '<input type="checkbox" name="frmAttribute[' . $keyAttr . '][]" value="' . $valueOpt['pkOptionID'] . '" caption="' . $valueOpt['OptionTitle'] . '" class="imagetype FetchFromDb" />
                            <input type="hidden" id="frmAttributeDefaultImg_' . $valueOpt['pkOptionID'] . '" path="' . UPLOADED_FILES_URL . 'images/products/85x67/" name="frmAttributeDefaultImg[' . $keyAttr . '][' . $valueOpt['pkOptionID'] . ']" value="' . $valueOpt['OptionImage'] . '" />&nbsp;' . $valueOpt['OptionTitle'] . '<div class="res_attr"></div></div>';
                        }
                        $varStr .='</div>';
                    }
                } else if ($valueAttr['AttributeInputType'] == 'text') {
                    $varStr .= '<div class="product_attr" id="textInput"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</div><input type="text" name="frmAttributeText[' . $keyAttr . '-' . $valueAttr['OptionsData']['0']['pkOptionID'] . ']" value="' . $valueAttr['OptionsData']['0']['OptionTitle'] . '" class="input2" /><span style="cursor: pointer;" onclick="hideInputType(' . "'" . 'textInput' . "'" . ');"><img src="common/images/my_minus.png" alt="Remove" title="Remove" /></span></div>';
                } else if ($valueAttr['AttributeInputType'] == 'textarea') {
                    $varStr .= '<div class="product_attr" id="textAreaInput"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</div><textarea name="frmAttributeTextArea[' . $keyAttr . '-' . $valueAttr['OptionsData']['0']['pkOptionID'] . ']" rows="3" class="input3">' . $valueAttr['OptionsData']['0']['OptionTitle'] . '</textarea><span onclick="hideInputType(' . "'" . 'textAreaInput' . "'" . ');"><img src="images/minus.png" alt="Remove" title="Remove" /></span></div>';
                } else if ($valueAttr['AttributeInputType'] == 'date') {
                    $varStr .= '<div class="product_attr" id="dateInput"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</div><input type="text" name="frmAttributeText[' . $keyAttr . '-' . $valueAttr['OptionsData']['0']['pkOptionID'] . ']" value="" class="tcal input1" /><span style="cursor: pointer;" onclick="hideInputType(' . "'" . 'dateInput' . "'" . ');"><img src="images/minus.png" alt="Remove" title="Remove" /></span></div>';
                }



//print_r($valueAttr);
            }
        } else {
            $varStr = '<input type="hidden" name="frmIsAttribute" value="0" class="input2" /><span class="req">There is no attribute in this category !</span>';
        }
        echo $varStr;
//print_r($arrAttributeRes);

        break;


    case 'ShowAttributeFront':
        $objAttribute = new attribute();
        $arrAttributeRes = $objAttribute->CategoryToAttribute($_POST['catid']);
        $varStr = '';
        if ($arrAttributeRes) {
            $varStr = '<input type="hidden" name="frmIsAttribute" value="1" class="input2" />';
            foreach ($arrAttributeRes as $keyAttr => $valueAttr) {
                if ($valueAttr['AttributeInputType'] == 'select' || $valueAttr['AttributeInputType'] == 'radio' || $valueAttr['AttributeInputType'] == 'checkbox') {
                    if ($valueAttr['OptionsRows'] > 0) {
                        $varStr .= '<b>' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</b>&nbsp;';
                        foreach ($valueAttr['OptionsData'] as $keyOpt => $valueOpt) {
                            $varStr .= '&nbsp;<input type="checkbox" name="frmAttribute[' . $keyAttr . '][]" value="' . $valueOpt['pkOptionID'] . '" />&nbsp;' . $valueOpt['OptionTitle'];
                        }
                        $varStr .='<br /><br />';
                    }
                } else if ($valueAttr['AttributeInputType'] == 'image') {
                    if ($valueAttr['OptionsRows'] > 0) {
                        $varStr .= '<b>' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</b>&nbsp;<br/>';
                        foreach ($valueAttr['OptionsData'] as $keyOpt => $valueOpt) {
                            $varStr .= '<div style="float:left;min-width:400px;">&nbsp;<input type="checkbox" name="frmAttribute[' . $keyAttr . '][]" value="' . $valueOpt['pkOptionID'] . '" class="imagetype" /><input type="hidden" name="frmAttributeDefaultImg[' . $keyAttr . '][' . $valueOpt['pkOptionID'] . ']" value="' . $valueOpt['OptionImage'] . '" />&nbsp;' . $valueOpt['OptionTitle'] . '<img src="' . $objCore->getImageUrl($valueOpt['OptionImage'], 'products/70x70') . '" width="25" height="25" /><div class="res_attr"></div></div><br/>';
                        }
                        $varStr .='<br /><br />';
                    }
                } else if ($valueAttr['AttributeInputType'] == 'text') {
                    $varStr .= '<span id="textInput"><b>' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</b>&nbsp;<input type="text" name="frmAttributeText[' . $keyAttr . '-' . $valueAttr['OptionsData']['0']['pkOptionID'] . ']" value="' . $valueAttr['OptionsData']['0']['OptionTitle'] . '" class="input2" /><span style="cursor: pointer;" onclick="hideInputType(' . "'" . 'textInput' . "'" . ');"><img src="images/minus.png" alt="Remove" title="Remove" /></span><br /><br /></span>';
                } else if ($valueAttr['AttributeInputType'] == 'textarea') {
                    $varStr .= '<span id="textAreaInput"><b>' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):<br /></b>&nbsp;<textarea name="frmAttributeTextArea[' . $keyAttr . '-' . $valueAttr['OptionsData']['0']['pkOptionID'] . ']" rows="3" class="input3">' . $valueAttr['OptionsData']['0']['OptionTitle'] . '</textarea><span onclick="hideInputType(' . "'" . 'textAreaInput' . "'" . ');"><img src="images/minus.png" alt="Remove" title="Remove" /></span><br /><br /></span>';
                } else if ($valueAttr['AttributeInputType'] == 'date') {
                    $varStr .= '<span id="dateInput"><b>' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</b>&nbsp;<input type="text" name="frmAttributeText[' . $keyAttr . '-' . $valueAttr['OptionsData']['0']['pkOptionID'] . ']" value="" class="tcal input1" /><span style="cursor: pointer;" onclick="hideInputType(' . "'" . 'dateInput' . "'" . ');"><img src="images/minus.png" alt="Remove" title="Remove" /></span><br /><br /></span>';
                }



//print_r($valueAttr);
            }
        } else {
            $varStr = '<input type="hidden" name="frmIsAttribute" value="0" class="input2" /><span class="red">There is no attribute in this category !</span>';
        }
        echo $varStr;
//print_r($arrAttributeRes);

        break;

    case 'checkAttributeCode':
        $objAttribute = new attribute();
        $varWhr = "AttributeCode = '" . addslashes($_REQUEST['code']) . "' AND pkAttributeID!='" . $_REQUEST['id'] . "' ";
        $arrAttributeRes = $objAttribute->AttributeList($varWhr);
        echo $varStr = ($arrAttributeRes) ? '0' : '1';

        break;

    case 'ShowAttributeMultipleProduct':
        $objAttribute = new attribute();
        $arrAttributeRes = $objAttribute->CategoryToAttribute($_POST['catid']);
        $varStr = '';
        $vari = $_REQUEST['showid'] - 1;
        $popId = $_REQUEST['showid'];
        if ($arrAttributeRes) {
            $varStr = '<input type="hidden" name="frmIsAttribute[]" value="1" class="input2" />';
            foreach ($arrAttributeRes as $keyAttr => $valueAttr) {

                if ($valueAttr['AttributeInputType'] == 'select' || $valueAttr['AttributeInputType'] == 'radio' || $valueAttr['AttributeInputType'] == 'checkbox') {
                    if ($valueAttr['OptionsRows'] > 0) {
                        $varStr .= '<div class="product_attr" row="' . $vari . '"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</div>';
                        foreach ($valueAttr['OptionsData'] as $keyOpt => $valueOpt) {
                            $varStr .= '<div class="product_attr_options"><input type="checkbox" name="frmAttribute[' . $vari . '][' . $keyAttr . '][]" value="' . $valueOpt['pkOptionID'] . '" caption="' . $valueOpt['OptionTitle'] . '" class="otherstype" />&nbsp;' . $valueOpt['OptionTitle'] . '<div class="res_caption"></div></div>';
                        }
                        $varStr .='</div>';
                    }
                } else if ($valueAttr['AttributeInputType'] == 'image') {
                    if ($valueAttr['OptionsRows'] > 0) {
                        $varStr .= '<div class="product_attr" row="' . $vari . '"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</div>';
                        foreach ($valueAttr['OptionsData'] as $keyOpt => $valueOpt) {
                            $varStr .= '<div class="product_attr_img_options" id="AttIconDefault_' . $valueOpt['pkOptionID'] . '_' . $popId . '">
                            <input type="hidden" id="Popup_ID_' . $valueOpt['pkOptionID'] . '_' . $popId . '" value="' . $popId . '" >
                            <input type="checkbox" Popup_ID="' . $popId . '" name="frmAttribute[' . $vari . '][' . $keyAttr . '][]" value="' . $valueOpt['pkOptionID'] . '" caption="' . $valueOpt['OptionTitle'] . '" class="imagetype FetchFromDb" />
                                <input path="' . UPLOADED_FILES_URL . 'images/products/85x67/" id="frmAttributeDefaultImg_' . $valueOpt['pkOptionID'] . '_' . $popId . '" type="hidden" name="frmAttributeDefaultImg[' . $vari . '][' . $keyAttr . '][' . $valueOpt['pkOptionID'] . ']" value="' . $valueOpt['OptionImage'] . '" />&nbsp;' . $valueOpt['OptionTitle'] .
                                    '<img style="display:none;" src="' . $objCore->getImageUrl($valueOpt['OptionImage'], 'products/70x70') . '" width="25" height="25" />
                                        <div class="res_attr" id="' . $vari . '"></div></div>';
                        }
                        $varStr .='</div>';
                    }
                } else if ($valueAttr['AttributeInputType'] == 'text') {
                    $varStr .= '<div class="product_attr" id="textInput' . $vari . '" row="' . $vari . '"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</div><input type="text" name="frmAttributeText[][' . $keyAttr . '-' . $valueAttr['OptionsData']['0']['pkOptionID'] . ']" value="' . $valueAttr['OptionsData']['0']['OptionTitle'] . '" class="input1" /><span style="cursor: pointer;" onclick="hideInputType(' . "'" . 'textInput' . $vari . "'" . ');"><img src="images/minus.png" alt="" title="Remove ' . $valueAttr['AttributeLabel'] . '(' . $valueAttr['AttributeCode'] . ')" /></span></div>';
                } else if ($valueAttr['AttributeInputType'] == 'textarea') {
                    $varStr .= '<div class="product_attr" id="textAreaInput' . $vari . '" row="' . $vari . '"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</div><textarea name="frmAttributeTextArea[][' . $keyAttr . '-' . $valueAttr['OptionsData']['0']['pkOptionID'] . ']" rows="2" class="input2">' . $valueAttr['OptionsData']['0']['OptionTitle'] . '</textarea><span style="cursor: pointer;" onclick="hideInputType(' . "'" . 'textAreaInput' . $vari . "'" . ');"><img src="images/minus.png" align="top" alt="" title="Remove ' . $valueAttr['AttributeLabel'] . '(' . $valueAttr['AttributeCode'] . ')" /></span><div>';
                } else if ($valueAttr['AttributeInputType'] == 'date') {
                    $varStr .= '<div class="product_attr" id="dateInput' . $vari . '" row="' . $vari . '"><div class="product_attr_name">' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</div><input type="text" name="frmAttributeText[' . $keyAttr . '-' . $valueAttr['OptionsData']['0']['pkOptionID'] . ']" value="" class="tcal input1" /><span style="cursor: pointer;" onclick="hideInputType(' . "'" . 'dateInput' . $vari . "'" . ');"><img src="images/minus.png" alt="Remove" title="Remove" /></span></div>';
                }


//print_r($valueAttr);
            }
        } else {
            $varStr = '<input type="hidden" name="frmIsAttribute[]" value="0" class="input2" /><span class="req">There is no attribute in this category !</span>';
        }
        echo $varStr;
//print_r($arrAttributeRes);

        break;

    case 'ShowAttributeMultipleProductFront':
        $objAttribute = new attribute();
        $arrAttributeRes = $objAttribute->CategoryToAttribute($_POST['catid']);
        $varStr = '';
        $vari = $_REQUEST['showid'] - 1;
        if ($arrAttributeRes) {
            $varStr = '<input type="hidden" name="frmIsAttribute[]" value="1" class="input2" />';
            foreach ($arrAttributeRes as $keyAttr => $valueAttr) {

                if ($valueAttr['AttributeInputType'] == 'select' || $valueAttr['AttributeInputType'] == 'radio' || $valueAttr['AttributeInputType'] == 'checkbox') {
                    if ($valueAttr['OptionsRows'] > 0) {
                        $varStr .= '<b>' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</b>&nbsp;';
                        foreach ($valueAttr['OptionsData'] as $keyOpt => $valueOpt) {
                            $varStr .= '&nbsp;<input type="checkbox" name="frmAttribute[' . $vari . '][' . $keyAttr . '][]" value="' . $valueOpt['pkOptionID'] . '" />&nbsp;' . $valueOpt['OptionTitle'];
                        }
                        $varStr .='<br /><br />';
                    }
                } else if ($valueAttr['AttributeInputType'] == 'image') {
                    if ($valueAttr['OptionsRows'] > 0) {
                        $varStr .= '<b>' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</b>&nbsp;<br>';
                        foreach ($valueAttr['OptionsData'] as $keyOpt => $valueOpt) {
                            $varStr .= '<div style="float:left;width:100%">&nbsp;<input type="checkbox" name="frmAttribute[' . $vari . '][' . $keyAttr . '][]" value="' . $valueOpt['pkOptionID'] . '" class="imagetype" />
                                <input type="hidden" name="frmAttributeDefaultImg[' . $vari . '][' . $keyAttr . '][' . $valueOpt['pkOptionID'] . ']" value="' . $valueOpt['OptionImage'] . '" />&nbsp;' . $valueOpt['OptionTitle'] .
                                    '<img src="' . $objCore->getImageUrl($valueOpt['OptionImage'], 'products/70x70') . '" width="25" height="25" />
                                        <div class="res_attr" id="' . $vari . '"></div></div>';
                        }
                        $varStr .='<br /><br />';
                    }
                } else if ($valueAttr['AttributeInputType'] == 'text') {
                    $varStr .= '<span id="textInput' . $vari . '"><b>' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</b>&nbsp;<input type="text" name="frmAttributeText[][' . $keyAttr . '-' . $valueAttr['OptionsData']['0']['pkOptionID'] . ']" value="' . $valueAttr['OptionsData']['0']['OptionTitle'] . '" class="input1" /><span style="cursor: pointer;" onclick="hideInputType(' . "'" . 'textInput' . $vari . "'" . ');"><img src="images/minus.png" alt="" title="Remove ' . $valueAttr['AttributeLabel'] . '(' . $valueAttr['AttributeCode'] . ')" /></span><br /><br /></span>';
                } else if ($valueAttr['AttributeInputType'] == 'textarea') {
                    $varStr .= '<span id="textAreaInput' . $vari . '"><b>' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):<br /></b>&nbsp;<textarea name="frmAttributeTextArea[][' . $keyAttr . '-' . $valueAttr['OptionsData']['0']['pkOptionID'] . ']" rows="2" class="input2">' . $valueAttr['OptionsData']['0']['OptionTitle'] . '</textarea><span style="cursor: pointer;" onclick="hideInputType(' . "'" . 'textAreaInput' . $vari . "'" . ');"><img src="images/minus.png" align="top" alt="" title="Remove ' . $valueAttr['AttributeLabel'] . '(' . $valueAttr['AttributeCode'] . ')" /></span><br /><br /></span>';
                } else if ($valueAttr['AttributeInputType'] == 'date') {
                    $varStr .= '<span id="dateInput' . $vari . '"><b>' . $valueAttr['AttributeLabel'] . ' (' . $valueAttr['AttributeCode'] . '):</b>&nbsp;<input type="text" name="frmAttributeText[' . $keyAttr . '-' . $valueAttr['OptionsData']['0']['pkOptionID'] . ']" value="" class="tcal input1" /><span style="cursor: pointer;" onclick="hideInputType(' . "'" . 'dateInput' . $vari . "'" . ');"><img src="images/minus.png" alt="Remove" title="Remove" /></span><br /><br /></span>';
                }


//print_r($valueAttr);
            }
        } else {
            $varStr = '<input type="hidden" name="frmIsAttribute[]" value="0" class="input2" /><span class="req">There is no attribute in this category !</span>';
        }
        echo $varStr;
//print_r($arrAttributeRes);

        break;

    case 'ShowProductForPackage':
        $showId = $_REQUEST['showid'];
        $varPackageDrop = '<select name="frmProductId[]" class="packageProduct" style="width:170px;" onchange="ShowProductPriceForPackage(this.value,' . $showId . ')"><option value="0">Product</option>';
        $objPackage = new Product();
        $arrRows = $objPackage->ProductListForPackage("fkCategoryID ='" . $_REQUEST['catid'] . "' AND fkWholesalerID='" . $_REQUEST['whid'] . "'");
        foreach ($arrRows as $keySelect => $valSelect) {
            $varPackageDrop .='<option value="' . $valSelect['pkProductID'] . '">' . $valSelect['ProductName'] . '</option>';
        }
        $varPackageDrop .='</select>';
        echo $varPackageDrop;

        break;
    case 'ResetProductForPackage':
        $categoryAry = $objGeneral->CategoryDropDownList("c.CategoryStatus=1 AND c.CategoryIsDeleted=0 ");
        $varcategoryDrop = '<option value="0">Category</option>';
        foreach ($categoryAry as $keySelect => $valSelect) {
// $varcategoryDrop .='<option value="' . $keySelect . '">' . str_replace("'", '', $valSelect) . '</option>';
            if ($arrCategoryDropDownLevel[$keySelect] == 0) {
                $catClass = "level1";
            } else if ($arrCategoryDropDownLevel[$keySelect] > 1) {
                $catClass = "level2";
            } else {
                $catClass = "";
            }
            $varcategoryDrop .='<option value="' . $keySelect . '" class="catOpt ' . $catClass . '">' . $valSelect . '</option>';
        }

        echo $varcategoryDrop;
        break;
    case 'ShowProductPriceForPackage':

        $objPackage = new Product();
        $objHome = new Home();
        $arrData = $objHome->getQuickViewDetails($_REQUEST['pid']);
        $arrRows = $objPackage->ProductPriceForPackage('pkProductID =' . $_REQUEST['pid']);
        $varPackageDrop = '<input type="hidden" name="frmPrice[]" class="input1" value="' . $arrRows[0]['FinalPrice'] . '" /><b class="packageProductPrice">' . $arrRows[0]['FinalPrice'] . '</b>';
        if (count($arrData[0]['arrAttributes']) == 0) {
            echo $varPackageDrop;
            echo '++noattr';
        } else {
            $ii = $_REQUEST['showid'];
            foreach ($arrData[0]['arrAttributes'] as $valproductAttribute) {

                echo '&nbsp;&nbsp;<input onclick="shAttr(' . $ii . ',' . $valproductAttribute['pkAttributeId'] . ',' . $_REQUEST['pid'] . ',this.id)" type="checkbox" name="pattribute_' . $ii . '[' . $valproductAttribute['pkAttributeId'] . '_' . $ii . ']" id="attr_' . $valproductAttribute['pkAttributeId'] . '_' . $ii . '" class="pattr">' . $valproductAttribute['AttributeLabel'];
            }
            echo '++attr++';
            echo $varPackageDrop;
        }


        break;

    case 'ShowProductPriceForPackageFront':

        $objPackage = new Product();
        $objHome = new Home();
        $arrData = $objHome->getQuickViewDetails($_REQUEST['pid']);
        $arrRows = $objPackage->ProductPriceForPackage('pkProductID =' . $_REQUEST['pid']);
        $varPackageDrop = $arrRows[0]['FinalPrice'];
        if (count($arrData[0]['arrAttributes']) == 0) {
            echo $varPackageDrop;
            echo '++noattr';
        } else {
            $ii = $_REQUEST['showid'];
            foreach ($arrData[0]['arrAttributes'] as $valproductAttribute) {

                echo '&nbsp;&nbsp;<input onclick="shAttr(' . $ii . ',' . $valproductAttribute['pkAttributeId'] . ',' . $_REQUEST['pid'] . ',this.id)" type="checkbox" name="pattribute_' . $ii . '[' . $valproductAttribute['pkAttributeId'] . '_' . $ii . ']" id="attr_' . $valproductAttribute['pkAttributeId'] . '_' . $ii . '" class="pattr">&nbsp;&nbsp;' . $valproductAttribute['AttributeLabel'] . '<br>';
            }
            echo '++attr++';
            echo $varPackageDrop;
        }

        break;

    case 'checkProductRefNo':
        $objPackage = new Product();
        $arrNum = $objPackage->CountProductRefNo(" AND ProductRefNo ='" . $_REQUEST['refno'] . "'");
        if ($arrNum == 0) {
            $varStr = '<input type="hidden" name="frmIsRefNo" value="0" />';
        } else {
            $varStr = 'Product Ref No. allready Exist. Please change.<input type="hidden" name="frmIsRefNo" value="1" />';
        }
        echo $varStr;

        break;

    case 'checkProductRefNoForMultiple':
        $showId = $_REQUEST['showid'];
        $objPackage = new Product();
        $pid = $_REQUEST['pid'] > 0 ? "AND pkProductID!='" . $_REQUEST['pid'] . "'" : '';
        $wher = " AND ProductRefNo ='" . $_REQUEST['refno'] . "' $pid";
        $arrNum = $objPackage->CountProductRefNo($wher);
        if ($arrNum == 0) {
            $varStr = '<input type="hidden" name="frmIsRefNo[]" value="0" />';
        } else {
            $varStr = 'Product Ref No. already Exist.<input type="hidden" name="frmIsRefNo[]" value="1" />';
        }
        echo $varStr;

        break;

    case 'AddPackage':

        $objClassCommon = new ClassCommon();
        $varPackageACPrice = $objClassCommon->getAcCostForPackage($_REQUEST['offerprice']);

        $arrPackage = array(
            'fkWholesalerID' => $_REQUEST['whid'],
            'PackageName' => $_REQUEST['pkgnm'],
            'ProIds' => $_REQUEST['pids'],
            'PackageACPrice' => $varPackageACPrice,
            'OfferPrice' => $_REQUEST['offerprice']
        );

        $objPackage = new Product();
        $insertedId = $objPackage->addPackage($arrPackage);

        $varPackageDrop = $insertedId . 'skm#skm<select name="frmfkPackageId" onchange="showPackageProduct(this.value);"><option value="0">Select Package</option>';
        $arrRows = $objPackage->PackageFullDropDownList();
        foreach ($arrRows as $keySelect => $valSelect) {
            $selected = ($insertedId == $valSelect['pkPackageId']) ? 'selected' : '';
            $varPackageDrop .='<option value="' . $valSelect['pkPackageId'] . '" ' . $selected . '>' . $valSelect['PackageName'] . '</option>';
        }
        $varPackageDrop .='</select>';
        echo $varPackageDrop;
        break;

    case 'ShowRegion':
        $objAdminUser = new AdminUser();
        $arrRows = $objAdminUser->getRegion('fkCountryId =' . $_REQUEST['ctyid']);
        echo '<select name="frmRegion" id="frmRegion" class="select2-me input-xlarge"><option value="0">Select Region</option>';
        foreach ($arrRows as $k => $v) {
            echo '<option value="' . $v['pkRegionID'] . '">' . $v['RegionName'] . '</option>';
        }
        echo '</select>';

        break;
    case 'getTimeZone':
        $countryID = $_REQUEST['q'];

        $objlogistic = new Logistic();
        $arrRows = $objlogistic->zoneList($countryID);
        echo '<select name="frmCompanyTimeZone" id="frmCompanyTimeZone" class="drop_down1">';
        foreach ($arrRows as $k => $v) {
            echo '<option value="' . trim($v['time_zone']) . '">' . trim($v['time_zone']) . '</option>';
        }

        echo '</select>';
        die;
        break;
    case 'ShowStateByCountry':
        $stateId = $_REQUEST['stateid'];
        $objAdminUser = new AdminUser();
        $arrRows = $objAdminUser->getStateByCountry("fkCountryID ='" . $_REQUEST['ctyid'] . "'");

        echo '<option value="">Select</option>';

        foreach ($arrRows as $k => $v) {
            $selected = ($stateId == $v['pkStateID']) ? ' selected="selected" ' : '';
            echo '<option value="' . $v['pkStateID'] . '" ' . $selected . '>' . $v['StateName'] . '</option>';
        }

        break;

    case 'deleteImage':
        $objProduct = new Product();
        $arrNum = $objProduct->deleteImage($_REQUEST['imgid']);
        echo '<span class="req red">Deleted</span>';
        break;

    case 'DeleteShipPriceRow':
        $objShippingGateway = new ShippingGatewayNew();
        $arrNum = $objShippingGateway->DeleteShipPriceRow($_REQUEST['priceID']);
        echo '<span class="req red">Deleted</span>';
        break;
    case 'DeleteShipGateway':
        $objShippingGateway = new ShippingGatewayNew();
        $arrNum = $objShippingGateway->DeleteShipGatewayRow($_REQUEST['gatwayID']);
        echo '<span class="req red">Deleted</span>';
        break;

    case 'checkExistRegion':
        $objRegion = new region();
        $varRegionName = $_POST['regionName'];
        $varRegionId = $_POST['regionId'];
        $varRes = $objRegion->IsRegionExist($varRegionName, $varRegionId);
        echo $varRes[0]['ids'];
        break;

    case 'getCountryRegion':
        $objWholesaler = new Wholesaler();
        $varCountryId = $_POST['countryId'];
        $varRes = $objWholesaler->getCountryRegion($varCountryId);
        $varHtml = '';
        foreach ($varRes as $val) {
            $varHtml.='<option value="' . $val['pkRegionID'] . '">' . $val['RegionName'] . '</option>';
        }
        echo $varHtml;
        break;

    case 'ChangeShippingGatewayStatus':
        $objShippingGateway = new ShippingGateway();
        $varUpdate = $objShippingGateway->updateShippingGatewayStatus($_POST);
        $varReqStatus = $_POST['status'];
        if ($varReqStatus == 0) {
            $varSelected1 = '';
            $varSelected2 = 'selected';
        } else {
            $varSelected1 = 'selected';
            $varSelected2 = '';
        }
        /* $varStr = '<select onchange="changeStatus(this.value,' . $_REQUEST['sgid'] . ')"><option value="1"' . $varSelected1 . '>Active</option>
          <option value="0" ' . $varSelected2 . '>Deactive</option></select></select>';
         * 
         */
        ?>

        <?php
        if (empty($varSelected1)) {
            ?><a href="javascript:void(0);" class="active" onclick="changeStatus('1',<?php echo $_REQUEST['sgid']; ?>)" title="Click here to active this package.">Active</a><?php
        } else {
            echo '<span class="label label-satgreen">Active</span>';
        }
        ?>
        <?php
        if (empty($varSelected2)) {
            ?><a href="javascript:void(0);" class="deactive" onclick="changeStatus('0',<?php echo $_REQUEST['sgid']; ?>)" title="Click here to deactive this package.">Deactive</a><?php
        } else {
            echo '<span  class="label label label-lightred">Deactive</span>';
        }
//echo $varStr;

        break;

    case 'ChangeShippingGatewayStatusNew':
        $objShippingGateway = new ShippingGatewayNew();
        $varUpdate = $objShippingGateway->updateShippingGatewayStatus($_POST);
        $varReqStatus = $_POST['status'];
        if ($varReqStatus == 0) {
            $varSelected1 = '';
            $varSelected2 = 'selected';
        } else {
            $varSelected1 = 'selected';
            $varSelected2 = '';
        }
        /* $varStr = '<select onchange="changeStatus(this.value,' . $_REQUEST['sgid'] . ')"><option value="1"' . $varSelected1 . '>Active</option>
          <option value="0" ' . $varSelected2 . '>Deactive</option></select></select>';
         * 
         */
        ?>

        <?php
        if (empty($varSelected1)) {
            ?><a href="javascript:void(0);" class="active" onclick="changeStatus('1',<?php echo $_REQUEST['sgid']; ?>)" title="Click here to active this package.">Active</a><?php
        } else {
            echo '<span class="label label-satgreen">Active</span>';
        }
        ?>
        <?php
        if (empty($varSelected2)) {
            ?><a href="javascript:void(0);" class="deactive" onclick="changeStatus('0',<?php echo $_REQUEST['sgid']; ?>)" title="Click here to deactive this package.">Deactive</a><?php
        } else {
            echo '<span  class="label label label-lightred">Deactive</span>';
        }
//echo $varStr;

        break;


    case 'Changelogisticportalstatus':
        $objlogisticPortal = new logistic();
        $varUpdate = $objlogisticPortal->updatelogicalportalStatus($_POST);
         $varReqStatus = $varUpdate;
        // pre($varReqStatus);
        //echo gettype($_POST['status']);

        if ($varReqStatus === 'exist') {
//            echo '56566';
            $varSelected1 = 'selected';
            $varSelected2 = '';
            $retuenStatus['status'] = 'exist';
        } else if ($varReqStatus && $_POST['status'] == '0') {
//            echo '232323';
            $varSelected1 = '';
            $varSelected2 = 'selected';
            $retuenStatus['status'] = true;
        } else {
//            echo '787878';
            $varSelected1 = 'selected';
            $varSelected2 = '';
            $retuenStatus['status'] = true;
        }
//        $varReqStatus = $_POST['status'];
//        if ($varReqStatus == 0) {
//            $varSelected1 = '';
//            $varSelected2 = 'selected';
//        } else {
//            $varSelected1 = 'selected';
//            $varSelected2 = '';
//        }
        /* $varStr = '<select onchange="changeStatus(this.value,' . $_REQUEST['sgid'] . ')"><option value="1"' . $varSelected1 . '>Active</option>
          <option value="0" ' . $varSelected2 . '>Deactive</option></select></select>';
         *
         */
        ?>

        <?php
        if (empty($varSelected1)) {
            $onClick = 'changeStatus(1, ' . $_REQUEST['sgid'] . ')';
            $retuenStatus['html'] = "<a href='javascript:void(0);' class='active' onclick='" . $onClick . "' title='Click here to active this method.'>Active</a> ";
        } else {
            $retuenStatus['html'] .= "<span class='label label-satgreen'>Active</span>";
        }
        ?>
        <?php
        if (empty($varSelected2)) {
            $onClick1 = 'changeStatus(0, ' . $_REQUEST['sgid'] . ')';
            $retuenStatus['html'] .= "<a href='javascript:void(0);' class='deactive' onclick='" . $onClick1 . "' title='Click here to deactive this method.'>Deactive</a> ";
        } else {
            $retuenStatus['html'] .= "<span  class='label label label-lightred'>Deactive</span>";
        }
        //pre($retuenStatus);
        echo json_encode($retuenStatus);
        //$sucessmsg="changed Sucessfully";
        //$objCore->setSuccessMsg("Status change Successfully");
        break;

    case 'Changeshippingmethodstatus':

        $objShippingGateway = new ShippingGateway();
        
            $varUpdate = $objShippingGateway->updateshippingmethodsStatus($_POST);
        
        
//        if ($varUpdate == 'exist') {
//            $varReqStatus = 'exist';
//        } else {
//            $varReqStatus = $_POST['status'];
//        }

        $varReqStatus = $varUpdate;
        //echo gettype($_POST['status']);

        if ($varReqStatus === 'exist') {
//            echo '56566';
            $varSelected1 = 'selected';
            $varSelected2 = '';
            $retuenStatus['status'] = 'exist';
        } else if ($varReqStatus && $_POST['status'] == '0') {
//            echo '232323';
            $varSelected1 = '';
            $varSelected2 = 'selected';
            $retuenStatus['status'] = true;
        } else {
//            echo '787878';
            $varSelected1 = 'selected';
            $varSelected2 = '';
            $retuenStatus['status'] = true;
        }
        ?>

        <?php
        if (empty($varSelected1)) {
            $onClick = 'changeStatus(1, ' . $_REQUEST['sgid'] . ')';
            $retuenStatus['html'] = "<a href='javascript:void(0);' class='active' onclick='" . $onClick . "' title='Click here to active this method.'>Active</a> ";
        } else {
            $retuenStatus['html'] .= "<span class='label label-satgreen'>Active</span>";
        }
        ?>
        <?php
        if (empty($varSelected2)) {
            $onClick1 = 'changeStatus(0, ' . $_REQUEST['sgid'] . ')';
            $retuenStatus['html'] .= "<a href='javascript:void(0);' class='deactive' onclick='" . $onClick1 . "' title='Click here to deactive this method.'>Deactive</a> ";
        } else {
            $retuenStatus['html'] .= "<span  class='label label label-lightred'>Deactive</span>";
        }
        //pre($retuenStatus);
        echo json_encode($retuenStatus);
        //$sucessmsg="changed Sucessfully";
        //$objCore->setSuccessMsg("Status change Successfully");
        break;

    case 'ShowCategoryForCoupon':
        $showId = $_REQUEST['showid'];
        //$varcategoryDrop = $objGeneral->CategoryHtml($arrCat, 'frmCategoryId[]', 'frmCategoryId', array(0), 'Select Category', 0, 'onChange="ShowProductForCoupon(this.value,' . $showId . ')" style="width:170px;"');

        $varcategoryDrop = $objGeneral->CategoryHtml($arrCat, 'frmCategoryId[]', 'frmCategoryId', array(0), 'Select Category', 0, ' onchange="ShowProductForCoupon(this.value,' . $showId . ')" class="select2-me input-xlarge"', 1, 1);

        $varcategoryDrop .='<span id="pro' . $showId . '"><select name="frmProductId[]" onchange="ShowProductPriceForCoupon(this.value,' . $showId . ');" style="width:170px; margin-left:10px;"><option value="0">Select Product</option></select></span>&nbsp;$ <span id="price' . $showId . '" style="font-weight:bold;">0.0000</span>';
        echo $varcategoryDrop;
        /* $varcategoryDrop = '<select name="frmCategoryId[]" onchange="ShowProductForCoupon(this.value,' . $showId . ');" style="width:170px;"><option value="0">Select Category</option>';
          foreach ($categoryAry as $keySelect => $valSelect) {
          $varcategoryDrop .='<option value="' . $keySelect . '">' . str_replace("'", '', $valSelect) . '</option>';
          }
          $varcategoryDrop .='</select><span id="pro' . $showId . '"><select name="frmProductId[]" onchange="ShowProductPriceForCoupon(this.value,' . $showId . ');" style="width:170px; margin-left:10px;"><option value="0">Select Product</option></select></span>&nbsp;$ <span id="price' . $showId . '" style="font-weight:bold;">0.0000</span>';
          echo $varcategoryDrop; */
        break;

    case 'ShowProductForCoupon':
        $showId = $_REQUEST['showid'];
        $varPackageDrop = '<select name="frmProductId[]" style="width:170px; margin-left:10px;" onchange="ShowProductPriceForCoupon(this.value,' . $showId . ')"><option value="0">Select Product</option>';
        $objPackage = new Product();
        $arrRows = $objPackage->ProductListForPackage('fkCategoryID =' . $_REQUEST['catid']);
        foreach ($arrRows as $keySelect => $valSelect) {
            $varPackageDrop .='<option value="' . $valSelect['pkProductID'] . 'vss' . $valSelect['FinalPrice'] . '">' . $valSelect['ProductName'] . '</option>';
        }
        $varPackageDrop .='</select>';
        echo $varPackageDrop;

        break;

    case 'checkCouponCode':
        $objCoupon = new Coupon();
        $varWhr = " AND CouponCode ='" . $_REQUEST['code'] . "'";
        if ($_REQUEST['id'] > 0) {
            $varWhr = $varWhr . ' AND pkCouponID !=' . $_REQUEST['id'];
        }

        $varNum = $objCoupon->CountCouponCode($varWhr);
        echo $varNum;

        break;

    case 'showRegionForWholesaler':
        $varWholeSalerDrop = '<option value="0">Select </option>';
        $objwholesaler = new Wholesaler();
        $arrRows = $objwholesaler->regionList('fkCountryId=' . $_REQUEST['q']);
        foreach ($arrRows as $keySelect => $valSelect) {
            $varWholeSalerDrop .='<option value="' . $valSelect['pkRegionID'] . '">' . $valSelect['RegionName'] . '</option>';
        }
        echo $varWholeSalerDrop;

        break;

    case 'showShippingMethod':
        $selId = $_REQUEST['selId'];
        $varWholeSalerDrop = '<option value="0">Select Shipping Method</option>';
        $objShippingGateway = new ShippingGateway();
        $arrRows = $objShippingGateway->shippingMethodList("fkShippingGatewayID = '" . $_REQUEST['q'] . "' ");
        foreach ($arrRows as $keySelect => $valSelect) {
            $selected = ($valSelect['pkShippingMethod'] == $selId) ? 'selected="selected"' : '';
            $varWholeSalerDrop .='<option value="' . $valSelect['pkShippingMethod'] . '" ' . $selected . '>' . $valSelect['MethodName'] . ' (' . $valSelect['MethodCode'] . ')</option>';
        }
        echo $varWholeSalerDrop;

        break;

    case 'showShippingPortal':
        $selId = $_REQUEST['selId'];

        $varWholeSalerDrop = '<option value="0">Select Shipping  Method</option>';
        $arrRows = $objGeneral->getmethodnamebylogisticid($_REQUEST['q'], $selId);
        //pre($arrRows);
        //$objShippingGateway = new ZonePriceNew();
        // $arrRows = $objShippingGateway->shippingCountryPortalList("fkportalID = " . $_REQUEST['q'] . " AND ShippingStatus = 1" );
        foreach ($arrRows as $keySelect => $valSelect) {
            $selected = ($valSelect['pkShippingMethod'] == $selId) ? 'selected="selected"' : '';
            $varWholeSalerDrop .='<option value="' . $valSelect['pkShippingMethod'] . '" ' . $selected . '>' . $valSelect['MethodName'] . '</option>';
        }
        echo $varWholeSalerDrop;

        break;

    case 'showCountryState':
        $country_id = $_REQUEST['country_id'];
       // pre($_REQUEST);
        $varWholeSalerDrop = '<option value="0">Select State</option>';
        $objGeneral = new General();
        $arrRows = $objGeneral->statelistbycountryid($_REQUEST['q']);
        //$arrRows = $objShippingGateway->statelistbycountryid("fkportalID = " . $_REQUEST['q'] . " AND ShippingStatus = 1" );
        foreach ($arrRows as $keySelect => $valSelect) {
            $selected = ($valSelect['id'] == $selId) ? 'selected="selected"' : '';
            $varWholeSalerDrop .='<option value="' . $valSelect['id'] . '" ' . $selected . '>' . $valSelect['name'] . '</option>';
        }
        echo $varWholeSalerDrop;

        break;

    case 'showStateCity':
        $state_id = $_REQUEST['state_id'];
        $varWholeSalerDrop = '<option value="0">Select City</option>';
        $objGeneral = new General();
        $arrRows = $objGeneral->countrylistbystateid("state_id = " . $_REQUEST['q']);
        //$arrRows = $objShippingGateway->statelistbycountryid("fkportalID = " . $_REQUEST['q'] . " AND ShippingStatus = 1" );
        foreach ($arrRows as $keySelect => $valSelect) {
            $selected = ($valSelect['id'] == $selId) ? 'selected="selected"' : '';
            $varWholeSalerDrop .='<option value="' . $valSelect['id'] . '" ' . $selected . '>' . $valSelect['name'] . '</option>';
        }
        echo $varWholeSalerDrop;

        break;

    case 'updatezonetitle':
        // pre($_REQUEST['data']['id']);
        $title_id = $_REQUEST['data']['id'];
        $title_name = $_REQUEST['data']['name'];
        $objZoneGateway = new ZoneGatewayNew();
        $arrRows = $objZoneGateway->updatezonetitlebyid($title_id, $title_name);
        //pre($arrRows);

        break;

    case 'getlogistcompaybyarea':
        // pre($_REQUEST['data']);
        $unitweight = $_REQUEST['data']['unitweight'];
        $weightvalue = $_REQUEST['data']['weightvalue'];
        $unitlength = $_REQUEST['data']['unitlength'];
        $Lengthvalue = $_REQUEST['data']['Lengthvalue'];
        $Widthvalue = $_REQUEST['data']['Widthvalue'];
        $Heightvalue = $_REQUEST['data']['Heightvalue'];
        $locationvalue = $_REQUEST['data']['locationvalue'];
        $currentcountryid = $_REQUEST['data']['currentcountryid'];
        $multiplecountriesvid = $_REQUEST['data']['multiplecountriesvalue'];
        $DimensionUnit = $_REQUEST['data']['dimentionunit'];


        $convertweight = $objGeneral->convertproductweight($unitweight, $weightvalue);
        $arrRows = $objGeneral->getlogisticnamebyarea($currentcountryid, $convertweight, $locationvalue, $Lengthvalue, $Widthvalue, $Heightvalue, $multiplecountriesvid,$DimensionUnit);
        foreach ($arrRows as $key => $val) {

            echo '<div class="ad_pro_check"><input class="validate[minCheckbox[1]] class_req checkradios" type="checkbox" name="frmShippingGateway[]" value="' . $val['logisticportalid'] . '"' . $selected . ' /><span>' . $val['logisticTitle'] . '</span></div>';
        }
        //pre($arrRows);

        break;

    case 'removezonetabledata':
        // pre($_REQUEST['data']['id']);
        $id = $_REQUEST['data']['id'];
        //  pre($id);
        //$title_name = $_REQUEST['data']['name'];
        $objZoneGateway = new ZoneGatewayNew();
        $arrRows = $objZoneGateway->removezonetabledataid($id);
        //pre($arrRows);

        break;
    case 'removezonecompletedata':
        // pre($_REQUEST['data']['id']);
        $zoneid = $_REQUEST['data']['zoneid'];
        //  pre($id);
        //$title_name = $_REQUEST['data']['name'];
        $objZoneGateway = new ZoneGatewayNew();
        $arrRows = $objZoneGateway->removezonecompletedataid($zoneid);
        //pre($arrRows);

        break;

    case 'showShippingPortalwithselected':
        $selId = $_REQUEST['selId'];
        $varWholeSalerDrop = '<option value="0">Select Shipping Geteway</option>';
        $objShippingGateway = new ShippingGatewayNew();
        $arrRows = $objShippingGateway->shippingCountryPortalList("fkportalID = " . $_REQUEST['q']);
        foreach ($arrRows as $keySelect => $valSelect) {
            $selected = ($valSelect['pkShippingMethod'] == $selId) ? 'selected="selected"' : '';
            $varWholeSalerDrop .='<option value="' . $valSelect['pkShippingGatewaysID'] . '" ' . $selected . '>' . $valSelect['ShippingTitle'] . '</option>';
        }
        echo $varWholeSalerDrop;

        break;

    case 'showShippingCountryAllowed':
        $selId = $_REQUEST['selId'];
        $portalID = $_REQUEST['portalID'];
        $varWholeSalerDrop = '<option value="0">Select Allowed Countries</option>';
        $objShippingGateway = new ShippingGatewayNew();
        $arrRows = $objShippingGateway->shippingCountryAllowedList("fkShippingGatewaysID = " . $_REQUEST['q'] . " AND fkAdminID = " . $_REQUEST['portalID'] . "");
        //echo count($arrRows);
        foreach ($arrRows as $keySelect => $valSelect) {
            $selected = ($valSelect['pkShippingMethod'] == $selId) ? 'selected="selected"' : '';
            $varWholeSalerDrop .='<option value="' . $valSelect['fkcountry_id'] . '" ' . $selected . '>' . $valSelect['name'] . '</option>';
        }
        $newarr['count'] = count($arrRows);
        $newarr['value'] = $varWholeSalerDrop;
        //pre($newarr);
        echo json_encode($newarr);
//      echo $varWholeSalerDrop;

        break;

    case 'showdetailsofshippingprice':
        //pre($_REQUEST);
        $logisticid = $_REQUEST['logistid'];
        $countryid = $_REQUEST['countryid'];
        $shippinggatwayid = $_REQUEST['shippingmethodid'];
        //pre($_REQUEST);
        $arrRows = $objGeneral->getshippingpricedetailbymethod($logisticid, $countryid, $shippinggatwayid);

        //print_r($arrRows);
        $value.='<table width="100%" cellpadding="0" cellspacing="0"> ';
        $value .='<tr><th> Zone Name </th> <th> From Country </th><th> To Country </th><th> Method Name </th><th> Max.Dimension</th>'
                . '<th> Max. Weight(Kg) </th> <th> Min. Weight(Kg) </th></tr>';
        foreach ($arrRows as $keySelect => $valSelect) {
            $value .='<tr>  ';
            $value .='<td>' . $valSelect['title'] . '</td>';
            $value .='<td>' . $valSelect['frmCountryName'] . ' </td>';
            $value .='<td>' . $valSelect['toCountryName'] . ' </td>';
            $value .='<td>' . $valSelect['MethodName'] . ' </td>';
            $value .='<td>' . $valSelect['maxlength'] . 'x' . $valSelect['maxwidth'] . 'x' . $valSelect['maxheight'] . ' </td>';
            $value .='<td>' . $valSelect['maxkg'] . ' </td>';
            $value .='<td>' . $valSelect['minkg'] . ' </td>';
            $value .='</tr>';
        }
        $value .='</table>';
        //pre($ob);
//         $varWholeSalerDrop = '<option value="0">Select Allowed Countries</option>';
//         $objShippingGateway = new ShippingGatewayNew();
//         $arrRows = $objShippingGateway->shippingCountryAllowedList("fkShippingGatewaysID = " . $_REQUEST['q']);
//         //echo count($arrRows);
//         foreach ($arrRows as $keySelect => $valSelect) {
//             $selected = ($valSelect['pkShippingMethod'] == $selId) ? 'selected="selected"' : '';
//             $varWholeSalerDrop .='<option value="' . $valSelect['fkcountry_id'] . '" ' . $selected . '>' . $valSelect['name'] . '</option>';
//         }
//         $newarr['count'] = count($arrRows);
//         $newarr['value'] = $varWholeSalerDrop;
        //pre($newarr);
        //echo json_encode($newarr);
        echo $value;

        break;

    case 'checkWholeSalerEmail':
        $objwholesaler = new Wholesaler();
        $varWhr = " AND CompanyEmail ='" . $_REQUEST['code'] . "'";
        if ($_REQUEST['id'] > 0) {
            $varWhr = $varWhr . ' AND pkWholesalerID !=' . $_REQUEST['id'];
        }

        $varNum = $objwholesaler->CountWholesalerEmail($varWhr);
        echo $varNum;

        break;

    case 'checkCustomerEmail':
        $objwholesaler = new Customer();
        $varWhr = " AND CustomerEmail ='" . $_REQUEST['code'] . "'";
        if ($_REQUEST['id'] > 0) {
            $varWhr = $varWhr . ' AND pkCustomerID !=' . $_REQUEST['id'];
        }

        $varNum = $objwholesaler->CountCustomerEmail($varWhr);
        echo $varNum;

        break;
    case 'checkLogisticEmail':
        $objlogistic = new Logistic();
        $varWhr = " AND CompanyEmail ='" . $_REQUEST['code'] . "'";
        if ($_REQUEST['id'] > 0) {
            $varWhr = $varWhr . ' AND pkLogisticID !=' . $_REQUEST['id'];
        }

        $varNum = $objlogistic->CountLogisticEmail($varWhr);
        echo $varNum;

        break;
    case 'SendWarningToWholesaler':
        $varMsg = $_REQUEST['msg'];
        //pre($varMsg);

        $varEmail = $_REQUEST['emailid'];
        $varWarnNo = (int) $_REQUEST['warnNo'] + 1;

        $objTemplate = new EmailTemplate();
        $objCore = new Core();

        $objwholesaler = new Wholesaler();
        $varNum = $objwholesaler->insertWholesalerWarning($_REQUEST);

        $varToUser = $varEmail;

        $varFromUser = $_SESSION['sessAdminEmail'];

        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= '" . $varWarnNo . "WarningToWholesalerByAdmin' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

        $varOutPutValues = html_entity_decode(stripcslashes($varMsg));
        pre($varOutPutValues);

// Calling mail function

        $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);


        break;

    case 'getWarningTemplateForWholesaler':

        $varEmail = $_REQUEST['emailid'];
        $varWarnNo = $_REQUEST['warnNo'];

        $objTemplate = new EmailTemplate();
        $objCore = new Core();

        $objwholesaler = new Wholesaler();
        $arrRes = $objwholesaler->editWholesaler(" pkWholesalerID='" . $_REQUEST['id'] . "' ");

        $varToUser = $varEmail;

        $varFromUser = $_SESSION['sessAdminEmail'];

        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= '" . ($varWarnNo + 1) . "WarningToWholesalerByAdmin' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';
        $varSendDate = $objCore->serverDateTime(date('d-m-Y'), DATE_FORMAT_SITE);

        $varKeyword = array('{IMAGE_PATH}', '{SENDDATE}', '{WHOLESALER}', '{WHOLESALER}', '{CURRENTKPI}', '{SITE_NAME}');

        $varKeywordValues = array($varPathImage, $varSendDate, $arrRes[0]['CompanyName'], $arrRes[0]['CompanyName'], $_REQUEST['kpi'], SITE_NAME);

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function
        echo $varOutPutValues;



        break;

    case 'SendWarningToLogistic':
        //echo "<pre>";
        //print_r($_REQUEST);
        //die;
        $varMsg = $_REQUEST['msg'];

        $varEmail = $_REQUEST['emailid'];
        $varWarnNo = (int) $_REQUEST['warnNo'] + 1;

        $objTemplate = new EmailTemplate();
        $objCore = new Core();

        $objlogistic = new Logistic();
        $varNum = $objlogistic->insertLogisticWarning($_REQUEST);

        $varToUser = $varEmail;

        $varFromUser = $_SESSION['sessAdminEmail'];

        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= '" . $varWarnNo . "WarningToLogisticByAdmin' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

        $varOutPutValues = html_entity_decode(stripcslashes($varMsg));

// Calling mail function

        $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);


        break;

    case 'getWarningTemplateForLogistic':

        $varEmail = $_REQUEST['emailid'];
        $varWarnNo = $_REQUEST['warnNo'];
        $logisticEmail = $_REQUEST['emailid'];
        $companyName = $_REQUEST['companyName'];

        //echo "<pre>";
        //print_r($_REQUEST);
        //die;

        $objTemplate = new EmailTemplate();
        $objCore = new Core();

        //$objwholesaler = new Wholesaler();
        //$arrRes = $objwholesaler->editWholesaler(" pkWholesalerID='" . $_REQUEST['id'] . "' ");

        $varToUser = $varEmail;

        $varFromUser = $_SESSION['sessAdminEmail'];

        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= '" . ($varWarnNo + 1) . "WarningToLogisticByAdmin' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';
        $varSendDate = $objCore->serverDateTime(date('d-m-Y'), DATE_FORMAT_SITE);

        $varKeyword = array('{IMAGE_PATH}', '{SENDDATE}', '{WHOLESALER}', '{WHOLESALER}', '{CURRENTKPI}', '{SITE_NAME}');

        $varKeywordValues = array($varPathImage, $varSendDate, $companyName, $companyName, $_REQUEST['kpi'], SITE_NAME);

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

        // Calling mail function
        echo $varOutPutValues;



        break;

    case 'getWarningTemplateForCountryPortal':

        $varEmail = $_REQUEST['emailid'];
        $varWarnNo = $_REQUEST['warnNo'];

        $objTemplate = new EmailTemplate();
        $objCore = new Core();

        $objCountryPortal = new CountryPortal();
        $arrRes = $objCountryPortal->getAdminDetails($_REQUEST['id']);

        $varToUser = $varEmail;

        $varFromUser = $_SESSION['sessAdminEmail'];

        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= '" . ($varWarnNo + 1) . "WarningToCountryPortalWholesalerByAdmin' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';
        $varSendDate = $objCore->serverDateTime(date('d-m-Y'), DATE_FORMAT_SITE);

        $varKeyword = array('{IMAGE_PATH}', '{SENDDATE}', '{COUNTRYPORTAL}', '{COUNTRYPORTAL}', '{CURRENTKPI}', '{SITE_NAME}');

        $varKeywordValues = array($varPathImage, $varSendDate, $arrRes['AdminTitle'], $arrRes['AdminTitle'], $_REQUEST['kpi'], SITE_NAME);

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function
        echo $varOutPutValues;



        break;

    case 'SuspendingWholesaler':
        $varMsg = $_REQUEST['msg'];
        $varEmail = $_REQUEST['emailid'];
        $varId = $_REQUEST['id'];
        $objwholesaler = new Wholesaler();

        $varNum = $objwholesaler->UpdateWholesalerStatus('suspend', $varId);

        $objTemplate = new EmailTemplate();
        $objCore = new Core();

        $varToUser = $varEmail;

        $varFromUser = $_SESSION['sessAdminEmail'];

        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= 'SuspendingWholesalerByAdmin' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

        $varPathImage = '';
        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{WHOLESALER}', '{MESSAGE}', '{SITE_NAME}');

        $varKeywordValues = array($varPathImage, $varEmail, $varMsg, SITE_NAME);

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function

        $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);

        break;

    case 'Sendtrackingnumber':

        //pre($_REQUEST);
        $varname = $_REQUEST['name'];
        $varEmail = $_REQUEST['emailid'];
        $TrackingId = $_REQUEST['id'];
        $DateStart = $_REQUEST['startdate'];
        $Dateend = $_REQUEST['enddate'];
        //$shippingtitle = $_REQUEST['shippingcompany'];
        $ShippingFirstName = $_REQUEST['shfirst'];
        $ShippingLastName = $_REQUEST['shlast'];
        $ShippingAddressLine1 = $_REQUEST['shadd1'];
        $ShippingAddressLine2 = $_REQUEST['shadd2'];
        $ShippingCountry = $_REQUEST['scountry'];
        $ShippingPostalCode = $_REQUEST['spcode'];
        $ShippingPhone = $_REQUEST['sphone'];
        $trackingurlEmail = $_REQUEST['trackingurl'];
        $pkOrderID = $_REQUEST['pkOrderID'];
      //  $varEmail='avinesh.mathur@planetwebsolution.com';
        $sitename = $_REQUEST['from'];
        $varToUser = $varEmail;
        //$objwholesaler = new Wholesaler();
        //$varNum = $objwholesaler->UpdateWholesalerStatus('suspend', $varId);

        $objTemplate = new EmailTemplate();
        $objCore = new Core();

        //$varToUser = $varEmail;
        //$varToUser='avinesh.mathur@planetwebsolution.com';

        if (!empty($sitename)) {
            $varFromUser = $sitename;
        } else {
            $varFromUser = $_SESSION['sessAdminEmail'];
        }

        $message = '
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top" style="height:20px;">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="top" style="background:#fff; border:3px solid #ffb422; padding:20px; font-size:14px; font-family:Verdana, Geneva, sans-serif"><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top" style="font-size:14px; font-family:Verdana, Geneva, sans-serif"><span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; margin-bottom:10px; display:block">Dear ' . $varname . ',</span>
                  </td>
              </tr>
              <tr>
                <td align="left" valign="top" style="font-size:14px; font-family:Verdana, Geneva, sans-serif" ><span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; text-indent:20px;display:block"> Your Order No:-' . $pkOrderID . ' has now been shipped to following address:</span> <br />
                  </td>
              </tr>
        
             <tr>
			 	<td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
					 <tr>
        <td align="left" valign="top" style="font-size:14px; font-family:Verdana, Geneva, sans-serif;width:15%"><span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:normal;margin-bottom:5px; display:block;"><strong>Name:</strong></span>
                  </td>
                  <td align="left" valign="top" style="font-size:14px; font-family:Verdana, Geneva, sans-serif"><span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:normal;margin-bottom:5px; display:block;text-indent:20px;">' . $ShippingFirstName . ' ' . $ShippingFirstName . '</span>
                  </td>
              </tr>
              <tr>
        	<td align="left" valign="top" style="font-size:14px; font-family:Verdana, Geneva, sans-serif;width:15%;"><span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:normal;margin-bottom:5px; display:block;"><strong>Address:</strong></span>
                  </td>
                  <td align="left" valign="top" style="font-size:14px; font-family:Verdana, Geneva, sans-serif"><span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:normal;margin-bottom:5px; display:block;text-indent:20px;">' . $ShippingAddressLine1 . ' ' . $ShippingAddressLine2 . '</span>
                  </td>
              </tr>
				
				</table>
				</td>
			 </tr>
        
               <tr>
        
                  <td align="left" valign="top" style="font-size:14px; font-family:Verdana, Geneva, sans-serif"><span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:normal;margin-bottom:5px; display:block;text-indent:20px;">' . $ShippingCountry . '</span>
                  </td>
              </tr>
      
               <tr>
        
                 
                  <td align="left" valign="top" style="font-size:14px; font-family:Verdana, Geneva, sans-serif"><span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:normal;margin-bottom:5px; display:block;text-indent:20px;"> ' . $ShippingPostalCode . '</span>
                  </td>
              </tr>
        
               <tr>
        
                  <td align="left" valign="top" style="font-size:14px; font-family:Verdana, Geneva, sans-serif"><span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:normal;margin-bottom:5px; display:block;text-indent:20px;"> ' . $ShippingPhone . '</span>
                  </td>
              </tr>
        
              <tr>
                <td align="left" valign="top" style="font-size:14px; font-family:Verdana, Geneva, sans-serif"><span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:normal;margin-bottom:5px; display:block; margin-top:5px;">the tracking number for your order is: <strong>' . $TrackingId . '</strong>.</span>
                  </td>
        
              </tr>
              <tr>
                <td align="left" valign="top" style="font-size:14px; font-family:Verdana, Geneva, sans-serif" colspan="2"><span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:normal;margin-bottom:5px; display:block; margin-top:5px; font-weight:600">You can click here to see <a href="' . $trackingurlEmail . '">' . $trackingurlEmail . '</a></span>
                  </td>
        
              </tr>
              <tr>
                <td align="left" valign="top" style="font-size:14px; font-family:Verdana, Geneva, sans-serif" colspan="2"><span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:normal;margin-bottom:5px; display:block; margin-top:5px;">Estimated Delivery date is between <strong>' . $DateStart . '</strong> and <strong>' . $Dateend . '</strong>.</span>
                  </td>
        
              </tr>
              <tr>
                <td align="left" valign="top" style="font-size:14px; font-family:Verdana, Geneva, sans-serif" colspan="2"><span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:normal;margin-bottom:5px; display:block; margin-top:5px;">Please allow some time for the status of the shipment to correctly display at the above address.</span>
                  </td>
        
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
		';

//         $message='
//         		<table width="100%" border="0" cellspacing="0" cellpadding="0">
//   <tr>
//     <td align="left" valign="top" style="height:20px;">&nbsp;</td>
//   </tr>
//   <tr>
//     <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
//         <tr>
//           <td align="left" valign="top" style="background:#fff; border:3px solid #ffb422; padding:20px; font-size:14px; font-family:Verdana, Geneva, sans-serif"><table border="0" cellspacing="0" cellpadding="0">
//               <tr>
//                 <td align="left" valign="top" style="font-size:14px; font-family:Verdana, Geneva, sans-serif">
//                 <span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;">Dear "'.$varname.'", 
//                  Your Order 264 have now been shipped to following address.</span> <br />
//                   <br />
//                   Recipient First Name: "'.$ShippingFirstName.'"<br />
//                   Recipient Last Name:  "'.$ShippingLastName.'"<br />
//                   Address Line 1: "'.$ShippingAddressLine1.'"<br />
//                   Address Line 2: "'.$ShippingAddressLine2.'"<br />
//                   Country: "'.$ShippingCountry.'"<br />
//                   Post Code or Zip Code: "'.$ShippingPostalCode.'"<br />
//                   Phone:"'.$ShippingPhone.'"<br />
//                   <br />
//                   via<span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;"> "'.$shippingtitle.'" </span>
//                   the tracking number for your oder is as following <span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;"> "'.$TrackingId.'" </span>
//                   You can click here to see "<span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;"> <a href="'.$trackingurlEmail.'">"'.$trackingurlEmail.'"</a> </span>" 
//                   Estimated Delievery date is <span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;"> "'.$DateStart.'" </span>End Date
//                   <span style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;"> "'.$Dateend.'" </span>
//                   Please allow some time for the status of the shipment to correctly display at the above address.<br /><br/>
//                   Thank you for ordering from Telamela.</td>
//               </tr>
//             </table></td>
//         </tr>
//       </table></td>
//   </tr>
// </table>
//         		';
//pre($varToUser);

        $varSiteName = SITE_NAME;
        $varSubject = "Order Tracking Information";
       // $varToUser = 'avinesh.mathur@planetwebsolution.com';
       // pre($message);
        $objCore->sendMail($varToUser, $varFromUser, $varSubject, $message);

        break;


    case 'WholesalerChangeStatus':
        $varStatus = $_REQUEST['status'];
        $varId = $_REQUEST['id'];
        $varEmail = $_REQUEST['emailid'];
        //if ($_REQUEST['status'] == 'approve')
        /* Condition changed by Krishna Gupta (05-10-2015) */
        if ($_REQUEST['status'] == 'active') {
            $varStatus = 'active';
        }
        $arrStatus = array('active' => 'Activated', 'deactive' => 'Deactivated', 'suspend' => 'Suspended', 'approve' => 'Approved', 'reject' => 'Rejected');

        $objwholesaler = new Wholesaler();

        $varNum = $objwholesaler->UpdateWholesalerStatus($varStatus, $varId);

        $objTemplate = new EmailTemplate();
        $objCore = new Core();


        $varToUser = $varEmail;
        $varFromUser = $_SESSION['sessAdminEmail'];
        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= 'WholesalerChangeStatusByAdmin' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

        $varPathImage = '';
        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{WHOLESALER}', '{STATUS}', '{MESSAGE}', '{SITE_NAME}');
        //$varKeyword = array('{IMAGE_PATH}', '{WHOLESALER}', '{STATUS}', '{MESSAGE}', '{LINK}');
        $varKeywordValues = array($varPathImage, $varEmail, $arrStatus[$_REQUEST['status']], $varMsg, SITE_NAME);

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function

        $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
//$objCore->setSuccessMsg(ADMIN_WHOLESALER_STATUS_MSG);

        /* $varcategoryDrop = '<select onchange="changeStatus(this.value,' . $_REQUEST['pid'] . ')"><option value="1"' . $varSelected1 . '>Active</option>
          <option value="0" ' . $varSelected2 . '>Deactive</option></select></select>'; */
        ?>
        <?php
        if ($varStatus == 'reject') {
            ?>
            <span class='label label-lightred'>Rejected</span>
            <a href="javascript:void(0);" class="active" onclick="changeStatus('approve', '<?php echo $_REQUEST['emailid']; ?>',<?php echo $_REQUEST['id']; ?>)" title="Click here to approve this customer.">Approve</a>
            <?php
        } else {
            ?>
            <?php
            if ($_SESSION['sessUserType'] == 'super-admin') {
                if ($varStatus != 'active') {
                    ?><a href="javascript:void(0);" class="active" onclick="changeStatus('active', '<?php echo $_REQUEST['emailid']; ?>',<?php echo $_REQUEST['id']; ?>)" title="Click here to active this customer.">Active</a><?php
                } else {
                    echo '<span class="label label-satgreen">Active</span>';
                }
            }
            ?>
            <?php
            if ($varStatus != 'deactive') {
                ?><a href="javascript:void(0);" class="deactive" onclick="changeStatus('deactive', '<?php echo $_REQUEST['emailid']; ?>',<?php echo $_REQUEST['id']; ?>)" title="Click here to deactive this customer.">Deactive</a><?php
            } else {
                echo '<span  class="label label-lightred">Deactive</span>';
            }
            ?>
            <?php
            if ($varStatus == 'suspend') {
                echo "<span class='yellow'>Suspend</span>";
            }
            ?>
        <?php } ?>
        <?php
        break;
    //change logistic  
    case 'LogisticChangeStatus':
        $varStatus = $_REQUEST['status'];
        $varId = $_REQUEST['id'];
        $varEmail = $_REQUEST['emailid'];
        if ($_REQUEST['status'] == 'approve') {
            $varStatus = 'active';
        }
        $arrStatus = array('active' => 'Activated', 'deactive' => 'Deactivated', 'suspend' => 'Suspended', 'approve' => 'Approved', 'reject' => 'Rejected');

        $objLogistic = new Logistic();

        $varNum = $objLogistic->UpdateLogisticStatus($varStatus, $varId);

        $objTemplate = new EmailTemplate();
        $objCore = new Core();


        $varToUser = $varEmail;
        $varFromUser = $_SESSION['sessAdminEmail'];
        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= 'LogisticChangeStatusByAdmin' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

        $varPathImage = '';
        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{LOGISTIC}', '{STATUS}', '{MESSAGE}', '{SITE_NAME}', '{LINK}');
        $varKeywordValues = array($varPathImage, $varEmail, $arrStatus[$_REQUEST['status']], $varMsg, SITE_NAME, '<a href="' . SITE_ROOT_URL . '">Click Here</a>');

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function

        $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
//$objCore->setSuccessMsg(ADMIN_WHOLESALER_STATUS_MSG);

        /* $varcategoryDrop = '<select onchange="changeStatus(this.value,' . $_REQUEST['pid'] . ')"><option value="1"' . $varSelected1 . '>Active</option>
          <option value="0" ' . $varSelected2 . '>Deactive</option></select></select>'; */
        ?>
        <?php
        if ($varStatus == 'reject') {
            ?>
            <span class='label label-lightred'>Rejected</span>
            <a href="javascript:void(0);" class="active" onclick="changeStatus('approve', '<?php echo $_REQUEST['emailid']; ?>',<?php echo $_REQUEST['id']; ?>)" title="Click here to approve this customer.">Approve</a>
            <?php
        } else {
            ?>
            <?php
            if ($_SESSION['sessUserType'] == 'super-admin') {
                if ($varStatus != 'active') {
                    ?><a href="javascript:void(0);" class="active" onclick="changeStatus('active', '<?php echo $_REQUEST['emailid']; ?>',<?php echo $_REQUEST['id']; ?>)" title="Click here to active this customer.">Active</a><?php
                } else {
                    echo '<span class="label label-satgreen">Active</span>';
                }
            }
            ?>
            <?php
            if ($varStatus != 'deactive') {
                ?><a href="javascript:void(0);" class="deactive" onclick="changeStatus('deactive', '<?php echo $_REQUEST['emailid']; ?>',<?php echo $_REQUEST['id']; ?>)" title="Click here to deactive this customer.">Deactive</a><?php
            } else {
                echo '<span  class="label label-lightred">Deactive</span>';
            }
            ?>
            <?php
            if ($varStatus == 'suspend') {
                echo "<span class='yellow'>Suspend</span>";
            }
            ?>
        <?php } ?>
        <?php
        break;

    case 'LogisticApproveHistory':
        $varId = $_REQUEST['logisticID'];
        $varEmail = $_REQUEST['emailid'];
        $varStatus = 'Active';
        $objLogistic = new Logistic();
        $varNum = $objLogistic->UpdateLogisticHistoryStatus($varStatus, $varId);

        $objTemplate = new EmailTemplate();
        $objCore = new Core();


        $varToUser = $varEmail;
        $varFromUser = $_SESSION['sessAdminEmail'];
        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= 'LogisticHistoryApproveStatusByAdmin' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

        $varPathImage = '';
        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{LOGISTIC}', '{STATUS}', '{MESSAGE}', '{SITE_NAME}');
        $varKeywordValues = array($varPathImage, $varEmail, $arrStatus[$_REQUEST['status']], $varMsg, SITE_NAME);

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function

        $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
        echo "<span class='label label-satgreen'>Approved</span>";

        break;

    case 'SpecialApplicationChangeStatus':
        $varStatus = $_REQUEST['status'];
        $varId = $_REQUEST['id'];
        $varStatus = $_REQUEST['status'];

        $arrStatus = array('Approved' => 'Approved');

        $objwholesaler = new Wholesaler();

        $varNum = $objwholesaler->UpdateWholesalerSpecialApplicationStatus($varStatus, $varId);
        $arrSubject = array(
            'adminSubject' => 'Special application has been approved.',
            'wholesalerSubject' => 'Special application has been approved.'
        );
        $objGeneral->sendSpecialFormNotificationEmail($varId, $arrSubject);

        echo '<span class="label label-satgreen">Approved</span>';
        ?>
        <?php
        break;

    case 'ShowWholesaler':
        $varWholeSalerDrop = '<option value="0">Select Wholesaler</option>';
        $objProduct = new Product();
        $varWhere = " AND CompanyCountry ='" . $_REQUEST['ctid'] . "' " . $varPortalFilterPK;
        $arrRows = $objProduct->WholesalerListBYCountry($varWhere);
        foreach ($arrRows as $keySelect => $valSelect) {
            $varWholeSalerDrop .='<option value="' . $valSelect['pkWholesalerID'] . '">' . $valSelect['CompanyName'] . '</option>';
        }
        echo $varWholeSalerDrop;

        break;
    case 'ShowWholesalerShippingGateway':
        $varWholeSalerDrop = ''; //'<option value="0">Select Shipping</option>';

        $objProduct = new Product();
        $arrRows = $objProduct->WholesalerShippingGatwaysList($_REQUEST['wid']);
        foreach ($arrRows as $keySelect => $valSelect) {
            $varWholeSalerDrop .='<input type="checkbox" name="frmShippingGateway[]" value="' . $valSelect['pkShippingGatewaysID'] . '"/> ' . $valSelect['ShippingTitle'] . '<br /> '; //'<option value="' . $valSelect['pkShippingGatewaysID'] . '">' . $valSelect['ShippingTitle'] . '</option>';
        }

        echo $varWholeSalerDrop;

        break;

    case 'Showcurrentcountrygateway':
        $varWholeSalerDrop = ''; //'<option value="0">Select Shipping</option>';
//        $objProduct = new Product();
//        $arrRows = $objProduct->countryshippingGatewayList($_REQUEST['ctid']);
        $arrRows = $objGeneral->countryshippingGatewayList($_REQUEST['ctid']);
        foreach ($arrRows as $keySelect => $valSelect) {
            $varWholeSalerDrop .='<input type="checkbox" name="frmShippingGateway[]" value="' . $valSelect['logisticportalid'] . '"/> ' . $valSelect['logisticTitle'] . '<br /> '; //'<option value="' . $valSelect['pkShippingGatewaysID'] . '">' . $valSelect['ShippingTitle'] . '</option>';
        }

        echo $varWholeSalerDrop;

        break;

    case 'showPackageProduct':
        $objPackage = new Product();
        $arrRows = $objPackage->showPackageProduct($_REQUEST['pkgid']);
        echo '<table border="0" width="100%"><tr><td><b>Product Ref No.</b></td><td><b>Product Name</b></td><td><b>Final Price</b></td></tr>';
        $TotalPrice = 0;
        foreach ($arrRows as $valPP) {
            echo '<tr><td>' . $valPP['ProductRefNo'] . '</td><td>' . $valPP['ProductName'] . '</td><td>' . $valPP['FinalPrice'] . '</td></tr>';
            $TotalPrice +=$valPP['FinalPrice'];
        }
        echo '<tr><td>&nbsp;</td><td><b>Product Total Price:</b></td><td><b>' . number_format($TotalPrice, 4) . '</b></td></tr>';
        echo '<tr><td>&nbsp;</td><td><b>Package Offer Price:</b></td><td><b>' . $arrRows[0]['PackagePrice'] . '</b></td></tr>';
        echo '</table>';
//print_r($arrRows);

        break;

    case 'customerChangeStatus':
        $varStatus = $_REQUEST['status'];
        $varId = $_REQUEST['id'];
        $varEmail = $_REQUEST['emailid'];

        $arrStatus = array('0' => 'Deactivated', '1' => 'Activated');

        $objcustomer = new customer();

        $varNum = $objcustomer->UpdateCustomerStatus($varStatus, $varId);

        $objTemplate = new EmailTemplate();
        $objCore = new Core();


        $varToUser = $varEmail;

        $varFromUser = $_SESSION['sessAdminEmail'];

        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= 'customerChangeStatusByAdmin' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

        $varPathImage = '';
        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{WHOLESALER}', '{STATUS}', '{MESSAGE}', '{SITE_NAME}');
        $varKeywordValues = array($varPathImage, $varEmail, $arrStatus[$varStatus], $varMsg, SITE_NAME);

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function

        $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);

        if ($varStatus == 0) {
            $varSelected1 = '';
            $varSelected2 = 'selected';
        } else {
            $varSelected1 = 'selected';
            $varSelected2 = '';
        }
        ?>

        <?php
        if (empty($varSelected1)) {
            ?><a href="javascript:void(0);" class="active" onclick="changeStatus('1', '<?php echo $_REQUEST['emailid']; ?>', '<?php echo $_REQUEST['id']; ?>')" title="Click here to active this customer.">Active</a><?php
        } else {
            echo '<span class="label label-satgreen">Active</span>';
        }
        ?>
        <?php
        if (empty($varSelected2)) {
            ?><a href="javascript:void(0);" class="deactive" onclick="changeStatus('0', '<?php echo $_REQUEST['emailid']; ?>', '<?php echo $_REQUEST['id']; ?>')" title="Click here to deactive this customer.">Deactive</a><?php
        } else {
            echo '<span  class="label label label-lightred">Deactive</span>';
        }
        ?>

        <?php
        break;

    case 'newsletterChangeStatus':

        $varId = $_REQUEST['id'];

        $objNewsLetter = new NewsLetter();
        $varStatus = 'Active';
        $varNum = $objNewsLetter->UpdateNewsletterStatus($varStatus, $varId);

        echo "<span class='yellow'>Active</span>";
        break;
    case 'changeOrderStatus':
        //die("123");
        $objOrder = new Order();
        //pre($_POST);
        $varUpdate = $objOrder->updateOrderStatus($_POST);
        break;

    case 'updateShipment':
        //echo "42353535";die;
        //$_REQUEST['data'] = explode('&',$_REQUEST['data']);
        //pre($_REQUEST);
        $objOrder = new Order();
        $varUpdate = $objOrder->updateShipment($_POST);
        break;

    case 'viewDisputedHistory':
        $objOrder = new Order();
        $soid = $_REQUEST['soid'];
        $isFeed = $_REQUEST['feedback'];
        $arrDisputedCommentsHistory = $objOrder->disputedCommentsHistory($soid);
        $arrDisputedComments = $objCore->getDisputedCommentArray();
        if (count($arrDisputedCommentsHistory) > 0) {
            ?>
            <table id="colorBox_table" style="width:600px;" border="0">

                <?php
                if ($_REQUEST['DisputedStatus'] == '1') {
                    ?>
                    <tr>
                        <td>
                            <b class="green"><?php echo DISPUTE_RESOLVED; ?></b>
                            <br/><br/>
                        </td>
                    </tr>
                <?php } ?>
                <?php
                foreach ($arrDisputedCommentsHistory as $kkk => $vvv) {
                    ?>
                    <tr>
                        <td>
                            <b>By <?php echo $vvv[$vvv['CommentedBy']] . ' (' . $vvv['CommentedBy'] . ') <small class="green">' . $objCore->localDateTime($vvv['CommentDateAdded'], DATE_TIME_FORMAT_SITE_FRONT) . '</small>'; ?></b>
                            <br/>
                        </td>
                    </tr>
                    <?php
                    if ($vvv['CommentOn'] == 'Disputed') {
                        $Qdata = unserialize($vvv['CommentDesc']);
                        //pre($Qdata);
                        ?>
                        <tr>
                            <td><b><?php echo $arrDisputedComments['Q1']; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo $arrDisputedComments[$Qdata['Q1']]; ?></td>
                        </tr>
                        <?php
                        if ($Qdata['Q1'] == 'A11') {
                            ?>
                            <tr>
                                <td><b><?php echo $arrDisputedComments['Q11']; ?></b></td>
                            </tr>
                            <tr>
                                <td><?php echo $Qdata['Q11']; ?></td>
                            </tr>
                            <?php
                            $additionalCommentsQ = $arrDisputedComments['Q12'];
                        } else {
                            ?>
                            <tr>
                                <td><b><?php echo $arrDisputedComments['Q21']; ?></b></td>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    $arrQ21 = explode(',', $Qdata['Q21']);
                                    $Q21 = '';
                                    //echo '<pre>';print_r($arrQ21);
                                    //pre($arrDisputedComments);
                                    foreach ($arrQ21 as $key => $v10) {
                                        if (key_exists($v10, $arrDisputedComments)) {
                                            $Q21 .= $arrDisputedComments[$v10] . ',';
                                        } else {
                                            $Q21 .= $v10 . ',';
                                        }
                                    }
                                    echo trim($Q21, ',');
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b><?php echo $arrDisputedComments['Q22']; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo $arrDisputedComments[$Qdata['Q22']]; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b><?php echo $arrDisputedComments['Q23']; ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo $arrDisputedComments[$Qdata['Q23']]; ?>
                                </td>
                            </tr>
                            <?php
                            $additionalCommentsQ = $arrDisputedComments['Q24'];
                        }
                    } else {
                        $additionalCommentsQ = 'Feedback';
                    }
                    ?>
                    <tr><td><b><?php echo $additionalCommentsQ; ?></b></td></tr>
                    <tr>
                        <td><?php echo $vvv['AdditionalComments']; ?></td>
                    </tr>
                    <tr><td><hr/></td></tr>

                    <?php
                }
                if ($isFeed) {
                    ?>

                    <tr>
                        <td><b><?php echo 'Post Your Feedback'; ?></b></td>
                    </tr>
                    <tr>
                        <td><textarea name="frmFeedback" id="frmFeedback" rows="3" cols="35" class="input-block-level"></textarea></td>
                    </tr>
                    <tr>
                        <td align="right">
                            <input type="hidden" name="type" value="disputeFeedback" />
                            <input type="hidden" name="oid" value="<?php echo $arrDisputedCommentsHistory[0]['fkOrderID'] ?>" />
                            <input type="hidden" name="soid" value="<?php echo $arrDisputedCommentsHistory[0]['fkSubOrderID'] ?>" />
                            <input type="submit" class="btn btn-blue" name="Submit" value="Submit"/> &nbsp;&nbsp;
                            <input type="button" onclick="popupClose1('disputedHistory')" style="cursor: pointer;" value="Cancel" name="cancel" class="btn">
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <?php
        } else {
            echo '<div>Disputed history not found !</div>';
        }

        break;




    case 'wholesalerStatusApprove':
        $varStatus = $_REQUEST['status'];
        $varId = $_REQUEST['id'];
        $varEmail = $_REQUEST['emailid'];
        if ($_REQUEST['status'] == 'approve') {
            $varStatus = 'active';
        }
        $arrStatus = array('active' => 'Activated', 'deactive' => 'Deactivated', 'suspend' => 'Suspended', 'approve' => 'Approved', 'reject' => 'Rejected');

        $objwholesaler = new Wholesaler();

        $varNum = $objwholesaler->UpdateWholesalerStatus($varStatus, $varId);

        $objCore->setSuccessMsg($varStatus == "active" ? ADMIN_MAILING_REQUEST_STATUS_APPROVE_SUCCESS_MSG : ADMIN_MAILING_REQUEST_STATUS_DISAPPROVE_SUCCESS_MSG);

        $objTemplate = new EmailTemplate();
        $objCore = new Core();


        $varToUser = $varEmail;
        $varFromUser = $_SESSION['sessAdminEmail'];
        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= 'WholesalerChangeStatusByAdmin' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

        $varPathImage = '';
        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';
        $link = '<a href="' . SITE_ROOT_URL . '">Click here</a>';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{WHOLESALER}', '{STATUS}', '{MESSAGE}', '{SITE_NAME}', '{LINK}');
        $varKeywordValues = array($varPathImage, $varEmail, $arrStatus[$_REQUEST['status']], $varMsg, SITE_NAME, $link);

        echo $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function

        $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
        break;

    case 'SendWholesalerRemitaance':
        $InvoiceID = $_REQUEST['InvoiceID'];
        $wholesalerEmail = $_REQUEST['wholesalerEmail'];
        $WholesalerID = $_REQUEST['WholesalerID'];
        $paymentMode = $_REQUEST['paymentMode'];
        $paymentAmount = $_REQUEST['paymentAmount'];
        $paymentDate = $_REQUEST['paymentDate'];
        $paymentComment = $_REQUEST['paymentComment'];

        $objTemplate = new EmailTemplate();
        $objCore = new Core();

        $varToUser = $wholesalerEmail;

        $varFromUser = $_SESSION['sessAdminEmail'];

        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= 'MakeWholesalerPayment' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

        $varPathImage = '';
        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{WHOLESALER}', '{MESSAGE}', '{SITE_NAME}', '{InvoiceID}', '{paymentMode}', '{paymentAmount}', '{paymentDate}', '{paymentComment}');

        $varKeywordValues = array($varPathImage, $varEmail, $varMsg, SITE_NAME, $InvoiceID, $paymentMode, $paymentAmount, $paymentDate, $paymentComment);

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function

        $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
        break;

    case 'MakeWholesalerPayment':
        $InvoiceID = $_REQUEST['InvoiceID'];
        $wholesalerEmail = $_REQUEST['wholesalerEmail'];
        $WholesalerID = $_REQUEST['WholesalerID'];
        $paymentMode = $_REQUEST['paymentMode'];
        $paymentAmount = $_REQUEST['paymentAmount'];
        $paymentDate = $_REQUEST['paymentDate'];
        $paymentComment = $_REQUEST['paymentComment'];

        $objTemplate = new EmailTemplate();
        $objCore = new Core();

        $objwholesaler = new Wholesaler();
        $varNum = $objwholesaler->UpdateWholesalerPayment($_REQUEST);

        $varToUser = $wholesalerEmail;

        $varFromUser = $_SESSION['sessAdminEmail'];

        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= 'MakeWholesalerPayment' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

        $varPathImage = '';
        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{WHOLESALER}', '{MESSAGE}', '{SITE_NAME}', '{InvoiceID}', '{paymentMode}', '{paymentAmount}', '{paymentDate}', '{paymentComment}');

        $varKeywordValues = array($varPathImage, $varEmail, $varMsg, SITE_NAME, $InvoiceID, $paymentMode, $paymentAmount, $paymentDate, $paymentComment);

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function

        $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
        break;

    case 'MakeCountryPortalPayment':
        $InvoiceID = $_REQUEST['InvoiceID'];
        $userEmail = $_REQUEST['userEmail'];
        $userID = $_REQUEST['userID'];
        $paymentMode = $_REQUEST['paymentMode'];
        $paymentAmount = $_REQUEST['paymentAmount'];
        $paymentDate = $_REQUEST['paymentDate'];
        $paymentComment = $_REQUEST['paymentComment'];

        $objTemplate = new EmailTemplate();
        $objCore = new Core();

        $objCountryPortal = new CountryPortal();

        $varNum = $objCountryPortal->UpdateCountryPortalPayment($_REQUEST);

        $varToUser = $userEmail;

        $varFromUser = $_SESSION['sessAdminEmail'];

        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= 'MakeCountryPortalPayment' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{COUNTRYPORTAL}', '{MESSAGE}', '{SITE_NAME}', '{InvoiceID}', '{paymentMode}', '{paymentAmount}', '{paymentDate}', '{paymentComment}');

        $varKeywordValues = array($varPathImage, $varToUser, $varMsg, SITE_NAME, $InvoiceID, $paymentMode, $paymentAmount, $paymentDate, $paymentComment);

        echo $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function

        $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
        break;

    case 'productAutocomplete':
        $objProduct = new Product();
        $varID = "TRIM(ProductName) LIKE '%" . addslashes(trim($_GET["q"])) . "%'" . $varPortalFilterFK;
        $arrClms = array('ProductName');
        $varTable = TABLE_PRODUCT;
        $arrRes = $objProduct->select($varTable, $arrClms, $varID);
        foreach ($arrRes as $val) {
            echo $val['ProductName'] . "\n";
        }
        break;
    case 'categoryAutocomplete':
        $objProduct = new Category();
        $varID = "TRIM(CategoryName) LIKE '%" . addslashes(trim($_GET["q"])) . "%'";
        $arrClms = array('CategoryName');
        $varTable = TABLE_CATEGORY;
        $arrRes = $objProduct->select($varTable, $arrClms, $varID);
        foreach ($arrRes as $val) {
            echo $val['CategoryName'] . "\n";
        }
        break;

    case 'attributeLableAutocomplete':
        $objAttribute = new attribute();
        $varID = "TRIM(AttributeLabel) LIKE '%" . addslashes(trim($_GET["q"])) . "%'";
        $arrClms = array('AttributeLabel');
        $varTable = TABLE_ATTRIBUTE;
        $arrRes = $objAttribute->select($varTable, $arrClms, $varID);
        foreach ($arrRes as $val) {
            echo $val['AttributeLabel'] . "\n";
        }
        break;

    case 'attributeCodeAutocomplete':
        $objAttribute = new attribute();
        $varID = "TRIM(AttributeCode) LIKE '%" . addslashes(trim($_GET["q"])) . "%'";
        $arrClms = array('AttributeCode');
        $varTable = TABLE_ATTRIBUTE;
        $arrRes = $objAttribute->select($varTable, $arrClms, $varID);
        foreach ($arrRes as $val) {
            echo $val['AttributeCode'] . "\n";
        }
        break;


    case 'productReviewStatus':

        $varStatus = $_REQUEST['status'];
        $pendind_status = $_REQUEST['pendind_status'];

        $arrStatus = array('ApprovedStatus' => $varStatus);
        $varRatingStatus = array('RatingApprovedStatus' => $varStatus);

        $varId = $_REQUEST['id'];
        $varRateID = $_REQUEST['rateID'];

        $objProduct = new Product();

        //  $varNum = $objProduct->updateReviewStatus($arrStatus, $varRatingStatus, $varId, $varRateID);
        // updated by apurav 24-09-2015
        $varNum = $objProduct->updateReviewStatus($arrStatus, $varId, $pendind_status, $varRateID);

        $varReqStatus = $_POST['status'];
        if ($varReqStatus == 'Disallow') {
            $varSelected1 = '';
            $varSelected2 = 'selected';
        } else {
            $varSelected1 = 'selected';
            $varSelected2 = '';
        }

        /* $varcategoryDrop = '<select onchange="changeStatus(this.value,' . $_REQUEST['pid'] . ')"><option value="1"' . $varSelected1 . '>Active</option>
          <option value="0" ' . $varSelected2 . '>Deactive</option></select></select>'; */
        ?>
        <?php
        if (empty($varSelected1)) {
            ?>
            <a href="javascript:void(0);" class="active" onclick="changeStatus('Allow',<?php echo $_REQUEST['id']; ?>, '<?php echo $varRateID ?>')" title="Click here to approve this review.">Approve</a><?php
        } else {
            echo '<span class="label label-satgreen">Approve</span>';
        }
        ?>
        <?php
        if (empty($varSelected2)) {
            ?><a href="javascript:void(0);" class="deactive" onclick="changeStatus('Disallow',<?php echo $_REQUEST['id']; ?>, '<?php echo $varRateID; ?>')" title="Click here to Disapprove this review.">Disapprove</a><?php
        } else {
            echo '<span class="label label-lightred">Disapprove</span>';
        }
        break;

    case 'customerAutocomplete':
        $objcustomer = new customer();
        $varID = "TRIM(CustomerFirstName) LIKE '" . addslashes(trim($_GET["q"])) . "%'";
        $arrClms = array('pkCustomerID', 'concat(CustomerFirstName," ",CustomerLastName) as csName', 'CustomerEmail');
        $varTable = TABLE_CUSTOMER;
        $arrRes = $objcustomer->select($varTable, $arrClms, $varID);
        foreach ($arrRes as $val) {
            echo $val['csName'] . '( ' . trim($val['CustomerEmail']) . ' )' . "\n";
        }
        break;

    case 'SendWarningToCountryPortal':

        $varMsg = $_REQUEST['msg'];
        $varEmail = $_REQUEST['emailid'];
        $varWarnNo = (int) $_REQUEST['warnNo'] + 1;

        $objTemplate = new EmailTemplate();
        $objCore = new Core();

        $objCountryPortal = new CountryPortal();
        $varNum = $objCountryPortal->insertCountryPortalWarning($_REQUEST);

        $varToUser = $varEmail;

        $varFromUser = $_SESSION['sessAdminEmail'];

        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= '" . $varWarnNo . "WarningToCountryPortalWholesalerByAdmin' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject']));


        $varOutPutValues = html_entity_decode(stripcslashes($varMsg));

// Calling mail function

        $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
        break;

    case 'CountryPortalChangeStatus':
        $varStatus = $_REQUEST['status'];
        $varId = $_REQUEST['id'];
        $varEmail = $_REQUEST['emailid'];

        $arrStatus = array('Active' => 'Activated', 'Inactive' => 'Deactivated');

        $objCountryPortal = new CountryPortal();

        $varNum = $objCountryPortal->UpdateCountryPortalStatus($varStatus, $varId);

        $objTemplate = new EmailTemplate();
        $objCore = new Core();


        $varToUser = $varEmail;
        $varFromUser = $_SESSION['sessAdminEmail'];
        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= 'CountryPortalChangeStatus' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{COUNTRYPORTAL}', '{STATUS}', '{MESSAGE}', '{SITE_NAME}');
        $varKeywordValues = array($varPathImage, $varEmail, $arrStatus[$_REQUEST['status']], $varMsg, SITE_NAME);

        $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function

        $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);

        if ($varStatus == 'Active') {
            echo '<span class="label label-satgreen">Active</span>';
        } else {
            ?>
            <a href="javascript:void(0);" class="active" onclick="changeStatus('Active', '<?php echo $varEmail; ?>',<?php echo $varId; ?>)" title="Click here to active this country portal.">Active</a>
            <?php
        }
        if ($varStatus == 'Inactive') {
            echo '<span  class="label label label-lightred">Deactive</span>';
        } else {
            ?>
            <a href="javascript:void(0);" class="deactive" onclick="changeStatus('Inactive', '<?php echo $varEmail; ?>',<?php echo $varId; ?>)" title="Click here to deactive this country portal.">Deactive</a>
            <?php
        }

        break;

    case 'getAjaxProductDetails':

        $wholId = $_REQUEST['fkWholesalerID'];

        $objPackage = new Product();

        $varPrList = $objPackage->getAjaxProductDetails($wholId);


        if (is_array($varPrList)) {
            ?>


            <option value="0">Select Product</option>
            <?php
            foreach ($varPrList as $key => $value) {
                ?>
                <option value="<?php echo $value['pkProductID'] . 'vss' . $value['FinalPrice'] . 'vss' . $value['DiscountFinalPrice']; ?>"><?php echo $value['ProductName']; ?></option>
            <?php } ?>


            <?php
        }


        break;
    case 'dashboardEvents':
        $objDashboard = new Dashboard();
        $arrRes = $objDashboard->getFestivalEvents();
        foreach ($arrRes as $key => $val) {
            $arrRes[$key]['url'] = 'festival_edit_uil.php?id=' . $val['id'] . '&type=edit';
            $arrRes[$key]['end'] = date('Y-m-d', strtotime($val['end'] . ' + 1 day'));
        }
        echo json_encode($arrRes);
        break;

    case 'dashboardKpi':

        $arrRes = $objGeneral->dashboardKPI($_REQUEST);
        $string = json_encode($arrRes);
        echo $string;
        break;

    case 'checkCmsExists':
        echo $arrRes = $objClassCommon->checkCmsExists($_REQUEST);
        break;
    case 'findcatLavel':
        $objCategory = new category();
        $fetchCategoryLavel = $objCategory->findcatLavel($_REQUEST['cid']);
        echo $fetchCategoryLavel['CategoryLevel'];
        break;

    case 'findcatEditLavel':
        $objCategory = new category();
        $fetchCategoryLavel = $objCategory->findcatLavel($_REQUEST['cid']);
        echo json_encode(array('lavel' => $fetchCategoryLavel['CategoryLevel'], 'parentId' => $fetchCategoryLavel['CategoryParentId']));
        break;

    case 'attributeDetails':
        $objHome = new Home();
        $arrData = $objHome->getAttributeViewDetails($_REQUEST['atId'], $_REQUEST['pid']);
        $arrproductDetailsIsImgUploaded = explode(",", $arrData[0]['IsImgUploaded']);
        $arrproductDetailsOptionImage = explode(",", $arrData[0]['AttributeOptionImage']);
        $arrproductDetailsOptionTitle = explode(",", $arrData[0]['OptionTitle']);
        $arrproductDetailsColorcode = explode(",", $arrData[0]['colorcode']);
        $arrproductDetailsOptionId = explode(",", $arrData[0]['pkOptionID']);
        $arrproductDetailsOptionPrice = explode(",", $arrData[0]['OptionExtraPrice']);

        $varCountAtrributeOption = 0;
        $radioVal = count($arrproductDetailsOptionTitle);
        foreach ($arrproductDetailsOptionTitle as $valoptionTitle) {
            $varOptPrice .=$arrproductDetailsOptionId[$varCountAtrributeOption] . '=' . $objCore->getPrice($arrproductDetailsOptionPrice[$varCountAtrributeOption]) . ',';
            if ($arrproductDetailsOptionImage[$varCountAtrributeOption] != '') {
                ?>
                <img src="<?php echo UPLOADED_FILES_URL; ?>images/products/85x67/<?php echo $arrproductDetailsOptionImage[$varCountAtrributeOption]; ?>">
            <?php }
            ?>
            <input type="radio" vl="<?php echo $arrproductDetailsOptionPrice[$varCountAtrributeOption]; ?>" value="<?php echo $arrproductDetailsOptionId[$varCountAtrributeOption]; ?>" name="frmAttribute_<?php echo $arrData[0]['pkAttributeId'] . '_' . $_REQUEST['inc']; ?>" class="frmAttribute_<?php echo $arrData[0]['pkAttributeId'] . '_' . $_REQUEST['inc']; ?>" id="frmAttribute_<?php echo $arrData[0]['pkAttributeId'] . '_' . $_REQUEST['inc']; ?>" onclick="getPric(this.parentNode.id, this.id, '<?php echo $_REQUEST['inc']; ?>', '<?php echo $arrproductDetailsOptionPrice[$varCountAtrributeOption]; ?>', '')"/>
            <?php
            echo $valoptionTitle;
            $varCountAtrributeOption++;
        }
        break;

    case 'picingManageAdmin':
        $objlogistic = new Logistic();
        $logisticID = $_REQUEST['logisticID'];
        $mode = $_REQUEST['mode'];
        echo $objlogistic->getPricingHtml($logisticID, $mode);
        break;

    case 'logisticStatusApprove':
        $varStatus = $_REQUEST['status'];
        $varId = $_REQUEST['id'];
        $varEmail = $_REQUEST['emailid'];
        if ($_REQUEST['status'] == 'approve') {
            $varStatus = 'active';
        }
        $arrStatus = array('active' => 'Activated', 'deactive' => 'Deactivated', 'suspend' => 'Suspended', 'approve' => 'Approved', 'reject' => 'Rejected');

        $objwholesaler = new Logistic();

        $varNum = $objwholesaler->UpdateLogisticStatus($varStatus, $varId);

        $objCore->setSuccessMsg($varStatus == "active" ? ADMIN_MAILING_REQUEST_STATUS_APPROVE_SUCCESS_MSG : ADMIN_MAILING_REQUEST_STATUS_DISAPPROVE_SUCCESS_MSG);

        $objTemplate = new EmailTemplate();
        $objCore = new Core();


        $varToUser = $varEmail;
        $varFromUser = $_SESSION['sessAdminEmail'];
        $varSiteName = SITE_NAME;

        $varWhereTemplate = " EmailTemplateTitle= 'LogisticChangeStatusByAdmin' AND EmailTemplateStatus = 'Active' ";

        $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

        $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

        $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

        $varPathImage = '';
        $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';
        $link = '<a href="' . SITE_ROOT_URL . '">Click here</a>';

        $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

        $varKeyword = array('{IMAGE_PATH}', '{LOGISTIC}', '{STATUS}', '{MESSAGE}', '{SITE_NAME}', '{LINK}');
        $varKeywordValues = array($varPathImage, $varEmail, $arrStatus[$_REQUEST['status']], $varMsg, SITE_NAME, $link);

        echo $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

// Calling mail function

        $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
        break;
}
?>
