<?php

/**
 * mainNewsMediaManageCtrl class controller.
 */
require_once CLASSES_ADMIN_PATH . 'class_enquiry_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';
require_once CLASSES_PATH . 'class_common.php';

class EnquiryCtrl extends Paging {
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
        $objEnquiry = new Enquiry();


        if ($_SESSION['sessAdminPageLimit'] == '' || $_SESSION['sessAdminPageLimit'] < 1) {
            $this->varPageLimit = ADMIN_RECORD_LIMIT;
        } else {
            $this->varPageLimit = $_SESSION['sessAdminPageLimit'];
        }

        if (isset($_GET['page'])) {
            $varPage = $_GET['page'];
        } else {
            $varPage = 0;
        }
        
        if (isset($_REQUEST['frmSearch']) && $_REQUEST['frmSearch'] == 'Search') {
            $arrSearchParameter = $_GET;
            $frmSenderName = $arrSearchParameter['frmSenderName'];
            $frmEmail = $arrSearchParameter['frmEmail'];
            $frmSubjectCode = $arrSearchParameter['frmSubjectCode'];


            $varWhr = ' 1';
            if ($frmSenderName <> '') {
                $varWhr .= " AND EnquirySenderName like '%" . addslashes($frmSenderName) . "%'";
            }
            if ($frmEmail <> '') {
                $varWhr .= " AND EnquirySenderEmail like '%" . addslashes($frmEmail) . "%'";
            }
            if ($frmSubjectCode <> '') {
                $varWhr .= " AND EnquirySubject like '%" . addslashes($frmSubjectCode) . "%'";
            }

            //echo $varWhr;          

            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = $objEnquiry->enquiryList($varWhr, $limit = '');
            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objEnquiry->enquiryList($varWhr, $this->varLimit);
            //echo '<pre>';print_r($this->arrRows);die;
            $this->varSortColumn = $objEnquiry->getSortColumn($_REQUEST);
        } else {

            $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
            $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
            $arrRecords = $objEnquiry->enquiryList($varWhr = '', $limit = '');
            $this->NumberofRows = count($arrRecords);
            $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
            $this->arrRows = $objEnquiry->enquiryList($varWhr = '', $this->varLimit);
            //echo '<pre>';print_r($this->arrRows);die;
            $this->varSortColumn = $objEnquiry->getSortColumn($_REQUEST);
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
        $objEnquiry = new Enquiry();

        if (isset($_GET['id']) && $_GET['id'] != '' && ($_GET['type'] == 'view')) {
            $varWhrCms = $_GET['id'];
            $this->arrEnquiry = $objEnquiry->viewEnquiry($varWhrCms);
            $this->arrRow = $this->arrEnquiry['arrEnquiryDetails'];
            $this->arrReply = $this->arrEnquiry['arrEnquiryReplyDetails'];
        }
        if (isset($_POST['frmHidenAdd']) && ($_POST['frmHidenAdd'] == 'Reply')) {   // Editing images record
            $varAddStatus = $objEnquiry->sendReplyEnquiry($_POST);
            if ($varAddStatus > 0) {
                $objCore->setSuccessMsg(ADMIN_SUPPORT_ADD_SUCCUSS_MSG);
                header('location: dashboard_uil.php');
                die;
            } else {
                $objCore->setErrorMsg(ADMIN_SUPPORT_ADD_ERROR_MSG);
                header('location:' . $_SERVER['HTTP_REFERER']);
                die;
            }
        } else {
            $this->getList();
        }
    }

}

$objPage = new EnquiryCtrl();
$objPage->pageLoad();
?>
