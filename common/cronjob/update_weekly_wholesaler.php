<?php

require_once '../config/config.inc.php';

class PremiumWeekWholesaler extends Database {

    /******************************************
      Function name : runCron
      Comments : This function call the cron functions one by one.
      User instruction : $res = $objClass->runCron();
     * **************************************** */
    public function __construct() {
        $objCore = new Core();
        $this->wholesalerKpi();
        //mail('raju.khatak@mail.vinove.com','hi','hi');
    }

    /**
     * function wholesalerKpi
     *
     * This function is used to calculate wholesaler kpi in % .
     *
     * Database Tables used in this function are : TABLE_WHOLESALER,TABLE_ORDER_ITEMS
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function wholesalerKpi()
    {
        // Fetch all wholesaler who product has been sold.
        $varWholesalerFetchQuery="SELECT distinct(fkWholesalerID) as fkWholesalerID FROM " . TABLE_ORDER_ITEMS . " INNER JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID=pkWholesalerID  WHERE 1";
        $arrOrderedWholesaler = $this->getArrayResult($varWholesalerFetchQuery);
        
        if(count($arrOrderedWholesaler)>0){
            
            foreach($arrOrderedWholesaler as $key=>$whid){ 
                $arrWholesalerRow = $this->getArrayResult("SELECT CompanyCountry FROM " . TABLE_WHOLESALER . " WHERE pkWholesalerID='" . $whid['fkWholesalerID'] . "'");

                $arrKpiSettingRow = $this->getArrayResult("SELECT fkCountryID,KPIValue FROM " . TABLE_KPI_SETTING . " WHERE fkCountryID ='0' OR fkCountryID = '" . $arrWholesalerRow[0]['CompanyCountry'] . "' ORDER BY fkCountryID DESC");

                $varKpiSaleTarget = $arrKpiSettingRow[0]['KPIValue'];

                $arrSoldProduct = $this->getArrayResult("SELECT count(pkOrderItemID) as num,sum(ItemPrice) ItemPrice FROM " . TABLE_ORDER_ITEMS . " WHERE fkWholesalerID='" . $whid['fkWholesalerID'] . "'");

                 $varTotalSoldProduct = $arrSoldProduct[0]['num'];// get total number of sold product
                 $varTotalSoldProductPrice = $arrSoldProduct[0]['ItemPrice'];// get total number price of sold product
              

                if ($varTotalSoldProduct >= $varKpiSaleTarget) { 
                    // get total positive feedback
                    $arrPostiveFeedback = $this->getArrayResult("SELECT count(pkFeedbackID) as num FROM " . TABLE_WHOLESALER_FEEDBACK . " WHERE fkWholesalerID='" . $whid['fkWholesalerID'] . "' AND FeedbackDateAdded > ( NOW( ) - INTERVAL 1 WEEK ) AND IsPositive=1");
                    // get total feedback
                    $arrTotalFeedback = $this->getArrayResult("SELECT count(pkFeedbackID) as num FROM " . TABLE_WHOLESALER_FEEDBACK . " WHERE fkWholesalerID='" . $whid['fkWholesalerID'] . "' AND FeedbackDateAdded > ( NOW( ) - INTERVAL 1 WEEK ) ");


                         $varTotalFeedback = $arrTotalFeedback[0]['num'];
                         $varPostiveFeedback = $arrPostiveFeedback[0]['num'];
                         $kpi = ($varPostiveFeedback / $varTotalFeedback) * 100;// get kpi in %
                         $kpi= number_format($kpi, 2);
                         // business condition
                         if($kpi>=95){
                         $arrRes['details'][$whid['fkWholesalerID']]['kpi'] = $kpi;
                         $arrRes['details'][$whid['fkWholesalerID']]['productSale'] = $varTotalSoldProduct;
                         $arrRes['details'][$whid['fkWholesalerID']]['totalAmount'] = $varTotalSoldProductPrice;
                         $arrRes['details'][$whid['fkWholesalerID']]['positiveFeedback'] = $varPostiveFeedback;
                         
                         }
                         if(count($arrRes)>=50){
                         break;
                         }
                }
            }
            
        }
        
        if(count($arrRes['details'])>0){
            $counter=1;
            $query='INSERT INTO tbl_premium_wholesaler VALUES';
            foreach($arrRes['details'] as $key=>$value){
                $fkWholesalerID=trim($key);
                $totalAmount=trim($value['totalAmount']);
                $productSale=trim($value['productSale']);
                $positiveFeedback=trim($value['positiveFeedback']);
                $wholesalerKpi=trim($value['kpi']);
                $query.=" ({$fkWholesalerID},{$totalAmount},{$productSale},{$positiveFeedback},{$wholesalerKpi})";
                if(count($arrRes['details'])>$counter){
                $query.=",";    
                }
            $counter++;
            }
            $queryDelete="DELETE FROM tbl_premium_wholesaler";
            $this->getArrayResult($queryDelete);
            
            $getData=$this->getArrayResult("SELECT fkWholesalerID FROM tbl_premium_wholesaler");
            if(count($getData)==0){
               $arrResData= $this->getArrayResult($query);
            }
            
            
        }
        echo 'records has been successfully inserted';
        return $arrResData;
    }


}

$objGiftCard = new PremiumWeekWholesaler();
//$objGiftCard->runGiftCardMail();
?>