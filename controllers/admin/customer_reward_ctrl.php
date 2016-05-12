<?php

require_once CLASSES_ADMIN_PATH . 'class_customer_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';
require COMPONENTS_SOURCE_ROOT_PATH . 'PHPExcel/Classes/PHPExcel.php';

class customerCtrl extends Paging {
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


        if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') {
            //echo "hello";

            $arrSearchParameter = $_GET;
            //$varWhereClause="";

            $varId = $arrSearchParameter['id'];
            $varType = $arrSearchParameter['type'];

            if ($varId <> '') {
                $varWhereClause .= " AND fkCustomerID ='" . addslashes($varId) . "'";
            }
            if ($varType <> '') {
                $varWhereClause .= " AND TransactionType = '" . $varType . "'";
            }

            $varWhereClauses = " 1 " . $varWhereClause;
        } else {
            $varWhereClauses = '';
        }

        $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
        $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
        $arrRecords = $objcustomer->rewardList($varWhereClauses, $limit = '');
        $this->NumberofRows = count($arrRecords);
        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
        $this->arrRows = $objcustomer->rewardList($varWhereClauses, $this->varLimit);
        $this->varSortColumn = $objcustomer->getRewardSortColumn($_REQUEST);
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
        $this->NumberofRows = count($objcustomer->customerList($varWhr = '', $this->varLimit));
        $this->getList();

       
        $this->arrShippingList = $objcustomer->shippingGatewayList();
        $this->arrCountryList = $objcustomer->countryList();

        if (isset($_REQUEST['action']) && $_REQUEST['action'] = 'delete') {
            if ($objcustomer->removeRewards($_REQUEST)) {
                $objCore->setSuccessMsg(ADMIN_DELETE_SUCCUSS_MSG);
            } else {
                $objCore->setErrorMsg(ADMIN_DELETE_SUCCUSS_MSG);
            }
            header('location:customer_reward_history_uil.php');
            die;
        } else if (isset($_REQUEST['frmChangeAction']) && is_array($_REQUEST['frmID'])) {
            if ($objcustomer->removeAllRewards($_REQUEST)) {
                $objCore->setSuccessMsg(ADMIN_DELETE_SUCCUSS_MSG);
            } else {
                $objCore->setErrorMsg(ADMIN_DELETE_SUCCUSS_MSG);
            }
            header('location:customer_reward_history_uil.php');
            die;
        } else {
            $this->getList();
            $this->arrCustomer = $objcustomer->customerAllList();
        }
    }

// end of page load
}

$objPage = new customerCtrl();
$objPage->pageLoad();
//print_r($objPage->arrRow[0]);
?>
