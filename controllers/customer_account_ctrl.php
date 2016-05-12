<?php

require_once CLASSES_PATH . 'class_customer_user_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

class customerAccountCtrl {
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
    }

    public function customerPasswordChange() {
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
            $objCore->setSuccessMsg(UPDATE_SUCC);
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
        $objCustomer = new Customer();
        $this->arrCountryList = $objCustomer->countryList();
        $cid = $_SESSION['sessUserInfo']['id'];
        $this->arrCustomerDeatails = $objCustomer->CustomerDetails($_SESSION['sessUserInfo']['id']);


        if (isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'Update' && $_GET['type'] == 'edit') {

            $varUpdateStatus = $objCustomer->updateCustomer($cid,$_POST);
        }

        if (isset($_POST['referFriends']) && $_POST['referFriends'] == 'referFriends') {
            
            $objCustomer->sendReferalToFriends($_POST, $this->arrCustomerDeatails[0]);
            $objCore->setSuccessMsg(FRONT_USER_REFERAL_EMAIL_SEND_SUCCESS);
            header("location: " . $objCore->getUrl('dashboard_customer_account.php'));
            die;
        }
        
        if (isset($_POST['action']) && $_POST['action'] == 'ScreenName') {
            //pre($_POST);            
            echo $objCustomer->checkScreenName($cid,$_POST);
            die();
        }
        // end of page load
    }

}

$objPage = new customerAccountCtrl();
$objPage->pageLoad();
$objPage->customerPasswordChange();

//print_r($objPage->arrRow[0]);
?>
