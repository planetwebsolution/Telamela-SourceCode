<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_support_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';

class SupportCtrl extends Paging {
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
        $objSupport = new Support();
        global $objGeneral;
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'],'fkFromUserID');

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
        $varWhr = " ";
        if (isset($_REQUEST['frmSearch']) && $_REQUEST['frmSearch'] == 'Search') {
            $arrSearchParameter = $_GET;
            $frmSenderName = $arrSearchParameter['frmSenderName'];
            $frmType = $arrSearchParameter['frmType'];
            $frmEmail = $arrSearchParameter['frmEmail'];

            if ($frmSenderName <> '') {
                if ($frmType == 'customer') {
                    $varWhr .= " AND CustomerFirstName like '%" . addslashes($frmSenderName) . "%' ";
                } elseif ($frmType == 'wholesaler') {
                    $varWhr .= " AND CompanyName like '%" . addslashes($frmSenderName) . "%' ";
                } else {
                    $varWhr .= " AND (CustomerFirstName like '%" . addslashes($frmSenderName) . "%' OR CompanyName like '%" . addslashes($frmSenderName) . "%' ) ";
                }
            }
            if ($frmEmail <> '') {
                $varWhr .= " AND EnquirySenderEmail like '%" . addslashes($frmEmail) . "%'";
            }

            if ($frmType <> '') {
                $varWhr .= " AND FromUserType = '" . addslashes($frmType) . "' ";
            }
            
            $varWhrClause = $varWhr . $varPortalFilter;
            //pre( $varWhr);

            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = $objSupport->viewAllWholesalerSupport($varWhrClause);
            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objSupport->viewAllWholesalerSupport($varWhrClause, $this->varLimit);
            //echo '<pre>';print_r($this->arrRows);die;
            $this->varSortColumn = $objSupport->getSortColumnWholesalerSupport($_REQUEST);
        } else {
            $varWhrClause = $varWhr . $varPortalFilter;
            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = $objSupport->viewAllWholesalerSupport($varWhrClause);
            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objSupport->viewAllWholesalerSupport($varWhrClause, $this->varLimit);
            //echo '<pre>';print_r($this->arrRows);die;
            $this->varSortColumn = $objSupport->getSortColumnWholesalerSupport($_REQUEST);
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
        
        //pre($_POST);
        $objCore = new Core();
        $objSupport = new Support();
        global $objGeneral;
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'],'fkFromUserID');
        $varPortalFilterPK = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'],'pkWholesalerID');

        $this->arrMessageType = $objSupport->getMessageTypeList();
        $this->varWholesalerList = $objSupport->wholeSalerList($varPortalFilterPK);
        if (isset($_POST['frmHidenAdd']) && ($_POST['frmHidenAdd'] == 'message')) {   // Editing images record
            
            $varAddStatus = $objSupport->addSupport($_POST);
            if ($varAddStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_SUPPORT_ADD_SUCCUSS_MSG);
                header('location: wholesaler_support_enquiry_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_SUPPORT_ADD_ERROR_MSG);
                header('location: wholesaler_support_enquiry_manage_uil.php');
                die;
            }
        }

        if (isset($_POST['frmHidenAdd']) && ($_POST['frmHidenAdd'] == 'reply')) {   // Editing images record
            $varAddStatus = $objSupport->addReplyWholesalerSupport($_POST);
            if ($varAddStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_SUPPORT_ADD_SUCCUSS_MSG);
                header('location: wholesaler_support_enquiry_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_SUPPORT_ADD_ERROR_MSG);
                header('location: wholesaler_support_enquiry_manage_uil.php');
                die;
            }
        }
        if (isset($_GET['id']) && $_GET['id'] != '' && ($_GET['type'] == 'edit')) {
            $varWhrCms = $_GET['id'].$varPortalFilter;
            $objSupport->givMessageRead($varWhrCms);
            $this->arrRow = $objSupport->viewSupport($varWhrCms);
        } else {

            $this->getList();
        }
    }

}

$objPage = new SupportCtrl();
$objPage->pageLoad();
?>