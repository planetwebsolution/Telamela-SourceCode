<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_shipping_gateway_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';

class ShippingMethodCtrl extends Paging {
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
        $objShippingGateway = new ShippingGateway();

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
        $arrRecords = $objShippingGateway->shippingMethodList($varWhr = '');
        $this->NumberofRows = count($arrRecords);
        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
        $this->arrRows = $objShippingGateway->shippingMethodList($varWhr = '', $this->varLimit);
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
        $objCore = new Core();
        $objShippingGateway = new ShippingGateway();

        $this->arrShippingList = $objShippingGateway->shippingGatewayList("ShippingType = 'admin' ");

        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'add' && $_GET['type'] == 'add') {  
        	//pre("here");
        	// Editing images record
            $varAddStatus = $objShippingGateway->addShippingMethod($_POST);
           // pre($varAddStatus);
            if ($varAddStatus == 'exist') {
                $objCore->setErrorMsg("SHIPPING METHOD ALREADY EXISTS");
                // header('location:shipping_method_add_uil.php?type=' . $_GET['type']);
                // die;
            } else if ($varAddStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_ADD_SUCCUSS_MSG);
                header('location:shipping_method_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
                //   header('location:shipping_method_add_uil.php?type=' . $_GET['type']);
                //die;
            }
        } else if (isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'edit' && $_GET['type'] == 'edit' && $_GET['smid'] != '') {

            $varUpdateStatus = $objShippingGateway->updateShippingMethod($_POST);

            if ($varUpdateStatus == 'exist') {
                $objCore->setErrorMsg("SHIPPING METHOD ALREADY EXISTS");
                header('location:shipping_method_edit_uil.php?type=' . $_GET['type'] . '&smid=' . $_GET['smid'] . '&httpRef=' . $_POST['httpRef']);
                die;
            } else if ($varUpdateStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_UPDATE_SUCCUSS_MSG);
                header('location:shipping_method_manage_uil.php');
                die;
            } 
            else if ($varUpdateStatus =='notdeacative') {
                $objCore->setErrorMsg("This Method is used, can't deactivate.");
                header('location:shipping_method_manage_uil.php');
                die;
            } 
            else {
                $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
                header('location:shipping_method_edit_uil.php?type=' . $_GET['type'] . '&smid=' . $_GET['smid'] . '&httpRef=' . $_POST['httpRef']);
                die;
            }
        } else if (isset($_GET['smid']) && $_GET['smid'] != '' && ($_GET['type'] == 'edit')) {
            $varWhr = $_GET['smid'];
            $this->arrRow = $objShippingGateway->getShippingMethodByID($varWhr);
        } else {
            $this->getList();
        }
    }

// end of page load
}

$objPage = new ShippingMethodCtrl();
$objPage->pageLoad();
?>
