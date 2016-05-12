<?php

/* * ****************************************
  Module name : UploadImage
  Parent module : None
  Date created : 11th September 2006
  Date last modified : 11th September 2006
  Author : Mohit Malik
  Last modified by : Mohit Malik
  Comments : Class for uploading the image
 * **************************************** */

class upload {
    /*     * ****************************************
      Variable declaration begins
     * **************************************** */

    var $directoryName;
    var $maxFileSize;
    var $error;
    var $userTmpName;
    var $userFileName;
    var $userFileSize;
    var $userFileType;
    var $userFullName;
    var $thumbName;

    /*     * ****************************************
      Variable declaration ends
     * **************************************** */

    /*     * ****************************************
      Function name : setDirectory
      Return type : none
      Date created : 11th September 2006
      Date last modified : 11th September 2006
      Author : Mohit Malik
      Last modified by : Mohit Malik
      Comments : Function will set the directory path where file will be stored
      User instruction : $objUpload->setDirectory($dirName)
     * **************************************** */

    function setDirectory($dirName = '.') {
        if (!is_dir($dirName))
            mkdir($dirName, 0777);
        $this->directoryName = $dirName;
    }

    /*     * ****************************************
      Function name : setMaxSize
      Return type : none
      Date created : 11th September 2006
      Date last modified : 11th September 2006
      Author : Mohit Malik
      Last modified by : Mohit Malik
      Comments : Function will set the max size of the file
      User instruction : $objUpload->setMaxSize($maxSize)
     * **************************************** */

    function setMaxSize($maxFile = 5242880) {
        $this->maxFileSize = $maxFile;
    }

    /*     * ****************************************
      Function name : error
      Return type : string
      Date created : 11th September 2006
      Date last modified : 11th September 2006
      Author : Mohit Malik
      Last modified by : Mohit Malik
      Comments : Function will return the error found
      User instruction : $objUpload->error()
     * **************************************** */

    function error() {
        return $this->error;
    }

    /*     * ****************************************
      Function name : isError
      Return type : boolean
      Date created : 11th September 2006
      Date last modified : 11th September 2006
      Author : Mohit Malik
      Last modified by : Mohit Malik
      Comments : Function will return the boolean value for error check
      User instruction : $objUpload->isError()
     * **************************************** */

    function isError() {
    	
    	    	
        if (isset($this->error))
            return false;
        else
            return true;
    }

    /*     * ****************************************
      Function name : setTmpName
      Return type : none
      Date created : 11th September 2006
      Date last modified : 11th September 2006
      Author : Mohit Malik
      Last modified by : Mohit Malik
      Comments : Function will set the temporary name of the file
      User instruction : $objUpload->setTmpName($tempName)
     * **************************************** */

    function setTmpName($tempName) {
        $this->userTmpName = $tempName;
    }

    /*     * ****************************************
      Function name : setFileSize
      Return type : none
      Date created : 11th September 2006
      Date last modified : 11th September 2006
      Author : Mohit Malik
      Last modified by : Mohit Malik
      Comments : Function will set the uploaded file size
      User instruction : $objUpload->setFileSize($fileSize)
     * **************************************** */

    function setFileSize($fileSize) {
        $this->userFileSize = $fileSize;
    }

    /*     * ****************************************
      Function name : setFileType
      Return type : none
      Date created : 11th September 2006
      Date last modified : 11th September 2006
      Author : Mohit Malik
      Last modified by : Mohit Malik
      Comments : Function will set the uploaded file type
      User instruction : $objUpload->setFileType($fileType)
     * **************************************** */

    function setFileType($fileType) {
        $this->userFileType = $fileType;
    }

    /*     * ****************************************
      Function name : setFileName
      Return type : none
      Date created : 11th September 2006
      Date last modified : 11th September 2006
      Author : Mohit Malik
      Last modified by : Mohit Malik
      Comments : Function will set the uploaded file name
      User instruction : $objUpload->setFileName($file)
     * **************************************** */

    function setFileName($file) {
        $this->userFileName = $file;
        $this->userFullName = $this->directoryName . '/' . $this->userFileName;
    }

    /*     * ****************************************
      Function name : resize
      Return type : none
      Date created : 11th September 2006
      Date last modified : 11th September 2006
      Author : Mohit Malik
      Last modified by : Mohit Malik
      Comments : Function will resize the uploaded image according to passed width & height
      User instruction : $objUpload->resize($maxWidth, $maxHeight)
     * **************************************** */

    function resize($maxWidth = 0, $maxHeight = 0) {
        if (eregi('\.png$', $this->userFullName)) {
            $img = ImageCreateFromPNG($this->userFullName);
        }

        if (eregi('\.(jpg|jpeg)$', $this->userFullName)) {
            $img = ImageCreateFromJPEG($this->userFullName);
        }

        if (eregi('\.gif$', $this->userFullName)) {
            $img = ImageCreateFromGif($this->userFullName);
        }

        $FullImageWidth = imagesx($img);
        $FullImageHeight = imagesy($img);

        if (isset($maxWidth) && isset($maxHeight) && $maxWidth != 0 && $maxHeight != 0) {
            $newWidth = $maxWidth;
            $newHeight = $maxHeight;
        } else if (isset($maxWidth) && $maxWidth != 0) {
            $newWidth = $maxWidth;
            $newHeight = ((int) ($newWidth * $FullImageHeight) / $FullImageWidth);
        } else if (isset($maxHeight) && $maxHeight != 0) {
            $newHeight = $maxHeight;
            $newWidth = ((int) ($newHeight * $FullImageWidth) / $FullImageHeight);
        } else {
            $newHeight = $FullImageHeight;
            $newWidth = $FullImageWidth;
        }

        $fullId = ImageCreateTrueColor($newWidth, $newHeight);
        ImageCopyResampled($fullId, $img, 0, 0, 0, 0, $newWidth, $newHeight, $FullImageWidth, $FullImageHeight);

        if (eregi('\.(jpg|jpeg)$', $this->userFullName)) {
            $full = ImageJPEG($fullId, $this->userFullName, 100);
        }

        if (eregi('\.png$', $this->userFullName)) {
            $full = ImagePNG($fullId, $this->userFullName);
        }

        if (eregi('\.gif$', $this->userFullName)) {
            $full = ImageGIF($fullId, $this->userFullName);
        }
        ImageDestroy($fullId);
        unset($maxWidth);
        unset($maxHeight);
    }

    function resizeCrop($maxWidth = 0, $maxHeight = 0, $dst_x = 0, $dst_y = 0) {
        
        if (preg_match('/\.png$/i', $this->thumbName)) {
            $img = ImageCreateFromPNG($this->thumbName);
        }

        if (preg_match('/\.(jpg)$/i', $this->thumbName)) {
            $img = ImageCreateFromJPEG($this->thumbName);
        }
        if (preg_match('/\.(jpeg)$/i', $this->thumbName)) {
            $img = ImageCreateFromJPEG($this->thumbName);
        }

        if (preg_match('/\.gif$/i', $this->thumbName)) {
            $img = ImageCreateFromGif($this->thumbName);
        }

        $FullImageWidth = imagesx($img);
        $FullImageHeight = imagesy($img);


        if ($dst_x <= 0) {
            $dst_x = 0;
        }
        if ($dst_y <= 0) {
            $dst_y = 0;
        }

        if ($dst_x == 0 && $dst_y == 0 && $FullImageWidth == 600 && $FullImageHeight == 600) {
            $iscrop = 0;
        } else {
            $iscrop = 1;
        }

        
        if ($iscrop) {
            if (isset($maxWidth) && isset($maxHeight) && $maxWidth != 0 && $maxHeight != 0) {
                $newWidth = $maxWidth;
                $newHeight = $maxHeight;
            } else if (isset($maxWidth) && $maxWidth != 0) {
                $newWidth = $maxWidth;
                $newHeight = ((int) ($newWidth * $FullImageHeight) / $FullImageWidth);
            } else if (isset($maxHeight) && $maxHeight != 0) {
                $newHeight = $maxHeight;

                $newWidth = ((int) ($newHeight * $FullImageWidth) / $FullImageHeight);
            } else {
                $newHeight = 600;
                $newWidth = 600;
            }

//            $newWidth = $newWidth + $dst_x;
//            $newHeight = $newHeight + $dst_y;
//            $dst_x = $newWidth + $dst_x;
//            $dst_y = $newHeight + $dst_y;
              //echo $newWidth . $newHeight; die;
            $fullId = ImageCreateTrueColor($newWidth, $newHeight);

            //ImageCopyResampled($fullId, $img, 0, 0, 0, 0, $newWidth, $newHeight, $FullImageWidth, $FullImageHeight);
            //pre($img);
//            ImageCopyResampled($fullId, $img, 0, 0, $dst_x, $dst_y, $FullImageWidth, $FullImageHeight, $newWidth, $newHeight);
            /* Hemant Suman For ImageCopyResampled  */
            ImageCopyResampled($fullId, $img, 0, 0, $dst_x, $dst_y, $newWidth, $newHeight, $newWidth, $newHeight);
        } else {
            if ($FullImageWidth > $FullImageHeight) {
                $newWidth = $maxWidth;
                $newHeight = ($FullImageHeight / $FullImageWidth) * $maxWidth;
            } else {
                $newHeight = $maxHeight;
                $newWidth = ($FullImageWidth / $FullImageHeight) * $maxHeight;
            }

            $newWidth = (int) $newWidth;
            $newHeight = (int) $newHeight;

            $fullId = ImageCreateTrueColor($newWidth, $newHeight);

            ImageCopyResampled($fullId, $img, 0, 0, 0, 0, $newWidth, $newHeight, $FullImageWidth, $FullImageHeight);
        }

        //$fullId = ImageCreateTrueColor(900, 900);
        //ImageCopyResampled($fullId, $img, 0, 0, 0, 0, $FullImageWidth, $FullImageHeight, 900, 900);

        //echo $dst_x . '=' . $dst_y . '=' . $FullImageWidth . '=' . $FullImageHeight . '=' . $newWidth . '=' . $newHeight;
       // exit;



       // $fullId = ImageCreateTrueColor($newWidth, $newHeight);

        //ImageCopyResampled($fullId, $img, 0, 0, 0, 0, $newWidth, $newHeight, $FullImageWidth, $FullImageHeight);

        //ImageCopyResampled($fullId, $img, 0, 0, $dst_x, $dst_y, $FullImageWidth, $FullImageHeight, $newWidth, $newHeight);



        if (preg_match('/\.(jpg)$/i', $this->thumbName)) {
            $full = ImageJPEG($fullId, $this->thumbName, 100);
        }
        if (preg_match('/\.(jpeg)$/i', $this->thumbName)) {
            $full = ImageJPEG($fullId, $this->thumbName, 100);
        }

        if (preg_match('/\.png$/i', $this->thumbName)) {
            $full = ImagePNG($fullId, $this->thumbName);
        }

        if (preg_match('/\.gif$/i', $this->thumbName)) {
            $full = ImageGIF($fullId, $this->thumbName);
        }

        ImageDestroy($fullId);
        unset($maxWidth);
        unset($maxHeight);
    }

    /*     * ****************************************
      Function name : startCopy
      Return type : none
      Date created : 11th September 2006
      Date last modified : 11th September 2006
      Author : Mohit Malik
      Last modified by : Mohit Malik
      Comments : Function will upload the file
      User instruction : $objUpload->startCopy()
     * **************************************** */

    function startCopy() {
        if (!isset($this->userFileName))
            $this->error = 'You must define filename!';

        if ($this->userFileSize <= 0)
            $this->error = 'Uploaded file size is less than zero KB.';

        if ($this->userFileSize > $this->maxFileSize)
            $this->error = 'Uploaded file size is greater than the set limit.';

        if (!isset($this->error)) {
            $filename = basename($this->userFileName);

            if (!empty($this->directoryName))
                $destination = $this->userFullName;
            else
                $destination = $filename;

            if (!is_uploaded_file($this->userTmpName))
                $this->error = 'File ' . $this->userTmpName . ' is not uploaded correctly.';

            if (!@move_uploaded_file($this->userTmpName, $destination))
                $this->error = 'Impossible to copy ' . $this->userFileName . ' from ' . $userfile . ' to destination directory.';
        }
    }

    /*     * ****************************************
      Function name : setThumbnailName
      Return type : none
      Date created : 11th September 2006
      Date last modified : 11th September 2006
      Author : Mohit Malik
      Last modified by : Mohit Malik
      Comments : Function will set the thumbnail file name
      User instruction : $objUpload->setThumbnailName($thumbname)
     * **************************************** */

    function setThumbnailName($thumbname) {
        //echo $thumbname = preg_replace('/\.([a-zA-Z]{3,4})$/', $thumbname, $this->userFileName);

        $thumbDir = $this->directoryName . $thumbname;

        if (!is_dir($thumbDir))
            mkdir($thumbDir, 0777);

        $this->thumbName = $thumbDir . $this->userFileName;
        /*
          if(preg_match('/\.png$/i', $this->userFullName))
          $this->thumbName = $this->directoryName.'/'.$thumbname.'.png';
          if(preg_match('/\.(jpg)$/i', $this->userFullName))
          $this->thumbName = $this->directoryName.'/'.$thumbname.'.jpg';
          if(preg_match('/\.(jpeg)$/i', $this->userFullName))
          $this->thumbName = $this->directoryName.'/'.$thumbname.'.jpeg';
          if(preg_match('/\.gif$/i', $this->userFullName))
          $this->thumbName = $this->directoryName.'/'.$thumbname.'.gif'; */
    }

    /*     * ****************************************
      Function name : IsImageValid
      Return type : none
      Date created :3 aug 2007
      Date last modified : 3 aug 2007
      Author : Bharat Bhushan
      Last modified by : Bharat Bhushan
      Comments : Function will check  file type
      User instruction : $objUpload->IsImageValid($argFiletype)
     * **************************************** */

    function IsImageValid($argFiletype) {
        $fileType = $argFiletype;
        $image_type_identifiers = array('image/gif' => 'gif', 'image/jpeg' => 'jpg', 'image/png' => 'png', 'image/pjpeg' => 'jpg', 'image/x-png' => 'png');
        if (array_key_exists($fileType, $image_type_identifiers)) {
            return true;
        } else {
            return false;
        }
    }

    function IsProductImageValid($argFiletype) {
        $fileType = $argFiletype;
        $image_type_identifiers = array('image/gif' => 'gif', 'image/jpeg' => 'jpg', 'image/png' => 'png', 'image/bmp' => 'bmp', 'image/pjpeg' => 'jpg', 'image/x-png' => 'png');

        if (array_key_exists($fileType['type'], $image_type_identifiers)) {

            return true;
        } else {
            return false;
        }
    }

    /*     * ****************************************
      Function name : createThumbnail
      Return type : none
      Date created : 11th September 2006
      Date last modified : 11th September 2006
      Author : Mohit Malik
      Last modified by : Mohit Malik
      Comments : Function will create the thumbnail
      User instruction : $objUpload->createThumbnail()
     * **************************************** */

    function createThumbnail() {
        if (!copy($this->userFullName, $this->thumbName)) {
            $this->error = '<br>' . $this->userFullName . ', ' . $this->thumbName . '<br>failed to copy $file...<br />\n';
        }
    }

    /*     * ****************************************
      Function name : setThumbnailSize
      Return type : none
      Date created : 11th September 2006
      Date last modified : 11th September 2006
      Author : Mohit Malik
      Last modified by : Mohit Malik
      Comments : Function will resize the thumbnail
      User instruction : $objUpload->setThumbnailSize($maxWidth, $maxHeight)
     * **************************************** */

    function setThumbnailSizeNew($maxWidth = 0, $maxHeight = 0) {
        if (preg_match('/\.png$/i', $this->thumbName)) {
            $img = ImageCreateFromPNG($this->thumbName);
        }

        if (preg_match('/\.(jpg)$/i', $this->thumbName)) {
            $img = ImageCreateFromJPEG($this->thumbName);
        }
        if (preg_match('/\.(jpeg)$/i', $this->thumbName)) {
            $img = ImageCreateFromJPEG($this->thumbName);
        }

        if (preg_match('/\.gif$/i', $this->thumbName)) {
            $img = ImageCreateFromGif($this->thumbName);
        }
        
        $FullImageWidth = imagesx($img);
        $FullImageHeight = imagesy($img);



//        if ($FullImageWidth > $FullImageHeight) {
//            $newWidth = $maxWidth;
//            $newHeight = ($FullImageHeight / $FullImageWidth) * $maxWidth;
//        }else { 
//            $newHeight = $maxHeight;
//            $newWidth = ($FullImageWidth / $FullImageHeight) * $maxHeight;
//        }
//        
//       
//        $newWidth = (int) $newWidth;
//        $newHeight = (int) $newHeight;
        
        if (isset($maxWidth) && isset($maxHeight) && $maxWidth != 0 && $maxHeight != 0) {
            $newWidth = $maxWidth;
            $newHeight = $maxHeight;
        } else if (isset($maxWidth) && $maxWidth != 0) {
            $newWidth = $maxWidth;

            $newHeight = ((int) ($newWidth * $FullImageHeight) / $FullImageWidth);
        } else if (isset($maxHeight) && $maxHeight != 0) {
            $newHeight = $maxHeight;

            $newWidth = ((int) ($newHeight * $FullImageWidth) / $FullImageHeight);
        } else {
            $newHeight = $FullImageHeight;
            $newWidth = $FullImageWidth;
        }
       
        $fullId = ImageCreateTrueColor($newWidth, $newHeight);
        ImageCopyResampled($fullId, $img, 0, 0, 0, 0, $newWidth, $newHeight, $FullImageWidth, $FullImageHeight);

        if (preg_match('/\.(jpg)$/i', $this->thumbName)) {
            $full = ImageJPEG($fullId, $this->thumbName, 100);
        }
        if (preg_match('/\.(jpeg)$/i', $this->thumbName)) {
            $full = ImageJPEG($fullId, $this->thumbName, 100);
        }

        if (preg_match('/\.png$/i', $this->thumbName)) {
            $full = ImagePNG($fullId, $this->thumbName);
        }

        if (preg_match('/\.gif$/i', $this->thumbName)) {
            $full = ImageGIF($fullId, $this->thumbName);
        }

        ImageDestroy($fullId);
        unset($maxWidth);
        unset($maxHeight);
    }

    function setThumbnailSize($maxWidth = 0, $maxHeight = 0) {
        if (preg_match('/\.png$/i', $this->thumbName)) {
            $img = ImageCreateFromPNG($this->thumbName);
        }

        if (preg_match('/\.(jpg)$/i', $this->thumbName)) {
            $img = ImageCreateFromJPEG($this->thumbName);
        }
        if (preg_match('/\.(jpeg)$/i', $this->thumbName)) {
            $img = ImageCreateFromJPEG($this->thumbName);
        }

        if (preg_match('/\.gif$/i', $this->thumbName)) {
            $img = ImageCreateFromGif($this->thumbName);
        }



        $FullImageWidth = imagesx($img);
        $FullImageHeight = imagesy($img);

        if (isset($maxWidth) && isset($maxHeight) && $maxWidth != 0 && $maxHeight != 0) {
            $newWidth = $maxWidth;
            $newHeight = $maxHeight;
        } else if (isset($maxWidth) && $maxWidth != 0) {
            $newWidth = $maxWidth;

            $newHeight = ((int) ($newWidth * $FullImageHeight) / $FullImageWidth);
        } else if (isset($maxHeight) && $maxHeight != 0) {
            $newHeight = $maxHeight;

            $newWidth = ((int) ($newHeight * $FullImageWidth) / $FullImageHeight);
        } else {
            $newHeight = $FullImageHeight;
            $newWidth = $FullImageWidth;
        }

        $fullId = ImageCreateTrueColor($newWidth, $newHeight);
        ImageCopyResampled($fullId, $img, 0, 0, 0, 0, $newWidth, $newHeight, $FullImageWidth, $FullImageHeight);

        if (preg_match('/\.(jpg)$/i', $this->thumbName)) {
            $full = ImageJPEG($fullId, $this->thumbName, 100);
        }
        if (preg_match('/\.(jpeg)$/i', $this->thumbName)) {
            $full = ImageJPEG($fullId, $this->thumbName, 100);
        }

        if (preg_match('/\.png$/i', $this->thumbName)) {
            $full = ImagePNG($fullId, $this->thumbName);
        }

        if (preg_match('/\.gif$/i', $this->thumbName)) {
            $full = ImageGIF($fullId, $this->thumbName);
        }

        ImageDestroy($fullId);
        unset($maxWidth);
        unset($maxHeight);
    }

    /*     * ****************************************
      Function Name : createColorImage
      Return type :
      Date created : 11th October 2006
      Date last modified : 11th October 2006
      Author : Ashish Sharma
      Last modified by : Ashish Sharma
      Comments : This function will create the Color image.
      User instruction : obj->createColorImage($colorCode);
     * **************************************** */

    function createColorImage($argColorCode, $argPath, $argWidth, $argHeight, $argExt) {
        $varDestination = $argPath . $argColorCode . '.' . $argExt;

        if (!file_exists($varDestination)) {
            $varImage = @imageCreate($argWidth, $argHeight);
            $varColor = hexdec($argColorCode);
            $arrColor = array('red' => 0xFF & ($varColor >> 0x10)
                , 'green' => 0xFF & ($varColor >> 0x8)
                , 'blue' => 0xFF & $varColor
            );
            $varColorBackgrnd = imagecolorallocate($varImage, $arrColor['red'], $arrColor['green'], $arrColor['blue']);
            imageFilledRectangle($varImage, 0, 0, $argWidth - 1, $argHeight - 1, $varColorBackgrnd);

            if ($argExt == "jpg") {
                imagejpeg($varImage, $varDestination);
            } elseif ($argExt == "gif") {
                imagegif($varImage, $varDestination);
            } elseif ($argExt == "png") {
                imagepng($varImage, $varDestination);
            }
        }
    }

    function getFileExtensionFromType($fileType) {
        $image_type_identifiers = array('image/gif' => 'gif', 'image/jpeg' => 'jpg', 'image/png' => 'png', 'application/x-shockwave-flash' => 'swf', 'image/bmp' => 'bmp', 'image/tiff' => 'tiff', 'image/psd' => 'psd', 'application/octet-stream' => 'jpc', 'image/jp2' => 'jp2', 'application/octet-stream' => 'jpf');

        if (array_key_exists($fileType, $image_type_identifiers)) {
            return $image_type_identifiers[$fileType];
        }
    }

    function IsFileValid($argFiletype) {

        $fileType = $argFiletype;
        $image_type_identifiers = array('application/msword' => 'doc', 'application/octet' => 'pdf');

        if (array_key_exists($fileType, $image_type_identifiers)) {

            return true;
        } else {
            return false;
        }
    }

    function imageResize($width, $height, $targetWidth, $targetHeight) {
        if ($width > $height)
            $percentage = ($targetWidth / $width);
        else
            $percentage = ($targetHeight / $height);
        $width = round($width * $percentage);
        $height = round($height * $percentage);
        //return "width=\"$width\" height=\"$height\"";
        $arrFinalArray = array('width' => $width, 'height' => $height);
        return $arrFinalArray;
    }

    function imageResizeRest($width, $height, $targetWidth, $targetHeight) {



        if ($height >= 167 && $width < 167) {

            $hh = ($height / $width);
            $height = 167 / $hh;
            $width = $width;
        } else if ($height < 167 && $width >= 167) {
            $height = $height;
            $width = $width;
        }
        if ($height > 167) {

            $height = 167;
        }

        if ($width > 167) {

            $width = 167;
        }
        //$width = round($width * $percentage);
        //$height = round($height * $percentage);
        //return "width=\"$width\" height=\"$height\"";
        $arrFinalArray = array('width' => $width, 'height' => $height);
        return $arrFinalArray;
    }

}

?>
