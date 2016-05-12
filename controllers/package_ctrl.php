<?php

/**
 * ProductCtrl class controller.
 */
require_once CLASSES_PATH . 'class_product_bll.php';
require_once CLASSES_PATH . 'class_category_bll.php';
require_once CLASSES_PATH . 'class_shopping_cart_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

class PackageCtrl {
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
        $objShoppingCart = new ShoppingCart();
        //pre($_POST);
        $this->arrData['arrCartDetails'] = $objShoppingCart->myCartDetails();
        $this->arrData['arrAdsDetails'] = $objProduct->getAdsDetails();
        
        if (isset($_REQUEST['pkgid'])) {
            $this->arrProductPackageDetails = $objProduct->getProductPackageDetails($_REQUEST['pkgid']);
        }
        if (!empty($_SESSION['MyCompare']['Product'])) {
            $this->arrData['arrCompDetails'] = $objCategory->myCompareDetails();
            $this->arrData['arrCompareDetails'] = $this->arrData['arrCompDetails']['product_details'];
        }
        $this->arrData['arrRecommendedDetails'] = $objCategory->myRecommendedDetails();

        if (isset($_REQUEST['frmReviewAdd']) && $_REQUEST['frmReviewAdd'] == 'add') {
            $objProduct->userReviewAdd($_REQUEST);
            header("location:".$objCore->getUrl('product.php',array('id'=>$_REQUEST['id'],'name'=>$_REQUEST['name'],'refNo'=>$_REQUEST['refNo'])));
        }

        

        if (isset($_SESSION['sessUserInfo']['id']) && $_SESSION['sessUserInfo']['type'] == "customer") {
            $this->arrCustomerDetails = $objProduct->CustomerDetails($_SESSION['sessUserInfo']['id']);
        }

        if (isset($_POST['frmHidenSend']) && $_POST['frmHidenSend'] == 'Send') {   // Editing images record

            $objProduct->sendRecommendedToFriend($_POST);
            header("location: ".$objCore->getUrl('product.php',array('id'=>$_REQUEST['id'],'name'=>$_REQUEST['name'],'refNo'=>$_REQUEST['refNo'])));
            die;
        }
        if (isset($_SESSION['sessUserInfo']['id']) && isset($_REQUEST['id'])) {
            $this->arrCustomerRatingDetails = $objProduct->myRatingDetailsByCustomer($_REQUEST['id'], $_SESSION['sessUserInfo']['id']);
        }
    }
    
    function getProductsDetails($valProductID)
    {
        //pre($_POST);
        $objCore = new Core();
        $objCategory = new Category();
        $objProduct = new Product();
        $objShoppingCart = new ShoppingCart();
        if (isset($valProductID)) {
            $arrProductDetails['varproductViewUpdate'] = $objProduct->getproductViewUpdate($valProductID);
            $arrProductDetails['arrproductDetails'] = $objProduct->getProductDetails($valProductID);
            $arrProductDetails['arrproductImages'] = $objProduct->getProductImages($valProductID);
            $arrProductDetails['arrproductReview'] = $objProduct->getUserReview($valProductID);
            $arrProductDetails['varproductWishlist'] = $objProduct->myWishlistDetails($valProductID);
            $arrProductDetails['arrRecentBuyer'] = $objProduct->getRecentBuyer($valProductID);
            $arrProductDetails['arrCustomerBoughtProduct'] = $objProduct->getCustomerBoughtProduct($valProductID);
            $arrProductDetails['arrRatingDetails'] = $objProduct->myRatingDetails($valProductID);
            //$this->arrUserRecommend=$objProduct->getUserRecommend($valProductID);
            //pre($this->arrproductReview);
            return $arrProductDetails;
        }
    }

}

$objPage = new PackageCtrl();
$objPage->pageLoad();
//pre($objProduct->arrproductDetails);
?>
