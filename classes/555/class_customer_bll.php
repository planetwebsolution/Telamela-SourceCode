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
class customer extends Database
{

    /**
     * function __construct
     *
     * Constructor of the class, will be called in PHP5
     *
     * @access public
     *
     */
    function __construct()
    {

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
    function shippingGatewayList()
    {
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
    function countryList()
    {
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
    function regionList($where = '')
    {
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
    function CountCustomerEmail($argWhere = '')
    {
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
    function adminUserList()
    {
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
     * User instruction: $objCustomer->customerList($arg