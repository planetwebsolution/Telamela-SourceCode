<?php

require_once CLASSES_ADMIN_PATH . 'class_wholesaler_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

class WholeSalerCtrl extends Paging
{
    /*
     * Variable declaration begins
     *
     * holds the heading of the page
     */

    public $varHeading = '';

    /*
     * constructor
     */

    public function __construct()
    {
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

    private function getList()
    {
        $objCore = new Core();
        $objPaging = new Paging();
        $objWholesaler = new Wholesaler();
        global $objGeneral;
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'fkWholesalerID');


        if ($_SESSION['sessAdminPageLimit'] == '' || $_SESSION['sessAdminPageLimit'] < 1)
        {
            $this->varPageLimit = ADMIN_RECORD_LIMIT;
        }
        else
        {
            $this->varPageLimit = $_SESSION['sessAdminPageLimit'];
        }

        if (isset($_GET['page']))
        {
            $varPage = $_GET['page'];
        }
        else
        {
            $varPage = '';
        }

        $varWhereClause = " FromUserType in('wholesaler') AND ToUserType in ('super-admin','user-admin') ";

        if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes')
        {
            $arrSearchParameter = $_GET;

            $varpkInvoiceID = $arrSearchParameter['frmpkInvoiceID'];
            $varInvoiceDateAddedFrom = mysql_real_escape_string(trim($arrSearchParameter['frmInvoiceDateAddedFrom']));
            $varInvoiceDateAddedTo = mysql_real_escape_string(trim($arrSearchParameter['frmInvoiceDateAddedTo']));
            $varfkOrderID = $arrSearchParameter['frmfkOrderID'];
            $varfkSubOrderID = $arrSearchParameter['frmfkSubOrderID'];
            $varCompanyName = $arrSearchParameter['frmCompanyName'];
            $varCommission = $arrSearchParameter['frmCommission'];
            $varTransactionStatus = $arrSearchParameter['frmTransactionStatus'];

            if ($varpkInvoiceID <> '')
            {
                $varWhereClause .= " AND i.pkInvoiceID = '" . $varpkInvoiceID . "'";
            }
            if (($varInvoiceDateAddedFrom <> '' && $varInvoiceDateAddedFrom <> '00-00-0000') && ($varInvoiceDateAddedTo <> '' && $varInvoiceDateAddedTo <> '00-00-0000'))
            {
                $varWhereClause .= " AND DATE_FORMAT(i.InvoiceDateAdded,'%Y-%m-%d') BETWEEN '" . $objCore->defaultDateTime($varInvoiceDateAddedFrom, DATE_FORMAT_DB) . "' AND '" . $objCore->defaultDateTime($varInvoiceDateAddedTo, DATE_FORMAT_DB) . "'";
            }
            if ($varfkOrderID <> '')
            {
                $varWhereClause .= " AND i.fkOrderID = '" . $varfkOrderID . "'";
            }
            if ($varfkSubOrderID <> '')
            {
                $varWhereClause .= " AND i.fkSubOrderID = '" . $varfkSubOrderID . "'";
            }
            if ($varCompanyName <> '')
            {
                $varWhereClause .= " AND w.CompanyName LIKE '%" . addslashes($varCompanyName) . "%'";
            }
            if ($varCommission <> '')
            {
                $varWhereClause .= " AND w.Commission = '" . $varCommission . "'";
            }
            if ($varTransactionStatus <> '')
            {
                if ($varTransactionStatus == TRANSACTION_DAYS_ALERT)
                    $varWhereClause .= " AND datediff(now() , `InvoiceDateAdded`) > '" . TRANSACTION_DAYS_ALERT . "'";
                else
                    $varWhereClause .= " AND TransactionStatus = '" . $varTransactionStatus . "'";
            }
            $varWhereClause = $varWhereClause . $varPortalFilter;
            //die($varWhereClause);
            $this->varPageStart = $objPaging->getPageStartLimit($_GET['page'], $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;

            $arrRecords = $objWholesaler->WholesalerCommissionCount($varWhereClause);
            $this->NumberofRows = $arrRecords;

            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objWholesaler->WholesalerCommissionList($varWhereClause, $this->varLimit);
            $this->varSortColumn = $objWholesaler->getSortColumnCommission($_REQUEST);
        } else
        {
            $varWhereClause = $varWhereClause . $varPortalFilter;
            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = $objWholesaler->WholesalerCommissionCount($varWhereClause);
            $this->NumberofRows = $arrRecords;
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objWholesaler->WholesalerCommissionList($varWhereClause, $this->varLimit);
            $this->varSortColumn = $objWholesaler->getSortColumnCommission($_REQUEST);
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
    public function pageLoad()
    {
        $objCore = new Core();
        $objWholesaler = new Wholesaler();
        global $objGeneral;
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'fkWholesalerID');

        if (isset($_GET['type']) && $_GET['type'] = 'view' && $_GET['iid'] <> '')
        {
            $varID = $_GET['iid'];
            $this->arrRow = $objWholesaler->viewInvoice($varID, $varPortalFilter);
        }
        else
        {
            $this->arrShippingList = $objWholesaler->shippingGatewayList();
            $this->arrCountryList = $objWholesaler->countryList();
            $this->getList();
            $this->CountryPortal = $objWholesaler->adminUserList();
        }
    }

// end of page load
}

$objPage = new WholeSalerCtrl();
$objPage->pageLoad();

//print_r($objPage->arrRow[0]);
?>
