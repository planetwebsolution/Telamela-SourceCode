<?php

/**
 *
 * Class name : Order
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Avinesh mathur
 *
 * Comments : The Order class is used to maintain Order infomation details for several modules.
 */
class Order extends Database {

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
     * function orderList
     *
     * This function is used to display the order List.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_order, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objOrder->orderList($argWhere = '', $argLimit = '')
     */
    function orderList($argWhere = '', $argLimit = '') {
        
        $varWhere = " WHERE 1 " . $argWhere;

        if ($argLimit) {
            $varLimit = " LIMIT " . $argLimit;
        }

        $varQuery = "SELECT oi.fkOrderID,oi.fkShippingIDs, oi.ShippingPrice,o.ShippingCountry,oi.pkOrderItemID,oi.transaction_ID, oi.SubOrderID, group_concat(oi.ItemName) as Items,concat(o.CustomerFirstName,' 
                ',o.CustomerLastName) as CustomerName,o.OrderDateAdded,sum(oi.ItemTotalPrice) as ItemTotal,oi.Status,oi.DisputedStatus FROM " 
        . TABLE_ORDER_ITEMS . " as oi LEFT JOIN " . TABLE_ORDER . " as o ON oi.fkOrderID = o.pkOrderID LEFT JOIN " . 
        TABLE_WHOLESALER . " as w on w.pkWholesalerID = oi.fkWholesalerID " . $varWhere . " 
                Group BY oi.SubOrderID order by oi.pkOrderItemID DESC " . $varLimit;
        //echo $varQuery; die;
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }
    
    
    
    /**
     * function disputedOrderList
     *
     * This function is used to display the disputed order List.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_order, tbl_order_disputed_comments, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objOrder->disputedOrderList($argWhere = '', $argLimit = '')
     * 
     * @author : Krishna Gupta
     * 
     * @created : 15-10-2015
     * 
     * @Last Modified : 19-10-2015
     */
    function disputedOrderList($argWhere = '', $argLimit = '') {
        
        if ($argLimit) {
            $varLimit = " LIMIT 0" . $argLimit;
        }
        define('TABLE_ORDER_DISPUTED_COMMENT', 'tbl_order_disputed_comments');
            
        $varWhere = " WHERE disputed.fkSubOrderID =  oi.SubOrderID " . $argWhere;
            
        $varQuery = "SELECT oi.fkOrderID, oi.SubOrderID, oi.ItemDateAdded, oi.ItemName as Items, disputed.fkSubOrderID,
                    concat(o.CustomerFirstName,' ',o.CustomerLastName) as CustomerName,
                    o.OrderDateAdded, sum(oi.ItemTotalPrice) as ItemTotal, w.pkWholesalerID,
                    oi.Status, oi.DisputedStatus FROM " . TABLE_ORDER_ITEMS . " as oi
                    LEFT JOIN " . TABLE_ORDER . " as o ON oi.fkOrderID = o.pkOrderID
                    LEFT JOIN " . TABLE_ORDER_DISPUTED_COMMENT . " as disputed ON oi.fkOrderID = disputed.fkOrderID
                    LEFT JOIN " . TABLE_WHOLESALER . " as w
                    on w.pkWholesalerID = oi.fkWholesalerID " . $varWhere . "
                    Group BY disputed.fkSubOrderID order by CommentDateAdded DESC " . $varLimit;
        //echo $varQuery; die;
        $arrRes = $this->getArrayResult($varQuery);
        
        return $arrRes;
    }
    
    
    
    /**
     * function CountryList
     *
     * This function is used to display the Country List.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters ''
     *
     * @return $arrRes
     *
     * User instruction: $objOrder->CountryList()
     */
    function CountryList() {
        $arrRes = $this->getArrayResult("SELECT country_id,name FROM " . TABLE_COUNTRY . " Order By name ASC");
        return $arrRes;
    }

    /**
     * function WholesalerList
     *
     * This function is used to display the Wholesaler List.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return arrRes
     *
     * User instruction: $objOrder->WholesalerList($argWhr)
     */
    function WholesalerList($argWhr) {
        $arrClms = array(
            'pkWholesalerID',
            'CompanyName',
        );
        $argWhere = "WholesalerStatus = 'active' " . $argWhr;
        $varOrderBy = ' CompanyName ASC ';

        $varTable = TABLE_WHOLESALER . " as w";
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function snipatCareer
     *
     * This function is used to display the snipat Career List.
     *
     * Database Tables used in this function are : tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters ''
     *
     * @return $arrRes
     *
     * User instruction: $objOrder->snipatCareer()
     */
    function snipatCareer() {

        $var = array('pkShippingGatewaysID', 'ShippingTitle');
        //$varTable = TABLE_SHIPPING_GATEWAYS;
        $varTable = TABLE_SHIP_GATEWAYS;
        $arrRes = $this->select($varTable, $var, '1');
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function editOrder
     *
     * This function is used to edit the order.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_shipping_gateways, tbl_order_option, tbl_order, tbl_country, tbl_order_comments, tbl_customer, tbl_wholesaler, tbl_admin, tbl_order_total
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrData
     *
     * User instruction: $objOrder->editOrder($argID, $varPortalFilter = '')
     */
    function editOrder($argID, $varPortalFilter = '') {
        //pre("herezczxc");

        $varID = "SubOrderID ='" . $argID . "' " . $varPortalFilter;
        

        $arrClms = array('pkOrderItemID', 'fkOrderID', 'transaction_ID', 'SubOrderID', 'ItemType', 'fkItemID', 'ItemName', 'ItemImage', 'fkWholesalerID', 'ShippingTitle', 'fkShippingIDs', 'ItemPrice', 'Quantity', 'ItemSubTotal', 'AttributePrice', 'ShippingPrice', 'DiscountPrice', 'ItemTotalPrice', 'ItemDetails', 'DisputedStatus','SingleDeductionValue','Status','Weight','WeightUnit','DimensionUnit','Height','Width','Length');
        //$varTbl = TABLE_ORDER_ITEMS . " LEFT JOIN " . TABLE_WHOLESALER . " as w ON w.pkWholesalerID = fkWholesalerID ";
        $varTbl = TABLE_ORDER_ITEMS . ' as c LEFT JOIN ' . TABLE_SHIP_GATEWAYS . " ON c.fkShippingIDs=pkShippingGatewaysID";
        $arrData['arrOrderItems'] = $this->select($varTbl, $arrClms, $varID);
        
        $arrClmswholesaler = array('CompanyName', 'CompanyAddress1', 'CompanyAddress2', 'CompanyCity', 'CompanyCountry', 'CompanyRegion', 'CompanyPostalCode','CompanyPhone');
        $wholesalercondition = "pkWholesalerID ='" . $arrData['arrOrderItems'][0]['fkWholesalerID'] . "' " ;
        $arrData['wholesaler'] = $this->select(TABLE_WHOLESALER, $arrClmswholesaler, $wholesalercondition);
        //pre($arrData['wholesaler']);
        foreach ($arrData['arrOrderItems'] as $k => $v) {

            if ($v['ItemType'] <> 'gift-card') {
                $jsonDet = json_decode(html_entity_decode($v['ItemDetails']));
                $varDet = '';
                foreach ($jsonDet as $jk => $jv) {
                    $varDet .= $jv->ProductName;
                    $arrCols = array('AttributeLabel', 'OptionValue');
                    $argWhr = " fkOrderItemID = '" . $v['pkOrderItemID'] . "' AND fkProductID = '" . $jv->pkProductID . "'";
                    $arrOpt = $this->select(TABLE_ORDER_OPTION, $arrCols, $argWhr);
                    $num = count($arrOpt);
                    if ($num > 0) {
                        $varDet .= ' (';
                        $i = 1;
                        foreach ($arrOpt as $ok => $ov) {

                            $varDet .= $ov['AttributeLabel'] . ': ' . str_replace('@@@', ',', $ov['OptionValue']);
                            if ($i < $num)
                                $varDet .=' | ';
                            $i++;
                        }

                        $varDet .= ')';
                        $varDet .= '<br />';
                    } else {
                        $varDet = '';
                    }
                }
            } else {
                $varDet = 'Gift Card';
            }
            $arrData['arrOrderItems'][$k]['OptionDet'] = $varDet;
            $arrData['arrOrderItems'][$k]['Shipments'] = $this->getShipmentDetails($v['pkOrderItemID']);
        }

        $varID = "pkOrderID ='" . $arrData['arrOrderItems'][0]['fkOrderID'] . "'";

        $arrClms = array(
            'pkOrderID',
            'TransactionID',
            'fkCustomerID',
            'CustomerFirstName',
            'CustomerLastName',
            'CustomerEmail',
            'CustomerPhone',
            'BillingFirstName',
            'BillingFirstName',
            'BillingLastName',
            'BillingOrganizationName',
            'BillingAddressLine1',
            'BillingAddressLine2',
            'BillingCountry',
            'c1.name as BillingCountryName',
            'BillingPostalCode',
            'BillingPhone',
            'ShippingFirstName',
            'ShippingLastName',
            'ShippingOrganizationName',
            'ShippingAddressLine1',
            'ShippingAddressLine2',
            'ShippingCountry',
            'c2.name as ShippingCountryName',
            'ShippingPostalCode',
            'ShippingPhone',
            'OrderStatus',
            'OrderDateAdded'
        );
        $varTable = TABLE_ORDER . " LEFT JOIN " . TABLE_COUNTRY . " as c1 ON BillingCountry =c1.country_id LEFT JOIN " . TABLE_COUNTRY . " as c2 ON ShippingCountry =c2.country_id";

        $arrData['arrOrder'] = $this->select($varTable, $arrClms, $varID);


        $varID = "fkOrderID ='" . $arrData['arrOrderItems'][0]['fkOrderID'] . "' ";
        $arrClms = array('pkOrderCommentID', 'CommentedBy', 'CommentedID', 'Comment', 'CommentDateAdded', 'AdminUserName as adminName', 'CompanyName as wholesalerName', 'CustomerFirstName as customerName');
        $varOrder = " pkOrderCommentID ASC";
        $varTable = TABLE_ORDER_COMMENTS . " LEFT JOIN " . TABLE_CUSTOMER . " ON CommentedID = pkCustomerID LEFT JOIN " . TABLE_WHOLESALER . " ON CommentedID = pkWholesalerID LEFT JOIN " . TABLE_ADMIN . " ON CommentedID=pkAdminID";
        $arrData['arrOrderComments'] = $this->select($varTable, $arrClms, $varID, $varOrder);


        $arrClms = array('pkOrderTotalID', 'Code', 'Title', 'Amount');
        $varOrder = " SortOrder ASC";
        $arrData['arrOrderTotal'] = $this->select(TABLE_ORDER_TOTAL, $arrClms, $varID, $varOrder);
        $arrData['arrDisputedCommentsHistory'] = $this->disputedCommentsHistory($argID);
        $arrData['arrCountryList'] = $this->CountryList();

       
        return $arrData;
    }

    /**
     * function disputedCommentsHistory
     *
     * This function is used to insert disputed comments.
     *
     * Database Tables used in this function are : tbl_order_disputed_comments, tbl_customer, tbl_wholesaler, tbl_admin
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return null
     */
    function disputedCommentsHistory($soid) {
        global $objCore;
        $arrClms = array(
            'pkDisputedID',
            'fkOrderID',
            'fkSubOrderID',
            'CommentedBy',
            'CommentedID',
            'CustomerFirstName as customer',
            'CompanyName wholesaler',
            'AdminTitle admin',
            'CommentOn',
            'CommentDesc',
            'AdditionalComments',
            'CommentDateAdded'
        );
        $varWhr = " fkSubOrderID ='" . $soid . "' ";
        $varOrd = " CommentDateAdded ASC ";
        $varTable = TABLE_ORDER_DISPUTED_COMMENTS . " LEFT JOIN " . TABLE_CUSTOMER . " ON CommentedID = pkCustomerID LEFT JOIN " . TABLE_WHOLESALER . " ON CommentedID=pkWholesalerID LEFT JOIN " . TABLE_ADMIN . " ON CommentedID=pkAdminID";
        $arrRes = $this->select($varTable, $arrClms, $varWhr, $varOrd);

        return $arrRes;
    }

    /**
     * function disputeFeedback
     *
     * This function is used to update order status as disputed.
     *
     * Database Tables used in this function are : tbl_order, tbl_order_disputed_comments
     *
     * @access public
     *
     * @parameters 2 string,string
     *
     * @return string $string
     */
    function disputeFeedback($arrPost, $id) {
        global $objGeneral;
        global $objCore;

        $oid = $arrPost['oid'];
        $soid = $arrPost['soid'];
        $arrClms = array('pkOrderID', 'fkCustomerID', 'TransactionID', 'CustomerFirstName', 'CustomerLastName', 'CustomerEmail', 'CustomerPhone');

        $argWhere = "pkOrderID='" . $oid . "' ";
        $arrOrder = $this->select(TABLE_ORDER, $arrClms, $argWhere);

        if (count($arrOrder) > 0) {

            $arrClms = array(
                'fkOrderID' => $arrPost['oid'],
                'fkSubOrderID' => $arrPost['soid'],
                'CommentedBy' => 'admin',
                'CommentedID' => $id,
                'CommentOn' => 'Feedback',
                'AdditionalComments' => $arrPost['frmFeedback'],
                'CommentDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );

            $arrRow = $this->insert(TABLE_ORDER_DISPUTED_COMMENTS, $arrClms);

            $arrOrder[0]['SubOrderId'] = $soid;
            $arrOrder[0]['EmailSubject'] = "" . ORDER_DISPUTED_FEEDBACK_BY_COUNTRY_PORTAL . '<br/>' . ORDER_DETAILS_TITLE;
            $objGeneral->sendDisputedEmail($arrOrder[0], 1);
        }
    }

    /**
     * function getShipmentDetails
     *
     * This function is used display get Shipment details.
     *
     * Database Tables used in this function are : tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     */
    function getShipmentDetails($oItemID) {
        $arrClms = array('pkShipmentID', 'fkShippingCarrierID', 'ShippingType', 'ShippingAlias', 'ShippingTitle', 'TransactionNo', 's.ShippingStatus', 'OrderDate', 'ShippedDate', 'DateAdded');
        $varTable = TABLE_SHIPMENT . " as s LEFT JOIN " . TABLE_SHIP_GATEWAYS . " as sg ON fkShippingCarrierID = sg.pkShippingGatewaysID";
        $varID = "fkOrderItemID = '" . $oItemID . "'";
        $arrRes = $this->select($varTable, $arrClms, $varID);
//pre($arrRes);
        return $arrRes[0];
    }

    /**
     * function updateOrder
     *
     * This function is used to update the order.
     *
     * Database Tables used in this function are : tbl_order, tbl_order_comments, tbl_order_items, tbl_order_option, tbl_order_total
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return 1
     *
     * User instruction: $objOrder->updateOrder($arrPost)
     */
    function updateOrder($arrPost) {

        $varSubOrderID = $_GET['soid'];
        $varOrderID = $arrPost['oid'];


        $varWhr = "pkOrderID = '" . $varOrderID . "'";

        $arrClms = array(
            'CustomerFirstName' => $arrPost['CustomerFirstName'],
            'CustomerLastName' => $arrPost['CustomerLastName'],
            'CustomerEmail' => $arrPost['CustomerEmail'],
            'CustomerPhone' => $arrPost['CustomerPhone'],
            'BillingFirstName' => $arrPost['BillingFirstName'],
            'BillingLastName' => $arrPost['BillingLastName'],
            'BillingOrganizationName' => $arrPost['BillingOrganizationName'],
            'BillingAddressLine1' => $arrPost['BillingAddressLine1'],
            'BillingAddressLine2' => $arrPost['BillingAddressLine2'],
            'BillingCountry' => $arrPost['BillingCountry'],
            'BillingPostalCode' => $arrPost['BillingPostalCode'],
            'BillingPhone' => $arrPost['BillingPhone'],
            'ShippingFirstName' => ($arrPost['ShippingFirstName']),
            'ShippingLastName' => $arrPost['ShippingLastName'],
            'ShippingOrganizationName' => $arrPost['ShippingOrganizationName'],
            'ShippingAddressLine1' => $arrPost['ShippingAddressLine1'],
            'ShippingAddressLine2' => $arrPost['ShippingAddressLine2'],
            'ShippingCountry' => $arrPost['ShippingCountry'],
            'ShippingPostalCode' => $arrPost['ShippingPostalCode'],
            'ShippingPhone' => $arrPost['ShippingPhone'],
            'OrderDateUpdated' => date(DATE_TIME_FORMAT_DB)
        );


        $arrUpdateID = $this->update(TABLE_ORDER, $arrClms, $varWhr);
        if ($arrPost['frmComment']) {
            $arrClmsComment = array(
                'fkOrderID' => $varOrderID,
                'fkSubOrderID' => $varSubOrderID,
                'CommentedBy' => 'admin',
                'CommentedID' => $_SESSION['sessUser'],
                'Comment' => $arrPost['frmComment'],
                'CommentDateAdded' => date(DATE_TIME_FORMAT_DB)
            );
            $this->insert(TABLE_ORDER_COMMENTS, $arrClmsComment);
        }
        foreach ($arrPost['frmIsRemoved'] as $k => $v) {
            if ($v == 1) {
                $varWhre = "pkOrderItemID= '" . $k . "'";
                $this->delete(TABLE_ORDER_ITEMS, $varWhre);
                $varWhre = "fkOrderItemID= '" . $k . "'";
                $this->delete(TABLE_ORDER_OPTION, $varWhre);
            }
        }


        $arrTotal = $this->orderTotal($varOrderID);



        // for Sub total, shipping and coupon
        foreach ($arrTotal as $k => $v) {
            $varTotalWhr = "fkOrderID='" . $varOrderID . "' AND Code = '" . $k . "' ";
            if ($k == 'coupon') {
                $v = '-' . $v;
            }
            $arrSubtotalCols = array('Amount' => $v);
            $this->update(TABLE_ORDER_TOTAL, $arrSubtotalCols, $varTotalWhr);
        }

        // for Redeem Gift card
        //$varGrantTotalPrice -= $varGiftCartPrice;
        //$arrGiftCartCols = array('fkOrderID'=>$varOrderID,'Code'=>'gift-card','Title'=>'Gift Card(code)','Amount'=>$varGiftCartPrice,'SortOrder'=>4);
       

        $varGrantTotalPrice = $arrTotal['sub-total'] + $arrTotal['shipping'] + $arrTotal['coupon'] + $arrTotal['reward-points'] + $arrTotal['gift-card'];
        $varTotalWhr = "fkOrderID='" . $varOrderID . "' AND Code = 'total' ";
        $arrTotalCols = array('Amount' => $varGrantTotalPrice);
        $this->update(TABLE_ORDER_TOTAL, $arrTotalCols, $varTotalWhr);

        $this->orderEmailNotification($varOrderID);
        return 1;
    }

    /**
     * function GetOrderDetails
     *
     * This function is used to get the order details.
     *
     * Database Tables used in this function are : tbl_order
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objOrder->GetOrderDetails($argOrderID)
     */
    function GetOrderDetails($argOrderID) {
        $arrClms = array('pkOrderID', 'TransactionID', 'CustomerFirstName', 'CustomerLastName', 'CustomerEmail', 'CustomerPhone');
        $argWhere = "pkOrderID='" . $argOrderID . "' ";
        $arrRes = $this->select(TABLE_ORDER, $arrClms, $argWhere);
        //  pre($arrRes);
        return $arrRes;
    }

    /**
     * function GetItemDetails
     *
     * This function is used to get the Item details.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_order_option
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objOrder->GetItemDetails($argWhere)
     */
    function GetItemDetails($argWhere) {
        $arrClms = array('pkOrderItemID', 'ItemType', 'ItemName', 'Quantity', 'ItemDetails', 'ItemTotalPrice');
        $arrRes = $this->select(TABLE_ORDER_ITEMS, $arrClms, $argWhere);

        foreach ($arrRes as $k => $v) {
            if ($v['ItemType'] <> 'gift-card') {
                $jsonDet = json_decode(html_entity_decode($v['ItemDetails']));
                $varDet = '';
                foreach ($jsonDet as $jk => $jv) {

                    $varDet .= $jv->ProductName;
                    $arrCols = array('AttributeLabel', 'OptionValue');
                    $argWhr = " fkOrderItemID = '" . $v['pkOrderItemID'] . "' AND fkProductID = '" . $jv->pkProductID . "'";
                    $arrOpt = $this->select(TABLE_ORDER_OPTION, $arrCols, $argWhr);
                    if ($arrOpt) {
                        $varDet .= ' (';
                        foreach ($arrOpt as $ok => $ov) {
                            $varDet .= $ov['AttributeLabel'] . ' # ' . str_replace('@@@', ',', $ov['OptionValue']) . ' ,';
                        }

                        $varDet .= ')';
                    }
                    $varDet .= '<br />';
                }
                $arrRes[$k]['OptionDet'] = $varDet;
            }
        }


        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function GetTotalDetails
     *
     * This function is used to get the Total details.
     *
     * Database Tables used in this function are : tbl_order_total
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objOrder->GetTotalDetails($argWhere)
     */
    function GetTotalDetails($argWhere) {
        $arrClms = array('Code', 'Title', 'Amount');
        $varOrder = " SortOrder ASC";
        $arrRes = $this->select(TABLE_ORDER_TOTAL, $arrClms, $argWhere, $varOrder);
        // pre($arrRes);
        return $arrRes;
    }

    /**
     * function orderEmailNotification
     *
     * This function is used to get the order Email Notifications.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objOrder->orderEmailNotification($varOrderID)
     */
    function orderEmailNotification($varOrderID) {
        $arrOrderDetail = $this->GetOrderDetails($varOrderID);

        $this->SentEmailToCustomer($arrOrderDetail[0]);
        $this->SentEmailToWholesaler($arrOrderDetail[0]);
        $this->SentEmailToCountryPortal($arrOrderDetail[0]);
        $this->SentEmailToSuperAdmin($arrOrderDetail[0]);
    }

    /**
     * function GetWholesalerDetails
     *
     * This function is used to get Wholesaler Details .
     *
     * Database Tables used in this function are : tbl_order_items, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objOrder->GetWholesalerDetails($argOrderID)
     */
    function GetWholesalerDetails($argOrderID) {
        $query = "SELECT fkWholesalerID,CompanyName, CompanyEmail,CompanyCountry,CompanyRegion FROM " . TABLE_ORDER_ITEMS . " INNER JOIN  " . TABLE_WHOLESALER . " ON fkWholesalerID=pkWholesalerID WHERE fkOrderID = '" . $argOrderID . "' GROUP BY fkWholesalerID";
        $arrRes = $this->getArrayResult($query);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function adminList
     *
     * This function is used to get admin List .
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objOrder->adminList($argWhr)
     */
    function adminList($argWhr) {
        $arrClms = array(
            'pkAdminID',
            'AdminType',
            'AdminUserName',
            'AdminEmail',
            'AdminCountry',
            'AdminRegion'
        );

        $varOrderBy = 'AdminUserName ASC ';
        $arrRes = $this->select(TABLE_ADMIN, $arrClms, $argWhr);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function SentEmailToCustomer
     *
     * This function is used to Sent Email To Customer .
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objOrder->SentEmailToCustomer($arrOrderDetail)
     */
    function SentEmailToCustomer($arrOrderDetail) {
        global $objCore;

        $varWhr = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' ";
        $arrOrderItems = $this->GetItemDetails($varWhr);

        $varWhr = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' AND Code='total' ";
        $arrOrderItemTotal = $this->GetTotalDetails($varWhr);

        $varEmailOrderDetails = '<table width="700" cellspacing="0" cellpadding="5" border="0"><tr><td>Your Order details Updated By Admin: </p></td></tr></table>';
        $varEmailOrderDetails .= '<table width="100%" bgcolor="#F0EBE2"  border="1" cellpadding="8" cellspacing="0">';
        $varEmailOrderDetails .= '<tr><th>Order ID</th><td>&nbsp;&nbsp;' . $arrOrderDetail['pkOrderID'] . '</td><th>Transaction&nbsp;ID</th><td>&nbsp;&nbsp;' . $arrOrderDetail['TransactionID'] . '</td></tr>';
        $varEmailOrderDetails .= '<tr><td colspan="4">&nbsp;</td></tr>';

        $varEmailOrderDetails .= '<tr><th>Item Type</th><th>Items</th><th>Quantity</th><th>Price</th></tr>';

        foreach ($arrOrderItems as $k => $v) {
            $varEmailOrderDetails .= '<tr><td align="center">' . $v['ItemType'] . '</td><td align="center"><b>' . $v['ItemName'] . '</b><br />' . $v['OptionDet'] . '</td><td align="center">' . $v['Quantity'] . '</td><td align="center">$ ' . number_format($v['ItemTotalPrice'], 2, '.', ',') . '</td></tr>';
        }

        $varEmailOrderDetails .= '<tr bgcolor="#ccc"><th colspan="3" align="right">Grant Total</th><td>&nbsp;&nbsp;$ ' . number_format($arrOrderItemTotal[0]['Amount'], 2, ".", ",") . '</td></tr>';

        $varEmailOrderDetails .='</table>';


        $varCustomerName = $arrOrderDetail['CustomerFirstName'] . ' ' . $arrOrderDetail['CustomerLastName'];

        $varCustomerEmail = $arrOrderDetail['CustomerEmail'];
        $varSubject = 'Order details';


        $varFrom = SITE_NAME;
        $EmailTemplates = $this->SentEmailTemplates();
        $varKeyword = array('{EMAIL}', '{EMAILDETAILS}');

        $varKeywordValues = array($varCustomerName, $varEmailOrderDetails);

        $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);

        // Calling mail function
        $objCore->sendMail($varCustomerEmail, $varFrom, $varSubject, $varEmailMessage);
    }

    /**
     * function SentEmailToCustomer
     *
     * This function is used to Sent Email To Wholesaler .
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objOrder->SentEmailToWholesaler($arrOrderDetail)
     */
    function SentEmailToWholesaler($arrOrderDetail) {

        global $objCore;
        global $objGeneral;


        $varEmailOrderDetails = '<table width="700" cellspacing="0" cellpadding="5" border="0"><tr><td>Order updated By Admin on ' . SITE_NAME . '.Order details : </p></td></tr></table>';
        $varEmailOrderDetails .= '<table width="100%" bgcolor="#F0EBE2"  border="1" cellpadding="8" cellspacing="0">';
        $varEmailOrderDetails .= '<tr><th>Order ID</th><td>&nbsp;&nbsp;' . $arrOrderDetail['pkOrderID'] . '</td><th>Transaction&nbsp;ID</th><td>&nbsp;&nbsp;' . $arrOrderDetail['TransactionID'] . '</td></tr>';
        $varEmailOrderDetails .= '<tr><td colspan="4">&nbsp;</td></tr>';

        $varEmailOrderDetails .= '<tr><th>Item Type</th><th>Items</th><th>Quantity</th><th>Price</th></tr>';

        $arrWholesalerDetails = $this->GetWholesalerDetails($arrOrderDetail['pkOrderID']);

        $EmailTemplates = $this->SentEmailTemplates();
        $varKeyword = array('{EMAIL}', '{EMAILDETAILS}');
        $varSubject = 'Order details';
        $varFrom = SITE_NAME;

        foreach ($arrWholesalerDetails as $k => $v) {

            $varWhre = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' AND fkWholesalerID = '" . $v['fkWholesalerID'] . "'";
            $arrOrderItems = $this->GetItemDetails($varWhre);


            $varEmailOrderDetail = '';
            $varTotal = 0;
            foreach ($arrOrderItems as $k2 => $v2) {
                $varTotal += $v2['ItemTotalPrice'];
                $varEmailOrderDetail .= '<tr><td align="center">' . $v2['ItemType'] . '</td><td align="center"><b>' . $v2['ItemName'] . '</b><br />' . $v2['OptionDet'] . '</td><td align="center">' . $v2['Quantity'] . '</td><td align="center">$ ' . number_format($v2['ItemTotalPrice'], 2, '.', ',') . '</td></tr>';
            }

            $varEmailOrderDetailss = $varEmailOrderDetails . $varEmailOrderDetail . '<tr bgcolor="#ccc"><th colspan="3" align="right">Grant Total</th><td>&nbsp;&nbsp;$ ' . number_format($varTotal, 2, ".", ",") . '</td></tr>';

            $varEmailOrderDetailss .='</table>';
            $varName = $v['CompanyName'];
            $varEmail = $v['CompanyEmail'];

            $varKeywordValues = array($varName, $varEmailOrderDetailss);
            $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);
            // Calling mail function
            $objCore->sendMail($varEmail, $varFrom, $varSubject, $varEmailMessage);
        }
    }

    /**
     * function SentEmailToCountryPortal
     *
     * This function is used to Sent Email To Country Portal .
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objOrder->SentEmailToCountryPortal($arrOrderDetail)
     */
    function SentEmailToCountryPortal($arrOrderDetail) {

        global $objCore;

        $varEmailOrderDetails = '<table width="700" cellspacing="0" cellpadding="5" border="0"><tr><td>Order Updated By Admin on ' . SITE_NAME . '.Order details : </p></td></tr></table>';
        $varEmailOrderDetails .= '<table width="100%" bgcolor="#F0EBE2"  border="1" cellpadding="8" cellspacing="0">';
        $varEmailOrderDetails .= '<tr><th>Order ID</th><td>&nbsp;&nbsp;' . $arrOrderDetail['pkOrderID'] . '</td><th>Transaction&nbsp;ID</th><td>&nbsp;&nbsp;' . $arrOrderDetail['TransactionID'] . '</td></tr>';
        $varEmailOrderDetails .= '<tr><td colspan="4">&nbsp;</td></tr>';

        $varEmailOrderDetails .= '<tr><th>Item Type</th><th>Items</th><th>Quantity</th><th>Price</th></tr>';

        $arrWholesalerDetails = $this->GetWholesalerDetails($arrOrderDetail['pkOrderID']);

        $EmailTemplates = $this->SentEmailTemplates();
        $varKeyword = array('{EMAIL}', '{EMAILDETAILS}');
        $varSubject = 'Order details';
        $varFrom = SITE_NAME;

        foreach ($arrWholesalerDetails as $k => $v) {

            $varWhre = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' AND fkWholesalerID = '" . $v['fkWholesalerID'] . "'";
            $arrOrderItems = $this->GetItemDetails($varWhre);


            $varEmailOrderDetail = '';
            $varTotal = 0;
            foreach ($arrOrderItems as $k2 => $v2) {
                $varTotal += $v2['ItemTotalPrice'];
                $varEmailOrderDetail .= '<tr><td align="center">' . $v2['ItemType'] . '</td><td align="center"><b>' . $v2['ItemName'] . '</b><br />' . $v2['OptionDet'] . '</td><td align="center">' . $v2['Quantity'] . '</td><td align="center">$ ' . number_format($v2['ItemTotalPrice'], 2, '.', ',') . '</td></tr>';
            }



            $varWhere = "AdminCountry = '" . $v['CompanyCountry'] . "'";

            $AdminData = $this->adminList($varWhere);
            $varCtr = 0;

            foreach ($AdminData as $val) {

                if ($val['AdminRegion'] == $v['CompanyRegion']) {
                    $varEmail = $val['AdminEmail'];
                    $varName = $val['AdminUserName'];
                    $varCtr = $varCtr++;
                } else if ($val['AdminCountry'] == $v['CompanyCountry'] && $varCtr == 0) {
                    $varEmail = $val['AdminEmail'];
                    $varName = $val['AdminUserName'];
                } else {

                    continue;
                }

                $varEmailOrderDetailss = $varEmailOrderDetails . $varEmailOrderDetail . '<tr bgcolor="#ccc"><th colspan="3" align="right">Grant Total</th><td>&nbsp;&nbsp;$ ' . number_format($varTotal, 2, ".", ",") . '</td></tr>';

                $varEmailOrderDetailss .='</table>';

                $varKeywordValues = array($varName, $varEmailOrderDetailss);
                $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);
                // Calling mail function
                $objCore->sendMail($varEmail, $varFrom, $varSubject, $varEmailMessage);
            }
        }
    }

    /**
     * function SentEmailToSuperAdmin
     *
     * This function is used to Sent Email To Super Admin .
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objOrder->SentEmailToSuperAdmin($arrOrderDetail)
     */
    function SentEmailToSuperAdmin($arrOrderDetail) {

        global $objCore;

        $varWhr = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' ";
        $arrOrderItems = $this->GetItemDetails($varWhr);

        $varWhr = " fkOrderID = '" . $arrOrderDetail['pkOrderID'] . "' AND Code='total' ";
        $arrOrderItemTotal = $this->GetTotalDetails($varWhr);

        $varEmailOrderDetails = '<table width="700" cellspacing="0" cellpadding="5" border="0"><tr><td>Order updated by Admin on ' . SITE_NAME . '.Order details : </p></td></tr></table>';
        $varEmailOrderDetails .= '<table width="100%" bgcolor="#F0EBE2"  border="0" cellpadding="8" cellspacing="0">';
        $varEmailOrderDetails .= '<tr><th>Order ID</th><td>&nbsp;&nbsp;' . $arrOrderDetail['pkOrderID'] . '</td><th>Transaction&nbsp;ID</th><td>&nbsp;&nbsp;' . $arrOrderDetail['TransactionID'] . '</td></tr>';
        $varEmailOrderDetails .= '<tr><td colspan="4">&nbsp;</td></tr>';

        $varEmailOrderDetails .= '<tr><th>Item Type</th><th>Items</th><th>Quantity</th><th>Price</th></tr>';

        foreach ($arrOrderItems as $k => $v) {
            $varEmailOrderDetails .= '<tr><td align="center">' . $v['ItemType'] . '</td><td align="center"><b>' . $v['ItemName'] . '</b><br />' . $v['OptionDet'] . '</td><td align="center">' . $v['Quantity'] . '</td><td align="center">$ ' . number_format($v['ItemTotalPrice'], 2, '.', ',') . '</td></tr>';
        }

        $varEmailOrderDetails .= '<tr bgcolor="#ccc"><th colspan="3" align="right">Grant Total</th><td>&nbsp;&nbsp;$ ' . number_format($arrOrderItemTotal[0]['Amount'], 2, ".", ",") . '</td></tr>';

        $varEmailOrderDetails .='</table>';

        $varWhre = "AdminType = 'super-admin' ";
        $arrAdminDetails = $this->adminList($varWhre);

        $EmailTemplates = $this->SentEmailTemplates();
        $varKeyword = array('{EMAIL}', '{EMAILDETAILS}');
        $varSubject = 'Order details';
        $varFrom = SITE_NAME;
        foreach ($arrAdminDetails as $admink => $adminv) {

            $varName = $adminv['AdminUserName'];
            $varEmail = $adminv['AdminEmail'];

            $varKeywordValues = array($varName, $varEmailOrderDetails);
            $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);

            // Calling mail function
            $objCore->sendMail($varEmail, $varFrom, $varSubject, $varEmailMessage);
        }
    }

    /**
     * function SentEmailTemplates
     *
     * This function is used to Sent Email To Super Admin .
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters ''
     *
     * @return true
     *
     * User instruction: $objOrder->SentEmailTemplates()
     */
    function SentEmailTemplates() {

        
        $varEmailTemplate = '<table width="700" cellspacing="0" cellpadding="5" border="0">
                <tr><td><p><strong>Dear {EMAIL} ,</strong></p></td></tr>
                <tr><td>{EMAILDETAILS}</td></tr>
                </table>';

        return $varEmailTemplate;
        // Calling mail function
    }

    /**
     * function orderTotal
     *
     * This function is used to display order Total .
     *
     * Database Tables used in this function are : tbl_order_items,
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRows
     *
     * User instruction: $objOrder->orderTotal($argOrderID)
     */
    function orderTotal($argOrderID) {

        $arrSubTotal = $this->getArrayResult("SELECT sum(ItemSubTotal+AttributePrice) as TotalPrice FROM " . TABLE_ORDER_ITEMS . " WHERE fkOrderID ='" . $argOrderID . "'");
        $arrShippingTotal = $this->getArrayResult("SELECT sum(ShippingPrice) as TotalPrice FROM " . TABLE_ORDER_ITEMS . " WHERE fkOrderID ='" . $argOrderID . "'");
        $arrDiscountTotal = $this->getArrayResult("SELECT sum(DiscountPrice) as TotalPrice FROM " . TABLE_ORDER_ITEMS . " WHERE fkOrderID ='" . $argOrderID . "'");

        $arrRows = array(
            'sub-total' => $arrSubTotal[0]['TotalPrice'],
            'shipping' => $arrShippingTotal[0]['TotalPrice'],
            'coupon' => $arrDiscountTotal[0]['TotalPrice'],
            'gift-card' => 0,
            'reward-points' => 0
        );

        $arrTotal = $this->getArrayResult("SELECT Code,Title,Amount FROM " . TABLE_ORDER_TOTAL . " WHERE fkOrderID ='" . $argOrderID . "' ORDER BY SortOrder ASC");


        foreach ($arrTotal as $val) {
            if ($val['Code'] == 'gift-card' || $val['Code'] == 'reward-points') {
                $arrRows[$val['Code']] = $val['Amount'];
            }
        }
        //pre($arrRows);
        return $arrRows;
    }

    /**
     * function removeOrder
     *
     * This function is used to remove order .
     *
     * Database Tables used in this function are : tbl_order_items,
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $ctr
     *
     * User instruction: $objOrder->removeOrder($argPostIDs, $varPortalFilter)
     */
    function removeOrder($argPostIDs, $varPortalFilter) {
        $ctr = 0;

        if (isset($argPostIDs['deleteType']) && $argPostIDs['deleteType'] == 'sD') {

            $varWhr = " SubOrderID = '" . $argPostIDs['frmID'] . "'";
            $varWhereSdelete = $varWhr . $varPortalFilter;
            $arrRes = $this->select(TABLE_ORDER_ITEMS, array('fkOrderID'), $varWhr, "", " 0,1");

            $num = $this->delete(TABLE_ORDER_ITEMS, $varWhereSdelete);
            if ($num > 0) {
                $ctr++;
                $this->removeRelatedOrder($argPostIDs['frmID'], $arrRes[0]['fkOrderID']);
            }
        } else {
            foreach ($argPostIDs['frmID'] as $varDeleteID) {
                $varWhr = " SubOrderID = '" . $varDeleteID . "'";
                $varWhereCondition = $varWhr . $varPortalFilter;
                $arrRes = $this->select(TABLE_ORDER_ITEMS, array('fkOrderID'), $varWhr, "", " 0,1");
                $num = $this->delete(TABLE_ORDER_ITEMS, $varWhereCondition);
                if ($num > 0) {
                    $ctr++;
                    $this->removeRelatedOrder($varDeleteID, $arrRes[0]['fkOrderID']);
                }
            }
        }

        return $ctr;
    }

    /**
     * function removeRelatedOrder
     *
     * This function is used to remove related order .
     *
     * Database Tables used in this function are : tbl_order_items, tbl_order, tbl_order_comments, tbl_order_total
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $ctr
     *
     * User instruction: $objOrder->removeOrder($argPostIDs, $varPortalFilter)
     */
    function removeRelatedOrder($argSubID, $argOID) {

        $varWhr = "fkOrderID='" . $argOID . "'";
        $arrRes = $this->select(TABLE_ORDER_ITEMS, array('fkOrderID'), $varWhr, "", " 0,1");

        if (empty($arrRes)) {
            $varWher = "pkOrderID='" . $argOID . "'";
            $this->delete(TABLE_ORDER, $varWher);
            $varWhereCondition = 'fkOrderID = ' . $argOID;
            $this->delete(TABLE_ORDER_COMMENTS, $varWhereCondition);
            $this->delete(TABLE_ORDER_ITEMS, $varWhereCondition);
            $this->delete(TABLE_ORDER_TOTAL, $varWhereCondition);
        }
    }
    
    
    /**
     * function SentCustomerFeedback
     *
     * This function is used to Sent Email to customer if their ordered product status is Completed
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objOrder->SentCustomerFeedback()
     * 
     * @author : Krishna Gupta
     * 
     * @created : 20-10-2015
     */
    function SentCustomerFeedback($fullname) {
    
        $varEmailTemplate = '<table width="700" cellspacing="0" cellpadding="5" border="0">
        
        <tr><td><p><strong>Dear '. $fullname .' ,</strong></p></td></tr>
        <tr><td><p style="margin-left: 50px;"> Please provide your valuable feedback to us within 30days. </p></td></tr>
        
        </table>';
    
        return $varEmailTemplate;
        // Calling mail function
    }

    /**
     * function updateOrderStatus
     *
     * This function is used to upadte order status.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_order
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objOrder->updateOrderStatus($argPost)
     */
    function updateOrderStatus($argPost) {
      // pre($argPost);
        $arrRes2 = $this->select(TABLE_ORDER_ITEMS, array('fkOrderID', 'SubOrderID', 'Status'), "SubOrderID = '" . $argPost['soid'] . "' ");

        $arrClmsUpdate = array('Status' => $argPost['status'], 'DisputedStatus' => $argPost['DisputedStatus']);
        if (isset($argPost['DisputedStatus'])) {
            if ($argPost['DisputedStatus'] == 'Canceled') {
                $arrClmsUpdate = array('Status' => 'Canceled');
            } else {
                $arrClmsUpdate = array('DisputedStatus' => $argPost['DisputedStatus']);
            }
        } else {
            $arrClmsUpdate = array('Status' => $argPost['status']);
        }
        
        /*
         * This condition is used to sent an email to customer if ordered product status became completed from admin panel
         * 
         * Another function : SentCustomerFeedback()
         * 
         * @author : Krishna Gupta
         * 
         * @created : 20-10-2015
         */
        if (isset($argPost['status']) && $argPost['status']=='Completed') {
            global $objCore;
            $getCustomerId = explode('-', $argPost['soid']);
            $getEmailID = mysql_query("SELECT CustomerFirstName, CustomerLastName, CustomerEmail from tbl_order where pkOrderID=".$getCustomerId[0]);
            $result = mysql_fetch_assoc($getEmailID);
            
            /* Send email to customer */
            $fullName = ucfirst($result['CustomerFirstName']).' '.ucfirst($result['CustomerLastName']);
            $varCustomerEmail = $result['CustomerEmail'];
            $varFrom = SITE_NAME;
            $EmailTemplates = $this->SentCustomerFeedback($fullName);
            $varSubject = " Your order has been completed. ";
            
            $varKeyword = array('{FULLNAME}');
            
            $varKeywordValues = array($fullName);
            
            $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);
            
            $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);
            $objCore->sendMail($varCustomerEmail, $varFrom, $varSubject, $varEmailMessage);
        }
        
        if (isset($argPost['status']) && $argPost['status']=='Processing') {
            global $objCore;
            //pre($argPost);
            $getCustomerId = explode('-', $argPost['soid']);
            if(empty($argPost['gatwaymailid']))
            {
                $gatwaymailid=$argPost['portalmail'];
            }
            else 
            {
                
                $gatwaymailid=$argPost['gatwaymailid'];
            }
            
            
            $varPortalFilter='';
            //'gatwayname' => $arrPost['ShippingTitle'],
            $logisticname=$argPost['gatwayname'];
            $status=$argPost['status'];
            $this->sendmailtologisticcompany($argPost['soid'], $varPortalFilter,$gatwaymailid,$logisticname,$status);
            
        }
        
        if (isset($argPost['status']) && $argPost['status']=='Processed') {
            global $objCore;
            //pre($argPost);
            $getCustomerId = explode('-', $argPost['soid']);
            if(empty($argPost['gatwaymailid']))
            {
                $gatwaymailid=$argPost['portalmail'];
            }
            else
            {
        
                $gatwaymailid=$argPost['gatwaymailid'];
            }
             
             
            $varPortalFilter='';
            //'gatwayname' => $arrPost['ShippingTitle'],
            $logisticname=$argPost['gatwayname'];
            $status=$argPost['status'];
            $this->sendmailtologisticcompanyinprocessed($argPost['soid'], $varPortalFilter,$gatwaymailid,$logisticname,$status);
             
        }
        
        if (isset($argPost['status']) && $argPost['status']=='Shipped') {
            global $objCore;
            //pre($argPost);
            $getCustomerId = explode('-', $argPost['soid']);
            //pre($getCustomerId);
            if(empty($argPost['gatwaymailid']))
            {
                $gatwaymailid=$argPost['portalmail'];
            }
            else
            {
        
                $gatwaymailid=$argPost['gatwaymailid'];
            }
             
             
            $varPortalFilter='';
            //'gatwayname' => $arrPost['ShippingTitle'],
            $logisticname=$argPost['gatwayname'];
            $status=$argPost['status'];
            $this->sendmailtocustomershipped($argPost['soid'], $varPortalFilter,$gatwaymailid,$logisticname,$status);
             
        }
        
        if (isset($argPost['status']) && $argPost['status']=='Delivered') {
            global $objCore;
            //pre($argPost);
            $getCustomerId = explode('-', $argPost['soid']);
            //pre($getCustomerId);
            if(empty($argPost['gatwaymailid']))
            {
                $gatwaymailid=$argPost['portalmail'];
            }
            else
            {
        
                $gatwaymailid=$argPost['gatwaymailid'];
            }
        
        
            $varPortalFilter='';
            //'gatwayname' => $arrPost['ShippingTitle'],
            $logisticname=$argPost['gatwayname'];
            $status=$argPost['status'];
            $this->sendmailtocustomerdelievered($argPost['soid'], $varPortalFilter,$gatwaymailid,$logisticname,$status);
        
        }
        
        
       // $getorderId = explode('-', $argPost['soid']);
        
        //$orderWhr = "pkOrderID ='" . $getorderId . "' ";
        $varWhr = "SubOrderID ='" . $argPost['soid'] . "' ";
        $logicvarWhr = "fkSubOrderID ='" . $argPost['soid'] . "' ";
        
        //pre($varWhr);
        $arrUpdatelogisticID = $this->update(tbl_logisticinvoice, $arrClmsUpdate, $logicvarWhr);
        $arrUpdateID = $this->update(TABLE_ORDER_ITEMS, $arrClmsUpdate, $varWhr);
        //$arrUpdateorderID = $this->update(TABLE_ORDER, $arrClmsUpdate, $orderWhr);
       
        
        

        $varID1 = "fkOrderID = '" . $arrRes1[0]['fkOrderID'] . "' AND Status ='Pending' ";
        $arrRes1 = $this->select(TABLE_ORDER_ITEMS, array('Status'), $varID1);

        if (count($arrRes1) == 0) {
            $arrClmsUpdate1 = array('OrderStatus' => $argPost['status'], 'OrderDateUpdated' => date(DATE_TIME_FORMAT_DB));
            $varWhr1 = "pkOrderID ='" . $arrRes2[0]['fkOrderID'] . "'";
            $arrUpdateID = $this->update(TABLE_ORDER, $arrClmsUpdate1, $varWhr1);
        }

        if ($arrRes2[0]['Status'] == 'Disputed' || $arrRes2[0]['Status'] == 'Canceled') {
            $this->markAsDisputed($arrRes2[0], $argPost['status'], 1);
        } else if ($argPost['status'] == 'Disputed' || $argPost['status'] == 'Canceled') {
            $this->markAsDisputed($arrRes2[0], $argPost['status']);
        }
    }

    /**
     * function markAsDisputed
     *
     * This function is used to display mark Disputed.
     *
     * Database Tables used in this function are : tbl_order, tbl_invoice
     *
     * @access public
     *
     * @parameters 3 string
     *
     * @return true
     *
     * User instruction: $objOrder->markAsDisputed($arrOrd, $status,$isRestore = 0)
     */
    function markAsDisputed($arrOrd, $status, $isRestore = 0) {
        global $objGeneral;
        $arrClms = array('pkOrderID', 'fkCustomerID', 'TransactionID', 'CustomerFirstName', 'CustomerLastName', 'CustomerEmail', 'CustomerPhone');

        $argWhere = "pkOrderID='" . $arrOrd['fkOrderID'] . "' ";
        $arrOrder = $this->select(TABLE_ORDER, $arrClms, $argWhere);

        if (count($arrOrder) > 0) {
            $varWhr = "fkSubOrderID ='" . $arrOrd['fkSubOrderID'] . "' AND fkOrderID !='' AND fkSubOrderID !=''";
            $this->update(TABLE_INVOICE, array('TransactionStatus' => $status), $varWhr);

            //$arrOrder[0]['Status'] = $arrOrd['Status'];
            $arrOrder[0]['SubOrderId'] = $arrOrd['SubOrderID'];
            if ($isRestore == 1) {
                $arrOrder[0]['EmailSubject'] = "Order Restore as " . $status . " By Country Portal. " . ORDER_DETAILS_TITLE;
            } else {
                $arrOrder[0]['EmailSubject'] = "Order Status change as " . $status . " By Country Portal. " . ORDER_DETAILS_TITLE;
            }

            $objGeneral->sendDisputedEmail($arrOrder[0]);
        }
    }

    /**
     * function sendInvoiceToCustomer
     *
     * This function is used to send Invoice To Customer.
     *
     * Database Tables used in this function are : tbl_invoice
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return true
     *
     * User instruction: $objOrder->sendInvoiceToCustomer($soID, $varPortalFilter)
     */
    function sendInvoiceToCustomer($soID, $varPortalFilter) {
    
        global $objCore;

        $arrRow = $this->editOrder($soID, $varPortalFilter);
        $arrOrder = $arrRow['arrOrder'][0];
        $arrCountryList = $arrRow['arrCountryList'];
        $arrOrderItem = $arrRow['arrOrderItems'];
        $arrOrderComment = $arrRow['arrOrderComments'];
        $arrOrderTotal = $arrRow['arrOrderTotal'];
        if (count($arrOrder) > 0) {

            $varCustomerName = $arrOrder['CustomerFirstName'] . ' ' . $arrOrder['CustomerLastName'];
            $varCustomerEmail = $arrOrder['CustomerEmail'];

            $arrCols = array(
                'fkOrderID' => $arrOrder['pkOrderID'],
                'fkSubOrderID' => $arrOrderItem[0]['SubOrderID'],
                'fkWholesalerID' => $arrOrderItem[0]['fkWholesalerID'],
                'FromUserType' => $_SESSION['sessUserType'],
                'FromUserID' => $_SESSION['sessUser'],
                'ToUserType' => 'customer',
                'ToUserID' => $arrOrder['fkCustomerID'],
                'CustomerName' => $varCustomerName,
                'CustomerEmail' => $varCustomerEmail,
                'Amount' => $varTotal,
                'AmountPayable' => $varTotal,
                'AmountDue' => '0.0000',
                'TransactionStatus' => 'Completed',
                'InvoiceDetails' => $varEmailOrderDetails,
                'OrderDateAdded' => $arrOrder['OrderDateAdded'],
                'InvoiceDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );

            $varInvoiceDate = $objCore->serverDateTime($arrCols['InvoiceDateAdded'], DATE_FORMAT_SITE_FRONT);
            $varInvoiceId = $this->insert(TABLE_INVOICE, $arrCols);


            $varEmailOrderDetails = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Customer:Invoice/Statement</title>
        <link href="' . CSS_PATH . 'invoices.css" rel="stylesheet" />
    </head>
    <body>
        <div class="main-div">
        <div class="no-print print_button"><span onclick="window.print();">Print</span></div>
            <div class="rgt-main-div">
                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td width="50%">
                            <img src="' . SITE_ROOT_URL . 'common/images/logo-telamela.png" />
                            <br /><br />
                            <span class="adr bld f20" id="custName">Telamela</span>
                            <br/>
                            <span class="adr" id="custName">United States</span>
                            <br/>
                        </td>

                        <td width="50%" class="vtop tc" valign="top">
                            <span class="c-name">INVOICE</span>
                        </td>
                    </tr>
                    <tr><td colspan="2"><hr /></td></tr>

                </table>
                <ul>
                    <li class="adr-lft">
                        <span class="bill-to bld">Bill To:</span>
                        <br/>
                        <span class="adr">' . $varCustomerName . '</span>
                        <br/>
                        <span class="adr">' . $arrOrder['BillingAddressLine1'] . '</span>
                        <br />
                        <span class="adr">' . $arrOrder['BillingAddressLine2'] . ' ' . $arrOrder['BillingPostalCode'] . '</span>
                        <br/>
                        <span class="adr">' . $arrOrder['BillingCountryName'] . '</span>
                        <br/>
                    </li>
                    <li class="adr-rgt">
                        <table cellspacing="0" cellpadding="0" width="100%" class="bill">
                            <tr>
                                <td width="40%" class="lft-txt"><span class="bld">Invoice#</span></td>
                                <td><span class="span">' . $varInvoiceId . '</span></td>
                            </tr>
                            <tr>
                                <td class="lft-txt">
                                    <span class="bld">Invoice Date</span>
                                </td>
                                <td>
                                    <span class="span">' . $varInvoiceDate . '</span>
                                </td>
                            </tr>

                        </table>
                    </li>
                </ul>

                <div style="margin-top:30px;float:left;width:99%;">
                    <span class="adr">Dear ' . $varCustomerName . ',</span>
                </div>
                <div style="clear:both;">
                </div>
                <div class="lineItemDIV" style="width: 99%">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="column">
                        <tr class="hd">
                            <td><b>Sub Order Id</b></td>
                            <td><b>Item Description</b></td>
                            <td><b>Price</b></td>
                            <td><b class="bld">Qty</b></td>
                            <td><b class="bld">Shipping</b></td>
                            <td><b class="bld">Discount</b></td>
                            <td><b class="bld">SubTotal</b></td>
                        </tr>';

            $varSubTotal = 0;
            $varTotal = 0;
            foreach ($arrOrderItem as $item) {
                $varSubTotal = (($item['ItemSubTotal'] + $item['ShippingPrice']) - $item['DiscountPrice']);
                $varTotal +=$varSubTotal;

                $varEmailOrderDetails .='<tr class="row-item">
                            <td>' . $item['SubOrderID'] . '</td>
                            <td>' . '<b>' . $item['ItemName'] . '</b><br/>' . $item['OptionDet'] . '</td>
                            <td>' . number_format($item['ItemPrice'], 2) . '</td>
                             <td>' . $item['Quantity'] . '</td>
                            <td>' . number_format($item['ShippingPrice'], 2) . '</td>
                            <td>' . number_format($item['DiscountPrice'], 2) . '</td>
                            <td>' . number_format($varSubTotal, 2) . '</td>
                        </tr>';
            }
           

            /*
              <!--
              <tr>
              <td colspan="2">&nbsp;
              </td>
              <td class="sub-tot">
              Sub Total
              </td>

              <td class="sub-tot">
              200.00
              </td>
              </tr>-->

             */
            $varEmailOrderDetails .= '<tr class="tot"><td colspan="5">&nbsp;</td><td class="total">TOTAL</td><td><span class="amount bld">' . ADMIN_CURRENCY_SYMBOL . number_format($varTotal, 2) . '</span></td></tr></table></div></div></div></body></html>';


            $varDir = INVOICE_PATH . 'customer/';
            if (!is_dir($varDir)) {
                mkdir($varDir, 0777);
            }
            $fileName = 'inv_' . $varInvoiceId . '.html';
            $varFileName = $varDir . $fileName;


            $fh = fopen($varFileName, 'w');
            fwrite($fh, $varEmailOrderDetails);
            fclose($fh);


            $arrCols = array(
                'Amount' => $varTotal,
                'AmountPayable' => $varTotal,
                'AmountDue' => 0.00,
                'InvoiceFileName' => $fileName
            );
            $varInvoiceId = $this->update(TABLE_INVOICE, $arrCols, "pkInvoiceID='" . $varInvoiceId . "'");


            $varEmailOrderDetails = $varEmailOrderDetails;

            $varSubject = 'Order invoice details';
            $varFrom = SITE_NAME;
            $EmailTemplates = $this->SentEmailTemplates();
            $varKeyword = array('{EMAIL}', '{EMAILDETAILS}');

            $varKeywordValues = array($varCustomerName, $varEmailOrderDetails);

            $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);
    
            // Calling mail function
            $objCore->sendMail($varCustomerEmail, $varFrom, $varSubject, $varEmailMessage);

            return 1;
        } else {
            return 0;
        }
    }

    /**
     * function sendInvoiceToCustomer1
     *
     * This function is used to send Invoice To Customer.
     *
     * Database Tables used in this function are : tbl_invoice
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return true
     *
     * User instruction: $objOrder->sendInvoiceToCustomer($soID, $varPortalFilter)
     */
    function sendInvoiceToCustomer1($soID, $varPortalFilter) {
    
        global $objCore;
        global $arrProductImageResizes;
    
        $arrRow = $this->editOrder($soID, $varPortalFilter);
        $arrOrder = $arrRow['arrOrder'][0];
        $arrOrderitem = $arrRow['arrOrderItems'][0];
        $arrCountryList = $arrRow['arrCountryList'];
        $arrOrderItem = $arrRow['arrOrderItems'];
        $arrOrderComment = $arrRow['arrOrderComments'];
        $arrOrderTotal = $arrRow['arrOrderTotal'];
        if (count($arrOrder) > 0) {
    
    
            $varCustomerName = $arrOrder['CustomerFirstName'] . ' ' . $arrOrder['CustomerLastName'];
            $varCustomerEmail = $arrOrder['CustomerEmail'];
    
            $arrCols = array(
                    'fkOrderID' => $arrOrder['pkOrderID'],
                    'fkSubOrderID' => $arrOrderItem[0]['SubOrderID'],
                    'fkWholesalerID' => $arrOrderItem[0]['fkWholesalerID'],
                    'FromUserType' => $_SESSION['sessUserType'],
                    'FromUserID' => $_SESSION['sessUser'],
                    'ToUserType' => 'customer',
                    'ToUserID' => $arrOrder['fkCustomerID'],
                    'CustomerName' => $varCustomerName,
                    'CustomerEmail' => $varCustomerEmail,
                    'Amount' => $varTotal,
                    'AmountPayable' => $varTotal,
                    'AmountDue' => '0.0000',
                    'TransactionStatus' => 'Completed',
                    'InvoiceDetails' => $varEmailOrderDetails,
                    'OrderDateAdded' => $arrOrder['OrderDateAdded'],
                    'InvoiceDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );
    
            $varInvoiceDate = $objCore->serverDateTime($arrCols['InvoiceDateAdded'], DATE_FORMAT_SITE_FRONT);
            $varInvoiceId = $this->insert(TABLE_INVOICE, $arrCols);
    
    
    
            //echo //$varEmailCSS = '<link href="' . ADMIN_CSS . '" rel="stylesheet" type="text/css" />';
            $varEmailOrderDetails = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <link rel="shortcut icon" href="'. IMAGES_URL.'/favicon.ico" />
        <title>Customer:Invoice || Statement</title>
        <link href="' . CSS_PATH . 'invoice.css" rel="stylesheet" />
    </head>
    <body>{EMAIL_HEAD}
    
    

            <div class="dashboard_title" style="font-family:Arial, Helvetica, sans-serif; width: 99.3%;margin-bottom: 0px;color: #000;font-size: 13px;font-weight: bold;background-color: #FA990E;padding: 5px 4px 5px 5px;margin: 5px 0 0px 0;border-bottom: 1px #7986a9 solid;">Customer Invoice <span style="float: right;margin-right: 10px;font-size: 12px;font-weight: normal;"><a href="javascript:void(0)" onClick="window.print();" style="color:black" class="noPrint">Print</a></span></div>
<table width="99%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; float: left;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;" class="left_content">
  <tr class="content">
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif; border:0; text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif; width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="2" class="heading" style="font-family:Arial, Helvetica, sans-serif; text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Order Details </td>
        </tr>
        <tr class="content">
          <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Order ID</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['pkOrderID'] . ' </td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Order Date</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $objCore->localDateTime($arrOrder['OrderDateAdded'], DATE_TIME_FORMAT_SITE) . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Order Status</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrderitem['Status'] . '</td>
        </tr>
      </table></td>
    <td width="2%" style="font-family:Arial, Helvetica, sans-serif; border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif; border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif; width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="2" class="heading" style="font-family:Arial, Helvetica, sans-serif; text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Account Information</td>
        </tr>
        <tr class="content">
          <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Customer Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['CustomerFirstName'] . ' ' . $arrOrder['CustomerLastName'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Email:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['CustomerEmail'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Phone</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['CustomerPhone'] . '</td>
        </tr>
      </table></td>
  </tr>
  <tr class="content">
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif; border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
  </tr>
  <tr class="content">
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="2" class="heading" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Billing Information</td>
        </tr>
        <tr class="content">
          <td colspan="2" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Recipient First Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['BillingFirstName'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Recipient Last Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['BillingLastName'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Organization Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['BillingOrganizationName'] . '&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Address Line 1:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['BillingAddressLine1'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Address Line 2</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['BillingAddressLine2'] . '&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Country</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['BillingCountryName'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Post Code or Zip Code:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['BillingPostalCode'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Phone:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['BillingPhone'] . '</td>
        </tr>
      </table></td>
    <td width="2%" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="2" class="heading" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Shipping Information</td>
        </tr>
        <tr class="content">
          <td colspan="2" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Recipient First Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingFirstName'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Recipient Last Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingLastName'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Organization Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingOrganizationName'] . '&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Address Line 1:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingAddressLine1'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Address Line 2</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingAddressLine2'] . '&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Country</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingCountryName'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Post Code or Zip Code:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingPostalCode'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Phone:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingPhone'] . '</td>
        </tr>
      </table></td>
  </tr>
  <tr class="content">
    <td width="48%" colspan="3" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Sub Order Id</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Items Ordered</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Items Image</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Price</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Qty.</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">SubTotal</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Shipping</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Discount</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Grand Total</td>
        </tr>
         '; $varSubTotal = 0;
            $varShippingSubTotal = 0;
            $varTotal = 0;
            foreach ($arrOrderItem as $item) {
    
                if ($item['ItemType'] == 'product') {
                    $path = 'products/' . $arrProductImageResizes['default'];
                } else if ($item['ItemType'] == 'package') {
                    $path = 'package/' . PACKAGE_IMAGE_RESIZE1;
                } else {
                    $path = 'gift_card';
                }
    
                $varSrc = $objCore->getImageUrl($item['ItemImage'], $path);
    
                $varSubTotal += ($item['ItemSubTotal'] + $item['AttributePrice'] - $item['DiscountPrice']);
                $varShippingSubTotal += $item['ShippingPrice'];
                $varEmailOrderDetails .='
        <tr class="content">
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $item['SubOrderID'] . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . '<b>' . $item['ItemName'] . '</b><br/>' . $item['OptionDet'] . '<br>
           <br></td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> <img src="' . $varSrc . '" alt="' . $item['ItemName'] . '" style="font-family:Arial, Helvetica, sans-serif;float: none;border: none;" /></td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . number_format(($item['ItemPrice'] + ($item['AttributePrice'] / $item['Quantity'])), 2) . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $item['Quantity'] . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . number_format(($item['ItemSubTotal'] + $item['AttributePrice']), 2) . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . number_format($item['ShippingPrice'], 2) . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . number_format($item['DiscountPrice'], 2) . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . number_format($item['ItemTotalPrice'], 2) . '</td>
        </tr>
        ';
            }
    
            $varTotal = ($varSubTotal + $varShippingSubTotal);
            $varEmailOrderDetails .='
      </table></td>
  </tr>
  <tr class="content">
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
  </tr>
  <tr class="content">
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="2" class="heading" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Comments History</td>
        </tr>
        <tr class="content">
          <td colspan="2" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">
';
    
    
            foreach ($arrOrderComment as $vc) {
                $varEmailOrderDetails .= '<p>' . $vc['Comment'] . '</p><p align="right"><b> - ' . $vc[$vc['CommentedBy'] . 'Name'] . ' (' . ucwords($vc['CommentedBy']) . ') </b></p>';
            }
    
            $varEmailOrderDetails .= '
<br></td>
        </tr>
      </table></td>
    <td width="2%" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="2" class="heading" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Order Totals</td>
    
        </tr>
        ';
    
    
            foreach ($arrOrderComment as $vc) {
                $varEmailOrderDetails .= '<p>' . $vc['Comment'] . '</p><p align="right"><b> - ' . $vc[$vc['CommentedBy'] . 'Name'] . ' (' . ucwords($vc['CommentedBy']) . ') </b></p>';
            }
    
            $varEmailOrderDetails .= '
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Sub Total</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . ADMIN_CURRENCY_SYMBOL . number_format($varSubTotal, 2, ".", ",") . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Shipping Charge</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . ADMIN_CURRENCY_SYMBOL . number_format($varShippingSubTotal, 2, ".", ",") . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Total</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . ADMIN_CURRENCY_SYMBOL . number_format($varTotal, 2, ".", ",") . '</td>
        </tr>';
    
            if ($varDescription) {
                $varEmailOrderDetails = '<tr class="content"><td class="admin_left_text">Description</td><td class="admin_left_input">' . $varDescription . '</td></tr>';
            }
    
            $varEmailOrderDetails .='
      </table></td>
  </tr>
  <tr class="content">
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
  </tr>
</table></body></html>';
    
            //insert invoice in table
    
            $varFileContent = str_replace('{EMAIL_HEAD}', '', $varEmailOrderDetails);
    
            $varDir = INVOICE_PATH . 'customer/';
            if (!is_dir($varDir)) {
                mkdir($varDir, 0777);
            }
            $fileName = 'inv_' . $varInvoiceId . '.html';
            $varFileName = $varDir . $fileName;
    
    
            $fh = fopen($varFileName, 'w');
            fwrite($fh, $varFileContent);
            fclose($fh);
            $arrCols = array(
                    'Amount' => $varTotal,
                    'AmountPayable' => $varTotal,
                    'AmountDue' => 0.00,
                    'InvoiceFileName' => $fileName
            );
            $varInvoiceId = $this->update(TABLE_INVOICE, $arrCols, "pkInvoiceID='" . $varInvoiceId . "'");
    
            $varEmailHead = '<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr><td>Here is the summary of your order. You can also find your order details in <a href="' . SITE_ROOT_URL . 'my_orders.php">My Orders</a> when you log into your Telamela account.</td></tr></table>';
            $varEmailOrderDetails = str_replace('{EMAIL_HEAD}', $varEmailHead, $varEmailOrderDetails);
    
            $varSubject = 'Telamela : Invoice Details';
            $varFrom = SITE_NAME;
            $EmailTemplates = $this->SentEmailTemplates();
            $varKeyword = array('{EMAIL}', '{EMAILDETAILS}');
    
            $varKeywordValues = array($varCustomerName, $varEmailOrderDetails);
    
            $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $EmailTemplates);
             //echo $varEmailMessage; die;
            // Calling mail function
            $objCore->sendMail($varCustomerEmail, $varFrom, $varSubject, $varEmailMessage);
    
            return 1;
        } else {
            return 0;
        }
    }
    
       function sendmailtologisticcompany($soID, $varPortalFilter,$logisticmailid,$logisticname,$status) {
       // $logisticmailid='antima.gupta@planetwebsolution.com';
        global $objCore;
        global $arrProductImageResizes;
    
        $arrRow = $this->editOrder($soID, $varPortalFilter);
        $arrOrder = $arrRow['arrOrder'][0];
        $arrCountryList = $arrRow['arrCountryList'];
        $arrOrderItem = $arrRow['arrOrderItems'];
        $arrOrderComment = $arrRow['arrOrderComments'];
        $arrOrderTotal = $arrRow['arrOrderTotal'];
        if (count($arrOrder) > 0) {
    
    
            $varCustomerName = $arrOrder['CustomerFirstName'] . ' ' . $arrOrder['CustomerLastName'];
            $varCustomerEmail = $arrOrder['CustomerEmail'];
            
            $arrCols = array(
                    'fkOrderID' => $arrOrder['pkOrderID'],
                    'fkSubOrderID' => $arrOrderItem[0]['SubOrderID'],
                    'fkWholesalerID' => $arrOrderItem[0]['fkWholesalerID'],
            		'fkShippingIDs' => $arrOrderItem[0]['fkShippingIDs'],
                    'FromUserType' => $_SESSION['sessUserType'],
                    'FromUserID' => $_SESSION['sessUser'],
                    'ToUserType' => 'customer',
                    'ToUserID' => $arrOrder['fkCustomerID'],
                    'CustomerName' => $varCustomerName,
                    'CustomerEmail' => $varCustomerEmail,
                    'Amount' => $varTotal,
                    'AmountPayable' => $varTotal,
                    'AmountDue' => '0.0000',
                    'TransactionStatus' => 'Completed',
                    'InvoiceDetails' => $varEmailOrderDetails,
                    'OrderDateAdded' => $arrOrder['OrderDateAdded'],
                    'InvoiceDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );
            $Length=number_format($arrOrderItem[0]['Length'], 2, '.', '');
            $Width=number_format($arrOrderItem[0]['Width'], 2, '.', '');
            $Height=number_format($arrOrderItem[0]['Height'], 2, '.', '');
            $DimensionUnit=$arrOrderItem[0]['DimensionUnit'];
            $productweight=$objCore->convertproductweight($arrOrderItem[0]['WeightUnit'],$arrOrderItem[0]['Weight']).' '.'kg';
            $varInvoiceDate = $objCore->serverDateTime($arrCols['InvoiceDateAdded'], DATE_FORMAT_SITE_FRONT);
            $varInvoiceId = $this->insert(TABLE_INVOICE, $arrCols);
    
    
    
            //echo //$varEmailCSS = '<link href="' . ADMIN_CSS . '" rel="stylesheet" type="text/css" />';
            $varEmailOrderDetails = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <link rel="shortcut icon" href="'. IMAGES_URL.'/favicon.ico" />
        <title>order status</title>
        <link href="' . CSS_PATH . 'invoice.css" rel="stylesheet" />
    </head>
    <body>{EMAIL_HEAD}
    
    
    
    <div class="dashboard_title" style="font-family:Arial, Helvetica, sans-serif; width: 99.3%;margin-bottom: 0px;color: #000;font-size: 18px;font-weight: bold;background-color: #FA990E;padding: 8px 4px 8px 5px;margin: 5px 0 0px 0;border-bottom: 1px #7986a9 solid;">Order Detail</div>        
<table width="99%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; float: left;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;" class="left_content">
  <tr class="content">
    <td width="100%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif; border:0; text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;" colspan="3"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif; width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-bottom: none;border-right: none;">
        
        
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Order ID</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['pkOrderID'] . ' </td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Order Date</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $objCore->localDateTime($arrOrder['OrderDateAdded'], DATE_TIME_FORMAT_SITE) . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Order Status</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $status . '</td>
        </tr>
      </table></td>
    
  </tr>
  <tr class="content">
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif; border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
  </tr>
  <tr class="content">
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"></td>
    <td width="2%" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">
	
	</td>
  </tr>
  <tr class="content">
    <td width="48%" colspan="3" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Sub Order Id</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Items Ordered</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Items Image</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;"> Shipping Price($)</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Qty.</td>
          
        </tr>
         '; $varSubTotal = 0;
            $varShippingSubTotal = 0;
            $varTotal = 0;
            foreach ($arrOrderItem as $item) {
    
                if ($item['ItemType'] == 'product') {
                    $path = 'products/' . $arrProductImageResizes['default'];
                } else if ($item['ItemType'] == 'package') {
                    $path = 'package/' . PACKAGE_IMAGE_RESIZE1;
                } else {
                    $path = 'gift_card';
                }
    
                $varSrc = $objCore->getImageUrl($item['ItemImage'], $path);
    
                $varSubTotal += ($item['ItemSubTotal'] + $item['AttributePrice'] - $item['DiscountPrice']);
                $varShippingSubTotal += $item['ShippingPrice'];
                $varEmailOrderDetails .='
        <tr class="content">
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $item['SubOrderID'] . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . '<b>' . $item['ItemName'] . '</b><br/>' . $item['OptionDet'] . '<br>
            <br></td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> <img src="' . $varSrc . '" alt="' . $item['ItemName'] . '" style="font-family:Arial, Helvetica, sans-serif;float: none;border: none;" /></td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . number_format($item['ShippingPrice'], 2). '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $item['Quantity'] . '</td>
          
        </tr>
        ';
            }
    
            $varTotal = ($varSubTotal + $varShippingSubTotal);
            $varEmailOrderDetails .='
      </table></td>
  </tr>
  <tr class="content">
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
  </tr>
  <tr class="content">
    <td width="100%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;" colspan="3"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="4" class="heading" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Product Dimension</td> </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 25%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Weight</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 25%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;font-weight: bold">length('.$DimensionUnit.')</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 25%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;font-weight: bold">height('.$DimensionUnit.')</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 25%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;font-weight: bold;">breadth('.$DimensionUnit.')</td>
        </tr>
         <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 25%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">'.$productweight.'</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 25%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">'.$Length .'</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 25%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">'.$Height.'</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 25%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">'.$Width.'</td>
        </tr>
       </table>
     </td>
    </tr>
  <tr class="content">
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
  </tr>
</table></body></html>';
    
            
            $varEmailHead = '<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr><td>
            <span style="display:block; margin-bottom:10px">Dear '.$logisticname.',</span>
                    <p style="text-indent:40px">Following order is ready for your pickup at one of our partner location,
                    The details of order are as following :</p></td></tr></table>';
            $varEmailOrderDetails = str_replace('{EMAIL_HEAD}', $varEmailHead, $varEmailOrderDetails);
    
            $varSubject = 'Telamela : Logistic status';
            $varFrom = SITE_NAME;
          // $logisticmailid = 'antima.gupta@planetwebsolution.com';
          // $logisticmailid='avinesh.mathur@planetwebsolution.com';
    
            // Calling mail function
            $objCore->sendMail($logisticmailid, $varFrom, $varSubject, $varEmailOrderDetails);
    
            return 1;
        } else {
            return 0;
        }
    }
    
    function sendmailtologisticcompanyinprocessed($soID, $varPortalFilter,$logisticmailid,$logisticname,$status) {
    	// $logisticmailid='antima.gupta@planetwebsolution.com';
    	global $objCore;
    	global $arrProductImageResizes;
    
    	$arrRow = $this->editOrder($soID, $varPortalFilter);
    	$arrOrder = $arrRow['arrOrder'][0];
       $arrwholesaler = $arrRow['wholesaler'][0];
    	$arrCountryList = $arrRow['arrCountryList'];
    	$arrOrderItem = $arrRow['arrOrderItems'];
    	$arrOrderComment = $arrRow['arrOrderComments'];
    	$arrOrderTotal = $arrRow['arrOrderTotal'];
    	if (count($arrOrder) > 0) {
    
    
    		$varCustomerName = $arrOrder['CustomerFirstName'] . ' ' . $arrOrder['CustomerLastName'];
    		$varCustomerEmail = $arrOrder['CustomerEmail'];
    
    		$arrCols = array(
    				'fkOrderID' => $arrOrder['pkOrderID'],
    				'fkSubOrderID' => $arrOrderItem[0]['SubOrderID'],
    				'fkWholesalerID' => $arrOrderItem[0]['fkWholesalerID'],
    				'fkShippingIDs' => $arrOrderItem[0]['fkShippingIDs'],
    				'FromUserType' => $_SESSION['sessUserType'],
    				'FromUserID' => $_SESSION['sessUser'],
    				'ToUserType' => 'customer',
    				'ToUserID' => $arrOrder['fkCustomerID'],
    				'CustomerName' => $varCustomerName,
    				'CustomerEmail' => $varCustomerEmail,
    				'Amount' => $varTotal,
    				'AmountPayable' => $varTotal,
    				'AmountDue' => '0.0000',
    				'TransactionStatus' => 'Completed',
    				'InvoiceDetails' => $varEmailOrderDetails,
    				'OrderDateAdded' => $arrOrder['OrderDateAdded'],
    				'InvoiceDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
    		);
    		$Length=number_format($arrOrderItem[0]['Length'], 2, '.', '');
    		$Width=number_format($arrOrderItem[0]['Width'], 2, '.', '');
    		$Height=number_format($arrOrderItem[0]['Height'], 2, '.', '');
    		$DimensionUnit=$arrOrderItem[0]['DimensionUnit'];
    		$productweight=$objCore->convertproductweight($arrOrderItem[0]['WeightUnit'],$arrOrderItem[0]['Weight']).' '.'kg';
    		$varInvoiceDate = $objCore->serverDateTime($arrCols['InvoiceDateAdded'], DATE_FORMAT_SITE_FRONT);
    		$varInvoiceId = $this->insert(TABLE_INVOICE, $arrCols);
    
    		$wholesalercountryarray=$objCore->getCountrynamebyid($arrwholesaler['CompanyCountry']);
    		$wholesalercountry=$wholesalercountryarray[0]['name'];
    		//echo //$varEmailCSS = '<link href="' . ADMIN_CSS . '" rel="stylesheet" type="text/css" />';
    		$varEmailOrderDetails = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <link rel="shortcut icon" href="'. IMAGES_URL.'/favicon.ico" />
        <title>order status</title>
        <link href="' . CSS_PATH . 'invoice.css" rel="stylesheet" />
    </head>
    <body>{EMAIL_HEAD}
    
    
    
    <div class="dashboard_title" style="font-family:Arial, Helvetica, sans-serif; width: 99.3%;margin-bottom: 0px;color: #000;font-size: 18px;font-weight: bold;background-color: #FA990E;padding: 8px 4px 8px 5px;margin: 5px 0 0px 0;border-bottom: 1px #7986a9 solid;">Order Detail</div>
<table width="99%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; float: left;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;" class="left_content">
  <tr class="content">
    <td width="100%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif; border:0; text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;" colspan="3"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif; width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-bottom: none;border-right: none;">
    
    
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Order ID</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['pkOrderID'] . ' </td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Order Date</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $objCore->localDateTime($arrOrder['OrderDateAdded'], DATE_TIME_FORMAT_SITE) . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Order Status</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $status . '</td>
        </tr>
      </table></td>
    
  </tr>
  <tr class="content">
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif; border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
  </tr>
  <tr class="content">
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="2" class="heading" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Customer Information</td>
        </tr>
         <tr class="content">
          <td colspan="2" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Recipient First Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingFirstName'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Recipient Last Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingLastName'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Organization Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingOrganizationName'] . '&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Address Line 1:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingAddressLine1'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Address Line 2</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingAddressLine2'] . '&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Country</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingCountryName'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Post Code or Zip Code:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingPostalCode'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Phone:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingPhone'] . '</td>
        </tr>
      </table></td>
    <td width="2%" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="2" class="heading" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;"> Wholesaler Pickup Information </td>
        </tr>
        <tr class="content">
          <td colspan="2" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> CompanyName:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' .$arrwholesaler['CompanyName'] . '</td>
        </tr>
       
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Address Line 1:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrwholesaler['CompanyAddress1'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Address Line 2</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' .$arrwholesaler['CompanyAddress2'] . '&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Company City</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrwholesaler['CompanyCity'] . '</td>
        </tr>
        
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Country</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $wholesalercountry . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Post Code or Zip Code:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrwholesaler['CompanyPostalCode'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Phone:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrwholesaler['CompanyPhone'] . '</td>
        </tr>
      </table></td>
  </tr>
          		
          		
  <tr class="content">
    <td width="48%" colspan="3" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Sub Order Id</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Items Ordered</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Items Image</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;"> Shipping Price($)</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Qty.</td>
    
        </tr>
         '; $varSubTotal = 0;
    		$varShippingSubTotal = 0;
    		$varTotal = 0;
    		foreach ($arrOrderItem as $item) {
    
    			if ($item['ItemType'] == 'product') {
    				$path = 'products/' . $arrProductImageResizes['default'];
    			} else if ($item['ItemType'] == 'package') {
    				$path = 'package/' . PACKAGE_IMAGE_RESIZE1;
    			} else {
    				$path = 'gift_card';
    			}
    
    			$varSrc = $objCore->getImageUrl($item['ItemImage'], $path);
    
    			$varSubTotal += ($item['ItemSubTotal'] + $item['AttributePrice'] - $item['DiscountPrice']);
    			$varShippingSubTotal += $item['ShippingPrice'];
    			$varEmailOrderDetails .='
        <tr class="content">
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $item['SubOrderID'] . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . '<b>' . $item['ItemName'] . '</b><br/>' . $item['OptionDet'] . '<br>
            <br></td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> <img src="' . $varSrc . '" alt="' . $item['ItemName'] . '" style="font-family:Arial, Helvetica, sans-serif;float: none;border: none;" /></td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . number_format($item['ShippingPrice'], 2). '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $item['Quantity'] . '</td>
    
        </tr>
        ';
    		}
    
    		$varTotal = ($varSubTotal + $varShippingSubTotal);
    		$varEmailOrderDetails .='
      </table></td>
  </tr>
  <tr class="content">
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
  </tr>
  <tr class="content">
    <td width="100%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;" colspan="3"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="4" class="heading" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Product Dimension</td> </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 25%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Weight</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 25%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;font-weight: bold">length('.$DimensionUnit.')</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 25%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;font-weight: bold">height('.$DimensionUnit.')</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 25%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;font-weight: bold;">breadth('.$DimensionUnit.')</td>
        </tr>
         <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 25%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">'.$productweight.'</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 25%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">'.$Length .'</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 25%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">'.$Height.'</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 25%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">'.$Width.'</td>
        </tr>
       </table>
     </td>
    </tr>
  <tr class="content">
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
  </tr>
</table></body></html>';
    
    
    		$varEmailHead = '<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr><td>
            <span style="display:block; margin-bottom:10px">Dear '.$logisticname.',</span>
                    <p style="text-indent:40px">Following order is ready for your pickup at one of our partner location,
                    The details of order are as following :</p></td></tr></table>';
    		$varEmailOrderDetails = str_replace('{EMAIL_HEAD}', $varEmailHead, $varEmailOrderDetails);
    
    		$varSubject = 'Telamela : Logistic status';
    		$varFrom = SITE_NAME;
    		// $logisticmailid = 'antima.gupta@planetwebsolution.com';
    		//$logisticmailid='avinesh.mathur@planetwebsolution.com';
    
    		// Calling mail function
    		$objCore->sendMail($logisticmailid, $varFrom, $varSubject, $varEmailOrderDetails);
    
    		return 1;
    	} else {
    		return 0;
    	}
    }
    
    function sendmailtocustomershipped($soID, $varPortalFilter,$logisticmailid,$logisticname,$status) {
        // $logisticmailid='antima.gupta@planetwebsolution.com';
        global $objCore;
        global $arrProductImageResizes;
    
        $arrRow = $this->editOrder($soID, $varPortalFilter);
        $arrOrder = $arrRow['arrOrder'][0];
        $arrCountryList = $arrRow['arrCountryList'];
        $arrOrderItem = $arrRow['arrOrderItems'];
        $arrOrderComment = $arrRow['arrOrderComments'];
        $arrOrderTotal = $arrRow['arrOrderTotal'];
        if (count($arrOrder) > 0) {
    
    
            $varCustomerName = $arrOrder['CustomerFirstName'] . ' ' . $arrOrder['CustomerLastName'];
            $varCustomerEmail = $arrOrder['CustomerEmail'];
    
            $arrCols = array(
                    'fkOrderID' => $arrOrder['pkOrderID'],
                    'fkSubOrderID' => $arrOrderItem[0]['SubOrderID'],
                    'fkWholesalerID' => $arrOrderItem[0]['fkWholesalerID'],
                    'FromUserType' => $_SESSION['sessUserType'],
                    'FromUserID' => $_SESSION['sessUser'],
                    'ToUserType' => 'customer',
                    'ToUserID' => $arrOrder['fkCustomerID'],
                    'CustomerName' => $varCustomerName,
                    'CustomerEmail' => $varCustomerEmail,
                    'Amount' => $varTotal,
                    'AmountPayable' => $varTotal,
                    'AmountDue' => '0.0000',
                    'TransactionStatus' => 'Completed',
                    'InvoiceDetails' => $varEmailOrderDetails,
                    'OrderDateAdded' => $arrOrder['OrderDateAdded'],
                    'InvoiceDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );
    
            $varInvoiceDate = $objCore->serverDateTime($arrCols['InvoiceDateAdded'], DATE_FORMAT_SITE_FRONT);
            $varInvoiceId = $this->insert(TABLE_INVOICE, $arrCols);
    
    
    
            //echo //$varEmailCSS = '<link href="' . ADMIN_CSS . '" rel="stylesheet" type="text/css" />';
            $varEmailOrderDetails = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <link rel="shortcut icon" href="'. IMAGES_URL.'/favicon.ico" />
        <title>order status</title>
        <link href="' . CSS_PATH . 'invoice.css" rel="stylesheet" />
    </head>
    <body>{EMAIL_HEAD}
    
    
    
            <div class="dashboard_title" style="font-family:Arial, Helvetica, sans-serif; width: 99.3%;margin-bottom: 0px;color: #000;font-size: 18px;font-weight: bold;background-color: #FA990E;padding: 8px 4px 8px 5px;margin: 5px 0 0px 0;border-bottom: 1px #7986a9 solid;">Order Details</div>
<table width="99%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; float: left;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;" class="left_content">
  <tr class="content">
    <td width="100%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif; border:0; text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;" colspan="3"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif; width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-bottom: none;border-right: none;">
        
    
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Order ID</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['pkOrderID'] . ' </td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Order Date</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $objCore->localDateTime($arrOrder['OrderDateAdded'], DATE_TIME_FORMAT_SITE) . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Order Status</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $status . '</td>
        </tr>
      </table></td>
    
  </tr>
  <tr class="content">
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif; border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
  </tr>
  <tr class="content">
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"></td>
    <td width="2%" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"></td>
  </tr>
  <tr class="content">
    <td width="48%" colspan="3" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Sub Order Id</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Items Ordered</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Items Image</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Price($)</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Qty.</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">SubTotal($)</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Shipping($)</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Shipping Company</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Discount($)</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Grand Total($)</td>
        </tr>
         '; $varSubTotal = 0;
            $varShippingSubTotal = 0;
            $varTotal = 0;
            foreach ($arrOrderItem as $item) {
    
                if ($item['ItemType'] == 'product') {
                    $path = 'products/' . $arrProductImageResizes['default'];
                } else if ($item['ItemType'] == 'package') {
                    $path = 'package/' . PACKAGE_IMAGE_RESIZE1;
                } else {
                    $path = 'gift_card';
                }
    
                $varSrc = $objCore->getImageUrl($item['ItemImage'], $path);
    
                $varSubTotal += ($item['ItemSubTotal'] + $item['AttributePrice'] - $item['DiscountPrice']);
                $varShippingSubTotal += $item['ShippingPrice'];
                $varEmailOrderDetails .='
        <tr class="content">
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $item['SubOrderID'] . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . '<b>' . $item['ItemName'] . '</b><br/>' . $item['OptionDet'] . '<br>
            <br></td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> <img src="' . $varSrc . '" alt="' . $item['ItemName'] . '" style="font-family:Arial, Helvetica, sans-serif;float: none;border: none;" /></td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . number_format(($item['ItemPrice'] + ($item['AttributePrice'] / $item['Quantity'])), 2) . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $item['Quantity'] . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . number_format(($item['ItemSubTotal'] + $item['AttributePrice']), 2) . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . number_format($item['ShippingPrice'], 2) . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $logisticname . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . number_format($item['DiscountPrice'], 2) . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . number_format($item['ItemTotalPrice'], 2) . '</td>
        </tr>
        ';
            }
    
            $varTotal = ($varSubTotal + $varShippingSubTotal);
            $varEmailOrderDetails .='
      </table></td>
  </tr>
  <tr class="content">
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
  </tr>
  <tr class="content">
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
    
      </table></td>
    <td width="2%" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"></td>
  </tr>
  <tr class="content">
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
  </tr>
</table></body></html>';
    
    
            $varEmailHead = '<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr><td>
            <span style="display:block; margin-bottom:10px">Dear '.$varCustomerName.' ,</span>
                    <p style="text-indent:40px">Your order is shipped to your destination, The details of order are as following:</p></td></tr></table>';
            $varEmailOrderDetails = str_replace('{EMAIL_HEAD}', $varEmailHead, $varEmailOrderDetails);
    
            $varSubject = 'Telamela : Order Status.';
            $varFrom = SITE_NAME;
    
    
            // Calling mail function
            // $logisticmailid='avinesh.mathur@planetwebsolution.com';
       //$varCustomerEmail = 'avinesh.mathur@planetwebsolution.com';
            $objCore->sendMail($varCustomerEmail, $varFrom, $varSubject, $varEmailOrderDetails);
    
            return 1;
        } else {
            return 0;
        }
    }
    
    function sendmailtocustomerdelievered($soID, $varPortalFilter,$logisticmailid,$logisticname,$status) {
        // $logisticmailid='antima.gupta@planetwebsolution.com';
        global $objCore;
        global $arrProductImageResizes;
    
        $arrRow = $this->editOrder($soID, $varPortalFilter);
        $arrOrder = $arrRow['arrOrder'][0];
        $arrCountryList = $arrRow['arrCountryList'];
        $arrOrderItem = $arrRow['arrOrderItems'];
        $arrOrderComment = $arrRow['arrOrderComments'];
        $arrOrderTotal = $arrRow['arrOrderTotal'];
        if (count($arrOrder) > 0) {
    
    
            $varCustomerName = $arrOrder['CustomerFirstName'] . ' ' . $arrOrder['CustomerLastName'];
            $varCustomerEmail = $arrOrder['CustomerEmail'];
    
            $arrCols = array(
                    'fkOrderID' => $arrOrder['pkOrderID'],
                    'fkSubOrderID' => $arrOrderItem[0]['SubOrderID'],
                    'fkWholesalerID' => $arrOrderItem[0]['fkWholesalerID'],
                    'FromUserType' => $_SESSION['sessUserType'],
                    'FromUserID' => $_SESSION['sessUser'],
                    'ToUserType' => 'customer',
                    'ToUserID' => $arrOrder['fkCustomerID'],
                    'CustomerName' => $varCustomerName,
                    'CustomerEmail' => $varCustomerEmail,
                    'Amount' => $varTotal,
                    'AmountPayable' => $varTotal,
                    'AmountDue' => '0.0000',
                    'TransactionStatus' => 'Completed',
                    'InvoiceDetails' => $varEmailOrderDetails,
                    'OrderDateAdded' => $arrOrder['OrderDateAdded'],
                    'InvoiceDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );
    
            $varInvoiceDate = $objCore->serverDateTime($arrCols['InvoiceDateAdded'], DATE_FORMAT_SITE_FRONT);
            $varInvoiceId = $this->insert(TABLE_INVOICE, $arrCols);
    
    
    
            //echo //$varEmailCSS = '<link href="' . ADMIN_CSS . '" rel="stylesheet" type="text/css" />';
            $varEmailOrderDetails = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <link rel="shortcut icon" href="'. IMAGES_URL.'/favicon.ico" />
        <title>order status</title>
        <link href="' . CSS_PATH . 'invoice.css" rel="stylesheet" />
    </head>
    <body>{EMAIL_HEAD}
    
    
    
            <div class="dashboard_title" style="font-family:Arial, Helvetica, sans-serif; width: 99.3%;margin-bottom: 0px;color: #000;font-size: 13px;font-weight: bold;background-color: #FA990E;padding: 5px 4px 5px 5px;margin: 5px 0 0px 0;border-bottom: 1px #7986a9 solid;">Customer Invoice <span style="float: right;margin-right: 10px;font-size: 12px;font-weight: normal;"><a href="javascript:void(0)" onClick="window.print();" style="color:black" class="noPrint">Print</a></span></div>
<table width="99%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; float: left;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;" class="left_content">
  <tr class="content">
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif; border:0; text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif; width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="2" class="heading" style="font-family:Arial, Helvetica, sans-serif; text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Order Details </td>
        </tr>
        <tr class="content">
          <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Order ID</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['pkOrderID'] . ' </td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Order Date</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $objCore->localDateTime($arrOrder['OrderDateAdded'], DATE_TIME_FORMAT_SITE) . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Order Status</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $status . '</td>
        </tr>
      </table></td>
    <td width="2%" style="font-family:Arial, Helvetica, sans-serif; border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif; border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif; width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="2" class="heading" style="font-family:Arial, Helvetica, sans-serif; text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Account Information</td>
        </tr>
        <tr class="content">
          <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Customer Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['CustomerFirstName'] . ' ' . $arrOrder['CustomerLastName'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Email:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['CustomerEmail'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Phone</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['CustomerPhone'] . '</td>
        </tr>
      </table></td>
  </tr>
  <tr class="content">
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif; border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
  </tr>
  <tr class="content">
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="2" class="heading" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Billing Information</td>
        </tr>
        <tr class="content">
          <td colspan="2" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Recipient First Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['BillingFirstName'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Recipient Last Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['BillingLastName'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Organization Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['BillingOrganizationName'] . '&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Address Line 1:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['BillingAddressLine1'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Address Line 2</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['BillingAddressLine2'] . '&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Country</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['BillingCountryName'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Post Code or Zip Code:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['BillingPostalCode'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Phone:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['BillingPhone'] . '</td>
        </tr>
      </table></td>
    <td width="2%" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="2" class="heading" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Shipping Information</td>
        </tr>
        <tr class="content">
          <td colspan="2" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Recipient First Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingFirstName'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Recipient Last Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingLastName'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Organization Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingOrganizationName'] . '&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Address Line 1:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingAddressLine1'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Address Line 2</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingAddressLine2'] . '&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Country</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingCountryName'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Post Code or Zip Code:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingPostalCode'] . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Phone:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $arrOrder['ShippingPhone'] . '</td>
        </tr>
      </table></td>
  </tr>
  <tr class="content">
    <td width="48%" colspan="3" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Sub Order Id</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Items Ordered</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Items Image</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Price($)</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Qty.</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">SubTotal($)</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Shipping($)</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Discount($)</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Grand Total($)</td>
        </tr>
         '; $varSubTotal = 0;
            $varShippingSubTotal = 0;
            $varTotal = 0;
            foreach ($arrOrderItem as $item) {
    
                if ($item['ItemType'] == 'product') {
                    $path = 'products/' . $arrProductImageResizes['default'];
                } else if ($item['ItemType'] == 'package') {
                    $path = 'package/' . PACKAGE_IMAGE_RESIZE1;
                } else {
                    $path = 'gift_card';
                }
    
                $varSrc = $objCore->getImageUrl($item['ItemImage'], $path);
    
                $varSubTotal += ($item['ItemSubTotal'] + $item['AttributePrice'] - $item['DiscountPrice']);
                $varShippingSubTotal += $item['ShippingPrice'];
                $varEmailOrderDetails .='
        <tr class="content">
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $item['SubOrderID'] . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . '<b>' . $item['ItemName'] . '</b><br/>' . $item['OptionDet'] . '<br>
            <br></td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> <img src="' . $varSrc . '" alt="' . $item['ItemName'] . '" style="font-family:Arial, Helvetica, sans-serif;float: none;border: none;" /></td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . number_format(($item['ItemPrice'] + ($item['AttributePrice'] / $item['Quantity'])), 2) . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . $item['Quantity'] . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . number_format(($item['ItemSubTotal'] + $item['AttributePrice']), 2) . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . number_format($item['ShippingPrice'], 2) . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . number_format($item['DiscountPrice'], 2) . '</td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . number_format($item['ItemTotalPrice'], 2) . '</td>
        </tr>
        ';
            }
    
            $varTotal = ($varSubTotal + $varShippingSubTotal);
            $varEmailOrderDetails .='
      </table></td>
  </tr>
  <tr class="content">
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
  </tr>
  <tr class="content">
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
    
      </table></td>
    <td width="2%" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="2" class="heading" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Order Totals</td>
    
        </tr>
        ';
    
    
            foreach ($arrOrderComment as $vc) {
                $varEmailOrderDetails .= '<p>' . $vc['Comment'] . '</p><p align="right"><b> - ' . $vc[$vc['CommentedBy'] . 'Name'] . ' (' . ucwords($vc['CommentedBy']) . ') </b></p>';
            }
    
            $varEmailOrderDetails .= '
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Sub Total($)</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . ADMIN_CURRENCY_SYMBOL . number_format($varSubTotal, 2, ".", ",") . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Shipping Charge($)</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . ADMIN_CURRENCY_SYMBOL . number_format($varShippingSubTotal, 2, ".", ",") . '</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Total($)</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">' . ADMIN_CURRENCY_SYMBOL . number_format($varTotal, 2, ".", ",") . '</td>
        </tr>';
    
            if ($varDescription) {

                $varEmailOrderDetails = '<tr class="content"><td class="admin_left_text">Description</td><td class="admin_left_input">' . $varDescription . '</td></tr>';
            }
    
            $varEmailOrderDetails .='
      </table></td>
  </tr>
  <tr class="content">
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
  </tr>
</table></body></html>';
    
    
            $varEmailHead = '<table width="100%" cellspacing="0" cellpadding="5" border="0"><tr><td>
            <span style="display:block; margin-bottom:10px">Dear '.$varCustomerName.' ,</span>
                    <p style="text-indent:40px">We are happy to inform you that your order has been successfully delivered. You can view Order details here:</p></td></tr></table>';
            $varEmailOrderDetails = str_replace('{EMAIL_HEAD}', $varEmailHead, $varEmailOrderDetails);
    
            $varSubject = 'Telamela :  Order Status.';
            $varFrom = SITE_NAME;
    
    
            // Calling mail function
            $objCore->sendMail($varCustomerEmail, $varFrom, $varSubject, $varEmailOrderDetails);
    
            return 1;
        } else {
            return 0;
        }
    }
    
    /**
     * function addShipment
     *
     * This function is used to add Shipment.
     *
     * Database Tables used in this function are : tbl_shipment
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objOrder->addShipment($arrPost)
     */
    function addShipment($arrPost) {
        global $objCore;

        $rrField = array('fkSubOrderID' => trim(stripcslashes($arrPost['shipment_suborderid'])),
            'fkShippingCarrierID' => trim(stripcslashes($arrPost['snipat_career'])),
            'TransactionNo' => trim(stripcslashes($arrPost['tranjection_id'])),
            'ShippingStatus' => trim(stripcslashes($arrPost['spnipat_status'])),
            'OrderDate' => date('Y-m-d 00:00:00', strtotime($arrPost['iDateFrom'])),
            'ShippedDate' => date('Y-m-d 00:00:00', strtotime($arrPost['iDateTo'])),
            'DateAdded' => 'now()');

        $inser = $this->insert(TABLE_SHIPMENT, $rrField);

        if ($inser) {

            $objCore->setSuccessMsg(SHIPMENT_ADD_SUCCESS);
            return true;
        }
    }

    /**
     * function shipmentRow
     *
     * This function is used to display Shipment.
     *
     * Database Tables used in this function are : tbl_shipment, tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $query
     *
     * User instruction: $objOrder->shipmentRow($shippId)
     */
    function shipmentRow($shippId) {

        $varArr = array('pkShipmentID', 'fkOrderItemID', 'fkShippingCarrierID', 'TransactionNo', 'ship.ShippingStatus', 'OrderDate', 'ShippedDate', 'pkShippingGatewaysID', 'ShippingTitle');

        $where = "fkOrderItemID='" . trim($shippId) . "'";

        $table = TABLE_SHIPMENT . ' as ship LEFT JOIN ' . TABLE_SHIP_GATEWAYS . ' as shipGat on ship.fkShippingCarrierID=shipGat.pkShippingGatewaysID';

        $query = $this->select($table, $varArr, $where);

        return $query;
    }
    
    function wholesalercountryportal($countryid) {
    
        $varArr = array('pkAdminID');
    
        $where = "AdminCountry='" . trim($countryid) . "'";
        $table=TABLE_ADMIN;
    
        //$table = TABLE_SHIPMENT . ' as ship LEFT JOIN ' . TABLE_SHIP_GATEWAYS . ' as shipGat on ship.fkShippingCarrierID=shipGat.pkShippingGatewaysID';
    
        $query = $this->select($table, $varArr, $where);
    
        return $query;
    }
    
    function wholesaleridshippingid($pkOrderItemID) {
    
        $varArr = array('fkWholesalerID,fkShippingIDs');
    
        $where = "pkOrderItemID='" . trim($pkOrderItemID) . "'";
        $table=tbl_order_items;
    
        //$table = TABLE_SHIPMENT . ' as ship LEFT JOIN ' . TABLE_SHIP_GATEWAYS . ' as shipGat on ship.fkShippingCarrierID=shipGat.pkShippingGatewaysID';
    
        $query = $this->select($table, $varArr, $where);
    
        return $query;
    }
    
    function wholesalercountry($wholesalerid) {
    
        $varArr = array('CompanyCountry');
    
        $where = "pkWholesalerID='" . trim($wholesalerid) . "'";
        $table=TABLE_WHOLESALER;
    
        //$table = TABLE_SHIPMENT . ' as ship LEFT JOIN ' . TABLE_SHIP_GATEWAYS . ' as shipGat on ship.fkShippingCarrierID=shipGat.pkShippingGatewaysID';
    
        $query = $this->select($table, $varArr, $where);
    
        return $query;
    }
    
    function getwaymailidusingportal($portalid,$shippingid) {
    
        $varArr = array('gatewayEmail');
    
        $where = "fkportalID='" . trim($portalid) . "' And fkgatewayID = '".$shippingid."'";
        $table=TABLE_GATEWAYS_PORTAL;
    
        //$table = TABLE_SHIPMENT . ' as ship LEFT JOIN ' . TABLE_SHIP_GATEWAYS . ' as shipGat on ship.fkShippingCarrierID=shipGat.pkShippingGatewaysID';
    
        $query = $this->select($table, $varArr, $where);
    
        return $query;
    }

    /**
     * function deleteShipment
     *
     * This function is used to delete Shipment.
     *
     * Database Tables used in this function are : tbl_shipment
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objOrder->deleteShipment($sId)
     */
    function deleteShipment($sId) {

        global $objCore;

        $table = TABLE_SHIPMENT;
        $where = "pkShipmentID='" . trim($sId) . "'";
        $query = $this->delete($table, $where);

        if ($query) {

            $objCore->setSuccessMsg(SHIPMENT_DELETE_SUCCESS);
            return true;
        }
    }

    /**
     * function editShipment
     *
     * This function is used to update Shipment.
     *
     * Database Tables used in this function are : tbl_shipment
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string
     */
    function updateShipment($arrPost) {
       //pre($arrPost);
        global $objCore;
        //pre('3453');
        $arrCols = array(
            'fkOrderItemID' => $arrPost['frmOrderItemID'],
            'fkShippingCarrierID' => $arrPost['frmShipmentGatways'],
            'TransactionNo' => $arrPost['frmTransactionNo'],
                'Trackingid' => $arrPost['frmTrackingNo'],
                'Trackingurl' => $arrPost['frmTrackingemail'],
            'ShippingStatus' => $arrPost['frmShippingStatus'],
            'OrderDate' => $objCore->serverDateTime($arrPost['frmOrderDateAdded'], DATE_TIME_FORMAT_DB),
            'ShipStartDate' => $objCore->serverDateTime($arrPost['frmDateFrom'], DATE_TIME_FORMAT_DB),
            'ShippedDate' => $objCore->serverDateTime($arrPost['frmDateTo'], DATE_TIME_FORMAT_DB)
        );
       // pre($arrCols);
        
        $dataarray= array(
                'status' => $arrPost['frmShippingStatus'],
                'soid' => $arrPost['suborderid'],
                'gatwaymailid' => $arrPost['gatewaymail'],
                'gatwayname' => $arrPost['ShippingTitle'],
        );
        
        if(!empty($arrPost['frmShippingStatus']))
        {
            $this->updateOrderStatus($dataarray);
        }
        //suborderid

        if ($arrPost['frmShipmentID'] <> '') {
            $varWhr = "pkShipmentID='" . $arrPost['frmShipmentID'] . "' ";
            $varNum = $this->update(TABLE_SHIPMENT, $arrCols, $varWhr);
            if ($varNum > 0) {
                $objCore->setSuccessMsg(SHIPMENT_UPDATE_SUCCESS);
            } else {
                $objCore->setErrorMsg(SHIPMENT_UPDATE_ERROR);
            }
        } else {
            $varNum = $this->insert(TABLE_SHIPMENT, $arrCols);
            if ($varNum > 0) {
                $objCore->setSuccessMsg(SHIPMENT_ADD_SUCCESS);
            } else {
                $objCore->setErrorMsg(SHIPMENT_ADD_ERROR);
            }
        }
        
        
        return true;
    }

    /**
     * function editShipment
     *
     * This function is used to edit the Shipment.
     *
     * Database Tables used in this function are : tbl_shipment
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objOrder->editShipment($arrPost)
     */
    function editShipment($arrPost) {

        global $objCore;


       // pre($arrPost);

        $rrField = array('fkSubOrderID' => trim(stripcslashes($arrPost['shipment_suborderid_edit'])),
            'fkShippingCarrierID' => trim(stripcslashes($arrPost['snipat_career_edit'])),
            'TransactionNo' => trim(stripcslashes($arrPost['tranjection_id_edit'])),
            'ShippingStatus' => trim(stripcslashes($arrPost['spnipat_status_edit'])),
            'OrderDate' => date('Y-m-d 00:00:00', strtotime($arrPost['iDateFrom_edit'])),
            'ShippedDate' => date('Y-m-d 00:00:00', strtotime($arrPost['iDateTo_edit'])),
            'DateAdded' => 'now()');


        $where = "pkShipmentID='" . trim($arrPost['shipment_id']) . "'";

        $inser = $this->update(TABLE_SHIPMENT, $rrField, $where);

        if ($inser) {

            $objCore->setSuccessMsg(SHIPMENT_UPDATE_SUCCESS);
            return true;
        }
    }

}

?>