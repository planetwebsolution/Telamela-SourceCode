<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_newsletter_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';

class newsletterCtrl extends Paging {
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
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'CreatedID');
        
        
        $varAdmin="";
        if ($_SESSION['sessAdminCountry'] > 0) {
            $varAdmin = "AND CreatedID = '" . $_SESSION['sessUser'] . "'";
        }


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
        $varWhrClause = "";
        if (isset($_REQUEST['frmSearch']) && $_REQUEST['frmSearch'] == 'Search') {
            $arrSearchParameter = $_GET;
            $frmStatus = $arrSearchParameter['frmStatus'];
            $frmTitle = $arrSearchParameter['frmTitle'];
            $frmCreatedBy = $arrSearchParameter['frmCreatedBy'];


            //pre($_REQUEST);
            if ($frmTitle <> '') {
                $varWhrClause .= " AND Title like '%" . addslashes($frmTitle) . "%'";
            }
            if ($frmStatus <> '') {
                $varWhrClause .= " AND DeliveryStatus = '" . $frmStatus . "'";
            }
            if ($frmCreatedBy <> '') {
                $varWhrClause .= " AND CreatedBy like '%" . addslashes($frmCreatedBy) . "%'";
            }

            $varWhrClause = $varWhrClause;

            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = $objNewsLetter->newsLetterList($varWhrClause, $varPortalFilter,$varAdmin);
            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objNewsLetter->newsLetterList($varWhrClause, $varPortalFilter,$varAdmin, $this->varLimit);
            $this->varSortColumn = $objNewsLetter->getSortColumn($_REQUEST);
            //echo '<pre>';print_r($this->arrRows);die;
        } else {
            $varWhrClause = $varWhrClause;
            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = $objNewsLetter->newsLetterList($varWhrClause, $varPortalFilter,$varAdmin);
            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objNewsLetter->newsLetterList($varWhrClause, $varPortalFilter,$varAdmin, $this->varLimit);
            $this->varSortColumn = $objNewsLetter->getSortColumn($_REQUEST);
            //echo '<pre>';print_r($this->arrRows);die;
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
        $objNewsLetter = new NewsLetter();

        if ($_GET['type'] == 'view' && $_GET['id'] <> '') {
            $this->arrRow = $objNewsLetter->getNewsletterList($_REQUEST['id']);
//            pre($this->arrRow);
        } else {
            $this->getList();
        }
    }

// end of page load
}

$objPage = new newsletterCtrl();
$objPage->pageLoad();
//pre($objPage);
?>
