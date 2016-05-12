<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_cms_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';

class cmsCtrl extends Paging {
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
        $objCms = new cms();


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
        $arrRecords = $objCms->CmsList($varWhr = '', $limit = '');
        $this->NumberofRows = count($arrRecords);
        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
        $this->arrRows = $objCms->CmsList($varWhr = '', $this->varLimit);
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
        $objCms = new cms();

        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'add' && $_GET['type'] == 'add') {   // Editing images record

            $varAddStatus = $objCms->addCms($_POST);
            if ($varAddStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_CMS_ADD_SUCCUSS_MSG);
                header('location:cms_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_CMS_ADD_ERROR_MSG);
                header('location:cms_add_uil.php?type=' . $_GET['type']);
                die;
            }
        } else if(isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'edit' && $_GET['type'] == 'edit' && $_GET['cmsid'] != '') {

            $varUpdateStatus = $objCms->updateCms($_POST);

            if ($varUpdateStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_CMS_UPDATE_SUCCUSS_MSG);
                header('location:cms_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_CMS_UPDATE_ERROR_MSG);
                header('location:cms_edit_uil.php?type=' . $_GET['type'] . '&cmsid=' . $_GET['cmsid']);
                die;
            }
        } else if (isset($_GET['cmsid']) && $_GET['cmsid'] != '' && ($_GET['type'] == 'edit')) {
            $varWhrCms = $_GET['cmsid'];
            $this->arrRow = $objCms->editCms($varWhrCms);
        }else if(isset($_POST['frmHidenOffer']) && $_POST['frmHidenOffer'] == 'offer' && $_GET['type'] == 'offer'){
           
            
            $varUpdateStatus = $objCms->updateOffer($_POST);
                $objCore->setSuccessMsg(ADMIN_UPDATE_SUCCUSS_MSG);
                header('location:cms_manage_uil.php');
                die;
             
        }else if(isset($_GET['type']) && ($_GET['type'] == 'offer')) {            
            
            $this->arrProduct = $objCms->ProductList();
            $this->arrOffer = $objCms->todayOffer();
            
        } else {          
            $this->arrOffer = $objCms->todayOffer();            
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

}

$objPage = new cmsCtrl();
$objPage->pageLoad();
?>
