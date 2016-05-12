<?php

require_once CLASSES_PATH . 'class_customer_user_bll.php';
require_once CLASSES_PATH . 'class_wholesaler_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

class CustomerWholesalerCtrl {
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
        //$objCore = new Core();
        //echo $objCore->setSuccessMsg();
        //$objAdminLogin = new AdminLogin();
        //check admin session
        //$objAdminLogin->isValidAdmin();
        //************ Get Admin Email here
    }

    public function pageLoad() {
        $objCore = new Core();
        $objCustomer = new Customer();
        $objWholesaler = new Wholesaler();
        // print_r($_POST['frmUserType']);die;      
        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'Sign in' && $_POST['frmUserType'] == 'customer') {
            $varSt = $objCustomer->userLogin($_POST);
            $objCore->setErrorMsg($varSt);
        } else if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'Sign in' && $_POST['frmUserType'] == 'wholesaler') {

            $objWholesaler->wholesalerLogin($_POST);
        } else if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'Send' && $_POST['frmUserType'] == 'customer') {
            $objCustomer->sendForgotPasswordEmail($_POST);
        } else if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'Send' && $_POST['frmUserType'] == 'wholesaler') {
            $objWholesaler->sendForgotPasswordEmailWholesaler($_POST);
        }
    }

    // end of page load
}

$objPage = new CustomerWholesalerCtrl();
$objPage->pageLoad();
//$objPage->customerLogin();
//print_r($objPage->arrRow[0]);
?>
