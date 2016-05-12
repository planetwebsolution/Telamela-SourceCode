<?php
/**
*
* Module name : UploadImage
*
* Parent module : None
*
* Date created : 11th September 2013
*
* Date last modified : 11th September 2013
*
* Author : Mohit Malik
*
* Last modified by : Mohit Malik
*
* Comments : Class for uploading the image
*
*/

class upload

{

	/**
	*
	Variable declaration begins
	*
	*/ 

	var $directoryName;

	var $maxFileSize;

	var $error;

	var $userTmpName;

	var $userFileName;

	var $userFileSize;

	var $userFileType;

	var $userFullName;

	var $thumbName;

	/**
	*
	Variable declaration ends
	*
	*/ 



	/**
	*
	* Function name : setDirectory
	*
	* Return type : none
	*
	* Date created : 11th September 2013
	*
	* Date last modified : 11th September 2013
	*
	* Author : Mohit Malik
	*
	* Last modified by : Mohit Malik
	*
	* Comments : Function will set the directory path where file will be stored
	*
	* User instruction : $objUpload->setDirectory($dirName)
	*
	*/ 

 	function setDirectory($dirName = '.')

	{ 

		    if(!is_dir($dirName))

			mkdir($dirName, 0777);

		$this->directoryName = $dirName;

	}



	/** 
	*
	* Function name : setMaxSize
	*
	* Return type : none
	*
	* Date created : 11th September 2013
	*
	* Date last modified : 11th September 2013
	*
	* Author : Mohit Malik
	*
	* Last modified by : Mohit Malik
	*
	* Comments : Function will set the max size of the file
	*
	* User instruction : $objUpload->setMaxSize($maxSize)
	*
	*/ 

 	function setMaxSize($maxFile = 10485760)

	{

		$this->maxFileSize = $maxFile;

	}



	/**
	*
	* Function name : error
	*
	* Return type : string
	*
	* Date created : 11th September 2013
	*
	* Date last modified : 11th September 2013
	*
	* Author : Mohit Malik
	*
	* Last modified by : Mohit Malik
	*
	* Comments : Function will return the error found
	*
	* User instruction : $objUpload->error()
	*
	*/ 

 	function error()

	{

		return $this->error;

	}



	/**
	*
	* Function name : isError
	*
	* Return type : boolean
	*
	* Date created : 11th September 2013
	*
	* Date last modified : 11th September 2013
	*
	* Author : Mohit Malik
	*
	* Last modified by : Mohit Malik
	*
	* Comments : Function will return the boolean value for error check
	*
	* User instruction : $objUpload->isError()
	*
	*/ 

 	function isError()

	{

		if(isset($this->error))

			return false;

		else

			return true;

	}



	/**
	*
	* Function name : setTmpName
	*
	* Return type : none
	*
	* Date created : 11th September 2013
	*
	* Date last modified : 11th September 2013
	*
	* Author : Mohit Malik
	*
	* Last modified by : Mohit Malik
	*
	* Comments : Function will set the temporary name of the file
	*
	* User instruction : $objUpload->setTmpName($tempName)
	*
	*/ 

	function setTmpName($tempName)

	{
		$this->userTmpName = $tempName;	 

	}



	/**
	*
	* Function name : setFileSize
	*
	* Return type : none
	*
	* Date created : 11th September 2013
	*
	* Date last modified : 11th September 2013
	*
	* Author : Mohit Malik
	*
	* Last modified by : Mohit Malik
	*
	* Comments : Function will set the uploaded file size
	*
	* User instruction : $objUpload->setFileSize($fileSize)
	*
	*/ 

	function setFileSize($fileSize)

	{

		$this->userFileSize = $fileSize;

	}



	/**
	*
	* Function name : setFileType
	*
	* Return type : none
	*
	* Date created : 11th September 2013
	*
	* Date last modified : 11th September 2013
	*
	* Author : Mohit Malik
	*
	* Last modified by : Mohit Malik
	*
	* Comments : Function will set the uploaded file type
	*
	* User instruction : $objUpload->setFileType($fileType)
	*
	*/ 

	function setFileType($fileType)

	{

		$this->userFileType = $fileType;	 

	}



	/**
	*
	* Function name : setFileName
	*
	* Return type : none
	*
	* Date created : 11th September 2013
	*
	* Date last modified : 11th September 2013
	*
	* Author : Mohit Malik
	*
	* Last modified by : Mohit Malik
	*
	* Comments : Function will set the uploaded file name
	*
	* User instruction : $objUpload->setFileName($file)
	*
	*/ 

 	function setFileName($file)

	{

		$this->userFileName = $file;

		$this->userFullName = $this->directoryName.'/'.$this->userFileName;

	}



	/**
	*
	* Function name : resize
	*
	* Return type : none
	*
	* Date created : 11th September 2013
	*
	* Date last modified : 11th September 2013
	*
	* Author : Mohit Malik
	*
	* Last modified by : Mohit Malik
	*
	* Comments : Function will resize the uploaded image according to passed width & height
	*
	* User instruction : $objUpload->resize($maxWidth, $maxHeight)
	*
	*/ 

	function resize($maxWidth = 0, $maxHeight = 0)

	{

		if(eregi('\.png$', $this->userFullName))

		{

			$img = ImageCreateFromPNG($this->userFullName);

		}

	

		if(eregi('\.(jpg|jpeg)$', $this->userFullName))

		{

			$img = ImageCreateFromJPEG($this->userFullName);

		}

	

		if(eregi('\.gif$', $this->userFullName))

		{

			$img = ImageCreateFromGif($this->userFullName);

		}



    	$FullImageWidth = imagesx($img);    

    	$FullImageHeight = imagesy($img);   



		if(isset($maxWidth) && isset($maxHeight) && $maxWidth != 0 && $maxHeight != 0)

		{

			$newWidth = $maxWidth;

			$newHeight = $maxHeight;

		}

		else if(isset($maxWidth) && $maxWidth != 0)

		{

			$newWidth = $maxWidth;

			$newHeight = ((int)($newWidth * $FullImageHeight) / $FullImageWidth);

		}

		else if(isset($maxHeight) && $maxHeight != 0)

		{

			$newHeight = $maxHeight;

			$newWidth = ((int)($newHeight * $FullImageWidth) / $FullImageHeight);

		}		

		else

		{

			$newHeight = $FullImageHeight;

			$newWidth = $FullImageWidth;

		}	



    	$fullId = ImageCreateTrueColor($newWidth , $newHeight);

		ImageCopyResampled($fullId, $img, 0,0,0,0, $newWidth, $newHeight, $FullImageWidth, $FullImageHeight);

		

		if(eregi('\.(jpg|jpeg)$', $this->userFullName))

		{

			$full = ImageJPEG($fullId, $this->userFullName,100);

		}

		

		if(eregi('\.png$', $this->userFullName))

		{

			$full = ImagePNG($fullId, $this->userFullName);

		}

		

		if(eregi('\.gif$', $this->userFullName))

		{

			$full = ImageGIF($fullId, $this->userFullName);

		}

		ImageDestroy($fullId);

		unset($maxWidth);

		unset($maxHeight);

	}



	/**
	*
	* Function name : startCopy
	*
	* Return type : none
	*
	* Date created : 11th September 2013
	*
	* Date last modified : 11th September 2013
	*
	* Author : Mohit Malik
	*
	* Last modified by : Mohit Malik 
	*
	* Comments : Function will upload the file
	*
	* User instruction : $objUpload->startCopy()
	*
	*/ 

	function startCopy()

	{

		if(!isset($this->userFileName))

			$this->error = 'You must define filename!';



        if($this->userFileSize <= 0)

			$this->error = 'Uploaded file size is less than zero KB.';



        if($this->userFileSize > $this->maxFileSize)

			$this->error = 'Uploaded file size is greater than the set limit.';

		

        if(!isset($this->error))

        {

			$filename = basename($this->userFileName);



            if(!empty($this->directoryName)) 

				$destination = $this->userFullName;

			else 

				$destination = $filename;



			if(!is_uploaded_file($this->userTmpName))

				$this->error = 'File ' . $this->userTmpName . ' is not uploaded correctly.';

	  

			if(!@move_uploaded_file($this->userTmpName, $destination))

				$this->error = 'Impossible to copy ' . $this->userFileName .' from ' . $userfile . ' to destination directory.';

		}

	}

	

	/**
	*
	* Function name : setThumbnailName
	*
	* Return type : none
	*
	* Date created : 11th September 2013
	*
	* Date last modified : 11th September 2013
	*
	* Author : Mohit Malik
	*
	* Last modified by : Mohit Malik
	*
	* Comments : Function will set the thumbnail file name
	*
	* User instruction : $objUpload->setThumbnailName($thumbname)
	*
	*/ 

	function setThumbnailName($thumbname)

	{

		$thumbname = preg_replace('/\.([a-zA-Z]{3,4})$/', $thumbname, $this->userFileName);

		if(eregi('\.png$', $this->userFullName))

			$this->thumbName = $this->directoryName.'/'.$thumbname.'.png';

		if(eregi('\.(jpg|jpeg)$', $this->userFullName))

			$this->thumbName = $this->directoryName.'/'.$thumbname.'.jpg';

		if(eregi('\.gif$', $this->userFullName))

			$this->thumbName = $this->directoryName.'/'.$thumbname.'.gif';

	}

	function setProductThumbnailName($thumbname)

	{

		  $thumbname=$thumbname.'_'.$this->userFileName;
		  $this->thumbName = $this->directoryName.'/'.$thumbname;

	}

	/**	
	*
	* Function name : IsImageValid
	*
	* Return type : none
	*
	* Date created :3 aug 2013
	*
	* Date last modified : 3 aug 2013
	*
	* Author : Bharat Bhushan
	*
	* Last modified by : Bharat Bhushan
	*
	* Comments : Function will check  file type
	*
	* User instruction : $objUpload->IsImageValid($argFiletype)
	*
	*/ 
	function IsImageValid($argFiletype)
	{
		$fileType = $argFiletype;
		$image_type_identifiers = array (
			'image/gif'=>'gif', 	'image/jpeg'=>'jpg', 	'image/png'=>'png',	'image/pjpeg'=>'jpg',	'image/x-png'=>'png');	
		if (@array_key_exists($fileType, $image_type_identifiers)) 
		{ 
			return true;
		} 
		else 
		{
			return false;
		} 
	}
	/**	
	*
	* Function name : IsProductImageValid
	*
	* Return type : none
	*
	* Date created :3 aug 2013
	*
	* Date last modified : 3 aug 2013
	*
	* Author : Bharat Bhushan
	*
	* Last modified by : Bharat Bhushan
	*
	* Comments : Function will check if the image type is valid or not
	*
	* User instruction : $objUpload->IsProductImageValid($argFiletype)
	*
	*/
	function IsProductImageValid($argFiletype)

	{

		

		$fileType = $argFiletype;

		$image_type_identifiers = array ('image/gif'=>'gif', 'image/jpeg'=>'jpg', 'image/png'=>'png', 'image/pjpeg'=>'jpg','image/x-png'=>'png');	



		if (array_key_exists($fileType['type'], $image_type_identifiers)) 

		{ 

			

			return true;

		} 

		else 

		{

			return false;

		} 

		

	}

	

	

	/**
	*
	* Function name : createThumbnail
	*
	* Return type : none
	*
	* Date created : 11th September 2013
	*
	* Date last modified : 11th September 2013
	*
	* Author : Mohit Malik
	*
	* Last modified by : Mohit Malik
	*
	* Comments : Function will create the thumbnail
	*
	* User instruction : $objUpload->createThumbnail()
	*
	*/ 

	function createThumbnail()

	{

		if(!copy($this->userFullName, $this->thumbName))

		{

			$this->error = '<br>'.$this->userFullName.', '.$this->thumbName.'<br>failed to copy $file...<br />\n';

		}

	}

	

	/**
	*
	* Function name : setThumbnailSize
	*
	* Return type : none
	*
	* Date created : 11th September 2013
	*
	* Date last modified : 11th September 2013
	*
	* Author : Mohit Malik
	*
	* Last modified by : Mohit Malik
	*
	* Comments : Function will resize the thumbnail
	*
	* User instruction : $objUpload->setThumbnailSize($maxWidth, $maxHeight)
	*
	*/ 

	function setThumbnailSize($maxWidth = 0, $maxHeight = 0)

	{

		if(eregi('\.png$', $this->thumbName))

		{

			$img = ImageCreateFromPNG($this->thumbName);

		}

	

		if(eregi('\.(jpg|jpeg)$', $this->thumbName))

		{

			$img = ImageCreateFromJPEG($this->thumbName);

		}

	

		if(eregi('\.gif$', $this->thumbName))

		{
                        
			
			$img = ImageCreateFromGif($this->thumbName);

		}



    	$FullImageWidth = imagesx($img);    

    	$FullImageHeight = imagesy($img); 

		

		if(isset($maxWidth) && isset($maxHeight) && $maxWidth != 0 && $maxHeight != 0)

		{

			$newWidth = $maxWidth;

			$newHeight = $maxHeight;

		}

		else if(isset($maxWidth) && $maxWidth != 0)

		{

			$newWidth = $maxWidth;

			$newHeight = ((int)($newWidth * $FullImageHeight) / $FullImageWidth);

		}

		else if(isset($maxHeight) && $maxHeight != 0)

		{

			$newHeight = $maxHeight;

			$newWidth = ((int)($newHeight * $FullImageWidth) / $FullImageHeight);

		}		

		else

		{

			$newHeight = $FullImageHeight;

			$newWidth = $FullImageWidth;

		}	



    	$fullId =  ImageCreateTrueColor($newWidth , $newHeight);

		ImageCopyResampled($fullId, $img, 0, 0, 0, 0, $newWidth, $newHeight, $FullImageWidth, $FullImageHeight);

		

		if(eregi('\.(jpg|jpeg)$', $this->thumbName))

		{

			$full = ImageJPEG($fullId, $this->thumbName, 100);

		}

		

		if(eregi('\.png$', $this->thumbName))

		{

			$full = ImagePNG($fullId, $this->thumbName);

		}

		

		if(eregi('\.gif$', $this->thumbName))

		{

			$full = ImageGIF($fullId, $this->thumbName);

		}

		ImageDestroy($fullId);

		unset($maxWidth);

		unset($maxHeight);

	}



	/**
	*
	* Function Name : createColorImage
	*
	* Return type : 
	*
	* Date created : 11th October 2013
	*
	* Date last modified : 11th October 2013
	*
	* Author : Ashish Sharma
	*
	* Last modified by : Ashish Sharma
	*
	* Comments : This function will create the Color image.
	*
	* User instruction : $obj->createColorImage($colorCode);
	*
	*/ 	

	function createColorImage($argColorCode, $argPath, $argWidth, $argHeight, $argExt)

	{

		$varDestination = $argPath . $argColorCode . '.' . $argExt;

		

		if(!file_exists($varDestination))

		{

			$varImage = @imageCreate($argWidth, $argHeight);

			$varColor = hexdec($argColorCode);

			$arrColor = array('red' => 0xFF & ($varColor >> 0x10)

							,'green' => 0xFF & ($varColor >> 0x8)

							,'blue' => 0xFF & $varColor

							);

			$varColorBackgrnd = imagecolorallocate($varImage, $arrColor['red'], $arrColor['green'], $arrColor['blue']);

			imageFilledRectangle($varImage, 0, 0, $argWidth - 1, $argHeight - 1, $varColorBackgrnd);

			

			if($argExt == "jpg")

			{

				imagejpeg($varImage, $varDestination);

			}

			elseif($argExt == "gif")

			{

				imagegif($varImage, $varDestination);

			}

			elseif($argExt == "png")

			{

				imagepng($varImage, $varDestination);

			}

		}

	}

	/**
	*
	* Function Name : getFileExtensionFromType
	*
	* Return type : 
	*
	* Date created : 11th October 2013
	*
	* Date last modified : 11th October 2013
	*
	* Author : Ashish Sharma
	*
	* Last modified by : Ashish Sharma
	*
	* Comments : This function will return the file extention.
	*
	* User instruction : $obj->getFileExtensionFromType($fileType);
	*
	*/

	function getFileExtensionFromType($fileType)

	{

		$image_type_identifiers = array ('image/gif'=>'gif', 'image/jpeg'=>'jpg', 'image/png'=>'png', 'application/x-shockwave-flash'=>'swf', 'image/bmp'=>'bmp', 'image/tiff'=>'tiff', 'image/psd'=>'psd', 'application/octet-stream'=>'jpc', 'image/jp2'=>'jp2', 'application/octet-stream'=>'jpf');	

		

		if (array_key_exists($fileType, $image_type_identifiers)) { 

			return $image_type_identifiers[$fileType];

		}           

	}

	/**
	*
	* Function Name : IsFileValid
	*
	* Return type : 
	*
	* Date created : 11th October 2013
	*
	* Date last modified : 11th October 2013
	*
	* Author : Ashish Sharma
	*
	* Last modified by : Ashish Sharma
	*
	* Comments : This function will check for valid file.
	*
	* User instruction : $obj->IsFileValid($argFiletype);
	*
	*/	

		function IsFileValid($argFiletype)

	{//echo $argFiletype;die;

		

		$fileType = $argFiletype;

		$image_type_identifiers = array ('application/msword'=>'doc','application/msword'=>'docx','application/txt'=>'txt','application/octet'=>'pdf','application/pdf'=>'pdf','text/plain'=>'txt');	



		if (array_key_exists($fileType, $image_type_identifiers)) 

		{ 

			

			return true;

		} 

		else 

		{

			return false;

		} 

		

	}

	/**
	*
	* Function Name : getThumbImageName
	*
	* Return type : 
	*
	* Date created : 11th October 2013
	*
	* Date last modified : 11th October 2013
	*
	* Author : Ashish Sharma
	*
	* Last modified by : Ashish Sharma
	*
	* Comments : This function will create the thumb image.
	*
	* User instruction : $obj->getThumbImageName($argImageName);
	*
	*/	

	function getThumbImageName($argImageName)			

	{

		//Get file extention	

		if($argImageName!='')

		{

			$varExt =  substr(strrchr($argImageName,"."),1);



			$varImageFileName = 		substr($argImageName,0,-(strlen($varExt)+1));

			if($varExt=='jpeg') { $varExt='jpg'; }

			//Create thumb file name

			$varImageNameThumb = $varImageFileName.'_thumb.'.$varExt;

		}

		return $varImageNameThumb;

	}



}

?>
