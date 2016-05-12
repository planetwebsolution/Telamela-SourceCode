<?php

require_once CLASSES_ADMIN_PATH . 'class_customer_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

class customer_feedbackCtrl extends Paging {
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
        $objcustomer = new customer();
        global $objGeneral;
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs']);

        // pre($this->kpi);
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

        $varWhereClause = " 1 ";
        if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') {
            //echo "hello";

            $arrSearchParameter = $_GET;
            //$varWhereClause="";


            $WholesalerID = $arrSearchParameter['WholesalerID'];
            $WholesalerName = $arrSearchParameter['WholesalerName'];
            
            if ($WholesalerName <> '') {
                $varWhereClause .= " AND CompanyName LIKE '%" . addslashes($WholesalerName) . "%'";
            }
            if ($WholesalerID <> '') {
                $varWhereClause .= " AND fkWholesalerID = " . $WholesalerID . " ";
            }



            $varWhereClauses = $varWhereClause.$varPortalFilter;
            $this->varPageStart = $objPaging->getPageStartLimit($_GET['page'], $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;

            $arrRecords = $objcustomer->customerFeedbackList($varWhereClauses);

            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objcustomer->customerFeedbackList($varWhereClauses, $this->varLimit);
        } else {
            $varWhereClauses = $varWhereClause.$varPortalFilter;
            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = $objcustomer->customerFeedbackList($varWhereClauses);
            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objcustomer->customerFeedbackList($varWhereClauses, $this->varLimit);
            // echo '<pre>';print_r($this->arrRows);die;
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
        $objcustomer = new customer();
        $this->arrRows = $objcustomer->customerList($varWhr = '', $this->varLimit);
        $this->NumberofRows = count($this->arrRows);
        $this->getList();
    }

// end of page load
}

$objPage = new customer_feedbackCtrl();
$objPage->pageLoad();
//print_r($objPage->arrRow[0]);
?>
