<?php

/**
 * ProductCtrl class controller.
 */
require_once CLASSES_PATH . 'class_product_bll.php';
require_once CLASSES_PATH . 'class_category_bll.php';
require_once CLASSES_PATH . 'class_shopping_cart_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';
require_once CLASSES_PATH . 'class_home_bll.php';

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
        $objHome = new Home();
//        pre($_REQUEST);
        
        $this->arrData['arrAdsDetails'] = $objProduct->getAdsDetails(); 
        $multilpleproductcountry=$objProduct->getmulproductDetails($pid);
        if(empty($multilpleproductcountry))
        {
            $product_type="gloabal";
        }
        else
        {
	    $product_type= $multilpleproductcountry[0]['producttype'];
	    if($product_type == 'local'){
		
		$avalCountry[] = $multilpleproductcountry[0]['country_id'];
		
	    }else if($product_type == 'multiple'){
		
		foreach($multilpleproductcountry as $kc => $vc){
		    $avalCountry[$kc] = $vc['country_id'];
		}
		
	    }else{
		$avalCountry[] = 0;
	    }
	    $this->avalCountry = $avalCountry;
        }
        //pre($multilpleproductcountry);

        //if($product_type)
        $this->arrData['arrWishListOfCustomer'] = $objHome->getAllWishListOfCustomer();
        if ($pid > 0) {
            $objProduct->updateReview($pid,$_SESSION['sessUserInfo']['id']);
            $this->varproductViewUpdate = $objProduct->getproductViewUpdate($pid);
            $this->arrproductDetails = $objProduct->getProductDetails($pid);            
            $this->arrproductImages = $objProduct->getProductImages($pid);
            $this->arrproductReview = $objProduct->getUserReview($pid);
            $this->varproductWishlist = $objProduct->myWishlistDetails($pid);
            $this->arrRecentBuyer = $objProduct->getRecentBuyer($pid);
            $this->arrCustomerBoughtProduct = $objProduct->getCustomerBoughtProduct($pid);
            //$this->arrUserRecommend=$objProduct->getUserRecommend($pid);            
            $this->varBreadcrumbs = $objProduct->getBreadcrumb($this->arrproductDetails[0]['CategoryHierarchy']);
            //pre($this->varBreadcrumbs);
        }
        //pre($this->arrproductDetails);
        $this->arrData['arrCartDetails'] = $objShoppingCart->myCartDetails($this->arrproductDetails[0]['fkPackageId']);
        $this->arrwholesalerDetails = $objProduct->getWholesalerDetails($this->arrproductDetails[0]['fkWholesalerID']>0?$this->arrproductDetails[0]['fkWholesalerID']:$_SESSION['sessUserInfo']['id']);
       
        
        if (isset($this->arrproductDetails[0]['fkPackageId']) && $this->arrproductDetails[0]['fkPackageId'] != "") {
//echo '<pre>'; print_r ($this->arrproductDetails[0]['fkPackageId']); die;
		//pre($this->arrproductDetails);
            $this->arrProductPackageDetails = $objProduct->getProductPackageDetails($this->arrproductDetails[0]['fkPackageId']);
        }
        if (!empty($_SESSION['MyCompare']['Product'])) {
            $this->arrData['arrCompDetails'] = $objCategory->myCompareDetails();
            $this->arrData['arrCompareDetails'] = $this->arrData['arrCompDetails']['product_details'];
        }
        $this->arrData['arrRecommendedDetails'] = $objCategory->myRecommendedDetails();

        if (isset($_REQUEST['frmReviewAdd']) && $_REQUEST['frmReviewAdd'] == 'add') {
            $objProduct->userReviewAdd($_REQUEST);
            header("location:" . $objCore->getUrl('product.php', array('id' => $pid, 'name' => $_REQUEST['name'], 'refNo' => $_REQUEST['refNo'])));
        }

        if ($pid > 0) {

            $this->arrRatingDetails = $objProduct->myRatingDetails($pid);
        }

        if (isset($_SESSION['sessUserInfo']['id']) && $_SESSION['sessUserInfo']['type'] == "customer") {
            $this->arrCustomerDetails = $objProduct->CustomerDetails($_SESSION['sessUserInfo']['id']);
        }

        if (isset($_POST['frmHidenSend']) && $_POST['frmHidenSend'] == 'Send') {   // Editing images record
            $proUrl = $objProduct->sendRecommendedToFriend($_POST);
            header("location: " . $proUrl);
            die;
        }
        if (isset($_SESSION['sessUserInfo']['id']) && isset($pid)) {
            $this->arrCustomerRatingDetails = $objProduct->myRatingDetailsByCustomer($pid, $_SESSION['sessUserInfo']['id']);
        }
    }

}

$objPage = new ProductCtrl();
$a = $objPage->pageLoad();
//echo '<pre>';

//pre($objProduct->arrproductDetails);
?>
