<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_PATH . 'class_cms_bll.php';

class RewardsCtrl {
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
        $this->arrBanner = $objCms->getRewardBanner();        
    }

}

$objPage = new RewardsCtrl();
$objPage->pageLoad();
?>
