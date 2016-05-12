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
        global $objGeneral;
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'pkWholesalerID');
        
        $dbCurrentDate = date(DATE_FORMAT_DB);
        $arrCurrentPeriodFilter = $objGeneral->getCurrentCommissionPeriodFilter($dbCurrentDate, '');
      
        $this->varPageLimit = ($_SESSION['sessAdminPageLimit'] < 1) ? ADMIN_RECORD_LIMIT : $_SESSION['sessAdminPageLimit'];
        $varPage = isset($_GET['page']) ? $_GET['page'] : '';

        $varWhereClause = "AdminType= 'user-admin' ";

        if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') {
            $arrSearchParameter = $_GET;
            $varName = $arrSearchParameter['frmName'];            
            $varStatus = $arrSearchParameter['frmStatus'];
            $varCountry = $arrSearchParameter['frmCountry'];


            if ($varName <> '') {
                $varWhereClause .= " AND AdminTitle LIKE '%" . addslashes($varName) . "%'";
            }            
            if ($varCountry > 0) {
                $varWhereClause .= " AND AdminCountry = '" . $varCountry . "'";
            }
            
            if ($varStatus<>'') {
                $varWhereClause .= " AND AdminStatus = '" . $varStatus . "'";
            }
        }

        $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
        $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
        $arrRecords = $objCountryPortal->CountryPortalCount($varWhereClause);
        $this->NumberofRows = $arrRecords;
        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
        $this->arrRows = $objCountryPortal->CountryPortalList($varWhereClause, $this->varLimit,$arrCurrentPeriodFilter);
        $this->varSortColumn = $objCountryPortal->getSortColumnKPI($_REQUEST);
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
        $this->arrCountryList = $objCountryPortal->countryList();
        $this->getList();
    }

// end of page load
}

$objPage = new CountryPortalCtrl();
$objPage->pageLoad();

//print_r($objPage->arrRow[0]);
?>
