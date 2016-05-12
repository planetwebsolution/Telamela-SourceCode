<?php

require_once CLASSES_PATH . 'class_wholesaler_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'class_upload_inc.php';
require_once CLASSES_PATH . 'class_common.php';

class WholesalerManagePackageCtrl extends Paging {
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
        global $objGeneral;
        $objCore = new Core();
        $wid = $_SESSION['sessUserInfo']['id'];
        $objWholesaler = new Wholesaler();
        $objClassCommon = new ClassCommon();
        //$this->arrCategoryList = $objGeneral->CategoryDropDownList("c.CategoryIsDeleted=0 "); //$objWholesaler->CategoryList($wid);
        $this->arrCategoryList = $objClassCommon->getCategories("CategoryIsDeleted='0' AND CategoryStatus='1'");

        if ($_REQUEST['action']) {
            if ($_REQUEST['action'] == 'delete' && $_REQUEST['pkid']) {

                $varNum = $objWholesaler->wholesalerDeletePackage($_REQUEST['pkid'], $wid);
                if ($varNum > 0) {
                    $objCore->setSuccessMsg(ADMIN_DELETE_SUCCUSS_MSG);
                } else {
                    $objCore->setSuccessMsg(ADMIN_DELETE_ERROR_MSG);
                }
                header('location:manage_packages.php');
                die;
            }
            if ($_REQUEST['action'] == 'edit' && $_REQUEST['pkid']) {
                $pkid = $objCore->getFormatValue($_REQUEST['pkid']);
				
                $this->arrPackageDetail = $objWholesaler->wholesalerPackageDetail($pkid, $wid);
                if (count($this->arrPackageDetail) > 0) {
                    $this->arrPackageProducts = $objWholesaler->wholesalerPackageProductList($pkid);
                }
            }
            if ($_REQUEST['action'] == 'update' && $_REQUEST['pkid']) {

            	/* To check existancy of new package in db by Krishna Gupta (29-10-2015) starts */
            	/* Last Modified : 5-11-2015 */
            	$count = 0;
            	foreach ($_POST['frmProductId'] as $products) {
            		$productIds .= "find_in_set('".$products."',group_concat(fkProductId)) AND ";
            		$count++;
            	}
            	$condition = rtrim($productIds, ' AND ');
            	$this->checkUniquePackage = $objWholesaler->CheckExistancyOfPackage($condition, $count);
            	/* To check existancy of new package in db by Krishna Gupta (29-10-2015) ends */
            	 
            	//pre($this->checkUniquePackage);
            	 
            	/* If new package data is not existing in db */
            	if (! $this->checkUniquePackage) {
            		
	                if ($_FILES['frmPackageImage']['name'] != '' && $_FILES['frmPackageImage']['error'] == 0) {
	                    $_POST['PackageImage'] = $this->imageUpload($_FILES['frmPackageImage'], 'edit', $_REQUEST['pkid']);
	                } else {
	                    $_POST['PackageImage'] = $_POST['frmPackageImg'];
	                }
	
	                $varUpdateStatus = $objWholesaler->updatePackage($_POST);
	                if ($varUpdateStatus > 0) {
	                    $objCore->setSuccessMsg(ADMIN_UPDATE_SUCCUSS_MSG);
	                } else {
	                    $objCore->setErrorMsg(ADMIN_UPDATE_ERROR_MSG);
	                }
	                header('location:manage_packages.php');
	                die;
            	} else {
            		/*
            		 * If package is existing then show package detail in form fields
            		 */
            		$pkid = $objCore->getFormatValue($_REQUEST['pkid']);
            		$this->arrPackageDetail = $objWholesaler->wholesalerPackageDetail($pkid, $wid);
            		if (count($this->arrPackageDetail) > 0) {
            			$this->arrPackageProducts = $objWholesaler->wholesalerPackageProductList($pkid);
            		}
            	}
            }
            if ($_POST['action'] == 'add' && $_POST['pkid'] == '') {
            	
            	/* To check existancy of new package in db by Krishna Gupta (29-10-2015) starts */
            	$count = 0;
            	foreach ($_POST['frmProductId'] as $products) {
            		$productIds .= "find_in_set('".$products."',group_concat(productId)) AND ";
            		$count++;
            	}
            	$condition = rtrim($productIds, ' AND ');
            	$this->checkUniquePackage = $objWholesaler->CheckExistancyOfPackage($condition, $count, 'add');
            	/* To check existancy of new package in db by Krishna Gupta (29-10-2015) ends */
            	
            	//pre($this->checkUniquePackage);
            	
            	/* If new package data is not existing in db */
            	if (! $this->checkUniquePackage) {
	                if ($_FILES['frmPackageImage']['name'] != '' && $_FILES['frmPackageImage']['error'] == 0) {
	                    $_POST['PackageImage'] = $this->imageUpload($_FILES['frmPackageImage'], 'add', $id = '');
	                } else {
	                    $_POST['PackageImage'] = '';
	                }
	                /* echo '<pre>';
					print_r($_POST); die; */
	                $varAddStatus = $objWholesaler->addPackage($_POST);
	
	                if ($varAddStatus > 0) {
	                    $objCore->setSuccessMsg(ADMIN_ADD_SUCCUSS_MSG);
	                } else {
	                    $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
	                }
	                header('location:manage_packages.php');
	                die;
            	}
                
            } else if ($_GET['action'] == 'add') {
                
            }
        } else {
            $this->arrPackageList = $objWholesaler->wholesalerPackageList($wid);
            $this->paging($this->arrPackageList);
            $this->arrPackageList = $objWholesaler->wholesalerPackageList($wid, $this->varLimit);
        }
    }

    function getCategoryProduct($cid) {
        $objCore = new Core();
        $objWholesaler = new Wholesaler();
        $arrProducts = $objWholesaler->CategoryProductList($cid);
        return $arrProducts;
    }

    function paging($arrRecords) {
        $objPaging = new Paging();
        $this->varPageLimit = LIST_VIEW_RECORD_LIMIT;
        if (isset($_GET['page'])) {
            $varPage = $_GET['page'];
        } else {
            $varPage = '';
        }
        $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
        $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
        $this->NumberofRows = count($arrRecords);
        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
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

        $objCore = new Core();
        $objUpload = new upload();

        $infoExt = pathinfo($argFILES['name']);
        $arrName = basename($argFILES['name'], '.' . $infoExt['extension']);
        $ImageName = preg_replace('/\s\s+/', '_', $arrName);
        $ImageName = date('Ymd_his') . '_' . rand() . '.' . $infoExt['extension'];
        $objUpload->setMaxSize();
        $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/package/';

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
                header('location:add_new_package.php?action=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:edit_package.php?action=' . $argType . '&pkid=' . $argId);
                die;
            }
        }

        if ($argFILES['error'] != 0) {
            $objCore->setErrorMsg('File upload error. Kindly try again.');
            if ($argType == 'add') {
                header('location:add_new_package.php?action=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:edit_package.php?action=' . $argType . '&pkid=' . $argId);
                die;
            }
        } else if (trim($argFILES['size']) > 5242880) {
            $varError = true;
            $objCore->setErrorMsg('File size exceeds the given limit of 5 MB.');
            if ($argType == 'add') {
                header('location:add_new_package.php?action=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:edit_package.php?action=' . $argType . '&pkid=' . $argId);
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

                    // Set a thumbnail name
                    // 73x73 and 68x68

                    list($width, $height) = explode('x', PACKAGE_IMAGE_RESIZE1);
                    $thumbnailName1 = PACKAGE_IMAGE_RESIZE1 . '/';
                    $objUpload->setThumbnailName($thumbnailName1);
                    // create thumbnail
                    $objUpload->createThumbnail();
                    // change thumbnail size
                    $objUpload->setThumbnailSize($width, $height);
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

$objPage = new WholesalerManagePackageCtrl();
$objPage->pageLoad();
?>
