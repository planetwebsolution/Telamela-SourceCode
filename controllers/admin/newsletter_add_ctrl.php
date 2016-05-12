<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_newsletter_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';

class newsletterAddCtrl extends Paging {
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
        $objAdminLogin = new AdminLogin();
        //check admin session
        $objAdminLogin->isValidAdmin();
        //************ Get Admin Email here
    }

    private function getList() {
        $objPaging = new Paging();
        $objNewsLetter = new NewsLetter();
        global $objGeneral;
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'pkWholesalerID');

        if ($_SESSION['sessAdminPageLimit'] == '' || $_SESSION['sessAdminPageLimit'] < 1) {
            $this->varPageLimit = ADMIN_RECORD_LIMIT;
        } else {
            $this->varPageLimit = $_SESSION['sessAdminPageLimit'];
        }

        if (isset($_GET['page'])) {
            $varPage = $_GET['page'];
        } else {
            $varPage = '';
        }


        $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
        $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
        $arrCustomerRecords = $objNewsLetter->recipientCustomerList($varWhr = '', $limit = '');
        $this->NumberofRows = count($arrCustomerRecords);
        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
        $this->arrCustomerRows = $objNewsLetter->recipientCustomerList($varWhr = '', $this->varLimit);

        //Wholesaler
        
        $varWhr = $varPortalFilter;
        
        $arrWholesalerRecords = $objNewsLetter->recipientWholesalerList($varWhr);
        $this->NumberofRows2 = count($arrWholesalerRecords);
        $this->varNumberPages2 = $objPaging->calculateNumberofPages($this->NumberofRows2, $this->varPageLimit);
        $this->arrWholesalerRows = $objNewsLetter->recipientWholesalerList($varWhr, $this->varLimit);

        //echo '<pre>';print_r($this->arrRows);die;
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
        $objNewsLetter = new NewsLetter();

        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'add' && $_GET['type'] == 'add') {
            $this->arrResult = $objNewsLetter->saveNewsLetter($_POST);
            header('location:newsletter_manage_uil.php');
            die;
        } else {
            $this->getList();
        }
    }

// end of page load
}

$objPage = new newsletterAddCtrl();
$objPage->pageLoad();
?>
