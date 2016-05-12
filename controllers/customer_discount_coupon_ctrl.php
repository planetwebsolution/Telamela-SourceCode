<?php
require_once CLASSES_PATH . 'class_customer_user_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';

class customerDiscountCouponsCtrl extends Paging {
    /*
     * Variable declaration begins
     *
     * holds the heading of the page
     */

    public $varHeading = '';

    public function __construct() {
        if ($_SESSION['sessUserInfo']['id'] && $_SESSION['sessUserInfo']['type'] == 'customer') {
            
        } else {
            header('location:' . SITE_ROOT_URL);
            die;
        }
        
        $objCore = new Core();
        
        $objCore->setCurrencyPrice();
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
        $cid = $_SESSION['sessUserInfo']['id'];        
        $this->arrCouponNum = $objCustomer->getCouponNum($cid);
        $this->paging($this->arrCouponNum);
        $this->arrCouponList = $objCustomer->getCouponlist($cid, $this->varLimit);

        // end of page load
    }

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
        $this->NumberofRows = $arrRecords;
        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
    }

}

$objPage = new customerDiscountCouponsCtrl();
$objPage->pageLoad();

//print_r($objPage->arrRow[0]);
?>
