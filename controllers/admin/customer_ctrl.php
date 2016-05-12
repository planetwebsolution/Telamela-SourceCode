<?php

require_once CLASSES_ADMIN_PATH . 'class_customer_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';
require COMPONENTS_SOURCE_ROOT_PATH . 'PHPExcel/Classes/PHPExcel.php';
//pre("custoemr");
//this is used when creat new country table.
// $objcustomer = new customer();
// $arrRecords = $objcustomer->changetable();
// foreach($arrRecords as $data)
// {
//     $arrRecords = $objcustomer->changerecord($data);
////     echo "UPDATE `tbl_country` SET `iso_code_2`=[value-3],"
////     . "`iso_code_3`=[value-4],`address_format`=[value-5],"
////     . "`postcode_required`=[value-6],`zone`=[value-7],"
////             . "`time_zone`=[value-8],`status`=[value-9] WHERE name=".$data['name'] .'</br>';
// }
 //die();
 //pre($arrRecords);

class customerCtrl extends Paging {
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
        $objcustomer = new customer();
        
        //pre('22222');
        //pre($_SESSION);
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

       
        if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') {
            //echo "hello";

            $arrSearchParameter = $_GET;
            //$varWhereClause="";

            $varName = $arrSearchParameter['CustomerFirstName'];
            $varPhone = $arrSearchParameter['BillingPhone'];
            $varEmail = $arrSearchParameter['CustomerEmail'];

            if ($varName <> '') {
                $varWhereClause .= " AND CustomerFirstName LIKE '%" . addslashes($varName) . "%'";
            }
            if ($varPhone <> '') {
                $varWhereClause .= " AND BillingPhone LIKE '%" . $varPhone . "%'";
            }
            if ($varEmail <> '') {
                $varWhereClause .= " AND CustomerEmail LIKE '%" . $varEmail . "%'";
            }


            $varWhereClauses = "CustomerStatus in('Active','Deactive') " . $varWhereClause;
            $this->varPageStart = $objPaging->getPageStartLimit($_GET['page'], $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;

            $arrRecords = $objcustomer->customerList($varWhereClauses, '');

            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objcustomer->customerList($varWhereClauses, $this->varLimit);
            $this->varSortColumn = $objcustomer->getSortColumn($_REQUEST);
        } else {

            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = $objcustomer->customerList($varWhr, $limit = '');
            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objcustomer->customerList($varWhr, $this->varLimit);
            $this->varSortColumn = $objcustomer->getSortColumn($_REQUEST);
            // echo '<pre>';print_r($this->arrRows);die;
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
        $objcustomer = new customer();
         
        $this->arrRows = $objcustomer->customerList($varWhr = '', $this->varLimit);
        $this->NumberofRows = count($objcustomer->customerList($varWhr = '', $this->varLimit));
        $this->getList();


        $this->arrShippingList = $objcustomer->shippingGatewayList();
        $this->arrCountryList = $objcustomer->countryList();

        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'add' && $_GET['type'] == 'add') {
        // Editing images record
            $varAddStatus = $objcustomer->addCustomer($_POST);
            if ($varAddStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_ADD_SUCCUSS_MSG);
                header('location:customer_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
                //header('location:customer_add_uil.php?type=' . $_GET['type']);
                //die;
            }
        } else if (isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'edit' && $_GET['type'] == 'edit' && $_GET['id'] != '') {

            $varUpdateStatus = $objcustomer->updateCustomer($_POST);

            if ($varUpdateStatus == 1) {
                $objCore->setSuccessMsg(ADMIN_UPDATE_SUCCUSS_MSG);
                header('location:customer_manage_uil.php');
                die;
            } else if ($varUpdateStatus == 'email_exists') {
                $objCore->setErrorMsg(ADMIN_USE_EMAIL_ALREADY_EXIST);
                //header('location:customer_edit_uil.php?type=' . $_GET['type'] . '&id=' . $_GET['id']);
                //die;
            } else if ($varUpdateStatus == 'password_not_match') {
                $objCore->setErrorMsg(ADMIN_USE_PASSWORD_NOT_MATCH);
                //header('location:customer_edit_uil.php?type=' . $_GET['type'] . '&id=' . $_GET['id']);
                //die;
            }
        }
        if (isset($_GET['id']) && $_GET['id'] != '' && ($_GET['type'] == 'edit')) {
            $varWhr = $_GET['id'];
            $this->arrRow = $objcustomer->editCustomer($varWhr);
            //$varWhrCountry = 'fkCountryId='.$this->arrRow[0]['CompanyCountry'];
            //$this->arrRegion = $objWholesaler->regionList($varWhrCountry);
            //$this->arrWarning = $objWholesaler->warningList($varWhr);
            //pre($this->arrWarning);
        }
        else if (isset($_GET['id']) && $_GET['id'] != '' && ($_GET['type'] == 'view')) {
        	$varWhr = $_GET['id'];
            $this->arrRow = $objcustomer->customerDetails($varWhr);
            //echo '<pre>'; print_r($this->arrRow[0]['pkCustomerID']); die;
            $this->arrTotalPurchase = $objcustomer->totalPurchase($_GET['id']);
            $this->arrTotalReward = $objcustomer->totalReward1($_GET['id']);
            $this->wishlistItem = $objcustomer->getWishlistProducts($_GET['id']);
            $this->cartItems = $objcustomer->customerCartDetails($_GET['id']);
        } else if (isset($_POST['Export']) && $_POST['Export'] == 'Export') {
            $this->exportCustomer($_POST);
        } else {
            //pre('111111');
            $this->getList();
            $this->CountryPortal = $objcustomer->adminUserList();
        }
    }

    //Export Start 
    function exportCustomer($arrPost) {

        $objCore = new Core();
        $objcustomer = new customer();
        $arrCustomer = $objcustomer->customerExportList('', '');
        //pre($arrCustomer);
        $headings = array(
            'Customer First Name',
            'Customer Last Name',
            'Customer Email',
            'Billing First Name',
            'Billing Last Name',
            'Billing Organization Name',
            'Billing Address Line1',
            'Billing Address Line2',
            'Billing Country',
            'Billing Postal Code',
            'Billing Phone',
            'Shipping First Name',
            'Shipping Last Name',
            'Shipping Organization Name',
            'Shipping Address Line1',
            'Shipping Address Line2',
            'Shipping Country',
            'Shipping Postal Code',
            'Shipping Phone',
            'Business Address',
            'Customer Status',
            'Purchased',
            'CustomerDateAdded',
        );
        if ($arrPost['fileType'] == 'csv') {


            $filename = 'customer_list_' . time() . '.csv';

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



            if ($arrCustomer) {

                foreach ($arrCustomer as $varKey => $varValue) {
                    $schema_insert = '';
                    $varValue['BillingCountry'] = $objcustomer->findCountryName($varValue['BillingCountry']);
                    $varValue['ShippingCountry'] = $objcustomer->findCountryName($varValue['ShippingCountry']);
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CustomerFirstName']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CustomerLastName']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CustomerEmail']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['BillingFirstName']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['BillingLastName']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['BillingOrganizationName']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['BillingAddressLine1']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['BillingAddressLine2']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['BillingCountry']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['BillingPostalCode']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['BillingPhone']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ShippingFirstName']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ShippingLastName']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ShippingOrganizationName']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ShippingAddressLine1']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ShippingAddressLine2']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ShippingCountry']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ShippingPostalCode']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ShippingPhone']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['BusinessAddress']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CustomerStatus']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Purchased']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $objCore->localDateTime($varValue['CustomerDateAdded'], DATE_FORMAT_SITE)) . $csv_enclosed . $csv_separator;
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
            $objPHPExcel->getActiveSheet()->setTitle('Customer List');

            $varSheetName = 'customer_list_' . time() . '.xls';

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

            if ($arrCustomer) {
                $rowNumber = 2;
                $col = 'A';

                foreach ($arrCustomer as $varKey => $varValue) {

                    //  $objPHPExcel->getActiveSheet()->setCellValueExplicit('A' . $rowNumber, '', PHPExcel_Cell_DataType::TYPE_STRING);
                    $varValue['BillingCountry'] = $objcustomer->findCountryName($varValue['BillingCountry']);
                    $varValue['ShippingCountry'] = $objcustomer->findCountryName($varValue['ShippingCountry']);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('A' . $rowNumber, $varValue['CustomerFirstName'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . $rowNumber, $varValue['CustomerLastName'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('C' . $rowNumber, $varValue['CustomerEmail'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('D' . $rowNumber, $varValue['BillingFirstName'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('E' . $rowNumber, $varValue['BillingLastName'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('F' . $rowNumber, $varValue['BillingOrganizationName'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('G' . $rowNumber, $varValue['BillingAddressLine1'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('H' . $rowNumber, $varValue['BillingAddressLine2'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('I' . $rowNumber, $varValue['BillingCountry'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('J' . $rowNumber, $varValue['BillingPostalCode'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('K' . $rowNumber, $varValue['BillingPhone'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('L' . $rowNumber, $varValue['ShippingFirstName'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('M' . $rowNumber, $varValue['ShippingLastName'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('N' . $rowNumber, $varValue['ShippingOrganizationName'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('O' . $rowNumber, $varValue['ShippingAddressLine1'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('P' . $rowNumber, $varValue['ShippingAddressLine2'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('Q' . $rowNumber, $varValue['ShippingCountry'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('R' . $rowNumber, $varValue['ShippingPostalCode'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('S' . $rowNumber, $varValue['ShippingPhone'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('T' . $rowNumber, $varValue['BusinessAddress'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('U' . $rowNumber, $varValue['CustomerStatus'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('V' . $rowNumber, $varValue['Purchased'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('W' . $rowNumber, $objCore->localDateTime($varValue['CustomerDateAdded'], DATE_FORMAT_SITE), PHPExcel_Cell_DataType::TYPE_STRING);
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
            header('location:customer_manage_uil.php');
        }
    }

// end of page load
}

$objPage = new customerCtrl();
$objPage->pageLoad();
//print_r($objPage->arrRow[0]);
?>
