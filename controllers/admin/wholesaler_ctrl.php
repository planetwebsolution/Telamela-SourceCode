<?php

require_once CLASSES_ADMIN_PATH . 'class_wholesaler_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';
require COMPONENTS_SOURCE_ROOT_PATH . 'PHPExcel/Classes/PHPExcel.php';

class WholeSalerCtrl extends Paging {
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
        $objWholesaler = new Wholesaler();
        global $objGeneral;
       
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'],'pkWholesalerID');

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
            $arrSearchParameter = $_GET;
            $varName = $arrSearchParameter['frmName'];
            $varPhone = $arrSearchParameter['frmPhone'];
            $varStatus = $arrSearchParameter['frmStatus'];
            $varEmail = $arrSearchParameter['frmEmail'];
            $varCountry = $arrSearchParameter['frmCountry'];
            $varCountryPortal = $arrSearchParameter['frmCountryPortal'];


            if ($varName <> '') {
                $varWhereClause .= " AND CompanyName LIKE '%" . addslashes($varName) . "%'";
            }
            if ($varPhone <> '') {
                $varWhereClause .= " AND CompanyPhone LIKE '%" . $varPhone . "%'";
            }
            if ($varEmail <> '') {
                $varWhereClause .= " AND CompanyEmail LIKE '%" . $varEmail . "%'";
            }
            if ($varCountry > 0) {
                $varWhereClause .= " AND CompanyCountry = '" . $varCountry . "'";
            }

            if ($varCountryPortal <> '0-0-0') {
                $arrPortal = explode('-', $varCountryPortal);
                $varCtry = $arrPortal[1];
                $varRegion = $arrPortal[2];

                if ($varRegion > 0) {
                    $varWhereClause .= " AND CompanyRegion = '" . $varRegion . "'";
                } else if ($varCtry > 0) {
                    $varWhereClause .= " AND CompanyCountry = '" . $varCtry . "'";
                }
            }

            $varWhrClause = "WholesalerStatus='" . $varStatus . "'" . $varWhereClause. $varPortalFilter;
            //echo $varWhrClause;die;
            $this->varPageStart = $objPaging->getPageStartLimit($_GET['page'], $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;

            $arrRecords = $objWholesaler->WholesalerCount($varWhrClause);
            $this->NumberofRows = $arrRecords;
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objWholesaler->WholesalerList($varWhrClause, $this->varLimit);
            $this->varSortColumn = $objWholesaler->getSortColumn($_REQUEST);
        } else {

            $varWhrClause = " WholesalerStatus IN ('active','deactive','suspend','pending') ".$varPortalFilter;
            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = $objWholesaler->WholesalerCount($varWhrClause);
            $this->NumberofRows = $arrRecords;
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objWholesaler->WholesalerList($varWhrClause, $this->varLimit);
            //echo '<pre>'; print_r ($this->arrRows); die;
            $this->varSortColumn = $objWholesaler->getSortColumn($_REQUEST);
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
        $objWholesaler = new Wholesaler();
        //echo $_GET['id'];die;
        
       
        $this->arrCountryList = $objWholesaler->countryList();
        global $objGeneral;
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'],'pkWholesalerID');
        
        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'add' && $_GET['type'] == 'add') {   // Editing images record
            $varAddStatus = $objWholesaler->addWholesaler($_POST);
            if ($varAddStatus == 'exist') {
                $objCore->setErrorMsg('Email Already in use. Please enter different email.');
                //header('location:wholesaler_add_uil.php?type='.$_GET['type']);
                //die;
            } else if ($varAddStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_ADD_SUCCUSS_MSG);
                header('location:wholesaler_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
                //header('location:wholesaler_add_uil.php?type='.$_GET['type']);
                //die;
            }
        } else if (isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'edit' && $_GET['type'] == 'edit' && $_GET['id'] != '') {
        	
        	
            $varUpdateStatus = $objWholesaler->updateWholesaler($_POST);
           
            

            if ($varUpdateStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_UPDATE_SUCCUSS_MSG);
                header('location:wholesaler_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_UPDATE_ERROR_MSG);
                header('location:wholesaler_edit_uil.php?type=' . $_GET['type'] . '&id=' . $_GET['id']);
                die;
            }
        } else if (isset($_GET['id']) && $_GET['id'] != '' && ($_GET['type'] == 'edit')) {
        	
        	
            
            $this->arrPaidInvoiceProductDetails= $objWholesaler->arrPaidInvoiceProductDetails($_GET['id']);
            $this->arrUnPaidInvoiceProductDetails= $objWholesaler->arrUnPaidInvoiceProductDetails($_GET['id']);
           
            $this->arrSoldProductDetails= $objWholesaler->arrSoldProductDetails($_GET['id']);
            //pre('here');
            $varWhr = "pkWholesalerID='".$_GET['id']."' ".$varPortalFilter;
            $this->arrRow = $objWholesaler->editWholesaler($varWhr);
            //pre($this->arrRow);
            $current_country_id=$this->arrRow[0]['CompanyCountry'];
           
           // pre($current_country_id);
            $current_country_portal = $objGeneral->getcurrentCountryPortal($current_country_id);
           // pre($current_country_portal);
             //$this->arrShippingList = $objWholesaler->shippingGatewayList("fkportalID = " . $current_country_portal[0]['pkAdminID']);
             $this->arrShippingList = $objGeneral->countryshippingGatewayList($current_country_id);
           //pre($this->arrShippingList);
            $varWhrCountry = "fkCountryId='" . $this->arrRow[0]['CompanyCountry']."'";
            $this->arrRegion = $objWholesaler->regionList($varWhrCountry);
            $this->arrWarning = $objWholesaler->warningList($_GET['id']);
            //pre($this->arrWarning);
        }
	else if (isset($_POST['Export']) && $_POST['Export'] == 'Export') {
            $this->exportWholesaler($_POST);
        } 
	else {

            $this->getList();
            $this->CountryPortal = $objWholesaler->adminUserList();
        }
    }

// end of page load
//Export Start 
    function exportWholesaler($arrPost) {

        $objCore = new Core();
	$objWholesaler = new Wholesaler();
        $arrWholesaler = $objWholesaler->wholesalerExportList('', '');  
         //pre($arrWholesaler);
        $headings = array(
                'Company Name',
                'Company Details',
		'Services',
		'Commission',
		'Company Address1',
		'Company Address2',
		'Company City',
		'Company Country',
		'Company Region',
                'Company Postal Code',
                'Company Website',
                'Company Email',
                'Paypal Email',
                'Company Phone',
                'Company Fax',
		'Opt1 Company Address1',
		'Opt1 Company  Address2',
		'Opt1 Company City',
		'Opt1 Company Country',
		'Opt1 Company Postal Code',
		'Opt1 Company Website',
		'Opt1 Company Email',
		'Opt1 Company phone',
		'Opt1 Company Fax',
		'Opt1 Company Address1',
		'Opt1 Company Address2',
		'Opt1 Company City',
		'Opt2 Company Country',
		'Opt2 Company Postal Code',
		'Opt2 Company Website',
		'Opt2 Company Email',
		'Opt2 Company phone',
		'Opt2 Company Fax',
                'Contact Person Name',
                'Contact Person Position',
                'Contact Person Phone',
                'Contact Person Email',
                'Contact Person Address',
                'Owner Name',
                'Owner Phone',
                'Owner Email',
                'Owner Address',
                'Ref1 Name',
                'Ref1 Phone',
                'Ref1 Email',
                'Ref1 Company Name',
                'Ref1 Company Address',
                'Ref2 Name',
                'Ref2 Phone',
                'Ref2 Email',
                'Ref2 Company Name',
                'Ref2 Company Address',
                'Ref3 Name',
                'Ref3 Phone',
                'Ref3 Email',
                'Ref3 Company Name',
                'Ref3 Company Address',
		'shipping Method',
                'Wholesaler Date Added'
        );

        if ($arrPost['fileType'] == 'csv') {


            $filename = 'wholesaler_list_' . time() . '.csv';

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



            if ($arrWholesaler) {

                foreach ($arrWholesaler as $varKey => $varValue) {
			        
			        $varValue['Opt1CompanyCountry'] = $objWholesaler->findCountryName($varValue['Opt1CompanyCountry']);
			        $varValue['Opt2CompanyCountry'] = $objWholesaler->findCountryName($varValue['Opt2CompanyCountry']);
				$arrShipping = $objWholesaler->findWholesalerShippingMethod($varValue['pkWholesalerID']);
				foreach($arrShipping as $k=>$val)
				{
					$arrShipping[$k] = $val['ShippingTitle'];
				}
				$varValue['shippingMethod'] = implode(",",$arrShipping);
				$schema_insert = '';
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CompanyName']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['AboutCompany']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Services']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Commission']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CompanyAddress1']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CompanyAddress2']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CompanyCity']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CountryName']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['RegionName']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CompanyPostalCode']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CompanyWebsite']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CompanyEmail']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['PaypalEmail']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CompanyPhone']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CompanyFax']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Opt1CompanyAddress1']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Opt1CompanyAddress2']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Opt1CompanyCity']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Opt1CompanyCountry']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Opt1CompanyPostalCode']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Opt1CompanyWebsite']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Opt1CompanyEmail']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Opt1Companyphone']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Opt1CompanyFax']) . $csv_enclosed . $csv_separator; 
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Opt2CompanyAddress1']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Opt2CompanyAddress2']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Opt2CompanyCity']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Opt2CompanyCountry']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Opt2CompanyPostalCode']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Opt2CompanyWebsite']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Opt2CompanyEmail']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Opt2Companyphone']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Opt2CompanyFax']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ContactPersonName']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ContactPersonPosition']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ContactPersonPhone']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ContactPersonEmail']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ContactPersonAddress']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['OwnerName']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['OwnerPhone']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['OwnerEmail']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['OwnerAddress']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Ref1Name']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Ref1Phone']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Ref1Email']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Ref1CompanyName']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Ref1CompanyAddress']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Ref2Name']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Ref2Phone']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Ref2Email']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Ref2CompanyName']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Ref2CompanyAddress']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Ref3Name']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Ref3Phone']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Ref3Email']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Ref3CompanyName']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Ref3CompanyAddress']) . $csv_enclosed . $csv_separator;   
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['shippingMethod']) . $csv_enclosed . $csv_separator;
				$schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $objCore->localDateTime($varValue['WholesalerDateAdded'], DATE_FORMAT_SITE)) . $csv_enclosed . $csv_separator;
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
            $objPHPExcel->getActiveSheet()->setTitle('Wholesaler List');

            $varSheetName = 'wholesaler_list_' . time() . '.xls';

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

            if ($arrWholesaler) {
                $rowNumber = 2;
                $col = 'A';

                foreach ($arrWholesaler as $varKey => $varValue) {
                    
			
			$varValue['Opt1CompanyCountry'] = $objWholesaler->findCountryName($varValue['Opt1CompanyCountry']);
			$varValue['Opt2CompanyCountry'] = $objWholesaler->findCountryName($varValue['Opt2CompanyCountry']);
			$arrShipping = $objWholesaler->findWholesalerShippingMethod($varValue['pkWholesalerID']);
			foreach($arrShipping as $k=>$val)
			{
				$arrShipping[$k] = $val['ShippingTitle'];
			}
			$varValue['shippingMethod'] = implode(",",$arrShipping);
			//pre($varValue);
                    //  $objPHPExcel->getActiveSheet()->setCellValueExplicit('A' . $rowNumber, '', PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('A' . $rowNumber, $varValue['CompanyName'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . $rowNumber, $varValue['AboutCompany'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('C' . $rowNumber, $varValue['Services'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('D' . $rowNumber, $varValue['Commission'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('E' . $rowNumber, $varValue['CompanyAddress1'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('F' . $rowNumber, $varValue['CompanyAddress2'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('G' . $rowNumber, $varValue['CompanyCity'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('H' . $rowNumber, $varValue['CountryName'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('I' . $rowNumber, $varValue['RegionName'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('J' . $rowNumber, $varValue['CompanyPostalCode'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('K' . $rowNumber, $varValue['CompanyWebsite'], PHPExcel_Cell_DataType::TYPE_STRING);  
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('L' . $rowNumber, $varValue['CompanyEmail'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('M' . $rowNumber, $varValue['PaypalEmail'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('N' . $rowNumber, $varValue['CompanyPhone'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('O' . $rowNumber, $varValue['CompanyFax'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('P' . $rowNumber, $varValue['Opt1CompanyAddress1'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('Q' . $rowNumber, $varValue['Opt1CompanyAddress2'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('R' . $rowNumber, $varValue['Opt1CompanyCity'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('S' . $rowNumber, $varValue['Opt1CompanyCountry'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('T' . $rowNumber, $varValue['Opt1CompanyPostalCode'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('U' . $rowNumber, $varValue['Opt1CompanyWebsite'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('V' . $rowNumber, $varValue['Opt1CompanyEmail'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('W' . $rowNumber, $varValue['Opt1Companyphone'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('X' . $rowNumber, $varValue['Opt1CompanyFax'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('Y' . $rowNumber, $varValue['Opt2CompanyAddress1'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('Z' . $rowNumber, $varValue['Opt2CompanyAddress2'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AA' . $rowNumber, $varValue['Opt2CompanyCity'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AB' . $rowNumber, $varValue['Opt2CompanyCountry'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AC' . $rowNumber, $varValue['Opt2CompanyPostalCode'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AD' . $rowNumber, $varValue['Opt2CompanyWebsite'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AE' . $rowNumber, $varValue['Opt2CompanyEmail'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AF' . $rowNumber, $varValue['Opt2Companyphone'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AG' . $rowNumber, $varValue['Opt2CompanyFax'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AH' . $rowNumber, $varValue['ContactPersonName'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AI' . $rowNumber, $varValue['ContactPersonPosition'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AJ' . $rowNumber, $varValue['ContactPersonPhone'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AK' . $rowNumber, $varValue['ContactPersonEmail'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AL' . $rowNumber, $varValue['ContactPersonAddress'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AM' . $rowNumber, $varValue['OwnerName'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AN' . $rowNumber, $varValue['OwnerPhone'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AO' . $rowNumber, $varValue['OwnerEmail'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AP' . $rowNumber, $varValue['OwnerAddress'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AQ' . $rowNumber, $varValue['Ref1Name'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AR' . $rowNumber, $varValue['Ref1Phone'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AS' . $rowNumber, $varValue['Ref1Email'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AT' . $rowNumber, $varValue['Ref1CompanyName'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AU' . $rowNumber, $varValue['Ref1CompanyAddress'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AV' . $rowNumber, $varValue['Ref2Name'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AW' . $rowNumber, $varValue['Ref2Phone'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AX' . $rowNumber, $varValue['Ref2Email'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AY' . $rowNumber, $varValue['Ref2CompanyName'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AZ' . $rowNumber, $varValue['Ref2CompanyAddress'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('BA' . $rowNumber, $varValue['Ref3Name'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('BB' . $rowNumber, $varValue['Ref3Phone'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('BC' . $rowNumber, $varValue['Ref3Email'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('BD' . $rowNumber, $varValue['Ref3CompanyName'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('BE' . $rowNumber, $varValue['Ref3CompanyAddress'], PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->getActiveSheet()->setCellValueExplicit('BF' . $rowNumber, $varValue['shippingMethod'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('BG' . $rowNumber, $objCore->localDateTime($varValue['WholesalerDateAdded'], DATE_FORMAT_SITE), PHPExcel_Cell_DataType::TYPE_STRING);
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
            header('location:wholesaler_manage_uil.php');
        }
    }
}

$objPage = new WholeSalerCtrl();
$objPage->pageLoad();

//print_r($objPage->arrRow[0]);
?>
