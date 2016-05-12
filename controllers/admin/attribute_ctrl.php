<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_attribute_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_PATH . 'class_common.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'class_upload_inc.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';
require COMPONENTS_SOURCE_ROOT_PATH . 'PHPExcel/Classes/PHPExcel.php';

class attributeCtrl extends Paging {
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
        if ($_POST['ajax_request'] && $_POST['ajax_request'] = 'valid') {
            
        } else {
            $objAdminLogin->isValidAdmin();
        }
        //************ Get Admin Email here
    }

    private function getList() {
        $objPaging = new Paging();
        $objAttribute = new attribute();


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

            $varCode = $arrSearchParameter['frmCode'];
            $varVisible = $arrSearchParameter['frmVisible'];
            $varComparable = $arrSearchParameter['frmComparable'];
            $varLabel = $arrSearchParameter['frmLabel'];
            $varSearchable = $arrSearchParameter['frmSearchable'];
            $varCategory = $arrSearchParameter['frmCategory'];


            if ($varCode <> '') {
                $varWhereClause .= " AND AttributeCode LIKE '%" . addslashes($varCode) . "%'";
            }
            if ($varLabel <> '') {
                $varWhereClause .= " AND AttributeLabel LIKE '%" . addslashes($varLabel) . "%'";
            }
            if ($varCategory > 0) {
                $varWhereClause .= " AND fkCategoryID LIKE '%" . $varCategory . "%'";
            }

            $varWhrClause = "AttributeVisible='" . $varVisible . "' AND AttributeComparable='" . $varComparable . "' AND AttributeSearchable= '" . $varSearchable . "' " . $varWhereClause;
            //echo $varWhrClause;die;

            $this->varPageStart = $objPaging->getPageStartLimit($_GET['page'], $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;

            $arrRecords = $objAttribute->AttributeList($varWhrClause, '');

            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objAttribute->AttributeList($varWhrClause, $this->varLimit);
        } else {
            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = $objAttribute->AttributeList($varWhr = '', $limit = '');

            $this->NumberofRows = count($arrRecords);

            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objAttribute->AttributeList($varWhr = '', $this->varLimit);
            //echo '<pre>';print_r($this->arrRows);die;
        }

        $this->varSortColumn = $objAttribute->getSortColumn($_REQUEST);
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
        
        global $objGeneral;
        $objCore = new Core();
        $objAttribute = new attribute();
        $objClassCommon = new ClassCommon();

        $this->arrInputType = $objAttribute->InputTypeList();
        $this->arrCategoryDropDown = $objClassCommon->getCategories();

        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'add' && $_GET['type'] == 'add') {
            // Editing images record

            if (isset($_FILES['attr_img'])) {
                foreach ($_FILES['attr_img']['name'] as $keyImg => $valImg) {
                    //  print_r($keyImg);
                    if ($valImg != '' && $_FILES['attr_img']['error'][$keyImg] == 0) {
                        $arrFile = array(
                            'name' => $_FILES['attr_img']['name'][$keyImg],
                            'type' => $_FILES['attr_img']['type'][$keyImg],
                            'tmp_name' => $_FILES['attr_img']['tmp_name'][$keyImg],
                            'error' => $_FILES['attr_img']['error'][$keyImg],
                            'size' => $_FILES['attr_img']['size'][$keyImg]
                        );

                        $arrFileName[] = $this->imageUpload($arrFile, $_GET['type'], $id = '');
                    }
                }
            }
            $arrAddStatus = $objAttribute->addAttribute($_POST, $arrFileName);

            if ($arrAddStatus['ret'] == 'manage') {
                $ref = 'attribute_manage_uil.php';
            } else {
                $ref = 'attribute_add_uil.php?type=' . $_GET['type'];
            }

            $objCore->setSuccessMsg($arrAddStatus['msg']);
            header('location:' . $ref);
            die;
        } else if (isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'edit' && $_GET['type'] == 'edit' && $_GET['attrbuteid'] != '') {

           // pre("here");
            //pre($_POST['frmHidenEdit']);

            foreach ($_POST['options'] as $key => $val) {

                if (isset($_FILES['attr_img']['name'][$key])) {

                    if ($_FILES['attr_img']['name'][$key] <> '' && $_FILES['attr_img']['error'][$key] == 0) {
                        $arrFile = array(
                            'name' => $_FILES['attr_img']['name'][$key],
                            'type' => $_FILES['attr_img']['type'][$key],
                            'tmp_name' => $_FILES['attr_img']['tmp_name'][$key],
                            'error' => $_FILES['attr_img']['error'][$key],
                            'size' => $_FILES['attr_img']['size'][$key]
                        );
                        $arrFileName[$key] = $this->imageUpload($arrFile, $_GET['type'], $_GET['attrbuteid']);
                    } else {
                        $arrFileName[$key] = $_POST['attr_old_img'][$key];
                    }
                }

                $_POST['optionsIds'][$key] = (int) $_POST['optionsIds'][$key];
            }

            // pre($arrFileName);
            //pre($aaa);
            $arrAddStatus = $objAttribute->updateAttribute($_POST, $arrFileName);
//            pre($_POST);
            if ($arrAddStatus['ret'] == 'manage') {
                $ref = $_POST['frmRef'];
            } else {
                $ref = 'attribute_edit_uil.php?type=' . $_GET['type'].'&attrbuteid=' . $_GET['attrbuteid'] . '&ref=' . $_POST['frmRef'];
            }
            
            $objCore->setSuccessMsg($arrAddStatus['msg']);
            header('location:' . $ref);
            die;            
        } else if (isset($_GET['attrbuteid']) && $_GET['attrbuteid'] != '' && ($_GET['type'] == 'edit')) {
             //pre("there");
            $varWhrAttri = $_GET['attrbuteid'];
            $this->arrRow = $objAttribute->editAttribute($varWhrAttri);
            // pre($this->arrRow);
        } else if (isset($_POST['Export']) && $_POST['Export'] == 'Export') {
            $this->exportAttribute($_POST);
        } else if (isset($_GET['type']) && $_GET['type'] == 'add') {
            
        } else {

            $this->getList();
        }
    }

// end of page load
//Export Start 
    function exportAttribute($arrPost) {

        $objCore = new Core();
        $objAttribute = new attribute();
        $arrAttribute = $objAttribute->attributeExportList('', '');
        $headings = array(
            'Attribute ID',
            'Attribute Code',
            'Attribute Label',
            'Attribute Visible',
            'Attribute Searchable',
            'Attribute Comparable',
            'Attribute Input Type',
            'Attribute Validation',
            'Category Names',
            'Attribute Date Added ',
        );

        if ($arrPost['fileType'] == 'csv') {


            $filename = 'attribute_list_' . time() . '.csv';

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



            if ($arrAttribute) {
                $count = 0;
                foreach ($arrAttribute as $varKey => $varValue) {
                    $schema_insert = '';
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['pkAttributeID']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['AttributeCode']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['AttributeLabel']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['AttributeVisible']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['AttributeSearchable']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['AttributeComparable']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['AttributeInputType']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['AttributeValidation']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CategoryNames']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['AttributeDateAdded']) . $csv_enclosed . $csv_separator;
                    $out .= $schema_insert;
                    $out .= $csv_terminated;
                    $count++;
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
            $objPHPExcel->getActiveSheet()->setTitle('category List');

            $varSheetName = 'attribute_list_' . time() . '.xls';

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

            if ($arrAttribute) {
                $rowNumber = 2;
                $col = 'A';
                $cnt = 0;
                foreach ($arrAttribute as $varKey => $varValue) {

                    //  $objPHPExcel->getActiveSheet()->setCellValueExplicit('A' . $rowNumber, '', PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('A' . $rowNumber, $varValue['pkAttributeID'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . $rowNumber, $varValue['AttributeCode'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('C' . $rowNumber, $varValue['AttributeLabel'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('D' . $rowNumber, $varValue['AttributeVisible'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('E' . $rowNumber, $varValue['AttributeSearchable'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('F' . $rowNumber, $varValue['AttributeComparable'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('G' . $rowNumber, $varValue['AttributeInputType'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('H' . $rowNumber, $varValue['AttributeValidation'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('I' . $rowNumber, $varValue['CategoryNames'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('J' . $rowNumber, $varValue['AttributeDateAdded'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $rowNumber++;
                    $cnt++;
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
            header('location:attribute_manage_uil.php');
        }
    }

    // end of page load

    /**
     * function imageUpload
     *
     * This function store image and return stored image name.
     *
     * Database Tables used in this function are : None
     *
     * Use Instruction : $objPage->imageUpload();
     *
     * @access public
     *
     * @return string varFileName
     */
    function imageUpload($argFILES, $argType, $argId) {
        global $arrProductImageResizes;

        $objCore = new Core();
        $objUpload = new upload();

        $infoExt = pathinfo($argFILES['name']);
        $arrName = basename($argFILES['name'], '.' . $infoExt['extension']);
        $ImageName = preg_replace('/\s\s+/', '_', $arrName);
        $ImageName = date('Ymd_his') . '_' . rand() . '.' . $infoExt['extension'];
        $objUpload->setMaxSize();
        $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/products/';

        // Set Directory
        $objUpload->setDirectory($varDirLocation);
        // CHECKING FILE TYPE.
        $varIsImage = $objUpload->IsImageValid($argFILES['type']);

        if ($varIsImage) {
            $varImageExists = 'yes';
        } else {
            $varImageExists = 'no';
        }

        if ($varImageExists == 'no') {
            $objCore->setErrorMsg("Invalid Image, Use image formats : jpg, png, gif");
            if ($argType == 'add') {
                header('location:attribute_add_uil.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:attribute_edit_uil.php?type=' . $argType . '&attrbuteid=' . $argId);
                die;
            }
        }

        if ($argFILES['error'] != 0) {
            $objCore->setErrorMsg('File upload error. Kindly try again.');
            if ($argType == 'add') {
                header('location:attribute_add_uil.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:attribute_edit_uil.php?type=' . $argType . '&attrbuteid=' . $argId);
                die;
            }
        } else if (trim($argFILES['size']) > 5242880) {
            $varError = true;
            $objCore->setErrorMsg('File size exceeds the given limit of 5 MB.');
            if ($argType == 'add') {
                header('location:attribute_add_uil.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:attribute_edit_uil.php?type=' . $argType . '&attrbuteid=' . $argId);
                die;
            }
        }

        if ($varImageExists == 'yes') {
            $objUpload->setTmpName($argFILES['tmp_name']);
            if ($objUpload->userTmpName) {
                $objUpload->setFileSize($argFILES['size']);
                // Set File Type
                $objUpload->setFileType($argFILES['type']);

                $varRand = rand();
                // Set File Name
                $fileName = strtolower($ImageName);
                $objUpload->setFileName($fileName);
                // Start Copy Process
                $objUpload->startCopy();
                // If there is error write the error message

                if ($objUpload->isError()) {
                    // resizing the file
                    $objUpload->resize();

                    $varFileName = $objUpload->userFileName;

                    $thumbnailName = 'original' . '/';
                    $objUpload->setThumbnailName($thumbnailName);
                    // create thumbnail
                    $objUpload->createThumbnail();

                    // Set a thumbnail name
                    // 70x70
                    //pre($arrProductImageResizes);
                    $crop = $arrProductImageResizes['default'] . '/';
                    list($width, $height) = explode('x', $arrProductImageResizes['default']);
                    $objUpload->setThumbnailName($crop);
                    $objUpload->createThumbnail();
                    $objUpload->setThumbnailSizeNew($width, $height);


                    //Get file name from the class public variable
                    //Get file extention
                    $varExt = substr(strrchr($varFileName, "."), 1);
                    $varThumbFileNameNoExt = substr($varFileName, 0, -(strlen($varExt) + 1));
                    //Create thumb file name
                    $varThumbFileName = $varThumbFileNameNoExt . '.' . $varExt;
                    return $varFileName;
                } else {
                    return '';
                }
            }
        }
    }

}

$objPage = new attributeCtrl();
$objPage->pageLoad();
?>
