<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_ads_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_PATH . 'class_common.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'class_upload_inc.php';

class AdsCtrl extends Paging {
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
        $objAds = new Ads();


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

        if (isset($_REQUEST['frmSearch']) && $_REQUEST['frmSearch'] == 'Search') {
            $arrSearchParameter = $_GET;
            $varType = $arrSearchParameter['frmType'];
            $varTitle = $arrSearchParameter['frmTitle'];

            $varWhr = '1';
            //pre($_REQUEST);
            if ($varTitle <> '') {
                $varWhr .= " AND Title like '%" . addslashes($varTitle) . "%'";
            }
            if ($varType <> '') {
                $varWhr .= " AND AdType = '" . $varType . "'";
            }

            //echo $varWhrClause;


            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = $objAds->adsList($varWhr, $limit = '');
            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objAds->adsList($varWhr, $this->varLimit);
            $this->varSortColumn = $objAds->getSortColumn($_REQUEST);
            //echo '<pre>';print_r($this->arrRows);die;                  
        } else {
            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = $objAds->adsList($varWhr = '', $limit = '');
            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objAds->adsList($varWhr = '', $this->varLimit);
            $this->varSortColumn = $objAds->getSortColumn($_REQUEST);
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
        global $objGeneral;
        $objCore = new Core();
        $objAds = new Ads();
        $objClassCommon = new ClassCommon();


        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'add' && $_GET['type'] == 'add') {   // Editing images record

        	if ($oCache->bEnabled)
        	{
        		$oCache->flushData();
        	}
        	if (isset($_FILES['frmImg']) && $_FILES['frmImg']['name'] <> '' && $_FILES['frmImg']['error'] == 0) {
                $arrFileName = $this->imageUpload($_FILES['frmImg'], $_GET['type'], $id = '', $_POST['frmImageSize']);
            } else {
                $arrFileName = '';
            }
            $_POST['frmImageName'] = $arrFileName;
            //pre($_FILES['frmImg']['name']);
            $varAddStatus = $objAds->addAds($_POST);
            if ($varAddStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_ADD_SUCCUSS_MSG);
                header('location:ads_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_CMS_ADD_ERROR_MSG);
                header('location:ads_add_uil.php?type=' . $_GET['type']);
                die;
            }
        } else if (isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'edit' && $_GET['type'] == 'edit' && $_GET['id'] != '') {
        	if ($oCache->bEnabled)
        	{
        		$oCache->flushData();
        	}
            //pre($_POST);
            if (isset($_FILES['frmImg']) && $_FILES['frmImg']['name'] <> '' && $_FILES['frmImg']['error'] == 0) {
                $arrFileName = $this->imageUpload($_FILES['frmImg'], $_GET['type'], $id = '', $_POST['frmImageSize']);
                $_POST['frmImageName'] = $arrFileName;
            }


            $varUpdateStatus = $objAds->updateAds($_POST);

            if ($varUpdateStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_CMS_UPDATE_SUCCUSS_MSG);
                header('location:ads_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_CMS_UPDATE_ERROR_MSG);
                header('location:ads_edit_uil.php?type=' . $_GET['type'] . '&id=' . $_GET['id']);
                die;
            }
        } else if (isset($_GET['id']) && $_GET['id'] != '' && ($_GET['type'] == 'edit')) {
            $varWhrCms = $_GET['id'];
            $this->arrRow = $objAds->editAds($varWhrCms);
            $whrCat="CategoryParentId='0'";
            $this->arrCategoryDropDown = $objClassCommon->getCategories($whrCat);
        } else if (isset($_GET['type']) && $_GET['type'] == 'add') {
            $whrCat="CategoryParentId='0'";
            $this->arrCategoryDropDown = $objClassCommon->getCategories($whrCat);
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
    function imageUpload($argFILES, $argType, $argId, $ImageSize) {
       
        $objCore = new Core();
        $objUpload = new upload();

        $infoExt = pathinfo($argFILES['name']);
        $arrName = basename($argFILES['name'], '.' . $infoExt['extension']);
        $ImageName = preg_replace('/\s\s+/', '_', $arrName);
        $ImageName = date('Ymd_his') . '_' . rand() . '.' . $infoExt['extension'];
        $objUpload->setMaxSize();
        $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/ads/';

        // Set Directory
        $objUpload->setDirectory($varDirLocation);
        // CHECKING FILE TYPE.
        $varIsImage = $objUpload->IsImageValid($argFILES['type']);
       // pre($varIsImage);
        if ($varIsImage) {
            $varImageExists = 'yes';
        } else {
            $varImageExists = 'no';
        }

        if ($varImageExists == 'no') {
            $objCore->setErrorMsg("Invalid Image, Use image formats : jpg, png, gif");
            if ($argType == 'add') {
                header('location:ads_add_uil.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:ads_edit_uil.php?type=' . $argType . '&pid=' . $argId);
                die;
            }
        }

        if ($argFILES['error'] != 0) {
            $objCore->setErrorMsg('File upload error. Kindly try again.');
            if ($argType == 'add') {
                header('location:ads_add_uil.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:ads_edit_uil.php?type=' . $argType . '&pid=' . $argId);
                die;
            }
        } else if (trim($argFILES['size']) > 5242880) {
            $varError = true;
            $objCore->setErrorMsg('File size exceeds the given limit of 5 MB.');
            if ($argType == 'add') {
                header('location:ads_add_uil.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:ads_edit_uil.php?type=' . $argType . '&pid=' . $argId);
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

                $szAry = explode('x', $ImageSize);
                if ($objUpload->isError()) {
                    // resizing the file
                    $objUpload->resize();
                    $varFileName = $objUpload->userFileName;
                    $objUpload->setThumbnailName($ImageSize . '/');
                    $objUpload->createThumbnail();
                    $objUpload->setThumbnailSize($szAry[0], $szAry[1]);

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

$objPage = new AdsCtrl();
$objPage->pageLoad();
?>
