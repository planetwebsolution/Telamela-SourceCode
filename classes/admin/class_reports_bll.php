<?php 

/**
 * Class name : Reports
 *
 * Parent module : None
 *
 * Author : Sandeep Sharma
 *
 * Last modified by : Sandeep Sharma
 *
 * Comments : The Reports class is used to maintain Reports infomation details to user for several modules.
 */
class Reports extends Database {

    /**
     * function Ads
     *
     * Constructor of the class, will be called in PHP5
     *
     * @access public
     *
     */
    function Reports() {
        //$objCore = new Core();
        //default constructor for this class
    }

    /**
     * function getDashboardData
     *
     * This function is used to display the dashboard deatails.
     *
     * Database Tables used in this function are : tbl_orders etc
     *
     * @access public
     *
     * @return array $arrRes
     *
     * User instruction: $objAds->adsList()
     */
    function getDashboardData() {
        $arrRes=array();
        
        //For Calculating orders count
        $arrClms = 'pkOrderItemID';
        $varTable = TABLE_ORDER_ITEMS;
        $argWhere = 'AND Status <> "Canceled"';
        $arrNum = $this->getNumRows($varTable, $arrClms, $argWhere);
        $arrRes['ordersCount']=$arrNum;
        
        //For Calculating Unique visitors count
        $varQuery = "SELECT  count(DISTINCT VisitorIP) as count FROM " . TABLE_VISITOR;
        $arrData = $this->getArrayResult($varQuery);
        //pre($arrData);
        $arrRes['visitorsCount']=$arrData;
        
        
        //For Calculating Total Revenue(from orders) sum
        $varQuery = "SELECT  pkOrderItemID,ItemType,
                    CASE ItemType
                    WHEN  'product' THEN Quantity*((ItemPrice-ItemACPrice)+(((100-w.Commission)*ItemACPrice)/100))
                    WHEN 'gift-card' THEN ItemSubTotal
                    WHEN 'package' THEN Quantity*(ItemPrice-ItemACPrice)
                    ELSE NULL END as 'revenue'
                    FROM " . TABLE_ORDER_ITEMS . " LEFT JOIN ".TABLE_WHOLESALER." w ON w.pkWholesalerID=fkWholesalerID WHERE Status <> 'Canceled'";
        $arrData = $this->getArrayResult($varQuery);
        $sum=0;
        foreach($arrData as $data){
            $sum+=$data['revenue'];
        }
        //echo $sum;
        
        //pre($arrData);
        $arrRes['revenueSum']=$sum;
        
        //pre($arrRes);
        return $arrRes;
    }
    
    /**
     * function getOrdersData
     *
     * This function is used to get the orders data
     *
     * Database Tables used in this function are : tbl_orders etc
     *
     * @access public
     *
     * @return array $arrRes
     *
     * User instruction: $objAds->adsList()
     */
    function getOrdersData($varAction=null,$data=null) {
        //echo "<pre>";
        $objClassCommon = new ClassCommon();
        $arrRes=array();
        $argWhere='';
        $varTable = TABLE_ORDER_ITEMS;
        $total=0;
        if($varAction=='today' || $varAction=='yesterday'){
            if($varAction=='today'){
                $dateToday=date('Y-m-d');           
            }else{
                $dateToday=date('Y-m-d',strtotime("-1 days"));
            }
            
            
            for ($i=4;$i<25;$i=$i+4){
                
                $num_paddedTotime = sprintf("%02d", $i);
                $num_paddedFromtime = sprintf("%02d", $i-4);
                $toTime=$dateToday.' '.$num_paddedTotime.':00:00';
                $fromTime=$dateToday.' '.$num_paddedFromtime.':00:00';
                
                $arrClms = array('TIME(ItemDateAdded) as date');
                $argWhere = 'ItemDateAdded >= "'.$fromTime.'" AND  ItemDateAdded < "'.$toTime.'"';
                $argWhere .= 'AND Status <> "Canceled"';
                
                $arrData = $this->select($varTable, $arrClms, $argWhere);
                $count=count($arrData);
                $arrRes['data'][$i]['time'][]=$arrData;
                $arrRes['data'][$i]['count']=$count;
                $total +=$count;
            }
            $arrRes['total']=$total;
            //print_r($arrRes);
            //die;
            //print_r($arrData);
            //print_r($arrTime);
            //print_r($arrRangeTimes);
        }elseif($varAction=='last_week'){
            $arrWeeksDates=$objClassCommon->getlastWeekDates();
            
            
            foreach($arrWeeksDates as $key=>$date){
                $toTime=$date.' 23:00:00';
                $fromTime=$date.' 00:00:00';
                
                $arrClms = array('DATE(ItemDateAdded) as date');
                $argWhere = 'ItemDateAdded >= "'.$fromTime.'" AND  ItemDateAdded <= "'.$toTime.'"';
                $argWhere .= 'AND Status <> "Canceled"';
                
                $arrData = $this->select($varTable, $arrClms, $argWhere);
                $count=count($arrData);
                $arrRes['data'][$key]['dates']=$arrData;
                $arrRes['data'][$key]['count']=$count;
                $total +=$count;
            }
            $arrRes['total']=$total;
            //print_r($arrWeeksDates);
            //print_r($arrRes);
            //die;
            //print_r($arrData);
            //print_r($arrTime);
            //print_r($arrRangeTimes);
        }elseif($varAction=='last_month'){
            $lastMonth=date('n', strtotime(date('Y-m')." -1 month"));
            $lastMonthYear=date('Y', strtotime(date('Y-m')." -1 month"));
            
            $arrWeeksDates=$objClassCommon->getWeeks($lastMonth,$lastMonthYear);
            //echo $lastMonth.'=='.$lastMonthYear;
            //echo "<pre>";
            //print_r($arrWeeksDates);
            //die;
            
            foreach($arrWeeksDates as $key=>$date){
                $toTime=$date['endDate'].' 23:00:00';
                $fromTime=$date['startDate'].' 00:00:00';
                
                $arrClms = array('DATE(ItemDateAdded) as date');
                $argWhere = 'ItemDateAdded >= "'.$fromTime.'" AND  ItemDateAdded <= "'.$toTime.'"';
                $argWhere .= 'AND Status <> "Canceled"';
                
                $arrData = $this->select($varTable, $arrClms, $argWhere);
                $count=count($arrData);
                $arrRes['data'][$key]['dates']=$arrData;
                $arrRes['data'][$key]['count']=$count;
                $total +=$count;                
            }
            $arrRes['total']=$total;
            //print_r($arrWeeksDates);
            //print_r($arrRes);
            //die;
            //print_r($arrData);
            //print_r($arrTime);
            //print_r($arrRangeTimes);
        }elseif($varAction=='searchReports'){
            $argWhere='';
            if($data['fromDate'] !=''){
                $argWhere .='ItemDateAdded >= "'.date('Y-m-d',strtotime($data['fromDate'])).' 00:00:00"';
            }
            if($data['toDate'] !=''){
                if($argWhere != ''){
                    $argWhere .=' AND  ItemDateAdded <= "'.date('Y-m-d',strtotime($data['toDate'])).' 23:00:00"';
                }else{
                    $argWhere .='ItemDateAdded <= "'.date('Y-m-d',strtotime($data['toDate'])).' 23:00:00"';
                }
                
            }
            
            $arrClms = array('count(ItemDateAdded) as counts');
            $argWhere .= 'AND Status <> "Canceled"';
            
            $arrData = $this->select($varTable, $arrClms, $argWhere);
            $count=$arrData[0]['counts'];
            $arrRes['result']=$count;
        }elseif($varAction=='top_order'){
            
            $varQuery = "SELECT count(fkItemID) as count,fkItemID,ItemName FROM " . $varTable . " WHERE Status <> 'Canceled' AND ItemType ='product' GROUP BY fkItemID ORDER BY count DESC LIMIT 10";
            $arrData = $this->getArrayResult($varQuery);
            //pre($arrData);
            $arrRes['result']=$arrData;
            $arrRes['count']=count($arrData);
        }
        
        //die;
        echo json_encode($arrRes);
        die;
    }
    
    /**
    * Function : getLoader
    * prints loader according to the type of loader requested
    * @access public
    * @param $loaderType
    */
    public function getLoader($loaderType=null,$class=null){
        if($loaderType=='' || $loaderType=="page"){
            echo '<div class="loader-holder loader-page-specific '.$class.'"><img src="'.IMAGE_PATH_URL.'loaders/green_100X34.gif" alt="loader"/></div>';
        }elseif($loaderType=='block'){
            echo '<div class="loader-holder loader-block-specific '.$class.'"><img src="'.IMAGE_PATH_URL.'loaders/green_100X34.gif" alt="loader"/></div>';
        }
    }
    
    /**
     * function getUniqueVisitorsData
     *
     * This function is used to display the unique visitors data.
     *
     * Database Tables used in this function are : tbl_visitors etc
     *
     * @access public
     *
     * @return array $arrRes
     *
     * User instruction: $objReport->getUniqueVisitorsData()
     */
    function getUniqueVisitorsData() {
        $objClassCommon = new ClassCommon();
        $arrRes=array();
        
        $lastmonthStartDate=$objClassCommon->calculateMonthDate(date("Y-m-d"), '1', '01', '-');
        $lastmonthEndDate=$objClassCommon->calculateMonthDate(date("Y-m-d"), '1', 't', '-');
        
        $currentmonthStartDate=$objClassCommon->calculateMonthDate(date("Y-m-d"), '0', '01', '-');
        $currentmonthEndDate=$objClassCommon->calculateMonthDate(date("Y-m-d"), '0', 't', '-');
        
        //echo $lastmonthStartDate."==".$lastmonthEndDate.'<br>'.$currentmonthStartDate.'=='.$currentmonthEndDate;
        //die;
        
        //For Calculating last month data
        $varQuery = "SELECT  count(DISTINCT VisitorIP) as count FROM " . TABLE_VISITOR . " WHERE DATE(Visitor_Date_Added) >='".$lastmonthStartDate."' AND DATE(Visitor_Date_Added) <='".$lastmonthEndDate."'";
        $arrData = $this->getArrayResult($varQuery);
        $arrRes['last']['count']=$arrData[0]['count'];
        
        //For Calculating current month data
        $varQuery = "SELECT  count(DISTINCT VisitorIP) as count FROM " . TABLE_VISITOR . " WHERE DATE(Visitor_Date_Added) >='".$currentmonthStartDate."' AND DATE(Visitor_Date_Added) <='".$currentmonthEndDate."'";
        $arrData = $this->getArrayResult($varQuery);
        $arrRes['current']['count']=$arrData[0]['count'];
        
        
        //pre($arrRes);
        return $arrRes;
    }
    
    /**
     * function getRevenueData
     *
     * This function is used to get the revenue data
     *
     * Database Tables used in this function are : tbl_orders,tbl_orders_items etc
     *
     * @access public
     *
     * @return array $arrRes
     *
     * User instruction: $objAds->adsList()
     */
    function getRevenueData($varAction=null,$data=null) {
        //echo "<pre>";
        $objClassCommon = new ClassCommon();
        $arrRes=array();
        $argWhere='';
        $varTable = TABLE_ORDER_ITEMS;
        
        if($varAction=='today' || $varAction=='yesterday'){
            if($varAction=='today'){
                $dateToday=date('Y-m-d');           
            }else{
                $dateToday=date('Y-m-d',strtotime("-1 days"));
            }
            
            
            for ($i=4;$i<25;$i=$i+4){
                
                $num_paddedTotime = sprintf("%02d", $i);
                $num_paddedFromtime = sprintf("%02d", $i-4);
                $toTime=$dateToday.' '.$num_paddedTotime.':00:00';
                $fromTime=$dateToday.' '.$num_paddedFromtime.':00:00';
                
                $arrClms = array('TIME(ItemDateAdded) as date');
                $argWhere = 'ItemDateAdded >= "'.$fromTime.'" AND  ItemDateAdded < "'.$toTime.'"';
                $argWhere .= 'AND Status <> "Canceled"';
                
                $arrData = $this->select($varTable, $arrClms, $argWhere);
                $count=count($arrData);
                $arrRes[$i]['time'][]=$arrData;
                $arrRes[$i]['count']=$count;
            }
            //print_r($arrRes);
            //die;
            //print_r($arrData);
            //print_r($arrTime);
            //print_r($arrRangeTimes);
        }elseif($varAction=='last_week'){
            $arrWeeksDates=$objClassCommon->getlastWeekDates();
            
            
            foreach($arrWeeksDates as $key=>$date){
                $toTime=$date.' 23:00:00';
                $fromTime=$date.' 00:00:00';
                
                $arrClms = array('DATE(ItemDateAdded) as date');
                $argWhere = 'ItemDateAdded >= "'.$fromTime.'" AND  ItemDateAdded <= "'.$toTime.'"';
                $argWhere .= 'AND Status <> "Canceled"';
                
                $arrData = $this->select($varTable, $arrClms, $argWhere);
                $count=count($arrData);
                $arrRes[$key]['dates']=$arrData;
                $arrRes[$key]['count']=$count;
            }
            //print_r($arrWeeksDates);
            //print_r($arrRes);
            //die;
            //print_r($arrData);
            //print_r($arrTime);
            //print_r($arrRangeTimes);
        }elseif($varAction=='last_month'){
            $lastMonth=date('n', strtotime(date('Y-m')." -1 month"));
            $lastMonthYear=date('Y', strtotime(date('Y-m')." -1 month"));
            
            $arrWeeksDates=$objClassCommon->getWeeks($lastMonth,$lastMonthYear);
            //echo $lastMonth.'=='.$lastMonthYear;
            //echo "<pre>";
            //print_r($arrWeeksDates);
            //die;
            
            foreach($arrWeeksDates as $key=>$date){
                $toTime=$date['endDate'].' 23:00:00';
                $fromTime=$date['startDate'].' 00:00:00';
                
                $arrClms = array('DATE(ItemDateAdded) as date');
                $argWhere = 'ItemDateAdded >= "'.$fromTime.'" AND  ItemDateAdded <= "'.$toTime.'"';
                $argWhere .= 'AND Status <> "Canceled"';
                
                $arrData = $this->select($varTable, $arrClms, $argWhere);
                $count=count($arrData);
                $arrRes[$key]['dates']=$arrData;
                $arrRes[$key]['count']=$count;
            }
            //print_r($arrWeeksDates);
            //print_r($arrRes);
            //die;
            //print_r($arrData);
            //print_r($arrTime);
            //print_r($arrRangeTimes);
        }elseif($varAction=='searchReports'){
            $argWhere='';
            if($data['fromDate'] !=''){
                $argWhere .='ItemDateAdded >= "'.date('Y-m-d',strtotime($data['fromDate'])).' 00:00:00"';
            }
            if($data['toDate'] !=''){
                if($argWhere != ''){
                    $argWhere .=' AND  ItemDateAdded <= "'.date('Y-m-d',strtotime($data['toDate'])).' 23:00:00"';
                }else{
                    $argWhere .='ItemDateAdded <= "'.date('Y-m-d',strtotime($data['toDate'])).' 23:00:00"';
                }
                
            }
            
            $arrClms = array('count(ItemDateAdded) as counts');
            $argWhere .= 'AND Status <> "Canceled"';
            
            $arrData = $this->select($varTable, $arrClms, $argWhere);
            $count=$arrData[0]['counts'];
            $arrRes['result']=$count;
        }elseif($varAction=='top_order'){
            
            $varQuery = "SELECT count(fkItemID) as count,fkItemID,ItemName FROM " . $varTable . " WHERE Status <> 'Canceled' AND ItemType ='product' GROUP BY fkItemID ORDER BY count DESC LIMIT 10";
            $arrData = $this->getArrayResult($varQuery);
            //pre($arrData);
            $arrRes['result']=$arrData;
            $arrRes['count']=count($arrData);
        }
        
        //die;
        echo json_encode($arrRes);
        die;
    }
    
    /**
     * function getRevenuesData
     *
     * This function is used to get the revenues data
     *
     * Database Tables used in this function are : tbl_orders_items
     *
     * @access public
     *
     * @return array $arrRes
     *
     * User instruction: $objReports->getRevenuesData()
     */
    function getRevenuesData($varAction=null,$data=null) {
        //echo "<pre>";
        $objClassCommon = new ClassCommon();
        $arrRes=array();
        $argWhere='';
        $varTable = TABLE_ORDER_ITEMS;
        $total=0;
        if($varAction=='daily' || $varAction=='yesterday'){
            if($varAction=='daily'){
                $dateToday=date('Y-m-d');           
            }else{
                $dateToday=date('Y-m-d',strtotime("-1 days"));
            }
            
            $sum=0;
            for ($i=4;$i<25;$i=$i+4){
                
                $num_paddedTotime = sprintf("%02d", $i);
                $num_paddedFromtime = sprintf("%02d", $i-4);
                $toTime=$dateToday.' '.$num_paddedTotime.':00:00';
                $fromTime=$dateToday.' '.$num_paddedFromtime.':00:00';
                
                $varQuery = "SELECT  pkOrderItemID,ItemType,TIME(ItemDateAdded) as date,
                            CASE ItemType
                            WHEN  'product' THEN Quantity*((ItemPrice-ItemACPrice)+(((100-w.Commission)*ItemACPrice)/100))
                            WHEN 'gift-card' THEN ItemSubTotal
                            WHEN 'package' THEN Quantity*(ItemPrice-ItemACPrice)
                            ELSE NULL END as 'revenue'
                            FROM " . TABLE_ORDER_ITEMS . " LEFT JOIN ".TABLE_WHOLESALER." w ON w.pkWholesalerID=fkWholesalerID WHERE Status <> 'Canceled' AND ItemDateAdded >= '".$fromTime."' AND  ItemDateAdded < '".$toTime."'";
                $arrData = $this->getArrayResult($varQuery);
                $currSum=0;
                foreach($arrData as $data){
                    $sum+=$data['revenue'];
                    $currSum+=$data['revenue'];
                }
                $count=count($arrData);
                $arrRes['data'][$i]['time']=$arrData;
                $arrRes['data'][$i]['count']=$currSum;
            }
            $arrRes['total']=$sum;
            //print_r($arrRes);
            //die;
            //print_r($arrData);
            //print_r($arrTime);
            //print_r($arrRangeTimes);
        }elseif($varAction=='weekly'){
            $arrWeeksDates=$objClassCommon->getlastWeekDates();
            
            
            foreach($arrWeeksDates as $key=>$date){
                $toTime=$date.' 23:00:00';
                $fromTime=$date.' 00:00:00';
                
                $varQuery = "SELECT  pkOrderItemID,ItemType,DATE(ItemDateAdded) as date,
                            CASE ItemType
                            WHEN  'product' THEN Quantity*((ItemPrice-ItemACPrice)+(((100-w.Commission)*ItemACPrice)/100))
                            WHEN 'gift-card' THEN ItemSubTotal
                            WHEN 'package' THEN Quantity*(ItemPrice-ItemACPrice)
                            ELSE NULL END as 'revenue'
                            FROM " . TABLE_ORDER_ITEMS . " LEFT JOIN ".TABLE_WHOLESALER." w ON w.pkWholesalerID=fkWholesalerID WHERE Status <> 'Canceled' AND ItemDateAdded >= '".$fromTime."' AND  ItemDateAdded <= '".$toTime."'";
                $arrData = $this->getArrayResult($varQuery);
                $currSum=0;
                foreach($arrData as $data){
                    $sum+=$data['revenue'];
                    $currSum+=$data['revenue'];
                }
                $count=count($arrData);
                $arrRes['data'][$key]['dates']=$arrData;
                $arrRes['data'][$key]['count']=$currSum;
                //
                //$count=count($arrData);
                //$arrRes['data'][$key]['dates']=$arrData;
                //$arrRes['data'][$key]['count']=$count;
                //$total +=$count;
            }
            $arrRes['total']=$sum;
            //print_r($arrWeeksDates);
            //print_r($arrRes);
            //die;
            //print_r($arrData);
            //print_r($arrTime);
            //print_r($arrRangeTimes);
        }elseif($varAction=='monthly'){
            $lastMonth=date('n', strtotime(date('Y-m')." -1 month"));
            $lastMonthYear=date('Y', strtotime(date('Y-m')." -1 month"));
            
            $arrWeeksDates=$objClassCommon->getWeeks($lastMonth,$lastMonthYear);
            //echo $currMonth.'=='.$currMonthYear;
            //echo "<pre>";
            //print_r($arrWeeksDates);
            //die;
            
            foreach($arrWeeksDates as $key=>$date){
                $toTime=$date['endDate'].' 23:00:00';
                $fromTime=$date['startDate'].' 00:00:00';
                
                $varQuery = "SELECT  pkOrderItemID,ItemType,DATE(ItemDateAdded) as date,
                            CASE ItemType
                            WHEN  'product' THEN Quantity*((ItemPrice-ItemACPrice)+(((100-w.Commission)*ItemACPrice)/100))
                            WHEN 'gift-card' THEN ItemSubTotal
                            WHEN 'package' THEN Quantity*(ItemPrice-ItemACPrice)
                            ELSE NULL END as 'revenue'
                            FROM " . TABLE_ORDER_ITEMS . " LEFT JOIN ".TABLE_WHOLESALER." w ON w.pkWholesalerID=fkWholesalerID WHERE Status <> 'Canceled' AND ItemDateAdded >= '".$fromTime."' AND  ItemDateAdded <= '".$toTime."'";
                $arrData = $this->getArrayResult($varQuery);
                $currSum=0;
                foreach($arrData as $data){
                    $sum+=$data['revenue'];
                    $currSum+=$data['revenue'];
                }
                $count=count($arrData);
                $arrRes['data'][$key]['dates']=$arrData;
                $arrRes['data'][$key]['count']=$currSum;
                
                
                //$arrClms = array('DATE(ItemDateAdded) as date');
                //$argWhere = 'ItemDateAdded >= "'.$fromTime.'" AND  ItemDateAdded <= "'.$toTime.'"';
                //$argWhere .= 'AND Status <> "Canceled"';
                //
                //$arrData = $this->select($varTable, $arrClms, $argWhere);
                //$count=count($arrData);
                //$arrRes['data'][$key]['dates']=$arrData;
                //$arrRes['data'][$key]['count']=$count;
                //$total +=$count;                
            }
            $arrRes['total']=$sum;
            //print_r($arrWeeksDates);
            //print_r($arrRes);
            //die;
            //print_r($arrData);
            //print_r($arrTime);
            //print_r($arrRangeTimes);
        }elseif($varAction=='searchReports'){
            $argWhere='';
            if($data['fromDate'] !=''){
                $argWhere .='ItemDateAdded >= "'.date('Y-m-d',strtotime($data['fromDate'])).' 00:00:00"';
            }
            if($data['toDate'] !=''){
                if($argWhere != ''){
                    $argWhere .=' AND  ItemDateAdded <= "'.date('Y-m-d',strtotime($data['toDate'])).' 23:00:00"';
                }else{
                    $argWhere .='ItemDateAdded <= "'.date('Y-m-d',strtotime($data['toDate'])).' 23:00:00"';
                }
                
            }
            
            $arrClms = array('count(ItemDateAdded) as counts');
            $argWhere .= 'AND Status <> "Canceled"';
            
            $arrData = $this->select($varTable, $arrClms, $argWhere);
            $count=$arrData[0]['counts'];
            $arrRes['result']=$count;
        }elseif($varAction=='top_order'){
            
            $varQuery = "SELECT count(fkItemID) as count,fkItemID,ItemName FROM " . $varTable . " WHERE Status <> 'Canceled' AND ItemType ='product' GROUP BY fkItemID ORDER BY count DESC LIMIT 10";
            $arrData = $this->getArrayResult($varQuery);
            //pre($arrData);
            $arrRes['result']=$arrData;
            $arrRes['count']=count($arrData);
        }
        
        //die;
        echo json_encode($arrRes);
        die;
    }
    
}

?>
