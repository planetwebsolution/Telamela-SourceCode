<?php

require_once CLASSES_PATH . 'class_wholesaler_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_paging_bll.php';

class WholesalerSupportCtrl extends Paging {
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
        //pre($_POST);
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
        global $objCore;
        $objWholesaler = new Wholesaler();
        $wsid = $_SESSION['sessUserInfo']['id'];
        $this->wsid = $wsid;
        $this->arrMessageType = $objWholesaler->getMessageTypeList();

        if ($_REQUEST['place'] && $_REQUEST['place'] == 'inbox') {
            $this->arrInbox = $objWholesaler->getWholesalerInbox($wsid);
            $this->paging($this->arrInbox);
            $this->arrInbox = $objWholesaler->getWholesalerInbox($wsid, $this->varLimit);
        }
        if ($_REQUEST['place'] && $_REQUEST['place'] == 'readInbox') {
            $mgsid = $objCore->getFormatValue($_REQUEST['mgsid']);
            $objWholesaler->givMessageRead($mgsid, $wsid);
            $this->arrMessage = $objWholesaler->getMessageDetail($mgsid, $wsid);
            // $this->arrMessageThread = $objWholesaler->getMessageThread($mgsid);
        }
        if ($_REQUEST['place'] && $_REQUEST['place'] == 'outbox') {
            $this->arrOutbox = $objWholesaler->getWholesalerOutbox($wsid);
            $this->paging($this->arrOutbox);
            $this->arrOutbox = $objWholesaler->getWholesalerOutbox($wsid, $this->varLimit);
        }
        if ($_REQUEST['place'] && $_REQUEST['place'] == 'readOutbox') {
            $msgid = $objCore->getFormatValue($_REQUEST['mgsid']);
            $this->arrMessage = $objWholesaler->getMessageOutboxDetail($msgid, $wsid);
            //pre($this->arrMessage);
            // $this->arrMessageThread = $objWholesaler->getMessageThread($_REQUEST['mgsid']);
        }
        if ($_REQUEST['action'] && $_REQUEST['action'] == 'delete' && $_REQUEST['mgsid']) {
            $msgid = addslashes($_REQUEST['mgsid']);
            $varNum = $objWholesaler->deleteMessage($msgid, $wsid);
            if ($varNum > 0) {
                $objCore->setSuccessMsg(FRONT_SUPPORT_DELETE_SUCCUSS_MSG);
            } else {
                $objCore->setSuccessMsg(FRONT_SUPPORT_DELETE_ERROR_MSG);
            }

            if ($_REQUEST['place'] == 'inbox') {
                header('location:' . $objCore->getUrl('wholesaler_messages_inbox.php', array('place' => 'inbox')));
                die;
            } elseif ($_REQUEST['place'] == 'outbox') {
                header('location:' . $objCore->getUrl('wholesaler_outbox_messages.php', array('place' => 'outbox')));
                die;
            }
        }

        if (isset($_POST['frmHidenAdd']) && $_POST['frmHidenAdd'] == 'Send') {
            $st = $objWholesaler->sendMessage($_POST);
            if ($st=='1') {
                $objCore->setSuccessMsg(FRONT_SUPPORT_SUCCUSS_MSG);
            } else {
                $objCore->setErrorMsg(FRONT_SUPPORT_ERROR_INVALID_EMAIL_MSG);
            }
            header('location:' . $objCore->getUrl('wholesaler_outbox_messages.php', array('place' => 'outbox')));
            die;
        }



        if ($_REQUEST['place'] && $_REQUEST['place'] == 'reply') {
            $res = $objWholesaler->replyMessage($_POST);
            if ($_POST['thread'] == 'inbox') {
                header('location:read_inbox_message.php?place=readInbox&mgsid=' . $_POST['fkSupportID']);
            } elseif ($_POST['thread'] == 'outbox') {
                header('location:read_outbox_message.php?place=readOutbox&mgsid=' . $_POST['fkSupportID']);
            }
            die;
        }
    }

// end of page load

    function paging($arrRecords) {
        $objPaging = new Paging();
        $this->varPageLimit = LIST_VIEW_RECORD_LIMIT;
        if (isset($_GET['page'])) {
            $varPage = $_GET['page'];
        } else {
            $varPage = '';
        }
        $this->varPageStart = $objPaging->getPageStartLimit($varPage, $this->varPageLimit);
        $this->varLimit = $this->varPageStart . ',' . $this->varPageLimit;
        $this->NumberofRows = count($arrRecords);
        $this->varNumberPages = $objPaging->calculateNumberofPages($this->NumberofRows, $this->varPageLimit);
    }

}

$objPage = new WholesalerSupportCtrl();
$objPage->pageLoad();
?>
