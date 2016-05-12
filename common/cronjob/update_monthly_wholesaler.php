<?php

require_once '../config/config.inc.php';

class PremiumMonthWholesaler extends Database {

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
        $arrKpiSettingRowSold = $this->getArrayResult("SELECT productSold,KPIValue FROM " . TABLE_KPI_PRE_SETTING . " WHERE 1");
        
        $varWholesalerFetchQueryLastMonth = "SELECT (product.fkCategoryID) as category FROM " . TABLE_ORDER_ITEMS . " OI INNER JOIN " . TABLE_WHOLESALER . " ON OI.fkWholesalerID=pkWholesalerID INNER JOIN ".TABLE_PRODUCT."  product ON (fkItemID=product.pkProductID) WHERE ItemDateAdded BETWEEN NOW() - INTERVAL 30 DAY AND NOW() group by product.fkCategoryID";
        $arrOrderedWholesalerLastMonth = $this->getArrayResult($varWholesalerFetchQueryLastMonth);
        //mail('raju.khatak@mail.vinove.com','lastCat',print_r($arrOrderedWholesalerLastMonth,1));
        if(count($arrOrderedWholesalerLastMonth)>0){
            $counter=1;
            foreach($arrOrderedWholesalerLastMonth as $key=>$catLastMonth){
                
                $varWholesalerFetchQuery = "SELECT distinct(OI.fkWholesalerID) as fkWholesalerID,TIMESTAMPDIFF(MONTH, WholesalerDateAdded, NOW()) as life,sum(  OI.Quantity ) AS orders FROM " . TABLE_ORDER_ITEMS . " OI INNER JOIN " . TABLE_WHOLESALER . " ON OI.fkWholesalerID=pkWholesalerID INNER JOIN ".TABLE_PRODUCT."  product ON (fkItemID=product.pkProductID) WHERE product.fkCategoryID='".(int) $catLastMonth['category']."' GROUP BY fkWholesalerID,product.fkCategoryID HAVING orders >='{$arrKpiSettingRowSold[0]['productSold']}'";
                $arrOrderedWholesaler = $this->getArrayResult($varWholesalerFetchQuery);
                //mail('raju.khatak@mail.vinove.com','lastCat',$varWholesalerFetchQuery);
                //mail('raju.khatak@mail.vinove.com','lastCat',print_r($arrOrderedWholesaler,1));
                if(count($arrOrderedWholesaler)>0){
            
            foreach($arrOrderedWholesaler as $key=>$whid){ 
                
                $varKpiSaleTarget = $arrKpiSettingRowSold[0]['productSold'];
                $varKpiKpiTarget = $arrKpiSettingRowSold[0]['KPIValue'];


                $arrSoldProduct = $this->getArrayResult("SELECT sum(OI.Quantity) as num,sum(ItemPrice*OI.Quantity) ItemPrice FROM " . TABLE_ORDER_ITEMS . " OI INNER JOIN ".TABLE_PRODUCT."  product ON (fkItemID=product.pkProductID AND ItemType='product') WHERE OI.fkWholesalerID='" . $whid['fkWholesalerID'] . "' AND product.fkCategoryID='".(int) $catLastMonth['category']."'");

                $varTotalSoldProduct = $arrSoldProduct[0]['num'];// get total number of sold product
                $varTotalSoldProductPrice = $arrSoldProduct[0]['ItemPrice'];// get total number price of sold product

                if (trim($varTotalSoldProduct) >= trim($varKpiSaleTarget)) {
                    // get total positive feedback
                    $arrPostiveFeedback = $this->getArrayResult("SELECT count(pkFeedbackID) as num FROM " . TABLE_WHOLESALER_FEEDBACK . " wh INNER JOIN ".TABLE_PRODUCT."  product ON (fkProductID=product.pkProductID) WHERE wh.fkWholesalerID='" . $whid['fkWholesalerID'] . "' AND IsPositive='1' AND product.fkCategoryID='".(int) $catLastMonth['category']."' AND FeedbackDateAdded > ( NOW( ) - INTERVAL 1 MONTH )");
                    // get total feedback
                    $arrTotalFeedback = $this->getArrayResult("SELECT count(pkFeedbackID) as num FROM " . TABLE_WHOLESALER_FEEDBACK . " wh INNER JOIN ".TABLE_PRODUCT."  product ON (fkProductID=product.pkProductID) WHERE wh.fkWholesalerID='" . $whid['fkWholesalerID'] . "' AND product.fkCategoryID='".(int) $catLastMonth['category']."' AND FeedbackDateAdded > ( NOW( ) - INTERVAL 1 MONTH )");
                    
                    
                    
                         $varTotalFeedback = $arrTotalFeedback[0]['num'];
                         $varPostiveFeedback = $arrPostiveFeedback[0]['num'];
                         $kpi = ($varPostiveFeedback / $varTotalFeedback) * 100;// get kpi in %
                         $kpi= number_format($kpi, 2);
                         // business condition
                         if(trim($kpi) >= trim($varKpiKpiTarget)){
                         $arrRes['details'][$counter][$whid['fkWholesalerID']]['kpi'] = $kpi;
                         $arrRes['details'][$counter][$whid['fkWholesalerID']]['fkCategoryPremiumID'] =$catLastMonth['category'];
                         $arrRes['details'][$counter][$whid['fkWholesalerID']]['productSale'] = $varTotalSoldProduct;
                         $arrRes['details'][$counter][$whid['fkWholesalerID']]['totalAmount'] = $varTotalSoldProductPrice;
                         $arrRes['details'][$counter][$whid['fkWholesalerID']]['positiveFeedback'] = $varPostiveFeedback;
                         
                         }
                         if(count($arrRes)>=6){
                         break;
                         }
                }
                $counter++;
            }
             
        }
                
        }
        }
       //mail('raju.khatak@mail.vinove.com','PostiveFeedback',print_r($arrRes['details'],1));
         $queryDelete="DELETE FROM tbl_premium_monthly_wholesaler";
         $this->getArrayResult($queryDelete);
         if(count($arrRes['details'])>0){
            $counter=1;
            $query='INSERT INTO tbl_premium_monthly_wholesaler VALUES ';
            foreach($arrRes['details'] as $key=>$value){
                foreach($value as $k=>$val){
                $fkWholesalerID=trim($k);
                $fkCategoryPremiumID=trim($val['fkCategoryPremiumID']);
                $totalAmount=trim($val['totalAmount']);
                $productSale=trim($val['productSale']);
                $positiveFeedback=trim($val['positiveFeedback']);
                $wholesalerKpi=trim($val['kpi']);
                $query.="({$fkWholesalerID},{$fkCategoryPremiumID},{$totalAmount},{$productSale},{$positiveFeedback},{$wholesalerKpi})";
                if(count($arrRes['details'])>$counter){
                $query.=",";    
                }
                }
            $counter++;
            }
            $getData=$this->getArrayResult("SELECT fkWholesalerID FROM tbl_premium_monthly_wholesaler");
            if(count($getData)==0){
               $arrResData= $this->getArrayResult($query);
            }
            
            
        }
        echo 'records has been successfully inserted';
        return $arrResData;
    }


}

$objGiftCard = new PremiumMonthWholesaler();
//$objGiftCard->runGiftCardMail();
?>