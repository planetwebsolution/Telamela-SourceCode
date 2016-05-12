<?php

require_once CLASSES_PATH . 'class_customer_user_bll.php';

class customerSupportCtrl {
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
        if ($_SESSION['sessUserInfo']['id'] && $_SESSION['sessUserInfo']['type'] == 'customer') {
            
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
        $objCore = new Core();
        $objCustomer = new Customer();
        $cid = $_SESSION['sessUserInfo']['id'];

        $this->arrSupportList = $objCustomer->supportList();
        if (isset($_REQUEST['place']) && $_REQUEST['place'] == 'outbox') {
            $this->arrCustomerSupportList = $objCustomer->customerOutboxSupportList();
        }

        if (isset($_REQUEST['place']) && $_REQUEST['place'] == 'inbox') {
            $this->arrCustomerInboxSupportList = $objCustomer->customerInboxSupportList();
        }
        //pre($this->arrCustomerInboxSupportList);
        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'Send') {   // Editing images record
            $objCustomer->addCustomerSupport($_POST);
            header('location:' . $objCore->getUrl('outbox_messages.php', array('place' => 'outbox')));
            die;
        }


        //Outbox message view
        if (isset($_REQUEST['frmOutboxChangeAction']) && $_REQUEST['frmOutboxChangeAction'] == 'view') {   // Editing images record
            $frmID = $objCore->getFormatValue($_REQUEST['frmID']);
            $this->arrOutboxMessageView = $objCustomer->outboxMessageViewById($frmID, $cid);
        }

        //Inbox message view

        if (isset($_REQUEST['frmInboxChangeAction']) && $_REQUEST['frmInboxChangeAction'] == 'view') {   // Editing images record
            $frmID = $objCore->getFormatValue($_REQUEST['frmID']);
            $objCustomer->givMessageRead($frmID);
            $this->arrInboxMessageView = $objCustomer->inboxMessageViewById($frmID, $cid);
            //$this->arrMessageThread = $objCustomer->getMessageThread($_REQUEST['frmID']);
        }



        if (isset($_REQUEST['place']) && $_REQUEST['place'] == 'reply') {
            $res = $objCustomer->replyMessage($_POST);
            header('location:' . $objCore->getUrl('messages_inbox.php', array('place' => 'inbox')));
            die;
        }
    }

}

$objPage = new customerSupportCtrl();
$objPage->pageLoad();


//print_r($objPage->arrRow[0]);
?>
