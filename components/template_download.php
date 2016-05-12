<?php // This module helps in downloading of the file.
require_once '../common/config/config.inc.php';
$varFile=$_GET['FileName'];//storing the file name.
$varFilePath = UPLOADED_FILES_SOURCE_PATH.'resume/'.$varFile;
$varFileLocation = $varFilePath;
if($varFileLocation)
{
	if (file_exists($varFileLocation))
	{		
		$path_parts = pathinfo($varFileLocation);
		$ext = strtolower($path_parts["extension"]);		
		header('Content-Description: File Transfer');
		switch ($ext)
		{
			case "pdf":
				header("Content-type: application/pdf"); // add here more headers for diff. extensions
				header("Content-Disposition: attachment; filename=\"".$_GET["FileName"]."\""); // use 'attachment' to force a download
				break;
			case "doc":
				header("Content-type: application/doc/docx/txt/rtf"); // add here more headers for diff. extensions
				header("Content-Disposition: attachment; filename=\"".$_GET["FileName"]."\""); // use 'attachment' to force a download
				break;
			default;
				header("Content-type: application/octet-stream");
				header("Content-Disposition: filename=\"".$_GET["FileName"]."\"");
		}
		
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($varFileLocation));
		ob_clean();
		flush();
		readfile($varFileLocation);
		exit;
	}	
}	
?>
