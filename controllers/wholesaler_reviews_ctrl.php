<?php

require_once CLASSES_PATH . 'class_wholesaler_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';

class WholesalerReviewsCtrl extends Paging {
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
        $objCore = new Core();
        $objWholesaler = new Wholesaler();
        $wid = $_SESSION['sessUserInfo']['id'];

        if (isset($_REQUEST['place']) && $_REQUEST['place'] == 'view' && $_REQUEST['pid'] != '') {
            $pid = $objCore->getFormatValue($_REQUEST['pid']);
            $objWholesaler->reviewsDone($_REQUEST['rid'],$pid);
            $this->arrReviewDetail = $objWholesaler->getWholesalerProductReviewsDetail($wid, $pid);
            $this->paging($this->arrReviewDetail);
            $this->arrReviewDetail = $objWholesaler->getWholesalerProductReviewsDetail($wid, $pid, $this->varLimit);
        } else {
            $this->arrReviews = $objWholesaler->getWholesalerProductReviews($wid);
            $this->paging($this->arrReviews);
            $this->arrReviews = $objWholesaler->getWholesalerProductReviews($wid, $this->varLimit);
            //pre($this->arrReviews);
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

$objPage = new WholesalerReviewsCtrl();
$objPage->pageLoad();
?>
