<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_module_list_bll.php';

class moduleListCtrl extends Paging {
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
        //echo $objCore->setSuccessMsg();
        $objAdminLogin = new AdminLogin();
        //check admin session
        $objAdminLogin->isValidAdmin();
        //************ Get Admin Email here
        if ($_SESSION['sessUserType'] != 'super-admin') {
            $objCore->setErrorMsg(ADMIN_USER_PERMISSION_TITLE . '<br />' . ADMIN_USER_PERMISSION_MSG);
            header('location:' . $_SERVER['HTTP_REFERER']);
            die;
        }
    }

    private function getList() {
        $objPaging = new Paging();
        $objModuleList = new moduleList();
        $this->varSortColumn = $objModuleList->getSortColumn($_REQUEST);
        /* 		if($_GET['cmsCatID'] != '')
          {
          $varWhrCms = $_GET['cmsCatID'];
          }else{
          $varWhrCms = '';
          } */
        if ($_SESSION['sessAdminPageLimit'] == '' || $_SESSION['sessAdminPageLimit'] < 1) {
            $this->varPageLimit = ADMIN_RECORD_LIMIT;
        } else {
            $this->varPageLimit = $_SESSION['sessAdminPageLimit'];
        }


        $this->varPageStart = $objPaging->getPageStartLimit($_GET['page'], $this->varPageLimit);
        $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
        $arrRecords = $objModuleList->getRollList($varWhr = '', $limit = '');
        $this->NumberofRows = count($arrRecords);

        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
        $this->arrRows = $objModuleList->getRollList($varWhr = '', $this->varLimit);
        //echo '<pre>';print_r($this->arrRows);die;
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
        $objModuleList = new moduleList();
        $this->arrModuleList = $objModuleList->getModuleList();


        if ($_POST['frmHidnAddEdit'] == 'addEditRole' && $_GET['type'] == 'add') { // Editing images record
            $varAddStatus = $objModuleList->addRoll($_POST);

            if ($varAddStatus > 0) {
                $objCore->setSuccessMsg("Submitted Successfully.");
                header('location:user_roll_manage_uil.php');
                exit;
            } else {
                $objCore->setErrorMsg("Error while submitting, Please try again.");
                header('location:user_roll_add_uil.php?type=' . $_GET['type']);
                exit;
            }
        } else if ($_POST['frmHidnAddEdit'] == 'addEditRole' && $_GET['type'] == 'edit' && $_GET['rollid'] != '') {


            $varUpdateStatus = $objModuleList->updateRoll($_POST);


            if ($varUpdateStatus > 0) {

                $objCore->setSuccessMsg("Updated Successfully.");
                header('location:user_roll_manage_uil.php');
                die;
            } else {
                $objCore->setErrorMsg("Error while updating, Please try again.");
                header('location:user_roll_add_uil.php?type=' . $_GET['type'] . '&rollid=' . $_GET['rollid']);
                die;
            }
        } else if (isset($_GET['rollid']) && $_GET['rollid'] != '' && ($_GET['type'] == 'edit')) {
            $varWhrCms = $_GET['rollid'];
            $this->arrRow = $objModuleList->editRoll($varWhrCms);
        } else if ($_GET['type'] != 'add' && $_GET['type'] != 'edit') {
            $this->getList();
        }
    }

// end of page load
}

$objPage = new moduleListCtrl();
$objPage->pageLoad();
?>
