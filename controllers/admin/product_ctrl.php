<?php

/**
 * ProductCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_category_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_product_bll.php';
require_once CLASSES_PATH . 'class_common.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'class_upload_inc.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require COMPONENTS_SOURCE_ROOT_PATH . 'PHPExcel/Classes/PHPExcel.php';

class ProductCtrl extends Paging {
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
      //  pre("y");
        $objPaging = new Paging();
        $objProduct = new Product();
        global $objGeneral;
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs']);

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

        $varWhereClause = "1 ";
        if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') {
            $arrSearchParameter = $_GET;
            $varName = $arrSearchParameter['frmName'];
            $varPriceFrom = $arrSearchParameter['frmPriceFrom'];
            $varPriceTo = $arrSearchParameter['frmPriceTo'];
            $varCategory = $arrSearchParameter['frmCategory'];
            $varWholesaler = $arrSearchParameter['frmWholesaler'];
            $varStatus = $arrSearchParameter['frmStatus'];


            if ($varName <> '') {
                $varWhereClause .= " AND ProductName like '%" . addslashes($varName) . "%'";
            }
            if ($varPriceFrom > 0 && $varPriceTo > 0) {
                $varWhereClause .= " AND FinalPrice between " . $varPriceFrom . ' AND ' . $varPriceTo;
            }

            if ($varCategory > 0) {
                $varWhereClause .= " AND fkCategoryID = " . $varCategory;
            }

            if ($varWholesaler > 0) {
                $varWhereClause .= " AND fkWholesalerID = " . $varWholesaler;
            }
            if ($varStatus <> '') {
                $varWhereClause .= " AND ProductStatus = " . $varStatus;
            }

            $varWhrClause = $varWhereClause . $varPortalFilter;

            $this->varPageStart = $objPaging->getPageStartLimit($_GET['page'], $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;

            $arrRecords = $objProduct->ProductList($varWhrClause);

            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objProduct->ProductList($varWhrClause, $this->varLimit);
        } else {
            if ($_GET['id'] != '' && $_GET['filter'] == 'd') {
                $varWhrClause = " fkCustomerID='" . $_GET['id'] . "' and ViewDateAdded < curdate() - INTERVAL " . RECENT_REVIEW_MESSAGE_LIMIT . " DAY";

                $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
                $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
                $arrRecords = $objProduct->RecentReviewProductList($varWhrClause);

                $this->NumberofRows = count($arrRecords);

                $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
                $this->arrRows = $objProduct->RecentReviewProductList($varWhrClause, $this->varLimit);
            } else {
                $varWhrClause = $varWhereClause . $varPortalFilter;
                $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
                $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
                $arrRecords = $objProduct->ProductList($varWhrClause);

                $this->NumberofRows = count($arrRecords);

                $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
                $this->arrRows = $objProduct->ProductList($varWhrClause, $this->varLimit);
            }

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
        //pre($_REQUEST);
        global $objGeneral;
        $objCore = new Core();
        $objProduct = new Product();
        global $objGeneral;
        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs']);
        $varPortalFilterP = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'p.fkWholesalerID');
        $varPortalFilterPK = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs'], 'pkWholesalerID');

        $this->arrCountryList = $objProduct->countryList();
//$this->arrCategoryDropDown = $objGeneral->CategoryDropDownList('c.CategoryStatus=1 AND c.CategoryIsDeleted=0 ');
//$this->arrCategoryDropDownLevel = $objGeneral->CategoryDropDownListLevel('c.CategoryStatus=1 AND c.CategoryIsDeleted=0 ');
        $this->arrPackageDropDown = $objProduct->PackageFullDropDownList($varPortalFilter);

        $objClassCommon = new ClassCommon();
        $this->arrMarginCost = $objClassCommon->getMarginCast();
        $this->arrCategoryDropDown = $objClassCommon->getCategories();
//        pre($_REQUEST);
        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'add' && $_GET['type'] == 'add') {
            // product image
            foreach ($_POST['frmProductImg'] as $keyImg => $valImg) {
                if ($valImg != '') {
                    $arrFile['frmProductImg'] = array(
                        'name' => $valImg,
                        'x1' => $_POST['x1'][$keyImg],
                        'y1' => $_POST['y1'][$keyImg]
                    );
                    $arrFileName[] = $this->imageUploadedThumb($arrFile['frmProductImg']);
                }
            }

            // product attribute image
            foreach ($_POST['frmAttributeDefaultImg'] as $keyAttr => $valAttr) {
                foreach ($valAttr as $kAttr => $vAttr) {
                    // pre($vAttr);
                    if (isset($_POST['frmAttrImg'][$kAttr]) && $_POST['frmAttrImg'][$kAttr] <> '') {
                        $arrFileAttr = array(
                            'name' => $_POST['frmAttrImg'][$kAttr],
                            'x1' => $_POST['x1_attr'][$kAttr],
                            'y1' => $_POST['y1_attr'][$kAttr]
                        );

                        $isImgUploaded = 1;
                        $imgNm = $this->imageUploadedThumb($arrFileAttr);
                    } else {
                        $isImgUploaded = 0;
                        $imgNm = $vAttr;
                    }
                    $arrFileNameAttr[$kAttr]['imgnm'] = $imgNm;
                    $arrFileNameAttr[$kAttr]['isImgUploaded'] = $isImgUploaded;
                }
            }

            $varAddStatus = $objProduct->addProduct($_POST, $arrFileName, $arrFileNameAttr);

            if ($varAddStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_ADD_SUCCUSS_MSG);
                if (isset($_POST['saveAndAddNore'])) {
                    header('location:product_add_uil.php?type=add');
                } else {
                    header('location:product_manage_uil.php');
                }
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
                header('location:product_add_uil.php?type=' . $_GET['type']);
                die;
            }
        } else if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'addMultiple' && $_GET['type'] == 'addMultiple') {   // Editing images record
            // pre($_POST);
            $i = 0;
            // product image
            foreach ($_POST['frmProductImg'] as $keyImg => $valImg) {
                foreach ($valImg as $k => $v) {
                    if ($v != '') {
                        $arrFile['frmProductImg'] = array(
                            'name' => $v,
                            'x1' => $_POST['x1'][$keyImg][$k],
                            'y1' => $_POST['y1'][$keyImg][$k]
                        );

                        $arrFileName[$keyImg][] = $this->imageUploadedThumb($arrFile['frmProductImg']);
                    }
                }
                $i++;
            }

            // pre($_POST);
            // product attribute image
            foreach ($_POST['frmAttributeDefaultImg'] as $keyAttr => $valAttr) {

                foreach ($valAttr as $kAtt => $vAtt) {

                    foreach ($vAtt as $kAttr => $vAttr) {

                        if (isset($_POST['frmAttrImg'][$keyAttr][$kAttr]) && $_POST['frmAttrImg'][$keyAttr][$kAttr] <> '') {
                            $arrFileAttr = array(
                                'name' => $_POST['frmAttrImg'][$keyAttr][$kAttr],
                                'x1' => $_POST['x1_attr'][$keyAttr][$kAttr],
                                'y1' => $_POST['y1_attr'][$keyAttr][$kAttr]
                            );
                            $isImgUploaded = 1;
                            $imgNm = $this->imageUploadedThumb($arrFileAttr);
                        } else {
                            $isImgUploaded = 0;
                            $imgNm = $vAttr;
                        }

                        $arrFileNameAttr[$keyAttr][$kAttr]['imgnm'] = $imgNm;
                        $arrFileNameAttr[$keyAttr][$kAttr]['isImgUploaded'] = $isImgUploaded;
                    }
                }
            }

            $varAddStatus = $objProduct->addMultipleProduct($_POST, $arrFileName, $arrFileNameAttr);
            // pre($_POST);
            if ($varAddStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_ADD_SUCCUSS_MSG);
                header('location:product_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
                header('location:product_manage_uil.php');
                die;
            }
        } else if (isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'edit' && $_GET['type'] == 'edit' && $_GET['id'] != '') {

            // product image


            foreach ($_POST['frmProductImg'] as $keyImg => $valImg) {
                if ($valImg != '') {
                    $arrFile['frmProductImg'] = array(
                        'name' => $valImg,
                        'x1' => $_POST['x1'][$keyImg],
                        'y1' => $_POST['y1'][$keyImg]
                    );
                    $arrFileName[] = $this->imageUploadedThumb($arrFile['frmProductImg']);
                }
            }

            // product attribute image
            foreach ($_POST['frmAttributeDefaultImg'] as $keyAttr => $valAttr) {
                foreach ($valAttr as $kAttr => $vAttr) {
                    // pre($vAttr);
                    if (isset($_POST['frmAttrImg'][$kAttr]) && $_POST['frmAttrImg'][$kAttr] <> '') {
                        $arrFileAttr = array(
                            'name' => $_POST['frmAttrImg'][$kAttr],
                            'x1' => $_POST['x1_attr'][$kAttr],
                            'y1' => $_POST['y1_attr'][$kAttr]
                        );

                        $isImgUploaded = 1;
                        $imgNm = $this->imageUploadedThumb($arrFileAttr);
                    } else {
                        $isImgUploaded = $_POST['frmAttributeImgUploaded'][$keyAttr][$kAttr];
                        //$isImgUploaded = 0;
                        $imgNm = $vAttr;
                    }

                    $arrFileNameAttr[$kAttr]['imgnm'] = $imgNm;
                    $arrFileNameAttr[$kAttr]['isImgUploaded'] = $isImgUploaded;
                }
            }

            //$this->productmulcountrydetail = $objProduct->productmulcountrydetailAdmin($_GET['id']);
            
            $varUpdateStatus = $objProduct->updateProduct($_POST, $arrFileName, $arrFileNameAttr);

            if ($varUpdateStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_UPDATE_SUCCUSS_MSG);
                header('location:' . $_POST['httpRef']);
                header('location:product_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_UPDATE_ERROR_MSG);
                header('location:product_edit_uil.php?type=' . $_GET['type'] . '&id=' . $_GET['id'] . '&httpRef' . $_POST['httpRef']);
                die;
            }
        } else if (isset($_GET['id']) && $_GET['id'] != '' && ($_GET['type'] == 'edit')) {

            $varWhr = $_GET['id'];
            $this->arrRow = $objProduct->editProduct($varWhr, $varPortalFilter);
           // pre($this->arrRow);
            $weightunit=$this->arrRow[0]['WeightUnit'];
            $Weight=$this->arrRow[0]['Weight'];
            $DimensionUnit=$this->arrRow[0]['DimensionUnit'];
            $Lengthvalue=$this->arrRow[0]['Length'];
            $Widthvalue=$this->arrRow[0]['Width'];
            $Heightvalue=$this->arrRow[0]['Height'];
            $currentcountry=$this->arrRow[0]['CompanyCountry'];
            //pre($currentcountry);
            $this->arrImageRows = $objProduct->getImages($varWhr);
           // $this->arrWholesaler = $objProduct->WholesalerListBYCountry($varPortalFilterPK);
            $this->arrWholesaler = $objProduct->WholesalerListBYcurrentCountry($currentcountry);
            
            //pre($this->arrWholesaler);

            $varcatid = $this->arrRow[0]['fkCategoryID'];
            $arrProductOptions = $objProduct->ProductToOptions($varWhr);
            $this->arrProductOpt['optid'] = explode(',', $arrProductOptions[0]['optid']);
            $this->arrProductOpt['optCaption'] = explode(';;', $arrProductOptions[0]['AttributeOptionValue']);
            $this->arrProductOpt['optExtraPrice'] = explode(',', $arrProductOptions[0]['OptionExtraPrice']);
            $this->arrProductOpt['optval'] = explode(',', $arrProductOptions[0]['optval']);
            $this->arrProductOpt['optimg'] = explode(',', $arrProductOptions[0]['optimg']);
            $this->arrAttribute = $objProduct->CategoryToAttribute($varcatid);
            
            $current_country_id=$this->arrRow[0]['CompanyCountry'];
             
            // pre($current_country_id);
            $current_country_portal = $objGeneral->getcurrentCountryPortal($current_country_id);
            //pre($current_country_portal);
           // $this->arrShippingGateway = $objProduct->shippingGatewayList("fkportalID = " . $current_country_portal[0]['pkAdminID']);
           
            
            
           // $this->arrShippingGateway = $objProduct->WholesalerShippingGatwaysList($this->arrRow[0]['fkWholesalerID']);
            $this->arrWholesalerDropDown = $objProduct->WholesalerFullDropDownList($varPortalFilterPK);
            
            $this->productmulcountrydetail = $objProduct->productmulcountrydetailAdmin($_GET['id']);
            $locationvalue=$this->productmulcountrydetail[0]['producttype'];
            //pre($locationvalue);
            //pre($this->productmulcountrydetail);
            if($locationvalue=='multiple')
            {
                foreach($this->productmulcountrydetail as $val)
                {
                    $multiplecountriesvid[]=$val['country_id'];
                }
            }
            $convertweight = $objGeneral->convertproductweight($weightunit, $Weight);
           // $arrRows = $objGeneral->getlogisticnamebyarea($currentcountryid, $convertweight, $locationvalue,$Lengthvalue,$Widthvalue,$Heightvalue,$multiplecountriesvid);
             $this->arrShippingGateway = $objGeneral->getlogisticnamebyarea($current_country_id, $convertweight, $locationvalue,$Lengthvalue,$Widthvalue,$Heightvalue,$multiplecountriesvid,$DimensionUnit);
            
            
        } else if (isset($_GET['id']) && $_GET['id'] != '' && ($_GET['type'] == 'view')) {
            $varWhr = $_GET['id'];
            $this->arrRow = $objProduct->viewProduct($varWhr, $varPortalFilterP);
            $this->arrImageRows = $objProduct->getImages($varWhr);
            $varcatid = $this->arrRow[0]['fkCategoryID'];

            $arrProductOptions = $objProduct->ProductToOptions($varWhr);
            $this->arrProductOpt['optid'] = explode(',', $arrProductOptions[0]['optid']);
            $this->arrProductOpt['optval'] = explode(',', $arrProductOptions[0]['optval']);
            $this->arrAttribute = $objProduct->CategoryToAttribute($varcatid);
            $current_country_id=$this->arrRow[0]['CompanyCountry'];
             
            // pre($current_country_id);
            $current_country_portal = $objGeneral->getcurrentCountryPortal($current_country_id);
            //pre($current_country_portal);
            $this->arrShippingGateway = $objProduct->shippingGatewayList("fkportalID = " . $current_country_portal[0]['pkAdminID']);
            //$this->arrShippingGateway = $objProduct->WholesalerShippingGatwaysList($this->arrRow[0]['fkWholesalerID']);
        } else if (isset($_POST['Export']) && $_POST['Export'] == 'Export') {
            $this->exportProduct($_POST);
        } else if (isset($_GET['type']) && $_GET['type'] == 'add') {
            $this->arrWholesaler = $objProduct->WholesalerListBYCountry($varPortalFilterPK);
            $this->arrWholesalerDropDown = $objProduct->WholesalerFullDropDownList($varPortalFilterPK);
        } else {
            $this->getList();
            $this->arrWholesalerDropDown = $objProduct->WholesalerFullDropDownList($varPortalFilterPK);
            $this->varSortColumn = $objProduct->getSortColumn($_REQUEST);
        }
    }

// end of page load

    /**
     * function imageUploadedThumb
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
    function imageUploadedThumb($argFILES) {
        global $arrProductImageResizes;
        $objCore = new Core();
        $objUpload = new upload();

        $infoExt = pathinfo($argFILES['name']);
        $ImageName = $infoExt['basename'];
        $ext = strtolower($infoExt['extension']);
        $objUpload->setMaxSize();
        $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/products/';

// Set Directory
        $objUpload->setDirectory($varDirLocation);
// CHECKING FILE TYPE.

        if (in_array($ext, array('jpg', 'png', 'jpeg', 'gif'))) {

            $fileName = strtolower($ImageName);
            $objUpload->setFileName($fileName);
            // Start Copy Process
            //$objUpload->startCopy();
            // If there is error write the error message


            $varFileName = $objUpload->userFileName;

            $thumbnailName = 'original' . '/';
            $objUpload->setThumbnailName($thumbnailName);
            // create thumbnail
            $objUpload->createThumbnail();
            // change thumbnail size
            // $objUpload->setThumbnailSize($width, $height);


            $crop = $arrProductImageResizes['detailHover'] . '/';
            list($width, $height) = explode('x', $arrProductImageResizes['detailHover']);
            
            $dst_x = $argFILES['x1'];
            $dst_y = $argFILES['y1'];
            $objUpload->setThumbnailName('');
            $objUpload->createThumbnail();
            $objUpload->resizeCrop($width, $height, $dst_x, $dst_y);

            // Set a thumbnail name

            foreach ($arrProductImageResizes as $key => $val) {
                $thumbnailName = $val . '/';
                list($width, $height) = explode('x', $val);
                $objUpload->setThumbnailName($thumbnailName);
                // create thumbnail
                $objUpload->createThumbnail();
                // change thumbnail size
                //$objUpload->setThumbnailSize($width, $height);
                $objUpload->setThumbnailSizeNew($width, $height);
            }

//Get file name from the class public variable
//Get file extention
            $varExt = substr(strrchr($varFileName, "."), 1);
            $varThumbFileNameNoExt = substr($varFileName, 0, -(strlen($varExt) + 1));
//Create thumb file name
            $varThumbFileName = $varThumbFileNameNoExt . '.' . $varExt;
        } else {
            $varFileName = '';
        }
        return $varFileName;
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
                header('location:product_add_uil.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:product_edit_uil.php?type=' . $argType . '&pid=' . $argId);
                die;
            }
        }

        if ($argFILES['error'] != 0) {
            $objCore->setErrorMsg('File upload error. Kindly try again.');
            if ($argType == 'add') {
                header('location:product_add_uil.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:product_edit_uil.php?type=' . $argType . '&pid=' . $argId);
                die;
            }
        } else if (trim($argFILES['size']) > MAX_PRODUCT_IMAGE_SIZE) {
            $varError = true;
            $objCore->setErrorMsg('File size exceeds the given limit of 5 MB.');
            if ($argType == 'add') {
                header('location:product_add_uil.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:product_edit_uil.php?type=' . $argType . '&pid=' . $argId);
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
// $objUpload->resize();


                    $varFileName = $objUpload->userFileName;

                    $thumbnailName = 'original' . '/';
                    $objUpload->setThumbnailName($thumbnailName);
// create thumbnail
                    $objUpload->createThumbnail();
// change thumbnail size
// $objUpload->setThumbnailSize($width, $height);


                    $crop = $arrProductImageResizes['detailHover'] . '/';
                    list($width, $height) = explode('x', $arrProductImageResizes['detailHover']);

                    $dst_x = $argFILES['x1'];
                    $dst_y = $argFILES['y1'];
                    $objUpload->setThumbnailName();
                    $objUpload->createThumbnail();
                    $objUpload->resizeCrop($width, $height, $dst_x, $dst_y);

// Set a thumbnail name

                    foreach ($arrProductImageResizes as $key => $val) {
                        $thumbnailName = $val . '/';
                        list($width, $height) = explode('x', $val);
                        $objUpload->setThumbnailName($thumbnailName);
// create thumbnail
                        $objUpload->createThumbnail();
// change thumbnail size
                        $objUpload->setThumbnailSize($width, $height);
                    }




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
    function imageResize($argFile) {

        $objCore = new Core();
        $objUpload = new upload();

        $ImageName = $argFile;



        $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/products/';

// Set Directory
        $objUpload->setDirectory($varDirLocation);
// CHECKING FILE TYPE.
        $arrValidImg = array("jpg", "jpeg", "gif", "png");
        $arrExt = explode(".", $ImageName);


        $varIsImage = strtolower(end($arrExt));
//$objUpload->IsImageValid($varDirLocation.$ImageName);

        if (in_array($varIsImage, $arrValidImg)) {
            $varImageExists = 'yes';
        } else {
            $varImageExists = 'no';
            return;
        }


        if ($varImageExists == 'yes') {

            $objUpload->setFileName($ImageName);
// Start Copy Process
//  $objUpload->startCopy();
// If there is error write the error message
// resizing the file
//   $objUpload->resize(510, 450);

            $varFileName = $objUpload->userFileName;

// Set a thumbnail name
//Get file name from the class public variable
// 142x136 and 157x138 and 161x150
            $thumbnailName3 = '160x140/';
            $objUpload->setThumbnailName($thumbnailName3);
// create thumbnail
            $objUpload->createThumbnail();
// change thumbnail size
            $objUpload->setThumbnailSize(160, 140);


//Get file name from the class public variable
// 208x194 and 209x185
            $thumbnailName2 = '210x190/';
            $objUpload->setThumbnailName($thumbnailName2);
// create thumbnail
            $objUpload->createThumbnail();
// change thumbnail size
            $objUpload->setThumbnailSize(210, 190);

//Get file name from the class public variable
// 298x194
            $thumbnailName4 = '300x200/';
            $objUpload->setThumbnailName($thumbnailName4);
// create thumbnail
            $objUpload->createThumbnail();
// change thumbnail size
            $objUpload->setThumbnailSize(300, 200);

//Get file name from the class public variable
//Get file extention

            return $ImageName;
        }
    }

//Export Start
    function exportProduct($arrPost) {

        $objCore = new Core();
        $objProduct = new Product();
        $arrProduct = $objProduct->productExportList('', '');
//pre($arrWholesaler);
        $headings = array(
            'Product_Ref_No',
            'Product_Name',
            'Company_Name',
            'Wholesale_Price',
            'Discount_Price',
            'Category',
            'Shipping_Method',
            'Quantity',
            'Dimension_Unit',
            'Length',
            'Width',
            'Height',
            'Weight_Unit',
            'Weight',
            'Attributes',
            'Product_Description',
            'Youtube_Code',
            'Home_Slider_Image_800x600',
            'Default_Image_600x600',
            'Product_Images_600x800',
            'Meta_Title',
            'Meta_Keywords',
            'Meta_Description',
            'Quantity_Alert',
            'Product Date Added',
            'Product Date Updated'
        );

        if ($arrPost['fileType'] == 'csv') {


            $filename = 'product_list_' . time() . '.csv';

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



            if ($arrProduct) {

                foreach ($arrProduct as $varKey => $varValue) {
                    $schema_insert = '';
                    $varValue['ShippingTitle'] = $objProduct->findShippingGateway($varValue['fkShippingID']);
                    $varAttribute = $objProduct->findAttribute($varValue['pkProductID']);
                    foreach ($varAttribute as $k => $v) {
                        $varAttrVal[$k] = str_replace(',', '|', $v['AttributeCode'] . '#' . $v['OptionTitle']);
                    }
                    $varValue['Attribute'] = implode(";", $varAttrVal);
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ProductRefNo']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ProductName']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CompanyName']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['WholesalePrice']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['DiscountPrice']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['CategoryName']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ShippingTitle']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Quantity']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['DimensionUnit']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Length']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Width']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Height']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['WeightUnit']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Weight']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['Attribute']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ProductDescription']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['YoutubeCode']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ProductSliderImage']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ProductImage']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['ImageNames']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['MetaTitle']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['MetaKeywords']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['MetaDescription']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $varValue['QuantityAlert']) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $objCore->localDateTime($varValue['ProductDateAdded'], DATE_FORMAT_SITE)) . $csv_enclosed . $csv_separator;
                    $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $objCore->localDateTime($varValue['ProductDateUpdated'], DATE_FORMAT_SITE)) . $csv_enclosed . $csv_separator;

                    $out .= $schema_insert;
                    $out .= $csv_terminated;
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
            $objPHPExcel->getActiveSheet()->setTitle('Product List');

            $varSheetName = 'product_list_' . time() . '.xls';

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

            if ($arrProduct) {
                $rowNumber = 2;
                $col = 'A';

                foreach ($arrProduct as $varKey => $varValue) {

                    $varValue['ShippingTitle'] = $objProduct->findShippingGateway($varValue['fkShippingID']);
                    $varAttribute = $objProduct->findAttribute($varValue['pkProductID']);
                    foreach ($varAttribute as $k => $v) {
                        $varAttrVal[$k] = str_replace(',', '|', $v['AttributeCode'] . '#' . $v['OptionTitle']);
                    }
                    $varValue['Attribute'] = implode(";", $varAttrVal);
//  $objPHPExcel->getActiveSheet()->setCellValueExplicit('A' . $rowNumber, '', PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('A' . $rowNumber, $varValue['ProductRefNo'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . $rowNumber, $varValue['ProductName'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('C' . $rowNumber, $varValue['CompanyName'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('D' . $rowNumber, $varValue['WholesalePrice'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('E' . $rowNumber, $varValue['DiscountPrice'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('F' . $rowNumber, $varValue['CategoryName'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('G' . $rowNumber, $varValue['ShippingTitle'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('H' . $rowNumber, $varValue['Quantity'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('I' . $rowNumber, $varValue['DimensionUnit'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('J' . $rowNumber, $varValue['Length'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('K' . $rowNumber, $varValue['Width'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('L' . $rowNumber, $varValue['Height'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('M' . $rowNumber, $varValue['WeightUnit'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('N' . $rowNumber, $varValue['Weight'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('O' . $rowNumber, $varValue['Attribute'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('P' . $rowNumber, $varValue['ProductDescription'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('Q' . $rowNumber, $varValue['YoutubeCode'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('W' . $rowNumber, $varValue['ProductSliderImage'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('S' . $rowNumber, $varValue['ProductImage'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('W' . $rowNumber, $varValue['ImageNames'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('T' . $rowNumber, $varValue['MetaTitle'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('U' . $rowNumber, $varValue['MetaKeywords'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('V' . $rowNumber, $varValue['MetaDescription'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AB' . $rowNumber, $varValue['QuantityAlert'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AD' . $rowNumber, $objCore->localDateTime($varValue['ProductDateAdded'], DATE_FORMAT_SITE), PHPExcel_Cell_DataType::TYPE_STRING);
                    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AE' . $rowNumber, $objCore->localDateTime($varValue['ProductDateUpdated'], DATE_FORMAT_SITE), PHPExcel_Cell_DataType::TYPE_STRING);
                    $rowNumber++;
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
            header('location:product_manage_uil.php');
        }
    }

}

$objPage = new ProductCtrl();
$objPage->pageLoad();
?>
