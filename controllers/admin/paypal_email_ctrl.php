<?php
/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_paypal_email_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH.'class_common.php';
class Paypal_Email_Ctrl extends Paging {
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
       $objPaypal = new Paypal_email();


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
			$frmCountry 			= $arrSearchParameter['frmCompanyCountry'];
			$frmEmail			= $arrSearchParameter['frmEmail'];
                        
                         $varWhr = '1';
			if($frmCountry <> 0)
			{
				$varWhr .= " AND fkCountryID = ".$frmCountry." ";
			}
			if($frmEmail <> '')
			{
				$varWhr .= " AND EmailId like '%".addslashes(trim($frmEmail))."%'";	
			}		
			             
			//echo $varWhr;          
		 $this->arrCountryList = $objPaypal->countryList();	
		$this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
                $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
                $arrRecords = $objPaypal->EmailList($varWhr, $limit = '');
                $this->NumberofRows = count($arrRecords);
                $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
                $this->arrRows = $objPaypal->EmailList($varWhr, $this->varLimit);
                //echo '<pre>';print_r($this->arrRows);die;     
              $this->varSortColumn = $objPaypal->getSortColumn($_REQUEST);        
						
		}else{
                  $this->arrCountryList = $objPaypal->countryList();
                $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
                $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
                $arrRecords = $objPaypal->EmailList($varWhr = '', $limit = '');
                $this->NumberofRows = count($arrRecords);
                $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
                $this->arrRows = $objPaypal->EmailList($varWhr = '', $this->varLimit);
                //echo '<pre>';print_r($this->arrRows);die;
               $this->varSortColumn = $objPaypal->getSortColumn($_REQUEST);
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
        $objCore = new Core();
        $objPaypal = new Paypal_email();
         if(isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'add')
                    // Editing images record
		{	
			$varAddStatus = $objPaypal->addEmail($_POST);
                        if($varAddStatus>0){
				$objCore->setSuccessMsg(ADMIN_ADD_SUCCUSS_MSG);
				header('location:paypal_email_manage_uil.php');
                                die;
			}else{
				$objCore->setErrorMsg(ADMIN_USE_COUNTRY_ALREADY_EXIST);
				header('location:paypal_email_add_uil.php');
                                die;
			}
			
		}
                else if(isset($_POST['frmHidenEdit']) && $_POST['frmHidenEdit'] == 'edit' && $_GET['type'] == 'edit' && $_GET['paypalid'] != '') {
              
            $varUpdateStatus = $objPaypal->updatePaypal($_POST);

            if ($varUpdateStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_CMS_UPDATE_SUCCUSS_MSG);
                header('location:paypal_email_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_USE_COUNTRY_ALREADY_EXIST);
                header('location:paypal_email_edit_uil.php?type=' . $_GET['type'] . '&paypalid=' . $_GET['paypalid']);
                die;
            }
        }
                else if (isset($_GET['paypalid']) && $_GET['paypalid'] != '' && ($_GET['type'] == 'edit')) {
            $varWhrCms = $_GET['paypalid'];
            $this->arrCountryList = $objPaypal->countryList();  
            $this->arrRow = $objPaypal->editPaypal($varWhrCms);
                }
        else {          
           // $this->arrOffer = $objCms->todayOffer();            
            $this->getList();
            
            
        }
    }
}

$objPage = new Paypal_Email_Ctrl();
$objPage->pageLoad();
?>