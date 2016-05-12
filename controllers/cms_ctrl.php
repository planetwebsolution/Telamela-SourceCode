<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_PATH . 'class_cms_bll.php';



class CmsCtrl {
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
         $objCms = new Cms();
        $this->arrCmsDetails = $objCms->CmsDetails($_REQUEST['id']);
       
    }

}

$objPage = new CmsCtrl();
$objPage->pageLoad();
?>
