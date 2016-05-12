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
class Invoice extends Database {

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

        $varWhere = " 1 " . $argWhere;
        $varWhere = str_replace('fkWholesalerID','tbl_logisticinvoice.fkWholesalerID',$varWhere);
        
        //echo $varWhere = '1 AND tbl_logisticinvoice.fkWholesalerID IN (5,120,36,154,85,119,122,125,132,143,133,126,131,148)';
        if ($argLimit) {
            $varLimit = " LIMIT " . $argLimit;
        }

        $varQuery = "SELECT *  FROM " . TABLE_LOGISTICINVOICE . " "
                . " LEFT JOIN tbl_order_items ON fkOrderitemID = pkOrderItemID "
                . " LEFT JOIN tbl_admin ON AdminCountry = AdminPortalID  WHERE " . $varWhere . " GROUP BY tbl_logisticinvoice.fkSubOrderID ORDER BY pkInvoiceID DESC " . $varLimit;
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
            'CustomerName',
            'CustomerEmail',
            'Amount',
            'InvoiceDetails',
            'OrderDateAdded',
            'InvoiceDateAdded'
        );
        $varTable = TABLE_INVOICE;
        $arrData = $this->select($varTable, $arrClms, $varID);
        // pre($arrData);
        return $arrData;
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
            $num = $this->delete(TABLE_INVOICE, $varWhereSdelete);
            if ($num > 0) {
                $ctr++;
            }
        } else {
            foreach ($argPostIDs['frmID'] as $varDeleteID) {
                $varWhr = " pkInvoiceID = '" . $varDeleteID . "'";
                $varWhereCondition = $varWhr . $varPortalFilter;
                $num = $this->delete(TABLE_INVOICE, $varWhereCondition);
                if ($num > 0) {
                    $ctr++;
                }
            }
        }
        return $ctr;
    }

}

?>
