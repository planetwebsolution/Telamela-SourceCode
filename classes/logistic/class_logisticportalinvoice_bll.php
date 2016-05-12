<?php

/**
 * 
 * Class name : Invoice
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The Invoice class is used to maintain Invoice infomation details for several modules.
 */
class LogisticInvoiceportal extends Database {

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
     * function invoiceList
     *
     * This function is used to display the invoice List.
     *
     * Database Tables used in this function are : tbl_invoice
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrRes
     *
     * User instruction: $objInvoice->invoiceList($argWhere = '', $argLimit = '')
     */
    function invoiceList($argWhere = '', $argLimit = '') {

        //$varWhere = " WHERE FromUserType in('super-admin','user-admin') AND ToUserType = 'customer' " . $argWhere;

        if ($argLimit) {
            $varLimit = " LIMIT " . $argLimit;
        }

//         $varQuery = "SELECT pkInvoiceID,fkOrderID,fkSubOrderID,CustomerName,CustomerEmail,Amount,InvoiceFileName,OrderDateAdded,InvoiceDateAdded,Status  FROM " . TABLE_LOGISTICINVOICE . " " . $varWhere . " ORDER BY InvoiceDateAdded DESC " . $varLimit;
        $varQuery = "SELECT pkInvoiceID,OrderDateAdded,fkOrderID,fkSubOrderID,CustomerID, customerfullname, fkShippingGatewaysID,shippingAmount,Status  FROM " . TABLE_LOGISTICINVOICE . " " . $argWhere . " ORDER BY pkInvoiceID DESC " . $varLimit;
		
		//echo  $varQuery;
		//die();
        
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function viewInvoice
     *
     * This function is used to view the invoice .
     *
     * Database Tables used in this function are : tbl_invoice
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrData
     *
     * User instruction: $objInvoice->viewInvoice($argID, $varPortalFilter)
     */
    function viewInvoice($argID, $varPortalFilter) {
        $varID = " FromUserType in('super-admin','user-admin') AND ToUserType = 'customer' AND pkInvoiceID ='" . $argID . "' " . $varPortalFilter;
        $arrClms = array(
            'pkInvoiceID',
            'fkOrderID',
            'customerfullname',
            'CustomerEmail',
            'shippingAmount',
            'InvoiceDetails',
            'OrderDateAdded',
            'InvoiceDateAdded'
        );
        $varTable = TABLE_LOGISTICINVOICE;
        $arrData = $this->select($varTable, $arrClms, $varID);
        // pre($arrData);
        return $arrData;
    }

    function getorderid($varID, $varPortalFilter) {
    	$arrClms = array(
    			'fkOrderID',
    	);
    	$varTable = TABLE_LOGISTICINVOICE;
    	$arrData = $this->select($varTable, $arrClms, $varID);
    	//pre($arrData);
    	return $arrData;
    }
    
    function getorderid1($varID, $varPortalFilter) {
    	//$argWhere = "pkInvoiceID='" . $varID . "' ";
    	$argWhere = "pkInvoiceID='" . $varID . "' ";
    	//pre($argWhere);
    	//$varQuery = "SELECT fkOrderID FROM " . TABLE_LOGISTICINVOICE . " " . $argWhere ;
    	$varQuery = "SELECT fkOrderID FROM " . TABLE_LOGISTICINVOICE .  " where " .  $argWhere ;
    	$arrRes = $this->getArrayResult($varQuery);
    	//pre($arrRes);
    	return $arrRes;
    }
    
    function getlogisticinvoicedata($varID, $varPortalFilter) {
    	$argWhere = "pkInvoiceID='" . $varID . "' ";
    	$varQuery = "SELECT pkInvoiceID,OrderDateAdded,fkOrderID,fkSubOrderID,CustomerID,fkShippingGatewaysID,shippingAmount,Status  FROM " . TABLE_LOGISTICINVOICE .  " where " .  $argWhere." Group BY fkSubOrderID" ;
        
        $arrRes = $this->getArrayResult($varQuery);
    	//pre($arrData);
    	return $arrRes;
    }
    
    function getorderdata($varID, $varPortalFilter) {
    	$arrClms = array( 'CustomerFirstName', 'CustomerLastName', 'CustomerEmail', 'CustomerPhone');
        $argWhere = "pkOrderID= '" . $varID . "' ";
       // $varWhere = "pkOrderID ='" . ' 386 ' . "' ";
        $varQuery = "SELECT * FROM " . TABLE_ORDER .  " where " .  $argWhere ;
        
       // $varQuery = "SELECT *  FROM " . TABLE_ORDER . " " . $argWhere . "" ;
        $arrRes = $this->getArrayResult($varQuery);
       
       //$arrRes = $this->select(TABLE_ORDER, $arrClms, $argWhere);
        //pre($arrRes);
    	return $arrRes;
    }
    
    function getorderdataitem($varID, $orderID) {
    
    	$argWhere = "SubOrderID='" . $varID . "' And fkOrderID='". $orderID . "'";
    	//$argWhere = "pkOrderItemID ='" . ' 386-58 ' . "' ";
    	//pre($argWhere);
    	$varQuery = "SELECT * FROM " . TABLE_ORDER_ITEMS .  " where " .  $argWhere ;
    
    	// $varQuery = "SELECT *  FROM " . TABLE_ORDER . " " . $argWhere . "" ;
    	$arrRes = $this->getArrayResult($varQuery);
    	 
    	//$arrRes = $this->select(TABLE_ORDER, $arrClms, $argWhere);
    	//pre($arrRes);
    	return $arrRes;
    }
    function getorderdataitem1($varID, $orderID) {
    
    	//$argWhere = "pkInvoiceID='" . $varID . "' And " . TABLE_ORDER_ITEMS ." .fkOrderID='". $orderID . "'";
    	$argWhere = TABLE_LOGISTICINVOICE ." .fkOrderID ='". $orderID . "' And " ."pkInvoiceID='". $varID . "'";
    	//$argWhere = "pkOrderItemID ='" . ' 386-58 ' . "' ";
    	//pre($argWhere);
    	$varQuery = "SELECT * FROM " . TABLE_LOGISTICINVOICE .  " left join "
            . TABLE_ORDER_ITEMS ." on " . TABLE_ORDER_ITEMS. ".fkOrderID = " . TABLE_LOGISTICINVOICE. ".fkOrderID 
            		AND " . TABLE_ORDER_ITEMS .".pkOrderItemID = " . TABLE_LOGISTICINVOICE.".fkOrderitemID WHERE " 
          .  $argWhere . " GROUP BY pkInvoiceID";
    
    	// $varQuery = "SELECT *  FROM " . TABLE_ORDER . " " . $argWhere . "" ;
    	//pre($varQuery);
    	$arrRes = $this->getArrayResult($varQuery);
    	 
    	//$arrRes = $this->select(TABLE_ORDER, $arrClms, $argWhere);
    	//pre($varQuery);
    	return $arrRes;
    }
	
	function getshippingcompanyname($varID, $varPortalFilter) {
    
    	$argWhere = "pkShippingGatewaysID='" . $varID . "' ";
    	//$argWhere = "pkShippingGatewaysID ='" . ' 21 ' . "' ";
         $varQuery = "SELECT ShippingTitle FROM " . TABLE_SHIP_GATEWAYS .  " where " .  $argWhere ;
        // pre($varQuery);
    	$arrRes = $this->getArrayResult($varQuery);
    
    	//pre($arrRes);
    	return $arrRes;
    }
    
    function getCustomername($varID, $varPortalFilter) {
    
    	$argWhere = "pkCustomerID='" . $varID . "' ";
    	//$argWhere = "pkCustomerID ='" . ' 21 ' . "' ";
    	$varQuery = "SELECT CustomerFirstName,CustomerLastName FROM " . TABLE_CUSTOMER .  " where " .  $argWhere ;
    	// pre($varQuery);
    	$arrRes = $this->getArrayResult($varQuery);
    
    	//pre($arrRes);
    	return $arrRes;
    }
    
    function getproductweight($varID, $varPortalFilter) {
    
    	$argWhere = "pkProductID='" . $varID . "' ";
    	//$argWhere = "pkCustomerID ='" . ' 21 ' . "' ";
    	$varQuery = "SELECT Weight,WeightUnit FROM " . TABLE_PRODUCT .  " where " .  $argWhere ;
    	// pre($varQuery);
    	$arrRes = $this->getArrayResult($varQuery);
    
    	//pre($arrRes);
    	return $arrRes;
    }
    
    
    /**
     * function removeInvoice
     *
     * This function is used to remove the invoice .
     *
     * Database Tables used in this function are : tbl_invoice
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $num
     *
     * User instruction: $objInvoice->removeInvoice($argPostIDs, $varPortalFilter) 
     */
    function removeInvoice($argPostIDs, $varPortalFilter) {
        $ctr = 0;

        if (isset($argPostIDs['deleteType']) && $argPostIDs['deleteType'] == 'sD') {
            $varWhereSdelete = " pkInvoiceID = '" . $argPostIDs['frmID'] . "' " . $varPortalFilter;
            $num = $this->delete(TABLE_LOGISTICINVOICE, $varWhereSdelete);
            if ($num > 0) {
                $ctr++;
            }
        } else {
            foreach ($argPostIDs['frmID'] as $varDeleteID) {
                $varWhr = " pkInvoiceID = '" . $varDeleteID . "'";
                $varWhereCondition = $varWhr . $varPortalFilter;
                $num = $this->delete(TABLE_LOGISTICINVOICE, $varWhereCondition);
                if ($num > 0) {
                    $ctr++;
                }
            }
        }
        return $ctr;
    }

}

?>
