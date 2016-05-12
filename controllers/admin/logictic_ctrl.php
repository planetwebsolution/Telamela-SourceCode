<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_logisticinvoice_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require COMPONENTS_SOURCE_ROOT_PATH . 'PHPExcel/Classes/PHPExcel.php';

class LogisticInvoiceCtrl extends Paging {
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
        $objInvoice = new LogisticInvoice();
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

        if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') {
            $arrSearchParameter = $_GET;
            
            $invoiceID = $arrSearchParameter['invoiceID'];
            $cName = $arrSearchParameter['cName'];
            $orderId = $arrSearchParameter['orderId'];
            $amount = $arrSearchParameter['amount'];
            $iDateFrom = $arrSearchParameter['iDateFrom'];
            $iDateTo = $arrSearchParameter['iDateTo'];
            $oDateFrom = $arrSearchParameter['oDateFrom'];
            $oDateTo = $arrSearchParameter['oDateTo'];
//echo '<pre>';print_r($_GET);die;
            $varWhereClause = " where pkInvoiceID != '' ";
            
            if ($invoiceID <> '') {
                $varWhereClause .= " AND pkInvoiceID LIKE '%" . addslashes($invoiceID) . "%'";
            }
            if ($cName <> '') {
                $varWhereClause .= " AND customerfullname LIKE '%" . addslashes($cName) . "%'";
            }
            if ($orderId <> '') {
                $varWhereClause .= " AND fkOrderID LIKE '%" . addslashes($orderId) . "%'";
            }
            if ($amount <> '') {
                $varWhereClause .= " AND shippingAmount >= '" . addslashes($amount) . "'";
            }
            if ($iDateFrom <> DATE_NULL_VALUE_SITE && $iDateTo <> DATE_NULL_VALUE_SITE && $iDateFrom<>'' && $iDateTo<>'') {
                $varFrm = date('Y-m-d', strtotime($iDateFrom));
                $varTo = date('Y-m-d', strtotime($iDateTo));
                $varWhereClause .= "AND DATE_FORMAT(shippingDate,'%Y-%m-%d') BETWEEN '" . addslashes($varFrm) . "' AND '" . addslashes($varTo) . "'";
            }

            if ($oDateFrom <> DATE_NULL_VALUE_SITE && $oDateTo <> DATE_NULL_VALUE_SITE && $oDateFrom<>'' && $oDateTo<>'') {
                $varFrm = date('Y-m-d', strtotime($oDateFrom));
                $varTo = date('Y-m-d', strtotime($oDateTo));
                $varWhereClause .= " AND DATE_FORMAT(OrderDateAdded,'%Y-%m-%d') BETWEEN '" . addslashes($varFrm) . "' AND '" . addslashes($varTo) . "'";
            }

            $varWhrClause = $varWhereClause.$varPortalFilter;
            //echo $varWhrClause;die;

            $this->varPageStart = $objPaging->getPageStartLimit($_GET['page'], $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;

            $arrRecords = $objInvoice->invoiceList($varWhrClause, '');

            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objInvoice->invoiceList($varWhrClause, $this->varLimit);
        } else {
        	//die("here");
        	$varWhereClause = " where pkInvoiceID != '' ";
        	
             $varWhrClause = $varWhereClause.$varPortalFilter;
             
            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = $objInvoice->invoiceList($varWhrClause, $limit = '');

            $this->NumberofRows = count($arrRecords);

            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objInvoice->invoiceList($varWhrClause, $this->varLimit);
            $this->shippingcompanyname=$objInvoice->getshippingcompanyname($this->arrRows[0]['fkShippingGatewaysID']);
            $this->Customername=$objInvoice->getCustomername($this->arrRows[0]['CustomerID']);
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
        $objInvoice = new LogisticInvoice();
		
        global $objGeneral;
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs']);
		
       //pre($_REQUEST);
        if (isset($_GET['id']) && $_GET['id'] != '' && ($_GET['type'] == 'view')) {
        	//pre("here");
        	
            $varID = $_GET['id'];
           
            $orderid=$objInvoice->getorderid1($varID);
           
            $this->arrorderdata=$objInvoice->getorderdata($orderid[0]['fkOrderID']);
            //pre($this->arrorderdata);
           $this->arrlogistic= $logisticinvoicedata=$objInvoice->getlogisticinvoicedata($varID);
          // pre($this->arrlogistic); 
          // $this->arrorderdataitem=$objInvoice->getorderdataitem($this->arrlogistic[0]['fkSubOrderID'],$orderid[0]['fkOrderID']);
           $this->arrorderdataitem=$objInvoice->getorderdataitem1($varID,$orderid[0]['fkOrderID']);
            $productdata=json_decode($this->arrorderdataitem[0]['ItemDetails']);
            $productid=$productdata[0]->pkProductID;
            $this->arrproductweight=$objInvoice->getproductweight($productid);
           // pre($this->arrorderdataitem);
           // $this->arrRow = $objInvoice->viewInvoice($varID,$varPortalFilter);
            //pre($this->arrRow);
        } 
         else if (isset($_POST['Export']) && $_POST['Export'] == 'Export') {
             $this->exportInvoice($_POST);
         }else {
             $this->getList();
         }
    }

// end of page load
    //Export Start 
    function exportInvoice($arrPost) {

        $objCore = new Core();
        $objInvoice = new LogisticInvoice();

        $arrInvoice = $objInvoice->invoiceList('', '');
        //pre($arrInvoice);
        $headings = array(
            'Logistic ID',
            'Order ID',
            'Sub Order ID',
            'Order Date',
            'Customer Name',
			'Logistic Company Name',
            'Shipping Amount('.ADMIN_CURRENCY_SYMBOL.')',
			'Status'
        );

        if ($arrPost['fileType'] == 'csv') {


            $filename = 'logistic_list_' . time() . '.csv';

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



            if ($arrInvoice) {

                foreach ($arrInvoice as $varKey => $varValue) {
					
					$customername_array = $objInvoice->getCustomername($varValue['CustomerID']); 
					$customername = $customername_array[0]['CustomerFirstName']." " . $customername_array[0]['CustomerLastName'];
					
					$companyname_array = $objInvoice->getshippingcompanyname($varValue['fkShippingGatewaysID']);
					$companyname = $companyname_array[0]['ShippingTitle'];
					
                    $schema_insert = '';
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['pkInvoiceID']) . $csv_enclosed . $csv_separator;
                    //$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $objCore->localDateTime($varValue['InvoiceDateAdded'], DATE_FORMAT_SITE)) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['fkOrderID']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['fkSubOrderID']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $objCore->localDateTime($varValue['OrderDateAdded'], DATE_FORMAT_SITE)) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $customername) . $csv_enclosed . $csv_separator;
					$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $companyname) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['shippingAmount']) . $csv_enclosed . $csv_separator;
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
            $objPHPExcel->getActiveSheet()->setTitle('Invoice List');

            $varSheetName = 'invoice_list_' . time() . '.xls';

            $highestColumn = "XFD";
            $highestRow = "1";

            $rowNumber = 1;
            $col = 'A';
            foreach ($headings as $heading) {
                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $heading);
                $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
                $objPHPExcel->getActiveSheet()->getStyle($col . $rowNumber)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objPHPExcel->getActiveSheet()->getStyle($col . $rowNumber)->getFill()->getStartColor()->setRGB('EBEBEB');
                $col++;
            }

            if ($arrInvoice) {
                $rowNumber = 2;
                $col = 'A';

                foreach ($arrInvoice as $varKey => $varValue) {
					
					
					$customername_array = $objInvoice->getCustomername($varValue['CustomerID']); 
					$customername = $customername_array[0]['CustomerFirstName']." " . $customername_array[0]['CustomerLastName'];
					
					$companyname_array = $objInvoice->getshippingcompanyname($varValue['fkShippingGatewaysID']);
					$companyname = $companyname_array[0]['ShippingTitle'];

                    //  $objPHPExcel->getActiveSheet()->setCellValueExplicit('A' . $rowNumber, '', PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('A' . $rowNumber, $varValue['pkInvoiceID'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . $rowNumber, $varValue['fkOrderID'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('C' . $rowNumber, $varValue['fkSubOrderID'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('D' . $rowNumber, $objCore->localDateTime($varValue['OrderDateAdded'], DATE_FORMAT_SITE), PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('E' . $rowNumber, $customername, PHPExcel_Cell_DataType::TYPE_STRING);
					 $objPHPExcel->getActiveSheet()->setCellValueExplicit('F' . $rowNumber, $companyname, PHPExcel_Cell_DataType::TYPE_STRING);
					 $objPHPExcel->getActiveSheet()->setCellValueExplicit('G' . $rowNumber, $varValue['shippingAmount'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('H' . $rowNumber, $varValue['Status'], PHPExcel_Cell_DataType::TYPE_STRING);
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
            header('location:invoice_manage_uil.php');
        }
    }

}

$objPage = new LogisticInvoiceCtrl();
$objPage->pageLoad();
?>
