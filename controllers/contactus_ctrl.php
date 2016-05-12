<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_PATH . 'class_contactus_bll.php';
//require_once CLASSES_SYSTEM_PATH.'class_paging_bll.php';
require_once CLASSES_PATH.'class_email_template_bll.php';




class CountactUsCtrl {
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
         $objContactUs = new ContactUs();
         $objCore = new Core();
         $this->arrSupportList = $objContactUs->supportList();
         //pre($_POST);
        if(isset($_POST['frmHidenSend']) && $_POST['frmHidenSend'] == 'Send') 
        {
           //pre("gfdfasd"); 
         $objContactUs->sendContactUs($_POST);
         $objContactUs->submitEnquiryToDatabase($_POST);
         $objCore->setSuccessMsg(CONTACT_SUCCUSS_MSG);
         header('location: ' . SITE_ROOT_URL.'contact.php');
         die;
        }
    }

}

$objPage = new CountactUsCtrl();
$objPage->pageLoad();
?>
