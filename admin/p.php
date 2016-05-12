<?php
exit;
require_once '../common/config/config.inc.php';
require_once COMPONENTS_SOURCE_ROOT_PATH . 'class_upload_inc.php';

echo '<pre>';
$dir = UPLOADED_FILES_SOURCE_PATH . 'images/products/';

$files = scandir($dir, 1);

pre(count($files));

$from = (int) $_GET['i'];
$to = $from + 500;

for ($i = $from; $i < $to; $i++) {

    $v = $files[$i];

    if ($v <> '') {
        if ($v == 'default.jpg') {
            
        } else {
            // echo $v . '<br />';
            $arrImage[$i] = imageResize($v);
        }
    }
    /* if ($k == 14) {
      pre($arrImage);
      } */
}

pre($arrImage);

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

    global $arrProductImageResizes;

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
        return 'not valid';
    }


    if ($varImageExists == 'yes') {

        $objUpload->setFileName($ImageName);
        // Start Copy Process
        //  $objUpload->startCopy();
        // If there is error write the error message
        // resizing the file
        //   $objUpload->resize(510, 450);

        $varFileName = $objUpload->userFileName;

        /*
          $thumbnailName = 'original' . '/';
          $objUpload->setThumbnailName($thumbnailName);
          // create thumbnail
          $objUpload->createThumbnail();
          // change thumbnail size
          // $objUpload->setThumbnailSize($width, $height);
         */

        $thumbnailName =  '157x157/';
        list($width, $height) = explode('x', '157x157');
        $objUpload->setThumbnailName($thumbnailName);
        // create thumbnail
        $objUpload->createThumbnail();
        // change thumbnail size
        //$objUpload->setThumbnailSize($width, $height);
        $objUpload->setThumbnailSizeNew($width, $height);
        /*

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
         */

        //Get file name from the class public variable
        //Get file extention

        return $ImageName;
    }
    return 'folder';
}

?>