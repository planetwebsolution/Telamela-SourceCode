<?php

/* * ****************************************
  Module name : Ajax Image uploader Calls
  Date created : 31 Jan, 2014
  Date last modified : 31 Jan, 2014
  Author : Suraj Kumar Maurya
  Last modified by :  Suraj Kumar Maurya
  Comments : This file includes the funtions for AJAX calls.
  Copyright : Copyright (C) 1999-2011 Vinove Software and Services
 * **************************************** */
require_once '../config/config.inc.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'class_upload_inc.php';

$varcase = $_REQUEST['action'];

switch ($varcase) {
    case 'uploadProductImage':

        $str = '';
        if (isset($_FILES)) {

            foreach ($_FILES as $file) {
                if ($file['name'] != '' && $file['error'] == 0) {
                    $arrResponse = imageUpload($file);
                    if ($arrResponse['error'] <> '') {
                        $str = '<div class="req">' . $arrResponse['error'] . '</div>';
                    } else {
                        
                        if (isset($_REQUEST['rowNum'])) {
                            $ro = explode('_', $_REQUEST['rowNum']);
                            $rownum = $ro['1'];
                            $pImgName = 'frmProductImg[' . $rownum . '][]';
                            $x1Name = 'x1[' . $rownum . '][]';
                            $y1Name = 'y1[' . $rownum . '][]';
                            $default = 'default[' . $rownum . ']';
                        } else {
                            $pImgName = 'frmProductImg[]';
                            $x1Name = 'x1[]';
                            $y1Name = 'y1[]';
                            $default = 'default';
                        }
                        
                        $chkd = ($_GET['deflt']=='1') ? 'checked="checked"' : '';
                        
                        $arrcls = explode('.', $arrResponse['name']);
                        $ids = implode('a', $arrcls);
                        $str = '<div>
                                    <img src="' . $objCore->getImageUrl($arrResponse['name'], 'products/' . $arrProductImageResizes['default']) . '" />
                                    <a href="#' . $ids . '" onclick="jCropPopupOpen(\'' . $ids . '\');" class="' . $ids . '">Crop</a>
                                    <input type="radio" name="'.$default.'" class="default" value="' . $arrResponse['name'] . '" ' . $chkd. ' /> Default
                                </div>
                                 <div style="display:none">
                                    <div id="' . $ids . '">
                                        <div style="overflow:auto; width:800px;height:600px">
                                            <img class="target" src="' . $objCore->getImageUrl($arrResponse['name'], 'products') . '" />
                                            <input type="hidden" value="0" name="'.$x1Name.'" class="x1" size="4"/>
                                            <input type="hidden" value="0" name="'.$y1Name.'" class="y1" size="4"/>
                                            <input type="hidden" value="' . $arrResponse['name'] . '" name="'.$pImgName.'" />
                                       </div>
                                       <div style="margin:10px 0 10px 200px;float:left; text-align:center;">
                                            <input type="button" class="submit button ok" name="ok" value="Crop" style="cursor: pointer;"/>
                                       </div>
                                    </div>
                                </div>';
                    }
                } else {
                    $str = '<div class="req">invalid files</div>';
                }
            }
        } else {
            $str = '<div class="req">invalid Access !<div>';
        }
        // $data['response'] = $str;
        echo $str;

        break;

    case 'uploadProductImageAttr':
        $str = '';
        if (isset($_FILES)) {

            foreach ($_FILES as $file) {
                if ($file['name'] != '' && $file['error'] == 0) {
                    $arrResponse = imageUpload($file);
                    if ($arrResponse['error'] <> '') {
                        $str = '<div class="req">' . $arrResponse['error'] . '</div>';
                    } else {
                        $optId = $_REQUEST['optid'];
                        
                        if (isset($_REQUEST['rowNum'])) {
                            $rownum = $_REQUEST['rowNum'];
                            $pImgName = 'frmAttrImg[' . $rownum . '][' . $optId . ']';
                            $x1Name = 'x1_attr[' . $rownum . '][' . $optId . ']';
                            $y1Name = 'y1_attr[' . $rownum . '][' . $optId . ']';
                        } else {
                            $pImgName = 'frmAttrImg[' . $optId . ']';
                            $x1Name = 'x1_attr[' . $optId . ']';
                            $y1Name = 'y1_attr[' . $optId . ']';
                        }

                        $arrcls = explode('.', $arrResponse['name']);
                        $ids = implode('a', $arrcls);
                        $str = '<div>
                                    <img src="' . $objCore->getImageUrl($arrResponse['name'], 'products/' . $arrProductImageResizes['default']) . '" />
                                    <a href="#' . $ids . '" onclick="jCropPopupOpen(\'' . $ids . '\');" class="' . $ids . '">Crop</a>
                                </div>
                                <div style="display:none">
                                    <div id="' . $ids . '">
                                        <div style="overflow:auto; width:800px;height:600px">
                                            <img class="target" src="' . $objCore->getImageUrl($arrResponse['name'], 'products') . '" />
                                            <input type="hidden" value="0" name="'.$x1Name.'" class="x1" size="4"/>
                                            <input type="hidden" value="0" name="'.$y1Name.'" class="y1" size="4"/>
                                            <input type="hidden" value="' . $arrResponse['name'] . '" name="'.$pImgName.'"/>
                                        </div>
                                        <div style="margin:10px 0 10px 200px;float:left; text-align:center;">
                                            <input type="button" class="submit button ok" name="ok" value="Crop" style="cursor: pointer;"/>
                                        </div>
                                    </div>
                               </div>';
                    }
                } else {
                    $str = '<div class="req">invalid files</div>';
                }
            }
        } else {
            $str = '<div class="req">invalid Access !<div>';
        }
        // $data['response'] = $str;
        echo $str;

        break;
    case 'saveImageAfterCrop':
    global $arrProductImageResizes;
    //$objCore = new Core();

    $objUpload = new upload();    
    $imageSrc=SOURCE_ROOT.'/'.$_REQUEST['imageSrc'];
    $imageName=$_REQUEST['imageName']; 
    $varDest=UPLOADED_FILES_SOURCE_PATH."images/products/".$imageName; 
    $varDestToShow=UPLOADED_FILES_URL."images/products/".$arrProductImageResizes['default']."/".$imageName; 
    
    if(!copy($imageSrc,$varDest)){
     echo 'error';   
    }else{
    $infoExt = pathinfo($imageName);
    $arrName = basename($imageName, '.' . $infoExt['extension']);
    $ImageName = $imageName;
    $objUpload->setMaxSize();
    $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/products/';
    $objUpload->setDirectory($varDirLocation);
    $fileName = strtolower($ImageName);
    $objUpload->setFileName($fileName);
    $thumbnailName = $arrProductImageResizes['default'] . '/';
    list($width, $height) = explode('x', $arrProductImageResizes['default']);
    $objUpload->setThumbnailName($thumbnailName);
    $objUpload->createThumbnail();
    $objUpload->setThumbnailSizeNew($width, $height);
    unlink($imageSrc);
    echo $varDestToShow;
    }    
    break; 
    
    case 'savePackageImageAfterCrop':
    global $arrProductImageResizes;
    //$objCore = new Core();

    $objUpload = new upload();    
    $imageSrc=SOURCE_ROOT.'/'.$_REQUEST['imageSrc'];
    $imageName=$_REQUEST['imageName']; 
    $varDest=UPLOADED_FILES_SOURCE_PATH."images/package/".$imageName; 
    $varDestToShow=UPLOADED_FILES_URL."images/package/65x65/".$imageName; 
    
    if(!copy($imageSrc,$varDest)){
     echo 'error';   
    }else{
    $infoExt = pathinfo($imageName);
    $arrName = basename($imageName, '.' . $infoExt['extension']);
    $ImageName = $imageName;
    $objUpload->setMaxSize();
    $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/package/';
    $objUpload->setDirectory($varDirLocation);
    $fileName = strtolower($ImageName);
    $objUpload->setFileName($fileName);
    $thumbnailName = '65x65/';
    list($width, $height) = explode('x', '65x65');
    $objUpload->setThumbnailName($thumbnailName);
    $objUpload->createThumbnail();
    $objUpload->setThumbnailSizeNew($width, $height);
    $thumbnailName = '161x148/';
    list($width, $height) = explode('x', '161x148');
    $objUpload->setThumbnailName($thumbnailName);
    $objUpload->createThumbnail();
    $objUpload->setThumbnailSizeNew($width, $height);
    unlink($imageSrc);
    echo $varDestToShow;
    }    
    break; 
    
    case 'saveImageAfterCropLogo':
    $imageSrc=SOURCE_ROOT.'/'.$_REQUEST['imageSrc'];
    $imageName=$_REQUEST['imageName']; 
    $varDest=UPLOADED_FILES_SOURCE_PATH."images/wholesaler_logo/".$imageName; 
    $varDestToShow=UPLOADED_FILES_URL."images/wholesaler_logo/".$imageName; 
    
    if(!copy($imageSrc,$varDest)){
     echo 'error';   
    }else{
    unlink($imageSrc);
    echo $varDestToShow;
    }    
    break;    
   
    case 'saveImageAfterCropSlider':
    global $arrProductImageResizes;
    $objUpload = new upload();     
    $imageSrc=SOURCE_ROOT.'/'.$_REQUEST['imageSrc'];
    $imageName=$_REQUEST['imageName']; 
    $varDest=UPLOADED_FILES_SOURCE_PATH."images/wholesaler_slider/".$imageName; 
    $varDestToShow=UPLOADED_FILES_URL."images/wholesaler_slider/".$arrProductImageResizes['color']."/".$imageName; 
    if(!copy($imageSrc,$varDest)){
     echo 'error';   
    }else{
    $infoExt = pathinfo($imageName);
    $arrName = basename($imageName, '.' . $infoExt['extension']);
    $ImageName = $imageName;
    $objUpload->setMaxSize();
    $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/wholesaler_slider/';
    $objUpload->setDirectory($varDirLocation);
    $fileName = strtolower($ImageName);
    $objUpload->setFileName($fileName);
    $thumbnailName = $arrProductImageResizes['color'] . '/';
    list($width, $height) = explode('x', $arrProductImageResizes['color']);
    $objUpload->setThumbnailName($thumbnailName);
    $objUpload->createThumbnail();
    $objUpload->setThumbnailSizeNew($width, $height);
    unlink($imageSrc);
    echo $varDestToShow;
    }
    break;    
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
function imageUpload($argFILES) {

    global $arrProductImageResizes;
    //$objCore = new Core();

    $objUpload = new upload();
    $arrRes = array('error' => '', 'name' => '');

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
        $arrRes['error'] = "Invalid Image, Use image formats : jpg, png, gif";
    }

    if ($argFILES['error'] != 0) {
        $arrRes['error'] = 'File upload error. Kindly try again.';
    } else if (trim($argFILES['size']) > MAX_PRODUCT_IMAGE_SIZE) {
        $arrRes['error'] = 'File size exceeds the given limit of ' . (int) (MAX_PRODUCT_IMAGE_SIZE / (1024 * 1024)) . ' MB.';
    }

    if ($varImageExists == 'yes') {
        $objUpload->setTmpName($argFILES['tmp_name']);
        if ($objUpload->userTmpName) {
            $objUpload->setFileSize($argFILES['size']);
            // Set File Type
            $objUpload->setFileType($argFILES['type']);


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

                ///$thumbnailName = 'original' . '/';
                ///$objUpload->setThumbnailName($thumbnailName);
                // create thumbnail
                /// $objUpload->createThumbnail();
                // change thumbnail size
                // $objUpload->setThumbnailSize($width, $height);
                //Create thumb file name

                $thumbnailName = $arrProductImageResizes['default'] . '/';
                list($width, $height) = explode('x', $arrProductImageResizes['default']);
                $objUpload->setThumbnailName($thumbnailName);
                $objUpload->createThumbnail();
                $objUpload->setThumbnailSizeNew($width, $height);


                $arrRes['name'] = $varFileName;
            } else {
                $arrRes['error'] = 'Invalid file !';
            }
        }
    }
    return $arrRes;
}

?>