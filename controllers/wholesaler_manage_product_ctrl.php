<?php

require_once CLASSES_PATH . 'class_wholesaler_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_common.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'class_upload_inc.php';

class WholesalerManageProductCtrl extends Paging {
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
        $this->wid = $wid;
        $objWholesaler = new Wholesaler();
        $objClassCommon = new ClassCommon();

// $this->arrCategoryList = $objGeneral->CategoryDropDownList("c.CategoryIsDeleted=0 "); // $objWholesaler->CategoryList($wid);
// $this->arrCategoryDropDownLevel = $objGeneral->CategoryDropDownListLevel("c.CategoryIsDeleted=0 ");

        $this->arrCategoryList = $objClassCommon->getCategories("CategoryIsDeleted='0' AND CategoryStatus='1'");

        $this->packageList = $objWholesaler->PackageFullDropDownList($wid);
        $this->wholesalercountry_id = $objWholesaler->getwholesalercountry_id($wid);
        $objClassCommon = new ClassCommon();
        $this->arrMarginCost = $objClassCommon->getMarginCast();


        $current_country_id = $_SESSION['sessUserInfo']['countryid'];
        //pre($_SESSION);
        $current_country_portal = $objGeneral->getcurrentCountryPortal($current_country_id);

        $this->arrShippingGatwayList = $objWholesaler->shippingGatewayList($current_country_id);
        //$this->arrShippingGatwayList = $objWholesaler->shippingGatewayList("fkportalID = " . $current_country_portal[0]['pkAdminID']);
        // $this->arrShippingGatwayList = $objWholesaler->getShippingGatwayList($wid);
        if ($_REQUEST['action']) {
            if ($_REQUEST['action'] == 'edit' && $_REQUEST['pid']) {
                // pre("64");
                $varWhr = $objCore->getFormatValue($_REQUEST['pid']);

                //$this->arrShippingGatwayList = $objWholesaler->getShippingGatwayList($wid);

                $this->productDetail = $objWholesaler->productDetail($varWhr, $wid);
                
                //pre($this->productDetail);

                $weightunit = $this->productDetail[0]['WeightUnit'];
                $Weight = $this->productDetail[0]['Weight'];
                $Lengthvalue = $this->productDetail[0]['Length'];
                $Widthvalue = $this->productDetail[0]['Width'];
                $Heightvalue = $this->productDetail[0]['Height'];
                $DimensionUnit = $this->productDetail[0]['DimensionUnit'];
               

                $this->productmulcountrydetail = $objWholesaler->productmulcountrydetail($_REQUEST['pid']);
                
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
             $this->arrShippingGatwayList = $objGeneral->getlogisticnamebyarea($current_country_id, $convertweight, $locationvalue,$Lengthvalue,$Widthvalue,$Heightvalue,$multiplecountriesvid,$DimensionUnit);

                if (count($this->productDetail) > 0) {
                    $this->productImages = $objWholesaler->productImages($varWhr);

                    $varcatid = $this->productDetail[0]['fkCategoryID'];

                    $this->specialEvents = $objWholesaler->getSpecialEvents($varcatid, $wid);
                    $this->specialProduct = $objWholesaler->getSpecialProductDetails($varWhr, $wid);

                    $arrProductOptions = $objWholesaler->ProductToOptions($varWhr);

                    $this->arrProductOpt['optid'] = explode(',', $arrProductOptions[0]['optid']);
                    $this->arrProductOpt['optCaption'] = explode(';;', $arrProductOptions[0]['AttributeOptionValue']);
                    $this->arrProductOpt['optExtraPrice'] = explode(',', $arrProductOptions[0]['OptionExtraPrice']);
                    $this->arrProductOpt['optval'] = explode(',', $arrProductOptions[0]['optval']);
                    $this->arrProductOpt['optimg'] = explode(',', $arrProductOptions[0]['optimg']);

                    $this->arrAttribute = $objWholesaler->CategoryToAttribute($varcatid);
                }
            } else if ($_REQUEST['action'] == 'update' && $_REQUEST['view'] == 'edit' && $_REQUEST['pid']) {

                // pre("90");
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
                            $imgNm = $vAttr;
                        }

                        $arrFileNameAttr[$kAttr]['imgnm'] = $imgNm;
                        $arrFileNameAttr[$kAttr]['isImgUploaded'] = $isImgUploaded;
                    }
                }

                $varUpdateStatus = $objWholesaler->updateProduct($_POST, $arrFileName, $arrFileNameAttr, $wid);
                if ($varUpdateStatus > 0) {
                    $objCore->setSuccessMsg(ADMIN_UPDATE_SUCCUSS_MSG);
                    header('location:manage_products.php');
                    die;
                } else {
                    $objCore->setErrorMsg(ADMIN_UPDATE_ERROR_MSG);
                    header('location:add_edit_product.php?action=edit&pid=' . $_REQUEST['pid']);
                    die;
                }
            } else if ($_REQUEST['action'] == 'update' && $_REQUEST['view'] == 'add') {
                //   pre($_POST);
                // pre("yes");
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

                $varAddStatus = $objWholesaler->addProduct($_POST, $arrFileName, $arrFileNameAttr, $wid);
                if ($varAddStatus > 0) {
                    $objCore->setSuccessMsg(ADMIN_ADD_SUCCUSS_MSG);
                    if (isset($_POST['submit'])) {
                        header('location:manage_products.php');
                    } else {
                        header('location:add_edit_product.php?&action=add');
                    }

                    die;
                } else {
                    $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
                    $objCore->setSuccessMsg(ADMIN_ADD_SUCCUSS_MSG);
                    header('location:manage_products.php');
                    die;
                }
            } else if ($_REQUEST['action'] == 'delete' && $_REQUEST['pid']) {
                $varNum = $objWholesaler->deleteProduct($_REQUEST['pid'], $wid);
                if ($varNum > 0) {
                    $objCore->setSuccessMsg(ADMIN_DELETE_SUCCUSS_MSG);
                } else {
                    $objCore->setSuccessMsg(ADMIN_DELETE_ERROR_MSG);
                }
                header('location:manage_products.php');
                die;
            } else if ($_REQUEST['action'] == 'addMulti' && $_REQUEST['frmfkWholesalerID']) {



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

                            $arrFileNameAttr[$keyAttr]['imgnm'] = $imgNm;
                            $arrFileNameAttr[$keyAttr]['isImgUploaded'] = $isImgUploaded;
                        }
                    }
                }


                $varAddStatus = $objWholesaler->addMultipleProduct($_POST, $arrFileName, $arrFileNameAttr);
                if ($varAddStatus > 0) {
                    $objCore->setSuccessMsg(ADMIN_ADD_SUCCUSS_MSG);
                    header('location:manage_products.php');
                    die;
                } else {
                    $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
                    header('location:manage_products.php');
                    die;
                }
            } else if ($_REQUEST['action'] == 'addMutiple') {
                
            }
        } else {
            $this->arrCountryList = $objWholesaler->countryList();
            $this->arrProductList = $objWholesaler->productList($wid);
            $this->paging($this->arrProductList);
            $this->arrProductList = $objWholesaler->productList($wid, $this->varLimit);
            $this->arrProductRatedList = $objCore->productListRating($wid);
        }
    }

// end of page load

    function paging($arrRecords) {
        $objPaging = new Paging();
        $this->varPageLimit = LIST_VIEW_RECORD_LIMIT;
        if (isset($_REQUEST['page'])) {
            $varPage = $_REQUEST['page'];
        } else {
            $varPage = 0;
        }
        $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
        $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
        $this->NumberofRows = $arrRecords;
        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);


// pre($this->varNumberPages);
    }

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
    function imageUpload($argFILES, $argType, $argId, $ImageFor = '') {
// pre($argFILES);
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
                header('location:add_edit_product.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:add_edit_product.php?action=edit&pid=' . $argId);
                die;
            }
        }

        if ($argFILES['error'] != 0) {
            $objCore->setErrorMsg('File upload error. Kindly try again.');
            if ($argType == 'add') {
                header('location:add_edit_product.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:add_edit_product.php?action=edit&pid=' . $argId);
                die;
            }
        } else if (trim($argFILES['size']) > MAX_PRODUCT_IMAGE_SIZE) {
            $varError = true;
            $objCore->setErrorMsg('File size exceeds the given limit of 5 MB.');
            if ($argType == 'add') {
                header('location:add_edit_product.php?type=' . $argType);
                die;
            } else if ($argType == 'edit') {
                header('location:add_edit_product.php?action=edit&pid=' . $argId);
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


                    // Set a thumbnail name

                    $thumbnailName = 'original' . '/';
                    $objUpload->setThumbnailName($thumbnailName);
                    // create thumbnail
                    $objUpload->createThumbnail();
                    // change thumbnail size
                    // $objUpload->setThumbnailSize($width, $height);
                    // Set a thumbnail name

                    $crop = $arrProductImageResizes['detailHover'] . '/';
                    list($width, $height) = explode('x', $arrProductImageResizes['detailHover']);

                    $objUpload->setThumbnailName();
                    $objUpload->createThumbnail();
                    $objUpload->setThumbnailSizeNew($width, $height);


                    foreach ($arrProductImageResizes as $key => $val) {
                        $thumbnailName = $val . '/';
                        list($width, $height) = explode('x', $val);
                        $objUpload->setThumbnailName($thumbnailName);
                        // create thumbnail
                        $objUpload->createThumbnail();
                        // change thumbnail size
                        $objUpload->setThumbnailSizeNew($width, $height);
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

}

$objPage = new WholesalerManageProductCtrl();

$objPage->pageLoad();
//pre($objPage);
?>
