<?php

/**
 * ProductPriceInventoryCtrl class controller.
 */
require_once CLASSES_PATH . 'class_wholesaler_bll.php';
require_once CLASSES_PATH . 'class_common.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';

class WholesalerPriceInventoryCtrl extends Paging {
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
        if ($_SESSION['sessUserInfo']['id'] && $_SESSION['sessUserInfo']['type'] == 'wholesaler') {
            
        } else {
            header('location:' . SITE_ROOT_URL);
            die;
        }
    }

    /**
     * function pageLoads
     *
     * This function Will be called on each page load and will check for any form submission.
     *
     * Database Tables used in this function are : None
     *
     * Use Instruction : $objPage->pageLoad();
     *
     * @access public
     *
     * @return void
     */
    public function pageLoad() {
        global $objGeneral;
        $objCore = new Core();
        $wid = $_SESSION['sessUserInfo']['id'];
        $objWholesaler = new Wholesaler();
        $objClassCommon = new ClassCommon();


        //$this->arrMarginCost = $objClassCommon->getMarginCast();

        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'updatePrice' && $_GET['pid'] != '') {

            $pid = $_GET['pid'];
            $varUpdateStatus = $objWholesaler->updateProductOptPrice($pid, $_POST);

            if ($varUpdateStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_UPDATE_SUCCUSS_MSG);
                header('location:manage_products.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_UPDATE_ERROR_MSG);
                header('location:add_edit_product_price.php?type=' . $_GET['type'] . '&pid=' . $_GET['id']);
                die;
            }
        } else if (isset($_GET['pid']) && $_GET['pid'] != '' && ($_GET['action'] == 'price')) {

            $pid = addslashes($_GET['pid']);
            $this->productDetail = $objWholesaler->productDetail($pid, $wid);
            if (count($this->productDetail) > 0) {
                $this->productToAttributeOptions = $objWholesaler->productToAttributeOptions($pid);
            }            
        } else if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'updateInventory' && $_GET['pid'] != '') {

            $pid = $_GET['pid'];
            $varUpdateStatus = $objWholesaler->updateProductOptInventory($pid, $_POST);

            if ($varUpdateStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_UPDATE_SUCCUSS_MSG);
                header('location:manage_products.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_UPDATE_ERROR_MSG);
                header('location:add_edit_product_inventory.php?type=' . $_GET['type'] . '&pid=' . $_GET['id']);
                die;
            }
        } else if (isset($_GET['pid']) && $_GET['pid'] != '' && ($_GET['action'] == 'inventory')) {

            $pid = addslashes($_GET['pid']);
            $this->productDetail = $objWholesaler->productDetail($pid, $wid);

            if (count($this->productDetail) > 0) {
                $this->arrAttrOptQty = $objWholesaler->productToAttributeOptionsQty($pid, $wid);

                $arrAttrOpt = $objWholesaler->productToAttributeOptions($pid);
                $this->arrCombinedAttrOpt = $objCore->combineAttributesOptions($arrAttrOpt);
            }
        }
    }

}

$objPage = new WholesalerPriceInventoryCtrl();
$objPage->pageLoad();
?>
