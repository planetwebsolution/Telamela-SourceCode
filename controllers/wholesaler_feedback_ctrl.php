<?php

require_once CLASSES_PATH . 'class_wholesaler_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';

class WholesalerFeedbackCtrl extends Paging {
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
        if ($_SESSION['sessUserInfo']['id'] && $_SESSION['sessUserInfo']['type'] == 'wholesaler') {
            
        } else {
            header('location:' . SITE_ROOT_URL);
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
        global $objGeneral;
        $objCore = new Core();        
        $objWholesaler = new Wholesaler();        
        $wid = $_SESSION['sessUserInfo']['id'];
        
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'viewFeedback' && $_REQUEST['feedbackID'] != '') {
            $objWholesaler->getFeedbackDetails($_REQUEST['feedbackID']);
        } else {
            $this->kpi = $objGeneral->wholesalerKpi($wid);
            $limit = " 0 , ".WHOLESALER_WARNING_LIMIT." ";
            $this->arrWholesalerWarnings = $objWholesaler->wholesalerWarnings($wid,$limit);
            
            $this->arrFeedbacks = $objWholesaler->getWholesalerProductFeedbacksCount($wid);
            $this->paging($this->arrFeedbacks);
            $this->arrFeedbacks = $objWholesaler->getWholesalerProductFeedbacks($wid, $this->varLimit);
        }
    }

// end of page load

    function paging($arrRecords) {
        $objPaging = new Paging();
        $this->varPageLimit = LIST_VIEW_RECORD_LIMIT;
        if (isset($_GET['page'])) {
            $varPage = $_GET['page'];
        } else {
            $varPage = '';
        }
        $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
        $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
        $this->NumberofRows = count($arrRecords);
        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
    }

}

$objPage = new WholesalerFeedbackCtrl();
$objPage->pageLoad();
?>
