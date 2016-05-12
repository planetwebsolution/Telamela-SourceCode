<?php

require_once CLASSES_PATH . 'class_customer_user_bll.php';

class ShippingBillingCtrl {
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
        if ($_SESSION['sessUserInfo']['id'] && $_SESSION['sessUserInfo']['type'] == 'customer') {
            
        } else {
            header('location:' . SITE_ROOT_URL);
            die;
        }

        /*
         * Checking valid login session
         */
        //$objCore = new Core();
        //echo $objCore->setSuccessMsg();
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
        $objCustomer = new Customer();
//        pre($_REQUEST);
        $this->arrCountryList = $objCustomer->countryList();
        $this->arrCustomerDeatails = $objCustomer->CustomerDetails($_SESSION['sessUserInfo']['id']);
        //pre($this->arrCustomerDeatails);
        
        if (isset($_POST['frmBillingShippingAddress']) && $_POST['frmBillingShippingAddress'] == 'update') {
            // pre($_POST);
            $varUpdateStatus = $objCustomer->updateBillingShippingDetails($_POST);
            //$objCore->setSuccessMsg(FRONT_USER_UPDATE_SUCCUSS_MSG);
            header('location:shipping_charge.php');
            die;
        } else if (isset($_REQUEST['RunDeleteShippingID'])){
            //pre($_REQUEST);
            $DeleteRunID = $_REQUEST['RunDeleteShippingID'];
            $arrRunAdd = $objCustomer->DeleteAddressRun($DeleteRunID);
            //header('location:run_time_shipping_address.php');
            //die;
        } else if(isset($_POST['runTimeShippingAddress']) && $_POST['runTimeShippingAddress'] == 'update_runtime'){
            $varUpdateStatus = $objCustomer->updateRunTimeShippingDetails($_POST);
            header('location:run_time_shipping_address.php');
            die;
        } else if(isset($_POST['EditAdd']) && $_POST['EditAdd'] == 'EditAddress'){
            //$varUpdateStatus = $objCustomer->EditRunTimeShippingDetails($_POST);
            header('location:run_time_shipping_address.php');
            die;
        } else if(isset($_POST['EditDetailRunTime']) && $_POST['EditDetailRunTime'] == 'EditDetailRunTime'){
            //pre($_REQUEST);
            $varUpdateStatus = $objCustomer->EditRunTimeShippingDetails($_POST);
            header('location:run_time_shipping_address.php');
            die;
        }
        // end of page load
    }

}

$objPage = new ShippingBillingCtrl();
$objPage->pageLoad();

//print_r($objPage->arrRow[0]);
?>
