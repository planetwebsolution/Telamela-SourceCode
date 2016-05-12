<?php

require_once CLASSES_ADMIN_PATH . 'class_slider_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_PATH . 'class_common.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'class_upload_inc.php';

/**
 *
 * Module name : SpecialBannerCtrl
 *
 * Parent module : None
 *
 * Date created : 10th March 2014
 *
 * Date last modified :  11th March 2014
 *
 * Author :  Suraj Kumar Maurya
 *
 * Last modified by : Suraj Kumar Maurya
 *
 * Comments : The SpecialBannerCtrl class is used to manage special landing page banner.
 *
 */
class SpecialBannerCtrl extends Paging {

    public $varHeading = '';

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

    /**
     *
     * Function Name : getList
     *
     * Return type : Array
     *
     * Date created : 10th March 2014
     *
     * Date last modified :  10th March 2014
     *
     * Author : Suraj Kumar Maurya
     *
     * Last modified by : Suraj Kumar Maurya
     *
     * Comments : It will return list of banners.
     *
     * User instruction : $this->getList();
     *
     */
    private function getList() {
        $objPaging = new Paging();
        $objSlider = new Slider();
        $objCore = new Core();

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

        $varWhr = '';

        if (isset($_REQUEST['frmSearch']) && $_REQUEST['frmSearch'] == 'Search') {
            $arrSearchParameter = $_GET;
            $varStatus = $arrSearchParameter['frmStatus'];
            $varTitle = $arrSearchParameter['frmTitle'];

            if ($varTitle <> '') {
                $varWhr .= " AND BannerTitle like '%" . addslashes($varTitle) . "%'";
            }

            if ($varStatus <> '') {
                $varWhr .= " AND BannerStatus = '" . $varStatus . "'";
            }
        }

        $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
        $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
        $this->NumberofRows = $objSlider->bannerCountList($varWhr);
        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);

        $this->arrRows = $objSlider->bannerList($varWhr, $this->varLimit);
        $this->varSortColumn = $objSlider->getSortColumnBanner($_REQUEST);


        if (!empty($_REQUEST['frmID'])) {
            $all = 'all';
            $objSlider->removeAllBanner($_REQUEST, $all);
            //$objCategory->removeCategory($_REQUEST, $all);
            $objCore->setSuccessMsg(ADMIN_DELETE_SUCCUSS_MSG);
            header('location:special_banner_manage_uil.php');
            die;
        } else if (isset($_REQUEST['frmUpdateOrder']) && $_REQUEST['frmUpdateOrder'] == 'order') {

            $varUpdateCategoryOrder = $objSlider->updateBannerOrder($_REQUEST);
             $objCore->setMultipleSuccessMsg($varUpdateCategoryOrder);
//            $objCore->setSuccessMsg(ADMIN_Order_UPDATE_SUCCUSS_MSG);
            header('location:special_banner_manage_uil.php');
            die;
        }
    }

    /**
     *
     * Function Name : pageLoad
     *
     * Return type : void
     *
     * Date created : 10th March 2014
     *
     * Date last modified :  10th March 2014
     *
     * Author : Suraj Kumar Maurya
     *
     * Last modified by : Suraj Kumar Maurya
     *
     * Comments : This function Will be called on each page load and will check for any form submission.
     *
     * User instruction : $objPage->pageLoad();
     *
     */
    public function pageLoad() {
        global $objGeneral;
        $objCore = new Core();
        $objSlider = new Slider();
        $objClassCommon = new ClassCommon();

        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'add' && $_GET['type'] == 'add') {
            // pre($_POST);
            $_POST['frmImageName'] = $this->imageUpload($_FILES['frmImg'], $_GET['type'], $id = '');
            $varAddStatus = $objSlider->addBanner($_POST);
            if ($varAddStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_ADD_SUCCUSS_MSG);
                header('location:special_banner_manage_uil.php');
                die;
            }
             elseif($varAddStatus==='error')
            {
                 $objCore->setErrorMsg("This Order No.  Already Exists");
                header('location:special_banner_add_uil.php?type=' . $_GET['type']);
                die;
            }
            else {
                $objCore->setErrorMsg(ADMIN_CMS_ADD_ERROR_MSG);
                header('location:special_banner_add_uil.php?type=' . $_GET['type']);
                die;
            }
        } else if (isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'edit' && $_GET['type'] == 'edit' && $_GET['id'] != '') {
            if ($_FILES['frmImg']['name'] <> '') {
                $_POST['frmImageName'] = $this->imageUpload($_FILES['frmImg'], $_GET['type'], $id = '');
            }
            $varUpdateStatus = $objSlider->updateBanner($_POST);
            if ($varUpdateStatus ==1) {
                $objCore->setSuccessMsg(ADMIN_CMS_UPDATE_SUCCUSS_MSG);
                header('location:special_banner_manage_uil.php');
                die;
            } 
             elseif ($varUpdateStatus == 2) {
             $objCore->setErrorMsg("This Order No.  Already Exists");
                header('location:special_banner_edit_uil.php?type=' . $_GET['type'] . '&id=' . $_GET['id']);
                die;
        }
            else {
                $objCore->setErrorMsg(ADMIN_CMS_UPDATE_ERROR_MSG);
                header('location:special_banner_edit_uil.php?type=' . $_GET['type'] . '&id=' . $_GET['id']);
                die;
            }
        } else if (isset($_GET['id']) && $_GET['id'] != '' && ($_GET['type'] == 'edit')) {
            $varWhrCms = $_GET['id'];
            $this->arrRow = $objSlider->getBannerDetail($varWhrCms);
            $whrCat="CategoryParentId='0'";
            $this->arrCategoryDropDown = $objClassCommon->getCategories($whrCat);
        } else if (isset($_GET['type']) && $_GET['type'] == 'add') {
            $whrCat="CategoryParentId='0'";
            $this->arrCategoryDropDown = $objClassCommon->getCategories($whrCat);
            
        } else {
            //$this->arrCountry = $objSlider->getCountry();
            $this->getList();
        }
    }

    /**
     *
     * Function Name : imageUpload
     *
     * Return type : string
     *
     * Date created : 10th March 2014
     *
     * Date last modified :  10th March 2014
     *
     * Author : Suraj Kumar Maurya
     *
     * Last modified by : Suraj Kumar Maurya
     *
     * Comments : This function store image and return stored image name.
     *
     * User instruction : $objPage->imageUpload();
     *
     */
    function imageUpload($argFILES, $argType, $argId) {

        // pre($argFILES);
        global $arrSpecialPageBannerImage;
        $objCore = new Core();
        $objUpload = new upload();

        $infoExt = pathinfo($argFILES['name']);
        $arrName = basename($argFILES['name'], '.' . $infoExt['extension']);
        $ImageName = preg_replace('/\s\s+/', '_', $arrName);
        $ImageName = date('Ymd_his') . '_' . rand() . '.' . $infoExt['extension'];
        $objUpload->setMaxSize();
        $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/banner/';

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
                header('location:slider_add_uil.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:slider_edit_uil.php?type=' . $argType . '&pid=' . $argId);
                die;
            }
        }

        if ($argFILES['error'] != 0) {
            $objCore->setErrorMsg('File upload error. Kindly try again.');
            if ($argType == 'add') {
                header('location:slider_add_uil.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:slider_edit_uil.php?type=' . $argType . '&pid=' . $argId);
                die;
            }
        } else if (trim($argFILES['size']) > 5242880) {
            $varError = true;
            $objCore->setErrorMsg('File size exceeds the given limit of 5 MB.');
            if ($argType == 'add') {
                header('location:slider_add_uil.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:slider_edit_uil.php?type=' . $argType . '&pid=' . $argId);
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
                    /*
                      $objUpload->setThumbnailName('120x80/');
                      $objUpload->createThumbnail();
                      $objUpload->setThumbnailSize('120', '80');


                      $objUpload->setThumbnailName('600x400/');
                      $objUpload->createThumbnail();
                      $objUpload->setThumbnailSize('600', '400');

                     */
                    foreach ($arrSpecialPageBannerImage as $key => $val) {
                        $thumbnailName = $val . '/';
                        list($width, $height) = explode('x', $val);
                        $objUpload->setThumbnailName($thumbnailName);
                        $objUpload->createThumbnail();
                        $objUpload->setThumbnailSizeNew($width, $height);
                    }



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

$objPage = new SpecialBannerCtrl();
$objPage->pageLoad();
?>
