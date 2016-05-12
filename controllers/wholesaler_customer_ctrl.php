<?php

require_once CLASSES_PATH . 'class_wholesaler_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

class WholesalerCustomerViewCtrl extends Paging {
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
        $objCore = new Core();
        $objWholesaler = new Wholesaler();
        
        
        $wid = $objCore->getFormatValue($_REQUEST['wid']);
        
        
        if (isset($wid) && $wid != "") {
            $this->arrwholesalerFeedback = $objWholesaler->wholesalerFeedback($wid);
            $this->arrWholeSalerDetails = $objWholesaler->WholesalerDetails($wid);
            $this->regionName = $objWholesaler->regionName($this->arrWholeSalerDetails['CompanyRegion']);
            $this->countryDetails = $objWholesaler->countryById($this->arrWholeSalerDetails['CompanyCountry']);
        }
      
        if (isset($_POST['submit']) && $_POST['submit'] == 'Send') {
      
            $objWholesaler->sendEnquiry($_POST);
            
            $objCore->setSuccessMsg(FRONT_USER_ENQUIRY_SUCCUSS_MSG);
            
            header("location:".$objCore->getUrl('wholesaler_profile_customer_view.php', array('action' => 'view', 'wid' => $wid)));
            die;
        }
    }

// end of page load
}

$objPage = new WholesalerCustomerViewCtrl();
$objPage->pageLoad();
?>
