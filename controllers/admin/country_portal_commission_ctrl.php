<?php

require_once CLASSES_ADMIN_PATH . 'class_country_portal_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

class CountryPortalCommissionCtrl extends Paging {
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
        $objCore = new Core();
        $objPaging = new Paging();
        $objCountryPortal = new CountryPortal();
        global $objGeneral;
        

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

        $varWhereClause = " FromUserType = 'user-admin' AND ToUserType = 'super-admin' ";

        if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') {
            $arrSearchParameter = $_GET;

            $varpkInvoiceID = $arrSearchParameter['frmpkInvoiceID'];
            $varInvoiceDateAddedFrom = $arrSearchParameter['frmInvoiceDateAddedFrom'];
            $varInvoiceDateAddedTo = $arrSearchParameter['frmInvoiceDateAddedTo'];
            $varCompanyName = $arrSearchParameter['frmCompanyName'];
            $varCommission = $arrSearchParameter['frmCommission'];
            $varTransactionStatus = $arrSearchParameter['frmTransactionStatus'];


            if ($varpkInvoiceID <> '') {
                $varWhereClause .= " AND i.pkInvoiceID = '" . $varpkInvoiceID . "'";
            }
            if (($varInvoiceDateAddedFrom <> '' && $varInvoiceDateAddedFrom <> '00-00-0000') && ($varInvoiceDateAddedTo <> '' && $varInvoiceDateAddedTo <> '00-00-0000')) {
                $varWhereClause .= " AND i.InvoiceDateAdded BETWEEN '" . $objCore->defaultDateTime($varInvoiceDateAddedFrom, DATE_FORMAT_DB) . "' AND '" . $objCore->defaultDateTime($varInvoiceDateAddedTo, DATE_FORMAT_DB) . "'";
            }
            if ($varfkOrderID <> '') {
                $varWhereClause .= " AND i.fkOrderID = '" . $varfkOrderID . "'";
            }
            if ($varfkSubOrderID <> '') {
                $varWhereClause .= " AND i.fkSubOrderID = '" . $varfkSubOrderID . "'";
            }
            if ($varCompanyName <> '') {
                $varWhereClause .= " AND AdminTitle LIKE '%" . addslashes($varCompanyName) . "%'";
            }
            if ($varCommission <> '') {
                $varWhereClause .= " AND Commission LIKE '%" . $varCommission . "%'";
            }
            if ($varCommission <> '') {
                $varWhereClause .= " AND Commission LIKE '%" . $varCommission . "%'";
            }
            if ($varTransactionStatus <> '') {
            	if($varTransactionStatus == TRANSACTION_DAYS_ALERT.' Days Pending')
                	$varWhereClause .= " AND datediff(now() , `InvoiceDateAdded`) > '".TRANSACTION_DAYS_ALERT."'";
                else
                	$varWhereClause .= " AND TransactionStatus = '" . $varTransactionStatus . "'";
            }
           
        }
        //echo $varWhereClause;
        
        $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
        $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
        $arrRecords = $objCountryPortal->countryPortalCommissionCount($varWhereClause);
        $this->NumberofRows = $arrRecords;
        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
        $this->arrRows = $objCountryPortal->countryPortalCommissionList($varWhereClause, $this->varLimit);
        $this->varSortColumn = $objCountryPortal->getSortColumnCommission($_REQUEST);
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
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'fkWholesalerID');

        //  $this->arrShippingList = $objCountryPortal->shippingGatewayList();
        $this->arrCountryList = $objCountryPortal->countryList();
        $this->getList();
        //$this->CountryPortal = $objCountryPortal->adminUserList();
    }

// end of page load
}

$objPage = new CountryPortalCommissionCtrl();
$objPage->pageLoad();

//print_r($objPage->arrRow[0]);
?>
