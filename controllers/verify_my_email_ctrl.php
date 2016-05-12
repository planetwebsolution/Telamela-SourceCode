<?php

require_once CLASSES_PATH . 'class_customer_user_bll.php';
require_once CLASSES_PATH . 'class_wholesaler_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

class VerifyMyEmailCtrl {
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
        if(isset($_REQUEST['ref'])){            
            $varRef = $_REQUEST['ref'];
        }else{
            $varRef = 'index.php';
        }
        
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == md5('customer') && $_REQUEST['vcode'] <> '') {
            
            $varSt = $objCustomer->customerEmailVerification($_REQUEST);
            header('location:'.SITE_ROOT_URL.'verify_my_email.php?msg='.$varSt.'&ref='.$varRef);            
            
        } else if (isset($_REQUEST['action']) && $_REQUEST['action'] == md5('wholesaler') && $_REQUEST['vcode'] <> '') {
            $varSt = $objWholesaler->wholesalerEmailVerification($_REQUEST);
            header('location:'.SITE_ROOT_URL.'verify_my_email.php?msg='.$varSt.'&ref='.$varRef);
        } else {
            //$objCore->setErrorMsg(FRON_END_USER_LOGIN_ERROR1);
            $objCore->setSuccessMsg(FRON_EMAIL_VERIFICATION_SUCCESS);
        }
    }

    // end of page load
}

$objPage = new VerifyMyEmailCtrl();
$objPage->pageLoad();
?>