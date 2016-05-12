<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */require_once '../common/config/config.inc.php';
require_once CLASSES_LOGISTIC_PATH . 'class_add_zone_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';
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
        $objZoneGateway = new ZoneGatewayNew();

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


        $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
        $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
        $arrRecords = $objZoneGateway->zoneList($varWhr = 'fklogisticid ='.$_SESSION['sessLogistic']);
        $arreditRecords = $objZoneGateway->zoneeditList($_SESSION['sessLogistic']);
       //pre($arreditRecords);
         $this->NumberofeditRows = count($arreditRecords);
        $this->EditRows = $arreditRecords;
        $this->NumberofRows = count($arrRecords);
        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
        $this->arrRows = $objZoneGateway->zoneList($varWhr = 'fklogisticid ='.$_SESSION['sessLogistic'], $this->varLimit);
      //  pre($this->arrRows);
        //echo '<pre>';print_r($this->arrRows);die;
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
        
        $objZoneGateway = new ZoneGatewayNew();
//
//        $this->arrZoneList = $objZoneGateway->zoneGatewayList("ZoneType = 'admin' ");
 //pre($_REQUEST);
        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'add' ) {   // Editing images record
          // pre("here");
            $varAddStatus = $objZoneGateway->addZone($_POST);
            if ($varAddStatus == 'exist') {
                $objCore->setErrorMsg('Zone Gateway already exist.');
                // header('location:zone_method_add_uil.php?type=' . $_GET['type']);
                // die;
            } else if ($varAddStatus > 0) {
                //$objCore->setSuccessMsg(ADMIN_ADD_SUCCUSS_MSG);
                $objCore->setSuccessMsg("Zone added successfully. Please Fill Zone Price");
                //header('location:setup_manage_uil.php');
                header('location:price_add_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
                //   header('location:zone_method_add_uil.php?type=' . $_GET['type']);
                //die;
            }
        } else if (isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'edit' ) {
//            pre($_REQUEST);
            //pre("heresss");
            $zonedetais_id = $objZoneGateway->updateZone($_POST);
           
            
            if ($zonedetais_id === 'exist') {
                
                //pre($varUpdateStatus);
                $objCore->setErrorMsg('Zone already exist.');
                header('location:zone_edit_new_uil.php?type=' . $_GET['type'] . '&smid=' . $_GET['smid'] . '&httpRef=' . $_POST['httpRef']);
                die;
            } else if ($zonedetais_id > 0) {
                $objCore->setSuccessMsg(ADMIN_UPDATE_SUCCUSS_MSG);
                header('location:setup_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
                header('location:setup_manage_uil.php');
                die;
            }
        } else if (isset($_GET['smid']) && $_GET['smid'] != '' && ($_GET['type'] == 'edit')) {
             //pre("heresssppp");
            $varWhr = $_GET['smid'];
            $this->arrRow = $objZoneGateway->getZoneByID($varWhr);
            $this->arrRow['selectedCountry'] = $objZoneGateway->getSelectedPortal($varWhr);
            //pre($this->arrRow);
        } 
        else {
           // pre("yes");
            $this->getList();
        }
    }

// end of page load
}

$objPage = new ZoneCtrl();
$objPage->pageLoad();
?>
