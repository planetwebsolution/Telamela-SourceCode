<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_package_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_PATH . 'class_common.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'class_upload_inc.php';
require_once CLASSES_PATH . 'class_common.php';

class PackageCtrl extends Paging {
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
        $objPackage = new Package();
        global $objGeneral;
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'pkg.fkWholesalerID');

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
            $varPackageName = $arrSearchParameter['frmPackageName'];
            $varProducts = $arrSearchParameter['frmProducts'];
            $varActualPrice = $arrSearchParameter['frmActualPrice'];
            $varPackagePrice = $arrSearchParameter['frmPackagePrice'];
            $varWholeSalerId = $arrSearchParameter['frmWholesaler'];

            $varWhrClause = '1';
            if ($varPackageName <> '') {
                $varWhrClause .= " AND PackageName like '%" . addslashes($varPackageName) . "%'";
            }

            if ($varProducts <> '') {
                $varWhrClause .= " AND ProductName like '%" . addslashes($varProducts) . "%'";
            }
            if ($varPackagePrice > 0) {
                $varWhrClause .= " AND PackagePrice = " . $varPackagePrice;
            }
            if ($varWholeSalerId <> '') {
                $varWhrClause .= " AND pkg.fkWholesalerID =" . $varWholeSalerId;
            }
            $varWhrClause = $varWhrClause . $varPortalFilter;
            //pre( $varWhrClause);

            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = $objPackage->packageList($varWhrClause, $limit = '');
            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objPackage->packageList($varWhrClause, $this->varLimit);
            $this->varSortColumn = $objPackage->getSortColumn($_REQUEST);
            //echo '<pre>';print_r($this->arrRows);die;
        } else {
            $varWhrClause = "1 " . $varPortalFilter;
            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = $objPackage->packageList($varWhrClause);
            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objPackage->packageList($varWhrClause, $this->varLimit);
            $this->varSortColumn = $objPackage->getSortColumn($_REQUEST);
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
        $objPackage = new Package();
        $objClassCommon = new ClassCommon();

        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'pkWholesalerID');
        $varPortalFilterFK = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs']);


        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'add' && $_GET['type'] == 'add') {   // Editing images record
        	
        	/* To check existancy of new package in db by Krishna Gupta (29-10-2015) starts */
        	/* Last Modified : 06-11-2015 */
        	$count = 0;
        	foreach ($_POST['frmProductId'] as $products) {
        		$productIds .= "find_in_set('".$products."',group_concat(fkProductId)) AND ";
        		$count++;
        	}
        	$condition = rtrim($productIds, ' AND ');
        	$checkUniquePackage = $objPackage->CheckExistancyOfPackage($condition, $count, $_GET['type']);
        	/* To check existancy of new package in db by Krishna Gupta (06-11-2015) ends */
        	     
        	if (!$checkUniquePackage) {
	        	if ($_FILES['frmPackageImage']['name'] != '' && $_FILES['frmPackageImage']['error'] == 0) {
	                $_POST['PackageImage'] = $this->imageUpload($_FILES['frmPackageImage'], $_GET['type'], $id = '');
	            } else {
	                $_POST['PackageImage'] = '';
	            }
	
	            $varAddStatus = $objPackage->addPackage($_POST);
	
	
	            if ($varAddStatus > 0) {
	
	                $objCore->setSuccessMsg(ADMIN_ADD_SUCCUSS_MSG);
	                header('location:package_manage_uil.php');
	                die;
	            } else {
	                $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
	                header('location:package_add_uil.php?type=' . $_GET['type']);
	                die;
	            }
        	} else {
        		header('location:package_add_uil.php?type=' . $_GET['type'] . '&whid=' . $_GET['whid'] . '&status=' . $checkUniquePackage);
        	}
        } else if (isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'edit' && $_GET['type'] == 'edit' && $_GET['pkgid'] != '') {
			//pre($_POST);
        	/* To check existancy of new package in db by Krishna Gupta (29-10-2015) starts */
        	/* Last Modified : 06-11-2015 */
        	$count = 0;
        	foreach ($_POST['frmProductId'] as $products) {
        		$productIds .= "find_in_set('".$products."',group_concat(fkProductId)) AND ";
        		$count++;
        	}
        	$condition = rtrim($productIds, ' AND ');
        	$checkUniquePackage = $objPackage->CheckExistancyOfPackage($condition, $count);
        	/* To check existancy of new package in db by Krishna Gupta (06-11-2015) ends */
        	
        	/* Condition if package is not existing in DB by Krishna Gupta 6-11-2015 */
        	if (!$checkUniquePackage) {
            if ($_FILES['frmPackageImage']['name'] != '' && $_FILES['frmPackageImage']['error'] == 0) {
                $_POST['PackageImage'] = $this->imageUpload($_FILES['frmPackageImage'], $_GET['type'], $id = '');
            } else {
                $_POST['PackageImage'] = $_POST['PackageImageHide'];
            }

            $varUpdateStatus = $objPackage->updatePackage($_POST);

            if ($varUpdateStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_CMS_UPDATE_SUCCUSS_MSG);
                header('location:package_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_CMS_UPDATE_ERROR_MSG);
                header('location:package_edit_uil.php?type=' . $_GET['type'] . '&pkgid=' . $_GET['pkgid']);
                die;
            }
            
        	}
        		/* If package is existing in DB by Krishna Gupta 6-11-2015 */
        	else {
        		header('location:package_edit_uil.php?type=' . $_GET['type'] . '&pkgid=' . $_GET['pkgid'] . '&status=' . $checkUniquePackage);
        	}
        	
        } else if (isset($_GET['pkgid']) && $_GET['pkgid'] != '' && ($_GET['type'] == 'edit')) {
            
        	$varWhr = $_GET['pkgid'];
            $this->arrCategoryDropDown = $objClassCommon->getCategories();
            $this->arrRow = $objPackage->editPackage($varWhr, $varPortalFilterFK);
            $this->arrWholesaler = $objPackage->WholesalerList($varPortalFilter);
        } else if (isset($_GET['type']) && $_GET['type'] == 'add') {
            $this->arrWholesaler = $objPackage->WholesalerList($varPortalFilter);
            $this->arrCategoryDropDown = $objClassCommon->getCategories();
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
                header('location:package_add_uil.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:package_edit_uil.php?type=' . $argType . '&pid=' . $argId);
                die;
            }
        }

        if ($argFILES['error'] != 0) {
            $objCore->setErrorMsg('File upload error. Kindly try again.');
            if ($argType == 'add') {
                header('location:package_add_uil.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:package_edit_uil.php?type=' . $argType . '&pid=' . $argId);
                die;
            }
        } else if (trim($argFILES['size']) > 5242880) {
            $varError = true;
            $objCore->setErrorMsg('File size exceeds the given limit of 5 MB.');
            if ($argType == 'add') {
                header('location:package_add_uil.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:package_edit_uil.php?type=' . $argType . '&pid=' . $argId);
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

$objPage = new PackageCtrl();
$objPage->pageLoad();
?>
