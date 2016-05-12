<?php
require_once CLASSES_PATH . 'class_wholesaler_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once(CLASSES_PATH . 'class_common.php');
require_once(CLASSES_PATH . 'excel_reader.php');
require_once COMPONENTS_SOURCE_ROOT_PATH . 'class_upload_inc.php';

class BulkUploadCtrl extends Paging {
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
//        print_r($_FILES);
//        pre($_REQUEST);
        if ($_SESSION['sessUserInfo']['id'] && $_SESSION['sessUserInfo']['type'] == 'wholesaler') {
            
        } else {
            header('location:' . SITE_ROOT_URL);
            die;
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
        $dataArray = array();
        $wid = $_SESSION['sessUserInfo']['id'];
        $this->wid = $wid;
        $this->attributesList = $objWholesaler->getAttributesList();
        if (isset($_POST['frmHiddenAdd']) && $_POST['frmHiddenAdd'] == 'upload') {
            // check if file uploaded
            //pre($_POST['fields']);
            if ($_FILES['file1']['name'] != '') {
                // for CSV file type
//                 pre($_POST);
                $varInsertedNum = 0;
                if ($_FILES['file1']['type'] == 'text/csv' || $_FILES['file1']['type'] == 'text/x-csv' || $_FILES['file1']['type'] == 'application/octet-stream' || strtolower(substr($_FILES['file1']['name'], -3)) == 'csv') {
                    //pre($_POST);
                    if (($handle = fopen($_FILES['file1']['tmp_name'], "r")) !== FALSE) {
                        $row_ctr = 0;

                        while (($line = fgetcsv($handle)) !== FALSE) {
//                            pre($line);
                            $row_ctr++;
                            // if want to skip first row
                            if ($_POST['skip_first']) {
                                if ($row_ctr == 1)
                                    continue;
                            }

                            foreach ($_POST['fields'] as $key => $val) {
                                $dataArray[$val] = $line[$key];
                            }
                            
//                            if ($row_ctr == 3)
//                            pre($dataArray);
                            
                            // want to upload the packages
                            if ($_POST['upload_type'] == 'packages') {
                                $zipExtractDest = UPLOADED_FILES_SOURCE_PATH . "images/temp_product/";
                                $zipDest = $zipExtractDest;
                                if (!empty($_FILES['frmImages']['name'])) {
                                    move_uploaded_file($_FILES['frmImages']['tmp_name'], $zipExtractDest . "temp.zip");
                                    $zipSource = $zipExtractDest . "temp.zip";
                                    system("unzip -qd " . $zipDest . " " . $zipSource);

                                    if ($dataArray['PackageName'] && $dataArray['ProductRefNo'] && $dataArray['PackagePrice'] && $dataArray['PackageImage']) {
                                        $processedPackageProducts = $objWholesaler->processedPackageProducts($dataArray['ProductRefNo']);
                                        $dataArray['PackageACPrice'] = $objWholesaler->processedPackageProductsPrice($dataArray['ProductRefNo']);
                                        if (!empty($processedPackageProducts)) {
                                            $packageExist = $objWholesaler->findPackage($dataArray['PackageName']);
                                            if (!$packageExist) {
                                                $processedData = $this->processPackageDataArray($dataArray);
                                                $processedImages = $dataArray['PackageImage'];
                                                $varNum = $objWholesaler->bulkUploadProduct($processedData, $_POST['upload_type'], " ", $processedImages, $zipDest);
                                                $varInsertedNum += ($varNum > 0) ? '1' : 0;
                                            } else {
                                                $objWholesaler->recursiveRemoveDirectory($zipDest);
                                                $objCore->setSuccessMsg("Package name is already exist!");
                                                header('location:manage_packages.php');
                                                die;
                                            }
                                        }
                                    }
                                    // want to upload the products
                                }
                            } else {


                                $zipExtractDest = UPLOADED_FILES_SOURCE_PATH . "images/temp_product/";
                                $zipDest = $zipExtractDest;
                                if (!empty($_FILES['frmImages']['name'])) {

                                    move_uploaded_file($_FILES['frmImages']['tmp_name'], $zipExtractDest . "temp.zip");
                                    $zipSource = $zipExtractDest . "temp.zip";
                                    system("unzip -qd " . $zipDest . " " . $zipSource);
                                    //   pre($dataArray);
//                                    if ($row_ctr == 3)
//                                    pre($dataArray);
                                    //echo "yesss"; die;
                                    if ($dataArray['ProductRefNo'] && $dataArray['ProductName'] && $dataArray['WholesalePrice'] && $dataArray['Quantity'] && $dataArray['fkCategoryID'] && $dataArray['fkShippingID']) {
                                        //  echo "yesa"; die;
                                        $dataArray['fkCategoryID'] = $objWholesaler->findCategory($dataArray['fkCategoryID']);
//                                          pre($dataArray['fkCategoryID']);
                                        $dataArray['fkShippingID'] = $objWholesaler->findShippingGateway($dataArray['fkShippingID']);
                                        
                                        if ($dataArray['fkCategoryID'] && $dataArray['fkShippingID'] != '') {
                                            //  echo "yesa"; die;
                                            $productAttributes = explode(";", $dataArray['Attribute']);
                                            $processAttributesInventory = $dataArray['AttributeInventory'];

                                            unset($dataArray['Attribute'], $dataArray['AttributeInventory']);

                                            $processedData = $this->processDataArray($dataArray);
                                            $attributesTempArray = array();

                                            if ($productAttributes) {

                                                foreach ($productAttributes AS $prodAttribute) {
                                                    if (strstr($prodAttribute, "#")) {
                                                        $dataAttribOptions = explode('#', $prodAttribute);

                                                        $attrRes = $objWholesaler->getAttributeId($dataAttribOptions[0], $dataArray['fkCategoryID']);

                                                        if ($attrRes['pkAttributeID'] > 0) {
                                                            $attributesTempArray[$attrRes['pkAttributeID']]['pkAttributeID'] = $attrRes['pkAttributeID'];
                                                            $attributesTempArray[$attrRes['pkAttributeID']]['AttributeInputType'] = $attrRes['AttributeInputType'];
                                                            $attributesTempArray[$attrRes['pkAttributeID']]['AttributeCode'] = $attrRes['AttributeCode'];
                                                            $attributesTempArray[$attrRes['pkAttributeID']]['options'] = $dataAttribOptions[1];
                                                        }
                                                    }
                                                }
                                            }

                                            $processedImages = explode(',', $dataArray['ImageName']);
                                            array_unshift($processedImages, $processedData['ProductImage']);
                                            
                                            unset($processedData['ImageName'], $processedData['ProductImage']);
                                            $processedAttributes = array();

                                            $processedAttributes = $this->processAttributeArray($attributesTempArray);

                                            $varNum = $objWholesaler->bulkUploadProduct($processedData, $_POST['upload_type'], $processedAttributes, $processAttributesInventory, $processedImages, $zipDest);
                                            $varInsertedNum += ($varNum > 0) ? '1' : 0;
                                        }
                                    }
                                }
                            }
                        }
                        if ($_POST['upload_type'] == 'packages') {
                            $objWholesaler->recursiveRemoveDirectory($zipDest);
                            $objCore->setSuccessMsg($varInsertedNum . ' Package(s) Added !');
                            header('location:manage_packages.php');
                            die;
                        } else if ($_POST['upload_type'] == 'products') {
                            //  echo "test"; die;
                            $objWholesaler->recursiveRemoveDirectory($zipDest);
                            $objCore->setSuccessMsg($varInsertedNum . ' Product(s) Added !');
                            header('location:manage_products.php');
                            die;
                        }
                        die;
                    }
                    // for excel file types
                } elseif ($_FILES['file1']['type'] == 'application/vnd.ms-excel' || $_FILES['file1']['type'] == 'application/msexcel' || $_FILES['file1']['type'] == 'application/msexcel' || $_FILES['file1']['type'] == 'application/wps-office.xls') {
                    // excel file operation
                    // echo "yes"; die;

                    $data = new Spreadsheet_Excel_Reader($_FILES['file1']['tmp_name']);
                    $row_ctr = 0;
                    $count_xls_head = $data->sheets[0]['numCols'];
                    //pre($data->sheets[0]['cells'][1]);
                    //$headFromXls = $data->sheets[0]['cells'][1];
                    $headFromXls = array('ProductRefNo', 'ProductName', 'WholesalePrice', 'DiscountPrice', 'fkCategoryID', 'fkShippingID',
                        'Quantity', 'QuantityAlert', 'DimensionUnit', 'Length', 'Width', 'Height', 'WeightUnit', 'Weight', 'Attribute',
                        'AttributeInventory', 'ProductDescription', 'ProductTerms', 'YoutubeCode', 'HtmlEditor', 'ProductImage',
                        'ImageName', 'MetaTitle', 'MetaKeywords', 'MetaDescription');
                    //foreach($data->sheets[0]['cells'][1] as $bb => $val1){
                    //  $headFromXls[] =  $val1;
                    //}
//                    pre($data->sheets[0]['cells']);

                    foreach ($data->sheets[0]['cells'] as $keyV => $varTempArray) {

                        $row_ctr++;
                        // want to skip first row
                        if ($_POST['skip_first']) {
                            if ($row_ctr == 1) {
                                continue;
                            }
                        }
                        
//                        pre($varTempArray);
                        for($ii = 1; $ii <= 25; $ii++){
                            
                            $varTempArray33[$ii] = $varTempArray[$ii];
                        }
//                        pre($varTempArray33);
                        
//                        $knew1 = 1;
//                        foreach ($varTempArray as $k => $tempVal) {
//                            if ($knew1 != $k) {
//                                $varTempArray33[$knew1] = '';
//                                $knew1--;
//                            } else {
//                                $varTempArray33[$knew1] = $tempVal;
//                            }
//                            $knew1++;
//                        }
//                        if($keyV == 2)

                        foreach ($headFromXls as $key => $val) {
                            //if(!empty($val)){
                            $dataArray[$val] = $varTempArray33[++$key];
                            //}
                        }
                        if(empty($dataArray['ProductRefNo']))
                {
                    $validation_error[]='ProductRefNo';
                }
                if(empty($dataArray['ProductName']))
                {
                    $validation_error[]='ProductName';
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
                
                 if(empty($dataArray['QuantityAlert']))
                {
                    $validation_error[]=' Alert Stock Quantity';
                }
                
                if(!empty($validation_error))
                {
                    $a=$row_ctr-= 1;
                   $_POST['error_mgs'] .= "Product  on row number ( " . $a . " ) was failed to upload due to " . implode(", ",$validation_error); 
                   break;
                }
                       // pre($dataArray);
                        // want to upload packages
                        if ($_POST['upload_type'] == 'packages') {
                            $zipExtractDest = UPLOADED_FILES_SOURCE_PATH . "images/temp_product/";
                            $zipDest = $zipExtractDest;
                            if (!empty($_FILES['frmImages']['name'])) {
                                move_uploaded_file($_FILES['frmImages']['tmp_name'], $zipExtractDest . "temp.zip");
                                $zipSource = $zipExtractDest . "temp.zip";
                                system("unzip -qd " . $zipDest . " " . $zipSource);

                                if ($dataArray['PackageName'] && $dataArray['ProductRefNo'] && $dataArray['PackagePrice'] && $dataArray['PackageImage']) {
                                    $processedPackageProducts = $objWholesaler->processedPackageProducts($dataArray['ProductRefNo']);
                                    $dataArray['PackageACPrice'] = $objWholesaler->processedPackageProductsPrice($dataArray['ProductRefNo']);
                                    if (!empty($processedPackageProducts)) {
                                        $packageExist = $objWholesaler->findPackage($dataArray['PackageName']);
                                        if (!$packageExist) {
                                            $processedData = $this->processPackageDataArray($dataArray);
                                            $processedImages = $dataArray['PackageImage'];
                                            $varNum = $objWholesaler->bulkUploadProduct($processedData, $_POST['upload_type'], " ", $processedImages, $zipDest);
                                            $varInsertedNum += ($varNum > 0) ? '1' : 0;
                                        } else {
                                            $objWholesaler->recursiveRemoveDirectory($zipDest);
                                            $objCore->setSuccessMsg("Package name is already exist!");
                                            header('location:manage_packages.php');
                                            die;
                                        }
                                    }
                                }
                                // want to upload the products
                            }
                        } else {

                            $zipExtractDest = UPLOADED_FILES_SOURCE_PATH . "images/temp_product/";
                            $zipDest = $zipExtractDest;
//                             pre($_FILES);

                            if (!empty($_FILES['frmImages']['name'])) {
                                move_uploaded_file($_FILES['frmImages']['tmp_name'], $zipExtractDest . "temp.zip");
                                $zipSource = $zipExtractDest . "temp.zip";
                                system("unzip -qd " . $zipDest . " " . $zipSource);

                                if ($dataArray['ProductRefNo'] && $dataArray['ProductName'] && $dataArray['WholesalePrice'] && $dataArray['Quantity'] && $dataArray['fkCategoryID'] && $dataArray['fkShippingID']) {

//                                    echo "<pre>"; 
//                                    print_r($dataArray);
                                    $dataArray['fkCategoryID'] = $objWholesaler->findCategory($dataArray['fkCategoryID']);
                                    $dataArray['fkShippingID'] = $objWholesaler->findShippingGateway($dataArray['fkShippingID']);
//                                    pre($dataArray);
                                    if ($dataArray['fkCategoryID'] && $dataArray['fkShippingID']) {
                                        // echo "yesaviee"; die;
                                        $productAttributes = explode(";", $dataArray['Attribute']);
                                        $processAttributesInventory = $dataArray['AttributeInventory'];
//                                        pre($productAttributes);
                                        unset($dataArray['Attribute'], $dataArray['AttributeInventory']);

                                        $processedData = $this->processDataArray($dataArray);
                                        $attributesTempArray = array();

                                        if ($productAttributes) {
                                            //pre($productAttributes);

                                            foreach ($productAttributes AS $prodAttribute) {
                                                if (strstr($prodAttribute, "#")) {
                                                    $dataAttribOptions = explode('#', $prodAttribute);
//                                                    pre($dataAttribOptions);
                                                    $attrRes = $objWholesaler->getAttributeId($dataAttribOptions[0], $dataArray['fkCategoryID']);
//                                                    pre($attrRes);
                                                    if ($attrRes['pkAttributeID'] > 0) {
                                                        $attributesTempArray[$attrRes['pkAttributeID']]['pkAttributeID'] = $attrRes['pkAttributeID'];
                                                        $attributesTempArray[$attrRes['pkAttributeID']]['AttributeInputType'] = $attrRes['AttributeInputType'];
                                                        $attributesTempArray[$attrRes['pkAttributeID']]['AttributeCode'] = $attrRes['AttributeCode'];
                                                        $attributesTempArray[$attrRes['pkAttributeID']]['options'] = $dataAttribOptions[1];
                                                    }
                                                }
                                            }
                                        }

                                        //echo "yes"; die;
                                        //pre($attributesTempArray);
                                        //pre($dataArray['ImageName']);
//                                           pre($dataArray);
                                        $processedImages = explode(',', $dataArray['ImageName']);
                                        // $processedImages = explode(',', $dataArray['ProductImage']); 
//                                        pre($processedImages);
                                        array_unshift($processedImages, $processedData['ProductImage']);
                                        unset($processedData['ImageName'], $processedData['ProductImage']);
                                        $processedAttributes = array();
//                                        pre($processedImages);
                                        $processedAttributes = $this->processAttributeArray($attributesTempArray);
//                                        pre($processedAttributes);

                                        $varNum = $objWholesaler->bulkUploadProduct($processedData, $_POST['upload_type'], $processedAttributes, $processAttributesInventory, $processedImages, $zipDest);
                                        $varInsertedNum += ($varNum > 0) ? '1' : 0;
                                    }
                                    //echo "yesavisdfsdf"; die;
                                }
                            }
                        }
                    }
                    if ($_POST['upload_type'] == 'packages') {
                        $objWholesaler->recursiveRemoveDirectory($zipDest);
                        $objCore->setSuccessMsg($varInsertedNum . ' Package(s) Added !');
                        header('location:manage_packages.php');
                        die;
                    } elseif ($_POST['upload_type'] == 'products') {
                        $objWholesaler->recursiveRemoveDirectory($zipDest);
                        $objCore->setSuccessMsg($varInsertedNum . ' Product(s) Added !');
                        header('location:manage_products.php');
                        die;
                    }
                    die;
                } else {
                    $_POST['error_mgs'] = 'Invalid File';
                }
            } else {
                $_POST['error_mgs'] = 'No File';
            }
        }
    }

// end of page load


    function processAttributeArray($argArray) {
        //pre($argArray);
        $objWholesaler = new Wholesaler();

        foreach ($argArray as $key => $val) {

            if (trim($argArray[$key]) != 'N/A' && $key > 0) {

                $options = explode('|', $val['options']);
                $opt = array();
                foreach ($options as $k => $v) {

                    $arrOpt = explode('=', $v);
                    $result = $objWholesaler->getAttributeOptionId($val, $arrOpt[0]);

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
        $refNo = explode('|', $argArray['ProductRefNo']);
        $products = $objWholesaler->getProductsFromRefNo($refNo);
        $data['fkWholesalerID'] = $_SESSION['sessUserInfo']['id'];
        $data['PackageName'] = $argArray['PackageName'];
        $data['PackagePrice'] = filter_var($argArray['PackagePrice'], FILTER_SANITIZE_NUMBER_FLOAT);
        $data['PackageACPrice'] = $argArray['PackageACPrice'];
        $data['PackageDateAdded'] = date(DATE_TIME_FORMAT_DB);
        $data['ProductIds'] = $products;
        // pre($data);
        return $data;
    }

    function processDataArray($argArray) {
        $objCore = new Core();
        $argArray['FinalPrice'] = $this->calculateMarginCost($argArray['WholesalePrice']);
        $argArray['DiscountFinalPrice'] = $this->calculateMarginCost($argArray['DiscountPrice']);
        $argArray['fkWholesalerID'] = $_POST['frmkfWholesalerID'];
        $argArray['CreatedBy'] = 'wholesaler';
        $argArray['fkCreatedID'] = $_POST['frmkfWholesalerID'];
        $argArray['LastViewed'] = $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB);
        $argArray['ProductDateAdded'] = $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB);
        $argArray['ProductDateUpdated'] = $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB);
        $argArray['IsAddedBulkUpload'] = 1;
        //pre($argArray);
        return $argArray;
    }

    function calculateMarginCost($argCost) {
        $objClassCommon = new ClassCommon();
        $arrRow = $objClassCommon->getMarginCast();
        $varMarginCost = $argCost + ($argCost * $arrRow[0]['MarginCast'] / 100);
        $varMarginCost = round($varMarginCost, 4);
        return $varMarginCost;
    }

}

$objPage = new BulkUploadCtrl();
$objPage->pageLoad();
?>
