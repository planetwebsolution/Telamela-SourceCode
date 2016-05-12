<?php

/* * ****************************************
  Module name : Config file
  Parent module : None
  Date created : 20Apr2011
  Date last modified : 10 Oct 2012
  Created by : Deepesh Pathak
  Last modified by : Aditya Pratap Singh
  Comments : System config file . Here we set all configuration options and all constant variable
 * **************************************** */
//Set display error true. 
ini_set('display_errors', "1");
//Report all error except notice
ini_set('error_reporting', E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_WARNING ^ E_STRICT);
//  ini_set('error_reporting', E_ALL);
// Do not allow php_sess_id to be passed in the querystring and it's use for google search
ini_set('session.use_only_cookies', 1);
ini_set("zlib.output_compression", "On");

if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
    ob_start("ob_gzhandler");
//Start new sesstion

@session_start();
//Database configuration settings for local and server mode and define some constant

if ($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "192.168.100.97" || $_SERVER['HTTP_HOST'] == "dothejob.in")
{ 
    
    $arrConfig['dbHost'] = 'localhost';
    $arrConfig['dbName'] = 'telamela';
    $arrConfig['dbUser'] = 'root';
    $arrConfig['dbPass'] = 'miami@123';
	
    //$arrConfig['siteRootURL'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	$arrConfig['siteRootURL'] ='http://192.168.100.97/hemant/telamela/pro/';
	define('SCRIPT_NAME', '/hemant/telamela/pro/index.php');
    define('RECAPTCHA_PUBLIC_KEY', '6LcRZckSAAAAAK1z3hqjw-RC5VDD-Z8igb6rqcWa');
    define('RECAPTCHA_PRIVATE_KEY', '6LcRZckSAAAAAKa3TFJpVaVIBs9AGKuq956sWJQS');
    define('GOOGLE_MAP_KEY', 'ABQIAAAA-CuDMkM7piIMiLKd2QUlchTt8kM4HLSPjv3l1TSpErqGULImDRQZQdIMFIv0zWpc6qYWYmgJVLI32g');
    define('IP_LOCATION_KEY', '51e7c1ec35f73681c1e61d338cd78e9388ad681f89e132a98e116a4188139ebf');
    define('CHECKOUT_SID', '1668207'); //2CO Seller ID     
    define('LOCAL_MODE', true);
    define('htpassowrdaccess', 'no');
}
else if ($_SERVER['HTTP_HOST'] == "star.vinove.com")
{
    $arrConfig['dbHost'] = 'localhost';
    $arrConfig['dbName'] = 'choice';
    $arrConfig['dbUser'] = 'team';
    $arrConfig['dbPass'] = 'vnv_pixel';
    $arrConfig['siteRootURL'] = 'http://' . $_SERVER['HTTP_HOST'] . '/~sandbox/labs/telamela/';
    define('LOCAL_MODE', false);

    define('RECAPTCHA_PUBLIC_KEY', '6LcTZckSAAAAAAOl-hJb9G5x6mwfq20WAGRGAKqF');
    define('RECAPTCHA_PRIVATE_KEY', '6LcTZckSAAAAAAWbC6VDox9apCpV3uKVoaofnoF7');
    define('GOOGLE_MAP_KEY', 'ABQIAAAA-CuDMkM7piIMiLKd2QUlchTt8kM4HLSPjv3l1TSpErqGULImDRQZQdIMFIv0zWpc6qYWYmgJVLI32g');
    define('IP_LOCATION_KEY', '51e7c1ec35f73681c1e61d338cd78e9388ad681f89e132a98e116a4188139ebf');
    define('CHECKOUT_SID', '1668207'); //2CO Seller ID
    define('htpassowrdaccess', 'no');
}
else if ($_SERVER['HTTP_HOST'] == "iworklab.com")
{
    $arrConfig['dbHost'] = 'localhost';
    $arrConfig['dbName'] = 'iworklac_choice';
    $arrConfig['dbUser'] = 'iworklac_choice';
    $arrConfig['dbPass'] = 'e5^FEzLyecu5';
    $arrConfig['siteRootURL'] = 'http://' . $_SERVER['HTTP_HOST'] . '/projects/telamela/';
    define('LOCAL_MODE', false);
    define('SCRIPT_NAME', '/projects/telamela/index.php');
    define('RECAPTCHA_PUBLIC_KEY', '6LcQZckSAAAAAPmFda9bxLY3LuD3PKeGQWoJ1yA5');
    define('RECAPTCHA_PRIVATE_KEY', '6LcQZckSAAAAAJusereSDgHgIYxWjsmX2S2t1DXU');
    //ABQIAAAA-CuDMkM7piIMiLKd2QUlchQbU--pZMdX1VpjiXQZ33oImq6p0BSrbJvIpkkku_uiEaeZjS0htQ6T2w
    define('GOOGLE_MAP_KEY', 'ABQIAAAA-CuDMkM7piIMiLKd2QUlchQbU--pZMdX1VpjiXQZ33oImq6p0BSrbJvIpkkku_uiEaeZjS0htQ6T2w');
    define('IP_LOCATION_KEY', '51e7c1ec35f73681c1e61d338cd78e9388ad681f89e132a98e116a4188139ebf');
    define('CHECKOUT_SID', '1669746');
    define('htpassowrdaccess', 'no');
    //2CO Seller ID
}
else if ($_SERVER['HTTP_HOST'] == "i.vinove.com")
{
    $arrConfig['dbHost'] = 'localhost';
    $arrConfig['dbName'] = 'sandbox_choice';
    $arrConfig['dbUser'] = 'sandbox';
    $arrConfig['dbPass'] = 'vinove';
    $arrConfig['siteRootURL'] = 'http://' . $_SERVER['HTTP_HOST'] . '/telamela/';
    define('LOCAL_MODE', false);
    define('SCRIPT_NAME', '/telamela/index.php');
    define('RECAPTCHA_PUBLIC_KEY', '6LcQZckSAAAAAPmFda9bxLY3LuD3PKeGQWoJ1yA5');
    define('RECAPTCHA_PRIVATE_KEY', '6LcQZckSAAAAAJusereSDgHgIYxWjsmX2S2t1DXU');
    //ABQIAAAA-CuDMkM7piIMiLKd2QUlchQbU--pZMdX1VpjiXQZ33oImq6p0BSrbJvIpkkku_uiEaeZjS0htQ6T2w
    define('GOOGLE_MAP_KEY', 'ABQIAAAA-CuDMkM7piIMiLKd2QUlchQbU--pZMdX1VpjiXQZ33oImq6p0BSrbJvIpkkku_uiEaeZjS0htQ6T2w');
    define('IP_LOCATION_KEY', '51e7c1ec35f73681c1e61d338cd78e9388ad681f89e132a98e116a4188139ebf');
    define('CHECKOUT_SID', '1669746');
    define('htpassowrdaccess', 'no');
    //2CO Seller ID
}
//else if ($_SERVER['HTTP_HOST'] == "www.telamela.com.au" || $_SERVER['HTTP_HOST'] == "telamela.com.au" || $_SERVER['HTTP_HOST'] == "54.79.97.86")
//{ 
//    $arrConfig['dbHost'] = 'localhost';
//    $arrConfig['dbName'] = 'telema';
//    $arrConfig['dbUser'] = 'root';
//    $arrConfig['dbPass'] = 'miami@123';
//    $arrConfig['siteRootURL'] = 'http://' . $_SERVER['HTTP_HOST'] . '/';
//    define('LOCAL_MODE', false);
//    define('SCRIPT_NAME', '/index.php');
//    define('RECAPTCHA_PUBLIC_KEY', '6LcQZckSAAAAAPmFda9bxLY3LuD3PKeGQWoJ1yA5');
//    define('RECAPTCHA_PRIVATE_KEY', '6LcQZckSAAAAAJusereSDgHgIYxWjsmX2S2t1DXU');
//    //ABQIAAAA-CuDMkM7piIMiLKd2QUlchQbU--pZMdX1VpjiXQZ33oImq6p0BSrbJvIpkkku_uiEaeZjS0htQ6T2w
//    define('GOOGLE_MAP_KEY', 'ABQIAAAA-CuDMkM7piIMiLKd2QUlchQbU--pZMdX1VpjiXQZ33oImq6p0BSrbJvIpkkku_uiEaeZjS0htQ6T2w');
//    define('IP_LOCATION_KEY', '51e7c1ec35f73681c1e61d338cd78e9388ad681f89e132a98e116a4188139ebf');
//    define('CHECKOUT_SID', '1669746');
//    define('htpassowrdaccess', 'no');
//    //2CO Seller ID
//}
else
{
    //$arrConfig['FckEditorImagePath'] = '/beta/common/uploaded_files/userfiles/';
}

//Get source root path 
$varSiteFsPath = dirname(__FILE__);
$varSiteFsPath = str_replace('\\', '/', $varSiteFsPath);
$arrConfig['sourceRoot'] = str_replace('/common/config', '/', $varSiteFsPath);
//pre($arrConfig);
//define site database values
define('SITE_HOST', $arrConfig['dbHost']);
define('SITE_DATABASE_NAME', $arrConfig['dbName']);
define('SITE_DATABASE_USER_NAME', $arrConfig['dbUser']);
define('SITE_DATABASE_PASSWORD', $arrConfig['dbPass']);

//Site root url define in constant variable
define('SITE_ROOT_URL', $arrConfig['siteRootURL']);

define('SITE_ROOT_URL_HOST', 'http://' . $_SERVER['HTTP_HOST'] . '/');

define('FCK_EDITOR_SOURCE_PATH', SITE_ROOT_URL . 'components/html_editor/fckeditor/');

//Define source root path
define('SOURCE_ROOT', $arrConfig['sourceRoot']);

//Define key for the encription
define('SITE_PASSWORD_ENCRYPTION_KEY', 'vinove');

//Define Admin help title.
define('ADMIN_HELP_TITLE', 'Secure Administrative Suite: Telamela');

//Define Admin help title.
define('FRONT_TITLE', 'Telamela');
define('RETURN_TO_TELAMELA', 'Return to telamela');

//define site path
define('PATH_URL_CM', SITE_ROOT_URL . 'common/');
define('IMAGE_PATH_URL', SITE_ROOT_URL . 'common/images/');
define('IMAGE_SOURCE_PATH', SOURCE_ROOT . 'common/images/');
define('INC_PATH', SOURCE_ROOT . 'common/inc/');
define('LANDING_IMAGE_PATH_URL', SITE_ROOT_URL . 'common/uploaded_files/images/category/main_category2/');

//controllers path
define('CONTROLLERS_PATH', SOURCE_ROOT . 'controllers/');
define('CONTROLLERS_ADMIN_PATH', CONTROLLERS_PATH . 'admin/');
define('CONTROLLERS_LOGISTIC_PATH', CONTROLLERS_PATH . 'logistic/');
define('API_PATH', SOURCE_ROOT . 'api/json/1.0/');
define('API_OFFLINE_PATH', SOURCE_ROOT . 'api/offline/json/1.0/');
define('API_MOBILE_PATH', SOURCE_ROOT . 'api/mobile/json/1.0/');

//classes path
define('CLASSES_PATH', SOURCE_ROOT . 'classes/');
define('CLASSES_SYSTEM_PATH', CLASSES_PATH . 'system/');
define('CLASSES_ADMIN_PATH', CLASSES_PATH . 'admin/');
define('CLASSES_LOGISTIC_PATH', CLASSES_PATH . 'logistic/');
define('AJAX_PATH', SOURCE_ROOT . 'common/ajax/');


//define site front end path
define('IMAGE_FRONT_PATH_URL', SITE_ROOT_URL . 'common/images/');
define('IMAGE_FRONT_SOURCE_PATH', 'common/images/');
define('INC_FRONT_PATH', 'common/inc/');
define('INC_FRONT_CSS_PATH', 'common/css/');
define('INC_FRONT_JS_PATH', 'common/js/');
define('FRONT_JS_PATH', SITE_ROOT_URL . 'common/front_js/');
define('CLASSES_FRONT_PATH', 'classes/');


//define uploaded files path
define('UPLOADED_FILES_URL', SITE_ROOT_URL . 'common/uploaded_files/');
define('IMAGES_URL', SITE_ROOT_URL . 'common/images/');
define('UPLOADED_FILES', SOURCE_ROOT . 'common/uploaded_files/');
define('UPLOADED_FILES_SOURCE_PATH', SOURCE_ROOT . 'common/uploaded_files/');
define('COMPONENTS_SOURCE_ROOT_PATH', SOURCE_ROOT . 'components/');

define('INVOICE_URL', SITE_ROOT_URL . 'invoices/');
define('INVOICE_PATH', SOURCE_ROOT . 'invoices/');
define('TEMPLATE_URL', SITE_ROOT_URL . 'common/email_template/email/');
//define character set for pages
define('CHARACTER_SET', 'utf-8');

//define site email address
define('SITE_EMAIL_ADDRESS', 'info@abc.com');

//Define site paging record limit
define('PAGE_SIZE', 5);

define('ADMIN_RECORD_LIMIT', 5);
define('GRID_VIEW_RECORD_LIMIT', 12);
define('LIST_VIEW_RECORD_LIMIT', 12);
define('GIFT_CARDS_RECORD_LIMIT', 5);
define('LIST_CART_BOX_LIMIT', 3);
define('TOP_SELLING_PRODUCT_MIN_LIMIT', 4);

//Social url
define('YOUTUBE_URL', 'http://www.youtube.com/channel/UCkyQ17NpO1m9NIq_K3YvcbQ?guided_help_flow=3');
define('TWITTER_URL', 'https://twitter.com/TelamelaGlobal');
define('FACEBOOK_URL', 'https://www.facebook.com/pages/Telamela-PTY-LTD/562683003816287');
define('GPLUS_URL', 'https://plus.google.com/b/106629883910578985751/106629883910578985751/about?hl=enRSS');

//define JS file
define('FCK_EDITOR_PATH_URL', SITE_ROOT_URL . 'components/html_editor/fckeditor/');
define('CKEDITOR_URL', SITE_ROOT_URL . 'components/html_editor/ckeditor/');
define('VALIDATE_JS', $arrConfig['siteRootURL'] . 'common/js/functions_js.js');

define('JS_PATH', $arrConfig['siteRootURL'] . 'common/js/');
define('CSS_PATH', $arrConfig['siteRootURL'] . 'common/css/');
define('CALENDAR_URL', $arrConfig['siteRootURL'] . 'common/calendar/');
define('TEMPLATE_PATH', $arrConfig['siteRootURL'] . 'common/wholesaler_template/template');


//define thumbnail JS file
define('THUMBNAIL_JS', $arrConfig['siteRootURL'] . 'common/js/thumbnailviewer.js');

//define AJAX file
define('AJAX_JS', $arrConfig['siteRootURL'] . 'common/js/ajax_js.js');

//define admin CSS file
define('ADMIN_CSS', $arrConfig['siteRootURL'] . 'admin/css/admin.css');
define('ADMIN_CSS_PATH', $arrConfig['siteRootURL'] . 'admin/css/');
define('ADMIN_JS_PATH', $arrConfig['siteRootURL'] . 'admin/js/');

//define site CSS file
define('SITE_CSS', $arrConfig['siteRootURL'] . 'common/css/layout.css');

//define thumbnail CSS file
define('THUMBNAIL_CSS', $arrConfig['siteRootURL'] . 'common/css/thumbnailviewer.css');

//define admin email
define('ADMIN_EMAIL', isset($_SESSION['sessAdminEmail']) ? $_SESSION['sessAdminEmail'] : '');

//define admin email
define('ADMIN_CONTACT_EMAIL', 'ranjeet.singh@mail.vinove.com');

//define SITE NAME
define('SITE_NAME', 'Telamela');

//site wise currency 
define('SITE_CURRENCY', 'USD');
//site title admin panel
define('ADMIN_PANEL_NAME', 'Secure Administrative Suite: Choice1');

//site administrator email
define('NO_REPLY_EMAIL', 'no-reply@vinove.com');


define('IMG_UPLOAD_AND_CROP_PATH', $arrConfig['siteRootURL'] . 'common/upload-and-crop-master/');

define('IMG_UPLOAD_AND_CROP', SITE_ROOT_URL . 'common/');

//define max upload image size 
define('MAX_UPLOAD_SIZE', 10485760); // in byte

define('MAX_PRODUCT_IMAGE_SIZE', 10485760); //in byte

define('MIN_PRODUCT_IMAGE_WIDTH', 600); // in px
define('MIN_PRODUCT_IMAGE_HEIGHT', 600); // in px
define('MAX_PRODUCT_IMAGE_WIDTH', 1200); // in px
define('MAX_PRODUCT_IMAGE_HEIGHT', 1200); // in px
define('MIN_PRODUCT_SLIDER_IMAGE_WIDTH', 800); // in px
define('MIN_PRODUCT_SLIDER_IMAGE_HEIGHT', 600); // in px
define('MIN_PRODUCT_DETAIL_IMAGE_HEIGHT', 600); // in px
//  for product resize
define('PRODUCT_IMAGE_RESIZE1', '70x70'); // width x height 
define('PRODUCT_IMAGE_RESIZE2', '125x125'); // width x height 
define('PRODUCT_IMAGE_RESIZE3', '300x300'); // width x height
define('PRODUCT_IMAGE_RESIZE4', '280x350'); // width x height // details Images
define('PRODUCT_IMAGE_RESIZE5', '300x200'); // width x height slider image

define('PACKAGE_IMAGE_RESIZE1', '65x65'); // width x height
//$arrProductImageResizes = array('default' => '65x65', 'listing' => '125x125', 'special' => '157x157', 'detail' => '280x280', 'detailHover' => '600x600');
$arrProductImageResizes = array('color' => '35x35', 'default' => '85x67', 'global' => '208x185', 'productdetails' => '280x408', 'recomended' => '104x129', 'cart' => '116x101', 'landing' => '370x400', 'landing3' => '124x174', 'detailHover' => '600x600');
$arrSpecialPageBannerImage = array('thumb' => '120x45', 'big' => '1136x269', 'reward' => '1000x321');

//  for Ads Image Resize

define('ADS_IMAGE_RESIZE1', '276x160'); // width x height 
define('ADS_IMAGE_RESIZE2', '158x117');
define('ADS_IMAGE_RESIZE3', '243x117');
define('ADS_IMAGE_RESIZE4', '264x207');

define("PAYPAL_BUSINESS_ID", "ranjeet.singh@mail.vinove.com");

define('SPECIAL_PAYPAL_ID', 'arvind.yadav-facilitator@mail.vinove.com');
//Date Formate

define('DEFAULT_TIME_ZONE', 'Asia/Calcutta');
//define('DEFAULT_TIME_ZONE', 'America/Los_Angeles');
//date_default_timezone_set(DEFAULT_TIME_ZONE);
//echo date_default_timezone_get();
define('DATE_FORMAT_SITE', 'd-m-Y'); //dd-mm-yyyy
define('DATE_TIME_FORMAT_SITE', 'd-m-Y H:i:s'); //dd-mm-yyyy H:i:s
define('DATE_TIME_FORMAT_SITE_BACK', 'Y-m-d h:i:s'); //dd-mm-yyyy H:i:s
define('DATE_NULL_VALUE_SITE', '00-00-0000'); //dd-mm-yyyy
define('DATE_TIME_NULL_VALUE_SITE', '0000-00-00 00:00:00'); //yyyy-mm-dd H:i:s
define('DATE_FORMAT_MONTH_YEAR_SITE', 'F Y'); // dd year

define('DATE_FORMAT_SITE_FRONT', 'd M Y'); //dd-mm-yyyy
define('DATE_TIME_FORMAT_SITE_FRONT', 'd M Y H:i:s'); //dd-mm-yyyy H:i:s

define('DATE_TIME_FORMAT_SITE_FRONT_MINUTES', 'd M Y H:i'); //dd-mm-yyyy H:i:s


define('DATE_FORMAT_DB', 'Y-m-d'); //yyyy-mm-dd
define('DATE_TIME_FORMAT_DB', 'Y-m-d H:i:s'); //yyyy-mm-dd H:i:s
define('DATE_NULL_VALUE_DB', '0000-00-00'); //yyyy-mm-dd
define('DATE_TIME_NULL_VALUE_DB', '0000-00-00 00:00:00'); //yyyy-mm-dd H:i;s
define('NEW_PRODUCT_BASED_ON_DAYS', '5');
define('WHATS_NEW_BASED_ON_NUBER_OF_DAYS', '90');
define('PRODUCT_LISTING_LIMIT_PER_PAGE', '200');
define('WHOLESALER_WARNING_LIMIT', 3);
define('NEWSLETTER_SEND_LIMIT', 10);
define('REVIEW_MESSAGE_LIMIT', 1000);
define('RECENT_REVIEW_MESSAGE_LIMIT', -2);
define('DEFAULT_SHIPPING_CHARGE', '4.00');
define('PAYPAL_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
define('PAYPAL_STATUS', 'Pending');
//define('PAYPAL_URL', 'https://www.paypal.com/cgi-bin/webscr');
//define('PAYPAL_STATUS', 'Completed');
define('MINIMUM_ORDER_', '3.00');
define('MINIMUM_ORDER_PRICE', '3.00');

// htaccess pattern
define('URL_PATTERN_SEPRATER', '/');
define('URL_PATTERN_PRODUCT', 'name' . URL_PATTERN_SEPRATER . 'id');
define('URL_PATTERN_CATEGORY', 'name' . URL_PATTERN_SEPRATER . 'cid');
define('URL_PATTERN_SPECIAL', 'name' . URL_PATTERN_SEPRATER . 'cid');
define('URL_PATTERN_LANDING', 'name' . URL_PATTERN_SEPRATER . 'cid');
define('URL_PATTERN_PACKAGE', 'name' . URL_PATTERN_SEPRATER . 'pkgid');
define('URL_PATTERN_CUST_ORDER_DETAILS', 'action' . URL_PATTERN_SEPRATER . 'oid');
define('URL_PATTERN_CUST_VIEW_INBOX', 'myAction' . URL_PATTERN_SEPRATER . 'frmInboxChangeAction' . URL_PATTERN_SEPRATER . 'frmID');
define('URL_PATTERN_CUST_VIEW_OUTBOX', 'myAction' . URL_PATTERN_SEPRATER . 'frmOutboxChangeAction' . URL_PATTERN_SEPRATER . 'frmID');

define('URL_PATTERN_CONTENT', 'cms' . URL_PATTERN_SEPRATER . 'id');
define('URL_PATTERN_WHOLSALER_VIEW', 'action' . URL_PATTERN_SEPRATER . 'wid');

define('TRANSACTION_DAYS_ALERT', 30);
define('FILTER_PRICE_LIMIT', "999999");
define('FILTER__LIMIT', "999999");
define('TOP_MENU_LIMIT', 9);

//Include files

require_once SOURCE_ROOT . 'common/config/table_constants.inc.php';
require_once SOURCE_ROOT . 'common/config/messages.inc.php';
require_once SOURCE_ROOT . 'common/config/filenames.inc.php';

require_once SOURCE_ROOT . 'classes/system/class_database_dbl.php';
require_once SOURCE_ROOT . 'classes/system/class_core_bll.php';

require_once $arrConfig['sourceRoot'] . 'classes/admin/class_adminlogin_bll.php';
require_once $arrConfig['sourceRoot'] . 'classes/logistic/class_logistic_login_bll.php';
require_once SOURCE_ROOT . 'classes/admin/class_user_bll.php';
require_once SOURCE_ROOT . 'classes/system/class_general_bll.php';
//require_once SOURCE_ROOT . 'classes/system/memcache.caching.php';
//$oCache = new CacheMemcache();

$objCore = new Core();
$objGeneral = new General();
$objUser = new User();
//$visitor=new Visitor();
$paymentMode = array("Paypal" => "Paypal", "Bank Transfer" => "Bank Transfer", "Check" => "Check");

//Open a connection to Database
$objDatabase = new Database($arrConfig['dbHost'], $arrConfig['dbUser'], $arrConfig['dbPass'], $arrConfig['dbName']);
$objDatabase->connect();
$objUser->checkLogin();

//$visitor->saveVisitorInfo();

function pre($array = '')
{
    echo "<pre>";
    print_r($array);
    die;
}

//isset($_SESSION['MyCart']) && $_SESSION['MyCart']!=''?setcookie("MyCart", serialize($_SESSION['MyCart']), time()+3600):'';
//$_SESSION['MyCart']=isset($_SESSION['MyCart']) && $_SESSION['MyCart']!=''?$_SESSION['MyCart']:unserialize($_COOKIE["MyCart"]);
//print_r($_SESSION['MyCart']['Total']);
//print_r($_COOKIE);
?>
