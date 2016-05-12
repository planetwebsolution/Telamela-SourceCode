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

        $varWhere = " WHERE FromUserType in('super-admin','user-admin') AND ToUserType = 'customer' " . $argWhere;

        if ($argLimit) {
            $varLimit = " LIMIT " . $argLimit;
        }

        $varQuery = "SELECT pkInvoiceID,fkOrderID,fkSubOrderID,CustomerName,CustomerEmail,Amount,InvoiceFileName,OrderDateAdded,InvoiceDateAdded,TransactionStatus,AdminMarginProduct,AdminCommissionProduct  FROM "
                . "" . TABLE_INVOICE . " " . $varWhere . " ORDER BY InvoiceDateAdded DESC " . $varLimit;
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
