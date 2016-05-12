<?php

/**
 * 
 * Class name : Dashboard
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The Dashboard class is used to maintain Dashboard infomation details for several modules.
 */
class Dashboard extends Database {

    /**
     * function __construct
     *
     * Constructor of the class, will be called in PHP5
     *
     * @access public
     *
     */
    public function __construct() {
        //$objCore = new Core();
        //default constructor for this class
    }

    /**
     * function RecentEnquiry
     *
     * This function is used to display the Recent Enquiry.
     *
     * Database Tables used in this function are : tbl_enquiry
     *
     * @access public
     *
     * @parameters ''
     *
     * @return string $arrRes
     *
     * User instruction: $objDashboard->RecentEnquiry() 
     */
    function RecentEnquiry() {
        $varTable = TABLE_ENQUIRY;
        $arrClms = array('pkEnquiryID', 'fkParentID', 'EnquirySenderName', 'EnquirySenderEmail', 'EnquirySenderMobile', 'EnquirySubject', 'EnquiryComment', 'EnquiryDateAdded');
        $varWhere = "fkParentID = 0";
        $varOrderBy = " EnquiryDateAdded DESC ";
        $varLimit = " 0,5 ";

        $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy, $varLimit);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function lastLogin
     *
     * This function is used to display the last Login details.
     *
     * Database Tables used in this function are : tbl_admin, tbl_admin_lastlogin
     *
     * @access public
     *
     * @parameters ''
     *
     * @return string $arrRes
     *
     * User instruction: $objDashboard->lastLogin()
     */
    function lastLogin() {
        $varTable = TABLE_ADMIN . " AS a LEFT JOIN " . TABLE_ADMIN_LASTLOGIN . " AS al ON a.pkAdminID=al.FkAdminID";
        $arrClms = array('a.AdminType', 'a.AdminUserName', 'al.AdminLastLogin', 'al.AdminLastLoginIPAddress');
        $varWhere = "a.pkAdminID = '" . $_SESSION['sessUser'] . "'";
        $varOrderBy = " al.AdminLastLogin DESC ";
        $varLimit = " 1,3 ";

        $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy, $varLimit);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function recentWholesalerApplication
     *
     * This function is used to display the recent Wholesaler Application.
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_country
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objDashboard->lastLogin()
     */
    function recentWholesalerApplication($argWhr = '') {

        $varTable = TABLE_WHOLESALER . " LEFT JOIN " . TABLE_COUNTRY . " ON CompanyCountry = country_id";
        $arrClms = array('pkWholesalerID', 'CompanyName', 'CompanyEmail', 'CompanyPhone', 'name as CountryName', 'WholesalerDateAdded');
        $varWhere = " WholesalerStatus = 'pending' " . $argWhr;
        $varOrderBy = " WholesalerDateAdded DESC ";
        $varLimit = " 0,5 ";

        $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy, $varLimit);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function recentlyOrderedItem
     *
     * This function is used to display the recently Ordered Item.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_order, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objDashboard->recentlyOrderedItem($argWhr) 
     */
    function recentlyOrderedItem($argWhr) {

        $varWhere = " WHERE 1 " . $argWhr;
        $varLimit = " LIMIT 0,5";
        $varQuery = "SELECT oi.fkOrderID, oi.SubOrderID,ItemType, group_concat(oi.ItemName) as Items,CompanyName,concat(o.CustomerFirstName,' ',o.CustomerLastName) as CustomerName,o.CustomerEmail,o.OrderDateAdded,sum(oi.ItemTotalPrice) as ItemTotal,oi.Status FROM " . TABLE_ORDER_ITEMS . " as oi LEFT JOIN " . TABLE_ORDER . " as o ON oi.fkOrderID = o.pkOrderID LEFT JOIN " . TABLE_WHOLESALER . " ON oi.fkWholesalerID=pkWholesalerID" . $varWhere . " Group BY oi.SubOrderID order by oi.pkOrderItemID DESC " . $varLimit;

        $arrRes = $this->getArrayResult($varQuery);
        // pre($arrRes);
        return $arrRes;
    }

    /**
     * function recentSupportEnquiry
     *
     * This function is used to display the recent Support Enquiry.
     *
     * Database Tables used in this function are : tbl_support, tbl_customer, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objDashboard->recentSupportEnquiry($argwhr = "")
     */
    function recentSupportEnquiry($argwhr = "") {

        $varwhr = "((FromUserType='wholesaler' " . $argwhr . ") OR (FromUserType='customer')) AND ToUserType='admin'";

        $varTable = TABLE_SUPPORT . " LEFT JOIN " . TABLE_CUSTOMER . " ON fkFromUserID = pkCustomerID LEFT JOIN " . TABLE_WHOLESALER . " ON fkFromUserID = pkWholesalerID";
        $varClms = "pkSupportID,FromUserType,fkFromUserID,CONCAT(CustomerFirstName,' ',CustomerLastName) customerName,CustomerEmail as customerEmail,BillingPhone as customerPhone,CompanyName as wholesalerName,CompanyEmail as wholesalerEmail,CompanyPhone as wholesalerPhone,SupportDateAdded";
        $varWhere = " WHERE " . $varwhr;
        $varOrderBy = " ORDER BY SupportDateAdded DESC ";
        $varLimit = " LIMIT 0,10 ";
        $varSql = "SELECT " . $varClms . " FROM " . $varTable . $varWhere . $varOrderBy . $varLimit;
        $arrRes = $this->getArrayResult($varSql);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function recentWholesalerSupport
     *
     * This function is used to display the recent Wholesaler Support.
     *
     * Database Tables used in this function are :  tbl_support, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objDashboard->recentWholesalerSupport($argwhr = "")
     */
    function recentWholesalerSupport($argwhr = "") {

        $varwhr = "((FromUserType='wholesaler' AND ToUserType='admin') OR (FromUserType='admin' AND ToUserType='wholesaler')) " . $argwhr;

        $varTable = TABLE_SUPPORT . " LEFT JOIN " . TABLE_WHOLESALER . " ON (fkFromUserID = pkWholesalerID OR fkToUserID = pkWholesalerID)";
        $varClms = "pkSupportID,FromUserType,fkFromUserID,Subject,CompanyName as wholesalerName,CompanyEmail as wholesalerEmail,CompanyPhone as wholesalerPhone,SupportDateAdded";
        $varWhere = " WHERE " . $varwhr;
        $varOrderBy = " ORDER BY SupportDateAdded DESC ";
        $varLimit = " LIMIT 0,5 ";
        $varSql = "SELECT " . $varClms . " FROM " . $varTable . $varWhere . $varOrderBy . $varLimit;
        $arrRes = $this->getArrayResult($varSql);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function recentCustomerSupport
     *
     * This function is used to display the recent Customer Support.
     *
     * Database Tables used in this function are :  tbl_support, tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objDashboard->recentCustomerSupport($argwhr = "")
     */
    function recentCustomerSupport($argwhr = "") {

        $varwhr = "((FromUserType='customer' AND ToUserType='admin') OR (FromUserType='admin' AND ToUserType='customer')) " . $argwhr;

        $varTable = TABLE_SUPPORT . " LEFT JOIN " . TABLE_CUSTOMER . " ON (fkFromUserID = pkCustomerID OR fkToUserID = pkCustomerID)";
        $varClms = "pkSupportID,FromUserType,fkFromUserID,Subject,CONCAT(CustomerFirstName,' ',CustomerLastName) customerName,CustomerEmail as customerEmail,BillingPhone as customerPhone,SupportDateAdded";
        $varWhere = " WHERE " . $varwhr;
        $varOrderBy = " ORDER BY SupportDateAdded DESC ";
        $varLimit = " LIMIT 0,5 ";
        $varSql = "SELECT " . $varClms . " FROM " . $varTable . $varWhere . $varOrderBy . $varLimit;
        $arrRes = $this->getArrayResult($varSql);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function recentProductReview
     *
     * This function is used to display the recent Product Review.
     *
     * Database Tables used in this function are :  tbl_review, tbl_customer, tbl_product, tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objDashboard->recentProductReview($argwhr = "")
     */
    function recentProductReview($argwhr = "") {

        $limit = "0,5";
        $varWhere = "1 " . $argwhr . "";
        $varOrderBy = 'pkReviewID DESC';
        $varArrayColoum = array('pkReviewID', 'fkCustomerID', 'fkProductID', 'Reviews', 'ApprovedStatus', 'ReviewDateAdded', 'pkCustomerID', 'concat(CustomerFirstName," ",CustomerLastName) as csName', 'pkProductID', 'ProductName', 'pkCategoryId', 'CategoryName');


        $varTable = TABLE_REVIEW . ' AS TR LEFT JOIN ' . TABLE_CUSTOMER . ' AS TC  ON TR.fkCustomerID=TC.pkCustomerID LEFT JOIN ' . TABLE_PRODUCT . ' AS TP ON TR.fkProductID=TP.pkProductID LEFT JOIN ' . TABLE_CATEGORY . ' as TCAT ON TP.fkCategoryID=TCAT.pkCategoryId';

        $arrRes = $this->select($varTable, $varArrayColoum, $varWhere, $varOrderBy, $limit);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function customerFeedbackCount
     *
     * This function is used to display the customer Feedback Count.
     *
     * Database Tables used in this function are :  tbl_wholesaler_feedback
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objDashboard->customerFeedbackCount($argwhr = "")
     */
    function customerFeedbackCount($argwhr = "") {

        $varQuery = "select (select count(pkFeedbackID) from " . TABLE_WHOLESALER_FEEDBACK . " where IsPositive = '1' " . $argwhr . ") as good, (select count(pkFeedbackID) from " . TABLE_WHOLESALER_FEEDBACK . " where IsPositive='0' " . $argwhr . ") as bad";
        $arrRes = $this->getArrayResult($varQuery);

        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function wholesalerFeedbackKpiList
     *
     * This function is used to display the recent wholesaler Feedback Kpi List.
     *
     * Database Tables used in this function are :  tbl_wholesaler_feedback, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objDashboard->wholesalerFeedbackKpiList($argwhr = "")
     */
    function wholesalerFeedbackKpiList($argwhr = "") {
        global $objGeneral;
        $varQuery = "select pkFeedbackID,fkWholesalerID,CompanyName,IsPositive,FeedbackDateAdded from " . TABLE_WHOLESALER_FEEDBACK . " INNER JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID  WHERE 1 " . $argwhr . " GROUP BY fkWholesalerID ORDER BY pkFeedbackID desc LIMIT 0,5";
        $arrRes = $this->getArrayResult($varQuery);

        foreach ($arrRes as $key => $val) {
            $varkpi = $objGeneral->wholesalerKpi($val['fkWholesalerID']);
            $arrRes[$key]['kpi'] = $varkpi['kpi'];
        }

        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function salesTotal
     *
     * This function is used to display visitors, advertisement revenue and sales revenue.
     *
     * Database Tables used in this function are :  tbl_order_total, tbl_visitor
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objDashboard->salesTotal($argwhr = "")
     */
    function salesTotal($argwhr = "") {
        global $objGeneral;
        global $objCore;

        $curDate = $objCore->serverdateTime(date(DATE_FORMAT_DB), DATE_FORMAT_DB);
        $curMonth = date('Y-m', strtotime($curDate));
        $prevDate = date('Y-m-d', strtotime($curDate . " -1 month"));
        $prevMonth = date('Y-m', strtotime($curDate . " -1 month"));


        $varQuery = "select (select count(pkVisitorID) from " . TABLE_VISITOR . "  WHERE DATE_FORMAT(Visitor_Date_Added,'%Y-%m')='" . $curMonth . "') as curMonth, (select count(pkVisitorID) from " . TABLE_VISITOR . " WHERE DATE_FORMAT(Visitor_Date_Added,'%Y-%m')='" . $prevMonth . "') as prevMonth ";
        $arrRes = $this->getArrayResult($varQuery);
        $arrRows['Visitor']['curMonth'] = (int) $arrRes[0]['curMonth'];
        $arrRows['Visitor']['prevMonth'] = (int) $arrRes[0]['prevMonth'];

        $varQuery = "select (select sum(AdsPrice*(DATEDIFF(LEAST(AdsEndDate, LAST_DAY('" . $curDate . "')),GREATEST(AdsStartDate, '" . $curMonth . "-01'))+1)) from " . TABLE_ADVERTISEMENT . "  WHERE DATE_FORMAT(AdsStartDate,'%Y-%m')<='" . $curMonth . "' AND DATE_FORMAT(AdsEndDate,'%Y-%m')>='" . $curMonth . "') as curMonth, (select sum(AdsPrice*(DATEDIFF(LEAST(AdsEndDate, LAST_DAY('" . $prevDate . "')),GREATEST(AdsStartDate, '" . $prevMonth . "-01'))+1)) from " . TABLE_ADVERTISEMENT . "  WHERE DATE_FORMAT(AdsStartDate,'%Y-%m')<='" . $prevMonth . "' AND DATE_FORMAT(AdsEndDate,'%Y-%m')>='" . $prevMonth . "') as prevMonth ";
        $arrRes = $this->getArrayResult($varQuery);
        $arrRows['Ads']['curMonth'] = (float) $arrRes[0]['curMonth'];
        $arrRows['Ads']['prevMonth'] = (float) $arrRes[0]['prevMonth'];

        $varQuery = "select (select sum(ItemTotalPrice) from " . TABLE_ORDER_ITEMS . "  WHERE Status IN ('Completed','Pending','Posted') AND  DATE_FORMAT(ItemDateAdded,'%Y-%m')='" . $curMonth . "') as curMonthAmount, (select sum(ItemTotalPrice) from " . TABLE_ORDER_ITEMS . "  WHERE Status IN ('Completed','Pending','Posted') AND  DATE_FORMAT(ItemDateAdded,'%Y-%m')='" . $prevMonth . "') as prevMonthAmount ";
        $arrRes = $this->getArrayResult($varQuery);
        $arrRows['Sales']['curMonthAmount'] = (float) $arrRes[0]['curMonthAmount'];
        $arrRows['Sales']['prevMonthAmount'] = (float) $arrRes[0]['prevMonthAmount'];
        //pre($arrRows);
        return $arrRows;
    }

    /**
     * function recentlyAddedWholesaler
     *
     * This function is used to display the recently Add Wholesaler.
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_country
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objDashboard->recentlyAddedWholesaler($argwhr = '')
     */
    function recentlyAddedWholesaler($argwhr = '') {
        $varTable = TABLE_WHOLESALER . " LEFT JOIN " . TABLE_COUNTRY . " ON CompanyCountry = country_id";
        $arrClms = array('pkWholesalerID', 'CompanyName', 'CompanyEmail', 'CompanyPhone', 'name as CountryName', 'WholesalerDateAdded', 'WholesalerStatus');
        $varWhere = " WholesalerStatus = 'active' " . $argwhr;
        $varOrderBy = " WholesalerDateAdded DESC ";
        $varLimit = " 0,10 ";

        $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBy, $varLimit);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getFestivalEvents
     *
     * This function is used to display the Festival Events.
     *
     * Database Tables used in this function are :  tbl_festival
     *
     * @access public
     *
     * @parameters ''
     *
     * @return string $arrRes
     *
     * User instruction: $objDashboard->RecentEnquiry() 
     */
    function getFestivalEvents($varWhere = '') {

        $varTable = TABLE_FESTIVAL;
        $arrClms = array('pkFestivalID as id', 'FestivalTitle as title', 'DATE_FORMAT(FestivalStartDate, "%Y-%m-%d") as start', 'DATE_FORMAT(FestivalEndDate,"%Y-%m-%d") as end');
        $varWhere = "FestivalStatus ='1'";
        $arrRes = $this->select($varTable, $arrClms, $varWhere);
        //pre($arrRes);
        return $arrRes;
    }

}

?>
