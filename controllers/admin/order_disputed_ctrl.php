<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_order_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require COMPONENTS_SOURCE_ROOT_PATH . 'PHPExcel/Classes/PHPExcel.php';

class OrderCtrl extends Paging {
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
        $objOrder = new Order();
        global $objGeneral;
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs']);



        if ($_SESSION['sessAdminPageLimit'] == '' || $_SESSION['sessAdminPageLimit'] < 1) {
            $this->varPageLimit = ADMIN_RECORD_LIMIT;
        } else {
            $this->varPageLimit = $_SESSION['sessAdminPageLimit'];
        }



        if (isset($_GET['page'])) {
            $varPage = $_GET['page'];
        } else {
            $varPage = 0;
        }


        $conditionDefault = " AND oi.DisputedStatus ='Disputed' " . $varPortalFilter;
        if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') {
        	
        	//echo "avi";die;
            $arrSearchParameter = $_GET;

            $varItemName = trim($arrSearchParameter['frmItemName']);
            $varWhid = $arrSearchParameter['frmWhid'];
            $varStatus = trim($arrSearchParameter['frmStatus']);
            $varOrderId = $arrSearchParameter['frmOrderId'];
            $varDateFrom = $arrSearchParameter['frmDateFrom'];
            $varDateTo = $arrSearchParameter['frmDateTo'];


            
            if ($varItemName <> '') {
                $varWhereClause .= $conditionDefault . " AND oi.ItemName LIKE '%" . addslashes($varItemName) . "%'";
            }
            if ($varWhid <> '' && $varWhid > 0) {
                $varWhereClause .= $conditionDefault . " AND fkWholesalerID = '" . addslashes($varWhid) . "'";
            }

            if ($varStatus <> '' && $varStatus <> '0') {
                $varWhereClause .= $conditionDefault . " AND Status = '" . addslashes($varStatus) . "'";
            }

            if ($varOrderId <> '') {
                $varWhereClause .= $conditionDefault . " AND pkOrderID LIKE '%" . addslashes($varOrderId) . "%'";
            }

            if ($varDateFrom <> DATE_NULL_VALUE_SITE && $varDateTo <> DATE_NULL_VALUE_SITE) {

	             if($varDateFrom!='')
	                {
	                $varFrm = date('Y-m-d', strtotime($varDateFrom));
	                $varTo = date('Y-m-d', strtotime($varDateTo));
	               
	                   
	                //$varWhereClause .= $conditionDefault . " AND DATE_FORMAT(ItemDateAdded,'%Y-%m-%d') BETWEEN '" . ($varFrm) . "' AND '" . ($varTo) . "'";

	                $varWhereClause .= $conditionDefault . " AND DATE_FORMAT(ItemDateAdded,'%Y-%m-%d') BETWEEN '" . ($varFrm) . "' AND '" . ($varTo) . "'";
	               }
            }

            
            $varWhereClauses .= $varWhereClause;
	                $this->varPageStart = $objPaging->getPageStartLimit($_GET['page'], $this->varPageLimit);
	                $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
	                $arrRecords = $objOrder->disputedOrderList($varWhereClauses);
	                $this->NumberofRows =  count($arrRecords);
	                $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
	                $this->arrRows = $objOrder->disputedOrderList($varWhereClauses, $this->varLimit);
	                
        } else {
            $varWhereClauses .= $conditionDefault;
            
            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = $objOrder->disputedOrderList($varWhereClauses);
            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objOrder->disputedOrderList($varWhereClauses, $this->varLimit);
            
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
        $objOrder = new order();
        global $objGeneral;
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs']);
        $varPortalFilter1 = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'w.pkWholesalerID');
//pre($_POST);
//pre($this->shipmentRow);

        if (isset($_POST['shipment_Delete_x'])) {

            $deleteShipment = $objOrder->deleteShipment($_POST['shipment_id']);
        }


        if (isset($_POST['shipment_edit']) && $_POST['shipment_edit'] == 'Update') {

            $editShipment = $objOrder->editShipment($_POST);
        }


        if (isset($_POST['shipment_save']) && $_POST['shipment_save'] == 'Save') {

            $addShipment = $objOrder->addShipment($_POST);
        }

        if (isset($_POST['type']) && $_POST['type'] == 'disputeFeedback') {
            $aid = $_SESSION['sessUser'];
            $objOrder->disputeFeedback($_REQUEST, $aid);
            $objCore->setSuccessMsg(ORDER_DISPUTED_FEEDBACK_SUCCESS_MESSAGE);
            //header('location:order_view_uil.php?type=edit&soid=' + $_GET['soid']);
            //die;
        }


        $this->shipmentRow = $objOrder->shipmentRow($_GET['soid']);

        if (isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'edit' && $_GET['type'] == 'edit' && $_GET['soid'] != '') {
            $varUpdateStatus = $objOrder->updateOrder($_POST);
            if ($varUpdateStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_UPDATE_SUCCUSS_MSG);
                header('location:' . $_POST['httpRef']);
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_UPDATE_ERROR_MSG);
                header('location:order_edit_uil.php?type=' . $_GET['type'] . '&soid=' . $_GET['soid'] . '&httpRef=' . $_POST['httpRef']);
                die;
            }
        } else if (isset($_GET['soid']) && $_GET['soid'] != '' && ($_GET['type'] == 'edit')) {
            $varID = $_GET['soid'];
            $this->arrRow = $objOrder->editOrder($varID, $varPortalFilter);
            $this->snipatCareer = $objOrder->snipatCareer();
// pre($this->arrRow);
        } else if (isset($_GET['soid']) && $_GET['soid'] != '' && ($_GET['type'] == 'sendInvoice')) {
            $varID = $_GET['soid'];
            $num = $objOrder->sendInvoiceToCustomer($varID, $varPortalFilter);
            if ($num) {
                $objCore->setSuccessMsg('Invoice Sent Successfuly!');
            } else {
                $objCore->setErrorMsg("Invoice Not Sent Successfuly.");
            }
            header('location:order_invoice_uil.php?type=edit&soid=' . $varID);
            die;
        } else if (isset($_POST['Export']) && $_POST['Export'] == 'Export') {
            $this->exportOrder($_POST);
        } else {
            $this->arrWholesaler = $objOrder->WholesalerList($varPortalFilter1);
            $this->getList();
        }
    }

// end of page load
//Export Start 
    function exportOrder($arrPost) {

        $objCore = new Core();
        $objOrder = new order();

        global $objGeneral;
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'oi.fkWholesalerID');

        $arrOrder = $objOrder->orderList($varPortalFilter, '');
//pre($arrOrder);

        $headings = array(
            'Order ID',
            'Sub Order ID',
            'Items Name',
            'Customer',
            'Date',
            'Total Price(' . ADMIN_CURRENCY_SYMBOL . ')',
            'Status'
        );


        if ($arrPost['fileType'] == 'csv') {


            $filename = 'order_list_' . time() . '.csv';

            $csv_terminated = "\n";
            $csv_separator = ",";
            $csv_enclosed = '"';
            $csv_escaped = "\\";



// Gets the data from the database

            $schema_insert = '';
            foreach ($headings as $heading) {
                $l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, stripslashes($heading)) . $csv_enclosed;
                $schema_insert .= $l;
                $schema_insert .= $csv_separator;
            } // end for
            $out = trim(substr($schema_insert, 0, -1));
            $out .= $csv_terminated;



            if ($arrOrder) {

                foreach ($arrOrder as $varKey => $varValue) {
                    $schema_insert = '';
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['fkOrderID']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['SubOrderID']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Items']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CustomerName']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $objCore->localDateTime($varValue['OrderDateAdded'], DATE_FORMAT_SITE)) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ItemTotal']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Status']) . $csv_enclosed . $csv_separator;


                    $out .= $schema_insert;
                    $out .= $csv_terminated;
                }
            }



            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Length: " . strlen($out));
// Output to browser with appropriate mime type, you choose ;)
            header("Content-type: text/x-csv");
//header("Content-type: text/csv");
//header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=$filename");
            echo $out;
            exit;
        } else if ($arrPost['fileType'] == 'excel') {

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet()->setTitle('Order List');

            $varSheetName = 'order_list_' . time() . '.xls';


            $highestColumn = "XFD";
            $highestRow = "2";

            $rowNumber = 1;
            $col = 'A';
            foreach ($headings as $heading) {
                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $heading);
                $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
                $objPHPExcel->getActiveSheet()->getStyle($col . $rowNumber)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objPHPExcel->getActiveSheet()->getStyle($col . $rowNumber)->getFill()->getStartColor()->setRGB('EBEBEB');
                $col++;
            }

            if ($arrOrder) {
                $rowNumber = 2;
                $col = 'A';

                foreach ($arrOrder as $varKey => $varValue) {

                    //  $objPHPExcel->getActiveSheet()->setCellValueExplicit('A' . $rowNumber, '', PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('A' . $rowNumber, $varValue['fkOrderID'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . $rowNumber, $varValue['SubOrderID'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('C' . $rowNumber, $varValue['Items'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('D' . $rowNumber, $varValue['CustomerName'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('E' . $rowNumber, $objCore->localDateTime($varValue['OrderDateAdded'], DATE_FORMAT_SITE), PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('F' . $rowNumber, $varValue['ItemTotal'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('G' . $rowNumber, $varValue['Status'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $rowNumber++;
                }
            }

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $varSheetName . '"');
            header('Cache-Control: max-age=0');

            $objWriter->save('php://output');
            exit();
        } else {
            $objCore->setErrorMsg('File type should be CSV or Excel !');
            header('location:order_manage_uil.php');
        }
    }

}

$objPage = new OrderCtrl();
$objPage->pageLoad();
?>
