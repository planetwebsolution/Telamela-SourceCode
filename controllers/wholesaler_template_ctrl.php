<?php

/**
 * ProductCtrl class controller.
 */
require_once CLASSES_PATH . 'class_product_bll.php';
require_once CLASSES_PATH . 'class_category_bll.php';
require_once CLASSES_PATH . 'class_shopping_cart_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

class ProductCtrl {
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
		//echo "<pre>";print_r($_SESSION);echo "</pre>";
        $objCore = new Core();
        $objCategory = new Category();
        $objProduct = new Product();
        $objShoppingCart = new ShoppingCart();
        $pid = (int) $_REQUEST['id'];
        //pre($_POST);
        $this->arrData['arrCartDetails'] = $objShoppingCart->myCartDetails();
        $this->arrData['arrAdsDetails'] = $objProduct->getAdsDetails();        
        if ($pid > 0) {
//            $this->varproductViewUpdate = $objProduct->getproductViewUpdate($pid);
            $this->arrproductDetails = $objProduct->getProductDetails($pid);            
//            $this->arrproductImages = $objProduct->getProductImages($pid);
//            $this->arrproductReview = $objProduct->getUserReview($pid);
//            $this->varproductWishlist = $objProduct->myWishlistDetails($pid);
//            $this->arrRecentBuyer = $objProduct->getRecentBuyer($pid);
//            $this->arrCustomerBoughtProduct = $objProduct->getCustomerBoughtProduct($pid);
            //$this->arrUserRecommend=$objProduct->getUserRecommend($pid);            
           // $this->varBreadcrumbs = $objProduct->getBreadcrumb($this->arrproductDetails[0]['CategoryHierarchy']);
            //pre($this->varBreadcrumbs);
        }
        $this->arrCountryList = $objProduct->countryList();
        $this->arrwholesalerDetails = $objProduct->getWholesalerDetails($this->arrproductDetails[0]['fkWholesalerID']>0?$this->arrproductDetails[0]['fkWholesalerID']:$_SESSION['sessUserInfo']['id']);
        
    }

}

$objPage = new ProductCtrl();
$objPage->pageLoad();
//pre($objProduct->arrproductDetails);
?>
