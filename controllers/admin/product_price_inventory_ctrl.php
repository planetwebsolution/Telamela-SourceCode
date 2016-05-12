<?php

/**
 * ProductPriceInventoryCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_product_bll.php';
require_once CLASSES_PATH . 'class_common.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';

class ProductPriceInventoryCtrl extends Paging {
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
        /*
         * Checking valid login session
         */
//$objCore = new Core();
//echo $objCore->setSuccessMsg();
        $objAdminLogin = new AdminLogin();
//check admin session
        $objAdminLogin->isValidAdmin();
//************ Get Admin Email here
    }

    private function getList() {
        
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
        $objProduct = new Product();
        $objClassCommon = new ClassCommon();

        $varPortalFilter = $objGeneral->countryPortalFilter($_SESSION['sessAdminWholesalerIDs']);
        //$this->arrMarginCost = $objClassCommon->getMarginCast();

        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'updatePrice' && $_GET['id'] != '') {

            $pid = $_GET['id'];
            $varUpdateStatus = $objProduct->updateProductOptPrice($pid, $_POST);

            if ($varUpdateStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_UPDATE_SUCCUSS_MSG);
                header('location:' . $_POST['httpRef']);
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_UPDATE_ERROR_MSG);
                header('location:product_price_uil.php?type=' . $_GET['type'] . '&id=' . $_GET['id'] . '&httpRef' . $_POST['httpRef']);
                die;
            }
        } else if (isset($_GET['id']) && $_GET['id'] != '' && ($_GET['type'] == 'price')) {
            $pid = $_GET['id'];
            $this->arrRow = $objProduct->editProduct($pid, $varPortalFilter);
            $this->productToAttributeOptions = $objProduct->productToAttributeOptions($pid);
        } else if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'updateInventory' && $_GET['id'] != '') {

            $pid = $_GET['id'];
            $varUpdateStatus = $objProduct->updateProductOptInventory($pid, $_POST);
            if ($varUpdateStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_UPDATE_SUCCUSS_MSG);
                header('location:' . $_POST['httpRef']);
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_UPDATE_ERROR_MSG);
                header('location:product_inventory_uil.php?type=' . $_GET['type'] . '&id=' . $_GET['id'] . '&httpRef' . $_POST['httpRef']);
                die;
            }
        } else if (isset($_GET['id']) && $_GET['id'] != '' && ($_GET['type'] == 'inventory')) {
            $pid = $_GET['id'];
            $this->arrRow = $objProduct->editProduct($pid, $varPortalFilterP);
            $this->arrAttrOptQty = $objProduct->productToAttributeOptionsQty($pid);
            $arrAttrOpt = $objProduct->productToAttributeOptions($pid);
            //pre($arrAttrOpt);
            $this->arrCombinedAttrOpt = $objCore->combineAttributesOptions($arrAttrOpt);
          //  pre($this->arrCombinedAttrOpt);
        }
    }

}

$objPage = new ProductPriceInventoryCtrl();
$objPage->pageLoad();
?>
