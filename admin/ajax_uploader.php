<?php

/* * ****************************************
  Module name : Ajax Image uploader Calls
  Date created : 031 Jan, 2014
  Date last modified : 31 Jan, 2014
  Author : Suraj Kumar Maurya
  Last modified by :  Suraj Kumar Maurya
  Comments : This file includes the funtions for AJAX calls.
  Copyright : Copyright (C) 1999-2011 Vinove Software and Services
 * **************************************** */
require_once '../common/config/config.inc.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'class_upload_inc.php';

$varcase = $_REQUEST['action'];
switch ($varcase) {
    case 'uploadProductImage':
        $data = array();
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

                        $chkd = ($_GET['deflt'] == '1') ? 'checked="checked"' : '';

                        $arrcls = explode('.', $arrResponse['name']);
                        $ids = implode('a', $arrcls);
                        $str = '
                            <div>
                            <div style="width:85px;height:67px;overflow:hidden;">
                            <img id="preview_'.$ids.'" style="width:85px;height:67px;" src="' . $objCore->getImageUrl($arrResponse['name'], 'products/' . $arrProductImageResizes['detailHover']) . '" />
                            </div>
                             <a href="javascript:void(0)" onclick="jCropPopupOpen(\'' . $ids . '\');" rel="tooltip" data-original-title="Click here to crop image">Crop</a>
                                 <input type="radio" name="' . $default . '" ' . $chkd . ' value="' . $arrResponse['name'] . '"/> Default
                            
                            </div>
                            <div id="' . $ids . '" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;top:1%;">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="jCropPopupClose(\'' . $ids . '\')">X</button>
                                     <h3 id="myModalLabel">Crop Image</h3>
                                </div>
                                <div style="width:800px;height:450px;overflow:auto;">
                                    <img class="target" id="target_'.$ids.'" src="' . $objCore->getImageUrl($arrResponse['name'], 'products') . '" />
                                    <input type="hidden" value="0" name="' . $x1Name . '" class="x1" size="4"/>
                                    <input type="hidden" value="0" name="' . $y1Name . '" class="y1" size="4"/>';
                        $str .='<input type="hidden" value="' . $arrResponse['name'] . '" name="' . $pImgName . '">
                                 </div>
                                <div class="modal-footer">
                                    <input type="button" onclick="jCropPopupClose(\'' . $ids . '\')" style="cursor: pointer;" value="Crop" name="ok" class="btn btn-blue">
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
        $data = array();
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
                            $mainClass = 'style="width:800px; margin-left: 0; left: 0; position: relative;"';
                        } else {
                            $pImgName = 'frmAttrImg[' . $optId . ']';
                            $x1Name = 'x1_attr[' . $optId . ']';
                            $y1Name = 'y1_attr[' . $optId . ']';
                            $mainClass = 'style="width:800px;"';
                        }

                        $arrcls = explode('.', $arrResponse['name']);
                        $ids = implode('a', $arrcls);
                        //print_r($arrResponse);
                        //pre($arrProductImageResizes);
                        $str = '
                            <div>
                            <div style="width:85px;height:67px;overflow:hidden;">
                            <img  id="preview_'.$ids.'"  style="width:85px;height:67px;" src="' . $objCore->getImageUrl($arrResponse['name'], 'products/' . $arrProductImageResizes['detailHover']) . '" />
                            </div>
                             <a href="javascript:void(0)" onclick="jCropPopupOpen(\'' . $ids . '\');" rel="tooltip" data-original-title="Click here to crop image">Crop</a>                                 
                            </div>
                            <div id="' . $ids . '" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" '.$mainClass.'>
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="jCropPopupClose(\'' . $ids . '\')">X</button>
                                     <h3 id="myModalLabel">Crop Image</h3>
                                </div>
                                <div style="width:800px;height:450px;overflow:auto;">
                                    <img class="target" id="target_'.$ids.'" src="' . $objCore->getImageUrl($arrResponse['name'], 'products') . '" />
                                    <input type="hidden" value="0" name="' . $x1Name . '" class="x1" size="4"/>
                                    <input type="hidden" value="0" name="' . $y1Name . '" class="y1" size="4"/>
                                    <input type="hidden" value="' . $arrResponse['name'] . '" name="' . $pImgName . '">
                                 </div>
                                <div class="modal-footer">
                                    <input type="button" onclick="jCropPopupClose(\'' . $ids . '\')" style="cursor: pointer;" value="Crop" name="ok" class="btn btn-blue">
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
            //pre($objUpload);
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
                //Hemant - $arrProductImageResizes['default'](85*67) to $arrProductImageResizes['detailHover'](600*600) / 3 times on this page
                //pre($arrProductImageResizes);
                $thumbnailName = $arrProductImageResizes['detailHover'] . '/';
                list($width, $height) = explode('x', $arrProductImageResizes['detailHover']);
                
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