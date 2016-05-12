<?php

require_once CLASSES_PATH . 'class_wholesaler_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';

class WholesalerOrderCtrl extends Paging {
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
        if ($_SESSION['sessUserInfo']['id'] && $_SESSION['sessUserInfo']['type'] == 'wholesaler') {
            
        } else {
            header('location:' . SITE_ROOT_URL);
            die;
        }

        $objCore = new Core();
        $objCore->setCurrencyPrice();
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
        $wid = $_SESSION['sessUserInfo']['id'];
        $wcountryid = $_SESSION['sessUserInfo']['countryid'];
        //pre($_SESSION);


        //pre($_POST);

        if (isset($_POST['shipment_Delete_x'])) {
            $varID = $_GET['soid'];
            $deleteShipment = $objWholesaler->deleteShipment($_POST['shipment_id']);
            header('location:order_details.php?place=view&soid=' . $varID);
            die;
        }

        if (isset($_POST['frmShippment']) && $_POST['frmShippment'] == 'Update') {
            //pre($_POST);
            $varID = $_GET['soid'];
            $editShipment = $objWholesaler->updateShipment($_POST);
            header('location:order_details.php?place=view&soid=' . $varID);
            die;
        }

        if (isset($_POST['type']) && $_POST['type'] == 'disputeFeedback') {
            $varID = $_GET['soid'];
            $objWholesaler->disputeFeedback($_REQUEST, $cid);
            $objCore->setSuccessMsg(ORDER_DISPUTED_FEEDBACK_SUCCESS_MESSAGE);
            header('location:order_details.php?place=view&soid=' . $varID);
            die;
        }

        if (isset($_REQUEST['place']) && $_REQUEST['place'] == 'view' && $_REQUEST['soid'] != '') {
            $soid = $objCore->getFormatValue($_REQUEST['soid']);

            $this->arrOrderDetail = $objWholesaler->getOrderDetail($soid, $wid);
            $fkShippingIDs=$this->arrOrderDetail['product_detail'][0]['fkShippingIDs'];
            $wholesalercountryportalid= $objWholesaler->wholesalercountryportalfront($wcountryid);
            $portalid=$wholesalercountryportalid[0]['pkAdminID'];
            $gatwaymailid=$objWholesaler->getwaymailidusingportalfront($portalid,$fkShippingIDs);
            $portalmail=$gatwaymailid[0]['gatewayEmail'];
            $this->arrOrderDetail['gatwaymail'] =$portalmail;
            //pre($portalmail);
            if (count($this->arrOrderDetail['product_detail']) > 0) {
                $this->arrInvoiceId = $objWholesaler->getInvoiceId($soid);
            }
            //$this->snipatCareer = $objWholesaler->shippingGatewayList();
        } else if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'updateStatus' && $_REQUEST['soid'] != '') {
            $objWholesaler->updateOrderStatus($_REQUEST['soid'], $_REQUEST['status']);
        } else if (isset($_REQUEST['place']) && $_REQUEST['place'] == 'sendInvoice' && $_REQUEST['soid'] != '') {
            $varID = $_GET['soid'];
            $objWholesaler->sendInvoiceToTelaMela($varID, $wid);
            $objCore->setSuccessMsg('Invoice Sent Successfuly!');
            header('location:order_details.php?place=view&soid=' . $varID);
            die;
        } else {
            $this->arrOrders = $objWholesaler->getWholesalerOrders($wid);
            $this->paging($this->arrOrders);
            $this->arrOrders = $objWholesaler->getWholesalerOrders($wid, $this->varLimit);
        }
    }

// end of page load

    function paging($arrRecords) {
        $objPaging = new Paging();
        $this->varPageLimit = LIST_VIEW_RECORD_LIMIT;
        if (isset($_GET['page'])) {
            $varPage = $_GET['page'];
        } else {
            $varPage = '';
        }
        $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
        $this->varLimit = " LIMIT " . $this->varPageStart . ',' . $this->varPageLimit;
        $this->NumberofRows = count($arrRecords);
        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
    }

}

$objPage = new WholesalerOrderCtrl();
$objPage->pageLoad();
?>
