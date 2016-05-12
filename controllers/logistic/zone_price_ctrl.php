<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */require_once '../common/config/config.inc.php';
require_once CLASSES_LOGISTIC_PATH . 'class_zone_price_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
//if (empty($_SESSION['sessLogistictype'])) {
//    header('location:index.php');
//    exit();
//}
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
        //$objCore = new Core();
        //echo $objCore->setSuccessMsg();
        $objAdminLogin = new AdminLogistic();
        //check admin session
        $objAdminLogin->isValidAdmin();
        
        //************ Get Admin Email here
    }

    private function getList() {
        $objPaging = new Paging();
        $objPriceZone = new ZonePriceNew();

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
//$varWhereClause='fklogisticidvalue ='.$_SESSION['sessLogistic'];
        $varWhereClause ='fklogisticidvalue ='.$_SESSION['sessLogistic'];
if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') {
   
            $arrSearchParameter = $_GET;
            $varzoneid = $arrSearchParameter['zoneid'];
            $varshippingmethod = $arrSearchParameter['shippingmethod'];
           
            $varminweight = $arrSearchParameter['minweight'];
            $varmaxweight = $arrSearchParameter['maxweight'];
            $varcost = $arrSearchParameter['cost'];
            
            
            //
            //$varWhereClause .='fklogisticidvalue ='.$_SESSION['sessLogistic'];
//            if ($_SESSION['sessUserType'] == 'user-admin') {
//            	$varWhereClause .= "  AND zonetitleid = '" . $_SESSION['sessUser'] . "'";
//            }
            if ($varzoneid > 0) {
               // $varWhereClause .= " AND logisticTitle LIKE '%" . addslashes($varName) . "%'";
                $varWhereClause .= " AND zonetitleid = '" .mysql_real_escape_string($varzoneid) . "'";
            }
            if ($varshippingmethod > 0) {
                $varWhereClause .= " AND shippingmethod = '" . mysql_real_escape_string($varshippingmethod) . "'";
            }

            if ($varminweight <> '') {
                $varWhereClause .= " AND minkg = '" . mysql_real_escape_string($varminweight) . "'";
            }
             if ($varmaxweight <> '') {
                $varWhereClause .= " AND maxkg = '" . mysql_real_escape_string($varmaxweight) . "'";
            }
             if ($varcost <> '') {
                $varWhereClause .= " AND costperkg = '" . mysql_real_escape_string($varcost) . "'";
            }
            
            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
        $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;

            $arrRecords = $this->arrRows = $objPriceZone->zonePriceList($varWhereClause, $this->varLimit);

            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            //$this->arrRows = $objProduct->ProductList($varWhrClause, $this->varLimit);
        }
        else{
            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
        $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
        
         $arrRecords = $objPriceZone->zonepriceCount('fklogisticidvalue ='.$_SESSION['sessLogistic']);
       
        
        $this->NumberofRows = $arrRecords;
        }
        
        //pre($this->NumberofRows );
      
            $varWhereClause .= " AND created = ( SELECT max(created) FROM " . TABLE_ZONEPRICE . " as newPriceTbl WHERE "
                    . " fklogisticidvalue =" .$_SESSION['sessLogistic'] . " AND newPriceTbl.zonetitleid = tbl_zoneprice.zonetitleid "
                    . " AND newPriceTbl.shippingmethod = tbl_zoneprice.shippingmethod ) ";
            
            $varWhereClauseFront = "fklogisticidvalue =" .$_SESSION['sessLogistic']. " AND created = ( SELECT max(created) FROM " . TABLE_ZONEPRICE . " as newPriceTbl WHERE "
                    . " fklogisticidvalue =" .$_SESSION['sessLogistic'] . " AND newPriceTbl.zonetitleid = tbl_zoneprice.zonetitleid "
                    . " AND newPriceTbl.shippingmethod = tbl_zoneprice.shippingmethod AND created <= CURDATE()) ";
        
        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
        //
        $this->arrRows = $objPriceZone->zonePriceList($varWhereClause, $this->varLimit);
        $this->frontRows = $objPriceZone->zonePriceList($varWhereClauseFront, '');
//        pre($this->frontRows);
        $this->varSortColumn = $objPriceZone->getSortColumn($_REQUEST);
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
//        pre($_REQUEST);
        $objCore = new Core();
        
        $objPriceZoneGateway = new ZonePriceNew();
//
//        $this->arrZoneList = $objZoneGateway->zoneGatewayList("ZoneType = 'admin' ");
 //pre($_REQUEST);
        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'add' ) {   // Editing images record
          // pre("here");
            $varAddStatus = $objPriceZoneGateway->addprice($_POST);
            if ($varAddStatus == 'exist') {
                $objCore->setErrorMsg('Shipping Method already exists.');
                 header('location:price_add_uil.php');
                die;
            } else if ($varAddStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_ADD_SUCCUSS_MSG);
                header('location:price_manage_uil.php');
                die;
            } 
            else if ($varAddStatus  == 'wrongcombination') {
               $objCore->setErrorMsg('Please select differnt shipping Method for same zone.');
                header('location:price_add_uil.php');
                die;
            } 
            else {
                $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
                //   header('location:zone_method_add_uil.php?type=' . $_GET['type']);
                //die;
            }
        } else if (isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'edit' ) {
//            pre($_REQUEST);
            $varAddStatus = $objPriceZoneGateway->editprice($_POST);
//            pre($varAddStatus);
            if ($varAddStatus === 'exist') {
                
                $objCore->setErrorMsg('Price already exists for same zone and shipping method.');
                header('location:price_edit_uil.php?type=' . $_GET['type'] . '&id=' . $_GET['id']);
                die;
            } else if ($varAddStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_UPDATE_SUCCUSS_MSG);
                header('location:price_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
                header('location:price_manage_uil.php');
                die;
            }
        } else if (isset($_GET['id']) && $_GET['id'] != '' && ($_GET['type'] == 'edit')) {
            //pre("heresssppp");
            $varWhr = $_GET['id'];
            $this->arrRow['detailById'] = $objPriceZoneGateway->getPriceByID($varWhr);
            //$this->arrRow['selectedCountry'] = $objZoneGateway->getSelectedPortal($varWhr);
            //pre($this->arrRow);
        } 
        else {
//            pre("yes");
            $this->getList();
        }
    }

// end of page load
}

$objPage = new ZoneCtrl();
$objPage->pageLoad();
?>
