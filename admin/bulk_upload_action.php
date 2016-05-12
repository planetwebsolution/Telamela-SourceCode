<?php

require_once '../common/config/config.inc.php';
require_once SOURCE_ROOT.'common/excel/simplexlsx.class.php';
require_once CLASSES_ADMIN_PATH . 'class_bulk_upload_bll.php';
//require_once CONTROLLERS_ADMIN_PATH . FILENAME_CMS_CTRL;
//echo '<pre>';
//print_r($_POST);
//print_r($_FILES);

$file = $_FILES['frmFile']['tmp_name'];

$arrName = explode('.', $_FILES['frmFile']['name']);
$ext = end($arrName);

// for csv file
if ($ext == 'csv') {

    $handle = fopen($file, "r");

    while ($data = fgetcsv($handle, 1000, ",", "'")) {
        print_r($data);
    }
}

// for excel file
if ($ext == 'xls' || $ext == 'xlsx') {

    $xlsx = new SimpleXLSX($file);
    echo '<h1>$xlsx->rows()</h1>';
    echo '<pre>';
    print_r($xlsx->rows());
    echo '</pre>';
}
?>