<?php

require_once CLASSES_PATH . 'class_customer_user_bll.php';
require_once CLASSES_PATH . 'class_shopping_cart_bll.php';
require_once CLASSES_PATH . 'class_shipping_price_api.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'shipping/usps/class_usps.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'shipping/ups/class_ups.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'shipping/fedex/class_fedex.php';

/**
 * Site OrderPageCtrl Class
 *
 * This is the OrderPageCtrl class that will used on order Details on Cart.
 *
 * DateCreated 5th August, 2013
 *
 * DateLastModified 18th August, 2013
 *
 * @copyright Copyright (C) 2010-2012 Vinove Software and Services
 *
 * @version 10.0
 */
class OrderPageCtrl {
    /*
     * Variable declaration begins
     *
     * holds the heading of the page
     */

    public $varHeading = '';

    /*
     * constructor
     */

    public function __construct() {
        /*
         * Checking valid login session
         */

        if (!isset($_SESSION['sessUserInfo']['type']) || $_SESSION['sessUserInfo']['type'] <> 'customer' || $_SESSION['MyCart']['Total']<1) {
            header('location:' . SITE_ROOT_URL);
        }
//        pre($_SESSION);
        $objCore = new Core();
        $objCore->setCurrencyPrice();
    }

    /**
     * function pageLoad
     *
     * This function Will be called on each page load and will check for any form submission.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters 0 
     *
     * @return string $arrData
     */
    public function pageLoad() {
//    	pre($_REQUEST);
//    	pre($_SESSION);
        $objCore = new Core();
        $objCustomer = new Customer();
        $objShoppingCart = new ShoppingCart();
        $objShipping = new ShippingPrice();

        $this->arrData['CustomerDeatails'] = $objCustomer->CustomerDetailsWithCountryName($_SESSION['sessUserInfo']['id']);
        $arrRes = $objShoppingCart->myCartDetails();
//        pre($arrRes);
        $this->arrData['arrCartDetails'] = $arrRes;
        $varShippingCost = 0;

        $arrShipping = $_POST;
//        pre($arrShipping);

        foreach ($arrRes['Product'] as $key => $val) {

            if (isset($_POST['UpdateMyCart'])) {
                 $varShi = $arrShipping['proRad'][$key];
                 $this->arrData['arrCartDetails']['Product'][$key]['AppliedShipping'] = $objShipping->appliedShipping($varShi, $val['pkProductID'], $key, 'Product');
//             	$varShi = $arrShipping;
//             	$this->arrData['arrCartDetails']['Product'][$key]['AppliedShipping'] = $objShipping->appliedShipping($varShi, $val['pkProductID'], $key, 'Product');
            }
            $varShippingCost += $this->arrData['arrCartDetails']['Product'][$key]['AppliedShipping']['ShippingCost'];
        }

        foreach ($arrRes['Package'] as $key => $val) {
            if (isset($_POST['UpdateMyCart'])) {
                $varShi = $arrShipping['pkgRad'][$key];
                $this->arrData['arrCartDetails']['Package'][$key]['AppliedShipping'] = $objShipping->appliedShipping($varShi, $val['pkPackageId'], $key, 'Package');
            }
            $varShippingCost += $this->arrData['arrCartDetails']['Package'][$key]['AppliedShipping']['ShippingCost'];
        }
        $this->arrData['ShippingCost'] = $varShippingCost;
        //pre($_SESSION);
        //pre($this->arrData['arrCartDetails']);
        // end of page load
    }

}

$objPage = new OrderPageCtrl();
$objPage->pageLoad();

//print_r($objPage->arrRow[0]);
?>
