<?php

/**
 * Site ShoppingCartCtrl Class
 *
 * This is the ShoppingCartCtrl class that will used on Shopping Cart Page.
 *
 * DateCreated 5th August, 2013
 *
 * DateLastModified 18th August, 2013
 *
 * @copyright Copyright (C) 2010-2012 Vinove Software and Services
 *
 * @version 10.0
 */
require_once CLASSES_PATH . 'class_shopping_cart_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';

class ShoppingCartCtrl extends Paging {
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
        $objCore = new Core();
        $objCore->setCurrencyPrice();
    }

    /**
     * function pageLoad
     *
     * This function Will be called on each page load and will check for any form submission.
     *
     * Database Tables used in this function are : no table
     *
     * @access public
     *
     * @parameters 0 
     *
     * @return string $stringMessage
     */
    public function pageLoad() {
        
        $objCore = new Core();
        $objShoppingCart = new ShoppingCart();
        //pre($_REQUEST);
        if (isset($_POST['UpdateMyCart'])) { 

            //pre($_REQUEST);
            $arrError = array();
            $Qty = 0;
            foreach ($_POST['frmProductId'] as $kC => $valC) { //echo $valC;

                //$arrRes = $objShoppingCart->getProductQuantityById($valC);                
                $prodIndex = $_POST['frmProductIndex'][$kC];
                if ($objShoppingCart->productInStockShoppingPage($valC, $_POST,$prodIndex)) {

                    $varqty = (int) $_POST['frmProductQuantity'][$kC];

                    if ($varqty > 0) {
                        $_SESSION['MyCart']['Product'][$valC][$prodIndex]['qty'] = $varqty;
                        $Qty += $varqty;
                    }
                } else {
                    
                    $Qty += $_SESSION['MyCart']['Product'][$valC][$prodIndex]['qty'];
                    $arrError[$valC] = $objShoppingCart->getProductById($valC) . ' : ' . PRODUCT_ADD_IN_SHOPING_CART_OUT_OF_STOCK;
                }
            }
            

            foreach ($_POST['frmPackageId'] as $kC => $valC) {

                $varqty = (int) $_POST['frmPackageQuantity'][$kC];
                if ($_POST['frmPackageQuantity'][$kC] > 0) {
                    $packageIndex = $_POST['frmPackageIndex'][$kC];
                    $_SESSION['MyCart']['Package'][$valC][$packageIndex]['qty'] = $_POST['frmPackageQuantity'][$kC];
                    $Qty += $varqty;
                }
            }

            foreach ($_POST['frmGiftCardId'] as $kC => $valC) {

                $varqty = (int) $_POST['frmGiftCardQty'][$kC];

                if ($_POST['frmGiftCardQty'][$kC] > 0) {
                    $_SESSION['MyCart']['GiftCard'][$valC]['qty'] = $_POST['frmGiftCardQty'][$kC];
                    $Qty += $varqty;
                }
            }
            
            $_SESSION['MyCart']['Total'] = ($Qty > 0) ? $Qty : $_SESSION['MyCart']['Total'];

            foreach ($arrError as $vError) {
                $str .= $vError . '<br/>';
            };
            if ($str <> '') {
                $objCore->setErrorMsg($str);
            }
            
            if ($_POST['UpdateMyCart'] == UPDATE_SHOP) {
                if ($str == '') {
                    $str = 'Shopping cart updated successfully.';
                    $objCore->setSuccessMsg($str);
                }
                header('location:shopping_cart.php');
            } else {
                header('location:checkout.php');
            }
            
            die;
        } else {
           
            $this->arrData['arrCartDetails'] = $objShoppingCart->myCartDetails();
            //pre($this->arrData);
        }
    }

}

$objPage = new ShoppingCartCtrl();
$objPage->pageLoad();
?>
