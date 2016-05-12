<?php

require_once CLASSES_ADMIN_PATH . 'class_country_portal_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_zone_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_adminuser_bll.php';

class ZoneCtrl extends Paging {
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
        $objzones = new Zone();
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
        $arrRecords = $objzones->ship_price_count($varWhereClause);
        $this->NumberofRows = $arrRecords;

        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);

        //$this->arrRows = $objCountryPortal->CountryPortalList($varWhereClause, $this->varLimit, $varCurrentPeriodFilter);
        $this->arrRows = $objzones->listOfAllPortal($varWhereClause, $this->varLimit);
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
        $objzones = new Zone();
//        $objlogisticPortal = new logistic();
        global $objGeneral;

        $dbCurrentDate = date(DATE_FORMAT_DB);

        //$varArchivePeriodFilter = $objGeneral->getArchiveCommissionPeriodFilter($dbCurrentDate, '');
        //pre($_GET);
        if (isset($_GET['type']) && $_GET['type'] == 'edit' && isset($_GET['EditId']) && $_GET['EditId'] <> '') {
//            pre("here");

            $this->arrDetail = $objzones->shipPriceDetailById($_GET['EditId']);
//            $this->arrRows = $objCountryPortal->getCountryPortalArchives($_GET['cid']);
//            $this->varSortColumn = $objCountryPortal->getSortColumnArchives($_REQUEST);
        } else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'add' && $_REQUEST['LogisticId'] != '' && $_REQUEST['frmHidenAdd'] == '') {

            $this->zoneTitleNo = $objzones->checkZoneWithNumber($_REQUEST['LogisticId']);
            $this->CmpcountryId = $_REQUEST['countryId'];
            $this->logisticId = $_REQUEST['LogisticId'];
            $this->countryId = $_REQUEST['countryId'];
//            echo $this->zoneTitleNo;die;
            
        } else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'add' && $_REQUEST['LogisticId'] != '' && $_REQUEST['frmHidenAdd'] == 'add') {

            $varAddStatus = $objzones->addZoneAdmin($_REQUEST);
            if ($varAddStatus) {
                $objCore->setSuccessMsg('Successfully added.');
                header('location:zone_listing_uil.php?type=listingzones&LogisticId='. $_REQUEST['LogisticId'].'&countryId='.$_REQUEST['countryId'] .'');
                die;
            }
//            echo $this->zoneTitleNo;die;

        } else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'listingzones' && $_REQUEST['LogisticId'] != '' ) {
            $this->logisticId = $_REQUEST['LogisticId'];
            $this->countryId = $_REQUEST['countryId'];
            $this->zoneListing = $objzones->listOfAllZones($_REQUEST);
            $this->LogisticDetail = $objzones->PortalDetailById($_REQUEST['LogisticId']);
//            pre($this->LogisticDetail);

        } else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'editzonedetail' && $_REQUEST['LogisticId'] != '' && $_REQUEST['frmHidenZoneEdit'] == '' ) {
            $this->logisticId = $_REQUEST['LogisticId'];
            $this->countryId = $_REQUEST['countryId'];
            $this->zoneDetailListing = $objzones->listOfAllZonesDetails($_REQUEST);

        } else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'editzonedetail' && $_REQUEST['LogisticId'] != '' && $_REQUEST['frmHidenZoneEdit'] == 'editzones' ) {
//            pre($_REQUEST);
            $this->logisticId = $_REQUEST['LogisticId'];
            $this->countryId = $_REQUEST['countryId'];
            $this->zoneDetailEdited = $objzones->editZoneDetailAdmin($_REQUEST);
            
            if ($this->zoneDetailEdited) {
                $objCore->setSuccessMsg('Successfully updated.');
                header('location:zone_listing_uil.php?type=listingzones&LogisticId='. $_REQUEST['LogisticId'].'&countryId='.$_REQUEST['countryId'] .'');
                die;
            }
            else if ($this->zoneDetailEdited = 'invalid') {
                $objCore->setSuccessMsg('Please try again.');
                header('location:zone_listing_uil.php?type=listingzones&LogisticId='. $_REQUEST['LogisticId'].'&countryId='.$_REQUEST['countryId'] .'');
                die;
            }

        } else {

            $this->getList();
        }
    }

// end of page load
}

$objPage = new ZoneCtrl();
$objPage->pageLoad();

//print_r($objPage);die;
?>
