<?php

require_once CLASSES_PATH . 'class_customer_user_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';

class customerOrderDetailCtrl {
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
        if (!isset($_SESSION['sessUserInfo']['type']) || $_SESSION['sessUserInfo']['type'] <> 'customer') {
            header('location:' . SITE_ROOT_URL);
        }

        $objCore = new Core();
        $objCore->setCurrencyPrice();
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
         global $objGeneral;
        $cid = $_SESSION['sessUserInfo']['id'];
        $oid = $objCore->getFormatValue($_REQUEST['oid']);

        if (isset($_POST['post_feedback']) && $_POST['post_feedback'] == 'yes') {
        	
            $arrID = $objCustomer->postCustomerFeedback();
            header('location:' . $objCore->getUrl('my_order_details.php', array('action'=>'view','oid' => $oid)));
            die;
        } else if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'reorder' && $_REQUEST['productID'] != '') {
            $objCustomer->customerReoder($_REQUEST['productID']);
            header('location:' . $objCore->getUrl('shopping_cart.php'));
            die;
        } else if (isset($_GET['type']) && $_GET['type'] == 'invoice' && $_GET['oid'] <> '') {
            $oid = $objCore->getFormatValue($_GET['oid']);
            $this->arrData['arrInvoice'] = $objCustomer->getInvoiceDetails($oid, $cid);
        } else if (isset($_POST['type']) && $_POST['type'] == 'dispute' && $_POST['oid'] <> '') {
           
            $oid = $objCore->getFormatValue($_REQUEST['oid']);
            $rewardpoints=$objCustomer->getrewieddetail($oid);
            $rewardid=$rewardpoints[0]['pkRewardPointID'];
            $fkCustomerID=$rewardpoints[0]['fkCustomerID'];
            $Points=$rewardpoints[0]['Points'];
            
            if(!empty($rewardid))
            {
              $updatereward=$objCustomer->updaterewieddetail($rewardid,$fkCustomerID);  
              
            }
           
             //pre($rewardpoints);
            $objCustomer->markAsDisputed($_REQUEST, $cid);
            $objCore->setSuccessMsg(ORDER_DISPUTED_SUCCESS_MESSAGE);
            header('location:' . $objCore->getUrl('my_order_details.php', array('action'=>'view','oid' => $oid)));
            die;
        } else if (isset($_POST['type']) && $_POST['type'] == 'disputeFeedback' && $_POST['oid'] <> '') {
            $oid = $objCore->getFormatValue($_REQUEST['oid']);
            $objCustomer->disputeFeedback($_REQUEST, $cid);
            $objCore->setSuccessMsg(ORDER_DISPUTED_FEEDBACK_SUCCESS_MESSAGE);
            header('location:' . $objCore->getUrl('my_order_details.php', array('action'=>'view','oid' => $oid)));
            die;
        } else {
            $this->arrData['CustomerDeatails'] = $objCustomer->getCustomerDetails($oid, $cid);
            if (count($this->arrData['CustomerDeatails']) > 0) {
                $this->arrData['orderProducts'] = $objCustomer->getOrderProducts($oid);
                $this->arrData['orderComments'] = $objCustomer->getOrderComments($oid);
                $this->arrData['orderTotal'] = $objCustomer->getOrderTotal($oid);
               // pre($this->arrData['orderTotal']);
                $this->arrData['arrDisputedCommentList'] = $objCustomer->getDisputedCommentList();
            }
        }
        
        
        //pre($this->arrData['arrShippingDetails']);
        // end of page load
    }

    /*
     * function InsertFeedback
     * 
     * This function is used to update feedback if customer not provided any feedback till 30 days.
     * 
     * Database Tables used in this function are : tbl_order, tbl_wholesaler_feedback
     * 
     * @access public
     * 
     * @author : Krishna Gupta
     * 
     * @created : 19-10-2015
     */
    public function InsertFeedback($data) {
    	$arrClms = array( 'fkCustomerID' );
    	$where = "pkOrderID=".$data['fkOrderID'];
    	$a = mysql_query("select fkCustomerID from tbl_order where ". $where);
    	$redata = mysql_fetch_array($a);
    	
    	$b = "INSERT INTO `tbl_wholesaler_feedback` (fkWholesalerID, fkCustomerID, fkProductID, fkOrderID, Question1, Question2, Question3, Comment, IsPositive, feedbackUpdate, FeedbackDateAdded) values ('".$data['fkWholesalerID']."', '".$redata[0]."', '".$data['fkItemID']."', '".$data['fkOrderID']."', '1', '1', '1', '', '1', '0', NOW())";
    	
    	$result = mysql_query($b);
    	
    } 
    
}

$objPage = new customerOrderDetailCtrl();
$objPage->pageLoad();

//print_r($objPage->arrRow[0]);
?>
