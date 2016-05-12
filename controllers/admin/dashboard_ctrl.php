<?php

/**
 * cmsDashboardCtrl class controller
 *
 * This is the controller for add home main images.
 */
require_once CLASSES_ADMIN_PATH . 'class_dashboard_bll.php';

class dashboardCtrl {
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
        $objAdminLogin = new AdminLogin();
        //check admin session
        $objAdminLogin->isValidAdmin();
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
        $objDashboard = new Dashboard();

        global $objGeneral;
        $varPortalFilterPK = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'pkWholesalerID');
        $varPortalFilterFK = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs']);
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'fkFromUserID');


        //$arrRes = $objDashboard->getFestivalEvents();
        $this->arrData['SalesTotal'] = $objDashboard->salesTotal($varPortalFilterFK);
        $this->arrData['RecentlyOrderedItem'] = $objDashboard->recentlyOrderedItem($varPortalFilterFK);
        $this->arrData['RecentEnquiry'] = $objDashboard->RecentEnquiry();
        // $this->arrData['lastLogin'] = $objDashboard->lastLogin();
        $this->arrData['RecentWholesalerApplication'] = $objDashboard->recentWholesalerApplication($varPortalFilterPK);
        $this->arrData['RecentWholesalerSupport'] = $objDashboard->recentWholesalerSupport($varPortalFilter);

        $varwhr = ($_SESSION['sessAdminCountry']>0)?" AND country_id='" . $_SESSION['sessAdminCountry']."'":"";
        $this->arrData['arrCountry'] = $objGeneral->getCountry("status='1'".$varwhr);
        $this->arrData['RecentProductReview'] = $objDashboard->recentProductReview($varPortalFilterFK);
        $this->arrData['RecentCustomerSupport'] = $objDashboard->recentCustomerSupport($varPortalFilter);
        $this->arrData['CustomerFeedbackCount'] = $objDashboard->customerFeedbackCount($varPortalFilterFK);
        $this->arrData['WholesalerFeedbackKpiList'] = $objDashboard->wholesalerFeedbackKpiList($varPortalFilterFK);
        

        //$this->arrData['RecentlyAddedWholesaler'] = $objDashboard->recentlyAddedWholesaler($varPortalFilterPK);
        //pre($this->arrData['RecentWholesalerApplication']);
    }

// end of page load
}

$objPage = new dashboardCtrl();
$objPage->pageLoad();
?>
