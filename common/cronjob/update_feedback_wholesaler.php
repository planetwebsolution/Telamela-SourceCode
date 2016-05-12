<?php

require_once '../config/config.inc.php';

class feedbackWholesaler extends Database {

    /******************************************
      Function name : runCron
      Comments : This function call the cron functions one by one.
      User instruction : $res = $objClass->runCron();
     * **************************************** */
    public function __construct() {
        $objCore = new Core();
        $this->manageWholesalerFeedback();
    }

    /**
     * function manageWholesalerFeedback
     *
     * This function is used manage the customer feedback section after 30days an order .
     *
     * Database Tables used in this function are : tbl_order_items,tbl_order,tbl_wholesaler_feedback
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function manageWholesalerFeedback()
    {
        // Fetch all wholesaler records who are not getting any feedback from last 30 days.
        
         $tableToGetWholQuery ="select * from (
SELECT O.fkCustomerID,OI.fkOrderID,OI.fkItemID,OI.fkWholesalerID,CONCAT(O.fkCustomerID,OI.fkOrderID,OI.fkItemID,OI.fkWholesalerID) AS F FROM tbl_order_items as OI INNER JOIN tbl_order O ON OI.fkOrderID=O.pkOrderID where ItemDateAdded < DATE_SUB(NOW(), INTERVAL 30 DAY) AND OI.ItemType!='gift-card') as viewTable where F NOT IN (SELECT CONCAT(fkCustomerID,fkOrderID,fkProductID,fkWholesalerID) AS F2 FROM tbl_wholesaler_feedback)";
        $arrWholesaler = $this->getArrayResult($tableToGetWholQuery);
        if(count($arrWholesaler) > 0){
            $counter=1;
            $query='INSERT INTO tbl_wholesaler_feedback (fkWholesalerID,fkCustomerID,fkProductID,fkOrderID,Question1,Question2,Question3,IsPositive,FeedbackDateAdded) VALUES ';
            foreach($arrWholesaler as $key=>$val){
                $fkWholesalerID=trim($val['fkWholesalerID']);
                $fkCustomerID=trim($val['fkCustomerID']);
                $fkProductID=trim($val['fkItemID']);
                $fkOrderID=trim($val['fkOrderID']);
                $Question1='1';
                $Question2='1';
                $Question3='1';
                $IsPositive='1';
                $FeedbackDateAdded="'".date('Y-m-d H:i:s')."'";
                $query.="({$fkWholesalerID},{$fkCustomerID},{$fkProductID},{$fkOrderID},{$Question1},{$Question2},{$Question3},{$IsPositive},{$FeedbackDateAdded})";
                if(count($arrWholesaler)>$counter){
                $query.=",";    
                }  
                $counter++;
            }
            $arrResData= $this->getArrayResult($query);
        }
       
        echo 'records has been successfully inserted';
        return $arrResData;
    }


}

$objGiftCard = new feedbackWholesaler();
//$objGiftCard->runGiftCardMail();
?>