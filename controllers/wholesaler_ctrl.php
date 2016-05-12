<?php

require_once CLASSES_PATH . 'class_wholesaler_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

class WholesalerCtrl extends Paging {
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
        if (isset($_SESSION['sessUserInfo']['id']) && $_SESSION['sessUserInfo']['type'] == 'wholesaler') {

            header('location:' . SITE_ROOT_URL . 'dashboard_wholesaler_account.php');
            die;
        }
        $objWholesaler = new Wholesaler();
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
        $objWholesaler = new Wholesaler();
        //pre("here");
        $this->arrCountryList = $objWholesaler->countryList();
        if (isset($_POST['frmHiddenAdd']) && $_POST['frmHiddenAdd'] == 'Add') {
            if ($objWholesaler->addWholesaler($_POST)) {
                header('location:thanks_message_wholesaler.php');
                die;
            } else {
                
            }
        }
    }

// end of page load
}

$objPage = new WholesalerCtrl();
$objPage->pageLoad();
?>
