<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_coupon_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';

class CouponCtrl extends Paging {
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
        $objPaging = new Paging();
        $objCoupon = new Coupon();
		$objCore = new Core();

        if ($_SESSION['sessAdminPageLimit'] == '' || $_SESSION['sessAdminPageLimit'] < 1) {
            $this->varPageLimit = ADMIN_RECORD_LIMIT;
        } else {
            $this->varPageLimit = $_SESSION['sessAdminPageLimit'];
        }

        if (isset($_GET['page'])) {
            $varPage = $_GET['page'];
        } else {
            $varPage = '';
        }

        if(isset($_REQUEST['frmSearch']) && $_REQUEST['frmSearch'] == 'Search')
		{
			$arrSearchParameter = $_GET;
			$frmCouponName 			= $arrSearchParameter['frmCouponName'];
			$frmCouponCode 			= $arrSearchParameter['frmCouponCode'];
			$frmDiscount 			= $arrSearchParameter['frmDiscount'];
            $frmDateStart 				= $arrSearchParameter['frmDateStart'];
            $frmDateEnd 				= $arrSearchParameter['frmDateEnd'];
                        $varTrash 			= $arrSearchParameter['frmTrashPressed'];
                        
            $varWhr = ' 1';
			if($frmCouponName <> '')
			{
				$varWhr .= " AND CouponName like '%".addslashes($frmCouponName)."%'";
			}
			if($frmCouponCode <> '')
			{
				$varWhr .= " AND CouponCode like '%".addslashes($frmCouponCode)."%'";	
			}		
			if($frmDiscount <> '')
			{
				$varWhr .= " AND Discount = ".$frmDiscount;
			}		
			if($frmDateStart <> '')
			{
				$varWhr .= " AND DateStart >= '".$objCore->defaultDateTime($frmDateStart,DATE_FORMAT_DB)."'";
			}		
			if($frmDateEnd <> '')
			{
				$varWhr .= " AND DateEnd <= '".$objCore->defaultDateTime($frmDateEnd,DATE_FORMAT_DB)."'";
			}	             
			//echo $varWhr;          
			
			$this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
	        $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
	        $arrRecords = $objCoupon->CouponList($varWhr, '');
	        $this->NumberofRows = count($arrRecords);
	        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
	        $this->arrRows = $objCoupon->CouponList($varWhr, $this->varLimit);        
                       
						
		}else{
	        $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
	        $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
	        $arrRecords = $objCoupon->CouponList($varWhr = '', $limit = '');
	        $this->NumberofRows = count($arrRecords);
	        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
	        $this->arrRows = $objCoupon->CouponList($varWhr = '', $this->varLimit);
	        //echo '<pre>';print_r($this->arrRows);die;
        
    	}
    	$this->varSortColumn = $objCoupon->getSortColumn($_REQUEST);
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
        $objCore = new Core();
        $objCoupon = new Coupon();

        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'add' && $_GET['type'] == 'add') {   // Editing images record
            
            $varAddStatus = $objCoupon->addCoupon($_POST);
            if ($varAddStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_ADD_SUCCUSS_MSG);
                header('location:coupon_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_ADD_ERROR_MSG);
                header('location:coupon_add_uil.php?type=' . $_GET['type']);
                die;
            }
        } else if(isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'edit' && $_GET['type'] == 'edit' && $_GET['id'] != '') {

            $varUpdateStatus = $objCoupon->updateCoupon($_POST);

            if ($varUpdateStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_UPDATE_SUCCUSS_MSG);
                header('location:coupon_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_UPDATE_ERROR_MSG);
                header('location:coupon_edit_uil.php?type=' . $_GET['type'] . '&id=' . $_GET['id']);
                die;
            }
        } else if (isset($_GET['id']) && $_GET['id'] != '' && ($_GET['type'] == 'edit')) {
            $varWhrCms = $_GET['id'];
            $this->arrRow = $objCoupon->editCoupon($varWhrCms);
            $this->arrCategoryDropDown = $objCoupon->CategoryFullDropDownList($varWhrCms);
            
            
        }else {                              
            $this->getList();
            
            
        }
    }

}

$objPage = new CouponCtrl();
$objPage->pageLoad();
?>
