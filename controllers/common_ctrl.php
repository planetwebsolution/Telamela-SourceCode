<?php
/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_PATH . 'class_common.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';

class CommonCtrl extends Paging {
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
        $objCore = new Core();
        $objCore->setDefaultCurrency();

        /*
          if (isset($_COOKIE['googtrans']) && $_COOKIE['googtrans'] == '/en/en') {
          setcookie('googtrans', '', time() - 3600, '/');
          }
         */
        //$objAdminLogin = new AdminLogin();
        //check admin session
        //$objAdminLogin->isValidAdmin();
        //************ Get Admin Email here
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
    	global $arrCat;
        //pre($_POST);
        $objComman = new ClassCommon();
        $arrCat = $objComman->getCategories();	
        $arrCatChild = $objComman->getCategoriesChild();	
        $arrCatAds = $objComman->getCatAds(); 
        $arrCatMore = $objComman->getCategories();
        
        $this->arrData['arrCategoryListing'] = $arrCat[0];
        $this->arrData['arrtopMenuTree'] = $objComman->topMenuTree($arrCat,$arrCatChild,$arrCatAds);
        $this->arrData['arrtopDropTree'] = $objComman->topDropTreeLst($arrCat,$arrCatAds);        
        $this->arrCmsList = $objComman->CmsList();
    }

}
$objPage2 = new CommonCtrl();
$objPage2->pageLoad();
?>
