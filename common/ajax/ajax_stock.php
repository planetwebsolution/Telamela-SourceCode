<?php

require_once '../config/config.inc.php';
require_once(CLASSES_PATH . 'class_shopping_cart_bll.php');
$objShoppingCart = new ShoppingCart();
$objCore = new Core();
$objGeneral = new General();

//Get Posted data
$case = $_REQUEST['action'];
switch ($case) {
    case 'getStock':
        $pid = $_REQUEST['pid'];
        $optIds = trim($_REQUEST['optIds'], ',');

        $arrRows = $objShoppingCart->getStock($pid, $optIds);
       
        $json = json_encode($arrRows);

        echo $json;
        die;
        $stock = (int) $arrRows['stock'];
        echo $stock;
        break;
}
?>