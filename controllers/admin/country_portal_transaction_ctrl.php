<?php

require_once CLASSES_ADMIN_PATH . 'class_country_portal_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

class CountryPortalCtrl extends Paging {
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
        $objCountryPortal = new CountryPortal();
        $objCore=new Core();
        global $objGeneral;

        //$varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'pkWholesalerID');
        if($_SESSION['sessUserType']=='user-admin')
        {
        	$varPortalFilter = $objGeneral->tranactioncountryPortalFilter($_SESSION['sessUser']);
        }
        else {
        	$varPortalFilter='';
        }
        
        $dbCurrentDate = date(DATE_FORMAT_DB);
        $varCurrentPeriodFilter = $objGeneral->getCurrentCommissionPeriodFilter($dbCurrentDate, '');
        

        $this->varPageLimit = ($_SESSION['sessAdminPageLimit'] < 1) ? ADMIN_RECORD_LIMIT : $_SESSION['sessAdminPageLimit'];
        $varPage = isset($_GET['page']) ? $_GET['page'] : '';
        
       // pre($_SESSION);
        
        if($_SESSION['sessAdminRoleName'] == 'Country Portal'){
            $varWhereClause = " pay.ToUserID='".$_SESSION['sessUser']."' AND  pay.ToUserType = 'user-admin' ";            
        }else{
            $varWhereClause = "  pay.ToUserType = 'user-admin'  ";
        }
        
        

       if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') {
            $arrSearchParameter = $_GET;

            $varpkOrderID = $arrSearchParameter['frmOrderId'];
            $varTransactionDateAddedFrom = $arrSearchParameter['frmDateFrom'];
            $varTransactionDateAddedTo = $arrSearchParameter['frmDateTo'];
            $varPaymentMethod = $arrSearchParameter['frmpaymentMode'];
            $varTransactionID = $arrSearchParameter['frmTransactionId'];


            if ($varpkOrderID <> '') {
                $varWhereClause .= " AND fkOrderID = '" . $varpkOrderID . "'";
            }
            if (($varTransactionDateAddedFrom <> '' && $varTransactionDateAddedFrom <> '00-00-0000') && ($varTransactionDateAddedTo <> '' && $varTransactionDateAddedTo <> '00-00-0000')) {
                $varWhereClause .= " AND PaymentDate  BETWEEN '" . $objCore->defaultDateTime($varTransactionDateAddedFrom, DATE_FORMAT_DB) . "' AND '" . $objCore->defaultDateTime($varTransactionDateAddedTo, DATE_FORMAT_DB) . "'";
            }
            if ($varPaymentMethod <> '') {
                $varWhereClause .= " AND PaymentMode  = '" . $varPaymentMethod . "'";
            }
            if ($varTransactionID <> '') {
                $varWhereClause .= " AND pkAdminPaymentID = '" . $varTransactionID . "'";
            }
       }
           //echo $varWhrClause = $varWhereClause;die;
           $varWhrClause = $varWhereClause.$varPortalFilter;
       //$varWhrClause = $varWhereClause;
           
            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = count($objCountryPortal->transactionDetails($varWhrClause));
            $this->NumberofRows = $arrRecords;
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objCountryPortal->transactionDetails($varWhrClause, $this->varLimit);
            $this->varSortColumn = $objCountryPortal->getSortColumnTransaction($_REQUEST);
           
        
        
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
        $objCountryPortal = new CountryPortal();
        global $objGeneral;
    
        $dbCurrentDate = date(DATE_FORMAT_DB);

        $varArchivePeriodFilter = $objGeneral->getArchiveCommissionPeriodFilter($dbCurrentDate, '');

        if (isset($_GET['type']) && $_GET['type'] == 'archive' && $_GET['cid'] <> '') {
            
            $this->arrAdminRows = $objCountryPortal->getAdminDetails($_GET['cid']);
            $this->arrRows = $objCountryPortal->getCountryPortalArchives($_GET['cid']);
            $this->varSortColumn = $objCountryPortal->getSortColumnArchives($_REQUEST);
            
        } else if (isset($_GET['cid']) && $_GET['cid'] <> '') {
            $this->arrAdminRows = $objCountryPortal->getAdminDetails($_GET['cid']);
            $this->arrRows = $objCountryPortal->getWholesalersSalesList($_GET['cid']);
              $this->varSortColumn = $objCountryPortal->getSortColumnWholesaler($_REQUEST);
        } else {
            $arrPeriods = $objGeneral->getDefaultCommision();
            $arrPeriod = $objGeneral->getCommissionPeriod();
            $this->varPeriod = $arrPeriod[$arrPeriods['SalesPeriod']];

            $this->arrCountryList = $objCountryPortal->countryList();
            $this->getList();
        }
    }

// end of page load
}

$objPage = new CountryPortalCtrl();
$objPage->pageLoad();

//print_r($objPage->arrRow[0]);
?>
