<?php

if (isset($_GET['files']) && $_GET['files'] <> '') {
    $download_path = 'common/uploaded_files/files/bulk_upload_sample/' . $_GET['files'];

    if ($download_path) {
        $data = @file_get_contents($download_path); // Read the file's contents
        $name = $_GET['files'];
        force_download($name, $data);
    }
}




/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package  CodeIgniter
 * @author  ExpressionEngine Dev Team
 * @copyright Copyright (c) 2008 - 2010, EllisLab, Inc.
 * @license  http://ellislab.com/codeigniter/user-guide/license.html
 * @link  http://codeigniter.com
 * @since  Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * CodeIgniter Download Helpers
 *
 * @package  CodeIgniter
 * @subpackage Helpers
 * @category Helpers
 * @author  ExpressionEngine Dev Team
 * @link http://ellislab.com/codeigniter/user-guide/helpers/download_helper.html
 */
// ------------------------------------------------------------------------

/**
 * Force Download
 *
 * Generates headers that force a download to happen
 *
 * @access public
 * @param string filename
 * @param mixed the data to be downloaded
 * @return void
 */
function force_download($filename = '', $data = '') {
    if ($filename == '' OR $data == '') {
        return FALSE;
    }

    // Try to determine if the filename includes a file extension.
    // We need it in order to set the MIME type
    if (FALSE === strpos($filename, '.')) {
        return FALSE;
    }

    // Grab the file extension
    $x = explode('.', $filename);
    $extension = end($x);

    // Load the mime types
    $mimes = getMimes();
    // Set a default mime if we can't find it
    if (!isset($mimes[$extension])) {
        $mime = 'application/octet-stream';
    } else {
        $mime = (is_array($mimes[$extension])) ? $mimes[$extension][0] : $mimes[$extension];
    }
    //echo $mime;
    // Generate the server headers
    if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
        header('Content-Type: "' . $mime . '"');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header("Content-Transfer-Encoding: binary");
        header('Pragma: public');
        header("Content-Length: " . strlen($data));
    } else {
        header('Content-Type: "' . $mime . '"');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header("Content-Transfer-Encoding: binary");
        header('Expires: 0');
        header('Pragma: no-cache');
        header("Content-Length: " . strlen($data));
    }

    exit($data);
}

function getMimes() {
    return $mimes = array('hqx' => 'application/mac-binhex40',
        'cpt' => 'application/mac-compactpro',
        'csv' => array('text/x-csv', 'text/csv', 'text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/csv', 'application/excel', 'application/vnd.msexcel'),
        'bin' => 'application/macbinary',
        'dms' => 'application/octet-stream',
        'lha' => 'application/octet-stream',
        'lzh' => 'application/octet-stream',
        'exe' => 'application/octet-stream',
        'class' => 'application/octet-stream',
        'psd' => 'application/x-photoshop',
        'so' => 'application/octet-stream',
        'sea' => 'application/octet-stream',
        'dll' => 'application/octet-stream',
        'oda' => 'application/oda',
        'pdf' => array('application/pdf', 'application/x-download'),
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',
        'smi' => 'application/smil',
        'smil' => 'application/smil',
        'mif' => 'application/vnd.mif',
        'xls' => array('application/excel', 'application/vnd.ms-excel', 'application/msexcel'),
        'ppt' => array('application/powerpoint', 'application/vnd.ms-powerpoint'),
        'wbxml' => 'application/wbxml',
        'wmlc' => 'application/wmlc',
        'dcr' => 'application/x-director',
        'dir' => 'application/x-director',
        'dxr' => 'application/x-director',
        'dvi' => 'application/x-dvi',
        'gtar' => 'application/x-gtar',
        'gz' => 'application/x-gzip',
        'php' => 'application/x-httpd-php',
        'php4' => 'application/x-httpd-php',
        'php3' => 'application/x-httpd-php',
        'phtml' => 'application/x-httpd-php',
        'phps' => 'application/x-httpd-php-source',
        'js' => 'application/x-javascript',
        'swf' => 'application/x-shockwave-flash',
        'sit' => 'application/x-stuffit',
        'tar' => 'application/x-tar',
        'tgz' => 'application/x-tar',
        'xhtml' => 'application/xhtml+xml',
        'xht' => 'application/xhtml+xml',
        'zip' => array('application/x-zip', 'application/zip', 'application/x-zip-compressed'),
        'mid' => 'audio/midi',
        'midi' => 'audio/midi',
        'mpga' => 'audio/mpeg',
        'mp2' => 'audio/mpeg',
        'mp3' => array('audio/mpeg', 'audio/mpg'),
        'aif' => 'audio/x-aiff',
        'aiff' => 'audio/x-aiff',
        'aifc' => 'audio/x-aiff',
        'ram' => 'audio/x-pn-realaudio',
        'rm' => 'audio/x-pn-realaudio',
        'rpm' => 'audio/x-pn-realaudio-plugin',
        'ra' => 'audio/x-realaudio',
        'rv' => 'video/vnd.rn-realvideo',
        'wav' => 'audio/x-wav',
        'bmp' => 'image/bmp',
        'gif' => 'image/gif',
        'jpeg' => array('image/jpeg', 'image/pjpeg'),
        'jpg' => array('image/jpeg', 'image/pjpeg'),
        'jpe' => array('image/jpeg', 'image/pjpeg'),
        'png' => array('image/png', 'image/x-png'),
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'css' => 'text/css',
        'html' => 'text/html',
        'htm' => 'text/html',
        'shtml' => 'text/html',
        'txt' => 'text/plain',
        'text' => 'text/plain',
        'log' => array('text/plain', 'text/x-log'),
        'rtx' => 'text/richtext',
        'rtf' => 'text/rtf',
        'xml' => 'text/xml',
        'xsl' => 'text/xml',
        'mpeg' => 'video/mpeg',
        'mpg' => 'video/mpeg',
        'mpe' => 'video/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',
        'avi' => 'video/x-msvideo',
        'movie' => 'video/x-sgi-movie',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'word' => array('application/msword', 'application/octet-stream'),
        'xl' => 'application/excel',
        'eml' => 'message/rfc822'
    );
}

