<?php

/**
 * Site OrderProcess Class
 *
 * This is the OrderProcess class that will used on website for Order Process.
 *
 * DateCreated 5th August, 2013
 *
 * DateLastModified 18th August, 2013
 *
 * @copyright Copyright (C) 2010-2012 Vinove Software and Services
 *
 * @version 10.0
 */
class OrderProcess extends Database {

    function __construct() {

        //$objCore = new Core();
        //default constructor for this class
    }

    /**
     * function CustomerDetails
     *
     * This function is used CustomerDetails.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 $String
     *
     * @return array $arrRes
     */
    function CustomerDetails($argCustomerId) {
        $arrClms = array(
            '*',
            'pkCustomerID',
            'CustomerFirstName',
            'CustomerLastName',
            'CustomerEmail',
            'BillingFirstName',
            'BillingLastName',
            'BillingOrganizationName',
            'BillingAddressLine1',
            'BillingAddressLine2',
            'BillingCountry',
            'BillingPostalCode',
            'BillingPhone',
            'ShippingFirstName',
            'ShippingLastName',
            'ShippingOrganizationName',
            'ShippingAddressLine1',
            'ShippingAddressLine2',
            'ShippingCountry',
            'ShippingPostalCode',
            'ShippingPhone',
            'BusinessAddress'
        );
        $argWhere = "pkCustomerID='" . $argCustomerId . "' ";
        $arrRes = $this->select(TABLE_CUSTOMER, $arrClms, $argWhere);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function attributeDetails
     *
     * This function is used attributeDetails.
     *
     * Database Tables used in this function are : tbl_attribute
     *
     * @access public
     *
     * @parameters $argAttrID
     *
     * @return array $arrRes
     */
    function attributeDetails($argAttrID) {
        $arrClms = array(
            'pkAttributeID',
            'AttributeCode',
            'AttributeLabel',
            'AttributeInputType'
        );

        $varTable = TABLE_ATTRIBUTE;
        $argWhere = "pkAttributeID='$argAttrID' ";
        $arrRes = $this->select($varTable, $arrClms, $argWhere);
        // pre($arrRes);
        return $arrRes;
    }

    
    function GetAdminEmail($email){
        
        $arrClms = array(
            'AdminCountry',
            'AdminRegion',
            'AdminEmail',
        );

        $varTable = TABLE_ADMIN;
        $argWhere = "PaypalEmailID='$email' " ;
        return $arrRes = $this->select($varTable, $arrClms, $argWhere);
        //pre($arrRes);
    }
    
    function GetWhCountry($id){
        
        $arrClms = array(
            'CompanyCountry',
        );

        $varTable = TABLE_WHOLESALER;
        $argWhere = "pkWholesalerID='$id' " ;
        $arrRes = $this->select($varTable, $arrClms, $argWhere);
        //pre($arrRes);
        return $arrRes[0];
    }
    
    function wholesalercountryportalfront($countryid) {
    
    	$varArr = array('pkAdminID');
    
    	$where = "AdminCountry='" . trim($countryid) . "'";
    	$table=TABLE_ADMIN;
    
    	//$table = TABLE_SHIPMENT . ' as ship LEFT JOIN ' . TABLE_SHIP_GATEWAYS . ' as shipGat on ship.fkShippingCarrierID=shipGat.pkShippingGatewaysID';
    
    	$query = $this->select($table, $varArr, $where);
    
    	return $query;
    }
    
    function getwaymailidusingportalfront($portalid,$shippingid) {
    
    	$varArr = array('gatewayEmail');
    
    	$where = "fkportalID='" . trim($portalid) . "' And fkgatewayID = '".$shippingid."'";
    	$table=TABLE_GATEWAYS_PORTAL;
    
    	//$table = TABLE_SHIPMENT . ' as ship LEFT JOIN ' . TABLE_SHIP_GATEWAYS . ' as shipGat on ship.fkShippingCarrierID=shipGat.pkShippingGatewaysID';
    
    	$query = $this->select($table, $varArr, $where);
    
    	return $query;
    }
    /**
     * function attributeOptDetails
     *
     * This function is used attributeOptDetails.
     *
     * Database Tables used in this function are : tbl_product_to_option
     *
     * @access public
     *
     * @parameters $argAttrID
     *
     * @return array $arrRes
     */
    function attributeOptDetails($pid, $argAttrOptID) {
        $arrIds = explode(',', $argAttrOptID);

        foreach ($arrIds as $k => $v) {
            if ($v == '') {
                unset($arrIds[$k]);
            }
        }


        $varIds = implode(',', $arrIds);

        if ($varIds) {
            $query = "SELECT fkAttributeId, group_concat(AttributeOptionValue SEPARATOR '@@@') as OptionValue,sum(OptionExtraPrice) as OptionExtraPrice FROM " . TABLE_PRODUCT_TO_OPTION . " WHERE fkProductId='" . $pid . "' AND fkAttributeOptionId in (" . $varIds . ") GROUP BY fkAttributeId";
            $arrRes = $this->getArrayResult($query);
        }
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function packageDetails
     *
     * This function is used packageDetails.
     *
     * Database Tables used in this function are : tbl_package
     *
     * @access public
     *
     * @parameters $argPkgID
     *
     * @return array $arrRes
     */
    function packageDetails($argPkgID) {
        $arrClms = array(
            'pkPackageId',
            'PackageName',
            'PackagePrice',
        );
        $varTable = TABLE_PACKAGE;
        $argWhere = "pkPackageId='$argPkgID' ";
        $arrRes = $this->select($varTable, $arrClms, $argWhere);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function productDetails
     *
     * This function is used productDetails.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters $argProIDs
     *
     * @return array $arrRes
     */
    function productDetails($argProIDs) {

        $arrClms = array(
            'pkProductID',
            'ProductRefNo',
            'ProductName'
        );
        $varTable = TABLE_PRODUCT;
        $argWhere = "pkProductID in ($argProIDs) ";
        $arrRes = $this->select($varTable, $arrClms, $argWhere);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function orderTotal
     *
     * This function is used orderTotal.
     *
     * Database Tables used in this function are : tbl_order_items
     *
     * @access public
     *
     * @parameters $argOrderID
     *
     * @return array $arrRows
     */
    function orderTotal($argOrderID) {

        $arrSubTotal = $this->getArrayResult("SELECT sum(ItemSubTotal+AttributePrice) as TotalPrice FROM " . TABLE_ORDER_ITEMS . " WHERE fkOrderID ='" . $argOrderID . "'");
        $arrShippingTotal = $this->getArrayResult("SELECT sum(ShippingPrice) as TotalPrice FROM " . TABLE_ORDER_ITEMS . " WHERE fkOrderID ='" . $argOrderID . "'");
        $arrDiscountTotal = $this->getArrayResult("SELECT sum(DiscountPrice) as TotalPrice FROM " . TABLE_ORDER_ITEMS . " WHERE fkOrderID ='" . $argOrderID . "'");

        $arrSubTotalPoints = $this->getArrayResult("SELECT sum(ItemSubTotal) as TotalPrice FROM " . TABLE_ORDER_ITEMS . " WHERE fkOrderID ='" . $argOrderID . "'");

        $arrRows = array(
            'sub-total' => $arrSubTotal[0]['TotalPrice'],
            'shipping' => $arrShippingTotal[0]['TotalPrice'],
            'coupon' => $arrDiscountTotal[0]['TotalPrice'],
            'OrderTotalPoints' => $arrSubTotalPoints[0]['TotalPrice']
        );


        return $arrRows;
    }

    /**
     * function addOrder
     *
     * This function is used addOrder.
     *
     * Database Tables used in this function are : tbl_order, tbl_customer
     *
     * @access public
     *
     * @parameters $arrPost
     *
     * @return String $arrAddID
     */
    function addOrder($arrPost, $txnID, $paymentAmount) {
        global $objCore;
        $arrClms = array(
            'TransactionID' => $txnID,
            'TransactionAmount' => $paymentAmount,
            'fkCustomerID' => $arrPost['pkCustomerID'],
            'CustomerFirstName' => $arrPost['CustomerFirstName'],
            'CustomerLastName' => $arrPost['CustomerLastName'],
            'CustomerEmail' => $arrPost['CustomerEmail'],
            'CustomerPhone' => $arrPost[$arrPost['BusinessAddress'] . 'Phone'],
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
            'OrderDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
        );
        $arrAddID = $this->insert(TABLE_ORDER, $arrClms);

        if ($arrAddID > 0) {
            $arrPurchased = $this->select(TABLE_CUSTOMER, array('Purchased'), " pkCustomerID = '" . $arrPost['pkCustomerID'] . "' ");
            $varPurchased = $arrPurchased[0]['Purchased'] + $_SESSION['MyCart']['Total'];
            $this->update(TABLE_CUSTOMER, array('Purchased' => $varPurchased), " pkCustomerID = '" . $arrPost['pkCustomerID'] . "' ");
        }

        return $arrAddID;
    }

    /**
     * function addGiftCard
     *
     * This function is used addGiftCard.
     *
     * Database Tables used in this function are : tbl_gift_card, tbl_gift_card_delivery_date
     *
     * @access public
     *
     * @parameters $arrClms,$argDeliveryDates
     *
     * @return String $arrAddID
     */
    function addGiftCard($arrClms, $argDeliveryDates) {

        $arrAddID = $this->insert(TABLE_GIFT_CARD, $arrClms);

        $arrDeliveryDates = explode(',', $argDeliveryDates);

        foreach ($arrDeliveryDates as $k => $v) {
            if ($v <> '') {
                $varDate = date(DATE_TIME_FORMAT_DB, strtotime($v));
                $this->insert(TABLE_GIFT_CARD_DELIVERY_DATE, array('fkGiftCardID' => $arrAddID, 'DeliveryDate' => $varDate));
            }
        }

        $varGiftCardCode = $this->uniqueGiftCardCode();

        $this->update(TABLE_GIFT_CARD, array('GiftCardCode' => $varGiftCardCode), " pkGiftCardID = '" . $arrAddID . "' ");


        return $arrAddID;
    }

    /**
     * function addOrderComment
     *
     * This function is used addOrderComment.
     *
     * Database Tables used in this function are : tbl_order_comments
     *
     * @access public
     *
     * @parameters $arrClms
     *
     * @return String $arrAddID
     */
    function addOrderComment($arrClms) {
        $arrAddID = $this->insert(TABLE_ORDER_COMMENTS, $arrClms);
        return $arrAddID;
    }

    /**
     * function addOrderItems
     *
     * This function is used addOrderItems.
     *
     * Database Tables used in this function are : tbl_order_items
     *
     * @access public
     *
     * @parameters $arrClms
     *
     * @return String $arrAddID
     */
    function addOrderItems($arrClms, $arrOptions = array()) {

        $arrAddID = $this->insert(TABLE_ORDER_ITEMS, $arrClms);
        if ($arrClms['ItemType'] <> 'gift-card') {
            $this->UpdateProduct($arrClms['ItemType'], $arrClms['fkItemID'], $arrClms['Quantity'], $arrOptions);
        }
        return $arrAddID;
    }
    
    function addlogisticinvoice($arrClms, $arrOptions = array()) {
    
    	$arrAddID = $this->insert(TABLE_LOGISTICINVOICE, $arrClms);
//        pre($arrAddID);
//     	if ($arrClms['ItemType'] <> 'gift-card') {
//     		$this->UpdateProduct($arrClms['ItemType'], $arrClms['fkItemID'], $arrClms['Quantity'], $arrOptions);
//     	}
    	return $arrAddID;
    }

    /**
     * function addOrderOption
     *
     * This function is used addOrderOption.
     *
     * Database Tables used in this function are : tbl_order_option
     *
     * @access public
     *
     * @parameters 1 $arrClms
     *
     * @return String $arrAddID
     */
    function addOrderOption($arrClms) {
        $arrAddID = $this->insert(TABLE_ORDER_OPTION, $arrClms);
        return $arrAddID;
    }

    /**
     * function addOrderTotal
     *
     * This function is used addOrderTotal.
     *
     * Database Tables used in this function are : tbl_order_total
     *
     * @access public
     *
     * @parameters 1 $arrClms
     *
     * @return String $arrAddID
     */
    function addOrderTotal($arrClms) {
        $arrAddID = $this->insert(TABLE_ORDER_TOTAL, $arrClms);
        return $arrAddID;
    }

    /**
     * function deleteFromCart
     *
     * This function is used for delete cart data after success full payment.
     *
     * Database Tables used in this function are : tbl_cart
     *
     * @access public
     *
     * @parameters 1
     *
     * @return String $dlQuery
     */
    function deleteFromCart($custID = '') {

        $tableName = TABLE_CART;
        $where = "fkCustomerID=" . $custID;

        $dlQuery = $this->delete($tableName, $where);

        return $dlQuery;
    }

    /**
     * function productDetailsWithId
     *
     * This function is used for get seleted data from product table.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1
     *
     * @return String $arrRes
     */
    function productDetailsWithId($productID = '') {

        $arrClms = array(
            'pkProductID',
            'ProductRefNo',
            'ProductName',
            'fkShippingID',
            'fkWholesalerID', 'Quantity', 'QuantityAlert', 'ProductImage'
        );
        $varTable = TABLE_PRODUCT;
        $argWhere = "pkProductID =" . $productID;
        $arrRes = $this->select($varTable, $arrClms, $argWhere);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function uniqueGiftCardCode
     *
     * This function is used uniqueGiftCardCode.
     *
     * Database Tables used in this function are : tbl_gift_card
     *
     * @access public
     *
     * @parameters 0
     *
     * @return String $varGiftCode
     */
    function uniqueGiftCardCode() {

        $varCharSets = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $varShuffle = str_shuffle($varCharSets);

        $varGiftCode = substr($varShuffle, 0, 7);

        $arrRes = $this->select(TABLE_GIFT_CARD, array('GiftCardCode'), " GiftCardCode = '" . $varGiftCode . "' ");
        if ($arrRes) {
            $this->uniqueGiftCardCode();
        } else {

            return $varGiftCode;
        }
    }

    /**
     * function GetOrderDetails
     *
     * This function is used GetOrderDetails.
     *
     * Database Tables used in this function are : tbl_order, tbl_country
     *
     * @access public
     *
     * @parameters 1 $argOrderID
     *
     * @return array $arrRes
     */
    function GetOrderDetails($argOrderID) {
        /*
          $arrClms = array('pkOrderID', 'TransactionID', 'CustomerFirstName', 'CustomerLastName', 'CustomerEmail', 'CustomerPhone');
          $argWhere = "pkOrderID='" . $argOrderID . "' ";
          $arrRes = $this->select(TABLE_ORDER, $arrClms, $argWhere);
         */
        $arrClms = array('a.*', 'd.name as BillingCountryName', 'e.name as ShipingCountryName');
        $varTable = TABLE_ORDER . ' as a LEFT JOIN ' . TABLE_COUNTRY . ' as d ON d.country_id=a.BillingCountry LEFT JOIN ' . TABLE_COUNTRY . ' as e ON e.country_id=a.ShippingCountry';
        $varID = "pkOrderID = '" . $argOrderID . "' ";
        $arrRes = $this->select($varTable, $arrClms, $varID);

        //  pre($arrRes);
        return $arrRes;
    }

    /**
     * function GetItemDetails
     *
     * This function is used GetItemDetails.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_order_option, tbl_product, tbl_package
     *
     * @access public
     *
     * @parameters 1 $argWhere
     *
     * @return array $arrRes
     */
    function GetItemDetails($argWhere) {
        $arrClms = array('pkOrderItemID', 'SubOrderID','fkShippingIDs', 'ItemType', 'ItemName', 'ItemPrice', 'ItemImage', 'AttributePrice', 'Quantity', 'ShippingPrice', 'DiscountPrice', 'ItemDetails', 'ItemTotalPrice', 'fkItemID');
        $arrRes = $this->select(TABLE_ORDER_ITEMS, $arrClms, $argWhere);

        foreach ($arrRes as $k => $v) {
            if ($v['ItemType'] <> 'gift-card') {
                $jsonDet = json_decode(html_entity_decode($v['ItemDetails']));
                $varDet = '';
                foreach ($jsonDet as $jk => $jv) {

                    $arrCols = array('AttributeLabel', 'OptionValue');
                    $argWhr = " fkOrderItemID = '" . $v['pkOrderItemID'] . "' AND fkProductID = '" . $jv->pkProductID . "'";
                    $arrOpt = $this->select(TABLE_ORDER_OPTION, $arrCols, $argWhr);
                    $optNum = count($arrOpt);
                    if ($optNum > 0 || $v['ItemType'] == 'package') {
                        $varDet .= $jv->ProductName;
                    }


                    if ($optNum) {
                        $varDet .= ' (';
                        $i = 1;
                        foreach ($arrOpt as $ok => $ov) {
                            $varDet .= $ov['AttributeLabel'] . ': ' . str_replace('@@@', ',', $ov['OptionValue']);
                            if ($i < $optNum)
                                $varDet .=' | ';
                            $i++;
                        }

                        $varDet = $varDet . ')';
                    }
                    $varDet .= '<br />';
                    if ($v['ItemType'] == 'product') {
                        $getImage = $this->select(TABLE_PRODUCT, array('ProductImage'), 'pkProductID="' . $jv->pkProductID . '"');
                        $arrRes[$k]['ProductImage'] = $getImage[0]['ProductImage'];
                    } else if ($v['ItemType'] == 'package') {
                        $getImage = $this->select(TABLE_PACKAGE, array('PackageImage'), 'pkPackageId="' . $v['fkItemID'] . '"');
                        $arrRes[$k]['ProductImage'] = $getImage[0]['PackageImage'];
                    }
                }
                $arrRes[$k]['OptionDet'] = $varDet;
                //pre($arrRes);
            } else {
                $arrRes[$k]['OptionDet'] = 'Gift Card';
            }
        }


        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function GetTotalDetails
     *
     * This function is used GetTotalDetails.
     *
     * Database Tables used in this function are : tbl_order_total
     *
     * @access public
     *
     * @parameters 1 $argWhere
     *
     * @return array $arrRes
     */
    function GetTotalDetails($argWhere) {
        $arrClms = array('Code', 'Title', 'Amount');
        $varOrder = " SortOrder ASC";
        $arrRes = $this->select(TABLE_ORDER_TOTAL, $arrClms, $argWhere, $varOrder);
        // pre($arrRes);
        return $arrRes;
    }

    /**
     * function getOrderComments
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_order_comments, tbl_customer, tbl_wholesaler, tbl_admin
     *
     * @access public
     *
     * @parameters 0 string
     *
     * @return string $arrRes
     */
    function getOrderComments($varWhr) {
        $varID = $varWhr;
        $arrClms = array('pkOrderCommentID', 'CommentedBy', 'CommentedID', 'Comment', 'CommentDateAdded', 'AdminUserName as adminName', 'CompanyName as wholesalerName', 'CustomerFirstName as customerName');
        $varOrder = " pkOrderCommentID ASC";
        $varTable = TABLE_ORDER_COMMENTS . " LEFT JOIN " . TABLE_CUSTOMER . " ON CommentedID = pkCustomerID LEFT JOIN " . TABLE_WHOLESALER . " ON CommentedID = pkWholesalerID LEFT JOIN " . TABLE_ADMIN . " ON CommentedID=pkAdminID";
        $arrRes = $this->select($varTable, $arrClms, $varID, $varOrder);
        //pre($arrRes);

        return $arrRes;
    }

    /**
     * function GetAdminDetails
     *
     * This function is used GetAdminDetails.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 1 $argWhere
     *
     * @return array $arrRes
     */
    function GetAdminDetails($argWhere) {
        $arrClms = array('AdminUserName', 'AdminEmail', 'AdminCountry', 'AdminRegion');
        $arrRes = $this->select(TABLE_ADMIN, $arrClms, $argWhere);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function GetWholesalerDetails
     *
     * This function is used GetWholesalerDetails.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 $argOrderID
     *
     * @return array $arrRes
     */
    function GetWholesalerDetails($argOrderID) {
        $query = "SELECT fkWholesalerID,CompanyName,fkShippingIDs, CompanyEmail,CompanyCountry,CompanyRegion FROM " . TABLE_ORDER_ITEMS . " INNER JOIN  " . TABLE_WHOLESALER . " ON fkWholesalerID=pkWholesalerID WHERE fkOrderID = '" . $argOrderID . "' GROUP BY fkWholesalerID";
        $arrRes = $this->getArrayResult($query);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function GetWholesalerDetailsWithId
     *
     * This function is used GetWholesalerDetailsWithId.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 $argOrderID
     *
     * @return array $arrRes
     */
    function GetWholesalerDetailsWithId($wholesalerId) {

        $query = "SELECT pkWholesalerID,CompanyName, CompanyEmail,CompanyCountry,CompanyRegion FROM " . TABLE_WHOLESALER . " WHERE pkWholesalerID = '" . $wholesalerId . "'";
        $arrRes = $this->getArrayResult($query);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function adminList
     *
     * This function is used adminList.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 1 $argWhr
     *
     * @return array $arrRes
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
     * function UpdateProduct
     *
     * This function is used UpdateProduct.
     *
     * Database Tables used in this function are : tbl_product_to_package, tbl_product
     *
     * @access public
     *
     * @parameters 3 $argItemType,$argItemID,$argQty
     *
     * @return true
     */
    function UpdateProduct($argItemType, $argItemID, $argQty = 0, $arrOptions) {
        global $objGeneral;

        if ($argItemType == 'product') {
            $varProductIds = $argItemID;
            $arrAtr['product'][$varProductIds] = $arrOptions;
        } else if ($argItemType == 'package') {
            $query = "SELECT GROUP_CONCAT(fkProductId) as Pids FROM " . TABLE_PRODUCT_TO_PACKAGE . " WHERE fkPackageId = '" . $argItemID . "' GROUP BY fkPackageId";
            $arrRes = $this->getArrayResult($query);
            $varProductIds = $arrRes['0']['Pids'];
        }

        $query = "SELECT pkProductID,Quantity,Sold FROM " . TABLE_PRODUCT . " WHERE pkProductID in (" . $varProductIds . ")";
        $arrRows = $this->getArrayResult($query);

        foreach ($arrRows as $k => $v) {
            $soldQuantity=$argQty;
            $varQty = $v['Quantity'] - $argQty;
            $varQt = ($varQty > 0) ? $varQty : 0;

            // $this->update(TABLE_PRODUCT, array('Quantity' => $varQt), " pkProductID = '" . $v['pkProductID'] . "' "); 

            $this->update(TABLE_PRODUCT, array('Quantity' => $varQt, 'Sold' => $v['Sold'] + $soldQuantity,'ProductDateUpdated' => date(DATE_TIME_FORMAT_DB)), " pkProductID = '" . $v['pkProductID'] . "' ");
            $this->UpdateAttributeOptids($varProductIds, $argQty, $arrAtr['product'][$v['pkProductID']]);
        }

        $objGeneral->solrProductRemoveAdd("pkProductID in (" . $varProductIds . ")");

        return true;
    }

    /**
     * function getAttributeStock
     *
     * This function is used ApplyGiftCard.
     *
     * Database Tables used in this function are : tbl_attribute, tbl_product_option_inventory
     *
     * @access public
     *
     * @parameters 2 $giftCardCode,$TotalOrderAmount
     *
     * @return true
     */
    function UpdateAttributeOptids($pid, $qty, $arrAttributeOption) {

        $arrAttr = array();
        $arrAttrOpt = array();
        $varOptIds = array();
        $objCore = new Core();
        $objShoppingCart = new ShoppingCart();
        foreach ($arrAttributeOption AS $attrOptions) {
            $attr = explode(':', $attrOptions);
            if ($attr[0] <> '') {
                $arrAttrbVals[] = (int) $attr[0];
                $arrAttrOpt[$attr[0]] = $attr[1];
            }
        }
        if (count($arrAttrbVals) > 0) {
            $varAttrIds = implode(',', $arrAttrbVals);
            $varQuery = "SELECT pkAttributeID FROM " . TABLE_ATTRIBUTE . " WHERE pkAttributeID IN (" . $varAttrIds . ") AND AttributeInputType IN ('image','select','radio','checkbox')";
            $arrResultRow = $this->getArrayResult($varQuery);
        }

        if (count($arrResultRow) > 0) {
            foreach ($arrResultRow as $val) {
                if ($arrAttrOpt[$val['pkAttributeID']] <> '') {
                    $varOptIds[] = trim($arrAttrOpt[$val['pkAttributeID']], ',');
                }
            }
            sort($varOptIds);

            $res = implode(',', $varOptIds);
            $varWhr = "fkProductID = '" . $pid . "' AND OptionIDs = '" . $res . "'";
            $varQuery = "SELECT OptionQuantity FROM " . TABLE_PRODUCT_OPTION_INVENTORY . " WHERE " . $varWhr;

            $arrRes = $this->getArrayResult($varQuery);

            $varQty = $arrRes[0]['OptionQuantity'] - $qty;
            $varQt = ($varQty > 0) ? $varQty : 0;
            $this->update(TABLE_PRODUCT_OPTION_INVENTORY, array('OptionQuantity' => $varQt), $varWhr);
        }
        return true;
    }

    /**
     * function ApplyGiftCard
     *
     * This function is used ApplyGiftCard.
     *
     * Database Tables used in this function are : tbl_gift_card
     *
     * @access public
     *
     * @parameters 2 $giftCardCode,$TotalOrderAmount
     *
     * @return true
     */
    function ApplyGiftCard($giftCardCode, $TotalOrderAmount, $customerEmail) {
        
        $_SESSION['MyCart']['GiftCardCode'] = array();
        if ($giftCardCode != '') {
            $query = "SELECT BalanceAmount FROM " . TABLE_GIFT_CARD . " WHERE BINARY GiftCardCode = '" . $giftCardCode . "' AND EmailTo='" . $customerEmail . "'";
           
            $arrRes = $this->getArrayResult($query);

            if ($arrRes['0']['BalanceAmount'] > 0) {
                $GrandTotal = $TotalOrderAmount - $arrRes['0']['BalanceAmount'];
                $appliedBalanced = ($GrandTotal > 0) ? $arrRes['0']['BalanceAmount'] : $TotalOrderAmount;
                $_SESSION['MyCart']['GiftCardCode'] = array($giftCardCode, $arrRes['0']['BalanceAmount'], $appliedBalanced);
                return array('isValid' => '1', 'GrandTotal' => ($GrandTotal > 0 ? $GrandTotal : 0));
            } else {
                return array('isValid' => '0', 'GrandTotal' => $TotalOrderAmount);
            }
        }
        /*
          $query = "SELECT pkProductID,Quantity,Sold FROM " . TABLE_PRODUCT . " WHERE pkProductID in (" . $varProductIds . ")";
          $arrRows = $this->getArrayResult($query);
          foreach ($arrRows as $k => $v) {

          $varQty = $v['Quantity'] - $argQty;
          $varQt = ($varQty > 0) ? $varQty : 0;

          // $this->update(TABLE_PRODUCT, array('Quantity' => $varQt), " pkProductID = '" . $v['pkProductID'] . "' ");

          $this->update(TABLE_PRODUCT, array('Quantity' => $varQt, 'Sold' => $v['Sold'] + 1), " pkProductID = '" . $v['pkProductID'] . "' ");
          }


          return true;
         */
    }

    /**
     * function getCartDetails
     *
     * This function is used get Gift Cart By Code.
     *
     * Database Tables used in this function are : tbl_gift_card
     *
     * @access public
     *
     * @parameters 1 $code
     *
     * @return $arrRes
     */
    function getGiftCartByCode($code) {

        $argWhere = "GiftCardCode = '" . $code . "' ";
        $arrClms = array('GiftCardCode', 'BalanceAmount');
        $arrRes = $this->select(TABLE_GIFT_CARD, $arrClms, $argWhere);
        return $arrRes[0];
    }

    /**
     * function getCartDetails
     *
     * This function is used ApplyGiftCard.
     *
     * Database Tables used in this function are : tbl_gift_card
     *
     * @access public
     *
     * @parameters 1 $CustomerID
     *
     * @return $arrRes[0]
     */
    function updateGiftCart($arrCols, $code) {
        $argWhere = "GiftCardCode = '" . $code . "' ";
        $this->update(TABLE_GIFT_CARD, $arrCols, $argWhere);
    }

    /**
     * function getCartDetails
     *
     * This function is used ApplyGiftCard.
     *
     * Database Tables used in this function are : tbl_cart
     *
     * @access public
     *
     * @parameters 1 $CustomerID
     *
     * @return $arrRes[0]
     */
    function getCartDetails($CustomerID) {
        $argWhere = "fkCustomerID = '" . $CustomerID . "' ";
        $arrClms = array("CartData");
        $arrRes = $this->select(TABLE_CART, $arrClms, $argWhere);
        return unserialize(html_entity_decode($arrRes[0]['CartData'], ENT_QUOTES));
    }
    
    /**
     * function GetPayKey
     *
     * This function is used GetPayKey.
     *
     * Database Tables used in this function are : tbl_cart
     *
     * @access public
     *
     * @parameters 1 $CustomerID
     *
     * @return $arrRes[0]
     */
    function GetPayKey($CustomerID) {
        $argWhere = "fkCustomerID = '" . $CustomerID . "' ";
        $arrClms = array("pay_key");
        $arrRes = $this->select(TABLE_CART, $arrClms, $argWhere);
        return $arrRes[0]['pay_key'];
    }

    /**
     * function deleteCartDetails
     *
     * This function is used ApplyGiftCard.
     *
     * Database Tables used in this function are : tbl_cart
     *
     * @access public
     *
     * @parameters 1 $CustomerID
     *
     * @return ''
     */
    function deleteCartDetails($CustomerID) {
        $argWhere = "fkCustomerID = '" . $CustomerID . "' ";
        $arrRes = $this->delete(TABLE_CART, $argWhere);
    }

    /**
     * function getMaxShippedDays
     *
     * This function is used getMaxShippedDays.
     *
     * Database Tables used in this function are : tbl_order, tbl_order_items, tbl_shipping_method
     *
     * @access public
     *
     * @parameters 1 $CustomerID
     *
     * @return $arrRes[0]
     */
    function getMaxShippedDays($cId, $varOrderID = 0) {

        if ($varOrderID == 0) {
            $varQuery2 = "SELECT pkOrderID FROM " . TABLE_ORDER . " WHERE fkCustomerID ='" . $cId . "' ORDER BY pkOrderID DESC LIMIT 0,1";
            $arrRes2 = $this->getArrayResult($varQuery2);
            $varOrderID = $arrRes2[0]['pkOrderID'];
        }

        $varQuery = "SELECT group_concat(fkMethodID) as fkMethodIDs FROM " . TABLE_ORDER_ITEMS . " WHERE fkOrderID='" . $varOrderID . "' ";
        $arrRes = $this->getArrayResult($varQuery);
        $varids = ($arrRes['0']['fkMethodIDs'] <> '') ? $arrRes['0']['fkMethodIDs'] : 0;

        $varQuery1 = "SELECT max(ShippingDays) as maxShippedDays FROM " . TABLE_SHIPPING_METHOD . " WHERE pkShippingMethod in ('" . $varids . "') ";
        $arrRes1 = $this->getArrayResult($varQuery1);
        $varMaxShippedDays = (int) $arrRes1[0]['maxShippedDays'];

        return $varMaxShippedDays;
    }

    /**
     * function getGiftCardDetails
     *
     * This function is used getGiftCardDetails.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_gift_card
     *
     * @access public
     *
     * @parameters 1 int
     *
     * @return $arrRes
     */
    function getGiftCardDetails($varOrderID = 0) {

        $varWhr = " fkOrderID = '" . $varOrderID . "' AND ItemType ='gift-card'";
        $arrCols = array('pkGiftCardID', 'GiftCardCode', 'NameFrom', 'EmailFrom', 'NameTo', 'EmailTo', 'Message', 'TotalAmount', 'BalanceAmount');
        $varTbl = TABLE_ORDER_ITEMS . " INNER JOIN " . TABLE_GIFT_CARD . " ON  	fkItemID  = pkGiftCardID ";
        $arrRes = $this->select($varTbl, $arrCols, $varWhr);
        return $arrRes;
    }

}

?>
