<?php

/**
 * ProductCtrl class controller.
 */
require_once CLASSES_PATH . 'class_product_bll.php';
require_once CLASSES_PATH . 'class_category_bll.php';

class ProductComparisonCtrl {
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
        $objCore = new Core();
        $objCore->setCurrencyPrice();
        //$objAdminLogin = new AdminLogin();
        //check admin session
        //$objAdminLogin->isValidAdmin();
        //************ Get Admin Email here
    }
    /**
     * function pageLoads
     *
     * This function Will be called on each page load and will check for any form submission.
     *
     * Database Tables used in this function are : None
     *
     * Use Instruction : $objProduct->pageLoad();
     *
     * @access public
     *
     * @return void
     */
    public function pageLoad() {
        $objCore = new Core();
        $objCategory = new Category();
        $objProduct = new Product();
        //pre($_POST);
        $this->arrData['arrCartDetails'] = $objCategory->myCartDetails();
        $this->arrData['arrAdsDetails'] = $objCategory->getAdsDetails();
         if(!empty($_SESSION['MyCompare']['Product']))
       {
        $this->arrData['arrCompDetails'] = $objCategory->myCompareDetails();
        $this->arrData['arrCompareDetails'] = $this->arrData['arrCompDetails']['product_details'];
        $this->arrData['arrCompareAttributeDetails'] = $this->arrData['arrCompDetails']['product_attribute'];
        $this->arrData['arrAttributeList'] = $this->arrData['arrCompDetails']['category_attribute'];
       //pre($this->arrData['arrCompDetails']);
       }
        $this->arrData['arrRecommendedDetails'] = $objCategory->myRecommendedDetails();
        
    }

}

$objPage = new ProductComparisonCtrl();
$objPage->pageLoad();
//pre($objProduct->arrproductDetails);

?>
