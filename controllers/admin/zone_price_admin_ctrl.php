<?php

require_once CLASSES_ADMIN_PATH . 'class_country_portal_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_zone_price_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_adminuser_bll.php';

class ZonePriceCtrl extends Paging {
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
//       pre($_SESSION);
        //$objCore = new Core();
        //echo $objCore->setSuccessMsg();
        $objAdminLogin = new AdminLogin();
        //check admin session
        $objAdminLogin->isValidAdmin();

        $objUser = new AdminUser();

        //check session
        //************ Get Admin Email here
    }

    private function getList() {
        //pre($_SESSION);
        $objPaging = new Paging();
        $objzonesprice = new ZonePrice();
        // pre($_SESSION);
        global $objGeneral;
        //$varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminlogisticIDs'], 'fklogisticidvalue');



        $this->varPageLimit = ($_SESSION['sessAdminPageLimit'] < 1) ? ADMIN_RECORD_LIMIT : $_SESSION['sessAdminPageLimit'];
        $varPage = isset($_GET['page']) ? $_GET['page'] : '';

//        if ($_SESSION['sessUserType'] == 'user-admin') {
//            $varWhereClause .= "  logisticportal = '" . $_SESSION['sessAdminCountry'] . "'";
//        }
        //$varWhereClause = "  AdminType= 'user-admin'  ";
//         if ($_SESSION['sessUserType'] == 'user-admin') {
//             $varWhereClause .= " AND AdminCountry = '" . $_SESSION['sessAdminCountry'] . "'";
//         }
        $varWhereClause = '1=1 ';
//        if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') {
//            $arrSearchParameter = $_GET;
//
//            $varName = $arrSearchParameter['frmTitle'];
//            $varStatus = $arrSearchParameter['frmStatus'];
//            if (!empty($varStatus)) {
//                if ($varStatus == 'Active') {
//                    $varStatus = 1;
//                } else {
//                    $varStatus = '0';
//                }
//            }
//            $varCountry = $arrSearchParameter['CountryPortalID'];
//
//
//
//            if ($_SESSION['sessUserType'] == 'user-admin') {
//                $varWhereClause .= "  AND logisticportal = '" . $_SESSION['sessUser'] . "'";
//            }
//            if ($varName <> '') {
//                // $varWhereClause .= " AND logisticTitle LIKE '%" . addslashes($varName) . "%'";
//                $varWhereClause .= " AND logisticTitle LIKE '%" . addslashes($varName) . "%'";
//            }
//            if ($varCountry > 0) {
//                $varWhereClause .= " AND logisticportal = '" . $varCountry . "'";
//            }
//
//            if ($varStatus <> '') {
//                $varWhereClause .= " AND logisticStatus = '" . $varStatus . "'";
//            }
//        } else {
//            $varWhereClause .= "  AND created = ( SELECT max(created) FROM " . TABLE_ZONEPRICE . " as newPriceTbl WHERE "
//                    . " newPriceTbl.zonetitleid = tbl_zoneprice.zonetitleid "
//                    . " AND newPriceTbl.shippingmethod = tbl_zoneprice.shippingmethod ) " ;
//        }
//         $varWhereClause='';

        $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
        $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
        //$arrRecords = $objCountryPortal->CountryPortalCount($varWhereClause);
        $arrRecords = $objzonesprice->ship_price_count($varWhereClause);
        $this->NumberofRows = $arrRecords;

        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);

        //$this->arrRows = $objCountryPortal->CountryPortalList($varWhereClause, $this->varLimit, $varCurrentPeriodFilter);
        $this->arrRows = $objzonesprice->listOfAllPortal($varWhereClause, $this->varLimit);
        //$this->varSortColumn = $objCountryPortal->getSortColumnKPI($_REQUEST);
        //pre("here");
//        pre($this->arrRows);
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
//          pre($_REQUEST);
        $objCore = new Core();
        $objzonesprice = new ZonePrice();
//        $objlogisticPortal = new logistic();
        global $objGeneral;

        $dbCurrentDate = date(DATE_FORMAT_DB);

        //$varArchivePeriodFilter = $objGeneral->getArchiveCommissionPeriodFilter($dbCurrentDate, '');
        //pre($_GET);
//        if (isset($_GET['type']) && $_GET['type'] == 'edit' && isset($_GET['EditId']) && $_GET['EditId'] <> '') {
//        $this->arrDetail = $objzonesprice->shipPriceDetailById($_GET['EditId']);
        if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'add' && $_REQUEST['LogisticId'] != '' && $_REQUEST['frmHidenAdd'] != 'add') {
            $this->logisticId = $_REQUEST['LogisticId'];
            //$varWhereClause = "fklogisticid = " . $_REQUEST['LogisticId'] . "";
            //$this->zoneList = $objzonesprice->getZoneListByLogisticID($varWhereClause);

        } else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'add' && $_REQUEST['LogisticId'] != '' && $_REQUEST['frmHidenAdd'] == 'add') {
            $this->logisticId = $_REQUEST['LogisticId'];
            //$varWhereClause = "fklogisticid = " . $_REQUEST['LogisticId'] . "";
            //$this->zoneList = $objzonesprice->getZoneListByLogisticID($varWhereClause);
            
            $varAddStatus = $objzonesprice->addprice($_REQUEST);
            if ($varAddStatus == 'exist') {
                $objCore->setErrorMsg('Shipping Method already exists.');
                header('location:zone_price_add_uil.php?type=add&LogisticId='.$_REQUEST['LogisticId'].'');
                die;
            } else if ($varAddStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_ADD_SUCCUSS_MSG);
                header('location:listing_zone_price.php?type=listingPrice&LogisticId='.$_REQUEST['LogisticId'].'');
                die;
            } else if ($varAddStatus == 'wrongcombination') {
                $objCore->setErrorMsg('Please select differnt shipping Method for same zone.');
                header('location:zone_price_add_uil.php?type=add&LogisticId='.$_REQUEST['LogisticId'].'');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
                //   header('location:zone_method_add_uil.php?type=' . $_GET['type']);
                //die;
            }
        } else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'listingPrice' && $_REQUEST['LogisticId'] != '') {

            $varWhereClause = "1=1";
            $varWhereClause .= " AND created = ( SELECT max(created) FROM " . TABLE_ZONEPRICE . " as newPriceTbl WHERE "
                    . " fklogisticidvalue =" . $_REQUEST['LogisticId'] . " AND newPriceTbl.zonetitleid = tbl_zoneprice.zonetitleid "
                    . " AND newPriceTbl.shippingmethod = tbl_zoneprice.shippingmethod ) ";

            $this->zonePriceList = $objzonesprice->zonePriceList($varWhereClause);
            $this->varSortColumn = $objzonesprice->getSortColumn($_REQUEST);
            $this->logisticId = $_REQUEST['LogisticId'];
        } else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'edit' && $_REQUEST['id'] != '' && $_POST['frmHidenEdit'] != 'edit') {

            $varWhr = $_GET['id'];
            $this->arrRow['detailById'] = $objzonesprice->getPriceByID($varWhr);
            $this->logisticId = $_REQUEST['LogisticId'];
        } else if (isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'edit') {
            $varAddStatus = $objzonesprice->editprice($_REQUEST);
//            pre($varAddStatus);
            if ($varAddStatus === 'exist') {

                $objCore->setErrorMsg('Price already exists for same zone and shipping method.');
                header('location:zone_price_edit_uil.php?type=' . $_GET['type'] . '&id=' . $_GET['id']);
                die;
            } else if ($varAddStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_UPDATE_SUCCUSS_MSG);
                header('location:zone_price_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
                header('location:price_manage_uil.php');
                die;
            }
        } else {
            $this->getList();
        }
    }

// end of page load
}

$objPage = new ZonePriceCtrl();
$objPage->pageLoad();

//print_r($objPage);die;
?>
