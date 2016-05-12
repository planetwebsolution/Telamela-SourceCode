<?php
/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_category_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_PATH . 'class_common.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';
require COMPONENTS_SOURCE_ROOT_PATH . 'PHPExcel/Classes/PHPExcel.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'class_upload_inc.php';

class categoryCtrl extends Paging {
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
        $objCategory = new category();
        $objCore = new Core();

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

        if (isset($_REQUEST['frmSearch']) && $_REQUEST['frmSearch'] == 'Search') {
            $arrSearchParameter = $_GET;
            $varName = $arrSearchParameter['frmName'];
            $varParentId = $arrSearchParameter['frmParentId'];
            $varStatus = $arrSearchParameter['frmStatus'];
            $varTrash = $arrSearchParameter['frmTrashPressed'];

            $varWhrClause = '';
            if ($varName <> '') {
                $varWhereClause .= " AND c.CategoryName like '%" . addslashes($varName) . "%'";
            }
            if ($varParentId > 0) {
                $varWhereClause .= " AND c.CategoryParentId = " . $varParentId;
            }
            if ($varStatus <> '') {
                $varWhrClause = 'c.CategoryStatus = ' . $varStatus . ' ' . $varWhereClause;
            }

            if ($varStatus <> '') {
                $varWhrClause = 'c.CategoryStatus = ' . $varStatus . ' ' . $varWhereClause;
            }

            if ($varTrash <> '') {
                $varWhrClause = 'c.CategoryIsDeleted = 1 ' . $varWhereClause;
            } else {
                $varWhrClause = 'c.CategoryIsDeleted = 0 ' . $varWhereClause;
            }
            //echo $varWhrClause;



            $this->varPageStart = $objPaging->getPageStartLimit($_GET['page'], $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;

            $arrRecords = $objCategory->CategoryList($varWhrClause, '');

            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objCategory->CategoryList($varWhrClause, $this->varLimit);
            $this->varSortColumn = $objCategory->getSortColumn($_REQUEST);
        } else {
            if (isset($_GET['pcid'])) {
                $pid = (int) $_GET['pcid'];
            } else {
                $pid = (int) $_SESSION['cat']['gcid'];
            }

            $varWhr = "c.CategoryIsDeleted = '0' AND c.CategoryParentId='" . addslashes($pid) . "'";

            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;

            $arrRecords = $objCategory->CategoryList($varWhr, $limit = '');

            $this->NumberofRows = count($arrRecords);

            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objCategory->CategoryList($varWhr, $this->varLimit);
            $this->varSortColumn = $objCategory->getSortColumn($_REQUEST);
        }


        if (!empty($_REQUEST['frmID'])) {
            $all = 'all';
            //pre($_REQUEST);
            $objCategory->removeCategory($_REQUEST, $all);
            $objCore->setSuccessMsg(ADMIN_DELETE_SUCCUSS_MSG);
            header('location:category_manage_uil.php');
            die;
        } else if (isset($_REQUEST['frmUpdateOrder']) && $_REQUEST['frmUpdateOrder'] == 'order') {
            //pre($_REQUEST);
            $varUpdateCategoryOrder = $objCategory->updateCategoryOrder($_REQUEST);
            $objCore->setMultipleSuccessMsg($varUpdateCategoryOrder);
//            $objCore->setSuccessMsg(ADMIN_Order_UPDATE_SUCCUSS_MSG);
            header('location:category_manage_uil.php');
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
        global $objGeneral;
        $objCore = new Core();
        $objCategory = new category();
        $objClassCommon = new ClassCommon();
        //echo '<li>hi</li>';exit;

        if (isset($_GET['action']) && $_GET['action'] == 'reset') {
            unset($_SESSION['cat']);
            header('location:category_manage_uil.php');
            die;
        }


        if (isset($_POST['frmHidnAddEditPage']) && $_POST['frmHidnAddEditPage'] == 'addEditPage' && $_GET['type'] == 'add') {   // Editing images record
            //pre($_FILES);
            $varAddStatus = $objCategory->addCategory($_POST, $_FILES);

            if ($varAddStatus == 'exist') {
                $objCore->setErrorMsg(ADMIN_CATEGORY_ALREADY_EXISTS);
                header('location:category_manage_uil.php');
                die;
            } else if ($varAddStatus == 'trash') {
                $objCore->setSuccessMsg("Category With entered Name already exist in Trashed. Please restored it.");
                header('location:category_manage_uil.php');
                die;
            } else if ($varAddStatus == 'orderexist') {
                $objCore->setErrorMsg("This Order No. Already Exists");
                header('location:category_add_uil.php?type=' . $_GET['type']);
                die;
            } else if ($varAddStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_CATEGORY_ADD_SUCCUSS_MSG);
                header('location:category_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_CATEGORY_ADD_ERROR_MSG);
                header('location:category_add_uil.php?type=' . $_GET['type']);
                die;
            }
        } else if (isset($_POST['frmHidnAddEditPage']) && $_POST['frmHidnAddEditPage'] == 'addEditPage' && $_GET['type'] == 'edit' && $_GET['cid'] != '') {
            //pre($_FILES);
            $varUpdateStatus = $objCategory->updateCategory($_POST, $_FILES);
            //pre($varUpdateStatus);

            if ($varUpdateStatus == 'exist') {
                $objCore->setErrorMsg(ADMIN_CATEGORY_ALREADY_EXISTS);
                header('location:category_edit_uil.php?type=' . $_GET['type'] . '&cid=' . $_GET['cid'] . '&ref=' . $_POST['frmRef']);
                die;
            } else if ($varAddStatus == 'trash') {
                $objCore->setSuccessMsg("Category With entered Name already exist in Trashed. Please restored it.");
                header('location:' . $_POST['frmRef']);
                die;
            } else if ($varUpdateStatus == 'ordrexit') {
                //pre("yes");
                $objCore->setErrorMsg("This Order No. Alreay Exists.");
                header('location:category_edit_uil.php?type=' . $_GET['type'] . '&cid=' . $_GET['cid'] . '&ref=' . $_POST['frmRef']);
                die;
            } else if ($varUpdateStatus > 0) {

                $objCore->setSuccessMsg(ADMIN_CATEGORY_UPDATE_SUCCUSS_MSG);
                header('location:' . $_POST['frmRef']);
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_CATEGORY_UPDATE_ERROR_MSG);
                header('location:category_edit_uil.php?type=' . $_GET['type'] . '&cid=' . $_GET['cid'] . '&ref=' . $_POST['frmRef']);
                die;
            }
        } else if (isset($_GET['cid']) && $_GET['cid'] != '' && ($_GET['type'] == 'edit')) {
            $varWhrCms = $_GET['cid'];
            $this->arrRow = $objCategory->editCategory($varWhrCms);

            $this->arrCategoryDropDown = $objClassCommon->getCategories("CategoryHierarchy NOT LIKE '" . $this->arrRow['0']['CategoryHierarchy'] . "%' AND CategoryIsDeleted=0 ");

            //$this->arrCategoryDropDown = $objGeneral->CategoryDropDownList("c.CategoryHierarchy NOT LIKE '" . $this->arrRow['0']['CategoryHierarchy'] . "%' AND c.CategoryIsDeleted=0 ");
            //$this->arrCategoryDropDownLevel = $objGeneral->CategoryDropDownListLevel("c.CategoryHierarchy NOT LIKE '" . $this->arrRow['0']['CategoryHierarchy'] . "%' AND c.CategoryIsDeleted=0 ");
        } else if ($_GET['type'] == 'add') {
            $this->arrCategoryDropDown = $objClassCommon->getCategories("CategoryIsDeleted=0 ");
        } else if (isset($_POST['Export']) && $_POST['Export'] == 'Export') {
            $this->exportCategory($_POST);
        } else if (isset($_GET['action']) && $_GET['action'] == 'getChildCat') {

            $_SESSION['cat']['gcid'] = $_REQUEST['pcid'];

            $varWhrClause = "c.CategoryIsDeleted = '0' AND c.CategoryParentId='" . addslashes($_REQUEST['pcid']) . "'";
            $arrRecords = $objCategory->CategoryList($varWhrClause, '');
            $varStr = '';
            foreach ($arrRecords as $val) {

                $varStr .= '<li><a href="' . $val['pkCategoryId'] . '" level="' . $val['CategoryLevel'] . '"  class="parentCat">' . $val['CategoryName'] . '</a></li>';
            }
            if ($varStr == '') {
                $varStr .= '<li><a>' . ADMIN_NO_RECORD_FOUND . '</a></li>';
            }
            echo $varStr;
            die;
        } else if (isset($_GET['action']) && $_GET['action'] == 'getChildCatDetails') {
            $_SESSION['cat']['pcid'] = $_REQUEST['pcid'];
            $this->getChildCatDetails();
            die;
        } else {

            $varWhrClause = "c.CategoryIsDeleted = '0' AND c.CategoryParentId='" . addslashes($_SESSION['cat']['gcid']) . "'";
            $this->arrSubCat = $objCategory->CategoryList($varWhrClause, '');

            $this->arrCategoryDropDown = $objClassCommon->getCategories("CategoryIsDeleted=0 AND CategoryParentId=0");
            $this->getList();
        }
    }

// end of page load
    //Export Start
    function exportCategory($arrPost) {

        $objCore = new Core();
        $objCategory = new category();
        $arrCategoryDetails = $objCategory->catgoryExportList('', '');
        $arrCategory = $arrCategoryDetails['categoryDetails'];
        $headings = array(
            'Category Name',
            'Category Description',
            'Parent1',
            'Parent2',
            'Parent3',
            'Category Ordering',
            'Category Meta Title',
            'Category Meta Keywords',
            'Category Meta Description',
            'Category Level',
            'Category Status',
            'Category Date Added',
            'Category Date Modified',
        );

        if ($arrPost['fileType'] == 'csv') {


            $filename = 'category_list_' . time() . '.csv';

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



            if ($arrCategory) {
                $count = 0;
                foreach ($arrCategory as $varKey => $varValue) {
                    $schema_insert = '';
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CategoryName']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CategoryDescription']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['parent_0']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['parent_1']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['parent_2']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CategoryOrdering']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CategoryMetaTitle']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CategoryMetaKeywords']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CategoryMetaDescription']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CategoryLevel']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CategoryStatus']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CategoryDateAdded']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CategoryDateModified']) . $csv_enclosed . $csv_separator;
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

            $varSheetName = 'category_list_' . time() . '.xls';

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

            if ($arrCategory) {
                $rowNumber = 2;
                $col = 'A';
                $cnt = 0;
                foreach ($arrCategory as $varKey => $varValue) {

                    //  $objPHPExcel->getActiveSheet()->setCellValueExplicit('A' . $rowNumber, '', PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('A' . $rowNumber, $varValue['CategoryName'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . $rowNumber, $varValue['CategoryDescription'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('C' . $rowNumber, $varValue['parent_0'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('D' . $rowNumber, $varValue['parent_1'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('E' . $rowNumber, $varValue['parent_2'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('F' . $rowNumber, $varValue['CategoryOrdering'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('G' . $rowNumber, $varValue['CategoryMetaTitle'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('H' . $rowNumber, $varValue['CategoryMetaKeywords'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('I' . $rowNumber, $varValue['CategoryMetaDescription'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('J' . $rowNumber, $varValue['CategoryLevel'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('K' . $rowNumber, $varValue['CategoryStatus'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('L' . $rowNumber, $varValue['CategoryDateAdded'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('M' . $rowNumber, $varValue['CategoryDateModified'], PHPExcel_Cell_DataType::TYPE_STRING);
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
            header('location:category_manage_uil.php');
        }
    }

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
        //echo '<pre>';print_r($argFILES);die;
        $objCore = new Core();
        $objUpload = new upload();

        $infoExt = pathinfo($argFILES['frmNewsImage']['name']);
        $arrName = basename($argFILES['frmNewsImage']['name'], '.' . $infoExt['extension']);
        $ImageName = preg_replace('/\s\s+/', '_', $arrName);
        $ImageName = $ImageName . '.' . $infoExt['extension'];
        $objUpload->setMaxSize();
        $varDirLocation = UPLOAD_FILES_PATH . 'news/';
        // Set Directory
        $objUpload->setDirectory($varDirLocation);
        // CHECKING FILE TYPE.
        $varIsImage = $objUpload->IsImageValid($argFILES['frmNewsImage']['type']);
        if ($varIsImage) {
            $varImageExists = 'yes';
        } else {
            $varImageExists = 'no';
        }
        if ($varImageExists == 'no') {
            $objCore->setErrorMsg("Invalid Image, Use image formats : jpg, png, gif");
            if ($argType == 'addNews') {
                header('location:main_news_add.php?type=' . $argType . '&sucs=0');
            } else if ($argType == 'editNews') {
                header('location:main_news_add.php?type=' . $argType . '&mainNewsID=' . $argId . '&sucs=0');
            }
            die;
        }

        if ($argFILES['frmNewsImage']['error'] != 0) {
            $objCore->setErrorMsg('File upload error. Kindly try again.');
            if ($argType == 'addNews') {
                header('location:main_news_add.php?type=' . $argType . '&sucs=0');
            } else if ($argType == 'editNews') {
                header('location:main_news_add.php?type=' . $argType . '&mainNewsID=' . $argId . '&sucs=0');
            }
            die;
        } else if (trim($argFILES['frmNewsImage']['size']) > 5242880) {
            $varError = true;
            $objCore->setErrorMsg('File size exceeds the given limit of 5 MB.');
            if ($argType == 'addNews') {
                header('location:main_news_add.php?type=' . $argType . '&sucs=0');
            } else if ($argType == 'editNews') {
                header('location:main_news_add.php?type=' . $argType . '&mainNewsID=' . $argId . '&sucs=0');
            }
            die;
        }

        if ($varImageExists == 'yes') {
            $objUpload->setTmpName($argFILES['frmNewsImage']['tmp_name']);
            if ($objUpload->userTmpName) {
                $objUpload->setFileSize($argFILES['frmNewsImage']['size']);
                // Set File Type
                $objUpload->setFileType($argFILES['frmNewsImage']['type']);

                $varRand = rand();
                // Set File Name
                $fileName = $varRand . '_' . strtolower($ImageName);
                $objUpload->setFileName($fileName);
                // Start Copy Process
                $objUpload->startCopy();
                // If there is error write the error message
                if ($objUpload->isError()) {
                    // resizing the file
                    $objUpload->resize(684, 316);
                    // Set a thumbnail name
                    $thumbnailName1 = '_thumb';
                    $objUpload->setThumbnailName($thumbnailName1);
                    // create thumbnail
                    $objUpload->createThumbnail();
                    // change thumbnail size
                    $objUpload->setThumbnailSize(103, 63);
                    //Get file name from the class public variable
                    $varFileName = $objUpload->userFileName;
                    //Get file extention
                    $varExt = substr(strrchr($varFileName, "."), 1);
                    $varThumbFileNameNoExt = substr($varFileName, 0, -(strlen($varExt) + 1));
                    //Create thumb file name
                    $varThumbFileName = $varThumbFileNameNoExt . 'thumb.' . $varExt;
                    return $varFileName;
                } else {
                    return '0';
                }
            }
        }
    }

    function updateHierarchy($parentId, $catId) {
        $objCategory = new category();
        $objCategory->updateHierarchy($parentId, $catId);
    }

    function getChildCatDetails() {

        //$pid = $_GET['pcid'];
        $page = $_REQUEST['page'];
        if ($page <> '') {
            $arrPage = explode('page=', $page);
            $page = end($arrPage);
        }
        $_GET['page'] = $page;

        $this->getList();
        ?>
        <?php
        if ($this->NumberofRows > 0) {
            ?>
            <table class="table table-hover table-nomargin table-bordered usertable">
                <thead>
                    <tr>
                        <th class="with-checkbox hidden-480">
                            <input type="checkbox" onclick="javascript:toggleOption(this);" id="Main" value="1" name="Main" style="width:20px; border:none; float:left;">
                        </th>
                        <th valign="top" style="width:15%; text-align:center;">
                            Category Name
                        </th>
                        <th valign="top" style="width:15%; text-align:center;">
                            Description
                        </th>
                        <th valign="top" style="width:15%; text-align:center;">
                            Parent Category Name
                        </th>
                        <th class="hidden-1024">
                            Display Order <a href="javascript: void(0);" class="saveorder" title="Save Order"></a>
                        </th>
                        <th class="hidden-480">
                            Status
                        </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
            <?php
            $i = 1;
            foreach ($this->arrRows as $val) {
                ?>
                        <tr>
                            <td class="with-checkbox hidden-480">
                                <input type="checkbox" class="singleCheck" onclick="singleSelectClick(this, 'singleCheck');" value="<?php echo $val['pkCategoryId']; ?>" id="frmID[]" name="frmID[]" style="width:20px; border:none;">
                            </td>
                            <td><?php echo $val['CategoryName']; ?></td>
                            <td class="hidden-1024"><?php echo $val['CategoryDescription']; ?> </td>
                            <td class="hidden-480"><?php
                if ($val['CategoryParentName'] <> '') {
                    echo $val['CategoryParentName'];
                } else {
                    echo 'Parent';
                }
                ?> 
                                <input type="hidden" name="CategoryParentId[]" id="catlevel[]"  value="<?php echo $val['CategoryParentId']; ?>"/>
                            </td>
                            <td class="hidden-1024">
                                <input type="text" name="order[]" size="5" value="<?php echo $val['CategoryOrdering']; ?>" class="input-small" id="frmOrderId<?php echo $val['pkCategoryId']; ?>" onblur="return order_validation(this.value, 'frmOrderId<?php echo $val['pkCategoryId']; ?>')">
                                <input type="hidden" name="orderId[]" size="5" value="<?php echo $val['pkCategoryId']; ?>">
                            </td>
                            <td class="hidden-480">
                                <span id="cat<?php echo $val['pkCategoryId']; ?>">
                <?php
                if (empty($val['CategoryStatus'])) {
                    ?><a href="javascript:void(0);" title="click for active" class="active" onclick="changeStatus('1',<?php echo $val['pkCategoryId']; ?>)">Active</a><?php
                } else {
                    echo '<span class="label label-satgreen">Active</span>';
                }
                ?>
                <?php
                if (!empty($val['CategoryStatus'])) {
                    ?><a href="javascript:void(0);" title="click for deactive"  class="deactive" onclick="changeStatus('0',<?php echo $val['pkCategoryId']; ?>)">Deactive</a><?php
                } else {
                    echo '<a  href="" class="label label label-lightred">Deactive</a>';
                }
                ?>
                                </span>
                            </td>
                            <td>
                                <a href="category_edit_uil.php?type=edit&cid=<?php echo $val['pkCategoryId']; ?>" title="" rel="tooltip" data-original-title="Edit" class="btn"><i class="icon-edit"></i></a>
                                <a onClick='return fconfirm("Are you sure you want to delete this category? " + "\n" + "This category and its sub category will be moved to trash and Product will no longer visible on the front end !", this.href);' href="category_action.php?frmID=<?php echo $val['pkCategoryId']; ?>&frmChangeAction=delete" title="" rel="tooltip" data-original-title="Delete" class="btn"><i class="icon-remove"></i></a>
                                <input type="hidden" value="order" id="frmUpdateOrder" name="frmUpdateOrder">
                            </td>
                        </tr>
                <?php
                $i++;
            }
            ?>
                </tbody>
            </table>

            <div id = "DataTables_Table_0_paginate" class="dataTables_paginate paging_full_numbers">
            <?php
            if ($this->varNumberPages > 1) {
                $this->displayPaging($page, $this->varNumberPages, $this->varPageLimit);
            }
            ?>
            </div>

            <div class = "controls hidden-480">
                <select ata-rule-required = "true" onchange = "javascript:return setValidAction(this.value, this.form, 'Category(s)');" name = "frmChangeAction">
                    <option value = "">--Select Action--</option>
                    <option value = "Delete All">Delete</option>
                </select>
                <div class="fright hidden-480">
                    <div class="export fleft">
                        <div>
                            <label class="control-label" for="textfield" style="margin: 4px 0 0 10px">Export to: </label>
                        </div>
                        <div>
                            <select name="fileType" class="select2-me input-small">
                                <option value="csv">CSV</option>
                                <option value="excel">Excel</option>
                            </select>
                        </div>
                        <div>
                            <input type="submit" class="btn btn-primary" name="Export" value="Export" />
                        </div>
                        <div class="import fleft">
                            <a href="bulk_upload_uil.php?type=category" target="_blank"><span class="btn btn-inverse">Import</span></a>
                        </div>
                    </div>
                </div>
                <label class = "control-label" for = "textfield">This action will be performed on the above selected record(s). </label>
            </div>
            <?php
        } else {
            ?>
            <table class="table table-hover table-nomargin table-bordered usertable">
                <tr class="content">
                    <td colspan="10" style="text-align:center">
                        <strong><?php echo ADMIN_NO_RECORD_FOUND ?></strong>
                    </td>
                </tr>
            </table>

                <?php } ?>
                <?php
            }

        }

        $objPage = new categoryCtrl();
        $objPage->pageLoad();
        ?>
