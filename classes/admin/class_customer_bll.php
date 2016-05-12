<?php

/**
 * 
 * Class name : customer
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The customer class is used to maintain customer infomation details for several modules.
 */
class customer extends Database {

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
     * function shippingGatewayList
     *
     * This function is used to display the shipping GatewayList List.
     *
     * Database Tables used in this function are : tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters ''
     *
     * @return $arrRes
     *
     * User instruction: $objCustomer->shippingGatewayList()
     */
    function shippingGatewayList() {
        $arrClms = array(
            'pkShippingGatewaysID',
            'ShippingTitle',
        );
        $argWhere = 'ShippingStatus=1';
        $varOrderBy = 'ShippingType ASC,ShippingTitle ASC ';
        $arrRes = $this->select(TABLE_SHIPPING_GATEWAYS, $arrClms, $argWhere);
        //pre($arrRes);
        return $arrRes;
    }

    function changetable() {
        $argWhere = '';
        $arrClms = array(
            'name',
            'iso_code_2',
            'iso_code_3',
            'address_format',
            'postcode_required',
            'zone',
            'time_zone',
            'status',
        );

        //$arrClms='*';
        // $varOrderBy = 'ShippingType ASC,ShippingTitle ASC ';
        $arrRes = $this->select(tbl_country, $arrClms, $argWhere);

        return $arrRes;
        //$sql="select * from ";
        // pre("here");
    }

    function changerecord($data) {
        // mysql_real_escape_string($data['name']);
        //die();
        $query = "UPDATE `countries` SET `iso_code_2`='" . $data['iso_code_2'] . "',"
                . "`iso_code_3`='" . $data['iso_code_3'] . "',`address_format`='" . $data['address_format'] . "',"
                . "`postcode_required`='" . $data['postcode_required'] . "',`zone`='" . $data['zone'] . "',"
                . "`time_zone`='" . $data['time_zone'] . "',`status`='" . $data['status'] . "' WHERE name='" . mysql_real_escape_string($data['name']) . "'";
        $arrRes = $this->getArrayResult($query);
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
     * User instruction: $objCustomer->countryList()
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
     * User instruction: $objCustomer->regionList($where = '')
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
     * function CountCustomerEmail
     *
     * This function is used to display the Count Customer Email.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrNum
     *
     * User instruction: $objCustomer->ountCustomerEmail($argWhere = '')
     */
    function CountCustomerEmail($argWhere = '') {
        $arrNum = $this->getNumRows(TABLE_CUSTOMER, 'CustomerEmail', $argWhere);
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
     * User instruction: $objCustomer->adminUserList()
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
     * function customerList
     *
     * This function is used to display the customer List.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objCustomer->customerList($argWhere = '', $argLimit = '')
     */
    function customerList($argWhere = '', $argLimit = '') {
        //pre($_SESSION['sessUserType']);
        $varWhr = " AND fkWholesalerID IN (" . $_SESSION['sessAdminWholesalerIDs'] . ")";
        if ($_SESSION['sessUserType'] == 'super-admin') {

            $arrClms = array(
                'pkCustomerID',
                'CustomerFirstName',
                'CustomerLastName',
                'CustomerEmail',
                'BillingPhone',
                'BalancedRewardPoints',
                'CustomerDateAdded',
                'IsEmailVerified',
                'CustomerStatus'
            );
            $varOrderBy = ' pkCustomerID DESC ';
            $this->getSortColumn($_REQUEST);
            // $varTable = TABLE_WHOLESALER.' LEFT JOIN '.TABLE_COUNTRY .' ON CompanyCountry =  country_id LEFT JOIN '.TABLE_REGION.' ON pkRegionID = CompanyRegion';
            $arrRes = $this->select(TABLE_CUSTOMER, $arrClms, $argWhere, $this->orderOptions, $argLimit);
        } else {
            $query = "SELECT fkWholesalerID,pkCustomerID,tbl_customer.CustomerFirstName,tbl_customer.CustomerLastName,
                tbl_customer.CustomerEmail,tbl_customer.BillingPhone,BalancedRewardPoints,
                CustomerDateAdded,IsEmailVerified,CustomerStatus 
                FROM tbl_customer LEFT JOIN tbl_order ON fkCustomerID = pkCustomerID 
                LEFT JOIN tbl_order_items ON pkOrderID = fkOrderID  
                WHERE  1 " . $varWhr . " GROUP BY tbl_order.fkCustomerID  ORDER BY pkCustomerID DESC";
            $arrRes = $this->getArrayResult($query);
        }
        //pre($query);
        // find Country Portal

        /*  foreach($arrRes as $k1=>$v1){

          $arrRes[$k1]['CountryRegionPortalUser'] ='-';
          $arrRes[$k1]['CountryRegionPortal'] = '';

          if($v1['CompanyRegion']>0){

          $varNumRegPortal =  $this->getNumRows(TABLE_ADMIN, 'pkAdminID', ' AND AdminRegion = '.$v1['CompanyRegion']);

          if($varNumRegPortal>0){
          //find wholesaler region   Portal
          $arrRes[$k1]['CountryRegionPortal'] =  $v1['CountryName'].'-'.$v1['RegionName'];
          $arrRes[$k1]['ShowRegion'] = $v1['CompanyRegion'];
          $arrDataR = $this->select(TABLE_ADMIN, array('AdminUserName'), ' AdminRegion = '.$v1['CompanyRegion']);
          $arrRes[$k1]['CountryRegionPortalUser'] = $arrDataR[0]['AdminUserName'];

          }else{
          //find wholesaler Country Portal
          $varNumCounPortal =  $this->getNumRows(TABLE_ADMIN, 'pkAdminID', ' AND AdminCountry = '.$v1['CompanyCountry']);
          if($varNumCounPortal > 0){
          $arrRes[$k1]['CountryRegionPortal'] =  $v1['CountryName'];
          $arrDataU = $this->select(TABLE_ADMIN, array('AdminUserName'), ' AdminCountry = '.$v1['CompanyCountry']);
          $arrRes[$k1]['CountryRegionPortalUser'] = $arrDataU[0]['AdminUserName'];
          }else{
          $arrRes[$k1]['CountryRegionPortalUser'] = '-';
          }
          }

          }else{
          //find wholesaler Country Portal
          $varNumCounPortal =  $this->getNumRows(TABLE_ADMIN, 'pkAdminID', ' AND AdminCountry = '.$v1['CompanyCountry']);
          if($varNumCounPortal > 0){
          $arrRes[$k1]['CountryRegionPortal'] =  $v1['CountryName'];
          $arrDataU = $this->select(TABLE_ADMIN, array('AdminUserName'), ' AdminCountry = '.$v1['CompanyCountry']);
          $arrRes[$k1]['CountryRegionPortalUser'] = $arrDataU[0]['AdminUserName'];

          }



          }
          } */
        return $arrRes;
    }

    /**
     * function customerExportList
     *
     * This function is used to display the customer List.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objCustomer->customerExportList($argWhere = '', $argLimit = '')
     */
    function customerExportList($argWhere = '', $argLimit = '') {
        $arrClms = array(
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
            'BusinessAddress',
            'Purchased',
            'CustomerDateAdded',
            'CustomerStatus'
        );

        $this->getSortColumn($_REQUEST);
        //$varTable = TABLE_CUSTOMER.' LEFT JOIN '.TABLE_COUNTRY .' ON CompanyCountry =  country_id ';
        $arrRes = $this->select(TABLE_CUSTOMER, $arrClms, $argWhere, $this->orderOptions, $argLimit);
        return $arrRes;
    }

    /**
     * function customerDetails
     *
     * This function is used to display the customer Details.
     *
     * Database Tables used in this function are : tbl_customer, tbl_order, tbl_order_items
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRow
     *
     * User instruction: $objCustomer->customerDetails($argID) 
     */
    function customerDetails($argID) {
        $varWhr = 'pkCustomerID =' . $argID;
        $arrClms = array(
            'pkCustomerID',
            'CustomerFirstName',
            'CustomerLastName',
            'CustomerEmail',
            'CustomerPassword',
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
            'BusinessAddress',
            'Purchased',
            'CustomerStatus',
            'CustomerDateAdded', 'BillingTown', 'ShippingTown', 'ResAddressLine1', 'ResAddressLine2', 'ResPostalCode', 'ResCountry', 'ResTown', 'ResPhone',
            'CustomerWebsiteVisitCount'
        );
        $arrRow = $this->select(TABLE_CUSTOMER, $arrClms, $varWhr);

        $varQuery = "SELECT SUM(ItemTotalPrice) AS TotalAmountSpent FROM " . TABLE_ORDER . " inner join " . TABLE_ORDER_ITEMS . " on pkOrderID = fkOrderID WHERE fkCustomerID='" . $argID . "'";
        $arrRes = $this->getArrayResult($varQuery);
        $arrRow[0]['CustomerTotalAmountSpent'] = !empty($arrRes[0]['TotalAmountSpent']) ? $arrRes[0]['TotalAmountSpent'] : '0.0000';
        return $arrRow;
    }

    /**
     * function findCountryName
     *
     * This function is used to find the Country Name.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrRes
     *
     * User instruction: $objCustomer->findCountryName($argCountryCode)
     */
    function findCountryName($argCountryCode) {
        $arrClms = array('name');
        $varID = "country_id='" . $argCountryCode . "'";
        $varTable = TABLE_COUNTRY;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes[0]['name'];
    }

    /**
     * function addCustomer
     *
     * This function is used to add the Customer.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrAddID
     *
     * User instruction: $objCustomer->addCustomer($arrPost) 
     */
    function addCustomer($arrPost) {
        // pre($arrPost);
        global $objGeneral;
        $varNum = $this->CountCustomerEmail(" AND CustomerEmail = '" . $arrPost['frmEmail'] . "' ");

        $varBillBusinessAdd = ($arrPost['BillingBsinessAddress'] == '1') ? 'Billing' : '';

        $varShipBusinessAdd = ($arrPost['ShippingBsinessAddress'] == '1') ? 'Shipping' : '';

        $varBusinessAddress1 = ($varBillBusinessAdd != "") ? $varBillBusinessAdd : $varShipBusinessAdd;

        $varBusinessAddress = ($varBusinessAddress1 != "") ? $varBusinessAddress1 : 'Billing';

        if ($varNum == 0) {

            $arrClms = array(
                'CustomerFirstName' => $arrPost['CustomerFirstName'],
                'CustomerLastName' => $arrPost['CustomerLastName'],
                'CustomerEmail' => $arrPost['frmEmail'],
                'CustomerPassword' => md5(trim($arrPost['frmPassword'])),
                'ResAddressLine1' => trim($arrPost['frmResAddressLine1']),
                'ResAddressLine2' => trim($arrPost['frmResAddressLine2']),
                'ResCountry' => trim($arrPost['frmResCountry']),
                'ResState' => trim($arrPost['frmResState']),
                'ResCity' => trim($arrPost['frmResCity']),
                'ResPostalCode' => trim($arrPost['ResPostalCode']),
                'ResTown' => trim($arrPost['frmResTown']),
                'ResPhone' => trim($arrPost['frmResPhone']),
                'BillingFirstName' => $arrPost['BillingFirstName'],
                'BillingLastName' => $arrPost['BillingLastName'],
                'BillingOrganizationName' => $arrPost['BillingOrganizationName'],
                'BillingAddressLine1' => $arrPost['BillingAddressLine1'],
                'BillingAddressLine2' => $arrPost['BillingAddressLine2'],
                'BillingCountry' => $arrPost['BillingCountry'],
                'BillingState' => $arrPost['BillingState'],
                'BillingCity' => $arrPost['BillingCity'],
                'BillingPostalCode' => $arrPost['BillingPostalCode'],
                'BillingTown' => trim($arrPost['frmBillingTown']),
                'BillingPhone' => $arrPost['BillingPhone'],
                'ShippingFirstName' => $arrPost['ShippingFirstName'],
                'ShippingLastName' => $arrPost['ShippingLastName'],
                'ShippingOrganizationName' => $arrPost['ShippingOrganizationName'],
                'ShippingAddressLine1' => $arrPost['ShippingAddressLine1'],
                'ShippingAddressLine2' => $arrPost['ShippingAddressLine2'],
                'ShippingCountry' => $arrPost['ShippingCountry'],
                'ShippingState' => $arrPost['ShippingState'],
                'ShippingCity' => $arrPost['ShippingCity'],
                'ShippingPostalCode' => $arrPost['ShippingPostalCode'],
                'ShippingTown' => trim($arrPost['frmShippingTown']),
                'ShippingPhone' => $arrPost['ShippingPhone'],
                'BusinessAddress' => $varBusinessAddress,
                'CustomerStatus' => 'active',
                'IsEmailVerified' => '1',
                'CustomerDateAdded' => date(DATE_TIME_FORMAT_DB)
            );
            $arrAddID = $this->insert(TABLE_CUSTOMER, $arrClms);

            $objGeneral->createReferalId($arrAddID);

            $objTemplate = new EmailTemplate();
            $objCore = new Core();

            $varUserName = trim(strip_tags($arrPost['frmEmail']));
            $varPassword = trim(strip_tags($arrPost['frmPassword']));

            $varToUser = $varUserName;

            $varFromUser = $_SESSION['sessAdminEmail'];

            $varSiteName = SITE_NAME;

            $varWhereTemplate = " EmailTemplateTitle= 'CustomerAddedByAdmin' AND EmailTemplateStatus = 'Active' ";

            $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

            $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

            $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

            $varPathImage = '';
            $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

            $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

            $varKeyword = array('{IMAGE_PATH}', '{CUSTOMER_NAME}', '{USER_NAME}', '{PASSWORD}', '{SITE_NAME}');

            $varKeywordValues = array($varPathImage, ($arrPost['CustomerFirstName'] . ' ' . $arrPost['CustomerLastName']), $varUserName, $varPassword, SITE_NAME);

            $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

            // Calling mail function

            $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);

            return $arrAddID;
        } else {
            return 0;
        }
    }

    /**
     * function editCustomer
     *
     * This function is used to edit the Customer.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $arrAddID
     *
     * User instruction: $objCustomer->editCustomer($argID)
     */
    function editCustomer($argID) {
        $varWhr = 'pkCustomerID =' . $argID;

        $arrClms = array(
            'pkCustomerID',
            'CustomerFirstName',
            'CustomerLastName',
            'CustomerEmail',
            'CustomerPassword',
            'BillingFirstName',
            'BillingLastName',
            'BillingOrganizationName',
            'BillingAddressLine1',
            'BillingAddressLine2',
            'BillingCountry',
            'BillingState',
            'BillingCity',
            'BillingPostalCode',
            'BillingPhone',
            'ShippingFirstName',
            'ShippingLastName',
            'ShippingOrganizationName',
            'ShippingAddressLine1',
            'ShippingAddressLine2',
            'ShippingCountry',
            'ShippingState',
            'ShippingCity',
            'ShippingPostalCode',
            'ShippingPhone',
            'BusinessAddress',
            'Purchased',
            'CustomerStatus', 'BillingTown', 'ShippingTown', 'ResAddressLine1', 'ResAddressLine2', 'ResPostalCode', 'ResCountry', 'ResTown', 'ResPhone', 'ResState', 'ResCity',
            'CustomerDateAdded'
        );

        //$varTable = TABLE_WHOLESALER .' LEFT JOIN '.TABLE_COUNTRY.' ON CompanyCountry=country_id LEFT JOIN '.TABLE_REGION.' ON CompanyRegion = pkRegionID';
        $arrRow = $this->select(TABLE_CUSTOMER, $arrClms, $varWhr);
        //pre($arrRow);
        return $arrRow;
    }

    /**
     * function updateCustomer
     *
     * This function is used to update the Customer.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return 1
     *
     * User instruction: $objCustomer->updateCustomer($arrPost)
     */
    function updateCustomer($arrPost) {
        $varNum = $this->CountCustomerEmail(" AND CustomerEmail = '" . $arrPost['frmEmail'] . "' AND pkCustomerID!=" . $_GET['id']);
        $changedPassword = "";
        if ($arrPost['frmPassword'] != $arrPost['frmPassword']) {
            return 'password_not_match';
        } else if ($varNum == '0') {
            $varWhr = 'pkCustomerID = ' . $_GET['id'];

            if ($arrPost['frmPassword'] == ADMIN_XXX || $arrPost['frmPassword'] == '') {
                $varPassword = $arrPost['frmOldPassword'];
            } else {
                $varPassword = md5(trim($arrPost['frmPassword']));
                $changedPassword = $arrPost['frmPassword'];
            }

            $varEmail = ($arrPost['frmEmail'] == $arrPost['frmOldEmail']) ? $arrPost['frmOldEmail'] : $arrPost['frmEmail'];

            $varBillBusinessAdd = ($arrPost['BillingBsinessAddress'] == '1') ? 'Billing' : '';

            $varShipBusinessAdd = ($arrPost['ShippingBsinessAddress'] == '1') ? 'Shipping' : '';

            $varBusinessAddress1 = ($varBillBusinessAdd != "") ? $varBillBusinessAdd : $varShipBusinessAdd;

            $varBusinessAddress = ($varBusinessAddress1 != "") ? $varBusinessAddress1 : 'Billing';

            $arrClms = array(
                'CustomerFirstName' => $arrPost['CustomerFirstName'],
                'CustomerLastName' => $arrPost['CustomerLastName'],
                'CustomerEmail' => $varEmail,
                'CustomerPassword' => $varPassword,
                'BillingFirstName' => $arrPost['BillingFirstName'],
                'BillingLastName' => $arrPost['BillingLastName'],
                'BillingOrganizationName' => $arrPost['BillingOrganizationName'],
                'BillingAddressLine1' => $arrPost['BillingAddressLine1'],
                'BillingAddressLine2' => $arrPost['BillingAddressLine2'],
                'BillingCountry' => $arrPost['BillingCountry'],
                'BillingState' => $arrPost['BillingState'],
                'BillingCity' => $arrPost['BillingCity'],
                'BillingPostalCode' => $arrPost['BillingPostalCode'],
                'BillingPhone' => $arrPost['BillingPhone'],
                'ShippingFirstName' => $arrPost['ShippingFirstName'],
                'ShippingLastName' => $arrPost['ShippingLastName'],
                'ShippingOrganizationName' => $arrPost['ShippingOrganizationName'],
                'ShippingAddressLine1' => $arrPost['ShippingAddressLine1'],
                'ShippingAddressLine2' => $arrPost['ShippingAddressLine2'],
                'ShippingCountry' => $arrPost['ShippingCountry'],
                'ShippingState' => $arrPost['ShippingState'],
                'ShippingCity' => $arrPost['ShippingCity'],
                'ShippingPostalCode' => $arrPost['ShippingPostalCode'],
                'ShippingPhone' => $arrPost['ShippingPhone'],
                'ResAddressLine1' => trim($arrPost['frmResAddressLine1']),
                'ResAddressLine2' => trim($arrPost['frmResAddressLine2']),
                'ResCountry' => trim($arrPost['frmResCountry']),
                'ResState' => trim($arrPost['frmResState']),
                'ResCity' => trim($arrPost['frmResCity']),
                'ResPostalCode' => trim($arrPost['ResPostalCode']),
                'ResTown' => trim($arrPost['frmResTown']),
                'ResPhone' => trim($arrPost['frmResPhone']),
                'ShippingTown' => trim($arrPost['frmShippingTown']),
                'BillingTown' => trim($arrPost['frmBillingTown']),
                'BusinessAddress' => $varBusinessAddress
            );

            $arrUpdateID = $this->update(TABLE_CUSTOMER, $arrClms, $varWhr);

            if ($arrUpdateID > 0) {
                $objTemplate = new EmailTemplate();
                $objCore = new Core();

                $varUserName = trim(strip_tags($arrPost['frmEmail']));
                if (($arrPost['frmEmail'] == $arrPost['frmOldEmail'])) {
                    $varPassword = 'Please use your Previous Password.';
                } else {
                    $varPassword = 'Password: ' . trim(strip_tags($arrPost['frmPassword']));
                }

                $varToUser = $varUserName;

                $varFromUser = $_SESSION['sessAdminEmail'];

                $varSiteName = SITE_NAME;

                $varWhereTemplate = " EmailTemplateTitle= 'customerChangeAccountByAdmin' AND EmailTemplateStatus = 'Active' ";

                $arrMailTemplate = $objTemplate->getTemplateInfo($varWhereTemplate);

                $varOutput = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateDescription']));

                $varSubject = html_entity_decode(stripcslashes($arrMailTemplate[0]['EmailTemplateSubject']));

                $varPathImage = '';
                $varPathImage = '<img src="' . SITE_ROOT_URL . 'common/images/logo.png" >';

                $varSubject = str_replace('{SITE_NAME}', SITE_NAME, html_entity_decode(stripcslashes($arrMailTemplate['0']['EmailTemplateSubject'])));

                $varMessage = 'Your account has been edited by admin.';

                if (!empty($changedPassword)) {
                    $varMessage .= "<br />Your Password has been updated. Below are your login details to access your account. Please keep this information safe for future references. <br />
                    <br />Username/Email : " . $varEmail . "
                    <br />Password : " . $changedPassword;
                }
                $varKeyword = array('{IMAGE_PATH}', '{WHOLESALER}', '{SITE_NAME}', '{USER_NAME}', '{PASSWORD}', '{MESSAGE}', '{STATUS}');

                $varKeywordValues = array($varPathImage, $arrPost['CustomerFirstName'] . " " . $arrPost['CustomerLastName'], SITE_NAME, $varUserName, $varPassword, $varMessage, $arrPost['frmStatus']);

                $varOutPutValues = str_replace($varKeyword, $varKeywordValues, $varOutput);

                // Calling mail function
                $objCore->sendMail($varToUser, $varFromUser, $varSubject, $varOutPutValues);
            }

            return 1;
        } else {
            return 'email_exists';
        }
    }

    /**
     * function UpdateCustomerStatus
     *
     * This function is used to update the Customer Status.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrUpdateID
     *
     * User instruction: $objCustomer->UpdateCustomerStatus($argVal, $varWhr) 
     */
    function UpdateCustomerStatus($argVal, $varWhr) {

        $varWhr = "pkCustomerID ='" . $varWhr . "' ";
        $arrClms = array('CustomerStatus' => $argVal);
        $arrUpdateID = $this->update(TABLE_CUSTOMER, $arrClms, $varWhr);
        return $arrUpdateID;
    }

    /**
     * function removeCustomer
     *
     * This function is used to remove the Customer.
     *
     * Database Tables used in this function are : tbl_customer, tbl_wishlist
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objCustomer->removeCustomer($argPostIDs)
     */
    function removeCustomer($argPostIDs) {
        $varWhere = "pkCustomerID = '" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_CUSTOMER, $varWhere);

        $varWhere = "fkUserId = '" . $argPostIDs['frmID'] . "'";
        $this->delete(TABLE_WISHLIST, $varWhere);
        return true;
    }

    /**
     * function removeAllCustomer
     *
     * This function is used to remove all Customer.
     *
     * Database Tables used in this function are : tbl_customer, tbl_wishlist
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objCustomer->removeAllCustomer($argArrPOST) 
     */
    function removeAllCustomer($argArrPOST) {
        $objCore = new Core();
        foreach ($argArrPOST['frmID'] as $varDeleteUsersID) {
            $varWhere = "pkCustomerID = '" . $varDeleteUsersID . "'";
            $this->delete(TABLE_CUSTOMER, $varWhere);

            $varWhere = "fkUserId = '" . $varDeleteUsersID . "'";
            $this->delete(TABLE_WISHLIST, $varWhere);
        }

        $objCore->setSuccessMsg(ADMIN_USER_DELETE_MESSAGE);

        return true;
    }

    /**
     * function customerFeedbackList
     *
     * This function is used to display customer Feedback List.
     *
     * Database Tables used in this function are : tbl_wholesaler_warning, tbl_wholesaler_feedback, tbl_wholesaler
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objCustomer->customerFeedbackList($argWhere = '', $argLimit = '') 
     */
    function customerFeedbackList($argWhere = '', $argLimit = '') {
        if ($argLimit != "") {
            $limit = "limit " . $argLimit . " ";
        } else {
            $limit = "";
        }

        $varWhr = "WHERE " . $argWhere;


        $varOrderBy = 'pkFeedbackID DESC ';
        $varQuery = "SELECT pkFeedbackID, fkWholesalerID, fkCustomerID,FeedbackDateAdded,CompanyName,CompanyEmail,
       WholesalerStatus, SUM(fkCustomerID) as numCustomer,SUM(IsPositive) as numGain, (SELECT count(`pkWarningID`) 
       FROM " . TABLE_WHOLESALER_WARNING . " as warn WHERE warn.fkWholesalerID = feed.fkWholesalerID 
       group by warn.fkWholesalerID) as numWarn FROM " . TABLE_WHOLESALER_FEEDBACK . " as feed left join  "
                . TABLE_WHOLESALER . " on fkWholesalerID=pkWholesalerID " . $varWhr . " group by fkWholesalerID order 
       	by FeedbackDateAdded DESC " . $limit . " ";
        $arrRes = $this->getArrayResult($varQuery);
        return $arrRes;
    }

    /**
     * function productDetailsFeedback
     *
     * This function is used to display product Details Feedback.
     *
     * Database Tables used in this function are : tbl_wholesaler_feedback, tbl_product, tbl_customer
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objCustomer->productDetailsFeedback($argWhere = '', $argLimit = '')
     */
    function productDetailsFeedback($argWhere = '', $argLimit = '') {
        if ($argLimit != "") {
            $limit = "limit " . $argLimit . " ";
        } else {
            $limit = "";
        }
        $varWhere = "WHERE " . $argWhere . "";
        $varQuery = "SELECT pkFeedbackID,pkProductID,ProductName,CustomerFirstName,FeedbackDateAdded,Question1,Question2,Question3,Comment FROM " . TABLE_WHOLESALER_FEEDBACK . " as wf left join " . TABLE_PRODUCT . " on fkProductID=pkProductID left join " . TABLE_CUSTOMER . " on fkCustomerID=pkCustomerID " . $varWhere . " order by FeedbackDateAdded DESC " . $limit . " ";
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function wholesalerPerformance
     *
     * This function is used to display wholesaler Performance.
     *
     * Database Tables used in this function are : tbl_wholesaler_feedback, tbl_product, tbl_customer
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objCustomer->wholesalerPerformance($argWhere = '', $argLimit = '')
     */
    function wholesalerPerformance($argWhere = '', $argLimit = '') {
        $varWhere = "WHERE " . $argWhere;
        $varQuery = "SELECT SUM(Question1) as numQuestion1, SUM(Question2) as numQuestion2, SUM(Question3) as numQuestion3 FROM " . TABLE_WHOLESALER_FEEDBACK . " as wf left join " . TABLE_PRODUCT . " on fkProductID=pkProductID left join " . TABLE_CUSTOMER . " on fkCustomerID=pkCustomerID " . $varWhere . " ";
        $arrRes = $this->getArrayResult($varQuery);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getSortColumn
     *
     * This function is used to sort column.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $varStrLnkSrtClmn
     *
     * User instruction: $objCustomer->getSortColumn($argVarSortOrder)
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
            $varSortBy = 'pkCustomerID';
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
        $objOrder->addColumn('Customer ID', 'pkCustomerID', '', 'hidden-480');
        /* Columns are added by Krishna Gupta (07-10-15) */
        $objOrder->addColumn('First Name', 'CustomerFirstName');
        $objOrder->addColumn('Last Name', 'CustomerLastName');
        /* Columns are added by Krishna Gupta (07-10-15) end */
        $objOrder->addColumn('Date Registered', 'CustomerDateAdded', '', 'hidden-480');
        $objOrder->addColumn('Email Address', 'CustomerEmail', '', 'hidden-1024');
        $objOrder->addColumn('Phone', 'BillingPhone', '', 'hidden-1024');
        $objOrder->addColumn('Reward Points', 'BalancedRewardPoints', '', 'hidden-1024');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function getWishlistProducts
     *
     * This function is used display error or message in box.
     *
     * Database Tables used in this function are : tbl_product, tbl_wishlist
     *
     * @access public
     *
     * @parameters 2 string 
     *
     * @return string $arrRes
     */
    function getWishlistProducts($cid, $limit) {
        $arrClms = array('pkWishlistId', 'fkProductId', 'ProductRefNo', 'WishlistDateAdded', 'ProductName', 'FinalPrice', 'DiscountFinalPrice');
        $argWhere = "fkUserId='" . $cid . "' ";
        $varTable = "" . TABLE_WISHLIST . " LEFT JOIN " . TABLE_PRODUCT . " ON fkProductId = pkProductID";
        $varOrderBy = " pkWishlistId DESC ";
        $arrRes = $this->select($varTable, $arrClms, $argWhere, $varOrderBy, $limit);


        return $arrRes;
    }

    /**
     * function customerCartDetails
     *
     * This function is used display cart items of customer.
     *
     * Database Tables used in this function are : tbl_cart
     *
     * @access public
     *
     * @parameters 1 int 
     *
     * @return string $arrRes
     */
    function customerCartDetails($CustomerID) {
        $varWhere = "1 AND fkCustomerID ='" . $CustomerID . "'";
        $varArrayColoum = array('CartDetails', 'CartDateAdded');
        $arrRes = $this->select(TABLE_CART, $varArrayColoum, $varWhere);
        return $arrRes;
    }

    /**
     * function rewardList
     *
     * This function is used to display the reward List.
     *
     * Database Tables used in this function are : tbl_reward_point
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objCustomer->rewardList($argWhere = '', $argLimit = '')
     */
    function rewardList($argWhere = '', $argLimit = '') {
        $arrClms = array(
            'pkRewardPointID',
            'fkCustomerID',
            'TransactionType',
            'Description',
            'Points',
            'RewardDateAdded'
        );

        $this->getRewardSortColumn($_REQUEST);

        $arrRes = $this->select(TABLE_REWARD_POINT, $arrClms, $argWhere, $this->orderOptions, $argLimit);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function getRewardSortColumn
     *
     * This function is used to sort column.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return $varStrLnkSrtClmn
     *
     * User instruction: $objCustomer->getRewardSortColumn($argVarSortOrder)
     */
    function getRewardSortColumn($argVarSortOrder) {

        $objCore = new Core();
        //Default order by setting
        if ($argVarSortOrder['orderBy'] == '') {
            $varOrderBy = 'DESC';
        } else {
            $varOrderBy = $argVarSortOrder['orderBy'];
        }
        //Default sort by setting
        if ($argVarSortOrder['sortBy'] == '') {
            $varSortBy = 'pkRewardPointID';
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
        $objOrder->addColumn('Reward Points', 'Points');
        $objOrder->addColumn('Transaction Type', 'TransactionType');
        $objOrder->addColumn('Reward Task', 'RewardTask', '', 'hidden-480');
        $objOrder->addColumn('RewardDateAdded', 'RewardDateAdded', '', 'hidden-1024');
        $this->orderOptions = $objOrder->orderOptions();

        //This string column name with  link.
        $varStrLnkSrtClmn = $objOrder->orderBlock();
        return $varStrLnkSrtClmn;
    }

    /**
     * function customerAllList
     *
     * This function is used to display the customer List.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return $arrRes
     *
     * User instruction: $objCustomer->customerAllList()
     */
    function customerAllList() {
        $arrClms = array(
            'pkCustomerID',
            'CustomerFirstName',
            'CustomerLastName',
            'CustomerEmail'
        );
        $varOrderBy = " CustomerFirstName ASC ";
        $arrRes = $this->select(TABLE_CUSTOMER, $arrClms, '', $varOrderBy);
        foreach ($arrRes as $k => $v) {
            $arrRow[$v['pkCustomerID']] = $v;
        }

        return $arrRow;
    }

    /**
     * function removeRewards
     *
     * This function is used to remove the reward.
     *
     * Database Tables used in this function are : tbl_reward_point
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return true
     *
     * User instruction: $objCustomer->removeRewards($argPostIDs)
     */
    function removeRewards($argPostIDs) {
        global $objGeneral;

        $cid = $objGeneral->getCustomerByRewardId($argPostIDs['id']);

        $varWhere = "pkRewardPointID = '" . $argPostIDs['id'] . "'";
        $this->delete(TABLE_REWARD_POINT, $varWhere);
        $objGeneral->updateCustomerRewards($argPostIDs['id'], $cid);

        return true;
    }

    /**
     * function removeAllRewards
     *
     * This function is used to remove all Customer.
     *
     * Database Tables used in this function are : tbl_reward_point
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return true
     *
     * User instruction: $objCustomer->removeAllRewards($argArrPOST) 
     */
    function removeAllRewards($argArrPOST) {
        global $objGeneral;

        foreach ($argArrPOST['frmID'] as $varDeleteUsersID) {

            $cid = $objGeneral->getCustomerByRewardId($varDeleteUsersID);

            $varWhere = "pkRewardPointID = '" . $varDeleteUsersID . "'";
            $this->delete(TABLE_REWARD_POINT, $varWhere);

            $objGeneral->updateCustomerRewards($argPostIDs['id'], $cid);
        }
        return true;
    }

    /**
     * function totalReward
     *
     * This function is used to get all total number of orders.
     *
     * Database Tables used in this function are : tbl_reward_point
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return true
     *
     * User instruction: $objCustomer->totalReward($cid) 
     */
    function totalReward($cid = 0) {

        $arrCulm = array('sum(Points) as point');
        $table = TABLE_REWARD_POINT;
        $whr = "fkCustomerID='" . (int) $cid . "'";

        $getPoint = $this->select($table, $arrCulm, $whr);
        //echo '<pre>'; print_r($getPoint); die;
        return $getPoint;
    }

    function totalReward1($cid = 0) {

        $arrCulm = array('BalancedRewardPoints');
        $table = TABLE_CUSTOMER;
        $whr = "pkCustomerID='" . (int) $cid . "'";

        $getPoint = $this->select($table, $arrCulm, $whr);
        //echo '<pre>'; print_r($getPoint); die;
        return $getPoint;
    }

    /**
     * function totalPurchase
     *
     * This function is used to get all total number of orders.
     *
     * Database Tables used in this function are : tbl_order
     *
     * @access public
     *
     * @parameters 1 array
     *
     * @return true
     *
     * User instruction: $objCustomer->totalPurchase($cid) 
     */
    function totalPurchase($cid = 0) {

//         $query = "SELECT * FROM tbl_order as o
//         INNER JOIN tbl_order_items as oi
//         ON (o.pkOrderID = oi.fkOrderID AND o.fkCustomerID = '$cid' )
//         GROUP BY o.pkOrderID ";
// //pre($query);
//         $order=$this->getArrayResult($query);
//         return count($order);
        //  return  $order;

        $arrCulm = array('count(pkOrderID) as customerorder');
        $table = TABLE_ORDER;
        $whr = "fkCustomerID='" . (int) $cid . "'";
        $getPurchase = $this->select($table, $arrCulm, $whr);
        //pre($getPurchase);
        //echo '<pre>'; print_r($getPurchase); die;
        return $getPurchase;
    }

}

?>
