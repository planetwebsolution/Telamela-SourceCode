<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_reports_bll.php';
require_once CLASSES_PATH . 'class_common.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';

class ReportsCtrl extends Paging
{
    /*
     * Variable declaration begins
     *
     * holds the heading of the page
     */

    public $varHeading = '';

    /*
     * constructor
     */

    public function __construct()
    {
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
    public function pageLoad()
    {
        global $objGeneral;
        global $oCache;
        $objCore = new Core();
        $objReport = new Reports();
        $objClassCommon = new ClassCommon();
        
        if(isset($_REQUEST['section']) && $_REQUEST['section'] != ''){                              //Requesting for sections
            $sectionName=$_REQUEST['section'];            
            if($sectionName=='orders'){                                                              //Orders Section
                $actionName=(isset($_REQUEST['action']) && $_REQUEST['action'] != '') ? $_REQUEST['action']: 'today';
                
                //echo $actionName;
                
            }
            if($sectionName=='visitors'){                                                              //Orders Section
                $this->arrData['content']=$objReport->getUniqueVisitorsData();                
            }
        }else{                                                                                      //Reuesting for dashboard
            $this->arrData['section']='dashboard';
            $this->arrData['content']=$objReport->getDashboardData();
        }
        
    }

}

$objPage = new ReportsCtrl();
$objPage->pageLoad();
?>
