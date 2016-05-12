<?php

require_once CLASSES_PATH . 'class_customer_user_bll.php';
require_once CLASSES_PATH . 'class_wholesaler_bll.php';
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
        $objCustomer = new Customer();
        $objWholesaler = new Wholesaler();
        if (isset($_REQUEST['uid'])) {
            $this->arrUserList = $objCustomer->checkCustomerForgotPWCode($_REQUEST);
        } else if (isset($_REQUEST['wid'])) {
            $this->arrUserList = $objWholesaler->checkWholesalerForgotPWCode($_REQUEST);
        }
        if ($this->arrUserList > 0) {
            
        } else {
            header('location:' . SITE_ROOT_URL);
            die;
        }
    }

    public function customerResetPassword() {
        $objCore = new Core();
        $objCustomer = new Customer();
        $objWholesaler = new Wholesaler();
        if (isset($_POST['frmHidenCustomerPasswordEdit']) && $_POST['frmHidenCustomerPasswordEdit'] == 'Update' && isset($_REQUEST['uid'])) {   // Editing images record
            if ($_POST['frmNewCustomerPassword'] == $_POST['frmConfirmNewCustomerPassword']) {
                $objCustomer->changeResetPassword($_REQUEST);
                $objCore->setSuccessMsg('<span>' . FRONT_END_PASSWORD_SUCC_CHANGE . '</span>');
                header('location:index.php');
                die;
            }
        } else if (isset($_POST['frmHidenCustomerPasswordEdit']) && $_POST['frmHidenCustomerPasswordEdit'] == 'Update' && isset($_REQUEST['wid'])) {   // Editing images record
            if ($_POST['frmNewCustomerPassword'] == $_POST['frmConfirmNewCustomerPassword']) {
                $objWholesaler->changeWholesalerResetPassword($_REQUEST);
                $objCore->setSuccessMsg('<span>' . FRONT_END_PASSWORD_SUCC_CHANGE . '</span>');
                header('location:index.php');
                die;
            }
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

        // end of page load
    }

}

$objPage = new customerAccountCtrl();
$objPage->pageLoad();
$objPage->customerResetPassword();

//print_r($objPage->arrRow[0]);
?>
