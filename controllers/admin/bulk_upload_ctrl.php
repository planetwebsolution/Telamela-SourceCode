<?php

/**
 * BulkUploadCtrl class controller.
 */
session_start();
ob_start();
require_once CLASSES_ADMIN_PATH . 'class_bulk_upload_bll.php';
#require_once SOURCE_ROOT . 'common/excel/simplexlsx.class.php';
require_once(CLASSES_PATH . 'class_common.php');
require_once(CLASSES_PATH . 'excel_reader.php');
//require_once CLASSES_SYSTEM_PATH.'class_paging_bll.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'class_upload_inc.php';

class BulkUploadCtrl {
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
        $zipDest = $zipExtractDest = UPLOADED_FILES_SOURCE_PATH . "images/temp_product/";
        $objBulkUpload = new BulkUpload();
        $this->attributesList = $objBulkUpload->getAttributesList();
        if (isset($_POST['frmHidenUpload']) && $_POST['frmHidenUpload'] == 'Upload') {   // Editing images record
            //echo '<pre>';
            //pre($_POST);
            //print_r($_FILES);
            $varTempName = $_FILES['frmFile']['tmp_name'];

            //find file extention            
            $arrName = explode('.', $_FILES['frmFile']['name']);
            $ext = end($arrName);

            // for csv file
            if ($ext == 'csv') {
                switch ($_POST['frmContentName']) {
                    case 'product':
                        $arrUploadRes = $this->productUploadCSV($varTempName);
                        break;
                    case 'wholesalers':
                        $arrUploadRes = $this->wholesalerUploadCSV($varTempName);
                        break;
                    case 'category':
                        $arrUploadRes = $this->categoryUploadCSV($varTempName);
                        break;
                    case 'customers':
                        $arrUploadRes = $this->customerUploadCSV($varTempName);
                        break;
                    case 'packages':
                        $arrUploadRes = $this->packageUploadCSV($varTempName);
                        break;
                    default:
                        $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
                        header('location:bulk_upload_uil.php');
                        die;
                }
            } else if ($ext == 'xls' || $ext == 'xlsx' || $ext == 'ods') {
                // for xls and xlsx file

                switch ($_POST['frmContentName']) {
                    case 'product':
                        $arrUploadRes = $this->productUploadXLS($varTempName);
                        break;
                    case 'wholesalers':
                        $arrUploadRes = $this->wholesalerUploadXLS($varTempName);
                        break;
                    case 'category':
                        $arrUploadRes = $this->categoryUploadXLS($varTempName);
                        break;
                    case 'customers':
                        $arrUploadRes = $this->customerUploadXLS($varTempName);
                        break;
                    case 'packages':
                        $arrUploadRes = $this->packageUploadXLS($varTempName);
                        break;
                    default:
                        $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
                        header('location:bulk_upload_uil.php');
                        die;
                }
            } else {
                // for other file 

                $objCore->setErrorMsg('Please upload valid file!');
                header('location:bulk_upload_uil.php');
                die;
            }

            exit;
        } else {

            $this->getList();
        }
    }

// end of page load

    /**
     * function product Upload via xls or xlsx file
     *
     * This function store products details from XLS file.
     *
     * Database Tables used in this function are : None     
     * @access public
     *
     * @return string varFileName
     */
    function productUploadXLS($argTempFileName) {
        $objCore = new Core();
        $objBulkUpload = new BulkUpload();
        $zipExtractDest = UPLOADED_FILES_SOURCE_PATH . "images/temp_product/";
        $zipDest = $zipExtractDest;
        if (!empty($_FILES['frmImages']['name'])) {
            move_uploaded_file($_FILES['frmImages']['tmp_name'], $zipExtractDest . "temp.zip");
            $zipSource = $zipExtractDest . "temp.zip";
            system("unzip -qd " . $zipDest . " " . $zipSource);
            $data = new Spreadsheet_Excel_Reader($argTempFileName);
            $row_ctr = 0;
//            pre($data->sheets[0]['cells']);
            foreach ($data->sheets[0]['cells'] as $varTempArray) {
                /* $kk = 0;
                  foreach ($varTempArray as $tempVal) {
                  $varTempArray2[$kk] = $tempVal;
                  $kk++;
                  } */
                $row_ctr++;
                // want to skip first row
                if ($row_ctr == 1) {
                    continue;
                }
                $validation_error= array();

                foreach ($_POST['fields'] as $key => $val) {
                    $dataArray[$val] = isset($varTempArray[$key + 1]) ? $varTempArray[$key + 1] : ''; //$varTempArray2[$key];
                }
                //pre($dataArray);
                if(empty($dataArray['ProductRefNo']))
                {
                    $validation_error[]='ProductRefNo';
                }
                if(empty($dataArray['ProductName']))
                {
                    $validation_error[]='ProductName';
                }
                if(empty($dataArray['fkWholesalerID']))
                {
                    $validation_error[]='Company Name';
                }
                if(empty($dataArray['WholesalePrice']))
                {
                    $validation_error[]='WholesalePrice';
                }
                if(empty($dataArray['fkCategoryID']))
                {
                    $validation_error[]='category';
                }
                if(empty($dataArray['fkShippingID']))
                {
                    $validation_error[]='Shipping Method';
                }
                if(empty($dataArray['Quantity']))
                {
                    $validation_error[]='Stock Quantity';
                }
                 if(empty($dataArray['Quantity']))
                {
                    $validation_error[]='Stock Quantity';
                }
                 if(empty($dataArray['QuantityAlert']))
                {
                    $validation_error[]=' Alert Stock Quantity';
                }
                if(empty($dataArray['ProductImage']))
                {
                    $validation_error[]='Default Product Image';
                }
                
                if(!empty($validation_error))
                {
                   $errorMsg .= "Product  on row number ( " . $row_ctr . " ) was failed to upload due to " . implode(", ",$validation_error); 
                   break;
                }
//                if ($row_ctr == 3)
                //pre($dataArray);
                if ($dataArray['ProductRefNo'] && $dataArray['ProductName'] && $dataArray['WholesalePrice'] && $dataArray['Quantity'] && $dataArray['fkCategoryID'] && $dataArray['fkShippingID']) {
                    $dataArray['fkCategoryID'] = $objBulkUpload->findCategory($dataArray['fkCategoryID']);
                    $dataArray['fkWholesalerID'] = $objBulkUpload->findWholesaler($dataArray['fkWholesalerID']);
                    $dataArray['fkShippingID'] = $objBulkUpload->findShippingGateway($dataArray['fkShippingID']);
                    $checkReferenceNumber = $objBulkUpload->isUniqueReferenceNumber($dataArray['ProductRefNo']);
                    
                    if(!$checkReferenceNumber)
                        continue;
                    
//                    pre($dataArray);
                    if ($dataArray['fkCategoryID'] && $dataArray['fkShippingID'] !='' && $dataArray['fkWholesalerID']) {


                        $productAttributes = explode(";", $dataArray['Attribute']);
                        $processAttributesInventory = $dataArray['AttributeInventory'];
                        unset($dataArray['Attribute'], $dataArray['AttributeInventory']);

                        $processedData = $this->processDataArray($dataArray);
                        $attributesTempArray = array();

                        if ($productAttributes) {

                            foreach ($productAttributes AS $prodAttribute) {
                                if (strstr($prodAttribute, "#")) {
                                    $dataAttribOptions = explode('#', $prodAttribute);
                                    //pre($dataAttribOptions);
                                    $attrRes = $objBulkUpload->getAttributeId($dataAttribOptions[0], $dataArray['fkCategoryID']);
                                    //pre($attrRes);
                                    if ($attrRes['pkAttributeID'] > 0) {
                                        $attributesTempArray[$attrRes['pkAttributeID']]['pkAttributeID'] = $attrRes['pkAttributeID'];
                                        $attributesTempArray[$attrRes['pkAttributeID']]['AttributeInputType'] = $attrRes['AttributeInputType'];
                                        $attributesTempArray[$attrRes['pkAttributeID']]['AttributeCode'] = $attrRes['AttributeCode'];
                                        $attributesTempArray[$attrRes['pkAttributeID']]['options'] = $dataAttribOptions[1];
                                    }
                                    //pre($attributesTempArray);
                                }
                            }
                        }



                        $processedImages = explode(',', $dataArray['ImageName']);
                        array_unshift($processedImages, $processedData['ProductImage']);
                        unset($processedData['ImageName'], $processedData['ProductImage']);
                        $processedAttributes = array();

                        $processedAttributes = $this->processAttributeArray($attributesTempArray);

                        $arrAddID = $objBulkUpload->bulkUploadProduct($processedData, $_POST['frmContentName'], $processedAttributes, $processAttributesInventory, $processedImages, $zipDest);
                    } else {
                        $errorMsg .= "Product with reference number ( " . $dataArray['ProductRefNo'] . " ) on row number ( " . $row_ctr . " ) was failed to upload." . "<br/>";
                    }
                } else {
                    $errorMsg .= "Product with reference number ( " . $dataArray['ProductRefNo'] . " ) on row number ( " . $row_ctr -= 1 . " ) was failed to upload." . "<br/>";
                }
            }
        } else {
            $errorMsg .= "Please upload a zip file of images" . "<br/>";
        }
        if (empty($errorMsg)) {
            $successMsg = "Products uploaded successfully.";
            $objCore->setSuccessMsg($successMsg);
        } else {
            $objCore->setErrorMsg($errorMsg);
            
        }
        $objBulkUpload->recursiveRemoveDirectory($zipDest);
        header('location:bulk_upload_uil.php');
        die;
    }

    /*
     * function product Upload via CSV file
     *
     * This function store product details into database from a CSV file.
     *
     * Database Tables used in this function are : None    
     * @access public
     *
     * @return string varFileName
     */

    function productUploadCSV($argTempFileName) {
        $objCore = new Core();
        $objBulkUpload = new BulkUpload();
        $zipExtractDest = UPLOADED_FILES_SOURCE_PATH . "images/temp_product/";
        $zipDest = $zipExtractDest;
        if (!empty($_FILES['frmImages']['name'])) {
            move_uploaded_file($_FILES['frmImages']['tmp_name'], $zipExtractDest . "temp.zip");
            $zipDest = $zipExtractDest;
            $zipSource = $zipExtractDest . "temp.zip";

            system("unzip -qd " . $zipDest . " " . $zipSource);
            $handle = fopen($argTempFileName, "r");
            $count = 0;
            $errorMsg = "";
            while ($data = fgetcsv($handle)) {
                if ($count == 0) {
                    $count++;
                    continue;
                }$count++;
                $arrClms = array();
                foreach ($_POST['fields'] as $key => $val) {
                    $dataArray[$val] = $data[$key];
                }
                
                $validation_error= array();
                if(empty($dataArray['ProductRefNo']))
                {
                    $validation_error[]='ProductRefNo';
                }
                if(empty($dataArray['ProductName']))
                {
                    $validation_error[]='ProductName';
                }
                if(empty($dataArray['fkWholesalerID']))
                {
                    $validation_error[]='Company Name';
                }
                if(empty($dataArray['WholesalePrice']))
                {
                    $validation_error[]='WholesalePrice';
                }
                if(empty($dataArray['fkCategoryID']))
                {
                    $validation_error[]='category';
                }
                if(empty($dataArray['fkShippingID']))
                {
                    $validation_error[]='Shipping Method';
                }
                if(empty($dataArray['Quantity']))
                {
                    $validation_error[]='Stock Quantity';
                }
                 if(empty($dataArray['Quantity']))
                {
                    $validation_error[]='Stock Quantity';
                }
                 if(empty($dataArray['QuantityAlert']))
                {
                    $validation_error[]=' Alert Stock Quantity';
                }
                if(empty($dataArray['ProductImage']))
                {
                    $validation_error[]='Default Product Image';
                }
                
                if(!empty($validation_error))
                {
                    $a=$count-= 1;
                   $errorMsg .= "Product  on row number ( " . $a . " ) was failed to upload due to " . implode(", ",$validation_error); 
                   break;
                }
                if ($dataArray['ProductRefNo'] && $dataArray['ProductName'] && $dataArray['WholesalePrice'] && $dataArray['Quantity'] && $dataArray['fkCategoryID'] && $dataArray['fkShippingID']) {
                    $dataArray['fkCategoryID'] = $objBulkUpload->findCategory($dataArray['fkCategoryID']);
                    $dataArray['fkWholesalerID'] = $objBulkUpload->findWholesaler($dataArray['fkWholesalerID']);
                    $dataArray['fkShippingID'] = $objBulkUpload->findShippingGateway($dataArray['fkShippingID']);
                    //$dataArray['HtmlEditor'] = htmlentities($dataArray['HtmlEditor']);
                    $checkReferenceNumber = $objBulkUpload->isUniqueReferenceNumber($dataArray['ProductRefNo']);
                   //echo $checkReferenceNumber;
                   //die; 
                     if(!$checkReferenceNumber)
                        continue;
                     
                    if ($dataArray['fkCategoryID'] && $dataArray['fkShippingID']!='' && $dataArray['fkWholesalerID']) {
                        $productAttributes = explode(";", $dataArray['Attribute']);
                        $processAttributesInventory = $dataArray['AttributeInventory'];
                        unset($dataArray['Attribute'], $dataArray['AttributeInventory']);

                        $processedData = $this->processDataArray($dataArray);
                        $attributesTempArray = array();

                        if ($productAttributes) {

                            foreach ($productAttributes AS $prodAttribute) {
                                if (strstr($prodAttribute, "#")) {
                                    $dataAttribOptions = explode('#', $prodAttribute);

                                    $attrRes = $objBulkUpload->getAttributeId($dataAttribOptions[0], $dataArray['fkCategoryID']);

                                    if ($attrRes['pkAttributeID'] > 0) {
                                        $attributesTempArray[$attrRes['pkAttributeID']]['pkAttributeID'] = $attrRes['pkAttributeID'];
                                        $attributesTempArray[$attrRes['pkAttributeID']]['AttributeInputType'] = $attrRes['AttributeInputType'];
                                        $attributesTempArray[$attrRes['pkAttributeID']]['AttributeCode'] = $attrRes['AttributeCode'];
                                        $attributesTempArray[$attrRes['pkAttributeID']]['options'] = $dataAttribOptions[1];
                                    }
                                }
                            }
                        }

                        // pre($productAttributes);                        

                        $processedImages = explode(',', $dataArray['ImageName']);
                        array_unshift($processedImages, $processedData['ProductImage']);
                        unset($processedData['ImageName'], $processedData['ProductImage']);
                        $processedAttributes = array();

                        $processedAttributes = $this->processAttributeArray($attributesTempArray);


                        $arrAddID = $objBulkUpload->bulkUploadProduct($processedData, $_POST['frmContentName'], $processedAttributes, $processAttributesInventory, $processedImages, $zipDest);
                    } else {
                        $errorMsg .= "Product with reference number ( " . $dataArray['ProductRefNo'] . " ) on row number ( " . $count . " ) was failed to upload." . "<br/>";
                    }
                } else {
                    $errorMsg .= "Product with reference number ( " . $dataArray['ProductRefNo'] . " ) on row number ( " . $count . " ) was failed to upload." . "<br/>";
                }
                //pre("y");
            }
        } else {
            $errorMsg .= "Please upload a zip file of images" . "<br/>";
        }
        if (empty($errorMsg)) {
            $successMsg = "Products uploaded successfully.";
            $objCore->setSuccessMsg($successMsg);
        } else {
            $objCore->setErrorMsg($errorMsg);
        }

        $objBulkUpload->recursiveRemoveDirectory($zipDest);
        header('location:bulk_upload_uil.php');
        die;
    }

    function processAttributeArray($argArray) {
        //pre($argArray);
        $objBulkUpload = new BulkUpload();

        foreach ($argArray as $key => $val) {

            if (trim($argArray[$key]) != 'N/A' && $key > 0) {

                $options = explode('|', $val['options']);
                //pre($options);
                $opt = array();
                foreach ($options as $k => $v) {

                    $arrOpt = explode('=', $v);
                    
                    $result = $objBulkUpload->getAttributeOptionId($val, $arrOpt[0]);
                    //pre($result);
                    if ($result['pkOptionID'] > 0) {
                        $opt[$result['pkOptionID']] = $result;
                        $opt[$result['pkOptionID']]['price'] = trim($arrOpt[1]);
                        $opt[$result['pkOptionID']]['newImage'] = trim($arrOpt[2]);
                    }
                }
                
                if (count($opt) > 0) {
                    $argArray[$key]['options'] = $opt;
                }
            } else {
                unset($argArray[$key]);
            }
        }
        //pre($argArray);
        return $argArray;
    }

    function processPackageDataArray($argArray) {
        $objWholesaler = new Wholesaler();
        $refNo = explode('@', $argArray['ProductRefNo']);
        $products = $objWholesaler->getProductsFromRefNo($refNo);
        $data['fkWholesalerID'] = $_SESSION['sessUserInfo']['id'];
        $data['PackageName'] = $argArray['PackageName'];
        $data['PackagePrice'] = filter_var($argArray['PackagePrice'], FILTER_SANITIZE_NUMBER_FLOAT);
        $data['PackageDateAdded'] = date(DATE_TIME_FORMAT_DB);
        $data['ProductIds'] = $products;
        return $data;
    }

    function processDataArray($argArray) {
        $objCore = new Core();
        $argArray['FinalPrice'] = $this->calculateMarginCost($argArray['WholesalePrice']);
        $argArray['DiscountFinalPrice'] = $this->calculateMarginCost($argArray['DiscountPrice']);
        $argArray['CreatedBy'] = 'admin';
        $argArray['fkCreatedID'] = $_SESSION['sessUser'];
        $argArray['LastViewed'] = $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB);
        $argArray['ProductDateAdded'] = $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB);
        $argArray['ProductDateUpdated'] = $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB);
        $argArray['IsAddedBulkUpload'] = 1;
        return $argArray;
    }

    function calculateMarginCost($argCost) {
        $objClassCommon = new ClassCommon();
        $arrRow = $objClassCommon->getMarginCast();
        $varMarginCost = $argCost + ($argCost * $arrRow[0]['MarginCast'] / 100);
        $varMarginCost = round($varMarginCost, 4);
        return $varMarginCost;
    }

    /**
     * function Wholesaler Upload via CSV file
     *
     * This function store Wholesaler info.
     *
     * Database Tables used in this function are : None     
     * @access public
     *
     * @return string varFileName
     */
    function wholesalerUploadCSV($argTempFileName, $argLinelength = 5000) {
        $objCore = new Core();
        $objBulkUpload = new BulkUpload();
        $handle = fopen($argTempFileName, "r");
        $count = 0;
        $errorMsg = "";
        $zipDest = $zipExtractDest = UPLOADED_FILES_SOURCE_PATH . "images/temp_product/";
        while ($data = fgetcsv($handle, $argLinelength, ',', '"')) {
            if ($count == 0) {
                $count++;
                continue;
            }$count++;
            $arrClms = array();
            foreach ($_POST['fields'] as $key => $val) {
                $dataArray[$val] = $data[$key];
            }
            // pre($dataArray);
            if (!empty($dataArray['CompanyName']) && !empty($dataArray['AboutCompany']) && !empty($dataArray['CompanyAddress1']) && !empty($dataArray['CompanyCity']) && !empty($dataArray['CompanyCountry']) &&
                    !empty($dataArray['CompanyRegion']) && !empty($dataArray['CompanyPostalCode']) && !empty($dataArray['CompanyWebsite']) &&
                    !empty($dataArray['CompanyEmail']) && !empty($dataArray['PaypalEmail']) &&
                    !empty($dataArray['CompanyPhone']) && !empty($dataArray['CompanyFax']) && !empty($dataArray['ContactPersonName']) &&
                    !empty($dataArray['ContactPersonPosition']) && !empty($dataArray['ContactPersonPhone']) && !empty($dataArray['ContactPersonEmail']) &&
                    !empty($dataArray['ContactPersonAddress']) && !empty($dataArray['OwnerName']) && !empty($dataArray['OwnerPhone']) && !empty($dataArray['OwnerEmail']) &&
                    !empty($dataArray['OwnerAddress']) && !empty($dataArray['Ref1Name']) && !empty($dataArray['Ref1Phone']) && !empty($dataArray['Ref1Email']) &&
                    !empty($dataArray['Ref1CompanyName']) && !empty($dataArray['Ref1CompanyAddress']) && !empty($dataArray['Ref2Name']) && !empty($dataArray['Ref2Phone']) &&
                    !empty($dataArray['Ref2Email']) && !empty($dataArray['Ref2CompanyName']) && !empty($dataArray['Ref2CompanyAddress']) && !empty($dataArray['Ref3Name']) &&
                    !empty($dataArray['Ref3Phone']) && !empty($dataArray['Ref3Email']) && !empty($dataArray['Ref3CompanyName']) && !empty($dataArray['Ref3CompanyAddress'])) {
                $flag = 1;

                if (!empty($dataArray['CompanyEmail']) && $flag) {
                    $flag = $objBulkUpload->isValidEmailID($dataArray['CompanyEmail']);
                }
                if (!empty($dataArray['PaypalEmail']) && $flag) {
                    $flag = $objBulkUpload->isValidEmailID($dataArray['PaypalEmail']);
                }
                if (!empty($dataArray['Opt1CompanyEmail']) && $flag) {
                    $flag = $objBulkUpload->isValidEmailID($dataArray['Opt1CompanyEmail']);
                }
                if (!empty($dataArray['Opt2CompanyEmail']) && $flag) {
                    $flag = $objBulkUpload->isValidEmailID($dataArray['Opt2CompanyEmail']);
                }
                if (!empty($dataArray['ContactPersonEmail']) && $flag) {
                    $flag = $objBulkUpload->isValidEmailID($dataArray['ContactPersonEmail']);
                }
                if (!empty($dataArray['OwnerEmail']) && $flag) {
                    $flag = $objBulkUpload->isValidEmailID($dataArray['OwnerEmail']);
                }
                if (!empty($dataArray['Ref1Email']) && $flag) {
                    $flag = $objBulkUpload->isValidEmailID($dataArray['Ref1Email']);
                }
                if (!empty($dataArray['Ref2Email']) && $flag) {
                    $flag = $objBulkUpload->isValidEmailID($dataArray['Ref2Email']);
                }
                if (!empty($dataArray['Ref3Email']) && $flag) {
                    $flag = $objBulkUpload->isValidEmailID($dataArray['Ref3Email']);
                }

                if (!empty($dataArray['CompanyRegion']) && $flag) {
                    $dataArray['CompanyRegion'] = $objBulkUpload->findCountryRegionCode($dataArray['CompanyCountry'], $dataArray['CompanyRegion']);
                } else {
                    $flag = 0;
                }

                if (!empty($dataArray['CompanyCountry']) && $flag && $dataArray['CompanyRegion']) {
                    $dataArray['CompanyCountry'] = $objBulkUpload->findCountryCode($dataArray['CompanyCountry']);
                } else {
                    $flag = 0;
                }

                if (!empty($dataArray['Opt1CompanyCountry']) && $flag && $dataArray['CompanyCountry']) {
                    $dataArray['Opt1CompanyCountry'] = $objBulkUpload->findCountryCode($dataArray['Opt1CompanyCountry']);
                }
                if (!empty($dataArray['Opt2CompanyCountry']) && $flag && $dataArray['Opt1CompanyCountry']) {
                    $dataArray['Opt2CompanyCountry'] = $objBulkUpload->findCountryCode($dataArray['Opt2CompanyCountry']);
                }

                if (!empty($dataArray['CompanyWebsite']) && $flag && $dataArray['Opt1CompanyCountry']) {
                    $flag = $objBulkUpload->isValidUrl($dataArray['CompanyWebsite']);
                }
                if (!empty($dataArray['Opt1CompanyWebsite']) && $flag) {
                    $flag = $objBulkUpload->isValidUrl($dataArray['Opt1CompanyWebsite']);
                }
                if (!empty($dataArray['Opt2CompanyWebsite']) && $flag) {
                    $flag = $objBulkUpload->isValidUrl($dataArray['Opt2CompanyWebsite']);
                }

                if (!empty($dataArray['CompanyName']) && $flag) {
                    $flag = $objBulkUpload->isUniqueCompanyName($dataArray['CompanyName']);
                }
                if (!empty($dataArray['CompanyEmail']) && $flag) {
                    $flag = $objBulkUpload->isUniqueCompanyEmail($dataArray['CompanyEmail']);
                }
                //pre($flag);
                if ($flag) {
                    $processedWholesalerData = $objBulkUpload->processWholesalerDataArray($dataArray);
                    $arrShippingMethods = explode(',', $dataArray['shippingMethod']);
                    unset($processedWholesalerData['shippingMethod']);
                    $arrAddID = $objBulkUpload->bulkUploadWholesaler($processedWholesalerData, $arrShippingMethods);
                } else {
                    $errorMsg .="Information for wholesaler with comapny email address " . $dataArray['CompanyEmail'] . " on row number (" . $count . ") has not been inserted.<br/>";
                }
            } else {
                $errorMsg .="Please fill mandatory and valid fields for the wholesaler with comapany email address " . $dataArray['CompanyEmail'] . " on row number (" . $count . ") .<br/>";
            }
        }
        if (empty($errorMsg)) {
            $successMsg = "Wholesaler details uploaded successfully.";
            $objCore->setSuccessMsg($successMsg);
        } else {
            $objCore->setErrorMsg($errorMsg);
        }

        header('location:bulk_upload_uil.php');
        die;
    }

    /**
     * function Wholesaler Upload via XLS file
     *
     * This function store Wholesaler info.
     *
     * Database Tables used in this function are : None     
     * @access public
     *
     * @return string varFileName
     */
    function wholesalerUploadXLS($argTempFileName) {
        $objCore = new Core();
        $objBulkUpload = new BulkUpload();
        $handle = fopen($argTempFileName, "r");
        $count = 0;
        $errorMsg = "";
        $zipDest = $zipExtractDest = UPLOADED_FILES_SOURCE_PATH . "images/temp_product/";

        $objBulkUpload = new BulkUpload();
        $data = new Spreadsheet_Excel_Reader($argTempFileName);
        $row_ctr = 0;
        foreach ($data->sheets[0]['cells'] as $varTempArray) {
            /* $kk = 0;
              foreach ($varTempArray as $tempVal) {
              $varTempArray2[$kk] = $tempVal;
              $kk++;
              } */
            $row_ctr++;
            // want to skip first row
            if ($row_ctr == 1) {
                continue;
            }
            foreach ($_POST['fields'] as $key => $val) {
                //echo "$key => $val<br>";
                $dataArray[$val] = isset($varTempArray[$key + 1]) ? $varTempArray[$key + 1] : ''; //$varTempArray2[$key];
            }
            //pre($varTempArray);
            if (!empty($dataArray['CompanyName']) && !empty($dataArray['AboutCompany']) && !empty($dataArray['CompanyAddress1']) && !empty($dataArray['CompanyCity']) && !empty($dataArray['CompanyCountry']) &&
                    !empty($dataArray['CompanyRegion']) && !empty($dataArray['CompanyPostalCode']) && !empty($dataArray['CompanyWebsite']) &&
                    !empty($dataArray['CompanyEmail']) && !empty($dataArray['PaypalEmail']) &&
                    !empty($dataArray['CompanyPhone']) && !empty($dataArray['CompanyFax']) && !empty($dataArray['ContactPersonName']) &&
                    !empty($dataArray['ContactPersonPosition']) && !empty($dataArray['ContactPersonPhone']) && !empty($dataArray['ContactPersonEmail']) &&
                    !empty($dataArray['ContactPersonAddress']) && !empty($dataArray['OwnerName']) && !empty($dataArray['OwnerPhone']) && !empty($dataArray['OwnerEmail']) &&
                    !empty($dataArray['OwnerAddress']) && !empty($dataArray['Ref1Name']) && !empty($dataArray['Ref1Phone']) && !empty($dataArray['Ref1Email']) &&
                    !empty($dataArray['Ref1CompanyName']) && !empty($dataArray['Ref1CompanyAddress']) && !empty($dataArray['Ref2Name']) && !empty($dataArray['Ref2Phone']) &&
                    !empty($dataArray['Ref2Email']) && !empty($dataArray['Ref2CompanyName']) && !empty($dataArray['Ref2CompanyAddress']) && !empty($dataArray['Ref3Name']) &&
                    !empty($dataArray['Ref3Phone']) && !empty($dataArray['Ref3Email']) && !empty($dataArray['Ref3CompanyName']) && !empty($dataArray['Ref3CompanyAddress'])) {
                $flag = 1;
                if (!empty($dataArray['CompanyEmail']) && $flag) {
                    $flag = $objBulkUpload->isValidEmailID($dataArray['CompanyEmail']);
                }
                if (!empty($dataArray['PaypalEmail']) && $flag) {
                    $flag = $objBulkUpload->isValidEmailID($dataArray['PaypalEmail']);
                }
                if (!empty($dataArray['Opt1CompanyEmail']) && $flag) {
                    $flag = $objBulkUpload->isValidEmailID($dataArray['Opt1CompanyEmail']);
                }
                if (!empty($dataArray['Opt2CompanyEmail']) && $flag) {
                    $flag = $objBulkUpload->isValidEmailID($dataArray['Opt2CompanyEmail']);
                }
                if (!empty($dataArray['ContactPersonEmail']) && $flag) {
                    $flag = $objBulkUpload->isValidEmailID($dataArray['ContactPersonEmail']);
                }
                if (!empty($dataArray['OwnerEmail']) && $flag) {
                    $flag = $objBulkUpload->isValidEmailID($dataArray['OwnerEmail']);
                }
                if (!empty($dataArray['Ref1Email']) && $flag) {
                    $flag = $objBulkUpload->isValidEmailID($dataArray['Ref1Email']);
                }
                if (!empty($dataArray['Ref2Email']) && $flag) {
                    $flag = $objBulkUpload->isValidEmailID($dataArray['Ref2Email']);
                }
                if (!empty($dataArray['Ref3Email']) && $flag) {
                    $flag = $objBulkUpload->isValidEmailID($dataArray['Ref3Email']);
                }
                if (!empty($dataArray['CompanyRegion']) && $flag) {
                    $dataArray['CompanyRegion'] = $objBulkUpload->findCountryRegionCode($dataArray['CompanyCountry'], $dataArray['CompanyRegion']);
                } else {
                    $flag = 0;
                }


                if (!empty($dataArray['CompanyCountry']) && $flag && $dataArray['CompanyRegion']) {
                    $dataArray['CompanyCountry'] = $objBulkUpload->findCountryCode($dataArray['CompanyCountry']);
                } else {
                    $flag = 0;
                }
                if (!empty($dataArray['Opt1CompanyCountry']) && $flag && $dataArray['CompanyCountry']) {
                    $dataArray['Opt1CompanyCountry'] = $objBulkUpload->findCountryCode($dataArray['Opt1CompanyCountry']);
                }
                if (!empty($dataArray['Opt2CompanyCountry']) && $flag && $dataArray['Opt1CompanyCountry']) {
                    $dataArray['Opt2CompanyCountry'] = $objBulkUpload->findCountryCode($dataArray['Opt2CompanyCountry']);
                }

                if (!empty($dataArray['CompanyWebsite']) && $flag && $dataArray['Opt1CompanyCountry']) {
                    $flag = $objBulkUpload->isValidUrl($dataArray['CompanyWebsite']);
                }
                if (!empty($dataArray['Opt1CompanyWebsite']) && $flag) {
                    $flag = $objBulkUpload->isValidUrl($dataArray['Opt1CompanyWebsite']);
                }
                if (!empty($dataArray['Opt2CompanyWebsite']) && $flag) {
                    $flag = $objBulkUpload->isValidUrl($dataArray['Opt2CompanyWebsite']);
                }
                // pre($flag);
                if (!empty($dataArray['CompanyName']) && $flag) {
                    $flag = $objBulkUpload->isUniqueCompanyName($dataArray['CompanyName']);
                }
                if (!empty($dataArray['CompanyEmail']) && $flag) {
                    $flag = $objBulkUpload->isUniqueCompanyEmail($dataArray['CompanyEmail']);
                }

                if ($flag) {
                    $processedWholesalerData = $objBulkUpload->processWholesalerDataArray($dataArray);
                    $arrShippingMethods = explode(',', $dataArray['shippingMethod']);
                    unset($processedWholesalerData['shippingMethod']);
                    $arrAddID = $objBulkUpload->bulkUploadWholesaler($processedWholesalerData, $arrShippingMethods);
                } else {
                    $errorMsg .="Information for wholesaler with comapny email address " . $dataArray['CompanyEmail'] . " on row number (" . $row_ctr . ") has not been inserted.<br/>";
                }
            } else {
                $errorMsg .="Please fill mandatory and valid fields for the wholesaler with comapany email address " . $dataArray['CompanyEmail'] . " on row number (" . $row_ctr . ") .<br/>";
            }
        }
        if (empty($errorMsg)) {
            $successMsg = "Wholesaler details uploaded successfully.";
            $objCore->setSuccessMsg($successMsg);
        } else {
            $objCore->setErrorMsg($errorMsg);
        }

        header('location:bulk_upload_uil.php');
        die;
    }

    /**
     * function Category Upload via CSV file
     *
     * This function store Category info.
     *
     * Database Tables used in this function are : None     
     * @access public
     *
     * @return string varFileName
     */
    function categoryUploadCSV($argTempFileName, $argLinelength = 5000) {
        $objCore = new Core();
        $objBulkUpload = new BulkUpload();
        $handle = fopen($argTempFileName, "r");
        $count = 0;
        $errorMsg = "";
        $zipDest = $zipExtractDest = UPLOADED_FILES_SOURCE_PATH . "images/temp_product/";
        while ($data = fgetcsv($handle, $argLinelength, ',', '"')) {
            if ($count == 0) {
                $count++;
                continue;
            }$count++;
            $arrClms = array();
            foreach ($_POST['fields'] as $key => $val) {
                $dataArray[$val] = $data[$key];
            }
            //pre($dataArray);
            if (!empty($dataArray['CategoryName'])) {
                $parentCategoryExist = 'yes';
                $categoryExist = $objBulkUpload->findCategory($dataArray['CategoryName']);
                if (!empty($dataArray['parentCategory1'])) {
                    $parentCategoryExist = $objBulkUpload->findCategory($dataArray['parentCategory1']);
                }
                if (!empty($dataArray['parentCategory2'])) {
                    $parentCategoryExist = $objBulkUpload->findCategory($dataArray['parentCategory2']);
                }
                if (!empty($dataArray['parentCategory3'])) {
                    $parentCategoryExist = $objBulkUpload->findCategory($dataArray['parentCategory3']);
                }
                unset($dataArray['parentCategory']);
                unset($dataArray['parentCategory1']);
                unset($dataArray['parentCategory2']);
                unset($dataArray['parentCategory3']);
                if (!$categoryExist && $parentCategoryExist) {
                    if ($parentCategoryExist == 'yes') {
                        $parentCategoryExist = 0;
                    }
                    $dataArray['CategoryParentId'] = $parentCategoryExist;
                    $processedCategoryData = $objBulkUpload->processedCategoryData($dataArray);
                    $arrAddID = $objBulkUpload->bulkUploadCategory($processedCategoryData);
                } else {
                    $errorMsg .= "Either Category already exist or parent category does not exist for the category name '" . $dataArray['CategoryName'] . "' on row number ( " . $count . " )'.<br/>";
                }
            } else {
                $errorMsg .= "Please enter category name on row number '" . $count . "'.<br/>";
            }
        }
        if (empty($errorMsg)) {
            $successMsg = "Category details uploaded successfully.";
            $objCore->setSuccessMsg($successMsg);
        } else {
            $objCore->setErrorMsg($errorMsg);
        }

        header('location:bulk_upload_uil.php');
        die;
    }

    /**
     * function Category Upload via XLS file
     *
     * This function store Category info.
     *
     * Database Tables used in this function are : None     
     * @access public
     *
     * @return string varFileName
     */
    function categoryUploadXLS($argTempFileName) {
        $objCore = new Core();
        $objBulkUpload = new BulkUpload();
        $handle = fopen($argTempFileName, "r");
        $count = 0;
        $errorMsg = "";
        $zipDest = $zipExtractDest = UPLOADED_FILES_SOURCE_PATH . "images/temp_product/";
        $objBulkUpload = new BulkUpload();
        $data = new Spreadsheet_Excel_Reader($argTempFileName);
        $row_ctr = 0;
        foreach ($data->sheets[0]['cells'] as $varTempArray) {
            /* $kk = 0;
              foreach ($varTempArray as $tempVal) {
              $varTempArray2[$kk] = $tempVal;
              $kk++;
              } */
            $row_ctr++;
            // want to skip first row
            if ($row_ctr == 1) {
                continue;
            }

            foreach ($_POST['fields'] as $key => $val) {
                $dataArray[$val] = isset($varTempArray[$key + 1]) ? $varTempArray[$key + 1] : ''; //$varTempArray2[$key];
            }
            if (!empty($dataArray['CategoryName'])) {
                $parentCategoryExist = 'yes';
                $categoryExist = $objBulkUpload->findCategory($dataArray['CategoryName']);
                if (!empty($dataArray['parentCategory1'])) {
                    $parentCategoryExist = $objBulkUpload->findCategory($dataArray['parentCategory1']);
                }
                if (!empty($dataArray['parentCategory2'])) {
                    $parentCategoryExist = $objBulkUpload->findCategory($dataArray['parentCategory2']);
                }
                if (!empty($dataArray['parentCategory3'])) {
                    $parentCategoryExist = $objBulkUpload->findCategory($dataArray['parentCategory3']);
                }

                unset($dataArray['parentCategory']);
                unset($dataArray['parentCategory1']);
                unset($dataArray['parentCategory2']);
                unset($dataArray['parentCategory3']);
                if (!$categoryExist && $parentCategoryExist) {
                    if ($parentCategoryExist == 'yes') {
                        $parentCategoryExist = 0;
                    }
                    $dataArray['CategoryParentId'] = $parentCategoryExist;
                    $processedCategoryData = $objBulkUpload->processedCategoryData($dataArray);
                    $arrAddID = $objBulkUpload->bulkUploadCategory($processedCategoryData);
                } else {
                    $errorMsg .= "Either Category already exist or parent category does not exist for the category name '" . $dataArray['CategoryName'] . "' on row number ( " . $row_ctr . " ).<br/>";
                }
            } else {
                $errorMsg .= "Please enter category name on row number ( " . $row_ctr . " ).<br/>";
            }
        }
        if (empty($errorMsg)) {
            $successMsg = "Category details uploaded successfully.";
            $objCore->setSuccessMsg($successMsg);
        } else {
            $objCore->setErrorMsg($errorMsg);
        }

        header('location:bulk_upload_uil.php');
        die;
    }

    /**
     * function Customers Upload via CSV file
     *
     * This function store Customer info from CSV file.
     *
     * Database Tables used in this function are : None     
     * @access public
     *
     * @return string varFileName
     */
    function customerUploadCSV($argTempFileName, $argLinelength = 5000) {
        $objCore = new Core();
        $objBulkUpload = new BulkUpload();
        $handle = fopen($argTempFileName, "r");
        $count = 0;
        $errorMsg = "";
        $zipDest = $zipExtractDest = UPLOADED_FILES_SOURCE_PATH . "images/temp_product/";
        while ($data = fgetcsv($handle, $argLinelength, ',', '"')) {
            if ($count == 0) {
                $count++;
                continue;
            }$count++;
            $arrClms = array();
            //pre($data);
            foreach ($_POST['fields'] as $key => $val) {
                $dataArray[$val] = $data[$key];
            }
            //pre($dataArray);
            $dataArray['BillingCountry'] = $objBulkUpload->findCountryCode($dataArray['BillingCountry']);
            $dataArray['ShippingCountry'] = $objBulkUpload->findCountryCode($dataArray['ShippingCountry']);
            if ($dataArray['CustomerFirstName'] && $dataArray['CustomerEmail']
                    && $dataArray['BillingFirstName'] && $dataArray['BillingOrganizationName'] && $dataArray['BillingAddressLine1']
                    && $dataArray['BillingCountry'] && $dataArray['BillingPostalCode'] && $dataArray['BillingPhone']
                    && $dataArray['ShippingFirstName'] && $dataArray['ShippingOrganizationName'] && $dataArray['ShippingAddressLine1']
                    && $dataArray['ShippingCountry'] && $dataArray['ShippingPostalCode'] && $dataArray['ShippingPhone'] && $dataArray['BusinessAddress']
                    && $dataArray['CustomerStatus']) {
                $validEmail = $objBulkUpload->isValidEmailID($dataArray['CustomerEmail']);
                $customerExist = $objBulkUpload->findCustomer($dataArray['CustomerEmail']);

                if ($validEmail && !$customerExist) {
                    $processedCustomerData = $objBulkUpload->processedCustomerData($dataArray);
                    $arrAddID = $objBulkUpload->bulkUploadCustomer($processedCustomerData);
                } else {
                    $errorMsg .= "Email address is already exist for email address '" . $dataArray['CustomerEmail'] . "' on row number ( " . $count . " ).<br/>";
                }
            } else {
                $errorMsg .= "Please fill valid and mandatory fields on row number ( " . $count . " ).<br/>";
            }
        }
        if (empty($errorMsg)) {
            $successMsg = "Customer details uploaded successfully.";
            $objCore->setSuccessMsg($successMsg);
        } else {

            $objCore->setErrorMsg($errorMsg);
        }

        header('location:bulk_upload_uil.php');
        die;
    }

    /**
     * function Customers Upload via XLS file
     *
     * This function store Customer info from XLS file.
     *
     * Database Tables used in this function are : None     
     * @access public
     *
     * @return string varFileName
     */
    function customerUploadXLS($argTempFileName) {
        $objCore = new Core();
        $objBulkUpload = new BulkUpload();
        $handle = fopen($argTempFileName, "r");
        $count = 0;
        $errorMsg = "";
        $zipDest = $zipExtractDest = UPLOADED_FILES_SOURCE_PATH . "images/temp_product/";
        $objBulkUpload = new BulkUpload();
        $data = new Spreadsheet_Excel_Reader($argTempFileName);
        $row_ctr = 0;
        foreach ($data->sheets[0]['cells'] as $varTempArray) {
            $kk = 0;
            foreach ($varTempArray as $tempVal) {
                $varTempArray2[$kk] = $tempVal;
                $kk++;
            }
            $row_ctr++;
            // want to skip first row
            if ($row_ctr == 1) {
                continue;
            }
            foreach ($_POST['fields'] as $key => $val) {
                $dataArray[$val] = $varTempArray2[$key];
            }
            $dataArray['BillingCountry'] = $objBulkUpload->findCountryCode($dataArray['BillingCountry']);
            $dataArray['ShippingCountry'] = $objBulkUpload->findCountryCode($dataArray['ShippingCountry']);
            $validEmail = $objBulkUpload->isValidEmailID($dataArray['CustomerEmail']);
            if ($dataArray['CustomerFirstName'] && $dataArray['CustomerEmail']
                    && $dataArray['BillingFirstName'] && $dataArray['BillingOrganizationName'] && $dataArray['BillingAddressLine1']
                    && $dataArray['BillingCountry'] && $dataArray['BillingPostalCode'] && $dataArray['BillingPhone']
                    && $dataArray['ShippingFirstName'] && $dataArray['ShippingOrganizationName'] && $dataArray['ShippingAddressLine1']
                    && $dataArray['ShippingCountry'] && $dataArray['ShippingPostalCode'] && $dataArray['ShippingPhone'] && $dataArray['BusinessAddress']
                    && $dataArray['CustomerStatus'] && $validEmail) {
                $customerExist = $objBulkUpload->findCustomer($dataArray['CustomerEmail']);

                if (!$customerExist) {
                    $processedCustomerData = $objBulkUpload->processedCustomerData($dataArray);
                    $arrAddID = $objBulkUpload->bulkUploadCustomer($processedCustomerData);
                } else {
                    $errorMsg .= "Email address is already exist for email address '" . $dataArray['CustomerEmail'] . "' on row number ( " . $row_ctr . " ).<br/>";
                }
            } else {
                $errorMsg .= "Please fill valid and mandatory fields on row number ( " . $row_ctr . " ).<br/>";
            }
        }
        if (empty($errorMsg)) {
            $successMsg = "Customer details uploaded successfully.";
            $objCore->setSuccessMsg($successMsg);
        } else {
            $objCore->setErrorMsg($errorMsg);
        }

        header('location:bulk_upload_uil.php');
        die;
    }

    /**
     * function Package Upload via CSV file
     *
     * This function store Package info from CSV file.
     *
     * Database Tables used in this function are : None     
     * @access public
     *
     * @return string varFileName
     */
    function packageUploadCSV($argTempFileName, $argLinelength = 5000) {
        $objCore = new Core();
        $objBulkUpload = new BulkUpload();
        $zipExtractDest = UPLOADED_FILES_SOURCE_PATH . "images/temp_product/";
        $zipDest = $zipExtractDest;
        $zipDest = $zipExtractDest = UPLOADED_FILES_SOURCE_PATH . "images/temp_product/";
        if (!empty($_FILES['frmPackageImages']['tmp_name'])) {

            move_uploaded_file($_FILES['frmPackageImages']['tmp_name'], $zipExtractDest . "temp.zip");
            $zipSource = $zipExtractDest . "temp.zip";
            system("unzip -qd " . $zipDest . " " . $zipSource);
            $handle = fopen($argTempFileName, "r");
            $count = 0;
            $errorMsg = "";

            while ($data = fgetcsv($handle, $argLinelength, ',', '"')) {
                if ($count == 0) {
                    $count++;
                    continue;
                }$count++;
                $arrClms = array();
                foreach ($_POST['fields'] as $key => $val) {
                    $dataArray[$val] = $data[$key];
                }
                $dataArray['fkWholesalerID'] = $objBulkUpload->findWholesaler($dataArray['fkWholesalerID']);
                if ($dataArray['PackageName'] && $dataArray['fkWholesalerID'] && $dataArray['PackagePrice'] && $dataArray['PackageImage'] && $dataArray['ProductsReferenceNumbers']) {
                    $packageExist = $objBulkUpload->findPackage($dataArray['PackageName']);
                    if (!$packageExist) {
                        $processedPackageProducts = $objBulkUpload->processedPackageProducts($dataArray['ProductsReferenceNumbers']);
                        $dataArray['PackageACPrice'] = $objBulkUpload->processedPackageProductsPrice($dataArray['ProductsReferenceNumbers']);
                        if (!empty($processedPackageProducts)) {
                            unset($dataArray['ProductsReferenceNumbers']);

                            $processedPackageImage = $dataArray['PackageImage'];
                            unset($dataArray['PackageImage']);

                            $processedPackageData = $objBulkUpload->processedPackageData($dataArray);
                            $arrAddID = $objBulkUpload->bulkUploadPackage($processedPackageData, $processedPackageImage, $processedPackageProducts, $zipDest);
                        } else {
                            $errorMsg .= "Products Ref No. does not exist.<br/>";
                        }
                    } else {
                        $errorMsg .= "Package name is already exist for apackage '" . $dataArray['PackageName'] . "' on row number ( " . $count . " ).<br/>";
                    }
                } else {

                    $errorMsg .= "Please fill valid and mandatory fields on row number ( " . $count . " ).<br/>";
                }
            }
        } else {
            $errorMsg .= "Please upload a zip file of images.<br/>";
        }

        if (empty($errorMsg)) {
            $successMsg = "Package details uploaded successfully.";
            $objCore->setSuccessMsg($successMsg);
        } else {
            $objCore->setErrorMsg($errorMsg);
        }
        $objBulkUpload->recursiveRemoveDirectory($zipDest);
        header('location:bulk_upload_uil.php');
        die;
    }

    /**
     * function Package Upload via XLS file
     *
     * This function store Package info from XLS file.
     *
     * Database Tables used in this function are : None     
     * @access public
     *
     * @return string varFileName
     */
    function packageUploadXLS($argTempFileName) {
        $objCore = new Core();
        $objBulkUpload = new BulkUpload();
        $zipExtractDest = UPLOADED_FILES_SOURCE_PATH . "images/temp_product/";
        $zipDest = $zipExtractDest;
        if (!empty($_FILES['frmPackageImages']['tmp_name'])) {
            move_uploaded_file($_FILES['frmPackageImages']['tmp_name'], $zipExtractDest . "temp.zip");
            $zipSource = $zipExtractDest . "temp.zip";
            system("unzip -qd " . $zipDest . " " . $zipSource);

            $handle = fopen($argTempFileName, "r");

            $count = 0;
            $errorMsg = "";
            $objBulkUpload = new BulkUpload();
            $data = new Spreadsheet_Excel_Reader($argTempFileName);
            $row_ctr = 0;
            foreach ($data->sheets[0]['cells'] as $varTempArray) {
                $kk = 0;
                foreach ($varTempArray as $tempVal) {
                    $varTempArray2[$kk] = $tempVal;
                    $kk++;
                }
                $row_ctr++;
                // want to skip first row
                if ($row_ctr == 1) {
                    continue;
                }
                foreach ($_POST['fields'] as $key => $val) {
                    $dataArray[$val] = $varTempArray2[$key];
                }

                $dataArray['fkWholesalerID'] = $objBulkUpload->findWholesaler($dataArray['fkWholesalerID']);
                if ($dataArray['PackageName'] && $dataArray['fkWholesalerID'] && $dataArray['PackagePrice'] && $dataArray['PackageImage'] && $dataArray['ProductsReferenceNumbers']) {
                    $packageExist = $objBulkUpload->findPackage($dataArray['PackageName']);
                    if (!$packageExist) {
                        $processedPackageProducts = $objBulkUpload->processedPackageProducts($dataArray['ProductsReferenceNumbers']);
                        $dataArray['PackageACPrice'] = $objBulkUpload->processedPackageProductsPrice($dataArray['ProductsReferenceNumbers']);
                        if (!empty($processedPackageProducts)) {
                            unset($dataArray['ProductsReferenceNumbers']);

                            $processedPackageImage = $dataArray['PackageImage'];
                            unset($dataArray['PackageImage']);

                            $processedPackageData = $objBulkUpload->processedPackageData($dataArray);
                            $arrAddID = $objBulkUpload->bulkUploadPackage($processedPackageData, $processedPackageImage, $processedPackageProducts, $zipDest);
                        } else {
                            $errorMsg .= "Products Ref No. does not exist.<br/>";
                        }
                    } else {
                        $errorMsg .= "Package name is already exist for apackage '" . $dataArray['PackageName'] . "' on row number ( " . $row_ctr . " ).<br/>";
                    }
                } else {
                    $errorMsg .= "Please fill valid and mandatory fields on row number ( " . $row_ctr . " ).<br/>";
                }
            }
        } else {
            $errorMsg .= "Please upload a zip file of images.<br/>";
        }

        if (empty($errorMsg)) {
            $successMsg = "Package details uploaded successfully.";
            $objCore->setSuccessMsg($successMsg);
        } else {
            $objCore->setErrorMsg($errorMsg);
        }
        $objBulkUpload->recursiveRemoveDirectory($zipDest);
        header('location:bulk_upload_uil.php');
        die;
    }

}

$objPage = new BulkUploadCtrl();
$objPage->pageLoad();
?>
