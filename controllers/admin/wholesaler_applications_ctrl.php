<?php

require_once CLASSES_ADMIN_PATH . 'class_wholesaler_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

class WholeSalerCtrl extends Paging {
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
        $objWholesaler = new Wholesaler();
        global $objGeneral;
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'],'pkWholesalerID');

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
            $arrSearchParameter = $_GET;


            $varName = $arrSearchParameter['frmName'];
            $varPhone = $arrSearchParameter['frmPhone'];
            $varStatus = $arrSearchParameter['frmStatus'];
            $varEmail = $arrSearchParameter['frmEmail'];
            $varCountry = $arrSearchParameter['frmCountry'];
            $varCountryPortal = $arrSearchParameter['frmCountryPortal'];


            if ($varName <> '') {
                $varWhereClause .= " AND CompanyName LIKE '%" . addslashes($varName) . "%'";
            }
            if ($varPhone <> '') {
                $varWhereClause .= " AND CompanyPhone LIKE '%" . $varPhone . "%'";
            }
            if ($varEmail <> '') {
                $varWhereClause .= " AND CompanyEmail LIKE '%" . $varEmail . "%'";
            }
            if ($varCountry > 0) {
                $varWhereClause .= " AND CompanyCountry = '" . $varCountry . "'";
            }

            if ($varCountryPortal <> '0-0-0') {
                $arrPortal = explode('-', $varCountryPortal);
                $varCtry = $arrPortal[1];
                $varRegion = $arrPortal[2];

                if ($varRegion > 0) {
                    $varWhereClause .= " AND CompanyRegion = '" . $varRegion . "'";
                } else if ($varCtry > 0) {
                    $varWhereClause .= " AND CompanyCountry = '" . $varCtry . "'";
                }
            }

            $varWhrClause = "WholesalerStatus='" . $varStatus . "'" . $varWhereClause.$varPortalFilter;
            //echo $varWhrClause;die;
            $this->varPageStart = $objPaging->getPageStartLimit($_GET['page'], $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;

            $arrRecords = $objWholesaler->WholesalerCount($varWhrClause);
            $this->NumberofRows = $arrRecords;
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objWholesaler->WholesalerList($varWhrClause, $this->varLimit);
            $this->varSortColumn = $objWholesaler->getSortColumn($_REQUEST);
        } else {

            $varWhrClause = " WholesalerStatus IN ('pending','reject') ".$varPortalFilter;
            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = $objWholesaler->WholesalerCount($varWhrClause);
            $this->NumberofRows = $arrRecords;
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objWholesaler->WholesalerList($varWhrClause, $this->varLimit);
            $this->varSortColumn = $objWholesaler->getSortColumn($_REQUEST);
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
        $objWholesaler = new Wholesaler();
       
        $this->arrCountryList = $objWholesaler->countryList();
        global $objGeneral;
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'],'pkWholesalerID');
        
        if (isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'edit' && $_GET['type'] == 'edit' && $_GET['id'] != '') {

            $varUpdateStatus = $objWholesaler->updateWholesaler($_POST);

            if ($varUpdateStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_UPDATE_SUCCUSS_MSG);
                header('location:wholesaler_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_UPDATE_ERROR_MSG);
                header('location:wholesaler_edit_uil.php?type=' . $_GET['type'] . '&id=' . $_GET['id']);
                die;
            }
        } else if (isset($_GET['id']) && $_GET['id'] != '' && ($_GET['type'] == 'edit')) {
            $varWhr = $_GET['id'].$varPortalFilter;
            $this->arrRow = $objWholesaler->editWholesaler($varWhr);
            $varWhrCountry = 'fkCountryId=' . $this->arrRow[0]['CompanyCountry'];
            $current_country_id=$this->arrRow[0]['CompanyCountry'];
           
           // pre($current_country_id);
            $current_country_portal = $objGeneral->getcurrentCountryPortal($current_country_id);
           // pre($current_country_portal);
             $this->arrShippingList = $objWholesaler->shippingGatewayList("fkportalID = " . $current_country_portal[0]['pkAdminID']);
            $this->arrRegion = $objWholesaler->regionList($varWhrCountry);
            $this->arrWarning = $objWholesaler->warningList($varWhr);
            //pre($this->arrWarning);
        } else {

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