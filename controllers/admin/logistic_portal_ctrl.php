<?php

require_once CLASSES_ADMIN_PATH . 'class_country_portal_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_logistic_portal_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_adminuser_bll.php';

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
//       pre($_POST);
        //$objCore = new Core();
        //echo $objCore->setSuccessMsg();
        $objAdminLogin = new AdminLogin();
        //check admin session
        $objAdminLogin->isValidAdmin();
        
        $objUser = new AdminUser();
        $objAdminLogin = new AdminLogin();
        //check session
       
        //************ Get Admin Email here
    }

    private function getList() {
//    	pre($_SESSION);
        $objPaging = new Paging();
        $objCountryPortal = new CountryPortal();
        $objlogisticPortal = new logistic();
        
        global $objGeneral;

        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'pkWholesalerID');

        $dbCurrentDate = date(DATE_FORMAT_DB);
        $varCurrentPeriodFilter = $objGeneral->getCurrentCommissionPeriodFilter($dbCurrentDate, '');


        $this->varPageLimit = ($_SESSION['sessAdminPageLimit'] < 1) ? ADMIN_RECORD_LIMIT : $_SESSION['sessAdminPageLimit'];
        $varPage = isset($_GET['page']) ? $_GET['page'] : '';
        
        if ($_SESSION['sessUserType'] == 'user-admin') {
        	$varWhereClause .= "  logisticportal = '" . $_SESSION['sessAdminCountry'] . "'";
        }

       



        //$varWhereClause = "  AdminType= 'user-admin'  ";
//         if ($_SESSION['sessUserType'] == 'user-admin') {
//             $varWhereClause .= " AND AdminCountry = '" . $_SESSION['sessAdminCountry'] . "'";
//         }

        if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') {
            $arrSearchParameter = $_GET;
            $varName = $arrSearchParameter['frmTitle'];
            $varStatus = $arrSearchParameter['frmStatus'];
            if(!empty($varStatus))
            {
            if($varStatus=='Active')
            {
            	$varStatus=1;
            }
            else 
            {
            	$varStatus='0';
            }
            }
            $varCountry = $arrSearchParameter['CountryPortalID'];
            
            
            $varWhereClause='1=1';
            if ($_SESSION['sessUserType'] == 'user-admin') {
            	$varWhereClause .= "  AND logisticportal = '" . $_SESSION['sessUser'] . "'";
            }
            if ($varName <> '') {
               // $varWhereClause .= " AND logisticTitle LIKE '%" . addslashes($varName) . "%'";
                $varWhereClause .= " AND logisticTitle LIKE '%" . addslashes($varName) . "%'";
            }
            if ($varCountry > 0) {
                $varWhereClause .= " AND logisticportal = '" . $varCountry . "'";
            }

            if ($varStatus <> '') {
                $varWhereClause .= " AND logisticStatus = '" . $varStatus . "'";
            }
        }
//        pre($varWhereClause);
       // $varWhereClause='';
        //$varWhereClause='ORDER BY logisticportalid DESC';
        $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
        $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
        //$arrRecords = $objCountryPortal->CountryPortalCount($varWhereClause);
        $arrRecords = $objlogisticPortal->logicalPortalCount($varWhereClause);
        $this->NumberofRows = $arrRecords;
       
        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
        //$this->arrRows = $objCountryPortal->CountryPortalList($varWhereClause, $this->varLimit, $varCurrentPeriodFilter);
        $this->arrRows = $objlogisticPortal->logicalPortalList($varWhereClause, $this->varLimit, $varCurrentPeriodFilter);
        //$this->varSortColumn = $objCountryPortal->getSortColumnKPI($_REQUEST);
        //pre("here");
//       pre($this->arrRows);
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
      //  pre($_POST);
        $objCore = new Core();
        $objCountryPortal = new CountryPortal();
        $objlogisticPortal = new logistic();
        global $objGeneral;

        $dbCurrentDate = date(DATE_FORMAT_DB);

       // $varArchivePeriodFilter = $objGeneral->getArchiveCommissionPeriodFilter($dbCurrentDate, '');
//        pre($_GET);
//         if (isset($_GET['type']) && $_GET['type'] == 'archive' && $_GET['cid'] <> '') {
//         	//pre("here");

//             $this->arrAdminRows = $objCountryPortal->getAdminDetails($_GET['cid']);
//             $this->arrRows = $objCountryPortal->getCountryPortalArchives($_GET['cid']);
//             $this->varSortColumn = $objCountryPortal->getSortColumnArchives($_REQUEST);
//         } else if (isset($_GET['cid']) && $_GET['cid'] <> '') {
//         	//pre("hrtere");
        	 
//             $this->arrAdminRows = $objCountryPortal->getAdminDetails($_GET['cid']);
//             $this->arrRows = $objCountryPortal->getWholesalersSalesList($_GET['cid']);
//             $this->varSortColumn = $objCountryPortal->getSortColumnWholesaler($_REQUEST);
//         } else {
         // pre('fgfsdfsd');
            $arrPeriods = $objGeneral->getDefaultCommision();
            $arrPeriod = $objGeneral->getCommissionPeriod();
            $this->varPeriod = $arrPeriod[$arrPeriods['SalesPeriod']];

            $this->arrCountryList = $objCountryPortal->countryList();
            $this->getList();
        //}
    }

// end of page load
}

$objPage = new CountryPortalCtrl();
$objPage->pageLoad();

//print_r($objPage);die;
?>