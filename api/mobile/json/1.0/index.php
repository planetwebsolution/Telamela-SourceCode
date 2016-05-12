<?php

//print_r($_REQUEST);

require_once '../../../../common/config/config.inc.php';
require_once '../../../../classes/class_email_template_bll.php';
require_once '../../../../classes/class_common.php';
require_once '../../../../classes/class_shopping_cart_bll.php';
require_once '../../../../solarium.php';
require_once '../../../../classes/class_category_bll.php';
require_once '../../../../classes/class_customer_user_bll.php';
require_once '../../../../classes/system/class_paging_bll.php';
require_once '../../../../classes/admin/class_paypal_email_bll.php';
require_once '../../../../classes/class_order_process_bll.php';
require_once API_MOBILE_PATH . 'api_processor_ctrl.php';
require_once '../../../../PPBootStrap.php';
require_once '../../../../common/paypal/Constants.php';
//This is used for turn off the errors and notices

error_reporting(0);
$categoryUrl = UPLOADED_FILES_URL . 'images/' . 'category/main_category1/';
$childCategoryUrl = UPLOADED_FILES_URL . 'images/' . 'category/main_category2/';
$bannerImgUrl = UPLOADED_FILES_URL . 'images/' . 'banner/600x400/';
$categoryBannerImgUrl = UPLOADED_FILES_URL . 'images/' . 'banner/1136x269/';
$productImgUrl = UPLOADED_FILES_URL . 'images/' . 'products/' . $arrProductImageResizes['landing'] . '/';
$catIconUrl = UPLOADED_FILES_URL . 'images/category/main_category1/icons/';
//$productImgUrlInner = UPLOADED_FILES_URL . 'images/' . 'products/' . $arrProductImageResizes['landing3'] . '/';

$objPage = new apiProcessorCtrl();

$arrRes = $objPage->pageLoad();
//print_r($arrProductImageResizes);die;
//pre($_REQUEST);
//pre($arrRes);
$json = json_encode($arrRes);

echo $json;
//@mail('deepak.kumar1@mail.vinove.com', 'Response', print_r($json, 1));
//@mail('aditya.sharma@mail.vinove.com', 'Response', print_r($json, 1));
//@mail('deepak.sindhu@mail.vinove.com', 'Response', print_r($json, 1));
die;
?>
