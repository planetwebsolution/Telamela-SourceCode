<?php

require_once CLASSES_PATH . 'class_wholesaler_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

class wholesalerAccountCtrl extends Paging {
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
        if (!$_SESSION['sessUserInfo']['id'] && $_SESSION['sessUserInfo']['type'] != 'wholesaler') {
            header('location:' . SITE_ROOT_URL);
        }
    }

    public function customerPasswordChange() {
        //echo "hii"; die;
        $objCore = new Core();
        $objCustomer = new Customer();
        if (isset($_POST['frmHidenCustomerPasswordEdit']) && $_POST['frmHidenCustomerPasswordEdit'] == 'Update') {   // Editing images record
            if ($_POST['frmNewCustomerPassword'] == $_POST['frmConfirmNewCustomerPassword']) {
                $objCore->setSuccessMsg(FRONT_END_PASSWORD_SUCC_CHANGE);
                $objCustomer->changeCustomerPassword($_POST);
                header('location:dashboard_customer_account.php');
                die;
            } else {

                $objCore->setErrorMsg(FRONT_END_INVALID_CURENT_PASSWORD);
                header('location:edit_my_password.php?type=edit');
                die;
            }
        } else if (isset($_POST['frmHidenCustomerPasswordEdit']) && $_POST['frmHidenCustomerPasswordEdit'] == 'Cancel') {
            $objCore->setSuccessMsg("Account update successfully.");
            header('location:dashboard_customer_account.php');
            die;
        }
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
        $objWholesaler = new Wholesaler();
       global $objGeneral;
       $current_country_id=$_SESSION['sessUserInfo']['countryid'];
      // pre($_SESSION);
       $current_country_portal = $objGeneral->getcurrentCountryPortal($current_country_id);
      
        $this->arrShippingList = $objWholesaler->shippingGatewayList($current_country_id);
        // pre($this->arrShippingList);
        $this->arrTemplateList = $objWholesaler->templateList();
        $this->arrsliderImagesList = $objWholesaler->wholesalerSliderList($_SESSION['sessUserInfo']['id']);
        $this->arrDocumentList = $objWholesaler->wholesalerDocumentList($_SESSION['sessUserInfo']['id']);
        $this->arrCountryList = $objWholesaler->countryList();        
        $this->arrZoneCountry = $objWholesaler->getZoneCountry();
        
        /* To show Wholesaler detail by Krishna Gupta 27-10-2015 starts */
        $this->arrwholesalerSoldItems = $objWholesaler->wholeSalerSoldItems($_SESSION['sessUserInfo']['id']);
        $this->arrwholesalerPositiveFeedback = $objWholesaler->wholeSalerPositiveFeedback($_SESSION['sessUserInfo']['id']);
        $this->arrwholesalerNegativeFeedback = $objWholesaler->wholeSalerNegativeFeedback($_SESSION['sessUserInfo']['id']);
        /* To show Wholesaler detail by Krishna Gupta 27-10-2015 ends */
        
        if ($_SESSION['sessUserInfo']['email'] != '' && $_SESSION['sessUserInfo']['id'] != "") {
            $this->arrWholesalerDeatails = $objWholesaler->WholesalerDetails($_SESSION['sessUserInfo']['id']);
            $limit = " 0 , ".WHOLESALER_WARNING_LIMIT." ";
            $this->arrWholesalerWarnings = $objWholesaler->wholesalerWarnings($_SESSION['sessUserInfo']['id'],$limit);
            
            $this->regionList = $objWholesaler->regionList($this->arrWholesalerDeatails['CompanyCountry']);            
            $this->kpi = $objGeneral->wholesalerKpi($_SESSION['sessUserInfo']['id']);
            
        } else {
            
        }
        
        if (isset($_POST['action']) && $_POST['action'] == 'viewFullWarning' && $_POST['warningId'] != '') {
            $objWholesaler->getFullWarning($_POST['warningId']);
            die;
        }
        
        if (isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'Update' && $_POST['pkWholesalerID']) {
            $varUpdateStatus = $objWholesaler->updateWholesaler($_POST);
            if ($varUpdateStatus > 0) {
                $objCore->setSuccessMsg(FRONT_USER_UPDATE_SUCCUSS_MSG);
                header('location:dashboard_wholesaler_account.php');
                die;
            } else {
                $objCore->setErrorMsg(FRONT_UPDATE_ERROR_MSG);
                return false;
            }
        }
        if (isset($_POST['frmHidenWholesalerPasswordEdit']) ) {
            if ($objWholesaler->customerPasswordChange($_POST)) {
                  header('location:dashboard_wholesaler_account.php');
                die;
            } else {
                
            }
        }
        // end of page load
    }

}

$objPage = new wholesalerAccountCtrl();
$objPage->pageLoad();

//print_r($objPage->arrRow[0]);
?>
