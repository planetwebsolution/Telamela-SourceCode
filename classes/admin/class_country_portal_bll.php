<?php

/**
 * Site CountryPortal Class
 *
 * This is the CountryPortal class that will used on website for Country portal kpi, commision.
 *
 * DateCreated 23rd Oct, 2013
 *
 * DateLastModified 23rd Oct, 2013
 *
 * @copyright Copyright (C) 2010-2012 Vinove Software and Services
 *
 * @version 10.0
 */
class CountryPortal extends Database {

    function __construct() {
//        pre($_POST);
        //$objCore = new Core();
        //default constructor for this class
    }

    /**
     * function countryList
     *
     * This function is used to retrive countryList.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 0
     *
     * @return array $arrRes
     */
    function countryList() {
        $arrClms = array(
            'country_id',
            'name',
        );
        $varOrderBy = 'name ASC ';
        $arrRes = $this->select(TABLE_COUNTRY, $arrClms);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function CountryPortalCount
     *
     * This function is used to retrive no of records.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 1 string (optional)
     *
     * @return string $varNum
     */
    function CountryPortalCount($argWhere = '') {

        $arrClms = "pkAdminID";
        $argWhr = ($argWhere <> '') ? " AND " . $argWhere : '';

        $varTable = TABLE_ADMIN;
        $varNum = $this->getNumRows($varTable, $arrClms, $argWhr);
        return $varNum;
    }

    /**
     * function CountryPortalList
     *
     * This function is used to retrive Country Portal List.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 2 string (optional) , string (optional)
     *
     * @return string $varNum
     */
    function CountryPortalList($argWhere = '', $argLimit = '', $varCurrentPeriodFilter = '') {
        global $objGeneral;

        $arrClms = array(
            'pkAdminID',
            'AdminUserName',
            'AdminEmail',
            'AdminTitle',
            'Commission',
            'SalesTarget',
            "DATE_FORMAT(SalesTargetStartDate,'%Y-%m-%d') as SalesTargetStartDate",
            "DATE_FORMAT(SalesTargetEndDate,'%Y-%m-%d') as SalesTargetEndDate",
            'AdminStatus'
        );

        $this->getSortColumnKPI($_REQUEST);
        $varTable = TABLE_ADMIN;
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $this->orderOptions, $argLimit);
        //pre($arrRes);
        // find Country Portal

        foreach ($arrRes as $key => $value) {

            $arrRes[$key]['warning'] = $this->warningCount($value['pkAdminID']);

            $varWhids = $this->getAdminWholesalers($value['pkAdminID']);
//            pre($varWhids);
            $arrPerformanceKpi = $this->countryPortalPerformanceKPI($varWhids);
            //echo '=====';
            //echo $varWhids;
            $arrDet = array(
                'whids' => $varWhids,
                'salesTarget' => $value['SalesTarget'],
                'fromDate' => $value['SalesTargetStartDate'],
                'toDate' => $value['SalesTargetEndDate']
            );
//            pre($arrDet);
            $arrRevenueKpi = $this->countryPortalRevenue($arrDet);

            $arrRes[$key]['PerformanceKpi'] = $arrPerformanceKpi;
            $arrRes[$key]['RevenueKpi'] = $arrRevenueKpi['RevenueKPI'];
            $arrRes[$key]['NoOfSoldItems'] = $arrRevenueKpi['NoOfSoldItems'];
            $arrRes[$key]['TotalSoldAmount'] = $arrRevenueKpi['TotalSoldAmount'];
            $arrRes[$key]['TotalCommission'] = ($arrRes[$key]['Commission'] / 100) * $arrRes[$key]['TotalSoldAmount'];
        }

        
        //echo '<pre>';
        //pre($arrRes);
        //die('END FOR');
        return $arrRes;
    }

    /**
     * function CountryPortalOrdersCount
     *
     * This function is used to retrive no of orders country portal wise.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_order
     *
     * @access public
     *
     * @parameters 1 string (optional)
     *
     * @return string $varNum
     */
    function CountryPortalOrdersCount($argWhere = '') {

        $varQuery = "SELECT sum(Quantity) as TotalQty, sum(ItemTotalPrice) as TotalAmount,DATE_FORMAT(OrderDateAdded, '%Y-%m') as Dated From " . TABLE_ORDER_ITEMS . " LEFT JOIN " . TABLE_ORDER . " ON fkOrderID = pkOrderID WHERE " . $argWhere . " GROUP BY DATE_FORMAT(OrderDateAdded, '%Y-%m') DESC " . $argLimit;
        $arrRes = $this->getArrayResult($varQuery);
        $varNum = count($arrRes);
        return $varNum;
    }

    /**
     * function CountryPortalOrdersList
     *
     * This function is used to get list of orders.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_order
     *
     * @access public
     *
     * @parameters 2 string (optional) , string (optional)
     *
     * @return string $varNum
     */
    function CountryPortalOrdersList($argWhere = '', $argLimit = '') {
        $argLimit = ($argLimit <> '') ? "LIMIT " . $argLimit : "";
        $varQuery = "SELECT sum(Quantity) as TotalQty, sum(ItemTotalPrice) as TotalAmount,DATE_FORMAT(OrderDateAdded, '%Y-%m') as Dated,PERIOD_DIFF(DATE_FORMAT(now(), '%Y%m'),DATE_FORMAT(OrderDateAdded, '%Y%m')) as DiffInv From " . TABLE_ORDER_ITEMS . " LEFT JOIN " . TABLE_ORDER . " ON fkOrderID = pkOrderID WHERE " . $argWhere . " GROUP BY DATE_FORMAT(OrderDateAdded, '%Y-%m') DESC " . $argLimit;
        $arrRes = $this->getArrayResult($varQuery);


        foreach ($arrRes as $k => $v) {
            $arrRow = $this->CountryPortalIsInvoiceSend($v['Dated']);
            $arrRes[$k]['inv'] = $arrRow['inv'];
            $arrRes[$k]['InvoiceFileName'] = $arrRow['InvoiceFileName'];
        }

        //pre($arrRes);

        return $arrRes;
    }

    /**
     * function CountryPortalIsInvoiceSend
     *
     * This function is used to check if invoice is sent.
     *
     * Database Tables used in this function are : tbl_invoice
     *
     * @access public
     *
     * @parameters 2 string (optional) , string (optional)
     *
     * @return string $varNum
     */
    function CountryPortalIsInvoiceSend($dated) {

        $varWhr = "FromUserType = 'user-admin' AND FromUserID ='" . $_SESSION['sessUser'] . "' AND DATE_FORMAT(OrderDateAdded,'%Y-%m') = '" . $dated . "' ";
        $varQuery1 = "SELECT pkInvoiceID,InvoiceFileName From " . TABLE_INVOICE . " WHERE " . $varWhr . " Order By pkInvoiceID DESC Limit 0,1";
        $arrInvoice = $this->getArrayResult($varQuery1);
        $arrRes['inv'] = count($arrInvoice);
        $arrRes['InvoiceFileName'] = $arrInvoice[0]['InvoiceFileName'];

        return $arrRes;
    }

    /**
     * function getCountryPortalArchives
     *
     * This function is used to get archives.
     *
     * Database Tables used in this function are : tbl_admin_commission_archive
     *
     * @access public
     *
     * @parameters 2 string (optional) , string (optional)
     *
     * @return string $varNum
     */
    function getCountryPortalArchives($cid = 0) {
        $varWhere = "fkAdminID='" . $cid . "'";

        $this->getSortColumnArchives($_REQUEST);

        $varOrder = $this->orderOptions;

        $varQuery = "SELECT fkAdminID,StartDate,EndDate,SalesTarget,AchivedTarget,TotalAmount,Commission From " . TABLE_ADMIN_COMMISSION_ARCHIVE . " WHERE " . $varWhere . " ORDER BY pkArchiveID DESC";
        $arrRes = $this->getArrayResult($varQuery);
        // pre($arrRes);
        return $arrRes;
    }

    /**
     * function getWholesalersOrderList
     *
     * This function is used to get wholesaler order list.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_order, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function getWholesalersOrderList($month = '', $cp) {

        if ($month <> '') {
            $varWhere = " AND  DATE_FORMAT(OrderDateAdded, '%Y-%m')  = '" . $month . "' " . $cp;
        }

        $varQuery = "SELECT pkWholesalerID, CompanyName, sum(Quantity) as TotalQty, sum(ItemTotalPrice) as TotalAmount, DATE_FORMAT(OrderDateAdded, '%Y-%m') as Dated,PERIOD_DIFF(DATE_FORMAT(now(), '%Y%m'),DATE_FORMAT(OrderDateAdded, '%Y%m')) as DiffInv From " . TABLE_ORDER_ITEMS . " LEFT JOIN " . TABLE_ORDER . " ON fkOrderID = pkOrderID LEFT JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID WHERE fkWholesalerID>0 " . $varWhere . " GROUP BY fkWholesalerID";
        $arrRes = $this->getArrayResult($varQuery);


        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getWholesalersOrdersForInvoice
     *
     * This function is used to get wholesaler invoice.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_order
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return array $arrRes
     */
    function getWholesalersOrdersForInvoice($month = '', $cp) {

        if ($month <> '') {
            $varWhere = " AND  DATE_FORMAT(OrderDateAdded, '%Y-%m')  = '" . $month . "' " . $cp;
        }

        $varQuery = "SELECT fkOrderID, SubOrderID, ItemType, ItemName,fkWholesalerID,ItemACPrice,Quantity,AttributePrice,DiscountPrice,Status, OrderDateAdded as Dated  From " . TABLE_ORDER_ITEMS . " LEFT JOIN " . TABLE_ORDER . " ON fkOrderID = pkOrderID WHERE fkWholesalerID > 0 " . $varWhere . "  ORDER BY OrderDateAdded DESC ";

        $arrRes = $this->getArrayResult($varQuery);

        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function countryPortalCommissionCount
     *
     * This function is used to get count of commission.
     *
     * Database Tables used in this function are : tbl_invoice, tbl_admin
     *
     * @access public
     *
     * @parameters 2 array
     *
     * @return string $arrAddID
     */
    function countryPortalCommissionCount($argWhere = '') {

        $arrClms = 'i.pkInvoiceID';
        $argWhr = ($argWhere <> '') ? " AND " . $argWhere : '';

        $varTable = TABLE_INVOICE . " as i LEFT JOIN " . TABLE_ADMIN . " ON FromUserID = pkAdminID";
        $varNum = $this->getNumRows($varTable, $arrClms, $argWhr);
        return $varNum;
    }

    /**
     * function countryPortalCommissionList
     *
     * This function is used to get wholesaler commission list.
     *
     * Database Tables used in this function are : tbl_invoice, tbl_admin
     *
     * @access public
     *
     * @parameters 2 array
     *
     * @return string $arrAddID
     */
    function countryPortalCommissionList($argWhere = '', $argLimit = '') {
        global $objGeneral;
        $arrClms = array(
            'pkInvoiceID',
            'InvoiceDateAdded',
            'fkOrderID',
            'fkSubOrderID',
            'fkWholesalerID',
            'FromUserID',
            'AmountPayable',
            'AmountDue',
            'TransactionStatus',
            'pkAdminID',
            'AdminTitle',
            'Commission',
            'AdminEmail'
        );
        $this->getSortColumnCommission($_REQUEST);
        $varTable = TABLE_INVOICE . " as i LEFT JOIN " . TABLE_ADMIN . " ON FromUserID = pkAdminID";
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $this->orderOptions, $argLimit);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function UpdateCountryPortalPayment
     *
     * This function is used to update country portal payment status.
     *
     * Database Tables used in this function are : tbl_invoice, tbl_admin_payment
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string $arrAddID
     */
    function UpdateCountryPortalPayment($arrPost) {
        $objCore = new Core();
        $varWhr = " pkInvoiceID ='" . $arrPost['InvoiceID'] . "' ";
        $arrRes = $this->select(TABLE_INVOICE, array('AmountPayable', 'AmountDue'), $varWhr);

        $amountDue = $arrRes[0]['AmountDue'] - $arrPost['paymentAmount'];
        if ($amountDue > 0) {
            $TransactionStatus = 'Partial';
        } else {
            $TransactionStatus = 'Completed';
        }

        $arrClms = array('fkInvoiceID' => $arrPost['InvoiceID'], 'ToUserType' => 'user-admin', 'ToUserID' => $arrPost['userID'], 'paymentMode' => $arrPost['paymentMode'], 'paymentAmount' => $arrPost['paymentAmount'], 'paymentDate' => $objCore->defaultDateTime($arrPost['paymentDate'], DATE_FORMAT_DB), 'Comment' => $arrPost['paymentComment'], 'PaymentDateAdded' => date(DATE_TIME_FORMAT_DB));
        $arrAddID = $this->insert(TABLE_ADMIN_PAYMENT, $arrClms);

        $varWhr = " pkInvoiceID ='" . $arrPost['InvoiceID'] . "'";
        $arrClms = array('TransactionStatus' => $TransactionStatus, 'AmountDue' => $amountDue);
        $arrUpdateID = $this->update(TABLE_INVOICE, $arrClms, $varWhr);

        return $arrAddID;
    }

    /**
     * function getWholesalersSalesList
     *
     * This function is used to get wholesaler sales list.
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_order, tbl_order_items
     *
     * @access public
     *
     * @parameters 1 int
     *
     * @return array $arrRes
     */
    function getWholesalersSalesList($cid = 0) {
        global $objGeneral;


        $arrAdminDetails = $this->getAdminDetails($_GET['cid']);

        $startDate = $arrAdminDetails['SalesTargetStartDate'];
        $endDate = $arrAdminDetails['SalesTargetEndDate'];

        $varWhids = $this->getAdminWholesalers($cid);

        $varWhere = " WHERE (OrderDateAdded BETWEEN '" . $startDate . "' AND '" . $endDate . "')";

        if ($varWhids <> '') {
            $varWhere .= " AND fkWholesalerID in (" . $varWhids . ")";
        } else {
            $varWhere .= " AND fkWholesalerID in (0)";
        }

        $this->getSortColumnWholesaler($_REQUEST);

        $varOrder = $this->orderOptions;

        $varQuery = " SELECT pkWholesalerID,CompanyName,Commission,CompanyEmail,sum(Quantity) as NoOfSoldItems,sum(ItemTotalPrice) as TotalSoldAmount FROM " . TABLE_WHOLESALER . " LEFT JOIN " . TABLE_ORDER_ITEMS . " ON pkWholesalerID = fkWholesalerID  LEFT JOIN " . TABLE_ORDER . " ON fkOrderID=pkOrderID " . $varWhere . " group BY fkWholesalerID ORDER BY " . $varOrder;
        $arrRes = $this->getArrayResult($varQuery);

        foreach ($arrRes as $key => $val) {
            $varkpi = $objGeneral->wholesalerKpi($val['pkWholesalerID']);
            $arrRes[$key]['kpi'] = $varkpi['kpi'];
            $arrRes[$key]['AdminCommission'] = ($arrAdminDetails['Commission'] * $val['TotalSoldAmount']) / 100;
        }

        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function sendInvoiceToTelamela
     *
     * This function is used to send invoice to telamela.
     *
     * Database Tables used in this function are : tbl_invoice
     *
     * @access public
     *
     * @parameters 2 array
     *
     * @return string $arrAddID
     */
    function sendInvoiceToTelamela($cID, $varPortalFilter) {

        global $objCore;
        $objTemplate = new EmailTemplate();

        $arrRow = $this->getWholesalersOrdersForInvoice($cID, $varPortalFilter);


        $arrAdminDetails = $this->getAdminDetails($_SESSION['sessUser']);

        //pre($arrAdminDetails);
        if (count($arrRow) > 0) {

            $arrCols = array(
                'fkOrderID' => '0',
                'fkSubOrderID' => '',
                'fkWholesalerID' => 0,
                'FromUserType' => 'user-admin',
                'FromUserID' => $_SESSION['sessUser'],
                'ToUserType' => 'super-admin',
                'ToUserID' => '1',
                'TransactionStatus' => 'Pending',
                'InvoiceDateAdded' => $objCore->serverDateTime(date(DATE_TIME_FORMAT_DB), DATE_TIME_FORMAT_DB)
            );



            $varInvoiceDate = $objCore->serverDateTime($arrCols['InvoiceDateAdded'], DATE_FORMAT_SITE_FRONT);
            $varInvoiceId = $this->insert(TABLE_INVOICE, $arrCols);

            $varFromDate = $objCore->localDateTime($cID, DATE_FORMAT_SITE);
            $m = $objCore->localDateTime($cID, 'm');
            $y = $objCore->localDateTime($cID, 'Y');

            $varToDate = $objCore->localDateTime($cID . '-' . cal_days_in_month(CAL_GREGORIAN, $m, $y), DATE_FORMAT_SITE);



            $varSubTotal = 0;
            $varAmountPayable = 0;
            $varSubCommision = 0;
            $varTotal = 0;
            $varEmailItemDetails = '';
            foreach ($arrRow as $item) {
                $varSubTotal = ($item['ItemACPrice'] * $item['Quantity']) + $item['AttributePrice'] - $item['DiscountPrice'];
                $varTotal += $varSubTotal;
                $varSubCommision = ($arrAdminDetails['Commission'] / 100) * $varSubTotal;
                $varAmountPayable += $varSubCommision;

                $varEmailItemDetails .= '<tr class="row-item">
                            <td>' . $objCore->localDateTime($item['Dated'], DATE_FORMAT_SITE) . '</td>
                            <td>' . $item['ItemName'] . '</td>
                             <td>' . number_format(($item['ItemACPrice'] + ($item['AttributePrice'] / $item['Quantity'])), 2) . '</td>
                            <td>' . $item['Quantity'] . '</td>
                                <td>' . number_format($item['DiscountPrice'], 2) . '</td>
                            <td>' . number_format($varSubTotal, 2) . '</td>
                                <td>' . number_format($varSubCommision, 2) . '</td>
                        </tr>';
            }


            $varEmailOrderDetails = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head><title>Country Portal: Tax Invoice/Statement</title><link href="' . CSS_PATH . 'invoices.css" rel="stylesheet" /></head>
    <body>
        <div class="main-div">
           <div class="no-print print_button"><span onclick="window.print();">Print</span></div>
            <div class="rgt-main-div">
                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td width="50%">
                            <img src="' . SITE_ROOT_URL . 'common/images/logo-telamela.png" width="" />
                            <br /><br />
                            <span class="adr bld f20">Country Portal Invoice</span>
                            <br/>
                            <span class="adr">' . $arrAdminDetails['AdminTitle'] . '</span>
                            <br/>
                            <span class="adr">' . $arrAdminDetails['CountryName'] . '</span>
                            <br/>
                        </td>

                        <td width="50%" class="vtop tc" valign="top">
                            <span class="c-name">Tax Invoice/Statement</span>
                        </td>
                    </tr>
                    <tr><td colspan="2"><hr /></td></tr>
                </table>
                <ul>
                    <li class="adr-lft">
                    <table cellspacing="0" cellpadding="0" width="100%" class="bill">
                            <tr><td class="lft-txt"><span class="bld">' . SITE_NAME . ' Pty. Ltd.</span><br /><span class="span">Ground floor 155-161 Boundary Road</span><br /><span class="span">North Melbourne, VIC, 3051</span></td></tr>
                    </table>
            </li>
            <li class="adr-rgt">
                <table cellspacing = "0" cellpadding = "0" width = "100%" class = "bill">
                <tr><td width = "40%" class = "lft-txt"><span class = "bld">Invoice#</span></td><td><span class = "span">' . $varInvoiceId . '</span></td></tr>
                <tr><td class = "lft-txt"><span class = "bld">From Date</span></td><td><span class = "span">' . $varFromDate . '</span></td></tr>
                <tr><td class = "lft-txt"><span class = "bld">To Date</span></td><td><span class = "span">' . $varToDate . '</span></td></tr>
                <tr><td class = "lft-txt"><span class = "bld">Invoice Date</span></td><td><span class = "span">' . $varInvoiceDate . '</span></td></tr>
                </table>
            </li>
            </ul>
            <div style="margin-top:30px;float:left;width:99%;"><span class="bill-to bld">Account summery</span></div>
            <div style="float:left;width:99%;"><span class = "adr bld">Total commission:</span><span> ' . ADMIN_CURRENCY_SYMBOL . number_format($varAmountPayable, 2) . '</span></div>
            <div style="float:left;width:99%;"><hr /></div>
            <div style="margin-top:30px;float:left;width:99%;"><span class = "bill-to bld">Statements</span></div>
            <div style="clear:both;"></div>
            <div class="lineItemDIV" style = "width: 99%">
            <table cellspacing = "0" cellpadding = "0" border = "0" width = "100%" class = "column">
            <tr class="hd"><td><b>Date</b></td><td><b>Items</b></td><td><b>Price</b></td><td><b>Qty</b></td><td><b>Discount</b></td><td><b>Sales</b></td><td><b>Commission</b></td></tr>';

            $varEmailOrderDetails .= $varEmailItemDetails;
            $varEmailOrderDetails .= '<tr class="tot"><td colspan="5">&nbsp;</td><td class="total">TOTAL</td><td><span class = "amount bld">' . ADMIN_CURRENCY_SYMBOL . number_format($varAmountPayable, 2) . '</span></td></tr>
            </table></div></div></div></body></html>';
            //echo $varEmailOrderDetails;
            //exit;


            $varDir = INVOICE_PATH . 'country_portal/';
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
                'AmountPayable' => $varAmountPayable,
                'AmountDue' => $varAmountPayable,
                'InvoiceFileName' => $fileName,
                'OrderDateAdded' => date(DATE_TIME_FORMAT_DB, strtotime($item['Dated']))
            );
            $this->update(TABLE_INVOICE, $arrCols, "pkInvoiceID='" . $varInvoiceId . "'");


            $arrTo = $this->getAdminDetails(1);

            $varTo = $arrTo['AdminEmail'];
            $varEmailOrderDetails = $varEmailOrderDetails;

            $varFrom = SITE_NAME;

            $varWhereTemplate = " EmailTemplateTitle= 'AdminToSuperAdminInvoiceDetails' AND EmailTemplateStatus = 'Active' ";

            $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);


            $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

            $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

            $varPathImage = '<img src = "' . SITE_ROOT_URL . 'common/images/logo.png" >';

            $varSubject = str_replace('{SITE_NAME}', SITE_NAME, $arrMailTemplate['0']['EmailTemplateSubject']);

            $varKeyword = array('{IMAGE_PATH}', '{EMAIL}', '{EMAILDETAILS}', '{SITE_NAME}');

            $varKeywordValues = array($varPathImage, $varTo, $varEmailOrderDetails, SITE_NAME);

            $varEmailMessage = str_replace($varKeyword, $varKeywordValues, $varOutput);

            // Calling mail function
            $objCore->sendMail($varTo, $varFrom, $varSubject, $varEmailMessage);

            return 1;
        } else {
            return 0;
        }
    }

    /**
     * function UpdateCountryPortalStatus
     *
     * This function is used to update country portal status.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters 2 array
     *
     * @return string $arrAddID
     */
    function UpdateCountryPortalStatus($argVal, $varWhre) {

        $varWhr = " pkAdminID ='" . $varWhre . "' ";

        if ($argVal == 'Active') {
            $this->resetCountryPortalWarning($varWhre);
        }

        $arrClms = array('AdminStatus' => $argVal);
        $arrUpdateID = $this->update(TABLE_ADMIN, $arrClms, $varWhr);
        return $arrUpdateID;
    }

    /**
     * function insertCountryPortalWarning
     *
     * This function is used to insert warning for country portal.
     *
     * Database Tables used in this function are : tbl_admin_warning
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return string $arrAddID
     */
    function insertCountryPortalWarning($arrPost) {
        $WarningText = ((int) $_REQUEST['warnNo'] + 1) . ' Warnig Letter';
        $arrClms = array(
            'fkAdminID' => $arrPost['id'],
            'WarningText' => $WarningText,
            'WarningDateAdded' => date(DATE_TIME_FORMAT_DB)
        );
        $arrAddID = $this->insert(TABLE_ADMIN_WARNING, $arrClms);
    }

    /**
     * function warningCount
     *
     * This function is used to retrive no of warning for country portal.
     *
     * Database Tables used in this function are : tbl_admin_warning
     *
     * @access public
     *
     * @parameters 1 string (optional)
     *
     * @return string $varNum
     */
    function warningCount($argWhere = '') {
        $arrClms = "pkWarningID";
        $argWhr = ($argWhere <> '') ? " AND fkAdminID = '" . $argWhere . "'" : "";
        $varTable = TABLE_ADMIN_WARNING;
        $varNum = $this->getNumRows($varTable, $arrClms, $argWhr);

        return $varNum;
    }

    function warningList($argWhere = '') {
        $varWhere = $argWhere;

        $arrClms = array(
            'WarningText',
            'WarningDateAdded'
        );
        $varOrderBy = ' WarningDateAdded DESC ';

        $varTable = TABLE_WHOLESALER_WARNING;
        $arrRes = $this->select($varTable, $arrClms, $varWhere, $varOrderBY);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     *
     * Function name:getSortColumnKPI
     *
     * Return type: String
     *
     * Author : Aditya Pratap Singh
     *
     * Last modified by : Aditya Pratap Singh
     *
     * Comments: sort coloum for Enquiries
     *
     * User instruction: $objEnquiries->getSortColumn($argVarSortOrder)
     *
     */
    function getSortColumnKPI($argVarSortOrder) {

        $objCore = new Core();
        //Default order by setting
        if ($argVarSortOrder['orderBy'] == '') {
            $varOrderBy = 'DESC';
        } else {
            $varOrderBy = $argVarSortOrder['orderBy'];
        }
        //Default sort by setting
        if ($argVarSortOrder['sortBy'] == '') {
            $varSortBy = 'pkAdminID';
        } else {
            $varSortBy = $argVarSortOrder['sortBy'];
        }
        //Create sort class object
        $objOrder = new CreateOrder($varSortBy, $varOrderBy);
        unset($argVarSortOrder['PHPSESSID']);
        //This function return  query  string. When we will array.
        $varQryStr = $objCore->sortQryStr($argVarSortOrder, $varOrderBy, $varSortBy);
        //print_r($varQryStr);
        //Pass query string in extra function for add in sorting
        $objOrder->extra($varQryStr);
        //Prepage sorting heading
        $objOrder->append(' ');
        $objOrder->addColumn('Country Office ID', 'pkAdminID', '', '');
        $objOrder->addColumn('Country Office Name', 'AdminTitle', '', 'hidden-480');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     *
     * Function name:getSortColumnKPI
     *
     * Return type: String
     *
     * Author : Aditya Pratap Singh
     *
     * Last modified by : Aditya Pratap Singh
     *
     * Comments: sort coloum for Enquiries
     *
     * User instruction: $objEnquiries->getSortColumn($argVarSortOrder)
     *
     */
    function getSortColumnArchives($argVarSortOrder) {

        $objCore = new Core();
        //Default order by setting
        if ($argVarSortOrder['orderBy'] == '') {
            $varOrderBy = 'DESC';
        } else {
            $varOrderBy = $argVarSortOrder['orderBy'];
        }
        //Default sort by setting
        if ($argVarSortOrder['sortBy'] == '') {
            $varSortBy = 'pkArchiveID';
        } else {
            $varSortBy = $argVarSortOrder['sortBy'];
        }
        //Create sort class object
        $objOrder = new CreateOrder($varSortBy, $varOrderBy);
        unset($argVarSortOrder['PHPSESSID']);
        //This function return  query  string. When we will array.
        $varQryStr = $objCore->sortQryStr($argVarSortOrder, $varOrderBy, $varSortBy);
        //print_r($varQryStr);
        //Pass query string in extra function for add in sorting
        $objOrder->extra($varQryStr);
        //Prepage sorting heading
        $objOrder->append(' ');
        $objOrder->addColumn('Start Date', 'StartDate');
        $objOrder->addColumn('End Date', 'EndDate');
        $objOrder->addColumn('Sales Target', 'SalesTarget', '', 'hidden-480');
        $objOrder->addColumn('No. of Sold Products', 'AchivedTarget', '', 'hidden-480');
        $objOrder->addColumn('Total Sales(' . ADMIN_CURRENCY_SYMBOL . ')', 'TotalAmount', '', 'hidden-480');
        $objOrder->addColumn('Total Commission (' . ADMIN_CURRENCY_SYMBOL . ')', '');
        $objOrder->addColumn('Commission(%)', 'Commission', '', 'hidden-480');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     *
     * Function name:getSortColumnKPI
     *
     * Return type: String
     *
     * Author : Aditya Pratap Singh
     *
     * Last modified by : Aditya Pratap Singh
     *
     * Comments: sort coloum for Enquiries
     *
     * User instruction: $objEnquiries->getSortColumn($argVarSortOrder)
     *
     */
    function getSortColumnWholesaler($argVarSortOrder) {

        $objCore = new Core();
        //Default order by setting
        if ($argVarSortOrder['orderBy'] == '') {
            $varOrderBy = 'ASC';
        } else {
            $varOrderBy = $argVarSortOrder['orderBy'];
        }
        //Default sort by setting
        if ($argVarSortOrder['sortBy'] == '') {
            $varSortBy = 'pkWholesalerID';
        } else {
            $varSortBy = $argVarSortOrder['sortBy'];
        }
        //Create sort class object
        $objOrder = new CreateOrder($varSortBy, $varOrderBy);
        unset($argVarSortOrder['PHPSESSID']);
        //This function return  query  string. When we will array.
        $varQryStr = $objCore->sortQryStr($argVarSortOrder, $varOrderBy, $varSortBy);
        //print_r($varQryStr);
        //Pass query string in extra function for add in sorting
        $objOrder->extra($varQryStr);
        //Prepage sorting heading
        $objOrder->append(' ');
        $objOrder->addColumn('Wholesaler Id', 'pkWholesalerID', '', 'hidden-480');
        $objOrder->addColumn('Wholesaler Name', 'CompanyName');
        $objOrder->addColumn('KPI(%)', '');
        $objOrder->addColumn('No. of Sold Products', 'NoOfSoldItems', '', 'hidden-480');
        $objOrder->addColumn('Total Sales(' . ADMIN_CURRENCY_SYMBOL . ')', 'TotalSoldAmount', '', 'hidden-480');
        $objOrder->addColumn('Total Commission (' . ADMIN_CURRENCY_SYMBOL . ')', '');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     *
     * Function name:getSortColumnCommission
     *
     * Return type: String
     *
     * Author : Amlana
     *
     * Last modified by : Amlana
     *
     * Comments: Wholesalers commission
     *
     * User instruction: $objWholesaler->getSortColumnCommission($argVarSortOrder)
     *
     */
    function getSortColumnCommission($argVarSortOrder) {

        $objCore = new Core();
        //Default order by setting
        if ($argVarSortOrder['orderBy'] == '') {
            $varOrderBy = 'DESC';
        } else {
            $varOrderBy = $argVarSortOrder['orderBy'];
        }
        //Default sort by setting
        if ($argVarSortOrder['sortBy'] == '') {
            $varSortBy = 'pkInvoiceID';
        } else {
            $varSortBy = $argVarSortOrder['sortBy'];
        }
        //Create sort class object
        $objOrder = new CreateOrder($varSortBy, $varOrderBy);
        unset($argVarSortOrder['PHPSESSID']);
        //This function return  query  string. When we will array.
        $varQryStr = $objCore->sortQryStr($argVarSortOrder, $varOrderBy, $varSortBy);
        //print_r($varQryStr);
        //Pass query string in extra function for add in sorting
        $objOrder->extra($varQryStr);
        //Prepage sorting heading
        $objOrder->append(' ');
        $objOrder->addColumn('Invoice Ref. No.', 'pkInvoiceID');
        $objOrder->addColumn('Invoice Date', 'InvoiceDateAdded', '', 'hidden-480');
        $objOrder->addColumn('Country Office ID', 'pkAdminID', '', 'hidden-1024');
        $objOrder->addColumn('Country Office Name', 'AdminTitle', '', 'hidden-350');
        $objOrder->addColumn('Amount Payablel', 'Amount', '', 'hidden-480');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function resetCountryPortalWarning
     *
     * This function is used to delete warning for country portal.
     *
     * Database Tables used in this function are : tbl_admin_warning
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return none;
     */
    function resetCountryPortalWarning($whId) {
        $varWhere = "fkAdminID = '" . $whId . "'";
        $this->delete(TABLE_ADMIN_WARNING, $varWhere);
    }

    /**
     * function countryPortalPerformanceKPI
     *
     * This function is used to retrive kpi for country portal.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string (optional)
     *
     * @return string $varNum
     */
    function countryPortalPerformanceKPI($ids) {
        global $objGeneral;
        $varPerformanceKPI = "0.00";

        if ($ids) {
            $arrWhids = explode(', ', $ids);
            $varKpiSum = "";
            $i = 0;
            foreach ($arrWhids as $key => $value) {
                $arrWkpi = $objGeneral->wholesalerKpi($value);
                if ($arrWkpi['kpi'] != 'N/A') {
                    $varKpiSum += $arrWkpi['kpi'];
                    $i++;
                }
            }

            $varPerformanceKPI = $varKpiSum / $i;
            $varPerformanceKPI = number_format($varPerformanceKPI, 2, '.', ', ');
        }

        return $varPerformanceKPI;
    }

    /**
     * function countryPortalRevenue
     *
     * This function is used to get country portals revenue.
     *
     * Database Tables used in this function are : tbl_order_items, tbl_order
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return array $arrRes
     */
    function countryPortalRevenue($addDet) {
        //pre($addDet);
        global $objGeneral;
        $arrRevenueKPI = "0.00";
        $varACSales = "0";
        $TotalSales = "0.00";

        $whids = $addDet['whids'];
        $salesTarget = $addDet['salesTarget'];
        $fromDate = $addDet['fromDate'];
        $toDate = $addDet['toDate'];

        if ($whids) {
            $varPortalFilter = $objGeneral->countryPortalFilter($whids);
            //echo '<pre>';
            //print_r($varPortalFilter);
            $varWhere = " WHERE 1 " . $varPortalFilter . " AND (OrderDateAdded BETWEEN '" . $fromDate . "' AND '" . $toDate . "') ";

            $varQuery = "SELECT sum(Quantity) as ActualSale, sum(ItemTotalPrice) as TotalSales FROM " . 
                    TABLE_ORDER_ITEMS . " LEFT JOIN " . TABLE_ORDER . " ON fkOrderID=pkOrderID" . $varWhere;
            //echo '<pre>';
            //print_r($varQuery);
            $arrACSales = $this->getArrayResult($varQuery);
            
            $varACSales = (int) $arrACSales[0]['ActualSale'];
            $arrRevenueKPI = ($varACSales / $salesTarget) * 100;
            $arrRevenueKPI = (float) $arrRevenueKPI;
            $TotalSales = (float) $arrACSales[0]['TotalSales'];
        }
        $arrRes = array('RevenueKPI' => $arrRevenueKPI, 'NoOfSoldItems' => $varACSales, 'TotalSoldAmount' => $TotalSales);
        //echo '<pre>';
        //print_r($addDet);
        //echo '<pre>';
        //print_r($whids);
        return $arrRes;
    }

    /**
     * function getAdminWholesalers
     *
     * This function is used to retrive Wholesalers under country portal.
     *
     * Database Tables used in this function are : tbl_admin, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string (optional)
     *
     * @return string $varWholesalerIDs
     */
    function getAdminWholesalers($argId) {

        $arrClms = array('AdminType', 'AdminCountry', 'AdminRegion');
        $varTable = TABLE_ADMIN;
        $varWhere = "pkAdminID = '" . $argId . "' ";

        $arrAdminRes = $this->select($varTable, $arrClms, $varWhere);
        //pre($arrAdminRes);
        $varWholesalerIDs = '';

        $varWhere = "";

        if ($arrAdminRes[0]['AdminRegion'] > 0) {
            $varWhere .= "CompanyRegion = '" . $arrAdminRes[0]['AdminRegion'] . "' ";
        } else if ($arrAdminRes[0]['AdminCountry'] > 0) {
            $varWhere .= "CompanyCountry = '" . $arrAdminRes[0]['AdminCountry'] . "' ";
        } else {
            $varWhere = "";
        }
        //pre($varWhere);
        if ($varWhere) {
            $varQuery = "SELECT group_concat(pkWholesalerID) as WIDs  FROM " . TABLE_WHOLESALER . " WHERE " . $varWhere;
            //pre($varQuery);
            $arrRes = $this->getArrayResult($varQuery);
            $varWholesalerIDs = $arrRes[0]['WIDs'];
        }

        return $varWholesalerIDs;
    }

    /**
     * function getAdminWholesalers
     *
     * This function is used to retrive admin details.
     *
     * Database Tables used in this function are : tbl_admin, tbl_country
     *
     * @access public
     *
     * @parameters 1 string (optional)
     *
     * @return string $varWholesalerIDs
     */
    function getAdminDetails($argId) {

        $arrClms = array(
            'AdminType',
            'AdminEmail',
            'AdminTitle',
            'Commission',
            "DATE_FORMAT(SalesTargetStartDate,'%Y-%m-%d') as SalesTargetStartDate",
            "DATE_FORMAT(SalesTargetEndDate,'%Y-%m-%d') as SalesTargetEndDate",
            'AdminCountry',
            'name as CountryName',
            'AdminRegion'
        );
        $varTable = TABLE_ADMIN . " LEFT JOIN " . TABLE_COUNTRY . " ON AdminCountry=country_id";
        $varWhere = "pkAdminID = '" . $argId . "' ";

        $arrRes = $this->select($varTable, $arrClms, $varWhere);

        return $arrRes[0];
    }

    /**
     * function getInvoiceList
     *
     * This function is used to retrive invoice list.
     *
     * Database Tables used in this function are : tbl_invoice, tbl_admin
     *
     * @access public
     *
     * @parameters 2 string (optional)
     *
     * @return string $varWholesalerIDs
     */
    function getInvoiceList($argWhere = '', $argLimit = '') {
        $varWhere = " WHERE FromUserType ='user-admin' AND ToUserType = 'super-admin' " . $argWhere;

        if ($argLimit) {
            $varLimit = " LIMIT " . $argLimit;
        }

        $varQuery = "SELECT pkInvoiceID,fkOrderID,fkSubOrderID,AdminTitle,Amount,InvoiceFileName,OrderDateAdded,InvoiceDateAdded  FROM " . TABLE_INVOICE . " LEFT JOIN " . TABLE_ADMIN . " ON FromUserID = pkAdminID" . $varWhere . " ORDER BY pkInvoiceID DESC " . $varLimit;
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function viewInvoice
     *
     * This function is used to get invoice details.
     *
     * Database Tables used in this function are : tbl_invoice
     *
     * @access public
     *
     * @parameters 1 int 1 string
     *
     * @return string $arrData
     */
    function viewInvoice($argID, $varPortalFilter) {
        $varID = " FromUserType = 'user-admin' AND ToUserType = 'super-admin' AND pkInvoiceID ='" . $argID . "' " . $varPortalFilter;
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
     * This function is used to remove invoice.
     *
     * Database Tables used in this function are : tbl_invoice
     *
     * @access public
     *
     * @parameters 1 int 1 string (optional)
     *
     * @return int $num
     */
    function removeInvoice($argPostIDs, $varPortalFilter) {
        $varWhereSdelete = " pkInvoiceID = '" . $argPostIDs . "' " . $varPortalFilter;
        $num = $this->delete(TABLE_INVOICE, $varWhereSdelete);
        return $num;
    }

    /**
     * function transactionDetails
     *
     * This function is used to retrive transaction details.
     *
     * Database Tables used in this function are : tbl_admin_payment, tbl_admin, tbl_invoice
     *
     * @access public
     *
     * @parameters 2 string (optional)
     *
     * @return string $varWholesalerIDs
     */
    function transactionDetails($argWhere = '', $argLimit = '') {
        if ($argLimit != '') {
            $varLimit = "limit " . $argLimit . " ";
        }
        $varOrderBy = 'PaymentDateAdded DESC';
        $varQuery = "SELECT pkAdminPaymentID ,fkInvoiceID,AdminUserName,PaymentMode,PaymentAmount,PaymentDate,Comment FROM " . TABLE_ADMIN_PAYMENT . " as pay LEFT JOIN " . TABLE_ADMIN . " on pkAdminID = ToUserID LEFT JOIN " . TABLE_INVOICE . " on pkInvoiceID=fkInvoiceID  where " . $argWhere . " order by " . $varOrderBy . " " . $varLimit . " ";
        $arrRow = $this->getArrayResult($varQuery);
        //pre($varQuery);
        return $arrRow;
    }

    /**
     * function removeTransaction
     *
     * This function is used to remove transaction.
     *
     * Database Tables used in this function are : tbl_admin_payment
     *
     * @access public
     *
     * @parameters 1 int
     *
     * @return boolean
     */
    function removeTransaction($argPostID) {
        $varWhere = "ToUserType = 'user-admin' AND pkAdminPaymentID = '" . $argPostID['frmID'] . "' ";
        $this->delete(TABLE_ADMIN_PAYMENT, $varWhere);
        return true;
    }

    /**
     * function removeAllTransaction
     *
     * This function is used to remove selected transaction.
     *
     * Database Tables used in this function are : tbl_admin_payment
     *
     * @access public
     *
     * @parameters 1 int
     *
     * @return boolean
     */
    function removeAllTransaction($argPostID) {

        foreach ($argPostID['frmID'] as $valDeltetID) {
            $varWhere = "ToUserType = 'user-admin' AND pkAdminPaymentID = '" . $valDeltetID . "' ";
            $this->delete(TABLE_ADMIN_PAYMENT, $varWhere);
        }
        return true;
    }

    /**
     * function getSortColumnTransaction
     *
     * This function is used to sort transaction column.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 1 string 
     *
     * @return string $varWholesalerIDs
     */
    function getSortColumnTransaction($argVarSortOrder) {

        $objCore = new Core();
        //Default order by setting
        if ($argVarSortOrder['orderBy'] == '') {
            $varOrderBy = 'DESC';
        } else {
            $varOrderBy = $argVarSortOrder['orderBy'];
        }
        //Default sort by setting
        if ($argVarSortOrder['sortBy'] == '') {
            $varSortBy = 'pkAdminPaymentID';
        } else {
            $varSortBy = $argVarSortOrder['sortBy'];
        }
        //Create sort class object
        $objOrder = new CreateOrder($varSortBy, $varOrderBy);
        unset($argVarSortOrder['PHPSESSID']);
        //This function return  query  string. When we will array.
        $varQryStr = $objCore->sortQryStr($argVarSortOrder, $varOrderBy, $varSortBy);
        //print_r($varQryStr);
        //Pass query string in extra function for add in sorting
        $objOrder->extra($varQryStr);
        //Prepage sorting heading
        $objOrder->append(' ');
        $objOrder->addColumn('Invoice ID', 'fkInvoiceID', '', 'hidden-480');
        $objOrder->addColumn('Transaction ID', 'pkAdminPaymentID', '', 'hidden-480');
        $objOrder->addColumn('Country Portal Name', 'AdminUserName');
        $objOrder->addColumn('Payment Mode', 'PaymentMode', '', 'hidden-480');
        $objOrder->addColumn('Payment Amount', 'PaymentAmount');
        $objOrder->addColumn('Comment', 'Comment', '', 'hidden-480');
        $objOrder->addColumn('Payment Date', 'PaymentDate', '', 'hidden-1024');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

}

?>
