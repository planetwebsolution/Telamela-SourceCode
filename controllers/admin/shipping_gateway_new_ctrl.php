<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_shipping_gateway_new_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

class ShippingGatewayCtrl extends Paging {
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
        $objShippingGateway = new ShippingGatewayNew();

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
        $arrRecords = $objShippingGateway->shippingGatewayPriceList($varWhr = '', $limit = '');
        $this->NumberofRows = count($arrRecords);
        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
        $this->arrRows = $objShippingGateway->shippingGatewayPriceList($varWhr = '', $this->varLimit);
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
        $objShippingGateway = new ShippingGatewayNew();

        //$this->arrShippingGatewaysList = $objShippingGateway->shippingGatewayList("ShippingType = 'admin' ");
        //$this->arrShippingMethodList = $objShippingGateway->shippingMethodList("");

        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'add' && $_GET['type'] == 'add') {   // Editing images record
            $varAddStatus = $objShippingGateway->addShippingGateway($_POST);
            if ($varAddStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_ADD_SUCCUSS_MSG);
                header('location:shipping_gateway_manage_new_uil.php');
                die;
            } else if ($varAddStatus == 'EmptyPrice') {
                $objCore->setErrorMsg('Shipping Price is Required!');
                header('location:shipping_price_add_new_uil.php?type=' . $_GET['type']);
                die;
            } else if ($varAddStatus == 'weightError') {
                $objCore->setErrorMsg('Max weight always grater than Min weight!');
                header('location:shipping_price_add_new_uil.php?type=' . $_GET['type']);
                die;
            } else if ($varAddStatus == 'exist') {
                $objCore->setErrorMsg('This Combination Already Exist!');
                header('location:shipping_price_add_new_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
                header('location:shipping_price_add_new_uil.php?type=' . $_GET['type']);
                die;
            }
        } else if (isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'edit' && $_GET['type'] == 'edit' && $_GET['sgid'] != '') {
            //pre();
            $varUpdateStatus = $objShippingGateway->updateShippingGateway($_REQUEST);
            //pre($varUpdateStatus);
            if ($varUpdateStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_UPDATE_SUCCUSS_MSG);
                header('location:shipping_gateway_manage_new_uil.php');
                die;
            } else if ($varUpdateStatus == 'weightError') {
                $objCore->setErrorMsg('Max weight always grater than Min weight!');
                header('location:shipping_gateway_manage_new_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_UPDATE_ERROR_MSG);
                header('location:shipping_gateway_edit_new_uil.php?type=' . $_GET['type'] . '&sgid=' . $_GET['sgid'] . '&httpRef=' . $_POST['httpRef']);
                die;
            }
        } else if (isset($_GET['sgid']) && $_GET['sgid'] != '' && ($_GET['type'] == 'edit')) {

            $varWhr = $_GET['sgid'];
            $this->arrRow = $objShippingGateway->editShippingGateway($varWhr, $_GET['smid']);
            $this->OldEntry = $objShippingGateway->editShippingGatewayOldEntry($varWhr, $_GET['smid']);
            //$this->arrMethods = $objShippingGateway->shippingMethodList("fkShippingGatewayID = '" . $varWhr . "' ");
            $this->RemainingCountries = $objShippingGateway->getcountryShippingByID($varWhr, $_GET['smid']);
            //$this->arrZoneCountry = $objShippingGateway->getZoneCountry();
            //pre($this->arrRow);
        } else if (isset($_GET['type']) && $_GET['type'] == 'add') {
            $this->arrZoneCountry = $objShippingGateway->getZoneCountry();
        } else {
            $this->getList();
        }
    }

// end of page load
}

$objPage = new ShippingGatewayCtrl();
$objPage->pageLoad();
?>
