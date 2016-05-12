<?php

require_once CLASSES_ADMIN_PATH . 'class_product_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_PATH . 'class_common.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

/**
 * Site General Class
 *
 * This is the general class that will frequently used on website.
 *
 * DateCreated 16th Oct, 2013
 *
 * DateLastModified 16th Oct, 2013
 *
 * @copyright Copyright (C) 2010-2012 Vinove Software and Services
 *
 * @version 10.0
 */
class customer_Product_Review_Ctrl extends Paging {
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
        $objProduct = new Product();

        $id = $_GET['id'];

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
            //echo pre($_REQUEST);
            $arrSearchParameter = $_GET;
            //$varWhereClause="";

            $ProductId = $arrSearchParameter['ProductId'];
            $ProductName = $arrSearchParameter['ProductName'];
            $CustomerFirstName = $arrSearchParameter['CustomerFirstName'];
            $frmParentId = $arrSearchParameter['frmParentId'];



            if ($ProductId <> '') {
                $varWhereClause .= " AND pkProductID ='" . addslashes($ProductId) . "'";
            }
            if ($ProductName <> '') {
                $varWhereClause .= " AND ProductName LIKE '%" . addslashes($ProductName) . "%'";
            }
            if ($CustomerFirstName <> '') {
                $varWhereClause .= " AND concat(CustomerFirstName,' ',CustomerLastName)  LIKE '%" . addslashes($CustomerFirstName) . "%'";
            }
            if ($frmParentId <> '' && $frmParentId <> '0') {
                $varWhereClause .= " AND pkCategoryId  ='" . $frmParentId . "'";
            }



            $varWhereClauses = $varWhereClause . $varPortalFilter;
            $this->varPageStart = $objPaging->getPageStartLimit($_GET['page'], $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;

            $arrRecords = $objProduct->customerReviewList($varWhereClauses);

            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objProduct->customerReviewList($varWhereClauses, $this->varLimit);
            $this->varProductSortColumn = $objProduct->varProductSortColumn($_REQUEST);
        } else {

            if ($id != '') {
                $varWhereClause = 'fkCustomerID=' . $id;
            } else {
                $varWhereClause = '1';
            }
            $varWhereClauses = $varWhereClause . $varPortalFilter;
            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = $objProduct->customerReviewList($varWhereClauses);
            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objProduct->customerReviewList($varWhereClauses, $this->varLimit);
            $this->varProductSortColumn = $objProduct->varProductSortColumn($_REQUEST);
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
        global $objGeneral;
        $objCore = new Core();
        $objProduct = new Product();
        $objClassCommon = new ClassCommon();

        $this->arrCategoryDropDown = $objClassCommon->getCategories();
        $this->getList();
    }

// end of page load
}

$objPage = new customer_Product_Review_Ctrl();
$objPage->pageLoad();
//print_r($objPage->arrRow[0]);
?>
