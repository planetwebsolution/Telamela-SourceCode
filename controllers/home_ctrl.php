<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_PATH . 'class_home_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';

class HomeCtrl extends Paging {
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
        $objCore->setDefaultCurrency();
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
     * Use Instruction : $objPage->pageLoad();
     *
     * @access public
     *
     * @return void
     */
    public function pageLoad() {
        $objCore = new Core();
        $objHome = new Home();
        global $objGeneral;
        global $objPage2;


        $arrDelaySetting = $objGeneral->getSetting('HomeBannerDelayTime');
//        $arrDelaySetting = $objGeneral->getHomeBanners('HomeBannerDelayTime');
//        pre($arrDelaySetting);
        $varDelayTime = (int) $arrDelaySetting['HomeBannerDelayTime']['SettingValue'];
        
        $varDelayTime = ($varDelayTime > 0) ? $varDelayTime * 1000 : '4000';
//        pre($varDelayTime);
        $this->arrData['arrHomeBanner']['Setting']['delayTime'] = $varDelayTime;
        $this->arrData['arrHomeBanner']['Contents'] = $objHome->getHomeBanners();
        
//        echo '<pre>';
//        print_r($this->arrData['arrHomeBanner']['Contents']);
//        echo '</pre>';
//        die; 

        $this->arrData['arrTodayOfferProduct'] = $objHome->getTodayOfferProduct();
        //pre($this->arrData['arrTodayOfferProduct']);
        $todayOfferProduct = $this->arrData['arrTodayOfferProduct']['offer_details']['0']['fkProductId'];

        $this->arrData['topSellingProducts'] = $objHome->getTopSellingProducts($todayOfferProduct);
        
        //pre($this->arrData['topSellingProducts']);
        //$this->arrData['arrFeatureProducts'] = $objHome->featureProducts($todayOfferProduct);
        $this->arrData['arrRecentlyViewedPoducts'] = $objHome->RecentlyViewedProducts($todayOfferProduct);
        //pre($this->arrData['arrRecentlyViewedPoducts']);
        //pre($objPage2->arrData['arrCategoryListing']);
        $this->arrData['arrCategoryLatestPoducts'] = $objHome->categoryLatestPoducts($todayOfferProduct, $objPage2->arrData['arrCategoryListing']);

        //$this->arrData['arrAdsDetails'] = $objHome->getAdsDetails();


        $this->arrData['topRatedProducts'] = $objHome->getTopRatedProds($todayOfferProduct);
        $this->arrData['ads'] = $objHome->getAds();

        $this->arrData['arrSpecialProductPrice'] = $objGeneral->getAllSpecialProductPrice();
        //pre($this->arrData['arrSpecialProductPrice']);
        $this->arrData['arrWholesalerDetails'] = $objHome->getAllWholesalerDetails();
        
        $this->arrData['arrHotDeals'] = $objHome->getAllHotDeals($objPage2->arrData['arrCategoryListing']);
        
        $this->arrData['arrWishListOfCustomer'] = $objHome->getAllWishListOfCustomer();
        
        //pre($this->arrData['arrHotDeals']);
    }

}

$objPage = new HomeCtrl();
$objPage->pageLoad();

?>