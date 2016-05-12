<?php

require_once CLASSES_PATH . 'class_customer_user_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

class CustomerCtrl extends Paging {
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
        /*if (isset($_SESSION['sessUserInfo']['id']) && $_SESSION['sessUserInfo']['type'] == 'customer') {
            header('location:' . SITE_ROOT_URL.'dashboard_customer_account.php');
            die;
        }*/
    }

    public function customerLogin() {
        $objCore = new Core();
        $objCustomer = new Customer();

        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'Sign in' && $_POST['frmUserType'] == '0') {
            $objCustomer->userLogin($_POST);
        } else {
            $objCore->setErrorMsg(FRON_END_USER_LOGIN_ERROR);
            header('location:index.php');
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
        $objCustomer = new Customer();
        $this->arrCountryList = $objCustomer->countryList();
        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'add') {   // Editing images record
            $varAddStatus = $objCustomer->addCustomer($_POST);

            if ($varAddStatus > 0) {
                header('location:thanks_message_customer.php');

                /*
                  $this->arrCustomerDetails = $objCustomer->CustomerDetails($varAddStatus);
                  //pre($this->arrCustomerDetails);
                  if ($this->arrCustomerDetails[0]['BusinessAddress'] == "Billing") {
                  $varCountryId = $this->arrCustomerDetails[0]['BillingCountry'];
                  } else {
                  $varCountryId = $this->arrCustomerDetails[0]['ShippingCountry'];
                  }

                  $this->arrCustomerZone = $objCustomer->countryById($varCountryId);
                  // pre($this->arrCustomerZone);
                  $_SESSION['sessUserInfo']['type'] = 'customer';
                  $_SESSION['sessUserInfo']['email'] = $this->arrCustomerDetails[0]['CustomerEmail'];
                  $_SESSION['sessUserInfo']['id'] = $varAddStatus;
                  $_SESSION['sessTimeZone'] = $this->arrCustomerZone[0]['time_zone'];
                  //pre($_SESSION);
                  if (isset($_POST['frmRef'])) {
                  header('location:billing_and_shipping_address.php');
                  } else {
                  $objCore->setSuccessMsg(FRONT_USER_ADD_SUCCUSS_MSG);
                  header('location:dashboard_customer_account.php');
                  }
                  die; */
            } else {
                $objCore->setErrorMsg(FRONT_USER_EMAIL_ALREADY_EXIST);
                return false;
            }
        }
    }

// end of page load
}

$objPage = new CustomerCtrl();
$objPage->pageLoad();
//$objPage->customerLogin();
//print_r($objPage->arrRow[0]);
?>
