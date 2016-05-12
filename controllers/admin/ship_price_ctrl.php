<?php

require_once CLASSES_ADMIN_PATH . 'class_country_portal_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_ship_price_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_adminuser_bll.php';

class ShipPriceCtrl extends Paging {
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
        $objshipprice = new Ship_price();
       // pre($_SESSION);
        global $objGeneral;
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminlogisticIDs'], 'fklogisticidvalue');

 

        $this->varPageLimit = ($_SESSION['sessAdminPageLimit'] < 1) ? ADMIN_RECORD_LIMIT : $_SESSION['sessAdminPageLimit'];
        $varPage = isset($_GET['page']) ? $_GET['page'] : '';

        if ($_SESSION['sessUserType'] == 'user-admin') {
            $varWhereClause .= "  logisticportal = '" . $_SESSION['sessAdminCountry'] . "'";
        }





        //$varWhereClause = "  AdminType= 'user-admin'  ";
//         if ($_SESSION['sessUserType'] == 'user-admin') {
//             $varWhereClause .= " AND AdminCountry = '" . $_SESSION['sessAdminCountry'] . "'";
//         }
        $varWhereClause = '1=1 ';
        if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') {
            $arrSearchParameter = $_GET;
           
            $varName = $arrSearchParameter['frmTitle'];
            $varStatus = $arrSearchParameter['frmStatus'];
            if (!empty($varStatus)) {
                if ($varStatus == 'Active') {
                    $varStatus = 1;
                } else {
                    $varStatus = '0';
                }
            }
            $varCountry = $arrSearchParameter['CountryPortalID'];



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
        } else {
            $varWhereClause .= "  AND created = ( SELECT max(created) FROM " . TABLE_ZONEPRICE . " as newPriceTbl WHERE "
                    . " newPriceTbl.zonetitleid = tbl_zoneprice.zonetitleid "
                    . " AND newPriceTbl.shippingmethod = tbl_zoneprice.shippingmethod ) " . $varPortalFilter;
        }
     
//         $varWhereClause='';

        $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
        $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
        //$arrRecords = $objCountryPortal->CountryPortalCount($varWhereClause);
        $arrRecords = $objshipprice->ship_price_count($varWhereClause);
        $this->NumberofRows = $arrRecords;

        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);

        //$this->arrRows = $objCountryPortal->CountryPortalList($varWhereClause, $this->varLimit, $varCurrentPeriodFilter);
        $this->arrRows = $objshipprice->shipPriceList($varWhereClause, $this->varLimit);
        //$this->varSortColumn = $objCountryPortal->getSortColumnKPI($_REQUEST);
        //pre("here");
        //pre($this->arrRows);
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
        $objshipprice = new Ship_price();
//        $objlogisticPortal = new logistic();
        global $objGeneral;

        $dbCurrentDate = date(DATE_FORMAT_DB);

        //$varArchivePeriodFilter = $objGeneral->getArchiveCommissionPeriodFilter($dbCurrentDate, '');
        //pre($_GET);
        if (isset($_GET['type']) && $_GET['type'] == 'edit' && isset($_GET['EditId']) && $_GET['EditId'] <> '') {
//            pre("here");

            $this->arrDetail = $objshipprice->shipPriceDetailById($_GET['EditId']);
//            $this->arrRows = $objCountryPortal->getCountryPortalArchives($_GET['cid']);
//            $this->varSortColumn = $objCountryPortal->getSortColumnArchives($_REQUEST);
        } else if (isset($_REQUEST['approveForm']) && $_REQUEST['approveForm'] == 'approved') {

            //pre($_REQUEST);
           
            $arrdetailsshippingprice = $objshipprice->shipPriceDetailById($_REQUEST['pkpriceid']);
            $logisticportalid=$arrdetailsshippingprice[0]['fklogisticidvalue'];
            $prepriceid=$arrdetailsshippingprice[0]['prepriceid'];
             $approved = $objshipprice->shipPriceAccepted($_REQUEST['pkpriceid'],$logisticportalid,$prepriceid);
           // pre($arrdetailsshippingprice);
            if ($approved) {
                $objCore->setSuccessMsg('Price approved successfully.');
                header('location:ship_price_manage_uil1.php');
                die;
            }
//            $this->arrAdminRows = $objCountryPortal->getAdminDetails($_GET['cid']);
//            $this->arrRows = $objCountryPortal->getWholesalersSalesList($_GET['cid']);
//            $this->varSortColumn = $objCountryPortal->getSortColumnWholesaler($_REQUEST);
        } else if (isset($_REQUEST['rejectForm']) && $_REQUEST['rejectForm'] == 'rejected') {

            //pre($_REQUEST);
            $arrdetailsshippingprice = $objshipprice->shipPriceDetailById($_REQUEST['pkpriceid']);
            $logisticportalid=$arrdetailsshippingprice[0]['fklogisticidvalue'];
            $approved = $objshipprice->shipPriceRejected($_REQUEST['pkpriceid'],$logisticportalid);
            if ($approved) {
                $objCore->setSuccessMsg('Price Rejected.');
                header('location:ship_price_manage_uil1.php');
                die;
            }
//            $this->arrAdminRows = $objCountryPortal->getAdminDetails($_GET['cid']);
//            $this->arrRows = $objCountryPortal->getWholesalersSalesList($_GET['cid']);
//            $this->varSortColumn = $objCountryPortal->getSortColumnWholesaler($_REQUEST);
        } else {

            $this->getList();
        }
    }

// end of page load
}

$objPage = new ShipPriceCtrl();
$objPage->pageLoad();

//print_r($objPage);die;
?>
