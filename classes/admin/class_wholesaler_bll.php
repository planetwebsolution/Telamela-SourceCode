<?php

/**
 * 
 * Class name : Wholesaler
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The Wholesaler class is used to maintain Wholesaler infomation details for several modules.
 */
class Wholesaler extends Database {

    /**
     * function __construct
     *
     * Constructor of the class, will be called in PHP5
     *
     * @access public
     *
     */
    function __construct() {

        //$objCore = new Core();
        //default constructor for this class
    }

    /**
     * function arrUnPaidInvoiceProductDetails
     *
     * This function is used to display the UnPaid Invoice Product Details.
     *
     * Database Tables used in this function are : tbl_invoice
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objWholesaler->arrUnPaidInvoiceProductDetails($whId = '') 
     */
    function arrUnPaidInvoiceProductDetails($whId = '') {

        $arrClms = array('count(TransactionStatus) as TransactionStatus');
        $argWhere = 'TransactionStatus="Pending" and FromUserType="wholesaler" and FromUserID=' . $whId;
        $arrRes = $this->select(TABLE_INVOICE, $arrClms, $argWhere);
        return $arrRes;
    }

    /**
     * function arrPaidInvoiceProductDetails
     *
     * This function is used to display the Paid Invoice Product Details.
     *
     * Database Tables used in this function are : tbl_invoice
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objWholesaler->arrUnPaidInvoiceProductDetails($whId = '') 
     */
    function arrPaidInvoiceProductDetails($whId = '') {

        $arrClms = array('count(TransactionStatus) as TransactionStatus');
        $argWhere = 'TransactionStatus="Completed" and FromUserType="wholesaler" and FromUserID=' . $whId;
        $arrRes = $this->select(TABLE_INVOICE, $arrClms, $argWhere);
        return $arrRes;
    }
    
   

    /**
     * function arrSoldProductDetails
     *
     * This function is used to display the Sold Product Details.
     *
     * Database Tables used in this function are : tbl_order_items
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objWholesaler->arrSoldProductDetails($whId = '')
     */
    function arrSoldProductDetails($whId = '') {

        $arrClms = array('count(Quantity) as qty', 'sum(ItemPrice) ip');
        $argWhere = 'fkWholesalerID=' . $whId;
        $arrRes = $this->select(TABLE_ORDER_ITEMS, $arrClms, $argWhere);
        return $arrRes;
    }

    /**
     * function shippingGatewayList
     *
     * This function is used to display the shipping Gateway List.
     *
     * Database Tables used in this function are : tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters ''
     *
     * @return $arrRes
     *
     * User instruction: $objWholesaler->shippingGatewayList()
     */
    function shippingGatewayList($argWhere) {
    	
    	$arrClms = array(
    			'pkShippingGatewaysID',
    			'ShippingTitle',
    			'ShippingType'
    	);
    	$varOrderBy = "";
    	$varQuery = "SELECT * FROM tbl_ship_gateways LEFT JOIN tbl_gateway_portal ON fkgatewayID = pkShippingGatewaysID WHERE " . $argWhere;
    	$arrRow = $this->getArrayResult($varQuery);
//     	$arrClms = array(
//             'pkShippingGatewaysID',
//             'ShippingTitle',
//         );
//         $argWhere = 'ShippingStatus=1';
//         $varOrderBy = 'ShippingType ASC,ShippingTitle ASC ';
//         $arrRes = $this->select(TABLE_SHIP_GATEWAYS, $arrClms, $argWhere);
//         $arrRes = $this->select(TABLE_SHIPPING_GATEWAYS, $arrClms, $argWhere);
        
        //pre($arrRes);
        return $arrRow;
    }

    /**
     * function countryList
     *
     * This function is used to display the country List.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters ''
     *
     * @return $arrRes
     *
     * User instruction: $objWholesaler->countryList()
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
     * function getWarningTemplates
     *
     * This function is used to retrive WarningTemplates List.
     *
     * Database Tables used in this function are : tbl_email_templates
     *
     * @access public
     *
     * @parameters ''
     *
     * @return $arrRes
     *
     * User instruction: $objWholesaler->countryList()
     */
    function getWarningTemplates() {
        $arrClms = array(
            'EmailTemplateTitle',
            'EmailTemplateDisplayTitle',
            'EmailTemplateSubject',
            'EmailTemplateDescription',
            'EmailTemplateStatus',
        );
        $varWhere = " EmailTemplateTitle in ('1WarningToWholesalerByAdmin','2WarningToWholesalerByAdmin','3WarningToWholesalerByAdmin','4WarningToWholesalerByAdmin') AND EmailTemplateStatus='Active' ";
        $varOrderBy = 'EmailTemplateTitle ASC ';
        $arrRes = $this->select(TABLE_EMAIL_TEMPLATES, $arrClms, $varWhere, $varOrderBy);


        //echo html_entity_decode($arrRes[0]['EmailTemplateDescription']);
        //exit;
        return $arrRes;
    }

    /**
     * function regionList
     *
     * This function is used to display the region List.
     *
     * Database Tables used in this function are : tbl_region
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objWholesaler->regionList($where = '')
     */
    function regionList($where = '') {
        $arrClms = array(
            'pkRegionID',
            'RegionName',
        );
        $varOrderBy = 'RegionName ASC ';
        $arrRes = $this->select(TABLE_REGION, $arrClms, $where);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function CountWholesalerEmail
     *
     * This function is used to display the Count Wholesaler Email.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrNum
     *
     * User instruction: $objWholesaler->CountWholesalerEmail($argWhere = '') 
     */
    function CountWholesalerEmail($argWhere = '') {
        $arrNum = $this->getNumRows(TABLE_WHOLESALER, 'CompanyEmail', $argWhere);
        return $arrNum;
    }

    /**
     * function adminUserList
     *
     * This function is used to display the admin User List.
     *
     * Database Tables used in this function are : tbl_admin
     *
     * @access public
     *
     * @parameters ''
     *
     * @return $arrRes
     *
     * User instruction: $objWholesaler->adminUserList()
     */
    function adminUserList() {
        $arrClms = array(
            'pkAdminID',
            'AdminUserName',
            'AdminCountry',
            'AdminRegion'
        );
        $varWhr = "AdminType = 'user-admin'";
        $varOrderBy = 'AdminUserName ASC ';
        $arrRes = $this->select(TABLE_ADMIN, $arrClms, $varWhr);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function WholesalerCount
     *
     * This function is used to display the Wholesaler Count.
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_country, tbl_region
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $varNum
     *
     * User instruction: $objWholesaler->WholesalerCount($argWhere = '')
     */
    function WholesalerCount($argWhere = '') {

        $arrClms = 'pkWholesalerID';
        $argWhr = ($argWhere <> '') ? " AND " . $argWhere : '';

        $varTable = TABLE_WHOLESALER . ' LEFT JOIN ' . TABLE_COUNTRY . ' ON CompanyCountry =  country_id LEFT JOIN ' . TABLE_REGION . ' ON pkRegionID = CompanyRegion';
        $varNum = $this->getNumRows($varTable, $arrClms, $argWhr);
        return $varNum;
    }

    /**
     * function WholesalerList
     *
     * This function is used to display the WholesalerList.
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_country, tbl_region, tbl_admin, tbl_wholesaler_warning
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objWholesaler->WholesalerList($argWhere = '', $argLimit = '') 
     */
    function WholesalerList($argWhere = '', $argLimit = '') {
        global $objGeneral;
        $arrClms = array(
            'pkWholesalerID',
            'CompanyName',
            'CompanyCountry',
            'name as CountryName',
            'CompanyRegion',
            'RegionName',
            'Commission',
            'CompanyEmail',
            'WholesalerDateAdded',
            'WholesalerStatus'
        );
        $this->getSortColumn($_REQUEST);
        $varTable = TABLE_WHOLESALER . ' LEFT JOIN ' . TABLE_COUNTRY . ' ON CompanyCountry =  country_id LEFT JOIN ' . TABLE_REGION . ' ON pkRegionID = CompanyRegion';
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $this->orderOptions, $argLimit);
		//echo '<pre>'; print_r($arrRes); die;
        // find Country Portal

        foreach ($arrRes as $k1 => $v1) {

            $varkpi = $objGeneral->wholesalerKpi($v1['pkWholesalerID']);
            $arrRes[$k1]['kpi'] = $varkpi['kpi'];




            $arrRes[$k1]['CountryRegionPortalUser'] = '-';
            $arrRes[$k1]['CountryRegionPortal'] = '';

            if ($v1['CompanyRegion'] > 0) {

                $varNumRegPortal = $this->getNumRows(TABLE_ADMIN, 'pkAdminID', ' AND AdminRegion = ' . $v1['CompanyRegion']);

                if ($varNumRegPortal > 0) {
                    //find wholesaler region   Portal
                    $arrRes[$k1]['CountryRegionPortal'] = $v1['CountryName'] . '-' . $v1['RegionName'];
                    $arrRes[$k1]['ShowRegion'] = $v1['CompanyRegion'];
                    $arrDataR = $this->select(TABLE_ADMIN, array('AdminUserName'), ' AdminRegion = ' . $v1['CompanyRegion']);
                    $arrRes[$k1]['CountryRegionPortalUser'] = $arrDataR[0]['AdminUserName'];
                } else {
                    //find wholesaler Country Portal   
                    $varNumCounPortal = $this->getNumRows(TABLE_ADMIN, 'pkAdminID', ' AND AdminCountry = ' . $v1['CompanyCountry']);
                    if ($varNumCounPortal > 0) {
                        $arrRes[$k1]['CountryRegionPortal'] = $v1['CountryName'];
                        $arrDataU = $this->select(TABLE_ADMIN, array('AdminUserName'), ' AdminCountry = ' . $v1['CompanyCountry']);
                        $arrRes[$k1]['CountryRegionPortalUser'] = $arrDataU[0]['AdminUserName'];
                    } else {
                        $arrRes[$k1]['CountryRegionPortalUser'] = '-';
                    }
                }
            } else {
                //find wholesaler Country Portal   
                $varNumCounPortal = $this->getNumRows(TABLE_ADMIN, 'pkAdminID', ' AND AdminCountry = ' . $v1['CompanyCountry']);
                if ($varNumCounPortal > 0) {
                    $arrRes[$k1]['CountryRegionPortal'] = $v1['CountryName'];
                    $arrDataU = $this->select(TABLE_ADMIN, array('AdminUserName'), ' AdminCountry = ' . $v1['CompanyCountry']);
                    $arrRes[$k1]['CountryRegionPortalUser'] = $arrDataU[0]['AdminUserName'];
                }
            }



            $varQuery = "SELECT count(pkWarningID) as warn  FROM " . TABLE_WHOLESALER_WARNING . " WHERE fkWholesalerID = " . $v1['pkWholesalerID'] . "  group by fkWholesalerID ";
            $arrRow = $this->getArrayResult($varQuery);
            $arrRes[$k1]['warning'] = (int) $arrRow[0]['warn'];
        }

        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function WholesalerSpecialApplicationCount
     *
     * This function is used to display the Wholesaler special application Count.
     *
     * Database Tables used in this function are : tbl_special_application, tbl_festival, tbl_wholesaler, tbl_country
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $varNum
     *
     * User instruction: $objWholesaler->WholesalerCount($argWhere = '')
     */
    function WholesalerSpecialApplicationCount($argWhere = '') {

        $arrClms = 'pkApplicationID';
        $argWhr = ($argWhere <> '') ? " AND " . $argWhere : '';

        $varTable = TABLE_SPECIAL_APPLICATION . " as sa LEFT JOIN " . TABLE_FESTIVAL . " ON sa.fkFestivalID = pkFestivalID LEFT JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID LEFT JOIN " . TABLE_COUNTRY . " ON fkCountryID=country_id";
        $varNum = $this->getNumRows($varTable, $arrClms, $argWhr);
        return $varNum;
    }

    /**
     * function WholesalerSpecialApplicationList
     *
     * This function is used to display the Wholesaler special List.
     *
     * Database Tables used in this function are : tbl_special_application, tbl_festival, tbl_wholesaler, tbl_country
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objWholesaler->WholesalerList($argWhere = '', $argLimit = '') 
     */
    function WholesalerSpecialApplicationList($argWhere = '', $argLimit = '') { 

        $this->getSortColumnSpecial($_REQUEST);
        $arrClms = "pkApplicationID,fkWholesalerID,sa.fkFestivalID,fkCountryID,TotalAmount,TransactionID,TransactionAmount,IsPaid,IsApproved,ApplicatonDateAdded,CompanyName,CompanyEmail,FestivalTitle,name as CountryName";

        $varWhr = $argWhere;
        $argLimit = ($argLimit <> '') ? " LIMIT " . $argLimit : '';
        $varOrder = $this->orderOptions;
        $varTable = TABLE_SPECIAL_APPLICATION . " as sa LEFT JOIN " . TABLE_FESTIVAL . " ON sa.fkFestivalID = pkFestivalID LEFT JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID LEFT JOIN " . TABLE_COUNTRY . " ON fkCountryID=country_id";

        $varQuery = "Select " . $arrClms . " FROM " . $varTable . " WHERE " . $varWhr . " ORDER BY " . $varOrder . $argLimit;
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function WholesalerSpecialApplicationList
     *
     * This function is used to display the Wholesaler special List.
     *
     * Database Tables used in this function are : tbl_special_application, tbl_festival, tbl_wholesaler, tbl_country, tbl_special_application_to_category, tbl_category
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objWholesaler->WholesalerList($argWhere = '', $argLimit = '') 
     */
    function getWholesalerSpecialApplication($argWhere = '') {

        $arrClms = "pkApplicationID,fkWholesalerID,sa.fkFestivalID,fkCountryID,TotalAmount,TransactionID,TransactionAmount,IsPaid,IsApproved,ApplicatonDateAdded,CompanyName,CompanyEmail,FestivalTitle,name as CountryName";

        $varWhr = $argWhere;
        $varTable = TABLE_SPECIAL_APPLICATION . " as sa LEFT JOIN " . TABLE_FESTIVAL . " ON sa.fkFestivalID = pkFestivalID LEFT JOIN " . TABLE_WHOLESALER . " ON fkWholesalerID = pkWholesalerID LEFT JOIN " . TABLE_COUNTRY . " ON fkCountryID=country_id";

        $varQuery = "Select " . $arrClms . " FROM " . $varTable . " WHERE " . $varWhr;
        $arrRes = $this->getArrayResult($varQuery);



        $varQuery = "SELECT fkCategoryID,ProductQty,CategoryName FROM " . TABLE_SPECIAL_APPLICATION_TO_CATEGORY . " LEFT JOIN " . TABLE_CATEGORY . " ON fkCategoryID=pkCategoryId  WHERE fkApplicationID='" . $arrRes[0]['pkApplicationID'] . "'";
        $arrRow['cat'] = $this->getArrayResult($varQuery);
        $arrRow['details'] = $arrRes[0];

        return $arrRow;
    }

    /**
     * function wholesalerExportList
     *
     * This function is used to display the wholesaler Export List.
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_country, tbl_region, tbl_admin, tbl_wholesaler_warning
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objWholesaler->wholesalerExportList($argWhere = '', $argLimit = '')
     */
    function wholesalerExportList($argWhere = '', $argLimit = '') {
        global $objGeneral;
        $arrClms = array(
            'pkWholesalerID',
            'CompanyName',
            'AboutCompany',
            'Services',
            'Commission',
            'CompanyAddress1',
            'CompanyAddress2',
            'CompanyCountry',
            'name as CountryName',
            'CompanyRegion',
            'CompanyCity',
            'RegionName',
            'CompanyAddress1',
            'CompanyAddress2',
            'CompanyPostalCode',
            'CompanyWebsite',
            'CompanyEmail',
            'PaypalEmail',
            'CompanyPhone',
            'CompanyFax',
            'ContactPersonName',
            'ContactPersonPosition',
            'ContactPersonPhone',
            'ContactPersonEmail',
            'ContactPersonAddress',
            'OwnerName',
            'OwnerPhone',
            'OwnerEmail',
            'OwnerAddress',
            'Ref1Name',
            'Ref1Phone',
            'Ref1Email',
            'Ref1CompanyName',
            'Ref1CompanyAddress',
            'Ref2Name',
            'Ref2Phone',
            'Ref2Email',
            'Ref2CompanyName',
            'Ref2CompanyAddress',
            'Ref3Name',
            'Ref3Phone',
            'Ref3Email',
            'Ref3CompanyName',
            'Ref3CompanyAddress',
            'WholesalerDateAdded'
        );
        $this->getSortColumn($_REQUEST);
        $varTable = TABLE_WHOLESALER . ' LEFT JOIN ' . TABLE_COUNTRY . ' ON CompanyCountry =  country_id LEFT JOIN ' . TABLE_REGION . ' ON pkRegionID = CompanyRegion';
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $this->orderOptions, $argLimit);
        // find Country Portal

        foreach ($arrRes as $k1 => $v1) {

            $varkpi = $objGeneral->wholesalerKpi($v1['pkWholesalerID']);
            $arrRes[$k1]['kpi'] = $varkpi['kpi'];




            $arrRes[$k1]['CountryRegionPortalUser'] = '-';
            $arrRes[$k1]['CountryRegionPortal'] = '';

            if ($v1['CompanyRegion'] > 0) {

                $varNumRegPortal = $this->getNumRows(TABLE_ADMIN, 'pkAdminID', ' AND AdminRegion = ' . $v1['CompanyRegion']);

                if ($varNumRegPortal > 0) {
                    //find wholesaler region   Portal
                    $arrRes[$k1]['CountryRegionPortal'] = $v1['CountryName'] . '-' . $v1['RegionName'];
                    $arrRes[$k1]['ShowRegion'] = $v1['CompanyRegion'];
                    $arrDataR = $this->select(TABLE_ADMIN, array('AdminUserName'), ' AdminRegion = ' . $v1['CompanyRegion']);
                    $arrRes[$k1]['CountryRegionPortalUser'] = $arrDataR[0]['AdminUserName'];
                } else {
                    //find wholesaler Country Portal   
                    $varNumCounPortal = $this->getNumRows(TABLE_ADMIN, 'pkAdminID', ' AND AdminCountry = ' . $v1['CompanyCountry']);
                    if ($varNumCounPortal > 0) {
                        $arrRes[$k1]['CountryRegionPortal'] = $v1['CountryName'];
                        $arrDataU = $this->select(TABLE_ADMIN, array('AdminUserName'), ' AdminCountry = ' . $v1['CompanyCountry']);
                        $arrRes[$k1]['CountryRegionPortalUser'] = $arrDataU[0]['AdminUserName'];
                    } else {
                        $arrRes[$k1]['CountryRegionPortalUser'] = '-';
                    }
                }
            } else {
                //find wholesaler Country Portal   
                $varNumCounPortal = $this->getNumRows(TABLE_ADMIN, 'pkAdminID', ' AND AdminCountry = ' . $v1['CompanyCountry']);
                if ($varNumCounPortal > 0) {
                    $arrRes[$k1]['CountryRegionPortal'] = $v1['CountryName'];
                    $arrDataU = $this->select(TABLE_ADMIN, array('AdminUserName'), ' AdminCountry = ' . $v1['CompanyCountry']);
                    $arrRes[$k1]['CountryRegionPortalUser'] = $arrDataU[0]['AdminUserName'];
                }
            }



            $varQuery = "SELECT count(pkWarningID) as warn  FROM " . TABLE_WHOLESALER_WARNING . " WHERE fkWholesalerID = " . $v1['pkWholesalerID'] . "  group by fkWholesalerID ";
            $arrRow = $this->getArrayResult($varQuery);
            $arrRes[$k1]['warning'] = (int) $arrRow[0]['warn'];
        }



        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function WholesalerCommissionCount
     *
     * This function is used to display the Wholesaler Commission Count.
     *
     * Database Tables used in this function are : tbl_invoice, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $varNum
     *
     * User instruction: $objWholesaler->WholesalerCommissionCount($argWhere = '') 
     */
    function WholesalerCommissionCount($argWhere = '') {

        $arrClms = 'i.pkInvoiceID';
        $argWhr = ($argWhere <> '') ? " AND " . $argWhere : '';

        $varTable = TABLE_INVOICE . ' AS i LEFT JOIN ' . TABLE_WHOLESALER . ' AS w ON i.fkWholesalerID = w.pkWholesalerID';
        $varNum = $this->getNumRows($varTable, $arrClms, $argWhr);
        return $varNum;
    }

    /**
     * function WholesalerCommissionList
     *
     * This function is used to display the Wholesaler Commission List.
     *
     * Database Tables used in this function are : tbl_invoice, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objWholesaler->WholesalerCommissionList($argWhere = '', $argLimit = '')
     */
    function WholesalerCommissionList($argWhere = '', $argLimit = '') {
        global $objGeneral;
        $arrClms = array(
            'i.pkInvoiceID',
            'i.InvoiceDateAdded',
            'i.fkOrderID',
            'i.fkSubOrderID',
            'i.fkWholesalerID',
            'w.CompanyName',
            'i.AmountPayable',
            'i.AmountDue',
            'i.InvoiceFileName',
            'i.TransactionStatus',
            'w.Commission',
            'w.CompanyEmail'
        );
        $this->getSortColumnCommission($_REQUEST);
        $varTable = TABLE_INVOICE . ' AS i LEFT JOIN ' . TABLE_WHOLESALER . ' AS w ON i.fkWholesalerID = w.pkWholesalerID';
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $this->orderOptions, $argLimit);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function UpdateWholesalerPayment
     *
     * This function is used to update the Wholesaler Payment.
     *
     * Database Tables used in this function are : tbl_invoice, tbl_admin_payment
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrAddID
     *
     * User instruction: $objWholesaler->UpdateWholesalerPayment($arrPost) 
     */
    function UpdateWholesalerPayment($arrPost) {
        $objCore = new Core();
        $varWhr = " pkInvoiceID ='" . $arrPost['InvoiceID'] . "' ";
        $arrRes = $this->select(TABLE_INVOICE, array('AmountPayable', 'AmountDue'), $varWhr);

        $amountDue = $arrRes[0]['AmountDue'] - $arrPost['paymentAmount'];
        if ($amountDue > 0) {
            $TransactionStatus = 'Partial';
        } else {
            $TransactionStatus = 'Completed';
        }

        $arrClms = array('fkInvoiceID' => $arrPost['InvoiceID'], 'ToUserType' => 'wholesaler', 'ToUserID' => $arrPost['WholesalerID'], 'paymentMode' => $arrPost['paymentMode'], 'paymentAmount' => $arrPost['paymentAmount'], 'paymentDate' => $objCore->defaultDateTime($arrPost['paymentDate'], DATE_FORMAT_DB), 'Comment' => $arrPost['paymentComment'], 'PaymentDateAdded' => date(DATE_TIME_FORMAT_DB));
        $arrAddID = $this->insert(TABLE_ADMIN_PAYMENT, $arrClms);

        $varWhr = " pkInvoiceID ='" . $arrPost['InvoiceID'] . "'";
        $arrClms = array('TransactionStatus' => $TransactionStatus, 'AmountDue' => $amountDue);
        $arrUpdateID = $this->update(TABLE_INVOICE, $arrClms, $varWhr);

        return $arrAddID;
    }

    /**
     * function addWholesaler
     *
     * This function is used to add the Wholesaler.
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_wholesaler_to_shipping_gateway
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrAddID
     *
     * User instruction: $objWholesaler->addWholesaler($arrPost)
     */
    function addWholesaler($arrPost) {

        $varNum = $this->CountWholesalerEmail(" AND CompanyEmail = '" . $arrPost['frmCompanyEmail'] . "' ");

        if ($varNum == 0) {

            $arrClms = array(
                'CompanyName' => $arrPost['frmCompanyName'],
                'AboutCompany' => $arrPost['frmAboutCompany'],
                'Services' => $arrPost['frmServices'],
                'Commission' => $arrPost['frmCommission'],
                'CompanyAddress1' => $arrPost['frmCompanyAddress1'],
                'CompanyAddress2' => $arrPost['frmCompanyAddress2'],
                'CompanyCity' => $arrPost['frmCompanyCity'],
                'CompanyCountry' => $arrPost['frmCompanyCountry'],
                'CompanyState' => $arrPost['CompanyState'],
                'CompanyCity' => $arrPost['CompanyCity'],
                'CompanyRegion' => $arrPost['frmCompanyRegion'],
                'CompanyPostalCode' => $arrPost['frmCompanyPostalCode'],
                'CompanyWebsite' => $arrPost['frmCompanyWebsite'],
                'CompanyEmail' => $arrPost['frmCompanyEmail'],
                'CompanyPassword' => md5(trim($arrPost['frmPassword'])),
                'PaypalEmail' => $arrPost['frmPaypalEmail'],
                'CompanyPhone' => $arrPost['frmCompanyPhone'],
                'CompanyFax' => $arrPost['frmCompanyFax'],
                'ContactPersonName' => $arrPost['frmContactPersonName'],
                'ContactPersonPosition' => $arrPost['frmContactPersonPosition'],
                'ContactPersonPhone' => $arrPost['frmContactPersonPhone'],
                'ContactPersonEmail' => $arrPost['frmContactPersonEmail'],
                'ContactPersonAddress' => $arrPost['frmContactPersonAddress'],
                'OwnerName' => $arrPost['frmOwnerName'],
                'OwnerPhone' => $arrPost['frmOwnerPhone'],
                'OwnerEmail' => $arrPost['frmOwnerEmail'],
                'OwnerAddress' => $arrPost['frmOwnerAddress'],
                'Ref1Name' => $arrPost['frmRef1Name'],
                'Ref1Phone' => $arrPost['frmRef1Phone'],
                'Ref1Email' => $arrPost['frmRef1Email'],
                'Ref1CompanyName' => $arrPost['frmRef1CompanyName'],
                'Ref1CompanyAddress' => $arrPost['frmRef1CompanyAddress'],
                'Ref2Name' => $arrPost['frmRef2Name'],
                'Ref2Phone' => $arrPost['frmRef2Phone'],
                'Ref2Email' => $arrPost['frmRef2Email'],
                'Ref2CompanyName' => $arrPost['frmRef2CompanyName'],
                'Ref2CompanyAddress' => $arrPost['frmRef2CompanyAddress'],
                'Ref3Name' => $arrPost['frmRef3Name'],
                'Ref3Phone' => $arrPost['frmRef3Phone'],
                'Ref3Email' => $arrPost['frmRef3Email'],
                'Ref3CompanyName' => $arrPost['frmRef3CompanyName'],
                'Ref3CompanyAddress' => $arrPost['frmRef3CompanyAddress'],
                'WholesalerStatus' => 'active',
                'IsEmailVerified' => '1',
                'WholesalerDateAdded' => date(DATE_TIME_FORMAT_DB),
                'WholesalerDateUpdated' => date(DATE_TIME_FORMAT_DB)
            );
            $arrAddID = $this->insert(TABLE_WHOLESALER, $arrClms);

            if ($arrAddID > 0) {

                foreach ($arrPost['frmShippingGateway'] as $key => $val) {
                    $arrCls = array(
                        'fkWholesalerID' => $arrAddID,
                        'fkShippingGatewaysID' => $val
                    );
                    $this->insert(TABLE_WHOLESALER_TO_SHIPPING_GATEWAY, $arrCls);
                }

                $objTemplate = new EmailTemplate();
                $objCore = new Core();

                $varUserName = trim(strip_tags($arrPost['frmCompanyEmail']));
                $varPassword = trim(strip_tags($arrPost['frmPassword']));

                $varToUser = $varUserName;

                $varFromUser = $_SESSION['sessAdminEmail'];

                $varSiteName = SITE_NAME;

                $varWhereTemplate = " EmailTemplateTitle= 'WholeSalerAddedByAdmin' AND EmailTemplateStatus = 'Active' ";

                $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                $varPathImage = '';
                $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                $varKeyword = array('{IMAGE_PATH}', '{WHOLESALER}', '{SITE_NAME}', '{USER_NAME}', '{PASSWORD}', '{SITE_NAME}');

                $varKeywordValues = array($varPathImage, $arrPost['frmCompanyName'], SITE_NAME, $varUserName, $varPassword, SITE_NAME);

                $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                // Calling mail function

                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
            }

            return $arrAddID;
        } else {
            return 'exist';
        }
    }

    /**
     * function editWholesaler
     *
     * This function is used to edit the Wholesaler.
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_country, tbl_region, tbl_wholesaler_to_shipping_gateway
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRow
     *
     * User instruction: $objWholesaler->editWholesaler($argID) 
     */
    function editWholesaler($argID) {
        $varWhr = $argID;

        $arrClms = array(
            'pkWholesalerID',
            'CompanyName',
            'AboutCompany',
            'Services',
            'Commission',
            'CompanyAddress1',
            'CompanyAddress2',
            'CompanyCity',
            'CompanyCountry',
            'CompanyState',
            'name',
            'CompanyRegion',
            'RegionName',
            'CompanyPostalCode',
            'CompanyWebsite',
            'CompanyEmail',
            'CompanyPassword',
            'PaypalEmail',
            'CompanyPhone',
            'CompanyFax',
            'ContactPersonName',
            'ContactPersonPosition',
            'ContactPersonPhone',
            'ContactPersonEmail',
            'ContactPersonAddress',
            'OwnerName',
            'OwnerPhone',
            'OwnerEmail',
            'OwnerAddress',
            'Ref1Name',
            'Ref1Phone',
            'Ref1Email',
            'Ref1CompanyName',
            'Ref1CompanyAddress',
            'Ref2Name',
            'Ref2Phone',
            'Ref2Email',
            'Ref2CompanyName',
            'Ref2CompanyAddress',
            'Ref3Name',
            'Ref3Phone',
            'Ref3Email',
            'Ref3CompanyName',
            'Ref3CompanyAddress',
            'WholesalerStatus'
        );

        $varTable = TABLE_WHOLESALER . ' LEFT JOIN ' . TABLE_COUNTRY . ' ON CompanyCountry=country_id LEFT JOIN ' . TABLE_REGION . ' ON CompanyRegion = pkRegionID';
        $arrRow = $this->select($varTable, $arrClms, $varWhr);

        $arrShippingDetails = $this->getArrayResult("SELECT GROUP_CONCAT(fkShippingGatewaysID) as ShippingGateway FROM " . TABLE_WHOLESALER_TO_SHIPPING_GATEWAY . " where fkWholesalerID= '" . $arrRow[0]['pkWholesalerID'] . "' GROUP BY fkWholesalerID");
        $arrRow[0]['shippingDetails'] = explode(',', $arrShippingDetails[0]['ShippingGateway']);
        //pre($arrRow);
        return $arrRow;
    }

    /**
     * function updateWholesaler
     *
     * This function is used to update the Wholesaler.
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_wholesaler_to_shipping_gateway
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRow
     *
     * User instruction: $objWholesaler->updateWholesaler($arrPost) 
     */
    function updateWholesaler($arrPost) {


        global $objGeneral;


        $varNum = $this->CountWholesalerEmail(" AND CompanyEmail = '" . $arrPost['frmCompanyEmail'] . "' AND pkWholesalerID!=" . $_GET['id']);

        if ($varNum == 0) {
            $varWhr = 'pkWholesalerID = ' . $_GET['id'];


            if (($arrPost['frmPassword'] == '' || $arrPost['frmPassword'] == ADMIN_XXX)) {
                $varPassword = '';
            } else {
                $varPassword = 'Password: ' . trim(strip_tags($arrPost['frmPassword']));
                $varPasswordDb = md5(trim($arrPost['frmPassword']));
            }

            $arrClms = array(
                'CompanyName' => $arrPost['frmCompanyName'],
                'AboutCompany' => $arrPost['frmAboutCompany'],
                'Services' => $arrPost['frmServices'],
                'Commission' => $arrPost['frmCommission'],
                'CompanyAddress1' => $arrPost['frmCompanyAddress1'],
                'CompanyAddress2' => $arrPost['frmCompanyAddress2'],
               
                'CompanyCountry' => $arrPost['frmCompanyCountry'],
                'CompanyState' => $arrPost['CompanyState'],
                'CompanyCity' => $arrPost['CompanyCity'],
                'CompanyRegion' => $arrPost['frmCompanyRegion'],
                'CompanyPostalCode' => $arrPost['frmCompanyPostalCode'],
                'CompanyWebsite' => $arrPost['frmCompanyWebsite'],
                'CompanyEmail' => $arrPost['frmCompanyEmail'],
                'CompanyPassword' => $varPasswordDb,
                'PaypalEmail' => $arrPost['frmPaypalEmail'],
                'CompanyPhone' => $arrPost['frmCompanyPhone'],
                'CompanyFax' => $arrPost['frmCompanyFax'],
                'ContactPersonName' => $arrPost['frmContactPersonName'],
                'ContactPersonPosition' => $arrPost['frmContactPersonPosition'],
                'ContactPersonPhone' => $arrPost['frmContactPersonPhone'],
                'ContactPersonEmail' => $arrPost['frmContactPersonEmail'],
                'ContactPersonAddress' => $arrPost['frmContactPersonAddress'],
                'OwnerName' => $arrPost['frmOwnerName'],
                'OwnerPhone' => $arrPost['frmOwnerPhone'],
                'OwnerEmail' => $arrPost['frmOwnerEmail'],
                'OwnerAddress' => $arrPost['frmOwnerAddress'],
                'Ref1Name' => $arrPost['frmRef1Name'],
                'Ref1Phone' => $arrPost['frmRef1Phone'],
                'Ref1Email' => $arrPost['frmRef1Email'],
                'Ref1CompanyName' => $arrPost['frmRef1CompanyName'],
                'Ref1CompanyAddress' => $arrPost['frmRef1CompanyAddress'],
                'Ref2Name' => $arrPost['frmRef2Name'],
                'Ref2Phone' => $arrPost['frmRef2Phone'],
                'Ref2Email' => $arrPost['frmRef2Email'],
                'Ref2CompanyName' => $arrPost['frmRef2CompanyName'],
                'Ref2CompanyAddress' => $arrPost['frmRef2CompanyAddress'],
                'Ref3Name' => $arrPost['frmRef3Name'],
                'Ref3Phone' => $arrPost['frmRef3Phone'],
                'Ref3Email' => $arrPost['frmRef3Email'],
                'Ref3CompanyName' => $arrPost['frmRef3CompanyName'],
                'Ref3CompanyAddress' => $arrPost['frmRef3CompanyAddress'],
                'WholesalerStatus' => $arrPost['frmWholesalerStatus'],
                'WholesalerDateUpdated' => date(DATE_TIME_FORMAT_DB)
            );


            $arrUpdateID = $this->update(TABLE_WHOLESALER, $arrClms, $varWhr);

            $this->delete(TABLE_WHOLESALER_TO_SHIPPING_GATEWAY, " fkWholesalerID = " . $_GET['id']);
            foreach ($arrPost['frmShippingGateway'] as $key => $val) {
                $arrCls = array(
                    'fkWholesalerID' => $_GET['id'],
                    'fkShippingGatewaysID' => $val
                );
                $this->insert(TABLE_WHOLESALER_TO_SHIPPING_GATEWAY, $arrCls);
            }


            if ($arrUpdateID > 0) {
                $objTemplate = new EmailTemplate();
                $objCore = new Core();

                if (in_array($arrPost['frmWholesalerStatus'], array('deactive', 'suspend', 'reject', 'pending'))) {
                    $objGeneral->solrProductRemoveAdd("fkWholesalerID='" . $_GET['id'] . "'");
                }


                $arrStatus = array('active' => 'Activated', 'deactive' => 'Deactivated', 'suspend' => 'Suspended', 'approve' => 'Approved', 'reject' => 'Rejected', 'pending' => 'Pending');
                if ($arrPost['frmWholesalerStatus'] != $arrPost['frmWholesalerOldStatus']) {
                    $varStatus = '<br/>Your account has been ' . $arrStatus[$arrPost['frmWholesalerStatus']] . '<br/>';
                } else {
                    $varStatus = '';
                }
                $varUserName = trim(strip_tags($arrPost['frmCompanyEmail']));


                $varToUser = $varUserName;

                $varFromUser = $_SESSION['sessAdminEmail'];

                $varSiteName = SITE_NAME;

                $varWhereTemplate = " EmailTemplateTitle= 'WholeSalerUpdatedByAdmin' AND EmailTemplateStatus = 'Active' ";

                $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                $varPathImage = '';
                $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                $varKeyword = array('{IMAGE_PATH}', '{WHOLESALER}', '{SITE_NAME}', '{USER_NAME}', '{PASSWORD}', '{SITE_NAME}', '{WHOLESALER_STATUS}');

                $varKeywordValues = array($varPathImage, $arrPost['frmCompanyName'], SITE_NAME, $varUserName, $varPassword, SITE_NAME, $varStatus);

                $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                // Calling mail function

                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
            }

            return $arrUpdateID;
        } else {
            return 0;
        }
    }

    /**
     * function UpdateWholesalerStatus
     *
     * This function is used to update the Wholesaler status.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrUpdateID
     *
     * User instruction: $objWholesaler->UpdateWholesalerStatus($argVal, $varWhre)
     */
    function UpdateWholesalerStatus($argVal, $varWhre) {
        global $objGeneral;
		
        $varWhr = " pkWholesalerID ='" . $varWhre . "' ";

        $arrRes = $this->select(TABLE_WHOLESALER, array('WholesalerStatus'), $varWhr);
        
        /* This code is commented by Krishna Gupta ( 05-10-2015 )  */
        /* if ($arrRes[0]['WholesalerStatus'] == 'suspend' && $argVal == 'active') {
            $this->resetWholesalerKpi($varWhre);
        }
		
        if (in_array($argVal, array('deactive', 'suspend', 'reject'))) {
            $objGeneral->solrProductRemoveAdd("fkWholesalerID='" . $varWhre . "'");
        } */
        /* This code is commented by Krishna Gupta ( 05-10-2015 ) end */

        $arrClms = array('WholesalerStatus' => $argVal, 'WholesalerDateUpdated' => date(DATE_TIME_FORMAT_DB));
        $arrUpdateID = $this->update(TABLE_WHOLESALER, $arrClms, $varWhr);
        return $arrUpdateID;
    }

    /**
     * function UpdateWholesalerStatus
     *
     * This function is used to update the Wholesaler status.
     *
     * Database Tables used in this function are : tbl_special_application
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrUpdateID
     *
     * User instruction: $objWholesaler->UpdateWholesalerStatus($argVal, $varWhre)
     */
    function UpdateWholesalerSpecialApplicationStatus($argVal, $varWhre) {
        global $objGeneral;

        $varWhr = " pkApplicationID ='" . $varWhre . "' ";
        $arrClms = array('IsApproved' => $argVal);
        $arrUpdateID = $this->update(TABLE_SPECIAL_APPLICATION, $arrClms, $varWhr);
        return $arrUpdateID;
    }

    /**
     * function removeWholesaler
     *
     * This function is used to remove the Wholesaler.
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_wholesaler_documents, tbl_wholesaler_feedback, tbl_wholesaler_to_shipping_gateway, tbl_wholesaler_warning, tbl_package, tbl_product, tbl_product_image, tbl_product_rating, tbl_product_to_package, tbl_product_to_option, tbl_recommendtbl_review, tbl_wishlist
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrUpdateID
     *
     * User instruction: $objWholesaler->removeWholesaler($argPostIDs, $varPortalFilter) 
     */
    function removeWholesaler($argPostIDs, $varPortalFilter) {
        global $objGeneral;

        $varWhere = "pkWholesalerID = '" . $argPostIDs['frmID'] . "'" . $varPortalFilter;
        $num = $this->delete(TABLE_WHOLESALER, $varWhere);

        if ($num > 0) {
            $varWhere = "fkWholesalerID = '" . $argPostIDs['frmID'] . "'";

            $objGeneral->solrProductRemoveAdd($varWhere);

            $this->delete(TABLE_WHOLESALER_DOCUMENTS, $varWhere);
            $this->delete(TABLE_WHOLESALER_FEEDBACK, $varWhere);
            $this->delete(TABLE_WHOLESALER_TO_SHIPPING_GATEWAY, $varWhere);
            $this->delete(TABLE_WHOLESALER_WARNING, $varWhere);
            $this->delete(TABLE_PACKAGE, $varWhere);
            $arrRes = $this->select(TABLE_PRODUCT, array('pkProductID'), $varWhere);
            foreach ($arrRes as $k => $val) {
                $varWhr = " fkProductID = '" . $val['pkProductID'] . "' ";
                $this->delete(TABLE_PRODUCT_IMAGE, $varWhr);
                $this->delete(TABLE_PRODUCT_RATING, $varWhr);
                $this->delete(TABLE_PRODUCT_TO_OPTION, $varWhr);
                $this->delete(TABLE_PRODUCT_TO_PACKAGE, $varWhr);
                $this->delete(TABLE_RECOMMEND, $varWhr);
                $this->delete(TABLE_REVIEW, $varWhr);
                $this->delete(TABLE_WISHLIST, $varWhr);
            }
            $this->delete(TABLE_PRODUCT, $varWhere);
        }
        return $num;
    }

    /**
     * function removeAllWholesaler
     *
     * This function is used to remove all Wholesaler.
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_wholesaler_documents, tbl_wholesaler_feedback, tbl_wholesaler_to_shipping_gateway, tbl_wholesaler_warning, tbl_package, tbl_product, tbl_product_image, tbl_product_rating, tbl_product_to_package, tbl_product_to_option, tbl_recommendtbl_review, tbl_wishlist
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $ctr
     *
     * User instruction: $objWholesaler->removeAllWholesaler($argPostIDs, $varPortalFilter) 
     */
    function removeAllWholesaler($argPostIDs, $varPortalFilter) {
        global $objGeneral;

        $ctr = 0;

        foreach ($argPostIDs['frmID'] as $valDeleteID) {
            $varWhere = "pkWholesalerID = '" . $valDeleteID . "'" . $varPortalFilter;
            $num = $this->delete(TABLE_WHOLESALER, $varWhere);
            if ($num > 0) {
                $ctr++;
                $varWhere = "fkWholesalerID = '" . $valDeleteID . "'";

                $objGeneral->solrProductRemoveAdd($varWhere);

                $this->delete(TABLE_WHOLESALER_DOCUMENTS, $varWhere);
                $this->delete(TABLE_WHOLESALER_FEEDBACK, $varWhere);
                $this->delete(TABLE_WHOLESALER_TO_SHIPPING_GATEWAY, $varWhere);
                $this->delete(TABLE_WHOLESALER_WARNING, $varWhere);
                $this->delete(TABLE_PACKAGE, $varWhere);
                $arrRes = $this->select(TABLE_PRODUCT, array('pkProductID'), $varWhere);
                foreach ($arrRes as $k => $val) {
                    $varWhr = " fkProductID = '" . $val['pkProductID'] . "' ";
                    $this->delete(TABLE_PRODUCT_IMAGE, $varWhr);
                    $this->delete(TABLE_PRODUCT_RATING, $varWhr);
                    $this->delete(TABLE_PRODUCT_TO_OPTION, $varWhr);
                    $this->delete(TABLE_PRODUCT_TO_PACKAGE, $varWhr);
                    $this->delete(TABLE_RECOMMEND, $varWhr);
                    $this->delete(TABLE_REVIEW, $varWhr);
                    $this->delete(TABLE_WISHLIST, $varWhr);
                }
            }
            $this->delete(TABLE_PRODUCT, $varWhere);
        }
        return $ctr;
    }

    /**
     * function removeWholesalerSpecial
     *
     * This function is used to remove the Wholesaler.
     *
     * Database Tables used in this function are : tbl_special_application, tbl_special_application_to_category
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrUpdateID
     *
     * User instruction: $objWholesaler->removeWholesalerSpecial($argPostIDs, $varPortalFilter) 
     */
    function removeWholesalerSpecial($argPostIDs, $varPortalFilter) {
        global $objGeneral;

        $varWhere = "pkApplicationID = '" . $argPostIDs['frmID'] . "'" . $varPortalFilter;
        $num = $this->delete(TABLE_SPECIAL_APPLICATION, $varWhere);

        if ($num > 0) {
            $varWhere = "fkApplicationID = '" . $argPostIDs['frmID'] . "'";
            $this->delete(TABLE_SPECIAL_APPLICATION_TO_CATEGORY, $varWhere);
        }
        return $num;
    }

    /**
     * function removeAllWholesalerSpecial
     *
     * This function is used to remove all Wholesaler.
     *
     * Database Tables used in this function are : tbl_special_application, tbl_special_application_to_category
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $ctr
     *
     * User instruction: $objWholesaler->removeAllWholesalerSpecial($argPostIDs, $varPortalFilter) 
     */
    function removeAllWholesalerSpecial($argPostIDs, $varPortalFilter) {
        global $objGeneral;

        $ctr = 0;

        foreach ($argPostIDs['frmID'] as $valDeleteID) {
            $varWhere = "pkApplicationID = '" . $valDeleteID . "'" . $varPortalFilter;
            $num = $this->delete(TABLE_SPECIAL_APPLICATION, $varWhere);
            if ($num > 0) {
                $ctr++;
                $varWhere = "fkApplicationID = '" . $valDeleteID . "'";

                $this->delete(TABLE_SPECIAL_APPLICATION_TO_CATEGORY, $varWhere);
            }
        }
        return $ctr;
    }

    /**
     * function insertWholesalerWarning
     *
     * This function is used to insert Wholesaler Warning.
     *
     * Database Tables used in this function are : tbl_wholesaler_warning
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrAddID
     *
     * User instruction: $objWholesaler->insertWholesalerWarning($arrPost) 
     */
    function insertWholesalerWarning($arrPost) {
       // pre($arrPost);
        

        $WarningText = ($arrPost['$varWarnNo'] + 1) . ' Warning Letter';

        $arrClms = array(
            'fkWholesalerID' => $arrPost['id'],
            'WarningMsg' => $arrPost['msg'],
            'WarningText' => $WarningText,
            'WarningDateAdded' => date(DATE_TIME_FORMAT_DB)
        );
        $arrAddID = $this->insert(TABLE_WHOLESALER_WARNING, $arrClms);
    }

    /**
     * function warningList
     *
     * This function is used to display warning List.
     *
     * Database Tables used in this function are : tbl_wholesaler_warning
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objWholesaler->warningList($argWhere)
     */
    function warningList($argWhere) {
        $varWhere = 'fkWholesalerID=' . $argWhere;

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
     * function getSortColumn
     *
     * This function is used to sort columns .
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $varStrLnkSrtClmn
     *
     * User instruction: $objWholesaler->getSortColumn($argVarSortOrder) 
     */
    function getSortColumn($argVarSortOrder) {

        $objCore = new Core();
        //Default order by setting
        if ($argVarSortOrder['orderBy'] == '') {
            $varOrderBy = 'DESC';
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
        $objOrder->addColumn('Ref No.', 'pkWholesalerID', '', 'hidden-480');
        $objOrder->addColumn('Wholesaler Name', 'CompanyName');
        $objOrder->addColumn('Sales Commission', 'Commission', '', 'hidden-480');

        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function getSortColumnSpecial
     *
     * This function is used to sort columns .
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $varStrLnkSrtClmn
     *
     * User instruction: $objWholesaler->getSortColumn($argVarSortOrder) 
     */
    function getSortColumnSpecial($argVarSortOrder) {

        $objCore = new Core();
        //Default order by setting
        if ($argVarSortOrder['orderBy'] == '') {
            $varOrderBy = 'DESC';
        } else {
            $varOrderBy = $argVarSortOrder['orderBy'];
        }
        //Default sort by setting
        if ($argVarSortOrder['sortBy'] == '') {
            $varSortBy = 'pkApplicationID';
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
        $objOrder->addColumn('Application ID', 'pkApplicationID', '', 'hidden-480');
        $objOrder->addColumn('Transaction ID', 'TransactionID', '', 'hidden-480');
        $objOrder->addColumn('Wholesaler Name', 'CompanyName');
        $objOrder->addColumn('Specials/Events', 'BannerTitle', '', 'hidden-480');
        $objOrder->addColumn('Country', 'CountryName', '', 'hidden-1024');
        $objOrder->addColumn('Amount', 'TotalAmount', '', 'hidden-480');
        $objOrder->addColumn('Added Date', 'ApplicatonDateAdded', '', 'hidden-1024');

        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function getSortColumnKPI
     *
     * This function is used to sort columns of KPI.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $varStrLnkSrtClmn
     *
     * User instruction: $objWholesaler->getSortColumnKPI($argVarSortOrder) 
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
        $objOrder->addColumn('Ref No.', 'pkWholesalerID');
        $objOrder->addColumn('Wholesaler Name', 'CompanyName');

        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function getSortColumnCommission
     *
     * This function is used to sort columns of Commission.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $varStrLnkSrtClmn
     *
     * User instruction: $objWholesaler->getSortColumnCommission($argVarSortOrder)
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
        $objOrder->addColumn('Invoice Date', 'InvoiceDateAdded', '', 'hidden-1024');
        $objOrder->addColumn('Order Id', 'fkOrderID', '', 'hidden-1024');
        $objOrder->addColumn('SubOrder Id', 'fkSubOrderID', '', 'hidden-480');
        $objOrder->addColumn('Wholesaler ID', 'fkWholesalerID', '', 'hidden-1024');
        $objOrder->addColumn('Wholesaler Name', 'CompanyName');
        $objOrder->addColumn('Amount Payablel', 'Amount', '', 'hidden-480');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function resetWholesalerKpi
     *
     * This function is used to reset Wholesaler Kpi.
     *
     * Database Tables used in this function are : tbl_wholesaler_warning,tbl_wholesaler_feedback
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return ''
     *
     * User instruction: $objWholesaler->resetWholesalerKpi($whId)
     */
    function resetWholesalerKpi($whId) {
        $varWhere = "fkWholesalerID = '" . $whId . "'";

        $this->delete(TABLE_WHOLESALER_WARNING, $varWhere);
        $this->delete(TABLE_WHOLESALER_FEEDBACK, $varWhere);
    }

    /**
     * function findCountryName
     *
     * This function is used to find Country Name.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objWholesaler->findCountryName($argCountryCode) 
     */
    function findCountryName($argCountryCode) {
        $arrClms = array('name');
        $varID = "country_id='" . trim($argCountryCode) . "'";
        $varTable = TABLE_COUNTRY;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes[0]['name'];
    }

    /**
     * function findCountryRegionName
     *
     * This function is used to find Country Region Name.
     *
     * Database Tables used in this function are : tbl_region
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objWholesaler->findCountryRegionName($argCountryCode) 
     */
    function findCountryRegionName($argCountryCode) {
        $arrClms = array('RegionName');
        $varID = "pkRegionID= " . $argCountryCode . " ";
        $varTable = TABLE_REGION;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes[0]['pkRegionID'];
    }

    /**
     * function findWholesalerShippingMethod
     *
     * This function is used to find Wholesaler Shipping Method.
     *
     * Database Tables used in this function are : tbl_wholesaler_to_shipping_gateway, tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRow
     *
     * User instruction: $objWholesaler->findWholesalerShippingMethod($argWholesalerId) 
     */
    function findWholesalerShippingMethod($argWholesalerId) {
        $varQuery = "SELECT ShippingTitle FROM " . TABLE_WHOLESALER_TO_SHIPPING_GATEWAY . " LEFT JOIN " . TABLE_SHIPPING_GATEWAYS . " on pkShippingGatewaysID = fkShippingGatewaysID where fkWholesalerID = " . $argWholesalerId . " ";
        $arrRow = $this->getArrayResult($varQuery);
        //pre($arrRow);
        return $arrRow;
    }

    /**
     * function transactionDetails
     *
     * This function is used to dispaly transaction Details.
     *
     * Database Tables used in this function are : tbl_admin_payment, tbl_wholesaler, tbl_invoice
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRow
     *
     * User instruction: $objWholesaler->transactionDetails($argWhere = '', $argLimit = '') 
     */
    function transactionDetails($argWhere = '', $argLimit = '') {
        if ($argLimit != '') {
            $varLimit = "limit " . $argLimit . " ";
        }
        $this->getSortColumn($_REQUEST);
        $varQuery = "SELECT pkAdminPaymentID ,fkInvoiceID,CompanyName,PaymentMode,PaymentAmount,PaymentDate,Comment,PaymentDateAdded FROM " . TABLE_ADMIN_PAYMENT . " as pay LEFT JOIN " . TABLE_WHOLESALER . " on pkWholesalerID = ToUserID LEFT JOIN " . TABLE_INVOICE . " on pkInvoiceID=fkInvoiceID  where " . $argWhere . " order by " . $this->orderOptions . " " . $varLimit . " ";
        $arrRow = $this->getArrayResult($varQuery);
        //pre($arrRow);
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
     * @parameters 2 string
     *
     * @return true
     *
     * User instruction: $objWholesaler->removeTransaction($argPostID, $varPortalFilter) 
     */
    function removeTransaction($argPostID, $varPortalFilter) {
        $varWhere = "ToUserType = 'wholesaler' AND pkAdminPaymentID = '" . $argPostID['frmID'] . "'" . $varPortalFilter;
        $this->delete(TABLE_ADMIN_PAYMENT, $varWhere);
        return true;
    }

    /**
     * function removeAllTransaction
     *
     * This function is used to remove all transaction.
     *
     * Database Tables used in this function are : tbl_admin_payment
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return true
     *
     * User instruction: $objWholesaler->removeAllTransaction($argPostID, $varPortalFilter)
     */
    function removeAllTransaction($argPostID, $varPortalFilter) {

        foreach ($argPostID['frmID'] as $valDeltetID) {
            $varWhere = "ToUserType = 'wholesaler' AND pkAdminPaymentID = '" . $valDeltetID . "'" . $varPortalFilter;
            $this->delete(TABLE_ADMIN_PAYMENT, $varWhere);
        }
        return true;
    }

    /**
     * function getSortColumnTransaction
     *
     * This function is used to sort columns .
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $varStrLnkSrtClmn
     *
     * User instruction: $objWholesaler->getSortColumnTransaction($argVarSortOrder)
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
        $objOrder->addColumn('Wholesaler Name', 'CompanyName');
        $objOrder->addColumn('Payment Mode', 'PaymentMode', '', 'hidden-480');
        $objOrder->addColumn('Payment Amount', 'PaymentAmount', '', 'hidden-480');
        $objOrder->addColumn('Comment', 'Comment', '', 'hidden-1024');
        $objOrder->addColumn('Payment Date', 'PaymentDate', '', 'hidden-480');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function viewInvoice
     *
     * This function is used to view Invoice .
     *
     * Database Tables used in this function are : tbl_invoice
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrData
     *
     * User instruction: $objWholesaler->viewInvoice($argID, $varPortalFilter)
     */
    function viewInvoice($argID, $varPortalFilter) {
        $varID = " FromUserType in('wholesaler') AND ToUserType in ('super-admin','user-admin') AND pkInvoiceID ='" . $argID . "' " . $varPortalFilter;
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
        //pre($arrData);
        return $arrData;
    }

}

?>
