<?php

/**
 * Site ShoppingCartCtrl Class
 *
 * This is the ShoppingCartCtrl class that will used on Shopping Cart Page.
 *
 * DateCreated 5th August, 2013
 *
 * DateLastModified 18th August, 2013
 *
 * @copyright Copyright (C) 2010-2012 Vinove Software and Services
 *
 * @version 10.0
 */
require_once CLASSES_PATH . 'class_customer_user_bll.php';
require_once CLASSES_PATH . 'class_shopping_cart_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_general_bll.php';
require_once CLASSES_PATH . 'class_shipping_price_api.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'shipping/usps/class_usps.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'shipping/ups/class_ups.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'shipping/fedex/class_fedex.php';
//require_once CLASSES_PATH . 'class_order_process_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_product_bll.php';

class ShoppingCartCtrl extends Paging {
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
        if (!isset($_SESSION['sessUserInfo']['type']) || $_SESSION['sessUserInfo']['type'] <> 'customer' || $_SESSION['MyCart']['Total'] < 1) {
            header('location:' . SITE_ROOT_URL);
        }
        $objCore = new Core();
        $objCore->setCurrencyPrice();
        //pre($_SESSION);
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
     * @return string $stringMessage
     */
    public function pageLoad() {
        $objCore = new Core();
        $objShoppingCart = new ShoppingCart();
        $objCustomer = new Customer();
//        pre($_SESSION);
        $this->arrData['CustomerDeatails'] = $objCustomer->CustomerDetailsWithCountryName($_SESSION['sessUserInfo']['id'], $_SESSION['RunShippingID']);
//        pre($this->arrData['CustomerDeatails']);
        if (isset($_REQUEST['RunShippingID'])) {
            //pre($_SESSION);
            $_SESSION['RunShippingID'] = $_REQUEST['RunShippingID'];
        } else {
            $_SESSION['RunShippingID'] = 0;
        }

//        pre($_REQUEST);
//        if ($_SESSION['RunShippingID'] == 1) {
//            $arrCustomerDetails[0]['ShippingFirstName'] = $this->arrData['CustomerDeatails'][0]['1_ShippingFirstName'];
//            $arrCustomerDetails[0]['ShippingLastName'] = $this->arrData['CustomerDeatails'][0]['1_ShippingLastName'];
//            $arrCustomerDetails[0]['ShippingOrganizationName'] = $this->arrData['CustomerDeatails'][0]['1_ShippingOrganizationName'];
//            $arrCustomerDetails[0]['ShippingAddressLine1'] = $this->arrData['CustomerDeatails'][0]['1_ShippingAddressLine1'];
//            $arrCustomerDetails[0]['ShippingAddressLine2'] = $this->arrData['CustomerDeatails'][0]['1_ShippingAddressLine2'];
//            $arrCustomerDetails[0]['ShippingCountry'] = $this->arrData['CustomerDeatails'][0]['1_ShippingCountry'];
//            $arrCustomerDetails[0]['ShippingState'] = $this->arrData['CustomerDeatails'][0]['1_ShippingState'];
//            $arrCustomerDetails[0]['ShippingCity'] = $this->arrData['CustomerDeatails'][0]['1_ShippingCity'];
//            $arrCustomerDetails[0]['ShippingCountryName'] = $this->arrData['CustomerDeatails'][0]['1_ShippingCountryName'];
//            $arrCustomerDetails[0]['ShippingPostalCode'] = $this->arrData['CustomerDeatails'][0]['1_ShippingPostalCode'];
//            $arrCustomerDetails[0]['ShippingPhone'] = $this->arrData['CustomerDeatails'][0]['1_ShippingPhone'];
//        } else if ($_SESSION['RunShippingID'] == 2) {
//            
//            $arrCustomerDetails[0]['ShippingFirstName'] = $this->arrData['CustomerDeatails'][0]['2_ShippingFirstName'];
//            $arrCustomerDetails[0]['ShippingLastName'] = $this->arrData['CustomerDeatails'][0]['2_ShippingLastName'];
//            $arrCustomerDetails[0]['ShippingOrganizationName'] = $this->arrData['CustomerDeatails'][0]['2_ShippingOrganizationName'];
//            $arrCustomerDetails[0]['ShippingAddressLine1'] = $this->arrData['CustomerDeatails'][0]['2_ShippingAddressLine1'];
//            $arrCustomerDetails[0]['ShippingAddressLine2'] = $this->arrData['CustomerDeatails'][0]['2_ShippingAddressLine2'];
//            $arrCustomerDetails[0]['ShippingCountry'] = $this->arrData['CustomerDeatails'][0]['2_ShippingCountry'];
//            $arrCustomerDetails[0]['ShippingState'] = $this->arrData['CustomerDeatails'][0]['2_ShippingState'];
//            $arrCustomerDetails[0]['ShippingCity'] = $this->arrData['CustomerDeatails'][0]['2_ShippingCity'];
//            $arrCustomerDetails[0]['ShippingCountryName'] = $this->arrData['CustomerDeatails'][0]['2_ShippingCountryName'];
//            $arrCustomerDetails[0]['ShippingPostalCode'] = $this->arrData['CustomerDeatails'][0]['2_ShippingPostalCode'];
//            $arrCustomerDetails[0]['ShippingPhone'] = $this->arrData['CustomerDeatails'][0]['2_ShippingPhone'];
//            //pre($arrCustomerDetails);
//        } else {
//            $arrCustomerDetails[0]['ShippingFirstName'] = $this->arrData['CustomerDeatails'][0]['ShippingFirstName'];
//            $arrCustomerDetails[0]['ShippingLastName'] = $this->arrData['CustomerDeatails'][0]['ShippingLastName'];
//            $arrCustomerDetails[0]['ShippingOrganizationName'] = $this->arrData['CustomerDeatails'][0]['ShippingOrganizationName'];
//            $arrCustomerDetails[0]['ShippingAddressLine1'] = $this->arrData['CustomerDeatails'][0]['ShippingAddressLine1'];
//            $arrCustomerDetails[0]['ShippingAddressLine2'] = $this->arrData['CustomerDeatails'][0]['ShippingAddressLine2'];
//            $arrCustomerDetails[0]['ShippingCountry'] = $this->arrData['CustomerDeatails'][0]['ShippingCountry'];
//            $arrCustomerDetails[0]['ShippingState'] = $this->arrData['CustomerDeatails'][0]['ShippingState'];
//            $arrCustomerDetails[0]['ShippingCity'] = $this->arrData['CustomerDeatails'][0]['ShippingCity'];
//            $arrCustomerDetails[0]['ShippingCountryName'] = $this->arrData['CustomerDeatails'][0]['ShippingCountryName'];
//            $arrCustomerDetails[0]['ShippingPostalCode'] = $this->arrData['CustomerDeatails'][0]['ShippingPostalCode'];
//            $arrCustomerDetails[0]['ShippingPhone'] = $this->arrData['CustomerDeatails'][0]['ShippingPhone'];
//        }

        $arrCustomer = $objCustomer->CustomerDetailsForShipping($_SESSION['sessUserInfo']['id'], $_SESSION['RunShippingID']);
        //pre($arrCustomer);
        if (isset($arrCustomer['ShippingPostalCode']) && $arrCustomer['ShippingPostalCode'] <> '') {
            //pre($arrCustomer);
            $this->arrData['arrCartDetails'] = $objShoppingCart->myCartDetails($arrCustomer);

//            pre($this->arrData['arrCartDetails']);
//            foreach ($this->arrData['arrCartDetails']['Product'] as $kVal => $Vvalue) {
//                foreach ($Vvalue['ShippingDetails'] as $kk => $vv) {
//                    foreach ($vv['Methods'] as $k => $v) {
//                        
////                        pre($v);
//                        if ($v['tostate'] != 0 && $v['tostate'] != $arrCustomerDetails[0]['ShippingState']) {
//                            unset($this->arrData['arrCartDetails'][$kVal]['ShippingDetails'][$kk]['Methods'][$k]);
//                        } else if ($v['tocity'] != 0 && $v['tocity'] != $arrCustomerDetails[0]['ShippingCity']) {
//                            unset($this->arrData['arrCartDetails'][$kVal]['ShippingDetails'][$kk]['Methods'][$k]);
//                        }
//                        
//                        if(empty($v)){
//                            unset($this->arrData['arrCartDetails'][$kVal]['ShippingDetails'][$kk]);
//                        }
//                        
//                    }
//                }
//            }
//            pre($arrCustomerDetails);
           // pre($this->arrData['arrCartDetails']);
        } else {
            header('location:billing_and_shipping_address.php');
        }
    }

}

$objPage = new ShoppingCartCtrl();
$objPage->pageLoad();
?>
