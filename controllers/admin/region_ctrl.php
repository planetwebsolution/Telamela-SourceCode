<?php

/**
 * maincustomerManageCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_region_bll.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'class_upload_inc.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';

class regionCtrl extends Paging {
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
        $objRegion = new region();


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
        $arrRecords = $objRegion->RegionList($varWhereClause = '', $limit = '');
        $this->NumberofRows = count($arrRecords);
        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
        $this->arrRows = $objRegion->RegionList($varWhereClause = '', $this->varLimit);
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
        $objCore = new Core();
        $objRegion = new region();


        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'add' && $_GET['type'] == 'add') {   // Editing images record
           
            
             if ($_FILES['frmRegionImage']['name'] != '' && $_FILES['frmRegionImage']['error'][$keyImg] == 0) {
                 
                $_POST['varRegionImageName'] = $this->imageUpload($_FILES, 'add', 0);
             }else{
                 $_POST['varRegionImageName'] = '';
                 
             }
             
            $varAddStatus = $objRegion->addRegion($_POST);
            if ($varAddStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_ADD_SUCCUSS_MSG);
                header('location:region_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
                header('location:region_add_uil.php?type=' . $_GET['type']);
                die;
            }
        } else if (isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'edit' && $_GET['type'] == 'edit' && $_POST['countryId'] != '') {
            if ($_FILES['frmRegionImage']['name']) {
                $_POST['varRegionImageName'] = $this->imageUpload($_FILES, 'edit', $_POST['countryId']);
            } else {
                $_POST['varRegionImageName'] = $_POST['frmRegionImage'];
            }
            $varUpdateStatus = $objRegion->updateRegion($_POST);

            if ($varUpdateStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_UPDATE_SUCCUSS_MSG);
                header('location:region_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_UPDATE_ERROR_MSG);
                header('location:region_edit_uil.php?type=' . $_GET['type'] . '&countryId=' . $_GET['countryId']);
                die;
            }
        } else if (isset($_GET['countryId']) && $_GET['countryId'] != '' && ($_GET['type'] == 'edit')) {
            $varWhrCms = $_GET['countryId'];
            $this->arrRow = $objRegion->editRegion($varWhrCms);
        } else if ($_GET['type'] == 'add') {
            $this->varCountryList = $objRegion->CountryList();
        } else {

            $this->getList();
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
       //pre($argFILES);
        $objCore = new Core();
        $objUpload = new upload();

        $infoExt = pathinfo($argFILES['frmRegionImage']['name']);
        $arrName = basename($argFILES['frmRegionImage']['name'], '.' . $infoExt['extension']);
        $ImageName = preg_replace('/\s\s+/', '_', $arrName);
        $ImageName = date('Ymd_his') . '_' . rand() . '.' . $infoExt['extension'];
        $objUpload->setMaxSize();
        $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/regions/';

        // Set Directory
        $objUpload->setDirectory($varDirLocation);
        // CHECKING FILE TYPE.
         $varIsImage = $objUpload->IsImageValid($argFILES['frmRegionImage']['type']);

        if ($varIsImage) {
            $varImageExists = 'yes';
        } else {
            $varImageExists = 'no';
        }
        if ($varImageExists == 'no') {
            $objCore->setErrorMsg("Invalid Image, Use image formats : jpg, png, gif");
            if ($argType == 'add') {
                header('location:region_add_uil.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:region_edit_uil.php?type=' . $argType . '&pid=' . $argId);
                die;
            }
        }

        if ($argFILES['frmRegionImage']['error'] != 0) {
            $objCore->setErrorMsg('File upload error. Kindly try again.');
            if ($argType == 'add') {
                header('location:region_add_uil.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:region_edit_uil.php?type=' . $argType . '&pid=' . $argId);
                die;
            }
        } else if (trim($argFILES['frmRegionImage']['size']) > 5242880) {
            $varError = true;
            $objCore->setErrorMsg('File size exceeds the given limit of 5 MB.');
            if ($argType == 'add') {
                header('location:region_add_uil.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:region_edit_uil.php?type=' . $argType . '&pid=' . $argId);
                die;
            }
        }

        if ($varImageExists == 'yes') {
            $objUpload->setTmpName($argFILES['frmRegionImage']['tmp_name']);
            if ($objUpload->userTmpName) {
                $objUpload->setFileSize($argFILES['frmRegionImage']['size']);
                // Set File Type
                $objUpload->setFileType($argFILES['frmRegionImage']['type']);

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


                    // Set a thumbnail name
                    $thumbnailName1 = 'thumbs/';
                    $objUpload->setThumbnailName($thumbnailName1);
                    // create thumbnail
                    $objUpload->createThumbnail();
                    // change thumbnail size
                    $objUpload->setThumbnailSize(85, 75);
                    //Get file name from the class public variable
                    $varFileName = $objUpload->userFileName;


                    

                    //Get file extention
                    $varExt = substr(strrchr($varFileName, "."), 1);
                    $varThumbFileNameNoExt = substr($varFileName, 0, -(strlen($varExt) + 1));
                    //Create thumb file name
                    $varThumbFileName = $varThumbFileNameNoExt . '.' . $varExt;
                    return $varFileName;
                } else {
                    return '0';
                }
            }
        }
    }

}

$objPage = new regionCtrl();
$objPage->pageLoad();
?>